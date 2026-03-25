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
 * @property supplierModel $supplierModel
 * @property upload $upload
 */


class supplierController extends CI_Controller
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




	public function index($page = 1)
	{
		$this->config->config['pageTitle'] = 'List Supplier';
		$this->load->model('supplierModel');
		$this->load->helper('pagination');

		$keyword  = $this->input->get('keyword', true);
		$status   = $this->input->get('status', true);
		$perpage  = (int) $this->input->get('perpage');
		$perpage  = $perpage > 0 ? $perpage : 10;

		$total = $this->supplierModel->countSupplier($keyword, $status);

		$page = (int) $page;
		$page = $page > 0 ? $page : 1;
		$max_page = ceil($total / $perpage);

		if ($page > $max_page && $total > 0) {
			$query = http_build_query($this->input->get());
			redirect(base_url('supplier/list') . ($query ? '?' . $query : ''));
		}

		$start = ($page - 1) * $perpage;

		$data['suppliers'] = $this->supplierModel->selectSupplier($keyword, $status, $perpage, $start);
		$data['links'] = init_pagination(base_url('supplier/list'), $total, $perpage, 3);

		$data['status']     = $status;
		$data['keyword']    = $keyword;
		$data['perpage']    = $perpage;
		$data['start']      = $start;
		$data['title']      = "Danh sách nhà cung cấp";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Danh sách nhà cung cấp']
		];
		$data['template'] = "supplier/index";

		$this->load->view("admin-layout/admin-layout", $data);
	}


	public function createSupplier()
	{
		$this->config->config['pageTitle'] = 'Add Supplier';
		$this->load->model('supplierModel');
		$data['errors'] = $this->session->flashdata('errors');
		$data['input'] = $this->session->flashdata('input');
		$data['supplier'] = $this->supplierModel->selectSupplier();
		$data['title'] = "Thêm mới nhà cung cấp";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Thêm mới nhà cung cấp']
		];
		$data['template'] = "supplier/storeSupplier";
		$this->load->view("admin-layout/admin-layout", $data);
	}



	public function storageSupplier()
	{
		$this->form_validation->set_rules('Name', 'tên nhà cung cấp', 'trim|required', ['required' => 'Bạn cần điền %s']);
		$this->form_validation->set_rules('Contact', 'tên người đại diện', 'trim|required', ['required' => 'Bạn cần điền %s']);
		$this->form_validation->set_rules('Phone', 'số điện thoại', 'trim|required', ['required' => 'Bạn cần điền %s']);
		$this->form_validation->set_rules('Address', 'dịa chỉ nhà cung cấp', 'trim|required', ['required' => 'Bạn cần điền %s']);
		$this->form_validation->set_rules('Email', 'email nhà cung cấp', 'trim|required', ['required' => 'Bạn cần điền %s']);

		if ($this->form_validation->run()) {
			$data = [
				'Name' => $this->input->post('Name'),
				'Contact' => $this->input->post('Contact'),
				'Phone' => $this->input->post('Phone'),
				'Address' => $this->input->post('Address'),
				'Email' => $this->input->post('Email'),
				'Status' => $this->input->post('Status'),
			];
			$this->load->model('supplierModel');
			$this->supplierModel->insertSupplier($data);
			$this->session->set_flashdata('success', 'Đã thêm nhà cung cấp thành công');
			redirect(base_url('supplier/list'));
		} else {
			$this->session->set_flashdata('errors', $this->form_validation->error_array());
			$this->session->set_flashdata('input', $this->input->post());
			redirect(base_url('supplier/create'));
		}
	}

	public function editSupplier($SupplierID)
	{
		$this->config->config['pageTitle'] = 'Edit Supplier';
		$this->load->model('supplierModel');
		$data['supplier'] = $this->supplierModel->selectSupplierById($SupplierID);
		$data['title'] = "Chỉnh sửa nhà cung cấp";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Danh sách nhà cung cấp', 'url' => 'supplier/list'],
			['label' => 'Chỉnh sửa nhà cung cấp']
		];
		$data['template'] = "supplier/editSupplier";
		$this->load->view("admin-layout/admin-layout", $data);
	}

	public function updateSupplier($SupplierID)
	{
		$this->load->model('supplierModel');
		$this->load->library(['form_validation', 'upload']);

		// Validate dữ liệu nhập vào
		$this->form_validation->set_rules('Name', 'tên nhà cung cấp', 'trim|required', ['required' => 'Bạn cần điền %s']);
		$this->form_validation->set_rules('Contact', 'tên người đại diện', 'trim|required', ['required' => 'Bạn cần điền %s']);
		$this->form_validation->set_rules('Phone', 'số điện thoại', 'trim|required', ['required' => 'Bạn cần điền %s']);
		$this->form_validation->set_rules('Address', 'dịa chỉ nhà cung cấp', 'trim|required', ['required' => 'Bạn cần điền %s']);
		$this->form_validation->set_rules('Email', 'email nhà cung cấp', 'trim|required', ['required' => 'Bạn cần điền %s']);


		if (!$this->form_validation->run()) {
			return $this->editSupplier($SupplierID);
		}

		$old_data = $this->supplierModel->selectSupplierById($SupplierID);

		$new_data = [
			'Name' => $this->input->post('Name'),
			'Contact' => $this->input->post('Contact'),
			'Phone' => $this->input->post('Phone'),
			'Address' => $this->input->post('Address'),
			'Email' => $this->input->post('Email'),
			'Status' => $this->input->post('Status'),
		];

		if ($this->_is_same_data($old_data, $new_data)) {
			// Hiện tại phần này đang có bug là khi người dùng xoá đi bấm lưu thì chuyển về trang lỗi, nhưng nếu nhập lại email cũ thì là không có gì thay đổi
			$this->session->set_flashdata('info', 'Không có thay đổi nào để lưu.');
			$result = $this->supplierModel->updateSupplier($SupplierID, $new_data);
			return $this->editSupplier($SupplierID);
		} else {
			$result = $this->supplierModel->updateSupplier($SupplierID, $new_data);
			if ($result) {
				$this->session->set_flashdata('success', 'Đã chỉnh sửa nhà cung cấp thành công.');
			} else {
				$this->session->set_flashdata('error', 'Có lỗi xảy ra khi cập nhật.');
			}
		}

		redirect(base_url('supplier/list'));
	}


	public function bulkUpdateSupplier()
	{
		$supplier_ids = $this->input->post('supplier_ids');
		$new_status = (int) $this->input->post('new_status');

		if (empty($supplier_ids) || !is_array($supplier_ids)) {
			$this->session->set_flashdata('error', 'Cần chọn ít nhất một nhà cung cấp');
			redirect(base_url('supplier/list'));
			return;
		}

		if (empty($new_status)) {
			$this->session->set_flashdata('error', 'Cần chọn trạng thái');
			redirect(base_url('supplier/list'));
			return;
		}

		$this->load->model('supplierModel');
		$this->supplierModel->bulkupdateSupplier($supplier_ids, $new_status);
		$this->session->set_flashdata('success', 'Cập nhật trạng thái thành công');
		redirect(base_url('supplier/list'));
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
}
