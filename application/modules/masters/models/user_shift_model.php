<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Reference_model
 *
 * This model represents user shift details. It operates the following tables:
 * - user_shift,
 *
 * @package	Payroll
 * @author	Vathsala
 */ 
 
class User_shift_model extends CI_Model{

    private $table_name	= 'user_shift';	

	function __construct()
	{
		parent::__construct();
 
	} 
	
	/**
	 * Get all user shift for users
	 *
	 * @return	array
	 */ 
	function get_all_user_shift()
	{
		
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	}
	
	/**
	 * Get user_current shift by user id (user id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_user_current_shift_by_user_id($user_id,$date=NULL)
	{
		$this->db->limit(1);
		$this->db->select($this->table_name.'.*');
		$this->db->select('shift.name');
		$this->db->where('user_id', $user_id);
		if($date==NULL)
			$this->db->where('DATE(created) <=',date('Y-m-d'));
		else
			$this->db->where('DATE(created) <=',date('Y-m-d',strtotime($date)));
		$this->db->order_by('created','desc');
		$this->db->order_by('id','desc');
		$this->db->join('shift','shift.id='.$this->table_name.'.shift_id','left');
		$query = $this->db->get($this->table_name);
		//echo $this->db->last_query();exit;
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}

	/**
	 * Get all user_shifts by user id (user id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_all_user_shift_by_user_id($user_id)
	{
		$this->db->select($this->table_name.'.*');
		
		$this->db->select('shift.name');
		
		$this->db->where('user_id', $user_id);
		
		$this->db->order_by('DATE(created)');
		
		$this->db->join('shift','shift.id='.$this->table_name.'.shift_id','left');
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}

	/**
	 * Insert new user shift
	 *
	 * @param	array
	 * @param	bool
	 * @return	id
	 */
	function insert_user_shift($data)
	{
		if ($this->db->insert($this->table_name, $data)) {
		
			$sal_id = $this->db->insert_id();
			
			return $sal_id;
		}
		return false;
	}
	
	/**
	 * Update user shift by user id
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_user_shift_by_user_id($user_id, $data)
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
	function update_user_shift_by_user_id_and_date($user_id, $date,$data)
	{
		$this->db->where('user_id', $user_id);
		
		$this->db->where('created', $date);
		
		if ($this->db->update($this->table_name, $data)) {
			
			return true;
		}
		return false;
	}
	/**
	 * Delete user shifts by user id
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_user_shift_by_user_id($user_id)
	{
		$this->db->where('user_id', $user_id);
		
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows() > 0) {
		
			return true;
			
		}
		return false;
	}
	
}