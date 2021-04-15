<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template');  ?>   

 <div class="contentinner">
    <h4 class="widgettitle">Attendance Edit </h4>           
    <div class="widgetcontent">
    	<?php $result = validation_errors();
			 if(trim($result)!=""):?>
    		<div class="alert alert-error">
                	<button data-dismiss="alert" class="close" type="button">&times;</button>
                       		<?php echo validation_errors(); ?>

                </div>
           <?php endif;?>
    	 <?php 
		 	//echo "<pre>";
			//print_r($post);
			
		 	$attributes = array('class' => 'stdform editprofileform','method'=>'post');

                echo form_open('',$attributes);
				$overtimestart =0;
				$overtimeend = 0;
				if($department[0]["ot_applicable"]==1):
					if(isset($shift) && !empty($shift))
					{
						foreach($shift as $sh)
						{
							if($sh["type"]=="overtimestart")
							{
								$overtimestart = $sh["from_time"];
								$overtimeend = $sh["to_time"];
							}
						
						}	
					
					}
				endif;
				?>	
                
              <?php 
			  		$month_val = array("January","February","March","April","May","June","July","August","September","October","November","December");
			  		?>
              <table class="table table-bordered">
              <caption><b> <?php 
			  				
			  					$value =explode("-",$attendance_id);
								if(count($value)>1)
								{
									$year = $value["2"];
									$month = $value[1];
									$day = $value[0];
								}
								else
								{
									if(isset($attendance1) && !empty($attendance1))
									{
									
										$value = explode('-',$attendance1[0]['attendance_date']);
										$year = $value["2"];
										$month = $value[1];
										$day = $value[0];
									}
								
								}
							?></b></caption>
            <thead>
            <tr>
             
             	<?php //print_r($users);
				//echo  $department[0]["ot_applicable"];
				if($department[0]["ot_applicable"]==1)
				{
					$head = array("S No","Date","Day","In Time - Out Time","Break / Lunch","Over Time","Total Hours");
				}
				else
				{
					$head = array("S No","Date","Day","In Time - Out Time","Break / Lunch","Total Hours");
				
				}
				//print_r($head);
					foreach($head as $ele)
					{
						echo "<th>".$ele."</th>";
					}
				?>
           	
           
            <!--<th></th>-->
            </tr>
            </thead>
            <tbody>
           
				
            	<tr>
                <?php 
				if(isset($attendance1)&& !empty($attendance1))
				{
					$first=$attendance1[0]["attendance_date"]." ".$attendance1[0]["in"];
					$sec=$attendance1[0]["attendance_date"]." ".$attendance1[0]["out"];
					$date1 = new DateTime($first);
					$date2 = new DateTime($sec);
					$interval = dateTimeDiff($date1,$date2);
				}
				?>
                	<td class="center">1</td>
                    <td class="center"><?php 
							if($day<10)
								$day_value = "0".ltrim($day,0);
							else
								$day_value = ltrim($day,0);
							if($month<10)
								$day_value .="-0".ltrim($month,0);
							else
								$day_value .="-".$month;
							$day_value .="-".$year;
							$sun = date('l',strtotime($day_value));
						$data = array(
							'name' => 'attendance[created][]',
							'class'=>'required datepicker input-small',
							 'value' => $day_value,
							' readonly '=>'readonly'
						
						);
						echo form_input($data);
					?></td>
                    <td><?=$sun?></td>
                  	<td class="center">
                    <?php 
						$intime = '';
						if(isset($attendance1) && !empty($attendance1))
							$intime = $attendance1[0]["in"];
						$data = array(
							'name' => 'attendance[in][]',
							'class'=>'required timepicker input-small time_in',
							 'value' =>$intime
						
						);
						echo form_input($data);
					?>
                    <?php 
						$outtime = '';
						if(isset($attendance1) && !empty($attendance1))
							$outtime = $attendance1[0]["out"];
						$data = array(
							'name' => 'attendance[out][]',
							'class'=>'required timepicker input-small valid time_out',
							 'value' =>$outtime
						
						);
						echo form_input($data);
					?>
                    </td>
                   <td class="center break_td">
                   		 <?php 
							if(isset($break) && !empty($break))
							{
							
								foreach($break as $val)
								{
									$data = array(
									'name' => 'break[in_time][0][]',
									'class'=>'required timepicker input-small break in_break',
									'id' =>'break0',
									 'value' =>$val["in_time"]
								
									);
									echo form_input($data);
							
								
									$data = array(
										'name' => 'break[out_time][0][]',
										'class'=>'required timepicker input-small out_break',
										 'value' =>$val["out_time"]
									
									);
									echo form_input($data);
									echo "<br>";
								}
							}
							else
							{
								$data = array(
									'name' => 'break[in_time][0][]',
									'class'=>'required timepicker input-small break in_break',
									'id' =>'break1'
									
								
								);
								echo form_input($data);
							
							
								$data = array(
									'name' => 'break[out_time][0][]',
									'class'=>'required timepicker input-small out_break'
									
								
								);
								echo form_input($data);
							}
					?>
                    <a href="#" class="btn btn-danger add_row"><i class="icon-plus icon-black"></i></a>
                   </td>
                  
                   		<?php 
							if($department[0]["ot_applicable"]==1)
							{
							echo "<td class='center overtime'><span class='overtime_val'>";
							
								if($overtimestart!=0)
								{
									if(isset($attendance1)&& !empty($attendance1)):
										if($attendance1[0]["out"] !="00:00:00")
										{
											$over=$attendance1[0]["attendance_date"]." ".$overtimestart;
											$date3 = new DateTime($over);
											$interval1 = dateTimeDiff($date3,$date2);
											if($interval1->h<10)
												echo "0".$interval1->h .":";
											else
												echo $interval1->h .":";
											if($interval1->i<10)
												echo "0".$interval1->i;
											else
												echo $interval1->i ;
										}	
									endif;
								}
							
							echo "</span><input type='hidden' class= 'overtimestart' value='".$overtimestart."' />
							<input type='hidden' class= 'overtimeend' value='".$overtimeend."' />
							</td>";
						}
						
						
						?>
                   		
                  
                   <!--  <td class="center break_time">
                     	<span class="break_diff"></span>
                   		<input type="hidden" class="break_time_val" />
                   </td>-->
                   <td class="center total_hours">
                   <span class="total_diff"><?php 
				   			if(isset($attendance1)&& !empty($attendance1)):
								if($interval->h!=0):
									if($interval->h<10)
										echo "0".$interval->h .":";
									else
										echo $interval->h .":";
									if($interval->i<10)
										echo "0".$interval->i;
									else
										echo $interval->i ;	
								endif;
				   			endif;
				   
				   ?></span>
                   <input type="hidden" class="total" /></td>
                 <!--  <td><?php 
				   /*	$data = array(
							'name'      => 'attendance[date][]',
							'type'      => 'radio',
							'value'     => '1',
							'class'		=>'required-radio',
							'checked'	=> FALSE
							);
			   
				   echo form_checkbox();*/?></td>-->
                   <!--<td>-->
                    	<?php 
							/*$data = array("name"=>"attendance[leave][0]","value"=>"casual leave","type"	=>"radio");
							echo form_checkbox($data)." Causal leave<br>";
							$data = array("name"=>"attendance[leave][0]","value"=>"sick leave","type"	=>"radio");
							echo form_checkbox($data)." Sick leave<br>";
							$data = array("name"=>"attendance[leave][0]","value"=>"none","type"	=>"radio");
							echo form_checkbox($data)."None<br>";
							$data = array("name"=>"attendance[lop][0]","value"=>"LOP");
							echo form_checkbox($data)." LOP<br>";*/
						?>
                   <!-- </td>-->
                </tr>
               
            </tbody>
           </table>
           
     </div>
     <div class="action-btn-align">
     
    <?php
					$data = array(
					  'name'        => 'save',
					  'value'		=> 'Update',
					  'class'		=>'btn btn-primary btn-rounded submit'
					);
					
					 echo form_submit($data);?>
                    <a href="<?=$this->config->item('base_url')."attendance/view_attendance/".$user_id?>" ><input type="button" class="btn btn-info btn-rounded" value="Cancel" /></a>
    </div>
   
    </div>
    <?php 
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


?>
<script type="text/javascript">
	$(document).ready(function(){
		
		
		<?php if(isset($attendance) && !empty($attendance)){?>
			
				alert("Current Month attendance already added for this User. Go to attendance edit for modify the attendance details")
		
		<?php }?>
		
	});
</script>
<script type="text/javascript">
	function removejscssfile(filename, filetype){
 var targetelement=(filetype=="js")? "script" : (filetype=="css")? "link" : "none" //determine element type to create nodelist from
 var targetattr=(filetype=="js")? "src" : (filetype=="css")? "href" : "none" //determine corresponding attribute to test for
 var allsuspects=document.getElementsByTagName(targetelement)
 for (var i=allsuspects.length; i>=0; i--){ //search backwards within nodelist for matching elements to remove
  if (allsuspects[i] && allsuspects[i].getAttribute(targetattr)!=null && allsuspects[i].getAttribute(targetattr).indexOf(filename)!=-1)
   allsuspects[i].parentNode.removeChild(allsuspects[i]) //remove element by calling parentNode.removeChild()
 }
}

removejscssfile("<?= $theme_path; ?>/css/jquery-ui-timepicker-addon.min.css", "css") 

removejscssfile("<?= $theme_path; ?>/js/jquery-ui-timepicker-addon.min.js", "js") 

</script>
 <link rel="stylesheet" href="<?=$theme_path?>/css/jquery-ui-theme.css" type="text/css" />
  <link rel="stylesheet" href="<?=$theme_path?>/css/jquery.ui.timepicker.css" type="text/css" />
    <script type="text/ecmascript" src="<?=$theme_path?>/js/jquery.ui.timepicker.js"></script>

