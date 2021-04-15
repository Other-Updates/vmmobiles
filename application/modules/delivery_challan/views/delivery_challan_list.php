<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?php echo $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<style>
    .bg-red {
        background-color: #dd4b39 !important;
    }
    .bg-green {
        background-color:#09a20e !important;
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
        <h4>Delivery Challan List
<!--            <a href="<?php if ($this->user_auth->is_action_allowed('delivery_challan', 'delivery_challan', 'add')): ?><?php echo $this->config->item('base_url') . 'delivery_challan/' ?><?php endif ?>" class="btn btn-success right topgen <?php if (!$this->user_auth->is_action_allowed('delivery_challan', 'delivery_challan', 'add')): ?>alerts<?php endif ?>"><span class="glyphicon glyphicon-plus"></span> Add Delivery Challan</a>-->
        </h4>
    </div>
    <div class="contentpanel">
        <div id='result_div' class="panel-body">
            <table id="basicTable_call_back" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline quanty-cntr delquant-cntr totamt-right invstatus-cntr delstatus-cntr">
                <thead>
                    <tr>
                        <td width='5%'>S.No</td>
                        <td width='15%'>Firm Name</td>
                        <td width='10%'>Invoice No</td>
                        <td width='10%'>Customer Name</td>
                        <td width='5%' class="action-btn-align">Quantity</td>
                        <td width='5%' class="action-btn-align">Delivered Quantity</td>
                        <td width='10%' >Total Amount</td>
                        <td width='10%' class="action-btn-align">Invoice Status</td>
                        <td width='10%' class="action-btn-align">Delivery Status</td>
                        <td width='10%' class="hide_class action-btn-align">Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($po) && !empty($po)) {
                        $i = 1;
                        foreach ($po as $val) {
                            ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $val['firm_name'] ?></td>
                                <td><?php echo $val['inv_id'] ?></td>
                                <td><?php echo $val['store_name'] ?></td>
                                <td class="action-btn-align"><?php echo $val['total_qty'] ?></td>
                                <td class="action-btn-align"><?php echo $val['delivery_qty'] ?></td>
                                <td class="text_right"><?php echo number_format($val['net_total'], 2); ?></td>
                                <td class="action-btn-align">
                                    <?php if ($val['invoice_status'] == 'waiting') { ?>
                                        <span class=" badge  bg-red">Waiting For Approval</span>
                                    <?php } else if ($val['invoice_status'] == 'approved') { ?>
                                        <span class=" badge bg-green">Approved</span>
                                    <?php } ?>
                                </td>
                                <td class="action-btn-align">
                                    <?php if ($val['delivery_status'] == 'partially_delivered') { ?>
                                        <span  class="badge  bg-yellow update_status" onclick="check(<?php echo $val['id'] ?>);">Partially Delivered</span>
                                    <?php } else if ($val['delivery_status'] == 'pending') { ?>
                                        <span  class="badge bg-red update_status" onclick="check(<?php echo $val['id'] ?>);">Pending</span>
                                    <?php } else {
                                        ?>
                                        <span class = "badge bg-green update_status" onclick="check(<?php echo $val['id'] ?>);">Delivered</span>
                                    <?php }
                                    ?>
                                </td>
                                <td class='hide_class  action-btn-align'>
                                    <!--<a href="<?php if ($this->user_auth->is_action_allowed('delivery_challan', 'delivery_challan', 'edit')): ?><?php echo $this->config->item('base_url') . 'delivery_challan/dc_edit/' . $val['id'] ?><?php endif ?>" data-toggle="tooltip" class="tooltips btn btn-info btn-xs <?php if (!$this->user_auth->is_action_allowed('delivery_challan', 'delivery_challan', 'edit')): ?>alerts<?php endif ?>" title="" data-original-title="Edit"><span class="fa fa-edit "></span></a>-->

                                    <a href="<?php if ($this->user_auth->is_action_allowed('delivery_challan', 'delivery_challan', 'view')): ?><?php echo $this->config->item('base_url') . 'delivery_challan/dc_view/' . $val['id'] ?><?php endif ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('delivery_challan', 'delivery_challan', 'view')): ?>alerts<?php endif ?>" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>
                                </td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class=""></td>
                        <td class="action-btn-align total-bg"></td>
                        <td class="action-btn-align total-bg"></td>
                        <td class="text_right total-bg"></td>
                        <td></td>
                        <td></td>
                        <td class="hide_class "></td>
                    </tr>
                </tfoot>
            </table>
            <div class="action-btn-align mb-10">
                <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
            </div>
        </div>
        <?php
        if (isset($po) && !empty($po)) {
            foreach ($po as $val1) {
                ?>
                <div id="challan_update_<?php echo $val1['id']; ?>" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content modalcontent-top">
                            <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>

                                <h3 id="myModalLabel" class="inactivepop">Change Delivery Status</h3>
                            </div>
                            <div class="modal-body">
                                <br />
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Status</label>
                                    <div class="col-sm-8 relative">
                                        <select name="status" id="status">
                                            <option value="pending" <?php
                                            if ($val1['delivery_status'] == 'pending') {
                                                echo "selected";
                                            }
                                            ?> >Pending</option>
                                            <option value="partially_delivered" <?php
                                            if ($val1['delivery_status'] == 'partially_delivered') {
                                                echo "selected";
                                            }
                                            ?>>Partially Delivered</option>
                                            <option value="delivered" <?php
                                            if ($val1['delivery_status'] == 'delivered') {
                                                echo "selected";
                                            }
                                            ?>>Delivered</option>
                                        </select>
                                        <input type="hidden" value="<?php echo $val1['id']; ?>" id="d_id" />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer action-btn-align">
                                <button class="btn btn-primary update_yes" id="update_ok" >Update</button>
                                <button type="button" class="btn btn-danger1 delete_all pull-right"  data-dismiss="modal" id="no">Cancel</button>
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
    });</script>
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
    });</script>
<script type="text/javascript">
    function check(val)
    {
        $('#challan_update_' + val).modal('show');
    }
    $(document).ready(function ()
    {
        $('#basicTable_call_back').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "retrieve": true,
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('delivery_challan/ajaxList/'); ?>",
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
                var cols = [4, 5, 6];
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
                        pageTotal = pageTotal.toFixed(2); /* float */

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
                url: BASE_URL + "purchase_order/po_delete",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "purchase_order/purchase_order_list");
                }
            });
        });
        /* $('.update_status').click(function () {

         $('.challan_update').modal({
         backdrop: 'static',
         keyboard: false
         });
         $('#challan_update').modal('show');
         });*/


        $("#update_ok").live("click", function ()
        {
            var id = $(this).parent().parent().find('#d_id').val();
            var status = $(this).parent().parent().find('#status').val();
            $.ajax({
                url: BASE_URL + "delivery_challan/change_del_status",
                type: 'POST',
                data: {value1: id, value2: status},
                success: function (result) {
                    window.location.reload(BASE_URL + "delivery_challan/delivery_challan_list");
                }
            });
        });
        $('.modal').css("display", "none");
        $('.fade').css("display", "none");
    });
</script>
