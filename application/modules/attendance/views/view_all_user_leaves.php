<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template');  ?>   
<script type="text/javascript" src="<?=$theme_path?>/js/employee.js"></script>
<div class="contentinner">
    <h4 class="widgettitle">View All Notifications </h4>           
    <div class="widgetcontent">
    		 <?php 
						
					//$no_of_users1[0]['count'] = 1150;
					$options = array();
					$this->load->model('options_model');
					$record = array(10,20,30,40,50,60,70,80,90,100,120,140,160,180,200);
					$closest = $this->options_model->getClosest($count[0]['count'],$record);
					//echo $closest;
					for($k=10;$k<=$closest;)
					{
						$options[$k]=$k;
						if($k<100)
							$k=$k+10;
						else
							$k = $k+20;
					}
					if($count[0]['count']>=1000)
					{
						$count_start = $count[0]['count']/100;
						if($count_start>=10)
						{
						
							for($c=4;$c<$count_start;)
							{
								$options[$c*100] = $c*100;
								$c+=2;
							}
						
						}
					
					}
					if(!in_array($show_count,$options))
					{
						$max = $this->options_model->getClosest($show_count,$options);
						if($max<$count[0]['count'])
							$show_count  = "all";
						else
							$show_count = $max;
					}
					$options["all"] = "All";
					//echo $no_of_users1[0]['count'];
					echo "Show ".form_dropdown('record_show',$options,$show_count,"id='count_change'")." entries ";
					
				?> 
    		 <div class="scroll_bar">   
    	   <table class="table table-bordered" >
        	<thead>
            	<?php 
				$user_role = json_decode($roles[0]["roles"]);
				$head = array("S.No","Name","Leave From","Leave To","Reason","Status","Approved By","Applied By","LOP","Leave Type");				
				?>                
            	<tr>
                	<?php 
					foreach($head as $ele)
					{
						echo "<th>".$ele."</th>";
					}
					    if(in_array("leave:edit_user_leaves",$user_role) || in_array("leave:cancel_user_leave",$user_role))
						{
							echo "<th>Action</th>";
						}		
					?>            	
                </tr>
            </thead>
            <tbody>
            	<?php 
					if(isset($leaves) && !empty($leaves))
					{
						$i=$start;
						foreach($leaves as $leave)
						{
							
						?>	
							<tr>
                            	<td class="center"><?=++$i?></td>
                                <td class="center"><?=$leave["taken_by_name"]?></td>
                                <?php $from_date = explode(' ',$leave["date_from1"]);
								$to_date = explode(' ',$leave["date_to1"]); 
								 ?>
                                 
                                 
                                  <td class="center">
                                <?php  
								if($leave["type"]=="permission" || $leave["type"]=="on-duty")
									echo $leave["date_from1"];
								else
									echo $from_date[0];
								?>
                                </td>
                                <td class="center"><?php 
								
								if($leave["type"]=="permission" || $leave["type"]=="on-duty")
									echo $leave["date_to1"];
								else
									echo $to_date[0];
								
								?></td>
                                
                                <td class="center"><?=$leave['reason']?></td>
                               <td class="center"><?php 
							   if($leave["approved"]==0) echo "New";
							   else if($leave["approved"]==1) echo "Approved";
							   else if($leave["approved"]==2) echo "Rejected";
							   else echo "Hold"; ?></td>
                               <td class="center"><?php  if($leave["approved"]==1) echo $leave["approved_by_name"]; else echo "-";?></td>
                                <td class="center"><?php if($leave["applied_by_name"]!="") echo $leave["applied_by_name"];else echo "-";?></td>
                                <td class="center"><?php 
									if($leave["type"]!="on-duty" && $leave["type"]!="earned leave")
									{
										$lop =FALSE;
										if($leave["lop"]==1) $lop =TRUE;
										$data = array(
												
												"disabled"=>"disabled",
												"checked" => $lop
										);
										echo form_checkbox($data);
									}
									else
										echo "NA";?>
								</td>
                                <td class="center">	<?=$leave["type"]?>								
                                </td>
                           
                              <td class="center">
                              <?php if(in_array("leave:edit_user_leaves",$user_role)){
							  
							  	$url = $this->config->item('base_url')."attendance/leave/edit_user_leaves/".$leave["ct_user_id"]."/".$leave["leave_id"]."?page=2";
								
							  ?>
                                <a href="<?=$url?>" title="Edit" class="btn btn-info btn-rounded"><i class="icon icon-pencil"></i></a>
                                <?php }
								if(in_array("leave:cancel_user_leave",$user_role)){
								
								$url = $this->config->item('base_url')."attendance/leave/cancel_user_leave/".$leave["ct_user_id"]."/".$leave["leave_id"]."?page=2";
								
								?>
                                <a href="<?=$url?>" title="Cancel leave" class="btn btn-danger border4">Cancel Leave</a>
                           		<?php }?>
                                </td>
                             
                            </tr>
                            <?php }?>
						<?php 
						
					}
					else
					{	
						
							echo "<tr><td colspan='10'>No Records Found</td></tr>";
					}	
					
				?>
                
            </tbody>
        </table>
        </div>
        <?php
		 	if(!isset($filter))
			{
				if(isset($leaves) && !empty($leaves))
				{
				$end=$start + count($leaves);
				 
					$start=$start+1;
					?>
			Showing <?=$start?> to <?=$end?> of <?=$count[0]['count']?> records
		  <?php  }
		  }
		  ?>
      <div class="button_right_align">
     
       
 <?php if(isset($links) && $links!=NULL)
            echo $links;
			?>
            </div>
            
 </div>
 </div>      	