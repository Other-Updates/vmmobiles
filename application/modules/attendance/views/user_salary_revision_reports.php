<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template');  ?>   
 <script type="text/javascript" src="<?= $theme_path; ?>/js/documents.js"></script>
  <link href="<?=$theme_path?>/css/print_page.css" rel="stylesheet" >
  <style type="text/css">.hide_title{display:none;}
	 @media print 
	{
		@page{ size : portrait;}
	}
	.table th, .table td{ padding:15px 5px;}
  </style>
<div class="contentinner">
            	 <h4 class="widgettitle align_center show_title">SERVICE RECORD</h4>
                 
                <div id="cmp_name"><?php  if(isset($settings) && !empty($settings)) echo strtoupper($settings[0]['value'].','.$place[0]['value']);?></div>         
                <h4 class="widgettitle align_center hide_title">SERVICE RECORD</h4>
                <br>
                <table cellspacing="10" class="table table-bordered print_border revision_table" style="font-size:11px; width:100%;"  >
                <thead>
                <tr>
                <th width="38%" id="tex_left">Name and address of the Contractor</th>
                <th width="2%">:</th>
                <th colspan="3">
				<?php  if(isset($user) && !empty($user)){
				
						echo $user[0]['first_name'];
						if($user[0]['last_name']!="")
							echo " ".$user[0]['last_name'];
						if(isset($address) && !empty($address))
						{
							if($address[0]['city']!="")
								echo "  ,".$address[0]['city'];
						
						}
				}?>
                </th>
                </tr>
                <tr>
                <th id="tex_left">Name and address of the Establishment under which migrant for men or employee</th>
                <th valign="top">:</th>
                <th colspan="3"></th>
                </tr>
                <tr>
                <th id="tex_left">Name and address of principal employee</th>
                <th>:</th>
                <th colspan="3"></th>
                </tr>
                <tr>
                <th id="tex_left">Nature and location of work</th>
                <th>:</th>
                <th colspan="3"></th>
                </tr>
                <tr>
                <th id="tex_left">Name and address of the migrant workman</th>
                <th>:</th>
                <th colspan="3"></th>
                </tr>
                <tr>
                <th id="tex_left">Age or Date of Birth</th>
                <th>:</th>
                <th colspan="3"><?php
					 if(isset($user) && !empty($user)){
						if($user[0]['dob']!="")
							echo date('d-m-Y',strtotime($user[0]['dob']));
				}
				?></th>
                </tr>
                <tr>
                <th id="tex_left">Identification mark</th>
                <th>:</th>
                <th colspan="3"><?php 
							//print_r(array_filter($identification));
							if(isset($identification) && !empty($identification)){
								$i=0;
								foreach($identification as $val)
								{
									$i++;
									if($val["identification_mark"]!=""){
										echo $val["identification_mark"];
										if($i!=count($identification))
											echo ",";
									}
								}
							
							}
					
				?></th>
                </tr>
                <tr>
                <th id="tex_left">Father's / Husband's Name</th>
                <th>:</th>
                <th colspan="3"><?php if(isset($family) && !empty($family))
							{
								echo $family[0]["name"];
							
							}
						?></th>
                </tr>
                <tr>
                <th id="tex_left">Date of Joining</th>
                <th>:</th>
                <th width="16%"><?php 
					if(isset($history) && !empty($history))
					{
						foreach($history as $uh)
						{
							if($uh["type"]=="doj")
							{
								echo date('d-m-Y',strtotime($uh['date']));
							}
						
						}
					
					}
				
				?></th>
                <th width="19%">Date of Leaving</th>
                <th width="25%"><?php 
					if(isset($history) && !empty($history))
					{
						foreach($history as $uh)
						{
							if($uh["type"]=="dol")
							{
								echo date('d-m-Y',strtotime($uh['date']));
							}
						
						}
					
					}
				
				?></th>
                </tr>
                </thead>  
                </table>
                <br>
                <table class="table table-bordered print_border revision_table" style="font-size:11px;" id="dyntable">
                <thead>
                <tr>
                <th>Revision Date</th>
                <th>Gross Wage</th>
                <th>Total Allowances</th>
                <th>Total Deductions</th>
                <th>Net Amount</th>
                <th>Signature</th>
                <th>Remarks</th>
                </tr>
                </thead>
                <tbody>
                <?php 
				
				$total = array();
				if(isset($user_salary) && !empty($user_salary)):
					$i=0;
					foreach($user_salary as $us_val)
					{
						if($i==0)
							$total[$us_val['basic']] = $us_val;
						else
						{
							if(!isset($total[$us_val['basic']])&& empty($total[$us_val['basic']]))
							{
								$total[$us_val['basic']] = $us_val;
							}
						}
						$i++;
					}
					
				endif;
				
					/*$unique = array_map('unserialize', array_unique(array_map('serialize', $user_salary)));*/
					/*print_r($total);
					exit;*/
					if(isset($total) && !empty($total)):
						foreach($total as $us_val)
						{
				?>
                <tr>
                <td><?=date('d-m-Y',strtotime($us_val["revised_date"]));?></td>
                <td><?=$us_val['basic']?></td>
                <?php 
						$total_all = 0;
						$total_dedu =0;
						if(isset($salary_group[$us_val["salary_group"]])&& !empty($salary_group[$us_val["salary_group"]]))
						{
							foreach($salary_group[$us_val["salary_group"]] as $grp)
							{
								$new_value = 0;
								if($grp['percentage']==1)
								{
									$new_value = $grp['value']/100*$us_val['basic'];
								
								}
								else
								{
									$new_value = $grp['value'];
								}
								if($grp['deduction']==0)
								{
									$total_all = $total_all + $new_value;
								}
								else
								{
									$total_dedu = $total_dedu + $new_value;
								}
							}
						
						}	
				
					?>
                <td><?=$total_all?></td>
                <td><?=$total_dedu?></td>
                <td><?php $net_amount = $us_val['basic']+$total_all-$total_dedu;
						echo $net_amount;
				
				?></td>
                <td></td>
                <td></td>
                </tr>
               <?php 
			   		}
			   endif;?>
                </tbody>
                </table>
                <table width="100%" border="1">
                <tr><td>&nbsp;</td><td></td><td></td></tr>
                <tr><td>&nbsp;</td><td></td><td></td></tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td style="float:right; padding-right:30px;"><strong>Authorised Signature</strong></td>
                  </tr>
                  <tr><td>&nbsp;</td><td></td><td></td></tr>
                </table>

                <div class="button_right_align">
                <?php if(isset($_GET['doc']))
					{?>
                    <a href="<?=$this->config->item('base_url')."documents/print_document/".$user_id?>" title="Back"><input type="button" class="btn btn-rounded btn-info" value="Back" /></a>
                    <a href="javascript:void(0)" id="print" title="Print"><input type="button" class="btn btn-warning btn-rounded" value="Print" /><i class="icon icon-print print_icon"></i></a>
                    <?php }
					else
					{?>
	            	<a href="<?=$this->config->item('base_url')."attendance/reports/users_salary_revision_reports"?>" title="Back"><input type="button" class="btn btn-rounded btn-info" value="Back" /></a>
					<?php }?>
             	</div>
            </div><!--contentinner-->
        