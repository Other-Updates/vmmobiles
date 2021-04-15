<?php







if (!defined('BASEPATH'))



    exit('No direct script access allowed');







class Suppliers extends MX_Controller
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



            'suppliers/index' => array('add', 'edit', 'delete', 'view'),



            'suppliers/insert_vendor' => array('add'),



            'suppliers/edit_vendor' => array('edit'),



            'suppliers/update_vendor' => array('edit'),



            'suppliers/delete_vendor' => array('delete'),



            'suppliers/add_duplicate_mail' => array('add', 'edit'),



            'suppliers/update_duplicate_mail' => array('add', 'edit'),



            'suppliers/excel' => 'no_restriction',



            'suppliers/pdf' => 'no_restriction',



            'suppliers/ajaxList' => 'no_restriction',



            'suppliers/add_duplicate_land' => 'no_restriction',



            'suppliers/update_duplicate_land' => 'no_restriction',



            'suppliers/import_suppliers' => 'no_restriction'



        );







        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {



            redirect($this->config->item('base_url'));
        }



        $this->load->model('masters/user_model');



        $this->load->model('masters/supplier_model');
    }







    public function index()
    {



        $this->load->model('masters/supplier_model');



        $data["vendor"] = $this->supplier_model->get_vendor();



        $data['all_state'] = $this->supplier_model->state();



        $data['firms'] = $firms = $this->user_auth->get_user_firms();



        $this->template->write_view('content', 'masters/supplier', $data);



        $this->template->render();
    }







    public function insert_vendor()
    {



        $this->load->model('masters/supplier_model');



        $input_data = array(



            'name' => $this->input->post('name'),



            'store_name' => $this->input->post('store'),



            'address1' => $this->input->post('address1'),



            'address2' => $this->input->post('address2'),



            'city' => $this->input->post('city'),



            'pincode' => $this->input->post('pin'),



            'mobil_number' => $this->input->post('number'),



            'landline' => $this->input->post('landline'),



            'email_id' => $this->input->post('mail'),



            //'dob' => $this->input->post('dob'),



            // 'anniversary_date' => $this->input->post('anniversary'),



            'bank_name' => $this->input->POST('bank'),



            'bank_branch' => $this->input->POST('branch'),



            'account_num' => $this->input->POST('acnum'),



            'firm_id' => $this->input->POST('firm_id'),



            'created_by' => $this->user_auth->get_user_id(),



            // 'payment_percent' => $this->input->post('payment'),



            // 'credit_days' => $this->input->post('credit_days'),



            'state_id' => $this->input->post('state_id'),



            'payment_terms' => $this->input->post('payment_terms'),



            'tin' => $this->input->post('tin'),



            'ifsc' => $this->input->post('ifsc')



        );



        // echo "<pre>";print_r($input_data);exit;



        $this->supplier_model->insert_vendor($input_data);



        $data["vendor"] = $this->supplier_model->get_vendor();



        redirect($this->config->item('base_url') . 'masters/suppliers', $data);
    }







    public function edit_vendor($id)
    {



        $this->load->model('masters/supplier_model');



        $data['all_state'] = $this->supplier_model->state();



        $data["vendor"] = $this->supplier_model->get_vendor1($id);



        $data['firms'] = $firms = $this->user_auth->get_user_firms();



        $this->template->write_view('content', 'masters/update_supplier', $data);



        $this->template->render();
    }







    public function update_vendor()
    {



        $this->load->model('masters/supplier_model');



        $data['all_state'] = $this->supplier_model->state();



        $id = $this->input->post('id');



        $data["vendor"] = $this->supplier_model->get_vendor();



        $input = array(
            'name' => $this->input->post('name'), 'store_name' => $this->input->post('store'), 'address1' => $this->input->post('address1'),



            'address2' => $this->input->post('address2'), 'city' => $this->input->post('city'),



            'pincode' => $this->input->post('pin'), 'mobil_number' => $this->input->post('number'), 'email_id' => $this->input->post('mail'),

            //'dob' => $this->input->post('dob'),



            // 'anniversary_date' => $this->input->post('anniversary'), 

            'bank_name' => $this->input->POST('bank'), 'bank_branch' => $this->input->POST('branch'), 'account_num' => $this->input->POST('acnum'), 'firm_id' => $this->input->POST('firm_id'), 'firm_id' => $this->input->POST('firm_id'), 'created_by' => $this->user_auth->get_user_id(),

            //'payment_percent' => $this->input->post('payment'),



            // 'credit_days' => $this->input->post('credit_days'), 

            'state_id' => $this->input->post('state_id'), 'payment_terms' => $this->input->post('payment_terms'), 'tin' => $this->input->post('tin'), 'ifsc' => $this->input->post('ifsc'), 'landline' => $this->input->post('landline')
        );



        $this->supplier_model->update_vendor($input, $id);



        $this->template->write_view('content', 'masters/update_supplier', $data);



        redirect($this->config->item('base_url') . 'masters/suppliers/');
    }







    public function delete_vendor()
    {



        $this->load->model('masters/supplier_model');







        $id = $this->input->POST('value1'); {



            $this->supplier_model->delete_vendor($id);



            $data["vendor"] = $this->supplier_model->get_vendor();



            redirect($this->config->item('base_url') . 'masters/suppliers', $data);
        }
    }







    public function add_duplicate_mail()
    {



        $this->load->model('masters/supplier_model');



        $input = $this->input->get('value1');



        $validation = $this->supplier_model->add_duplicate_mail($input);



        $i = 0;



        if ($validation) {



            $i = 1;
        }
        if ($i == 1) {



            echo "Email Already Exist";
        }
    }







    public function add_duplicate_land()
    {



        $this->load->model('masters/supplier_model');



        $input = $this->input->get('value1');



        $validation = $this->supplier_model->add_duplicate_land($input);



        $i = 0;



        if ($validation) {



            $i = 1;
        }
        if ($i == 1) {



            echo "Number Already Exist";
        }
    }







    public function update_duplicate_mail()
    {



        $this->load->model('masters/supplier_model');



        $input = $this->input->post('value1');



        $id = $this->input->post('value2');



        $validation = $this->supplier_model->update_duplicate_mail($input, $id);



        $i = 0;



        if ($validation) {



            $i = 1;
        }
        if ($i == 1) {



            echo "Email already Exist";
        }
    }







    public function update_duplicate_land()
    {



        $this->load->model('masters/supplier_model');



        $input = $this->input->post('value1');



        $id = $this->input->post('value2');



        $validation = $this->supplier_model->update_duplicate_land($input, $id);



        $i = 0;



        if ($validation) {



            $i = 1;
        }
        if ($i == 1) {



            echo "Number already Exist";
        }
    }







    function ajaxList()
    {



        $list = $this->supplier_model->get_datatables();



        $data = array();



        $no = $_POST['start'];



        foreach ($list as $ass) {



            //  $edit_access = ($edit_access == 0) ? 'blocked_access' : '';



            // $delete_access = ($delete_access == 0) ? 'blocked_access' : '';



            if ($this->user_auth->is_action_allowed('masters', 'suppliers', 'edit')) {



                $edit_row = '<a class="tooltips  btn btn-default btn-xs" href="' . base_url() . 'masters/suppliers/edit_vendor/' . $ass->id . '"><i class="fa fa-edit"></i></a>';
            } else {



                $edit_row = '<a class="tooltips  btn btn-default btn-xs alerts" href=""><i class="fa fa-edit"></i></a>';
            }



            if ($this->user_auth->is_action_allowed('masters', 'suppliers', 'delete')) {



                $delete_row = '<a onclick="check(' . $ass->id . ')" class="tooltips btn btn-default btn-xs delete_row" delete_id="test3_' . $ass->id . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><i class="fa fa-ban"></i></a>';
            } else {



                $delete_row = '<a  class="tooltips btn btn-default btn-xs delete_row alerts" delete_id="test3_' . $ass->id . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><i class="fa fa-ban"></i></a>';
            }



            $no++;



            $row = array();



            $row[] = $no;



            $row[] = $ass->firm_name;



            $row[] = $ass->store_name;



            $row[] = $ass->email_id;



            $row[] = $ass->mobil_number;





            $row[] = $ass->city;



            $row[] = $ass->tin;



            $row[] = $edit_row . '&nbsp;&nbsp;' . $delete_row;



            $data[] = $row;
        }



        $output = array(



            "draw" => $_POST['draw'],



            "recordsTotal" => $this->supplier_model->count_all(),



            "recordsFiltered" => $this->supplier_model->count_filtered(),



            "data" => $data,



        );



        echo json_encode($output);



        exit;
    }







    function import_suppliers()
    {



        $this->load->model('manage_firms/manage_firms_model');







        if ($this->input->post()) {



            $is_success = 0;



            if (!empty($_FILES['supplier_data'])) {



                $config['upload_path'] = './attachement/csv/';



                $config['allowed_types'] = '*';



                $config['max_size'] = '10000';



                $this->load->library('upload', $config);



                $random_hash = substr(str_shuffle(time()), 0, 3) . strrev(mt_rand(100000, 999999));



                $extension = pathinfo($_FILES['supplier_data']['name'], PATHINFO_EXTENSION);



                $new_file_name = 'customer_' . $random_hash . '.' . $extension;



                $_FILES['supplier_data'] = array(



                    'name' => $new_file_name,



                    'type' => $_FILES['supplier_data']['type'],



                    'tmp_name' => $_FILES['supplier_data']['tmp_name'],



                    'error' => $_FILES['supplier_data']['error'],



                    'size' => $_FILES['supplier_data']['size']



                );



                $config['file_name'] = $new_file_name;



                $this->upload->initialize($config);







                $this->upload->do_upload('supplier_data');



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





                        $firm_name = $row_data[1];



                        $store_name = $row_data[0];











                        $status = 'Active';



                        // $short_name = $row_data[2];



                        $short_name = '';



                        // $credit_days = $row_data[3];



                        $credit_days = "";



                        $email = $row_data[2];



                        //$landline = $row_data[6];



                        $landline = '';



                        // $mobile = $row_data[7];



                        $mobile = $row_data[3];



                        //$state = $row_data[8];



                        $state = '';



                        //$address1 = $row_data[9];

                        $address1 = $row_data[4];



                        // $tin = $row_data[10];

                        /*$tin = $row_data[5];



                        $bank = $row_data[11];



                        $ifsc = $row_data[12];



                        $payment_terms = $row_data[13];



                        $account_num = $row_data[14];



                        $bank_branch = $row_data[15];*/

                        $tin = '';



                        $bank = '';



                        $tin = $row_data[5];



                        $ifsc = '';



                        $payment_terms = '';



                        $account_num = '';



                        $bank_branch = '';



                        if (strtolower($state) == 'tamilnadu') {



                            $state = 'Tamil nadu';
                        }



                        if ($state)

                            $state_id = $this->supplier_model->get_state_id($state);

                        else

                            $state_id = '';







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





                            if ($store_name != '' && $store_name != ',') {







                                //$frim = array('4', '3', '2');



                                $sup_id = $this->supplier_model->is_supplier_name_exist($store_name, $firm);



                                //echo $sup_id;



                                $input_data = array(



                                    'name' => $store_name,



                                    'store_name' => $store_name,



                                    'address1' => $address1,



                                    'mobil_number' => $mobile,



                                    'landline' => $landline,



                                    'email_id' => $email,



                                    'bank_name' => $bank,



                                    'bank_branch' => $bank_branch,



                                    'account_num' => $account_num,



                                    'firm_id' => $firm_id,



                                    'created_by' => $this->user_auth->get_user_id(),



                                    'credit_days' => $credit_days,



                                    'state_id' => ($state_id) ? $state_id : 31,



                                    'payment_terms' => $payment_terms,



                                    'tin' => $tin,



                                    'ifsc' => $ifsc,



                                    'created_date' => date('Y-m-d H:i:s'),



                                );





                                if (empty($sup_id)) {







                                    $this->supplier_model->insert_vendor($input_data);
                                } else {







                                    $this->supplier_model->update_vendor($input_data, $sup_id);
                                }
                            }
                        }
                    }
                }



                $is_success = 1;
            }



            if ($is_success) {



                redirect($this->config->item('base_url') . 'masters/suppliers');
            }
        }
    }







    function clear_cache()
    {



        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");



        $this->output->set_header("Pragma: no-cache");
    }
}
