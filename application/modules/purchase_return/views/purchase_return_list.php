<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>

<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>

<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>

<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />



<style>

    .btn-xs {

        border-radius: 0px;

    }

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

    .btn-info { background-color:#ffffff;border-color: #000000;color:#a1a3a5;    padding: 2px 2px 2px 2px !important;}

    .btn-info:hover { background-color:#ff4081;border:1px solid #ff4081 !important;color:#ffffff; }



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

        <h4>Purchase Return List

        <!--<a href="<?php echo $this->config->item('base_url') . 'purchase_order/' ?>" class="btn btn-success right topgen"><span class="glyphicon glyphicon-plus"></span> Add Purchase Order</a>-->

        </h4>

    </div>

    <div class="contentpanel">

        <div id='result_div' class="panel-body mt-top5 pb0">

            <div class="tabpad">

                <table id="basicTable_call_back" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">

                    <thead>

                        <tr>

                            <td class="action-btn-align">S.No</td>

                            <td class="action-btn-align">Shop</td>

                            <td class="action-btn-align">Po No</td>

                            <td class="action-btn-align">Supplier</td>

                            <td class="action-btn-align">Total Quantity</td>

                            <td class="action-btn-align">Return Quantity</td>

                            <td class="action-btn-align">Delivery Quantity</td>

    <!--                        <td class="action-btn-align">Total Tax</td>-->

                            <!--<td class='action-btn-align'>Sub Total</td>-->

                            <td class="action-btn-align">Total Amount</td>

                            <td class='action-btn-align'>Delivery Schedule</td>

                            <!--<td>Mode of Payment</td>-->

                            <!--<td>Remarks</td>-->



                            <td class="hide_class action-btn-align">Action</td>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        if (isset($po) && !empty($po)) {

                            $this->load->model('purchase_return/purchase_return_model');

                            $i = 1;

                            $over_all_net_total = 0;

                            foreach ($po as $val) {

                                $over_all_net_total = 0;

                                $get_pr_details = $this->purchase_return_model->getpr_details_based_on_pr($val['id']);

//                                echo '<pre>';

//                                print_r($get_pr_details);

//                                exit;

                                // exit;

                                foreach ($get_pr_details as $key => $vals) {

                                    // $subtotal = $vals['sub_total'];

                                    $deliver_qty = $vals['delivery_qty'];

                                    $per_cost = $vals['per_cost'];

                                    $gst = $vals['tax'];

                                    $cgst = $vals['gst'];

                                    $net_total = $deliver_qty * $per_cost + (($deliver_qty * $per_cost) * $gst / 100) + (($deliver_qty * $per_cost) * $cgst / 100) - $vals['discount'] + $vals['transport'];



                                    $over_all_net_total += $net_total;

                                }

//                                echo '<pre>';

//                                print_r($over_all_net_total);

//                                exit;

                                ?>



                                <tr>

                                    <td class='first_td action-btn-align'><?= $i ?></td>

                                    <td class='action-btn-align'><?= $val['firm_name'] ?></td>

                                    <?php

                                    if (isset($val['return'][1]) && !empty($val['return'][1])) {

                                        ?>

                                        <td class='action-btn-align'>

                                            <a href="<?php if ($this->user_auth->is_action_allowed('purchase', 'purchase_return', 'view')): ?><?php echo $this->config->item('base_url') . 'purchase_return/po_views/' . $val['id'] ?><?php endif ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs  <?php if (!$this->user_auth->is_action_allowed('purchase', 'purchase_return', 'view')): ?>alerts<?php endif ?>" title="" data-original-title="View"><?= $val['po_no']; ?></a></td>

                                    <?php } else { ?>

                                        <td class='action-btn-align'><?= $val['po_no']; ?></td>

                                    <?php } ?>

                                    <td><?= $val['store_name'] ?></td>

                                    <?php

                                    if (isset($val['return'][1]) && !empty($val['return'][1])) {

                                        ?>

                                        <td class="action-btn-align"><?php echo $val['return'][1]['total_qty']; ?></td>

                                        <td class="action-btn-align"><?php echo ($val['return'][1]['total_qty']) - ($val['return'][0]['total_qty']); ?></td>

                                    <?php } else {

                                        ?>

                                        <td class="action-btn-align"><?= $val['total_qty'] ?></td>

                                        <td class="action-btn-align"><?= $val['return_quantity'][0]['return_quantity'] ?></td>

                                    <?php } ?>

                                    <td class="action-btn-align"><?= $val['delivery_qty'] ?></td>

            <!--                                <td class="action-btn-align"><?= $val['tax'] ?></td> -->

                                    <!--<td class="text_right"><?= number_format($val['subtotal_qty'], 2); ?></td>-->

                                    <td class="text_right"><?= $over_all_net_total; ?></td>

                                    <!--<td class="text_right"><?= $val['net_total']; ?></td>-->





                                    <td class='action-btn-align'><?= ($val['delivery_schedule'] != '1970-01-01') ? date('d-M-Y', strtotime($val['delivery_schedule'])) : ''; ?></td>

                                    <!--<td><?= $val['mode_of_payment'] ?></td>

                                    <!--<td><?= $val['remarks'] ?></td>-->



                                    <td class='hide_class  action-btn-align'>

                                        <a href="<?php if ($this->user_auth->is_action_allowed('purchase', 'purchase_return', 'edit')): ?><?php echo $this->config->item('base_url') . 'purchase_return/po_edit/' . $val['id'] ?><?php endif ?>" data-toggle="tooltip" class="tooltips btn btn-info btn-xs <?php if (!$this->user_auth->is_action_allowed('purchase', 'purchase_return', 'edit')): ?>alerts<?php endif ?>" title="" data-original-title="Edit"><span>Make Return</span></a>

                                        <?php

                                        // if (isset($val['return'][1]) && !empty($val['return'][1])) {

                                        ?>

                                        <a href="<?php if ($this->user_auth->is_action_allowed('purchase', 'purchase_return', 'view')): ?><?php echo $this->config->item('base_url') . 'purchase_return/po_view/' . $val['id'] ?><?php endif ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs  <?php if (!$this->user_auth->is_action_allowed('purchase', 'purchase_return', 'view')): ?>alerts<?php endif ?>" title="" data-original-title="View"><span class="fa fa-eye"></span></a>

                                        <?php //}        ?>

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

                            <td class="text_right"></td>

                            <td class="text_right"></td>

                            <td class="text_right"></td>

                            <td class="text_right"></td>

                            <td class="action-btn-align total-bg"></td>

                            <td class="action-btn-align total-bg"></td>

                            <td class="action-btn-align total-bg"></td>

                            <td class="text_right total-bg"></td>

                            <td class="text_right"></td>

                            <td class="hide_class text_right"></td>





                        </tr>

                    </tfoot>

                </table>

            </div>

            <div class="action-btn-align mb-10">

                <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>

            </div>

        </div>

        <?php

        if (isset($po) && !empty($po)) {

            foreach ($po as $val) {

                ?>



                <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">

                    <div class="modal-dialog">

                        <div class="modal-content modalcontent-top">

                            <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>

                                <h3 id="myModalLabel" class="inactivepop">In-Active user</h3>

                            </div>

                            <div class="modal-body">

                                Do You Want In-Active This Purchase Order?<strong><?= $val['po_no']; ?></strong>

                                <input type="hidden" value="<?php echo $val['id']; ?>" class="id" />

                            </div>

                            <div class="modal-footer action-btn-align">

                                <button class="btn btn-primary delete_yes" id="yesin">Yes</button>

                                <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no">No</button>

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

                var cols = [4, 5, 6, 7];

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

                url: BASE_URL + "purchase_order/po_delete",

                type: 'POST',

                data: {value1: hidin},

                success: function (result) {



                    window.location.reload(BASE_URL + "purchase_order/purchase_order_list");

                }

            });



        });



        $('.modal').css("display", "none");

        $('.fade').css("display", "none");



    });

</script>

