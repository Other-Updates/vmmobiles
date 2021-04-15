<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer_model extends CI_Model {

    private $table_name = 'customer';
    private $table_name1 = 'master_state';
    private $table_name2 = 'customer_types';
    private $street = 'master_street';
    private $vendor = 'vendor';
    var $joinTable1 = 'erp_manage_firms r';
    var $primaryTable = 'customer u';
    var $selectColumn = 'u.id,u.store_name,u.name,u.customer_type,u.email_id,u.mobil_number,u.address1,u.city,r.firm_name';
    var $column_order = array(null, 'u.store_name', 'r.firm_name', 'u.address1', 'u.email_id', null); //set column field database for datatable orderable
    var $column_search = array('u.store_name', 'r.firm_name', 'u.address1', 'u.email_id'); //set column field database for datatable searchable
    var $order = array('u.id' => 'DESC'); // default order

    function __construct() {

        parent::__construct();

        $this->load->database();
    }

    function getfirm_id_based_on_firm_name($firm_name) {

        $this->db->select('firm_id');

        $this->db->where('firm_name', $firm_name);

        $this->db->where('status', 1);

        $query = $this->db->get('erp_manage_firms');



        if ($query->num_rows() >= 1) {

            return $query->result_array();
        }
    }

    function get_firm_name($id) {
        $this->db->where('firm_id', $id);
        $data = $this->db->get('erp_manage_firms')->result_array();
        return $data[0]['firm_name'];
    }

    function insert_customer($data) {

        if ($this->db->insert($this->table_name, $data)) {

            $insert_id = $this->db->insert_id();



            return $insert_id;
        }

        return false;
    }

    function insert_state($data) {

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

    function get_all_street() {

        $this->db->select('street_name');

        $this->db->distinct('street_name');

        $query = $this->db->get($this->table_name);

        if ($query->num_rows() > 0) {

            return $query->result_array();
        }

        return false;
    }

    function get_customer1($id) {

        $this->db->select($this->table_name . '.*');

        $this->db->select('master_state.state,master_state.id as m_s_id,st,cst,vat,credit_days,credit_limit,advance');

        $this->db->where($this->table_name . '.id', $id);

        $this->db->where($this->table_name . '.status', 1);

        $this->db->join('master_state', 'master_state.id=' . $this->table_name . '.state_id', 'LEFT');

        $query = $this->db->get($this->table_name)->result_array();

        return $query;
    }

    function get_customer() {

        $this->db->select($this->table_name . '.*');

        $this->db->select('master_state.state');

        $this->db->select('erp_manage_firms.firm_name');

        $this->db->where($this->table_name . '.status', 1);



        $this->db->join('master_state', 'master_state.id=' . $this->table_name . '.state_id', 'LEFT');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=' . $this->table_name . '.firm_id', 'LEFT');


        $query = $this->db->get($this->table_name)->result_array();

        return $query;
    }

    function update_customer($data, $id) {



        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name)) {
            return true;
        }



        return false;
    }

    function delete_customer($id) {

        $this->db->where('id', $id);

        if ($this->db->update($this->table_name, $data = array('status' => 0))) {

            return true;
        }

        return false;
    }

    function add_duplicate_email($input) {



        $this->db->select('*');

        $this->db->where('status', 1);

        $this->db->where('email_id', $input['email']);

        $this->db->where('firm_id', $input['firm_id']);

        $query = $this->db->get('customer');

        if ($query->num_rows() >= 1) {

            return $query->result_array();
        }
    }

    public function check_duplicate_email($input) {
        $this->db->select('*');

        $this->db->where('status', 1);

        $this->db->where('email_id', $input['email']);

        $this->db->where('firm_id', $input['firm_id']);

        $query = $this->db->get('customer');

        if ($query->num_rows() > 0) {

            return $query->result_array();
        }
    }

    public function check_duplicate_mobile_num($input) {
        $this->db->select('*');

        $this->db->where('status', 1);

        $this->db->where('mobil_number', $input['number']);

        $this->db->where('firm_id', $input['firm_id']);

        $query = $this->db->get('customer');

        if ($query->num_rows() > 0) {

            return $query->result_array();
        }
    }

    function add_duplicate_mobile($input) {



        $this->db->select('*');

        $this->db->where('status', 1);

        $this->db->where('mobil_number', $input['number']);

        $this->db->where('firm_id', $input['firm_id']);

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

    function update_duplicate_mobile($input, $id) {

        $this->db->select('*');

        $this->db->where('status', 1);

        $this->db->where('mobil_number', $input);

        $this->db->where('id !=', $id);

        $query = $this->db->get('customer')->result_array();

        return $query;
    }

    function get_customer_by_id($id) {

        $this->db->select($this->table_name . '.store_name');

        $this->db->where($this->table_name . '.id', $id);

        $query = $this->db->get($this->table_name)->result_array();

        return $query;
    }

    function get_customer_with_agent($id) {

        $this->db->select($this->table_name . '.*');

        $this->db->select('agent.name as agentname');

        $this->db->where($this->table_name . '.id', $id);

        $this->db->where($this->table_name . '.status', 1);

        $this->db->join('agent', 'agent.id=' . $this->table_name . '.agent_name', 'LEFT');

        $query = $this->db->get($this->table_name)->result_array();

        return $query;
    }

    function is_customer_name_exist($store_name, $frim, $mobile) {

        $this->db->select($this->table_name . '.id');

        $this->db->where('LCASE(store_name)', strtolower($store_name));

        $this->db->where($this->table_name . '.status', 1);

        $this->db->where($this->table_name . '.mobil_number', $mobile);

        if (!empty($frim))
            $this->db->where_not_in($this->table_name . '.firm_id', $frim);

        $query = $this->db->get($this->table_name);

        if ($query->num_rows() > 0) {

            $result = $query->row_array();

            return $result['id'];
        }

        return NULL;
    }

    function is_supplier_name_exist($store_name, $frim) {

        $this->db->select($this->vendor . '.id');

        $this->db->where('LCASE(store_name)', strtolower($store_name));

        $this->db->where($this->vendor . '.status', 1);

        if (!empty($frim))
            $this->db->where_not_in($this->vendor . '.firm_id', $frim);

        $query = $this->db->get($this->vendor);

        if ($query->num_rows() > 0) {

            $result = $query->row_array();

            return $result['id'];
        }

        return NULL;
    }

    function insert_supplier($data) {

        if ($this->db->insert($this->vendor, $data)) {

            return true;
        }

        return false;
    }

    function update_supplierr($data, $id) {

        $this->db->where('id', $id);

        if ($this->db->update($this->vendor, $data)) {



            return true;
        }

        return false;
    }

    function get_con_customer_list() {

        $types = array('3', '4');

        $this->db->select($this->table_name . '.id,store_name');

        $this->db->where($this->table_name . '.status', 1);

        $this->db->where_in($this->table_name . '.customer_type', $types);

        $query = $this->db->get($this->table_name);

        if ($query->num_rows() > 0) {

            return $query->result_array();
        }

        return NULL;
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

        $query = $this->db->get();

        return $query->num_rows();
    }

    function count_all() {

        $this->db->from($this->primaryTable);

        return $this->db->count_all_results();
    }

    function get_customer_name_by_id($id) {

        $this->db->select($this->table_name . '.id,name');

        $this->db->where($this->table_name . '.status', 1);

        $this->db->where($this->table_name . '.id', $id);

        $query = $this->db->get($this->table_name);

        if ($query->num_rows() > 0) {

            return $query->result_array();
        }

        return NULL;
    }

    function count_local_customers($monthly = 0, $month = NULL) {

        $types = array('local');

        $this->db->select('*');

        $this->db->where($this->table_name . '.status', 1);

        $this->db->where_in($this->table_name . '.customer_region', $types);

        if ($monthly == 1 && $month != NULL) {

            $this->db->where("DATE_FORMAT(created_date,'%m')", $month);
        }

        $query = $this->db->get($this->table_name);

        if ($query->num_rows() > 0) {

            return $query->num_rows();
        }

        return NULL;
    }

    function count_non_local_customers($monthly = 0, $month = NULL) {

        $types = array('non-local');

        $this->db->select('*');

        $this->db->where($this->table_name . '.status', 1);

        $this->db->where_in($this->table_name . '.customer_region', $types);

        if ($monthly == 1 && $month != NULL) {

            $this->db->where("DATE_FORMAT(created_date,'%m')", $month);
        }

        $query = $this->db->get($this->table_name);

        if ($query->num_rows() > 0) {

            return $query->num_rows();
        }

        return NULL;
    }

}
