<style type="text/css">
.table {
  table-layout: fixed; 
  width: 100%;
  *margin-left: -100px;/*ie7*/
}
.table td, .table th {
  vertical-align: top;
  border-top: 1px solid #ddd;
  width:100px;
}
.table th {
  position:absolute;
  *position: relative; /*ie7*/
  left:0; 
  width:100px;
}
.outer {position:relative; float:left; width:100%;}
.inner {
  overflow-x:scroll;
  overflow-y:visible;
  /*width:91.5%; */
  margin-left:111px;
}
</style>
<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template');  ?>   
<script type="text/javascript" src="<?=$theme_path?>/js/attendance_reports.js"></script>
<script type="text/javascript" src="<?=$theme_path?>/js/time_reports.js"></script>
<link href="<?=$theme_path?>/css/print_page.css" rel="stylesheet" >
<div class="contentinner">
			<?php
			$filter = $this->session_view->get_session(null,null);
		 	$attributes = array('class' => 'stdform editprofileform','method'=>'post');

                echo form_open('',$attributes);?>
            	<h4 class="widgettitle">Time Reports</h4>
        <?php 
		$filter = $this->session_view->get_session('reports','time_reports');
		//print_r($filter);
		$filter_start = date("Y-m-d",strtotime($filter["start_date"]));
		$filter_end = date("Y-m-d",strtotime($filter["end_date"]));
		//echo $filter_end;
		if(isset($saturday_holiday) && $saturday_holiday==0)
			$week_days = 6;
		else
			$week_days = 5;
		$this->load->model("attendance_model");
		$month_start = new DateTime(date('d-m-Y',strtotime($filter_start))." 00:00:00");
		
		$month_end = new DateTime(date('d-m-Y',strtotime($filter_end))." 00:00:00");
		//$s_date = date('d-m-Y',strtotime($filter_start));
		$s_date = date('d-m-Y',strtotime($filter_start));
		$std_dt = $filter_end." 00:00:00";		
		$exclude_date = new DateTime($std_dt.' +1 day');
		//$e_date = $exclude_date->format('d-m-Y');
		
		$e_date = date('d-m-Y',strtotime($filter_end));
		$start = new DateTime($s_date.' 00:00:00');		
		//Create a DateTime representation of the last day of the current month based off of "now"
		//$end = new DateTime( $e_date.' 00:00:00');
		
		$attd_end_date = $exclude_date->format( 'd-m-Y' );
		$date = new DateTime(date( 'd-m-Y' )." 00:00:00".' +1 day');;
		$cur_date = date('d-m-Y',(strtotime($date->format('d-m-Y'))));		
		if(strtotime($cur_date)<=strtotime($attd_end_date))
		{			
		$end = new DateTime( $cur_date.' 00:00:00');
		}
		
		//Define our interval (1 Day)
		$interval = new DateInterval('P1D');
		//Setup a DatePeriod instance to iterate between the start and end date by the interval
		//$period = new DatePeriod( $filter["start_date"], $interval, $filter["end_date"] );
		
		$period = new DatePeriod( $start, $interval, $exclude_date );		
		//Iterate over the DatePeriod instance
		$sunday = array();
		//print_r($period);
		foreach( $period as $date ){
			//Make sure the day displayed is ONLY sunday.
			//print_r($date);
			$days_array[] = $date->format( 'd-m-Y' );
		}
		$proceed = 0;	
		//Define our interval (1 Day)
		$interval = new DateInterval('P1D');
		//Setup a DatePeriod instance to iterate between the start and end date by the interval
		$period = new DatePeriod( $month_start, $interval, $month_end );
		//Iterate over the DatePeriod instance
		$sunday = array();
		foreach( $period as $date ){
			//Make sure the day displayed is ONLY sunday.
			if( $date->format('w') == 0 ){
				$sunday[] =$date->format( 'd-m-Y' ).PHP_EOL;
			}
			//Checking saturday is a  Saturday holiday 
			if(isset($saturday_holiday) && $saturday_holiday==1)
			{
				if( $date->format('w') == 6 ){
					$sunday[] =$date->format( 'd-m-Y' ).PHP_EOL;
				}
			}
		}
		//print_r($days_array);			
	?>
    			<div class="time_report_note alert alert-info">Note: Click an entry to view the Split ups</div>
          
                <div class="button_left_align">&nbsp;&nbsp; NA - Not Applicable, &nbsp; P - Permission, &nbsp; SL - Sick Leave, &nbsp; CL - Casual Leave, &nbsp; EL - Earned Leave, &nbsp; LOP - Loss of Pay, &nbsp; OD - On-duty, &nbsp; C- Compoff, &nbsp; PH - Public Holiday, &nbsp; I - Inactive Status
                </div>
                <div class="button_left_align">
                    <caption class="no-display">&nbsp;&nbsp;
                       <span class="btn-rounded holiday_time_class">&nbsp;&nbsp;&nbsp;&nbsp;</span> - Compoff&nbsp;&nbsp;&nbsp;&nbsp;
                       <span class="btn-rounded permission_time_class">&nbsp;&nbsp;&nbsp;&nbsp;</span> - Permission / On-duty&nbsp;&nbsp;&nbsp;&nbsp;                                
                    </caption>
                </div>
<div class="outer">
  <div class="inner">
                
                <table class="table table-bordered time_table"  style="font-size:10px;">
                    <thead>
                        <tr>
                            <!--<th rowspan="3"><div id="rotate_holiday">S.No</div></th>-->
                        	<th style="height:40px; border-top: 1px solid #ddd;"><div style="position:relative; top:20px;">Name of the<br /></div></th>
                            <?php  		
							//print_r($days_array);	
							$row_count = 0;				
							for($d=0;$d<=count($days_array)-1;$d++){?>
                            	<td colspan="2" class="row_width" style="background:#fcfcfc; text-align:center; width:100%;"><?php $current_day = explode("-",$days_array[$d]);									
									$time = mktime(0, 0, 0, $current_day[1]);
                                    $name = strftime("%b", $time);
									echo date('l',strtotime($days_array[$d]))."<br />";								    
									echo $name." ".$current_day[0];
									$row_count++;
								?></td>
                           <?php }?>                             
                        </tr>
                        
                       <tr style="background:#fcfcfc; text-align:center"><th style="text-align:center; border-top:0"><div style="position:relative; top:-10px;">Worker</div></th><?php for($d=0;$d<=count($days_array)-1;$d++){?><td style="text-align:center">In</td><td style="text-align:center">Out</td><?php } ?></tr>     
                            </thead>
                            <tbody>
                            <?php
								//print_r($attendance);								
								$s = $start_page+1;
								if(isset($attendance)&& !empty($attendance))
								$result = array_filter($attendance);
						        //if(isset($result)&& !empty($result)){
							$this->load->model('masters/shift_model');
							$this->load->model('masters/user_shift_model');
							$this->load->model('masters/salary_group_model');
							if(isset($filter["user_id"]) && !empty($filter["user_id"])):
								
								for($k=0;$k<count($filter["user_id"]);$k++){
								$no_of_ot_hours = 0;
								$comp_off_ot_hours = 0;
								$user_overtime = 0;
								$att = array(0);
								$da = 0;
								$total_all = 0;
								$total_dedu = 0;
								$user_salary = array();
								
								$this->load->model('masters/users_model');
						        $user_name = $this->users_model->get_user_name_by_user_id($filter['user_id'][$k]);							
						        //echo $user_name[0]['first_name']." ".$user_name[0]['last_name'];	
								if(isset($attendance[$k]) && !empty($attendance[$k]))
								{
									//$this->pre_print->view($attendance[$k]);
									foreach($attendance[$k] as $am)
									{
										if($am["in"]!="00:00:00")
										$att[$am["attendance_date"]] = $am;						
									
									}
								}								
								$leave_arr = array();
				
								if(isset($leave[$k]) && !empty($leave[$k]))
								{
									foreach($leave[$k] as $lval)
									{
										//$this->pre_print->view($lval);	
								$current_shift_id = $this->user_shift_model->get_user_current_shift_by_user_id($filter['user_id'][$k],$lval["l_from"]);												
								$current_shift = $this->shift_model->get_shift_regular_time_by_shift_id($current_shift_id[0]["shift_id"]);
										$start_hour = strtotime($current_shift[0]["from_time"]);
										$end_hour = strtotime($current_shift[0]["to_time"]);
										
										if($lval["l_from"] == $lval["l_to"])
										{
											if($start_hour>=$end_hour)
											{
												
												$sdt = date("H:i",strtotime($lval["leave_from"]));
												$edt = date("H:i",strtotime($lval["leave_to"]));
												
												if(strtotime("00:00")<strtotime($sdt) && (strtotime($edt)<$end_hour))
												{
													$previous =  date('Y-m-d', strtotime($lval["l_from"] .' -1 day'));
													$leave_arr[date('d-m-Y',strtotime($previous))] = $lval;
												}
												else
													$leave_arr[$lval["l_from"]] = $lval;
											}
											else
												$leave_arr[$lval["l_from"]] = $lval;
										}
										else if($lval["type"]=="permission")
										{
											//$leave_arr[$lval["l_from"]] = $lval;
											if($start_hour>=$end_hour)
											{
												
												$sdt = date("H:i",strtotime($lval["leave_from"]));
												$edt = date("H:i",strtotime($lval["leave_to"]));
												
												if(strtotime("00:00")<strtotime($sdt) && (strtotime($edt)<$end_hour))
												{
													$previous =  date('Y-m-d', strtotime($lval["l_from"] .' -1 day'));												
													$leave_arr[date('d-m-Y',strtotime($previous))] = $lval;
												}
												else
													$leave_arr[$lval["l_from"]] = $lval;
											}
											else
												$leave_arr[$lval["l_from"]] = $lval;
										}
										else
										{
											
											$start = $lval["l_from"];
											$std_dt = date('Y-m-d',strtotime($lval["l_to"]));
											$end_current = new DateTime($lval["l_to"].' 00:00:00');
											$exclude_date = new DateTime($std_dt.' +1 day');
											$end = $exclude_date->format('d-m-Y');
											$start = new DateTime($start.' 00:00:00');
											//Create a DateTime representation of the last day of the current month based off of "now"
											$end = new DateTime( $end.' 00:00:00');
											$interval_od = dateTimeDiff($start,$end_current);
											if($lval["type"]=="on-duty")
											{
												
												if($start_hour>=$end_hour)
												{
													//Define our interval (1 Day)
													
													$interval = new DateInterval('P1D');
													//Setup a DatePeriod instance to iterate between the start and end date by the interval
													$period = new DatePeriod( $start, $interval, $end_current );
													
													//Iterate over the DatePeriod instance
													$lval["shift"]="night";
													$sunday = array();
													foreach( $period as $date ){
														//Make sure the day displayed is ONLY sunday.
														
														$leave_arr[$date->format( 'd-m-Y' )] =$lval;
													}
												}
												else
												{
													
													$interval = new DateInterval('P1D');
													//Setup a DatePeriod instance to iterate between the start and end date by the interval
													$period = new DatePeriod( $start, $interval, $end );
													$lval["shift"]="day";
													//Iterate over the DatePeriod instance
													$sunday = array();
													foreach( $period as $date ){
														//Make sure the day displayed is ONLY sunday.
														
														$leave_arr[$date->format( 'd-m-Y' )] =$lval;
													}
												
												}
												
											}
											else
											{
												//Define our interval (1 Day)
												$interval = new DateInterval('P1D');
												//Setup a DatePeriod instance to iterate between the start and end date by the interval
												$period = new DatePeriod( $start, $interval, $end );
												
												//Iterate over the DatePeriod instance
												$sunday = array();
												foreach( $period as $date ){
													//Make sure the day displayed is ONLY sunday.
													
													$leave_arr[$date->format( 'd-m-Y' )] =$lval;
												}
											}
										}
									}
								}
								$holi_arr = array();
								if(isset($holiday[$k]) && !empty($holiday[$k]))
								{
									foreach($holiday[$k] as $hval)
									{
										if($hval["holiday_from"] == $hval["holiday_to"])
										{
											//$holi_arr[$hval["h_from"]] = $hval;
											$hol_val = date('l',strtotime($hval["holiday_from"]));										
											if($hol_val == "Sunday" || $hol_val == "Saturday")
											{										
											   if(isset($saturday_holiday) && $saturday_holiday!=1)			
											      $holi_arr[$hval["h_from"]] = $hval;
											}
											else
											   $holi_arr[$hval["h_from"]] = $hval;
										}
										else
										{
											$start = $hval["h_from"];
											$std_dt = date('Y-m-d',strtotime($hval["h_to"]));
											$exclude_date = new DateTime($std_dt.' +1 day');
											$end = $exclude_date->format('d-m-Y');
											$start = new DateTime($std_dt.' 00:00:00');
											//Create a DateTime representation of the last day of the current month based off of "now"
											$end = new DateTime( $end.' 00:00:00');
											//Define our interval (1 Day)
											$interval = new DateInterval('P1D');
											//Setup a DatePeriod instance to iterate between the start and end date by the interval
											$period = new DatePeriod( $start, $interval, $end );
											
											//Iterate over the DatePeriod instance
											$sunday = array();
											foreach( $period as $date ){
												$hol_val = date('l',strtotime($date->format( 'd-m-Y' )));																				
												if($hol_val == "Sunday" || $hol_val == "Saturday")
												{										
												if(isset($saturday_holiday) && $saturday_holiday!=1)			
												   $holi_arr[$hval["h_from"]] = $hval;
												}
												else
												   $holi_arr[$hval["h_from"]] = $hval;
												//Make sure the day displayed is ONLY sunday.
												$holi_arr[$date->format( 'd-m-Y' )] =$hval;
											}
										}
									}
								}
								//if($filter['user_id'][$k]==5)
								
								//$this->pre_print->view($leave_arr);	
							
							$lop_days = 0;
							$comp_off_days = 0;
							$days_with_salary = 0;
							$total_ot_earned = 0;
							$total_compoff_ot_earned = 0;
							$earned = 0 ;
							$ot_all = 0;
							
							?>
                          
                            <tr>                           
                            <th style="border-bottom:1px solid #ddd;"><?=$user_name[0]['first_name']." ".$user_name[0]['last_name']?></th>
                            <?php
							$this->load->model('attendance/attendance_model');										
							?>
                            <?php  
							for($n=0;$n<=count($days_array)-1;$n++){
								$current_day = explode("-",$days_array[$n]);									
								$working_days = count($days_array)-(count($sunday)+count($holi_arr));									
								$day_value = $days_array[$n];
								$current = $current_day[0];							
								//echo $day_value;
								if(isset($history[$k][0]["date"]) && strtotime($day_value)>strtotime($history[$k][0]["date"]))
									echo "<td class='center' colspan='2'>I</td>";								
								else
								{
								$start_time = 0;
								$regular_time = 0;
								$regular_time_val = 0;
								$breaktimediff=0;
								$date_end =0;
								$end_time = 0;
								$leave_taken = 0;
								$half_regular = 0 ;
								$current_shift_id = $this->user_shift_model->get_user_current_shift_by_user_id($filter["user_id"][$k],$day_value);								
								$shift = $this->shift_model->get_shift_details_by_shift_id($current_shift_id[0]["shift_id"]);
								$salary = $this->user_salary_model->get_user_salary_by_user_id($filter["user_id"][$k],$day_value);
								if(isset($shift) && !empty($shift))
								{
									foreach($shift as $sh)
									{
										if($sh["type"]=="overtimestart")
										{
											
											$overtimestart = $sh["from_time"];
											$overtimeend = $sh["to_time"];
										}
										else
										{
											if($sh["type"]=="regular")
											{
												$reg_st = explode(':',$sh["from_time"]);
												$reg_et = explode(':',$sh["to_time"]);
												if($reg_st[0]>$reg_et[0])
												{
													$next_day = new DateTime(date('d-m-Y H:i:s').' + 1 day');
													$date_start = new DateTime(date('d-m-Y')." ".$sh["from_time"]);
													$date_end = new DateTime($next_day->format('d-m-Y')." ".$sh["to_time"]);
												}
												else
												{
													$date_start = new DateTime(date('d-m-Y')." ".$sh["from_time"]);
													$date_end = new DateTime(date('d-m-Y')." ".$sh["to_time"]);
												}
												
												$start_time = $sh["from_time"];
												$end_time = $sh["to_time"];												
												$regular_time = dateTimeDiff($date_start,$date_end);
											}
											else
											{
												$reg_st = explode(':',$sh["from_time"]);
												$reg_et = explode(':',$sh["to_time"]);
												if($reg_st[0]>$reg_et[0])
												{
													$next_day = new DateTime(date('d-m-Y H:i:s').' + 1 day');
													$break_st = new DateTime(date('d-m-Y')." ".$sh["from_time"]);
													$break_end = new DateTime($next_day->format('d-m-Y')." ".$sh["to_time"]);
												}
												else
												{
													$break_st = new DateTime(date('d-m-Y')." ".$sh["from_time"]);
													$break_end = new DateTime(date('d-m-Y')." ".$sh["to_time"]);
												}
												
												$inter = dateTimeDiff($break_st,$break_end);
												if($inter->h>0)
												{
													$breaktimediff = $breaktimediff + ($inter->h)*60;
												}
												if($inter->i>0)
												{
													$breaktimediff = $breaktimediff + ($inter->i);
												}
												if($inter->s>0)
												{
													$breaktimediff = $breaktimediff + ($inter->s/60);
												}
											}
										}
									}
									$regular_time_val = $regular_time->h*60 + $regular_time->i - $breaktimediff - $threshold[0]['value'];
									$half_regular = $regular_time_val/2;
									$res = explode(':',$start_time);
									$shift_start_time = $res[0]*60+$res[1]+$threshold[0]['value'];
									if(isset($res[2]) && $res[2]>0)
										$shift_start_time = $shift_start_time + ($res[2]/60);
							
									$yes = 0;
									$total_break = 0;
									$time_taken = 0;
									$break = array();
									$difference ="";
									$permission_hrs = 0;
									$half_day = 0;
									
								
									$sun = date('l',strtotime($day_value));
									//echo $sun;
									if(isset($att[$current])&& !empty($att[$current]))
									{
										$user_in = explode(':',$att[$current]['in']);// user in time
										$shift_start = explode(':',$start_time);// shift start time
										$calc = explode(':',$att[$current]['out']);// user out time
										$end = explode(':',$end_time);// shift end time
										
										$start_shift =( $shift_start[0]-1).":".$shift_start[1];
										$user_in_start = $user_in[0].":".$user_in[1];
										$end_shift = ($end[0]+1).":".$end[1];
										$check1 = DateTime::createFromFormat('H:i', $user_in_start);
										$check2 = DateTime::createFromFormat('H:i', $start_shift);
										
										if($shift_start[0]>$end[0])
										{
											$next_day = new DateTime(date('d-m-Y H:i:s').' + 1 day');
											$check3 = new DateTime($next_day->format('d-m-Y')." ".$end_shift);
										}
										else
										{
											$check3 = DateTime::createFromFormat('H:i', $end_shift);
										}
										if (!($check1 > $check2 && $check1 < $check3))
										{
										  unset($att[$current]);
										}										
										
									
									}
									if(isset($att[$day_value])&& !empty($att[$day_value]))
									{	
										$user_in = explode(':',$att[$day_value]['in']);// user in time
										$shift_start = explode(':',$start_time);// shift start time
										$calc = explode(':',$att[$day_value]['out']);// user out time
										$end = explode(':',$end_time);// shift end time										
										$in_start = new DateTime(date('Y-m-d').$att[$day_value]['in']);
										
										if($calc[0]<$end[0])
										{
											if($user_in[0]>$calc[0])
											{	
												$next_day = new DateTime(date('d-m-Y H:i:s').' + 1 day');
												$in_end = new DateTime($next_day->format('d-m-Y')." ".$att[$day_value]['out']);
											}
											else
											{
												$in_end = new DateTime(date('Y-m-d').$att[$day_value]['out']);
											}
										}
										elseif($calc[0]>$end[0])
										{											
											if($user_in[0]>$calc[0])
											{	
												$next_day = new DateTime(date('d-m-Y H:i:s').' + 1 day');
												$in_end = new DateTime($next_day->format('d-m-Y')." ".$end_time);
											}
											else
											{
												$in_end = new DateTime(date('Y-m-d').$end_time);
											}
											
											
										}
										elseif($calc[0]==$end[0] && $calc[1]>$end[1])
										{
											if($user_in[0]>$calc[0])
											{	
												$next_day = new DateTime(date('d-m-Y H:i:s').' + 1 day');
												$in_end = new DateTime($next_day->format('d-m-Y')." ".$end_time);
											}
											else
											{
												$in_end = new DateTime(date('Y-m-d').$end_time);
											}
										
										}
										else
										{
											if($user_in[0]>$calc[0])
											{	
												$next_day = new DateTime(date('d-m-Y H:i:s').' + 1 day');
												$in_end = new DateTime($next_day->format('d-m-Y')." ".$end_time);
											}
											else
											{
												$in_end = new DateTime(date('Y-m-d').$end_time);
											}
										}
										
										$in_interval = dateTimeDiff($in_start,$in_end);
										$break = $this->attendance_model->get_break_details_by_attendance_id($att[$day_value]["id"]);
										if(isset($break) && !empty($break))
										{
											foreach($break as $br)
											{
											
												if($br["in_time"]!="00:00:00")
												{
													$reg_st = explode(':',$br["in_time"]);
													$reg_et = explode(':',$br["out_time"]);
													if($reg_st[0]>$reg_et[0])
													{
														$next_day = new DateTime(date('d-m-Y H:i:s').' + 1 day');
														$break1=date('Y-m-d')." ".$br["in_time"];
														$break2 = $next_day->format('d-m-Y')." ".$br["out_time"];
													}
													else
													{	
														$break1=date('Y-m-d')." ".$br["in_time"];
														$break2 = date('Y-m-d')." ".$br["out_time"];
													}	
													
													$break1_date = new DateTime($break1);
													$break2_date =  new DateTime($break2);
													$break_interval = dateTimeDiff($break1_date,$break2_date);
													
													$total_break = $total_break+$break_interval->i;
													if($break_interval->h>0)
														$total_break = $total_break + $break_interval->h *60;
													if($break_interval->s>0)
														$total_break = $total_break + ($break_interval->s /60);
												}
											}
										}
										$time_taken = $in_interval->h *60+$in_interval->i - $total_break ;
										
										if($in_interval->s>0)
											$time_taken =$time_taken +($in_interval->s /60);										
										}
									
										
										if($sun=="Sunday")
										{																
											$yes =1;
											if(isset($att[$day_value])&& !empty($att[$day_value]))
											{												
												$half_salary = $regular_time_val/2;
												$working_hours= gmdate("H:i:s", ($time_taken * 60)); 
												
												if($half_regular>$time_taken)
												{													
													echo '<td colspan="2" class="center">&nbsp;-&nbsp;</td>';
												}
												else
												{																																													
												$user_id_val = $filter["user_id"][$k];
												$days_array_val = $days_array[$n];
												if($att[$days_array_val]["in"]==NULL && $att[$days_array_val]["out"]==NULL)
												{																									
													echo '<td colspan="2" class="center">&nbsp;-&nbsp;</td>';
												}
												else
												{																									
												if(isset($att[$days_array_val]) && !empty($att[$days_array_val])){										
												echo '<td data="'.$att[$days_array_val]["id"]."=".$days_array_val."=".$user_id_val.'" at_id="'.$att[$days_array_val]["id"].'_in" class="check-time check_in holiday_time"><span class="break-time">'.$att[$days_array_val]["in"];?>
												</span></td>
												<?php 
												echo '<td at_id="'.$att[$days_array_val]["id"].'" class="check-time check_out holiday_time"><span class="break-time">'.$att[$days_array_val]["out"];
												?></span>
                                                </td>                                             
                                                <?php											
												}
												}
												}
														
											}
											else
											{
												echo '<td colspan="2" class="center">&nbsp;-&nbsp;</td>';
											}									
										}
											if($yes==0)
									{
										if($sun=="Saturday")
										{											
											if(isset($saturday_holiday) && $saturday_holiday==1)
											{
												$yes =1;
												if(isset($att[$day_value])&& !empty($att[$day_value]))
												{	//print_r($att[$day_value]);
													$half_salary = $regular_time_val/2;
													$working_hours= gmdate("H:i:s", ($time_taken * 60));                    
													
													if($half_regular>$time_taken)
													{														
														echo '<td colspan="2" class="center">&nbsp;-&nbsp;</td>';
													}
													else
													{																									
													$user_id_val = $filter["user_id"][$k];
												    $days_array_val = $days_array[$n];
													if($att[$days_array_val]["in"]==NULL && $att[$days_array_val]["out"]==NULL)
													{																									
														echo '<td colspan="2" class="center">&nbsp;-&nbsp;</td>';
													}
													else
													{														
												    if(isset($att[$days_array_val]) && !empty($att[$days_array_val])){										
												    echo '<td data="'.$att[$days_array_val]["id"]."=".$days_array_val."=".$user_id_val.'" at_id="'.$att[$days_array_val]["id"].'_in" class="check-time check_in"><span class="break-time">'.$att[$days_array_val]["in"];?>
                                                    </span></td>
                                                    <?php 
                                                    echo '<td at_id="'.$att[$days_array_val]["id"].'" class="check-time check_out"><span class="break-time">'.$att[$days_array_val]["out"];
                                                    ?>
                                                    </span>
                                                    </td>                                                                                                       													
													<?php												   
													}
													}
													}															
												}
												else
												{
													echo '<td colspan="2" class="center">&nbsp;-&nbsp;</td>';
												}
											}
											
										}
										}
									if($yes==0)
									{
										if(isset($holi_arr[$day_value])&& !empty($holi_arr[$day_value]))
										{											
												$yes =1;																							
												if(isset($att[$day_value])&& !empty($att[$day_value]))
												{													
													if($half_regular>$time_taken)
													{													
														echo '<td colspan="2" class="center">PH</td>';
													}
													else
													{
													$user_id_val = $filter["user_id"][$k];
												    $days_array_val = $days_array[$n];
													if($att[$days_array_val]["in"]==NULL && $att[$days_array_val]["out"]==NULL)
													{																									
														echo '<td colspan="2" class="center">PH</td>';
													}
													else
													{												
												    if(isset($att[$days_array_val]) && !empty($att[$days_array_val])){										
												    echo '<td data="'.$att[$days_array_val]["id"]."=".$days_array_val."=".$user_id_val.'" at_id="'.$att[$days_array_val]["id"].'_in" class="check-time check_in"><span class="break-time">'.$att[$days_array_val]["in"];?>
                                                    </span></td>
                                                    <?php 
                                                    echo '<td at_id="'.$att[$days_array_val]["id"].'" class="check-time check_out"><span class="break-time">'.$att[$days_array_val]["out"];
                                                    ?> 
                                                    </span>
                                                    </td>                                                                                                       													
													<?php												   
													}
													}
													}
													
												}
												else
												{																				
													echo '<td colspan="2" class="center">PH</td>';													
												}
											
										}	
									}
									//print_r($leave_arr);
									if($yes==0)
									{
										if(isset($leave_arr[$day_value]) && !empty($leave_arr[$day_value]))
										{	
											$class = "";
											$session = "";
											$reason='';
											$yes = 1;
											$leave_type = "";
											$leave_from = new DateTime(date('d-m-Y H:i:s',strtotime($leave_arr[$day_value]["leave_from"])));
											$leave_to = new DateTime(date('d-m-Y H:i:s',strtotime($leave_arr[$day_value]["leave_to"])));
											$leave_interval =dateTimeDiff($leave_from,$leave_to);
											if($leave_arr[$day_value]['type']=='casual leave' || $leave_arr[$day_value]['type']=='sick leave' || $leave_arr[$day_value]['type']=='earned leave')
											{
												if($leave_from==$leave_to)
												{
													$reason = 2;
													$leave_type = 2;
												}
												else
												{
													
													if($leave_interval->d==0)
													{
														$reason=1;
														$half_day = ($leave_interval->h*60)+$leave_interval->i;
														$leave_type =1;
													}
													else
													{
														$reason=2;
														$leave_type =2;
														
													}
													if($leave_type==1)
													{
														if(strtotime($start_time)==strtotime(date('H:i:s',strtotime($leave_arr[$day_value]["leave_from"]))))
															$session = "session 1";
														else
															$session="session 2";
													}
												}
												if($reason==1)
												{
													if($leave_arr[$day_value]['type']=='casual leave')
														$reason = "CL 1/2";
													else
														$reason ="SL 1/2";
													if($leave_arr[$day_value]['lop']==1)
													{	
														$reason = "LOP 1/2";														
													}
													
												}
												else
												{
												    if($leave_arr[$day_value]['type']=='earned leave')
														$reason = "EL";
													else if($leave_arr[$day_value]['type']=='casual leave')
														$reason = "CL";
													else
														$reason ="SL";
													if($leave_arr[$day_value]['lop']==1)
													{															
														$reason = "LOP";
													}
													
												
												}
											}
											else if($leave_arr[$day_value]['type']=="permission" )
											{
												$reason='P';
												$leave_type =3;
												
											}
											else if($leave_arr[$day_value]['type']=="compoff" )
											{
												$reason = "C";
												$leave_type =4;
											}
											else if($leave_arr[$day_value]['type']=="on-duty" )
											{
												$reason = "OD";
												$leave_type =5;
											}
											//echo $leave_type;
											if(isset($att[$day_value]) && !empty($att[$day_value]))
											{										   
												$yes =1;
										    	$working_hours= gmdate("H:i:s", ($time_taken * 60)); 
												$user_id_val = $filter["user_id"][$k];											
												$days_array_val = $days_array[$n];
																						
												if(isset($att[$days_array_val]) && !empty($att[$days_array_val]))
												{	
													if($att[$days_array_val]["in"]==NULL && $att[$days_array_val]["in"]==NULL)
													
													{
														if($leave_type==2 || $leave_type==4)
												   			echo "<td colspan='2' class='center'>&nbsp;".$reason."&nbsp;</td>";
														else
															echo "<td colspan='2' class='center'>&nbsp;Absent&nbsp;</td>";
													}
													else
													{
										
														if($leave_type==1 || $leave_type==3 || $leave_type==5)
																$class = "permission";	
																				
														echo '<td data="'.$att[$days_array_val]["id"]."=".$days_array_val."=".$user_id_val.'" at_id="'.$att[$days_array_val]["id"].'_in" class="check-time check_in '.$class.'"><span class="break-time">'.$att[$days_array_val]["in"];?>
														</span>
                                                        <?php if($leave_type==1 || $leave_type==3 || $leave_type==5)
															{	
															echo "<span class='leave'  style='display:none;'>";
																if($leave_type==1)
																	echo "<b>Half day leave: </b>".$session;
																else if($leave_type==3)
																	echo "<b>Permission: </b>".date('H:i:s',strtotime($leave_arr[$day_value]["leave_from"]))." - " .date('H:i:s',strtotime($leave_arr[$day_value]["leave_to"]));
																else if($leave_type==5)
																	echo "<b>OD: </b>".date('d-m-Y H:i:s',strtotime($leave_arr[$day_value]["leave_from"]))." - " .date('d-m-Y H:i:s',strtotime($leave_arr[$day_value]["leave_to"]));
															echo "</span>";
															}
														?>
                                                        </td> 
														<?php 
														echo '<td at_id="'.$att[$days_array_val]["id"].'" class="check-time check_out '.$class.'"><span class="break-time">'.$att[$days_array_val]["out"];
													?>
													</span>
													</td>                                                   
													<?php											
													}
												}	
											}		
											else
											echo "<td colspan='2' class='center'>&nbsp;".$reason."&nbsp;</td>";
										}
										
									
									}
									if($yes==0)
									{	
																								     
										if(isset($att[$day_value]) && !empty($att[$day_value]))
										{										   
											$yes =1;
										    $working_hours= gmdate("H:i:s", ($time_taken * 60)); 
											$user_id_val = $filter["user_id"][$k];											
											$days_array_val = $days_array[$n];
																						
											if(isset($att[$days_array_val]) && !empty($att[$days_array_val]))
											{	
												if($att[$days_array_val]["in"]==NULL && $att[$days_array_val]["in"]==NULL)
												{
												   echo "<td colspan='2' class='center'>&nbsp;Absent&nbsp;</td>";
												}
												else
												{
											//print_r($att[$day_value]);									
													echo '<td data="'.$att[$days_array_val]["id"]."=".$days_array_val."=".$user_id_val.'" at_id="'.$att[$days_array_val]["id"].'_in" class="check-time check_in"><span class="break-time">'.$att[$days_array_val]["in"];?>
													</span></td> 
													<?php 
													echo '<td at_id="'.$att[$days_array_val]["id"].'" class="check-time check_out"><span class="break-time">'.$att[$days_array_val]["out"];
													?>
													</span>
													</td>                                                   
													<?php											
												}
											}					
																					
										}										
									}
									
									if($yes==0)
									{								   			
										echo "<td colspan='2' class='center'>&nbsp;Absent&nbsp;</td>";																	
										if($salary[0]["type"]!="daily"){										
										$lop_days = $lop_days + 1;
										}										
									}									
									
									?>
                           <?php }
						   			else
										
						   			echo "<td colspan='2' class='center'>NA</td>";
						   }	
						   }			   
						   ?>                            
                           </tr>
                           <?php 
						   //exit;
						  }
						   endif;
						 if(empty($users))
						  {
						  	if($proceed==0)
						  		$colspan=20+count($days_array)+1;
							else
								$colspan=11+count($days_array)+1;
						  	echo "<tr><td colspan=".$colspan.">No Results Found</td></tr>";
						}?>
                   		</tbody>
                </table>
                </div></div>
   
	 <?php
			 if(isset($users) && !empty($users))
			{
					
						$end=$start_page+ count($users);
						
							$start_page=$start_page+1;
							?>
					<span class="no-display" style="float:left;">Showing <?=$start_page?> to <?=$end?> of <?=$no_of_users?> records  </span>                  
        <?php }?>
              <div class="button_right_align">
              <br />
              <a href="<?=$this->config->item('base_url')."attendance/reports/time_reports/"?>" title="Back"><input type="button" class="btn btn-info btn-rounded" value="Back" /></a>
              </div><!--contentinner-->	
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
var count = <?=$row_count?>;
if(count>11)
{
$(".row_width").css("width","");
}
});
</script>


