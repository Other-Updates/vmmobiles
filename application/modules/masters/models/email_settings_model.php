<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_settings_model extends CI_Model {

    private $table_name = 'erp_email_settings';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert_email($data) {
        $this->db->insert_batch($this->table_name, $data);
        return true;
    }

    public function delete_email() {
        $this->db->truncate('erp_email_settings');
        return true;
    }

    public function get_quotation_emails() {
        $this->db->select($this->table_name . '.*');
        $query = $this->db->get($this->table_name)->result_array();
        return $query;
    }

}
