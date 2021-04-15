<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sales_man_model extends CI_Model {

    private $table_name = 'erp_sales_man';
    private $table_name1 = 'erp_manage_firms';

    //private $table_name1 = 'master_state';
    //private $table_name2 = 'customer_types';
    //private $table_name3 = 'reference_types';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insert_sales_man($data) {
        if ($this->db->insert($this->table_name, $data)) {
            return true;
        }
        return false;
    }

    function get_sales_man() {
        $this->db->select($this->table_name . '.*');
        $this->db->select('erp_manage_firms.firm_name');
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }
        $this->db->where_in($this->table_name . '.firm_id', $frim_id);
        $this->db->where($this->table_name . '.status', 1);
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=' . $this->table_name . '.firm_id');
        $query = $this->db->get($this->table_name)->result_array();
        return $query;
    }

    function get_sales_man_by_id($id) {
        $this->db->select($this->table_name . '.*');
        $this->db->select('erp_manage_firms.firm_name');
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }
        $this->db->where_in($this->table_name . '.firm_id', $frim_id);
        $this->db->where($this->table_name . '.status', 1);
        $this->db->where($this->table_name . '.id', $id);
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=' . $this->table_name . '.firm_id');
        $query = $this->db->get($this->table_name)->result_array();
        return $query;
    }

    function update_sales_man($data, $id) {

        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {

            return true;
        }
        return false;
    }

    function delete_sales_man($id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data = array('status' => 0))) {
            return true;
        }
        return false;
    }

    /* function insert_state($data) {
      if ($this->db->insert($this->table_name1, $data)) {
      $insert_id = $this->db->insert_id();

      return $insert_id;
      }
      return false;
      }

      function state() {
      $this->db->select('*');
      $this->db->where('status', 1);
      $query = $this->db->get($this->table_name1);
      if ($query->num_rows() > 0) {
      return $query->result_array();
      }
      return false;
      }

      function get_customer1($id) {
      $this->db->select($this->table_name . '.*');
      $this->db->select('master_state.state,master_state.id as m_s_id,st,cst,vat');
      $this->db->where($this->table_name . '.id', $id);
      $this->db->where($this->table_name . '.status', 1);
      $this->db->join('master_state', 'master_state.id=' . $this->table_name . '.state_id');
      $query = $this->db->get($this->table_name)->result_array();
      return $query;
      }/*





      /* function get_customer_types() {
      $this->db->select('*');
      $this->db->where('status', 1);
      $query = $this->db->get($this->table_name2);
      if ($query->num_rows() > 0) {
      return $query->result_array();
      }
      return false;
      }

      function get_reference_types() {
      $this->db->select('*');
      $this->db->where('status', 1);
      $query = $this->db->get($this->table_name3);
      if ($query->num_rows() > 0) {
      return $query->result_array();
      }
      return false;
      }

      function update_sales_man($data, $id) {

      $this->db->where('id', $id);
      if ($this->db->update($this->table_name, $data)) {

      return true;
      }
      return false;
      }


      function add_duplicate_email($input) {

      $this->db->select('*');
      $this->db->where('status', 1);
      $this->db->where('email_id', $input);
      $query = $this->db->get('customer');
      if ($query->num_rows() >= 1) {
      return $query->result_array();
      }
      }

      function update_duplicate_email($input, $id) {
      $this->db->select('*');
      $this->db->where('status', 1);
      $this->db->where('email_id', $input);
      $this->db->where('id !=', $id);
      $query = $this->db->get('customer')->result_array();
      return $query;
      }

      function get_customer_with_agent($id) {
      $this->db->select($this->table_name . '.*');
      $this->db->select('agent.name as agentname');
      $this->db->where($this->table_name . '.id', $id);
      $this->db->where($this->table_name . '.status', 1);
      $this->db->join('agent', 'agent.id=' . $this->table_name . '.agent_name');
      $query = $this->db->get($this->table_name)->result_array();
      return $query;
      } */
}
