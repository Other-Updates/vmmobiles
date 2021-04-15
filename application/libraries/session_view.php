<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session_view {

	function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->library('session');
		date_default_timezone_set("Asia/Calcutta");
		//$this->clear_other_sessions();
	}

	protected function clear_other_sessions(){

		$current_page = array($this->ci->router->class=>array($this->ci->router->method=>""));
		$all_filters = $this->ci->session->userdata("filters");
		
		if(!empty($all_filters)) {
			/*Different controllers*/
			$new_filter = array_intersect_key($all_filters, $current_page);
			
			/*Same controller different method*/
			if(key($new_filter) == $this->ci->router->class) {

				$new_filter[key($new_filter)] = array_intersect_key($all_filters[key($new_filter)], $current_page[key($new_filter)]);
			}

			$this->ci->session->set_userdata("filters",$new_filter);
			$all_filters1 = $this->ci->session->userdata("filters");
		}

	}
	function clear_session($class=null,$method=null)
	{
		$class = (isset($class)) ? $class : $this->ci->router->class;
		$method = (isset($method)) ? $method : $this->ci->router->method;

		$filters = $this->ci->session->userdata("filters");
		if(isset($filters[$class]))
		{
			$get_session = $filters[$class];
			if(isset($get_session[$method]))
			{
				$get_session[$method] = "";
				$this->ci->session->set_userdata("filters",array($class =>$get_session));
			}
		}
		
	}
	function add_session($class=null,$method=null,$data)
	{
		$class = (isset($class)) ? $class : $this->ci->router->class;
		$method = (isset($method)) ? $method : $this->ci->router->method;
		$old_data = $this->ci->session->userdata("filters");
		if(isset($old_data[$class]) && !empty($old_data[$class]))
			$old_data[$class][$method]= $data;
		else
		
			$old_data[$class] = array($method =>$data);
		
		$this->ci->session->set_userdata("filters",$old_data);
		$filters = $this->ci->session->userdata("filters");		
	}
	function get_session($class=null,$method=null)
	{
		
		$class = (isset($class)) ? $class : $this->ci->router->class;
		$method = (isset($method)) ? $method : $this->ci->router->method;

		$filters = $this->ci->session->userdata("filters");		
		if(isset($filters[$class]))
		{
			$session_data = $filters;
			$get_session = $session_data[$class];
			if(isset($get_session[$method]))
				return $get_session[$method];
		
		}
	}
	
}

?>