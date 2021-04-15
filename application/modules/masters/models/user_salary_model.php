<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Reference_model
 *
 * This model represents user salary details. It operates the following tables:
 * - user_salary,
 *
 * @package	Payroll
 * @author	Vathsala
 */ 
 
class User_salary_model extends CI_Model{

    private $table_name	= 'user_salary';	

	function __construct()
	{
		parent::__construct();
 
	} 
	
	/**
	 * Get all user salary for users
	 *
	 * @return	array
	 */ 
	function get_all_user_salary()
	{
		
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	}
	
	/**
	 * Get user_salary by user id (user id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_user_salary_by_user_id($user_id,$date=null)
	{
		$this->db->limit(1);
		$this->db->select($this->table_name.'.*');
		$this->db->select('salary_group.name');
		$this->db->where('user_id', $user_id);
		if($date==null)
			$this->db->where('DATE(revised_date) <=',date('Y-m-d'));
		else
			$this->db->where('DATE(revised_date) <=',date('Y-m-d',strtotime($date)));
		$this->db->order_by('revised_date','desc');
		$this->db->order_by('id','desc');
		$this->db->join('salary_group','salary_group.id='.$this->table_name.'.salary_group');
		$query = $this->db->get($this->table_name);
		//echo $this->db->last_query();exit;
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}

	/**
	 * Get all user_salary by user id (user id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_all_user_salary_by_user_id($user_id)
	{
		$this->db->select($this->table_name.'.*');
		
		$this->db->select('salary_group.name');
		
		$this->db->where('user_id', $user_id);
		
		$this->db->order_by('DATE(revised_date)');
		
		$this->db->join('salary_group','salary_group.id='.$this->table_name.'.salary_group','left');
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
/**
	 * Get distinct user_salary by user id (user id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_distinct_user_salary_by_user_id($user_id)
	{
		$this->db->select('distinct(basic)');
		$this->db->where('user_id', $user_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	/**
	 * Insert new user salary
	 *
	 * @param	array
	 * @param	bool
	 * @return	id
	 */
	function insert_user_salary($data)
	{
		if ($this->db->insert($this->table_name, $data)) {
		
			$sal_id = $this->db->insert_id();
			
			return $sal_id;
		}
		return false;
	}
	
	/**
	 * Update user salary by user id
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_user_salary_by_user_id($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		
		if ($this->db->update($this->table_name, $data)) {
			
			return true;
		}
		return false;
	}
	
	/**
	 * Update user salary by user id and date
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_user_salary_by_user_id_and_date($user_id, $date,$data)
	{
		$this->db->where('user_id', $user_id);
		
		$this->db->where('DATE(revised_date)', $date);
		
		if ($this->db->update($this->table_name, $data)) {
			
			return true;
		}
		return false;
	}
	/**
	 * Update user salary by salary id
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_user_salary_by_salary_id($salary_id, $data)
	{
		$this->db->where('id', $salary_id);
		
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
	function delete_user_salary_by_user_id($user_id)
	{
		$this->db->where('user_id', $user_id);
		
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows() > 0) {
		
			return true;
			
		}
		return false;
	}
	/*Get user salary type by user id*/
	function get_user_salary_type_by_user_id($user_id)
	{
		$this->db->select('type');
		
		$this->db->where('user_id', $user_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	/*Get user revised user salary type by user id*/
	function get_revised_user_salary_by_user_id($user_id)
	{
		$this->db->limit(1);
		$this->db->where('user_id', $user_id);
		$this->db->where('DATE(revised_date) >',date('Y-m-d'));
		$this->db->order_by('id','desc');
		$this->db->where('user_id', $user_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() == 1) {
			return $query->result_array();
		}
		return false;
	}
	/*function to get revised salary by salary id*/
	function get_revised_user_salary_by_revised_id($rev_id)
	{

		$this->db->where('id', $rev_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() == 1) {
			return $query->result_array();
		}
		return false;
	}
}