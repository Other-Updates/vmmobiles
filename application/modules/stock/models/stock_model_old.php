<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stock_model extends CI_Model {

    private $erp_stock = 'erp_stock';
    private $erp_stock_history = 'erp_stock_history';
    private $erp_category = 'erp_category';
    private $erp_product = 'erp_product';
    private $erp_brand = 'erp_brand';
    var $joinTable1 = 'erp_manage_firms r';
    var $joinTable2 = 'erp_category c';
    var $joinTable3 = 'erp_product p';
    var $joinTable4 = 'erp_brand b';
    var $primaryTable = 'erp_stock u';
    //var $selectColumn = 'u.id,u.quantity,c.categoryName,p.product_name,b.brands,p.model_no,r.firm_name';
    var $selectColumn = 'u.id,u.quantity,c.categoryName,p.product_name,b.brands,p.model_no,r.firm_name,p.cost_price,p.cgst,p.sgst';
    var $column_order = array(null, 'r.firm_name', 'c.categoryName', 'p.product_name', 'b.brands', 'u.quantity', null); //set column field database for datatable orderable
    var $column_search = array('r.firm_name', 'c.categoryName', 'p.product_name', 'b.brands', 'u.quantity', 'p.cost_price'); //set column field database for datatable searchable
    var $order = array('u.id' => 'ASC '); // default order

    function __construct() {
        parent::__construct();
    }

    public function get_all_stock($serch_data) {


         $this->db->select('erp_category.categoryName,erp_product.product_name,erp_brand.brands,erp_stock.quantity,erp_product.model_no,erp_manage_firms.firm_name,erp_stock.id, erp_product.cost_price, erp_product.cgst, erp_product.sgst');

         
        if (isset($serch_data) && !empty($serch_data)) {

            

            if (!empty($serch_data['category']) && $serch_data['category'] != 'Select') {

                $this->db->where($this->erp_stock . '.category', $serch_data['category']);
            }
            if (!empty($serch_data['brand']) && $serch_data['brand'] != 'Select') {
                $this->db->where($this->erp_stock . '.brand', $serch_data['brand']);
            }
            if (!empty($serch_data['product']) && count($serch_data['product'] > 0)) {
                $this->db->where_in($this->erp_stock . '.product_id', $serch_data['product']);
            }

            if (!empty($serch_data['firm_id']) && count($serch_data['firm_id'] > 0)) {
              //  $this->db->where($this->erp_stock . '.firm_id', $serch_data['firm_id']);
            }
            //if (!empty($serch_data['model_no']) && $serch_data['model_no'] != 'Select') {
            // $this->db->where($this->erp_stock . '.product_id', $serch_data['model_no']);
            //}
            if (!empty($serch_data['from_date']) && $serch_data['from_date'] != '') {
                //$this->db->where($this->erp_stock_history . '.created_date >=', $serch_data['from_date'] . ' 00:00:00.000000');
            }
            if (!empty($serch_data['to_date']) && $serch_data['to_date'] != '') {
                //$this->db->where($this->erp_stock_history . '.created_date <=', $serch_data['to_date'] . ' 23:59:59.999999');
            }
        }

        if(empty($serch_data['firm_id'])){
            $firms = $this->user_auth->get_user_firms();
            $frim_id = array();
            foreach ($firms as $value) {
                $frim_id[] = $value['firm_id'];
            }
            $this->db->where_in('erp_stock.firm_id', $frim_id);
        }else{
            $this->db->where('erp_stock.firm_id', $serch_data['firm_id']);
        }
       
        $this->db->join('erp_category', 'erp_category.cat_id=erp_stock.category');
        $this->db->join('erp_product', 'erp_product.id=erp_stock.product_id');
        //$this->db->join('erp_stock_history', 'erp_stock_history.product_id=erp_stock.product_id');
        //$this->db->join('erp_brand', 'erp_brand.id=erp_stock.brand', 'LEFT');
        $this->db->join('erp_brand', 'erp_brand.id=erp_product.brand_id', 'LEFT');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_product.firm_id', 'LEFT');
        $this->db->group_by('erp_product.id');
        $query = $this->db->get('erp_stock');

        //echo $this->db->last_query();
        //exit;
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

    function _get_datatables_query($search_data = array()) {
        //Join Table
        $this->db->join($this->joinTable1, 'r.firm_id=u.firm_id', 'LEFT');
        $this->db->join($this->joinTable2, 'c.cat_id=u.category', 'LEFT');
        $this->db->join($this->joinTable3, 'p.id=u.product_id', 'LEFT');
//        $this->db->join($this->joinTable4, 'b.id=u.brand', 'LEFT');
        $this->db->join($this->joinTable4, 'b.id=p.brand_id', 'LEFT');
        $this->db->where('u.category !=', 0);
         $this->db->where('u.product_id !=', 0);
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }
        $this->db->where_in('u.firm_id', $frim_id);
        $this->db->from($this->primaryTable);
        $i = 0;
        //print_r($this->column_search);
        foreach ($this->column_search as $item) {
            // echo $_POST['search']['value'];
            // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i == 0) { // first loop
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
            }
            $i++;
        }

        if ($search_data['category'] != '' || $search_data['category'] != 'Select' || $search_data['product'] != '') {
            if ($search_data['category'] != '') { // first loop
                $this->db->where('u.category', $search_data['category']);
            }
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_firm_name($id){

        $this->db->select('firm_name,firm_id');
        $this->db->where_in('firm_id',$id);
        $query=$this->db->get('erp_manage_firms')->result_array();
        return $query;

    }
    function get_datatables($search_data, $custom_col = NULL) {
        if ($custom_col != NULL) {
            $selectColumn = 'u.id,u.quantity,c.categoryName,p.product_name,b.brands,p.model_no,r.firm_name,p.cost_price,p.cgst,p.sgst';
            $this->db->select($selectColumn);
        } else {
            $this->db->select($this->selectColumn);
        }

        $this->db->where('p.product_name !=','');
        $this->db->where('r.firm_name !=','');
         $this->db->where('b.brands !=','');
          

        $this->_get_datatables_query($search_data);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }if ($search_data['length'] != -1) {
            $this->db->limit($search_data['length'], $search_data['start']);
        }
        $query = $this->db->get();

        //echo $this->db->last_query();
        //exit;

        return $query->result();
    }

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
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

    public function get_all_stock_for_report($search = NULL, $custom_col = NULL) {
        //$this->db->select('(select SUM(erp_stock.quantity) from erp_stock where product_id = erp_product.id) as individual');

        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }

        if ($custom_col != NULL || $custom_col != '') {
            $this->db->select('erp_category.categoryName,erp_product.product_name,erp_brand.brands,erp_stock.quantity,erp_product.model_no,erp_manage_firms.firm_name,erp_stock.id, erp_product.cost_price, erp_product.cgst, erp_product.sgst');
        } else {
            $this->db->select('erp_category.categoryName,erp_product.product_name,erp_brand.brands,erp_stock.quantity,erp_product.model_no');
        }


        //$this->db->select('erp_category.categoryName,erp_product.product_name,erp_brand.brands,erp_stock.quantity,erp_product.model_no');
        $this->db->select('erp_manage_firms.firm_name');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_stock.firm_id','LEFT');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_stock.category','LEFT');
        $this->db->join('erp_product', 'erp_product.id=erp_stock.product_id','LEFT');
        //$this->db->join('erp_stock_history', 'erp_stock_history.product_id=erp_stock.product_id');
        //$this->db->join('erp_brand', 'erp_brand.id=erp_stock.brand', 'LEFT');
        $this->db->join('erp_brand', 'erp_brand.id=erp_product.brand_id', 'LEFT');
         $search_data = json_decode($search);

         if ($search_data[0]->category != '' || $search_data[1]->product != '') {         
        if ($search != NULL && $search != '') {

            $search_data = json_decode($search);
            if ($search_data[0]->category != '' && $search_data[0]->category != 'Select') {
                $this->db->where('erp_stock.category', $search_data[0]->category);

            }
            if (!empty($search_data[1]->product) && count($search_data[1]->product) > 0) {
                $pro_arr = array();
                foreach ($search_data[1]->product as $val) {
                    $pro_arr[] = $val;
                }
                $this->db->where_in('erp_stock.product_id', $pro_arr);
            }
        }
    }

        $this->db->where_in('erp_stock.firm_id', $frim_id);
        //$this->db->group_by('erp_stock.id');
        $query = $this->db->get('erp_stock');
      //  echo "query_count";print_r($query->num_rows());
       // echo "<pre>";print_r($query->result_array());
        //echo $this->db->last_query();
        //exit;

        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_stock_for_stockreport($search = NULL, $custom_col = NULL) {

        //echo "Comes here..";
        //echo "<pre>";
        //print_r($search);
        //exit;
        //$this->db->select('(select SUM(erp_stock.quantity) from erp_stock where product_id = erp_product.id) as individual');
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }
        if ($custom_col != NULL) {
            $this->db->select('erp_category.categoryName,erp_product.product_name,erp_brand.brands,erp_stock.quantity,erp_product.model_no,erp_manage_firms.firm_name,erp_stock.id, erp_product.cost_price, erp_product.cgst, erp_product.sgst');
        } else {
            $this->db->select('erp_category.categoryName,erp_product.product_name,erp_brand.brands,erp_stock.quantity,erp_product.model_no');
        }

        $this->db->select('erp_manage_firms.firm_name');
        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_stock.firm_id', 'left');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_stock.category');
        $this->db->join('erp_product', 'erp_product.id=erp_stock.product_id');
        //$this->db->join('erp_stock_history', 'erp_stock_history.product_id=erp_stock.product_id');
        //$this->db->join('erp_brand', 'erp_brand.id=erp_stock.brand', 'LEFT');
        $this->db->join('erp_brand', 'erp_brand.id=erp_product.brand_id', 'LEFT');
        if ($search != NULL && $search != '') {
            //echo "Here Comes..";
            //exit;
            $search_data = json_decode($search);
           // echo "<pre>";
           // print_r($search_data);
        
            if ($search_data[1]->category != '' && $search_data[1]->category != 'Select') {
               // $this->db->where('erp_stock.category', $search_data[1]->category);
                if($search_data[1]->category>0){
                    $this->db->where('erp_stock.category', $search_data[1]->category);
                }
            }
            if (!empty($search_data[2]->product) && count($search_data[2]->product) > 0) {
                $pro_arr = array();
                foreach ($search_data[2]->product as $val) {
                    $pro_arr[] = $val;
                }
                $this->db->where_in('erp_stock.product_id', $pro_arr);
            }
            if ($search_data[3]->brand != '' && $search_data[1]->brand != 'Select') {
                if($search_data[3]->brand>0){
                    $this->db->where('erp_stock.brand', $search_data[3]->brand);
                }
                
            }
           
        }
        $this->db->where_in('erp_stock.firm_id', $frim_id);
        //$this->db->group_by('erp_stock.id');
        $query = $this->db->get('erp_stock');

       // echo $this->db->last_query();
       // exit;
        //print_r($query->result_array());
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function update_stock($id, $data) {
        $this->db->where('erp_stock' . '.id', $id);
        if ($this->db->update('erp_stock', $data)) {
            return true;
        }
        return false;
    }

}
