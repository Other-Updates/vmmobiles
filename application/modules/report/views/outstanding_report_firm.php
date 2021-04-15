<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<link href="<?php echo $theme_path; ?>/plugin/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
<script type='text/javascript' src='<?php echo $theme_path; ?>/js/fSelect.js'></script>
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
        <h4>Outstanding Report - Firm Wise</h4>
    </div>
    <div class="panel-body">
        <div class="row search_table_hide search-area">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">Due</label>
                    <select id='due_date' class="form-control">
                        <option value="">Select</option>
                        <option value="6">OB</option>
                        <option value="1">0 to 7 Days</option>
                        <option value="2">Above 7 Days</option>
                        <option value="3">Above 30 Days</option>
                        <option value="4">Above 90 Days</option>
                        <option value="5">Overall</option>
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
            <div id='result_div1' class="panel-body">
                <div class="">
                    <table id="myTable" class="display last-td-center dataTable table table-striped table-bordered responsive dataTable dtr-inline no-footer
                           electricals-right paints-right tiles-right hardware-right txtne-right table-fixed" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <td class="action-btn-align">S.No</td>
                                <td>Customer Name</td>
                                <td class="action-btn-align">Mobile</td>
                                <td class="action-btn-align">Electricals</td>
                                <td class="action-btn-align">Paints</td>
                                <td class="action-btn-align">Tiles</td>
                                <td class="action-btn-align">Hardware</td>
                                <td class="action-btn-align" >Net Balance</td>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class="text_right total-bg"></td>
                                <td class="text_right total-bg"></td>
                                <td class="text_right total-bg"></td>
                                <td class="text_right total-bg">></td>
                                <td class="text_right total-bg"></td>
                            </tr>
                        <tfoot>

                    </table>
                </div>
            </div>
            <div class="action-btn-align mt-top15">
                <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                <!--<button class="btn btn-success excel_btn" id="excel-prt"><span class="glyphicon glyphicon-print"></span> Excel</button>-->
                <div class="btn-group">
                    <button type="button" class=" btn btn-success dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-print"></span> Excel
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#" class="excel_btn">Current Entries</a></li>
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
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/fSelect.js'></script>
<script type="text/javascript">
            jQuery(document).ready(function () {
                var table;
                table = jQuery('#myTable').DataTable({
                    "lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
                    "pageLength": 50,
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "retrieve": true,
                    "order": [], //Initial no order.
                    //dom: 'Bfrtip',
                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?php echo site_url('report/outstanding_ajaxList/'); ?>",
                        "type": "POST",
                    },
                    //Set column definition initialisation properties.
                    "columnDefs": [
                        {
                            "targets": [0, 7], //first column / numbering column
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
                        var cols = [3, 4, 5, 6, 7];
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
                                pageTotal = pageTotal.toFixed(2); /* float */

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

    $('#search').live('click', function () {
        for_loading();
        $.ajax({
            url: BASE_URL + "report/outstanding_report_firm_wise_search_result",
            type: 'POST',
            data: {
                due_date: $('#due_date').val(),
                cust_type: $('#cust_type').val(),
                cust_reg: $('#cust_reg').val()
            },
            success: function (result) {
                for_response();
                var table = $('#myTable').DataTable();
                table.destroy();
                $('#result_div1').html('').html(result);
                datatable();
            }
        });
    });
</script>
<script>
    function datatable() {
        var table;
        table = jQuery('#myTable').DataTable({
            "lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
            "pageLength": 50,
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
                var cols = [3, 4, 5, 6, 7];
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


</script>
<script>
    $('.excel_btn').live('click', function () {
        fnExcelReport2();
    });</script>
<script>
    function fnExcelReport2()
    {

        var tab_text = "<table id='custom_export' border='5px'><tr width='100px' bgcolor='#87AFC6'>";
        var textRange;
        var j = 0;
        tab = document.getElementById('myTable'); // id of table
        return false;
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
            name: "Outstanding Report - Firm Wise",
            filename: "Outstanding Report - Firm Wise",
            fileext: ".xls",
            exclude_img: false,
            exclude_links: false,
            exclude_inputs: false
        });



    }
    $('#excel-prt').on('click', function ()
    {
        var arr = [];
        arr.push({'due_date': $('#due_date').val()});
        arr.push({'cust_type': $('#cust_type').val()});
        arr.push({'cust_reg': $('#cust_reg').val()});
        var arrStr = JSON.stringify(arr);
        window.location.replace('<?php echo $this->config->item('base_url') . 'report/outstanding_firmwise_excel_report?search=' ?>' + arrStr);
    });
</script>
<script src="<?= $theme_path; ?>/js/fixedheader/jquery.dataTables.min.js"></script>


