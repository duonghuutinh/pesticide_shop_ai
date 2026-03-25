<?php
class customerModel extends CI_Model
{

    public function countCustomer($filter = [])
    {
        $this->db->from('users');
            // ->where('users.Deleted_at IS NULL');

        if (isset($filter['status']) && $filter['status'] !== '') {
            $this->db->where('users.Status', $filter['status']);
        }

        if (isset($filter['role_id']) && $filter['role_id'] !== '') {
            $this->db->where('users.Role_ID', $filter['role_id']);
        }

        if (!empty($filter['keyword'])) {
            $this->db->group_start()
                ->like('users.Name', $filter['keyword'])
                ->or_like('users.Email', $filter['keyword'])
                ->or_like('users.Phone', $filter['keyword'])
                ->group_end();
        }

        return $this->db->count_all_results();
    }


    // public function getCustomers($limit, $offset, $filter = [])
    // {
    //     $this->db->select('users.*, role.Role_name')
    //         ->from('users')
    //         ->join('role', 'users.Role_ID = role.Role_ID')
    //         ->where('users.Deleted_at IS NULL');

    //     if (isset($filter['status']) && $filter['status'] !== '') {
    //         $this->db->where('users.Status', $filter['status']);
    //     }

    //     if (isset($filter['role_id']) && $filter['role_id'] !== '') {
    //         $this->db->where('users.Role_ID', $filter['role_id']);
    //     }

    //     if (!empty($filter['keyword'])) {
    //         $this->db->group_start()
    //             ->like('users.Name', $filter['keyword'])
    //             ->or_like('users.Email', $filter['keyword'])
    //             ->or_like('users.Phone', $filter['keyword'])
    //             ->group_end();
    //     }

    //     $this->db->order_by('users.UserID', 'DESC');
    //     $this->db->limit($limit, $offset);

    //     return $this->db->get()->result();
    // }


    public function getCustomers($limit, $offset, $filter = [])
    {
        $this->db->select('users.*, role.Role_name, COALESCE(SUM(orders.TotalAmount), 0) as total_spent')
            ->from('users')
            ->join('role', 'users.Role_ID = role.Role_ID', 'left')
            ->join('shipping', 'shipping.user_id = users.UserID', 'left')
            ->join('orders', 'orders.ShippingID = shipping.id AND orders.Order_Status = 4 AND orders.Payment_Status = 1', 'left');
            // ->where('users.Deleted_at IS NULL');

        if (isset($filter['status']) && $filter['status'] !== '') {
            $this->db->where('users.Status', $filter['status']);
        }

        if (isset($filter['role_id']) && $filter['role_id'] !== '') {
            $this->db->where('users.Role_ID', $filter['role_id']);
        }

        if (!empty($filter['keyword'])) {
            $this->db->group_start()
                ->like('users.Name', $filter['keyword'])
                ->or_like('users.Email', $filter['keyword'])
                ->or_like('users.Phone', $filter['keyword'])
                ->group_end();
        }

        $this->db->group_by('users.UserID');

        if (!empty($filter['sort_totalamount'])) {
            $this->db->order_by('total_spent', $filter['sort_totalamount']);
        } else {
            $this->db->order_by('users.UserID', 'DESC');
        }

        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }


    public function getAllRole($limit = null, $offset = null, $filter = [])
    {
        $this->db->select('
            role.Role_ID, 
            role.Role_name, 
            role.Description, 
            COUNT(users.UserID) as Total_Users,
            SUM(CASE WHEN users.Status = 1 THEN 1 ELSE 0 END) as Active_Users,
            SUM(CASE WHEN users.Status = 0 THEN 1 ELSE 0 END) as Locked_Users
        ');
        $this->db->from('role');
        $this->db->join('users', 'role.Role_ID = users.Role_ID', 'left');

        // --- Filter ---
        if (!empty($filter['keyword'])) {
            $this->db->group_start();
            $this->db->like('role.Role_name', $filter['keyword']);
            $this->db->or_like('role.Description', $filter['keyword']);
            $this->db->group_end();
        }

        $this->db->group_by('role.Role_ID');

        // --- Limit + Offset ---
        if (!is_null($limit)) {
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();
        return $query->result();
    }


    public function countAllRoles($filter = [])
    {
        $this->db->from('role');

        if (!empty($filter['keyword'])) {
            $this->db->group_start();
            $this->db->like('Role_name', $filter['keyword']);
            $this->db->or_like('Description', $filter['keyword']);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }




    public function selectCustomerById($UserID)
    {
        $query = $this->db->get_where('users', ['UserID' => $UserID]);
        return $query->row();
    }
    public function selectRoleById($Role_ID)
    {
        $query = $this->db->get_where('role', ['Role_ID' => $Role_ID]);
        return $query->row();
    }


    public function updateRole($Role_ID, $data)
    {
        return $this->db->update('role', $data, ['Role_ID' => $Role_ID]);
    }

    public function updateCustomer($UserID, $data)
    {
        return $this->db->update('users', $data, ['UserID' => $UserID]);
    }



    // public function bulkupdateCustomer($customer_ids, $new_status){
    //     foreach ($customer_ids as $customer_id) {
    //         $data = [
    //             'Status' => $new_status,
    //         ];
    //         $this->db->update('users', $data, ['UserID' => $customer_id]);
    //     }
    //     $this->session->set_flashdata('success', 'Cập nhật thành công');
    //     redirect(base_url('manage-customer/list'));
    // }


    public function bulkupdateCustomer($customer_ids, $new_status){
        $this->db->where_in('UserID', $customer_ids);
        $this->db->update('users', ['Status' => $new_status]);
    
        $this->session->set_flashdata('success', 'Cập nhật thành công');
        redirect(base_url('manage-customer/list'));
    }
    


    public function getCustomerByEmailAndPhone($email, $phone)
    {
        $query = $this->db->get_where('users', ['Email' => $email, 'Phone' => $phone, 'Role_ID' => 2]);
        return $query->row();
    }


    public function getCustomerByEmail($email)
    {
        $query = $this->db->get_where('users', ['email' => $email, 'role_id' => 2]);
        return $query->row();
    }

    public function updateCustomerForgotPassword($email, $phone, $update_data)
    {
        // Kiểm tra dữ liệu đầu vào
        if (is_array($update_data)) {
            $this->db->where('email', $email);
            $this->db->or_where('phone', $phone);
            $this->db->where('role_id', 2);
            return $this->db->update('users', $update_data);
        } else {
            // Ghi log hoặc xử lý lỗi nếu update_data không phải là mảng
            log_message('error', 'update_data không phải là mảng.');
            return false;
        }
    }

    public function updateCustomerChangePassword($email, $phone, $update_data)
    {
   
        if (is_array($update_data)) {
            $this->db->where('email', $email);
            $this->db->or_where('phone', $phone);
            $this->db->where('role_id', 2);
            return $this->db->update('users', $update_data);
        } else {
            log_message('error', 'update_data không phải là mảng.');
            return false;
        }
    }


    public function updateTokenCustomer($update_data, $email, $phone)
    {
        $this->db->where('email', $email);
        $this->db->or_where('phone', $phone);
        $this->db->where('role_id', 2);
        return $this->db->update('users', $update_data);
    }



    public function deleteCustomer($UserID)
    {
        return $this->db->delete('users', ['UserID' => $UserID]);
    }
}
