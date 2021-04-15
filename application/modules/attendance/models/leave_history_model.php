<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Reference_model
 *
 * This model represents user leave_history details. It operates the following tables:
 * - leave_history,
 *
 * @package	Payroll
 * @author	Vathsala
 */ 
 
class Leave_history_model extends CI_Model{

    private $table_name	= 'leave_history';	

	function __construct()
	{
		parent::__construct();
 
	} 
	
	/**
	 * Get all  available leave_history for users
	 *
	 * @return	array
	 */ 
	function get_all_user_leave_history()
	{
		
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	}
	
	/**
	 * Get user_leave_history by user id (user id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_user_leave_history_by_user_id($user_id)
	{
		$this->db->select($this->table_name.'.*');
		
		$this->db->select('users.id as user_id,users.employee_id,users.first_name');
		
		$this->db->select('u2.first_name as changed_by_name');
		
		$this->db->select('department.id as dept');
		
		//$this->db->select('department.shift_id as shift');
		
		//$this->db->select('department.ot_applicable');
		
		$this->db->select('department.name as dept_name');
		
		$this->db->select('designation.name as des_name');
		
		$this->db->join('users','users.id='.$this->table_name.'.user_id','left');
		
		$this->db->join('user_department','user_department.user_id=users.id','left');
		
		$this->db->join('department','department.id=user_department.department','left');
		
		$this->db->join('designation','designation.id=user_department.designation','left');
		
		$this->db->join('users u2','u2.id='.$this->table_name.'.changed_by','left');
	
		$this->db->order_by($this->table_name.'.id','desc');
		
		$this->db->where($this->table_name.'.user_id', $user_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}

	
	/**
	 * Insert new user leave_history
	 *
	 * @param	array
	 * @param	bool
	 * @return	id
	 */
	function insert_user_leave_history($data)
	{
		if ($this->db->insert($this->table_name, $data)) {
		
			$leave_id = $this->db->insert_id();
			
			return $leave_id;
		}
		return false;
	}
	
	/**
	 * Update user leave_history by user id
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_user_leave_history_by_user_id($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		
		if ($this->db->update($this->table_name, $data)) {
			
			return true;
		}
		return false;
	}
	
	/**
	 * Delete user leave_history by user id
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_user_leave_history_by_user_id($user_id)
	{
		$this->db->where('user_id', $user_id);
		
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows() > 0) {
		
			return true;
			
		}
		return false;
	}
	function get_user_id_from_leave_history()
	{
	   $this->db->select('DISTINCT(user_id)');
	   $query = $this->db->get($this->table_name);
	   if($query->num_rows() >=1)
	   {
	   return $query->result_array();
	   }
	   return false;
	}
	function get_leave_history_by_userid($user_id)
	{
	   $this->db->select('*');
	    $this->db->where('user_id',$user_id);
	   $query = $this->db->get($this->table_name);
	   if($query->num_rows() >=1)
	   {
	   return $query->result_array();
	   }
	   return false;
	}
	function get_leave_history_by_userid_and_without_earned_leave($user_id)
	{
	   $type = 'earned leave';
	   $this->db->select('*');
	   $this->db->where('user_id',$user_id);
	   $this->db->where('leave_type !=',$type);
	   $query = $this->db->get($this->table_name);
	   //echo $this->db->last_query();
	   if($query->num_rows() >=1)
	   {
	   return $query->result_array();
	   }
	   return false;
	}
}