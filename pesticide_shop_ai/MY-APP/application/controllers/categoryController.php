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
 */
class categoryController extends CI_Controller
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
			redirect(base_url('dang-mhap'));
		}
	}

	public function index($page = 1)
	{
		$this->config->config['pageTitle'] = 'List Category';
		$this->load->model('categoryModel');
		// Filter
		$keyword  = $this->input->get('keyword', true);
		$status   = $this->input->get('status', true);
		$perpage  = (int) $this->input->get('perpage');
		$perpage  = $perpage > 0 ? $perpage : 10;

		// Tổng số bản ghi
		$total = $this->categoryModel->countCategory($keyword, $status);

		$data['links'] = init_pagination(base_url('category/list'), $total, $perpage, 3);

		// --- Tính offset ---
		$page  = (int)$page;
		$page  = ($page > 0) ? $page : 1;
		$max_page = ceil($total / $perpage);
		if ($page > $max_page && $total > 0) {
			$query = http_build_query($this->input->get());
			redirect(base_url('category/list') . ($query ? '?' . $query : ''));
		}

		$start = ($page - 1) * $perpage;

		// Dữ liệu hiển thị
		$data['category']    = $this->categoryModel->selectCategory($keyword, $status, $perpage, $start);
		$data['links']    = $this->pagination->create_links();

		// Trả filter lại view
		$data['status']   = $status;
		$data['keyword']  = $keyword;
		$data['perpage']  = $perpage;
		$data['title'] 	  = "Danh sách danh mục";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Danh sách danh mục']
		];
		$data['start'] = $start;
		$data['template'] = "category/index";
		$this->load->view("admin-layout/admin-layout", $data);
	}

	public function createCategory()
	{
		$this->config->config['pageTitle'] = 'Create Category';
		$this->load->model('categoryModel');
		$data['errors'] = $this->session->flashdata('errors');
		$data['input'] = $this->session->flashdata('input');
		$data['category'] = $this->categoryModel->selectCategory();
		$data['title'] = "Thêm mới danh mục";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Thêm mới danh mục', 'url' => 'category/create'],
		];
		$data['template'] = "category/storeCategory";
		$this->load->view("admin-layout/admin-layout", $data);
	}

	public function storageCategory()
	{
		$this->form_validation->set_rules('Name', 'Name', 'trim|required', ['required' => 'Bạn cần điền tên danh mục']);
		$this->form_validation->set_rules('Description', 'Description', 'trim|required', ['required' => 'Bạn cần điền mô tả']);
		$this->form_validation->set_rules('Slug', 'Slug', 'trim|required', ['required' => 'Bạn cần chọn %s']);
		// $this->form_validation->set_rules('Image', 'Hình ảnh', 'required', ['required' => 'Bạn cần chọn %s']);

		
		if ($this->form_validation->run()) {
			if (empty($_FILES['Image']['name'])) {
				$this->session->set_flashdata('errors', ['Image' => 'Bạn cần chọn hình ảnh']);
				$this->session->set_flashdata('input', $this->input->post());
				redirect(base_url('brand/create'));
				return;
			}
			$ori_filename = $_FILES['Image']['name'];
			$new_name = time() . "" . str_replace(' ', '-', $ori_filename);
			$config = [
				'upload_path' => './uploads/category',
				'allowed_types' => 'gif|jpg|png|jpeg',
				'file_name' => $new_name
			];
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('Image')) {
				$data['error'] = $this->upload->display_errors();
				$data['template'] = "category/storeCategory";
				$data['title'] = "Thêm mới danh mục";
				$this->load->view("admin-layout/admin-layout", $data);
			} else {
				$category_filename = $this->upload->data('file_name');
				$data = [
					'Name' => $this->input->post('Name'),
					'Slug' => $this->input->post('Slug'),
					'Description' => $this->input->post('Description'),
					'Image' => $category_filename,
					'Status' => $this->input->post('Status'),
				];
				$this->load->model('categoryModel');
				$this->categoryModel->insertcategory($data);
				$this->session->set_flashdata('success', 'Đã thêm danh mục thành công');
				redirect(base_url('category/list'));
			}
		} else {
			$this->session->set_flashdata('errors', $this->form_validation->error_array());
			$this->session->set_flashdata('input', $this->input->post());
			$this->createcategory();
		}
	}

	public function editcategory($id)
	{
		$this->config->config['pageTitle'] = 'Edit Category';
		$this->load->model('categoryModel');
		$data['category'] = $this->categoryModel->selectcategoryById($id);
		$data['title'] = "Chỉnh sửa danh mục";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Danh sách danh mục', 'url' => 'category/list'],
			['label' => 'Chỉnh sửa danh mục']
		];
		$data['template'] = "category/editcategory";
		$this->load->view("admin-layout/admin-layout", $data);
	}

	public function updateCategory($CategoryID)
	{
		$this->form_validation->set_rules('Name', 'Name', 'trim|required', ['required' => 'Bạn cần diền %s']);
		$this->form_validation->set_rules('Description', 'Description', 'trim|required', ['required' => 'Bạn cần điền %s']);
		$this->form_validation->set_rules('Slug', 'Slug', 'trim|required', ['required' => 'Bạn cần chọn %s']);


		if ($this->form_validation->run()) {

			if (!empty($_FILES['Image']['name'])) {
				// Upload Image
				$ori_filename = $_FILES['Image']['name'];
				$new_name = time() . "" . str_replace(' ', '-', $ori_filename);

				$config = [
					'upload_path' => './uploads/category',
					'allowed_types' => 'gif|jpg|png|jpeg',
					'file_name' => $new_name
				];
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('Image')) {
					$data['error'] = $this->upload->display_errors();
					$data['category'] = $this->categoryModel->selectCategory();
					$data['template'] = "category/storeCategory";
					$data['title'] = "Chỉnh sửa danh mục";
					$this->load->view("admin-layout/admin-layout", $data);
				} else {
					$category_filename = $this->upload->data('file_name');
					$data = [
						'Name' => $this->input->post('Name'),
						'Slug' => $this->input->post('Slug'),
						'Description' => $this->input->post('Description'),
						'Image' => $category_filename,
						'Status' => $this->input->post('Status'),
					];
				}
			} else {
				$data = [
					'Name' => $this->input->post('Name'),
					'Slug' => $this->input->post('Slug'),
					'Description' => $this->input->post('Description'),
					'Status' => $this->input->post('Status'),
				];
			}
			$this->load->model('categoryModel');
			$this->categoryModel->updateCategory($CategoryID, $data);
			$this->session->set_flashdata('success', 'Đã chỉnh sửa danh mục thành công');
			redirect(base_url('category/list'));
		} else {

			$this->editcategory($CategoryID);
		}
	}

	// public function bulkUpdateCategory(){
	// 	$category_ids = $this->input->post('category_ids');
	// 	$new_status = (int) $this->input->post('new_status');

	// 	$this->load->model('categoryModel');
	// 	$this->categoryModel->bulkupdateCategory($category_ids, $new_status);

	// }



	public function bulkUpdateCategory()
	{
		$category_ids = $this->input->post('category_ids');
		$new_status = (int) $this->input->post('new_status');

		if (empty($category_ids) || !is_array($category_ids)) {
			$this->session->set_flashdata('error', 'Cần chọn ít nhất một danh mục');
			redirect(base_url('category/list'));
			return;
		}

		if (!isset($new_status)) {
			$this->session->set_flashdata('error', 'Cần chọn trạng thái');
			redirect(base_url('category/list'));
			return;
		}

		$this->load->model('categoryModel');
		$this->categoryModel->bulkupdateCategory($category_ids, $new_status);
		$this->session->set_flashdata('success', 'Cập nhật trạng thái thành công');
		redirect(base_url('category/list'));
	}

	// public function deleteCategory($CategoryID)
	// {
	// 	$this->load->model('categoryModel');
	// 	$this->load->model('productModel');

	// 	// Kiểm tra xem danh mục có sản phẩm liên kết hay không
	// 	$categoryUsedInProducts = $this->categoryModel->checkCategoryInProducts($CategoryID);

	// 	if ($categoryUsedInProducts) {
	// 		// Nếu có sản phẩm sử dụng danh mục này, không cho phép xóa
	// 		$this->session->set_flashdata('error', 'Không thể xóa danh mục vì có sản phẩm đang sử dụng.');
	// 	} else {
	// 		// Nếu không có sản phẩm nào liên kết, thực hiện xóa
	// 		if ($this->categoryModel->deleteCategory($CategoryID)) {
	// 			$this->session->set_flashdata('success', 'Đã xóa danh mục thành công');
	// 		} else {
	// 			$this->session->set_flashdata('error', 'Xóa danh mục thất bại');
	// 		}
	// 	}

	// 	redirect(base_url('category/list'));
	// }
}
