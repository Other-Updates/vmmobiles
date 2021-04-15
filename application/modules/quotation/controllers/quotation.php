<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Quotation extends MX_Controller {



    function __construct() {

        parent::__construct();

        $this->clear_cache();

        if (!$this->user_auth->is_logged_in()) {

            redirect($this->config->item('base_url') . 'admin');

        }

        $main_module = 'quotation';

        $access_arr = array(

            'quotation/quotation_view' => array('add', 'edit', 'delete', 'view'),

            'quotation/search_result' => array('add', 'edit', 'delete', 'view'),

            'quotation/quotation_list' => 'no_restriction',

            'quotation/index' => array('add', 'edit', 'delete', 'view'),

            'quotation/update_quotation' => array('edit'),

            'quotation/delete_id' => array('delete'),

            'quotation/quotation_edit' => array('add', 'edit'),

            'quotation/quotation_delete' => array('delete'),

            'quotation/change_status' => 'no_restriction',

            'quotation/get_customer' => 'no_restriction',

            'quotation/get_customer_by_id' => 'no_restriction',

            'quotation/get_product' => 'no_restriction',

            'quotation/get_service' => 'no_restriction',

            'quotation/history_view' => 'no_restriction',

            'quotation/send_email' => 'no_restriction',

            'quotation/get_prefix_by_frim_id' => 'no_restriction',

            'quotation/get_increment_id' => 'no_restriction',

            'quotation/get_reference_group_by_frim_id' => 'no_restriction',

            'quotation/get_sales_man_by_frim_id' => 'no_restriction',

            'quotation/send_notification' => 'no_restriction',

            'quotation/excel_report' => 'no_restriction',

            'quotation/get_product_by_frim_id' => 'no_restriction',

            'quotation/get_model_no_by_frim_id' => 'no_restriction',

            'quotation/clear_cache' => 'no_restriction',

            'quotation/quotation_ajaxList' => 'no_restriction',

        );



        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {

            $this->user_auth->is_permission_allowed();

            redirect($this->config->item('base_url'));

        }

        $this->load->model('masters/product_model');

        $this->load->model('masters/categories_model');

        $this->load->model('master_style/master_model');

        $this->load->model('masters/brand_model');

        $this->load->model('quotation/gen_model');

        $this->load->model('masters/customer_model');

        $this->load->model('admin/admin_model');

        $this->load->model('api/increment_model');

        $this->load->model('api/notification_model');

        $this->load->model('project_cost/project_cost_model');

        $this->load->model('masters/sms_model');

        $this->load->model('masters/reference_groups_model');

        if (isset($_GET['notification']))

            $this->notification_model->update_notification(array('status' => 1), $_GET['notification']);

    }



    public function search_result() {

        $search_data = $this->input->get();

        $this->load->model('quotation/gen_model');

        $data['search_data'] = $search_data;

        $data['all_gen'] = $this->gen_model->get_all_quotation($search_data);

        $this->load->view('quotation/search_list', $data);

    }



    public function index() {

        if ($this->input->post()) {

            $input = $this->input->post();

            $data['company_details'] = $this->admin_model->get_company_details();

            $input['quotation']['notification_date'] = date('Y-m-d', strtotime($input['quotation']['notification_date']));

            $input['quotation']['delivery_schedule'] = date('Y-m-d', strtotime($input['quotation']['delivery_schedule']));

            $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');

            $input['quotation']['created_by'] = $user_info[0]['id'];

            $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));



            $insert_id = $this->gen_model->insert_quotation($input['quotation']);

            $notification = array();

            if (isset($input['quotation']['notification_date']) && !empty($input['quotation']['notification_date']) && $input['quotation']['notification_date'] != '1970-01-01') {

                $notification = array();

                $notification['notification_date'] = $input['quotation']['notification_date'];

                $notification['type'] = 'quotation';

                $receiver_list = array(1, 2);

                $notification['receiver_id'] = json_encode($receiver_list);

                $notification['link'] = 'quotation/quotation_list';

                $notification['Message'] = 'New Quotation (' . $input['quotation']['q_no'] . ') is Created , and the review date will be on ' . date('d-M-Y', strtotime($input['quotation']['notification_date']));

                //$notification['Message'] = date('d-M-Y', strtotime($input['quotation']['notification_date'])) . ' is Quotation review date';

                $this->notification_model->insert_notification($notification);

            }

            $q_no = $input['quotation']['q_no'];

            $split = explode("-", $q_no);

            $code = 'TT';

            $this->increment_model->update_increment_id($split[0], $code);

            if (isset($insert_id) && !empty($insert_id)) {

                $input = $this->input->post();

                if (isset($input['categoty']) && !empty($input['categoty'])) {



                    $insert_arr = array();

                    foreach ($input['categoty'] as $key => $val) {

                        $insert['q_id'] = $insert_id;

                        $insert['category'] = $val;

                        $insert['product_id'] = $input['product_id'][$key];

                        if (!empty($input['quotation']['product_description']))

                            $insert['product_description'] = $input['product_description'][$key];

                        else

                            $insert['product_description'] = 'null';

                        $insert['type'] = $input['type'][$key];

                        $insert['brand'] = $input['brand'][$key];

                        $insert['unit'] = $input['unit'][$key];

                        $insert['quantity'] = $input['quantity'][$key];

                        $insert['per_cost'] = $input['per_cost'][$key];

                        $insert['tax'] = $input['tax'][$key];

                        $insert['gst'] = $input['gst'][$key];

                        $insert['igst'] = $input['igst'][$key];

                        $insert['discount'] = $input['discount'][$key];

                        $insert['sub_total'] = $input['sub_total'][$key];

                        $insert['created_date'] = date('Y-m-d H:i');

                        $insert_arr[] = $insert;

                    }



                    $this->gen_model->insert_quotation_details($insert_arr);

                }

            }

            $sms = $this->sms_model->send_sms($insert_id, 'quotation');



            if ($input['print'] == 'yes') {

                $file_name = base_url() . 'quotation/quotation_view/' . $insert_id;

                echo "<script>window.location.href = '$file_name';</script>";

                exit;

            } else {

                $redirect_url = base_url() . 'quotation/quotation_list';

                echo "<script>window.location.href = '$redirect_url';</script>";

                exit;

            }



            // redirect($this->config->item('base_url') . 'quotation/quotation_list');

        }



        $data["category"] = $details = $this->categories_model->get_all_category();

        $data["brand"] = $this->brand_model->get_brand();

        $data["nick_name"] = $this->gen_model->get_all_nick_name();

        $data["ref_grps"] = $this->reference_groups_model->get_references();

        $data['company_details'] = $this->admin_model->get_company_details();

        $data['firms'] = $firms = $this->user_auth->get_user_firms();

        $data["products"] = $this->gen_model->get_all_product();

        $data["customers"] = $this->gen_model->get_all_customers();



        $this->template->write_view('content', 'quotation/index', $data);

        $this->template->render();

    }



    public function quotation_view($id) {

        $datas["quotation"] = $quotation = $this->gen_model->get_all_quotation_by_id($id);

        $datas["quotation_details"] = $quotation_details = $this->gen_model->get_all_quotation_details_by_id($id);

        $datas["category"] = $category = $this->categories_model->get_all_category();

        // $datas['company_details'] = $this->admin_model->get_company_details();

        $datas['company_details'] = $this->gen_model->get_company_details_by_firm($id);

//        echo '<pre>';

//        print_r($datas['company_details']);

//        exit;

        $datas["brand"] = $brand = $this->brand_model->get_brand();

        $this->template->write_view('content', 'quotation_view', $datas);

        $this->template->render();

    }



    public function delete_id() {

        $input = $this->input->get();

        $del = $this->gen_model->delete_id($input['del_id']);

    }



    public function change_status($id, $status) {

        $this->gen_model->change_quotation_status($id, $status);

        $user_info = $this->user_auth->get_from_session('user_info');

        $quotation = $this->gen_model->get_his_quotation_by_id($id);

        $quotation_details = $this->gen_model->get_his_quotation_deteils_by_id($id);

        $customer_details = $this->customer_model->get_customer1($quotation[0]['customer']);

        $sub_tot = 0;

        foreach ($quotation_details as $vals) {

            $sub_tot += ($vals['per_cost'] * $vals['quantity']);

        }



        $input['quotation']['invoice_status'] = 'waiting';

        $input['quotation']['delivery_status'] = 'pending';

        $input['quotation']['payment_status'] = 'pending';

        $input['quotation']['estatus'] = 1;

        $input['quotation']['ref_name'] = $quotation[0]['ref_name'];



//$input['quotation']['delivery_status'] = 'pending';

        $data['company_details'] = $this->admin_model->get_company_details();

        $data['customer_details'] = $customer_details = $this->customer_model->get_customer1($quotation[0]['customer']);

//$contract_customer = $input['quotation']['contract_customer'];

        $input['quotation']['created_by'] = $user_info[0]['id'];

        $input['quotation']['created_date'] = date('Y-m-d', strtotime($quotation[0]['created_date']));

        $input['quotation']['credit_due_date'] = date('Y-m-d', strtotime($quotation[0]['created_date'] . "+" . $data['customer_details'][0]['credit_days'] . " days"));

        $ref_amount = $this->gen_model->get_reference_amount($quotation[0]['ref_name']);

        $input['quotation']['commission_rate'] = ($quotation[0]['net_total'] / 100 ) * $ref_amount;

        $input['quotation']['transport'] = '0.00';

        $input['quotation']['labour'] = '0.00';

        $input['quotation']['round_off'] = '0.00';

        if ($input['quotation']['credit_days'] == '') {

            $input['quotation']['credit_days'] = NULL;

        }if ($input['quotation']['credit_limit'] == '') {

            $input['quotation']['credit_limit'] = NULL;

        }if ($input['quotation']['temp_credit_limit'] == '') {

            $input['quotation']['temp_credit_limit'] = NULL;

        }if ($input['quotation']['approved_by'] == '') {

            $input['quotation']['approved_by'] = NULL;

        }

        $input['quotation']['delivery_qty'] = 0;

        $input['quotation']['inv_id'] = $quotation[0]['inv_id'];

        $input['quotation']['firm_id'] = $quotation[0]['firm_id'];

        $input['quotation']['customer'] = $quotation[0]['customer'];

        $input['quotation']['total_qty'] = $quotation[0]['total_qty'];

        $input['quotation']['delivery_qty'] = 0;

        $input['quotation']['tax_label'] = $quotation[0]['tax_label'];

        $input['quotation']['tax'] = $quotation[0]['tax'];

        $input['quotation']['subtotal_qty'] = $sub_tot;

        $input['quotation']['net_total'] = $quotation[0]['net_total'];

        $input['quotation']['bill_type'] = 'cash';

        $input['quotation']['customer_po'] = '';

        $input['quotation']['remarks'] = '';

        $input['quotation']['q_id'] = $id;

        $insert_id = $this->project_cost_model->insert_invoice($input['quotation']);

        $insert_arr = array();



        if (isset($insert_id) && !empty($insert_id)) {

            foreach ($quotation_details as $vals) {

                $insert['in_id'] = $insert_id;

                $insert['q_id'] = $id;

                $insert['category'] = $vals['category'];

                $insert['product_id'] = $vals['product_id'];

                $insert['product_description'] = ($vals['product_description'] != 'null' && $vals['product_description'] != '') ? $vals['product_description'] : '';

                $insert['product_type'] = 1;

                $insert['brand'] = $vals['brand'];

                $insert['unit'] = $vals['unit'];

                $insert['quantity'] = $vals['quantity'];



                $insert['delivery_quantity'] = 0;



                $insert['per_cost'] = $vals['per_cost'];

                $insert['tax'] = $vals['tax'];

                $insert['gst'] = $vals['gst'];

                $insert['igst'] = (!empty($vals['igst']) && $vals['igst'] != 0) ? $vals['igst'] : '';



                $insert['discount'] = (!empty($vals['discount']) && $vals['discount'] != 0) ? $vals['discount'] : '';

                $insert['sub_total'] = $vals['quantity'] * $vals['per_cost'];

                $insert['created_date'] = date('Y-m-d H:i');

                $insert_arr[] = $insert;

                $stock_arr = array();

                $inv_id['inv_id'] = $quotation[0]['inv_id'];

                $stock_arr[] = $inv_id;

                $this->stock_details($insert, $inv_id);

            }

            $this->project_cost_model->insert_invoice_details($insert_arr);

            $this->gen_model->insert_invoice_product_details($insert_arr);

        }

        redirect($this->config->item('base_url') . 'quotation/quotation_list');

    }



    function stock_details($stock_info, $inv_id) {



        $this->project_cost_model->check_stock($stock_info, $inv_id);

    }



    public function quotation_list() {

        $datas['quotation'] = $this->gen_model->get_all_quotation();

        $datas['company_details'] = $this->admin_model->get_company_details();

        $this->template->write_view('content', 'quotation/quotation_list', $datas);

        $this->template->render();

    }



    public function get_customer() {

        $atten_inputs = $this->input->post();

        $data = $this->gen_model->get_customer($atten_inputs);

        echo json_encode($data);

        exit;

//        echo '<ul id="country-list">';

//        if (isset($data) && !empty($data)) {

//            foreach ($data as $st_rlno) {

//                if ($st_rlno['store_name'] != '')

//                    echo '<li class="cust_class" cust_name="' . $st_rlno['store_name'] . '" cust_id="' . $st_rlno['id'] . '" cust_no="' . $st_rlno['mobil_number'] . '" cust_email="' . $st_rlno['email_id'] . '" cust_address="' . $st_rlno['address1'] . '" cust_tin="' . $st_rlno['tin'] . '" credit_days="' . $st_rlno['credit_days'] . '" credit_limit="' . $st_rlno['credit_limit'] . '" temp_credit_limit="' . $st_rlno['temp_credit_limit'] . '" approved_by="' . $st_rlno['approved_by'] . '">' . $st_rlno['store_name'] . '</li>';

//            }

//        }

//        else {

//            echo '<li style="color:red height:2px;">No Data Found</li>';

//        }

//        echo '</ul>';

    }



    public function get_customer_by_id() {

        $input = $this->input->post();

        $data_customer["customer_details"] = $this->gen_model->get_customer_by_id($input['id']);

        echo json_encode($data_customer);

        exit;

    }



    public function get_product_by_frim_id() {



        $input = $this->input->post();

        $products = $this->gen_model->get_product_by_frim_id($input);



        echo json_encode($products);

        exit;

    }



    public function get_model_no_by_frim_id() {



        $input = $this->input->post();

        $products = $this->gen_model->get_model_no_by_frim_id($input['firm_id']);

        echo json_encode($products);

        exit;

    }



    public function get_product() {

        $atten_inputs = $this->input->post();

        $product_data = $this->gen_model->get_product($atten_inputs);

        $cust_type = 'cost_price';

        if ($atten_inputs['c_id'] != '') {

            $cus_type = $this->gen_model->get_customer_by_id($atten_inputs['c_id']);
            $product_data[0]['selling_price'] = $product_data[0]['sales_price'];
            

           /* if ($cus_type[0]['customer_type'] == 1) {

                $product_data[0]['selling_price'] = $product_data[0]['cash_cus_price'];

            } else if ($cus_type[0]['customer_type'] == 2) {

                $product_data[0]['selling_price'] = $product_data[0]['credit_cus_price'];

            } else if ($cus_type[0]['customer_type'] == 3) {

                $product_data[0]['selling_price'] = $product_data[0]['cash_con_price'];

            } else if ($cus_type[0]['customer_type'] == 4) {

                $product_data[0]['selling_price'] = $product_data[0]['credit_con_price'];

            } else if ($cus_type[0]['customer_type'] == 5) {

                $product_data[0]['selling_price'] = $product_data[0]['vip_price'];

            } else if ($cus_type[0]['customer_type'] == 6) {

                $product_data[0]['selling_price'] = $product_data[0]['vvip_price'];

            } else if ($cus_type[0]['customer_type'] == 7) {

                $product_data[0]['selling_price'] = $product_data[0]['h1_price'];

            } else if ($cus_type[0]['customer_type'] == 8) {

                $product_data[0]['selling_price'] = $product_data[0]['h2_price'];

            }*/

        }

        echo json_encode($product_data);

        exit;

//        echo '<ul  id="product-list" style="width:25%">';

//        if (isset($product_data) && !empty($product_data)) {

//            foreach ($product_data as $st_rlno) {

//                if (!empty($st_rlno['product_image'])) {

//                    $file = FCPATH . 'attachement/product/' . $st_rlno['product_image'];

//                    $exists = file_exists($file);

//                }

//                $cust_image = (!empty($exists) && isset($exists)) ? $st_rlno['product_image'] : "no-img.gif";

//                if ($st_rlno['product_name'] != '')

//                    echo '<li class="pro_class" pro_sell="' . $st_rlno[$cust_type] . '" pro_type="' . $st_rlno['type'] . '" pro_id="' . $st_rlno['id'] . '" mod_no="' . $st_rlno['model_no'] . '" pro_name="' . $st_rlno['product_name'] . '" pro_description="' . $st_rlno['product_description'] . '" pro_image="' . $cust_image . '" pro_cgst="' . $st_rlno['cgst'] . '"pro_sgst ="' . $st_rlno['sgst'] . '"pro_discount ="' . $st_rlno['discount'] . '"pro_cat ="' . $st_rlno['category_id'] . '"pro_brand ="' . $st_rlno['brand_id'] . '">' . $st_rlno['product_name'] . '</li>';

//            }

//        }

//        else {

//            echo '<li style="color:red height:2px;">No Data Found</li>';

//        }

//        echo '</ul>';

    }



    public function get_product_by_id() {

        $input = $this->input->post();

        $data_customer["product_details"] = $this->gen_model->get_product_by_id($input['id']);

        echo json_encode($data_customer);

        exit;

    }



    public function get_service() {

        $atten_inputs = $this->input->get();

        $product_data = $this->gen_model->get_service($atten_inputs);



        echo '<ul id="service-list">';

        if (isset($product_data) && !empty($product_data)) {

            foreach ($product_data as $st_rlno) {

                if (!empty($st_rlno['product_image'])) {

                    $file = FCPATH . 'attachement/product/' . $st_rlno['product_image'];

                    $exists = file_exists($file);

                }

                $cust_image = (!empty($exists) && isset($exists)) ? $st_rlno['product_image'] : "no-img.gif";

                if ($st_rlno['model_no'] != '')

                    echo '<li class="ser_class" ser_sell="' . $st_rlno['selling_price'] . '" ser_type="' . $st_rlno['type'] . '" ser_id="' . $st_rlno['id'] . '" ser_no="' . $st_rlno['model_no'] . '" ser_name="' . $st_rlno['product_name'] . '" ser_description="' . $st_rlno['product_description'] . '" ser_image="' . $cust_image . '" ser_cgst="' . $st_rlno['cgst'] . '"ser_sgst ="' . $st_rlno['sgst'] . '"ser_cat ="' . $st_rlno['category_id'] . '">' . $st_rlno['product_name'] . '</li>';

            }

        }

        else {

            echo '<li class="no_data" style="color:red;">No Data Found</li>';

        }

        echo '</ul>';

    }



    public function quotation_edit($id) {

        $datas["quotation"] = $quotation = $this->gen_model->get_all_quotation_by_id($id);

        $datas["quotation_details"] = $quotation_details = $this->gen_model->get_all_quotation_details_by_id($id);

        $datas['company_details'] = $this->admin_model->get_company_details();

        $datas["category"] = $category = $this->categories_model->get_all_category();

        $datas["brand"] = $brand = $this->brand_model->get_brand();

        $datas["nick_name"] = $this->gen_model->get_all_nick_name();

        $datas['firms'] = $firms = $this->user_auth->get_user_firms();

        $datas["products"] = $this->gen_model->get_all_product();

        $datas["customers"] = $this->gen_model->get_all_customers();

        $datas["ref_grps"] = $this->reference_groups_model->get_references();

//        echo "<pre>";

//        print_r($datas["quotation_details"]);

//        exit;

        $this->template->write_view('content', 'quotation_edit', $datas);

        $this->template->render();

    }



    public function update_quotation($id) {



        $his_quo = $this->gen_model->get_his_quotation_by_id($id);

        $his_quo[0]['org_q_id'] = $his_quo[0]['id'];

        unset($his_quo[0]['id']);



        // echo "<pre>"; print_r($his_quo); exit;

        $insert_id = $this->gen_model->insert_history_quotation($his_quo[0]);

        $input = $this->input->post();



        $input['quotation']['notification_date'] = date('Y-m-d', strtotime($input['quotation']['notification_date']));

        $input['quotation']['delivery_schedule'] = date('Y-m-d', strtotime($input['quotation']['delivery_schedule']));

        $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');

        $input['quotation']['created_by'] = $user_info[0]['id'];

        $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));

        $update_id = $this->gen_model->update_quotation($input['quotation'], $id);

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

        $his_quo1 = $this->gen_model->get_all_history_quotation_by_id($id);

        //echo "<pre>"; print_r($his_quo1); exit;

        $his_quo_details['hist'] = $this->gen_model->get_his_quotation_deteils_by_id($id);

        if (isset($his_quo_details['hist']) && !empty($his_quo_details['hist'])) {

            $insert_arrs = array();

            foreach ($his_quo_details['hist'] as $key) {

                $inserts = $key;

                $inserts['h_id'] = $insert_id;

                $inserts['org_q_id'] = $his_quo1[0]['org_q_id'];

                unset($inserts['id']);

                unset($inserts['q_id']);

                if (!empty($his_quo_details['hist']['product_description'][$key]))

                    $inserts['product_description'] = $his_quo_details['hist']['product_description'][$key];

                else

                    $inserts['product_description'] = 'null';



                $insert_arrs[] = $inserts;

            }

            // echo "<pre>"; print_r($insert_arrs); exit;

            $this->gen_model->insert_history_quotation_details($insert_arrs);



            $delete_id = $this->gen_model->delete_quotation_deteils_by_id($id);

        }

        $input = $this->input->post();

        if (isset($input['categoty']) && !empty($input['categoty'])) {

            $insert_arr = array();

            foreach ($input['categoty'] as $key => $val) {



                $insert['q_id'] = $his_quo[0]['org_q_id'];

                $insert['category'] = $val;

                $insert['product_id'] = $input['product_id'][$key];

                if (!empty($input['product_description'][$key]))

                    $insert['product_description'] = $input['product_description'][$key];

                else

                    $insert['product_description'] = 'null';

                $insert['brand'] = $input['brand'][$key];

                $insert['unit'] = $input['unit'][$key];

                $insert['quantity'] = $input['quantity'][$key];

                $insert['per_cost'] = $input['per_cost'][$key];

                $insert['tax'] = $input['tax'][$key];

                $insert['gst'] = $input['gst'][$key];

                $insert['igst'] = $input['igst'][$key];

                $insert['discount'] = $input['discount'][$key];

                $insert['sub_total'] = $input['sub_total'][$key];

                $insert['created_date'] = date('Y-m-d H:i:s');

                $insert_arr[] = $insert;

            }

            // echo "<pre>"; print_r($insert_arr); exit;

            $this->gen_model->insert_quotation_details($insert_arr);

        }



        $datas["quotation"] = $quotation = $this->gen_model->get_all_quotation();

        redirect($this->config->item('base_url') . 'quotation/quotation_list', $datas);

    }



    public function quotation_delete() {

        $id = $this->input->POST('value1');

        $datas["quotation"] = $quotation = $this->gen_model->get_all_quotation();

        $del_id = $this->gen_model->delete_quotation($id);

        redirect($this->config->item('base_url') . 'quotation/quotation_list', $datas);

    }



    public function history_view($id) {

        $datas["his_quo"] = $his_quo = $this->gen_model->all_history_quotations($id);

        //echo "<pre>"; print_r($datas); exit;

        $this->template->write_view('content', 'quotation/history_view', $datas);

        $this->template->render();

    }



    public function send_email() {



        $this->load->library("Pdf");

        $id = $this->input->get();

        $data["quotation"] = $quotation = $this->gen_model->get_all_quotation_by_id($id['id']);

        $data["quotation_details"] = $quotation_details = $this->gen_model->get_all_quotation_details_by_id($id['id']);

        $data["category"] = $category = $this->categories_model->get_all_category();

        $data['company_details'] = $this->admin_model->get_company_details();

        $data["brand"] = $brand = $this->brand_model->get_brand();

        $data["email_details"] = $email_details = $this->gen_model->get_all_email_details();



        $this->load->library('email');

        $config['protocol'] = 'sendmail';

        $config['mailpath'] = '/usr/sbin/sendmail';

        $config['charset'] = 'iso-8859-1';

        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);



        $to_array = array($data['company_details'][0]['email'], $data['quotation'][0]['email_id']);

        //echo '<pre>'; print_r($to_array); exit;

        $this->email->clear(TRUE);

        $this->email->to(implode(', ', $to_array));

        $this->email->from($data['email_details'][1]['value'], $data['email_details'][0]['value']);

        $this->email->cc($data['email_details'][3]['value']);

        $this->email->subject($data['email_details'][2]['value']);

        $this->email->set_mailtype("html");

        $msg1['test'] = $this->load->view('quotation/email_page', $data, TRUE);

        //$msg1['company_details']=$data['company_details'];

        //echo "<pre>"; print_r($msg1); exit;

        $header = $this->load->view('quotation/pdf_header_view', $data, TRUE);

        $msg = $this->load->view('quotation/pdf_email_template', $msg1, TRUE);

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->AddPage();

        $pdf->Header($header);

        $pdf->writeHTMLCell(0, 0, '', '', $msg, 0, 1, 0, true, '', true);

        $filename = 'Quotation-' . date('d-M-Y-H-i-s') . '.pdf';

        $newFile = $this->config->item('theme_path') . 'attachement/' . $filename;

        $pdf->Output($newFile, 'F');

        //echo "<pre>"; print_r($msg1); exit;

        $this->email->attach($this->config->item('theme_path') . 'attachement/' . $filename);

        $this->email->message('Dear Customer Name, <br> We Thank you for choosing us, Kindly find the attachment for Quotation Details <b>' . $data['quotation'][0]['q_no'] . '</b>'

                . 'Company Name - ' . $data['quotation'][0]['store_name'] . '<br>

                     Address - ' . $data['quotation'][0]['address1'] . ' <br>

                       PH - ' . $data['quotation'][0]['mobil_number'] . ' <br>

                        Email ID - ' . $data['quotation'][0]['email_id'] . ' <br><br><br><br>Thanks<br>');

        $this->email->send();

    }



    //get sub category

    function get_sub_category() {

        $c_id = $this->input->get('c_id');

        $p_data = $this->categories_model->get_all_s_cat_by_id($c_id);

        $select = '';

        $select = $select . "<select name='sub_categoty[]'><option value=''>Select</option>";

        if (isset($p_data) && !empty($p_data)) {

            foreach ($p_data as $val1) {

                $select = $select . "<option value=" . $val1['actionId'] . ">" . $val1['sub_categoryName'] . "</option>";

            }

        }



        $select = $select . "</select>";

        if (empty($p_data)) {

            $select = $select . "   <span style='color:red;'>Sub category not crerated yet...</span>";

        }

        echo $select;

    }



    function get_prefix_by_frim_id() {

        $input = $this->input->post();

        $arr = $this->gen_model->get_prefix_by_frim_id($input['firm_id']);

//        echo '<pre>';

//        print_r($arr);

//        die;

        echo json_encode($arr);

        exit;

    }



    function get_increment_id() {

        $input = $this->input->post();

        $arr = $this->increment_model->get_increment_id($input['type'], $input['code']);

        echo json_encode($arr);

        exit;

    }



    function get_reference_group_by_frim_id() {

        $input = $this->input->post();

        $arr = $this->gen_model->get_reference_group_by_frim_id($input['firm_id']);

        echo json_encode($arr);

        exit;

    }



    function get_sales_man_by_frim_id() {

        $input = $this->input->post();

        $arr = $this->gen_model->get_sales_man_by_frim_id($input['firm_id']);

        echo json_encode($arr);

        exit;

    }



    function send_notification() {

        $input = $this->input->post();

        if (isset($input) && !empty($input)) {

            $input['credit_limit'] = ($input['credit_limit'] != '') ? $input['credit_limit'] : '0';

            $notification = array();

            $notification['notification_date'] = date('Y-m-d');

            $notification['due_date'] = NULL;

            $notification['type'] = 'credit_limit_exceeded';

            $receiver_list = array(1, 2);

            $notification['receiver_id'] = json_encode($receiver_list);

            $notification['link'] = 'masters/customers/edit_customer/' . $input['cust_id'];

            $notification['Message'] = 'Quotation Amount Exceeded to Rs. ' . $input['exceed_total'] . ' and the Original Limit is Rs. ' . $input['credit_limit'];

            $this->notification_model->insert_notification($notification);

            echo "sent";

            exit;

        }

    }



    function excel_report() {

        if (isset($_GET) && $_GET['search'] != '') {

            $search = $_GET['search'];

        } else {

            $search = '';

        }

        $json = json_decode($search);



        $po = $this->gen_model->get_all_quotation_for_report($search);



        $this->export_csv($po);

    }



    function export_csv($query, $timezones = array()) {



        // output headers so that the file is downloaded rather than displayed

        header('Content-Type: text/csv; charset=utf-8');

        header('Content-Disposition: attachment; filename=Quotation Report.csv');



        // create a file pointer connected to the output stream

        $output = fopen('php://output', 'w');



        // output the column headings

        //Order has been changes

        fputcsv($output, array('Quotation No', 'Customer Name', 'Total Quantity', 'Total Amount', 'Delivery Schedule', 'Created Date'));



        // fetch the data

        //$rows = mysql_query($query);

        // loop over the rows, outputting them

        foreach ($query as $val) {

            if ($val['delivery_schedule'] != '' && $val['delivery_schedule'] != '1970-01-01') {

                $val['delivery_schedule'] = date('d-M-Y', strtotime($val['delivery_schedule']));

            } else {

                $val['delivery_schedule'] = 'NA';

            }

            if ($val['created_date'] != '' && $val['created_date'] != '1970-01-01') {

                $val['created_date'] = date('d-M-Y', strtotime($val['created_date']));

            } else {

                $val['created_date'] = 'NA';

            }

            $row = array($val['q_no'], ($val['store_name']) ? $val['store_name'] : $val['name'], $val['total_qty'], $val['net_total'], $val['delivery_schedule'], $val['created_date']);

            fputcsv($output, $row);

        }

        exit;

    }



    function clear_cache() {

        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");

        $this->output->set_header("Pragma: no-cache");

    }



    function quotation_ajaxList() {

        $list = $this->gen_model->get_datatables();

//        echo '<pre>';

//        print_r($list);

//        exit;

        $data = array();



        $no = $_POST['start'];

        foreach ($list as $ass) {



            $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');



            $edit_url = $views_url = $delete_url = "";





            if ($this->user_auth->is_action_allowed('quotation', 'quotation', 'edit')) {

                $edit = $this->config->item('base_url') . 'quotation/quotation_edit/' . $ass['q_id'];

            }

            if ($this->user_auth->is_action_allowed('quotation', 'quotation', 'view')) {

                $view = $this->config->item('base_url') . 'quotation/quotation_view/' . $ass['q_id'];

            }

            if ($this->user_auth->is_action_allowed('quotation', 'quotation', 'delete')) {

                $delete = '#test3_' . $ass['q_id'];

            }

            if (!$this->user_auth->is_action_allowed('quotation', 'quotation', 'edit')) {

                $edit_alert = 'alerts';

            }

            if (!$this->user_auth->is_action_allowed('quotation', 'quotation', 'view')) {

                $view_alert = 'alerts';

            }

            if (!$this->user_auth->is_action_allowed('quotation', 'quotation', 'delete')) {

                $delete_alert = 'alerts';

            }



            $edit_url = '<a href="' . $edit . '"data-toggle="tooltip" class="tooltips btn btn-info btn-xs ' . $edit_alert . '" title="" data-original-title="Edit"><span class="fa fa-edit "></span></a>';

            $views_url = '<a href="' . $view . '" data-toggle="tooltip" class="tooltips btn btn-defaultback btn-xs ' . $view_alert . '" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>';

            $delete_url = '<a href="' . $delete . '" data-toggle="modal" id="yesin" name="delete" class="tooltips btn btn-danger btn-xs delete_yes' . $delete_alert . '" title="" data-original-title="In-Active" ><span class="fa fa-log-out "> <span class="fa fa-ban" hidin="' . $ass['q_id'] . '"></span> </span></a>';



//            if ($this->user_auth->is_action_allowed('quotation', 'quotation', 'delete')) {

//                $delete_url = '<a href="#test3_' . $ass->q_id . '" data-toggle="modal" id="yesin" name="delete" class="tooltips btn btn-danger btn-xs delete_yes" ><span class="fa fa-log-out"> <span class="fa fa-ban " hidin="' . $ass->q_id . '"></span>  </span></a>';

//            } else {

//                $delete_url = '<a href="#" data-toggle="tooltip" class="tooltips btn btn-danger btn-xs alerts" title="" ><span class="fa fa-log-out "> <span class="fa fa-ban"></span> </span></a>';

//            }



            $no++;

            $row = array();

            $row[] = $no;

            $row[] = $ass['q_no'];

            $row[] = $ass['store_name'];

            $row[] = $ass['total_qty'];

            $row[] = number_format($ass['net_total'], 2);

            $row[] = ($ass['delivery_schedule'] != '1970-01-01') ? date('d-M-Y', strtotime($ass['delivery_schedule'])) : '';

            $row[] = ($ass['notification_date'] != '1970-01-01') ? date('d-M-Y', strtotime($ass['notification_date'])) : '';

            $row[] = ($ass['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($ass['created_date'])) : '';

            if ($ass['estatus'] == 1) {

                $status = '<span class="badge bg-red">Pending</span>';

            } else if ($ass['estatus'] == 2) {

                $status = '<span class="badge bg-green">Completed</span>';

            } else if ($ass['estatus'] == 4) {

                $status = '<span class = "badge bg-green">Order Approved</span>';

            } else if ($ass['estatus'] == 5) {

                $status = '<span class = "badge bg-yellow">Order Reject</span>';

            }



            $row[] = $status;



            if ($ass['estatus'] == 2) {

                $row[] = $views_url;

            } else if (($user_info[0]['role'] != 3)) {

                $row[] = $edit_url . ' ' . $views_url . ' ' . $delete_url;

            }



            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->gen_model->count_all(),

            "recordsFiltered" => $this->gen_model->count_filtered(),

            "data" => $data,

        );

        echo json_encode($output);

        exit;

    }



}

