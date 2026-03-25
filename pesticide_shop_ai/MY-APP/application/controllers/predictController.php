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
 */


class predictController extends CI_Controller
{


    // public function yolo_predict_page()
    // {
    //     $this->config->config['pageTitle'] = 'Chẩn đoán bệnh';
    //     $this->load->model('indexModel');

    //     $data = [
    //         'title'             => "Yolo Predict",
    //         'template'          => "AI/yolo_predict",
    //         'image_url'         => '',
    //         'predictions'       => [],
    //         'message'           => '',
    //         'relevant_products' => [],
    //         'category'          => $this->indexModel->getCategoryHome(),
    //     ];

    //     // Nếu có ảnh được upload
    //     if ($this->input->method() === 'post' && isset($_FILES['image'])) {
    //         $imagePath = $_FILES['image']['tmp_name'];
    //         $imageMimeType = mime_content_type($imagePath);

    //         // Kiểm tra định dạng hợp lệ
    //         $info = getimagesize($imagePath);
    //         if (!$info || !in_array($info['mime'], ['image/jpeg', 'image/png'])) {
    //             $data['message'] = 'Chỉ chấp nhận tệp JPEG hoặc PNG.';
    //             $this->load->view("pages/layout/index", $data);
    //             return;
    //         }


    //         // Gửi ảnh tới Flask
    //         $response = $this->_call_flask_api($imagePath);
    //         if (!$response) {
    //             $data['message'] = 'Lỗi kết nối máy chủ Flask.';
    //         } elseif (isset($response['message'])) {
    //             $data['message'] = $response['message'];
    //         } else {
    //             // Gắn dữ liệu dự đoán
    //             $data['image_url'] = 'http://localhost:5000/' . $response['image_url'];
    //             $data['predictions'] = $response['predictions'];

    //             // Lấy tên bệnh từ kết quả
    //             $disease_type = $this->_map_label_to_disease($response['predictions']);
    //             if ($disease_type) {
    //                 $data['relevant_products'] = $this->indexModel->getProductsByDiseaseType($disease_type);
    //             }
    //         }
    //     }

    //     $this->load->view("pages/layout/index", $data);
    // }


    // public function yolo_predict_page($page = 1)
    // {
    //     $this->config->config['pageTitle'] = 'Chẩn đoán bệnh';
    //     $this->load->model('indexModel');
    //     $this->load->library(['pagination', 'session']);

    //     $perpage = 6;
    //     $is_post = $this->input->method() === 'post';

    //     // Xoá dữ liệu khi người dùng truy cập lại trang web
    //     if (!$is_post && $page == 1) {
    //         $this->session->unset_userdata('ai_result');
    //     }

    //     $data = [
    //         'title'             => "Yolo Predict",
    //         'template'          => "AI/yolo_predict",
    //         'image_url'         => '',
    //         'predictions'       => [],
    //         'message'           => '',
    //         'relevant_products' => [],
    //         'category'          => $this->indexModel->getCategoryHome(),
    //         'links'             => '',
    //         'label_map'         => $this->label_map
    //     ];


    //     if ($is_post && isset($_FILES['image'])) {
    //         $imagePath = $_FILES['image']['tmp_name'];
    //         $imageMimeType = mime_content_type($imagePath);

    //         if (!in_array($imageMimeType, ['image/jpeg', 'image/png'])) {
    //             $data['message'] = 'Chỉ chấp nhận tệp JPEG hoặc PNG.';
    //             return $this->load->view("pages/layout/index", $data);
    //         }

    //         $response = $this->_call_flask_api($imagePath);
    //         if (!$response) {
    //             $data['message'] = 'Lỗi kết nối máy chủ Flask.';
    //         } elseif (isset($response['message'])) {
    //             $data['message'] = $response['message'];
    //         } else {
    //             $disease_type = $this->_map_label_to_disease($response['predictions']);
    //             if ($disease_type) {
    //                 // Set session
    //                 $ai_result = [
    //                     'image_url'    => 'http://localhost:5000/' . $response['image_url'],
    //                     'predictions'  => $response['predictions'],
    //                     'disease_type' => $disease_type,
    //                 ];
    //                 $this->session->set_userdata('ai_result', $ai_result);
    //                 // Gán vào data ngay tại đây để hiển thị luôn
    //                 $data['image_url']   = $ai_result['image_url'];
    //                 $data['predictions'] = $ai_result['predictions'];
    //             }
    //         }
    //     }

    //     $ai_result = $this->session->userdata('ai_result');
    //     if ($ai_result && isset($ai_result['disease_type'])) {
    //         $data['image_url']   = $ai_result['image_url'];
    //         $data['predictions'] = $ai_result['predictions'];

    //         $total = $this->indexModel->countProductsByDiseaseType($ai_result['disease_type']);

    //         $config = [
    //             'base_url'           => base_url('predict'),
    //             'total_rows'         => $total,
    //             'per_page'           => $perpage,
    //             'uri_segment'        => 2,
    //             'use_page_numbers'   => TRUE,
    //             'full_tag_open'      => '<ul class="pagination">',
    //             'full_tag_close'     => '</ul>',
    //             'cur_tag_open'       => '<li class="active"><a>',
    //             'cur_tag_close'      => '</a></li>',
    //             'num_tag_open'       => '<li>',
    //             'num_tag_close'      => '</li>',
    //             'prev_tag_open'      => '<li>',
    //             'prev_tag_close'     => '</li>',
    //             'next_tag_open'      => '<li>',
    //             'next_tag_close'     => '</li>',
    //         ];
    //         $this->pagination->initialize($config);

    //         $page   = max(1, (int)$page);
    //         $offset = ($page - 1) * $perpage;

    //         $data['relevant_products'] = $this->indexModel->getProductsByDiseaseType($ai_result['disease_type'], $perpage, $offset);
    //         $data['links']             = $this->pagination->create_links();

    //         if (empty($data['relevant_products'])) {
    //             $data['message'] = 'Không tìm thấy sản phẩm phù hợp với kết quả chẩn đoán.';
    //         }
    //     }

    //     // --- Hiển thị view ---
    //     $this->load->view("pages/layout/index", $data);
    // }


    public function yolo_predict_page($page = 1)
    {
        $this->config->config['pageTitle'] = 'Chẩn đoán bệnh';
        $this->load->model('indexModel');
        $this->load->library(['pagination', 'session']);

        $perpage = 6;
        $is_post = $this->input->method() === 'post';

    
        if (!$is_post && $page == 1) {
            $this->session->unset_userdata('ai_result');
        }

        $data = [
            'title'             => "Yolo Predict",
            'template'          => "AI/yolo_predict",
            'image_url'         => '',
            'predictions'       => [],
            'message'           => '',
            'relevant_products' => [],
            'category'          => $this->indexModel->getCategoryHome(),
            'links'             => '',
            'label_map'         => $this->label_map
        ];


        if ($is_post && isset($_FILES['image'])) {
            $this->session->unset_userdata('ai_result');
            $imagePath = $_FILES['image']['tmp_name'];
            $imageMimeType = mime_content_type($imagePath);

            if (!in_array($imageMimeType, ['image/jpeg', 'image/png'])) {
                $data['message'] = 'Chỉ chấp nhận tệp JPEG hoặc PNG.';
                return $this->load->view("pages/layout/index", $data);
            }

            $response = $this->_call_flask_api($imagePath);
            if (!$response) {
                $data['message'] = 'Lỗi kết nối máy chủ Flask.';
            } elseif (isset($response['message'])) {
                $data['message'] = $response['message'];
            } else {
                $result = $response['predictions'];
                if (!empty($result)) {
                    $disease_type = $this->_map_label_to_disease($result);
                    $data['image_url']   = 'http://localhost:5000/' . $response['image_url'];
                    $data['predictions'] = $result;

                    if ($disease_type) {
                        $ai_result = [
                            'image_url'    => $data['image_url'],
                            'predictions'  => $result,
                            'disease_type' => $disease_type,
                        ];
                        $this->session->set_userdata('ai_result', $ai_result);
                    }
                } else {
                    $data['predictions'] = [];
                    $data['message'] = 'Không nhận diện được đối tượng nào trong ảnh.';
                }
            }
        }

        $ai_result = $this->session->userdata('ai_result');
        if ($ai_result && isset($ai_result['disease_type'])) {
            $data['image_url']   = $ai_result['image_url'];
            $data['predictions'] = $ai_result['predictions'];

            $total = $this->indexModel->countProductsByDiseaseType($ai_result['disease_type']);

            $config = [
                'base_url'           => base_url('predict'),
                'total_rows'         => $total,
                'per_page'           => $perpage,
                'uri_segment'        => 2,
                'use_page_numbers'   => TRUE,
                'full_tag_open'      => '<ul class="pagination">',
                'full_tag_close'     => '</ul>',
                'cur_tag_open'       => '<li class="active"><a>',
                'cur_tag_close'      => '</a></li>',
                'num_tag_open'       => '<li>',
                'num_tag_close'      => '</li>',
                'prev_tag_open'      => '<li>',
                'prev_tag_close'     => '</li>',
                'next_tag_open'      => '<li>',
                'next_tag_close'     => '</li>',
            ];
            $this->pagination->initialize($config);

            $page   = max(1, (int)$page);
            $offset = ($page - 1) * $perpage;

            $data['relevant_products'] = $this->indexModel->getProductsByDiseaseType($ai_result['disease_type'], $perpage, $offset);
            $data['links']             = $this->pagination->create_links();

            if (empty($data['relevant_products'])) {
                $data['message'] = 'Không tìm thấy sản phẩm phù hợp với kết quả chẩn đoán.';
            }
        }

        // --- Hiển thị view ---
        $this->load->view("pages/layout/index", $data);
    }



    private function _call_flask_api($imagePath)
    {
        $image = curl_file_create($imagePath);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => 'http://localhost:5000/predict',
            CURLOPT_POST           => 1,
            CURLOPT_POSTFIELDS     => ['image' => $image],
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false || curl_errno($ch)) {
            $error = curl_error($ch);
            log_message('error', 'Flask API error: ' . $error);
            return ['message' => 'Lỗi gọi API: ' . $error];
        }



        return json_decode($response, true);
    }

    private $label_map = [
        0 => 'Đốm rong',
        1 => 'Cháy lá',
        2 => 'Đốm lá',
        3 => 'Không có bệnh',
    ];

    private function _map_label_to_disease($predictions)
    {
        foreach ($predictions as $prediction) {
            $label = $prediction['label'];
            if (isset($this->label_map[$label]) && $label != 3) {
                return $this->label_map[$label];
            }
        }
        return null;
    }
}
