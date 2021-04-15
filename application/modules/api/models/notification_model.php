<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification_model extends CI_Model {

    private $table_name1 = 'erp_notification';

    function __construct() {
        date_default_timezone_set('Asia/Kolkata');
        parent::__construct();
    }

    public function insert_notification($data) {
        if ($this->db->insert($this->table_name1, $data)) {
            return true;
        }
        return false;
    }

    public function update_notification($data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name1, $data)) {

            return true;
        }
        return false;
    }

    public function all_notification() {
        $type_arr = array('payment', 'purchase_payment');
        if ($this->user_auth->is_section_allowed('purchase', 'purchase_request')) {
            $this->db->where('type', 'min_qty');
        } else {
            $type_arr = array('payment', 'purchase_payment', 'purchase_request');
        }
        $this->db->select('*');
        $this->db->where('status', 0);
        $this->db->where_not_in('type', $type_arr);
        $this->db->order_by("notification_date", 'asc');
        $query = $this->db->get($this->table_name1)->result_array();

        $user_info = $this->user_auth->get_from_session('user_info');
        $count = $count++;
        if (!empty($query)) {
            foreach ($query as $val) {
               
                if (in_array($user_info[$count++])) {
                    $count++;
                }
            }
            $query['total_count'] = $count;
        }
        return $query;
    }

    public function get_receivable_notification() {
        /* $current_date = date('Y-m-d');
          $this->db->select('erp_notification.*');
          $this->db->where('erp_notification.status',0);
          $this->db->where('erp_notification.type','purchase_payment');
          $this->db->select('purchase_receipt_bill.due_date');
          $this->db->join('purchase_receipt_bill','purchase_receipt_bill.due_date= erp_notification.notification_date');
          $this->db->where("DATE_FORMAT(notification_date,'%Y-%m-%d') <= purchase_receipt_bill.due_date" );
          $this->db->where("DATE_FORMAT(notification_date,'%Y-%m-%d') >= DATE_SUB(purchase_receipt_bill.due_date, INTERVAL 4 DAY)" );
          $this->db->where("DATE_FORMAT(notification_date,'%Y-%m-%d') >= '".$current_date."'"  );
          $query = $this->db->get('erp_notification')->result_array();
          return $query; */
        $current_date = date('Y-m-d');
        $this->db->select('*');
        $this->db->where('status', 0);
        $this->db->where('type', 'purchase_payment');
        $this->db->where('DATE_FORMAT(notification_date,"%Y-%m-%d") <= "' . $current_date . '"');
        //$this->db->where('DATE_FORMAT(due_date,"%Y-%m-%d") <= "' . $current_date . '"');
        $this->db->order_by("notification_date", 'asc');
        $query = $this->db->get($this->table_name1)->result_array();
        $user_info = $this->user_auth->get_from_session('user_info');
        $count = 0;
        if (!empty($query)) {
            foreach ($query as $val) {
                $receiver_list = json_decode($val['receiver_id']);
                if (in_array($user_info[0][role], $receiver_list)) {
                    $count++;
                }
            }
            $query['total_count'] = $count;
        }
        return $query;
    }

    public function get_stayable_notification() {
        /* $current_date = date('Y-m-d');
          $this->db->select('erp_notification.*');
          $this->db->where('erp_notification.status',0);
          $this->db->where('erp_notification.type','payment');
          $this->db->select('receipt_bill.due_date');
          $this->db->join('receipt_bill','receipt_bill.due_date= erp_notification.notification_date');
          //$this->db->where("DATE_FORMAT(notification_date,'%Y-%m-%d') <= receipt_bill.due_date" );
          $this->db->where("notification_date >= DATE_SUB(receipt_bill.due_date, INTERVAL 2 DAY)" , NULL, FALSE);
          //$this->db->where("DATE_SUB(receipt_bill.due_date, INTERVAL 2 DAY) >= '".$current_date."'"  );
          $query = $this->db->get('erp_notification')->result_array();
          return $query; */
        $current_date = date('Y-m-d');
        $this->db->select('*');
        $this->db->where('status', 0);
        $this->db->where('type', 'payment');
        $this->db->where('DATE_FORMAT(notification_date,"%Y-%m-%d") <= "' . $current_date . '"');
        //$this->db->where('DATE_FORMAT(due_date,"%Y-%m-%d") <= "' . $current_date . '"');
        $this->db->order_by("notification_date", 'asc');
        $query = $this->db->get($this->table_name1)->result_array();
        $user_info = $this->user_auth->get_from_session('user_info');
        $count = 0;
        if (!empty($query)) {
            foreach ($query as $val) {
                $receiver_list = json_decode($val['receiver_id']);
                if (in_array($user_info[0][role], $receiver_list)) {
                    $count++;
                }
            }
            $query['total_count'] = $count;
        }
        return $query;
    }

}

?>