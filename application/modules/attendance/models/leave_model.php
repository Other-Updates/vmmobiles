<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Leave_model
 *
 * This model represents users_leaves. It operates the following tables:
 * - leave_table,
 *
 * @package	Payroll
 * @author	Vathsala
 */ 
 
class Leave_model extends CI_Model{

    private $table_name	= 'leave_table';	

	function __construct()
	{
		parent::__construct();
 
	} 
	
	/**
	 * Get all user leaves
	 *
	 * @return	array
	 */ 
	function get_all_user_leaves()
	{
		
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	}
	
	/**
	 * Get leaves  by user id (user id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_leaves_user_id($user_id)
	{
		
		$this->db->where('user_id', $user_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	
	
	/**
	 * Insert user leaves
	 *
	 * @param	array
	 * @param	bool
	 * @return	id
	 */
	function insert_user_leaves($data)
	{
		if ($this->db->insert($this->table_name, $data)) {
		
			$family_id = $this->db->insert_id();
			
			return $family_id;
		}
		return false;
	}
	
	/**
	 * Update a leaves by id
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_user_leaves_by_id($leave_id, $data)
	{
		$this->db->where('id', $leave_id);
		
		if ($this->db->update($this->table_name, $data)) {
			
			return true;
		}
		return false;
	}
	
	/**
	 * Delete user leaves by id
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_user_leaves_by_id($leave_id)
	{
		$this->db->where('id', $leave_id);
		
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows() > 0) {
		
			return true;
			
		}
		return false;
	}
	/*Get user leaves by month and year and user id*/
	function get_user_leaves_by_month_year_and_user_id($year,$month,$user_id)
	{
	
		$this->db->select($this->table_name.'.*');
		
		$this->db->select('u1.first_name as approved_by_name');
		
		$this->db->select('u2.first_name as applied_by_name');
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d") as from_key',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d") as to_key',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d-%m-%y %h:%i:%s") as date_from',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d-%m-%y  %h:%i:%s") as date_to',FALSE);
		
		$this->db->where('YEAR(leave_from)',$year);
		
		if(gettype($month)=="array")
		
			$this->db->where_in('MONTH(leave_from)',$month);
		else
			$this->db->where('MONTH(leave_from)',$month);
		
		$this->db->where('user_id',$user_id);
		
		$this->db->join('users u1','u1.id='.$this->table_name.'.approved_by','left');
		
		$this->db->join('users u2','u2.id='.$this->table_name.'.applied_by','left');
	
		$query = $this->db->get($this->table_name);
		
		//echo $this->db->last_query();
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	// function get all user leaves between two dates
	function get_user_leaves_by_between_dates($user_id,$date1,$date2)
	{
	
		$this->db->select($this->table_name.'.*');
		
		$this->db->select('u1.first_name as approved_by_name');
		
		$this->db->select('u2.first_name as applied_by_name');
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d") as from_key',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d") as to_key',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d-%m-%y %h:%i:%s") as date_from',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d-%m-%y  %h:%i:%s") as date_to',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d-%m-%Y") as l_from',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d-%m-%Y") as l_to',FALSE);
		
		$this->db->where('DATE(leave_from) >=',$date1);
		
		$this->db->where('DATE(leave_from) <=',$date2);
		
		$this->db->where('user_id',$user_id);
		
		$this->db->join('users u1','u1.id='.$this->table_name.'.approved_by','left');
		
		$this->db->join('users u2','u2.id='.$this->table_name.'.applied_by','left');
	
		$query = $this->db->get($this->table_name);
		
		//echo $this->db->last_query();
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	
	// function get all approved user leaves between two dates
	function get_approved_user_leaves_by_between_dates($user_id,$date1,$date2)
	{
	
		$this->db->select($this->table_name.'.*');
		
		$this->db->select('u1.first_name as approved_by_name');
		
		$this->db->select('u2.first_name as applied_by_name');
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d") as from_key',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d") as to_key',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d-%m-%y %h:%i:%s") as date_from',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d-%m-%y  %h:%i:%s") as date_to',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d-%m-%Y") as l_from',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d-%m-%Y") as l_to',FALSE);
		
		$this->db->where('DATE(leave_from) >=',$date1);
		
		$this->db->where('DATE(leave_from) <=',$date2);
		
		$this->db->where('approved',1);
		
		$this->db->where('user_id',$user_id);
		
		$this->db->join('users u1','u1.id='.$this->table_name.'.approved_by','left');
		
		$this->db->join('users u2','u2.id='.$this->table_name.'.applied_by','left');
	
		$query = $this->db->get($this->table_name);
		
		//echo $this->db->last_query();
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	
	// function get all approved user leaves on particular date
	function get_approved_user_leaves_on_date($user_id,$date)
	{
	
		$this->db->select($this->table_name.'.*');
		
		$this->db->select('u1.first_name as approved_by_name');
		
		$this->db->select('u2.first_name as applied_by_name');
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d") as from_key',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d") as to_key',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d-%m-%y %h:%i:%s") as date_from',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d-%m-%y  %h:%i:%s") as date_to',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d-%m-%Y") as l_from',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d-%m-%Y") as l_to',FALSE);
		
		$this->db->where('DATE(leave_from)<=',$date);
		
		$this->db->where('DATE(leave_to)>=',$date);		
		
		$this->db->where('approved',1);
		
		$this->db->where('user_id',$user_id);
		
		$this->db->join('users u1','u1.id='.$this->table_name.'.approved_by','left');
		
		$this->db->join('users u2','u2.id='.$this->table_name.'.applied_by','left');
	
		$query = $this->db->get($this->table_name);
		
		//echo $this->db->last_query();
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
		}
		return false;
	}
	
	//get user leaves by leave id
	function get_user_leaves_by_leave_id($leave_id)
	{
	
		$this->db->select($this->table_name.'.*');
		
		$this->db->select('u1.first_name as approved_by_name');
		
		$this->db->select('u2.first_name as applied_by_name');
		
		$this->db->select('u3.first_name as taken_by_name');
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d-%m-%Y %h:%m:%s") as date_from',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d-%m-%Y %h:%m:%s") as date_to',FALSE);
		
		$this->db->where($this->table_name.'.id',$leave_id);
		
		$this->db->join('users u1','u1.id='.$this->table_name.'.approved_by','left');
		
		$this->db->join('users u2','u2.id='.$this->table_name.'.applied_by','left');
		
		$this->db->join('users u3','u3.id='.$this->table_name.'.user_id','left');
	
		$query = $this->db->get($this->table_name);
		
		//echo $this->db->last_query();
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	function get_user_leaves_user_id_status($year,$month,$user_id,$status)
	{
	
		$this->db->select($this->table_name.'.*');
		
		$this->db->select('u1.first_name as approved_by_name');
		
		$this->db->select('u2.first_name as applied_by_name');
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d") as from_key',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d") as to_key',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d-%m-%y") as date_from',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d-%m-%y") as date_to',FALSE);
		
		$this->db->where('YEAR(leave_from)',$year);
		
		$this->db->where('MONTH(leave_from)',$month);
		
		$this->db->where('user_id',$user_id);
		
		$this->db->where('approved',$status);
		
		$this->db->join('users u1','u1.id='.$this->table_name.'.approved_by','left');
		
		$this->db->join('users u2','u2.id='.$this->table_name.'.applied_by','left');
	
		$query = $this->db->get($this->table_name);
		
		//echo $this->db->last_query();
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	function get_user_leaves_by_date($user_id,$date1,$date2,$type=null,$except_id=null)
	{	
		$this->db->select($this->table_name.'.type');
		
		$this->db->select($this->table_name.'.approved');
		
		$where = '(user_id = '.$user_id.')';
		
		$this->db->where($where);
		
		if(isset($except_id) && $except_id!=null)
		{
			$this->db->where('id !=',$except_id);
		
		}
		if(isset($type) && $type!=null)
		{
			$where = '((DATE(leave_from) = "'.date('Y-m-d',strtotime($date1)).'" OR '.'DATE(leave_to) = "'.date('Y-m-d',strtotime($date2)).'")';
			$where .= 'OR ("'.$date1.'" BETWEEN '.$this->table_name.'.leave_from AND '.$this->table_name.'.leave_to)';
			$where .= 'OR ("'.$date2.'" BETWEEN '.$this->table_name.'.leave_from AND '.$this->table_name.'.leave_to))';
			$this->db->where($where);
		}
		else
		{
		
			$where ='(('.$this->table_name.".leave_from >='".$date1."' and ". $this->table_name.".leave_to <='".$date2."')";
			$where .= 'OR ("'.$date1.'" BETWEEN '.$this->table_name.'.leave_from AND '.$this->table_name.'.leave_to)';
			$where .= 'OR ("'.$date2.'" BETWEEN '.$this->table_name.'.leave_from AND '.$this->table_name.'.leave_to))';
			
			$this->db->where($where);
		}
		
				
		$query = $this->db->get($this->table_name);
		
		//echo $this->db->last_query();
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	
	}
	function get_user_leaves_for_diff($user_id,$date,$except_id=null)
	{	
		$this->db->select($this->table_name.'.type');
		
		$this->db->select($this->table_name.'.approved');
		
		$this->db->select($this->table_name.'.leave_from');
		$this->db->select($this->table_name.'.leave_to');
		
		$where = '(user_id = '.$user_id.')';
		
		$this->db->where($where);
		
		$type = array('sick leave','casual leave');
		
		$this->db->where_in('type',$type);
		
		if(isset($except_id) && $except_id!=null)
		{
			$this->db->where('id !=',$except_id);
		
		}
		if(isset($type) && $type!=null)
		{
		
			$where = '((DATE(leave_from) = "'.date('Y-m-d',strtotime($date)).'" OR '.'DATE(leave_to) = "'.date('Y-m-d',strtotime($date)).'")';
			$where .= 'OR ("'.$date.'" BETWEEN '.$this->table_name.'.leave_from AND '.$this->table_name.'.leave_to))';
			$this->db->where($where);
		}
		$query = $this->db->get($this->table_name);
		
		//echo $this->db->last_query();
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	function get_user_leaves_count_by_today($date,$user_id=NULL)
	{
		$this->db->select('count(*) as count');
		
		if($user_id!=NULL)
		{
			if(gettype($user_id)=="array")
				$this->db->where_in($this->table_name.'.user_id',$user_id);
			else
				$this->db->where($this->table_name.'.user_id',$user_id);
		}	
		$this->db->where('DATE(leave_from)',$date);
		
		$query = $this->db->get($this->table_name);
		
		//echo $this->db->last_query();
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	
	}
	function get_user_leaves_count_by_week($start,$end,$user_id=NULL)
	{
		$this->db->select('count(*) as count');
		
		if($user_id!=NULL)
		{
			if(gettype($user_id)=="array")
				$this->db->where_in($this->table_name.'.user_id',$user_id);
			else
				$this->db->where($this->table_name.'.user_id',$user_id);
		}	
		$this->db->where('DATE(leave_from)>= ',$start);
		
		$this->db->where('DATE(leave_from)<= ',$end);
		
		
		$query = $this->db->get($this->table_name);
		
		//echo $this->db->last_query();
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	
	}
	function get_user_leaves_by_today($limit,$start,$date,$user_id=NULL)
	{
		$this->db->limit($limit, $start);
		
		$this->db->select($this->table_name.'.*');
		
		$this->db->select('u1.first_name as approved_by_name');
		
		$this->db->select('u2.first_name as applied_by_name');
		
		$this->db->select('u3.first_name as taken_by_name');
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d") as from_key',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d") as to_key',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d-%m-%y") as date_from',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d-%m-%y") as date_to',FALSE);
		
		$this->db->where('DATE(leave_from)',$date);
		
		if($user_id!=NULL)
		{
			if(gettype($user_id)=="array")
				$this->db->where_in($this->table_name.'.user_id',$user_id);
			else
				$this->db->where($this->table_name.'.user_id',$user_id);
		}	
		$this->db->join('users u1','u1.id='.$this->table_name.'.approved_by','left');
		
		$this->db->join('users u2','u2.id='.$this->table_name.'.applied_by','left');
		
		$this->db->join('users u3','u3.id='.$this->table_name.'.user_id','left');
		
		$this->db->order_by($this->table_name.'.id','desc');
	
		$query = $this->db->get($this->table_name);
		
		//echo $this->db->last_query();
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	function get_user_leaves_by_week($limit, $start_record,$start,$end,$user_id=NULL)
	{
		$this->db->limit($limit, $start_record);
	
		$this->db->select($this->table_name.'.*');
		
		$this->db->select('u1.first_name as approved_by_name');
		
		$this->db->select('u2.first_name as applied_by_name');
		
		$this->db->select('u3.first_name as taken_by_name');
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d") as from_key',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d") as to_key',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d-%m-%y") as date_from',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d-%m-%y") as date_to',FALSE);
		
		$this->db->where('DATE(leave_from)>= ',$start);
		
		$this->db->where('DATE(leave_from)<= ',$end);
		
		if($user_id!=NULL)
		{
			if(gettype($user_id)=="array")
				$this->db->where_in($this->table_name.'.user_id',$user_id);
			else
				$this->db->where($this->table_name.'.user_id',$user_id);
		}	
		$this->db->join('users u1','u1.id='.$this->table_name.'.approved_by','left');
		
		$this->db->join('users u2','u2.id='.$this->table_name.'.applied_by','left');
		
		$this->db->join('users u3','u3.id='.$this->table_name.'.user_id','left');
		
		$this->db->order_by($this->table_name.'.id','desc');
	
		$query = $this->db->get($this->table_name);
		
		
		//echo $this->db->last_query();
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	function get_leave_status_by_id($leave_id)
	{
		$this->db->select($this->table_name.'.approved');
		
		$this->db->where($this->table_name.'.id',$leave_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() == 1) {
		
			return $query->result_array();
			
		}
		
		return false;
	}
	function get_user_leaves_by_status($status,$users=null)
	{
		$this->db->limit(5);
		
		$this->db->select($this->table_name.'.*');
		
		$this->db->select($this->table_name.'.id as leave_id');
		
		$this->db->select($this->table_name.'.user_id as ct_user_id');
		
		$this->db->select('u1.first_name as approved_by_name');
		
		$this->db->select('u2.first_name as applied_by_name');
		
		$this->db->select('u3.first_name as taken_by_name');
		
		$this->db->select('u3.image as profile_image');
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d-%m-%y") as date_from',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d-%m-%y") as date_to',FALSE);
		
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d-%m-%y %h:%i") as date_from1',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d-%m-%y %h:%i") as date_to1',FALSE);
		
		
		$this->db->where('approved',$status);
		
		if(isset($users) && !empty($users))
		
			$this->db->where_in('user_id',$users);			
			
			$this->db->where('DATE(leave_from)>=',date('Y-m-d',strtotime("Today")));	     
		
		$this->db->join('users u1','u1.id='.$this->table_name.'.approved_by','left');
		
		$this->db->join('users u2','u2.id='.$this->table_name.'.applied_by','left');
		
		$this->db->join('users u3','u3.id='.$this->table_name.'.user_id','left');
		
		$this->db->order_by('id','desc');
	
		$query = $this->db->get($this->table_name);
		
		//echo $this->db->last_query();
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	function get_all_user_leaves_by_status($limit,$start,$status,$users=null)
	{
		$this->db->limit($limit,$start);
		
		$this->db->select($this->table_name.'.*');
		
		$this->db->select($this->table_name.'.id as leave_id');
		
		$this->db->select($this->table_name.'.user_id as ct_user_id');
		
		$this->db->select('u1.first_name as approved_by_name');
		
		$this->db->select('u2.first_name as applied_by_name');
		
		$this->db->select('u3.first_name as taken_by_name');
		
		$this->db->select('u3.image as profile_image');
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d-%m-%y") as date_from',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d-%m-%y") as date_to',FALSE);
		
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d-%m-%y %h:%i") as date_from1',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d-%m-%y %h:%i") as date_to1',FALSE);
		
		if(gettype($status)=="array")
				$this->db->where_in('approved',$status);
		else
		
			$this->db->where('approved',$status);
		
		if(isset($users) && !empty($users))
		
			$this->db->where_in('user_id',$users);			
			
			$this->db->where('DATE(leave_from)>=',date('Y-m-d',strtotime("Today")));	     
		
		$this->db->join('users u1','u1.id='.$this->table_name.'.approved_by','left');
		
		$this->db->join('users u2','u2.id='.$this->table_name.'.applied_by','left');
		
		$this->db->join('users u3','u3.id='.$this->table_name.'.user_id','left');
		
		$this->db->order_by('id','desc');
	
		$query = $this->db->get($this->table_name);
		
		//echo $this->db->last_query();
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	function get_all_user_leaves_by_status_count($status,$users=null)
	{
		
		$this->db->select('count(*) as count');
		if(gettype($status)=="array")
				$this->db->where_in('approved',$status);
		else
		
			$this->db->where('approved',$status);
		
		$this->db->where('DATE(leave_from)>=',date('Y-m-d',strtotime("Today")));	     
		
		if(isset($users) && !empty($users))
		
			$this->db->where_in('user_id',$users);			
	
		$query = $this->db->get($this->table_name);
		
		//echo $this->db->last_query();
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	function get_all_user_leaves_by_status_without_limit($status,$users=null)
	{
		
		$this->db->select($this->table_name.'.*');
		
		$this->db->select($this->table_name.'.id as leave_id');
		
		$this->db->select($this->table_name.'.user_id as ct_user_id');
		
		$this->db->select('u1.first_name as approved_by_name');
		
		$this->db->select('u2.first_name as applied_by_name');
		
		$this->db->select('u3.first_name as taken_by_name');
		
		$this->db->select('u3.image as profile_image');
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d-%m-%y") as date_from',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d-%m-%y") as date_to',FALSE);
		
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_from,"%d-%m-%y %h:%i") as date_from1',FALSE);
		
		$this->db->select('DATE_FORMAT('.$this->table_name.'.leave_to,"%d-%m-%y %h:%i") as date_to1',FALSE);
		
		if(gettype($status)=="array")
				$this->db->where_in('approved',$status);
		else
		
			$this->db->where('approved',$status);
		
		if(isset($users) && !empty($users))
		
			$this->db->where_in('user_id',$users);			
			
			$this->db->where('DATE(leave_from)>=',date('Y-m-d',strtotime("Today")));	     
		
		$this->db->join('users u1','u1.id='.$this->table_name.'.approved_by','left');
		
		$this->db->join('users u2','u2.id='.$this->table_name.'.applied_by','left');
		
		$this->db->join('users u3','u3.id='.$this->table_name.'.user_id','left');
		
		$this->db->order_by('id','desc');
	
		$query = $this->db->get($this->table_name);
		
		//echo $this->db->last_query();
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	
	
}