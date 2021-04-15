<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sku_management extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'stock';
        $access_arr = array(
            'sku_management/project_cost_list' => array('add', 'edit', 'delete', 'view'),
            'stock/sku_management/index' => array('add', 'edit', 'delete', 'view'),
            'sku_management/add_invoice' => array('add', 'edit', 'delete', 'view'),
            'sku_management/quotation_view' => array('add', 'edit', 'delete', 'view'),
            'sku_management/invoice_view' => array('add', 'edit', 'delete', 'view'),
            'sku_management/quotation_view' => array('add', 'edit', 'delete', 'view'),
            'sku_management/new_quotation' => array('add', 'edit', 'delete', 'view'),
            'sku_management/quotation_delete' => array('delete'),
            'sku_management/quotation_add' => array('add', 'edit'),
            'sku_management/invoice_add' => array('add', 'edit'),
            'sku_management/update_quotation' => array('edit'),
            'sku_management/get_stock' => 'no_restriction',
            'sku_management/stock_details' => 'no_restriction',
            'sku_management/get_po' => 'no_restriction',
            'sku_management/change_status' => 'no_restriction',
            'sku_management/get_customer' => 'no_restriction',
            'sku_management/get_service' => 'no_restriction',
            'sku_management/get_customer_by_id' => 'no_restriction',
            'sku_management/stock_details' => 'no_restriction',
            'sku_management/get_product' => 'no_restriction',
            'sku_management/get_product_by_id' => 'no_restriction',
            'sku_management/delete_id' => 'no_restriction',
            'sku_management/delete_pc_id' => 'no_restriction',
            'sku_management/send_email' => 'no_restriction'
        );
//	if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
//	    redirect($this->config->item('base_url'));
//	}
        $this->load->model('masters/product_model');
        $this->load->model('masters/categories_model');
        $this->load->model('masters/brand_model');
        $this->load->model('masters/customer_model');
        $this->load->model('master_style/master_model');
        $this->load->model('sales/project_cost_model');
        $this->load->model('enquiry/enquiry_model');
        $this->load->model('admin/admin_model');
        $this->load->model('api/increment_model');
        $this->load->model('api/notification_model');
        $this->load->model('quotation/gen_model');
        $this->load->model('sales_return/sales_return_model');
        $this->load->model('stock/sku_management_model');
    }

    public function index() {
        $datas["sku_mgmt"] = $sku_mgmt = $this->sku_management_model->get_all_sku_management();

        // echo"<pre>"; print_r($datas); exit;
        $this->template->write_view('content', 'stock/index', $datas);
        $this->template->render();
    }

    public function get_product_by_id() {
        $input = $this->input->post();
        $data_customer["product_details"] = $this->project_cost_model->get_product_by_id($input['id']);
        echo json_encode($data_customer);
        exit;
    }

    public function add_sku() {
        if ($this->input->post()) {
            $input = $this->input->post();
            $user_info = $this->user_auth->get_from_session('user_info');
            $data['company_details'] = $this->admin_model->get_company_details();
            $input['sku']['sku_date'] = date('Y-m-d', strtotime($input['sku']['sku_date']));
            $input['sku']['status'] = 1;
            $insert_id = $this->sku_management_model->insert_sku($input['sku']);
            if (isset($insert_id) && !empty($insert_id)) {
                $input = $this->input->post();
                if (isset($input['categoty']) && !empty($input['categoty'])) {
                    $insert_arr = array();
                    $insert_pro = array();
                    foreach ($input['categoty'] as $key => $val) {
                        $insert['sku_id'] = $insert_id;
                        $insert['cat_id'] = $val;
                        $insert['product_id'] = $input['product_id'][$key];
                        $insert['brand_id'] = $input['brand'][$key];
                        $insert['sku_type'] = $input['sku_type'][$key];
                        $insert['stock'] = $input['stock'][$key];

                        $insert['qty'] = $input['quantity'][$key];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;

                        if ($input['product_id'][$key] == '' && $input['sku_type'][$key] == 2) {
                            $check_stock = array();
                            $insert_pro['category_id'] = $val;
                            $insert_pro['brand_id'] = $input['brand'][$key];
                            $insert_pro['model_no'] = '';
                            $insert_pro['product_name'] = $input['model_no'][$key];
                            $insert_pro['firm_id'] = $input['sku']['firm_id'];
                            $exist = $this->product_model->is_product_name_exist($insert_pro['product_name'], $insert_pro['category_id'], $insert_pro['firm_id']);
                            if ($exist == '') {
                                $product_id = $this->product_model->insert_product($insert_pro);
                                $check_stock['category'] = $val;
                                $check_stock['brand'] = $input['brand'][$key];
                                $check_stock['model_no'] = '';
                                $check_stock['product_id'] = $product_id;
                                $check_stock['firm_id'] = $input['sku']['firm_id'];
                                $check_stock['quantity'] = $input['quantity'][$key];
                                $this->product_model->check_stock($check_stock);
                            }
                        }
                    }
                    $this->sku_management_model->insert_sku_details($insert_arr);
                }
            }
            $insert_id++;
            $inc['type'] = 'sku_code';
            $inc['value'] = 'SKU00' . $insert_id;
            $this->sku_management_model->update_increment($inc);
            redirect($this->config->item('base_url') . 'stock/sku_management');
        }
        $data['firms'] = $firms = $this->user_auth->get_user_firms();
        $data["category"] = $details = $this->categories_model->get_all_category();
        $data["last_id"] = $this->master_model->get_last_id('sku_code');
        $data["brand"] = $this->brand_model->get_brand();
        $data["products"] = $this->gen_model->get_all_product();
//	echo "<pre>";
//	print_r($data);
//	exit;
        $this->template->write_view('content', 'stock/add_sku', $data);
        $this->template->render();
    }

    public function edit_sku($id) {
        if ($this->input->post()) {
            $input = $this->input->post();
            $user_info = $this->user_auth->get_from_session('user_info');
            $data['company_details'] = $this->admin_model->get_company_details();
            $input['sku']['sku_date'] = date('Y-m-d', strtotime($input['sku']['sku_date']));
            $input['sku']['updated_date'] = date('Y-m-d H:i:s');
            $input['sku']['status'] = 1;
            $this->sku_management_model->update_sku($input['sku'], $id);
            $this->sku_management_model->delete_sku_details($id);
            if (isset($id) && !empty($id)) {
                $input = $this->input->post();
                if (isset($input['categoty']) && !empty($input['categoty'])) {
                    $insert_arr = array();
                    foreach ($input['categoty'] as $key => $val) {
                        $insert['sku_id'] = $id;
                        $insert['cat_id'] = $val;
                        $insert['product_id'] = $input['product_id'][$key];
                        $insert['brand_id'] = $input['brand'][$key];
                        $insert['sku_type'] = $input['sku_type'][$key];
                        $insert['stock'] = $input['stock'][$key];

                        $insert['qty'] = $input['quantity'][$key];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;
                    }

                    $this->sku_management_model->insert_sku_details($insert_arr);
                }
            }
//	    $insert_id++;
//	    $inc['type'] = 'sku_code';
//	    $inc['value'] = 'SKU00' . $insert_id;
//	    $this->sku_management_model->update_increment($inc);
            redirect($this->config->item('base_url') . 'stock/sku_management');
        }
        $data['sku'] = $sku = $this->sku_management_model->get_sku_by_id($id);
        $data['sku_details'] = $sku = $this->sku_management_model->get_sku_details_by_id($id);
        $data['firms'] = $firms = $this->user_auth->get_user_firms();
        $data["category"] = $details = $this->categories_model->get_all_category();
        $data["last_id"] = $this->master_model->get_last_id('sku_code');
        $data["brand"] = $this->brand_model->get_brand();
        $data["products"] = $this->gen_model->get_all_product();
//	echo "<pre>";
//	print_r($data);
//	exit;
        $this->template->write_view('content', 'stock/edit_sku', $data);
        $this->template->render();
    }

    public function delete_sku($id) {
        $this->sku_management_model->delete_sku($id);
        $this->sku_management_model->delete_sku_details($id);
        redirect($this->config->item('base_url') . 'stock/sku_management');
    }

    public function get_stock_by_product() {
        $input = $this->input->post();
        $arr = $this->sku_management_model->get_stock_by_product($input['cat_id'], $input['pro_id']);
        echo json_encode($arr);
        exit;
    }

}
