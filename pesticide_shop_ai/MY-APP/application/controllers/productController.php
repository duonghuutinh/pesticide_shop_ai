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
 * @property categoryModel $categoryModel
 * @property brandModel $brandModel
 */

class productController extends CI_Controller
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


	// public function index($page = 1)
	// {
	// 	$this->config->config['pageTitle'] = 'List Products';
	// 	$this->load->model('indexModel');
	// 	$this->load->library('pagination');

	// 	$keyword  = $this->input->get('keyword', true);
	// 	$status   = $this->input->get('status', true);
	// 	$sort_stock = $this->input->get('sort_stock', true);
	// 	$perpage  = (int) $this->input->get('perpage');
	// 	$perpage  = $perpage > 0 ? $perpage : 10;

	// 	$total_products = $this->indexModel->countAllProduct($keyword, $status);

	// 	$page  = (int)$page;
	// 	$page  = ($page > 0) ? $page : 1;
	// 	$max_page = ceil($total_products / $perpage);
	// 	if ($page > $max_page && $total_products > 0) {
	// 		$query = http_build_query($this->input->get());
	// 		redirect(base_url('product/list') . ($query ? '?' . $query : ''));
	// 	}

	// 	$start = ($page - 1) * $perpage;


	// 	$data['products'] = $this->indexModel->getProductPagination($perpage, $start, $keyword, $status);
	// 	// echo '<pre>';
	// 	// print_r($data['products']);
	// 	// echo '</pre>';
	// 	$data['links'] = init_pagination(base_url('product/list'), $total_products, $perpage, 3);

	// 	$data['keyword'] = $keyword;
	// 	$data['status'] = $status;
	// 	$data['perpage'] = $perpage;
	// 	$data['title'] = "Danh sách sản phẩm";
	// 	$data['breadcrumb'] = [
	// 		['label' => 'Dashboard', 'url' => 'dashboard'],
	// 		['label' => 'Danh sách sản phẩm']
	// 	];
	// 	$data['start'] = $start;
	// 	$data['template'] = "product/index";
	// 	$this->load->view("admin-layout/admin-layout", $data);
	// }


	public function index($page = 1)
	{
		$this->config->config['pageTitle'] = 'List Products';
		$this->load->model('indexModel');
		$this->load->library('pagination');

		$keyword     = $this->input->get('keyword', true);
		$status      = $this->input->get('status', true);
		$sort_stock  = $this->input->get('sort_stock', true); // Lấy giá trị sắp xếp tồn kho
		$perpage     = (int) $this->input->get('perpage');
		$perpage     = $perpage > 0 ? $perpage : 10;

		$total_products = $this->indexModel->countAllProduct($keyword, $status);

		$page  = (int)$page;
		$page  = ($page > 0) ? $page : 1;
		$max_page = ceil($total_products / $perpage);
		if ($page > $max_page && $total_products > 0) {
			$query = http_build_query($this->input->get());
			redirect(base_url('product/list') . ($query ? '?' . $query : ''));
		}

		$start = ($page - 1) * $perpage;

		// Truyền thêm $sort_stock vào model
		$data['products'] = $this->indexModel->getProductPagination($perpage, $start, $keyword, $status, $sort_stock);

		$data['links'] = init_pagination(base_url('product/list'), $total_products, $perpage, 3);

		$data['keyword']     = $keyword;
		$data['status']      = $status;
		$data['perpage']     = $perpage;
		$data['sort_stock']  = $sort_stock; // Gửi về view để giữ lại lựa chọn lọc

		$data['title'] = "Danh sách sản phẩm";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Danh sách sản phẩm']
		];
		$data['start'] = $start;
		$data['template'] = "product/index";

		$this->load->view("admin-layout/admin-layout", $data);
	}





	public function createProduct()
	{
		$this->config->config['pageTitle'] = 'Create Product';
		// Load categories
		$this->load->model('categoryModel');
		$data['category'] = $this->categoryModel->selectCategory();
		// Load brand
		$this->load->model('brandModel');
		$data['brand'] = $this->brandModel->selectBrand();
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
		$data['title'] = "Thêm mới sản phẩm";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Thêm mới sản phẩm']
		];
		$data['template'] = "product/storeProduct";
		$this->load->view("admin-layout/admin-layout", $data);
	}





	public function storeProduct()
	{
		$this->form_validation->set_rules('Name', 'Name', 'trim|required', ['required' => 'Bạn cần điền tên sản phẩm']);
		$this->form_validation->set_rules('Slug', 'Slug', 'trim|required', ['required' => 'Bạn cần điền %s']);
		$this->form_validation->set_rules('Product_Code', 'Product_Code', 'trim|required', ['required' => 'Bạn cần điền mã sản phẩm']);
		$this->form_validation->set_rules('Description', 'Description', 'trim|required', ['required' => 'Bạn cần điền mô tả sản phẩm']);
		$this->form_validation->set_rules('Selling_price', 'Price', 'trim|required', ['required' => 'Bạn cần điền giá bán']);
		$this->form_validation->set_rules('Product_uses', 'Product_uses', 'trim|required', ['required' => 'Bạn cần điền công dụng sản phẩm']);
		$this->form_validation->set_rules('Unit', 'Unit', 'trim|required', ['required' => 'Bạn cần điền đơn vị tính']);
		// $this->form_validation->set_rules('Image', 'Hình ảnh', 'required', ['required' => 'Bạn cần chọn %s']);

		if ($this->form_validation->run()) {

			$ori_filename = $_FILES['Image']['name'];
			$new_name = time() . "" . str_replace(' ', '-', $ori_filename);
			$config = [
				'upload_path' => './uploads/product',
				'allowed_types' => 'gif|jpg|png|jpeg|webp',
				'file_name' => $new_name
			];
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('Image')) {
				$data['error'] = $this->upload->display_errors();
				$data['template'] = "product/storeProduct";
				$data['title'] = "Thêm mới sản phẩm";
				$this->load->view("admin-layout/admin-layout", $data);
			} else {
				$product_filename = $this->upload->data('file_name');
				$data = [
					'Name' => $this->input->post('Name'),
					'Description' => $this->input->post('Description'),
					'Product_Code' => $this->input->post('Product_Code'),
					'Product_uses' => $this->input->post('Product_uses'),
					'Slug' => $this->input->post('Slug'),
					'Selling_price' => $this->input->post('Selling_price'),
					'Unit' => $this->input->post('Unit'),
					'Promotion' => $this->input->post('Promotion'),
					'Image' => $product_filename,
					'Status' => $this->input->post('Status'),
					'BrandID' => $this->input->post('BrandID'),
					'CategoryID' => $this->input->post('CategoryID'),
				];
				// echo '<pre>';
				// print_r($data);
				// echo '</pre>';

				$this->load->model('productModel');
				$this->productModel->insertProduct($data);
				$this->session->set_flashdata('success', 'Đã thêm sản phẩm thành công');
				redirect(base_url('product/list'));
			}
		} else {
			$this->session->set_flashdata('error', 'Tạo sản phẩm thất bại, Vui lòng thử lại');
			$this->createProduct();
		}
	}

	// private function loadProductForm($data = [])
	// {
	// 	$this->load->model('brandModel');
	// 	$this->load->model('categoryModel');
	// 	$data['brand'] = $this->brandModel->getAllBrands();
	// 	$data['category'] = $this->categoryModel->getAllCategories();
	// 	$data['template'] = "product/storeProduct";
	// 	$data['title'] = "Thêm mới sản phẩm";
	// 	$this->load->view("admin-layout/admin-layout", $data);
	// }


	public function editProduct($ProductID)
	{
		$this->config->config['pageTitle'] = 'Edit Product';
		$this->load->model('categoryModel');
		$data['category'] = $this->categoryModel->selectCategory();
		$this->load->model('brandModel');
		$data['brand'] = $this->brandModel->selectBrand();
		$this->load->model('productModel');
		$data['product'] = $this->productModel->selectProductById($ProductID);

		// echo '<pre>';
		// print_r($data['product'] );
		// echo '</pre>';

		$data['title'] = "Chỉnh sửa sản phẩm";
		$data['breadcrumb'] = [
			['label' => 'Dashboard', 'url' => 'dashboard'],
			['label' => 'Danh sách sản phẩm', 'url' => 'product/list'],
			['label' => 'Chỉnh sửa sản phẩm']
		];
		$data['template'] = "product/editProduct";
		$this->load->view("admin-layout/admin-layout", $data);
	}

	public function updateProduct($ProductID)
	{
		$this->form_validation->set_rules('Name', 'Name', 'trim|required', ['required' => 'Bạn cần diền %s']);
		$this->form_validation->set_rules('Slug', 'Slug', 'trim|required', ['required' => 'Bạn cần diền %s']);
		$this->form_validation->set_rules('Description', 'Description', 'trim|required', ['required' => 'Bạn cần điền %s']);
		$this->form_validation->set_rules('Selling_price', 'Price', 'trim|required', ['required' => 'Bạn cần diền %s']);
		$this->form_validation->set_rules('Product_uses', 'Product_uses', 'trim|required', ['required' => 'Bạn cần diền %s']);
		$this->form_validation->set_rules('Unit', 'Unit', 'trim|required', ['required' => 'Bạn cần điền %s']);


		if ($this->form_validation->run()) {

			if (!empty($_FILES['Image']['name'])) {
				// Upload Image
				$ori_filename = $_FILES['Image']['name'];
				$new_name = time() . "" . str_replace(' ', '-', $ori_filename);
				$config = [
					'upload_path' => './uploads/product',
					'allowed_types' => 'gif|jpg|png|jpeg',
					'file_name' => $new_name
				];
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('Image')) {
					$data['error'] = $this->upload->display_errors();
					$data['template'] = "product/storeProduct";
					$data['title'] = "Chỉnh sửa sản phẩm";
					$this->load->view("admin-layout/admin-layout", $data);
				} else {
					$product_filename = $this->upload->data('file_name');
					$data = [
						'Name' => $this->input->post('Name'),
						'Description' => $this->input->post('Description'),
						'Product_uses' => $this->input->post('Product_uses'),
						'Slug' => $this->input->post('Slug'),
						'Selling_price' => $this->input->post('Selling_price'),
						'Unit' => $this->input->post('Unit'),
						'Promotion' => $this->input->post('Promotion'),
						'Image' => $product_filename,
						'Status' => $this->input->post('Status'),
						'BrandID' => $this->input->post('BrandID'),
						'CategoryID' => $this->input->post('CategoryID'),
					];
				}
			} else {
				$data = [
					'Name' => $this->input->post('Name'),
					'Description' => $this->input->post('Description'),
					'Product_uses' => $this->input->post('Product_uses'),
					'Slug' => $this->input->post('Slug'),
					'Selling_price' => $this->input->post('Selling_price'),
					'Unit' => $this->input->post('Unit'),
					'Promotion' => $this->input->post('Promotion'),
					'Status' => $this->input->post('Status'),
					'BrandID' => $this->input->post('BrandID'),
					'CategoryID' => $this->input->post('CategoryID'),
				];
			}
			$this->load->model('productModel');
			$this->productModel->updateProduct($ProductID, $data);
			$this->session->set_flashdata('success', 'Đã chỉnh sửa sản phẩm thành công');
			redirect(base_url('product/list'));
		} else {
			$this->editProduct($ProductID);
		}
	}



	public function bulkUpdateProduct()
	{
		$product_ids = $this->input->post('product_ids');
		$action = $this->input->post('action');

		// echo '<pre>';
		// print_r($action);
		// echo '</pre>';


		if (empty($product_ids)) {
			$this->session->set_flashdata('error', 'Vui lòng chọn ít nhất một sản phẩm.');
			redirect(base_url('product/list'));
		}
		

		$this->load->model('productModel');

		if ($action === 'update_status') {
			$status = $this->input->post('new_status');

			if (!isset($status) && $status != 1 && $status != 0) {
				$this->session->set_flashdata('error', 'Cần chọn trạng thái');
				redirect(base_url('product/list'));
				return;
			}
			$new_status = (int)$status;

			$this->productModel->bulkUpdateStatus($product_ids, $new_status);
			$this->session->set_flashdata('success', 'Cập nhật trạng thái thành công');
		} elseif ($action === 'update_promotion') {
			$promotion = $this->input->post('promotion');

			if (!isset($promotion) && $promotion != 1 && $promotion != 0 ) {
				$this->session->set_flashdata('error', 'Cần nhập % giảm giá');
				redirect(base_url('product/list'));
				return;
			}
			$new_promotion = (int)$promotion;
			if ($promotion >= 0 && $promotion <= 100) {
				$this->productModel->bulkUpdatePromotion($product_ids, $new_promotion);
				$this->session->set_flashdata('success', 'Cập nhật giảm giá thành công');
			} else {
				$this->session->set_flashdata('error', 'Giảm giá phải từ 0 đến 100');
			}
		}

		redirect(base_url('product/list'));
	}





	// public function bulkUpdateProduct()
	// {

	// 	$product_ids = $this->input->post('product_ids');
	// 	$new_status = (int) $this->input->post('new_status');



	// 	$this->load->model('productModel');
	// 	$this->productModel->bulkUpdateProduct($product_ids, $new_status);
	// }



	// public function deleteProduct($id)
	// {
	// 	$this->load->model('productModel');
	// 	$result = $this->productModel->deleteProduct($id);

	// 	if ($result['status']) {
	// 		$this->session->set_flashdata('success', $result['message']);
	// 	} else {
	// 		$this->session->set_flashdata('error', $result['message']);
	// 	}

	// 	redirect(base_url('product/list'));
	// }


}
