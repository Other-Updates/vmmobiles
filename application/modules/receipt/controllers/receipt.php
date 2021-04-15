<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Receipt extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'receipt';
        $access_arr = array(
            'receipt/index' => array('add', 'edit', 'delete', 'view'),
            'receipt/manage_receipt' => array('add', 'edit', 'delete', 'view'),
            'receipt/receipt_list' => array('add', 'edit', 'delete', 'view'),
            'receipt/view_receipt' => array('add', 'edit', 'delete', 'view'),
        );
        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->model('masters/agent_model');
        $this->load->model('api/notification_model');
        $this->load->database();
        $this->load->library('form_validation');
        $this->load->model('admin/admin_model');
        $this->load->model('api/notification_model');
        $this->load->model('master_style/master_model');
        if (isset($_GET['notification']))
            $this->notification_model->update_notification(array('status' => 1), $_GET['notification']);
    }

    public function index() {
        $user_info = $this->user_auth->get_from_session('user_info');
        $this->load->model('receipt/receipt_model');
        $this->load->model('customer/customer_model');
        $this->load->model('customer/agent_model');
        $this->load->model('master_style/master_model');
        $data["last_id"] = $this->master_model->get_last_id('rp_code');
        $no[1] = substr($data["last_id"][0]['value'], 3);
        if (date('m') > 3) {
            $check_no = 'RP' . date('y') . (date('y') + 1) . '0001';
            $check_res = $this->receipt_model->check_so_no($check_no);
            if (empty($check_res)) {
                $data['last_no'] = 'RP' . date('y') . (date('y') + 1) . '0001';
            } else
                $data['last_no'] = 'RP' . date('y') . (date('y') + 1) . str_pad(substr($no[1], 4, 8) + 1, 4, '0', STR_PAD_LEFT);
        }else {
            $check_no = 'RP' . (date('y') - 1) . date('y') . '0001';
            $check_res = $this->receipt_model->check_so_no($check_no);
            if (empty($check_res)) {
                $data['last_no'] = 'RP' . (date('y') - 1) . date('y') . '0001';
            } else
                $data['last_no'] = 'RP' . (date('y') - 1) . date('y') . str_pad(substr($no[1], 4, 8) + 1, 4, '0', STR_PAD_LEFT);
        }
        if ($this->input->post()) {
            $input = $this->input->post();
            $this->receipt_model->update_invoice_status($input['inv_no']);
            if ($input['balance'] == 0)
                $input['receipt']['complete_status'] = 1;
            else
                $input['receipt']['complete_status'] = 0;
            $input['receipt']['due_date'] = date('Y-m-d', strtotime($input['receipt']['due_date']));


            $data["last_id"] = $this->master_model->get_last_id('rp_code');
            $no[1] = substr($data["last_id"][0]['value'], 3);
            if (date('m') > 3) {
                $check_no = 'RP' . date('y') . (date('y') + 1) . '0001';
                $check_res = $this->receipt_model->check_so_no($check_no);
                if (empty($check_res)) {
                    $data['last_no'] = 'RP' . date('y') . (date('y') + 1) . '0001';
                } else
                    $data['last_no'] = 'RP' . date('y') . (date('y') + 1) . str_pad(substr($no[1], 4, 8) + 1, 4, '0', STR_PAD_LEFT);
            }else {
                $check_no = 'RP' . (date('y') - 1) . date('y') . '0001';
                $check_res = $this->receipt_model->check_so_no($check_no);
                if (empty($check_res)) {
                    $data['last_no'] = 'RP' . (date('y') - 1) . date('y') . '0001';
                } else
                    $data['last_no'] = 'RP ' . (date('y') - 1) . date('y') . str_pad(substr($no[1], 4, 8) + 1, 4, '0', STR_PAD_LEFT);
            }
            $this->receipt_model->update_receipt_id($data['last_no']);
            $input['receipt']['receipt_no'] = $data['last_no'];
            if (isset($input['inv_no']) && !empty($input['inv_no'])) {
                $i = 0;
                $order_list = '';
                foreach ($input['inv_no'] as $key => $val) {

                    if ($i == 0) {
                        $order_list = $order_list . $val;
                        $i = 1;
                    } else
                        $order_list = $order_list . '-' . $val;
                }
            }
            $input['receipt']['inv_list'] = $order_list;
            //echo "<pre>";

            $insert_id = $this->receipt_model->insert_receipt($input['receipt']);
            $input['receipt_bill']['receipt_id'] = $insert_id;
            //print_r($insert_id);
            //print_r($input);
            $insert_id = $this->receipt_model->insert_receipt_bill($input['receipt_bill']);

            redirect($this->config->item('base_url') . 'receipt/receipt_list');
        }


        $data['all_customer'] = $this->customer_model->get_customer();
        $data['all_agent'] = $this->agent_model->get_agent();
        $this->template->write_view('content', 'receipt/index', $data);
        $this->template->render();
    }

    public function receipt_list() {
        $this->load->model('receipt/receipt_model');
        $data['all_receipt'] = $this->receipt_model->get_all_receipt();
        $this->template->write_view('content', 'receipt_list', $data);
        $this->template->render();
    }

    public function manage_receipt($r_id) {
        $this->load->model('receipt/receipt_model');
        if ($this->input->post()) {
            $input = $this->input->post();
            if ($input['balance'] == 0 || $input['balance'] == 0.00 || $input['balance'] == '0.00')
                $receipt_status = 'Completed';
            else
                $receipt_status = 'Pending';
            $input['receipt_bill']['due_date'] = ($input['receipt_bill']['due_date']) ? date('Y-m-d', strtotime($input['receipt_bill']['due_date'])) : date('Y-m-d', strtotime($input['receipt_bill']['created_date']));
            $input['receipt_bill']['created_date'] = date('Y-m-d', strtotime($input['receipt_bill']['created_date']));
            $this->receipt_model->update_invoice(array('payment_status' => $receipt_status), $input['receipt_bill']['receipt_id']);
            $insert_id = $this->receipt_model->insert_receipt_bill($input['receipt_bill']);
            $insert_id++;
            $inc['type'] = 'rp_code';
            $inc['value'] = 'RECQ000' . $insert_id;
            $this->receipt_model->update_increment($inc);
            //insert notification
            $notification = array();
            if (isset($input['receipt_bill']['due_date']) && !empty($input['receipt_bill']['due_date'])) {
                $notification = array();
                //$notification['notification_date']=$input['receipt_bill']['due_date'];
                $due_date = $input['receipt_bill']['due_date'];
                $notification['notification_date'] = date('Y-m-d', strtotime('-2 days', strtotime($due_date)));
                $notification['due_date'] = $due_date;
                $notification['type'] = 'payment';
                $receiver_list = array(1, 2);
                $notification['receiver_id'] = json_encode($receiver_list);
                $notification['link'] = 'receipt/receipt_list';
                $notification['Message'] = date('d-M-Y', strtotime($input['receipt_bill']['due_date'])) . ' is due date for payment';
                $this->notification_model->insert_notification($notification);
            }
            $input_comp = $this->input->post();
            if (!empty($input_comp['receipt_bill'])) {

                unset($input_comp['receipt_bill']['terms']);
                unset($input_comp['receipt_bill']['ac_no']);
                unset($input_comp['receipt_bill']['branch']);
                unset($input_comp['receipt_bill']['dd_no']);
                unset($input_comp['receipt_bill']['due_date']);
                unset($input_comp['receipt_bill']['discount_per']);
                unset($input_comp['receipt_bill']['discount']);
                unset($input_comp['balance']);
                $input_comp['receipt_bill']['receiver_type'] = "Sales Reciver";
                $input_comp['receipt_bill']['type'] = "credit";
                $input_comp['receipt_bill']['receipt_id'] = $input_comp['receipt_bill']['receipt_no'];
                unset($input_comp['receipt_bill']['receipt_no']);
                // echo"<pre>"; print_r($input_comp); exit;
                $insert_agent_cash = $this->receipt_model->insert_agent_amount($input_comp['receipt_bill']);
                if ($input_comp['receipt_bill']['recevier'] == 'company') {
                    $company_amount = $this->admin_model->get_company_amount();
                    $amount = $company_amount[0]['value'] + $input_comp['receipt_bill']['bill_amount'];
                    $this->admin_model->update_company_amount($amount);
                }
            }

            redirect($this->config->item('base_url') . 'receipt/receipt_list');
        }
        $data["last_id"] = $this->master_model->get_last_id('rp_code');
        $data['all_agent'] = $this->agent_model->get_agent();
        $data['receipt_details'] = $this->receipt_model->get_receipt_by_id($r_id);
        $this->template->write_view('content', 'update_receipt', $data);
        $this->template->render();
    }

    public function view_receipt($r_id) {
        $this->load->model('receipt/receipt_model');
        if ($this->input->post()) {
            $input = $this->input->post();

            if ($input['balance'] == 0 || $input['balance'] == 0.00 || $input['balance'] == '0.00')
                $receipt_status = 'Completed';
            else
                $receipt_status = 'Pending';

            $this->receipt_model->update_invoice(array('payment_status' => $receipt_status), $input['receipt_bill']['receipt_id']);
            $this->receipt_model->insert_receipt_bill($input['receipt_bill']);
            redirect($this->config->item('base_url') . 'receipt/receipt_list');
        }
        $data['all_agent'] = $this->agent_model->get_agent();
        $data['receipt_details'] = $this->receipt_model->get_receipt_by_id($r_id);
        $this->template->write_view('content', 'view_receipt', $data);
        $this->template->render();
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
