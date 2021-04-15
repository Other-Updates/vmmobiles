<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Report extends MX_Controller {



    function __construct() {

        parent::__construct();

        $this->clear_cache();


        if (!$this->user_auth->is_logged_in()) {


            redirect($this->config->item('base_url') . 'admin');

        }

        $main_module = 'report';

        $access_arr = array(

            'report/cashinhand' => array('add', 'edit', 'delete', 'view'),

            'report/search_cahsinhand' => array('add', 'edit', 'delete', 'view'),

            'report/conversion_list' => 'no_restriction',

            'report/search_conversion_list' => array('add', 'edit', 'delete', 'view'),

            'report/profit_list' => 'no_restriction',

            'report/search_profit_list' => 'no_restriction',

            'report/quotation_report' => 'no_restriction',

            'report/quotation_search_result' => 'no_restriction',

            'report/purchase_report' => 'no_restriction',

            'report/purchase_search_result' => 'no_restriction',

            'report/purchase_receipt' => 'no_restriction',

            'report/payment_receipt' => 'no_restriction',

            'report/payment_receipt_search_result' => 'no_restriction',

            'report/purchase_receipt_search_result' => 'no_restriction',

            'report/stock_report' => 'no_restriction',

            'report/stock_search_result' => 'no_restriction',

            'report/pc_report' => 'no_restriction',

            'report/pc_search_result' => 'no_restriction',

            'report/invoice_report' => 'no_restriction',

            'report/invoice_search_result' => 'no_restriction',

            'report/hr_invoice_report' => 'no_restriction',

            'report/hr_invoice_search_result' => 'no_restriction',

            'report/customer_based_report' => 'no_restriction',

            'report/ajaxList' => 'no_restriction',

            'report/customer_invoice_search_result' => 'no_restriction',

            'report/shelf_life_report' => 'no_restriction',

            'report/shelf_life_search_result' => 'no_restriction',

            'report/outstanding_report_due_date' => 'no_restriction',

            'report/outstanding_report_due_date_search_result' => 'no_restriction',

            'report/outstanding_report_due_date_result' => 'no_restriction',

            'report/outstanding_report_firm' => 'no_restriction',

            'report/outstanding_report_firm_wise_search_result' => 'no_restriction',

            'report/clear_cache' => 'no_restriction',

            'report/profit_ajaxList' => 'no_restriction',

            'report/outstanding_ajaxList' => 'no_restriction',

            'report/outstanding_duedate_ajaxList' => 'no_restriction',

            'report/payment_ajaxList' => 'no_restriction',

            'report/customer_based_ajaxList' => 'no_restriction',

            'report/invoice_ajaxList' => 'no_restriction',

            'report/hr_invoice_ajaxList' => 'no_restriction',

            'report/pc_ajaxList' => 'no_restriction',

            'report/purchase_receipt_ajaxList' => 'no_restriction',

            'report/purchase_report_ajaxList' => 'no_restriction',

            'report/quotation_report_ajaxList' => 'no_restriction',

            'report/gst_report' => 'no_restriction',

            'report/getall_gst_entries' => 'no_restriction',

            'report/gst_report_ajaxList' => 'no_restriction',

            'report/invoice_gst_search_result' => 'no_restriction',

            'report/gst_report_pdf' => 'no_restriction',

            'report/attendance_report' => 'no_restriction',

            'report/customer_excel_report' => 'no_restriction',

            'report/pr_excel_report' => 'no_restriction',

            'report/hr_excel_report' => 'no_restriction',

            'report/inv_excel_report' => 'no_restriction',

            'report/outstanding_excel_report' => 'no_restriction',

            'report/outstanding_due_date_excel_report' => 'no_restriction',

            'report/outstanding_firmwise_excel_report' => 'no_restriction',

            'report/profit_excel_report' => 'no_restriction',

            'report/customer_receipt_view' => 'no_restriction',

        );



        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {

            $this->user_auth->is_permission_allowed();

            redirect($this->config->item('base_url'));

        }



        $this->load->helper('form');

        $this->load->helper('url');

        $this->load->library('session');

        $this->load->library('email');

        $this->load->database();

        $this->load->model('quotation/gen_model');

        $this->load->library('form_validation');

        $this->load->model('purchase_order/purchase_order_model');

        $this->load->model('stock/stock_model');

        $this->load->model('master_category/master_category_model');

        $this->load->model('masters/product_model');

        $this->load->model('master_brand/master_brand_model');

        $this->load->model('customer/agent_model');

        $this->load->model('sales/project_cost_model');

        $this->load->model('admin/admin_model');

        $this->load->model('report_model');

        $this->load->model('agent/agent_model');

        $this->load->model('masters/sales_man_model');

        $this->load->model('masters/customer_model');

        $this->load->model('masters/categories_model');

        $this->load->model('masters/brand_model');

    }



    function cashinhand() {

        $this->load->model('sales_receipt/sales_receipt_model');

        $data['all_agent'] = $this->agent_model->get_agent();

        $data['amount'] = $this->receipt_model->get_all_amount();

        // $data['company_amount'] =$this->admin_model->get_company_amount();

        $data['credit'] = $this->admin_model->amount_credit();

        $data['debit'] = $this->admin_model->amount_debit();

        $data['company_amount'] = $data['credit'][0]['credit'] - $data['debit'][0]['debit'];

        $this->template->write_view('content', 'cashinhand', $data);

        $this->template->render();

    }


     function customer_receipt_view($r_id) {

        $this->load->model('sales_receipt/sales_receipt_model');

        $this->load->model('purchase_order/purchase_order_model');



        if ($this->input->post()) {

            $input = $this->input->post();

            if ($input['balance'] == 0 || $input['balance'] == 0.00 || $input['balance'] == '0.00')

                $receipt_status = 'Completed';

            else

                $receipt_status = 'Pending';



            $this->sales_receipt_model->update_invoice(array('payment_status' => $receipt_status), $input['receipt_bill']['receipt_id']);

            $this->sales_receipt_model->insert_receipt_bill($input['receipt_bill']);

            redirect($this->config->item('base_url') . 'sales_receipt/receipt_list');

        }

        $data['all_agent'] = $this->agent_model->get_agent();

        $data['receipt_details'] = $this->sales_receipt_model->get_receipt_by_id($r_id);

        $firm_id = $data['receipt_details'][0]['firm_id'];

        $data['company_details'] = $this->purchase_order_model->get_company_details_by_firmid($firm_id);

        $this->template->write_view('content', 'sales_receipt/view_receipt', $data);

        $this->template->render();

    }

    function search_cahsinhand() {

        $this->load->model('agent/agent_model');

        $this->load->model('sales_receipt/sales_receipt_model');

        // $data['company_amount'] =$this->admin_model->get_company_amount();

        $search_data = $this->input->get();

        // echo"<pre>"; print_r($search_data); exit;

        if (isset($search_data['agent']) && !empty($search_data['agent']) && $search_data['agent'] != 'Select' && $search_data['cah_option'] == 'agent') {

            $data['credit'] = $this->admin_model->amount_credit_agent($search_data['agent']);

            $data['debit'] = $this->admin_model->amount_debit_agent($search_data['agent']);

            $data['company_amount'] = $data['credit'][0]['credit'] - $data['debit'][0]['debit'];

            $data['search_data'] = $search_data;

            $data['amount'] = $this->receipt_model->get_all_receipt_cash($search_data);

            $this->load->view('report/search_cashinhand', $data);

        }

        if ($search_data['agent'] == 'Select') {

            $data['credit'] = $this->admin_model->amount_credit_agent_all();

            $data['debit'] = $this->admin_model->amount_debit_agent_all();



            $data['company_amount'] = $data['credit'][0]['credit'] - $data['debit'][0]['debit'];



            $data['search_data'] = $search_data;

            $data['amount'] = $this->receipt_model->get_all_receipt_cash($search_data);

            $this->load->view('report/search_cashinhand', $data);

        }

        if ($search_data['cah_option'] == 'company' && $search_data['agent'] == 'Select') {

            $this->load->model('sales_receipt/sales_receipt_model');

            $data['all_agent'] = $this->agent_model->get_agent();

            $data['amount'] = $this->receipt_model->get_all_amount();

            // $data['company_amount'] =$this->admin_model->get_company_amount();

            $data['credit'] = $this->admin_model->amount_credit();

            $data['debit'] = $this->admin_model->amount_debit();

            $data['company_amount'] = $data['credit'][0]['credit'] - $data['debit'][0]['debit'];

            $this->load->view('report/search_cashinhand_company', $data);

        }

    }



    public function conversion_list() {

        $this->load->model('sales/project_cost_model');

        $datas["quotation"] = $quotation = $this->report_model->get_all_quotation_report();

        $datas["quotation"][0]['percentage'] = ($datas["quotation"][0]['pc_total'][0]['id'] / $datas["quotation"][0]['quo_total'][0]['id']) * 100;



        $this->template->write_view('content', 'report/conversion_list', $datas);

        $this->template->render();

    }



    public function shelf_life_report() {

        $data["category"] = $details = $this->categories_model->get_all_category();

        $data["brand"] = $this->brand_model->get_brand();

        $data['firms'] = $firms = $this->user_auth->get_user_firms();

        $data['all_product'] = $this->report_model->get_all_expired_product();

        $this->template->write_view('content', 'report/shelf_life_report', $data);

        $this->template->render();

    }



    public function shelf_life_search_result() {

        $search_data = $this->input->get();

        $data['search_data'] = $search_data;

        $data["category"] = $details = $this->categories_model->get_all_category();

        $data["brand"] = $this->brand_model->get_brand();

        $data['firms'] = $firms = $this->user_auth->get_user_firms();

        $data['all_product'] = $this->report_model->get_all_expired_product($search_data);

        $this->load->view('report/shelf_life_search_list', $data);

    }



    public function search_conversion_list() {

        $this->load->model('sales/project_cost_model');

        $search_data = $this->input->get();

        $data['search_data'] = $search_data;

        $datas["quotation"] = $quotation = $this->report_model->get_all_quotation_report($search_data);

        $datas["quotation"][0]['percentage'] = ($datas["quotation"][0]['count'] / $datas["quotation"][0]['count']) * 100;

        // echo"<pre>"; print_r($datas); exit;

        $datas['company_details'] = $this->admin_model->get_company_details();

        $this->load->view('report/search_conversion_list', $datas);

    }



    public function profit_list() {

        $datas = array();

        $this->load->model('sales/project_cost_model');

        //$datas["quotation"] = $quotation = $this->report_model->get_all_profit_report();

        //$datas['company_details'] = $this->admin_model->get_company_details();

//        echo"<pre>";

//        print_r($datas);

//        exit;

        $datas['firm_list'] = $this->report_model->get_all_firms();


        $this->template->write_view('content', 'report/profit_list', $datas);

        $this->template->render();

    }



    public function search_profit_list() {

        $this->load->model('sales/project_cost_model');

        $search_data = $this->input->get();

        $data['search_data'] = $search_data;

        $datas["quotation"] = $quotation = $this->report_model->get_all_profit_report($search_data);


        $datas['company_details'] = $this->admin_model->get_company_details();

        $this->load->view('report/search_profit_list', $datas);

    }



    function quotation_report() {

        $data['all_style'] = $this->gen_model->get_all_quotation_no();

        $data['all_supplier'] = $this->gen_model->get_all_customer_quotation();

        $data['all_product'] = $this->gen_model->get_all_product_quotation();

        //$data['quotation'] = $this->gen_model->get_all_quotation_for_quotation_report();

        $this->template->write_view('content', 'report/quotation_list', $data);

        $this->template->render();

    }



    public function quotation_search_result() {

        $search_data = $this->input->get();

        $data['search_data'] = $search_data;

        $data['quotation'] = $this->gen_model->get_all_quotation($search_data);

        $this->load->view('report/search_quotation_list', $data);

    }



    function purchase_report() {

        $data['all_style'] = $this->purchase_order_model->get_all_po();

        $data['all_supplier'] = $this->purchase_order_model->get_all_supplier_po();

        $data['all_product'] = $this->purchase_order_model->get_all_product_po();

        $data['firm_list'] = $this->report_model->get_all_firms();

        //$data['po'] = $this->purchase_order_model->get_all_purchase_order();



        $this->template->write_view('content', 'report/purchase_order_list', $data);

        $this->template->render();

    }



    public function purchase_search_result() {

        $search_data = $this->input->get();

        $data['search_data'] = $search_data;

        $data['po'] = $this->purchase_order_model->get_all_po($search_data);

        $this->load->view('report/search_purchase_order_list', $data);

    }



    function purchase_receipt() {

        $this->load->model('purchase_receipt/receipt_model');

        $data['all_style'] = $this->receipt_model->get_all_receipt();

        $data['all_supplier'] = $this->purchase_order_model->get_all_supplier_po();

        //$data['all_receipt'] = $this->receipt_model->get_all_purchase_receipt();

        $this->template->write_view('content', 'report/receipt_list', $data);

        $this->template->render();

    }



//    function outstanding_report_due_date() {

//        $this->load->model('sales_receipt/sales_receipt_model');

//        //$data['all_style'] = $this->report_model->outstanding_report();

//        $data['all_supplier'] = $this->report_model->get_all_supplier();

//        //$data['all_receipt'] = $this->report_model->outstanding_report();

////        echo '<pre>';

////        print_r($data['all_receipt']);

////        exit;

//        $data['firms'] = $firms = $this->user_auth->get_user_firms();

//        $this->template->write_view('content', 'report/payment_receipt_list', $data);

//        $this->template->render();

//    }

    function payment_receipt() {

        $this->load->model('sales_receipt/sales_receipt_model');

        //$data['all_style'] = $this->report_model->outstanding_report();

        $data['all_supplier'] = $this->report_model->get_all_supplier();

        //$data['all_receipt'] = $this->report_model->outstanding_report();

//        echo '<pre>';

//        print_r($data['all_receipt']);

//        exit;

        $data['firms'] = $firms = $this->user_auth->get_user_firms();

        $this->template->write_view('content', 'report/payment_receipt_list', $data);

        $this->template->render();

    }



    public function payment_receipt_search_result() {

        $search_data = $this->input->get();

        $data['search_data'] = $search_data;

//        echo '<pre>';

//        print_r($search_data);

//        exit;

        $this->load->model('sales_receipt/sales_receipt_model');

        $data['all_receipt'] = $this->report_model->outstanding_report($search_data);

        $this->load->view('report/search_payment_receipt_list', $data);

    }



    public function purchase_receipt_search_result() {

        $search_data = $this->input->get();

        $data['search_data'] = $search_data;

        $this->load->model('purchase_receipt/receipt_model');

        $data['all_receipt'] = $this->receipt_model->get_all_receipt($search_data);

        $this->load->view('report/search_purchase_receipt_list', $data);

    }



    function stock_report() {

        $data['product'] = $this->product_model->get_product();

        $data['brand'] = $this->master_brand_model->get_brand();

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

         

        $data['cat'] = $this->master_category_model->get_category_by_firm($frim_id);

      //  $data['cat'] = $this->master_category_model->get_all_category();

        $data['firm_list'] = $this->report_model->get_all_firms();

       // $data['cat_list'] = $this->report_model->get_all_category();

        //echo"<pre>"; print_r($data); exit;

        //$data['stock'] = $this->stock_model->get_all_stock();

        $this->template->write_view('content', 'report/stock_list', $data);

        $this->template->render();

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



    function pc_report() {



        $data['all_style'] = $this->project_cost_model->get_all_project_cost();

        $data['all_supplier'] = $this->project_cost_model->get_all_customer_pc();

        $data['all_product'] = $this->project_cost_model->get_all_product_pc();

        //$data['quotation'] = $this->project_cost_model->get_all_pc();

        $this->template->write_view('content', 'report/pc_list', $data);

        $this->template->render();

    }



    public function pc_search_result() {

        $search_data = $this->input->get();

        $data['search_data'] = $search_data;

        $data['quotation'] = $this->project_cost_model->get_all_project_cost($search_data);

        $this->load->view('report/pc_search_list', $data);

    }



    function invoice_report() {



        $data['all_style'] = $this->report_model->get_all_invoice();

        // $data['all_supplier'] = $this->project_cost_model->get_all_customer_invoice();

        $data['all_supplier'] = $this->project_cost_model->get_all_customer();

        //$data['quotation'] = $this->project_cost_model->get_invoice();

        $data["sales_man_list"] = $this->sales_man_model->get_sales_man();

        //$data['all_product'] = $this->report_model->get_all_product_invoice();

        $data['all_product'] = $this->report_model->get_all_product();

        $data['firm_list'] = $this->report_model->get_all_firms();

        $all_gst = $this->report_model->get_all_gstvalues();

        $gst = array();

        $data['all_gst'] = array();

        if (!empty($all_gst)) {



            $data['all_gst'] = $all_gst;

        }



        $this->template->write_view('content', 'report/invoice_list', $data);

        $this->template->render();

    }



    function gst_report() {



        $data['all_style'] = $this->report_model->get_all_invoice();

        // $data['all_supplier'] = $this->project_cost_model->get_all_customer_invoice();

        $data['all_supplier'] = $this->project_cost_model->get_all_customer();

        //$data['quotation'] = $this->project_cost_model->get_invoice();

        $data["sales_man_list"] = $this->sales_man_model->get_sales_man();

        //$data['all_product'] = $this->report_model->get_all_product_invoice();

        $data['all_product'] = $this->report_model->get_all_product();

        $data['firms'] = $firms = $this->user_auth->get_user_firms();



        $all_gst = $this->report_model->get_all_gstvalues();

        $gst = array();

        $data['all_gst'] = array();

        if (!empty($all_gst)) {



            $data['all_gst'] = $all_gst;

        }

        $this->template->write_view('content', 'report/invoice_gst_list', $data);

        $this->template->render();

    }



    public function gst_report_pdf() {



        //$data["quotation"] = $this->session->userdata('gst_report');



        $inv_id = $this->session->userdata('gst_report');

        $search_arr = array();

        $search_arr['inv_id'] = $inv_id;

        $data["quotation"] = $this->project_cost_model->get_gst_invoice($search_arr);



        //$datas['company_details'] = $this->project_cost_model->get_company_details_by_firm($inv_id);

        $this->load->library("Pdf");

        $header = $this->load->view('report/pdf_header_view', $datas, TRUE);



        $msg = $this->load->view('report/customer_receipt_pdf', $data, TRUE);

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->AddPage('p', 'A5');



        $pdf->SetTitle('GST Return Report');

        $pdf->Header($header);

        $pdf->writeHTMLCell(0, 0, '', '', $msg, 0, 1, 0, true, '', true);

        $filename = 'GST Return Report-' . date('d-M-Y-H-i-s') . '.pdf';

        $newFile = $this->config->item('theme_path') . 'attachement/' . $filename;

        $pdf->Output($newFile);

    }



    public function invoice_search_result() {

        $search_data = $this->input->get();

        $data['search_data'] = $search_data;

        $data['quotation'] = $this->project_cost_model->get_invoice($search_data);

        $this->load->view('report/invoice_search_list', $data);

    }



    public function invoice_gst_search_result() {

        $search_data = $this->input->get();



        $data['search_data'] = $search_data;



        $data['quotation'] = $this->project_cost_model->get_gst_invoice($search_data);



        $list_array = array();

        $this->load->library('session');

        $list = array();

        foreach ($data['quotation'] as $key => $val) {

            if ($key <= 49) {

                $list[] = $val['id'];

            }

        }

        $session_array = array('gst_report' => '');

        $this->session->set_userdata($session_array);

        $session_array = array('gst_report' => $list);

        $this->session->set_userdata($session_array);

        $this->load->view('report/invoice_gst_search_list', $data);

    }



    public function customer_invoice_search_result() {

        $search_data = $this->input->post();

        $data['search_data'] = $search_data;

        //echo "<pre>"; print_r($search_data); exit;

        //$data['quotation'] = $this->project_cost_model->get_all_customer_invoice($search_data);

        $data['quotation'] = $this->report_model->get_customer_based_datatables($search_data);

        $this->load->view('report/customer_invoice_search_list', $data);

    }



    function hr_invoice_report() {



        $data['all_style'] = $this->report_model->get_invoice();

        $data['all_supplier'] = $this->report_model->get_all_hr_customer_invoice();

        $data['all_product'] = $this->report_model->get_all_product_invoice();

        //$data['quotation'] = $this->report_model->get_invoice();

        //echo "<pre>";

        // print_r($data);

        // exit;

        $this->template->write_view('content', 'report/hr_invoice_list', $data);

        $this->template->render();

    }



    public function hr_invoice_search_result() {

        $search_data = $this->input->get();

        $data['search_data'] = $search_data;

        $data['quotation'] = $this->report_model->get_invoice($search_data);

        $this->load->view('report/hr_invoice_search_list', $data);

    }



    function customer_based_report() {

        //$data['all_style'] = $this->project_cost_model->get_invoice();

        //$data['all_supplier'] = $this->report_model->get_all_customer();

        $data['all_receipt'] = $this->project_cost_model->get_all_customer_invoice();

        //$data["sales_man_list"] = $this->sales_man_model->get_sales_man();

        $data['all_product'] = $this->report_model->get_all_product_invoice();

       //echo "<pre>";print_r($data);exit;

        $data['frim_list'] = $this->report_model->get_all_firms();

         $data['customer_list'] = $this->report_model->get_all_customers();

          $data['product_list'] = $this->report_model->get_all_products();

        $this->template->write_view('content', 'report/customer_report', $data);

        $this->template->render();

    }



    function ajaxList() {

        $search_data = $this->input->post();

        $search_arr = array();

        $search_arr['category'] = $search_data['category'];

        $search_arr['brand'] = $search_data['brand'];

        $search_arr['product'] = $search_data['product'];

        $search_arr['firm_id'] = $search_data['firm_id'];

        if (empty($search_arr)) {

            $search_arr = array();

        }

        $list = $this->report_model->get_datatables($search_arr);

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

            $row[] = $ass->categoryName;

             $row[] = $ass->product_name;

            $row[] = $ass->brands;

           

            $row[] = $ass->quantity;



            $data[] = $row;

        }

        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->report_model->count_all(),

            "recordsFiltered" => $this->report_model->count_filtered($search_data),

            "data" => $data,

        );

        echo json_encode($output);

        exit;

    }



    function profit_excel_report() {



        if (isset($_GET) && $_GET['search'] != '') {

            $search = $_GET['search'];

        } else {

            $search = '';

        }

        $json = json_decode($search);



        $profit = $this->report_model->get_all_profit_report_for_excel($json);



        $this->export_all_profit_csv($profit);

    }



    function export_all_profit_csv($query, $timezones = array()) {



        // output headers so that the file is downloaded rather than displayed

        header('Content-Type: text/csv; charset=utf-8');

        header('Content-Disposition: attachment; filename=Profit and Loss Report.csv');



        // create a file pointer connected to the output stream

        $output = fopen('php://output', 'w');



        // output the column headings

        //Order has been changes

        fputcsv($output, array('S.No', 'Customer Name', 'Invoice No', 'Invoice Date', 'Invoice Amount', 'Commission Amount', 'Original Amount', 'Profit', 'Profit Amount'));



        // fetch the data

        //$rows = mysql_query($query);

        // loop over the rows, outputting them

        $i = 1;

        $cgst = 0;

        $sgst = 0;

        foreach ($query as $key => $val) {

            $net_total = $val['net_total'];

            if ($val->advance != '') {

                $net_total = $val['net_total'] - $val['advance'];

            }

            $invoice_total = $val['subtotal_qty'] + $val['transport'] + $val['labour'];



            if (isset($val['or_amount']) && !empty($val['or_amount'])) {

                if (isset($val['or_amount']) && !empty($val['or_amount'])) {

                    $j = 0;

                    $cgst = 0;

                    $sgst = 0;

                    $p = 0;

                    foreach ($val['or_amount'] as $vals) {



                        $p1 = $vals['cost_price'] * $vals['quantity'];



                        $cgst1 = ($vals['tax'] / 100 ) * ($vals['cost_price'] * $vals['quantity']);



                        $gst_type = $quotation[0]['state_id'];

                        if ($gst_type != '') {

                            if ($gst_type == 31) {



                                $sgst1 = ($vals['gst'] / 100 ) * ($vals['cost_price'] * $vals['quantity']);

                            } else {

                                $sgst1 = ($vals['igst'] / 100 ) * ($vals['cost_price'] * $vals['quantity']);

                            }

                        }

                        $p += $p1;

                    }

                    $j++;

                }

                $org_price = (($p + $cgst + $sgst + $val['transport'] + $val['labour']));



                $price = (($invoice_total - $val['commission_rate']) - $p) / $invoice_total;

                $profit_per = $price * 100;

                //echo ($profit_per > 0 && !empty($p)) ? number_format($profit_per) . '%' : '0' . '%';



                $total_cost_price = number_format((($invoice_total - $val['commission_rate']) - $p), 2, '.', ',');

            }

            $i++;



            $row = array($key + 1, ($val['store_name']) ? $val['store_name'] : $val['name'], $val['inv_id'], ($val['created_date'] != '' && $val['created_date'] != '0000-00-00') ? date('d-M-Y', strtotime($val['created_date'])) : '-', ($invoice_total > 0 ) ? number_format($invoice_total, 2) : '0', $val['commission_rate'], number_format($p, 2), ($profit_per > 0 && !empty($p)) ? number_format($profit_per) . '%' : '0' . '%', ($total_cost_price > 0 && !empty($p) ) ? $total_cost_price : '0');

            //echo "<pre>";print_r($row);exit;

            fputcsv($output, $row);

        }

        exit;

    }



    function profit_ajaxList() {

        $search_data = $this->input->post();

        $search_arr = array();

        $search_arr['from_date'] = $search_data['from_date'];

        //$search_arr['brand'] = $search_data['brand'];

        $search_arr['to_date'] = $search_data['to_date'];


          $search_arr['firm_id'] = $search_data['firm_id'];

        //$search_arr['category'] = $search_data['category'];

        if (empty($search_arr)) {

            $search_arr = array();

        }

        $list = $this->report_model->get_profit_datatables($search_arr);

        $data = array();

        $no = $_POST['start'];

        $i = 1;

        $cgst = 0;

        $sgst = 0;

        foreach ($list as $val) {

            $net_total = $val['net_total'];

            if ($val->advance != '') {

                $net_total = $val['net_total'] - $val['advance'];

            }

            $invoice_total = $val['subtotal_qty'] + $val['transport'] + $val['labour'];

            ?>



            <?php



            if (isset($val['or_amount']) && !empty($val['or_amount'])) {

                if (isset($val['or_amount']) && !empty($val['or_amount'])) {

                    $j = 0;

                    $cgst = 0;

                    $sgst = 0;

                    $p = 0;

                    foreach ($val['or_amount'] as $vals) {



                        $p1 = $vals['cost_price'] * $vals['quantity'];



                        $cgst1 = ($vals['tax'] / 100 ) * ($vals['cost_price'] * $vals['quantity']);



                        $gst_type = $quotation[0]['state_id'];

                        if ($gst_type != '') {

                            if ($gst_type == 31) {



                                $sgst1 = ($vals['gst'] / 100 ) * ($vals['cost_price'] * $vals['quantity']);

                            } else {

                                $sgst1 = ($vals['igst'] / 100 ) * ($vals['cost_price'] * $vals['quantity']);

                            }

                        }

                        $p += $p1;

                    }

                    $j++;

                }

                $org_price = (($p + $cgst + $sgst + $val['transport'] + $val['labour']));



                $price = (($invoice_total - $val['commission_rate']) - $p) / $invoice_total;

                $profit_per = $price * 100;

                //echo ($profit_per > 0 && !empty($p)) ? number_format($profit_per) . '%' : '0' . '%';



                $total_cost_price = number_format((($invoice_total - $val['commission_rate']) - $p), 2, '.', ',');

                ?>

                <?php



            }

            $i++;





            $no++;

            $row = array();

            $row[] = $no;

            //$row[] = $ass->firm_name;

            $row[] = ($val['store_name']) ? $val['store_name'] : $val['name'];

            $row[] = $val['inv_id'];

            $row[] = ($val['created_date'] != '' && $val['created_date'] != '0000-00-00') ? date('d-M-Y', strtotime($val['created_date'])) : '-';

            $row[] = ($invoice_total > 0 ) ? number_format($invoice_total, 2) : '0';

            $row[] = $val['commission_rate'];

            $row[] = number_format($p, 2);

            $row[] = ($profit_per > 0 && !empty($p)) ? number_format($profit_per) . '%' : '0' . '%';

            $row[] = ($total_cost_price > 0 && !empty($p) ) ? $total_cost_price : '0';



            $data[] = $row;

        }

        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->report_model->count_all_profit(),

            "recordsFiltered" => $this->report_model->count_filtered_profit(),

            "data" => $data,

        );

        echo json_encode($output);

        exit;

    }



    function outstanding_firmwise_excel_report() {



        if (isset($_GET) && $_GET['search'] != '') {

            $search = $_GET['search'];

        } else {

            $search = '';

        }

        $json = json_decode($search);



        $firmwise = $this->report_model->get_customer_details_firm_wise_report($json);



        $this->export_all_firmwise_csv($firmwise);

    }



    function export_all_firmwise_csv($query, $timezones = array()) {



        // output headers so that the file is downloaded rather than displayed

        header('Content-Type: text/csv; charset=utf-8');

        header('Content-Disposition: attachment; filename=Outstanding Report-Firm Wise.csv');



        // create a file pointer connected to the output stream

        $output = fopen('php://output', 'w');



        // output the column headings

        //Order has been changes

        fputcsv($output, array('S.No', 'Customer Name', 'Mobile', 'Electrical', 'Paint', 'Tile', 'Hardware', 'Net Balance'));



        // fetch the data

        //$rows = mysql_query($query);

        // loop over the rows, outputting them

        foreach ($query as $key => $customer) {

            if ($customer['firm_id'] == 1)

                $electricals = ($electricals + ($customer['net_total'] - ($customer['electricals'] + $customer['advance'])));

            if ($customer['firm_id'] == 2)

                $paints = ($paints + ($customer['net_total'] - ($customer['paints'] + $customer['advance'])));

            if ($customer['firm_id'] == 3)

                $tiles = ($tiles + ($customer['net_total'] - ($customer['tiles'] + $customer['advance'])));

            if ($customer['firm_id'] == 4)

                $hardware = ($hardware + ($customer['net_total'] - ($customer['hardware'] + $customer['advance'])));



            $net_amount = $net_amount + ($customer['net_total'] - ($customer['net_amount'] + $customer['advance']));



            $row = array($key + 1, ($customer['store_name']) ? $customer['store_name'] : $customer['name'], $customer['mobil_number'], ($customer['firm_id'] == 1) ? number_format($customer['net_total'] - ($customer['electricals'] + $customer['advance']), 2) : '0', ($customer['firm_id'] == 2) ? number_format($customer['net_total'] - ($customer['paints'] + $customer['advance']), 2) : '0', ($customer['firm_id'] == 3) ? number_format($customer['net_total'] - ($customer['tiles'] + $customer['advance']), 2) : '0', ($customer['firm_id'] == 4) ? number_format($customer['net_total'] - ($customer['hardware'] + $customer['advance']), 2) : '0', ($customer['net_total'] != '') ? number_format($customer['net_total'] - ($customer['net_amount'] + $customer['advance']), 2) : '0');

            //echo "<pre>";print_r($row);exit;

            fputcsv($output, $row);

        }



        exit;

    }



    function outstanding_ajaxList() {

        $search_data = $this->input->post();

        $search_arr = array();

        $search_arr['cust_type'] = $search_data['cust_type'];

        $search_arr['cust_reg'] = $search_data['cust_reg'];

        $search_arr['due_date'] = $search_data['due_date'];

        //$search_arr['category'] = $search_data['category'];

        if (empty($search_arr)) {

            $search_arr = array();

        }

        $list = $this->report_model->get_outstanding_datatables($search_arr);



        $data = array();

        $no = $_POST['start'];



        foreach ($list as $customer) {



            if ($customer['firm_id'] == 1)

                $electricals = ($electricals + ($customer['net_total'] - ($customer['electricals'] + $customer['advance'])));

            if ($customer['firm_id'] == 2)

                $paints = ($paints + ($customer['net_total'] - ($customer['paints'] + $customer['advance'])));

            if ($customer['firm_id'] == 3)

                $tiles = ($tiles + ($customer['net_total'] - ($customer['tiles'] + $customer['advance'])));

            if ($customer['firm_id'] == 4)

                $hardware = ($hardware + ($customer['net_total'] - ($customer['hardware'] + $customer['advance'])));



            $net_amount = $net_amount + ($customer['net_total'] - ($customer['net_amount'] + $customer['advance']));

            $no++;

            $row = array();

            $row[] = $no;

            //$row[] = $ass->firm_name;

            $row[] = ($customer['store_name']) ? $customer['store_name'] : $customer['name'];

            $row[] = $customer['mobil_number'];

            $row[] = ($customer['firm_id'] == 1) ? number_format($customer['net_total'] - ($customer['electricals'] + $customer['advance']), 2) : '0';

            $row[] = ($customer['firm_id'] == 2) ? number_format($customer['net_total'] - ($customer['paints'] + $customer['advance']), 2) : '0';

            $row[] = ($customer['firm_id'] == 3) ? number_format($customer['net_total'] - ($customer['tiles'] + $customer['advance']), 2) : '0';

            $row[] = ($customer['firm_id'] == 4) ? number_format($customer['net_total'] - ($customer['hardware'] + $customer['advance']), 2) : '0';

            $row[] = ($customer['net_total'] != '') ? number_format($customer['net_total'] - ($customer['net_amount'] + $customer['advance']), 2) : '0';



            $data[] = $row;

        }

        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->report_model->count_all_outstanding_firmwise(),

            "recordsFiltered" => $this->report_model->count_filtered_outstanding_firmwise(),

            "data" => $data,

        );

        echo json_encode($output);

        exit;

    }



    function outstanding_due_date_excel_report() {



        if (isset($_GET) && $_GET['search'] != '') {

            $search = $_GET['search'];

        } else {

            $search = '';

        }

        $json = json_decode($search);



        $duedate = $this->report_model->get_customer_details_report($json);



        $this->export_all_duedate_csv($duedate);

    }



    function export_all_duedate_csv($query, $timezones = array()) {



        // output headers so that the file is downloaded rather than displayed

        header('Content-Type: text/csv; charset=utf-8');

        header('Content-Disposition: attachment; filename=Outstanding Report-Due Date Wise.csv');



        // create a file pointer connected to the output stream

        $output = fopen('php://output', 'w');



        // output the column headings

        //Order has been changes

        fputcsv($output, array('S.No', 'Customer Name', 'Mobile', 'OB', '0 to 7 days', '7 to 30 days', ' 30 to 90 days', '90 days', 'Net Balance'));



        // fetch the data

        //$rows = mysql_query($query);

        // loop over the rows, outputting them

        foreach ($query as $key => $customer) {

            $days = $sevendays = $inv = $advance = $thirtydays = $nintydays = $receipt = 0;

            //echo "<pre>";

            //print_r($customers);

            //exit;

            $a_val = $b_val = $c_val = $d_val = $e_val = $overall_total = 0;

            $days_net_total = $seven_days_net_total = $thirty_days_net_total = $ninty_days_net_total = $wingsinvoice_net_total = 0;



            if (!empty($customer['days'])) {

                foreach ($customer['days'] as $days_value) {

                    $days_net_total = $days_net_total + $days_value['new_balance'];

                }

            }



            if (!empty($customer['sevendays'])) {

                foreach ($customer['sevendays'] as $seven_days_value) {

                    $seven_days_net_total = $seven_days_net_total + $seven_days_value['new_balance'];

                }

            }



            if (!empty($customer['thirtydays'])) {

                foreach ($customer['thirtydays'] as $thirty_days_value) {

                    $thirty_days_net_total = $thirty_days_net_total + $thirty_days_value['new_balance'];

                }

            }



            if (!empty($customer['nintydays'])) {

                foreach ($customer['nintydays'] as $ninty_days_value) {

                    $ninty_days_net_total = $ninty_days_net_total + $ninty_days_value['new_balance'];

                }

            }

            if (!empty($customer['rec'])) {

                foreach ($customer['rec'] as $wingsinvoice) {

                    $wingsinvoice_net_total += $wingsinvoice['new_balance'];

                }

            }

            $overall_total = $days_net_total + $seven_days_net_total + $thirty_days_net_total + $ninty_days_net_total + $wingsinvoice_net_total;

            $row = [];

            if ($overall_total > 0) {

                $row = array($key + 1, ($customer['store_name']) ? $customer['store_name'] : $customer['name'], $customer['mobil_number'], ($wingsinvoice_net_total <= 0 ) ? number_format($wingsinvoice_net_total, 2) : number_format($wingsinvoice_net_total, 2), ($days_net_total <= 0 ) ? number_format($days_net_total, 2) : number_format($days_net_total, 2), ($seven_days_net_total <= 0 ) ? number_format($seven_days_net_total, 2) : number_format($seven_days_net_total, 2), ($thirty_days_net_total <= 0 ) ? number_format($thirty_days_net_total, 2) : number_format($thirty_days_net_total, 2), ($ninty_days_net_total <= 0 ) ? number_format($ninty_days_net_total, 2) : number_format($ninty_days_net_total, 2), number_format($overall_total, 2));

            }

            //echo "<pre>";print_r($row);exit;

            fputcsv($output, $row);

        }



        exit;

    }



    function outstanding_duedate_ajaxList() {

        $search_data = $this->input->post();

        $search_arr = array();

        $search_arr['cust_type'] = $search_data['cust_type'];

        $search_arr['cust_reg'] = $search_data['cust_reg'];

        $search_arr['firm'] = $search_data['firm'];

        //$search_arr['category'] = $search_data['category'];

        if (empty($search_arr)) {

            $search_arr = array();

        }

        $list = $this->report_model->get_outstanding_duedate_datatables($search_arr);



        $data = array();

        $no = $_POST['start'];



        foreach ($list as $customer) {

            $s = 1;

            $days = $sevendays = $inv = $advance = $thirtydays = $nintydays = $receipt = 0;

            //echo "<pre>";

            //print_r($customers);

            //exit;

            $a_val = $b_val = $c_val = $d_val = $e_val = $overall_total = 0;

            $days_net_total = $seven_days_net_total = $thirty_days_net_total = $ninty_days_net_total = $wingsinvoice_net_total = 0;



            if (!empty($customer['days'])) {

                foreach ($customer['days'] as $days_value) {

                    $days_net_total = $days_net_total + $days_value['new_balance'];

                }

            }



            if (!empty($customer['sevendays'])) {

                foreach ($customer['sevendays'] as $seven_days_value) {

                    $seven_days_net_total = $seven_days_net_total + $seven_days_value['new_balance'];

                }

            }



            if (!empty($customer['thirtydays'])) {

                foreach ($customer['thirtydays'] as $thirty_days_value) {

                    $thirty_days_net_total = $thirty_days_net_total + $thirty_days_value['new_balance'];

                }

            }



            if (!empty($customer['nintydays'])) {

                foreach ($customer['nintydays'] as $ninty_days_value) {

                    $ninty_days_net_total = $ninty_days_net_total + $ninty_days_value['new_balance'];

                }

            }

            if (!empty($customer['rec'])) {

                foreach ($customer['rec'] as $wingsinvoice) {

                    $wingsinvoice_net_total += $wingsinvoice['new_balance'];

                }

            }

            ?>



            <?php



            $overall_total = $days_net_total + $seven_days_net_total + $thirty_days_net_total + $ninty_days_net_total + $wingsinvoice_net_total;

            if ($overall_total > 0) {

                $no++;

                $row = array();

                $row[] = $no;

                //$row[] = $ass->firm_name;

                $row[] = ($customer['store_name']) ? $customer['store_name'] : $customer['name'];

                $row[] = $customer['mobil_number'];

//            $row[] = ($wingsinvoice_net_total <= 0 ) ? '' : number_format($wingsinvoice_net_total, 2);

//            $row[] = ($days_net_total <= 0 ) ? '' : number_format($days_net_total, 2);

//            $row[] = ($seven_days_net_total <= 0 ) ? '' : number_format($seven_days_net_total, 2);

//            $row[] = ($thirty_days_net_total <= 0 ) ? '' : number_format($thirty_days_net_total, 2);

//            $row[] = ($ninty_days_net_total <= 0 ) ? '' : number_format($ninty_days_net_total, 2);

                $row[] = ($wingsinvoice_net_total <= 0 ) ? number_format($wingsinvoice_net_total, 2) : number_format($wingsinvoice_net_total, 2);

                $row[] = ($days_net_total <= 0 ) ? number_format($days_net_total, 2) : number_format($days_net_total, 2);

                $row[] = ($seven_days_net_total <= 0 ) ? number_format($seven_days_net_total, 2) : number_format($seven_days_net_total, 2);

                $row[] = ($thirty_days_net_total <= 0 ) ? number_format($thirty_days_net_total, 2) : number_format($thirty_days_net_total, 2);

                $row[] = ($ninty_days_net_total <= 0 ) ? number_format($ninty_days_net_total, 2) : number_format($ninty_days_net_total, 2);





                //$row[] = $days_net_total + $seven_days_net_total + $thirty_days_net_total + $ninty_days_net_total + $wingsinvoice_net_total;

                $row[] = number_format($overall_total, 2);



                $data[] = $row;

            }

        }

        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->report_model->count_all_outstanding_duedate(),

            "recordsFiltered" => $this->report_model->count_filtered_outstanding_duedate(),

            "data" => $data,

        );

        echo json_encode($output);

        exit;

    }



    function outstanding_excel_report() {



        if (isset($_GET) && $_GET['search'] != '') {

            $search = $_GET['search'];

        } else {

            $search = '';

        }

        $json = json_decode($search);

        $outstanding = $this->report_model->outstanding_report_excel($json);



        $this->export_all_outstanding_csv($outstanding);

    }



    function export_all_outstanding_csv($query, $timezones = array()) {



        // output headers so that the file is downloaded rather than displayed

        header('Content-Type: text/csv; charset=utf-8');

        header('Content-Disposition: attachment; filename=Outstanding Report.csv');



        // create a file pointer connected to the output stream

        $output = fopen('php://output', 'w');



        // output the column headings

        //Order has been changes

        fputcsv($output, array('S.No', 'Customer Name', 'Inv Amt', 'Paid Amt', 'Discount Amt', 'Balance', 'Created Date', 'Due Date'));



        // fetch the data

        //$rows = mysql_query($query);

        // loop over the rows, outputting them

        foreach ($query as $key => $val) {



            $row = array($key + 1, ($val['store_name']) ? $val['store_name'] : $val['name'], number_format($val['invoice_net_total'], 2, '.', ','), number_format($val['receipt_bill'][0]['receipt_paid'], 2, '.', ','), number_format($val['receipt_bill'][0]['receipt_discount'], 2, '.', ','), number_format(($val['invoice_net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'])), 2, '.', ','), ($val['receipt_bill'][0]['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['created_date'])) : '-', ($val['receipt_bill'][0]['next_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['next_date'])) : '');

            //echo "<pre>";print_r($row);exit;

            fputcsv($output, $row);

        }

        exit;

    }



    function payment_ajaxList() {

        $search_data = $this->input->post();

        $search_arr = array();

        $search_arr['cust_type'] = $search_data['cust_type'];

        $search_arr['cust_reg'] = $search_data['cust_reg'];

        $search_arr['firm'] = $search_data['firm'];

        //$search_arr['category'] = $search_data['category'];

        if (empty($search_arr)) {

            $search_arr = array();

        }

        $list = $this->report_model->get_payment_datatables($search_arr);



        $data = array();

        $no = $_POST['start'];



        foreach ($list as $val) {

            $link = '';

            $paid = $bal = $inv = 0;

            $i = 1;

            $inv = $inv + $val['invoice_net_total'];

//            $inv= array_sum($val['invoice_net']);



            $paid = $paid + $val['receipt_bill'][0]['receipt_paid'];

            $bal = $bal + ($val['receipt_bill'][0]['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']));



            if ($val['receipt_bill'][0]['net_total'] == ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'])) {

                $link = '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="In-Complete"><span class="fa fa-thumbs-up green">&nbsp;</span></a>';

            } else {

                $link = '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="Complete"><span class="fa fa-thumbs-down blue">&nbsp;</span></a>';

            }



            $no++;

            $row = array();

            $row[] = $no;

            $row[] = ($val['store_name']) ? $val['store_name'] : $val['name'];

//            $row[] = number_format($val['receipt_bill'][0]['net_total'], 2, '.', ',');

            $row[] = number_format($val['invoice_net_total'], 2, '.', ',');

            $row[] = number_format($val['receipt_bill'][0]['receipt_paid'], 2, '.', ',');

            $row[] = number_format($val['receipt_bill'][0]['receipt_discount'], 2, '.', ',');

            $row[] = number_format(($val['invoice_net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'])), 2, '.', ',');

            $row[] = ($val['receipt_bill'][0]['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['created_date'])) : '-';

            $row[] = ($val['receipt_bill'][0]['next_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['next_date'])) : '';

            $row[] = $link;





            $data[] = $row;

        }

        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->report_model->count_all_pay_outstanding(),

            "recordsFiltered" => $this->report_model->count_filtered_pay_outstanding(),

            "data" => $data,

        );

        echo json_encode($output);

        exit;

    }



    function customer_excel_report() {



        if (isset($_GET) && $_GET['search'] != '') {

            $search = $_GET['search'];

        } else {

            $search = '';

        }

        $json = json_decode($search);



        $cust = $this->report_model->get_all_customer_report($json);



        $this->export_all_customer_csv($cust);

    }



    function export_all_customer_csv($query, $timezones = array()) {



        // output headers so that the file is downloaded rather than displayed

        header('Content-Type: text/csv; charset=utf-8');

        header('Content-Disposition: attachment; filename=Customer Based Report.csv');



        // create a file pointer connected to the output stream

        $output = fopen('php://output', 'w');



        // output the column headings

        //Order has been changes

       // fputcsv($output, array('S.No', 'Customer Name', 'Invoice No', 'Invoice Amount', 'Advance Amt', 'Paid Amount', 'Return Amt', 'Discount Amt', 'Balance', 'Inv Date', 'Paid Date'));

        fputcsv($output, array('S.No', 'Customer Name', 'Invoice No', 'Invoice Amount', 'Paid Amount', 'Invoice Date'));



        // fetch the data

        //$rows = mysql_query($query);

        // loop over the rows, outputting them

        foreach ($query as $key => $val) {

          /*  if (($val['return'][0]['id'] != $val['return'][1]['id'])) {

                $rtn_amt = number_format($val['return'][1]['net_total'] - $val['return'][0]['net_total'], 2, '.', ',');

                $return_amt = str_replace("-", "", $rtn_amt);

            } else {

                $return_amt = '0.00';

            }

            $discount_amt = number_format($val['receipt_bill'][0]['receipt_discount'], 2, '.', ',');

            if (($val['return'][0]['id'] != $val['return'][1]['id'])) {

                // $row[] = (($val['return'][1]['net_total'] - ($val['return'][1]['net_total'] - $val['return'][0]['net_total'])) - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']) > 0) ? number_format(($val['return'][1]['net_total'] - ($val['return'][1]['net_total'] - $val['return'][0]['net_total'])) - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance']), 2, '.', ',') : '0.00';

                //$row[] = number_format(($val['return'][1]['net_total'] - ($val['return'][1]['net_total'] - $val['return'][0]['net_total'])) - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance']), 2, '.', ',');



                $balance = number_format($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance']), 2, '.', ',');

            } else {

                //$row[] = ($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']) > 0) ? number_format($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance']), 2, '.', ',') : '0.00';



                $balance = number_format($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance']), 2, '.', ',');

            }

           // $row = array($key + 1, $val['store_name'], $val['inv_id'], number_format($val['net_total'], 2, '.', ','), number_format($val['advance'], 2, '.', ','), number_format($val['receipt_bill'][0]['receipt_paid'], 2, '.', ','), $return_amt, $discount_amt, $balance, ($val['created_date'] != '' && $val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '-', ($val['receipt_bill'][0]['next_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['next_date'])) : '');*/

              $row = array($key + 1, $val['store_name'], $val['inv_id'], number_format($val['net_total'], 2, '.', ','), number_format($val['receipt_bill'][0]['receipt_paid'], 2, '.', ','), ($val['created_date'] != '' && $val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '-');

          //  echo "<pre>";print_r($row);exit;

            fputcsv($output, $row);

        }

        exit;

    }



    function customer_based_ajaxList() {

        $search_data = $this->input->post();

        $search_arr = array();

        $search_arr['overdue'] = $search_data['overdue'];

        $search_arr['from_date'] = $search_data['from_date'];

        $search_arr['to_date'] = $search_data['to_date'];

        $search_arr['inv_id'] = $search_data['inv_id'];

        $search_arr['customer'] = $search_data['customer'];

        $search_arr['product'] = $search_data['product'];

        $search_arr['firm_id'] = $search_data['firm_id'];

        //$search_arr['category'] = $search_data['category'];

        if (empty($search_arr)) {

            $search_arr = array();

        }

        $list = $this->report_model->get_customer_based_datatables($search_data);



//        echo '<pre>';

//        print_r($list);

//        die;



        $data = array();

        $no = $_POST['start'];



        foreach ($list as $val) {

            $link = '';

            $paid = $bal = $inv = $advance = $rtn_amt = 0;



            $advance = $advance + $val['advance'];

            $inv = $inv + $val['net_total'];

            $paid = $paid + $val['receipt_bill'][0]['receipt_paid'];

            $bal = $bal + ($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance']));

            ?>

            <?php



            if ($val['payment_status'] == 'Pending') {

                $link = '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="In-Complete"><span class="fa fa-thumbs-down blue">&nbsp;</span></a>';

            } else {

                $link = '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="Complete"><span class="fa fa-thumbs-up green">&nbsp;</span></a>';

            }

            ?>



            <?php



            if ($this->user_auth->is_action_allowed("reports", "customer_based_report", "view")) {

              //  $url = $this->config->item("base_url") . "sales_receipt/view_receipt/" . $val["id"];
                $url = $this->config->item("base_url") . "report/customer_receipt_view/" . $val["id"];

            }



            if (!$this->user_auth->is_action_allowed("reports", "customer_based_report", "view")) {

                $alert = 'alerts';

            }





            $link1 = '<a href="' . $url . '" data-toggle="tooltip" class="tooltips btn btn-default btn-xs ' . $alert . ' " title="" data-original-title="View" ><span class="fa fa-eye"></span></a>';

            $no++;

            $row = array();

            $row[] = $no;

            //$row[] = $ass->firm_name;

            $row[] = $val['store_name'];

            $row[] = $val['inv_id'];

            $row[] = number_format($val['net_total'], 2, '.', ',');

            //$row[] = number_format($val['advance'], 2, '.', ',');

          //  $row[] = number_format($val['receipt_bill'][0]['receipt_paid'], 2, '.', ',');

            if (($val['return'][0]['id'] != $val['return'][1]['id'])) {

                $rtn_amt = number_format($val['return'][1]['net_total'] - $val['return'][0]['net_total'], 2, '.', ',');

               // $row[] = str_replace("-", "", $rtn_amt);

            } else {

                //$row[] = '0.00';

            }

          //  $row[] = number_format($val['receipt_bill'][0]['receipt_discount'], 2, '.', ',');

            if (($val['return'][0]['id'] != $val['return'][1]['id'])) {

                // $row[] = (($val['return'][1]['net_total'] - ($val['return'][1]['net_total'] - $val['return'][0]['net_total'])) - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']) > 0) ? number_format(($val['return'][1]['net_total'] - ($val['return'][1]['net_total'] - $val['return'][0]['net_total'])) - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance']), 2, '.', ',') : '0.00';

                //$row[] = number_format(($val['return'][1]['net_total'] - ($val['return'][1]['net_total'] - $val['return'][0]['net_total'])) - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance']), 2, '.', ',');



              //  $row[] = number_format($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance']), 2, '.', ',');

            } else {

                //$row[] = ($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']) > 0) ? number_format($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance']), 2, '.', ',') : '0.00';



               // $row[] = number_format($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance']), 2, '.', ',');

            }

            //$row[] = (($val['return'][1]['net_total'] - $val['return'][0]['net_total']) - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']) > 0) ? number_format($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance']), 2, '.', ',') : '0.00';

            $row[] = ($val['created_date'] != '' && $val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '-';

            //$row[] = ($val['receipt_bill'][0]['next_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['next_date'])) : '';

          //  $row[] = $link;

            $row[] = $link1;





            $data[] = $row;

        }

        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->report_model->count_all_customer(),

            "recordsFiltered" => $this->report_model->count_filtered_customer($search_data),

            "data" => $data,

        );

        echo json_encode($output);

        exit;

    }



    function inv_excel_report() {



        if (isset($_GET) && $_GET['search'] != '') {

            $search = $_GET['search'];

        } else {

            $search = '';

        }

        $json = json_decode($search);

        $inv = $this->project_cost_model->get_invoice_report($json);



        $this->export_all_inv_csv($inv);

    }



    function export_all_inv_csv($query, $timezones = array()) {



        // output headers so that the file is downloaded rather than displayed

        header('Content-Type: text/csv; charset=utf-8');

        header('Content-Disposition: attachment; filename=Invoice Report.csv');



        // create a file pointer connected to the output stream

        $output = fopen('php://output', 'w');



        // output the column headings

        //Order has been changes

        //fputcsv($output, array('S.No', 'Invoice Id', 'Customer Name', 'Total Qty', 'CGST', 'SGST', 'Sub Total', 'Invoice Amt', 'Paid Amt', 'Invoice Date', 'Piad Date', 'Credit Days', 'Due Date', 'Credit Limit', 'Exceeded Credit Limit', 'Sales Man'));

         fputcsv($output, array('S.No', 'Invoice Id', 'Customer Name', 'Total Quantity','Invoice Amount', 'Paid Amount', 'Invoice Date', 'Sales Man'));



        // fetch the data

        //$rows = mysql_query($query);

        // loop over the rows, outputting them

        foreach ($query as $key => $val) {



            if ($val['credit_days'] > 0 && $val['created_date'] != '1970-01-01') {

                $due_date = date('d-M-Y', strtotime($val['created_date'] . "+" . $val['credit_days'] . " days"));

            } else {

                $due_date = '-';

            }



            //$row = array($key + 1, $val['inv_id'], ($val['store_name']) ? $val['store_name'] : $val['name'], $val['total_qty'], number_format(($val['erp_invoice_details'][0]['cgst']), 2), number_format(($val['erp_invoice_details'][0]['sgst']), 2), number_format($val['subtotal_qty'], 2), number_format($val['net_total'], 2), number_format(($val['receipt_bill'][0]['receipt_paid'] + $val['advance']), 2, '.', ','), ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '', ($val['receipt_bill'][0]['paid_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['paid_date'])) : '-', $val['credit_days'] > 0 ? $val['credit_days'] : '-', $due_date, ($val['credit_limit'] != '') ? $val['credit_limit'] : '-', ($val['exceeded_limit'] != '') ? $val['exceeded_limit'] : '-', $val['sales_man_name']);

             $row = array($key + 1, $val['inv_id'], ($val['store_name']) ? $val['store_name'] : $val['name'], $val['total_qty'], number_format($val['net_total'], 2), number_format(($val['receipt_bill'][0]['receipt_paid'] + $val['advance']), 2, '.', ','), ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '', $val['sales_man_name']);

            //echo "<pre>";print_r($row);exit;

            fputcsv($output, $row);

        }

        exit;

    }



    function invoice_ajaxList() {

        $search_data = $this->input->post();

        $search_arr = array();

        $search_arr['overdue'] = $search_data['overdue'];

        $search_arr['from_date'] = $search_data['from_date'];

        $search_arr['to_date'] = $search_data['to_date'];

        $search_arr['inv_id'] = $search_data['inv_id'];

        $search_arr['customer'] = $search_data['customer'];

        $search_arr['product'] = $search_data['product'];

        $search_arr['gst'] = $search_data['gst'];

        $search_arr['sales_man'] = $search_data['sales_man'];

         $search_arr['firm_id'] = $search_data['firm_id'];

        if (empty($search_arr)) {

            $search_arr = array();

        }

        $list = $this->report_model->get_invoice_datatables($search_arr);


//echo "<pre>";print_r($list);exit;


        $data = array();

        $no = $_POST['start'];



        foreach ($list as $val) {

            if ($val['credit_days'] > 0 && $val['created_date'] != '1970-01-01') {

                $due_date = date('d-M-Y', strtotime($val['created_date'] . "+" . $val['credit_days'] . " days"));

            } else {

                $due_date = '-';

            }

            ?>

            <?php



            $no++;

            $row = array();

            $row[] = $no;

            //$row[] = $ass->firm_name;

            $row[] = $val['inv_id'];

            $row[] = ($val['store_name']) ? $val['store_name'] : $val['name'];

            $row[] = $val['total_qty'];

           // $row[] = number_format(($val['erp_invoice_details'][0]['cgst']), 2);

           // $row[] = number_format(($val['erp_invoice_details'][0]['sgst']), 2);

           // $row[] = number_format($val['subtotal_qty'], 2);

            $row[] = number_format($val['net_total'], 2);

          //  $row[] = number_format(($val['receipt_bill'][0]['receipt_paid'] + $val['advance']), 2, '.', ',');

            $row[] = ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '';

           // $row[] = ($val['receipt_bill'][0]['paid_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['paid_date'])) : '-';

           // $row[] = $val['credit_days'] > 0 ? $val['credit_days'] : '-';

           // $row[] = $due_date;

           // $row[] = ($val['credit_limit'] != '') ? $val['credit_limit'] : '-';

           // $row[] = ($val['exceeded_limit'] != '') ? $val['exceeded_limit'] : '-';

            $row[] = $val['sales_man_name'];

            $data[] = $row;

        }

        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->report_model->count_all_invoice(),

            "recordsFiltered" => $this->report_model->count_filtered_invoice($search_data),

            "data" => $data,

        );

        echo json_encode($output);

        exit;

    }



    function getall_gst_entries() {



        $search_data = $this->input->get();



//        if (empty($search_data['firm_id'] && $search_data['cust_type'] && $search_data['from_date'] && $search_data['to_date'] && $search_data['gsr'])) {

//            $search_data = "";

//        }



        $data['search_data'] = $search_data;



        $data['quotation'] = $this->project_cost_model->get_gst_invoice($search_data);



        $list_array = array();

        $this->load->library('session');

        $list = array();

        foreach ($data['quotation'] as $key => $val) {

            if ($key <= 49) {

                $list[] = $val['id'];

            }

        }

        $session_array = array('gst_report' => '');

        $this->session->set_userdata($session_array);

        $session_array = array('gst_report' => $list);

        $this->session->set_userdata($session_array);

        //echo "<pre>";print_r($data);exit;

        $this->export_all_quotation_csv($data);

        //$this->load->view('report/invoice_gst_list_excel', $data);

    }



    function export_all_quotation_csv($query, $timezones = array()) {



        // output headers so that the file is downloaded rather than displayed

        header('Content-Type: text/csv; charset=utf-8');

        header('Content-Disposition: attachment; filename=GST Report.csv');



        // create a file pointer connected to the output stream

        $output = fopen('php://output', 'w');



        // output the column headings

        //Order has been changes

        fputcsv($output, array('S.No', 'Invoice ID', 'Firm Name', 'Firm GSTIN', 'Customer name', 'Customer GSTIN', 'Total QTY', 'CGST', 'SGST', 'Sub Total', 'Inv Amt', 'INV Date'));



        // fetch the data

        //$rows = mysql_query($query);

        // loop over the rows, outputting them

        foreach ($query[quotation] as $key => $val) {

            $row = array($key + 1, $val['inv_id'], $val['firm_name'], ($val['gstin']) ? $val['gstin'] : '', ($val['store_name']) ? $val['store_name'] : $val['name'], ($val['tin']) ? $val['tin'] : '', $val['total_qty'], number_format(($val['erp_invoice_details'][0]['cgst']), 2), number_format(($val['erp_invoice_details'][0]['sgst']), 2), number_format($val['subtotal_qty'], 2), number_format($val['net_total'], 2), ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '');

            //echo "<pre>";print_r($row);exit;

            fputcsv($output, $row);

        }

        exit;

    }



    function gst_report_ajaxList() {

        $search_data = $this->input->post();





        $list = $this->report_model->get_gst_datatables($search_data);

        $list_array = array();

        foreach ($list as $value) {

            $list_array[] = $value['id'];

        }







        $session_array = array('gst_report' => '');

        $this->session->unset_userdata($session_array);

        $session_array = array('gst_report' => $list_array);

        $this->session->set_userdata($session_array);



        $data = array();

        $no = $_POST['start'];



        foreach ($list as $val) {

            if ($val['credit_days'] > 0 && $val['created_date'] != '1970-01-01') {

                $due_date = date('d-M-Y', strtotime($val['created_date'] . "+" . $val['credit_days'] . " days"));

            } else {

                $due_date = '-';

            }

            ?>

            <?php



            $tin = ($val['tin']) ? ' - ' . $val['tin'] : '';

            $no++;

            $row = array();

            $row[] = $no;

            //$row[] = $ass->firm_name;



            $row[] = '<a href="' . $this->config->item('base_url') . 'sales/invoice_views/' . $val['id'] . '" target="_blank">' . $val['inv_id'] . '</a>';

            $row[] = $val['firm_name'];

            $row[] = ($val['gstin']) ? $val['gstin'] : '';

            $row[] = ($val['store_name']) ? $val['store_name'] : $val['name'];

            $row[] = ($val['tin']) ? $val['tin'] : '';



            $row[] = $val['total_qty'];

            $row[] = number_format(($val['erp_invoice_details'][0]['cgst']), 2);

            $row[] = number_format(($val['erp_invoice_details'][0]['sgst']), 2);

            $row[] = number_format($val['subtotal_qty'], 2);

            $row[] = number_format($val['net_total'], 2);

//            $row[] = number_format(($val['receipt_bill'][0]['receipt_paid'] + $val['advance']), 2, '.', ',');

            $row[] = ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '';

//            $row[] = ($val['receipt_bill'][0]['paid_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['paid_date'])) : '-';

//            $row[] = $val['credit_days'] > 0 ? $val['credit_days'] : '-';

//            $row[] = $due_date;

//            $row[] = ($val['credit_limit'] != '') ? $val['credit_limit'] : '-';

//            $row[] = ($val['exceeded_limit'] != '') ? $val['exceeded_limit'] : '-';

//            $row[] = $val['sales_man_name'];

            $row['total'][] = $this->report_model->count_filtered_gst();

            $data[] = $row;

        }

        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->report_model->count_all_gst(),

            "recordsFiltered" => $this->report_model->count_filtered_gst(),

            "data" => $data,

        );



        echo json_encode($output);

        exit;

    }



    function hr_excel_report() {



        if (isset($_GET) && $_GET['search'] != '') {

            $search = $_GET['search'];

        } else {

            $search = '';

        }

        $json = json_decode($search);



        $hr = $this->report_model->get_invoice_hr_report($json);



        $this->export_all_hr_csv($hr);

    }



    function export_all_hr_csv($query, $timezones = array()) {



        // output headers so that the file is downloaded rather than displayed

        header('Content-Type: text/csv; charset=utf-8');

        header('Content-Disposition: attachment; filename=Contractor Report.csv');



        // create a file pointer connected to the output stream

        $output = fopen('php://output', 'w');



        // output the column headings

        //Order has been changes

        fputcsv($output, array('S.No', 'Invoice ID', 'Customer Name', 'Total Qty', 'Inv Amt', 'Invoice Date', 'Credit Days', 'Due Date', 'Credit Limit', 'Exceeded Credit Limit'));



        // fetch the data

        //$rows = mysql_query($query);

        // loop over the rows, outputting them

        foreach ($query as $key => $val) {

            if ($val['credit_days'] > 0 && $val['created_date'] != '1970-01-01') {

                $due_date = date('d-M-Y', strtotime($val['created_date'] . "+" . $val['credit_days'] . " days"));

            } else {

                $due_date = '-';

            }



            $row = array($key + 1, $val['inv_id'], ($val['store_name']) ? $val['store_name'] : $val['name'], number_format($val['net_total'], 2), ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '', $val['credit_days'] > 0 ? $val['credit_days'] : '-', $due_date, ($val['credit_limit'] != '') ? $val['credit_limit'] : '-', ($val['exceeded_limit'] != '') ? $val['exceeded_limit'] : '-');

            //echo "<pre>";print_r($row);exit;

            fputcsv($output, $row);

        }

        exit;

    }



    function hr_invoice_ajaxList() {

        $search_data = $this->input->post();

        $search_arr = array();

        $search_arr['category'] = $search_data['category'];

        //$search_arr['brand'] = $search_data['brand'];

        $search_arr['product'] = $search_data['product'];

        //$search_arr['category'] = $search_data['category'];

        if (empty($search_arr)) {

            $search_arr = array();

        }

        $list = $this->report_model->get_hr_invoice_datatables($search_arr);

        //echo "<pre>";

        //print_r($list);

        //exit;





        $data = array();

        $no = $_POST['start'];

        $tot = 0;

        foreach ($list as $val) {



            $tot += $val['net_total'];

            if ($val['credit_days'] > 0 && $val['created_date'] != '1970-01-01') {

                $due_date = date('d-M-Y', strtotime($val['created_date'] . "+" . $val['credit_days'] . " days"));

            } else {

                $due_date = '-';

            }



            $no++;

            $row = array();

            $row[] = $no;

            $row[] = $val['inv_id'];

            $row[] = ($val['store_name']) ? $val['store_name'] : $val['name'];

            $row[] = $val['total_qty'];

            $row[] = number_format($val['net_total'], 2);

            $row[] = ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '';

            $row[] = $val['credit_days'] > 0 ? $val['credit_days'] : '-';

            $row[] = $due_date;

            $row[] = ($val['credit_limit'] != '') ? $val['credit_limit'] : '-';

            $row[] = ($val['exceeded_limit'] != '') ? $val['exceeded_limit'] : '-';



            $data[] = $row;

        }

        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->report_model->count_all_hr_invoice(),

            "recordsFiltered" => $this->report_model->count_filtered_hr_invoice(),

            "data" => $data,

        );

        echo json_encode($output);

        exit;

    }



    function pc_ajaxList() {

        $search_data = $this->input->post();

        $search_arr = array();

        $search_arr['category'] = $search_data['category'];

        //$search_arr['brand'] = $search_data['brand'];

        $search_arr['product'] = $search_data['product'];

        //$search_arr['category'] = $search_data['category'];

        if (empty($search_arr)) {

            $search_arr = array();

        }



        $list = $this->project_cost_model->get_pc_datatables($search_arr);

//        echo "<pre>";

//        print_r($list);

//        exit;





        $data = array();

        $no = $_POST['start'];

        $tot = 0;

        foreach ($list as $val) {





            $no++;

            $row = array();

            $row[] = $no;

            $row[] = $val['job_id'];

            $row[] = ($val['store_name']) ? $val['store_name'] : $val['name'];

            $row[] = $val['total_qty'];

            // $row[] = number_format(($val['tax_details'][0]['tot_tax']), 2);

            $row[] = number_format($val['subtotal_qty'], 2);

            $row[] = number_format($val['net_total'], 2);

            $row[] = ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '';





            $data[] = $row;

        }

        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->project_cost_model->count_all_pc(),

            "recordsFiltered" => $this->project_cost_model->count_filtered_pc(),

            "data" => $data,

        );

        echo json_encode($output);

        exit;

    }



    function pr_excel_report() {

        if (isset($_GET) && $_GET['search'] != '') {

            $search = $_GET['search'];

        } else {

            $search = '';

        }



        $json = json_decode($search);



        $this->load->model('purchase_receipt/receipt_model');

        $pr = $this->receipt_model->get_all_receipt_report($json);



        $this->export_all_pr_csv($pr);

    }



    function export_all_pr_csv($query, $timezones = array()) {



        // output headers so that the file is downloaded rather than displayed

        header('Content-Type: text/csv; charset=utf-8');

        header('Content-Disposition: attachment; filename=Purchase Receipt Report.csv');



        // create a file pointer connected to the output stream

        $output = fopen('php://output', 'w');



        // output the column headings

        //Order has been changes

        fputcsv($output, array('S.No', 'PO#', 'Customer Name', 'Inv Amt', 'Paid Amt', 'Discount Amt', 'Balance', 'Due Date', 'Created Date'));



        // fetch the data

        //$rows = mysql_query($query);

        // loop over the rows, outputting them

        foreach ($query as $key => $val) {



            $row = array($key + 1, $val['po_no'], ($val['store_name']), number_format($val['net_total'], 2, '.', ','), number_format($val['receipt_bill'][0]['receipt_paid'], 2, '.', ','), number_format($val['receipt_bill'][0]['receipt_discount'], 2, '.', ',', 2, '.', ','), number_format(($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'])), 2, '.', ','), ($val['receipt_bill'][0]['next_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['next_date'])) : '-', ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '');

            //echo "<pre>";print_r($row);exit;

            fputcsv($output, $row);

        }

        exit;

    }



    function purchase_receipt_ajaxList() {



        $search_data = $this->input->post();

        $search_arr = array();

        $search_arr['category'] = $search_data['category'];

        //$search_arr['brand'] = $search_data['brand'];

        $search_arr['product'] = $search_data['product'];

        //$search_arr['category'] = $search_data['category'];

        if (empty($search_arr)) {

            $search_arr = array();

        }

        $this->load->model('purchase_receipt/receipt_model');

        $list = $this->receipt_model->get_purchase_receipt_datatables($search_arr);



        $data = array();

        $no = $_POST['start'];

        $paid = $bal = $inv = 0;

        foreach ($list as $val) {

            $status = $url = $view = '';

            $inv = $inv + $val['net_total'];

            $paid = $paid + $val['receipt_bill'][0]['receipt_paid'];

            $bal = $bal + ($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']));



            if ($val['payment_status'] == 'Pending') {

                $status = '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="In-Complete"><span class="fa fa-thumbs-down blue">&nbsp;</span></a>';

            } else {

                $status = '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="Complete"><span class="fa fa-thumbs-up green">&nbsp;</span></a>';

            }

            $url = $this->config->item('base_url') . 'purchase_receipt/view_receipt/' . $val['id'];



            $view = '<a href="' . $url . '" data-toggle="tooltip" class="tooltips btn btn-default btn-xs" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>';



            $no++;

            $row = array();

            $row[] = $no;

            $row[] = $val['po_no'];

            $row[] = ($val['store_name']);

            $row[] = number_format($val['net_total'], 2, '.', ',');

            $row[] = number_format($val['receipt_bill'][0]['receipt_paid'], 2, '.', ',');

            $row[] = number_format($val['receipt_bill'][0]['receipt_discount'], 2, '.', ',');

            $row[] = number_format(($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'])), 2, '.', ',');

            $row[] = ($val['receipt_bill'][0]['next_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['next_date'])) : '-';

            $row[] = ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '';

            $row[] = $status;

            $row[] = $view;





            $data[] = $row;

        }

        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->receipt_model->count_all_receipt(),

            "recordsFiltered" => $this->receipt_model->count_filtered_receipt(),

            "data" => $data,

        );

        echo json_encode($output);

        exit;

    }



    function purchase_report_ajaxList() {



        $search_data = $this->input->post();

        $search_arr = array();

        $search_arr['po_no'] = $search_data['po_no'];

        $search_arr['sales_man'] = $search_data['sales_man'];

        $search_arr['product'] = $search_data['product'];

        $search_arr['supplier'] = $search_data['supplier'];
        $search_arr['from_date'] = $search_data['from_date'];
        $search_arr['to_date'] = $search_data['to_date'];
         $search_arr['firm_id'] = $search_data['firm_id'];

        if (empty($search_arr)) {

            $search_arr = array();

        }

        $list = $this->purchase_order_model->get_purchase_report_datatables($search_arr);





        $data = array();

        $no = $_POST['start'];

        $paid = $bal = $inv = 0;

        foreach ($list as $val) {



            $url = $this->config->item('base_url') . 'purchase_order/po_view/' . $val['id'];



            $view = '<a href="' . $url . '" data-toggle="tooltip" class="tooltips btn btn-default btn-xs" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>';



            $no++;

            $row = array();

            $row[] = $no;

            $row[] = $val['po_no'];

            $row[] = ($val['store_name']) ? $val['store_name'] : $val['name'];

            $row[] = $val['total_qty'];

            $row[] = number_format($val['net_total'], 2);

           //$row[] = ($val['delivery_schedule'] != '1970-01-01') ? date('d-M-Y', strtotime($val['delivery_schedule'])) : '';

            $row[] = ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '';



            $row[] = $view;



            $data[] = $row;

        }

        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->purchase_order_model->count_all_purchase_report(),

            "recordsFiltered" => $this->purchase_order_model->count_filtered_purchase_report(),

            "data" => $data,

        );

        echo json_encode($output);

        exit;

    }



    function quotation_report_ajaxList() {



        $search_data = $this->input->post();

        $search_arr = array();

        $search_arr['category'] = $search_data['category'];

        //$search_arr['brand'] = $search_data['brand'];

        $search_arr['product'] = $search_data['product'];

        //$search_arr['category'] = $search_data['category'];

        if (empty($search_arr)) {

            $search_arr = array();

        }

        $list = $this->gen_model->get_quotation_report_datatables($search_arr);







        $data = array();

        $no = $_POST['start'];

        $paid = $bal = $inv = 0;

        foreach ($list as $val) {

            $status = $url = $view = '';



            if ($val['estatus'] == 1) {



                $status = '<span class=" badge bg-red">Pending</span>';

            }

            if ($val['estatus'] == 2) {



                $status = '<span class=" badge bg-green">Completed</span>';

            }

            if ($val['estatus'] == 4) {



                $status = '<span class=" badge bg-green">Order Approved</span>';

            }

            if ($val['estatus'] == 5) {



                $status = '<span class="badge bg-yellow">Order Reject</span>';

            }

            $url = $this->config->item('base_url') . 'quotation/quotation_view/' . $val['id'];



            $view = '<a href="' . $url . '" data-toggle="tooltip" class="tooltips btn btn-default btn-xs" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>';



            $no++;

            $row = array();

            $row[] = $no;

            $row[] = $val['q_no'];

            $row[] = ($val['store_name']) ? $val['store_name'] : $val['name'];

            $row[] = $val['total_qty'];

            $row[] = number_format($val['net_total'], 2);

            $row[] = ($val['delivery_schedule'] != '1970-01-01') ? date('d-M-Y', strtotime($val['delivery_schedule'])) : '';

            $row[] = ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '';

            $row[] = $status;

            $row[] = $view;



            $data[] = $row;

        }

        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->gen_model->count_all_quotation_report(),

            "recordsFiltered" => $this->gen_model->count_filtered_quotation_report($search_arr),

            "data" => $data,

        );

        echo json_encode($output);

        exit;

    }



    function outstanding_report_due_date() {

        $data['firms'] = $firms = $this->user_auth->get_user_firms();

        //$data['customers'] = $this->report_model->get_customer_details();



        $this->template->write_view('content', 'report/outstanding_report_due_date', $data);

        $this->template->render();

    }



//    function outstanding_report_due_date_result() {

//	$data = $this->report_model->get_customer_details();

//	echo json_encode($data);

//    }



    function outstanding_report_due_date_search_result() {

        $search_data = $this->input->post();

        $data['customers'] = $this->report_model->get_customer_details($search_data);



        $this->load->view('report/search_outstanding_report_due_date', $data);

    }



    function outstanding_report_firm() {

        $data = array();

        //$data['customers'] = $this->report_model->get_customer_details_firm_wise();



        $this->template->write_view('content', 'report/outstanding_report_firm', $data);

        $this->template->render();

    }



    function outstanding_report_firm_wise_search_result() {

        $search_data = $this->input->post();

        $data['customers'] = $this->report_model->get_customer_details_firm_wise($search_data);



        $this->load->view('report/search_outstanding_report_firm', $data);

    }



    function clear_cache() {

        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");

        $this->output->set_header("Pragma: no-cache");

    }



    /* function attendance_report($page = null) {



      $this->load->model('attendance_model');



      $this->load->model('masters/available_leaves_model');



      $this->load->model('masters/users_model');



      $this->load->model('leave_model');



      $this->load->model('masters/department_model');



      $this->load->model('masters/designation_model');







      $this->load->model('masters/options_model');



      $this->load->model('masters/family_model');



      $this->load->model('masters/holidays_model');



      $this->load->model('masters/user_salary_model');



      $this->load->model('masters/salary_group_model');







      $this->load->model('masters/address_model');



      $this->load->model('masters/user_shift_model');



      $this->load->model('masters/user_history_model');







      //$this->users_model->create_view_for_tds();







      $data["default_number_of_records"] = $this->options_model->get_option_by_name('default_number_of_records');







      $options = array('company_name', 'place', 'district', 'min_ot_hours', 'ot_threshold', 'ot_division', 'saturday_holiday', 'overtime_wages', 'week_starting_day', 'month_starting_date');



      $settings = $this->options_model->get_option_by_name($options);



      if (isset($settings) && !empty($settings)) {



      foreach ($settings as $set) {



      $data[$set["key"]] = $set["value"];

      }

      }



      //print_r($this->session->all_userdata());



      $result = array();



      if ($this->input->post("go")) {



      $filter = $this->input->post();



      if (isset($filter["go"]))

      unset($filter["go"]);







      $year = $filter["year"];



      $month = $filter["month"];







      //$days = cal_days_in_month(CAL_GREGORIAN, $month, $year);







      $start_date = $filter["start_date"];



      $end_date = $filter["end_date"];



      $user_type = $filter["user_type"];



      //print_r($filter);

      //exit;



      $this->users_model->create_view_for_normal_users($end_date);



      $data["no_of_users"] = $this->users_model->get_users_count_with_shift_salary($filter, 1, null, $end_date, $start_date);



      $this->session_view->add_session('reports', 'attendance_reports', $filter);



      redirect($this->config->item('base_url') . "attendance/reports/attendance_reports/");

      }



      else {







      //$filter = $this->session_view->get_session('reports', 'attendance_reports');

      //print_r($filter);

      //exit;





      if (isset($filter) && !empty($filter)) {



      $year = $filter["year"];



      $month = $filter["month"];



      $user_type = $filter["user_type"];



      $start_date = $filter["start_date"];



      $end_date = $filter["end_date"];



      $this->users_model->create_view_for_normal_users($end_date);



      $data["no_of_users"] = $this->users_model->get_users_count_with_shift_salary($filter, 1, null, $end_date, $start_date);

      } else {



      $year = date('Y');



      if (date('d') > $data["month_starting_date"])

      $month = date('m');

      else

      $month = date('m') - 1;



      $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);







      $day = $data["month_starting_date"];



      if ($data["month_starting_date"] == 1) {



      if ($month != 12) {



      $start_date = $year . "-" . $month . "-" . $day;



      $end_date = $year . "-" . $month . "-" . $days;

      } else {



      $start_date = $year . "-" . $month . "-" . $day;



      //$end_date = ($year+1)."-1-".$days;



      $end_date = ($year) . "-12-31";

      }

      } else {



      if ($month != 12) {



      $start_date = $year . "-" . $month . "-" . $day;



      $end_date = $year . "-" . ($month + 1) . "-" . ($day - 1);

      } else {



      $start_date = $year . "-" . $month . "-" . $day;



      $end_date = ($year + 1) . "-1-" . ($day - 1);

      }

      }



      $this->users_model->create_view_for_normal_users($end_date);



      $data["no_of_users"] = $this->users_model->get_users_count_with_shift_salary(null, 1, null, $end_date, $start_date);



      $filter = array("year" => $year, 'month' => $month, "user_type" => 2, "start_date" => $start_date, "end_date" => $end_date);



      //                $this->session_view->add_session('reports', 'attendance_reports', $filter);



      $user_type = 2;

      }

      }





      if (isset($filter["show_count"]))

      $default = $filter["show_count"];







      else {



      if (isset($data["default_number_of_records"]) && !empty($data["default_number_of_records"]))

      $default = $data["default_number_of_records"][0]["value"];

      else

      $default = 10;

      }







      $result["total_rows"] = count($data["no_of_users"]);



      //print_r($result["total_rows"]);



      $result["base_url"] = $this->config->item('base_url') . "/report/attendance_report/";



      $result["per_page"] = $default;



      $result["num_links"] = 3;



      $result["uri_segment"] = 4;



      $result['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';



      $result['full_tag_close'] = '</ul>';



      $result['prev_link'] = '&lt;';



      $result['prev_tag_open'] = '<li>';



      $result['prev_tag_close'] = '</li>';



      $result['next_link'] = '&gt;';



      $result['next_tag_open'] = '<li>';



      $result['next_tag_close'] = '</li>';



      $result['cur_tag_open'] = '<li class="current"><a href="#">';



      $result['cur_tag_close'] = '</a></li>';



      $result['num_tag_open'] = '<li>';



      $result['num_tag_close'] = '</li>';







      $result['first_tag_open'] = '<li>';



      $result['first_tag_close'] = '</li>';



      $result['last_tag_open'] = '<li>';



      $result['last_tag_close'] = '</li>';







      $result['first_link'] = '&lt;&lt;';



      $result['last_link'] = '&gt;&gt;';







      $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;



      $this->pagination->initialize($result);



      $data["links"] = $this->pagination->create_links();



      $data["count"] = $default;



      $this->users_model->create_view_for_normal_users($end_date);



      if ($default == "all")

      $users = $this->users_model->get_users_count_with_shift_salary($filter, 1, null, $end_date, $start_date);

      else

      $users = $this->users_model->get_users_with_shift_salary($filter, 1, null, $end_date, $start_date, $result["per_page"], $page);



      //echo $this->db->last_query();

      //        echo '<pre>';

      //        print_r(($users));





      if (isset($users) && !empty($users)) {







      foreach ($users as $user) {



      $att = $family = $leave = $holiday = $salary = $salary_group = $address = $available = $shift = array();



      $att = $this->attendance_model->get_attendance_by_between_dates($user["id"], $start_date, $end_date);



      $family = $this->family_model->get_family_member_by_relation_and_user_id($user["id"], 'father');



      $leave = $this->leave_model->get_approved_user_leaves_by_between_dates($user["id"], $start_date, $end_date);



      if (empty($family))

      $family = $this->family_model->get_family_member_by_relation_and_user_id($user["id"], 'husband');



      $address = $this->address_model->get_address_by_user_id($user["id"]);



      $holiday = $this->holidays_model->get_holidays_by_between_dates($user["id"], $start_date, $end_date, $user["dept"]);



      $available = $this->available_leaves_model->get_user_leaves_by_user_id($user["id"]);







      $data["users"][] = $user;



      $data["holiday"][] = $holiday;



      $data["salary_group"][] = $salary_group;



      $data["attendance"][] = $att;



      $data["family"][] = $family;



      $data["leave"][] = $leave;



      $data["address"][] = $address;



      $data["available"][] = $available;



      //}

      //else

      //unset($user);

      }

      }





      //if(isset($data["users"]) && !empty($data["users"]))

      //$result["total_rows"] = count($data["users"]);







      $data["start_page"] = $page;



      $data["overtimewages"] = $this->options_model->get_options_by_type('overtime_wages');



      $data["threshold"] = $this->options_model->get_options_by_type('attendance_threshold');



      $data["departments"] = $this->department_model->get_all_departments_by_status(1);



      $data["designations"] = $this->designation_model->get_all_designations();



      //$data["shifts"] = $this->shift_model->get_all_shifts();







      $data["year"] = $year;



      $data["month"] = $month;



      $data["start_date"] = $start_date;



      $data["end_date"] = $end_date;



      $data["user_type"] = $user_type;

      //        echo '<pre>';

      //        print_r($data);

      //        die;

      $this->template->write_view('content', 'attendance_reports', $data);



      $this->template->render();

      } */

}

