<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Expense extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('email');
	    $this->load->database();
		$this->load->library('form_validation');
			
	}
	
	public function fixed_expense()
	{
		$this->load->model('expense_model');
		if($this->input->post())
		{
			$input=$this->input->post();
			$input['exp_date']=date('Y-m-d',strtotime($input['exp_date']));
			$s_arr=array();
			if(isset($input['fixed_exp']['exp_type']) && !empty($input['fixed_exp']['exp_type']))
			{
				foreach($input['fixed_exp']['exp_type'] as $key=>$val)
				{
					$s_arr[]=array('exp_date'=>$input['exp_date'],'exp_type'=>$val,'exp_value'=>$input['fixed_exp']['exp_value'][$key],'exp_remarks'=>$input['fixed_exp']['exp_remarks'][$key]);
				}
			
			}
			$this->expense_model->insert_fixed_expense($s_arr);
			redirect($this->config->item('base_url').'expense/fixed_expense');
		}
		$data['expense']=$this->expense_model->get_expense_details('fixed');
		$data['expense1']=$this->expense_model->get_expense_details1('fixed');
		$data['all_expense']=$this->expense_model->get_all_fixed_expense();
		$this->template->write_view('content', 'fixed_expense',$data);
        $this->template->render();           
	}
	public function delete_fixed()
	{
		$this->load->model('expense_model');
		$this->expense_model->delete_fixed_expense($this->input->post());
		redirect($this->config->item('base_url').'expense/fixed_expense');
	}
	public function delete_variable_fixed()
	{
		$this->load->model('expense_model');
		$this->expense_model->delete_fixed_variable_expense($this->input->post());
		redirect($this->config->item('base_url').'expense/variable_expense');
	}
	public function update_fixed()
	{
		$this->load->model('expense_model');
		if($this->input->post())
		{
			$input=$this->input->post();
			$delete_arr=array('exp_date'=>$input['update_exp_date'],'created_date'=>$input['update_created_date']);
			$this->expense_model->delete_fixed_expense($delete_arr);
			$input['exp_date']=date('Y-m-d',strtotime($input['exp_date']));
			$s_arr=array();
			if(isset($input['fixed_exp']['exp_type']) && !empty($input['fixed_exp']['exp_type']))
			{
				foreach($input['fixed_exp']['exp_type'] as $key=>$val)
				{
					$s_arr[]=array('exp_date'=>$input['exp_date'],'exp_type'=>$val,'exp_value'=>$input['fixed_exp']['exp_value'][$key],'exp_remarks'=>$input['fixed_exp']['exp_remarks'][$key]);
				}
			
			}
			$this->expense_model->insert_fixed_expense($s_arr);
			redirect($this->config->item('base_url').'expense/fixed_expense');
		}
	}
	public function variable_expense()
	{
		$this->load->model('expense_model');
		if($this->input->post())
		{
			$input=$this->input->post();
			
			$input['exp']['date']=date('Y-m-d',strtotime($input['exp']['date']));
			if(is_array($input['exp']['exp_for']))
			{
				$i=0;
				$arr_name='';
				foreach($input['exp']['exp_for'] as $val)
				{
					$arr_name=$arr_name.$val;
					$i++;
					if($i!=count($input['exp']['exp_for']))
					{
						$arr_name=$arr_name.',';
					}
					
				}
				$input['exp']['exp_for']=$arr_name;
			}

			$insert_id=$this->expense_model->insert_variable_expense($input['exp']);
			
			$inv_arr=array();
			if(isset($input['inv_details']) && !empty($input['inv_details']))
			{
				foreach($input['inv_details'] as $valx)
				{
					$inv_arr[]=array(
								   'var_exp_id'=>$insert_id,
								   'inv_no'=>$valx
								   );
				}
				$this->expense_model->insert_variable_expense_inv_details($inv_arr);
			}
			$s_arr=array();
			if(isset($input['exp_info']['exp_type']) && !empty($input['exp_info']['exp_type']))
			{
				foreach($input['exp_info']['exp_type'] as $key=>$val)
				{
					$s_arr[]=array(
								   'exp_var_id'=>$insert_id,
								   'exp_type'=>$val,
								   'exp_amount'=>$input['exp_info']['exp_amount'][$key],
								   'exp_desc'=>$input['exp_info']['exp_desc'][$key]
								   );
				}
			$this->expense_model->insert_variable_expense_details($s_arr);
			}
			
			
			redirect($this->config->item('base_url').'expense/variable_expense');
		}
		$data['expense']=$this->expense_model->get_expense_details('variable');
		$data['all_expense']=$this->expense_model->get_all_var_expense();
		//expense type 
		$this->load->model('vendor/vendor_model');
		$data['all_supplier']=$this->vendor_model->get_vendor();
		$this->load->model('customer/customer_model');
		$data['all_customer']=$this->customer_model->get_customer();
		$this->load->model('po/gen_model');
		$data['po_no']=$this->gen_model->get_all_po_for_expense();
		$this->load->model('sales_order/sales_order_model');
		$data['so_no']=$this->sales_order_model->get_all_so_for_expense();
		
		$this->load->model('package/package_model');
		$data['lr_no']=$this->package_model->get_all_lrno_for_expense();
			
		$this->template->write_view('content', 'variable_expense',$data);   
        $this->template->render();           
	}
	public function update_variable_fixed()
	{
			$this->load->model('expense_model');
			$input=$this->input->post();
			$input['exp']['date']=date('Y-m-d',strtotime($input['exp']['date']));
			if(is_array($input['exp']['exp_for']))
			{
				$i=0;
				$arr_name='';
				foreach($input['exp']['exp_for'] as $val)
				{
					$arr_name=$arr_name.$val;
					$i++;
					if($i!=count($input['exp']['exp_for']))
					{
						$arr_name=$arr_name.',';
					}
					
				}
				$input['exp']['exp_for']=$arr_name;
			}

			$insert_id=$this->expense_model->update_variable_expense($input['exp'],$input['update_id']);
			$this->expense_model->delete_all_variable($input['update_id']);
			$s_arr=array();
			if(isset($input['exp_info']['exp_type']) && !empty($input['exp_info']['exp_type']))
			{
				foreach($input['exp_info']['exp_type'] as $key=>$val)
				{
					$s_arr[]=array(
								   'exp_var_id'=>$input['update_id'],
								   'exp_type'=>$val,
								   'exp_amount'=>$input['exp_info']['exp_amount'][$key],
								   'exp_desc'=>$input['exp_info']['exp_desc'][$key]
								   );
				}
			
			}
			$this->expense_model->insert_variable_expense_details($s_arr);
			redirect($this->config->item('base_url').'expense/variable_expense');
	}
	public function get_expense_type_details()
	{
		
		$ex_type=$this->input->get('ex_type');
		if($ex_type==1)
		{
			$this->load->model('vendor/vendor_model');
			$data['all_supplier']=$this->vendor_model->get_vendor();
			$select='';
			$select=$select."<select class='form-control expensecmp expensecmpup' name='exp[exp_for]'    style='width: 150px;float:left;'><option value=''>Select</option>";	
			if(isset($data['all_supplier']) && !empty($data['all_supplier']))
			{
				foreach($data['all_supplier'] as $val1)
				{		
						$select=$select."<option value=".$val1['id'].">".$val1['store_name']."</option>";
				}
			}
			
			$select=$select."</select><span id='varerror2' style='color:#F00;' ></span> <span class='varerrorup2' style='color:#F00;'></span>";
			if(empty($data['all_supplier']))
			{
				$select=$select."   <span style='color:red;'>Supplier not crerated yet...</span>";
			}
			echo $select;
		}
		else if($ex_type==2)
		{
			$this->load->model('customer/customer_model');
			$data['all_customer']=$this->customer_model->get_customer();
			$select='';
			$select=$select."<select class='form-control expensecmp expensecmpup' name='exp[exp_for]'   style='width: 150px;float:left;'><option value=''>Select</option>";	
			if(isset($data['all_customer']) && !empty($data['all_customer']))
			{
				foreach($data['all_customer'] as $val1)
				{		
						$select=$select."<option value=".$val1['id'].">".$val1['store_name'].' ( '.$val1['selling_percent'].' % )'."</option>";
				}
			}
			
			$select=$select."</select><span id='varerror2' style='color:#F00;' ></span> <span class='varerrorup2' style='color:#F00;'></span>";
			if(empty($data['all_customer']))
			{
				$select=$select."   <span style='color:red;'>Customer not crerated yet...</span>";
			}
			echo $select;
		}
		else if($ex_type==3)
		{
			$this->load->model('po/gen_model');
			$data['po_no']=$this->gen_model->get_all_po_for_expense();
			$select='';
			$select=$select."<select class='form-control expensecmp expensecmpup' name='exp[exp_for]'   style='width: 150px;float:left;'><option value=''>Select</option>";	
			if(isset($data['po_no']) && !empty($data['po_no']))
			{
				foreach($data['po_no'] as $val1)
				{		
						$select=$select."<option value=".$val1['id'].">".$val1['grn_no']."</option>";
				}
			}
			
			$select=$select."</select><span id='varerror2' style='color:#F00;' ></span> <span class='varerrorup2' style='color:#F00;'></span>";
			if(empty($data['po_no']))
			{
				$select=$select."   <span style='color:red;'>PO not crerated yet...</span>";
			}
			echo $select;
		}
		else if($ex_type==4)
		{
			$this->load->model('sales_order/sales_order_model');
			$data['so_no']=$this->sales_order_model->get_all_so_for_expense();
			$select='';
			$select=$select."<select class='form-control expensecmp expensecmpup' name='exp[exp_for]' id='receipt'  style='width: 150px;float:left;'><option value=''>Select</option>";	
			if(isset($data['so_no']) && !empty($data['so_no']))
			{
				foreach($data['so_no'] as $val1)
				{		
						$select=$select."<option value=".$val1['id'].">".$val1['receipt_no']."</option>";
				}
			}
			
			$select=$select."</select><span id='varerror2' style='color:#F00;' ></span> <span class='varerrorup2' style='color:#F00;'></span>";
			if(empty($data['so_no']))
			{
				$select=$select."   <span style='color:red;'>Receipt not crerated yet...</span>";
			}
			echo $select;
		}
		else if($ex_type==5)
		{
			
			$this->load->model('package/package_model');
			$data['lr_no']=$this->package_model->get_all_lrno_for_expense();
			$this->load->model('sales_order/sales_order_model');
			$data['so_no']=$this->sales_order_model->get_all_so_for_expense();
			$select='';
			$select=$select."<select class='form-control expensecmp expensecmpup' name='exp[exp_for][]' style='width: 150px;float:left;'><option value=''>Select</option>";	
			if(isset($data['lr_no']) && !empty($data['lr_no']))
			{
				foreach($data['lr_no'] as $val1)
				{		
						$select=$select."<option value=".$val1['id'].">".$val1['lr_no']."</option>";
				}
			}
			
			$select=$select."</select><span id='varerror2' style='color:#F00;' ></span> <span class='varerrorup2' style='color:#F00;'></span>";
			if(empty($data['so_no']))
			{
				$select=$select."   <span style='color:red;'>Package Order crerated yet...</span>";
			}
			echo $select;
		}
		else if($ex_type==6)
		{
			$this->load->model('sales_order/sales_order_model');
			$data['so_no']=$this->sales_order_model->get_all_so_for_expense();
			$select='';
			$select=$select."<select class='form-control expensecmp expensecmpup'  multiple='multiple' id='agent_list_receipt' name='exp[exp_for][]'  style='width: 150px;float:left;'><option value=''>Select</option>";	
			if(isset($data['so_no']) && !empty($data['so_no']))
			{
				foreach($data['so_no'] as $val1)
				{		
						$select=$select."<option value=".$val1['id'].">".$val1['receipt_no']."</option>";
				}
			}
			
			$select=$select."</select><span id='varerror2' style='color:#F00;' ></span> <span class='varerrorup2' style='color:#F00;'></span>";
			if(empty($data['so_no']))
			{
				$select=$select."   <span style='color:red;'>Agent not crerated yet...</span>";
			}
			echo $select;
		}
	}
	public function package_view($p_id)
	{
		$this->load->model('package/package_model');
		$data['package_details']=$this->package_model->get_package_by_id($p_id);
		$data['package_info']=$this->package_model->get_package_by_id1($p_id);
		$this->template->write_view('content', 'package/package_view',$data);
        $this->template->render();      
	}
	public function get_inv_no_list()
	{
		$atten_inputs = $this->input->get();
		$this->load->model('invoice_model');
		$data = $this->invoice_model->get_all_inv_no($atten_inputs);
		foreach($data as $st_rlno)
		{
			echo $st_rlno['inv_no']."\n";
		}	
	}
	
	public function view($inv_id)
	{
		$this->load->model('invoice/invoice_model');
		$this->load->model('package/package_model');
		$data['invoice_details']=$this->invoice_model->get_invoice_by_id($inv_id);
		$data['package_details']=$this->package_model->get_package_by_id($data['invoice_details'][0]['package_id']);
		$data['package_info']=$this->package_model->get_package_by_id1($data['invoice_details'][0]['package_id']);
		$this->template->write_view('content', 'invoice/invoice_view',$data);
        $this->template->render();  
	}
	public function send_email()
	{
		$this->load->model('invoice/invoice_model');
		$this->load->model('package/package_model');
		$this->load->model('admin/admin_model');
		$inv_id=$this->input->get('inv_id');
	
		$data['invoice_details']=$this->invoice_model->get_invoice_by_id($inv_id);
		$data['package_details']=$this->package_model->get_package_by_id($data['invoice_details'][0]['package_id']);
		$data['package_info']=$this->package_model->get_package_by_id1($data['invoice_details'][0]['package_id']);
		$data['company_details']=$this->admin_model->get_company_details();
		
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		$this->email->from('noreply@email.com', 'Sneha Creation');
		$this->email->to(''); 
		$this->email->subject($data['invoice_details'][0]['inv_no'].' Created');
		$this->email->set_mailtype("html");
		$msg1['test'] = $this->load->view('invoice/invoice_email_view',$data,TRUE);
		$msg1['company_details']=$data['company_details'];
		$msg = $this->load->view('po/email_template',$msg1,TRUE);
		$this->email->message($msg);
		$this->email->send();
		echo $msg;
	}
	public function get_receipt_info()
	{
		$this->load->model('sales_receipt/sales_receipt_model');
		$input = $this->input->get();
		$data=$this->receipt_model->get_receipt_by_id_for_agent($input['r_id']);
		$a_amt=array();
		if(isset($data) && !empty($data))
		{
			foreach($data as $datas)
			{
				$a_amt[]=(round($datas['total_amount']*($datas['agent_comm']/100),2));
	
			}
		
		}
		echo array_sum($a_amt).' / '.$datas['agent_name'].' ( '.$datas['agent_comm'] .' % )';
		
	}	
	public function get_inv_info()
	{
		$this->load->model('expense_model');
		$input = $this->input->get();
		$data=$this->expense_model->get_inv_info_details($input);
		 echo '<p><b>Invoice Details</b></p>';
		if(isset($data) && !empty($data))
		{
			
			foreach($data as $val)
			{
			    echo '<p><input type="checkbox" name="inv_details[]" value="'.$val['inv_no'].'" />'.$val['inv_no'].'</p>';
			}
		}
		else
		{
				echo "New Invoice not created....";
		}
	
	}
	public function search_fixed()
	{
		$search_data=$this->input->get();
		$this->load->model('expense_model');
		$data['expense']=$this->expense_model->get_expense_details('fixed');
		$data['expense1']=$this->expense_model->get_expense_details1('fixed');
		$data['all_expense']=$this->expense_model->get_all_fixed_expense($search_data);
		$this->load->view('expense/search_fixed',$data);
	}
	public function search_variable()
	{
		$search_data=$this->input->get();
		$this->load->model('expense_model');
		$data['expense']=$this->expense_model->get_expense_details('variable');
		//expense type 
		$this->load->model('vendor/vendor_model');
		$data['all_supplier']=$this->vendor_model->get_vendor();
		$this->load->model('customer/customer_model');
		$data['all_customer']=$this->customer_model->get_customer();
		$this->load->model('po/gen_model');
		$data['po_no']=$this->gen_model->get_all_po_for_expense();
		$this->load->model('sales_order/sales_order_model');
		$data['so_no']=$this->sales_order_model->get_all_so_for_expense();
		
		$this->load->model('package/package_model');
		$data['lr_no']=$this->package_model->get_all_lrno_for_expense();
			
		$data['all_expense']=$this->expense_model->get_all_var_expense($search_data);
		$this->load->view('expense/search_variable',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
