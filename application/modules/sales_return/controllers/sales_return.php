<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Sales_return extends MX_Controller {



    function __construct() {

        parent::__construct();

        $this->clear_cache();

        if (!$this->user_auth->is_logged_in()) {

            redirect($this->config->item('base_url') . 'admin');

        }

        $main_module = 'sales';

        $access_arr = array(

            'sales_return/index' => array('add', 'edit', 'delete', 'view'),

            'sales_return/invoice_view' => array('add', 'edit', 'delete', 'view'),

            'sales_return/change_status' => array('add', 'edit', 'delete', 'view'),

            'sales_return/sales_return_list' => array('add', 'edit', 'delete', 'view'),

            'sales_return/get_customer' => array('delete'),

            'sales_return/get_customer_by_id' => array('add', 'edit'),

            'sales_return/get_product' => array('edit'),

            'sales_return/get_product_by_id' => 'no_restriction',

            'sales_return/po_edit' => 'no_restriction',

            'sales_return/update_po' => 'no_restriction',

            'sales_return/po_delete' => 'no_restriction',

            'sales_return/history_view' => 'no_restriction',

            'sales_return/clear_cache' => 'no_restriction',

            'sales_return/invoice_views' => array('add', 'edit', 'delete', 'view'),

            'sales_return/product_list' => 'no_restriction', // Newly Added..

            'sales_return/clear_prodct_name_wise_filter' => 'no_restriction', // Newly Added..

            'sales_return/ajaxList' => 'no_restriction', // Newly Added..

            'sales_return/return_bill_copy' => 'no_restriction', // Newly Added..

            'sales_return/sales_return_bill' => 'no_restriction',

        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {

            redirect($this->config->item('base_url'));

        }

        $this->load->helper('form');

        $this->load->helper('url');

        $this->load->library('session');

        $this->load->library('email');

        $this->load->database();

        $this->load->library('form_validation');

        $this->load->model('masters/categories_model');

        $this->load->model('master_style/master_model');

        $this->load->model('masters/brand_model');

        $this->load->model('quotation/Gen_model');

        $this->load->model('masters/customer_model');

        $this->load->model('enquiry/enquiry_model');

        $this->load->model('admin/admin_model');

        $this->load->model('sales_return/sales_return_model');

        $this->load->model('sales/project_cost_model');

        $this->load->model('product/product_model');  // Newly Added..

    }



    public function index() {

        $user_info = $this->user_auth->get_from_session('user_info');

        if ($this->input->post()) {



            //echo "<pre>";

            //print_r($this->input->post());

            //exit;



            $filter = $this->input->post('filter');

            $this->session->set_userdata("product_name_wise", $filter);

            $filter = $this->session->userdata('product_name_wise');

            //echo "<pre>test";

            //print_r($filter);

            //exit;

            redirect($this->config->item('base_url') . 'sales_return/index');

        } else {

            $filter = $this->session->userdata('product_name_wise');

        }



//        $datas["po"] = $po = $this->sales_return_model->get_all_inv($filter);

//        $datas['company_details'] = $this->admin_model->get_company_details();

//        echo "<pre>";

//        print_r($datas);

//        exit;

        $this->template->write_view('content', 'sales_return/sales_return_list', $datas);

        $this->template->render();

    }



    public function invoice_view($id) {



        //  $datas["po"] = $po = $this->sales_return_model->get_all_inv_by_id($id);

        // $datas["po_details"] = $po_details = $this->sales_return_model->get_all_inv_details_by_id($id);

        $datas["quotation"] = $quotation = $this->sales_return_model->get_all_invoice_by_id($id);

        $datas["in_words"] = $this->convert_number($datas["quotation"][0]['net_total']);

        $datas["quotation_details"] = $quotation_details = $this->sales_return_model->get_all_sr_details_by_id($id);

        $datas["return_details"] = $return_details = $this->sales_return_model->get_all_sr_by_id($id);

//        echo "<pre>";

//        print_r($datas);

//        exit;



        $datas['company_details'] = $this->project_cost_model->get_company_details_by_firm($id);

        //$datas['company_details'] = $this->admin_model->get_company_details();

        $this->template->write_view('content', 'sales_return_view', $datas);

        $this->template->render();

    }



    public function return_bill_copy($id, $in_id) {

        $datas["quotation"] = $quotation = $this->sales_return_model->get_all_invoice_by_id($in_id);

        $datas["in_words"] = $this->convert_number($datas["quotation"][0]['net_total']);

        $datas["quotation_details"] = $quotation_details = $this->sales_return_model->get_all_sr_bill_details_by_id($id, $in_id);

        $datas['company_details'] = $this->project_cost_model->get_company_details_by_firm($in_id);

//        echo '<pre>';

//        print_r($datas);

//        die;

        $this->template->write_view('content', 'sales_bill_copy', $datas);

        $this->template->render();

    }



    public function invoice_views($id) {



        //  $datas["po"] = $po = $this->sales_return_model->get_all_inv_by_id($id);

        // $datas["po_details"] = $po_details = $this->sales_return_model->get_all_inv_details_by_id($id);

        $datas["quotation"] = $quotation = $this->sales_return_model->get_all_invoice_by_id($id);

        $datas["in_words"] = $this->convert_number($datas["quotation"][0]['net_total']);

        $datas["quotation_details"] = $quotation_details = $this->sales_return_model->get_all_sr_details_by_id($id);

//        echo "<pre>";

//        print_r($datas);

//        exit;



        $datas['company_details'] = $this->project_cost_model->get_company_details_by_firm($id);

        //$datas['company_details'] = $this->admin_model->get_company_details();

        $this->template->write_view('content', 'sales_return_views', $datas);

        $this->template->render();

    }



    public function change_status($id, $status) {

        //echo $id; echo $status; exit;

        $this->sales_return_model->change_po_status($id, $status);

        redirect($this->config->item('base_url') . 'sales_return/sales_return_list');

    }



    public function sales_return_list() {



    }



    public function get_customer() {

        $atten_inputs = $this->input->get();

        $data = $this->sales_return_model->get_customer($atten_inputs);

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

        $data_customer["customer_details"] = $this->sales_return_model->get_customer_by_id($input['id']);

        echo json_encode($data_customer);

        exit;

    }



    public function get_product() {

        $atten_inputs = $this->input->get();

        $product_data = $this->sales_return_model->get_product($atten_inputs);



        echo '<ul id="product-list">';

        if (isset($product_data) && !empty($product_data)) {

            foreach ($product_data as $st_rlno) {

                if ($st_rlno['model_no'] != '')

                    echo '<li class="pro_class" pro_cost="' . $st_rlno['cost_price'] . '" pro_type="' . $st_rlno['type'] . '" pro_id="' . $st_rlno['id'] . '" mod_no="' . $st_rlno['model_no'] . '" pro_name="' . $st_rlno['product_name'] . '" pro_description="' . $st_rlno['product_description'] . '" pro_image="' . $st_rlno['product_image'] . '">' . $st_rlno['model_no'] . '</li>';

            }

        }

        else {

            echo '<li style="color:red;">No Data Found</li>';

        }

        echo '</ul>';

    }



    public function get_product_by_id() {

        $input = $this->input->post();

        $data_customer["product_details"] = $this->sales_return_model->get_product_by_id($input['id']);

        echo json_encode($data_customer);

        exit;

    }



    public function po_edit($id) {

        $datas["po"] = $po = $this->sales_return_model->get_all_inv_by_id($id);

        $datas["po_details"] = $po_details = $this->sales_return_model->get_all_inv_details_by_id($id);

        $datas["category"] = $category = $this->categories_model->get_all_category();

        $datas["brand"] = $brand = $this->brand_model->get_brand();

        //$datas['company_details'] = $this->admin_model->get_company_details($id);



        $this->template->write_view('content', 'sales_return_edit', $datas);

        $this->template->render();

    }



    function stock_details($stock_info, $po_id) {



        $this->sales_return_model->check_stock($stock_info, $po_id);

    }



    public function update_po($id) {

        $input = $this->input->post();

        $firm_id = $input['po']['firm'];

        // $user_info= $this->user_info=$this->session->userdata('user_info');

        $user_info = $this->user_auth->get_from_session('user_info');

        $input['po']['created_by'] = $user_info[0]['id'];

        $input['po']['created_date'] = date('Y-m-d H:i:s');

        unset($input['po']['firm']);

        unset($input['po']['round_off']);

        unset($input['po']['transport']);

        unset($input['po']['labour']);

        $update = $this->sales_return_model->update_inv($input['po'], $id);

        //$input['po']['inv_id'] = $id;

        $input['po']['invoice_id'] = $id;



        $insert_id = $this->sales_return_model->insert_sr($input['po']);



        //$insert_id=1;

        if (isset($update) && !empty($update)) {

            $input = $this->input->post();

            if (isset($input['categoty']) && !empty($input['categoty'])) {

                $insert_arr1 = array();

                foreach ($input['categoty'] as $key => $val) {



                    $insert1['in_id'] = $id;

                    $insert1['q_id'] = $input['po']['q_id'];

                    $insert1['category'] = $val;

                    $insert1['product_id'] = $input['product_id'][$key];

                    $insert1['product_description'] = $input['product_description'][$key];

                    $insert1['brand'] = $input['brand'][$key];

                    $insert1['unit'] = $input['unit'][$key];

                    $insert1['quantity'] = $input['quantity'][$key] - $input['return_quantity'][$key];

                    $insert1['per_cost'] = $input['per_cost'][$key];

                    $insert1['tax'] = $input['tax'][$key];

                    $insert1['gst'] = $input['gst'][$key];

                    $insert1['igst'] = $input['igst'][$key];

                    $insert1['discount'] = $input['discount'][$key];

                    $insert1['sub_total'] = $input['sub_total'][$key];

                    $insert1['created_date'] = date('Y-m-d H:i');

                    $insert_arr1[] = $insert1;

                }

                //  echo "<pre>"; print_r($insert_arr1); exit;

                $this->sales_return_model->delete_inv_details($id);

                $this->sales_return_model->insert_inv_details($insert_arr1);

            }

        }

        if (isset($insert_id) && !empty($insert_id)) {

            $input = $this->input->post();

            if (isset($input['categoty']) && !empty($input['categoty'])) {

                //$this->sales_return_model->delete_sr_details($id);



                $insert_arr = array();



                foreach ($input['categoty'] as $key => $val) {



                    $insert['in_id'] = $id;

                    $insert['return_id'] = $insert_id;

                    $insert['q_id'] = $input['po']['q_id'];

                    $insert['category'] = $val;

                    $insert['product_id'] = $input['product_id'][$key];

                    $insert['product_description'] = $input['product_description'][$key];

                    $insert['brand'] = $input['brand'][$key];

                    $insert['unit'] = $input['unit'][$key];

                    $insert['return_quantity'] = $input['return_quantity'][$key];

                    $insert['per_cost'] = $input['per_cost'][$key];

                    $insert['tax'] = $input['tax'][$key];

                    $insert['gst'] = $input['gst'][$key];

                    $insert['igst'] = $input['igst'][$key];

                    $insert['discount'] = $input['discount'][$key];

                    $insert['sub_total'] = $input['sub_total'][$key];

                    $insert['created_date'] = date('Y-m-d H:i');

                    $insert_arr[] = $insert;

                    $stock_arr = array();

                    $po_id['inv_id'] = $input['po']['inv_id'];

                    $stock_arr[] = $po_id;

                    $insert['firm'] = $firm_id;

                    $this->stock_details($insert, $po_id);

                    unset($insert['firm']);

                }



                $this->sales_return_model->insert_sr_details($insert_arr);

            }

        }

        // $datas["po"]= $po =$this->purchase_return_model->get_all_po();

        redirect($this->config->item('base_url') . 'sales_return/index');

    }



    public function po_delete() {

        $id = $this->input->POST('value1');

        $datas["po"] = $po = $this->sales_return_model->get_all_po();

        $del_id = $this->sales_return_model->delete_po($id);

        redirect($this->config->item('base_url') . 'sales_return/sales_return_list', $datas);

    }



    public function history_view($id) {

        $datas["his_quo"] = $his_quo = $this->sales_return_model->all_history_quotations($id);

        $this->template->write_view('content', 'history_view', $datas);

        $this->template->render();

    }



    function clear_cache() {

        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");

        $this->output->set_header("Pragma: no-cache");

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



    // Newly Added..



    public function product_list() {



        $term = $this->input->post('term');





        $data = $this->product_model->product_list($term);

        echo '<ul id="country-list">';

        if (isset($data) && !empty($data)) {

            foreach ($data as $st_rlno) {

                if ($st_rlno['product_name'] != '')

                    echo '<li class="asset_name_auto" asset_id="' . $st_rlno['id'] . '" asset_name="' . $st_rlno['product_name'] . '" onClick=selectCountry(' . $st_rlno['id'] . ')>' . $st_rlno['product_name'] . '</li>';

            }

        }

        else {

            echo '<li style="color:red;">No Data Found</li>';

        }

        echo '</ul>';

    }



    public function clear_prodct_name_wise_filter() {

        $this->session->unset_userdata('product_name_wise');

        //echo "test  " . $this->session->userdata('product_name_wise');

        echo 1;

    }



    function ajaxList() {

        $search_data = $this->input->post();



        $search_arr = array();

        $filter = $this->session->userdata('product_name_wise');



        $search_arr['product_id'] = $filter['product_id'];

        //$search_arr['brand'] = $search_data['brand'];

        //$search_arr['product'] = $search_data['product'];

        //$search_arr['category'] = $search_data['category'];

        if (empty($search_arr)) {

            $search_arr = array();

        }

        $list = $this->sales_return_model->get_datatables($search_arr);

//        echo '<pre>';

//        print_r($list);

//        die;



        $data = array();

        $no = $_POST['start'];

        foreach ($list as $val) {

            $quotation = $this->sales_return_model->get_all_invoice_by_id($val['id']);

            $quotation_details = $this->sales_return_model->get_all_sr_details_by_id($val['id']);

            $cgst = 0;

            $sgst = 0;

            $ret_qty = 0;

            $net_value = 0;

            $rtn_amt = 0;

            if (isset($quotation_details) && !empty($quotation_details)) {

                foreach ($quotation_details as $vals) {

                    $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['return_quantity']);

                    $gst_type = $quotation[0]['state_id'];

                    if ($gst_type != '') {

                        if ($gst_type == 31) {



                            $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['return_quantity']);

                        } else {

                            $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * $vals['return_quantity']);

                        }

                    }



                    $cgst += $cgst1;

                    $sgst += $sgst1;

                    $net_value += $vals['return_quantity'] * $vals['per_cost'];

                }

            }





            $invoice_url = $views_url = $bill_copy_url = $url = $alert = $url1 = $alert1 = $total_qty = $action_url = "";



            if ($val['return'][0]['id'] != $val['return'][1]['id']) {

                if ($this->user_auth->is_action_allowed('sales', 'sales_return', 'view')) {

                    $url = $this->config->item('base_url') . 'sales_return/invoice_views/' . $val['id'];

                }

                if (!$this->user_auth->is_action_allowed('sales', 'sales_return', 'view')) {

                    $alert = 'alerts';

                }

                $invoice_url = '<a href="' . $url . '" data-toggle="tooltip" class="tooltips btn btn-default  btn-xs ' . $alert . '" title="" data-original-title="View">' . $val['inv_id'] . '</a>';

            } else {

                $invoice_url = '<td class="action-btn-align">' . $val['inv_id'] . '</td>';

            }



            if (($val['return'][0]['id'] != $val['return'][1]['id'])) {

                $total_qty = '<td class="action-btn-align">' . $val['return'][1]['total_qty'] . '</td><td class="action-btn-align">' . ($val['return'][1]['total_qty']) - ($val['return'][0]['total_qty']) . '</td>';

            } else {

                $total_qty = '<td class="action-btn-align">' . $val['total_qty'] . ' </td><td></td>';

            }

            if ($this->user_auth->is_action_allowed('sales', 'sales_return', 'edit')) {

                $url1 = $this->config->item('base_url') . 'sales_return/po_edit/' . $val['id'];

            }

            if (!$this->user_auth->is_action_allowed('sales', 'sales_return', 'edit')) {

                $alert1 = 'alerts';

            }

            $action_url = '<a href="' . $url1 . '" data-toggle="tooltip" class="tooltips btn btn-info btn-xs ' . $alert1 . '" title="" data-original-title="Edit"><span>Make Return</span></a>';



            if ($val['return'][0]['id'] != $val['return'][1]['id']) {

                if ($this->user_auth->is_action_allowed('sales', 'sales_return', 'view')) {

                    $url2 = $this->config->item('base_url') . 'sales_return/invoice_view/' . $val['id'];

                }

                if (!$this->user_auth->is_action_allowed('sales', 'sales_return', 'view')) {

                    $alert2 = 'alerts';

                }

                $views_url = '<a href="' . $url2 . '" data-toggle="tooltip" class="tooltips btn btn-default  btn-xs ' . $alert2 . '" title="" data-original-title="View"><span class="fa fa-eye"></span></a>';

                //$bill_copy_url = '<a href="' . $this->config->item('base_url') . 'sales_return/return_bill_copy/' . $val['id'] . '" data-toggle="tooltip" class="tooltips btn btn-default  btn-xs ' . $alert2 . '" title="" data-original-title="View"><span>Return Copy</span></a>';

            }





            $no++;

            $row = array();
            if(number_format($val['return'][1]['net_total'], 2) > 0){
            $row[] = $no;

            //$row[] = $ass->firm_name;

            $row[] = $val['inv_id'];

            $row[] = $val['store_name'];

            if ($val['return'][0]['id'] != $val['return'][1]['id']) {

                $row[] = $val['delivery_qty'];

                $row[] = number_format($val['return'][1]['net_total'], 2);

                $row[] = ($val['return'][1]['total_qty']) - ($val['return'][0]['total_qty']);

                $rtn_amt = number_format(($val['return'][1]['net_total'] - $val['return'][0]['net_total']), 2);

                $row[] = str_replace("-", "", $rtn_amt);

            } else {

                $row[] = $val['delivery_qty'];

                $row[] = number_format($val['return'][1]['net_total'], 2);

                $row[] = '';

                $row[] = number_format(($val['return'][1]['net_total'] - $val['return'][0]['net_total']), 2);

            }

            //$row[] = $val['total_qty'];

            //$row[] = number_format($val['net_total'], 2);

            $row[] = $action_url . ' ' . $views_url;





            $data[] = $row;

        }
    }

        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->sales_return_model->count_all(),

            "recordsFiltered" => $this->sales_return_model->count_filtered($search_arr),

            "data" => $data,

        );



        echo json_encode($output);

        exit;

    }



    public function sales_return_bill($id) {

        // $datas["quotation"] = $quotation = $this->sales_return_model->get_all_inv_by_id($id);

        // $datas["quotation_details"] = $quotation_details = $this->sales_return_model->get_all_sr_details_by_id($id);

        $datas["quotation"] = $quotation = $this->sales_return_model->get_all_inv_by_id($id);

        $datas["quotation_details"] = $quotation_details = $this->sales_return_model->get_all_inv_details_by_id($id);

        $datas["category"] = $category = $this->categories_model->get_all_category();

        $datas["brand"] = $brand = $this->brand_model->get_brand();

        $datas["in_words"] = $this->convert_number($datas["quotation"][0]['net_total']);

        $datas['company_details'] = $this->project_cost_model->get_company_details_by_firm($id);



        $this->template->write_view('content', 'sales_return_bill', $datas);

        $this->template->render();

    }



}

