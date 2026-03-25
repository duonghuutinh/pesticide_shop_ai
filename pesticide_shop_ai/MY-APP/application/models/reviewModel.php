<?php
class reviewModel extends CI_Model
{
    public function getProductsWithReviews()
    {
        $this->db->select('
        product.ProductID,
        product.Name,
        product.Image,
        product.Status,
        COUNT(reviews.id) AS total_reviews,
        ROUND(AVG(reviews.rating), 1) AS avg_rating,
        MAX(reviews.created_at) AS last_review_time
    ');
        $this->db->from('product');
        $this->db->join('reviews', 'product.ProductID = reviews.ProductID');
        $this->db->group_by(['product.ProductID', 'product.Name', 'product.Image', 'product.Status']);
        $this->db->order_by('last_review_time', 'DESC');

        $query = $this->db->get();
        return $query->result();
    }




    public function countAllProductsWithReview($keyword = null)
    {
        $this->db->select('p.ProductID');
        $this->db->from('product p');
        $this->db->join('reviews r', 'p.ProductID = r.ProductID');
        if ($keyword) {
            $this->db->like('p.Name', $keyword);
        }
        $this->db->group_by('p.ProductID');
        return $this->db->count_all_results();
    }



    public function getProductsWithReview($keyword = null, $limit = 10, $offset = 0)
    {
        $this->db->select('
            p.ProductID, p.Name, p.Image,
            COUNT(r.id) as total_reviews,
            ROUND(AVG(r.rating), 1) as avg_rating,
            MAX(r.created_at) as last_review_time,
            MAX(r.id) as review_id,
            SUM(CASE WHEN r.is_active = 0 THEN 1 ELSE 0 END) as pending_reviews
        ');
        $this->db->from('product p');
        $this->db->join('reviews r', 'p.ProductID = r.ProductID');

        if ($keyword) {
            $this->db->like('p.Name', $keyword);
        }

        $this->db->group_by('p.ProductID');
        $this->db->order_by('last_review_time', 'DESC');
        $this->db->limit($limit, $offset);

        return $this->db->get()->result();
    }

    public function getReviewsByProductId($productId)
    {
        $this->db->select('r.*, u.Name as reviewer_name');
        $this->db->from('reviews r');
        $this->db->join('users u', 'r.UserID = u.UserID', 'left');
        $this->db->where('r.ProductID', $productId);
        $this->db->order_by('r.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function getActiveReviewsByProductId($productId)
    {
        $this->db->select('r.*, u.Name as reviewer_name');
        $this->db->from('reviews r');
        $this->db->join('users u', 'r.UserID = u.UserID', 'left');
        $this->db->where('r.ProductID', $productId);
        $this->db->where('r.is_active', 1);
        $this->db->order_by('r.created_at', 'DESC');
        return $this->db->get()->result();
    }

    

    // public function countReviewByProduct($product_id)
    // {
    //     $this->db->where('ProductID', $product_id);
    //     return $this->db->count_all_results('reviews');
    // }

    // public function getReviewByProduct($product_id, $limit = 5, $offset = 0)
    // {
    //     $this->db->select('id, comment, rating, reply, created_at, is_active');
    //     $this->db->from('reviews');
    //     $this->db->where('ProductID', $product_id);
    //     $this->db->order_by('created_at', 'DESC');
    //     $this->db->limit($limit, $offset);
    //     return $this->db->get()->result();
    // }


    public function countReviewByProduct($product_id, $is_active = null, $rating = null)
    {
        $this->db->where('ProductID', $product_id);
        if ($is_active !== null && $is_active !== '') {
            $this->db->where('is_active', (int)$is_active);
        }
        if ($rating !== null && $rating !== '') {
            $this->db->where('rating', (int)$rating);
        }
        return $this->db->count_all_results('reviews');
    }

    public function getReviewByProduct($product_id, $limit, $start, $is_active = null, $rating = null)
    {
        $this->db->where('ProductID', $product_id);
        if ($is_active !== null && $is_active !== '') {
            $this->db->where('is_active', (int)$is_active);
        }
        if ($rating !== null && $rating !== '') {
            $this->db->where('rating', (int)$rating);
        }
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get('reviews')->result();
    }




    public function updateReviewData($review_id, $data)
    {
        $this->db->where('id', $review_id);
        return $this->db->update('reviews', $data);
    }
}
