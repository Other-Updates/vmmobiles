<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Firms extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'masters';
        $access_arr = array(
            'firms/index' => array('add', 'edit', 'delete', 'view'),
            'firms/insert_firms' => array('add'),
            'firms/edit_firm' => array('edit'),
            'firms/update_firm' => array('edit'),
            'firms/delete_firm' => array('delete'),
            'firms/add_duplicate_firm' => array('add', 'edit'),
            'firms/update_duplicate_firm' => array('add', 'edit'),
            'firms/add_state' => array('add', 'edit')
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('masters/manage_firms_model');
    }

    public function index() {
        $data["firms"] = $this->manage_firms_model->getallfirms();
        $this->template->write_view('content', 'masters/firm', $data);
        $this->template->render();
    }

    public function insert_firms() {

        if ($this->input->post()) {
            $input = $this->input->post();
            $input['status'] = 1;
            $input['created_date'] = date('Y-m-d H:i:s');
            unset($input['submit']);
            // echo "<pre>"; print_r($input); exit;
            $this->manage_firms_model->insert_firm($input);
            redirect($this->config->item('base_url') . 'masters/firms');
        }
    }

    public function edit_firm($id) {
        $data["firms"] = $this->manage_firms_model->get_firm_by_id($id);
        $this->template->write_view('content', 'masters/update_firm', $data);
        $this->template->render();
    }

    public function update_firm($id) {
        if ($this->input->post()) {
            $input = $this->input->post();
            unset($input['submit']);
            $this->manage_firms_model->update_firm($input, $id);
            redirect($this->config->item('base_url') . 'masters/firms');
        }
    }

    public function delete_firm() {
        $id = $this->input->POST('value1');
        $this->manage_firms_model->delete_firm($id);
        redirect($this->config->item('base_url') . 'masters/firms');
    }

    public function add_duplicate_firm() {

        $input = $this->input->get('value1');
        $validation = $this->manage_firms_model->add_duplicate_firm($input);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo"Firm Name Already Exist";
        }
    }

    public function update_duplicate_firm() {
        $input = $this->input->get('value1');
        $id = $this->input->get('value2');
        $validation = $this->manage_firms_model->update_duplicate_firm($input, $id);

        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Firm Name Already Exist";
        }
    }

}
