<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property session $session
 * @property config $config
 * @property form_validation $form_validation
 * @property input $input
 * @property load $load
 * @property data $data
 * @property indexModel $indexModel
 * @property pagination $pagination
 * @property uri $uri
 * @property sliderModel $sliderModel
 * @property email $email
 * @property cart $cart
 * @property orderModel $orderModel
 * @property productModel $productModel
 * @property page $page
 * @property customerModel $customerModel
 * @property loginModel $loginModel
 * @property upload $upload
 * @property db $db
 */

class orderController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		$this->checkLogin();
	}
	public function checkLogin()
	{
		if (!$this->session->userdata('logged_in_admin')) {
			redirect(base_url('dang_nhap'));
			die();
		}
	}


	public function index($page = 1)
	{
		$this->config->config['pageTitle'] = 'List Order';
		$this->load->model('orderModel');

		// --- Lấy filter từ GET ---
		$date_from = $this->input->get('date_from', TRUE);
		$date_to   = $this->input->get('date_to', TRUE);
		$keyword         = $this->input->get('keyword', TRUE);
		$status          = $this->input->get('status', TRUE);
		$checkout_method = $this->input->get('checkout_method', TRUE);
		$sort_order = $this->input->get('sort_order', TRUE);
		$sort_total_amount = $this->input->get('sort_total_amount', TRUE);
		$perpage         = (int)$this->input->get('perpage');
		$perpage         = ($perpage > 0) ? $perpage : 10;

		
		if (empty($sort_order)) {
			$sort_order = 'desc';
		}

		$filter = [
			'keyword'         => $keyword,
			'status'          => $status,
			'checkout_method' => $checkout_method,
			'date_from'       => $date_from,
			'date_to'         => $date_to,
			'sort_order'      => $sort_order,
			'sort_total_amount'	=> $sort_total_amount
		];

		$total = $this->orderModel->countOrder($filter);

		// --- Tính offset ---
		$page = (int)$page;
		$page = ($page > 0) ? $page : 1;
		$max_page = ceil($total / $perpage);

		if ($page > $max_page && $total > 0) {
			$query = http_build_query($this->input->get());
			redirect(base_url('order_admin/listOrder') . ($query ? '?' . $query : ''));
		}

		$start = ($page - 1) * $perpage;

		$data['order'] = $this->orderModel->selectOrder($perpage, $start, $filter);

		// echo '<pre>';
		// print_r($data['order']);
		// echo '</pre>';


		$data['links'] = init_pagination(base_url('order_admin/listOrder'), $total, $perpage, 3);

		$data['keyword']         = $keyword;
		$data['status']          = $status;
		$data['checkout_method'] = $checkout_method;
		$data['sort_order'] 	 = $sort_order;
		$data['perpage']         = $perpage;
		$data['start']           = $start;

		$data['title'] = "Danh sách đơn hàng";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Danh sách đơn hàng']
		];
		$data['start'] = $start;
		$data['date_from'] = $date_from;
		$data['date_to']   = $date_to;

		$data['template'] = "order_admin/index";
		$this->load->view("admin-layout/admin-layout", $data);
	}



	public function viewOrder($order_code)
	{
		$this->config->config['pageTitle'] = 'View Order';
		$this->load->model('orderModel');
		$data['order_details'] = $this->orderModel->selectOrderDetails($order_code);

		// echo '<pre>';
		// print_r($data['order_details']);
		// echo '</pre>';

		if (!empty($data['order_details'])) {

			foreach ($data['order_details'] as &$order_detail) {


				$order_detail->product_qty_in_batches = $this->orderModel->get_qty_product_in_batches($order_detail->ProductID, $order_detail->qty);
				// echo '<pre>';
				// print_r($order_detail->product_qty_in_batches);
				// echo '</pre>';

			}

			$data['title'] = "Chi tiết đơn hàng";
			$data['breadcrumb'] = [
				['label' => 'Dashboard', 'url' => 'dashboard'],
				['label' => 'Danh sách đơn hàng', 'url' => 'order_admin/listOrder'],
				['label' => 'Chi tiết đơn hàng']
			];
			$data['template'] = "order_admin/viewOrder";
			$this->load->view("admin-layout/admin-layout", $data);
		} else {
			$this->session->set_flashdata('error', 'Không có đơn hàng nào');
			redirect(base_url('dashboard'));
		}
	}



	// public function deleteOrder($order_code)
	// {
	// 	$this->load->model('orderModel');
	// 	// Lấy danh sách order details
	// 	$order_detail = $this->orderModel->selectOrderDetails($order_code);
	// 	if (empty($order_detail)) {
	// 		$this->session->set_flashdata('error', 'Đơn hàng không tồn tại');
	// 		redirect(base_url('order_admin/listOrder'));
	// 		return;
	// 	}

	// 	if ($order_detail->checkout_method == 'COD') {
	// 		$this->db->trans_start();
	// 		foreach ($order_detail as $order_detail) {
	// 			$this->orderModel->deleteOrderBatches($order_detail->order_detail_id);
	// 		}
	// 		$this->orderModel->deleteOrderDetails($order_code);
	// 		$ShippingID = $this->orderModel->deleteOrder($order_code);
	// 		if ($ShippingID !== false) {
	// 			$this->orderModel->deleteShipping($ShippingID);
	// 		}
	// 		$this->db->trans_complete();
	// 	} elseif ($order_detail->checkout_method == 'VNPAY') {
	// 		$this->session->set_flashdata('error', 'Không thể xoá đơn hàng với phuong thức thanh toán VNPAY');
	// 		redirect(base_url('order_admin/listOrder'));
	// 	}

	// 	if ($this->db->trans_status() === FALSE) {
	// 		$this->session->set_flashdata('error', 'Xóa đơn hàng thất bại');
	// 	} else {
	// 		$this->session->set_flashdata('success', 'Xóa đơn hàng thành công');
	// 	}
	// 	redirect(base_url('order_admin/listOrder'));
	// }

	public function update_order_status_old()
	{
		$value = $this->input->post('value');
		$order_code = $this->input->post('Order_Code');
		$product_qty_in_batch = $this->input->post('product_qty_in_batch');

		$this->load->model('orderModel');

		if ($value == 4) {
			$timenow = Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();
			$data_order = array(
				'Order_Status' => $value,
				'Payment_Status' => 1,
				'Date_delivered' => $timenow,
				'Payment_date_successful' => $timenow
			);
			$this->orderModel->updateOrder($data_order, $order_code);
			if (!empty($product_qty_in_batch)) {
				foreach ($product_qty_in_batch as $batch) {
					$batch_id = $batch['Batch_ID'];
					$quantity_to_deduct = $batch['QuantityToTake'];

					$this->orderModel->deductBatchQuantity($batch_id, $quantity_to_deduct);
				}
			} else {
				$this->session->set_flashdata('error', 'Lỗi không thể cập nhật số lượng');
				redirect(base_url('order_admin/listOrder'));
			}
		} elseif ($value == 5) {
			$data_order = array(
				'Order_Status' => $value,
			);
			$this->orderModel->updateOrder($data_order, $order_code);
		} else {
			$data_order = array(
				'Order_Status' => $value
			);
			$this->orderModel->updateOrder($data_order, $order_code);
		}
	}


	public function update_order_status()
	{
		$value = (int)$this->input->post('value');
		$order_code = $this->input->post('Order_Code');
		if (!is_array($order_code)) {
			$order_code = [$order_code];
		}
		$product_qty_in_batch = $this->input->post('product_qty_in_batch');

		$this->load->model('orderModel');
		$result = $this->orderModel->process_order_status_update($value, $order_code, $product_qty_in_batch);

		echo json_encode($result);
		return;
	}


	public function bulkUpdate()
	{
		$this->load->model('orderModel');

		$order_ids = $this->input->post('order_ids');
		$new_status = (int) $this->input->post('new_status');

		if (empty($order_ids)) {
			$this->session->set_flashdata('error', 'Vui lòng chọn ít nhất 1 đơn hàng để cập nhật.');
			redirect(base_url('order_admin/listOrder'));
		}

		$result = $this->orderModel->process_order_status_update($new_status, $order_ids);

		if ($result['success']) {
			$this->session->set_flashdata('success', $result['message']);
		} else {
			$this->session->set_flashdata('error', $result['message']);
		}

		redirect(base_url('order_admin/listOrder'));
	}



	public function customerCancelOrder($Order_Code)
	{
		$this->load->model('orderModel');
	
		$result = $this->orderModel->cancelOrderByCode($Order_Code);
	
		if ($result) {
			$this->session->set_flashdata('success', 'Hủy đơn hàng thành công.');
		} else {
			$this->session->set_flashdata('error', 'Không thể hủy đơn hàng này.');
		}
	
		redirect(base_url('order_customer/listOrder'));
	}
	





	public function printOrder($order_code)
	{
		$this->load->library('Pdf');
		$this->load->model('orderModel');

		$order_details = $this->orderModel->selectOrderDetails($order_code);

		if (empty($order_details)) {
			show_error('Không tìm thấy đơn hàng.', 404);
		}

		// Lấy thông tin khách hàng và mã giảm giá từ phần tử đầu tiên
		$first = $order_details[0];
		$customer_name = $first->name;
		$customer_phone = $first->phone;
		$customer_address = $first->address;
		$checkout_method = $first->checkout_method;

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetTitle('Hóa đơn: ' . $order_code);
		$pdf->SetHeaderMargin(10);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(15);
		$pdf->SetAutoPageBreak(true);
		$pdf->SetAuthor('Pesticide Shop');
		$pdf->SetDisplayMode('real', 'default');
		$pdf->AddPage();

		$html = '
		<h2 style="text-align: center;">HÓA ĐƠN MUA HÀNG</h2>
		<p style="text-align: center;">Cảm ơn bạn đã mua sắm tại <strong>Pesticide Shop</strong></p>
		<p><strong>Mã đơn hàng:</strong> ' . $order_code . '</p>
		<p><strong>Ngày in:</strong> ' . date('d/m/Y') . '</p>
		<p><strong>Khách hàng:</strong> ' . $customer_name . '</p>
		<p><strong>SĐT:</strong> ' . $customer_phone . '</p>
		<p><strong>Địa chỉ:</strong> ' . $customer_address . '</p>
		<p><strong>Phương thức thanh toán:</strong> ' . $checkout_method . '</p>
	';

		$html .= '
		<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
			<thead>
				<tr style="background-color: #f2f2f2; text-align: center;">
					<th>STT</th>
					<th>Mã SP</th>
					<th>Tên sản phẩm</th>
					<th>Giá</th>
					<th>Số lượng</th>
					<th>Chiết khấu SP</th>
					<th>Thành tiền</th>
				</tr>
			</thead>
			<tbody>
	';

		$total = 0;
		foreach ($order_details as $key => $product) {
			$discounted_price = $product->Selling_price * (1 - $product->Promotion / 100);
			$subtotal = $discounted_price * $product->qty;
			$total += $subtotal;

			$html .= '
			<tr style="text-align: center;">
				<td>' . ($key + 1) . '</td>
				<td>' . $product->Product_Code . '</td>
				<td style="text-align: left;">' . $product->Name . '</td>
				<td>' . number_format($product->Selling_price, 0, ',', '.') . 'đ</td>
				<td>' . $product->qty . '</td>
				<td>' . $product->Promotion . '%</td>
				<td>' . number_format($subtotal, 0, ',', '.') . 'đ</td>
			</tr>';
		}

		// Tính giảm giá hóa đơn
		$discount_value = 0;
		if (!empty($first->DiscountID)) {
			if ($first->Discount_type == 'Fixed') {
				$discount_value = $first->Discount_value;
			} elseif ($first->Discount_type == 'Percent') {
				$discount_value = $total * ($first->Discount_value / 100);
				if (!empty($first->Max_discount)) {
					$discount_value = min($discount_value, $first->Max_discount);
				}
			}
		}

		$final_total = $total - $discount_value;

		// Hiển thị tổng tiền
		$html .= '
		<tr style="font-weight: bold; text-align: right;">
			<td colspan="6">Tạm tính:</td>
			<td style="text-align: center;">' . number_format($total, 0, ',', '.') . 'đ</td>
		</tr>';

		if ($discount_value > 0) {
			$html .= '
		<tr style="font-weight: bold; text-align: right;">
			<td colspan="6">Mã giảm giá (' . $first->Coupon_code . '):</td>
			<td style="text-align: center;">- ' . number_format($discount_value, 0, ',', '.') . 'đ</td>
		</tr>';
		}

		$html .= '
		<tr style="font-weight: bold; text-align: right;">
			<td colspan="6">Tổng cộng:</td>
			<td style="text-align: center;">' . number_format($final_total, 0, ',', '.') . 'đ</td>
		</tr>
	</tbody>
	</table>
	';

		$html .= '
		<p style="text-align: center; margin-top: 20px;">Cảm ơn bạn đã ủng hộ. Mọi thắc mắc vui lòng liên hệ hotline: <strong>1900 1900</strong>.</p>
	';

		$pdf->SetFont('dejavusans', '', 10);
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('Order_' . $order_code . '.pdf', 'I');
	}


	public function bulkPrint()
	{
		$this->load->library('Pdf');
		$this->load->model('orderModel');

		$order_codes = $this->input->post('order_ids');

		if (empty($order_codes)) {
			$this->session->set_flashdata('error', 'Không có đơn hàng nào được chọn.');
			redirect(base_url('order_admin/listOrder'));
		}

		// Tạo thư mục downloads nếu chưa tồn tại
		$download_dir = FCPATH . 'downloads/';
		if (!is_dir($download_dir)) {
			mkdir($download_dir, 0777, true);
		}

		$zip = new ZipArchive();
		$zip_filename = $download_dir . 'orders_' . time() . '.zip';
		$zip->open($zip_filename, ZipArchive::CREATE);


		foreach ($order_codes as $order_code) {
			$order_details = $this->orderModel->printOrderDetails($order_code);

			$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
			$pdf->SetTitle('Hóa đơn: ' . $order_code);
			$pdf->SetFont('dejavusans', '', 12);
			$pdf->AddPage();

			$html = '
            <h2 style="text-align: center;">HÓA ĐƠN MUA HÀNG</h2>
            <p><strong>Mã đơn hàng:</strong> ' . $order_code . '</p>
            <p><strong>Ngày in:</strong> ' . date('d/m/Y') . '</p>
            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2; text-align: center;">
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Chiết khấu</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
        ';

			$total = 0;
			foreach ($order_details as $key => $product) {
				$discounted_price = $product->Selling_price * (1 - $product->Promotion / 100);
				$subtotal = $product->qty * $discounted_price;
				$total += $subtotal;

				$html .= '
                <tr style="text-align: center;">
                    <td>' . ($key + 1) . '</td>
                    <td style="text-align: left;">' . $product->Name . '</td>
                    <td>' . number_format($product->Selling_price, 0, ',', '.') . 'đ</td>
                    <td>' . $product->qty . '</td>
                    <td>' . $product->Promotion . '%</td>
                    <td>' . number_format($subtotal, 0, ',', '.') . 'đ</td>
                </tr>
            ';
			}

			$html .= '
            <tr style="font-weight: bold; text-align: right;">
                <td colspan="5">Tổng cộng:</td>
                <td style="text-align: center;">' . number_format($total, 0, ',', '.') . 'đ</td>
            </tr>
            </tbody>
            </table>
        ';

			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf_path = FCPATH . 'downloads/order_' . $order_code . '.pdf';
			$pdf->Output($pdf_path, 'F');

			$zip->addFile($pdf_path, 'order_' . $order_code . '.pdf');
		}

		$zip->close();

		// Dọn file PDF sau khi zip
		foreach ($order_codes as $order_code) {
			unlink(FCPATH . 'downloads/order_' . $order_code . '.pdf');
		}

		// redirect(base_url('downloads/' . basename($zip_filename)));


		if (file_exists($zip_filename)) {
			// Dọn dẹp bộ đệm đầu ra trước khi gửi header
			if (ob_get_length()) ob_end_clean();

			// Gửi file zip về cho trình duyệt
			header('Content-Type: application/zip');
			header('Content-Disposition: attachment; filename="' . basename($zip_filename) . '"');
			header('Content-Length: ' . filesize($zip_filename));
			header('Pragma: public');
			header('Cache-Control: must-revalidate');
			header('Expires: 0');
			readfile($zip_filename);

			// Xóa file zip sau khi gửi xong
			unlink($zip_filename);
			exit;
		} else {
			show_error('Không tìm thấy file zip để tải về.');
		}
	}
}
