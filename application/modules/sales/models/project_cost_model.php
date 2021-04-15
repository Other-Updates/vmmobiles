<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Project_cost_model extends CI_Model {

    private $table_name1 = 'po';
    private $table_name2 = 'po_details';
    private $table_name4 = 'master_style';
    private $table_name5 = 'master_style_size';
    private $table_name6 = 'vendor';
    private $erp_quotation = 'erp_quotation';
    private $erp_quotation_details = 'erp_quotation_details';
    private $customer = 'customer';
    private $increment_table = 'increment_table';
    private $erp_quotation_history = 'erp_quotation_history';
    private $erp_quotation_history_details = 'erp_quotation_history_details';
    private $erp_product = 'erp_product';
    private $erp_user = 'erp_user';
    private $erp_project_cost = 'erp_project_cost';
    private $erp_project_details = 'erp_project_details';
    private $erp_other_cost = 'erp_other_cost';
    private $erp_invoice_details = 'erp_invoice_details';
    private $erp_invoice_product_details = 'erp_invoice_product_details';
    private $erp_invoice = 'erp_invoice';
    private $erp_stock = 'erp_stock';
    private $erp_stock_history = 'erp_stock_history';
    private $erp_po = 'erp_po';
    private $erp_po_details = 'erp_po_details';
    private $erp_email_settings = 'erp_email_settings';
    private $receipt_bill = 'receipt_bill';
    var $joinTable1 = 'customer r';
    var $joinTable2 = 'erp_invoice c';
    var $primaryTable = 'erp_quotation u';
    var $selectColumn = 'u.id,u.q_no,u.net_total,r.store_name,c.id As i_id,c.net_total As inv_amount,c.inv_id,c.invoice_status,c.payment_status,c.delivery_status,c.contract_customer,c.customer,c.created_date';
    var $column_order = array(null, 'u.q_no', 'r.store_name', 'u.net_total', 'c.inv_id', 'c.net_total', 'c.created_date', 'c.invoice_status', 'c.payment_status', 'c.delivery_status', null);
    var $column_search = array('u.q_no', 'r.store_name', 'u.net_total', 'c.inv_id', 'c.net_total', 'c.created_date', 'c.invoice_status', 'c.payment_status', 'c.delivery_status');
    var $order = array('u.id' => 'DESC'); // default order

    function __construct() {

        parent::__construct();

        $this->load->database();
    }

    public function insert_quotation($data) {

        if ($this->db->insert($this->erp_project_cost, $data)) {

            $insert_id = $this->db->insert_id();

            return $insert_id;
        }

        return false;
    }

    public function get_customer_by_firm($id) {
        $this->db->Select('id,store_name');
        $this->db->where('firm_id', $id);
        $query = $this->db->get('customer')->result_array();

        $result = [];

        foreach ($query as $key => $data) {
            $result[$key]['id'] = $data['id'];
            $result[$key]['value'] = $data['store_name'];
        }
        return $result;
    }

    public function remove_stocks_by_invdit($product_id, $qty, $firm_id, $cat_id) {

        if ($qty != 0) {
            $this->db->where('firm_id', $firm_id);
            $this->db->where('product_id', $product_id);
            $this->db->where('category', $cat_id);
            $get_old_qty = $this->db->get('erp_stock')->result_array();

            $old_stock_qty = $get_old_qty[0]['quantity'];

            $new_qty = $qty;


            $qty_product = $old_stock_qty + $qty;


            $this->db->where('firm_id', $firm_id);
            $this->db->where('product_id', $product_id);
            $this->db->where('category', $cat_id);
            $this->db->update('erp_stock', ['quantity' => $qty_product]);
        }
    }

    public function get_sales_ime_details($id) {
        $this->db->select('ime_code');
        $this->db->where('sales_id', $id);
        $query = $this->db->get('erp_po_ime_code_details')->result_array();
        return $query;
    }

    public function insert_quotation_details($data) {

        $this->db->insert_batch($this->erp_project_details, $data);

        return true;
    }

    public function insert_invoice($data) {

        if ($this->db->insert($this->erp_invoice, $data)) {

            $insert_id = $this->db->insert_id();



            return $insert_id;
        }

        return false;
    }

    public function insert_invoice_details($data) {

        $this->db->insert_batch($this->erp_invoice_details, $data);

        return true;
    }

    public function insert_invoicedetails($data) {

        if ($this->db->insert($this->erp_invoice_details, $data)) {

            $insert_id = $this->db->insert_id();



            return $insert_id;
        }

        return false;
    }

    public function insert_invoice_product_details($data) {

        $this->db->insert_batch($this->erp_invoice_product_details, $data);

        return true;
    }

    public function insert_other_cost($data) {

        $this->db->insert_batch($this->erp_other_cost, $data);

        return true;
    }

    public function get_all_email_details() {

        $this->db->select('*');

        $this->db->where("(type='inv_sender' OR type='inv_email' OR type='inv_subject' OR type='inv_cc_email')");

        // $this->db->where($this->erp_email_settings.'.type','q_email');

        $query = $this->db->get($this->erp_email_settings)->result_array();

        return $query;
    }

    public function update_increment($id) {

        $this->db->where($this->increment_table . '.id', 6);

        if ($this->db->update($this->increment_table, $id)) {

            return true;
        }

        return false;
    }

    public function update_increment2($id) {

        $this->db->where($this->increment_table . '.id', 7);

        if ($this->db->update($this->increment_table, $id)) {

            return true;
        }

        return false;
    }

    public function get_customer($atten_inputs, $id) {

        $this->db->select('name,id,mobil_number,email_id,address1,tin,state_id');

        $this->db->where($this->customer . '.status', 1);

        $this->db->where($this->customer . '.firm_id', $id);

        $this->db->like($this->customer . '.name', $atten_inputs['q']);

        $query = $this->db->get($this->customer)->result_array();

        return $query;
    }

    public function get_customer_by_id($id) {

        $this->db->select('name,mobil_number,email_id,address1');

        $this->db->where($this->customer . '.id', $id);

        return $this->db->get($this->customer)->result_array();
    }

    public function get_all_nick_name() {

        $this->db->select('*');

        $this->db->where($this->erp_user . '.status', 1);

        $query = $this->db->get($this->erp_user)->result_array();

        return $query;
    }

    public function get_service_cost($id) {

        $this->db->select('SUM(sub_total) as service_cost');

        $this->db->where($this->erp_project_details . '.j_id', $id);

        $this->db->where($this->erp_project_details . '.product_type', 2);

        return $this->db->get($this->erp_project_details)->result_array();
    }

    public function get_other_cost($id) {

        $this->db->select('SUM(amount) as other_cost');

        $this->db->where($this->erp_other_cost . '.j_id', $id);

        return $this->db->get($this->erp_other_cost)->result_array();
    }

    public function get_receipt_id($id) {

        $this->db->select('receipt_id');

        $this->db->where($this->receipt_bill . '.recevier_id', $id);

        return $this->db->get($this->receipt_bill)->result_array();
    }

    public function get_all_quotation_no() {

        $this->db->select('q_no,id');

        $query = $this->db->get($this->erp_quotation)->result_array();

        return $query;
    }

    public function get_product($atten_inputs, $id) {

        $this->db->select('id,model_no,product_name,product_description,product_image,cost_price,sales_price,cgst,sgst,category_id,igst');

        $this->db->where($this->erp_product . '.status', 1);

        if ($id != '')
            $this->db->where($this->erp_product . '.firm_id', $id);

        //$this->db->where($this->erp_product . '.category_id', $id);

        $this->db->where($this->erp_product . '.type', 1);

        $this->db->like($this->erp_product . '.model_no', $atten_inputs['q']);

        $query = $this->db->get($this->erp_product)->result_array();

        return $query;
    }

    public function get_service($atten_inputs, $id) {

        $this->db->select('id,model_no,product_name,product_description,product_image,type,cost_price,cgst,sgst,category_id,igst');

        $this->db->where($this->erp_product . '.status', 1);

        if ($id != '')
            $this->db->where($this->erp_product . '.firm_id', $id);

        // $this->db->where($this->erp_product . '.category_id', $id);

        $this->db->where($this->erp_product . '.type', 2);

        $this->db->like($this->erp_product . '.model_no', $atten_inputs['s']);

        $query = $this->db->get($this->erp_product)->result_array();

        return $query;
    }

    public function get_product_by_id($id) {

        $this->db->select('model_no,product_name,product_description,product_image,cost_price');

        $this->db->where($this->erp_product . '.id', $id);

        return $this->db->get($this->erp_product)->result_array();
    }

    public function get_all_project_cost($serch_data) {

        if (!empty($serch_data['from_date']))
            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

        if (!empty($serch_data['to_date']))
            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

        if ($serch_data['from_date'] == '1970-01-01')
            $serch_data['from_date'] = '';

        if ($serch_data['to_date'] == '1970-01-01')
            $serch_data['to_date'] = '';



        if (!empty($serch_data['job_id']) && $serch_data['job_id'] != 'Select') {



            $this->db->where($this->erp_project_cost . '.job_id', $serch_data['job_id']);
        }

        if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

            $this->db->where($this->erp_project_cost . '.customer', $serch_data['customer']);
        }

        if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

            $this->db->where($this->erp_project_details . '.product_id', $serch_data['product']);
        }





        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_project_cost . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_project_cost . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_project_cost . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_project_cost . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        }



        $this->db->select('customer.id as customer,customer.store_name,customer.state_id,customer.tin, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_project_cost.id,erp_project_cost.job_id,erp_project_cost.total_qty,erp_project_cost.tax,erp_project_cost.tax_label,'
                . 'erp_project_cost.net_total,erp_project_cost.created_date,erp_project_cost.remarks,erp_project_cost.subtotal_qty,erp_project_cost.estatus');

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->where_in('erp_project_cost.firm_id', $frim_id);

        //$this->db->join('erp_quotation', 'erp_quotation.id=erp_project_cost.q_no');

        $this->db->join('customer', 'customer.id=erp_project_cost.customer');

        $this->db->join('erp_project_details', 'erp_project_details.j_id=erp_project_cost.id');

        $this->db->group_by('erp_project_cost.id');

        //$this->db->order_by('erp_project_cost.id', 'desc');

        $query = $this->db->get('erp_project_cost')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            $this->db->where('j_id', intval($val['id']));

            $this->db->where('type =', project_cost);

            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();

            $i++;
        }

        $j = 0;

        foreach ($query as $val) {

            $this->db->select('sum(sub_total - ( per_cost * quantity )) as tot_tax');

            $this->db->where($this->erp_project_details . '.j_id', $val['id']);

            $query[$j]['tax_details'] = $this->db->get($this->erp_project_details)->result_array();

            $j++;
        }

        return $query;

        //echo"<pre>"; print_r($query); exit;
    }

    public function get_all_pc($serch_data) {

        if (!empty($serch_data['from_date']))
            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

        if (!empty($serch_data['to_date']))
            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

        if ($serch_data['from_date'] == '1970-01-01')
            $serch_data['from_date'] = '';

        if ($serch_data['to_date'] == '1970-01-01')
            $serch_data['to_date'] = '';



        if (!empty($serch_data['job_id']) && $serch_data['job_id'] != 'Select') {



            $this->db->where($this->erp_project_cost . '.job_id', $serch_data['job_id']);
        }

        if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

            $this->db->where($this->erp_project_cost . '.customer', $serch_data['customer']);
        }

        if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

            $this->db->where($this->erp_project_details . '.product_id', $serch_data['product']);
        }





        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_project_cost . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_project_cost . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_project_cost . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_project_cost . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        }



        $this->db->select('customer.id as customer,customer.store_name,customer.tin,customer.state_id, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_project_cost.id,erp_project_cost.job_id,erp_project_cost.total_qty,erp_project_cost.tax,erp_project_cost.tax_label,'
                . 'erp_project_cost.net_total,erp_project_cost.created_date,erp_project_cost.remarks,erp_project_cost.subtotal_qty,erp_project_cost.estatus');

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->where_in('erp_project_cost.firm_id', $frim_id);

        if (empty($serch_data)) {

            $this->db->where("DATE_FORMAT(" . $this->erp_project_cost . ".created_date,'%m') = '" . date('m') . "'");
        }

        //$this->db->join('erp_quotation', 'erp_quotation.id=erp_project_cost.q_no');

        $this->db->join('customer', 'customer.id=erp_project_cost.customer');

        $this->db->join('erp_project_details', 'erp_project_details.j_id=erp_project_cost.id');

        $this->db->group_by('erp_project_cost.id');

        //$this->db->order_by('erp_project_cost.id', 'desc');

        $query = $this->db->get('erp_project_cost')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            $this->db->where('j_id', intval($val['id']));

            $this->db->where('type =', project_cost);

            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();

            $i++;
        }

        $j = 0;

        foreach ($query as $val) {

            $this->db->select('sum(sub_total - ( per_cost * quantity )) as tot_tax');

            $this->db->where($this->erp_project_details . '.j_id', $val['id']);

            $query[$j]['tax_details'] = $this->db->get($this->erp_project_details)->result_array();

            $j++;
        }

        return $query;

        //echo"<pre>"; print_r($query); exit;
    }

    function get_pc_datatables($search_data) {



        $this->_get_pc_datatables_query($search_data);

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get('erp_project_cost')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            $this->db->where('j_id', intval($val['id']));

            $this->db->where('type =', project_cost);

            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();

            $i++;
        }

        $j = 0;

        foreach ($query as $val) {

            $this->db->select('sum(sub_total - ( per_cost * quantity )) as tot_tax');

            $this->db->where($this->erp_project_details . '.j_id', $val['id']);

            $query[$j]['tax_details'] = $this->db->get($this->erp_project_details)->result_array();

            $j++;
        }

        return $query;
    }

    function _get_pc_datatables_query($serch_data = array()) {

        if (!isset($serch_data['from_date']))
            $serch_data['from_date'] = '';

        if (!isset($serch_data['to_date']))
            $serch_data['to_date'] = '';

        if (!empty($serch_data['from_date']))
            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

        if (!empty($serch_data['to_date']))
            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

        if ($serch_data['from_date'] == '1970-01-01')
            $serch_data['from_date'] = '';

        if ($serch_data['to_date'] == '1970-01-01')
            $serch_data['to_date'] = '';



        if (!empty($serch_data['job_id']) && $serch_data['job_id'] != 'Select') {



            $this->db->where($this->erp_project_cost . '.job_id', $serch_data['job_id']);
        }

        if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

            $this->db->where($this->erp_project_cost . '.customer', $serch_data['customer']);
        }

        if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

            $this->db->where($this->erp_project_details . '.product_id', $serch_data['product']);
        }





        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_project_cost . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_project_cost . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_project_cost . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_project_cost . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        }



        $this->db->select('customer.id as customer,customer.store_name,customer.tin,customer.state_id, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_project_cost.id,erp_project_cost.job_id,erp_project_cost.total_qty,erp_project_cost.tax,erp_project_cost.tax_label,'
                . 'erp_project_cost.net_total,erp_project_cost.created_date,erp_project_cost.remarks,erp_project_cost.subtotal_qty,erp_project_cost.estatus');

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->where_in('erp_project_cost.firm_id', $frim_id);

        if (empty($serch_data)) {

            $this->db->where("DATE_FORMAT(" . $this->erp_project_cost . ".created_date,'%m') = '" . date('m') . "'");
        }

        //$this->db->join('erp_quotation', 'erp_quotation.id=erp_project_cost.q_no');

        $this->db->join('customer', 'customer.id=erp_project_cost.customer');

        $this->db->join('erp_project_details', 'erp_project_details.j_id=erp_project_cost.id');

        $this->db->group_by('erp_project_cost.id');
    }

    function count_filtered_pc() {

        $this->_get_pc_datatables_query();

        $query = $this->db->get('erp_project_cost');

        return $query->num_rows();
    }

    function count_all_pc() {

        $this->_get_pc_datatables_query();

        $this->db->from('erp_project_cost');

        return $this->db->count_all_results();
    }

    public function get_all_project_cost_for_report($search = NULL) {



        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->select('customer.id as customer,customer.store_name,customer.tin,customer.state_id, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_project_cost.id,erp_project_cost.job_id,erp_project_cost.total_qty,erp_project_cost.tax,erp_project_cost.tax_label,'
                . 'erp_project_details.j_id,erp_project_cost.net_total,erp_project_cost.created_date,erp_project_cost.remarks,erp_project_cost.subtotal_qty,erp_project_cost.estatus');

        //  $this->db->join('erp_quotation', 'erp_quotation.id=erp_project_cost.q_id');

        $this->db->join('customer', 'customer.id=erp_project_cost.customer');

        if ($search != NULL && $search != '') {



            $search_data = json_decode($search);



            if ($search_data[0]->job_id != '' && $search_data[0]->job_id != 'Select') {

                $this->db->where('erp_project_cost.job_id', $search_data[0]->job_id);
            }

            if ($search_data[1]->customer != '' && $search_data[1]->customer != 'Select') {

                $this->db->where('erp_project_cost.customer', $search_data[1]->customer);
            }

            if (($search_data[2]->product) && $search_data[2]->product != 'Select') {

                $this->db->where($this->erp_project_details . '.product_id', $search_data[2]->product);
            }

            if ($search_data[3]->from != '') {

                $this->db->where($this->erp_project_cost . '.created_date >=', $search_data[3]->from);
            }

            if ($search_data[4]->to != '') {

                $this->db->where($this->erp_project_cost . '.created_date <=', $search_data[4]->to);
            }
        }

        $this->db->where_in('erp_project_cost.firm_id', $frim_id);

        $this->db->join('erp_project_details', 'erp_project_details.j_id=erp_project_cost.id');

        $this->db->group_by('erp_project_cost.id');

        $query = $this->db->get('erp_project_cost')->result_array();



        $i = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            $this->db->where('j_id', intval($val['id']));

            $this->db->where('type =', project_cost);

            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();

            $i++;
        }

        $j = 0;

        foreach ($query as $val) {

            $this->db->select('sum(sub_total - ( per_cost * quantity )) as tot_tax');

            $this->db->where($this->erp_project_details . '.j_id', $val['id']);

            $query[$j]['tax_details'] = $this->db->get($this->erp_project_details)->result_array();

            $j++;
        }



        return $query;

        //        if ($query->num_rows() >= 0) {
        //            return $query->result_array();
        //        }
        //        return false;
    }

    public function get_invoice($serch_data) {



        //echo "<pre>";
        //print_r($serch_data);
        //exit;



        if (!empty($serch_data['from_date']))
            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

        if (!empty($serch_data['to_date']))
            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

        if ($serch_data['from_date'] == '1970-01-01')
            $serch_data['from_date'] = '';

        if ($serch_data['to_date'] == '1970-01-01')
            $serch_data['to_date'] = '';

        $invoiceIds = array();

        if (!empty($serch_data['gst']) && $serch_data['gst'] != '' && $serch_data['gst'] != 'Select') {

            $invoice_ids = array();

            $where_gst = '(erp_invoice_details.tax="' . $serch_data['gst'] . '" OR erp_invoice_details.gst = "' . $serch_data['gst'] . '")';

            //$this->db->select('erp_invoice.id');

            $this->db->select('erp_invoice_details.*');

            $this->db->join('erp_invoice', 'erp_invoice_details.in_id=erp_invoice.id');

            $this->db->where($where_gst);

            if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {

                $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);
            }

            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

                $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);
            }

            if (!empty($serch_data['sales_man']) && $serch_data['sales_man'] != 'Select') {

                $this->db->where($this->erp_invoice . '.sales_man', $serch_data['sales_man']);
            }

            if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

                $this->db->where($this->erp_invoice_details . '.product_id', $serch_data['product']);
            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }



            $invoices = $this->db->get('erp_invoice_details')->result_array();

            //echo $this->db->last_query();
            //exit;



            $inv_all_details = array();

            $count = 1;

            if (!empty($invoices)) {

                /* Search Particular products in that GST % From the Invoice */

                foreach ($invoices as $invoices_values) {

                    $invoice_id = $invoices_values['in_id'];

                    $tax = $invoices_values['tax'];

                    $per_cost = $invoices_values['per_cost'];

                    $quantity = $invoices_values['quantity'];

                    $gst = $invoices_values['gst'];

                    $cgst = ($tax / 100) * ($per_cost * $quantity);

                    $sgst = ($gst / 100) * ($per_cost * $quantity);

                    if (!isset($inv_all_details[$invoice_id]['quantity'])) {

                        $inv_all_details[$invoice_id]['in_id'] = $invoice_id;

                        $inv_all_details[$invoice_id]['quantity'] = $quantity;

                        $inv_all_details[$invoice_id]['cgst'] = $cgst;

                        $inv_all_details[$invoice_id]['sgst'] = $sgst;
                    } else {

                        $inv_all_details[$invoice_id]['quantity'] = $inv_all_details[$invoice_id]['quantity'] + $quantity;

                        $inv_all_details[$invoice_id]['cgst'] = $inv_all_details[$invoice_id]['cgst'] + ($cgst);

                        $inv_all_details[$invoice_id]['sgst'] = $inv_all_details[$invoice_id]['sgst'] + $sgst;
                    }
                }



                $invoiceIds = array_map(function ($invoices) {

                    return $invoices['in_id'];
                }, $invoices);



                if (!empty($invoiceIds)) {



                    $invoiceIds = array_unique($invoiceIds);

                    $this->db->where_in($this->erp_invoice . '.id', $invoiceIds);
                } else {

                    $this->db->where($this->erp_invoice . '.id', -1);
                }
            } else {

                $this->db->where($this->erp_invoice . '.id', -1);
            }
        }



        if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {

            $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);
        }

        if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

            $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);
        }

        if (!empty($serch_data['sales_man']) && $serch_data['sales_man'] != 'Select') {

            $this->db->where($this->erp_invoice . '.sales_man', $serch_data['sales_man']);
        }

        if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

            $this->db->where($this->erp_invoice_details . '.product_id', $serch_data['product']);
        }

        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        }



        $this->db->select('customer.id as customer,customer.store_name,customer.tin,customer.state_id, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_quotation.q_no,erp_invoice.total_qty,erp_invoice.tax,erp_quotation.ref_name,erp_invoice.tax_label,'
                . 'erp_invoice.net_total,erp_invoice.created_date,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_sales_man.sales_man_name,erp_invoice.q_id');





        if (empty($serch_data['firm_id'])) {

            $firms = $this->user_auth->get_user_firms();

            $frim_id = array();

            foreach ($firms as $value) {

                $frim_id[] = $value['firm_id'];
                $this->db->where_in('erp_invoice.firm_id', $frim_id);
            }
        } else {
            $frim_id = $serch_data['firm_id'];
            $this->db->where('erp_invoice.firm_id', $frim_id);
        }



        //if (empty($serch_data)) {
        //  $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%m') = '" . date('m') . "'");
        //}

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->join('erp_sales_man', 'erp_sales_man.id=erp_invoice.sales_man', 'LEFT');

        $this->db->join('erp_invoice_details', 'erp_invoice_details.in_id=erp_invoice.id');

        $this->db->group_by('erp_invoice.id');



        $query = $this->db->get('erp_invoice')->result_array();

        //echo $this->db->last_query();
        //exit;







        $i = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            $this->db->where('j_id', intval($val['id']));

            $this->db->where('type', 'invoice');

            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();

            $i++;
        }







        $i2 = 0;

        foreach ($query as $val) {

            $this->db->select('SUM((tax / 100 ) * (per_cost * quantity)) as cgst, SUM((gst / 100 ) * (per_cost * quantity)) as sgst');

            $this->db->where('in_id', intval($val['id']));

            $query[$i2]['erp_invoice_details'] = $this->db->get('erp_invoice_details')->result_array();

            $i2++;
        }







        $j = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date,MAX(created_date) AS paid_date');

            $this->db->where('receipt_bill.receipt_id', $val['id']);

            $query[$j]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();

            $j++;
        }



        if (!empty($inv_all_details) && !empty($query)) {

            $query['inv_all_details'] = $inv_all_details;
        }

        return $query;
    }

    public function get_gst_invoice($serch_data) {



        if (!empty($serch_data['from_date']))
            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

        if (!empty($serch_data['to_date']))
            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

        if ($serch_data['from_date'] == '1970-01-01')
            $serch_data['from_date'] = '';

        if ($serch_data['to_date'] == '1970-01-01')
            $serch_data['to_date'] = '';

        $invoiceIds = array();

        if (!empty($serch_data['gst']) && $serch_data['gst'] != '' && $serch_data['gst'] != 'Select') {



            $invoice_ids = array();

            $where_gst = '(erp_invoice_details.tax="' . $serch_data['gst'] . '" OR erp_invoice_details.gst = "' . $serch_data['gst'] . '")';

            //$this->db->select('erp_invoice.id');

            $this->db->select('erp_invoice_details.*');

            $this->db->join('erp_invoice', 'erp_invoice_details.in_id=erp_invoice.id');

            $this->db->join('customer', 'customer.id=erp_invoice.customer');

            $this->db->where($where_gst);

            if (!empty($serch_data['firm_id']) && $serch_data['firm_id'] != 'Select') {

                $this->db->where($this->erp_invoice . '.firm_id', $serch_data['firm_id']);
            } else {

                $firms = $this->user_auth->get_user_firms();

                $frim_id = array();

                foreach ($firms as $value) {

                    $frim_id[] = $value['firm_id'];
                }

                $this->db->where_in('erp_invoice.firm_id', $frim_id);
            }

            $inv_id = array();

            foreach ($serch_data['inv_id'] as $values) {

                $inv_id[] = $values;
            }

            if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {

                $this->db->where_in($this->erp_invoice . '.id', $inv_id);
            }



            if (!empty($serch_data['cust_type']) && $serch_data['cust_type'] != 'Select') {

                if ($serch_data['cust_type'] == 1) {

                    //                    $this->db->where($this->customer . '.tin IS NOT NULL', null, false);

                    $this->db->where($this->customer . '.tin IS NULL');
                } else if ($serch_data['cust_type'] == 2) {

                    //  $this->db->where($this->customer . '.tin', '');
                    // $this->db->where($this->customer . '.tin !=', '');

                    $this->db->where($this->customer . '.tin IS NOT NULL', null, false);
                }
            }



            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }



            $invoices = $this->db->get('erp_invoice_details')->result_array();



            $inv_all_details = array();

            $count = 1;

            if (!empty($invoices)) {

                /* Search Particular products in that GST % From the Invoice */

                foreach ($invoices as $invoices_values) {

                    //$cgst = $sgst = $total_gst = 0;

                    $invoice_id = $invoices_values['in_id'];

                    $tax = $invoices_values['tax'];

                    $per_cost = $invoices_values['per_cost'];

                    $quantity = $invoices_values['quantity'];

                    $gst = $invoices_values['gst'];

                    $cgst = ($tax / 100) * ($per_cost * $quantity);

                    $sgst = ($gst / 100) * ($per_cost * $quantity);

                    $total_gst = ($cgst) + ($sgst);

                    $sub_total = ($per_cost * $quantity);

                    if (!isset($inv_all_details[$invoice_id]['quantity'])) {

                        $inv_all_details[$invoice_id]['in_id'] = $invoice_id;

                        $inv_all_details[$invoice_id]['quantity'] = $quantity;

                        $inv_all_details[$invoice_id]['cgst'] = $cgst;

                        $inv_all_details[$invoice_id]['sgst'] = $sgst;

                        $inv_all_details[$invoice_id]['total_gst'] += $total_gst;

                        $inv_all_details[$invoice_id]['sub_total'] += ($per_cost * $quantity);
                    } else {

                        $inv_all_details[$invoice_id]['quantity'] = $inv_all_details[$invoice_id]['quantity'] + $quantity;

                        $inv_all_details[$invoice_id]['cgst'] = $inv_all_details[$invoice_id]['cgst'] + ($cgst);

                        $inv_all_details[$invoice_id]['sgst'] = $inv_all_details[$invoice_id]['sgst'] + $sgst;

                        $inv_all_details[$invoice_id]['total_gst'] += $total_gst;

                        $inv_all_details[$invoice_id]['sub_total'] += ($per_cost * $quantity);
                    }
                }



                $invoiceIds = array_map(function ($invoices) {

                    return $invoices['in_id'];
                }, $invoices);



                if (!empty($invoiceIds)) {



                    $invoiceIds = array_unique($invoiceIds);

                    $this->db->where_in($this->erp_invoice . '.id', $invoiceIds);
                } else {

                    $this->db->where($this->erp_invoice . '.id', -1);
                }
            } else {

                $this->db->where($this->erp_invoice . '.id', -1);
            }
        }



        if (!empty($serch_data['firm_id']) && $serch_data['firm_id'] != 'Select') {

            $this->db->where($this->erp_invoice . '.firm_id', $serch_data['firm_id']);
        }

        $inv_id = array();

        foreach ($serch_data['inv_id'] as $values) {

            $inv_id[] = $values;
        }

        if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {

            $this->db->where_in($this->erp_invoice . '.id', $inv_id);
        }

        if (!empty($serch_data['cust_type']) && $serch_data['cust_type'] != 'Select') {



            if ($serch_data['cust_type'] == 1) {

                $this->db->where($this->customer . '.tin IS NULL');

                // $this->db->where($this->customer . '.tin IS NOT NULL', null, false);
            } else if ($serch_data['cust_type'] == 2) {

                $this->db->where($this->customer . '.tin IS NOT NULL', null, false);

                //  $this->db->where($this->customer . '.tin', '');
            }
        }



        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        }



        $this->db->select('customer.id as customer,customer.store_name,customer.tin,customer.state_id, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_quotation.q_no,erp_invoice.total_qty,erp_invoice.tax,erp_quotation.ref_name,erp_invoice.tax_label,'
                . 'erp_invoice.net_total,erp_invoice.created_date,'
                . 'erp_invoice.remarks,erp_invoice.subtotal_qty,'
                . 'erp_invoice.estatus,erp_invoice.customer_po,erp_sales_man.sales_man_name,erp_invoice.q_id,erp_manage_firms.gstin,,erp_manage_firms.firm_name');



        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }



        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        $this->db->where('erp_invoice.subtotal_qty !=', 0);

        //if (empty($serch_data)) {
        //  $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%m') = '" . date('m') . "'");
        //}

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_invoice.firm_id');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->join('erp_sales_man', 'erp_sales_man.id=erp_invoice.sales_man', 'LEFT');

        $this->db->join('erp_invoice_details', 'erp_invoice_details.in_id=erp_invoice.id');

        $this->db->group_by('erp_invoice.id');

        $this->db->order_by('erp_invoice.id', 'desc');



        $query = $this->db->get('erp_invoice')->result_array();



        //        echo $this->db->last_query();
        //        exit;

        $i = 0;

        foreach ($query as $val) {



            $this->db->select('*');

            $this->db->where('j_id', intval($val['id']));

            $this->db->where('type', 'invoice');

            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();

            $i++;
        }

        $i2 = 0;

        foreach ($query as $val) {

            $this->db->select('SUM((tax / 100 ) * (per_cost * quantity)) as cgst, SUM((gst / 100 ) * (per_cost * quantity)) as sgst');

            $this->db->where('in_id', intval($val['id']));

            $query[$i2]['erp_invoice_details'] = $this->db->get('erp_invoice_details')->result_array();

            $i2++;
        }

        $j = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date,MAX(created_date) AS paid_date');

            $this->db->where('receipt_bill.receipt_id', $val['id']);

            $query[$j]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();

            $j++;
        }



        if (!empty($inv_all_details) && !empty($query)) {

            $query['inv_all_details'] = $inv_all_details;
        }

        return $query;
    }

    public function get_all_pc_by_id($id) {

        $this->db->select('customer.id as customer,customer.store_name,customer.tin,customer.state_id, customer.name,customer.mobil_number,customer.email_id,customer.address1,customer.account_num, customer.ifsc,customer.bank_name,erp_project_cost.id,erp_project_cost.job_id,erp_project_cost.total_qty,erp_project_cost.tax,erp_project_cost.tax_label,erp_project_cost.ref_name,'
                . 'erp_project_cost.net_total,erp_project_cost.remarks,erp_project_cost.subtotal_qty,erp_project_cost.q_no,erp_project_cost.estatus,erp_project_cost.created_date,erp_manage_firms.firm_id,erp_manage_firms.firm_name');

        //$this->db->where('erp_project_cost.estatus',1);

        $this->db->where('erp_project_cost.id', $id);

        $this->db->join('customer', 'customer.id=erp_project_cost.customer');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_project_cost.firm_id');

        $query = $this->db->get('erp_project_cost')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            $this->db->where('j_id', intval($val['id']));

            $this->db->where('type =', project_cost);

            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();

            $i++;
        }

        return $query;
    }

    public function get_all_pc_details_by_id($id) {

        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,'
                . 'erp_project_details.category,erp_project_details.product_id,erp_project_details.brand,erp_project_details.quantity,erp_project_details.unit,erp_project_details.igst,'
                . 'erp_project_details.per_cost,erp_project_details.tax,erp_project_details.gst,erp_project_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,erp_project_details.discount,'
                . 'erp_project_details.product_description');

        $this->db->where('erp_project_details.j_id', $id);

        $this->db->join('erp_category', 'erp_category.cat_id=erp_project_details.category', 'left');

        $this->db->join('erp_product', 'erp_product.id=erp_project_details.product_id');

        $this->db->join('erp_brand', 'erp_brand.id=erp_project_details.brand', 'left');



        $query = $this->db->get('erp_project_details');

        if ($query->num_rows() >= 0) {

            return $query->result_array();

            //echo"<pre>"; print_r($query->result_array()); exit;
        }

        return false;
    }

    public function get_all_invoice_by_id($id) {

        $this->db->select('erp_user.nick_name,customer.id as customer,customer.store_name,customer.tin,customer.state_id,customer.advance, customer.name,customer.mobil_number,customer.email_id,customer.address1,customer.account_num, customer.ifsc,customer.bank_name,customer.customer_type,erp_invoice.id,erp_invoice.q_id,erp_invoice.inv_id,erp_quotation.q_no,erp_invoice.total_qty,erp_invoice.tax,erp_quotation.ref_name,erp_invoice.tax_label,'
                . 'erp_invoice.net_total,erp_invoice.round_off,erp_invoice.transport,erp_invoice.labour,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_invoice.created_date,erp_invoice.firm_id,erp_invoice.sales_man,erp_invoice.invoice_status,erp_invoice.delivery_status,erp_manage_firms.firm_name,erp_sales_man.sales_man_name,erp_invoice.cgst_price,erp_invoice.sgst_price,erp_invoice.taxable_price,erp_invoice.bill_type');

        //$this->db->where('erp_invoice.estatus',1);

        $this->db->where('erp_invoice.id', $id);

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id', 'LEFT');

        $this->db->join('customer', 'customer.id=erp_invoice.customer', 'LEFT');

        $this->db->join('erp_user', 'erp_user.id=erp_quotation.ref_name', 'LEFT');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_invoice.firm_id', 'LEFT');

        $this->db->join('erp_sales_man', 'erp_sales_man.id=erp_invoice.sales_man', 'LEFT');

        $query = $this->db->get('erp_invoice')->result_array();

        // echo $this->db->last_query();
        // exit;

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            $this->db->where('j_id', intval($val['id']));

            $this->db->where('type', 'invoice');

            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();

            $i++;
        }

        return $query;
    }

    public function get_all_invoice_details_by_id($id) {

        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,erp_product.hsn_sac_name,erp_invoice_details.category,erp_invoice_details.product_id,erp_invoice_details.brand,erp_invoice_details.quantity,erp_invoice_details.unit,'
                . 'erp_invoice_details.per_cost,erp_invoice_details.tax,erp_invoice_details.gst,erp_invoice_details.sub_total,erp_product.model_no,erp_product.product_image,erp_invoice_details.discount,erp_invoice_details.igst,'
                . 'erp_invoice_details.product_description,erp_invoice_details.id,erp_product.hsn_sac,erp_product.sales_price_without_gst,,erp_invoice_details.sp_with_gst');

        $this->db->where('erp_invoice_details.in_id', intval($id));

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice_details.q_id', 'LEFT');

        $this->db->join('erp_category', 'erp_category.cat_id=erp_invoice_details.category', 'left');

        $this->db->join('erp_product', 'erp_product.id=erp_invoice_details.product_id');

        $this->db->join('erp_brand', 'erp_brand.id=erp_invoice_details.brand', 'left');



        $query = $this->db->get('erp_invoice_details')->result_array();



        $i = 0;

        foreach ($query as $val) {

            $this->db->select('erp_stock.quantity');

            $this->db->where('product_id', $val['product_id']);

            //  if ($val['category'] != '')
            //    $this->db->where('category', $val['category']);
            //   if ($val['brand'] != '')
            //       $this->db->where('brand', $val['brand']);

            $query[$i]['stock'] = $this->db->get('erp_stock')->result_array();

            $this->db->select('ime_code');
            $this->db->where('sales_details_id', $val['id']);
            $this->db->where('sales_id', $id);
            $ime_details = $this->db->get('erp_po_ime_code_details')->result_array();
            $sale_ime = array();
            foreach ($ime_details as $datas_ime) {
                $sale_ime[] = $datas_ime['ime_code'];
            }

            $query[$i]['ime_code_details'] = $sale_ime;

            $query[$i]['ime_code_details_hidden'] = implode(',', $sale_ime);





            $this->db->select('ime_code');

            $this->db->where('status', 'open');

            $this->db->where('product_id', $val['product_id']);

            $this->db->or_where('sales_id', $id);


            $ime_details = $this->db->get('erp_po_ime_code_details')->result_array();

            $query[$i]['ime_code_all_details'] = $ime_details;



            $i++;
        }

        return $query;
    }

    public function open_imeie($id) {

        $this->db->or_where('sales_id', $id);

        $ime_details = $this->db->update('erp_po_ime_code_details', ["status" => 'open']);
    }

    public function get_all_sales_id() {

        $this->db->select('erp_project_cost.id,erp_project_cost.job_id ,erp_project_cost.firm_id,erp_project_cost.net_total,erp_project_cost.customer,customer.name');

        $this->db->where('erp_project_cost.estatus =', 2);

        $this->db->join('customer', 'customer.id=erp_project_cost.customer', 'LEFT');

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->where_in('erp_project_cost.firm_id', $frim_id);

        $this->db->order_by('erp_project_cost.id', 'desc');

        $query = $this->db->get('erp_project_cost')->result_array();

        //        echo $this->db->last_query();
        //        die;

        return $query;
    }

    public function get_all_quotation() {

        $this->db->select('erp_project_cost.id,customer.id as customer,customer.store_name,customer.state_id, customer.tin,customer.name,customer.mobil_number,customer.email_id,customer.address1,customer.customer_type,customer.credit_days, customer.credit_limit, customer.temp_credit_limit, customer.approved_by,erp_project_cost.total_qty,erp_project_cost.tax,erp_project_cost.tax_label,'
                . 'erp_project_cost.job_id,erp_project_cost.net_total,erp_project_cost.notification_date,erp_project_cost.remarks,erp_project_cost.subtotal_qty,erp_project_cost.estatus,erp_project_cost.created_date');

        //$this->db->where('erp_project_cost.estatus =', 2);

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->where_in('erp_project_cost.firm_id', $frim_id);

        $this->db->join('customer', 'customer.id=erp_project_cost.customer', 'LEFT');

        $this->db->order_by('erp_project_cost.id', 'desc');

        $query = $this->db->get('erp_project_cost')->result_array();



        /* $i = 0;

          foreach ($query as $val) {

          $this->db->select('*');

          $this->db->where('q_id', intval($val['id']));

          $query[$i]['pc_amount'] = $this->db->get('erp_project_cost')->result_array();

          $i++;

          }

          $j = 0;

          foreach ($query as $val) {



          $this->db->select('*');

          $this->db->where('q_id', intval($val['id']));

          $query[$j]['inv_amount'] = $this->db->get('erp_invoice')->result_array();

          $j++;

          } */

        return $query;
    }

    function get_order_datatables($search_data) {



        $this->_get_order_datatables_query($search_data);

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get('erp_project_cost')->result_array();



        //echo $this->db->last_query();
        //exit;



        return $query;
    }

    function _get_order_datatables_query($search_data = array()) {



        $this->db->select('erp_project_cost.id,customer.id as customer,customer.store_name,customer.state_id, customer.tin,customer.name,customer.mobil_number,customer.email_id,customer.address1,customer.customer_type,customer.credit_days, customer.credit_limit, customer.temp_credit_limit, customer.approved_by,erp_project_cost.total_qty,erp_project_cost.tax,erp_project_cost.tax_label,'
                . 'erp_project_cost.job_id,erp_project_cost.net_total,erp_project_cost.notification_date,erp_project_cost.remarks,erp_project_cost.subtotal_qty,erp_project_cost.estatus,erp_project_cost.created_date');

        //$this->db->where('erp_project_cost.estatus =', 2);

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->where_in('erp_project_cost.firm_id', $frim_id);

        $this->db->join('customer', 'customer.id=erp_project_cost.customer', 'LEFT');

        $this->db->order_by('erp_project_cost.id', 'desc');
    }

    function count_all_order() {

        $this->db->from('erp_project_cost');

        return $this->db->count_all_results();
    }

    function count_filtered_order() {

        $this->_get_order_datatables_query();

        $query = $this->db->get('erp_project_cost');

        return $query->num_rows();
    }

    public function get_all_quotation_by_id($id) {

        $this->db->select('erp_user.nick_name,customer.id as customer,customer.store_name,customer.state_id,customer.name,customer.tin,customer.mobil_number,customer.email_id,customer.address1,customer.customer_type,customer.customer_type,customer.credit_days, customer.credit_limit, customer.temp_credit_limit, customer.approved_by,customer.advance,erp_quotation.id,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.discount,erp_quotation.ref_name,erp_quotation.tax_label,erp_quotation.inv_id,'
                . 'erp_quotation.job_id,erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus,erp_quotation.created_date,erp_quotation.firm_id,erp_manage_firms.firm_name');

        //$this->db->where('erp_quotation.estatus',2);

        $this->db->where('erp_quotation.id', $id);

        $this->db->join('customer', 'customer.id=erp_quotation.customer');

        $this->db->join('erp_user', 'erp_user.id=erp_quotation.ref_name', 'LEFT');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_quotation.firm_id');

        $query = $this->db->get('erp_quotation');

        if ($query->num_rows() >= 0) {

            return $query->result_array();
        }

        return false;
    }

    public function get_all_project_cost_by_id($id) {

        $this->db->select('customer.id as customer,customer.store_name,customer.tin,customer.state_id,customer.name,customer.mobil_number,customer.email_id,customer.address1,customer.customer_type,customer.credit_days, customer.credit_limit, customer.temp_credit_limit, customer.approved_by, customer.advance,erp_project_cost.id,erp_project_cost.job_id,erp_project_cost.total_qty,erp_project_cost.tax,erp_project_cost.tax_label,'
                . 'erp_project_cost.net_total,erp_project_cost.remarks,erp_project_cost.subtotal_qty,erp_project_cost.inv_id,erp_project_cost.q_no,erp_project_cost.estatus,erp_project_cost.firm_id,erp_manage_firms.firm_name');

        //$this->db->where('erp_project_cost.estatus',1);

        $this->db->where('erp_project_cost.id', $id);

        $this->db->join('customer', 'customer.id=erp_project_cost.customer');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_project_cost.firm_id');

        $query = $this->db->get('erp_project_cost');

        if ($query->num_rows() >= 0) {

            return $query->result_array();
        }

        return false;
    }

    public function get_all_product_by_id($id) {

        $this->db->select('erp_product.id,erp_product.model_no,erp_product.product_name,erp_product.product_image,'
                . 'erp_quotation_details.product_description');

        $this->db->where('erp_quotation.id', $id);

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_quotation_details.q_id');

        $this->db->join('erp_product', 'erp_product.id=erp_quotation_details.product_id');

        $query = $this->db->get('erp_quotation_details');

        if ($query->num_rows() >= 0) {

            return $query->result_array();
        }

        return false;
    }

    public function get_all_quotation_details_by_id($id) {

        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,erp_product.cost_price,'
                . 'erp_quotation_details.id as p_id,erp_quotation_details.category,erp_quotation_details.product_id,erp_quotation_details.brand,erp_quotation_details.quantity,'
                . 'erp_quotation_details.per_cost,erp_quotation_details.tax,erp_quotation_details.gst,erp_quotation_details.igst,erp_quotation_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,erp_quotation_details.discount,'
                . 'erp_quotation_details.product_description');

        $this->db->where('erp_quotation_details.q_id', $id);

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_quotation_details.q_id');

        $this->db->join('erp_category', 'erp_category.cat_id=erp_quotation_details.category', 'left');

        $this->db->join('erp_product', 'erp_product.id=erp_quotation_details.product_id');

        $this->db->join('erp_brand', 'erp_brand.id=erp_quotation_details.brand', 'left');



        $query = $this->db->get('erp_quotation_details')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('per_cost');

            if ($val['category'] != '')
                $this->db->where('category', $val['category']);

            $this->db->where('product_id', $val['product_id']);

            if ($val['brand'] != '')
                $this->db->where('brand', $val['brand']);

            $this->db->order_by('per_cost', 'desc');

            $this->db->limit(1);

            $query[$i]['po'] = $this->db->get('erp_po_details')->result_array();

            $i++;
        }

        return $query;
    }

    public function get_all_sales_details_by_id($q_id) {

        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,erp_product.cost_price,'
                . 'erp_project_details.id as p_id,erp_project_details.category,erp_project_details.product_id,erp_project_details.brand,erp_project_details.quantity,erp_project_details.unit,'
                . 'erp_project_details.per_cost,erp_project_details.tax,erp_project_details.gst,erp_project_details.igst,erp_project_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,erp_project_details.discount,'
                . 'erp_project_details.product_description');

        $this->db->where('erp_project_details.j_id', $q_id);

        $this->db->join('erp_project_cost', 'erp_project_cost.id=erp_project_details.j_id');

        $this->db->join('erp_category', 'erp_category.cat_id=erp_project_details.category', 'left');

        $this->db->join('erp_product', 'erp_product.id=erp_project_details.product_id');

        $this->db->join('erp_brand', 'erp_brand.id=erp_project_details.brand', 'left');

        $query = $this->db->get('erp_project_details')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            // if ($val['category'] != '')
            //     $this->db->where('category', $val['category']);

            $this->db->where('product_id', $val['product_id']);

            // if ($val['brand'] != '')
            //    $this->db->where('brand', $val['brand']);

            $query[$i]['stock'] = $this->db->get('erp_stock')->result_array();

            $i++;
        }

        return $query;
    }

    public function get_all_project_details_by_id($q_id) {

        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,erp_product.cost_price,'
                . 'erp_quotation_details.id as p_id,erp_quotation_details.category,erp_quotation_details.product_id,erp_quotation_details.brand,erp_quotation_details.quantity,erp_quotation_details.unit,'
                . 'erp_quotation_details.per_cost,erp_quotation_details.tax,erp_quotation_details.gst,erp_quotation_details.igst,erp_quotation_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,erp_quotation_details.discount,'
                . 'erp_quotation_details.product_description');

        $this->db->where('erp_quotation_details.q_id', $q_id);

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_quotation_details.q_id');

        $this->db->join('erp_category', 'erp_category.cat_id=erp_quotation_details.category', 'left');

        $this->db->join('erp_product', 'erp_product.id=erp_quotation_details.product_id');

        $this->db->join('erp_brand', 'erp_brand.id=erp_quotation_details.brand', 'left');

        $query = $this->db->get('erp_quotation_details')->result_array();

        //        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,'
        //                . 'erp_project_details.category,erp_project_details.product_id,erp_project_details.brand,erp_project_details.quantity,erp_project_details.q_id,'
        //                . 'erp_quotation_details.per_cost,erp_project_details.tax,erp_project_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,'
        //                . 'erp_quotation_details.product_description');
        //        $this->db->where('erp_project_details.j_id', $id);
        //        $this->db->where('erp_project_details.q_id', $q_id);
        //        $this->db->join('erp_quotation_details', 'erp_quotation_details.q_id = erp_project_details.q_id');
        //        $this->db->join('erp_category', 'erp_category.cat_id=erp_project_details.category');
        //        $this->db->join('erp_product', 'erp_product.id=erp_project_details.product_id');
        //        $this->db->join('erp_brand', 'erp_brand.id=erp_project_details.brand');
        //        $query = $this->db->get('erp_project_details')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('erp_stock.quantity');

            // if ($val['category'] != '')
            //    $this->db->where('category', $val['category']);

            $this->db->where('product_id', $val['product_id']);

            //  if ($val['brand'] != '')
            //      $this->db->where('brand', $val['brand']);

            $query[$i]['stock'] = $this->db->get('erp_stock')->result_array();

            $i++;
        }

        return $query;
    }

    public function get_stock($data) { //echo "<pre>"; print_r($data); exit;
        $this->db->select('quantity');

        $this->db->where('category', $data['cat_id']);

        $this->db->where('product_id', $data['model_no']);

        $this->db->where('brand', $data['brand_id']);

        $available_stock = $this->db->get($this->erp_stock)->result_array();

        // echo "<pre>"; print_r($available_stock); exit;

        return $available_stock;
    }

    public function get_po($data) { //echo "<pre>"; print_r($data); exit;
        $this->db->select('per_cost');

        $this->db->where('category', $data['cat_id']);

        $this->db->where('product_id', $data['model_no']);

        $this->db->where('brand', $data['brand_id']);

        $available_stock = $this->db->get($this->erp_po_details)->result_array();

        // echo "<pre>"; print_r($available_stock); exit;

        return $available_stock;
    }

    public function check_stock($check_stock, $inv_id) {



        $this->db->select('*');

        $this->db->where('category', $check_stock['category']);

        $this->db->where('product_id', $check_stock['product_id']);

        $this->db->where('firm_id', $check_stock['firm']);

        $available_stock = $this->db->get($this->erp_stock)->result_array();

        //        echo $this->db->last_query();



        $ava_quantity = $available_stock[0]['quantity'] - $check_stock['quantity'];



        if ($ava_quantity < 0) {

            //Update Stock

            $quantity = $ava_quantity - $ava_quantity;

            $this->db->where('category', $check_stock['category']);

            $this->db->where('product_id', $check_stock['product_id']);

            $this->db->where('firm_id', $check_stock['firm']);

            //min stock notification

            $this->db->update($this->erp_stock, array('quantity' => $quantity));

            $this->check_min_qty($check_stock['category'], $check_stock['firm_id'], $check_stock['product_id'], $quantity);
        } else {

            //Insert Stcok
            //echo $ava_quantity;

            $quantity = $available_stock[0]['quantity'] - $check_stock['quantity'];

            $this->db->where('category', $check_stock['category']);

            $this->db->where('product_id', $check_stock['product_id']);

            $this->db->where('firm_id', $check_stock['firm']);

            $this->db->update($this->erp_stock, array('quantity' => $quantity));

            //            echo $this->db->last_query();

            $this->check_min_qty($check_stock['category'], $check_stock['firm_id'], $check_stock['product_id'], $quantity);
        }

        //Insert Stock History



        if ($check_stock['product_type'] == 'product') {

            $insert_stock_his = array();

            $insert_stock_his['ref_no'] = $inv_id['inv_id'];

            $insert_stock_his['type'] = 2;

            $insert_stock_his['category'] = $check_stock['category'];

            $insert_stock_his['product_id'] = $check_stock['product_id'];

            //$insert_stock_his['brand'] = $check_stock['brand'];

            $insert_stock_his['quantity'] = -$check_stock['quantity'];

            $insert_stock_his['created_date'] = date('Y-m-d H:i');

            $this->db->insert($this->erp_stock_history, $insert_stock_his);
        }
    }

    public function check_min_qty($cat_id, $firm_id, $p_id, $quantity) {

        $this->db->select('min_qty,product_name');

        $this->db->where('erp_product.id', $p_id);

        $qty = $this->db->get('erp_product')->result_array();



        $this->db->select('quantity');

        $this->db->where('erp_stock.category', $cat_id);

        $this->db->where('erp_stock.firm_id', $firm_id);

        $this->db->where('erp_stock.product_id', $p_id);

        $stock = $this->db->get('erp_stock')->result_array();



        if ($stock[0]['quantity'] <= $qty[0]['min_qty']) {

            $notification = array();

            $notification['notification_date'] = date('Y-m-d');

            $notification['type'] = 'min_qty';

            $notification['link'] = 'stock/';

            $notification['Message'] = $qty[0]['product_name'] . ' is in minimum stock';

            if ($this->db->insert('erp_notification', $notification)) {

                return true;
            }
        }
    }

    public function get_all_quotation_history_by_id($id) {

        $this->db->select('customer.id,customer.tin,customer.name,customer.state_id,customer.mobil_number,customer.email_id,customer.address1,erp_quotation_history.q_no,erp_quotation_history.total_qty,erp_quotation_history.tax,erp_quotation_history.ref_name,erp_quotation_history.tax_label,'
                . 'erp_quotation_history.net_total,erp_quotation_history.delivery_schedule,erp_quotation_history.notification_date,erp_quotation_history.mode_of_payment,erp_quotation_history.remarks,erp_quotation_history.subtotal_qty');

        $this->db->where('erp_quotation_history.eStatus', 1);

        $this->db->where('erp_quotation_history.id', $id);

        $this->db->join('customer', 'customer.id=erp_quotation_history.customer');

        $query = $this->db->get('erp_quotation_history');

        if ($query->num_rows() >= 0) {

            return $query->result_array();
        }

        return false;
    }

    public function get_all_quotation_history_details_by_id($id) {

        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_brand.id,erp_brand.brands,'
                . ' erp_product.id,erp_product.model_no,erp_product.product_name,erp_product.product_image,erp_quotation_history_details.product_description,erp_quotation_history_details.igst,'
                . 'erp_quotation_history_details.category,erp_quotation_history_details.product_id,erp_quotation_history_details.brand,erp_quotation_history_details.quantity,erp_quotation_history_details.unit,'
                . 'erp_quotation_history_details.per_cost,erp_quotation_history_details.tax,erp_quotation_history_details.sub_total');

        $this->db->where('erp_quotation_history.id', $id);

        $this->db->join('erp_quotation_history', 'erp_quotation_history.id=erp_quotation_history_details.h_id');

        $this->db->join('erp_category', 'erp_category.cat_id=erp_quotation_history_details.category');

        $this->db->join('erp_product', 'erp_product.id=erp_quotation_history_details.product_id');

        $this->db->join('erp_brand', 'erp_brand.id=erp_quotation_history_details.brand');

        $query = $this->db->get('erp_quotation_history_details');

        if ($query->num_rows() >= 0) {

            return $query->result_array();
        }

        return false;
    }

    public function get_his_quotation_by_id($id) {

        $this->db->select('*');

        $this->db->where($this->erp_quotation . '.id', $id);

        return $this->db->get($this->erp_quotation)->result_array();
    }

    public function get_all_history_quotation_by_id($id) {

        $this->db->select('*');

        $this->db->where($this->erp_quotation_history . '.org_q_id', $id);

        return $this->db->get($this->erp_quotation_history)->result_array();
    }

    public function insert_history_quotation($data) {

        if ($this->db->insert($this->erp_quotation_history, $data)) {

            $insert_id = $this->db->insert_id();

            return $insert_id;
        }

        return false;
    }

    public function insert_history_quotation_details($data) {

        $this->db->insert_batch($this->erp_quotation_history_details, $data);

        return true;
    }

    public function get_his_quotation_deteils_by_id($id) {

        $this->db->select('*');

        $this->db->where($this->erp_quotation_details . '.q_id', $id);

        return $this->db->get($this->erp_quotation_details)->result_array();
    }

    public function delete_quotation_deteils_by_id($id) {

        $this->db->where('q_id', $id);

        $this->db->delete($this->erp_quotation_details);
    }

    public function delete_id($id) {

        $this->db->where('id', $id);

        $this->db->delete($this->erp_quotation_details);
    }
	

    public function delete_pc_id($id) {
        if ($id != '') {
            $this->db->where('q_id', $id);

            $this->db->delete($this->erp_project_details);
        }
        return true;
    }

    public function delete_pc_by_id($id) {

        $this->db->where('j_id', $id);

        $this->db->delete($this->erp_project_details);
    }

    public function delete_inv_by_id($id) {

        $this->db->where('in_id', $id);

        $this->db->delete($this->erp_invoice_details);
        return true;
    }

    public function delete_invoice($id) {

        $this->db->where('id', $id);

        $this->db->delete($this->erp_invoice);
        return true;
    }

    public function delete_receipt_by_inv_id($id) {

        $this->db->where('receipt_id', $id);

        $this->db->delete($this->receipt_bill);
        return true;
    }

    public function change_quotation_status($id, $status) {

        $this->db->where($this->erp_quotation . '.id', $id);

        if ($this->db->update($this->erp_quotation, array('estatus' => $status))) {

            return true;
        }

        return false;
    }

    public function change_pc_status($id, $status) {

        $this->db->where($this->erp_project_cost . '.id', $id);

        if ($this->db->update($this->erp_project_cost, array('estatus' => $status))) {

            return true;
        }

        return false;
    }

    public function update_quotation($data, $id) {

        $this->db->where($this->erp_quotation . '.id', $id);

        if ($this->db->update($this->erp_quotation, $data)) {

            return true;
        }

        return false;
    }

    public function update_project_cost($data, $id) {

        $this->db->where($this->erp_project_cost . '.id', $id);

        if ($this->db->update($this->erp_project_cost, $data)) {

            return true;
        }

        return false;
    }

    public function update_invoice($data, $id) {

        $this->db->where($this->erp_invoice . '.id', $id);

        if ($this->db->update($this->erp_invoice, $data)) {

            return true;
        }

        return false;
    }

    public function update_other_cost($data, $id) {

        $this->db->where($this->erp_other_cost . '.j_id', $id);

        if ($this->db->update($this->erp_other_cost, $data)) {

            return true;
        }

        return false;
    }

    public function delete_quotation($id) {

        $this->db->where('id', $id);

        if ($this->db->update($this->erp_quotation, $data = array('estatus' => 0))) {

            return true;
        }

        return false;
    }

    public function all_history_quotations($id) {

        $this->db->select('*');

        $this->db->where('erp_quotation_history.org_q_id', $id);

        $this->db->order_by('created_date', 'desc');

        $query = $this->db->get('erp_quotation_history')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            $this->db->where($this->erp_quotation_history_details . '.h_id', $val['id']);

            $query[$i]['history_details'] = $this->db->get($this->erp_quotation_history_details)->result_array();

            $i++;
        }

        return $query;
    }

    public function get_all_customer_by_id($id) {

        $this->db->select('*');

        $this->db->where('df', 0);

        $this->db->where('status', 1);

        $this->db->where('state_id', $id);
		

        $query = $this->db->get($this->table_name6);

        if ($query->num_rows() >= 0) {

            return $query->result_array();
        }

        return false;
    }

    public function get_all_style_details_by_id($style_name) {

        $this->db->select('style_name,mrp,lot_no,id as style_id');

        $this->db->where('df', 0);

        $this->db->where('status', 1);

        $this->db->where('style_name', $style_name);

        $query = $this->db->get($this->table_name4);

        if ($query->num_rows() >= 0) {

            return $query->result_array();
        }

        return false;
    }

    public function get_location($where) {

        $this->db->select('location');

        $this->db->where($where);

        $query = $this->db->get('stock_info')->result_array();

        return $query;
    }

    public function get_all_color_details_by_id($s_id) {

        $this->db->select('master_colour.id,master_colour.colour');

        $this->db->where('master_style_color.status', 1);

        $this->db->where('master_style_color.style_id', $s_id);

        $this->db->join('master_colour', 'master_colour.id=master_style_color.color_id');

        $query = $this->db->get('master_style_color');

        if ($query->num_rows() >= 0) {

            return $query->result_array();
        }

        return false;
    }

    public function get_all_style_details_by_id1($id) {

        $this->db->select($this->table_name4 . '.*');

        $this->db->select('master_style_type.style_type');

        $this->db->where($this->table_name4 . '.status', 1);

        $this->db->where($this->table_name4 . '.id', $id);

        $this->db->join('master_style_type', 'master_style_type.id=' . $this->table_name4 . '.style_type');

        $query = $this->db->get($this->table_name4)->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select($this->table_name5 . '.*');

            $this->db->select('master_size.size');

            $this->db->where($this->table_name5 . '.style_id', $val['id']);

            $this->db->join('master_size', 'master_size.id=' . $this->table_name5 . '.size_id');

            $query[$i]['style_size'] = $this->db->get($this->table_name5)->result_array();

            $i++;
        }

        return $query;
    }

    public function insert_gen($data) {

        if ($this->db->insert($this->table_name1, $data)) {

            $insert_id = $this->db->insert_id();



            return $insert_id;
        }

        return false;
    }

    public function insert_gen_details($data) {

        if ($this->db->insert_batch($this->table_name2, $data)) {

            $insert_id = $this->db->insert_id();



            return $insert_id;
        }

        return false;
    }

    public function get_all_gen($serch_data = NULL) {

        if (isset($serch_data) && !empty($serch_data)) {

            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';

            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';

            if (!empty($serch_data['state']) && $serch_data['state'] != 'Select') {

                $this->db->where($this->table_name1 . '.state', $serch_data['state']);
            }

            if (!empty($serch_data['supplier']) && $serch_data['supplier'] != 'Select') {

                $this->db->where($this->table_name1 . '.customer', $serch_data['supplier']);
            }

            if (!empty($serch_data['po'])) {

                $this->db->where($this->table_name1 . '.grn_no', $serch_data['po']);
            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["style"]) && $serch_data["style"] != "Select") {



                $this->db->where('master_style.id', $serch_data["style"]);
            }
        } else {

            $from_y = $to_y = 0;

            if (date('m') > 3) {

                $from_y = date('Y');

                $to_y = date('Y') + 1;
            } else {

                $from_y = date('Y') - 1;

                $to_y = date('Y');
            }

            $from = $from_y . '-04-01';

            $to = $to_y . '-03-31';

            $this->db->where("DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') >='" . $from . "' AND DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') <= '" . $to . "'");
        }

        $this->db->select($this->table_name1 . '.*');

        $this->db->select('vendor.name,store_name');

        $this->db->select('master_style.style_name');

        $this->db->select('master_state.state');

        $this->db->where($this->table_name1 . '.status', 1);

        $this->db->where($this->table_name1 . '.df', 0);

        $this->db->order_by($this->table_name1 . '.id', 'desc');

        $this->db->group_by('po_details.gen_id');

        $this->db->join('po_details', 'po_details.gen_id=' . $this->table_name1 . '.id');

        $this->db->join('master_style', 'master_style.id=po_details.style_id');

        $this->db->join('vendor', 'vendor.id=' . $this->table_name1 . '.customer');

        $this->db->join('master_state', 'master_state.id=' . $this->table_name1 . '.state');

        $query = $this->db->get($this->table_name1)->result_array();

        $i = 0;



        foreach ($query as $val) {

            $cancel_status = '';

            if ($val['delivery_status'] == 0) {

                $date = strtotime($val['delivery_schedule']);

                $date = strtotime("+10 day", $date);



                if (strtotime(date('d-m-Y', $date)) < strtotime(date('d-m-Y')))
                    $cancel_status = 'true';
                else
                    $cancel_status = 'false';
            } else
                $cancel_status = 'false';



            $query[$i]['cancel_status'] = $cancel_status;

            $i++;
        }

        return $query;
    }

    function get_customers() {

        $this->db->select($this->customer . '.*');

        $this->db->where($this->customer . '.customer_type = 1 OR customer_type =2');

        $query = $this->db->get($this->customer)->result_array();

        return $query;
    }

    function get_customer_type($id) {

        $this->db->select($this->customer . '.customer_type');

        $this->db->where($this->customer . '.id', $id);

        $query = $this->db->get($this->customer)->result_array();

        return $query[0]['customer_type'];
    }

    function get_product_cash_selling_price($id) {

        $this->db->select($this->erp_product . '.cash_cus_price');

        $this->db->where($this->erp_product . '.id', $id);

        $query = $this->db->get($this->erp_product)->result_array();

        return $query[0]['cash_cus_price'];
    }

    function get_product_credit_selling_price($id) {

        $this->db->select($this->erp_product . '.credit_cus_price');

        $this->db->where($this->erp_product . '.id', $id);

        $query = $this->db->get($this->erp_product)->result_array();

        return $query[0]['credit_cus_price'];
    }

    public function get_reference_amount($id) {

        $this->db->select('erp_user.id,erp_reference_groups.commission_rate,erp_reference_groups.user_id');

        $this->db->where('erp_user.id', $id);

        $this->db->join('erp_reference_groups', 'erp_reference_groups.user_id=erp_user.id');

        $query = $this->db->get('erp_user')->result_array();

        return $query[0]['commission_rate'];
    }

    public function get_all_products($barcode) {

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $key => $value) {

            $frim_id[] = $value['firm_id'];
        }


        // $this->db->select('erp_product.*');
        $this->db->select('erp_product.*,erp_category.categoryName,erp_manage_firms.firm_name');

        //$this->db->where('erp_product.barcode', $barcode);

        $this->db->where('erp_product.id', 2);

        $this->db->where_in('erp_product.firm_id', $frim_id);

        $this->db->join('erp_category', 'erp_category.cat_id=erp_product.category_id');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_product.firm_id');

        $query = $this->db->get('erp_product');



        if ($query->num_rows() >= 0) {

            return $query->result_array();
        }

        return false;
    }

    public function get_products_by_barcode($bar_code,$cat_id=null) {


        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $key => $value) {

            $frim_id[] = $value['firm_id'];
        }


        $this->db->select('erp_product.*,erp_category.categoryName,erp_manage_firms.firm_name,erp_stock.quantity as qty');
        $this->db->where('ime.ime_code', $bar_code);
        $this->db->where('ime.status', 'open');
        $this->db->where_in('erp_product.firm_id', $frim_id);
        $this->db->join('erp_product', 'erp_product.id=ime.product_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_product.category_id');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_product.firm_id');
        $this->db->join('erp_stock', 'erp_stock.product_id = erp_product.id', 'left');
        $this->db->limit(1);
        $this->db->where('erp_stock.quantity !=', 0.00);
        if($cat_id != null)
            $this->db->where('ime.po_cat_type', $cat_id);
        $query = $this->db->get('erp_po_ime_code_details as ime');




        if ($query->num_rows() >= 0) {

            $data = $query->result_array();

            foreach ($data as $key => $result_data) {

                $this->db->select('ime.ime_code');
                $this->db->where('ime.product_id', $result_data['id']);
                $this->db->where('ime.status', 'open');
                if($cat_id != null)
                    $this->db->where('ime.po_cat_type', $cat_id);
                $ime_data = $this->db->get('erp_po_ime_code_details as ime')->result_array();

                $data[$key]['ime_details'] = $ime_data;
            }



            return $data;
        }

        return false;
    }

    public function update_ime_status($product_id, $ime_code, $qty, $data) {

        $ime_code_data = explode(',', $ime_code);

        $update_data = [
            "status" => "close",
            "close_date" => date('Y-m-d H:i:s'),
            "sales_id" => $data['sales_id'],
            "sales_details_id" => $data['sales_details_id'],
        ];

        foreach ($ime_code_data as $key => $resutls) {

            $this->db->where('erp_po_ime_code_details.ime_code', $resutls);
            $this->db->where('erp_po_ime_code_details.product_id', $product_id);
            $query = $this->db->update('erp_po_ime_code_details', $update_data);
        }
    }

    public function get_imecode_from_proqty($input) {


        $pro_id = $input['product_id'];
        $pro_qty = $input['pro_qty'];
        $ime_code = $input['ime_code'];
        $ime = "";
        if ($ime_code != "") {
            $ime = explode(',', $ime_code);
            //echo "<pre>";print_r($ime);exit;
        }

        $this->db->select('ime.ime_code');
        $this->db->where('ime.product_id', $pro_id);

        if ($ime)
            $this->db->where_not_in('ime.ime_code', $ime);

        $this->db->where('ime.status', 'open');
        $this->db->limit($pro_qty);
        $query = $this->db->get('erp_po_ime_code_details as ime');

        //echo "<pre>";print_r($query->result_array());exit;

        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }

        return 0;
    }

    function check_ime_qty($bar_code, $qty) {
        $this->db->select('ime.product_id');
        $this->db->where('ime.ime_code', $bar_code);
        $this->db->where('ime.status', 'open');
        $product_details = $this->db->get('erp_po_ime_code_details as ime')->result_array();

        $product_id = $product_details[0]['product_id'];

        $this->db->select('ime.ime_code');
        // $this->db->where('ime.ime_code !=',$bar_code);
        $this->db->where('ime.product_id', $product_id);
        $this->db->where('ime.status', 'open');
        $query = $this->db->get('erp_po_ime_code_details as ime')->result_array();


        if (count($query) < $qty) {

            return 0;
        }

        return 1;
    }

    public function get_the_total_sales_count() {

        $current_date = date('Y-m-d');

        $this->db->select('net_total');

        $this->db->where($this->erp_project_cost . '.created_date', $current_date);

        $query = $this->db->get($this->erp_project_cost);

        if ($query->num_rows() >= 0) {

            return $query->result_array();
        }

        return false;
    }

    public function approve_invoice($id) {

        $data = array('invoice_status' => 'approved');

        $this->db->where($this->erp_invoice . '.id', $id);

        if ($this->db->update($this->erp_invoice, $data)) {

            return true;
        }

        return false;
    }

    public function get_all_customer_pc() {

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->select('customer.name,customer.id');

        $this->db->where($this->customer . '.status', 1);

        $this->db->join('erp_project_cost', 'erp_project_cost.customer=customer.id');

        $this->db->where_in('erp_project_cost.firm_id', $frim_id);

        $this->db->group_by('erp_project_cost.customer');

        $query = $this->db->get($this->customer)->result_array();

        return $query;
    }

    public function get_all_customer_invoice($serch_data = array()) {

        $this->db->distinct();

        $this->db->select('erp_invoice.*');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance');

        $this->db->group_by('customer.store_name');

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->where_in('erp_invoice.contract_customer', 0);

        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        if (!empty($serch_data['overdue']) && $serch_data['overdue'] != '' && $serch_data['overdue'] == 3) {

            $this->db->where('customer.advance >', 0);
        }

        $this->db->order_by('erp_invoice.id', 'desc');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->join('erp_invoice_details', 'erp_invoice.id=erp_invoice_details.in_id');

        //$this->db->where('customer', 822);



        if (isset($serch_data) && !empty($serch_data)) {

            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';

            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';





            if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {



                $this->db->where('erp_invoice.inv_id', $serch_data['inv_id']);
            }

            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

                $this->db->where('customer.id', $serch_data['customer']);
            }



            if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

                $this->db->where('erp_invoice_details.product_id', $serch_data['product']);
            }



            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }



        $query = $this->db->get('erp_invoice')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date');

            $this->db->where('receipt_bill.receipt_id', $val['id']);

            $query[$i]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();

            $i++;
            $this->db->select('firm_name');
            $this->db->where('firm_id', $val['firm_id']);
            $firm_details = $this->db->get('erp_manage_firms')->result_array();
            $query[$i]['firm_name'] = $firm_details[0]['firm_name'];
            //echo $this->db->last_query() . '<br />';
        }



        return $query;
    }

    public function get_all_product_pc() {

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->select('erp_product.product_name,erp_product.id');

        $this->db->where($this->erp_product . '.status', 1);

        $this->db->join('erp_project_details', 'erp_project_details.product_id=erp_product.id');

        $this->db->where_in('erp_product.firm_id', $frim_id);

        $this->db->group_by('erp_project_details.product_id');

        $query = $this->db->get($this->erp_product)->result_array();

        return $query;
    }

    public function get_all_completed_quotation($serch_data) {



        if (isset($serch_data) && !empty($serch_data)) {

            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';

            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';





            if (!empty($serch_data['q_no']) && $serch_data['q_no'] != 'Select') {



                $this->db->where($this->erp_quotation . '.q_no', $serch_data['q_no']);
            }

            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

                $this->db->where($this->erp_quotation . '.customer', $serch_data['customer']);
            }

            if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

                $this->db->where($this->erp_quotation_details . '.product_id', $serch_data['product']);
            }



            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_quotation . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_quotation . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_quotation . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_quotation . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }

        $this->db->select('customer.id as customer,customer.store_name,customer.tin,customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.id,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
                . 'erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus,erp_quotation.validity,erp_quotation.created_date');



        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        if (!empty($firms) && count($firms) > 0) {

            foreach ($firms as $value) {

                $frim_id[] = $value['firm_id'];
            }
        }

        $this->db->where_in('erp_quotation.firm_id', $frim_id);

        $this->db->where('erp_quotation.estatus !=', 0);

        //$this->db->where('erp_quotation.type =', 1);

        $this->db->order_by('erp_quotation.id', 'desc');

        $this->db->join('customer', 'customer.id=erp_quotation.customer');

        $this->db->join('erp_quotation_details', 'erp_quotation_details.q_id=erp_quotation.id');

        $this->db->group_by('erp_quotation.id');

        $query = $this->db->get('erp_quotation')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select(' sum(sub_total - ( per_cost * quantity )) as tot_tax');

            $this->db->where($this->erp_quotation_details . '.q_id', $val['id']);

            $query[$i]['tax_details'] = $this->db->get($this->erp_quotation_details)->result_array();

            $i++;
        }



        $j = 0;

        foreach ($query as $val) {



            $this->db->select('*');

            $this->db->where('q_id', intval($val['id']));

            $query[$j]['inv_amount'] = $this->db->get('erp_invoice')->result_array();

            $j++;
        }

        return $query;
    }

    function _get_datatables_query() {

        //Join Table

        $this->db->join($this->joinTable1, 'r.id=u.customer');

        $this->db->join($this->joinTable2, 'c.q_id=u.id', 'left');

        $this->db->where('u.estatus', 2);



        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->where_in('u.firm_id', $frim_id);

        $this->db->group_by('u.id');

        $this->db->from($this->primaryTable);

        $i = 0;

        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $like = "" . $item . " LIKE '%" . $_POST['search']['value'] . "%'";

                    //$this->db->like($item, $_POST['search']['value']);
                } else {

                    //$query = $this->db->or_like($item, $_POST['search']['value']);

                    $like .= " OR " . $item . " LIKE '%" . $_POST['search']['value'] . "%'" . "";
                }
            }

            $i++;
        }

        if ($like) {

            $where = "(" . $like . " ) AND ( u.estatus = 2 ) ";

            $this->db->where($where);
        }

        if (isset($_POST['order']) && $this->column_order[$_POST['order']['0']['column']] != null) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function _get_datatables_query1() {



        $this->db->select('cat.categoryName,i.net_total As inv_amount,i.inv_id,i.invoice_status,i.payment_status,i.delivery_status,i.contract_customer,i.customer,i.created_date,c.store_name,q.id,q.q_no,q.net_total,i.id As i_id,i.delivery_qty,f.firm_name as shop_name');

        $this->db->join('customer c', 'c.id=i.customer');

        $this->db->join('erp_category cat', 'cat.cat_id=i.sale_cat_type','left',false);

        $this->db->join('erp_quotation q', 'i.q_id=q.id', 'left');

        $this->db->join('erp_manage_firms f', 'f.firm_id=i.firm_id', 'left');

        $this->db->where('q.estatus', 2);



        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->where_in('i.firm_id', $frim_id);

        $this->db->group_by('q.id');

        $this->db->from('erp_invoice i');

        $column_order = array(null, 'q.q_no', 'c.store_name', 'q.net_total', 'i.inv_id', 'i.net_total', 'i.created_date', 'i.invoice_status', 'i.payment_status', 'i.delivery_status', null);

        $column_search = array('q.q_no', 'c.store_name', 'q.net_total', 'i.inv_id', 'i.net_total', 'i.created_date', 'i.invoice_status', 'i.payment_status', 'i.delivery_status');

        $order = array('q.id' => 'DESC');

        $i = 0;

        foreach ($column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $like = "" . $item . " LIKE '%" . $_POST['search']['value'] . "%'";

                    //$this->db->like($item, $_POST['search']['value']);
                } else {

                    //$query = $this->db->or_like($item, $_POST['search']['value']);

                    $like .= " OR " . $item . " LIKE '%" . $_POST['search']['value'] . "%'" . "";
                }
            }

            $i++;
        }

        if ($like) {

            $where = "(" . $like . " ) AND ( q.estatus = 2 ) ";

            $this->db->where($where);
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {

            $order = $order;

            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables() {

        //$this->db->select($this->selectColumn);

        $this->_get_datatables_query1();

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get()->result_array();

        //        echo $this->db->last_query();
        //        exit;

        $j = 0;

        foreach ($query as $val) {



            $this->db->select('*');

            $this->db->where('q_id', intval($val['id']));

            $query[$j]['invoice'] = $this->db->get('erp_invoice')->result_array();

            $j++;
        }

        //echo $this->db->last_query();
        //print_r($query);
        //exit;

        return $query;
    }

    function count_filtered() {

        $this->_get_datatables_query1();

        $query = $this->db->get();

        //        echo $this->db->last_query();
        //        exit;

        return $query->num_rows();
    }

    function count_all() {

        //        $this->db->from($this->primaryTable);
        //        $this->db->count_all_results();
        //        echo $this->db->last_query();
        //        exit;



        $this->db->select('COUNT(id) AS numrows');

        $query = $this->db->get('erp_quotation u')->result_array();

        if (!empty($query))
            return $query[0]['numrows'];
    }

    public function get_company_details_by_firm($s_id) {

        $this->db->select('erp_manage_firms.*,erp_invoice.firm_id');

        $this->db->where('erp_invoice.id', $s_id);

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_invoice.firm_id');

        $query = $this->db->get('erp_invoice')->result_array();



        return $query;
    }

    public function get_company_details_by_firms($s_id) {

        $this->db->select('erp_manage_firms.*,erp_project_cost.firm_id');

        $this->db->where('erp_project_cost.id', $s_id);

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_project_cost.firm_id');

        $query = $this->db->get('erp_project_cost')->result_array();

        return $query;
    }

    public function delete_quotation_also($id) {

        $this->db->where('id', $id);

        if ($this->db->delete($this->erp_quotation)) {

            return true;
        }

        return false;
    }

    public function get_all_customer() {

        $customerIds = array();

        $this->db->select('DISTINCT(customer)');

        $invoice_query = $this->db->get('erp_invoice')->result_array();

        $customerIds = array_map(function ($invoice_query) {

            return $invoice_query['customer'];
        }, $invoice_query);



        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->select('customer.store_name,customer.id');

        if (!empty($customerIds))
            $this->db->where_in('id', $customerIds);

        $this->db->where($this->customer . '.status', 1);

        $query = $this->db->get($this->customer)->result_array();

        return $query;
    }

    public function get_product_cost_by_product($input) {

        $this->db->select('erp_product.*');

        $this->db->where_in('erp_product.id', $input['prod_array']);

        //$this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_project_cost.firm_id');

        $query = $this->db->get('erp_product')->result_array();



        $product_details = array();

        foreach ($query as $val) {

            $product_details[$val['id']] = $val;
        }

        return $product_details;
    }

    public function invoice_duplicate_details() {

        $this->db->select('erp_invoice.id');

        $this->db->order_by('erp_invoice.id');

        $query = $this->db->get('erp_invoice')->result_array();

        foreach ($query as $val) {

            $this->db->select('erp_invoice_details.*');

            $this->db->where('erp_invoice_details.in_id', $val['id']);

            $inv_det[] = $this->db->get('erp_invoice_details')->result_array();
        }

        return $inv_det;
    }

    public function insert_inv_pro_details($data) {

        $this->db->insert('erp_invoice_product_details', $data);

        return true;
    }

    public function updatestock_as_per_invoice_live($invoice_id) {

        // Get all Products in invoice details

        $i = $invoice_id;

        // Get Firm Id in - Invoice Table

        $this->db->select('firm_id, inv_id');

        $this->db->where('id', $i);

        $invoice_details = $this->db->get('erp_invoice')->result_array();



        if (!empty($invoice_details)) {

            $firm_id = $invoice_details[0]['firm_id'];

            $inv_id = $invoice_details[0]['inv_id'];

            $this->db->select('*');

            $this->db->where('in_id', $i);

            $query = $this->db->get('erp_invoice_details')->result_array();

            if (!empty($query)) {

                foreach ($query as $invoice_products) {

                    $product_id = $invoice_products['product_id'];

                    $brand_id = $invoice_products['brand'];

                    $category = $invoice_products['category'];

                    $invoice_product_quantity = $invoice_products['quantity'];

                    //Get stock..

                    $this->db->select('*');

                    $this->db->where('firm_id', $firm_id);

                    $this->db->where('category', $category);

                    //$this->db->where('brand', $brand_id);

                    $this->db->where('product_id', $product_id);

                    $stock_details = $this->db->get('erp_stock')->result_array();




                    $this->db->where('sales_id', $i);
                    $this->db->update('erp_po_ime_code_details', ["status" => "open", "sales_id" => 0]);

                    //echo $this->db->last_query();exit;

                    if (!empty($stock_details)) {

                        $stock_id = $stock_details[0]['id'];

                        $quantity = $stock_details[0]['quantity'];

                        //echo "Stock Id : " . $stock_id . '<br />Quantity : ' . $quantity . '<br />';
                        //echo "Inovice product qty : " . $invoice_product_quantity . '<br />';
                        // Update Stock..

                        $current_quantity = $quantity + $invoice_product_quantity;

                        // echo "Current Qty : " . $current_quantity;exit;

                        $data['quantity'] = $current_quantity;

                        $this->db->where('id', $stock_id);

                        if ($this->db->update('erp_stock', $data)) {

                            // Insert Stock History..

                            $stock_history['ref_no'] = $inv_id;

                            $stock_history['type'] = 1;

                            $stock_history['category'] = $category;

                            $stock_history['brand'] = $brand_id;

                            $stock_history['product_id'] = $product_id;

                            $stock_history['quantity'] = $invoice_product_quantity;

                            $stock_history['created_date'] = date('Y-m-d H:i:s');

                            $this->db->insert('erp_stock_history', $stock_history);
                        }
                    }
                }
            }
        }
    }

    public function updatestockreturn_as_per_invoice_live($invoice_id) {



        // Get all Products in invoice details

        $i = $invoice_id;

        // Get Firm Id in - Invoice Table

        $this->db->select('firm_id, inv_id');

        $this->db->where('id', $i);

        $invoice_details = $this->db->get('erp_invoice')->result_array();

        //echo "<pre>"; print_r($invoice_details); exit;

        if (!empty($invoice_details)) {

            $firm_id = $invoice_details[0]['firm_id'];

            $inv_id = $invoice_details[0]['inv_id'];

            $this->db->select('*');

            $this->db->where('in_id', $i);

            $invoice_details_qry = $this->db->get('erp_invoice_details')->result_array();

            // echo "<pre>"; print_r($invoice_details_qry); exit;

            if (!empty($invoice_details_qry)) {

                foreach ($invoice_details_qry as $inv_detailsvalue) {

                    $product_id = $inv_detailsvalue['product_id'];

                    $brand_id = $inv_detailsvalue['brand'];

                    $category = $inv_detailsvalue['category'];

                    $this->db->select('*');

                    $this->db->where('invoice_id', $i);

                    $query = $this->db->get('erp_sales_return')->result_array();


                    if (count($query) > 1) {

                        //                            /echo "Rajaa";exit;

                        foreach ($query as $salesreturn) {

                            $sales_return_id = $salesreturn['id'];

                            $invoice_id = $salesreturn['invoice_id'];

                            // Get Sales Return Details

                            $this->db->select('*');

                            $this->db->where('return_id', $sales_return_id);

                            $this->db->where('in_id', $invoice_id);

                            $this->db->where('product_id', $product_id);

                            $this->db->where('return_quantity !=', 0);

                            $sales_return_details = $this->db->get('erp_sales_return_details')->result_array();

                            //echo $this->db->last_query();exit;

                            $return_qty = $sales_return_details[0]['return_quantity'];

                            //Get stock..

                            $this->db->select('*');

                            $this->db->where('firm_id', $firm_id);

                            $this->db->where('category', $category);

                            // $this->db->where('brand', $brand_id);

                            $this->db->where('product_id', $product_id);

                            $stock_details = $this->db->get('erp_stock')->result_array();

                            if (!empty($stock_details)) {

                                $stock_id = $stock_details[0]['id'];

                                $quantity = $stock_details[0]['quantity'];

                                // Update Stock..

                                $current_quantity = $quantity + $return_qty;

                                $data['quantity'] = $current_quantity;

                                $this->db->where('id', $stock_id);

                                if ($this->db->update('erp_stock', $data)) {

                                    // Insert Stock History..

                                    $stock_history['ref_no'] = $inv_id;

                                    $stock_history['type'] = 3;

                                    $stock_history['category'] = $category;

                                    $stock_history['brand'] = $brand_id;

                                    $stock_history['product_id'] = $product_id;

                                    $stock_history['quantity'] = $return_qty;

                                    $this->db->insert('erp_stock_history', $stock_history);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function update_invoice_payment_status($invoice_id) {

        $data = array();

        $data['payment_status'] = 'Completed';

        $this->db->where('id', $invoice_id);

        if ($this->db->update($this->erp_invoice, $data)) {



            return true;
        }

        return false;
    }

    public function get_invoice_report($serch) {



        if ($serch != NULL && $serch != '') {

            $serch_data['inv_id'] = $serch[0]->inv_id;

            $serch_data['customer'] = $serch[1]->customer;

            $serch_data['product'] = $serch[2]->product;

            $serch_data['sales_man'] = $serch[3]->sales_man;

            $serch_data['from_date'] = $serch[4]->from;

            $serch_data['to_date'] = $serch[5]->to;

            $serch_data['overdue'] = $serch[6]->overdue;

            $serch_data['gst_sales_report'] = $serch[7]->gst_sales_report;
        }



        if (!empty($serch_data['from_date']))
            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

        if (!empty($serch_data['to_date']))
            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

        if ($serch_data['from_date'] == '1970-01-01')
            $serch_data['from_date'] = '';

        if ($serch_data['to_date'] == '1970-01-01')
            $serch_data['to_date'] = '';

        $invoiceIds = array();

        if (!empty($serch_data['gst']) && $serch_data['gst'] != '' && $serch_data['gst'] != 'Select') {

            $invoice_ids = array();

            $where_gst = '(erp_invoice_details.tax="' . $serch_data['gst'] . '" OR erp_invoice_details.gst = "' . $serch_data['gst'] . '")';

            //$this->db->select('erp_invoice.id');

            $this->db->select('erp_invoice_details.*');

            $this->db->join('erp_invoice', 'erp_invoice_details.in_id=erp_invoice.id');

            $this->db->where($where_gst);

            if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {

                $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);
            }

            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

                $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);
            }

            if (!empty($serch_data['sales_man']) && $serch_data['sales_man'] != 'Select') {

                $this->db->where($this->erp_invoice . '.sales_man', $serch_data['sales_man']);
            }

            if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

                $this->db->where($this->erp_invoice_details . '.product_id', $serch_data['product']);
            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }



            $invoices = $this->db->get('erp_invoice_details')->result_array();

            //echo $this->db->last_query();
            //exit;



            $inv_all_details = array();

            $count = 1;

            if (!empty($invoices)) {

                /* Search Particular products in that GST % From the Invoice */

                foreach ($invoices as $invoices_values) {

                    $invoice_id = $invoices_values['in_id'];

                    $tax = $invoices_values['tax'];

                    $per_cost = $invoices_values['per_cost'];

                    $quantity = $invoices_values['quantity'];

                    $gst = $invoices_values['gst'];

                    $cgst = ($tax / 100) * ($per_cost * $quantity);

                    $sgst = ($gst / 100) * ($per_cost * $quantity);

                    if (!isset($inv_all_details[$invoice_id]['quantity'])) {

                        $inv_all_details[$invoice_id]['in_id'] = $invoice_id;

                        $inv_all_details[$invoice_id]['quantity'] = $quantity;

                        $inv_all_details[$invoice_id]['cgst'] = $cgst;

                        $inv_all_details[$invoice_id]['sgst'] = $sgst;
                    } else {

                        $inv_all_details[$invoice_id]['quantity'] = $inv_all_details[$invoice_id]['quantity'] + $quantity;

                        $inv_all_details[$invoice_id]['cgst'] = $inv_all_details[$invoice_id]['cgst'] + ($cgst);

                        $inv_all_details[$invoice_id]['sgst'] = $inv_all_details[$invoice_id]['sgst'] + $sgst;
                    }
                }



                $invoiceIds = array_map(function ($invoices) {

                    return $invoices['in_id'];
                }, $invoices);



                if (!empty($invoiceIds)) {



                    $invoiceIds = array_unique($invoiceIds);

                    $this->db->where_in($this->erp_invoice . '.id', $invoiceIds);
                } else {

                    $this->db->where($this->erp_invoice . '.id', -1);
                }
            } else {

                $this->db->where($this->erp_invoice . '.id', -1);
            }
        }



        if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {

            $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);
        }

        if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

            $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);
        }

        if (!empty($serch_data['sales_man']) && $serch_data['sales_man'] != 'Select') {

            $this->db->where($this->erp_invoice . '.sales_man', $serch_data['sales_man']);
        }

        if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

            $this->db->where($this->erp_invoice_details . '.product_id', $serch_data['product']);
        }

        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        }



        $this->db->select('customer.id as customer,customer.store_name,customer.tin,customer.state_id, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_quotation.q_no,erp_invoice.total_qty,erp_invoice.tax,erp_quotation.ref_name,erp_invoice.tax_label,'
                . 'erp_invoice.net_total,erp_invoice.created_date,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_sales_man.sales_man_name,erp_invoice.q_id');



        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        //if (empty($serch_data)) {
        //  $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%m') = '" . date('m') . "'");
        //}

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->join('erp_sales_man', 'erp_sales_man.id=erp_invoice.sales_man', 'LEFT');

        $this->db->join('erp_invoice_details', 'erp_invoice_details.in_id=erp_invoice.id');

        $this->db->group_by('erp_invoice.id');



        $query = $this->db->get('erp_invoice')->result_array();

        //echo $this->db->last_query();
        //exit;







        $i = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            $this->db->where('j_id', intval($val['id']));

            $this->db->where('type', 'invoice');

            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();

            $i++;
        }







        $i2 = 0;

        foreach ($query as $val) {

            $this->db->select('SUM((tax / 100 ) * (per_cost * quantity)) as cgst, SUM((gst / 100 ) * (per_cost * quantity)) as sgst');

            $this->db->where('in_id', intval($val['id']));

            $query[$i2]['erp_invoice_details'] = $this->db->get('erp_invoice_details')->result_array();

            $i2++;
        }







        $j = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date,MAX(created_date) AS paid_date');

            $this->db->where('receipt_bill.receipt_id', $val['id']);

            $query[$j]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();

            $j++;
        }



        if (!empty($inv_all_details) && !empty($query)) {

            $query['inv_all_details'] = $inv_all_details;
        }

        return $query;
    }

}
