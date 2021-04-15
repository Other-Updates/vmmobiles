<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<script type='text/javascript' src='<?= $theme_path; ?>/js/jquery.table2excel.min.js'></script>
<style>
    .bg-red {background-color: #dd4b39 !important;}
    .bg-green {background-color:#09a20e !important;}
    .bg-yellow{background-color:orange !important;}
    .ui-datepicker td.ui-datepicker-today a { background:#999999;}
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
        <h4>Sales Cost List</h4>
    </div>
    <div class="panel-body">
        <div class="row search_table_hide search-area">
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">Sales Id</label>
                    <select id='job_id' class="form-control">
                        <option>Select</option>
                        <?php
                        if (isset($all_style) && !empty($all_style)) {
                            foreach ($all_style as $val) {
                                ?>
                                <option value='<?= $val['job_id'] ?>'><?= $val['job_id'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">Customer</label>
                    <select id='customer'  class="form-control">
                        <option>Select</option>
                        <?php
                        if (isset($all_supplier) && !empty($all_supplier)) {
                            foreach ($all_supplier as $val) {
                                ?>
                                <option value='<?= $val['id'] ?>'><?= $val['name'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">Product</label>
                    <select id='product'  class="form-control">
                        <option>Select</option>
                        <?php
                        if (isset($all_product) && !empty($all_product)) {
                            foreach ($all_product as $val) {
                                ?>
                                <option value='<?= $val['id'] ?>'><?= $val['product_name'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">From Date</label>
                    <input type="text" id='from_date'  class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">To Date</label>
                    <input type="text"  id='to_date' class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group mcenter">
                    <label class="control-label col-md-12 mnone">&nbsp;</label>
                    <a id='search' class="btn btn-success mtop4"><span class="glyphicon glyphicon-search "></span> Search</a>
                    <a class="btn btn-danger1 mtop4" id="clear"><span class="fa fa-close"></span> Clear</a>
                </div>
            </div>
        </div>

    </div>
    <div class="contentpanel">
        <div  class="panel-body mt-top5">
            <div class="">
                <table id="basicTable_call_back" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline
                       saltquq-cntr salsubtotal-right salcostamt-right saldate1-right"  cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <td class="action-btn-align">S.No</td>
                            <td class="action-btn-align">Sales ID</td>
                            <td>Customer Name</td>
                            <td class="action-btn-align">Total Quantity</td>
                            <!--<td class="action-btn-align">Total Tax</td>-->
                            <td class="action-btn-align">Sub Total</td>
                            <td>Sales Cost Amount</td>
                            <td class="action-btn-align">Sales Cost Date</td>
                            <!--<td>Remarks</td>-->

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="action-btn-align total-bg"></td>
                            <!--<td class="text_right total-bg"></td>-->
                            <td class="text_right total-bg"></td>
                            <td class="text_right total-bg"></td>
                            <td class=" "></td>


                        </tr>
                    </tfoot>
                    <tbody  id='result_div' >
                        <?php
                        if (isset($quotation) && !empty($quotation)) {
                            $i = 1;
                            foreach ($quotation as $val) {
                                ?>
                                <tr>
                                    <td class='first_td action-btn-align'><?= $i ?></td>
                                    <td class="action-btn-align"><?= $val['job_id'] ?></td>
                                    <td><?php echo ($val['store_name']) ? $val['store_name'] : $val['name']; ?></td>
                                    <td class="action-btn-align"><?= $val['total_qty'] ?></td>
                                    <!--<td class="text_right"><?= number_format(($val['tax_details'][0]['tot_tax']), 2); ?></td>-->
                                    <td class="text_right"><?= number_format($val['subtotal_qty'], 2); ?></td>
                                    <td class="text_right"><?= number_format($val['net_total'], 2) ?></td>
                                    <td class="action-btn-align"><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td>
                                    <!--<td><?= $val['remarks'] ?></td>-->

                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                    </tbody>
                </table>
            </div>
            <div class="action-btn-align mb-10">
                <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                <!--<button class="btn btn-success excel_btn" id="excel-prt"><span class="glyphicon glyphicon-print"></span> Excel</button>-->
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
            url: BASE_URL + "report/pc_search_result",
            type: 'GET',
            data: {
                job_id: $('#job_id').val(),
                customer: $('#customer').val(),
                product: $('#product').val(),
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val()
            },
            success: function (result) {
                for_response();
                var table = $('#basicTable_call_back').DataTable();
                table.destroy();
                $('#result_div').html('');
                $('#result_div').html(result);
                datatable();
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function ()
    {
        var table;
        table = jQuery('#basicTable_call_back').DataTable({
            "lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
            "pageLength": 50,
            "processing": false, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "retrieve": true,
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('report/pc_ajaxList/'); ?>",
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
                var cols = [3, 4, 5];
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
<script>


    $('#excel-prt').on('click', function ()
    {
        var arr = [];
        arr.push({'job_id': $('#job_id').val()});
        arr.push({'customer': $('#customer').val()});
        arr.push({'product': $('#product').val()});
        arr.push({'from': $('#from_date').val()});
        arr.push({'to': $('#to_date').val()});
        var arrStr = JSON.stringify(arr);

        window.location.replace('<?php echo $this->config->item('base_url') . 'sales/excel_report?search=' ?>' + arrStr);
    });
</script>
<script>
    function datatable() {
        var table;
        table = jQuery('#basicTable_call_back').DataTable({
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
                var cols = [3, 4, 5];
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
    $('.excel_btn1').live('click', function () {

        fnExcelReport2();
    });</script>
<script>
    function fnExcelReport2()
    {

        /*var tab_text = "<table border='5px'><tr width='100px' bgcolor='#87AFC6'>";
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
         return (sa);*/


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
            name: "Sales Report",
            filename: "Sales Report",
            fileext: ".xls",
            exclude_img: false,
            exclude_links: false,
            exclude_inputs: false
        });
    }

    /*

     $('#to_date').blur(function () {
     var from_date = $('#from_date').val();
     var to_date = $('#to_date').val();
     var startDate = new Date($('#from_date').val());
     var endDate = new Date($('#to_date').val());

     //console.log("Start Date :" + startDate + "EndDate : " + endDate);

     if ($.trim(to_date) != '' && $.trim(from_date) != '')
     {
     if (endDate < startDate) {
     alert("End Date should greater than the Start Date.");
     $('#to_date').val('');
     }

     }

     });

     */


</script>
<script src="<?= $theme_path; ?>/js/fixedheader/jquery.dataTables.min.js"></script>
