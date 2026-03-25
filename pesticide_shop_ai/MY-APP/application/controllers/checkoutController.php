<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property session $session
 * @property config $config
 * @property form_validation $form_validation
 * @property input $input
 * @property load $load
 * @property model $model
 * @property warehouseModel $warehouseModel
 * @property indexModel $indexModel
 * @property productModel $productModel
 * @property pagination $pagination
 * @property uri $uri
 * @property pagination $pagination
 * @property brandModel $brandModel
 * @property categoryModel $categoryModel
 * @property upload $upload
 * @property data $data
 * @property email $email
 * @property cart $cart
 * @property orderModel $orderModel
 */

class CheckoutController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->load->model('indexModel');
        $this->load->library('cart');
        $this->data['brand'] = $this->indexModel->getBrandHome();
        $this->data['category'] = $this->indexModel->getCategoryHome();
    }
    public function checkLogin()
    {
        if (
            !$this->session->userdata('logged_in_customer') &&
            !$this->session->userdata('logged_in_admin')
        ) {
            $this->session->set_flashdata('error', 'Bạn cần đăng nhập để sử dụng chức năng này.');
            redirect(base_url('/dang-nhap'));
        }
    }

    public function getUserOnSession()
    {
        $this->checkLogin();


        if ($this->session->userdata('logged_in_admin')) {
            return $this->session->userdata('logged_in_admin');
        } elseif ($this->session->userdata('logged_in_customer')) {
            return $this->session->userdata('logged_in_customer');
        }

        return null;
    }


    public function send_mail($to_mail, $subject, $message)
    {

        $config = array();

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_user'] = 'hohuuthuan789@gmail.com';
        $config['smtp_pass'] = 'xvinihubnvdnmloz';
        $config['smtp_port'] = '465';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $from_mail = 'hohuuthuan789@gmail.com';

        $this->email->from($from_mail, 'Trang web abc.com');
        $this->email->to($to_mail);

        $this->email->subject($subject);
        $this->email->message($message);

        $this->email->send();
    }


    private function generate_order_code()
    {
        $letters = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
        $numbers = sprintf("%06d", rand(0, 999999));
        return $letters . $numbers;
    }

    private function get_shipping_data($user_id, $checkout_method)
    {
        return [
            'user_id' => $user_id,
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'address' => $this->input->post('address'),
            'checkout_method' => $checkout_method
        ];
    }

    private function calculate_total_cart()
    {
        $total = 0;
        foreach ($this->cart->contents() as $item) {
            $total += $item['qty'] * $item['price'];
        }

        $discount = $this->session->userdata('coupon_discount') ?? 0;

        return max(0, $total - $discount);
    }


    public function confirm_checkout_method()
    {
        $this->load->model('orderModel');
        $this->load->library('form_validation');

        // Validate input
        $this->form_validation->set_rules('name', 'Username', 'trim|required', ['required' => 'Bạn cần cung cấp %s']);
        $this->form_validation->set_rules('email', 'Email', 'trim|required', ['required' => 'Bạn cần cung cấp %s']);
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required', ['required' => 'Bạn cần cung cấp %s']);
        $this->form_validation->set_rules('address', 'Address', 'trim|required', ['required' => 'Bạn cần cung cấp %s']);

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', 'Vui lòng điền đầy đủ thông tin');
            return redirect(base_url('checkout'));
        }

        $user = $this->getUserOnSession();
        $checkout_method = $this->input->post('checkout_method');
        $order_code = $this->generate_order_code();

        $shipping_data = $this->get_shipping_data($user['id'], $checkout_method);
        $this->session->set_userdata("shipping_data_{$order_code}", $shipping_data);

        $total = $this->calculate_total_cart();

        if ($checkout_method === 'COD') {
            $this->process_cod_order($order_code, $shipping_data, $user['id'], $total);
            $this->send_mail($shipping_data['email'], 'Thông báo đặt hàng', 'Cảm ơn bạn đã đặt hàng, chúng tôi sẽ gửi đơn hàng đến bạn sớm nhất.');
            return redirect(base_url('thank-you-for-order'));
        }

        if ($checkout_method === 'VNPAY') {
            $this->redirect_to_vnpay($order_code, $total);
        }

        $this->session->set_flashdata('error', 'Vui lòng chọn phương thức thanh toán');
        redirect(base_url('checkout'));
    }




    private function process_cod_order($order_code, $shipping_data, $user_id, $total)
    {
        $ShippingID = $this->orderModel->newShipping($shipping_data);
        if (!$ShippingID) return;

        $this->session->unset_userdata("shipping_data_{$order_code}");


        $order_data = [
            'Order_code' => $order_code,
            'Order_Status' => -1,
            'Payment_Status' => 0,
            'UserID' => $user_id,
            'TotalAmount' => $total,
            'Date_Order' => Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString(),
            'ShippingID' => $ShippingID
        ];

        // Ghi nhận mã giảm giá nếu có
        $coupon_id = $this->session->userdata('coupon_id');



        $coupon_discount = $this->session->userdata('coupon_discount');
        $coupon_type = $this->session->userdata('coupon_type');
        $max_discount = $this->session->userdata('coupon_max');

        if ($coupon_id) {
            $order_data['DiscountID'] = $coupon_id;
        }

        $order_id = $this->orderModel->insert_order($order_data);

        // Lấy dữ liệu giỏ hàng
        $cart_items = $this->cart->contents();
        $subtotal = 0;

        foreach ($cart_items as $item) {
            $subtotal += $item['subtotal'];
        }

        // Tính tổng chiết khấu sẽ áp dụng
        $discount_applied = 0;
        if ($coupon_discount && $subtotal > 0) {
            if ($coupon_type == 'percent') {
                $discount_applied = round($subtotal * $coupon_discount / 100);
                if ($max_discount) {
                    $discount_applied = min($discount_applied, $max_discount);
                }
            } else {
                $discount_applied = $coupon_discount;
            }
        }

        // Phân bổ chiết khấu vào từng dòng sản phẩm
        $total_allocated = 0;
        $index = 0;
        $cart_count = count($cart_items);

        foreach ($cart_items as $item) {
            $index++;
            $line_total = $item['subtotal'];
            $ratio = $line_total / $subtotal;
            $discount_allocated = round($discount_applied * $ratio);


            if ($index == $cart_count) {
                $discount_allocated = $discount_applied - $total_allocated;
            }

            $total_allocated += $discount_allocated;

            // Lưu chi tiết đơn hàng
            $detail = [
                'Order_code' => $order_code,
                'ProductID' => $item['id'],
                'Quantity' => $item['qty'],
                'Selling_price' => $item['price'],
                'Subtotal' => $item['subtotal'],
                'discount_amount' => $discount_allocated
            ];
            $detail_id = $this->orderModel->insert_order_detail($detail);
        }

        if ($coupon_id) {
            $this->load->model('orderModel');
            $this->orderModel->markCouponAsUsed($coupon_id);
        }

        // Clear session sau khi đặt hàng
        $this->session->set_flashdata('success', 'Đặt hàng thành công');
        $this->session->unset_userdata('coupon_code');
        $this->session->unset_userdata('coupon_discount');
        $this->session->unset_userdata('coupon_type');
        $this->session->unset_userdata('coupon_max');
        $this->session->unset_userdata('coupon_id');

        $this->cart->destroy();
    }



    private function redirect_to_vnpay($order_code, $total)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = base_url('thank-you-for-order');
        $vnp_TmnCode = "F72UMWTL";
        $vnp_HashSecret = "696U98UTDBDDD09ZN1T0GAVR3KC4EVMU";

        $vnp_TxnRef = $order_code;
        $vnp_OrderInfo = 'Thanh toan don hang: ' . $order_code;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $total * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_BankCode" => $vnp_BankCode
        );

        // Sắp xếp key tăng dần
        ksort($inputData);

        $query = [];
        $hashdata = [];

        foreach ($inputData as $key => $value) {
            $hashdata[] = urlencode($key) . "=" . urlencode($value);
            $query[] = urlencode($key) . "=" . urlencode($value);
        }

        $hashdataStr = implode('&', $hashdata);
        $queryStr = implode('&', $query);

        $vnpSecureHash = hash_hmac('sha512', $hashdataStr, $vnp_HashSecret);
        $vnp_Url .= '?' . $queryStr . '&vnp_SecureHash=' . $vnpSecureHash;

        redirect($vnp_Url);
    }


    public function thank_you_for_order()
    {
        if (isset($_GET['vnp_Amount']) && $_GET['vnp_ResponseCode'] == 00) {


            $user_id = $this->getUserOnSession();
            $shipping_data_session = $this->session->userdata("shipping_data_{$_GET['vnp_TxnRef']}");


            $this->load->model('orderModel');
            $ShippingID = $this->orderModel->newShipping($shipping_data_session);



            if ($ShippingID) {
                if (!empty($this->session->userdata("shipping_data_{$_GET['vnp_TxnRef']}"))) {
                    $this->session->unset_userdata("shipping_data_{$_GET['vnp_TxnRef']}");
                }


                // $subtotal = 0;
                // $total = 0;
                // foreach ($this->cart->contents() as $item) {
                //     $subtotal = $item['qty'] * $item['price'];
                //     $total += $subtotal;
                // }



                $total_amount = $_GET['vnp_Amount'] / 100;

                $order_data = [
                    'Order_code' => $_GET['vnp_TxnRef'],
                    'Order_Status' => -1,
                    'Payment_Status' => 1,
                    'UserID' => $user_id['id'],
                    'TotalAmount' => $total_amount,
                    'Date_Order' => Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString(),
                    'ShippingID' => $ShippingID
                ];
                // Ghi nhận mã giảm giá nếu có
                $coupon_id = $this->session->userdata('coupon_id');
                $coupon_discount = $this->session->userdata('coupon_discount');
                $coupon_type = $this->session->userdata('coupon_type');
                $max_discount = $this->session->userdata('coupon_max');

                if ($coupon_id) {
                    $order_data['DiscountID'] = $coupon_id;
                }

                $order_id = $this->orderModel->insert_order($order_data);

                // Lấy dữ liệu giỏ hàng
                $cart_items = $this->cart->contents();
                $subtotal = 0;
                foreach ($this->cart->contents() as $item) {
                    $subtotal += $item['qty'] * $item['price'];
                }
                $total = $subtotal;

              


                // Tính tổng chiết khấu sẽ áp dụng
                $discount_applied = 0;
                if ($coupon_discount && $subtotal > 0) {
                    if ($coupon_type == 'percent') {
                        $discount_applied = round($subtotal * $coupon_discount / 100);
                        if ($max_discount) {
                            $discount_applied = min($discount_applied, $max_discount);
                        }
                    } else {
                        $discount_applied = $coupon_discount;
                    }
                }

                // Phân bổ chiết khấu vào từng dòng sản phẩm
                $total_allocated = 0;
                $index = 0;
                $cart_count = count($cart_items);

                foreach ($cart_items as $item) {
                    $index++;
                    $line_total = $item['subtotal'];
                    $ratio = $line_total / $subtotal;
                    $discount_allocated = round($discount_applied * $ratio);


                    if ($index == $cart_count) {
                        $discount_allocated = $discount_applied - $total_allocated;
                    }

                    $total_allocated += $discount_allocated;

                    // Lưu chi tiết đơn hàng
                    $detail = [
                        'Order_code' => $_GET['vnp_TxnRef'],
                        'ProductID' => $item['id'],
                        'Quantity' => $item['qty'],
                        'Selling_price' => $item['price'],
                        'Subtotal' => $item['subtotal'],
                        'discount_amount' => $discount_allocated
                    ];
                    $detail_id = $this->orderModel->insert_order_detail($detail);
                }
                
            }
            // Lưu thông tin thanh toán VNPAY
            $data_vnpay = [
                'ShippingID' => $ShippingID,
                'vnp_Amount' => $_GET['vnp_Amount'],
                'vnp_BankCode' => $_GET['vnp_BankCode'],
                'vnp_BankTranNo' => $_GET['vnp_BankTranNo'],
                'vnp_CardType' => $_GET['vnp_CardType'],
                'vnp_OrderInfo' => $_GET['vnp_OrderInfo'],
                'vnp_PayDate' =>  $_GET['vnp_PayDate'],
                'vnp_ResponseCode' => $_GET['vnp_ResponseCode'],
                'vnp_TmnCode' => $_GET['vnp_TmnCode'],
                'vnp_TransactionStatus' => $_GET['vnp_TransactionStatus'],
                'vnp_TxnRef' => $_GET['vnp_TxnRef'], // Lưu giá trị order_code
                'vnp_SecureHash' => $_GET['vnp_SecureHash']
            ];
            $this->load->model('indexModel');
            $this->indexModel->insert_VNPAY($data_vnpay);

            if ($coupon_id) {
                $this->load->model('orderModel');
                $this->orderModel->markCouponAsUsed($coupon_id);
            }
            // Clear session sau khi đặt hàng
            $this->session->set_flashdata('success', 'Đặt hàng thành công');
            $this->session->unset_userdata('coupon_code');
            $this->session->unset_userdata('coupon_discount');
            $this->session->unset_userdata('coupon_type');
            $this->session->unset_userdata('coupon_max');
            $this->session->unset_userdata('coupon_id');

            $this->cart->destroy();


            $to_mail = $user_id['email'];
            $subject = 'Thông báo đặt hàng';
            $message = 'Cảm ơn bạn đã đặt hàng, chúng tôi sẽ gửi đơn hàng đến bạn sớm nhất.';
            $this->send_mail($to_mail, $subject, $message);
            redirect(base_url('thank-you-for-order'));
            die();
        }


        $this->config->config['pageTitle'] = 'Cảm ơn bạn đã đặt hàng';
        $this->data['template'] = "thanks/index";
        $this->load->view("pages/layout/index", $this->data);
    }




    public function thank_you_for_payment()
    {
        $this->config->config['pageTitle'] = 'Cảm ơn bạn đã đặt hàng';
        $this->data['template'] = "thanks/index";
        $this->load->view("pages/layout/index", $this->data);
    }
}
