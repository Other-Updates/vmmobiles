<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends MX_Controller {

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
		$this->load->model('product/product_model');
                $this->load->model('master_style/master_model');
	}
	
	public function index()
	{
            $data["product"]=$this->product_model->get_product();            
            $data["last_id"]=$this->master_model->get_last_id('m_code');    
            $this->template->write_view('content', 'product/index',$data);
            $this->template->render();       
	}
        public function insert_product(){

            if($this->input->post())
            {
                $data["product"]=$this->product_model->get_product();
                $this->load->helper('text');

                $config['upload_path'] = './attachement/product';

                $config['allowed_types'] = '*';

                $config['max_size']	= '2000';

                $this->load->library('upload', $config);

                $upload_data['file_name']=$_FILES;
                if(isset($_FILES) && !empty($_FILES))
                {
                        $upload_files = $_FILES;
                        if($upload_files['admin_image'] !='')
                        {
                                $_FILES['admin_image'] = array(
                                'name' => $upload_files['admin_image']['name'],
                                'type' => $upload_files['admin_image']['type'],
                                'tmp_name' => $upload_files['admin_image']['tmp_name'],
                                'error' => $upload_files['admin_image']['error'],
                                'size' => '2000'
                                );
                        $this->upload->do_upload('admin_image');

                        $upload_data = $this->upload->data();

                        $dest= getcwd()."/attachement/product/" .$upload_data['file_name'];

                        $src=$this->config->item("base_url").'attachement/product/'.$upload_data['file_name'];

                        }
                }
                $input_data['admin']['admin_image']=$upload_data['file_name'];
                $input=array('model_no'=>$this->input->post('model_no'),'product_name'=>$this->input->post('product_name'),
                'product_description'=>$this->input->post('product_description'),'product_image'=>$upload_data['file_name'],
                'type'=>$this->input->post('type'),'min_qty'=>$this->input->post('min_qty'),'reorder_quantity'=>$this->input->post('reorder_quantity'),
                'cost_price'=>$this->input->post('cost_price'),'cash_cus_price'=>$this->input->post('cash_cus_price'),'credit_cus_price'=>$this->input->post('credit_cus_price'),'cash_con_price'=>$this->input->post('cash_con_price'),'credit_con_price'=>$this->input->post('credit_con_price'));
                $insert_id = $this->product_model->insert_product($input);              
                $data["product"]= $details =$this->product_model->get_product();
                redirect($this->config->item('base_url').'product/index',$data);
            }
	}
        public function edit_product($id)
	{
            $data["product"]= $details =$this->product_model->get_product_by_id($id);
               //echo "<pre>"; print_r($data); exit;
            $this->template->write_view('content', 'product/update_product',$data);
            $this->template->render();
	}
        public function update_products()
	{
            if($this->input->post())
            {
               
                $id = $this->input->post('id');
                $input=array('id'=>$this->input->post('id'),'model_no'=>$this->input->post('model_no'),'product_name'=>$this->input->post('product_name'),
                'product_description'=>$this->input->post('product_description'),'type'=>$this->input->post('type'),'min_qty'=>$this->input->post('min_qty'),
                'reorder_quantity' => $this->input->post('reorder_quantity'),'cost_price'=>$this->input->post('cost_price'),
                'cash_cus_price'=>$this->input->post('cash_cus_price'),'credit_cus_price'=>$this->input->post('credit_cus_price'),
                'cash_con_price'=>$this->input->post('cash_con_price'),'credit_con_price'=>$this->input->post('credit_con_price'));
                //$data["product"]=$this->product_model->get_product();
                $this->load->helper('text');
                $config['upload_path'] = './attachement/product/';
                $config['allowed_types'] = '*';
                $config['max_size']	= '2000';
                $this->load->library('upload', $config);
                $upload_data['file_name']=$_FILES;
                if (isset($_FILES) && !empty($_FILES)) {
                $upload_files = $_FILES;
                if ($upload_files['admin_image']['name'] != '') {
                    $_FILES['admin_image'] = array(
                        'name' => $upload_files['admin_image']['name'],
                        'type' => $upload_files['admin_image']['type'],
                        'tmp_name' => $upload_files['admin_image']['tmp_name'],
                        'error' => $upload_files['admin_image']['error'],
                        'size' => '2000'
                    );
                    $this->upload->do_upload('admin_image');

                    $upload_data = $this->upload->data();

                 $dest= getcwd()."/attachement/product/" .$upload_data['file_name'];

                    $src=$this->config->item("base_url").'attachement/product/'.$upload_data['file_name'];
                    $input_data['admin_image'] = $upload_data['file_name'];
                     $input=array('model_no'=>$this->input->post('model_no'),'product_name'=>$this->input->post('product_name'),
                'product_description'=>$this->input->post('product_description'),'product_image'=>$upload_data['file_name'],
                'type'=>$this->input->post('type'),'min_qty'=>$this->input->post('min_qty'),
                'reorder_quantity'=>$this->input->post('reorder_quantity'),'cost_price'=>$this->input->post('cost_price'),
                'cash_cus_price'=>$this->input->post('cash_cus_price'),'credit_cus_price'=>$this->input->post('credit_cus_price'),
                'cash_con_price'=>$this->input->post('cash_con_price'),'credit_con_price'=>$this->input->post('credit_con_price'));
   
                }
            }
                $this->product_model->update_product($input,$id);              
                redirect($this->config->item('base_url').'product/index');
            }
        }
         public function delete_product()
	{
                $data["product"]= $details =$this->product_model->get_product();
                $id=$this->input->POST('value1');
                $this->product_model->delete_product($id);
                redirect($this->config->item('base_url').'product/index',$data);
	}
        public function add_duplicate_product()
        {

            $input=$this->input->get('value1');
            $validation=$this->product_model->add_duplicate_product($input);
            $i=0; if($validation){$i=1;}if($i==1){echo"Model Number Already Exist";}

        }
        public function update_duplicate_product()
        {	
            $input=$this->input->get('value1');
            $id=$this->input->get('value2');
            $validation=$this->product_model->update_duplicate_product($input,$id);

            $i=0; if($validation){$i=1;}if($i==1){echo "Model Number Already Exist";}

        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
