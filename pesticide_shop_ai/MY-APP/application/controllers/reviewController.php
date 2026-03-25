<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property session $session
 * @property config $config
 * @property form_validation $form_validation
 * @property input $input
 * @property load $load
 * @property model $model
 * @property pagination $pagination
 * @property uri $uri
 * @property pagination $pagination
 * @property upload $upload
 * @property reviewModel $reviewModel
 * @property productModel $productModel
 */


class reviewController extends CI_Controller
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

    // public function index()
    // {
    //     $this->config->config['pageTitle'] = 'List of products';


    //     $this->load->model('reviewModel');

    //     $data['reviews'] = $this->reviewModel->getProductsWithReviews();



    //     $data['title']      = "Danh sách sản phẩm được đánh giá";
    // 	$data['breadcrumb'] = [
    // 		['label' => 'Danh sách sản phẩm được đánh giá', 'url' => 'review-list'],
    // 		['label' => 'Danh sách sản phẩm được đánh giá']
    // 	];
    //     $data['template'] = "review/index";
    //     $this->load->view("admin-layout/admin-layout", $data);
    // }



    public function index($page = 1)
    {
        $this->config->config['pageTitle'] = 'Danh sách đánh giá sản phẩm';
        $this->load->model('reviewModel');
        $this->load->helper('pagination');

        $keyword  = $this->input->get('keyword', true);
        $perpage  = (int) $this->input->get('perpage');
        $perpage  = $perpage > 0 ? $perpage : 10;


        $total = $this->reviewModel->countAllProductsWithReview($keyword);

        $page = (int) $page;
        $page = $page > 0 ? $page : 1;
        $max_page = ceil($total / $perpage);

        if ($page > $max_page && $total > 0) {
            $query = http_build_query($this->input->get());
            redirect(base_url('review-list') . ($query ? '?' . $query : ''));
        }

        $start = ($page - 1) * $perpage;

        $data['reviews'] = $this->reviewModel->getProductsWithReview($keyword, $perpage, $start);

        // echo '<pre>';
        // print_r($data['reviews']);
        // echo '</pre>';
        $data['links']   = init_pagination(base_url('review-list'), $total, $perpage, 2);

        $data['keyword']    = $keyword;
        $data['perpage']    = $perpage;
        $data['start']      = $start;
        $data['title']      = "Danh sách đánh giá sản phẩm";
        $data['breadcrumb'] = [
            ['label' => 'Dashboard', 'url' => 'dashboard'],
            ['label' => 'Danh sách đánh giá sản phẩm']
        ];
        $data['template'] = "review/index";

        $this->load->view("admin-layout/admin-layout", $data);
    }


    // public function reviewProduct($productId)
    // {
    //     $this->load->model('reviewModel');
    //     $this->load->model('productModel');


    //     $product = $this->productModel->selectProductById($productId);
    //     if (!$product) {
    //         show_404();
    //     }

    //     $reviews = $this->reviewModel->getReviewsByProductId($productId);

    //     $data['product'] = $product;
    //     $data['reviews'] = $reviews;

    //     echo '<pre>';
    //     print_r($data['product']);
    //     echo '</pre>';
    //     echo '<pre>';
    //     print_r($data['reviews']);
    //     echo '</pre>';

    //     $data['title'] = 'Chi tiết đánh giá sản phẩm';

    //     $data['breadcrumb'] = [
    //         ['label' => 'Dashboard', 'url' => 'dashboard'],
    //         ['label' => 'Danh sách đánh giá', 'url' => 'review-list'],
    //         ['label' => 'Chi tiết đánh giá']
    //     ];

    //     $data['template'] = 'review/review_of_product';

    //     $this->load->view('admin-layout/admin-layout', $data);
    // }



    // public function reviewProduct($product_id, $page = 1)
    // {
    //     $this->load->model('reviewModel');
    //     $this->load->model('productModel');
    //     $this->load->helper('pagination');

    //     $perpage = (int) $this->input->get('perpage');
    //     $perpage = $perpage > 0 ? $perpage : 1;

    //     $total = $this->reviewModel->countReviewByProduct($product_id);

    //     $page = (int) $page;
    //     $page = $page > 0 ? $page : 1;
    //     $max_page = ceil($total / $perpage);

    //     if ($page > $max_page && $total > 0) {
    //         $query = http_build_query($this->input->get());
    //         redirect(base_url("review-list/detail/$product_id") . ($query ? '?' . $query : ''));
    //     }

    //     $start = ($page - 1) * $perpage;

    //     $data['product'] = $this->productModel->selectProductById($product_id);
    //     $data['reviews'] = $this->reviewModel->getReviewByProduct($product_id, $perpage, $start);

    //     $data['links'] = init_pagination(base_url("review-list/detail/$product_id"), $total, $perpage, 4);

    //     $data['perpage'] = $perpage;
    //     $data['start'] = $start;
    //     $data['title'] = "Chi tiết đánh giá sản phẩm";
    //     $data['breadcrumb'] = [
    //         ['label' => 'Dashboard', 'url' => 'dashboard'],
    //         ['label' => 'Đánh giá sản phẩm', 'url' => 'review-list'],
    //         ['label' => 'Chi tiết đánh giá']
    //     ];

    //     $data['template'] = 'review/review_of_product';

    //     $this->load->view('admin-layout/admin-layout', $data);
    // }


    public function reviewProduct($product_id, $page = 1)
    {
        $this->load->model('reviewModel');
        $this->load->model('productModel');
        $this->load->helper('pagination');
    
    
        $is_active = $this->input->get('is_active', true); 
        $rating = $this->input->get('rating', true);       
        $perpage = (int) $this->input->get('perpage');
        $perpage = $perpage > 0 ? $perpage : 10;
    
       
        $total = $this->reviewModel->countReviewByProduct($product_id, $is_active, $rating);
    
        $page = (int) $page;
        $page = $page > 0 ? $page : 1;
        $max_page = ceil($total / $perpage);
    
     
        if ($page > $max_page && $total > 0) {
            $query = http_build_query($this->input->get());
            redirect(base_url("review-list/detail/$product_id") . ($query ? '?' . $query : ''));
        }
    
        $start = ($page - 1) * $perpage;
    
        // Dữ liệu
        $data['product'] = $this->productModel->selectProductById($product_id);
        $data['reviews'] = $this->reviewModel->getReviewByProduct($product_id, $perpage, $start, $is_active, $rating);

        // echo '<pre>';
        // print_r($data['reviews']);
        // echo '</pre>';
        
        // Gán link phân trang kèm query string
        $base_url = base_url("review-list/detail/$product_id");
        $query_string = $this->input->get();
        $data['links'] = init_pagination($base_url, $total, $perpage, 4, $query_string);
    
        // Truyền lại filter để giữ giá trị trong form
        $data['is_active'] = $is_active;
        $data['rating'] = $rating;
        $data['perpage'] = $perpage;
        $data['start'] = $start;
        $data['title'] = "Danh sách đánh giá sản phẩm: ".$data['product']->Name;
    
        $data['breadcrumb'] = [
            ['label' => 'Dashboard', 'url' => 'dashboard'],
            ['label' => 'Danh sách đánh giá sản phẩm', 'url' => 'review-list'],
            ['label' => 'Chi tiết đánh giá']
        ];
    
        $data['template'] = 'review/review_of_product';
    
        $this->load->view('admin-layout/admin-layout', $data);
    }
    



    public function updateReview()
    {
        $review_id = $this->input->post('review_id', true);
        $comment   = $this->input->post('comment', true);
        $reply     = $this->input->post('reply', true);
        $is_active = $this->input->post('is_active', true);
        if (empty($review_id)) {
            $this->session->set_flashdata('error', 'ID đánh giá không hợp lệ.');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        // Chuẩn bị mảng dữ liệu cần cập nhật
        $data = [
            'comment' => $comment,
            'reply'   => $reply,
            'is_active' => $is_active
        ];
        // Gọi model xử lý
        $this->load->model('reviewModel');
        $updated = $this->reviewModel->updateReviewData($review_id, $data);

        // Thông báo
        if ($updated) {
            $this->session->set_flashdata('success', 'Cập nhật đánh giá thành công.');
        } else {
            $this->session->set_flashdata('error', 'Cập nhật thất bại. Vui lòng thử lại.');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }
}
