<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />


	
<style>
    .ui-datepicker td.ui-datepicker-today a {background:#999999;}
	 	
</style>
<div class="mainpanel">
    <div class="media mt--20">
        <h4>Outstanding Report</h4>
    </div>

    <div class="panel-body">
        <div class="row search_table_hide search-area">
            <div class="col-sm-2">
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
            <!--
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Invoice NO</label>
                                <select id='inv_id' class="form-control">
                                    <option value="">Select</option>
            <?php
            if (isset($all_style) && !empty($all_style)) {
                foreach ($all_style as $val) {
                    ?>
                                                                                                                                                                                                                                            <option value='<?= $val['inv_id'] ?>'><?= $val['inv_id'] ?></option>
                    <?php
                }
            }
            ?>
                                </select>
                            </div>
                        </div>-->
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">Customer Name</label>
                    <select id='customer'  class="form-control">
                        <option value="">Select</option>
                        <?php
                        if (isset($all_supplier) && !empty($all_supplier)) {
                            foreach ($all_supplier as $val) {
                                ?>
                                <option value='<?= $val['id'] ?>'><?= $val['store_name'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!--            <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">From Date</label>
                                <input type="text" id='from_date'  class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">To Date</label>
                                <input type="text"  id='to_date' class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >
                            </div>
                        </div>-->
            <div class="col-sm-2">
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
			    
                <table id="myTable " class="display last-td-center dataTable table table-striped table-bordered responsive dataTable 
				dtr-inline no-footer invamount-right pamount-right damunt-right balancepay-right" cellspacing="0" width="100%" >
                    <thead>
                        <tr>
                            <td class="action-btn-align">S.No</td>
                            <!--<td class="action-btn-align">Invoice #</td>-->
                            <td>Customer Name</td>
                            <td>Invoice Amount</td>
                            <td>Paid Amount</td>
                            <td>Discount Amount</td>
                            <td>Balance</td>
                            <td class="action-btn-align">Created Date</td>
                            <td class="action-btn-align">Due Date</td>
                            <td class="hide_class action-btn-align">Payment Status</td>
                            <!--<td class="hide_class action-btn-align">Action</td>-->
                        </tr>
                    </thead>
                    <tbody id="result_data">

                    </tbody>
                    <tfoot class="result_tfoot">
                        <tr>
                            <!--<td></td>-->
                            <td></td>
                            <td></td>
                            <td class="text_right total-bg"></td>
                            <td class="text_right total-bg"></td>
                            <td></td>
                            <td class="text_right total-bg"></td>
                            <td></td>
                            <td></td>
                            <td class="hide_class"></td>

                        </tr>
                    </tfoot>

                </table>
            </div>
            <div class="action-btn-align mt-top15">
                <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                <button class="btn btn-success excel_btn1" id="excel-prt"><span class="glyphicon glyphicon-print"></span> Excel</button>
            </div>

        </div>

        <script>
            $('.print_btn').click(function () {
                window.print();
            });
            $('#clear').live('click', function ()
            {
                window.location.reload();
            });

        </script>
    </div><!-- contentpanel -->

</div><!-- mainpanel -->

<script type="text/javascript">
    $(document).ready(function () {
        $('#customer').select2();

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
            url: BASE_URL + "report/payment_receipt_search_result",
            type: 'GET',
            data: {
                firm: $('#firm').val(),
                //inv_id: $('#inv_id').val(),
                customer: $('#customer').val(),
                // from_date: $('#from_date').val(),
                // to_date: $('#to_date').val()
            },
            success: function (result) {
                for_response();
                $('#result_data').html('');
                var table = $('#myTable').DataTable();
                table.destroy();
                $('#result_data').html(result);
                datatable();
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function ()
    {
        $('#myTable').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "retrieve": true,
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('report/payment_ajaxList/'); ?>",
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
                var cols = [2, 3, 5];
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


    });
</script>
<script>
    $('.excel_btn1').live('click', function () {
        fnExcelReport1();
    });
</script>

<script>

    function datatable() {
        $('#myTable').DataTable({
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
                var cols = [2, 3, 5];
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
    }
    function fnExcelReport1()
    {
        var tab_text = "<table border='5px'><tr width='100px' bgcolor='#87AFC6'>";
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
        return (sa);
    }
</script>