<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Users extends MX_Controller
{



    function __construct()
    {



        parent::__construct();



        if (!$this->user_auth->is_logged_in()) {



            redirect($this->config->item('base_url') . 'admin');
        }



        $main_module = 'masters';



        $access_arr = array(

            'users/index' => array('add', 'edit', 'delete', 'view'),

            'users/insert_user' => array('add'),

            'users/edit_user' => array('edit'),

            'users/update_user' => array('edit'),

            'users/delete_user' => array('delete'),

            'users/add_duplicate_email' => array('add', 'edit'),

            'users/update_duplicate_email' => array('add', 'edit'),

            'users/add_duplicate_user' => array('add', 'edit'),

            'users/update_duplicate_user' => array('add', 'edit'),

            'users/users_ajaxList' => 'no_restriction',

        );







        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {



            redirect($this->config->item('base_url'));
        }



        $this->load->model('masters/user_model');
    }



    public function index()
    {







        $this->load->model('masters/user_model');











        $data["agent"] = $agent = $this->user_model->get_user();



        $data['all_state'] = $this->user_model->state();



        $data['user'] = $user = $this->user_model->get_user_role();



        $data['firms'] = $firms = $this->user_model->get_active_firms();



        //        echo "<pre>";

        //        print_r($data["agent"]);

        //        exit;



        $this->template->write_view('content', 'masters/user', $data);



        $this->template->render();
    }



    public function insert_user()
    {



        $this->load->model('masters/user_model');



        //exit;



        if ($this->input->post()) {



            $this->load->helper('text');







            $config['upload_path'] = './attachement/sign';







            $config['allowed_types'] = '*';







            $config['max_size'] = '2000';







            $this->load->library('upload', $config);







            $upload_data['file_name'] = $_FILES;



            if (isset($_FILES) && !empty($_FILES)) {



                $upload_files = $_FILES;



                if ($upload_files['signature'] != '') {



                    $_FILES['signature'] = array(

                        'name' => $upload_files['signature']['name'],

                        'type' => $upload_files['signature']['type'],

                        'tmp_name' => $upload_files['signature']['tmp_name'],

                        'error' => $upload_files['signature']['error'],

                        'size' => '2000'

                    );



                    $this->upload->do_upload('signature');







                    $upload_data = $this->upload->data();







                    $dest = getcwd() . "/attachement/sign/" . $upload_data['file_name'];







                    $src = $this->config->item("base_url") . 'attachement/sign/' . $upload_data['file_name'];
                }
            }



            $input_data['signature'] = $upload_data['file_name'];



            $input_data = array(
                'name' => $this->input->post('name'), 'address' => $this->input->post('address1'), 'nick_name' => $this->input->post('nick_name'),

                'mobile_no' => $this->input->post('number'), 'email_id' => $this->input->post('mail'),

                'password' => md5($this->input->POST('pass')), 'username' => $this->input->POST('user_name'), 'role' => $this->input->POST('role'), 'signature' => $upload_data['file_name']
            );



            //echo "<pre>";print_r($input_data);exit;



            $id = $this->user_model->insert_user($input_data);



            $firm_id = array();



            $firm_id = $this->input->POST('firm_id');



            if (isset($firm_id) && !empty($firm_id)) {



                $i = 0;



                foreach ($firm_id as $firm) {



                    $firm_input = array('user_id' => $id, 'firm_id' => $firm);



                    $this->user_model->insert_firm($firm_input);
                }
            }



            $data["agent"] = $this->user_model->get_user();



            redirect($this->config->item('base_url') . 'masters/users', $data);
        }
    }



    public function edit_user($id)
    {



        $this->load->model('masters/user_model');



        $data['all_state'] = $this->user_model->state();



        $data['user'] = $user = $this->user_model->get_user_role();



        $data["agent"] = $this->user_model->get_user1($id);



        $data['firms'] = $firms = $this->user_model->get_active_firms();



        $this->template->write_view('content', 'masters/update_user', $data);



        $this->template->render();
    }



    public function update_user()
    {



        $this->load->model('masters/user_model');



        $id = $this->input->POST('id');



        if ($this->input->post()) {



            $this->load->helper('text');







            $config['upload_path'] = './attachement/sign';







            $config['allowed_types'] = '*';







            $config['max_size'] = '2000';







            $this->load->library('upload', $config);











            $input_data = array(
                'name' => $this->input->post('name'), 'address' => $this->input->post('address1'), 'nick_name' => $this->input->post('nick_name'),

                'mobile_no' => $this->input->post('number'), 'email_id' => $this->input->post('mail'), 'username' => $this->input->POST('username'), 'role' => $this->input->POST('role')
            );







            $pass = $this->input->POST('pass');



            if (isset($pass) && !empty($pass))

                $input_data['password'] = md5($pass);







            $upload_data['file_name'] = $_FILES;



            if (isset($_FILES) && !empty($_FILES)) {



                $upload_files = $_FILES;



                if ($upload_files['signature']['name'] != '') {



                    $_FILES['signature'] = array(

                        'name' => $upload_files['signature']['name'],

                        'type' => $upload_files['signature']['type'],

                        'tmp_name' => $upload_files['signature']['tmp_name'],

                        'error' => $upload_files['signature']['error'],

                        'size' => '2000'

                    );



                    $this->upload->do_upload('signature');







                    $upload_data = $this->upload->data();







                    $dest = getcwd() . "/attachement/sign/" . $upload_data['file_name'];







                    $src = $this->config->item("base_url") . 'attachement/sign/' . $upload_data['file_name'];



                    $input_data['signature'] = $upload_data['file_name'];
                }
            }



            //echo "<pre>";print_r($input_data);exit;



            $this->user_model->update_user($input_data, $id);



            $this->user_model->delete_user_firm($id);



            $firm_id = array();



            $firm_id = $this->input->POST('firm_id');



            if (isset($firm_id) && !empty($firm_id)) {



                $i = 0;



                foreach ($firm_id as $firm) {



                    $firm_input = array('user_id' => $id, 'firm_id' => $firm);



                    $this->user_model->insert_firm($firm_input);
                }
            }

            $firms = $this->user_model->get_all_firms_by_user_id($id);

            $firms_data = array('firms' => $firms);

            $this->user_auth->store_in_session($firms_data);

            $data['all_state'] = $this->user_model->state();



            $data["agent"] = $this->user_model->get_user();



            $this->template->write_view('content', 'masters/update_user', $data);



            redirect($this->config->item('base_url') . 'masters/users/');
        }
    }



    public function delete_user()
    {



        $this->load->model('masters/user_model');



        $data["agent"] = $this->user_model->get_user();



        $id = $this->input->POST('value1');



        $this->user_model->delete_user($id);



        redirect($this->config->item('base_url') . 'masters/users', $data);
    }



    public function add_duplicate_email()
    {



        $this->load->model('masters/user_model');



        $input = $this->input->get('value1');



        $validation = $this->user_model->add_duplicate_email($input);



        $i = 0;



        if ($validation) {



            $i = 1;
        }
        if ($i == 1) {



            echo "Email Already Exist";
        }
    }



    public function add_duplicate_user()
    {



        $this->load->model('masters/user_model');



        $input = $this->input->get('value1');



        $validation = $this->user_model->add_duplicate_user($input);



        $i = 0;



        if ($validation) {



            $i = 1;
        }
        if ($i == 1) {



            echo "Username Already Exist";
        }
    }



    public function update_duplicate_email()
    {



        $this->load->model('masters/user_model');



        $input = $this->input->post('value1');



        $id = $this->input->post('value2');



        //        echo $input;

        //        echo $id;

        //        exit;



        $validation = $this->user_model->update_duplicate_email($input, $id);



        $i = 0;



        if ($validation) {



            $i = 1;
        }
        if ($i == 1) {



            echo "Email already Exist";
        }
    }



    public function update_duplicate_user()
    {



        $this->load->model('masters/user_model');



        $input = $this->input->post('value1');



        $id = $this->input->post('value2');



        //        echo $input;

        //        echo $id;

        //        exit;



        $validation = $this->user_model->update_duplicate_user($input, $id);



        $i = 0;



        if ($validation) {



            $i = 1;
        }
        if ($i == 1) {



            echo "User already Exist";
        }
    }



    public function users_ajaxList()
    {



        $list = $this->user_model->get_datatables();



        //        $i = 0;

        //        foreach ($list as $val) {

        //            $this->db->select('*');

        //            $this->db->where('user_id', $val['id']);

        //            $list[$i]['firm'] = $this->db->get('erp_user_firms')->result_array();

        //            $i++;

        //        }

        //        echo "<pre>";

        //        print_r($list);

        //        exit;



        $data = array();



        $no = $_POST['start'];



        foreach ($list as $ass) {



            //  $edit_access = ($edit_access == 0) ? 'blocked_access' : '';

            // $delete_access = ($delete_access == 0) ? 'blocked_access' : '';







            $no++;



            $row = array();



            $row[] = $no;



            $row[] = $ass->name;



            $row[] = $ass->username;



            $row[] = $ass->mobile_no;



            $row[] = $ass->email_id;



            $row[] = $ass->user_role;



            $row[] = 'test';



            //            $rows[] = $ass->firm_name;

            //            foreach ($rows as $lst) {

            //                $row[] = $ass->name . '<span class="badge bg-green" style="padding: 2px;"></span><br>';

            //            }



            if ($this->user_auth->is_action_allowed('masters', 'users', 'edit')) {



                $rows = '<a href="' . base_url() . 'masters/users/edit_user/' . $ass->id . '" data-toggle="modal" id="edit" class="tooltips btn btn-default btn-xs" title="" ><span class="fa fa-log-out "> <span class="fa fa-edit" ></span></span></a>';
            } else {



                $rows = '<a href="#" data-toggle="tooltip" class="tooltips btn btn-default btn-xs alerts" title="" ><span class="fa fa-log-out "> <span class="fa fa-edit"></span></span></a>';
            }



            if ($this->user_auth->is_action_allowed('masters', 'users', 'delete')) {



                $row[] = $rows . '<a href="#test3_' . $ass->id . '" data-toggle="modal" id="delete_yes" name="delete" class="tooltips btn btn-default btn-xs" ><span class="fa fa-log-out"> <span class="fa fa-ban " hidin="' . $ass->id . '"></span>  </span></a>';
            } else {



                $row[] = $rows . '<a href="#" data-toggle="tooltip" class="tooltips btn btn-default btn-xs alerts" title="" ><span class="fa fa-log-out "> <span class="fa fa-ban"></span> </span></a>';
            }



            $data[] = $row;
        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->user_model->count_all(),

            "recordsFiltered" => $this->user_model->count_filtered(),

            "data" => $data,

        );



        echo json_encode($output);



        exit;
    }
}
