<?php 
class Leave extends MX_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('user_auth');
		if(!$this->user_auth->active_application())
		{	
			redirect($this->config->item("base_url")."users/login/");

		}
		if($this->router->method=="index")
		   $this->router->method="apply_or_modify_leaves";
		if($this->router->method == "view_user_leave" || $this->router->method == "view_all_user_leaves")
		{
			if(!$this->user_auth->get_user_permission($this->router->class.":view_user_leaves")) {
			
				$this->session_messages->add_message('warning','You dont have permission to access this area');
				redirect($this->config->item("base_url")."users/");
			}
		}
		
		else
		{
			if(!$this->user_auth->get_user_permission($this->router->class.":".$this->router->method)) {
			
				$this->session_messages->add_message('warning','You dont have permission to access this area');
				redirect($this->config->item("base_url")."users/");
			}
		}
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library("pagination");
		$this->load->model("masters/user_department_model");
		$this->load->model("masters/users_model");
		
		//$this->pre_print->view($this->session->all_userdata());
		$datam["messages"]= $this->session_messages->view_all_messages();
		$this->template->write_view('session_msg', 'masters/session_messages',$datam);
	}
	//Leave Module
	function index()
	{
		redirect($this->config->item('base_url')."attendance/leave/apply_or_modify_leaves/");
	}
	function apply_or_modify_leaves()
	{
		
		$this->load->model('masters/users_model');
		$this->load->model('masters/department_model');
		$this->load->model('masters/designation_model');
		$this->load->model('masters/user_roles_model');
		$this->load->model('masters/options_model');


		$data["default_number_of_records"] = $this->options_model->get_option_by_name('default_number_of_records');

		$result = array();
		$filter=null;
		
		$data["roles"] = $this->user_roles_model->get_user_role($this->user_auth->get_user_id());
			
		if($this->input->post("search"))
		{
		
			$filter = $this->input->post();
		
			if(isset($filter["search"]))
				unset($filter["search"]);
			
			$data["no_of_users1"] = $this->users_model->get_filter_user_count($filter,1);
			
			$this->session_view->add_session(null,null,$filter);
			
			redirect($this->config->item('base_url')."attendance/leave/apply_or_modify_leaves/");
		}
		else
		{
			$filter = $this->session_view->get_session(null,null);
			
			if(isset($filter) && !empty($filter))
			{
				$data["no_of_users1"] = $this->users_model->get_filter_user_count($filter,1);
				
			}
			else
			{
				$data["no_of_users1"] = $this->users_model->get_users_count(1);
				
			}
			//print_r($filter);
		
		}
		if(isset($filter["show_count"]))
		
			$default = $filter["show_count"];
		
		else
		{
			if(isset($data["default_number_of_records"]) && !empty($data["default_number_of_records"]))
		
				$default =$data["default_number_of_records"][0]["value"];
			else
				$default = 10;
		}
		
		if(isset($filter["inactive"]))
			$data["status"] = TRUE;
		//$result['suffix'] = '?show='.$default ;
		$result["total_rows"] = $data["no_of_users1"][0]['count'];
		$result["base_url"] = $this->config->item('base_url') . "attendance/leave/apply_or_modify_leaves/";
		$result["per_page"] = $default;
		$data["count"] = $default;
		$result["num_links"] =3;
		$result["uri_segment"] = 4;
		$result['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
		$result['full_tag_close'] = '</ul>';
		$result['prev_link'] = '&lt;';
		$result['prev_tag_open'] = '<li>';
		$result['prev_tag_close'] = '</li>';
		$result['next_link'] = '&gt;';
		$result['next_tag_open'] = '<li>';
		$result['next_tag_close'] = '</li>';
		$result['cur_tag_open'] = '<li class="current"><a href="#">';
		$result['cur_tag_close'] = '</a></li>';
		$result['num_tag_open'] = '<li>';
		$result['num_tag_close'] = '</li>';
		 
		$result['first_tag_open'] = '<li>';
		$result['first_tag_close'] = '</li>';
		$result['last_tag_open'] = '<li>';
		$result['last_tag_close'] = '</li>';
		 
		$result['first_link'] = '&lt;&lt;';
		$result['last_link'] = '&gt;&gt;';
		$this->pagination->initialize($result);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		if($default == "all")
			$data['users'] = $this->users_model->get_users_with_dept($filter,1);
		else
			$data['users'] = $this->users_model->get_users_with_dept_by_limit($result["per_page"],$page,$filter,1);
		$data["links"] = $this->pagination->create_links();
		$data["start"] = $page;
		$data["departments"] = $this->department_model->get_all_departments_by_status(1);
		$data["designations"] = $this->designation_model->get_all_designations();
		//print_r($filter);
		//$this->pre_print->viewExit($data);
	
		$this->template->write_view('content', 'attendance/user_leaves',$data);
		$this->template->render();
	
	}
	function view_user_leaves($user_id)
	{
		$this->load->model('masters/available_leaves_model');
		$this->load->model('masters/users_model');
		$this->load->model('leave_model');
		$this->load->model('masters/user_history_model');
		$this->load->model('masters/options_model');
		$this->load->model('masters/user_department_model');
		$this->load->model('masters/user_salary_model');
		$this->load->model('masters/user_roles_model');
		$data["roles"] = $this->user_roles_model->get_user_role($this->user_auth->get_user_id());
		$options = array('week_starting_day','month_starting_date');
		$data["enable_earned_leave"]= $this->options_model->get_option_by_name("enable_earned_leave");
		$settings= $this->options_model->get_option_by_name($options);
		$data["doj"] = $this->user_history_model->get_history_by_user_id_and_type($user_id,'doj');
		$data["dept"] = $this->user_department_model->get_department_by_user_id($user_id);
		$data["name"] = $this->users_model->get_user_name_by_user_id($user_id);			
		$joined_date = explode("-",$data["doj"][0]["date"]);
		if(isset($settings) && !empty($settings))
		{
			foreach($settings as $key =>$set)
			{
				$data[$set["key"]] = $set["value"];
			}
		}
		if($this->input->post("go"))
		{
			$filter = $this->input->post();
			$this->session_view->add_session(null,null,$filter);
			
			$data["year"] = $filter["year"];
			$data["month"] = $filter["month"];
			$data["year"] = $filter["year"];
			$data["month"] = $filter["month"];
			$data["start_date"] = $filter["start_date"];
			$data["end_date"] = $filter["end_date"];
			
			$data["month_start_date"] = $filter["month_start_date"];
			$data["month_end_date"]  = $filter["month_end_date"];
			// week end date
				$nextMonthStart = mktime(0,0,0,$data["month"]+1,1,$data["year"]);
				$last_saturday = date("Y-m-d H:i:s",strtotime("previous saturday", $nextMonthStart));
				$next_date2 = new DateTime($last_saturday.' +6 day');
				$data["week_end_date"] = $next_date2->format('Y-m-d');
				// week start date
				$nextMonthStart = mktime(0,0,0,$data["month"],1,$data["year"]);
				$last_saturday_date = date("d",strtotime("first saturday", $nextMonthStart));
				if(ltrim($last_saturday_date,'0')==8)
					$last_saturday_date =01;
				$data["week_start_date"] = $data["year"]."-".$data["month"]."-".$last_saturday_date;
			if(strtotime($data["start_date"]) < strtotime($data["month_start_date"]))
			{
			   $start_date_val=$data["start_date"];
			}
			else
			{
			   $start_date_val=$data["month_start_date"];
			}
			if($joined_date[0] == $data["year"])
			{
				if($joined_date[1] = $data["month"])
				{
					$start_date_val = $data["doj"][0]["date"];
				}
			}
			$data["user_salary"]	=	$this->user_salary_model->get_user_salary_by_user_id($user_id,$start_date_val);	
			if($data["user_salary"][0]["type"]=="monthly")
			{
				$data["leaves"] = $this->leave_model->get_user_leaves_by_between_dates($user_id,$data["start_date"],$data["end_date"]);
			}
			else
			{
				
				$data["leaves"] = $this->leave_model->get_user_leaves_by_between_dates($user_id,$data["week_start_date"],$data["week_end_date"]);
			}
		}
		else
		{
			$filter = $this->session_view->get_session(null,null);
			
			if(isset($filter) && !empty($filter))
			{
				
				$data["year"]=$filter["year"];
				$data["month"]=$filter["month"];
				$data["start_date"] = $filter["start_date"];
				$data["end_date"] = $filter["end_date"];
				$data["month_start_date"] = $filter["month_start_date"];
				
				$data["month_end_date"]  = $filter["month_end_date"];
				// week end date
				$nextMonthStart = mktime(0,0,0,$data["month"]+1,1,$data["year"]);
				$last_saturday = date("Y-m-d H:i:s",strtotime("previous saturday", $nextMonthStart));
				$next_date2 = new DateTime($last_saturday.' +6 day');
				$data["week_end_date"] = $next_date2->format('Y-m-d');
				// week start date
				$nextMonthStart = mktime(0,0,0,$data["month"],1,$data["year"]);
				$last_saturday_date = date("d",strtotime("first saturday", $nextMonthStart));
				if(ltrim($last_saturday_date,'0')==8)
					$last_saturday_date =01;
				$data["week_start_date"] = $data["year"]."-".$data["month"]."-".$last_saturday_date;
			}
			else
			{
				//$this->pre_print->viewExit($filter);
				$data["year"] = date('Y');
				$data["month"]  = date('m');
			
				$day = $data["month_starting_date"];
				if($data["month_starting_date"]==1)
				{
					if($data["month"]!=12)
					{
						$data["start_date"] =$data["year"]."-".$data["month"]."-".$day;
						$data["end_date"] = $data["year"]."-".($data["month"]+1)."-".$day;
					}
					else
					{
						$data["start_date"]  =$data["year"]."-".$data["month"]."-".$day;
						$data["end_date"]= ($data["year"]+1)."-1-".$day-1;
					}
				}
				else
				{
					if($data["month"]!=12)
					{
						$data["start_date"] = $data["year"]."-".$data["month"]."-".$day;
						$data["end_date"]= $data["year"]."-".($data["month"]+1)."-".($day-1);
					}
					else
					{
						$data["start_date"]= $data["year"]."-".$data["month"]."-".$day;
						$data["end_date"]= ($data["year"]+1)."-1-".($day-1);
					}
				}
				
				$days_in_month = cal_days_in_month(CAL_GREGORIAN, $data["month"], $data["year"]);								
				$data["month_start_date"]=$data["year"]."-".$data["month"]."-1";
				$data["month_end_date"]=$data["year"]."-".$data["month"]."-".$days_in_month;
				// week end date
				$nextMonthStart = mktime(0,0,0,$data["month"]+1,1,$data["year"]);
				$last_saturday = date("Y-m-d H:i:s",strtotime("previous saturday", $nextMonthStart));
				$next_date2 = new DateTime($last_saturday.' +6 day');
				$data["week_end_date"] = $next_date2->format('Y-m-d');
				// week start date
				$nextMonthStart = mktime(0,0,0,$data["month"],1,$data["year"]);
				$last_saturday_date = date("d",strtotime("first saturday", $nextMonthStart));
				if(ltrim($last_saturday_date,'0')==8)
					$last_saturday_date =01;
				$data["week_start_date"] = $data["year"]."-".$data["month"]."-".$last_saturday_date;
			}
			if(strtotime($data["start_date"]) < strtotime($data["month_start_date"]))
				{
				   $start_date_val=$data["start_date"];
				}
				else
				{
				   $start_date_val=$data["month_start_date"];
				}
				
				if($joined_date[0] == $data["year"])
				{
					if($joined_date[1] = $data["month"])
					{
						$start_date_val = $data["doj"][0]["date"];
					}
				}
				$data["user_salary"]	=	$this->user_salary_model->get_user_salary_by_user_id($user_id,$start_date_val);	
				if($data["user_salary"][0]["type"]=="monthly")
				{
					
					$data["leaves"] = $this->leave_model->get_user_leaves_by_between_dates($user_id,$data["start_date"],$data["end_date"]);
						
				}
				else
				{
					

					$data["leaves"] = $this->leave_model->get_user_leaves_by_between_dates($user_id,$data["week_start_date"],$data["week_end_date"]);
						
				}
			
		
		}
		$data["available"] = $this->available_leaves_model->get_user_leaves_by_user_id($user_id);
		
		$data["user_id"] =$user_id;
		$data["status"] = $this->users_model->get_user_status_by_user_id($user_id);
		//$this->pre_print->view($filter);
		$this->template->write_view('content', 'attendance/view_user_leaves',$data);
		$this->template->render();
	
	}
	function apply_leave($user_id)
	{
		$this->load->model('masters/available_leaves_model');
		$this->load->model('leave_model');
		$this->load->model('masters/shift_model');
		$this->load->model('masters/user_department_model');
		$this->load->model('masters/user_shift_model');
		$this->load->model('masters/options_model');
		$this->load->model('masters/users_model');
		
		$data["leave"] = $this->available_leaves_model->get_user_leaves_by_user_id($user_id);
		$data["enable_earned_leave"]= $this->options_model->get_option_by_name("enable_earned_leave");
		$data["name"] = $this->users_model->get_user_name_by_user_id($user_id);		
		$data["dept"] = $this->user_department_model->get_department_by_user_id($user_id);
		$data["user_id"] = $user_id;
		$admin_id = $this->user_auth->get_user_id();
		
			$mail = array();
			$department_head= $this->user_department_model->get_user_dept_head_by_userid($user_id);
			if(isset($department_head) && !empty($department_head))
			{
				$mail["department_head"] = $department_head[0]["email"];
				$mail["head_name"] = $department_head[0]["head_name"];
			}
			$user_mail = $this->users_model->get_user_mail_id_by_user_id($user_id);
			$admin_mail = $this->users_model->get_user_mail_id_by_user_id($admin_id);
			$mail["user"] = $user_mail[0]["email"];
			$mail["user_name"] = $user_mail[0]["name"];
			$mail["admin"] = $admin_mail[0]["email"];
			$mail["admin_name"] = $admin_mail[0]["name"];
			$mail["user_id"] = $user_id;
 		
		
		//Post start 
		if($this->input->post("save"))
		{
			$input = $this->input->post();
			$data["input"] = $input;
			//$this->pre_print->viewExit($input);
			if(isset($input["leave"]) && !empty($input["leave"]))//isset start
			{
				
				if($input["leave"]["leave_type"]=="")
				{
					foreach($input["leave"] as $key=>$val)
					{
							if($key!="session" && $key!="date")
                            {
                                if($key=="leave_type")
                                    $field_name = "Duration Type";
								else if($key=="approved")
        							$field_name = "Status";
                                else
                                    $field_name = ucfirst(str_replace('_',' ',$key));
                                $rules = "required";
                                
                                $leave[] = array(
                                'field'   => "leave[".$key."]" , 
                                'label'   => $field_name, 
                                'rules'   => $rules
                                );
						}
					}
				}
				else if($input["leave"]["leave_type"]==1)
				{
					foreach($input["leave"] as $key=>$val)
					{
							if($key!="leave_to" && $key!= "leave_from")
                            {
							
                                $field_name = ucfirst(str_replace('_',' ',$key));
                                $rules = "required";
                                if($key=="approved")
         						$field_name = "Status";
                                $leave[] = array(
                                'field'   => "leave[".$key."]" , 
                                'label'   => $field_name, 
                                'rules'   => $rules
                                );
							}
					}
					if(!isset($leave["type"]))
					{
						
						$leave[] = array(
								'field'   => "leave[type]" , 
								'label'   => "Leave Type", 
								'rules'   => "required"
								);
					}
				}
				else if($input["leave"]["leave_type"]==2 || $input["leave"]["leave_type"]==3 || $input["leave"]["leave_type"]==4 ||  $input["leave"]["leave_type"]==6)
				{
					foreach($input["leave"] as $key=>$val)
					{
							if($key!="session" && $key!="date")
                            {
                                $field_name = ucfirst(str_replace('_',' ',$key));
                                $rules = "required";
                                if($key=="approved")
                                $field_name = "Status";
                                $leave[] = array(
                                'field'   => "leave[".$key."]" , 
                                'label'   => $field_name, 
                                'rules'   => $rules
                                );
							}
						}
                        if($input["leave"]["leave_type"]==2)
                        {
                            if(!isset($leave["type"]))
                            {
                                
                                $leave[] = array(
                                        'field'   => "leave[type]" , 
                                        'label'   => "Leave Type", 
                                        'rules'   => "required"
                                        );
                            }
                        }
					}
					else if($input["leave"]["leave_type"]==5)
					{
				
						if(isset($input["leave"]["session"]))
							unset($input["leave"]["session"]);
						if(isset($input["leave"]["date"]))
							unset($input["leave"]["date"]);
						
						foreach($input["leave"] as $key=>$val)
						{
							$field_name = "";
							if($key=="leave_from")
								$field_name = "From";
							
							else if($key=="leave_to")
								$field_name = "To";
							
							else if($key=="approved")
								 $field_name = "Status";
							else
								 $field_name = ucfirst(str_replace('_',' ',$key));
							$rules = "required";
									
							$leave[] = array(
							'field'   => "leave[".$key."]" , 
							'label'   => $field_name, 
							'rules'   => $rules
							);  
								
						}
						
				
					}
				
				}
				
			$this->form_validation->set_rules($leave);
			if ($this->form_validation->run() != FALSE)// validation start
			{			
				$lop = 0;
				//$input["leave"]["approved"] = 0;
				$from = '';
				$to='';
				$type ="";
				$new_value = 0;
				
				if(isset($input['leave']['type']))
				{
					if($input['leave']['type']==1)
						$type ='sick leave';
					else if($input['leave']['type']==2)
						$type ='casual leave';
					$leave_type =$this->available_leaves_model->get_user_leaves_by_type($user_id,$type);
				}
				if(isset($input["leave"]["lop"]))
					$lop = 1;
					
				/*if(isset($input["leave"]["approved"]))
					$input["leave"]["approved"] = $input["leave"]["approved"];*/
				
					if(isset($input["leave"]["date"]))
					{	$from_one = $input["leave"]["date"];
						
						$shift_id = $this->user_shift_model->get_user_current_shift_by_user_id($user_id,$from_one);
					}	
					$date_start=$date_end =$break_start=$break_end='';
					if(isset($shift_id) && !empty($shift_id))
					{
						$shift_time =$this->shift_model->get_regular_and_lunch_by_shift_id($shift_id[0]['shift_id']);
						if(isset($shift_time) && !empty($shift_time))
						{
							
							foreach($shift_time as $s_time)
							{
								if($s_time["type"] == 'regular')
								{
									$date_start = $s_time["from_time"];
									$date_end = $s_time["to_time"];
								}
								if($s_time["type"] =="lunch")
								{
									$break_start = $s_time["from_time"];
									$break_end = $s_time["to_time"];
								
								}
							}
						
						}
						
					}
				if($input["leave"]["leave_type"]==1)
				{
					
					
					if($input["leave"]["session"]==1)
					{
						$from = date("Y-m-d",strtotime($input["leave"]["date"]))." ".$date_start;
						
						$to = date("Y-m-d",strtotime($input["leave"]["date"]))." ".$break_start;
					}
					elseif( $input["leave"]["session"]==2)
					{
						$from = date("Y-m-d",strtotime($input["leave"]["date"]))." ".$break_end;
						
						$to = date("Y-m-d",strtotime($input["leave"]["date"]))." ".$date_end;
					}
					
					if(isset($leave_type[0]['available_casual_leave']))
					{
						if($leave_type[0]['available_casual_leave']<=0)
						$lop=1;
						$new_value = $leave_type[0]['available_casual_leave']-0.5;
					}
					else if(isset($leave_type[0]['available_sick_leave']))
					{
						if($leave_type[0]['available_sick_leave']<=0)
						$lop=1;
						$new_value = $leave_type[0]['available_sick_leave']-0.5;
					}
					
					/*if($new_value<0)
						$lop =1;*/
						
					$reject =0;
					
					$full_day_leave1  = $this->leave_model->get_user_leaves_for_diff($user_id,$from);
					$check = 1;
					if(isset($full_day_leave1)&& !empty($full_day_leave1))
					{
						foreach($full_day_leave1 as $fd)
						{
							$diff_d = $this->dateTimeDiff(new DateTime($fd["leave_from"]),new DateTime($fd["leave_to"]));
							if($diff_d->h==0)
								$check = 0;
							if($fd["approved"]==2)
								$reject =1;
								
						}
					}
					if(empty($leaves_applied) && $check!=0)
					{
						
					if($lop==0 && $input["leave"]["approved"]!=2)
						$this->available_leaves_model->update_user_leaves_by_type($user_id,$type,$new_value);
					if($input["leave"]["approved"]==1)
						$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=> $input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
					else
						$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
						$id_leave = $this->leave_model->insert_user_leaves($leave_val);	
							$mail["leave_from"] = $from;
							$mail["leave_to"] = $to;
							$mail["type"] = "Half day leave";
							if($input["leave"]["session"]==1)
								$mail["session"] = "Session1";
							else 
								$mail["session"] = "Session2";
							$mail["leave_type"] = $input['leave']['type'];
							$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
							$this->email_notif->send_mail_notif("apply_leave",$mail);
							$this->session_messages->add_message('success','Leave applied successfully');
						
					}
					else
					{
						//$reject = 0;
							if(isset($leaves_applied)&& !empty($leaves_applied))
							{
								foreach($leaves_applied as $leave)
								{
									if($leave["approved"]==2)
										$reject = 1;
								
								}
							}
							if($reject==1)
								$this->session_messages->add_message('warning',"Already Leave applied & rejected for this day");
							else
								$this->session_messages->add_message('warning',"Already Leave applied for this day");
							$data["error"] = 1 ;
					}
				}
				elseif($input["leave"]["leave_type"]==2 ||  $input["leave"]["leave_type"]==4 || $input["leave"]["leave_type"]==6)// full day leave or comp off start
				{
					$month_from = explode("-",$input["leave"]["leave_from"]);
					$month_to = explode("-",$input["leave"]["leave_to"]);
					
					$from = date("Y-m-d",strtotime($input["leave"]["leave_from"]))." 00:00:00";
					$to = date("Y-m-d",strtotime($input["leave"]["leave_to"]))." 00:00:00";
					$leaves_applied = $this->leave_model->get_user_leaves_by_date($user_id,$from,$to,1);
					//print_r($from);
					//echo $this->db->last_query();
					//print_r($leaves_applied);
					//exit;
					if(empty($leaves_applied))
					{
					
					
					$date1 = new DateTime($from);
					$date2 = new DateTime($to);
					$interval = $this->dateTimeDiff($date1,$date2);
					$month_differ = 0;
					if($month_from[1] !=$month_to[1])
					{
						$days_in_from = cal_days_in_month(CAL_GREGORIAN, $month_from[1], $month_from[2]);
						$days_in_to = cal_days_in_month(CAL_GREGORIAN, $month_to[1], $month_to[2]);
						$month_differ = 1;
						$days_in_first = $days_in_from - $month_from[0];
						$days_in_second = $month_to[1];
						$interval->d = $days_in_first + $days_in_second;
						$first_from =new DateTime( date("Y-m-d",strtotime($input["leave"]["leave_from"]))." 00:00:00");
						$first_to = new DateTime(date("Y-m-d",strtotime($month_from[2]."-".$month_from[1]."-".$days_in_from))." 00:00:00");
						$second_from = new DateTime(date("Y-m-d",strtotime($month_to[2]."-".$month_to[1]."-1"))." 00:00:00");
						$second_to = new DateTime(date("Y-m-d",strtotime($month_to[2]."-".$month_to[1]."-".$month_to[0]))." 00:00:00");
						$interval_from = $this->dateTimeDiff($first_from,$first_to);
						$interval_to = $this->dateTimeDiff($second_from,$second_to);
					}
					
					//echo "<pre>";
					/*print_r($second_to);
					exit;*/
					if($input["leave"]["leave_type"]==2)
					{
						
						if(isset($leave_type[0]['available_casual_leave']))// available causal leave set
						{
							
							if($lop==0)// Not an lop
							{
								
									if($leave_type[0]['available_casual_leave']>0) // available casual leaves >0 
                                    {
										//echo $month_differ;
										
										if($leave_type[0]['available_casual_leave']<($interval->d+1)) // but less than applied count
										{
											
											$new_value =0;
											if($lop==0 && $input["leave"]["approved"]!=2)
											$this->available_leaves_model->update_user_leaves_by_type($user_id,$type,$new_value);
											if($month_differ==0)// same month
											{
											$next ="";
											
											$next = new DateTime($from.' + '.floor($leave_type[0]['available_casual_leave']-1) .' day');
											if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
											//echo "<pre>";
											else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
											$id_leave = $this->leave_model->insert_user_leaves($leave_val);
											
												$mail["leave_from"] = $from;
												$mail["leave_to"] = $next->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
											
											//print_r($leave_val);
											$from = new DateTime($next->format('Y-m-d H:i:s').' + '.floor($leave_type[0]['available_casual_leave']).' day');
											
											if($input["leave"]["approved"]==1)

												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$to,"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
											else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$to,"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
											//print_r($leave_val);
											
											$id_leave = $this->leave_model->insert_user_leaves($leave_val);
											
												$mail["leave_from"] = $from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $to;
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
											
											$this->session_messages->add_message('success','Leave applied successfully');
											}
											elseif($month_differ==1)// different month
											{
												
												$next ="";
												
											
												if($leave_type[0]['available_casual_leave']<($interval_from->d+1))// applied count >available leave
												{
													
													$next ="";
											
													$next = new DateTime($first_from->format('Y-m-d H:i:s').' + '.floor($leave_type[0]['available_casual_leave']-1) .' day');
													if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
													
													else
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
													
													$id_leave = $this->leave_model->insert_user_leaves($leave_val);
													//print_r($leave_val);
													
														$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
														$mail["leave_to"] = $next->format('Y-m-d H:i:s');
														$mail["type"] = "Leave";
														$mail["leave_type"] = $input['leave']['type'];
														$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
														$this->email_notif->send_mail_notif("apply_leave",$mail);
													
													$from = new DateTime($next->format('Y-m-d H:i:s').' + 1 day');
													if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
													else
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
													$leave_type[0]['available_casual_leave'] -= $interval_from->d+1;
													//print_r($leave_val);
													$id_leave = $this->leave_model->insert_user_leaves($leave_val);
													
														$mail["leave_from"] = $from->format('Y-m-d H:i:s');
														$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
														$mail["type"] = "Leave";
														$mail["leave_type"] = $input['leave']['type'];
														$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
														$this->email_notif->send_mail_notif("apply_leave",$mail);
													
													$this->session_messages->add_message('success','Leave applied successfully');
													
												}
												else // less than available
												{	
													if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
													else
														$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
													//print_r($leave_val);
													$id_leave = $this->leave_model->insert_user_leaves($leave_val);
													
													$mail["leave_from"] = $firest_from->format('Y-m-d H:i:s');
													$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
													$mail["type"] = "Leave";
													$mail["leave_type"] = $input['leave']['type'];
													$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
													$this->email_notif->send_mail_notif("apply_leave",$mail);
													
													$leave_type[0]['available_casual_leave'] -= $interval_from->d+1;
													$this->session_messages->add_message('success','Leave applied successfully');
													
												}
											if($leave_type[0]['available_casual_leave']>0) 
											{
												if($leave_type[0]['available_casual_leave']<($interval_to->d+1))
												{
													$next ="";
											
													$next = new DateTime($second_from->format('Y-m-d H:i:s').' + '.floor($leave_type[0]['available_casual_leave']-1) .' day');
													if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
													else
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
													$id_leave = $this->leave_model->insert_user_leaves($leave_val);
													
													$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
													$mail["leave_to"] = $next->format('Y-m-d H:i:s');
													$mail["type"] = "Leave";
													$mail["leave_type"] = $input['leave']['type'];
													$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
													$this->email_notif->send_mail_notif("apply_leave",$mail);
													
													$from = new DateTime($next->format('Y-m-d H:i:s').' + '.floor($leave_type[0]['available_casual_leave']).' day');
													if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
													else
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
													$id_leave = $this->leave_model->insert_user_leaves($leave_val);
													
													$mail["leave_from"] = $from->format('Y-m-d H:i:s');
													$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
													$mail["type"] = "Leave";
													$mail["leave_type"] = $input['leave']['type'];
													$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
													$this->email_notif->send_mail_notif("apply_leave",$mail);
													
													$this->session_messages->add_message('success','Leave applied successfully');
													//$leave_type[0]['available_casual_leave'] -= $interval_from->d+1;
													//print_r($leave_val);
												}
												else
												{	
													if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
													else
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
													//print_r($leave_val);
													$id_leave = $this->leave_model->insert_user_leaves($leave_val);
													
													$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
													$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
													$mail["type"] = "Leave";
													$mail["leave_type"] = $input['leave']['type'];
													$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
													$this->email_notif->send_mail_notif("apply_leave",$mail);
													
													//$leave_type[0]['available_casual_leave'] -= $interval_from->d+1;
													$this->session_messages->add_message('success','Leave applied successfully');
												}
											}
											else
											{
												
												
												if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
												else
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
													//print_r($leave_val);
												$id_leave = $this->leave_model->insert_user_leaves($leave_val);
												
													$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
													$mail["leave_to"] =$second_to->format('Y-m-d H:i:s');
													$mail["type"] = "Leave";
													$mail["leave_type"] = $input['leave']['type'];
													$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
													$this->email_notif->send_mail_notif("apply_leave",$mail);
													
													
												$this->session_messages->add_message('success','Leave applied successfully');
											
											}
												
											}
											
										}
										else
										{
											//echo $leave_type[0]['available_casual_leave'];
											//$this->pre_print->viewExit($lop);
											
											$new_value = $leave_type[0]['available_casual_leave']-($interval->d+1);
											if($lop==0 && $input["leave"]["approved"]!=2)
											$this->available_leaves_model->update_user_leaves_by_type($user_id,$type,$new_value);
											if($month_differ==0){
											
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"]);
												//print_r($leave_val);
											$id_leave = $this->leave_model->insert_user_leaves($leave_val);
											
											$mail["leave_from"] = $from;
											$mail["leave_to"] = $to;
											$mail["type"] = "Leave";
											$mail["leave_type"] = $input['leave']['type'];
											$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
											$this->email_notif->send_mail_notif("apply_leave",$mail);
											
											$this->session_messages->add_message('success','Leave applied successfully');
											}
											else if($month_differ==1)
											{
												if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
												else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
												//print_r($leave_val);
												$id_leave = $this->leave_model->insert_user_leaves($leave_val);
												
												$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
												if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
												else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
												//	print_r($leave_val);
													$id_leave = $this->leave_model->insert_user_leaves($leave_val);
													
													$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
													$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
													$mail["type"] = "Leave";
													$mail["leave_type"] = $input['leave']['type'];
													$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
													$this->email_notif->send_mail_notif("apply_leave",$mail);
												
												$this->session_messages->add_message('success','Leave applied successfully');
												
											
											}
										
										}
									}
									else
									{
										
										if($month_differ==0){
										if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
											else
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
											//	print_r($leave_val);
											$id_leave = $this->leave_model->insert_user_leaves($leave_val);
											
											$mail["leave_from"] = $from;
											$mail["leave_to"] = $to;
											$mail["type"] = "Leave";
											$mail["leave_type"] = $input['leave']['type'];
											$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
											$this->email_notif->send_mail_notif("apply_leave",$mail);
											
											$this->session_messages->add_message('success','Leave applied successfully');
											}
											else if($month_differ==1)
											{
												if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
												else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
												//print_r($leave_val);
												$id_leave = $this->leave_model->insert_user_leaves($leave_val);
												
												$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
												if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
												else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
													//print_r($leave_val);
												$id_leave = $this->leave_model->insert_user_leaves($leave_val);
												
												$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
												$this->session_messages->add_message('success','Leave applied successfully');
												//$leave_type[0]['available_casual_leave'] -= $interval_from->d+1;
											
											
											}
									
									}
									
								}
								else
								{
									
									
									if($month_differ==0){
										if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
										else
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
											$id_leave = $this->leave_model->insert_user_leaves($leave_val);
											
												$mail["leave_from"] = $from;
												$mail["leave_to"] = $to;
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
											$this->session_messages->add_message('success','Leave applied successfully');
											}
											else if($month_differ==1)
											{
												if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
												else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
												//print_r($leave_val);
												$id_leave = $this->leave_model->insert_user_leaves($leave_val);
												
												$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
												
												if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
												else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
												$id_leave = $this->leave_model->insert_user_leaves($leave_val);
												
												$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
												$this->session_messages->add_message('success','Leave applied successfully');
												//$leave_type[0]['available_casual_leave'] -= $interval_from->d+1;
											
											
											}
									
								}
								
							}
						}
						if(isset($leave_type[0]['available_sick_leave']))
						{
							if($lop==0)
							{
									
									//echo $leave_type[0]['available_sick_leave'];
									if($leave_type[0]['available_sick_leave']>0)
                                    {
										//echo $month_differ;
										if($leave_type[0]['available_sick_leave']<($interval->d+1))
										{
											$new_value = 0;
											if($lop==0 && $input["leave"]["approved"]!=2)
											$this->available_leaves_model->update_user_leaves_by_type($user_id,$type,$new_value);
											if($month_differ==0){
											$next ="";
											
											$next = new DateTime($from.' + '.floor($leave_type[0]['available_sick_leave']-1) .' day');
											if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
											else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
											//echo "<pre>";
											$id_leave = $this->leave_model->insert_user_leaves($leave_val);
											
												$mail["leave_from"] = $from;
												$mail["leave_to"] = $next->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
											//print_r($leave_val);
											$from = new DateTime($next->format('Y-m-d H:i:s').' + '.floor($leave_type[0]['available_sick_leave']).' day');
											if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$to,"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
											else
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$to,"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
											//print_r($leave_val);
											
											$id_leave = $this->leave_model->insert_user_leaves($leave_val);
											
												$mail["leave_from"] = $from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $to;
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												$this->session_messages->add_message('success','Leave applied successfully');
											}
											elseif($month_differ==1)
											{
												
												$next ="";
												
											
												if($leave_type[0]['available_sick_leave']<($interval_from->d+1))
												{
													
													$next ="";
											
													$next = new DateTime($first_from->format('Y-m-d H:i:s').' + '.floor($leave_type[0]['available_sick_leave']-1) .' day');
												if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
												else
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
													$id_leave = $this->leave_model->insert_user_leaves($leave_val);
													
												$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $next->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
													//print_r($leave_val);
													$from = new DateTime($next->format('Y-m-d H:i:s').' + 1 day');
												if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
												else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
													$leave_type[0]['available_sick_leave'] -= $interval_from->d+1;
													//print_r($leave_val);
													$id_leave = $this->leave_model->insert_user_leaves($leave_val);
													
												$mail["leave_from"] = $from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
											
													$this->session_messages->add_message('success','Leave applied successfully');
													
												}
												else
												{	
													if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
													else
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
													//print_r($leave_val);
													$id_leave = $this->leave_model->insert_user_leaves($leave_val);
													
												$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
													$leave_type[0]['available_sick_leave'] -= $interval_from->d+1;
													$this->session_messages->add_message('success','Leave applied successfully');
													
												}
											if($leave_type[0]['available_sick_leave']>0)
											{
												if($leave_type[0]['available_sick_leave']<($interval_to->d+1))
												{
													$next ="";
											
													$next = new DateTime($second_from->format('Y-m-d H:i:s').' + '.floor($leave_type[0]['available_sick_leave']-1) .' day');
												if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
													else
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
													$id_leave = $this->leave_model->insert_user_leaves($leave_val);
													//print_r($leave_val);
													
												$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $next->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
													$from = new DateTime($next->format('Y-m-d H:i:s').' + '.floor($leave_type[0]['available_sick_leave']).' day');
												if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
													else
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
													$id_leave = $this->leave_model->insert_user_leaves($leave_val);
													
												$mail["leave_from"] = $from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
													$this->session_messages->add_message('success','Leave applied successfully');
													
												}
												else
												{	
													if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
													else
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
													//print_r($leave_val);
													$id_leave = $this->leave_model->insert_user_leaves($leave_val);
													
												$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
													$this->session_messages->add_message('success','Leave applied successfully');
													
												}
											}
											else
											{
												
												if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
												else
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
												
													$id_leave = $this->leave_model->insert_user_leaves($leave_val);
													
												$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
													$this->session_messages->add_message('success','Leave applied successfully');
											
											}
												
											}
											
										}
										else
										{
											$new_value = $leave_type[0]['available_sick_leave']-($interval->d+1);
											if($lop==0 && $input["leave"]["approved"]!=2)
											$this->available_leaves_model->update_user_leaves_by_type($user_id,$type,$new_value);
											if($month_differ==0){
											if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
											else
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
											$id_leave = $this->leave_model->insert_user_leaves($leave_val);
											
												$mail["leave_from"] = $from;
												$mail["leave_to"] = $to;
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
											
											$this->session_messages->add_message('success','Leave applied successfully');
											}
											else if($month_differ==1)
											{
												if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
												else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
												$id_leave = $this->leave_model->insert_user_leaves($leave_val);
												
												$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
												if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
												else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
												//	print_r($leave_val);
												$id_leave = $this->leave_model->insert_user_leaves($leave_val);
												
												$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
											
												$this->session_messages->add_message('success','Leave applied successfully');
												
											
											}
										
										}
									}
									else
									{
										if($month_differ==0){
										if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
											else
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
											$id_leave = $this->leave_model->insert_user_leaves($leave_val);
											
												$mail["leave_from"] = $from;
												$mail["leave_to"] = $to;
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
											}
											else if($month_differ==1)
											{
												if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
												else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
												$id_leave = $this->leave_model->insert_user_leaves($leave_val);
												
												$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
												if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
												else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
												$id_leave =$this->leave_model->insert_user_leaves($leave_val);
												
												$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
												$leave_type[0]['available_sick_leave'] -= $interval_from->d+1;
												$this->session_messages->add_message('success','Leave applied successfully');
											
											
											}
									
									}
									
								}
								else
								{
									
									if($month_differ==0){
									if($input["leave"]["approved"]!=0)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
									else
										$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
											$id_leave = $this->leave_model->insert_user_leaves($leave_val);
											
												$mail["leave_from"] = $from;
												$mail["leave_to"] = $to;
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
											$this->session_messages->add_message('success','Leave applied successfully');
											}
											else if($month_differ==1)
											{
												if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
												else
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
												$id_leave = $this->leave_model->insert_user_leaves($leave_val);
												
												$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
												if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
												else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
												$id_leave = $this->leave_model->insert_user_leaves($leave_val);
												
												$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
												$leave_type[0]['available_casual_leave'] -= $interval_from->d+1;
												$this->session_messages->add_message('success','Leave applied successfully');
											
											
											}
									
								}
								
								
							}
							elseif ($input["leave"]["leave_type"]==4)
							{
							
								$input['leave']['type'] = 4;
								//echo "ene";
								$leave_type =$this->available_leaves_model->get_user_leaves_by_type($user_id,'compoff');
								if($interval->d+1>$leave_type[0]['comp_off'])
								{
									
									$this->session_messages->add_message('warning', "Your compoff days are less than the requested number of days");
									$data["error"] = 1 ;
								}
								else
								{
									$new_value = $leave_type[0]['comp_off']-($interval->d+1);
									if($lop==0 && $input["leave"]["approved"]!=2)
									$this->available_leaves_model->update_user_leaves_by_type($user_id,'compoff',$new_value);
									if($month_differ == 0)
									{
									if($input["leave"]["approved"]==1)
									$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
									else
									$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
									$id_leave = $this->leave_model->insert_user_leaves($leave_val);
									
												$mail["leave_from"] = $from;
												$mail["leave_to"] = $to;
												$mail["type"] = "Comp off";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
									$this->session_messages->add_message('success','Comp off leave applied successfully');
									}
									else if($month_differ==1)
									{
										if($input["leave"]["approved"]==1)
										$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
										else
										$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
										$id_leave = $this->leave_model->insert_user_leaves($leave_val);
										
												$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
												$mail["type"] = "Comp off";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
										if($input["leave"]["approved"]==1)
										$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
										else
										$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
											$id_leave = $this->leave_model->insert_user_leaves($leave_val);
											
												$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
												$mail["type"] = "Comp off";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
												$this->email_notif->send_mail_notif("apply_leave",$mail);
												
										
										$this->session_messages->add_message('success','Comp off leave applied successfully');
									
									}
								}
								
							}
							elseif ($input["leave"]["leave_type"]==6)
							{
							
								$input['leave']['type'] = 6;
								$lop=0;
								$leave_type =$this->available_leaves_model->get_user_leaves_by_type($user_id,'available_earned_leave');
								if($interval->d+1>$leave_type[0]['available_earned_leave'])
								{
									
									$this->session_messages->add_message('warning', "Your earned leaves are less than the requested number of days");
									$data["error"] = 1 ;
								}
								else
								{
									$new_value = $leave_type[0]['available_earned_leave']-($interval->d+1);
									if($lop==0 && $input["leave"]["approved"]!=2)
									$this->available_leaves_model->update_user_leaves_by_type($user_id,'available_earned_leave',$new_value);
									if($month_differ == 0)
									{
										if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
										else
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
										$id_leave = $this->leave_model->insert_user_leaves($leave_val);
									
										$mail["leave_from"] = $from;
										$mail["leave_to"] = $to;
										$mail["type"] = "Earned Leave";
										$mail["leave_type"] = $input['leave']['type'];
										$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
										$this->email_notif->send_mail_notif("apply_leave",$mail);
												
										$this->session_messages->add_message('success','Earned leave applied successfully');
									}
									else if($month_differ==1)
									{
										if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
										else
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
										$id_leave = $this->leave_model->insert_user_leaves($leave_val);
										
										$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
										$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
										$mail["type"] = "Earned Leave";
										$mail["leave_type"] = $input['leave']['type'];
										$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
										$this->email_notif->send_mail_notif("apply_leave",$mail);
												
										if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
										else
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
										$id_leave = $this->leave_model->insert_user_leaves($leave_val);
											
										$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
										$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
										$mail["type"] = "Earned Leave";
										$mail["leave_type"] = $input['leave']['type'];
										$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
										$this->email_notif->send_mail_notif("apply_leave",$mail);
												
										
										$this->session_messages->add_message('success','Earned leave applied successfully');
									
									}
								}
								
							}
						}
						else
						{
							$reject = 0;
							if(isset($leaves_applied)&& !empty($leaves_applied))
							{
								foreach($leaves_applied as $leave)
								{
									if($leave["approved"]==2)
										$reject = 1;
								
								}
							}
							if($reject==1)
								$this->session_messages->add_message('warning',"Already Leave applied & rejected for this day");
							else
							
								$this->session_messages->add_message('warning',"Already Leave applied for this day");
							
							$data["error"] = 1 ;
						}
				}
				else if($input["leave"]["leave_type"]==3 )
				{
					
					$from = date("Y-m-d H:i:s",strtotime($input["leave"]["leave_from"]));
					$to = date("Y-m-d H:i:s",strtotime($input["leave"]["leave_to"]));
					$leaves_applied = $this->leave_model->get_user_leaves_by_date($user_id,$from,$to);
					//echo $this->db->last_query();
					$full_day_leave1  = $this->leave_model->get_user_leaves_for_diff($user_id,$from);
					$check = 1;
					$reject = 0;
					if(isset($full_day_leave1)&& !empty($full_day_leave1))
						{
							foreach($full_day_leave1 as $fd)
							{
								$diff_d = $this->dateTimeDiff(new DateTime($fd["leave_from"]),new DateTime($fd["leave_to"]));
								if($diff_d->h==0)
									$check = 0;
								if($fd["approved"]==2)
									$reject =1;
							}
						}
					//print_r($leaves_applied);
					//echo $check;
					//exit;
					if(empty($leaves_applied) && $check!=0)
					{
                   			
					$date1 = new DateTime($from);
					$date2 = new DateTime($to);
					$input['leave']['type'] = 3;
					$interval = $this->dateTimeDiff($date1,$date2);
					$leave_type =$this->available_leaves_model->get_user_leaves_by_type($user_id,'permission');
					if($leave_type[0]['permission']<=0)
					{
						$lop = 1;
					}
					$new_value = $leave_type[0]['permission']-($interval->h);
					/*if($new_value<0)
					{
						$lop =1;
					
					}*/
					if($lop==0 && $input["leave"]["approved"]!=2)
						$this->available_leaves_model->update_user_leaves_by_type($user_id,'permission',$new_value);
					if($input["leave"]["approved"]==1)
					$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
					else
					$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
					$id_leave = $this->leave_model->insert_user_leaves($leave_val);
					
					$mail["leave_from"] = $from;
					$mail["leave_to"] = $to;
					$mail["type"] = "Permission";
					$mail["leave_type"] = $input['leave']['type'];
					$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
					//$mail["link"] = $
					$this->email_notif->send_mail_notif("apply_leave",$mail);
					
					$this->session_messages->add_message('success','Permission applied successfully');
					}
					else
					{
						
							if(isset($leaves_applied)&& !empty($leaves_applied))
							{
								foreach($leaves_applied as $leave)
								{
									if($leave["approved"]==2)
										$reject = 1;
								
								}
							}
							if($reject==1)
								$this->session_messages->add_message('warning',"Already Leave applied & rejected for this day");
							else
								$this->session_messages->add_message('warning',"Already Leave applied for this day");
							$data["error"] = 1 ;
					}
				}
				else if($input["leave"]["leave_type"]==5 )
				{
					
					$from = date("Y-m-d H:i:s",strtotime($input["leave"]["leave_from"]));
					$to = date("Y-m-d H:i:s",strtotime($input["leave"]["leave_to"]));
					$leaves_applied = $this->leave_model->get_user_leaves_by_date($user_id,$from,$to);
					//echo $this->db->last_query();
					$full_day_leave1  = $this->leave_model->get_user_leaves_for_diff($user_id,$from);
					$check = 1;
					$reject = 0;
					if(isset($full_day_leave1)&& !empty($full_day_leave1))
						{
							foreach($full_day_leave1 as $fd)
							{
								$diff_d = $this->dateTimeDiff(new DateTime($fd["leave_from"]),new DateTime($fd["leave_to"]));
								if($diff_d->h==0)
									$check = 0;
								if($fd["approved"]==2)
									$reject =1;
							}
						}
					//print_r($leaves_applied);
					//echo $check;
					//exit;
					if(empty($leaves_applied) && $check!=0)
					{
                   			
						$date1 = new DateTime($from);
						$date2 = new DateTime($to);
						$input['leave']['type'] = 5;
						$interval = $this->dateTimeDiff($date1,$date2);
						//$leave_type =$this->available_leaves_model->get_user_leaves_by_type($user_id,'permission');
						$lop=0;
	
					if($input["leave"]["approved"]==1)
					$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
					else
					$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
					$id_leave = $this->leave_model->insert_user_leaves($leave_val);
					
					$mail["leave_from"] = $from;
					$mail["leave_to"] = $to;
					$mail["type"] = "On-duty";
					$mail["leave_type"] = $input['leave']['type'];
					$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
					//$mail["link"] = $
					$this->email_notif->send_mail_notif("apply_leave",$mail);
					
					$this->session_messages->add_message('success','On-duty applied successfully');
					}
					else
					{
						
							if(isset($leaves_applied)&& !empty($leaves_applied))
							{
								foreach($leaves_applied as $leave)
								{
									if($leave["approved"]==2)
										$reject = 1;
								
								}
							}
							if($reject==1)
								$this->session_messages->add_message('warning',"Already Leave applied & rejected for this day");
							else
								$this->session_messages->add_message('warning',"Already Leave applied for this day");
							$data["error"] = 1 ;
					}
				}
				if(!isset($data["error"]))
					
						redirect($this->config->item('base_url')."attendance/leave/apply_or_modify_leaves");	
				
			}// isset function end
		
		}//post end
		$datam["messages"]= $this->session_messages->view_all_messages();
		$this->template->write_view('session_msg', 'masters/session_messages',$datam);
		$this->template->write_view('content', 'attendance/add_leave',$data);
		$this->template->render();
	}
	function view_user_leave($user_id,$leave_id)
	{
		$this->load->model('masters/available_leaves_model');
		$this->load->model('leave_model');
		$this->load->model('masters/user_roles_model');
		$this->load->model('masters/options_model');
		$this->load->model('masters/user_department_model');
		$this->load->model('masters/users_model');
		$data["enable_earned_leave"]= $this->options_model->get_option_by_name("enable_earned_leave");
		$data["roles"] = $this->user_roles_model->get_user_role($this->user_auth->get_user_id());
		$data["available"] = $this->available_leaves_model->get_user_leaves_by_user_id($user_id);
		$data["leave"] = $this->leave_model->get_user_leaves_by_leave_id($leave_id);
		$data["dept"] = $this->user_department_model->get_department_by_user_id($user_id);
		$data["name"] = $this->users_model->get_user_name_by_user_id($user_id);
		if(isset($data["leave"]) && !empty($data["leave"]))
		{
			$date3 = new DateTime($data["leave"][0]["date_from"]);
			$date4 = new DateTime($data["leave"][0]["date_to"]);
			$interval2=$this->dateTimeDiff($date3,$date4);
		
			//$this->pre_print->viewExit($data);
			$type = $data["leave"][0]["type"];
			//print_r($interval2);
			if($type=='casual leave' ||$type=="sick leave")
			{
				if($date3==$date4)
				{
					$data["type"] = 2;
				
				}
				else
				{
					if($interval2->d==0 && $interval2->h>0)
						$data["type"] = 1;
					else if($interval2->h==0)
						$data["type"] = 2;
				}
				
				
			}
			else
			{
				if($type =="compoff")
					$data["type"] = 4;
				else if($type=="permission")
					$data["type"] = 3;
				else if($type=="on-duty")
					$data["type"] = 5;
				else if($type=="earned leave")
					$data["type"] = 6;
			}
			//echo $data["type"];
			if($data["type"]==1)
			{
				$session_time = date('h:i:s',strtotime($data["leave"][0]["leave_from"]));
				$compare_time = date('12:00:00');
				//echo $session_time;
				if($session_time < $compare_time)
					$data["session"] = 1;
				else
					$data["session"]=2;
				//else
					
			}
			$data["user_id"]  = $user_id;
			//print_r($data);
			$this->template->write_view('content', 'attendance/view_user_leave',$data);
			$this->template->render();
		}
		else
		{	
			echo "Page Not Found";
		}
	}								
	function edit_user_leaves($user_id,$leave_id)
	{
		$this->load->model('masters/available_leaves_model');
		$this->load->model('masters/user_department_model');
		$this->load->model('masters/users_model');
		$this->load->model('masters/shift_model');
		$this->load->model('masters/user_shift_model');
		$this->load->model('masters/options_model');
		
		$this->load->model('leave_model');
		$data["available"] = $this->available_leaves_model->get_user_leaves_by_user_id($user_id);
		$data["enable_earned_leave"]= $this->options_model->get_option_by_name("enable_earned_leave");
		$data["leave"] = $this->leave_model->get_user_leaves_by_leave_id($leave_id);
		$data["dept"] = $this->user_department_model->get_department_by_user_id($user_id);
		$data["name"] = $this->users_model->get_user_name_by_user_id($user_id);
		$admin_id = $this->user_auth->get_user_id();
		
			$mail = array();
			$department_head= $this->user_department_model->get_user_dept_head_by_userid($user_id);
			if(isset($department_head) && !empty($department_head))
			{
				$mail["department_head"] = $department_head[0]["email"];
				$mail["head_name"] = $department_head[0]["head_name"];
			}
			$user_mail = $this->users_model->get_user_mail_id_by_user_id($user_id);
			$admin_mail = $this->users_model->get_user_mail_id_by_user_id($admin_id);
			$mail["user"] = $user_mail[0]["email"];
			$mail["user_name"] = $user_mail[0]["name"];
			$mail["admin"] = $admin_mail[0]["email"];
			$mail["admin_name"] = $admin_mail[0]["name"];
			$mail["user_id"] = $user_id;
        
		if(isset($data["leave"] ) && !empty($data["leave"] ))
		{
		$date3 = new DateTime($data["leave"][0]["date_from"]);
		$date4 = new DateTime($data["leave"][0]["date_to"]);
		$interval2=$this->dateTimeDiff($date3,$date4);
		
		//$this->pre_print->viewExit($data);
		$type = $data["leave"][0]["type"];
		$applied_by_user_id = $data["leave"][0]["user_id"];
		//print_r($interval2);
		if($type=='casual leave' ||$type=="sick leave")
		{
			if($date3==$date4)
			{
				$data["type"] = 2;
			
			}
			else
			{
				if($interval2->d==0 && $interval2->h>0)
					$data["type"] = 1;
				else if($interval2->h==0)
					$data["type"] = 2;
			}
			
			
		}
		else
		{
			if($type =="compoff")
				$data["type"] = 4;
			else if($type=="permission")
				$data["type"] = 3;
			else if($type=="on-duty")
				$data["type"] = 5;
			else if($type=="earned leave")
				$data["type"] = 6;
		}
		//echo $data["type"];
		//echo $date3;		
		if(isset($data["leave"][0]["leave_from"]))
		{	
			$from_one = $data["leave"][0]["leave_from"];
			$shift_id = $this->user_shift_model->get_user_current_shift_by_user_id($user_id,$from_one);
		}	
		$date_start = $date_end = $break_start = $break_end = '';
		if(isset($shift_id) && !empty($shift_id))
		{
			$shift_time =$this->shift_model->get_regular_and_lunch_by_shift_id($shift_id[0]['shift_id']);
			if(isset($shift_time) && !empty($shift_time))
			{
				
				foreach($shift_time as $s_time)
				{
					if($s_time["type"] == 'regular')
					{
						$date_start = $s_time["from_time"];
						$date_end = $s_time["to_time"];
					}
					if($s_time["type"] =="lunch")
					{
						$break_start = $s_time["from_time"];
						$break_end = $s_time["to_time"];					
					}
				}
			
			}
			
		}
		
		if($data["type"]==1)
		{
			$session_time = date('H:i:s',strtotime($data["leave"][0]["leave_from"]));
			$compare_time = date('12:00:00');
		
			/*if($session_time < $compare_time)
				$data["session"] = 1;
			else
				$data["session"]=2;*/				
			if($break_start<$session_time)
				$data["session"] = 2;
			else
				$data["session"] = 1; 			
		}
	
		if($this->input->post("save"))
		{
			$input = $this->input->post();
			$data["input"] = $input;
		    
			if(isset($input["leave"]) && !empty($input["leave"]) )
			{
			
				if($input["leave"]["leave_type"]=="")
				{
					foreach($input["leave"] as $key=>$val)
					{
							if($key!="session" && $key!="date"){
							if($key=="leave_type")
								$field_name = "Duration Type";
								else if($key=="approved")
         						$field_name = "Status";
							else
								$field_name = ucfirst(str_replace('_',' ',$key));
							$rules = "required";
							
							$leave[] = array(
							'field'   => "leave[".$key."]" , 
							'label'   => $field_name, 
							'rules'   => $rules
							);
						}
					}
				}
				else if($input["leave"]["leave_type"]==1)
				{
					foreach($input["leave"] as $key=>$val)
					{
							if($key!="leave_to" && $key!= "leave_from"){
							
							$field_name = ucfirst(str_replace('_',' ',$key));
							if($key=="approved")
        					$field_name = "Status";
							$rules = "required";
							
							$leave[] = array(
							'field'   => "leave[".$key."]" , 
							'label'   => $field_name, 
							'rules'   => $rules
							);
						}
					}
					if(!isset($leave["type"]))
					{
						
						$leave[] = array(
								'field'   => "leave[type]" , 
								'label'   => "Leave Type", 
								'rules'   => "required"
								);
					}
				}
				else if($input["leave"]["leave_type"]==2 || $input["leave"]["leave_type"]==3 || $input["leave"]["leave_type"]==4 || $input["leave"]["leave_type"]==6)
				{
					foreach($input["leave"] as $key=>$val)
					{
							if($key!="session" && $key!="date"){
							$field_name = ucfirst(str_replace('_',' ',$key));
							if($key=="approved")
        					$field_name = "Status";
							$rules = "required";
							
							$leave[] = array(
							'field'   => "leave[".$key."]" , 
							'label'   => $field_name, 
							'rules'   => $rules
							);
						}
					}
					if($input["leave"]["leave_type"]==2)
					{
						if(!isset($leave["type"]))
						{
							
							$leave[] = array(
									'field'   => "leave[type]" , 
									'label'   => "Leave Type", 
									'rules'   => "required"
									);
						}
					}
				}
				else if($input["leave"]["leave_type"]==5)
					{
				
						if(isset($input["leave"]["session"]))
							unset($input["leave"]["session"]);
						if(isset($input["leave"]["date"]))
							unset($input["leave"]["date"]);
						
						foreach($input["leave"] as $key=>$val)
						{
							$field_name = "";
							if($key=="leave_from")
								$field_name = "From";
							
							else if($key=="leave_to")
								$field_name = "To";
							
							else if($key=="approved")
								 $field_name = "Status";
							else
								 $field_name = ucfirst(str_replace('_',' ',$key));
							$rules = "required";
									
							$leave[] = array(
							'field'   => "leave[".$key."]" , 
							'label'   => $field_name, 
							'rules'   => $rules
							);  
								
						}
						
				
					}
					
			}
			
			$this->form_validation->set_rules($leave);
			if ($this->form_validation->run() != FALSE)
			{
				
					$date3 = new DateTime(date('d-m-Y H:i:s',strtotime($data["leave"][0]['leave_from'])));
					$date4 = new DateTime(date('d-m-Y H:i:s',strtotime($data["leave"][0]['leave_to'])));
					$interval3 = $this->dateTimeDiff($date3,$date4);
					$add_value =0;
					
					if($data["type"]==1 || $data["type"]==2)
					{
						
						if(isset($data["type"]))
						{
							$old_leave =$this->available_leaves_model->get_user_leaves_by_type($user_id,$data["leave"][0]["type"]);
						}
						if($data["type"]==1)
						{
							$add_value =0.5;
							
						}
						elseif($data["type"] ==2)
						{
							$add_value =$interval3->d+1;
						
						}
					}
					
					else if($data["type"]==3)
					{
						$add_value =$interval3->h;
						$old_leave =$this->available_leaves_model->get_user_leaves_by_type($user_id,'permission');
					}
					else if($data["type"]==4)
					{
						$add_value =$interval3->d+1;
						$old_leave =$this->available_leaves_model->get_user_leaves_by_type($user_id,'comp_off');
					}
					else if($data["type"]==6)
					{
						$add_value =$interval3->d+1;
						$old_leave =$this->available_leaves_model->get_user_leaves_by_type($user_id,'available_earned_leave');
					}
					
					if($data["leave"][0]["lop"]==0 && $data["leave"][0]["approved"]!=2 && $data["type"]!=5)
					{
						if(isset($old_leave[0]['available_casual_leave']))
							$new_value1 = $old_leave[0]['available_casual_leave']+$add_value;
						
						else if(isset($old_leave[0]['available_sick_leave']))
							$new_value1 = $old_leave[0]['available_sick_leave']+$add_value;
								
						else if(isset($old_leave[0]['permission']))
							$new_value1 = $old_leave[0]['permission']+$add_value;
						else if(isset($old_leave[0]['comp_off']))
							$new_value1 = $old_leave[0]['comp_off']+$add_value;
						else if(isset($old_leave[0]['available_earned_leave']))
							$new_value1 = $old_leave[0]['available_earned_leave']+$add_value;
					
					$this->available_leaves_model->update_user_leaves_by_type($user_id,$data["leave"][0]["type"],$new_value1);
					
					}
				$this->leave_model->delete_user_leaves_by_id($leave_id);
				$lop = 0;
				//$approved = 0;
				$from = '';
				$to='';
				$type ="";
				$new_value = 0;
				
				if(isset($input['leave']['type']))
				{
					if($input['leave']['type']==1)
						$type ='sick leave';
					else if($input['leave']['type']==2)
						$type ='casual leave';
					$leave_type =$this->available_leaves_model->get_user_leaves_by_type($user_id,$type);
				}
				
				if(isset($input["leave"]["lop"]))
					$lop = 1;
				//if(isset($input["leave"]["approved"]))
					//$approved = $input["leave"]["approved"];
				/*else
					$lop = 1;*/
				if(isset($input["leave"]["date"]))
				{
					$from_one = $input["leave"]["date"];
							
				
					$shift_id = $this->user_shift_model->get_user_current_shift_by_user_id($user_id,$from_one);
				}
				$date_start=$date_end =$break_start=$break_end='';
					if(isset($shift_id) && !empty($shift_id))
					{
						$shift_time =$this->shift_model->get_regular_and_lunch_by_shift_id($shift_id[0]['shift_id']);
						if(isset($shift_time) && !empty($shift_time))
						{
							
							foreach($shift_time as $s_time)
							{
								if($s_time["type"] == 'regular')
								{
									$date_start = $s_time["from_time"];
									$date_end = $s_time["to_time"];
								}
								if($s_time["type"] =="lunch")
								{
									$break_start = $s_time["from_time"];
									$break_end = $s_time["to_time"];
								
								}
							}
						
						}
						
					}
				
				if($input["leave"]["leave_type"]==1)
				{
					
					
					if($input["leave"]["session"]==1)
					{
						$from = date("Y-m-d",strtotime($input["leave"]["date"]))." ".$date_start;
						
						$to = date("Y-m-d",strtotime($input["leave"]["date"]))." ".$break_start;
					}
					elseif( $input["leave"]["session"]==2)
					{
						$from = date("Y-m-d",strtotime($input["leave"]["date"]))." ".$break_end;
						
						$to = date("Y-m-d",strtotime($input["leave"]["date"]))." ".$date_end;
					}
					
					if(isset($leave_type[0]['available_casual_leave']))
					{
						
						if($leave_type[0]['available_casual_leave']<=0)
							$lop=1;
						$new_value = $leave_type[0]['available_casual_leave']-0.5;
					}
					else if(isset($leave_type[0]['available_sick_leave']))
					{
						if($leave_type[0]['available_sick_leave']<=0)
							$lop=1;
						
						$new_value = $leave_type[0]['available_sick_leave']-0.5;
					}
					
					/*if($new_value<0)
						$lop =1;*/
					$leaves_applied= $this->leave_model->get_user_leaves_by_date($user_id,$from,$to,null,$leave_id);
					$full_day_leave1  = $this->leave_model->get_user_leaves_for_diff($user_id,$from,$leave_id);
					$check = 1;
					
					if(isset($full_day_leave1)&& !empty($full_day_leave1))
					{
						foreach($full_day_leave1 as $fd)
						{
							$diff_d = $this->dateTimeDiff(new DateTime($fd["leave_from"]),new DateTime($fd["leave_to"]));
							if($diff_d->h==0)
								$check = 0;
						}
					}
					
					if(empty($leaves_applied) && $check!=0)
					{
					
					//exit;
					if($lop==0 && $input["leave"]["approved"]!=2)
							
						$this->available_leaves_model->update_user_leaves_by_type($user_id,$type,$new_value);
					
						/*if($input["leave"]["approved"]==1)*/
					$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
					/*else
					$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);*/
						$new_id =$this->leave_model->insert_user_leaves($leave_val);
						
							$mail["leave_from"] = $from;
							$mail["leave_to"] = $to;
							$mail["type"] = "Half day leave";
							$mail["leave_type"] = $input['leave']['type'];
							$mail["approved"] = $input['leave']['approved'];
							if($input["leave"]["session"]==1)
								$mail["session"] = "Session1";
							else
								$mail["session"] = "Session2";
							$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
							$this->email_notif->send_mail_notif("edit_leave",$mail);
						
						$this->session_messages->add_message('success','Leave updated successfully');
					}
					else
					{
						$this->session_messages->add_message('warning',"Already Leave applied for this day");
							$data["error"] = 1 ;
					}
					
				}
				elseif($input["leave"]["leave_type"]==2 ||  $input["leave"]["leave_type"]==4 || $input["leave"]["leave_type"]==6)// full day leave or comp off start
				{
						//$this->pre_print->viewExit($input);
					$month_from = explode("-",$input["leave"]["leave_from"]);
					$month_to = explode("-",$input["leave"]["leave_to"]);
					
					$from = date("Y-m-d",strtotime($input["leave"]["leave_from"]))." 00:00:00";
					$to = date("Y-m-d",strtotime($input["leave"]["leave_to"]))." 00:00:00";
					$leaves_applied = $this->leave_model->get_user_leaves_by_date($user_id,$from,$to,1,$leave_id);
					/*print_r($from);
					echo $lop;
					print_r($to);
					exit;*/
					
					if(empty($leaves_applied))
					{
					
					
					$date1 = new DateTime($from);
					$date2 = new DateTime($to);
					$interval = $this->dateTimeDiff($date1,$date2);
					$month_differ = 0;
					if($month_from[1] !=$month_to[1])
					{
						$days_in_from = cal_days_in_month(CAL_GREGORIAN, $month_from[1], $month_from[2]);
						$days_in_to = cal_days_in_month(CAL_GREGORIAN, $month_to[1], $month_to[2]);
						$month_differ = 1;
						$days_in_first = $days_in_from - $month_from[0];
						$days_in_second = $month_to[1];
						$interval->d = $days_in_first + $days_in_second;
						$first_from =new DateTime( date("Y-m-d",strtotime($input["leave"]["leave_from"]))." 00:00:00");
						$first_to = new DateTime(date("Y-m-d",strtotime($month_from[2]."-".$month_from[1]."-".$days_in_from))." 00:00:00");
						$second_from = new DateTime(date("Y-m-d",strtotime($month_to[2]."-".$month_to[1]."-1"))." 00:00:00");
						$second_to = new DateTime(date("Y-m-d",strtotime($month_to[2]."-".$month_to[1]."-".$month_to[0]))." 00:00:00");
						$interval_from = $this->dateTimeDiff($first_from,$first_to);
						$interval_to = $this->dateTimeDiff($second_from,$second_to);
					}
					
					//echo "<pre>";
					/*print_r($second_to);
					exit;*/
					if($input["leave"]["leave_type"]==2)
					{
						
						if(isset($leave_type[0]['available_casual_leave']))
						{
							
							if($lop==0)
							{
								
									if($leave_type[0]['available_casual_leave']>0)
                                    {
										//echo $month_differ;
										if($leave_type[0]['available_casual_leave']<($interval->d+1))
										{
											$new_value =0;
											if($input["leave"]["approved"]!=2)
											$this->available_leaves_model->update_user_leaves_by_type($user_id,$type,$new_value);
											if($month_differ==0){
											$next ="";
											
											$next = new DateTime($from.' + '.floor($leave_type[0]['available_casual_leave']-1) .' day');
											//if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
										/*	else
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);*/
											//echo "<pre>";
											
											$new_id =$this->leave_model->insert_user_leaves($leave_val);
											//print_r($leave_val);
											
												$mail["leave_from"] = $from;
												$mail["leave_to"] = $next->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["approved"] = $input['leave']['approved'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												
												$this->email_notif->send_mail_notif("edit_leave",$mail);
											
                                            
											$from = new DateTime($next->format('Y-m-d H:i:s').' + '.floor($leave_type[0]['available_casual_leave']).' day');
									//	if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$to,"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
											/*else
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$to,"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
											//print_r($leave_val);*/
											
											$new_id =$this->leave_model->insert_user_leaves($leave_val);
											
												$mail["leave_from"] = $from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $to;
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["approved"] = $input['leave']['approved'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$this->email_notif->send_mail_notif("edit_leave",$mail);
											
                                            
											$this->session_messages->add_message('success','Leave updated successfully');
											}
											elseif($month_differ==1)
											{
												
												$next ="";
												
											
												if($leave_type[0]['available_casual_leave']<($interval_from->d+1))
												{
													
													$next ="";
											
													$next = new DateTime($first_from->format('Y-m-d H:i:s').' + '.floor($leave_type[0]['available_casual_leave']-1) .' day');
												//if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
												/*else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);*/
													$new_id =$this->leave_model->insert_user_leaves($leave_val);
													
														$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
														$mail["leave_to"] = $next->format('Y-m-d H:i:s');
														$mail["type"] = "Leave";
														$mail["leave_type"] = $input['leave']['type'];
														$mail["approved"] = $input['leave']['approved'];
														$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
														$this->email_notif->send_mail_notif("edit_leave",$mail);
													
													//print_r($leave_val);
													$from = new DateTime($next->format('Y-m-d H:i:s').' + 1 day');
												//if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
													
												/*else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);*/
												
													$leave_type[0]['available_casual_leave'] -= $interval_from->d+1;
													//print_r($leave_val);
													$new_id =$this->leave_model->insert_user_leaves($leave_val);
													
														$mail["leave_from"] = $from->format('Y-m-d H:i:s');
														$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
														$mail["type"] = "Leave";
														$mail["leave_type"] = $input['leave']['type'];
														$mail["approved"] = $input['leave']['approved'];
														$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
														$this->email_notif->send_mail_notif("edit_leave",$mail);
													
													$this->session_messages->add_message('success','Leave updated successfully');
													
												}
												else
												{	
													//if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
													/*else
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);*/
													//print_r($leave_val);
													$new_id =$this->leave_model->insert_user_leaves($leave_val);
													
													$mail["leave_from"] = $firest_from->format('Y-m-d H:i:s');
													$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
													$mail["type"] = "Leave";
													$mail["leave_type"] = $input['leave']['type'];
													$mail["approved"] = $input['leave']['approved'];
													$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
													$this->email_notif->send_mail_notif("edit_leave",$mail);
													
													$leave_type[0]['available_casual_leave'] -= $interval_from->d+1;
													$this->session_messages->add_message('success','Leave updated successfully');
													
												}
											if($leave_type[0]['available_casual_leave']>0)
											{
												if($leave_type[0]['available_casual_leave']<($interval_to->d+1))
												{
													$next ="";
											
													$next = new DateTime($second_from->format('Y-m-d H:i:s').' + '.floor($leave_type[0]['available_casual_leave']-1) .' day');
												//if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
												/*else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);	*/
													$new_id =$this->leave_model->insert_user_leaves($leave_val);
													
													$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
													$mail["leave_to"] = $next->format('Y-m-d H:i:s');
													$mail["type"] = "Leave";
													$mail["leave_type"] = $input['leave']['type'];
													$mail["approved"] = $input['leave']['approved'];
													$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
													$this->email_notif->send_mail_notif("edit_leave",$mail);
													
													$from = new DateTime($next->format('Y-m-d H:i:s').' + '.floor($leave_type[0]['available_casual_leave']).' day');
												//if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
												/*else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);*/
													$new_id =$this->leave_model->insert_user_leaves($leave_val);
													
													$mail["leave_from"] = $from->format('Y-m-d H:i:s');
													$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
													$mail["type"] = "Leave";
													$mail["leave_type"] = $input['leave']['type'];
													$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
													$mail["approved"] = $input['leave']['approved'];
													$this->email_notif->send_mail_notif("edit_leave",$mail);
													
													
													$this->session_messages->add_message('success','Leave updated successfully');
													//$leave_type[0]['available_casual_leave'] -= $interval_from->d+1;
													//print_r($leave_val);
												}
												else
												{	
													//if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
													/*else
														$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);*/
													//print_r($leave_val);
													$new_id =$this->leave_model->insert_user_leaves($leave_val);
													
													$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
													$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
													$mail["type"] = "Leave";
													$mail["leave_type"] = $input['leave']['type'];
													$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
													$mail["approved"] = $input['leave']['approved'];
													$this->email_notif->send_mail_notif("edit_leave",$mail);
													
													$this->session_messages->add_message('success','Leave updated successfully');
													//$leave_type[0]['available_casual_leave'] -= $interval_from->d+1;
												}
											}
											else
											{
												
												//print_r($second_to);
											//	if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
												/*else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);*/
													//print_r($leave_val);
												$new_id =$this->leave_model->insert_user_leaves($leave_val);
												
													$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
													$mail["leave_to"] =$second_to->format('Y-m-d H:i:s');
													$mail["type"] = "Leave";
													$mail["leave_type"] = $input['leave']['type'];
													$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
													$mail["approved"] = $input['leave']['approved'];
													$this->email_notif->send_mail_notif("edit_leave",$mail);
													
													
												$this->session_messages->add_message('success','Leave updated successfully');
											
											}
												
											}
											
										}
										else
										{
											
											$new_value = $leave_type[0]['available_casual_leave']-($interval->d+1);
											if($lop==0 && $input["leave"]["approved"]!=2)
											$this->available_leaves_model->update_user_leaves_by_type($user_id,$type,$new_value);
											if($month_differ==0){
											//if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
											/*else
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
												//print_r($leave_val);*/
											$new_id =$this->leave_model->insert_user_leaves($leave_val);
											
											$mail["leave_from"] = $from;
											$mail["leave_to"] = $to;
											$mail["type"] = "Leave";
											$mail["leave_type"] = $input['leave']['type'];
											$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
											$mail["approved"] = $input['leave']['approved'];
											$this->email_notif->send_mail_notif("edit_leave",$mail);
											
											$this->session_messages->add_message('success','Leave updated successfully');
											}
											else if($month_differ==1)
											{
												//if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
												/*else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);*/
												//print_r($leave_val);
												$new_id =$this->leave_model->insert_user_leaves($leave_val);
												
												$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												  $mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
												//if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
												/*else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);*/
												//	print_r($leave_val);
												$new_id =$this->leave_model->insert_user_leaves($leave_val);
												
													$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
													$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
													$mail["type"] = "Leave";
													$mail["leave_type"] = $input['leave']['type'];
													$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
													$mail["approved"] = $input['leave']['approved'];
													$this->email_notif->send_mail_notif("edit_leave",$mail);
												
												$this->session_messages->add_message('success','Leave updated successfully');
												
											
											}
										
										}
									}
									else
									{
										//echo "enter2";exit;
										if($month_differ==0){
											//if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
											/*else
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);*/
											//	print_r($leave_val);
											$new_id =$this->leave_model->insert_user_leaves($leave_val);
											
											$mail["leave_from"] = $from;
											$mail["leave_to"] = $to;
											$mail["type"] = "Leave";
											$mail["leave_type"] = $input['leave']['type'];
											$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
											$mail["approved"] = $input['leave']['approved'];
											$this->email_notif->send_mail_notif("edit_leave",$mail);
											
											$this->session_messages->add_message('success','Leave updated successfully');
											}
											else if($month_differ==1)
											{
												//if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
												/*else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);*/
												
												//print_r($leave_val);
												$new_id =$this->leave_model->insert_user_leaves($leave_val);
												
												$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
												//if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
												/*else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);*/
													//print_r($leave_val);
												$new_id =$this->leave_model->insert_user_leaves($leave_val);
												
												$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
												$this->session_messages->add_message('success','Leave updated successfully');
												//$leave_type[0]['available_casual_leave'] -= $interval_from->d+1;
											
											
											}
									
									}
									
								}
								else
								{
									//echo "enter1";exit;
									if($month_differ==0){
											//if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
											/*else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);*/
												//print_r($leave_val);
											$new_id =$this->leave_model->insert_user_leaves($leave_val);
											
												$mail["leave_from"] = $from;
												$mail["leave_to"] = $to;
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
											$this->session_messages->add_message('success','Leave updated successfully');
											}
											else if($month_differ==1)
											{
												//if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
												/*else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);*/
												//print_r($leave_val);
												$new_id =$this->leave_model->insert_user_leaves($leave_val);
												
												$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
												//if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
												/*else
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);*/
												
												$new_id =$this->leave_model->insert_user_leaves($leave_val);
												
												$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
                                                
                                                
												$this->session_messages->add_message('success','Leave updated successfully');
												//$leave_type[0]['available_casual_leave'] -= $interval_from->d+1;
											
											
											}
									
								}
								
							}
						}
						if(isset($leave_type[0]['available_sick_leave']))
						{
							
							if($lop==0)
							{
									//echo $leave_type[0]['available_sick_leave'];
									if($leave_type[0]['available_sick_leave']>0)
                                    {
										//echo $month_differ;
										if($leave_type[0]['available_sick_leave']<($interval->d+1))
										{
											$new_value = 0;
											if($lop==0 && $input["leave"]["approved"]!=2)
											$this->available_leaves_model->update_user_leaves_by_type($user_id,$type,$new_value);
											if($month_differ==0){
											$next ="";
											
											$next = new DateTime($from.' + '.floor($leave_type[0]['available_sick_leave']-1) .' day');
											//if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
											//else
											//$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
											//echo "<pre>";
											$new_id =$this->leave_model->insert_user_leaves($leave_val);
											
												$mail["leave_from"] = $from;
												$mail["leave_to"] = $next->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
											
											//print_r($leave_val);
											$from = new DateTime($next->format('Y-m-d H:i:s').' + '.floor($leave_type[0]['available_sick_leave']).' day');
										//if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$to,"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
											//else
											//$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$to,"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
											//print_r($leave_val);
											
											$new_id =$this->leave_model->insert_user_leaves($leave_val);
											
												$mail["leave_from"] = $from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $to;
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
											$this->session_messages->add_message('success','Leave updated successfully');
											}
											elseif($month_differ==1)
											{
												
												$next ="";
												
											
												if($leave_type[0]['available_sick_leave']<($interval_from->d+1))
												{
													
													$next ="";
											
													$next = new DateTime($first_from->format('Y-m-d H:i:s').' + '.floor($leave_type[0]['available_sick_leave']-1) .' day');
												//if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
											//	else
												//$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
													
													$new_id =$this->leave_model->insert_user_leaves($leave_val);
													
												$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $next->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
													//print_r($leave_val);
													$from = new DateTime($next->format('Y-m-d H:i:s').' + 1 day');
												//if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
												//	else
												//	$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
													$leave_type[0]['available_sick_leave'] -= $interval_from->d+1;
													//print_r($leave_val);
													$new_id =$this->leave_model->insert_user_leaves($leave_val);
														
												$mail["leave_from"] = $from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
													$this->session_messages->add_message('success','Leave updated successfully');
													
												}
												else
												{	
													//if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
													//else
													//$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
													//print_r($leave_val);
													$new_id =$this->leave_model->insert_user_leaves($leave_val);
													
												$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
													$leave_type[0]['available_sick_leave'] -= $interval_from->d+1;
													$this->session_messages->add_message('success','Leave updated successfully');
													
												}
											if($leave_type[0]['available_sick_leave']>0)
											{
												if($leave_type[0]['available_sick_leave']<($interval_to->d+1))
												{
													$next ="";
											
													$next = new DateTime($second_from->format('Y-m-d H:i:s').' + '.floor($leave_type[0]['available_sick_leave']-1) .' day');
											//	if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
													//else
												//	$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$next->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
													
													$new_id =$this->leave_model->insert_user_leaves($leave_val);
												
												$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $next->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
													//print_r($leave_val);
													$from = new DateTime($next->format('Y-m-d H:i:s').' + '.floor($leave_type[0]['available_sick_leave']).' day');
												///if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
													//else
													//$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
													$new_id =$this->leave_model->insert_user_leaves($leave_val);
													
												$mail["leave_from"] = $from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
													$this->session_messages->add_message('success','Leave updated successfully');
													
												}
												else
												{	
												//	if($input["leave"]["approved"]==1)
													$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
													//else
													//$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
													//print_r($leave_val);
													$new_id =$this->leave_model->insert_user_leaves($leave_val);
													
												$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
													$this->session_messages->add_message('success','Leave updated successfully');
												}
											}
											else
											{
												//if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
												//else
												//$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
												
													$new_id =$this->leave_model->insert_user_leaves($leave_val);
													
												$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
                                                
													$this->session_messages->add_message('success','Leave updated successfully');
											}
												
											}
											
										}
										else
										{
											$new_value = $leave_type[0]['available_sick_leave']-($interval->d+1);
											if($lop==0 && $input["leave"]["approved"]!=2)
											$this->available_leaves_model->update_user_leaves_by_type($user_id,$type,$new_value);
											if($month_differ==0){
											//if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
											//else
											//$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
											$new_id =$this->leave_model->insert_user_leaves($leave_val);
											
												$mail["leave_from"] = $from;
												$mail["leave_to"] = $to;
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
											
                                                
											$this->session_messages->add_message('success','Leave updated successfully');
											}
											else if($month_differ==1)
											{
												//if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
												//else
												//$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
												
												$new_id =$this->leave_model->insert_user_leaves($leave_val);
												
												
												$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
												//if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
												//else
												//$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
													//print_r($leave_val);
												$new_id =$this->leave_model->insert_user_leaves($leave_val);
												
												$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
                                                
												$this->session_messages->add_message('success','Leave updated successfully');
											
											}
										
										}
									}
									else
									{
										
										if($month_differ==0){
											//if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
										//	else
											//$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
											
											$new_id =$this->leave_model->insert_user_leaves($leave_val);
											
												$mail["leave_from"] = $from;
												$mail["leave_to"] = $to;
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
                                                
											$this->session_messages->add_message('success','Leave updated successfully');
											}
											else if($month_differ==1)
											{
												//if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
												//else
												//$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
											
											$new_id =	$this->leave_model->insert_user_leaves($leave_val);
											
												$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
                                                
										//	if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
												//else
											//	$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>1,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
												
											$new_id =	$this->leave_model->insert_user_leaves($leave_val);
											
												$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
                                                
												$leave_type[0]['available_sick_leave'] -= $interval_from->d+1;
											
											$this->session_messages->add_message('success','Leave updated successfully');
											}
									
									}
									
								}
								else
								{
									
									if($month_differ==0){
									//if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
											//else
											//$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
											$new_id =$this->leave_model->insert_user_leaves($leave_val);
											
												$mail["leave_from"] = $from;
												$mail["leave_to"] = $to;
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
											
                                                
											$this->session_messages->add_message('success','Leave updated successfully');
											}
											else if($month_differ==1)
											{
												//if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
												//else
												//$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
												
												$new_id =$this->leave_model->insert_user_leaves($leave_val);
													
												$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
												//if($input["leave"]["approved"]==1)
												$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
												//else
											//	$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
												
												$new_id =$this->leave_model->insert_user_leaves($leave_val);
												
												$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
												$mail["type"] = "Leave";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
                                                
												$leave_type[0]['available_casual_leave'] -= $interval_from->d+1;
											$this->session_messages->add_message('success','Leave updated successfully');
											
											}
									
								}
								
								
							}
							elseif ($input["leave"]["leave_type"]==4)
							{
							
								$input['leave']['type'] = 4;
								//echo "ene";
								$leave_type =$this->available_leaves_model->get_user_leaves_by_type($user_id,'compoff');
								if($interval->d+1>$leave_type[0]['comp_off'])
								{
									$this->session_messages->add_message('warning',"Your compoff days are less than the requested number of days");
									$data["error"] = 1 ;
								}
								else
								{
									$new_value = $leave_type[0]['comp_off']-($interval->d+1);
									if($lop==0 && $input["leave"]["approved"]!=2)
									$this->available_leaves_model->update_user_leaves_by_type($user_id,'compoff',$new_value);
									if($month_differ == 0)
									{
									//if($input["leave"]["approved"]==1)
									$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['leave_type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
									//else
									//$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
									$new_id =$this->leave_model->insert_user_leaves($leave_val);
									 
												$mail["leave_from"] = $from;
												$mail["leave_to"] = $to;
												$mail["type"] = "Comp off";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
									$this->session_messages->add_message('success','Comp off leave updated successfully');
									}
									else if($month_differ==1)
									{
										//if($input["leave"]["approved"]==1)
										$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['leave_type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
										//else
											//$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
										$new_id =$this->leave_model->insert_user_leaves($leave_val);
										
												$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
												$mail["type"] = "Comp off";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$mail["approved"] = $input['leave']['approved'];
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
										//if($input["leave"]["approved"]==1)
										$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['leave_type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
										//else
										//$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);	
										$new_id =$this->leave_model->insert_user_leaves($leave_val);
										
												$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
												$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
												$mail["type"] = "Comp off";
												$mail["leave_type"] = $input['leave']['type'];
												$mail["approved"] = $input['leave']['approved'];
												$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
												$this->email_notif->send_mail_notif("edit_leave",$mail);
												
										$this->session_messages->add_message('success','Comp off leave updated successfully');
									
									}
								}
								
							}
							elseif ($input["leave"]["leave_type"]==6)
							{
								
								$input['leave']['type'] = 6;
								$lop=0;
								$leave_type =$this->available_leaves_model->get_user_leaves_by_type($user_id,'available_earned_leave');
								if($interval->d+1>$leave_type[0]['available_earned_leave'])
								{
									
									$this->session_messages->add_message('warning', "Your earned leaves are less than the requested number of days");
									$data["error"] = 1 ;
								}
								else
								{
									$new_value = $leave_type[0]['available_earned_leave']-($interval->d+1);
									if($lop==0 && $input["leave"]["approved"]!=2)
									$this->available_leaves_model->update_user_leaves_by_type($user_id,'available_earned_leave',$new_value);
									if($month_differ == 0)
									{
										//if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
										//else
										//	$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
										$id_leave = $this->leave_model->insert_user_leaves($leave_val);
									//$this->pre_print->viewExit($input);
										$mail["leave_from"] = $from;
										$mail["leave_to"] = $to;
										$mail["type"] = "Earned Leave";
										$mail["leave_type"] = $input['leave']['type'];
										$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
										$this->email_notif->send_mail_notif("apply_leave",$mail);
												
										$this->session_messages->add_message('success','Earned leave applied successfully');
									}
									else if($month_differ==1)
									{
										//if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
									//	else*/
									//		$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$first_from->format('Y-m-d H:i:s'),"leave_to"=>$first_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
										$id_leave = $this->leave_model->insert_user_leaves($leave_val);
										
										$mail["leave_from"] = $first_from->format('Y-m-d H:i:s');
										$mail["leave_to"] = $first_to->format('Y-m-d H:i:s');
										$mail["type"] = "Earned Leave";
										$mail["leave_type"] = $input['leave']['type'];
										$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
										$this->email_notif->send_mail_notif("apply_leave",$mail);
												
										//if($input["leave"]["approved"]==1)
											$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id,"approved_by"=>$admin_id);
										//else*/
										//	$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$second_from->format('Y-m-d H:i:s'),"leave_to"=>$second_to->format('Y-m-d H:i:s'),"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$admin_id);
										$id_leave = $this->leave_model->insert_user_leaves($leave_val);
											
										$mail["leave_from"] = $second_from->format('Y-m-d H:i:s');
										$mail["leave_to"] = $second_to->format('Y-m-d H:i:s');
										$mail["type"] = "Earned Leave";
										$mail["leave_type"] = $input['leave']['type'];
										$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$id_leave;
										$this->email_notif->send_mail_notif("apply_leave",$mail);
												
										
										$this->session_messages->add_message('success','Earned leave applied successfully');
									
									}
								}
								
							}
						
						}
						else
						{
							$this->session_messages->add_message('warning',"Already Leave applied for this day");
							$data["error"] = 1 ;
                            
						}
				}
				elseif($input["leave"]["leave_type"]==3 )
				{
					
					$from = date("Y-m-d H:i:s",strtotime($input["leave"]["leave_from"]));
					$to = date("Y-m-d H:i:s",strtotime($input["leave"]["leave_to"]));
					$leaves_applied = $this->leave_model->get_user_leaves_by_date($user_id,$from,$to,null,$leave_id);
					$full_day_leave1  = $this->leave_model->get_user_leaves_for_diff($user_id,$from,$leave_id);
					$check = 1;
					if(isset($full_day_leave1)&& !empty($full_day_leave1))
					{
						foreach($full_day_leave1 as $fd)
						{
							$diff_d = $this->dateTimeDiff(new DateTime($fd["leave_from"]),new DateTime($fd["leave_to"]));
							if($diff_d->h==0)
								$check = 0;
						}
					}
					
					if(empty($leaves_applied) && $check!=0)
					{
                    						
					$date1 = new DateTime($from);
					$date2 = new DateTime($to);
					$input['leave']['type'] = 3;
					$interval = $this->dateTimeDiff($date1,$date2);
					$leave_type =$this->available_leaves_model->get_user_leaves_by_type($user_id,'permission');
					if($leave_type[0]['permission']<=0)
					{
						$lop = 1;
					}
					$new_value = $leave_type[0]['permission']-($interval->h);
					/*if($new_value<0)
					{
						$lop =1;
					
					}*/
					if($lop==0 && $input["leave"]["approved"]!=2)
						$this->available_leaves_model->update_user_leaves_by_type($user_id,'permission',$new_value);
				//	if($input["leave"]["approved"]==1)
					$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
					//else
					//$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
					$new_id =$this->leave_model->insert_user_leaves($leave_val);
					
					$mail["leave_from"] = $from;
					$mail["leave_to"] = $to;
					$mail["type"] = "Permission";
					$mail["leave_type"] = $input['leave']['type'];
					$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
					$mail["approved"] = $input['leave']['approved'];
					//$mail["link"] = $
					$this->email_notif->send_mail_notif("edit_leave",$mail);
					
					$this->session_messages->add_message('success','Permission updated successfully');

					}
					else
					{
						$this->session_messages->add_message('warning',"Already Leave applied for this day");
							$data["error"] = 1 ;
                            
					}
				}
				else if($input["leave"]["leave_type"]==5 )
				{
					$from = date("Y-m-d H:i:s",strtotime($input["leave"]["leave_from"]));
					$to = date("Y-m-d H:i:s",strtotime($input["leave"]["leave_to"]));
					$leaves_applied = $this->leave_model->get_user_leaves_by_date($user_id,$from,$to,null,$leave_id);
					$full_day_leave1  = $this->leave_model->get_user_leaves_for_diff($user_id,$from,$leave_id);
					$check = 1;
					if(isset($full_day_leave1)&& !empty($full_day_leave1))
					{
						foreach($full_day_leave1 as $fd)
						{
							$diff_d = $this->dateTimeDiff(new DateTime($fd["leave_from"]),new DateTime($fd["leave_to"]));
							if($diff_d->h==0)
								$check = 0;
						}
					}
					
					if(empty($leaves_applied) && $check!=0)
					{
												
						$date1 = new DateTime($from);
						$date2 = new DateTime($to);
						$input['leave']['type'] = 5;
						$interval = $this->dateTimeDiff($date1,$date2);
						$lop = 0;
					//	if($input["leave"]["approved"]==1)
						$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id,"approved_by"=>$admin_id);
						//else
						//print_r($leave_val);exit;
						//$leave_val = array("user_id"=>$user_id,"reason"=>$input['leave']['reason'],"leave_from"=>$from,"leave_to"=>$to,"lop"=>$lop,"type"=>$input['leave']['type'],"approved"=>$input["leave"]["approved"],"applied_by"=>$applied_by_user_id);
						$new_id =$this->leave_model->insert_user_leaves($leave_val);
						
						$mail["leave_from"] = $from;
						$mail["leave_to"] = $to;
						$mail["type"] = "On-duty";
						$mail["leave_type"] = $input['leave']['type'];
						$mail["link"] = $this->config->item('base_url')."users/leaves/view_user_leave/".$new_id;
						$mail["approved"] = $input['leave']['approved'];
						//$mail["link"] = $
						$this->email_notif->send_mail_notif("edit_leave",$mail);
						
						$this->session_messages->add_message('success','On-duty updated successfully');
					}
					else
					{
						
							if(isset($leaves_applied)&& !empty($leaves_applied))
							{
								foreach($leaves_applied as $leave)
								{
									if($leave["approved"]==2)
										$reject = 1;
								
								}
							}
							if($reject==1)
								$this->session_messages->add_message('warning',"Already Leave applied & rejected for this day");
							else
								$this->session_messages->add_message('warning',"Already Leave applied for this day");
							$data["error"] = 1 ;
					}
				}


				
		
				if(!isset($data["error"]))
				{
					if(isset($input["page"]))
					{
						if($input["page"]==1)
							redirect($this->config->item('base_url')."attendance/leave/view_user_leave/".$user_id."/".$new_id);
						else
							redirect($this->config->item('base_url')."attendance/leave/view_all_user_leaves/");
					}
					else
						redirect($this->config->item('base_url')."attendance/leave/view_user_leaves/".$user_id);
				}
				}		
		}
		//$this->pre_print->viewExit($data);
		$data["user_id"]  = $user_id;
		$datam["messages"]= $this->session_messages->view_all_messages();
		$this->template->write_view('session_msg', 'masters/session_messages',$datam);
		$this->template->write_view('content', 'attendance/edit_leave',$data);
		$this->template->render();
		}
		else
			echo "Page Not Found";
	}
	
	function cancel_user_leave($user_id,$leave_id)
	{
		$this->load->model('masters/available_leaves_model');
		$this->load->model('masters/user_department_model');
		$this->load->model('masters/shift_model');
		$this->load->model('leave_model');
		$data["available"] = $this->available_leaves_model->get_user_leaves_by_user_id($user_id);
		$data["leave"] = $this->leave_model->get_user_leaves_by_leave_id($leave_id);
		$admin_id = $this->user_auth->get_user_id();
			$mail = array();
			$department_head= $this->user_department_model->get_user_dept_head_by_userid($user_id);
			if(isset($department_head) && !empty($department_head))
			{
				$mail["department_head"] = $department_head[0]["email"];
				$mail["head_name"] = $department_head[0]["head_name"];
			}
			$user_mail = $this->users_model->get_user_mail_id_by_user_id($user_id);
			$admin_mail = $this->users_model->get_user_mail_id_by_user_id($admin_id);
			$mail["user"] = $user_mail[0]["email"];
			$mail["user_name"] = $user_mail[0]["name"];
			$mail["admin"] = $admin_mail[0]["email"];
			$mail["admin_name"] = $admin_mail[0]["name"];
			$mail["user_id"] = $user_id;
			
		if(isset($data["leave"]) && !empty($data["leave"]))
		{
		$date3 = new DateTime($data["leave"][0]["date_from"]);
		$date4 = new DateTime($data["leave"][0]["date_to"]);
		$mail["leave_from"] = $data["leave"][0]["date_from"];
		$mail["leave_to"] = $data["leave"][0]["date_to"];
		
		$interval2=$this->dateTimeDiff($date3,$date4);
		
		$type = $data["leave"][0]["type"];
		
		if($type=='casual leave' ||$type=="sick leave")
		{
			if($interval2->d==0 && $interval2->h>0)
				$data["type"] = 1;
			else if($interval2->h==0)
				$data["type"] = 2;
		}
		else
		{
			if($type =="compoff")
				$data["type"] = 4;
			else if($type=="permission")
				$data["type"] = 3;
			else if($type=="on-duty")
				$data["type"] = 5;
			else if($type=="earned leave")
				$data["type"] = 6;
		}
		
		if($data["type"]==1)
		{
			$session_time = date('h:i:s',strtotime($data["leave"][0]["leave_from"]));
			$compare_time = date('12:00:00');
			//echo $session_time;
			if($session_time < $compare_time)
			{
				$data["session"] = 1;
				$mail["session"] = "session1";
			}
			else
			{
				$data["session"] = 2;
				$mail["session"] = "session2";
			}
			$mail["type"] = "Half day leave";
			//else
				
		}
		$date3 = new DateTime(date('d-m-Y H:i:s',strtotime($data["leave"][0]['leave_from'])));
		$date4 = new DateTime(date('d-m-Y H:i:s',strtotime($data["leave"][0]['leave_to'])));
		$interval3 = $this->dateTimeDiff($date3,$date4);
		$add_value =0;
		if($data["type"]==1 || $data["type"]==2)
		{
			if(isset($data["type"]))
			{
				$old_leave =$this->available_leaves_model->get_user_leaves_by_type($user_id,$data["leave"][0]["type"]);
			}
			if($data["type"]==1)
			{
				$add_value =0.5;
				
			}
			elseif($data["type"] ==2)
			{
				$add_value =$interval3->d+1;
				$mail["type"] = "Leave";
			}
		}
		
		else if($data["type"]==3)
		{
			$add_value =$interval3->h;
			$old_leave =$this->available_leaves_model->get_user_leaves_by_type($user_id,'permission');
			$mail["type"] = "Permission";
		}
		else if($data["type"]==4)
		{
			$add_value =$interval3->d+1;
			$old_leave =$this->available_leaves_model->get_user_leaves_by_type($user_id,'comp_off');
			$mail["type"] = "Comp off";
		}
		else if($data["type"]==6)
		{
			$add_value =$interval3->d+1;
			$old_leave =$this->available_leaves_model->get_user_leaves_by_type($user_id,'available_earned_leave');
			$mail["type"] = "Earned leave";
		}
		if(isset($old_leave[0]['available_casual_leave']))
			$new_value = $old_leave[0]['available_casual_leave']+$add_value;
		else if(isset($old_leave[0]['available_sick_leave']))
			$new_value = $old_leave[0]['available_sick_leave']+$add_value;
		else if(isset($old_leave[0]['permission']))
			$new_value = $old_leave[0]['permission']+$add_value;
		else if(isset($old_leave[0]['comp_off']))
			$new_value = $old_leave[0]['comp_off']+$add_value;
		else if(isset($old_leave[0]['available_earned_leave']))
			$new_value= $old_leave[0]['available_earned_leave']+$add_value;
			
		if($data["leave"][0]["lop"]==0 && $data["leave"][0]["approved"]!=2 && $data["type"]!=5)
			$this->available_leaves_model->update_user_leaves_by_type($user_id,$type,$new_value);
		$this->leave_model->delete_user_leaves_by_id($leave_id);
		$mail["leave_type"] = $data["leave"][0]['type'];
		$mail["link"] = $this->config->item('base_url');
		$this->email_notif->send_mail_notif("cancel_leave",$mail);
		$this->session_messages->add_message('error',$type.' cancelled');

		if(isset($_GET['page']))
		{
			if($_GET['page']==1)
				redirect($this->config->item('base_url'));	
			else
				redirect($this->config->item('base_url')."attendance/leave/view_all_user_leaves/");	
		}
		else
		
			redirect($this->config->item('base_url')."attendance/leave/view_user_leaves/".$user_id);	
		}
		
		
		else
			echo "Page Not Found";
			
	}
	function leave_balance_and_history()
	{
		$this->load->model('masters/users_model');
		$this->load->model('masters/options_model');
		$this->load->model('masters/department_model');
		$this->load->model('masters/designation_model');
		$this->load->model('attendance/leave_history_model');
		$this->load->model('masters/user_roles_model');
		$this->load->model('masters/options_model');


		$data["default_number_of_records"] = $this->options_model->get_option_by_name('default_number_of_records');
		$options =  array('enable_earned_leave');
		$data["settings"]= $this->options_model->get_option_by_name($options);		
		$data["roles"] = $this->user_roles_model->get_user_role($this->user_auth->get_user_id());
		$result = array();
		$filter=null;
		
		if($this->input->post("search"))
		{
		
			$filter = $this->input->post();
		
			if(isset($filter["search"]))
				unset($filter["search"]);
			
			$data["no_of_users1"] = $this->users_model->get_filter_user_count($filter,1);
			
			$this->session_view->add_session(null,null,$filter);
			
			redirect($this->config->item('base_url')."attendance/leave/leave_balance_and_history/");
		}
		else
		{
			$filter = $this->session_view->get_session(null,null);
			
			if(isset($filter) && !empty($filter))
			{
				$data["no_of_users1"] = $this->users_model->get_filter_user_count($filter,1);
				
			}
			else
			{
				$data["no_of_users1"] = $this->users_model->get_users_count(1);
				
			}
			//print_r($filter);
		
		}
		
		if(isset($filter["show_count"]))
		
			$default = $filter["show_count"];
		
		else
		{
			if(isset($data["default_number_of_records"]) && !empty($data["default_number_of_records"]))
		
				$default =$data["default_number_of_records"][0]["value"];
			else
				$default = 10;
		}
		
		if(isset($filter["inactive"]))
			$data["status"] = TRUE;
		//$result['suffix'] = '?show='.$default ;
		$result["total_rows"] = $data["no_of_users1"][0]['count'];
		$result["base_url"] = $this->config->item('base_url') . "attendance/leave/leave_balance_and_history/";
		$result["per_page"] = $default;
		$data["count"] = $default;
		//print_r($data["count"]);
		$result["num_links"] =3;
		$result["uri_segment"] = 4;
		$result['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
		$result['full_tag_close'] = '</ul>';
		$result['prev_link'] = '&lt;';
		$result['prev_tag_open'] = '<li>';
		$result['prev_tag_close'] = '</li>';
		$result['next_link'] = '&gt;';
		$result['next_tag_open'] = '<li>';
		$result['next_tag_close'] = '</li>';
		$result['cur_tag_open'] = '<li class="current"><a href="#">';
		$result['cur_tag_close'] = '</a></li>';
		$result['num_tag_open'] = '<li>';
		$result['num_tag_close'] = '</li>';
		 
		$result['first_tag_open'] = '<li>';
		$result['first_tag_close'] = '</li>';
		$result['last_tag_open'] = '<li>';
		$result['last_tag_close'] = '</li>';
		 
		$result['first_link'] = '&lt;&lt;';
		$result['last_link'] = '&gt;&gt;';
		$this->pagination->initialize($result);
		
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		if($default == "all")
		{
			
			$data['users'] = $this->users_model->get_users_leaves_with_dept_without_limit($filter,1);
			//$this->pre_print->viewExit($data);
		}
		else
			$data['users'] = $this->users_model->get_users_leaves_with_dept_by_limit($result["per_page"],$page,$filter,1);
		
		$data["links"] = $this->pagination->create_links();
		$data["start"] = $page;
		$data["departments"] = $this->department_model->get_all_departments_by_status(1);
		$data["designations"] = $this->designation_model->get_all_designations();		
		//print_r($filter);
		
	
		$this->template->write_view('content', 'attendance/view_available_user_leaves',$data);
		$this->template->render();
	}
	function edit_available_user_leaves($user_id)
	{
		$this->load->model('masters/options_model');
		$this->load->model('masters/available_leaves_model');
		$this->load->model('attendance/leave_history_model');
		$this->load->model('masters/users_model');
		$options =  array('enable_earned_leave');
		$data["settings"]= $this->options_model->get_option_by_name($options);
		$data['leave'] = $this->available_leaves_model->get_user_leaves_by_user_id($user_id);
		$data["dept"] = $this->user_department_model->get_department_by_user_id($user_id);
		$data["name"] = $this->users_model->get_user_name_by_user_id($user_id);
		if($this->input->post("save"))
		{
			$input = $this->input->post('leave');
			$data["input"] = $input;
			$options=array('available_casual_leave','available_sick_leave','available_earned_leave','comp_off','permission');
			$type = array(2,1,5,4,3);
			if(isset($input)&& !empty($input))
			{
				//$this->pre_print->view($input);
				$leave_arr = array();
				for($i=0;$i<4;$i++)
				{
					if(isset($input[$options[$i]]) && $input[$options[$i]]!="")
					{
						//echo "ente";
						$rules = "required";
							
						$leave_arr[] = array(
						'field'   => 'leave[reason]['.$i.']',
						'label'   => 'Reason', 
						'rules'   => $rules
						);
					}
				}
				$this->form_validation->set_rules($leave_arr);
				//$this->pre_print->view($leave_arr);
				if ($this->form_validation->run() != FALSE)
				{
					//$this->pre_print->view($input);
					$leave = $input;
					if(isset($leave['reason']))
						unset($leave['reason']);
					foreach($leave as $key=>$val)
					{
						if($leave[$key]=="")
							unset($leave[$key]);
					}
					if(isset($data['leave']) && !empty($data["leave"]))
						$this->available_leaves_model->update_user_leaves_by_user_id($user_id,$leave);
					else
					{
						$leave["user_id"]= $user_id;
						$this->available_leaves_model->insert_user_leaves($leave);
					}
					for($i=0;$i<5;$i++)
					{
						if(isset($input["reason"][$i])&& $input["reason"][$i]!="")
						{
							$leave_val = $data["leave"][0][$options[$i]];
							if($data["leave"][0][$options[$i]]==NULL)
								$leave_val = 0;
							$statement = "Count is changed from ".$leave_val." to ".$input[$options[$i]]." for ".$input["reason"][$i];
							//changed by not added
							//$insert = array("user_id"=>$user_id,"history"=>$statement,"changed_by"=>0,"leave_type"=>$type[$i]);
							$insert = array("user_id"=>$user_id,"history"=>$statement,"leave_type"=>$type[$i]);
							$this->leave_history_model->insert_user_leave_history($insert);
						}
					
					}
					$this->session_messages->add_message('success','User leaves count changed');

					redirect($this->config->item('base_url')."attendance/leave/leave_balance_and_history/");
				}
			}
			//$this->pre_print->viewExit($leave_arr);
		}
		
		//$this->pre_print->viewExit($data);
		$this->template->write_view('content', 'attendance/edit_user_leaves',$data);
		$this->template->render();
	
	}
	function approve_user_leaves()
	{
		$this->load->model('masters/users_model');
		$this->load->model('masters/department_model');
		$this->load->model('masters/designation_model');
		$this->load->model('masters/user_roles_model');
		
		$data["roles"] = $this->user_roles_model->get_user_role($this->user_auth->get_user_id());
		$result = array();
		$filter=null;
		
		if($this->input->post("search"))
		{
		
			$filter = $this->input->post();
		
			if(isset($filter["search"]))
				unset($filter["search"]);
			
			$data["no_of_users1"] = $this->users_model->get_filter_user_count($filter,1);
			
			$this->session_view->add_session(null,null,$filter);
			
			redirect($this->config->item('base_url')."attendance/leave/approve_user_leaves/");
		}
		else
		{
			$filter = $this->session_view->get_session(null,null);
			
			if(isset($filter) && !empty($filter))
			{
				$data["no_of_users1"] = $this->users_model->get_filter_user_count($filter,1);
				
			}
			else
			{
				$data["no_of_users1"] = $this->users_model->get_users_count(1);
				
			}
			//print_r($filter);
		
		}
		if(isset($filter["show_count"]))
		
			$default = $filter["show_count"];
		
		else
			$default =10;
		
		if(isset($filter["inactive"]))
			$data["status"] = TRUE;
		//$result['suffix'] = '?show='.$default ;
		$result["total_rows"] = $data["no_of_users1"][0]['count'];
		$result["base_url"] = $this->config->item('base_url') . "attendance/leave/approve_user_leaves/";
		$result["per_page"] = $default;
		$data["count"] = $default;
		$result["num_links"] =3;
		$result["uri_segment"] = 3;
		$result['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
		$result['full_tag_close'] = '</ul>';
		$result['prev_link'] = '&lt;';
		$result['prev_tag_open'] = '<li>';
		$result['prev_tag_close'] = '</li>';
		$result['next_link'] = '&gt;';
		$result['next_tag_open'] = '<li>';
		$result['next_tag_close'] = '</li>';
		$result['cur_tag_open'] = '<li class="current"><a href="#">';
		$result['cur_tag_close'] = '</a></li>';
		$result['num_tag_open'] = '<li>';
		$result['num_tag_close'] = '</li>';
		 
		$result['first_tag_open'] = '<li>';
		$result['first_tag_close'] = '</li>';
		$result['last_tag_open'] = '<li>';
		$result['last_tag_close'] = '</li>';
		 
		$result['first_link'] = '&lt;&lt;';
		$result['last_link'] = '&gt;&gt;';
		$this->pagination->initialize($result);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		if($default == "all")
			$data['users'] = $this->users_model->get_users_with_dept($filter,1);
		else
			$data['users'] = $this->users_model->get_users_with_dept_by_limit($result["per_page"],$page,$filter,1);
		$data["links"] = $this->pagination->create_links();
		$data["start"] = $page;
		$data["departments"] = $this->department_model->get_all_departments_by_status(1);
		$data["designations"] = $this->designation_model->get_all_designations();
		//print_r($filter);
		//$this->pre_print->viewExit($data);
	
		$this->template->write_view('content', 'attendance/approve_user_leaves',$data);
		$this->template->render();
	
	
	}
	function approve_user_leave($user_id)
	{
		$this->load->model('masters/available_leaves_model');
		$this->load->model('masters/users_model');
		$this->load->model('leave_model');
		if($this->input->post("go"))
		{
			$data["new"] = $this->leave_model->get_user_leaves_user_id_status($this->input->post('year'),$this->input->post('month'),$user_id,0);
			$data["hold"] = $this->leave_model->get_user_leaves_user_id_status($this->input->post('year'),$this->input->post('month'),$user_id,3);
			$data["approved"] = $this->leave_model->get_user_leaves_user_id_status($this->input->post('year'),$this->input->post('month'),$user_id,1);
			$data["reject"] = $this->leave_model->get_user_leaves_user_id_status($this->input->post('year'),$this->input->post('month'),$user_id,2);
			$data["year"] = $this->input->post('year');
			$data["month"] = $this->input->post('month');
		}
		else
		{
			$data["new"] = $this->leave_model->get_user_leaves_user_id_status(date('Y'),date('m'),$user_id,0);
			$data["hold"] = $this->leave_model->get_user_leaves_user_id_status(date('Y'),date('m'),$user_id,3);
			$data["approved"] = $this->leave_model->get_user_leaves_user_id_status(date('Y'),date('m'),$user_id,1);
			$data["reject"] = $this->leave_model->get_user_leaves_user_id_status(date('Y'),date('m'),$user_id,2);
		
		}
		$data["available"] = $this->available_leaves_model->get_user_leaves_by_user_id($user_id);
		$data["status"] = $this->users_model->get_user_status_by_user_id($user_id);
		$data["user_id"] =$user_id;
		//$this->pre_print->viewExit($data);
		$this->template->write_view('content', 'attendance/approve_user_leave',$data);
		$this->template->render();
	
	
	}
	function view_leave_history($user_id)
	{
		$this->load->model('attendance/leave_history_model');
		$this->load->model('masters/options_model');
		$this->load->model('masters/user_department_model');
		$this->load->model('masters/users_model');
		$options =  array('enable_earned_leave');
		$data["settings"]= $this->options_model->get_option_by_name($options);
		$data['history'] = $this->leave_history_model->get_user_leave_history_by_user_id($user_id);
		$data["dept"] = $this->user_department_model->get_department_by_user_id($user_id);
		$data["name"] = $this->users_model->get_user_name_by_user_id($user_id);
		//$this->pre_print->viewExit($data);
		$this->template->write_view('content', 'attendance/view_leave_history',$data);
		$this->template->render();
	}
	function update_leave_by_id($leave_id)
	{
		$this->load->model('leave_model');
		$values = $this->input->post();
		$leave = $this->leave_model->get_leave_status_by_id($leave_id);
		if(isset($leave) && !empty($leave))
		{
			if($leave[0]["approved"]!=$values["approved"])
			{
				if($values["approved"]==1)
					$values["approved_by"] = $this->user_auth->get_user_id();
				$this->session_messages->add_message('success','Leave status changed');
				$this->leave_model->update_user_leaves_by_id($leave_id,$values);
			}
		}
		//print_r($values);
	}
	function view_all_user_leaves()
	{
		$this->load->model('masters/users_model');
		$this->load->model('masters/department_model');
		$this->load->model('masters/user_department_model');
		$this->load->model('masters/designation_model');
		$this->load->model('attendance/leave_model');
		$this->load->model('masters/user_roles_model');
		$this->load->model('masters/options_model');

		$data["default_number_of_records"] = $this->options_model->get_option_by_name('default_number_of_records');

		$data["enable_earned_leave"]= $this->options_model->get_option_by_name("enable_earned_leave");
		$user_id = $this->user_auth->get_user_id();				
		$dept_id = $this->department_model->get_department_id_by_department_head($user_id);
		if(isset($dept_id) && !empty($dept_id))
		{
			foreach($dept_id as $dept)
			{
				$dept_id_list [] = $dept["id"];		
			}
		}
		
		$users = array();
		if($this->user_auth->is_department_head())
		{
			$dept_users = $this->user_department_model->get_list_of_user_id($dept_id_list);
					
			if(isset($dept_users) && !empty($dept_users))
			{
				foreach($dept_users as $user)
				{
					if($user["user_id"]!=$user_id)
						$users[] = $user["user_id"];
				}
			}	
			
		}
		//print_r($dept_id_list);
		$data["roles"] = $this->user_roles_model->get_user_role($this->user_auth->get_user_id());
		
		$data["count"] = $this->leave_model->get_all_user_leaves_by_status_count(0,$users);
		
		$filter = $this->session_view->get_session(null,null);
		
		if(isset($filter["show_count"]))
		
			$default = $filter["show_count"];
		
		else
		{
			if(isset($data["default_number_of_records"]) && !empty($data["default_number_of_records"]))
		
				$default =$data["default_number_of_records"][0]["value"];
			else
				$default = 10;
		}
		
		$data["show_count"] = $default;
		$result = array();
		$result["total_rows"] = $data["count"][0]['count'];
		$result["base_url"] = $this->config->item('base_url') . "attendance/leave/view_all_user_leaves/";
		$result["per_page"] = $default ;
		$result["num_links"] = 3;
		$result["uri_segment"] = 4;
		$result['full_tag_open'] = '<ul class="tsc_pagination tsc_paginationA tsc_paginationA01">';
		$result['full_tag_close'] = '</ul>';
		$result['prev_link'] = '&lt;';
		$result['prev_tag_open'] = '<li>';
		$result['prev_tag_close'] = '</li>';
		$result['next_link'] = '&gt;';
		$result['next_tag_open'] = '<li>';
		$result['next_tag_close'] = '</li>';
		$result['cur_tag_open'] = '<li class="current"><a href="#">';
		$result['cur_tag_close'] = '</a></li>';
		$result['num_tag_open'] = '<li>';
		$result['num_tag_close'] = '</li>';
		 
		$result['first_tag_open'] = '<li>';
		$result['first_tag_close'] = '</li>';
		$result['last_tag_open'] = '<li>';
		$result['last_tag_close'] = '</li>';
		 
		$result['first_link'] = '&lt;&lt;';
		$result['last_link'] = '&gt;&gt;';
		$this->pagination->initialize($result);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		//$filter = $this->session_view->get_session(null,null);
		if($default == "all")
	
			$data['leaves'] = $this->leave_model->get_all_user_leaves_by_status_without_limit(0,$users);
		else
			$data['leaves'] = $this->leave_model->get_all_user_leaves_by_status($result["per_page"],$page,0,$users);
		
		$data["links"] = $this->pagination->create_links();
		$data["start"] = $page;
		
		
		//$this->pre_print->view($filter);
		
		$this->template->write_view('content', 'attendance/view_all_user_leaves',$data);
		$this->template->render();
	}
	
	function dateTimeDiff($date1, $date2) 
	{

		$alt_diff = new stdClass();
		$alt_diff->y =  floor(abs($date1->format('U') - $date2->format('U')) / (60*60*24*365));
		$alt_diff->m =  floor((floor(abs($date1->format('U') - $date2->format('U')) / (60*60*24)) - ($alt_diff->y * 365))/30);
		$alt_diff->d =  floor(floor(abs($date1->format('U') - $date2->format('U')) / (60*60*24)) - ($alt_diff->y * 365) - ($alt_diff->m * 30));
		$alt_diff->h =  floor( floor(abs($date1->format('U') - $date2->format('U')) / (60*60)) - ($alt_diff->y * 365*24) - ($alt_diff->m * 30 * 24 )  - ($alt_diff->d * 24) );
		$alt_diff->i = floor( floor(abs($date1->format('U') - $date2->format('U')) / (60)) - ($alt_diff->y * 365*24*60) - ($alt_diff->m * 30 * 24 *60)  - ($alt_diff->d * 24 * 60) -  ($alt_diff->h * 60) );
		$alt_diff->s =  floor( floor(abs($date1->format('U') - $date2->format('U'))) - ($alt_diff->y * 365*24*60*60) - ($alt_diff->m * 30 * 24 *60*60)  - ($alt_diff->d * 24 * 60*60) -  ($alt_diff->h * 60*60) -  ($alt_diff->i * 60) );
		$alt_diff->invert =  (($date1->format('U') - $date2->format('U')) > 0)? 0 : 1 ;
	
		return $alt_diff;
	} 
	
}?>