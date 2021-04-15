<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>

<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js"></script>

<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>

<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />

<style>



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

        <h4>Purchase Payment List </h4>

    </div>

    <div class="contentpanel">

        <table class="table table-striped table-bordered responsive no-footer dtr-inline search_table_hide" style="display:none;">

            <tr>

                <td>Supplier

                    <input type="hidden" name="po_no" id="po_no" autocomplete="off" style="width:150px"/>

                    <select id='state' style="width: 170px;">

                        <option>Select</option>

                        <?php

                        if (isset($all_state) && !empty($all_state)) {

                            foreach ($all_state as $val) {

                                ?>

                                <option value='<?= $val['id'] ?>'><?= $val['state'] ?></option>

                                <?php

                            }

                        }

                        ?>

                    </select>

                </td>

                <td>

                    <select id='supplier'  class="form-control" style="width: 170px;">

                        <option>Select</option>

                        <?php

                        if (isset($all_supplier) && !empty($all_supplier)) {

                            foreach ($all_supplier as $val) {

                                ?>

                                <option value='<?= $val['id'] ?>'><?= $val['store_name'] ?></option>

                                <?php

                            }

                        }

                        ?>

                    </select>

                </td>

                <td>From Date</td>

                <td>

                    <div class="input-group" style="width:70%;">

                        <input type="text" id='from_date'  class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >



                    </div>

                </td>

                <td>To Date</td>

                <td>

                    <div class="input-group" style="width:70%;">

                        <input type="text"  id='to_date' class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >



                    </div>

                </td>

                <td><a style="float:right;" id='search' class="btn btn-default">Search</a></td>

            </tr>

        </table>

        <div id='result_div' class="panel-body">

            <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">

                <thead>

                    <tr>

                        <td class="action-btn-align">S.No</td>

                        <td class='action-btn-align'>PO #</td>

                        <td class="action-btn-align">Supplier Name</td>

                        <td class="action-btn-align">Invoice Amount</td>

                        <td class="action-btn-align">Paid Amount</td>

                        <td class="action-btn-align">Discount Amount</td>

                        <td class="action-btn-align">Balance</td>

                        <td class='action-btn-align'>Due Date</td>

                        <td class="hide_class action-btn-align">Payment Status</td>

                        <td class="hide_class action-btn-align">Action</td>

                    </tr>

                </thead>

                <tbody>

                    <?php

                    $paid = $bal = $inv = 0;

//echo '<pre>';

//print_r($all_receipt);

                    if (isset($all_receipt) && !empty($all_receipt)) {

                        $this->load->model('purchase_receipt/receipt_model');

                        $i = 1;

                        foreach ($all_receipt as $val) {

                            //  $inv = $inv + $val['net_total'];

                            $paid = $paid + $val['receipt_bill'][0]['receipt_paid'];

                            $get_pr_details = $this->receipt_model->getpr_details_based_on_pr($val['po_id']);

                            $over_all_net_total = 0;

                            foreach ($get_pr_details as $value) {



                                $deliver_qty = $value['delivery_qty'];

                                $per_cost = $value['per_cost'];

                                $gst = $value['tax'];

                                $cgst = $value['gst'];

                                $net_total = $deliver_qty * $per_cost + (($deliver_qty * $per_cost) * $gst / 100) + (($deliver_qty * $per_cost) * $cgst / 100) - $value['discount'] + $value['transport'];

                                $over_all_net_total += $net_total;

                                $inv = $inv + $net_total;

                            }

                            $bal = $bal + ($over_all_net_total - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']));

                            $balance = ($over_all_net_total - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']) > 0) ? number_format($over_all_net_total - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']), 2, '.', ',') : '0.00';

                           
                          $bal_data=  $over_all_net_total - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']);



 ?>
                            <tr>



                                <td class='first_td action-btn-align'><?php echo $i ?></td>

                                <td class='action-btn-align'><?php echo $val['po_no'] ?></td>

                                <td><?php echo $val['store_name'] ?></td>

                                <td  class="text_right"><?php echo round($over_all_net_total, 2) ?></td>

                                

                                <td  class="text_right"><?php echo number_format($val['receipt_bill'][0]['receipt_paid'], 2, '.', ',') ?></td>

                                <td  class="text_right"><?php echo number_format($val['receipt_bill'][0]['receipt_discount'], 2, '.', ',') ?></td>

                                <td  class="text_right">

                                    <?php //echo ($over_all_net_total - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']) > 0) ? number_format($over_all_net_total - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']), 2, '.', ',') : '0.00';        ?>

                                    <?php echo $bal_data; ?>



                                </td>

                                <td class='action-btn-align'><?php echo ($val['receipt_bill'][0]['next_date'] != '' && $val['receipt_bill'][0]['next_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['next_date'])) : ''; ?></td>

                                <td class="hide_class action-btn-align">

                                    <?php

                                    // if ($val['payment_status'] == 'Pending') {

                                    if ($balance == 0 || $balance == 0.00 || $balance == '0.00') {

                                        echo '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="Complete"><span class="fa fa-thumbs-up green">&nbsp;</span></a>';

                                        //  echo '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="In-Complete"><span  class="fa fa-thumbs-down blue">&nbsp;</span></a>';

                                    } else {

                                        echo '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="In-Complete"><span  class="fa fa-thumbs-down blue">&nbsp;</span></a>';

                                        //  echo '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="Complete"><span class="fa fa-thumbs-up green">&nbsp;</span></a>';

                                    }

                                    ?>

                                </td>

                                <td  class="hide_class action-btn-align">



                                    <?php

                                    if ($balance != 0 || $balance != 0.00 || $balance != '0.00') {

                                        //    if ($val['payment_status'] == 'Pending') {

                                        ?>

                                        <a href="<?php if ($this->user_auth->is_action_allowed('purchase', 'purchase_receipt', 'edit')): ?><?php echo $this->config->item('base_url') . 'purchase_receipt/manage_receipt/' . $val['id'] ?><?php endif ?>"data-toggle="tooltip" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('purchase', 'purchase_receipt', 'edit')): ?>alerts<?php endif ?>" title="" data-original-title="Edit"><span class="fa fa-edit "></span></a>





                                        <?php

                                    }

                                    ?>

                                    <a href="<?php if ($this->user_auth->is_action_allowed('purchase', 'purchase_receipt', 'view')): ?><?php echo $this->config->item('base_url') . 'purchase_receipt/view_receipt/' . $val['id'] ?><?php endif ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('purchase', 'purchase_receipt', 'view')): ?>alerts<?php endif ?>" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>

                                </td>

                            </tr>

                            <?php

                            $i++;

                        }

                        ?>



                        <?php

                    }

                    ?>

                </tbody>

                <tfoot>

                    <tr>

                        <td></td>

                        <td></td>

                        <td></td>

                        <td class="text_right total-bg"><?= number_format($inv, 2, '.', ',') ?></td>

                        <td class="text_right total-bg"><?= number_format($paid, 2, '.', ',') ?></td>

                        <td></td>

                        <td class="text_right total-bg"><?= number_format($bal, 2, '.', ',') ?></td>

                        <td></td>

                        <td class="hide_class"></td>

                        <td class="hide_class"></td>

                    </tr>

                </tfoot>

            </table>

            <div class="action-btn-align mt-top15">

                <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>

            </div>



        </div>



        <script>

            $('.print_btn').click(function () {

                window.print();

            });

        </script>

    </div><!-- contentpanel -->



</div><!-- mainpanel -->



<?php

if (isset($all_gen) && !empty($all_gen)) {

    foreach ($all_gen as $val) {

        ?>

        <form method="post" action="<?= $this->config->item('base_url') . 'po/force_to_complete/1' ?>">

            <div id="com_<?= $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header"><a class="close" data-dismiss="modal">×</a>

                            <h4 style="color:#06F">Force to Complete</h4>

                            <h3 id="myModalLabel">

                        </div>

                        <div class="modal-body">



                            <strong>

                                Are You Sure You Want to Complete This PO ?

                            </strong>

                            <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">

                                <tr>

                                    <td width="40%" style="text-align:right;" class="first_td1">Remarks&nbsp;</td>

                                    <td>

                                        <input type="text" style="width:220px;" class="form-control" name='complete_remarks' />

                                    </td>

                                </tr>

                            </table>

                            <input type="hidden" name="update_id" value="<?= $val['id'] ?>"  />



                        </div>

                        <div class="modal-footer">

                            <button class="btn btn-primary delete_yes yesin" id="yesin">Yes</button>

                            <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no"> No</button>

                        </div>

                    </div>

                </div>

            </div>

        </form>

        <?php

    }

}

?>

<script type="text/javascript">

    $(document).on('click', '.alerts', function () {

        sweetAlert("Oops...", "This Access is blocked!", "error");

        return false;

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

                var cols = [3, 4, 5, 6];

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

            url: BASE_URL + "po/search_result",

            type: 'GET',

            data: {

                po: $('#po_no').val(),

                state: $('#state').val(),

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