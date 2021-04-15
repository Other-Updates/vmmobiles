<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Weekly_task_model extends CI_Model {

    private $table_name1 = 'po';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert_quotation($data) {
        if ($this->db->insert($this->erp_project_cost, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return false;
    }

}
