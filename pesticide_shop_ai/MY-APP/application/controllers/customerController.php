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
 * @property customerModel $customerModel
 * @property upload $upload
 * @property data $data
 */

class customerController extends CI_Controller
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

	public function index($page = 1)
	{
		$this->config->config['pageTitle'] = 'List Customers';
		$this->load->model('customerModel');

		// Filter
		$keyword = $this->input->get('keyword', TRUE);
		$status = $this->input->get('status', TRUE);
		$role_id = $this->input->get('role_id', TRUE);
		$sort_totalamount = $this->input->get('sort_totalamount', TRUE);
		$perpage = (int) $this->input->get('perpage');
		$perpage = ($perpage > 0) ? $perpage : 10;

		$filter = [
			'keyword' => $keyword,
			'status' => $status,
			'role_id' => $role_id,
			'sort_totalamount' => $sort_totalamount
		];


		// Tổng số bản ghi theo filter
		$total = $this->customerModel->countCustomer($filter);

		// --- Tính offset ---
		$page  = (int)$page;
		$page  = ($page > 0) ? $page : 1;
		$max_page = ceil($total / $perpage);
		if ($page > $max_page && $total > 0) {
			$query = http_build_query($this->input->get());
			redirect(base_url('manage-customer/list') . ($query ? '?' . $query : ''));
		}

		$start = ($page - 1) * $perpage;

		$data['customers'] = $this->customerModel->getCustomers($perpage, $start, $filter);

		// echo '<pre>';
		// print_r($data['customers']);
		// echo '</pre>';


		$data['links'] = init_pagination(base_url('manage-customer/list'), $total, $perpage, 3);

		// Trả filter về view
		$data['keyword']   = $keyword;
		$data['status']    = $status;
		$data['role_id']   = $role_id;
		$data['sort_totalamount'] = $sort_totalamount;
		$data['perpage']   = $perpage;

		$data['title'] = "Danh sách người dùng";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Danh sách người dùng']
		];
		$data['start'] = $start;
		$data['template'] = "manage-customer/index";
		$this->load->view("admin-layout/admin-layout", $data);
	}



	public function manageRoleUser($page = 1)
	{
		$this->config->config['pageTitle'] = 'Manage Role';
		$this->load->model('customerModel');

		// --- Lấy filter từ GET ---
		$keyword  = $this->input->get('keyword', TRUE);
		$perpage  = (int)$this->input->get('perpage');
		$perpage  = ($perpage > 0) ? $perpage : 10;

		$filter = [
			'keyword' => $keyword,
		];

		$total = $this->customerModel->countAllRoles($filter);

		$page  = (int)$page;
		$page = (int)$this->uri->segment(2);
		if ($page < 1) $page = 1;
		$max_page = ceil($total / $perpage);
		if ($page > $max_page && $total > 0) {
			$query = http_build_query($this->input->get());
			redirect(base_url('manage-role') . ($query ? '?' . $query : ''));
		}

		$start = ($page - 1) * $perpage;

		
		// --- Lấy danh sách vai trò ---
		$data['roles']   = $this->customerModel->getAllRole($perpage, $start, $filter);
		$data['links'] = init_pagination(base_url('manage-role'), $total, $perpage, 2);


		// --- Truyền filter lại cho view ---
		$data['keyword'] = $keyword;
		$data['perpage'] = $perpage;
		// Thông tin view
		$data['title'] = "Quản lý nhóm người dùng";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Danh sách vai trò'],
		];
		$data['start'] = $start;
		$data['template'] = "manage-customer/listRole";
		$this->load->view("admin-layout/admin-layout", $data);
	}




	public function editRole($Role_ID)
	{
		$this->config->config['pageTitle'] = 'Edit Role';
		$this->load->model('customerModel');
		$data['role'] = $this->customerModel->selectRoleById($Role_ID);
		$data['title'] = "Chỉnh sửa vai trò";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Danh sách vai trò', 'url' => 'manage-role'],
			['label' => 'Chỉnh sửa vai trò']
		];
		$data['template'] = "manage-customer/editRole";
		$this->load->view("admin-layout/admin-layout", $data);
	}

	public function updateRole($Role_ID)
	{
		$this->form_validation->set_rules('Role_name', 'Role_name', 'trim|required', ['required' => 'Bạn cần diền %s']);
		$this->form_validation->set_rules('Description', 'Email', 'trim|required', ['required' => 'Bạn cần điền %s']);

		if ($this->form_validation->run()) {

			$data = [
				'Role_name' => $this->input->post('Role_name'),
				'Description' => $this->input->post('Description'),
			];

			$this->load->model('customerModel');
			$this->customerModel->updateRole($Role_ID, $data);
			$this->session->set_flashdata('success', 'Đã chỉnh sửa thông tin vai trò thành công');
			redirect(base_url('manage-role'));
		} else {
			$this->editRole($Role_ID);
		}
	}


	public function editCustomer($UserID)
	{
		$this->config->config['pageTitle'] = 'Edit Customer';
		$this->load->model('customerModel');
		$data['customers'] = $this->customerModel->selectCustomerById($UserID);
		$data['title'] = "Chỉnh sửa người dùng";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Danh sách người dùng', 'url' => 'manage-customer/list'],
			['label' => 'Chỉnh sửa']
		];
		$data['template'] = "manage-customer/editCustomer";
		$this->load->view("admin-layout/admin-layout", $data);
	}


	public function updateCustomer($UserID)
	{
		$this->form_validation->set_rules('Name', 'Username', 'trim|required', ['required' => 'Bạn cần diền %s']);
		$this->form_validation->set_rules('Email', 'Email', 'trim|required', ['required' => 'Bạn cần điền %s']);
		$this->form_validation->set_rules('Phone', 'Phone', 'trim|required', ['required' => 'Bạn cần diền %s']);
		$this->form_validation->set_rules('Address', 'Address', 'trim|required', ['required' => 'Bạn cần điền %s']);


		if ($this->form_validation->run()) {

			if (!empty($_FILES['Avatar']['name'])) {

				$ori_filename = $_FILES['Avatar']['name'];
				$new_name = time() . "" . str_replace(' ', '-', $ori_filename);

				$config = [
					'upload_path' => './uploads/user',
					'allowed_types' => 'gif|jpg|png|jpeg',
					'file_name' => $new_name
				];
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('Avatar')) {
					$this->data['error'] = $this->upload->display_errors();
					$this->data['template'] = "manage-customer/editCustomer";
					$this->data['title'] = "Chỉnh sửa người dùng";
					$this->load->view("admin-layout/admin-layout", $this->data);
				} else {
					$avatar_filename = $this->upload->data('file_name');
					$data = [
						'Name' => $this->input->post('Name'),
						'Email' => $this->input->post('Email'),
						'Phone' => $this->input->post('Phone'),
						'Address' => $this->input->post('Address'),
						'Avatar' => $avatar_filename,
						'Status' => $this->input->post('Status'),
						'Role_ID' => $this->input->post('Role_ID')
					];
				}
			} else {
				$data = [
					'Name' => $this->input->post('Name'),
					'Email' => $this->input->post('Email'),
					'Phone' => $this->input->post('Phone'),
					'Address' => $this->input->post('Address'),
					'Status' => $this->input->post('Status'),
					'Role_ID' => $this->input->post('Role_ID')
				];
			}
			$this->load->model('customerModel');
			$this->customerModel->updateCustomer($UserID, $data);
			$this->session->set_flashdata('success', 'Đã chỉnh sửa trạng thái khách hàng thành công');
			redirect(base_url('manage-customer/list'));
		} else {
			$this->editCustomer($UserID);
		}
	}


	public function bulkUpdateCustomer(){
		$customer_ids = $this->input->post('customer_ids');
		$new_status = (int) $this->input->post('new_status');

		$this->load->model('customerModel');
		$this->customerModel->bulkupdateCustomer($customer_ids, $new_status);

	}

	// public function deleteCustomer($UserID)
	// {
	// 	$this->load->model('customerModel');
	// 	$this->customerModel->deleteCustomer($UserID);
	// 	$this->session->set_flashdata('success', 'Đã xoá người dùng thành công');
	// 	redirect(base_url('category/list'));
	// }

}
