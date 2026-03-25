<?php
class checkoutModel extends CI_Model
{
    public function newShipping($data)
    {
        $this->db->insert('shipping', $data);
        return $ShippingID = $this->db->insert_id();

    }
    public function insert_orders($data_orders)
    {
        return $this->db->insert('orders', $data_orders);

    }

    public function insert_orders_details($data_orders_details)
    {
        return $this->db->insert('orders_details', $data_orders_details);

    }


}

?>