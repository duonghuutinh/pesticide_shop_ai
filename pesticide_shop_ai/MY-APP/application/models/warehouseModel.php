<?php
class warehouseModel extends CI_Model
{
    public function getLatestReceiptNumber()
    {
        $this->db->select_max('id');
        $query = $this->db->get('warehouse_receipt');
        $result = $query->row_array();
        return isset($result['id']) ? $result['id'] + 1 : 1;
    }
    // Đếm số lượng phiếu nhập (tính theo distinct ID)
    public function count_warehouse_receipts()
    {
        $this->db->select('COUNT(DISTINCT id) AS total');
        $this->db->from('warehouse_receipt');
        $query = $this->db->get();
        return (int)$query->row()->total;
    }


    // public function count_warehouse_receipts($filters = [])
    // {
    //     $this->db->select('wr.id');
    //     $this->db->from('warehouse_receipt wr');
    //     $this->db->join('warehouse_receipt_items wri', 'wr.id = wri.Receipt_id', 'left');

    //     // Filter theo ngày tạo
    //     if (!empty($filters['date_start'])) {
    //         $this->db->where('DATE(wr.created_at) >=', $filters['date_start']);
    //     }
    //     if (!empty($filters['date_end'])) {
    //         $this->db->where('DATE(wr.created_at) <=', $filters['date_end']);
    //     }

    //     // Filter theo nhà cung cấp
    //     if (!empty($filters['supplier_id'])) {
    //         $this->db->where('wr.supplier_id', $filters['supplier_id']);
    //     }

    //     // Tìm kiếm theo tên người giao hoặc số phiếu
    //     if (!empty($filters['keyword'])) {
    //         $this->db->group_start();
    //         $this->db->like('wr.name_of_delivery_person', $filters['keyword']);
    //         $this->db->or_like('wr.delivery_note_number', $filters['keyword']);
    //         $this->db->group_end();
    //     }

    //     $this->db->group_by('wr.id');

    //     $sub_sql = $this->db->get_compiled_select();
    //     $this->db->reset_query();

    //     $query = $this->db->query("SELECT COUNT(*) AS total FROM ({$sub_sql}) AS sub");
    //     return (int)$query->row()->total;
    // }


    // public function get_warehouse_receipts_v2($limit, $offset, $filters = [])
    // {
    //     $this->db->select('
    //     wr.tax_identification_number,
    //     wr.id AS warehouse_receipt_id,
    //     wr.created_at,
    //     wr.name_of_delivery_person,
    //     wr.delivery_unit,
    //     wr.address,
    //     wr.delivery_note_number,
    //     wr.warehouse_from,
    //     wr.supplier_id,
    //     s.Name AS supplier_name,
    //     wr.sub_total,
    //     p.Name AS product_name,
    //     p.Product_Code AS product_code,
    //     wri.Unit AS product_unit,
    //     wri.Import_price AS unit_import_price,
    //     wri.Exp_date AS expiry_date,
    //     wri.Quantity_doc AS quantity_document,
    //     wri.Quantity_actual AS quantity_actual,
    //     wri.Notes AS notes
    // ');
    //     $this->db->from('warehouse_receipt wr');
    //     $this->db->join('suppliers s', 'wr.supplier_id = s.SupplierID', 'left');
    //     $this->db->join('warehouse_receipt_items wri', 'wr.id = wri.Receipt_id', 'left');
    //     $this->db->join('product p', 'wri.ProductID = p.ProductID', 'left');

    //     // --- Filters ---
    //     if (!empty($filters['date_start'])) {
    //         $this->db->where('DATE(wr.created_at) >=', $filters['date_start']);
    //     }
    //     if (!empty($filters['date_end'])) {
    //         $this->db->where('DATE(wr.created_at) <=', $filters['date_end']);
    //     }
    //     if (!empty($filters['supplier_id'])) {
    //         $this->db->where('wr.supplier_id', $filters['supplier_id']);
    //     }
    //     if (!empty($filters['keyword'])) {
    //         $this->db->group_start();
    //         $this->db->like('wr.name_of_delivery_person', $filters['keyword']);
    //         $this->db->or_like('wr.delivery_note_number', $filters['keyword']);
    //         $this->db->group_end();
    //     }

    //     // --- Sort ---
    //     switch ($filters['sort_by']) {
    //         case 'sub_total_asc':
    //             $this->db->order_by('wr.sub_total', 'ASC');
    //             break;
    //         case 'sub_total_desc':
    //             $this->db->order_by('wr.sub_total', 'DESC');
    //             break;
    //         case 'total_quantity_asc':
    //             $this->db->order_by('wri.Quantity_actual', 'ASC');
    //             break;
    //         case 'total_quantity_desc':
    //             $this->db->order_by('wri.Quantity_actual', 'DESC');
    //             break;
    //         default:
    //             $this->db->order_by('wr.id', 'DESC');
    //     }

    //     $this->db->limit($limit, $offset);
    //     $query = $this->db->get();
    //     $raw_data = $query->result_array();

    //     // --- Grouping by receipt_id ---
    //     $grouped_data = [];

    //     foreach ($raw_data as $row) {
    //         $receipt_id = $row['warehouse_receipt_id'];
    //         if (!isset($grouped_data[$receipt_id])) {
    //             $grouped_data[$receipt_id] = [
    //                 'warehouse_receipt_id' => $row['warehouse_receipt_id'],
    //                 'tax_identification_number' => $row['tax_identification_number'],
    //                 'created_at' => $row['created_at'],
    //                 'name_of_delivery_person' => $row['name_of_delivery_person'],
    //                 'delivery_unit' => $row['delivery_unit'],
    //                 'address' => $row['address'],
    //                 'delivery_note_number' => $row['delivery_note_number'],
    //                 'warehouse_from' => $row['warehouse_from'],
    //                 'supplier_id' => $row['supplier_id'],
    //                 'supplier_name' => $row['supplier_name'],
    //                 'sub_total' => $row['sub_total'],
    //                 'product_items' => [],
    //             ];
    //         }

    //         if (!empty($row['product_name'])) {
    //             $grouped_data[$receipt_id]['product_items'][] = [
    //                 'product_name' => $row['product_name'],
    //                 'product_code' => $row['product_code'],
    //                 'product_unit' => $row['product_unit'],
    //                 'unit_import_price' => $row['unit_import_price'],
    //                 'expiry_date' => $row['expiry_date'],
    //                 'quantity_document' => $row['quantity_document'],
    //                 'quantity_actual' => $row['quantity_actual'],
    //                 'notes' => $row['notes']
    //             ];
    //         }
    //     }

    //     return array_values($grouped_data);
    // }




    public function count_filtered_receipts($filter)
    {
        $this->db->from('warehouse_receipt wr');
        if (!empty($filter['keyword'])) {
            $this->db->group_start();
            $this->db->like('wr.name_of_delivery_person', $filter['keyword']);
            $this->db->or_like('wr.delivery_note_number', $filter['keyword']);
            $this->db->group_end();
        }
        if (!empty($filter['supplier_id'])) {
            $this->db->where('wr.supplier_id', $filter['supplier_id']);
        }
        if (!empty($filter['date_start'])) {
            $this->db->where('DATE(wr.created_at) >=', $filter['date_start']);
        }
        if (!empty($filter['date_end'])) {
            $this->db->where('DATE(wr.created_at) <=', $filter['date_end']);
        }

        return $this->db->count_all_results();
    }

    // public function get_filtered_receipts($filter)
    // {
    //     $this->db->select('
    //     wr.id AS warehouse_receipt_id,
    //     wr.tax_identification_number,
    //     wr.created_at,
    //     wr.name_of_delivery_person,
    //     wr.delivery_unit,
    //     wr.address,
    //     wr.delivery_note_number,
    //     wr.warehouse_from,
    //     wr.supplier_id,
    //     s.Name AS supplier_name,
    //     wr.sub_total');
    //     $this->db->from('warehouse_receipt wr');
    //     $this->db->join('suppliers s', 'wr.supplier_id = s.SupplierID', 'left');

    //     if (!empty($filter['keyword'])) {
    //         $this->db->group_start();
    //         $this->db->like('wr.name_of_delivery_person', $filter['keyword']);
    //         $this->db->or_like('wr.delivery_note_number', $filter['keyword']);
    //         $this->db->group_end();
    //     }

    //     if (!empty($filter['supplier_id'])) {
    //         $this->db->where('wr.supplier_id', $filter['supplier_id']);
    //     }

    //     if (!empty($filter['date_start'])) {
    //         $this->db->where('DATE(wr.created_at) >=', $filter['date_start']);
    //     }

    //     if (!empty($filter['date_end'])) {
    //         $this->db->where('DATE(wr.created_at) <=', $filter['date_end']);
    //     }

    //     if ($filter['sort_by'] == 'sub_total_asc') {
    //         $this->db->order_by('wr.sub_total', 'ASC');
    //     } elseif ($filter['sort_by'] == 'sub_total_desc') {
    //         $this->db->order_by('wr.sub_total', 'DESC');
    //     } elseif ($filter['sort_by'] == 'total_quantity_asc') {
    //         $this->db->order_by('(SELECT SUM(wri.Quantity_actual) FROM warehouse_receipt_items wri WHERE wri.Receipt_id = wr.id)', 'ASC');
    //     } elseif ($filter['sort_by'] == 'total_quantity_desc') {
    //         $this->db->order_by('(SELECT SUM(wri.Quantity_actual) FROM warehouse_receipt_items wri WHERE wri.Receipt_id = wr.id)', 'DESC');
    //     } else {
    //         $this->db->order_by('wr.id', 'DESC');
    //     }


    //     $this->db->limit($filter['limit'], $filter['offset']);

    //     return $this->db->get()->result_array();
    // }

    public function get_filtered_receipts($limit, $offset, $filter)
    {
        $this->db->select('
        wr.id AS warehouse_receipt_id,
        wr.tax_identification_number,
        wr.created_at,
        wr.name_of_delivery_person,
        wr.delivery_unit,
        wr.address,
        wr.delivery_note_number,
        wr.warehouse_from,
        wr.supplier_id,
        s.Name AS supplier_name,
        wr.sub_total,
        SUM(wri.Quantity_actual) AS total_quantity');
        $this->db->from('warehouse_receipt wr');
        $this->db->join('suppliers s', 'wr.supplier_id = s.SupplierID', 'left');
        $this->db->join('warehouse_receipt_items wri', 'wri.Receipt_id = wr.id', 'left');

        // FILTER: từ ngày đến ngày
        if (!empty($filter['start_date'])) {
            $this->db->where('wr.created_at >=', $filter['start_date'] . ' 00:00:00');
        }
        if (!empty($filter['end_date'])) {
            $this->db->where('wr.created_at <=', $filter['end_date'] . ' 23:59:59');
        }

        // FILTER: theo nhà cung cấp
        if (!empty($filter['supplier_id'])) {
            $this->db->where('wr.supplier_id', $filter['supplier_id']);
        }

        // FILTER: tìm theo tên người giao hoặc số phiếu
        if (!empty($filter['keyword'])) {
            $this->db->group_start();
            $this->db->like('wr.name_of_delivery_person', $filter['keyword']);
            $this->db->or_like('wr.delivery_note_number', $filter['keyword']);
            $this->db->group_end();
        }

        // GROUP BY để dùng SUM()
        $this->db->group_by('wr.id');

        // SẮP XẾP (ORDER BY)
        if ($filter['sort_by'] == 'total_quantity_asc') {
            $this->db->order_by('total_quantity', 'ASC');
        } elseif ($filter['sort_by'] == 'total_quantity_desc') {
            $this->db->order_by('total_quantity', 'DESC');
        } elseif ($filter['sort_by'] == 'sub_total_asc') {
            $this->db->order_by('wr.sub_total', 'ASC');
        } elseif ($filter['sort_by'] == 'sub_total_desc') {
            $this->db->order_by('wr.sub_total', 'DESC');
        } else {
            $this->db->order_by('wr.id', 'DESC'); // mặc định
        }

        // PHÂN TRANG
        $this->db->limit($limit, $offset);

        return $this->db->get()->result_array();
    }


    public function get_items_by_receipt_ids($receipt_ids = [])
    {
        if (empty($receipt_ids)) return [];

        $this->db->select('
        wri.Receipt_id,
        p.Name AS product_name,
        p.Product_Code AS product_code,
        wri.Unit AS product_unit,
        wri.Import_price AS unit_import_price,
        wri.Exp_date AS expiry_date,
        wri.Quantity_doc AS quantity_document,
        wri.Quantity_actual AS quantity_actual,
        wri.Notes AS notes
    ');
        $this->db->from('warehouse_receipt_items wri');
        $this->db->join('product p', 'wri.ProductID = p.ProductID', 'left');
        $this->db->where_in('wri.Receipt_id', $receipt_ids);
        $query = $this->db->get()->result_array();

        $result = [];
        foreach ($query as $row) {
            $rid = $row['Receipt_id'];
            unset($row['Receipt_id']);
            $result[$rid][] = $row;
        }

        return $result;
    }



    public function get_warehouse_receipts_v1($limit, $offset)
    {
        $this->db->select('
            wr.tax_identification_number,
            wr.id AS warehouse_receipt_id,
            wr.created_at,
            wr.name_of_delivery_person,
            wr.delivery_unit,
            wr.address,
            wr.delivery_note_number,
            wr.warehouse_from,
            wr.supplier_id,
            s.Name AS supplier_name,
            wr.sub_total,
            p.Name AS product_name,
            p.Product_Code AS product_code,
            wri.Unit AS product_unit,
            wri.Import_price AS unit_import_price,
            wri.Exp_date AS expiry_date,
            wri.Quantity_doc AS quantity_document,
            wri.Quantity_actual AS quantity_actual,
            wri.Notes AS notes
        ');
        $this->db->from('warehouse_receipt wr');
        $this->db->join('suppliers s', 'wr.supplier_id = s.SupplierID', 'left');
        $this->db->join('warehouse_receipt_items wri', 'wr.id = wri.Receipt_id', 'left');
        $this->db->join('product p', 'wri.ProductID = p.ProductID', 'left');
        $this->db->order_by('wr.id DESC');
        $this->db->limit($limit, $offset);

        $query = $this->db->get();
        $raw_data = $query->result_array();

        // Gộp dữ liệu như cũ
        $grouped_data = [];

        foreach ($raw_data as $row) {
            $receipt_id = $row['warehouse_receipt_id'];
            if (!isset($grouped_data[$receipt_id])) {
                $grouped_data[$receipt_id] = [
                    'warehouse_receipt_id' => $row['warehouse_receipt_id'],
                    'tax_identification_number' => $row['tax_identification_number'],
                    'created_at' => $row['created_at'],
                    'name_of_delivery_person' => $row['name_of_delivery_person'],
                    'delivery_unit' => $row['delivery_unit'],
                    'address' => $row['address'],
                    'delivery_note_number' => $row['delivery_note_number'],
                    'warehouse_from' => $row['warehouse_from'],
                    'supplier_id' => $row['supplier_id'],
                    'supplier_name' => $row['supplier_name'],
                    'sub_total' => $row['sub_total'],
                    'product_items' => []
                ];
            }

            if (!empty($row['product_name'])) {
                $grouped_data[$receipt_id]['product_items'][] = [
                    'product_name' => $row['product_name'],
                    'product_code' => $row['product_code'],
                    'product_unit' => $row['product_unit'],
                    'unit_import_price' => $row['unit_import_price'],
                    'expiry_date' => $row['expiry_date'],
                    'quantity_document' => $row['quantity_document'],
                    'quantity_actual' => $row['quantity_actual'],
                    'notes' => $row['notes']
                ];
            }
        }

        return array_values($grouped_data);
    }


    // public function get_warehouse_receipts()
    // {
    //     $this->db->select('
    //         wr.tax_identification_number,
    //         wr.id AS warehouse_receipt_id,
    //         wr.created_at,
    //         wr.name_of_delivery_person,
    //         wr.delivery_unit,
    //         wr.address,
    //         wr.delivery_note_number,
    //         wr.warehouse_from,
    //         wr.supplier_id,
    //         s.Name AS supplier_name,
    //         wr.sub_total,
    //         p.Name AS product_name,
    //         p.Product_Code AS product_code,
    //         wri.Unit AS product_unit,
    //         wri.Import_price AS unit_import_price,
    //         wri.Exp_date AS expiry_date,
    //         wri.Quantity_doc AS quantity_document,
    //         wri.Quantity_actual AS quantity_actual,
    //         wri.Notes AS notes');
    //     $this->db->from('warehouse_receipt wr');
    //     $this->db->join('suppliers s', 'wr.supplier_id = s.SupplierID', 'left');
    //     $this->db->join('warehouse_receipt_items wri', 'wr.id = wri.Receipt_id', 'left');
    //     $this->db->join('product p', 'wri.ProductID = p.ProductID', 'left');
    //     $this->db->order_by('wr.id, p.Name');

    //     $query = $this->db->get();
    //     $raw_data = $query->result_array();

    //     // Gộp dữ liệu theo warehouse_receipt_id
    //     $grouped_data = [];

    //     foreach ($raw_data as $row) {
    //         $receipt_id = $row['warehouse_receipt_id'];

    //         if (!isset($grouped_data[$receipt_id])) {
    //             // Lưu thông tin phiếu nhập
    //             $grouped_data[$receipt_id] = [
    //                 'warehouse_receipt_id' => $row['warehouse_receipt_id'],
    //                 'tax_identification_number' => $row['tax_identification_number'],
    //                 'created_at' => $row['created_at'],
    //                 'name_of_delivery_person' => $row['name_of_delivery_person'],
    //                 'delivery_unit' => $row['delivery_unit'],
    //                 'address' => $row['address'],
    //                 'delivery_note_number' => $row['delivery_note_number'],
    //                 'warehouse_from' => $row['warehouse_from'],
    //                 'supplier_id' => $row['supplier_id'],
    //                 'supplier_name' => $row['supplier_name'],
    //                 'sub_total' => $row['sub_total'],
    //                 'product_items' => []
    //             ];
    //         }

    //         if (!empty($row['product_name'])) {
    //             $grouped_data[$receipt_id]['product_items'][] = [
    //                 'product_name' => $row['product_name'],
    //                 'product_code' => $row['product_code'],
    //                 'product_unit' => $row['product_unit'],
    //                 'unit_import_price' => $row['unit_import_price'],
    //                 'expiry_date' => $row['expiry_date'],
    //                 'quantity_document' => $row['quantity_document'],
    //                 'quantity_actual' => $row['quantity_actual'],
    //                 'notes' => $row['notes']
    //             ];
    //         }
    //     }


    //     return array_values($grouped_data);
    // }



    public function get_warehouse_receipt_by_id($id)
    {
        $this->db->select('
            wr.tax_identification_number,
            wr.id AS warehouse_receipt_id,
            wr.created_at,
            wr.name_of_delivery_person,
            wr.delivery_unit,
            wr.address,
            wr.delivery_note_number,
            wr.warehouse_from,
            wr.supplier_id,
            s.Name AS supplier_name,
            wr.sub_total,
            p.Name AS product_name,
            p.Product_Code AS product_code,
            wri.Unit AS product_unit,
            wri.Import_price AS unit_import_price,
            wri.Exp_date AS expiry_date,
            wri.Quantity_doc AS quantity_document,
            wri.Quantity_actual AS quantity_actual,
            wri.Notes AS notes
        ');
        $this->db->from('warehouse_receipt wr');
        $this->db->join('suppliers s', 'wr.supplier_id = s.SupplierID', 'left');
        $this->db->join('warehouse_receipt_items wri', 'wr.id = wri.Receipt_id', 'left');
        $this->db->join('product p', 'wri.ProductID = p.ProductID', 'left');
        $this->db->where('wr.id', $id);
        $this->db->order_by('p.Name');

        $query = $this->db->get();
        $raw_data = $query->result_array();

        if (empty($raw_data)) {
            return null; // Không tìm thấy phiếu
        }

        $receipt_data = [
            'warehouse_receipt_id' => $raw_data[0]['warehouse_receipt_id'],
            'tax_identification_number' => $raw_data[0]['tax_identification_number'],
            'created_at' => $raw_data[0]['created_at'],
            'name_of_delivery_person' => $raw_data[0]['name_of_delivery_person'],
            'delivery_unit' => $raw_data[0]['delivery_unit'],
            'address' => $raw_data[0]['address'],
            'delivery_note_number' => $raw_data[0]['delivery_note_number'],
            'warehouse_from' => $raw_data[0]['warehouse_from'],
            'supplier_id' => $raw_data[0]['supplier_id'],
            'supplier_name' => $raw_data[0]['supplier_name'],
            'sub_total' => $raw_data[0]['sub_total'],
            'product_items' => []
        ];

        foreach ($raw_data as $row) {
            if (!empty($row['product_name'])) {
                $receipt_data['product_items'][] = [
                    'product_name' => $row['product_name'],
                    'product_code' => $row['product_code'],
                    'product_unit' => $row['product_unit'],
                    'unit_import_price' => $row['unit_import_price'],
                    'expiry_date' => $row['expiry_date'],
                    'quantity_document' => $row['quantity_document'],
                    'quantity_actual' => $row['quantity_actual'],
                    'notes' => $row['notes']
                ];
            }
        }

        return $receipt_data;
    }



    public function insertWarehouseReceiptWithItems($data_warehouse_receipt, $products)
    {
        $this->db->trans_start();
        $this->db->insert('warehouse_receipt', $data_warehouse_receipt);
        $warehouse_receipt_id = $this->db->insert_id();

        if ($warehouse_receipt_id) {
            foreach ($products as $key => $product) {
                $data_warehouse_receipt_items = [
                    'Receipt_id' => $warehouse_receipt_id,
                    'ProductID' => $product['ProductID'] ?? null,
                    'Product_Code' => $product['code'] ?? null,
                    'Unit' => $product['unit'] ?? null,
                    'Import_price' => $product['Import_price'] ?? null,
                    'Exp_date' => $product['Exp_date'] ?? null,
                    'Quantity_doc' => $product['quantity_doc'] ?? null,
                    'Quantity_actual' => $product['quantity_real'] ?? null,
                    'Notes' => $product['note'] ?? null,
                ];
                $this->db->insert('warehouse_receipt_items', $data_warehouse_receipt_items);

                $data_batches = [
                    'Warehouse_Receipt_ID' => $warehouse_receipt_id,
                    'ProductID' => $product['ProductID'] ?? null,
                    'Quantity' => $product['quantity_real'] ?? null,
                    'Import_date' => $data_warehouse_receipt['created_at'] ?? null,
                    'Expiry_date' => $product['Exp_date'] ?? null,
                    'Import_price' => $product['Import_price'] ?? null,
                    'SupplierID' => $data_warehouse_receipt['supplier_id'] ?? null,
                    'remaining_quantity' => $product['quantity_real'] ?? null
                ];
                $this->db->insert('batches', $data_batches);
            }
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $warehouse_receipt_id;
        }
    }


    public function insertWarehouseReceipt($data_warehouse_receipt)
    {
        if ($this->db->insert('warehouse_receipt', $data_warehouse_receipt)) {
            return $this->db->insert_id();
        }
        return false;
    }


    public function insert_order_detail($data_order_detail)
    {
        $this->db->insert('order_detail', $data_order_detail);
        return $order_detail_id = $this->db->insert_id();
    }

    public function get_qty_product_insert_to_order_batches($product_id, $quantity)
    {

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
            WHERE AccumulatedQuantity - remaining_quantity < ?
        ";

        $query = $this->db->query($sql, [$product_id, $quantity, $quantity, $quantity]);
        return $query->result_array();
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
        WHERE AccumulatedQuantity - remaining_quantity < ? ";

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

        // if ($this->db->affected_rows() > 0) {
        //     log_message('error', "Batch_ID: $batch_id - Giảm số lượng thành công: $quantity_to_deduct");
        // } else {
        //     log_message('error', "Lỗi: Không thể cập nhật Batch_ID: $batch_id với số lượng $quantity_to_deduct");
        // }
    }


    public function insert_order_batches($data_order_batches)
    {
        return $this->db->insert('order_batches', $data_order_batches);
    }


    public function selectOrder()
    {
        $query = $this->db->select('orders.*, shipping.*')
            ->from('orders')
            ->join('shipping', 'orders.ShippingID = shipping.id')
            ->order_by('(CASE WHEN orders.Order_Status = -1 THEN 0 ELSE 1 END)', 'ASC')
            ->order_by('orders.Order_Status', 'ASC')
            ->order_by('orders.Date_Order', 'DESC')
            ->get();

        return $query->result();
    }

    public function getOrderByUserId($user_id)
    {
        $query = $this->db->select('orders.*, order_detail.*, shipping.*')
            ->from('orders')
            ->join('order_detail', 'orders.Order_Code = order_detail.Order_Code', '')
            ->join('shipping', 'orders.ShippingID = shipping.id')
            ->where('shipping.user_id', $user_id)
            ->get();
        return $query->result();
    }




    public function selectOrderDetails($orderCode)
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

    public function printOrderDetails($orderCode)
    {
        $query = $this->db->select('orders.Order_Code, 
                                    orders.status as order_status, 
                                    order_detail.quantity as qty, 
                                    order_detail.Order_Code,
                                    order_detail.ProductID, product.*')
            ->from('order_detail')
            ->join('product', 'order_detail.ProductID= product.ProductID')
            ->join('orders', 'orders.Order_Code= order_detail.Order_Code')
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

    // public function deleteOrder($Order_Code)
    // {
    //     return $this->db->delete('orders', ['Order_Code' => $Order_Code]);
    // }

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

    public function insertRevenue($data)
    {
        $this->db->insert('revenue', $data);
    }
    public function insertWarehouse($data)
    {
        $this->db->insert('revenue', $data);
    }
}
