<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<div class="print_header">
    <table width="100%">
        <tr>
            <td width="15%" style="vertical-align:middle;">
                <div class="print_header_logo" ><img src="<?= $theme_path; ?>/images/logo.png" /></div>
            </td>
            <td width="85%">

                <div class="print_header_tit" >
                    <h3> <?= $company_details[0]['firm_name'] ?></h3>
                    <p></p>
                    <p class="pf">  <?= $company_details[0]['address'] ?>,
                    </p>
                    <p></p>
                    <p class="pf"> Pin Code : <?= $company_details[0]['pincode'] ?></p>
                    <p></p>
                </div>
            </td>
        </tr>
    </table>
</div>
<div class="mainpanel">
    <div class="media mt--40">
        <h4 class="hide_class">View Cash Out Flow</h4>
    </div>

    <?php
    if (isset($payment[0]['payment_history']) && !empty($payment[0]['payment_history'])) {
        $i = 1;
        $dis = 0;
        $paid = 0;
        foreach ($payment[0]['payment_history'] as $val) {
            $paid = $paid + $val['amount_in'];
        }
    }
    ?>
    <div class="contentpanel panel-body mb-50">
        <form method="post">
            <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                <thead>
                <th class="action-btn-align" colspan="4">Payment Details</th>
                </thead>
                <tr>
                    <td><span  class="tdhead">Receiver Firm:</span></td>
                    <td><?php echo $payment[0]['firm_name'] ?></td>
                    <td class="action-btn-align"> <img src="<?php echo $theme_path; ?>/images/logo.png" alt="Chain Logo" width="125px"></td>
                    <td></td>
                </tr>
                <tr>
                    <td><span  class="tdhead">Receiver Staff Name:</span></td>
                    <td><?php echo ($payment[0]['user_name'] == 'Others') ? $payment[0]['other_name'] : $payment[0]['user_name']; ?></td>
                    <td><span  class="tdhead">Date:</span></td>
                    <td><?php echo date('d-M-Y', strtotime($payment[0]['created_date'])) ?></td>

                </tr>
                <tr>
                    <td><span  class="tdhead">Sender Firm:</span></td>
                    <td><?php echo $payment[0]['sender'][0]['sender_firm_name'] ?></td>
                    <td><span  class="tdhead">Cash Out:</span></td>
                    <td><?php echo number_format($payment[0]['cash_out'], 2, '.', ',') ?></td>
                </tr>
                <tr>
                    <td><span  class="tdhead">Sender Staff Name:</span></td>
                    <td><?php echo ($payment[0]['sender_name'] == 'Others') ? $payment[0]['sender_other_name'] : $payment[0]['sender_name']; ?></td>
                    <td><span  class="tdhead">Cash In:</span></td>
                    <td><?php echo number_format($payment[0]['cash_in'], 2, '.', ',') ?></td>
                </tr>
                <tr>
                    <td><span  class="tdhead">Pay Type:</span></td>
                    <td><?php echo $payment[0]['amount_type'] ?></td>
                    <td><span  class="tdhead">Balance:</span></td>
                    <td><?php echo number_format($payment[0]['cash_out'] - $payment[0]['cash_in'], 2, '.', ','); ?></td>
                </tr>
            </table>
        </form>
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
                            <td><?php echo ($val['remarks']) ? $val['remarks'] : '-' ?></td>
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
        <div class="hide_class action-btn-align">
            <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
            <a href="<?php echo $this->config->item('base_url') ?>cash_out_flow/cash_out_flow_list" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>

        </div>
    </div>
</div>

<script>
    $('.print_btn').click(function () {
        window.print();
    });
    $(document).ready(function () {
        window.print();
    });
</script>