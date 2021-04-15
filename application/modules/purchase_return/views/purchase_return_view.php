<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
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
    table.dataTable tr td:first-child {
        text-align:left;
    }
</style>
<div class="print_header">
    <table width="100%">
        <tr>
            <td width="15%" style="vertical-align:middle;">
                <div class="print_header_logo" ><img src="<?= $theme_path; ?>/images/logo.png" /></div>
            </td>
            <td width="85%">

                <div class="print_header_tit" >
                    <h3> <?= $company_details[0]['firm_name'] ?></h3>
                    <p></p>
                    <p class="pf">  <?= $company_details[0]['address'] ?>,
                    </p>
                    <p></p>
                    <p class="pf"> Pin Code : <?= $company_details[0]['pincode'] ?>,</p>
                    <p></p>
                </div>
            </td>
        </tr>
    </table>
</div>
<div class="mainpanel">
    <div class="media mt--40 hide_class">
        <h4 class="hide_class">View Purchase Order
        </h4>
    </div>
    <div class="contentpanel enquiryview  ptpb-10  viewquo mb-45">
        <?php
        if (isset($po) && !empty($po)) {
            foreach ($po as $val) {
                ?>
                <div class="tpadd10">
                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline tablecolor">
                        <tr class="tbor">
                            <td colspan="2">GSTIN NO : <?= $company_details[0]['gstin'] ?></td>
                            <td  colspan="2" style="text-align:right">Cell : <?= $company_details[0]['mobile_number'] ?> </td>
                        </tr>
                        <tr>
                            <td><span  class="tdhead">TO,</span>
                                <div><?php echo $val['store_name']; ?></div>
                                <div><?php echo $val['address1']; ?> </div>
                                <div>Mobile : <?php echo ($val['mobil_number']) ? $val['mobil_number'] : '-'; ?></div>
                                <div>Email :  <?php echo ($val['email_id']) ? $val['email_id'] : '-'; ?></div>
                                <div>GSTIN : <?php echo ($val['tin']) ? $val['tin'] : '-'; ?></div>
                            </td>
                            <td>PO NO : </td>
                            <td class="action-btn-align" style="text-align:right;" colspan="2"> <?php echo $val['po_no']; ?></td>
                        </tr>
                        <tr>
                        </tr>
                        <tr>
                            <td>Firm Name:</td>
                            <td><?php echo $company_details[0]['firm_name'] ?></td>
                            <td>Supplier Name: </td>
                            <td><?php echo $val['name']; ?></td>


                        </tr>
                        <tr>
                            <td>Supplier GSTIN: </td>
                            <td><?php echo $val['tin']; ?></td>
                            <td>Date: </td>
                            <td><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '-'; ?></td>

                        </tr>
                    </table>
                </div>
                <form method="post" action="<?php echo $this->config->item('base_url') . 'purchase_order/dc_edit/' . $val['id'] ?>" id="add_delivary" >
                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                        <thead>
                            <tr>
                                <td  width="2%" class="first_td1 action-btn-align ser-wid">S.No</td>
                                <td width="10%" class="first_td1">HSN Code</td>
                                <td width="10%" class="hide_class first_td1">Category</td>
                                <td width="20%" class="first_td1">Product Name</td>
                                <td width="10%" class="hide_class first_td1">Brand</td>
                                <td width="5%" class="hide_class first_td1">Unit</td>
                                <td  width="8%" class="first_td1 action-btn-align ser-wid">QTY</td>
                                <td width="8%" class="first_td1 action-btn-align ser-wid">Return QTY</td>
                                <td  width="8%" class="first_td1 action-btn-align ser-wid">Unit Price</td>
        <!--                                <td  width="6%" class="first_td1 action-btn-align ser-wid">Total</td>-->
                                <td  width="7%" class="first_td1 action-btn-align proimg-wid">Discount %</td>
                                <td  width="5%" class="first_td1 action-btn-align proimg-wid">CGST%</td>
                                <?php
                                $gst_type = $po[0]['state_id'];
                                if ($gst_type != '') {
                                    if ($gst_type == 31) {
                                        ?>
                                        <td  width="5%" class="first_td1 action-btn-align ser-wid" >SGST%</td>
                                    <?php } else { ?>
                                        <td  width="5%" class="first_td1 action-btn-align ser-wid" >IGST%</td>

                                        <?php
                                    }
                                }
                                ?>
                                <td  width="7%" class="first_td1 action-btn-align proimg-wid">Transport</td>
                                <td  width="7%" class="first_td1 action-btn-align qty-wid">Net Value</td>
                            </tr>
                        </thead>
                        <tbody id='app_table'>
                            <?php
                            $i = 1;
                            if (isset($po_details) && !empty($po_details)) {
                                $ret_qty = $over_all_net_total = 0;
                                foreach ($po_details as $vals) {
                                    $deliver_qty = $vals['delivery_qty'];
                                    $per_cost = $vals['per_cost'];
                                    $gst = $vals['tax'];
                                    $cgst = $vals['gst'];
                                    $net_total = $deliver_qty * $per_cost + (($deliver_qty * $per_cost) * $gst / 100) + (($deliver_qty * $per_cost) * $cgst / 100) - $vals['discount'] + $vals['transport'];

                                    $over_all_net_total += $net_total;
                                    ?>
                                    <tr>
                                        <td class="action-btn-align">
                                            <?php echo $i; ?>
                                        </td>
                                        <td class="">
                                            <?php echo!empty($vals['hsn_sac_name']) ? $vals['hsn_sac_name'] : '-'; ?>
                                        </td>
                                        <td class="hide_class">
                                            <?php echo!empty($vals['categoryName']) ? $vals['categoryName'] : '-'; ?>
                                        </td>
                                        <td>
                                            <?php echo $vals['product_name']; ?>
                                        </td>
                                        <td class="hide_class">
                                            <?php echo!empty($vals['brands']) ? $vals['brands'] : '-' ?>
                                        </td>
                                        <td class="hide_class">
                                            <?php echo!empty($vals['unit']) ? $vals['unit'] : '-' ?>
                                        </td>
                                        <td class="action-btn-align act_qty">
                                            <?php echo $vals['delivery_qty'] ?>
                                        </td>
                                        <td class="action-btn-align del_qty">
                                            <?php
                                            echo $vals['return_quantity'];
                                            $ret_qty += $vals['return_quantity'];
                                            ?>
                                        </td>
                                        <td class="text_right">
                                            <?php echo number_format($vals['per_cost'], 2); ?>
                                        </td>
                <!--                                        <td class="text_right">
                                        <?php //echo number_format($vals['per_cost'], 2); ?>
                                        </td>-->
                                        <td class="action-btn-align">
                                            <?php echo $vals['discount'] ?>
                                        </td>
                                        <td class="action-btn-align">
                                            <?php echo $vals['tax'] ?>
                                        </td>
                                        <?php
                                        $gst_type = $po[0]['state_id'];
                                        if ($gst_type != '') {
                                            if ($gst_type == 31) {
                                                ?>
                                                <td class="action-btn-align" >
                                                    <?php echo $vals['gst']; ?>
                                                </td>
                                            <?php } else { ?>
                                                <td class="action-btn-align" >
                                                    <?php echo $vals['igst']; ?>
                                                </td>

                                                <?php
                                            }
                                        }
                                        ?>
                                        <td class="action-btn-align">
                                            <?php echo $vals['transport'] ?>
                                        </td>
                                        <td class="text_right">
                                            <?php echo $net_total ?>
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
                                <td colspan="3" class="hide_class" style="width:70px; text-align:right;"></td>
                                <td colspan="3" style="width:70px; text-align:right;"><b>Total</b></td>
                                <td class="action-btn-align"><?php echo $vals['po'][0]['delivery_qty'] ?></td>
                                <td class="action-btn-align"><?php echo $ret_qty; ?></td>
                                <td colspan="5" style="text-align:right;"><b>Sub Total</b></td>
                                <td class="text_right"><?php echo $over_all_net_total; ?></td>
                            </tr>
                            <tr>
                                <td colspan="3"  class="hide_class" style="width:70px; text-align:right;"></td>
                                <td colspan="10" style="text-align:right;font-weight:bold;"><?php echo $val['tax_label']; ?> </td>
                                <td class="text_right">
                                    <?php echo number_format($val['tax'], 2); ?>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="3"  class="hide_class" style="width:70px; text-align:right;"></td>
                                <td colspan="10"style="text-align:right;font-weight:bold;">Net Total</td>
                                <td class="text_right"><?php echo $over_all_net_total + $val['tax']; ?></td>

                            </tr>
                            <tr>
                                <td colspan="13" style="">
                                    <span style="float:left;  top:12px;">Remarks&nbsp;&nbsp;&nbsp;</span>
                                    <?php echo $val['remarks']; ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="hide_class action-btn-align">

                        <a href="<?php echo $this->config->item('base_url') . 'purchase_return/' ?>"class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                        <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>

                    </div>
                </form>
                <?php
            }
        }
        ?>
    </div><!-- contentpanel -->
</div><!-- mainpanel -->
<script>
    $('.print_btn').click(function () {
        window.print();
    });

</script>

