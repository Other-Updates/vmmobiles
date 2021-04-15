<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Service extends MX_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->database();
        $this->load->library('form_validation');
        $this->load->model('master_category/master_category_model');
        $this->load->model('master_style/master_model');
        $this->load->model('master_brand/master_brand_model');
        $this->load->model('project_cost/project_cost_model');
        $this->load->model('customer/customer_model');
        $this->load->model('enquiry/enquiry_model');
        $this->load->model('admin/admin_model');
        $this->load->model('quotation/Gen_model');
        $this->load->model('service/service_model');
        $this->load->model('api/increment_model');
    }

    public function index() {
        if ($this->input->post()) {
            $input = $this->input->post();

            $data['company_details'] = $this->admin_model->get_company_details();
            $user_info = $this->user_info = $this->session->userdata('user_info');
            $input['quotation']['created_by'] = $user_info[0]['id'];
            $input['quotation']['created_date'] = date('Y-m-d H:i');
            //$this->service_model->delete_quotation( $input['quotation']['q_id']);
            $this->service_model->delete_quotation_deteils_by_id($input['quotation']['q_id']);
            $this->service_model->update_quotation($input['quotation'], $input['quotation']['q_id']);
            $insert_id = $this->service_model->get_id($input['quotation']['q_id']);
            //   echo"<pre>"; print_r($insert_id[0]['id']); exit;
            if (isset($insert_id) && !empty($insert_id)) {
                $input = $this->input->post();

                if (isset($input['categoty']) && !empty($input['categoty'])) {
                    $insert_arr = array();
                    foreach ($input['categoty'] as $key => $val) {
                        $insert['j_id'] = $insert_id[0]['id'];
                        $insert['q_id'] = $input['quotation']['q_id'];
                        $insert['category'] = $val;
                        $insert['product_id'] = $input['product_id'][$key];
                        $insert['product_description'] = $input['product_description'][$key];
                        $insert['brand'] = $input['brand'][$key];
                        $insert['quantity'] = $input['quantity'][$key];
                        $insert['per_cost'] = $input['per_cost'][$key];
                        $insert['tax'] = $input['tax'][$key];
                        $insert['sub_total'] = $input['sub_total'][$key];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;
                    }

                    $this->service_model->insert_quotation_details($insert_arr);
                }
                if (isset($input['item_name']) && !empty($input['item_name'])) {
                    $insert_arrs = array();
                    foreach ($input['item_name'] as $key => $val) {
                        $inserts['j_id'] = $insert_id[0]['id'];
                        $inserts['item_name'] = $val;
                        $inserts['amount'] = $input['amount'][$key];
                        $inserts['type'] = $input['type'][$key];

                        $insert_arrs[] = $inserts;
                    }
                    $this->service_model->insert_other_cost($insert_arrs);
                }
            }
            $insert_id++;
            $inc['type'] = 'job_code';
            $inc['value'] = 'JOB000' . $insert_id;
            $this->service_model->update_increment($inc);
            redirect($this->config->item('base_url') . 'service/service_list');
        }
    }

    public function add_invoice() {
        if ($this->input->post()) {
            $input = $this->input->post();
            $date = date('Y-m-d', strtotime($input['quotation']['warranty_from']));
            $new_date = date('Y-m-d', strtotime($input['quotation']['warranty_to']));
            $input['quotation']['warranty_from'] = $date;
            $input['quotation']['warranty_to'] = $new_date;
            // echo "<pre>"; print_r($input); exit;
            $data['company_details'] = $this->admin_model->get_company_details();
            $user_info = $this->user_info = $this->session->userdata('user_info');
            $input['quotation']['created_by'] = $user_info[0]['id'];
            $input['quotation']['created_date'] = date('Y-m-d H:i');
            $insert_id = $this->service_model->insert_invoice($input['quotation']);
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
                        $insert['brand'] = $input['brand'][$key];
                        $insert['quantity'] = $input['quantity'][$key];
                        $insert['per_cost'] = $input['per_cost'][$key];
                        $insert['tax'] = $input['tax'][$key];
                        $insert['sub_total'] = $input['sub_total'][$key];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;
                        $stock_arr = array();
                        $inv_id['inv_id'] = $input['quotation']['inv_id'];
                        $stock_arr[] = $inv_id;
                        $this->stock_details($insert, $inv_id);
                    }
                    $this->service_model->insert_invoice_details($insert_arr);
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
                    $this->service_model->insert_other_cost($insert_arrs);
                }
            }
            $insert_id++;
            $inc['type'] = 'inv_code';
            $inc['value'] = 'INV000' . $insert_id;
            $this->service_model->update_increment2($inc);
            redirect($this->config->item('base_url') . 'service/service_list');
        }
    }

    function stock_details($stock_info, $inv_id) {

        $this->service_model->check_stock($stock_info, $inv_id);
    }

    public function get_service() {
        $atten_inputs = $this->input->get();
        $product_data = $this->service_model->get_service($atten_inputs);

        echo '<ul id="service-list">';
        if (isset($product_data) && !empty($product_data)) {
            foreach ($product_data as $st_rlno) {
                if ($st_rlno['model_no'] != '')
                    echo '<li class="ser_class" ser_sell="' . $st_rlno['selling_price'] . '" ser_type="' . $st_rlno['type'] . '" ser_id="' . $st_rlno['id'] . '" ser_no="' . $st_rlno['model_no'] . '" ser_name="' . $st_rlno['product_name'] . '" ser_description="' . $st_rlno['product_description'] . '" ser_image="' . $st_rlno['product_image'] . '">' . $st_rlno['model_no'] . '</li>';
            }
        }
        else {
            echo '<li style="color:red;">No Data Found</li>';
        }
        echo '</ul>';
    }

    public function quotation_view($id) {
        $datas["quotation"] = $quotation = $this->service_model->get_all_pc_by_id($id);
        $datas["quotation_details"] = $quotation_details = $this->service_model->get_all_pc_details_by_id($id);
        $datas["category"] = $category = $this->service_model->get_all_category();
        $datas['company_details'] = $this->service_model->get_company_details();
        $datas["brand"] = $brand = $this->service_model->get_brand();
        $this->template->write_view('content', 'project_cost_view', $datas);
        $this->template->render();
    }

    public function invoice_view($id) {
        $datas["quotation"] = $quotation = $this->service_model->get_all_invoice_by_id($id);
        $datas["quotation_details"] = $quotation_details = $this->service_model->get_all_invoice_details_by_id($id);
        //echo "<pre>"; print_r($datas); exit;
        $datas["category"] = $category = $this->service_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();
        $this->template->write_view('content', 'invoice_view', $datas);
        $this->template->render();
    }

    public function change_status($id, $status) {
        $this->service_model->change_quotation_status($id, $status);
        redirect($this->config->item('base_url') . 'service/service_list');
    }

    public function service_list() {

        $datas["quotation"] = $quotation = $this->service_model->get_all_quotation();
        $datas['company_details'] = $this->admin_model->get_company_details();
        //echo "<pre>"; print_r($datas); exit;
        $this->template->write_view('content', 'service/service_list', $datas);
        $this->template->render();
    }

    public function service_view($id) {

        $datas["quotation"] = $quotation = $this->service_model->get_all_pc_service($id);
        $datas["quotation_details"] = $quotation_details = $this->service_model->get_all_pc_details_service($id);
        $datas["category"] = $category = $this->master_category_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();
        //echo"<pre>"; print_r($datas); exit;
        $this->template->write_view('content', 'service_view', $datas);
        $this->template->render();
    }

    public function get_customer() {
        $atten_inputs = $this->input->get();
        $data = $this->service_model->get_customer($atten_inputs);
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

    public function get_customer_by_id() {
        $input = $this->input->post();
        $data_customer["customer_details"] = $this->service_model->get_customer_by_id($input['id']);
        echo json_encode($data_customer);
        exit;
    }

    public function get_product() {
        $atten_inputs = $this->input->get();
        $product_data = $this->service_model->get_product($atten_inputs);

        echo '<ul id="product-list">';
        if (isset($product_data) && !empty($product_data)) {
            foreach ($product_data as $st_rlno) {
                if ($st_rlno['model_no'] != '')
                    echo '<li class="pro_class" pro_cost="' . $st_rlno['selling_price'] . '" pro_id="' . $st_rlno['id'] . '" mod_no="' . $st_rlno['model_no'] . '" pro_name="' . $st_rlno['product_name'] . '" pro_description="' . $st_rlno['product_description'] . '" pro_image="' . $st_rlno['product_image'] . '">' . $st_rlno['model_no'] . '</li>';
            }
        }
        else {
            echo '<li style="color:red;">No Data Found</li>';
        }
        echo '</ul>';
    }

    public function get_product_by_id() {
        $input = $this->input->post();
        $data_customer["product_details"] = $this->service_model->get_product_by_id($input['id']);
        echo json_encode($data_customer);
        exit;
    }

    public function get_invoice() {
        $input = $this->input->get();
        //  echo"<pre>"; print_r($input);
        $data["invoice"] = $invoice = $this->service_model->get_all_invoice_by_id($input['q_id']);
        // echo"<pre>"; print_r($data); exit;
        $url = $this->config->item('base_url') . 'service/project_cost_add/' . $input['q_id'];
        $url1 = $this->config->item('base_url') . 'service/service_list/';
        $date = Date($invoice[0]['warranty_to']) - Date($invoice[0]['warranty_from']);
        if ($date == 1) {
            echo '<table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" ><tr> <th colspan="2">  Free Warranty Service is Avaliable </th> </tr>';
            echo '<tr><td>Warranty From</td><td> <input type="text"  name="available_quantity[] class="code form-control colournamedup tabwid form-align " value="' . $invoice[0]['warranty_from'] . '" readonly="readonly" ></td></tr>';
            echo '<tr><td>Warranty To </td><td><input type="text" name="available_quantity[]"  class="code form-control colournamedup tabwid form-align wid175 " value="' . $invoice[0]['warranty_to'] . '" readonly="readonly" ></td></tr></table>';
            $datas["quotation"] = $quotation = $this->service_model->get_all_quotation_by_id($input['q_id']);
            $datas["quotation_details"] = $quotation_details = $this->service_model->get_all_quotation_details_by_id($input['q_id']);
            $datas["job_id"] = $job_id = $this->service_model->get_all_quotations();
            $datas["category"] = $category = $this->master_category_model->get_all_category();
            $datas['company_details'] = $this->admin_model->get_company_details();
            $datas["brand"] = $brand = $this->master_brand_model->get_brand();
            $datas["last_id"] = $this->master_model->get_last_id('job_code');

            $this->load->view('warranty_service', $datas);
        } else {

            echo '<table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" ><tr align="center"> <td align="center" colspan="2" > Warranty Period is Completed <b>' . $input['q_no'] . ' </b></td> </tr>';
            echo ' <tr> <td align="center"  colspan="2"> <a href= "' . $url . '" class="btn btn-defaultback"><span class="glyphicon"></span>Countinue</a> ';
            echo '  <a href= "' . $url1 . '" class="btn btn-defaultback"><span class="glyphicon"></span> Back</a> </td></tr></table>';
        }
    }

    public function project_cost_add($id) {

        $datas["quotation"] = $quotation = $this->service_model->get_all_quotation_by_id($id);
        $datas["quotation_details"] = $quotation_details = $this->service_model->get_all_quotation_details_by_id($id);
        $datas["job_id"] = $job_id = $this->service_model->get_all_quotations();
        $datas["category"] = $category = $this->master_category_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();
        // echo "<pre>"; print_r($datas); exit;
        $datas["last_id"] = $this->master_model->get_last_id('job_code');
        $this->template->write_view('content', 'warranty_service', $datas);
        $this->template->render();
    }

    public function project_cost_update($id) {
        $datas["job_id"] = $job_id = $this->service_model->get_all_quotations();

        $this->template->write_view('content', 'project_cost_add', $datas);
        $this->template->render();
    }

    public function paid_service_add() {

        if ($this->input->post()) {
            $input = $this->input->post();
            {
                $job_id = $input['quotation']['job_id'];

                $data['company_details'] = $this->admin_model->get_company_details();
                $input['quotation']['notification_date'] = date('Y-m-d');
                $input['quotation']['delivery_schedule'] = date('Y-m-d');
                $user_info = $this->user_info = $this->session->userdata('user_info');
                $input['quotation']['created_by'] = $user_info[0]['id'];
                $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));
                $input['quotation']['estatus'] = 2;
                $insert_id = $this->Gen_model->insert_quotation($input['quotation']);
                $inc['type'] = 'job_code';
                $inc['value'] = 'JOB000' . $insert_id;
                $this->project_cost_model->update_increment($inc);
                $datas["quotation"] = $quotation = $this->project_cost_model->get_all_quotation_by_id($insert_id);
                $datas["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_pc_details_by_id($id);
                //$input=$this->input->post();
                // echo "<pre>"; print_r($input); exit;
                $datas["category"] = $category = $this->master_category_model->get_all_category();
                $datas['company_details'] = $this->admin_model->get_company_details();
                $datas["brand"] = $brand = $this->master_brand_model->get_brand();
                $datas["quotation"][0]['q_id'] = $datas["quotation"][0]['id'];
                $datas["quotation"][0]['job_id'] = $job_id;
                unset($datas['quotation'][0]['delivery_schedule']);
                unset($datas['quotation'][0]['id']);
                unset($datas['quotation'][0]['mode_of_payment']);
                unset($datas['quotation'][0]['email_id']);
                unset($datas['quotation'][0]['address1']);
                unset($datas['quotation'][0]['name']);
                unset($datas['quotation'][0]['q_no']);
                unset($datas['quotation'][0]['other_cost']);
                unset($datas['quotation'][0]['ref_name']);
                unset($datas['quotation'][0]['nick_name']);
                unset($datas['quotation'][0]['store_name']);
                unset($datas['quotation'][0]['mobil_number']);
                $insert_id1 = $this->project_cost_model->insert_quotation($datas["quotation"][0]);
                if (isset($insert_id1) && !empty($insert_id1)) {
                    $input = $this->input->post();
                    if (isset($input['categoty']) && !empty($input['categoty'])) {
                        $insert_arrs = array();
                        foreach ($input['categoty'] as $key => $val) {
                            $inserts['j_id'] = $insert_id1;
                            $inserts['q_id'] = $datas["quotation"][0]['q_id'];
                            $inserts['category'] = $val;
                            $inserts['product_id'] = $input['product_id'][$key];
                            $inserts['product_description'] = $input['product_description'][$key];
                            $inserts['product_type'] = $input['product_type'][$key];
                            $inserts['brand'] = $input['brand'][$key];
                            $inserts['quantity'] = $input['quantity'][$key];
                            $inserts['per_cost'] = $input['per_cost'][$key];
                            $inserts['tax'] = $input['tax'][$key];
                            $inserts['sub_total'] = $input['sub_total'][$key];
                            $inserts['created_date'] = date('Y-m-d H:i');
                            $insert_arrs[] = $inserts;
                        }
                        //   echo "<pre>"; print_r($insert_arrs); exit;
                        $this->project_cost_model->insert_quotation_details($insert_arrs);
                    }
                    if (isset($input['item_name']) && !empty($input['item_name'])) {
                        $insert_arrs1 = array();
                        foreach ($input['item_name'] as $key => $val) {
                            $inserts1['j_id'] = $insert_id1;
                            $inserts1['item_name'] = $val;
                            $inserts1['amount'] = $input['amount'][$key];
                            $inserts1['type'] = $input['type'][$key];
                            $insert_arrs1[] = $inserts1;
                        }
                        $this->project_cost_model->insert_other_cost($insert_arrs1);
                    }
                }
                $insert_id1++;
//                $inc['type']='job_code';
//                $inc['value']='JOB000'.$insert_id1;
//                $this->project_cost_model->update_increment($inc);
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
                        $insert['type'] = $input['product_type'][$key];
                        $insert['brand'] = $input['brand'][$key];
                        $insert['quantity'] = $input['quantity'][$key];
                        $insert['per_cost'] = $input['per_cost'][$key];
                        $insert['tax'] = $input['tax'][$key];
                        $insert['sub_total'] = $input['sub_total'][$key];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;
                    }

                    $this->Gen_model->insert_quotation_details($insert_arr);
                }
            }
            $insert_id++;
            $inc['type'] = 'qno_code';
            $datas["quotation"] = $details = $this->Gen_model->get_all_quotation();
            $inc['type'] = 'job_code';
            $inc['value'] = 'JOB000' . $insert_id;
            $this->project_cost_model->update_increment($inc);
            redirect($this->config->item('base_url') . 'service/service_list', $datas);
        }

        $data['gno'] = $this->increment_model->get_increment_id('IS');
        $data["category"] = $details = $this->master_category_model->get_all_category();
        $data["brand"] = $this->master_brand_model->get_brand();
        $data["nick_name"] = $this->Gen_model->get_all_nick_name();
        $data['company_details'] = $this->admin_model->get_company_details();
        $data["last_id"] = $this->master_model->get_last_id('job_code');
        $this->template->write_view('content', 'service/paid_service', $data);
        $this->template->render();
    }

    public function update_quotation($id) {
        $his_quo = $this->service_model->get_his_quotation_by_id($id);
        $his_quo[0]['org_q_id'] = $his_quo[0]['id'];
        unset($his_quo[0]['id']);
        //echo "<pre>"; print_r($his_quo); exit;
        $insert_id = $this->service_model->insert_history_quotation($his_quo[0]);
        $input = $this->input->post();
        // echo "<pre>"; print_r($input); exit;
        $input['quotation']['notification_date'] = date('Y-m-d');
        $input['quotation']['delivery_schedule'] = date('Y-m-d');
        $user_info = $this->user_info = $this->session->userdata('user_info');
        $input['quotation']['created_by'] = $user_info[0]['id'];
        $input['quotation']['created_date'] = date('Y-m-d H:i:s');
        $update_id = $this->service_model->update_quotation($input['quotation'], $id);
        $his_quo1 = $this->service_model->get_all_history_quotation_by_id($id);
        //echo "<pre>"; print_r($his_quo1); exit;
        $his_quo_details['hist'] = $this->service_model->get_his_quotation_deteils_by_id($id);
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
            $this->service_model->insert_history_quotation_details($insert_arrs);

            $delete_id = $this->service_model->delete_quotation_deteils_by_id($id);
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
                $insert['sub_total'] = $input['sub_total'][$key];
                $insert['created_date'] = date('Y-m-d H:i:s');
                $insert_arr[] = $insert;
            }
            // echo "<pre>"; print_r($insert_arr); exit;
            $this->service_model->insert_quotation_details($insert_arr);
        }

        $datas["quotation"] = $quotation = $this->service_model->get_all_quotation();
        redirect($this->config->item('base_url') . 'service/service_list');
    }

    public function quotation_delete() {
        $id = $this->input->POST('value1');
        $datas["quotation"] = $quotation = $this->service_model->get_all_quotation();
        $del_id = $this->service_model->delete_quotation($id);
        redirect($this->config->item('base_url') . 'service/service_list');
    }

    public function history_view($id) {
        $datas["his_quo"] = $his_quo = $this->service_model->all_history_quotations($id);
        $this->template->write_view('content', 'history_view', $datas);
        $this->template->render();
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */