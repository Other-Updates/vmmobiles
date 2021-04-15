<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Leave_updated_model
 *
 * This model represents Leave updated date for user. It operates the following tables:
 * - leave_updated,
 *
 * @package	Payroll
 * @author	Vathsala
 */ 
 
class Leave_updated_model extends CI_Model{

    private $table_name	= 'leave_updated';	
	
	private $length ;

	function __construct()
	{
		parent::__construct();
		
		$ci =& get_instance();	
		
	}
	
	function get_all_users()
	{
			$this->db->select($this->table_name.'.*,users.id');
			$this->db->join($this->table_name,$this->table_name.'.user_id=users.id','left');
			$this->db->where('users.status',1);
			$query = $this->db->get('users');
			
			if ($query->num_rows() >= 1) 
			{		
				//print_r($query->result_array());
				return $query->result_array();			
			}
			return false;
	}		

	function insert_leave_updated_date_for_user($data)
	{
		
		if ($this->db->insert($this->table_name, $data)) {
		
			$user_id = $this->db->insert_id();
			
			return $user_id;
		}
		return false;
	}
	
	function update_leave_update_by_user_id($user_id,$data)
	{
		$this->db->where('user_id',$user_id);
		
		if($this->db->update($this->table_name, $data)) 
		{			
			return true;
		}
		return false;
	}
}