<style type="text/css">
.responsive_table .btn{padding: 4px 4px ;}
</style>
<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template');  ?>   
<script type="text/javascript" src="<?=$theme_path?>/js/attendance_reports.js"></script>
<link href="<?=$theme_path?>/css/print_page.css" rel="stylesheet" >
<div class="contentinner">
	<h4 class="widgettitle ">Monthly Attendance Reports</h4>
	<div class="widgetcontent">
    		<div class="well well-small">
            	<?php 				 
				$user_role = json_decode($roles[0]["roles"]);
		 		$filter = $this->session_view->get_session(null,null);
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
                         
                        <th>User Type &nbsp; <?php 								
							 //$options=array(''=>"Select",1=>"Weekly",2=>"Monthly");
							 $options=array(''=>"Select",2=>"Monthly");
							 $default=$user_type;
							 echo form_dropdown('user_type',$options,$default,'id="user_type" class="uniformselect user_type"');
							?>
                        </th>
                        
                        <th>Year &nbsp;
						    <?php 
							    $year = date('Y');
								$options=array(''=>'Select Year');
								for($i=2000;$i<=date('Y');$i++)
								{
									$options[$i] = $i;
								
								}
								echo form_dropdown('year',$options,$year,'id="year_select" class="input-small"');
							?>
                        </th>
                        <th>Month &nbsp;
						    <?php 
								$options=array(''=>'Select Month');
								$month_arr = array("Jan","Feb","Mar","Apr","May","June","July","Aug","Sep","Oct","Nov","Dec");
								$month = date('m');
								$default = $month;
								if($year == date('Y'))
								{																			
										for($i=0;$i<date('m');$i++)
											$options[$i+1] = $month_arr[$i];									
								}
								else
								{
									for($i=0;$i<12;$i++)
									{
										$options[$i+1] = $month_arr[$i];										
									}								
								}								
								echo form_dropdown('month',$options,$default,'id="month_select" class="input-small"');
							
							?>
                         </th>
                         <?php
						   $start_date = "";
						   if(isset($filter["start_date"])&& $filter["start_date"]!="")
						   {									
							 $start_date = date("d-m-Y",strtotime($filter["start_date"]));
						   }
						   $end_date = "";
						   if(isset($filter["end_date"])&& $filter["end_date"]!="")
						   {									
							 $end_date = date("d-m-Y",strtotime($filter["end_date"]));
						   }
						 ?>
                            <input type="hidden" name="month_start_date" id="month_start_date" value="<?=$start_date?>">
                            <input type="hidden" name="month_end_date" id="month_end_date" value="<?=$end_date?>">                         
                        <th>
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
										
          echo form_open('',$attributes);
		  ?>                
           <div class="scroll_bar">
    	   <table class="table table-bordered time-report-table sortable" >
        	<thead>
            	<?php 
				$head = array("S.No","Employee Id","Username","Employee Name","Department","Designation","Email");
				$db_name = array("id","emp_id","username","first_name","dept_name","des_name","email");
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
                <th class="action"><input type="checkbox" class="chk_all" name="select_all" /></th>
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
                                <td class="center"><input type="checkbox" class="list_box" name="user_list[<?php echo $user["id"]; ?>]" /></td>
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
     </div>   
     <div class="button_right_align">
     <?php if(isset($links1) && $links1!=NULL)
					echo $links1;?><br />      	     
             
     </div> 
     
     <div class="button_right_align" style="clear:both;">
        <input type="submit" name="view_attendance" value="View Attendance" class="btn btn-rounded btn-primary view_att" title="View Attendance" style="display:none;" /> 
     </div>
     </form>         
</div>

<script type="text/javascript">
$(document).ready(function(){		
		
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
	
	$(".chk_all").click(function(){		
	   
	   if($(this).prop("checked")==true)
	   {
		 $(".list_box").each(function(){
			$(this).attr("checked","checked");
		 });
	   }
	   else
	   {
		 $(".list_box").each(function(){
			$(this).removeAttr("checked");
		 });
	   }
	   if($(".list_box:checked").length>=1) $(".view_att").show();
	   else if($(".list_box:checked").length==0) $(".view_att").hide();
	});
	
	var list_total = $(".list_box").length;
	
	$(".list_box").click(function()
	{
	   if($(".list_box:checked").length<list_total)
	   {
		  $(".chk_all").removeAttr("checked");
	   }
	   else if($(".list_box:checked").length == list_total)
	   {
		  $(".chk_all").attr("checked","checked");
	   }
	   if($(".list_box:checked").length>=1) $(".view_att").show();
	   else if($(".list_box:checked").length==0) $(".view_att").hide();
	});
	
});
</script>
