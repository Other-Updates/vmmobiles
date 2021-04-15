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
class Receipt_model extends CI_Model {

    private $table_name1 = 'receipt';
    private $table_name2 = 'receipt_bill';
    private $increment_table = 'increment_table';
    private $erp_company_amount = 'erp_company_amount';

    /* private $table_name3	= 'customer';
      private $table_name4	= 'master_style';
      private $table_name5	= 'master_style_size';
      private $table_name6	= 'vendor';
      private $table_name7	= 'package';
      private $table_name8	= 'package_details'; */

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

    public function insert_agent_amount($data) {
        if ($this->db->insert($this->erp_company_amount, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function update_agent_amount($data, $id) {
        $this->db->where($this->erp_company_amount . '.receipt_id', $id);
        if ($this->db->update($this->erp_company_amount, $data)) {
            return true;
        }
        return false;
    }

    public function insert_receipt_bill($data) {
        if ($this->db->insert($this->table_name2, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function update_increment($id) {
        $this->db->where($this->increment_table . '.id', 8);
        if ($this->db->update($this->increment_table, $id)) {
            return true;
        }
        return false;
    }

    public function get_all_amount($serch_data = NULL) {
        $this->db->select('erp_company_amount.*,agent.name,receipt_bill.receipt_no,erp_quotation.job_id');
        $this->db->where($this->erp_company_amount . '.recevier', 1);
        $this->db->join('agent', 'agent.id=erp_company_amount.recevier_id', 'left');
        $this->db->join('receipt_bill', 'receipt_bill.id=erp_company_amount.receipt_id', 'left');
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_company_amount.receipt_id', 'left');
        $query = $this->db->get('erp_company_amount')->result_array();
        return $query;
    }

    public function get_all_receipt($serch_data = NULL) {
        $this->db->select('erp_invoice.*');
        $this->db->select('customer.name,customer.store_name');
        $this->db->order_by('erp_invoice.id', 'desc');
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $query = $this->db->get('erp_invoice')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date');
            $this->db->where('receipt_bill.receipt_id', $val['id']);
            $query[$i]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_receipt_cash($serch_data = NULL) {
        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';
            if (!empty($serch_data['cah_option']) && $serch_data['cah_option'] != 'Select') {
                $this->db->where('erp_company_amount.recevier', $serch_data['cah_option']);
            }
            if (!empty($serch_data['agent']) && $serch_data['agent'] != 'Select') {
                $this->db->where('agent.id', $serch_data['agent']);
            }
            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {
                $this->db->where("DATE_FORMAT(erp_company_amount.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(erp_company_amount.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {
                $this->db->where("DATE_FORMAT(erp_company_amount.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {
                $this->db->where("DATE_FORMAT(erp_company_amount.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $this->db->select('erp_company_amount.*,agent.name');
        $this->db->join('agent', 'agent.id=erp_company_amount.recevier_id', 'left');
        $query = $this->db->get('erp_company_amount')->result_array();
        return $query;
    }

    public function get_receipt_by_id($id) {
        $this->db->select('erp_invoice.*');
        $this->db->where('erp_invoice.id', $id);
        $this->db->select('customer.name,customer.store_name');
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $query = $this->db->get('erp_invoice')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('receipt_bill.receipt_id', $val['id']);
            $query[$i]['receipt_history'] = $this->db->get('receipt_bill')->result_array();
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

    public function get_receipt_by_id_for_agent($data) {//echo "<pre>";
        $this->db->select('receipt.*');
        $this->db->where_in('receipt.id', $data);
        $this->db->select('customer.store_name,selling_percent');
        $this->db->select('agent.name as agent_name');
        $this->db->join('customer', 'customer.id=' . $this->table_name1 . '.customer_id');
        $this->db->join('agent', 'agent.id=' . $this->table_name1 . '.agent_id');
        $query = $this->db->get('receipt')->result_array();
        //echo "<pre>";print_r($query);

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
        if ($this->db->update('erp_invoice', $data)) {

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

}
