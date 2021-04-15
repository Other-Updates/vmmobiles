<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template');  ?>   
 <script type="text/javascript" src="<?= $theme_path; ?>/js/employee.js"></script>
<div class="contentinner">
    <h4 class="widgettitle">Leave Balance and History</h4>           
    <div class="widgetcontent">
    		<div class="well well-small">
            	 <?php 
				//print_r($users);
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
                     	<th>&nbsp;
                        	<?php 
								$options = array(''=>'Select');
								$default ='';
								if(isset($filter["field"])&& !empty($filter["field"]))
								{
									$default = $filter["field"];
								
								}
								$values = array("blood_group"=>"Blood group","email"=>"Email","employee_id"=>"Employee Id","gender"=>"Gender","marital_status"=>"Marital status","mobile"=>"Mobile no","religion"=>"Religion","username"=>"Username");
								foreach($values as $key => $val)
								{
									$options[$key] = $val;
								
								
								}
								echo form_dropdown('field',$options,$default,'class="uniformselect"');
                        	?>
                        </th>
                        <th>&nbsp;
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
                        <th>Status&nbsp;
                        	<?php 
								$options = array();
								$default =0;
								if(isset($filter["inactive"])&& !empty($filter["inactive"]))
								{
									$default = $filter["inactive"];								
								}															
								$values = array(0=>"Active",1=>"In-active",2=>"Both");
								if(isset($filter["field"])&& !empty($filter["field"]))
								{
									$default = $filter["field"];								
								}
								foreach($values as $key => $val)
								{
									$options[$key] = $val;							
								}
								echo form_dropdown('inactive',$options,$default,'class="uniformselect"');
                        	?>
                        </th>
                        <th>&nbsp;
                        	<?php $data = array(
							  'name'        => 'search',
							  'value'		=> 'Search',
							  'class'		=>'btn btn-warning border4',
							  'title'		=>'Search'
							);
					
					 		echo form_submit($data);?>
                        </th>
                         <th>&nbsp;
                        	<a href="javascript:void(0)" style="float:right" title="Reset"><input type="button" class="btn btn-danger border4 reset" value="Reset"></a>
                        </th>
                     </tr>
                </thead>
            </table>
            </div>
              <?php 
			  	    $earned_leave = $this->options_model->get_options_by_type('enable_earned_leave');					
			  		$options = array(10=>"10",25=>"25",50=>"50");
					/*$count_start = $no_of_users1[0]['count']/100;
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
					*/
					$options = array();
					$this->load->model('options_model');
					$record = array(10,20,30,40,50,60,70,80,90,100,120,140,160,180,200);
					$closest = $this->options_model->getClosest($no_of_users1[0]['count'],$record);
					//echo $closest;
					for($k=10;$k<=$closest;)
					{
						$options[$k]=$k;
						if($k<100)
							$k=$k+10;
						else
							$k = $k+20;
					}
					if($no_of_users1[0]['count']>=1000)
					{
						$count_start = $no_of_users1[0]['count']/100;
						if($count_start>=10)
						{
						
							for($c=4;$c<$count_start;)
							{
								$options[$c*100] = $c*100;
								$c+=2;
							}
						
						}
					
					}
					if(!in_array($count,$options))
					{
						$max = $this->options_model->getClosest($count,$options);
						if($max<$no_of_users1[0]['count'])
							$count  = "all";
						else
							$count = $max;
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
				$head = array("S.No","Employee Id","Username","Employee Name","Department","Designation","Casual leave","Sick Leave","Earned Leave","Permission","Comp off");
				$db_name = array("id","emp_id","username","first_name","dept_name","des_name","available_casual_leave","available_sick_leave","available_earned_leave","permission","comp_off");
				if(isset($status))
				{
					$db_name[] = "status";
					$head[] = "Status";
				}
				?>
            	<tr>
                	
            	<?php
					$i =0;
					$id_sort =0;
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
						if($ele=="Earned Leave")
						{
						  if($settings[0]["value"]==1)
						    echo "<th ".$elem_class.$elem_id." data='".base64_encode($db_name[$i++])."'>".$ele."</th>";
						}
						else
						{
							echo "<th ".$elem_class.$elem_id." data='".base64_encode($db_name[$i++])."'>".$ele."</th>";
						}
					}
					/*if(isset($status))
					{
						echo "<th>Status</th>";
					}*/
					if($id_sort == 1)
						$s = $no_of_users1[0]['count']-$start;
					else
						$s = $start +1;
				?>
                <th class="action">Action</th>
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
							$current_shift = $this->user_shift_model->get_user_current_shift_by_user_id($user["user_id"],null);
							$salary_group = $this->user_salary_model->get_user_salary_by_user_id($user["user_id"]);
							
							if($user["dept_name"]=="" || $user["des_name"]=="" || empty($current_shift) || empty($salary_group))
							{
								$class = "in-complete";
								$exist = 1;
							}
						?>	
							<tr class="<?=$class?>">

                            	<td class="center"><?php echo $id_sort == 1?$s--:$s++;?></td>
                                <td class="center"><?=$user["employee_id"]?></td>
                                <td class="center"><?=$user["username"]?></td>
                                <td class="center"><?=ucwords($user['first_name'])." ".ucwords($user['last_name'])?></td>
                                <td class="center"><?=ucwords($user["dept_name"])?></td>
                                <td class="center"><?=ucwords($user["des_name"])?></td>
                                <td class="center"><?=$user['available_casual_leave']?></td>
                                <td class="center"><?=$user['available_sick_leave']?></td>
                                <?php if($settings[0]["value"]==1) {?>
                                <td class="center"><?=$user['available_earned_leave']?></td>
                                <?php } ?>
                                <td class="center"><?=$user['permission']?></td>
                                <td class="center"><?=$user['comp_off']?></td>
                                 <?php 
								 	$us = "active";
									if($user["status"]==0)
										$us = "in-active";
									if(isset($status))
									{
										echo "<td class='center'>".$us."</td>";
									}
												
								
								 
								 ?>
                                <td class="center action">                              	 
                                <?php if($us =="active" && $class=="")
								{
								$v=0;
								if(in_array("leave:edit_available_user_leaves",$user_role)){?>
                                <a title="Edit" href="<?=$this->config->item('base_url')."attendance/leave/edit_available_user_leaves/".$user["user_id"]?>" 
                                class="btn btn-info btn-rounded"><i class="icon icon-pencil"></i></a>
                                <?php 
								$v=1;
								}
							    $this->load->model('attendance/leave_history_model');
								if($earned_leave[0]['value'] == 1)
							        $history= $this->leave_history_model->get_leave_history_by_userid($user["user_id"]);
								else
								    $history= $this->leave_history_model->get_leave_history_by_userid_and_without_earned_leave($user["user_id"]);
							    $output=0;
							    if(isset($history) && !empty($history))
							    {
								  $output=1;
								}
								//print_r($output); 
							    if ($output==1){								
								if(in_array("leave:view_leave_history",$user_role)){?>
							    <a title="History" href="<?=$this->config->item('base_url')."attendance/leave/view_leave_history/".$user["user_id"]?>" 
                                class="btn btn-success btn-rounded"><i class="icon icon-book"></i></a> 
                                <?php 
								$v=1;
								}
								}
								}
								else
								{?>
                                <i class="icon icon-remove"></i>
                                <?php }?>
                                </td>
                            </tr>
						<?php 
						}
					
					}
					else
					{
						if(isset($status))
						{
							echo "<tr><td colspan='11'>No Records Found</td></tr>";
						}
						else
						{
							echo "<tr><td colspan='10'>No Records Found</td></tr>";
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
				 	$start = $start+1;
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
		<?php if($exist==1) { ?>
		  $("#legend").css("display","block");
		<?php } else if($v=0) {?>
		  $(".action").css("display","none");
		<?php } ?>
	});
</script>