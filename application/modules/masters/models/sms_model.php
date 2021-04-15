<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sms_model extends CI_Model {

    private $table_name = 'customer';
    private $vendor = 'vendor';

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('quotation/gen_model');
        $this->load->model('sales/project_cost_model');
        $this->load->model('purchase_order/purchase_order_model');
    }

    function send_sms($id, $type) {
        //$is_sms_allowed = $this->is_sms_allowed;
        if ($type == 'quotation') {
            $sms_info = $this->gen_model->get_all_quotation_by_id($id);
            $sms_message = 'Dear ' . $sms_info[0]['name'] . ', Thanks for registering at ' . $sms_info[0]['firm_name'] . '. Kindly find the Quotation Details below,<br>';
            $sms_message .= 'Quotation No -' . $sms_info[0]['q_no'] . '<br>';
            $sms_message .= 'SubTotal -' . $sms_info[0]['subtotal_qty'] . '<br>';
            $sms_message .= 'Tax -' . $sms_info[0]['tax'] . '<br>';
            $sms_message .= 'Discount -' . $sms_info[0]['discount'] . '<br>';
            $sms_message .= 'Total Payable -' . (($sms_info[0]['subtotal_qty'] + $sms_info[0]['tax']) - $sms_info[0]['discount']) . '<br>';
            $mobile = $sms_info[0]['mobil_number'];
            $this->send_email($sms_info[0]['email_id'], $sms_message);
        } else if ($type == 'invoice') {
            $sms_info = $this->project_cost_model->get_all_invoice_by_id($id);
            $sms_message = 'Dear ' . $sms_info[0]['name'] . ', Thanks for registering at ' . $sms_info[0]['firm_name'] . '. Kindly find the Invoice Details below,<br>';
            $sms_message .= 'Invoice No -' . $sms_info[0]['inv_id'] . '<br>';
            $sms_message .= 'SubTotal -' . $sms_info[0]['subtotal_qty'] . '<br>';
            $sms_message .= 'Tax -' . $sms_info[0]['tax'] . '<br>';
            $sms_message .= 'Transport -' . $sms_info[0]['transport'] . '<br>';
            $sms_message .= 'Labour -' . $sms_info[0]['labour'] . '<br>';
            $sms_message .= 'Total Payable -' . ($sms_info[0]['subtotal_qty'] + $sms_info[0]['tax'] + $sms_info[0]['transport'] + $sms_info[0]['labour']) . '<br>';
            $mobile = $sms_info[0]['mobil_number'];
            $this->send_email($sms_info[0]['email_id'], $sms_message);
        } else if ($type == 'purchase') {
            //$sms_info = $this->purchase_order_model->get_all_po_details_by_id($id);
            $sms_info = $this->purchase_order_model->get_all_po_by_id($id);

            $sms_message = 'We have purchased products ' . $sms_info[0]['po_no'] . ' and the details are below <br>';
            $sms_message .= 'SubTotal -' . ($sms_info[0]['subtotal_qty']) . '<br>';
            $sms_message .= 'Tax -' . $sms_info[0]['tax'] . '<br>';
            $sms_message .= 'Total Payable -' . ($sms_info[0]['net_total']) . '<br>';
            $mobile = $sms_info[0]['mobil_number'];

            $this->send_email($sms_info[0]['email_id'], $sms_message);
        }
        $service_url = 'http://bulk.sysmechsolutions.in/api/sendmsg.php?user=eetotal&pass=EeTotal@123&sender=ttbill&phone=' . $mobile . '&text=' . urlencode($sms_message) . '&priority=dnd&stype=normal';
        //$curl = curl_init($service_url);
        //$curl_post_data = json_encode($curl_post_data);
        //curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //$curl_response = curl_exec($curl);
        //if (curl_errno($curl)) {
        //$error = curl_error($curl);
        $jobs1 = curl_init();
        curl_setopt($jobs1, CURLOPT_URL, $service_url);
        curl_setopt($jobs1, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($jobs1, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($jobs1, CURLOPT_SSL_VERIFYHOST, false);
        curl_exec($jobs1);
    }

    function send_email($to, $msg) {
        $email_details = $this->gen_model->get_all_email_details();
        $this->load->model('cron/cron_model');
        $emails = $this->cron_model->get_all_email_details();
//        $this->load->library('email');
//        $config = array(
//            'protocol' => 'mail',
//            'charset' => 'utf-8',
//            'wordwrap' => FALSE,
//            'mailtype' => 'html'
//        );
//        $this->email->initialize($config);
//        $this->email->set_newline("\r\n");
//        $this->email->set_mailtype("html");
        $this->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
        $config['smtp_port'] = 465;
        $config['smtp_user'] = $emails[0]['value'];
        $config['smtp_pass'] = 'MotivationS';
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $this->email->from($email_details[1]['value'], $email_details[0]['value']);
        $this->email->to($to);
        $this->email->subject($email_details[2]['value']);
        $this->email->message($msg);
        $this->email->send();
    }

}
