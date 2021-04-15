<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Project_cost extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('masters/categories_model');
        $this->load->model('masters/brand_model');
        $this->load->model('masters/customer_model');
        $this->load->model('master_style/master_model');
        $this->load->model('project_cost/project_cost_model');
        $this->load->model('enquiry/enquiry_model');
        $this->load->model('admin/admin_model');
        $this->load->model('api/increment_model');
        $this->load->model('api/notification_model');
        $this->load->model('quotation/Gen_model');
        $this->load->model('sales_return/sales_return_model');
    }

    public function index() {
        if ($this->input->post()) {
            $input = $this->input->post();
            $data['company_details'] = $this->admin_model->get_company_details();
            $user_info = $this->user_auth->get_from_session('user_info');
            $input['quotation']['created_by'] = $user_info[0]['id'];
            $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));

            $insert_id = $this->project_cost_model->insert_quotation($input['quotation']);
            if (isset($insert_id) && !empty($insert_id)) {
                $input = $this->input->post();
                if (isset($input['categoty']) && !empty($input['categoty'])) {
                    $insert_arr = array();
                    foreach ($input['categoty'] as $key => $val) {
                        $insert['j_id'] = $insert_id;
                        $insert['q_id'] = $input['quotation']['q_id'];
                        $insert['category'] = $val;
                        $insert['product_id'] = $input['product_id'][$key];
                        $insert['product_description'] = $input['product_description'][$key];
                        $insert['product_type'] = $input['product_type'][$key];
                        $insert['brand'] = $input['brand'][$key];
                        $insert['quantity'] = $input['quantity'][$key];
                        $insert['per_cost'] = $input['per_cost'][$key];
                        $insert['tax'] = $input['tax'][$key];
                        $insert['gst'] = $input['gst'][$key];
                        $insert['sub_total'] = $input['sub_total'][$key];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;
                    }
                    $this->project_cost_model->insert_quotation_details($insert_arr);
                }
                if (isset($input['item_name']) && !empty($input['item_name'])) {
                    $insert_arrs = array();
                    foreach ($input['item_name'] as $key => $val) {
                        $inserts['j_id'] = $insert_id;
                        $inserts['item_name'] = $val;
                        $inserts['amount'] = $input['amount'][$key];
                        $inserts['type'] = $input['type'][$key];

                        $insert_arrs[] = $inserts;
                    }
                    $this->project_cost_model->insert_other_cost($insert_arrs);
                }
            }

            $agent_ser = $this->project_cost_model->get_service_cost($insert['j_id']);
            $agent_other = $this->project_cost_model->get_other_cost($insert['j_id']);
            $user_info = $this->user_auth->get_from_session('user_info');
            $receipt = $this->project_cost_model->get_receipt_id($user_info[0]['id']);
            $amount = array();
            $user_info = $this->user_auth->get_from_session('user_info');
            $input = $this->input->post();
            $int['bill_amount'] = $agent_ser[0]['service_cost'] + $agent_other[0]['other_cost'];
            if ($user_info[0]['id'] != 0) {
                $int['recevier'] = 'agent';
                $int['recevier_id'] = $user_info[0]['id'];
                $int['receiver_type'] = 'Project Cost';
                $int['receipt_id'] = $input['quotation']['job_id'];
                ;
                $int['type'] = 'debit';
                $amount = $int;
                $this->load->model('sales_receipt/sales_receipt_model');
                $insert_agent_cash = $this->receipt_model->insert_agent_amount($amount);
            }

            redirect($this->config->item('base_url') . 'project_cost/project_cost_list');
        }
    }

    public function add_invoice() {
        if ($this->input->post()) {

            $user_info = $this->user_auth->get_from_session('user_info');
            $input = $this->input->post();
            $date = date('Y-m-d', strtotime($input['quotation']['warranty_from']));
            $new_date = date('Y-m-d', strtotime($input['quotation']['warranty_to']));
            $input['quotation']['warranty_from'] = $date;
            $input['quotation']['warranty_to'] = $new_date;
            $contract_customer = $input['quotation']['contract_customer'];
            $data['company_details'] = $this->admin_model->get_company_details();
            $user_info = $this->user_auth->get_from_session('user_info');
            $input['quotation']['created_by'] = $user_info[0]['id'];
            $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));

            $insert_id = $this->project_cost_model->insert_invoice($input['quotation']);
            unset($input['quotation']['contract_customer']);
            $this->sales_return_model->insert_sr($input['quotation']);
            if (isset($insert_id) && !empty($insert_id)) {
                $input = $this->input->post();
                if (isset($input['categoty']) && !empty($input['categoty'])) {
                    $insert_arr = array();
                    foreach ($input['categoty'] as $key => $val) {
                        $insert['in_id'] = $insert_id;
                        $insert['q_id'] = $input['quotation']['q_id'];
                        $insert['category'] = $val;
                        $insert['product_id'] = $input['product_id'][$key];
                        $insert['product_description'] = $input['product_description'][$key];
                        $insert['product_type'] = $input['product_type'][$key];
                        $insert['brand'] = $input['brand'][$key];
                        $insert['quantity'] = $input['quantity'][$key];
                        $insert['per_cost'] = $input['per_cost'][$key];
                        $insert['tax'] = $input['tax'][$key];
                        $insert['gst'] = $input['gst'][$key];
                        $insert['sub_total'] = $input['sub_total'][$key];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;
                        $stock_arr = array();
                        $inv_id['inv_id'] = $input['quotation']['inv_id'];
                        $stock_arr[] = $inv_id;
                        $this->stock_details($insert, $inv_id);
                    }
                    $this->project_cost_model->insert_invoice_details($insert_arr);
                }
                if (isset($input['item_name']) && !empty($input['item_name'])) {
                    $insert_arrs = array();
                    foreach ($input['item_name'] as $key => $val) {
                        $inserts['j_id'] = $insert_id;
                        $inserts['item_name'] = $val;
                        $inserts['amount'] = $input['amount'][$key];
                        $inserts['type'] = $input['type'][$key];
                        $insert_arrs[] = $inserts;
                    }
                    $this->project_cost_model->insert_other_cost($insert_arrs);
                }
            }
            $insert_id++;
            $inc['type'] = 'inv_code';
            $inc['value'] = 'INV000' . $insert_id;
            $this->project_cost_model->update_increment2($inc);

            if ($contract_customer != '') {
                $input = $this->input->post();
                $cust_type = $this->project_cost_model->get_customer_type($contract_customer);
                $new = array();
                $net_total = 0;
                foreach ($input['product_id'] as $key => $val) {
                    if ($cust_type == 1) {
                        $inp['per_cost'] = $this->project_cost_model->get_product_cash_selling_price($val);
                        $tax = (($input['tax'][$key] / 100) * $inp['per_cost']);
                        $gst = (($input['gst'][$key] / 100) * $inp['per_cost']);
                        $inp['sub_total'] = ($inp['per_cost'] * $input['quantity'][$key]) + ($tax * $input['quantity'][$key]) + ($gst * $input['quantity'][$key]);
                        $net_total += $inp['sub_total'];
                    } else if ($cust_type == 2) {
                        $inp['per_cost'] = $this->project_cost_model->get_product_credit_selling_price($val);
                        $tax = (($input['tax'][$key] / 100) * $inp['per_cost']);
                        $gst = (($input['gst'][$key] / 100) * $inp['per_cost']);
                        $inp['sub_total'] = ($inp['per_cost'] * $input['quantity'][$key]) + ($tax * $input['quantity'][$key]) + ($gst * $input['quantity'][$key]);
                        $net_total += $inp['sub_total'];
                    }
                    $input['new_sub_total'][] = $inp['sub_total'];
                    $input['new_per_cost'][] = $inp['per_cost'];
                }

                $input['quotation']['subtotal_qty'] = $net_total;
                $input['quotation']['net_total'] = $net_total + $input['quotation']['tax'];
                $date = date('Y-m-d', strtotime($input['quotation']['warranty_from']));
                $new_date = date('Y-m-d', strtotime($input['quotation']['warranty_to']));
                $input['quotation']['warranty_from'] = $date;
                $input['quotation']['warranty_to'] = $new_date;
                $input['quotation']['customer'] = $contract_customer;
                $last_id = $this->master_model->get_last_id('inv_code');
                $input['quotation']['inv_id'] = $last_id[0]['value'];
                $data['company_details'] = $this->admin_model->get_company_details();
                $user_info = $this->user_auth->get_from_session('user_info');
                $input['quotation']['created_by'] = $user_info[0]['id'];
                $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));
                // echo "<pre>";print_r($new); print_r($input); exit;
                $insert_id = $this->project_cost_model->insert_invoice($input['quotation']);
                //unset($input['quotation']['contract_customer']);
                //$this->sales_return_model->insert_sr($input['quotation']);
                if (isset($insert_id) && !empty($insert_id)) {
                    //$input = $this->input->post();
                    if (isset($input['categoty']) && !empty($input['categoty'])) {
                        $insert_arr = array();
                        foreach ($input['categoty'] as $key => $val) {
                            $insert['in_id'] = $insert_id;
                            $insert['q_id'] = $input['quotation']['q_id'];
                            $insert['category'] = $val;
                            $insert['product_id'] = $input['product_id'][$key];
                            $insert['product_description'] = $input['product_description'][$key];
                            $insert['product_type'] = $input['product_type'][$key];
                            $insert['brand'] = $input['brand'][$key];
                            $insert['quantity'] = $input['quantity'][$key];
                            $insert['per_cost'] = $input['new_per_cost'][$key];
                            $insert['tax'] = $input['tax'][$key];
                            $insert['gst'] = $input['gst'][$key];
                            $insert['sub_total'] = $input['new_sub_total'][$key];
                            $insert['created_date'] = date('Y-m-d H:i');
                            $insert_arr[] = $insert;
                            //$stock_arr = array();
                            //$inv_id['inv_id'] = $input['quotation']['inv_id'];
                            //$stock_arr[] = $inv_id;
                            // $this->stock_details($insert, $inv_id);
                        }
                        $this->project_cost_model->insert_invoice_details($insert_arr);
                    }
                    if (isset($input['item_name']) && !empty($input['item_name'])) {
                        $insert_arrs = array();
                        foreach ($input['item_name'] as $key => $val) {
                            $inserts['j_id'] = $insert_id;
                            $inserts['item_name'] = $val;
                            $inserts['amount'] = $input['amount'][$key];
                            $inserts['type'] = $input['type'][$key];
                            $insert_arrs[] = $inserts;
                        }
                        $this->project_cost_model->insert_other_cost($insert_arrs);
                    }
                }
                $insert_id++;
                $inc['type'] = 'inv_code';
                $inc['value'] = 'INV000' . $insert_id;
                $this->project_cost_model->update_increment2($inc);
            }


            redirect($this->config->item('base_url') . 'project_cost/project_cost_list');
        }
    }

    function get_stock() {
        $data = $this->input->get();
        $stock = $this->project_cost_model->get_stock($data);
        if (isset($stock) && !empty($stock)) {

            echo '<input type="text" tabindex="-1" name="available_quantity[]" style="width:70px;" class="code form-control colournamedup tabwid form-align " value="' . $stock[0]['quantity'] . '" readonly="readonly" autocomplete="off">';
        }
    }

    function stock_details($stock_info, $inv_id) {

        $this->project_cost_model->check_stock($stock_info, $inv_id);
    }

    function get_po() {
        $data = $this->input->get();
        $stock = $this->project_cost_model->get_po($data);
        if (isset($stock) && !empty($stock)) {
            echo'<input type="text"   tabindex="-1" value="' . $stock[0]['per_cost'] . '"   name="per_cost[]" style="width:70px;" class="percost required " id="price"/><span class="error_msg"></span>';
        } else {
            echo'<input type="text"   tabindex="-1"  name="per_cost[]" style="width:70px;" class="percost required" id="price"/><span class="error_msg"></span>';
        }
    }

    public function quotation_view($id) {
        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_pc_by_id($id);
        $datas["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_pc_details_by_id($id);
        //echo"<pre>"; print_r($datas); exit;
        $datas["category"] = $category = $this->categories_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->brand_model->get_brand();
        $this->template->write_view('content', 'project_cost_view', $datas);
        $this->template->render();
    }

    public function invoice_view($id) {
        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_invoice_by_id($id);
        $datas["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_invoice_details_by_id($id);
        $datas["category"] = $category = $this->categories_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->brand_model->get_brand();
        $this->template->write_view('content', 'invoice_view', $datas);
        $this->template->render();
    }

    public function change_status($id, $status) {
        $this->project_cost_model->change_quotation_status($id, $status);
        redirect($this->config->item('base_url') . 'project_cost/project_cost_list');
    }

    public function project_cost_list() {

        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_quotation();
        $datas['company_details'] = $this->admin_model->get_company_details();
        // echo"<pre>"; print_r($datas); exit;
        $this->template->write_view('content', 'project_cost/project_cost_list', $datas);
        $this->template->render();
    }

    public function get_customer() {
        $atten_inputs = $this->input->get();
        $data = $this->project_cost_model->get_customer($atten_inputs);
        echo '<ul id="country-list">';
        if (isset($data) && !empty($data)) {
            foreach ($data as $st_rlno) {
                if ($st_rlno['name'] != '')
                    echo '<li class="cust_class" cust_name="' . $st_rlno['name'] . '" cust_id="' . $st_rlno['id'] . '" cust_no="' . $st_rlno['mobil_number'] . '" cust_email="' . $st_rlno['email_id'] . '" cust_address="' . $st_rlno['address1'] . '">' . $st_rlno['name'] . '</li>';
            }
        }
        else {
            echo '<li style="color:red;">No Data Found</li>';
        }
        echo '</ul>';
    }

    public function get_service() {
        $atten_inputs = $this->input->get();
        $product_data = $this->project_cost_model->get_service($atten_inputs);

        echo '<ul id="service-list">';
        if (isset($product_data) && !empty($product_data)) {
            foreach ($product_data as $st_rlno) {
                if ($st_rlno['model_no'] != '')
                    echo '<li class="ser_class" ser_sell="' . $st_rlno['cost_price'] . '" ser_type="' . $st_rlno['type'] . '" ser_id="' . $st_rlno['id'] . '" ser_no="' . $st_rlno['model_no'] . '" ser_name="' . $st_rlno['product_name'] . '" ser_description="' . $st_rlno['product_description'] . '" ser_image="' . $st_rlno['product_image'] . '">' . $st_rlno['model_no'] . '</li>';
            }
        }
        else {
            echo '<li style="color:red;">No Data Found</li>';
        }
        echo '</ul>';
    }

    public function get_customer_by_id() {
        $input = $this->input->post();
        $data_customer["customer_details"] = $this->project_cost_model->get_customer_by_id($input['id']);
        echo json_encode($data_customer);
        exit;
    }

    public function get_product() {
        $atten_inputs = $this->input->get();
        $product_data = $this->project_cost_model->get_product($atten_inputs);

        echo '<ul id="product-list">';
        if (isset($product_data) && !empty($product_data)) {
            foreach ($product_data as $st_rlno) {
                if ($st_rlno['model_no'] != '')
                    echo '<li class="pro_class" pro_cost="' . $st_rlno['cost_price'] . '" pro_id="' . $st_rlno['id'] . '" mod_no="' . $st_rlno['model_no'] . '" pro_name="' . $st_rlno['product_name'] . '" pro_description="' . $st_rlno['product_description'] . '" pro_image="' . $st_rlno['product_image'] . '">' . $st_rlno['model_no'] . '</li>';
            }
        }
        else {
            echo '<li style="color:red;">No Data Found</li>';
        }
        echo '</ul>';
    }

    public function get_product_by_id() {
        $input = $this->input->post();
        $data_customer["product_details"] = $this->project_cost_model->get_product_by_id($input['id']);
        echo json_encode($data_customer);
        exit;
    }

    public function delete_id() {
        $input = $this->input->get();
        $del = $this->project_cost_model->delete_id($input['del_id']);
    }

    public function delete_pc_id() {
        $input = $this->input->get();
        $del = $this->project_cost_model->delete_pc_id($input['del_id']);
    }

    public function quotation_add($id) {
        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_quotation_by_id($id);
        $datas["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_quotation_details_by_id($id);
        //echo "<pre>"; echo $id ; print_r($datas); exit;
        $datas["category"] = $category = $this->categories_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->brand_model->get_brand();
        $datas["customer"] = $this->project_cost_model->get_customers();
        // $datas["last_id"]=$this->master_model->get_last_id('job_code');

        $this->template->write_view('content', 'project_cost_add', $datas);
        $this->template->render();
    }

    public function invoice_add($id, $q_id) {
        $id = $_GET['id'];
        $q_id = $_GET['q_id'];
        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_project_cost_by_id($id);
        $datas["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_project_details_by_id($id, $q_id);
        $datas["customer"] = $this->project_cost_model->get_customers();
        $datas["category"] = $category = $this->categories_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->brand_model->get_brand();
        $datas["last_id"] = $this->master_model->get_last_id('inv_code');
        $this->template->write_view('content', 'invoice_add', $datas);
        $this->template->render();
    }

    public function update_quotation($id) {
        $his_quo = $this->project_cost_model->get_his_quotation_by_id($id);
        $his_quo[0]['org_q_id'] = $his_quo[0]['id'];
        unset($his_quo[0]['id']);
        //echo "<pre>"; print_r($his_quo); exit;
        $insert_id = $this->project_cost_model->insert_history_quotation($his_quo[0]);
        $input = $this->input->post();
        // echo "<pre>"; print_r($input); exit;
        $input['quotation']['notification_date'] = date('Y-m-d');
        $input['quotation']['delivery_schedule'] = date('Y-m-d');
        $user_info = $this->user_auth->get_from_session('user_info');
        $input['quotation']['created_by'] = $user_info[0]['id'];
        $input['quotation']['created_date'] = date('Y-m-d H:i:s');
        $update_id = $this->project_cost_model->update_quotation($input['quotation'], $id);
        $his_quo1 = $this->project_cost_model->get_all_history_quotation_by_id($id);
        //echo "<pre>"; print_r($his_quo1); exit;
        $his_quo_details['hist'] = $this->project_cost_model->get_his_quotation_deteils_by_id($id);
        if (isset($his_quo_details['hist']) && !empty($his_quo_details['hist'])) {
            $insert_arrs = array();
            foreach ($his_quo_details['hist'] as $key) {
                $inserts = $key;
                $inserts['h_id'] = $insert_id;
                $inserts['org_q_id'] = $his_quo1[0]['org_q_id'];
                unset($inserts['id']);
                unset($inserts['q_id']);
                $insert_arrs[] = $inserts;
            }
            // echo "<pre>"; print_r($insert_arrs); exit;
            $this->project_cost_model->insert_history_quotation_details($insert_arrs);

            $delete_id = $this->project_cost_model->delete_quotation_deteils_by_id($id);
        }
        $input = $this->input->post();
        if (isset($input['categoty']) && !empty($input['categoty'])) {
            $insert_arr = array();
            foreach ($input['categoty'] as $key => $val) {

                $insert['q_id'] = $his_quo[0]['org_q_id'];
                $insert['category'] = $val;
                $insert['product_id'] = $input['product_id'][$key];
                $insert['product_description'] = $input['product_description'][$key];
                $insert['brand'] = $input['brand'][$key];
                $insert['quantity'] = $input['quantity'][$key];
                $insert['per_cost'] = $input['per_cost'][$key];
                $insert['tax'] = $input['tax'][$key];
                $insert['gst'] = $input['gst'][$key];
                $insert['sub_total'] = $input['sub_total'][$key];
                $insert['created_date'] = date('Y-m-d H:i:s');
                $insert_arr[] = $insert;
            }
            // echo "<pre>"; print_r($insert_arr); exit;
            $this->project_cost_model->insert_quotation_details($insert_arr);
        }

        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_quotation();
        redirect($this->config->item('base_url') . 'project_cost/project_cost_list');
    }

    public function quotation_delete() {
        $id = $this->input->POST('value1');
        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_quotation();
        $del_id = $this->project_cost_model->delete_quotation($id);
        redirect($this->config->item('base_url') . 'project_cost/project_cost_list');
    }

    public function send_email() {

        $this->load->library("Pdf");
        $id = $this->input->get();
        $data["quotation"] = $quotation = $this->project_cost_model->get_all_invoice_by_id($id['id']);
        $data["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_invoice_details_by_id($id['id']);
        $data["category"] = $category = $this->categories_model->get_all_category();
        $data['company_details'] = $this->admin_model->get_company_details();
        $data["brand"] = $brand = $this->brand_model->get_brand();
        $data["email_details"] = $email_details = $this->project_cost_model->get_all_email_details();

        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);
        $to_array = array($data['company_details'][0]['email'], $data['quotation'][0]['email_id']);
        $this->email->clear(TRUE);
        $this->email->to(implode(', ', $to_array));
        $this->email->from($data['email_details'][1]['value'], $data['email_details'][0]['value']);
        // $this->email->to($data['company_details'][0]['email'],$data['quotation'][0]['email_id']);
        $this->email->cc($data['email_details'][3]['value']);
        $this->email->subject($data['email_details'][2]['value']);
        $this->email->set_mailtype("html");
        $msg1['test'] = $this->load->view('project_cost/email_page', $data, TRUE);
        //$msg1['company_details']=$data['company_details'];
        $header = $this->load->view('quotation/pdf_header_view', $data, TRUE);
        $msg = $this->load->view('project_cost/pdf_email_template', $msg1, TRUE);
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->AddPage();
        $pdf->Header($header);
        $pdf->writeHTMLCell(0, 0, '', '', $msg, 0, 1, 0, true, '', true);
        $filename = 'Invoice-' . date('d-M-Y-H-i-s') . '.pdf';
        $newFile = $this->config->item('theme_path') . 'attachement/' . $filename;
        $pdf->Output($newFile, 'F');
        //echo "<pre>"; print_r($data); exit;
        $this->email->attach($this->config->item('theme_path') . 'attachement/' . $filename);
        $this->email->message('Dear ' . $data['quotation'][0]['name'] . ',We Thank you for choosing us, Kindly find the attachment for Invoice Details  <b>' . $data['quotation'][0]['inv_id'] . '</b><br>'
                . 'Company Name - ' . $data['quotation'][0]['store_name'] . '<br>
                    Address - ' . $data['quotation'][0]['address1'] . ' <br>
                        PH - ' . $data['quotation'][0]['mobil_number'] . ' <br>
                        Email ID - ' . $data['quotation'][0]['email_id'] . ' <br><br><br>Thanks<br>');
        $this->email->send();
    }

    public function new_quotation() {
        if ($this->input->post()) {
            $input = $this->input->post();

            // echo "<pre>"; print_r($input); exit;
            $data['company_details'] = $this->admin_model->get_company_details();
            $input['quotation']['notification_date'] = date('Y-m-d', strtotime($input['quotation']['notification_date']));
            $input['quotation']['delivery_schedule'] = date('Y-m-d', strtotime($input['quotation']['delivery_schedule']));
            $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
            $input['quotation']['estatus'] = 2;
            $input['quotation']['created_by'] = $user_info[0]['id'];
            $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));

            $insert_id = $this->Gen_model->insert_quotation($input['quotation']);
            $notification = array();
            if (isset($input['quotation']['notification_date']) && !empty($input['quotation']['notification_date'])) {
                $notification = array();
                $notification['notification_date'] = $input['quotation']['notification_date'];
                $notification['type'] = 'quotation';
                $receiver_list = array(1, 2);
                $notification['receiver_id'] = json_encode($receiver_list);
                $notification['link'] = 'quotation/quotation_list';
                $notification['Message'] = date('d-M-Y', strtotime($input['quotation']['notification_date'])) . ' is Quotation review date';
                $this->notification_model->insert_notification($notification);
            }
            $this->increment_model->update_increment_id('IS');

            if (isset($insert_id) && !empty($insert_id)) {
                $input = $this->input->post();
                if (isset($input['categoty']) && !empty($input['categoty'])) {

                    $insert_arr = array();
                    foreach ($input['categoty'] as $key => $val) {
                        $insert['q_id'] = $insert_id;
                        $insert['category'] = $val;
                        $insert['product_id'] = $input['product_id'][$key];
                        $insert['product_description'] = $input['product_description'][$key];
                        $insert['type'] = $input['type'][$key];
                        $insert['brand'] = $input['brand'][$key];
                        $insert['quantity'] = $input['quantity'][$key];
                        $insert['per_cost'] = $input['per_cost'][$key];
                        $insert['tax'] = $input['tax'][$key];
                        $insert['gst'] = $input['gst'][$key];
                        $insert['sub_total'] = $input['sub_total'][$key];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;
                    }

                    $this->Gen_model->insert_quotation_details($insert_arr);
                }
            }
            $insert_id++;
            $inc['type'] = 'qno_code';
            $inc['type'] = 'job_code';
            $inc['value'] = 'SL000' . $insert_id;
            $this->project_cost_model->update_increment($inc);
            $details = $this->Gen_model->get_all_quotation();
            redirect($this->config->item('base_url') . 'project_cost/project_cost_list');
        }
        $data['gno'] = $this->increment_model->get_increment_id('IS');
        $data["category"] = $details = $this->categories_model->get_all_category();
        $data["brand"] = $this->brand_model->get_brand();
        $data["nick_name"] = $this->Gen_model->get_all_nick_name();
        $data['company_details'] = $this->admin_model->get_company_details();
        $data["last_id"] = $this->master_model->get_last_id('job_code');
        $data['firms'] = $firms = $this->user_auth->get_user_firms();
        // echo "<pre>"; print_r($data); exit;
        $this->template->write_view('content', 'project_cost/new_quotation', $data);
        $this->template->render();
    }

}
