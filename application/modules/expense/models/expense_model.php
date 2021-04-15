<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin_model
 *
 * This model represents admin access. It operates the following tables:
 * admin,
 *
 * @package	i2_soft
 * @author	Elavarasan
 */
 
class Expense_model extends CI_Model{

	private $table_name1	= 'expense';
	private $table_name2	= 'expense_fixed';	
	private $table_name3	= 'expense_variable';
	private $table_name4	= 'expense_variable_detaills';	
	function __construct()
	{
		parent::__construct();

	}
	
	public function get_expense_details($type)
	{
		$this->db->select('*');
		$this->db->where('expense_type',$type);
		
	 	$query = $this->db->get($this->table_name1)->result_array();
		return $query; 
	}
	public function get_expense_details1($type)
	{
		$this->db->select('*');
		$this->db->where('expense_type',$type);
		$this->db->where('status',1);
	 	$query = $this->db->get($this->table_name1)->result_array();
		return $query; 
	}
	public function insert_fixed_expense($data)
	{
	 	if($this->db->insert_batch($this->table_name2,$data))
			return true;
		else
			return false;
	}
	public function insert_variable_expense($data)
	{
	 	if($this->db->insert($this->table_name3,$data))
			return $this->db->insert_id();
		else
			return false;
	}
	public function insert_variable_expense_details($data)
	{
	 	if($this->db->insert_batch($this->table_name4,$data))
			return true;
		else
			return false;
	}
	public function insert_variable_expense_inv_details($data)
	{
	 	if($this->db->insert_batch('expense_variable_inv_detaills',$data))
			return true;
		else
			return false;
	}
	
	public function delete_fixed_expense($data)
	{
		$this->db->where($data);
	 	$this->db->delete($this->table_name2);
	}
	public function delete_fixed_variable_expense($data)
	{
		$this->db->where('id',$data['delete_id']);
	 	$this->db->delete($this->table_name3);
	}
	public function update_variable_expense($data,$id)
	{
		$this->db->where('id',$id);
	 	$this->db->update($this->table_name3,$data);
		return true;
	}
	public function delete_all_variable($id)
	{
		$this->db->where('exp_var_id',$id);
	 	$this->db->delete($this->table_name4);
	}
	public function get_all_fixed_expense($serch_data=NULL)
	{
		$this->db->select('exp_date,created_date');
		$this->db->group_by('exp_date');
		$this->db->group_by('created_date');
		$this->db->where('status',1);
	 	if(isset($serch_data) && !empty($serch_data))
		{
			$serch_data['from_date']=date('Y-m-d',strtotime($serch_data['from_date']));
			$serch_data['to_date']=date('Y-m-d',strtotime($serch_data['to_date']));
			if($serch_data['from_date']=='1970-01-01')
			$serch_data['from_date']='';
			if($serch_data['to_date']=='1970-01-01')
			$serch_data['to_date']='';
		
			if(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
			{
				
			$this->db->where("DATE_FORMAT(".$this->table_name2.".exp_date,'%Y-%m-%d') >='".$serch_data["from_date"]."' AND DATE_FORMAT(".$this->table_name2.".exp_date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
			}
			elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]=="")
			{
			
				$this->db->where("DATE_FORMAT(".$this->table_name2.".exp_date,'%Y-%m-%d') >='".$serch_data["from_date"]."'");
			}
			elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]=="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
			{
				
				$this->db->where("DATE_FORMAT(".$this->table_name2.".exp_date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
			}
			
		}
		else
		{
			$from_y=$to_y=0;
			if(date('m')>3)
			{
				$from_y=date('Y');
				$to_y=date('Y')+1;
			}
			else
			{
				$from_y=date('Y')-1;
				$to_y=date('Y');
			}
			$from=$from_y.'-04-01';
			$to=$to_y.'-03-31';
			$this->db->where("DATE_FORMAT(".$this->table_name2.".exp_date,'%Y-%m-%d') >='".$from."' AND DATE_FORMAT(".$this->table_name2.".exp_date,'%Y-%m-%d') <= '".$to."'" );	
		}
		$query = $this->db->get($this->table_name2)->result_array();
		
		
		$this->db->select('*');
		$this->db->where('expense_type','fixed');
	 	$expense = $this->db->get($this->table_name1)->result_array();
		
		$i=0;
		foreach($query as $val)
		{
			$j=0;
			foreach($expense as $val1)
			{
				$this->db->select($this->table_name2.'.*');
				$this->db->select('expense.expense');
				$this->db->where($this->table_name2.'.exp_date',$val['exp_date']);
				$this->db->where($this->table_name2.'.exp_type',$val1['id']);
				$this->db->where($this->table_name2.'.created_date',$val['created_date']);
				$this->db->join('expense','expense.id='.$this->table_name2.'.exp_type');
				$query[$i]['expense_info'][$j] = $this->db->get($this->table_name2)->result_array();
				if(empty($query[$i]['expense_info'][$j]))
				{
					$query[$i]['expense_info'][$j][0]['exp_type']=$val1['id'];
					$query[$i]['expense_info'][$j][0]['exp_value']=0;
					$query[$i]['expense_info'][$j][0]['expense']=$val1['expense'];
				}
				$j++;
			}
			$i++;
		}
		return $query;
	}
	public function get_all_var_expense($serch_data=NULL)
	{
		$this->db->select('*');
		$this->db->where('status',1);
		$this->db->order_by('date','desc');
		if(isset($serch_data) && !empty($serch_data))
		{
			$serch_data['from_date']=date('Y-m-d',strtotime($serch_data['from_date']));
			$serch_data['to_date']=date('Y-m-d',strtotime($serch_data['to_date']));
			if($serch_data['from_date']=='1970-01-01')
			$serch_data['from_date']='';
			if($serch_data['to_date']=='1970-01-01')
			$serch_data['to_date']='';
		
			if(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
			{
				
			$this->db->where("DATE_FORMAT(".$this->table_name3.".date,'%Y-%m-%d') >='".$serch_data["from_date"]."' AND DATE_FORMAT(".$this->table_name3.".date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
			}
			elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]=="")
			{
			
				$this->db->where("DATE_FORMAT(".$this->table_name3.".date,'%Y-%m-%d') >='".$serch_data["from_date"]."'");
			}
			elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]=="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
			{
				
				$this->db->where("DATE_FORMAT(".$this->table_name3.".date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
			}
			
		}
		else
		{
			$from_y=$to_y=0;
			if(date('m')>3)
			{
				$from_y=date('Y');
				$to_y=date('Y')+1;
			}
			else
			{
				$from_y=date('Y')-1;
				$to_y=date('Y');
			}
			$from=$from_y.'-04-01';
			$to=$to_y.'-03-31';
			$this->db->where("DATE_FORMAT(".$this->table_name3.".date,'%Y-%m-%d') >='".$from."' AND DATE_FORMAT(".$this->table_name3.".date,'%Y-%m-%d') <= '".$to."'" );	
		}
	 	$query = $this->db->get($this->table_name3)->result_array();
		
		$this->db->select('*');
		$this->db->where('expense_type','variable');
	 	$expense = $this->db->get($this->table_name1)->result_array();
		
		$i=0;
		foreach($query as $val)
		{
			if($val['exp_against']=='suplier')
			{
				$this->db->select('store_name as exp_for_name');
				$this->db->where('status',1);
				$this->db->where('id',$val['exp_for']);
				$query[$i]['exp_for_details'] = $this->db->get('vendor')->result_array();
				
				$this->db->select('inv_no');
				$this->db->where('var_exp_id',$val['id']);
				$query[$i]['inv_for_details'] = $this->db->get('expense_variable_inv_detaills')->result_array();
				
				
				
			}
			elseif($val['exp_against']=='customer')
			{
				$this->db->select('store_name as exp_for_name');
				$this->db->where('status',1);
				$this->db->where('id',$val['exp_for']);
				$query[$i]['exp_for_details'] = $this->db->get('customer')->result_array();
			}
			elseif($val['exp_against']=='style')
			{
				$this->db->select('grn_no as exp_for_name');
				$this->db->where('status',1);
				$this->db->where('id',$val['exp_for']);
				$query[$i]['exp_for_details'] = $this->db->get('po')->result_array();
			}
			elseif($val['exp_against']=='sale_order')
			{
				$this->db->select('receipt_no as exp_for_name');
				
				$this->db->where('id',$val['exp_for']);
				$query[$i]['exp_for_details'] = $this->db->get('receipt')->result_array();
			}
			elseif($val['exp_against']=='transport')
			{
				$list=explode(',',$val['exp_for']);
				
				$j=0;$list_data='';
				foreach($list as $list_val)
				{
					$this->db->select('lr_no as exp_for_name');
					$this->db->where('id',$val['exp_for']);
					$list_query= $this->db->get('package')->result_array();
					$list_data=$list_data.$list_query[0]['exp_for_name'];
					$j++;
					if($j!=count($list))
					$list_data=$list_data.',';
				}
				$query[$i]['exp_for_details'][0]['exp_for_name']=$list_data;
				$this->db->select('inv_no');
				$this->db->where('var_exp_id',$val['id']);
				$query[$i]['inv_for_details'] = $this->db->get('expense_variable_inv_detaills')->result_array();
			}
			elseif($val['exp_against']=='agent')
			{
				$list=explode(',',$val['exp_for']);
				$j=0;$list_data='';
				foreach($list as $list_val)
				{
					$this->db->select('receipt_no as exp_for_name');
					$this->db->where('id',$val['exp_for']);
					$list_query= $this->db->get('receipt')->result_array();
					$list_data=$list_data.$list_query[0]['exp_for_name'];
					$j++;
					if($j!=count($list))
					$list_data=$list_data.',';
				}
				$query[$i]['exp_for_details'][0]['exp_for_name']=$list_data;
			}
			$j=0;
			foreach($expense as $val1)
			{
				$this->db->select($this->table_name4.'.*');
				$this->db->select('expense.expense');
				$this->db->where($this->table_name4.'.exp_var_id',$val['id']);
				$this->db->where($this->table_name4.'.exp_type',$val1['id']);
				$this->db->join('expense','expense.id='.$this->table_name4.'.exp_type');
				$query[$i]['expense_info'][] = $this->db->get($this->table_name4)->result_array();
				
				if(empty($query[$i]['expense_info'][$j]))
				{
					$query[$i]['expense_info'][$j][0]['exp_type']=$val1['id'];
					$query[$i]['expense_info'][$j][0]['exp_amount']=0;
					$query[$i]['expense_info'][$j][0]['exp_desc']='';
					$query[$i]['expense_info'][$j][0]['expense']=$val1['expense'];
				}
				$j++;
			}
			$i++;
		}
		//echo"<pre>";print_r($query);
		return $query;
	}
	public function get_inv_info_details($data)
	{
			$this->db->select('inv_no');
			$res = $this->db->get('expense_variable_inv_detaills')->result_array();
		
		if($data['st_id']==1)
		{
			$this->db->select('purchase_receipt.receipt_no as inv_no');
			$this->db->where('customer_id',$data['expense_ag']);
			$query = $this->db->get('purchase_receipt')->result_array();
			$i=0;
			foreach($query as $vv)
			{
				foreach($res as $vvv)
				{
					if($vv['inv_no']==$vvv['inv_no'])
					{
						unset($query[$i]);	
					}
				}
				$i++;	
			}
			return $query;
		}
		if($data['st_id']==5)
		{
			$this->db->select('invoice.inv_no as inv_no');
			$this->db->where('lr_no',$data['expense_text']);
			$this->db->join('invoice','invoice.package_id=package.id');
			$query = $this->db->get('package')->result_array();
			$i=0;
			foreach($query as $vv)
			{
				foreach($res as $vvv)
				{
					if($vv['inv_no']==$vvv['inv_no'])
					{
						unset($query[$i]);	
					}
				}
				$i++;	
			}
			return $query;
		}
		
	}
}