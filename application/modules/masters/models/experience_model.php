<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Experience_model
 *
 * This model represents  languages_known. It operates the following tables:
 * - languages_known,
 *
 * @package	Payroll
 * @author	Vathsala
 */ 
 
class Experience_model extends CI_Model{

    private $table_name	= 'experience';	

	function __construct()
	{
		parent::__construct();
 
	} 
	
	/**
	 * Get all experiences
	 *
	 * @return	array
	 */ 
	function get_all_experiences()
	{
		
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	}
	
	/**
	 * Get experiences by id (user id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_experiences_by_user_id($user_id)
	{
		
		$this->db->where('user_id', $user_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}

	
	/**
	 * Insert new user experiences
	 *
	 * @param	array
	 * @param	bool
	 * @return	id
	 */
	function insert_experiences($data)
	{
		if ($this->db->insert($this->table_name, $data)) {
		
			$exp_id = $this->db->insert_id();
			
			return $exp_id;
		}
		return false;
	}
	
	/**
	 * Update experiences details by user id
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_experiences_by_user_id($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		
		if ($this->db->update($this->table_name, $data)) {
			
			return true;
		}
		return false;
	}
	
	/**
	 * Delete experience details by user id
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_experiences_by_user_id($user_id)
	{
		$this->db->where('user_id', $user_id);
		
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows() > 0) {
		
			return true;
			
		}
		return false;
	}
	
}