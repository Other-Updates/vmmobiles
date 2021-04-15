<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Budget_model extends CI_Model {

    private $table_name4 = 'master_style';
    private $table_name5 = 'master_style_size';
    private $erp_budget = 'erp_budget';
    private $erp_budget_details = 'erp_budget_details';
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

    public function insert_budget($data) {
        if ($this->db->insert($this->erp_budget, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function insert_budget_details($data) {
        $this->db->insert_batch($this->erp_budget_details, $data);
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
        $this->db->where_not_in($this->customer . '.id', $atten_inputs['cust']);
        $query = $this->db->get($this->customer)->result_array();
        return $query;
    }

    public function get_customer_by_id($id) {
        $this->db->select('name,mobil_number,email_id,address1');
        $this->db->where($this->customer . '.id', $id);
        return $this->db->get($this->customer)->result_array();
    }

    public function get_product($atten_inputs, $id) {
        $this->db->select('id,model_no,product_name,product_description,product_image,type,cost_price,cgst,sgst');
        $this->db->where($this->erp_product . '.status', 1);
        $this->db->where($this->erp_product . '.category_id', $id);
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

    public function get_all_budget($serch_data = array()) {
        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';


            if (!empty($serch_data['vc_no']) && $serch_data['vc_no'] != 'Select') {

                $this->db->where($this->erp_budget . '.vc_no', $serch_data['vc_no']);
            }
            if (!empty($serch_data['supplier']) && $serch_data['supplier'] != 'Select') {
                $this->db->where($this->customer . '.store_name', $serch_data['supplier']);
            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_budget . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_budget . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_budget . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_budget . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $this->db->select('erp_budget.*,erp_manage_firms.firm_name');
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }
        $this->db->where_in('erp_budget.firm_id', $frim_id);
        $this->db->where('erp_budget.estatus !=', 0);
        // $this->db->join('customer', 'customer.id=erp_budget.customer_id');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_budget.firm_id', 'left');
        $this->db->order_by('erp_budget.id', 'desc');
        $query = $this->db->get('erp_budget');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_budget_by_id($id) {
        $this->db->select('erp_budget.*,erp_manage_firms.firm_name');
        $this->db->where('erp_budget.id', $id);
        // $this->db->join('customer', 'customer.id=erp_delivery_challan.customer', 'left');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_budget.firm_id', 'left');
        $query = $this->db->get('erp_budget');
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

    public function get_all_budget_details_by_id($id) {
        $this->db->select('erp_budget_details.*,erp_budget.*');
        $this->db->where('erp_budget_details.bd_id', $id);
        $this->db->join('erp_budget', 'erp_budget.id=erp_budget_details.bd_id', 'left');
        $query = $this->db->get('erp_budget_details')->result_array();

        $i = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid');
            $this->db->where('erp_invoice.customer', $val['customer_id']);
            $this->db->join('receipt_bill', 'receipt_bill.receipt_id=erp_invoice.id');
            $this->db->where('receipt_bill.created_date >=', $val['from_date']);
            $this->db->where('receipt_bill.created_date <=', $val['to_date']);
            $query[$i]['receipt_bill'] = $this->db->get('erp_invoice')->result_array();
            $i++;
        }
        return $query;
    }

    public function delete_budget_deteils_by_id($id) {
        $this->db->where('bd_id', $id);
        $this->db->delete($this->erp_budget_details);
    }

    public function update_budget($data, $id) {
        $this->db->where($this->erp_budget . '.id', $id);
        if ($this->db->update($this->erp_budget, $data)) {
            return true;
        }
        return false;
    }

    public function budget_delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->erp_budget);
    }

    public function delete_id($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->erp_budget_details);
    }

}
