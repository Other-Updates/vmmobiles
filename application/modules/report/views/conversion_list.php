<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<style>
    .bg-red {background-color: #dd4b39 !important;}
    .bg-yellow{background-color:orange !important;}
    .ui-datepicker td.ui-datepicker-today a {background:#999999;}
    .style{text-align: center;}
</style>
<div class="mainpanel">

    <div class="media mt--20">
        <h4>Quotation Vs Project Conversion Ratio
        </h4>
    </div>
    <div class="contentpanel">
        <div class="panel-body">
        	<div class="row search_table_hide search-area">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">From Date</label>
                        <input type="text" id='from_date'  class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">To Date</label>
                        <input type="text"  id='to_date' class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy">
                    </div>
                </div>
                <div class="col-md-2">
                <div class="form-group mcenter">
                	   <label class="control-label col-md-12 mnone">&nbsp;</label>
                       <a id='search' class="btn btn-success pull-left mtop4"><span class="glyphicon glyphicon-search "></span> Search</a>
                       <a class="btn btn-danger1 pull-right mtop4"><span class="fa fa-close"></span> Clear</a>                    
                    </div>
                </div>
            </div>
        </div>
        <div id='result_div' class="panel-body mt-top5">
            <div class="">
                <table class="table table-striped table-bordered no-footer dtr-inline">
                    <?php
                    if (isset($quotation) && !empty($quotation)) {
                        ?>
                        <tr>
                            <td class="style">Conversion Ratio</td>
                            <td class="style">
                                <span class="badge bg-green total"> </span>
                                <!--<input type="text" id='from_date' value="<?php echo $quotation[0]['pc_total'][0]['id'] ?>/<?php echo $quotation[0]['quo_total'][0]['id'] ?>" class="form-control" name="inv_date" id="" style="width:100px">-->
                            </td>
                            <td class="style">Conversion Percentage</td>
                            <td class="style">
                                <span class="badge bg-green per"></span>
                               <!--<input type="text"  id='to_date' class=" form-control" name="inv_date"  value="<?php echo number_format((float) $quotation[0]['percentage']); ?>" style="width:100px">-->

                            </td>
                        </tr>
                    <?php }
                    ?>
                </table>
                <table id="basicTable_call_back" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                    <thead>
                        <tr>
                            <td class="action-btn-align">S.No</td>
                            <td class="action-btn-align">Quotation No</td>
                            <td>Customer Name</td>
                            <td>Quotation Amount</td>
                            <td class="action-btn-align">Quotation Date</td>
                            <td>Job ID</td>
                            <td>Project Cost Amount</td>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text_right total-bg"></td>
                            <td ></td>
                            <td class=""></td>
                            <td class="text_right total-bg"></td>

                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        if (isset($quotation) && !empty($quotation)) {

                            $i = 1;
                            foreach ($quotation as $val) {
                                ?>
                                <tr>
                                    <td id="td_count" class='first_td action-btn-align td_cound'><?= $i ?></td>
                                    <td class="action-btn-align"><?= $val['q_no'] ?></td>
                                    <td><?= $val['name'] ?></td>
                                    <td class="text_right"><?= number_format($val['net_total'], 2); ?></td>
                                    <td class="action-btn-align"><?php echo date('d-M-Y', strtotime($val['created_date'])); ?></td>
                                    <?php if (isset($val['pc_amount']) && !empty($val['pc_amount'])) { ?>

                                        <td class="pc_count"><?php echo $val['pc_amount'][0]['job_id']; ?></td>
                                        <td class="text_right"><?php echo number_format($val['pc_amount'][0]['net_total'], 2); ?></td>

                                    <?php } else { ?>
                                        <td></td><td></td>

                                    </tr>
                                    <?php
                                }
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="action-btn-align mb-10">
                <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                <button class="btn btn-success excel_btn"><span class="glyphicon glyphicon-print"></span> Excel</button>
            </div>
        </div>

    </div>
</div>
<script>
    $('.print_btn').click(function () {
        window.print();
    });
</script>
</div><!-- contentpanel -->

</div><!-- mainpanel -->
<script type="text/javascript">
    $(document).ready(function () {

        var tds = $('#basicTable_call_back').children('tbody').children('tr').find('.td_cound').length;
        var td_pc = $('#basicTable_call_back').children('tbody').children('tr').find('.pc_count').length;
        var val = ((td_pc / tds) * 100).toFixed(2);
        ;
        $('.total').html(td_pc + "/" + tds);
        $('.per').html(val);
    });
</script>
<script type="text/javascript">
    $('.complete_remarks').live('blur', function ()
    {
        var complete_remarks = $(this).parent().parent().find(".complete_remarks").val();
        var ssup = $(this).offsetParent().find('.remark_error');
        if (complete_remarks == '' || complete_remarks == null)
        {
            ssup.html("Required Field");
        } else
        {
            ssup.html("");
        }
    });

    $(document).ready(function () {
        $('#basicTable_call_back').DataTable({
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                var cols = [3, 6];
                for (x in cols) {
                    total = api.column(cols[x]).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    // Total over this page
                    pageTotal = api.column(cols[x], {page: 'current'}).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    // Update footer
                    if (Math.floor(pageTotal) == pageTotal && $.isNumeric(pageTotal)) {
                        pageTotal = pageTotal;

                    } else {
                        pageTotal = pageTotal.toFixed(2);/* float */

                    }
                    $(api.column(cols[x]).footer()).html(pageTotal);
                }


            },
            responsive: true,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -2}
            ]
        });
        jQuery('.datepicker').datepicker();

    });
    $().ready(function () {
        $("#po_no").autocomplete(BASE_URL + "gen/get_po_list", {
            width: 260,
            autoFocus: true,
            matchContains: true,
            selectFirst: false
        });
    });
    $('#search').live('click', function () {
        for_loading();
        $.ajax({
            url: BASE_URL + "report/search_conversion_list",
            type: 'GET',
            data: {
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val()
            },
            success: function (result) {
                for_response();
                $('#result_div').html(result);

            }
        });

    });

</script>

<script type="text/javascript">
    $(document).ready(function () {


    });
</script>