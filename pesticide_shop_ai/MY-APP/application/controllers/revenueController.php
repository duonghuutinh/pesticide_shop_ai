 <?php
    defined('BASEPATH') or exit('No direct script access allowed');

    /**
     * @property session $session
     * @property config $config
     * @property form_validation $form_validation
     * @property input $input
     * @property load $load
     * @property data $data
     * @property indexModel $indexModel
     * @property pagination $pagination
     * @property uri $uri
     * @property sliderModel $sliderModel
     * @property email $email
     * @property cart $cart
     * @property orderModel $orderModel
     * @property productModel $productModel
     * @property page $page
     * @property customerModel $customerModel
     * @property loginModel $loginModel
     * @property upload $upload
     * @property revenueModel $revenueModel
     * @property getRevenueToday $getRevenueToday
     * @property getRevenueThisMonth $getRevenueThisMonth
     * @property getRevenueThisYear $getRevenueThisYear
     */


    class revenueController extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('revenueModel');
            $this->load->library('session');
        }

        private function _isValidDate($date)
        {
            $format = 'Y-m-d';
            $d = DateTime::createFromFormat($format, $date);
            return $d && $d->format($format) === $date;
        }
        private function _isValidMonth($month)
        {
            return preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $month);
        }

        private function _isValidYear($year)
        {
            return preg_match('/^\d{4}$/', $year);
        }

        public function checkLogin()
        {
            if (!$this->session->userdata('logged_in_admin')) {
                redirect(base_url('login'));
            }
        }

        private function _loadRevenueReportPage($extraData = [])
        {
            $data = [
                "template" => "revenue/revenueReport",
                "title" => "Thống kê doanh thu"
            ];
            $data['breadcrumb'] = [
                ['label' => 'Dashboard', 'url' => 'dashboard'],
                ['label' => 'Báo cáo doanh thu']
            ];
            $data = array_merge($data, $extraData);

            $this->load->view("admin-layout/admin-layout", $data);
        }

        public function revenueReportPage()
        {
            $this->config->config['pageTitle'] = 'Revenue';
            $data = [];


            $timeType = $this->input->get('time_type');
            $data['timeType'] = $timeType;

            if ($timeType === 'day') {
                $startDate = htmlspecialchars($this->input->get('start_date', true));
                $endDate = htmlspecialchars($this->input->get('end_date', true));
                if ($startDate && $endDate) {
                    if ($this->_isValidDate($startDate) && $this->_isValidDate($endDate)) {
                        $data['profits'] = $this->revenueModel->getProfitByDateRange($startDate, $endDate);
                        $data['timeType'] = 'day';
                    } else {
                        $data['profits'] = ['error' => 'Invalid date format. Please use YYYY-MM-DD.'];
                    }
                }
            } elseif ($timeType === 'month') {
                $startMonth = htmlspecialchars($this->input->get('start_month', true));
                $endMonth = htmlspecialchars($this->input->get('end_month', true));
                if ($startMonth && $endMonth) {
                    if ($this->_isValidMonth($startMonth) && $this->_isValidMonth($endMonth)) {
                        $data['profits'] = $this->revenueModel->getProfitByMonthRange($startMonth, $endMonth);
                        $data['timeType'] = 'month';
                    } else {
                        $data['profits'] = ['error' => 'Invalid month format. Please use YYYY-MM.'];
                    }
                }
            } elseif ($timeType === 'year') {
                $startYear = htmlspecialchars($this->input->get('start_year', true));
                $endYear = htmlspecialchars($this->input->get('end_year', true));

                if ($startYear && $endYear) {
                    if ($this->_isValidYear($startYear) && $this->_isValidYear($endYear)) {
                        $data['profits'] = $this->revenueModel->getProfitByYearRange($startYear, $endYear);
                        $data['timeType'] = 'year'; // Gửi loại thời gian sang view
                    } else {
                        $data['profits'] = ['error' => 'Invalid year format. Please use YYYY.'];
                    }
                }
            }

            $this->_loadRevenueReportPage($data);
        }





        public function revenueBatchesPage()
        {
            $this->config->config['pageTitle'] = 'Thống kê lô hàng';
            $data = [];
            $data['batches'] = $this->revenueModel->getBatchProfitStatus();

            // echo '<pre>';
            // print_r($data['batches']);
            // echo '</pre>';


            $data['title'] = "Thống kê lô hàng";
            $data['breadcrumb'] = [
                ['label' => 'Dashboard', 'url' => 'dashboard'],
                ['label' => 'Báo cáo trạng thái lô hàng']
            ];
            $data['template'] = "revenue/batchesReport";
            $this->load->view("admin-layout/admin-layout", $data);
        }
    }


    ?>