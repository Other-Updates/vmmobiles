<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Admin_model extends CI_Model {



    private $table_name = 'admin';

    private $table_name1 = 'company_details';

    private $table_name2 = 'po';

    private $table_name3 = 'sales_order';

    private $table_name4 = 'package';

    private $table_name5 = 'invoice';

    private $erp_user = 'erp_user';

    private $agent_user = 'agent';

    private $erp_company_amount = 'erp_company_amount';

    private $erp_email_settings = 'erp_email_settings';

    private $erp_po = 'erp_po';

    private $erp_invoice = 'erp_invoice';

    private $epushserverdb_db;

    private $epushserverdb_database;

    private $ttbs_database;



    function __construct() {

        parent::__construct();

        $this->load->database();

        $this->ttbs_database = $this->db->database;

    }



    public function removeemptyproductdetails() {

        $this->load_ttbs_database();

        $this->ttbs_db->select('id');

        $this->ttbs_db->where('product_name', '');

        $products = $this->ttbs_db->get('erp_product')->result_array();

        //echo "<pre>"; print_r($products);exit;

        $data = array();

        if (!empty($products)) {

            $product_ids = array_map(function($products) {

                return $products['id'];

            }, $products);

            $this->close_ttbs_database();

            for ($i = 0; $i < count($product_ids); $i++) {

                $this->db->select('*');

                $this->db->where('id', $product_ids[$i]);

                $query = $this->db->get('erp_product')->result_array();

                if (!empty($query)) {

                    $product_id = $query[0]['id'];

                    $data['category_id'] = $query[0]['category_id'];

                    $data['brand_id'] = $query[0]['brand_id'];

                    $data['model_no'] = $query[0]['model_no'];

                    $data['product_name'] = $query[0]['product_name'];

                    $data['barcode'] = $query[0]['barcode'];

                    $data['product_description'] = $query[0]['product_description'];

                    $data['product_image'] = $query[0]['product_image'];

                    $data['type'] = $query[0]['type'];

                    $data['min_qty'] = $query[0]['min_qty'];

                    $data['qty'] = $query[0]['qty'];

                    $data['selling_price'] = $query[0]['selling_price'];

                    $data['reorder_quantity'] = $query[0]['reorder_quantity'];

                    $data['cost_price'] = $query[0]['cost_price'];

                    $data['cash_cus_price'] = $query[0]['cash_cus_price'];

                    $data['credit_cus_price'] = $query[0]['credit_cus_price'];

                    $data['cash_con_price'] = $query[0]['cash_con_price'];

                    $data['credit_con_price'] = $query[0]['credit_con_price'];

                    $data['vip_price'] = $query[0]['vip_price'];

                    $data['vvip_price'] = $query[0]['vvip_price'];

                    $data['h1_price'] = $query[0]['h1_price'];

                    $data['h2_price'] = $query[0]['h2_price'];

                    $data['discount'] = $query[0]['discount'];

                    $data['status'] = $query[0]['status'];

                    $data['firm_id'] = $query[0]['firm_id'];

                    $data['unit'] = $query[0]['unit'];

                    $data['is_non_gst'] = $query[0]['is_non_gst'];

                    $data['hsn_sac_name'] = $query[0]['hsn_sac_name'];

                    $data['hsn_sac'] = $query[0]['hsn_sac'];

                    $data['hsn_sac_rate'] = $query[0]['hsn_sac_rate'];

                    $data['cgst'] = $query[0]['cgst'];

                    $data['sgst'] = $query[0]['sgst'];

                    $data['igst'] = $query[0]['igst'];

                    $data['expires_in'] = $query[0]['expires_in'];

                    $data['expired_date'] = $query[0]['expired_date'];

                    $data['created_date'] = $query[0]['created_date'];

                    $data['created_by'] = $query[0]['created_by'];



                    $this->load_ttbs_database();

                    $this->ttbs_db->where('id', $product_id);

                    $this->ttbs_db->update('erp_product', $data);

                    $this->close_ttbs_database();

                }

            }

        }



        exit;



        /*



          $this->db->select('id');

          $this->db->where('product_name', '');

          $products = $this->db->get('erp_product')->result_array();

          //echo "<pre>";print_r($products);exit;

          $product_ids = array_map(function($products) {

          return $products['id'];

          }, $products);

          //echo "<pre>"; print_r($product_ids); exit;

          $this->db->select('product_id');

          $this->db->where_in('product_id', array(1));

          $this->db->group_by('product_id');

          $invoice_products = $this->db->get('erp_invoice_details')->result_array();

          //echo "<pre>"; print_r($invoice_products);exit;

          $invoice_product_ids = array_map(function($invoice_products) {

          return $invoice_products['product_id'];

          }, $invoice_products);

          //echo "<pre>";

          //print_r($invoice_product_ids); //exit;

          //echo "------------------------------------------";

          $result = array_diff($product_ids, $invoice_product_ids);

          //print_r($result);

          //$this->db->where_in('id', $result);

          //$this->db->delete('erp_product');



         */

    }



    public function get_user_by_login($username, $password) {



        $this->db->select('tab_1.*');

        $this->db->where('username', $username);

        $this->db->where('password', md5($password));

        $query = $this->db->get($this->erp_user . ' AS tab_1');



        if ($query->num_rows() >= 1) {

            return $query->row();

        } else {

            return FALSE;

        }

    }



    public function login($data) {

        $this->db->select('username,id,role');

        $this->db->where('username', $data['username']);

        $this->db->where('password', md5($data['password']));

        $query = $this->db->get($this->erp_user);

        if ($query->num_rows() >= 1) {

            return $query->result_array();

        } else {



            $this->db->select('username,id,role');

            $this->db->where('username', $data['username']);

            $this->db->where('password', md5($data['password']));

            $query1 = $this->db->get($this->agent_user);

            if ($query1->num_rows() >= 0) {

                return $query1->result_array();

            }

        }



        return false;

    }



    public function get_admin($role, $id) {



        $this->db->select('*');

        $this->db->where('role', $role);

        $this->db->where('id', $id);

        $query = $this->db->get($this->erp_user);

        if ($query->num_rows() >= 1) {



            return $query->result_array();

        } else {

            $this->db->select('*');

            $this->db->where('role', $role);

            $this->db->where('id', $id);

            $query1 = $this->db->get($this->agent_user);



            if ($query1->num_rows() >= 0) {

                return $query1->result_array();

            }

        }



        return false;

    }



    function update_profile($data, $role, $id) {



        $this->db->where('id', $id);

        $this->db->where('role', $role);

        $this->db->update($this->erp_user, $data);

        $this->db->where('id', $id);

        $this->db->where('role', $role);

        $this->db->update($this->agent_user, $data);

    }



    function insert_company_details($data) {

        $this->db->where('id', 1);

        if ($this->db->update($this->table_name1, $data)) {



            return true;

        }

        return false;

    }



    function get_company_details() {

        $this->db->select('*');

        $query = $this->db->get($this->table_name1)->result_array();

        return $query;

    }



    function get_company_amount() {

        $this->db->select('value');

        $this->db->where("(type='company_amount')");

        $query = $this->db->get($this->erp_email_settings)->result_array();

        return $query;

    }



    function update_company_amount($data) {

        $update_array = array('value' => $data);

        $this->db->where("type", "company_amount");

        if ($this->db->update($this->erp_email_settings, $update_array)) {

            return true;

        }

        return false;

    }



    function amount_credit() {

        $this->db->select('SUM(bill_amount) as credit');

        $this->db->where($this->erp_company_amount . '.type', 1);

        $this->db->where($this->erp_company_amount . '.recevier', 1);

        $query = $this->db->get($this->erp_company_amount)->result_array();

        return $query;

    }



    function amount_debit() {

        $this->db->select('SUM(bill_amount) as debit');

        $this->db->where($this->erp_company_amount . '.type', 2);

        $this->db->where($this->erp_company_amount . '.recevier', 1);

        $query = $this->db->get($this->erp_company_amount)->result_array();

        return $query;

    }



    function amount_credit_agent($id) {

        $this->db->select('SUM(bill_amount) as credit');

        $this->db->where($this->erp_company_amount . '.type', 1);

        $this->db->where($this->erp_company_amount . '.recevier', 2);

        $this->db->where($this->erp_company_amount . '.recevier_id', $id);

        $query = $this->db->get($this->erp_company_amount)->result_array();

        return $query;

    }



    function amount_debit_agent($id) {

        $this->db->select('SUM(bill_amount) as debit');

        $this->db->where($this->erp_company_amount . '.type', 2);

        $this->db->where($this->erp_company_amount . '.recevier', 2);

        $this->db->where($this->erp_company_amount . '.recevier_id', $id);

        $query = $this->db->get($this->erp_company_amount)->result_array();

        return $query;

    }



    function amount_credit_agent_all() {

        $this->db->select('SUM(bill_amount) as credit');

        $this->db->where($this->erp_company_amount . '.type', 1);

        $this->db->where($this->erp_company_amount . '.recevier', 2);

        $query = $this->db->get($this->erp_company_amount)->result_array();

        return $query;

    }



    function amount_debit_agent_all() {

        $this->db->select('SUM(bill_amount) as debit');

        $this->db->where($this->erp_company_amount . '.type', 2);

        $this->db->where($this->erp_company_amount . '.recevier', 2);

        $query = $this->db->get($this->erp_company_amount)->result_array();

        return $query;

    }



    function get_agent_cash($id) {

        $this->db->select('SUM(bill_amount) as credit');

        $this->db->where($this->erp_company_amount . '.recevier_id', $id);

        $this->db->where($this->erp_company_amount . '.type', 1);

        $this->db->where($this->erp_company_amount . '.recevier', 2);

        $query = $this->db->get($this->erp_company_amount)->result_array();

        return $query;

    }



    function get_cash() {

        $this->db->select('SUM(bill_amount) as cash');

        $this->db->where("(receiver_type='Advance Amount')");

        $this->db->where($this->erp_company_amount . '.type', 1);

        $query = $this->db->get($this->erp_company_amount)->result_array();

        return $query;

    }



    function get_purchase_cost() {

        $this->db->select('SUM(bill_amount) as purchase_cost');

        $this->db->where("(receiver_type='Purchase Cost')");

        $this->db->where($this->erp_company_amount . '.type', 2);

        $query = $this->db->get($this->erp_company_amount)->result_array();

        return $query;

    }



    function get_agent_debit($id) {

        $this->db->select('SUM(bill_amount) as debit');

        $this->db->where($this->erp_company_amount . '.recevier_id', $id);

        $this->db->where($this->erp_company_amount . '.type', 2);

        $this->db->where($this->erp_company_amount . '.recevier', 2);

        $query = $this->db->get($this->erp_company_amount)->result_array();

        return $query;

    }



    function get_purchase_report($from_date, $to_date) {

        $this->db->select('SUM(full_total) AS total_qty,SUM(net_total) AS total_val');

        $this->db->where("DATE_FORMAT(" . $this->table_name2 . ".inv_date,'%Y-%m-%d') >='" . $from_date . "' AND DATE_FORMAT(" . $this->table_name2 . ".inv_date,'%Y-%m-%d') <= '" . $to_date . "'");

        $this->db->where($this->table_name2 . '.status', 1);

        $this->db->where($this->table_name2 . '.df', 0);

        $query = $this->db->get($this->table_name2)->result_array();



        $current_day = date("N");

        $days_to_friday = 7 - $current_day;

        $days_from_monday = $current_day - 1;

        $monday = date("Y-m-d", strtotime("- {$days_from_monday} Days"));

        $sunday = date("Y-m-d", strtotime("+ {$days_to_friday} Days"));



        $this->db->select('SUM(net_total) AS this_week_total_val');

        $this->db->where("DATE_FORMAT(" . $this->table_name2 . ".inv_date,'%Y-%m-%d') >='" . $monday . "' AND DATE_FORMAT(" . $this->table_name2 . ".inv_date,'%Y-%m-%d') <= '" . $sunday . "'");

        $this->db->where($this->table_name2 . '.status', 1);

        $this->db->where($this->table_name2 . '.df', 0);

        $query['last_week'] = $this->db->get($this->table_name2)->result_array();

        return $query;

    }



    function get_sales_report($from_date, $to_date) {

        $this->db->select('SUM(full_total) AS total_qty,SUM(net_final_total) AS total_val');

        $this->db->where("DATE_FORMAT(" . $this->table_name3 . ".inv_date,'%Y-%m-%d') >='" . $from_date . "' AND DATE_FORMAT(" . $this->table_name3 . ".inv_date,'%Y-%m-%d') <= '" . $to_date . "'");

        $this->db->where($this->table_name3 . '.status', 1);

        $this->db->where($this->table_name3 . '.df', 0);

        $query = $this->db->get($this->table_name3)->result_array();



        $current_day = date("N");

        $days_to_friday = 7 - $current_day;

        $days_from_monday = $current_day - 1;

        $monday = date("Y-m-d", strtotime("- {$days_from_monday} Days"));

        $sunday = date("Y-m-d", strtotime("+ {$days_to_friday} Days"));



        $this->db->select('SUM(net_final_total) AS this_week_total_val');

        $this->db->where("DATE_FORMAT(" . $this->table_name3 . ".inv_date,'%Y-%m-%d') >='" . $monday . "' AND DATE_FORMAT(" . $this->table_name3 . ".inv_date,'%Y-%m-%d') <= '" . $sunday . "'");

        $this->db->where($this->table_name3 . '.status', 1);

        $this->db->where($this->table_name3 . '.df', 0);

        $query['last_week'] = $this->db->get($this->table_name3)->result_array();

        return $query;

    }



    function get_package_report($from_date, $to_date) {

        $this->db->select('SUM(total_value) AS total_qty');

        $this->db->where("DATE_FORMAT(" . $this->table_name5 . ".add_date,'%Y-%m-%d') >='" . $from_date . "' AND DATE_FORMAT(" . $this->table_name5 . ".add_date,'%Y-%m-%d') <= '" . $to_date . "'");

        $this->db->where($this->table_name5 . '.status', 1);

        $query = $this->db->get($this->table_name5)->result_array();



        $current_day = date("N");

        $days_to_friday = 7 - $current_day;

        $days_from_monday = $current_day - 1;

        $monday = date("Y-m-d", strtotime("- {$days_from_monday} Days"));

        $sunday = date("Y-m-d", strtotime("+ {$days_to_friday} Days"));



        $this->db->select('SUM(total_value) AS this_week_total_val');

        $this->db->where("DATE_FORMAT(" . $this->table_name5 . ".add_date,'%Y-%m-%d') >='" . $monday . "' AND DATE_FORMAT(" . $this->table_name5 . ".add_date,'%Y-%m-%d') <= '" . $sunday . "'");

        $this->db->where($this->table_name5 . '.status', 1);

        $query['last_week'] = $this->db->get($this->table_name5)->result_array();

        return $query;

    }



    function get_qty_chart() {

        $list_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);

        $result = array();

        foreach ($list_array as $val) {

            if ($val < 10)

                $date = (date('Y')) . '-' . str_pad($val, 2, '0', STR_PAD_LEFT);

            else

                $date = (date('Y')) . '-' . $val;



            $this->db->select('SUM(net_total) AS total_qty');

            $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m')", $date);

            $query = $this->db->get('erp_invoice')->result_array();



            if (!empty($query[0]['total_qty']))

                $result[$val] = $query[0]['total_qty'];

            else

                $result[$val] = 0;

        }

        return $result;

    }



    function get_qty_chart1() {

        $list_array = array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15);

        $result = array();

        foreach ($list_array as $val) {

            if (date('m') > 3) {

                if ($val == '13') {

                    $date = (date('Y') + 1) . '-' . str_pad(1, 1, '0', STR_PAD_LEFT);

                } elseif ($val == '14') {

                    $date = (date('Y') + 1) . '-' . str_pad(2, 1, '0', STR_PAD_LEFT);

                } elseif ($val == '15') {

                    $date = (date('Y') + 1) . '-' . str_pad(3, 1, '0', STR_PAD_LEFT);

                } else {

                    if ($val < 10)

                        $date = date('Y') . '-' . str_pad($val, 2, '0', STR_PAD_LEFT);

                    else

                        $date = date('Y') . '-' . $val;

                }

            }

            else {

                if ($val == '13') {

                    $date = date('Y') . '-0' . str_pad(1, 1, '0', STR_PAD_LEFT);

                } elseif ($val == '14') {

                    $date = date('Y') . '-0' . str_pad(2, 1, '0', STR_PAD_LEFT);

                } elseif ($val == '15') {

                    $date = date('Y') . '-0' . str_pad(3, 1, '0', STR_PAD_LEFT);

                } else {

                    if ($val < 10)

                        $date = (date('Y') - 1) . '-' . str_pad($val, 2, '0', STR_PAD_LEFT);

                    else

                        $date = (date('Y') - 1) . '-' . $val;

                }

            }



            $this->db->select('SUM(full_total) AS total_qty');

            $this->db->where("DATE_FORMAT(" . $this->table_name3 . ".inv_date,'%Y-%m')", $date);

            $this->db->where($this->table_name3 . '.status', 1);

            $this->db->where($this->table_name3 . '.df', 0);

            $query = $this->db->get($this->table_name3)->result_array();

            if (!empty($query[0]['total_qty']))

                $result[$val] = $query[0]['total_qty'];

            else

                $result[$val] = 0;

        }

        return $result;

    }



    function get_dashboard_report() {

        $user_info = $this->session->userdata('user_info');

        $this->db->select('enquiry_no,customer_name,created_date');

        if ($user_info[0]['role'] == 5) {

            $this->db->where('created_by', $user_info[0]['id']);

            $this->db->where('erp_enquiry.status', 'Pending');

            $this->db->order_by('erp_enquiry.created_date', 'desc');

            $query['enquiry'] = $this->db->get('erp_enquiry')->result_array();

        } else {

            $this->db->where('erp_enquiry.status', 'Pending');

            $this->db->order_by('erp_enquiry.created_date', 'desc');

            $query['enquiry'] = $this->db->get('erp_enquiry')->result_array();

        }







        $this->db->select('inv_id,net_total,customer.store_name');

        $this->db->where('erp_invoice.payment_status', 'Pending');

        $this->db->order_by('erp_invoice.created_date', 'desc');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $query['receipt'] = $this->db->get('erp_invoice')->result_array();



        $this->db->select('erp_product.product_name,erp_product.min_qty,erp_stock.quantity,erp_category.categoryName,erp_brand.brands');

        $this->db->join('erp_product', 'erp_product.id=erp_stock.product_id AND erp_product.min_qty >= erp_stock.quantity');

        $this->db->join('erp_category', 'erp_category.cat_id=erp_stock.category');

        $this->db->join('erp_brand', 'erp_brand.id=erp_stock.brand');

        $this->db->limit(10);

        $query['stock'] = $this->db->get('erp_stock')->result_array();



        return $query;

    }

    public function get_today_purchase(){
             $firms = $this->user_auth->get_user_firms();

            $frim_id = array();

            foreach ($firms as $value) {

                $frim_id[] = $value['firm_id'];

            }

            $this->db->select('erp_po.id,vendor.store_name as supplier_name,erp_po.net_total,erp_manage_firms.firm_name,erp_po.po_no,erp_po.created_date');

            $this->db->join('vendor', 'vendor.id=erp_po.supplier');

           $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_po.firm_id');

           if (!empty($frim_id)) {

            $this->db->where_in('erp_po.firm_id', $frim_id);

           }

           $this->db->group_by('erp_po.supplier');

           $this->db->where('erp_po.created_date', date('Y-m-d'));

            $this->db->order_by('erp_po.created_date', date('Y-m-d'));

            $this->db->limit(10);

             $query = $this->db->get('erp_po')->result_array();

return $query;


    }

    public function get_today_sales(){
        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->select('erp_invoice.id,erp_invoice.net_total,customer.store_name as customer_name,erp_manage_firms.firm_name,erp_invoice.inv_id');

        //$this->db->where('erp_invoice.payment_status', 'Pending');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_invoice.firm_id');

        if (!empty($frim_id)) {

            $this->db->where_in('erp_invoice.firm_id', $frim_id);

        }

        $this->db->group_by('erp_invoice.customer');

         $this->db->where('erp_invoice.created_date', date('Y-m-d'));

        $this->db->order_by('erp_invoice.created_date', date('Y-m-d'));

        $this->db->limit(10);

        $query = $this->db->get('erp_invoice')->result_array();

        return $query;
    }

    public function get_firm_based_pending_invoice() {

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->select('erp_invoice.id,erp_invoice.customer,customer.store_name,erp_manage_firms.firm_name');

        $this->db->where('erp_invoice.payment_status', 'Pending');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_invoice.firm_id');

        if (!empty($frim_id)) {

            $this->db->where_in('erp_invoice.firm_id', $frim_id);

        }

        $this->db->group_by('erp_invoice.customer');

        $this->db->order_by('erp_invoice.created_date', 'desc');

        $this->db->limit(10);

        $query = $this->db->get('erp_invoice')->result_array();

        return $query;

    }



    public function get_customer_by_invoice($cust_id) {

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->select('erp_invoice.id,inv_id,net_total');

        $this->db->select('customer.email_id,mobil_number,name');

        $this->db->where('erp_invoice.customer', $cust_id);

        $this->db->where('erp_invoice.payment_status', 'Pending');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        if (!empty($frim_id))

            $this->db->where_in('erp_invoice.firm_id', $frim_id);

        $this->db->order_by('erp_invoice.created_date', 'desc');

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



    public function get_cash_credit_po() {

        $current_date = date('Y-m-d');

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->select('prefix,firm_id');

        $this->db->where_in('erp_manage_firms.firm_id', $frim_id);

        $this->db->order_by('erp_manage_firms.firm_id', 'ASC');

        $query = $this->db->get('erp_manage_firms')->result_array();



        $i = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(net_total) as po_cash');

            $this->db->where($this->erp_po . '.created_date', $current_date);

            $this->db->where_in('erp_po.firm_id', $val['firm_id']);

            $this->db->where('erp_po.po_type', 1);

            $query[$i]['po_cash'] = $this->db->get($this->erp_po)->result_array();

            $i++;

        }

        $j = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(net_total) as po_credit');

            $this->db->where($this->erp_po . '.created_date', $current_date);

            $this->db->where_in('erp_po.firm_id', $val['firm_id']);

            $this->db->where('erp_po.po_type', 2);

            $query[$j]['po_credit'] = $this->db->get($this->erp_po)->result_array();

            $j++;

        }

        $is = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(net_total) as inv_cash');

            $this->db->where($this->erp_invoice . '.created_date', $current_date);

            $this->db->where_in('erp_invoice.firm_id', $val['firm_id']);

            $this->db->where('erp_invoice.bill_type', 1);

            $query[$is]['inv_cash'] = $this->db->get($this->erp_invoice)->result_array();

            $is++;

        }

        $js = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(net_total) as inv_credit');

            $this->db->where($this->erp_invoice . '.created_date', $current_date);

            $this->db->where_in('erp_invoice.firm_id', $val['firm_id']);

            $this->db->where('erp_invoice.bill_type', 2);

            $query[$js]['inv_credit'] = $this->db->get($this->erp_invoice)->result_array();

            $js++;

        }

        return $query;

    }



    public function get_cash_credit_sales() {

        $current_date = date('Y-m-d');

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->select('firm_name,firm_id');

        $this->db->where_in('erp_manage_firms.firm_id', $frim_id);

        $this->db->order_by('erp_manage_firms.firm_id', 'ASC');

        $query = $this->db->get('erp_manage_firms')->result_array();



        $i = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(net_total) as inv_cash');

            $this->db->where($this->erp_invoice . '.created_date', $current_date);

            $this->db->where_in('erp_invoice.firm_id', $val['firm_id']);

            $this->db->where('erp_invoice.bill_type', 1);

            $query[$i]['inv_cash'] = $this->db->get($this->erp_invoice)->result_array();

            $i++;

        }

        $j = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(net_total) as inv_credit');

            $this->db->where($this->erp_invoice . '.created_date', $current_date);

            $this->db->where_in('erp_invoice.firm_id', $val['firm_id']);

            $this->db->where('erp_invoice.bill_type', 2);

            $query[$j]['inv_credit'] = $this->db->get($this->erp_invoice)->result_array();

            $j++;

        }

        return $query;

    }



    public function get_the_total_sales_count() {

        $current_date = date('Y-m-d');

        $this->db->select('net_total');

        $this->db->where($this->erp_project_cost . '.created_date', $current_date);

        $query = $this->db->get($this->erp_project_cost);

        if ($query->num_rows() >= 0) {

            return $query->result_array();

        }

        return false;

    }



    public function delete_unwanted_records($parent_table = NULL, $child_table = NULL) {

        if ($parent_table != NULL && $child_table != NULL) {

            $delete_ids = array();

            if ($parent_table == 'erp_invoice' && $child_table == 'erp_invoice_details') {

                $this->db->select('DISTINCT(in_id)');

                $query = $this->db->get($child_table);

                $query = $query->result_array();

                if (!empty($query)) {

                    foreach ($query as $invoice_value) {

                        $this->db->select('id');

                        $this->db->where('id', $invoice_value['in_id']);

                        $query = $this->db->get($parent_table);

                        if ($query->num_rows() == 0) {



                            array_push($delete_ids, $invoice_value['in_id']);



                            // Delete Query..

                            $this->db->where('in_id', $invoice_value['in_id']);

                            $this->db->delete($child_table);

                        }

                    }

                }

            }

            if ($parent_table == 'erp_quotation' && $child_table == 'erp_quotation_details') {

                //echo "Comes here..";

                //exit;

                $this->db->select('DISTINCT(q_id)');

                $query = $this->db->get($child_table);

                $query = $query->result_array();

                if (!empty($query)) {

                    foreach ($query as $quotation_value) {

                        $this->db->select('id');

                        $this->db->where('id', $quotation_value['q_id']);

                        $query = $this->db->get($parent_table);

                        if ($query->num_rows() == 0) {

                            //array_push($delete_ids, $quotation_value['q_id']);

                            // Delete Query..

                            $this->db->where('q_id', $quotation_value['q_id']);

                            $this->db->delete($child_table);

                        }

                    }

                }

            }

            if ($parent_table == 'customer' && $child_table == 'erp_invoice') {

                $this->db->select('DISTINCT(customer)');

                $query = $this->db->get($child_table);

                $query = $query->result_array();

                if (!empty($query)) {

                    foreach ($query as $customer_value) {

                        $this->db->select('id');

                        $this->db->where('id', $customer_value['customer']);

                        $query = $this->db->get($parent_table);

                        if ($query->num_rows() == 0) {

                            array_push($delete_ids, $customer_value['customer']);

                            // Delete Query..

                            $this->db->where('customer', $customer_value['customer']);

                            $this->db->delete($child_table);

                        }

                    }

                }

            }



            if ($parent_table == 'erp_product' && $child_table == 'erp_invoice_details') {

                $this->db->select('DISTINCT(product_id)');

                $query = $this->db->get($child_table);

                $query = $query->result_array();

                if (!empty($query)) {

                    foreach ($query as $product_value) {

                        $this->db->select('id');

                        $this->db->where('id', $product_value['product_id']);

                        $query = $this->db->get($parent_table);

                        if ($query->num_rows() == 0) {

                            array_push($delete_ids, $product_value['product_id']);

                            // Delete Query..

                            $this->db->where('product_id', $product_value['product_id']);

                            $this->db->delete($child_table);

                        }

                    }

                }

            }



            if ($parent_table == 'erp_invoice' && $child_table == 'receipt_bill') {

                $this->db->select('DISTINCT(receipt_id)');

                $query = $this->db->get($child_table);

                $query = $query->result_array();

                if (!empty($query)) {

                    foreach ($query as $receipt_value) {

                        $this->db->select('id');

                        $this->db->where('id', $receipt_value['receipt_id']);

                        $query = $this->db->get($parent_table);

                        if ($query->num_rows() == 0) {

                            array_push($delete_ids, $receipt_value['receipt_id']);

                            // Delete Query..

                            $this->db->where('receipt_id', $receipt_value['receipt_id']);

                            $this->db->delete($child_table);

                        }

                    }

                }

            }



            if ($parent_table == 'customer' && $child_table == 'erp_quotation') {

                $this->db->select('DISTINCT(customer)');

                $query = $this->db->get($child_table);

                $query = $query->result_array();

                if (!empty($query)) {

                    foreach ($query as $receipt_value) {

                        $this->db->select('id');

                        $this->db->where('id', $receipt_value['customer']);

                        $query = $this->db->get($parent_table);

                        if ($query->num_rows() == 0) {

                            array_push($delete_ids, $receipt_value['customer']);

                            // Delete Query..

                            $this->db->where('customer', $receipt_value['customer']);

                            $this->db->delete($child_table);

                        }

                    }

                }

            }

            if ($parent_table == 'erp_quotation' && $child_table == 'erp_invoice_details') {

                $this->db->select('DISTINCT(q_id)');

                $query = $this->db->get($child_table);

                $query = $query->result_array();

                if (!empty($query)) {

                    foreach ($query as $receipt_value) {

                        $this->db->select('id');

                        $this->db->where('id', $receipt_value['q_id']);

                        $query = $this->db->get($parent_table);

                        if ($query->num_rows() == 0) {

                            array_push($delete_ids, $receipt_value['q_id']);

                            // Delete Query..

                            $this->db->where('q_id', $receipt_value['q_id']);

                            $this->db->delete($child_table);

                        }

                    }

                }

            }





            echo "Test<pre>";

            print_r($delete_ids);

        }

    }



    public function remove_duplicate_invoice() {

        $this->db->select('id,inv_id,q_id');

        $this->db->where('erp_invoice.inv_id !=', 'Wings Invoice');

        $this->db->limit(10, 10);

        $query = $this->db->get('erp_invoice')->result_array();

        $dup_inv = array();

        foreach ($query as $val) {

            $update_array = array('invoice_id' => $val['id']);

            $this->db->where('erp_sales_return.inv_id', $val['inv_id']);

            $this->db->where('erp_sales_return.q_id', $val['q_id']);

            $this->db->update('erp_sales_return', $update_array);

        }

        return $dup_inv;

    }



    public function invoice_amount() {

        $this->db->select('erp_invoice.round_off,erp_invoice.id,erp_invoice.inv_id,erp_invoice.q_id,customer.state_id,customer.store_name,customer.tin,customer.state_id,customer.advance,erp_invoice.transport,erp_invoice.labour,erp_invoice.remarks,erp_invoice.subtotal_qty');

        $this->db->where('erp_invoice.inv_id !=', 'Wings Invoice');

        $this->db->join('customer', 'customer.id=erp_invoice.customer', 'LEFT');

//        $this->db->where('erp_invoice.id =', '2997');

        $query = $this->db->get('erp_invoice')->result_array();

        $dup_inv = array();

        $net_total = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            $this->db->where('erp_invoice_details.in_id =', $val['id']);

            $inv_det = $this->db->get('erp_invoice_details')->result_array();

            $cgst = 0;

            $sgst = 0;

            $sub_tot = $tot_qty = 0;

            foreach ($inv_det as $vals) {

                $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);



                $gst_type = $val['state_id'];

                if ($gst_type != '') {

                    if ($gst_type == 31) {



                        $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);

                    } else {

                        $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);

                    }

                }

                $cgst += $cgst1;

                $sgst += $sgst1;

                $tot_qty += $vals['quantity'];



                if (isset($val['round_off']) && $val['round_off'] > 0) {

                    if ($val['net_total'] > ($val['subtotal_qty'] + $val['transport'] + $val['labour'] + $cgst + $sgst)) {

                        $round_off_plus = $val['round_off'];

                        $round_off_minus = 0;

                    } else if ($val['net_total'] < ($val['subtotal_qty'] + $val['transport'] + $val['labour'] + $cgst + $sgst)) {

                        $round_off_minus = $val['round_off'];

                        $round_off_plus = 0;

                    } else {

                        $round_off_plus = 0;

                        $round_off_minus = 0;

                    }

                }

                $sub_tot += $vals['sub_total'];

            }



            $net_total = ($sub_tot + $cgst + $sgst + $val['transport'] + $val['labour']) - $val['round_off'];

            $net_total = $net_total;

            //if ($sub_tot != $val['subtotal_qty']) {



            $update_array = array('subtotal_qty' => $sub_tot, 'net_total' => $net_total, 'total_qty' => $tot_qty);

            $this->db->where('erp_invoice.id', $val['id']);

            $this->db->update('erp_invoice', $update_array);

            //}

        }

        return true;

    }



    public function loopallproducts() {

        //Last Id - 8674

        $this->db->select('product_id');

        $this->db->group_by('product_id');

        $pro_id = $this->db->get('erp_invoice_details')->result_array();

        $pro_id = array_map(function($pro_id) {

            return $pro_id['product_id'];

        }, $pro_id);

        //        echo "<pre>";

        //        print_r($pro_id);

        //        exit;



        for ($i = 1; $i <= 12440; $i++) {



            if (!in_array($i, $pro_id)) {



                $this->db->where('id', $i);

                $this->db->delete('erp_product');

            } else {

                $array[] = $i;

            }

        }

//        return $array;

//

//        $array = array('5150', '8785', '8971', '9006', '9113', '9628', '9659', '9931', '10199', '10214', '10230', '10326', '10327', '10905', '10909', '11478', '11519', '11542', '11545', '11577', '11596', '11629', '11667', '11719', '11746', '11832', '11834', '11839', '11885', '11886', '11887', '11890', '11933', '11995', '12440');

        foreach ($array as $val) {

            $this->db->select('product_name');

            $this->db->where('id', $val);

            $pro_name = $this->db->get('erp_product')->result_array();



            if (!empty($pro_name)) {

                $this->db->select('id');

                $product_name = $pro_name[0]['product_name'];

                $this->db->where("product_name", $product_name);

                //$this->db->like("product_name", $pro_name[0]['product_name']);

                $product_id = $this->db->get('erp_product')->result_array();

                echo $this->db->last_query();



                $product_id = array_map(function($product_id) {

                    return $product_id['id'];

                }, $product_id);

                echo '<pre>';

                print_r($product_id);

                if (!empty($product_id)) {

                    $id = $product_id[0];

                    $data['product_id'] = $id;

                    $this->db->where_in('product_id', $product_id);

                    $this->db->update('erp_invoice_details', $data);

                    $this->db->where_in('product_id', $product_id);

                    $this->db->update('erp_stock', $data);

                    $this->db->where_in('product_id', $product_id);

                    $this->db->update('erp_sales_return_details', $data);

                    $this->db->where_in('product_id', $product_id);

                    $this->db->update('erp_quotation_details', $data);

                    $this->db->where_in('product_id', $product_id);

                    $this->db->update('erp_invoice_product_details', $data);

                    unset($product_id[0]);

                    if (!empty($product_id)) {

                        $this->db->where_in('id', $product_id);

                        $this->db->delete('erp_product');

                    }

                }

            }

        }

        return true;

    }



    public function updatestock_as_per_invoice_live() {

        // Get all Products in invoice details - invoice id 7040 - 7111

        for ($i = 7040; $i <= 7111; $i++) {

            // Get Firm Id in - Invoice Table

            $this->db->select('firm_id, inv_id');

            $this->db->where('id', $i);

            $invoice_details = $this->db->get('erp_invoice')->result_array();



            if (!empty($invoice_details)) {

                $firm_id = $invoice_details[0]['firm_id'];

                $inv_id = $invoice_details[0]['inv_id'];

                $this->db->select('*');

                $this->db->where('in_id', $i);

                $query = $this->db->get('erp_invoice_details')->result_array();

                //echo "<pre>";print_r($query);exit;

                if (!empty($query)) {

                    foreach ($query as $invoice_products) {

                        $product_id = $invoice_products['product_id'];

                        $brand_id = $invoice_products['brand'];

                        $category = $invoice_products['category'];

                        $invoice_product_quantity = $invoice_products['quantity'];

                        //Get stock..

                        $this->db->select('*');

                        $this->db->where('firm_id', $firm_id);

                        $this->db->where('category', $category);

                        //$this->db->where('brand', $brand_id);

                        $this->db->where('product_id', $product_id);

                        $stock_details = $this->db->get('erp_stock')->result_array();

                        //echo $this->db->last_query();exit;

                        if (!empty($stock_details)) {

                            $stock_id = $stock_details[0]['id'];

                            $quantity = $stock_details[0]['quantity'];

                            //echo "Stock Id : " . $stock_id . '<br />Quantity : ' . $quantity . '<br />';

                            //echo "Inovice product qty : " . $invoice_product_quantity . '<br />';

                            // Update Stock..

                            $current_quantity = $quantity - $invoice_product_quantity;

                            if ($current_quantity < 0 || $current_quantity == '' || $current_quantity == NULL) {

                                $current_quantity = 0;

                            }

                            //echo "Current Qty : " . $current_quantity;

                            //exit;

                            $data['quantity'] = $current_quantity;

                            $this->db->where('id', $stock_id);

                            if ($this->db->update('erp_stock', $data)) {

                                // Insert Stock History..

                                $stock_history['ref_no'] = $inv_id;

                                $stock_history['type'] = 2;

                                $stock_history['category'] = $category;

                                $stock_history['brand'] = $brand_id;

                                $stock_history['product_id'] = $product_id;

                                $stock_history['quantity'] = '-' . $invoice_product_quantity;

                                $stock_history['created_date'] = date('Y-m-d H:i:s');

                                $this->db->insert('erp_stock_history', $stock_history);

                                echo "Invoice Id : " . $i . " ( " . $inv_id . " ) Product Id : " . $product_id . "Firm Id : " . $firm_id . " Stock Id : " . $stock_id . " Current Qty : " . $current_quantity . " <b>Success</b><br />";

                            } else {

                                echo "Invoice Id : " . $i . " ( " . $inv_id . " ) Product Id : " . $product_id . "Firm Id : " . $firm_id . 'FAILED <br />';

                            }

                        }

                    }

                }

            }



            //exit;

        }

    }



    public function updatestockreturn_as_per_invoice_live() {

        // Get all Products in invoice details - invoice id 7040 - 7111

        for ($i = 7040; $i <= 7111; $i++) {

            // $i = 7090;

            // Get Firm Id in - Invoice Table

            $this->db->select('firm_id, inv_id');

            $this->db->where('id', $i);

            $invoice_details = $this->db->get('erp_invoice')->result_array();

            //echo "<pre>"; print_r($invoice_details); exit;

            if (!empty($invoice_details)) {

                $firm_id = $invoice_details[0]['firm_id'];

                $inv_id = $invoice_details[0]['inv_id'];

                $this->db->select('*');

                $this->db->where('in_id', $i);

                $invoice_details_qry = $this->db->get('erp_invoice_details')->result_array();

                // echo "<pre>"; print_r($invoice_details_qry); exit;

                if (!empty($invoice_details_qry)) {

                    foreach ($invoice_details_qry as $inv_detailsvalue) {

                        $product_id = $inv_detailsvalue['product_id'];

                        $brand_id = $inv_detailsvalue['brand'];

                        $category = $inv_detailsvalue['category'];

                        $this->db->select('*');

                        $this->db->where('invoice_id', $i);

                        $query = $this->db->get('erp_sales_return')->result_array();

                        //echo $i . '--' . $this->db->last_query();

                        //exit;

                        if (!empty($query)) {

//                            /echo "Rajaa";exit;

                            foreach ($query as $salesreturn) {

                                $sales_return_id = $salesreturn['id'];

                                $invoice_id = $salesreturn['invoice_id'];

                                // Get Sales Return Details

                                $this->db->select('*');

                                //  $this->db->where('return_id', $sales_return_id);

                                $this->db->where('in_id', $invoice_id);

                                $this->db->where('product_id', $product_id);

                                $this->db->where('return_quantity !=', 0);

                                $sales_return_details = $this->db->get('erp_sales_return_details')->result_array();

                                // echo $this->db->last_query() . '<br />';

                                // exit;



                                if (!empty($sales_return_details)) {

                                    $return_qty = ($sales_return_details[0]['return_quantity'] != '') ? $sales_return_details[0]['return_quantity'] : 0;

                                    //Get stock..

                                    $this->db->select('*');

                                    $this->db->where('firm_id', $firm_id);

                                    $this->db->where('category', $category);

                                    // $this->db->where('brand', $brand_id);

                                    $this->db->where('product_id', $product_id);

                                    $stock_details = $this->db->get('erp_stock')->result_array();

                                    if (!empty($stock_details)) {

                                        $stock_id = $stock_details[0]['id'];

                                        $quantity = $stock_details[0]['quantity'];

                                        // Update Stock..

                                        $current_quantity = $quantity + $return_qty;

                                        if ($current_quantity < 0 || $current_quantity == '' || $current_quantity == NULL) {

                                            $current_quantity = 0;

                                        }

                                        $data['quantity'] = $current_quantity;

                                        $this->db->where('id', $stock_id);

                                        if ($this->db->update('erp_stock', $data)) {

                                            // Insert Stock History..

                                            $stock_history['ref_no'] = $inv_id;

                                            $stock_history['type'] = 3;

                                            $stock_history['category'] = $category;

                                            $stock_history['brand'] = $brand_id;

                                            $stock_history['product_id'] = $product_id;

                                            $stock_history['quantity'] = $return_qty;

                                            $this->db->insert('erp_stock_history', $stock_history);

                                            echo "<br /> Sales Return For the Invoice : " . $i . " Success<br />";

                                        } else {

                                            echo "<br /> Sales Return For the Invoice : " . $i . " Failed<br />";

                                        }

                                    } else {

                                        echo "<br /> Empty Stock Available For the Invoice : " . $i . "<br />";

                                    }

                                } else {

                                    echo "<br /> No Sales Return Available For this Invoice : " . $i . "<br />";

                                }

                            }

                            //exit;

                        } else {

                            echo "<br /> No Return(Sales Return Empty) For the Invoice : " . $i . "<br />";

                        }

                    }

                }

            }

        }

    }



    public function getrecordsfromepushserver() {

        $users = array('2', '3', '15', '23', '28', '34', '36', '37', '38', '39', '40', '41', '42', '43');

        $this->db->select('users.id,users.username');

        //$this->db->where('id',36);

        $this->db->where_in('id', $users);

        $user_details = $this->db->get('users');

        if ($user_details->num_rows() > 0) {

            $user_details = $user_details->result_array();

            // echo "<pre>";

            // print_r($user_details);

            // exit;

            $month = 11;

            $year = 2018;

            // $month = date('m');

            // $year = date('Y');

            $table = 'devicelogs_' . $month . '_' . $year;

            // echo $table; exit;

            foreach ($user_details as $key => $user_data) {

                $this->load->database('epushserverdb', TRUE);

                $this->epushserverdb_db = $this->load->database('epushserverdb', true);

                $this->epushserverdb_db->where($table . '.hrapp_syncstatus', NULL);

                $this->epushserverdb_db->where($table . '.UserId', $user_data['id']); // example-36

                $device_log = $this->epushserverdb_db->get($table);





                if ($device_log->num_rows() > 0) {

                    $device_log = $device_log->result_array();

                    //echo "<pre>";print_r($device_log);

                    $total_device_log = count($device_log);

                    foreach ($device_log as $keys => $log_data) {

                        $user_atten_date = date('Y-m-d', strtotime($log_data['LogDate']));

                        $atten_user_id = $log_data['UserId'];

                        $device_log_id = $log_data['DeviceLogId'];

                        // Check if already this user have a attendance on same day..

                        $this->load->database('default', TRUE);

                        $this->db = $this->load->database('default', true);

                        $this->db->select('*');

                        $this->db->where('user_id', $atten_user_id);

                        $this->db->where('DATE(created)', $user_atten_date);

                        $alreadyAttendance = $this->db->get('attendance');



                        if ($alreadyAttendance->num_rows() == 0) {

                            //echo "IF : " . $device_log_id . '--' . $atten_user_id . '<br />';

                            if ($log_data['Direction'] == 'in') {

                                $insert_atten_data = [

                                    "user_id" => $log_data['UserId'],

                                    "in" => date("H:i", strtotime($log_data['LogDate'])),

                                    "created" => $log_data['LogDate'],

                                ];

                                //echo "logggdate";print_r(date("H:i", strtotime($log_data['LogDate'])));

                                //print_r($log_data['LogDate']);

                                $this->load->database('default', TRUE);

                                $this->db = $this->load->database('default', true);

                                $this->db->insert('attendance', $insert_atten_data);

                                $insert_attenance_id = $this->db->insert_id();

                                echo "Attendance Inserted For User : " . $user_data['username'] . "For Date : " . date("d-m-Y", strtotime($log_data['LogDate'])) . '<br />';

                                $this->load->database('epushserverdb', TRUE);

                                $this->epushserverdb_db = $this->load->database('epushserverdb', true);

                                $this->epushserverdb_db->where($table . '.LogDate', $log_data['LogDate']);

                                $this->epushserverdb_db->where($table . '.UserId', $atten_user_id);

                                $this->epushserverdb_db->where($table . '.DeviceLogId', $device_log_id);

                                $update_devicelog_data = array('hrapp_syncstatus' => 1);

                                $update_device_log = $this->epushserverdb_db->update($table, $update_devicelog_data);

                                //echo $this->epushserverdb_db->last_query();exit;

                                echo "Device Log Id : " . $device_log_id . "Updated as 1<br />";

                                $this->load->database('default', TRUE);

                                $this->db = $this->load->database('default', true);

                            }

                        } else {

                            echo "ELSE : Device Log id : " . $device_log_id . '-- User Id : ' . $atten_user_id . '<br />';

                            $this->db->select('*');

                            $this->db->where('DATE(created)', $user_atten_date);

                            $this->db->where('user_id', $atten_user_id);

                            $query = $this->db->get('attendance');

                            $attendance_data = $query->result_array();

                            if (!empty($attendance_data[0]['out'])) {

                                $this->load->database('default', TRUE);

                                $this->db = $this->load->database('default', true);

                                $out_time = $attendance_data[0]['out'];

                                if ($log_data['Direction'] == 'in') {



                                    $in_time = date('H:i', strtotime($log_data['LogDate']));



                                    $this->db->where('break_table.attendance_id', $attendance_data[0]['id']);

                                    $this->db->where('break_table.in_time', $out_time);

                                    $this->db->where('break_table.out_time', $in_time);

                                    $this->db->where('break_table.type', 'break');

                                    $attendance_check = $this->db->get('break_table')->result_array();



                                    if (count($attendance_check) == 0) {



                                        $insert_break_data = array(

                                            'attendance_id' => $attendance_data[0]['id'],

                                            'in_time' => $out_time,

                                            'out_time' => $in_time,

                                            'type' => 'break'

                                        );

                                        $this->db->insert('break_table', $insert_break_data);



                                        $insert_break_id = $this->db->insert_id();

                                    } else {

                                        $insert_break_id = $attendance_check[0]['id'];

                                    }

                                    //print_r($insert_break_id);exit;

                                    // Update Attendance

                                    $this->db->where('attendance.id', $attendance_data[0]['id']);

                                    $update_atten_data = array(

                                        'out' => NULL

                                    );

                                    $update_atten = $this->db->update('attendance', $update_atten_data);

                                } else {

                                    $this->load->database('default', TRUE);

                                    $this->db = $this->load->database('default', true);

                                    // Update Attendance

                                    $this->db->where('attendance.id', $attendance_data[0]['id']);

                                    $update_atten_data = array(

                                        'out' => NULL

                                    );

                                    $update_atten = $this->db->update('attendance', $update_atten_data);

                                }

                            } else {

                                if ($log_data['Direction'] == 'out') {

                                    $this->load->database('default', TRUE);

                                    $this->db = $this->load->database('default', true);

                                    $out_time = date('H:i', strtotime($log_data['LogDate']));

                                    // Update Attendance

                                    $this->db->where('attendance.id', $attendance_data[0]['id']);

                                    $update_atten_data = array(

                                        'out' => $out_time

                                    );

                                    $update_atten = $this->db->update('attendance', $update_atten_data);

                                }

                            }

                        }

                    }

                }

            }

            exit;

            return true;

        } else {

            return false;

        }

    }



    public function load_snapshot_database() {

        $this->epushserverdb_db = $this->load->database('epushserverdb', TRUE);

        echo "Comes Here";

        exit;

        $this->epushserverdb_database = $this->epushserverdb_db->database;

    }



    public function close_snapshot_database() {

        $this->epushserverdb_db->close();

        $this->db = $this->load->database('default', TRUE);

    }



    public function insertepushrecordsto_ttbsdb() {

        //$users = array('2', '3', '15', '23', '28', '34', '36', '37', '38', '39', '40', '41', '42', '43');

        $this->db->select('users.id,users.username');

        //$this->db->where('id',36);

        $this->db->where_in('id', $users);

        $user_details = $this->db->get('users');

        if ($user_details->num_rows() > 0) {

            $user_details = $user_details->result_array();



            $month = date('m');

            $year = date('Y');

            // $month = "10";

            // $year = "2018";

            $table = 'devicelogs_' . $month . '_' . $year;

            //echo $table; exit;



            foreach ($user_details as $key => $user_data) {



//                $this->load->database('epushserverdb', TRUE);

//                $this->epushserverdb_db = $this->load->database('epushserverdb', true);

//                $this->epushserverdb_db->where($table . '.hrapp_syncstatus', NULL);

//                $this->epushserverdb_db->where($table . '.UserId', $user_data['id']); // example-36

//                $device_log = $this->epushserverdb_db->get($table);

                if ($this->db->table_exists($table)) {

                    $this->db->where('UserId', $user_data['id']);

                    $device_log = $this->db->get($table);

                } else {

                    $device_log = "";

                }

                if ($device_log->num_rows() > 0) {



                    $device_log = $device_log->result_array();

                    // echo "<pre>";print_r($device_log);exit;

                    $total_device_log = count($device_log);

                    foreach ($device_log as $keys => $log_data) {

                        $user_atten_date = date('Y-m-d', strtotime($log_data['LogDate']));

                        $atten_user_id = $log_data['UserId'];

                        $device_log_id = $log_data['DeviceLogId'];

                        // Check if already this user have a attendance on same day..

                        $this->load->database('default', TRUE);

                        $this->db = $this->load->database('default', true);

                        $this->db->select('*');

                        $this->db->where('user_id', $atten_user_id);

                        $this->db->where('DATE(created)', $user_atten_date);

                        $alreadyAttendance = $this->db->get('attendance');



                        if ($alreadyAttendance->num_rows() == 0) {

                            //echo "IF : " . $device_log_id . '--' . $atten_user_id . '<br />';

                            if ($log_data['Direction'] == 'in') {

                                $insert_atten_data = [

                                    "user_id" => $log_data['UserId'],

                                    "in" => date("H:i", strtotime($log_data['LogDate'])),

                                    "created" => $log_data['LogDate'],

                                ];

                                //echo "logggdate";print_r(date("H:i", strtotime($log_data['LogDate'])));

                                //print_r($log_data['LogDate']);

                                $this->load->database('default', TRUE);

                                $this->db = $this->load->database('default', true);

                                $this->db->insert('attendance', $insert_atten_data);

                                $insert_attenance_id = $this->db->insert_id();

                                echo "Attendance Inserted For User : " . $user_data['username'] . "For Date : " . date("d-m-Y", strtotime($log_data['LogDate'])) . '<br />';



//                                $this->load->database('epushserverdb', TRUE);

//                                $this->epushserverdb_db = $this->load->database('epushserverdb', true);

//                                $this->epushserverdb_db->where($table . '.LogDate', $log_data['LogDate']);

//                                $this->epushserverdb_db->where($table . '.UserId', $atten_user_id);

//                                $this->epushserverdb_db->where($table . '.DeviceLogId', $device_log_id);

//                                $update_devicelog_data = array('hrapp_syncstatus' => 1);

//                                $update_device_log = $this->epushserverdb_db->update($table, $update_devicelog_data);

//                                //echo $this->epushserverdb_db->last_query();exit;

                                // $this->db->where('LogDate',$log_data['LogDate']);

                                $this->db->where('DATE(LogDate)', $log_data['LogDate']);

                                $this->db->where('UserId', $atten_user_id);

                                $this->db->where('DeviceLogId', $device_log_id);

                                $update_devicelog_data = array('hrapp_syncstatus' => 1);

                                $this->db->update($table, $update_devicelog_data);

                                // $this->db->table($table)->update($update_devicelog_data);

                                echo "Device Log Id : " . $device_log_id . "Updated as 1<br />";

                                $this->load->database('default', TRUE);

                                $this->db = $this->load->database('default', true);

                                echo "1111";

                            }

                        } else {

                            echo "ELSE : Device Log id : " . $device_log_id . '-- User Id : ' . $atten_user_id . '<br />';

                            $this->db->select('*');

                            $this->db->where('DATE(created)', $user_atten_date);

                            $this->db->where('user_id', $atten_user_id);

                            $query = $this->db->get('attendance');

                            $attendance_data = $query->result_array();

                            if (!empty($attendance_data[0]['out'])) {

                                $this->load->database('default', TRUE);

                                $this->db = $this->load->database('default', true);

                                $out_time = $attendance_data[0]['out'];

                                if ($log_data['Direction'] == 'in') {



                                    $in_time = date('H:i', strtotime($log_data['LogDate']));



                                    $this->db->where('break_table.attendance_id', $attendance_data[0]['id']);

                                    $this->db->where('break_table.in_time', $out_time);

                                    $this->db->where('break_table.out_time', $in_time);

                                    $this->db->where('break_table.type', 'break');

                                    $attendance_check = $this->db->get('break_table')->result_array();



                                    if (count($attendance_check) == 0) {



                                        $insert_break_data = array(

                                            'attendance_id' => $attendance_data[0]['id'],

                                            'in_time' => $out_time,

                                            'out_time' => $in_time,

                                            'type' => 'break'

                                        );

                                        $this->db->insert('break_table', $insert_break_data);



                                        $insert_break_id = $this->db->insert_id();

                                    } else {

                                        $insert_break_id = $attendance_check[0]['id'];

                                    }

                                    //print_r($insert_break_id);exit;

                                    // Update Attendance

                                    $this->db->where('attendance.id', $attendance_data[0]['id']);

                                    $update_atten_data = array(

                                        'out' => NULL

                                    );

                                    $update_atten = $this->db->update('attendance', $update_atten_data);

                                } else {

                                    $this->load->database('default', TRUE);

                                    $this->db = $this->load->database('default', true);

                                    // Update Attendance

                                    $this->db->where('attendance.id', $attendance_data[0]['id']);

                                    $update_atten_data = array(

                                        'out' => NULL

                                    );

                                    $update_atten = $this->db->update('attendance', $update_atten_data);

                                }

                            } else {

                                if ($log_data['Direction'] == 'out') {

                                    $this->load->database('default', TRUE);

                                    $this->db = $this->load->database('default', true);

                                    $out_time = date('H:i', strtotime($log_data['LogDate']));

                                    // Update Attendance

                                    $this->db->where('attendance.id', $attendance_data[0]['id']);

                                    $update_atten_data = array(

                                        'out' => $out_time

                                    );

                                    $update_atten = $this->db->update('attendance', $update_atten_data);

                                }

                            }

                        }

                    }

                }

            }

            exit;

            return true;

        } else {



            return false;

        }

    }



    function create_devicelog_table($table) {

        $sql = "CREATE TABLE " . $table . " (

  `DeviceLogId` bigint(20) NOT NULL,

  `DownloadDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,

  `DeviceId` bigint(20) NOT NULL,

  `UserId` varchar(50) NOT NULL,

  `LogDate` timestamp NOT NULL DEFAULT '1970-12-31 18:30:01',

  `Direction` varchar(255) DEFAULT NULL,

  `AttDirection` varchar(255) DEFAULT NULL,

  `C1` varchar(255) DEFAULT NULL,

  `C2` varchar(255) DEFAULT NULL,

  `C3` varchar(255) DEFAULT NULL,

  `C4` varchar(255) DEFAULT NULL,

  `C5` varchar(255) DEFAULT NULL,

  `C6` varchar(255) DEFAULT NULL,

  `C7` varchar(255) DEFAULT NULL,

  `WorkCode` varchar(255) DEFAULT NULL,

  `hrapp_syncstatus` tinyint(4) DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=latin1";



        $query = $this->db->query($sql);



        return $query;

    }



}

