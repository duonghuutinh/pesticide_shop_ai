<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property session $session
 * @property config $config
 * @property form_validation $form_validation
 * @property input $input
 * @property load $load
 * @property model $model
 * @property WarehouseModel $WarehouseModel
 * @property IndexModel $IndexModel
 * @property ProductModel $ProductModel
 * @property pagination $pagination
 * @property uri $uri
 * @property pagination $pagination
 * @property BrandModel $BrandModel
 * @property CategoryModel $CategoryModel
 * @property upload $upload
 * @property RevenueModel $RevenueModel
 * @property OrderModel $OrderModel
 * @property CustomerModel $CustomerModel
 * 
 */


class dashboardController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->checkLogin();
    }


    private function checkLogin()
    {
        if (!$this->session->userdata('logged_in_admin')) {
            $this->session->set_flashdata('error', 'Bạn cần đăng nhập với tài khoản quản trị để sử dụng chức năng này.');
            redirect(base_url('dang-nhap'));
        }
    }
    public function logout()
    {
        if (!empty($this->session->userdata('logged_in_admin'))) {
            $this->session->unset_userdata('logged_in_admin');
        }

        $this->session->set_flashdata('success', 'Đăng xuất Admin thành công');
        redirect(base_url('/'));
    }
    public function checkSessions()
    {
        if (!empty($this->session->userdata('logged_in_admin'))) {
            echo "admin";
        }
    }

    public function getUserOnSession()
    {
        $this->checkLogin();

        if ($this->session->userdata('logged_in_admin')) {
            return $this->session->userdata('logged_in_admin');
        }

        return null;
    }


    public function profile_user()
    {

        $this->config->config['pageTitle'] = 'Chỉnh sửa thông tin';
        $user_id = $this->getUserOnSession();


        if ($user_id) {
            $this->load->model('CustomerModel');
            $profile_user = $this->CustomerModel->selectCustomerById($user_id['id']);

            if ($profile_user) {
                // echo $profile_user->id;
                $this->load->view('pages/customer/profile_Customer', ['profile_user' => $profile_user]);
            } else {
                echo 'Không tìm thấy thông tin người dùng';
            }
        } else {
            echo 'Không tìm thấy ID người dùng trong session';
        }
    }



    public function index()
    {

        $this->config->config['pageTitle'] = 'Dashboard';

        // Load model
        $this->load->model('RevenueModel');
        $currentYear = Carbon\Carbon::now()->year;
        $startMonth = Carbon\Carbon::create($currentYear, 1, 1)->format('Y-m');
        $endMonth = Carbon\Carbon::create($currentYear, 12, 1)->format('Y-m');
        $data['profits'] = $this->RevenueModel->getProfitByMonthRange($startMonth, $endMonth);
        $data['timeType'] = 'month';
        $data['todayRevenue'] = $this->RevenueModel->getTodayRevenue();
        $data['todayProfit'] = $this->RevenueModel->getTodayProfit();
        $data['todayNewOrders'] = $this->RevenueModel->getTodayNewOrders();
        $data['todayNewUsers'] = $this->RevenueModel->getTodayNewUsers();

        
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';


        // Load view
        $data['template'] = "dashboard/adminHomePage";
        $this->load->view("admin-layout/admin-layout", $data);
    }

    public function discount_code_list($page = 1)
    {
        $this->config->config['pageTitle'] = 'List Discount';
        $this->load->model('OrderModel');
        $this->load->helper('pagination');

        $keyword  = $this->input->get('keyword', true);
        $status = $this->input->get('status', true);
        $status = ($status === '' || $status === null) ? null : (int) $status;

        $date_from = $this->input->get('date_from', true);
        $date_to = $this->input->get('date_to', true);

        $discount_type = $this->input->get('Discount_type', true);

        $perpage  = (int) $this->input->get('perpage');
        $perpage  = $perpage > 0 ? $perpage : 5;

        // Tạo filter array
        $filter = [
            'keyword'   => $keyword,
            'status'    => $status,
            'discount_type' => $discount_type,
            'date_from' => $date_from,
            'date_to'   => $date_to
        ];

        // Tính tổng số bản ghi theo filter
        $total = $this->OrderModel->countDiscountCode($filter);

        $page = (int) $page;
        $page = $page > 0 ? $page : 1;
        $max_page = ceil($total / $perpage);

        if ($page > $max_page && $total > 0) {
            $query = http_build_query($this->input->get());
            redirect(base_url('discount-code/list') . ($query ? '?' . $query : ''));
        }

        $start = ($page - 1) * $perpage;

        // Lấy danh sách mã giảm giá theo filter
        $data['DiscountCodes'] = $this->OrderModel->selectDiscountCode($filter, $perpage, $start);
        $data['discountSummary'] = $this->OrderModel->getDiscountSummaryByType();




        $data['links'] = init_pagination(base_url('discount-code/list'), $total, $perpage, 3);

        $data['status']     = $status;
        $data['keyword']    = $keyword;
        $data['perpage']    = $perpage;
        $data['start']      = $start;
        $data['title']      = "Danh sách mã giảm giá";
        $data['breadcrumb'] = [
            ['label' => 'Dashboard', 'url' => 'dashboard'],
            ['label' => 'Danh sách mã giảm giá']
        ];
        $data['template'] = "discount/index";

        $this->load->view("admin-layout/admin-layout", $data);
    }




    // public function discount_code_list($page = 1)
    // {
    //     $this->config->config['pageTitle'] = 'List Discount';
    //     $this->load->model('OrderModel');
    //     $this->load->helper('pagination');

    //     $keyword  = $this->input->get('keyword', true);
    //     $status = $this->input->get('status', true);
    //     $status = ($status === '' || $status === null) ? null : (int) $status;


    //     $perpage  = (int) $this->input->get('perpage');
    //     $perpage  = $perpage > 0 ? $perpage : 5;

    //     $total = $this->OrderModel->countDiscountCode($keyword, $status);

    //     $page = (int) $page;
    //     $page = $page > 0 ? $page : 1;
    //     $max_page = ceil($total / $perpage);

    //     if ($page > $max_page && $total > 0) {
    //         $query = http_build_query($this->input->get());
    //         redirect(base_url('discount-code/list') . ($query ? '?' . $query : ''));
    //     }

    //     $start = ($page - 1) * $perpage;

    //     $data['DiscountCodes'] = $this->OrderModel->selectDiscountCode($keyword, $status, $perpage, $start);
    //     $data['discountSummary'] = $this->OrderModel->getDiscountSummaryByType();


    //     $data['links'] = init_pagination(base_url('discount-code/list'), $total, $perpage, 3);

    //     $data['status']     = $status;
    //     $data['keyword']    = $keyword;
    //     $data['perpage']    = $perpage;
    //     $data['start']      = $start;
    //     $data['title']      = "Danh sách mã giảm giá";
    //     $data['breadcrumb'] = [
    //         ['label' => 'Dashboard', 'url' => 'dashboard'],
    //         ['label' => 'Danh sách mã giảm giá']
    //     ];
    //     $data['template'] = "discount/index";

    //     $this->load->view("admin-layout/admin-layout", $data);
    // }

    // public function bulkUpdate()
    // {
    //     $discountIDs = $this->input->post('discount_ids');
    //     $newStatus   = $this->input->post('new_status');

    //     if (!is_array($discountIDs) || !in_array($newStatus, ['0', '1'])) {
    //         $this->session->set_flashdata('error', 'Dữ liệu không hợp lệ.');
    //         redirect($_SERVER['HTTP_REFERER']);
    //     }

    //     $this->db->where_in('DiscountID', $discountIDs);
    //     $this->db->update('discount', ['Status' => (int)$newStatus]);

    //     $this->session->set_flashdata('success', 'Cập nhật trạng thái thành công.');
    //     redirect($_SERVER['HTTP_REFERER']);
    // }






    // public function createDiscountCode()
    // {
    //     $this->config->config['pageTitle'] = 'Create Discount';
    //     // $this->load->model('OrderModel');
    //     $data['errors'] = $this->session->flashdata('errors');
    //     $data['input'] = $this->session->flashdata('input');
    //     // $data['discount'] = $this->OrderModel->selectDiscount();
    //     $data['title'] = "Thêm mới mã giảm giá";
    //     $data['breadcrumb'] = [
    //         ['label' => 'Dashboard', 'url' => 'dashboard'],
    //         ['label' => 'Thêm mới mã giảm giá']
    //     ];
    //     $data['template'] = "discount/storeDiscountCode";
    //     $this->load->view("admin-layout/admin-layout", $data);
    // }


    public function createDiscountCode()
    {
        $this->config->config['pageTitle'] = 'Create Discount';

        $data['errors'] = $this->session->flashdata('errors');
        $data['input'] = $this->session->flashdata('input');

        // echo '<pre>';
        // print_r($data['errors']);
        // echo '</pre>';

        // Cấu hình thông tin cho view
        $data['title'] = "Thêm mới mã giảm giá";
        $data['breadcrumb'] = [
            ['label' => 'Dashboard', 'url' => 'dashboard'],
            ['label' => 'Thêm mới mã giảm giá']
        ];
        $data['template'] = "discount/storeDiscountCode";

        // Hiển thị view với thông tin lỗi và dữ liệu input
        $this->load->view("admin-layout/admin-layout", $data);
    }


    public function updateDiscountCodes($DiscountID)
    {
        $this->load->model('OrderModel');

        $this->form_validation->set_rules('Coupon_code', 'mã nhập', 'trim|required', ['required' => 'Bạn cần điền %s']);
        $this->form_validation->set_rules('Discount_type', 'Discount_type', 'trim|required', ['required' => 'Bạn cần chọn kiểu mã giảm giá']);
        $this->form_validation->set_rules('Discount_value', 'giá trị mã giảm giá', 'trim|required', ['required' => 'Bạn cần điền %s']);
        $this->form_validation->set_rules('Min_order_value', 'giá trị tối thiểu của đơn hàng', 'trim|required', ['required' => 'Bạn cần điền %s']);
        $this->form_validation->set_rules('Start_date', 'ngày bắt đầu hiệu lực', 'trim|required', ['required' => 'Bạn cần điền %s']);
        $this->form_validation->set_rules('End_date', 'ngày hết hạn của mã giảm giá', 'trim|required', ['required' => 'Bạn cần điền %s']);

        if ($this->input->post('Discount_type') == 'Percentage') {
            $this->form_validation->set_rules('Discount_value', 'giá trị mã giảm giá', 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]', [
                'required' => 'Bạn cần điền %s',
                'numeric' => 'Giá trị %s phải là số',
                'greater_than_equal_to' => 'Giá trị %s phải lớn hơn hoặc bằng 0',
                'less_than_equal_to' => 'Giá trị %s phải nhỏ hơn hoặc bằng 100'
            ]);
        }

        if (!$this->form_validation->run()) {
            $data['errors'] = validation_errors();
            return $this->discount_code_edit($DiscountID, $data);
        }

        // Nếu không có lỗi, tiếp tục xử lý như bình thường
        $old_data = $this->OrderModel->selectDiscountById($DiscountID);
        $new_data = [
            'Coupon_code' => $this->input->post('Coupon_code'),
            'Discount_type' => $this->input->post('Discount_type'),
            'Discount_value' => $this->input->post('Discount_value'),
            'Min_order_value' => $this->input->post('Min_order_value'),
            'Start_date' => $this->input->post('Start_date'),
            'End_date' => $this->input->post('End_date'),
            'Status' => $this->input->post('Status')
        ];

        if ($this->_is_same_data($old_data, $new_data)) {
            $this->session->set_flashdata('info', 'Không có thay đổi nào để lưu.');
            return $this->discount_code_edit($DiscountID);
        } else {
            $result = $this->OrderModel->updateDiscountCode($DiscountID, $new_data);
            if ($result) {
                $this->session->set_flashdata('success', 'Đã chỉnh sửa mã giảm giá thành công.');
            } else {
                $this->session->set_flashdata('error', 'Có lỗi xảy ra khi cập nhật.');
            }
        }

        redirect(base_url('discount-code/list'));
    }


    public function storageDiscountCode()
    {

        $this->load->model('OrderModel');


        $this->form_validation->set_rules('Discount_type', 'Discount_type', 'trim|required', ['required' => 'Bạn cần chọn kiểu mã giảm giá']);
        $this->form_validation->set_rules('Discount_value', 'giá trị mã giảm giá', 'trim|required', ['required' => 'Bạn cần điền %s']);
        $this->form_validation->set_rules('Min_order_value', 'giá trị tối thiểu của đơn hàng', 'trim|required', ['required' => 'Bạn cần điền %s']);
        $this->form_validation->set_rules('Start_date', 'ngày bắt đầu hiệu lực', 'trim|required', ['required' => 'Bạn cần điền %s']);
        $this->form_validation->set_rules('End_date', 'ngày hết hạn của mã giảm giá', 'trim|required', ['required' => 'Bạn cần điền %s']);
        $this->form_validation->set_rules('Number_of_discount_codes', 'số lượng mã giảm giá', 'trim|required', ['required' => 'Bạn cần điền %s']);


        if ($this->input->post('Discount_type') == 'Percentage') {
            $this->form_validation->set_rules('Discount_value', 'giá trị mã giảm giá', 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]', [
                'required' => 'Bạn cần điền %s',
                'numeric' => 'Giá trị %s phải là số',
                'greater_than_equal_to' => 'Giá trị %s phải lớn hơn hoặc bằng 0',
                'less_than_equal_to' => 'Giá trị %s phải nhỏ hơn hoặc bằng 100'
            ]);
        }

        if (!$this->form_validation->run()) {
            $data['errors'] = validation_errors();
            return $this->createDiscountCode($data);
        }

        if ($this->form_validation->run()) {
            $Number_of_discount_codes = (int)$this->input->post('Number_of_discount_codes');
            $data = [
                'Discount_type' => $this->input->post('Discount_type'),
                'Discount_value' => $this->input->post('Discount_value'),
                'Min_order_value' => $this->input->post('Min_order_value'),
                'Start_date' => $this->input->post('Start_date'),
                'End_date' => $this->input->post('End_date'),
                'Status' => $this->input->post('Status') ?? 1,
            ];

            // Thực hiện tạo mã giảm giá
            $this->load->model('OrderModel');
            $created = 0;
            for ($i = 0; $i < $Number_of_discount_codes; $i++) {
                do {
                    $code = $this->generate_discount_code();
                    $exists = $this->OrderModel->checkCouponCodeExists($code);
                } while ($exists);

                $data['Coupon_code'] = $code;
                $this->OrderModel->insertDiscountCode($data);
                $created++;
            }

            $this->session->set_flashdata('success', "Đã tạo thành công $created mã giảm giá.");
            redirect(base_url('discount-code/list'));
        }
    }


    private function generate_discount_code()
    {
        $letters = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
        $numbers = sprintf("%05d", rand(0, 999999));
        return $letters . $numbers;
    }


    public function discount_code_edit($DiscountID)
    {
        $this->config->config['pageTitle'] = 'Edit Brand';
        $this->load->model('OrderModel');
        $data['discount'] = $this->OrderModel->selectDiscountById($DiscountID);

        $data['title'] = "Chỉnh sửa mã giảm giá";
        $data['breadcrumb'] = [
            ['label' => 'Dashboard', 'url' => 'dashboard'],
            ['label' => 'Danh sách mã giảm giá', 'url' => 'discount-code/list'],
            ['label' => 'Chỉnh sửa mã giảm giá']
        ];
        $data['template'] = "discount/editDiscountCode";
        $this->load->view("admin-layout/admin-layout", $data);
    }

    private function _is_same_data($old, $new)
    {
        foreach ($new as $key => $val) {
            if (!isset($old->$key) || $old->$key != $val) {
                return false;
            }
        }
        return true;
    }

    public function updateDiscountCode($DiscountID)
    {
        $this->load->model('OrderModel');

        $this->form_validation->set_rules('Coupon_code', 'mã nhập', 'trim|required', ['required' => 'Bạn cần điền %s']);
        $this->form_validation->set_rules('Discount_type', 'Discount_type', 'trim|required', ['required' => 'Bạn cần chọn kiểu mã giảm giá']);
        $this->form_validation->set_rules('Discount_value', 'giá trị mã giảm giá', 'trim|required', ['required' => 'Bạn cần điền %s']);
        $this->form_validation->set_rules('Min_order_value', 'giá trị tối thiểu của đơn hàng', 'trim|required', ['required' => 'Bạn cần điền %s']);
        $this->form_validation->set_rules('Start_date', 'ngày bắt đầu hiệu lực', 'trim|required', ['required' => 'Bạn cần điền %s']);
        $this->form_validation->set_rules('End_date', 'ngày hết hạn của mã giảm giá', 'trim|required', ['required' => 'Bạn cần điền %s']);

        if ($this->input->post('Discount_type') == 'Percentage') {
            $this->form_validation->set_rules('Discount_value', 'giá trị mã giảm giá', 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]', [
                'required' => 'Bạn cần điền %s',
                'numeric' => 'Giá trị %s phải là số',
                'greater_than_equal_to' => 'Giá trị %s phải lớn hơn hoặc bằng 0',
                'less_than_equal_to' => 'Giá trị %s phải nhỏ hơn hoặc bằng 100'
            ]);
        }

        if (!$this->form_validation->run()) {
            $data['errors'] = validation_errors();
            return $this->discount_code_edit($DiscountID, $data);
        }

        // Nếu không có lỗi, tiếp tục xử lý như bình thường
        $old_data = $this->OrderModel->selectDiscountById($DiscountID);
        $new_data = [
            'Coupon_code' => $this->input->post('Coupon_code'),
            'Discount_type' => $this->input->post('Discount_type'),
            'Discount_value' => $this->input->post('Discount_value'),
            'Min_order_value' => $this->input->post('Min_order_value'),
            'Start_date' => $this->input->post('Start_date'),
            'End_date' => $this->input->post('End_date'),
            'Status' => $this->input->post('Status')
        ];

        if ($this->_is_same_data($old_data, $new_data)) {
            $this->session->set_flashdata('info', 'Không có thay đổi nào để lưu.');
            return $this->discount_code_edit($DiscountID);
        } else {
            $result = $this->OrderModel->updateDiscountCode($DiscountID, $new_data);
            if ($result) {
                $this->session->set_flashdata('success', 'Đã chỉnh sửa mã giảm giá thành công.');
            } else {
                $this->session->set_flashdata('error', 'Có lỗi xảy ra khi cập nhật.');
            }
        }

        redirect(base_url('discount-code/list'));
    }



    public function bulkUpdateDiscountCode()
    {
        $discount_code_ids = $this->input->post('discount_code_ids');
        $new_status = (int) $this->input->post('new_status');

        $this->load->model('OrderModel');
        $this->OrderModel->bulkupdateDiscount($discount_code_ids, $new_status);
    }




    public function deleteDiscountCode($DiscountID)
    {
        $this->load->model('OrderModel');
        $this->OrderModel->deleteDiscountCode($DiscountID);
        $this->session->set_flashdata('success', 'Xoá mã giảm giá thành công');
        redirect(base_url('discount-code/list'));
    }



    // public function list_comment()
    // {
    //     $this->config->config['pageTitle'] = 'List Comments';
    //     $this->load->model('IndexModel');
    //     $data['comments'] = $this->IndexModel->getAllComment();
    //     // echo '</pre>';
    //     // print_r($data['comments']);
    //     // echo '</pre>';
    //     $data["title"] = "Danh sách bình luận";
    //     $data['breadcrumb'] = [
    // 		['label' => 'Dashboard', 'url' => 'dashboard'],
    // 		['label' => 'Danh sách bình luận']
    // 	];
    //     $data["template"] = "comment/index";
    //     $this->load->view("admin-layout/admin-layout", $data);
    // }

    // public function deleteComment($cmt_id)
    // {
    //     $this->load->model('IndexModel');

    //     $del_comment_details = $this->IndexModel->deleteComment($cmt_id);
    //     if ($del_comment_details) {
    //         $this->session->set_flashdata('success', 'Xóa bình luận thành công');
    //         redirect(base_url('comment'));
    //     } else {
    //         $this->session->set_flashdata('error', 'Xóa bình luận thất bại');
    //         redirect(base_url('comment'));
    //     }
    // }

    // public function editComment($cmt_id)
    // {
    //     $this->config->config['pageTitle'] = 'Edit Customer';
    //     $this->load->model('IndexModel');
    //     $data['comments'] = $this->IndexModel->selectCommentById($cmt_id);
    //     $data["title"] = "Chỉnh sửa bình luận";
    //     $data['breadcrumb'] = [
    // 		['label' => 'Dashboard', 'url' => 'dashboard'],
    // 		['label' => 'Danh sách bình luận', 'url' => 'comment'],
    //         ['label' => 'Cập nhật trạng thái bình luận']
    // 	];
    //     $data["template"] = "comment/editComment";
    //     $this->load->view("admin-layout/admin-layout", $data);
    // }


    // public function updateComment($cmt_id)
    // {
    //     $data = [
    //         'comment' => $this->input->post('comment'),
    //         'status' => $this->input->post('status'),
    //     ];
    //     $this->load->model('IndexModel');
    //     $this->IndexModel->updateComment($cmt_id, $data);
    //     $this->session->set_flashdata('success', 'Đã chỉnh sửa bình luận thành công');
    //     redirect(base_url('comment'));
    // }
}
