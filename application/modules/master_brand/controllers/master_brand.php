<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class master_brand extends MX_Controller {

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
	
function __construct(){
    parent::__construct();
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->library('session');
    $this->load->library('email');
    $this->load->database();
    $this->load->library('form_validation');
}

public function index(){
    $this->load->model('master_brand/master_brand_model');	 
    $data["brand"]=$this->master_brand_model->get_brand();
    $this->template->write_view('content','master_brand/index',$data);
    $this->template->render();	
    }

public function insert_brand(){
    $this->load->model('master_brand/master_brand_model');
    $input=array('brands'=>$this->input->post('brands'));
    $this->master_brand_model->insert_brand($input);
    $data["brand"]=$this->master_brand_model->get_brand();
    redirect($this->config->item('base_url').'master_brand/index',$data);
}
public function update_brand(){
    $this->load->model('master_brand/master_brand_model');
    $id=$this->input->post('value1');
    $input=array('brands'=>$this->input->post('value2'));
    $this->master_brand_model->update_brand($input,$id);
    $data["brand"]=$this->master_brand_model->get_brand();
    redirect($this->config->item('base_url').'master_brand/index',$input);
}
public function delete_master_brand(){
    $this->load->model('master_brand/master_brand_model');
    $id=$this->input->get('value1');
    {
    $this->master_brand_model->delete_master_brand($id);
    $data["brand"]=$this->master_brand_model->get_brand();
    redirect($this->config->item('base_url').'master_brand/index',$input);
  }
 }
public function add_duplicate_brandname()
{
    $this->load->model('master_brand/master_brand_model');	
    $input=$this->input->post('value1');
    $validation=$this->master_brand_model->add_duplicate_brandname($input);
    $i=0; if($validation){$i=1;}if($i==1){echo"Brand Name Already Exist";}

}
public function update_duplicate_brandname()
{
    $this->load->model('master_brand/master_brand_model');	
    $input=$this->input->get('value1');
    $id=$this->input->get('value2');
    $validation=$this->master_brand_model->update_duplicate_brandname($input,$id);

    $i=0; if($validation){$i=1;}if($i==1){echo "Brand Name Already Exist";}

}
}