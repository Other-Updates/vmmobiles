<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 * options_model

 *

 * This model represents tasker options. It operates the following tables:

 * - options,

 *

 * @package	Payroll

 * @author	Anandhkumar

 */

 

class options_model extends CI_Model{





    private $table_name	= 'options';	



	function __construct()

	{

		parent::__construct();



	}

	

	/**

	 * Get all options

	 *

	 * @return	array

	 */

	function get_all_options()

	{

				

		$query = $this->db->get($this->table_name);

		

		if ($query->num_rows() >= 1) {

			return $query->result_array();

		}

		return false;

	}

	

	/**

	 * Get options by id (options id)

	 *

	 * @param	int

	 * @return	array

	 */

	function get_options_by_id($options_id)

	{

		

		$this->db->where('id', $options_id);

		

		$query = $this->db->get($this->table_name);

		

		if ($query->num_rows() == 1) {

			return $query->result_array();

		}

		return false;

	}

	

	

	function get_options_by_type($type)

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

	 * Insert new options

	 *

	 * @param	array

	 * @param	bool

	 * @return	array

	 */

	function insert_options($data, $status = TRUE)

	{
		$this->db->order_by('id','desc');
		$get_data=$this->db->get('options')->result_array();
		if(count($get_data)>0)
		{
		  $id=$get_data[0]['id']+1;
		}else
		{
		 $id="1";
		}
		$data['id']=$id;
		//print_r($get_data);exit;
		if(!isset($data["status"]))

			$data['status'] = $status ? 1 : 0;

		if ($this->db->insert($this->table_name, $data)) {

			$options_id = $this->db->insert_id();

			

			return array('id' => $options_id);

		}

		

		return false;

	}

	

	/**

	 * Update a options

	 *

	 * @param	array

	 * @param	int

	 * @return	bool

	 */

	function update_options($options_id, $data)

	{

		if(!isset($data["status"]))

			$data['status'] = 1;

		$this->db->where('id', $options_id);

		

		if ($this->db->update($this->table_name, $data)) {

			

			return true;

		}

		return false;

	}

	

	/**

	 * Delete a options

	 *

	 * @param	int

	 * @return	bool

	 */

	function delete_options($options_id)

	{

		$this->db->where('id', $options_id);

		$this->db->delete($this->table_name);

		

		if ($this->db->affected_rows() > 0) {

			return true;

		}

		return false;

	}
	function get_menu_update($key,$value)
	{
		$this->db->where('key',$key);
		$check_option=$this->db->get('options')->result_array();

		if(count($check_option)>0)
		{
			$update_data=["value"=>$value];
			$this->db->where('key',$key);
			$this->db->where('id',$check_option[0]['id']);
			$this->db->update('options',$update_data);
		}else
		{
			$insert_data=["key"=>$key,"value"=>$value,"status"=>1];
			$this->db->insert('options',$insert_data);
		}
	}
	function get_option_by_name_and_type($option,$type)

	{

		$this->db->select('id');

		

		$this->db->where('value',$option);

		

		$this->db->where('key',$type);

		

		$query = $this->db->get($this->table_name);

		

		if ($query->num_rows() == 1) {

			return $query->result_array();

		}

		return false;

		

	}

	function get_option_by_name($type)

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

	function get_option_by_name_and_status($type,$status)

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

	function delete_options_by_key($key)

	{

		$this->db->where_in('key', $key);

		$this->db->delete($this->table_name);

		

		if ($this->db->affected_rows() > 0) {

			return true;

		}

		return false;

	}

	function get_options_by_count_type($type)

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

	function get_options_by_limit($limit,$start,$type,$filter=null)

	{

		$this->db->limit($limit,$start);

		

		$this->db->where('key', $type);

		

		if(isset($filter["sort"]) && !empty($filter["sort"]))

		{

			$this->db->order_by($filter["sort"], $filter["order"]);

		

		}

	

		//$this->db->where('status',1);

		

		$query = $this->db->get($this->table_name);

		if ($query->num_rows() >= 1) {

			return $query->result_array();

		}

		return false;

	}

	function delete_options_by_id($id)

	{

		$this->db->where_in('id', $id);

		$this->db->delete($this->table_name);

		

		if ($this->db->affected_rows() > 0) {

			return true;

		}

		return false;

	}

	function get_all_options_except($id,$type)

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

	function get_length_of_employee_id_prefix()

	{

		$query=$this->db->query("SELECT LENGTH(`value`) as length FROM `options` where `key`='emp_id_prefix'");

		if ($query->num_rows() > 0)

		{

		

			$result = $query->result_array() ;

			

			return $result[0]["length"];

			

		}

		return false;

	}

	function get_employee_id_prefix()

	{

		$query=$this->db->query("SELECT value as prefix FROM `options` where `key`='emp_id_prefix'");

		if ($query->num_rows() > 0)

		{

		

			$result = $query->result_array() ;

			

			return $result[0]["prefix"];

			

		}

		return false;

	}

	function getClosest($search, $arr) 

	{

		$closest = null;

		foreach($arr as $item) 

		{								

			if(abs($item-$search)<10)

				$closest = $item;

		

		}

		return $closest;

		

	   /*$closest = null;

	   foreach($arr as $item) 

	   {								

			if($closest == null || abs($search - $closest) >= abs($item - $search))

			

				$closest = $item;

		

	   }

	   return $closest;*/

	} 



	

}