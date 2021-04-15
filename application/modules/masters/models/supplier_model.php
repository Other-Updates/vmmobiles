<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supplier_model extends CI_Model {

    private $table_name = 'vendor';
    private $table_name1 = 'master_state';
    var $joinTable1 = 'erp_manage_firms r';
    var $primaryTable = 'vendor u';
    var $selectColumn = 'u.id,u.store_name,u.name,u.mobil_number,u.email_id,u.address1,u.city,r.firm_name,u.firm_id,u.tin';
    var $column_order = array(null, 'u.store_name', 'r.firm_name', 'u.address1', 'u.email_id', 'u.city', null); //set column field database for datatable orderable
    var $column_search = array('u.store_name', 'r.firm_name', 'u.address1', 'u.email_id', 'u.city', 'u.mobil_number'); //set column field database for datatable searchable
    var $order = array('u.id' => 'DESC'); // default order

    function __construct() {

        parent::__construct();

        $this->load->database();
    }

    function insert_vendor($data) {



        if ($this->db->insert($this->table_name, $data)) {

            return true;
        }

        return false;
    }

    function get_state_id($state) {



        $this->db->select('id');

        $this->db->where('status', 1);

        $this->db->where('LCASE(state)', strtolower($state));

        $query = $this->db->get('master_state');

        if ($query->num_rows() > 0) {

            $query = $query->result_array();

            return $query[0]['id'];
        }

        return NULL;
    }

    function is_supplier_name_exist($store_name, $frim) {

        $this->db->select($this->table_name . '.id');

        $this->db->where('LCASE(store_name)', strtolower($store_name));

        $this->db->where($this->table_name . '.status', 1);

        if (!empty($frim))
            $this->db->where_not_in($this->table_name . '.firm_id', $frim);

        $query = $this->db->get($this->table_name);

        if ($query->num_rows() > 0) {

            $result = $query->row_array();

            return $result['id'];
        }

        return NULL;
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

    function get_vendor1($id) {

        $this->db->select($this->table_name . '.*');

        $this->db->select('master_state.state');

        $this->db->where($this->table_name . '.id', $id);

        $this->db->where($this->table_name . '.status', 1);

        $this->db->join('master_state', 'master_state.id=' . $this->table_name . '.state_id', 'LEFT');

        $query = $this->db->get($this->table_name)->result_array();

        return $query;
    }

    function get_vendor() {

        $this->db->select($this->table_name . '.*');

        $this->db->select('master_state.state');

        $this->db->select('erp_manage_firms.firm_name');

        $this->db->where($this->table_name . '.status', 1);

        $this->db->join('master_state', 'master_state.id=' . $this->table_name . '.state_id', 'LEFT');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=' . $this->table_name . '.firm_id', 'LEFT');

        $query = $this->db->get($this->table_name)->result_array();

//print_r($query);
//exit;

        return $query;
    }

    function update_vendor($data, $id) {



        // $this->db->where('id', $id);
        //if ($this->db->update($this->table_name, $data)) {
        //     return true;
        // }



        $this->db->where('id', $id);

        $this->db->set($data);

        $result = $this->db->update($this->table_name);

        if ($result) {

            return true;
        }



        return false;
    }

    function delete_vendor($id) {

        $this->db->where('id', $id);

        if ($this->db->update($this->table_name, $data = array('status' => 0))) {

            return true;
        }

        return false;
    }

    function add_duplicate_mail($input) {



        $this->db->select('*');

        $this->db->where('status', 1);

        $this->db->where('email_id', $input);

        $query = $this->db->get(' vendor');

        if ($query->num_rows() >= 1) {

            return $query->result_array();
        }
    }

    function add_duplicate_land($input) {



        $this->db->select('*');

        $this->db->where('status', 1);

        $this->db->where('landline', $input);

        $query = $this->db->get('vendor');

        if ($query->num_rows() >= 1) {

            return $query->result_array();
        }
    }

    function update_duplicate_mail($input, $id) {

        $this->db->select('*');

        $this->db->where('status', 1);

        $this->db->where('email_id', $input);

        $this->db->where('id !=', $id);

        $query = $this->db->get('vendor')->result_array();

        return $query;
    }

    function update_duplicate_land($input, $id) {

        $this->db->select('*');

        $this->db->where('status', 1);

        $this->db->where('landline', $input);

        $this->db->where('id !=', $id);

        $query = $this->db->get('vendor')->result_array();

        return $query;
    }

    function _get_datatables_query() {

        //Join Table

        $this->db->join($this->joinTable1, 'r.firm_id=u.firm_id');

        $this->db->where('u.status', 1);

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $new = implode(" , ", $frim_id);

        $this->db->where_in('u.firm_id', $frim_id);

        $this->db->from($this->primaryTable);

        $i = 0;

        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $like = "" . $item . " LIKE '%" . $_POST['search']['value'] . "%'";

                    // $this->db->like($item, $_POST['search']['value']);
                } else {

                    //   $query = $this->db->or_like($item, $_POST['search']['value']);

                    $like .= " OR " . $item . " LIKE '%" . $_POST['search']['value'] . "%'";
                }
            }

            $i++;
        }

        if ($like) {

            $where = "u.firm_id IN (" . $new . ") AND (" . $like . ")";

            $this->db->where($where);
        }

        if (isset($_POST['order']) && $this->column_order[$_POST['order']['0']['column']] != null) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables() {

        $this->db->select($this->selectColumn);

        $this->_get_datatables_query();

        $firms = $this->user_auth->get_user_firms();

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();
    }

    function count_filtered() {

        $this->_get_datatables_query();

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        // print_r($frim_id);
        //  exit;

        $this->db->where_in('u.firm_id', $frim_id);

        $query = $this->db->get();

        return $query->num_rows();
    }

    function count_all() {

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->where_in('u.firm_id', $frim_id);

        $this->db->from($this->primaryTable);

        return $this->db->count_all_results();
    }

}
