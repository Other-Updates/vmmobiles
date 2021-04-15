<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class User_section_model extends CI_Model {



    private $table_name = 'erp_user_sections';

    private $module_table = 'erp_user_modules';



    function __construct() {

        parent::__construct();

        $this->load->database();

    }



    function insert_user_section($data) {

        if ($this->db->insert($this->table_name, $data)) {

            $insert_id = $this->db->insert_id();

            return $insert_id;

        }

        return FALSE;

    }



    function update_user_section($data, $id) {

        $data['updated_date'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);

        if ($this->db->update($this->table_name, $data)) {

            return TRUE;

        }

        return FALSE;

    }



    function delete_user_section($id, $data) {

        if ($this->db->delete($this->table_name, $data)) {

            return TRUE;

        }

        return FALSE;

    }



    function get_user_section_by_id($id) {

        $this->db->select($this->table_name . '.*');

        $this->db->where($this->table_name . '.id', $id);

        $query = $this->db->get($this->table_name);

        if ($query->num_rows() > 0) {

            return $query->result_array();

        }

        return NULL;

    }



    function get_user_sections_by_module_id($id) {

        $this->db->select('tab_1.id,tab_1.user_section_name,,tab_1.user_section_key,acc_view,acc_add,acc_edit,acc_delete');

        $this->db->join($this->module_table . ' AS tab_2', 'tab_2.id = tab_1.module_id', 'LEFT');

        $this->db->where('tab_1.module_id', $id);

        $this->db->where('tab_1.status', 1);

         $key=["reference_groups","quotation","purchase_return","purchase_receipt","manage_sku","physical_report","delivery_challan","budget","cash_out_flow","quotation_report","hr_invoice_report","payment_receipt_report","outstanding_report_due_date","outstanding_report_firm","sales","sales_return","sales_receipt","pc_report","purchase_receipt_report"];
        
        $this->db->where_not_in('tab_1.user_section_key',$key);



        $query = $this->db->get($this->table_name . ' AS tab_1');

        if ($query->num_rows() > 0) {

            return $query->result_array();

        }

        return NULL;

    }



    function get_all_user_sections() {

        $this->db->select($this->table_name . '.*');

        $query = $this->db->get($this->table_name);

        if ($query->num_rows() > 0) {

            return $query->result_array();

        }

        return NULL;

    }



    function get_all_user_sections_with_module_name() {

        $this->db->select('tab_1.id,tab_1.user_section_name,tab_1.module_id,tab_1.status,tab_2.user_module_name');

        $this->db->join($this->module_table . ' AS tab_2', 'tab_2.id = tab_1.module_id', 'LEFT');

        $query = $this->db->get($this->table_name . ' AS tab_1');

        if ($query->num_rows() > 0) {

            return $query->result_array();

        }

        return NULL;

    }



    function get_all_user_sections_with_modules() {

        $this->db->select($this->module_table . '.*');

        $query = $this->db->get($this->module_table);






        $modules = $query->result_array();

        $user_section_arr = array();

        if (!empty($modules)) {

            foreach ($modules as $module) {

                $sections = $this->get_user_sections_by_module_id($module['id']);

                $user_section_arr[$module['id']] = $module;

                $user_section_arr[$module['id']]['sections'] = $sections;

            }

        }

        return $user_section_arr;

    }



    function is_user_section_name_available($user_section_name, $id = NULL) {

        $this->db->select($this->table_name . '.id');

        $this->db->where('LCASE(user_section_name)', strtolower($user_section_name));

        if (!empty($id))

            $this->db->where('id !=', $id);

        $query = $this->db->get($this->table_name);

        if ($query->num_rows() > 0) {

            return $query->result_array();

        }

        return NULL;

    }



    function insert_all_user_sections() {

        $this->delete_all_user_sections();



        $module_array = array(

            array(

                'module_id' => 1,

                'user_section_name' => 'Dashboard',

                'user_section_key' => 'dashboard',

                'acc_view' => 1,

                'acc_add' => 0,

                'acc_edit' => 0,

                'acc_delete' => 0

            ),

            array(

                'module_id' => 2,

                'user_section_name' => 'Suppliers',

                'user_section_key' => 'suppliers',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 2,

                'user_section_name' => 'Customers',

                'user_section_key' => 'customers',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 2,

                'user_section_name' => 'Firms',

                'user_section_key' => 'firms',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 2,

                'user_section_name' => 'User Roles',

                'user_section_key' => 'user_roles',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 2,

                'user_section_name' => 'Users',

                'user_section_key' => 'users',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 2,

                'user_section_name' => 'Products',

                'user_section_key' => 'products',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 2,

                'user_section_name' => 'Categories',

                'user_section_key' => 'categories',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 2,

                'user_section_name' => 'Brands',

                'user_section_key' => 'brands',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 2,

                'user_section_name' => 'Reference Groups',

                'user_section_key' => 'reference_groups',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 2,

                'user_section_name' => 'Sales Man',

                'user_section_key' => 'sales_man',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 2,

                'user_section_name' => 'Email Settings',

                'user_section_key' => 'email_settings',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 3,

                'user_section_name' => 'Quotation',

                'user_section_key' => 'quotation',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 4,

                'user_section_name' => 'Request',

                'user_section_key' => 'purchase_request',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 4,

                'user_section_name' => 'Order',

                'user_section_key' => 'purchase_order',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 4,

                'user_section_name' => 'Return',

                'user_section_key' => 'purchase_return',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 4,

                'user_section_name' => 'Receipt',

                'user_section_key' => 'purchase_receipt',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 5,

                'user_section_name' => 'Stock',

                'user_section_key' => 'stock',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 5,

                'user_section_name' => 'SKU',

                'user_section_key' => 'manage_sku',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 5,

                'user_section_name' => 'Shrinkage Control',

                'user_section_key' => 'physical_report',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 6,

                'user_section_name' => 'Sales',

                'user_section_key' => 'sales',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 6,

                'user_section_name' => 'Invoice',

                'user_section_key' => 'invoice',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 6,

                'user_section_name' => 'Return',

                'user_section_key' => 'sales_return',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 6,

                'user_section_name' => 'Receipt',

                'user_section_key' => 'sales_receipt',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 7,

                'user_section_name' => 'Delivery Challan',

                'user_section_key' => 'delivery_challan',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 8,

                'user_section_name' => 'Budget',

                'user_section_key' => 'budget',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 9,

                'user_section_name' => 'Cash Out Flow',

                'user_section_key' => 'cash_out_flow',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),
			
			array(

                'module_id' => 10,

                'user_section_name' => 'GST Report',

                'user_section_key' => 'gst_report',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 10,

                'user_section_name' => 'Quotation Report',

                'user_section_key' => 'quotation_report',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 10,

                'user_section_name' => 'Purchase Report',

                'user_section_key' => 'purchase_report',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 10,

                'user_section_name' => 'Purchase Receipt Report',

                'user_section_key' => 'purchase_receipt_report',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 10,

                'user_section_name' => 'Customer Based Report',

                'user_section_key' => 'customer_based_report',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 10,

                'user_section_name' => 'Stock Report',

                'user_section_key' => 'stock_report',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 10,

                'user_section_name' => 'Sales Report',

                'user_section_key' => 'pc_report',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 10,

                'user_section_name' => 'Invoice Report',

                'user_section_key' => 'invoice_report',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 10,

                'user_section_name' => 'Contractor Report',

                'user_section_key' => 'hr_invoice_report',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 10,

                'user_section_name' => 'Outstanding Report',

                'user_section_key' => 'payment_receipt_report',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 10,

                'user_section_name' => 'Outstanding Report - Due Date',

                'user_section_key' => 'outstanding_report_due_date',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 10,

                'user_section_name' => 'Outstanding Report - Firm',

                'user_section_key' => 'outstanding_report_firm',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 10,

                'user_section_name' => 'Profit and Loss Report',

                'user_section_key' => 'profit_list',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 11,

                'user_section_name' => 'Today Sales and Purchase',

                'user_section_key' => 'today_notification',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 11,

                'user_section_name' => 'Purchase Payment',

                'user_section_key' => 'purchase_notification',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 11,

                'user_section_name' => 'Invoice Payment',

                'user_section_key' => 'invoice_notification',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

            array(

                'module_id' => 11,

                'user_section_name' => 'General',

                'user_section_key' => 'general_notification',

                'acc_view' => 1,

                'acc_add' => 1,

                'acc_edit' => 1,

                'acc_delete' => 1

            ),

        );

        if (!empty($module_array)) {

            foreach ($module_array as $list) {

                $insert = $this->db->insert($this->table_name, $list);

            }

        }

        return FALSE;

    }



    function delete_all_user_sections() {

        $SQL = 'TRUNCATE TABLE erp_user_sections';

        if ($this->db->query($SQL)) {

            return TRUE;

        }

        return FALSE;

    }



}

