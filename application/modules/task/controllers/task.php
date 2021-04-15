<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Task extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'task_manager';
        $access_arr = array (
        'task/weekly_task_report' => 'no_restriction',
        'task/daily_task_report' => 'no_restriction',
        );
        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }

//        $this->load->model('masters/sms_model');
    }

    public function weekly_task_report() {

        $this->template->write_view('content', 'task/weekly_task_report');
        $this->template->render();
    }

    public function daily_task_report() {
        $this->template->write_view('content', 'task/daily_task_report');
        $this->template->render();
    }

}

?>