<?php
class indexModel extends CI_Model
{
    // VNPAY
    public function insert_VNPAY($data_vnpay)
    {
        $this->db->trans_start();
        $this->db->insert('vnpay', $data_vnpay);
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_complete();
        return true;
    }

    public function getBrandHome()
    {
        $query = $this->db->get_where('brand', ['Status' => 1]);
        return $query->result();
    }
    public function getCategoryHome()
    {
        $query = $this->db->get_where('category', ['Status' => 1]);
        return $query->result();
    }

    public function getAllProduct()
    {
        $this->db->select('product.*');
        $this->db->from('product');
        $this->db->where('product.Status', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllSupplier()
    {
        $this->db->select('suppliers.*');
        $this->db->from('suppliers');
        // $this->db->where('supplier.Status', 1);
        $query = $this->db->get();
        return $query->result();
    }



    public function getCustomerToken($email)
    {
        $query = $this->db->get_where('users', ['email' => $email]);
        return $query->row();
    }

    public function activeCustomerAndUpdateNewToken($email, $data_customer)
    {
        $this->db->trans_start();
        $this->db->update('users', $data_customer, ['email' => $email]);
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // comment
    public function commentSend($data)
    {
        $this->db->trans_start();
        $this->db->insert('comment', $data);
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_complete();
        return true;
    }
    public function getListConmment()
    {
        $query = $this->db->get_where('comment', ['status' => 1]);
        return $query->result();
    }




    public function countAllProduct($keyword = null, $status = null)
    {
        $this->db->from('product');
        if ($keyword) {
            $this->db->like('product.Name', $keyword);
        }
        if ($status !== null && $status !== '') {
            $this->db->where('product.Status', $status);
        }
        return $this->db->count_all_results();
    }

    public function countAllCategory()
    {
        return $this->db->count_all('category');
    }
    public function countAllBrand()
    {
        return $this->db->count_all('brand');
    }
    public function countAllUser()
    {
        return $this->db->count_all('users');
    }
    public function countAllProductByCate($id)
    {
        $this->db->where('CategoryID', $id);
        $this->db->from('product');
        return $this->db->count_all_results();
    }
    public function countAllProductByBrand($id)
    {
        $this->db->where('BrandID', $id);
        $this->db->from('product');
        return $this->db->count_all_results();
    }
    public function countAllProductByKeyword($keyword)
    {
        $this->db->like('product.Name', $keyword);
        $this->db->from('product');
        return $this->db->count_all_results();
    }


    // public function getProductPagination($limit, $start, $keyword = null, $status = null)
    // {
    //     $this->db->select('category.Name as tendanhmuc, 
    //                    product.*, 
    //                    brand.Name as tenthuonghieu, 
    //                    COALESCE(SUM(batches.remaining_quantity), 0) as total_remaining')
    //         ->from('category')
    //         ->join('product', 'product.CategoryID = category.CategoryID')
    //         ->join('brand', 'brand.BrandID = product.BrandID')
    //         ->join('batches', 'batches.ProductID = product.ProductID', 'left')
    //         ->group_by('product.ProductID')
    //         ->order_by('total_remaining', 'DESC')
    //         ->limit($limit, $start);

    //     if ($keyword) {
    //         $this->db->group_start()
    //             ->like('product.Name', $keyword)
    //             ->or_like('product.Product_Code', $keyword)
    //             ->group_end();
    //     }

    //     if ($status !== null && $status !== '') {
    //         $this->db->where('product.Status', $status);
    //     }

    //     $query = $this->db->get();
    //     $products = $query->result();

    //     // Lấy chi tiết số lượng tồn kho theo từng lô
    //     foreach ($products as $product) {
    //         $product->batches = $this->get_batches_by_product($product->ProductID);
    //     }

    //     return $products;
    // }


    public function getProductPagination($limit, $start, $keyword = null, $status = null, $sort_stock = null)
    {
        $this->db->select('category.Name as tendanhmuc, 
                       product.*, 
                       brand.Name as tenthuonghieu, 
                       COALESCE(SUM(batches.remaining_quantity), 0) as total_remaining')
            ->from('category')
            ->join('product', 'product.CategoryID = category.CategoryID')
            ->join('brand', 'brand.BrandID = product.BrandID')
            ->join('batches', 'batches.ProductID = product.ProductID', 'left')
            ->group_by('product.ProductID');

        if ($keyword) {
            $this->db->group_start()
                ->like('product.Name', $keyword)
                ->or_like('product.Product_Code', $keyword)
                ->group_end();
        }

        if ($status !== null && $status !== '') {
            $this->db->where('product.Status', $status);
        }

        // Sắp xếp theo tồn kho nếu có chọn
        if ($sort_stock == 'asc') {
            $this->db->order_by('total_remaining', 'ASC');
        } elseif ($sort_stock == 'desc') {
            $this->db->order_by('total_remaining', 'DESC');
        } else {
            $this->db->order_by('product.Date_created', 'DESC');
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        $products = $query->result();

        foreach ($products as $product) {
            $product->batches = $this->get_batches_by_product($product->ProductID);
        }

        return $products;
    }




    public function getIndexPagination($limit, $start)
    {
        $query = $this->db->select('category.Name as tendanhmuc, 
                                    product.*, 
                                    brand.Name as tenthuonghieu, 
                                    COALESCE(SUM(batches.remaining_quantity), 0) as total_remaining')
            ->from('category')
            ->join('product', 'product.CategoryID = category.CategoryID')
            ->join('brand', 'brand.BrandID = product.BrandID')
            ->join('batches', 'batches.ProductID = product.ProductID', 'left')
            ->where('product.Status', 1)
            ->group_by('product.ProductID')
            ->order_by('RAND()')
            // ->order_by('total_remaining', 'DESC')
            ->limit($limit, $start)
            ->get();

        $products = $query->result();

        foreach ($products as $product) {
            $product->batches = $this->get_batches_by_product($product->ProductID);
        }

        return $products;
    }



    public function getBestSellingProducts($limit = 6)
    {
        $this->db->select('product.*, 
                       category.Name as tendanhmuc, 
                       brand.Name as tenthuonghieu,
                       COALESCE(SUM(order_detail.Quantity), 0) as sold_quantity')
            ->from('order_detail')
            ->join('orders', 'orders.Order_Code = order_detail.Order_Code')
            ->join('product', 'product.ProductID = order_detail.ProductID')
            ->join('category', 'category.CategoryID = product.CategoryID')
            ->join('brand', 'brand.BrandID = product.BrandID')
            ->where('product.Status', 1)
            ->where('orders.Order_Status', 4)
            ->where('orders.Payment_Status', 1) 
            ->group_by('product.ProductID')
            ->order_by('sold_quantity', 'DESC')
            ->limit($limit);

        $query = $this->db->get();
        $products = $query->result();

        foreach ($products as $product) {
            $product->batches = $this->get_batches_by_product($product->ProductID);
        }

        return $products;
    }



    public function countSearchProduct($keyword)
    {
        $this->db->from('product');
        $this->db->join('category', 'category.CategoryID = product.CategoryID');
        $this->db->join('brand', 'brand.BrandID = product.BrandID');
        $this->db->where('product.Status', 1);

        if (!empty($keyword)) {
            $this->db->group_start()
                ->like('product.Name', $keyword)
                ->or_like('product.Product_uses', $keyword)
                ->or_like('brand.Name', $keyword)
                ->or_like('category.Name', $keyword)
                ->group_end();
        }

        return $this->db->count_all_results();
    }

    public function getSearchProductPagination($keyword, $limit, $start)
    {
        $this->db->select('category.Name as tendanhmuc, 
                       product.*, 
                       brand.Name as tenthuonghieu, 
                       COALESCE(SUM(batches.remaining_quantity), 0) as total_remaining');
        $this->db->from('category');
        $this->db->join('product', 'product.CategoryID = category.CategoryID');
        $this->db->join('brand', 'brand.BrandID = product.BrandID');
        $this->db->join('batches', 'batches.ProductID = product.ProductID', 'left');
        $this->db->where('product.Status', 1);

        if (!empty($keyword)) {
            $this->db->group_start()
                ->like('product.Name', $keyword)
                ->or_like('product.Product_uses', $keyword)
                ->or_like('brand.Name', $keyword)
                ->or_like('category.Name', $keyword)
                ->group_end();
        }

        $this->db->group_by('product.ProductID');
        $this->db->order_by('total_remaining', 'DESC');
        $this->db->limit($limit, $start);

        $query = $this->db->get();
        $products = $query->result();

        // Gắn thêm lô hàng
        foreach ($products as $product) {
            $product->batches = $this->get_batches_by_product($product->ProductID);
        }

        return $products;
    }


    // Đếm tổng sản phẩm có khuyến mãi
    public function countProductOnSale($keyword = null)
    {
        $this->db->select('COUNT(*) as total');
        $this->db->from('product');
        $this->db->where('Status', 1);
        $this->db->where('Deleted_at IS NULL');
        $this->db->where('Promotion >', 0);

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('Name', $keyword);
            $this->db->or_like('Product_uses', $keyword);
            $this->db->or_like('product.Description', $keyword);
            $this->db->group_end();
        }

        $query = $this->db->get()->row();
        return $query ? (int)$query->total : 0;
    }

    // Lấy sản phẩm có khuyến mãi có phân trang
    public function getProductOnSalePagination($limit, $offset, $keyword = null)
    {
        $this->db->select('product.*, category.Name as tendanhmuc, brand.Name as tenthuonghieu');
        $this->db->from('product');
        $this->db->join('category', 'category.CategoryID = product.CategoryID', 'left');
        $this->db->join('brand', 'brand.BrandID = product.BrandID', 'left');
        $this->db->where('product.Status', 1);
        $this->db->where('product.Deleted_at IS NULL');
        $this->db->where('product.Promotion >', 0);

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('product.Name', $keyword);
            $this->db->or_like('product.Product_uses', $keyword);
            $this->db->or_like('product.Description', $keyword);
            $this->db->or_like('category.Name', $keyword);
            $this->db->or_like('brand.Name', $keyword);
            $this->db->group_end();
        }

        $this->db->limit($limit, $offset);
        $this->db->order_by('product.Date_created', 'DESC');

        $result = $this->db->get()->result();
        return $this->attachBatchesToProducts($result);
    }

    private function attachBatchesToProducts($products)
    {
        if (empty($products)) return [];

        $product_ids = array_map(function ($p) {
            return $p->ProductID;
        }, $products);

        $this->db->select('*');
        $this->db->from('batches');
        $this->db->where_in('ProductID', $product_ids);
        // $this->db->where('Deleted_at IS NULL');
        $query = $this->db->get()->result();

        // Gom batches theo ProductID
        $batches_by_product = [];
        foreach ($query as $batch) {
            $batches_by_product[$batch->ProductID][] = $batch;
        }

        // Gắn lại vào mảng products
        foreach ($products as &$product) {
            $product->batches = $batches_by_product[$product->ProductID] ?? [];
        }

        return $products;
    }





    public function getProductsByDiseaseType($disease_type, $limit = 10, $offset = 0)
    {
        $this->db->select('product.*, category.Name as tendanhmuc, brand.Name as tenthuonghieu');
        $this->db->from('product');
        $this->db->join('category', 'category.CategoryID = product.CategoryID');
        $this->db->join('brand', 'brand.BrandID = product.BrandID');
        $this->db->where('product.Status', 1);
        $this->db->like('product.Product_uses', $disease_type, 'both', false);

        $query = $this->db->get('', $limit, $offset);
        return $query->result();
    }

    public function countProductsByDiseaseType($disease_type)
    {
        $this->db->from('product');
        $this->db->where('Status', 1);
        $this->db->like('Product_uses', $disease_type, 'both', false);
        return $this->db->count_all_results();
    }


    public function get_batches_by_product($product_id)
    {
        $query = $this->db->select('Batch_ID, Expiry_date, remaining_quantity')
            ->from('batches')
            ->where('ProductID', $product_id)
            ->where('remaining_quantity >', 0)
            ->order_by('Expiry_date', 'ASC')
            ->get();

        return $query->result();
    }





    public function getCategoryPagination($id, $limit, $start)
    {
        $this->db->limit($limit, $start);
        $query = $this->db->select('category.Name as tendanhmuc, product.*, brand.Name as tenthuonghieu')
            ->from('category')
            ->join('product', 'product.CategoryID = category.CategoryID')
            ->join('brand', 'brand.BrandID = product.BrandID')
            ->where('product.CategoryID', $id)
            ->where('product.Status', 1)
            ->get();
        return $query->result();
    }

    public function getCategoryKyTuPagination($id, $kytu, $limit, $start)
    {
        $this->db->limit($limit, $start);
        $query = $this->db->select('category.Name as tendanhmuc, product.*, brand.Name as tenthuonghieu')
            ->from('category')
            ->join('product', 'product.CategoryID = category.CategoryID')
            ->join('brand', 'brand.BrandID = product.BrandID')
            ->where('product.Status', 1)
            ->where('product.CategoryID', $id)
            ->order_by('product.Name', $kytu)
            ->get();
        return $query->result();
    }
    public function getCategoryPricePagination($id, $gia, $limit, $start)
    {
        $this->db->limit($limit, $start);
        $query = $this->db->select('category.Name as tendanhmuc, product.*, brand.Name as tenthuonghieu')
            ->from('category')
            ->join('product', 'product.CategoryID = category.CategoryID')
            ->join('brand', 'brand.BrandID = product.BrandID')
            ->where('product.Status', 1)
            ->where('product.CategoryID', $id)
            ->order_by('product.selling_price', $gia)
            ->get();
        return $query->result();
    }
    public function getCategoryPriceRangePagination($id, $from_price, $to_price, $limit, $start)
    {
        $this->db->limit($limit, $start);
        $query = $this->db->select('category.Name as tendanhmuc, product.*, brand.Name as tenthuonghieu')
            ->from('category')
            ->join('product', 'product.CategoryID = category.CategoryID')
            ->join('brand', 'brand.BrandID = product.BrandID')
            ->where('product.Status', 1)
            ->where('product.CategoryID', $id)
            ->where('product.selling_price >=' . $from_price)
            ->where('product.selling_price <=' . $to_price)
            ->order_by('product.selling_price', 'asc')
            ->get();
        return $query->result();
    }
    public function getBrandPagination($id, $limit, $start)
    {
        $this->db->limit($limit, $start);
        $query = $this->db->select('category.Name as tendanhmuc, product.*, brand.Name as tenthuonghieu')
            ->from('category')
            ->join('product', 'product.CategoryID = category.CategoryID')
            ->join('brand', 'brand.BrandID = product.BrandID')
            ->where('product.Status', 1)
            ->where('product.BrandID', $id)
            ->get();
        return $query->result();
    }

    public function getCategorySlug($CategoryID)
    {
        $this->db->select('category.*');
        $this->db->from('category');
        $this->db->limit(1);
        $this->db->where('category.CategoryID', $CategoryID);
        $query = $this->db->get();
        $result = $query->row();
        return $Slug = $result->Slug;
    }
    public function getBrandSlug($BrandID)
    {
        $this->db->select('brand.*');
        $this->db->from('brand');
        $this->db->limit(1);
        $this->db->where('brand.BrandID', $BrandID);
        $query = $this->db->get();
        $result = $query->row();
        return $Slug = $result->Slug;
    }
    public function getSearchPagination($keyword, $limit, $start)
    {
        $this->db->limit($limit, $start);
        $query = $this->db->select('category.Name as tendanhmuc, product.*, brand.Name as tenthuonghieu')
            ->from('category')
            ->join('product', 'product.CategoryID = category.CategoryID')
            ->join('brand', 'brand.BrandID = product.BrandID')
            ->like('product.Name', $keyword)
            ->get();
        return $query->result();
    }



    public function getItemsCategoryHome()
    {
        $this->db->select('product.*, category.Name as cate_name, category.CategoryID');
        $this->db->from('category');
        $this->db->join('product', 'product.CategoryID = category.CategoryID');
        $query = $this->db->get();
        $result = $query->result_array();
        $newArray = array();
        foreach ($result as $key => $value) {
            $newArray[$value['cate_name']][] = $value;
        }
        return $newArray;
    }





    public function getCategoryName($CategoryID)
    {
        $this->db->select('category.*');
        $this->db->from('category');
        $this->db->limit(1);
        $this->db->where('category.CategoryID', $CategoryID);
        $query = $this->db->get();
        $result = $query->row();
        return $Name = $result->Name;
    }

    public function getMinPriceProduct($id)
    {
        $this->db->select('MIN(selling_price) AS min_price');
        $this->db->from('product');
        $this->db->where('product.CategoryID', $id);
        $query = $this->db->get();
        $result = $query->row();
        return $result ? $result->min_price : null;
    }

    public function getMaxPriceProduct($id)
    {
        $this->db->select('MAX(selling_price) AS max_price');
        $this->db->from('product');
        $this->db->where('product.CategoryID', $id);
        $query = $this->db->get();
        $result = $query->row();
        return $result ? $result->max_price : null;
    }




    public function getBrandProduct($id)
    {
        $query = $this->db->select('category.Name as tendanhmuc, product.*, brand.Name as tenthuonghieu')
            ->from('category')
            ->join('product', 'product.CategoryID = category.CategoryID')
            ->join('brand', 'brand.BrandID = product.BrandID')
            ->where('product.BrandID', $id)
            ->get();
        return $query->result();
    }

    public function getCategoryProduct($CategoryID)
    {
        $query = $this->db->select('category.Name as tendanhmuc, product.*, brand.Name as tenthuonghieu')
            ->from('category')
            ->join('product', 'product.CategoryID = category.CategoryID')
            ->join('brand', 'brand.BrandID = product.BrandID')
            ->where('product.CategoryID', $CategoryID)
            ->get();
        return $query->result();
    }

    public function getProductDetails($ProductID)
    {
        $query = $this->db->select('category.Name as tendanhmuc, 
                                 product.*, 
                                 brand.Name as tenthuonghieu, 
                                 COALESCE(SUM(batches.remaining_quantity), 0) as total_remaining')
            ->from('category')
            ->join('product', 'product.CategoryID = category.CategoryID')
            ->join('brand', 'brand.BrandID = product.BrandID')
            ->join('batches', 'batches.ProductID = product.ProductID', 'left')
            ->where('product.ProductID', $ProductID)
            ->group_by('product.ProductID')
            ->get();

        $result = $query->row();
        if (!$result) {
            log_message('debug', 'No product details found for ID: ' . $ProductID);
        }
        return $result;
    }

    public function getReviewableProducts($Order_Code, $user_id)
    {
        $this->db->select('
            orders.Order_Code,
            order_detail.ProductID, 
            product.Name, 
            product.Image,
            IF(MAX(reviews.id) IS NOT NULL, 1, 0) AS has_reviewed');
        $this->db->from('orders');
        $this->db->join('order_detail', 'orders.Order_Code = order_detail.Order_Code');
        $this->db->join('product', 'order_detail.ProductID = product.ProductID');
        $this->db->join('shipping', 'orders.ShippingID = shipping.id');
        $this->db->join('reviews', 'reviews.ProductID = order_detail.ProductID AND reviews.UserID = ' . $this->db->escape($user_id), 'left');
        $this->db->where('orders.Order_Code', $Order_Code);
        $this->db->where('shipping.user_id', $user_id);
        $this->db->where('orders.Order_Status', 4);
        $this->db->group_by(['order_detail.ProductID', 'product.Name', 'product.Image']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getReviewStatusOfOrder($Order_Code, $user_id)
    {
        // Đếm tổng số sản phẩm trong đơn hàng
        $this->db->select('COUNT(*) as total_products');
        $this->db->from('order_detail');
        $this->db->join('orders', 'orders.Order_Code = order_detail.Order_Code');
        $this->db->join('shipping', 'orders.ShippingID = shipping.id');
        $this->db->where('orders.Order_Code', $Order_Code);
        $this->db->where('shipping.user_id', $user_id);
        $total = $this->db->get()->row()->total_products;

        // Đếm số sản phẩm đã được user đánh giá
        $this->db->select('COUNT(DISTINCT reviews.ProductID) as reviewed_count');
        $this->db->from('order_detail');
        $this->db->join('orders', 'orders.Order_Code = order_detail.Order_Code');
        $this->db->join('shipping', 'orders.ShippingID = shipping.id');
        $this->db->join('reviews', 'reviews.ProductID = order_detail.ProductID AND reviews.UserID = ' . $this->db->escape($user_id));
        $this->db->where('orders.Order_Code', $Order_Code);
        $this->db->where('shipping.user_id', $user_id);
        $reviewed = $this->db->get()->row()->reviewed_count;

        return ($reviewed >= $total); // true nếu đã đánh giá hết
    }



    public function insertReviews($reviews)
    {
        if (!empty($reviews)) {
            $this->db->insert_batch('reviews', $reviews);
        }
    }




    public function getProductInOrder($Order_Code)
    {
        $user_id = $this->session->userdata('UserID');

        // Lấy sản phẩm trong đơn hàng
        $this->db->select('od.ProductID, p.Name, p.Image');
        $this->db->from('order_detail od');
        $this->db->join('product p', 'p.ProductID = od.ProductID');
        $this->db->join('orders o', 'o.Order_Code = od.Order_Code');
        $this->db->where('od.Order_Code', $Order_Code);
        $this->db->where('o.UserID', $user_id);
        $products = $this->db->get()->result();

        $order = $this->db->get_where('orders', ['Order_Code' => $Order_Code, 'UserID' => $user_id])->row();


        if (!$order || $order->Order_Status != 4) {
            show_error('Đơn hàng không hợp lệ hoặc chưa hoàn tất.');
        }
        return $order;
    }



    public function getBrandName($BrandID)
    {
        $this->db->select('brand.*');
        $this->db->from('brand');
        $this->db->limit(1);
        $this->db->where('brand.BrandID', $BrandID);
        $query = $this->db->get();
        $result = $query->row();
        return $Name = $result->Name;
    }
    public function getProductName($ProductID)
    {
        $this->db->select('product.Name');
        $this->db->from('product');
        $this->db->limit(1);
        $this->db->where('product.ProductID', $ProductID);
        $query = $this->db->get();
        $result = $query->row();

        if ($result) {
            return $result->Name;
        } else {
            // Handle the case where the product is not found
            return null; // Or you can return a default value or error message
        }
    }


    // Tìm kiếm với từ khóa
    public function getProductByKeyword($keyword)
    {
        $query = $this->db->select('category.Name as tendanhmuc, product.*, brand.Name as tenthuonghieu')
            ->from('category')
            ->join('product', 'product.CategoryID = category.CategoryID')
            ->join('brand', 'brand.BrandID = product.BrandID')
            ->like('product.Name', $keyword)
            ->get();
        return $query->result();
    }


    public function getProfileUser($user_id)
    {
        $query = $this->db->select('*')
            ->from('customers')
            ->where('id', $user_id)
            ->get();
        return $query->row();
    }


    public function updateCustomer($user_id, $data)
    {
        $this->db->trans_start();
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_complete();
        return true;
    }


    // Comment
    // public function getAllComment()
    // {
    //     $this->db->select('comment.*, product.Name AS product_name');
    //     $this->db->from('comment');
    //     $this->db->join('product', 'comment.ProductID_comment = product.ProductID');
    //     $this->db->where('product.Status', 1);
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    public function getAllComment()
    {
        $this->db->select('comment.*');
        $this->db->from('comment');
        // $this->db->where('comment.status', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function deleteComment($cmt_id)
    {
        $this->db->trans_start();
        $this->db->delete('comment', ['id' => $cmt_id]);
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_complete();
        return true;
    }
    public function selectCommentById($cmt_id)
    {
        $query = $this->db->get_where('comment', ['id' => $cmt_id]);
        return $query->row();
    }
    public function updateComment($cmt_id, $data)
    {
        $this->db->trans_start();
        $this->db->where('id', $cmt_id);
        $this->db->update('comment', $data);
        if ($this->db->affected_rows() == 0) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_complete();
        return true;
    }




    public function getValidCoupon($coupon_code)
    {
        $this->db->where('Coupon_code', $coupon_code);
        $this->db->where('Start_date <=', date('Y-m-d H:i:s'));
        $this->db->where('End_date >=', date('Y-m-d H:i:s'));
        $query = $this->db->get('discount');
        return $query->row();
    }
}
