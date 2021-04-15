<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Physical_report_model extends CI_Model {

    private $erp_stock = 'erp_stock';
    private $erp_stock_history = 'erp_stock_history';
    private $erp_category = 'erp_category';
    private $erp_product = 'erp_product';
    private $erp_brand = 'erp_brand';
    private $erp_manage_firms = 'erp_manage_firms';
    var $joinTable1 = 'erp_manage_firms r';
    var $joinTable2 = 'erp_category c';
    var $joinTable3 = 'erp_product p';
    var $joinTable4 = 'erp_brand b';
    var $primaryTable = 'erp_stock u';
    var $selectColumn = 'u.id,u.quantity,c.categoryName,p.product_name,b.brands,p.model_no,r.firm_name';
    var $column_order = array(null, 'r.firm_name', 'c.categoryName', 'p.product_name', 'b.brands', 'u.quantity', null); //set column field database for datatable orderable
    var $column_search = array('r.firm_name', 'c.categoryName', 'p.product_name', 'b.brands', 'u.quantity'); //set column field database for datatable searchable
    var $order = array('u.id' => 'ASC'); // default order

    function __construct() {
        parent::__construct();
    }

    public function get_all_stock($serch_data) {
        if (isset($serch_data) && !empty($serch_data)) {
            //print_r($serch_data);
            //exit;

            if (!empty($serch_data['category']) && $serch_data['category'] != 'Select') {

                $this->db->where($this->erp_stock . '.category', $serch_data['category']);
            }
            if (!empty($serch_data['brand']) && $serch_data['brand'] != 'Select') {
                $this->db->where($this->erp_stock . '.brand', $serch_data['brand']);
            }
            if (!empty($serch_data['product']) && count($serch_data['product'] > 0)) {
                $this->db->where_in($this->erp_stock . '.product_id', $serch_data['product']);
            }
            //if (!empty($serch_data['model_no']) && $serch_data['model_no'] != 'Select') {
            // $this->db->where($this->erp_stock . '.product_id', $serch_data['model_no']);
            //}
            if (!empty($serch_data['from_date']) && $serch_data['from_date'] != '') {
                $this->db->where($this->erp_stock_history . '.created_date >=', $serch_data['from_date'] . ' 00:00:00.000000');
            }
            if (!empty($serch_data['to_date']) && $serch_data['to_date'] != '') {
                $this->db->where($this->erp_stock_history . '.created_date <=', $serch_data['to_date'] . ' 23:59:59.999999');
            }
        }

        $this->db->select('erp_category.categoryName,erp_product.product_name,erp_brand.brands,erp_stock.quantity,erp_product.model_no,erp_stock_history.created_date');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_stock.category');
        $this->db->join('erp_product', 'erp_product.id=erp_stock.product_id');
        $this->db->join('erp_stock_history', 'erp_stock_history.product_id=erp_stock.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_stock.brand', 'LEFT');
        $this->db->group_by('erp_product.id');
        $query = $this->db->get('erp_stock');
        //print_r($query->result_array());
        //exit;
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_stock_by_id($id) {
        $this->db->select('erp_category.categoryName,erp_product.product_name,erp_brand.brands,erp_stock.quantity');
        $this->db->join('erp_category', 'erp_category.id=erp_stock.category');
        $this->db->join('erp_product', 'erp_product.id=erp_stock.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_stock.brand', 'LEFT');
        $query = $this->db->get('erp_stock');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    function _get_datatables_query() {
        //Join Table
        $this->db->join($this->joinTable1, 'r.firm_id=u.firm_id');
        $this->db->join($this->joinTable2, 'c.cat_id=u.category');
        $this->db->join($this->joinTable3, 'p.id=u.product_id');
        $this->db->join($this->joinTable4, 'b.id=u.brand', 'LEFT');
        $this->db->where('u.status', 1);
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }
        $this->db->where_in('u.firm_id', $frim_id);
        $this->db->from($this->primaryTable);
        $i = 0;
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
        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables() {
        $this->db->select($this->selectColumn);
        $this->_get_datatables_query();
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

    public function get_all_stock_for_report($entry_date) {
        //$this->db->select('(select SUM(erp_stock.quantity) from erp_stock where product_id = erp_product.id) as individual');
        $this->db->select('erp_category.categoryName,erp_product.product_name,erp_brand.brands,erp_physical_stock.*,erp_product.model_no,erp_stock_history.created_date,erp_product.cost_price');
        $this->db->select('erp_manage_firms.firm_name');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_physical_stock.firm_id', 'left');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_physical_stock.category');
        $this->db->join('erp_product', 'erp_product.id=erp_physical_stock.product_id');
        $this->db->join('erp_stock_history', 'erp_stock_history.product_id=erp_physical_stock.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_physical_stock.brand', 'LEFT');
        $this->db->where('erp_physical_stock.entry_date', $entry_date);
        //$this->db->where('erp_physical_stock.entry_date <=', $to_date);
        $this->db->group_by('erp_physical_stock.id');
        $query = $this->db->get('erp_physical_stock');
        //print_r($query->result_array());
        //exit;
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_stock_for_report_by_id($id) {
//	$start = date('Y-m-01');
//	$end = date('Y-m-t');
        $this->db->select('(select SUM(erp_stock.quantity) from erp_stock where product_id = erp_product.id) as individual');
        $this->db->select('erp_category.categoryName,erp_product.product_name,erp_brand.brands,erp_physical_stock.*,erp_product.model_no,erp_product.cost_price');
        $this->db->select('erp_manage_firms.firm_name');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_physical_stock.firm_id', 'left');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_physical_stock.category');
        $this->db->join('erp_product', 'erp_product.id=erp_physical_stock.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_physical_stock.brand', 'LEFT');

        $this->db->where('erp_physical_stock.shrinkage_id', $id);
        $query = $this->db->get('erp_physical_stock');
        //print_r($query->result_array());
        //exit;
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    function is_product_name_exist($store_name) {
        $this->db->select($this->erp_product . '.id');
        $this->db->where('LCASE(product_name)', strtolower($store_name));
//	if (!empty($cat_id))
//	    $this->db->where('category_id', $cat_id);
        $this->db->where($this->erp_product . '.status', 1);
        $query = $this->db->get($this->erp_product);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result['id'];
        }
        return 0;
    }

    function is_category_name_exist($store_name) {
        $this->db->select($this->erp_category . '.cat_id');
        $this->db->where('LCASE(categoryName)', strtolower($store_name));
        $this->db->where($this->erp_category . '.eStatus', 1);
        $query = $this->db->get($this->erp_category);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result['cat_id'];
        }
        return 0;
    }

    function is_brand_name_exist($brand_name) {
        $this->db->select($this->erp_brand . '.id');
        $this->db->where('LCASE(brands)', strtolower($brand_name));
        $this->db->where($this->erp_brand . '.status', 1);
        $query = $this->db->get($this->erp_brand);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result['id'];
        }
        return 0;
    }

    function is_firm_name_exist($firm_name) {
        $this->db->select($this->erp_manage_firms . '.firm_id');
        $this->db->where('LCASE(firm_name)', strtolower($firm_name));
        $this->db->where($this->erp_manage_firms . '.status', 1);
        $query = $this->db->get($this->erp_manage_firms);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result['firm_id'];
        }
        return 0;
    }

    public function insert_physical_stock($data) {
        $this->db->insert('erp_physical_stock', $data);
        return true;
    }

    public function insert_shrinkage($data) {
        if ($this->db->insert('erp_shrinkage', $data))
            return $this->db->insert_id();
    }

    public function get_all_shrinkage($from_date = NULL, $to_date = NULL) {
        $this->db->select('*');
        //$this->db->where('entry_date >=', $from_date);
        //$this->db->where('entry_date <=', $to_date);
        $query = $this->db->get('erp_shrinkage')->result_array();
        $i = 0;
        foreach ($query as $value) {
            $this->db->select('(select SUM(erp_stock.quantity) from erp_stock where product_id = erp_product.id) as individual');
            $this->db->select('erp_category.categoryName,erp_product.product_name,erp_brand.brands,erp_physical_stock.*,erp_product.model_no,erp_product.cost_price');
            $this->db->select('erp_manage_firms.firm_name');
            $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_physical_stock.firm_id', 'left');
            $this->db->join('erp_category', 'erp_category.cat_id=erp_physical_stock.category');
            $this->db->join('erp_product', 'erp_product.id=erp_physical_stock.product_id');
            $this->db->join('erp_brand', 'erp_brand.id=erp_physical_stock.brand', 'LEFT');

            $this->db->where('erp_physical_stock.shrinkage_id', $value['id']);
            $query[$i]['stock'] = $this->db->get('erp_physical_stock')->result_array();
            $i++;
        }
        return $query;
    }

    public function update_physical_quantity($data, $id) {
        $this->db->where('erp_physical_stock.id', $id);
        $this->db->where('erp_physical_stock.shrinkage_id', $data['shrinkage_id']);
        if ($this->db->update('erp_physical_stock', $data)) {
            return true;
        }
        return false;
    }

    public function get_all_stock_srinkage_id($id) {
        $this->db->select('erp_physical_stock.id,erp_physical_stock.shrinkage_id,erp_physical_stock.physical_quantity');
        $this->db->where('erp_physical_stock.shrinkage_id', $id);
        $query = $this->db->get('erp_physical_stock');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

}
