<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
 <style type="text/css">
 	.text_right
	{
		text-align:right;
	}
        .box, .box-body, .content { padding:0; margin:0;border-radius: 0;}
	#top_heading_fix h3 {top: -57px;left: 6px;}
	#TB_overlay { z-index:20000 !important; }
	#TB_window { z-index:25000 !important; }
	.dialog_black{ z-index:30000 !important; }
	#boxscroll22 {max-height: 291px;overflow: auto;cursor: inherit !important;} 
.auto-asset-search ul#country-list li:hover {
    background: #c3c3c3;
    cursor: pointer;<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
 <style type="text/css">
 	.text_right
	{
		text-align:right;
	}
        .box, .box-body, .content { padding:0; margin:0;border-radius: 0;}
	#top_heading_fix h3 {top: -57px;left: 6px;}
	#TB_overlay { z-index:20000 !important; }
	#TB_window { z-index:25000 !important; }
	.dialog_black{ z-index:30000 !important; }
	#boxscroll22 {max-height: 291px;overflow: auto;cursor: inherit !important;} 
.auto-asset-search ul#country-list li:hover {
    background: #c3c3c3;
    cursor: pointer;
}
.auto-asset-search ul#country-list li {
    background: #dadada;
    margin: 0;
    padding: 5px;
    border-bottom: 1px solid #f3f3f3;
}
ul li {
    list-style-type: none;
}
 </style>
<div class="mainpanel">
            <!--<div class="pageheader">
                <div class="media">
                    <div class="pageicon pull-left">
                        <i class="fa fa-quote-right iconquo"></i>
                    </div>
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                            <li>Home</li>
                            <li>View</li>
                        </ul>
                          
                         <h4>View Quotation</h4>                    
                    </div>
                </div>
            </div>-->
             <div class="media mt--40">
                 <h4 class="hide_class">View Paid Service
              </h4>
             </div>
            <div class="contentpanel enquiryview  ptpb-10  viewquo mb-45 mt-top2">
            
        
                 <?php       
                    //echo '<pre>';
                   //print_r($quotation);
                    if(isset($quotation) && !empty($quotation))
                    {
                            foreach($quotation as $val)
                            {   
                                    ?>
                <table  class="table table-striped table-bordered responsive dataTable no-footer dtr-inline tablecolor">
                 <tr>
   			       <td><span  class="tdhead">TO,</span>
      				 <div><b><?php echo $val['store_name'];?></b></div>
      				 <div><?php echo $val['address1'];?> </div>
                                 <div> <?php echo $val['mobil_number'];?></div>
                                 <div> <?php echo $val['email_id'];?></div>
     			   </td>
                           <td></td>
                   <td class="action-btn-align"> <img src="<?= $theme_path; ?>/images/Logo1.png" alt="Chain Logo" width="125px"></td>
                   <td></td>
  				 </tr>
                 <tr>
                   <td><span  class="tdhead">Reference Name:</span></td>
                   <td><?php echo $val['nickname'][0]['nick_name'];?></td>
                   <td><span  class="tdhead">Quotation NO:</span></td>
                   <td><?php echo $val['q_no'];?></td>
                 </tr>
                  <tr>
                   <!--<td><span  class="tdhead">Company Name: </span><?php echo $val['store_name'];?></td>
                   <td><span  class="tdhead">Customer Mobile No:</span> <?php echo $val['mobil_number'];?></td>-->
                 </tr>
                  <tr>
                 <!--  <td><span  class="tdhead">Customer Email ID:</span> <?php echo $val['email_id'];?></td>-->
                   <td><span  class="tdhead">Tin No:</span></td>
                   <td><?=$company_details[0]['tin_no']?></td>
                   <td></td><td></td>
                 </tr>
                      
                </table>
             
                  
                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                	<thead>
                    <tr>
                        <td  width="2%" class="first_td1 action-btn-align">S.No</td>
                    	<td width="10%" class="first_td1">Category</td>                         
                        <td width="10%" class="first_td1">Brand</td>
                        <td width="10%" class="first_td1">Model No</td>  
                        <td width="10%" class="first_td1">Product Description</td>  
                        <td width="10%" class="first_td1 action-btn-align">Product Image</td>  
                        <td  width="2%" class="first_td1">QTY</td>
                        <td  width="2%" class="first_td1">Cost/QTY</td>
                        <td  width="2%" class="first_td1">Tax</td>
                        <td  width="5%" class="first_td1">Net Value</td>                        
                       
                    </tr>
                    </thead>
                    <tbody id='app_table'>
                         <?php       
                         $i=1;
                         if(isset($quotation_details) && !empty($quotation_details))
			{
				foreach($quotation_details as $vals)
				{
					?>
                        <tr>
                            <td class="action-btn-align">
                            	<?php echo $i;?>
                            </td>
                            <td>
                            	<?php echo $vals['categoryName']?>
                            </td>
                            <td>
                            	<?php echo $vals['brands']?>
                            </td>
                            <td >
                            	<?php echo $vals['model_no']?>
                            </td> 
                             <td>
                            	<?php echo $vals['product_description']?>
                            </td>
                             <td class="action-btn-align">
                            	 <img id="blah" name="product_image[]" class="add_staff_thumbnail product_image" width="50px" height="50px" src="<?= $this->config->item("base_url")?>attachement/product/<?php echo $vals['product_image'];?>"/> 
                            </td>
                            <td class="action-btn-align">
                            	<?php echo $vals['quantity']?>
                            </td>
                            <td class="action-btn-align">
                            	<?php echo number_format($vals['per_cost'],2);?>
                            </td>
                            <td class="action-btn-align">
                            	<?php echo $vals['tax']?>
                            </td>
                            <td class="text_right">
                            	<?php echo number_format($vals['sub_total'],2);?>
                            </td>
                        </tr>
                         <?php
                         $i++;
                                            }
                                        }
                                    ?>
                    </tbody>
                        
                    <tfoot>
                    	<tr>
                            <td colspan="5" style="width:70px; text-align:right;">Total</td>
                            <td class="action-btn-align"><?php echo $val['total_qty'];?></td>
                            <td colspan="3" style="text-align:right;">Sub Total</td>
                            <td class="text_right"><?php echo number_format($val['subtotal_qty'],2);?></td>
                           
                        </tr>
                        <tr>
                            <td colspan="3" style="width:70px; text-align:right;"></td>
                            <td colspan="6" style="text-align:right;font-weight:bold;"><?php echo $val['tax_label'];?> </td>
                            <td class="text_right">
                            	<?php echo number_format($val['tax'],2);?>
                            
                        </tr>
                        <tr>
                            <td colspan="3" style="width:70px; text-align:right;"></td>
                            <td colspan="6"style="text-align:right;font-weight:bold;">Net Total</td>
                            <td class="text_right"><?php echo number_format($val['net_total'],2);?></td>
                        
                        </tr>
                         <tr>
                            <td colspan="11" style="">
                            	<span style="float:left;  top:12px;">Remarks&nbsp;&nbsp;&nbsp;</span> 
                                <?php echo $val['remarks'];?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                
              
                <div class="hide_class action-btn-align">
                 
                    <a href="<?php echo $this->config->item('base_url').'service/service_list/'?>"class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                   <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                </div>
                 <?php }
                 
                                }
                    ?>
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
        <script>
                        $('.print_btn').click(function(){
                            window.print();
                        });
                      </script>
   
