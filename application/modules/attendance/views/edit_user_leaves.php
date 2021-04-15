<div class="contentinner">
    <h4 class="widgettitle">Edit Available User Leaves </h4>           
    <div class="widgetcontent">
    	   <h4 class="emp_info">
                	<span class=""><span class="emp_title">Employee Name</span> :<?php echo $name[0]['first_name']; ?>&nbsp;<?php echo $name[0]['last_name']; ?></span>
                	<span class=""><span class="emp_title">Department</span> : <?php echo $dept[0]['dep_name']; ?></span>
                    <span class=""><span class="emp_title">Designation</span> : <?php echo $dept[0]['des_name']; ?></span>
           </h4>
    			<?php $result = validation_errors();
				$my_array = array();
		     $errors = explode("</p>",$result);
			 if(isset($errors) &&	!empty($errors))
			 
			 {
			 	$my_array=array_filter(array_unique(array_map('trim',$errors)));
				
				// print_r($my_array);
			 }
			 if(trim($result)!=""):?>
    		<div class="alert alert-error">
                	<button data-dismiss="alert" class="close" type="button">&times;</button>
                       		<?php 
								//print_r(array_unique(explode("</p>",validation_errors())));
							echo implode("</p>",$my_array); ?>

             </div>
           <?php endif;?>
           
            	 <?php 
		 
		 		$attributes = array('class' => 'stdform editprofileform','method'=>'post');

                echo form_open('',$attributes);?>
				 <table class="table table-bordered" >
        	<thead>
            	<?php //print_r($shifts);
				$head = array("Leave Type","Old value","New Value","Reason");
				?>
            	<tr>
                	
            	<?php 
					foreach($head as $ele)
					{
						echo "<th class='center'>".$ele."</th>";
					}
				?>
                </tr>
            </thead>
            <tbody>
            	<tr>
                	<td class="center">
                    	<?php 
							echo form_label('Causal Leave')
						
						?>
                    </td>
                	<td class="center">
                    	<?php 
							$data = array(
							'class' =>'input-small',
							'value' =>$leave[0]['available_casual_leave'],
							'readonly' =>'readonly'
							
					);
					echo form_input($data);
						
						?>
                    </td>
                    <td class="center">
                    	<?php 
							$default = '';
							if(isset($_POST['save']))
							{
								$default = $input['available_casual_leave'];
							
							}
							$data = array(
							'name' =>'leave[available_casual_leave]',
							'class' =>'required input-small',
							'value' =>$default,
							
					);
					echo form_input($data);
						
						?>
                    </td>
                    <td class="center">
                    	<?php 
							$default = '';
							if(isset($_POST['save']))
							{
								$default = $input['reason'][0];
							
							}
							$data = array(
							'name' =>'leave[reason][0]',
							'class' =>'required',
							'value' =>$default
							
					);
					echo form_input($data);
						
						?>
                    </td>
                </tr>
                <tr>
                	<td class="center">
                    	<?php 
						echo form_label('Sick Leave')
						
						?>
                    </td>
                	<td class="center">
                    	<?php 
							$data = array(
							'class' =>'input-small',
							'value' =>$leave[0]['available_sick_leave'],
							'readonly' =>'readonly'
							
					);
					echo form_input($data);
						
						?>
                    </td>
                    <td class="center">
                    	<?php 
							$default = '';
							if(isset($_POST['save']))
							{
								$default = $input['available_sick_leave'];
							
							}
							$data = array(
							'name' =>'leave[available_sick_leave]',
							'class' =>'required input-small',
							'value' =>$default,
							
					);
					echo form_input($data);
						
						?>
                    </td>
                    <td class="center">
                    	<?php 
							$default = '';
							if(isset($_POST['save']))
							{
								$default = $input['reason'][1];
							
							}
							$data = array(
							'name' =>'leave[reason][1]',
							'class' =>'required input',
							'value' =>$default,
							
					);
					echo form_input($data);
						
						?>
                    </td>
                </tr>
                <?php if($settings[0]["value"]==1) { ?>
                <tr>
                	<td class="center">
                    	<?php 
							echo form_label('Earned Leave')
						
						?>
                    </td>
                	<td class="center">
                    	<?php 
							$data = array(
							'class' =>'input-small',
							'value' =>$leave[0]['available_earned_leave'],
							'readonly' =>'readonly'
							
					);
					echo form_input($data);
						
						?>
                    </td>
                    <td class="center">
                    	<?php 
							$default = '';
							if(isset($_POST['save']))
							{
								$default = $input['available_earned_leave'];
							
							}
							$data = array(
							'name' =>'leave[available_earned_leave]',
							'class' =>'required input-small',
							'value' =>$default,
							
					);
					echo form_input($data);
						
						?>
                    </td>
                    <td class="center">
                    	<?php 
							$default = '';
							if(isset($_POST['save']))
							{
								$default = $input['reason'][2];
							
							}
							$data = array(
							'name' =>'leave[reason][2]',
							'class' =>'required',
							'value' =>$default
							
					);
					echo form_input($data);
						
						?>
                    </td>
                </tr>
                <?php } ?>
                <tr>
                	<td class="center">
                    	<?php 
							echo form_label('Comp Off')
						
						?>
                    </td>
                	<td class="center">
                    	<?php 
							$data = array(
							'class' =>'input-small',
							'value' =>$leave[0]['comp_off'],
							'readonly' =>'readonly'
							
					);
					echo form_input($data);
						
						?>
                    </td>
                    <td class="center">
                    	<?php 
							$default = '';
							if(isset($_POST['save']))
							{
								$default = $input['comp_off'];
							
							}
							$data = array(
							'name' =>'leave[comp_off]',
							'class' =>'required input-small',
							'value' =>$default
							
					);
					echo form_input($data);
						
						?>
                    </td>
                    <td class="center">
                    	<?php 
							$default = '';
							if(isset($_POST['save']))
							{
								$default = $input['reason'][3];
							
							}
							$data = array(
							'name' =>'leave[reason][3]',
							'class' =>'required input',
							'value' =>$default
							
					);
					echo form_input($data);
						
						?>
                    </td>
                </tr>
                
                <tr>
                	<td class="center">
                    	<?php 
							echo form_label('Permission')
						
						?>
                    </td>
                	<td class="center">
                    	<?php 
							$data = array(
							'class' =>'input-small',
							'value' =>$leave[0]['permission'],
							'readonly' =>'readonly'
							
					);
					echo form_input($data);
						
						?>
                    </td>
                    <td class="center">
                    	<?php 
							$default = '';
							if(isset($_POST['save']))
							{
								$default = $input['permission'];
							
							}
							$data = array(
							'name' =>'leave[permission]',
							'class' =>'required input-small',
							'value' =>$default
							
					);
					echo form_input($data);
						
						?>
                    </td>
                    <td class="center">
                    	<?php 
							$default = '';
							if(isset($_POST['save']))
							{
								$default = $input['reason'][4];
							
							}
							$data = array(
							'name' =>'leave[reason][4]',
							'class' =>'required input',
							'value' =>$default,
							
					);
					echo form_input($data);
						
						?>
                    </td>
                </tr>
            </tbody>
        </table>
         <div class="button_right_align">
     	<?php 
         	$data = array(
					  'name'        => 'save',
					  'value'		=> 'Save',
					  'class'		=>'btn btn-success border4 submit',
					  'title'		=>'Save',
					  'disabled'	=>'disabled'
					);
					
					 echo form_submit($data);?>
                    <a href="<?=$this->config->item('base_url')."attendance/leave/leave_balance_and_history/"?>"  title="Cancel"><input type="button" class="btn btn-danger border4" value="Cancel" /></a>
      		
        </div>
    </div>
   
</div>
<script type="text/javascript">
	
	$(document).ready(function(){
	
		$(".required").blur(function()
		{
			var res = 0;
			$(".required").each(function(){
			
				if($.trim($(this).val())!="")
					res = 1;
				
			});
			if(res==1)
				$(".submit").removeAttr("disabled");
			else
				$(".submit").attr("disabled","disabled");
		});
		$(".required").keydown(function(){
		
				$(".submit").removeAttr("disabled");
			
		});
	});
	
</script>