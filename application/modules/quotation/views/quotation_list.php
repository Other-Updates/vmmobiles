<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<style>
    .bg-red {
        background-color: #dd4b39 !important;
    }
    .bg-yellow
    {
        background-color:orange !important;
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
    <div class="media">
        <h4>Quotation List
            <?php
            $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
            if (($user_info[0]['role'] != 3)) {
                ?>
                <a href="<?php if ($this->user_auth->is_action_allowed('quotation', 'quotation', 'add')): ?><?php echo $this->config->item('base_url') . 'quotation/' ?><?php endif ?>" class="btn btn-success right topgen <?php if (!$this->user_auth->is_action_allowed('quotation', 'quotation', 'add')): ?>alerts<?php endif ?>"><span class="glyphicon glyphicon-plus"></span> New Quotation</a>
            <?php } ?>
        </h4>
    </div>
    <div class="contentpanel quo-tab">
        <div id='result_div' class="panel-body">
            <div class="tabpad">
                <table id="basicTable_call_back" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                    <thead>
                        <tr>
                            <td class="action-btn-align">S.No</td>
                            <td class="action-btn-align">Quotation No</td>
                            <td class="action-btn-align">Customer Name</td>
                            <td class="action-btn-align">Total Quantity</td>
                            <!--<td class="action-btn-align">Total Tax</td>-->
                            <!--<td>Sub Total</td>-->
                            <td class="action-btn-align">Total Amount</td>

                            <td class='action-btn-align'>Delivery Schedule</td>
                            <td class='action-btn-align'>Notification Date</td>
                            <!--<td>Mode of Payment</td>-->
                            <td class="action-btn-align">Created Date</td>
                            <td class="action-btn-align">Status</td>

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
                                    <!--<td class="text_right"><?= number_format($val['tax_details'][0]['tot_tax'], 2) < 0 ? 0 : number_format($val['tax_details'][0]['tot_tax'], 2); ?></td>-->
                                    <!--<td class="text_right"><?= number_format($val['subtotal_qty'], 2); ?></td>-->
                                    <td class="text_right"><?= number_format($val['net_total'], 2) ?></td>

                                    <td class='action-btn-align'><?= ($val['delivery_schedule'] != '1970-01-01') ? date('d-M-Y', strtotime($val['delivery_schedule'])) : ''; ?></td>
                                    <td class='action-btn-align'><?= ($val['notification_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['notification_date'])) : ''; ?></td>
                                    <!--<td><?= $val['mode_of_payment'] ?></td>-->
                                    <td class='action-btn-align'><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td>
                                    <td class='action-btn-align'>
                                        <?php
                                        if ($val['estatus'] == 1) {
                                            ?>
                                            <span class=" badge bg-red"> <?php echo 'Pending'; ?></span>

                                            <?php
                                        }
                                        if ($val['estatus'] == 2) {
                                            ?>
                                            <span class=" badge bg-green"> <?php echo 'Completed'; ?></span>
                                            <?php
                                        }
                                        if ($val['estatus'] == 4) {
                                            ?>
                                            <span class=" badge bg-green"> <?php echo 'Order Approved'; ?></span>
                                            <?php
                                        }
                                        if ($val['estatus'] == 5) {
                                            ?>
                                            <span class="badge bg-yellow"> <?php echo 'Order Reject'; ?></span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <?php if ($val['estatus'] == 2) {
                                        ?>
                                        <td class="hide_class action-btn-align">
                                            <a href="<?php if ($this->user_auth->is_action_allowed('quotation', 'quotation', 'view')): ?><?php echo $this->config->item('base_url') . 'quotation/quotation_view/' . $val['id'] ?><?php endif ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('quotation', 'quotation', 'view')): ?>alerts<?php endif ?>" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>
                                        </td>
                                    <?php } else {
                                        ?>
                                        <td width="80" class='hide_class  action-btn-align'>
                                            <?php
                                            $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
                                            if (($user_info[0]['role'] != 3)) {
                                                ?>
                                                <a href="<?php if ($this->user_auth->is_action_allowed('quotation', 'quotation', 'edit')): ?><?php echo $this->config->item('base_url') . 'quotation/quotation_edit/' . $val['id'] ?><?php endif ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('quotation', 'quotation', 'edit')): ?>alerts<?php endif ?>" title="" data-original-title="Edit"><span class="fa fa-edit "></span></a>

                                                <a href="<?php if ($this->user_auth->is_action_allowed('quotation', 'quotation', 'delete')): ?>#test3_<?php echo $val['id']; ?><?php endif ?>" data-toggle="modal" name="delete" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('quotation', 'quotation', 'delete')): ?>alerts<?php endif ?>" title="In-Active"><span class="fa fa-ban"></span></a>
                                            <?php } ?>
                                            <a href="<?php if ($this->user_auth->is_action_allowed('quotation', 'quotation', 'view')): ?><?php echo $this->config->item('base_url') . 'quotation/quotation_view/' . $val['id'] ?><?php endif ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('quotation', 'quotation', 'view')): ?>alerts<?php endif ?>" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
<!--                             <tr><td colspan="10">No data found...</td></tr>-->

                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text_right"></th>
                            <th class="text_right"></th>
                            <th class="text_right"></th>
                            <td class="action-btn-align total-bg"></td>
                            <td class="text_right total-bg"></td>

                            <th class="text_right"></th>
                            <th class="text_right"></th>
                            <th class="text_right"></th>
                            <th class="text_right"></th>
                            <th class="hide_class text_right"></th>

                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="action-btn-align mb-10">
                <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
            </div>
        </div>
        <?php
        if (isset($quotation) && !empty($quotation)) {
            foreach ($quotation as $val) {
                ?>


                <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                    <div class="modal-dialog">
                        <div class="modal-content modalcontent-top">
                            <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                                <h3 id="myModalLabel" class="inactivepop">Delete Quotation</h3>
                            </div>
                            <div class="modal-body">
                                Do You Want Delete This Quotation?<strong><?= $val['q_no']; ?></strong>
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
<script>
    $(document).on('click', '.alerts', function () {
        sweetAlert("Oops...", "This Access is blocked!", "error");
        return false;
    });
    $('.print_btn').click(function () {
        window.print();
    });
</script>
</div><!-- contentpanel -->

</div><!-- mainpanel -->
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
            url: BASE_URL + "po/search_result",
            type: 'GET',
            data: {
                po: $('#po_no').val(),
                style: $('#style').val(),
                supplier: $('#supplier').val(),
                supplier_name: $('#supplier').find('option:selected').text(),
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
    $(document).ready(function ()
    {
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
                var cols = [3, 4];
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

        $("#yesin").live("click", function ()
        {

            var hidin = $(this).parent().parent().find('.id').val();
            // alert(hidin);
            $.ajax({
                url: BASE_URL + "quotation/quotation_delete",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "quotation/quotation_list");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
</script>
