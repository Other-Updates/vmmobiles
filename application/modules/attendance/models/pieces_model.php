<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *Pieces_model
 *
 * This model represents pieces details. It operates the following tables:
 * - pieces,
 *
 * @package	Payroll
 * @author	Vathsala
 */ 
 
class Pieces_model extends CI_Model{

    private $table_name	= 'pieces';	

	function __construct()
	{
		parent::__construct();
 
	} 
	
	
	
	/**
	 * Get pieces by user id (user id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_pieces_by_user_id($user_id)
	{
		
		$this->db->where('user_id', $user_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}

	
	/**
	 * Insert pieces
	 *
	 * @param	array
	 * @param	bool
	 * @return	id
	 */
	function insert_pieces($data)
	{
		if ($this->db->insert($this->table_name, $data)) {
		
			$id = $this->db->insert_id();
			
			return $id;
		}
		return false;
	}
	
	/**
	 * Update pieces
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_pieces_by_user_id($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		
		if ($this->db->update($this->table_name, $data)) {
			
			return true;
		}
		return false;
	}
	
	function delete_pieces_by_created($created)
	{
		$this->db->where('created', $created);
		
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows() > 0) {
		
			return true;
			
		}
		return false;
	}
	function get_pieces_by_month_year_and_user_id($year,$month,$user_id)
	{
		$this->db->select('SUM(pieces) as total_pieces');
		
		$this->db->where('YEAR(created)',$year);
		
		$this->db->where('MONTH(created)',$month);
		
		$this->db->where('user_id',$user_id);
	
		$query = $this->db->get($this->table_name);
		
		//echo $this->db->last_query();
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	
	}
}