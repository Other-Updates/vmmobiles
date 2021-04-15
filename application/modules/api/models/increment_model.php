<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Increment_model extends CI_Model {



    private $increment_table = 'increment';



    function __construct() {

        date_default_timezone_set('Asia/Kolkata');

        parent::__construct();

    }



    function get_increment_id($type, $code) {

        $prefix = '';

        $prefix = date('y') . "/" . date('m');

        $this->db->where('type', $type);

        $this->db->where('code', $code);

        $this->db->where('prefix', $prefix);

        $query = $this->db->get($this->increment_table);

        if ($query->num_rows() == 1) {

            $res = $query->result_array();

        } else {

            $res = $this->insert_increment_id($type, $code);

        }

        $entry_number = '';

        if ($type == 'TT')

            $entry_number = $res['0']['code'] . "/" . $res['0']['prefix'] . "-" . $res['0']['last_increment_id'];

        else

            $entry_number = $res['0']['code'] . "/" . $res['0']['prefix'] . "-" . $res['0']['last_increment_id'];

        return $entry_number;

    }



    function insert_increment_id($type, $code) {

        $data = array();

        $data['prefix'] = '';

        $data['prefix'] = date('y') . "/" . date('m');

        $data['type'] = $type;

        $data['code'] = $code;

        $data['last_increment_id'] = '001';

        if ($this->db->insert($this->increment_table, $data)) {

            $prefix = date('y') . "/" . date('m');

            $this->db->where('type', $type);

            $this->db->where('code', $code);

            $this->db->where('prefix', $prefix);

            $query = $this->db->get($this->increment_table);

            $data['id'] = $this->db->insert_id();

            return $query->result_array();

        }

        return false;

    }



    function update_increment_id($type, $code) {

        $prefix = '';

        $prefix = date('y') . "/" . date('m');

        $last_id = $this->get_increment_id($type, $code);

        //echo $code;

        //echo $type;

        //echo $last_id;

        // exit;

        $inc_arr = explode("-", $last_id);

        $str = $inc_arr[1];

        $str = $str + 1;

        $str = sprintf('%1$03d', $str);

        $data = array();

        $data["last_increment_id"] = $str;

        $this->db->where('type', $type);

        $this->db->where('code', $code);

        $this->db->where('prefix', $prefix);

        if ($this->db->update($this->increment_table, $data)) {

            return true;

        }

        return false;

    }



}



?>