<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sales extends MX_Controller {

    function __construct() {

        parent::__construct();

        $this->clear_cache();

        if (!$this->user_auth->is_logged_in()) {

            redirect($this->config->item('base_url') . 'admin');
        }

        $main_module = 'sales';

        $access_arr = array(
            'sales/project_cost_list' => 'no_restriction',
            'sales/invoice_list' => 'no_restriction',
            'sales/index' => 'no_restriction',
            'sales/add_invoice' => 'no_restriction',
            'sales/quotation_view' => 'no_restriction',
            'sales/invoice_view' => 'no_restriction',
            'sales/invoice_views' => 'no_restriction',
            'sales/invoice_edit' => 'no_restriction',
            'sales/quotation_view' => 'no_restriction',
            'sales/quotation_edit' => 'no_restriction',
            'sales/new_quotation' => 'no_restriction',
            'sales/quotation_delete' => 'no_restriction',
            'sales/quotation_add' => 'no_restriction',
            'sales/invoice_add' => 'no_restriction',
            'sales/update_quotation' => 'no_restriction',
            'sales/update_project_cost' => 'no_restriction',
            'sales/update_invoice' => 'no_restriction',
            'sales/get_stock' => 'no_restriction',
            'sales/stock_details' => 'no_restriction',
            'sales/get_po' => 'no_restriction',
            'sales/change_status' => 'no_restriction',
            'sales/change_pc_status' => 'no_restriction',
            'sales/get_customer' => 'no_restriction',
            'sales/get_service' => 'no_restriction',
            'sales/get_customer_by_id' => 'no_restriction',
            'sales/stock_details' => 'no_restriction',
            'sales/get_product' => 'no_restriction',
            'sales/get_product_by_id' => 'no_restriction',
            'sales/delete_id' => 'no_restriction',
            'sales/delete_pc_id' => 'no_restriction',
            'sales/send_email' => 'no_restriction',
            'sales/approve_invoice' => 'no_restriction',
            'sales/get_all_products' => 'no_restriction',
            'sales/todays_sales' => 'no_restriction',
            'sales/excel_report' => 'no_restriction',
            'sales/excel_report_invoice' => 'no_restriction',
            'sales/invoice_pdf' => 'no_restriction',
            'sales/customer_invoice_pdf' => 'no_restriction',
            'sales/invoice_ajaxList' => 'no_restriction',
            'sales/new_direct_invoice' => 'no_restriction',
            'sales/convert_number' => 'no_restriction',
            'sales/clear_cache' => 'no_restriction',
            'sales/invoice_delete' => 'no_restriction',
            'sales/ajaxList' => 'no_restriction',
            'sales/get_product_cost' => 'no_restriction',
            'sales/invoice_duplicate_details' => 'no_restriction',
            'sales/check_ime_qty' => 'no_restriction',
            'sales/get_ime_code_from_productqty' => 'no_restriction',
            'sales/get_customer_by_firm' => 'no_restriction',
            ''
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {

            redirect($this->config->item('base_url'));
        }

        $this->load->model('masters/categories_model');

        $this->load->model('masters/brand_model');

        $this->load->model('masters/customer_model');

        $this->load->model('master_style/master_model');

        $this->load->model('masters/sales_man_model');

        $this->load->model('sales/project_cost_model');

        $this->load->model('enquiry/enquiry_model');

        $this->load->model('admin/admin_model');

        $this->load->model('api/increment_model');

        $this->load->model('api/notification_model');

        $this->load->model('quotation/gen_model');

        $this->load->model('sales_return/sales_return_model');

        $this->load->model('masters/product_model');

        $this->load->model('masters/reference_groups_model');

        $this->load->model('masters/sms_model');

        if (isset($_GET['notification']))
            $this->notification_model->update_notification(array('status' => 1), $_GET['notification']);
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

                $int['type'] = 'debit';

                $amount = $int;

                $this->load->model('receipt/receipt_model');

                $insert_agent_cash = $this->receipt_model->insert_agent_amount($amount);
            }



            redirect($this->config->item('base_url') . 'sales/project_cost_list');
        }
    }

    public function add_invoice() {

        if ($this->input->post()) {

            $user_info = $this->user_auth->get_from_session('user_info');

            $input = $this->input->post();

            $data['company_details'] = $this->admin_model->get_company_details();

            $input['quotation']['notification_date'] = date('Y-m-d', strtotime($input['quotation']['notification_date']));

            $input['quotation']['delivery_schedule'] = date('Y-m-d', strtotime($input['quotation']['delivery_schedule']));

            $user_info = $this->user_auth->get_from_session('user_info');

            $input['quotation']['estatus'] = 2;

            $input['quotation']['created_by'] = $user_info[0]['id'];

            $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));

            unset($input['quotation']['q_id']);

            unset($input['quotation']['customer_po']);

            unset($input['quotation']['contract_customer']);

            unset($input['quotation']['credit_days']);

            unset($input['quotation']['credit_limit']);

            unset($input['quotation']['temp_credit_limit']);

            unset($input['quotation']['approved_by']);

            unset($input['quotation']['round_off']);

            unset($input['quotation']['transport']);

            unset($input['quotation']['labour']);

            unset($input['quotation']['delivery_status']);

            unset($input['quotation']['sales_man']);

            unset($input['quotation']['bill_type']);

            $arr = $this->gen_model->get_prefix_by_frim_id($input['quotation']['firm_id']);

            $arr1 = $this->increment_model->get_increment_id($arr[0]['prefix'], 'TT');

            $increment_id2 = explode("/", $arr1);

            $inv_id = 'INV-' . $arr[0]['prefix'] . '-' . $increment_id2[1] . '-' . $increment_id2[2];

            $final_id = $arr[0]['prefix'] . '-' . $increment_id2[1] . '' . $increment_id2[2];

            $input['quotation']['q_no'] = $final_id;

            $insert_id = $this->gen_model->insert_quotation($input['quotation']);

            $input = $this->input->post();

            $input['quotation']['q_id'] = $insert_id;

            $q_no = $final_id;

            $split = explode("-", $q_no);

            $code = 'TT';

            $this->increment_model->update_increment_id($split[0], $code);

            //$input = $this->input->post();

            unset($input['quotation']['q_no']);

            unset($input['quotation']['ref_name']);

            unset($input['quotation']['delivery_schedule']);

            unset($input['quotation']['mode_of_payment']);

            unset($input['quotation']['validity']);

            unset($input['quotation']['job_id']);

            unset($input['quotation']['notification_date']);

//$date = date('Y-m-d', strtotime($input['quotation']['warranty_from']));
//$new_date = date('Y-m-d', strtotime($input['quotation']['warranty_to']));

            $input['quotation']['invoice_status'] = 'approved';

            $contract_customer = $input['quotation']['contract_customer'];

            $data['company_details'] = $this->admin_model->get_company_details();

            $data['customer_details'] = $this->customer_model->get_customer1($input['quotation']['customer']);

            $input['quotation']['created_by'] = $user_info[0]['id'];

            $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));

            $input['quotation']['credit_due_date'] = date('Y-m-d', strtotime($input['quotation']['created_date'] . "+" . $data['customer_details'][0]['credit_days'] . " days"));

            $ref_amount = $this->project_cost_model->get_reference_amount($input['quotation']['ref_name']);

            $input['quotation']['commission_rate'] = ($input['quotation']['net_total'] / 100 ) * $ref_amount;

            if ($input['quotation']['credit_days'] == '') {

                $input['quotation']['credit_days'] = NULL;
            }if ($input['quotation']['credit_limit'] == '') {

                $input['quotation']['credit_limit'] = NULL;
            }if ($input['quotation']['temp_credit_limit'] == '') {

                $input['quotation']['temp_credit_limit'] = NULL;
            }if ($input['quotation']['approved_by'] == '') {

                $input['quotation']['approved_by'] = NULL;
            }

//            if (isset($input['cus_type']) && !empty($input['cus_type']) && ($input['cus_type'] == 5 || $input['cus_type'] == 6) && $user_info[0]['role'] != 1) {
//                $input['quotation']['invoice_status'] = 'waiting';
//            }

            if ($input['quotation']['delivery_status'] == 'delivered') {

                $input['quotation']['delivery_qty'] = $input['quotation']['total_qty'];
            }

            $input['quotation']['inv_id'] = $inv_id;

            $insert_id = $this->project_cost_model->insert_invoice($input['quotation']);

            unset($input['quotation']['round_off']);

            unset($input['quotation']['transport']);

            unset($input['quotation']['labour']);

            if (isset($input['cus_type']) && !empty($input['cus_type']) && ($input['cus_type'] == 5 || $input['cus_type'] == 6) && $user_info[0]['role'] != 1) {

//                $receiver_list = array(1);
//                $notification = array();
//                $notification['notification_date'] = date('d-M-Y');
//                $notification['type'] = 'invoice';
//                $notification['receiver_id'] = json_encode($receiver_list);
//                $notification['link'] = 'sales/invoice_view/' . $insert_id;
//                $notification['Message'] = 'New invoice is created by the customer T5/T6, is waiting for your approval.';
//                $this->notification_model->insert_notification($notification);
            }

            $customer = array();

            $customer['temp_credit_limit'] = NULL;

            $this->customer_model->update_customer($customer, $input['quotation']['customer']);

            unset($input['quotation']['invoice_status']);

            unset($input['quotation']['delivery_status']);

            unset($input['quotation']['contract_customer']);

            unset($input['quotation']['ref_name']);

            unset($input['quotation']['commission_rate']);

            unset($input['quotation']['credit_due_date']);

            unset($input['quotation']['credit_days']);

            unset($input['quotation']['credit_limit']);

            unset($input['quotation']['temp_credit_limit']);

            unset($input['quotation']['approved_by']);

            unset($input['quotation']['sales_man']);

            unset($input['quotation']['delivery_qty']);

            $input['quotation']['invoice_id'] = $insert_id;

            $input['quotation']['inv_id'] = $inv_id;

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

                        $insert['unit'] = $input['unit'][$key];

                        $insert['quantity'] = $input['quantity'][$key];

                        if ($input['quotation']['delivery_status'] == 'delivered') {

                            $insert['delivery_quantity'] = $input['quantity'][$key];
                        }

                        $insert['per_cost'] = $input['per_cost'][$key];

                        $insert['tax'] = $input['tax'][$key];

                        $insert['gst'] = $input['gst'][$key];

                        $insert['igst'] = $input['igst'][$key];

                        $insert['discount'] = $input['discount'][$key];

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

                $sms = $this->sms_model->send_sms($insert_id, 'invoice');
            }





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

                        $igst = (($input['igst'][$key] / 100) * $inp['per_cost']);

                        $dis = (($input['discount'][$key] / 100) * $inp['per_cost']);

                        $inp['sub_total'] = ((($inp['per_cost'] * $input['quantity'][$key]) + ($tax * $input['quantity'][$key]) + ($igst * $input['quantity'][$key]) + ($gst * $input['quantity'][$key])) - ($dis * $input['quantity'][$key]));

                        $net_total += $inp['sub_total'];
                    } else if ($cust_type == 2) {

                        $inp['per_cost'] = $this->project_cost_model->get_product_credit_selling_price($val);

                        $tax = (($input['tax'][$key] / 100) * $inp['per_cost']);

                        $gst = (($input['gst'][$key] / 100) * $inp['per_cost']);

                        $igst = (($input['igst'][$key] / 100) * $inp['per_cost']);

                        $dis = (($input['discount'][$key] / 100) * $inp['per_cost']);

                        $inp['sub_total'] = ((($inp['per_cost'] * $input['quantity'][$key]) + ($tax * $input['quantity'][$key]) + ($igst * $input['quantity'][$key]) + ($gst * $input['quantity'][$key])) - ($dis * $input['quantity'][$key]));

                        $net_total += $inp['sub_total'];
                    }

                    $input['new_sub_total'][] = $inp['sub_total'];

                    $input['new_per_cost'][] = $inp['per_cost'];
                }



                $input['quotation']['subtotal_qty'] = $net_total;

                $input['quotation']['net_total'] = $net_total + $input['quotation']['tax'];

//$date = date('Y-m-d', strtotime($input['quotation']['warranty_from']));
//$new_date = date('Y-m-d', strtotime($input['quotation']['warranty_to']));
//$input['quotation']['warranty_from'] = $date;
//$input['quotation']['warranty_to'] = $new_date;

                $input['quotation']['customer'] = $contract_customer;

                $last_id = $this->master_model->get_last_id('inv_code');

                $input['quotation']['inv_id'] = $last_id[0]['value'];

                $data['company_details'] = $this->admin_model->get_company_details();

                $user_info = $this->user_auth->get_from_session('user_info');

                $input['quotation']['created_by'] = $user_info[0]['id'];

                $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));

                $ref_amount = $this->project_cost_model->get_reference_amount($input['quotation']['ref_name']);

                $input['quotation']['commission_rate'] = ($input['quotation']['net_total'] / 100 ) * $ref_amount;

// echo "<pre>";print_r($new); print_r($input); exit;

                $insert_id = $this->project_cost_model->insert_invoice($input['quotation']);

//unset($input['quotation']['contract_customer']);
//$this->sales_return_model->insert_sr($input['quotation']);

                if (isset($insert_id) && !empty($insert_id)) {



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

                            $insert['unit'] = $input['unit'][$key];

                            $insert['quantity'] = $input['quantity'][$key];

                            $insert['per_cost'] = $input['new_per_cost'][$key];

                            $insert['tax'] = $input['tax'][$key];

                            $insert['gst'] = $input['gst'][$key];

                            $insert['igst'] = $input['igst'][$key];

                            $insert['discount'] = $input['discount'][$key];

                            $insert['sub_total'] = $input['new_sub_total'][$key];

                            $insert['created_date'] = date('Y-m-d H:i');

                            $insert_arr[] = $insert;
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
            }

            $file_name = base_url() . 'sales/invoice_pdf/' . $insert_id;

            $redirect_url = base_url() . 'sales/invoice_list';

            echo "<script>window.open('$file_name')</script>";

            echo "<script>window.location.href = '$redirect_url';</script>";
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

        if ($datas["quotation"][0]['net_total'] != '')
            $datas["in_words"] = $this->convert_number($datas["quotation"][0]['net_total']);

        $datas["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_pc_details_by_id($id);



        $datas["category"] = $category = $this->categories_model->get_all_category();

// $datas['company_details'] = $this->admin_model->get_company_details();

        $datas['company_details'] = $this->project_cost_model->get_company_details_by_firms($id);

        $datas["brand"] = $brand = $this->brand_model->get_brand();

        $this->template->write_view('content', 'project_cost_view', $datas);

        $this->template->render();
    }

    public function quotation_edit($id) {

        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_pc_by_id($id);

        $datas["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_pc_details_by_id($id);

        $datas['firms'] = $firms = $this->user_auth->get_user_firms();

//$datas["nick_name"] = $this->gen_model->get_all_nick_name();

        $firms = $this->user_auth->get_user_firms();

        $datas["nick_name"] = $this->gen_model->get_reference_group_by_frim_id($firms[0]['firm_id']);

        $datas["category"] = $category = $this->categories_model->get_all_category();

        $datas['company_details'] = $this->admin_model->get_company_details();

        $datas["brand"] = $brand = $this->brand_model->get_brand();

        $datas["products"] = $this->gen_model->get_all_product();

        $datas["customers"] = $this->gen_model->get_all_customers();

        $this->template->write_view('content', 'project_cost_edit', $datas);



        $this->template->render();
    }

    public function invoice_view($id) {

        $id = 3892;

        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_invoice_by_id($id);

        $datas["in_words"] = $this->convert_number($datas["quotation"][0]['net_total']);

        $datas["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_invoice_details_by_id($id);

        $datas["category"] = $category = $this->categories_model->get_all_category();

//  $datas['company_details'] = $this->admin_model->get_company_details();

        $datas["brand"] = $brand = $this->brand_model->get_brand();

        $datas["user_info"] = $this->user_auth->get_from_session('user_info');

        $datas['company_details'] = $this->project_cost_model->get_company_details_by_firm($id);



        $this->template->write_view('content', 'invoice_view', $datas);

        $this->template->render();
    }

    public function invoice_views($id) {

        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_invoice_by_id($id);

        $datas["in_words"] = $this->convert_number($datas["quotation"][0]['net_total']);

        $datas["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_invoice_details_by_id($id);

        $datas["category"] = $category = $this->categories_model->get_all_category();

        $datas['company_details'] = $this->admin_model->get_company_details();

        $datas["brand"] = $brand = $this->brand_model->get_brand();

        $datas["user_info"] = $this->user_auth->get_from_session('user_info');

        $datas['company_details'] = $this->project_cost_model->get_company_details_by_firm($id);

        // $datas['ime_code_details']=$this->project_cost_model->get_sales_ime_details($id);
        //  echo "<pre>";print_r($datas);exit;

        $this->template->write_view('content', 'invoice_views', $datas);

        $this->template->render();
    }

    public function change_status($id, $status) {

        $this->project_cost_model->change_quotation_status($id, $status);

        redirect($this->config->item('base_url') . 'sales/project_cost_list');
    }

    public function change_pc_status($id, $status) {

        $this->project_cost_model->change_pc_status($id, $status);

        redirect($this->config->item('base_url') . 'sales/project_cost_list');
    }

    public function project_cost_list() {



        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_quotation();

        $datas['company_details'] = $this->admin_model->get_company_details();

        $this->template->write_view('content', 'sales/project_cost_list', $datas);

        $this->template->render();
    }

    function ajaxList() {



        $search_data = $this->input->post();



        $search_arr = array();



        if (empty($search_arr)) {

            $search_arr = array();
        }



        $list = $this->project_cost_model->get_order_datatables($search_arr);

        $data = array();

        $no = $_POST['start'];

        foreach ($list as $val) {

            $url1 = $url2 = $url3 = $edit_url = $add_url = $views_url = "";

            $status = "";

            if ($val['estatus'] == 1) {

                $status = ' <span class=" badge bg-red">Pending</span>';
            }

            if ($val['estatus'] == 2) {

                $status = '<span class=" badge bg-green">Completed</span>';
            }

            if ($this->user_auth->is_action_allowed('sales', 'sales', 'edit')) {

                $url1 = $this->config->item('base_url') . 'sales/quotation_edit/' . $val['id'];
            }

            if (!$this->user_auth->is_action_allowed('sales', 'sales', 'edit')) {

                $alert1 = 'alerts';
            }

            if ($this->user_auth->is_action_allowed('sales', 'sales', 'add')) {

                $url2 = $this->config->item('base_url') . 'sales/invoice_add/?s=' . $val['id'];
            }

            if (!$this->user_auth->is_action_allowed('sales', 'sales', 'add')) {

                $alert2 = 'alerts';
            }

            if ($this->user_auth->is_action_allowed('sales', 'sales', 'view')) {

                $url3 = $this->config->item('base_url') . 'sales/quotation_view/' . $val['id'];
            }

            if (!$this->user_auth->is_action_allowed('sales', 'sales', 'view')) {

                $alert3 = 'alerts';
            }

            if ($val['estatus'] != 2)
                $edit_url = '<a href="' . $url1 . '" data-toggle="tooltip" class="tooltips btn btn-default  btn-xs ' . $alert1 . '" title="" data-original-title="View"><span class="fa fa-edit"></span></a>';

            if ($val['estatus'] == 2)
                $add_url = '<a href="' . $url2 . '" data-toggle="tooltip" class="tooltips btn btn-default  btn-xs ' . $alert2 . '" title="" data-original-title="Make Invoice"><span>Make Invoice</span></a>';

            $views_url = '<a href="' . $url3 . '" data-toggle="tooltip" class="tooltips btn btn-default  btn-xs ' . $alert2 . '" title="" data-original-title="View"><span class="fa fa-log-out "> <span class="fa fa-eye"></span> </span></a>';



            $no++;

            $row = array();

            $row[] = $no;

//$row[] = $ass->firm_name;

            $row[] = $val['job_id'];

            $row[] = $val['store_name'];

            $row[] = number_format($val['net_total'], 2);

            $row[] = $status;

            $row[] = $edit_url . ' ' . $add_url . ' ' . $views_url;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->project_cost_model->count_all_order(),
            "recordsFiltered" => $this->project_cost_model->count_filtered_order(),
            "data" => $data,
        );



        echo json_encode($output);

        exit;
    }

    public function invoice_list() {

        $datas = array();

// $datas["quotation"] = $quotation = $this->project_cost_model->get_invoice();
//$datas["quotation"] = $quotation = $this->project_cost_model->get_all_completed_quotation();  --- already in commandline

        $datas['sales'] = $this->project_cost_model->get_all_sales_id();

// $datas['company_details'] = $this->admin_model->get_company_details();

        $this->template->write_view('content', 'sales/invoice_list', $datas);

        $this->template->render();
    }

    public function invoice_edit($id) {

        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_invoice_by_id($id);

        $datas['quotation_details'] = $this->project_cost_model->get_all_invoice_details_by_id($id);

        //echo "<pre>";print_r($datas);exit;

        $datas['company_details'] = $this->admin_model->get_company_details();

        $datas["brand"] = $brand = $this->brand_model->get_brand();

        $datas["products"] = $this->gen_model->get_all_product();

        $datas["customers"] = $this->gen_model->get_all_customers();

        $datas["user_info"] = $this->user_auth->get_from_session('user_info');

        $datas["sales_man"] = $this->sales_man_model->get_sales_man();

        $this->template->write_view('content', 'sales/invoice_edit', $datas);

        $this->template->render();
    }

    public function get_customer($id) {

        $atten_inputs = $this->input->get();

        $data = $this->project_cost_model->get_customer($atten_inputs, $id);

        echo '<ul id="country-list">';

        if (isset($data) && !empty($data)) {

            foreach ($data as $st_rlno) {

                if ($st_rlno['name'] != '')
                    echo '<li class="cust_class" cust_name="' . $st_rlno['name'] . '" cust_id="' . $st_rlno['id'] . '" cust_no="' . $st_rlno['mobil_number'] . '" cust_email="' . $st_rlno['email_id'] . '" cust_address="' . $st_rlno['address1'] . '" cust_tin="' . $st_rlno['tin'] . '">' . $st_rlno['name'] . '</li>';
            }
        }

        else {

            echo '<li style="color:red;">No Data Found</li>';
        }

        echo '</ul>';
    }

    public function get_service($id) {

        $atten_inputs = $this->input->get();

        $product_data = $this->project_cost_model->get_service($atten_inputs, $id);



        echo '<ul id="service-list">';

        if (isset($product_data) && !empty($product_data)) {

            foreach ($product_data as $st_rlno) {

                if ($st_rlno['model_no'] != '')
                    echo '<li class="ser_class" ser_sell="' . $st_rlno['cost_price'] . '" ser_type="' . $st_rlno['type'] . '" ser_id="' . $st_rlno['id'] . '" ser_no="' . $st_rlno['model_no'] . '" ser_name="' . $st_rlno['product_name'] . '" ser_description="' . $st_rlno['product_description'] . '" ser_image="' . $st_rlno['product_image'] . '" ser_cgst="' . $st_rlno['cgst'] . '"ser_sgst ="' . $st_rlno['sgst'] . '"ser_cat ="' . $st_rlno['category_id'] . '">' . $st_rlno['model_no'] . '</li>';
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

    public function get_product($id) {

        $atten_inputs = $this->input->get();

        $product_data = $this->project_cost_model->get_product($atten_inputs, $id);



        echo '<ul id="product-list">';

        if (isset($product_data) && !empty($product_data)) {

            foreach ($product_data as $st_rlno) {

                if ($st_rlno['product_name'] != '')
                    echo '<li class="pro_class" pro_cost="' . $st_rlno['cost_price'] . '" pro_id="' . $st_rlno['id'] . '" mod_no="' . $st_rlno['model_no'] . '" pro_name="' . $st_rlno['product_name'] . '" pro_description="' . $st_rlno['product_description'] . '" pro_image="' . $st_rlno['product_image'] . '" pro_cgst="' . $st_rlno['cgst'] . '"pro_sgst ="' . $st_rlno['sgst'] . '"pro_cat ="' . $st_rlno['category_id'] . '">' . $st_rlno['product_name'] . '</li>';
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

//        echo "<pre>";
//        echo $id;
//        print_r($datas["quotation_details"]);
//        exit;

        $datas["category"] = $category = $this->categories_model->get_all_category();

        $datas['company_details'] = $this->admin_model->get_company_details();

        $datas["brand"] = $brand = $this->brand_model->get_brand();

        $datas["customer"] = $this->project_cost_model->get_customers();

// $datas["last_id"]=$this->master_model->get_last_id('job_code');

        $datas["products"] = $this->gen_model->get_all_product();

        $this->template->write_view('content', 'project_cost_add', $datas);

        $this->template->render();
    }

    public function invoice_add($q_id) {



        if (isset($_GET) && ($_GET['s'] != '')) {

            $datas["quotation"] = $quotation = $this->project_cost_model->get_all_project_cost_by_id($_GET['s']);

            $datas["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_sales_details_by_id($_GET['s']);
        } else {

            $datas["quotation"] = $quotation = $this->project_cost_model->get_all_quotation_by_id($q_id);

            $datas["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_project_details_by_id($q_id);
        }

//        echo '<pre>';
//        print_r($datas);
//        die;

        $datas["customer"] = $this->project_cost_model->get_customers();

        $datas["category"] = $category = $this->categories_model->get_all_category();

        $datas['company_details'] = $this->admin_model->get_company_details();

        $datas["brand"] = $brand = $this->brand_model->get_brand();

        $datas["sales_man"] = $this->sales_man_model->get_sales_man();

        $datas["last_id"] = $this->master_model->get_last_id('inv_code');

        $datas["products"] = $this->gen_model->get_all_product();

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

            $this->project_cost_model->insert_quotation_details($insert_arr);
        }



        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_quotation();

        redirect($this->config->item('base_url') . 'sales/project_cost_list');
    }

    public function quotation_delete() {

        $id = $this->input->POST('value1');

        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_quotation();

        $del_id = $this->project_cost_model->delete_quotation($id);

        redirect($this->config->item('base_url') . 'sales/project_cost_list');
    }

    public function approve_invoice() {

        $id = $this->input->POST('id');

        if ($id != '') {

            $approve = $this->project_cost_model->approve_invoice($id);

            if ($approve) {

                echo 'success';

                exit;
            }
        }
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

// $to_array = array($data['company_details'][0]['email'], $data['quotation'][0]['email_id']);

        $to_array = array($data['quotation'][0]['email_id']);

        $this->email->clear(TRUE);

        $this->email->to(implode(', ', $to_array));

        $this->email->from($data['email_details'][1]['value'], $data['email_details'][0]['value']);

// $this->email->to($data['company_details'][0]['email'],$data['quotation'][0]['email_id']);

        $this->email->cc($data['email_details'][3]['value']);

        $this->email->subject($data['email_details'][2]['value']);

        $this->email->set_mailtype("html");

        $msg1['test'] = $this->load->view('sales/email_page', $data, TRUE);

//$msg1['company_details']=$data['company_details'];

        $header = $this->load->view('quotation/pdf_header_view', $data, TRUE);

        $msg = $this->load->view('sales/pdf_email_template', $msg1, TRUE);

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



        $pdf->AddPage();

        $pdf->Header($header);

        $pdf->writeHTMLCell(0, 0, '', '', $msg, 0, 1, 0, true, '', true);

        $filename = 'Invoice-' . date('d-M-Y-H-i-s') . '.pdf';

        $newFile = $this->config->item('theme_path') . 'attachement/' . $filename;

        $pdf->Output($newFile, 'F');

//echo "<pre>"; print_r($data); exit;

        $this->email->attach($this->config->item('theme_path') . 'attachement/' . $filename);

        $this->email->message('Dear ' . $data['quotation'][0]['name'] . ',<br> We Thank you for choosing us, Kindly find the attachment for Invoice Details <b>' . $data['quotation'][0]['inv_id'] . '</b><br>'
                . 'Company Name - ' . $data['quotation'][0]['store_name'] . '<br>

                       Address - ' . $data['quotation'][0]['address1'] . ' <br>

                        PH - ' . $data['quotation'][0]['mobil_number'] . ' <br>

                        Email ID - ' . $data['quotation'][0]['email_id'] . ' <br><br><br>Thanks<br>');

        $this->email->send();
    }

    public function update_new_direct_invoice($input, $id) {

        //if ($this->input->post())
        {

            //$input = $this->input->post();

            $input = $input;

            $input['pc_id'] = $id;
//echo "<pre>";print_r($input);exit;

            $data['company_details'] = $this->admin_model->get_company_details();

            $user_info = $this->user_auth->get_from_session('user_info');

            $input['quotation']['created_by'] = $user_info[0]['id'];


            if ($input['quotation']['delivery_status'] == 'delivered') {

                $input['quotation']['delivery_qty'] = $input['quotation']['total_qty'];
            }


            $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));

//unset($input['quotation']['q_no']);

            unset($input['quotation']['ref_name']);

            unset($input['quotation']['delivery_schedule']);

            unset($input['quotation']['mode_of_payment']);

            unset($input['quotation']['validity']);

            unset($input['quotation']['q_no']);

            unset($input['quotation']['notification_date']);

            $this->db->select('inv_id,q_id');
            $this->db->where('id', $input['pc_id']);
            $inv_details = $this->db->get('erp_invoice')->result_array();

            $input['quotation']['inv_id'] = $inv_details[0]['inv_id'];
            $input['quotation']['q_id'] = $inv_details[0]['q_id'];


//unset($input['quotation']['inv_id']);


            $insert_id = $this->project_cost_model->update_invoice($input['quotation'], $input['pc_id']);

            $delete_id = $this->project_cost_model->delete_inv_by_id($input['pc_id']);

            if (isset($input['categoty']) && !empty($input['categoty'])) {

                $insert_arr = array();

                foreach ($input['categoty'] as $key => $val) {

                    $insert['q_id'] = $input['quotation']['q_id'];

                    $insert['in_id'] = $input['pc_id'];

                    $insert['category'] = $val;

                    $insert['product_id'] = $input['product_id'][$key];

                    $insert['product_description'] = $input['product_description'][$key];

                    $insert['product_type'] = 1;

                    $insert['brand'] = $input['brand'][$key];

                    $insert['unit'] = $input['unit'][$key];

                    $insert['quantity'] = $input['quantity'][$key];

                    $insert['per_cost'] = $input['per_cost'][$key];
                    $insert['sp_with_gst'] = $input['sp_with_gst'][$key];
                     $insert['sp_without_gst'] = $input['sp_without_gst'][$key];
                    $insert['tax'] = $input['tax'][$key];

                    $insert['gst'] = $input['gst'][$key];

                    $insert['igst'] = $input['igst'][$key];

                    $insert['discount'] = $input['discount'][$key];

                    $insert['sub_total'] = $input['sub_total'][$key];

                    if ($input['quotation']['delivery_status'] == 'delivered') {

                        $insert['delivery_quantity'] = $input['quantity'][$key];
                    }


                    $insert['created_date'] = date('Y-m-d H:i');

                    $insert_arr[] = $insert;

                    $insert_details_id = $this->project_cost_model->insert_invoicedetails($insert);

                    $update_data = [
                        "sales_id" => $input['pc_id'],
                        "sales_details_id" => $insert_details_id,
                    ];

                    if ($input['ime_code_val'] != "")
                        $this->project_cost_model->update_ime_status($input['product_id'][$key], $input['ime_code_val'][$key], $input['quantity'][$key], $update_data);
                }


                // $this->project_cost_model->insert_invoice_details($insert_arr);
            }

            if (isset($input['item_name']) && !empty($input['item_name'])) {

                $insert_arrs = array();

                foreach ($input['item_name'] as $key => $val) {

                    $inserts['item_name'] = $val;

                    $inserts['amount'] = $input['amount'][$key];

                    $inserts['type'] = $input['type'][$key];

                    $insert_arrs[] = $inserts;
                }

                $this->project_cost_model->update_other_cost($insert_arrs, $input['pc_id']);
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

                $int['type'] = 'debit';

                $amount = $int;

                $this->load->model('receipt/receipt_model');

                $insert_agent_cash = $this->receipt_model->update_agent_amount($amount, $input['quotation']['job_id']);
            }

            return $receipt;

            // redirect($this->config->item('base_url') . 'sales/invoice_list');
        }
    }

    public function new_direct_invoice() {

        if ($this->input->post()) {

            $input = $this->input->post();

            $net_total = $input['quotation']['net_total'];

            $data['company_details'] = $this->admin_model->get_company_details();

            $input['quotation']['notification_date'] = date('Y-m-d', strtotime($input['quotation']['notification_date']));

            $input['quotation']['delivery_schedule'] = date('Y-m-d', strtotime($input['quotation']['delivery_schedule']));

            $user_info = $this->user_auth->get_from_session('user_info');

            $input['quotation']['estatus'] = 2;

            $input['quotation']['created_by'] = $user_info[0]['id'];

            $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));

            unset($input['quotation']['round_off']);

            unset($input['quotation']['transport']);

            unset($input['quotation']['labour']);

            unset($input['quotation']['delivery_status']);

            unset($input['quotation']['sales_man']);

            unset($input['quotation']['bill_type']);

            $arr = $this->gen_model->get_prefix_by_frim_id($input['quotation']['firm_id']);

            $arr1 = $this->increment_model->get_increment_id($arr[0]['prefix'], 'TT');

            $increment_id2 = explode("/", $arr1);

            $inv_id = 'INV-' . $arr[0]['prefix'] . '-' . $increment_id2[1] . '-' . $increment_id2[2];

            $final_id = $arr[0]['prefix'] . '-' . $increment_id2[1] . '' . $increment_id2[2];

            $input['quotation']['q_no'] = $final_id;

            $insert_id = $this->gen_model->insert_quotation($input['quotation']);

            $input = $this->input->post();

            $input['quotation']['q_id'] = $insert_id;

            $q_no = $final_id;

            $split = explode("-", $q_no);

            $code = 'TT';

            $this->increment_model->update_increment_id($split[0], $code);

            unset($input['quotation']['q_no']);

            unset($input['quotation']['ref_name']);

            unset($input['quotation']['delivery_schedule']);

            unset($input['quotation']['mode_of_payment']);

            unset($input['quotation']['validity']);

            unset($input['quotation']['job_id']);

            unset($input['quotation']['notification_date']);



// new invoice

            $input['quotation']['invoice_status'] = 'approved';

//$input['quotation']['delivery_status'] = 'pending';

            $data['company_details'] = $this->admin_model->get_company_details();

            $data['customer_details'] = $customer_details = $this->customer_model->get_customer1($input['quotation']['customer']);

            $advance_amt = $this->input->post('advance');

            //echo $advance_amt;
            //print_r($data['customer_details']);
            //exit;
//$contract_customer = $input['quotation']['contract_customer'];

            $input['quotation']['created_by'] = $user_info[0]['id'];

            $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));

            $input['quotation']['credit_due_date'] = date('Y-m-d', strtotime($input['quotation']['created_date'] . "+" . $data['customer_details'][0]['credit_days'] . " days"));

            $ref_amount = $this->project_cost_model->get_reference_amount($input['quotation']['ref_name']);

            $input['quotation']['commission_rate'] = ($input['quotation']['net_total'] / 100 ) * $ref_amount;

            if ($input['quotation']['credit_days'] == '') {

                $input['quotation']['credit_days'] = NULL;
            }if ($input['quotation']['credit_limit'] == '') {

                $input['quotation']['credit_limit'] = NULL;
            }if ($input['quotation']['temp_credit_limit'] == '') {

                $input['quotation']['temp_credit_limit'] = NULL;
            }if ($input['quotation']['approved_by'] == '') {

                $input['quotation']['approved_by'] = NULL;
            }

            if ($input['quotation']['approved_by'] == '') {

// $input['quotation']['approved_by'] = NULL;
            }



//            if (isset($input['cus_type']) && !empty($input['cus_type']) && ($input['cus_type'] == 5 || $input['cus_type'] == 6) && $user_info[0]['role'] != 1) {
//                $input['quotation']['invoice_status'] = 'waiting';
//            }

            if ($input['quotation']['delivery_status'] == 'delivered') {

                $input['quotation']['delivery_qty'] = $input['quotation']['total_qty'];
            }

            $input['quotation']['inv_id'] = $inv_id;

            $insert_id1 = $this->project_cost_model->insert_invoice($input['quotation']);

            $insert_invoice_id = $insert_id1;

            unset($input['quotation']['round_off']);

            unset($input['quotation']['transport']);

            unset($input['quotation']['labour']);

            if (isset($input['cus_type']) && !empty($input['cus_type']) && ($input['cus_type'] == 5 || $input['cus_type'] == 6) && $user_info[0]['role'] != 1) {

            }

            $customer = array();

            $customer['temp_credit_limit'] = NULL;
            $customer['tin'] = $input['customer']['tin'];


            $this->customer_model->update_customer($customer, $input['quotation']['customer']);

            unset($input['quotation']['invoice_status']);

            unset($input['quotation']['delivery_status']);

            unset($input['quotation']['contract_customer']);

            unset($input['quotation']['ref_name']);

            unset($input['quotation']['commission_rate']);

            unset($input['quotation']['credit_due_date']);

            unset($input['quotation']['credit_days']);

            unset($input['quotation']['credit_limit']);

            unset($input['quotation']['temp_credit_limit']);

            unset($input['quotation']['approved_by']);

            unset($input['quotation']['sales_man']);

            unset($input['quotation']['delivery_qty']);

            unset($input['quotation']['bill_type']);

            $input['quotation']['invoice_id'] = $insert_id1;

            $input['quotation']['inv_id'] = $inv_id;



            $this->sales_return_model->insert_sr($input['quotation']);



            if (isset($insert_id1) && !empty($insert_id1)) {

                $input = $this->input->post();



                if (isset($input['categoty']) && !empty($input['categoty'])) {

                    $insert_arr = array();

                    foreach ($input['categoty'] as $key => $val) {

                        $insert['in_id'] = $insert_id1;

                        $insert['q_id'] = $insert_id;

                        $insert['category'] = $val;

                        $insert['product_id'] = $input['product_id'][$key];

                        $insert['product_description'] = $input['product_description'][$key];

                        $insert['product_type'] = 1;

                        $insert['brand'] = $input['brand'][$key];

                        $insert['unit'] = $input['unit'][$key];

                        $insert['quantity'] = $input['quantity'][$key];

                        if ($input['quotation']['delivery_status'] == 'delivered') {

                            $insert['delivery_quantity'] = $input['quantity'][$key];
                        }

                        $insert['per_cost'] = $input['per_cost'][$key];
                        $insert['sp_with_gst'] = $input['sp_with_gst'][$key];
                        $insert['sp_without_gst'] = $input['sp_without_gst'][$key];
                        $insert['tax'] = $input['tax'][$key];

                        $insert['gst'] = $input['gst'][$key];

                        $insert['igst'] = $input['igst'][$key];



                        $insert['discount'] = (!empty($input['discount'][$key])) ? $input['discount'][$key] : '';

                        $insert['sub_total'] = $input['sub_total'][$key];

                        $insert['created_date'] = date('Y-m-d H:i');

                        $insert_arr[] = $insert;

                        $stock_arr = array();

                        $inv_id['inv_id'] = $input['quotation']['inv_id'];

                        $stock_arr[] = $inv_id;

                        $insert['firm'] = $input['quotation']['firm_id'];

                        $this->stock_details($insert, $inv_id);

//                        echo '<pre>';
//                        print_r($insert);
//                        print_r($inv_id);

                        unset($insert['firm']);
                    }//exit;

                    $this->project_cost_model->insert_invoice_details($insert_arr);

                    $this->project_cost_model->insert_invoice_product_details($insert_arr);
                }

                if (isset($input['item_name']) && !empty($input['item_name'])) {

                    $insert_arrs = array();

                    foreach ($input['item_name'] as $key => $val) {

                        $inserts['j_id'] = $insert_id1;

                        $inserts['item_name'] = $val;

                        $inserts['amount'] = $input['amount'][$key];

                        $inserts['type'] = $input['type'][$key];

                        $insert_arrs[] = $inserts;
                    }

                    $this->project_cost_model->insert_other_cost($insert_arrs);
                }

                $sms = $this->sms_model->send_sms($insert_id1, 'invoice');
            }

            $input_data = $this->input->post();

            $this->update_new_direct_invoice($input, $insert_invoice_id);

            $receipt_id = $insert_invoice_id;

            $receipt_num = $this->master_model->get_last_id('rp_code');



            $insert_data = [
                "receipt_id" => $receipt_id,
                "receipt_no" => $receipt_num[0]['value'],
                "terms" => $receipt_id,
                "bill_amount" => $input_data['quotation']['net_total'],
                "due_date" => ($input_data['quotation']['created_date']) ? date('Y-m-d', strtotime($input_data['quotation']['created_date'])) : '',
                "created_date" => ($input_data['quotation']['created_date']) ? date('Y-m-d', strtotime($input_data['quotation']['created_date'])) : '',
            ];


            $this->load->model('sales_receipt/sales_receipt_model');

            $receipt_status = 'Completed';

            $this->sales_receipt_model->update_invoice(array('payment_status' => $receipt_status), $receipt_id);

            $insert_id = $this->sales_receipt_model->insert_receipt_bill($insert_data);

            $insert_id++;

            $inc['type'] = 'rp_code';

            $inc['value'] = 'RECQ000' . $insert_id;

            $this->sales_receipt_model->update_increment($inc);




            if ($input['print'] == 'yes') {

                $file_name = base_url() . 'sales/invoice_views/' . $insert_id1;

                $file_name1 = base_url() . 'sales/invoice_pdf/' . $insert_id1;

                echo "<script>window.location.href = '$file_name';</script>";

                echo "<script>window.open('$file_name1');</script>";

                exit;
            } else {

                $redirect_url = base_url() . 'sales/invoice_list';

                echo "<script>window.location.href = '$redirect_url';</script>";

                exit;
            }
        }

        $data["category"] = $details = $this->categories_model->get_all_category();

        $data["brand"] = $this->brand_model->get_brand();

        $data["nick_name"] = $this->gen_model->get_all_nick_name();

        $data["ref_grps"] = $this->reference_groups_model->get_references();

        $data['company_details'] = $this->admin_model->get_company_details();

        $data['firms'] = $firms = $this->user_auth->get_user_firms();

        $data["sales_man"] = $this->sales_man_model->get_sales_man();

        $data["products"] = $this->gen_model->get_all_product();



        $firm_id = array_column($data['firms'], 'firm_id');



        $data["customers"] = $this->gen_model->get_all_customers($firm_id);



        $this->template->write_view('content', 'sales/new_direct_invoice', $data);

        $this->template->render();
    }

    public function get_product_cost() {



        if ($this->input->post()) {

            $input = $this->input->post();

            $product_data = $this->project_cost_model->get_product_cost_by_product($input);



            if ($input['cust_id'] != '') {

                $cus_type = $this->gen_model->get_customer_by_id($input['cust_id']);

                $i = 0;

                foreach ($product_data as $val) {



                    if ($cus_type[0]['customer_type'] == 1) {

                        $product_data[$val['id']]['selling_price'] = $product_data[$val['id']]['cash_cus_price'];
                    } else if ($cus_type[0]['customer_type'] == 2) {

                        $product_data[$val['id']]['selling_price'] = $product_data[$val['id']]['credit_cus_price'];
                    } else if ($cus_type[0]['customer_type'] == 3) {

                        $product_data[$val['id']]['selling_price'] = $product_data[$val['id']]['cash_con_price'];
                    } else if ($cus_type[0]['customer_type'] == 4) {

                        $product_data[$val['id']]['selling_price'] = $product_data[$val['id']]['credit_con_price'];
                    } else if ($cus_type[0]['customer_type'] == 5) {

                        $product_data[$val['id']]['selling_price'] = $product_data[$val['id']]['vip_price'];
                    } else if ($cus_type[0]['customer_type'] == 6) {

                        $product_data[$val['id']]['selling_price'] = $product_data[$val['id']]['vvip_price'];
                    } else if ($cus_type[0]['customer_type'] == 7) {

                        $product_data[$val['id']]['selling_price'] = $product_data[$val['id']]['h1_price'];
                    } else if ($cus_type[0]['customer_type'] == 8) {

                        $product_data[$val['id']]['selling_price'] = $product_data[$val['id']]['h2_price'];
                    }
                }
            }

            echo json_encode($product_data);

            exit;
        }
    }

    public function update_project_cost() {

        if ($this->input->post()) {

            $input = $this->input->post();

            $data['company_details'] = $this->admin_model->get_company_details();

            $user_info = $this->user_auth->get_from_session('user_info');

            $input['quotation']['created_by'] = $user_info[0]['id'];

            $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));

//unset($input['quotation']['q_no']);
//unset($input['quotation']['ref_name']);

            unset($input['quotation']['delivery_schedule']);

            unset($input['quotation']['mode_of_payment']);

            unset($input['quotation']['validity']);

//unset($input['quotation']['inv_id']);

            $insert_id = $this->project_cost_model->update_project_cost($input['quotation'], $input['pc_id']);

            $delete_id = $this->project_cost_model->delete_pc_by_id($input['pc_id']);

            if (isset($input['categoty']) && !empty($input['categoty'])) {

                $insert_arr = array();

                foreach ($input['categoty'] as $key => $val) {

                    $insert['j_id'] = $input['pc_id'];

                    $insert['category'] = $val;

                    $insert['product_id'] = $input['product_id'][$key];

                    $insert['product_description'] = $input['product_description'][$key];

                    $insert['product_type'] = 1;

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

                $this->project_cost_model->insert_quotation_details($insert_arr);
            }

            if (isset($input['item_name']) && !empty($input['item_name'])) {

                $insert_arrs = array();

                foreach ($input['item_name'] as $key => $val) {

                    $inserts['item_name'] = $val;

                    $inserts['amount'] = $input['amount'][$key];

                    $inserts['type'] = $input['type'][$key];

                    $insert_arrs[] = $inserts;
                }

                $this->project_cost_model->update_other_cost($insert_arrs, $input['pc_id']);
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

                $int['type'] = 'debit';

                $amount = $int;

                $this->load->model('receipt/receipt_model');

                $insert_agent_cash = $this->receipt_model->update_agent_amount($amount, $input['quotation']['job_id']);
            }



            redirect($this->config->item('base_url') . 'sales/project_cost_list');
        }
    }

    public function update_invoice() {

        if ($this->input->post()) {

            $input = $this->input->post();

            //Remove Old Product stock
            foreach ($input['old_product_id'] as $key => $results) {
                $qty = $input['old_product_qty'][$key];
                $firm_id = $input['old_firm_id'][$key];
                $cat_id = $input['old_cat_id'][$key];
                // echo $firm_id;echo "<br>";
                //  echo $qty;echo "<br>";
                //  echo $results;echo "<br>";
                $this->project_cost_model->remove_stocks_by_invdit($results, $qty, $firm_id, $cat_id);
            }


            $data['company_details'] = $this->admin_model->get_company_details();

            $user_info = $this->user_auth->get_from_session('user_info');

            $input['quotation']['created_by'] = $user_info[0]['id'];


            if ($input['quotation']['delivery_status'] == 'delivered') {

                $input['quotation']['delivery_qty'] = $input['quotation']['total_qty'];
            }


            $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));

//unset($input['quotation']['q_no']);

            unset($input['quotation']['ref_name']);

            unset($input['quotation']['delivery_schedule']);

            unset($input['quotation']['mode_of_payment']);

            unset($input['quotation']['validity']);
            // echo "<pre>";print_r($input);exit;
//unset($input['quotation']['inv_id']);

            $insert_id = $this->project_cost_model->update_invoice($input['quotation'], $input['pc_id']);

            $delete_id = $this->project_cost_model->delete_inv_by_id($input['pc_id']);

            if (isset($input['categoty']) && !empty($input['categoty'])) {

                $insert_arr = array();

                foreach ($input['categoty'] as $key => $val) {

                    $insert['q_id'] = $input['quotation']['q_id'];

                    $insert['in_id'] = $input['pc_id'];

                    $insert['category'] = $val;

                    $insert['product_id'] = $input['product_id'][$key];

                    $insert['product_description'] = $input['product_description'][$key];

                    $insert['product_type'] = 1;

                    $insert['brand'] = $input['brand'][$key];

                    $insert['unit'] = $input['unit'][$key];

                    $insert['quantity'] = $input['quantity'][$key];

                    $insert['per_cost'] = $input['per_cost'][$key];
                    $insert['sp_with_gst'] = $input['sp_with_gst'][$key];
                     $insert['sp_without_gst'] = $input['sp_without_gst'][$key];
                    $insert['tax'] = $input['tax'][$key];

                    $insert['gst'] = $input['gst'][$key];

                    $insert['igst'] = $input['igst'][$key];

                    $insert['discount'] = $input['discount'][$key];

                    $insert['sub_total'] = $input['sub_total'][$key];

                    if ($input['quotation']['delivery_status'] == 'delivered') {

                        $insert['delivery_quantity'] = $input['quantity'][$key];
                    }

                    $insert['created_date'] = date('Y-m-d H:i');

                    $insert_details_id = $this->project_cost_model->insert_invoicedetails($insert);


                    $insert_arr[] = $insert;

                    $customer['tin'] = $input['customer']['tin'];

                    $this->customer_model->update_customer($customer, $input['customer']['id']);


                    $this->project_cost_model->open_imeie($input['pc_id']);

                    $update_data = [
                        "sales_id" => $input['pc_id'],
                        "sales_details_id" => $insert_details_id,
                    ];

                    if ($input['ime_code_val'] != "")
                        $this->project_cost_model->update_ime_status($input['product_id'][$key], $input['ime_code_val'][$key], $input['quantity'][$key], $update_data);


                    $stock_arr = array();

                    $inv_id['inv_id'] = $input['quotation']['inv_id'];

                    $stock_arr[] = $inv_id;

                    $insert_data = $insert;

                    $insert_data['firm'] = $input['quotation']['firm_id'];

                    $this->stock_details($insert_data, $inv_id);
                }

                //$this->project_cost_model->insert_invoice_details($insert_arr);
            }


            $receipt_id = $insert_invoice_id;

            $receipt_num = $this->master_model->get_last_id('rp_code');



            $update_data = [
                "bill_amount" => $input_data['quotation']['net_total'],
                "created_date" => ($input_data['quotation']['created_date']) ? date('Y-m-d', strtotime($input_data['quotation']['created_date'])) : '',
            ];


            $this->load->model('sales_receipt/sales_receipt_model');

            $insert_id = $this->sales_receipt_model->update_bill_amount($input['pc_id'], $update_data);

            if (isset($input['item_name']) && !empty($input['item_name'])) {

                $insert_arrs = array();

                foreach ($input['item_name'] as $key => $val) {

                    $inserts['item_name'] = $val;

                    $inserts['amount'] = $input['amount'][$key];

                    $inserts['type'] = $input['type'][$key];

                    $insert_arrs[] = $inserts;
                }

                $this->project_cost_model->update_other_cost($insert_arrs, $input['pc_id']);
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

                $int['type'] = 'debit';

                $amount = $int;

                $this->load->model('receipt/receipt_model');

                $insert_agent_cash = $this->receipt_model->update_agent_amount($amount, $input['quotation']['job_id']);
            }



            redirect($this->config->item('base_url') . 'sales/invoice_list');
        }
    }

    public function new_quotation() {

        if ($this->input->post()) {

            $input = $this->input->post();

            $data['company_details'] = $this->admin_model->get_company_details();

            $user_info = $this->user_auth->get_from_session('user_info');

            $input['quotation']['created_by'] = $user_info[0]['id'];

            $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));

//unset($input['quotation']['q_no']);
//unset($input['quotation']['ref_name']);

            unset($input['quotation']['delivery_schedule']);

            unset($input['quotation']['mode_of_payment']);

            unset($input['quotation']['validity']);

//unset($input['quotation']['inv_id']);

            $insert_id = $this->project_cost_model->insert_quotation($input['quotation']);



            if (isset($insert_id) && !empty($insert_id)) {



                $input = $this->input->post();

                if (isset($input['categoty']) && !empty($input['categoty'])) {

                    $insert_arr = array();

                    foreach ($input['categoty'] as $key => $val) {

                        $insert['j_id'] = $insert_id;

//$insert['q_id'] = $input['quotation']['q_id'];

                        $insert['category'] = $val;

                        $insert['product_id'] = $input['product_id'][$key];

                        $insert['product_description'] = $input['product_description'][$key];

                        $insert['product_type'] = $input['type'][$key];

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

                $int['type'] = 'debit';

                $amount = $int;

                $this->load->model('receipt/receipt_model');

                $insert_agent_cash = $this->receipt_model->insert_agent_amount($amount);
            }

            if ($input['print'] == 'yes') {

                $file_name = base_url() . 'sales/quotation_view/' . $insert_id;

                echo "<script>window.location.href = '$file_name';</script>";

                exit;
            } else {

                $redirect_url = base_url() . 'sales/project_cost_list';

                echo "<script>window.location.href = '$redirect_url';</script>";

                exit;
            }



//redirect($this->config->item('base_url') . 'sales/project_cost_list');
        }

        $data["category"] = $details = $this->categories_model->get_all_category();

        $data["brand"] = $this->brand_model->get_brand();

        $data["nick_name"] = $this->gen_model->get_all_nick_name();

        $data["ref_grps"] = $this->reference_groups_model->get_references();

        $data['company_details'] = $this->admin_model->get_company_details();

        $data['firms'] = $firms = $this->user_auth->get_user_firms();

        $data["sales_man"] = $this->sales_man_model->get_sales_man();

        $data["products"] = $this->gen_model->get_all_product();

        $data["customers"] = $this->gen_model->get_all_customers();

        $this->template->write_view('content', 'sales/new_quotation', $data);



        $this->template->render();
    }

    public function todays_sales() {

        $total_sales = $this->project_cost_model->get_the_total_sales_count();

        print_r($total_sales);
    }

    public function check_ime_qty() {

        $bar_code = $this->input->post('barcode');
        $qty = $this->input->post('qty');
        $result = $this->project_cost_model->check_ime_qty($bar_code, $qty);

        echo $result;
    }

    public function get_ime_code_from_productqty() {
        $input = $this->input->post();

        $data = $this->project_cost_model->get_imecode_from_proqty($input);

        if ($data == 0) {
            echo 0;
        } else {
            echo json_encode($data);
        }
    }

    public function get_customer_by_firm() {
        $firm_id = $this->input->post('firm_id');

        $data = $this->project_cost_model->get_customer_by_firm($firm_id);


        echo json_encode($data);
    }

    function get_all_products() {

        $input = $this->input->post();

        //  $arr = $this->project_cost_model->get_all_products($input['barcode']);
        $arr = $this->project_cost_model->get_products_by_barcode($input['barcode']);

        if ($arr)
            $arr[0]['selling_price'] = $arr[0]['sales_price'];


        //echo "<pre>";print_r($arr);exit;
        // $cust_type = 'cost_price';

        /*  if ($input['cust_id'] != '' && !empty($arr)) {

          // $cus_type = $this->gen_model->get_customer_by_id($input['cust_id']);
          $arr[0]['selling_price']=$arr[0]['sales_price'];
          if ($cus_type[0]['customer_type'] == 1) {

          $arr[0]['selling_price'] = $arr[0]['cash_cus_price'];

          } else if ($cus_type[0]['customer_type'] == 2) {

          $arr[0]['selling_price'] = $arr[0]['credit_cus_price'];

          } else if ($cus_type[0]['customer_type'] == 3) {

          $arr[0]['selling_price'] = $arr[0]['cash_con_price'];

          } else if ($cus_type[0]['customer_type'] == 4) {

          $arr[0]['selling_price'] = $arr[0]['credit_con_price'];

          } else if ($cus_type[0]['customer_type'] == 5) {

          $arr[0]['selling_price'] = $arr[0]['vip_price'];

          } else if ($cus_type[0]['customer_type'] == 6) {

          $arr[0]['selling_price'] = $arr[0]['vvip_price'];

          } else if ($cus_type[0]['customer_type'] == 7) {

          $arr[0]['selling_price'] = $arr[0]['h1_price'];

          } else if ($cus_type[0]['customer_type'] == 8) {

          $arr[0]['selling_price'] = $arr[0]['h2_price'];

          }

          }
         */

        echo json_encode($arr);

        exit;

//echo $arr;
    }

    public function excel_report() {

        if (isset($_GET) && $_GET['search'] != '') {

            $search = $_GET['search'];
        } else {

            $search = '';
        }

        $json = json_decode($search);

        $po = $this->project_cost_model->get_all_project_cost_for_report($search);

        $this->export_csv($po);
    }

    public function excel_report_invoice() {

        if (isset($_GET) && $_GET['search'] != '') {

            $search = $_GET['search'];
        } else {

            $search = '';
        }



        $json = json_decode($search);

        $po = $this->project_cost_model->get_all_invoice_for_report($search);

        $this->export_csv($po);
    }

    function export_csv($query, $timezones = array()) {

        header('Content-Type: text/csv; charset=utf-8');

        header('Content-Disposition: attachment; filename=Sales Report.csv');

        $output = fopen('php://output', 'w');

        fputcsv($output, array('Sales Id', 'Customer Name', 'Total Quantity', 'Sub Total', 'Sales Cost Amount', 'Sales Cost Date'));

        foreach ($query as $val) {



            $row = array($val['job_id'], ($val['store_name']) ? $val['store_name'] : $val['name'], $val['total_qty'], number_format($val['subtotal_qty'], 2), number_format($val['net_total'], 2), ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '');

            fputcsv($output, $row);
        }

        exit;
    }

    public function invoice_pdf($inv_id) {

        $data["quotation"] = $quotation = $this->project_cost_model->get_all_invoice_by_id($inv_id);

        $data["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_invoice_details_by_id($inv_id);

        $data["category"] = $category = $this->categories_model->get_all_category();

// $data['company_details'] = $this->admin_model->get_company_details();

        $datas['company_details'] = $this->project_cost_model->get_company_details_by_firm($inv_id);



        $data["brand"] = $brand = $this->brand_model->get_brand();

        $data["user_info"] = $this->user_auth->get_from_session('user_info');

        $this->load->library("Pdf");

        $header = $this->load->view('sales/pdf_header_view', $datas, TRUE);

        $msg = $this->load->view('sales/receipt_pdf', $data, TRUE);

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->AddPage();

        $pdf->SetTitle('Invoice Receipt');

        $pdf->Header($header);

        $pdf->writeHTMLCell(0, 0, '', '', $msg, 0, 1, 0, true, '', true);

        $filename = 'Receipt-' . date('d-M-Y-H-i-s') . '.pdf';

        $newFile = $this->config->item('theme_path') . 'attachement/' . $filename;

        $pdf->Output($newFile);
    }

    public function customer_invoice_pdf($inv_id) {

        $data["quotation"] = $quotation = $this->project_cost_model->get_all_invoice_by_id($inv_id);

        $data["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_invoice_details_by_id($inv_id);

        $data["t1_customer_rate"] = array();

        if (isset($quotation_details) && !empty($quotation_details)) {

            foreach ($quotation_details as $val) {

                $product = $this->product_model->get_product_by_id($val['product_id']);

                if (isset($product) && !empty($product)) {

                    foreach ($product as $val1) {

                        array_push($data["t1_customer_rate"], $val1['cash_cus_price']);
                    }
                }
            }
        }

        $data["category"] = $category = $this->categories_model->get_all_category();

// $data['company_details'] = $this->admin_model->get_company_details();



        $datas['company_details'] = $this->project_cost_model->get_company_details_by_firm($inv_id);

        $data["brand"] = $brand = $this->brand_model->get_brand();

        $data["user_info"] = $this->user_auth->get_from_session('user_info');

        $this->load->library("Pdf");

        $header = $this->load->view('sales/pdf_header_view', $datas, TRUE);



        $msg = $this->load->view('sales/customer_receipt_pdf', $data, TRUE);

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->AddPage();

        $pdf->SetTitle('Invoice Receipt');

        $pdf->Header($header);

        $pdf->writeHTMLCell(0, 0, '', '', $msg, 0, 1, 0, true, '', true);

        $filename = 'Receipt-' . date('d-M-Y-H-i-s') . '.pdf';

        $newFile = $this->config->item('theme_path') . 'attachement/' . $filename;

        $pdf->Output($newFile);
    }

    function invoice_ajaxList() {



        $list = $this->project_cost_model->get_datatables();


        $data = array();

        $no = $_POST['start'];

        foreach ($list as $ass) {



            $no++;

            $row = array();

            $row[] = $no;

            $row[] = $ass['shop_name'];

            $row[] = $ass['store_name'];

            //  $row[] = number_format($ass['net_total'], 2);



            if ($ass['invoice_status'] == 'waiting') {

                $inv_status = '<span class=" badge  bg-red">Waiting</span>';
            } else if ($ass['invoice_status'] == 'approved') {

                $inv_status = '<span class=" badge bg-green">Approved</span>';
            }





            if ($ass['delivery_status'] == 'partially_delivered') {

                $delivery_status = '<span class="badge bg-red">Partially Delivered</span>';
            } else if ($ass['delivery_status'] == 'pending') {

                $delivery_status = '<span class="badge bg-yellow">Pending</span>';
            } else if ($ass['delivery_status'] == 'delivered') {

                $delivery_status = '<span class = "badge bg-green">Delivered</span>';
            }





            if ($ass['payment_status'] == 'Pending') {

                $payment_status = '<span class=" badge  bg-yellow">Pending</span>';
            } else if ($ass['payment_status'] == 'Completed') {

                $payment_status = '<span class=" badge bg-green">Completed</span>';
            }




            if (empty($ass['invoice'])) {



                $row[] = '<a href="' . $this->config->item('base_url') . 'sales/invoice_views/' . $ass['invoice'][0]['id'] . '" >' . $ass['inv_id'] . '</a>';

                $row[] = round($ass['delivery_qty']);

                $row[] = number_format($ass['inv_amount'], 2);

                $row[] = '';

                //$row[] = '';
                //$row[] = '';
                //$row[] = '';

                if ($this->user_auth->is_action_allowed('sales', 'invoice', 'add')) {

                    $row[] = '<a href="' . $this->config->item('base_url') . 'sales/invoice_add/' . $ass['id'] . '" data-toggle="tooltip" class="tooltips btn btn-default btn-xs1" title="" ><span class="fa fa-log-out "> <span class="glyphicon glyphicon-plus"></span>  </span></a>';
                } else {

                    $row[] = '<a href="#" data-toggle="tooltip" class="tooltips btn btn-default btn-xs1 alerts" title="" ><span class="fa fa-log-out "> <span class="glyphicon glyphicon-plus"></span>  </span></a>';
                }
            } else {

                if ($ass['invoice'][0]['contract_customer'] == 0) {


                    $row[] = '<a href="' . $this->config->item('base_url') . 'sales/invoice_views/' . $ass['invoice'][0]['id'] . '" >' . $ass['inv_id'] . '</a>';

                    $row[] = round($ass['delivery_qty']);

                    $row[] = number_format($ass['inv_amount'], 2);

                    $row[] = ($ass['created_date'] != '') ? date('d-M-Y', strtotime($ass['created_date'])) : '-';

                    //$row[] = $inv_status;
                    // $row[] = $delivery_status;
                    //$row[] = $payment_status;



                    if ($this->user_auth->is_action_allowed('sales', 'invoice', 'edit')) {

                        $rows = '';
                        //if ($ass['payment_status'] != "Completed" || $ass['delivery_status'] != "delivered" || $ass['invoice_status'] != "approved") {

                        $rows = '<a href="' . $this->config->item('base_url') . 'sales/invoice_edit/' . $ass['invoice'][0]['id'] . '" data-toggle="tooltip" class="tooltips btn btn-default btn-xs 2222" title="" ><span class="fa fa-log-out "> <span class="fa fa-edit"></span></span></a>';
                        //}
                    } else {

                        $rows = '<a href="#" data-toggle="tooltip" class="tooltips btn btn-default btn-xs alerts" title="" ><span class="fa fa-log-out "> <span class="fa fa-edit"></span></span></a>';
                    }

                    if ($this->user_auth->is_action_allowed('sales', 'invoice', 'view')) {

                        $rowss = $rows . '<a href="' . $this->config->item('base_url') . 'sales/invoice_views/' . $ass['invoice'][0]['id'] . '" data-toggle="tooltip" class="tooltips btn btn-default btn-xs" title="" ><span class="fa fa-log-out "> <span class="fa fa-eye"></span>  </span></a>';
                    } else {

                        $rowss = $rows . '<a href="#" data-toggle="tooltip" class="tooltips btn btn-default btn-xs alerts" title="" ><span class="fa fa-log-out "> <span class="fa fa-eye"></span>  </span></a>';
                    }



                    if ($this->user_auth->is_action_allowed('sales', 'invoice', 'delete')) {

                        // echo 1;

                        $row[] = $rowss . '<a href="#test3_' . $ass['invoice'][0]['id'] . '" data-toggle="modal" id="yesin" name="delete" class="tooltips btn btn-default btn-xs" ><span class="fa fa-log-out"> <span class="fa fa-ban testspan" in_id="' . $ass['invoice'][0]['id'] . '" q_id="' . $ass['invoice'][0]['q_id'] . '"></span>  </span></a>';
                    } else {

                        // echo 2;

                        $row[] = $rowss . '<a href="#" data-toggle="tooltip" class="tooltips btn btn-default btn-xs alerts" title="" ><span class="fa fa-log-out "> <span class="fa fa-ban"></span>  </span></a>';
                    }
                } else {

                    $row[] = '<a href="' . $this->config->item('base_url') . 'sales/invoice_views/' . $ass['invoice'][0]['id'] . '" >' . $ass['invoice'][0]['inv_id'] . '</a> -- <a href="' . $this->config->item('base_url') . 'sales/invoice_views/' . $ass['invoice'][0]['id'] . '" >' . $ass['invoice'][1]['inv_id'] . '</a>';

                    $row[] = round($ass['delivery_qty']);

                    $row[] = number_format($ass['invoice'][0]['net_total'], 2) . ' -- ' . number_format($ass['invoice'][1]['net_total'], 2);

                    $row[] = ($ass['created_date'] != '') ? date('d-M-Y', strtotime($ass['created_date'])) : '-';

                    // $row[] = $inv_status;
                    // $row[] = $delivery_status;
                    // $row[] = $payment_status;

                    if ($this->user_auth->is_action_allowed('sales', 'invoice', 'view')) {



                        $rowss = '<a href="' . $this->config->item('base_url') . 'sales/invoice_view/' . $ass['invoice'][0]['id'] . '" data-toggle="tooltip" class="tooltips btn btn-default btn-xs" title="Contractor Invoice" ><span class="fa fa-log-out "> <span class="fa fa-eye"></span>  </span></a>

                            <a href="' . $this->config->item('base_url') . 'sales/invoice_view/' . $ass['invoice'][1]['id'] . '" data-toggle="tooltip" class="tooltips btn btn-default btn-xs" title="Customer Invoice" ><span class="fa fa-log-out "> <span class="fa fa-eye"></span>  </span></a>';
                    } else {

                        $rowss = '<a href="#" data-toggle="tooltip" class="tooltips btn btn-default btn-xs alerts" title="Contractor Invoice" ><span class="fa fa-log-out "> <span class="fa fa-eye"></span>  </span></a>

                            <a href="#" data-toggle="tooltip" class="tooltips btn btn-default btn-xs alerts" title="Customer Invoice" ><span class="fa fa-log-out "> <span class="fa fa-eye"></span>  </span></a>';
                    }



                    if ($this->user_auth->is_action_allowed('sales', 'invoice', 'delete')) {

                        // echo 1;

                        $row[] = $rowss . '<a href="#test3_' . $ass['invoice'][0]['id'] . '" data-toggle="modal" id="yesin" name="delete" class="tooltips btn btn-default btn-xs" ><span class="fa fa-log-out"> <span class="fa fa-ban testspan" in_id="' . $ass['invoice'][0]['id'] . '" q_id="' . $ass['invoice'][0]['q_id'] . '"></span>  </span></a>';
                    } else {

                        // echo 2;

                        $row[] = $rowss . '<a href="#" data-toggle="tooltip" class="tooltips btn btn-default btn-xs alerts" title="" ><span class="fa fa-log-out "> <span class="fa fa-ban"></span>  </span></a>';
                    }
                }
            }

            $data[] = $row;
        }



//        echo "<pre>";
//        print_r($data);
//        exit;



        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->project_cost_model->count_all(),
            "recordsFiltered" => $this->project_cost_model->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);

        exit;
    }

    function convert_number($number) {



        $hyphen = '-';

        $conjunction = '  ';

        $separator = ' ';

        $negative = 'negative ';

        $decimal = ' Rupees And ';

        $dictionary = array(
            0 => 'Zero',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Fourty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety',
            100 => 'Hundred',
            1000 => 'Thousand',
            1000000 => 'Million',
            1000000000 => 'Billion',
            1000000000000 => 'Trillion',
            1000000000000000 => 'Quadrillion',
            1000000000000000000 => 'Quintillion'
        );



        if (!is_numeric($number)) {

            return false;
        }



        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {

// overflow

            trigger_error(
                    'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
            );

            return false;
        }



        if ($number < 0) {

            return $negative . $this->convert_number(abs($number));
        }



        $string = $fraction = null;



        if (strpos($number, '.') !== false) {

            list($number, $fraction) = explode('.', $number);
        }



        switch (true) {

            case $number < 21:

                $string = $dictionary[$number];

                break;

            case $number < 100:

                $tens = ((int) ($number / 10)) * 10;

                $units = $number % 10;

                $string = $dictionary[$tens];

                if ($units) {

                    $string .= $hyphen . $dictionary[$units];
                }

                break;

            case $number < 1000:

                $hundreds = $number / 100;

                $remainder = $number % 100;

                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];

                if ($remainder) {

                    $string .= $conjunction . $this->convert_number($remainder);
                }

                break;

            default:

                $baseUnit = pow(1000, floor(log($number, 1000)));

                $numBaseUnits = (int) ($number / $baseUnit);

                $remainder = $number % $baseUnit;

                $string = $this->convert_number($numBaseUnits) . ' ' . $dictionary[$baseUnit];

                if ($remainder) {

                    $string .= $remainder < 100 ? $conjunction : $separator;

                    $string .= $this->convert_number($remainder);
                }

                break;
        }



        if (null !== $fraction && is_numeric($fraction)) {

            $string .= $decimal;

            $words = array();

            $i = 0;

            foreach (str_split((string) $fraction) as $number) {

                $i++;

                if ($i == 1) {

                    $number = $number * 10;
                }

                $words[] = $dictionary[$number];
            }

//print_r($words);

            $string .= $words[0] . ' ' . $words[1] . ' Paise Only';
        }



        return $string;
    }

    function clear_cache() {

        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");

        $this->output->set_header("Pragma: no-cache");
    }

    public function invoice_delete() {

        $id = $this->input->POST('value1');

        $q_id = $this->input->POST('value2');

        $result = $this->project_cost_model->updatestock_as_per_invoice_live($id);

        //   $result1 = $this->project_cost_model->updatestockreturn_as_per_invoice_live($id);



        $this->project_cost_model->delete_receipt_by_inv_id($id);

        $this->project_cost_model->delete_inv_by_id($id);

        $this->project_cost_model->delete_invoice($id);

        $this->project_cost_model->delete_quotation_also($q_id);




        redirect($this->config->item('base_url') . 'sales/invoice_list');
    }

    public function invoice_duplicate_details() {

        $data['inv_det'] = $this->project_cost_model->invoice_duplicate_details();

        $insert_arr1 = array();

        foreach ($data['inv_det'] as $value) {

            if (isset($value) && !empty($value)) {

                foreach ($value as $val) {

                    $insert1['in_id'] = $val['in_id'];

                    $insert1['q_id'] = $val['q_id'];

                    $insert1['category'] = $val['category'];

                    $insert1['product_id'] = $val['product_id'];

                    $insert1['product_description'] = $val['product_description'];

                    $insert1['brand'] = $val['brand'];

                    $insert1['unit'] = $val['unit'];

                    $insert1['quantity'] = $val['quantity'];

                    $insert1['per_cost'] = $val['per_cost'];

                    $insert1['tax'] = $val['tax'];

                    $insert1['gst'] = $val['gst'];

                    $insert1['igst'] = $val['igst'];

                    $insert1['discount'] = $val['discount'];

                    $insert1['sub_total'] = $val['sub_total'];

                    $insert1['created_date'] = $val['created_date'];

                    $this->project_cost_model->insert_inv_pro_details($insert1);

                    $insert_arr1[] = $insert1;
                }
            }
        }

        return $data;
    }

}
