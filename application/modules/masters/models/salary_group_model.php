<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Users_model
 *
 * This model represents Salary group. It operates the following tables:
 * - shift,
 *
 * @package	Payroll
 * @author	Vathsala
 */ 
 
class Salary_group_model extends CI_Model{

    private $table_name	= 'salary_group';	
	
	private $associate = 'salary_group_split';

	function __construct()
	{
		parent::__construct();
 		
		$ci =& get_instance();
	} 
	
	/**
	 * Get all salary_groups
	 *
	 * @return	array
	 */ 
	function get_all_salary_groups()
	{
		
		$this->db->where('status',1);
		
		$this->db->order_by("name", "asc");
		
		$query = $this->db->get($this->table_name);
		
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	}
	/**
	 * Get all salary_groups except id
	 *
	 * @return	array
	 */ 
	function get_all_salary_groups_except($id)
	{
		
		$this->db->where('id !=',$id);
		$this->db->where('status',1);
		$query = $this->db->get($this->table_name);
		
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	}
	/**
	 * Get all salary_groups
	 *
	 * @return	array
	 */ 
	function get_all_salary_groups_by_limit($limit,$start,$filter=null)
	{
		
		$this->db->limit($limit, $start);
		
		if(isset($filter["sort"])&& !empty($filter["sort"]))
		{
			$this->db->order_by($filter["sort"], $filter["order"]);
		
		}
		$this->db->where('status',1);
		
		$query = $this->db->get($this->table_name);
		
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	}
	/**
	 * Get salary_group by id 
	 *
	 * @param	int
	 * @return	array
	 */
	function get_salary_group_by_id($id)
	{
		
		$this->db->where('id', $id);
		
		$this->db->where('status',1);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() == 1) {
			return $query->result_array();
		}
		return false;
	}

	
	/**
	 * Insert new salary_group
	 *
	 * @param	array
	 * @param	bool
	 * @return	id
	 */
	function insert_salary_group($data)
	{
		if ($this->db->insert($this->table_name, $data)) {
		
			$id = $this->db->insert_id();
			
			return $id;
		}
		return false;
	}
	
	/**
	 * Update  salary_group
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_salary_group($id, $data)
	{
		$this->db->where('id', $shift_id);
		
		if ($this->db->update($this->table_name, $data)) {
			
			return true;
		}
		return false;
	}
	
	/**
	 * Delete salary_group
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_salary_group($id)
	{
		$this->db->where('id', $id);
		
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows() > 0) {
		
			return true;
			
		}
		return false;
	}
		/**
		*Get salary groups count*/
	function get_salary_group_count()
	{
		$this->db->select('count(*) as count');
		
		$this->db->where('status',1);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	/*Insert salary group details*/
	function insert_salary_group_details($data)
	{
		if ($this->db->insert($this->associate, $data)) {
		
			$id = $this->db->insert_id();
			
			return $id;
		}
		return false;
	
	}
	/*Get salary splits by salary group id**/
	function get_salary_group_split_by_salary_group_id($salary_group_id)
	{
		
		$this->db->select($this->associate.'.*');
		
		$this->db->where($this->associate.'.salary_group_id',$salary_group_id);
	
		$query = $this->db->get($this->associate);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	//Delete Salary split details by salary group id
	function delete_split_details_by_salary_group_id($salary_group_id)
	{
		$this->db->where('salary_group_id', $salary_group_id);
		
		$this->db->delete($this->associate);
		
		if ($this->db->affected_rows() > 0) {
		
			return true;
			
		}
		return false;
	}
	//function to update status for salary group
	function update_status_by_salary_group_id($salary_group_id)
	{
	
		$this->db->set('status',0);
		
		$this->db->where('id',$salary_group_id);
		if ($this->db->update($this->table_name)) {
			//echo $this->db->last_query();
			
			return true;
		}
		return false;
	
	}
	function check_salary_group_exist($group_name,$group_id=NULL)
	{
		$this->db->select('id');
		
		$this->db->where('LOWER(name)',trim(strtolower($group_name)));
		
		if(isset($group_id)&& $group_id!=NULL)
		
			$this->db->where('id !=',$group_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	
	}
}