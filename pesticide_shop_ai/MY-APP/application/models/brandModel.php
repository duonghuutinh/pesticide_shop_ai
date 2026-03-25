<?php
class brandModel extends CI_Model
{
    public function insertBrand($data)
    {
        return $this->db->insert('brand', $data);
    }



    public function countBrand($keyword = null, $status = null)
    {
        if (!empty($keyword)) {
            $this->db->like('Name', $keyword);
        }

        if ($status !== null && $status !== '') {
            $this->db->where('Status', (int)$status);
        }

        return $this->db->count_all_results('brand');
    }
    public function selectBrand($keyword = null, $status = null, $limit = 10, $offset = 0)
    {
        if (!empty($keyword)) {
            $this->db->like('Name', $keyword);
        }

        if ($status !== null && $status !== '') {
            $this->db->where('Status', (int)$status);
        }

        $this->db->order_by('Status', 'DESC');
        $this->db->order_by('Name', 'ASC');

        $query = $this->db->get('brand', $limit, $offset);
        return $query->result();
    }




    public function selectBrandById($BrandID)
    {
        $query = $this->db->get_where('brand', ['BrandID' => $BrandID]);
        return $query->row();
    }

    public function updateBrand($BrandID, $data)
    {
        return $this->db->update('brand', $data, ['BrandID' => $BrandID]);
    }



    // public function bulkupdateBrand($brand_ids, $new_status)
    // {
    //     foreach ($brand_ids as $brand_id) {
    //         $data = [
    //             'Status' => $new_status,
    //         ];
    //         $this->db->update('brand', $data, ['BrandID' => $brand_id]);
    //     }
    //     $this->session->set_flashdata('success', 'Cập nhật thành công');
    //     redirect(base_url('brand/list'));
    // }



    public function bulkupdateBrand($brand_ids, $new_status)
    {
        $this->db->trans_begin();

        foreach ($brand_ids as $brand_id) {
            $data = ['Status' => $new_status];
            $this->db->update('brand', $data, ['BrandID' => $brand_id]);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Có lỗi xảy ra khi cập nhật');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Cập nhật thành công');
        }

        redirect(base_url('brand/list'));
    }


    public function checkBrandInProducts($brand_id)
    {
        return $this->db->where('brand_id', $brand_id)->count_all_results('products') > 0;
    }


    // public function deleteBrand($BrandID)
    // {
    //     return $this->db->delete('brand', ['BrandID' => $BrandID]);
    // }
}
