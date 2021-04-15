<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>

<!--
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js"></script> -->

<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>

<link href="<?php echo $theme_path; ?>/plugin/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

<script type='text/javascript' src='<?php echo $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />

<script type='text/javascript' src='<?= $theme_path; ?>/js/jquery.table2excel.min.js'></script>

<style>

    .bg-red {background-color: #dd4b39 !important;}

    .bg-green {background-color:#09a20e !important;}

    .bg-yellow{ background-color:orange !important;}

    .ui-datepicker td.ui-datepicker-today a {background:#999999;}

    .btn-group > .btn, .btn-group-vertical > .btn { border-width: 0px!important;}
table tr td:nth-child(4) {
	text-align:center;
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

                <div class="print_header_logo" ><img src="<?= $theme_path; ?>/images/logo-login2.png" /></div>

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

        <h4>Profit and Loss Report</h4>

    </div>

    <div class="panel-body">

        <div class="row search_table_hide search-area">

             <div class="col-md-3">

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


            <div class="col-md-3">

                <div class="form-group">

                    <label class="control-label">From Date</label>

                    <input type="text" id='from_date'  class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >

                </div>

            </div>

            <div class="col-md-3">

                <div class="form-group">

                    <label class="control-label">To Date</label>

                    <input type="text"  id='to_date' class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy">

                </div>

            </div>

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

        <div id='result_div' class="panel-body mt-top5">

            <div class="">

                <table id="myTable" class="display last-td-center dataTable table table-striped table-bordered responsive dataTable dtr-inline no-footer invoiceamount-right

                       commissionamount-right originalamt-right profit-cntr profitamt-left" cellspacing="0" width="100%">

                    <thead>

                         <tr style="text-align:center;">

                            <td class="action-btn-align">S.No</td>

<!--                            <td class="action-btn-align">Quotation No</td>-->

                            <td>Customer Name</td>

<!--                            <td>Quotation Amount</td>-->

                            <td>Invoice NO</td>

                            <td class="action-btn-align">Invoice Date</td>

                            <td style="text-align:center !important;">Invoice Amount</td>

                            <td style="text-align:center !important;">Commission Amount</td>

                            <td style="text-align:center !important;">Original Amount</td>

                            <td style="text-align:center !important;">Profit %</td>

                            <td style="text-align:center !important;">Profit Amount</td>

                        </tr>

                    </thead>



                    <tbody id="result_data">

                        <?php

                        ?>

                    </tbody>



                    <tfoot>

                        <tr>

                            <td></td>

                            <td></td>



                            <td></td>

                            <td></td>

                            <td class="text_right total-bg"></td>

                            <td class="text_right total-bg"></td>

                            <td class="text_right total-bg"></td>

                            <td></td>

                            <td class="text_right total-bg"></td>

                        </tr>

                    </tfoot>



                </table>

            </div>

            <div class="action-btn-align mb-10">

                <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>

                <!--<button class="btn btn-success excel_btn1"><span class="glyphicon glyphicon-print"></span> Excel</button>-->

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

    </div><!-- contentpanel -->



</div><!-- mainpanel -->

<div id="export_excel"></div>

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
    table = $('#myTable').DataTable({
        "lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "retrieve": true,
        "order": [], //Initial no order.
        //dom: 'Bfrtip',
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": '<?php echo base_url() . 'report/profit_ajaxList'; ?>',
            "type": "POST",
            "data": function (data) {
                data.from_date = $('#from_date').val();
                data.to_date = $('#to_date').val();
                data.firm_id = $('#firm_id').val();
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
              var cols = [4,5,6,8];
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
                "targets": [0, 4], //first column / numbering column
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


    });





</script>

<script>

    $('.print_btn').click(function () {

        window.print();

    });

    $('#clear').on('click', function ()

    {

        window.location.reload();

    });



</script>

<script type="text/javascript">

    $('.complete_remarks').on('blur', function ()

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

  /*  $('#search').on('click', function () {

        for_loading();

        $.ajax({

            url: BASE_URL + "report/search_profit_list",

            type: 'GET',

            data: {

             firm_id: $('#firm_id').val(),

                from_date: $('#from_date').val(),

                to_date: $('#to_date').val()

            },

            success: function (result) {

                for_response();

                var table = $('#myTable').DataTable();

                table.destroy();

                $('#result_data').html(result);

                datatable();



            }

        });

    });*/

</script>

<script type="text/javascript">

    $(document).ready(function ()

    {



        $("#yesin").on("click", function ()

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

    $('.excel_btn1').on('click', function () {

        fnExcelReport1();

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

                var cols = [4, 6, 5, 8];

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

        /* var tab_text = "<table border='5px'><tr width='100px' bgcolor='#87AFC6'>";

         var textRange;

         var j = 0;

         tab = document.getElementById('myTable'); // id of table

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

        tab = document.getElementById('myTable'); // id of table

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

            name: "Profit and Loss Report",

            filename: "Profit and Loss Report",

            fileext: ".xls",

            exclude_img: false,

            exclude_links: false,

            exclude_inputs: false

        });

    }

    $('#excel-prt').on('click', function ()

    {

        var arr = [];

        arr.push({'from_date': $('#from_date').val()});

        arr.push({'to_date': $('#to_date').val()});

        var arrStr = JSON.stringify(arr);

        window.location.replace('<?php echo $this->config->item('base_url') . 'report/profit_excel_report?search=' ?>' + arrStr);

    });

</script>

<script src="<?= $theme_path; ?>/js/fixedheader/jquery.dataTables.min.js"></script>