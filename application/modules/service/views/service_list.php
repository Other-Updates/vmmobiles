<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<style>
    .btn-xs {     padding: 1px 4px 2px 5px; }
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
    .auto-asset-search ul#product-list li:hover {
        background: #c3c3c3;
        cursor: pointer;
    }
    .auto-asset-search ul#country-list li {
        background: #dadada;
        margin: 0;
        padding: 5px;
        border-bottom: 1px solid #f3f3f3;
    }
    .auto-asset-search ul#product-list li {
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
    <div class="media mt--20">
        <h4 class="ml-5">Service and Repair</h4>
    </div>
    <div class="contentpanel">
        <div class="panel-body mt--40">
            <table class="table table-striped table-bordered no-footer dtr-inline search_table_hide mb-0">
                <tr>
                    <td><label class="ml-5"> Service Type</label></td>
                    <td>
                        <label class="ml-5"><input type="radio" name="Radio" value="paid"> Paid Service</label>
                    </td>
                    <td>
                        <label class="ml-5"><input type="radio" name="Radio" value="warranty"> Warranty Service</label>
                    </td>
                </tr>
            </table>
        </div>
        <!-- <div>
             <label class="ml-5"> Service Type</label>
         </div>
         <div>
         <label class="ml-5"><input type="radio" name="Radio" value="paid">Paid Service</label>
         <label class="ml-5"><input type="radio" name="Radio" value="warranty">Warranty Service</label>
         </div>-->
        <div class="contentpanel">
            <div id='result_div' class="panel-body mt-top5 pb0 mb-50 print-top">
                <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                    <thead>
                        <tr>
                            <td class="action-btn-align">S.No</td>
                            <td class='action-btn-align'>Quotation No</td>
                            <td>Company Name</td>
                            <td class="action-btn-align">Total Quantity</td>
<!--                            <td class="action-btn-align">Total Tax</td>-->
                            <!--<td>Sub Total</td>-->
                            <td>Total Amount</td>
                            <td class='action-btn-align'>Delivery Schedule</td>
                            <td class='action-btn-align'>Notification Date</td>
                            <!--<td>Mode of Payment</td>-->
                            <td class="action-btn-align">Validity</td>
                            <!--<td>Remarks</td>-->
                            <td class="hide_class action-btn-align">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($quotation) && !empty($quotation)) {
                            $i = 1;
                            foreach ($quotation as $val) {
                                ?>
                                <tr>
                                    <td class='first_td action-btn-align'><?= $i ?></td>
                                    <td class='action-btn-align'><?= $val['q_no'] ?></td>
                                    <td><?= $val['store_name'] ?></td>
                                    <td class="action-btn-align"><?= $val['total_qty'] ?></td>
        <!--                                    <td class="action-btn-align"><?= $val['tax'] ?></td> -->
                                    <!--<td class="text_right"><?= number_format($val['subtotal_qty'], 2); ?></td>-->
                                    <td class="text_right"><?= number_format($val['net_total'], 2); ?></td>
                                    <td class='action-btn-align'><?= ($val['delivery_schedule'] != '1970-01-01') ? date('d-M-Y', strtotime($val['delivery_schedule'])) : ''; ?></td>
                                    <td class='action-btn-align'><?= ($val['notification_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['notification_date'])) : ''; ?></td>
                                    <!--<td><?= $val['mode_of_payment'] ?></td>-->
                                    <td class="action-btn-align"><?= $val['validity'] ?></td>
                                    <!--<td><?= $val['remarks'] ?></td>-->
                                    <td class="hide_class action-btn-align">
                                        <a href="<?php echo $this->config->item('base_url') . 'service/service_view/' . $val['id'] ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>
                                    </td>

                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
<!--                             <tr><td colspan="10">No data found...</td></tr>-->

                    </tbody>
                </table>
                <div class="action-btn-align mb-10">
                    <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                </div>
            </div>

        </div>
    </div>
    <script>
        $('.print_btn').click(function () {
            window.print();
        });
    </script>
    <script>
        $('input[type="radio"]').click(function () {
            if ($(this).attr("value") == "paid") {
                window.location.replace("<?php echo $this->config->item('base_url') . 'service/paid_service_add/' ?>");
            }
            if ($(this).attr("value") == "warranty") {
                window.location.replace("<?php echo $this->config->item('base_url') . 'service/project_cost_update/' ?>");
            }
        });
    </script>
