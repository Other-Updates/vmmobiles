<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Reference_model
 *
 * This model represents Reference details. It operates the following tables:
 * - reference_details,
 *
 * @package	Payroll
 * @author	Vathsala
 */ 
 
class Reference_model extends CI_Model{

    private $table_name	= 'reference_details';	

	function __construct()
	{
		parent::__construct();
 
	} 
	
	/**
	 * Get all references
	 *
	 * @return	array
	 */ 
	function get_all_references()
	{
		
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	}
	
	/**
	 * Get references by user id (user id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_references_by_user_id($user_id)
	{
		
		$this->db->where('user_id', $user_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}

	
	/**
	 * Insert new reference
	 *
	 * @param	array
	 * @param	bool
	 * @return	array
	 */
	function insert_reference($data)
	{
		if ($this->db->insert($this->table_name, $data)) {
		
			$ref_id = $this->db->insert_id();
			
			return $ref_id;
		}
		return false;
	}
	
	/**
	 * Update reference by user id
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_reference_by_user_id($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		
		if ($this->db->update($this->table_name, $data)) {
			
			return true;
		}
		return false;
	}
	
	/**
	 * Delete reference by user id
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_reference_by_user_id($user_id)
	{
		$this->db->where('user_id', $user_id);
		
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows() > 0) {
		
			return true;
			
		}
		return false;
	}
	
}