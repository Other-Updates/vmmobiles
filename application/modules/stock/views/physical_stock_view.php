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
</style>
<?php
if (isset($stock) && !empty($stock)) {
    $sys = '';
    $phy = '';
    $loss_cost = '';
    $actual_cost = '';
    foreach ($stock as $val) {

        $sys += $val['system_quantity'];
        $phy += $val['physical_quantity'];
        $shrinkage = $val['system_quantity'] - $val['physical_quantity'];
        $loss_cost += $shrinkage * $val['cost_price'];
        $actual_cost += $val['system_quantity'] * $val['cost_price'];
    }
//    echo $loss_cost . '<br>' . $actual_cost . '<br>';
//    echo $sys . '<br>';
//    echo $phy;
    $total = $sys - $phy;
    $total_cost = $actual_cost - $loss_cost;
//exit;
}
?>
<div class="mainpanel">

    <div class="media mt--40">
        <h4 class="ml-25 mediamartop">Shrinkage Report
        </h4>
    </div>
    <div class="panel-body mt--40">
        <div class="col-sm-6">
            <h4>Shrinkage Value</h4>
            <div id="piechart" class="chart_des" style="width: 100%; height: 500px;"></div>
            <h4><b>System Stock Total Value:&nbsp;</b><?php echo number_format($sys); ?></h4>
        </div>
        <div class="col-sm-6">
            <h4>Shrinkage Rate</h4>
            <div id="piechart1" class="chart_des" style="width: 100%; height: 500px;"></div>
            <h4><b>System Stock Total Rate:&nbsp;</b><?php echo number_format($actual_cost); ?></h4>
        </div>
        <div class="col-sm-12">
            <div class="media mt--20">
                <h4>Shrinkage Report table
                    <a href="<?php echo $this->config->item('base_url') . 'stock/physical_report/cleart_quantity/' . $stock[0]['shrinkage_id']; ?>" id='clear_qty' class="btn btn-success right"><span class="glyphicon glyphicon-refresh"></span> Clear Quantity</a>
                </h4>
            </div>
            <div id="">
                <table id="basicTable_call_back" class="display dataTable table table-striped table-bordered responsive dtr-inline no-footer " cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <td width='5%' class="">S.No</td>
                            <td width='20%'>Firm Name</td>
                            <td width='15%'>Category</td>
                            <td width='15%'>Product Name</td>
                            <td width='5%'>Brand</td>
                            <td width='10%'>System Quantity</td>
                            <td width='10%'>Physical Quantity</td>
                            <td width='10%'>Shrinkage value</td>
                            <td width='10%'>Shrinkage Rate</td>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="total-bg" style="text-align:center;"></td>
                            <td class="total-bg" style="text-align:center;"></td>
                        </tr>
                    </tfoot>
                    <tbody id='result_div'>
                        <?php
                        if (isset($stock) && !empty($stock)) {
                            $i = 1;
                            foreach ($stock as $val) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?><input type="hidden" class="phy_id" value="<?php echo $val['id']; ?>"/>
                                        <input type="hidden" class="shrinkage_id" value="<?php echo $val['shrinkage_id']; ?>"/>
                                    </td>
                                    <td><?php echo $val['firm_name']; ?></td>
                                    <td><?php echo $val['categoryName']; ?></td>
                                    <td><?php echo $val['product_name']; ?></td>
                                    <td><?php echo $val['brands']; ?></td>
                                    <td class="action-btn-align"><?php echo $val['system_quantity']; ?></td>
                                    <td class="action-btn-align phy_qty"><?php echo $val['physical_quantity']; ?></td>
                                    <td class="shrinkage" style="text-align:center">
                                        <?php
                                        $shrinkage = $val['system_quantity'] - $val['physical_quantity'];
                                        echo $shrinkage;
                                        ?>
                                    </td>
                                    <td class="cost" style="text-align:center">
                                        <?php
                                        $total_cost1 = $shrinkage * $val['cost_price'];
                                        echo $total_cost1;
                                        ?>
                                    </td>
                                </tr>

                                <?php
                                $i++;
                            }
                        } else {
                            ?>
                            <tr><td colspan="9" style="text-align:center;">NO DATA FOUND</td></tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>

    </div>
    <div class="contentpanel mb-50">

    </div>
</div>
<script type="text/javascript" src="<?php echo $theme_path; ?>/js/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Physical Stock', <?php echo $phy; ?>],
            ['Shrinkage', <?php echo $total; ?>]
        ]);

        var options = {
            title: 'Shrinkage Value'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Shrinkage', <?php echo $loss_cost; ?>],
            ['Physical Stock', <?php echo $total_cost; ?>]
        ]);

        var options = {
            title: 'Shrinkage Rate'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart1'));

        chart.draw(data, options);
    }

</script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Report', 'Shrinkage Value', 'Shrinkage Rate'],
            ['Shrinkage', <?php echo $total; ?>, <?php echo $loss_cost; ?>]
        ]);

        var options = {
            width: 500,
            chart: {
                title: 'Shrinkage'
            }

        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>

<script>
//    var sum = 0;
//    var total = 0;
//// iterate through each td based on class and add the values
//    $(".shrinkage").each(function () {
//
//	var value = $(this).text();
//
//	// add only if the value is number
//	if (!isNaN(value) && value.length != 0) {
//
//	    sum += parseFloat(value);
//	}
//    });
//    $(".cost").each(function () {
//
//	var value = $(this).text();
//
//	// add only if the value is number
//	if (!isNaN(value) && value.length != 0) {
//
//	    total += parseFloat(value);
//	}
//    });
//    $('.total_shrinkage').text(sum).css('font-weight', 'bold');
//    $('.total_cost').text(total).css('font-weight', 'bold');
    $(document).ready(function ()
    {
        $('#basicTable_call_back').dataTable({
            "lengthMenu": [[200, 500, 1000, -1], [200, 500, 1000, "All"]],
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
                var cols = [7, 8];
                for (x in cols) {
                    total = api.column(cols[x]).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    // Total over this page
                    pageTotal = api.column(cols[x], {page: 'current'}).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    // Update footer
                    $(api.column(cols[x]).footer()).html(pageTotal);
                }


            },
            responsive: true,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -2}
            ]
        });
    });

    $(document).ready(function () {
        $("#basicTable_call_back").on('dblclick', "tbody td.phy_qty", function (e) {
            e.stopPropagation();
            var currentEle = $(e.target);
            var value = $(e.target).html();
            id = $(this).closest('tr').find('td:first input.phy_id').val();
            shrinkage_id = $(this).closest('tr').find('td:first input.shrinkage_id').val();
            if ($.trim(value) === "") {
                $(currentEle).data('mode', 'add');
            } else {
                $(currentEle).data('mode', 'edit');
            }
            updateVal(currentEle, value, id, shrinkage_id);
        });
    });
    function updateVal(currentEle, value, id, shrinkage_id) {
        $(currentEle).html('<form id="new"><input class="thVal form-control"  name="physical_quantity" type="text" value="' + value.replace(/,/g, '') + '" onkeypress="return isNumber(event, this)" style="width:70px;" /><input type="hidden" name="shrinkage_id" value="' + shrinkage_id + '" /></form>');
        // All others

        var mode = $(currentEle).data('mode');
        $(".thVal").focus();
        $(".thVal").blur(function (event) {
            new_val = $(this).val();
            $.ajax({
                type: 'POST',
                async: false,
                data: $("#new").serialize(),
                url: '<?php echo base_url(); ?>stock/physical_report/edit_physical_quantity/' + id,
                success: function (data) {
                    if (data == 'edit') {
                        $(currentEle).html(new_val);
                    }
                }
            });
        });
    }
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