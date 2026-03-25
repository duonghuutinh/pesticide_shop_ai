<?php
class orderModel extends CI_Model
{

    public function newShipping($data)
    {
        $this->db->insert('shipping', $data);
        return $form_of_payment_id = $this->db->insert_id();
    }
    public function insert_order($data_order)
    {
        $this->db->insert('orders', $data_order);
        return $order_id = $this->db->insert_id();
    }

    public function insert_order_detail($data_order_detail)
    {
        $this->db->insert('order_detail', $data_order_detail);
        return $order_detail_id = $this->db->insert_id();
    }

    // public function get_qty_product_insert_to_order_batches($product_id, $quantity)
    // {

    //     $sql = "
    //         WITH BatchPriority AS (
    //             SELECT 
    //                 Batch_ID, 
    //                 ProductID, 
    //                 Expiry_date, 
    //                 remaining_quantity,
    //                 ROW_NUMBER() OVER (ORDER BY Expiry_date ASC) AS RowNum
    //             FROM batches
    //             WHERE ProductID = ? AND remaining_quantity > 0
    //         ),
    //         SelectedBatches AS (
    //             SELECT 
    //                 Batch_ID, 
    //                 ProductID, 
    //                 Expiry_date, 
    //                 remaining_quantity,
    //                 RowNum,
    //                 SUM(remaining_quantity) OVER (ORDER BY RowNum) AS AccumulatedQuantity
    //             FROM BatchPriority
    //         )
    //         SELECT 
    //             Batch_ID, 
    //             CASE 
    //                 WHEN AccumulatedQuantity <= ? THEN remaining_quantity
    //                 ELSE ? - (AccumulatedQuantity - remaining_quantity)
    //             END AS QuantityToTake
    //         FROM SelectedBatches
    //         WHERE AccumulatedQuantity - remaining_quantity < ?
    //     ";

    //     $query = $this->db->query($sql, [$product_id, $quantity, $quantity, $quantity]);
    //     return $query->result_array();
    // }


    public function getOrderStatus($order_code)
    {
        return $this->db->select('Order_Status')
            ->where('Order_Code', $order_code)
            ->get('orders')
            ->row()
            ->Order_Status;
    }


    public function get_qty_product_in_batches($product_id, $quantity)
    {

        if (empty($product_id) || $quantity <= 0) {
            return [];
        }

        $sql = "
        WITH BatchPriority AS (
            SELECT 
                Batch_ID, 
                ProductID, 
                Expiry_date, 
                remaining_quantity,
                ROW_NUMBER() OVER (ORDER BY Expiry_date ASC) AS RowNum
            FROM batches
            WHERE ProductID = ? AND remaining_quantity > 0
        ),
        SelectedBatches AS (
            SELECT 
                Batch_ID, 
                ProductID, 
                Expiry_date, 
                remaining_quantity,
                RowNum,
                SUM(remaining_quantity) OVER (ORDER BY RowNum) AS AccumulatedQuantity
            FROM BatchPriority
        )
        SELECT 
            Batch_ID, 
            CASE 
                WHEN AccumulatedQuantity <= ? THEN remaining_quantity
                ELSE ? - (AccumulatedQuantity - remaining_quantity)
            END AS QuantityToTake
        FROM SelectedBatches
        WHERE AccumulatedQuantity - remaining_quantity < ?";

        $query = $this->db->query($sql, [$product_id, $quantity, $quantity, $quantity]);

        if (!$query) {
            return [];
        }
        $batches = $query->result_array();
        $totalQuantity = 0;
        foreach ($batches as $batch) {
            $totalQuantity += $batch['QuantityToTake'];
        }
        $shortage = max(0, $quantity - $totalQuantity);
        return [
            'batches' => $batches,
            'totalQuantity' => $totalQuantity,
            'shortage' => $shortage
        ];
    }


    public function deductBatchQuantity($batch_id, $quantity_to_deduct)
    {
        $this->db->set('remaining_quantity', 'remaining_quantity - ' . (int) $quantity_to_deduct, false);
        $this->db->where('Batch_ID', $batch_id);
        $this->db->update('batches');
    }


    public function insert_order_batches($data_order_batches)
    {
        return $this->db->insert('order_batches', $data_order_batches);
    }




    public function process_order_status_update($value, $order_codes, $product_qty_in_batch = [])
    {
        $this->load->library('session');
        $invalid_orders = [];
        $missing_batch_data = [];

        foreach ($order_codes as $order_code) {
            $current_status = $this->getOrderStatus($order_code);
            if ($current_status > $value) {
                $invalid_orders[] = $order_code;
            }
        }

        if (!empty($invalid_orders)) {
            return [
                'success' => false,
                'message' => 'Không thể cập nhật trạng thái cho các đơn hàng đã ở trạng thái cao hơn: ' . implode(', ', $invalid_orders),
            ];
        }

        $timenow = Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();

        foreach ($order_codes as $order_code) {
            $order_details = $this->selectOrderDetails($order_code);
            // echo '<pre>';
            // print_r($order_details);
            // echo '</pre>';
            // die();
            if ((int)$value === 4) {
                $found = false;

                // Duyệt qua từng sản phẩm trong đơn hàng
                foreach ($order_details as $order_detail) {
                    $product_id = $order_detail->ProductID;
                    $quantity = $order_detail->qty;
                    $order_detail_id = $order_detail->order_detail_id;


                    $batch_data = $this->get_qty_product_in_batches($product_id, $quantity);


                    // echo '<pre>';
                    // print_r($batch_data);
                    // echo '</pre>';
                    // die();


                    if (!empty($batch_data['batches'])) {
                        foreach ($batch_data['batches'] as $batch) {
                            $batch_id = $batch['Batch_ID'];

                            // echo $batch_id; die();

                            $quantity_to_take = $batch['QuantityToTake'];
                            // Cập nhật số lượng cho batch
                            $this->deductBatchQuantity($batch_id, $quantity_to_take);
                            $this->insert_order_batches([
                                'order_detail_id' => $order_detail_id,
                                'batch_id' => $batch_id,
                                'quantity' => $quantity_to_take
                            ]);
                            $found = true;
                        }
                    }
                }

                if ($found) {
                    $data_order = [
                        'Order_Status' => 4,
                        'Payment_Status' => 1,
                        'Date_delivered' => $timenow,
                        'Payment_date_successful' => $timenow
                    ];
                    $this->updateOrder($data_order, $order_code);
                } else {
                    $missing_batch_data[] = $order_code;
                }
            } else {

                $this->updateOrder(['Order_Status' => $value], $order_code);
            }
        }

        if (!empty($missing_batch_data)) {
            return [
                'success' => false,
                'message' => 'Thiếu dữ liệu lô hàng cho đơn: ' . implode(', ', $missing_batch_data)
            ];
        }

        return [
            'success' => true,
            'message' => 'Cập nhật trạng thái đơn hàng thành công.'
        ];
    }





    // public function selectOrder($limit, $start, $filter = [])
    // {
    //     $this->db->select('orders.*, shipping.*')
    //         ->from('orders')
    //         ->join('shipping', 'orders.ShippingID = shipping.id')
    //         ->order_by('(CASE WHEN orders.Order_Status = -1 THEN 0 ELSE 1 END)', 'ASC')
    //         ->order_by('orders.Order_Status', 'ASC')
    //         ->order_by('orders.Date_Order', 'DESC');

    //     if (!empty($filter['keyword'])) {
    //         $this->db->group_start()
    //             ->like('orders.Order_code', $filter['keyword'])
    //             ->or_like('shipping.Name', $filter['keyword'])
    //             ->or_like('shipping.Phone', $filter['keyword'])
    //             ->or_like('shipping.Email', $filter['keyword'])
    //             ->or_like('shipping.Address', $filter['keyword'])
    //             ->group_end();
    //     }

    //     if ($filter['status'] !== '' && $filter['status'] !== null) {
    //         $this->db->where('orders.Order_Status', $filter['status']);
    //     }

    //     if (!empty($filter['checkout_method'])) {
    //         $this->db->where('shipping.checkout_method', $filter['checkout_method']);
    //     }
    //     if (!empty($filter['date_from'])) {
    //         $this->db->where('orders.Date_Order >=', $filter['date_from'] . ' 00:00:00');
    //     }

    //     if (!empty($filter['date_to'])) {
    //         $this->db->where('orders.Date_Order <=', $filter['date_to'] . ' 23:59:59');
    //     }

    //     if (!empty($filter['sort_order']) && in_array($filter['sort_order'], ['asc', 'desc'])) {
    //         $this->db->order_by('orders.Date_Order', $filter['sort_order']);
    //     } else {
    //         $this->db->order_by('orders.Date_Order', 'desc');
    //     }



    //     $this->db->limit($limit, $start);

    //     return $this->db->get()->result();
    // }

    public function selectOrder($limit, $start, $filter = [])
    {
        $this->db->select('orders.*, shipping.*')
            ->from('orders')
            ->join('shipping', 'orders.ShippingID = shipping.id');

        // Các điều kiện filter
        if (!empty($filter['keyword'])) {
            $this->db->group_start()
                ->like('orders.Order_code', $filter['keyword'])
                ->or_like('shipping.Name', $filter['keyword'])
                ->or_like('shipping.Phone', $filter['keyword'])
                ->or_like('shipping.Email', $filter['keyword'])
                ->or_like('shipping.Address', $filter['keyword'])
                ->group_end();
        }

        if ($filter['status'] !== '' && $filter['status'] !== null) {
            $this->db->where('orders.Order_Status', $filter['status']);
        }

        if (!empty($filter['checkout_method'])) {
            $this->db->where('shipping.checkout_method', $filter['checkout_method']);
        }

        if (!empty($filter['date_from'])) {
            $this->db->where('orders.Date_Order >=', $filter['date_from'] . ' 00:00:00');
        }

        if (!empty($filter['date_to'])) {
            $this->db->where('orders.Date_Order <=', $filter['date_to'] . ' 23:59:59');
        }



        if (!empty($filter['sort_total_amount'])) {
            $direction = strtolower($filter['sort_total_amount']) === 'asc' ? 'asc' : 'desc';
            $this->db->order_by('orders.TotalAmount', $direction);
        } elseif (!empty($filter['sort_order']) && in_array($filter['sort_order'], ['asc', 'desc'])) {
            $this->db->order_by('orders.Date_Order', $filter['sort_order']);
        } else {
            $this->db->order_by('(CASE 
            WHEN orders.Order_Status = -1 THEN 0
            WHEN orders.Order_Status = 1 THEN 1
            WHEN orders.Order_Status = 2 THEN 2
            WHEN orders.Order_Status = 3 THEN 3
            WHEN orders.Order_Status = 4 THEN 4
            WHEN orders.Order_Status = 5 THEN 5
            ELSE 6
        END)', 'ASC');

            $this->db->order_by('orders.Date_Order', $filter['sort_order'] ?? 'desc');
        }

        // Áp dụng phân trang
        $this->db->limit($limit, $start);

        return $this->db->get()->result();
    }











    public function countOrder($filter = [])
    {
        $this->db->from('orders')
            ->join('shipping', 'orders.ShippingID = shipping.id');

        if (!empty($filter['keyword'])) {
            $this->db->group_start()
                ->like('shipping.Name', $filter['keyword'])
                ->or_like('shipping.Phone', $filter['keyword'])
                ->or_like('shipping.Email', $filter['keyword'])
                ->or_like('shipping.Address', $filter['keyword'])
                ->group_end();
        }

        if ($filter['status'] !== '' && $filter['status'] !== null) {
            $this->db->where('orders.Order_Status', $filter['status']);
        }

        if (!empty($filter['checkout_method'])) {
            $this->db->where('shipping.checkout_method', $filter['checkout_method']);
        }
        if (!empty($filter['date_from'])) {
            $this->db->where('orders.Date_Order >=', $filter['date_from'] . ' 00:00:00');
        }

        if (!empty($filter['date_to'])) {
            $this->db->where('orders.Date_Order <=', $filter['date_to'] . ' 23:59:59');
        }


        return $this->db->count_all_results();
    }





    // public function getOrderByUserId($user_id)
    // {
    //     $query = $this->db->select('orders.*, order_detail.*, shipping.*')
    //         ->from('orders')
    //         ->join('order_detail', 'orders.Order_Code = order_detail.Order_Code', '')
    //         ->join('shipping', 'orders.ShippingID = shipping.id')
    //         ->where('shipping.user_id', $user_id)
    //         ->order_by('orders.Date_Order', 'DESC')
    //         ->get();
    //     return $query->result();
    // }


    public function getOrderByUserId($user_id)
    {
        $query = $this->db->select('orders.*, order_detail.*, shipping.*')
            ->from('orders')
            ->join('order_detail', 'orders.Order_Code = order_detail.Order_Code')
            ->join('shipping', 'orders.ShippingID = shipping.id')
            ->where('shipping.user_id', $user_id)
            ->order_by("FIELD(orders.Order_Status, -1, 1, 2, 3, 4, 5)")
            ->order_by('orders.Date_Order', 'DESC')
            ->get();

        return $query->result();
    }




    public function selectOrderDetails($orderCode)
    {
        $query = $this->db->select('
            orders.Order_Code, 
            orders.TotalAmount, 
            orders.DiscountID,
            orders.Order_Status as order_status,
            orders.Payment_Status as payment_status,
            order_detail.id as order_detail_id,
            order_detail.Subtotal as sub, 
            order_detail.Quantity as qty, 
            order_detail.Order_Code, 
            order_detail.ProductID, 
            product.*,
            shipping.*,
            discount.Coupon_code,
            discount.Discount_type,
            discount.Discount_value,
            discount.Min_order_value,
         
        ')
            ->from('order_detail')
            ->join('product', 'order_detail.ProductID = product.ProductID', 'left')
            ->join('orders', 'orders.Order_Code = order_detail.Order_Code')
            ->join('shipping', 'orders.ShippingID = shipping.id')
            ->join('discount', 'orders.DiscountID = discount.DiscountID', 'left')
            ->where('order_detail.Order_Code', $orderCode)
            ->get();

        return $query->result();
    }


    public function printOrderDetails($orderCode)
    {
        $query = $this->db->select('orders.Order_Code, order_detail.id as order_detail_id,
                                    orders.Order_Status as order_status,
                                    orders.Payment_Status as payment_status,
                                    order_detail.Subtotal as sub, 
                                    order_detail.Quantity as qty, 
                                    order_detail.Order_Code, 
                                    order_detail.ProductID, 
                                    product.*, shipping.*')
            ->from('order_detail')
            ->join('product', 'order_detail.ProductID = product.ProductID', 'left')
            ->join('orders', 'orders.Order_Code = order_detail.Order_Code')
            ->join('shipping', 'orders.ShippingID = shipping.id')
            ->where('order_detail.Order_Code', $orderCode)
            ->get();

        return $query->result();
    }

    public function deleteOrderBatches($order_detail_id)
    {
        $this->db->where_in('order_detail_id', $order_detail_id);
        return $this->db->delete('order_batches');
    }


    public function deleteOrderDetails($Order_Code)
    {
        $this->db->where_in('Order_Code', $Order_Code);
        return $this->db->delete('order_detail');
    }


    public function deleteShipping($ShippingID)
    {
        return $this->db->delete('Shipping', ['id' => $ShippingID]);
    }

    public function deleteOrder($Order_Code)
    {

        $this->db->select('ShippingID');
        $this->db->where('Order_Code', $Order_Code);
        $query = $this->db->get('orders');
        $result = $query->row();

        if ($result) {
            $ShippingID = $result->ShippingID;
            $this->db->delete('orders', ['Order_Code' => $Order_Code]);
            return $ShippingID;
        }
        return false;
    }

    public function updateOrder($data_order, $Order_Code)
    {
        return $this->db->update('orders', $data_order, ['Order_Code' => $Order_Code]);
    }
    public function updateOrderDetails($data_order_details, $Order_Code)
    {
        return $this->db->update('order_detail', $data_order_details, ['Order_Code' => $Order_Code]);
    }


    public function selectDiscountCode($filter, $limit, $start)
    {
        $this->db->select('*')->from('discount');

        // Lọc theo từ khóa (keyword)
        if (!empty($filter['keyword'])) {
            $this->db->group_start();
            $this->db->like('Coupon_code', $filter['keyword']);
            $this->db->or_like('Discount_type', $filter['keyword']);
            $this->db->group_end();
        }


        if (isset($filter['status']) && $filter['status'] !== null) {
            $this->db->group_start();
            if ($filter['status'] == 1) {
                $this->db->where('Status', 1);
                $this->db->where('End_date >=', date('Y-m-d'));
            } elseif ($filter['status'] == 0) {
                $this->db->group_start();
                $this->db->where('Status', 0);
                $this->db->or_where('End_date <', date('Y-m-d'));
                $this->db->group_end();
            }
            $this->db->group_end();
        }

        if (!empty($filter['discount_type'])) {
            $this->db->where('Discount_type', $filter['discount_type']);
        }

        if (!empty($filter['date_from'])) {
            $this->db->where('Start_date >=', $filter['date_from']);
        }

        // Lọc theo ngày kết thúc (date_to)
        if (!empty($filter['date_to'])) {
            $this->db->where('End_date <=', $filter['date_to']);
        }

        // Giới hạn số bản ghi và bắt đầu từ đâu
        $this->db->limit($limit, $start);

        return $this->db->get()->result();
    }

    public function countDiscountCode($filter)
    {
        $this->db->from('discount');

        // Lọc theo từ khóa (keyword)
        if (!empty($filter['keyword'])) {
            $this->db->group_start();
            $this->db->like('Coupon_code', $filter['keyword']);
            $this->db->or_like('Discount_type', $filter['keyword']);
            $this->db->group_end();
        }

        // Lọc theo trạng thái (status)
        if (isset($filter['status']) && $filter['status'] !== null) {
            $this->db->group_start();
            if ($filter['status'] == 1) {
                $this->db->where('Status', 1);
                $this->db->where('End_date >=', date('Y-m-d'));
            } elseif ($filter['status'] == 0) {
                $this->db->group_start();
                $this->db->where('Status', 0);
                $this->db->or_where('End_date <', date('Y-m-d'));
                $this->db->group_end();
            }
            $this->db->group_end();
        }

        if (!empty($filter['discount_type'])) {
            $this->db->where('Discount_type', $filter['discount_type']);
        }

        // Lọc theo ngày bắt đầu (date_from)
        if (!empty($filter['date_from'])) {
            $this->db->where('Start_date >=', $filter['date_from']);
        }

        // Lọc theo ngày kết thúc (date_to)
        if (!empty($filter['date_to'])) {
            $this->db->where('End_date <=', $filter['date_to']);
        }

        return $this->db->count_all_results();
    }




    public function getDiscountSummaryByType()
    {
        $sql = "
    SELECT 
        Discount_type,
        COUNT(*) as total,
        SUM(CASE WHEN Status = 1 AND End_date >= CURDATE() THEN 1 ELSE 0 END) as active,
        SUM(CASE WHEN Status = 1 AND End_date < CURDATE() THEN 1 ELSE 0 END) as expired
    FROM discount
    GROUP BY Discount_type
    ";

        return $this->db->query($sql)->result();
    }




    public function insertDiscountCode($data)
    {
        return $this->db->insert('discount', $data);
    }

    public function markCouponAsUsed($coupon_id)
    {
        $this->db->where('DiscountID', $coupon_id);
        return $this->db->update('discount', ['Status' => 0]);
    }



    public function selectDiscountById($DiscountID)
    {
        $query = $this->db->get_where('discount', ['DiscountID' => $DiscountID]);
        return $query->row();
    }

    public function updateDiscountCode($DiscountID, $new_data)
    {
        return $this->db->update('discount', $new_data, ['DiscountID' => $DiscountID]);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    public function checkCouponCodeExists($code)
    {
        return $this->db->where('Coupon_code', $code)->count_all_results('discount') > 0;
    }


    public function deleteDiscountCode($DiscountID)
    {
        return $this->db->delete('discount', ['DiscountID' => $DiscountID]);
    }


    public function bulkupdateDiscount($discount_code_ids, $new_status)
    {
        foreach ($discount_code_ids as $discount_code_id) {
            $data = [
                'Status' => $new_status,
            ];
            $this->db->update('discount', $data, ['DiscountID' => $discount_code_id]);
        }
        $this->session->set_flashdata('success', 'Cập nhật thành công');
        redirect(base_url('discount-code/list'));
    }

    public function cancelOrderByCode($Order_Code)
    {

        $this->db->select('Order_Status');
        $this->db->from('orders');
        $this->db->where('Order_Code', $Order_Code);
        $order = $this->db->get()->row();

        if ($order && in_array($order->Order_Status, [-1, 1, 2])) {

            $this->db->where('Order_Code', $Order_Code);
            return $this->db->update('orders', ['Order_Status' => 5]);
        }

        return false;
    }
}
