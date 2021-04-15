<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_firms extends MX_Controller {

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
		$this->load->model('manage_firms/manage_firms_model');
               
	}
	
	public function index()
	{
            $data["firms"]=$this->manage_firms_model->get_all_firms();
            $this->template->write_view('content', 'manage_firms/index',$data);
            $this->template->render();       
	}
        public function insert_firms(){

            if($this->input->post())
            {
                $input = $this->input->post();
                $input['status'] = 1;
                $input['created_date'] = date('Y-m-d H:i:s');
               // echo "<pre>"; print_r($input); exit;
                $this->manage_firms_model->insert_firm($input); 
                redirect($this->config->item('base_url').'manage_firms');
            }
	}
        public function edit_firm($id)
	{
            $data["firms"]=$this->manage_firms_model->get_firm_by_id($id);
            $this->template->write_view('content', 'manage_firms/update_firm',$data);
            $this->template->render();
	}
        public function update_firm($id)
	{
            if($this->input->post())
            {               
                $input = $this->input->post();
                $this->manage_firms_model->update_firm($input,$id);              
                redirect($this->config->item('base_url').'manage_firms');
            }
        }
         public function delete_firm()
	{
                $id=$this->input->POST('value1');
                $this->manage_firms_model->delete_firm($id);
                redirect($this->config->item('base_url').'manage_firms');
	}
        public function add_duplicate_firm()
        {

            $input=$this->input->get('value1');
            $validation=$this->manage_firms_model->add_duplicate_firm($input);
            $i=0; if($validation){$i=1;}if($i==1){echo"Firm Name Already Exist";}

        }
        public function update_duplicate_firm()
        {	
            $input=$this->input->get('value1');
            $id=$this->input->get('value2');
            $validation=$this->manage_firms_model->update_duplicate_firm($input,$id);

            $i=0; if($validation){$i=1;}if($i==1){echo "Firm Name Already Exist";}

        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
