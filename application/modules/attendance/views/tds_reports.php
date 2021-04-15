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
<div class="contentinner mb-125">
			<?php
				//print_r($allowance);
			$filter = $this->session_view->get_session(null,null);
		 	$attributes = array('class' => 'stdform editprofileform','method'=>'post');

                echo form_open('',$attributes);?>
            	<h4 class="widgettitle">TDS Reports</h4>
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
                           
                          
                            <th>
                        	<?php 
								$options = array(''=>'Select');
								$default ='';							
								$values = array("access_id"=>"Access Id","blood_group"=>"Blood group","email"=>"Email","employee_id"=>"Employee Id","gender"=>"Gender","marital_status"=>"Marital status","mobile"=>"Mobile no","religion"=>"Religion","username"=>"Username");
								if(isset($filter["field"])&& !empty($filter["field"]))
								{
									$default = $filter["field"];
								
								}
								foreach($values as $key => $val)
								{
									$options[$key] = $val;							
								}
								echo form_dropdown('field',$options,$default,'class="uniformselect"');
                        	?>
                        </th>
                       <th>
                        	<?php 
								$default = '';
								if(isset($filter["value"])&& $filter["value"]!="")
								{
									$default = $filter["value"];
								
								}
								$data = array(
										'name' => 'value',
										'class' =>'input-medium',
										'value' =>$default										
								);
								echo form_input($data);
							?>
                        </th>
                          <th>Year &nbsp;<?php $options=array(''=>'Select Year');
								
								for($i=2000;$i<=date('Y')+1;$i++)
								{
									$options[$i] = $i;
								
								}
								echo form_dropdown('year',$options,$year,'id="year_select" class="input-small"');
							?></th>
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
							
					$month_arr = array("Jan","Feb","Mar","Apr","May","June","July","Aug","Sep","Oct","Nov","Dec");
				?>
                 <input type="hidden" name="start_date" id="start_date" value="<?=$start_date?>">
                <table class="table table-bordered  wage_res">                
                <tr>
                <td>Name of the Company : <strong><?php if(isset($company_name) && $company_name!="") echo $company_name;?></strong></td>
                <td>Place : <strong><?php if(isset($place) && $place!="") echo $place;?></strong></td>
                <td>District : <strong><?php if(isset($district) && $district!="") echo $district;?></strong></td>
                <td colspan="4">Year of <strong><?=$year;?></strong></td>
                </tr>
                </table>          
    <br>
 			 <div id="table_scroll">
                <table class="table table-bordered print_border incentive_table"  style="font-size:10px;">
                    <thead>
                        <tr>
                            <th rowspan="3">S.No</th>
                        	<th rowspan="3">Name of the Worker</th>
                            <?php 
								for($t=0;$t<count($start_date_arr);$t++)
								{
									echo '<th colspan="2"  rowspan="1">'.$month_arr[$t].'</th>';
								
								}
							?>
                            <th colspan="2"  rowspan="1">Total</th>
                        </tr>
                        <tr>
                         <?php 
							for($t=0;$t<count($start_date_arr);$t++)
							{
							?>
                                <th>Rs.</th>
                                <th>P.</th>  
                         <?php 
						 	}?> 
                              <th>Rs.</th>
                              <th>P.</th>                 
                        </tr>
                           
                            </thead>
                            <tbody>
                            <?php
							$s = $start_page +1;
							if(isset($users) && !empty($users)):
							$col_array = array();
							
							for($k=0;$k<count($users);$k++){
								$row_array = array();
							?>
                            <tr>
                            <td class="center"><?=$s++?></td>
                            <td class="center"><?=$users[$k]['first_name']?></td>
                            <?php 
							for($t=0;$t<count($start_date_arr);$t++)
							{
								$start_date_in_sec = strtotime($start_date_arr[$t]);
							
								$end_date_in_sec = strtotime($end_date_arr[$t]);
								
								if(strtotime($user_doj[$k][0]['date'])<=$end_date_in_sec)
								{
								
									$cur_year = $year;
							
									$cur_mon = date('m',$start_date_in_sec);
									
									$month_tds= $this->tds_model->get_user_tds_by_month_year($users[$k]["id"],$cur_year,$cur_mon);	
                            
									$tds_amount  = 0.0;
									
                            		if(isset($month_tds) && !empty($month_tds))
									{
								
										$tds_amount = $month_tds[0]['amount'];

										$row_array[] = round($tds_amount,2);
									
										$col_array[$t][] = round($tds_amount,2);
									}
									
							?>
                                <td class="center">
                                    <?php 
                                    //print_r($allowance);
                                        $new_val = array();
									if(isset($month_tds) && !empty($month_tds))
									{
                                        $new_val = explode('.',round($tds_amount,2));
                                        echo $new_val[0];
									}
									else
										echo "-";                                    ?>
                                </td>
                                <td class="center"><?php if(isset($new_val[1]))
                                        echo (strlen($new_val[1])==1 ? ($new_val[1]*10) : $new_val[1]);
                                        else
                                        echo "-"; ?>
                                </td>
                            <?php 
								}
								else
									echo "<td class='center'>-</td><td class='center'>-</td>";
								
							}
								?>
                            <td class="center"><?php 
							$total = 0;
							$total = array_sum($row_array);
							$tot_val = array();
							$col_array[count($start_date_arr)][$k] = $total;
							$tot_val = explode('.',$total);
							echo $tot_val[0];
							?></td>
                            <td class="center">
                            <?php 
								if(isset($tot_val[1]))
									echo (strlen($tot_val[1])==1 ? ($tot_val[1]*10) : $tot_val[1]);
                                else
                                    echo "-"; 
							?>

                            </td>                          
                            </tr>
                           <?php 
						   //exit;
						  }
						echo "<tr><th colspan='2' class='center'>TOTAL</th>";
						for($t=0;$t<=count($start_date_arr);$t++)
						{
							$total_col = 0;
							if(isset($col_array[$t]))
								$total_col = explode('.',array_sum($col_array[$t]));
							
							if($total_col !=0)
								echo "<th>".$total_col[0]."</th><th>";
							else
								echo "<th>-</th><th>";
								
							if(isset($total_col[1]))
								echo (strlen($total_col[1])==1 ? ($total_col[1]*10) : $total_col[1]);
							else
								echo "-"; 
							echo "</th>";
						}
						
						 endif;
						 if(empty($users))
						  {
						  	
						  	echo "<tr><td colspan='28' class='center'>No Results Found</td></tr>";
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
                
             <input type="hidden" id="month_starting_date" value="<?=$month_starting_date?>"/>
            </div><!--contentinner-->
            
            <?php 
	


?>
<script type = "text/javascript">
	
	$(document).ready(function(){
		var year;
		var year_start="";
		var year_end = "";
		var d =new Date();
		$("#year_select").change(function(){
			year = $(this).val();
			var next_year = (+year) + (+1);
			//alert(next_year);
			if(year!="")
			{
				
				year_start = year+"-1-"+ $("#month_starting_date").val();
				
				/*if(year!=d.getFullYear())
				{
					if($("#month_starting_date").val()!=1)
						year_end = parseInt($("#month_starting_date").val()-1)+"-1-"+next_year;
						
					else
						year_end = "31-12-"+year;
				}
				else
				{
					cur_month =  d.getMonth()+1;
					
				}*/
			}
			$("#start_date").val(year_start);
			//$("#end_date").val(year_end);
		});
		
	});
		
</script>
