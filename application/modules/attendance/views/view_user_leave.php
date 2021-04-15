<div class="contentinner">
    <h4 class="widgettitle">View User Leave </h4>           
    <div class="widgetcontent">
    	   <h4 class="emp_info">
                	<span class=""><span class="emp_title">Employee Name</span> :<?php echo $name[0]['first_name']; ?>&nbsp;<?php echo $name[0]['last_name']; ?></span>
                	<span class=""><span class="emp_title">Department</span> : <?php echo $dept[0]['dep_name']; ?></span>
                    <span class=""><span class="emp_title">Designation</span> : <?php echo $dept[0]['des_name']; ?></span>
           </h4>
           <?php 
		   $user_role = json_decode($roles[0]["roles"]);
		   //print_r($user_role);
		   $attributes = array('class' => 'stdform editprofileform','method'=>'post');
				
                echo form_open('',$attributes);?>
           <table class="table alert alert-success">
           	<thead>
            	<tr>
                	<th>Available Casual Leave : <?php if($available[0]['available_casual_leave']==NULL) echo 0.0;
													else 
														echo $available[0]['available_casual_leave'];?></th>
                   <th>Available Sick Leave : <?php if($available[0]['available_sick_leave']==NULL) echo 0.0;
				   									else echo $available[0]['available_sick_leave'];?></th>
                    <th>Available Comp Off : <?php echo isset($available[0]['comp_off'])&& $available[0]['comp_off']!="" && $available[0]['comp_off']>0?$available[0]['comp_off']:0; ?></th>
                     <th>Available Permission(in Hours) : <?php if($available[0]['permission']==NULL) echo 0.0;
													else 
														echo $available[0]['permission'];?></th>
                      <?php 
					   	if(isset($enable_earned_leave)&& !empty($enable_earned_leave))
						{
							if($enable_earned_leave[0]["value"]==1)
								{
					   ?>
                       		 <th>Available Earned Leave : <?php if($available[0]['available_earned_leave']==NULL && $available[0]['available_earned_leave']<0) echo 0;
													else 
														echo $available[0]['available_earned_leave'];?></th>
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
            	<th>Name</th>
            	<th>Duration Type </th>
                    	
                  
                   <?php if($type==1 || $type==2 || $type==6): ?>
                    <th class="leave_from" id="leave_f">Leave From</th>
                    <th class="leave_to" id="leave_t">Leave To</th>
              	<?php elseif($type==3):?>
                    <th class="leave_from" id="leave_f">Permission From</th>
                    <th class="leave_to" id="leave_t">Permission To</th>
                <?php elseif($type==4):?>
                	<th class="leave_from" id="leave_f">Compoff From</th>
                <th class="leave_to" id="leave_t">Compoff To</th>
                
                <?php elseif($type==5):?>
                	<th class="leave_from" id="leave_f">From</th>
                <th class="leave_to" id="leave_t">To</th>
                <?php endif;?>
                <th>Reason</th>
                <?php if($type!=5 && $type!=6){?>
             	<th>LOP</th>
                <?php }?>
                <th>Status</th>   
                <?php if($type!=5 && $type!=6){?>           
                <th class="leave_type" >Leave Type</th>
                <?php }?>
                <?php if(in_array("leave:edit_user_leaves",$user_role) || in_array("leave:cancel_user_leave",$user_role)):?>
              	<th>Action</th>
                <?php endif; ?>
            </thead>
            <tbody>
            	<tr>
                <td class="center"><?=$leave[0]["taken_by_name"]?></td>
                <td class="center"><?php
					//echo $type;
					switch($type)				
					{
						case 1:
							echo "Half day";
							break;
						case 2:
							echo "Full day";
							break;
						case 3:
							echo "Permission";
							break;
						case 4:
							echo "Comp-off";
							break;
						case 5:
							echo "On-duty";
							break;
						case 6:
							echo "earned leave";
							break;
						
					}
					
					?></td>
                    
                    
				<td class="center leave_from" ><?php 
						
							if($type==3 || $type==5)
								echo date('d-m-Y H:i:s',strtotime($leave[0]['leave_from']));
							else
								echo date('d-m-Y',strtotime($leave[0]['leave_from']));
						
				?>
                </td>
                <td class="center leave_to"><?php 
						
							if($type==3|| $type==5)
								echo date('d-m-Y H:i:s',strtotime($leave[0]['leave_to']));
							else
								echo date('d-m-Y',strtotime($leave[0]['leave_to']));
						
				?>
                </td>
                
                <td class="center"><?php 
						echo  $leave[0]['reason'];
							
						
				?>
                </td>
                <?php if($type!=5 && $type!=6){?>
                  <td class="center">
                	<?php 
						
								if($leave[0]['lop']==1)
									echo "<i class='icon icon-check'></i>";
								else
									echo "-";
							
							
						
					?>
                </td>
                <?php }?>
                 <td class="center">
                	<?php
					if($leave[0]["approved"]==0) echo "New";
				   	else if($leave[0]["approved"]==1) echo "Approved";
				   	else if($leave[0]["approved"]==2) echo "Rejected";
				   	else echo "Hold";						
					?>
                </td>
                	<?php
						$style ="display:none;";
						 if($type==1 || $type==2):
							$style = "";
							endif;
					 ?>
                     <?php if($type!=5 && $type!=6){?>
                <td class="center leave_type" >
                
                	<?php 	
						echo ucwords($leave[0]["type"]);
							
					?>
                </td>
                <?php }?>
              	<td class="center" >  
				<?php 
				 $from_date = strtotime($leave[0]["leave_from"]);
				$today = strtotime(date('Y-m-d'));		
				if(in_array("leave:edit_user_leaves",$user_role)){
				//if($from_date>=$today && $leave[0]["approved"]==0){
								$action_col =1;
				?>
                	  <a href="<?=$this->config->item('base_url')."attendance/leave/edit_user_leaves/".$user_id."/".$leave[0]["id"]."?page=1"?>" title="Edit" class="btn btn-info btn-rounded"><i class="icon icon-pencil"></i></a>
                      <?php }if(in_array("leave:cancel_user_leave",$user_role)){?>
                                <a href="<?=$this->config->item('base_url')."attendance/leave/cancel_user_leave/".$user_id."/".$leave[0]["id"]."?page=1"?>" title="Cancel leave" class="btn btn-danger border4">Cancel Leave</a>
                                <?php
						//}
					}?>
                </td>
                </tr>
            </tbody>
          </table>
          </div>
    </div>
   
     <div class="button_right_align">
    
                    <a href="<?=$this->config->item('base_url')?>" title="Back"><input type="button" class="btn btn-danger border4" value="Cancel" /></a>
    </div>
  
   
</div>