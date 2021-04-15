<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Report_model extends CI_Model {



    private $table_name1 = 'sales_order';

    private $erp_product = 'erp_product';

    private $customer = 'customer';

    private $erp_invoice = 'erp_invoice';

    private $erp_invoice_details = 'erp_invoice_details';

    private $receipt_bill = 'receipt_bill';

    private $payment_report = 'payment_report';

    private $table_name6 = 'vendor';

    var $primaryTable = 'erp_stock u';

    var $joinTable2 = 'erp_category c';

    var $joinTable3 = 'erp_product p';

    var $joinTable4 = 'erp_brand b';

    //var $joinTable5 = 'erp_stock_history h';

    var $selectColumn = 'u.id,u.quantity,c.categoryName,p.product_name,b.brands,p.model_no,u.category';

    var $column_order = array(null, 'c.categoryName', 'b.brands', 'p.product_name', 'u.quantity', null); //set column field database for datatable orderable

    var $column_search = array('c.categoryName', 'b.brands', 'p.product_name', 'u.quantity'); //set column field database for datatable searchable

    var $group = 'p.id'; // default order



    function __construct() {

        parent::__construct();

    }



    function get_all_receipt() {

        if (isset($serch_data) && !empty($serch_data)) {

            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

            if ($serch_data['from_date'] == '1970-01-01')

                $serch_data['from_date'] = '';

            if ($serch_data['to_date'] == '1970-01-01')

                $serch_data['to_date'] = '';

            if (!empty($serch_data['state']) && $serch_data['state'] != 'Select') {

                $this->db->where($this->table_name1 . '.state', $serch_data['state']);

            }

            if (!empty($serch_data['supplier']) && $serch_data['supplier'] != 'Select') {

                $this->db->where($this->table_name1 . '.customer', $serch_data['supplier']);

            }

            if (!empty($serch_data['po'])) {

                $this->db->where($this->table_name1 . '.grn_no', $serch_data['po']);

            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            } elseif (isset($serch_data["style"]) && $serch_data["style"] != "Select") {



                $this->db->where('master_style.id', $serch_data["style"]);

            }

        }

        $this->db->select($this->table_name1 . '.*');

        $this->db->select('vendor.name,store_name');

        $this->db->select('master_style.style_name');

        $this->db->select('master_state.state');

        $this->db->where($this->table_name1 . '.status', 1);

        $this->db->where($this->table_name1 . '.df', 0);

        //$this->db->where("DATE_FORMAT(erp_invoice.created,'%m') ='" . date('m') . "'");

        $this->db->order_by($this->table_name1 . '.id', 'desc');

        $this->db->group_by('po_details.gen_id');

        $this->db->join('po_details', 'po_details.gen_id=' . $this->table_name1 . '.id');

        $this->db->join('master_style', 'master_style.id=po_details.style_id');

        $this->db->join('vendor', 'vendor.id=' . $this->table_name1 . '.customer');

        $this->db->join('master_state', 'master_state.id=' . $this->table_name1 . '.state');

        $this->db->order_by('erp_invoice.id', 'desc');

        $query = $this->db->get('erp_invoice')->result_array();

        return $query;

    }



    public function get_all_quotation_report($serch_data) {

        $this->db->select('erp_quotation.id,customer.id as customer, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'

                . 'erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus,erp_quotation.created_date');

        $this->db->where('erp_quotation.estatus !=', 0);

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->where_in('erp_quotation.firm_id', $frim_id);

        $this->db->join('customer', 'customer.id=erp_quotation.customer');

        if (isset($serch_data) && !empty($serch_data)) {



            if (!empty($serch_data['from_date']))

                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

            if (!empty($serch_data['to_date']))

                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

            if ($serch_data['from_date'] == '1970-01-01')

                $serch_data['from_date'] = '';

            if ($serch_data['to_date'] == '1970-01-01')

                $serch_data['to_date'] = '';

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(erp_quotation.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(erp_quotation.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(erp_quotation.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(erp_quotation.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            }

        }

        //$this->db->where("DATE_FORMAT(erp_quotation.created_date,'%m') ='" . date('m') . "'");

        $this->db->order_by('erp_quotation.id', 'desc');

        $query = $this->db->get('erp_quotation')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            $this->db->where('q_id', intval($val['id']));

            $query[$i]['pc_amount'] = $this->db->get('erp_project_cost')->result_array();



            $i++;

        }

        $c = 0;

        $Count = COUNT($query);

        $query[$c]['count'] = $Count;



        $j = 0;

        $this->db->select('COUNT(erp_quotation.id) as id');

        $query[$j]["quo_total"] = $this->db->get('erp_quotation')->result_array();

        $k = 0;

        $this->db->select('COUNT(erp_project_cost.id) as id');

        $query[$k]["pc_total"] = $this->db->get('erp_project_cost')->result_array();

        return $query;

    }



    function get_all_profit_report($serch_data) {





//        $this->db->select('erp_quotation.id,customer.id as customer, customer.name,customer.store_name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'

//                . 'erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus');

//        $this->db->where('erp_quotation.estatus !=', 0);

       $firms = $this->user_auth->get_user_firms();

       $frim_id = array();

        foreach ($firms as $value) {

          $frim_id[] = $value['firm_id'];

        }

//        $this->db->where_in('erp_quotation.firm_id', $frim_id);

//        $this->db->join('customer', 'customer.id=erp_quotation.customer');

//        $query = $this->db->get('erp_quotation')->result_array();

//

//        $i = 0;

//

//        $j = 0;

//        foreach ($query as $val) {


        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.email_id,customer.id AS cust_id,customer.state_id');

        $this->db->select('erp_invoice.*');

        if (isset($serch_data) && !empty($serch_data)) {

            if (!empty($serch_data['from_date']))

                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

            if (!empty($serch_data['to_date']))

                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

            if ($serch_data['from_date'] == '1970-01-01')

                $serch_data['from_date'] = '';

            if ($serch_data['to_date'] == '1970-01-01')

                $serch_data['to_date'] = '';

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            }

        }

        // $this->db->where('q_id', intval($val['id']));


        if(empty($serch_data['firm_id'])){
           $this->db->where_in('erp_invoice.firm_id', $frim_id);
        }else{
           $this->db->where('erp_invoice.firm_id', $serch_data['firm_id']);
        }

        //$this->db->where("erp_invoice.inv_id !=", 'Wings Invoice');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $query = $this->db->get('erp_invoice')->result_array();


       //  echo "<pre>"; print_r($query);exit;

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('erp_invoice_details.*,erp_product.id,erp_product.cost_price');

            $this->db->where('in_id', intval($val['id']));

            $this->db->join('erp_product', 'erp_product.id=erp_invoice_details.product_id');

            $query[$i]['or_amount'] = $this->db->get('erp_invoice_details')->result_array();

            $i++;

        }

//            if (empty($query[$j]['inv_amount']))

//                unset($query[$j]);

//            $j++;

        //echo "<pre>";

        // print_r($query);

        //exit;



        return $query;

    }



    function get_all_profit_report1($serch_data) {



        $this->db->select('erp_quotation.id,customer.id as customer, customer.name,customer.store_name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'

                . 'erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus');

        $this->db->where('erp_quotation.estatus !=', 0);

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->where_in('erp_quotation.firm_id', $frim_id);

        $this->db->join('customer', 'customer.id=erp_quotation.customer');

        $query = $this->db->get('erp_quotation')->result_array();



        $i = 0;

        foreach ($query as $val) {

            $this->db->select('erp_quotation_details.id,erp_quotation_details.q_id,erp_quotation_details.product_id,erp_product.id,SUM(erp_product.cost_price) AS total_cost_price');

            $this->db->where('q_id', intval($val['id']));

            $this->db->join('erp_product', 'erp_product.id=erp_quotation_details.product_id');

            $query[$i]['or_amount'] = $this->db->get('erp_quotation_details')->result_array();

            $i++;

        }

        $j = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            if (isset($serch_data) && !empty($serch_data)) {

                if (!empty($serch_data['from_date']))

                    $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

                if (!empty($serch_data['to_date']))

                    $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

                if ($serch_data['from_date'] == '1970-01-01')

                    $serch_data['from_date'] = '';

                if ($serch_data['to_date'] == '1970-01-01')

                    $serch_data['to_date'] = '';

                if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                    $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

                } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                    $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

                } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                    $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

                }

            }

            $this->db->where('q_id', intval($val['id']));

            $query[$j]['inv_amount'] = $this->db->get('erp_invoice')->result_array();

            if (empty($query[$j]['inv_amount']))

                unset($query[$j]);

            $j++;

        }

        return $query;

    }



    function count_filtered($search_data) {

        $this->_get_datatables_query($search_data);

        $query = $this->db->get();

        return $query->num_rows();

    }



    function count_filtered_profit() {

        $this->_get_profit_datatables_query();

        $query = $this->db->get('erp_invoice');

        return $query->num_rows();

    }



    function count_filtered_hr_invoice() {

        $this->_get_hr_invoice_datatables_query();

        $query = $this->db->get('erp_invoice');

        return $query->num_rows();

    }



    function count_all_hr_invoice() {

        $this->_get_hr_invoice_datatables_query();

        $this->db->from('erp_invoice');

        return $this->db->count_all_results();

    }



    function count_all() {

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->from($this->primaryTable);

        $this->db->where_in('firm_id', $frim_id);

        return $this->db->count_all_results();

    }



    function count_all_profit() {

        $this->db->from('erp_invoice');

        return $this->db->count_all_results();

    }



    function _get_datatables_query($search_data = array()) {

        //Join Table

        //$this->db->join($this->joinTable1, 'r.firm_id=u.firm_id');

        $this->db->join($this->joinTable2, 'c.cat_id=u.category');

        $this->db->join($this->joinTable3, 'p.id=u.product_id');

        $this->db->join($this->joinTable4, 'p.brand_id=b.id', 'LEFT');

        // $this->db->where('u.status', 1);

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

      

        $this->db->from($this->primaryTable);

        $i = 0;

        $j = 0;



        foreach ($this->column_search as $item) { // loop column

            if ($_POST['search']['value']) { // if datatable send POST for search

                if ($i === 0) { // first loop

                    $this->db->like($item, $_POST['search']['value']);

                } else {

                    $this->db->or_like($item, $_POST['search']['value']);

                }

            }

            $i++;

        }

        if ($search_data['category'] != '' || $search_data['product'] != '' || $search_data['firm_id'] != '' || $search_data['brand'] != '') {

            if ($search_data['category'] != '' && $search_data['category'] != 'Select') { // first loop

                $this->db->where('u.category', $search_data['category']);

            } if ($search_data['product'] != '') {

                $this->db->where('u.product_id', $search_data['product']);

            }
            if ($search_data['brand'] != '' && $search_data['brand'] != 'Select') {

                $this->db->where('u.brand', $search_data['brand']);

            }
            if ($search_data['firm_id'] != '' && $search_data['firm_id'] != 'Select') {

                $this->db->where('u.firm_id', $search_data['firm_id']);

            }else{
                $this->db->where_in('u.firm_id', $frim_id);
            }


        }else{
              $this->db->where_in('u.firm_id', $frim_id);
        }

        if (isset($this->group)) {

            $group = $this->group;

            $this->db->order_by($group);

        }

    }



    function _get_profit_datatables_query($search_data = array()) {

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.email_id,customer.id AS cust_id,customer.state_id');

        $this->db->select('erp_invoice.*');

        if (isset($serch_data) && !empty($serch_data)) {

            if (!empty($serch_data['from_date']))

                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

            if (!empty($serch_data['to_date']))

                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

            if ($serch_data['from_date'] == '1970-01-01')

                $serch_data['from_date'] = '';

            if ($serch_data['to_date'] == '1970-01-01')

                $serch_data['to_date'] = '';

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            }else{
                $current_date=date('Y-m-d');
                 $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $current_date. "' AND DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $current_date. "'");
            }

        }


        $current_date=date('Y-m-d');

                 $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $current_date. "' AND DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $current_date. "'");

        // $this->db->where('q_id', intval($val['id']));

        $this->db->where("erp_invoice.inv_id !=", 'Wings Invoice');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');



        $column_order = array(null, 'customer.store_name', 'erp_invoice.inv_id', null, null, 'erp_invoice.commission_rate', null, null, null);

        $column_search = array('customer.name', 'erp_invoice.inv_id');

        $order = array('erp_invoice.id' => 'desc');

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



    function _get_outstanding_datatables_query($search_data = array()) {

        $this->db->select('erp_invoice.*');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance');

        if (!empty($search_data['cust_type']) && $search_data['cust_type'] != 9) {

            $this->db->where_in($this->customer . ".customer_type", $search_data['cust_type']);

        }

        if (!empty($search_data['cust_reg']) && $search_data['cust_reg'] != 'both') {

            $this->db->where($this->customer . ".customer_region", $search_data['cust_reg']);

        }

        if (!empty($search_data['due_date']) && $search_data['due_date'] == 6) {

            $this->db->where("erp_invoice.inv_id", 'Wings Invoice');

        }

        if (!empty($search_data['due_date']) && $search_data['due_date'] != 6 && $search_data['due_date'] != 5) {

            $this->db->where("erp_invoice.inv_id !=", 'Wings Invoice');

        }

        //$this->db->order_by('erp_invoice.id', 'desc');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->where('erp_invoice.net_total >', 0);

        $this->db->where("payment_status ", 'Pending');

        $column_order = array(null, 'customer.store_name', 'customer.mobil_number', null, null, null, null, null);

        $column_search = array('customer.name', 'customer.store_name', 'customer.mobil_number');

        $order = array('erp_invoice.id' => 'desc');

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



    function _get_outstanding_duedate_datatables_query($search_data = array()) {



        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }



        $this->db->distinct('customer.id');

        $this->db->select('payment_report.balance,payment_report.customer,payment_report.inv_id');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance,customer.id');

        $this->db->join('payment_report', 'payment_report.customer=customer.id');

        $this->db->where("payment_report.balance >", 0.1);

//        $this->db->where("payment_report.inv_id !=", 'Wings Invoice');

        $this->db->group_by("payment_report.customer");

        $column_order = array(null, 'customer.store_name', 'customer.mobil_number', null, null, null, null, null, null);

        $column_search = array('customer.store_name', 'customer.name', 'customer.mobil_number', 'customer.advance');

        $order = array('customer.store_name' => 'ASC');

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



    function _get_payment_datatables_query($search_data = array()) {

        if (isset($serch_data) && !empty($serch_data)) {



            if (!empty($serch_data['firm']) && $serch_data['firm'] != 'Select') {



                $this->db->where($this->erp_invoice . '.firm_id', $serch_data['firm']);

            }

            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

                $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);

            }

        }



        $this->db->distinct('customer.id');

        $this->db->select('erp_invoice.firm_id');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance,customer.id');

        $this->db->join('customer', 'customer.id=erp_invoice.customer', 'left');





        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        $this->db->where('erp_invoice.net_total >', 0);

        $column_order = array(null, 'customer.store_name', null, null, null, null, null, null, null);

        $column_search = array('customer.store_name');

        $order = array('customer.store_name' => 'ASC');

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



    function _get_hr_invoice_datatables_query($search_data = array()) {

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

            $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);

        }

        if (!empty($serch_data['sales_man']) && $serch_data['sales_man'] != 'Select') {

            $this->db->where($this->erp_invoice . '.sales_man', $serch_data['sales_man']);

        }

        if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

            $this->db->where($this->erp_invoice_details . '.product_id', $serch_data['product']);

        }



        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

        }



        $this->db->select('customer.id as customer,customer.store_name,customer.tin, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_quotation.q_no,erp_invoice.total_qty,erp_invoice.tax,erp_quotation.ref_name,erp_invoice.tax_label,'

                . 'erp_invoice.net_total,erp_invoice.created_date,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_sales_man.sales_man_name');

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        $customer = array('7', '8');

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->join('erp_sales_man', 'erp_sales_man.id=erp_invoice.sales_man', 'LEFT');

        $this->db->join('erp_invoice_details', 'erp_invoice_details.in_id=erp_invoice.id');

        $this->db->where_in('customer.customer_type', $customer);

    }



    function get_datatables($search_data) {

        $this->db->select($this->selectColumn);

        $this->_get_datatables_query($search_data);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        //echo $this->db->last_query();

        //exit;



        return $query->result();

    }



    function get_profit_datatables($search_data) {

        //$this->db->select($this->selectColumn);

        $this->_get_profit_datatables_query($search_data);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

         $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        if($search_data['firm_id']!="" && $search_data['firm_id']!="Select")
            $this->db->where_in('erp_invoice.firm_id', $search_data['firm_id']);
        else
             $this->db->where_in('erp_invoice.firm_id', $frim_id);

        $query = $this->db->get('erp_invoice')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('erp_invoice_details.*,erp_product.id,erp_product.cost_price');

            $this->db->where('in_id', intval($val['id']));

            $this->db->join('erp_product', 'erp_product.id=erp_invoice_details.product_id');

            $query[$i]['or_amount'] = $this->db->get('erp_invoice_details')->result_array();

            $i++;

        }

        return $query;

    }



    function get_outstanding_datatables($search_data) {

        //$this->db->select($this->selectColumn);

        $this->_get_outstanding_datatables_query($search_data);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get('erp_invoice')->result_array();

        $i = 0;

        foreach ($query as $duedate) {

            $due_date = $duedate['credit_due_date'];

            $seven_date = date('Y-m-d', strtotime("+7 day", strtotime($duedate['credit_due_date'])));

            $thirty_date = date('Y-m-d', strtotime("+30 day", strtotime($duedate['credit_due_date'])));

            $ninty_date = date('Y-m-d', strtotime("+90 day", strtotime($duedate['credit_due_date'])));

            if ($duedate['firm_id'] == 1) {

                $this->db->select('SUM(bill_amount) AS total_bill_amount,SUM(discount) AS receipt_discount');

                if (!empty($search_data['due_date']) && $search_data['due_date'] != 5 && $search_data['due_date'] != 6) {

                    if ($search_data['due_date'] == 1)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($due_date)) . '" and "' . date('Y-m-d', strtotime($seven_date)) . '"');

                    else if ($search_data['due_date'] == 2)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($seven_date)) . '" and "' . date('Y-m-d', strtotime($thirty_date)) . '"');

                    else if ($search_data['due_date'] == 3)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($thirty_date)) . '" and "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                    else if ($search_data['due_date'] == 4)

                        $this->db->where('created_date >= "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                }

                $this->db->where("receipt_id ", $duedate['id']);

                $electricals = $this->db->get($this->receipt_bill)->result_array();

                $query[$i]['electricals'] = ($electricals[0]['total_bill_amount'] + $electricals[0]['receipt_discount']);

            }

            if ($duedate['firm_id'] == 2) {

                $this->db->select('SUM(bill_amount) AS total_bill_amount,SUM(discount) AS receipt_discount');

                if (!empty($search_data['due_date']) && $search_data['due_date'] != 5 && $search_data['due_date'] != 6) {

                    if ($search_data['due_date'] == 1)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($due_date)) . '" and "' . date('Y-m-d', strtotime($seven_date)) . '"');

                    else if ($search_data['due_date'] == 2)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($seven_date)) . '" and "' . date('Y-m-d', strtotime($thirty_date)) . '"');

                    else if ($search_data['due_date'] == 3)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($thirty_date)) . '" and "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                    else if ($search_data['due_date'] == 4)

                        $this->db->where('created_date >= "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                }

                $this->db->where("receipt_id ", $duedate['id']);

                $paints = $this->db->get($this->receipt_bill)->result_array();

                $query[$i]['paints'] = ($paints[0]['total_bill_amount'] + $paints[0]['receipt_discount']);

            }

            if ($duedate['firm_id'] == 3) {

                $this->db->select('SUM(bill_amount) AS total_bill_amount,SUM(discount) AS receipt_discount');

                if (!empty($search_data['due_date']) && $search_data['due_date'] != 5 && $search_data['due_date'] != 6) {

                    if ($search_data['due_date'] == 1)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($due_date)) . '" and "' . date('Y-m-d', strtotime($seven_date)) . '"');

                    else if ($search_data['due_date'] == 2)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($seven_date)) . '" and "' . date('Y-m-d', strtotime($thirty_date)) . '"');

                    else if ($search_data['due_date'] == 3)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($thirty_date)) . '" and "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                    else if ($search_data['due_date'] == 4)

                        $this->db->where('created_date >= "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                }

                $this->db->where("receipt_id ", $duedate['id']);

                $tiles = $this->db->get($this->receipt_bill)->result_array();

                $query[$i]['tiles'] = ($tiles[0]['total_bill_amount'] + $tiles[0]['receipt_discount']);

            }

            if ($duedate['firm_id'] == 4) {

                $this->db->select('SUM(bill_amount) AS total_bill_amount,SUM(discount) AS receipt_discount');

                if (!empty($search_data['due_date']) && $search_data['due_date'] != 5 && $search_data['due_date'] != 6) {

                    if ($search_data['due_date'] = 1)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($due_date)) . '" and "' . date('Y-m-d', strtotime($seven_date)) . '"');

                    else if ($search_data['due_date'] = 2)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($seven_date)) . '" and "' . date('Y-m-d', strtotime($thirty_date)) . '"');

                    else if ($search_data['due_date'] = 3)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($thirty_date)) . '" and "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                    else if ($search_data['due_date'] = 4)

                        $this->db->where('created_date >= "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                }

                $this->db->where("receipt_id ", $duedate['id']);

                $hardware = $this->db->get($this->receipt_bill)->result_array();

                $query[$i]['hardware'] = ($hardware[0]['total_bill_amount'] + $hardware[0]['receipt_discount']);

            }

            $query[$i]['net_amount'] = $query[$i]['electricals'] + $query[$i]['paints'] + $query[$i]['tiles'] + $query[$i]['hardware'];



            $i++;

        }





        return $query;

    }



    function get_outstanding_duedate_datatables($search_data) {

        //$this->db->select($this->selectColumn);

        $this->_get_outstanding_duedate_datatables_query($search_data);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get('customer')->result_array();

//        echo $this->db->last_query();

//        die;

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $i = 0;

        foreach ($query as $val) {



            $due_date = date('Y-m-d');

            $seven_date = date('Y-m-d', strtotime("-6 day", strtotime($due_date)));

            $seven_date1 = date('Y-m-d', strtotime("-7 day", strtotime($due_date)));

            $thirty_date = date('Y-m-d', strtotime("-29 day", strtotime($due_date)));

            $thirty_date1 = date('Y-m-d', strtotime("-30 day", strtotime($due_date)));

            $ninty_date = date('Y-m-d', strtotime("-89 day", strtotime($due_date)));



            //$this->db->select('*');

            $this->db->select('SUM(balance) as new_balance');

            $this->db->where("DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') >='" . $seven_date . "' AND DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') <= '" . $due_date . "'");

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id !=', 'Wings Invoice');

            //$this->db->where('payment_report.balance >', 0.1);

            $this->db->where_in('payment_report.firm_id', $frim_id);

            $this->db->group_by('payment_report.customer');

            $this->db->from('payment_report');

            $query[$i]['days'] = $this->db->get()->result_array();



            //$this->db->select('*');

            $this->db->select('SUM(balance) as new_balance');

            $this->db->where("DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') >='" . $thirty_date . "' AND DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') <= '" . $seven_date1 . "'");

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id !=', 'Wings Invoice');

            //$this->db->where('payment_report.balance >', 0.1);

            $this->db->where_in('payment_report.firm_id', $frim_id);

            $this->db->group_by('payment_report.customer');

            $this->db->from('payment_report');

            $query[$i]['sevendays'] = $this->db->get()->result_array();



            //$this->db->select('*');

            $this->db->select('SUM(balance) as new_balance');

            $this->db->where("DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') >='" . $ninty_date . "' AND DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') <= '" . $thirty_date1 . "'");

            $this->db->where('payment_report.customer', $val['id']);

            // $this->db->where('payment_report.customer',1087);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id !=', 'Wings Invoice');

            //$this->db->where('payment_report.balance >', 0.1);

            //$this->db->where_in('payment_report.firm_id', $frim_id);

            $this->db->group_by('payment_report.customer');

            $this->db->from('payment_report');

            $query[$i]['thirtydays'] = $this->db->get()->result_array();



            //$this->db->select('*');

            $this->db->select('SUM(balance) as new_balance');

            $this->db->where("DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') <'" . $ninty_date . "'");

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id !=', 'Wings Invoice');

            $this->db->where('payment_report.balance >', 0.1);

            $this->db->where_in('payment_report.firm_id', $frim_id);

            $this->db->group_by('payment_report.customer');

            $this->db->from('payment_report');

            $query[$i]['nintydays'] = $this->db->get()->result_array();





            //$this->db->select('*');

            $this->db->select('SUM(balance) as new_balance');

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id', 'Wings Invoice');

            //$this->db->where('payment_report.balance >', 0.1);

            $this->db->where_in('payment_report.firm_id', $frim_id);

            $this->db->group_by('payment_report.customer');

            $query[$i]['rec'] = $this->db->get('payment_report')->result_array();

//            echo $this->db->last_query();

//            exit;

            $i++;

        }

//        echo '<pre>';print_r($query);exit;

        return $query;

    }



    function get_payment_datatables($search_data) {

        //$this->db->select($this->selectColumn);

        $this->_get_payment_datatables_query($search_data);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

//        $this->db->where('erp_invoice.customer',1087);

        $result_arr = $this->db->get('erp_invoice')->result_array();





        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $i = $j = 0;

        if (!empty($result_arr)) {

            foreach ($result_arr as $value) {

                $this->db->distinct();

                $this->db->select('erp_invoice.net_total AS net_total');

                //$this->db->select('SUM(receipt_bill.discount) AS receipt_discount,SUM(receipt_bill.bill_amount) AS receipt_paid,MAX(receipt_bill.due_date) AS next_date,MAX(receipt_bill.created_date) AS paid_date');

                $this->db->where('erp_invoice.inv_id !=', 'Wings Invoice');

                $this->db->where('erp_invoice.customer', $value['id']);

                $this->db->where('erp_invoice.firm_id', $value['firm_id']);

                $this->db->where_in('erp_invoice.contract_customer', 0);

                $this->db->join('receipt_bill', 'receipt_bill.receipt_id=erp_invoice.id', 'left');

                $sub_query = $this->db->get('erp_invoice')->result_array();

                $invoice_net_total = 0;

                if (!empty($sub_query)) {

                    foreach ($sub_query as $total) {

                        $invoice_net_total += $total['net_total'];

                    }

                }

                //'$result_arr[$j]['invoice_net'][] = $invoice_net_total;

                if (isset($result_arr[$j]['invoice_net_total']))

                    $result_arr[$j]['invoice_net_total'] += $invoice_net_total;

                else

                    $result_arr[$j]['invoice_net_total'] = $invoice_net_total;

                $j++;

            }

        }

        if (!empty($result_arr)) {

            foreach ($result_arr as $value) {

                $this->db->select('erp_invoice.net_total');

                $this->db->select('SUM(erp_invoice.net_total) AS net_total, MAX(erp_invoice.created_date) AS created_date');

                $this->db->select('SUM(receipt_bill.discount) AS receipt_discount,SUM(receipt_bill.bill_amount) AS receipt_paid,MAX(receipt_bill.due_date) AS next_date,MAX(receipt_bill.created_date) AS paid_date');

                $this->db->where('erp_invoice.inv_id !=', 'Wings Invoice');

                $this->db->where('erp_invoice.customer', $value['id']);

                $this->db->where('erp_invoice.firm_id', $value['firm_id']);

                $this->db->where_in('erp_invoice.contract_customer', 0);

                $this->db->join('receipt_bill', 'receipt_bill.receipt_id=erp_invoice.id', 'left');

                $sub_query = $this->db->get('erp_invoice')->result_array();

                $result_arr[$i]['receipt_bill'] = $sub_query;

                $i++;

            }

        }

//        echo '<pre>';print_r($result_arr) ;exit;

        return $result_arr;

    }



    public function get_customer_based_datatables($serch_data = array()) {

        $this->db->distinct();

        $this->db->select('erp_invoice.*');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance');

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->where_in('erp_invoice.contract_customer', 0);

        

        // $this->db->where('erp_invoice.net_total >', 0);

        if (!empty($serch_data['overdue']) && $serch_data['overdue'] != '' && $serch_data['overdue'] == 3) {

            $this->db->where('customer.advance >', 0);

        }

        //$this->db->order_by('erp_invoice.id', 'desc');

        $this->db->join('customer', 'customer.id=erp_invoice.customer', 'LEFT');

        $this->db->join('erp_invoice_details', 'erp_invoice.id=erp_invoice_details.in_id', 'LEFT');

        //  $this->db->where('customer', 164);



     if (isset($serch_data) && !empty($serch_data)) {

            if (!empty($serch_data['from_date']))

                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

            if (!empty($serch_data['to_date']))

                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

            if ($serch_data['from_date'] == '1970-01-01')

                $serch_data['from_date'] = '';

            if ($serch_data['to_date'] == '1970-01-01')

                $serch_data['to_date'] = '';


            if (!empty($serch_data['firm_id']) && $serch_data['firm_id'] != 'Select') {



                $this->db->where('erp_invoice.firm_id', $serch_data['firm_id']);

            }
            else if (!empty($serch_data['firm_id']) && $serch_data['firm_id'] == 'Select') {



              $this->db->where_in('erp_invoice.firm_id', $frim_id);

            }


            if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {



                $this->db->where('erp_invoice.inv_id', $serch_data['inv_id']);

            }

            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

                $this->db->where('customer.id', $serch_data['customer']);

            }



            if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

                $this->db->where('erp_invoice_details.product_id', $serch_data['product']);

            }



            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            }else{

            $current_date=date('Y-m-d');
           // $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $current_date. "'");
             $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $current_date. "' AND DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $current_date . "'");

            $this->db->where('erp_invoice.firm_id', $frim_id[0]);
               
            }



            

        }

            



        $column_order = array(null, 'customer.store_name', 'erp_invoice.inv_id', 'erp_invoice.net_total', 'customer.advance', null, null, null, null, null, null, null,);

        $column_search = array('customer.store_name', 'erp_invoice.inv_id', 'erp_invoice.net_total', 'customer.advance');

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



        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get('erp_invoice')->result_array();

        //echo $this->db->last_query();

        //exit;

        $i = 0;

          


        foreach ($query as $val) {

            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date');

            $this->db->where('receipt_bill.receipt_id', $val['id']);

            $query[$i]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();

            $this->db->select('total_qty,subtotal_qty,id,net_total');

            $this->db->where('invoice_id', $val['id']);

            $this->db->order_by("id", "desc");

            $this->db->limit(1);

            $query[$i]['return'] = $this->db->get('erp_sales_return')->result_array();

            //$query[$i]['return'] = 0;

            //  echo $this->db->last_query();

            //  echo '<br>----------------------------------<br>';

            $this->db->select('total_qty,subtotal_qty,id,net_total');

            $this->db->where('invoice_id', $val['id']);

            $this->db->order_by("id", "asc");

            $this->db->limit(1);

            $value = $this->db->get('erp_sales_return')->result_array();

            array_push($query[$i]['return'], $value[0]);

            // array_push($query[$i]['return'], 0);

            $i++;

            // echo $this->db->last_query() . '<br />';

        }

        // exit;

        return $query;

    }



    public function get_invoice_datatables($serch_data) {



        if (!empty($serch_data['from_date']))

            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

        if (!empty($serch_data['to_date']))

            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

        if ($serch_data['from_date'] == '1970-01-01')

            $serch_data['from_date'] = '';

        if ($serch_data['to_date'] == '1970-01-01')

            $serch_data['to_date'] = '';

        $invoiceIds = array();

        if (!empty($serch_data)) {

            $invoice_ids = array();

           // $where_gst = '(erp_invoice_details.tax="' . $serch_data['gst'] . '" OR erp_invoice_details.gst = "' . $serch_data['gst'] . '")';

            $this->db->select('erp_invoice.id');

            $this->db->select('erp_invoice_details.*');

            $this->db->join('erp_invoice', 'erp_invoice_details.in_id=erp_invoice.id');

          //  $this->db->where($where_gst);

            if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {

                $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);

            }

            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

                $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);

            }

            if (!empty($serch_data['sales_man']) && $serch_data['sales_man'] != 'Select') {

                $this->db->where($this->erp_invoice . '.sales_man', $serch_data['sales_man']);

            }

            if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

                $this->db->where($this->erp_invoice_details . '.product_id', $serch_data['product']);

            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



               $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            } 




            $invoices = $this->db->get('erp_invoice_details')->result_array();



            $inv_all_details = array();

            $count = 1;

            if (!empty($invoices)) {

                /* Search Particular products in that GST % From the Invoice */

                foreach ($invoices as $invoices_values) {

                    $invoice_id = $invoices_values['in_id'];

                    $tax = $invoices_values['tax'];

                    $per_cost = $invoices_values['per_cost'];

                    $quantity = $invoices_values['quantity'];

                    $gst = $invoices_values['gst'];

                    $cgst = ($tax / 100) * ($per_cost * $quantity);

                    $sgst = ($gst / 100) * ($per_cost * $quantity);

                    if (!isset($inv_all_details[$invoice_id]['quantity'])) {

                        $inv_all_details[$invoice_id]['in_id'] = $invoice_id;

                        $inv_all_details[$invoice_id]['quantity'] = $quantity;

                        $inv_all_details[$invoice_id]['cgst'] = $cgst;

                        $inv_all_details[$invoice_id]['sgst'] = $sgst;

                    } else {

                        $inv_all_details[$invoice_id]['quantity'] = $inv_all_details[$invoice_id]['quantity'] + $quantity;

                        $inv_all_details[$invoice_id]['cgst'] = $inv_all_details[$invoice_id]['cgst'] + ($cgst);

                        $inv_all_details[$invoice_id]['sgst'] = $inv_all_details[$invoice_id]['sgst'] + $sgst;

                    }

                }



                $invoiceIds = array_map(function($invoices) {

                    return $invoices['in_id'];

                }, $invoices);



                if (!empty($invoiceIds)) {



                    $invoiceIds = array_unique($invoiceIds);

                    $this->db->where_in($this->erp_invoice . '.id', $invoiceIds);

                } else {

                    $this->db->where($this->erp_invoice . '.id', -1);

                }

            } else {

                $this->db->where($this->erp_invoice . '.id', -1);

            }

        }


        
        if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {

            $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);

        }

        if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

            $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);

        }

        if (!empty($serch_data['sales_man']) && $serch_data['sales_man'] != 'Select') {

            $this->db->where($this->erp_invoice . '.sales_man', $serch_data['sales_man']);

        }

        if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

            $this->db->where($this->erp_invoice_details . '.product_id', $serch_data['product']);

        }

        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

        }elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') = '" . date('Y-m-d'). "'");

        }

        if (!empty($serch_data['firm_id']) && $serch_data['firm_id'] != 'Select') {

            $this->db->where($this->erp_invoice . '.firm_id', $serch_data['firm_id']);

        }else{
             $firms = $this->user_auth->get_user_firms();

            $frim_id = array();

            foreach ($firms as $value) {

                $frim_id[] = $value['firm_id'];

            }

            $this->db->where_in('erp_invoice.firm_id', $frim_id);
        }


        $this->db->where($this->erp_invoice . '.inv_id !=','');



        $this->db->select('customer.id as customer,customer.store_name,customer.tin,customer.state_id, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_quotation.q_no,erp_invoice.total_qty,erp_invoice.tax,erp_quotation.ref_name,erp_invoice.tax_label,'

                . 'erp_invoice.net_total,erp_invoice.created_date,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_sales_man.sales_man_name,erp_invoice.q_id');



       

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->join('erp_sales_man', 'erp_sales_man.id=erp_invoice.sales_man', 'LEFT');

        $this->db->join('erp_invoice_details', 'erp_invoice_details.in_id=erp_invoice.id');

        $this->db->group_by('erp_invoice.id');



        $column_order = array(null, 'erp_invoice.inv_id', 'customer.store_name', 'erp_invoice.total_qty', null, null, 'erp_invoice.subtotal_qty', 'erp_invoice.net_total', null, null, null, null, null, null, null,);

        $column_search = array('customer.store_name', 'erp_invoice.inv_id', 'erp_invoice.net_total', 'customer.advance');

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





        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get('erp_invoice')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            $this->db->where('j_id', intval($val['id']));

            $this->db->where('type', 'invoice');

            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();

            $i++;

        }

        $i2 = 0;

        foreach ($query as $val) {

            $this->db->select('SUM((tax / 100 ) * (per_cost * quantity)) as cgst, SUM((gst / 100 ) * (per_cost * quantity)) as sgst');

            $this->db->where('in_id', intval($val['id']));

            $query[$i2]['erp_invoice_details'] = $this->db->get('erp_invoice_details')->result_array();

            $i2++;

        }

        $j = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date,MAX(created_date) AS paid_date');

            $this->db->where('receipt_bill.receipt_id', $val['id']);

            $query[$j]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();

            $j++;

        }

        if (!empty($inv_all_details) && !empty($query)) {

          //  $query['inv_all_details'] = $inv_all_details;

        }

        return $query;

    }



    public function get_gst_datatables($serch_data) {



        if (!empty($serch_data['from_date']))

            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

        if (!empty($serch_data['to_date']))

            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

        if ($serch_data['from_date'] == '1970-01-01')

            $serch_data['from_date'] = '';

        if ($serch_data['to_date'] == '1970-01-01')

            $serch_data['to_date'] = '';

        $invoiceIds = array();

        if (!empty($serch_data['gst']) && $serch_data['gst'] != '' && $serch_data['gst'] != 'Select') {

            $invoice_ids = array();

            $where_gst = '(erp_invoice_details.tax="' . $serch_data['gst'] . '" OR erp_invoice_details.gst = "' . $serch_data['gst'] . '")';

            //$this->db->select('erp_invoice.id');

            $this->db->select('erp_invoice_details.*');

            $this->db->join('erp_invoice', 'erp_invoice_details.in_id=erp_invoice.id');

            $this->db->join('customer', 'customer.id=erp_invoice.customer');

            $this->db->where($where_gst);

            if (!empty($serch_data['firm_id']) && $serch_data['firm_id'] != 'Select') {

                $this->db->where($this->erp_invoice . '.firm_id', $serch_data['firm_id']);

            } else {

                $firms = $this->user_auth->get_user_firms();

                $frim_id = array();

                foreach ($firms as $value) {

                    $frim_id[] = $value['firm_id'];

                }

                $this->db->where_in('erp_invoice.firm_id', $frim_id);

            }

            if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {

                $this->db->where_in($this->erp_invoice . '.id', implode(',', $serch_data['inv_id']));

            }



            if (!empty($serch_data['cust_type']) && $serch_data['cust_type'] != 'Select') {

                if ($serch_data['cust_type'] == 1) {

                    $this->db->where($this->customer . '.tin IS NOT NULL', null, false);

                } else if ($serch_data['cust_type'] == 2) {

                    $this->db->where($this->customer . '.tin IS NULL');

                }

            }



            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            }



            $invoices = $this->db->get('erp_invoice_details')->result_array();



            $inv_all_details = array();

            $count = 1;

            if (!empty($invoices)) {

                /* Search Particular products in that GST % From the Invoice */

                foreach ($invoices as $invoices_values) {

                    //$cgst = $sgst = $total_gst = 0;

                    $invoice_id = $invoices_values['in_id'];

                    $tax = $invoices_values['tax'];

                    $per_cost = $invoices_values['per_cost'];

                    $quantity = $invoices_values['quantity'];

                    $gst = $invoices_values['gst'];

                    $cgst = ($tax / 100) * ($per_cost * $quantity);

                    $sgst = ($gst / 100) * ($per_cost * $quantity);

                    $total_gst = ($cgst) + ($sgst);

                    $sub_total = ($per_cost * $quantity);

                    if (!isset($inv_all_details[$invoice_id]['quantity'])) {

                        $inv_all_details[$invoice_id]['in_id'] = $invoice_id;

                        $inv_all_details[$invoice_id]['quantity'] = $quantity;

                        $inv_all_details[$invoice_id]['cgst'] = $cgst;

                        $inv_all_details[$invoice_id]['sgst'] = $sgst;

                        $inv_all_details[$invoice_id]['total_gst'] += $total_gst;

                        $inv_all_details[$invoice_id]['sub_total'] += ($per_cost * $quantity);

                    } else {

                        $inv_all_details[$invoice_id]['quantity'] = $inv_all_details[$invoice_id]['quantity'] + $quantity;

                        $inv_all_details[$invoice_id]['cgst'] = $inv_all_details[$invoice_id]['cgst'] + ($cgst);

                        $inv_all_details[$invoice_id]['sgst'] = $inv_all_details[$invoice_id]['sgst'] + $sgst;

                        $inv_all_details[$invoice_id]['total_gst'] += $total_gst;

                        $inv_all_details[$invoice_id]['sub_total'] += ($per_cost * $quantity);

                    }

                }



                $invoiceIds = array_map(function($invoices) {

                    return $invoices['in_id'];

                }, $invoices);



                if (!empty($invoiceIds)) {



                    $invoiceIds = array_unique($invoiceIds);

                    $this->db->where_in($this->erp_invoice . '.id', $invoiceIds);

                } else {

                    $this->db->where($this->erp_invoice . '.id', -1);

                }

            } else {

                $this->db->where($this->erp_invoice . '.id', -1);

            }

        }

        if (!empty($serch_data['firm_id']) && $serch_data['firm_id'] != 'Select') {

            $this->db->where($this->erp_invoice . '.firm_id', $serch_data['firm_id']);

        } else {

            $firms = $this->user_auth->get_user_firms();

            $frim_id = array();

            foreach ($firms as $value) {

                $frim_id[] = $value['firm_id'];

            }

            $this->db->where_in('erp_invoice.firm_id', $frim_id);

        }

        if (!empty($serch_data['cust_type']) && $serch_data['cust_type'] != 'Select') {

            if ($serch_data['cust_type'] == 1) {

                $this->db->where($this->customer . '.tin IS NULL');

//                $this->db->where($this->customer . '.tin IS NOT NULL', null, false);

            } else if ($serch_data['cust_type'] == 2) {

                $this->db->where($this->customer . '.tin IS NOT NULL', null, false);

//                $this->db->where($this->customer . '.tin IS NULL');

            }

        }

        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

        }



        $this->db->select('customer.id as customer,customer.store_name,customer.tin,customer.state_id, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_quotation.q_no,erp_invoice.total_qty,erp_invoice.tax,erp_quotation.ref_name,erp_invoice.tax_label,'

                . 'erp_invoice.net_total,erp_invoice.created_date,'

                . 'erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,'

                . 'erp_sales_man.sales_man_name,erp_invoice.q_id,erp_manage_firms.gstin,erp_manage_firms.firm_name');



        $this->db->where('erp_invoice.subtotal_qty !=', 0);

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_invoice.firm_id');

        $this->db->join('erp_sales_man', 'erp_sales_man.id=erp_invoice.sales_man', 'LEFT');

        $this->db->join('erp_invoice_details', 'erp_invoice_details.in_id=erp_invoice.id');

        $this->db->group_by('erp_invoice.id');



        $column_order = array(null, 'erp_invoice.inv_id', 'customer.store_name', 'erp_invoice.total_qty', null, null, 'erp_invoice.subtotal_qty', 'erp_invoice.net_total', null, null, null, null, null, null, null,);

        $column_search = array('customer.store_name', 'erp_invoice.inv_id', 'erp_invoice.net_total', 'customer.advance');

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





        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get('erp_invoice')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            $this->db->where('j_id', intval($val['id']));

            $this->db->where('type', 'invoice');

            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();

            $i++;

        }

        $i2 = 0;

        foreach ($query as $val) {

            $this->db->select('SUM((tax / 100 ) * (per_cost * quantity)) as cgst, SUM((gst / 100 ) * (per_cost * quantity)) as sgst');

            $this->db->where('in_id', intval($val['id']));

            $query[$i2]['erp_invoice_details'] = $this->db->get('erp_invoice_details')->result_array();

            $i2++;

        }

        $j = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date,MAX(created_date) AS paid_date');

            $this->db->where('receipt_bill.receipt_id', $val['id']);

            $query[$j]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();

            $j++;

        }

        if (!empty($inv_all_details) && !empty($query)) {

            //$query['inv_all_details'] = $inv_all_details;

        }

        return $query;

    }



    function get_hr_invoice_datatables($search_data) {



        $this->_get_hr_invoice_datatables_query($search_data);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get('erp_invoice')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            $this->db->where('j_id', intval($val['id']));

            $this->db->where('type', 'invoice');

            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();

            $i++;

        }



        return $query;

    }



    public function get_invoice($serch_data) {

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

            $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);

        }

        if (!empty($serch_data['sales_man']) && $serch_data['sales_man'] != 'Select') {

            $this->db->where($this->erp_invoice . '.sales_man', $serch_data['sales_man']);

        }

        if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

            $this->db->where($this->erp_invoice_details . '.product_id', $serch_data['product']);

        }



        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

        }



        $this->db->select('customer.id as customer,customer.store_name,customer.tin, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_quotation.q_no,erp_invoice.total_qty,erp_invoice.tax,erp_quotation.ref_name,erp_invoice.tax_label,'

                . 'erp_invoice.net_total,erp_invoice.created_date,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_sales_man.sales_man_name');

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        $customer = array('7', '8');

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->join('erp_sales_man', 'erp_sales_man.id=erp_invoice.sales_man', 'LEFT');

        $this->db->join('erp_invoice_details', 'erp_invoice_details.in_id=erp_invoice.id');

        $this->db->where_in('customer.customer_type', $customer);

        $query = $this->db->get('erp_invoice')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            $this->db->where('j_id', intval($val['id']));

            $this->db->where('type', 'invoice');

            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();

            $i++;

        }

        return $query;

    }



    public function get_all_hr_customer_invoice() {

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        $customer = array('7', '8');

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->select('customer.store_name,customer.id');

        $this->db->where($this->customer . '.status', 1);

        $this->db->join('erp_invoice', 'erp_invoice.customer=customer.id');

        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        $this->db->where_in('customer.customer_type', $customer);

        $this->db->group_by('erp_invoice.customer');

        $query = $this->db->get($this->customer)->result_array();

        return $query;

    }



    public function get_all_product_invoice() {

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->select('erp_product.product_name,erp_product.id as product_id');

        $this->db->where($this->erp_product . '.status', 1);

        $this->db->join('erp_invoice_details', 'erp_invoice_details.product_id = erp_product.id');

        $this->db->where_in('erp_product.firm_id', $frim_id);

        $this->db->group_by('erp_invoice_details.product_id');

        $query = $this->db->get($this->erp_product)->result_array();



        return $query;

    }

    public function get_all_firms(){
         $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->select('firm_id,firm_name');

        $this->db->where('erp_manage_firms.status', 1);

        $this->db->where_in('erp_manage_firms.firm_id', $frim_id);

        $query = $this->db->get('erp_manage_firms')->result_array();

        return $query;
    

    }

        public function get_all_customers(){

         $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->select('id,store_name as customer_name');

        $this->db->where('customer.status', 1);

        $this->db->where_in('customer.firm_id', $frim_id);

        $query = $this->db->get('customer')->result_array();

        return $query;
    

    }

    public function get_all_products(){

         $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->select('id,product_name');

        $this->db->where('erp_product.status', 1);

        $this->db->where_in('erp_product.firm_id', $frim_id);

        $query = $this->db->get('erp_product')->result_array();

        return $query;
    

    }



    public function get_all_expired_product($serch_data = array()) {



        if (!empty($serch_data['from_date']))

            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

        if (!empty($serch_data['to_date']))

            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

        if ($serch_data['from_date'] == '1970-01-01')

            $serch_data['from_date'] = '';

        if ($serch_data['to_date'] == '1970-01-01')

            $serch_data['to_date'] = '';



        if (!empty($serch_data['firm']) && $serch_data['firm'] != 'Select') {



            $this->db->where($this->erp_product . '.firm_id', $serch_data['firm']);

        }

        if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

            $this->db->where($this->erp_product . '.id', $serch_data['product']);

        }

        if (!empty($serch_data['category']) && $serch_data['category'] != 'Select') {

            $this->db->where($this->erp_product . '.category_id', $serch_data['category']);

        }



        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_product . ".expired_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_product . ".expired_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_product . ".expired_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_product . ".expired_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

        }

        $date = date('Y-m-d');

        $this->db->select($this->erp_product . '.*');

        $this->db->where($this->erp_product . ".expired_date != 0000-00-00");

        $this->db->where("DATE_FORMAT(" . $this->erp_product . ".expired_date,'%Y-%m-%d') <='" . $date . "'");

        $query = $this->db->get($this->erp_product)->result_array();

        return $query;

    }



    public function get_customer_details($search_data = array()) {



        if (!empty($search_data['firm'])) {

            $this->db->where($this->customer . ".firm_id", $search_data['firm']);

        }

        if (!empty($search_data['cust_type']) && $search_data['cust_type'] != 9) {

            $this->db->where_in($this->customer . ".customer_type", $search_data['cust_type']);

        }

        if (!empty($search_data['cust_reg']) && $search_data['cust_reg'] != 'both') {

            $this->db->where($this->customer . ".customer_region", $search_data['cust_reg']);

        }



        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }



        $this->db->distinct('customer.id');

        //$this->db->select('payment_report.firm_id');

        $this->db->select('payment_report.balance,payment_report.customer,payment_report.inv_id');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance,customer.id');

        $this->db->join('payment_report', 'payment_report.customer=customer.id');

        $this->db->where("payment_report.balance >", 0.1);

        $this->db->group_by("payment_report.customer");

        //$this->db->join('customer', 'customer.id=payment_report.customer', 'left');

        //$this->db->where('customer.id', 2); // AARUMUGANERI ABDULLAH OWN

        //$this->db->where('customer.id', 762); // ALTHAF TOTAL 9894691587

        //$this->db->where('customer.id', 861); // Irsath bai, Aasath street

        //$this->db->where('customer.id', 543); // Basheer

        //$this->db->where('customer.id', 1);

        //$this->db->where('customer.id', 788);



        $this->db->from('customer');



        //$this->db->where_in('payment_report.firm_id', $frim_id);

        $query = $this->db->get()->result_array();



        /*

          echo $this->db->last_query();

          echo "<pre>";

          print_r($query);

          exit; */



        $i = 0;

        foreach ($query as $val) {



            $due_date = date('Y-m-d');

            $seven_date = date('Y-m-d', strtotime("-6 day", strtotime($due_date)));

            $seven_date1 = date('Y-m-d', strtotime("-7 day", strtotime($due_date)));

            $thirty_date = date('Y-m-d', strtotime("-29 day", strtotime($due_date)));

            $thirty_date1 = date('Y-m-d', strtotime("-30 day", strtotime($due_date)));

            $ninty_date = date('Y-m-d', strtotime("-89 day", strtotime($due_date)));



            //$this->db->select('*');

            $this->db->select('*, SUM(balance) as new_balance');

            $this->db->where("DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') >='" . $seven_date . "' AND DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') <= '" . $due_date . "'");

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id !=', 'Wings Invoice');

            $this->db->where('payment_report.balance >', 0.1);

            $this->db->where_in('payment_report.firm_id', $frim_id);

            $this->db->group_by('payment_report.customer');

            $this->db->from('payment_report');

            $query[$i]['days'] = $this->db->get()->result_array();



            //$this->db->select('*');

            $this->db->select('*, SUM(balance) as new_balance');

            $this->db->where("DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') >='" . $thirty_date . "' AND DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') <= '" . $seven_date1 . "'");

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id !=', 'Wings Invoice');

            $this->db->where('payment_report.balance >', 0.1);

            $this->db->where_in('payment_report.firm_id', $frim_id);

            $this->db->group_by('payment_report.customer');

            $this->db->from('payment_report');

            $query[$i]['sevendays'] = $this->db->get()->result_array();



            //$this->db->select('*');

            $this->db->select('*, SUM(balance) as new_balance');

            $this->db->where("DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') >='" . $ninty_date . "' AND DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') <= '" . $thirty_date1 . "'");

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id !=', 'Wings Invoice');

            $this->db->where_in('payment_report.firm_id', $frim_id);

            $this->db->group_by('payment_report.customer');

            $this->db->from('payment_report');

            $query[$i]['thirtydays'] = $this->db->get()->result_array();



            //$this->db->select('*');

            $this->db->select('*, SUM(balance) as new_balance');

            $this->db->where("DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') <'" . $ninty_date . "'");

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id !=', 'Wings Invoice');

            $this->db->where('payment_report.balance >', 0.1);

            $this->db->where_in('payment_report.firm_id', $frim_id);

            $this->db->group_by('payment_report.customer');

            $this->db->from('payment_report');

            $query[$i]['nintydays'] = $this->db->get()->result_array();





            //$this->db->select('*');

            $this->db->select('*, SUM(balance) as new_balance');

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id', 'Wings Invoice');

            $this->db->where('payment_report.balance >', 0.1);

            $this->db->where_in('payment_report.firm_id', $frim_id);

            $this->db->group_by('payment_report.customer');

            $query[$i]['rec'] = $this->db->get('payment_report')->result_array();







            $i++;

        }



        //exit;

        /*

          $j = 0;

          foreach ($query as $val) {

          $this->db->select('SUM(balance) AS balance');

          $this->db->where('payment_report.customer', $val['id']);

          $this->db->where('payment_report.firm_id', $val['firm_id']);

          $this->db->where('payment_report.inv_id', 'Wings Invoice');

          $query[$j]['rec'] = $this->db->get('payment_report')->result_array();

          //echo $this->db->last_query() . '<br />';

          $j++;

          }



         */

        /*

          echo "<pre>";

          print_r($query);

          exit; */

        return $query;

    }



    public function get_customer_details1($search_data = array()) {



        if (!empty($search_data['firm'])) {

            $this->db->where($this->payment_report . ".firm_id", $search_data['firm']);

        }

        if (!empty($search_data['cust_type']) && $search_data['cust_type'] != 9) {

            $this->db->where_in($this->payment_report . ".customer_type", $search_data['cust_type']);

        }

        if (!empty($search_data['cust_reg']) && $search_data['cust_reg'] != 'both') {

            $this->db->where($this->payment_report . ".customer_region", $search_data['cust_reg']);

        }



        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }



        $this->db->distinct('payment_report.customer');

        //$this->db->select('payment_report.firm_id');

        $this->db->select('payment_report.*');

        $this->db->from('payment_report');

        $query = $this->db->get()->result_array();

        echo $this->db->last_query();

        exit;

        $i = 0;

        foreach ($query as $val) {



            $due_date = date('Y-m-d');

            $seven_date = date('Y-m-d', strtotime("-6 day", strtotime($due_date)));

            $seven_date1 = date('Y-m-d', strtotime("-7 day", strtotime($due_date)));

            $thirty_date = date('Y-m-d', strtotime("-29 day", strtotime($due_date)));

            $thirty_date1 = date('Y-m-d', strtotime("-30 day", strtotime($due_date)));

            $ninty_date = date('Y-m-d', strtotime("-89 day", strtotime($due_date)));



            //$this->db->select('*');

            $this->db->select('*, SUM(balance) as new_balance');

            $this->db->where("DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') >='" . $seven_date . "' AND DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') <= '" . $due_date . "'");

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id !=', 'Wings Invoice');

            $this->db->where_in('payment_report.firm_id', $frim_id);

            $this->db->group_by('payment_report.customer');

            $this->db->from('payment_report');

            $query[$i]['days'] = $this->db->get()->result_array();



            //$this->db->select('*');

            $this->db->select('*, SUM(balance) as new_balance');

            $this->db->where("DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') >='" . $thirty_date . "' AND DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') <= '" . $seven_date1 . "'");

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id !=', 'Wings Invoice');

            $this->db->where_in('payment_report.firm_id', $frim_id);

            $this->db->group_by('payment_report.customer');

            $this->db->from('payment_report');

            $query[$i]['sevendays'] = $this->db->get()->result_array();



            //$this->db->select('*');

            $this->db->select('*, SUM(balance) as new_balance');

            $this->db->where("DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') >='" . $ninty_date . "' AND DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') <= '" . $thirty_date1 . "'");

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id !=', 'Wings Invoice');

            $this->db->where_in('payment_report.firm_id', $frim_id);

            $this->db->group_by('payment_report.customer');

            $this->db->from('payment_report');

            $query[$i]['thirtydays'] = $this->db->get()->result_array();



            //$this->db->select('*');

            $this->db->select('*, SUM(balance) as new_balance');

            $this->db->where("DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') <'" . $ninty_date . "'");

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id !=', 'Wings Invoice');

            $this->db->where_in('payment_report.firm_id', $frim_id);

            $this->db->group_by('payment_report.customer');

            $this->db->from('payment_report');

            $query[$i]['nintydays'] = $this->db->get()->result_array();





            //$this->db->select('*');

            $this->db->select('*, SUM(balance) as new_balance');

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id', 'Wings Invoice');

            $this->db->where_in('payment_report.firm_id', $frim_id);

            $this->db->group_by('payment_report.customer');

            $query[$i]['rec'] = $this->db->get('payment_report')->result_array();







            $i++;

        }

        return $query;

    }



    public function get_customer_details_firm_wise($search_data = array()) {



        $this->db->select('erp_invoice.*');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance');

        if (!empty($search_data['cust_type']) && $search_data['cust_type'] != 9) {

            $this->db->where_in($this->customer . ".customer_type", $search_data['cust_type']);

        }

        if (!empty($search_data['cust_reg']) && $search_data['cust_reg'] != 'both') {

            $this->db->where($this->customer . ".customer_region", $search_data['cust_reg']);

        }

        if (!empty($search_data['due_date']) && $search_data['due_date'] == 6) {

            $this->db->where("erp_invoice.inv_id", 'Wings Invoice');

        }

        if (!empty($search_data['due_date']) && $search_data['due_date'] != 6 && $search_data['due_date'] != 5) {

            $this->db->where("erp_invoice.inv_id !=", 'Wings Invoice');

        }

        $this->db->order_by('erp_invoice.id', 'desc');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');



        $this->db->where("payment_status ", 'Pending');

        $this->db->where('erp_invoice.net_total >', 0);

        $query = $this->db->get('erp_invoice')->result_array();



        $i = 0;

        foreach ($query as $duedate) {

            $due_date = $duedate['credit_due_date'];

            $seven_date = date('Y-m-d', strtotime("+7 day", strtotime($duedate['credit_due_date'])));

            $thirty_date = date('Y-m-d', strtotime("+30 day", strtotime($duedate['credit_due_date'])));

            $ninty_date = date('Y-m-d', strtotime("+90 day", strtotime($duedate['credit_due_date'])));

            if ($duedate['firm_id'] == 1) {

                $this->db->select('SUM(bill_amount) AS total_bill_amount,SUM(discount) AS receipt_discount');

                if (!empty($search_data['due_date']) && $search_data['due_date'] != 5 && $search_data['due_date'] != 6) {

                    if ($search_data['due_date'] == 1)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($due_date)) . '" and "' . date('Y-m-d', strtotime($seven_date)) . '"');

                    else if ($search_data['due_date'] == 2)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($seven_date)) . '" and "' . date('Y-m-d', strtotime($thirty_date)) . '"');

                    else if ($search_data['due_date'] == 3)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($thirty_date)) . '" and "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                    else if ($search_data['due_date'] == 4)

                        $this->db->where('created_date >= "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                }

                $this->db->where("receipt_id ", $duedate['id']);

                $electricals = $this->db->get($this->receipt_bill)->result_array();

                $query[$i]['electricals'] = ($electricals[0]['total_bill_amount'] + $electricals[0]['receipt_discount']);

            }

            if ($duedate['firm_id'] == 2) {

                $this->db->select('SUM(bill_amount) AS total_bill_amount,SUM(discount) AS receipt_discount');

                if (!empty($search_data['due_date']) && $search_data['due_date'] != 5 && $search_data['due_date'] != 6) {

                    if ($search_data['due_date'] == 1)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($due_date)) . '" and "' . date('Y-m-d', strtotime($seven_date)) . '"');

                    else if ($search_data['due_date'] == 2)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($seven_date)) . '" and "' . date('Y-m-d', strtotime($thirty_date)) . '"');

                    else if ($search_data['due_date'] == 3)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($thirty_date)) . '" and "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                    else if ($search_data['due_date'] == 4)

                        $this->db->where('created_date >= "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                }

                $this->db->where("receipt_id ", $duedate['id']);

                $paints = $this->db->get($this->receipt_bill)->result_array();

                $query[$i]['paints'] = ($paints[0]['total_bill_amount'] + $paints[0]['receipt_discount']);

            }

            if ($duedate['firm_id'] == 3) {

                $this->db->select('SUM(bill_amount) AS total_bill_amount,SUM(discount) AS receipt_discount');

                if (!empty($search_data['due_date']) && $search_data['due_date'] != 5 && $search_data['due_date'] != 6) {

                    if ($search_data['due_date'] == 1)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($due_date)) . '" and "' . date('Y-m-d', strtotime($seven_date)) . '"');

                    else if ($search_data['due_date'] == 2)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($seven_date)) . '" and "' . date('Y-m-d', strtotime($thirty_date)) . '"');

                    else if ($search_data['due_date'] == 3)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($thirty_date)) . '" and "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                    else if ($search_data['due_date'] == 4)

                        $this->db->where('created_date >= "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                }

                $this->db->where("receipt_id ", $duedate['id']);

                $tiles = $this->db->get($this->receipt_bill)->result_array();

                $query[$i]['tiles'] = ($tiles[0]['total_bill_amount'] + $tiles[0]['receipt_discount']);

            }

            if ($duedate['firm_id'] == 4) {

                $this->db->select('SUM(bill_amount) AS total_bill_amount,SUM(discount) AS receipt_discount');

                if (!empty($search_data['due_date']) && $search_data['due_date'] != 5 && $search_data['due_date'] != 6) {

                    if ($search_data['due_date'] = 1)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($due_date)) . '" and "' . date('Y-m-d', strtotime($seven_date)) . '"');

                    else if ($search_data['due_date'] = 2)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($seven_date)) . '" and "' . date('Y-m-d', strtotime($thirty_date)) . '"');

                    else if ($search_data['due_date'] = 3)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($thirty_date)) . '" and "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                    else if ($search_data['due_date'] = 4)

                        $this->db->where('created_date >= "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                }

                $this->db->where("receipt_id ", $duedate['id']);

                $hardware = $this->db->get($this->receipt_bill)->result_array();

                $query[$i]['hardware'] = ($hardware[0]['total_bill_amount'] + $hardware[0]['receipt_discount']);

            }

            $query[$i]['net_amount'] = $query[$i]['electricals'] + $query[$i]['paints'] + $query[$i]['tiles'] + $query[$i]['hardware'];



            $i++;



            //echo $this->db->last_query() . '<br />';

        }

//        echo $this->db->last_query();

        //echo "<pre>";

        //print_r($query);

        //exit;



        return $query;

    }



    public function get_all_customer() {



        $this->db->select('erp_invoice.customer');

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

        $this->db->group_by('erp_invoice.customer');

        $query = $this->db->get('erp_invoice')->result_array();



        return $query;

    }



    public function outstanding_report($serch_data = NULL) {



        if (isset($serch_data) && !empty($serch_data)) {



            if (!empty($serch_data['firm']) && $serch_data['firm'] != 'Select') {



                $this->db->where($this->erp_invoice . '.firm_id', $serch_data['firm']);

            }

            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

                $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);

            }

        }



        $this->db->distinct('customer.id');

        $this->db->select('erp_invoice.firm_id');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance,customer.id');

        $this->db->join('customer', 'customer.id=erp_invoice.customer', 'left');

        $this->db->from($this->erp_invoice);



        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        $this->db->where('erp_invoice.net_total >', 0);

        $query = $this->db->get()->result_array();



        // print_r($this->db->last_query());



        $i = $j = 0;

        if (!empty($query)) {

            foreach ($query as $value) {

                $this->db->distinct();

                $this->db->select('erp_invoice.net_total AS net_total');

                //$this->db->select('SUM(receipt_bill.discount) AS receipt_discount,SUM(receipt_bill.bill_amount) AS receipt_paid,MAX(receipt_bill.due_date) AS next_date,MAX(receipt_bill.created_date) AS paid_date');

                $this->db->where('erp_invoice.inv_id !=', 'Wings Invoice');

                $this->db->where('erp_invoice.customer', $value['id']);

                $this->db->where('erp_invoice.firm_id', $value['firm_id']);

                $this->db->where_in('erp_invoice.contract_customer', 0);

                $this->db->join('receipt_bill', 'receipt_bill.receipt_id=erp_invoice.id', 'left');

                $sub_query = $this->db->get('erp_invoice')->result_array();

                $invoice_net_total = 0;

                if (!empty($sub_query)) {

                    foreach ($sub_query as $total) {

                        $invoice_net_total += $total['net_total'];

                    }

                }

                //'$result_arr[$j]['invoice_net'][] = $invoice_net_total;

                if (isset($query[$j]['invoice_net_total']))

                    $query[$j]['invoice_net_total'] += $invoice_net_total;

                else

                    $query[$j]['invoice_net_total'] = $invoice_net_total;

                $j++;

            }

        }

        foreach ($query as $val) {

            $this->db->select('erp_invoice.net_total');

            $this->db->select('SUM(erp_invoice.net_total) AS net_total, MAX(erp_invoice.created_date) AS created_date');

            $this->db->select('SUM(receipt_bill.discount) AS receipt_discount,SUM(receipt_bill.bill_amount) AS receipt_paid,MAX(receipt_bill.due_date) AS next_date,MAX(receipt_bill.created_date) AS paid_date');

            $this->db->where('erp_invoice.inv_id !=', 'Wings Invoice');

            $this->db->where('erp_invoice.customer', $val['id']);

            $this->db->where('erp_invoice.firm_id', $val['firm_id']);

            $this->db->where_in('erp_invoice.contract_customer', 0);

            $this->db->join('receipt_bill', 'receipt_bill.receipt_id=erp_invoice.id', 'left');

            $query[$i]['receipt_bill'] = $this->db->get('erp_invoice')->result_array();



            $i++;

        }



//        echo '<pre>';

//        print_r($query);

//        exit;

        return $query;

    }



    public function get_all_supplier() {

        $this->db->distinct('customer.id');

        $this->db->select('erp_invoice.firm_id');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance,customer.id');

        $this->db->join('customer', 'customer.id=erp_invoice.customer', 'left');

        $this->db->group_by('customer.store_name');

        $this->db->from($this->erp_invoice);



        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        $query = $this->db->get()->result_array();

        return $query;

    }



    function get_all_gstvalues() {

        $gst_values = array();

        $this->db->select('erp_invoice_details.tax, erp_invoice_details.gst');

        $this->db->distinct('erp_invoice_details.tax, erp_invoice_details.gst');

        $invoice_details_query = $this->db->get($this->erp_invoice_details)->result_array();

        if (!empty($invoice_details_query)) {

            foreach ($invoice_details_query as $value) {



                if (!in_array($value['tax'], $gst_values)) {

                    array_push($gst_values, $value['tax']);

                }

                if (!in_array($value['gst'], $gst_values)) {

                    array_push($gst_values, $value['gst']);

                }

            }

            $gst_values = array_filter($gst_values);

        }

        // echo "<pre>";

        //  print_r($gst_values);

        //  exit;

        $this->db->select('erp_product.cgst, erp_product.sgst');

        $this->db->distinct('erp_product.cgst, erp_product.sgst');

        $product_query = $this->db->get($this->erp_product)->result_array();

        if (!empty($product_query)) {

            foreach ($product_query as $value) {



                if (!in_array($value['cgst'], $gst_values)) {

                    array_push($gst_values, $value['cgst']);

                }

                if (!in_array($value['sgst'], $gst_values)) {

                    array_push($gst_values, $value['sgst']);

                }

            }

            $gst_values = array_filter($gst_values);

        }

        //echo "<pre>";

        //print_r($gst_values);

        //exit;

        return $gst_values;

    }



    public function get_all_product() {

        $productIds = array();

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }



        $this->db->select('DISTINCT(product_id)');

        $product_query = $this->db->get('erp_invoice_details')->result_array();



        $productIds = array_map(function($product_query) {

            return $product_query['product_id'];

        }, $product_query);

        if (!empty($productIds))

            $this->db->where_in('id', $productIds);



        $this->db->where_in('erp_product.firm_id', $frim_id);

        $query = $this->db->get($this->erp_product)->result_array();



        return $query;

    }



    public function get_all_invoice() {

        $this->db->select('customer.id as customer,customer.store_name,customer.tin,customer.state_id, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_quotation.q_no,erp_invoice.total_qty,erp_invoice.tax,erp_quotation.ref_name,erp_invoice.tax_label,'

                . 'erp_invoice.net_total,erp_invoice.created_date,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_sales_man.sales_man_name,erp_invoice.q_id');



        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        //if (empty($serch_data)) {

        //  $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%m') = '" . date('m') . "'");

        //}

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->join('erp_sales_man', 'erp_sales_man.id=erp_invoice.sales_man', 'LEFT');

        $this->db->join('erp_invoice_details', 'erp_invoice_details.in_id=erp_invoice.id');

        $this->db->group_by('erp_invoice.id');



        $query = $this->db->get('erp_invoice')->result_array();

        return $query;

    }



    function count_all_pay_outstanding() {

        $this->_get_payment_datatables_query();

        $this->db->from('erp_invoice');

        return $this->db->count_all_results();

    }



    function count_filtered_pay_outstanding() {

        $this->_get_payment_datatables_query();

        $query = $this->db->get('erp_invoice');

        return $query->num_rows();

    }



    function count_all_outstanding_duedate() {

        $this->_get_outstanding_duedate_datatables_query();

        $this->db->from('customer');

        return $this->db->count_all_results();

    }



    function count_filtered_outstanding_duedate() {

        $this->_get_outstanding_duedate_datatables_query();

        $query = $this->db->get('customer');

        return $query->num_rows();

    }



    function count_all_outstanding_firmwise() {

        $this->_get_outstanding_datatables_query();

        $this->db->from('erp_invoice');

        return $this->db->count_all_results();

    }



    function count_filtered_outstanding_firmwise() {

        $this->_get_outstanding_datatables_query();

        $query = $this->db->get('erp_invoice');

        return $query->num_rows();

    }



    public function count_all_customer() {

        $this->db->from('erp_invoice');

        return $this->db->count_all_results();

    }



    public function count_filtered_customer($serch_data) {

        $this->db->distinct();

        $this->db->select('erp_invoice.*');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance');

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->where_in('erp_invoice.contract_customer', 0);

        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        // $this->db->where('erp_invoice.net_total >', 0);

        if (!empty($serch_data['overdue']) && $serch_data['overdue'] != '' && $serch_data['overdue'] == 3) {

            $this->db->where('customer.advance >', 0);

        }

        //$this->db->order_by('erp_invoice.id', 'desc');

        $this->db->join('customer', 'customer.id=erp_invoice.customer', 'LEFT');

        $this->db->join('erp_invoice_details', 'erp_invoice.id=erp_invoice_details.in_id', 'LEFT');

        //  $this->db->where('customer', 164);



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



                $this->db->where('erp_invoice.inv_id', $serch_data['inv_id']);

            }

            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

                $this->db->where('customer.id', $serch_data['customer']);

            }



            if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

                $this->db->where('erp_invoice_details.product_id', $serch_data['product']);

            }



            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            }

        }

        $query = $this->db->get('erp_invoice');

        return $query->num_rows();

    }



    public function count_all_invoice() {

        $this->db->from('erp_invoice');

        return $this->db->count_all_results();

    }



    public function count_filtered_invoice($serch_data) {

        if (!empty($serch_data['from_date']))

            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

        if (!empty($serch_data['to_date']))

            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

        if ($serch_data['from_date'] == '1970-01-01')

            $serch_data['from_date'] = '';

        if ($serch_data['to_date'] == '1970-01-01')

            $serch_data['to_date'] = '';

        $invoiceIds = array();

        if (!empty($serch_data['gst']) && $serch_data['gst'] != '' && $serch_data['gst'] != 'Select') {

            $invoice_ids = array();

            $where_gst = '(erp_invoice_details.tax="' . $serch_data['gst'] . '" OR erp_invoice_details.gst = "' . $serch_data['gst'] . '")';

            //$this->db->select('erp_invoice.id');

            $this->db->select('erp_invoice_details.*');

            $this->db->join('erp_invoice', 'erp_invoice_details.in_id=erp_invoice.id');

            $this->db->where($where_gst);

            if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {

                $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);

            }

            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

                $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);

            }

            if (!empty($serch_data['sales_man']) && $serch_data['sales_man'] != 'Select') {

                $this->db->where($this->erp_invoice . '.sales_man', $serch_data['sales_man']);

            }

            if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

                $this->db->where($this->erp_invoice_details . '.product_id', $serch_data['product']);

            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            }



            $invoices = $this->db->get('erp_invoice_details')->result_array();



            $inv_all_details = array();

            $count = 1;

            if (!empty($invoices)) {

                /* Search Particular products in that GST % From the Invoice */

                foreach ($invoices as $invoices_values) {

                    $invoice_id = $invoices_values['in_id'];

                    $tax = $invoices_values['tax'];

                    $per_cost = $invoices_values['per_cost'];

                    $quantity = $invoices_values['quantity'];

                    $gst = $invoices_values['gst'];

                    $cgst = ($tax / 100) * ($per_cost * $quantity);

                    $sgst = ($gst / 100) * ($per_cost * $quantity);

                    if (!isset($inv_all_details[$invoice_id]['quantity'])) {

                        $inv_all_details[$invoice_id]['in_id'] = $invoice_id;

                        $inv_all_details[$invoice_id]['quantity'] = $quantity;

                        $inv_all_details[$invoice_id]['cgst'] = $cgst;

                        $inv_all_details[$invoice_id]['sgst'] = $sgst;

                    } else {

                        $inv_all_details[$invoice_id]['quantity'] = $inv_all_details[$invoice_id]['quantity'] + $quantity;

                        $inv_all_details[$invoice_id]['cgst'] = $inv_all_details[$invoice_id]['cgst'] + ($cgst);

                        $inv_all_details[$invoice_id]['sgst'] = $inv_all_details[$invoice_id]['sgst'] + $sgst;

                    }

                }



                $invoiceIds = array_map(function($invoices) {

                    return $invoices['in_id'];

                }, $invoices);



                if (!empty($invoiceIds)) {



                    $invoiceIds = array_unique($invoiceIds);

                    $this->db->where_in($this->erp_invoice . '.id', $invoiceIds);

                } else {

                    $this->db->where($this->erp_invoice . '.id', -1);

                }

            } else {

                $this->db->where($this->erp_invoice . '.id', -1);

            }

        }



        if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {

            $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);

        }

        if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

            $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);

        }

        if (!empty($serch_data['sales_man']) && $serch_data['sales_man'] != 'Select') {

            $this->db->where($this->erp_invoice . '.sales_man', $serch_data['sales_man']);

        }

        if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

            $this->db->where($this->erp_invoice_details . '.product_id', $serch_data['product']);

        }

        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

        }



        $this->db->select('customer.id as customer,customer.store_name,customer.tin,customer.state_id, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_quotation.q_no,erp_invoice.total_qty,erp_invoice.tax,erp_quotation.ref_name,erp_invoice.tax_label,'

                . 'erp_invoice.net_total,erp_invoice.created_date,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_sales_man.sales_man_name,erp_invoice.q_id');



        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->join('erp_sales_man', 'erp_sales_man.id=erp_invoice.sales_man', 'LEFT');

        $this->db->join('erp_invoice_details', 'erp_invoice_details.in_id=erp_invoice.id');

        $this->db->group_by('erp_invoice.id');

        $query = $this->db->get('erp_invoice');

        return $query->num_rows();

    }



    public function count_all_gst() {

        $this->db->from('erp_invoice');

        return $this->db->count_all_results();

    }



    public function count_filtered_gst() {

        if (!empty($serch_data['from_date']))

            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

        if (!empty($serch_data['to_date']))

            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

        if ($serch_data['from_date'] == '1970-01-01')

            $serch_data['from_date'] = '';

        if ($serch_data['to_date'] == '1970-01-01')

            $serch_data['to_date'] = '';

        $invoiceIds = array();

        if (!empty($serch_data['gst']) && $serch_data['gst'] != '' && $serch_data['gst'] != 'Select') {

            $invoice_ids = array();

            $where_gst = '(erp_invoice_details.tax="' . $serch_data['gst'] . '" OR erp_invoice_details.gst = "' . $serch_data['gst'] . '")';

            //$this->db->select('erp_invoice.id');

            $this->db->select('erp_invoice_details.*');

            $this->db->join('erp_invoice', 'erp_invoice_details.in_id=erp_invoice.id');

            $this->db->join('customer', 'customer.id=erp_invoice.customer');

            $this->db->where($where_gst);

            if (!empty($serch_data['firm_id']) && $serch_data['firm_id'] != 'Select') {

                $this->db->where($this->erp_invoice . '.firm_id', $serch_data['firm_id']);

            } else {

                $firms = $this->user_auth->get_user_firms();

                $frim_id = array();

                foreach ($firms as $value) {

                    $frim_id[] = $value['firm_id'];

                }

                $this->db->where_in('erp_invoice.firm_id', $frim_id);

            }

            if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {

                $this->db->where_in($this->erp_invoice . '.id', implode(',', $serch_data['inv_id']));

            }



            if (!empty($serch_data['cust_type']) && $serch_data['cust_type'] != 'Select') {

                if ($serch_data['cust_type'] == 1) {

                    $this->db->where($this->customer . '.tin IS NOT NULL', null, false);

                } else if ($serch_data['cust_type'] == 2) {

                    $this->db->where($this->customer . '.tin IS NULL');

                }

            }



            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            }



            $invoices = $this->db->get('erp_invoice_details')->result_array();



            $inv_all_details = array();

            $count = 1;

            if (!empty($invoices)) {

                /* Search Particular products in that GST % From the Invoice */

                foreach ($invoices as $invoices_values) {

                    //$cgst = $sgst = $total_gst = 0;

                    $invoice_id = $invoices_values['in_id'];

                    $tax = $invoices_values['tax'];

                    $per_cost = $invoices_values['per_cost'];

                    $quantity = $invoices_values['quantity'];

                    $gst = $invoices_values['gst'];

                    $cgst = ($tax / 100) * ($per_cost * $quantity);

                    $sgst = ($gst / 100) * ($per_cost * $quantity);

                    $total_gst = ($cgst) + ($sgst);

                    $sub_total = ($per_cost * $quantity);

                    if (!isset($inv_all_details[$invoice_id]['quantity'])) {

                        $inv_all_details[$invoice_id]['in_id'] = $invoice_id;

                        $inv_all_details[$invoice_id]['quantity'] = $quantity;

                        $inv_all_details[$invoice_id]['cgst'] = $cgst;

                        $inv_all_details[$invoice_id]['sgst'] = $sgst;

                        $inv_all_details[$invoice_id]['total_gst'] += $total_gst;

                        $inv_all_details[$invoice_id]['sub_total'] += ($per_cost * $quantity);

                    } else {

                        $inv_all_details[$invoice_id]['quantity'] = $inv_all_details[$invoice_id]['quantity'] + $quantity;

                        $inv_all_details[$invoice_id]['cgst'] = $inv_all_details[$invoice_id]['cgst'] + ($cgst);

                        $inv_all_details[$invoice_id]['sgst'] = $inv_all_details[$invoice_id]['sgst'] + $sgst;

                        $inv_all_details[$invoice_id]['total_gst'] += $total_gst;

                        $inv_all_details[$invoice_id]['sub_total'] += ($per_cost * $quantity);

                    }

                }



                $invoiceIds = array_map(function($invoices) {

                    return $invoices['in_id'];

                }, $invoices);



                if (!empty($invoiceIds)) {



                    $invoiceIds = array_unique($invoiceIds);

                    $this->db->where_in($this->erp_invoice . '.id', $invoiceIds);

                } else {

                    $this->db->where($this->erp_invoice . '.id', -1);

                }

            } else {

                $this->db->where($this->erp_invoice . '.id', -1);

            }

        }

        if (!empty($serch_data['firm_id']) && $serch_data['firm_id'] != 'Select') {

            $this->db->where($this->erp_invoice . '.firm_id', $serch_data['firm_id']);

        } else {

            $firms = $this->user_auth->get_user_firms();

            $frim_id = array();

            foreach ($firms as $value) {

                $frim_id[] = $value['firm_id'];

            }

            $this->db->where_in('erp_invoice.firm_id', $frim_id);

        }

        if (!empty($serch_data['cust_type']) && $serch_data['cust_type'] != 'Select') {

            if ($serch_data['cust_type'] == 1) {

                $this->db->where($this->customer . '.tin IS NOT NULL', null, false);

            } else if ($serch_data['cust_type'] == 2) {

                $this->db->where($this->customer . '.tin IS NULL');

            }

        }

        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

        }



        $this->db->select('customer.id as customer,customer.store_name,customer.tin,customer.state_id, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_quotation.q_no,erp_invoice.total_qty,erp_invoice.tax,erp_quotation.ref_name,erp_invoice.tax_label,'

                . 'erp_invoice.net_total,erp_invoice.created_date,'

                . 'erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,'

                . 'erp_sales_man.sales_man_name,erp_invoice.q_id,erp_manage_firms.gstin,erp_manage_firms.firm_name');



        $this->db->where('erp_invoice.subtotal_qty !=', 0);

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_invoice.firm_id');

        $this->db->join('erp_sales_man', 'erp_sales_man.id=erp_invoice.sales_man', 'LEFT');

        $this->db->join('erp_invoice_details', 'erp_invoice_details.in_id=erp_invoice.id');

        $this->db->group_by('erp_invoice.id');

        $query = $this->db->get('erp_invoice');

        return $query->num_rows();

    }



    function get_all_customer_report($serch) {

        if ($serch != NULL && $serch != '') {

            $serch_data['inv_id'] = $serch[0]->inv_id;

            $serch_data['customer'] = $serch[1]->customer;

            $serch_data['product'] = $serch[2]->product;

            $serch_data['from_date'] = $serch[3]->from;

            $serch_data['to_date'] = $serch[4]->to;

            $serch_data['overdue'] = $serch[5]->overdue;

        }

        $this->db->distinct();

        $this->db->select('erp_invoice.*');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance');

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->where_in('erp_invoice.contract_customer', 0);

        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        //$this->db->where('erp_invoice.net_total >', 0);

        if (!empty($serch_data['overdue']) && $serch_data['overdue'] != '' && $serch_data['overdue'] == 3) {

            $this->db->where('customer.advance >', 0);

        }

        //$this->db->order_by('erp_invoice.id', 'desc');

        $this->db->join('customer', 'customer.id=erp_invoice.customer', 'LEFT');

        $this->db->join('erp_invoice_details', 'erp_invoice.id=erp_invoice_details.in_id', 'LEFT');

        //  $this->db->where('customer', 164);



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



                $this->db->where('erp_invoice.inv_id', $serch_data['inv_id']);

            }

            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

                $this->db->where('customer.id', $serch_data['customer']);

            }



            if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

                $this->db->where('erp_invoice_details.product_id', $serch_data['product']);

            }



            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            }

        }





        $query = $this->db->get('erp_invoice')->result_array();

        //echo $this->db->last_query();

        //exit;

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date');

            $this->db->where('receipt_bill.receipt_id', $val['id']);

            $query[$i]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();

            $this->db->select('total_qty,subtotal_qty,id,net_total');

            $this->db->where('invoice_id', $val['id']);

            $this->db->order_by("id", "desc");

            $this->db->limit(1);

            $query[$i]['return'] = $this->db->get('erp_sales_return')->result_array();

            $this->db->select('total_qty,subtotal_qty,id,net_total');

            $this->db->where('invoice_id', $val['id']);

            $this->db->order_by("id", "asc");

            $this->db->limit(1);

            $value = $this->db->get('erp_sales_return')->result_array();

            array_push($query[$i]['return'], $value[0]);

            $i++;

            // echo $this->db->last_query() . '<br />';

        }

//        echo '<pre>';

//        print_r($query);

//        exit;

        return $query;

    }



    public function get_invoice_hr_report($serch) {



        if ($serch != NULL && $serch != '') {

            $serch_data['inv_id'] = $serch[0]->inv_id;

            $serch_data['customer'] = $serch[1]->customer;

            $serch_data['product'] = $serch[2]->product;

            $serch_data['from_date'] = $serch[3]->from;

            $serch_data['to_date'] = $serch[4]->to;

        }



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

            $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);

        }

        if (!empty($serch_data['sales_man']) && $serch_data['sales_man'] != 'Select') {

            $this->db->where($this->erp_invoice . '.sales_man', $serch_data['sales_man']);

        }

        if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

            $this->db->where($this->erp_invoice_details . '.product_id', $serch_data['product']);

        }



        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

        }



        $this->db->select('customer.id as customer,customer.store_name,customer.tin, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_quotation.q_no,erp_invoice.total_qty,erp_invoice.tax,erp_quotation.ref_name,erp_invoice.tax_label,'

                . 'erp_invoice.net_total,erp_invoice.created_date,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_sales_man.sales_man_name');

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        $customer = array('7', '8');

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->join('erp_sales_man', 'erp_sales_man.id=erp_invoice.sales_man', 'LEFT');

        $this->db->join('erp_invoice_details', 'erp_invoice_details.in_id=erp_invoice.id');

        $this->db->where_in('customer.customer_type', $customer);

        $query = $this->db->get('erp_invoice')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            $this->db->where('j_id', intval($val['id']));

            $this->db->where('type', 'invoice');

            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();

            $i++;

        }

        return $query;

    }



    public function outstanding_report_excel($serch = NULL) {

        if ($serch != NULL && $serch != '') {

            $serch_data['firm'] = $serch[0]->firm;

            $serch_data['customer'] = $serch[1]->customer;

        }

        if (isset($serch_data) && !empty($serch_data)) {



            if (!empty($serch_data['firm']) && $serch_data['firm'] != 'Select') {



                $this->db->where($this->erp_invoice . '.firm_id', $serch_data['firm']);

            }

            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

                $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);

            }

        }



        $this->db->distinct('customer.id');

        $this->db->select('erp_invoice.firm_id');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance,customer.id');

        $this->db->join('customer', 'customer.id=erp_invoice.customer', 'left');

        $this->db->from($this->erp_invoice);



        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        $this->db->where('erp_invoice.net_total >', 0);

        $query = $this->db->get()->result_array();



        // print_r($this->db->last_query());



        $i = $j = 0;

        if (!empty($query)) {

            foreach ($query as $value) {

                $this->db->distinct();

                $this->db->select('erp_invoice.net_total AS net_total');

                //$this->db->select('SUM(receipt_bill.discount) AS receipt_discount,SUM(receipt_bill.bill_amount) AS receipt_paid,MAX(receipt_bill.due_date) AS next_date,MAX(receipt_bill.created_date) AS paid_date');

                $this->db->where('erp_invoice.inv_id !=', 'Wings Invoice');

                $this->db->where('erp_invoice.customer', $value['id']);

                $this->db->where('erp_invoice.firm_id', $value['firm_id']);

                $this->db->where_in('erp_invoice.contract_customer', 0);

                $this->db->join('receipt_bill', 'receipt_bill.receipt_id=erp_invoice.id', 'left');

                $sub_query = $this->db->get('erp_invoice')->result_array();

                $invoice_net_total = 0;

                if (!empty($sub_query)) {

                    foreach ($sub_query as $total) {

                        $invoice_net_total += $total['net_total'];

                    }

                }

                //'$result_arr[$j]['invoice_net'][] = $invoice_net_total;

                if (isset($query[$j]['invoice_net_total']))

                    $query[$j]['invoice_net_total'] += $invoice_net_total;

                else

                    $query[$j]['invoice_net_total'] = $invoice_net_total;

                $j++;

            }

        }

        foreach ($query as $val) {

            $this->db->select('erp_invoice.net_total');

            $this->db->select('SUM(erp_invoice.net_total) AS net_total, MAX(erp_invoice.created_date) AS created_date');

            $this->db->select('SUM(receipt_bill.discount) AS receipt_discount,SUM(receipt_bill.bill_amount) AS receipt_paid,MAX(receipt_bill.due_date) AS next_date,MAX(receipt_bill.created_date) AS paid_date');

            $this->db->where('erp_invoice.inv_id !=', 'Wings Invoice');

            $this->db->where('erp_invoice.customer', $val['id']);

            $this->db->where('erp_invoice.firm_id', $val['firm_id']);

            $this->db->where_in('erp_invoice.contract_customer', 0);

            $this->db->join('receipt_bill', 'receipt_bill.receipt_id=erp_invoice.id', 'left');

            $query[$i]['receipt_bill'] = $this->db->get('erp_invoice')->result_array();



            $i++;

        }



//        echo '<pre>';

//        print_r($query);

//        exit;

        return $query;

    }



    public function get_customer_details_report($serch = array()) {

        if ($serch != NULL && $serch != '') {

            $serch_data['firm'] = $serch[0]->firm;

            $serch_data['cust_type'] = $serch[1]->cust_type;

            $serch_data['cust_reg'] = $serch[1]->cust_reg;

        }

        if (!empty($search_data['firm'])) {

            $this->db->where($this->customer . ".firm_id", $search_data['firm']);

        }

        if (!empty($search_data['cust_type']) && $search_data['cust_type'] != 9) {

            $this->db->where_in($this->customer . ".customer_type", $search_data['cust_type']);

        }

        if (!empty($search_data['cust_reg']) && $search_data['cust_reg'] != 'both') {

            $this->db->where($this->customer . ".customer_region", $search_data['cust_reg']);

        }



        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }



        $this->db->distinct('customer.id');

        //$this->db->select('payment_report.firm_id');

        $this->db->select('payment_report.balance,payment_report.customer,payment_report.inv_id');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance,customer.id');

        $this->db->join('payment_report', 'payment_report.customer=customer.id');

        $this->db->where("payment_report.balance >", 0.1);

        $this->db->group_by("payment_report.customer");

        //$this->db->join('customer', 'customer.id=payment_report.customer', 'left');

        //$this->db->where('customer.id', 2); // AARUMUGANERI ABDULLAH OWN

        //$this->db->where('customer.id', 762); // ALTHAF TOTAL 9894691587

        //$this->db->where('customer.id', 861); // Irsath bai, Aasath street

        //$this->db->where('customer.id', 543); // Basheer

        //$this->db->where('customer.id', 1);

        //$this->db->where('customer.id', 788);



        $this->db->from('customer');



        //$this->db->where_in('payment_report.firm_id', $frim_id);

        $query = $this->db->get()->result_array();



        /*

          echo $this->db->last_query();

          echo "<pre>";

          print_r($query);

          exit; */



        $i = 0;

        foreach ($query as $val) {



            $due_date = date('Y-m-d');

            $seven_date = date('Y-m-d', strtotime("-6 day", strtotime($due_date)));

            $seven_date1 = date('Y-m-d', strtotime("-7 day", strtotime($due_date)));

            $thirty_date = date('Y-m-d', strtotime("-29 day", strtotime($due_date)));

            $thirty_date1 = date('Y-m-d', strtotime("-30 day", strtotime($due_date)));

            $ninty_date = date('Y-m-d', strtotime("-89 day", strtotime($due_date)));



            //$this->db->select('*');

            $this->db->select('*, SUM(balance) as new_balance');

            $this->db->where("DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') >='" . $seven_date . "' AND DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') <= '" . $due_date . "'");

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id !=', 'Wings Invoice');

            $this->db->where('payment_report.balance >', 0.1);

            $this->db->where_in('payment_report.firm_id', $frim_id);

            $this->db->group_by('payment_report.customer');

            $this->db->from('payment_report');

            $query[$i]['days'] = $this->db->get()->result_array();



            //$this->db->select('*');

            $this->db->select('*, SUM(balance) as new_balance');

            $this->db->where("DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') >='" . $thirty_date . "' AND DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') <= '" . $seven_date1 . "'");

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id !=', 'Wings Invoice');

            $this->db->where('payment_report.balance >', 0.1);

            $this->db->where_in('payment_report.firm_id', $frim_id);

            $this->db->group_by('payment_report.customer');

            $this->db->from('payment_report');

            $query[$i]['sevendays'] = $this->db->get()->result_array();



            //$this->db->select('*');

            $this->db->select('*, SUM(balance) as new_balance');

            $this->db->where("DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') >='" . $ninty_date . "' AND DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') <= '" . $thirty_date1 . "'");

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id !=', 'Wings Invoice');

            $this->db->where_in('payment_report.firm_id', $frim_id);

            $this->db->group_by('payment_report.customer');

            $this->db->from('payment_report');

            $query[$i]['thirtydays'] = $this->db->get()->result_array();



            //$this->db->select('*');

            $this->db->select('*, SUM(balance) as new_balance');

            $this->db->where("DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') <'" . $ninty_date . "'");

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id !=', 'Wings Invoice');

            $this->db->where('payment_report.balance >', 0.1);

            $this->db->where_in('payment_report.firm_id', $frim_id);

            $this->db->group_by('payment_report.customer');

            $this->db->from('payment_report');

            $query[$i]['nintydays'] = $this->db->get()->result_array();





            //$this->db->select('*');

            $this->db->select('*, SUM(balance) as new_balance');

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id', 'Wings Invoice');

            $this->db->where('payment_report.balance >', 0.1);

            $this->db->where_in('payment_report.firm_id', $frim_id);

            $this->db->group_by('payment_report.customer');

            $query[$i]['rec'] = $this->db->get('payment_report')->result_array();







            $i++;

        }



        return $query;

    }



    public function get_customer_details_firm_wise_report($serch = array()) {

        if ($serch != NULL && $serch != '') {

            $serch_data['due_date'] = $serch[0]->due_date;

            $serch_data['cust_type'] = $serch[1]->cust_type;

            $serch_data['cust_reg'] = $serch[2]->cust_reg;

        }

        $this->db->select('erp_invoice.*');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance');

        if (!empty($search_data['cust_type']) && $search_data['cust_type'] != 9) {

            $this->db->where_in($this->customer . ".customer_type", $search_data['cust_type']);

        }

        if (!empty($search_data['cust_reg']) && $search_data['cust_reg'] != 'both') {

            $this->db->where($this->customer . ".customer_region", $search_data['cust_reg']);

        }

        if (!empty($search_data['due_date']) && $search_data['due_date'] == 6) {

            $this->db->where("erp_invoice.inv_id", 'Wings Invoice');

        }

        if (!empty($search_data['due_date']) && $search_data['due_date'] != 6 && $search_data['due_date'] != 5) {

            $this->db->where("erp_invoice.inv_id !=", 'Wings Invoice');

        }

        $this->db->order_by('erp_invoice.id', 'desc');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');



        $this->db->where("payment_status ", 'Pending');

        $this->db->where('erp_invoice.net_total >', 0);

        $query = $this->db->get('erp_invoice')->result_array();



        $i = 0;

        foreach ($query as $duedate) {

            $due_date = $duedate['credit_due_date'];

            $seven_date = date('Y-m-d', strtotime("+7 day", strtotime($duedate['credit_due_date'])));

            $thirty_date = date('Y-m-d', strtotime("+30 day", strtotime($duedate['credit_due_date'])));

            $ninty_date = date('Y-m-d', strtotime("+90 day", strtotime($duedate['credit_due_date'])));

            if ($duedate['firm_id'] == 1) {

                $this->db->select('SUM(bill_amount) AS total_bill_amount,SUM(discount) AS receipt_discount');

                if (!empty($search_data['due_date']) && $search_data['due_date'] != 5 && $search_data['due_date'] != 6) {

                    if ($search_data['due_date'] == 1)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($due_date)) . '" and "' . date('Y-m-d', strtotime($seven_date)) . '"');

                    else if ($search_data['due_date'] == 2)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($seven_date)) . '" and "' . date('Y-m-d', strtotime($thirty_date)) . '"');

                    else if ($search_data['due_date'] == 3)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($thirty_date)) . '" and "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                    else if ($search_data['due_date'] == 4)

                        $this->db->where('created_date >= "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                }

                $this->db->where("receipt_id ", $duedate['id']);

                $electricals = $this->db->get($this->receipt_bill)->result_array();

                $query[$i]['electricals'] = ($electricals[0]['total_bill_amount'] + $electricals[0]['receipt_discount']);

            }

            if ($duedate['firm_id'] == 2) {

                $this->db->select('SUM(bill_amount) AS total_bill_amount,SUM(discount) AS receipt_discount');

                if (!empty($search_data['due_date']) && $search_data['due_date'] != 5 && $search_data['due_date'] != 6) {

                    if ($search_data['due_date'] == 1)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($due_date)) . '" and "' . date('Y-m-d', strtotime($seven_date)) . '"');

                    else if ($search_data['due_date'] == 2)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($seven_date)) . '" and "' . date('Y-m-d', strtotime($thirty_date)) . '"');

                    else if ($search_data['due_date'] == 3)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($thirty_date)) . '" and "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                    else if ($search_data['due_date'] == 4)

                        $this->db->where('created_date >= "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                }

                $this->db->where("receipt_id ", $duedate['id']);

                $paints = $this->db->get($this->receipt_bill)->result_array();

                $query[$i]['paints'] = ($paints[0]['total_bill_amount'] + $paints[0]['receipt_discount']);

            }

            if ($duedate['firm_id'] == 3) {

                $this->db->select('SUM(bill_amount) AS total_bill_amount,SUM(discount) AS receipt_discount');

                if (!empty($search_data['due_date']) && $search_data['due_date'] != 5 && $search_data['due_date'] != 6) {

                    if ($search_data['due_date'] == 1)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($due_date)) . '" and "' . date('Y-m-d', strtotime($seven_date)) . '"');

                    else if ($search_data['due_date'] == 2)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($seven_date)) . '" and "' . date('Y-m-d', strtotime($thirty_date)) . '"');

                    else if ($search_data['due_date'] == 3)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($thirty_date)) . '" and "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                    else if ($search_data['due_date'] == 4)

                        $this->db->where('created_date >= "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                }

                $this->db->where("receipt_id ", $duedate['id']);

                $tiles = $this->db->get($this->receipt_bill)->result_array();

                $query[$i]['tiles'] = ($tiles[0]['total_bill_amount'] + $tiles[0]['receipt_discount']);

            }

            if ($duedate['firm_id'] == 4) {

                $this->db->select('SUM(bill_amount) AS total_bill_amount,SUM(discount) AS receipt_discount');

                if (!empty($search_data['due_date']) && $search_data['due_date'] != 5 && $search_data['due_date'] != 6) {

                    if ($search_data['due_date'] = 1)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($due_date)) . '" and "' . date('Y-m-d', strtotime($seven_date)) . '"');

                    else if ($search_data['due_date'] = 2)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($seven_date)) . '" and "' . date('Y-m-d', strtotime($thirty_date)) . '"');

                    else if ($search_data['due_date'] = 3)

                        $this->db->where('created_date BETWEEN "' . date('Y-m-d', strtotime($thirty_date)) . '" and "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                    else if ($search_data['due_date'] = 4)

                        $this->db->where('created_date >= "' . date('Y-m-d', strtotime($ninty_date)) . '"');

                }

                $this->db->where("receipt_id ", $duedate['id']);

                $hardware = $this->db->get($this->receipt_bill)->result_array();

                $query[$i]['hardware'] = ($hardware[0]['total_bill_amount'] + $hardware[0]['receipt_discount']);

            }

            $query[$i]['net_amount'] = $query[$i]['electricals'] + $query[$i]['paints'] + $query[$i]['tiles'] + $query[$i]['hardware'];



            $i++;



            //echo $this->db->last_query() . '<br />';

        }

//        echo $this->db->last_query();

        //echo "<pre>";

        //print_r($query);

        //exit;



        return $query;

    }



    function get_all_profit_report_for_excel($serch) {



        if ($serch != NULL && $serch != '') {

            $serch_data['from_date'] = $serch[0]->from_date;

            $serch_data['to_date'] = $serch[1]->to_date;

        }

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.email_id,customer.id AS cust_id,customer.state_id');

        $this->db->select('erp_invoice.*');

        if (isset($serch_data) && !empty($serch_data)) {

            if (!empty($serch_data['from_date']))

                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

            if (!empty($serch_data['to_date']))

                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

            if ($serch_data['from_date'] == '1970-01-01')

                $serch_data['from_date'] = '';

            if ($serch_data['to_date'] == '1970-01-01')

                $serch_data['to_date'] = '';

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {



                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {



                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

            }

        }

        // $this->db->where('q_id', intval($val['id']));

        $this->db->where("erp_invoice.inv_id !=", 'Wings Invoice');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $query = $this->db->get('erp_invoice')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('erp_invoice_details.*,erp_product.id,erp_product.cost_price');

            $this->db->where('in_id', intval($val['id']));

            $this->db->join('erp_product', 'erp_product.id=erp_invoice_details.product_id');

            $query[$i]['or_amount'] = $this->db->get('erp_invoice_details')->result_array();

            $i++;

        }

//            if (empty($query[$j]['inv_amount']))

//                unset($query[$j]);

//            $j++;

        //echo "<pre>";

        // print_r($query);

        //exit;



        return $query;

    }



}

