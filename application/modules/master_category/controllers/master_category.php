<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_category extends MX_Controller {

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

function redirect_function($url)
{
    ?>
    <script>
        window.location.href = "<?php echo $url;?>";
    </script>
  <?php
}   
public function index()
{
        $this->load->model('master_category/master_category_model');
        $data['corrective_action']= $corrective_action = $this->master_category_model->get_all_corrective_action(); 
               //   echo"<pre>"; print_r($data); exit;
        $data["detail"]= $details =$this->master_category_model->get_all_category();
        $this->template->write_view('content','master_category/index',$data);
        $this->template->render();
        }

public function insert_master_category()
{
    $this->load->model('master_category/master_category_model');
    $input=array('category'=>$this->input->post('category'));
     if($input['category'] != '')
    {
        $this->master_category_model->insert_master_category($input);
        $data["detail"]=$this->master_category_model->get_all_category();
        redirect($this->config->item('base_url').'master_category/index',$data);
    }
    else
    {
        $data["detail"]=$this->master_category_model->get_all_category();
        $this->template->write_view('content','master_category/index',$data);
        $this->template->render();  
    }
}
public function update_category()
{
    $this->load->model('master_category/master_category_model');
    $data = $this->input->post();
        $action_ids=$data['actionId'];
        unset($data["actionId"]);
        unset($data["sub_categoryName"]);    
       // echo"<pre>"; print_r($data); exit;
        $this->master_category_model->update_defect($data);
        $insert_id = $data['cat_id'];
        if(isset($insert_id) && !empty($insert_id)){
            if(isset($action_ids)&&!empty($action_ids))
            {
                foreach($action_ids as $key){
                    $datas[] = array('cat_id' => $insert_id , 'actionId' => $key );
                }
                $defect_type_id= $this->master_category_model->insert_defect_type_corrective_action($datas,$insert_id);
            }
        }
         $url=$this->config->item('base_url')."master_category/index";    
        $this->redirect_function($url);
}

public function delete_master_category()
{
    $this->load->model('master_category/master_category_model');
    $id=$this->input->get('value1');
    //echo "<pre>"; print_r($id); exit;
    $this->master_category_model->delete_master_category($id);
    $data["detail"]=$this->master_category_model->get_all_category();
    redirect($this->config->item('base_url').'master_category/index',$data);
   
}
public function add_duplicate_category()
{
    $this->load->model('master_category/master_category_model');	
    $input=$this->input->get('value1');
    $validation=$this->master_category_model->add_duplicate_category($input);    
    $i=0; if($validation){$i=1;}if($i==1){echo "Category Name already Exist";}

}		
public function update_duplicate_category()
{
    $this->load->model('master_category/master_category_model');	
    $input=$this->input->post('value1');
    $id=$this->input->post('value2');
    $validation=$this->master_category_model->update_duplicate_category($input,$id);
    //echo $input; echo $id; exit;
    $i=0; if($validation){$i=1;}if($i==1){echo "Category Name already Exist";}

}
function save_defect()
    { 
        $this->load->model('master_category/master_category_model');	
        $data= $this->input->post();      
        $action_ids=$data['actionId'];
        unset($data["actionId"]);
        unset($data["sub_categoryName"]);
     
        $insert_id = $this->master_category_model->insert_defect($data);
        if(isset($insert_id) && !empty($insert_id)){
            if(isset($action_ids)&&!empty($action_ids))
            {
                foreach($action_ids as $key){
                    $datas[] = array('cat_id' => $insert_id , 'actionId' => $key );
                    
                }
                $defect_type_id= $this->master_category_model->insert_defect_type_corrective_action($datas,$insert_id);
            }
        }
        $url=$this->config->item('base_url')."master_category/index";    
        $this->redirect_function($url);
    }
    
    function update_cat($id)
    {
        $this->load->model('master_category/master_category_model');      
        $data['defect_type']=$defect_type =$this->master_category_model->get_all_defect_type_data($id); 
       //echo"<pre>";print_r($defect_type);exit;        
        $this->template->write_view('content','master_category/edit_category',$data);
        $this->template->render(); 
    }
    function save_action()
    {
        $this->load->model('master_category/master_category_model');
        $datas = $this->input->post();
        $data=$datas['sub_categoryName'];

        if(isset($datas)&&!empty($datas))
        {
              //echo"<pre>"; print_r($datas); exit;
        $insert_id = $this->master_category_model->insert_action($datas);
        echo "<tbody><tr><td><input type='checkbox' name='actionId[]' value='$insert_id'></td>
            <td class='edit_name hide_edit'><input type='text' id='$insert_id' value='$data' disabled /></td>
            <td class='text-right'><a href='javascript:void(0);' class='edit_corrective_action' maze='$data' id='$insert_id' hijacked='yes'><i class='fa fa-edit'></i></a> &nbsp; <a id='$insert_id' class='delete_corrective_action' data-original-title='Delete' hijacked='yes'><i class='fa fa-close'></i></a></td>
        </tr><tbody>";
        $this->skip_template_view();
        }
        
    }
     function delete_action_by_id($id)
    {
        $this->load->model('master_category/master_category_model');
        $datas = $this->input->post();  
      
        //$user_id= $this->session->userdata('iUserId');
        echo $this->master_category_model->delete_action_by_ids($datas['del_id']);  
        $this->skip_template_view();
    
    }
    function edit_action_by_id($id)
    {
        $this->load->model('master_category/master_category_model');
        $datas = $this->input->post();  
        $id=$datas['actionId'];
        //echo"<pre>"; print_r($datas); exit;
        unset($datas['actionId']);
       
        echo $this->master_category_model->update_action_by_ids($id,$datas);  
        $this->skip_template_view();
    }
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
