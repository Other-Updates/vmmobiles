<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Purchase_order_model extends CI_Model {

    private $table_name4 = 'master_style';
    private $table_name5 = 'master_style_size';
    private $vendor = 'vendor';
    private $erp_po = 'erp_po';
    private $erp_po_details = 'erp_po_details';
    private $increment_table = 'increment_table';
    private $erp_product = 'erp_product';
    private $erp_user = 'erp_user';
    private $erp_stock = 'erp_stock';
    private $erp_stock_history = 'erp_stock_history';
    var $joinTable1 = 'vendor v';
    var $joinTable2 = 'erp_po_details pd';
    var $joinTable3 = 'erp_manage_firms f';
    var $primaryTable = 'erp_po p';
    var $category= 'erp_category c';
    var $selectcolumn = 'v.tin,v.store_name,v.state_id,v.name,v.mobil_number,v.email_id,v.address1,p.*,f.firm_name,c.CategoryName';
    var $column_order = array(null, 'f.firm_name', 'p.pr_no', 'p.pr_status', 'v.store_name', 'p.total_qty', 'p.delivery_qty', 'p.net_total', 'p.created_date', 'p.pr_status', 'p.delivery_status', null);
    var $column_search = array('f.firm_name', 'p.pr_no', 'p.pr_status', 'v.store_name', 'p.total_qty', 'p.delivery_qty', 'p.net_total', 'p.created_date', 'p.pr_status', 'p.delivery_status');
    var $order = array('p.id' => 'DESC'); // default order

    function __construct() {

        parent::__construct();

        $this->load->database();
    }

    public function insert_po($data) {

        if ($this->db->insert($this->erp_po, $data)) {

            $insert_id = $this->db->insert_id();



            return $insert_id;
        }

        return false;
    }

    public function get_supplier_by_firmid($id) {
        $this->db->Select('id,store_name');
        $this->db->where('firm_id', $id);
        $query = $this->db->get('vendor')->result_array();

        $result = [];

        foreach ($query as $key => $data) {
            $result[$key]['id'] = $data['id'];
            $result[$key]['value'] = $data['store_name'];
        }
        return $result;
    }

    public function remove_stocks_by_poedit($product_id, $qty, $firm_id, $cat_id) {

        if ($qty != 0) {
            $this->db->where('firm_id', $firm_id);
            $this->db->where('product_id', $product_id);
            $this->db->where('category', $cat_id);
            $get_old_qty = $this->db->get('erp_stock')->result_array();

            $old_stock_qty = $get_old_qty[0]['quantity'];

            $new_qty = $qty;

            if ($old_stock_qty > $qty)
                $qty_product = $old_stock_qty - $qty;
            else
                $qty_product = $qty - $old_stock_qty;

            $this->db->where('firm_id', $firm_id);
            $this->db->where('product_id', $product_id);
            $this->db->where('category', $cat_id);
            $this->db->update('erp_stock', ['quantity' => $qty_product]);
        }
    }

    public function insert_po_details($data) {

        $this->db->insert_batch($this->erp_po_details, $data);

        return true;
    }

    public function insertpo_details($data) {


        if ($this->db->insert($this->erp_po_details, $data)) {

            $insert_id = $this->db->insert_id();



            return $insert_id;
        }

        return false;
    }

    public function insert_ime_code($data) {

        $ime_code = explode(',', $data['ime_code']);


        $insert_id = '';
        foreach ($ime_code as $key => $result) {

            $data['ime_code'] = $result;


            $this->db->insert('erp_po_ime_code_details', $data);

            $insert_id = $this->db->insert_id();
        }

        return $insert_id;
    }

    public function get_ime_by_poid($id) {
        $this->db->select('ime_code');
        $this->db->where('po_id', $id);
        $query = $this->db->get('erp_po_ime_code_details')->result_array();
        return $query;
    }

    public function check_duplicate_ime_code($code) {



        $result = '';
        foreach ($code as $key => $data) {

            $this->db->where('ime_code', $data);

            $this->db->where('status', 'open');



            $result_data = $this->db->get('erp_po_ime_code_details')->result_array();
            if (!empty($result_data)) {
                $result[] = $key + 1;
            }
        }
        if (!empty($result))
            return $result;
        else
            return 0;
    }

    public function check_duplicate_ime_code_edit($code) {



        $result = '';
        foreach ($code as $key => $data) {

            $this->db->where('ime_code', $data);

            $this->db->where('status', 'open');

            $result_data = $this->db->get('erp_po_ime_code_details')->result_array();
            if (count($result_data) >= 2) {
                $result[] = $key + 1;
            }
        }
        if (!empty($result))
            return $result;
        else
            return 0;
    }

    public function check_stock($check_stock, $po_id) {

        $this->db->select('erp_category.firm_id');

        $this->db->where('erp_category.cat_id', $check_stock['category']);

        $firm_id_details = $this->db->get('erp_category')->result_array();

        $firm_id = 0;

        if (!empty($firm_id_details)) {

            $firm_id = $firm_id_details[0]['firm_id'];
        }

        $this->db->select('*');

        $this->db->where('category', $check_stock['category']);

        $this->db->where('product_id', $check_stock['product_id']);

        $this->db->where('firm_id', $firm_id);

        $current_stock = $this->db->get($this->erp_stock)->result_array();

        if (isset($current_stock) && !empty($current_stock)) {

            //Update Stock
//echo "<pre>";
//print_r($check_stock);
//print_r($current_stock);

            $quantity = $check_stock['quantity'] + $current_stock[0]['quantity'];



            $this->db->where('category', $check_stock['category']);

            $this->db->where('product_id', $check_stock['product_id']);

            $this->db->where('firm_id', $firm_id);

            $this->db->update($this->erp_stock, array('quantity' => $quantity));
        } else {

            //Insert Stcok

            $insert_stock = array();

            $insert_stock['firm_id'] = $firm_id;

            $insert_stock['category'] = $check_stock['category'];

            $insert_stock['product_id'] = $check_stock['product_id'];

            $insert_stock['brand'] = $check_stock['brand'];

            $insert_stock['quantity'] = $check_stock['quantity'];

            $this->db->insert($this->erp_stock, $insert_stock);
        }

        //Insert Stock History

        $insert_stock_his = array();

        $insert_stock_his['ref_no'] = $po_id['po_id'];

        $insert_stock_his['type'] = 1;

        $insert_stock_his['category'] = $check_stock['category'];

        $insert_stock_his['product_id'] = $check_stock['product_id'];

        $insert_stock_his['brand'] = $check_stock['brand'];

        $insert_stock_his['quantity'] = $check_stock['quantity'];

        $insert_stock_his['created_date'] = date('Y-m-d H:i');

        //echo"<pre>"; print_r($insert_stock_his); exit;

        $this->db->insert($this->erp_stock_history, $insert_stock_his);
    }

    public function insert_stock_details($data) {



        $this->db->insert_batch($this->erp_stock, $data);

        return true;
    }

    public function insert_stock_history($data) {

        $this->db->insert_batch($this->erp_stock_history, $data);

        return true;
    }

    public function get_stock_details() {

        $this->db->select('*');

        return $this->db->get($this->erp_stock)->result_array();
    }

    public function update_increment($id) {

        $this->db->where($this->increment_table . '.id', 5);

        if ($this->db->update($this->increment_table, $id)) {

            return true;
        }

        return false;
    }

    public function get_customer($atten_inputs) {

//        $firms = $this->user_auth->get_user_firms();
//        $frim_id = array();
//        foreach ($firms as $value) {
//            $frim_id[] = $value['firm_id'];
//        }

        $this->db->select('name,id,mobil_number,email_id,address1,store_name,tin,credit_days,state_id');

        $this->db->where($this->vendor . '.status', 1);

        // $this->db->where_in($this->vendor . '.firm_id', $frim_id);
//        if ($id != NULL) {
//            $this->db->where($this->vendor . '.firm_id', $id);
//        }if (!empty($atten_inputs)) {
//            $this->db->like($this->vendor . '.store_name', $atten_inputs['q']);
//        }

        $this->db->where($this->vendor . '.id', $atten_inputs['cust_id']);

        $query = $this->db->get($this->vendor)->result_array();

        return $query;
    }

    public function get_customer_by_id($id) {

        $this->db->select('name,mobil_number,email_id,address1');

        $this->db->where($this->vendor . '.id', $id);

        return $this->db->get($this->vendor)->result_array();
    }

    public function get_product($atten_inputs) {

        $this->db->select('erp_product.id,model_no,product_name,product_description,product_image,type,cost_price,sales_price,cgst,sgst,igst,discount,category_id,brand_id,unit,erp_stock.quantity,erp_product.hsn_sac,erp_product.cost_price_without_gst');
		
        //if ($id != '')
        //    $this->db->where($this->erp_product . '.firm_id', $id);

        $this->db->where($this->erp_product . '.status', 1);

        // $this->db->where($this->erp_product . '.category_id', $id);
        // $this->db->where($this->erp_product . '.type', 1);
        // $this->db->like($this->erp_product . '.product_name', $atten_inputs['q']);

        $this->db->where($this->erp_product . '.id', $atten_inputs['model_number_id']);

        $this->db->join('erp_stock', 'erp_stock.product_id = erp_product.id', 'left');

        $query = $this->db->get($this->erp_product)->result_array();

        return $query;
    }

    public function get_product_by_id($id) {

        $this->db->select('model_no,product_name,product_description,product_image');

        $this->db->where($this->erp_product . '.id', $id);

        return $this->db->get($this->erp_product)->result_array();
    }

    public function get_all_purchase_order_details($purchase_order_id) {

        $this->db->select('SUM(delivery_quantity) AS delivery_quantity');

        $this->db->where($this->erp_po_details . '.po_id', $purchase_order_id);

        return $this->db->get($this->erp_po_details)->result_array();
    }

    public function get_all_po($serch_data = array()) {

        if (isset($serch_data) && !empty($serch_data)) {

            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';

            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';





            if (!empty($serch_data['po_no']) && $serch_data['po_no'] != 'Select') {



                $this->db->where($this->erp_po . '.po_no', $serch_data['po_no']);
            }

            if (!empty($serch_data['supplier']) && $serch_data['supplier'] != 'Select') {

                $this->db->where($this->vendor . '.store_name', $serch_data['supplier']);
            }

            if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

                $this->db->where($this->erp_po_details . '.product_id', $serch_data['product']);
            }



            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }

        $this->db->select('vendor.id as vendor,vendor.tin,vendor.store_name,vendor.state_id,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_po.*');

        $this->db->select('erp_manage_firms.firm_name');



        if (empty($serch_data)) {

            $firms = $this->user_auth->get_user_firms();

            $frim_id = array();

            foreach ($firms as $value) {

                $frim_id[] = $value['firm_id'];
            }
        } else {
            $frim_id = $serch_data['firm_id'];
        }

        $this->db->where_in('erp_po.firm_id', $frim_id);

        $this->db->where('erp_po.estatus !=', 0);

        $this->db->join('vendor', 'vendor.id=erp_po.supplier');

        $this->db->join('erp_po_details', 'erp_po_details.po_id=erp_po.id');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_po.firm_id', 'left');   

        $this->db->group_by('erp_po.id');

        $this->db->order_by($this->erp_po . '.id', 'desc');

        $query = $this->db->get('erp_po');

        if ($query->num_rows() >= 0) {

            return $query->result_array();
        }

        return false;
    }

    public function get_all_purchase_order($serch_data = array()) {

        if (isset($serch_data) && !empty($serch_data)) {

            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';

            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';





            if (!empty($serch_data['po_no']) && $serch_data['po_no'] != 'Select') {



                $this->db->where($this->erp_po . '.po_no', $serch_data['po_no']);
            }

            if (!empty($serch_data['supplier']) && $serch_data['supplier'] != 'Select') {

                $this->db->where($this->vendor . '.store_name', $serch_data['supplier']);
            }

            if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

                $this->db->where($this->erp_po_details . '.product_id', $serch_data['product']);
            }



            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }

        $this->db->select('vendor.id as vendor,vendor.tin,vendor.store_name,vendor.state_id,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_po.id,erp_po.po_no,erp_po.total_qty,erp_po.tax,erp_po.tax_label,'
                . 'erp_po.net_total,erp_po.delivery_schedule,erp_po.mode_of_payment,erp_po.remarks,erp_po.subtotal_qty,erp_po.estatus,erp_po.created_date');

        $this->db->select('erp_manage_firms.firm_name');

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->where_in('erp_po.firm_id', $frim_id);

        $this->db->where('erp_po.estatus !=', 0);

        if (empty($serch_data)) {

            $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%m') = '" . date('m') . "'");
        }

        $this->db->join('vendor', 'vendor.id=erp_po.supplier');

        $this->db->join('erp_po_details', 'erp_po_details.po_id=erp_po.id');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_po.firm_id', 'left');

        $this->db->group_by('erp_po.id');

        $this->db->order_by($this->erp_po . '.id', 'desc');

        $query = $this->db->get('erp_po');

        if ($query->num_rows() >= 0) {

            return $query->result_array();
        }

        return false;
    }

    function get_purchase_report_datatables($search_data) {



        $this->_get_purchase_report_datatables_query($search_data);

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        elseif (isset($search_data['limit']) && !empty($search_data['limit']) || isset($search_data['offset']) && !empty($search_data['offset']))
            $this->db->limit($search_data['limit'], $search_data['offset']);

        $query = $this->db->get('erp_po')->result_array();



        return $query;
    }

    function _get_purchase_report_datatables_query($serch_data = array()) {

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





            if (!empty($serch_data['po_no']) && $serch_data['po_no'] != 'Select') {



                $this->db->where($this->erp_po . '.po_no', $serch_data['po_no']);
            }

            if (!empty($serch_data['supplier']) && $serch_data['supplier'] != 'Select') {

                $this->db->where($this->vendor . '.store_name', $serch_data['supplier']);
            }

            if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

                $this->db->where($this->erp_po_details . '.product_id', $serch_data['product']);
            }



            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . date('Y-m-d') . "'");
            }

            if (isset($serch_data['firm_id']) && $serch_data['firm_id'] != 'Select') {

                $firm_id = $serch_data['firm_id'];
                $this->db->where('erp_po.firm_id', $firm_id);
            } else {
                $firms = $this->user_auth->get_user_firms();

                $frim_id = array();

                foreach ($firms as $value) {

                    $frim_id[] = $value['firm_id'];
                }
                $this->db->where_in('erp_po.firm_id', $frim_id);
            }
        }

        $this->db->select('vendor.id as vendor,vendor.tin,vendor.store_name,vendor.state_id,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_po.id,erp_po.po_no,erp_po.total_qty,erp_po.tax,erp_po.tax_label,'
                . 'erp_po.net_total,erp_po.delivery_schedule,erp_po.mode_of_payment,erp_po.remarks,erp_po.subtotal_qty,erp_po.estatus,erp_po.created_date');

        $this->db->select('erp_manage_firms.firm_name');

        $this->db->where('erp_po.estatus !=', 0);



        $this->db->join('vendor', 'vendor.id=erp_po.supplier');

        $this->db->join('erp_po_details', 'erp_po_details.po_id=erp_po.id');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_po.firm_id', 'left');

        $this->db->group_by('erp_po.id');

        $this->db->order_by($this->erp_po . '.id', 'desc');
    }

    public function get_purchase_link($search_data) {

        if (!empty($search_data['product'])) {

            $this->db->select('erp_po.id,erp_po.po_no,erp_po.estatus');

            $this->db->select('erp_po_details.id AS p_id, erp_po_details.product_id');

            $this->db->join('erp_po_details', 'erp_po_details.po_id=erp_po.id');

            $this->db->where('erp_po.estatus !=', 0);

            $this->db->where_in('erp_po_details.product_id', $search_data['product']);

            $this->db->group_by('erp_po.id');

            $query = $this->db->get('erp_po');

            if ($query->num_rows() >= 0) {

                return $query->result_array();
            }

            return false;
        }
    }

    function count_filtered_purchase_report() {

        $this->_get_purchase_report_datatables_query();

        $query = $this->db->get('erp_po');

        return $query->num_rows();
    }

    function count_all_purchase_report() {

        $this->_get_purchase_report_datatables_query();

        $this->db->from('erp_po');

        return $this->db->count_all_results();
    }

    public function get_all_po_for_report($search = NULL) {



        //$this->db->select('(select SUM(erp_stock.quantity) from erp_stock where product_id = erp_product.id) as individual');

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->select('vendor.id as vendor,vendor.tin,vendor.store_name,vendor.state_id,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_po.id,erp_po.po_no,erp_po.total_qty,erp_po.tax,erp_po.tax_label,'
                . 'erp_po.net_total,erp_po.delivery_schedule,erp_po.mode_of_payment,erp_po.remarks,erp_po.subtotal_qty,erp_po.estatus,erp_po.created_date');

        $this->db->select('erp_manage_firms.firm_name');

        $this->db->where_in('erp_po.firm_id', $frim_id);

        $this->db->where('erp_po.estatus !=', 0);

        $this->db->join('vendor', 'vendor.id=erp_po.supplier');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_po.firm_id', 'left');

        $this->db->join('erp_po_details', 'erp_po_details.po_id=erp_po.id');

        $this->db->order_by($this->erp_po . '.id', 'desc');



        if ($search != NULL && $search != '') {

            $search_data = json_decode($search);

            if (!empty($search_data[3]->from))
                $search_data[3]->from = date('Y-m-d', strtotime($search_data[3]->from));

            if (!empty($search_data[4]->to))
                $search_data[4]->to = date('Y-m-d', strtotime($search_data[4]->to));

            if ($search_data[3]->from == '1970-01-01')
                $search_data[3]->from = '';

            if ($search_data[4]->to == '1970-01-01')
                $search_data[4]->to = '';

            if ($search_data[0]->po_no != '' && $search_data[0]->po_no != 'Select') {

                $this->db->where('erp_po.po_no', $search_data[0]->po_no);
            }

            if ($search_data[1]->supplier != '' && $search_data[1]->supplier != 'Select') {

                $this->db->where('vendor.store_name', $search_data[1]->supplier);
            }

            if (($search_data[2]->product) && $search_data[2]->product != 'Select') {

                $this->db->where($this->erp_po_details . '.product_id', $search_data[2]->product);
            }

            if (isset($search_data[3]->from) && $search_data[3]->from != "" && isset($search_data[4]->to) && $search_data[4]->to != "") {



                $this->db->where("DATE_FORMAT(erp_po.created_date,'%Y-%m-%d') >='" . $search_data[3]->from . "' AND DATE_FORMAT(erp_po.created_date,'%Y-%m-%d') <= '" . $search_data[4]->to . "'");
            } elseif (isset($search_data[3]->from) && $search_data[3]->from != "" && isset($search_data[4]->to) && $search_data[4]->to == "") {



                $this->db->where("DATE_FORMAT(erp_po.created_date,'%Y-%m-%d') >='" . $search_data[3]->from . "'");
            } elseif (isset($search_data[3]->from) && $search_data[3]->from == "" && isset($search_data[4]->to) && $search_data[4]->to != "") {



                $this->db->where("DATE_FORMAT(erp_po.created_date,'%Y-%m-%d') <= '" . $search_data[4]->to . "'");
            }
        }

        $this->db->where_in('erp_po.firm_id', $frim_id);

        $this->db->group_by($this->erp_po . '.po_no');

        $query = $this->db->get('erp_po');

        if ($query->num_rows() >= 0) {

            return $query->result_array();
        }

        return false;
    }

    public function get_all_po_by_id($id) {

        $this->db->select('vendor.id as vendor,vendor.tin,vendor.store_name,vendor.state_id,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_po.*,erp_manage_firms.firm_name');

        //$this->db->where('erp_po.estatus',1);

        $this->db->where('erp_po.id', $id);

        $this->db->join('vendor', 'vendor.id=erp_po.supplier', 'left');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_po.firm_id', 'left');

        $query = $this->db->get('erp_po');

        if ($query->num_rows() >= 0) {

            return $query->result_array();
        }

        return false;
    }

    public function get_all_product_by_id($id) {

        $this->db->select('erp_product.id,erp_product.model_no,erp_product.product_name,erp_product.product_image,'
                . 'erp_po_details.product_description');

        $this->db->where('erp_po_details.id', $id);

        $this->db->join('erp_po', 'erp_po.id=erp_po_details.po_id');

        $this->db->join('erp_product', 'erp_product.id=erp_po_details.product_id');

        $query = $this->db->get('erp_po_details');

        if ($query->num_rows() >= 0) {

            return $query->result_array();
        }

        return false;
    }

    public function get_all_po_details_by_id($id) {

        $this->db->select('erp_category.categoryName,erp_product.product_name,erp_brand.brands,erp_product.hsn_sac_name,erp_product.hsn_sac,erp_po_details.*');

        $this->db->where('erp_po_details.po_id', $id);

        $this->db->join('erp_po', 'erp_po.id=erp_po_details.po_id');

        $this->db->join('erp_category', 'erp_category.cat_id=erp_po_details.category');

        $this->db->join('erp_product', 'erp_product.id=erp_po_details.product_id');

        $this->db->join('erp_brand', 'erp_brand.id=erp_po_details.brand', 'LEFT');

        //$this->db->join('erp_stock', 'erp_stock.product_id = erp_po_details.product_id', 'left');

        $query = $this->db->get('erp_po_details')->result_array();



        $i = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            // $this->db->where('category', $val['category']);

            $this->db->where('product_id', $val['product_id']);

            // $this->db->where('brand', $val['brand']);

            $query[$i]['stock'] = $this->db->get('erp_stock')->result_array();



            $this->db->select('ime_code');
            $this->db->where('po_details_id', $val['id']);
            $this->db->where('po_id', $id);
            $ime_details = $this->db->get('erp_po_ime_code_details')->result_array();

            $query[$i]['ime_code_details'] = $ime_details;

            $ime_code = '';
            foreach ($ime_details as $code) {
                $ime_code[] = $code['ime_code'];
            }

            $query[$i]['ime_codes'] = implode(',', $ime_code);


            $i++;
        }

        return $query;
    }

    public function delete_ime_by_poid($id) {
        $this->db->where('po_id', $id);
        $ime_details = $this->db->delete('erp_po_ime_code_details');
        return $ime_details;
    }

    public function update_dc($data, $id) {

        $this->db->where('erp_po' . '.id', $id);

        if ($this->db->update('erp_po', $data)) {

            return true;
        }

        return false;
    }

    public function update_dc_details($data, $id) {

        $this->db->where('erp_po_details' . '.id', $id);

        if ($this->db->update('erp_po_details', $data)) {

            return true;
        }

        return false;
    }
	
	public function update_product($data, $id) {

        $this->db->where('erp_product' . '.id', $id);

        if ($this->db->update('erp_product', $data)) {

            return true;
        }

        return false;
    }

    public function check_old_qty($purchase_order_detail_id) {

        $this->db->select('erp_po_details.*');

        $this->db->where('erp_po_details.id', $purchase_order_detail_id);

        $query = $this->db->get($this->erp_po_details)->result_array();

        return $query;
    }

    public function delete_po_deteils_by_id($id) {

        $this->db->where('po_id', $id);

        $this->db->delete($this->erp_po_details);
    }

    public function change_po_status($id, $status) {

        $this->db->where($this->erp_po . '.id', $id);

        if ($this->db->update($this->erp_po, array('estatus' => $status))) {

            return true;
        }

        return false;
    }

    public function update_po($data, $id) {

        $this->db->where($this->erp_po . '.id', $id);

        if ($this->db->update($this->erp_po, $data)) {

            return true;
        }

        return false;
    }

    public function delete_po($id) {

        $this->db->where('id', $id);

        if ($this->db->update($this->erp_po, $data = array('estatus' => 0))) {

            return true;
        }

        return false;
    }

    public function get_the_total_po_count() {

        $current_date = date('Y-m-d');

        $this->db->select('net_total');

        $this->db->where($this->erp_po . '.created_date', $current_date);

        $query = $this->db->get($this->erp_po);

        if ($query->num_rows() >= 0) {

            return $query->result_array();
        }

        return false;
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

        $this->db->select('*');

        $this->db->where($this->vendor . '.status', 1);

        $this->db->where_in($this->vendor . '.firm_id', $frim_id);

        $query = $this->db->get($this->vendor)->result_array();

        return $query;
    }

    public function get_all_supplier_po() {

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->select('vendor.store_name,vendor.id');

        $this->db->where($this->vendor . '.status', 1);

        $this->db->join('erp_po', 'erp_po.supplier=vendor.id');

        $this->db->where_in('erp_po.firm_id', $frim_id);

        $this->db->group_by('erp_po.supplier');

        $query = $this->db->get($this->vendor)->result_array();

        return $query;
    }

    public function get_all_product_po() {

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->select('erp_product.product_name,erp_product.id');

        $this->db->where($this->erp_product . '.status', 1);

        $this->db->join('erp_po_details', 'erp_po_details.product_id=erp_product.id');

        $this->db->where_in('erp_product.firm_id', $frim_id);

        $this->db->group_by('erp_po_details.product_id');

        $query = $this->db->get($this->erp_product)->result_array();

        return $query;
    }

    public function get_company_details_by_firm($s_id) {

        $this->db->select('erp_manage_firms.*,erp_po.firm_id');

        $this->db->where('erp_po.id', $s_id);

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_po.firm_id');

        $query = $this->db->get('erp_po')->result_array();

        return $query;
    }

    public function get_datatables() {

        $this->db->select($this->selectColumn);

        //  $this->db->select('p.id as porder_id,p.created_date as po_date');



        $this->_get_datatables_query();



        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);



        $query = $this->db->get();
       

        $data = $query->result_array();


        return $data;
    }

    function _get_datatables_query() {

        //Join Table


        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->where_in('p.firm_id', $frim_id);

        $this->db->where('p.estatus !=', 0);


        $this->db->join($this->joinTable1, 'v.id=p.supplier');

        $this->db->join($this->joinTable2, 'pd.po_id=p.id');

        $this->db->join($this->joinTable3, 'f.firm_id=p.firm_id', 'left');

        $this->db->join($this->category, 'c.cat_id=p.po_cat_type','left',false);    

        // $this->db->group_by('p.id');

        $this->db->group_by('p.id');


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



        if (isset($_POST['order']) && $this->column_order[$_POST['order']['0']['column']] != null) { // here order processing
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

    public function get_company_details_by_firmid($firm_id) {

        $this->db->select('erp_manage_firms.*');

        $this->db->where('erp_manage_firms.firm_id', $firm_id);

        $query = $this->db->get('erp_manage_firms')->result_array();

        return $query;
    }

    public function check_duplicate_pr_id($input) {
        $this->db->select('*');
        $this->db->where('po_no', $input['value1']);
        $this->db->where('eStatus', 1);
        $query = $this->db->get('erp_po');
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    public function check_duplicate_pr_id_edit($input, $id) {
        $this->db->select('*');
        $this->db->where('po_no', $input);
        $this->db->where('id !=', $id);
        $this->db->where('eStatus', 1);
        $query = $this->db->get('erp_po')->result_array();


        return $query;
    }

}
