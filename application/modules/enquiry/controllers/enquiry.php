<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Enquiry extends MX_Controller {

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
		$this->load->model('enquiry/enquiry_model');
                $this->load->model('master_style/master_model');
                $this->load->model('po/gen_model');
                $data["last_id"]=$this->master_model->get_last_id('enq_code');		
           
                $this->template->write_view('content', 'enquiry/index',$data);
                $this->template->render();       
	}
        public function add_enquiry()
	{
		$this->load->model('enquiry/enquiry_model');		
		$this->load->model('master_style/master_model');		
		$data["last_id"]=$this->master_model->get_last_id('enq_code');              		          
                $input=$this->input->post(); 
                $user_info=$this->session->userdata('user_info');
                $input['created_by']= $user_info[0]['id'];$user_info[0]['id'];
                $enq_id=$data['last_id'][0]['value'];  
                $input['enquiry_no']=$enq_id;                 
                $input['followup_date']=date('Y-m-d',strtotime($input['followup_date']));
                    //echo"<pre>;"; print_r($input); exit;
                $insert_id =  $this->enquiry_model->insert_enquiry($input);                        
              //  $this->enquiry_model->update_enquiry_no($input,$insert_id);                 
                $insert_id++;
                $inc['type']='enq_code';
                $inc['value']='ERQ000'.$insert_id;
                $this->enquiry_model->update_increment($inc);
                redirect($this->config->item('base_url').'enquiry/enquiry_list');
        }
	public function enquiry_list()
	{
            $this->load->model('enquiry/enquiry_model');
            $data['all_enquiry']=$this->enquiry_model->get_all_enquiry();
            $this->template->write_view('content', 'enquiry_list',$data);
            $this->template->render(); 
        
	}
        public function enquiry_edit($id)
	{
            $this->load->model('enquiry/enquiry_model');
            $data['all_enquiry']=$this->enquiry_model->get_all_enquiry_by_id($id);
            //echo "<pre>"; print_r($data); exit;
            $this->template->write_view('content', 'enquiry_edit',$data);
            $this->template->render(); 
	}
        public function add_duplicate_email()
        {
               $this->load->model('enquiry/enquiry_model');
               $input=$this->input->get('value1');
               $validation=$this->enquiry_model->add_duplicate_email($input);               
               $i=0; if($validation){$i=1;}if($i==1){echo "Email Already Exist";}
         }	
	public function update_enquiry($id)
	{
            $this->load->model('enquiry/enquiry_model');		
            $this->load->model('master_style/master_model');                        		          
            $input=$this->input->post();    
            $input['followup_date']=date('Y-m-d',strtotime($input['followup_date']));
            $user_info=$this->session->userdata('user_info');
            $input['created_by']= $this->session->userdata['user_info'][0]['id'];            
            $insert_id =  $this->enquiry_model->update_enquiry($input,$id);                
            redirect($this->config->item('base_url').'enquiry/enquiry_list');
        }
        public function enquiry_delete()
	{
            $this->load->model('enquiry/enquiry_model');		
            $id=$this->input->POST('value1'); 
            $data['all_enquiry']=$this->enquiry_model->get_all_enquiry();
            $del_id =  $this->enquiry_model->delete_enquiry($id);          
            redirect($this->config->item('base_url').'enquiry/enquiry_list',$data);
        }
         public function enquiry_view($id)
	{
            $this->load->model('enquiry/enquiry_model');		
             $data['all_enquiry']=$this->enquiry_model->get_all_enquiry_by_id($id);
            //echo "<pre>"; print_r($data); exit;
            $this->template->write_view('content', 'enquiry_view',$data);
            $this->template->render(); 
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
