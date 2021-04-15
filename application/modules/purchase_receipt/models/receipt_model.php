<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Receipt_model extends CI_Model {

    private $table_name1 = 'receipt';
    private $table_name2 = 'receipt_bill';
    private $erp_po = 'erp_po';
    private $vendor = 'vendor';
    private $erp_company_amount = 'erp_company_amount';
    private $erp_pr_details = 'erp_pr_details';

    function __construct() {
        parent::__construct();
    }

    public function check_so_no($po) {
        $this->db->select('receipt_no');
        $this->db->where('receipt_no', $po);
        $query = $this->db->get('receipt')->result_array();
        return $query;
    }

    public function insert_receipt($data) {
        if ($this->db->insert($this->table_name1, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function insert_receipt_bill($data) {
        if ($this->db->insert('purchase_receipt_bill', $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function get_company() {
        $this->db->select('*');
        $query = $this->db->get($this->vendor)->result_array();
        return $query;
    }

    public function insert_agent_amount($data) {
        if ($this->db->insert($this->erp_company_amount, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function get_all_receipt($serch_data = NULL) {

        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';


            if (!empty($serch_data['q_no']) && $serch_data['q_no'] != 'Select') {

                $this->db->where($this->erp_po . '.po_no', $serch_data['q_no']);
            }
            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {
                $this->db->where($this->vendor . '.id', $serch_data['customer']);
            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $this->db->select('erp_po.*');
        $this->db->select('vendor.store_name');
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }


        if (empty($serch_data)) {
            $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%m') = '" . date('m') . "'");
        }

        $this->db->where_in('erp_po.firm_id', $frim_id);
        $this->db->order_by('erp_po.id', 'desc');
        // $this->db->where('erp_po.pr_status =', 'approved');
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');
        $query = $this->db->get('erp_po')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date');
            $this->db->where('purchase_receipt_bill.receipt_id', $val['id']);
            $query[$i]['receipt_bill'] = $this->db->get('purchase_receipt_bill')->result_array();
            $i++;
        }

        return $query;
    }

    public function get_all_receipt_report($serch = NULL) {

        if ($serch != NULL && $serch != '') {
            $serch_data['q_no'] = $serch[0]->q_no;
            $serch_data['customer'] = $serch[1]->customer;
            $serch_data['from_date'] = $serch[2]->from;
            $serch_data['to_date'] = $serch[3]->to;
        }

        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';


            if (!empty($serch_data['q_no']) && $serch_data['q_no'] != 'Select') {

                $this->db->where($this->erp_po . '.po_no', $serch_data['q_no']);
            }
            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {
                $this->db->where($this->vendor . '.id', $serch_data['customer']);
            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $this->db->select('erp_po.*');
        $this->db->select('vendor.store_name');
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }


        if (empty($serch_data)) {
            $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%m') = '" . date('m') . "'");
        }

        $this->db->where_in('erp_po.firm_id', $frim_id);
        $this->db->order_by('erp_po.id', 'desc');
        // $this->db->where('erp_po.pr_status =', 'approved');
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');
        $query = $this->db->get('erp_po')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date');
            $this->db->where('purchase_receipt_bill.receipt_id', $val['id']);
            $query[$i]['receipt_bill'] = $this->db->get('purchase_receipt_bill')->result_array();
            $i++;
        }

        return $query;
    }

    public function get_all_receipt_based_pr_details($serch_data = NULL) {
        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';


            if (!empty($serch_data['q_no']) && $serch_data['q_no'] != 'Select') {

                $this->db->where($this->erp_pr . '.po_no', $serch_data['q_no']);
            }
            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {
                $this->db->where($this->vendor . '.id', $serch_data['customer']);
            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_pr . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_pr . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_pr . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }

        $this->db->select('erp_pr.*');
        $this->db->select('vendor.store_name');
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }
        $this->db->where_in('erp_pr.firm_id', $frim_id);
        $this->db->order_by('erp_pr.id', 'desc');
        $this->db->where('erp_pr.pr_status =', 'approved');
        $this->db->join('vendor', 'vendor.id=erp_pr.supplier');
        $query = $this->db->get('erp_pr')->result_array();
	//echo $this->db->last_query();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date');
            $this->db->where('purchase_receipt_bill.receipt_id', $val['id']);
            $query[$i]['receipt_bill'] = $this->db->get('purchase_receipt_bill')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_purchase_receipt($serch_data = NULL) {
        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';


            if (!empty($serch_data['q_no']) && $serch_data['q_no'] != 'Select') {

                $this->db->where($this->erp_po . '.po_no', $serch_data['q_no']);
            }
            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {
                $this->db->where($this->vendor . '.id', $serch_data['customer']);
            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $this->db->select('erp_po.*');
        $this->db->select('vendor.store_name');
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }
        $this->db->where_in('erp_po.firm_id', $frim_id);
        if (empty($serch_data)) {
            $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%m') = '" . date('m') . "'");
        }
        $this->db->order_by('erp_po.id', 'desc');
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');
        $query = $this->db->get('erp_po')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date');
            $this->db->where('purchase_receipt_bill.receipt_id', $val['id']);

            $query[$i]['receipt_bill'] = $this->db->get('purchase_receipt_bill')->result_array();
            $i++;
        }
        return $query;
    }

    function get_purchase_receipt_datatables($search_data) {

        $this->_get_purchase_receipt_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_po')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date');
            $this->db->where('purchase_receipt_bill.receipt_id', $val['id']);

            $query[$i]['receipt_bill'] = $this->db->get('purchase_receipt_bill')->result_array();
            $i++;
        }

        return $query;
    }

    function _get_purchase_receipt_datatables_query($serch_data = array()) {
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


            if (!empty($serch_data['q_no']) && $serch_data['q_no'] != 'Select') {

                $this->db->where($this->erp_po . '.po_no', $serch_data['q_no']);
            }
            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {
                $this->db->where($this->vendor . '.id', $serch_data['customer']);
            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $this->db->select('erp_po.*');
        $this->db->select('vendor.store_name');
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }
        $this->db->where_in('erp_po.firm_id', $frim_id);
        if (empty($serch_data)) {
            $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%m') = '" . date('m') . "'");
        }
        $this->db->order_by('erp_po.id', 'desc');
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');
    }

    function count_filtered_receipt() {
        $this->_get_purchase_receipt_datatables_query();
        $query = $this->db->get('erp_po');
        return $query->num_rows();
    }

    function count_all_receipt() {
        $this->_get_purchase_receipt_datatables_query();
        $this->db->from('erp_po');
        return $this->db->count_all_results();
    }

    public function get_receipt_total_amount($values) {
        /* $firms = $this->user_auth->get_user_firms();
          $frim_id = array();
          foreach ($firms as $value) {
          $frim_id[] = $value['firm_id'];
          } */
        $this->db->select('erp_po.*');
        $this->db->where_in('erp_po.firm_id', $values['firm']);
        $this->db->order_by('erp_po.id', 'desc');
        $query = $this->db->get('erp_po')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,due_date');
            $this->db->where('purchase_receipt_bill.receipt_id', $val['id']);
            if (isset($values) && !empty($values)) {
                if ($values['from'] != '') {
                    $this->db->where('purchase_receipt_bill.due_date >=', $values['from']);
                }
                if ($values['to'] != '') {
                    $this->db->where('purchase_receipt_bill.due_date <=', $values['to']);
                }
            }
            $query[$i]['receipt_bill'] = $this->db->get('purchase_receipt_bill')->result_array();
            //echo $this->db->last_query();
            $i++;
        }
        return $query;
    }

    public function get_receipt_total_amount_by_user_id($id, $values) {
        /* $firms = $this->sales_receipt_model->get_firm_by_user($id);
          $frim_id = array();
          foreach ($firms as $value) {
          $frim_id[] = $value['firm_id'];
          } */
        $this->db->select('erp_po.*');
        //$firms = $this->user_auth->get_user_firms();
        $this->db->where('erp_po.firm_id', $values['firm']);
        $this->db->order_by('erp_po.id', 'desc');
        $query = $this->db->get('erp_po')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,due_date');
            $this->db->where('purchase_receipt_bill.receipt_id', $val['id']);
            if (isset($values) && !empty($values)) {
                if ($values['from'] != '') {
                    $this->db->where('purchase_receipt_bill.due_date >=', $values['from']);
                }
                if ($values['to'] != '') {
                    $this->db->where('purchase_receipt_bill.due_date <=', $values['to']);
                }
            }
            $query[$i]['receipt_bill'] = $this->db->get('purchase_receipt_bill')->result_array();
            //echo $this->db->last_query();
            $i++;
        }
        return $query;
    }

    public function get_receipt_by_id($id) { //echo "<pre>";
        $this->db->where('erp_po.id', $id);
        $this->db->select('erp_po.*');
        $this->db->select('vendor.name,vendor.store_name, vendor.credit_days');
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');
        $query = $this->db->get('erp_po')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('purchase_receipt_bill.receipt_id', $val['id']);
            $query[$i]['receipt_history'] = $this->db->get('purchase_receipt_bill')->result_array();
            $j = 0;
            foreach ($query[$i]['receipt_history'] as $rep) {
                if ($rep['recevier'] != 'company') {
                    $this->db->select('name');
                    $this->db->where('id', $rep['recevier_id']);
                    $recevier = $this->db->get('agent')->result_array();
                    $query[$i]['receipt_history'][$j]['recevier'] = $recevier[0]['name'];
                }
                $j++;
            }
            $i++;
        }
        return $query;
    }

    public function get_receipt_based_on_pr_by_id($id) { //echo "<pre>";
        $this->db->where('erp_pr.id', $id);
        $this->db->select('erp_pr.*');
        $this->db->select('vendor.name,vendor.store_name, vendor.credit_days');
        $this->db->join('vendor', 'vendor.id=erp_pr.supplier');
        $query = $this->db->get('erp_pr')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('purchase_receipt_bill.receipt_id', $val['id']);
            $query[$i]['receipt_history'] = $this->db->get('purchase_receipt_bill')->result_array();
            $j = 0;
            foreach ($query[$i]['receipt_history'] as $rep) {
                if ($rep['recevier'] != 'company') {
                    $this->db->select('name');
                    $this->db->where('id', $rep['recevier_id']);
                    $recevier = $this->db->get('agent')->result_array();
                    $query[$i]['receipt_history'][$j]['recevier'] = $recevier[0]['name'];
                }
                $j++;
            }
            $i++;
        }
        return $query;
    }

    public function get_receipt_download_by_id($id, $rec_id) {//echo "<pre>";
        $this->db->where('erp_po.id', $id);
        $this->db->select('erp_po.*');
        $this->db->select('erp_manage_firms.firm_name');
        $this->db->select('vendor.name,vendor.store_name,vendor.email_id,vendor.mobil_number');
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_po.firm_id');
        $query = $this->db->get('erp_po')->result_array();
        $k = 0;
        foreach ($query as $val) {
            $this->db->where('erp_po_details.po_id', $id);
            $this->db->join('erp_product', 'erp_product.id=erp_po_details.product_id');
            $this->db->select('erp_po_details.*,erp_product.product_name');
            $query[$k]['po_details'] = $this->db->get('erp_po_details')->result_array();
            $k++;
        }
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('purchase_receipt_bill.id', $rec_id);
            $query[$i]['receipt_history'] = $this->db->get('purchase_receipt_bill')->result_array();
            $j = 0;
            foreach ($query[$i]['receipt_history'] as $rep) {
                if ($rep['recevier'] != 'company') {
                    $this->db->select('name');
                    $this->db->where('id', $rep['recevier_id']);
                    $recevier = $this->db->get('agent')->result_array();
                    $query[$i]['receipt_history'][$j]['recevier'] = $recevier[0]['name'];
                }
                $j++;
            }
            $i++;
        }
        return $query;
    }

    public function get_pr_receipt_download_by_id($id, $rec_id) {//echo "<pre>";
        $this->db->where('erp_pr.id', $id);
        $this->db->select('erp_pr.*');
        $this->db->select('erp_manage_firms.firm_name');
        $this->db->select('vendor.name,vendor.store_name,vendor.email_id,vendor.mobil_number');
        $this->db->join('vendor', 'vendor.id=erp_pr.supplier');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_pr.firm_id');
        $query = $this->db->get('erp_pr')->result_array();
        $k = 0;
        foreach ($query as $val) {
            $this->db->where('erp_pr_details.po_id', $id);
            $this->db->join('erp_product', 'erp_product.id=erp_pr_details.product_id');
            $this->db->select('erp_pr_details.*,erp_product.product_name');
            $query[$k]['po_details'] = $this->db->get('erp_pr_details')->result_array();
            $k++;
        }
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('purchase_receipt_bill.id', $rec_id);
            $query[$i]['receipt_history'] = $this->db->get('purchase_receipt_bill')->result_array();
            $j = 0;
            foreach ($query[$i]['receipt_history'] as $rep) {
                if ($rep['recevier'] != 'company') {
                    $this->db->select('name');
                    $this->db->where('id', $rep['recevier_id']);
                    $recevier = $this->db->get('agent')->result_array();
                    $query[$i]['receipt_history'][$j]['recevier'] = $recevier[0]['name'];
                }
                $j++;
            }
            $i++;
        }
        return $query;
    }

    public function get_po_details_id($id) {//echo "<pre>";
    }

    public function get_receipt_by_id_for_agent($data) {//echo "<pre>";
        $this->db->select('receipt.*');
        $this->db->where_in('receipt.id', $data);
        $this->db->select('customer.store_name,selling_percent');
        $this->db->select('agent.name as agent_name');
        $this->db->join('customer', 'customer.id=' . $this->table_name1 . '.customer_id');
        $this->db->join('agent', 'agent.id=' . $this->table_name1 . '.agent_id');
        $query = $this->db->get('receipt')->result_array();

        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('receipt_bill.receipt_id', $val['id']);
            $query[$i]['receipt_history'] = $this->db->get('receipt_bill')->result_array();

            $arr = explode('-', $val['inv_list']);

            $this->db->select('invoice.inv_no,invoice.id,inv_date,org_value,total_value');
            $this->db->where('customer.id', $val['customer_id']);
            $this->db->where_in('invoice.id', $arr);
            $this->db->join('package', 'package.id=invoice.package_id');
            $this->db->join('customer', 'customer.id=package.customer');
            $query[$i]['inv_details'] = $this->db->get('invoice')->result_array();



            $i++;
        }

        return $query;
    }

    public function update_invoice($data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update('erp_po', $data)) {

            return true;
        }
        return false;
    }

    public function update_invoice_status($data) {
        $this->db->where_in('id', $data);
        if ($this->db->update('invoice', array('receipt_status' => 1))) {

            return true;
        }
        return false;
    }

    public function update_receipt_id($no) {
        $this->db->where('type', 'rp_code');
        if ($this->db->update('increment_table', array('value' => $no))) {

            return true;
        }
        return false;
    }

    public function get_all_rp_no($data) {
        $this->db->select('receipt_no');
        $this->db->like('receipt_no', $data['q']);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get($this->table_name1)->result_array();
        return $query;
    }

    function checking_payment_checkno($input) {

        $this->db->select('*');
        $this->db->where('dd_no', $input);
        $query = $this->db->get('receipt_bill');

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    function update_checking_payment_checkno($input) {

        $this->db->select('*');
        $this->db->where('dd_no', $input);
        $query = $this->db->get('receipt_bill');

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    public function getpr_details_based_on_pr($id) {
        $this->db->select('erp_pr_details.*');
        $this->db->where($this->erp_pr_details . '.po_id', $id);
        return $this->db->get($this->erp_pr_details)->result_array();
    }

    public function update_pr_invoice($data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update('erp_pr', $data)) {

            return true;
        }
        return false;
    }

}
