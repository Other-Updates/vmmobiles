<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sales_man extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->clear_cache();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'masters';
        $access_arr = array(
            'sales_man/index' => array('add', 'edit', 'delete', 'view'),
            'sales_man/insert_sales_man' => array('add'),
            'sales_man/edit_sales_man' => array('edit'),
            'sales_man/update_sales_man' => array('edit'),
            'sales_man/delete_sales_man' => array('delete'),
            'sales_man/add_duplicate_email' => array('add', 'edit'),
            'sales_man/update_duplicate_email' => array('add', 'edit'),
            'sales_man/add_state' => array('add', 'edit'),
            'sales_man/load_user' => array('add', 'edit', 'delete', 'view'),
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('masters/sales_man_model');
        $this->load->model('masters/customer_model');
        $this->load->model('masters/user_model');
        $this->load->model('agent/agent_model');
    }

    public function index() {
        $data["sales_man"] = $this->sales_man_model->get_sales_man();
        $data['all_state'] = $this->customer_model->state();
        $data['firms'] = $firms = $this->user_auth->get_user_firms();
        $this->template->write_view('content', 'masters/sales_man', $data);
        $this->template->render();
    }

    public function insert_sales_man() {
        $input_data = array(
            'firm_id' => $this->input->post('firm_id'),
            'sales_man_name' => $this->input->post('sales_man_name'),
            'email_id' => $this->input->post('mail'),
            'mobil_number' => $this->input->post('number'),
            'address1' => $this->input->post('address1'),
            'bank_name' => $this->input->POST('bank'),
            'bank_branch' => $this->input->POST('branch'),
            'account_num' => $this->input->POST('acnum'),
            'ifsc' => $this->input->post('ifsc'),
            'target_rate' => $this->input->post('target_rate'),
        );
        $this->sales_man_model->insert_sales_man($input_data);
        $data["sales_man"] = $this->sales_man_model->get_sales_man();
        redirect($this->config->item('base_url') . 'masters/sales_man', $data);
    }

    public function edit_sales_man($id) {
        $data["sales_man"] = $this->sales_man_model->get_sales_man_by_id($id);
        $data['firms'] = $firms = $this->user_auth->get_user_firms();
        $data['all_state'] = $this->customer_model->state();
        $this->template->write_view('content', 'masters/update_sales_man', $data);
        $this->template->render();
    }

    public function update_sales_man() {
        //this->load->model('customer/customer_model');
        $id = $this->input->POST('id');
        $input = array(
            'firm_id' => $this->input->post('firm_id'),
            'sales_man_name' => $this->input->post('sales_man_name'),
            'email_id' => $this->input->post('mail'),
            'mobil_number' => $this->input->post('number'),
            'address1' => $this->input->post('address1'),
            'bank_name' => $this->input->POST('bank'),
            'bank_branch' => $this->input->POST('branch'),
            'account_num' => $this->input->POST('acnum'),
            'ifsc' => $this->input->post('ifsc'),
            'target_rate' => $this->input->post('target_rate'),
        );

        $this->sales_man_model->update_sales_man($input, $id);
        redirect($this->config->item('base_url') . 'masters/sales_man');
    }

    public function delete_sales_man() {
        //$this->load->model('customer/customer_model');
        $data["sales_man"] = $this->sales_man_model->get_sales_man();
        $id = $this->input->POST('value1');
        {
            $this->sales_man_model->delete_sales_man($id);

            redirect($this->config->item('base_url') . 'masters/sales_man', $data);
        }
    }

    public function add_duplicate_email() {
        $this->load->model('customer/customer_model');
        $input = $this->input->get('value1');
        $validation = $this->customer_model->add_duplicate_email($input);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Email Already Exist";
        }
    }

    public function update_duplicate_email() {
        $this->load->model('customer/customer_model');
        $input = $this->input->post('value1');
        $id = $this->input->post('value2');
        $validation = $this->customer_model->update_duplicate_email($input, $id);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Email already Exist";
        }
    }

    public function add_state() {
        $this->load->model('customer/customer_model');
        $input = $this->input->get();
        $insert_id = $this->customer_model->insert_state($input);
        echo $insert_id;
    }

    public function load_user() {
        $ref = $this->input->post('ref');
        $user_list = array();
        if ($ref == 1) {
            $user_list = $this->user_model->get_user_name();
        } else if ($ref == 2) {
            $user_list = $this->customer_model->get_con_customer_list();
        }
        echo json_encode($user_list);
        exit;
    }

    function clear_cache() {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

}
