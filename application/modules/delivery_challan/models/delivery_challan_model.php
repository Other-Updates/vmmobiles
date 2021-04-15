<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Delivery_challan_model extends CI_Model {

    private $table_name4 = 'master_style';
    private $table_name5 = 'master_style_size';
    private $erp_delivery_challan = 'erp_delivery_challan';
    private $erp_delivery_challan_details = 'erp_delivery_challan_details';
    private $increment_table = 'increment_table';
    private $erp_product = 'erp_product';
    private $erp_user = 'erp_user';
    private $erp_stock = 'erp_stock';
    private $erp_stock_history = 'erp_stock_history';
    private $customer = 'customer';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert_dc($data) {
        if ($this->db->insert($this->erp_delivery_challan, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function insert_dc_details($data) {
        $this->db->insert_batch($this->erp_delivery_challan_details, $data);
        return true;
    }

    public function update_increment($id) {
        $this->db->where($this->increment_table . '.id', 4);
        if ($this->db->update($this->increment_table, $id)) {
            return true;
        }
        return false;
    }

    public function get_customer($atten_inputs, $id) {
        $this->db->select('name,id,mobil_number,email_id,address1,store_name,tin');
        $this->db->where($this->customer . '.status', 1);
        $this->db->where($this->customer . '.firm_id', $id);
        $this->db->like($this->customer . '.store_name', $atten_inputs['q']);
        $query = $this->db->get($this->customer)->result_array();
        return $query;
    }

    public function get_customer_by_id($id) {
        $this->db->select('name,mobil_number,email_id,address1');
        $this->db->where($this->customer . '.id', $id);
        return $this->db->get($this->customer)->result_array();
    }

    public function get_product($atten_inputs, $id) {
        $this->db->select('id,model_no,product_name,product_description,product_image,type,cost_price,cgst,sgst,category_id');
        $this->db->where($this->erp_product . '.status', 1);
        if ($id != '')
            $this->db->where($this->erp_product . '.firm_id', $id);
        //$this->db->where($this->erp_product . '.category_id', $id);
        $this->db->where($this->erp_product . '.type', 1);
        $this->db->like($this->erp_product . '.product_name', $atten_inputs['q']);
        $query = $this->db->get($this->erp_product)->result_array();
        return $query;
    }

    public function get_product_by_id($id) {
        $this->db->select('model_no,product_name,product_description,product_image');
        $this->db->where($this->erp_product . '.id', $id);
        return $this->db->get($this->erp_product)->result_array();
    }

    public function get_all_dc($serch_data = array()) {
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

                $this->db->where($this->erp_delivery_challan . '.po_no', $serch_data['po_no']);
            }
            if (!empty($serch_data['supplier']) && $serch_data['supplier'] != 'Select') {
                $this->db->where($this->customer . '.store_name', $serch_data['supplier']);
            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_delivery_challan . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_delivery_challan . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_delivery_challan . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_delivery_challan . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $this->db->select('customer.id as customer,customer.store_name,customer.state_id,customer.tin,customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_delivery_challan.id,erp_delivery_challan.dc_no,erp_delivery_challan.total_qty,erp_delivery_challan.tax,erp_delivery_challan.tax_label,'
                . 'erp_delivery_challan.net_total,erp_delivery_challan.remarks,erp_delivery_challan.subtotal_qty,erp_delivery_challan.estatus,erp_delivery_challan.created_date,erp_delivery_challan.firm_id,erp_manage_firms.firm_name');
        $this->db->select('erp_manage_firms.firm_name');
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }
        $this->db->where_in('erp_delivery_challan.firm_id', $frim_id);
        $this->db->where('erp_delivery_challan.estatus !=', 0);
        $this->db->join('customer', 'customer.id=erp_delivery_challan.customer');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_delivery_challan.firm_id', 'left');
        $query = $this->db->get('erp_delivery_challan');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_dc_by_id($id) {
        $this->db->select('customer.id as customer,customer.store_name,customer.state_id,customer.tin,customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.*,erp_manage_firms.firm_name');
        //$this->db->where('erp_delivery_challan.estatus',1);
        $this->db->where('erp_invoice.id', $id);
        $this->db->join('customer', 'customer.id=erp_invoice.customer', 'left');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_invoice.firm_id', 'left');
        $query = $this->db->get('erp_invoice');

        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }

        return false;
    }

    public function get_all_product_by_id($id) {
        $this->db->select('erp_product.id,erp_product.model_no,erp_product.product_name,erp_product.product_image,'
                . 'erp_delivery_challan_details.product_description');
        $this->db->where('erp_delivery_challan_details.id', $id);
        $this->db->join('erp_po', 'erp_po.id=erp_delivery_challan_details.dc_id');
        $this->db->join('erp_product', 'erp_product.id=erp_delivery_challan_details.product_id');
        $query = $this->db->get('erp_delivery_challan_details');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_dc_details_by_id($id) {
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,'
                . 'erp_invoice_details.*');
        $this->db->where('erp_invoice_details.in_id', $id);
        // $this->db->join('erp_invoice', 'erp_invoice.id=erp_invoice_details.inv_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_invoice_details.category');
        $this->db->join('erp_product', 'erp_product.id=erp_invoice_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_invoice_details.brand', 'LEFT');

        $query = $this->db->get('erp_invoice_details');

        if ($query->num_rows() >= 0) {
            return $query->result_array();
            // echo"<pre>"; print_r($query->result_array()); exit;
        }
        return false;
    }

    public function delete_dc_deteils_by_id($id) {
        $this->db->where('dc_id', $id);
        $this->db->delete($this->erp_delivery_challan_details);
    }

    public function update_dc($data, $id) {
        $this->db->where('erp_invoice' . '.id', $id);
        if ($this->db->update('erp_invoice', $data)) {
            return true;
        }
        return false;
    }

    public function update_dc_details($data, $id) {
        $this->db->where('erp_invoice_details' . '.id', $id);
        if ($this->db->update('erp_invoice_details', $data)) {
            return true;
        }
        return false;
    }

    public function delete_dc($id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->erp_delivery_challan, $data = array('estatus' => 0))) {
            return true;
        }
        return false;
    }

    public function delete_id($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->erp_delivery_challan_details);
    }

    public function get_all_invoice() {

        $this->db->select('customer.id as customer,customer.store_name,customer.state_id,customer.tin,customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.*,erp_manage_firms.firm_name');
        $this->db->select('erp_manage_firms.firm_name');
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }
        $this->db->where_in('erp_invoice.firm_id', $frim_id);
        $this->db->where('erp_invoice.estatus !=', 0);
        $this->db->where("erp_invoice.inv_id !=", 'Wings Invoice');
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_invoice.firm_id', 'left');
        $this->db->order_by('erp_invoice.id', 'desc');
        $query = $this->db->get('erp_invoice');

        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function change_del_status($id, $status) {
        $this->db->where('erp_invoice.id', $id);
        if ($this->db->update('erp_invoice', array('delivery_status' => $status))) {
            return true;
        }
        return false;
    }

    function get_datatables($search_data) {

        $this->_get_datatables_query();

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get('erp_invoice');


        return $query->result();
    }

    function _get_datatables_query($search_data = array()) {
        $this->db->select('customer.id as customer,customer.store_name,customer.state_id,customer.tin,customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.*,erp_manage_firms.firm_name');
        $this->db->select('erp_manage_firms.firm_name');
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }
        $this->db->where_in('erp_invoice.firm_id', $frim_id);
        $this->db->where('erp_invoice.estatus !=', 0);
        $this->db->where("erp_invoice.inv_id !=", 'Wings Invoice');
        $this->db->join('customer', 'customer.id=erp_invoice.customer', 'left');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_invoice.firm_id', 'left');
        // $this->db->order_by('erp_invoice.id', 'desc');

        $column_order = array(null,
            'erp_manage_firms.firm_name',
            'erp_invoice.inv_id',
            'customer.store_name',
            'erp_invoice.total_qty',
            'erp_invoice.delivery_qty',
            'erp_invoice.net_total');
        $column_search = array('erp_manage_firms.firm_name',
            'erp_invoice.inv_id',
            'customer.store_name',
            'erp_invoice.total_qty',
            'erp_invoice.delivery_qty',
            'erp_invoice.net_total'
        );
        $order = array('erp_invoice.id' => 'desc');
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

    function count_all() {
        $this->db->from('erp_invoice');
        return $this->db->count_all_results();
    }

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get('erp_invoice');
        return $query->num_rows();
    }

}
