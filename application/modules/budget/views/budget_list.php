<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?php echo $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<style>
    .bg-red {background-color: #dd4b39 !important;}
    .bg-green {background-color:#09a20e !important;}
    .bg-yellow{background-color:orange !important;}
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
        <h4>Budget List
            <a href="<?php if ($this->user_auth->is_action_allowed('budget', 'budget', 'add')): ?><?php echo $this->config->item('base_url') . 'budget/' ?><?php endif ?>" class="btn btn-success right topgen <?php if (!$this->user_auth->is_action_allowed('budget', 'budget', 'add')): ?>alerts<?php endif ?>"><span class="glyphicon glyphicon-plus"></span> Add Budget</a>
        </h4>
    </div>
    <div class="contentpanel">
        <div id='result_div' class="panel-body">
            <table id="basicTable_call_back" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                <thead>
                    <tr>
                        <td width='5%'>S.No</td>
                        <td width='15%'>Firm Name</td>
                        <td width='10%'>Voucher No</td>
                        <td width='10%'>Budget Name</td>
                        <td width='10%'>From Date</td>
                        <td width='10%'>To Date</td>
                        <td width='10%' class="action-btn-align">Total Amount</td>
                        <td width='10%' class="hide_class action-btn-align">Action</td>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class=""></td>
                        <td class=""></td>
                        <td class=""></td>
                        <td class="text_right total-bg"></td>
                        <td class="hide_class "></td>


                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    if (isset($po) && !empty($po)) {
                        $i = 1;
                        foreach ($po as $val) {
                            ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $val['firm_name'] ?></td>
                                <td><?php echo $val['vc_no'] ?></td>
                                <td><?php echo $val['budget_name'] ?></td>
                                <td><?php echo ($val['from_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['from_date'])) : ''; ?></td>
                                <td><?php echo ($val['to_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['to_date'])) : ''; ?></td>
                                <td class="text_right"><?php echo number_format($val['net_total'], 2); ?></td>
                                <td class='hide_class  action-btn-align'>
                                    <!-- <a href="<?php //if ($this->user_auth->is_action_allowed('budget', 'budget', 'edit')):   ?><?php //echo $this->config->item('base_url') . 'budget/budget_edit/' . $val['id']   ?><?php //endif   ?>" data-toggle="tooltip" class="tooltips btn btn-info btn-xs <?php //if (!$this->user_auth->is_action_allowed('budget', 'budget', 'edit')):   ?>alerts<?php //endif   ?>" title="" data-original-title="Edit"><span class="fa fa-edit "></span></a> -->
                                    <a href="<?php if ($this->user_auth->is_action_allowed('budget', 'budget', 'delete')): ?>#test3_<?php echo $val['id']; ?><?php endif ?>" data-toggle="modal" name="delete" class="tooltips btn btn-danger btn-xs <?php if (!$this->user_auth->is_action_allowed('budget', 'budget', 'delete')): ?>alerts<?php endif ?>" title="In-Active"><span class="fa fa-ban"></span></a>
                                    <a href="<?php if ($this->user_auth->is_action_allowed('budget', 'budget', 'view')): ?><?php echo $this->config->item('base_url') . 'budget/budget_view/' . $val['id'] ?><?php endif ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('budget', 'budget', 'view')): ?>alerts<?php endif ?>" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>
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
                        Do You Want In-Active This Budget? &nbsp; <strong><?= $val['vc_no']; ?></strong>
                        <input type="hidden" value="<?php echo $val['id']; ?>" class="id" />
                    </div>
                    <div class="modal-footer action-btn-align">
                        <button class="btn btn-primary delete_yes" id="yesin">Yes</button>
                        <button type="button" class="btn btn-danger1 delete_all"  data-dismiss="modal" id="no">No</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>

<script>
    $(document).on('click', '.alerts', function () {
        sweetAlert("Oops...", "This Access is blocked!", "error");
        return false;
    });
    $('.print_btn').click(function () {
        window.print();
    });

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
                var cols = [6];
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
                url: BASE_URL + "budget/budget_delete",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "budget/budget_list");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
</script>
