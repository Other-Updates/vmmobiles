<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



/**

 * Admin_model

 *

 * This model represents admin access. It operates the following tables:

 * admin,

 *

 * @package	i2_soft

 * @author	Elavarasan

 */

class Api_model extends CI_Model {



    private $table_name = 'admin';

    private $erp_stock = 'erp_stock';

    private $erp_stock_history = 'erp_stock_history';

    private $erp_pr = 'erp_pr';

    private $erp_pr_details = 'erp_pr_details';

    private $vendor = 'vendor';

    private $erp_user = 'erp_user';

    private $agent_user = 'agent';

    private $erp_po = 'erp_po';

    private $erp_po_details = 'erp_po_details';

    private $erp_company_amount = 'erp_company_amount';

    private $erp_email_settings = 'erp_email_settings';

    private $user_table = 'erp_user';

    private $customer = 'customer';

    private $erp_product = 'erp_product';

    private $erp_quotation = 'erp_quotation';

    private $erp_invoice = 'erp_invoice';

    private $erp_sales_return = 'erp_sales_return';

    private $erp_invoice_details = 'erp_invoice_details';

    private $erp_project_cost = 'erp_project_cost';

    private $erp_project_details = 'erp_project_details';

    private $erp_other_cost = 'erp_other_cost';

    private $department = 'department';

    private $designation = 'designation';

    private $shift = 'shift';

    private $salary_group = 'salary_group';

    private $users = 'users';

    private $attendance = 'attendance';



    function __construct() {

        parent::__construct();

    }



    public function get_user_by_login($username, $password) {



        $this->db->select('tab_1.*');

        $this->db->where('username', $username);

        $this->db->where('password', md5($password));

        $query = $this->db->get($this->erp_user . ' AS tab_1');

        if ($query->num_rows() >= 1) {



            return $query->result_array();

        } else {

            $this->db->select('agent.*');

            $this->db->where('username', $username);

            $this->db->where('password', md5($password));

            $query1 = $this->db->get($this->agent_user);

            if ($query1->num_rows() >= 0) {

                return $query1->result_array();

            }

        }

        return false;

    }



    public function insert_user($data) {

        if ($this->db->insert($this->user_table, $data)) {

            $insert_id = $this->db->insert_id();

            return $insert_id;

        }

        return false;

    }



    public function get_user_role_name($id){

        $this->db->select('user_role');

        $this->db->where('id',$id);

       $query= $this->db->get('erp_user_roles')->result_array();



       if($query){

        return $query[0]['user_role'];

       }else{

        return '';

       }

    }

    public function get_today_purchase($user_id,$filter_data){

            $this->db->select('firm_id');

            $this->db->where('user_id',$user_id);

            $firms=$this->db->get('erp_user_firms')->result_array();



             $frim_id = array();

            foreach ($firms as $value) {

                $frim_id[] = $value['firm_id'];

            }



            $this->db->select('erp_manage_firms.firm_name,erp_po.po_no,vendor.name as supplier_name,erp_po.delivery_qty,erp_po.net_total');



            $this->db->join('vendor', 'vendor.id=erp_po.supplier');



           $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_po.firm_id');



           if (!empty($frim_id)) {



            $this->db->where_in('erp_po.firm_id', $frim_id);



           }



          // $this->db->group_by('erp_po.po_no');



           $this->db->where('erp_po.created_date', date('Y-m-d'));



           

           if (!empty($filter_data))

                $this->db->limit($filter_data['limit'], $filter_data['offset']);



            $query = $this->db->get('erp_po')->result_array();

    

            return $query;





    }





    public function get_user_allowed_modules($id){



        $this->db->select('id,user_section_key,acc_view');   

        $this->db->where_in('s.user_section_key',["dashboard","purchase_order","stock","sales","customer_based_report","stock_report","purchase_report","invoice_report"]);

        $query=$this->db->get('erp_user_sections as s')->result_array();





        $result='';



        foreach($query as $key=>$resut_data){

            if($resut_data['acc_view']==1){

                $result[$key]['modules']=$resut_data['user_section_key'];

                $result[$key]['status']=true;

            }else{

                $result[$key]['modules']=$resut_data['user_section_key'];

                $result[$key]['status']=false;;

            }

        }



        return $result;



    }

    public function get_today_inward($user_id){

             $this->db->select('firm_id');

            $this->db->where('user_id',$user_id);

            $firms=$this->db->get('erp_user_firms')->result_array();



             $frim_id = array();

            foreach ($firms as $value) {

                $frim_id[] = $value['firm_id'];

            }



             $this->db->select('SUM(delivery_qty) AS inward_qty,SUM(net_total) AS purchase_amount');

             $this->db->where('erp_po.created_date', date('Y-m-d'));

            // $this->db->group_by('erp_po.po_no');

             $query = $this->db->get('erp_po')->result_array();





            if($query)

               return $query;

            else

                return false;



           //  return $result;



    }



      public function get_today_outward($user_id){

             $this->db->select('firm_id');

            $this->db->where('user_id',$user_id);

            $firms=$this->db->get('erp_user_firms')->result_array();



             $frim_id = array();

            foreach ($firms as $value) {

                $frim_id[] = $value['firm_id'];

            }



             $this->db->select('SUM(delivery_qty) AS outward_qty,SUM(net_total) AS sales_amount');

             $this->db->where('erp_invoice.created_date', date('Y-m-d'));



             $query = $this->db->get('erp_invoice')->result_array();



          //   echo "<pre>";print_r($query);exit;



             if($query)

                return $query;

            else

                return 0;



            // return $result;



    }



    public function get_today_sales($user_id,$filter_data){



            $this->db->select('firm_id');

            $this->db->where('user_id',$user_id);

            $firms=$this->db->get('erp_user_firms')->result_array();



             $frim_id = array();

            foreach ($firms as $value) {

                $frim_id[] = $value['firm_id'];

            }



        $this->db->select('erp_invoice.id,erp_invoice.inv_id,erp_invoice.net_total,customer.store_name as customer_name,erp_manage_firms.firm_name,erp_invoice.delivery_qty');



        //$this->db->where('erp_invoice.payment_status', 'Pending');



        $this->db->join('customer', 'customer.id=erp_invoice.customer');



        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_invoice.firm_id');



        if (!empty($frim_id)) {



            $this->db->where_in('erp_invoice.firm_id', $frim_id);



        }



        //$this->db->group_by('erp_invoice.customer');



         $this->db->where('erp_invoice.created_date', date('Y-m-d'));



      //  $this->db->order_by('erp_invoice.created_date', date('Y-m-d'));



         if (!empty($filter_data))

                $this->db->limit($filter_data['limit'], $filter_data['offset']);



        $query = $this->db->get('erp_invoice')->result_array();



        return $query;

    }



    public function get_user_role_id_by_role($role) {

        $this->db->select('id');

        $this->db->where('LCASE(user_role)', strtolower(trim($role)));

        $this->db->where('status', 1);

        $query = $this->db->get('master_user_role')->result_array();

        if (!empty($query))

            return $query[0]['id'];

        else

            return false;

    }







    public function get_firm_id_by_name($firm) {

        $this->db->select('firm_id');

        $this->db->where('LCASE(firm_name)', strtolower(trim($firm)));

        $this->db->where('status', 1);

        $query = $this->db->get('erp_manage_firms')->result_array();

        if (!empty($query))

            return $query[0]['firm_id'];

        else

            return false;

    }



    public function insert_firm($data) {

        if ($this->db->insert('erp_user_firms', $data)) {

            $insert_id = $this->db->insert_id();

            return $insert_id;

        }

        return false;

    }



    public function get_all_po($firm_id = array(), $filter_data = array()) {



        $this->db->select('vendor.id as vendor,vendor.tin,vendor.store_name,vendor.state_id,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_po.*');

        $this->db->select('erp_manage_firms.firm_name');

//        $firms = $this->user_auth->get_user_firms();

//        $frim_id = array();

//        foreach ($firms as $value) {

//            $frim_id[] = $value['firm_id'];

//        }

        if (!empty($firm_id))

            $this->db->where_in('erp_po.firm_id', $firm_id);

        $this->db->where('erp_po.estatus !=', 0);

        $this->db->join('vendor', 'vendor.id=erp_po.supplier');

        $this->db->join('erp_po_details', 'erp_po_details.po_id=erp_po.id');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_po.firm_id', 'left');

        $this->db->group_by('erp_po.po_no');

        $this->db->order_by($this->erp_po . '.id', 'desc');

        if (!empty($filter_data))

            $this->db->limit($filter_data['limit'], $filter_data['offset']);

        $query = $this->db->get('erp_po');

        if ($query->num_rows() >= 0) {

            return $query->result_array();

        }

        return false;

    }



     public function get_all_po_total($firm_id = array(), $filter_data = array()) {



        $this->db->select('net_total');

        if (!empty($firm_id))

            $this->db->where_in('erp_po.firm_id', $firm_id);

        $this->db->where('erp_po.estatus !=', 0);

        $this->db->join('vendor', 'vendor.id=erp_po.supplier');

        $this->db->join('erp_po_details', 'erp_po_details.po_id=erp_po.id');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_po.firm_id', 'left');

        $this->db->group_by('erp_po.po_no');

        $this->db->order_by($this->erp_po . '.id', 'desc');

        if (!empty($filter_data))

            //$this->db->limit($filter_data['limit'], $filter_data['offset']);

        $query = $this->db->get('erp_po');

        $total_amt=0;

        if ($query->num_rows() >= 0) {

            $data= $query->result_array();

            foreach($data as $result){

                $total_amt +=round($result['net_total']);

            }

            return $total_amt;

        }

        return 0;;

    }







    public function get_user_firms($id) {

        $this->db->select('firm_id');

        $this->db->where('user_id', $id);

        $this->db->group_by('firm_id');

        $query = $this->db->get('erp_user_firms')->result_array();

        return $query;

    }



    public function get_all_pr($firm_id, $filter_data = array()) {



        $this->db->select('vendor.id as vendor, vendor.store_name,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_po.id,erp_po.po_no,erp_po.total_qty,erp_po.tax,erp_po.tax_label, vendor.state_id,'

                . 'erp_po.net_total,erp_po.delivery_schedule,erp_po.mode_of_payment,erp_po.remarks,erp_po.subtotal_qty,erp_po.estatus');

        $this->db->select('erp_manage_firms.firm_name');

//        $firms = $this->user_auth->get_user_firms();

//        $frim_id = array();

//        foreach ($firms as $value) {

//            $frim_id[] = $value['firm_id'];

//        }

        if (!empty($firm_id))

            $this->db->where_in('erp_po.firm_id', $firm_id);

        $this->db->where('erp_po.estatus !=', 0);

        $this->db->where('erp_po.pr_status =', 'approved');

        $this->db->join('vendor', 'vendor.id=erp_po.supplier');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_po.firm_id', 'left');

        $this->db->order_by($this->erp_po . '.id', 'desc');

         $this->db->limit($filter_data['limit'], $filter_data['offset']);

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



          foreach($query as $key=>$result_data){

            $this->db->select('quantity,delivery_quantity,per_cost');

            $this->db->where('po_id',$result_data['id']);

            $result = $this->db->get('erp_po_details')->result_array();



            $query[$key]['pro_total_qty']=$result[0]['quantity'];

            $query[$key]['pro_delivery_qty']=$result[0]['delivery_quantity'];

            $return_qty=0;

            if($result[0]['delivery_quantity']>0)

                 $return_qty=$result[0]['quantity'] - $result[0]['delivery_quantity'];

            $per_cost=$result[0]['per_cost'];

            $query[$key]['pro_return_qty']=$return_qty;

//print_r($result);echo $return_qty;exit;

            $query[$key]['pro_final_total']=$result_data['net_total'] - ($return_qty*$per_cost);

        }

        return $query;

    }



    public function get_all_receipt($firm_id, $filter_data = array()) {





        $this->db->select('erp_po.*');

        $this->db->select('vendor.store_name');

        //$firms = $this->user_auth->get_user_firms();

//        $frim_id = array();

//        foreach ($firms as $value) {

//            $frim_id[] = $value['firm_id'];

//        }

        if (!empty($firm_id))

            $this->db->where_in('erp_po.firm_id', $firm_id);

        $this->db->order_by('erp_po.id', 'desc');

        $this->db->where('erp_po.pr_status =', 'approved');

        $this->db->join('vendor', 'vendor.id=erp_po.supplier');

        $this->db->limit($filter_data['limit'], $filter_data['offset']);

        $query = $this->db->get('erp_po')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date');

            $this->db->where('purchase_receipt_bill.receipt_id', $val['id']);

            $query[$i]['receipt_bill'] = $this->db->get('purchase_receipt_bill')->result_array();

            $i++;

        }



         foreach($query as $key=>$result_data){

            $this->db->select('quantity,delivery_quantity,per_cost');

            $this->db->where('po_id',$result_data['id']);

            $result = $this->db->get('erp_po_details')->result_array();



           $return_qty=0;

            if($result[0]['delivery_quantity']>0)

                 $return_qty=$result[0]['quantity'] - $result[0]['delivery_quantity'];

             

            $per_cost=$result[0]['per_cost'];

         

            $paid_amt=$result_data['receipt_bill'][0]['receipt_paid'];

            if(empty($paid_amt))

                $paid_amt=0;



            $total_inv_amt=$result_data['net_total'] - ($return_qty*$per_cost);



            $query[$key]['pro_final_total']=$total_inv_amt;

            $query[$key]['pro_balance']=$total_inv_amt - $paid_amt;

        }



      

        return $query;

    }



    public function get_all_stock($firm_id, $filter_data = array()) {



       

        $this->db->select('erp_category.categoryName,erp_product.product_name,erp_product.id as productid,erp_brand.brands,erp_stock.quantity,erp_product.model_no,erp_manage_firms.firm_name');

        $this->db->join('erp_category', 'erp_category.cat_id=erp_stock.category');

        $this->db->join('erp_product', 'erp_product.id=erp_stock.product_id');

       // $this->db->join('erp_stock_history', 'erp_stock_history.product_id=erp_stock.product_id');

        $this->db->join('erp_brand', 'erp_brand.id=erp_stock.brand', 'LEFT');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_product.firm_id', 'LEFT');

        $this->db->where('erp_manage_firms.firm_name !=',' ');

        $this->db->group_by('erp_product.id');

         $this->db->where_in('erp_manage_firms.firm_id',$firm_id);

        if (!empty($filter_data))

            $this->db->limit($filter_data['limit'], $filter_data['offset']);

        $query = $this->db->get('erp_stock');



            $quantity=0;

        if ($query->num_rows() >= 0) {

            $data= $query->result_array();



            foreach($data as $key=>$result_data){

                $this->db->select('brand_id');

                $this->db->where('id',$result_data['productid']);

                $product_data=$this->db->get('erp_product')->result_array();



                $this->db->select('brands');

                $this->db->where('id',$product_data[0]['brand_id']);

                $brand_data=$this->db->get('erp_brand')->result_array();

                $data[$key]['brands']=$brand_data[0]['brands'];



                //$quantity +=$result_data['quantity'];

            }

           // $data['total_quantity']=$quantity;

            return $data;

        }

        return false;

    }



       public function get_all_stock_totalqty($firm_id, $filter_data = array()) {



       

        $this->db->select('erp_stock.quantity');

        $this->db->join('erp_category', 'erp_category.cat_id=erp_stock.category');

        $this->db->join('erp_product', 'erp_product.id=erp_stock.product_id');

        $this->db->join('erp_brand', 'erp_brand.id=erp_stock.brand', 'LEFT');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_product.firm_id', 'LEFT');

        $this->db->where('erp_manage_firms.firm_name !=',' ');

        $this->db->group_by('erp_product.id');

        if (!empty($filter_data))

            //$this->db->limit($filter_data['limit'], $filter_data['offset']);

        $query = $this->db->get('erp_stock');



        

        $quantity=0;

        if ($query->num_rows() >= 0) {

            $data= $query->result_array();



            foreach($data as $result){

                $quantity +=$result['quantity'];

            }

            return round($quantity);

                

        }

        return 0;

    }







    public function get_all_quotation($firm_id, $filter_data = array()) {

        $this->db->select('erp_project_cost.id,customer.id as customer,customer.store_name,customer.state_id, customer.tin,customer.name,customer.mobil_number,customer.email_id,customer.address1,customer.customer_type,customer.credit_days, customer.credit_limit, customer.temp_credit_limit, customer.approved_by,erp_project_cost.total_qty,erp_project_cost.tax,erp_project_cost.tax_label,'

                . 'erp_project_cost.job_id,erp_project_cost.net_total,erp_project_cost.notification_date,erp_project_cost.remarks,erp_project_cost.subtotal_qty,erp_project_cost.estatus,erp_project_cost.created_date');

        //$this->db->where('erp_project_cost.estatus =', 2);



        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->where_in('erp_project_cost.firm_id', $firm_id);

        $this->db->join('customer', 'customer.id=erp_project_cost.customer', 'LEFT');

        $this->db->order_by('erp_project_cost.id', 'desc');

        if (!empty($filter_data))

            $this->db->limit($filter_data['limit'], $filter_data['offset']);

        $query = $this->db->get('erp_project_cost')->result_array();

        return $query;

    }



    public function get_all_inv($firm_id, $filter_data = array()) {



        $this->db->select('customer.store_name,customer.name,customer.mobil_number,customer.email_id,customer.state_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_invoice.total_qty,erp_invoice.tax,erp_invoice.tax_label,'

                . 'erp_invoice.q_id,erp_invoice.customer,erp_invoice.net_total,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.estatus,erp_invoice.customer_po,erp_invoice.payment_status');

//        $firms = $this->user_auth->get_user_firms();

//        $frim_id = array();

//        foreach ($firms as $value) {

//            $frim_id[] = $value['firm_id'];

//        }



        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        $this->db->where('erp_invoice.estatus !=', 0);

        $this->db->where("erp_invoice.inv_id !=", 'Wings Invoice');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->limit($filter_data['limit'], $filter_data['offset']);

        $query = $this->db->get('erp_invoice')->result_array();



        $data="";

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('total_qty');

            $this->db->where('inv_id', $val['inv_id']);

            $this->db->order_by("id", "desc");

            $this->db->limit(1);

            $this->db->limit(2);

            $datas =$this->db->get('erp_sales_return')->result_array();



            if(empty($datas)){

                $query[$i]['return']=["total_qty"=>'0'];

            }else{

                  $query[$i]['return']=$datas;

            }

          

            

            $i++;

        }

    

        return $query;

    }



    public function get_all_sale_receipt($firm_id, $filter_data = array()) {



        $this->db->select('erp_invoice.*');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance');

//        $firms = $this->user_auth->get_user_firms();

//        $frim_id = array();

//        foreach ($firms as $value) {

//            $frim_id[] = $value['firm_id'];

//        }

        $this->db->where_in('erp_invoice.contract_customer', 0);

        $this->db->where_in('erp_invoice.firm_id', $firm_id);

        $this->db->order_by('erp_invoice.id', 'desc');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        if (!empty($filter_data))

            $this->db->limit($filter_data['limit'], $filter_data['offset']);

        $query = $this->db->get('erp_invoice')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date,MAX(created_date) AS paid_date');

            $this->db->where('receipt_bill.receipt_id', $val['id']);

            $query[$i]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();

            $i++;

        }

        return $query;

    }



    public function get_all_sales_id($firm_id, $filter_data = array()) {



        $this->db->select('erp_quotation.id,erp_quotation.q_no,erp_quotation.net_total,customer.store_name,erp_invoice.id as i_id,

            erp_invoice.net_total as inv_amount,erp_invoice.inv_id,erp_invoice.invoice_status,erp_invoice.payment_status,erp_invoice.delivery_status,erp_invoice.contract_customer,erp_invoice.customer,erp_invoice.created_date');

        $this->db->where('erp_quotation.estatus =', 2);

        $this->db->where('erp_invoice.payment_status =', 'Completed');

        $this->db->join('customer', 'customer.id=erp_quotation.customer');

        $this->db->join('erp_invoice', 'erp_invoice.q_id=erp_quotation.id', 'LEFT');



        $this->db->where_in('erp_quotation.firm_id', $firm_id);

        $this->db->order_by('erp_quotation.id', 'desc');

        $this->db->group_by('erp_quotation.id');

        if (!empty($filter_data))

            $this->db->limit($filter_data['limit'], $filter_data['offset']);

        $query = $this->db->get('erp_quotation')->result_array();

        $j = 0;

        $total_amt=0;

        foreach ($query as $val) {



            $this->db->select('*');

            $this->db->where('q_id', intval($val['id']));



            $invoice_data=$this->db->get('erp_invoice')->result_array();

            foreach ($invoice_data as $keys=>$vals) {

                $invoice_data[$keys]['created_date'] = ($vals['created_date']) ? date('d-M-Y', strtotime($val['created_date'])) : '-';

            }



            $query[$j]['invoice'] = $invoice_data;

            $query[$j]['created_date'] = ($val['created_date']) ? date('d-M-Y', strtotime($val['created_date'])) : '-';

            $j++;



       // $total_amt +=round($val['inv_amount']);

        }



        //$query['total_amount']=$total_amt;

        return $query;

    }



      public function get_all_sales_id_amt($firm_id, $filter_data = array()) {



        $this->db->select('erp_invoice.net_total');

        $this->db->where('erp_quotation.estatus =', 2);

        $this->db->where('erp_invoice.payment_status =', 'Completed');

        $this->db->join('customer', 'customer.id=erp_quotation.customer');

        $this->db->join('erp_invoice', 'erp_invoice.q_id=erp_quotation.id', 'LEFT');



        $this->db->where_in('erp_quotation.firm_id', $firm_id);

        $this->db->order_by('erp_quotation.id', 'desc');

        $this->db->group_by('erp_quotation.id');

        if (!empty($filter_data))

            //$this->db->limit($filter_data['limit'], $filter_data['offset']);

        $query = $this->db->get('erp_quotation')->result_array();

        $j = 0;

        $total_amt=0;

        foreach ($query as $val) {



           

        $total_amt +=round($val['net_total']);

        }



        return $total_amt;

      //  return $query;

    }

       



    public function get_all_customer() {

        $this->db->select('id,store_name as value');

        $this->db->where($this->customer . '.status', 1);

        $query = $this->db->get($this->customer)->result_array();

        return $query;

    }



    public function get_all_customer_by_id($id) {

        $this->db->select('*');

        $this->db->where($this->customer . '.id', $id);

        $this->db->where($this->customer . '.status', 1);

        $query = $this->db->get($this->customer)->result_array();

        return $query;

    }



    public function add_customres($data){ 



        $customer_data=[

            "store_name"=>$data['customer_name'],

            "address1"=>$data['address'],

            "mobil_number"=>$data['mobile_number'],

            "email_id"=>$data['email_id'],

            "tin"=>$data['gstin'],

            "firm_id"=>$data['firm_id'],

        ];





        $this->db->insert($this->customer,$customer_data);

          $insert_id = $this->db->insert_id();

         $data= $this->get_all_customer_by_id($insert_id);

         return $data;

    }



    public function check_duplicate_customer_details($data){

        $this->db->where('firm_id',$data['firm_id']);

        if($data['type']=="email")

            $this->db->where('email_id',$data['data']);

        else if($data['type']=="mobile")

            $this->db->where('mobil_number',$data['data']);



       $query= $this->db->get($this->customer)->result_array();



       if(empty($query))

        return $data['data'];

      else

        return false;;



    }





        public function add_suppliers($data){ 



        $supplier_data=[

            "store_name"=>$data['supplier_name'],

            "address1"=>$data['address'],

            "mobil_number"=>$data['mobile_number'],

            "email_id"=>$data['email_id'],

            "tin"=>$data['gstin'],

            "firm_id"=>$data['firm_id'],

        ];





        $this->db->insert($this->vendor,$supplier_data);

          $insert_id = $this->db->insert_id();

         $data= $this->get_all_supplier_by_id($insert_id);

         return $data;

    }



    public function api_check_duplicate_supplier_details($data){

        $this->db->where('firm_id',$data['firm_id']);

        if($data['type']=="email")

            $this->db->where('email_id',$data['data']);

        else if($data['type']=="mobile")

            $this->db->where('mobil_number',$data['data']);



       $query= $this->db->get($this->vendor)->result_array();



       if(empty($query))

        return $data['data'];

      else

        return false;;



    }



    public function check_dupliacate_suppliers($data){

        $this->db->where('firm_id',$data['firm_id']);

        $this->db->where('mobil_number',$data['mobile_number']);

        $this->db->where('email_id',$data['email_id']);

        $query= $this->db->get($this->vendor)->result_array();

        if(!empty($query))

            return "Email Address and Mobile Number already Exists";

        else{

            $this->db->where('firm_id',$data['firm_id']);

            $this->db->where('mobil_number',$data['mobile_number']);

            $query= $this->db->get($this->vendor)->result_array();

            if(!empty($query))

                 return "Mobile Number already Exists";

             else{

                $this->db->where('firm_id',$data['firm_id']);

                $this->db->where('email_id',$data['email_id']);

                $query= $this->db->get($this->vendor)->result_array();

                 if(!empty($query))

                        return "Email Address already Exists";

                else;

                    return '';

             }

        }

    }  



     public function check_dupliacate_customers($data){

        $this->db->where('firm_id',$data['firm_id']);

        $this->db->where('mobil_number',$data['mobile_number']);

        $this->db->where('email_id',$data['email_id']);

        $query= $this->db->get($this->customer)->result_array();

        if(!empty($query))

            return "Email Address and Mobile Number already Exists";

        else{

            $this->db->where('firm_id',$data['firm_id']);

            $this->db->where('mobil_number',$data['mobile_number']);

            $query= $this->db->get($this->vendor)->result_array();

            if(!empty($query))

                 return "Mobile Number already Exists";

             else{

                $this->db->where('firm_id',$data['firm_id']);

                $this->db->where('email_id',$data['email_id']);

                $query= $this->db->get($this->vendor)->result_array();

                 if(!empty($query))

                        return "Email Address already Exists";

                else;

                    return '';

             }

        }

    } 



      public function get_customer_by_frim_id($id) {

        $this->db->select('*');

        $this->db->where($this->customer . '.firm_id', $id);

        $this->db->where($this->customer . '.status', 1);

        $query = $this->db->get($this->customer)->result_array();

        return $query;

    }



    public function get_all_supplier() {

        $this->db->select('id,store_name as value');

        $this->db->where($this->vendor . '.status', 1);

        $query = $this->db->get($this->vendor)->result_array();

        return $query;

    }



    public function get_all_supplier_by_id($id) {

        $this->db->select('*');

        $this->db->where($this->vendor . '.id', $id);

        $this->db->where($this->vendor . '.status', 1);

        $query = $this->db->get($this->vendor)->result_array();

        return $query;

    }

      public function get_suppliers_by_frim_id($firm_id) {

        $this->db->select('*');

        $this->db->where($this->vendor . '.firm_id', $firm_id);

        $this->db->where($this->vendor . '.status', 1);

        $query = $this->db->get($this->vendor)->result_array();

        return $query;

    }

    public function get_sales_product_by_frim_id($firm_id){

        $this->db->select($this->erp_product . '.id,product_name as value');

        $this->db->select('erp_category.cat_id,categoryName');

        $this->db->select('erp_brand.id as brand,brands');

        $this->db->join('erp_category', 'erp_category.cat_id=erp_product.category_id', 'LEFT');

        $this->db->join('erp_brand', 'erp_brand.id=erp_product.brand_id', 'LEFT');

        $this->db->join('erp_stock', 'erp_stock.product_id=erp_product.id', 'LEFT');

       // $this->db->join('erp_brand', 'erp_brand.id=erp_product.brand_id', 'LEFT');

      //  $this->db->group_by('erp_stock.product_id');

        $this->db->where('erp_stock.quantity !=','0.00');

        $this->db->where($this->erp_product . '.status', 1);

        $this->db->where($this->erp_product . '.firm_id', $firm_id);

        $query = $this->db->get($this->erp_product)->result_array();

        return $query;

    }

    public function get_product_by_frim_id($firm_id) {

        $this->db->select($this->erp_product . '.id,product_name as value');

        $this->db->select('erp_category.cat_id,categoryName');

        $this->db->select('erp_brand.id as brand,brands');

        $this->db->join('erp_category', 'erp_category.cat_id=erp_product.category_id', 'LEFT');

        $this->db->join('erp_brand', 'erp_brand.id=erp_product.brand_id', 'LEFT');

       // $this->db->join('erp_stock', 'erp_stock.product_id=erp_product.id', 'LEFT');

        //$this->db->join('erp_brand', 'erp_brand.id=erp_product.brand_id', 'LEFT');

        $this->db->where($this->erp_product . '.status', 1);

        $this->db->where($this->erp_product . '.firm_id', $firm_id);

        $query = $this->db->get($this->erp_product)->result_array();

        return $query;

    }



    public function get_model_number_by_firm($atten_inputs) {

        $this->db->select('id,model_no as value');

        $this->db->where($this->erp_product . '.status', 1);

        $this->db->where($this->erp_product . '.firm_id', $atten_inputs);

        $query = $this->db->get($this->erp_product)->result_array();

        return $query;

    }



    public function get_product($input) {



          

        $this->db->select('erp_product.*,erp_product.model_no as model_number');

        $this->db->select('erp_brand.brands as model_no');

        $this->db->where('erp_product.status', 1);

        $this->db->where('erp_product.id', $input);

         $this->db->join('erp_brand', 'erp_brand.id=erp_product.brand_id', 'LEFT');

        $query = $this->db->get('erp_product')->result_array();



        foreach($query as $key=>$data){

            $this->db->select('quantity');

            $this->db->where('product_id',$data['id']);

            $get_stock_data=$this->db->get('erp_stock')->result_array();

            $query[$key]['qty']=$get_stock_data[0]['quantity'];







             $this->db->select('ime_code');

             $this->db->where('status','open');

             $this->db->where('product_id',$data['id']);

             $ime_code_details=$this->db->get('erp_po_ime_code_details')->result_array();

             $ime_results=[];

             if($ime_code_details!=""){

                $m=0;

                foreach($ime_code_details as $keys=>$datas){

                    $ime_results[$m]=$datas['ime_code'];

                    $m++;

                }

             }

             $query[$key]['ime_code_lists']=$ime_results;



             

        }

        return $query;

    }



    public function get_reference_group_by_frim_id($id) {

        $this->db->select('*');

        $this->db->where('erp_reference_groups.firm_id', $id);

        $query = $this->db->get('erp_reference_groups')->result_array();

        $i = 0;

        foreach ($query as $val) {

            if ($val['reference_type'] == 3 || $val['reference_type'] == 4) {

                $query[$i]['user_name'] = $val['others'];

                $query[$i]['user_id'] = $val['id'];

                $i++;

            } else if ($val['reference_type'] == 1) {

                $this->db->select('name');

                $this->db->where('erp_user.id', $val['user_id']);

                $user = $this->db->get('erp_user')->result_array();

                $query[$i]['user_name'] = $user[0]['name'];

                $query[$i]['user_id'] = $val['user_id'];

                $i++;

            } else if ($val['reference_type'] == 2) {

                $this->db->select('store_name');

                $this->db->where('customer.id', $val['customer_id']);

                $customer = $this->db->get('customer')->result_array();

                $query[$i]['user_name'] = $customer[0]['store_name'];

                $query[$i]['user_id'] = $val['customer_id'];

                $i++;

            }

        }

        return $query;

    }



    public function get_sales_man_by_frim_id($id) {

        $this->db->select('*');

        $this->db->where('erp_sales_man.firm_id', $id);

        $query = $this->db->get('erp_sales_man')->result_array();

        return $query;

    }



    public function get_prefix_by_frim_id($id) {

        $this->db->select('prefix');

        $this->db->where('erp_manage_firms.firm_id', $id);

        return $this->db->get('erp_manage_firms')->result_array();

    }



    public function get_all_firms($firm_id) {



        $this->db->select('erp_manage_firms.*');

        $this->db->order_by('erp_manage_firms.firm_id', 'ASC');

        $this->db->where_in('erp_manage_firms.firm_id',$firm_id);

        $query = $this->db->get('erp_manage_firms')->result_array();

        return $query;

    }



    function get_customer1($id) {

        $this->db->select('customer.*');

        $this->db->select('master_state.state,master_state.id as m_s_id,st,cst,vat,credit_days,credit_limit,advance');

        $this->db->where('customer.id', $id);

        $this->db->where('customer.status', 1);

        $this->db->join('master_state', 'master_state.id=customer.state_id', 'LEFT');

        $query = $this->db->get('customer')->result_array();

        return $query;

    }



    function get_user_info_by_id($id) {

        $this->db->select('erp_user.*');

        $this->db->where('erp_user.id', $id);

//        $this->db->where('erp_user.role', 1);

        $this->db->where('erp_user.status', 1);

        $query = $this->db->get('erp_user')->result_array();



        return $query;

    }



    public function insert_quotation($data) {

        if ($this->db->insert($this->erp_quotation, $data)) {

            $insert_id = $this->db->insert_id();



            return $insert_id;

        }

        return false;

    }



    public function get_reference_amount($id) {

        $this->db->select('erp_user.id,erp_reference_groups.commission_rate,erp_reference_groups.user_id');

        $this->db->where('erp_user.id', $id);

        $this->db->join('erp_reference_groups', 'erp_reference_groups.user_id=erp_user.id');

        $query = $this->db->get('erp_user')->result_array();

        return $query[0]['commission_rate'];

    }



    public function insert_invoice($data) {

        if ($this->db->insert($this->erp_invoice, $data)) {

            $insert_id = $this->db->insert_id();



            return $insert_id;

        }

        return false;

    }



    function update_customer($data, $id) {



        $this->db->where('id', $id);

        if ($this->db->update('customer', $data)) {



            return true;

        }

        return false;

    }



    public function insert_sr($data) {

        if ($this->db->insert($this->erp_sales_return, $data)) {

            $insert_id = $this->db->insert_id();



            return $insert_id;

        }

        return false;

    }



    public function insert_invoice_details($data) {

        $this->db->insert_batch($this->erp_invoice_details, $data);

        return true;

    }



    public function insert_invoicedetails($data) {

         if ($this->db->insert($this->erp_invoice_details, $data)) {

            $insert_id = $this->db->insert_id();



            return $insert_id;

        }

        return false;

    }



     public function update_ime_status($product_id,$ime_code_data,$qty,$data){



      //  $ime_code_data=explode(',', $ime_code);



        $update_data=[

            "status"=>"close",

            "close_date"=>date('Y-m-d H:i:s'),

            "sales_id"=>$data['sales_id'],

            "sales_details_id"=>$data['sales_details_id'],



        ];



       

        foreach($ime_code_data as $key=>$resutls){

          //  print_r($ime_code_data);exit;



            

                $this->db->where('erp_po_ime_code_details.ime_code',$resutls);

               $this->db->where('erp_po_ime_code_details.product_id',$product_id);

               $query= $this->db->update('erp_po_ime_code_details',$update_data); 

            



            

        }

        return true;

        

    }





    public function check_stock($check_stock, $inv_id) {

        $this->db->select('*');

        $this->db->where('category', $check_stock['category']);

        $this->db->where('product_id', $check_stock['product_id']);

        $this->db->where('brand', $check_stock['brand']);

        $available_stock = $this->db->get('erp_stock')->result_array();



        $ava_quantity = $available_stock[0]['quantity'] - $check_stock['quantity'];

        if ($ava_quantity < 0) {

            //Update Stock

            $quantity = $ava_quantity - $ava_quantity;

            $this->db->where('category', $check_stock['category']);

            $this->db->where('product_id', $check_stock['product_id']);

            $this->db->where('brand', $check_stock['brand']);

            //min stock notification

            $this->db->update('erp_stock', array('quantity' => $quantity));

            $this->check_min_qty($check_stock['category'], $check_stock['brand'], $check_stock['product_id'], $quantity);

        } else {

            //Insert Stcok



            $quantity = $available_stock[0]['quantity'] - $check_stock['quantity'];

            $this->db->where('category', $check_stock['category']);

            $this->db->where('product_id', $check_stock['product_id']);

            $this->db->where('brand', $check_stock['brand']);

            $this->db->update('erp_stock', array('quantity' => $quantity));

            $this->check_min_qty($check_stock['category'], $check_stock['brand'], $check_stock['product_id'], $quantity);

        }

        //Insert Stock History



        if ($check_stock['product_type'] == 'product') {

            $insert_stock_his = array();

            $insert_stock_his['ref_no'] = $inv_id['inv_id'];

            $insert_stock_his['type'] = 2;

            $insert_stock_his['category'] = $check_stock['category'];

            $insert_stock_his['product_id'] = $check_stock['product_id'];

            $insert_stock_his['brand'] = $check_stock['brand'];

            $insert_stock_his['quantity'] = -$check_stock['quantity'];

            $insert_stock_his['created_date'] = date('Y-m-d H:i');

            $this->db->insert('erp_stock_history', $insert_stock_his);

        }

    }



    public function check_min_qty($cat_id, $brand, $p_id, $quantity) {

        $this->db->select('min_qty,product_name');

        $this->db->where('erp_product.id', $p_id);

        $qty = $this->db->get('erp_product')->result_array();



        $this->db->select('quantity');

        $this->db->where('erp_stock.category', $cat_id);

        $this->db->where('erp_stock.brand', $brand);

        $this->db->where('erp_stock.product_id', $p_id);

        $stock = $this->db->get('erp_stock')->result_array();



        if ($stock[0]['quantity'] <= $qty[0]['min_qty']) {

            $notification = array();

            $notification['notification_date'] = date('Y-m-d');

            $notification['type'] = 'min_qty';

            $notification['link'] = 'stock/';

            $notification['Message'] = $qty[0]['product_name'] . ' is in minimum stock';

            if ($this->db->insert('erp_notification', $notification)) {

                return true;

            }

        }

    }



    public function insert_notification($data) {

        if ($this->db->insert('erp_notification', $data)) {

            return true;

        }

        return false;

    }



    public function insert_sales($data) {

        if ($this->db->insert($this->erp_project_cost, $data)) {

            $insert_id = $this->db->insert_id();

            return $insert_id;

        }

        return false;

    }



    public function insert_quotation_details($data) {

        $this->db->insert_batch($this->erp_project_details, $data);

        return true;

    }



    public function insert_other_cost($data) {

        $this->db->insert_batch($this->erp_other_cost, $data);

        return true;

    }



    public function get_product_for_po($atten_inputs) {

        $this->db->select('erp_product.id,model_no,product_name,product_description,product_image,type,cost_price,cgst,sgst,igst,discount,category_id,brand_id,unit,erp_stock.quantity');



        $this->db->where($this->erp_product . '.status', 1);

        $this->db->where($this->erp_product . '.id', $atten_inputs['model_number_id']);

        $this->db->join('erp_stock', 'erp_stock.product_id = erp_product.id', 'left');

        $query = $this->db->get($this->erp_product)->result_array();

        return $query;

    }



    public function get_category_by_frim_id($id) {

        $this->db->select('cat_id,categoryName	');

        $this->db->where('firm_id', $id);

        $query = $this->db->get('erp_category')->result_array();

        return $query;

    }



    public function get_brand_by_frim_id($id) {

        $this->db->select('id,brands');

        $this->db->where('firm_id', $id);

        $query = $this->db->get('erp_brand')->result_array();

        return $query;

    }



    public function insert_po($data) {

        if ($this->db->insert($this->erp_po, $data)) {

            $insert_id = $this->db->insert_id();



            return $insert_id;

        }

        return false;

    }



    public function insert_po_details($data) {

        $this->db->insert_batch($this->erp_po_details, $data);

        return true;

    }



      public function insert_podetails($data) {





         if ($this->db->insert($this->erp_po_details, $data)) {

            $insert_id = $this->db->insert_id();



           

            return $insert_id;

        }

        return false;



    }



    public function insert_pr($data) {

        if ($this->db->insert($this->erp_pr, $data)) {

            $insert_id = $this->db->insert_id();



            return $insert_id;

        }

        return false;

    }



    public function insert_pr_details($data) {

        $this->db->insert_batch($this->erp_pr_details, $data);

        return true;

    }



    public function check_stock_po($check_stock, $po_id) {

        $this->db->select('*');

        $this->db->where('category', $check_stock['category']);

        $this->db->where('product_id', $check_stock['product_id']);

        $this->db->where('brand', $check_stock['brand']);

        $current_stock = $this->db->get($this->erp_stock)->result_array();

        if (isset($current_stock) && !empty($current_stock)) {

            //Update Stock

            $quantity = $check_stock['quantity'] + $current_stock[0]['quantity'];

            $this->db->where('category', $check_stock['category']);

            $this->db->where('product_id', $check_stock['product_id']);

            $this->db->where('brand', $check_stock['brand']);

            $this->db->update($this->erp_stock, array('quantity' => $quantity));

        } else {

            //Insert Stcok

            $insert_stock = array();

            $insert_stock['category'] = $check_stock['category'];

            $insert_stock['product_id'] = $check_stock['product_id'];

            $insert_stock['brand'] = $check_stock['brand'];

            $insert_stock['quantity'] = $check_stock['quantity'];

            $this->db->insert($this->erp_stock, $insert_stock);

        }

        //Insert Stock History

        $insert_stock_his = array();

        $insert_stock_his['ref_no'] = $po_id['po_id'];

        $insert_stock_his['type'] = 1;

        $insert_stock_his['category'] = $check_stock['category'];



        $insert_stock_his['product_id'] = $check_stock['product_id'];

        $insert_stock_his['brand'] = $check_stock['brand'];

        $insert_stock_his['quantity'] = $check_stock['quantity'];

        $insert_stock_his['created_date'] = date('Y-m-d H:i');

        //echo"<pre>"; print_r($insert_stock_his); exit;

        $this->db->insert($this->erp_stock_history, $insert_stock_his);

    }



    public function get_all_po_by_id($id) {

        $this->db->select('vendor.id as vendor,vendor.store_name, vendor.tin,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_po.id,erp_po.po_no,erp_po.total_qty,erp_po.tax,erp_po.tax_label,vendor.state_id,'

                . 'erp_po.net_total,erp_po.delivery_schedule,erp_po.mode_of_payment,erp_po.remarks,erp_po.subtotal_qty,erp_po.estatus,erp_po.firm_id,erp_po.pr_no,erp_manage_firms.firm_name');

        $this->db->where('erp_po.pr_status =', 'approved');

        $this->db->where('erp_po.id', $id);

        $this->db->join('vendor', 'vendor.id=erp_po.supplier');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_po.firm_id');

        $query = $this->db->get('erp_po');

        if ($query->num_rows() >= 0) {

            return $query->result_array();

        }

        return false;

    }



    public function get_all_po_details_by_id($id) {

        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,'

                . 'erp_po_details.category,erp_po_details.product_id,erp_po_details.brand,erp_po_details.quantity,erp_po_details.unit,'

                . 'erp_po_details.per_cost,erp_po_details.tax,erp_po_details.gst,erp_po_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,erp_po_details.discount,erp_po_details.igst,erp_po_details.transport,'

                . 'erp_po_details.product_description,erp_po_details.delivery_quantity');

        $this->db->where('erp_po_details.po_id', $id);

        $this->db->where('erp_po.pr_status =', 'approved');

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



    public function update_po($data, $id) {

        $this->db->where($this->erp_po . '.id', $id);

        if ($this->db->update($this->erp_po, $data)) {

            return true;

        }

        return false;

    }



    public function delete_po_details($id) {

        $this->db->where('po_id', $id);

        $this->db->delete($this->erp_po_details);

    }



    public function check_stock_pr($check_stock, $po_id) {

        $this->db->select('*');

        $this->db->where('category', $check_stock['category']);

        $this->db->where('product_id', $check_stock['product_id']);

        $this->db->where('brand', $check_stock['brand']);

        $current_stock = $this->db->get($this->erp_stock)->result_array();

        if (isset($current_stock) && !empty($current_stock)) {

            //Update Stock

            $quantity = $current_stock[0]['quantity'] - $check_stock['return_quantity'];

            $this->db->where('category', $check_stock['category']);

            $this->db->where('product_id', $check_stock['product_id']);

            $this->db->where('brand', $check_stock['brand']);

            $this->db->update($this->erp_stock, array('quantity' => $quantity));

        } else {

            //Insert Stcok

            $insert_stock = array();

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



    public function get_receipt_by_id($id) {

        $this->db->where('erp_po.id', $id);

        $this->db->select('erp_po.*');

        $this->db->select('vendor.name,vendor.store_name, vendor.credit_days');

        $this->db->join('vendor', 'vendor.id=erp_po.supplier');

        $query = $this->db->get('erp_po')->result_array();

        $i = 0;

        foreach ($query as $val) {

            $this->db->select('*');

            $this->db->where('purchase_receipt_bill.receipt_id', $val['id']);

            $query[$i]['receipt_history'] = $this->db->get('purchase_receipt_bill')->result_array();

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



    public function insert_receipt_bill($data) {

        if ($this->db->insert('purchase_receipt_bill', $data)) {

            $insert_id = $this->db->insert_id();

            return $insert_id;

        }

        return false;

    }



    public function update_invoice($data, $id) {

        $this->db->where('id', $id);

        if ($this->db->update('erp_po', $data)) {

            return true;

        }

        return false;

    }



    public function get_firm_based_pending_invoice($frim_id, $filter_data = array()) {

        $this->db->select('erp_invoice.id,erp_invoice.customer,customer.store_name,erp_manage_firms.firm_name');

        $this->db->where('erp_invoice.payment_status', 'Pending');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_invoice.firm_id');

        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        $this->db->group_by('erp_invoice.customer');

        $this->db->order_by('erp_invoice.created_date', 'desc');

        if (!empty($filter_data))

            $this->db->limit($filter_data['limit'], $filter_data['offset']);

        $query = $this->db->get('erp_invoice')->result_array();

        return $query;

    }



    function get_stock_report($frim_id, $filter_data = array()) {

        $this->db->select('erp_product.product_name,erp_product.min_qty,erp_stock.quantity,erp_category.categoryName,erp_brand.brands');

        $this->db->join('erp_product', 'erp_product.id=erp_stock.product_id AND erp_product.min_qty >= erp_stock.quantity');

        $this->db->join('erp_category', 'erp_category.cat_id=erp_stock.category');

        $this->db->join('erp_brand', 'erp_brand.id=erp_stock.brand');

        if (!empty($filter_data))

            $this->db->limit($filter_data['limit'], $filter_data['offset']);

        $query = $this->db->get('erp_stock')->result_array();

        return $query;

    }



    function get_qty_chart($frim_id, $filter_data = array()) {

        $list_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);

        $result = array();

        foreach ($list_array as $val) {

            if ($val < 10)

                $date = (date('Y')) . '-' . str_pad($val, 2, '0', STR_PAD_LEFT);

            else

                $date = (date('Y')) . '-' . $val;



            $this->db->select('SUM(net_total) AS total_qty');

            $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m')", $date);

            if (!empty($filter_data))

                $this->db->limit($filter_data['limit'], $filter_data['offset']);

            $query = $this->db->get('erp_invoice')->result_array();



            if (!empty($query[0]['total_qty']))

                $result[$val] = $query[0]['total_qty'];

            else

                $result[$val] = 0;

        }

        return $result;

    }



    public function get_customer_by_invoice($firm_id, $cust_id) {

        $this->db->select('erp_invoice.id,inv_id,net_total');

        $this->db->select('customer.email_id,mobil_number,name');

        $this->db->where('erp_invoice.customer', $cust_id);

        $this->db->where('erp_invoice.payment_status', 'Pending');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->where_in('erp_invoice.firm_id', $firm_id);

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



    function get_all_customer_by_mobile_no($mobile_number) {

        $this->db->select('tab_1.*');

        $this->db->where('tab_1.mobil_number', $mobile_number);

        $this->db->where('tab_1.status', 1);

        $query = $this->db->get($this->customer . ' AS tab_1');

        if ($query->num_rows() > 0) {

            return $query->result_array();

        }

        return NULL;

    }



    public function insert_customer($data) {

        if ($this->db->insert($this->customer, $data)) {

            $insert_id = $this->db->insert_id();

            return $insert_id;

        }

        return false;

    }



    public function get_product_by_barcode($barcode,$type,$firm_id) {

       /* $this->db->select('*');

        $this->db->where($this->erp_product . '.status', 1);

        $this->db->where($this->erp_product . '.barcode', $barcode);

        $query = $this->db->get($this->erp_product)->result_array();

           foreach($query as $key=>$data){

            $this->db->select('quantity');

            $this->db->where('product_id',$data['id']);

            $get_stock_data=$this->db->get('erp_stock')->result_array();

            $query[$key]['qty']=$get_stock_data[0]['quantity'];

        }



        return $query;*/





        $query="";





    

        if($type=="product"){

           // $barcode=html_entity_decode($barcode, ENT_COMPAT);

            //$barcode= html_entity_decode($barcode, ENT_QUOTES);

            $barcode=htmlentities($barcode);



            

             $this->db->select('erp_product.*');

             $this->db->where('erp_product.status', 1);

             $this->db->where('erp_product.firm_id', $firm_id);

            $this->db->like('barcode', $barcode);

            $this->db->limit(1);



            $query=$this->db->get('erp_product')->result_array();

            



        }elseif($type=="imei"){

             $this->db->select('erp_product.*');

             $this->db->where('ime.ime_code',$barcode);

            $this->db->where('ime.status','open');

           $this->db->where('erp_product.status', 1);

         //  $this->db->where('erp_product.firm_id', $firm_id);

           $this->db->join('erp_product', 'erp_product.id=ime.product_id');

          $this->db->limit(1);

          $query= $this->db->get('erp_po_ime_code_details as ime')->result_array();

        }

   

        if(!empty($query)){

               foreach($query as $key=>$data){

            $this->db->select('quantity');

            $this->db->where('product_id',$data['id']);

            $get_stock_data=$this->db->get('erp_stock')->result_array();

            $query[$key]['qty']=$get_stock_data[0]['quantity'];



            $this->db->select('brands');

            $this->db->where('id',$data['brand_id']);

            $get_brand_data=$this->db->get('erp_brand')->result_array();

             $query[$key]['model_no']=$get_brand_data[0]['brands'];



             $this->db->select('ime_code');

             $this->db->where('status','open');

             $this->db->where('product_id',$data['id']);

             $ime_code_details=$this->db->get('erp_po_ime_code_details')->result_array();

             $ime_results="";

             if($ime_code_details!=""){

                $m=0;

                foreach($ime_code_details as $keys=>$datas){

                    $ime_results[$m]=$datas['ime_code'];

                    $m++;

                }

             }

             $query[$key]['ime_code_lists']=$ime_results;



        }

        }

       



return $query;



    }



    public function get_monthly_amount($barcode) {

        $start_date = date('Y-m-01');

        $end_date = date('Y-m-t');

        $this->db->select('SUM(paid_amt) AS paid_amount,SUM(balance) AS balance');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=payment_report.firm_id');

        $this->db->where("DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') >='" . $start_date . "' AND DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') <= '" . $end_date . "'");

        $query = $this->db->get('payment_report')->result_array();



     

         return $query;

  

     

       

        

    }



    public function get_customer_based_datatables($serch_data = array()) {


        $this->db->select('firm_id');

        $this->db->where('user_id',$serch_data['user_id']);

        $firms=$this->db->get('erp_user_firms')->result_array();


        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->distinct();

        $this->db->select('erp_invoice.*');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance');



        //$this->db->where_in('erp_invoice.contract_customer', 0);

      
          
        $this->db->where_in('erp_invoice.firm_id', $frim_id);
        

        $this->db->where('erp_invoice.net_total >', 0);

        if (!empty($serch_data['overdue']) && $serch_data['overdue'] != '' && $serch_data['overdue'] == 3) {

            $this->db->where('customer.advance >', 0);

        }

        //$this->db->order_by('erp_invoice.id', 'desc');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->join('erp_invoice_details', 'erp_invoice.id=erp_invoice_details.in_id');

        //$this->db->where('customer', 822);

        

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
        
        if (!empty($serch_data['limit']))
            $this->db->limit($serch_data['limit'], $serch_data['offset']);

        $query = $this->db->get('erp_invoice')->result_array();

     

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

            //echo $this->db->last_query() . '<br />';

        }



        return $query;

    }



    public function get_outstanding_duedate_datatables($serch_data = array()) {

        $this->_get_outstanding_duedate_datatables_query($serch_data);

        if (!empty($serch_data['limit']))

            $this->db->limit($serch_data['limit'], $serch_data['offset']);



        $query = $this->db->get('customer')->result_array();

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

            $this->db->where('payment_report.balance >', 0.1);

            $this->db->where_in('payment_report.firm_id', $serch_data['frim_id']);

            $this->db->group_by('payment_report.customer');

            $this->db->from('payment_report');

            $query[$i]['days'] = $this->db->get()->result_array();



            //$this->db->select('*');

            $this->db->select('SUM(balance) as new_balance');

            $this->db->where("DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') >='" . $thirty_date . "' AND DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') <= '" . $seven_date1 . "'");

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id !=', 'Wings Invoice');

            $this->db->where('payment_report.balance >', 0.1);

            $this->db->where_in('payment_report.firm_id', $serch_data['frim_id']);

            $this->db->group_by('payment_report.customer');

            $this->db->from('payment_report');

            $query[$i]['sevendays'] = $this->db->get()->result_array();



            //$this->db->select('*');

            $this->db->select('SUM(balance) as new_balance');

            $this->db->where("DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') >='" . $ninty_date . "' AND DATE_FORMAT(payment_report.created_date,'%Y-%m-%d') <= '" . $thirty_date1 . "'");

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id !=', 'Wings Invoice');

            $this->db->where('payment_report.balance >', 0.1);

            $this->db->where_in('payment_report.firm_id', $serch_data['frim_id']);

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

            $this->db->where_in('payment_report.firm_id', $serch_data['frim_id']);

            $this->db->group_by('payment_report.customer');

            $this->db->from('payment_report');

            $query[$i]['nintydays'] = $this->db->get()->result_array();





            //$this->db->select('*');

            $this->db->select('SUM(balance) as new_balance');

            $this->db->where('payment_report.customer', $val['id']);

            //$this->db->where('payment_report.firm_id', $val['firm_id']);

            $this->db->where('payment_report.inv_id', 'Wings Invoice');

            $this->db->where('payment_report.balance >', 0.1);

            $this->db->where_in('payment_report.firm_id', $serch_data['frim_id']);

            $this->db->group_by('payment_report.customer');

            $query[$i]['rec'] = $this->db->get('payment_report')->result_array();

            $i++;

        }

        return $query;

    }



    function _get_outstanding_duedate_datatables_query($search_data = array()) {





        $this->db->distinct('customer.id');

        $this->db->select('payment_report.balance,payment_report.customer,payment_report.inv_id');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance,customer.id');



        if (!empty($search_data['cust_type']) && $search_data['cust_type'] != 9) {

            $this->db->where_in($this->customer . ".customer_type", $search_data['cust_type']);

        }

        if (!empty($search_data['cust_reg']) && $search_data['cust_reg'] != 'both') {

            $this->db->where($this->customer . ".customer_region", $search_data['cust_reg']);

        }



        $this->db->join('payment_report', 'payment_report.customer=customer.id');

        $this->db->where("payment_report.balance >", 0.1);

//        $this->db->where("payment_report.inv_id !=", 'Wings Invoice');

        $this->db->group_by("payment_report.customer");

    }



    public function get_profit_datatables($search_data) {

        //$this->db->select($this->selectColumn);

        $this->_get_profit_datatables_query($search_data);

        if (!empty($search_data['limit']))

            $this->db->limit($search_data['limit'], $search_data['offset']);

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



    public function _get_profit_datatables_query($search_data = array()) {

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

    }



    public function get_product_name() {

        $this->db->select('*');

        $this->db->where($this->erp_product . '.status', 1);

        $query = $this->db->get($this->erp_product)->result_array();

        return $query;

    }



    public function get_payment_datatables($search_data) {



        //$this->db->select($this->selectColumn);

        $this->_get_payment_datatables_query($search_data);



        if (!empty($search_data['limit']))

            $this->db->limit($search_data['limit'], $search_data['offset']);



        $query = $this->db->get('erp_invoice')->result_array();



        $i = 0;

        foreach ($query as $val) {

            // $this->db->select('erp_invoice.net_total');



            $this->db->select('SUM(erp_invoice.net_total) AS net_total, MAX(erp_invoice.created_date) AS created_date');

            $this->db->select('SUM(receipt_bill.discount) AS receipt_discount,SUM(receipt_bill.bill_amount) AS receipt_paid,MAX(receipt_bill.due_date) AS next_date,MAX(receipt_bill.created_date) AS paid_date');

            $this->db->where('erp_invoice.customer', $val['id']);

            $this->db->where_in('erp_invoice.firm_id', $search_data['firm_id']);

            $this->db->where_in('erp_invoice.contract_customer', 0);

            $this->db->join('receipt_bill', 'receipt_bill.receipt_id=erp_invoice.id', 'left');

            $query[$i]['receipt_bill'] = $this->db->get('erp_invoice')->result_array();



            $i++;

        }



        return $query;

    }



    public function _get_payment_datatables_query($serch_data = array()) {

        if (isset($serch_data) && !empty($serch_data)) {



            if (!empty($serch_data['firm'])) {



                $this->db->where($this->erp_invoice . '.firm_id', $serch_data['firm']);

            }

            if (!empty($serch_data['customer'])) {

                $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);

            }

        }



        $this->db->distinct('customer.id');

        $this->db->select('erp_invoice.firm_id');

        $this->db->select('customer.name,customer.store_name,customer.mobil_number,customer.advance,customer.id');

        $this->db->join('customer', 'customer.id=erp_invoice.customer', 'left');



        $this->db->where_in('erp_invoice.firm_id', $serch_data['firm_id']);

        $this->db->where('erp_invoice.net_total >', 0);

    }



    public function get_outstanding_datatables($search_data = array()) {

        //$this->db->select($this->selectColumn);

        $this->_get_outstanding_datatables_query($search_data);

        if (!empty($search_data['limit']))

            $this->db->limit($search_data['limit'], $search_data['offset']);

        $query = $this->db->get('erp_invoice')->result_array();



        $i = 0;

        foreach ($query as $duedate) {



            $due_date = $duedate['credit_due_date'];

            $seven_date = date('Y-m-d', strtotime("+7 day", strtotime($duedate['credit_due_date'])));

            $thirty_date = date('Y-m-d', strtotime("+30 day", strtotime($duedate['credit_due_date'])));

            $ninty_date = date('Y-m-d', strtotime("+90 day", strtotime($duedate['credit_due_date'])));



            if ($search_data['firm_id'] == 1) {



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

            if ($search_data['firm_id'] == 2) {



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

            if ($search_data['firm_id'] == 3) {



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

            if ($search_data['firm_id'] == 4) {



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



    public function _get_outstanding_datatables_query($search_data = array()) {

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

    }



//    public function get_invoice_datatables($serch_data) {

//

//        if (!empty($serch_data['from_date']))

//            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));

//        if (!empty($serch_data['to_date']))

//            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));

//        if ($serch_data['from_date'] == '1970-01-01')

//            $serch_data['from_date'] = '';

//        if ($serch_data['to_date'] == '1970-01-01')

//            $serch_data['to_date'] = '';

//

//        if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {

//            $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);

//        }

//        if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

//            $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);

//        }

//        if (!empty($serch_data['sales_man']) && $serch_data['sales_man'] != 'Select') {

//            $this->db->where($this->erp_invoice . '.sales_man', $serch_data['sales_man']);

//        }

//        if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {

//            $this->db->where($this->erp_invoice_details . '.product_id', $serch_data['product']);

//        }

//        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

//

//            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

//        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

//

//            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");

//        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

//

//            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");

//        }

//

//        $this->db->select('customer.id as customer,customer.store_name,customer.tin,customer.state_id, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_quotation.q_no,erp_invoice.total_qty,erp_invoice.tax,erp_quotation.ref_name,erp_invoice.tax_label,'

//                . 'erp_invoice.net_total,erp_invoice.created_date,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_sales_man.sales_man_name,erp_invoice.q_id');

//

//        $firms = $this->user_auth->get_user_firms();

//        $frim_id = array();

//        foreach ($firms as $value) {

//            $frim_id[] = $value['firm_id'];

//        }

//        $this->db->where_in('erp_invoice.firm_id', $serch_data['frim_id']);

//        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');

//        $this->db->join('customer', 'customer.id=erp_invoice.customer');

//        $this->db->join('erp_sales_man', 'erp_sales_man.id=erp_invoice.sales_man', 'LEFT');

//        $this->db->join('erp_invoice_details', 'erp_invoice_details.in_id=erp_invoice.id');

//        $this->db->group_by('erp_invoice.id');

//

//

//        if (!empty($serch_data['limit']))

//            $this->db->limit($serch_data['limit'], $serch_data['offset']);

//

//        $query = $this->db->get('erp_invoice')->result_array();

//        $i = 0;

//        foreach ($query as $val) {

//            $this->db->select('*');

//            $this->db->where('j_id', intval($val['id']));

//            $this->db->where('type', 'invoice');

//            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();

//            $i++;

//        }

//        $i2 = 0;

//        foreach ($query as $val) {

//            $this->db->select('SUM((tax / 100 ) * (per_cost * quantity)) as cgst, SUM((gst / 100 ) * (per_cost * quantity)) as sgst');

//            $this->db->where('in_id', intval($val['id']));

//            $query[$i2]['erp_invoice_details'] = $this->db->get('erp_invoice_details')->result_array();

//            $i2++;

//        }

//        $j = 0;

//        foreach ($query as $val) {

//            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date,MAX(created_date) AS paid_date');

//            $this->db->where('receipt_bill.receipt_id', $val['id']);

//            $query[$j]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();

//            $j++;

//        }

//        if (!empty($inv_all_details) && !empty($query)) {

//            $query['inv_all_details'] = $inv_all_details;

//        }

//        return $query;

//    }



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

                $this->db->where_in($this->erp_invoice . '.firm_id', $serch_data['firm_id']);

            } else {



                $firms = array('1', '2', '3', '4');

                if (!empty($serch_data['firm_id']) && $serch_data['firm_id'] != 'Select') {

                    $firms = $serch_data['firm_id'];

                }

                $frim_id = array();



                foreach ($firms as $value) {

                    $frim_id[] = $value['firm_id'];

                }

                $this->db->where_in('erp_invoice.firm_id', $frim_id);

            }

            $inv_id = array();

            foreach ($serch_data['inv_id'] as $values) {

                $inv_id[] = $values;

            }

            if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {

                $this->db->where_in($this->erp_invoice . '.id', $inv_id);

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



            // $this->db->where($this->erp_invoice . '.id', 6804);



            if (!empty($serch_data['limit']))

                $this->db->limit($serch_data['limit'], $serch_data['offset']);

            $invoices = $this->db->get('erp_invoice_details')->result_array();

            // echo $this->db->last_query();exit;

            $inv_all_details = array();

            $count = 1;

            if (!empty($invoices)) {



                // echo "<pre>";print_r($invoices);exit;



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



                // echo "<pre>";print_r($inv_all_details);exit;



                $invoiceIds = array_map(function($invoices) {

                    return $invoices['in_id'];

                }, $invoices);



                $invoiceIds = array_unique($invoiceIds);



                // echo "<pre>"; print_r($invoiceIds); exit;



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

            // $this->db->where($this->erp_invoice . '.firm_id', $serch_data['firm_id']);

        }

        $inv_id = array();

        foreach ($serch_data['inv_id'] as $values) {

            $inv_id[] = $values;

        }

        if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {

            $this->db->where_in($this->erp_invoice . '.id', $inv_id);

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

                . 'erp_invoice.remarks,erp_invoice.subtotal_qty,'

                . 'erp_invoice.estatus,erp_invoice.customer_po,erp_sales_man.sales_man_name,erp_invoice.q_id,erp_manage_firms.gstin,,erp_manage_firms.firm_name');



        $firms = array('1', '2', '3', '4');

        if (!empty($serch_data['firm_id']) && $serch_data['firm_id'] != 'Select') {

            $firms = $serch_data['firm_id'];

        }

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->where_in('erp_invoice.firm_id', $frim_id);

        $this->db->where('erp_invoice.subtotal_qty !=', 0);

        //if (empty($serch_data)) {

        //  $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%m') = '" . date('m') . "'");

        //}

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_invoice.firm_id');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->join('erp_sales_man', 'erp_sales_man.id=erp_invoice.sales_man', 'LEFT');

        $this->db->join('erp_invoice_details', 'erp_invoice_details.in_id=erp_invoice.id');

        $this->db->group_by('erp_invoice.id');

        $this->db->order_by('erp_invoice.id', 'desc');

        if (!empty($serch_data['limit']))

            $this->db->limit($serch_data['limit'], $serch_data['offset']);

        $query = $this->db->get('erp_invoice')->result_array();

        //echo $this->db->last_query();

        //exit;

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

            $query['inv_all_details'] = $inv_all_details;

        }



        // echo "<pre>"; print_r($query); exit;





        return $query;

    }



    public function get_sales_man($firms) {

        $this->db->select('erp_sales_man.*');

        $this->db->select('erp_manage_firms.firm_name');

        //$firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];

        }

        $this->db->where_in('erp_sales_man.firm_id', $frim_id);

        $this->db->where('erp_sales_man.status', 1);

        $this->db->join('erp_manage_firms', 'erp_manage_firms.firm_id=erp_sales_man.firm_id');

        $query = $this->db->get('erp_sales_man')->result_array();

        return $query;

    }



    public function get_present_list($date = NULL) {

        $query = array();

        if ($date != NULL) {

            $this->db->select('u.id,u.employee_id,u.username ,u.first_name,a.in as In_time,a.out as Out_time ,d.name as department,des.name as Designation');

            $this->db->join('users u', 'a.user_id = u.id');

            $this->db->join('user_department ud', 'ud.user_id=u.id');

            $this->db->join('department d', 'ud.department=d.id ');

            $this->db->join('designation des', 'des.id = ud.designation');

            $where = "DATE_FORMAT(a.created, '%Y-%m-%d') ='$date'";



//            $where = "DATE_FORMAT(a.created, '%Y-%m-%d') ='2018-09-06'";

            $this->db->where($where);

            $query = $this->db->get('attendance a')->result_array();

        }



        return $query;

    }



    public function get_absent_list($date = NULL) {

        $query = array();

        if ($date != NULL) {

            $this->db->distinct();

//            $this->db->select('u.id');

            $this->db->select('u.id,u.employee_id,u.username ,u.first_name,d.name as department,des.name as Designation');

            $this->db->join('users u', 'a.user_id = u.id');

            $this->db->join('user_department ud', 'ud.user_id=u.id');

            $this->db->join('department d', 'ud.department=d.id ');

            $this->db->join('designation des', 'des.id = ud.designation');

            $where = "DATE_FORMAT(a.created, '%Y-%m-%d') != '$date'";



//            $where = "DATE_FORMAT(a.created, '%Y-%m-%d') ='2018-09-06'";

            $this->db->where($where);

            $query = $this->db->get('attendance a')->result_array();

        }



        return $query;

    }



    public function get_present_absent_details($userid, $start_date) {

        $this->db->select('a.in');

        $where = "DATE_FORMAT(a.created, '%Y-%m-%d') ='$start_date' AND a.user_id=$userid";

        $this->db->where($where);

        $query = $this->db->get('attendance a')->result_array();

        return $query;

    }



    public function get_total_employess() {

        $this->db->where($this->users . '.status', 1);

        $query = $this->db->get($this->users)->num_rows();

        return $query;

    }



    public function get_late_list() {

        $time = '09:00:00';

        $this->db->select('u.id,u.employee_id,u.username ,u.first_name,a.in as In_time ,d.name as department,des.name as Designation');

        $this->db->join('users u', 'a.user_id = u.id');

        $this->db->join('user_department ud', 'ud.user_id=u.id');

        $this->db->join('department d', 'ud.department=d.id ');

        $this->db->join('designation des', 'des.id = ud.designation');

        $this->db->where('DATE_FORMAT(a.created,"%Y-%m-%d")', date('Y-m-d'));

        $this->db->where("TIME_FORMAT(a.in,'%h:%i:%s') >", $time);

        $query = $this->db->get('attendance a')->result_array();

        return $query;

    }



    public function get_late_out_list() {

        $time = '18:00:00';

        $this->db->select('u.id,u.employee_id,u.username ,u.first_name,a.out as Out_time ,d.name as department,des.name as Designation,a.created');

        $this->db->join('users u', 'a.user_id = u.id');

        $this->db->join('user_department ud', 'ud.user_id=u.id');

        $this->db->join('department d', 'ud.department=d.id ');

        $this->db->join('designation des', 'des.id = ud.designation');

        $this->db->where('DATE_FORMAT(a.created,"%Y-%m-%d")', date('Y-m-d'));

        // $this->db->where("TIME_FORMAT(a.out,'%h:%i:%s') >", $time);

        $this->db->where("a.out >", $time);

        $query = $this->db->get('attendance a')->result_array();

        // echo $this->db->last_query();

//        print_r($query);

//        exit;

        return $query;

    }



    public function get_early_in_list() {

        $time = '09:00:00';

        $this->db->select('u.id,u.employee_id,u.username ,u.first_name,a.in as In_time ,d.name as department,des.name as Designation,a.created');

        $this->db->join('users u', 'a.user_id = u.id');

        $this->db->join('user_department ud', 'ud.user_id=u.id');

        $this->db->join('department d', 'ud.department=d.id ');

        $this->db->join('designation des', 'des.id = ud.designation');

        $this->db->where('DATE_FORMAT(a.created,"%Y-%m-%d")', date('Y-m-d'));

        $this->db->where("a.in <", $time);

        $query = $this->db->get('attendance a')->result_array();



        //echo $this->db->last_query();



        return $query;

    }



    public function get_early_out_list() {

        $time = '18:00:00';

        $this->db->select('u.id,u.employee_id,u.username ,u.first_name,a.out as Out_time ,d.name as department,des.name as Designation,a.created');



        $this->db->join('users u', 'a.user_id = u.id');

        $this->db->join('user_department ud', 'ud.user_id=u.id');

        $this->db->join('department d', 'ud.department=d.id ');

        $this->db->join('designation des', 'des.id = ud.designation');

        $this->db->where('DATE_FORMAT(a.created,"%Y-%m-%d")', date('Y-m-d'));

        // $this->db->where("TIME_FORMAT(a.out,'%h:%i:%s') >", $time);

        $this->db->where("a.out <", $time);

        $query = $this->db->get('attendance a')->result_array();



        return $query;

    }



    public function get_user_present_details($id, $date) {

        $query = array();

        if ($date != NULL) {

            $this->db->select('a.id AS attendance_id,u.id,u.employee_id,u.username,u.first_name,d.name as department,des.name as Designation');

            $this->db->join('users u', 'a.user_id = u.id');

            $this->db->join('user_department ud', 'ud.user_id=u.id');

            $this->db->join('department d', 'ud.department=d.id ');

            $this->db->join('designation des', 'des.id = ud.designation');

            $where = "DATE_FORMAT(a.created, '%Y-%m-%d') ='$date' AND a.user_id=" . $id;

            $this->db->where($where);

            $query = $this->db->get('attendance a')->result_array();

            $i = 0;

            foreach ($query as $val) {

                $this->db->select('a.in AS In_time,b.in_time AS out_time,b.out_time AS in_time ,b.type AS reason,a.out AS Out_time');

                $this->db->join('users u', 'a.user_id = u.id');

                $this->db->join('break_table b', 'a.id = b.attendance_id');

                $where = "DATE_FORMAT(a.created, '%Y-%m-%d') ='$date'AND a.user_id=" . $id;

                $this->db->where($where);



                $query[$i]['time'] = $this->db->get('attendance a')->result_array();



                $i++;

            }

        }

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

        $this->db->where_in('erp_invoice.firm_id', $serch_data['frim_id']);

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->join('erp_sales_man', 'erp_sales_man.id=erp_invoice.sales_man', 'LEFT');

        $this->db->join('erp_invoice_details', 'erp_invoice_details.in_id=erp_invoice.id');

        $this->db->group_by('erp_invoice.id');





        if (!empty($serch_data['limit']))

            $this->db->limit($serch_data['limit'], $serch_data['offset']);



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

            $query['inv_all_details'] = $inv_all_details;

        }

        return $query;

    }



    public function api_daily_attendance_report($filter_data) {

//

        $query = array();

        if ($filter_data['date'] != NULL) {

//            $this->db->select('*');

            $date = $filter_data['date'];

            $this->db->select('u.id,u.employee_id,u.username ,u.first_name,a.in as In_time,a.out as Out_time ,d.name as department,des.name as Designation,u.email');

            $this->db->join('users u', 'a.user_id = u.id');

            $this->db->join('user_department ud', 'ud.user_id=u.id');

            $this->db->join('department d', 'ud.department=d.id ');

            $this->db->join('designation des', 'des.id = ud.designation');

            $where = "DATE_FORMAT(a.created, '%Y-%m-%d') = '$date'";



            $this->db->where($where);

            if (!empty($filter_data['name']) && $filter_data['name'] != 'Select') {

                $this->db->where($this->d . 'd.name', $filter_data['name']);

            }

            if (!empty($filter_data['name']) && $filter_data['name'] != 'Select') {

                $this->db->where($this->des . 'des.name', $filter_data['name']);

            }

            if (!empty($filter_data['name']) && $filter_data['name'] != 'Select') {

                $this->db->where($this->shift . '.name', $filter_data['name']);

            }

            $query = $this->db->get('attendance a')->result_array();

        }



        return $query;

    }



//    public function api_monthly_attendance_details($id, $date) {

//        $query = array();

//        if ($date != NULL) {

//

//            $this->db->select('a.id AS attendance_id,u.id,u.employee_id,u.username ,u.first_name,d.name as department,des.name as Designation');

//            $this->db->join('users u', 'a.user_id = u.id');

//            $this->db->join('user_department ud', 'ud.user_id=u.id');

//            $this->db->join('department d', 'ud.department=d.id ');

//            $this->db->join('designation des', 'des.id = ud.designation');

//            $where = "DATE_FORMAT(a.created, '%Y-%m-%d') ='$date 'AND a.user_id=" . $id;

//            $this->db->where($where);

//            $query = $this->db->get('attendance a')->result_array();

//            $i = 0;

//            foreach ($query as $val) {

//                $this->db->select('a.created AS Date,a.in AS In_time,b.out_time ,b.in_time,b.type AS reason,a.out AS Out_time');

//                $this->db->join('users u', 'a.user_id = u.id');

//                $this->db->join('break_table b', 'a.user_id = b.id');

//                $where = "DATE_FORMAT(a.created, '%Y-%m-%d') ='$date' AND a.user_id=" . $id;

//                $this->db->where($where);

//

//                $query[$i]['time'] = $this->db->get('attendance a')->result_array();

//

//                $i++;

//            }

//        }

//        return $query;

//    }



    public function get_all_user_details($search_arr) {

        $this->db->select('u.id,u.employee_id,u.username ,u.first_name, u.last_name,u.email,d.name as department,des.name as Designation');

        $this->db->join('user_department ud', 'ud.user_id=u.id');

        $this->db->join('department d', 'ud.department=d.id ');

        $this->db->join('designation des', 'ud.designation=des.id');

//        $this->db->join('attendance a', 'ud.user_id=a.user_id');

        if (!empty($search_arr['department']))

            $this->db->where_in('ud.department', $search_arr['department']);

        if (!empty($search_arr['designation']))

            $this->db->where_in('ud.designation', $search_arr['designation']);



        $this->db->order_by("u.id");

        $query = $this->db->get('users u')->result_array();



        return $query;

    }



    public function get_user_month_total($id) {

        $this->db->select('count(a.user_id) AS Present_count');

        $this->db->join('users u', 'a.user_id = u.id');

        $this->db->where("MONTH(a.created) = MONTH(CURRENT_DATE())AND YEAR(a.created) = YEAR(CURRENT_DATE()) AND a.user_id= " . $id . " GROUP BY a.user_id");

        $query = $this->db->get('attendance a')->result_array();

        return $query;

    }



    public function monthly_users_details($year, $month, $id) {



        $this->db->select('u.id,u.employee_id,u.username ,u.first_name, u.last_name,u.email,d.name as department,des.name as Designation');

        $this->db->join('user_department ud', 'ud.user_id=u.id');

        $this->db->join('department d', 'ud.department=d.id ');

        $this->db->join('designation des', 'ud.designation=des.id');

        $this->db->order_by("u.id");

        $this->db->where("u.id", $id);

        $query = $this->db->get('users u')->result_array();



        $start_date = date('Y-m-01');



        $current_date = date('Y-m-d');

        $end_date = date('Y-m-d', strtotime($current_date . ' + 1 days'));



        if (!empty($year)) {

            $start_date = $year . "-" . $month . "-01";

            $enddate = date('t', $month);

            $end_date = $year . "-" . $month . "-" . $enddate;

        }



        $period = new DatePeriod(

                new DateTime($start_date), new DateInterval('P1D'), new DateTime($end_date)

        );



        $date = "";

        foreach ($period as $key => $value) {

            $date[] = $value->format('Y-m-d');

        }



        $data = [];

        if (!empty($query)) {

            $data['user_id'] = $query[0]['id'];

            $data['user_name'] = $query[0]['first_name'] . " " . $query[0]['last_name'];

            $data['email'] = $query[0]['email'];

            $data['department'] = $query[0]['department'];

            $data['designation'] = $query[0]['Designation'];

            foreach ($date as $key => $date_format) {

                $created = $date_format;

//                $where = "DATE_FORMAT(a.created, '%Y-%m-%d') ='$created' AND a.user_id=" . $id;



                $this->db->select('a.in AS In_time, a.out AS Out_time, a.created,a.user_id');

                // $this->db->where($where);

                $this->db->where("a.user_id", $id);



//                if (!empty($year)) {

////                    $this->db->where("DATE_FORMAT(a.created, '%Y')=", $year);

////                    $this->db->where("DATE_FORMAT(a.created, '%m')=", $month);

//                } else {

                $this->db->where("DATE_FORMAT(a.created, '%Y-%m-%d')=", $created);

//                }



                $result_data_attenance = $this->db->get('attendance a')->result_array();

                $date = "";

                $in_time = "";

                $out_time = "";



                if (!empty($result_data_attenance)) {



                    $in_time = $result_data_attenance[0]['In_time'];

                    $out_time = $result_data_attenance[0]['Out_time'];

                    // $created = $result_data_attenance[0]['created'];

                }

//                $where = "DATE_FORMAT(a.created, '%Y-%m-%d') ='$created' AND a.user_id=" . $id;

                $this->db->select('b.out_time AS break_out, b.in_time AS break_in, b.type AS reason, a.created');

                $this->db->join('break_table b', 'a.id = b.attendance_id');

//                $this->db->where($where);

                $this->db->where("b.type", 'break');

                $this->db->where("a.user_id", $id);

//                if (!empty($year)) {

//                    $this->db->where("DATE_FORMAT(a.created, '%Y')=", $year);

//                    $this->db->where("DATE_FORMAT(a.created, '%m')=", $month);

//                } else {

                $this->db->where("DATE_FORMAT(a.created, '%Y-%m-%d')=", $created);

//                }



                $result_data_break = $this->db->get('attendance a')->result_array();

                $b_in_time = "";

                $b_out_time = "";

                $break_time_data = "";

                if (!empty($result_data_break)) {

                    foreach ($result_data_break as $break) {

                        // $created = $break['created'];

                        $b_out_time = $break['break_in'];

                        $b_in_time = $break['break_out'];

                        $reason = $break['reason'];

                        $break_time = [



                            "out_time" => $b_in_time,

                            "in_time" => $b_out_time,

                            "reason" => $reason,

                        ];

                        $break_time_data[] = $break_time;

                    }

                }





//                $this->db->select('b.out_time AS break_out, b.in_time AS break_in, b.type AS reason, a.created');

                $this->db->join('break_table b', 'a.id = b.attendance_id');

//                $this->db->where($where);

                $this->db->where("b.type", 'lunch');

                $this->db->where("a.user_id", $id);

//                if (!empty($year)) {

//                    $this->db->where("DATE_FORMAT(a.created, '%Y')=", $year);

//                    $this->db->where("DATE_FORMAT(a.created, '%m')=", $month);

//                } else {

                $this->db->where("DATE_FORMAT(a.created, '%Y-%m-%d')=", $created);

//            }

                $result_data_lunch = $this->db->get('attendance a')->result_array();



                $l_in_time = "";

                $l_out_time = "";

                $l_reason = "";

                if (!empty($result_data_lunch)) {

                    $l_in_time = $result_data_lunch[0]['break_out'];

                    $l_out_time = $result_data_lunch[0]['break_in'];

                    $l_reason = $result_data_lunch[0]['reason'];

                }

                if (empty($break_time_data)) {

                    $break_time_data = [];

                }

                $result_data = [

                    "Date" => $created,

                    "Day" => date('l', strtotime($created)),

                    "In_time" => $in_time,

                    "break" => $break_time_data,

//                    "lunch_out" => $l_out_time,

//                    "lunch_in" => $l_in_time,

//                    "reason" => $l_reason,

                    "Out_time" => $out_time,

                ];

                $time = "";



                $time_diff = $result_data_attenance[0]['Out_time'] - $result_data_attenance[0]['In_time'];

                if ($time_diff > 8) {

                    $time = $time_diff - 8;

                    $time = $time . ":00:00";

                }

                $result_data['over_time'] = $time;

                $time_diff = $result_data_attenance[0]['Out_time'] - $result_data_attenance[0]['In_time'];

                if ($time_diff > 9) {

                    $time = $time_diff;

                    $time = $time . ":00:00";

                }

                $result_data['Total_hours'] = $time;





//                $data['date'][$date_format][$key] = $this->db->get()->$result_data;



                $data['date'][$key] = $result_data;

            }

        } else {

            return "No data";

        }





        return $data;

    }



    public function get_all_user($date) {

        $query = array();

        if ($date != NULL) {

            $this->db->select('u.id,u.employee_id,u.username ,u.first_name, u.last_name,u.email,d.name as department,des.name as Designation');

            $this->db->join('user_department ud', 'ud.user_id=u.id');

            $this->db->join('department d', 'ud.department=d.id ');

//            $where = "DATE_FORMAT(a.created, '%Y-%m-%d') ='$date'";

            $this->db->join('designation des', 'ud.designation=des.id');



            $this->db->order_by("u.id");

            $query = $this->db->get('users u')->result_array();

        }

        return $query;

    }



    public function get_attendance_details($date, $user_id) {

        $this->db->select('*');

        $where = "DATE_FORMAT(created, '%Y-%m-%d') ='$date'";

        $this->db->where($where);

        $this->db->where('user_id', $user_id);

        $query = $this->db->get('attendance')->num_rows();



        return $query;

    }



    public function get_all_user_details_basedonid($user_id) {



        $this->db->select('u.id,u.employee_id,u.username ,u.first_name, u.last_name,u.email,d.name as department,des.name as Designation');

        $this->db->join('user_department ud', 'ud.user_id=u.id');

        $this->db->join('department d', 'ud.department=d.id ');

//            $where = "DATE_FORMAT(a.created, '%Y-%m-%d') = '$date'";

        $this->db->join('designation des', 'ud.designation=des.id');

        $this->db->where('u.id', $user_id);

        $this->db->order_by("u.id");

        $query = $this->db->get('users u')->result_array();



        return $query[0];

    }



    public function get_attendance_details_basedondate($start_date, $user_id) {

        $this->db->select('a.in AS in_time,a.out AS out_time,a.id');

        $this->db->where('a.user_id', $user_id);

        $this->db->where("DATE_FORMAT(a.created, '%Y-%m-%d') =", $start_date);

        $query = $this->db->get('attendance a')->result_array();





        return $query;

    }



    public function get_break_details_basedonattendance_id($attendance_id) {



        $this->db->select('b.*');

        $this->db->where('b.attendance_id', $attendance_id);

        $query = $this->db->get('break_table b')->result_array();

        return $query;

    }



    public function daily_details_basedondate($user_id, $date) {

        $query = array();

        if ($date != NULL) {

            $this->db->select('a.in AS in_time,a.out AS out_time');

            $where = "DATE_FORMAT(a.created, '%Y-%m-%d') = '$date'AND a.user_id = " . $user_id;

            $this->db->where($where);

            $query = $this->db->get('attendance a')->result_array();

        }

        return $query;

    }



    public function daily_break_details($user_id, $date) {

        $query = array();

        if ($date != NULL) {

            $this->db->select('b.in_time AS Out_time,b.out_time AS in_time');

//            $this->db->where('b.attendance_id', $attendance_id);

            $this->db->join('attendance a', 'a.id= b.attendance_id');

            $where = "DATE_FORMAT(a.created, '%Y-%m-%d') = '$date' AND a.user_id = " . $user_id;

            $this->db->where($where);

            $query = $this->db->get('break_table b')->result_array();

        }

        return $query;

    }



    public function get_overtime_details($userid, $start_date) {

        $this->db->select('a.in,a.out');

        $where = "DATE_FORMAT(a.created, '%Y-%m-%d') ='$start_date' AND a.user_id=$userid";

        $this->db->where($where);

        $result = $this->db->get('attendance a')->result_array();

        $time = "";

        $time_diff = '';

        if (!empty($result)) {



            $in_time = $result[0]['in'];

            $out_time = $result[0]['out'];

            $time_diff = $out_time - $in_time;

        }



        if ($time_diff > 8) {

            $time = $time_diff - 8;

            $time = $userid . "-" . $time . ":00:00";

        }

        return $time;

    }



    public function check_duplicate_ime($data){



        $ime_code="";

        $i=0;

        foreach($data as $key=>$result){

            $this->db->where('ime_code',$result);

           $result_data= $this->db->get('erp_po_ime_code_details')->result_array();



           if(!empty($result_data))

           {

            $ime_code[$i]=$result;



            $i++;

           }

        }



        if (!empty($ime_code)) {

            return $ime_code;

        }else{

           return false; 

        }



        

    }



       public function insert_ime_code($data){



    $ime_code=$data['ime_code'];







    foreach($ime_code as $key=>$result){



        $data['ime_code']=$result;





        $this->db->insert('erp_po_ime_code_details',$data);



           





    }

 return true;

    



   }



}

