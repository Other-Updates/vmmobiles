<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends MX_Controller
{

    function __construct()
    {

        parent::__construct();

        $this->clear_cache();



        if (!$this->user_auth->is_logged_in()) {

            redirect($this->config->item('base_url') . 'admin');
        }

        $main_module = 'masters';

        $access_arr = array(
            'products/index' => array('add', 'edit', 'delete', 'view'),
            'products/insert_product' => array('add'),
            'products/edit_product' => array('edit'),
            'products/update_products' => array('edit'),
            'products/delete_product' => array('delete'),
            'products/add_duplicate_product' => 'no_restriction',
            'products/update_duplicate_product' => 'no_restriction',
            'products/import_products' => array('add', 'edit', 'delete', 'view'),
            'products/ajaxList' => 'no_restriction',
            'products/get_category_by_frim_id' => 'no_restriction',
            'products/stock_details' => 'no_restriction',
            'products/get_brand_by_frim_id' => 'no_restriction',
            'products/save_barcode' => 'no_restriction',
            'products/generate_barcode' => 'no_restriction',
            'products/barcode_pdf' => 'no_restriction',
            'products/check_product' => 'no_restriction',
            'products/excel_report' => 'no_restriction',
            'products/check_imie_code_available' => 'no_restriction',
            'products/check_imiecode_availability' => 'no_restriction',
            'products/get_product_by_firm_catid' => 'no_restriction',
        );



        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {

            redirect($this->config->item('base_url'));
        }

        $this->load->model('masters/product_model');

        $this->load->model('master_style/master_model');

        $this->load->model('masters/categories_model');

        $this->load->model('masters/brand_model');

        $this->load->model('manage_firms/manage_firms_model');
    }

    public function index()
    {





        /*  $query=$this->db->get('erp_product')->result_array();

          foreach($query as $data){

          $this->db->where('id',$data['id']);



          echo $data['product_name'];echo "<br>";



          $barcode=htmlentities($data['product_name']);



          // echo $barcode;echo "<br>";



          $updates=$this->db->update('erp_product',["barcode"=>trim($barcode)]);



          echo trim($barcode);echo "<br>";



          }

          exit; */

        $data["category"] = $details = $this->categories_model->get_all_category();

        $data["brand"] = $this->brand_model->get_brand();

        $data["last_id"] = $this->master_model->get_last_id('m_code');

        $data['firms'] = $firms = $this->user_auth->get_user_firms();



        $this->template->write_view('content', 'masters/product', $data);

        $this->template->render();
    }

    public function check_imie_code_available()
    {

        $post_data = $this->input->post();



        $data = $this->product_model->check_imie_exists($post_data);



        if ($data)
            echo 1;
        else
            echo 0;
    }

    public function check_imiecode_availability()
    {

        $post_data = $this->input->post();



        $data = $this->product_model->check_imiecode_availability($post_data);



        if ($data == 1)
            echo 1;
        else
            echo $data;
    }

    public function get_product_by_firm_catid()
    {

        $post_data = $this->input->post();



        $data = $this->product_model->get_product_by_firm_catid($post_data);



        if ($data == 1)
            echo 1;
        else
            echo json_encode($data);
    }

    public function insert_product()
    {



        if ($this->input->post()) {



            $data["product"] = $this->product_model->get_product();



            $this->load->helper('text');



            $config['upload_path'] = './attachement/product';



            $config['allowed_types'] = '*';



            $config['max_size'] = '20000';



            $this->load->library('upload', $config);



            $upload_data['file_name'] = $_FILES;

            if (isset($_FILES) && !empty($_FILES)) {

                $upload_files = $_FILES;

                if ($upload_files['admin_image'] != '') {

                    $_FILES['admin_image'] = array(
                        'name' => $upload_files['admin_image']['name'],
                        'type' => $upload_files['admin_image']['type'],
                        'tmp_name' => $upload_files['admin_image']['tmp_name'],
                        'error' => $upload_files['admin_image']['error'],
                        'size' => '20000'
                    );

                    $this->upload->do_upload('admin_image');



                    $upload_data = $this->upload->data();



                    $dest = getcwd() . "/attachement/product/" . $upload_data['file_name'];



                    $src = $this->config->item("base_url") . 'attachement/product/' . $upload_data['file_name'];
                }
            }

            $input_data['admin']['admin_image'] = $upload_data['file_name'];

            $expired_date = '0000-00-00';

            if ($this->input->post('expires_in') != '' && $this->input->post('expires_in') > 0) {

                $expires_in = $this->input->post('expires_in');

                $expired_date = date('Y-m-d', strtotime("+" . $expires_in . " days"));
            }



            $datas = $this->input->POST();



            $brand_id = $this->input->POST('brand_id');



            $brand_name = $this->product_model->get_brand_name($brand_id);



            $barcode = $this->input->POST('barcode');

            if (empty($this->input->POST('barcode'))) {

                $barcode = $this->input->post('product_name');
            }
            $cp_without_gst = '0.0';
            if ($this->input->post('cost_price')) {
                $cost_price = $this->input->post('cost_price');
                $cgst = $this->input->POST('cgst');
                $sgst = $this->input->POST('sgst');
                $cp_with_gst = $cost_price * (($cgst + $sgst) / 100);
                $cp_without_gst = $cost_price - $cp_with_gst;
            }
            $sp_without_gst = '0.0';
            if ($this->input->post('sales_price')) {
                $sales_price = $this->input->post('sales_price');
                $cgst = $this->input->POST('cgst');
                $sgst = $this->input->POST('sgst');
                $sp_with_gst = $sales_price * (($cgst + $sgst) / 100);
                $sp_without_gst = $sales_price - $sp_with_gst;
            }

            $input = array(
                'model_no' => $this->input->post('model_no'),
                'product_name' => $this->input->post('product_name'),
                'product_description' => $this->input->post('product_description'),
                'product_image' => $upload_data['file_name'],
                'type' => $this->input->post('type'),
                'min_qty' => $this->input->post('min_qty'),
                'reorder_quantity' => $this->input->post('reorder_quantity'),
                'cost_price_without_gst' => $cp_without_gst,
                'sales_price_without_gst' => $sp_without_gst,
                'cost_price' => $this->input->post('cost_price'),
                'sales_price' => $this->input->post('sales_price'),
                // 'cash_cus_price' => $this->input->post('cash_cus_price'),
                //'credit_cus_price' => $this->input->post('credit_cus_price'),
                //'cash_con_price' => $this->input->post('cash_con_price'),
                //'credit_con_price' => $this->input->post('credit_con_price'),
                // 'vip_price' => $this->input->post('vip_price'),
                //'vvip_price' => $this->input->post('vvip_price'),
                // 'h1_price' => $this->input->post('h1_price'),
                'discount' => $this->input->post('discount'),
                //'h2_price' => $this->input->post('h2_price'),
                'hsn_sac' => $this->input->post('hsn_sac'),
                'unit' => $this->input->post('unit'),
                'created_by' => $this->user_auth->get_user_id(),
                'firm_id' => $this->input->POST('firm_id'),
                'category_id' => $datas['CategoryId'],
                'cgst' => $this->input->POST('cgst'),
                'sgst' => $this->input->POST('sgst'),
                'barcode' => htmlentities($barcode),
                'brand_id' => $this->input->POST('brand_id'),
                'expires_in' => $this->input->post('expires_in'),
                'expired_date' => $expired_date,
                'created_date' => date('Y-m-d'),
                'igst' => $this->input->POST('igst'),
                'qty' => 0
            );

            //echo "<pre>";print_r($input);exit;

            if ($datas['CategoryId'] != "") {

                $insert_id = $this->product_model->insert_product($input);

                $qty = $this->input->post('reorder_quantity');

                $this->stock_details($input, $insert_id);
            }

            //            $input['qty']=0;
            //            echo '<pre>';print_r($input);exit;



            $data["product"] = $details = $this->product_model->get_product();

            redirect($this->config->item('base_url') . 'masters/products');
        }
    }

    public function edit_product($id)
    {

        $data["product"] = $details = $this->product_model->get_product_by_id($id);

        $data["brand"] = $this->brand_model->get_brand();

        $data['firms'] = $firms = $this->user_auth->get_user_firms();

        $data['productid'] = $id;

        $data["category"] = $details = $this->categories_model->get_all_category();

        //  echo "<pre>";print_r($data);exit;

        $this->template->write_view('content', 'masters/update_product', $data);

        $this->template->render();
    }

    public function update_products()
    {



        if ($this->input->post()) {

            $id = $this->input->post('id');

            //echo "<pre>";print_r($id);exit;

            $expired_date = '0000-00-00';

            if ($this->input->post('expires_in') != '' && $this->input->post('expires_in') > 0) {

                $expires_in = $this->input->post('expires_in');

                $expired_date = date('Y-m-d', strtotime("+" . $expires_in . " days"));
            }



            $brand_id = $this->input->POST('brand_id');



            $brand_name = $this->product_model->get_brand_name($brand_id);







            $barcode = $this->input->POST('barcode');

            if (empty($this->input->POST('barcode'))) {

                $barcode = $this->input->post('product_name');
            }
            $cp_without_gst = '0.0';
            if ($this->input->post('cost_price')) {
                $cost_price = $this->input->post('cost_price');
                $cgst = $this->input->POST('cgst');
                $sgst = $this->input->POST('sgst');
                $cp_with_gst = $cost_price * (($cgst + $sgst) / 100);
                $cp_without_gst = $cost_price - $cp_with_gst;
            }
            $sp_without_gst = '0.0';
            if ($this->input->post('sales_price')) {
                $sales_price = $this->input->post('sales_price');
                $cgst = $this->input->POST('cgst');
                $sgst = $this->input->POST('sgst');
                $sp_with_gst = $sales_price * (($cgst + $sgst) / 100);
                $sp_without_gst = $sales_price - $sp_with_gst;
            }


            $input = array(
                'id' => $this->input->post('id'),
                'model_no' => $this->input->post('model_no'),
                'product_name' => $this->input->post('product_name'),
                'product_description' => $this->input->post('product_description'),
                'type' => $this->input->post('type'),
                'min_qty' => $this->input->post('min_qty'),
                'reorder_quantity' => $this->input->post('reorder_quantity'),
                'cost_price_without_gst' => $cp_without_gst,
                'sales_price_without_gst' => $sp_without_gst,
                'cost_price' => $this->input->post('cost_price'),
                'sales_price' => $this->input->post('sales_price'),
                //'cash_cus_price' => $this->input->post('cash_cus_price'), 'credit_cus_price' => $this->input->post('credit_cus_price'),
                // 'cash_con_price' => $this->input->post('cash_con_price'), 'credit_con_price' => $this->input->post('credit_con_price'),
                //  'vip_price' => $this->input->post('vip_price'), 'vvip_price' => $this->input->post('vvip_price'),
                'discount' => $this->input->post('discount'),
                'hsn_sac' => $this->input->post('hsn_sac'),
                'igst' => $this->input->POST('igst'),
                // 'h1_price' => $this->input->post('h1_price'), 'h2_price' => $this->input->post('h2_price'),
                'unit' => $this->input->post('unit'),
                'created_by' => $this->user_auth->get_user_id(), 'firm_id' => $this->input->POST('firm_id'), 'category_id' => $this->input->POST('category_id'), 'cgst' => $this->input->POST('cgst'), 'sgst' => $this->input->POST('sgst'), 'barcode' => htmlentities($barcode), 'brand_id' => $this->input->POST('brand_id'), 'expires_in' => $this->input->post('expires_in'), 'expired_date' => $expired_date
            );

            //$data["product"]=$this->product_model->get_product();

            $this->load->helper('text');

            $config['upload_path'] = './attachement/product/';

            $config['allowed_types'] = '*';

            $config['max_size'] = '2000';

            $this->load->library('upload', $config);

            $upload_data['file_name'] = $_FILES;

            if (isset($_FILES) && !empty($_FILES)) {

                $upload_files = $_FILES;

                if ($upload_files['admin_image']['name'] != '') {

                    $_FILES['admin_image'] = array(
                        'name' => $upload_files['admin_image']['name'],
                        'type' => $upload_files['admin_image']['type'],
                        'tmp_name' => $upload_files['admin_image']['tmp_name'],
                        'error' => $upload_files['admin_image']['error'],
                        'size' => '2000'
                    );

                    $this->upload->do_upload('admin_image');



                    $upload_data = $this->upload->data();



                    $dest = getcwd() . "/attachement/product/" . $upload_data['file_name'];



                    $src = $this->config->item("base_url") . 'attachement/product/' . $upload_data['file_name'];

                    $input_data['admin_image'] = $upload_data['file_name'];

                    // $input['product_image'] = $upload_data['file_name'];

                    $input = array(
                        // 'model_no' => $this->input->post('model_no'),

                        'product_name' => $this->input->post('product_name') . " " . "-" . " " . $brand_name,
                        'product_description' => $this->input->post('product_description'),
                        'product_image' => trim($upload_data['file_name']),
                        'type' => $this->input->post('type'), 'min_qty' => $this->input->post('min_qty'),
                        'sales_price' => $this->input->post('sales_price'),
                        // 'reorder_quantity' => $this->input->post('reorder_quantity'), 'cost_price' => $this->input->post('cost_price'),
                        // 'cash_cus_price' => $this->input->post('cash_cus_price'), 'credit_cus_price' => $this->input->post('credit_cus_price'),
                        //'cash_con_price' => $this->input->post('cash_con_price'),
                        'hsn_sac' => $this->input->post('hsn_sac'),
                        //'credit_con_price' => $this->input->post('credit_con_price'),
                        // 'vip_price' => $this->input->post('vip_price'), 'vvip_price' => $this->input->post('vvip_price'),
                        'discount' => $this->input->post('discount'),
                        'created_by' => $this->user_auth->get_user_id(), 'firm_id' => $this->input->POST('firm_id'), 'category_id' => $this->input->POST('category_id'), 'cgst' => $this->input->POST('cgst'), 'sgst' => $this->input->POST('sgst'), 'barcode' => htmlentities($barcode), 'brand_id' => $this->input->POST('brand_id'), 'expires_in' => $this->input->post('expires_in'), 'expired_date' => $expired_date
                    );



                    //  $data=   $this->product_model->update_image($id, $upload_data['file_name']);
                }
            }



            //echo $id;echo "<pre>";print_r($input);exit;

            $this->product_model->update_product($input, $id);

            redirect($this->config->item('base_url') . 'masters/products');
        }
    }

    public function delete_product()
    {

        $data["product"] = $details = $this->product_model->get_product();

        $id = $this->input->POST('value1');

        $this->product_model->delete_product($id);

        redirect($this->config->item('base_url') . 'masters/products');
    }

    public function add_duplicate_product()
    {



        $input = $this->input->post();

        $validation = $this->product_model->add_duplicate_product($input);

        $i = 0;

        if ($validation) {

            $i = 1;
        }

        if ($i == 1) {

            echo 0;
        } else {

            echo 1;
        }
    }

    public function update_duplicate_product()
    {

        $input = $this->input->get('value1');

        $id = $this->input->get('value2');

        $validation = $this->product_model->update_duplicate_product($input, $id);



        $i = 0;

        if ($validation) {

            $i = 1;
        }
        if ($i == 1) {

            echo "Model Number Already Exist";

            exit;
        }
    }

    function import_products()
    {



        if ($this->input->post()) {



            $skip_rows = $this->input->post('skip_rows');



            if ($skip_rows == 0)
                $skip_rows = 1;

            //            $skip_rows = 1;

            $is_success = 0;



            if (!empty($_FILES['product_data'])) {



                $config['upload_path'] = './attachement/csv/';



                $config['allowed_types'] = '*';



                $config['max_size'] = '10000';



                $this->load->library('upload', $config);



                $random_hash = substr(str_shuffle(time()), 0, 3) . strrev(mt_rand(100000, 999999));



                $extension = pathinfo($_FILES['product_data']['name'], PATHINFO_EXTENSION);



                $new_file_name = 'product_' . $random_hash . '.' . $extension;



                $_FILES['product_data'] = array(
                    'name' => $new_file_name,
                    'type' => $_FILES['product_data']['type'],
                    'tmp_name' => $_FILES['product_data']['tmp_name'],
                    'error' => $_FILES['product_data']['error'],
                    'size' => $_FILES['product_data']['size']
                );



                $config['file_name'] = $new_file_name;



                $this->upload->initialize($config);



                $this->upload->do_upload('product_data');



                $upload_data = $this->upload->data();



                $file_name = $upload_data['file_name'];



                $file = base_url() . 'attachement/csv/' . $file_name;



                $handle = fopen($file, 'r');



                if ($file != NULL && $skip_rows > 0) {



                    $skipLines = $skip_rows;



                    $lineNum = 1;



                    if ($skipLines > 0) {



                        while (fgetcsv($handle)) {



                            if ($lineNum == $skipLines) {



                                break;
                            }



                            $lineNum++;
                        }
                    }
                }



                $count = 1;

                if ($file != NULL) {



                    while ($row_data = fgetcsv($handle)) {





                        $product_name = $row_data[0];



                        $firm_name = $row_data[1];



                        $status = 'Active';



                        $category = $row_data[2];



                        $model = $row_data[3];



                        $model_num = $row_data[4];



                        $brand = $model;



                        if (!empty($model_num))
                            $brand = $model . " " . "-" . " " . $model_num;





                        $quantity = $row_data[5];





                        $cost_price = $row_data[6];



                        $sales_price = $row_data[7];



                        $type = 'No';



                        // echo "<pre>";print_r($row_data);exit;
                        // $firm_details = $this->manage_firms_model->getfirm_id_based_on_firm_name($firm_name);

                        $firm_details = $this->getfirm_id_based_on_firm_name($firm_name);



                        if (!empty($firm_details)) {

                            $firm_id = $firm_details[0]['firm_id'];

                            if ($firm_id == 1) {

                                $firm = array('2', '3', '4');
                            } else if ($firm_id == 2) {

                                $firm = array('1', '3', '4');
                            } else if ($firm_id == 3) {

                                $firm = array('1', '2', '4');
                            } else if ($firm_id == 4) {

                                $firm = array('1', '2', '3');
                            }

                            //$frim = array('1', '4', '2');



                            $cat_id = $this->product_model->check_cat_exists($category, $firm_id);



                            if (empty($cat_id)) {



                                $cat_data = array();



                                $cat_data['categoryName'] = $category;



                                $cat_data['firm_id'] = $firm_id;



                                $cat_data['eStatus'] = 1;



                                $user_info = $this->user_auth->get_from_session('user_info');



                                $cat_data['created_by'] = $user_info[0]['id'];



                                $cat_data['createdDate'] = date('Y-m-d H:i:s');



                                $cat_id = $this->product_model->insert_category($cat_data);
                            }





                            $brand_id = $this->product_model->check_brand_exists($cat_id, $firm_id, $brand);



                            if (empty($brand_id)) {



                                $brand_data = array();



                                $brand_data['brands'] = $brand;



                                $brand_data['firm_id'] = $firm_id;

                                $brand_data['cat_id'] = $cat_id;



                                $brand_data['status'] = 1;



                                $user_info = $this->user_auth->get_from_session('user_info');



                                $brand_data['created_by'] = $user_info[0]['id'];



                                $brand_data['created_date'] = date('Y-m-d H:i:s');



                                $brand_id = $this->product_model->insert_brand($brand_data);
                            }



                            //$frim = array('1', '4', '2');



                            if (!empty($cat_id && $brand_id)) {

                                $product_name = str_replace('"', 'inch', $product_name);



                                $pro_id = $this->product_model->check_product_exists($product_name, $firm_id, $cat_id, $brand_id);



                                $product_data = array();



                                $product_data['product_name'] = htmlentities($product_name);





                                $product_data['barcode'] = htmlentities($product_name);



                                $product_data['hsn_sac'] = "0";



                                $product_data['cgst'] = "6.00";



                                $product_data['sgst'] = "6.00";

                                $product_data['igst'] = "6.00";



                                $product_data['firm_id'] = $firm_id;



                                $product_data['category_id'] = $cat_id;



                                $product_data['brand_id'] = $brand_id;



                                $product_data['status'] = ($status == 'Active') ? 1 : 0;



                                $product_data['type'] = ($type == 'No') ? 'product' : 'others';



                                $product_data['cost_price'] = $cost_price;

                                $product_data['sales_price'] = $sales_price;
                                $cp_without_gst = '0.0';
                                if ($cost_price) {
                                    $cgst = $product_data['cgst'];
                                    $sgst = $product_data['sgst'];
                                    $cp_with_gst = $cost_price * (($cgst + $sgst) / 100);
                                    $cp_without_gst = $cost_price - $cp_with_gst;
                                }
                                $sp_without_gst = '0.0';
                                if ($sales_price) {
                                    $cgst = $product_data['cgst'];
                                    $sgst = $product_data['sgst'];
                                    $sp_with_gst = $sales_price * (($cgst + $sgst) / 100);
                                    $sp_without_gst = $sales_price - $sp_with_gst;
                                }
                                $product_data['cost_price_without_gst'] = $cp_without_gst;

                                $product_data['sales_price_without_gst'] = $sp_without_gst;



                                $product_data['unit'] = 0;



                                $product_data['qty'] = $quantity;





                                // echo "<pre>";print_r($product_data);



                                if (empty($pro_id)) {

                                    $product_data['created_date'] = date('Y-m-d');

                                    $pro_id = $this->product_model->insert_product($product_data);

                                    $this->stock_details($product_data, $pro_id);
                                } else {

                                    $product_data['created_date'] = date('Y-m-d');

                                    $this->product_model->update_product($product_data, $pro_id);

                                    $this->stock_details($product_data, $pro_id);
                                }



                                $is_success = 1;



                                $this->db->close();



                                $this->db->initialize();
                            }



                            if ($count == 1000) {



                                break;
                            }



                            $count++;
                        }
                    }
                }
            }



            if ($is_success) {



                redirect($this->config->item('base_url') . 'masters/products');
            }
        }
    }

    function getfirm_id_based_on_firm_name($name)
    {



        $this->db->select('*');



        $this->db->where('firm_name', trim($name));



        $this->db->where('status', 1);



        $query = $this->db->get('erp_manage_firms')->result_array();



        return $query;
    }

    function stock_details($product_data, $pro_id)
    {

        $stock = array();

        $stock['category'] = $product_data['category_id'];

        $stock['firm_id'] = $product_data['firm_id'];

        $stock['brand'] = $product_data['brand_id'];

        $stock['product_id'] = $pro_id;

        $stock['quantity'] = $product_data['qty'];



        if ($product_data['category_id'] != "")
            $this->product_model->check_stock($stock);
    }

    function ajaxList()
    {

        $list = $this->product_model->get_datatables();

        $data = array();

        $no = $_POST['start'];

        foreach ($list as $ass) {

            //  $edit_access = ($edit_access == 0) ? 'blocked_access' : '';
            // $delete_access = ($delete_access == 0) ? 'blocked_access' : '';

            if ($this->user_auth->is_action_allowed('masters', 'products', 'edit')) {

                $edit_row = '<a class="tooltips  btn btn-default btn-xs" href="' . base_url() . 'masters/products/edit_product/' . $ass->id . '"><i class="fa fa-edit"></i></a>';
            } else {

                $edit_row = '<a class="tooltips  btn btn-default btn-xs" href=""><i class="fa fa-edit alerts"></i></a>';
            }

            if ($this->user_auth->is_action_allowed('masters', 'products', 'delete')) {

                $delete_row = '<a onclick="check(' . $ass->id . ')" pro_name= "' . $ass->product_name . '" class="tooltips btn btn-default btn-xs delete_row" delete_id="test3_' . $ass->id . '" data-toggle="modal" name="delete" title="In-Active" id="delete_' . $ass->id . '"><i class="fa fa-ban"></i></a>';
            } else {

                $delete_row = '<a  class="tooltips btn btn-default btn-xs delete_row alerts" pro_id ="' . $ass->id . '" delete_id="test3_' . $ass->id . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><i class="fa fa-ban"></i></a>';
            }

            $barcode = '<a data-toggle="modal" class="tooltips btn btn-default btn-xs export_barcode"  product_id="' . $ass->id . '"  barcode_id="' . html_entity_decode($ass->barcode) . '"   product_name="' . $ass->product_name . '"><i class="fa fa-barcode"></i></a>';

            if (!empty($ass->product_image)) {

                $file = FCPATH . 'attachement/product/' . $ass->product_image;

                $exists = file_exists($file);
            }

            $cust_image = (!empty($exists) && isset($exists)) ? $ass->product_image : "no-img.gif";

            $img = '<img id="blah" class="add_staff_thumbnail" width="50px" height="50px" src="' . base_url() . 'attachement/product/' . $cust_image . '"/>';

            $no++;

            $row = array();

            $row[] = $no;

            $row[] = $ass->firm_name;

            $row[] = $ass->product_name;

            $row[] = $ass->categoryName;

            $row[] = $ass->brandName;

            //$row[] = $ass->type;
            //$row[] = $ass->qty;

            $row[] = $ass->cost_price;

            $row[] = $ass->sales_price;

            $row[] = $edit_row . '&nbsp;&nbsp;' . $delete_row . '&nbsp;&nbsp;' . $barcode;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->product_model->count_all(),
            "recordsFiltered" => $this->product_model->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);

        exit;
    }

    function get_category_by_frim_id()
    {

        $input = $this->input->post();

        $arr = $this->product_model->get_category_by_frim_id($input['firm_id']);

        echo json_encode($arr);

        exit;
    }

    function get_brand_by_frim_id()
    {

        $input = $this->input->post();

        $arr = $this->product_model->get_brand_by_frim_id($input['firm_id']);

        echo json_encode($arr);

        exit;
    }

    public function generate_barcode($code)
    {

        $this->load->library('zend');

        $this->zend->load('Zend/Barcode');

        return Zend_Barcode::render('code128', 'image', array('text' => $code), array('imageType' => 'png'));
    }

    function save_barcode()
    {

        $this->load->library('zend');

        $this->zend->load('Zend/Barcode');

        $barcode = $this->input->post('barcode');

        $file = Zend_Barcode::draw('code128', 'image', array('text' => $barcode), array());



        $store_image = imagepng($file, FCPATH . 'attachement/barcode/' . $barcode . '.png');





        echo $barcode . '.png';
    }

    public function check_product()
    {

        $input = $this->input->post();

        print_r($input);
    }

    public function barcode_pdf()
    {

        $this->load->library('zend');

        $this->zend->load('Zend/Barcode');

        $barcode_id = trim($this->input->post('barcode_id'));



        $barcode_id = str_replace(" ", "", $barcode_id);

        $barcode_id = str_replace("-", "", $barcode_id);



        $product_id = $this->input->post('product_id');



        $product_name = $this->input->post('product_name');



        $product_details = $this->product_model->get_product_by_id($product_id);



        $barcode_type = $this->input->post('barcode_type');



        $count = $this->input->post('count');

        $data['report_title'] = 'Barcode for products';



        $result_ime_codes = "";



        if ($barcode_type == 2) {

            $result_ime_codes = $this->product_model->get_ime_codes($count, $product_id);
        }



        // $data['barcode'] = $this->product_model->get_barcode_by_limit($limit);
        //  }



        $img = FCPATH . 'attachement/barcode/' . $barcode_id . '.png';

        chmod("/somedir/somefile", 0777);

        chmod($img, 0777);



        $this->load->library("Pdf");

        $header = $this->load->view('quotation/pdf_header_view', $data, TRUE);

        // $msg = $this->load->view('masters/barcode_pdf', $data, TRUE);

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->AddPage();

        $pdf->SetTitle('barcode');

        $pdf->Header($header);

        $toolcopy = '<html><body><br>';

        $x = 1;





        if (!empty($result_ime_codes)) {

            foreach ($result_ime_codes as $key => $results) {





                $file = Zend_Barcode::draw('code128', 'image', array('text' => $results['ime_code']));



                $store_image = imagepng($file, FCPATH . 'attachement/barcode/' . $results['ime_code'] . '.png');







                $img = 'attachement/barcode/' . $results['ime_code'] . '.png';



                $toolcopy .= '<img src="' . $img . '"  width="100" height="50" >';
            }
        }



        if ($barcode_type == 1) {



            $barcode_return = trim($this->input->post('barcode_id'));



            // foreach ($data['barcode'] as $ass) {

            $file = Zend_Barcode::draw('code128', 'image', array('text' => $barcode_return), array());



            $store_image = imagepng($file, FCPATH . 'attachement/barcode/' . $barcode_id . '.png');





            while ($x <= $count) {



                $img = 'attachement/barcode/' . $barcode_id . '.png';

                $toolcopy .= '<img src="' . $img . '"  width="100" height="50" >';



                $x++;
            }
        }



        $toolcopy .= '</body></html>';

        $pdf->writeHTML($toolcopy, true, 0, true, 0);

        // $pdf->writeHTMLCell(0, 0, '', '', $toolcopy, 0, 1, 0, true, '', true);

        $filename = 'barcode-' . date('d-M-Y-H-i-s') . '.pdf';



        // echo $filename;exit;

        $newFile = $this->config->item('theme_path') . 'attachement/' . $filename;

        $pdf->Output($newFile);
    }

    function clear_cache()
    {

        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");

        $this->output->set_header("Pragma: no-cache");
    }

    public function excel_report()
    {



        $products = $this->product_model->get_all_products_to_export();



        $this->export_csv($products);
    }

    function export_csv($query, $timezones = array())
    {



        // output headers so that the file is downloaded rather than displayed

        header('Content-Type: text/csv; charset=utf-8');

        header('Content-Disposition: attachment; filename=Product_report.csv');



        // create a file pointer connected to the output stream

        $output = fopen('php://output', 'w');



        // output the column headings
        //Order has been changes

        fputcsv($output, array('Product Name', 'Firm Name', 'Category', 'Brand Name', 'Model Number', 'Unit', 'Stock', 'Min Quantity', 'Cost Price', 'T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'H1', 'H2', 'HSN/SAC', 'IGST', 'CGST', 'SGST'));



        // fetch the data
        //$rows = mysql_query($query);
        // loop over the rows, outputting them

        foreach ($query as $val) {

            $row = array($val['product_name'], $val['firm_name'], $val['categoryName'], $val['brands'], $val['model_no'], $val['unit'], '', $val['min_qty'], $val['cost_price'], $val['cash_cus_price'], $val['credit_cus_price'], $val['cash_con_price'], $val['credit_con_price'], $val['vip_price'], $val['vvip_price'], $val['h1_price'], $val['h2_price'], $val['hsn_sac'], $val['igst'], $val['cgst'], $val['sgst']);

            fputcsv($output, $row);
        }

        exit;
    }

    /*   function import_products() {



      if ($this->input->post()) {







      $skip_rows = $this->input->post('skip_rows');

      //            $skip_rows = 1;

      $is_success = 0;



      if (!empty($_FILES['product_data'])) {



      $config['upload_path'] = './attachement/csv/';



      $config['allowed_types'] = '*';



      $config['max_size'] = '10000';



      $this->load->library('upload', $config);



      $random_hash = substr(str_shuffle(time()), 0, 3) . strrev(mt_rand(100000, 999999));



      $extension = pathinfo($_FILES['product_data']['name'], PATHINFO_EXTENSION);



      $new_file_name = 'product_' . $random_hash . '.' . $extension;



      $_FILES['product_data'] = array(

      'name' => $new_file_name,

      'type' => $_FILES['product_data']['type'],

      'tmp_name' => $_FILES['product_data']['tmp_name'],

      'error' => $_FILES['product_data']['error'],

      'size' => $_FILES['product_data']['size']

      );



      $config['file_name'] = $new_file_name;



      $this->upload->initialize($config);



      $this->upload->do_upload('product_data');



      $upload_data = $this->upload->data();



      $file_name = $upload_data['file_name'];



      $file = base_url() . 'attachement/csv/' . $file_name;



      $handle = fopen($file, 'r');



      if ($file != NULL && $skip_rows > 0) {



      $skipLines = $skip_rows;



      $lineNum = 1;



      if ($skipLines > 0) {



      while (fgetcsv($handle)) {



      if ($lineNum == $skipLines) {



      break;

      }



      $lineNum++;

      }

      }

      }



      $count = 1;

      if ($file != NULL) {

      while ($row_data = fgetcsv($handle)) {



      $product_name = $row_data[0];

      $firm_name = $row_data[1];



      $status = 'Active';



      $category = $row_data[2];



      $brand = $row_data[3];



      $model = $row_data[4];



      $unit = $row_data[5];



      $qty = $row_data[6];



      $min_qty = $row_data[7];



      $cost_price = $row_data[8];



      $cash_cus_price = $row_data[9];



      $credit_cus_price = $row_data[10];



      $cash_con_price = $row_data[11];



      $credit_con_price = $row_data[12];



      $vip_price = $row_data[13];



      $vvip_price = $row_data[14];



      $h1_price = $row_data[15];



      $h2_price = $row_data[16];



      $type = 'No';



      $is_non_gst = 'No';



      $hsn_sac = $row_data[17];



      $igst = $row_data[18];



      $cgst = $row_data[19];



      $sgst = $row_data[20];



      // $firm_details = $this->manage_firms_model->getfirm_id_based_on_firm_name($firm_name);

      $firm_details=$this->getfirm_id_based_on_firm_name($firm_name);



      if (!empty($firm_details)) {

      $firm_id = $firm_details[0]['firm_id'];

      if ($firm_id == 1) {

      $firm = array('2', '3', '4');

      } else if ($firm_id == 2) {

      $firm = array('1', '3', '4');

      } else if ($firm_id == 3) {

      $firm = array('1', '2', '4');

      } else if ($firm_id == 4) {

      $firm = array('1', '2', '3');

      }

      //$frim = array('1', '4', '2');



      $cat_id = $this->product_model->is_category_name_exist($category, $firm, $firm_id);



      $brand_id = $this->product_model->is_brand_name_exist($brand, $firm, $firm_id);

      //echo 'cat-' . $cat_id . '<br>';

      //echo 'pro-' . $brand_id . '<br>';



      if (empty($cat_id)) {



      $cat_data = array();



      $cat_data['categoryName'] = $category;



      $cat_data['firm_id'] = $firm_id;



      $cat_data['eStatus'] = 1;



      $user_info = $this->user_auth->get_from_session('user_info');



      $cat_data['created_by'] = $user_info[0]['id'];



      $cat_data['createdDate'] = date('Y-m-d H:i:s');



      $cat_id = $this->product_model->insert_category($cat_data);

      }



      if (empty($brand_id)) {



      $brand_data = array();



      $brand_data['brands'] = $brand;



      $brand_data['firm_id'] = $firm_id;



      $brand_data['status'] = 1;



      $user_info = $this->user_auth->get_from_session('user_info');



      $brand_data['created_by'] = $user_info[0]['id'];



      $brand_data['created_date'] = date('Y-m-d H:i:s');



      $brand_id = $this->product_model->insert_brand($brand_data);

      }



      //$frim = array('1', '4', '2');



      if (!empty($cat_id)) {

      $product_name = str_replace('"', 'inch', $product_name);

      $pro_id = $this->product_model->is_product_name_exist($product_name, $cat_id, $firm, $firm_id);



      $product_data = array();



      $product_data['category_id'] = $cat_id;



      $product_data['firm_id'] = $firm_id;



      $product_data['brand_id'] = $brand_id;



      $product_data['product_name'] = $product_name;



      $product_data['qty'] = $qty;



      $product_data['min_qty'] = $min_qty;



      $product_data['status'] = ($status == 'Active') ? 1 : 0;



      $product_data['type'] = ($type == 'No') ? 'product' : 'others';



      $product_data['cost_price'] = $cost_price;



      $product_data['cash_cus_price'] = $cash_cus_price;



      $product_data['credit_cus_price'] = $credit_cus_price;



      $product_data['cash_con_price'] = $cash_con_price;



      $product_data['credit_con_price'] = $credit_con_price;



      $product_data['vip_price'] = $vip_price;



      $product_data['vvip_price'] = $vvip_price;



      $product_data['h1_price'] = $h1_price;



      $product_data['h2_price'] = $h2_price;



      $product_data['unit'] = $unit;



      $product_data['is_non_gst'] = ($is_non_gst == 'No') ? 1 : 0;



      $product_data['hsn_sac'] = $hsn_sac;



      $product_data['igst'] = str_replace('%', '', $igst);



      $product_data['cgst'] = str_replace('%', '', $cgst);



      $product_data['sgst'] = str_replace('%', '', $sgst);

      if (empty($pro_id)) {

      $product_data['created_date'] = date('Y-m-d');

      $pro_id = $this->product_model->insert_product($product_data);



      $this->stock_details($product_data, $pro_id);

      } else {

      $product_data['created_date'] = date('Y-m-d');

      $this->product_model->update_product($product_data, $pro_id);



      $this->stock_details($product_data, $pro_id);

      }



      $is_success = 1;



      $this->db->close();



      $this->db->initialize();

      }



      if ($count == 1000) {



      break;

      }



      $count++;

      }

      }

      }

      }



      if ($is_success) {



      redirect($this->config->item('base_url') . 'masters/products');

      }

      }

      } */
}
