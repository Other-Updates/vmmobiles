<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Admin_model
 *
 * This model represents admin access. It operates the following tables:
 * admin,
 *
 * @package	i2_soft
 * @author	Elavarasan
 */
class Product_model extends CI_Model {

    private $table_name = 'erp_product';
    private $increment_table = 'increment_table';

    function __construct() {
        parent::__construct();
    }

    public function insert_product($data) {
        if ($this->db->insert($this->table_name, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return false;
    }

    public function update_increment($data) {
        $this->db->where($this->increment_table . '.id', 13);
        if ($this->db->update($this->increment_table, $data)) {
            return true;
        }
        return false;
    }

    public function get_product() {
        $this->db->select($this->table_name . '.*, erp_brand.brands');
        $this->db->join('erp_brand', 'erp_brand.id=erp_product.brand_id');
        $query = $this->db->get($this->table_name)->result_array();
        return $query;
    }

    public function get_product_by_id($id) {
        $this->db->select($this->table_name . '.*');
        $this->db->where($this->table_name . '.id', $id);
        $query = $this->db->get($this->table_name)->result_array();
        return $query;
    }

    public function update_product($data, $id) {

        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {
            return true;
        }
        return false;
    }

    public function delete_product($id) {
        $this->db->where('id', $id);
        if ($this->db->delete('erp_product')) {
            return true;
        }
        return false;
    }

    function add_duplicate_product($input) {
        $this->db->select('*');
        $this->db->where('model_no', $input);
        $this->db->where('status', 1);
        $query = $this->db->get('erp_product');

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    function update_duplicate_product($input, $id) {
        //echo $input;
        //echo $id;
        //exit;
        $this->db->select('*');
        $this->db->where('model_no', $input);
        $this->db->where('id !=', $id);
        $this->db->where('status', 1);
        $query = $this->db->get('erp_product')->result_array();


        return $query;
    }

    public function product_list($term) {
        $this->db->select('id,product_name');
        $this->db->like('product_name', $term);
        $query = $this->db->get($this->table_name)->result_array();
        return $query;
    }

}
