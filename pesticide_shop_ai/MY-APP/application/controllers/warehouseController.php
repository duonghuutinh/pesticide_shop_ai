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
 */


class warehouseController extends CI_Controller
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
			redirect(base_url('dang-nhap'));
		}
	}

	// public function index()
	// {
	// 	// $this->checkLogin();
	// 	$this->config->config['pageTitle'] = 'List Products';
	// 	$this->load->model('indexModel');

	// 	$total_products = $this->indexModel->countAllProduct();

	// 	$this->load->library('pagination');

	// 	$config = array();
	// 	$config["base_url"] = base_url() . 'product/list';
	// 	$config['total_rows'] = $total_products;
	// 	$config["per_page"] = 10;
	// 	$config["uri_segment"] = 3;
	// 	$config['use_page_numbers'] = TRUE;
	// 	$config['full_tag_open'] = '<ul class="pagination">';
	// 	$config['full_tag_close'] = '</ul>';
	// 	$config['first_link'] = 'First';
	// 	$config['first_tag_open'] = '<li>';
	// 	$config['first_tag_close'] = '</li>';
	// 	$config['last_link'] = 'Last';
	// 	$config['last_tag_open'] = '<li>';
	// 	$config['last_tag_close'] = '</li>';
	// 	$config['cur_tag_open'] = '<li class="active"><a>';
	// 	$config['cur_tag_close'] = '</a></li>';
	// 	$config['num_tag_open'] = '<li>';
	// 	$config['num_tag_close'] = '</li>';
	// 	$config['next_tag_open'] = '<li>';
	// 	$config['next_tag_close'] = '</li>';
	// 	$config['prev_tag_open'] = '<li>';
	// 	$config['prev_tag_close'] = '</li>';

	// 	// Khởi tạo phân trang
	// 	$this->pagination->initialize($config);

	// 	// Xác định trang hiện tại
	// 	$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
	// 	$start = ($page - 1) * $config['per_page'];

	// 	// Lấy dữ liệu sản phẩm theo phân trang
	// 	$data['products'] = $this->indexModel->getIndexPagination($config['per_page'], $start);
	// 	$data['links'] = $this->pagination->create_links();
	// 	// echo '<pre>';
	// 	// print_r($data);
	// 	// echo '</pre>';


	// 	$data['breadcrumb'] = [
	// 		['label' => 'Dashboard', 'url' => 'dashboard'],
	// 		['label' => 'Danh sách sản phẩm trong kho']
	// 	];
	// 	$data['template'] = "warehouse/index";
	// 	$this->load->view("admin-layout/admin-layout", $data);
	// }

	public function index($page = 1)
	{
		$this->config->config['pageTitle'] = 'List Products';
		$this->load->model('indexModel');
		$this->load->library('pagination');

		$keyword  = $this->input->get('keyword', true);
		$status   = $this->input->get('status', true);
		$perpage  = (int) $this->input->get('perpage');
		$perpage  = $perpage > 0 ? $perpage : 10;

		$total_products = $this->indexModel->countAllProduct($keyword, $status);

		$page  = (int)$page;
		$page  = ($page > 0) ? $page : 1;
		$max_page = ceil($total_products / $perpage);
		if ($page > $max_page && $total_products > 0) {
			$query = http_build_query($this->input->get());
			redirect(base_url('warehouse/list') . ($query ? '?' . $query : ''));
		}

		$start = ($page - 1) * $perpage;


		$data['products'] = $this->indexModel->getProductPagination($perpage, $start, $keyword, $status);
		$data['links'] = init_pagination(base_url('warehouse/list'), $total_products, $perpage, 3);


		$data['keyword'] = $keyword;
		$data['status'] = $status;
		$data['perpage'] = $perpage;
		$data['title'] = "Danh sách sản phẩm trong kho";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Danh sách sản phẩm trong kho']
		];
		$data['start'] = $start;
		$data['template'] = "warehouse/index";
		$this->load->view("admin-layout/admin-layout", $data);
	}



	public function receive_goods_page($extraData = [])
	{
		$this->load->model('indexModel');
		$this->load->model('warehouseModel');
		$data = [
			'allproducts' => $this->indexModel->getAllProduct(),
			'allsuppliers' => $this->indexModel->getAllSupplier(),
			'receipt_number' => $this->warehouseModel->getLatestReceiptNumber(),
			'pageTitle' => 'Phiếu nhập hàng',
			'template' => "warehouse/receive-goods",
			'title' => "Phiếu nhập kho",
			'errors' => $this->session->flashdata('errors'),
			'input' => $this->session->flashdata('input')
		];

		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Phiếu nhập kho']
		];

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";

		$data = array_merge($data, $extraData);

		$this->load->view("admin-layout/admin-layout", $data);
	}


	public function enter_into_warehouse()
	{
		$fields = [
			'tax_identification_number' => 'Chưa có mã số thuế',
			'date' => 'Bạn cần chọn ngày',
			'ho_ten_nguoi_giao' => 'Bạn cần nhập họ tên người giao',
			'donvi' => 'Bạn cần nhập đơn vị',
			'address' => 'Bạn cần nhập địa chỉ',
			'phieu_giao_nhan_so' => 'Bạn cần nhập phiếu giao nhận số',
			'nhan_noi_bo_tu_kho' => 'Bạn cần nhập nhận nội bộ từ kho',
			'supplier_id' => 'Thiếu nhà cung cấp'
		];

		foreach ($fields as $field => $message) {
			$this->form_validation->set_rules($field, ucfirst(str_replace('_', ' ', $field)), 'trim|required', ['required' => $message]);
		}

		$products = $this->input->post('products') ?? [];
		foreach ($products as $key => $product) {
			$product_fields = [
				"ProductID" => "Bạn cần chọn sản phẩm",
				"code" => "Thiếu mã sản phẩm",
				"unit" => "Thiếu đơn vị tính",
				"Import_price" => "Thiếu giá nhập",
				"Exp_date" => "Thiếu hạn sử dụng",
				"quantity_doc" => "Thiếu số lượng",
				"quantity_real" => "Thiếu số lượng"
			];

			foreach ($product_fields as $field => $message) {
				$rule = in_array($field, ['Import_price', 'quantity_doc', 'quantity_real']) ? 'trim|required|numeric' : 'trim|required';
				$this->form_validation->set_rules("products[$key][$field]", ucfirst($field), $rule, [
					'required' => $message,
					'numeric' => 'Giá trị phải là số'
				]);
			}
		}

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('errors', $this->form_validation->error_array());
			$this->session->set_flashdata('input', $this->input->post());
			redirect('warehouse/receive-goods');
			return;
		}


		$data_warehouse_receipt = [
			'tax_identification_number' => $this->input->post('tax_identification_number'),
			'created_at' => $this->input->post('date'),
			'name_of_delivery_person' => $this->input->post('ho_ten_nguoi_giao'),
			'delivery_unit' => $this->input->post('donvi'),
			'address' => $this->input->post('address'),
			'delivery_note_number' => $this->input->post('phieu_giao_nhan_so'),
			'warehouse_from' => $this->input->post('nhan_noi_bo_tu_kho'),
			'supplier_id' => $this->input->post('supplier_id'),
			'sub_total' => $this->input->post('sub_total')
		];
		// echo "<pre>";
		// print_r($products);
		// echo "</pre>";

		// echo "<pre>";
		// print_r($data_warehouse_receipt);
		// echo "</pre>";
		$products = $this->input->post('products') ?? [];
		$this->load->model('warehouseModel');
		$warehouse_receipt_id = $this->warehouseModel->insertWarehouseReceiptWithItems($data_warehouse_receipt, $products);


		if ($warehouse_receipt_id) {
			$this->session->set_flashdata('success', 'Phiếu nhập kho đã được tạo thành công!');
		} else {
			$this->session->set_flashdata('error', 'Lỗi: Không thể tạo phiếu nhập kho!');
		}
		redirect('warehouse/receive-goods');
	}






	public function receipt_goods_history($page = 1)
	{
		$this->config->config['pageTitle'] = 'Lịch sử nhập hàng';
		$this->load->model('warehouseModel');
		$this->load->model('indexModel');

		$filter = [
			'perpage'       => (int)$this->input->get('perpage'),
			'keyword'       => $this->input->get('keyword', TRUE),
			'supplier_id'   => $this->input->get('supplier_id', TRUE),
			'start_date'    => $this->input->get('start_date', TRUE),
			'start_date'      => $this->input->get('start_date', TRUE),
			'sort_by'       => $this->input->get('sort_by', TRUE)
		];
		$filter['perpage'] = ($filter['perpage'] > 0 && $filter['perpage'] <= 100) ? $filter['perpage'] : 10;

		// Tổng số dòng
		$total = $this->warehouseModel->count_filtered_receipts($filter);

		// Xử lý trang hiện tại
		$page = (int)$this->uri->segment(3);
		if ($page < 1) $page = 1;
		$max_page = ceil($total / $filter['perpage']);
		if ($page > $max_page && $total > 0) {
			$query = http_build_query($this->input->get());
			redirect(base_url('warehouse/receive-goods-history') . ($query ? '?' . $query : ''));
		}

		// Phân trang
		$limit  = $filter['perpage'];
		$offset = ($page - 1) * $limit;

		// Lấy danh sách phiếu nhập
		$receipts = $this->warehouseModel->get_filtered_receipts($limit, $offset, $filter);
		$receipt_ids = array_column($receipts, 'warehouse_receipt_id');

		// Lấy danh sách sản phẩm theo phiếu
		$items = $this->warehouseModel->get_items_by_receipt_ids($receipt_ids);
		foreach ($receipts as &$receipt) {
			$receipt['product_items'] = isset($items[$receipt['warehouse_receipt_id']]) ? $items[$receipt['warehouse_receipt_id']] : [];
		}

		// Đổ dữ liệu ra view
		$data['receive_history'] = $receipts;

		// echo "<pre>";
		// print_r($data['receive_history']);
		// echo "</pre>";



		$data['suppliers'] = $this->indexModel->getAllSupplier();
		$data['links'] = init_pagination(base_url('warehouse/receive-goods-history'), $total, $limit, 3);

		$data['title'] = "Lịch sử nhập hàng";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Lịch sử nhập hàng']
		];
		$data['template'] = "warehouse/receive-goods-list";
		$data['start'] = $offset;
		$data['perpage'] = $limit;

		$this->load->view("admin-layout/admin-layout", $data);
	}





	public function receipt_goods_history_gốc($page = 1)
	{
		$this->config->config['pageTitle'] = 'Lịch sử nhập hàng';
		$this->load->model('warehouseModel');

		$perpage = (int)$this->input->get('perpage');
		$perpage = $perpage > 0 ? $perpage : 10;

		$total = $this->warehouseModel->count_warehouse_receipts();

		$page = (int)$this->uri->segment(3);
		if ($page < 1) $page = 1;
		$max_page = ceil($total / $perpage);
		if ($page > $max_page && $total > 0) {
			$query = http_build_query($this->input->get());
			redirect(base_url('warehouse/receive-goods-history') . ($query ? '?' . $query : ''));
		}

		$start = ($page - 1) * $perpage;

		$data['receive_history'] = $this->warehouseModel->get_warehouse_receipts_v1($perpage, $start);
		$data['suppliers'] = $this->indexModel->getAllSupplier();
		$data['links'] = init_pagination(base_url('warehouse/receive-goods-history'), $total, $perpage, 3);


		$data['title'] = "Lịch sử nhập hàng";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Lịch sử nhập hàng']
		];
		$data['template'] = "warehouse/receive-goods-list";
		$data['start'] = $start;
		$data['perpage'] = $perpage;
		$this->load->view("admin-layout/admin-layout", $data);
	}


	// public function receipt_goods_history()
	// {
	// 	$this->load->model('warehouseModel');

	// 	$data['receive_history'] = $this->warehouseModel->get_warehouse_receipts();

	// 	// echo "<pre>";
	// 	// print_r($data['receive_history']);
	// 	// echo "</pre>";

	// 	$this->config->config['pageTitle'] = 'Lịch sử nhập hàng';
	// 	$data['title'] = "Lịch sử nhập hàng";
	// 	$data['breadcrumb'] = [
	// 		['label' => 'Dashboard', 'url' => 'dashboard'],
	// 		['label' => 'Lịch sử nhập hàng']
	// 	];
	// 	$data['template'] = "warehouse/receive-goods-list";
	// 	$this->load->view("admin-layout/admin-layout", $data);
	// }

	public function receipt_detail($id)
	{
		$this->load->model('warehouseModel');
		$data['receipt_detail'] = $this->warehouseModel->get_warehouse_receipt_by_id($id);

		// echo "<pre>";
		// print_r($data['receipt_detail']);
		// echo "</pre>";
		// die();


		$data['title'] = "Chi tiết phiếu nhập kho";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Lịch sử nhập hàng', 'url' => 'warehouse/receive-goods-history'],
			['label' => 'Chi tiết phiếu nhập']
		];
		$data['template'] = "warehouse/receipt-detail";
		$this->load->view("admin-layout/admin-layout", $data);
	}






	public function printReceiptDetail($id)
	{
		$this->load->library('Pdf');
		$this->load->model('warehouseModel');

		// Lấy dữ liệu phiếu nhập kho
		$data['receipt_detail'] = $this->warehouseModel->get_warehouse_receipt_by_id($id);
		if (!$data['receipt_detail']) {
			show_error('Không tìm thấy phiếu nhập kho.');
		}

		// Khởi tạo PDF
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetTitle('Phiếu nhập kho: ' . $data['receipt_detail']['delivery_note_number']);
		$pdf->SetFont('dejavusans', '', 12);
		$pdf->AddPage();

		// Nội dung PDF
		$html = '
	    <h2 style="text-align: center;">PHIẾU NHẬP KHO</h2>
	    <p><strong>Mã phiếu nhập:</strong> ' . $data['receipt_detail']['delivery_note_number'] . '</p>
	    <p><strong>Ngày nhập:</strong> ' . date('d/m/Y', strtotime($data['receipt_detail']['created_at'])) . '</p>
	    <p><strong>Nhà cung cấp:</strong> ' . $data['receipt_detail']['supplier_name'] . '</p>
	    <p><strong>Địa chỉ:</strong> ' . $data['receipt_detail']['address'] . '</p>
	    <p><strong>Người giao:</strong> ' . $data['receipt_detail']['name_of_delivery_person'] . '</p>
	    <p><strong>Kho nhập:</strong> ' . $data['receipt_detail']['warehouse_from'] . '</p>
	    <p><strong>Mã số thuế:</strong> ' . $data['receipt_detail']['tax_identification_number'] . '</p>
	    <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
	        <thead>
	            <tr style="background-color: #f2f2f2; text-align: center;">
	                <th>STT</th>
	                <th>Tên sản phẩm</th>
	                <th>Mã sản phẩm</th>
	                <th>Đơn vị</th>
	                <th>Đơn giá</th>
	                <th>Số lượng</th>
	                <th>Thành tiền</th>
	            </tr>
	        </thead>
	        <tbody>';

		$total = 0;
		foreach ($data['receipt_detail']['product_items'] as $key => $product) {
			$subtotal = $product['quantity_actual'] * $product['unit_import_price'];
			$total += $subtotal;

			$html .= '
	        <tr style="text-align: center;">
	            <td>' . ($key + 1) . '</td>
	            <td style="text-align: left;">' . $product['product_name'] . '</td>
	            <td>' . $product['product_code'] . '</td>
	            <td>' . $product['product_unit'] . '</td>
	            <td>' . number_format($product['unit_import_price'], 0, ',', '.') . 'đ</td>
	            <td>' . $product['quantity_actual'] . '</td>
	            <td>' . number_format($subtotal, 0, ',', '.') . 'đ</td>
	        </tr>
	    ';
		}

		$html .= '
	    <tr style="font-weight: bold; text-align: right;">
	        <td colspan="6">Tổng cộng:</td>
	        <td style="text-align: center;">' . number_format($total, 0, ',', '.') . 'đ</td>
	    </tr>
	    </tbody>
	    </table>';

		// Viết HTML vào PDF
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf_path = FCPATH . 'downloads/receipt_' . $data['receipt_detail']['delivery_note_number'] . '.pdf';
		$pdf->Output($pdf_path, 'F');

		// Sau khi tạo PDF, gửi file về cho người dùng
		if (file_exists($pdf_path)) {
			// Dọn dẹp bộ đệm đầu ra trước khi gửi header
			if (ob_get_length()) ob_end_clean();

			// Gửi file PDF về cho trình duyệt
			header('Content-Type: application/pdf');
			header('Content-Disposition: attachment; filename="' . basename($pdf_path) . '"');
			header('Content-Length: ' . filesize($pdf_path));
			header('Pragma: public');
			header('Cache-Control: must-revalidate');
			header('Expires: 0');
			readfile($pdf_path);

			// Xóa file PDF sau khi gửi xong
			unlink($pdf_path);
			exit;
		} else {
			show_error('Không tìm thấy file PDF để tải về.');
		}
	}

	public function bulkPrintReceipts()
	{
		$this->load->library('Pdf');
		$this->load->model('warehouseModel');

		$receipt_ids = $this->input->post('warehouse_receipt_ids');

		if (empty($receipt_ids)) {
			show_error("Không có phiếu nhập kho nào được chọn.");
		}

		$download_dir = FCPATH . 'downloads/';
		if (!is_dir($download_dir)) {
			mkdir($download_dir, 0777, true);
		}

		$zip = new ZipArchive();
		$zip_filename = $download_dir . 'receipts_' . time() . '.zip';
		$zip->open($zip_filename, ZipArchive::CREATE);

		$pdf_paths = []; // lưu đường dẫn các file để xóa sau

		foreach ($receipt_ids as $id) {
			$data['receipt_detail'] = $this->warehouseModel->get_warehouse_receipt_by_id($id);
			if (!$data['receipt_detail']) continue;

			$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
			$pdf->SetTitle('Phiếu nhập kho: ' . $data['receipt_detail']['delivery_note_number']);
			$pdf->SetFont('dejavusans', '', 12);
			$pdf->AddPage();

			$html = '
			<h2 style="text-align: center;">PHIẾU NHẬP KHO</h2>
			<p><strong>Mã phiếu nhập:</strong> ' . $data['receipt_detail']['delivery_note_number'] . '</p>
			<p><strong>Ngày nhập:</strong> ' . date('d/m/Y', strtotime($data['receipt_detail']['created_at'])) . '</p>
			<p><strong>Nhà cung cấp:</strong> ' . $data['receipt_detail']['supplier_name'] . '</p>
			<p><strong>Địa chỉ:</strong> ' . $data['receipt_detail']['address'] . '</p>
			<p><strong>Người giao:</strong> ' . $data['receipt_detail']['name_of_delivery_person'] . '</p>
			<p><strong>Kho nhập:</strong> ' . $data['receipt_detail']['warehouse_from'] . '</p>
			<p><strong>Mã số thuế:</strong> ' . $data['receipt_detail']['tax_identification_number'] . '</p>
			<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
				<thead>
					<tr style="background-color: #f2f2f2; text-align: center;">
						<th>STT</th>
						<th>Tên sản phẩm</th>
						<th>Mã sản phẩm</th>
						<th>Đơn vị</th>
						<th>Đơn giá</th>
						<th>Số lượng</th>
						<th>Thành tiền</th>
					</tr>
				</thead>
				<tbody>';

			$total = 0;
			foreach ($data['receipt_detail']['product_items'] as $key => $product) {
				$subtotal = $product['quantity_actual'] * $product['unit_import_price'];
				$total += $subtotal;

				$html .= '
				<tr style="text-align: center;">
					<td>' . ($key + 1) . '</td>
					<td style="text-align: left;">' . $product['product_name'] . '</td>
					<td>' . $product['product_code'] . '</td>
					<td>' . $product['product_unit'] . '</td>
					<td>' . number_format($product['unit_import_price'], 0, ',', '.') . 'đ</td>
					<td>' . $product['quantity_actual'] . '</td>
					<td>' . number_format($subtotal, 0, ',', '.') . 'đ</td>
				</tr>';
			}

			$html .= '
				<tr style="font-weight: bold; text-align: right;">
					<td colspan="6">Tổng cộng:</td>
					<td style="text-align: center;">' . number_format($total, 0, ',', '.') . 'đ</td>
				</tr>
				</tbody>
			</table>';

			$pdf->writeHTML($html, true, false, true, false, '');

			// tên file không trùng lặp
			$filename = 'receipt_' . $id . '_' . $data['receipt_detail']['delivery_note_number'] . '.pdf';
			$pdf_path = $download_dir . $filename;
			$pdf->Output($pdf_path, 'F');

			$zip->addFile($pdf_path, $filename);
			$pdf_paths[] = $pdf_path;
		}

		$zip->close();

		// Xoá các file PDF sau khi nén
		foreach ($pdf_paths as $file) {
			if (file_exists($file)) unlink($file);
		}

		// Gửi file zip về trình duyệt
		if (file_exists($zip_filename)) {
			if (ob_get_length()) ob_end_clean();
			header('Content-Type: application/zip');
			header('Content-Disposition: attachment; filename="' . basename($zip_filename) . '"');
			header('Content-Length: ' . filesize($zip_filename));
			header('Pragma: public');
			header('Cache-Control: must-revalidate');
			header('Expires: 0');
			readfile($zip_filename);
			unlink($zip_filename);
			exit;
		} else {
			show_error('Không tìm thấy file zip để tải về.');
		}
	}
}
