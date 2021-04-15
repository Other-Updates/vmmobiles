<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?php echo $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<link href="<?php echo $theme_path; ?>/plugin/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
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
    .ui-datepicker td.ui-datepicker-today a {
        background:#999999;
    }

</style>
<div class="mainpanel">

    <div class="media mt--20">
        <h4>Shrinkage Control
        </h4>
    </div>
    <!-- <div class="panel-body mt--40">
            <div class="row search_table_hide mb-0">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">From Date</label>
                        <div class="col-sm-8">
                            <input type="text" id='from_date' readonly=""  class="form-control datepicker margin0" name="inv_date" placeholder="dd-mm-yyyy" >
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">To Date</label>
                        <div class="col-sm-8">
                            <input type="text"  id='to_date' readonly="" class="form-control datepicker margin0" name="inv_date" placeholder="dd-mm-yyyy" >
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mcenter">
                <!--<button type="button" class="btn btn-warning chart_view" style="float:right; margin-right: 15px;"><i class="icon-plus-circle2 position-left"></i> Analytical Chart view</button>
                    <button type="button" class="btn btn-success search pull-right"><i class="icon-plus-circle2 position-left"></i> Table View</button>
                </div>
            </div>
        </div>  -->
    <br />
    <div class="contentpanel mb-50">
        <div id='result_div' class="panel-body stock_table">
            <table id="basicTable" class="display dataTable table table-striped table-bordered responsive dtr-inline no-footer date-cntr doc-cntr val-cntr rate-right" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <td width='5%' class="action-btn-align">S.No</td>
                        <td width='10%'class="action-btn-align">Entry Date</td>
                        <td width='5%'class="action-btn-align">Entry Document</td>
                        <td width='10%'class="action-btn-align">Shrinkage value</td>
                        <td width='10%'class="action-btn-align">Shrinkage Rate</td>
                        <td width='10%' class="action-btn-align">Action</td>

                    </tr>
                </thead>
                <tbody id='result_div'>
                    <?php
                    if (isset($shrinkage) && !empty($shrinkage)) {
                        $i = 1;
                        foreach ($shrinkage as $val) {
                            if (isset($val['stock']) && !empty($val['stock'])) {
                                $sys = '';
                                $phy = '';
                                $loss_cost = '';
                                $actual_cost = '';
                                $shrinkage_value = '';
                                $total_cost = '';
                                foreach ($val['stock'] as $val1) {
                                    $sys += $val1['system_quantity'];
                                    $phy += $val1['physical_quantity'];
                                    $shrinkage_qty = $val1['system_quantity'] - $val1['physical_quantity'];
                                    $shrinkage_value += $val1['system_quantity'] - $val1['physical_quantity']; //2104
                                    $total_cost += $shrinkage_qty * $val1['cost_price'];
                                    $actual_cost += $val1['system_quantity'] * $val1['cost_price'];
//				    $shrinkage_value += $val1['system_quantity'] - $val1['physical_quantity'];
//				    $total_cost += $shrinkage_value * $val1['cost_price'];
                                }
                            }
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['entry_date']; ?></td>
                                <td>
                                    <?php
                                    if (!empty($val['document_name'])) {
                                        $file = FCPATH . "attachement/physical_stock/monthly_shrinkage/" . $val['document_name'];
                                        //echo $file;
                                        $exists = file_exists($file);
                                        $cust_image = (!empty($exists) && isset($exists)) ? $val['document_name'] : "-";
                                    }
                                    ?>
                                    <?php if ($cust_image) { ?>
                                        <a class="btn btn-info" href="<?php echo $this->config->item('base_url') . '/attachement/physical_stock/monthly_shrinkage/' . $cust_image ?>"><i class="fa fa-download"></i> <?php //echo $val['document_name'];                                   ?> </a>
                                    <?php } ?>


                                </td>
                                <td>
                                    <?php
                                    echo number_format($shrinkage_value);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo number_format($total_cost);
                                    ?>
                                </td>
                                <td>
                                    <a href="<?php echo $this->config->item('base_url') . 'stock/physical_report/view/' . $val['id'] ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs" title="" data-original-title="View"><span class="fa fa-eye"></span></a>
                                </td>
                            </tr>

                            <?php
                            $i++;
                        }
                    }
                    ?>
                </tbody>

            </table>

            <div class="action-btn-align">
                <button type="button" class="btn btn-primary add_bluk_import" style="float:right; margin-right: 15px;"><i class="icon-plus-circle2 position-left"></i> Import Physical Report</button>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h6 class="modal-title">Import Physical Report</h6>
            </div>
            <form action="<?php echo $this->config->item('base_url'); ?>stock/physical_report/import_physical_stock" enctype="multipart/form-data" name="import_products" method="post" id="import_products">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Attachment:</strong></label>
                                    <input type="file" name="product_data" id="physical_data" class="form-control">
                                    <span class="error_msg" style="color:red"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Entry Date</strong></label>
                                    <input type="text" name="entry_date" id="entry_date" class="form-control datepicker">
                                    <span class="error_msg" style="color:red"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" id="import" class="btn btn-success">Submit</button>
                    <button type="button" name="cancel" id="cancel" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo $theme_path; ?>/js/loader.js"></script>
<script type="text/javascript">

    var table;
//    jQuery(document).ready(function () {
//
//	//datatables
//	table = jQuery('#example').DataTable({
//	    "processing": true, //Feature control the processing indicator.
//	    "serverSide": true, //Feature control DataTables' server-side processing mode.
//	    "order": [], //Initial no order.
//	    //dom: 'Bfrtip',
//	    // Load data for the table's content from an Ajax source
//	    "ajax": {
//		"url": "<?php echo site_url('stock/ajaxList/'); ?>",
//		"type": "POST",
//	    },
//	    //Set column definition initialisation properties.
//	    "columnDefs": [
//		{
//		    "targets": [0, 4], //first column / numbering column
//		    "orderable": false, //set not orderable
//		},
//	    ],
//	});
//
//    });


</script>
<script>
    $('.add_bluk_import').click(function () {

        $('#myModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#myModal').modal('show');
        jQuery('.datepicker').datepicker();
    });
    $('#import').click(function () {
        var ext = $('#physical_data').val().split('.').pop().toLowerCase();
        if ($('#physical_data').val() == '') {
            $('#physical_data').closest('div').find('.error_msg').text('Select File');
            return false;
        } else if ($.inArray(ext, ['csv']) == -1) {
            $('#physical_data').closest('div').find('.error_msg').text('Select .csv file only');
            return false;
        } else if ($('#entry_date').val() == '') {
            $('#entry_date').closest('div').find('.error_msg').text('Select Date');
            $('#physical_data').closest('div').find('.error_msg').text();
            return false;
        } else {
            $('#physical_data').closest('div').find('.error_msg').text();
            $('#entry_date').closest('div').find('.error_msg').text();
            $('#import_products').submit();
        }

    });
    var date = new Date();
    var firstDay = new Date(date.getFullYear(), date.getMonth() + 1, 1);
    var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
    //date.setMonth(date.getMonth(), 1);
    /* $(document).ready(function () {
     jQuery('#from_date').datepicker().datepicker("setDate", "" + firstDay.getDate() + "-" + firstDay.getMonth() + "-" + firstDay.getFullYear()).on('changeDate', function (selected) {
     var minDate = new Date(selected.date.valueOf());
     $('#to_date').datepicker('setStartDate', minDate);
     });

     });

     $(document).ready(function () {
     jQuery('#to_date').datepicker().datepicker("setDate", "" + lastDay.getDate() + "-" + (lastDay.getMonth() + 1) + "-" + lastDay.getFullYear());

     });*/
    $(document).ready(function () {
        var startDate;
        $("#from_date").datepicker({
            roundTime: 'ceil',
            onSelect: function (dateStr) {
                startDate = $("#from_date").val();
                $("#to_date").datepicker("option", {minDate: dateStr})
            }
        });
        $("#to_date").datepicker();
    });
    $(document).ready(function () {
        jQuery('#entry_date').datepicker();

    });
    $('.search').click(function () {
        var start = $('#from_date').val();
        var end = $('#to_date').val();
        $.ajax({
            url: "<?php echo $this->config->item('base_url'); ?>" + "stock/physical_report/search_result",
            type: 'POST',
            data: {
                from_date: start,
                to_date: end
            },
            success: function (result) {
                $('.stock_table').html(result);
            }
        });
    });
    $('.chart_view').click(function () {
        var start = $('#from_date').val();
        var end = $('#to_date').val();
        //window.location.href = "<?php echo $this->config->item('base_url'); ?>" + 'stock/physical_report/view/' + start + '/' + end;
        $.ajax({
            url: "<?php echo $this->config->item('base_url'); ?>" + "stock/physical_report/view",
            type: 'POST',
            data: {
                from_date: start,
                to_date: end
            },
            success: function (result) {
                $('.stock_table').html(result);
            }
        });
    });
</script>