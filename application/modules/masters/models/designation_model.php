<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Users_model
 *
 * This model represents Designation. It operates the following tables:
 * - department,
 *
 * @package	Payroll
 * @author	Vathsala
 */ 
 
class Designation_model extends CI_Model{

    private $table_name	= 'designation';	

	function __construct()
	{
		parent::__construct();
 		
		$ci =& get_instance();
	} 
	
	/**
	 * Get all Designations
	 *
	 * @return	array
	 */ 
	function get_all_designations()
	{
	
		$this->db->order_by("name", "asc");
					
		$query = $this->db->get($this->table_name);	
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	}
	
	/**
	 * Get all Designations except id
	 *
	 * @return	array
	 */ 
	function get_all_designations_except($id)
	{
		
		$this->db->where('id !=',$id);	
		$query = $this->db->get($this->table_name);
		
	
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	}
	/**
	 * Get all Designations by limit
	 *
	 * @return	array
	 */ 
	function get_all_designations_by_limit($limit,$start,$filter)
	{
		
		$this->db->limit($limit, $start);
		
		if(isset($filter["sort"])&& !empty($filter["sort"]))
		{
			$this->db->order_by($filter["sort"], $filter["order"]);
		
		}
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	}
	/**
		*Get designation count*/
	function get_designation_count()
	{
		$this->db->select('count(*) as count');
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	/**
	 * Get Designation by id 
	 *
	 * @param	int
	 * @return	array
	 */
	function get_designation_by_id($des_id)
	{
		
		$this->db->where('id', $des_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() == 1) {
			return $query->result_array();
		}
		return false;
	}

	
	/**
	 * Insert new Designation
	 *
	 * @param	array
	 * @param	bool
	 * @return	id
	 */
	function insert_designation($data)
	{
		if ($this->db->insert($this->table_name, $data)) {
		
			$des_id = $this->db->insert_id();
			
			return $des_id;
		}
		return false;
	}
	
	/**
	 * Update  designation
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_designation($des_id, $data)
	{
		$this->db->where('id', $des_id);
		
		if ($this->db->update($this->table_name, $data)) {
			
			return true;
		}
		return false;
	}
	
	/**
	 * Delete designation
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_designation($des_id)
	{
		$this->db->where('id', $des_id);
		
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows() > 0) {
		
			return true;
			
		}
		return false;
	}
	
	function check_designation_exist($des_name,$des_id=NULL)
	{
		$this->db->select('id');
		
		$this->db->where('LOWER(name)',trim(strtolower($des_name)));
		
		if(isset($des_id)&& $des_id!=NULL)
		
			$this->db->where('id !=',$des_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	
	}
}