<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reference_groups extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'masters';
        $access_arr = array(
            'reference_groups/index' => array('add', 'edit', 'delete', 'view'),
            'reference_groups/insert_ref_groups' => array('add'),
            'reference_groups/edit_ref_group' => array('edit'),
            'reference_groups/update_ref_group' => array('edit'),
            'reference_groups/delete_reference_group' => array('delete'),
            'reference_groups/add_duplicate_email' => array('add', 'edit'),
            'reference_groups/update_duplicate_email' => array('add', 'edit'),
            'reference_groups/add_state' => array('add', 'edit'),
            'reference_groups/load_user' => array('add', 'edit', 'delete', 'view'),
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('masters/reference_groups_model');
        $this->load->model('masters/customer_model');
        $this->load->model('masters/user_model');
        $this->load->model('agent/agent_model');
    }

    public function index() {

        $data["references"] = $this->reference_groups_model->get_references();
        $data["customers"] = $this->customer_model->get_con_customer_list();
        $data['all_state'] = $this->customer_model->state();
        $data['all_agent'] = $this->agent_model->get_agent();
        $data['firms'] = $firms = $this->user_auth->get_user_firms();
        $data['reference_types'] = $this->reference_groups_model->get_reference_types();
        $data['user_list'] = $this->user_model->get_user_name();
        $this->template->write_view('content', 'masters/reference_groups', $data);
        $this->template->render();
    }

    public function insert_ref_groups() {
        $this->load->model('masters/reference_groups_model');
        $input_data = array(
            'firm_id' => $this->input->post('firm_id'),
            'reference_type' => $this->input->post('reference_type'),
            'user_id' => $this->input->post('user'),
            'customer_id' => $this->input->post('customer_id'),
            'others' => $this->input->post('others'),
            'contact_person' => $this->input->post('contact_person'),
            'email_id' => $this->input->post('mail'),
            'mobil_number' => $this->input->post('number'),
            'address1' => $this->input->post('address1'),
            'address2' => $this->input->post('address2'),
            'state_id' => $this->input->post('state_id'),
            'city' => $this->input->post('city'),
            'bank_name' => $this->input->POST('bank'),
            'bank_branch' => $this->input->POST('branch'),
            'account_num' => $this->input->POST('acnum'),
            'ifsc' => $this->input->post('ifsc'),
            'agent_name' => $this->input->post('agent_name'),
            'payment_terms' => $this->input->post('payment_terms'),
            'commission_rate' => $this->input->post('commission_rate'),
                //'status' => 1,
        );

        if ($this->input->post('reference_type') != 2) {
            $input_data['contact_person'] = $this->input->post('contact_person1');
            $input_data['email_id'] = $this->input->post('mail1');
        }
        //echo '<pre>'; print_r($input_data); exit;
        $this->reference_groups_model->insert_ref_group($input_data);
        $data["references"] = $this->reference_groups_model->get_references();
        redirect($this->config->item('base_url') . 'masters/reference_groups', $data);
    }

    public function edit_ref_group($id) {
        $data["references"] = $this->reference_groups_model->get_reference_by_id($id);
        $data["customers"] = $this->customer_model->get_con_customer_list();
        $data['all_state'] = $this->customer_model->state();
        $data['all_agent'] = $this->agent_model->get_agent();
        $data['firms'] = $firms = $this->user_auth->get_user_firms();
        $data['reference_types'] = $this->reference_groups_model->get_reference_types();
        $data['user_list'] = $this->user_model->get_user_name();
        $this->template->write_view('content', 'masters/update_reference_group', $data);
        $this->template->render();
    }

    public function update_ref_group() {
        //this->load->model('customer/customer_model');
        $id = $this->input->POST('id');
        $input = array(
            'firm_id' => $this->input->post('firm_id'),
            'reference_type' => $this->input->post('reference_type'),
            'user_id' => $this->input->post('user'),
            'customer_id' => $this->input->post('customer_id'),
            'others' => $this->input->post('others'),
            'contact_person' => $this->input->post('contact_person'),
            'email_id' => $this->input->post('mail'),
            'mobil_number' => $this->input->post('number'),
            'address1' => $this->input->post('address1'),
            'address2' => $this->input->post('address2'),
            'state_id' => $this->input->post('state_id'),
            'city' => $this->input->post('city'),
            'bank_name' => $this->input->POST('bank'),
            'bank_branch' => $this->input->POST('branch'),
            'account_num' => $this->input->POST('acnum'),
            'ifsc' => $this->input->post('ifsc'),
            'agent_name' => $this->input->post('agent_name'),
            'payment_terms' => $this->input->post('payment_terms'),
            'commission_rate' => $this->input->post('commission_rate'),
        );
        if ($this->input->post('reference_type') != 2) {
            $input_data['contact_person'] = $this->input->post('contact_person1');
            $input_data['email_id'] = $this->input->post('mail1');
        }
        $this->reference_groups_model->update_ref_group($input, $id);
        redirect($this->config->item('base_url') . 'masters/reference_groups');
    }

    public function delete_reference_group() {
        //$this->load->model('customer/customer_model');
        $data["references"] = $this->reference_groups_model->get_references();
        $id = $this->input->POST('value1'); {
            $this->reference_groups_model->delete_reference_group($id);

            redirect($this->config->item('base_url') . 'masters/reference_groups', $data);
        }
    }

    public function add_duplicate_email() {
        $this->load->model('customer/customer_model');
        $input = $this->input->post();
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

}
