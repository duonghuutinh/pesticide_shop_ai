<?php
class supplierModel extends CI_Model
{
    public function insertSupplier($data)
    {
        return $this->db->insert('suppliers', $data);
    }

    

    // public function selectBrand($keyword = null, $status = null, $limit = 20)
    // {
    //     if (!empty($keyword)) {
    //         $this->db->like('Name', $keyword);
    //     }

    //     if ($status !== null && $status !== '') {
    //         $this->db->where('Status', (int)$status);
    //     }

    //     $this->db->order_by('Status', 'DESC');
    //     $this->db->order_by('Name', 'ASC');

    //     // Giới hạn số bản ghi hiển thị
    //     $this->db->limit((int)$limit);

    //     $query = $this->db->get('brand');
    //     return $query->result();
    // }


    public function countSupplier($keyword = null, $status = null)
    {
        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('Name', $keyword);
            $this->db->or_like('Phone', $keyword);
            $this->db->or_like('Contact', $keyword);
            $this->db->group_end();
        }
        if ($status !== null && $status !== '') {
            $this->db->where('Status', (int)$status);
        }

        return $this->db->count_all_results('suppliers');
    }
    public function selectSupplier($keyword = null, $status = null, $limit = 10, $offset = 0)
    {
        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('Name', $keyword);
            $this->db->or_like('Phone', $keyword);
            $this->db->or_like('Contact', $keyword);
            $this->db->group_end();
        }

        if ($status !== null && $status !== '') {
            $this->db->where('Status', (int)$status);
        }

        $this->db->order_by('Status', 'DESC');
        $this->db->order_by('Name', 'ASC');

        $query = $this->db->get('suppliers', $limit, $offset);
        return $query->result();
    }




    public function selectSupplierById($SupplierID)
    {
        $query = $this->db->get_where('suppliers', ['SupplierID' => $SupplierID]);
        return $query->row();
    }

    public function updateSupplier($SupplierID, $data)
    {
        return $this->db->update('suppliers', $data, ['SupplierID' => $SupplierID]);
    }



    public function bulkupdateSupplier($supplier_ids, $new_status)
    {
        foreach ($supplier_ids as $supplier_id) {
            $data = [
                'Status' => $new_status,
            ];
            $this->db->update('suppliers', $data, ['SupplierID' => $supplier_id]);
        }
        $this->session->set_flashdata('success', 'Cập nhật thành công');
        redirect(base_url('supplier/list'));
    }

}
