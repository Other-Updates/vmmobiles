<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *Address_model
 *
 * This model represents  address. It operates the following tables:
 * - languages_known,
 *
 * @package	Payroll
 * @author	Vathsala
 */ 
 
class Address_model extends CI_Model{

    private $table_name	= 'address';	

	function __construct()
	{
		parent::__construct();
 
	} 
	
	/**
	 * Get all address
	 *
	 * @return	array
	 */ 
	function get_all_address()
	{
		
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	}
	
	/**
	 * Get address by id (user id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_address_by_user_id($user_id)
	{
		
		$this->db->where('user_id', $user_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}

	
	/**
	 * Insert new user address
	 *
	 * @param	array
	 * @param	bool
	 * @return	id
	 */
	function insert_address($data)
	{
		if ($this->db->insert($this->table_name, $data)) {
		
			$address_id = $this->db->insert_id();
			
			return $address_id;
		}
		return false;
	}
	
	/**
	 * Update address details by user id
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_address_by_user_id($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		
		if ($this->db->update($this->table_name, $data)) {
			
			return true;
		}
		return false;
	}
	
	/**
	 * Delete address details by user id
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_address_by_user_id($user_id)
	{
		$this->db->where('user_id', $user_id);
		
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows() > 0) {
		
			return true;
			
		}
		return false;
	}
	/*function to get address by type*/
	function get_address_by_user_id_by_type($user_id,$type)
	{
	
		$this->db->where('user_id', $user_id);
		
		$this->db->where('type',$type);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	
	}
}