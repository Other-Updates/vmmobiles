<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Physical_report extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'stock';
        $access_arr = array(
            'stock/index' => array('add', 'edit', 'delete', 'view'),
            'stock/ajaxList' => 'no_restriction',
            'stock/excel_report' => 'no_restriction'
        );

//	if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
//	    redirect($this->config->item('base_url'));
//	}
        $this->load->model('stock/physical_report_model');
        $this->load->model('api/notification_model');
        if (isset($_GET['notification']))
            $this->notification_model->update_notification(array('status' => 1), $_GET['notification']);
    }

    public function index() {
        //$from_date = date('Y-m-01');
        //$to_date = date('Y-m-t');
        $data["shrinkage"] = $this->physical_report_model->get_all_shrinkage();

        //echo '<pre>';
        // print_r($data);
        // exit;
        $this->template->write_view('content', 'stock/physical_stock_list', $data);
        $this->template->render();
    }

    function ajaxList() {
        $list = $this->stock_model->get_datatables();

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

    function import_physical_stock() {
        if ($this->input->post()) {
            $skip_rows = 1;
            $is_success = 0;
            if (!empty($_FILES['product_data'])) {
                $config['upload_path'] = './attachement/physical_stock/';
                $config['allowed_types'] = '*';
                $config['max_size'] = '10000';
                $this->load->library('upload', $config);
                $random_hash = date('Y-m-d', strtotime($this->input->post('entry_date')));
                $extension = pathinfo($_FILES['product_data']['name'], PATHINFO_EXTENSION);
                $new_file_name = 'Physical Stock list_' . $random_hash . '.' . $extension;
                $_FILES['product_data'] = array(
                    'name' => $new_file_name,
                    'type' => $_FILES['product_data']['type'],
                    'tmp_name' => $_FILES['product_data']['tmp_name'],
                    'error' => $_FILES['product_data']['error'],
                    'size' => $_FILES['product_data']['size']
                );
                $config['file_name'] = $new_file_name;
                $this->upload->initialize($config);
                $this->upload->do_upload('product_data');
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
                $input = array();
                $input['document_name'] = $file_name;
                $input['entry_date'] = date('Y-m-d', strtotime($this->input->post('entry_date')));
                $insert_id = $this->physical_report_model->insert_shrinkage($input);

                $file = base_url() . 'attachement/physical_stock/' . $file_name;
                $handle = fopen($file, 'r');
                if ($file != NULL && $skip_rows > 0) {
                    $skipLines = $skip_rows;
                    $lineNum = 1;
                    if ($skipLines > 0) {
                        while (fgetcsv($handle)) {
                            if ($lineNum == $skipLines) {
                                break;
                            }
                            $lineNum++;
                        }
                    }
                }
                $count = 0;
                $row = 1;
                while ($row_data = fgetcsv($handle)) {
                    $firm_name = $row_data[0];
                    $category = $row_data[1];
                    $product_name = $row_data[2];
                    $brand = $row_data[3];
                    $sys_qty = $row_data[4];
                    $physical_qty = $row_data[5];
                    $firm_id = $this->physical_report_model->is_firm_name_exist($firm_name);
                    $cat_id = $this->physical_report_model->is_category_name_exist($category);
                    $product_id = $this->physical_report_model->is_product_name_exist($product_name);
                    $brand_id = $this->physical_report_model->is_brand_name_exist($brand);
                    $physical_stock = array();
                    $physical_stock['shrinkage_id'] = $insert_id;
                    $physical_stock['firm_id'] = $firm_id;
                    $physical_stock['category'] = $cat_id;
                    $physical_stock['brand'] = $brand_id;
                    $physical_stock['product_id'] = $product_id;
                    $physical_stock['system_quantity'] = $sys_qty;
                    $physical_stock['physical_quantity'] = $physical_qty;
                    $physical_stock['entry_date'] = date('Y-m-d', strtotime($this->input->post('entry_date')));
                    $this->physical_report_model->insert_physical_stock($physical_stock);

                    $is_success = 1;
                    if ($count == 1000) {
                        break;
                    }
                    $count++;
                }
            }
            if ($is_success) {
                redirect($this->config->item('base_url') . 'stock/physical_report');
            }
        }
    }

    public function view($id) {

        $data["stock"] = $this->physical_report_model->get_all_stock_for_report_by_id($id);
//        echo '<pre>';
//        print_r($data);
//        exit;
        $this->template->write_view('content', 'stock/physical_stock_view', $data);
        $this->template->render();
        //$this->load->view('stock/physical_stock_view', $data);
    }

    public function search_result() {
        if ($this->input->post()) {
            $from_date = date('Y-m-d', strtotime($this->input->post('from_date')));
            $to_date = date('Y-m-d', strtotime($this->input->post('to_date')));
            $data["shrinkage"] = $this->physical_report_model->get_all_shrinkage($from_date, $to_date);
            $i = 0;
            foreach ($data["shrinkage"] as $val) {

                $data["shrinkage"][$i]["stock"] = $this->physical_report_model->get_all_stock_for_report($val['entry_date']);
                $i++;
            }
//	echo '<pre>';
//	print_r($data);
//	exit;
            $this->load->view('stock/physical_stock_table', $data);
        }
    }

    public function edit_physical_quantity($id) {
        $input = $this->input->post();
        $data = $this->physical_report_model->update_physical_quantity($input, $id);
        echo 'edit';
        //echo '<pre>';
        //print_r($input);
        //exit;
    }

    public function cleart_quantity($id) {
        $stock = $this->physical_report_model->get_all_stock_srinkage_id($id);
        // echo '<pre>';
        // print_r($stock);
        // exit;
        $update = array();
        if (!empty($stock)) {
            foreach ($stock as $val) {
                $update['system_quantity'] = $val['physical_quantity'];
                $update['shrinkage_id'] = $val['shrinkage_id'];
                $this->physical_report_model->update_physical_quantity($update, $val['id']);
            }
        }
        redirect($this->config->item('base_url') . 'stock/physical_report/view/' . $id);
    }

}
