<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sku_management_model extends CI_Model {

    private $table_name1 = 'erp_sku_management';
    private $table_name2 = 'erp_sku_details';
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
    private $erp_invoice = 'erp_invoice';
    private $erp_stock = 'erp_stock';
    private $erp_stock_history = 'erp_stock_history';
    private $erp_po = 'erp_po';
    private $erp_po_details = 'erp_po_details';
    private $erp_email_settings = 'erp_email_settings';
    private $receipt_bill = 'receipt_bill';

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
        $this->db->where($this->increment_table . '.type', $id['type']);
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

    public function get_customer($atten_inputs) {
        $this->db->select('name,id,mobil_number,email_id,address1');
        $this->db->where($this->customer . '.status', 1);
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

    function get_all_sku_management() {
        $this->db->select($this->table_name1 . '.*');
        $this->db->select('erp_manage_firms.firm_name');
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }
        $this->db->where_in($this->table_name1 . '.firm_id', $frim_id);
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=.' . $this->table_name1 . '.firm_id', 'left');
        $this->db->where($this->table_name1 . '.status', 1);
        $query = $this->db->get($this->table_name1)->result_array();
        return $query;
    }

    function get_sku_by_id($id) {
        $this->db->select($this->table_name1 . '.*');
        $this->db->select('erp_manage_firms.firm_name');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=.' . $this->table_name1 . '.firm_id', 'left');
        $this->db->where($this->table_name1 . '.id', $id);
        $this->db->where($this->table_name1 . '.status', 1);
        $query = $this->db->get($this->table_name1)->result_array();
        return $query;
    }

    public function get_sku_details_by_id($id) {
        $this->db->select($this->table_name2 . '.*');
//	$this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,'
//		. 'erp_po_details.category,erp_po_details.product_id,erp_po_details.brand,erp_po_details.quantity,'
//		. 'erp_po_details.per_cost,erp_po_details.tax,erp_po_details.gst,erp_po_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,'
//		. 'erp_po_details.product_description');
        $this->db->select('erp_category.cat_id,erp_category.categoryName');
        $this->db->select('erp_product.id,erp_product.product_name');
        $this->db->select('erp_brand.id,erp_brand.brands');
        $this->db->where($this->table_name2 . '.sku_id', $id);
        $this->db->join('erp_category', 'erp_category.cat_id=.' . $this->table_name2 . '.cat_id');
        $this->db->join('erp_product', 'erp_product.id=.' . $this->table_name2 . '.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=.' . $this->table_name2 . '.brand_id', 'LEFT');

        $query = $this->db->get($this->table_name2);

        if ($query->num_rows() >= 0) {
            return $query->result_array();
            // echo"<pre>"; print_r($query->result_array()); exit;
        }
        return false;
    }

    public function update_sku($data, $id) {
        $this->db->where($this->table_name1 . '.id', $id);
        if ($this->db->update($this->table_name1, $data)) {
            return true;
        }
        return false;
    }

    public function delete_sku_details($id) {
        $this->db->where('sku_id', $id);
        $this->db->delete($this->table_name2);
    }

    public function delete_sku($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name1);
    }

    function get_stock_by_product($cat_id, $pro_id) {
        $this->db->select('SUM(quantity) as stock');
        $this->db->where('category', $cat_id);
        $this->db->where('product_id', $pro_id);
        $query = $this->db->get('erp_stock')->result_array();
        return $query;
    }

    public function insert_sku($data) {
        if ($this->db->insert($this->table_name1, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function insert_sku_details($data) {
        $this->db->insert_batch($this->table_name2, $data);
        return true;
    }

}
