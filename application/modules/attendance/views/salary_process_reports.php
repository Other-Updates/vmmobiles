<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template');  ?>   
 <script type="text/javascript" src="<?= $theme_path; ?>/js/wage_slip.js"></script>
 <link rel="stylesheet" href="<?=$theme_path?>/css/jquery.easy-pie-chart.css" type="text/css" />
 <script type="text/javascript" src="<?=$theme_path?>/js/jquery.easy-pie-chart.js"></script>
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
<div class="contentinner mb-125">
	<h4 class="widgettitle">Wage Process Reports</h4>
	<div class="widgetcontent">
    		<div class="well well-small">
            	 <?php 
		 		$filter = $this->session_view->get_session(null,null);
		 		$attributes = array('class' => 'stdform editprofileform','method'=>'post');

                echo form_open('',$attributes);
				
				$s = $start_page+1;?>
            <table class="table print_border responsive_table">
            	<thead>
                	<tr>
                        <th>Department &nbsp; <?php 
						
							$default = '';
								if(isset($filter["department"])&& !empty($filter["department"]))
								{
									$default = $filter["department"];
								
								}
							$options = array();
							if(isset($departments) && !empty($departments))
							{
								foreach($departments as $dept)
								{
									$options[$dept["dept_id"]] = ucwords($dept["dept_name"]);
								
								
								}
							}
							echo form_multiselect('department[]',$options,$default,'class="multiselect" id="department_select"');
						?></th>
                        <th id ="designation">Designation &nbsp; <?php 
							$default = '';
								if(isset($filter["designation"])&& !empty($filter["designation"]))
								{
									$default = $filter["designation"];
								
								}
							$options = array();
							if(isset($designations) && !empty($designations))
							{
								foreach($designations as $des)
								{
									$options[$des["id"]] = ucwords($des["name"]);
								
								
								}
							}
								echo form_multiselect('designation[]',$options,$default,'class="multiselect" id="designation_select"');
						?></th>
                     	<th>Shift &nbsp;
                        	<?php 
								$default = '';
								if(isset($filter["shift"])&& !empty($filter["shift"]))
								{
									$default = $filter["shift"];
								
								}
							$options = array();
							if(isset($shifts) && !empty($shifts))
							{
								foreach($shifts as $shf)
								{
									$options[$shf["id"]] = ucwords($shf["name"]);
								
								
								}
							}
							echo form_multiselect('shift[]',$options,$default,'class="multiselect" ');
                        	?>
                        </th>
                        <th>Salary Group &nbsp;
                        	<?php 
								$default = '';
								if(isset($filter["salary_group"])&& !empty($filter["salary_group"]))
								{
									$default = $filter["salary_group"];
								
								}
							$options = array();
							if(isset($salary_groups) && !empty($salary_groups))
							{
								foreach($salary_groups as $sg)
								{
									$options[$sg["id"]] = ucwords($sg["name"]);
								
								
								}
							}
							echo form_multiselect('salary_group[]',$options,$default,'class="multiselect" ');
                        	?>
						
                        </th>
                         
                         <th>
                         	Year &nbsp;<?php 
							
								$options=array(''=>'Select Year');
								
								for($i=2000;$i<=date('Y');$i++)
								{
									$options[$i] = $i;
								
								}
								if(isset($filter["year"]))
									$default = $filter["year"];
								else
									$default = date('Y');
								echo form_dropdown('year',$options,$default,'id="year_select"');
							?>
                         </th>
                         <th>Month &nbsp;<?php 
						 	$month_arr = array("Jan","Feb","Mar","Apr","May","June","July","Aug","Sep","Oct","Nov","Dec");
							$options=array(''=>'Select Month');
								
							if(isset($filter["month"]))
							{
									$default = $filter["month"];
									if($year == date('Y'))
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
							}
								else
								{
									for($i=0;$i<date('m');$i++)
									{
										$options[$i+1] = $month_arr[$i];
									
									}
									$default = $month;	
								}
								//print_r($default);
								
								echo form_dropdown('month',$options,$default,'id="month_select"');
						 
						 ?></th>
                          <input type="hidden" name="start_date" id="start_date" value="<?=$start_date?>">
                          <input type="hidden" name="end_date" id="end_date" value="<?=$end_date?>">
                          <input type="hidden" name="month_start_date" id="month_start_date" value="<?=$month_start_date?>">
                          <input type="hidden" name="month_end_date" id="month_end_date" value="<?=$month_end_date?>">
                         
                        <th>
                        	<?php $data = array(
							  'name'        => 'search',
							  'value'		=> 'Search',
							  'class'		=>'btn btn-warning btn-rounded',
							  'title'		=>'Search'
							);
					
					 		echo form_submit($data);?>
                        </th>
                        <th>
                        	<a href="javascript:void(0)" style="float:right" title="Reset"><input type="button" class="btn btn-danger btn-rounded reset" value="Reset"></a>
                        </th>
                     </tr>
                </thead>
            </table>
            </div>
              
                 <?php 
					$options = array();
					$this->load->model('options_model');
					$record = array(10,20,30,40,50,60,70,80,90,100,120,140,160,180,200);
					$closest = $this->options_model->getClosest(count($no_of_users1),$record);
					//echo $closest;
					for($k=10;$k<=$closest;)
					{
						$options[$k]=$k;
						if($k<100)
							$k=$k+10;
						else
							$k = $k+20;
					}
					if(count($no_of_users1)>=1000)
					{
						$count_start = count($no_of_users1)/100;
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
						if($max<count($no_of_users1))
							$count  = "all";
						else
							$count = $max;
					}
					$options["all"] = "All";
					//echo $no_of_users1[0]['count'];
					echo "<span class='hide_show'>Show ".form_dropdown('record_show',$options,$count,"id='count_change'")." entries</span> ";
							
							
								$default = date('d',strtotime($start_date));
								$filter_start = $start_date;
								$filter_end = $end_date;
								//echo $default;
								$starting_day = array();
								
								$day = $month_starting_date;
								/*if($month_starting_date==1)
								{
									if($month!=12)
									{
										$start_d = $year."-".$month."-".$day;
										$end = $year."-".($month+1)."-".$day;
									}
									else
									{
										$start_d = $year."-".$month."-".$day;
										$end = ($year+1)."-1-".$day-1;
									}
								}
								else
								{
									if($month!=12)
									{
										$start_d = $year."-".$month."-".$day;
										$end = $year."-".($month+1)."-".($day-1);
									}
									else
									{
										$start_d = $year."-".$month."-".$day;
										$end = ($year+1)."-1-".($day-1);
									}
								}*/

								$start_date = date('d-m-Y',strtotime($month_start_date));  //$start_date = date('d-m-Y',strtotime($start_d));
								$end_date = date('d-m-Y',strtotime($month_end_date));  //$end_date = date('d-m-Y',strtotime($end));							
														
								$start = new DateTime($start_date.' 00:00:00');
								//Create a DateTime representation of the last day of the current month based off of "now"
								$end = new DateTime( $end_date.' 00:00:00');
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
								$current_month = 0;
								$options = array();
								if(isset($starting_day)&& !empty($starting_day))
								{
									if($year == date('Y'))
									{
										if($month==date('m'))
										{
										
											$current_month = 1;
											foreach($starting_day as $st)
											{
												$next_date1 =  date("Y-m-d",strtotime($st))." 00:00:00";
												$next_date2 = new DateTime($next_date1.' +6 day');
												//if($next_date2->format('Y-m-d')<date('Y-m-d'))
													$options[date('d',strtotime($st))] = date('d-M',strtotime($st));
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
									else
									{
										foreach($starting_day as $st)
										{
											$options[date('d',strtotime($st))] = date('d-M',strtotime($st));
										}
									}
								}
								
								//print_r($options);
								//echo form_dropdown('date',$options,$default,'id="date_select"');
								$weekly_users = array();
								$monthly_users = array();
								if(isset($users) && !empty($users))	
								{
									$this->load->model('masters/user_salary_model');
									
									foreach($users as $user)
									{
										$type = $this->user_salary_model->get_user_salary_by_user_id($user["id"],$start_date);
										if($type[0]["type"]=="weekly" || $type[0]["type"]=="daily")
											$weekly_users[] = $user;
										else
											$monthly_users[] = $user;
									}
								}
								//print_r($monthly_users);
							?>
                            
           <div class="button_right_align">
                	I - Inactive Status
           </div>           
           <div class="scroll_bar">            
            <table class="table table-bordered editprofileform wage_res"  >
                
                <tr>
                <td>Name of the Company : <strong><?php if(isset($company_name) && $company_name!="") echo $company_name;?></strong></td>
                <td>Place : <strong><?php if(isset($place) && $place!="") echo $place;?></strong></td>
                <td>District : <strong><?php if(isset($district) && $district!="") echo $district;?></strong></td>
                <td>Holidays : <strong>Sunday</strong></td>
                <td colspan="4">Month of <strong><?php $month_arr = array("Jan","Feb","Mar","Apr","May","June","July","Aug","Sep","Oct","Nov","Dec");

							echo $month_arr[$month-1]." ".$year;
				
				?></strong></td>
                </tr>
                </table>      
                <br>    
                <?php
				//print_r($weekly_users);
				 if(isset($weekly_users) && !empty($weekly_users)):?>
    	    	<table class="table table-bordered print_border salary_table"  style="font-size:10px;">
                    <thead>
                        <tr>
                            <th>S.No</th>
                        	<th >Name of the Worker</th>
                            <?php if(isset($options)&& !empty($options)){
								foreach($options as $current_week)
								{?>
                             <th><?=$current_week?></th>
                        	<?php }
								}
							?>
                            <?php if($current_month==0){?>
                            <th >Salary Processed</th>
                          
                            <?php }?>                           
                        </tr>
                        </thead>
                      <tbody>
                      	<?php 
							$k=1;							
							$v=0;
							foreach($weekly_users as $w_user)
							{
								echo "<tr>";
								$current_user = 0;
								echo "<td class='center'>".$s++."</td>";
								echo "<td class='center'>".$w_user["first_name"]."</td>";
								//print_r($options);
								foreach($options as $current_key =>$current_week)
								{
									echo "<td class='center'><center>";
									$current_date = $year."-".$month."-". $current_key;
									
									$next =  date("Y-m-d",strtotime($current_date))." 00:00:00";
									$next_current = new DateTime($next.' +6 day');
									
									$salary = $this->salary_process_model->get_user_processed_salary_by_user_id_and_date($w_user["id"],$current_date,$next_current->format('Y-m-d'));
									//print_r($salary);	
									//echo $w_user["dol"];								
									if(isset($w_user["dol"]) && strtotime($current_date)>strtotime($w_user["dol"]))
										echo "I";								
									else if(isset($salary) && !empty($salary))
									{
										//echo "<i class='icon icon-ok'></i>";
										echo "<img src='".$theme_path."/img/check-mark.svg' width='40' height ='40'/>";
										$current_user ++;
									}										
									else
										echo "<img src='".$theme_path."/img/remove.png' width='15' height ='15'/>";									
									echo "</center></td>";									
								}
								if($current_month==0){
								echo "<td class='center'><center>";
								if($current_user == count($options))
								{
									$percent = 100;
								}
								else if($current_user>0)
								{
									$percent = (100/count($options))*$current_user;
								}
								else
								{
									$percent = 0;
								}
								echo '<div class="chart" data-percent="'.round($percent) .'">'.round($percent).'%</div>';
								
								
								echo "</center></td>";
								}
								echo "<tr>";
							}
						?>
                      </tbody>
                    </table>
                    <?php echo "<br>"; endif;?>
                    
                    <?php if(isset($monthly_users) && !empty($monthly_users)):
							//$s =1;
					?>
                    	<table class="table table-bordered print_border salary_table "  style="font-size:10px;">
                   		 <thead>
                       	 	<tr>
                            <th >S.No</th>
                        	<th >Name of the Worker</th>
                            <th><?=$month_arr[ltrim($month,0)-1]?></th>
                            <?php if($current_month==0){?>
                            <th>Salary Processed</th>
                            <?php }?>
                           </tr>
                          </thead>
                          <tbody>
                          <?php $k=1;
							foreach($monthly_users as $m_user)
							{
								echo "<tr>";
								$current_user = 0;
								echo "<td class='center'>".$s++."</td>";
								echo "<td class='center'>".$m_user["first_name"]."</td>";
								//echo $start_date;
								$get_start = explode("-",$filter_start);
								$salary = $this->salary_process_model->get_user_processed_salary_by_month_year($m_user["id"],$get_start[0],$get_start[1]);
								echo "<td class='center'><center>";
								if(isset($salary) && !empty($salary))
								{
									//echo "<i class='icon icon-ok'></i>";
									echo "<img src='".$theme_path."/img/check-mark.svg' width='40' height ='40'/>";
									$current_user = 1;
								}
									
								else
									echo "<img src='".$theme_path."/img/remove.png' width='15' height ='15'/>";
								echo "</center></td>";
								if($current_month==0){
								echo "<td class='center'><center>";
								if($current_user==1)
									$percent = 100;
								else
									$percent =0;
									echo '<div class="chart" data-percent="'.$percent.'">'.$percent.'%</div>';
								echo "</center></td>";
								}
								echo "<tr>";
							}?>
                          </tbody>
                         </table>
                    <?php endif;
					if(empty($users))
						echo "No Results Found";
					?>
        </div>
           <?php
			if(isset($users) && !empty($users))
			{
				$end=$start_page + count($users);
				 if($start_page==0)
					$start_page=1;
					?>
		<!--	<span class="no-display">Showing <?=$start_page?> to <?=$end?> of <?=count($no_of_users1)?> records</span>-->
            <?php }?>
        
        
     
         <div class="button_right_align">
         <?php if(isset($links1) && $links1!=NULL)
					echo $links1;?><br />
                      <a href="javascript:void(0);" ><input type="button" class="btn btn-success"  value="Process Salary"  name = "process" style="display:none" id="process_salary"/></a>
                      <a href="#" id="print" class="btn btn-warning btn-rounded print-align"><i class="icon icon-print"></i>Print</a>
      			</div>
                
                
    	      
           
      
    </div>
    
</div>
<script type = "text/javascript">
	$(document).ready(function(){
		 $('.chart').easyPieChart({
        //your configuration goes here
		animate: 2000,
		size : 40,
		barColor:function(percent){
		if(percent==100)
			return "#51A351";
		else if(percent>70)
			return "#1176CE";
		else
			return "red";
		}
    	});
	
		var day = "<?=$week_starting_day ?>";
		var s_date = "<?=$month_starting_date?>";
		
		var d = new Date();
		    
		    var total_days = daysInMonth($("#month_select").val(),$("#year_select").val());
			var m=$("#month_select").val();
			var y=$("#year_select").val();
			var start=1;
			$("#month_start_date").val(y+"-"+m+"-"+start);
			$("#month_end_date").val(y+"-"+m+"-"+total_days);
			
		$("#month_select").change(function(){
		if($(this).val()!=0){
			list = "";
			var getTot = daysInMonth($(this).val(),$("#year_select").val()); //Get total days in a month
			var m=$(this).val();
			var y=$("#year_select").val();
			var start=1;
			$("#month_start_date").val(y+"-"+m+"-"+start);
			$("#month_end_date").val(y+"-"+m+"-"+getTot);
			
			var sat = new Array();   //Declaring array for inserting Saturdays
		
			for(var i=1;i<=getTot;i++){    //looping through days in month
				var newDate = new Date($("#year_select").val(),$(this).val()-1,i);
				if(newDate.getDay()==day){   //if Saturday
					sat.push(i);
				}
			
			}
			 list += "<option value='0'>Select Week</option>";
			if($("#year_select").val()== d.getFullYear())
			{
				if(d.getMonth()== $(this).val()-1)
				{
					for(k=0;k<sat.length;k++)
					{
						if(parseInt(sat[k]+6)<d.getDate())
						{
							current = sat[k]+"-"+ $(this).val()+"-"+$("#year_select").val();
							list += "<option value='"+current+"'>"+sat[k]+"-"+$("#month_select option:selected").text()+"</option>";
							
						}
					}
				}
				else
				{
					for(k=0;k<sat.length;k++)
					{
						
						current = sat[k]+"-"+ $(this).val()+"-"+$("#year_select").val();
						list += "<option value='"+current+"'>"+sat[k]+"-"+$("#month_select option:selected").text()+"</option>";
						
						
					}
				
				}
			}
			else
			{
				for(k=0;k<sat.length;k++)
				{
					
					current = sat[k]+"-"+ $(this).val()+"-"+$("#year_select").val();
					list += "<option value='"+current+"'>"+sat[k]+"-"+$("#month_select option:selected").text()+"</option>";
						
					
				}
			
			}
			
			$("#date_select").html(list);
			if(s_date!=1)
			{
				end_date = parseInt(s_date)-1;
				end_month = parseInt($(this).val())+1;
				if($(this).val()!=12)
				{
					$("#start_date").val($("#year_select").val()+"-"+$(this).val()+"-"+s_date);
					$("#end_date").val($("#year_select").val()+"-"+end_month+"-"+end_date);
				}
				else
				{
					$("#start_date").val($("#year_select").val()+"-"+$(this).val()+"-"+s_date);
					$("#end_date").val($("#year_select").val()+1+"-1-"+end_date);
				
				}
			}
			else
			{
				end_date = daysInMonth($(this).val(),$("#year_select").val());
				end_year = parseInt($("#year_select").val())+1;
				
				$("#start_date").val($("#year_select").val()+"-"+$(this).val()+"-"+s_date);
				$("#end_date").val($("#year_select").val()+"-"+$(this).val()+"-"+end_date);
				
			
			}
			}
	});
	
	function daysInMonth(month,year) {
    	return new Date(year, month, 0).getDate();
	}
	
	});
</script>