<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Language_model
 *
 * This model represents  languages_known. It operates the following tables:
 * - languages_known,
 *
 * @package	Payroll
 * @author	Vathsala
 */ 
 
class Language_model extends CI_Model{

    private $table_name	= 'languages_known';	

	function __construct()
	{
		parent::__construct();
 
	} 
	
	/**
	 * Get all languages
	 *
	 * @return	array
	 */ 
	function get_all_languages()
	{
		
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	}
	
	/**
	 * Get languagss by id (user id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_languages_by_user_id($user_id)
	{
		
		$this->db->where('user_id', $user_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}

	
	/**
	 * Insert new language
	 *
	 * @param	array
	 * @param	bool
	 * @return	id
	 */
	function insert_languages($data)
	{
		if ($this->db->insert($this->table_name, $data)) {
		
			$language_id = $this->db->insert_id();
			
			return $language_id;
		}
		return false;
	}
	
	/**
	 * Update language details by user id
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_language_by_user_id($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		
		if ($this->db->update($this->table_name, $data)) {
			
			return true;
		}
		return false;
	}
	
	/**
	 * Delete languages details by user id
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_language_by_user_id($user_id)
	{
		$this->db->where('user_id', $user_id);
		
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows() > 0) {
		
			return true;
			
		}
		return false;
	}
	
}