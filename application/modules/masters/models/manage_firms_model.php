<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Manage_firms_model extends CI_Model {



    private $table_name = 'erp_manage_firms';



    function __construct() {

        parent::__construct();

        $this->load->database();

    }



    public function insert_firm($data) {

        if ($this->db->insert($this->table_name, $data)) {

            $insert_id = $this->db->insert_id();

            return $insert_id;

        }

        return false;

    }



    public function get_all_firms() {

        $this->db->select($this->table_name . '.*');


          $firms = $this->user_auth->get_user_firms();

         $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

       // $this->db->where_in('u.firm_id', $frim_id);

         $this->db->where_in($this->table_name . '.firm_id', $frim_id);

        $this->db->order_by($this->table_name . '.firm_id', 'ASC');

        $query = $this->db->get($this->table_name)->result_array();

        return $query;

    }



    public function getallfirms() {

        $this->db->select($this->table_name . '.*');


     

       // $this->db->where_in('u.firm_id', $frim_id);

        // $this->db->where_in($this->table_name . '.firm_id', $frim_id);

        $this->db->order_by($this->table_name . '.firm_id', 'ASC');

        $query = $this->db->get($this->table_name)->result_array();

        return $query;

    }



    public function get_firm_by_id($id) {

        $this->db->select($this->table_name . '.*');

        $this->db->where($this->table_name . '.firm_id', $id);

        $query = $this->db->get($this->table_name)->result_array();

        return $query;

    }



    public function update_firm($data, $id) {

        $this->db->where('firm_id', $id);

        if ($this->db->update($this->table_name, $data)) {

            return true;

        }

        return false;

    }



    public function delete_firm($id) {

        $this->db->where('firm_id', $id);

        if ($this->db->delete('erp_manage_firms')) {

            return true;

        }

        return false;

    }



    function add_duplicate_firm($input) {

        $this->db->select('*');

        $this->db->where('firm_name', $input);

        $this->db->where('status', 1);

        $query = $this->db->get('erp_manage_firms');



        if ($query->num_rows() >= 1) {

            return $query->result_array();

        }

    }



    function update_duplicate_firm($input, $id) {

        $this->db->select('*');

        $this->db->where('firm_name', $input);

        $this->db->where('firm_id !=', $id);

        $this->db->where('status', 1);

        $query = $this->db->get('erp_manage_firms')->result_array();

        return $query;

    }





}

