<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>

<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>

<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>

<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />

<script type='text/javascript' src='<?= $theme_path; ?>/js/jquery.table2excel.min.js'></script>

<script src="<?= $theme_path; ?>/js/fixedheader/jquery.dataTables.min.js"></script> 

<style>

    .bg-red {background-color: #dd4b39 !important;}

    .bg-green { background-color:#09a20e !important;}

    .bg-yellow{background-color:orange !important;}

    .ui-datepicker td.ui-datepicker-today a { background:#999999;}

    .btn-group > .btn, .btn-group-vertical > .btn { border-width: 0px!important;}
	.search-area .col-md-2 {
    width: 16%;
}
table tr td:nth-child(6) {
	text-align:center;
}
table tr td:nth-child(7) {
	text-align:left;
}

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

                    <h3><?= $data['company_details'][0]['company_name'] ?></h3>

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

        <h4>Invoice List</h4>

    </div>

    <div class="panel-body mt--40">

        <div class="row search_table_hide search-area">

             <div class="col-md-2">

                <div class="form-group">

                    <label class="control-label">Shop Name</label>

                    <select id='firm_id' class="form-control">

                        <option>Select</option>

<?php
if (isset($firm_list) && !empty($firm_list)) {

    foreach ($firm_list as $key=>$val) {
         $select='';
                               if($key==0){
                                $select='selected=selected';
                               } ?>

                                <option <?php echo $select;?> value='<?= $val['firm_id'] ?>'><?= $val['firm_name'] ?></option>

                                <?php
                            }
                        }
                        ?>

                    </select>

                </div>

            </div>

            <div class="col-md-2">

                <div class="form-group">

                    <label class="control-label">Invoice Id</label>

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

            </div>

            <div class="col-md-2">

                <div class="form-group">

                    <label class="control-label">Customer</label>

                    <select id='customer'  class="form-control" >

                        <option>Select</option>

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

            <div class="col-md-2">

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

            <div class="col-md-2">

                <div class="form-group">

                    <label class="control-label">Sales Man</label>

                    <select id='sales_man'  class="form-control" >

                        <option>Select</option>

<?php
if (isset($sales_man_list) && !empty($sales_man_list)) {

    foreach ($sales_man_list as $val) {
        ?>

                                <option value='<?= $val['id'] ?>'><?= $val['sales_man_name'] ?></option>

        <?php
    }
}
?>

                    </select>

                </div>

            </div>

            <div class="col-md-2">

                <div class="form-group">

                    <label class="control-label">From Date</label>

                    <input type="text" id='from_date'  class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >

                </div>

            </div>

            <div class="col-md-2">

                <div class="form-group">

                    <label class="control-label">To Date</label>

                    <input type="text"  id='to_date' class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >

                </div>

            </div>

            <input type="hidden" name="overdue" id="overdue" value=""/>

            <input type="hidden" name="gst_sales_report" id="gst_sales_report" value=""/>

         <!--   <div class="col-md-3">

                <div class="form-group">

                    <label class="control-label">Overdue</label>

                    <select name="overdue" id="overdue" class="form-control">

                        <option value="">Select</option>

                        <option value="1">Credit Days</option>

                        <option value="2">Credit Limit</option>

                    </select>

                </div>

            </div>

            <div class="col-md-3">

                <div class="form-group">

                    <label class="control-label">GST</label>

                    <select id='gst_sales_report'  class="form-control" >

                        <option>Select</option>

<?php
if (isset($all_gst) && !empty($all_gst)) {

    foreach ($all_gst as $val) {
        ?>

                                <option value='<?= $val ?>'><?= $val ?>%</option>

        <?php
    }
}
?>

                    </select>

                </div>

            </div>-->

            <div class="col-md-2">

                <div class="form-group mcenter">

                    <label class="control-label col-md-12 mnone">&nbsp;</label>

                    <a id='search' class="btn btn-success  mtop4"><span class="glyphicon glyphicon-search "></span> Search</a>

                    <a class="btn btn-danger1 mtop4" id="clear"><span class="fa fa-close"></span> Clear</a>

                </div>

            </div>

        </div>

    </div>

    <div class="contentpanel">

        <div class="panel-body mt-top5">

            <div class="result_div">

                <table id="basicTable_call_back" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline invoiceid-cntr totalqua-cntr cgst-right  subtot-right invoiceamount-right paidamount-right  ">

                    <thead>

                          <tr style="text-align:center;">

                            <td class="action-btn-align">S.No</td>

                            <td class="action-btn-align">Invoice ID</td>

                            <td class="action-btn-align">Customer Name</td>

                            <td class="action-btn-align">Total Quantity</td>

                            <!--<td class="action-btn-align">CGST</td>

                            <td class="action-btn-align">SGST</td>

                            <td class="action-btn-align">Sub Total</td>-->

                            <td class="action-btn-align" style="text-align:center !important;">Invoice Amount</td>

<!--                            <td class="action-btn-align">Paid Amount</td>-->

                            <td class="action-btn-align" style="text-align:center !important;">Invoice Date</td>

                           <!-- <td class="action-btn-align">Paid Date</td>

                            <td class="action-btn-align">Credit Days</td>

                            <td class="action-btn-align">Due Date</td>

                            <td class="action-btn-align">Credit Limit</td>

                            <td class="action-btn-align">Exceeded Credit Limit</td>-->

                            <td class="action-btn-align" style="text-align:center !important;">Sales Man</td>

                            <!--<td>Remarks</td>-->



                        </tr>

                    </thead>



                    <tbody id='result_div'>



                    </tbody>

                    <tfoot>

                        <tr>

                            <td></td>

                            <td></td>

                            <td></td>

                            <td class="action-btn-align total-bg"></td>

                           <!-- <td class="text_right total-bg"></td>

                            <td class="text_right total-bg"></td>

                            <td class="text_right total-bg"></td>-->

                            <td class="text_right total-bg"></td>

                           <!-- <td class="text_right total-bg"></td>-->

                            <td></td>

                           <!-- <td></td>

                            <td ></td>

                            <td></td>

                            <td></td>

                            <td></td>-->

                            <td></td>





                        </tr>

                    </tfoot>

<!-- <tfoot>

    <tr>

        <td colspan="4"></td>

        <td class="text_right total-bg"><?= number_format($tot, 2); ?></td>

        <td colspan="4"></td>

    </tr>

</tfoot>-->



                </table>

            </div>

            <div class="action-btn-align mb-10">

                <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>

                <!--<button class="btn btn-success excel_btn1" ><span class="glyphicon glyphicon-print"></span> Excel</button>-->

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

    });</script>

</div><!-- contentpanel -->



</div><!-- mainpanel -->

<script type="text/javascript">





    $(document).ready(function () {

        $('#customer').select2();

        $('#inv_id').select2();

        $('#product').select2();

        // jQuery('.datepicker').datepicker();

    });



    $(function () {

        $("#from_date").datepicker({
            numberOfMonths: 1,
            dateFormat: 'dd-mm-yy',
            onSelect: function (selected) {

                var dt = new Date(selected);

                dt.setDate(dt.getDate() + 1);

                $("#to_date").datepicker("option", "minDate", dt);

            }

        });

        $("#to_date").datepicker({
            numberOfMonths: 1,
            dateFormat: 'dd-mm-yy',
            onSelect: function (selected) {

                var dt = new Date(selected);

                dt.setDate(dt.getDate() - 1);

                $("#from_date").datepicker("option", "maxDate", dt);

            }

        });



         var currentDate = new Date();  
        $("#from_date").datepicker("setDate",currentDate);
        $("#to_date").datepicker("setDate",currentDate);

    });





    $().ready(function () {

        $("#po_no").autocomplete(BASE_URL + "gen/get_po_list", {
            width: 260,
            autoFocus: true,
            matchContains: true,
            selectFirst: false

        });

    });

   /* $('#search').live('click', function () {

        //alert($('#gst_sales_report').val());

        for_loading();

        $.ajax({
            url: BASE_URL + "report/invoice_search_result",
            type: 'GET',
            cache: false,
            data: {
                inv_id: $('#inv_id').val(),
                customer: $('#customer').val(),
                product: $('#product').val(),
                sales_man: $('#sales_man').val(),
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val(),
                overdue: $('#overdue').val(),
                firm_id: $('#firm_id').val(),
                gst: $('#gst_sales_report').val(),
            },
            success: function (result) {

                for_response();

                $('.result_div').html('');

                $('.result_div').html(result);

                data_tab_init();

            }

        });

    });*/

</script>

<script type="text/javascript">

     

    $(document).ready(function ()

    {

       var table;
    table = $('#basicTable_call_back').DataTable({
        "lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "retrieve": true,
        "order": [], //Initial no order.
        //dom: 'Bfrtip',
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": '<?php echo base_url() . 'report/invoice_ajaxList'; ?>',
            "type": "POST",
            "data": function (data) {
                data.inv_id = $('#inv_id').val();
                data.customer = $('#customer').val();
                data.product =$('#product').val();
                data.sales_man = $('#sales_man').val();
                data.from_date = $('#from_date').val();
                data.to_date = $('#to_date').val();
                data.overdue = $('#overdue').val();
                data.firm_id = $('#firm_id').val();
                data.gst = $('#gst_sales_report').val();

            }
        },
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
              var cols = [3,4];
                 symbol = " ";
                var numFormat = $.fn.dataTable.render.number('\,', '.', 2, symbol).display;
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
                    //$(api.column(cols[x]).footer()).html(pageTotal);
                     $(api.column(cols[x]).footer()).html(numFormat(parseFloat(pageTotal).toFixed(2)));

                }


            },
        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [0, 6], //first column / numbering column
                "orderable": false, //set not orderable
            },
        ],
        responsive: true,
        columnDefs: [
            {responsivePriority: 1, targets: 0},
            {responsivePriority: 2, targets: -2}
        ],
      
    });

    $('#search').click(function () { //button filter event click
        table.ajax.reload();  //just reload table
    });
    $('#reset').click(function () { //button reset event click

        window.location.reload();
    });


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



    function data_tab_init() {

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

                var cols = [3, 4];

                 symbol = " ";

               var numFormat = $.fn.dataTable.render.number('\,', '.', 2, symbol).display;

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

                  //  $(api.column(cols[x]).footer()).html(pageTotal);

                    $(api.column(cols[x]).footer()).html(numFormat(parseFloat(pageTotal).toFixed(2)));

                }





            },
            responsive: true,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -2}

            ]

        });

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

         return (sa);

         } */



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
            name: "Invoice Report",
            filename: "Invoice Report",
            fileext: ".xls",
            exclude_img: false,
            exclude_links: false,
            exclude_inputs: false

        });

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



    }

    $('#excel-prt').on('click', function ()

    {



        var arr = [];

        arr.push({'inv_id': $('#inv_id').val()});

        arr.push({'customer': $('#customer').val()});

        arr.push({'product': $('#product').val()});

        arr.push({'sales_man': $('#sales_man').val()});

        arr.push({'from': $('#from_date').val()});

        arr.push({'to': $('#to_date').val()});

        arr.push({'overdue': $('#overdue').val()});

        arr.push({'gst_sales_report': $('#gst_sales_report').val()});

        var arrStr = JSON.stringify(arr);



        window.location.replace('<?php echo $this->config->item('base_url') . 'report/inv_excel_report?search=' ?>' + arrStr);

    });

</script>





