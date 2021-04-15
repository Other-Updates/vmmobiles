<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template');  ?>   
<script type="text/javascript" src="<?=$theme_path?>/js/reports.js"></script>
<link href="<?=$theme_path?>/css/print_page.css" rel="stylesheet" >
<style type="text/css">
@media print
{
.contentinner
{
-webkit-print-color-adjust: exact;

}

}
.headerpanel
{
	width:100%;
}

</style>
<div class="contentinner mb-125">
			<?php
				$this->load->model('masters/shift_model');
				$this->load->model('masters/user_shift_model');
				$this->load->model('masters/salary_group_model');
				//print_r($incentive);
			$filter = $this->session_view->get_session(null,null);
		 	$attributes = array('class' => 'stdform editprofileform','method'=>'post');

                echo form_open('',$attributes);
					//print_r($filter);
				?>
            	<h4 class="widgettitle">Wage Reports</h4>
                <div class="well">
                 <table class="table responsive_table">
                 	<thead>
                    	<tr>
                            <th>Department &nbsp; <?php 
								
								$options=array();
								$default = '';
								if(isset($filter["department"])&& !empty($filter["department"]))
								{
									$default = $filter["department"];
								
								}
								if(isset($departments) && !empty($departments))
								{
									foreach($departments as $dept)
									{	
										$options[$dept["dept_id"]] = $dept["dept_name"];
									}
								}
								/*if(isset($_POST['go']))
								{
									$default =$_POST['department'];
								}*/
								echo form_multiselect('department[]',$options,$default,'class="multiselect" id="department_select"');
							?></th>
                            <th id ="designation">Designation &nbsp;<?php 
								$default = '';
								if(isset($filter["designation"])&& !empty($filter["designation"]))
								{
									$default = $filter["designation"];
								
								}
								$options=array();
								if(isset($designations) && !empty($designations))
								{
									foreach($designations as $des)
									{	
										$options[$des["id"]] = $des["name"];
									}
								}
								/*if(isset($_POST['go']))
								{
									$default =$_POST['designation'];
								}*/
								echo form_multiselect('designation[]',$options,$default,'class="multiselect" id="designation_select"');
							?></th>
                            <th>User Type&nbsp; <?php 
								$options=array(''=>"Select",1=>"Weekly",2=>"Monthly");
								$default=$user_type;
								echo form_dropdown('user_type',$options,$default,'id="user_type" class="uniformselect user_type"');
							?>
                            </th>
                            <th>Year &nbsp;<?php $options=array(''=>'Select Year');
								
								for($i=2000;$i<=date('Y');$i++)
								{
									$options[$i] = $i;
								
								}
								echo form_dropdown('year',$options,$year,'id="year_select" class="input-small"');
							?></th>
                            <th>Month &nbsp;<?php 
							        $options=array(''=>'Select Month');
									$month_arr = array("Jan","Feb","Mar","Apr","May","June","July","Aug","Sep","Oct","Nov","Dec");
									$default = $month;
									if($year == date('Y'))
									{
										if($user_type==1)
										{
											
											for($i=0;$i<date('m');$i++)
												$options[$i+1] = $month_arr[$i];
										}
										else
										{
											for($i=0;$i<date('m')-1;$i++)
											{
											
												if($i==date('m')-2)
												{
													if(date('d')>$month_starting_date)
														$options[$i+1] = $month_arr[$i];
												}
												else
													$options[$i+1] = $month_arr[$i];
											}
										}
									}
									else
									{
										for($i=0;$i<12;$i++)
										{
											$options[$i+1] = $month_arr[$i];
										
										}
									
									}
									//$options[$default] = $month_arr[$default-1];
								echo form_dropdown('month',$options,$default,'id="month_select" class="input-small"');
							
							?></th>
                            <input type="hidden" name="start_date" id="start_date" value="<?=$start_date?>">
                            <input type="hidden" name="end_date" id="end_date" value="<?=$end_date?>">
                         <th id="date_th">Week &nbsp;
                         	<?php
								$filter_start = $start_date;
								$filter_end = $end_date;
								

								$default = "";
								if(isset($filter['date'])) 
									$default = $filter["date"];
								//echo $default;
								$starting_day = array();
								
								$day = $month_starting_date;
								
								$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
								
								$start_d = $year."-".$month."-1";
								$end = ($year)."-".$month."-".($days_in_month);
								$start_date = date('d-m-Y',strtotime($start_d));
								$end_date = date('d-m-Y',strtotime($end));
								$std_dt1 = $end_date." 00:00:00";
								$exclude_date1= new DateTime($std_dt1.' +1 day');
								$e_date1 = $exclude_date1->format('d-m-Y');
								$start = new DateTime($start_date.' 00:00:00');
								//Create a DateTime representation of the last day of the current month based off of "now"
								$end = new DateTime( $e_date1.' 00:00:00');
								//Define our interval (1 Day)
								$interval = new DateInterval('P1D');
								//Setup a DatePeriod instance to iterate between the start and end date by the interval
								$period = new DatePeriod( $start, $interval, $end );
								
								//Iterate over the DatePeriod instance
								//$sunday = array();
								foreach( $period as $date ){
									//Make sure the day displayed is ONLY sunday.
									if( $date->format('w') == $week_starting_day ){
										$starting_day[] =$date->format( 'd-m-Y' ).PHP_EOL;
									}
									
								}
								//echo $start_date;
								
								//print_r( $starting_day);
								$options = array();
								if(isset($starting_day)&& !empty($starting_day))
								{
									if($year == date('Y'))
									{
										
										if($month==date('m'))
										{
										//echo date('m')-1;
											foreach($starting_day as $st)
											{
											    if(strtotime($st)<strtotime(date("d-m-Y")))
											    {
												$next_date1 =  date("Y-m-d",strtotime($st))." 00:00:00";
												$next_date2 = new DateTime($next_date1.' +6 day');
												if($next_date2->format('d')<date('d'))
												$options[date('d',strtotime($st))] = date('d-M',strtotime($st));
												}
											}
											
										
										}
										else
										{																		
											foreach($starting_day as $st)
											{											
											   if(strtotime($st)<strtotime(date("d-m-Y")))
											     {
											       $options[ltrim(date('d',strtotime($st)),0)] = date('d-M',strtotime($st));
											     }
											}
										}
									}
									else
									{
										foreach($starting_day as $st)
										{										
											$options[date('d',strtotime($st))] = date('d-M',strtotime($st));
										}
									}
								}
								
								
								echo form_multiselect('date[]',$options,$default,'id="date_select" class="multiselect"');
								
							?>
                          
                            <th class="res_div"><input type="submit" name="go" value="  Go  " id="go" class="btn btn-info border4"></th>
                            <th>
                        	<a href="javascript:void(0)" style="float:right" title="Reset"><input type="button" class="btn btn-danger border4 reset" value="Reset"></a>
                        </th>
                          </tr></thead>
                          
    			</table>
                </div>
                <?php 
						
					//$no_of_users1[0]['count'] = 1150;
					$options = array();
					$this->load->model('options_model');
					$record = array(10,20,30,40,50,60,70,80,90,100,120,140,160,180,200);
					$closest = $this->options_model->getClosest(count($no_of_users),$record);
					//echo $closest;
					for($k=10;$k<=$closest;)
					{
						$options[$k]=$k;
						if($k<100)
							$k=$k+10;
						else
							$k = $k+20;
					}
					if(count($no_of_users)>=1000)
					{
						$count_start = count($no_of_users)/100;
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
						if($max<count($no_of_users))
							$count  = "all";
						else
							$count = $max;
					}
					$options["all"] = "All";
					//echo $no_of_users1[0]['count'];
					echo "<span class='hide_show'>Show ".form_dropdown('record_show',$options,$count,"id='count_change'")." entries</span>";
					
				?>                 
                <div class="button_right_align">NA - Not Applicable, &nbsp; P - Permission, &nbsp; SL - Sick Leave, &nbsp; CL - Casual Leave, &nbsp; EL - Earned Leave, &nbsp; LOP - Loss of Pay, &nbsp; OD - On-duty, &nbsp; C- Compoff, &nbsp; PH - Public Holiday, &nbsp; I - Inactive Status
                </div>               
                <table class="table table-bordered wage_res"  >
                
                <tr>
                <td>Name of the Company : <strong><?php if(isset($company_name) && $company_name!="") echo $company_name;?></strong></td>
                <td>Place : <strong><?php if(isset($place) && $place!="") echo $place;?></strong></td>
                <td>District : <strong><?php if(isset($district) && $district!="") echo $district;?></strong></td>
                <td>Holidays : <strong>Sunday<?php if(isset($saturday_holiday) && $saturday_holiday==1) echo " , Saturday"; echo ", PH-Public holidays";?></strong></td>
                <td colspan="4">Month of <strong><?php $month_arr = array("Jan","Feb","Mar","Apr","May","June","July","Aug","Sep","Oct","Nov","Dec");

							echo $month_arr[$month-1]." ".$year;
				
				?></strong></td>
                </tr>
                </table>          
    <br>
    <?php 
		
		if(isset($saturday_holiday) && $saturday_holiday==0)
			$week_days = 6;
		else
			$week_days = 5;
		$this->load->model("attendance_model");
		$month_start = new DateTime(date('d-m-Y',strtotime($filter_start))." 00:00:00");
		$month_end = new DateTime(date('d-m-Y',strtotime($filter_end))." 00:00:00");
		$s_date = date('d-m-Y',strtotime($filter_start));
		$std_dt = $filter_end." 00:00:00";
		$exclude_date = new DateTime($std_dt.' +1 day');
		$e_date = $exclude_date->format('d-m-Y');
		
		$start = new DateTime($s_date.' 00:00:00');
		//Create a DateTime representation of the last day of the current month based off of "now"
		$end = new DateTime( $e_date.' 00:00:00');
		//Define our interval (1 Day)
		$interval = new DateInterval('P1D');
		//Setup a DatePeriod instance to iterate between the start and end date by the interval
		$period = new DatePeriod( $start, $interval, $end );
		
		//Iterate over the DatePeriod instance
		//$sunday = array();
		foreach( $period as $date ){
			//Make sure the day displayed is ONLY sunday.
			$days_array[] = $date->format( 'd-m-Y' );
		}
		$proceed = 0;
		//Define our interval (1 Day)
		$interval = new DateInterval('P1D');
		//Setup a DatePeriod instance to iterate between the start and end date by the interval
		$period = new DatePeriod( $month_start, $interval, $end );
		//Iterate over the DatePeriod instance
		$sunday = array();
		foreach( $period as $date ){
			//Make sure the day displayed is ONLY sunday.
			if( $date->format('w') == 0 ){
				//echo $date->format( 'd-m-Y' );
				$sunday[] =$date->format( 'd-m-Y' ).PHP_EOL;
			}
			//Checking saturday is a  Saturday holiday 
			if(isset($saturday_holiday) && $saturday_holiday==1)
			{
				if( $date->format('w') == 6 ){
				//echo $date->format( 'd-m-Y' );
					$sunday[] =$date->format( 'd-m-Y' ).PHP_EOL;
				}
			}
		}
		//print_r($days);
		//if(isset($saturday_holiday) && $saturday_holiday==0)
		
		//print_r($sunday);
			//exit;
		
		
	?>
				 <div id="table_scroll">
                <table class="table table-bordered print_table1 print_border"  style="font-size:10px;">
                    <thead>
                        <tr height="20">
                            <th rowspan="3"><div id="rotate_holiday">S.No</div></th>
                        	<th rowspan="3">Name of the Worker</th>
                           <!-- <th rowspan="3">Father's&nbsp;or<br>Husband's Name</th>
                            <th rowspan="3">Address</th>
                            <th id="rotate_padding" rowspan="3"><div id="rotate">Nature&nbsp;of&nbsp;work</div></th>
                            <th id="rotate_padding" rowspan="3"><div id="rotate">Group&nbsp;No.&nbsp;Relay&nbsp;No.</div></th>
                            <th id="rotate_padding1" rowspan="3"><div id="rotate">Token&nbsp;giving&nbsp;reference to&nbsp;Certificate</div></th>-->
                            <?php  for($d=0;$d<=count($days_array)-1;$d++){?>
                            	<th rowspan="3"><?php $current_day = explode("-",$days_array[$d]);
									echo $current_day[0];
								
								?></th>
                           <?php }?>
                            <th height="116" colspan="2" rowspan="1" style="vertical-align:bottom; top:10px;"><div id="rotate" style="top:-10px;">Rate&nbsp;of&nbsp;Wages</div></th>
                             <th  rowspan="3" id="rotate_padding1"><div id="rotate" style="top:-10px;">No.of&nbsp;working&nbsp;days </div></th>
                            <th  rowspan="3" id="rotate_padding1"><div id="rotate" class='during_class' style="top:-10px;">No.of&nbsp;days&nbsp;worked during&nbsp;the&nbsp;<?php if($filter["user_type"]==1) echo "week(s)"; else echo "month";?></div></th>
                             <th  rowspan="3" id="rotate_padding1"><div id="rotate" style="top:-10px;">Compoff&nbsp;days&nbsp;worked</div></th>
                            <?php if($proceed==0){?>
                            <th colspan="2" rowspan="1" style="vertical-align:bottom"><div id="rotate" style="top:-10px;">Wages&nbsp;Earned</div></th>                            
                            <th colspan="2" rowspan="1" style="vertical-align:bottom"><div id="rotate" style="top:-10px;">Dearness&nbsp;Allowances</div></th>
                            <th colspan="2" rowspan="1" style="vertical-align:bottom"><div id="rotate" style="top:-10px;">Allowances</div></th>
                            <th colspan="2" rowspan="1" style="vertical-align:bottom"><div id="rotate" style="top:-10px;">Total&nbsp;Deductions</div></th>
                            <th colspan="2" rowspan="1" style="vertical-align:bottom"><div id="rotate" style="top:-10px;">Incentives</div></th>
                            <th colspan="2" rowspan="1" style="vertical-align:bottom"><div id="rotate" style="top:-10px;">Net&nbsp;Amount&nbsp;Paid</div></th>
                            <th rowspan="3" style="vertical-align:bottom"><div id="rotate" style="top:-10px;">Sign&nbsp;of&nbsp;the&nbsp;worker</div></th> 
                            <?php }?>                           
                        </tr>
                         <tr height="20">
                            <th>Rs.</th>
                            <th>P.</th>
                            <?php if($proceed==0){?>
                            <th>Rs.</th>
                            <th>P.</th>
                            <th>Rs.</th>
                            <th>P.</th>
                            <th>Rs.</th>
                            <th>P.</th>
                            <th>Rs.</th>
                            <th>P.</th>  
                            <th>Rs.</th>
                            <th>P.</th>
                            <th>Rs.</th>
                            <th>P.</th>  
                            <?php }?>                      
                            </tr>
                           
                            </thead>
                            <tbody>
                            <?php
								///print_r($attendance);
								
									$s =  $start_page+1;
								if(isset($attendance)&& !empty($attendance))
								$result = array_filter($attendance);
						//	if(isset($result)&& !empty($result)){
							if(isset($users) && !empty($users)):
								
								for($k=0;$k<count($users);$k++){
								$no_of_ot_hours = 0;
								$comp_off_ot_hours = 0;
								$user_overtime = 0;
								$att = array(0);
								$da = 0;
								$total_all = 0;
								$total_dedu = 0;
								$user_salary = array();
								if(isset($attendance[$k]) && !empty($attendance[$k]))
								{
									//$this->pre_print->view($attendance[$k]);
									foreach($attendance[$k] as $am)
									{
										if($am["in"]!="00:00:00")
										$att[$am["attendance_date"]] = $am;
									
									
									}
								}
								//print_r($incentive[$k]);
								///echo "<pre>";
								//print_r($att);
								//exit;
								$leave_arr = array();
								if(isset($leave[$k]) && !empty($leave[$k]))
								{
									foreach($leave[$k] as $lval)
									{
										$current_shift_id = $this->user_shift_model->get_user_current_shift_by_user_id($users[$k]["id"],$lval["l_from"]);
												
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
												/*	$date_dt = date('d-m-Y',strtotime($lval["l_from"]));
												$date_dt2 = new DateTime($std_dt.' -1 day');*/
												//print_r($date_dt2);
												//$date_dt3 = $exclude_date->format('d-m-Y');
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
												/*	$date_dt = date('d-m-Y',strtotime($lval["l_from"]));
												$date_dt2 = new DateTime($std_dt.' -1 day');*/
												//print_r($date_dt2);
												//$date_dt3 = $exclude_date->format('d-m-Y');
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
											//$sunday = array();
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
							//$this->pre_print->view($holi_arr);	
							$lop_days = 0;
							$comp_off_days = 0;
							$days_with_salary = 0;
							$total_ot_earned = 0;
							$total_compoff_ot_earned = 0;
							$earned = 0 ;
							$ot_all = 0;
							
							?>
                           
                            <tr>
                            <td><?=$s++?></td>
                            <td><?=$users[$k]['first_name']?></td>                           
                              <?php 
							  		for($n=0;$n<=count($days_array)-1;$n++){
							  			$current_day = explode("-",$days_array[$n]);									
                            			$working_days = count($days_array)-(count($sunday)+count($holi_arr));										
									$day_value = $days_array[$n];
									$current = $current_day[0];
									//echo $day_value;
								if(isset($users[$k]["dol"]) && strtotime($day_value)>strtotime($users[$k]["dol"]))
										echo "<td class='center'>I</td>";								
								else
								{
								$overtimestart =0;
								$overtimend = 0;
								$start_time = 0;
								$regular_time = 0;
								$regular_time_val = 0;
								$half_regular = 0;
								$breaktimediff=0;
								$date_end =0;
								$end_time = 0;
								$half_dedu = 0;
								$full_dedu = 0;
								$leave_taken = 0;
								$duty_hours = 0;
							
								$on_duty = 0;
								$full_day_od = 0;
								$current_shift_id = $this->user_shift_model->get_user_current_shift_by_user_id($users[$k]["id"],$day_value);						
								$shift = $this->shift_model->get_shift_details_by_shift_id($current_shift_id[0]["shift_id"]);
								$salary = $this->user_salary_model->get_user_salary_by_user_id($users[$k]["id"],$day_value);
								//echo $this->db->last_query();
								$salary_group = $this->salary_group_model->get_salary_group_split_by_salary_group_id($salary[0]["salary_group"]);
								if(!isset($user_salary[$salary[0]["basic"]]))
									$user_salary[$salary[0]["basic"]] = $salary[0]['basic'];								
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
												if($interval->s>0)
												{
													$breaktimediff = $breaktimediff + ($interval->s/60);
												}
											}
										}
									}
									$regular_time_val = $regular_time->h*60 + $regular_time->i - $breaktimediff - $threshold[0]['value'];
									$res = explode(':',$start_time);
									$shift_start_time = $res[0]*60+$res[1]+$threshold[0]['value'];
									if(isset($res[2]) && $res[2]>0)
										$shift_start_time = $shift_start_time + ($res[2]/60);
									$half_regular = $regular_time_val /2;
									$yes = 0;
									$total_break = 0;
									$time_taken = 0;
									$break = array();
									$difference ="";
									$permission_hrs = 0;
									$half_day = 0;
									$ot_value = 0;
									$half_day_salary = 0;
									$one_day_salary = 0;
									$one_hr_salary = 0;
									$current_ot_hrs = 0;
									$current_compoff_ot_hrs = 0;
									$full_da = 0;
									$half_da = 0;
									$half_all =0;
									$full_all = 0;
									$one_hr_da = 0;
									$one_hr_all = 0;
									$overtime_break = 0;
									
									    //Half day,one day nad one hour  salary calculation
										if($salary[0]['type']=='weekly')
										{
											$half_day_salary = $salary[0]['basic']/($week_days*2);
											$one_day_salary = $salary[0]['basic']/$week_days;
											
											if(isset($salary_group)&& !empty($salary_group))
											{
												foreach($salary_group as $grp)
												{
													if($grp['deduction']==1)
													{	
														if($grp['percentage']==1)
														{
															$half_dedu += $grp['value']/100*$half_day_salary;
															$full_dedu += $grp['value']/100*$one_day_salary;
														}
														else
														{
															$half_dedu += ($grp['value']*0.5)/$week_days;
															$full_dedu += $grp['value']/$week_days;
														}
													
													}
													
												}
											}
											$half_da += $salary[0]['da']/($week_days*2);
											$full_da += $salary[0]['da']/$week_days;	
											if(isset($salary_group)&& !empty($salary_group))
											{
												foreach($salary_group as $grp)
												{
													
													if($grp['deduction']==0)
													{
														if($grp['percentage']==1)
														{
															$half_all += $grp['value']/100*$half_day_salary;
															$full_all += $grp['value']/100*$one_day_salary;
														}
														else
														{
															$half_all += ($grp['value']*0.5)/$week_days;
															$full_all += $grp['value']/$week_days;
														}
													}
												}
											}
											
										}
										elseif($salary[0]['type']=='monthly')
										{
											$half_day_salary = $salary[0]['basic']/($working_days*2);
											$one_day_salary = $salary[0]['basic']/$working_days;
											
											if(isset($salary_group)&& !empty($salary_group))
											{
												foreach($salary_group as $grp)
												{
													if($grp['deduction']==1)
													{	
														if($grp['percentage']==1)
														{
															$half_dedu += $grp['value']/100*$half_day_salary;
															$full_dedu += $grp['value']/100*$one_day_salary;
														}
														else
														{
															$half_dedu += ($grp['value']*0.5)/$working_days;
															$full_dedu += $grp['value']/$working_days;
														}
													
													}
													
												}
												
											}											
											$half_da += $salary[0]["da"]/($working_days*2);
											$full_da += $salary[0]['da']/$working_days;
											if(isset($salary_group)&& !empty($salary_group))
											{
												foreach($salary_group as $grp)
												{
													$new_value = 0;
													
													if($grp['deduction']==0)
													{
														if($grp['percentage']==1)
														{
															$half_all += $grp['value']/100*$half_day_salary;
															$full_all += $grp['value']/100*$one_day_salary;
														}
														else
														{
															$half_all += ($grp['value']*0.5)/$working_days;
															$full_all += $grp['value']/$working_days;
														}
													}
												}
											}
											
										}
										elseif($salary[0]['type']=='daily')
										{
											$half_day_salary = round($salary[0]['basic']/2);
											$one_day_salary = $salary[0]['basic'];
											
											if(isset($salary_group)&& !empty($salary_group))
											{
												foreach($salary_group as $grp)
												{
													if($grp['deduction']==1)
													{	
														if($grp['percentage']==1)
														{
															$half_dedu += $grp['value']/100*$half_day_salary;
															$full_dedu += $grp['value']/100*$one_day_salary;
														}
														else
														{
															$half_dedu += ($grp['value']*0.5);
															$full_dedu += $grp['value'];
														}
													
													}
													
												}
											}
											
											$half_da += round($salary[0]['da']/2);
											$full_da += $salary[0]['da'];
											
											if(isset($salary_group)&& !empty($salary_group))
											{
												foreach($salary_group as $grp)
												{
													$new_value = 0;
													
													if($grp['deduction']==0)
													{
														if($grp['percentage']==1)
														{
															$half_all += $grp['value']/100*$half_day_salary;
															$full_all += $grp['value']/100*$one_day_salary;
														}
														else
														{
															$half_all += ($grp['value']*0.5);
															$full_all += $grp['value'];
														}
													}
												}
											}
										}
										
									$one_hr_salary = $one_day_salary/round($regular_time_val/60);
									$one_hr_da = $full_da/round($regular_time_val/60);
									$one_hr_all = $full_all/round($regular_time_val/60);
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
										$shift_start1 = date("H:i", strtotime($start_time)-21600); 
										$end_threshold = explode(':',$shift_start1);
										$check1 = DateTime::createFromFormat('H:i', $user_in_start);
										$check2 = DateTime::createFromFormat('H:i', $start_shift);
										
										if($shift_start[0]>$end[0])
										{
											$next_day = new DateTime(date('d-m-Y H:i:s').' + 1 day');
											$check3 = new DateTime($next_day->format('d-m-Y')." ".$shift_start1);
										}
										else
										{
											$check3 = DateTime::createFromFormat('H:i', $shift_start1);
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
										//print_r($calc);										
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
											//echo $end_time;
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
													
													
													if($current_shift_id[0]['ot_applicable']==1)
													{
														if($overtimestart!=0)
														{
															$ot_br_start =  strtotime($break1);
															$ot_br_end = strtotime($break2);
															$ot_start1=date('d-m-Y')." ".$overtimestart;
															$ot_end1 =date('d-m-Y')." ".$overtimeend;
															if(strtotime($ot_end1)<=strtotime($ot_start1))
															{
																$exclude_date = new DateTime($ot_end1.' +1 day');
																$ot_end1 =$exclude_date->format('d-m-Y')." ".$overtimeend;
															}
															//echo $break1;
															if($ot_br_start>=strtotime($ot_start1))
															{
																if($ot_br_end<=strtotime($ot_end1))
																$overtime_break =	$overtime_break +  $break_interval->h *60 +$break_interval->i+ ($break_interval->s/60);	
																else
																{
																	
																	$date12 = new DateTime($ot_end1);
																	$ot_br_interval = dateTimeDiff($break1_date,$date12);
																	$overtime_break =	$overtime_break +  $ot_br_interval->h *60 +$ot_br_interval->i+ ($ot_br_interval->s/60);	
																}	
															}
														}
														
													}
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
										//print_r($salary[$k]);
										if($current_shift_id[0]['ot_applicable']==1)
										{
											if($overtimestart!=0)
											{
												$over1 = explode(':',$overtimestart);
												$over2 = explode(':',$overtimeend);
												if($att[$day_value]["out"]!=NULL && $att[$day_value]["out"]!="00:00:00" && $att[$day_value]["out"]!="00:00")
												{
														$att_out = explode(':',$att[$day_value]["out"]);
														$ot_start=$att[$day_value]["attendance_date"]." ".$overtimestart;
														$ot_end =$att[$day_value]["attendance_date"]." ".$overtimeend;
														if(strtotime($ot_end)<=strtotime($ot_start))
														{
															$exclude_date = new DateTime($ot_end.' +1 day');
															$ot_end =$exclude_date->format('d-m-Y')." ".$overtimeend;
														}
														$in_start = $att[$day_value]["attendance_date"]." ".$att[$day_value]["in"];
														$out_end = $att[$day_value]["attendance_date"]." ".$att[$day_value]["out"];
														if(strtotime($out_end)<=strtotime($in_start))
														{
															$exclude_date = new DateTime($out_end.' +1 day');
															$out_end =$exclude_date->format('d-m-Y')." ".$att[$day_value]["out"];
														}
														if(strtotime($ot_start)<strtotime($in_start))
														{
															$ot_start= $in_start;
														}
														$difference ="";
														if(strtotime($ot_start)<strtotime($out_end))
														{
															if(strtotime($ot_end)>strtotime($out_end))
															{
																$ot_start=new DateTime($ot_start);
																$out_end = new DateTime($out_end);
																$difference = dateTimeDiff($ot_start,$out_end);
															}
															else if(strtotime($ot_end)<=strtotime($out_end))
															{
																$ot_start=new DateTime($ot_start);
																$ot_end = new DateTime($ot_end);
																$difference = dateTimeDiff($ot_start,$ot_end);
															}														
														}
														
														
															if($difference!="")
															{
																
																$overtime_calc =round($regular_time_val/60)/4;																
																$new_time = $difference->h.".".$difference->i;
																$new_hours  = $difference->h*60+$difference->i - $overtime_break;																
																//OT value calculation
																if(isset($min_ot_hours)):
																	
																	$temp = explode(':',$min_ot_hours);
																	$ot_value = $temp[0]*60;
																	if(isset($temp[1]))
																		$ot_value += $temp[1];
																	
																	if($new_hours-$ot_threshold>=$ot_value-$ot_threshold)
																	{
																		if($ot_division!=0)
																		{
																			if(isset($saturday_holiday) && $saturday_holiday==1)
																			{
																				if($sun == "Sunday" || $sun == "Saturday" )
																				{
																					$current_compoff_ot_hrs = floor($new_hours / $ot_division);
																					$remind = $new_hours%$ot_division;
																					if($remind+$ot_threshold>=$ot_division)
																					{
																						//echo $no_of_ot_hours;
																						$current_compoff_ot_hrs +=1;
																					}
																				//	echo $current_compoff_ot_hrs;
																					$comp_off_ot_hours += $current_compoff_ot_hrs ;
																					if(isset($overtime_wages))
																						$total_compoff_ot_earned += ($current_compoff_ot_hrs/(60/$ot_division) )* ($one_hr_salary*$overtime_wages);
																				}
																				else
																				{
																					$current_ot_hrs = floor($new_hours / $ot_division);
																					$remind = $new_hours%$ot_division;
																					if($remind+$ot_threshold>=$ot_division)
																					{
																						
																						$current_ot_hrs +=1;
																					}
																					
																					$no_of_ot_hours += $current_ot_hrs ;
																					if(isset($overtime_wages))
																						$total_ot_earned +=( $current_ot_hrs /(60/$ot_division))* ($one_hr_salary*$overtime_wages);
																				}
																			}
																			else if($sun == "Sunday")
																			{
																				$current_compoff_ot_hrs = floor($new_hours / $ot_division);
																				$remind = $new_hours%$ot_division;
																				if($remind+$ot_threshold>=$ot_division)
																				{
																					//echo $no_of_ot_hours;
																					$current_compoff_ot_hrs +=1;
																				}
																				$comp_off_ot_hours += $current_compoff_ot_hrs ;
																				if(isset($overtime_wages))
																						$total_compoff_ot_earned += ($current_compoff_ot_hrs/(60/$ot_division)) * ($one_hr_salary*$overtime_wages);
																			}
																			else
																			{
																			
																				$current_ot_hrs = floor($new_hours / $ot_division);
																					
																				$remind = $new_hours%$ot_division;
																				if($remind+$ot_threshold>=$ot_division)
																				{
																					
																					$current_ot_hrs += 1 ;
																				}
																				$no_of_ot_hours += $current_ot_hrs;
																				//echo $no_of_ot_hours;
																				if(isset($overtime_wages))
																						$total_ot_earned += ($current_ot_hrs/(60/$ot_division)) * ($one_hr_salary*$overtime_wages);
																			}
																		}
																		//echo $new_hours." ".$no_of_ot_hours;
																	}
																endif;
															}
														}
															/*$user_overtime = $user_overtime+$interval->h;*/
													}
											}
										}	
									
									
										if($current_ot_hrs>0)
										{
											$ot_all  += ($current_ot_hrs/(60/$ot_division)*$one_hr_da)*2;
											$ot_all  += ($current_ot_hrs/(60/$ot_division)*$one_hr_all)*2;
										
										}
										if($current_compoff_ot_hrs>0)
										{
											$ot_all  += ($current_compoff_ot_hrs/(60/$ot_division)*$one_hr_da)*2;
											$ot_all  += ($current_compoff_ot_hrs/(60/$ot_division)*$one_hr_all)*2;
										
										}
										
										
										//echo $no_of_ot_hours;
										//echo "compoff".$comp_off_ot_hours;
										if($sun=="Sunday")
										{
											//print_r( $att[$current]);
											$yes =1;
											if(isset($att[$day_value])&& !empty($att[$day_value]))
											{
												//print_r($att[$day_value]);
												$half_salary = $regular_time_val/2;
												
												if($regular_time_val<=$time_taken)
												{
													$comp_off_days = $comp_off_days +1;
													echo '<td  class="holiday_class">C</td>';
												}
												else
												{
													$comp_off_days = $comp_off_days +0.5;
													echo '<td  class="holiday_class">C 1/2</td>';
												}
														
											}
											else
											{
												echo '<td  class="holiday_class">-&nbsp;Sun&nbsp;-</td>';
											}
										//	$working_days--;
										}
										if($sun=="Saturday")
										{
											
											if(isset($saturday_holiday) && $saturday_holiday==1)
											{
												$yes =1;
												if(isset($att[$day_value])&& !empty($att[$day_value]))
												{
													
													$half_salary = $regular_time_val/2;
													if($regular_time_val<=$time_taken)
													{
														$comp_off_days = $comp_off_days +1;
														echo '<td  class="holiday_class">C</td>';
													}
													else
													{
														$comp_off_days = $comp_off_days +0.5;
														echo '<td  class="holiday_class">C 1/2</td>';
													}
															
												}
												else
												{
													echo '<td  class="holiday_class">-&nbsp;Sat&nbsp;-</td>';
												}
											}
											
										}
										
									if($yes==0)
									{
										if(isset($holi_arr[$day_value])&& !empty($holi_arr[$day_value]))
										{											
												$yes =1;
												//echo $in_interval->h;
												if(isset($att[$day_value])&& !empty($att[$day_value]))
												{
													
													if($in_interval->h>5)
													{
														$comp_off_days = $comp_off_days +1;
														echo '<td>C</td>';
														
													}
													else
													{
														$comp_off_days = $comp_off_days +0.5;
														echo '<td>C 1/2</td>';
													}
												}
												else
												{
													echo '<td>PH</td>';
													
												}
											//$working_days--;
											
										}	
									}
									if($yes==0)
									{
										if(isset($leave_arr[$day_value]) && !empty($leave_arr[$day_value]))
										{
											$reason='';
											$yes = 1;
										
											$leave_from = new DateTime(date('d-m-Y H:i:s',strtotime($leave_arr[$day_value]["leave_from"])));
											$leave_to = new DateTime(date('d-m-Y H:i:s',strtotime($leave_arr[$day_value]["leave_to"])));
											$leave_interval =dateTimeDiff($leave_from,$leave_to);
											if($leave_arr[$day_value]['type']=='casual leave' || $leave_arr[$day_value]['type']=='sick leave' || $leave_arr[$day_value]["type"]=="earned leave")
											{
												if($leave_from==$leave_to)
												{
													$reason = 2;
												
												}
												else
												{
													
													if($leave_interval->d==0)
													{
														$reason=1;
														$half_day = ($leave_interval->h*60)+$leave_interval->i;
													}
													else
													{
														$reason=2;
														
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
														if($salary[0]["type"]!="daily"){
														$lop_days = $lop_days+0.5;
														$reason = "LOP 1/2";
														}
														else
															$reason = "1/2";
													}
													else
													{
														if($salary[0]["type"]!="daily"){
														$days_with_salary = $days_with_salary +0.5;
														$earned += $half_day_salary ;
														
														$da +=$half_da;
														$total_all +=$half_all;
														$total_dedu += $half_dedu;
														}
																
													}
													if(isset($att[$day_value])&& !empty($att[$day_value]))
													{
														$balance = $regular_time_val - ($leave_interval->h*60)-$leave_interval->i; 
														if($time_taken<$balance)
														{	
															
															if($salary[0]["type"]!="daily"){
															$lop_days = $lop_days+1;
															$reason = "LOP";
															}
															else
															$reason = "a";
																
														}
														else
														{
															//if($salary[0]["type"]!="daily"){
															
															$days_with_salary =$days_with_salary +0.5;
															//}
															
															$earned += $half_day_salary ;
															
															
															$da +=$half_da;
															$total_all +=$half_all;
															$total_dedu += $half_dedu;
														}	
													}
													else
													{
														if($leave_arr[$day_value]['lop']==1)
														{
															if($salary[0]["type"]!="daily"){
															$lop_days = $lop_days+1;
															$reason = "LOP";
															}
															else
															$reason = "a";
														}
													
													}
												}
												else
												{
													if($leave_arr[$day_value]['type']=='casual leave')
														$reason = "CL";
													else if($leave_arr[$day_value]['type']=='sick leave')
														$reason ="SL";
													else if($leave_arr[$day_value]['type']=='earned leave')
														$reason ="EL";
													if($leave_arr[$day_value]['lop']==1)
													{	
														
														if($salary[0]["type"]!="daily"){
														$lop_days = $lop_days+1;
														
														$reason = "LOP";}
														else
															$reason = "a";
													}
													else
													{
															$days_with_salary = $days_with_salary +1;
															$earned += $one_day_salary ;
															
															$total_dedu += $full_dedu;
															$da +=$full_da;
															$total_all +=$full_all;												
													}
												
												}
											}
											else if($leave_arr[$day_value]['type']=="permission" )
											{
												$reason='P';
												
												$permission_hrs = ($interval->h*60)+$interval->i;
												if($leave_arr[$day_value]['lop']==1)
												{	
													if($salary[0]["type"]!="daily"){
													$lop_days = $lop_days+0.5;
													$reason = "LOP 1/2";
													}else
														$reason = "1/2";
												}
												else
												{											
													$days_with_salary = $days_with_salary +0.5;
													$earned += $half_day_salary ;
													
													$da +=$half_da;
													$total_all +=$half_all;	
													$total_dedu += $half_dedu;													
												
												}
												if(isset($att[$day_value])&& !empty($att[$day_value]))
												{
													
													$balance = $regular_time_val - $permission_hrs; 
													
													if($time_taken<$balance && $leave_arr[$day_value]['lop']==1)
													{	
														
														$lop_days = $lop_days+1;
														if($salary[0]["type"]!="daily"){
															$reason = "LOP";
														}
														else
														{
															$reason ="a";
														}
													}
													else if ($time_taken<$balance && $leave_arr[$day_value]['lop']==0)
													{
														$lop_days = $lop_days+1;
														if($salary[0]["type"]!="daily"){
															$reason = "LOP 1/2";
														}
														else
														{
															$reason ="1/2";
														}
													
													}
													else if($time_taken>=$balance)
													{														
														$days_with_salary =$days_with_salary +0.5;													
														$earned += $half_day_salary;
														$da +=$half_da;
														$total_all +=$half_all;	
														$total_dedu += $half_dedu;
															
													}
												}
												else
												{
													if($leave_arr[$day_value]['lop']==1)
													{
														if($salary[0]["type"]!="daily"){
														$lop_days = $lop_days+1;
														$reason = "LOP";
														}
														else
														$reason = "a";
													}
												}
											}
											else if($leave_arr[$day_value]['type']=="on-duty" )
											{
												$reason='OD';
												//echo $users[$k]["id"];
												$od_dt = $day_value." 00:00:00";
												$exclude_date = new DateTime($od_dt.' +1 day');
												$next_day = $exclude_date->format('d-m-Y');
												if($leave_arr[$day_value]["l_from"]==$day_value && $leave_arr[$day_value]["l_to"]==$day_value)
												{
													$ds = explode(':',date('H:i:s',strtotime($leave_arr[$day_value]["leave_from"])));
													$duty_start_time = $ds[0]*60+$ds[1];
													if(isset($ds[2]) && $ds[2]>0)
													{
														$duty_start_time = $duty_start_time + ($ds[2]/60);
														
													}
													$ds_to = explode(':',date('H:i:s',strtotime($leave_arr[$day_value]["leave_to"])));
													$duty_end_time = $ds_to[0]*60+$ds_to[1];
													if(isset($ds_to[2]) && $ds_to[2]>0)
													{
														$duty_end_time = $duty_end_time + ($ds_to[2]/60);
														
													}
													$d_from = new DateTime($day_value." ".date('H:i:s',strtotime($leave_arr[$day_value]["leave_from"])));
													$d_to = new DateTime($day_value." ".date('H:i:s',strtotime($leave_arr[$day_value]["leave_to"])));
													$d_inter = dateTimeDiff($d_from,$d_to);
													$duty_hours = $d_inter->h*60 + $d_inter->i + $d_inter->i/60;
													//echo $duty_hours;
													$duty_hours = $regular_time_val-$duty_hours;
													if($duty_hours>=$regular_time_val)
													{
														$days_with_salary = $days_with_salary +1;
														$earned += $one_day_salary ;
															
														$total_dedu += $full_dedu;
														$da +=$full_da;
														$total_all +=$full_all;	
														$full_day_od = 1;
														$full_day_od = 1;
													}
													else
													{
														if($shift_start_time>$duty_start_time)
															$on_duty = 1;
															
													}
												}
												elseif($leave_arr[$day_value]["l_from"]==$next_day && $leave_arr[$day_value]["l_to"]==$next_day)
												{
													$ds = explode(':',date('H:i:s',strtotime($leave_arr[$day_value]["leave_from"])));
													$duty_start_time = $ds[0]*60+$ds[1];
													if(isset($ds[2]) && $ds[2]>0)
													{
														$duty_start_time = $duty_start_time + ($ds[2]/60);
														
													}
													$ds_to = explode(':',date('H:i:s',strtotime($leave_arr[$day_value]["leave_to"])));
													$duty_end_time = $ds_to[0]*60+$ds_to[1];
													if(isset($ds_to[2]) && $ds_to[2]>0)
													{
														$duty_end_time = $duty_end_time + ($ds_to[2]/60);
														
													}
													$d_from = new DateTime($day_value." ".date('H:i:s',strtotime($leave_arr[$day_value]["leave_from"])));
													$d_to = new DateTime($day_value." ".date('H:i:s',strtotime($leave_arr[$day_value]["leave_to"])));
													$d_inter = dateTimeDiff($d_from,$d_to);
													$duty_hours = $d_inter->h*60 + $d_inter->i + $d_inter->i/60;
													//echo $duty_hours;
													$duty_hours = $regular_time_val-$duty_hours;
													if($duty_hours>=$regular_time_val)
													{
														$days_with_salary = $days_with_salary +1;
														
														$earned += $one_day_salary ;
															
														$total_dedu += $full_dedu;
														$da +=$full_da;
														$total_all +=$full_all;	
														$full_day_od = 1;
														$full_day_od = 1;
														
													}
													else
													{
														if($shift_start_time>$duty_start_time)
															$on_duty = 1;
													}
												}
												elseif($leave_arr[$day_value]["shift"]=="day")
												{
											if($leave_arr[$day_value]["l_from"]==$day_value && $leave_arr[$day_value]["l_to"]!=$day_value)
											{
												//echo "enter";
												$ds = explode(':',date('H:i:s',strtotime($leave_arr[$day_value]["leave_from"])));
												$duty_start_time = $ds[0]*60+$ds[1];
												if(isset($ds[2]) && $ds[2]>0)
												{
													$duty_start_time = $duty_start_time + ($ds[2]/60);
													
												}
												if($shift_start_time<$duty_start_time)
												{
													
													$d_from = new DateTime($day_value." ".$start_time);
													$d_to = new DateTime($day_value." ".date('H:i:s',strtotime($leave_arr[$day_value]["leave_from"])));
													$d_inter = dateTimeDiff($d_from,$d_to);
													$duty_hours = $d_inter->h*60 + $d_inter->i + $d_inter->i/60;
												
												}
												else if($shift_start_time>=$duty_start_time)
												{
													$days_with_salary = $days_with_salary +1;
													$full_day_od = 1;
													$earned += $one_day_salary ;
															
													$total_dedu += $full_dedu;
													$da +=$full_da;
													$total_all +=$full_all;	
													$full_day_od = 1;
												}
											}
											else if($leave_arr[$day_value]["l_from"]!=$day_value && $leave_arr[$day_value]["l_to"]!=$day_value)
											{
												$days_with_salary = $days_with_salary +1;
												$full_day_od = 1;
												$earned += $one_day_salary ;
															
												$total_dedu += $full_dedu;
												$da +=$full_da;
												$total_all +=$full_all;	
												$full_day_od = 1;
											}
											elseif($leave_arr[$day_value]["l_from"]!=$day_value && $leave_arr[$day_value]["l_to"]==$day_value)
											{
												$ds = explode(':',date('H:i:s',strtotime($leave_arr[$day_value]["leave_to"])));
												$duty_end_time = $ds[0]*60+$ds[1];
												if(isset($ds[2]) && $ds[2]>0)
												{
													$duty_end_time = $duty_end_time + ($ds[2]/60);
													
												}
												if($shift_start_time<$duty_end_time)
												{							
													$d_from = new DateTime($day_value." ".date('H:i:s',strtotime($leave_arr[$day_value]["leave_to"])));
													$d_to = new DateTime($day_value." ".$end_time);
													$d_inter = dateTimeDiff($d_from,$d_to);
													$duty_hours = $d_inter->h*60 + $d_inter->i + $d_inter->i/60;
													$on_duty = 1;
													
												}
												else if($shift_start_time>=$duty_end_time)
												{
													$duty_hours = 0;								
												}
											}
										}
										elseif($leave_arr[$day_value]["shift"]=="night")
										{
											
											if($leave_arr[$day_value]["l_from"]==$day_value && $leave_arr[$day_value]["l_to"]==$next_day)
											{
												$ds = explode(':',date('H:i:s',strtotime($leave_arr[$day_value]["leave_from"])));
												$duty_start_time = $ds[0]*60+$ds[1];
												if(isset($ds[2]) && $ds[2]>0)
												{
													$duty_start_time = $duty_start_time + ($ds[2]/60);
													
												}
												$ds_to = explode(':',date('H:i:s',strtotime($leave_arr[$day_value]["leave_to"])));
												$duty_end_time = $ds_to[0]*60+$ds_to[1];
												if(isset($ds_to[2]) && $ds_to[2]>0)
												{
													$duty_end_time = $duty_end_time + ($ds_to[2]/60);													
												}
												$d_from = new DateTime($day_value." ".date('H:i:s',strtotime($leave_arr[$day_value]["leave_from"])));
												$d_to = new DateTime($next_day." ".date('H:i:s',strtotime($leave_arr[$day_value]["leave_to"])));
												$d_inter = dateTimeDiff($d_from,$d_to);
												$duty_hours = $d_inter->h*60 + $d_inter->i + $d_inter->i/60;
												//echo $duty_hours;
												$duty_hours = $regular_time_val-$duty_hours;
												if($duty_hours>=$regular_time_val)
												{
													$days_with_salary = $days_with_salary +1;
													$earned += $one_day_salary ;
															
													$total_dedu += $full_dedu;
													$da +=$full_da;
													$total_all +=$full_all;	
													$full_day_od = 1;
													$full_day_od = 1;
												}
												else
												{
													if($shift_start_time>$duty_start_time)
														$on_duty = 1;														
												}
											}
											else if($leave_arr[$day_value]["l_from"]==$day_value && $leave_arr[$day_value]["l_to"]!=$day_value)
											{
												$ds = explode(':',date('H:i:s',strtotime($leave_arr[$day_value]["leave_from"])));
												$duty_start_time = $ds[0]*60+$ds[1];
												if(isset($ds[2]) && $ds[2]>0)
												{
													$duty_start_time = $duty_start_time + ($ds[2]/60);													
												}												
												if($shift_start_time<$duty_start_time)
												{													
													$d_from = new DateTime($day_value." ".$start_time);
													$d_end = date('H:i:s',strtotime($leave_arr[$day_value]["leave_from"]));
													if(strtotime($d_end)<=strtotime($start_time))
														$d_to = new DateTime($day_value." ".$d_end);
													else
														$d_to = new DateTime($next_day." ".$d_end);
													$d_inter = dateTimeDiff($d_from,$d_to);
													$duty_hours = $d_inter->h*60 + $d_inter->i + $d_inter->i/60;									
												}
												else if($shift_start_time>=$duty_start_time)
												{
													$days_with_salary = $days_with_salary +1;
													$earned += $one_day_salary ;
															
													$total_dedu += $full_dedu;
													$da +=$full_da;
													$total_all +=$full_all;	
													$full_day_od = 1;
														$full_day_od = 1;												
												}
											}
											else if($leave_arr[$day_value]["l_from"]!=$day_value && $leave_arr[$day_value]["l_to"]!=$day_value)
											{
												if($next_day == $leave_arr[$day_value]["l_to"])
												{
													
													$ds = explode(':',date('H:i:s',strtotime($leave_arr[$day_value]["leave_to"])));
													$duty_end_time = $ds[0]*60+$ds[1];
													if(isset($ds[2]) && $ds[2]>0)
													{
														$duty_end_time = $duty_end_time + ($ds[2]/60);
														
													}												
													if($shift_start_time>=$duty_end_time)
													{
														
														$d_st =date('H:i:s',strtotime($leave_arr[$day_value]["leave_to"]));
														$d_from = new DateTime($day_value." ".$d_st);
														if(strtotime($d_st)>=strtotime($end_time))
															$d_to = new DateTime($next_day." ".$end_time);
														else
														
															$d_to = new DateTime($day_value." ".$end_time);
														$d_inter = dateTimeDiff($d_from,$d_to);
														$duty_hours = $d_inter->h*60 + $d_inter->i + $d_inter->i/60;
														$on_duty = 1;													
													}
													else if($shift_start_time<$duty_end_time)
													{
														$duty_hours = 0;													
													}
												}
												else
												{
													$days_with_salary = $days_with_salary +1;
													$earned += $one_day_salary ;															
													$total_dedu += $full_dedu;
													$da +=$full_da;
													$total_all +=$full_all;	
													$full_day_od = 1;
													$full_day_od = 1;
												}											
											}											
										}	
										
										if(isset($att[$day_value])&& !empty($att[$day_value]))
										{
											$att_time = explode(':',$att[$day_value]["in"]);
											$att_calc = $att_time[0]*60 + $att_time[1];
											if(isset($att_time) && $att_time[2]>0)
												$att_calc =$att_calc  + ($att_time[2]/60);
											$balance = $regular_time_val - $duty_hours; 
											
											if($full_day_od ==0):
												
													if($time_taken<$duty_hours)
													{	
														if($time_taken>=$half_regular )
														{
															if($att_calc>$shift_start_time && $on_duty!=1)
															{															
																if($salary[0]["type"]=="daily")
																	$reason = 'a';
																else
																	$reason = 'LOP';
															}
															else
															{
																$days_with_salary =$days_with_salary +0.5;
																$earned += $half_day_salary;
																$da +=$half_da;
																$total_all +=$half_all;	
																$total_dedu += $half_dedu;
																if($salary[0]["type"]=="daily")
																	$reason = '1/2';
																else
																	$reason = 'LOP 1/2';
															}
														}
														else
														{
															if($salary[0]["type"]=="daily")
																	$reason = 'a';
																else
																	$reason = 'LOP';
														}
														
													}
													
													else if($time_taken>=$duty_hours)
													{
														if($att_calc>$shift_start_time && $on_duty!=1)
														{
															if($salary[0]["type"]=="daily")
																	$reason = '1/2';
																else
																	$reason = 'LOP 1/2';
															$days_with_salary =$days_with_salary +0.5;
															$earned += $half_day_salary;
															$da +=$half_da;
															$total_all +=$half_all;	
															$total_dedu += $half_dedu;
														}
														else
														{
															$days_with_salary =$days_with_salary +1;
															$earned += $one_day_salary ;
													
															$total_dedu += $full_dedu;
															$da +=$full_da;
															$total_all +=$full_all;	
															$reason = '<span class="icon-ok"></span>';
														}
													}
												
											endif;
										}
										else
										{
											if($full_day_od ==0)
											{
												if($salary[0]["type"]=="daily")
													$reason = 'a';
												else
													$reason = 'LOP';
											}
											
										}
										
									}
											
											else if($leave_arr[$day_value]['type']=="compoff" )
											{
												if($leave_arr[$day_value]['approved'] == 1)
												{
													$reason='compoff leave';
													if($leave_interval->h==0)
													{
														$days_with_salary = $days_with_salary +1;
														$earned += $one_day_salary;
														
														$da +=$full_da;
														$total_all +=$full_all;	
														$total_dedu += $full_dedu;
															
													}
													else
													{
														$days_with_salary = $days_with_salary +0.5;
														$earned += $half_day_salary;
														
														$da +=$half_da;
														$total_all +=$half_all;	
														$total_dedu += $half_dedu;
															
													}
												}
												else
												{
													//$reason = 'a';
													if($leave_interval->h>5)
													{
														$lop_days = $lop_days +1;
														$reason = 'a';
													}
													else
													{
														$lop_days = $lop_days +0.5;
														$days_with_salary =$days_with_salary +0.5;
														$reason = 'a 1/2';
														$earned += $half_day_salary;
														
														$da +=$half_da;
														$total_all +=$half_all;	
														$total_dedu += $half_dedu;
															
													}
													
												}
											}
											
										
											echo '<td>'.$reason.'</td>';
											$yes =1;
											
										}
									
									}
									if($yes==0)
									{
										if(isset($att[$day_value]) && !empty($att[$day_value]))
										{
											if($salary[0]["type"]=="daily"){
												
												if($att[$day_value]["in"]!="00:00:00" && $att[$day_value]["in"]!=NULL){
													$att_time = explode(':',$att[$day_value]["in"]);
													$att_calc = $att_time[0]*60 + $att_time[1];
													if(isset($att_time) && $att_time[2]>0)
														$att_calc =$att_calc  + ($att_time[2]/60);
													if($att_calc>$shift_start_time && $regular_time_val>$time_taken)
													{
														
														echo "<td>a</td>";
														$lop_days = $lop_days+1;
														//$days_with_salary = $days_with_salary+0.5;
																													
													}
													else if($att_calc>$shift_start_time)
													{
														
															echo "<td>1/2</td>";
														$lop_days = $lop_days+0.5;
														$days_with_salary = $days_with_salary+0.5;
														$earned += $half_day_salary;
														
														$da +=$half_da;
														$total_all +=$half_all;	
														$total_dedu += $half_dedu;
															
													}
													else if($regular_time_val>$time_taken)
													{
														if($time_taken>=$half_regular )
														{
															echo "<td>1/2</td>";
															$lop_days = $lop_days+0.5;
															$days_with_salary = $days_with_salary+0.5;
															$earned += $half_day_salary;
															
															$da +=$half_da;
															$total_all +=$half_all;	
															$total_dedu += $half_dedu;
														}
														else
														{
															echo "<td>a</td>";
															$lop_days = $lop_days+1;
														}
															
																
													}
													else if($regular_time_val<=$time_taken)
													{	
														$days_with_salary = $days_with_salary+1;
														echo '<td><span class="icon-ok"></span></td>';
														$earned += $one_day_salary;
														
											
														$da +=$full_da;
														$total_all +=$full_all;	
														$total_dedu += $full_dedu;
														
															
													}
													$yes =1;
												}
												else
													echo '<td>a</td>';
											}
											else
											{
													if($att[$day_value]["in"]!="00:00:00" && $att[$day_value]["in"]!=NULL){
													$att_time = explode(':',$att[$day_value]["in"]);
													$att_calc = $att_time[0]*60 + $att_time[1];
													if(isset($att_time[2]) && $att_time[2]>0)
														$att_calc = $att_calc +($att_time[2]/60);
													if($att_calc>$shift_start_time && $regular_time_val>$time_taken)
													{														
														echo "<td>LOP</td>";
														$lop_days = $lop_days+1;																												
													}
													else if($att_calc>$shift_start_time)
													{											
														echo "<td>LOP 1/2</td>";
														$lop_days = $lop_days+0.5;
														$days_with_salary = $days_with_salary+0.5;
														$earned += $half_day_salary;
														
														$da +=$half_da;
														$total_all +=$half_all;	
														$total_dedu += $half_dedu;	
													}
													else if($regular_time_val>$time_taken)
													{													
														if($time_taken>=$half_regular )
														{
															echo "<td>LOP 1/2</td>";
															$lop_days = $lop_days+0.5;
															$days_with_salary = $days_with_salary+0.5;
															$earned += $half_day_salary;
															$da +=$half_da;
															$total_all +=$half_all;	
															$total_dedu += $half_dedu;	
														}
														else
														{
															echo "<td>LOP</td>";
															$lop_days = $lop_days+1;
														}
														
															
													}
													else if($regular_time_val<=$time_taken)
													{	
														$days_with_salary = $days_with_salary+1;
														echo '<td><span class="icon-ok"></span></td>';
														$earned += $one_day_salary;
														$da +=$full_da;
														$total_all +=$full_all;	
														$total_dedu += $full_dedu;											
													}
													$yes =1;
												}
											
											}
											
										}
									}
									if($yes==0)
									{
										echo "<td>a</td>";
										if($salary[0]["type"]!="daily"){										
										$lop_days = $lop_days + 1;
										}
									}									
									?>
                           <?php }
						   		else
									echo "<td>NA</td>";
						   }
						   		
						   }
						   ?>
                           <td><?php
						   			$wages = 0; 
									$new_sal = array();
						   			if(isset($user_salary)&& !empty($user_salary)){
						   					foreach($user_salary as $us)
											{
												$wages +=$us;	
											}
											$new_sal =  explode('.',round($wages/count($user_salary),2));
											echo $new_sal[0];
										}	
										?></td>
                           <td><?php 
						   	if(isset($new_sal[1]))
								echo (strlen($new_sal[1])==1 ? ($new_sal[1]*10) : $new_sal[1]);								
							else
								echo "-";
						   
						   ?></td>
                           <td><?=$working_days?></td>
                           <td><?php
						   		
								echo $days_with_salary;
								$total_ot = 0;
								if($no_of_ot_hours!=0)	$total_ot += $no_of_ot_hours/(60/$ot_division);
								if($comp_off_ot_hours!=0) $total_ot += $comp_off_ot_hours/(60/$ot_division);
								if($total_ot !=0)
									echo "+".$total_ot/4;
								?></td>
                                <td><?php if($comp_off_days>0)
											echo $comp_off_days;
										else
											echo "-";
											
								?></td>
                                <?php if($proceed==0){?>
                             <td><?php 
							 	
								$new_earned = explode('.',round($earned+$total_ot_earned+$total_compoff_ot_earned,2));
								echo $new_earned[0];
							 ?></td>
                             <td><?php if(isset($new_earned[1]))
							                echo (strlen($new_earned[1])==1 ? ($new_earned[1]*10) : $new_earned[1]);							 				
										else
											echo "-";
							 ?></td>
                             
                             <td>
                             	<?php $new_all = explode('.',round($total_all+$da+$ot_all,2));
									echo $new_all[0];
								?>
                             </td>
                            <td><?php 
									if(isset($new_all[1]))
										echo (strlen($new_all[1])==1 ? ($new_all[1]*10) : $new_all[1]);                                       
                                    else
                                        echo "-";
							 
							 ?></td>                             
                             <td>
                             	<?php
									$user_allowance = 0;
									 if(isset($allowance[$k]) && !empty($allowance[$k]))
									{
										$user_allowance = 0;
										foreach($allowance[$k] as $allow)
										{
											$user_allowance += $allow["amount"];
										
										}	
										
									}
									$new_allow = explode('.',round($user_allowance,2));
									echo $new_allow[0];
								?>
                             </td>
                             <td><?php 
							 	if(isset($new_allow[1]))
								    echo (strlen($new_allow[1])==1 ? ($new_allow[1]*10) : $new_allow[1]);							 		
								else
									echo "-";
							 
							 ?></td>                             
                              <td>
                             	<?php 							
								$user_deduction = 0;
								if(isset($deduction[$k]) && !empty($deduction[$k]))
								{
									$user_deduction = 0;
									foreach($deduction[$k] as $ded)
									{
										$user_deduction += $ded["amount"];
									
									}	
									$total_dedu += $user_deduction;
								}
								$tds_value = 0;
								//print_r($tds[$k]);
								if(isset($tds[$k]) && !empty($tds[$k]))
								{
									$tds_value = 0;
									foreach($tds[$k] as $tds_ded)
									{
										$tds_value += $tds_ded["amount"];										
									}	
									$total_dedu += $tds_value;
								}
								$new_dedu = explode(".",round($total_dedu,2));
									echo $new_dedu[0];
								?>
                             </td>
                             <td><?php 
							 		if(isset($new_dedu[1]))
										echo (strlen($new_dedu[1])==1 ? ($new_dedu[1]*10) : $new_dedu[1]);							 			
									else
										echo "-";	
									?>
							 </td>
                             <td>
                             	<?php
									$user_incentive = 0;
									 if(isset($incentive[$k]) && !empty($incentive[$k]))
									{
										$user_incentive = 0;
										foreach($incentive[$k] as $inc)
										{
											$user_incentive += $inc["amount"];
										
										}	
										
									}
									$new_inc = explode('.',round($user_incentive,2));
									echo $new_inc[0];
								?>
                             </td>
                             <td><?php 
							 	if(isset($new_inc[1]))
									echo (strlen($new_inc[1])==1 ? ($new_inc[1]*10) : $new_inc[1]);							 		
								else
									echo "-";
							 
							 ?></td>
                             <td><?php 
							 	$net_amt  = round($earned+$total_ot_earned+$total_compoff_ot_earned,2)+round($total_all+$da+$ot_all,2)-round($total_dedu,2);	
									$new_net = array();
							 		if(isset($incentive[$k]) && !empty($incentive[$k]))									
							 			$net_amt =$net_amt+round($user_incentive,2);									
																			
									if(isset($allowance[$k]) && !empty($allowance[$k]))									
							 			$new_net = explode('.',$net_amt+round($user_allowance,2));									
									else
										$new_net = explode('.',$net_amt);
										
									echo $new_net[0];
								?></td>
                              <td><?php 
							  	if(isset($new_net[1]))
									echo (strlen($new_net[1])==1 ? ($new_net[1]*10) : $new_net[1]);								
								else
									echo "-";
							  				?></td>
                              <td>&nbsp;</td>
                              <?php 
							  
							  }
							  
							  ?>
                            </tr>
                           <?php 						  
						  }
						   endif;
						 if(empty($users))
						  {
						  	if($proceed==0)
						  		$colspan=22+count($days_array)+1;
							else
								$colspan=13+count($days_array)+1;
						  	echo "<tr><td colspan=".$colspan.">No Results Found</td></tr>";
						}?>
                   		</tbody>
                </table>
                </div>
   
	 <?php
			 if(isset($users) && !empty($users))
			{
					
						$end=$start_page+ count($users);
						
							$start_page=$start_page+1;
							?>
					<span class="no-display">Showing <?=$start_page?> to <?=$end?> of <?=count($no_of_users)?> records</span>
        <?php }?>
              <div class="button_right_align">
              	  <?php   
				  	if(isset($links) && $links!=NULL)
					echo $links;					
					?>
                    <a href="#" id="print" class="btn btn-warning border4 print-align"><i class="icon icon-print"></i>Print</a>
              </div>
                
             <input type="hidden" id="week_starting_day" value="<?=$week_starting_day?>"/>
               <input type="hidden" id="month_starting_date" value="<?=$month_starting_date?>"/>
            </div><!--contentinner-->
            
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
		user_val = "<?=$user_type?>";		
		if(user_val==2)
		{
			$("#date_th").hide();
		}	
	});
</script>
