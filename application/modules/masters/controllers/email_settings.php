<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_settings extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'masters';
        $access_arr = array(
            'email_settings/index' => array('add', 'edit', 'delete', 'view'),
            'email_settings/insert_email' => 'no_restriction',
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('masters/email_settings_model');
        $this->load->model('admin/admin_model');
    }

    public function index() {

        $data["emails"] = $this->email_settings_model->get_quotation_emails();
        $this->template->write_view('content', 'masters/email_settings', $data);
        $this->template->render();
    }

    public function insert_email() {
        $input = $this->input->post();
        $this->email_settings_model->delete_email();
        if (isset($input['type']) && !empty($input['type'])) {
            $insert_arr = array();
            foreach ($input['type'] as $key => $val) {
                $insert['type'] = $val;
                $insert['label'] = $input['label'][$key];
                $insert['value'] = $input['value'][$key];
                $insert_arr[] = $insert;
            }

            $this->email_settings_model->insert_email($insert_arr);
            $data['company_amount'] = $this->admin_model->get_company_amount();
            $input_comp['receiver_type'] = "Opening Company Amount";
            $input_comp['type'] = "credit";
            $input_comp['recevier'] = "company";
            $input_comp['bill_amount'] = $data['company_amount'][0]['value'];
            $this->load->model('sales_receipt/sales_receipt_model');
            $this->load->model('receipt/receipt_model');
            $insert_agent_cash = $this->receipt_model->insert_agent_amount($input_comp);
        }

        redirect($this->config->item('base_url') . 'masters/email_settings');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
