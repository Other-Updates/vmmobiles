<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template');  ?>   
 <script type="text/javascript" src="<?= $theme_path; ?>/js/employee.js"></script>
<div class="contentinner">
    <h4 class="widgettitle">Approve User Leaves </h4>           
    <div class="widgetcontent">
    		<div class="well well-small">
            	 <?php 
				 $user_role = json_decode($roles[0]["roles"]);
				
		 		$filter = $this->session_view->get_session(null,null);
		 		$attributes = array('class' => 'stdform editprofileform','method'=>'post');

                echo form_open('',$attributes);?>
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
                     	<th>
                        	<?php 
								$options = array(''=>'Select');
								$default ='';
								if(isset($filter["field"])&& !empty($filter["field"]))
								{
									$default = $filter["field"];
								
								}
								$values = array("employee_id"=>"Employee Id","username"=>"Username","email"=>"Email","mobile"=>"Mobile no","gender"=>"Gender","religion"=>"Religion","blood_group"=>"Blood group","marital_status"=>"Marital status");
								foreach($values as $key => $val)
								{
									$options[$key] = $val;
								
								
								}
								echo form_dropdown('field',$options,$default,'class="uniformselect"');
                        	?>
                        </th>
                        <th>
                        	<?php 
								$default = '';
								if(isset($filter["value"])&& $filter["value"]!="")
								{
									$default = $filter["value"];
								
								}
								$data = array(
										'name' => 'value',
										'class' =>'input-medium',
										'value' =>$default
										
								);
								echo form_input($data);
							?>
                        </th>
                         <th>
                        	<?php 
								$state = FALSE;
								if(isset($status))
									$state =  $status;
								$data = array("name"=>"inactive",
												"value"=>1,
												"class" =>"required",
												"checked" => $state
								);
								echo form_checkbox($data);
							?>&nbsp;Include inactive users
                        </th>
                        <th>
                        	<?php $data = array(
							  'name'        => 'search',
							  'value'		=> 'Search',
							  'class'		=>'btn btn-warning border4',
							  'title'		=>'Search'
							);
					
					 		echo form_submit($data);?>
                        </th>
                         <th>
                        	<a href="javascript:void(0)" style="float:right" title="Reset"><input type="button" class="btn btn-danger border4 reset" value="Reset"></a>
                        </th>
                     </tr>
                </thead>
            </table>
            </div>
               <?php 
					$options = array(10=>"10",25=>"25",50=>"50");
					$count_start = $no_of_users1[0]['count']/100;
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
                         <span style="background-color:#c73f38;" class="btn-rounded" >&nbsp;&nbsp;&nbsp;&nbsp;</span> - Incomplete
                   </span>
           <div class="scroll_bar">
    	   <table class="table table-bordered sortable" >
        	<thead>
            	<?php //print_r($shifts);
				$head = array("Id","Employee Id","Name","Department","Designation","Email");
				$db_name = array("id","emp_id","first_name","dept_name","des_name","email");
				?>
            	<tr>
                	
            	<?php 
					$i =0;
					$filter = $this->session_view->get_session(null,null);
					foreach($head as $ele)
					{
						$elem_class = $elem_id = "";
						if(isset($filter["sort"])){
						if($db_name[$i] == $filter["sort"]) {
							$elem_class = "class='sort' ";
							$elem_id = "id='".$filter["order"]."' ";
						}
						}
						echo "<th ".$elem_class.$elem_id." data='".base64_encode($db_name[$i++])."'>".$ele."</th>";
					}
					if(isset($status))
					{
						echo "<th>Status</th>";
					}
					if(in_array("leave:approve_user_leave",$user_role)){
				?>
                <th class="action">Action</th>
                <?php }?>
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
                            	<td class="center"><?=$user["id"]?></td>
                                <td class="center"><?=$user["employee_id"]?></td>
                                <td class="center"><?=ucwords($user['first_name'])?></td>
                                <td class="center"><?=ucwords($user["dept_name"])?></td>
                                <td class="center"><?=ucwords($user["des_name"])?></td>
                                <td class="center"><?=$user['email']?></td>
                                <?php 
									$us = "active";
									if($user["status"]==0)
										$us = "in-active";
									if(isset($status))
									{
										echo "<td class='center'>".$us."</td>";
									}								
								?>
                                <?php 
							  		$url = $this->config->item('base_url')."attendance/leave/approve_user_leave/".$user["id"];
									if($class!="")
							  		$url = $this->config->item('base_url')."attendance/leave/approve_user_leave/".$user["id"]."?us=1";
									$v=0;
									if(in_array("leave:approve_user_leave",$user_role)){
							        ?>
                                <td class="center action">
                                    <a href="<?=$url?>" title="View" class="btn btn-success btn-rounded"><i class="icon icon-eye-open"></i></a>
                                </td>
                                <?php 
								$v=1;
								}?>
                            </tr>
						<?php 
						}
					
					}
					else
					{
						if(isset($status))
						{
							if(in_array("leave:approve_user_leave",$user_role))
								echo "<tr><td colspan='8'>No Records Found</td></tr>";
							else
								echo "<tr><td colspan='7'>No Records Found</td></tr>";
						}
						else
						{
							if(in_array("leave:approve_user_leave",$user_role))
								echo "<tr><td colspan='7'>No Records Found</td></tr>";
							else
								echo "<tr><td colspan='6'>No Records Found</td></tr>";
						}
					}	
				?>
                
            </tbody>
        </table>
        </div>
           <?php
			if(isset($users) && !empty($users))
			{
				$end=$start + count($users);
				 if($start==0)
					$start=1;
					?>
			Showing <?=$start?> to <?=$end?> of <?=$no_of_users1[0]['count']?> records
            <?php }?>
        
        
     
         <div class="button_right_align">
         <?php if(isset($links) && $links!=NULL)
					echo $links;?><br />
                     
      			</div>
       
    </div>
   
</div>
<script type="text/javascript">

	$(document).ready(function(){
		<?php 
		if($exist==1) {	?>
		$("#legend").css("display","block");
		<?php }		
		if($v==0) { ?>
		$(".action").css("display","none");
		<?php } ?>
	});
</script>
