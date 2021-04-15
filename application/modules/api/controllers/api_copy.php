<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//require(APPPATH . '/libraries/REST_Controller.php');

class Api extends MX_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    function __construct() {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('session_view');
        $this->load->library('user_auth');
        $this->load->library('email');
        $this->load->database();
        $this->load->library('form_validation');

        $this->load->model('api_model');
        $this->load->model('increment_model');

        $this->load->model('purchase_receipt/receipt_model');

        //$this->load->library('security');
    }

    public function login() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            if (!empty($data['password']) && !empty($data['username'])) {
                $username = $data['username'];
                $password = $data['password'];
                $user_details="";
                if ($this->user_auth->login($username, $password)) {
                    $user_data = $this->api_model->get_user_by_login($username, $password);
                    $user_role_name=$this->api_model->get_user_role_name($user_data[0]['role']);
                    $result = 1;
                    $user_details=["id"=>$user_data[0]['id'],"name"=>$user_data[0]['name'],"role"=>$user_data[0]['role'],"mobile_no"=>$user_data[0]['mobile_no'],"email_id"=>$user_data[0]['email_id'],"address"=>$user_data[0]['address'],"user_role_name"=>$user_role_name];
                } else {
                    $result = 0;
                }
               
               $user_details['user_permission']=$this->api_model->get_user_allowed_modules($user_data[0]['role']);
                if ($result == 1) {
                    $output = array('status' => 'Success', 'message' => 'logged in', 'user_id' => $user_data[0]['id'],'user_details'=>$user_details);
                    echo json_encode($output);
                } else {
                    $output = array('status' => 'error', 'message' => 'You have entered wrong Username or password .Please try again..!');
                    echo json_encode($output);
                }
            } else {
                $output = array('status' => 'error', 'message' => 'Please Enter Username and Password');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Please Enter Username and Password');
            echo json_encode($output);
        }
    }

    public function signup() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input

        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);

            if (!empty($data['firms']) && !empty($data['password']) && !empty($data['username']) && !empty($data['name']) && !empty($data['nick_name']) && !empty($data['address']) && !empty($data['mobile']) && !empty($data['role']) && !empty($data['email'])) {
                $result == 0;
                $username = $data['username'];
                $password = $data['password'];
                $name = $data['name'];
                $nick_name = $data['nick_name'];
                $address = $data['address'];
                $email = $data['email'];
                $mobile = $data['mobile'];
                $role = $this->api_model->get_user_role_id_by_role($data['role']);
                $firms = $data['firms'];


                if (!empty($data['image_path']) && !empty($data['image_encode'])) {
                    $base = $data['image_encode'];
                    $file_data = base64_decode($base);
                    $image_path = $data['image_path'];
                    $file = basename($image_path);
                    $imageName = $file;
                    //$insert2['FormValues'] = '';
                    $src = $this->config->item("base_url") . 'attachement/sign/' . $upload_data['file_name'];
                    mkdir('./attachments/sign', 0777, true);
                    $save_path = 'attachments/sign/' . $file;

                    if (file_put_contents($save_path, $file_data) !== false) {
                        $signature = $imageName;
                    } else {
                        $signature = 'No Image';
                    }
                } else {
                    $signature = 'No Image';
                }
                $input_data = array('name' => $name, 'address' => $address, 'nick_name' => $nick_name,
                    'mobile_no' => $mobile, 'email_id' => $email,
                    'password' => md5($password), 'username' => $username, 'role' => $role, 'signature' => $signature, 'admin_image' => 'No Image');
                $id = $this->api_model->insert_user($input_data);

                if (!empty($id)) {
                    if (isset($firms) && !empty($firms)) {
                        $i = 0;
                        foreach ($firms as $firm) {
                            $firm_id = $this->api_model->get_firm_id_by_name($firm);
                            $firm_input = array('user_id' => $id, 'firm_id' => $firm_id);
                            $this->api_model->insert_firm($firm_input);
                        }
                    }
                    $result = 1;
                }

                if ($result == 1) {
                    $output = array('status' => 'Success', 'message' => 'User Added Successfully');
                    echo json_encode($output);
                } else {
                    $output = array('status' => 'error', 'message' => 'User Not Added Successfully');
                    echo json_encode($output);
                }
            } else {
                $output = array('status' => 'error', 'message' => 'Please Enter Name,username,password,nick name,address,email,mobile,role,Firm');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Please Enter Data');
            echo json_encode($output);
        }
    }


    public function api_duplicate_imecode_check(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
           

           // $po = $this->api_model->get_all_inv($firm_id, $filter_data);

            $ime = $this->api_model->check_duplicate_ime($data['ime_code']);

          
            if (!empty($ime)) {
                $ime_data=json_encode($ime);
                $output = array('status' => 'Error', 'message' => 'Duplicate Ime Found', 'data' => $ime);
                echo json_encode($output);
            } else {
                $output = array('status' => 'Success', 'message' => 'Duplicate Ime Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter User ID');
            echo json_encode($output);
        }
    }
    
    public function api_purchase_order_list() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $firm_id = $this->api_model->get_user_firms($data['user_id']);
            $firm_id = array_map(function($firm_id) {
                return $firm_id['firm_id'];
            }, $firm_id);

            $filter_data['limit'] = $data['limit'];
            $filter_data['offset'] = $data['offset'];
            if ($filter_data['offset'] == 0) {
                $filter_data['offset'] = "";
            }
            $po = $this->api_model->get_all_po($firm_id, $filter_data);
            $total_amount = $this->api_model->get_all_po_total($firm_id, $filter_data);
            
            //$total_amount=round($po[0]['total_amount']);

            foreach ($po as $key => $val) {
                $po[$key]['created_date'] = ($val['created_date']) ? date('d-M-Y', strtotime($val['created_date'])) : '-';
            }

            if (!empty($po)) {
                $output = array('status' => 'Success', 'message' => 'Purchase Order List', 'total_amount'=>$total_amount,'data' => $po);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter User ID');
            echo json_encode($output);
        }
    }

    public function api_purchase_return_list() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $firm_id = $this->api_model->get_user_firms($data['user_id']);
            $firm_id = array_map(function($firm_id) {
                return $firm_id['firm_id'];
            }, $firm_id);

             $filter_data['limit'] = $data['limit'];
            $filter_data['offset'] = $data['offset'];
            if ($filter_data['offset'] == 0) {
                $filter_data['offset'] = "";
            }

           // $po = $this->api_model->get_all_inv($firm_id, $filter_data);

            $pr = $this->api_model->get_all_pr($firm_id,$filter_data);

            foreach ($pr as $key => $val) {
                $pr[$key]['delivery_schedule'] = ($val['delivery_schedule']) ? date('d-m-Y', strtotime($val['delivery_schedule'])) : '-';
            }
            if (!empty($pr)) {
                $output = array('status' => 'Success', 'message' => 'Purchase Return List', 'data' => $pr);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter User ID');
            echo json_encode($output);
        }
    }

    public function api_purchase_receipt_list() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $firm_id = $this->api_model->get_user_firms($data['user_id']);
            $firm_id = array_map(function($firm_id) {
                return $firm_id['firm_id'];
            }, $firm_id);

              $filter_data['limit'] = $data['limit'];
            $filter_data['offset'] = $data['offset'];
            if ($filter_data['offset'] == 0) {
                $filter_data['offset'] = "";
            }

            $prc = $this->api_model->get_all_receipt($firm_id,$filter_data);

            foreach ($prc as $key => $val) {
                $prc[$key]['receipt_bill'][0]['next_date'] = ($val['receipt_bill'][0]['next_date']) ? date('d-m-Y', strtotime($val['receipt_bill'][0]['next_date'])) : '-';
            }
            if (!empty($prc)) {
                $output = array('status' => 'Success', 'message' => 'Purchase Receipt List', 'data' => $prc);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter User ID');
            echo json_encode($output);
        }
    }

    public function api_inventory_stock_list() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);

        if (!empty($json_input) && $data['user_id'] != '') {
            $firm_id = $this->api_model->get_user_firms($data['user_id']);
            $firm_id = array_map(function($firm_id) {
                return $firm_id['firm_id'];
            }, $firm_id);
            $filter_data['limit'] = $data['limit'];
            $filter_data['offset'] = $data['offset'];
            if ($filter_data['offset'] == 0) {
                $filter_data['offset'] = "";
            }

            $stock['stock'] = $stocks = $this->api_model->get_all_stock($firm_id, $filter_data);
        
            //$total_quantity = round($stocks['total_quantity']);
            $total_quantity =  $this->api_model->get_all_stock_totalqty($firm_id, $filter_data);
           // $total_quantity = 0;


            $sum = 0;
            foreach ($stocks as $val) {
                $sum = $sum + $val['quantity'];
            }
            $stock['total_qty'] = $sum;

            if (!empty($stock)) {
                $output = array('status' => 'Success', 'message' => 'inventory Stock List','total_quantity' => $total_quantity,'data' => $stock);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter User ID');
            echo json_encode($output);
        }
    }

    public function api_sales_invoice_list() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $firm_id = $this->api_model->get_user_firms($data['user_id']);
            $firm_id = array_map(function($firm_id) {
                return $firm_id['firm_id'];
            }, $firm_id);

            $filter_data['limit'] = $data['limit'];
            $filter_data['offset'] = $data['offset'];
            if ($filter_data['offset'] == 0) {
                $filter_data['offset'] = "";
            }
            $quotation = $this->api_model->get_all_sales_id($firm_id, $filter_data);
            $total_amount = $this->api_model->get_all_sales_id_amt($firm_id, $filter_data);
            // $total_amount = round($quotation['total_amount']);
            $quotation_count = count($quotation);
            /* foreach ($quotation as $key => $val) {
              $quotation[$key]['created_date'] = ($val['created_date']) ? date('d-m-Y', strtotime($val['created_date'])) : '-';
              } */
            if (!empty($quotation)) {
                $output = array('status' => 'Success', 'message' => 'Sales Invoice List','total_amount'=>$total_amount, 'data' => $quotation, 'total_count' => $quotation_count);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter User ID');
            echo json_encode($output);
        }
    }

    public function api_sales_order_list() {

        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $firm_id = $this->api_model->get_user_firms($data['user_id']);
            $firm_id = array_map(function($firm_id) {
                return $firm_id['firm_id'];
            }, $firm_id);

            $filter_data['limit'] = $data['limit'];
            $filter_data['offset'] = $data['offset'];
            if ($filter_data['offset'] == 0) {
                $filter_data['offset'] = "";
            }

            $quotation = $this->api_model->get_all_quotation($firm_id, $filter_data);
            if (!empty($quotation)) {
                $output = array('status' => 'Success', 'message' => 'Sales Order List', 'data' => $quotation);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter User ID');
            echo json_encode($output);
        }
    }

    public function api_sales_return_list() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $firm_id = $this->api_model->get_user_firms($data['user_id']);
            $firm_id = array_map(function($firm_id) {
                return $firm_id['firm_id'];
            }, $firm_id);


            $filter_data['limit'] = $data['limit'];
            $filter_data['offset'] = $data['offset'];
            if ($filter_data['offset'] == 0) {
                $filter_data['offset'] = "";
            }

            $po = $this->api_model->get_all_inv($firm_id, $filter_data);
            if (!empty($po)) {
                $output = array('status' => 'Success', 'message' => 'Sales Return List', 'data' => $po);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter User ID');
            echo json_encode($output);
        }
    }

    public function api_sales_receipt_list() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $firm_id = $this->api_model->get_user_firms($data['user_id']);
            $firm_id = array_map(function($firm_id) {
                return $firm_id['firm_id'];
            }, $firm_id);

            $filter_data['limit'] = $data['limit'];
            $filter_data['offset'] = $data['offset'];
            if ($filter_data['offset'] == 0) {
                $filter_data['offset'] = "";
            }
            $po = $this->api_model->get_all_sale_receipt($firm_id, $filter_data);
            foreach ($po as $key => $val) {
                $po[$key]['created_date'] = ($val['created_date']) ? date('d-m-Y', strtotime($val['created_date'])) : '-';
                $po[$key]['receipt_bill'][0]['next_date'] = ($val['receipt_bill'][0]['next_date']) ? date('d-m-Y', strtotime($val['receipt_bill'][0]['next_date'])) : '-';
                $po[$key]['receipt_bill'][0]['paid_date'] = ($val['receipt_bill'][0]['paid_date']) ? date('d-m-Y', strtotime($val['receipt_bill'][0]['paid_date'])) : '-';
            }
            if (!empty($po)) {
                $output = array('status' => 'Success', 'message' => 'Sales Receipt List', 'data' => $po);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter User ID');
            echo json_encode($output);
        }
    }

    public function api_get_all_customer() {
        $customer = $this->api_model->get_all_customer();
        if (!empty($customer)) {
            $output = array('status' => 'Success', 'message' => 'Customer List', 'data' => $customer);
            echo json_encode($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
            echo json_encode($output);
        }
    }

    public function api_get_all_supplier() {
        $customer = $this->api_model->get_all_supplier();
        if (!empty($customer)) {
            $output = array('status' => 'Success', 'message' => 'Supplier List', 'data' => $customer);
            echo json_encode($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
            echo json_encode($output);
        }
    }

    public function api_get_all_firms() {

    	$json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $firm_id = $this->api_model->get_user_firms($data['user_id']);
            $firm_id = array_map(function($firm_id) {
                return $firm_id['firm_id'];
            }, $firm_id);

        $firms = $this->api_model->get_all_firms($firm_id);
        if (!empty($firms)) {
            $output = array('status' => 'Success', 'message' => 'Firm List', 'data' => $firms);
            echo json_encode($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
            echo json_encode($output);
        }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter User ID');
            echo json_encode($output);
        }
    }

    public function api_add_customers(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);

             $check_duplicate=$this->api_model->check_dupliacate_customers($data);
            if($check_duplicate){
                $output = array('status' => 'error', 'message' => $check_duplicate);
                echo json_encode($output);
            }else{
                 $customer = $this->api_model->add_customres($data);
                if (!empty($customer)) {
                    $output = array('status' => 'Success', 'message' => 'Customer Data added Successfully', 'data' => $customer);
                    echo json_encode($output);
                } else {
                    $output = array('status' => 'error', 'message' => 'Data Not Found');
                    echo json_encode($output);
                }
            }
           
        } else {
            $output = array('status' => 'error', 'message' => 'Enter Customer Details');
            echo json_encode($output);
        }
    } 

      public function api_check_duplicate_customer_details(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $customer = $this->api_model->check_duplicate_customer_details($data);
            if (!empty($customer)) {
                $output = array('status' => 'Success', 'message' => 'Customer Data', 'data' => $customer);
                echo json_encode($output);
            } else {
                if($data['type']=="email")
                     $output = array('status' => 'error', 'message' => 'Customer Email Address  Alreday Exists');
                 else if($data['type']=="mobile")
                     $output = array('status' => 'error', 'message' => 'Customer Mobile Number Alreday Exists');
                 else
                    $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter Customer Details');
            echo json_encode($output);
        }
    }



        public function api_add_suppliers(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $check_duplicate=$this->api_model->check_dupliacate_suppliers($data);
            if($check_duplicate){
                $output = array('status' => 'error', 'message' => $check_duplicate);
                echo json_encode($output);
            }else{
                  $suppliers = $this->api_model->add_suppliers($data);
                if (!empty($suppliers)) {
                    $output = array('status' => 'Success', 'message' => 'Supplier Data added Successfully', 'data' => $suppliers);
                    echo json_encode($output);
                } else {
                    $output = array('status' => 'error', 'message' => 'Data Not Found');
                    echo json_encode($output);
                }
            }
          
        } else {
            $output = array('status' => 'error', 'message' => 'Enter Supplier Details');
            echo json_encode($output);
        }
    } 

      public function api_check_duplicate_supplier_details(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $suppliers = $this->api_model->check_duplicate_supplier_details($data);
            if (!empty($suppliers)) {
                $output = array('status' => 'Success', 'message' => 'Supplier Data', 'data' => $suppliers);
                echo json_encode($output);
            } else {
                if($data['type']=="email")
                     $output = array('status' => 'error', 'message' => 'Supplier Email Address  Alreday Exists');
                 else if($data['type']=="mobile")
                     $output = array('status' => 'error', 'message' => 'Supplier Mobile Number Alreday Exists');
                 else
                    $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter Customer Details');
            echo json_encode($output);
        }
    }



    public function api_get_customer_by_id() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $customer = $this->api_model->get_all_customer_by_id($data['customer_id']);
            if (!empty($customer)) {
                $output = array('status' => 'Success', 'message' => 'Customer Data', 'data' => $customer);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter Customer ID');
            echo json_encode($output);
        }
    }

    public function api_get_supplier_by_id() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $customer = $this->api_model->get_all_supplier_by_id($data['supplier_id']);
            if (!empty($customer)) {
                $output = array('status' => 'Success', 'message' => 'Supplier Data', 'data' => $customer);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter Supplier ID');
            echo json_encode($output);
        }
    }

    public function api_get_data_by_firm() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $product['product'] = $this->api_model->get_sales_product_by_frim_id($data['firm_id']);
            $product['model'] = $this->api_model->get_model_number_by_firm($data['firm_id']);
            $product['reference_name'] = $this->api_model->get_reference_group_by_frim_id($data['firm_id']);
            $product['sales_man'] = $this->api_model->get_sales_man_by_frim_id($data['firm_id']);
             $product['customers'] = $this->api_model->get_customer_by_frim_id($data['firm_id']);
            $pre = $this->api_model->get_prefix_by_frim_id($data['firm_id']);

            $val = $this->increment_model->get_increment_id($pre[0]['prefix'], $data['code']);
            $val = $this->increment_model->get_increment_id($pre[0]['prefix'], $data['code']);
            $inc = explode('/', $val);
            $q_id = $pre[0]['prefix'] . '-' . $inc[1] . '' . $inc[2];
            $sales_id = 'SL-' . $pre[0]['prefix'] . '-' . $inc[1] . '' . $inc[2];
            $inv_id = 'INV-' . $pre[0]['prefix'] . '-' . $inc[1] . '' . $inc[2];
            $product['q_no'] = $q_id;
            $product['sales_id'] = $sales_id;
            $product['inv_id'] = $inv_id;
            if (!empty($product)) {
                $output = array('status' => 'Success', 'message' => 'Frim Based Data', 'data' => $product);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter Firm ID');
            echo json_encode($output);
        }
    }

    public function api_get_product_by_id() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $product = $this->api_model->get_product($data['product_id']);
            if (!empty($product)) {
                $output = array('status' => 'Success', 'message' => 'Product Data', 'data' => $product);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter Product ID');
            echo json_encode($output);
        }
    }

    public function api_get_product_by_po() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $product = $this->api_model->get_product_for_po($data['product_id']);
            if (!empty($product)) {
                $output = array('status' => 'Success', 'message' => 'Product Data', 'data' => $product);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter Product ID');
            echo json_encode($output);
        }
    }

    public function api_new_direct_invoice() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input

       // echo "<pre>";print_r($json_input);exit;
        if (!empty($json_input)) {
            $input = json_decode($json_input, TRUE);
            $quotation = array();
            $user_info = $this->api_model->get_user_info_by_id($input['user_id']);

            $cus = array();
            if ($input['customer_id'] == '') {
                $cus['name'] = $input['customer_name'];
                $cus['store_name'] = $input['customer_name'];
                $cus['firm_id'] = $input['firm_name'];
                $cus['mobil_number'] = $input['mobile_number'];
                $cus['state_id'] = 31;
                $cus['customer_region'] = 'local';

                $customer = $this->api_model->insert_customer($cus);
            }

            $customer_id = ($input['customer_id'] != '') ? $input['customer_id'] : $customer;

            $quotation['firm_id'] = $input['firm_name'];
            $quotation['q_no'] = $input['invoice_no'];
            $quotation['ref_name'] = $input['reference_name'];
            $quotation['job_id'] = $input['sales_id'];
            $quotation['inv_id'] = $input['inv_id'];
            $quotation['total_qty'] = $input['total']['total_qty'];
            $quotation['subtotal_qty'] = $input['total']['sub_total'];
            $quotation['tax_label'] = $input['total']['tax_label_name'];
            $quotation['tax'] = $input['total']['tax_label'];
            $quotation['net_total'] = $input['total']['net_total'];
            $quotation['remarks'] = $input['total']['remarks'];
            $quotation['delivery_schedule'] = ($input['delivery_schedule']) ? $input['delivery_schedule'] : '-';
            $quotation['notification_date'] = ($input['notification_date']) ? date('Y-m-d', strtotime($input['notification_date'])) : date('Y-m-d');
            $quotation['mode_of_payment'] = ($input['total']['mode_of_payment']) ? $input['total']['mode_of_payment'] : '-';
            $quotation['validity'] = ($input['validity']) ? $input['validity'] : '-';
            $quotation['customer'] = $customer_id;
            $quotation['estatus'] = 2;
            $quotation['created_by'] = $user_info[0]['id'];
            $quotation['created_date'] = date('Y-m-d', strtotime($input['created_date']));
            $product = $input['add_po'];

            if (isset($product) && !empty($product)) {
                $insert_id = $this->api_model->insert_quotation($quotation);
            }

            if (!empty($insert_id)) {
                $input['q_id'] = $insert_id;
                $q_no = $input['invoice_no'];
                $split = explode("-", $q_no);
                $code = 'TT';
                $this->increment_model->update_increment_id($split[0], $code);
            }

            $data['customer_details'] = $this->api_model->get_customer1($customer_id);
            // new invoice
            $invoice['invoice_status'] = 'approved';
            $invoice['created_by'] = $user_info[0]['id'];
            $invoice['created_date'] = date('Y-m-d');
            $invoice['credit_due_date'] = date('Y-m-d', strtotime($input['created_date'] . "+" . $data['customer_details'][0]['credit_days'] . " days"));
            $ref_amount = $this->api_model->get_reference_amount($input['ref_name']);
            $invoice['commission_rate'] = ($input['net_total'] / 100 ) * $ref_amount;
            if ($input['credit_days'] == '') {
                $invoice['credit_days'] = NULL;
            }if ($input['credit_limit'] == '') {
                $invoice['credit_limit'] = NULL;
            }if ($input['temp_credit_limit'] == '') {
                $invoice['temp_credit_limit'] = NULL;
            }if ($input['approved_by'] == '') {
                $invoice['approved_by'] = NULL;
            }
            if (isset($input['cus_type']) && !empty($input['cus_type']) && ($input['cus_type'] == 5 || $input['cus_type'] == 6) && $user_info[0]['role'] != 1) {
                $invoice['invoice_status'] = 'waiting';
            }
           
            $invoice['firm_id'] = $input['firm_name'];
            $invoice['delivery_status'] = $input['delivery_status'];
            $invoice['sales_man'] = $input['sales_man'];
            $invoice['inv_id'] = $input['inv_id'];
            $invoice['bill_type'] = $input['bill_type'];
            $invoice['total_qty'] = $input['total']['total_qty'];
            $invoice['subtotal_qty'] = $input['total']['sub_total'];
            $invoice['tax_label'] = $input['total']['tax_label_name'];
            $invoice['tax'] = $input['total']['tax_label'];
            $invoice['round_off'] = ($input['total']['round_off']) ? $input['total']['round_off'] : '0';
            $invoice['transport'] = ($input['total']['transport']) ? $input['total']['transport'] : '0';
            $invoice['labour'] = ($input['total']['labour']) ? $input['total']['labour'] : '0';
            $invoice['net_total'] = $input['total']['net_total'];
            $invoice['remarks'] = $input['total']['remarks'];
            $invoice['customer'] = $customer_id;
            $invoice['q_id'] = $insert_id;
            $invoice['created_by'] = $user_info[0]['id'];
             if ($input['delivery_status'] == 'delivered') {
                            $invoice['delivery_qty'] = $input['total']['total_qty'];
                    }
            $insert_id1 = $this->api_model->insert_invoice($invoice);

            if (isset($input['cus_type']) && !empty($input['cus_type']) && ($input['cus_type'] == 5 || $input['cus_type'] == 6) && $user_info[0]['role'] != 1) {
                $receiver_list = array(1);
                $notification = array();
                $notification['notification_date'] = date('d-M-Y');
                $notification['type'] = 'invoice';
                $notification['receiver_id'] = json_encode($receiver_list);
                $notification['link'] = 'sales/invoice_view/' . $insert_id1;
                $notification['Message'] = 'New invoice is created by the customer T5/T6, is waiting for your approval.';
                $this->api_model->insert_notification($notification);
            }

            $sr['firm_id'] = $input['firm_name'];
            $sr['inv_id'] = $input['inv_id'];
            $sr['created_date'] = date('Y-m-d', strtotime($input['created_date']));
            $sr['total_qty'] = $input['total']['total_qty'];
            $sr['subtotal_qty'] = $input['total']['sub_total'];
            $sr['tax_label'] = $input['total']['tax_label_name'];
            $sr['tax'] = $input['total']['tax_label'];
            $sr['net_total'] = $input['total']['net_total'];
            $sr['remarks'] = $input['total']['remarks'];
            $sr['customer'] = $customer_id;
            $sr['q_id'] = $insert_id;
            
            $sr['created_by'] = $user_info[0]['id'];
            $customer = array();
            $customer['temp_credit_limit'] = NULL;
            $this->api_model->update_customer($customer, $input['customer']);
            $this->api_model->insert_sr($sr);

            if (isset($insert_id1) && !empty($insert_id1)) {

                if (isset($product) && !empty($product)) {
                    $insert_arr = array();

                    foreach ($product as $key => $val) {
                        $insert['in_id'] = $insert_id1;
                        $insert['q_id'] = $insert_id;
                        $insert['category'] = $val['cat_id'];
                        $insert['product_id'] = $val['product_name'];
                        $insert['product_description'] = $val['product_description'];
                        $insert['product_type'] = 1;
                        $insert['brand'] = $val['brand_id'];
                        $insert['unit'] = $val['unit'];
                        $insert['quantity'] = $val['qty'];
                        if ($input['delivery_status'] == 'delivered') {
                            $insert['delivery_quantity'] = $val['qty'];
                        }
                        $insert['per_cost'] = $val['unit_price'];
                        $insert['tax'] = $val['cgst'];
                        $insert['gst'] = $val['sgst'];
                        $insert['igst'] = $val['igst'];
                        $insert['discount'] = $val['discount'];
                        $insert['sub_total'] = $val['net_value'];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;
                        $stock_arr = array();
                        $inv_id['inv_id'] = $input['inv_id'];
                        $stock_arr[] = $inv_id;
                        $this->stock_details($insert, $inv_id);

                        $get_invoice_details_id=$this->api_model->insert_invoicedetails($insert);


                        $update_data=[
                    "sales_id"=>$insert_id1,
                    "sales_details_id"=>$get_invoice_details_id,

                    ];
       
	            if($val['imei_code']!="")
	                   $this->api_model->update_ime_status($val['product_name'],$val['imei_code'],$val['qty'],$update_data);


                    }
                    //$this->api_model->insert_invoice_details($insert_arr);
                }

                 $this->load->model('master_style/master_model');

            $receipt_id=$insert_id1;

           $receipt_num=$this->master_model->get_last_id('rp_code');

           

                   $insert_data=[
                       "receipt_id"=>$receipt_id,
                         "receipt_no"=>$receipt_num[0]['value'],
                           "terms"=>$receipt_id,
                             "bill_amount"=>$input['total']['net_total'],
                               "due_date"=>date('Y-m-d', strtotime($input['created_date'])),
                                 "created_date"=>date('Y-m-d', strtotime($input['created_date'])),

           ];


           $this->load->model('sales_receipt/sales_receipt_model');

            $receipt_status = 'Completed';

            $this->sales_receipt_model->update_invoice(array('payment_status' => $receipt_status), $receipt_id);

            $insert_id = $this->sales_receipt_model->insert_receipt_bill($insert_data);

            $insert_id++;

            $inc['type'] = 'rp_code';

            $inc['value'] = 'RECQ000' . $insert_id;

            $this->sales_receipt_model->update_increment($inc);



                //$sms = $this->sms_model->send_sms($insert_id1, 'invoice');
            }

            if (!empty($insert_id) && !empty($insert_id1)) {
                $output = array('status' => 'Success', 'message' => 'Invoice Successfully Added..');
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Invoice Not added..');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter Invoice Details');
            echo json_encode($output);
        }
    }

    function stock_details($stock_info, $inv_id) {

        $this->api_model->check_stock($stock_info, $inv_id);
    }

    public function api_add_sales_order() {

        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $input = json_decode($json_input, TRUE);

            $quotation = array();
            $user_info = $this->api_model->get_user_info_by_id($input['user_id']);

            $quotation['firm_id'] = $input['firm_name'];
            $quotation['job_id'] = $input['sales_no'];
            $quotation['q_no'] = $input['q_no'];
            $quotation['inv_id'] = $input['inv_id'];
            $quotation['ref_name'] = $input['reference_name'];
            $quotation['customer'] = $input['customer_name'];
            $quotation['contract_customer'] = 0;
            $quotation['total_qty'] = $input['total']['total_qty'];
            $quotation['subtotal_qty'] = $input['total']['sub_total'];
            $quotation['tax_label'] = $input['total']['tax_label_name'];
            $quotation['tax'] = $input['total']['tax_label'];
            $quotation['net_total'] = $input['total']['net_total'];
            $quotation['remarks'] = $input['total']['remarks'];

//            $quotation['mode_of_payment'] = ($input['total']['mode_of_payment']) ? $input['total']['mode_of_payment'] : '-';
            $quotation['estatus'] = 1;
            $quotation['created_by'] = $user_info[0]['id'];
            $quotation['created_date'] = date('Y-m-d', strtotime($input['created_date']));
            $product = $input['add_so'];

            if (isset($product) && !empty($product)) {
                $insert_id = $this->api_model->insert_sales($quotation);
            }

            if (isset($insert_id) && !empty($insert_id)) {
                if (isset($product) && !empty($product)) {
                    $insert_arr = array();
                    foreach ($product as $key => $val) {
                        $insert['j_id'] = $insert_id;
                        //$insert['q_id'] = $input['quotation']['q_id'];
                        $insert['category'] = $val['cat_id'];
                        $insert['product_id'] = $val['product_name'];
                        $insert['product_description'] = $val['product_description'];
                        $insert['product_type'] = 1;
                        $insert['brand'] = $val['brand_id'];
                        $insert['unit'] = $val['unit'];
                        $insert['quantity'] = $val['qty'];
                        $insert['per_cost'] = $val['unit_price'];
                        $insert['tax'] = $val['cgst'];
                        $insert['gst'] = $val['sgst'];
                        $insert['igst'] = $val['igst'];
                        $insert['discount'] = $val['discount'];
                        $insert['sub_total'] = $val['total'];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;
                    }
                    $this->api_model->insert_quotation_details($insert_arr);
                }
            }
            if (!empty($insert_id) && !empty($product)) {
                $output = array('status' => 'Success', 'message' => 'Sales Order Successfully Added..');
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Sales Order Not added..');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter Sales Order Details');
            echo json_encode($output);
        }
    }

    public function api_get_po_data_by_firm() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $product['product'] = $this->api_model->get_product_by_frim_id($data['firm_id']);
            $product['model'] = $this->api_model->get_model_number_by_firm($data['firm_id']);
            $product['category'] = $this->api_model->get_category_by_frim_id($data['firm_id']);
            $product['brand'] = $this->api_model->get_brand_by_frim_id($data['firm_id']);
            $product['supplier'] = $this->api_model->get_suppliers_by_frim_id($data['firm_id']);

            $pre = $this->api_model->get_prefix_by_frim_id($data['firm_id']);
            $val = $this->increment_model->get_increment_id($pre[0]['prefix'], $data['code']);
            $val = $this->increment_model->get_increment_id($pre[0]['prefix'], $data['code']);
            $inc = explode('/', $val);

            $sales_id = 'PO-' . $pre[0]['prefix'] . '-' . $inc[1] . '' . $inc[2];
            $inv_id = 'PR-' . $pre[0]['prefix'] . '-' . $inc[1] . '' . $inc[2];

            $product['po_no'] = $sales_id;
            $product['pr_no'] = $inv_id;
            if (!empty($product)) {
                $output = array('status' => 'Success', 'message' => 'Frim Based Data', 'data' => $product);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter Firm ID');
            echo json_encode($output);
        }
    }

    public function api_add_purchase_order() {

        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $input = json_decode($json_input, TRUE);
         //  $output = array('status' => 'Success', 'message' => $input);

          // echo json_encode($output);
          // exit;

            $quotation = array();

            $user_info = $this->api_model->get_user_info_by_id($input['user_id']);

            $quotation['firm_id'] = $input['firm_id'];
            $quotation['pr_no'] = $input['pr_no'];
            $quotation['po_no'] = $input['po_no'];
            $quotation['supplier'] = $input['supplier'];
            $quotation['pr_status'] = $input['pr_status'];
            $quotation['delivery_status'] = $input['delivery_status'];
            $quotation['payment_status'] = 'Completed';
            $quotation['po_type'] = $input['po_type'];
            $quotation['total_qty'] = $input['total']['total_qty'];
            $quotation['subtotal_qty'] = $input['total']['sub_total'];
            $quotation['tax_label'] = $input['total']['tax_label_name'];
            $quotation['tax'] = $input['total']['tax_label'];
            $quotation['net_total'] = $input['total']['net_total'];
            $quotation['remarks'] = $input['total']['remarks'];
            $quotation['estatus'] = 1;
            $quotation['delivery_schedule'] = date('Y-m-d');
            $quotation['created_by'] = $user_info[0]['id'];
            $quotation['created_date'] = date('Y-m-d', strtotime($input['created_date']));
            if ($quotation['delivery_status'] == 'delivered') {
                $quotation['delivery_qty'] = $quotation['total_qty'];
            }

            $product = $input['add_po'];

            if (isset($product) && !empty($product)) {
                $insert_id = $this->api_model->insert_po($quotation);
            }

            if ($quotation['pr_status'] == 'approved') {
                $receipt_id=$this->api_model->insert_pr($quotation);
            }


            $q_no = $input['po_no'];
            $split = explode("-", $q_no);
            $code = 'PO';
            $this->increment_model->update_increment_id($split[1], $code);

           // $podetailsid = array();

            if (isset($insert_id) && !empty($insert_id)) {
                $insert_arr = array();
                if (isset($product) && !empty($product)) {

                    foreach ($product as $key => $val) {
                        $insert['po_id'] = $insert_id;
                        $insert['category'] = $val['cat_id'];
                        $insert['product_id'] = $val['product_name'];
                        $insert['product_description'] = $val['product_description'];
                        $insert['type'] = 1;
                        $insert['brand'] = $val['brand_id'];
                        $insert['unit'] = $val['unit'];
                        $insert['quantity'] = $val['qty'];
                        if ($quotation['delivery_status'] == 'delivered') {
                            $insert['delivery_quantity'] = $val['qty'];
                        }
                        $insert['per_cost'] = $val['unit_price'];
                        $insert['tax'] = $val['cgst'];
                        $insert['gst'] = $val['sgst'];
                        $insert['igst'] = $val['igst'];
                        $insert['discount'] = $val['discount'];
                        $insert['transport'] = $val['transport'];
                        $insert['sub_total'] = $val['total'];
                       // $insert['payment_status'] = 'Completed';
                        $insert['created_date'] = date('Y-m-d', strtotime($input['created_date']));
                        $insert_arr[] = $insert;

                        if ($quotation['pr_status'] == 'approved') {
                            $stock_arr = array();
                            $po_id['po_id'] = $quotation['pr_no'];
                            $stock_arr[] = $po_id;
                            $this->stock_details_po($insert, $po_id);
                        }

                         $po_details_id=$this->api_model->insert_podetails($insert);

                       $ime["po_id"]=$insert_id;
                        $ime["po_details_id"]=$po_details_id;
                        $ime["product_id"]=  $val['product_name'];
                        $ime["ime_code"]= $val['imei_code'];
                        $ime["status"]="open";
                        $ime["open_date"]=date('Y-m-d h:i:s');

//echo $po_details_id;
                    	//$podetailsid[]=$product;

                        $this->api_model->insert_ime_code($ime);

                    }
                   // $this->api_model->insert_po_details($insert_arr);

                }
            }

            //edit update

             $this->load->model('purchase_receipt/receipt_model');

             //$this->receipt_model->update_invoice(array('payment_status' => "Completed"), $insert_id);

             //$this->receipt_model->update_pr_invoice(array('payment_status' => "Completed"), $insert_id);

             $date=date('Y-m-d', strtotime($input['created_date']));
             if(empty($input['po']["delivery_schedule"]))
                    $date=date('Y-m-d');

             $insert_data=[
                "receipt_id"=>$receipt_id,
                "recevier"=>"company",
                "terms"=>1,
                "bill_amount"=>$input['total']["net_total"],
                "due_date"=>$date,
                "created_date"=>$date,
             ];

             $this->receipt_model->insert_receipt_bill($insert_data);




            if (!empty($insert_id) && !empty($product)) {
                $output = array('status' => 'Success', 'message' => 'Purchase Order Successfully Added..');
                // $output = array('status' => 'Success', 'message' => $input);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Purchase Order Not added..');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter Purchase Order Details');
            echo json_encode($output);
        }
    }





    function stock_details_po($stock_info, $po_id) {

        $this->api_model->check_stock_po($stock_info, $po_id);
    }

    public function api_pr_edit() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $datas["po"] = $po = $this->api_model->get_all_po_by_id($data['po_id']);
            $datas["po_details"] = $po_details = $this->api_model->get_all_po_details_by_id($data['po_id']);
            if (!empty($datas)) {
                $output = array('status' => 'Success', 'message' => 'Purchase Return Data', 'data' => $datas);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter PO ID');
            echo json_encode($output);
        }
    }

    public function api_edit_purchase_return() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $input = json_decode($json_input, TRUE);
            $quotation = array();
            $user_info = $this->api_model->get_user_info_by_id($input['user_id']);
            $id = $input['po_id'];
            $quotation['firm_id'] = $input['firm_id'];
            $quotation['pr_no'] = $input['pr_no'];
            $quotation['po_no'] = $input['po_no'];
            $quotation['supplier'] = $input['supplier'];
            //  $quotation['pr_status'] = $input['pr_status'];
            //$quotation['delivery_status'] = $input['delivery_status'];
            // $quotation['po_type'] = $input['po_type'];
            $quotation['total_qty'] = $input['total']['total_qty'];
            $quotation['subtotal_qty'] = $input['total']['sub_total'];
            $quotation['tax_label'] = $input['total']['tax_label_name'];
            $quotation['tax'] = $input['total']['tax_label'];
            $quotation['net_total'] = $input['total']['net_total'];
            $quotation['remarks'] = $input['total']['remarks'];
            $quotation['estatus'] = 1;
            $quotation['delivery_schedule'] = date('Y-m-d');
            $quotation['created_by'] = $user_info[0]['id'];
            $quotation['created_date'] = date('Y-m-d', strtotime($input['created_date']));
            // if ($quotation['delivery_status'] == 'delivered') {
            //  $quotation['delivery_qty'] = $quotation['total_qty'];
            // }

            $product = $input['add_po'];

            if (isset($product) && !empty($product)) {
                $update = $this->api_model->update_po($quotation, $id);
                $insert_id = $this->api_model->insert_pr($quotation);
            }
            if (isset($update) && !empty($update)) {
                $insert_arr1 = array();
                if (isset($product) && !empty($product)) {
                    foreach ($product as $key => $val) {
                        $insert1['po_id'] = $id;
                        $insert1['category'] = $val['cat_id'];
                        $insert1['product_id'] = $val['product_name'];
                        $insert1['product_description'] = $val['product_description'];
                        $insert1['type'] = 1;
                        $insert1['brand'] = $val['brand_id'];
                        $insert1['unit'] = $val['unit'];
                        $insert1['quantity'] = $val['qty'] - $val['return_quantity'];
                        //if ($quotation['delivery_status'] == 'delivered') {
                        //   $insert1['delivery_quantity'] = $val['qty'] - $val['return_quantity'];
                        // }
                        $insert1['per_cost'] = $val['unit_price'];
                        $insert1['tax'] = $val['cgst'];
                        $insert1['gst'] = $val['sgst'];
                        $insert1['igst'] = $val['igst'];
                        $insert1['discount'] = $val['discount'];
                        $insert1['transport'] = $val['transport'];
                        $insert1['sub_total'] = $val['total'];
                        $insert1['created_date'] = date('Y-m-d H:i');
                        $insert_arr1[] = $insert1;
                    }
                    $this->api_model->delete_po_details($id);
                    $this->api_model->insert_po_details($insert_arr1);
                }
            }

            if (isset($insert_id) && !empty($insert_id)) {
                $insert_arr = array();
                if (isset($product) && !empty($product)) {
                    foreach ($product as $key => $val) {
                        $insert['po_id'] = $insert_id;
                        $insert['category'] = $val['cat_id'];
                        $insert['product_id'] = $val['product_name'];
                        $insert['product_description'] = $val['product_description'];
                        $insert['type'] = 1;
                        $insert['brand'] = $val['brand_id'];
                        $insert['unit'] = $val['unit'];
                        $insert['return_quantity'] = $val['return_quantity'];
                        $insert['per_cost'] = $val['unit_price'];
                        $insert['tax'] = $val['cgst'];
                        $insert['gst'] = $val['sgst'];
                        $insert['igst'] = $val['igst'];
                        $insert['discount'] = $val['discount'];
                        $insert['transport'] = $val['transport'];
                        $insert['sub_total'] = $val['total'];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;

                        $stock_arr = array();
                        $po_id['po_id'] = $quotation['po_no'];
                        $stock_arr[] = $po_id;
                        $this->stock_details_pr($insert, $po_id);
                    }
                    $this->api_model->insert_pr_details($insert_arr);
                }
            }

            if (!empty($insert_id) && !empty($update)) {
                $output = array('status' => 'Success', 'message' => 'Purchase Returned Successfully');
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Purchase Not Return');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter Purchase Return Details');
            echo json_encode($output);
        }
    }

    function stock_details_pr($stock_info, $po_id) {

        $this->api_model->check_stock_pr($stock_info, $po_id);
    }

    public function api_get_receipt_details() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $po = $this->api_model->get_receipt_by_id($data['receipt_id']);
            if (!empty($po)) {
                $output = array('status' => 'Success', 'message' => 'Receipt Data', 'data' => $po);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter PO ID');
            echo json_encode($output);
        }
    }

    public function api_payment_receipt() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $input = json_decode($json_input, TRUE);
            if ($input['balance'] == 0 || $input['balance'] == 0.00 || $input['balance'] == '0.00')
                $receipt_status = 'Completed';
            else
                $receipt_status = 'Pending';
            $input['receipt_bill']['due_date'] = ($input['receipt_bill']['due_date']) ? date('Y-m-d', strtotime($input['receipt_bill']['due_date'])) : date('Y-m-d', strtotime($input['receipt_bill']['created_date']));
            $input['receipt_bill']['created_date'] = date('Y-m-d', strtotime($input['receipt_bill']['created_date']));

            $update = $this->api_model->update_invoice(array('payment_status' => $receipt_status), $input['receipt_bill']['receipt_id']);
            $insert_id = $this->api_model->insert_receipt_bill($input['receipt_bill']);

            if (!empty($insert_id)) {
                $output = array('status' => 'Success', 'message' => 'Purchase Amount Payed Successfully');
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter Payment Details');
            echo json_encode($output);
        }
    }

    public function api_dashboard_details() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);

            $firm_id = $this->api_model->get_user_firms($data['user_id']);
            $firm_id = array_map(function($firm_id) {
                return $firm_id['firm_id'];
            }, $firm_id);
            $filter_data['limit'] = $data['limit'];
            $filter_data['offset'] = $data['offset'];
            if ($filter_data['offset'] == 0) {
                $filter_data['offset'] = "";
            }
            $fun_id = $data['fun_id'];
            if ($fun_id == 1) {
                $datas['invoice'] = $this->api_model->get_firm_based_pending_invoice($firm_id, $filter_data);
                $filter_data['limit'] = 10;
                $datas['stock'] = $this->api_model->get_stock_report($firm_id, $filter_data);
                $datas['chart'] = $this->api_model->get_qty_chart($firm_id, $filter_data);
            } else if ($fun_id == 2) {
                $datas['stock'] = $this->api_model->get_stock_report($firm_id, $filter_data);
                $filter_data['limit'] = 10;
                $datas['invoice'] = $this->api_model->get_firm_based_pending_invoice($firm_id, $filter_data);
                $datas['chart'] = $this->api_model->get_qty_chart($firm_id, $filter_data);
            } else {
                $datas['chart'] = $this->api_model->get_qty_chart($firm_id, $filter_data);
                $filter_data['limit'] = 10;
                $datas['invoice'] = $this->api_model->get_firm_based_pending_invoice($firm_id, $filter_data);
                $datas['stock'] = $this->api_model->get_stock_report($firm_id, $filter_data);
            }



            if (!empty($datas)) {
                $output = array('status' => 'Success', 'message' => 'Dashboard Details', 'data' => $datas);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter User ID');
            echo json_encode($output);
        }
    }

    public function api_get_customer_by_invoice() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);

            $firm_id = $this->api_model->get_user_firms($data['user_id']);
            $firm_id = array_map(function($firm_id) {
                return $firm_id['firm_id'];
            }, $firm_id);

            $datas = $this->api_model->get_customer_by_invoice($firm_id, $data['customer_id']);


            if (!empty($datas)) {
                $output = array('status' => 'Success', 'message' => 'Invoice Details', 'data' => $datas);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter User ID and Customer ID');
            echo json_encode($output);
        }
    }

    public function api_get_customer_by_mobile_no() {

        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        if (!empty($json_input) && $data['mobile_no'] != '') {

            $customer = $this->api_model->get_all_customer_by_mobile_no($data['mobile_no']);

            if (!empty($customer)) {
                $output = array('status' => 'Success', 'message' => 'Customer Data', 'data' => $customer);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter Mobile Number');
            echo json_encode($output);
        }
    }

    public function api_get_product_by_barcode() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        if (!empty($json_input) && $data['barcode'] != '') {
           
            $product = $this->api_model->get_product_by_barcode($data['barcode'],$data['type'],$data['firm_id']);
            if (!empty($product)) {
                $output = array('status' => 'Success', 'message' => 'Product Data', 'data' => $product);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Enter Barcode');
            echo json_encode($output);
        }
    }

    public function api_get_monthly_amount() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);

        $product = $this->api_model->get_monthly_amount();
        if (!empty($product)) {
            if($product[0]['paid_amount']!=null){
               $output = array('status' => 'Success', 'message' => 'Invoice Amount', 'data' => $product);
                 echo json_encode($output); 
            }else{
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                 echo json_encode($output);
            }
            
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
            echo json_encode($output);
        }
    }

    public function api_customer_based_report() {

        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        $output = array();
        $search_arr['overdue'] = (isset($data['overdue']) && !empty($data['overdue'])) ? $data['overdue'] : "";
        $search_arr['from_date'] = (isset($data['from_date']) && !empty($data['from_date'])) ? $data['from_date'] : "";
        $search_arr['to_date'] = (isset($data['to_date']) && !empty($data['to_date'])) ? $data['to_date'] : "";
        $search_arr['inv_id'] = (isset($data['inv_id']) && !empty($data['inv_id'])) ? $data['inv_id'] : "";
        $search_arr['customer'] = (isset($data['customer']) && !empty($data['customer'])) ? $data['customer'] : "";
        $search_arr['product'] = (isset($data['product']) && !empty($data['product'])) ? $data['product'] : "";
        $search_arr['user_id'] = (isset($data['user_id']) && !empty($data['user_id'])) ? $data['user_id'] : "";
        $search_arr['firm_id'] = (isset($data['firm_id']) && !empty($data['firm_id'])) ? $data['firm_id'] : "";
        $search_arr['limit'] = $data['limit'];
        $search_arr['offset'] = $data['offset'];
        if ($search_arr['offset'] == 0) {
            $search_arr['offset'] = "";
        }
        if (empty($search_arr)) {
            $search_arr = array();
        }
        $list = $this->api_model->get_customer_based_datatables($search_arr);
        $i = 0;
        $data = array();
        foreach ($list as $val) {
            $link = '';
            $paid = $bal = $inv = $advance = $rtn_amt = 0;
            $advance = $advance + $val['advance'];
            $inv = $inv + $val['net_total'];
            $paid = $paid + $val['receipt_bill'][0]['receipt_paid'];
            $bal = $bal + ($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance']));

            $data[$i]['id'] = $val['id'];
            $data[$i]['customer_name'] = $val['store_name'];
            $data[$i]['inv_id'] = $val['inv_id'];
            $data[$i]['invoice_amount'] = number_format($val['net_total'], 2, '.', ',');
            $data[$i]['advance'] = number_format($val['advance'], 2, '.', ',');
            $data[$i]['paid_amount'] = number_format($val['receipt_bill'][0]['receipt_paid'], 2, '.', ',');

            if (($val['return'][0]['id'] != $val['return'][1]['id'])) {
                $rtn_amt = number_format($val['return'][1]['net_total'] - $val['return'][0]['net_total'], 2, '.', ',');
                $rtn_amt = str_replace("-", "", $rtn_amt);
            } else {
                $rtn_amt = '0.00';
            }
            $data[$i]['return_amount'] = $rtn_amt;
            $data[$i]['discount_amount'] = number_format($val['receipt_bill'][0]['receipt_discount'], 2, '.', ',');
            if (($val['return'][0]['id'] != $val['return'][1]['id'])) {
                $data[$i]['balance_amount'] = (($val['return'][1]['net_total'] - ($val['return'][1]['net_total'] - $val['return'][0]['net_total'])) - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']) > 0) ? number_format(($val['return'][1]['net_total'] - ($val['return'][1]['net_total'] - $val['return'][0]['net_total'])) - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance']), 2, '.', ',') : '0.00';
            } else {
                $data[$i]['balance_amount'] = ($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']) > 0) ? number_format($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance']), 2, '.', ',') : '0.00';
            }
            $data[$i]['created_date'] = ($val['created_date'] != '' && $val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '-';
            $data[$i]['due_date'] = ($val['receipt_bill'][0]['next_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['next_date'])) : '';
            if ($val['payment_status'] == 'Pending') {
                $data[$i]['payment_status'] = 'In-Complete';
            } else {
                $data[$i]['payment_status'] = 'Complete';
            }

            $i++;
        }
        if (!empty($data)) {
            $output = array('status' => 'Success', 'message' => 'Customer based Report', 'data' => $data);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
        }
        echo json_encode($output);
    }

    public function api_get_all_products() {

        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        $output = array();
        $list = $this->api_model->get_product_name();
        $i = 0;
        $data = array();
        foreach ($list as $val) {
            $data[$i]['id'] = $val['id'];
            $data[$i]['product_name'] = $val['product_name'];
            $i++;
        }
        if (!empty($data)) {
            $output = array('status' => 'Success', 'message' => 'Product Name', 'data' => $data);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
        }
        echo json_encode($output);
    }

    public function api_get_all_invoice_id() {

        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        $output = array();
        $list = $this->api_model->get_customer_based_datatables();
        $i = 0;
        $data = array();
        foreach ($list as $val) {
            $data[$i]['id'] = $val['id'];
            $data[$i]['inv_id'] = $val['inv_id'];
            $i++;
        }
        if (!empty($data)) {
            $output = array('status' => 'Success', 'message' => 'Invoice Id', 'data' => $data);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
        }
        echo json_encode($output);
    }

    public function api_outstanding_report_due_date() {

        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        $output = array();

        $search_arr['firm'] = (isset($data['firm']) && !empty($data['firm'])) ? $data['firm'] : "";
        $search_arr['cust_type'] = (isset($data['cust_type']) && !empty($data['cust_type'])) ? $data['cust_type'] : "";
        $search_arr['cust_reg'] = (isset($data['cust_reg']) && !empty($data['cust_reg'])) ? $data['cust_reg'] : "";
        $search_arr['user_id'] = (isset($data['user_id']) && !empty($data['user_id'])) ? $data['user_id'] : "";
        $search_arr['firm_id'] = (isset($data['firm_id']) && !empty($data['firm_id'])) ? $data['firm_id'] : "";
        $search_arr['limit'] = $data['limit'];
        $search_arr['offset'] = $data['offset'];
        if ($search_arr['offset'] == 0) {
            $search_arr['offset'] = "";
        }
        if (empty($search_arr)) {
            $search_arr = array();
        }

        $list = $this->api_model->get_outstanding_duedate_datatables($search_arr);
        $i = 0;
        $data = array();
        foreach ($list as $customer) {

            $days = $sevendays = $inv = $advance = $thirtydays = $nintydays = $receipt = 0;

            $a_val = $b_val = $c_val = $d_val = $e_val = $overall_total = 0;
            $days_net_total = $seven_days_net_total = $thirty_days_net_total = $ninty_days_net_total = $wingsinvoice_net_total = 0;

            if (!empty($customer['days'])) {
                foreach ($customer['days'] as $days_value) {
                    $days_net_total = $days_net_total + $days_value['new_balance'];
                }
            }

            if (!empty($customer['sevendays'])) {
                foreach ($customer['sevendays'] as $seven_days_value) {
                    $seven_days_net_total = $seven_days_net_total + $seven_days_value['new_balance'];
                }
            }

            if (!empty($customer['thirtydays'])) {
                foreach ($customer['thirtydays'] as $thirty_days_value) {
                    $thirty_days_net_total = $thirty_days_net_total + $thirty_days_value['new_balance'];
                }
            }

            if (!empty($customer['nintydays'])) {
                foreach ($customer['nintydays'] as $ninty_days_value) {
                    $ninty_days_net_total = $ninty_days_net_total + $ninty_days_value['new_balance'];
                }
            }
            if (!empty($customer['rec'])) {
                foreach ($customer['rec'] as $wingsinvoice) {
                    $wingsinvoice_net_total += $wingsinvoice['new_balance'];
                }
            }


            $overall_total = $days_net_total + $seven_days_net_total + $thirty_days_net_total + $ninty_days_net_total + $wingsinvoice_net_total;
            //if ($overall_total > 0) {
            $data[$i]['id'] = $customer['id'];
            $data[$i]['customer_name'] = $customer['store_name'];
            $data[$i]['mobil_number'] = $customer['mobil_number'];
            $data[$i]['wingsinvoice'] = ($wingsinvoice_net_total <= 0 ) ? '' : number_format($wingsinvoice_net_total, 2);
            $data[$i]['days'] = ($days_net_total <= 0 ) ? '' : number_format($days_net_total, 2);
            $data[$i]['sevendays'] = ($seven_days_net_total <= 0 ) ? '' : number_format($seven_days_net_total, 2);
            $data[$i]['thirtydays'] = ($thirty_days_net_total <= 0 ) ? '' : number_format($thirty_days_net_total, 2);
            $data[$i]['nintydays'] = ($ninty_days_net_total <= 0 ) ? '' : number_format($ninty_days_net_total, 2);
            $data[$i]['overall_total'] = number_format($overall_total, 2);

            $i++;
        }
        if (!empty($data)) {
            $output = array('status' => 'Success', 'message' => 'Outstanding Report Due Date', 'data' => $data);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
        }
        echo json_encode($output);
    }



 /*   public function api_puchase_reports(){
    	$json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        $output = array();
        $search_arr['from_date'] = (isset($data['from_date']) && !empty($data['from_date'])) ? $data['from_date'] : "";
        $search_arr['to_date'] = (isset($data['to_date']) && !empty($data['to_date'])) ? $data['to_date'] : "";
        $search_arr['po_no'] = (isset($data['po_no']) && !empty($data['po_no'])) ? $data['po_no'] : "";
        $search_arr['supplier'] = (isset($data['supplier']) && !empty($data['supplier'])) ? $data['supplier'] : "";
        $search_arr['product'] = (isset($data['product']) && !empty($data['product'])) ? $data['product'] : "";
        $search_arr['limit'] = $data['limit'];
        $search_arr['offset'] = $data['offset'];

         $firm_id = $this->api_model->get_user_firms($data['user_id']);
            $firm_id = array_map(function($firm_id) {
                return $firm_id['firm_id'];
            }, $firm_id);

         $search_arr['firm_id'] = $firm_id;   

        $this->load->model('purchase_order/purchase_order_model');

        $list = $this->purchase_order_model->get_purchase_report_datatables($search_arr);

        $i=0;
        foreach ($list as $val) {

        	$data[$i]['s.no'] = $i+1;
            $data[$i]['po_no'] = $val['po_no'];
            $data[$i]['customer_name'] = ($val['store_name']) ? $val['store_name'] : $val['name'];
            $data[$i]['total_qty'] = $val['total_qty'];
            $data[$i]['total_amount'] = number_format($val['net_total'], 2);
            $data[$i]['created_date'] = ($val['created_date'] != '' && $val['created_date'] != '0000-00-00') ? date('d-M-Y', strtotime($val['created_date'])) : '-';

            $i++;


        }

         if (!empty($data)) {
            $output = array('status' => 'Success', 'message' => 'Purchase Report List', 'data' => $data);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
        }
        echo json_encode($output);

    }



    public function api_stock_reports(){
    	$json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        $output = array();
        $search_arr['category'] = (isset($data['category']) && !empty($data['category'])) ? $data['category'] : "";
        $search_arr['brand'] = (isset($data['brand']) && !empty($data['brand'])) ? $data['brand'] : "";
        $search_arr['product'] = (isset($data['product']) && !empty($data['product'])) ? $data['product'] : "";
        $search_arr['user_id'] = (isset($data['user_id']) && !empty($data['user_id'])) ? $data['user_id'] : "";
        $search_arr['limit'] = $data['limit'];
        $search_arr['offset'] = $data['offset'];
        $search_arr['firm_id'] = ""; 
        if($data['user_id']!=""){
         $firm_id = $this->api_model->get_user_firms($data['user_id']);
            $firm_id = array_map(function($firm_id) {
                return $firm_id['firm_id'];
            }, $firm_id);

         $search_arr['firm_id'] = $firm_id;  

         } 

         $this->load->model('stock/stock_model');

        $list = $this->stock_model->get_all_stock($search_data);

        $i=0;
        foreach ($list as $val) {

        	$data[$i]['s.no'] = $i+1;
            $data[$i]['category'] = $val['categoryName'];
            $data[$i]['product'] = $val['product_name'];
            $data[$i]['brand'] = $val['brands'];
            $data[$i]['quantity'] =$val['quantity'];
            
            $i++;


        }

         if (!empty($data)) {
            $output = array('status' => 'Success', 'message' => 'Stock Report List', 'data' => $data);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
        }
        echo json_encode($output);

    }


     public function api_stock_based_lists_reports(){
    	$json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        $output = array();
        $search_arr['category'] = (isset($data['category']) && !empty($data['category'])) ? $data['category'] : "";
        $search_arr['product'] = (isset($data['product']) && !empty($data['product'])) ? $data['product'] : "";
        $search_arr['user_id'] = (isset($data['user_id']) && !empty($data['user_id'])) ? $data['user_id'] : "";
        $search_arr['limit'] = $data['limit'];
        $search_arr['offset'] = $data['offset'];
        $search_arr['firm_id'] = ""; 
        if($data['user_id']!=""){
         $firm_id = $this->api_model->get_user_firms($data['user_id']);
            $firm_id = array_map(function($firm_id) {
                return $firm_id['firm_id'];
            }, $firm_id);

         $search_arr['firm_id'] = $firm_id;  

         } 

         $custom_col = 'stock_report';

         $this->load->model('stock/stock_model');

        $list = $this->stock_model->get_datatables($search_arr, $custom_col);

        $i=0;
        foreach ($list as $val) {

        	$data[$i]['s.no'] = $i+1;
            $data[$i]['firm_name'] = $val['firm_name'];
            $data[$i]['categoryName'] = $val['categoryName'];
            $data[$i]['brand'] = $val['brands'];
            $data[$i]['product_name'] =$val['product_name'];
            $data[$i]['cost_price'] =$val['cost_price'];
            $data[$i]['quantity'] =$val['quantity'];
            $data[$i]['total_price'] =round($val['quantity'] * $val['cost_price']);
            $data[$i]['cgst'] =round(($val["quantity"] * $val["cost_price"] * $val["cgst"]) / 100, 2);
            $data[$i]['sgst'] =round(($val["quantity"] * $val["cost_price"] * $val["sgst"]) / 100, 2);
            $net_total = ($val["quantity"] * $val["cost_price"] + (($val["quantity"] * $val["cost_price"] * $val["cgst"]) / 100) + (($val["quantity"] * $val["cost_price"] * $val["sgst"]) / 100);
            $data[$i]['net_total'] = round($net_total, 2);
            
            $i++;


        }

         if (!empty($data)) {
            $output = array('status' => 'Success', 'message' => 'Stock Report List', 'data' => $data);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
        }
        echo json_encode($output);

    }*/


    public function api_profit_list() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        $output = array();

        $search_arr['from_date'] = (isset($data['from_date']) && !empty($data['from_date'])) ? $data['from_date'] : "";
        $search_arr['to_date'] = (isset($data['to_date']) && !empty($data['to_date'])) ? $data['to_date'] : "";
        $search_arr['user_id'] = (isset($data['user_id']) && !empty($data['user_id'])) ? $data['user_id'] : "";
        $search_arr['firm_id'] = (isset($data['firm_id']) && !empty($data['firm_id'])) ? $data['firm_id'] : "";
        $search_arr['limit'] = $data['limit'];
        $search_arr['offset'] = $data['offset'];
        if ($search_arr['offset'] == 0) {
            $search_arr['offset'] = "";
        }

        if (empty($search_arr)) {
            $search_arr = array();
        }
        $list = $this->api_model->get_profit_datatables($search_arr);

        $data = array();
        $i = 0;
        $cgst = 0;
        $sgst = 0;
        foreach ($list as $val) {
            $net_total = $val['net_total'];
            if ($val->advance != '') {
                $net_total = $val['net_total'] - $val['advance'];
            }
            $invoice_total = $val['subtotal_qty'] + $val['transport'] + $val['labour'];


            if (isset($val['or_amount']) && !empty($val['or_amount'])) {
                if (isset($val['or_amount']) && !empty($val['or_amount'])) {
                    $j = 0;
                    $cgst = 0;
                    $sgst = 0;
                    $p = 0;
                    foreach ($val['or_amount'] as $vals) {

                        $p1 = $vals['cost_price'] * $vals['quantity'];

                        $cgst1 = ($vals['tax'] / 100 ) * ($vals['cost_price'] * $vals['quantity']);

                        $gst_type = $quotation[0]['state_id'];
                        if ($gst_type != '') {
                            if ($gst_type == 31) {

                                $sgst1 = ($vals['gst'] / 100 ) * ($vals['cost_price'] * $vals['quantity']);
                            } else {
                                $sgst1 = ($vals['igst'] / 100 ) * ($vals['cost_price'] * $vals['quantity']);
                            }
                        }
                        $p += $p1;
                    }
                    $j++;
                }
                $org_price = (($p + $cgst + $sgst + $val['transport'] + $val['labour']));

                $price = (($invoice_total - $val['commission_rate']) - $p) / $invoice_total;
                $profit_per = $price * 100;
                //echo ($profit_per > 0 && !empty($p)) ? number_format($profit_per) . '%' : '0' . '%';

                $total_cost_price = number_format((($invoice_total - $val['commission_rate']) - $p), 2, '.', ',');
            }

            $data[$i]['id'] = $customer['id'];
            $data[$i]['customer_name'] = ($val['store_name']) ? $val['store_name'] : $val['name'];
            $data[$i]['inv_id'] = $val['inv_id'];
            $data[$i]['created_date'] = ($val['created_date'] != '' && $val['created_date'] != '0000-00-00') ? date('d-M-Y', strtotime($val['created_date'])) : '-';
            $data[$i]['invoice_amount'] = ($invoice_total > 0 ) ? number_format($invoice_total, 2) : '0';
            $data[$i]['commission_rate'] = $val['commission_rate'];
            $data[$i]['original_amount'] = number_format($p, 2);
            $data[$i]['profit'] = ($profit_per > 0 && !empty($p)) ? number_format($profit_per) . '%' : '0' . '%';
            $data[$i]['profit_amount'] = ($total_cost_price > 0 && !empty($p) ) ? $total_cost_price : '0';

            $i++;
        }

        if (!empty($data)) {
            $output = array('status' => 'Success', 'message' => 'Profit and Loss Report', 'data' => $data);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
        }


        echo json_encode($output);
    }

    public function api_outstanding_report() {

        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        $output = array();

        $search_arr['customer'] = (isset($data['customer']) && !empty($data['customer'])) ? $data['customer'] : "";
        $search_arr['firm'] = (isset($data['firm']) && !empty($data['firm'])) ? $data['firm'] : "";
        $search_arr['user_id'] = (isset($data['user_id']) && !empty($data['user_id'])) ? $data['user_id'] : "";
        $search_arr['firm_id'] = (isset($data['firm_id']) && !empty($data['firm_id'])) ? $data['firm_id'] : "";
        $search_arr['limit'] = $data['limit'];
        $search_arr['offset'] = $data['offset'];
        if ($search_arr['offset'] == 0) {
            $search_arr['offset'] = "";
        }

        if (empty($search_arr)) {
            $search_arr = array();
        }

        $list = $this->api_model->get_payment_datatables($search_arr);

        $data = array();
        $i = 0;

        foreach ($list as $val) {
            $created_date = '';
            $paid = $bal = $inv = 0;
            $inv = $inv + $val['receipt_bill'][0]['net_total'];
            $paid = $paid + $val['receipt_bill'][0]['receipt_paid'];
            $bal = $bal + ($val['receipt_bill'][0]['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']));
            $created_date = ($val['receipt_bill'][0]['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['created_date'])) : '-';

            $data[$i]['id'] = $val['id'];
            $data[$i]['customer_name'] = ($val['store_name']) ? $val['store_name'] : $val['name'];
            $data[$i]['invoice_amount'] = number_format($val['receipt_bill'][0]['net_total'], 2, '.', ',');
            $data[$i]['paid_amount'] = number_format($val['receipt_bill'][0]['receipt_paid'], 2, '.', ',');
            $data[$i]['discount_amount'] = number_format($val['receipt_bill'][0]['receipt_discount'], 2, '.', ',');
            $data[$i]['balance'] = number_format(($val['receipt_bill'][0]['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'])), 2, '.', ',');
            $data[$i]['created_date'] = $created_date;
            $data[$i]['due_date'] = ($val['receipt_bill'][0]['next_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['next_date'])) : '';
            $net_total = $val['receipt_bill'][0]['net_total'];
            $paidanddiscount = $val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'];
            if ($net_total != $paidanddiscount) {
                $data[$i]['payment_status'] = 'In-Complete';
            } else {
                $data[$i]['payment_status'] = 'Complete';
            }

            $i++;
        }
        if (!empty($data)) {
            $output = array('status' => 'Success', 'message' => 'Outstanding Report', 'data' => $data);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
        }
        echo json_encode($output);
    }

    public function api_outstanding_report_firm_wise() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        $output = array();

        $search_arr['cust_type'] = (isset($data['cust_type']) && !empty($data['cust_type'])) ? $data['cust_type'] : "";
        $search_arr['cust_reg'] = (isset($data['cust_reg']) && !empty($data['cust_reg'])) ? $data['cust_reg'] : "";
        $search_arr['due_date'] = (isset($data['due_date']) && !empty($data['due_date'])) ? $data['due_date'] : "";
        $search_arr['user_id'] = (isset($data['user_id']) && !empty($data['user_id'])) ? $data['user_id'] : "";
        $search_arr['firm_id'] = (isset($data['firm_id']) && !empty($data['firm_id'])) ? $data['firm_id'] : "";
        $search_arr['limit'] = $data['limit'];
        $search_arr['offset'] = $data['offset'];
        if ($search_arr['offset'] == 0) {
            $search_arr['offset'] = "";
        }
        if (empty($search_arr)) {
            $search_arr = array();
        }
        $list = $this->api_model->get_outstanding_datatables($search_arr);

        $i = 0;
        $data = array();
        foreach ($list as $customer) {

            if ($customer['firm_id'] == 1)
                $electricals = ($electricals + ($customer['net_total'] - ($customer['electricals'] + $customer['advance'])));
            if ($customer['firm_id'] == 2)
                $paints = ($paints + ($customer['net_total'] - ($customer['paints'] + $customer['advance'])));
            if ($customer['firm_id'] == 3)
                $tiles = ($tiles + ($customer['net_total'] - ($customer['tiles'] + $customer['advance'])));
            if ($customer['firm_id'] == 4)
                $hardware = ($hardware + ($customer['net_total'] - ($customer['hardware'] + $customer['advance'])));

            $net_amount = $net_amount + ($customer['net_total'] - ($customer['net_amount'] + $customer['advance']));

            $data[$i]['id'] = $customer['id'];
            $data[$i]['customer_name'] = ($customer['store_name']) ? $customer['store_name'] : $customer['name'];
            $data[$i]['mobil_number'] = $customer['mobil_number'];
            $data[$i]['electricals'] = ($customer['firm_id'] == 1) ? number_format($customer['net_total'] - ($customer['electricals'] + $customer['advance']), 2) : '0';
            $data[$i]['paints'] = ($customer['firm_id'] == 2) ? number_format($customer['net_total'] - ($customer['paints'] + $customer['advance']), 2) : '0';
            $data[$i]['tiles'] = ($customer['firm_id'] == 3) ? number_format($customer['net_total'] - ($customer['tiles'] + $customer['advance']), 2) : '0';
            $data[$i]['hardware'] = ($customer['firm_id'] == 4) ? number_format($customer['net_total'] - ($customer['hardware'] + $customer['advance']), 2) : '0';
            $data[$i]['net_amount'] = ($customer['net_total'] != '') ? number_format($customer['net_total'] - ($customer['net_amount'] + $customer['advance']), 2) : '0';

            $i++;
        }
        if (!empty($data)) {
            $output = array('status' => 'Success', 'message' => 'Outstanding Report Firm wise', 'data' => $data);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
        }
        echo json_encode($output);
    }

//    function api_invoice_report() {
//
//        $json_input = file_get_contents('php://input', TRUE); // JSON Input
//        $data = json_decode($json_input, TRUE);
//        $output = array();
//
//        $search_arr['overdue'] = (isset($data['overdue']) && !empty($data['overdue'])) ? $data['overdue'] : "";
//        $search_arr['from_date'] = (isset($data['from_date']) && !empty($data['from_date'])) ? $data['from_date'] : "";
//        $search_arr['to_date'] = (isset($data['to_date']) && !empty($data['to_date'])) ? $data['to_date'] : "";
//        $search_arr['inv_id'] = (isset($data['inv_id']) && !empty($data['inv_id'])) ? $data['inv_id'] : "";
//        $search_arr['customer'] = (isset($data['customer']) && !empty($data['customer'])) ? $data['customer'] : "";
//        $search_arr['product'] = (isset($data['product']) && !empty($data['product'])) ? $data['product'] : "";
//        $search_arr['sales_man'] = (isset($data['sales_man']) && !empty($data['sales_man'])) ? $data['sales_man'] : "";
//        $search_arr['user_id'] = (isset($data['user_id']) && !empty($data['user_id'])) ? $data['user_id'] : "";
//        $search_arr['firm_id'] = (isset($data['firm_id']) && !empty($data['firm_id'])) ? $data['firm_id'] : "";
//        $search_arr['limit'] = $data['limit'];
//        $search_arr['offset'] = $data['offset'];
//        if ($search_arr['offset'] == 0) {
//            $search_arr['offset'] = "";
//        }
//
//        if (empty($search_arr)) {
//            $search_arr = array();
//        }
////        print_r($search_arr);
////        exit;
//        $list = $this->api_model->get_invoice_datatables($search_arr);
//
//
//        $data = array();
//        $i = 0;
//        foreach ($list as $val) {
//            if ($val['credit_days'] > 0 && $val['created_date'] != '1970-01-01') {
//                $due_date = date('d-M-Y', strtotime($val['created_date'] . "+" . $val['credit_days'] . " days"));
//            } else {
//                $due_date = '-';
//            }
//
//            $data[$i]['id'] = $val['id'];
//            $data[$i]['inv_id'] = $val['inv_id'];
//            $data[$i]['customer_name'] = ($val['store_name']) ? $val['store_name'] : $val['name'];
//            $data[$i]['total_qty'] = $val['total_qty'];
//            $data[$i]['cgst'] = number_format(($val['erp_invoice_details'][0]['cgst']), 2);
//            $data[$i]['sgst'] = number_format(($val['erp_invoice_details'][0]['sgst']), 2);
//            $data[$i]['subtotal_qty'] = number_format($val['subtotal_qty'], 2);
//            $data[$i]['net_total'] = number_format($val['net_total'], 2);
//            $data[$i]['paid_amount'] = number_format(($val['receipt_bill'][0]['receipt_paid'] + $val['advance']), 2, '.', ',');
//            $data[$i]['created_date'] = ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '';
//            $data[$i]['paid_date'] = ($val['receipt_bill'][0]['paid_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['paid_date'])) : '-';
//            $data[$i]['credit_days'] = $val['credit_days'] > 0 ? $val['credit_days'] : '-';
//            $data[$i]['due_date'] = $due_date;
//            $data[$i]['credit_limit'] = ($val['credit_limit'] != '') ? $val['credit_limit'] : '-';
//            $data[$i]['exceeded_limit'] = ($val['exceeded_limit'] != '') ? $val['exceeded_limit'] : '-';
//            $data[$i]['sales_man'] = $val['sales_man_name'];
//
//            $i++;
//        }
//        if (!empty($data)) {
//            $output = array('status' => 'Success', 'message' => 'Invoice Report', 'data' => $data);
//        } else {
//            $output = array('status' => 'error', 'message' => 'Data Not Found');
//        }
//        echo json_encode($output);
//    }

    function api_gst_report() {

        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        $output = array();

        $search_arr['firm'] = (isset($data['firm']) && !empty($data['firm'])) ? $data['firm'] : "";
        $search_arr['cust_type'] = (isset($data['cust_type']) && !empty($data['cust_type'])) ? $data['cust_type'] : "";
        $search_arr['from_date'] = (isset($data['from_date']) && !empty($data['from_date'])) ? $data['from_date'] : "";
        $search_arr['to_date'] = (isset($data['to_date']) && !empty($data['to_date'])) ? $data['to_date'] : "";
        $search_arr['user_id'] = (isset($data['user_id']) && !empty($data['user_id'])) ? $data['user_id'] : "";
        $search_arr['firm_id'] = (isset($data['firm_id']) && !empty($data['firm_id'])) ? $data['firm_id'] : "";
        $search_arr['gst'] = (isset($data['gst']) && !empty($data['gst'])) ? $data['gst'] : "";

        $search_arr['limit'] = $data['limit'];
        $search_arr['offset'] = $data['offset'];
        if ($search_arr['offset'] == 0) {
            $search_arr['offset'] = "";
        }

        if (empty($search_arr)) {
            $search_arr = array();
        }

        $list = $this->api_model->get_gst_datatables($search_arr);


        $data = array();
        $i = 0;
        foreach ($list as $val) {
            $cgst = $sgst = $quantity = $total_gst = $sub_total = 0;
            $inv_amount = 0;
            if (!empty($search_arr['gst'])) {
                $cgst = number_format($val['inv_all_details']['id']['cgst'], 2);
                $sgst = number_format($val['inv_all_details']['id']['sgst'], 2);
                $quantity = $val['inv_all_details']['id']['quantity'];
                $sub_total = number_format($val['inv_all_details']['id']['sub_total'], 2);
                $inv_amount = $val['inv_all_details']['id']['sub_total'] + $val['inv_all_details']['id']['total_gst'];
                $inv_amount = number_format($inv_amount, 2);
            } else {
                $quantity = $val['total_qty'];
                $cgst = number_format(($val['erp_invoice_details'][0]['cgst']), 2);
                $sgst = number_format(($val['erp_invoice_details'][0]['sgst']), 2);
                $sub_total = number_format($val['subtotal_qty'], 2);
                $inv_amount = number_format($val['net_total'], 2);
            }

            if ($val['credit_days'] > 0 && $val['created_date'] != '1970-01-01') {
                $due_date = date('d-M-Y', strtotime($val['created_date'] . "+" . $val['credit_days'] . " days"));
            } else {
                $due_date = '-';
            }
            $tin = ($val['tin']) ? ' - ' . $val['tin'] : '';
            $data[$i]['id'] = $val['id'];
            $data[$i]['inv_id'] = $val['inv_id'];
            $data[$i]['firm_name'] = $val['firm_name'];
            $data[$i]['gstin'] = ($val['gstin']) ? $val['gstin'] : '';
            $data[$i]['customer_name'] = ($val['store_name']) ? $val['store_name'] : $val['name'];
            $data[$i]['gstin'] = ($val['tin']) ? $val['tin'] : '';
            $data[$i]['total_qty'] = $quantity;
            $data[$i]['cgst'] = $cgst;
            $data[$i]['sgst'] = $sgst;
            $data[$i]['subtotal_qty'] = $sub_total;
            $data[$i]['net_total'] = $inv_amount;
            /*
              $data[$i]['total_qty'] = $val['total_qty'];
              $data[$i]['cgst'] = number_format(($val['erp_invoice_details'][0]['cgst']), 2);
              $data[$i]['sgst'] = number_format(($val['erp_invoice_details'][0]['sgst']), 2);
              $data[$i]['subtotal_qty'] = number_format($val['subtotal_qty'], 2);
              $data[$i]['net_total'] = number_format($val['net_total'], 2);
             */
            $data[$i]['created_date'] = ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '';

            $i++;
        }
        if (!empty($data)) {
            $output = array('status' => 'Success', 'message' => 'GST Report', 'data' => $data);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
        }
        echo json_encode($output);
    }

    function api_gst_percentage() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        $output = array();
        $this->load->model('report/report_model');
        $all_gst = $this->report_model->get_all_gstvalues();
        //echo "<pre>";
        // print_r($all_gst);
        //exit;
        $i = 0;
        foreach ($all_gst as $key => $val) {
            $list[$i]['gst'] = $val;
            $i++;
        }

        $percentage_list = $list;
        // echo "<pre>";print_r($percentage_list);exit;
        $output = array('status' => 'Success', 'message' => 'GST Percentage List', 'data' => $percentage_list);
        echo json_encode($output);
    }

    function api_getallsalesman() {
        //$this->load->model('masters/sales_man_model');
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        $firm_id = (isset($data['firm_id']) && !empty($data['firm_id'])) ? $data['firm_id'] : array('1', '2', '3', '4');
        $output = array();
        $sales_man_list = $this->api_model->get_sales_man($firm_id);
        $output = array('status' => 'Success', 'message' => 'Salesman List', 'data' => $sales_man_list);
        echo json_encode($output);
    }

    function reset_session() {

        $data = $this->input->post();

        $this->session_view->clear_session($data["class"], $data["method"]);
    }

    public function get_present_list() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        if (isset($data['date'])) {

            $date = $data['date'];
        } else {

            $date = date('Y-m-d');
        }
        $present_details = $this->api_model->get_present_list($date);

        $i = 0;
        if (!empty($present_details)) {

            foreach ($present_details as $value) {
                $employee_present_details[$i]['id'] = $value['id'];
                $employee_present_details[$i]['employee_id'] = $value['employee_id'];
                $employee_present_details[$i]['username'] = $value['username'];
                $employee_present_details[$i]['first_name'] = $value['first_name'];
                $employee_present_details[$i]['In_time'] = $value['In_time'];
                $employee_present_details[$i]['Out_time'] = $value['Out_time'];
                $employee_present_details[$i]['department'] = $value['department'];
                $employee_present_details[$i]['designation'] = $value['Designation'];
//                $employee_present_details[$i]['current_status'] = $value['out'];
                if ($value['Out_time'] == '' || $value['Out_time'] == '00:00:00') {
                    $employee_present_details[$i]['current_status'] = 'In';
                } else {
                    $employee_present_details[$i]['current_status'] = 'Out';
                }
                $i++;
            }
            $output = array('status' => 'Success', 'message' => 'present_details', 'Present_list' => $employee_present_details);
            echo json_encode($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
            echo json_encode($output);
        }
    }

    public function get_absent_list() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        if (isset($data['date'])) {

            $date = $data['date'];
        } else {

            $date = date('Y-m-d');
        }
        $absent_details = $this->api_model->get_absent_list($date);
        $i = 0;

        if (!empty($absent_details)) {

            foreach ($absent_details as $value) {
                $employee_absent_details[$i]['id'] = $value['id'];
                $employee_absent_details[$i]['employee_id'] = $value['employee_id'];
                $employee_absent_details[$i]['username'] = $value['username'];
                $employee_absent_details[$i]['first_name'] = $value['first_name'];
                $employee_absent_details[$i]['In_time'] = $value['In_time'];
                $employee_absent_details[$i]['Out_time'] = $value['Out_time'];
                $employee_absent_details[$i]['department'] = $value['department'];
                $employee_absent_details[$i]['designation'] = $value['Designation'];
//                if ($value['Out_time'] == '' || $value['Out_time'] == '00:00:00') {
//                    $employee_absent_details[$i]['current_status'] = 'In';
//                } else {
//                    $employee_absent_details[$i]['current_status'] = 'Out';
//                }
                $i++;
            }
            $output = array('status' => 'Success', 'message' => 'absent_details', 'Absent_list' => $employee_absent_details);
            echo json_encode($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
            echo json_encode($output);
        }
    }

    public function get_total_employess() {
        $total_employess = $this->api_model->get_total_employess();
        if (!empty($total_employess)) {
            $output = array('status' => 'Success', 'message' => 'total_employess', 'Total_employess' => $total_employess);
            echo json_encode($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
            echo json_encode($output);
        }
    }

    function get_total_present_employess() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        if (isset($data['date'])) {

            $date = $data['date'];
        } else {

            $date = date('Y-m-d');
        }
        $present_employess = $this->api_model->get_present_list($date);
        if (!empty($present_employess)) {
            $output = array('status' => 'Success', 'message' => 'present_employess', 'Total_present_employess' => count($present_employess));
            echo json_encode($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
            echo json_encode($output);
        }
    }

    function get_late_list() {
        $late_employess = $this->api_model->get_late_list();

        if (!empty($late_employess)) {
            $output = array('status' => 'Success', 'message' => 'late_employess', 'late_list' => $late_employess);
            echo json_encode($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
            echo json_encode($output);
        }
    }

    function get_total_absent_employess() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        if (isset($data['date'])) {

            $date = $data['date'];
        } else {

            $date = date('Y-m-d');
        }
        $total_employess = $this->api_model->get_total_employess();
        $present_employess = $this->api_model->get_present_list($date);

        if (!empty($present_employess) && !empty($total_employess)) {
            $output = array('status' => 'Success', 'message' => 'absent_employess', 'Total_absent_employees' => ($total_employess) - count($present_employess));
            echo json_encode($output);
        } else {
            $output = array('status' => 'Success', 'message' => 'absent_employess', 'Total_absent_employees' => ($total_employess));
            echo json_encode($output);
        }
    }

    function api_invoice_report() {

        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        $output = array();

        $search_arr['overdue'] = (isset($data['overdue']) && !empty($data['overdue'])) ? $data['overdue'] : "";
        $search_arr['from_date'] = (isset($data['from_date']) && !empty($data['from_date'])) ? $data['from_date'] : "";
        $search_arr['to_date'] = (isset($data['to_date']) && !empty($data['to_date'])) ? $data['to_date'] : "";
        $search_arr['inv_id'] = (isset($data['inv_id']) && !empty($data['inv_id'])) ? $data['inv_id'] : "";
        $search_arr['customer'] = (isset($data['customer']) && !empty($data['customer'])) ? $data['customer'] : "";
        $search_arr['product'] = (isset($data['product']) && !empty($data['product'])) ? $data['product'] : "";
        $search_arr['sales_man'] = (isset($data['sales_man']) && !empty($data['sales_man'])) ? $data['sales_man'] : "";
        $search_arr['user_id'] = (isset($data['user_id']) && !empty($data['user_id'])) ? $data['user_id'] : "";
        $search_arr['firm_id'] = (isset($data['firm_id']) && !empty($data['firm_id'])) ? $data['firm_id'] : "";
        $search_arr['gst'] = (isset($data['gst']) && !empty($data['gst'])) ? $data['gst'] : "";
        $search_arr['limit'] = $data['limit'];
        $search_arr['offset'] = $data['offset'];
        if ($search_arr['offset'] == 0) {
            $search_arr['offset'] = "";
        }

        if (empty($search_arr)) {
            $search_arr = array();
        }

        $list = $this->api_model->get_invoice_datatables($search_arr);

        $data = array();
        $i = 0;
        $total_amount=0;
        foreach ($list as $val) {


            $cgst = $sgst = $quantity = $total_gst = $sub_total = 0;
            $inv_amount = 0;
            $id = $val['id'];
            if (!empty($search_arr['gst'])) {


                $cgst = number_format($list['inv_all_details'][$id]['cgst'], 2);
                $sgst = number_format($list['inv_all_details'][$id]['sgst'], 2);
                $quantity = $list['inv_all_details'][$id]['quantity'];
                $sub_total = number_format($list['inv_all_details'][$id]['sub_total'], 2);
                $inv_amount = $list['inv_all_details'][$id]['sub_total'] + $list['inv_all_details']['id']['total_gst'];
                $inv_amount = number_format($inv_amount, 2);
            } else {
                $quantity = $val['total_qty'];
                $cgst = number_format(($val['erp_invoice_details'][0]['cgst']), 2);
                $sgst = number_format(($val['erp_invoice_details'][0]['sgst']), 2);
                $sub_total = number_format($val['subtotal_qty'], 2);
                $inv_amount = number_format($val['net_total'], 2);
            }
            if ($val['credit_days'] > 0 && $val['created_date'] != '1970-01-01') {
                $due_date = date('d-M-Y', strtotime($val['created_date'] . "+" . $val['credit_days'] . " days"));
            } else {
                $due_date = '-';
            }

            $data[$i]['id'] = $val['id'];
            $data[$i]['inv_id'] = $val['inv_id'];
            $data[$i]['customer_name'] = ($val['store_name']) ? $val['store_name'] : $val['name'];
            $data[$i]['total_qty'] = $quantity;
            $data[$i]['cgst'] = $cgst;
            $data[$i]['sgst'] = $sgst;
            $data[$i]['subtotal_qty'] = number_format($val['subtotal_qty'], 2);
            $data[$i]['net_total'] = number_format($val['net_total'], 2);
            $data[$i]['paid_amount'] = number_format(($val['receipt_bill'][0]['receipt_paid'] + $val['advance']), 2, '.', ',');
            $data[$i]['created_date'] = ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '';
            $data[$i]['paid_date'] = ($val['receipt_bill'][0]['paid_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['paid_date'])) : '-';
            $data[$i]['credit_days'] = $val['credit_days'] > 0 ? $val['credit_days'] : '-';
            $data[$i]['due_date'] = $due_date;
            $data[$i]['credit_limit'] = ($val['credit_limit'] != '') ? $val['credit_limit'] : '-';
            $data[$i]['exceeded_limit'] = ($val['exceeded_limit'] != '') ? $val['exceeded_limit'] : '-';
            $data[$i]['sales_man'] = $val['sales_man_name'];
            $total_amount += round(number_format($val['net_total'], 2));

            $i++;
        }
        if (!empty($data)) {
            $output = array('status' => 'Success', 'message' => 'Invoice Report','total_amount'=>$total_amount,'data' => $data);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
        }
        echo json_encode($output);
    }

    public function api_daily_attendance_report() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        $output = array();
        $filter_data['department'] = (isset($data['department']) && !empty($data['department'])) ? $data['department'] : "";
        $filter_data['designation'] = (isset($data['designation']) && !empty($data['designation'])) ? $data['designation'] : "";
        $filter_data['shift'] = (isset($data['shift']) && !empty($data['shift'])) ? $data['shift'] : "";
        $filter_data['created_date'] = (isset($data['created_date']) && !empty($data['created_date'])) ? $data['created_date'] : "";
        $filter_data['limit'] = $data['limit'];
        $filter_data['offset'] = $data['offset'];
        if ($filter_data['offset'] == 0) {
            $filter_data['offset'] = "";
        }

        if (empty($filter_data)) {
            $filter_data = array();
        }
        if (!isset($filter_data['date'])) {
            $date = date('Y-m-d');
            $filter_data['date'] = $date;
        }

        $attendance_details = $this->api_model->api_daily_attendance_report($filter_data);
        $i = 0;
        if (!empty($attendance_details)) {
            foreach ($attendance_details as $value) {
                $employee_attendance_details[$i]['id'] = $value['id'];
                $employee_attendance_details[$i]['employee_id'] = $value['employee_id'];
                $employee_attendance_details[$i]['username'] = $value['username'];
                $employee_attendance_details[$i]['first_name'] = $user_value['first_name'] . ' ' . $user_value['last_name'];
                $employee_attendance_details[$i]['In_time'] = $value['In_time'];
                $employee_attendance_details[$i]['Out_time'] = $value['Out_time'];
                $employee_attendance_details[$i]['department'] = $value['department'];
                $employee_attendance_details[$i]['designation'] = $value['Designation'];
                $employee_attendance_details[$i]['email'] = $value['email'];
//                if ($value['Out_time'] == '' || $value['Out_time'] == '00:00:00') {
//                    $employee_attendance_details[$i]['current_status'] = 'In';
//                } else {
//                    $employee_attendance_details[$i]['current_status'] = 'Out';
//                }

                $output = array('status' => 'Success', 'message' => 'attendance_details', 'Daily attendance details' => $employee_attendance_details);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
            echo json_encode($output);
        }

        echo json_encode($output);
    }

    public function api_monthly_attendance_reports() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        $output = $monthly_users_list = array();
        $i = 0;
        $user_details = $this->api_model->get_all_user_details();

        if (!empty($user_details)) {
            foreach ($user_details as $user_value) {
                $monthly_users_list[$i]['user_id'] = $user_value['id'];
                $monthly_users_list[$i]['employee_id'] = $user_value['employee_id'];
                $monthly_users_list[$i]['username'] = $user_value['username'];
                $monthly_users_list[$i]['employee_name'] = $user_value['first_name'] . ' ' . $user_value['last_name'];
                $monthly_users_list[$i]['email'] = $user_value['email'];
                $monthly_users_list[$i]['department'] = $user_value['department'];
                $monthly_users_list[$i]['Designation'] = $user_value['Designation'];
                $dayNumber = date("j");
                $monthly_users_list[$i]['No of days'] = $dayNumber;
                $user_count = $this->api_model->get_user_month_total($user_value['id']);
                $monthly_users_list[$i]['present_days'] = $user_count;
                $start_date = date('Y-m-01');
                $current_date = date('Y-m-d');
                $count = 0;
                while (strtotime($start_date) <= strtotime($current_date)) {
                    $get_details = $this->api_model->get_present_absent_details($user_value['id'], $start_date);

                    if (!empty($get_details)) {
                        $monthly_users_list[$i]['dates'][$count]['date'] = 'P';
                    } else {
                        $monthly_users_list[$i]['dates'][$count]['date'] = 'A';
                    }
                    $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
                    $count++;
                }

                $i++;
            }

            $output = array('status' => 'Success', 'message' => 'Monthly User Details', 'monthly_user_list' => $monthly_users_list);
        } else {
            $output = array('status' => 'error', 'message' => 'Please Enter ID ');
        }

        echo json_encode($output);
    }

    public function api_monthly_users_details() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            if (isset($data['year'])) {
                $year = $data['year'];
            } else {

                $year = "";
            }
            if (isset($data['month'])) {

                $month = $data['month'];
            } else {

                $month = "";
            }

            $datas = $this->api_model->monthly_users_details($year, $month, $data['user_id']);

            $i = 0;
            if (!empty($datas)) {
                foreach ($datas as $value) {
                    $present_details[$i]['id'] = $value['id'];
                    $present_details[$i]['employee_id'] = $value['employee_id'];
                    $present_details[$i]['username'] = $value['username'];
                    $present_details[$i]['first_name'] = $value['first_name'] . ' ' . $value['last_name'];
                    $present_details[$i]['In_time'] = $value['In_time'];
                    $present_details[$i]['Out_time'] = $value['Out_time'];
                    $present_details[$i]['department'] = $value['department'];
                    $present_details[$i]['designation'] = $value['Designation'];
                    if ($value['Out_time'] == '' || $value['Out_time'] == '00:00:00') {
                        $employee_absent_details[$i]['current_status'] = 'In';
                    } else {
                        $employee_absent_details[$i]['current_status'] = 'Out';
                    }
                    $i++;
                }
                $output = array('status' => 'Success', 'message' => 'attendance Details', 'attendance Details' => $datas);
                echo json_encode($output);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Please Enter ID ');
            echo json_encode($output);
        }
    }

    public function api_pdf_present_list() {
        $json_input = file_get_contents('php://input', TRUE);
        $data['report_title'] = 'present List';
        $data = json_decode($json_input, TRUE);
        if (isset($data['date'])) {

            $date = $data['date'];
        } else {

            $date = date('Y-m-d');
        }
        $data["product_details"] = $present_details = $this->api_model->get_all_user($date);
        $i = 0;
        if (!empty($present_details)) {

            foreach ($present_details as $value) {
                $employee_present_details[$i]['id'] = $value['id'];
                $employee_present_details[$i]['employee_id'] = $value['employee_id'];
                $employee_present_details[$i]['username'] = $value['username'];
                $employee_present_details[$i]['first_name'] = $value['first_name'];
                $employee_present_details[$i]['In_time'] = $value['In_time'];
                $employee_present_details[$i]['Out_time'] = $value['Out_time'];
                $employee_present_details[$i]['department'] = $value['department'];
                $employee_present_details[$i]['designation'] = $value['Designation'];
                $get_attendance_details = $this->api_model->get_attendance_details($date, $value['id']);
                if ($get_attendance_details > 0) {
                    $employee_present_details[$i]['present_status'] = 'present';
                } else {
                    $employee_present_details[$i]['present_status'] = 'Absent';
                }


                $i++;
            }
            $data["product_details"] = $employee_present_details;
            $body = $this->load->view('attendance_report', $data, TRUE);
            $file_path = $file_path = FCPATH . '/attachement/api_attendance_report/';
            $filename = 'Attendance_report.pdf';
            $pdfFilePath = $file_path . $filename;
            $mpdf = new mPDF('', 'A4', '10', '"Roboto", "Noto", sans-serif', 5, 5, 25, 8, 5, 5, 'L');
//            $pdf->writeHTMLCell(0, 0, '', '', $body, 0, 1, 0, true, '', true);
            $mpdf->allow_charset_conversion = true;
            $mpdf->charset_in = 'iso-8859-4';
            $mpdf->SetHTMLFooter('<div class="pdf_date" style="color:black; text-align:left;" ></div><div class="pdf_pagination" style="color:black; text-align:right;" >{PAGENO} / {nb}</div>');
            $output_pdf = mb_convert_encoding($body, 'UTF-8', 'UTF-8');
            $mpdf->WriteHTML($output_pdf);
            $mpdf->Output($pdfFilePath, 'F');
            if (!empty($filename)) {
                $Check_file = FCPATH . 'attachement/api_attendance_report/' . $filename;
                if (file_exists($Check_file)) {
                    $link = $this->config->item('base_url') . 'attachement/api_attendance_report/';
                    $file_link = $link . $filename;
                }
            }
            if ($file_link) {
                $output = array('status' => 'Success', 'message' => 'Daily_attendance', 'link' => $file_link);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
        }
        echo json_encode($output);
    }

    public function pdf_monthly_users_details() {

        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            if (isset($data['year'])) {

                $year = $data['year'];
            } else {

                $year = "";
            }
            if (isset($data['month'])) {

                $month = $data['month'];
            } else {

                $month = "";
            }

            $datas = $this->api_model->monthly_users_details($year, $month, $data['user_id']);
//            print_r($datas);
//            exit;

            /* $json_input = file_get_contents('php://input', TRUE);
              $data['report_title'] = 'present List';
              $data = json_decode($json_input, TRUE);

              if (isset($data['user_id'])) {
              $user_id = $data['user_id'];
              }
              if (isset($data['date'])) {

              $date = $data['date'];
              } else {

              $date = date('Y-m-d');
              }

              if (isset($data['year'])) {

              $year = $data['year'];
              } else {

              $year = "";
              }
              $data["monthly_users_details"] = $present_details = $this->api_model->get_all_user_details_basedonid($user_id);
              $start_date = date('Y-m-01');
              $end_date = date('Y-m-d');
              $i = 0;
              if (!empty($present_details)) {


              $employee_present_details[$i]['id'] = $present_details['id'];
              $employee_present_details[$i]['employee_id'] = $present_details['employee_id'];
              $employee_present_details[$i]['username'] = $present_details['username'];
              $employee_present_details[$i]['first_name'] = $present_details['first_name'];
              //                $employee_present_details[$i]['In_time'] = $value['In_time'];
              //                $employee_present_details[$i]['Out_time'] = $value['Out_time'];
              $employee_present_details[$i]['department'] = $present_details['department'];
              $employee_present_details[$i]['designation'] = $present_details['Designation'];

              //$get_attendance_details = $this->api_model->get_attendance_details_basedondate($start_date, $present_details['id']);
              while (strtotime($start_date) <= strtotime($end_date)) {

              $get_attendance_details = $this->api_model->get_attendance_details_basedondate($start_date, $user_id, $year);

              $employee_present_details[$i]['attendance_month'][$start_date] = $get_attendance_details;


              if (isset($get_attendance_details) && !empty($get_attendance_details)) {
              $employee_present_details[$i]['attendance_month'][$start_date][0]['Time'] = $get_attendance_details[0]['in_time'] . '-' . $get_attendance_details[0]['out_time'];
              $attendance_id = $get_attendance_details[0]['id'];
              $break_details = $this->api_model->get_break_details_basedonattendance_id($attendance_id, $year);
              $break = array();
              if (isset($break_details) & & !empty($break_details)) {
              foreach ($break_details as $value) {
              $break_in_out_time = $value['out_time'] . '-' . $value['in_time'];
              $break[] = $break_in_out_time;
              }
              }

              $breaklunch = implode(",", $break);
              $employee_present_details[$i]['attendance_month'][$start_date][0]['break/lunch'] = $breaklunch;
              }
              $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
              }

              $i++; */ $data["monthly_users_details"] = $datas;

            $body = $this->load->view('monthly_attendance_report', $data, TRUE);
            $file_path = $file_path = FCPATH . '/attachement/api_monthly_report/';
            $filename = 'Monthly_Attendance_Report.pdf';
            $pdfFilePath = $file_path . $filename;
            $mpdf = new mPDF('', 'A4', '10', '"Roboto", "Noto", sans-serif', 5, 5, 25, 8, 5, 5, 'L');
            $mpdf->allow_charset_conversion = true;
            $mpdf->charset_in = 'iso-8859-4';
            $mpdf->SetHTMLFooter('<div class="pdf_date" style="color:black; text-align:left;" ></div><div class="pdf_pagination" style="color:black; text-align:right;" >{PAGENO} / {nb}</div>');
            $output_pdf = mb_convert_encoding($body, 'UTF-8', 'UTF-8');
            $mpdf->WriteHTML($output_pdf);
            $mpdf->Output($pdfFilePath, 'F');
            if (!empty($filename)) {
                $Check_file = FCPATH . 'attachement/api_monthly_report/' . $filename;
                if (file_exists($Check_file)) {
                    $link = $this->config->item('base_url') . 'attachement/api_monthly_report/';
                    $file_link = $link . $filename;
                }
            }
            if ($file_link) {
                $output = array('status' => 'Success', 'message' => 'Monthly_users_details.', 'link' => $file_link);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
        }
        echo json_encode($output);
    }

    public function api_daily_present_details() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            if (isset($data['date'])) {

                $date = $data['date'];
            } else {

                $date = date('Y-m-d');
            }


            if (isset($data['user_id'])) {
                $user_id = $data['user_id'];
            }
            $data["monthly_users_details"] = $present_details = $this->api_model->get_all_user_details_basedonid($user_id);
            $i = 0;
            if (!empty($present_details)) {
                $employee_present_details[$i]['id'] = $present_details['id'];
                $employee_present_details[$i]['employee_id'] = $present_details['employee_id'];
                $employee_present_details[$i]['username'] = $present_details['first_name'] . " " . $present_details['last_name'];
//            $employee_present_details[$i]['last_name'] = $present_details['last_name'];
                $employee_present_details[$i]['department'] = $present_details['department'];
                $employee_present_details[$i]['designation'] = $present_details['Designation'];
                $employee_present_details[$i]['Date'] = $date;

                $get_attendance_details = $this->api_model->daily_details_basedondate($user_id, $date);
                $employee_present_details[$i]['Time'] = $get_attendance_details;
                $break_details = $this->api_model->daily_break_details($user_id, $date);
                $break = array();

                for ($j = 0; $j < count($break_details); $j++) {
                    $break[$j]['Out_time'] = $break_details[$j]['Out_time'];
                    $break[$j]['in_time'] = $break_details[$j]['in_time'];
                    $break[$j]['Status'] = ($break_details[$j]['in_time'] != '' && $break_details[$j]['in_time'] != NULL) ? 'In' : 'Out';
                }
                $employee_present_details[$i]['break/lunch'] = $break;


                if ($get_attendance_details[0]['out_time'] != '') {
                    $employee_present_details[$i]['current_status'] = 'Out';
                } else {

                    $employee_present_details[$i]['current_status'] = 'In';
                }
                $i++;
                $data["monthly_users_details"] = $employee_present_details;
                $output = array('status' => 'Success', 'message' => 'User Details', 'Daily_User_Details' => $employee_present_details);
            } else {
                $output = array('status' => 'error', 'message' => 'Data Not Found');
                echo json_encode($output);
            }
        } else {
            $output = array('status' => 'error', 'message' => 'Please Enter ID ');
        }


        echo json_encode($output);
    }

    public function api_overtime_report() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);
        if (isset($data['year'])) {

            $year = $data['year'];
        } else {

            $year = "";
        }
        if (isset($data['month'])) {

            $month = $data['month'];
        } else {

            $month = "";
        }
        $search_arr['department'] = (isset($data['department']) && !empty($data['department'])) ? $data['department'] : "";
        $search_arr['designation'] = (isset($data['designation']) && !empty($data['designation'])) ? $data['designation'] : "";
        if (empty($search_arr)) {
            $search_arr = array();
        }
        $output = $monthly_users_list = array();

        $user_details = $this->api_model->get_all_user_details($search_arr);

        $i = 0;
        if (!empty($user_details)) {
            foreach ($user_details as $user_value) {
                $monthly_users_list[$i]['user_id'] = $user_value['id'];
                $monthly_users_list[$i]['employee_id'] = $user_value['employee_id'];
                $monthly_users_list[$i]['username'] = $user_value['username'];
                $monthly_users_list[$i]['employee_name'] = $user_value['first_name'] . ' ' . $user_value['last_name'];
                $monthly_users_list[$i]['email'] = $user_value['email'];
                $monthly_users_list[$i]['department'] = $user_value['department'];
                $monthly_users_list[$i]['Designation'] = $user_value['Designation'];
                $monthly_users_list[$i]['normal_rate/hour'] = '';
                $monthly_users_list[$i]['wages_for_overtime_work'] = '';
                $monthly_users_list[$i]['net_amount_paid'] = '';
                $monthly_users_list[$i]['signature_of_the_employee'] = '';
                $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $dayNumber = date("j");
                if ($month == date("m") || $month == '') {
                    $start_date = date('Y-m-01');
                    $current_date = date('Y-m-' . $dayNumber);
                    $count = 0;
                    while (strtotime($start_date) <= strtotime($current_date)) {

                        $get_details = $this->api_model->get_overtime_details($user_value['id'], $start_date);
//
                        $monthly_users_list[$i]['overtime'] = $get_details;


                        if (!empty($get_details)) {
                            $monthly_users_list[$i]['dates'][$count]['date'] = 'P';
                        } else {
                            $monthly_users_list[$i]['dates'][$count]['date'] = 'A';
                        }
                        $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
                        $count++;
                    }
                } else {

                    $start_date = date('Y-m-01');
                    $current_date = date('Y-m-' . $number);
                    $count = 0;
                    while (strtotime($start_date) <= strtotime($current_date)) {
                        $get_details = $this->api_model->get_overtime_details($user_value['id'], $start_date);
                        $monthly_users_list[$i]['overtime'] = $get_details;
                        if (!empty($get_details)) {
                            $monthly_users_list[$i]['dates'][$count]['date'] = 'P';
                        } else {
                            $monthly_users_list[$i]['dates'][$count]['date'] = 'A';
                        }
                        $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
                        $count++;
                    }
                }
                $i++;
            }

            $output = array('status' => 'Success', 'message' => 'Monthly User Details', 'monthly_user_list' => $monthly_users_list);
        } else {
            $output = array('status' => 'error', 'message' => 'Please Enter ID ');
        }

        echo json_encode($output);
    }

    function get_late_out_list() {

        $late_out_employess = $this->api_model->get_late_out_list();

        if (!empty($late_out_employess)) {

            $output = array('status' => 'Success', 'message' => 'late_out_employess', 'late_out_list' => $late_out_employess);
            echo json_encode($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
            echo json_encode($output);
        }
    }

    function get_early_in_list() {

        $early_in_employess = $this->api_model->get_early_in_list();
        if (!empty($early_in_employess)) {
            $output = array('status' => 'Success', 'message' => 'early_in_employess', 'early_in_list' => $early_in_employess);
            echo json_encode($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
            echo json_encode($output);
        }
    }

    function get_early_out_list() {

        $early_out_employess = $this->api_model->get_early_out_list();
        if (!empty($early_out_employess)) {
            $output = array('status' => 'Success', 'message' => 'early_out_employess', 'early_out_list' => $early_out_employess);
            echo json_encode($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Data Not Found');
            echo json_encode($output);
        }
    }

    function get_api_dashboard_list() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        $data = json_decode($json_input, TRUE);



        $filter_data['limit'] = $data['limit'];
            $filter_data['offset'] = $data['offset'];
            if ($filter_data['offset'] == 0) {
                $filter_data['offset'] = "";
         }

        $user_id=$data['user_id'];

      
        $today_purchase = $this->api_model->get_today_purchase($user_id,$filter_data);
        $today_sales= $this->api_model->get_today_sales($user_id,$filter_data);
        $today_inward = $this->api_model->get_today_inward($user_id);
        $today_outward = $this->api_model->get_today_outward($user_id);


        $today_in_out_ward=[];

         $today_in_out_ward[0]['purchase_qty'] =round($today_inward[0]['inward_qty']);
         $today_in_out_ward[0]['sales_qty'] =round($today_outward[0]['outward_qty']);
         $today_in_out_ward[0]['purchase_amount'] =round($today_inward[0]['purchase_amount']);
         $today_in_out_ward[0]['sales_amount'] =round($today_outward[0]['sales_amount']);


       // echo "<pre>";print_r($result);exit;
        
        if (!empty($today_inward) && !empty($today_inward)) {
            $output = array('status' => 'Success', 'message' => 'dashboard_list','today_purchase'=>$today_purchase,'today_sales'=>$today_sales,"today_in_out_ward"=>$today_in_out_ward);
            echo json_encode($output);
        } else {
            $output = array('status' => 'Success', 'message' => 'Data Not Found');
            echo json_encode($output);
        }
    }

}
