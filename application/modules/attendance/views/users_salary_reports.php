<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template');  ?>   
<script type="text/javascript" src="<?=$theme_path?>/js/attendance.js"></script>
<div class="contentinner">
    <h4 class="widgettitle">User Salary Revision Reports </h4>           
    <div class="widgetcontent">
    		<div class="well well-small">
            	 <?php 
		 		$filter = $this->session_view->get_session(null,null);
		 		$attributes = array('class' => 'stdform editprofileform','method'=>'post');

                echo form_open('',$attributes);?>
            <table class="table responsive_table">
            	<thead>
                	<tr>
                        <th>Department &nbsp; <?php 
							
							$options = array();
							if(isset($departments) && !empty($departments))
							{
								foreach($departments as $dept)
								{
									$options[$dept["dept_id"]] = $dept["dept_name"];
								
								
								}
							}
							echo form_multiselect('filter[department][]',$options,'','class="multiselect" id="department_select"');
						?></th>
                        <th id="designation">Designation &nbsp; <?php 
						
							$options = array();
							if(isset($designations) && !empty($designations))
							{
								foreach($designations as $des)
								{
									$options[$des["id"]] = $des["name"];
								
								
								}
							}
								echo form_multiselect('filter[designation][]',$options,'','class="multiselect" id="designation_select"');
						?></th>
                     	<th>
                        	<?php 
								$options = array(''=>'Select');
								$values = array("employee_id"=>"Employee Id","first_name"=>"Name","email"=>"Email");
								foreach($values as $key => $val)
								{
									$options[$key] = $val;						
								
								}
								echo form_dropdown('filter[field]',$options,'','class="uniformselect"');
                        	?>
                        </th>
                        <th>
                        	<?php 
								$data = array(
										'name' => 'filter[value]',
										'class' =>'input-small'
								);
								echo form_input($data);
							?>
                        </th>
                        <th>
                        	<?php 
								$state = FALSE;
								if(isset($status))
									$state =  $status;
								$data = array("name"=>"inactive",
												"value"=>1,
												"class" =>"required",
												"checked" => $state
								);
								echo form_checkbox($data);
							?>&nbsp;Include inactive users
                        </th>
                        <th>
                        	<?php $data = array(
							  'name'        => 'search',
							  'value'		=> '  Search  ',
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
            </div> <?php 
					
					$options = array(10=>"10",25=>"25",50=>"50");
					$count_start = $no_of_users1[0]['count']/100;
					if($count_start<=10)
					{
						for($c=1;$c<$count_start;$c++)
						{
							$options[$c*100] = $c*100;
						}
					}
					else if($count_start>10)
					{
					
						for($c=1;$c<$count_start;)
						{
							$options[$c*100] = $c*100;
							$c+=2;
						}
					
					}
					$options["all"] = "All";
					echo "Show ".form_dropdown('record_show',$options,$count,"id='count_change'")." entries";
				?>
             <span style="float:right;" style="display:none;" id="legend">
                         <span style="background-color:#c73f38;" class="btn-rounded" >&nbsp;&nbsp;&nbsp;&nbsp;</span> - Incomplete
                   </span>
    	   <table class="table table-bordered sortable" >
        	<thead>
            	<?php //print_r($shifts);
				$head = array("Id","Employee Id","Name","Department","Designation","Email");
				$db_name = array("id","emp_id","first_name","dept_name","des_name","email");
				
				?>
            	<tr>
                	
            	<?php 
					$i =0;
					$filter = $this->session_view->get_session(null,null);
					foreach($head as $ele)
					{
						$elem_class = $elem_id = "";
						if(isset($filter["sort"])){
						if($db_name[$i] == $filter["sort"]) {
							$elem_class = "class='sort' ";
							$elem_id = "id='".$filter["order"]."' ";
						}
						}
						echo "<th ".$elem_class.$elem_id." data='".base64_encode($db_name[$i++])."'>".$ele."</th>";
					}
					if(isset($status))
					{
						echo "<th>Status</th>";
					}
				?>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
            	<?php 
					if(isset($users) && !empty($users))
					{
						$exist = 0;
						foreach($users as $user)
						{
							$class = "";
							$this->load->model('masters/user_shift_model');
							$this->load->model('masters/user_salary_model');
							$current_shift = $this->user_shift_model->get_user_current_shift_by_user_id($user["id"],null);
							$salary_group = $this->user_salary_model->get_user_salary_by_user_id($user["id"]);
							if($user["dept_name"]=="" || $user["des_name"]=="" || empty($current_shift) || empty($salary_group))
							{
								$class = "in-complete";
								$exist = 1;
							}
						?>	
							<tr class="<?=$class?>">
                            	<td class="center"><?=$user["id"]?></td>
                                <td class="center"><?=$user["employee_id"]?></td>
                                <td class="center"><?=$user['first_name']?></td>
                               <td class="center"><?=$user["dept_name"]?></td>
                               <td class="center"><?=$user["des_name"]?></td>
                                <td class="center"><?=$user['email']?></td>
                                 <?php 
									$us = "active";
									if($user["status"]==0)
										$us = "in-active";
									if(isset($status))
									{
										echo "<td class='center'>".$us."</td>";
									}
												
								
								?>
                              <td class="center">
                                <a href="<?=$this->config->item('base_url')."attendance/reports/salary_revision_reports/".$user["id"]?>" title="View" class="btn btn-success btn-rounded"><i class="icon icon-eye-open"></i></a>
                              
                                </td>
                            </tr>
						<?php 
						}
					
					}
					else
					{
						echo "<tr><td colspan='7'>No Records Found</td></tr>";
					
					}	
				?>
                
            </tbody>
        </table>
        <?php
			if(isset($users) && !empty($users))
			{
				$end=$start + count($users);
				 if($start==0)
					$start=1;
					?>
			Showing <?=$start?> to <?=$end?> of <?=$no_of_users1[0]['count']?> records
            <?php }?>
        
        
     
         <div class="button_right_align">
         <?php if(isset($links) && $links!=NULL)
					echo $links;?><br />
                     
      			</div>
       
    </div>
</div>
<script type="text/javascript">

	$(document).ready(function(){
		<?php 
			if($exist==1)
			{
		?>
				$("#legend").css("display","block");
		<?php }?>
	});
</script>