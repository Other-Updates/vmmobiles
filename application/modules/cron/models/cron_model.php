<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron_model extends CI_Model {

    private $table_name1 = 'sales_order';
    private $table_name2 = 'sales_order_details';
    private $table_name3 = 'customer';
    private $table_name4 = 'master_style';
    private $table_name5 = 'master_style_size';
    private $table_name6 = 'vendor';
    private $erp_po = 'erp_po';

    function __construct() {
        parent::__construct();
    }

    public function get_all_po() {
        $today = date('Y-m-d');
        $this->db->select('vendor.id as vendor,vendor.tin,vendor.store_name,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_po.*');
        $this->db->select('erp_manage_firms.firm_name');
        $this->db->where('erp_po.estatus !=', 0);
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_po.firm_id', 'left');
        $this->db->where("erp_po.created_date = '" . $today . "'");
        $query = $this->db->get('erp_po');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_invoice() {
        $today = date('Y-m-d');
        $this->db->select('customer.id as customer,customer.store_name, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_quotation.q_no,erp_invoice.total_qty,erp_invoice.tax,erp_quotation.ref_name,erp_invoice.tax_label,'
                . 'erp_invoice.net_total,erp_invoice.created_date,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_invoice.warranty_from,erp_invoice.warranty_to');
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }
        $this->db->where_in('erp_invoice.firm_id', $frim_id);
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $this->db->where("erp_invoice.created_date = '" . $today . "'");
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

    public function get_all_stock() {
        //$today = date('Y-m-d');
        $this->db->select('erp_category.categoryName,erp_product.product_name,erp_brand.brands,erp_stock.quantity,erp_product.model_no,erp_stock_history.created_date,erp_manage_firms.firm_name,erp_product.min_qty');
        /* $firms = $this->user_auth->get_user_firms();
          $frim_id = array();
          foreach ($firms as $value) {
          $frim_id[] = $value['firm_id'];
          }
          $this->db->where_in('erp_stock.firm_id', $frim_id); */
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_stock.firm_id', 'left');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_stock.category');
        $this->db->join('erp_product', 'erp_product.id=erp_stock.product_id');
        $this->db->join('erp_stock_history', 'erp_stock_history.product_id=erp_stock.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_stock.brand', 'LEFT');
        //$this->db->where("DATE_FORMAT(erp_stock_history.created_date,'%Y-%m-%d') = '" . $today . "'");
        $this->db->group_by('erp_product.id');
        $query = $this->db->get('erp_stock');
        //print_r($query->result_array());
        //exit;
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_profit_report() {
        $today = date('Y-m-d');
        $this->db->select('erp_quotation.id,customer.id as customer,customer.store_name, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
                . 'erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus');

        $this->db->where('erp_quotation.estatus !=', 0);
        $this->db->join('customer', 'customer.id=erp_quotation.customer');
        $query = $this->db->get('erp_quotation')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('erp_quotation_details.id,erp_quotation_details.q_id,erp_quotation_details.product_id,erp_product.id,SUM(erp_product.cost_price) AS total_cost_price');
            $this->db->where('q_id', intval($val['id']));
            $this->db->join('erp_product', 'erp_product.id=erp_quotation_details.product_id');
            $query[$i]['pc_amount'] = $this->db->get('erp_quotation_details')->result_array();
            $i++;
        }
        $j = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') = '" . $today . "'");
            $this->db->where('q_id', intval($val['id']));
            $query[$j]['inv_amount'] = $this->db->get('erp_invoice')->result_array();
            if (empty($query[$j]['inv_amount']))
                unset($query[$j]);
            $j++;
        }
        return $query;
    }

    public function get_all_invoice() {
        $today = date('Y-m-d');
        $this->db->select('customer.id as customer,customer.store_name, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.*,erp_quotation.q_no,erp_quotation.net_total AS q_total');
        /* $firms = $this->user_auth->get_user_firms();
          $frim_id = array();
          foreach ($firms as $value) {
          $frim_id[] = $value['firm_id'];
          }
          $this->db->where_in('erp_project_cost.firm_id', $frim_id); */
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') = '" . $today . "'");
        $query = $this->db->get('erp_invoice')->result_array();
        $j = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date,MAX(created_date) AS paid_date');
            $this->db->where('receipt_bill.receipt_id', $val['id']);
            $query[$j]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();
            $j++;
        }
        return $query;
    }

    public function get_all_sku_report() {
        $today = date('Y-m-d');
        $this->db->select('erp_sku_management.*');
        $this->db->select('erp_manage_firms.firm_name');
        $this->db->select('erp_sku_details.*');
        $this->db->select("erp_product.product_name,erp_brand.brands,erp_category.categoryName");
        $this->db->join('erp_sku_details', 'erp_sku_details.sku_id=erp_sku_management.id');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_sku_management.firm_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_sku_details.cat_id', 'LEFT');
        $this->db->join('erp_product', 'erp_product.id=erp_sku_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_sku_details.brand_id', 'LEFT');
        $this->db->where("DATE_FORMAT(erp_sku_management.created_date,'%Y-%m-%d') = '" . $today . "'");
        $query = $this->db->get('erp_sku_management')->result_array();
        return $query;

        //echo"<pre>"; print_r($query); exit;
    }

    public function get_all_po_weekly() {
        $start_date = date("Y-m-d", strtotime("-1 week"));
        $end_date = date("Y-m-d");
        $this->db->select('vendor.id as vendor,vendor.tin,vendor.store_name,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_po.*');
        $this->db->select('erp_manage_firms.firm_name');
        $this->db->where('erp_po.estatus !=', 0);
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_po.firm_id', 'left');
        $this->db->where("erp_po.created_date >= '" . $start_date . "' AND erp_po.created_date <= '" . $end_date . "'");
        $query = $this->db->get('erp_po');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_stock_weekly() {
        $start_date = date("Y-m-d", strtotime("-1 week"));
        $end_date = date("Y-m-d");
        $this->db->select('erp_category.categoryName,erp_product.product_name,erp_brand.brands,erp_stock.quantity,erp_product.model_no,erp_stock_history.created_date,erp_manage_firms.firm_name');
        /* $firms = $this->user_auth->get_user_firms();
          $frim_id = array();
          foreach ($firms as $value) {
          $frim_id[] = $value['firm_id'];
          }
          $this->db->where_in('erp_stock.firm_id', $frim_id); */
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_stock.firm_id', 'left');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_stock.category');
        $this->db->join('erp_product', 'erp_product.id=erp_stock.product_id');
        $this->db->join('erp_stock_history', 'erp_stock_history.product_id=erp_stock.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_stock.brand', 'LEFT');
        // $this->db->where("DATE_FORMAT(erp_stock_history.created_date,'%Y-%m-%d') = '" . $today . "'");
        $this->db->where("erp_stock_history.created_date >= '" . $start_date . "' AND erp_stock_history.created_date <= '" . $end_date . "'");
        $this->db->group_by('erp_product.id');
        $query = $this->db->get('erp_stock');
        //print_r($query->result_array());
        //exit;
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_profit_report_weekly() {
        $start_date = date("Y-m-d", strtotime("-1 week"));
        $end_date = date("Y-m-d");
        $today = date('Y-m-d');
        $this->db->select('erp_quotation.id,customer.id as customer,customer.store_name, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
                . 'erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus');

        $this->db->where('erp_quotation.estatus !=', 0);
        $this->db->join('customer', 'customer.id=erp_quotation.customer');
        $query = $this->db->get('erp_quotation')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('erp_quotation_details.id,erp_quotation_details.q_id,erp_quotation_details.product_id,erp_product.id,SUM(erp_product.cost_price) AS total_cost_price');
            $this->db->where('q_id', intval($val['id']));
            $this->db->join('erp_product', 'erp_product.id=erp_quotation_details.product_id');
            $query[$i]['pc_amount'] = $this->db->get('erp_quotation_details')->result_array();
            $i++;
        }

        $j = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where("erp_invoice.created_date >= '" . $start_date . "' AND erp_invoice.created_date <= '" . $end_date . "'");
            $this->db->where('q_id', intval($val['id']));
            $query[$j]['inv_amount'] = $this->db->get('erp_invoice')->result_array();
            if (empty($query[$j]['inv_amount']))
                unset($query[$j]);
            $j++;
        }
        return $query;
    }

    public function get_all_invoice_weekly() {
        $start_date = date("Y-m-d", strtotime("-1 week"));
        $end_date = date("Y-m-d");
        $this->db->select('customer.id as customer,customer.store_name, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.*,erp_quotation.q_no,erp_quotation.net_total AS q_total');
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $this->db->where("erp_invoice.created_date >= '" . $start_date . "' AND erp_invoice.created_date <= '" . $end_date . "'");
        $query = $this->db->get('erp_invoice')->result_array();
        $j = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date,MAX(created_date) AS paid_date');
            $this->db->where('receipt_bill.receipt_id', $val['id']);
            $query[$j]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();
            $j++;
        }
        return $query;
    }

    public function get_all_sku_report_weekly() {
        $start_date = date("Y-m-d", strtotime("-1 week"));
        $end_date = date("Y-m-d");
        $this->db->select('erp_sku_management.*');
        $this->db->select('erp_manage_firms.firm_name');
        $this->db->select('erp_sku_details.*');
        $this->db->select("erp_product.product_name,erp_brand.brands,erp_category.categoryName");
        $this->db->join('erp_sku_details', 'erp_sku_details.sku_id=erp_sku_management.id');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_sku_management.firm_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_sku_details.cat_id', 'LEFT');
        $this->db->join('erp_product', 'erp_product.id=erp_sku_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_sku_details.brand_id', 'LEFT');
        $this->db->where("DATE_FORMAT(erp_sku_management.created_date,'%Y-%m-%d') >= '" . $start_date . "' AND DATE_FORMAT(erp_sku_management.created_date,'%Y-%m-%d')  <= '" . $end_date . "'");
        $query = $this->db->get('erp_sku_management')->result_array();
        return $query;
        //echo"<pre>"; print_r($query); exit;
    }

    public function get_all_po_monthly() {
        $start_date = date("Y-m-d", strtotime("-1 month"));
        $end_date = date("Y-m-d");
        $this->db->select('vendor.id as vendor,vendor.tin,vendor.store_name,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_po.*');
        $this->db->select('erp_manage_firms.firm_name');
        $this->db->where('erp_po.estatus !=', 0);
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_po.firm_id', 'left');
        $this->db->where("erp_po.created_date >= '" . $start_date . "' AND erp_po.created_date <= '" . $end_date . "'");
        $query = $this->db->get('erp_po');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_stock_monthly() {
        $start_date = date("Y-m-d", strtotime("-1 month"));
        $end_date = date("Y-m-d");
        $this->db->select('erp_category.categoryName,erp_product.product_name,erp_brand.brands,erp_stock.quantity,erp_product.model_no,erp_stock_history.created_date,erp_manage_firms.firm_name');
        /* $firms = $this->user_auth->get_user_firms();
          $frim_id = array();
          foreach ($firms as $value) {
          $frim_id[] = $value['firm_id'];
          }
          $this->db->where_in('erp_stock.firm_id', $frim_id); */
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_stock.firm_id', 'left');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_stock.category');
        $this->db->join('erp_product', 'erp_product.id=erp_stock.product_id');
        $this->db->join('erp_stock_history', 'erp_stock_history.product_id=erp_stock.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_stock.brand', 'LEFT');
        // $this->db->where("DATE_FORMAT(erp_stock_history.created_date,'%Y-%m-%d') = '" . $today . "'");
        $this->db->where("erp_stock_history.created_date >= '" . $start_date . "' AND erp_stock_history.created_date <= '" . $end_date . "'");
        $this->db->group_by('erp_product.id');
        $query = $this->db->get('erp_stock');
        //print_r($query->result_array());
        //exit;
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_profit_report_monthly() {
        $start_date = date("Y-m-d", strtotime("-1 month"));
        $end_date = date("Y-m-d");
        $today = date('Y-m-d');
        $this->db->select('erp_quotation.id,customer.id as customer,customer.store_name, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
                . 'erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus');
        $this->db->where('erp_quotation.estatus !=', 0);
        $this->db->join('customer', 'customer.id=erp_quotation.customer');
        $query = $this->db->get('erp_quotation')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('erp_quotation_details.id,erp_quotation_details.q_id,erp_quotation_details.product_id,erp_product.id,SUM(erp_product.cost_price) AS total_cost_price');
            $this->db->where('q_id', intval($val['id']));
            $this->db->join('erp_product', 'erp_product.id=erp_quotation_details.product_id');
            $query[$i]['pc_amount'] = $this->db->get('erp_quotation_details')->result_array();
            $i++;
        }
        $j = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where("erp_invoice.created_date >= '" . $start_date . "' AND erp_invoice.created_date <= '" . $end_date . "'");
            $this->db->where('q_id', intval($val['id']));
            $query[$j]['inv_amount'] = $this->db->get('erp_invoice')->result_array();
            if (empty($query[$j]['inv_amount']))
                unset($query[$j]);
            $j++;
        }
        return $query;
    }

    public function get_all_invoice_monthly() {
        $start_date = date("Y-m-d", strtotime("-1 month"));
        $end_date = date("Y-m-d");
        $this->db->select('customer.id as customer,customer.store_name, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.*,erp_quotation.q_no,erp_quotation.net_total AS q_total');
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $this->db->where("erp_invoice.created_date >= '" . $start_date . "' AND erp_invoice.created_date <= '" . $end_date . "'");
        $query = $this->db->get('erp_invoice')->result_array();
        $j = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date,MAX(created_date) AS paid_date');
            $this->db->where('receipt_bill.receipt_id', $val['id']);
            $query[$j]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();
            $j++;
        }
        return $query;
    }

    public function get_all_sku_report_monthly() {
        $start_date = date("Y-m-d", strtotime("-1 month"));
        $end_date = date("Y-m-d");
        $this->db->select('erp_sku_management.*');
        $this->db->select('erp_manage_firms.firm_name');
        $this->db->select('erp_sku_details.*');
        $this->db->select("erp_product.product_name,erp_brand.brands,erp_category.categoryName");
        $this->db->join('erp_sku_details', 'erp_sku_details.sku_id=erp_sku_management.id');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_sku_management.firm_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_sku_details.cat_id', 'LEFT');
        $this->db->join('erp_product', 'erp_product.id=erp_sku_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_sku_details.brand_id', 'LEFT');
        $this->db->where("DATE_FORMAT(erp_sku_management.created_date,'%Y-%m-%d')  >= '" . $start_date . "' AND DATE_FORMAT(erp_sku_management.created_date,'%Y-%m-%d')  <= '" . $end_date . "'");
        $query = $this->db->get('erp_sku_management')->result_array();
        return $query;
    }

    public function get_all_stock_for_stockreport() {
        $this->db->select('erp_category.categoryName,erp_product.product_name,erp_brand.brands,erp_stock.quantity,erp_product.model_no,erp_stock_history.created_date');
        $this->db->select('erp_manage_firms.firm_name');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_stock.firm_id', 'left');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_stock.category');
        $this->db->join('erp_product', 'erp_product.id=erp_stock.product_id');
        $this->db->join('erp_stock_history', 'erp_stock_history.product_id=erp_stock.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_stock.brand', 'LEFT');
        $this->db->limit(10);
        $query = $this->db->get('erp_stock');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_email_details() {
        $this->db->select('*');
        $this->db->where("(type='rep_sender' OR type='rep_receiver')");
        // $this->db->where($this->erp_email_settings.'.type','q_email');
        $query = $this->db->get('erp_email_settings')->result_array();
        return $query;
    }

}
