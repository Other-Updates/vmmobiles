<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Reference_model
 *
 * This model represents user department details. It operates the following tables:
 * - user_department,
 *
 * @package	Payroll
 * @author	Vathsala
 */ 
 
class User_department_model extends CI_Model{

    private $table_name	= 'user_department';	
	
	private $associate1 = 'department';
	
	private $associate2 = 'designation';

	function __construct()
	{
		parent::__construct();
 
	} 
	
	/**
	 * Get all departments for users
	 *
	 * @return	array
	 */ 
	function get_all_departments()
	{
		
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	}
	
	/**
	 * Get department by user id (user id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_department_by_user_id($user_id)
	{
		$this->db->select($this->associate1.'.name as dep_name');
		$this->db->select($this->associate2.'.name as des_name');
		//$this->db->select($this->associate1.'.ot_applicable');
		//$this->db->select($this->associate1.'.shift_id');
		$this->db->select($this->table_name.'.*');
		$this->db->where($this->table_name.'.user_id', $user_id);
		$this->db->join($this->associate1,$this->associate1.'.id='.$this->table_name.'.department','left');
		$this->db->join($this->associate2,$this->associate2.'.id='.$this->table_name.'.designation','left');
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}

	
	/**
	 * Insert new user department
	 *
	 * @param	array
	 * @param	bool
	 * @return	id
	 */
	function insert_user_department($data)
	{
		if ($this->db->insert($this->table_name, $data)) {
		
			$dep_id = $this->db->insert_id();
			
			return $dep_id;
		}
		return false;
	}
	
	/**
	 * Update user department by user id
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_user_department_by_user_id($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		
		if ($this->db->update($this->table_name, $data)) {
			
			return true;
		}
		return false;
	}
	
	/**
	 * Delete user department by user id
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_user_department_by_user_id($user_id)
	{
		$this->db->where('user_id', $user_id);
		
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows() > 0) {
		
			return true;
			
		}
		return false;
	}
	
	/*Get designations by department id*/
	function get_designations_by_department_id($dept_id)
	{
		$this->db->select($this->associate2.'.name as des_name');
		$this->db->select($this->table_name.'.*');
		if(isset($dept_id)&& !empty($dept_id))
		{
			$this->db->where_in($this->table_name.'.department', $dept_id);
		}
		$this->db->join($this->associate1,$this->associate1.'.id='.$this->table_name.'.department','left');
		$this->db->join($this->associate2,$this->associate2.'.id='.$this->table_name.'.designation','left');
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	
	/*Get dept id of user*/
	function get_user_dept_id($user_id)
	{
		$this->db->select('department');
		$this->db->where('user_id',$user_id);
		$query = $this->db->get($this->table_name);
		if($query->num_rows>=1)
		{
			return $query->result_array();
		}
		return false;	
	}
	
	/*Get degn id of user*/
	function get_user_degn_id($user_id)
	{
	
		$this->db->select('designation');
		$this->db->where('user_id',$user_id);
		$query = $this->db->get($this->table_name);	
		if($query->num_rows>=1)
		{
			return $query->result_array();
		}
		return false;	
	}
	
	/*Get list of users id*/
	function get_list_of_user_id($dept_id)
	{
		$this->db->select('user_id');
		$this->db->where_in('department',$dept_id);
		$query = $this->db->get($this->table_name);
		if($query->num_rows>=1)
		{
			 return $query->result_array();
		}
		return false;
	}
	/*Get Department head  of user*/
	function get_user_dept_head_by_userid($user_id)
	{
		$this->db->select($this->table_name.'.department');
		
		$this->db->select('department.department_head');
		
		$this->db->select('users.email');
		
		$this->db->select("CONCAT_WS(' ', users.first_name, users.last_name ) AS head_name");
		
		$this->db->where($this->table_name.'.user_id',$user_id);
		
		$this->db->join('department','department.id='.$this->table_name.'.department','left');
		
		$this->db->join('users','users.id=.department.department_head','left');
		
		$query = $this->db->get($this->table_name);
		
		if($query->num_rows>=1)
		{
			return $query->result_array();
		}
		return false;	
	}
	
}