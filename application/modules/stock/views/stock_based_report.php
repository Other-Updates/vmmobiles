<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<link href="<?php echo $theme_path; ?>/plugin/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/css/fSelect.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/js//sweetalert.css">
<script src="<?php echo $theme_path; ?>/js/sweetalert.min.js" type="text/javascript"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/jquery.table2excel.min.js'></script>
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
        <h4>Stock List</h4>
    </div>
    <div class="panel-body pnone">
        <div class="row search_table_hide mb-0">

             <div class="col-md-3">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Shop Name</label>
                    <div class="col-sm-8">
                        <select id='firm_id' class="form-control">
                            <option value="">Select</option>
                            <?php
                            if (isset($frim_list) && !empty($frim_list)) {
                                foreach ($frim_list as $key=>$val) {
                                   $select='';
                                   if($key==0){
                                    $select="selected=selected";
                                   } ?>
                                    <option <?php echo $select;?> value='<?= $val['firm_id'] ?>'><?= $val['firm_name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Category</label>
                    <div class="col-sm-8">
                        <select id='category' class="form-control">
                            <option value="">Select</option>
                            <?php
                            if (isset($cat) && !empty($cat)) {
                                foreach ($cat as $val) {
                                    ?>
                                    <option value='<?= $val['cat_id'] ?>'><?= $val['categoryName'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Product</label>
                    <div class="col-sm-8 wid100-div">
                        <select id='product' name="product[]" class="form-control multi_select wid100" multiple="multiple">
                            <option>Select</option>
                            <?php
                            if (isset($product) && !empty($product)) {
                                foreach ($product as $val) {
                                    ?>
                                    <option value='<?= $val['id'] ?>'><?= $val['product_name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3"><a id='search' class="btn btn-success"><span class="glyphicon glyphicon-search "></span> Search</a></div>
        </div>
    </div>
    <div class="contentpanel mb-50">
        <div  class="panel-body mt-top5">
            <table id="example1" class="display dataTable table table-striped table-bordered responsive dataTable dtr-inline no-footer
                   costprice-right quantity1-cntr tprice-right cgstam-right sgstamt-right totalpricewith-right" cellspacing="0" width="100%">
                <thead>
                      <tr style="text-align:center;">
                        <td >S.No</td>
                        <td width=''>Shop</td>
                        <td width=''>Category</td>
                        <td width=''>Brand</td>
                        <td width=''>Product</td>
                        <td width=''>Cost Price</td>
                        <td width='' class="action-btn-align">Qty</td>
                        <td width='' class="action-btn-align" style="text-align:center;">Total Price (Without GST)</td>
                        <td width='' class="action-btn-align" style="text-align:center !important;">CGST</td>
                        <td width='' class="action-btn-align" style="text-align:center !important;">SGST</td>
                        <td width='' class="action-btn-align" style="text-align:center !important;">Total Price (With GST)</td>
<!--                        <td width='5%' class="hide_class action-btn-align">Action</td>-->
                    </tr>
                </thead>
                <tbody id="result_div">

                </tbody>
                <tfoot class="hide_class">
                    <tr>
                        <td width=''></td>
                        <td width=''></td>
                        <td width=''></td>
                        <td width=''></td>
                        <td width=''></td>
                        <td width='' class="total-bg action-btn-align"></td>
                        <td width=''></td>
                        <td width=''></td>
                        <td width=''></td>
                        <td width=''></td>
<!--                        <td width='10%' class="hide_class"></td>-->
                    </tr>
                </tfoot>
            </table>

            <div class="action-btn-align">
                <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                <!--<button class="btn btn-success excel" id="excel-prt"><span class="glyphicon glyphicon-print"></span> Excel</button>-->
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
<script type="text/javascript" src="<?php echo $theme_path; ?>/js/jquery-1.12.4.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/buttons.print.min.js"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/fSelect.js'></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/jquery.table2excel.min.js'></script>
<script type="text/javascript">
    var table;
    jQuery(document).ready(function () {
        //datatables
        var product = $('#product').val();
        var category = $('#category').val();
        var inventory = 1;
        table = jQuery('#example1').DataTable({
            "lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
            "pageLength": 50,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('stock/ajaxList_report/'); ?>",
                "type": "POST",
                //"data": {"product": product, "category": $('#category').val(), "inventory": 1}
            },
            //Set column definition initialisation properties.

            "columnDefs": [
                {
                    "targets": [0, 5, 6], //first column / numbering column
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
                var cols = [5];

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
                    if (Math.floor(pageTotal) == pageTotal && $.isNumeric(pageTotal)) {
                        pageTotal = pageTotal;

                    } else {
                        pageTotal = pageTotal.toFixed(2);/* float */

                    }
                    // Update footer
                   // $(api.column(cols[x]).footer()).html(pageTotal);
                    $(api.column(cols[x]).footer()).html(numFormat(parseFloat(pageTotal).toFixed(2)));
                }

            },
        });

        new $.fn.dataTable.FixedHeader(table);
    });



</script>
<script>
    $(document).ready(function ()
    {
        //$('.purchase_link').text('');
        $('.multi_select').fSelect();
        var arr = [];
        $('#excel-prt').on('click', function ()
        {
            var arr = [];

            arr.push({'category': $('#category').val()});
            arr.push({'product': $('#product').val()});
            var arrStr = JSON.stringify(arr);
            window.location.replace('<?php echo $this->config->item('base_url') . 'stock/excel_stock_based_report?search=' ?>' + arrStr);
        });
          $('.fs-label-wrap').find('.fs-label').text();
        $('.fs-label-wrap').find('.fs-label').text('Select Product');
    });</script>
<script>
    $(document).on('click', '.alerts', function () {
        sweetAlert("Oops...", "This Access is blocked!", "error");
        return false;
    });

    $('.print_btn').click(function () {
        window.print();
    });
    $('#search').on('click', function () {
        // alert(1);
        for_loading();
        $.ajax({
            url: BASE_URL + "stock/stock_report_search_result",
            type: 'GET',
            cache: false,
            data: {
                product: $('#product').val(),
                category: $('#category').val(),
                 firm_id: $('#firm_id').val(),
                inventory: 1,
            },
            success: function (result) {
                for_response();
                var table = $('#example1').DataTable();
                table.destroy();
                $('#result_div').html('');
                $('#result_div').html(result);
                datatable();


            }
        });
    });

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

    function datatable()
    {

        $('#example1').DataTable({
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
                var total='';
                var pageTotal='';
                var cols = [5];

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


</script>
<script>
    $('.excel_btn1').on('click', function () {

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
        tab = document.getElementById('example1'); // id of table
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
            name: "System Stock Report",
            filename: "System Stock Report",
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