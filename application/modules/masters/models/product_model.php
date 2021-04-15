<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_model extends CI_Model {

    private $table_name = 'erp_product';
    private $increment_table = 'increment_table';
    private $erp_category = 'erp_category';
    private $erp_brand = 'erp_brand';
    var $joinTable1 = 'erp_manage_firms r';
    var $joinTable2 = 'erp_category c';
    var $primaryTable = 'erp_product u';
    var $selectColumn = 'u.id,u.product_name,c.categoryName,u.type,u.cost_price,u.qty,r.firm_name,u.product_image,u.barcode,u.sales_price,u.brand_id';
    var $column_order = array(null, 'u.product_name', 'c.categoryName', 'r.firm_name', 'u.type', 'u.qty', 'u.cost_price', null); //set column field database for datatable orderable
    var $column_search = array('u.product_name', 'c.categoryName', 'r.firm_name', 'u.type', 'u.qty', 'u.cost_price'); //set column field database for datatable searchable
    var $order = array('u.id' => 'DESC'); // default order
    private $erp_stock = 'erp_stock';
    private $erp_stock_history = 'erp_stock_history';

    function __construct() {



        parent::__construct();



        $this->load->database();
    }

    public function insert_product($data) {



        if ($this->db->insert($this->table_name, $data)) {



            $insert_id = $this->db->insert_id();



            return $insert_id;
        }



        return false;
    }

    public function check_imie_exists($data) {

        $this->db->select('ime_code');

        $this->db->where('status', 'open');

        $this->db->where('product_id', $data['product_id']);

        $query = $this->db->get('erp_po_ime_code_details')->result_array();



        if (!empty($query))
            return true;
        else
            return '';
    }

    public function get_product_by_firm_catid($data) {

        $firm_id = $data['firm_id'];

        $cat_id = $data['cat_id'];





        $this->db->select('id,product_name');

        if ($cat_id != 0)
            $this->db->where('category_id', $cat_id);



        $this->db->where('firm_id', $firm_id);

        $data = $this->db->get('erp_product')->result_array();



        if (empty($data))
            return 1;
        else
            return $data;
    }

    public function check_imiecode_availability($data) {

        $this->db->select('ime_code');

        $this->db->where('status', 'open');

        $this->db->where('product_id', $data['product_id']);

        $query = $this->db->get('erp_po_ime_code_details')->result_array();



        if (count($query) < $data["count"]) {

            if (count($query) == 0)
                return "IMIE code not available..Please purchase the product..";
            else
                return "Product has minimum " . count($query) . " " . "barcode...Please add valid barcode count..";
        }else {

            return 1;
        }
    }

    public function get_ime_codes($count, $product_id) {

        $this->db->select('ime_code');

        $this->db->where('product_id', $product_id);

        $this->db->where('status', 'open');

        $this->db->limit($count);

        $query = $this->db->get('erp_po_ime_code_details');

        return $query->result_array();
    }

    public function update_increment($data) {



        $this->db->where($this->increment_table . '.id', 13);



        if ($this->db->update($this->increment_table, $data)) {



            return true;
        }



        return false;
    }

    public function get_product() {



        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->where_in('firm_id', $frim_id);







        $this->db->select($this->table_name . '.*');



        $query = $this->db->get($this->table_name)->result_array();



        return $query;
    }

    public function get_product_by_id($id) {



        $this->db->select($this->table_name . '.*');



        $this->db->where($this->table_name . '.id', $id);



        $query = $this->db->get($this->table_name)->result_array();



        foreach ($query as $key => $data) {

            $query[$key]['barcode'] = html_entity_decode($data['barcode']);
        }



        return $query;
    }

    public function update_image($id, $image) {

        $this->db->where('id', $id);

        return $this->db->update('erp_product', ["product_image" => trim($image)]);
    }

    public function update_product($data, $id) {

        unset($data['submit']);

        /*

          $update = array(

          "category_id" => $data['category_id'],

          "firm_id" => $data['firm_id'],

          "brand_id" => $data['brand_id'],

          "product_name" => $data['product_name'],

          "qty" => $data['qty'],

          "min_qty" => $data['min_qty'],

          "status" => $data['status'],

          "type" => $data['type'],

          "cost_price" => $data['cost_price'],

          "cash_cus_price" => $data['cash_cus_price'],

          "credit_cus_price" => $data['credit_cus_price'],

          "cash_con_price" => $data['cash_con_price'],

          "credit_con_price" => $data['credit_con_price'],

          "vip_price" => $data['vip_price'],

          "vvip_price" => $data['vvip_price'],

          "h1_price" => $data['h1_price'],

          "h2_price" => $data['h2_price'],

          "unit" => $data['unit'],

          "is_non_gst" => $data['is_non_gst'],

          "hsn_sac" => $data['hsn_sac'],

          "igst" => $data['igst'],

          "cgst" => $data['cgst'],

          "sgst" => $data['sgst'],

          ); */

        //  echo "<pre>";print_r($data);exit;

        $this->db->set($data);

        $this->db->where('id', $id);

        if ($this->db->update($this->table_name)) {

            return true;
        }

        return false;
    }

    public function delete_product($id) {



        $this->db->where('id', $id);



        if ($this->db->delete('erp_product')) {



            return true;
        }



        return false;
    }

    function add_duplicate_product($input) {



        $this->db->select('*');



        $this->db->where('product_name', $input['pname']);



        $this->db->where('firm_id', $input['firm_id']);



        $this->db->where('status', 1);



        $query = $this->db->get('erp_product');



        if ($query->num_rows() >= 1) {



            return $query->result_array();
        }
    }

    function get_brand_name($id) {

        $this->db->select('brands');

        $this->db->where('id', $id);

        $query = $this->db->get('erp_brand')->result_array();

        return $query[0]['brands'];
    }

    function update_duplicate_product($input, $id) {



        $this->db->select('*');



        $this->db->where('model_no', $input);



        $this->db->where('id !=', $id);



        $this->db->where('status', 1);



        $query = $this->db->get('erp_product')->result_array();



        return $query;
    }

    function is_product_name_exist($store_name, $cat_id, $frim, $firm_id) {



        $this->db->select($this->table_name . '.id');



        $this->db->where('LCASE(product_name)', strtolower($store_name));



        if (!empty($cat_id))
            $this->db->where('category_id', $cat_id);



        if (!empty($frim))
            $this->db->where_not_in($this->table_name . '.firm_id', $frim);



        $this->db->where($this->table_name . '.firm_id', $firm_id);



        $this->db->where($this->table_name . '.status', 1);



        $query = $this->db->get($this->table_name);



        if ($query->num_rows() > 0) {



            $result = $query->row_array();



            return $result['id'];
        }



        return NULL;
    }

    function is_category_name_exist($store_name, $frim, $firm_id) {



        $this->db->select($this->erp_category . '.cat_id');



        $this->db->where('LCASE(categoryName)', strtolower($store_name));



        //if (!empty($frim))
        //$this->db->where_not_in($this->erp_category . '.firm_id', $frim);



        $this->db->where($this->erp_category . '.firm_id', $firm_id);



        $this->db->where($this->erp_category . '.eStatus', 1);



        $query = $this->db->get($this->erp_category);



        if ($query->num_rows() > 0) {



            $result = $query->row_array();



            return $result['cat_id'];
        }



        return NULL;
    }

    function check_cat_exists($cat, $firm) {



        $this->db->where('categoryName', $cat);

        $this->db->where('firm_id', $firm);

        $query = $this->db->get('erp_category')->result_array();



        if (!empty($query))
            return $query[0]['cat_id'];
        else
            return '';
    }

    function check_brand_exists($cat_id, $firm_id, $brand) {



        $this->db->where('brands', $brand);

        $this->db->where('cat_id', $cat_id);

        $this->db->where('firm_id', $firm_id);

        $query = $this->db->get('erp_brand')->result_array();



        if (!empty($query))
            return $query[0]['id'];
        else
            return '';
    }

    function check_product_exists($product_name, $firm_id, $cat_id, $brand_id) {



        $this->db->where('product_name', $product_name);

        $this->db->where('brand_id', $brand_id);

        $this->db->where('category_id', $cat_id);

        $this->db->where('firm_id', $firm_id);

        $query = $this->db->get('erp_product')->result_array();



        if (!empty($query))
            return $query[0]['id'];
        else
            return '';
    }

    function is_brand_name_exist($store_name, $frim, $firm_id) {



        $this->db->select($this->erp_brand . '.id');



        $this->db->where('LCASE(brands)', strtolower($store_name));



        if (!empty($frim))
            $this->db->where_not_in($this->erp_brand . '.firm_id', $frim);



        $this->db->where($this->erp_brand . '.firm_id', $firm_id);



        $this->db->where($this->erp_brand . '.status', 1);



        $query = $this->db->get($this->erp_brand);



        if ($query->num_rows() > 0) {



            $result = $query->row_array();



            return $result['id'];
        }



        return NULL;
    }

    function insert_category($data) {



        if ($this->db->insert($this->erp_category, $data)) {



            $insert_id = $this->db->insert_id();



            return $insert_id;
        }



        return false;
    }

    function insert_brand($data) {



        if ($this->db->insert($this->erp_brand, $data)) {



            $insert_id = $this->db->insert_id();



            return $insert_id;
        }



        return false;
    }

    function update_category($data, $id) {



        $this->db->where('cat_id', $id);



        if ($this->db->update($this->erp_category, $data)) {



            return true;
        }



        return false;
    }

    function _get_datatables_query() {

        //Join Table

        $this->db->join($this->joinTable1, 'r.firm_id=u.firm_id');

        $this->db->join($this->joinTable2, 'c.cat_id=u.category_id');

        $this->db->where('u.status', 1);

        $this->db->where('u.brand_id !=', 0);

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $new = implode(" , ", $frim_id);

        $this->db->where_in('u.firm_id', $frim_id);

        $this->db->from($this->primaryTable);

        $i = 0;

        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $like = "" . $item . " LIKE '%" . $_POST['search']['value'] . "%'";

                    // $this->db->like($item, $_POST['search']['value']);
                } else {

                    //   $query = $this->db->or_like($item, $_POST['search']['value']);

                    $like .= " OR " . $item . " LIKE '%" . $_POST['search']['value'] . "%'";
                }
            }

            $i++;
        }

        if ($like) {

            $where = "u.firm_id IN (" . $new . ") AND (" . $like . ")";

            $this->db->where($where);
        }

        if (isset($_POST['order']) && $this->column_order[$_POST['order']['0']['column']] != null) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables() {

        $this->db->select($this->selectColumn);

        $this->_get_datatables_query();

        $firms = $this->user_auth->get_user_firms();

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        $query = $query->result();

        foreach ($query as $key => $result_data) {



            $this->db->where('id', $result_data->brand_id);

            $brand_data = $this->db->get('erp_brand')->result_array();



            $query[$key]->brandName = $brand_data[0]['brands'];
        }

        return $query;
    }

    function count_filtered() {



        $this->_get_datatables_query();



        $query = $this->db->get();



        return $query->num_rows();
    }

    function count_all() {



        $this->db->join($this->joinTable1, 'r.firm_id=u.firm_id');



        $this->db->join($this->joinTable2, 'c.cat_id=u.category_id');



        $this->db->where('u.status', 1);



        $firms = $this->user_auth->get_user_firms();



        $frim_id = array();



        foreach ($firms as $value) {



            $frim_id[] = $value['firm_id'];
        }



        $this->db->where_in('u.firm_id', $frim_id);



        $this->db->from($this->primaryTable);



        return $this->db->count_all_results();
    }

    public function get_category_by_frim_id($id) {



        $this->db->select($this->erp_category . '.*');



        $this->db->where($this->erp_category . '.firm_id', $id);



        $this->db->where($this->erp_category . '.eStatus', 1);



        $query = $this->db->get($this->erp_category)->result_array();



        return $query;
    }

    public function get_brand_by_frim_id($id) {



        $this->db->select($this->erp_brand . '.*');



        $this->db->where($this->erp_brand . '.firm_id', $id);



        $this->db->where($this->erp_brand . '.status', 1);



        $query = $this->db->get($this->erp_brand)->result_array();



        return $query;
    }

    public function check_stock($check_stock) {



        $this->db->select('*');



        $this->db->where('category', $check_stock['category']);



        $this->db->where('product_id', $check_stock['product_id']);



        $this->db->where('firm_id', $check_stock['firm_id']);



        $current_stock = $this->db->get($this->erp_stock)->result_array();



        if (isset($current_stock) && !empty($current_stock)) {



            //Update Stock



            $quantity = $check_stock['quantity'];



            $this->db->where('category', $check_stock['category']);



            $this->db->where('product_id', $check_stock['product_id']);



            $this->db->where('firm_id', $check_stock['firm_id']);



            $insert_stock['brand'] = $check_stock['brand'];



            $this->db->update($this->erp_stock, array('quantity' => $quantity));
        } else {



            //Insert Stcok



            $insert_stock = array();



            $insert_stock['category'] = $check_stock['category'];



            $insert_stock['product_id'] = $check_stock['product_id'];



            $insert_stock['firm_id'] = $check_stock['firm_id'];



            $insert_stock['quantity'] = $check_stock['quantity'];



            $insert_stock['brand'] = $check_stock['brand'];



            $this->db->insert($this->erp_stock, $insert_stock);
        }



        //Insert Stock History



        $insert_stock_his = array();



        $insert_stock_his['ref_no'] = 'INITIAl';



        $insert_stock_his['type'] = 1;



        $insert_stock_his['category'] = $check_stock['category'];







        $insert_stock_his['product_id'] = $check_stock['product_id'];



        $insert_stock_his['brand'] = $check_stock['brand'];



        $insert_stock_his['quantity'] = $check_stock['quantity'];



        $insert_stock_his['created_date'] = date('Y-m-d H:i');



        //echo"<pre>"; print_r($insert_stock_his); exit;



        $this->db->insert($this->erp_stock_history, $insert_stock_his);
    }

    public function get_barcode_by_limit($id) {



        $this->db->select($this->table_name . '.barcode');



        $firms = $this->user_auth->get_user_firms();



        $frim_id = array();



        foreach ($firms as $value) {



            $frim_id[] = $value['firm_id'];
        }



        $this->db->where_in($this->table_name . '.firm_id', $frim_id);



        $this->db->where($id);



        $query = $this->db->get($this->table_name)->result_array();



        return $query;
    }

    public function get_all_products_to_export() {



        $this->db->select('pr.*, f.firm_name, c.categoryName, b.brands');

        $this->db->join('erp_manage_firms f', 'f.firm_id=pr.firm_id');

        $this->db->join('erp_category c', 'c.cat_id=pr.category_id');

        $this->db->join('erp_brand b', 'b.id=pr.brand_id');

        $this->db->where('pr.status', 1);



        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {



            $frim_id[] = $value['firm_id'];
        }

        $this->db->where_in('pr.firm_id', $frim_id);

        $query = $this->db->get('erp_product pr')->result_array();



        return $query;
    }

}
