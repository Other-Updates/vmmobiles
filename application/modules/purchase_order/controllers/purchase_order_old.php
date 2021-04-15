<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Purchase_order extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->clear_cache();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'purchase';
        $access_arr = array(
            'purchase_order/purchase_order_list' => 'no_restriction',
            'purchase_order/index' => 'no_restriction',
            'purchase_order/search_result' => array('add', 'edit', 'delete', 'view'),
            'purchase_order/po_view' => array('add', 'edit', 'delete', 'view'),
            'purchase_order/po_delete' => array('delete'),
            'purchase_order/po_edit' => array('add', 'edit'),
            'purchase_order/update_po' => array('edit'),
            'purchase_order/change_status' => 'no_restriction',
            'purchase_order/get_customer' => 'no_restriction',
            'purchase_order/get_customer_by_id' => 'no_restriction',
            'purchase_order/get_product' => 'no_restriction',
            'purchase_order/get_product_by_id' => 'no_restriction',
            'purchase_order/get_service' => 'no_restriction',
            'purchase_order/history_view' => 'no_restriction',
            'purchase_order/stock_details' => 'no_restriction',
            'purchase_order/excel_report' => 'no_restriction',
            'purchase_order/dc_edit' => 'no_restriction',
            'purchase_order/pr_view' => 'no_restriction',
            'purchase_order/clear_cache' => 'no_restriction',
            'purchase_order/purchase_order_ajaxList' => 'no_restriction',
            'purchase_order/check_exists_ime_code' => 'no_restriction',
            'purchase_order/get_supplier_by_firm' => 'no_restriction',
            'purchase_order/check_duplicate_ime_code_edit' => 'no_restriction',
            'purchase_order/check_duplicate_pr_id' => 'no_restriction',
            'purchase_order/check_duplicate_pr_id_edit' => 'no_restriction',
            ''
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
        $this->load->model('purchase_return/purchase_return_model');
        $this->load->model('masters/sms_model');
        $this->load->model('api/notification_model');
        $this->load->model('api/increment_model');
        $this->load->model('quotation/gen_model');
        if (isset($_GET['notification']))
            $this->notification_model->update_notification(array('status' => 1), $_GET['notification']);
    }

    public function index() {
//exit;
        $input = $this->input->post();

        if (!empty($input)) {


//echo "<pre>";print_r($input);exit;
            $user_info = $this->user_auth->get_from_session('user_info');
            $data['company_details'] = $this->admin_model->get_company_details();
            $input['po']['po_no'] = $input['po']['pr_no'];
            $input['po']['delivery_schedule'] = date('Y-m-d', strtotime($input['po']['created_date']));
            $input['po']['created_by'] = $user_info[0]['id'];
            $input['po']['supplier'] = $input['supplier']['id'];
            $input['po']['created_date'] = date('Y-m-d', strtotime($input['po']['created_date']));
            if ($input['po']['delivery_status'] == 'delivered') {
                $input['po']['delivery_qty'] = $input['po']['total_qty'];
            }
            $insert_id = $this->purchase_order_model->insert_po($input['po']);

            if ($input['po']['pr_status'] == 'approved') {
                $insert_pr_id = $this->purchase_return_model->insert_pr($input['po']);
            }

//insert notification
            $notification = array();
            if ($input['credit_days'] > 0 && isset($input['po']['created_date']) && !empty($input['po']['created_date'])) {
                $created_date = $input['po']['created_date'];
                $due_date = date('Y-m-d', strtotime('+' . $input['credit_days'] . ' days', strtotime($created_date)));
                $notification = array();
                $days = 3;
                $notification['notification_date'] = date('Y-m-d', strtotime('-' . $days . ' days', strtotime($due_date)));
                $notification['due_date'] = $due_date;
                $notification['type'] = 'purchase_payment';
                $receiver_list = array(1, 2);
                $notification['receiver_id'] = json_encode($receiver_list);
                $notification['link'] = 'purchase_receipt/receipt_list';
                $notification['Message'] = date('d-M-Y', strtotime($due_date)) . '-We have to pay amount for Supplier';
                $this->notification_model->insert_notification($notification);
            }

            $notifications = array();
            if ($input['po']['pr_status'] == 'waiting') {
                $created_date = date('Y-m-d', strtotime($input['po']['created_date']));
                $notifications = array();
                $notifications['notification_date'] = date('Y-m-d');
                $notifications['due_date'] = '';
                $notifications['type'] = 'purchase_request';
                $receiver_list = array(1, 2, 6);
                $notifications['receiver_id'] = json_encode($receiver_list);
                $notifications['link'] = 'purchase_order/purchase_order_list';
                $notifications['Message'] = $input['po']['pr_no'] . '- Waiting for purchase manager approval';
                $this->notification_model->insert_notification($notifications);
            }


//            $q_no = $input['po']['po_no'];
//            $split = explode("-", $q_no);
//            $code = 'PO';
//            $this->increment_model->update_increment_id($split[1], $code);
            if (isset($insert_id) && !empty($insert_id)) {
                $input = $this->input->post();
                if (isset($input['categoty']) && !empty($input['categoty'])) {
                    $insert_arr = array();

                    foreach ($input['categoty'] as $key => $val) {
                        $insert['po_id'] = $insert_id;
                        $input['po']['po_no'] = $input['po']['pr_no'];
                        $insert['category'] = $val;
                        $insert['product_id'] = $input['product_id'][$key];
                        $insert['product_description'] = $input['product_description'][$key];
                        $insert['type'] = $input['type'][$key];
                        $insert['brand'] = $input['brand'][$key];
                        $insert['unit'] = $input['unit'][$key];
                        $insert['quantity'] = $input['quantity'][$key];
                        if ($input['po']['delivery_status'] == 'delivered') {
                            $insert['delivery_quantity'] = $input['quantity'][$key];
                        }
                        $insert['per_cost'] = $input['per_cost'][$key];
                        $insert['price_with_gst'] = $input['price_with_gst'][$key];
                        $insert['tax'] = $input['tax'][$key];
                        $insert['gst'] = $input['gst'][$key];
                        $insert['igst'] = $input['igst'][$key];
                        $insert['discount'] = $input['discount'][$key];
                        $insert['transport'] = $input['transport'][$key];
                        $insert['sub_total'] = $input['sub_total'][$key];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;
                        if ($input['po']['pr_status'] == 'approved' && $input['po']['delivery_status'] == 'delivered') {
                            $stock_arr = array();
                            $po_id['po_id'] = $input['po']['pr_no'];
                            $stock_arr[] = $po_id;
                            // $this->stock_details($insert, $po_id);
                        }
                    }
                    $this->purchase_order_model->insert_po_details($insert_arr);
                }

                if ($input['po']['pr_status'] = 'approved')
                    $sms = $this->sms_model->send_sms($insert_id, 'purchase');
            }


            $update_po_details = $this->update_po_data($input, $insert_id);


            $this->load->model('purchase_receipt/receipt_model');

            $receipt_status = 'Completed';

            $this->receipt_model->update_invoice(array('payment_status' => $receipt_status), $insert_id);

            $this->receipt_model->update_pr_invoice(array('payment_status' => $receipt_status), $insert_id);


            $bill_data = [
                "recevier" => 'company',
                "receipt_id" => $insert_id,
                "bill_amount" => $input['po']['net_total'],
                "terms" => '1',
                "due_date" => date('Y-m-d', strtotime($input['po']['created_date'])),
                "created_date" => date('Y-m-d', strtotime($input['po']['created_date'])),
            ];

            $this->receipt_model->insert_receipt_bill($bill_data);

            if ($input['print'] == 'yes') {
                $file_name = base_url() . 'purchase_order/pr_view/' . $insert_id;
                echo "<script>window.location.href = '$file_name';</script>";
                exit;
            } else {
                $redirect_url = base_url() . 'purchase_order/purchase_order_list';
                echo "<script>window.location.href = '$redirect_url';</script>";
                exit;
            }



            //  redirect($this->config->item('base_url') . 'purchase_order/purchase_order_list');
        }

        $data["po"] = $details = $this->purchase_order_model->get_all_po();
        $data["category"] = $details = $this->categories_model->get_all_category();
        $data["brand"] = $this->brand_model->get_brand();
        $data['firms'] = $firms = $this->user_auth->get_user_firms();
        $data['company_details'] = $this->admin_model->get_company_details();
        $data["products"] = $this->purchase_order_model->get_all_product();
        $data["customers"] = $this->purchase_order_model->get_all_customers();
        // echo "<pre>";print_r($data["customers"] );exit;
        $this->template->write_view('content', 'purchase_order/index', $data);
        $this->template->render();
    }

    function stock_details($stock_info, $po_id) {

        $this->purchase_order_model->check_stock($stock_info, $po_id);
    }

    public function get_supplier_by_firm() {
        $firm_id = $this->input->post('firm_id');

        $data = $this->purchase_order_model->get_supplier_by_firmid($firm_id);
        echo json_encode($data);
    }

    public function po_view($id) {
        $datas["po"] = $po = $this->purchase_order_model->get_all_po_by_id($id);
        $datas["po_details"] = $po_details = $this->purchase_order_model->get_all_po_details_by_id($id);
        $datas["category"] = $category = $this->categories_model->get_all_category();
// $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->brand_model->get_brand();
        $datas['company_details'] = $this->purchase_order_model->get_company_details_by_firm($id);
//        echo '<pre>';
//        print_r($datas["company_details"]);
//        exit;
        $this->template->write_view('content', 'purchase_order_view', $datas);
        $this->template->render();
    }

    public function pr_view($id) {
        $datas["po"] = $po = $this->purchase_order_model->get_all_po_by_id($id);
        $datas["po_details"] = $po_details = $this->purchase_order_model->get_all_po_details_by_id($id);
        $datas["category"] = $category = $this->categories_model->get_all_category();
//$datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->brand_model->get_brand();
        $datas['company_details'] = $this->purchase_order_model->get_company_details_by_firm($id);
        $this->template->write_view('content', 'purchase_request_view', $datas);
        $this->template->render();
    }

    public function change_status($id, $status) {
//echo $id; echo $status; exit;
        $this->purchase_order_model->change_po_status($id, $status);
        redirect($this->config->item('base_url') . 'purchase_order/purchase_order_list');
    }

    public function purchase_order_list() {
        $datas["po"] = $po = $this->purchase_order_model->get_all_po();
        $datas['company_details'] = $this->admin_model->get_company_details();
//echo "<pre>";
//print_r($datas);
//exit;
        $this->template->write_view('content', 'purchase_order/purchase_order_list', $datas);
        $this->template->render();
    }

    public function get_customer($id) {
        $atten_inputs = $this->input->post();
        $data = $this->purchase_order_model->get_customer($atten_inputs);
        echo json_encode($data);
        exit;
    }

    public function get_customer_by_id() {
        $input = $this->input->post();
        $data_customer["customer_details"] = $this->purchase_order_model->get_customer_by_id($input['id']);
        echo json_encode($data_customer);
        exit;
    }

    public function get_product() {
        $atten_inputs = $this->input->post();
        $product_data = $this->purchase_order_model->get_product($atten_inputs);
        echo json_encode($product_data);
        exit;
    }

    public function get_product_by_id() {
        $input = $this->input->post();
        $data_customer["product_details"] = $this->purchase_order_model->get_product_by_id($input['id']);
        echo json_encode($data_customer);
        exit;
    }

    public function update_po_data($input, $id) {
        // $input = $this->input->post();

        if ($input['po']['delivery_status'] == 'delivered') {
            $input['po']['delivery_qty'] = $input['po']['total_qty'];
        }
        $input['po']['created_date'] = date('Y-m-d', strtotime($input['po']['created_date']));

        $this->purchase_order_model->update_po($input['po'], $id);
        $this->purchase_order_model->delete_po_deteils_by_id($id);

        if ($input['po']['pr_status'] == 'approved') {
            $input['po']['po_id'] = $id;
            $this->purchase_return_model->delete_pr($id);
            $pr_id = $this->purchase_return_model->insert_pr($input['po']);
        }

        //if (isset($update_id) && !empty($update_id)) {
        $input = $this->input->post();
        if (isset($input['categoty']) && !empty($input['categoty'])) {
            $insert_arr = array();

            foreach ($input['categoty'] as $key => $val) {
                $insert['po_id'] = $id;
                $insert['category'] = $val;
                $insert['product_id'] = $input['product_id'][$key];
                $insert['product_description'] = $input['product_description'][$key];
                $insert['type'] = $input['type'][$key];
                $insert['brand'] = $input['brand'][$key];
                $insert['unit'] = $input['unit'][$key];
                $insert['quantity'] = $input['quantity'][$key];
                if ($input['po']['delivery_status'] == 'delivered') {
                    $insert['delivery_quantity'] = $input['quantity'][$key];
                }
                $insert['per_cost'] = $input['per_cost'][$key];
                $insert['price_with_gst'] = $input['price_with_gst'][$key];
                $insert['tax'] = $input['tax'][$key];
                $insert['gst'] = $input['gst'][$key];
                $insert['igst'] = $input['igst'][$key];
                $insert['discount'] = $input['discount'][$key];
                $insert['transport'] = $input['transport'][$key];
                $insert['sub_total'] = $input['sub_total'][$key];
                $insert['created_date'] = date('Y-m-d H:i');
                $insert_arr[] = $insert;
                if ($input['po']['pr_status'] == 'approved' && $input['po']['delivery_status'] == 'delivered') {
                    $stock_arr = array();
                    $po_id['po_id'] = $input['po']['pr_no'];
                    $stock_arr[] = $po_id;
                    $this->stock_details($insert, $po_id);
                }
                $insert_id = $this->purchase_order_model->insertpo_details($insert);

                $ime_data = [
                    "po_id" => $id,
                    "po_details_id" => $insert_id,
                    "product_id" => $input['product_id'][$key],
                    "ime_code" => trim($input['ime_code_value'][$key]),
                    "status" => "open",
                    "open_date" => date('Y-m-d'),
                ];
                $this->purchase_order_model->insert_ime_code($ime_data);
            }
            //  $this->purchase_order_model->insert_po_details($insert_arr);

            if ($input['po']['pr_status'] == 'approved') {
                $this->purchase_return_model->delete_pr_details($id);
                foreach ($input['categoty'] as $key => $val) {
                    $pr_details = array();
                    $pr_details['po_id'] = $id;
                    $pr_details['pr_id'] = $pr_id;
                    $pr_details['category'] = $val;
                    $pr_details['product_id'] = $input['product_id'][$key];
                    $pr_details['product_description'] = $input['product_description'][$key];
                    $pr_details['type'] = $input['type'][$key];
                    $pr_details['brand'] = $input['brand'][$key];
                    $pr_details['unit'] = $input['unit'][$key];
                    $pr_details['quantity'] = $input['quantity'][$key];
                    $pr_details['return_quantity'] = 0;
                    $pr_details['per_cost'] = $input['per_cost'][$key];
                    $pr_details['tax'] = $input['tax'][$key];
                    $pr_details['gst'] = $input['gst'][$key];
                    $pr_details['igst'] = $input['igst'][$key];
                    $pr_details['discount'] = $input['discount'][$key];
                    $pr_details['transport'] = $input['transport'][$key];
                    $pr_details['sub_total'] = $input['sub_total'][$key];
                    $pr_details['created_date'] = date('Y-m-d H:i');
                    //echo "<pre>";
                    //print_r($pr_details);
                    //exit;
                    $this->purchase_return_model->insert_pr_details($pr_details);
                }
            }
        }

        return 1;
    }

    public function po_edit($id) {
        $input = $this->input->post();

        if (!empty($input)) {
            $input = $this->input->post();



            //Remove Old Product stock
            foreach ($input['old_product_id'] as $key => $results) {
                $qty = $input['old_product_qty'][$key];
                $firm_id = $input['old_firm_id'][$key];
                $cat_id = $input['old_cat_id'][$key];
                // echo $firm_id;echo "<br>";
                //  echo $qty;echo "<br>";old_cat_id
                // echo $results;echo "<br>";
                $this->purchase_order_model->remove_stocks_by_poedit($results, $qty, $firm_id, $cat_id);
            }

            if ($input['po']['delivery_status'] == 'delivered') {
                $input['po']['delivery_qty'] = $input['po']['total_qty'];
            }
            $input['po']['created_date'] = date('Y-m-d', strtotime($input['po']['created_date']));
            $input['po']['po_no'] = $input['po']['pr_no'];
// $insert_id = $this->purchase_order_model->insert_po($input['po']);


            $this->purchase_order_model->update_po($input['po'], $id);
            $this->purchase_order_model->delete_po_deteils_by_id($id);

            if ($input['po']['pr_status'] == 'approved') {
                $input['po']['po_id'] = $id;
                $this->purchase_return_model->delete_pr($id);
                $pr_id = $this->purchase_return_model->insert_pr($input['po']);
            }

            //if (isset($update_id) && !empty($update_id)) {


            $input = $this->input->post();
            if (isset($input['categoty']) && !empty($input['categoty'])) {
                $insert_arr = array();
                $this->purchase_order_model->delete_ime_by_poid($id);
                foreach ($input['categoty'] as $key => $val) {
                    $insert['po_id'] = $id;
                    $insert['category'] = $val;
                    $insert['product_id'] = $input['product_id'][$key];
                    $insert['product_description'] = $input['product_description'][$key];
                    $insert['type'] = $input['type'][$key];
                    $insert['brand'] = $input['brand'][$key];
                    $insert['unit'] = $input['unit'][$key];
                    $insert['quantity'] = $input['quantity'][$key];
                    if ($input['po']['delivery_status'] == 'delivered') {
                        $insert['delivery_quantity'] = $input['quantity'][$key];
                    }
                    $insert['per_cost'] = $input['per_cost'][$key];
                    $insert['price_with_gst'] = $input['price_with_gst'][$key];
                    $insert['tax'] = $input['tax'][$key];
                    $insert['gst'] = $input['gst'][$key];
                    $insert['igst'] = $input['igst'][$key];
                    $insert['discount'] = $input['discount'][$key];
                    $insert['transport'] = $input['transport'][$key];
                    $insert['sub_total'] = $input['sub_total'][$key];
                    $insert['created_date'] = date('Y-m-d H:i');
                    $insert_arr[] = $insert;
                    if ($input['po']['pr_status'] == 'approved' && $input['po']['delivery_status'] == 'delivered') {
                        $stock_arr = array();
                        $po_id['po_id'] = $input['po']['pr_no'];
                        $stock_arr[] = $po_id;


                        $this->stock_details($insert, $po_id);
                    }

                    $insert_id = $this->purchase_order_model->insertpo_details($insert);

                    $ime_data = [
                        "po_id" => $id,
                        "po_details_id" => $insert_id,
                        "product_id" => $input['product_id'][$key],
                        "ime_code" => trim($input['ime_code_value'][$key]),
                        "status" => "open",
                        "open_date" => date('Y-m-d'),
                    ];



                    $this->purchase_order_model->insert_ime_code($ime_data);
                }
                //  $this->purchase_order_model->insert_po_details($insert_arr);

                if ($input['po']['pr_status'] == 'approved') {
                    $this->purchase_return_model->delete_pr_details($id);
                    foreach ($input['categoty'] as $key => $val) {
                        $pr_details = array();
                        $pr_details['po_id'] = $id;
                        $pr_details['pr_id'] = $pr_id;
                        $pr_details['category'] = $val;
                        $pr_details['product_id'] = $input['product_id'][$key];
                        $pr_details['product_description'] = $input['product_description'][$key];
                        $pr_details['type'] = $input['type'][$key];
                        $pr_details['brand'] = $input['brand'][$key];
                        $pr_details['unit'] = $input['unit'][$key];
                        $pr_details['quantity'] = $input['quantity'][$key];
                        $pr_details['return_quantity'] = 0;
                        $pr_details['per_cost'] = $input['per_cost'][$key];
                        $pr_details['tax'] = $input['tax'][$key];
                        $pr_details['gst'] = $input['gst'][$key];
                        $pr_details['igst'] = $input['igst'][$key];
                        $pr_details['discount'] = $input['discount'][$key];
                        $pr_details['transport'] = $input['transport'][$key];
                        $pr_details['sub_total'] = $input['sub_total'][$key];
                        $pr_details['created_date'] = date('Y-m-d H:i');
                        //echo "<pre>";
                        //print_r($pr_details);
                        //exit;
                        $this->purchase_return_model->insert_pr_details($pr_details);
                    }
                }
            }
            if ($input['po']['pr_status'] == 'approved')
                $sms = $this->sms_model->send_sms($insert_id, 'purchase');
            //}

            redirect($this->config->item('base_url') . 'purchase_order/purchase_order_list');
        }
        $datas["po"] = $po = $this->purchase_order_model->get_all_po_by_id($id);
        $datas["po_details"] = $po_details = $this->purchase_order_model->get_all_po_details_by_id($id);
        $datas["category"] = $details = $this->categories_model->get_all_category();
        $datas["brand"] = $this->brand_model->get_brand();
        $datas['firms'] = $firms = $this->user_auth->get_user_firms();
        $datas["products"] = $this->purchase_order_model->get_all_product();
        $datas["customers"] = $this->purchase_order_model->get_all_customers();
//echo "<pre>";print_r($datas["po_details"] );exit;
        $this->template->write_view('content', 'purchase_order_edit', $datas);
        $this->template->render();
    }

    public function dc_edit($id) {
        $input = $this->input->post();
//        echo '<pre>';
//        print_r($input);
//        exit;
        $cnt = 0;
        $current_qty = 0;
        $delivery_qty_sum = array();
        $purchase_order_id = $id;
        foreach ($input['id'] as $key => $val) {
            $trim_val = trim($val);
            if (!empty($input['delivery_quantity'][$trim_val])) {
                $current_qty = $insert['delivery_quantity'] = $input['delivery_quantity'][$trim_val][0] . '<br />';
                $purchase_order_detail_id = $input['id'][$key];
                $already_purchase_detail = $this->purchase_order_model->check_old_qty($purchase_order_detail_id);
                if (!empty($already_purchase_detail)) {
                    $already_qty = $already_purchase_detail[0]['delivery_quantity'];
                    $current_qty = $current_qty - $already_qty;
                    $current_qty = abs($current_qty);
                    $insert['delivery_quantity'] = $current_qty + $already_qty;
                }
                array_push($delivery_qty_sum, $current_qty);
                $stock_arr = array();
                $po_id['po_id'] = $input['po_no'];
                $stock_arr['category'] = $input['po']['cat_id'][$key];
                $stock_arr['product_id'] = $input['po']['pro_id'][$key];
                $stock_arr['brand'] = $input['po']['brand'][$key];
                $stock_arr['quantity'] = $current_qty;
                $this->stock_details($stock_arr, $po_id);
                $this->purchase_order_model->update_dc_details($insert, $val);
            }
        }

        $get_all_purchase_order_details = $this->purchase_order_model->get_all_purchase_order_details($purchase_order_id);
        if (!empty($get_all_purchase_order_details)) {
            $d_qty = $get_all_purchase_order_details[0]['delivery_quantity'];
        }
        if ($d_qty == $input['total_qty']) {
            $inputs = array('delivery_status' => 'delivered', 'delivery_qty' => $d_qty);
            $this->purchase_order_model->update_dc($inputs, $id);
        } else if ($d_qty < $input['total_qty']) {
            $inputs = array('delivery_status' => 'partially_delivered', 'delivery_qty' => $d_qty);
            $this->purchase_order_model->update_dc($inputs, $id);
        } else if ($d_qty == 0) {
            $inputs = array('delivery_status' => 'pending', 'delivery_qty' => $d_qty);
            $this->purchase_order_model->update_dc($inputs, $id);
        }

        foreach ($input['id'] as $key => $val) {
            $trim_val = trim($val);
            if (!empty($input['delivery_quantity'][$trim_val])) {
                $category = $input['po']['cat_id'][$key];
                $product_id = $input['po']['pro_id'][$key];

                $update_pr_details = $this->purchase_return_model->update_pr_details_basedon_po_id($category, $product_id, $purchase_order_id, $input['delivery_quantity'][$trim_val][0]);
            }
            $erp_pr = $this->purchase_return_model->get_erp_pr_based_on_erp_po($purchase_order_id);
        }

        $this->purchase_return_model->update_pr($purchase_order_id, $del_qty);

        $get_all_purchase_return_details = $this->purchase_return_model->get_all_purchase_return_details($purchase_order_id);

        if (!empty($get_all_purchase_return_details)) {
            $del_qty = $get_all_purchase_return_details[0]['delivery_qty'];
        }

        if ($del_qty == $erp_pr[0]['total_qty']) {
            $pr_inputs = array('delivery_status' => 'delivered', 'delivery_qty' => $del_qty);
            $this->purchase_return_model->update_dc($pr_inputs, $purchase_order_id);
        } else if ($del_qty < $erp_pr[0]['total_qty']) {
            $pr_inputs = array('delivery_status' => 'partially_delivered', 'delivery_qty' => $del_qty);
            $this->purchase_return_model->update_dc($pr_inputs, $purchase_order_id);
        } else if ($del_qty == 0) {
            $pr_inputs = array('delivery_status' => 'pending', 'delivery_qty' => $del_qty);
            $this->purchase_return_model->update_dc($pr_inputs, $purchase_order_id);
        }

        redirect($this->config->item('base_url') . 'purchase_order/purchase_order_list');
    }

    public function po_delete() {
        $id = $this->input->POST('value1');
        $datas["po"] = $po = $this->purchase_order_model->get_all_po();
        $del_id = $this->purchase_order_model->delete_po($id);
        redirect($this->config->item('base_url') . 'purchase_order/purchase_order_list', $datas);
    }

    public function history_view($id) {
        $datas["his_quo"] = $his_quo = $this->purchase_order_model->all_history_quotations($id);
        $this->template->write_view('content', 'history_view', $datas);
        $this->template->render();
    }

    function excel_report() {
        if (isset($_GET) && $_GET['search'] != '') {
            $search = $_GET['search'];
        } else {
            $search = '';
        }

        $json = json_decode($search);

        $po = $this->purchase_order_model->get_all_po_for_report($search);
        $this->export_csv($po);
    }

    function export_csv($query, $timezones = array()) {

// output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Purchase Order Report.csv');

// create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

// output the column headings
//Order has been changes
        fputcsv($output, array('Po No', 'Company Name', 'Total Quantity', 'Total Amount', 'Delivery Schedule', 'Created Date'));

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
            $row = array($val['po_no'], ($val['store_name']) ? $val['store_name'] : $val['name'], $val['total_qty'], $val['net_total'], $val['delivery_schedule'], $val['created_date']);
            fputcsv($output, $row);
        }
        exit;
    }

    function clear_cache() {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    function purchase_order_ajaxList() {

        $list = $this->purchase_order_model->get_datatables();

        $data = array();

        $no = $_POST['start'];
        foreach ($list as $ass) {

            /* if ($this->user_auth->is_action_allowed('purchase', 'purchase_request', 'edit')) {
              $edit = '<a href="' . $this->config->item('base_url') . 'purchase_order/po_edit/' . $ass['id'] . '" data-toggle="tooltip" class="tooltips btn btn-default btn-xs" title="" ><span class="fa fa-log-out "> <span class="fa fa-edit"></span></span></a>';
              } else {
              $edit = '<a href="#" data-toggle="tooltip" class="tooltips btn btn-default btn-xs alerts" title="" ><span class="fa fa-log-out "> <span class="fa fa-edit"></span></span></a>';
              }
              if ($this->user_auth->is_action_allowed('purchase', 'purchase_request', 'view')) {
              $view = $edit . '<a href="' . $this->config->item('base_url') . 'purchase_order/pr_view/' . $ass['id'] . '" data-toggle="tooltip" class="tooltips btn btn-default btn-xs" title="" ><span class="fa fa-log-out "> <span class="fa fa-eye"></span>  </span></a>';
              } else {
              $view = $edit . '<a href="#" data-toggle="tooltip" class="tooltips btn btn-default btn-xs alerts" title="" ><span class="fa fa-log-out "> <span class="fa fa-eye"></span>  </span></a>';
              } */

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ass['firm_name'];
            $row[] = $ass['po_no'];
            // $row[] = ($ass['pr_status'] == 'approved') ? $ass['po_no'] : '-';
            $row[] = $ass['store_name'];
            $row[] = $ass['total_qty'];
            //$row[] = $ass['delivery_qty'];
            $row[] = number_format($ass['net_total'], 2);
            $row[] = ($ass['delivery_schedule'] != '1970-01-01') ? date('d-M-Y', strtotime($ass['delivery_schedule'])) : '-';
            $pr_status = $delivery_status = '';
            if ($ass['pr_status'] == 'waiting') {
                $pr_status = '<span class=" badge  bg-red">Waiting</span>';
            } else if ($ass['pr_status'] == 'approved') {
                $pr_status = '<span class=" badge bg-green">Approved</span>';
            }

            // $row[] = $pr_status;

            if ($ass['delivery_status'] == 'partially_delivered') {
                $delivery_status = '<span class="badge bg-red">Partially Delivered</span>';
            } else if ($ass['delivery_status'] == 'pending') {
                $delivery_status = '<span class="badge bg-yellow">Pending</span>';
            } else if ($ass['delivery_status'] == 'delivered') {
                $delivery_status = '<span class = "badge bg-green">Delivered</span>';
            }

            // $row[] = $delivery_status;

            $edit = '<a href="' . $this->config->item('base_url') . 'purchase_order/po_edit/' . $ass['po_id'] . '" data-toggle="tooltip" class="tooltips btn btn-default btn-xs" title="" ><span class="fa fa-log-out "> <span class="fa fa-edit"></span></span></a>';

            $row[] = $edit . '<a href="' . $this->config->item('base_url') . 'purchase_order/po_view/' . $ass['po_id'] . '" data-toggle="tooltip" class="tooltips btn btn-default btn-xs" title="" ><span class="fa fa-log-out "> <span class="fa fa-eye"></span>  </span></a>';

            /*  if ($ass['pr_status'] == 'waiting') {
              $row[] = $view;
              }
              if ($ass['pr_status'] == 'approved') {
              $row = '<a href="' . $this->config->item('base_url') . 'purchase_order/po_view/' . $ass['id'] . '" data-toggle="tooltip" class="tooltips btn btn-default btn-xs" title="" ><span class="fa fa-log-out "> <span class="fa fa-eye"></span>  </span></a>';
              } */

            $data[] = $row;
        }


        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->purchase_order_model->count_all(),
            "recordsFiltered" => $this->purchase_order_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    public function check_exists_ime_code() {
        $ime_code = $this->input->POST('ime_code');

        $data = $this->purchase_order_model->check_duplicate_ime_code($ime_code);

        if ($data == 0)
            echo 0;
        else
            echo json_encode($data);
    }

    public function check_duplicate_ime_code_edit() {
        $ime_code = $this->input->POST('ime_code');


        $data = $this->purchase_order_model->check_duplicate_ime_code_edit($ime_code);

        if ($data == 0)
            echo 0;
        else
            echo json_encode($data);
    }

    public function check_duplicate_pr_id() {
        $input = $this->input->post();

        $validation = $this->purchase_order_model->check_duplicate_pr_id($input);

        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "PO NO already Exist";
        }
    }

    public function check_duplicate_pr_id_edit() {
        $input = $this->input->post('value1');
        $id = $this->input->post('value2');
        $validation = $this->purchase_order_model->check_duplicate_pr_id_edit($input, $id);
        //echo $input; echo $id; exit;
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "PO NO already Exist";
        }
    }

}
