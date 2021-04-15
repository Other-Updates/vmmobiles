<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron extends MX_Controller {

    function __construct() {
        parent::__construct();

        /* $main_module = 'masters';
          $access_arr = array(
          'cron/index' => array('add', 'edit', 'delete', 'view'),
          );

          if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
          redirect($this->config->item('base_url'));
          } */
        //$this->load->model('masters/cron_model');
        $this->load->model('masters/customer_model');
        $this->load->model('masters/supplier_model');
    }

    public function index() {
        $customers = $this->customer_model->get_customer();
        $suppliers = $this->supplier_model->get_vendor();
        $current_date = date('Y-m-d');
        if (!empty($customers) && count($customers) > 0) {
            foreach ($customers as $customer) {
                if ($customer['dob'] == $current_date) {
                    $sms_message = 'Dear ' . $customer['name'] . ', We Wish you a very Happy Birthday! and another year of accomplishments, opportunity, and personal growth! Have a Wonderful Life ahead!';
                    $mobile = $customer['mobil_number'];
                    echo $sms_message . '<br>';
                    echo $mobile . '<br>';
                    //$service_url = 'http://mobicomm.dove-sms.com/mobicomm//submitsms.jsp?user=Zimson&key=5caa15e419XX&mobile=+91' . $mobile . '&senderid=Zimson&accusage=2&message=' . urlencode($sms_message);
                    //$curl = curl_init($service_url);
                    //$curl_post_data = json_encode($curl_post_data);
                    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    //$curl_response = curl_exec($curl);
                    // if (curl_errno($curl)) {
                    // $error = curl_error($curl);
                    //}
                }
                if ($customer['anniversary'] == $current_date) {
                    $sms_message = 'Dear ' . $customer['name'] . ', We are so happy that you are our partner. May you get all possibilities in life to be prosperous and successful. Happy Anniversary!';
                    $mobile = $customer['mobil_number'];
                    echo $sms_message . '<br>';
                    echo $mobile . '<br>';
                    //$service_url = 'http://mobicomm.dove-sms.com/mobicomm//submitsms.jsp?user=Zimson&key=5caa15e419XX&mobile=+91' . $mobile . '&senderid=Zimson&accusage=2&message=' . urlencode($sms_message);
                    //$curl = curl_init($service_url);
                    //$curl_post_data = json_encode($curl_post_data);
                    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    //$curl_response = curl_exec($curl);
                    // if (curl_errno($curl)) {
                    // $error = curl_error($curl);
                    //}
                }
            }
        }

        if (!empty($suppliers) && count($suppliers) > 0) {
            foreach ($suppliers as $supplier) {
                if ($supplier['dob'] == $current_date) {
                    $sms_message = 'Dear ' . $customer['name'] . ', We Wish you a very Happy Birthday! and another year of accomplishments, opportunity, and personal growth! Have a Wonderful Life ahead!';
                    $mobile = $supplier['mobil_number'];
                    echo $sms_message . '<br>';
                    echo $mobile . '<br>';
                    //$service_url = 'http://mobicomm.dove-sms.com/mobicomm//submitsms.jsp?user=Zimson&key=5caa15e419XX&mobile=+91' . $mobile . '&senderid=Zimson&accusage=2&message=' . urlencode($sms_message);
                    //$curl = curl_init($service_url);
                    //$curl_post_data = json_encode($curl_post_data);
                    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    //$curl_response = curl_exec($curl);
                    // if (curl_errno($curl)) {
                    // $error = curl_error($curl);
                    //}
                }
                if ($supplier['anniversary_date'] == $current_date) {
                    $sms_message = 'Dear ' . $supplier['name'] . ', We are so happy that you are our partner. May you get all possibilities in life to be prosperous and successful. Happy Anniversary!';
                    $mobile = $supplier['mobil_number'];
                    echo $sms_message . '<br>';
                    echo $mobile . '<br>';
                    //$service_url = 'http://mobicomm.dove-sms.com/mobicomm//submitsms.jsp?user=Zimson&key=5caa15e419XX&mobile=+91' . $mobile . '&senderid=Zimson&accusage=2&message=' . urlencode($sms_message);
                    //$curl = curl_init($service_url);
                    //$curl_post_data = json_encode($curl_post_data);
                    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    //$curl_response = curl_exec($curl);
                    // if (curl_errno($curl)) {
                    // $error = curl_error($curl);
                    //}
                }
            }
        }
    }

}
