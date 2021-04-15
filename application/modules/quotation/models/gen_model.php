<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gen_model extends CI_Model {

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
    private $erp_email_settings = 'erp_email_settings';
    private $erp_user = 'erp_user';
    var $joinTable1 = 'customer c';
    var $joinTable2 = 'erp_quotation_details qd';
    var $primaryTable = 'erp_quotation q';
    // var $selectcolumn = 'q.id,c.store_name,q.q_no,q.total_qty,q.net_total,q.delivery_schedule,q.notification_date,q.created_date';

    var $selectcolumn = 'c.id,c.store_name,c.state_id,c.tin,c.name,c.mobil_number,c.email_id,c.address1,q.id,q.q_no,q.total_qty,q.tax,q.ref_name,q.tax_label,'
            . 'q.net_total,q.delivery_schedule,q.notification_date,q.mode_of_payment,q.remarks,q.subtotal_qty,q.estatus,q.validity,q.created_date';
    var $column_order = array(null, 'q.q_no', 'c.store_name', 'q.total_qty', 'q.net_total', 'q.delivery_schedule', 'q.notification_date', 'q.created_date', 'q.estatus', null);
    var $column_search = array('q.q_no', 'c.store_name', 'q.total_qty', 'q.net_total', 'q.delivery_schedule', 'q.notification_date', 'q.created_date', 'q.estatus');
    var $order = array('q.id' => 'DESC'); // default order

    function __construct() {

        parent::__construct();
    }

    public function insert_quotation($data) {

        if ($this->db->insert($this->erp_quotation, $data)) {

            $insert_id = $this->db->insert_id();



            return $insert_id;
        }

        return false;
    }

    public function insert_quotation_details($data) {

        $this->db->insert_batch($this->erp_quotation_details, $data);

        return true;
    }

    public function update_increment($id) {

        $this->db->where($this->increment_table . '.id', 12);

        if ($this->db->update($this->increment_table, $id)) {

            return true;
        }

        return false;
    }

    public function get_customer($atten_inputs) {



        $this->db->select('name,customer.id,customer.mobil_number,customer.email_id,customer.address1,customer.store_name,customer.tin,customer.credit_days,customer.advance,customer.credit_limit,customer_type,customer.temp_credit_limit,customer.approved_by,customer.state_id,erp_invoice.id as in_id,erp_invoice.net_total');

        $this->db->where($this->customer . '.status', 1);



        $this->db->where($this->customer . '.id', $atten_inputs['cust_id']);

        $this->db->join('erp_invoice', 'erp_invoice.customer=customer.id', 'left');

        $query = $this->db->get($this->customer)->result_array();



        $i = 0;

        $bal = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date,MAX(created_date) AS paid_date');

            $this->db->where('receipt_bill.receipt_id', $val['in_id']);

            $query[$i]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();

            $bal = $bal + ($val['net_total'] - ( $query[$i]['receipt_bill'][0]['receipt_paid'] + $query[$i]['receipt_bill'][0]['receipt_discount']));

            $i++;
        }

        $query[0]['balance'] = $bal;

        return $query;
    }

    public function get_all_email_details() {

        $this->db->select('*');

        $this->db->where("(type='q_sender' OR type='q_email' OR type='q_subject' OR type='q_cc_email')");

        // $this->db->where($this->erp_email_settings.'.type','q_email');

        $query = $this->db->get($this->erp_email_settings)->result_array();

        return $query;
    }

    public function get_customer_by_id($id) {

        $this->db->select('name,mobil_number,email_id,address1,store_name,customer_type,credit_days,credit_limit');

        $this->db->where($this->customer . '.id', $id);

        return $this->db->get($this->customer)->result_array();
    }

    public function get_all_nick_name() {

        $this->db->select('*');

        $this->db->where($this->erp_user . '.status', 1);

        $query = $this->db->get($this->erp_user)->result_array();

        return $query;
    }

    public function get_product($atten_inputs) {

        $this->db->select('erp_product.id,erp_product.model_no,product_name,product_description,product_image,type,cash_cus_price,credit_cus_price,cash_con_price,credit_con_price,vip_price,vvip_price,cost_price,selling_price,cgst,sgst,discount,category_id,erp_product.firm_id,erp_product.brand_id,h1_price,h2_price,unit,igst,erp_stock.quantity,erp_product.sales_price,erp_product.hsn_sac,erp_product.cost_price_without_gst,erp_product.sales_price_without_gst');

        $this->db->where($this->erp_product . '.status', 1);

        $this->db->where($this->erp_product . '.firm_id', $atten_inputs['firm_id']);

        if ($atten_inputs['cat_id'])
            $this->db->where($this->erp_product . '.category_id', $atten_inputs['cat_it']);

        $this->db->where($this->erp_product . '.id', $atten_inputs['model_number_id']);

        $this->db->join('erp_stock', 'erp_stock.product_id = erp_product.id', 'left');

        $this->db->where('erp_stock.quantity >', 0.00);

        $this->db->where('erp_stock.category !=', 0);

        $this->db->where('erp_stock.brand !=', 0);

        $query = $this->db->get($this->erp_product)->result_array();


        foreach ($query as $key => $result_data) {

            $this->db->select('ime.ime_code');
            $this->db->where('ime.product_id', $result_data['id']);
            $this->db->where('ime.status', 'open');
            $ime_data = $this->db->get('erp_po_ime_code_details as ime')->result_array();

            $query[$key]['ime_details'] = $ime_data;
        }

        return $query;
    }

    public function get_product_by_frim_id($atten_inputs) {

        $this->db->select('erp_product.id,erp_product.product_name as value,erp_product.category_id,erp_stock.quantity');
        $this->db->join('erp_stock', 'erp_stock.product_id = erp_product.id', 'left');
        // $this->db->like('erp_product.product_name', $atten_inputs['pro']);
        $keyword = $atten_inputs['pro'];
        $this->db->where("erp_product.product_name LIKE '%$keyword%'");
        $this->db->where($this->erp_product . '.status', 1);
        //if ($id != '')
        $this->db->where($this->erp_product . '.firm_id', $atten_inputs['firm_id']);
        if($atten_inputs['category_id'])
            $this->db->where($this->erp_product . '.category_id', $atten_inputs['category_id']);
        if (isset($atten_inputs['sale_type']) && $atten_inputs['sale_type'] == "purchase") {

        } else {
            $this->db->where('erp_stock.quantity >', 0.00);
        }
        $this->db->where('erp_stock.firm_id !=', 0);
        $this->db->group_by('erp_product.id');
        $this->db->limit(20);
        // $this->db->where($this->erp_product . '.type', 1);
        //$this->db->where($this->erp_product . '.id', $atten_inputs['model_number_id']);
        //$this->db->like($this->erp_product . '.product_name', $atten_inputs['q']);
        $query = $this->db->get($this->erp_product)->result_array();
        return $query;
    }

    public function get_model_no_by_frim_id($atten_inputs) {

        $this->db->select('id,model_no as value');

        $this->db->where($this->erp_product . '.status', 1);

        //if ($id != '')

        $this->db->where($this->erp_product . '.firm_id', $atten_inputs);

        $this->db->where('erp_product.model_no !=', '');

        // $this->db->where($this->erp_product . '.type', 1);
        //$this->db->where($this->erp_product . '.id', $atten_inputs['model_number_id']);
        //$this->db->like($this->erp_product . '.product_name', $atten_inputs['q']);

        $query = $this->db->get($this->erp_product)->result_array();

        return $query;
    }

    public function get_service($atten_inputs, $id) {

        $this->db->select('id,model_no,product_name,product_description,product_image,type,selling_price,cgst,sgst,category_id,brand_id');

        $this->db->where($this->erp_product . '.status', 1);

        if ($id != '')
            $this->db->where($this->erp_product . '.firm_id', $id);

        $this->db->where($this->erp_product . '.type', 2);

        $this->db->like($this->erp_product . '.product_name', $atten_inputs['s']);

        $query = $this->db->get($this->erp_product)->result_array();

        return $query;
    }

    public function get_all_quotation($serch_data) {



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

        $this->db->select('customer.id as customer,customer.store_name,customer.state_id,customer.tin,customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.id,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
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

    public function get_all_quotation_for_quotation_report($search = NULL) {



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

        $this->db->select('customer.id as customer,customer.store_name,customer.state_id,customer.tin,customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.id,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
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

        if (empty($serch_data)) {

            $this->db->where("DATE_FORMAT(" . $this->erp_quotation . ".created_date,'%m') = '" . date('m') . "'");
        }

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

    function get_quotation_report_datatables($search_data) {





        $this->_get_quotation_report_datatables_query($search_data);





        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

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

    function _get_quotation_report_datatables_query($serch_data = array()) {

        if (!isset($serch_data['from_date']))
            $serch_data['from_date'] = '';

        if (!isset($serch_data['to_date']))
            $serch_data['to_date'] = '';

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

        $this->db->select('customer.id as customer,customer.store_name,customer.state_id,customer.tin,customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.id,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
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

        if (empty($serch_data)) {

            $this->db->where("DATE_FORMAT(" . $this->erp_quotation . ".created_date,'%m') = '" . date('m') . "'");
        }



        $this->db->order_by('erp_quotation.id', 'desc');

        $this->db->join('customer', 'customer.id=erp_quotation.customer');

        $this->db->join('erp_quotation_details', 'erp_quotation_details.q_id=erp_quotation.id');

        $this->db->group_by('erp_quotation.id');



        $column_order = array(null, 'erp_quotation.q_no', 'customer.store_name', 'erp_quotation.total_qty', 'erp_quotation.net_total', 'erp_quotation.delivery_schedule', 'erp_quotation.created_date', 'erp_quotation.estatus', null);

        $column_search = array('erp_quotation.q_no', 'customer.store_name', 'erp_quotation.total_qty', 'erp_quotation.net_total', 'erp_quotation.delivery_schedule', 'erp_quotation.created_date', 'erp_quotation.estatus');

        $order = array('erp_quotation.id' => 'DESC');



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

            $where = "(" . $like . " )";

            $this->db->where($where);
        }

        if (isset($_POST['order']) && $column_order[$_POST['order']['0']['column']] != null) { // here order processing
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {

            $order = $order;

            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_quotation_report() {

        $this->_get_quotation_report_datatables_query();

        $query = $this->db->get('erp_quotation');

        return $query->num_rows();
    }

    function count_all_quotation_report() {

        $this->_get_quotation_report_datatables_query();

        $this->db->from('erp_quotation');

        return $this->db->count_all_results();
    }

    public function get_all_quotation_for_report($search = NULL) {

        //$this->db->select('(select SUM(erp_stock.quantity) from erp_stock where product_id = erp_product.id) as individual');

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->select('customer.id as customer,customer.store_name,customer.state_id,customer.tin,customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.id,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
                . 'erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus,erp_quotation.validity,erp_quotation.created_date');



        $this->db->where_in('erp_quotation.firm_id', $frim_id);

        $this->db->where('erp_quotation.estatus !=', 0);

        $this->db->where('erp_quotation.type =', 1);

        $this->db->order_by('erp_quotation.id', 'desc');

        $this->db->join('customer', 'customer.id=erp_quotation.customer');

        $this->db->join('erp_quotation_details', 'erp_quotation_details.q_id=erp_quotation.id');

        $this->db->group_by('erp_quotation.id');

        if ($search != NULL && $search != '') {

            $search_data = json_decode($search);

            if ($search_data[0]->q_no != '' && $search_data[0]->q_no != 'Select') {

                $this->db->where('erp_quotation.q_no', $search_data[0]->q_no);
            }

            if ($search_data[1]->customer != '' && $search_data[1]->customer != 'Select') {

                $this->db->where('erp_quotation.customer', $search_data[1]->customer);
            }

            if ($search_data[2]->product != '' && $search_data[2]->product != 'Select') {

                $this->db->where($this->erp_quotation_details . '.product_id', $search_data[2]->product);
            }



            if ($search_data[3]->from != '') {

                $this->db->where($this->erp_quotation . '.created_date >=', $search_data[3]->from);
            }

            if ($search_data[4]->to != '') {

                $this->db->where($this->erp_quotation . '.created_date <=', $search_data[4]->to);
            }
        }



        $query = $this->db->get('erp_quotation');

        //print_r($query->result_array());

        if ($query->num_rows() >= 0) {

            return $query->result_array();
        }

        return false;
    }

    public function get_all_quotation_by_id($id) {

        $this->db->select('erp_user.nick_name,customer.id as customer,customer.store_name,customer.state_id,customer.tin,customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.id,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
                . 'erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus,erp_quotation.validity,erp_quotation.created_date,erp_quotation.firm_id,erp_manage_firms.firm_name');

        //$this->db->where('erp_quotation.estatus',1);

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

        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,erp_product.model_no,'
                . 'erp_quotation_details.id as del_id,erp_quotation_details.category,erp_quotation_details.product_id,erp_quotation_details.brand,erp_quotation_details.quantity,'
                . 'erp_quotation_details.per_cost,erp_quotation_details.tax,erp_quotation_details.gst,erp_quotation_details.discount,erp_quotation_details.sub_total,erp_product.model_no,erp_product.product_image,erp_quotation_details.unit,erp_quotation_details.igst,'
                . 'erp_quotation_details.product_description,erp_product.type,erp_product.hsn_sac_name');

        $this->db->where('erp_quotation_details.q_id', $id);

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_quotation_details.q_id');

        $this->db->join('erp_category', 'erp_category.cat_id=erp_quotation_details.category', 'LEFT');

        $this->db->join('erp_product', 'erp_product.id=erp_quotation_details.product_id');

        $this->db->join('erp_brand', 'erp_brand.id=erp_quotation_details.brand', 'LEFT');



        $query = $this->db->get('erp_quotation_details')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('erp_stock.quantity');

            $this->db->where('product_id', $val['product_id']);

            //  if ($val['category'] != '')
            //    $this->db->where('category', $val['category']);
            //   if ($val['brand'] != '')
            //       $this->db->where('brand', $val['brand']);

            $query[$i]['stock'] = $this->db->get('erp_stock')->result_array();

            $i++;
        }

//        if ($query->num_rows() >= 0) {
//            return $query->result_array();
//        echo"<pre>";
//        print_r($query);
//        exit;
//        }

        return $query;
    }

    public function get_all_quotation_history_by_id($id) {

        $this->db->select('erp_user.nick_name,customer.store_name,customer.state_id,customer.tin,customer.id,customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation_history.q_no,erp_quotation_history.total_qty,erp_quotation_history.tax,erp_quotation_history.ref_name,erp_quotation_history.tax_label,'
                . 'erp_quotation_history.net_total,erp_quotation_history.delivery_schedule,erp_quotation_history.notification_date,erp_quotation_history.mode_of_payment,erp_quotation_history.remarks,erp_quotation_history.subtotal_qty,erp_quotation_history.validity,erp_quotation_history.created_date,erp_quotation_history.firm_id,erp_manage_firms.firm_name');

        $this->db->where('erp_quotation_history.eStatus', 1);

        $this->db->where('erp_quotation_history.id', $id);

        $this->db->join('customer', 'customer.id=erp_quotation_history.customer');

        $this->db->join('erp_user', 'erp_user.id=erp_quotation_history.ref_name', 'LEFT');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_quotation_history.firm_id', 'LEFT');

        $query = $this->db->get('erp_quotation_history');

        if ($query->num_rows() >= 0) {

            return $query->result_array();
        }

        return false;
    }

    public function get_all_quotation_history_details_by_id($id) {

        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_brand.id,erp_brand.brands,erp_product.model_no,'
                . ' erp_product.id,erp_product.model_no,erp_product.product_name,erp_product.product_image,erp_quotation_history_details.product_description,erp_product.type,erp_quotation_history_details.unit,'
                . 'erp_quotation_history_details.category,erp_quotation_history_details.product_id,erp_quotation_history_details.brand,erp_quotation_history_details.quantity,erp_quotation_history_details.igst,'
                . 'erp_quotation_history_details.per_cost,erp_quotation_history_details.tax,erp_quotation_history_details.gst,erp_quotation_history_details.sub_total,erp_product.hsn_sac_name');

        $this->db->where('erp_quotation_history.id', $id);

        $this->db->join('erp_quotation_history', 'erp_quotation_history.id=erp_quotation_history_details.h_id');

        $this->db->join('erp_category', 'erp_category.cat_id=erp_quotation_history_details.category');

        $this->db->join('erp_product', 'erp_product.id=erp_quotation_history_details.product_id');

        $this->db->join('erp_brand', 'erp_brand.id=erp_quotation_history_details.brand', 'LEFT');

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

    public function get_reference_amount($id) {

        $this->db->select('erp_user.id,erp_reference_groups.commission_rate,erp_reference_groups.user_id');

        $this->db->where('erp_user.id', $id);

        $this->db->join('erp_reference_groups', 'erp_reference_groups.user_id=erp_user.id');

        $query = $this->db->get('erp_user')->result_array();

        return $query[0]['commission_rate'];
    }

    public function insert_invoice_product_details($data) {

        $this->db->insert_batch('erp_invoice_product_details', $data);

        return true;
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

    public function change_quotation_status($id, $status) {

        $this->db->where($this->erp_quotation . '.id', $id);

        if ($this->db->update($this->erp_quotation, array('estatus' => $status))) {

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

    public function get_all_gen($serch_data = NULL) {



        if (isset($serch_data) && !empty($serch_data)) {

            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';

            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';





            if (!empty($serch_data['q_no']) && $serch_data['q_no'] != '') {



                $this->db->where($this->erp_quotation . 'q_no', $serch_data['q_no']);
            }

            if (!empty($serch_data['po'])) {

                $this->db->where($this->erp_quotation . '.q_no', $serch_data['po']);
            }



            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_quotation . ".inv_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_quotation . ".inv_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_quotation . ".inv_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["style"]) && $serch_data["style"] != "") {



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

            $this->db->where("DATE_FORMAT(" . $this->erp_quotation . ".inv_date,'%Y-%m-%d') >='" . $from . "' AND DATE_FORMAT(" . $this->erp_quotation . ".inv_date,'%Y-%m-%d') <= '" . $to . "'");
        }



        $this->db->select('*');

        $this->db->select('customer.name');

        $this->db->order_by($this->erp_quotation . '.id', 'desc');

        $this->db->join('erp_quotation', 'erp_quotation.q_no=' . $this->erp_quotation . '.q_no');

        $this->db->join('customer', 'customer.id=erp_quotation.customer');

        $query = $this->db->get($this->erp_quotation)->result_array();





        return $query;
    }

    public function get_prefix_by_frim_id($id) {

        $this->db->select('prefix');

        $this->db->where('erp_manage_firms.firm_id', $id);

        return $this->db->get('erp_manage_firms')->result_array();
    }

    public function get_reference_group_by_frim_id($id) {

        $this->db->select('*');

        $this->db->where('erp_reference_groups.firm_id', $id);

        $query = $this->db->get('erp_reference_groups')->result_array();

        $i = 0;

        foreach ($query as $val) {

            if ($val['reference_type'] == 3 || $val['reference_type'] == 4) {

                $query[$i]['user_name'] = $val['others'];

                $query[$i]['user_id'] = $val['id'];

                $i++;
            } else if ($val['reference_type'] == 1) {

                $this->db->select('name');

                $this->db->where('erp_user.id', $val['user_id']);

                $user = $this->db->get('erp_user')->result_array();

                $query[$i]['user_name'] = $user[0]['name'];

                $query[$i]['user_id'] = $val['user_id'];

                $i++;
            } else if ($val['reference_type'] == 2) {

                $this->db->select('store_name');

                $this->db->where('customer.id', $val['customer_id']);

                $customer = $this->db->get('customer')->result_array();

                $query[$i]['user_name'] = $customer[0]['store_name'];

                $query[$i]['user_id'] = $val['customer_id'];

                $i++;
            }
        }

        return $query;
    }

    public function get_sales_man_by_frim_id($id) {

        $this->db->select('*');

        $this->db->where('erp_sales_man.firm_id', $id);

        $query = $this->db->get('erp_sales_man')->result_array();

        return $query;
    }

    public function get_all_product() {

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->select('*');

        $this->db->where_in('erp_product.firm_id', $frim_id);

        $query = $this->db->get('erp_product')->result_array();

        return $query;
    }

    public function get_all_customers() {

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }


        $this->db->select('name,id,mobil_number,email_id,address1,store_name,tin,credit_days,credit_limit,temp_credit_limit,approved_by,firm_id');

        $this->db->where($this->customer . '.status', 1);

        $this->db->where_in('customer.firm_id', $frim_id);

        $query = $this->db->get($this->customer)->result_array();

        return $query;
    }

    public function get_all_customer_quotation() {

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->select('customer.store_name,customer.id');

        $this->db->where($this->customer . '.status', 1);

        $this->db->join('erp_quotation', 'erp_quotation.customer=customer.id');

        $this->db->where_in('erp_quotation.firm_id', $frim_id);

        $this->db->group_by('erp_quotation.customer');

        $query = $this->db->get($this->customer)->result_array();

        return $query;
    }

    public function get_all_product_quotation() {

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->select('erp_product.product_name,erp_product.id');

        $this->db->where($this->erp_product . '.status', 1);

        $this->db->join('erp_quotation_details', 'erp_quotation_details.product_id=erp_product.id');

        $this->db->where_in('erp_product.firm_id', $frim_id);

        $this->db->group_by('erp_quotation_details.product_id');

        $query = $this->db->get($this->erp_product)->result_array();

        return $query;
    }

    public function get_all_quotation_no() {

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->select('erp_quotation.q_no,erp_quotation.id');

        $this->db->where_in('erp_quotation.firm_id', $frim_id);

        //$this->db->where($this->erp_quotation . '.status', 1);

        $this->db->group_by('erp_quotation.id');

        $query = $this->db->get($this->erp_quotation)->result_array();

        return $query;
    }

    public function get_company_details_by_firm($s_id) {

        $this->db->select('erp_manage_firms.*,erp_quotation.firm_id');

        $this->db->where('erp_quotation.id', $s_id);

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_quotation.firm_id');

        $query = $this->db->get('erp_quotation')->result_array();

        return $query;
    }

    public function get_datatables() {

        $this->db->select($this->selectColumn);



        $this->_get_datatables_query();



        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);



        $query = $this->db->get();



        return $query->result_array();
    }

    function _get_datatables_query() {

        //Join Table



        $this->db->join($this->joinTable1, 'c.id=q.customer');

        $this->db->join($this->joinTable2, 'qd.q_id=q.id');

        $this->db->group_by('q.id');

        $this->db->where('q.eStatus !=', 0);



        $firms = $this->user_auth->get_user_firms();



        $frim_id = array();



        foreach ($firms as $value) {



            $frim_id[] = $value['firm_id'];
        }



        $this->db->where_in('q.firm_id', $frim_id);



        $this->db->from($this->primaryTable);



        $i = 0;



        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->like($item, $_POST['search']['value']);
                } else {



                    $this->db->or_like($item, $_POST['search']['value']);
                }
            }



            $i++;
        }



        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {



            $order = $this->order;



            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function count_all() {

        $this->db->from($this->primaryTable);



        return $this->db->count_all_results();
    }

    public function count_filtered() {

        $this->_get_datatables_query();



        $query = $this->db->get();



        return $query->num_rows();
    }

}
