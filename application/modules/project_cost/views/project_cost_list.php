<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<style>
    .btn-xs1 {
        padding: 2px 2px 0px 4px;
        border-radius: 50%;
    }
    .btn-xs {
        padding: 0px 4px 1px 4px;
        border-radius: 50%;
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
    .btn-success { color:#a1a3a5;background-color:#ffffff;border-color: #ff4081;}
    .btn-primary { color:#a1a3a5;background-color:#ffffff;border-color: #ff4081; }
    .btn-primary:hover { color:#ffffff;background-color:#ff4081;border-color: #ff4081; }
</style>
<div class="mainpanel">

    <div class="media mt--20">
        <h4 class="ml-5">Sales List
            <a href="<?php echo $this->config->item('base_url') . 'project_cost/new_quotation' ?>" class="btn btn-success right topgen" style="background-color:#ff5a92; color:#ffffff"><span class="glyphicon glyphicon-plus"></span> Add New</a>
        </h4>
    </div>
    <div class="contentpanel">
        <div id='result_div' class="panel-body mt-top5 pb0 mb-50">
            <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                <thead>
                    <tr>
                        <td class="action-btn-align">S.No</td>
                        <td class='action-btn-align'>Quotation No</td>
                        <td>Company Name</td>
                        <td>Quotation Amount</td>
                        <?php
                        $user_info = $this->user_info = $this->session->userdata('user_info');
                        if ($user_info[0]['role'] != 4) {
                            ?>
                            <td>Invoice NO</td>
                            <td>Invoice Amount</td>
                            <td class="hide_class action-btn-align">Invoice</td>
                        <?php } ?>
                        <td>Sales ID</td>
                        <td>Cost</td>
                        <td class="hide_class action-btn-align">Project Cost</td>

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
                                <td class="text_right"><?= number_format($val['net_total'], 2); ?></td>
                                <?php
                                $user_info = $this->user_info = $this->session->userdata('user_info');
                                if ($user_info[0]['role'] != 4) {
                                    ?>
                                    <?php if (isset($val['pc_amount']) && !empty($val['pc_amount'])) { ?>
                                        <?php if (isset($val['inv_amount']) && !empty($val['inv_amount'])) { ?>
                                            <?php if($val['inv_amount'][0]['contract_customer'] == 0) {?>
                                            <td><?php echo $val['inv_amount'][0]['inv_id']; ?></td>
                                            <td  class="text_right"><?php echo number_format($val['inv_amount'][0]['net_total'], 2)?></td>
                                             <?php }else{
                                             ?>
                                            <td><?php echo $val['inv_amount'][0]['inv_id'].' -- '.$val['inv_amount'][1]['inv_id']; ?></td>
                                            <td  class="text_right"><?php echo number_format($val['inv_amount'][0]['net_total'], 2).' -- '. number_format($val['inv_amount'][1]['net_total'], 2); ?></td>
                                             <?php }?>
                                            <?php if($val['inv_amount'][0]['contract_customer'] == 0) {?>
                                            <td class="hide_class action-btn-align "><a href="<?php echo $this->config->item('base_url') . 'project_cost/invoice_view/' . $val['inv_amount'][0]['id'] ?>" data-toggle="tooltip" class="tooltips btn btn-success btn-xs" title="" ><span class="fa fa-log-out "> <span class="fa fa-eye"></span>  </span></a></td>
                                            <?php }else{
                                             ?>
                                            <td class="hide_class action-btn-align ">                                        
                                                <a href="<?php echo $this->config->item('base_url') . 'project_cost/invoice_view/' . $val['inv_amount'][0]['id'] ?>" data-toggle="tooltip" class="tooltips btn btn-success btn-xs" title="Contractor Invoice" ><span class="fa fa-log-out "> <span class="fa fa-eye"></span>  </span></a><a href="<?php echo $this->config->item('base_url') . 'project_cost/invoice_view/' . $val['inv_amount'][1]['id'] ?>" data-toggle="tooltip" class="tooltips btn btn-success btn-xs" title="Customer Invoice" ><span class="fa fa-log-out "> <span class="fa fa-eye"></span>  </span></a>
                                           
                                            </td>
                                            <?php } ?>

                                        <?php } else { ?>
                                            <td></td>
                                            <td></td>
                                            <td class="hide_class action-btn-align"><a href="<?php echo $this->config->item('base_url') . 'project_cost/invoice_add?id=' . $val['pc_amount'][0]['id'] . '&q_id=' . $val['pc_amount'][0]['q_id'] ?>" data-toggle="tooltip" class="tooltips btn btn-primary btn-xs1" title="" ><span class="fa fa-log-out "> <span class="glyphicon glyphicon-plus"></span>  </span></a></td>

                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <td></td>
                                        <td></td>
                                        <td class="hide_class"></td>
                                    <?php } ?>
                                <?php } ?>
                                <?php if (isset($val['pc_amount']) && !empty($val['pc_amount'])) { ?>
                                    <td><?= $val['job_id'] ?></td>
                                    <td class="text_right"><?php echo number_format($val['pc_amount'][0]['net_total'], 2); ?></td>
                                    <td class="hide_class action-btn-align"><a href="<?php echo $this->config->item('base_url') . 'project_cost/quotation_view/' . $val['pc_amount'][0]['id'] ?>" data-toggle="tooltip" class="tooltips btn btn-success btn-xs" title="" ><span class="fa fa-log-out "> <span class="fa fa-eye"></span> </span></a></td>

                                <?php } else { ?>
                                    <td><?= $val['job_id'] ?></td>  <td class="hide_class"></td>
                                    <td class="hide_class action-btn-align"><a href="<?php echo $this->config->item('base_url') . 'project_cost/quotation_add/' . $val['id'] ?>" data-toggle="tooltip" class="tooltips btn btn-primary btn-xs1" title="" ><span class="fa fa-log-out "> <span class="glyphicon glyphicon-plus"></span></span></a></td>
                                </tr>
                                <?php
                            }
                            $i++;
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div class="action-btn-align mb-10">
                <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
            </div>
        </div>
        <?php
        if (isset($project) && !empty($project)) {
            foreach ($project as $val) {
                ?>

                <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                    <div class="modal-dialog">
                        <div class="modal-content modalcontent-top">
                            <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                                <h3 id="myModalLabel" style="color:white">In-Active user</h3>
                            </div>
                            <div class="modal-body">
                                Do You Want In-Active This Quotation?<strong><?= $val['job_id']; ?></strong>
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
        $("#yesin").live("click", function ()
        {

            var hidin = $(this).parent().parent().find('.id').val();
            // alert(hidin);
            $.ajax({
                url: BASE_URL + "Project_cost_model/quotation_delete",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "Project_cost_model/quotation_list");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
</script>
