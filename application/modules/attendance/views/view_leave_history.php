<div class="contentinner">
    <h4 class="widgettitle">User Leave History</h4>           
    <div class="widgetcontent">
    		<h4 class="emp_info">
                	<span class=""><span class="emp_title">Employee Name</span> :<?php echo $name[0]['first_name']; ?>&nbsp;<?php echo $name[0]['last_name']; ?></span>
                	<span class=""><span class="emp_title">Department</span> : <?php echo $dept[0]['dep_name']; ?></span>
                    <span class=""><span class="emp_title">Designation</span> : <?php echo $dept[0]['des_name']; ?></span>
           </h4>
            	 <?php 
		 
		 		$attributes = array('class' => 'stdform editprofileform','method'=>'post');

                echo form_open('',$attributes);?>
           <table class="table table-bordered" >
        	<thead>
            	<?php //print_r($shifts);
				$head = array("S.No","Employee Id","Name","Department","Designation","Reason","Leave Type","Changed by");
				?>
            	<tr>
                	
            	<?php 
					foreach($head as $ele)
					{
						echo "<th>".$ele."</th>";
					}
				?>
                </tr>
            </thead>
            <tbody>
            	<?php 
					if(isset($history) && !empty($history))
					{
						$i=0;
						foreach($history as $history)
						{
						if($settings[0]["value"]==0)
						{						
						if($history["leave_type"]=="earned leave")
						   continue;
						}  
						?>	
							<tr>
                            	<td class="center"><?=++$i;?></td>
                                <td class="center"><?=$history["employee_id"]?></td>
                                <td class="center"><?=ucwords($history['first_name'])?></td>
                                <td class="center"><?=ucwords($history["dept_name"])?></td>
                                <td class="center"><?=ucwords($history["des_name"])?></td>
                                <td class="center"><?=ucwords($history['history'])?></td>
                                <td class="center"><?=ucwords($history['leave_type'])?></td>
                                <td class="center"><?php 
								 		if($history['changed_by_name']=="")
								 			echo "-";
										else
											echo ucwords($history['changed_by_name']); ?></td>
                                
                            </tr>
						<?php 
						}
					
					}
					else
					{
						echo "<tr><td colspan='8'>No Records Found</td></tr>";					
					}
					if($i==0)
					{
						echo "<tr><td colspan='8'>No Records Found</td></tr>";					
					}	
				?>
                
            </tbody>
        </table>
       
      <div class="button_right_align">
     
      
        <a href="<?=$this->config->item('base_url')."attendance/leave/leave_balance_and_history/"?>"  title="Back"><input type="button" class="btn btn-info btn-rounded" value="Back" /></a>
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