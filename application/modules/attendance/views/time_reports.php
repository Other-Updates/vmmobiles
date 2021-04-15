<style type="text/css">
/*.responsive_table .btn{padding: 4px 4px ;}*/
.headerpanel
{
	width:100%;
}
</style>
<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template');  ?>   
<script type="text/javascript" src="<?= $theme_path; ?>/js/wage_slip.js"></script>
<link href="<?=$theme_path?>/css/print_page.css" rel="stylesheet" >
<div class="contentinner">
	<h4 class="widgettitle ">Time Reports</h4>
	<div class="widgetcontent">
    		<div class="well well-small">
            	<?php 				 
				$user_role = json_decode($roles[0]["roles"]);
		 		$filter = $this->session_view->get_session(null,null);
				//print_r($user_role);
		 		$attributes = array('class' => 'stdform editprofileform','method'=>'post');
                echo form_open('',$attributes);?>
            <table class="table responsive_table tds_button">
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
							//print_r($options);
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
                         
                          <th> User Type &nbsp; <?php 								
								$options=array(''=>"Select",1=>"Weekly",2=>"Monthly");
								$default=$user_type;
								echo form_dropdown('user_type',$options,$default,'id="user_type" class="uniformselect user_type"');
							?>
                            </th>
                            <th>
                                From Date <span class="req">*</span>&nbsp;&nbsp;
                        	    <?php							    
								$default = '';
								if(isset($filter["start_date"])&& $filter["start_date"]!="")
								{									
									$default = date("d-m-Y",strtotime($filter["start_date"]));
								}
								$data = array(
								        'id' => 'start-date',
										'name' => 'start_date',
										'class' =>'input-medium date-picker',
										'readonly'=>'readonly',
										'value' =>$default
								);
								echo form_input($data);
							    ?>
                                </th>
                                <th>
                                &nbsp;To Date <span class="req">*</span>&nbsp;&nbsp;
                                <?php 
								$default = '';
								if(isset($filter["end_date"])&& $filter["end_date"]!="")
								{									
									$default = date("d-m-Y",strtotime($filter["end_date"]));
								}
								$data = array(
								 		'id' => 'end-date',
										'name' => 'end_date',
										'class' =>'input-medium date-picker',
										'readonly'=>'readonly',
										'value' =>$default
								);
								echo form_input($data);
							    ?>
                            </th>
                      
                         
                        <th>
                        <br />
                        	<?php $data = array(
							  'id' 			=> 'search',
							  'name'        => 'search',
							  'value'		=> 'Search',
							  'class'		=>'btn btn-warning btn-rounded',
							  'title'		=>'Search',
							  'id'			=>'search'
							);
					
					 		echo form_submit($data);?>
                        </th>
                        <th>
                        <br />
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
					echo "Show ".form_dropdown('record_show',$options,$count,"id='count_change'")." entries";
				?>
                
           <div class="scroll_bar">
    	   <table class="table table-bordered time-report-table sortable" >
        	<thead>
            	<?php //print_r($shifts);
				$head = array("S.No","Employee Id","Username","Employee Name","Department","Designation","Email");
				$db_name = array("id","emp_id","username","first_name","dept_name","des_name","email");
				//print_r($users);
				?>
            	<tr>
                	
            	<?php 
					$i =0;
					$id_sort =0;
					$filter = $this->session_view->get_session(null,null);
					foreach($head as $ele)
					{
						$elem_class = $elem_id = "";
						if(isset($filter["sort"])){
						if($db_name[$i] == $filter["sort"]) {
							$elem_class = "class='sort' ";
							$elem_id = "id='".$filter["order"]."' ";
							if($filter["sort"]=="id" && $filter["order"]=="desc")
								$id_sort =1;
						}
						}
						echo "<th ".$elem_class.$elem_id." data='".base64_encode($db_name[$i++])."'>".$ele."</th>";
					}
					if($id_sort == 1)
						$s = count($no_of_users1)-$start_page;
					else
						$s = $start_page +1;
					
				?>              
                <?php				
				if(in_array("reports:view_time_reports",$user_role) && isset($users) && !empty($users)){?>
               <th class="action">
                 <?php 						
						$data = array(
						"class" =>"required group_check",
						"checked" => FALSE
					);
					echo form_checkbox($data);
				?>
                </th>
            <?php } ?>
                </tr>
            </thead>
            <tbody>
            	<?php 
					$enter = 0;
					if(isset($users) && !empty($users))
					{	
						foreach($users as $user)
						{			
								$time_report_data = array("user_id"=>$user["id"],"date_from"=>$filter["start_date"],"date_to"=>$filter["end_date"]);								
						?>	
							<tr>                           
                            	<td class="center"><?php echo $id_sort == 1?$s--:$s++;?></td>
                                <td class="center"><?=$user["employee_id"]?></td>
                                <td class="center"><?=$user['username']?></td>
                                <td class="center"><?=ucwords($user['first_name'])." ".ucwords($user['last_name'])?></td>
                                <td class="center"><?=ucwords($user["dept_name"])?></td>
                                <td class="center"><?=ucwords($user["des_name"])?></td>
                                <td class="center"><?=$user['email']?></td>                                                    
                                <?php if(in_array("reports:view_time_reports",$user_role)){ ?>
                                <td class="center">
                              	<?php 
									$data = array(
															"value" => $user["id"],
															"class" =>"required single_check",
															"checked" => FALSE
											);
											echo form_checkbox($data);
											echo "<input type='hidden' disabled='disabled'  class = 'time_report_data' name='time_report_data[".$user["id"]."]' value='".json_encode($time_report_data)."'>";
                                   ?>       
                                </td>
                                <?php }?>
                            </tr>
						<?php } ?>                 
						<?php
					}
					else
					{	
						if(in_array("reports:view_time_reports",$user_role) && isset($users) && !empty($users))
						{									 
							echo "<tr><td colspan='8'>No Records Found</td></tr>";
						}
						else
						{
							echo "<tr><td colspan='7'>No Records Found</td></tr>";
						}
						
					}
				?>
                
            </tbody>
        </table>
        </div>
           <?php
			if(isset($users) && !empty($users))
			{
				$end=$start_page + count($users);
					$start_page = $start_page+1;
					?>
			Showing <?=$start_page?> to <?=$end?> of <?=count($no_of_users1)?> records
            <?php }?> 
     
     <div class="button_right_align">
     <?php if(isset($links1) && $links1!=NULL)
					echo $links1;?><br />      
     	 <?php if(in_array("reports:view_time_reports",$user_role)){ ?>    
         <a href="javascript:void(0);" ><input type="submit" class="btn btn-success btn-rounded"  value="View Time Report"  name = "time_report" style="display:none; float:right;" id="time_report"/></a>
         <?php } ?>
     </div>
      
    </div>     
</div>
<script type="text/javascript">

$(document).ready(function(){		
		
	$(".group_check").click(function(){				
			if($(this).is(":checked"))
			{
				$(".single_check").attr("checked","checked");
				$(".time_report_data").removeAttr("disabled");			
			}
			else
			{
				$(".single_check").removeAttr("checked");
				$(".time_report_data").attr("disabled","disabled");			
			}		
			
		});
});
	
	$(".single_check").live('click',function(){
		if($(this).is(":checked"))
			{
			$(this).next().removeAttr("disabled");
			}
			else
			{
			$(this).next().attr("disabled","disabled");
			}
	});
	
	$(".group_check,.single_check").live('click',function(){
		var count=0;
		var total=0;				
		$(".single_check:checked").each(function(){
		count++;
		});			
		if(count>=1) {
		  $("#time_report").css("display","block");	}
		else {
		  $("#time_report").css("display","none");	}
		
		$(".single_check").each(function(){
		total++;	});
		if(count<total)
		{	$(".group_check").removeAttr("checked");	}	
	});
	$("#search").click(function(){
	var s_date = $.trim($("#start-date").val());
	var e_date = $.trim($("#end-date").val());	
	if(s_date == "" && e_date == "")
	{
	   alert("Start and End date is required");
	   return false;
	}
	else if(s_date == "")
	{
	   alert("Start date is required");
	   return false;
	}
	else if(e_date == "")
	{
	   alert("End date is required");
	   return false;
	}
	});
	$(".date-picker").datepicker({dateFormat:'d-m-yy',changeYear: true,maxDate:0,yearRange: '1945:'+(new Date).getFullYear()});
	
	$("#end-date,#start-date").on('change',function(){							 
	var start_date = $("#start-date").val().split("-");
	var end_date = $("#end-date").val().split("-");	
	var st = new Date(start_date[2],start_date[1]-1,start_date[0]);
	var end = new Date(end_date[2],end_date[1]-1,end_date[0]);
	if(st>end){		
    alert("To date must be equal/greater than from date");
	$("#end-date").val('');
	}							 
	});	
	
	$(".reset").click(function(){		
		$.ajax({
		   	url : BASE_URL + "api/reset_session/",
			type : "POST",
			data : {class:ct_class,method:ct_method},
			success:function(res)
			{				
				window.location = window.location.pathname;
			}
		   });
	});
</script>