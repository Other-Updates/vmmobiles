<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends MX_Controller {

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
        $this->load->library('email');
        $this->load->database();
        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->model('users/user_model');
        $data["agent"] = $this->user_model->get_user();
        $data['all_state'] = $this->user_model->state();
        $data['user'] = $user = $this->user_model->get_user_role();
        //echo "<pre>";print_r($data);exit;
        $this->template->write_view('content', 'users/index', $data);
        $this->template->render();
    }

    public function insert_user() {
        $this->load->model('users/user_model');
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
            $input_data = array('name' => $this->input->post('name'), 'address' => $this->input->post('address1'), 'nick_name' => $this->input->post('nick_name'),
                'mobile_no' => $this->input->post('number'), 'email_id' => $this->input->post('mail'),
                'password' => md5($this->input->POST('pass')), 'username' => $this->input->POST('user_name'), 'role' => $this->input->POST('role'), 'signature' => $upload_data['file_name']);
            //echo "<pre>";print_r($input_data);exit;
            $this->user_model->insert_user($input_data);
            $data["agent"] = $this->user_model->get_user();
            redirect($this->config->item('base_url') . 'users/index', $data);
        }
    }

    public function edit_user($id) {
        $this->load->model('users/user_model');
        $data['all_state'] = $this->user_model->state();
        $data['user'] = $user = $this->user_model->get_user_role();
        $data["agent"] = $this->user_model->get_user1($id);
        $this->template->write_view('content', 'users/update_user', $data);
        $this->template->render();
    }

    public function update_user() {
        $this->load->model('users/user_model');
        $id = $this->input->POST('id');
        if ($this->input->post()) {
            $this->load->helper('text');

            $config['upload_path'] = './attachement/sign';

            $config['allowed_types'] = '*';

            $config['max_size'] = '2000';

            $this->load->library('upload', $config);
            
            
            $input_data = array('name' => $this->input->post('name'), 'address' => $this->input->post('address1'), 'nick_name' => $this->input->post('nick_name'),
                'mobile_no' => $this->input->post('number'), 'email_id' => $this->input->post('mail'), 'username' => $this->input->POST('username'), 'role' => $this->input->POST('role'));
            
            $pass=$this->input->POST('pass');
            if(isset($pass) && !empty($pass))
                $input_data['password']=md5($pass);           
            
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
            $data['all_state'] = $this->user_model->state();
            $data["agent"] = $this->user_model->get_user();
            $this->template->write_view('content', 'users/update_user', $data);
            redirect($this->config->item('base_url') . 'users/');
        }
    }

    public function delete_user() {
        $this->load->model('users/user_model');
        $data["agent"] = $this->user_model->get_user();
        $id = $this->input->POST('value1');
        $this->user_model->delete_user($id);
        redirect($this->config->item('base_url') . 'users/index', $data);
    }

    public function add_duplicate_email() {
        $this->load->model('users/user_model');
        $input = $this->input->get('value1');
        $validation = $this->user_model->add_duplicate_email($input);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Email Already Exist";
        }
    }

    public function update_duplicate_email() {
        $this->load->model('users/user_model');
        $input = $this->input->post('value1');
        $id = $this->input->post('value2');
        // echo $input; echo $id; exit;
        $validation = $this->user_model->update_duplicate_email($input, $id);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Email already Exist";
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
