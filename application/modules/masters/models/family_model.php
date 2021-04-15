<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Family_model
 *
 * This model represents family_members. It operates the following tables:
 * - family_members,
 *
 * @package	Payroll
 * @author	Vathsala
 */ 
 
class Family_model extends CI_Model{

    private $table_name	= 'family_members';	
	
	private $associate = 'nominees';
	
	private $associate2 = 'wages_share_table';

	function __construct()
	{
		parent::__construct();
 
	} 
	
	/**
	 * Get all Family members
	 *
	 * @return	array
	 */ 
	function get_all_family_members()
	{
		
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	}
	
	/**
	 * Get family members  by id (user id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_family_members_by_user_id($user_id)
	{
		
		$this->db->where('user_id', $user_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}

	
	/**
	 * Insert new family member
	 *
	 * @param	array
	 * @param	bool
	 * @return	id
	 */
	function insert_family_members($data)
	{
		if ($this->db->insert($this->table_name, $data)) {
		
			$family_id = $this->db->insert_id();
			
			return $family_id;
		}
		return false;
	}
	
	/**
	 * Update a family_members by id
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_family_members_by_user_id($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		
		if ($this->db->update($this->table_name, $data)) {
			
			return true;
		}
		return false;
	}
	
	/**
	 * Delete family members by user_id
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_family_members_by_user_id($user_id)
	{
		$this->db->where('user_id', $user_id);
		
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows() > 0) {
		
			return true;
			
		}
		return false;
	}
	/*get Family member by relation name*/
	function get_family_member_by_relation_and_user_id($user_id,$relation)
	{
		$this->db->select('name');
		
		$this->db->where('relation',$relation);
		
		$this->db->where('user_id', $user_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	
	}
	// Function to insert  noiminee details
	function insert_nominee($data)
	{
		if ($this->db->insert($this->associate, $data)) {
		
			$family_id = $this->db->insert_id();
			
			return $family_id;
		}
		return false;
	
	}
	// Function to delete nominee details by user_id
	function delete_nominees_by_user_id($user_id)
	{
		$this->db->where('user_id', $user_id);
		
		$this->db->delete($this->associate);
		
		if ($this->db->affected_rows() > 0) {
		
			return true;
			
		}
		return false;
	}
	/**
	 * Get nominees  by user id (user id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_nominees_by_user_id($user_id)
	{
		
		$this->db->where('user_id', $user_id);
		
		$query = $this->db->get($this->associate);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	/* Get all nominees details with user id*/
	function get_all_nominee_details_by_user_id($user_id)
	{
		$this->db->select('*');
	
		$this->db->join($this->table_name,$this->table_name.'.id='.$this->associate.'.family_member_id','left');
		
		$this->db->where($this->associate.'.user_id', $user_id);
		
		$query = $this->db->get($this->associate);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	
	}
	/*Get spouse name by user id*/
	function get_spouse_name_by_user_id($user_id)
	{
		$relation=array('husband','wife');
		
		$this->db->select('name');
	
		$this->db->where_in('LOWER(relation)',$relation);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	
	
	}
	/*Get relation name by family member id*/
	function get_relation_name_by_family_id($f_id)
	{
		$this->db->select('relation,name');
		
		$this->db->where($this->table_name.'.id', $f_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() == 1) {
			return $query->result_array();
		}
		return false;
	
	
	
	}
	/*Insert in wages share */
	function insert_wages_share($data)
	{
		if ($this->db->insert($this->associate2, $data)) {
		
			$family_id = $this->db->insert_id();
			
			return $family_id;
		}
		return false;
	}
	/*Update wages share by user id*/
	function update_wages_share($user_id,$data)
	{
		$this->db->where('user_id', $user_id);
		
		if ($this->db->update($this->associate2, $data)) {
			
			return true;
		}
		return false;
	}
	/*Get wages share by user id*/
	function get_wages_share_by_user_id($user_id)
	{
		$this->db->where($this->associate2.'.user_id', $user_id);
		
		$query = $this->db->get($this->associate2);
		
		if ($query->num_rows() == 1) {
			return $query->result_array();
		}
		return false;
	
	}
	/**
	 * Delete family members by user_id
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_wages_share_by_user_id($user_id)
	{
		$this->db->where('user_id', $user_id);
		
		$this->db->delete($this->associate2);
		
		if ($this->db->affected_rows() > 0) {
		
			return true;
			
		}
		return false;
	}
}