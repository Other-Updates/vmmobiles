<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Brands extends MX_Controller {



    function __construct() {

        parent::__construct();

        $this->clear_cache();

        if (!$this->user_auth->is_logged_in()) {

            redirect($this->config->item('base_url') . 'admin');

        }

        $main_module = 'masters';

        $access_arr = array(

            'brands/index' => array('add', 'edit', 'delete', 'view'),

            'brands/insert_brand' => array('add'),

            'brands/update_brand' => array('edit'),

            'brands/delete_master_brand' => array('delete'),

            'brands/add_duplicate_brandname' => array('add', 'edit'),

            'brands/update_duplicate_brandname' => array('add', 'edit'),

            'brands/update_duplicatebrandname' => array('add', 'edit'),

            'brands/brand_ajaxList' => 'no_restriction',

            'brands/get_duplicate' => 'no_restriction',

            'brands/import_brands' => 'no_restriction'

        );



        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {

            redirect($this->config->item('base_url'));

        }

        $this->load->model('masters/brand_model');
         $this->load->model('masters/categories_model');

    }



    public function get_duplicate() {



        $data = $this->brand_model->get_brand_duplicate();

        echo "<pre>";

        print_r($data);

        exit;

    }



    public function index() {
       /* $this->db->select('brand_id,category_id,product_name,firm_id');
        $this->db->where('brand_id >','79');
        $this->db->order_by('brand_id','asc');
         $this->db->group_by('brand_id');
        $get_products=$this->db->get('erp_product')->result_array();

        foreach($get_products as $data){
            $explode_brand=explode('-',$data['product_name']);
            $insert_data=[
                "id"=>$data['brand_id'],
                "brands"=>$explode_brand[1],
                "status"=>1,
                "created_by"=>1,
                "firm_id"=>$data['firm_id'],
                "cat_id"=>$data['category_id'],
            ];
           echo "<pre>";
         echo 1;
            $this->db->insert('erp_brand',$insert_data);
        }*/
           // echo "<pre>";
           //print_r($get_products);
      
        $data["brand"] = $this->brand_model->get_brand();

        $data["category"] = $this->categories_model->get_all_category();
        $data["cat"]="";

        $data['firms'] = $firms = $this->user_auth->get_user_firms();

    //  echo "<pre>";print_r($data);exit;

        $this->template->write_view('content', 'masters/brands', $data);
        //$this->template->write_view('content', 'masters/brand_modal', $data);

        $this->template->render();

    }



    public function insert_brand() {

        $input = array('brands' => $this->input->post('brands'),'cat_id' => $this->input->post('cat_id'), 'created_by' => $this->user_auth->get_user_id(), 'firm_id' => $this->input->POST('firm_id'));

        $this->brand_model->insert_brand($input);

        $data["brand"] = $this->brand_model->get_brand();

        redirect($this->config->item('base_url') . 'masters/brands', $data);

    }



    public function update_brand() {

        $id = $this->input->post('value1');

        $input = array('brands' => $this->input->post('value2'),'cat_id' => $this->input->post('cat_id'), 'created_by' => $this->user_auth->get_user_id(), 'firm_id' => $this->input->POST('firm'));

        $this->brand_model->update_brand($input, $id);

        $data["brand"] = $this->brand_model->get_brand();

        redirect($this->config->item('base_url') . 'masters/brands');

    }



    public function delete_master_brand() {

        $id = $this->input->get('value1'); {

            $this->brand_model->delete_master_brand($id);

            $data["brand"] = $this->brand_model->get_brand();

            redirect($this->config->item('base_url') . 'masters/brands');

        }

    }


     function import_brands() {

        $this->load->model('manage_firms/manage_firms_model');



        if ($this->input->post()) {

            $is_success = 0;

            if (!empty($_FILES['brand_data'])) {

                $config['upload_path'] = './attachement/csv/';

                $config['allowed_types'] = '*';

                $config['max_size'] = '10000';

                $this->load->library('upload', $config);

                $random_hash = substr(str_shuffle(time()), 0, 3) . strrev(mt_rand(100000, 999999));

                $extension = pathinfo($_FILES['brand_data']['name'], PATHINFO_EXTENSION);

                $new_file_name = 'customer_' . $random_hash . '.' . $extension;

                $_FILES['brand_data'] = array(

                    'name' => $new_file_name,

                    'type' => $_FILES['brand_data']['type'],

                    'tmp_name' => $_FILES['brand_data']['tmp_name'],

                    'error' => $_FILES['brand_data']['error'],

                    'size' => $_FILES['brand_data']['size']

                );

                $config['file_name'] = $new_file_name;

                $this->upload->initialize($config);



                $this->upload->do_upload('brand_data');

                $upload_data = $this->upload->data();

                $file_name = $upload_data['file_name'];

                $file = base_url() . 'attachement/csv/' . $file_name;

                $handle = fopen($file, 'r');

                $skip_rows = 1;

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

        
                if ($file != NULL) {

                    while ($row_data = fgetcsv($handle)) {


                        $firm_name = $row_data[0];

                        $category = $row_data[1];

                        $model = $row_data[2];

                        $model_number = $row_data[3];

                        $model_name=$model;

                     	if(!empty($model_number))
                        	$model_name=$model." "."-".$model_number;
                        

                        $status = '1';

                      

                       
                        $firm_details = $this->manage_firms_model->getfirm_id_based_on_firm_name($firm_name);



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


                             $cat_id=$this->brand_model->get_category_id($category,$firm_id);


                            if ($model_name != '' && $model_name != ',' && $cat_id!=0) {



                          //$frim = array('4', '3', '2');

                                $brand_id = $this->brand_model->is_brand_name_exist($model_name, $firm,$cat_id);

                                //echo $sup_id;

                                   $input_data = array(

                                        'brands' => $model_name,
                                         
                                        'firm_id' => $firm_id,

                                        'cat_id' => $cat_id,

                                        'status	' => $status,

                                        'created_by' => 1,

                                        'created_date' => date('Y-m-d H:i:s'),

                                    );


                                if (empty($brand_id)) {

                                 

                                    $this->brand_model->insert_brand($input_data);

                                } else {



                                    $this->brand_model->update_brand($input_data, $brand_id);

                                }

                            }

                        }

                    }

                }

                $is_success = 1;

            }

            if ($is_success) {

                redirect($this->config->item('base_url') . 'masters/brands');

            }

        }

    }


    public function add_duplicate_brandname() {



        $input = $this->input->post();

        $validation = $this->brand_model->add_duplicate_brandname($input);

        $i = 0;

        if ($validation) {

            $i = 1;

        }if ($i == 1) {

            echo"Brand Name Already Exist";

        }

    }



    public function update_duplicate_brandname() {



        $input = $this->input->get('value1');

        $id = $this->input->get('value2');

        

        $validation = $this->brand_model->update_duplicate_brandname($input, $id);



        $i = 0;

        if ($validation) {

            $i = 1;

        }if ($i == 1) {

            echo "Brand Name Already Exist";

        }

    }


    public function update_duplicatebrandname() {
        $input = $this->input->POST('value1');

        $id = $this->input->POST('value2');

         $cat_id = $this->input->POST('value3');

         $firm = $this->input->POST('value4');

        $validation = $this->brand_model->update_duplicatebrandname($input, $id,$cat_id,$firm);



        $i = 0;

        if ($validation) {

            $i = 1;

        }
        if ($i == 1) {

            echo "Brand Name Already Exist";

        }else{
            echo 0;
        }

    }



    function clear_cache() {

        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");

        $this->output->set_header("Pragma: no-cache");

    }



    public function brand_ajaxList() {



        $list = $this->brand_model->get_datatables();

        //  echo "<pre>";print_r($list);exit;

        $data = array();

        $no = $_POST['start'];

        foreach ($list as $ass) {

            //  $edit_access = ($edit_access == 0) ? 'blocked_access' : '';

            // $delete_access = ($delete_access == 0) ? 'blocked_access' : '';



            $no++;

            $row = array();

            $row[] = $no;

            $row[] = $ass->firm_name;

             $row[] = $ass->cat_name;

            $row[] = $ass->brands;

            // $row[] = $edit_row . '&nbsp;&nbsp;' . $delete_row .

            if ($this->user_auth->is_action_allowed('masters', 'brands', 'edit')) {

                $rows = '<a href="#" data-toggle="modal" id="edit" model_id="'.$ass->id.'" firm_id="'.$ass->firm_id.'" cat_id="'.$ass->cat_id.'" model_name="'.$ass->brands.'" class="tooltips btn btn-default btn-xs" title="" ><span class="fa fa-log-out "> <span class="fa fa-edit" ></span></span></a>&nbsp;';

            } else {

                $rows = '<a href="#" data-toggle="tooltip" class="tooltips btn btn-default btn-xs alerts" title="" ><span class="fa fa-log-out "> <span class="fa fa-edit"></span></span></a>';

            }

            if ($this->user_auth->is_action_allowed('masters', 'brands', 'delete')) {

                $row[] = $rows . '<a href="#test3_' . $ass->id . '"  data-toggle="modal" id="delete_yes" name="delete" class="tooltips btn btn-default btn-xs" ><span class="fa fa-log-out"> <span class="fa fa-ban " hidin="' . $ass->id . '"></span>  </span></a>';

            } else {

                $row[] = $rows . '<a href="#" data-toggle="tooltip" class="tooltips btn btn-default btn-xs alerts" title="" ><span class="fa fa-log-out "> <span class="fa fa-ban"></span> </span></a>';

            }

            $data[] = $row;

        }

        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->brand_model->count_all(),

            "recordsFiltered" => $this->brand_model->count_filtered(),

            "data" => $data,

        );

        echo json_encode($output);

        exit;

    }



}

