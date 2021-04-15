<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Brand_model extends CI_Model {

    private $table_name = 'erp_brand';
    private $table_name1 = 'increment_table';
    var $joinTable1 = 'erp_manage_firms r';
    var $primaryTable = 'erp_brand b';
    var $selectColumn = 'b.id,b.cat_id,b.brands,r.firm_name,b.firm_id,b.cat_id';
    var $column_order = array(null, 'r.firm_name', 'b.brands', null); //set column field database for datatable orderable
    var $column_search = array('r.firm_name', 'b.brands'); //set column field database for datatable searchable
    var $order = array('b.cat_id' => 'DESC'); // default order

    function __construct() {

        parent::__construct();

        $this->load->database();
    }

    function insert_brand($data) {

        if ($this->db->insert($this->table_name, $data)) {

            return true;
        }

        return false;
    }

    function get_category_id($name, $firm) {

        $this->db->where('categoryName', $name);
        $this->db->where('firm_id', $firm);
        $data = $this->db->get('erp_category')->result_array();

        if ($data) {
            return $data[0]['cat_id'];
        }
        return 0;
    }

    function is_brand_name_exist($model_name, $firm, $category) {

        $this->db->where('cat_id', $category);
        $this->db->where('brands', $model_name);
        $this->db->where('firm_id', $firm);
        $data = $this->db->get('erp_brand')->result_array();

        if ($data)
            return $data[0]['id'];
        else
            return '';
    }

    function get_brand() {

        $this->db->select($this->table_name . '.*');

        $this->db->select('erp_manage_firms.firm_name');

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->where_in($this->table_name . '.firm_id', $frim_id);

        $this->db->where($this->table_name . '.status', 1);

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=' . $this->table_name . '.firm_id', 'LEFT');

        $this->db->order_by('erp_brand.id', 'desc');

        $query = $this->db->get($this->table_name)->result_array();

        return $query;
    }

    function update_brand($data, $id) {

        $this->db->where('id', $id);

        if ($this->db->update($this->table_name, $data)) {

            return true;
        }

        return false;
    }

    function delete_master_brand($id) {

        $this->db->where('id', $id);

        if ($this->db->update($this->table_name, $data = array('status' => 0))) {

            return true;
        }

        return false;
    }

    function add_duplicate_brandname($input) {

        $this->db->select('*');

        $this->db->where('brands', $input['cname']);

        $this->db->where('firm_id', $input['firm_id']);

        $this->db->where('status', 1);

        $query = $this->db->get('erp_brand');



        if ($query->num_rows() >= 1) {

            return $query->result_array();
        }
    }

    function update_duplicate_brandname($input, $id) {

        //echo $input;
        //echo $id;
        //exit;

        $this->db->select('*');

        $this->db->where('brands', $input);

        $this->db->where('id !=', $id);

        $this->db->where('status', 1);

        $query = $this->db->get('erp_brand')->result_array();





        return $query;
    }

    function update_duplicatebrandname($input, $id, $cat_id, $firm) {

        //echo $input;
        //echo $id;
        //exit;

        $this->db->select('*');

        $this->db->where('brands', $input);

        $this->db->where('id !=', $id);
        $this->db->where('firm_id', $firm);
        $this->db->where('cat_id ', $cat_id);

        $this->db->where('status', 1);

        $query = $this->db->get('erp_brand')->result_array();





        return $query;
    }

    function get_clr($id) {

        $this->db->select('*');

        $this->db->where('id', $id);

        $query = $this->db->get('erp_brand')->result_array();

        return $query;
    }

    function _get_datatables_query() {
        //Join Table
        $this->db->join($this->joinTable1, 'r.firm_id=b.firm_id');
        $this->db->where('b.status', 1);
        $firms = $this->user_auth->get_user_firms();
        $frim_id = array();
        foreach ($firms as $value) {
            $frim_id[] = $value['firm_id'];
        }
        $new = implode(" , ", $frim_id);
        $this->db->where_in('b.firm_id', $frim_id);
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
            $where = "b.firm_id IN (" . $new . ") AND (" . $like . ")";
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

            $this->db->where('cat_id', $result_data->cat_id);

            $results = $this->db->get('erp_category')->result_array();



            if (!empty($results))
                $query[$key]->cat_name = $results[0]['categoryName'];
            else
                $query[$key]->cat_name = '';
        }
        // $datas= $query->result();
//echo "<pre>";print_r($query);exit;
        return $query;
    }

    public function count_all() {

        $this->db->from($this->primaryTable);



        return $this->db->count_all_results();
    }

    public function count_filtered() {

        $this->_get_datatables_query();



        $query = $this->db->get();



        return $query->num_rows();
    }

    public function get_brand_duplicate() {



        $this->db->select('erp_brand.*');

        $brands = $this->db->get('erp_brand')->result_array();

        $data = [];

        $datas = "";

        $invoice_details_data = "";

        foreach ($brands as $keyb => $brands_data) {

            $this->db->select('erp_brand.id, erp_brand.firm_id, erp_brand.brands');

            $this->db->where('erp_brand.firm_id', $brands_data['firm_id']);

            $this->db->where('erp_brand.brands', $brands_data['brands']);

            $data['brands_duplicate'] = $this->db->get('erp_brand')->result_array();





            if (count($data['brands_duplicate']) > 1) {



                foreach ($data['brands_duplicate'] as $key => $duplicate) {

                    if ($key > 0) {

                        $datas[] = $duplicate;

//                        $brand_id = $duplicate['id'];
//                        $this->select('inv.id,inv.in_id');
//                        $this->db->where('inv.brand', $brand_id);
//                        $invoice_details = $this->db->get('erp_invoice_details as inv')->result_array();
//                        $datas[] = $invoice_detailss;
//                        if (!empty($invoice_details)) {
//                            $invoice_details_data[$key] = $invoice_details;
//                        } else {
//                            $invoice_details_data[$key] = $brand_id;
//                        }
                    }
                }
            }
        }

        echo "<pre>";

        print_r($datas);

        exit;
    }

}
