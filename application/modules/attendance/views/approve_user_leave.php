<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template');  ?> 

<script type="text/javascript" src="<?=$theme_path?>/js/userleaves.js"></script>
<div class="contentinner">
    <h4 class="widgettitle">User Leaves </h4>           
    <div class="widgetcontent">
    		<div class="well well-small">
            	
    		<?php $result = validation_errors();
			 if(trim($result)!=""):?>
    		<div class="alert alert-error">
                	<button data-dismiss="alert" class="close" type="button">&times;</button>
                       		<?php echo implode("</p>",array_unique(explode("</p>", validation_errors()))); ?>

             </div>
           <?php endif;?>
           <?php $attributes = array('class' => 'stdform editprofileform','method'=>'post');
				
                echo form_open('',$attributes);?>
           <table class="table alert alert-success">
           	<thead>
            	<tr>
                	<th>Available Casual Leave : <?php  if(isset($available[0]['available_casual_leave'])):
													if($available[0]['available_casual_leave']<0) echo 0;
													else 
														echo $available[0]['available_casual_leave'];
													endif;?></th>
                   <th>Available Sick Leave : <?php if(isset($available[0]['available_sick_leave'])):
				   									if($available[0]['available_sick_leave']<0) echo 0;
				   									else echo $available[0]['available_sick_leave'];
													endif;?></th>
                    <th>Available Comp Off : <?php echo isset($available[0]['comp_off'])&& $available[0]['comp_off']!=""?$available[0]['comp_off']:0; ?></th>
                     <th>Available Permission(in Hours) : <?php if($available[0]['permission']<0) echo 0;
													else 
														echo $available[0]['permission'];?></th>
                </tr>
            </thead>
           </table>
          
           </div>
           <table width="100%" border="0" >
                	
                <tbody><tr>
                  
                  <td>	<?php echo form_label('Select Year');?></td>
                  <td>
                  <p>
                        
                            <span class="field">
                         
                            <?php $options=array(''=>'Select Year');
								
								for($i=2000;$i<=date('Y');$i++)
								{
									$options[$i] = $i;
								
								}
								if(date('m')==12)
								{
									$option[date('Y')+1] = date('Y')+1;
								}
								if(isset($_POST["go"]))
									$default = $year;
								else
									$default = date('Y');
								echo form_dropdown('year',$options,$default,'id="year_select"');
							?>
                            
                          
                            </span>
                        </p>
                  </td>
                  <td>
                
                        <?php echo form_label('Select Month');?></td>
                        <td>
                         <p> 
                            <span class="field">
                           <?php 
								//echo date('m');
							$month_arr = array("Jan","Feb","Mar","Apr","May","June","July","Aug","Sep","Oct","Nov","Dec");
							$options=array(''=>'Select Month');
								
							if(isset($_POST["go"]))
							{
									$default = $month;
									if(date('m')==12)
									{
										$option[date('Y')+1] = date('Y')+1;
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
									$month =  date('m');
									if(date('m')==12)
									{
										for($i=0;$i<3;$i++)
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
									$default = date('m');	
								}
								//print_r($default);
								//$options[$default] = $month_arr[$default-1];
								echo form_dropdown('month',$options,$default,'id="month_select"');
							?>
                            
                            </span>
                        </p>
                  </td>
                  <td width="3%">&nbsp;</td>
                  <td><input type="submit" name="go" value="Go" id="go" class="btn btn-info border4"></td>
                </tr>
              </tbody></table>	
              <div id="tabs">
                    <ul>
                    	<li ><a href="#tabs-1">New</a></li>
                         <li ><a href="#tabs-2">Hold</a></li>
                        <li ><a href="#tabs-3">Approved</a></li>
                        <li ><a href="#tabs-4">Reject</a></li>
                     </ul>
                 <div id="tabs-1">
    	   <table class="table table-bordered" style="width:98%">
        	<thead>
            	<?php //print_r($shifts);
			
					$head = array("S No","Leave From","Leave To","Reason","Leave type","Applied by","LOP","Status");
					
				?>
            	<tr>
                	
            	<?php 
					foreach($head as $ele)
					{
						echo "<th>".$ele."</th>";
					}
					if($status[0]["status"]==1 && !isset($_GET["us"]))
						echo "<th>Action</th>";
				?>
                </tr>
            </thead>
            <tbody>
            	<?php 
					if(isset($new) && !empty($new))
					{
						$i=0;
						foreach($new as $n)
						{
						?>	
							<tr>
                            	<td class="center"><?=++$i?></td>
                            	<td class="center"><?=$n["date_from"]?></td>
                                <td class="center"><?=$n["date_to"]?></td>
                                <td class="center"><?=ucwords($n['reason'])?></td>
                                <td class="center">	<?=ucwords($n["type"])?></td>
                                <td class="center"><?php if($n["applied_by_name"]!="") echo $n["applied_by_name"];?></td>
                                <td class="center"><?php										
									$lop =FALSE;
									if($n["lop"]==1) $lop =TRUE;
									if($status[0]["status"]==1)
									{
										$data = array(
												"id" => 'lop_'.$n["id"],
												"name" =>'lop['.$n["id"].']',
												"checked" => $lop
										);
										echo form_checkbox($data);
									}
									else if($status[0]["status"]==0)
									{
										if($lop)
											echo "<i class='icon icon-check'></i>";
										else
											echo "-";
									}?>
								</td>
                                <td class="center">
                                	<?php 
										if($status[0]["status"]==1  && !isset($_GET["us"]))
										{
											$options = array(
													0=>"New",
													3=>"Hold",
													1=>"Approved",
													2=> "Reject"
											);
											echo form_dropdown('approved['.$n["id"].']',$options,$n["approved"],"id='approved_".$n["id"]."'");
										}
										else
										{
											echo "New";
										}
									?>
                                </td>
                                <?php if($status[0]["status"]==1  && !isset($_GET["us"]))
									{?>
                              <td class="center">
                              	<?php //if($month == date('m')){
									
								//}
									$data = array(
											"name" => "save[".$n["id"]."]",
											"id" =>"save_".$n["id"],
											"content" => "Save",
											"class" =>"save btn btn-success btn-rounded",
											'title'	=>'Save'
											
									);
									echo form_button($data);
								?>
                                </td>
                                <?php }?>
                            </tr>
						<?php 
						}
					
					}
					else
					{
						if($status[0]["status"]==1)
									
							echo "<tr><td colspan='9'>No Records Found</td></tr>";
						else
							echo "<tr><td colspan='8'>No Records Found</td></tr>";
					}	
				?>
                
            </tbody>
        </table>
        </div>
         <div id="tabs-2">
          <table class="table table-bordered" style="width:98%">
        	<thead>
            	<?php //print_r($shifts);
			
					$head = array("S no","Leave From","Leave To","Reason","Leave type","Applied by","LOP","Status");
				?>
            	<tr>
                	
            	<?php 
					foreach($head as $ele)
					{
						echo "<th>".$ele."</th>";
					}
					if($status[0]["status"]==1  && !isset($_GET["us"]))
					{
						echo "<th>Action</th>";
					}
				?>
                </tr>
            </thead>
            <tbody>
            	<?php 
					if(isset($hold) && !empty($hold))
					{
						$i=0;
						foreach($hold as $h)
						{
						?>	
							<tr>
                            	<td class="center"><?=++$i?></td>
                            	<td class="center"><?=$h["date_from"]?></td>
                                <td class="center"><?=$h["date_to"]?></td>
                                <td class="center"><?=ucwords($h['reason'])?></td>
                               <td class="center">	<?=ucwords($h["type"])?>
                                </td>
                                <td class="center"><?php if($h["applied_by_name"]!="") echo $h["applied_by_name"];?></td>
                                <td class="center"><?php 
									$lop =FALSE;
									if($h["lop"]==1) $lop =TRUE;
									if($status[0]["status"]==1)
									{
										$data = array(
												"id" => 'lop_'.$h["id"],
												"name" =>'lop['.$h["id"].']',
												"checked" => $lop
										);
										echo form_checkbox($data);
									}
									else
									{
										if($lop)
											echo "<i class='icon icon-check'></i>";
										else
											echo "-";
									
									
									}?>
								</td>
                                <td class="center">
                                	<?php 
										if($status[0]["status"]==1  && !isset($_GET["us"]))
										{
											$options = array(
													3=>"Hold",
													1=>"Approved",
													2=> "Reject"
											);
											echo form_dropdown('approved['.$h["id"].']',$options,$h["approved"],"id='approved_".$h["id"]."'");
										}
										else
											echo "Hold";
									?>
                                </td>
                                <?php if($status[0]["status"]==1  && !isset($_GET["us"]))
									{?>
                              <td class="center">
                              	<?php //if($month == date('m')){
									
								//}
									$data = array(
											"name" => "save[".$h["id"]."]",
											"id" =>"save_".$h["id"],
											"content" => "Save",
											"class" =>"save btn btn-success btn-rounded",
											"title"	=>"Save"
											
									);
									echo form_button($data);
								?>
                                </td>
                                <?php }?>
                            </tr>
						<?php 
						}
					
					}
					else
					{
						if($status[0]["status"]==1)
						
							echo "<tr><td colspan='9'>No Records Found</td></tr>";
						else
							echo "<tr><td colspan='9'>No Records Found</td></tr>";
					}	
				?>
                
            </tbody>
        </table>
        
         </div>
          <div id="tabs-3">
          	<table class="table table-bordered" style="width:98%">
        	<thead>
            	<?php //print_r($shifts);
			
					$head = array("S no","Leave From","Leave To","Reason","Leave type","Applied by","LOP","Approved by","Status");
				?>
            	<tr>
                	
            	<?php 
					foreach($head as $ele)
					{
						echo "<th>".$ele."</th>";
					}
				?>
                </tr>
            </thead>
            <tbody>
            	<?php 
					if(isset($approved) && !empty($approved))
					{
						$i=0;
						foreach($approved as $app)
						{
						?>	
							<tr>
                            	<td class="center"><?=++$i?></td>
                            	<td class="center"><?=$app["date_from"]?></td>
                                <td class="center"><?=$app["date_to"]?></td>
                                <td class="center"><?=ucwords($app['reason'])?></td>
                               <td class="center">	<?=ucwords($app["type"])?>
                                </td>
                                <td class="center"><?php if($app["applied_by_name"]!="") echo $app["applied_by_name"];?></td>
                                <td class="center"><?php 
									$lop =FALSE;
									if($app["lop"]==1) $lop =TRUE;
									if($lop)
										echo "<i class='icon icon-check'></i>";
									else
										echo "-";
										
									?>
								</td>
                                <td class="center">
                                <?php echo $app["approved_by_name"]?>
                                </td>
                                <td class="center">
                                	<?php 
										echo 'Approved';
									?>
                                </td>
                              
                            </tr>
						<?php 
						}
					
					}
					else
					{
						echo "<tr><td colspan='9'>No Records Found</td></tr>";
					
					}	
				?>
                
            </tbody>
        </table>
        
          </div>
           <div id="tabs-4">
           		<table class="table table-bordered" style="width:98%" >
        	<thead>
            	<?php //print_r($shifts);
			
					$head = array("S no","Leave From","Leave To","Reason","Leave type","Applied by","Rejected by","Status");
				?>
            	<tr>
                	
            	<?php 
					foreach($head as $ele)
					{
						echo "<th>".$ele."</th>";
					}
				?>
                </tr>
            </thead>
            <tbody>
            	<?php 
					if(isset($reject) && !empty($reject))
					{
						$i=0;
						foreach($reject as $rej)
						{
						?>	
							<tr>
                            	<td class="center"><?=++$i?></td>
                            	<td class="center"><?=$rej["date_from"]?></td>
                                <td class="center"><?=$rej["date_to"]?></td>
                                <td class="center"><?=ucwords($rej['reason'])?></td>
                               <td class="center">	<?=ucwords($rej["type"])?>
                                </td>
                                <td class="center"><?php if($rej["applied_by_name"]!="") echo $rej["applied_by_name"];?></td>
                                
                                <td class="center">
                                <?php echo $rej["approved_by_name"]?>
                                </td>
                                <td class="center">
                                	<?php 
										echo 'Rejected';
									?>
                                </td>
                              
                            </tr>
						<?php 
						}
					
					}
					else
					{
						
						echo "<tr><td colspan='8'>No Records Found</td></tr>";
					
					}	
				?>
                
            </tbody>
        </table>
        
           </div>
           </div>
         <?php
		 	if(!isset($filter))
			{
				if(isset($users) && !empty($users))
				{
				$end=$start + count($users);
				 if($start==0)
					$start=1;
					?>
			Showing <?=$start?> to <?=$end?> of <?=$no_of_users[0]['count']?> records
		  <?php  }
		  }
		  ?>
      <div class="button_right_align">
     
       
 <?php if(isset($links) && $links!=NULL)
            echo $links;?><br />
             <a href="<?=$this->config->item('base_url')."attendance/leave/approve_user_leaves/"?>"  title="Back"><input type="button" class="btn btn-defaultback border4" value="Back" /></a> 
        </div>
     
    </div>
   
</div>
<script type="text/javascript">
	$(document).ready(function(){
		
			$(".multiselect").multiselect({
				includeSelectAllOption: true,
				 enableFiltering: true
			});
	
	
	});
</script>