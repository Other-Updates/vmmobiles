<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User_roles_model
 *
 * This model represents User roles. It operates the following tables:
 * - user_roles,
 *
 * @package	Payroll
 * @author	Anandhakumar
 */ 
 
class User_roles_model extends CI_Model{

    private $table_name	= 'user_roles';	
	
	private $length ;

	function __construct()
	{
		parent::__construct();
	} 

	/**
	 * Get user role by id
	 *
	 * @param	int
	 * @return	array
	 */ 
	function get_user_role($user_id)
	{
		
		$this->db->where('user_id', $user_id);
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
		}
		return false;
	}
	
	/**
	 * Insert new user role
	 *
	 * @param	array
	 * @return	id
	 */
	function insert_user_role($user_id,$data)
	{

		if($this->get_user_role($user_id)) {

			return $this->update_user_role($user_id,$data);

		} else {

			$data["user_id"] = $user_id;
			if ($this->db->insert($this->table_name, $data)) {
			
				$sal_id = $this->db->insert_id();
				
				return true;
			}
			return false;
		}
	}

	/**
	 * Update user shift by user id
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_user_role($user_id, $data)
	{

		$this->db->where('user_id', $user_id);
		
		if ($this->db->update($this->table_name, $data)) {
			
			if ($this->db->affected_rows() > 0) {
				return true;
			}
		}
		return false;
	}

}