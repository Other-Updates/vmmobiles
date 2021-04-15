<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<style>
    .ui-datepicker td.ui-datepicker-today a {
        background:#999999;
    }
    .error_msgs,.error_msg, em{color: rgb(255, 0, 0); font-size: 12px;font-weight: normal;}
    .mb-ss{
        margin-top: -40px;
        text-align: center;
    }
</style>

<div class="mainpanel">
    <div class="media">
        <h4>Update Cash Out Flow</h4>
    </div>
    <div class="contentpanel panel-body mb-50">
        <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
            <thead>
            <th colspan="9">Payment History</th>

            </thead>
            <thead>
            <th width="1%">S&nbsp;No</th>
            <th>Created Date</th>
            <th>Cash In</th>
            <th>Remarks</th>
            </thead>
            <tbody id='payment_info'>
                <?php
                if (isset($payment[0]['payment_history']) && !empty($payment[0]['payment_history'])) {
                    $i = 1;
                    $dis = 0;
                    $paid = 0;
                    foreach ($payment[0]['payment_history'] as $val) {
                        $paid = $paid + $val['amount_in'];
                        ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo date('d-M-Y', strtotime($val['created_date'])) ?></td>
                            <td><?php echo $val['amount_in'] ?></td>
                            <td><?php echo $val['remarks'] ?></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                    <?php
                } else
                    echo "<tr>
                        <td colspan='4'>No Data Found</td>
                    </tr>";
                ?>
            </tbody>
        </table>
        <form action=""  method="post">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <div class="form-group">
                        <div class="col-sm-2"></div>
                        <label class="col-sm-4 col-mx-2 control-label">Cash Out <span class="badge bg-green wnone"><?php echo $payment[0]['cash_out'] ?></span></label>
                        <div class="col-sm-6 col-mx-2">
                            <span class="badge bg-green mnone"><?php echo $payment[0]['cash_out'] ?></span>
                            <!--<span class="btn btn-sm blue"></span>-->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2"></div>
                        <label class="col-sm-4 control-label first_td1">Cash In <span class="badge bg-green wnone"><?php echo $payment[0]['cash_in'] ?></span></label>
                        <div class="col-sm-6">
                            <span class="badge bg-green mnone"><?php echo $payment[0]['cash_in'] ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2"></div>
                        <label class="col-sm-4 control-label first_td1">Balance <span class="badge bg-green  wnone"><?php echo number_format(($payment[0]['cash_out'] - $payment[0]['cash_in']), 2); ?></span></label>
                        <div class="col-sm-6">
                            <span class="badge bg-green bal mnone"><?php echo number_format(($payment[0]['cash_out'] - $payment[0]['cash_in']), 2); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2"></div>
                        <label class="col-sm-4 control-label first_td">Pay Amount <span style="color:#F00; font-style:oblique;">*</span></label>
                        <div class="col-sm-6" id='customer_td'>
                            <input type="text" tabindex="1" onkeypress="return isNumber(event, this)"  name="amount_in" id="amount_in" class="form-control required  form-align"/>
                            <span class="error_msg"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2"></div>
                        <label class="col-sm-4 control-label first_td1">Remarks</label>
                        <div class="col-sm-6">
                            <textarea tabindex="1" name="remarks" id="remarks" class="form-control form-align" style="resize:none;"></textarea>
                            <span class="error_msgs"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
                <div class="clearfix"></div>
            </div>
            <div class="frameset_table action-btn-align">
                <table>
                    <td width="570">&nbsp;</td>
                    <td><input type="submit" name="submit" class="btn btn-success" value="Quick Pay" id="save" /></td>
                    <td>&nbsp;</td>
<!--                    <td><a href="<?php echo $this->config->item('base_url') . 'cash_out_flow/force_payment/' . $payment[0]['id']; ?>" class="btn btn-warning"><span class="glyphicon"></span> Force Pay </a></td>
                    <td>&nbsp;</td>-->
                    <td><a href="<?php echo $this->config->item('base_url') . 'cash_out_flow/cash_out_flow_list' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a></td>
                </table>
            </div>
        </form>
    </div><!-- contentpanel -->
    <div class="panel-body mb-ss">
        <a id="force" data-toggle="modal" class="btn btn-warning action-btn-align"><span class="glyphicon "></span> Force Pay </a>
    </div>
</div><!-- mainpanel -->

<div id="test" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
    <div class="modal-dialog">
        <div class="modal-content modalcontent-top">
            <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                <h3 id="myModalLabel" class="inactivepop">Fource Pay</h3>
            </div>
            <div class="modal-body">
                Are you sure you want to force to pay?<p id="pro_name" style="font-weight: bold;"></p>
                <input type="hidden" id="pro_id" value="<?php echo $payment[0]['id']; ?>" class="id" />
            </div>
            <div class="modal-footer action-btn-align">
                <button class="btn btn-primary delete_yes" id="yesin">Yes</button>
                <button type="button" class="btn btn-danger1 delete_all"  data-dismiss="modal" id="no">No</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $('#amount_in').focus();
        jQuery('.datepicker').datepicker();
    });

    $(document).ready(function ()
    {
        $("#force").on("click", function ()
        {
            var i = 0;
            var remarks = $('#remarks').val();

            if (remarks == "")
            {
                $(".error_msgs").html("This field is required ");
                $(".error_msg").html("");
                i = 1;

            }

            if (i == 1)
            {
                return false;
            } else
            {
                $(".error_msgs").html("");
                $('#test').modal('show');
            }

        });

        $(".delete_yes").on("click", function ()
        {
            var rem = $('#remarks').val();

            var hidin = $(this).parent().parent().find('.id').val();

            $.ajax({
                url: BASE_URL + "cash_out_flow/force_payment/" + hidin,
                type: 'POST',
                data: {remarks: rem},
                success: function (result) {

                    window.location.reload(BASE_URL + "cash_out_flow/cash_out_flow_list");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");


    });
</script>
<script type="text/javascript">

    $('#save').on('click', function ()
    {
        var i = 0;
        var paid = Number($('#amount_in').val());
        var bal = $('.bal').text().replace(/,/g, '');

        if (paid == "")
        {
            $(".error_msg").html("This field is required ");
            $(".error_msgs").html("");
            i = 1;

        } else if (Number(paid) > Number(bal))
        {
            $(".error_msg").html("This field less then the balance amount");
            $(".error_msgs").html("");
            i = 1;
        } else
        {
            $(".error_msg").html("");
        }

        if (i == 1)
        {
            return false;
        } else
        {
            return true;
        }
    });

    function isNumber(evt, this_ele) {
        this_val = $(this_ele).val();
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (evt.which == 13) {//Enter key pressed
            $(".thVal").blur();
            return false;
        }
        if (charCode > 39 && charCode > 37 && charCode > 31 && ((charCode != 46 && charCode < 48) || charCode > 57 || (charCode == 46 && this_val.indexOf('.') != -1))) {
            return false;
        } else {
            return true;
        }

    }
</script>