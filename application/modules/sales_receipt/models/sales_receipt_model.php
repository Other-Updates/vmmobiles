<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Sales_receipt_model extends CI_Model {



    private $table_name1 = 'receipt';

    private $table_name2 = 'receipt_bill';

    private $increment_table = 'increment_table';

    private $erp_company_amount = 'erp_company_amount';

    private $user_firms = 'erp_user_firms';

    private $erp_invoice = 'erp_invoice';

    private $customer = 'customer';



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



    public function insert_receipt_bill($data) {

        if ($this->db->insert($this->table_name2, $data)) {

            $insert_id = $this->db->insert_id();



            return $insert_id;

        }

        return false;

    }

    public function update_bill_amount($id,$update_data){

         $this->db->where('receipt_id', $id);

        if ($this->db->update($this->table_name2, $update_data)) {



            return true;

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

        if (isset($serch_data) && !empty($serch_data)) {

            if (!empty($serch_data['from_date']))

                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

            if (!empty($serch_data['to_date']))

                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

            if ($serch_data['from_date'] == '1970-01-01')

                $serch_data['from_date'] = '';

            if ($serch_data['to_date'] == '1970-01-01')

                $serch_data['to_date'] = '';





            if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {



                $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);

            }

            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

                $this->db->where($this->customer . '.id', $serch_data['customer']);

            }



            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            }

        }



        //$this->db->where('customer.id', 2);



        $this->db->select('erp_invoice.*');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance');

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->where_in('erp_invoice.contract_customer', 0);

        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        $this->db->order_by('erp_invoice.id', 'desc');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');



        //$this->db->where('customer.id', 543); // Basheer

        //$this->db->where('customer.id', 762); // ALTHAF TOTAL 9894691587

        //$this->db->where('customer.id', 861); // Irsath bai, Aasath street

        //$this->db->where('customer.id', 2);



        $query = $this->db->get('erp_invoice')->result_array();

        //echo "<pre>";

        //print_r($query);

        //exit;

        //echo $this->db->last_query();

        //exit;



        $i = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date,MAX(created_date) AS paid_date');

            $this->db->where('receipt_bill.receipt_id', $val['id']);

            $query[$i]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();

            $i++;

        }



        //echo "<pre>";

        //print_r($query);

        //exit;



        return $query;

    }



    function get_datatables($search_data) {

        $this->_get_datatables_query($search_data);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get('erp_invoice')->result_array();



        $i = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date,MAX(created_date) AS paid_date');

            $this->db->where('receipt_bill.receipt_id', $val['id']);

            $query[$i]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();

            $i++;

        }

        //echo $this->db->last_query();

        //exit;



        return $query;

    }



    function _get_datatables_query($search_data = array()) {



        $this->db->select('erp_invoice.*');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance');

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->where_in('erp_invoice.contract_customer', 0);

        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        //$this->db->order_by('erp_invoice.id', 'desc');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $column_order = array(null, 'erp_invoice.inv_id', 'customer.store_name', 'erp_invoice.net_total', null, null, null, null, null, null, 'erp_invoice.payment_status', null);

        $column_search = array('erp_invoice.inv_id', 'customer.store_name', 'erp_invoice.net_total', 'erp_invoice.payment_status');

        $order = array('erp_invoice.id' => 'DESC');

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

        $this->db->from('erp_invoice');

        return $this->db->count_all_results();

    }



    function count_filtered() {

        $this->_get_datatables_query();

        $query = $this->db->get('erp_invoice');

        return $query->num_rows();

    }



    public function get_all_cashpay_receipt($serch_data = NULL) {

        if (isset($serch_data) && !empty($serch_data)) {

            if (!empty($serch_data['from_date']))

                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

            if (!empty($serch_data['to_date']))

                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

            if ($serch_data['from_date'] == '1970-01-01')

                $serch_data['from_date'] = '';

            if ($serch_data['to_date'] == '1970-01-01')

                $serch_data['to_date'] = '';





            if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {



                $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);

            }

            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

                $this->db->where($this->customer . '.id', $serch_data['customer']);

            }



            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            }

        }

        $this->db->select('erp_invoice.*');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance');

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->where_in('erp_invoice.contract_customer', 0);

        $this->db->where_in('erp_invoice.firm_id', $frim_id);

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



    public function get_sales_list($values = array()) {

        $this->db->select('erp_invoice.id,erp_invoice.inv_id,erp_invoice.customer,erp_invoice.firm_id,erp_invoice.net_total');

        $this->db->select('customer.name,customer.store_name');

        $this->db->where('erp_invoice.firm_id', $values['firm']);

        $this->db->order_by('erp_invoice.id', 'desc');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $query = $this->db->get('erp_invoice')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(receipt_bill.discount) AS receipt_discount,SUM(receipt_bill.bill_amount) AS receipt_paid,receipt_bill.due_date');

            $this->db->where('receipt_bill.receipt_id', $val['id']);

            if ($values['from'] != '') {

                $this->db->where('receipt_bill.due_date >=', $values['from']);

            }

            if ($values['to'] != '') {

                $this->db->where('receipt_bill.due_date <=', $values['to']);

            }



            $query[$i]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();

            $i++;

        }

        return $query;

    }



    public function get_sales_list_by_user_id($id, $values = array()) {

        $firms = $this->get_firm_by_user($id);

        $firms = $firms[0];

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->select('erp_invoice.*');

        $this->db->select('customer.name, customer.store_name');

        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        $this->db->order_by('erp_invoice.id', 'desc');

        $this->db->join('customer', 'customer.id = erp_invoice.customer');

        $query = $this->db->get('erp_invoice')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(discount) AS receipt_discount, SUM(bill_amount) AS receipt_paid, due_date');

            $this->db->where('receipt_bill.receipt_id', $val['id']);

            if ($values['from'] != '') {

                $this->db->where('receipt_bill.due_date >=', $values['from']);

            }

            if ($values['to'] != '') {

                $this->db->where('receipt_bill.due_date <=', $values['to']);

            }

            $query[$i]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();

            $i++;

        }

        return $query;

    }



    public function get_receipt_by_user_id($id, $serch_data = NULL) {

        $this->db->select('erp_invoice.*');

        $this->db->select('customer.name, customer.store_name');

        $this->db->where('erp_invoice.firm_id', $values['firm']);

        $this->db->order_by('erp_invoice.id', 'desc');

        $this->db->group_by('erp_invoice.customer');

        $this->db->join('customer', 'customer.id = erp_invoice.customer');

        $query = $this->db->get('erp_invoice')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(discount) AS receipt_discount, SUM(bill_amount) AS receipt_paid, MAX(due_date) AS next_date');

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

        $this->db->select('erp_company_amount.*, agent.name');

        $this->db->join('agent', 'agent.id = erp_company_amount.recevier_id', 'left');

        $query = $this->db->get('erp_company_amount')->result_array();

        return $query;

    }



    public function get_receipt_by_id($id) {

        $this->db->select('erp_invoice.*');

        $this->db->where('erp_invoice.id', $id);

        $this->db->select('customer.name, customer.store_name, customer.mobil_number, customer.advance');

        $this->db->join('customer', 'customer.id = erp_invoice.customer');

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

        $this->db->select('customer.store_name, selling_percent');

        $this->db->select('agent.name as agent_name');

        $this->db->join('customer', 'customer.id = ' . $this->table_name1 . '.customer_id');

        $this->db->join('agent', 'agent.id = ' . $this->table_name1 . '.agent_id');

        $query = $this->db->get('receipt')->result_array();

        //echo "<pre>";print_r($query);



        $i = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            $this->db->where('receipt_bill.receipt_id', $val['id']);

            $query[$i]['receipt_history'] = $this->db->get('receipt_bill')->result_array();



            $arr = explode('-', $val['inv_list']);



            $this->db->select('invoice.inv_no, invoice.id, inv_date, org_value, total_value');

            $this->db->where('customer.id', $val['customer_id']);

            $this->db->where_in('invoice.id', $arr);

            $this->db->join('package', 'package.id = invoice.package_id');

            $this->db->join('customer', 'customer.id = package.customer');

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



    public function get_receipt_download_by_id($id, $rec_id) {//echo "<pre>";

        $this->db->where('erp_invoice.id', $id);

        $this->db->select('erp_invoice.*');

        $this->db->select('erp_manage_firms.firm_name');

        $this->db->select('customer.name, customer.store_name, customer.email_id, customer.mobil_number, customer.advance');

        $this->db->join('customer', 'customer.id = erp_invoice.customer');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id = erp_invoice.firm_id');

        $query = $this->db->get('erp_invoice')->result_array();

        $k = 0;

        foreach ($query as $val) {

            $this->db->where('erp_invoice_details.in_id', $id);

            $this->db->join('erp_product', 'erp_product.id = erp_invoice_details.product_id');

            $this->db->select('erp_invoice_details.*, erp_product.product_name');

            $query[$k]['po_details'] = $this->db->get('erp_invoice_details')->result_array();

            $k++;

        }

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            $this->db->where('receipt_bill.id', $rec_id);

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



    public function get_company() {

        $this->db->select('*');

        $query = $this->db->get('customer')->result_array();

        return $query;

    }



    public function get_firm_by_user($id) {

        $this->db->select('firm_id');

        $this->db->where($this->user_firms . '.user_id', $id);

        $result = $this->db->get('erp_user_firms')->result_array();

        return $result;

    }



    public function update_receipt_entry($insert, $id) {



        $this->db->where($this->table_name2 . '.id', $id);

        $this->db->update($this->table_name2, $insert);

        return true;

    }



}

