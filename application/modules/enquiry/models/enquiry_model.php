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
 
class enquiry_model extends CI_Model{

	
        private $erp_enquiry	= 'erp_enquiry';
         private $increment_table= 'increment_table';
	function __construct()
	{
		parent::__construct();

	}
	
	public function insert_enquiry($data)
	{
		if ($this->db->insert($this->erp_enquiry, $data)) {
			$insert_id = $this->db->insert_id();
			
			return $insert_id;
		}
		return false;
	}
        public function update_enquiry_no($data,$id)
	{
		$this->db->where($this->erp_enquiry.'.id',$id);
		if ($this->db->update($this->erp_enquiry,$data)) {
			return true;
		}
		return false;
	}
         public function update_increment($id)
	{
		$this->db->where($this->increment_table.'.id',11);
		if ($this->db->update($this->increment_table,$id)) {
			return true;
		}
		return false;
	}
        public function add_duplicate_email($input)
        {
            $this->db->select('*');
            $this->db->where('status',1);
            $this->db->where('customer_email',$input);
            $query=$this->db->get($this->erp_enquiry);
            if ($query->num_rows() >= 1) 
            {
             return $query->result_array();
            }
        }
         public function get_all_enquiry()
	 {
            $this->db->select('*');   
            $user_info=$this->session->userdata('user_info');
            if ($user_info[0]['role'] == 5){
                 $this->db->where('created_by',$user_info[0]['id']);
                $query = $this->db->get($this->erp_enquiry)->result_array();
            }
            else{
                $query = $this->db->get($this->erp_enquiry)->result_array();
            }
            return $query;
	  } 
          public function get_all_enquiry_by_id($id)
	 {
            $this->db->select('*');
            $this->db->where('id',$id);
            $query = $this->db->get($this->erp_enquiry)->result_array();
            return $query;
        } 
        
          public function get_all_enquiry_details($id)
	 {
            $this->db->select('*');
            $this->db->where('created_by',$id);
            $user_info=$this->session->userdata('user_info');
             if ($user_info[0]['role'] == 5){
                 
                 
             }
            $query = $this->db->get($this->erp_enquiry)->result_array();
            return $query;
        } 
         public function update_enquiry($data,$id)
	{
		$this->db->where($this->erp_enquiry.'.id',$id);
		if ($this->db->update($this->erp_enquiry,$data)) {
			return true;
		}
		return false;
	}
          public function delete_enquiry($id)
	{
                $this->db->where('id', $id);
		   if ($this->db->update($this->erp_enquiry,$data=array('status'=>0)))
			{
			  return true;
			}
		   return false;
	}


}