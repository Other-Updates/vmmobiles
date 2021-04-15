<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Purchase_return_model extends CI_Model {

    private $table_name4 = 'master_style';
    private $table_name5 = 'master_style_size';
    private $vendor = 'vendor';
    private $erp_po = 'erp_po';
    private $erp_po_details = 'erp_po_details';
    private $increment_table = 'increment_table';
    private $erp_product = 'erp_product';
    private $erp_user = 'erp_user';
    private $erp_stock = 'erp_stock';
    private $erp_stock_history = 'erp_stock_history';
    private $erp_pr = 'erp_pr';
    private $erp_pr_details = 'erp_pr_details';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert_pr($data) {
        if ($this->db->insert($this->erp_pr, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return false;
    }

    public function insert_pr_details($data) {
        $this->db->insert($this->erp_pr_details, $data);
        return true;
    }

    public function insert_po_details($data) {
        $this->db->insert_batch($this->erp_po_details, $data);
        return true;
    }

    public function check_stock($check_stock, $po_id) {
        $this->db->select('erp_category.firm_id');
        $this->db->where('erp_category.cat_id', $check_stock['category']);
        $firm_id_details = $this->db->get('erp_category')->result_array();
        $firm_id = 0;
        if (!empty($firm_id_details)) {
            $firm_id = $firm_id_details[0]['firm_id'];
        }
        $this->db->select('*');
        $this->db->where('category', $check_stock['category']);
        $this->db->where('product_id', $check_stock['product_id']);
        //  $this->db->where('brand', $check_stock['brand']);
        $this->db->where('firm_id', $firm_id);
        $current_stock = $this->db->get($this->erp_stock)->result_array();
        if (isset($current_stock) && !empty($current_stock)) {
            //Update Stock
            $quantity = $current_stock[0]['quantity'] - $check_stock['return_quantity'];
            $this->db->where('category', $check_stock['category']);
            $this->db->where('product_id', $check_stock['product_id']);
            //    $this->db->where('brand', $check_stock['brand']);
            $this->db->where('firm_id', $firm_id);
            $this->db->update($this->erp_stock, array('quantity' => $quantity));
        } else {
            //Insert Stcok
            $insert_stock = array();
            $insert_stock['firm_id'] = $firm_id;
            $insert_stock['category'] = $check_stock['category'];
            $insert_stock['product_id'] = $check_stock['product_id'];
            $insert_stock['brand'] = $check_stock['brand'];
            $insert_stock['quantity'] = $check_stock['return_quantity'];
            $this->db->insert($this->erp_stock, $insert_stock);
        }
        //Insert Stock History
        $insert_stock_his = array();
        $insert_stock_his['ref_no'] = $po_id['po_id'];
        $insert_stock_his['type'] = 3;
        $insert_stock_his['category'] = $check_stock['category'];

        $insert_stock_his['product_id'] = $check_stock['product_id'];
        $insert_stock_his['brand'] = $check_stock['brand'];
        $insert_stock_his['quantity'] = -$check_stock['return_quantity'];
        $insert_stock_his['created_date'] = date('Y-m-d H:i');
        //echo"<pre>"; print_r($insert_stock_his); exit;
        $this->db->insert($this->erp_stock_history, $insert_stock_his);
    }

    public function insert_stock_details($data) {

        $this->db->insert_batch($this->erp_stock, $data);
        return true;
    }

    public function insert_stock_history($data) {
        $this->db->insert_batch($this->erp_stock_history, $data);
        return true;
    }

    public function get_stock_details() {
        $this->db->select('*');
        return $this->db->get($this->erp_stock)->result_array();
    }

    public function update_increment($id) {
        $this->db->where($this->increment_table . '.id', 5);
        if ($this->db->update($this->increment_table, $id)) {
            return true;
        }
        return false;
    }

    public function update_po($po_id, $data) {
        $this->db->where($this->erp_po . '.id', $po_id);
        if ($this->db->update($this->erp_po, $data)) {
            return true;
        }
        return false;
    }

    public function get_customer($atten_inputs) {
        $this->db->select('name,id,mobil_number,email_id,address1');
        $this->db->where($this->vendor . '.status', 1);
        $this->db->like($this->vendor . '.name', $atten_inputs['q']);
        $query = $this->db->get($this->vendor)->result_array();
        return $query;
    }

    public function get_customer_by_id($id) {
        $this->db->select('name,mobil_number,email_id,address1');
        $this->db->where($this->vendor . '.id', $id);
        return $this->db->get($this->vendor)->result_array();
    }

    public function get_product($atten_inputs) {
        $this->db->select('id,model_no,product_name,product_description,product_image,type,cost_price');
        $this->db->where($this->erp_product . '.status', 1);
        $this->db->where($this->erp_product . '.type', 1);
        $this->db->like($this->erp_product . '.model_no', $atten_inputs['q']);
        $query = $this->db->get($this->erp_product)->result_array();
        return $query;
    }

    public function get_product_by_id($id) {
        $this->db->select('model_no,product_name,product_description,product_image');
        $this->db->where($this->erp_product . '.id', $id);
        return $this->db->get($this->erp_product)->result_array();
    }

    public function get_all_po($serch_data) {
        $this->db->select('vendor.id as vendor, vendor.store_name,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_po.id,erp_po.po_no,erp_po.total_qty,erp_po.tax,erp_po.tax_label, vendor.state_id,'
                . 'erp_po.net_total,erp_po.delivery_schedule,erp_po.mode_of_payment,erp_po.remarks,erp_po.subtotal_qty,erp_po.estatus');
        $this->db->select('erp_manage_firms.firm_name');
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }
        $this->db->where_in('erp_po.firm_id', $frim_id);
        $this->db->where('erp_po.estatus !=', 0);
        $this->db->where('erp_po.pr_status =', 'approved');
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_po.firm_id', 'left');
        $this->db->order_by($this->erp_po . '.id', 'desc');
        $query = $this->db->get('erp_po')->result_array();

        $i = 0;
        foreach ($query as $val) {
            $this->db->select('total_qty');
            $this->db->where('po_no', $val['po_no']);
            $this->db->order_by("id", "desc");
            $this->db->limit(1);
            $this->db->order_by("id", "desc");
            $this->db->limit(2);
            $query[$i]['return'] = $this->db->get('erp_pr')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_po_by_id($id) {
        $this->db->select('vendor.id as vendor,vendor.store_name, vendor.tin,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_po.id,erp_po.po_no,erp_po.total_qty,erp_po.tax,erp_po.tax_label,vendor.state_id,erp_po.created_date,'
                . 'erp_po.net_total,erp_po.delivery_schedule,erp_po.mode_of_payment,erp_po.remarks,erp_po.subtotal_qty,erp_po.estatus,erp_po.firm_id,erp_po.pr_no');
        //$this->db->where('erp_po.estatus',1);
        $this->db->where('erp_po.id', $id);
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');
        $query = $this->db->get('erp_po');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_product_by_id($id) {
        $this->db->select('erp_product.id,erp_product.model_no,erp_product.product_name,erp_product.product_image,'
                . 'erp_po_details.product_description');
        $this->db->where('erp_po_details.id', $id);
        $this->db->join('erp_po', 'erp_po.id=erp_po_details.po_id');
        $this->db->join('erp_product', 'erp_product.id=erp_po_details.product_id');
        $query = $this->db->get('erp_po_details');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_po_details_by_id($id) {
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,'
                . 'erp_po_details.category,erp_po_details.product_id,erp_po_details.brand,erp_po_details.quantity,erp_po_details.unit,'
                . 'erp_po_details.per_cost,erp_po_details.tax,erp_po_details.gst,erp_po_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,erp_po_details.discount,erp_po_details.igst,erp_po_details.transport,'
                . 'erp_po_details.product_description,erp_po_details.delivery_quantity,erp_po_details.id as po_details_id');
        $this->db->where('erp_po_details.po_id', $id);
        $this->db->join('erp_po', 'erp_po.id=erp_po_details.po_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_po_details.category');
        $this->db->join('erp_product', 'erp_product.id=erp_po_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_po_details.brand', 'LEFT');

        $query = $this->db->get('erp_po_details')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('quantity');
            $this->db->where('category', $val['category']);
            $this->db->where('product_id', $val['product_id']);
            $this->db->where('brand', $val['brand']);
            $this->db->order_by('quantity', 'desc');
            $this->db->limit(1);
            $query[$i]['stock'] = $this->db->get('erp_stock')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_pr_by_id($id) {
        $this->db->select('vendor.id as vendor,vendor.store_name, vendor.tin,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_pr.id,erp_pr.po_no,erp_pr.total_qty,erp_pr.tax,erp_pr.tax_label,vendor.state_id,'
                . 'erp_pr.net_total,erp_pr.delivery_schedule,erp_pr.mode_of_payment,erp_pr.remarks,erp_pr.subtotal_qty,erp_pr.estatus,erp_pr.firm_id,erp_pr.pr_no');
        //$this->db->where('erp_po.estatus',1);
        $this->db->where('erp_pr.id', $id);
        $this->db->join('vendor', 'vendor.id=erp_pr.supplier');
        $query = $this->db->get('erp_pr');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_pr_details_by_id($id) {
        $this->db->select('erp_pr_details.delivery_qty,erp_pr_details.quantity,erp_pr_details.id as erp_pr_id, erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,'
                . 'erp_pr_details.category,erp_pr_details.product_id,erp_pr_details.brand,erp_pr_details.return_quantity,erp_pr_details.unit,'
                . 'erp_pr_details.per_cost,erp_pr_details.tax,erp_pr_details.return_quantity,erp_pr_details.gst,erp_pr_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,erp_pr_details.discount,erp_pr_details.igst,erp_pr_details.transport,erp_pr_details.po_id,'
                . 'erp_pr_details.product_description');
        $this->db->where('erp_pr_details.pr_id', $id);

        $this->db->join('erp_po', 'erp_po.id=erp_pr_details.po_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_pr_details.category');
        $this->db->join('erp_product', 'erp_product.id=erp_pr_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_pr_details.brand', 'LEFT');

        $query = $this->db->get('erp_pr_details')->result_array();
  //      echo $this->db->last_query();
//        echo "<pre>";
//        print_r($query);
 //       exit;

        $j = 0;
        foreach ($query as $val) {
            $this->db->select('erp_pr.total_qty,erp_pr.delivery_qty');
            // $this->db->where('product_id', $val['product_id']);
            $this->db->where('po_id', $val['po_id']);
            $query[$j]['po'] = $this->db->get('erp_pr')->result_array();
            $j++;
        }
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('quantity');
            $this->db->where('category', $val['category']);
            $this->db->where('product_id', $val['product_id']);
            $this->db->where('brand', $val['brand']);
            $this->db->order_by('quantity', 'desc');
            $this->db->limit(1);
            $query[$i]['stock'] = $this->db->get('erp_stock')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_quotation_history_by_id($id) {
        $this->db->select('vendor.id,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_quotation_history.q_no,erp_quotation_history.total_qty,erp_quotation_history.tax,erp_quotation_history.ref_name,erp_quotation_history.tax_label,erp_quotation_history.igst,'
                . 'erp_quotation_history.net_total,erp_quotation_history.delivery_schedule,erp_quotation_history.notification_date,erp_quotation_history.mode_of_payment,erp_quotation_history.remarks,erp_quotation_history.subtotal_qty');
        $this->db->where('erp_quotation_history.eStatus', 1);
        $this->db->where('erp_quotation_history.id', $id);
        $this->db->join('vendor', 'vendor.id=erp_quotation_history.vendor');
        $query = $this->db->get('erp_quotation_history');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function delete_po_details($id) {
        $this->db->where('po_id', $id);
        $this->db->delete($this->erp_po_details);
    }

    public function delete_pr_details($id) {
        $this->db->where('po_id', $id);
        $this->db->delete($this->erp_pr_details);
    }

    public function delete_pr($id) {
        $this->db->where('po_id', $id);
        $this->db->delete($this->erp_pr);
    }

    public function change_po_status($id, $status) {
        $this->db->where($this->erp_po . '.id', $id);
        if ($this->db->update($this->erp_po, array('estatus' => $status))) {
            return true;
        }
        return false;
    }

    public function delete_po($id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->erp_po, $data = array('estatus' => 0))) {
            return true;
        }
        return false;
    }

    public function update_pr($purchase_order_id, $deliver_qty) {
        $data = array();
        $data['delivery_qty'] = $deliver_qty;
        $this->db->where('erp_pr' . '.po_id', $purchase_order_id);
        if ($this->db->update('erp_pr', $data)) {
            return true;
        }
        return false;
    }

    public function get_po_details($purchase_order_id) {
        $this->db->select('erp_po_details.*');
        $this->db->where($this->erp_po_details . '.po_id', $purchase_order_id);
        return $this->db->get($this->erp_po_details)->result_array();
    }

    public function get_po($purchase_order_id) {
        $this->db->select('erp_po.*');
        $this->db->where($this->erp_po . '.id', $purchase_order_id);
        return $this->db->get($this->erp_po)->result_array();
    }

    public function update_po_details($purchase_order_id, $categoty, $brand, $data) {
        $this->db->where($this->erp_po_details . '.po_id', $purchase_order_id);
        $this->db->where($this->erp_po_details . '.category', $categoty);
        $this->db->where($this->erp_po_details . '.brand', $brand);
        if ($this->db->update($this->erp_po_details, $data)) {
            return true;
        }
        return false;
    }

    public function get_erp_pr($pr_id) {
        $this->db->select('erp_pr.*');
        $this->db->where($this->erp_pr . '.id', $pr_id);
        $query = $this->db->get($this->erp_pr)->result_array();

        return $query;
    }

    public function update_erp_pr($erp_pr_id, $data) {
        $this->db->where($this->erp_pr . '.id', $erp_pr_id);
        if ($this->db->update($this->erp_pr, $data)) {
            return true;
        }
        return false;
    }

    public function get_all_po_in_pr_table() {

        $this->db->select('erp_pr.delivery_qty,erp_pr.total_qty, vendor.id as vendor, vendor.store_name,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_pr.id,erp_pr.po_no,erp_pr.total_qty,erp_pr.tax,erp_pr.tax_label, vendor.state_id,'
                . 'erp_pr.net_total,erp_pr.delivery_schedule,erp_pr.mode_of_payment,erp_pr.remarks,erp_pr.subtotal_qty,erp_pr.estatus');
        $this->db->select('erp_manage_firms.firm_name');
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }
        $this->db->where_in('erp_pr.firm_id', $frim_id);
        $this->db->where('erp_pr.estatus !=', 0);
        $this->db->where('erp_pr.pr_status =', 'approved');
        $this->db->join('vendor', 'vendor.id=erp_pr.supplier');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_pr.firm_id', 'left');
        $this->db->order_by($this->erp_pr . '.po_id', 'desc');
        $query = $this->db->get('erp_pr')->result_array();

        $i = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(return_quantity) as return_quantity');
            $this->db->where('pr_id', $val['id']);
            $query[$i]['return_quantity'] = $this->db->get('erp_pr_details')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_pr_details($erp_pr_details_id) {
        $this->db->select('*');
        $this->db->where('id', $erp_pr_details_id);
        $query = $this->db->get('erp_pr_details')->result_array();
        //echo $this->db->last_query();
        //exit;
        return $query;
    }

    public function delete_pr_details_based_on_pr_detailsid($erp_pr_details_id) {
        $this->db->where('id', $erp_pr_details_id);
        $this->db->delete($this->erp_pr_details);
    }

    public function get_purchase_order_id($id) {
        $this->db->select('po_id');
        $this->db->where('id', $id);
        $query = $this->db->get('erp_pr')->result_array();
        return $query;
    }

    public function update_pr_details($erp_pr_details_id, $data) {
        $this->db->where($this->erp_pr_details . '.id', $erp_pr_details_id);
        if ($this->db->update($this->erp_pr_details, $data)) {
            return true;
        }
        return false;
    }

    public function update_pr_details_basedon_po_id($category, $product_id, $purchase_order_id, $delivery_quantity) {
        $data = array();
        $data['delivery_qty'] = $delivery_quantity;
        $this->db->where($this->erp_pr_details . '.po_id', $purchase_order_id);
        $this->db->where($this->erp_pr_details . '.category', $category);
        $this->db->where($this->erp_pr_details . '.product_id', $product_id);
        if ($this->db->update($this->erp_pr_details, $data)) {
            return true;
        }
        return false;
    }

    public function get_po_details_based_on_prdcat($purchase_order_id, $categoty, $brand) {
        $this->db->select('erp_po_details.*');
        $this->db->where($this->erp_po_details . '.po_id', $purchase_order_id);
        $this->db->where($this->erp_po_details . '.category', $categoty);
        $this->db->where($this->erp_po_details . '.brand', $brand);
        return $this->db->get($this->erp_po_details)->result_array();
    }

    public function getpr_details_based_on_pr($id) {
        $this->db->select('erp_pr_details.*');
        $this->db->where($this->erp_pr_details . '.pr_id', $id);
        return $this->db->get($this->erp_pr_details)->result_array();
    }

    public function get_pr_details_based_on_pr($id) {
        $this->db->select('erp_pr_details.*');
        $this->db->where($this->erp_pr_details . '.po_id', $id);
        return $this->db->get($this->erp_pr_details)->result_array();
    }

    public function get_all_purchase_return_details($purchase_order_id) {
        $this->db->select('SUM(delivery_qty) AS delivery_qty');
        $this->db->where($this->erp_pr_details . '.po_id', $purchase_order_id);
        return $this->db->get($this->erp_pr_details)->result_array();
    }

    public function update_dc($data, $purchase_order_id) {
        $this->db->where('erp_pr' . '.po_id', $purchase_order_id);
        if ($this->db->update('erp_pr', $data)) {
            return true;
        }
        return false;
    }

    function get_erp_pr_based_on_erp_po($purchase_order_id) {
        $this->db->select('erp_pr.*');
        $this->db->where($this->erp_pr . '.po_id', $purchase_order_id);
        $query = $this->db->get($this->erp_pr)->result_array();

        return $query;
    }

    public function get_al_purchase_return_details($r_id) {
        $this->db->select('SUM(delivery_qty) AS delivery_qty');
        $this->db->where($this->erp_pr_details . '.pr_id', $r_id);
        return $this->db->get($this->erp_pr_details)->result_array();
    }

}
