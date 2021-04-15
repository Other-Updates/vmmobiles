<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * temp_data_model
 *
 * This model represents tasker temp_data. It operates the following tables:
 * - temp_data,
 *
 * @package	Payrolll
 * @author	Anandhakumar
 */
 
class temp_data_model extends CI_Model{

    private $table_name	= 'temp_data';	

	function __construct()
	{
		parent::__construct();

	}
	
	/**
	 * Get all temp_data
	 *
	 * @return	array
	 */
	function get_all_temp_data()
	{
				
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	
	/**
	 * Get temp_data by id (temp_data id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_temp_data_by_id($temp_data_id)
	{
		
		$this->db->where('id', $temp_data_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() == 1) {
			return $query->result_array();
		}
		return false;
	}
	
	
	function get_temp_data_by_type($type)
	{
		
		$this->db->where('key', $type);
		
		$this->db->where('status',1);
		
		$query = $this->db->get($this->table_name);
		//if ($query->num_rows() >= 1) {
			return $query->result_array();
		//}
		//return false;
	}
	
	/**
	 * Insert new temp_data
	 *
	 * @param	array
	 * @param	bool
	 * @return	array
	 */
	function insert_temp_data($data, $status = TRUE)
	{
		
		if(!isset($data["status"]))
			$data['status'] = $status ? 1 : 0;
		if ($this->db->insert($this->table_name, $data)) {
			$temp_data_id = $this->db->insert_id();
			
			return array('id' => $temp_data_id);
		}
		
		return false;
	}
	
	/**
	 * Update a temp_data
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_temp_data($temp_data_id, $data)
	{
		if(!isset($data["status"]))
			$data['status'] = 1;
		$this->db->where('id', $temp_data_id);
		
		if ($this->db->update($this->table_name, $data)) {
			
			return true;
		}
		return false;
	}
	
	/**
	 * Delete a temp_data
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_temp_data($temp_data_id)
	{
		$this->db->where('id', $temp_data_id);
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		return false;
	}
	function get_temp_data_by_name_and_type($temp_data,$type)
	{
		$this->db->select('id');
		
		$this->db->where('value',$temp_data);
		
		$this->db->where('key',$type);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() == 1) {
			return $query->result_array();
		}
		return false;
		
	}
	function get_temp_data_by_name($type)
	{
		$this->db->select('id,value,key');
		
		if(gettype($type)=="array")
		
			$this->db->where_in('key',$type);
		else
			$this->db->where('key',$type);
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
		
	}
	function get_temp_data_by_name_and_status($type,$status)
	{
		$this->db->select('id,value,key');
		
		$this->db->where_in('key',$type);
		
		$this->db->where('status',$status);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
		
	}
	function delete_temp_data_by_key($key)
	{
		$this->db->where_in('key', $key);
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		return false;
	}
	function get_temp_data_by_count_type($type)
	{
		$this->db->select('count(*) as count');
		
		$this->db->where('key', $type);
		
		//$this->db->where('status',1);
		
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	function get_temp_data_by_limit($limit,$start,$type)
	{
		$this->db->limit($limit,$start);
		
		$this->db->where('key', $type);
		
		//$this->db->where('status',1);
		
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	function delete_temp_data_by_id($id)
	{
		$this->db->where_in('id', $id);
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows() > 0) {
			return true;
		}
		return false;
	}
	function get_all_temp_data_except($id,$type)
	{
		$this->db->select('*');
		$this->db->where('id !=',$id);
		
		$this->db->where_in('key',$type);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
		
	}
}