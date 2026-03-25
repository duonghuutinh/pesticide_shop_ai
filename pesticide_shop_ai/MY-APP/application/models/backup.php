
<?php

class revenueModel extends CI_Model
{
    public function getRevenueThisMonth()
    {
        $this->db->select('SUM(TotalAmount) as TotalRevenue');
        $this->db->from('orders');
        $this->db->where('MONTH(Payment_date_successful)', date('m'));
        $this->db->where('YEAR(Payment_date_successful)', date('Y'));
        $this->db->where('Payment_Status', 1);
        return $this->db->get()->row();
    }

    public function getRevenueThisYear()
    {
        $this->db->select('SUM(TotalAmount) as TotalRevenue');
        $this->db->from('orders');
        $this->db->where('YEAR(Payment_date_successful)', date('Y'));
        $this->db->where('Payment_Status', 1);
        return $this->db->get()->row();
    }

    public function getRevenueByDate($date)
    {
        $this->db->select('SUM(TotalAmount) as TotalRevenue');
        $this->db->from('orders');
        $this->db->where('DATE(Payment_date_successful)', $date);
        $this->db->where('Payment_Status', 1);
        return $this->db->get()->row();
    }

    public function getRevenueByDateRange($startDate, $endDate)
    {
        // Thêm thời gian vào ngày bắt đầu và ngày kết thúc
        $startDate = $startDate . ' 00:00:00';
        $endDate = $endDate . ' 23:59:59';

        $this->db->select('DATE(Payment_date_successful) as Date, SUM(TotalAmount) as TotalRevenue');
        $this->db->from('orders');
        $this->db->where('Payment_date_successful >=', $startDate);
        $this->db->where('Payment_date_successful <=', $endDate);
        $this->db->where('Payment_Status', 1);
        $this->db->group_by('DATE(Payment_date_successful)');
        $this->db->order_by('DATE(Payment_date_successful)', 'ASC');

        // Lấy kết quả
        $results = $this->db->get()->result();

        // Xử lý để trả về 0 nếu không có dữ liệu cho ngày nào đó
        $dateRange = $this->generateDateRange($startDate, $endDate);
        $finalResults = [];
        foreach ($dateRange as $date) {
            $found = false;
            foreach ($results as $row) {
                if ($row->Date === $date) {
                    $finalResults[] = $row;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $finalResults[] = (object)[
                    'Date' => $date,
                    'TotalRevenue' => 0
                ];
            }
        }

        return $finalResults;
    }

    // Hàm tạo danh sách các ngày trong khoảng thời gian
    private function generateDateRange($startDate, $endDate)
    {
        $start = new DateTime(substr($startDate, 0, 10));
        $end = new DateTime(substr($endDate, 0, 10));
        $end->modify('+1 day');

        $interval = new DateInterval('P1D');
        $dateRange = new DatePeriod($start, $interval, $end);

        $dates = [];
        foreach ($dateRange as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        return $dates;
    }








    // public function getRevenueByMonthRange($startMonth, $endMonth)
    // {
    //     // Chuẩn hóa ngày bắt đầu và ngày kết thúc
    //     $startDate = $startMonth . '-01 00:00:00'; // Ngày đầu tiên của tháng bắt đầu
    //     $endDate = (new DateTime($endMonth . '-01'))->modify('last day of this month')->format('Y-m-d 23:59:59'); // Ngày cuối cùng của tháng kết thúc

    //     // Truy vấn dữ liệu từ cơ sở dữ liệu
    //     $this->db->select('YEAR(Payment_date_successful) as Year, MONTH(Payment_date_successful) as Month, SUM(TotalAmount) as TotalRevenue');
    //     $this->db->from('orders');
    //     $this->db->where('Payment_date_successful >=', $startDate);
    //     $this->db->where('Payment_date_successful <=', $endDate);
    //     $this->db->where('Payment_Status', 1);
    //     $this->db->group_by(['YEAR(Payment_date_successful)', 'MONTH(Payment_date_successful)']);
    //     $this->db->order_by('Year, Month', 'ASC');
    //     $results = $this->db->get()->result();

    //     // Tạo danh sách các tháng trong khoảng thời gian
    //     $dateRange = $this->generateMonthRange($startMonth, $endMonth);
    //     $finalResults = [];

    //     // Ghép dữ liệu từ cơ sở dữ liệu với danh sách các tháng
    //     foreach ($dateRange as $date) {
    //         $found = false;
    //         foreach ($results as $row) {
    //             if ($row->Year == $date['Year'] && $row->Month == $date['Month']) {
    //                 $finalResults[] = $row; // Thêm dữ liệu từ cơ sở dữ liệu
    //                 $found = true;
    //                 break;
    //             }
    //         }
    //         if (!$found) {
    //             // Nếu không tìm thấy dữ liệu cho tháng này, thêm dữ liệu mặc định
    //             $finalResults[] = (object)[
    //                 'Year' => $date['Year'],
    //                 'Month' => $date['Month'],
    //                 'TotalRevenue' => 0
    //             ];
    //         }
    //     }

    //     return $finalResults;
    // }


    public function getRevenueByMonthRange($startMonth, $endMonth)
    {
        $startDate = $startMonth . '-01 00:00:00';
        $endDate = (new DateTime($endMonth . '-01'))->modify('last day of this month')->format('Y-m-d 23:59:59');

        $this->db->select('YEAR(Payment_date_successful) AS Year, MONTH(Payment_date_successful) AS Month, SUM(TotalAmount) AS TotalRevenue');
        $this->db->from('orders');
        $this->db->where('Payment_Status', 1);
        $this->db->where('Payment_date_successful >=', $startDate);
        $this->db->where('Payment_date_successful <=', $endDate);
        $this->db->group_by(['YEAR(Payment_date_successful)', 'MONTH(Payment_date_successful)']);
        $this->db->order_by('Year ASC, Month ASC');

        // Debug truy vấn SQL
        $query = $this->db->get_compiled_select();
        echo $query; // In ra câu lệnh SQL
        die();

        $results = $this->db->get()->result();

        return $results;
    }
    // Hàm tạo danh sách các tháng trong khoảng thời gian
    private function generateMonthRange($startMonth, $endMonth)
    {

        $start = new DateTime($startMonth . '-01');
        $end = new DateTime($endMonth . '-01');
        $end->modify('+1 month');


        $interval = new DateInterval('P1M');
        $dateRange = new DatePeriod($start, $interval, $end);

        $months = [];
        foreach ($dateRange as $date) {
            $months[] = [
                'Year' => $date->format('Y'),
                'Month' => $date->format('n')
            ];
        }

        return $months;
    }

    public function getRevenueByYearRange($startYear, $endYear)
    {
        $this->db->select('YEAR(Payment_date_successful) as Year, SUM(TotalAmount) as TotalRevenue');
        $this->db->from('orders');
        $this->db->where('YEAR(Payment_date_successful) >=', $startYear);
        $this->db->where('YEAR(Payment_date_successful) <=', $endYear);
        $this->db->where('Payment_Status', 1);
        $this->db->group_by('YEAR(Payment_date_successful)');
        $this->db->order_by('Year', 'ASC');
        $results = $this->db->get()->result();

        // Tạo danh sách các năm trong khoảng thời gian
        $years = range($startYear, $endYear);
        $finalResults = [];
        foreach ($years as $year) {
            $found = false;
            foreach ($results as $row) {
                if ($row->Year == $year) {
                    $finalResults[] = $row;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $finalResults[] = (object)[
                    'Year' => $year,
                    'TotalRevenue' => 0
                ];
            }
        }

        return $finalResults;
    }






    // Tính tổng doanh thu
    private function getTotalRevenue($startDate = null, $endDate = null)
    {
        $this->db->select('SUM(od.Quantity * p.Selling_price) AS Total_Revenue');
        $this->db->from('order_detail od');
        $this->db->join('product p', 'od.ProductID = p.ProductID');

        if ($startDate && $endDate) {
            $this->db->where('od.Order_Code IN (
                SELECT Order_Code 
                FROM orders 
                WHERE Payment_date_successful BETWEEN "' . $startDate . '" AND "' . $endDate . '"
                AND Payment_Status = 1
            )');
        }

        $query = $this->db->get();
        return $query->row()->Total_Revenue ?? 0;
    }

    // Tính lợi nhuận
    public function getProfit($startDate = null, $endDate = null)
    {
        $totalRevenue = $this->getTotalRevenue($startDate, $endDate);
        $totalCost = $this->getTotalCost($startDate, $endDate);
        return $totalRevenue - $totalCost;
    }




    // Tính tổng chi phí nhập kho
    private function getTotalCost($startDate = null, $endDate = null)
    {
        $this->db->select('SUM(wri.Quantity_actual * wri.Import_price) AS Total_Cost');
        $this->db->from('warehouse_receipt_items wri');

        if ($startDate && $endDate) {
            $this->db->where('wri.Receipt_id IN (
                SELECT id 
                FROM warehouse_receipt 
                WHERE created_at BETWEEN "' . $startDate . '" AND "' . $endDate . '"
            )');
        }

        $query = $this->db->get();
        return $query->row()->Total_Cost ?? 0; // Trả về 0 nếu không có dữ liệu
    }




    public function getOrderProfit()
    {
        // Truy vấn chi tiết lợi nhuận từng đơn hàng
        $sql = "
            SELECT 
                od.Order_Code,
                SUM(od.Quantity * od.Selling_price) AS Total_Revenue,
                SUM(ob.quantity * b.Import_price) AS Total_Cost,
                SUM(od.Quantity * od.Selling_price) - SUM(ob.quantity * b.Import_price) AS Total_Profit
            FROM order_detail od
            JOIN order_batches ob ON od.id = ob.order_detail_id
            JOIN batches b ON ob.batch_id = b.Batch_ID
            GROUP BY od.Order_Code;
        ";
        $query = $this->db->query($sql);
        $orderProfits = $query->result();

        // Tính tổng lợi nhuận của tất cả các đơn hàng
        $totalProfitAll = 0;
        foreach ($orderProfits as $order) {
            $totalProfitAll += $order->Total_Profit;
        }

        // Trả về kết quả bao gồm danh sách đơn hàng và tổng lợi nhuận
        return [
            'orderProfits' => $orderProfits,
            'totalProfitAll' => $totalProfitAll
        ];
    }


    // public function getProfitByDateRange($startDate, $endDate)
    // {

    //     if (strlen($startDate) === 10) {
    //         $startDate .= ' 00:00:00';
    //     }
    //     if (strlen($endDate) === 10) { 
    //         $endDate .= ' 23:59:59';
    //     }

    //     $sql = "
    //     SELECT 
    //         od.Order_Code,
    //         o.Payment_date_successful,
    //         SUM(od.Quantity * od.Selling_price) AS Total_Revenue,
    //         SUM(ob.quantity * b.Import_price) AS Total_Cost,
    //         SUM(od.Quantity * od.Selling_price) - SUM(ob.quantity * b.Import_price) AS Total_Profit
    //     FROM orders o
    //     JOIN order_detail od ON o.Order_Code = od.Order_Code
    //     JOIN order_batches ob ON od.id = ob.order_detail_id
    //     JOIN batches b ON ob.batch_id = b.Batch_ID
    //     WHERE o.Payment_Status = 1
    //     AND o.Payment_date_successful BETWEEN ? AND ?
    //     GROUP BY od.Order_Code
    //     ORDER BY od.Order_Code ASC;
    // ";
    //     $query = $this->db->query($sql, [$startDate, $endDate]);
    //     $orderProfits = $query->result();

    //     $totalProfitAll = 0;
    //     $totalRevenueAll = 0;
    //     $totalCostAll = 0;

    //     foreach ($orderProfits as $order) {
    //         $totalProfitAll += $order->Total_Profit;
    //         $totalRevenueAll += $order->Total_Revenue;
    //         $totalCostAll += $order->Total_Cost;
    //     }
    //     return [
    //         'orderProfits' => $orderProfits,
    //         'totalProfitAll' => $totalProfitAll,
    //         'totalRevenueAll' => $totalRevenueAll,
    //         'totalCostAll' => $totalCostAll
    //     ];
    // }



    public function getProfitByDateRange($startDate, $endDate)
    {

        if (strlen($startDate) === 10) {
            $startDate .= ' 00:00:00';
        }
        if (strlen($endDate) === 10) {
            $endDate .= ' 23:59:59';
        }

        // Truy vấn SQL
        $sql = "
        SELECT 
            DATE(o.Payment_date_successful) AS Payment_Date,
            od.Order_Code,
            SUM(od.Quantity * od.Selling_price) AS Total_Revenue,
            SUM(ob.quantity * b.Import_price) AS Total_Cost,
            SUM(od.Quantity * od.Selling_price) - SUM(ob.quantity * b.Import_price) AS Total_Profit
        FROM orders o
        JOIN order_detail od ON o.Order_Code = od.Order_Code
        JOIN order_batches ob ON od.id = ob.order_detail_id
        JOIN batches b ON ob.batch_id = b.Batch_ID
        WHERE o.Payment_Status = 1
        AND o.Payment_date_successful BETWEEN ? AND ?
        GROUP BY DATE(o.Payment_date_successful), od.Order_Code
        ORDER BY Payment_Date ASC, od.Order_Code ASC;
    ";

        // Thực thi truy vấn
        $query = $this->db->query($sql, [$startDate, $endDate]);
        if (!$query) {
            // Xử lý lỗi nếu truy vấn thất bại
            return [
                'error' => 'Database query failed',
                'orderProfits' => [],
                'dailyTotals' => [],
                'totalProfitAll' => 0,
                'totalRevenueAll' => 0,
                'totalCostAll' => 0
            ];
        }

        $orderProfits = $query->result();

        // Tính toán tổng hợp
        $totalProfitAll = 0;
        $totalRevenueAll = 0;
        $totalCostAll = 0;
        $dailyTotals = [];

        foreach ($orderProfits as $order) {
            $totalProfitAll += $order->Total_Profit;
            $totalRevenueAll += $order->Total_Revenue;
            $totalCostAll += $order->Total_Cost;

            // Tổng hợp theo ngày
            $paymentDate = $order->Payment_Date;
            if (!isset($dailyTotals[$paymentDate])) {
                $dailyTotals[$paymentDate] = [
                    'Total_Revenue' => 0,
                    'Total_Cost' => 0,
                    'Total_Profit' => 0
                ];
            }
            $dailyTotals[$paymentDate]['Total_Revenue'] += $order->Total_Revenue;
            $dailyTotals[$paymentDate]['Total_Cost'] += $order->Total_Cost;
            $dailyTotals[$paymentDate]['Total_Profit'] += $order->Total_Profit;
        }

        // Trả về kết quả
        return [
            'orderProfits' => $orderProfits,
            'dailyTotals' => $dailyTotals,
            'totalProfitAll' => $totalProfitAll,
            'totalRevenueAll' => $totalRevenueAll,
            'totalCostAll' => $totalCostAll
        ];
    }



    public function getProfitByMonthRange($startMonth, $endMonth)
    {
        // Thêm ngày đầu tiên và ngày cuối cùng của tháng
        $startDate = $startMonth . '-01 00:00:00'; // Ngày đầu tiên của tháng bắt đầu
        $endDate = date("Y-m-t 23:59:59", strtotime($endMonth . '-01')); // Ngày cuối cùng của tháng kết thúc

        // Truy vấn SQL chi tiết từng đơn hàng
        $sql = "
                SELECT 
                    DATE(o.Payment_date_successful) AS Payment_Date,
                    od.Order_Code,
                    SUM(od.Quantity * od.Selling_price) AS Total_Revenue,
                    SUM(ob.quantity * b.Import_price) AS Total_Cost,
                    SUM(od.Quantity * od.Selling_price) - SUM(ob.quantity * b.Import_price) AS Total_Profit
                FROM orders o
                JOIN order_detail od ON o.Order_Code = od.Order_Code
                JOIN order_batches ob ON od.id = ob.order_detail_id
                JOIN batches b ON ob.batch_id = b.Batch_ID
                WHERE o.Payment_Status = 1
                AND o.Payment_date_successful BETWEEN ? AND ?
                GROUP BY DATE(o.Payment_date_successful), od.Order_Code
                ORDER BY Payment_Date ASC, od.Order_Code ASC;
                ";

        // Thực thi truy vấn
        $query = $this->db->query($sql, [$startDate, $endDate]);
        if (!$query) {
            // Xử lý lỗi nếu truy vấn thất bại
            return [
                'error' => 'Database query failed',
                'orderProfits' => [],
                'monthlyTotals' => [],
                'totalProfitAll' => 0,
                'totalRevenueAll' => 0,
                'totalCostAll' => 0
            ];
        }

        $orderProfits = $query->result();

        // Tạo danh sách tất cả các tháng trong khoảng thời gian
        $allMonths = [];
        $currentMonth = strtotime($startMonth . '-01');
        $endMonthTimestamp = strtotime($endMonth . '-01');

        while ($currentMonth <= $endMonthTimestamp) {
            $allMonths[] = date('Y-m', $currentMonth);
            $currentMonth = strtotime('+1 month', $currentMonth);
        }

        // Tính toán tổng hợp
        $totalProfitAll = 0;
        $totalRevenueAll = 0;
        $totalCostAll = 0;
        $monthlyTotals = [];

        // Khởi tạo giá trị mặc định cho từng tháng
        foreach ($allMonths as $month) {
            $monthlyTotals[$month] = [
                'Total_Revenue' => 0,
                'Total_Cost' => 0,
                'Total_Profit' => 0
            ];
        }

        // Tổng hợp dữ liệu từ các đơn hàng
        foreach ($orderProfits as $order) {
            $paymentMonth = date('Y-m', strtotime($order->Payment_Date)); // Lấy tháng từ ngày thanh toán
            $totalProfitAll += $order->Total_Profit;
            $totalRevenueAll += $order->Total_Revenue;
            $totalCostAll += $order->Total_Cost;

            // Cộng dồn vào tháng tương ứng
            if (!isset($monthlyTotals[$paymentMonth])) {
                $monthlyTotals[$paymentMonth] = [
                    'Total_Revenue' => 0,
                    'Total_Cost' => 0,
                    'Total_Profit' => 0
                ];
            }
            $monthlyTotals[$paymentMonth]['Total_Revenue'] += $order->Total_Revenue;
            $monthlyTotals[$paymentMonth]['Total_Cost'] += $order->Total_Cost;
            $monthlyTotals[$paymentMonth]['Total_Profit'] += $order->Total_Profit;
        }

        // Trả về kết quả
        return [
            'orderProfits' => $orderProfits, // Danh sách chi tiết từng đơn hàng
            'monthlyTotals' => $monthlyTotals, // Tổng hợp theo tháng
            'totalProfitAll' => $totalProfitAll, // Tổng lợi nhuận
            'totalRevenueAll' => $totalRevenueAll, // Tổng doanh thu
            'totalCostAll' => $totalCostAll // Tổng chi phí
        ];
    }


    public function getProfitByYearRange($startYear, $endYear)
    {
        // Thêm ngày đầu tiên và ngày cuối cùng của năm
        $startDate = $startYear . '-01-01 00:00:00'; // Ngày đầu tiên của năm bắt đầu
        $endDate = $endYear . '-12-31 23:59:59'; // Ngày cuối cùng của năm kết thúc

        // Truy vấn SQL chi tiết từng đơn hàng
        $sql = "
                SELECT 
                    DATE(o.Payment_date_successful) AS Payment_Date,
                    od.Order_Code,
                    SUM(od.Quantity * od.Selling_price) AS Total_Revenue,
                    SUM(ob.quantity * b.Import_price) AS Total_Cost,
                    SUM(od.Quantity * od.Selling_price) - SUM(ob.quantity * b.Import_price) AS Total_Profit
                FROM orders o
                JOIN order_detail od ON o.Order_Code = od.Order_Code
                JOIN order_batches ob ON od.id = ob.order_detail_id
                JOIN batches b ON ob.batch_id = b.Batch_ID
                WHERE o.Payment_Status = 1
                AND o.Payment_date_successful BETWEEN ? AND ?
                GROUP BY DATE(o.Payment_date_successful), od.Order_Code
                ORDER BY Payment_Date ASC, od.Order_Code ASC;
                ";

        // Thực thi truy vấn
        $query = $this->db->query($sql, [$startDate, $endDate]);
        if (!$query) {
            // Xử lý lỗi nếu truy vấn thất bại
            return [
                'error' => 'Database query failed',
                'orderProfits' => [],
                'yearlyTotals' => [],
                'totalProfitAll' => 0,
                'totalRevenueAll' => 0,
                'totalCostAll' => 0
            ];
        }

        $orderProfits = $query->result();

        // Tạo danh sách tất cả các năm trong khoảng thời gian
        $allYears = range($startYear, $endYear);

        // Tính toán tổng hợp
        $totalProfitAll = 0;
        $totalRevenueAll = 0;
        $totalCostAll = 0;
        $yearlyTotals = [];

        // Khởi tạo giá trị mặc định cho từng năm
        foreach ($allYears as $year) {
            $yearlyTotals[$year] = [
                'Total_Revenue' => 0,
                'Total_Cost' => 0,
                'Total_Profit' => 0
            ];
        }

        // Tổng hợp dữ liệu từ các đơn hàng
        foreach ($orderProfits as $order) {
            $paymentYear = date('Y', strtotime($order->Payment_Date)); // Lấy năm từ ngày thanh toán
            $totalProfitAll += $order->Total_Profit;
            $totalRevenueAll += $order->Total_Revenue;
            $totalCostAll += $order->Total_Cost;

            // Cộng dồn vào năm tương ứng
            if (!isset($yearlyTotals[$paymentYear])) {
                $yearlyTotals[$paymentYear] = [
                    'Total_Revenue' => 0,
                    'Total_Cost' => 0,
                    'Total_Profit' => 0
                ];
            }
            $yearlyTotals[$paymentYear]['Total_Revenue'] += $order->Total_Revenue;
            $yearlyTotals[$paymentYear]['Total_Cost'] += $order->Total_Cost;
            $yearlyTotals[$paymentYear]['Total_Profit'] += $order->Total_Profit;
        }

        // Trả về kết quả
        return [
            'orderProfits' => $orderProfits, // Danh sách chi tiết từng đơn hàng
            'yearlyTotals' => $yearlyTotals, // Tổng hợp theo năm
            'totalProfitAll' => $totalProfitAll, // Tổng lợi nhuận
            'totalRevenueAll' => $totalRevenueAll, // Tổng doanh thu
            'totalCostAll' => $totalCostAll // Tổng chi phí
        ];
    }






    public function getBatchProfitStatus()
    {
        $sql = "
            SELECT 
                b.Batch_ID,
                b.ProductID,
                p.Name AS Product_Name,
                p.Product_Code AS Product_Code, -- Thêm Product_Code
                b.Import_date,
                b.Import_price,
                b.Quantity AS Total_Quantity,
                (b.Quantity * b.Import_price) AS Total_Cost,
                IFNULL(SUM(ob.quantity), 0) AS Total_Sold,
                IFNULL(SUM(ob.quantity * od.Selling_price), 0) AS Total_Revenue,
                (b.Quantity * b.Import_price) - IFNULL(SUM(ob.quantity * od.Selling_price), 0) AS Remaining_Amount
            FROM batches b
            LEFT JOIN product p ON b.ProductID = p.ProductID
            LEFT JOIN order_batches ob ON b.Batch_ID = ob.batch_id
            LEFT JOIN order_detail od ON ob.order_detail_id = od.id
            GROUP BY b.Batch_ID, b.ProductID, p.Name, p.Product_Code, b.Import_date, b.Import_price, b.Quantity
        ";
        $query = $this->db->query($sql);
        $result = $query->result();

        // Xử lý dữ liệu để nhóm theo sản phẩm
        $groupedData = [];
        foreach ($result as $row) {
            $productID = $row->ProductID;

            // Nếu sản phẩm chưa tồn tại trong mảng, khởi tạo
            if (!isset($groupedData[$productID])) {
                $groupedData[$productID] = [
                    'ProductID' => $row->ProductID,
                    'Product_Name' => $row->Product_Name,
                    'Product_Code' => $row->Product_Code, // Thêm Product_Code vào đây
                    'Batches' => [] // Danh sách các lô hàng
                ];
            }

            // Thêm thông tin lô hàng vào danh sách Batches
            $groupedData[$productID]['Batches'][] = [
                'Batch_ID' => $row->Batch_ID,
                'Import_date' => $row->Import_date,
                'Import_price' => $row->Import_price,
                'Total_Quantity' => $row->Total_Quantity,
                'Total_Cost' => $row->Total_Cost,
                'Total_Sold' => $row->Total_Sold,
                'Total_Revenue' => $row->Total_Revenue,
                'Remaining_Amount' => $row->Remaining_Amount
            ];
        }

        // Trả về dữ liệu đã được nhóm
        return array_values($groupedData); // Chuyển mảng thành danh sách chỉ số
    }
}
