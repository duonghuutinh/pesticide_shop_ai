<?php
class loginModel extends CI_Model
{
    public function checkLoginAdmin($email) {
        $query = $this->db->where('email', $email)->where('status', 1)->where('role_id', 1)->get('users');
        return $query->result();
    }
    
    public function checkLoginCustomer($email)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return [];
        }
    }
    public function checkEmailExists($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }
    
    public function newCustomer($data)
    {
        return $this->db->insert('users', $data);

    }
    public function newUserAdmin($data)
    {
        return $this->db->insert('users', $data);

    }



}

?>