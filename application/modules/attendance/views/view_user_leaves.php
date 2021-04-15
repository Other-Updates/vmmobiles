<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template');  ?>   
<script type="text/javascript" src="<?=$theme_path?>/js/attendance.js"></script>
<div class="contentinner">
    <h4 class="widgettitle">User Leaves </h4>           
    <div class="widgetcontent">
    		<h4 class="emp_info">
                	<span class=""><span class="emp_title">Employee Name</span> :<?php echo $name[0]['first_name']; ?>&nbsp;<?php echo $name[0]['last_name']; ?></span>
                	<span class=""><span class="emp_title">Department</span> : <?php echo $dept[0]['dep_name']; ?></span>
                    <span class=""><span class="emp_title">Designation</span> : <?php echo $dept[0]['des_name']; ?></span>
           </h4>
    		<div class="well well-small">
            	
    		<?php 
			$user_role = json_decode($roles[0]["roles"]);
			$result = validation_errors();
			 if(trim($result)!=""):?>
    		<div class="alert alert-error">
                	<button data-dismiss="alert" class="close" type="button">&times;</button>
                       		<?php echo implode("</p>",array_unique(explode("</p>", validation_errors()))); ?>

             </div>
           <?php endif; ?>
           <?php $attributes = array('class' => 'stdform editprofileform','method'=>'post');
				
                echo form_open('',$attributes);?>
           <table class="table alert alert-success">
           	<thead>
            	<tr>
                	<th>Available Casual Leave : <?php  if(isset($available[0]['available_casual_leave'])):
													if($available[0]['available_casual_leave']<0) echo 0;
													else 
														echo $available[0]['available_casual_leave'];
													endif;?></th>
                   <th>Available Sick Leave : <?php if(isset($available[0]['available_sick_leave'])):
				   									if($available[0]['available_sick_leave']<0) echo 0;
				   									else echo $available[0]['available_sick_leave'];
													endif;?></th>
                    <th>Available Comp Off : <?php echo isset($available[0]['comp_off'])&& $available[0]['comp_off']!=""?$available[0]['comp_off']:0; ?></th>
                     <th>Available Permission(in Hours) : <?php if($available[0]['permission']<0) echo 0;
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
          
           </div>
           <table width="100%" border="0">
                	
                <tbody><tr>
                  
                  <td>	<?php echo form_label('Select Year');?></td>
                  <td>
                  <p>
                        
                            <span class="field">
                         
                            <?php 
								$joined_date = explode("-",$doj[0]["date"]);
								$options=array(''=>'Select Year');
									$i = $joined_date[0];
								if($month==1)
								{
									if($joined_date[2]<$month_starting_date)
										$i = $joined_date[0]-1;	
								}
								for(;$i<=date('Y');$i++)
								{
									$options[$i] = $i;
								
								}
							
									$default = $year;
								
								echo form_dropdown('year',$options,$default,'id="year_select"');
							?>
                            
                          
                            </span>
                        </p>
                  </td>
                  <td>
                
                        <?php echo form_label('Select Month');?></td>
                        <td>
                         <p> 
                            <span class="field">
                           <?php 
								//echo date('m');
							$month_arr = array("Jan","Feb","Mar","Apr","May","June","July","Aug","Sep","Oct","Nov","Dec");
							$options=array(''=>'Select Month');
								
								
									$default = $month;
									
									if($year == $joined_date[0] && $year== date('Y'))
									{
										if($joined_date[2]<$month_starting_date)
											$i=$joined_date[1]-2;
										else
											$i=$joined_date[1]-1;
										if($i<0)
											$i=0;
											
										for(;$i<date('m');$i++)
										{
											$options[$i+1] = $month_arr[$i];
										
										}
									
									}
									else if($year == $joined_date[0])
									{
										if($joined_date[2]<$month_starting_date)
											 $i=$joined_date[1]-2;
										else
											$i=$joined_date[1]-1;
										if($i<0)
											$i=0;
										for(;$i<12;$i++)
										{
											$options[$i+1] = $month_arr[$i];
										
										}
									}
									else if($year == date('Y'))
									{
										
										for($i=0;$i<date('m');$i++)
										{
											$options[$i+1] = $month_arr[$i];
										
										}
									}
									else
									{
										for($i=0;$i<12;$i++)
										{
											$options[$i+1] = $month_arr[$i];
										
										}
									
									}
								$default = $month;
								
								//print_r($default);
								//$options[$default] = $month_arr[$default-1];
								echo form_dropdown('month',$options,$default,'id="month_select"');
							?>
                            
                            </span>
                        </p>
                  </td>
                  <td width="3%">&nbsp;</td>
                  <input type="hidden" name="start_date" id="start_date" value="<?=$start_date?>">
                  <input type="hidden" name="end_date" id="end_date" value="<?=$end_date?>">
                  <input type="hidden" name="month_start_date" id="month_start_date" value="<?=$month_start_date?>">
                  <input type="hidden" name="month_end_date" id="month_end_date" value="<?=$month_end_date?>">
                   <input type="hidden"  id="month_starting_date" value="<?=$month_starting_date?>">
                  <input type="hidden" id="week_starting_day" value="<?=$week_starting_day?>">
                  <input type="hidden" id="doj" value="<?=$doj[0]["date"]?>">
                  <td><input type="submit" name="go" value="Go" id="go" class="btn btn-info border4"></td>
                </tr>
              </tbody></table>	
           <div class="scroll_bar">   
    	   <table class="table table-bordered" >
        	<thead>
            	<?php //print_r($shifts);
				$head = array("S.No","Leave From","Leave To","Reason","Status","Status Changed By","Applied By","LOP","Leave type");
				
				?>
                <?php 
					foreach($head as $ele)
					{
						echo "<th>".$ele."</th>";
					}
					if($status[0]['status']==1 && !isset($_GET['us']))
					{
						echo "<th>Action</th>";
					
					}
				?>
            	<tr>
                	
            	
                </tr>
            </thead>
            <tbody>
            	<?php 
					if(isset($leaves) && !empty($leaves))
					{
						$i=0;
						//$this->pre_print->viewExit($leaves);
						foreach($leaves as $leave)
						{
						?>	
							<tr>
                            	<td class="center"><?=++$i?></td>
                               
                                <?php $from_date = explode(' ',$leave["date_from"]);
								$to_date = explode(' ',$leave["date_to"]); 
								 ?>
                                 <?php //if($from_date[1]!="00:00:00" && $to_date[1]!="00:00:00"){?>
                                 
                                  <td class="center">
                                <?php  
								if($leave["type"]=="permission" || $leave["type"]=="on-duty")
									echo $leave["date_from"];
								else
									echo $from_date[0];
								?>
                                </td>
                                <td class="center"><?php 
								
								if($leave["type"]=="permission" || $leave["type"]=="on-duty")
									echo $leave["date_to"];
								else
									echo $to_date[0];
								
								?></td>
                                <?php //}else{?>
                                
                                <td class="center"><?=$leave['reason']?></td>
                               <td class="center"><?php 
							   if($leave["approved"]==0) echo "New";
							   else if($leave["approved"]==1) echo "Approved";
							   else if($leave["approved"]==2) echo "Rejected";
							   else echo "Hold"; ?></td>
                               <td class="center"><?php  if($leave["approved_by_name"]!="") echo $leave["approved_by_name"]; else echo "-"?></td>
                                <td class="center"><?php if($leave["applied_by_name"]!="") echo $leave["applied_by_name"];else echo "-";?></td>
                                <td class="center"><?php 
								
									if($leave["type"]!="on-duty" && $leave["type"]!="earned leave"):
									$lop =FALSE;
									if($leave["lop"]==1) $lop =TRUE;
									$data = array(
											
											"disabled"=>"disabled",
											"checked" => $lop
									);
									echo form_checkbox($data);
									else:
										echo "NA";
									endif;
									?>
								</td>
                                <td class="center">	<?=$leave["type"]?>								
                                </td>
                            <?php 
							    if($status[0]['status']==1 && !isset($_GET['us']))
								{?>
                              <td class="center">
                              <?php if(in_array("leave:edit_user_leaves",$user_role)){
							  
							  	$url = $this->config->item('base_url')."attendance/leave/edit_user_leaves/".$user_id."/".$leave["id"];
								if(isset($_GET["page"]))
								{
								$url = $this->config->item('base_url')."attendance/leave/edit_user_leaves/".$user_id."/".$leave["id"]."?page=2";;
								}
							  ?>
                                <a href="<?=$url?>" title="Edit" class="btn btn-info btn-rounded"><i class="icon icon-pencil"></i></a>
                                <?php }
								if(in_array("leave:cancel_user_leave",$user_role)){
								
								$url = $this->config->item('base_url')."attendance/leave/cancel_user_leave/".$user_id."/".$leave["id"];
								if(isset($_GET["page"]))
								{
									$url = $this->config->item('base_url')."attendance/leave/cancel_user_leave/".$user_id."/".$leave["id"]."?page=2";;
								}
								?>
                                <a href="<?=$url?>" title="Cancel leave" class="btn btn-danger btn-rounded">Cancel Leave</a>
                           		<?php }?>
                                </td>
                             <?php }?>
                            </tr>
						<?php 
						}
					
					}
					else
					{	
						 if($status[0]['status']==1)
							echo "<tr><td colspan='10'>No Records Found</td></tr>";
						else
							echo "<tr><td colspan='9'>No Records Found</td></tr>";
					}	
				?>
                
            </tbody>
        </table>
        </div>
         <?php
		 	if(!isset($filter))
			{
				if(isset($users) && !empty($users))
				{
				$end=$start + count($users);
				 if($start==0)
					$start=1;
					?>
			Showing <?=$start?> to <?=$end?> of <?=$no_of_users[0]['count']?> records
		  <?php  }
		  }
		  ?>
      <div class="button_right_align">
     
       
 <?php if(isset($links) && $links!=NULL)
            echo $links;
			
			$url = $this->config->item('base_url')."attendance/leave/apply_or_modify_leaves/";
			if(isset($_GET["page"]))
			{
				$url = $this->config->item('base_url')."attendance/leave/view_all_user_leaves/";
			}

			?><br />
             <a href="<?=$url?>" title="Back"><input type="button" class="btn btn-defaultback border4" value="Back" /></a> 
        </div>
     
    </div>
   
</div>
<script type="text/javascript">
	$(document).ready(function(){
		
			$(".multiselect").multiselect({
				includeSelectAllOption: true,
				 enableFiltering: true
			});
	
	
	});
</script>