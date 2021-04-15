<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/css/fSelect.css"/>
<script type="text/javascript" src="<?php echo $theme_path; ?>/selects/bootstrap_multiselect.js"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/jquery.table2excel.min.js'></script>
<style>
    .text_right { text-align:right !important;}
    .fs-wrap { width:100%;margin: 5px 0;}
    .fs-label-wrap .fs-label {padding: 9px 22px 8px 8px;}
    .fs-dropdown { width:92%;}
    .btn-group > .btn, .btn-group-vertical > .btn { border-width: 0px!important;}
</style>
<!--<script src="<?php echo $theme_path; ?>/js/angular.min.js"></script>-->
<!--<script type='text/javascript' src='<?php echo $theme_path; ?>/js/fSelect.js'></script>-->
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
        <h4>Outstanding Report - Due Date Wise</h4>
    </div>
    <div class="panel-body">
        <div class="row search_table_hide search-area">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">Firm</label>
                    <select id='firm' class="form-control">
                        <option value="">Select</option>
                        <?php
                        if (isset($firms) && !empty($firms)) {
                            foreach ($firms as $val) {
                                ?>
                                <option value='<?= $val['firm_id'] ?>'><?= $val['firm_name'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">Customer Type</label>
                    <div class="rep-cust-type">
                        <select id='cust_type' class="form-control multi_select" multiple="multiple">
                            <option value="1">T1</option>
                            <option value="2">T2</option>
                            <option value="3">T3</option>
                            <option value="4">T4</option>
                            <option value="5">T5</option>
                            <option value="6">T6</option>
                            <option value="7">H1</option>
                            <option value="8">H2</option>
                            <option value="9">All</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">Customer Region</label>
                    <select id='cust_reg'  class="form-control">
                        <option value="">Select</option>
                        <option value="local">Local Customers</option>
                        <option value="non-local">Non-Local Customers</option>
                        <option value="both">Both</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group mcenter">
                    <label class="control-label col-md-12 mnone">&nbsp;</label>
                    <a id='search' class="btn btn-success  mtop4"><span class="glyphicon glyphicon-search"></span> Search</a>
                    <a class="btn btn-danger1  mtop4" id="clear"><span class="fa fa-close"></span> Clear</a>
                </div>
            </div>
        </div>
    </div>

    <div class="contentpanel mt-10">
        <div  class="panel-body">
            <div class="">
                <table id="basicTable_call_back" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline result_div ob-right days1-right days2-right days3-right days4-right netbalance1-right ">
                    <thead>
                        <tr>
                            <td class="action-btn-align">S.No</td>
                            <td>Customer Name</td>
                            <td class="action-btn-align">Mobile</td>
                            <td class="action-btn-align">OB</td>
                            <td class="action-btn-align">0 to 7 days</td>
                            <td class="action-btn-align">> 7 to 30 days</td>
                            <td class="action-btn-align">> 30 to 90 days</td>
                            <td class="action-btn-align">> 90 days</td>
                            <td class="action-btn-align">Net Balance</td>

                        </tr>
                    </thead>
                    <tbody id="result_data">
                        <?php
                        if (isset($customers) && !empty($customers)) {

                            $s = 1;
                            $days = $sevendays = $inv = $advance = $thirtydays = $nintydays = $receipt = 0;
                            //echo "<pre>";
                            //print_r($customers);
                            //exit;

                            foreach ($customers as $customer) {
                                $a_val = $b_val = $c_val = $d_val = $e_val = 0;
                                $days_net_total = $seven_days_net_total = $thirty_days_net_total = $ninty_days_net_total = $wingsinvoice_net_total = 0;

                                if (!empty($customer['days'])) {
                                    foreach ($customer['days'] as $days_value) {
                                        $days_net_total = $days_net_total + $days_value['new_balance'];
                                    }
                                }

                                if (!empty($customer['sevendays'])) {
                                    foreach ($customer['sevendays'] as $seven_days_value) {
                                        $seven_days_net_total = $seven_days_net_total + $seven_days_value['new_balance'];
                                    }
                                }

                                if (!empty($customer['thirtydays'])) {
                                    foreach ($customer['thirtydays'] as $thirty_days_value) {
                                        $thirty_days_net_total = $thirty_days_net_total + $thirty_days_value['new_balance'];
                                    }
                                }

                                if (!empty($customer['nintydays'])) {
                                    foreach ($customer['nintydays'] as $ninty_days_value) {
                                        $ninty_days_net_total = $ninty_days_net_total + $ninty_days_value['new_balance'];
                                    }
                                }


                                // if ($vak > 0) {
                                ?>
                                <tr>
                                    <td class="action-btn-align"><?php echo $s; ?></td>
                                    <td><?php echo ($customer['store_name']) ? $customer['store_name'] : $customer['name']; ?></td>
                                    <td class="action-btn-align"><?php echo $customer['mobil_number']; ?></td>

                                    <td class="text_right">
                                        <?php
                                        if (!empty($customer['rec'])) {
                                            foreach ($customer['rec'] as $wingsinvoice) {
                                                $wingsinvoice_net_total += $wingsinvoice['new_balance'];
                                            }

                                            echo($wingsinvoice_net_total <= 0 ) ? '' : number_format($wingsinvoice_net_total, 2);
                                        }
                                        ?>
                                        <?php //echo ($customer['rec'][0]['inv_id'] != '' && $customer['rec'][0]['inv_id'] == 'Wings Invoice') ? number_format($customer['rec'][0]['net_total'], 2) : '';   ?>
                                    </td>
                                    <td class="text_right 7days">
                                        <?php
                                        //if ($customer['days'][0]['inv_id'] != '' && $customer['days'][0]['inv_id'] != 'Wings Invoice') {
                                        //$new_val = 0;
                                        //$val = (number_format($customer['days'][0]['net_total'] - ($customer['days'][0]['receipt'] + $customer['days'][0]['advance']), 2));
                                        echo($days_net_total <= 0 ) ? '' : number_format($days_net_total, 2);
                                        // }
                                        ?>
                                    </td>
                                    <td class="text_right 7to30days">
                                        <?php
                                        //if ($customer['sevendays'][0]['inv_id'] != '' && $customer['sevendays'][0]['inv_id'] != 'Wings Invoice') {
                                        // $new_val = 0;
                                        //$val = (number_format($customer['sevendays'][0]['net_total'] - ($customer['sevendays'][0]['receipt'] + $customer['sevendays'][0]['advance']), 2));
                                        echo($seven_days_net_total <= 0 ) ? '' : number_format($seven_days_net_total, 2);
                                        //}
                                        ?>
                                    </td>
                                    <td class="text_right 30to90days">
                                        <?php
                                        //if ($customer['thirtydays'][0]['inv_id'] != '' && $customer['thirtydays'][0]['inv_id'] != 'Wings Invoice') {
                                        // $new_val = 0;
                                        // $val = (number_format($customer['thirtydays'][0]['net_total'] - ($customer['thirtydays'][0]['receipt'] + $customer['thirtydays'][0]['advance']), 2));
                                        echo($thirty_days_net_total <= 0 ) ? '' : number_format($thirty_days_net_total, 2);
                                        //}
                                        ?>
                                    </td>
                                    <td class="text_right 90days">
                                        <?php
                                        // if ($customer['nintydays'][0]['inv_id'] != '' && $customer['nintydays'][0]['inv_id'] != 'Wings Invoice') {
                                        // $new_val = 0;
                                        // $val = (number_format($customer['nintydays'][0]['net_total'] - ($customer['nintydays'][0]['receipt'] + $customer['nintydays'][0]['advance']), 2));
                                        echo($ninty_days_net_total <= 0 ) ? '' : number_format($ninty_days_net_total, 2);
                                        // }
                                        ?>
                                    </td>
                                    <td class="text_right net_balance">
                                        <?php
                                        echo $days_net_total + $seven_days_net_total + $thirty_days_net_total + $ninty_days_net_total + $wingsinvoice_net_total;
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                $s++;
                                // }
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text_right total-bg"></td>
                            <td class="text_right total-bg"></td>
                            <td class="text_right total-bg"></td>
                            <td class="text_right total-bg"></td>
                            <td class="text_right total-bg"></td>
                            <td class="text_right total-bg"></td>
                        </tr>
                    <tfoot>
                </table>
            </div>
            <div class="action-btn-align mt-top15">
                <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                <!--<button class="btn btn-success excel_btn1" id="excel-prt"><span class="glyphicon glyphicon-print"></span> Excel</button>-->
                <div class="btn-group">
                    <button type="button" class=" btn btn-success dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-print"></span> Excel
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#" class="excel_btn1">Current Entries</a></li>
                        <li><a href="#" id="excel-prt">Entire Entries</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="export_excel"></div>
        <script>

            $('.print_btn').click(function () {
                window.print();
            });
            $('#clear').live('click', function ()
            {
                window.location.reload();
            });
        </script>
    </div>
</div>
<script>
    $(function () {
        $('#cust_type')
                .multiselect({
                    allSelectedText: 'All',
                    maxHeight: 200,
                    includeSelectAllOption: true
                })
                .multiselect('selectAll', false)
                .multiselect('updateButtonText');
    });


</script>
<script type="text/javascript">
    /*report();
     function report() {
     var languageApp = angular.module("multiLanguageApp", []);
     languageApp.controller('multiLanguageController', function ($scope, $http) {
     var url = BASE_URL + 'report/outstanding_report_due_date_result';
     var request_data = {firm: $('#firm').val(),
     cust_type: $('#cust_type').val(),
     cust_reg: $('#cust_reg').val()}
     $http.post(url, request_data).then(function (response) {
     console.log(response)
     $scope.customers = response.data;
     });
     });
     }*/
    // $('.multi_select').fSelect();
    $('#search').live('click', function () {
        $.ajax({
            url: BASE_URL + "report/outstanding_report_due_date_search_result",
            type: 'POST',
            data: {
                firm: $('#firm').val(),
                cust_type: $('#cust_type').val(),
                cust_reg: $('#cust_reg').val()
            },
            success: function (result) {
                for_response();
                $('#result_data').html('');
                var table = $('#basicTable_call_back').DataTable();
                table.destroy();
                $('#result_data').html(result);
                datatable();
            }
        });
    });

    $(document).ready(function ()
    {
        var table;
        table = jQuery('#basicTable_call_back').DataTable({
            "lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],
            //"pageLength": 50,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "retrieve": true,
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('report/outstanding_duedate_ajaxList/'); ?>",
                "type": "POST",
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0, 8], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
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
                var cols = [3, 4, 5, 6, 7, 8];
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
        new $.fn.dataTable.FixedHeader(table);

    });

</script>
<script>
    $('.excel_btn1').live('click', function () {
        fnExcelReport1();
    });
</script>
<script>

    function datatable() {
        var table;
        table = jQuery('#basicTable_call_back').DataTable({
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
                var cols = [3, 4, 5, 6, 7, 8];
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
        new $.fn.dataTable.FixedHeader(table);
    }
    function fnExcelReport1()
    {
        /*   var tab_text = "<table border='5px'><tr width='100px' bgcolor='#87AFC6'>";
         var textRange;
         var j = 0;
         tab = document.getElementById('basicTable_call_back'); // id of table
         for (j = 0; j < tab.rows.length; j++)
         {
         tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
         //tab_text=tab_text+"</tr>";
         }
         tab_text = tab_text + "</table>";
         tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
         tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
         tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params
         var ua = window.navigator.userAgent;
         var msie = ua.indexOf("MSIE ");
         if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
         {
         txtArea1.document.open("txt/html", "replace");
         txtArea1.document.write(tab_text);
         txtArea1.document.close();
         txtArea1.focus();
         sa = txtArea1.document.execCommand("SaveAs", true, "Say Thanks to Sumit.xls");
         } else                 //other browser not tested on IE 11
         sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
         return (sa); */
        var tab_text = "<table id='custom_export' border='5px'><tr width='100px' bgcolor='#87AFC6'>";
        var textRange;
        var j = 0;
        tab = document.getElementById('basicTable_call_back'); // id of table
        for (j = 0; j < tab.rows.length; j++)
        {
            tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
            //tab_text=tab_text+"</tr>";
        }
        tab_text = tab_text + "</table>";
        tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
        tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
        tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params
        $('#export_excel').show();
        $('#export_excel').html('').html(tab_text);
        $('#export_excel').hide();
        $("#custom_export").table2excel({
            exclude: ".noExl",
            name: "Outstanding Report - Due Date Wise",
            filename: "Outstanding Report - Due Date Wise",
            fileext: ".xls",
            exclude_img: false,
            exclude_links: false,
            exclude_inputs: false
        });
    }
    $('#excel-prt').on('click', function ()
    {

        var arr = [];
        arr.push({'firm': $('#firm').val()});
        arr.push({'cust_type': $('#cust_type').val()});
        arr.push({'cust_reg': $('#cust_reg').val()});
        var arrStr = JSON.stringify(arr);
        window.location.replace('<?php echo $this->config->item('base_url') . 'report/outstanding_due_date_excel_report?search=' ?>' + arrStr);
    });
</script>
<script src="<?= $theme_path; ?>/js/fixedheader/jquery.dataTables.min.js"></script>