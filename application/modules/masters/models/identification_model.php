<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Roles_model
 *
 * This model represents Identification marks. It operates the following tables:
 * - roles,
 *
 * @package	Payroll
 * @author	Vathsala
 */ 
 
class Identification_model extends CI_Model{

    private $table_name	= 'identification_marks';	

	function __construct()
	{
		parent::__construct();
 
	} 
	
	/**
	 * Get all identification 
	 *
	 * @return	array
	 */ 
	function get_all_identifications()
	{
		
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	}
	
	/**
	 * Get idenifications by id (user id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_identifications_by_user_id($user_id)
	{
		
		$this->db->where('user_id', $user_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}

	
	/**
	 * Insert new identifications 
	 *
	 * @param	array
	 * @param	bool
	 * @return	id
	 */
	function insert_identification($data)
	{
		if ($this->db->insert($this->table_name, $data)) {
		
			$language_id = $this->db->insert_id();
			
			return $language_id;
		}
		return false;
	}
	
	/**
	 * Update identifications by user id
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_identification_by_user_id($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		
		if ($this->db->update($this->table_name, $data)) {
			
			return true;
		}
		return false;
	}
	
	/**
	 * Delete identifications by user id
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_identifcation_by_user_id($user_id)
	{
		$this->db->where('user_id', $user_id);
		
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows() > 0) {
		
			return true;
			
		}
		return false;
	}
	
}