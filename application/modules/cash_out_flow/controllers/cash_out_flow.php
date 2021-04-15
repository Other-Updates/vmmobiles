<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cash_out_flow extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->clear_cache();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'cash_out_flow';
        $access_arr = array(
            'cash_out_flow/cash_out_flow_list' => array('add', 'edit', 'delete', 'view'),
            'cash_out_flow/index' => array('add'),
            'cash_out_flow/get_all_users_by_firm' => 'no_restriction',
            'cash_out_flow/get_mobile_number' => 'no_restriction',
            'cash_out_flow/get_all_cash_out_flow' => 'no_restriction',
            'cash_out_flow/cash_out_flow_edit' => 'no_restriction',
            'cash_out_flow/force_payment' => 'no_restriction',
            'cash_out_flow/cash_out_flow_view' => 'no_restriction',
            'cash_out_flow/cash_out_flow_search_result' => 'no_restriction',
            'cash_out_flow/clear_cache' => 'no_restriction',
            'cash_out_flow/cash_out_flow_delete' => 'no_restriction',
            'cash_out_flow/ajaxList' => 'no_restriction',
            'cash_out_flow/get_sales_man_by_firm' => 'no_restriction',
        );
        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('cash_out_flow/cash_out_flow_model');
        $this->load->model('purchase_order/purchase_order_model');
        $this->load->model('quotation/gen_model');
    }

    public function index() {
        $data['firms'] = $firms = $this->user_auth->get_user_firms();
        $data['all_firm'] = $all_firm = $this->cash_out_flow_model->get_all_firms();
        if ($this->input->post()) {
            $input = $this->input->post();
            $input['created_date'] = date('Y-m-d H:i:s');

            $this->cash_out_flow_model->insert_cash_out_flow($input);
            redirect($this->config->item('base_url') . 'cash_out_flow/cash_out_flow_list');
        }
        $firms_id = $data['firms']['firm_id'];
        $all_firm_id = $data['all_firm']['firm_id'];
        $data["sender_customers"] = $this->gen_model->get_all_customers($firms_id);
        $data["receiver_customers"] = $this->gen_model->get_all_customers($all_firm_id);
//        echo "<pre>";
//        print_r($data);
//        exit;
        $this->template->write_view('content', 'cash_out_flow/index', $data);
        $this->template->render();
    }

    public function get_all_users_by_firm($firm_id) {
        $users = $this->cash_out_flow_model->get_all_users($firm_id);
        $customers = $this->cash_out_flow_model->get_all_customers($firm_id);
        $suppliers = $this->cash_out_flow_model->get_all_suppliers($firm_id);
        $users_json = array();
        if (!empty($users)) {
            foreach ($users as $list) {
                $users_json[] = $list['name'];
            }
        }
        if (!empty($customers)) {
            foreach ($customers as $list) {
                $users_json[] = $list['name'];
            }
        }
        if (!empty($suppliers)) {
            foreach ($suppliers as $list) {
                $users_json[] = $list['name'];
            }
        }
        $users_json[] = 'Others';
        // $users_json1 = implode(',', $users_json);
        $users_json1 = $users_json;
        //echo $users_json1;
        echo json_encode($users_json1);
        exit;
    }

    public function get_mobile_number() {
        $name = $this->input->post('name');
        $users = $this->cash_out_flow_model->get_mobile_number($name);
        echo json_encode($users);
        exit;
    }

    public function cash_out_flow_list() {
        $data['firms'] = $firms = $this->user_auth->get_user_firms();
        $data['user'] = $this->cash_out_flow_model->get_all_cash_out_flow();
        //$data['cash_out'] = $this->cash_out_flow_model->get_all_cash_out_flow();
//        echo '<pre>';
//        print_r($data);
//        exit;
        $this->template->write_view('content', 'cash_out_flow/cash_out_flow_list', $data);
        $this->template->render();
    }

    function ajaxList() {
        $search_data = $this->input->post();
        $search_arr = array();
        $search_arr['category'] = $search_data['category'];
        //$search_arr['brand'] = $search_data['brand'];
        $search_arr['product'] = $search_data['product'];
        //$search_arr['category'] = $search_data['category'];
        if (empty($search_arr)) {
            $search_arr = array();
        }
        $list = $this->cash_out_flow_model->get_datatables($search_arr);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {
            $url = $view = $edit = $alert = $delete = "";
            $view_url = $edit_url = $delete_url = "";
            if ($val['payment_status'] == 'pending') {
                $url = '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="In-Complete"><span class="fa fa-thumbs-down blue">&nbsp;</span></a>';
            } else {
                if ($val['is_force_pay'] == 1) {
                    $url = '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="Complete - ' . $val['remarks'] . '"><span class="fa fa-thumbs-up bro">&nbsp;</span></a>';
                } else {
                    $url = '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="Complete"><span class="fa fa-thumbs-up green">&nbsp;</span></a>';
                }
            }
            if ($this->user_auth->is_action_allowed('cash_out_flow', 'cash_out_flow', 'edit')) {
                $edit = $this->config->item('base_url') . 'cash_out_flow/cash_out_flow_edit/' . $val['id'];
            }
            if ($this->user_auth->is_action_allowed('cash_out_flow', 'cash_out_flow', 'view')) {
                $view = $this->config->item('base_url') . 'cash_out_flow/cash_out_flow_view/' . $val['id'];
            }
            if ($this->user_auth->is_action_allowed('cash_out_flow', 'cash_out_flow', 'delete')) {
                $delete = '#test3_' . $val['id'];
            }
            if ((!$this->user_auth->is_action_allowed('cash_out_flow', 'cash_out_flow', 'edit')) || (!$this->user_auth->is_action_allowed('cash_out_flow', 'cash_out_flow', 'view')) || (!$this->user_auth->is_action_allowed('cash_out_flow', 'cash_out_flow', 'delete'))) {
                $alert = 'alerts';
            }
            $edit_url = '<a href="' . $edit . '"data-toggle="tooltip" class="tooltips btn btn-info btn-xs ' . $alert . '" title="" data-original-title="Quick pay"><span class="fa fa-edit "></span></a>';
            $view_url = '<a href="' . $view . '" data-toggle="tooltip" class="tooltips btn btn-default btn-xs ' . $alert . '" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>';
            $delete_url = '<a href="' . $delete . '" data-toggle="modal" name="delete" class="tooltips btn btn-danger btn-xs ' . $alert . '" title="Delete"><span class="fa fa-ban"></span></a>';

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val['firm_name'];
            $row[] = ($val['user_name'] == 'Others') ? $val['other_name'] : $val['user_name'];
            $row[] = $val['sender'][0]['sender_firm_name'];
            $row[] = ($val['sender_name'] == 'Others') ? $val['sender_other_name'] : $val['sender_name'];
            $row[] = $val['cash_out'];
            $row[] = $val['cash_in'];
            $row[] = number_format(($val['cash_out'] - $val['cash_in']), 2);
            $row[] = $url;
            if ($val['payment_status'] == 'pending') {
                $row[] = $edit_url . ' ' . $view_url . ' ' . $delete_url;
            } else {
                $row[] = $view_url . ' ' . $delete_url;
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cash_out_flow_model->count_all(),
            "recordsFiltered" => $this->cash_out_flow_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    public function cash_out_flow_edit($id) {
        $update = array();
        if ($this->input->post()) {
            $input = $this->input->post();
            $input['cash_out_id'] = $id;
            $input['created_date'] = date('Y-m-d H:i:s');
            $this->cash_out_flow_model->insert_cash_out_flow_history($input);

            $cash_out = $this->cash_out_flow_model->get_cash_out_flow_by_id($id);
            $update['cash_in'] = $cash_out[0]['cash_in'] + $input['amount_in'];
            $update['balance'] = $cash_out[0]['cash_out'] - $update['cash_in'];
            $input['updated_date'] = date('Y-m-d H:i:s');
            $this->cash_out_flow_model->update_cash_out_flow($update, $id);
            $cash_out1 = $this->cash_out_flow_model->get_cash_out_flow_by_id($id);
            if ($cash_out1[0]['cash_out'] == $cash_out1[0]['cash_in']) {
                $update1['payment_status'] = 'completed';
                $this->cash_out_flow_model->update_cash_out_flow($update1, $id);
            }
            redirect($this->config->item('base_url') . 'cash_out_flow/cash_out_flow_list');
        }
        $data['payment'] = $this->cash_out_flow_model->get_cash_out_flow_by_id($id);
        $this->template->write_view('content', 'cash_out_flow/update_payment', $data);
        $this->template->render();
    }

    public function force_payment($id) {
        $input = $this->input->post();
        $update1 = array();
        $update1['payment_status'] = 'completed';
        $update1['remarks'] = $input['remarks'];
        $update1['is_force_pay'] = 1;
        $this->cash_out_flow_model->update_cash_out_flow($update1, $id);

        $inputs['cash_out_id'] = $id;
        $inputs['remarks'] = $input['remarks'];
        $inputs['amount_in'] = '';
        $inputs['created_date'] = date('Y-m-d H:i:s');
        $this->cash_out_flow_model->insert_cash_out_flow_history($inputs);

        echo '1';
        //redirect($this->config->item('base_url') . 'cash_out_flow/cash_out_flow_list');
    }

    public function cash_out_flow_view($id) {
        $data['payment'] = $this->cash_out_flow_model->get_cash_out_flow_by_id($id);
        $firm_id = $data['payment'][0]['sender_firm_id'];
        $data['company_details'] = $this->purchase_order_model->get_company_details_by_firmid($firm_id);

        $this->template->write_view('content', 'cash_out_flow/cash_out_flow_view', $data);
        $this->template->render();
    }

    public function cash_out_flow_search_result() {
        $search_data = $this->input->post();
        $data['search_data'] = $search_data;
        $data['cash_out'] = $this->cash_out_flow_model->get_all_cash_out_flow($search_data);
        $this->load->view('cash_out_flow/cash_out_flow_search_list', $data);
    }

    function clear_cache() {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    public function cash_out_flow_delete() {
        $id = $this->input->POST('value1');
        $del_id = $this->cash_out_flow_model->cash_out_flow_delete($id);
        redirect($this->config->item('base_url') . 'cash_out_flow/cash_out_flow_list');
    }

    public function get_sales_man_by_firm() {
        $sender_firm_id = $this->input->POST('sender_firm_id');
        $sales_man = $this->cash_out_flow_model->get_sales_man_by_firm($sender_firm_id);
        echo json_encode($sales_man);
        exit;
    }

}
