<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<style>
    .btn-xs
    {
        padding: 1px 1px 1px 4px;
    }
    .btn-xs1
    {
        padding: 3px 0px 0px 3px;
    }
    .btn-xsquo
    {
        padding: 1px 0px 0px 3px;
    }
    .bg-red {
        background-color: #ff5d48 !important;
    }
    .bg-green {
        background-color:#09a20e !important;
    }
</style>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<div class="mainpanel">

    <div class="media mt--20">
        <h4 class="ml-5">Enquiry Details
            <a href="<?php echo $this->config->item('base_url') . 'enquiry/' ?>" class="btn btn-success right topgen" style="background-color:#ff5a92; color:#ffffff"><span class="glyphicon glyphicon-plus"></span> Add Enquiry</a>
        </h4>
    </div>

    <div class="contentpanel">

        <div id='result_div' class="panel-body mt-top5 pb0 mb-70">
            <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline ">
                <thead>
                    <tr>
                        <td class="action-btn-align">S.No</td>
                        <td>Enquiry Number</td>
                        <td>Customer Name</td>
                        <!--<td>Customer Address</td>-->
                        <td class='action-btn-align'>Enquiry Date</td>
                        <td class='action-btn-align'>Enquiry Followup Date</td>
                        <td>Customer Email</td>
                        <td>Enquiry About</td>
                        <td class='action-btn-align'>Status</td>
                        <!--<td>Remarks</td>-->
                        <?php
                        $user_info = $this->user_info = $this->session->userdata('user_info');
                        if (($user_info[0]['role'] != 5)) {
                            ?>
                            <td class="hide_class action-btn-align" width="83">Action</td>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $total_qty = 0;
                    if (isset($all_enquiry) && !empty($all_enquiry)) {
                        $i = 1;
                        foreach ($all_enquiry as $val) {
                            $total_qty = $total_qty + $val['total_qty'];
                            ?>
                            <tr>
                                <td class='first_td action-btn-align'><?= $i ?></td>
                                <td class='action-btn-align'><?= $val['enquiry_no'] ?></td>
                                <td><?= $val['customer_name'] ?></td>
                                <!--<td><?= $val['customer_address'] ?></td>-->
                                <td class='action-btn-align'><?= date('d-M-Y', strtotime($val['created_date'])); ?></td>
                                <td class='action-btn-align'><?= ($val['followup_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['followup_date'])) : ''; ?></td>
                                <td><?= $val['customer_email'] ?></td>
                                <td><?= $val['enquiry_about'] ?></td>
                                <td class='action-btn-align'>
                                    <?php
                                    if ($val['status'] == 'Pending') {
                                        ?>
                                        <span class=" badge bg-red"> <?php echo 'Pending'; ?></span>

                                        <?php
                                    }
                                    if ($val['status'] == 'Completed') {
                                        ?>
                                        <span class=" badge bg-green"> <?php echo 'Completed'; ?></span>
                                    <?php } ?>
                                </td>
                                <!--<td><?= $val['remarks'] ?></td>-->
                                <?php
                                $user_info = $this->user_info = $this->session->userdata('user_info');
                                if (($user_info[0]['role'] != 5)) {
                                    ?>
                                    <td class="hide_class action-btn-align">
                                        <a href="<?php echo $this->config->item('base_url') . 'enquiry/enquiry_edit/' . $val['id'] ?>" data-toggle="tooltip" class="tooltips btn btn-info btn-xs" title="" data-original-title="Edit"><span  class="fa fa-edit"></span>&nbsp;</a>
                                        <a href="#test3_<?php echo $val['id']; ?>" data-toggle="modal" name="delete" class="tooltips btn btn-danger btn-xs" title="In-Active"><span class="fa fa-ban"></span>&nbsp;</a>
                                        <a href="<?php echo $this->config->item('base_url') . 'enquiry/enquiry_view/' . $val['id'] ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xsquo" title="" data-original-title="View"><span  class="fa fa-eye"></span>&nbsp;</a>
                                    </td>
                                <?php } ?>
                            </tr>
                            <?php
                            $i++;
                        }
                    }
                    ?>


                </tbody>
            </table>
            <div class="action-btn-align mb-10">
                <button class="btn btn-defaultprint6 print_btn "><span class="glyphicon glyphicon-print"></span> Print</button>
            </div>
        </div>
        <?php
        if (isset($all_enquiry) && !empty($all_enquiry)) {
            foreach ($all_enquiry as $val) {
                ?>
                <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                    <div class="modal-dialog">
                        <div class="modal-content modalcontent-top">
                            <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                                <h3 id="myModalLabel" class="inactivepop">In-Active user</h3>
                            </div>
                            <div class="modal-body">
                                Do You Want In-Active This user?<strong><?= $val['enquiry_no']; ?></strong>
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
    $(document).ready(function () {
        jQuery('.datepicker').datepicker();
    });
    $().ready(function () {
        $("#ps_no").autocomplete(BASE_URL + "enquiry/get_ps_no_list", {
            width: 260,
            autoFocus: true,
            matchContains: true,
            selectFirst: false
        });
    });
    $('#search').live('click', function () {
        for_loading();
        $.ajax({
            url: BASE_URL + "enquiry/search_result",
            type: 'GET',
            data: {
                ps_no: $('#ps_no').val(),
                customer: $('#customer').val(),
                customer_name: $('#customer').find('option:selected').text(),
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
            //alert(hidin);
            $.ajax({
                url: BASE_URL + "enquiry/enquiry_delete",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "enquiry/enquiry_list");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
</script>
