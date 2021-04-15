<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Reference_model
 *
 * This model represents user available leaves details. It operates the following tables:
 * - available_leaves,
 *
 * @package	Payroll
 * @author	Vathsala
 */ 
 
class Available_leaves_model extends CI_Model{

    private $table_name	= 'available_leaves';	

	function __construct()
	{
		parent::__construct();
 
	} 
	
	/**
	 * Get all  available leaves for users
	 *
	 * @return	array
	 */ 
	function get_all_user_leaves()
	{
		
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	}
	
	/**
	 * Get user_leaves by user id (user id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_user_leaves_by_user_id($user_id)
	{
		if(gettype($user_id)=="array")
		
			$this->db->where_in('user_id', $user_id);
		else
			
			$this->db->where('user_id', $user_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}

	
	/**
	 * Insert new user leaves
	 *
	 * @param	array
	 * @param	bool
	 * @return	id
	 */
	function insert_user_leaves($data)
	{
		if ($this->db->insert($this->table_name, $data)) {
		
			$leave_id = $this->db->insert_id();
			
			return $leave_id;
		}
		return false;
	}
	
	/**
	 * Update user leaves by user id
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_user_leaves_by_user_id($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		
		if ($this->db->update($this->table_name, $data)) {
			
			return true;
		}
		return false;
	}
	
	/**
	 * Delete user leaves by user id
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_user_leaves_by_user_id($user_id)
	{
		$this->db->where('user_id', $user_id);
		
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows() > 0) {
		
			return true;
			
		}
		return false;
	}
	function get_user_leaves_by_type($user_id,$type)
	{
		if($type=="casual leave" )
			$this->db->select('available_casual_leave');
		else if($type =="sick leave")
			$this->db->select('available_sick_leave');
		else if($type =="permission")
			$this->db->select('permission');
		else if($type =="comp_off")
			$this->db->select('comp_off');
		else if($type =="available_earned_leave" || $type =="earned leave" )
			$this->db->select('available_earned_leave');
		$this->db->where('user_id', $user_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	
	}
	function update_user_leaves_by_type($user_id,$type,$val)
	{
		
		if($type =="sick leave" || $type==1)
			$this->db->set('available_sick_leave',$val);
		if($type=="casual leave" || $type==2)
			$this->db->set('available_casual_leave',$val);
		else if($type =="permission" || $type==3)
			$this->db->set('permission',$val);
		else if($type =="compoff" || $type==4)
			$this->db->set('comp_off',$val);
		else if($type =="earned leave" || $type==6 || $type =="available_earned_leave")
			$this->db->set('available_earned_leave',$val);
		$this->db->where('user_id',$user_id);
		if ($this->db->update($this->table_name)) {
			
			return true;
		}
		return false;
	
	}
	/**
	 * Update available earned leaves for each user using cron
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_available_earned_leaves_by_user_id($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		
		if ($this->db->update($this->table_name, $data)) {
			
			return true;
		}
		return false;
	}
	
}