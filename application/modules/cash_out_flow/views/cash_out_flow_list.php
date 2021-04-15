<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?php echo $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<style>
    .bg-red {background-color: #dd4b39 !important;}
    .bg-green {background-color:#09a20e !important;}
    .bg-yellow{background-color:orange !important;}
    .bro{color:#801e00}
    td a { border: none !important; }
    td a:hover { border: none !important; }
    .btn-xs {
        padding: 0px 2px 1px 2px;
        border-radius: 50%;
    }
</style>
<?php
$this->load->model('admin/admin_model');
$data['company_details'] = $this->admin_model->get_company_details();
?>
<div class="print_header">
    <table width="100%">
        <tr>
            <td width="15%" style="vertical-align:middle;">
                <div class="print_header_logo" ><img src="<?= $theme_path; ?>/images/logo.png" /></div>
            </td>
            <td width="85%">
                <div class="print_header_tit" >
                    <h3>The Total</h3>
                    <p>
                        <?= $data['company_details'][0]['address1'] ?>,
                        <?= $data['company_details'][0]['address2'] ?>,
                    </p>
                    <p></p>
                    <p><?= $data['company_details'][0]['city'] ?>-
                        <?= $data['company_details'][0]['pin'] ?>,
                        <?= $data['company_details'][0]['state'] ?></p>
                    <p></p>
                    <p>Ph:
                        <?= $data['company_details'][0]['phone_no'] ?>, Email:
                        <?= $data['company_details'][0]['email'] ?>
                    </p>
                </div>
            </td>
        </tr>
    </table>
</div>
<div class="mainpanel">
    <div class="media mt--20">
        <h4>Cash Out Flow List
            <a href="<?php if ($this->user_auth->is_action_allowed('cash_out_flow', 'cash_out_flow', 'add')): ?><?php echo $this->config->item('base_url') . 'cash_out_flow/' ?><?php endif ?>" class="btn btn-success right topgen <?php if (!$this->user_auth->is_action_allowed('cash_out_flow', 'cash_out_flow', 'add')): ?>alerts<?php endif ?>"><span class="glyphicon glyphicon-plus"></span> Add New</a>
        </h4>
    </div>
    <div class="panel-body">
        <div class="row search_table_hide search-area">
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Receiver Firm</label>
                    <select id='firm_id' class="form-control">
                        <option value="">Select</option>
                        <?php
                        if (isset($firms) && !empty($firms)) {
                            foreach ($firms as $val) {
                                ?>
                                <option value='<?php echo $val['firm_id']; ?>'><?php echo $val['firm_name']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Receiver Staff</label>
                    <select id='user_name' class="form-control">
                        <option>Select</option>
                        <?php
                        if (isset($user) && !empty($user)) {
                            foreach ($user as $val) {
                                ?>
                                <option value='<?php echo ($val['user_name'] == 'Others') ? $val['other_name'] : $val['user_name']; ?>'><?php echo ($val['user_name'] == 'Others') ? $val['other_name'] : $val['user_name']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">From Date</label>
                    <input type="text" id='from_date'  class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">To Date</label>
                    <input type="text"  id='to_date' class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mcenter">
                    <label class="control-label col-md-12">&nbsp;</label>
                    <a id='search' class="btn btn-success mtop4"><span class="glyphicon glyphicon-search "></span> Search</a>
                    <a class="btn btn-danger1 mtop4" id="clear"><span class="fa fa-close"></span> Clear</a>
                </div>
            </div>
        </div>
    </div>
    <div class="contentpanel mb-50">
        <div  class="panel-body mt-top5">
            <table id="basicTable_call_back" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline cashout-right cashin-right balance-right paymentstatus-cntr">
                <thead>
                    <tr class="action-btn-align">
                        <td width='5%' >S.No</td>
                        <td width='15%'>Receiver Firm </td>
                        <td width='10%'>Receiver Staff </td>
                        <td width='15%'>Sender Firm </td>
                        <td width='10%'>Sender Staff </td>
                        <td width='10%'>Cash Out</td>
                        <td width='10%'>Cash In</td>
                        <td width='10%'>Balance</td>
                        <td width='10%'>Payment Status</td>
                        <td width='15%'>   Action  </td>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text_right total-bg"></td>
                        <td class="text_right total-bg"></td>
                        <td class="text_right total-bg"></td>
                        <td class="hide_class"></td>
                        <td class="hide_class"></td>
                    </tr>
                </tfoot>
                <tbody id='result_div'>


                </tbody>
            </table>
            <div class="action-btn-align mb-10">
                <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
            </div>

            <?php
            if (isset($cash_out) && !empty($cash_out)) {
                foreach ($cash_out as $val) {
                    ?>


                    <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                        <div class="modal-dialog">
                            <div class="modal-content modalcontent-top">
                                <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                                    <h3 id="myModalLabel" class="inactivepop">Cash Out Flow Delete</h3>
                                </div>
                                <div class="modal-body">
                                    Do You Want Delete?
                                    <input type="hidden" value="<?php echo $val['id']; ?>" class="id" />
                                </div>
                                <div class="modal-footer action-btn-align">
                                    <button class="btn btn-primary delete_yes" id="yesin">Yes</button>
                                    <button type="button" class="btn btn-success delete_all"  data-dismiss="modal" id="no">No</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.alerts', function () {
        sweetAlert("Oops...", "This Access is blocked!", "error");
        return false;
    });
    $('.print_btn').click(function () {
        window.print();
    });
    $('#clear').live('click', function ()
    {
        window.location.reload();
    });

    $(document).ready(function () {
        $('#user_name').select2();
        jQuery('.datepicker').datepicker();
    });
    $(document).ready(function ()
    {
        $('#basicTable_call_back').DataTable({
            "lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
            "pageLength": 50,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "retrieve": true,
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('cash_out_flow/ajaxList/'); ?>",
                "type": "POST",
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0, 9], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
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
                var cols = [5, 6, 7];
                for (x in cols) {
                    total = api.column(cols[x]).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    // Total over this page
                    pageTotal = api.column(cols[x], {page: 'current'}).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    // Update footer
//                    if (Math.floor(pageTotal) == pageTotal && $.isNumeric(pageTotal)) {
//                        pageTotal = pageTotal;
//
//                    } else {
//                        pageTotal = pageTotal.toFixed(2);/* float */
//
//                    }
                    $(api.column(cols[x]).footer()).html(pageTotal.toFixed(2));
                }


            },
            responsive: true,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -2}
            ]
        });

    });

    $('#search').on('click', function () {
        for_loading();
        $.ajax({
            url: BASE_URL + "cash_out_flow/cash_out_flow_search_result",
            type: 'POST',
            data: {
                firm_id: $('#firm_id').val(),
                user_name: $('#user_name').val(),
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val()
            },
            success: function (result) {
                for_response();
                var table = $('#basicTable_call_back').DataTable();
                table.destroy();
                $('#result_div').html('');
                $('#result_div').html(result);
                datatable();
            }
        });
    });

    $("#yesin").live("click", function ()
    {

        var hidin = $(this).parent().parent().find('.id').val();
        // alert(hidin);
        $.ajax({
            url: BASE_URL + "cash_out_flow/cash_out_flow_delete",
            type: 'POST',
            data: {value1: hidin},
            success: function (result) {

                window.location.reload(BASE_URL + "cash_out_flow/cash_out_flow_list");
            }
        });

    });
</script>
<script>
    function datatable()
    {
        $('#basicTable_call_back').DataTable({
            "lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
            "pageLength": 50,
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
                var cols = [5, 6, 7];
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

    }
</script>
