<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template');  ?>   
<script type="text/javascript" src="<?=$theme_path?>/js/other_reports.js"></script>
<link href="<?=$theme_path?>/css/print_page.css" rel="stylesheet" >
<style type="text/css">
@media print
{
@page{ size : portrait;}
}
.headerpanel
{
	width:100%;
}
</style>
<div class="contentinner mb-100">
			<?php
				//print_r($deduction);
			$filter = $this->session_view->get_session(null,null);
		 	$attributes = array('class' => 'stdform editprofileform','method'=>'post');

                echo form_open('',$attributes);?>
            	<h4 class="widgettitle">Deduction Reports</h4>
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
								echo form_multiselect('designation[]',$options,$default,'class="multiselect" id="designation_select"');
							?></th>
                            <th>User Type&nbsp; <?php 
								$options=array(''=>"Select",1=>"Weekly",2=>"Monthly");
								$default=$user_type;
								echo form_dropdown('user_type',$options,$default,'id="user_type" class="uniformselect user_type"');
							?>
                            </th>
                            <th>Year &nbsp;<?php $options=array(''=>'Select Year');
								
								for($i=2000;$i<=date('Y')+1;$i++)
								{
									$options[$i] = $i;
								
								}
								echo form_dropdown('year',$options,$year,'id="year_select" class="input-small"');
							?></th>
                            <th>Month &nbsp;<?php 
							        $options=array(''=>'Select Month');
									$month_arr = array("Jan","Feb","Mar","Apr","May","June","July","Aug","Sep","Oct","Nov","Dec");
									$default = $month;
									if($year == date('Y')+1)
									{
										/*if($user_type==1)
										{
											*/
											for($i=0;$i<date('m')-1;$i++)
												$options[$i+1] = $month_arr[$i];
										/*}
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
										}*/
									}
									else
									{
										for($i=0;$i<12;$i++)
										{
											$options[$i+1] = $month_arr[$i];
										
										}
									
									}									
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
								$sunday = array();
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
									/*if($year == date('Y'))
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
									{*/
										foreach($starting_day as $st)
										{										
											$options[date('d',strtotime($st))] = date('d-M',strtotime($st));
										}
									//}
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
                <table class="table table-bordered  wage_res">                
                <tr>
                <td>Name of the Company : <strong><?php if(isset($company_name) && $company_name!="") echo $company_name;?></strong></td>
                <td>Place : <strong><?php if(isset($place) && $place!="") echo $place;?></strong></td>
                <td>District : <strong><?php if(isset($district) && $district!="") echo $district;?></strong></td>
                <!--<td>Holidays : <strong>Sunday<?php if(isset($saturday_holiday) && $saturday_holiday==1) echo " , Saturday";?></strong></td>-->
                <td colspan="4">Month of <strong><?php $month_arr = array("Jan","Feb","Mar","Apr","May","June","July","Aug","Sep","Oct","Nov","Dec");
							echo $month_arr[$month-1]." ".$year;				
				?></strong></td>
                </tr>
                </table>          
    <br>
    <?php	
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
		$sunday = array();
		foreach( $period as $date ){
			//Make sure the day displayed is ONLY sunday.
			$days_array[] = $date->format( 'd-m-Y' );
		}
		$proceed = 0;
	
		
	?>
				 <div id="table_scroll">
                <table class="table table-bordered print_border incentive_table"  style="font-size:10px;">
                    <thead>
                        <tr>
                            <th rowspan="3">S.No</th>
                        	<th rowspan="3">Name of the Worker</th>
                            <th colspan="2"  rowspan="1">Deductions</th>
                            <!--<th rowspan="3">Description</th>-->                                                
                        </tr>
                        <tr>
                            <th>Rs.</th>
                            <th>P.</th>                  
                        </tr>
                           
                            </thead>
                            <tbody>
                            <?php
							$s = $start_page +1;
							if(isset($users) && !empty($users)):
							for($k=0;$k<count($users);$k++){
							?>
                            <tr>
                            <td class="center"><?=$s++?></td>
                            <td class="center"><?=$users[$k]['first_name']?></td>
                            <td class="center">
                             	<?php 
								//print_r($deduction);
									$user_deduction = 0.0;
									if(isset($deduction[$k]) && !empty($deduction[$k]))
									{
										
										foreach($deduction[$k] as $deduct)
										{
											$user_deduction += $deduct["amount"];
										
										}
										
									}
									$new_val = explode('.',round($user_deduction,2));
									echo $new_val[0];
								?>
                            </td>
                            <td class="center"><?php if(isset($new_val[1]))
									echo (strlen($new_val[1])==1 ? ($new_val[1]*10) : $new_val[1]);
									else
									echo "-"; ?>
                            </td>
                            <!--<td class="center"><?=$deduction[$k][0]["description"]?></td>-->                            
                            </tr>
                           <?php 
						   //exit;
						  }
						 endif;
						 if(empty($users))
						  {
						  	
						  	echo "<tr><td colspan='5' class='center'>No Results Found</td></tr>";
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
                     <a href="#" id="print" class="btn btn-warning btn-rounded print-align" style="float:right;"><i class="icon icon-print"></i>Print</a>
              </div>
                
             <input type="hidden" id="week_starting_day" value="<?=$week_starting_day?>"/>
             <input type="hidden" id="month_starting_date" value="<?=$month_starting_date?>"/>
            </div><!--contentinner-->
            
            <?php 
	


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
