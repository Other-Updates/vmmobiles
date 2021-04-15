<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_fit extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->database();
        $this->load->library('form_validation');
        $this->load->model('master_fit/user_type_model');
        $this->load->model('master_fit/user_module_model');
        $this->load->model('master_fit/user_section_model');
    }

    public function index() {
        $this->load->model('master_fit/master_fit_model');
        $data['user_roles'] = $this->master_fit_model->get_all_fit();
        $this->template->write_view('content', 'master_fit/index', $data);
        $this->template->render();
    }

    public function insert_master_fit() {
        $this->load->model('master_fit/master_fit_model');
        $input = array('user_role' => $this->input->post('fit'), 'permission' => $this->input->post('permission'));
        if ($input['user_role'] != '') {
            $this->master_fit_model->insert_master_fit($input);
            $data["detail"] = $this->master_fit_model->get_all_fit();
            redirect($this->config->item('base_url') . 'master_fit/index', $data);
        } else {
            $data["detail"] = $this->master_fit_model->get_all_fit();
            $this->template->write_view('content', 'master_fit/index', $data);
            $this->template->render();
        }
    }

    public function update_fit() {
        $this->load->model('master_fit/master_fit_model');
        $id = $this->input->post('value1');
        $input = array('user_role' => $this->input->post('value2'), 'permission' => $this->input->post('value3'));
        $this->master_fit_model->update_fit($input, $id);
        $data["detail"] = $this->master_fit_model->get_all_fit();
        redirect($this->config->item('base_url') . 'master_fit/index', $data);
    }

    public function delete_master_fit() {
        $this->load->model('master_fit/master_fit_model');
        $id = $this->input->get('value1'); {
            $this->master_fit_model->delete_master_fit($id);
            $data["detail"] = $this->master_fit_model->get_all_fit();
            redirect($this->config->item('base_url') . 'master_fit/index', $data);
        }
    }

    public function user_permissions($type) {
        $data = array();
        $data['title'] = 'User Types - Permissions';

        if ($this->input->post('permissions', TRUE)) {
            $permissions = $this->input->post('permissions');
            $grand_all = $this->input->post('grand_all');
            $grand_all = !empty($grand_all) ? $grand_all : 0;
            //echo '<pre>'; print_r($this->input->post()); exit;
            $user_type = array('grand_all' => $grand_all);
            $this->user_type_model->update_user_type($user_type, $type);
            if (!empty($permissions)) {
                $this->user_type_model->delete_user_permission_by_type($type);
                foreach ($permissions as $module_id => $sections) {
                    if (!empty($sections)) {
                        foreach ($sections as $section_id => $item) {
                            $permission_arr = array(
                                'user_type_id' => $type,
                                'module_id' => $module_id,
                                'section_id' => $section_id,
                                'acc_all' => !empty($item['acc_all']) ? 1 : 0,
                                'acc_view' => !empty($item['acc_view']) ? 1 : 0,
                                'acc_add' => !empty($item['acc_add']) ? 1 : 0,
                                'acc_edit' => !empty($item['acc_edit']) ? 1 : 0,
                                'acc_delete' => !empty($item['acc_delete']) ? 1 : 0,
                                'created_date' => date('Y-m-d H:i:s')
                            );
                            $this->user_type_model->insert_user_permission($permission_arr);
                        }
                    }
                }
            }
            $this->session->set_flashdata('flashSuccess', 'User Type Permission successfully updated!');
            redirect($this->config->item('base_url') . 'master_fit/user_types');
        }

        $data['user_type_id'] = $type;
        $data['user_type'] = $this->user_type_model->get_user_type_by_id($type);
        $data['user_sections'] = $this->user_section_model->get_all_user_sections_with_modules();
        $user_permissions = $this->user_type_model->get_user_permissions_by_type($type);
        $user_permissions_arr = array();
        if (!empty($user_permissions)) {
            foreach ($user_permissions as $key => $value) {
                $user_permissions_arr[$value['module_id']][$value['section_id']] = array('acc_all' => $value['acc_all'], 'acc_view' => $value['acc_view'], 'acc_add' => $value['acc_add'], 'acc_edit' => $value['acc_edit'], 'acc_delete' => $value['acc_delete']);
            }
        }
        $data['user_permissions'] = $user_permissions_arr;
        //echo '<pre>';
        //print_r($data);
        //exit;
        $this->template->write_view('content', 'master_fit/user_permissions', $data);
        $this->template->render();
    }

    public function insert_user_role_permissions() {
        $this->user_module_model->insert_all_user_modules($type);
        $this->user_section_model->insert_all_user_sections($type);
    }

    public function add_duplicate_fit() {
        $this->load->model('master_fit/master_fit_model');
        $input = $this->input->get('value1');
        $validation = $this->master_fit_model->add_duplicate_fit($input);
        $i = 0;
        if ($validation) {
            $i = 1;
        }
        if ($i == 1) {
            echo "Fit Name Already Exist";
        }
    }

    public function update_duplicate_fit() {
        $this->load->model('master_fit/master_fit_model');
        $input = $this->input->post('value1');
        $id = $this->input->post('value2');
        $validation = $this->master_fit_model->update_duplicate_fit($input, $id);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Fit Name already Exist";
        }
    }

    public function expense_index() {
        $this->load->model('master_fit/master_fit_model');
        $data["details"] = $this->master_fit_model->get_all_expense_fixed();
        // print_r($data);exit;
        $data["variable"] = $this->master_fit_model->get_all_expense_variable();
        $this->template->write_view('content', 'master_fit/expense_index', $data);
        $this->template->render();
    }

    public function insert_master_expense() {
        $this->load->model('master_fit/master_fit_model');
        $input = array('expense' => $this->input->post('expense'), 'expense_type' => $this->input->post('expense_type'));
        if ($input['expense'] != '') {
            $this->master_fit_model->insert_master_expense($input);
            $data["details"] = $this->master_fit_model->get_all_expense_fixed();



            redirect($this->config->item('base_url') . 'master_fit/expense_index', $data);
        } else {
            $data["details"] = $this->master_fit_model->get_all_expense_fixed();

            $this->template->write_view('content', 'master_fit/expense_index', $data);
            $this->template->render();
        }
    }

    public function delete_master_expense() {
        $this->load->model('master_fit/master_fit_model');
        $id = $this->input->get('value1'); {
            $this->master_fit_model->delete_master_expense($id);
            $data["details"] = $this->master_fit_model->get_all_expense_fixed();
            $data["variable"] = $this->master_fit_model->get_all_expense_variable();
            redirect($this->config->item('base_url') . 'master_fit/index', $data);
        }
    }

    public function update_expense() {
        $this->load->model('master_fit/master_fit_model');
        $id = $this->input->get('value1');
        $input = array('expense' => $this->input->get('value2'));
        $this->master_fit_model->update_expense_one($input, $id);
        $data["details"] = $this->master_fit_model->get_all_expense_fixed();
        $data["variable"] = $this->master_fit_model->get_all_expense_variable();
        redirect($this->config->item('base_url') . 'master_fit/index', $data);
    }

    public function add_duplicate_expense_fixed() {
        $this->load->model('master_fit/master_fit_model');
        $input = $this->input->get();
        //print_r($input); exit;
        $validation = $this->master_fit_model->add_duplicate_expense_fixed($input);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Expense Already Exist";
        }
    }

    public function add_duplicate_expense_variable() {
        $this->load->model('master_fit/master_fit_model');
        $input = $this->input->get();
        //print_r($input); exit;
        $validation = $this->master_fit_model->add_duplicate_expense_variable($input);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Expense Already Exist";
        }
    }

    public function update_duplicate_expense_fixed() {
        $this->load->model('master_fit/master_fit_model');
        $input = $this->input->post('value1');
        $id = $this->input->post('value2');
        $exp_type = $this->input->post('value3');
        $validation = $this->master_fit_model->update_duplicate_expense_fixed($input, $id, $exp_type);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Expense Name already Exist";
        }
    }

    public function update_duplicate_expense_varaible() {
        $this->load->model('master_fit/master_fit_model');
        $input = $this->input->post('value1');
        $id = $this->input->post('value2');
        $exp_type = $this->input->post('value3');
        $validation = $this->master_fit_model->update_duplicate_expense_varaible($input, $id, $exp_type);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Expense Name already Exist";
        }
    }

}
