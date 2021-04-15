<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template');  ?>   
 <script type="text/javascript" src="<?= $theme_path; ?>/js/employee.js"></script>
<div class="contentinner">
    <h4 class="widgettitle">Attendance Details</h4>           
    <div class="widgetcontent">
    		<div class="well well-small">
            	 <?php 
				 //print_r($user_attendance);
				 $user_role = json_decode($roles[0]["roles"]);
				 //print_r($roles);
		 		 $filter = $this->session_view->get_session(null,null);
		 		 $attributes = array('class' => 'stdform editprofileform','method'=>'post');	
                 echo form_open('',$attributes);
				 ?>
            <table class="table responsive_table">
            	<thead>
                	<tr>
                        <th>Department &nbsp; <?php 
						
							$default = '';
								if(isset($filter["department"])&& !empty($filter["department"]))
								{
									$default = $filter["department"];
								
								}
							$options = array();
							if(isset($departments) && !empty($departments))
							{
								foreach($departments as $dept)
								{
									$options[$dept["dept_id"]] = ucwords($dept["dept_name"]);								
								
								}
							}
							echo form_multiselect('department[]',$options,$default,'class="multiselect" id="department_select"');
						?></th>
                        <th id ="designation">Designation &nbsp; <?php 
							$default = '';
								if(isset($filter["designation"])&& !empty($filter["designation"]))
								{
									$default = $filter["designation"];
								
								}
							$options = array();
							if(isset($designations) && !empty($designations))
							{
								foreach($designations as $des)
								{
									$options[$des["id"]] = ucwords($des["name"]);					
								
								}
							}
								echo form_multiselect('designation[]',$options,$default,'class="multiselect" id="designation_select"');
						?></th>
                        <th>Shift <span class="req">*</span>&nbsp;
                        	<?php 
								$default = '';
								if(isset($filter["shift"])&& !empty($filter["shift"]))
								{
									$default = $filter["shift"];
								
								}
							$options = array();
							if(isset($shifts) && !empty($shifts))
							{
								foreach($shifts as $shf)
								{
									$options[$shf["id"]] = ucwords($shf["name"]);
								
								
								}
							}
							echo form_multiselect('shift[]',$options,$default,'class="multiselect" id="shift" ');
                        	?>
                        </th>
                        <th>Salary Group &nbsp;
                        	<?php 
								$default = '';
								if(isset($filter["salary_group"])&& !empty($filter["salary_group"]))
								{
									$default = $filter["salary_group"];
								
								}
							$options = array();
							if(isset($salary_groups) && !empty($salary_groups))
							{
								foreach($salary_groups as $sg)
								{
									$options[$sg["id"]] = ucwords($sg["name"]);						
								
								}
							}
							echo form_multiselect('salary_group[]',$options,$default,'class="multiselect" ');
                        	?>
						
                        </th>
                        <th>Date <span class="req">*</span>&nbsp;
                        	<?php 
								$default = '';
								if(isset($filter["start_date"]) && $filter["start_date"]!="")
								{
									$default = $filter["start_date"];
								
								}
								$data = array(
								  		'id' => 'start_date',
										'name' => 'start_date',
										'class' =>'input-small today-date',
										'value' =>$default
										
								);
								echo form_input($data);
							?>
                        </th>                     	
                         
                        <th>
                        	<?php $data = array(
							  'id'			=> 'attendance-search',
							  'name'        => 'search',
							  'value'		=> 'Search',
							  'class'		=>'btn btn-warning btn-rounded',
							  'title'		=>'Search'
							);
					
					 		echo form_submit($data);?>
                        </th>
                        <th>
                        	<a href="javascript:void(0)" style="float:right" title="Reset"><input type="button" class="btn btn-danger btn-rounded reset" value="Reset"></a>
                        </th>
                     </tr>
                </thead>
            </table>
            </div>
               <?php 
					
					$options = array(10=>"10",25=>"25",50=>"50");
					$count_start = count($no_of_users1)/100;
					if($count_start<=10)
					{
						for($c=1;$c<$count_start;$c++)
						{
							$options[$c*100] = $c*100;
						}
					}
					else if($count_start>10)
					{
					
						for($c=1;$c<$count_start;)
						{
							$options[$c*100] = $c*100;
							$c+=2;
						}
					
					}
					$options["all"] = "All";
					echo "Show ".form_dropdown('record_show',$options,$count,"id='count_change'")." entries";
				?>
                 <span style="float:right;" style="display:none;" id="legend">
                         <span style="background-color:#F2DCE6;" class="btn-rounded" >&nbsp;&nbsp;&nbsp;&nbsp;</span> - Incomplete
                   </span>
           <div class="scroll_bar">
           <?php
		   $attributes = array('class' => 'attendance_data_form','method'=>'post');	
		   echo form_open('',$attributes);
		   ?> 
    	   <table class="table table-bordered sortable" >
        	<thead>
            	<?php //print_r($shifts);
				$head = array("S.No","Employee Id","Username","Employee Name","Department","Designation","Email");
				$db_name = array("id","emp_id","username","first_name","dept_name","des_name","email");
				
				?>
            	<tr>
                	
            	<?php 
					$i =0;
					$id_sort =0;
					//print_r($head);
					$filter = $this->session_view->get_session(null,null);
					foreach($head as $ele)
					{
						$elem_class = $elem_id = "";
						if(isset($filter["sort"])){
						if($db_name[$i] == $filter["sort"]) {
							$elem_class = "class='sort' ";
							$elem_id = "id='".$filter["order"]."' ";
							if($filter["sort"]=="id" && $filter["order"]=="desc")
								$id_sort =1;
						}
						}
						echo "<th ".$elem_class.$elem_id." data='".base64_encode($db_name[$i++])."'>".$ele."</th>";
					}
					if(isset($status))
					{
						echo "<th>Status</th>";
					}
					if($id_sort == 1)
						$s = $no_of_users1[0]['count']-$start;
					else
						$s = $start +1;
				?>
                <th class="action">
                 <?php 
						//echo "<span id='action'>Action</span>";
						$data = array(
						"class" =>"required group_check",
						"checked" => FALSE
					);
					echo form_checkbox($data);
				?>
                </th>
                </tr>
            </thead>
            
            <tbody>
            	<?php 
					if(isset($users) && !empty($users))
					{
						$exist = 0;
						foreach($users as $user)
						{
							$class = "";
							$this->load->model('masters/user_shift_model');
							$this->load->model('masters/user_salary_model');
							$current_shift = $this->user_shift_model->get_user_current_shift_by_user_id($user["id"],null);
							$salary_group = $this->user_salary_model->get_user_salary_by_user_id($user["id"]);
							if($user["dept_name"]=="" || $user["des_name"]=="" || empty($current_shift) || empty($salary_group))
							{
								$class = "in-complete";
								$exist = 1;
							}
						?>	                                                       
							<tr class="<?=$class?>">
                            <?php
							$attendance_data = array("user_id"=>$user["id"],"username"=>$user["username"]);
							?>
                            	<td class="center"><?php echo $id_sort == 1?$s--:$s++;?></td>
                                <td class="center"><?=$user["employee_id"]?></td>
                                <td class="center"><?=$user['username']?></td>
                                <td class="center"><?=ucwords($user['first_name'])." ".ucwords($user['last_name'])?></td>
                               <td class="center"><?=ucwords($user["dept_name"])?></td>
                               <td class="center"><?=ucwords($user["des_name"])?></td>
                                <td class="center"><?=$user['email']?></td>                               
                              <td class="center action">
                              <?php						
							  if(isset($user_attendance) && !empty($user_attendance))
							  {
							  foreach($user_attendance as $today_attendance)
							  {
							   $user_id_list[] = $today_attendance["user_id"];
							  }
							  }
							  
							  if(isset($user_id_list) && !empty($user_id_list)) {							 							 
								  if(!in_array($user["id"],$user_id_list)){						
								 
                                  
                                  $data = array(
															"value" => $user["id"],
															"class" =>"required single_check",
															"checked" => FALSE
											);
											echo form_checkbox($data);
											echo "<input type='hidden' disabled='disabled'  class = 'attendance_data' name='attendance_data[".$user["id"]."]' value='".json_encode($attendance_data)."'>";
                                   ?>       
								  <!--<a title="Add" href="<?=$this->config->item('base_url')."attendance/add_attendance_for_day/".$user["id"]?>" class="btn btn-danger btn-rounded">
								  <i class="icon icon-plus"></i></a>-->
								  <?php							  
								  }	
								  else
								  {?>
								  <i class="icon-thumbs-up"  title="Processed"></i>
								  <?php } 
							  }
							  else {
							  
							  $data = array(
															"value" => $user["id"],
															"class" =>"required single_check",
															"checked" => FALSE
											);
											echo form_checkbox($data);
											echo "<input type='hidden' disabled='disabled'  class = 'attendance_data' name='attendance_data[".$user["id"]."]' value='".json_encode($attendance_data)."'>";
											
							  ?>
                                  <!--<a title="Add" href="<?=$this->config->item('base_url')."attendance/add_attendance_for_day/".$user["id"]?>" class="btn btn-danger btn-rounded">
                                  <i class="icon icon-plus"></i></a>-->
							  <?php
							  }
							  ?>
                              </td>
                            </tr>
						<?php 
						}					
					}
					else
					{
						echo "<tr><td colspan='7'>No Records Found</td></tr>";
					}	
				?>
                
            </tbody>
        </table>
        </div>
           <?php
			if(isset($users) && !empty($users))
			{
				$end=$start + count($users);
				$start = $start+1;
					?>
			Showing <?=$start?> to <?=$end?> of <?=count($no_of_users1)?> records
            <?php }?>
        
        
     
         <div class="button_right_align"><br />          
            <a href="javascript:void(0);" >
            <input type="submit" class="btn btn-success"  value="Add Attendance"  name ="add_attendance" style="display:none" id="add_attendance"/>
            </a>
      	 </div>

       
    </div>
   
</div>
<script type="text/javascript">

	$(document).ready(function(){		
		
		$(".group_check").click(function(){				
			if($(this).is(":checked"))
			{
				$(".single_check").attr("checked","checked");
				$(".attendance_data").removeAttr("disabled");			
			}
			else
			{
				$(".single_check").removeAttr("checked");
				$(".attendance_data").attr("disabled","disabled");			
			}		
			
		});
	});
	$(".single_check").live('click',function(){
		if($(this).is(":checked"))
			{
			$(this).next().removeAttr("disabled");
			}
			else
			{
			$(this).next().attr("disabled","disabled");
			}
	});
	$(".group_check,.single_check").live('click',function(){
		var count=0;				
		$(".single_check:checked").each(function(){
		count++;
		});	
		
		if(count>=1)
		{
		  $("#add_attendance").css("display","block");
		}
		else
		{
		  $("#add_attendance").css("display","none");
		}	
	});
</script>