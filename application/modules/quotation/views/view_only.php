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
</style>
<div class="mainpanel">
    <div class="contentpanel enquiryview hisview">
        <?php
        if (isset($quotation) && !empty($quotation)) {
            foreach ($quotation as $val) {
                ?>
                <table  class="table table-striped table-bordered responsive dataTable no-footer dtr-inline tablecolor">
                    <tr>
                        <td><span  class="tdhead">TO,</span>
                            <div><b><?php echo $val['store_name']; ?></b></div>
                            <div><?php echo $val['address1']; ?> </div>
                            <div> <?php echo $val['mobil_number']; ?></div>
                            <div> <?php echo $val['email_id']; ?></div>
                        </td>
                        <td align='right'><span  class="tdhead">Quotation NO:</span><?php echo $val['q_no']; ?><br>
                            <span  class="tdhead">Date :</span><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?>
                        </td>

                    </tr>
                    <tr>
                        <td><span  class="tdhead">Firm Name : </span><?php echo $val['firm_name']; ?></td>
                        <td align='right'><span  class="tdhead">GSTIN No :</span><?php echo $val['tin']; ?></td>
                    </tr>

                </table>

                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                    <tr>
                        <td width="2%" class="action-btn-align">S.No</td>
                        <td width="10%" class="hide_class first_td1">Category</td>
                        <td width="10%" class="hide_class first_td1">Product Name</td>
                        <td width="10%" class="hide_class first_td1">Brand</td>
                        <td width="5%" class="hide_class first_td1">Unit</td>
                        <td width="10%" class="first_td1 action-btn-align">Image</td>
                        <td  width="5%" class="first_td1 action-btn-align">QTY</td>
                        <td  width="8%" class="first_td1 action-btn-align">Unit Price</td>
                        <!--<td  width="5%" class="first_td1 action-btn-align">Total</td>-->
                        <!--<td  width="7%" class="first_td1 action-btn-align proimg-wid">Discount%</td>-->
                        <td  width="5%" class="first_td1 action-btn-align proimg-wid">CGST%</td>
                        <?php
                        $gst_type = $quotation[0]['state_id'];
                        if ($gst_type != '') {
                            if ($gst_type == 31) {
                                ?>
                                <td  width="8%" class="first_td1 action-btn-align ser-wid" >SGST%</td>
                            <?php } else { ?>
                                <td  width="8%" class="first_td1 action-btn-align ser-wid" >IGST%</td>

                                <?php
                            }
                        }
                        ?>
                        <td  width="7%" class="first_td1 action-btn-align qty-wid">Net Value</td>
                    </tr>
                    <tbody id='app_table'>
                        <?php
                        $i = 1;
                        if (isset($quotation_details) && !empty($quotation_details)) {
                            foreach ($quotation_details as $vals) {
                                ?>
                                <tr>
                                    <td class="action-btn-align">
                                        <?php echo $i; ?>
                                    </td>
                                    <td  class="hide_class">
                                        <?php echo $vals['categoryName'] ?>
                                    </td>

                                    <td  class="hide_class">
                                        <?php echo $vals['product_name'] ?>
                                    </td>
                                    <td  class="hide_class">
                                        <?php echo!empty($vals['brands']) ? $vals['brands'] : '-' ?>
                                    </td>
                                    <td>
                                        <?php echo!empty($vals['unit']) ? $vals['unit'] : '-' ?>
                                    </td>
                                    <td class="action-btn-align">
                                        <?php
                                        if (!empty($vals['product_image'])) {
                                            $file = FCPATH . 'attachement/product/' . $vals['product_image'];
                                            $exists = file_exists($file);
                                        }
                                        $cust_image = (!empty($exists) && isset($exists)) ? $vals['product_image'] : "no-img.gif";
                                        ?>
                                        <img id="blah" name="product_image[]" class="add_staff_thumbnail product_image" width="50px" height="50px" src="<?= $this->config->item("base_url") ?>attachement/product/<?php echo $cust_image; ?>"/>
                                    </td>
                                    <td class="action-btn-align">
                                        <?php echo $vals['quantity'] ?>
                                    </td>
                                    <td class="action-btn-align">
                                        <?php echo number_format($vals['per_cost'], 2) ?>
                                    </td>
                <!--                                    <td class="text_right">
                                    <?php echo number_format(($vals['quantity'] * $vals['per_cost']), 2) ?>
                                    </td>
                                    <td class="action-btn-align">
                                    <?php echo $vals['discount'] ?>
                                    </td>-->
                                    <td class="action-btn-align">
                                        <?php echo $vals['tax'] ?>
                                    </td>
                                    <?php
                                    $gst_type = $quotation[0]['state_id'];
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
                                    <td class="text_right">
                                        <?php echo number_format($vals['sub_total'], 2); ?>
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
                            <td colspan="3" style="width:70px; text-align:right;">Total</td>
                            <td style="text-align:center;"><?php echo $val['total_qty']; ?></td>
                            <td colspan="3" style="text-align:right;">Sub Total</td>
                            <td style="width:70px; text-align:right;"><?php echo number_format($val['subtotal_qty'], 2); ?></td>

                        </tr>
                        <tr>
                            <td colspan="4" class="hide_class" style="width:70px; text-align:right;"></td>
                            <td colspan="6" style="text-align:right;font-weight:bold;"><?php echo $val['tax_label']; ?></td>
                            <td style="width:70px; text-align:right;">
                                <?php echo number_format($val['tax'], 2); ?>

                        </tr>
                        <tr>
                            <td colspan="4" class="hide_class" style="width:70px; text-align:right;"></td>
                            <td colspan="6"style="text-align:right;font-weight:bold;">Net Total</td>
                            <td style="width:70px; text-align:right;"><?php echo number_format($val['net_total'], 2); ?></td>

                        </tr>
                        <tr>
                            <td colspan="11" style="">
                                <span style="float:left;  top:12px;">Remarks&nbsp;&nbsp;&nbsp;</span>
                                <?php echo $val['remarks']; ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <table class="table table-striped tablecolor" style="width:100%;">
                    <tr>
                        <th class="tabth">TERMS AND CONDITIONS</th>
                    </tr>
                    <tr>
                        <th class="tabth">Delivery Schedule:<span class="termcolor"><?php echo $val['delivery_schedule']; ?></span></th>
                        <th class="tabth">Notification Date:<span class="termcolor"><?php echo $val['notification_date']; ?></span>
                        </th>
                        <th class="tabth">Mode of Payment:<span class="termcolor"><?php echo $val['mode_of_payment']; ?></span>
                        <th class="tabth">Validity:<span class="termcolor"><?php echo $val['validity']; ?></span>
                        </th>
                    </tr>
                </table>

                <div class="hide_class action-btn-align mb-bot4">
                    <a href="<?php echo $this->config->item('base_url') . 'quotation/quotation_list/' ?>"class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                </div>
                <?php
            }
        }
        ?>
    </div><!-- contentpanel -->
</div><!-- mainpanel -->

