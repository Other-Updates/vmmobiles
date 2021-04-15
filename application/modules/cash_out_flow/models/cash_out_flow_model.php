<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cash_out_flow_model extends CI_Model {

    private $cash_out_flow = 'erp_cash_out_flow';
    private $cash_out_flow_history = 'erp_cash_out_flow_history';

    function __construct() {
        parent::__construct();
    }

    public function insert_cash_out_flow($data) {
        if ($this->db->insert($this->cash_out_flow, $data)) {
            return true;
        }
        return false;
    }

    public function insert_cash_out_flow_history($data) {
        if ($this->db->insert($this->cash_out_flow_history, $data)) {
            return true;
        }
        return false;
    }

    public function update_cash_out_flow($data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update('erp_cash_out_flow', $data)) {

            return true;
        }
        return false;
    }

    public function cash_out_flow_delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->cash_out_flow);
    }

    public function get_all_cash_out_flow($serch_data = NULL) {

        if (isset($serch_data) && !empty($serch_data)) {
            if ($serch_data['from_date'] != '') {
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            }if ($serch_data['to_date'] != '') {
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            }
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';

            if (!empty($serch_data['firm_id']) && $serch_data['firm_id'] != '') {
                $this->db->where('erp_cash_out_flow.firm_id', $serch_data['firm_id']);
                $this->db->or_where('erp_cash_out_flow.sender_firm_id', $serch_data['firm_id']);
            }
            if (!empty($serch_data['user_name']) && $serch_data['user_name'] != 'Select') {
                $where = '(user_name="' . $serch_data['user_name'] . '" or sender_name = "' . $serch_data['user_name'] . '")';
                $this->db->where($where);
            }
            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != '' && isset($serch_data["to_date"]) && $serch_data["to_date"] != '') {

                $this->db->where("DATE_FORMAT(" . $this->cash_out_flow . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->cash_out_flow . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->cash_out_flow . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->cash_out_flow . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $this->db->select('erp_cash_out_flow.*,erp_manage_firms.firm_name');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_cash_out_flow.firm_id');
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        if (!empty($firms) && count($firms) > 0) {
            foreach ($firms as $value) {
                $frim_id[] = $value['firm_id'];
            }
        }
        if (empty($serch_data)) {
            $this->db->where_in('erp_cash_out_flow.firm_id', $frim_id);
            $this->db->or_where_in('erp_cash_out_flow.sender_firm_id', $frim_id);
        }
        $this->db->order_by('erp_cash_out_flow.id', 'desc');
        $query = $this->db->get('erp_cash_out_flow')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('erp_manage_firms.firm_name AS sender_firm_name');
            $this->db->where('erp_manage_firms.firm_id', $val['sender_firm_id']);
            $query[$i]['sender'] = $this->db->get('erp_manage_firms')->result_array();
            $i++;
        }
        return $query;
    }

    function get_datatables($search_data) {

        $this->_get_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_cash_out_flow')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('erp_manage_firms.firm_name AS sender_firm_name');
            $this->db->where('erp_manage_firms.firm_id', $val['sender_firm_id']);
            $query[$i]['sender'] = $this->db->get('erp_manage_firms')->result_array();
            $i++;
        }
        return $query;
    }

    function _get_datatables_query($search_data = array()) {
        $this->db->select('erp_cash_out_flow.*,erp_manage_firms.firm_name');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_cash_out_flow.firm_id');
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        if (!empty($firms) && count($firms) > 0) {
            foreach ($firms as $value) {
                $frim_id[] = $value['firm_id'];
            }
        }
        if (empty($serch_data)) {
            $this->db->where_in('erp_cash_out_flow.firm_id', $frim_id);
            $this->db->or_where_in('erp_cash_out_flow.sender_firm_id', $frim_id);
        }
        //$this->db->order_by('erp_cash_out_flow.id', 'desc');
        $column_order = array(null, 'erp_manage_firms.firm_name', 'erp_cash_out_flow.user_name', 'erp_manage_firms.firm_name', 'erp_cash_out_flow.sender_name', 'erp_cash_out_flow.cash_out', 'erp_cash_out_flow.cash_in', null, null);
        $column_search = array('erp_manage_firms.firm_name', 'erp_cash_out_flow.user_name', 'erp_cash_out_flow.sender_name', 'erp_cash_out_flow.cash_out', 'erp_cash_out_flow.cash_in');
        $order = array('erp_cash_out_flow.id' => 'desc');
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
        $this->db->from('erp_cash_out_flow');
        return $this->db->count_all_results();
    }

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get('erp_cash_out_flow');
        return $query->num_rows();
    }

    public function get_all_users($firm_id) {
        $this->db->select('erp_user.id,erp_user.name');
        $this->db->where('erp_user_firms.firm_id', $firm_id);
        $this->db->join('erp_user', 'erp_user.id=erp_user_firms.user_id');
        $query = $this->db->get('erp_user_firms');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_customers($firm_id) {
        $this->db->select('customer.id,customer.store_name As name');
        $this->db->where('customer.firm_id', $firm_id);
        $query = $this->db->get('customer');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_suppliers($firm_id) {
        $this->db->select('vendor.id,vendor.store_name As name');
        $this->db->where('vendor.firm_id', $firm_id);
        $query = $this->db->get('vendor');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_mobile_number($name) {
        $this->db->select('mobile_no As mobil_number');
        $this->db->where('name', $name);
        $query = $this->db->get('erp_user');
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {

            $this->db->select('mobil_number');
            $this->db->where('name', $name);
            $this->db->or_where('store_name', $name);
            $query1 = $this->db->get('customer');
            if ($query1->num_rows() >= 1) {
                return $query1->result_array();
            } else {
                $this->db->select('mobil_number');
                $this->db->where('name', $name);
                $this->db->or_where('store_name', $name);
                $query1 = $this->db->get('vendor');
                if ($query1->num_rows() >= 0) {
                    return $query1->result_array();
                }
            }
        }
        return false;
    }

    public function get_cash_out_flow_by_id($id) {
        $this->db->select('erp_cash_out_flow.*,erp_manage_firms.firm_name');
        $this->db->where('erp_cash_out_flow.id', $id);
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_cash_out_flow.firm_id');
        $query = $this->db->get('erp_cash_out_flow')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('erp_manage_firms.firm_name AS sender_firm_name');
            $this->db->where('erp_manage_firms.firm_id', $val['sender_firm_id']);
            $query[$i]['sender'] = $this->db->get('erp_manage_firms')->result_array();
            $i++;
        }
        $j = 0;
        foreach ($query as $val) {
            $this->db->select('erp_cash_out_flow_history.*');
            $this->db->where('erp_cash_out_flow_history.cash_out_id', $val['id']);
            $query[$j]['payment_history'] = $this->db->get('erp_cash_out_flow_history')->result_array();
            $j++;
        }
        return $query;
    }

    public function get_all_firms() {
        $this->db->select('firm_name,firm_id');
        $query = $this->db->get('erp_manage_firms');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_sales_man_by_firm($firm_id) {
        $this->db->select('erp_sales_man.id,erp_sales_man.sales_man_name as value');
        $this->db->where('erp_sales_man.firm_id', $firm_id);
        $this->db->where('erp_sales_man.status', 1);
        $query = $this->db->get('erp_sales_man');

        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

}
