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
 * @property upload $upload
 */


class brandController extends CI_Controller
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
		$this->config->config['pageTitle'] = 'List Brand';
		$this->load->model('brandModel');
		$this->load->helper('pagination');

		$keyword  = $this->input->get('keyword', true);
		$status   = $this->input->get('status', true);
		$perpage  = (int) $this->input->get('perpage');
		$perpage  = $perpage > 0 ? $perpage : 10;

		$total = $this->brandModel->countBrand($keyword, $status);

		$page = (int) $page;
		$page = $page > 0 ? $page : 1;
		$max_page = ceil($total / $perpage);

		if ($page > $max_page && $total > 0) {
			$query = http_build_query($this->input->get());
			redirect(base_url('brand/list') . ($query ? '?' . $query : ''));
		}

		$start = ($page - 1) * $perpage;

		$data['brand'] = $this->brandModel->selectBrand($keyword, $status, $perpage, $start);
		$data['links'] = init_pagination(base_url('brand/list'), $total, $perpage, 3);

		$data['status']     = $status;
		$data['keyword']    = $keyword;
		$data['perpage']    = $perpage;
		$data['start']      = $start;
		$data['title']      = "Danh sách thương hiệu";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Danh sách thương hiệu']
		];
		$data['template'] = "brand/index";

		$this->load->view("admin-layout/admin-layout", $data);
	}


	public function createBrand()
	{
		$this->config->config['pageTitle'] = 'Create Brand';
		$this->load->model('brandModel');
		$data['errors'] = $this->session->flashdata('errors');
		$data['input'] = $this->session->flashdata('input');
		$data['brand'] = $this->brandModel->selectBrand();
		$data['title'] = "Thêm mới thương hiệu";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Thêm mới thương hiệu']
		];
		$data['template'] = "brand/storeBrand";
		$this->load->view("admin-layout/admin-layout", $data);
	}



	public function storageBrand()
	{
		$this->form_validation->set_rules('Name', 'Name', 'trim|required', ['required' => 'Bạn cần điền tên thương hiệu']);
		$this->form_validation->set_rules('Description', 'Description', 'trim|required', ['required' => 'Bạn cần điền mô tả']);
		$this->form_validation->set_rules('Slug', 'Slug', 'trim|required', ['required' => 'Bạn cần chọn %s']);

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
				'upload_path' => './uploads/brand',
				'allowed_types' => 'gif|jpg|png|jpeg',
				'file_name' => $new_name
			];
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('Image')) {
				$data['error'] = $this->upload->display_errors();
				$data['template'] = "brand/storeBrand";
				$data['title'] = "Thêm mới thương hiệu";
				$this->load->view("admin-layout/admin-layout", $data);
			} else {
				$brand_filename = $this->upload->data('file_name');
				$data = [
					'Name' => $this->input->post('Name'),
					'Slug' => $this->input->post('Slug'),
					'Description' => $this->input->post('Description'),
					'Image' => $brand_filename,
					'Status' => $this->input->post('Status'),
				];
				$this->load->model('brandModel');
				$this->brandModel->insertBrand($data);
				$this->session->set_flashdata('success', 'Đã thêm thương hiệu thành công');
				redirect(base_url('brand/list'));
			}
		} else {
			$this->session->set_flashdata('errors', $this->form_validation->error_array());
			$this->session->set_flashdata('input', $this->input->post());
			redirect(base_url('brand/create'));
		}
	}

	public function editBrand($BrandID)
	{
		$this->config->config['pageTitle'] = 'Edit Brand';
		$this->load->model('brandModel');
		$data['brand'] = $this->brandModel->selectBrandById($BrandID);
		$data['title'] = "Chỉnh sửa thương hiệu";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Danh sách thương hiệu', 'url' => 'brand/list'],
			['label' => 'Chỉnh sửa thương hiệu']
		];
		$data['template'] = "brand/editBrand";
		$this->load->view("admin-layout/admin-layout", $data);
	}

	// public function updateBrand($BrandID)
	// {
	// 	$this->form_validation->set_rules('Name', 'Name', 'trim|required', ['required' => 'Bạn cần diền %s']);
	// 	$this->form_validation->set_rules('Description', 'Description', 'trim|required', ['required' => 'Bạn cần điền %s']);
	// 	$this->form_validation->set_rules('Slug', 'Slug', 'trim|required', ['required' => 'Bạn cần chọn %s']);


	// 	if ($this->form_validation->run()) {

	// 		if (!empty($_FILES['Image']['name'])) {
	// 			// Upload Image
	// 			$ori_filename = $_FILES['image']['name'];
	// 			$new_name = time() . "" . str_replace(' ', '-', $ori_filename);
	// 			$config = [
	// 				'upload_path' => './uploads/brand',
	// 				'allowed_types' => 'gif|jpg|png|jpeg',
	// 				'file_name' => $new_name
	// 			];
	// 			$this->load->library('upload', $config);

	// 			if (!$this->upload->do_upload('Image')) {
	// 				$error = array('error' => $this->upload->display_errors());
	// 				$data['template'] = "brand/createBrand";
	// 				$data['title'] = "Thêm mới thương hiệu";
	// 				$this->load->view("admin-layout/admin-layout", $data);
	// 			} else {
	// 				$brand_filename = $this->upload->data('file_name');
	// 				$data = [
	// 					'Name' => $this->input->post('Name'),
	// 					'Slug' => $this->input->post('Slug'),
	// 					'Description' => $this->input->post('Description'),
	// 					'Image' => $brand_filename,
	// 					'Status' => $this->input->post('Status'),
	// 				];
	// 			}
	// 		} else {
	// 			$data = [
	// 				'Name' => $this->input->post('Name'),
	// 				'Slug' => $this->input->post('Slug'),
	// 				'Description' => $this->input->post('Description'),
	// 				'Status' => $this->input->post('Status'),
	// 			];
	// 		}
	// 		$this->load->model('brandModel');
	// 		$result = $this->brandModel->updateBrand($BrandID, $data);
	// 		if ($result) {
	// 			$this->session->set_flashdata('success', 'Đã chỉnh sửa thương hiệu thành công');
	// 		} else {
	// 			$this->session->set_flashdata('error', 'Có lỗi xảy ra');
	// 		}


	// 		redirect(base_url('brand/list'));
	// 	} else {
	// 		$this->editBrand($BrandID);
	// 	}
	// }



	public function updateBrand($BrandID)
	{
		$this->load->model('brandModel');
		$this->load->library(['form_validation', 'upload']);

		// Validate dữ liệu nhập vào
		$this->form_validation->set_rules('Name', 'Tên thương hiệu', 'trim|required', ['required' => 'Bạn cần điền %s']);
		$this->form_validation->set_rules('Description', 'Mô tả', 'trim|required', ['required' => 'Bạn cần điền %s']);
		$this->form_validation->set_rules('Slug', 'Slug', 'trim|required', ['required' => 'Chưa có Slug']);

		if (!$this->form_validation->run()) {
			return $this->editBrand($BrandID);
		}

		$old_data = $this->brandModel->selectBrandById($BrandID);

		$new_data = [
			'Name' => $this->input->post('Name'),
			'Slug' => $this->input->post('Slug'),
			'Description' => $this->input->post('Description'),
			'Status' => $this->input->post('Status'),
		];

		if (!empty($_FILES['Image']['name'])) {
			$ori_filename = $_FILES['Image']['name'];
			$new_name = time() . '-' . url_title($ori_filename);
			$config = [
				'upload_path'   => './uploads/brand/',
				'allowed_types' => 'gif|jpg|png|jpeg',
				'file_name'     => $new_name,
				'overwrite'     => true,
			];
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('Image')) {
				$data = [
					'brand' => $old_data,
					'error' => $this->upload->display_errors(),
					'template' => "brand/editBrand",
					'title' => "Chỉnh sửa thương hiệu",
					'breadcrumb' => [
						['label' => 'Dashboard', 'url' => 'dashboard'],
						['label' => 'Danh sách thương hiệu', 'url' => 'brand/list'],
						['label' => 'Chỉnh sửa thương hiệu']
					]
				];
				return $this->load->view("admin-layout/admin-layout", $data);
			} else {
				$upload_data = $this->upload->data();
				$new_data['Image'] = $upload_data['file_name'];
			}
		}

		if ($this->_is_same_data($old_data, $new_data)) {
			$this->session->set_flashdata('info', 'Không có thay đổi nào để lưu.');
			return $this->editBrand($BrandID);
		} else {
			$result = $this->brandModel->updateBrand($BrandID, $new_data);
			if ($result) {
				$this->session->set_flashdata('success', 'Đã chỉnh sửa thương hiệu thành công.');
			} else {
				$this->session->set_flashdata('error', 'Có lỗi xảy ra khi cập nhật.');
			}
		}

		redirect(base_url('brand/list'));
	}




	public function bulkUpdateBrand()
	{
		$brand_ids = $this->input->post('brand_ids');
		$new_status = (int) $this->input->post('new_status');

		// echo '<pre>';
		// print_r($brand_ids);
		// echo '</pre>';

		// echo $new_status; die();


		if (empty($brand_ids) || !is_array($brand_ids)) {
			$this->session->set_flashdata('error', 'Cần chọn ít nhất một nhà cung cấp');
			redirect(base_url('brand/list'));
			return;
		}

		if (!isset($new_status)) {
			$this->session->set_flashdata('error', 'Cần chọn trạng thái');
			redirect(base_url('brand/list'));
			return;
		}

		$this->load->model('brandModel');
		$this->brandModel->bulkupdateBrand($brand_ids, $new_status);
		$this->session->set_flashdata('success', 'Cập nhật trạng thái thành công');
		redirect(base_url('brand/list'));
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
	// public function deleteBrand($BrandID)
	// {
	// 	$this->load->model('brandModel');
	// 	$this->load->model('productModel');

	// 	$brandUsedInProducts = $this->brandModel->checkBrandInProducts($BrandID);

	// 	if ($brandUsedInProducts) {
	// 		$this->session->set_flashdata('error', 'Không thể xóa thương hiệu vì có sản phẩm đang sử dụng.');
	// 	} else {

	// 		if ($this->brandModel->deleteBrand($BrandID)) {
	// 			$this->session->set_flashdata('success', 'Đã xóa thương hiệu thành công');
	// 		} else {
	// 			$this->session->set_flashdata('error', 'Xóa thương hiệu thất bại');
	// 		}
	// 	}
	// 	redirect(base_url('brand/list'));
	// }
}
