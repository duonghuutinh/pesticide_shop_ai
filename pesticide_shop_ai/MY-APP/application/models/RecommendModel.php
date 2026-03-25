<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RecommendModel extends CI_Model
{
    /**
     * Get top N similar products using Item-based KNN (Cosine Similarity)
     */
    public function getRecommendations($product_id, $limit = 4)
    {
        $this->db->select('p.*, i.similarity');
        $this->db->from('item_similarity i');
        $this->db->join('product p', 'p.ProductID = i.item_B');
        $this->db->where('i.item_A', $product_id);
        $this->db->where('p.Status', 1); // Only active products
        // Exclude the product itself just in case
        $this->db->where('p.ProductID !=', $product_id);
        $this->db->order_by('i.similarity', 'DESC');
        // fallback sort for stable results
        $this->db->order_by('p.ProductID', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result();
    }
}
