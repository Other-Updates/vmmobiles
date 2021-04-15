<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Delivery_challan extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->clear_cache();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'delivery_challan';
        $access_arr = array(
            'delivery_challan/delivery_challan_list' => array('add', 'edit', 'delete', 'view'),
            'delivery_challan/index' => array('add', 'edit', 'delete', 'view'),
            'delivery_challan/search_result' => array('add', 'edit', 'delete', 'view'),
            'delivery_challan/dc_view' => array('add', 'edit', 'delete', 'view'),
            'delivery_challan/dc_delete' => array('delete'),
            'delivery_challan/dc_edit' => array('add', 'edit'),
            'delivery_challan/update_dc' => array('edit'),
            'delivery_challan/change_status' => 'no_restriction',
            'delivery_challan/get_customer' => 'no_restriction',
            'delivery_challan/get_customer_by_id' => 'no_restriction',
            'delivery_challan/get_product' => 'no_restriction',
            'delivery_challan/get_product_by_id' => 'no_restriction',
            'delivery_challan/get_service' => 'no_restriction',
            'delivery_challan/delete_id' => 'no_restriction',
            'delivery_challan/stock_details' => 'no_restriction',
            'delivery_challan/clear_cache' => 'no_restriction',
            'delivery_challan/change_del_status' => 'no_restriction',
            'delivery_challan/ajaxList' => 'no_restriction'
        );
        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('masters/categories_model');
        $this->load->model('master_style/master_model');
        $this->load->model('masters/brand_model');
        $this->load->model('quotation/Gen_model');
        $this->load->model('masters/customer_model');
        $this->load->model('enquiry/enquiry_model');
        $this->load->model('admin/admin_model');
        $this->load->model('purchase_order/purchase_order_model');
        $this->load->model('delivery_challan/delivery_challan_model');
        $this->load->model('api/increment_model');
        $this->load->model('sales/project_cost_model');
    }

    public function index() {

        if ($this->input->post()) {
            $input = $this->input->post();

            $user_info = $this->user_auth->get_from_session('user_info');
            $data['company_details'] = $this->admin_model->get_company_details();
            $input['po']['created_by'] = $user_info[0]['id'];
            $input['po']['created_date'] = date('Y-m-d', strtotime($input['po']['created_date']));

            $insert_id = $this->delivery_challan_model->insert_dc($input['po']);
            $q_no = $input['po']['dc_no'];
            $split = explode("-", $q_no);
            $code = 'DC';
            $this->increment_model->update_increment_id($split[1], $code);
            if (isset($insert_id) && !empty($insert_id)) {
                $input = $this->input->post();
                if (isset($input['categoty']) && !empty($input['categoty'])) {
                    $insert_arr = array();
                    foreach ($input['categoty'] as $key => $val) {
                        $insert['dc_id'] = $insert_id;
                        $insert['category'] = $val;
                        $insert['product_id'] = $input['product_id'][$key];
                        $insert['product_description'] = $input['product_description'][$key];
                        $insert['type'] = $input['type'][$key];
                        $insert['brand'] = $input['brand'][$key];
                        $insert['unit'] = $input['unit'][$key];
                        $insert['quantity'] = $input['quantity'][$key];
                        $insert['per_cost'] = $input['per_cost'][$key];
                        $insert['tax'] = $input['tax'][$key];
                        $insert['gst'] = $input['gst'][$key];
                        $insert['sub_total'] = $input['sub_total'][$key];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;
                    }

                    $this->delivery_challan_model->insert_dc_details($insert_arr);
                }
            }
            redirect($this->config->item('base_url') . 'delivery_challan/delivery_challan_list');
        }
        $data["po"] = $details = $this->delivery_challan_model->get_all_dc();
        $data["last_id"] = $this->master_model->get_last_id('dl_code');
        $data["category"] = $details = $this->categories_model->get_all_category();
        $data["brand"] = $this->brand_model->get_brand();
        $data['firms'] = $firms = $this->user_auth->get_user_firms();
        $data['company_details'] = $this->admin_model->get_company_details();
        $this->template->write_view('content', 'delivery_challan/index', $data);
        $this->template->render();
    }

    public function dc_view($id) {

        $datas["po"] = $po = $this->delivery_challan_model->get_all_dc_by_id($id);

        $datas["po_details"] = $po_details = $this->delivery_challan_model->get_all_dc_details_by_id($id);

        $datas["category"] = $category = $this->categories_model->get_all_category();

        $datas['company_details'] = $this->admin_model->get_company_details();

        $datas["brand"] = $brand = $this->brand_model->get_brand();

        $datas['company_details'] = $this->project_cost_model->get_company_details_by_firm($id);

//        echo '<pre>';
//        print_r($datas);
//        exit;
        $this->template->write_view('content', 'delivery_challan_view', $datas);
        $this->template->render();
    }

    public function delivery_challan_list() {

        // $datas["po"] = $po = $this->delivery_challan_model->get_all_dc();
        //$datas['company_details'] = $this->admin_model->get_company_details();
//        $datas["po"] = $po = $this->delivery_challan_model->get_all_invoice();
//        echo '<pre>';
//        print_r($datas);
//        die;
        $this->template->write_view('content', 'delivery_challan/delivery_challan_list', $datas);
        $this->template->render();
    }

    public function get_customer($id) {
        $atten_inputs = $this->input->get();
        $data = $this->delivery_challan_model->get_customer($atten_inputs, $id);
        echo '<ul id="country-list">';
        if (isset($data) && !empty($data)) {
            foreach ($data as $st_rlno) {
                if ($st_rlno['store_name'] != '')
                    echo '<li class="cust_class" cust_name="' . $st_rlno['store_name'] . '" cust_id="' . $st_rlno['id'] . '" cust_no="' . $st_rlno['mobil_number'] . '" cust_email="' . $st_rlno['email_id'] . '" cust_address="' . $st_rlno['address1'] . '" cust_tin="' . $st_rlno['tin'] . '">' . $st_rlno['store_name'] . '</li>';
            }
        }
        else {
            echo '<li style="color:red;">No Data Found</li>';
        }
        echo '</ul>';
    }

    public function get_customer_by_id() {
        $input = $this->input->post();
        $data_customer["customer_details"] = $this->delivery_challan_model->get_customer_by_id($input['id']);
        echo json_encode($data_customer);
        exit;
    }

    public function get_product($id) {
        $atten_inputs = $this->input->get();
        $product_data = $this->delivery_challan_model->get_product($atten_inputs, $id);
        echo '<ul id="product-list">';
        if (isset($product_data) && !empty($product_data)) {
            foreach ($product_data as $st_rlno) {
                if ($st_rlno['product_name'] != '')
                    echo '<li class="pro_class" pro_cost="' . $st_rlno['cost_price'] . '" pro_type="' . $st_rlno['type'] . '" pro_id="' . $st_rlno['id'] . '" mod_no="' . $st_rlno['model_no'] . '" pro_name="' . $st_rlno['product_name'] . '" pro_description="' . $st_rlno['product_description'] . '" pro_image="' . $st_rlno['product_image'] . $cust_image . '" pro_cgst="' . $st_rlno['cgst'] . '"pro_sgst ="' . $st_rlno['sgst'] . '"pro_cat ="' . $st_rlno['category_id'] . '">' . $st_rlno['product_name'] . '</li>';
            }
        }
        else {
            echo '<li style="color:red;">No Data Found</li>';
        }
        echo '</ul>';
    }

    public function get_product_by_id() {
        $input = $this->input->post();
        $data_customer["product_details"] = $this->delivery_challan_model->get_product_by_id($input['id']);
        echo json_encode($data_customer);
        exit;
    }

    public function dc_edit($id) {

        $input = $this->input->post();
        // echo '<pre>';
        //print_r($input);
        // exit;
        foreach ($input['id'] as $key => $val) {
            $insert['delivery_quantity'] = $input['delivery_quantity'][$key];
            $this->delivery_challan_model->update_dc_details($insert, $val);
        }
        $d_qty = array_sum($input['delivery_quantity']);
        if ($d_qty == $input['total_qty']) {
            $inputs = array('delivery_status' => 'delivered', 'delivery_qty' => $d_qty);
            $this->delivery_challan_model->update_dc($inputs, $id);
        } else if ($d_qty < $input['total_qty']) {
            $inputs = array('delivery_status' => 'partially_delivered', 'delivery_qty' => $d_qty);
            $this->delivery_challan_model->update_dc($inputs, $id);
        } else if ($d_qty == 0) {
            $inputs = array('delivery_status' => 'pending', 'delivery_qty' => $d_qty);
            $this->delivery_challan_model->update_dc($inputs, $id);
        }
        // echo "<pre>"; print_r($insert_arr); exit;
        //$this->delivery_challan_model->update_dc($input, $id);
        redirect($this->config->item('base_url') . 'delivery_challan/delivery_challan_list');
    }

    public function update_dc($id) {
        $user_info = $this->user_auth->get_from_session('user_info');
        $input = $this->input->post();

        $input['po']['created_by'] = $user_info[0]['id'];
        $this->delivery_challan_model->update_dc($input['po'], $id);
        $this->delivery_challan_model->delete_dc_deteils_by_id($id);
        $input = $this->input->post();
        if (isset($input['categoty']) && !empty($input['categoty'])) {
            $insert_arr = array();
            foreach ($input['categoty'] as $key => $val) {
                $insert['dc_id'] = $id;
                $insert['category'] = $val;
                $insert['product_id'] = $input['product_id'][$key];
                $insert['product_description'] = $input['product_description'][$key];
                $insert['brand'] = $input['brand'][$key];
                $insert['unit'] = $input['unit'][$key];
                $insert['quantity'] = $input['quantity'][$key];
                $insert['per_cost'] = $input['per_cost'][$key];
                $insert['tax'] = $input['tax'][$key];
                $insert['gst'] = $input['gst'][$key];
                $insert['sub_total'] = $input['sub_total'][$key];
                $insert['created_date'] = date('Y-m-d H:i');
                $insert_arr[] = $insert;
            }
            // echo "<pre>"; print_r($insert_arr); exit;
            $this->delivery_challan_model->insert_dc_details($insert_arr);
        }
        redirect($this->config->item('base_url') . 'delivery_challan/delivery_challan_list');
    }

    public function dc_delete() {
        $id = $this->input->POST('value1');
        $datas["po"] = $po = $this->delivery_challan_model->get_all_dc();
        $del_id = $this->delivery_challan_model->delete_po($id);
        redirect($this->config->item('base_url') . 'delivery_challan/delivery_challan_list');
    }

    public function delete_id() {
        $input = $this->input->get();
        $del = $this->delivery_challan_model->delete_id($input['del_id']);
    }

    public function change_del_status() {
        $id = $this->input->post('value1');
        $status = $this->input->post('value2');
        $update = $this->delivery_challan_model->change_del_status($id, $status);
        if ($update) {
            echo 1;
            exit;
        } else {
            echo 0;
            exit;
        }
        //redirect($this->config->item('base_url') . 'purchase_order/purchase_order_list');
    }

    function clear_cache() {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    function ajaxList() {
        $search_data = $this->input->post();
        $search_arr = array();
        $search_arr['category'] = $search_data['category'];
        //$search_arr['brand'] = $search_data['brand'];
        $search_arr['product'] = $search_data['product'];
        //$search_arr['category'] = $search_data['category'];
        if (empty($search_arr)) {
            $search_arr = array();
        }
        $list = $this->delivery_challan_model->get_datatables($search_data);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ass) {
            $status = '';
            $del_status = '';
            $action = "";
            $url = "";
            $action_url = "";
            $alert = '';

            if ($ass->invoice_status == 'waiting') {
                $status = '<span class=" badge  bg-red">Waiting For Approval</span>';
            } else if ($ass->invoice_status == 'approved') {
                $status = '<span class=" badge bg-green">Approved</span>';
            }
            if ($ass->delivery_status == 'partially_delivered') {
                $del_status = ' <span  class="badge  bg-yellow update_status" onclick="check("' . $ass->id . ')";">Partially Delivered</span>';
            } else if ($ass->delivery_status == 'pending') {
                $del_status = ' <span class = "badge bg-red update_status" onclick = "check("' . $ass->id . '");">Pending</span>';
            } else {
                $del_status = '<span class = "badge bg-green update_status" onclick = "check("' . $ass->id . '");">Delivered</span>';
            }
            if ($this->user_auth->is_action_allowed('delivery_challan', 'delivery_challan', 'view')) {
                $url = $this->config->item('base_url') . 'delivery_challan/dc_view/' . $ass->id;
            }
            if (!$this->user_auth->is_action_allowed('delivery_challan', 'delivery_challan', 'view')) {
                $alert = 'alerts';
            }

            $action_url = ' <a href="' . $url . '" data-toggle="tooltip" class="tooltips btn btn-default btn-xs ' . $alert . '" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>';


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ass->firm_name;
            $row[] = $ass->inv_id;
            $row[] = $ass->store_name;
            $row[] = $ass->total_qty;
            $row[] = $ass->delivery_qty;
            $row[] = $ass->net_total;
            $row[] = $status;
            $row[] = $del_status;
            $row[] = $action_url;

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->delivery_challan_model->count_all(),
            "recordsFiltered" => $this->delivery_challan_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

}
