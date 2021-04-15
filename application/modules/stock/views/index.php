<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
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
    /* .btn-success { color:#a1a3a5;background-color:#ffffff;border-color: #ff4081;}
     .btn-primary { color:#a1a3a5;background-color:#ffffff;border-color: #ff4081; }
     .btn-primary:hover { color:#ffffff;background-color:#ff4081;border-color: #ff4081; }*/
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
        <h4>SKU List
            <a href="<?php if ($this->user_auth->is_action_allowed('stock', 'manage_sku', 'add')): ?><?php echo $this->config->item('base_url') . 'stock/sku_management/add_sku' ?><?php endif ?>" class="btn btn-success right topgen <?php if (!$this->user_auth->is_action_allowed('stock', 'manage_sku', 'add')): ?>alerts<?php endif ?>" style="background-color:#ff5a92; color:#ffffff"><span class="glyphicon glyphicon-plus"></span> Add New</a>
        </h4>
    </div>
    <div class="contentpanel">
        <div id='result_div' class="panel-body">
            <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                <thead>
                    <tr>
                        <td class="action-btn-align">S.No</td>
                        <td class='action-btn-align'>Firm</td>
                        <td class='action-btn-align'>SKU No</td>
                        <td class='action-btn-align'>SKU DATE</td>
                        <td class='hide_class action-btn-align'>Action</td>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($sku_mgmt) && !empty($sku_mgmt)) {
                        $i = 1;
                        foreach ($sku_mgmt as $val) {
                            ?>
                            <tr>
                                <td class='first_td action-btn-align'><?= $i ?></td>
                                <td class='action-btn-align'><?= $val['firm_name'] ?></td>
                                <td><?= $val['sku_no'] ?></td>
                                <td class="text_right" style="text-align:center"><?= $val['sku_date']; ?></td>
                                <td width="80" class='hide_class  action-btn-align'>
                                    <?php
                                    $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
                                    if (($user_info[0]['role'] != 3)) {
                                        ?>
                                        <a href="<?php if ($this->user_auth->is_action_allowed('stock', 'manage_sku', 'edit')): ?><?php echo $this->config->item('base_url') . 'stock/sku_management/edit_sku/' . $val['id'] ?><?php endif ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('stock', 'manage_sku', 'edit')): ?>alerts<?php endif ?>" title="" data-original-title="Edit"><span class="fa fa-edit "></span></a>
                                        <a href="<?php if ($this->user_auth->is_action_allowed('stock', 'manage_sku', 'delete')): ?><?php echo $this->config->item('base_url') . 'stock/sku_management/delete_sku/' . $val['id'] ?><?php endif ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('stock', 'manage_sku', 'delete')): ?>alerts<?php endif ?>" title="" data-original-title="Delete"><span class="fa fa-trash "></span></a>

                                    <?php } ?>

                                </td>

                                <?php
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
    /* $(document).on('click', '.alerts', function () {
     sweetAlert("Oops...", "This Access is blocked!", "error");
     return false;
     });*/
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
