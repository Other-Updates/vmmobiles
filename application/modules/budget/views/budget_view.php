<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<style type="text/css">
    .text_right{text-align:right;}
    .box, .box-body, .content { padding:0; margin:0;border-radius: 0;}
    #top_heading_fix h3 {top: -57px;left: 6px;}
    #TB_overlay { z-index:20000 !important; }
    #TB_window { z-index:25000 !important; }
    .dialog_black{ z-index:30000 !important; }
    #boxscroll22 {max-height: 291px;overflow: auto;cursor: inherit !important;}
    .auto-asset-search ul#country-list li:hover {background: #c3c3c3;cursor: pointer;}
    .auto-asset-search ul#country-list li { background: #dadada; margin: 0;padding: 5px;border-bottom: 1px solid #f3f3f3;}
    ul li {list-style-type: none;}
</style>
<div class="mainpanel">
    <div class="media mt--20">
        <h4 class="">View Budget Details
        </h4>
    </div>
    <div class="contentpanel enquiryview  ptpb-10  viewquo mb-45">
        <?php
        if (isset($po) && !empty($po)) {
            foreach ($po as $val) {
                ?>
                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline tablecolor">
                    <tr>
                        <td><span class="tdhead">Voucher No</span></td>
                        <td><?php echo $val['vc_no']; ?></td>
                        <td class="action-btn-align" colspan="2"> <img src="<?= $theme_path; ?>/images/logo.png" alt="Chain Logo" width="125px"></td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td><span class="tdhead">Firm Name</span></td>
                        <td><?php echo $val['firm_name']; ?></td>
                        <td><span  class="tdhead">Budget Name:</span></td>
                        <td><?php echo $val['budget_name']; ?></td>


                    </tr>
                    <tr>
                        <td><span  class="tdhead">From Date:</span></td>
                        <td><?php echo ($val['from_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['from_date'])) : ''; ?></td>
                        <td><span  class="tdhead">To Date:</span></td>
                        <td><?php echo ($val['to_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['to_date'])) : ''; ?></td>

                    </tr>
                    <tr>
                        <td><span  class="tdhead">Estimated Budget Cost:</span></td>
                        <td><?php echo ($val['estimated_bud_cost'] != '') ? $val['estimated_bud_cost'] : '-'; ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>

                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                    <thead>
                        <tr>
                            <td width="2%" class="first_td1 action-btn-align ser-wid">S.No</td>
                            <td width="30%" class="first_td1 action-btn-align">Customer Name</td>
                            <td width="10%" class="first_td1 action-btn-align">Amount</td>
                            <!--<td width="10%" class="first_td1 action-btn-align">Discount Amount</td>-->
                            <td width="10%" class="first_td1 action-btn-align">Received Amount</td>
                        </tr>
                    </thead>
                    <tbody id='app_table'>
                        <?php
                        $i = 1;
                        $total_dis = 0;
                        $total_rec = 0;
                        if (isset($po_details) && !empty($po_details)) {
                            foreach ($po_details as $vals) {
                                ?>
                                <tr>
                                    <td class="action-btn-align">
                                        <?php echo $i; ?>
                                    </td>
                                    <td>
                                        <?php echo $vals['customer']; ?>
                                    </td>
                                    <td class="text_right">
                                        <?php echo $vals['amount']; ?>
                                    </td>
                <!--                                    <td class="text_right">
                                    <?php echo!empty($vals['receipt_bill'][0]['receipt_discount']) ? $vals['receipt_bill'][0]['receipt_discount'] : '0'; ?>
                                    </td>-->
                                    <td class="text_right">
                                        <?php echo!empty($vals['receipt_bill'][0]['receipt_paid']) ? $vals['receipt_bill'][0]['receipt_paid'] : '0'; ?>
                                    </td>
                                </tr>
                                <?php
                                //$total_dis += $vals['receipt_bill'][0]['receipt_discount'];
                                $total_rec += $vals['receipt_bill'][0]['receipt_paid'];
                                $i++;
                            }
                        }
                        ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="2" style="text-align:right;"><b>Net Total</b></td>
                            <td class="text_right total-bg"><?php echo number_format($val['net_total'], 2); ?></td>
                            <td class="text_right total-bg"><?php echo number_format($total_rec, 2); ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="">
                                <span>Remarks&nbsp;&nbsp; : &nbsp;</span>
                                <?php echo $val['remarks']; ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <div class="hide_class action-btn-align">
                    <a href="<?php echo $this->config->item('base_url') . 'budget/budget_list/' ?>"class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                    <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                </div>
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
    $(document).ready(function () {
        window.print();
    });
</script>

