<?php
class categoryModel extends CI_Model
{
    public function insertCategory($data)
    {
        return $this->db->insert('category', $data);
    }

    public function countCategory($keyword = null, $status = null)
    {
        if (!empty($keyword)) {
            $this->db->like('Name', $keyword);
        }

        if ($status !== null && $status !== '') {
            $this->db->where('Status', (int)$status);
        }

        return $this->db->count_all_results('category');
    }
    public function selectCategory($keyword = null, $status = null, $limit = 20, $offset = 0)
    {
        if (!empty($keyword)) {
            $this->db->like('Name', $keyword);
        }

        if ($status !== null && $status !== '') {
            $this->db->where('Status', (int)$status);
        }

        $this->db->order_by('Status', 'DESC');
        $this->db->order_by('Name', 'ASC');

        $query = $this->db->get('category', $limit, $offset);
        return $query->result();
    }
    public function selectCategoryById($CategoryID)
    {
        $query = $this->db->get_where('category', ['CategoryID' => $CategoryID]);
        return $query->row();
    }

    public function updateCategory($CategoryID, $data)
    {
        return $this->db->update('category', $data, ['CategoryID' => $CategoryID]);
    }


    // public function bulkupdateCategory($category_ids, $new_status)
    // {
    //     foreach ($category_ids as $category_id) {

    //         $data = [
    //             'Status' => $new_status,
    //         ];
    //         $result = $this->db->update('category', $data, ['CategoryID' => $category_id]);
    //     }
    //     $this->session->set_flashdata('success', 'Cập nhật thành công');
    //     redirect(base_url('category/list'));
    // }


    public function bulkupdateCategory($category_ids, $new_status)
    {
        $this->db->trans_begin();

        foreach ($category_ids as $category_id) {
            $data = ['Status' => $new_status];
            $this->db->update('category', $data, ['CategoryID' => $category_id]);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }



    public function checkCategoryInProducts($CategoryID)
    {
        $this->db->select('id');
        $this->db->from('products');
        $this->db->where('category_id', $CategoryID);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    public function deleteCategory($CategoryID)
    {
        return $this->db->delete('category', ['CategoryID' => $CategoryID]);
    }
}
