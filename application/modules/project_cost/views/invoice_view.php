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
              <h4 class="hide_class">View Invoice             
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
                         
                   <td COLSPAN=2 class="action-btn-align"> <img src="<?= $theme_path; ?>/images/Logo1.png" alt="Chain Logo" width="125px"></td>
                     <td></td>
  				 </tr>
                 <tr>
                    <td><span  class="tdhead">Invoice NO:</span></td>  
                    <td><?php echo $val['inv_id'];?></td>
                   <td><span  class="tdhead">Tin No</span></td><td><?=$company_details[0]['tin_no']?></td>
                 </tr>
                  <tr>
                     <td><span  class="tdhead">Reference NO:</span></td>
                     <td><?php echo $val['q_no'];?></td>
                    <td><span  class="tdhead">Date</span></td><td><?=($val['created_date']!='1970-01-01')?date('d-M-Y',strtotime($val['created_date'])):'';?></td>
                 </tr>
                  
                </table>
              
                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                	<thead>
                    <tr> 
                        <td  width="2%" class="first_td1 action-btn-align ser-wid">S.No</td>
                    	<td width="10%" class="first_td1 hide_class">Category</td>                       
                        <td width="10%" class="first_td1 hide_class">Model No</td>
                        <td width="10%" class="first_td1 hide_class">Brand</td> 
                        <td width="10%" class="first_td1 pro-wid">Product Description</td>                        
                        <td  width="2%" class="first_td1 action-btn-align ser-wid">QTY</td>
                        <td  width="5%" class="first_td1 action-btn-align ser-wid">Cost/QTY</td>
                        <td  width="5%" class="first_td1 action-btn-align proimg-wid">CGST%</td>
                        <td  width="5%" class="first_td1 action-btn-align proimg-wid">SGST%</td>
                        <td  width="7%" class="first_td1 qty-wid">Net Value</td>                        
                       
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
                            <td class="hide_class">
                            	<?php echo $vals['categoryName']?>
                            </td>                           
                            <td class="hide_class">
                            	<?php echo $vals['model_no']?>
                            </td> 
                             <td class="hide_class">
                            	<?php echo $vals['brands']?>
                            </td>
                             <td>
                            	<?php echo $vals['product_description']?>
                            </td>                            
                            <td class="action-btn-align">
                            	<?php echo $vals['quantity']?>
                            </td>
                            <td class="text_right">
                            	<?php echo number_format($vals['per_cost'],2);?>
                            </td>
                            <td class="action-btn-align">
                            	<?php echo $vals['tax']?>
                            </td>
                            <td class="action-btn-align">
                            	<?php echo $vals['gst']?>
                            </td>
                            <td class="text_right">
                            	<?php echo number_format($vals['sub_total'],2)?>
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
                            <td colspan="4" class="hide_class" style="width:70px; text-align:right;"></td>
                            <td colspan="2" style="width:70px; text-align:right;">Total</td>
                            <td class="action-btn-align"><?php echo $val['total_qty'];?></td>
                            <td colspan="2" style="text-align:right;">Sub Total</td>
                            <td class="text_right"><?php echo number_format($val['subtotal_qty'],2);?></td>
                           
                        </tr>
                        <tr>
                            <td colspan="4" class="hide_class" style="width:70px; text-align:right;"></td>
                            <td colspan="5"  style="text-align:right;font-weight:bold;"><?php echo $val['tax_label'];?> </td>
                            <td class="text_right">
                            	<?php echo number_format($val['tax'],2);?>
                            
                        </tr>
                         <?php       
			
				foreach($val['other_cost'] as $key)
				{
					?> 
                        <tr>
                           <td colspan="4" class="hide_class" style="width:70px; text-align:right;"></td>
                            <td colspan="5" style="text-align:right;font-weight:bold;"><?php echo $key['item_name'];?> </td>
                            <td class="text_right">
                            	<?php echo number_format($key['amount'],2);?></td>
                            
                        </tr>
                                <?php }
                        ?>
                        <tr>
                           <td colspan="4" class="hide_class" style="width:70px; text-align:right;"></td>
                            <td colspan="5"style="text-align:right;font-weight:bold;">Net Total</td>
                            <td class="text_right"><?php echo number_format($val['net_total'],2);?></td>
                        
                        </tr>
                         <tr>
                             <td><span style="float:left;  top:12px;">Remarks&nbsp;&nbsp;&nbsp;</span> </td>
                            <td colspan="10" style="">                            	
                                <?php echo $val['remarks'];?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
               
                <div class="hide_class action-btn-align">
                
              
                    <a href="<?php echo $this->config->item('base_url').'project_cost/project_cost_list/'?>"class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                   <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                     <input type="button" class="btn btn-success" id='send_mail' style="float:right;margin-right:10px;"  value="Send Email"/>
                </div>
                 <?php }}
                    ?>
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
        <script>
            $(document).ready(function(){
                $('#send_mail').click(function(){
                        var s_html=$('.size_html');
                        for_loading(); 	
                                $.ajax({
                                          url:BASE_URL+"project_cost/send_email",
                                          type:'GET',
                                          data:{
                                                  id:<?=$quotation[0]['id']?>
                                                   },
                                          success:function(result){
                                                   for_response(); 
                                          }    
                                });
                });	
         });
        $('.print_btn').click(function(){
            window.print();
        });
      </script>
   
        