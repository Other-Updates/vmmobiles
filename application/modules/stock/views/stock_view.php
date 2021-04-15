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
             <div class="media">
              <h4>View stock              
              </h4>
             </div>
            <div class="contentpanel enquiryview  ptpb-10  viewquo mb-45">
            
        
                 <?php       
                    //echo '<pre>';
                   //print_r($quotation);
                    if(isset($stock) && !empty($stock))
                    {
                            foreach($stock as $val)
                            {
                                    ?>
                <table style="width:60%;margin:0 auto;" class="table table-striped responsive dataTable no-footer dtr-inline">
                    <tr>
                        <td class="first_td1">PO NO</td>
                        <td> <?php echo $val['po_no'];?></td>
                        <td>Supplier Name</td>
                        <td>
                            <?php echo $val['name'];?>
                        </td>
                   </tr>
                   <tr>
                        <td class="first_td1">Supplier Mobile No</td>
                        <td>
                            <?php echo $val['mobil_number'];?>
                        </td>
                       <td class="first_td1"  >Supplier Email ID</td>
                        <td id='customer_td'>
                            <?php echo $val['email_id'];?>
                        </td>              
                   </tr>
                   <tr>
                        <td  class="first_td1">Supplier Address</td>
                        <td colspan="">
                            <?php echo $val['address1'];?>
                        </td>
                        <td class="first_td1">Tin No</td>
                        <td><?=$company_details[0]['tin_no']?>
                        </td> 
                   </tr>               
                </table>
                  
                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                	<thead>
                    <tr>
                    	<td width="10%" class="first_td1">Category</td>
                        <td width="10%" class="first_td1">Model No</td>   
                        <td width="10%" class="first_td1">Brand</td>  
                        <td width="10%" class="first_td1">Product Description</td>                      
                        <td  width="8%" class="first_td1">QTY</td>
                        <td  width="2%" class="first_td1">Cost/QTY</td>
                        <td  width="2%" class="first_td1">Tax</td>
                        <td  width="2%" class="first_td1">Net Value</td>                        
                       
                    </tr>
                    </thead>
                    <tbody id='app_table'>
                         <?php       if(isset($po_details) && !empty($po_details))
			{
				foreach($po_details as $vals)
				{
					?>
                        <tr>
                            <td>
                            	<?php echo $vals['categoryName']?>
                            </td>
                            <td>
                            	<?php echo $vals['model_no']?>
                            </td>
                            <td >
                            	<?php echo $vals['brands']?>
                            </td> 
                             <td>
                            	<?php echo $vals['product_description']?>
                            </td>                            
                            <td>
                            	<?php echo $vals['quantity']?>
                            </td>
                            <td>
                            	<?php echo $vals['per_cost']?>
                            </td>
                            <td>
                            	<?php echo $vals['tax']?>
                            </td>
                            <td>
                            	<?php echo $vals['sub_total']?>
                            </td>
                        </tr>
                         <?php
                                            }
                                        }
                                    ?>
                    </tbody>
                        
                    <tfoot>
                    	<tr>
                            <td colspan="4" style="width:70px; text-align:right;">Total</td>
                            <td><?php echo $val['total_qty'];?></td>
                            <td colspan="2" style="text-align:right;">Sub Total</td>
                            <td><?php echo $val['subtotal_qty'];?></td>
                           
                        </tr>
                        <tr>
                            <td colspan="3" style="width:70px; text-align:right;"></td>
                            <td colspan="4" style="text-align:right;font-weight:bold;"><?php echo $val['tax_label'];?> </td>
                            <td>
                            	<?php echo $val['tax'];?>
                            
                        </tr>
                        <tr>
                            <td colspan="3" style="width:70px; text-align:right;"></td>
                            <td colspan="4"style="text-align:right;font-weight:bold;">Net Total</td>
                            <td><?php echo $val['net_total'];?></td>
                        
                        </tr>
                         <tr>
                            <td colspan="9" style="">
                            	<span style="float:left;  top:12px;">Remarks&nbsp;&nbsp;&nbsp;</span> 
                                <?php echo $val['remarks'];?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <table class="table table-striped" style="width:100%;border:1 solid #CCC;">
                	<tr>
                    	<td  style="width:49%;">
                        	<table style="width:100%;">
                                <tr>
                                	<td colspan="4"><b style="font-size:15px;">TERMS AND CONDITIONS</b></td>
                                </tr>
                                <tr>
                                    <td>1.</td>
                                    <td>Delivery Schedule</td>
                                    <td></td>
                                    <td>
                                        <div class="input-group" style="width:70%;">
                                        <?php echo $val['delivery_schedule'];?>
                                        <span id="colorpoerror" style="color:#F00;" ></span>
                                         </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>Mode of Payment</td>
                                    <td></td>
                                    <td><?php echo $val['mode_of_payment'];?></td>
                                </tr>
                                   <input type="hidden"  name="quotation[customer]" id="customer_id" class='id_customer' value="<?php echo $val['id'];?>"/>
                              
                            </table>
                        </td>
                        <td style="width:49%;">
                        	
                        </td>
                    </tr>
                </table>
                <div class="hide_class action-btn-align">
                     
<!--                     <a href="<?php echo $this->config->item('base_url').'quotation/change_status/'.$quotation[0]['id'].'/2'?>" class="btn complete"><span class="glyphicon"></span> Complete </a>-->
              
                    <a href="<?php echo $this->config->item('base_url').'purchase_order/purchase_order_list/'?>"class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                   
                </div>
                 <?php }}
                    ?>
            </div><!-- contentpanel -->
        </div><!-- mainpanel -->
   
        