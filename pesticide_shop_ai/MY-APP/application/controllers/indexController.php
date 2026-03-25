<?php
defined('BASEPATH') or exit('No direct script access allowed');



/**
 * @property session $session
 * @property config $config
 * @property form_validation $form_validation
 * @property input $input
 * @property load $load
 * @property data $data
 * @property IndexModel $IndexModel
 * @property pagination $pagination
 * @property uri $uri
 * @property SliderModel $SliderModel
 * @property email $email
 * @property cart $cart
 * @property orderModel $orderModel
 * @property productModel $productModel
 * @property page $page
 * @property customerModel $customerModel
 * @property loginModel $loginModel
 * @property reviewModel $reviewModel 
 * @property upload $upload

 * 
 */




class IndexController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}


		$this->load->model('IndexModel');
		$this->load->model('SliderModel');
		$this->load->library('cart');
		$this->data['brand'] = $this->IndexModel->getBrandHome();
		$this->data['category'] = $this->IndexModel->getCategoryHome();
	}
	public function page_404()
	{
		$this->load->view('pages/component/page404');
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

		// Ưu tiên lấy admin nếu có, nếu không thì lấy customer
		if ($this->session->userdata('logged_in_admin')) {
			return $this->session->userdata('logged_in_admin');
		} elseif ($this->session->userdata('logged_in_customer')) {
			return $this->session->userdata('logged_in_customer');
		}

		return null;
	}



	

	public function index()
	{

		$this->load->helper('pagination');
		$this->load->library('pagination');
		$this->load->model('IndexModel');
		$total_products = $this->IndexModel->countAllProduct();
		$per_page = 6;
		$uri_segment = 3;
		$base_url = base_url('pagination/index');

		$this->data['links'] = init_pagination($base_url, $total_products, $per_page, $uri_segment);

		$page = (int) $this->uri->segment($uri_segment);
		$page = ($page > 0) ? $page : 1;
		$start = ($page - 1) * $per_page;

		$this->data['allproduct_pagination'] = $this->IndexModel->getIndexPagination($per_page, $start);
		$this->data['bestsellers'] = $this->IndexModel->getBestSellingProducts(6);

		// echo '<pre>';
		// print_r($this->data['allproduct_pagination']);
		// echo '</pre>';


		$this->data['sliders'] = $this->SliderModel->selectAllSlider();
		$this->data['template'] = "pages/home/home";

		$this->load->view("pages/layout/index", $this->data);
	}




	public function search_product()
	{
		$this->load->helper('pagination');
		$this->load->library('pagination');

		$keyword = $this->input->get('keyword', TRUE);
		$per_page = 6;
		$uri_segment = 3;
		$base_url = base_url('search-product');

		$total_products = $this->IndexModel->countSearchProduct($keyword);
		$this->data['links'] = init_pagination($base_url, $total_products, $per_page, $uri_segment);

		$page = (int) $this->uri->segment($uri_segment);
		$page = ($page > 0) ? $page : 1;
		$start = ($page - 1) * $per_page;

		$this->data['allproduct_pagination'] = $this->IndexModel->getSearchProductPagination($keyword, $per_page, $start);
		$this->data['sliders'] = $this->SliderModel->selectAllSlider();
		$this->data['template'] = "pages/home/home";

		$this->load->view("pages/layout/index", $this->data);
	}



	public function product_on_sale()
	{
		$this->load->library('pagination');

		$keyword = $this->input->get('keyword');
		$total_rows = $this->IndexModel->countProductOnSale($keyword);

		$per_page = 6;
		$uri_segment = 2;
		$base_url = base_url('product-on-sale');

		$this->data['links'] = init_pagination($base_url, $total_rows, $per_page, $uri_segment);

		$page_segment = $this->uri->segment($uri_segment);
		$page = (!empty($page_segment) && is_numeric($page_segment)) ? (int)$page_segment : 1;
		$start = ($page - 1) * $per_page;

		$this->data['products_sale'] = $this->IndexModel->getProductOnSalePagination($per_page, $start, $keyword);
		$this->data['template'] = 'pages/home/productSale';
		$this->load->view('pages/layout/index', $this->data);
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


	public function checkout()
	{
		$this->config->config['pageTitle'] = 'Checkout';
		if ($this->session->userdata('logged_in_customer') || $this->session->userdata('logged_in_admin')) {
			if ($this->cart->contents()) {
				$this->data['template'] = "pages/checkout/checkout";
				$this->load->view("pages/layout/index", $this->data);
			} else {
				$this->session->set_flashdata('info', 'Bạn chưa có sản phẩm trong giỏ hàng');
				redirect(base_url() . 'gio-hang');
			}
		} else {
			$this->session->set_flashdata('error', 'Vui lòng đăng nhập để thực hiện đặt hàng');
			redirect(base_url() . 'gio-hang');
		}
	}


	public function applyCoupon()
	{
		$this->load->model('IndexModel');
		$coupon_code = $this->input->post('coupon_code', TRUE);
		$cart_total = $this->cart->total();

		$coupon = $this->IndexModel->getValidCoupon($coupon_code);

		if (!$coupon) {
			$this->session->set_flashdata('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn');
			redirect($_SERVER['HTTP_REFERER']);
		}

		if ($cart_total < $coupon->Min_order_value) {
			$this->session->set_flashdata('error', 'Đơn hàng chưa đạt giá trị tối thiểu để sử dụng mã giảm giá này');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$discount = 0;

		if ($coupon->Discount_type == 'Percentage') {
			$discount = ($cart_total * $coupon->Discount_value) / 100;
			if ($coupon->Max_discount && $discount > $coupon->Max_discount) {
				$discount = $coupon->Max_discount;
			}
		} elseif ($coupon->Discount_type == 'Fixed') {
			$discount = $coupon->Discount_value;
		}


		$this->session->set_userdata('coupon_code', $coupon->Coupon_code);
		$this->session->set_userdata('coupon_discount', $discount);
		$this->session->set_userdata('coupon_id', $coupon->DiscountID);

		$this->session->set_flashdata('success', 'Áp dụng mã giảm giá thành công');

		redirect($_SERVER['HTTP_REFERER']);
	}




	public function listOrder()
	{
		$this->config->config['pageTitle'] = 'List Order';
		$user_id = $this->getUserOnSession();

		// Load model
		$this->load->model('orderModel');
		$this->load->model('productModel');
		$this->load->model('IndexModel');


		$order_items = $this->orderModel->getOrderByUserId($user_id['id']);

		if (!empty($order_items)) {
			foreach ($order_items as $order_item) {
				$product_details = $this->productModel->selectProductById($order_item->ProductID);
				$order_item->product_details = $product_details;

				// Thêm cờ đánh giá
				if ($order_item->Order_Status == 4) {
					$order_item->has_reviewed_all_products = $this->IndexModel->getReviewStatusOfOrder($order_item->Order_Code, $user_id['id']);
				} else {
					$order_item->has_reviewed_all_products = false;
				}
			}
		} else {
			$this->session->set_flashdata('error', 'Không có đơn hàng nào');
		}

		// Truyền dữ liệu cho view
		$this->data['order_items'] = $order_items;
		$this->data['template'] = 'pages/order/listOrder';

		// echo '<pre>';
		// print_r($this->data);
		// echo '</pre>'; die();


		$this->load->view('pages/layout/index', $this->data);
	}


	public function reviewProducts($Order_Code)
	{
		$user_id = $this->getUserOnSession();
		$products = $this->IndexModel->getReviewableProducts($Order_Code, $user_id['id']);

		// echo '<pre>';
		// print_r($products);
		// echo '</pre>';

		$allReviewed = true;
		foreach ($products as $product) {
			if ($product->has_reviewed == 0) {
				$allReviewed = false;
				break;
			}
		}

		if ($allReviewed) {
			$this->session->set_flashdata('info', 'Bạn đã đánh giá tất cả sản phẩm trong đơn hàng này.');
			redirect('order_customer/viewOrder/' . $Order_Code);
			return;
		}


		$this->config->config['pageTitle'] = 'Đánh giá sản phẩm';
		$this->data['all_product_in_order'] = $products;
		$this->data['Order_Code'] = $Order_Code;
		// $this->data['template'] = 'pages/review/reviewProducts';
		$this->data['template'] = 'pages/review/test';
		$this->load->view("pages/layout/index", $this->data);
	}

	public function submitReviews()
	{
		$user = $this->getUserOnSession();
		$user_id = $user['id'];
		$Order_Code = $this->input->post('Order_Code');
		$reviews = $this->input->post('reviews');

		if (empty($reviews)) {
			$this->session->set_flashdata('error', 'Không có đánh giá nào được gửi.');
			redirect('review/order/' . $Order_Code);
		}

		// Reset validation mỗi vòng lặp để tránh lỗi chồng rules
		$this->load->library('form_validation');
		$errors = [];

		foreach ($reviews as $index => $review) {
			$this->form_validation->set_rules("reviews[$index][rating]", 'số sao', 'required|greater_than[0]|less_than[6]', [
				'required' => 'Bạn cần chọn %s.',
				'greater_than' => 'Số sao phải lớn hơn 0.',
				'less_than' => 'Số sao phải nhỏ hơn hoặc bằng 5.'
			]);

			$this->form_validation->set_rules("reviews[$index][comment]", 'Nhận xét', 'trim|required|min_length[5]', [
				'required' => 'Bạn chưa nhập nhận xét cho sản phẩm.',
				'min_length' => 'Nhận xét cần ít nhất 5 ký tự.'
			]);
		}

		if ($this->form_validation->run() == FALSE) {
			// Gộp lỗi chi tiết để hiển thị ở view
			foreach ($reviews as $index => $review) {
				$errors[$index]['rating']  = form_error("reviews[$index][rating]");
				$errors[$index]['comment'] = form_error("reviews[$index][comment]");
			}

			$this->session->set_flashdata('error', 'Vui lòng kiểm tra lại các đánh giá.');
			$this->session->set_flashdata('old_inputs', $reviews);
			$this->session->set_flashdata('errors', $errors);

			redirect('review/order/' . $Order_Code);
			return;
		}

		// Nếu hợp lệ thì lưu
		$data_to_insert = [];
		$time_now = Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();

		foreach ($reviews as $review) {
			$product_id = (int)$review['ProductID'];
			$rating = (int)$review['rating'];
			$comment = trim($review['comment']);

			$data_to_insert[] = [
				'ProductID' => $product_id,
				'UserID' => $user_id,
				'rating' => $rating,
				'comment' => $comment,
				'created_at' => $time_now,
				'is_active' => 0,
			];
		}

		$this->IndexModel->insertReviews($data_to_insert);
		$this->session->set_flashdata('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
		redirect('order_customer/listOrder');
	}


	public function viewOrder($order_code)
	{

		$this->load->model('orderModel');
		$this->load->model('productModel');
		$data['order_details'] = $this->orderModel->selectOrderDetails($order_code);
		foreach ($data['order_details'] as $order_detail) {
			$product_details = $this->productModel->selectProductById($order_detail->ProductID);
			$order_detail->product_details = $product_details;
		}
		$this->data['order_details'] = $data['order_details'];
		$this->data['template'] = 'pages/order/viewOrder';
		$this->load->view("pages/layout/index", $this->data);
	}

	public function deleteOrder($order_code)
	{
		$this->load->model('orderModel');
		$status = $this->orderModel->selectOrderDetails($order_code)['order_status'];
		$del_order_details = $this->orderModel->deleteOrderDetails($order_code);
		$del = $this->orderModel->deleteOrder($order_code);
		if ($del && $del_order_details) {
			$this->session->set_flashdata('success', 'Xóa đơn hàng thành công');
			redirect(base_url('order_customer/listOrder'));
		} else {
			$this->session->set_flashdata('error', 'Xóa đơn hàng thất bại');
			redirect(base_url('order-customer/listOrder'));
		}
	}


	public function category($CategoryID)
	{
		$this->data['slug'] = $this->IndexModel->getCategorySlug($CategoryID);
		//custom config link
		$config = array();
		$config["base_url"] = base_url() . '/pagination/danh-muc/' . '/' . $CategoryID . '/' . $this->data['slug'];
		$config['total_rows'] = ceil($this->IndexModel->countAllProductByCate($CategoryID));
		$config["per_page"] = 6; //từng trang 3 sản phẩn
		$config["uri_segment"] = 5; //lấy số trang hiện tại
		$config['use_page_numbers'] = TRUE; //trang có số
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		//end custom config link
		$this->pagination->initialize($config); //tự động tạo trang
		$this->page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0; //current page active 
		$this->data["links"] = $this->pagination->create_links(); //tự động tạo links phân trang dựa vào trang hiện tại

		// Lấy giá thấp nhất và lớn nhất
		$min_price = $this->data['min_price'] = $this->IndexModel->getMinPriceProduct($CategoryID);
		$max_price = $this->data['max_price'] = $this->IndexModel->getMaxPriceProduct($CategoryID);



		// Filter
		if (isset($_GET['kytu'])) {
			$kytu = $_GET['kytu'];
			$this->data['allproductbycate_pagination'] = $this->IndexModel->getCategoryKyTuPagination($CategoryID, $kytu, $config["per_page"], $this->page);
		} elseif (isset($_GET['gia'])) {
			$kytu = $_GET['gia'];
			$this->data['allproductbycate_pagination'] = $this->IndexModel->getCategoryPricePagination($CategoryID, $kytu, $config["per_page"], $this->page);
		} elseif (isset($_GET['to']) && isset($_GET['from'])) {
			$from_price = $_GET['from'];
			$to_price = $_GET['to'];
			$this->data['allproductbycate_pagination'] = $this->IndexModel->getCategoryPriceRangePagination($CategoryID, $from_price, $to_price, $config["per_page"], $this->page);
		} else {
			$this->data['allproductbycate_pagination'] = $this->IndexModel->getCategoryPagination($CategoryID, $config["per_page"], $this->page);
		}




		// $this->data['category_Product'] = $this->IndexModel->getCategoryProduct($id);
		$this->data['Name'] = $this->IndexModel->getCategoryName($CategoryID);
		$this->config->config['pageTitle'] = $this->data['Name'];

		$this->data['template'] = "pages/category/category";
		$this->load->view("pages/layout/index", $this->data);
	}
	public function brand($BrandID)
	{

		$this->data['slug'] = $this->IndexModel->getBrandSlug($BrandID);
		//custom config link
		$config = array();
		$config["base_url"] = base_url() . '/pagination/thuong-hieu/' . '/' . $BrandID . '/' . $this->data['slug'];
		$config['total_rows'] = ceil($this->IndexModel->countAllProductByBrand($BrandID)); //đếm tất cả sản phẩm //8 //hàm ceil làm tròn phân trang 
		$config["per_page"] = 6; //từng trang 3 sản phẩn
		$config["uri_segment"] = 5; //lấy số trang hiện tại
		$config['use_page_numbers'] = TRUE; //trang có số
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		//end custom config link
		$this->pagination->initialize($config); //tự động tạo trang
		$this->page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0; //current page active 
		$this->data["links"] = $this->pagination->create_links(); //tự động tạo links phân trang dựa vào trang hiện tại
		// Giới hạn sản phẩm trong trang (limit, start)
		$this->data['allproductbybrand_pagination'] = $this->IndexModel->getbrandPagination($BrandID, $config["per_page"], $this->page);


		$this->data['Name'] = $this->IndexModel->getBrandName($BrandID);
		$this->config->config['pageTitle'] = $this->data['Name'];
		$this->data['template'] = "pages/brand/brand";
		$this->load->view("pages/layout/index", $this->data);
	}





	public function product($ProductID)
	{
		$this->load->model("IndexModel");
		$this->load->model("reviewModel");
		$this->data['product_details'] = $this->IndexModel->getProductDetails($ProductID);

		$this->data['product_reviews'] = $this->reviewModel->getActiveReviewsByProductId($ProductID);

		$this->load->model("RecommendModel");
		$this->data['recommendations'] = $this->RecommendModel->getRecommendations($ProductID, 4);
		// echo '<pre>';
		// print_r($this->data['product_reviews']);
		// echo '</pre>';

		$this->data['title'] = $this->IndexModel->getProductName($ProductID);
		$this->config->config['pageTitle'] = $this->data['title'];

		$this->data['template'] = "pages/product-detail/product-detail";
		$this->load->view("pages/layout/index", $this->data);
	}

	public function cart()
	{
		$this->config->config['pageTitle'] = 'Giỏ hàng';
		$this->data['template'] = "pages/cart/cart";
		$this->load->view("pages/layout/index", $this->data);
	}

	public function add_to_cart()
	{
		$ProductID = $this->input->post('ProductID');
		$Quantity = $this->input->post('Quantity');
		$product = $this->IndexModel->getProductDetails($ProductID);

		if (!$product) {

			$this->session->set_flashdata('error', 'Sản phẩm không tồn tại.');
			redirect($_SERVER['HTTP_REFERER']);
		}
		foreach ($this->cart->contents() as $items) {
			if ($items['id'] == $ProductID) {
				$this->session->set_flashdata('error', 'Mặt hàng bạn đặt đã tồn tại trong giỏ hàng. Vui lòng vào giỏ hàng chỉnh sửa số lượng.');
				redirect(base_url() . 'gio-hang', 'refresh');
			}
		}
		if ($Quantity > $product->total_remaining) {
			$this->session->set_flashdata('error', 'Số lượng bạn chọn vượt quá số lượng tồn kho. Vui lòng chọn lại.');
			redirect($_SERVER['HTTP_REFERER']);
		}
		$Selling_price = isset($product->Promotion) && $product->Promotion > 0
			? $product->Selling_price * (1 - $product->Promotion / 100)
			: $product->Selling_price;
		$cart = array(
			'id' => $product->ProductID,
			'qty' => $Quantity,
			'price' => $Selling_price,
			'name' => $product->Name,
			'options' => array(
				'image' => $product->Image,
				'in_stock' => $product->total_remaining
			)
		);
		$this->cart->insert($cart);
		$this->session->set_flashdata('success', 'Thêm vào giỏ hàng thành công.');
		redirect(base_url() . 'gio-hang', 'refresh');
	}

	public function update_cart_item()
	{
		$rowid = $this->input->post('rowid');
		$quantity = $this->input->post('quantity');
		foreach ($this->cart->contents() as $items) {
			if ($rowid == $items['rowid']) {
				if ($quantity <= $items['options']['in_stock']) {
					$cart = array(
						'rowid' => $rowid,
						'qty' => $quantity
					);
				} else {
					$cart = array(
						'rowid' => $rowid,
						'qty' => $items['options']['in_stock']
					);
				}
			}
		}
		$this->cart->update($cart);
		// redirect(base_url().'gio-hang', 'refresh');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete_all_cart()
	{
		$this->cart->destroy();
		redirect(base_url() . 'gio-hang', 'refresh');
	}
	public function delete_item($rowid)
	{
		$this->cart->remove($rowid);
		redirect(base_url() . 'gio-hang', 'refresh');
	}

	public function login()
	{
		$this->config->config['pageTitle'] = 'Đăng nhập';
		$this->data['template'] = "pages/login/login";
		$this->load->view("pages/layout/index", $this->data);
	}


	public function profile_user()
	{

		$this->config->config['pageTitle'] = 'Chỉnh sửa thông tin';
		$user_id = $this->getUserOnSession();


		if ($user_id) {
			$this->load->model('customerModel');
			$profile_user = $this->customerModel->selectCustomerById($user_id['id']);

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


	public function editCustomer($user_id)
	{
		$this->config->config['pageTitle'] = 'Chỉnh sửa thông tin người dùng';

		$user_id = $this->getUserOnSession();

		if ($user_id) {
			$this->load->model('customerModel');
			$profile_user = $this->customerModel->selectCustomerById($user_id['id']);

			if ($profile_user) {
				$this->load->view('pages/customer/editCustomer', ['profile_user' => $profile_user]);
			} else {
				echo 'Không tìm thấy thông tin người dùng';
			}
		} else {
			echo 'Không tìm thấy ID người dùng trong session';
		}
	}

	public function updateAvatarCustomer($user_id)
	{
		if (!empty($_FILES['Avatar']['name'])) {
			// Upload Image
			$ori_filename = $_FILES['Avatar']['name'];
			$new_name = time() . "-" . str_replace(' ', '-', $ori_filename);

			$config = [
				'upload_path' => './uploads/user',
				'allowed_types' => 'gif|jpg|png|jpeg',
				'file_name' => $new_name
			];
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('Avatar')) {
				$error = ['error' => $this->upload->display_errors()];
				$this->session->set_flashdata('error', $error['error']);
				redirect(base_url('profile-user'));
				return;
			} else {
				$avatar_filename = $this->upload->data('file_name');
				$data = ['Avatar' => $avatar_filename];
			}
		} else {
			$this->session->set_flashdata('error', 'Vui lòng chọn ảnh hợp lệ.');
			redirect(base_url('profile-user'));
			return;
		}

		$this->load->model('customerModel');
		$this->customerModel->updateCustomer($user_id, $data);
		$this->session->set_flashdata('success', 'Đã cập nhật ảnh đại diện thành công.');
		redirect(base_url('profile-user'));
	}




	public function updateCustomer($user_id)
	{
		$this->form_validation->set_rules('Name', 'Username', 'trim|required', ['required' => 'Bạn cần điền %s']);
		$this->form_validation->set_rules('Email', 'Email', 'trim|required', ['required' => 'Bạn cần điền %s']);
		$this->form_validation->set_rules('Address', 'Address', 'trim|required', ['required' => 'Bạn cần chọn %s']);
		$this->form_validation->set_rules('Phone', 'Phone', 'trim|required', ['required' => 'Bạn cần chọn %s']);

		if ($this->form_validation->run()) {
			if (!empty($_FILES['Avatar']['name'])) {
				// Upload Image
				$ori_filename = $_FILES['image']['name'];
				$new_name = time() . "-" . str_replace(' ', '-', $ori_filename);
				$config = [
					'upload_path' => './uploads/user',
					'allowed_types' => 'gif|jpg|png|jpeg',
					'file_name' => $new_name
				];
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('Avatar')) {
					$error = ['error' => $this->upload->display_errors()];
					$this->load->view('customer/update_profile_user', $error);
					return;
				} else {
					$avatar_filename = $this->upload->data('file_name');
					$data = [
						'Name' => $this->input->post('Name'),
						'Email' => $this->input->post('Email'),
						'Address' => $this->input->post('Address'),
						'Phone' => $this->input->post('Phone'),
						'Avatar' => $avatar_filename
					];
				}
			} else {
				$data = [
					'Name' => $this->input->post('Name'),
					'Email' => $this->input->post('Email'),
					'Address' => $this->input->post('Address'),
					'Phone' => $this->input->post('Phone'),
				];
			}

			// Kiểm tra giá trị của $data trước khi cập nhật
			// echo '<pre>';
			// print_r($data);
			// echo '</pre>';

			$this->load->model('customerModel');
			$this->customerModel->updateCustomer($user_id, $data);
			$this->session->set_flashdata('success', 'Đã chỉnh sửa thông tin thành công');
			redirect(base_url('profile-user'));
		} else {
			$this->editCustomer($user_id);
		}
	}



	public function logout()
	{
		if (!empty($this->session->userdata('logged_in_admin'))) {
			$this->session->unset_userdata('logged_in_admin');
		}
		if (!empty($this->session->userdata('logged_in_customer'))) {
			$this->session->unset_userdata('logged_in_customer');
		}
		$this->session->set_flashdata('success', 'Đăng xuất thành công');
		redirect(base_url('/'));
	}




	// public function loginCustomer()
	// {
	// 	$max_attempts = 5;
	// 	$lockout_time = 0;

	// 	// Lấy thông tin số lần thử đăng nhập và thời gian lần thử cuối cùng
	// 	$login_attempts = $this->session->userdata('login_attempts') ?? 0;
	// 	$last_attempt_time = $this->session->userdata('last_attempt_time') ?? 0;

	// 	// Kiểm tra xem người dùng có bị khóa không
	// 	if ($login_attempts >= $max_attempts) {
	// 		$time_since_last_attempt = time() - $last_attempt_time;
	// 		if ($time_since_last_attempt < $lockout_time) {
	// 			$remaining_time = $lockout_time - $time_since_last_attempt;
	// 			$this->session->set_flashdata(
	// 				'error',
	// 				'Bạn đã thử đăng nhập quá nhiều lần. Vui lòng thử lại sau ' . ceil($remaining_time / 60) . ' phút.'
	// 			);
	// 			redirect(base_url('/dang-nhap'));
	// 			return;
	// 		} else {
	// 			// Xóa dữ liệu sau khi hết thời gian khóa
	// 			$this->session->unset_userdata(['login_attempts', 'last_attempt_time']);
	// 		}
	// 	}

	// 	// Ràng buộc form validation
	// 	$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', [
	// 		'required' => 'Bạn cần cung cấp email.',
	// 		'valid_email' => 'Email không hợp lệ.',
	// 	]);
	// 	$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]', [
	// 		'required' => 'Bạn cần cung cấp mật khẩu.',
	// 		'min_length' => 'Mật khẩu phải có ít nhất 6 ký tự.',
	// 	]);

	// 	if ($this->form_validation->run()) {
	// 		$email = $this->input->post('email');
	// 		$password = $this->input->post('password');

	// 		$this->load->model('loginModel');
	// 		$result = $this->loginModel->checkLoginCustomer($email);
	// 		echo '<pre>';
	// 		print_r($result[0]->Status);
	// 		echo '</pre>'; die();

	// 		// Kiểm tra kết quả từ cơ sở dữ liệu và xác minh mật khẩu
	// 		if (!empty($result) && password_verify($password, $result[0]->Password) && $result[0]->Status == 1) {

	// 			$this->session->unset_userdata(['login_attempts', 'last_attempt_time']);

	// 			$session_array = [
	// 				'id' => $result[0]->UserID,
	// 				'role_id' => $result[0]->Role_ID,
	// 				'username' => $result[0]->Name,
	// 				'email' => $result[0]->Email,
	// 				'phone' => $result[0]->Phone,
	// 			];

	// 			// Chuyển hướng dựa trên quyền
	// 			if ($result[0]->Role_ID == 1) {
	// 				$this->session->set_userdata('logged_in_admin', $session_array);
	// 				$this->session->set_flashdata('success', 'Đăng nhập thành công');
	// 				redirect(base_url('/'));
	// 			} else {
	// 				$this->session->set_userdata('logged_in_customer', $session_array);
	// 				$this->session->set_flashdata('success', 'Đăng nhập thành công');
	// 				redirect(base_url('/'));
	// 			}
	// 		} else {
	// 			// Tăng số lần thử đăng nhập và cập nhật thời gian
	// 			$login_attempts++;
	// 			$this->session->set_userdata('login_attempts', $login_attempts);
	// 			$this->session->set_userdata('last_attempt_time', time());

	// 			$this->session->set_flashdata('error', 'Email hoặc mật khẩu không chính xác.');
	// 			redirect(base_url('/dang-nhap'));
	// 		}
	// 	} else {
	// 		// Hiển thị lỗi form validation nếu có
	// 		$validation_errors = validation_errors('<div>', '</div>');
	// 		$this->session->set_flashdata('error', $validation_errors);
	// 		redirect(base_url('/dang-nhap'));
	// 	}
	// }


	public function loginCustomer()
	{
		$max_attempts = 5;
		$lockout_time = 0;

		// Lấy thông tin số lần thử đăng nhập và thời gian lần thử cuối cùng
		$login_attempts = $this->session->userdata('login_attempts') ?? 0;
		$last_attempt_time = $this->session->userdata('last_attempt_time') ?? 0;

		// Kiểm tra xem người dùng có bị khóa không
		if ($login_attempts >= $max_attempts) {
			$time_since_last_attempt = time() - $last_attempt_time;
			if ($time_since_last_attempt < $lockout_time) {
				$remaining_time = $lockout_time - $time_since_last_attempt;
				$this->session->set_flashdata(
					'error',
					'Bạn đã thử đăng nhập quá nhiều lần. Vui lòng thử lại sau ' . ceil($remaining_time / 60) . ' phút.'
				);
				redirect(base_url('/dang-nhap'));
				return;
			} else {
				// Xóa dữ liệu sau khi hết thời gian khóa
				$this->session->unset_userdata(['login_attempts', 'last_attempt_time']);
			}
		}

		// Ràng buộc form validation
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', [
			'required' => 'Bạn cần cung cấp email.',
			'valid_email' => 'Email không hợp lệ.',
		]);
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]', [
			'required' => 'Bạn cần cung cấp mật khẩu.',
			'min_length' => 'Mật khẩu phải có ít nhất 6 ký tự.',
		]);

		if ($this->form_validation->run()) {
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			$this->load->model('loginModel');
			$result = $this->loginModel->checkLoginCustomer($email);
			// echo '<pre>';
			// print_r($result[0]->Status);
			// echo '</pre>';
			// die();


			if (!empty($result)) {

				if ($result[0]->Status == 0) {
					$this->session->set_flashdata('error', 'Tài khoản của bạn đã bị khóa hoặc chưa được kích hoạt.');
					redirect(base_url('/dang-nhap'));
					return;
				}

				// Kiểm tra mật khẩu
				if (password_verify($password, $result[0]->Password)) {
					$this->session->unset_userdata(['login_attempts', 'last_attempt_time']);

					$session_array = [
						'id' => $result[0]->UserID,
						'role_id' => $result[0]->Role_ID,
						'username' => $result[0]->Name,
						'email' => $result[0]->Email,
						'phone' => $result[0]->Phone,
					];

					if ($result[0]->Role_ID == 1) {
						$this->session->set_userdata('logged_in_admin', $session_array);
						$this->session->set_flashdata('success', 'Đăng nhập thành công');
						redirect(base_url('/'));
					} else {
						$this->session->set_userdata('logged_in_customer', $session_array);
						$this->session->set_flashdata('success', 'Đăng nhập thành công');
						redirect(base_url('/'));
					}
				}
			} else {
				$this->session->set_flashdata('error', 'Sai email hoặc mật khẩu');
				redirect(base_url('/dang-nhap'));
			}
		} else {
			// Hiển thị lỗi form validation nếu có
			$validation_errors = validation_errors('<div>', '</div>');
			$this->session->set_flashdata('error', $validation_errors);
			redirect(base_url('/dang-nhap'));
		}
	}





	public function dang_ky()
	{

		$this->form_validation->set_rules('fullname', 'Fullname', 'trim|required|min_length[3]', [
			'required' => 'Bạn cần cung cấp %s',
			'min_length' => 'Tên người dùng phải có ít nhất 3 ký tự',
		]);
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', [
			'required' => 'Bạn cần cung cấp %s',
			'valid_email' => 'Địa chỉ email không hợp lệ',
		]);
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required|numeric|min_length[10]|max_length[11]', [
			'required' => 'Bạn cần cung cấp %s',
			'numeric' => 'Số điện thoại chỉ được chứa chữ số',
			'min_length' => 'Số điện thoại phải có ít nhất 10 chữ số',
			'max_length' => 'Số điện thoại không được quá 11 chữ số',
		]);
		$this->form_validation->set_rules('address', 'Address', 'trim|required', [
			'required' => 'Bạn cần cung cấp %s',
		]);
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]', [
			'required' => 'Bạn cần cung cấp %s',
			'min_length' => 'Mật khẩu phải có ít nhất 6 ký tự',
		]);

		if ($this->form_validation->run()) {
			$email = $this->input->post('email');

			$this->load->model('loginModel');
			$email_exists = $this->loginModel->checkEmailExists($email);

			if ($email_exists) {
				$this->session->set_flashdata('error', 'Email đã được sử dụng. Vui lòng sử dụng email khác.');
				redirect(base_url('dang-nhap'));
			}


			$username = $this->input->post('fullname');
			$password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
			$phone = $this->input->post('phone');
			$address = $this->input->post('address');

			// Tạo mã token và thời gian hết hạn
			$letters = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
			$numbers = sprintf("%06d", rand(0, 999999));
			$token = $letters . $numbers;
			$date_created = Carbon\Carbon::now('Asia/Ho_Chi_Minh')->addMinutes(10);


			$data = [
				'Email' => $email,
				'Password' => $password,
				'Role_ID' => 2,
				'Name' => $username,
				'Phone' => $phone,
				'Address' => $address,
				'Status' => 0,
				'Token_Code' => $token,
				'Avatar' => 'User-avatar.png',
				'Date_created' => $date_created
			];

			// Lưu dữ liệu vào cơ sở dữ liệu
			$result = $this->loginModel->newCustomer($data);

			if ($result) {
				// Gửi email kích hoạt tài khoản
				$fullURL = base_url() . 'kich-hoat-tai-khoan/?email=' . $email;
				$to_mail = $email;
				$subject = 'Thông báo đăng ký tài khoản thành công';
				$message = 'Click vào đường link để kích hoạt tài khoản: ' . $fullURL . '
				Nhập mã xác thực sau: ' . $token;
				$this->send_mail($to_mail, $subject, $message);
				$this->session->set_flashdata('success', 'Đăng ký tài khoản thành công. Vui lòng kiểm tra email để kích hoạt tài khoản.');
			} else {
				$this->session->set_flashdata('error', 'Đăng ký tài khoản thất bại. Vui lòng thử lại.');
			}

			redirect(base_url('dang-nhap'));
		} else {
			$this->session->set_flashdata('error', validation_errors('<div>', '</div>'));
			redirect(base_url('dang-nhap'));
		}
	}




	public function kich_hoat_tai_khoan()
	{
		if (isset($_GET['email'])) {
			$email = $_GET['email'];
			$this->data['email'] = $email;
			$this->data['template'] = "pages/auth/verify_token";
			$this->load->view("pages/layout/index", $this->data);
		} else {
			$this->session->set_flashdata('error', 'Thông tin kích hoạt không hợp lệ.');
			redirect(base_url('dang-nhap'));
		}
	}

	public function verify_token()
	{
		$email = $this->input->post('email');
		$token = $this->input->post('token');
		$this->load->model('IndexModel');
		$customer = $this->IndexModel->getCustomerToken($email);

		// echo "<pre>";
		// print_r($customer);
		// echo "</pre>";
		// die();


		$is_valid = false;
		$time_now = Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();

		if ($customer && $token == $customer->Token_Code && $customer->Date_created > $time_now) {
			$letters = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
			$numbers = sprintf("%06d", rand(0, 999999));
			$new_token = $letters . $numbers;

			$data_customer = [
				'Status' => 1,
				'Token_Code' => $new_token
			];

			$this->IndexModel->activeCustomerAndUpdateNewToken($email, $data_customer);
			$this->session->set_flashdata('success', 'Kích hoạt tài khoản thành công, mời bạn đăng nhập lại');
			$is_valid = true;
		} else {
			$this->session->set_flashdata('error', 'Đường dẫn hoặc mã đã hết hạn. Vui lòng thực hiện lại');
		}

		if (!$is_valid) {
			$this->session->set_flashdata('error', 'Mã xác thực không đúng. Vui lòng kiểm tra lại.');
		}

		redirect(base_url('dang-nhap'));
	}



	// Quên mật khẩu
	public function forgot_password_layout()
	{
		$this->data['template'] = "pages/forgot-password/forgot-password";
		$this->load->view("pages/layout/index", $this->data);
	}


	public function confirm_forgot_password()
	{
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$this->load->model('customerModel');
		$data['get_customer'] = $this->customerModel->getCustomerByEmailAndPhone($email, $phone);

		// echo "<pre>";
		// print_r($data['get_customer']);
		// echo "</pre>";
		// die();


		if (!empty($data['get_customer'])) {
			if ($data['get_customer']->Email == $email && $data['get_customer']->Phone == $phone) {

				$letters = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
				$numbers = sprintf("%06d", rand(0, 999999));
				$new_token = $letters . $numbers;
				$date_created = Carbon\Carbon::now('Asia/Ho_Chi_Minh')->addMinutes(10);

				$update_data = [
					'Token_Code' => $new_token,
					'Date_created' => $date_created
				];

				$result = $this->customerModel->updateTokenCustomer($update_data, $email, $phone);
				if ($result) {
					$fullURL = base_url() . 'lay-lai-mat-khau/?email=' . $email . '&phone=' . $phone;
					$to_mail = $email;
					$subject = 'Lấy lại mật khẩu';
					$message = 'Click vào đường link để xác thực lấy lại mật khẩu: ' . $fullURL . '. Nhập mã xác thực sau: <b>' . $new_token . '</b>';

					$this->send_mail($to_mail, $subject, $message);
					$this->session->set_flashdata('success', 'Vui lòng kiểm tra email: <b>' . $email . '</b> và làm theo hướng dẫn');

					redirect(base_url('dang-nhap'));
				} else {
					$this->session->set_flashdata('error', 'Không thể gửi mã xác thực. Vui lòng thử lại');
					redirect(base_url('forgot-password-layout'));
				}
			} else {
				$this->session->set_flashdata('error', 'Thông tin email hoặc số điện thoại không khớp.');
				redirect(base_url('forgot-password-layout'));
			}
		} else {
			$this->session->set_flashdata('error', 'Không tìm thấy khách hàng với thông tin cung cấp.');
			redirect(base_url('forgot-password-layout'));
		}
	}



	public function lay_lai_mat_khau()
	{

		if (isset($_GET['email']) && $_GET['phone']) {
			$email = $_GET['email'];
			$phone = $_GET['phone'];
			$this->data['email'] = $email;
			$this->data['phone'] = $phone;
			$this->data['template'] = "pages/auth/verify-token-forget-password";
			$this->load->view("pages/layout/index", $this->data);
		} else {
			$this->session->set_flashdata('error', 'Thông tin kích hoạt không hợp lệ.');
			redirect(base_url('dang-nhap'));
		}
	}

	public function verify_token_forget_password()
	{
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$Token_Code = $this->input->post('token');
		$this->load->model('IndexModel');
		$customer = $this->IndexModel->getCustomerToken($email);

		// echo "<pre>";
		// print_r($customer);
		// echo "</pre>";
		// die();


		$is_valid = false;
		$time_now = Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();

		if ($customer && $email == $customer->Email && $Token_Code == $customer->Token_Code && $customer->Date_created > $time_now) {

			$letters = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
			$numbers = sprintf("%06d", rand(0, 999999));
			$new_token = $letters . $numbers;

			$this->session->set_userdata('reset_email', $email);
			$this->session->set_userdata('reset_phone', $phone);
			$this->session->set_userdata('reset_token', $new_token);

			$update_data = [
				'Token_Code' => $new_token
			];
			$this->load->model('customerModel');
			$this->customerModel->updateTokenCustomer($update_data, $email, $phone);

			if (!empty($this->session->userdata('password_updated'))) {
				$this->session->unset_userdata('password_updated');
			}

			$this->session->set_flashdata('success', 'Xác thực thành công');
			$is_valid = true;
			redirect(base_url('nhap-mat-khau-moi'));
		}

		if (!$is_valid) {
			$this->session->set_flashdata('error', 'Mã xác thực hoặc đường dẫn không đúng. Vui lòng thực hiện lại.');
			redirect(base_url('forgot-password-layout'));
		}
		redirect(base_url('dang-nhap'));
	}



	public function nhap_mat_khau_moi()
	{
		if (!empty($this->session->userdata('password_updated'))) {
			$this->session->set_flashdata('error', 'Bạn đã thay đổi mật khẩu trước đó, hãy thực hiện lại');
			redirect(base_url('profile-user'));
		} else {
			$email = $this->session->userdata('reset_email');
			$phone = $this->session->userdata('reset_phone');

			$data['email'] = $email;
			$data['phone'] = $phone;
			if ($email && $phone) {
				$this->data = $data;
				$this->data['template'] = "pages/auth/enterNewPassword";
				$this->load->view("pages/layout/index", $this->data);
			} else {
				$this->session->set_flashdata('error', 'Mật khẩu bạn đã được đổi không thể quay lại');
				redirect(base_url('dang-nhap'));
			}
		}
	}

	public function enterNewPassword()
	{

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', ['required' => 'Bạn cần cung cấp %s', 'valid_email' => 'Địa chỉ email không hợp lệ']);
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required', ['required' => 'Bạn cần cung cấp %s']);
		$this->form_validation->set_rules('password', 'Password', 'trim|required', ['required' => 'Bạn cần cung cấp %s']);

		if ($this->form_validation->run() == TRUE) {
			$email = $this->input->post('email');
			$phone = $this->input->post('phone');
			$password = $this->input->post('password');
			$token_on_session = $this->session->userdata('reset_token');

			$this->load->model('IndexModel');
			$customer = $this->IndexModel->getCustomerToken($email);

			if ($token_on_session == $customer->Token_Code) {
				$letters = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
				$numbers = sprintf("%06d", rand(0, 999999));
				$new_token = $letters . $numbers;

				// Sử dụng hàm password_hash với hai tham số: mật khẩu và thuật toán
				$update_data = [
					'Token_Code' => $new_token,
					'Password' => password_hash($password, PASSWORD_DEFAULT),
				];

				$this->load->model('customerModel');
				$result = $this->customerModel->updateCustomerForgotPassword($email, $phone, $update_data);

				if ($result == 1) {
					$this->session->unset_userdata('reset_email');
					$this->session->unset_userdata('reset_phone');
					$this->session->unset_userdata('reset_token');
					$this->session->set_userdata('password_updated', TRUE);
					$this->session->set_flashdata('success', 'Cập nhật mật khẩu thành công, xin mời bạn đăng nhập lại');
					redirect(base_url('dang-nhap'));
				} else {
					$this->session->set_flashdata('error', 'Có lỗi xảy ra, vui lòng thực hiện lại');
				}
			} else {
				$this->session->set_flashdata('error', 'Không thể thay đổi mật khẩu, bạn đã thay đổi trước đó, vui lòng thực hiện lại');
				redirect(base_url('dang-nhap'));
			}
		} else {
			// $email = $this->input->post('email');
			// $phone = $this->input->post('phone');
			$this->session->set_flashdata('error', 'Vui lòng nhập đúng và đầy đủ thông tin');
			redirect(base_url('nhap-mat-khau-moi'));
		}
	}

	public function confirmPassword()
	{
		$this->checkLogin();
		$user = $this->getUserOnSession();
		// echo '<pre>';
		// print_r($user);
		// echo '</pre>';
		$this->data = $user;
		$this->data['template'] = "pages/customer/confirmPassword";
		$this->load->view("pages/layout/index", $this->data);
	}





	public function enterPasswordNow()
	{
		$max_attempts = 5;
		$lockout_time = 300;

		// Lấy thông tin số lần thử đăng nhập và thời gian lần thử cuối cùng
		$login_attempts = $this->session->userdata('login_attempts') ?? 0;
		$last_attempt_time = $this->session->userdata('last_attempt_time') ?? 0;

		// Kiểm tra xem người dùng có bị khóa không
		if ($login_attempts >= $max_attempts) {
			$time_since_last_attempt = time() - $last_attempt_time;
			if ($time_since_last_attempt < $lockout_time) {
				$remaining_time = $lockout_time - $time_since_last_attempt;
				$this->session->set_flashdata(
					'error',
					'Bạn đã thử đăng nhập quá nhiều lần. Vui lòng thử lại sau ' . ceil($remaining_time / 60) . ' phút.'
				);
				redirect(base_url('/dang-nhap'));
				return;
			} else {
				// Xóa dữ liệu sau khi hết thời gian khóa
				$this->session->unset_userdata(['login_attempts', 'last_attempt_time']);
			}
		}

		// Ràng buộc form validation
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', [
			'required' => 'Bạn cần cung cấp email.',
			'valid_email' => 'Email không hợp lệ.',
		]);
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]', [
			'required' => 'Bạn cần cung cấp mật khẩu.',
			'min_length' => 'Mật khẩu phải có ít nhất 6 ký tự.',
		]);

		if ($this->form_validation->run()) {
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			$this->load->model('loginModel');
			$result = $this->loginModel->checkLoginCustomer($email);
			// echo '<pre>';
			// print_r($result);
			// echo '</pre>';

			// $hashedPassword = $result[0]->Password;

			// if (password_verify($password, $hashedPassword)) {
			// 	echo "✅ Mật khẩu khớp!";
			// } else {
			// 	echo "❌ Mật khẩu không khớp!";
			// }
			// Kiểm tra kết quả từ cơ sở dữ liệu và xác minh mật khẩu
			if (!empty($result) && password_verify($password, $result[0]->Password)) {
				$this->session->unset_userdata(['login_attempts', 'last_attempt_time']);
				$this->session->set_flashdata('success', 'Kiểm tra email và nhập mã xác thực');
				redirect(base_url('change-password'));
			} else {
				// Tăng số lần thử đăng nhập và cập nhật thời gian
				$login_attempts++;
				$this->session->set_userdata('login_attempts', $login_attempts);
				$this->session->set_userdata('last_attempt_time', time());

				$this->session->set_flashdata('error', 'Mật khẩu không chính xác, vui lòng thử lại.');
				redirect(base_url('/confirmPassword'));
			}
		} else {
			// Hiển thị lỗi form validation nếu có
			$validation_errors = validation_errors('<div>', '</div>');
			$this->session->set_flashdata('error', $validation_errors);
			redirect(base_url('/confirmPassword'));
		}
	}


	public function change_password()
	{
		$this->checkLogin();
		$results = $this->getUserOnSession();
		$email = $results['email'];
		$phone = $results['phone'];

		$letters = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
		$numbers = sprintf("%06d", rand(0, 999999));
		$new_token = $letters . $numbers;
		$date_created = Carbon\Carbon::now('Asia/Ho_Chi_Minh')->addMinute(10);
		$update_data = [
			'Token_Code' => $new_token,
			'Date_created' => $date_created
		];
		$this->load->model('customerModel');
		$result = $this->customerModel->updateTokenCustomer($update_data, $email, $phone);
		if ($result) {
			$to_mail = $email;
			$subject = 'Đổi mật khẩu mới';
			$message = 'Mã xác thực của bạn là: ' . $new_token;

			$this->send_mail($to_mail, $subject, $message);
			$this->session->set_flashdata('success', 'Mã xác thực đã được gửi về email của bạn, vui lòng kiểm tra email: <b>' . $email . '</b>');

			// Chuyển đến trang nhập mã xác thực
			redirect(base_url('nhap-ma-xac-thuc'));
		} else {
			$this->session->set_flashdata('error', 'Không thể gửi mã xác thực. Vui lòng thử lại');
			redirect(base_url('profile-user'));
		}
	}


	public function nhap_ma_xac_thuc()
	{
		$this->checkLogin();

		$results = $this->getUserOnSession();
		$data['email'] = $results['email'];
		$data['phone'] = $results['phone'];

		$this->data = $data;
		$this->data['template'] = "pages/auth/changePass_verify";
		$this->load->view("pages/layout/index", $this->data);
	}

	public function change_password_verify_token()
	{
		$this->checkLogin();

		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$token = $this->input->post('token');
		$this->load->model('customerModel');
		$data['get_customer'] = $this->customerModel->getCustomerByEmailAndPhone($email, $phone);

		$time_now = Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();
		if ($data['get_customer'] && $token == $data['get_customer']->Token_Code && $data['get_customer']->Date_created > $time_now) {
			$letters = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
			$numbers = sprintf("%06d", rand(0, 999999));
			$new_token = $letters . $numbers;

			$update_data = [
				'Token_Code' => $new_token
			];

			$this->load->model('customerModel');
			$this->customerModel->updateTokenCustomer($update_data, $email, $phone);

			if (!empty($this->session->userdata('password_updated'))) {
				$this->session->unset_userdata('password_updated');
			}

			$this->session->set_flashdata('success', 'Xác thực thành công');
			redirect(base_url('cap-nhat-mat-khau-moi'));
		} else {
			$this->session->set_flashdata('error', 'Mã xác thực hoặc đường dẫn không đúng. Vui lòng thực hiện lại.');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}



	public function cap_nhat_mat_khau_moi()
	{
		if (!empty($this->session->userdata('password_updated'))) {
			$this->session->set_flashdata('error', 'Bạn đã thay đổi mật khẩu trước đó, hãy thực hiện lại');
			redirect(base_url('profile-user'));
		} else {
			$results = $this->getUserOnSession();
			$email = $results['email'];
			$phone = $results['phone'];

			if ($email && $phone) {
				$data['email'] = $email;
				$data['phone'] = $phone;

				$this->data = $data;
				$this->data['template'] = "pages/customer/changePassword";
				$this->load->view("pages/layout/index", $this->data);
			} else {
				$this->session->set_flashdata('error', 'Mật khẩu bạn đã được đổi không thể quay lại');
				redirect(base_url('dang-nhap'));
			}
		}
	}

	public function changePassword()
	{

		if (!empty($this->session->userdata('password_updated'))) {
			// echo "Đã thay đổi";
			$this->session->set_flashdata('error', 'Bạn đã thay đổi mật khẩu trước đó, hãy thực hiện lại');
			redirect(base_url('profile-user'));
		} else {
			// echo "Chưa thay đổi";
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', [
				'required' => 'Bạn cần cung cấp %s',
				'valid_email' => 'Địa chỉ email không hợp lệ'
			]);
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required', ['required' => 'Bạn cần cung cấp %s']);
			$this->form_validation->set_rules('password', 'Password', 'trim|required', ['required' => 'Bạn cần cung cấp %s']);

			if ($this->form_validation->run() == TRUE) {
				$email = $this->input->post('email');
				$phone = $this->input->post('phone');
				$password = $this->input->post('password');

				$letters = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
				$numbers = sprintf("%06d", rand(0, 999999));
				$new_token = $letters . $numbers;



				$update_data = [
					'Token_Code' => $new_token,
					'Password' => password_hash($password, PASSWORD_DEFAULT),
				];

				$this->load->model('customerModel');
				$result = $this->customerModel->updateCustomerChangePassword($email, $phone, $update_data);
				if ($result) {
					$this->session->set_flashdata('success', 'Cập nhật mật khẩu thành công, xin mời bạn đăng nhập lại');

					$this->session->set_userdata('password_updated', TRUE);

					$this->session->unset_userdata('logged_in_customer');
					redirect(base_url('dang-nhap'));
				} else {
					$this->session->set_flashdata('error', 'Có lỗi xảy ra, vui lòng thực hiện lại');
					redirect(base_url('profile-user'));
				}
			} else {
				$this->session->set_flashdata('error', 'Vui lòng nhập đúng và đầy đủ thông tin');
				redirect(base_url('nhap-mat-khau-moi'));
			}
		}
	}

	// AI
	public function predict()
	{
		$this->config->config['pageTitle'] = 'Chẩn đoán bệnh';
		$this->data['template'] = "pages/AI/predict";
		$this->load->view("pages/layout/index", $this->data);
	}



	public function comment_send()
	{
		$data = [
			'name' => $this->input->post('name_comment'),
			'email' => $this->input->post('email_comment'),
			'comment' => $this->input->post('comment'),
			'product_id_comment' => $this->input->post('pro_id_cmt'),
			'status' => 0,
			'date_cmt' => Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString()
		];
		$result = $this->IndexModel->commentSend($data);
	}
}
