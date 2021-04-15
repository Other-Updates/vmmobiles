<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reference_groups extends MX_Controller {

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
	
	public function index()
	{
		$this->load->model('customer/customer_model');
		$this->load->model('reference_groups/reference_groups_model');
		$data["customer"]=$this->customer_model->get_customer();
		$data['all_state']=$this->customer_model->state();
		//$data['all_agent']=$this->agent_model->get_agent();
                //data['reference_types']=$this->reference_groups_model->get_reference_types();
		//print_r($data);exit;
		$this->template->write_view('content', 'reference_groups/index',$data);
                $this->template->render();       
	}
	public function insert_customer()
	{
		$this->load->model('customer/customer_model');
		$input_data=array(
					'name'=>$this->input->post('name'),
					'store_name'=>$this->input->post('store'),
					'address1'=>$this->input->post('address1'),
					'address2'=>$this->input->post('address2'),
					'city'=>$this->input->post('city'),
					//'pincode'=>$this->input->post('pin'),
					'mobil_number'=>$this->input->post('number'),
					'email_id'=>$this->input->post('mail'),
					'bank_name'=>$this->input->POST('bank'),
					'bank_branch'=>$this->input->POST('branch'),
					'account_num'=>$this->input->POST('acnum'),
					//'selling_percent'=>$this->input->post('percentage'),
					'state_id'=>$this->input->post('state_id'),
					'ifsc'=>$this->input->post('ifsc'),
					//'c_st'=>$this->input->post('st'),
					//'c_cst'=>$this->input->post('cst'),
					//'c_vat'=>$this->input->post('vat'),
					'agent_name'=>$this->input->post('agent_name'),
					//'agent_comm'=>$this->input->post('agent_comm'),
					'payment_terms'=>$this->input->post('payment_terms'),
					'tin'=>$this->input->post('tin'),
                                        'customer_type'=>$this->input->post('customer_type'),
                                        'sell_price'=>$this->input->post('sell_price'),
					);
               
		$this->customer_model->insert_customer($input_data);
		$data["customer"]=$this->customer_model->get_customer();
		redirect($this->config->item('base_url').'customer/index',$data);   
	}
	
	
	public function edit_customer($id)
	{
		$this->load->model('customer/customer_model');
		$this->load->model('customer/agent_model');
		$data['all_state']=$this->customer_model->state();
		$data["customer"]=$this->customer_model->get_customer1($id);
		$data['all_agent']=$this->agent_model->get_agent();
                $data['customer_types']=$this->customer_model->get_customer_types();
		$this->template->write_view('content', 'customer/update_customer',$data);
        $this->template->render();
	}
	public function update_customer()
	{
		$this->load->model('customer/customer_model');
		$id=$this->input->POST('id');
		$input=array(
				'name'=>$this->input->post('name'),
				'store_name'=>$this->input->post('store'),
				'address1'=>$this->input->post('address1'),
				'address2'=>$this->input->post('address2'),
				'city'=>$this->input->post('city'),
				//'pincode'=>$this->input->post('pin'),
				'mobil_number'=>$this->input->post('number'),
				'email_id'=>$this->input->post('mail'),
				'bank_name'=>$this->input->POST('bank'),
				'bank_branch'=>$this->input->POST('branch'),
				'account_num'=>$this->input->POST('acnum'),
				//'selling_percent'=>$this->input->post('percentage'), 
				'state_id'=>$this->input->post('state_id'),
				'ifsc'=>$this->input->post('ifsc'),
				//'c_st'=>$this->input->post('st'),
				//'c_cst'=>$this->input->post('cst'),
				//'c_vat'=>$this->input->post('vat'),
				'agent_name'=>$this->input->post('agent_name'),
				//'agent_comm'=>$this->input->post('agent_comm'),
				'payment_terms'=>$this->input->post('payment_terms'),
				'tin'=>$this->input->post('tin'),
                                'customer_type'=>$this->input->post('customer_type'),
                                'sell_price'=>$this->input->post('sell_price'),
				);	
                // echo "<pre>"; print_r($input_data); exit;
		$this->customer_model->update_customer($input,$id);
		redirect($this->config->item('base_url').'customer/');
	}
	
	public function delete_customer()
        {
         $this->load->model('customer/customer_model');
         $data["customer"]=$this->customer_model->get_customer();
         $id=$this->input->POST('value1');
         {
         $this->customer_model->delete_customer($id);

         redirect($this->config->item('base_url').'customer/index',$data);
         }
        }
	public function add_duplicate_email()
            {
		$this->load->model('customer/customer_model');	
		$input=$this->input->get('value1');
		$validation=$this->customer_model->add_duplicate_email($input);
		$i=0; if($validation){$i=1;}if($i==1){echo "Email Already Exist";}
	
         }	
	 public function update_duplicate_email()
	 {
		$this->load->model('customer/customer_model');	
		$input=$this->input->post('value1');
		$id=$this->input->post('value2');
		$validation=$this->customer_model->update_duplicate_email($input,$id);
		$i=0; if($validation){$i=1;}if($i==1){echo "Email already Exist";}
	
	 }	
          public function add_state()
	 {
		$this->load->model('customer/customer_model');	
		$input=$this->input->get();		
		$insert_id =$this->customer_model->insert_state($input);
                echo $insert_id;
	 }
        
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
