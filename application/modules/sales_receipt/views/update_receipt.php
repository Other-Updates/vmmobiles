<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<style>
    .ui-datepicker td.ui-datepicker-today a {
        background:#999999;
    }
    .full {
        width:100%;
    }
</style>


<div class="mainpanel">
    <div class="media">
        <h4>Update Sales Receipt</h4>
    </div>
    <div class="contentpanel panel-body mb-50">
        <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
            <thead>
            <th colspan="9">Payment History</th>

            </thead>
            <thead>
            <th width="1%">S&nbsp;No</th>
            <th>Receipt&nbsp;NO</th>
            <th>Created Date</th>
            <th width="5%">Payment&nbsp;Terms</th>
            <th width="10%">Bank&nbsp;Details</th>
            <th>Received&nbsp;Amount</th>
            <th>Discount&nbsp;(&nbsp;%&nbsp;)</th>
            <th>Remarks</th>
            <?php if ($receipt_details[0]['inv_id'] != 'Wings Invoice') { ?>
                <th class="hide_class">Action</th>
            <?php } ?>
            </thead>
            <tbody id='receipt_info'>
                <?php
                if (isset($receipt_details[0]['receipt_history']) && !empty($receipt_details[0]['receipt_history'])) {
                    $i = 1;
                    $dis = 0;
                    $paid = 0;
                    foreach ($receipt_details[0]['receipt_history'] as $val) {

                        $paid = $paid + $val['bill_amount'];
                        $dis = $dis + $val['discount'];
                        ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <th class="rec_no<?php echo $val['id'] ?>"><?php echo $val['receipt_no'] ?></th>
                            <!--<th><?php echo $val['recevier'] ?></th>-->
                            <td class="rec_c_date<?php echo $val['id'] ?>"><?php echo date('d-M-Y', strtotime($val['created_date'])) ?></td>
                    <input type='hidden'  class="datepicker rec_d_date<?php echo $val['id'] ?>" name='due_date'  value="<?php echo date('d-M-Y', strtotime($val['due_date'])) ?>" />
                    <input class='rec_acc_no<?php echo $val['id'] ?>'   type='hidden' value="<?php echo $val['ac_no'] ?>" name='ac_no'/><div class="clearfix"></div>
                    <input  class='rec_branch<?php echo $val['id'] ?>'  type='hidden' value="<?php echo $val['branch'] ?>" name='branch'/><div class="clearfix"></div>
                    <input  class='rec_dd<?php echo $val['id'] ?>'  type='hidden' value="<?php echo $val['dd_no'] ?>" name='dd_no' /><div class="clearfix"></div>
                    <input type="hidden" class="rec_disc<?php echo $val['id'] ?>" name="discount" value="<?php echo $val['discount'] ?>">
                    <input type="hidden" class="rec_disc_per<?php echo $val['id'] ?>" name="discount_per" value="<?php echo $val['discount_per'] ?>">
                    <input type="hidden" class="rec_terms<?php echo $val['id'] ?>" name="terms" value="<?php echo $val['terms'] ?>">
                    <input type="hidden" class="recp_id<?php echo $val['id'] ?>" name="terms" value="<?php echo $val['receipt_id'] ?>">
                    <td>
                        <?php
                        if ($val['terms'] == 1)
                            echo "CASH";
                        elseif ($val['terms'] == 2)
                            echo "DD";
                        elseif ($val['terms'] == 3)
                            echo "CHEQUE";
                        elseif ($val['terms'] == 4)
                            echo "NEFT";
                        elseif ($val['terms'] == 5)
                            echo "RTGS";
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($val['terms'] != 1 && $val['terms'] != 4 && $val['terms'] != 5) {
                            echo "<b>A/C&nbsp;NO</b>    :<br>" . $val['ac_no'] . '<br>';
                            echo "<b>Bank</b>    :<br>" . $val['branch'] . '<br>';
                            echo "<b>DD&nbsp;/&nbsp;Cheque&nbsp;NO</b>:<br>" . $val['dd_no'] . '<br>';
                        } else
                            echo "-";
                        ?>
                    </td>

                    <td class="text_right rec_bill<?php echo $val['id'] ?>"><?php echo number_format($val['bill_amount'], 2, '.', ',') ?></td>
                    <td class="text_right"><?php echo number_format($val['discount'], 2, '.', ',') ?> ( <?= $val['discount_per'] ?> %)</td>
                    <td class="rec_remarks<?php echo $val['id'] ?>"><?php echo ($val['remarks']) ? $val['remarks'] : '-'; ?></td>
                    <?php if ($receipt_details[0]['inv_id'] != 'Wings Invoice') { ?>
                        <td class="hide_class">
                            <button type="button" rec_id ="<?php echo $val['id'] ?>" class="btn btn-info edit" onclick="pay_edit(<?php echo $val['id']; ?>)"id="edit_model" data-toggle="modal" data-target="#Model" title="" data-original-title="Edit"><span class="fa fa-edit "></span></button>
                            <button type="button" rec_id ="<?php echo $val['id'] ?>" class="btn btn-primary download"><span class="glyphicon glyphicon-download"></span></button>
                            <button type="button" rec_id ="<?php echo $val['id'] ?>"class="btn btn-defaultprint6 print"><span class="glyphicon glyphicon-print"></span></button>
                        </td>
                    <?php } ?>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
                <tfoot>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text_right"><?php echo number_format($paid, 2, '.', ',') ?></td>

                <?php if ($receipt_details[0]['inv_id'] != 'Wings Invoice') { ?>
                    <td class="text_right"><?php echo number_format($dis, 2, '.', ',') ?></td>
                    <td></td>
                    <td></td>
                <?php } else { ?>
                    <td style="text-align:center;"><?php echo number_format($dis, 2, '.', ',') ?></td>
                    <td></td>
                <?php } ?>

                </tfoot>
                <?php
            } else {
                echo "<tr><td colspan='9'>No Data Found</td> </tr>";
            }
            ?>
            </tbody>
        </table>
        <?php
        if (isset($customer_details) && !empty($customer_details)) {
            if ($customer_details[0]['credit_days'] > 0) {
                $advance = $customer_details[0]['advance'];
                $credit_days = $customer_details[0]['credit_days'];
                $inv_created_date = $receipt_details[0]['created_date'];
                $due_date = date('d-m-Y', strtotime($inv_created_date . "+" . $credit_days . " days"));
                $class = 'no-datepicker';
                $disabled = 'readonly';
            } else {
                $due_date = '';
                $class = 'datepicker';
                $disabled = '';
            }
        } else {
            $due_date = '';
            $class = 'datepicker';
            $disabled = '';
        }
        ?>
        <form method="post">
            <input type="hidden" name="receipt_bill[receipt_id]" value="<?php echo $receipt_details[0]['id'] ?>">
            <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                <thead>
                <th colspan="4">Sales Invoice Details</th>
                </thead>
                <thead>
                <th>S No</th>
                <th>Invoice NO</th>
                <th>Invoice Date</th>
                <th>Amount</th>
                </thead>
                <tbody id='receipt_info'>
                    <tr>
                        <td>1</td>
                        <td><?php echo $receipt_details[0]['inv_id'] ?></td>
                        <td><?php echo date('d-M-Y', strtotime($receipt_details[0]['created_date'])) ?></td>
                        <td><?php echo number_format($receipt_details[0]['net_total'], 2, '.', ',') ?></td>
                    </tr>
                <input type="hidden" value="<?php echo ($receipt_details[0]['net_total'] - $dis) - $paid ?>" id="inv_amount" />

                <input type="hidden" value="<?php echo $customer_details[0]['advance']; ?>" id="advance" />

                <tr><td colspan="3" style="text-align:right;">Invoice Amount</td><td><?php echo number_format($receipt_details[0]['net_total'], 2, '.', ',') ?></td></tr>
                <tr><td colspan="3" style="text-align:right;">Advance Amount</td><td><?php echo number_format($customer_details[0]['advance'], 2, '.', ',') ?></td></tr>
                <tr><td colspan="3" style="text-align:right;">Total Discount</td><td><?php echo number_format($dis, 2, '.', ',') ?></td></tr>
                <tr><td colspan="3" style="text-align:right;">Total Received Amount</td><td><?php echo number_format($paid, 2, '.', ',') ?></td></tr>
                <tr>
                    <td colspan="3" style="text-align:right;">Receipt NO</td><td><input name="receipt_bill[receipt_no]" type="text" value="<?php echo $last_id[0]['value']; ?>"></td>
                </tr>
                <tr>
                    <td colspan='3' style='text-align: right;'>Payment Terms</td><td  style='align: right;'>
                        <select class='form-control' id='terms1' style="width:170px; display:none;" name='receipt_bill[terms]' tabindex="1" id="recp_no">
                            <option class="1" value='1'>CASH</option>
                        </select>
                        <select class='form-control' id='terms' style="width:170px;" name='receipt_bill[terms]' tabindex="1">
                            <option class="1" value='1'>CASH</option>
                            <option class="2" value='2'>DD</option>
                            <option class="3" value='3'>CHEQUE</option>
                            <option class="4" value='4'>NEFT</option>
                            <option class="5" value='5'>RTGS</option>
                        </select>
                    </td>
                </tr>

                <tr class='show_tr' style='display:none'>
                    <td colspan='3' style='text-align: right;'>A / C NO</td>
                    <td  style='align: right;'>
                        <input id='ac_no'  class='form-control'  style=' width:170px ;float:left;' type='text'  name='receipt_bill[ac_no]' tabindex="1"/><div class="clearfix"></div>
                        <span id="receiptuperror" style="color:#F00;" ></span>
                    </td>
                </tr>
                <tr class='show_tr' style='display:none'>
                    <td colspan='3' style='text-align: right;'>Bank</td>
                    <td  style='align: right;'>
                        <input id='branch'  class='form-control'  style=' width:170px ;float:left;' type='text'  name='receipt_bill[branch]' tabindex="1"/><div class="clearfix"></div>
                        <span id="receiptuperror1" style="color:#F00;" ></span>
                    </td>
                </tr>
                <tr  class='show_tr' style='display:none'>
                    <td colspan='3' style='text-align: right;'>DD / Cheque NO</td>
                    <td  style='align: right;'>
                        <input id='dd_no'  class='form-control' style=' width:170px ;float:left;' type='text'  name='receipt_bill[dd_no]' tabindex="1"/><div class="clearfix"></div>
                        <span id="receiptuperror2" style="color:#F00;" ></span><div class="clearfix"></div><span id="dupperror" style="color:#F00;" ></span></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right;"><span style='  position: relative; top: 10px;'>Discount &nbsp; </span>
                        <input id='discount_per' autocomplete='off'  class='form-control' style=' width:170px;float:right;' type='text'  name='receipt_bill[discount_per]' tabindex="1"/>
                    </td>
                    <td>
                        <input id='discount'  class='form-control dot_val' style=' width:170px ;float:left;' type='text'  name='receipt_bill[discount]' tabindex="1"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right;">Paid Amount</td>
                    <td>
                        <input id='paid'  class='form-control dot_value' type='text'  style=' width:170px ;float:left;'  name='receipt_bill[bill_amount]'  tabindex="1"/><div class="clearfix"></div>
                        <span id="receiptuperror3" style="color:#F00;" ></span> </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right;">Due Date</td>
                    <td>
                        <input type='text'  style=' width:170px ;float:left;'  class="<?php echo $class; ?>" name='receipt_bill[due_date]'  value="<?php echo $due_date ?>" <?php echo $disabled; ?> tabindex="1"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right;">Created Date</td>
                    <td>
                        <input type='text'  id='c_date' style=' width:170px ;float:left;'  class="datepicker" name='receipt_bill[created_date]'  tabindex="1"/><div class="clearfix"></div>
                        <span id="date_err" style="color:#F00;" ></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right;">Balance</td>
                    <td>
                        <input id='balance'  class='form-control' type='text'  style=' width:170px ;float:left;'  name='balance'   value='<?php echo (($receipt_details[0]['net_total'] - $dis) - $paid) - $customer_details[0]['advance']; ?>'  readonly='readonly' tabindex="1"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right;">Remarks</td>
                    <td>
                        <input type='text'  style='width:170px ;float:left;'  class="form-control" name='receipt_bill[remarks]'  tabindex="1"/>
                    </td>
                </tr>
                <tr><td class="action-btn-align"  colspan="4"> <input  type="submit" class="btn btn-success" value="Pay" id="pay" tabindex="1"/> </td></tr>

                </tbody>
            </table>
        </form>
    </div><!-- contentpanel -->
</div><!-- mainpanel -->

<div id="myModaledit" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content"style="overflow-y:auto; ">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h6 class="modal-title">Edit Payment History</h6>
            </div>
            <form action="" id="form_id" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <input type="hidden" id="invc_id" name="inv_id" value="">
                            <!--                            <div class="col-md-12">

                                                            <div class="row">

                                                                <span class="col-md-4">Invoice Amount</span>

                                                                <div class="form-group col-md-8">

                                                                    <input type="text" name="inv_amt" value="<?php echo number_format($receipt_details[0]['net_total'], 2, '.', ',') ?>"/>

                                                                </div>

                                                            </div>

                                                        </div>-->
                            <div class="col-md-12">
                                <div class="row" style="border-top:1px solid white;">
                                    <span class="col-md-4">Receipt NO</span>
                                    <div class="form-group col-md-8">
                                        <input type="text" id="rec_nbr" name="receipt_no" class="full" type="text" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <span class="col-md-4">Payment Terms</span>
                                    <div class="form-group col-md-8">
                                        <select class='form-control full' id='terms11' style="width:170px; display:none;" name='terms' tabindex="1" id="recp_no">
                                            <option class="1" value='1'>CASH</option>
                                        </select>
                                        <select class='form-control full' id='terms_change' style="width:170px;" name='terms' tabindex="1">
                                            <option class="1" value="1" <?php ($val['terms'] == 1) ? 'selected' : '' ?>>CASH</option>
                                            <option class="2" value='2' <?php ($val['terms'] == 2) ? 'selected' : '' ?>>DD</option>
                                            <option class="3" value='3' <?php ($val['terms'] == 3) ? 'selected' : '' ?>>CHEQUE</option>
                                            <option class="4" value='4' <?php ($val['terms'] == 4) ? 'selected' : '' ?>>NEFT</option>
                                            <option class="5" value='5' <?php ($val['terms'] == 5) ? 'selected' : '' ?>>RTGS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 show_div" style='display:none'>
                                <div class="row">
                                    <span class="col-md-4">A / C NO</span>
                                    <div class="form-group col-md-8">
                                        <input id='ac_no1'  class='form-control full'  style=' width:170px ;float:left;' type='text' value="" name='ac_no' tabindex="1"/><div class="clearfix"></div>
                                        <span id="receiptuperrorr" style="color:#F00;" ></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 show_div" style='display:none'>
                                <div class="row">
                                    <span class="col-md-4">Bank</span>
                                    <div class="form-group col-md-8">
                                        <input id='branch1'  class='form-control full'  style=' width:170px ;float:left;' type='text' value="" name='branch' tabindex="1"/><div class="clearfix"></div>
                                        <span id="receiptuperror11" style="color:#F00;" ></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 show_div" style='display:none'>
                                <div class="row">
                                    <span class="col-md-4">DD / Cheque NO</span>
                                    <div class="form-group col-md-8">
                                        <input id='dd_no1'  class='form-control full' style=' width:170px ;float:left;' type='text' value="" name='dd_no' tabindex="1"/><div class="clearfix"></div>
                                        <span id="receiptuperror22" style="color:#F00;" ></span><div class="clearfix"></div><span id="dupperror" style="color:#F00;" ></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row" >
                                    <span class="col-md-4" >Discount</span>
                                    <div class="form-group col-md-4" >
                                        <input id='discount_per1' autocomplete='off'  class='form-control' style=' width:170px;' type='text'  value="" name='discount_per' tabindex="1"/>
                                    </div>
                                    <div  class="form-group col-md-4">
                                        <input id='discount1'  class='form-control dot_val' style=' width:163px ;float:left;' type='text' value=""  name='discount' tabindex="1"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <span class="col-md-4">Paid Amount</span>
                                    <div class="form-group col-md-8">
                                        <input id='paid1'  class='form-control dot_value full' type='text'  style=' width:170px ;float:left;' value=""  name='bill_amount'  tabindex="1"/><div class="clearfix"></div>
                                        <span id="receiptuperror33" style="color:#F00;" ></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <span class="col-md-4">Due Date</span>
                                    <div class="form-group col-md-8">
                                        <input type='text' id="d_date" style=' width:170px ;float:left;'  class="datepicker full" name='due_date'  value=""  tabindex="1"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <span class="col-md-4">Created Date</span>
                                    <div class="form-group col-md-8">
                                        <input type='text'  id='cr_date' style=' width:170px ;float:left;'  class="datepicker full" name='created_date' value="" tabindex="1"/><div class="clearfix"></div>
                                        <span id="date_err11" style="color:#F00;" ></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <span class="col-md-4">Remarks</span>
                                    <div class="form-group col-md-8">
                                        <input type='text' id="remrks"  style='width:170px ;float:left;'  class="form-control full" name='remarks' value="" tabindex="1"/>   </div>
                                </div>
                            </div>
                            <div class="modal-footer" class="action-btn-align">
                                <input  type="submit" class="btn btn-info " value="update" id="Update" tabindex="1"/>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('#recp_no').focus();
        jQuery('.datepicker').datepicker();
    });

    $('.print').click(function () {
        r_id = '<?php echo $receipt_details[0]['id'] ?>';
        var link = document.createElement('a');
        $rec_id = $(this).attr('rec_id');
        link.href = '<?php echo base_url(); ?>sales_receipt/print_receipt/' + r_id + '/' + $rec_id;
        link.target = '_blank';
        link.click();
    });

    $('.download').click(function () {
        r_id = '<?php echo $receipt_details[0]['id'] ?>';
        var link = document.createElement('a');
        $rec_id = $(this).attr('rec_id');
        //link.download = file_name;
        link.href = '<?php echo base_url(); ?>sales_receipt/download_receipt/' + r_id + '/' + $rec_id;
        link.click();
    });

    $('#terms').live('change', function () {
        if ($(this).val() == 2 || $(this).val() == 3)
            $('.show_tr').show();
        else
            $('.show_tr').hide();
    });

    $('.receiver').live('click', function () {
        if ($(this).val() == 'agent') {

            $('.select_agent').css('display', 'block');
            $('#terms1').css('display', 'block');
            $('#terms').css('display', 'none');
        } else {
            $('.select_agent').css('display', 'none');
            $('#terms1').css('display', 'none');
            $('#terms').css('display', 'block');
        }
    });
    // Date Picker
    $('#add_package').live('click', function () {
        $('.sty_class').each(function () {

            var s_html = $(this).closest('tr').find('.size_val');
            var size_name = $(this).closest('tr').find('.size_name');
            var cort_class = $(this).closest('tr').find('.cort_class').val();
            var sty_class = $(this).closest('tr').find('.sty_class').val();
            var col_class = $(this).closest('tr').find('.col_class').val();

            $(s_html).each(function () {
                $(this).attr('name', 'size[' + sty_class + col_class + cort_class + '][]');
            });
            $(size_name).each(function () {
                $(this).attr('name', 'size_name[' + sty_class + col_class + cort_class + '][]');
            });
        });
    });

    $(document).ready(function () {

        jQuery('#from_date1').datepicker();
    });
    $('#cor_no').live('keyup', function () {
        var select_op = '';
        if (Number($(this).val()))
        {
            select_op = select_op + '<select class="cort_class"  name="corton[]"><option>Select</option>';
            for (i = 1; i <= Number($(this).val()); i++)
            {
                select_op = select_op + '<option value=' + i + '>' + i + '</option>';
            }
            select_op = select_op + '</select>';
            $('.cor_class').html(select_op);
        }
    });
    $('#customer').live('change', function () {
        for_loading();
        $.ajax({
            url: BASE_URL + "sales_receipt/get_all_pending_invoice",
            type: 'GET',
            data: {
                c_id: $(this).val()
            },
            success: function (result) {
                $('#s_div').html(result);
            }
        });
        $.ajax({
            url: BASE_URL + "sales_receipt/get_invoice_view",
            type: 'GET',
            data: {
                c_id: $(this).val()
            },
            success: function (result) {
                for_response();
                $('#receipt_info').html(result);
            }
        });

    });
    $('.so_id').live('click', function () {
        var s_arr = [];
        var i = 0;
        $('.so_id').each(function () {
            if ($(this).attr('checked') == 'checked')
            {
                s_arr[i] = $(this).val();
                i++;
            }
        });
        for_loading();
        $.ajax({
            url: BASE_URL + "sales_receipt/get_inv",
            type: 'GET',
            data: {
                inv_id: s_arr,
                c_id: $('#customer').val()
            },
            success: function (result) {
                for_response();
                $('#receipt_info').html(result);
            }
        });
    });
    $('#discount').live('keyup', function () {
        total = 0;
        total = (Number($('#inv_amount').val()) - Number($(this).val())) - Number($('#paid').val());
        total = total - Number($('#advance').val());
        $('#balance').val(total.toFixed(2));

        var tt = ($(this).val() / $('#inv_amount').val()) * 100;
        $('#discount_per').val(tt.toFixed(2));
    });
    $('#paid').live('keyup', function () {
        total = 0;
        total = (Number($('#inv_amount').val()) - Number($('#discount').val())) - Number($(this).val());
        total = total - Number($('#advance').val());
        $('#balance').val(total.toFixed(2));
    });
    $('#discount_per').live('keyup', function () {
        var tt = $('#inv_amount').val() * ($(this).val() / 100);
        $('#discount').val(tt.toFixed(2));

        total = 0;
        total = (Number($('#inv_amount').val()) - Number($('#discount').val())) - Number($('#paid').val());
        total = total - Number($('#advance').val());
        $('#balance').val(total.toFixed(2));
    });
</script>
<script type="text/javascript">

    $(".dduplication").live('blur', function ()
    {
        //alert("hi");
        var checkno = $(".dduplication").val();
        if (checkno == "")
        {
        } else
        {
            $.ajax(
                    {
                        url: BASE_URL + "sales_receipt/update_checking_payment_checkno",
                        type: 'POST',
                        data: {value1: checkno},
                        success: function (result)
                        {
                            $("#dupperror").html(result);

                        }
                    });
        }
    });
    $("#paid").live('blur', function ()
    {
        var paid = $('#paid').val();
        var bal = $('#balance').val();
        if (paid == "")
        {
            $("#receiptuperror3").html("Required Field");

        } else if (bal < 0)
        {
            $("#receiptuperror3").html("This Field Less then the Balance Amount");
        } else
        {
            $("#receiptuperror3").html("");
        }
    });
    $("#ac_no").live('blur', function ()
    {
        var ac_no = $("#ac_no").val();
        if (ac_no == "" || ac_no == null || ac_no.trim().length == 0)
        {
            $("#receiptuperror").html("Required Field");
        } else
        {
            $("#receiptuperror").html("");
        }
    });
    $("#branch").live('blur', function ()
    {
        var branch = $("#branch").val();
        if (branch == "" || branch == null || branch.trim().length == 0)
        {
            $("#receiptuperror1").html("Required Field");
        } else
        {
            $("#receiptuperror1").html("");
        }
    });
    $("#dd_no").live('blur', function ()
    {
        var dd_no = $("#dd_no").val();
        if (dd_no == "" || dd_no == null || dd_no.trim().length == 0)
        {
            $("#receiptuperror2").html("Required Field");
        } else
        {
            $("#receiptuperror2").html("");
        }
    });

    $('#pay').live('click', function ()
    {
        i = 0;
        var paid = $('#paid').val();
        var bal = $('#balance').val();
        var date = $('#c_date').val();
        if (date == "")
        {
            $("#date_err").html("Required Field");
            i = 1;

        } else
        {
            $("#date_err").html("");
        }
        if (paid == "")
        {
            $("#receiptuperror3").html("Required Field");
            i = 1;

        } else if (bal < 0)
        {
            $("#receiptuperror3").html("This Field Less then the Balance Amount");
            i = 1;
        } else
        {
            $("#receiptuperror3").html("");
        }
        var terms = $("#terms").val();
        if (terms == 1 || terms == 4 || terms == 5)
        {
        } else
        {
            var ac_no = $("#ac_no").val();
            if (ac_no == "" || ac_no == null || ac_no.trim().length == 0)
            {
                $("#receiptuperror").html("Required Field");
                i = 1;
            } else
            {
                $("#receiptuperror").html("");
            }
            var branch = $("#branch").val();
            if (branch == "" || branch == null || branch.trim().length == 0)
            {
                $("#receiptuperror1").html("Required Field");
                i = 1;
            } else
            {
                $("#receiptuperror1").html("");
            }
            var dd_no = $("#dd_no").val();
            if (dd_no == "" || dd_no == null || dd_no.trim().length == 0)
            {
                $("#receiptuperror2").html("Required Field");
                i = 1;
            } else
            {
                $("#receiptuperror2").html("");
            }
            var m = $('#dupperror').html();
            if ((m.trim()).length > 0)
            {
                i = 1;
            }
        }
        if (i == 1)
        {
            return false;
        } else
        {
            return true;
        }
    });

</script>
<script>
    // jQuery ".Class" SELECTOR.
    $(document).ready(function () {
        $('.dot_value').keypress(function (event) {
            return isNumber(event, this)
        });
    });
    // THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
    function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
                (charCode != 45 || $(element).val().indexOf('-') != -1) && // “-” CHECK MINUS, AND ONLY ONE.
                (charCode != 46 || $(element).val().indexOf('.') != -1) && // “.” CHECK DOT, AND ONLY ONE.
                (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
    function pay_edit(id) {

        var rec_no = $(".rec_no" + id).text();
        var rec_c_date = $(".rec_c_date" + id).text();
        var rec_d_date = $(".rec_d_date" + id).val();
        var rec_acc_no = $(".rec_acc_no" + id).val();
        var rec_branch = $(".rec_branch" + id).val();
        var rec_dd = $(".rec_dd" + id).val();
        var rec_terms = $(".rec_terms" + id).val();
        var rec_bill = $(".rec_bill" + id).text();
        var rec_disc = $(".rec_disc" + id).val();
        var rec_disc_per = $(".rec_disc_per" + id).val();
        var recp_id = $(".recp_id" + id).val();
        var rec_remarks = $(".rec_remarks" + id).text();

        $('#rec_nbr').val(rec_no);
        $('#terms_change').val(rec_terms);
        $('#ac_no1').val(rec_acc_no);
        $('#branch1').val(rec_branch);
        $('#dd_no1').val(rec_dd);
        $('#discount_per1').val(rec_disc_per);
        $('#discount1').val(rec_disc);
        $('#paid1').val(rec_bill);
        $('#d_date').val(rec_d_date);
        $('#cr_date').val(rec_c_date);
        $('#remrks').val(rec_remarks);
        $('#invc_id').val(recp_id);

        if (rec_terms == 2 || rec_terms == 3) {
            $('.show_div').show();
        } else {
            $('.show_div').hide();
        }

        $('#form_id').attr('action', BASE_URL + "sales_receipt/update_receipt_payment/" + id);
        $("#myModaledit").modal('show');

    }
//    $(document).on('click', '#edit_model', function () {
//        $("#myModaledit").modal('show');
//    });
    $('#terms_change').live('change', function () {
        if ($(this).val() == 2 || $(this).val() == 3)
            $('.show_div').show();
        else
            $('.show_div').hide();
    });
    $("#paid1").live('blur', function ()
    {
        var paid = $('#paid1').val();
        if (paid == "")
        {
            $("#receiptuperror33").html("Required Field");

        } else
        {
            $("#receiptuperror33").html("");
        }
    });
    $("#ac_no1").live('blur', function ()
    {
        var ac_no = $("#ac_no1").val();
        if (ac_no == "" || ac_no == null || ac_no.trim().length == 0)
        {
            $("#receiptuperrorr").html("Required Field");
        } else
        {
            $("#receiptuperrorr").html("");
        }
    });
    $("#branch1").live('blur', function ()
    {
        var branch = $("#branch1").val();
        if (branch == "" || branch == null || branch.trim().length == 0)
        {
            $("#receiptuperror11").html("Required Field");
        } else
        {
            $("#receiptuperror11").html("");
        }
    });
    $("#dd_no1").live('blur', function ()
    {
        var dd_no = $("#dd_no1").val();
        if (dd_no == "" || dd_no == null || dd_no.trim().length == 0)
        {
            $("#receiptuperror22").html("Required Field");
        } else
        {
            $("#receiptuperror22").html("");
        }
    });
</script>