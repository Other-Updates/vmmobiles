<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template');  ?>   
<script type="text/javascript" src="<?=$theme_path?>/js/userleaves.js"></script>
 <div class="contentinner">
    <h4 class="widgettitle">Apply Leave / On-duty </h4>           
    <div class="widgetcontent">
    	   <h4 class="emp_info">
                	<span class=""><span class="emp_title">Employee Name</span> :<?php echo $name[0]['first_name']; ?>&nbsp;<?php echo $name[0]['last_name']; ?></span>
                	<span class=""><span class="emp_title">Department</span> : <?php echo $dept[0]['dep_name']; ?></span>
                    <span class=""><span class="emp_title">Designation</span> : <?php echo $dept[0]['des_name']; ?></span>
           </h4>
    		<?php $result = validation_errors();
			 if(trim($result)!=""):?>
    		<div class="alert alert-error">
                	<button data-dismiss="alert" class="close" type="button">&times;</button>
                       		<?php echo implode("</p>",array_unique(explode("</p>", validation_errors()))); ?>

             </div>
           <?php endif;
		   //	print_r($leave);
		   ?>          
		   
           <?php $attributes = array('class' => 'stdform editprofileform','method'=>'post');
				
                echo form_open('',$attributes);?>
           <table class="table alert alert-success">
           	<thead>
            	<tr>
                	<th>Available Casual Leave : <?php if(isset($leave[0]['available_casual_leave'])):
															if($leave[0]['available_casual_leave']<0) 
																echo 0;
															else 
															echo $leave[0]['available_casual_leave'];
														endif;?></th>
                   <th>Available Sick Leave : <?php if(isset($leave[0]['available_sick_leave'])):
				   									if($leave[0]['available_sick_leave']<0) echo 0;
				   									else echo $leave[0]['available_sick_leave'];
													endif;?></th>
                    <th>Available Comp Off : <?php echo isset($leave[0]['comp_off'])&& $leave[0]['comp_off']!="" && $leave[0]['comp_off']>0?$leave[0]['comp_off']:0; ?></th>
                     <th>Available Permission(in Hours) : <?php if($leave[0]['permission']<0) echo 0;
													else 
														echo $leave[0]['permission'];?></th>
                       <?php 
					   	if(isset($enable_earned_leave)&& !empty($enable_earned_leave))
						{
							if($enable_earned_leave[0]["value"]==1)
								{
					   ?>
                       		 <th>Available Earned Leave : <?php if($leave[0]['available_earned_leave']==NULL && $leave[0]['available_earned_leave']<0) echo 0;
													else 
														echo $leave[0]['available_earned_leave'];?></th>
                       <?php 	}
					   		}
					   ?>
                </tr>
            </thead>
           </table>
           <br />
          <div class="scroll_bar">
    	  <table class="table table-bordered">
          	<thead>
            	<th>Duration Type </th>
                    	
                    <th class="half_option" >
                    	Session
                    </th>
                   <th class="date">Date</th>  
            	<th class="leave_from" id="leave_f">Leave From</th>
                <th class="leave_to" id="leave_t">Leave To</th>
              
                <th>Reason</th>
             	<th class="lop_td">LOP</th>
                <th>Status</th>
                <th class="leave_type">Leave Type</th>
                
            </thead>
            <tbody>
            	<tr>
                <td class="center"><?php 
						if(isset($leave[0]['comp_off']))
						{
							if($leave[0]["comp_off"]>0)
							{
								$options = array(""=>"Select",1=>"Half day leave",2=>"Full day leave",3=>"Permission",4=>"Comp off","5"=>"On-duty");									if(isset($enable_earned_leave)&& !empty($enable_earned_leave))
									{
										if($enable_earned_leave[0]["value"]==1)
										{
											if($leave[0]['available_earned_leave']!=NULL && $leave[0]['available_earned_leave']>0)
												$options[6] = "Earned leave"	;
										}
									}
							}
							else
							{
								$options = array(""=>"Select",1=>"Half day leave",2=>"Full day leave",3=>"Permission","5"=>"On-duty");
								if(isset($enable_earned_leave)&& !empty($enable_earned_leave))
								{
									if($enable_earned_leave[0]["value"]==1)
									{
										if($leave[0]['available_earned_leave']!=NULL && $leave[0]['available_earned_leave']>0)
											$options[6] = "Earned leave"	;
									}
								}	
							}
						}
						else
						{
							$options = array(""=>"Select",1=>"Half day leave",2=>"Full day leave",3=>"Permission","5"=>"On-duty");
							if(isset($enable_earned_leave)&& !empty($enable_earned_leave))
							{
								if($enable_earned_leave[0]["value"]==1)
								{
									if($leave[0]['available_earned_leave']!=NULL && $leave[0]['available_earned_leave']>0)
										$options[6] = "Earned leave"	;
								}
							}
						}
						echo form_dropdown('leave[leave_type]',$options,set_value('leave[leave_type]'),'class="required input-medium" id="type_select"');
					?></td>
                     <td class="half_option center">
                    	<?php 
						
						$options = array(""=>"Select",1=>"Session 1",2=>"Session 2");
						
						echo form_dropdown('leave[session]',$options,set_value('leave[session]'),'class="input-medium"');
					?>
                    </th>
                    <td class="center date" ><?php 
					$data = array(
							'name' =>'leave[date]',
							'class' =>'required input-small input-date',
							'id' =>'datepicker',
							'readonly'=>'readonly',
							'value' =>set_value('leave[date]')
					);
					echo form_input($data);
				?>
                </td>
				<td class="center leave_from" ><?php 
					$data = array(
							'name' =>'leave[leave_from]',
							'class' =>'required datetimepicker input-small leave_from1',
							'value' =>set_value('leave[leave_from]'),
							'readonly'=>'readonly'
							
					);
					echo form_input($data);
				?>
                </td>
                <td class="center leave_to"><?php 
					$data = array(
							'name' =>'leave[leave_to]',
							'class' =>'required datetimepicker input-small leave_to1',
							'value' =>set_value('leave[leave_to]'),
							'readonly'=>'readonly'
					);
					echo form_input($data);
				?>
                </td>
                
                <td class="center"><?php 
					$data = array(
							'name' =>'leave[reason]',
							'class' =>'required',
							'value' =>set_value('leave[reason]')
					);
					echo form_input($data);
				?>
                </td>
                <td class="center lop_td">
                	<?php 
						//print_r($input["leave"]["lop"]);
						/*if($this->user_auth->is_admin())
						{*/
							$cheked_status = FALSE;
							if(isset($_POST['save']))
							{
								if(isset($input["leave"]["lop"]))
								{
									$cheked_status = TRUE;
								}
							}
							
							
							$data = array(
									'name' =>'leave[lop]',
									'value' =>1,
									'checked'=>$cheked_status
								
							);
							echo form_checkbox($data);
						/*}
						else
						{
						
							$cheked_status = FALSE;
							$data = array(
									'name' =>'leave[lop]',
									'value' =>1,
									'checked'=>$cheked_status,
									'disabled' =>'disabled'
								
							);
							echo form_checkbox($data);
						}*/
					?>
                </td>
                 <td class="center">
                	<?php 
					        $default = "";
							if(isset($_POST['save']))
							{
								if(isset($input["leave"]["approved"]))
								{
								$default = $input["leave"]["approved"];
								}
							}						
										
						$options = array(""=>"Select","0"=>"New",1=>"Approved",2=>"Reject",3=>"Hold");
						echo form_dropdown('leave[approved]',$options,$default,'class="required input-medium" id="type_select"');
							
					?>
                </td>
                <td class="center leave_type">
                
                	<?php 	
							$checked_status1 = FALSE;
							$checked_status2 = FALSE;
							if(isset($_POST['save']))
							{
								if(isset($input["leave"]["type"]))
								{
									if($input["leave"]["type"]==1)
									{
										$checked_status = TRUE;
									}
									else
									{
									
										$checked_status2 = TRUE;
									}
								}
							}
							
							$data = array(
									'name' =>'leave[type]',
									'value' =>1,
									'checked'=>$checked_status1,
									'type'=>'radio'
							);
							echo form_checkbox($data)." Sick Leave";
							$data = array(
									'name' =>'leave[type]',
									'value' =>2,
									'checked'=>$checked_status2,
									'type'=>'radio'
							);
							echo "<br>".form_checkbox($data)." Casual Leave";
						
					?>
                </td>
                </tr>
            </tbody>
          </table>
          </div>
    </div>
   
     <div class="button_right_align">
    <?php
					$data = array(
					  'name'        => 'save',
					  'value'		=> 'Save',
					  'class'		=>'btn btn-success border4 submit',
					  'title'		=>'Save'
					);
					
					 echo form_submit($data);
					 if(isset($_GET['page'])){
					 	?>
					 		<a href="<?=$this->config->item('base_url')."attendance/view_attendance/".$user_id?>" title="Cancel"><input type="button" class="btn btn-danger border4" value="Cancel" /></a>
					 <?php }
					 else{
					 ?>
                     
                    <a href="<?=$this->config->item('base_url')."attendance/leave/apply_or_modify_leaves/"?>" title="Cancel"><input type="button" class="btn btn-danger border4" value="Cancel" /></a>
                    <?php }?>
    </div>
  
   
</div>