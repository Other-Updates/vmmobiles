<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stock extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'stock';
        $access_arr = array(
            'stock/index' => array('add', 'edit', 'delete', 'view'),
            'stock/ajaxList' => 'no_restriction',
            'stock/excel_report' => 'no_restriction',
            'stock/monthly_shrinkage' => 'no_restriction',
            'stock/stock_update' => 'no_restriction',
            'stock/ajaxList_report' => 'no_restriction',
            'stock/stock_based_report' => 'no_restriction',
            'stock/stock_report_search_result' => 'no_restriction',
            'stock/invoice_test' => 'no_restriction',
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            //redirect($this->config->item('base_url'));
        }
        $this->load->model('stock/stock_model');
        $this->load->model('purchase_order/purchase_order_model');
        $this->load->model('api/notification_model');
        $this->load->model('master_category/master_category_model');
        $this->load->model('product/product_model');
        if (isset($_GET['notification']))
            $this->notification_model->update_notification(array('status' => 1), $_GET['notification']);
    }

    public function index() {
        $data = array();
        //$datas["stock"] = $po = $this->stock_model->get_all_stock();
        

        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }

       $data['firm_details']= $this->stock_model->get_firm_name($frim_id);
//echo "<pre>";print_r($data);exit;
       $data['product'] = $this->product_model->get_product();
        $data['cat'] = $this->master_category_model->get_category_by_firm($frim_id);



        $this->template->write_view('content', 'stock/stock_list', $data);
        $this->template->render();
    }

    function ajaxList() {
        $search_data = $this->input->post();
        $search_arr = array();

        $search_arr['category'] = $search_data['category'];
        $search_arr['brand'] = $search_data['brand'];
        $search_arr['product'] = $search_data['product'];
        $search_arr['length'] = $search_data['length'];
        $search_arr['start'] = $search_data['start'];
        //$search_arr['category'] = $search_data['category'];
        if (empty($search_arr)) {
            $search_arr = array();
        }
        $list = $this->stock_model->get_datatables($search_arr);

       // echo "<pre>";print_r($list);exit;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ass) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ass->firm_name;
            $row[] = $ass->categoryName;
            $row[] = $ass->product_name;
            $row[] = $ass->brands;
            $row[] = $ass->quantity;
            $user_info = $this->user_auth->get_from_session('user_info');
            if ($user_info[0]['role'] == 1) {
               // $row[] = '<a href="javascript:void(0)" stock_id="' . $ass->id . '" data-toggle="tooltip" class="tooltips btn btn-default btn-xs edit" title="" data-original-title="Edit"><span class="fa fa-edit "></span></a>';
            } else {
               // $row[] = '<a href="javascript:void(0)" stock_id="' . $ass->id . '" data-toggle="tooltip" class="tooltips btn btn-default btn-xs edit" title="" data-original-title="Edit"><span class="fa fa-ban alerts"></span></a>';
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->stock_model->count_all(),
            "recordsFiltered" => $this->stock_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    public function excel_report() {
        if (isset($_GET) && $_GET['search'] != '') {
            $search = $_GET['search'];
        } else {
            $search = '';
        }
        $json = json_decode($search);

        //echo "<pre>";
       // print_r($json);
        //exit;


        if (isset($json[0]->report) && $json[0]->report == 1) {

            $po = $this->stock_model->get_all_stock_for_stockreport($search);
        } else {

            $po = $this->stock_model->get_all_stock_for_report($search);
        }

       // echo "<pre>";print_r($po);exit;
//	echo '<pre>';
        $this->export_csv($po);
//	$report = $this->load->view('stock_report.php', $data, TRUE);
//	echo $report;
//	exit;
    }

    function export_csv($query, $timezones = array()) {

        // output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=System Stock Report.csv');

        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        // output the column headings
        //Order has been changes
        fputcsv($output, array('S.No','Category', 'Product Name', 'Brand', 'Quantity'));

        // fetch the data
        //$rows = mysql_query($query);
        // loop over the rows, outputting them
        foreach ($query as $key=> $val) {
            $row = array($key + 1,$val['categoryName'], $val['product_name'], $val['brands'], $val['quantity']);
            fputcsv($output, $row);
        }
        exit;
    }

    public function stock_update() {
        $input = $this->input->post();
        $update = array('quantity' => $input['quantity']);
        $this->stock_model->update_stock($input['id'], $update);
        echo 'success';
        exit;
    }

    public function stock_search_result() {
        $search_data = $this->input->get();
        $data['search_data'] = $search_data;
        if (isset($search_data['inventory']) && !empty($search_data['inventory'])) {
            $data['stock'] = $this->stock_model->get_all_stock($search_data);
            $data['purchase_link'] = $this->purchase_order_model->get_purchase_link($search_data);
            $this->load->view('stock/search_inv_stock_list', $data);
        } else {
            $data['stock'] = $this->stock_model->get_all_stock($search_data);
            $this->load->view('report/search_stock_list', $data);
        }
    }

    public function stock_list_report() {

          $this->load->model('report/report_model');

        $data = array();
        //$datas["stock"] = $po = $this->stock_model->get_all_stock();
        $data['product'] = $this->product_model->get_product();
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }
        $data['cat'] = $this->master_category_model->get_category_by_firm($frim_id);

        $data['frim_list'] = $this->report_model->get_all_firms();

        $this->template->write_view('content', 'stock/stock_based_report', $data);
        $this->template->render();
    }

    public function ajaxList_report() {
        $search_data = $this->input->post();
        $search_arr = $custom_col = array();

        $search_arr['category'] = $search_data['category'];
        $search_arr['product'] = $search_data['product'];
        $search_arr['length'] = $search_data['length'];
        $search_arr['start'] = $search_data['start'];
        $custom_col = 'stock_report';
        //$search_arr['category'] = $search_data['category'];
        if (empty($search_arr)) {
            $search_arr = array();
        }
        $list = $this->stock_model->get_datatables($search_arr, $custom_col);
        // echo "<pre>";
        //print_r($list);
        //exit;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ass) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ass->firm_name;
            $row[] = $ass->categoryName;
            $row[] = $ass->brands;
            $row[] = $ass->product_name;
            $row[] = $ass->cost_price;
            $row[] = $ass->quantity;
            $row[] = $ass->quantity * $ass->cost_price;
            $row[] = round(($ass->quantity * $ass->cost_price * $ass->cgst) / 100, 2);
            $row[] = round(($ass->quantity * $ass->cost_price * $ass->sgst) / 100, 2);
            $net_total = ($ass->quantity * $ass->cost_price) + (($ass->quantity * $ass->cost_price * $ass->cgst) / 100) + (($ass->quantity * $ass->cost_price * $ass->sgst) / 100);
            $row[] = round($net_total, 2);
            $user_info = $this->user_auth->get_from_session('user_info');
            if ($user_info[0]['role'] == 1) {
                $row[] = '<a href="javascript:void(0)" stock_id="' . $ass->id . '" data-toggle="tooltip" class="tooltips btn btn-info btn-xs edit" title="" data-original-title="Edit"><span class="fa fa-edit "></span></a>';
            } else {
                $row[] = '<a href="javascript:void(0)" stock_id="' . $ass->id . '" data-toggle="tooltip" class="tooltips btn btn-info btn-xs edit" title="" data-original-title="Edit"><span class="fa fa-ban alerts"></span></a>';
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->stock_model->count_all(),
            "recordsFiltered" => $this->stock_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    public function stock_report_search_result() {
        $search_data = $this->input->get();
        $data['search_data'] = $search_data;
        $data['stock'] = $this->stock_model->get_all_stock($search_data);
        $this->load->view('stock/search_stock_report_list', $data);
    }

    public function excel_stock_based_report() {
        //echo "dsafsd";
        //exit;

        if (isset($_GET) && $_GET['search'] != '') {
            $search = $_GET['search'];
        } else {
            $search = '';
        }
        $json = json_decode($search);
        //echo "<pre>";
       // print_r($json);
      
        $custom_col = 'stock_report';
        if (isset($json[0]->report) && $json[0]->report == 1) {
            $po = $this->stock_model->get_all_stock_for_stockreport($search, $custom_col);
        } else {

            //echo "Comes here..";
            

            $po = $this->stock_model->get_all_stock_for_report($search, $custom_col);
        }

        $this->export_csv_stock_based_report($po);
//	$report = $this->load->view('stock_report.php', $data, TRUE);
//	echo $report;
//	exit;
    }

    function export_csv_stock_based_report($query, $timezones = array()) {

        // output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=System Stock Report.csv');

        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        // output the column headings
        //Order has been changes
        //fputcsv($output, array('Firm Name', 'Category', 'Product Name', 'Brand', 'System Quantity', 'Physical Quantity'));

        fputcsv($output, array('Sno', 'Firm Name', 'Category', 'Brand', 'Product Name', 'Quantity',
            'Cost Price', 'Total Price(Without GST)', 'CGST Amount', 'SGST Amount',
            'Total Price(With GST)'
        ));

        // fetch the data
        //$rows = mysql_query($query);
        // loop over the rows, outputting them

        $no = 1;

        foreach ($query as $val) {
            $firm_name = $val['firm_name'];
            $category_name = $val['categoryName'];
            $brand_name = $val['brands'];
            $product_name = $val['product_name'];
            $quantity = $val['quantity'];
            $cost_price = $val['cost_price'];
            $total_price_without_gst = round(($val['quantity'] * $val['cost_price']), 2);
            $cgst_amount = round(($val['quantity'] * $val['cost_price'] * $val['cgst']) / 100, 2);
            $sgst_amount = round(($val['quantity'] * $val['cost_price'] * $val['sgst']) / 100, 2);
            $net_total = $total_price_without_gst + $cgst_amount + $sgst_amount;
            $net_total = round($net_total, 2);

            $row = array($no, $firm_name, $category_name, $brand_name, $product_name, $quantity, $cost_price,
                $total_price_without_gst, $cgst_amount, $sgst_amount, $net_total);
            fputcsv($output, $row);
            $no++;
        }
        exit;
    }

    public function invoice_test() {
        $data = array();
        //$datas["stock"] = $po = $this->stock_model->get_all_stock();

        $this->template->write_view('content', 'stock/invoice_test', $data);
        $this->template->render();
        //$this->load->view('stock/invoice_test', $data);
    }

    public function ajaxtestList() {
        $search_data = $this->input->post();
        $search_arr = array();
        $search_arr['category'] = $search_data['category'];
        //$search_arr['brand'] = $search_data['brand'];
        $search_arr['product'] = $search_data['product'];
        //$search_arr['category'] = $search_data['category'];
        if (empty($search_arr)) {
            $search_arr = array();
        }
        $list = $this->stock_model->get_datatables($search_arr);
        //echo "<pre>";
        //print_r($list);
        //exit;


        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ass) {

            $no++;
            $row = array();
            $row[] = $no;
            //$row[] = $ass->firm_name;
            $row[] = $ass->q_id;
            $row[] = $ass->customer;
            $row[] = $ass->sales_man;
            $row[] = $ass->total_qty;
            $row[] = $ass->subtotal_qty;

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->stock_model->count_all(),
            "recordsFiltered" => $this->stock_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

}
