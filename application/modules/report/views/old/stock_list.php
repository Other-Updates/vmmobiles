<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>



<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>



<link href="<?php echo $theme_path; ?>/plugin/datatables/css/jquery.dataTables.min.css" rel="stylesheet">



<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/css/fSelect.css"/>



<script type='text/javascript' src='<?= $theme_path; ?>/js/jquery.table2excel.min.js'></script>



<style>



    .bg-red { background-color: #dd4b39 !important;}



    .bg-green {background-color:#09a20e !important;}



    .bg-yellow{background-color:orange !important;}



    .ui-datepicker td.ui-datepicker-today a {background:#999999;}



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



        <h4 class="">Stock List</h4>



    </div>



    <div class="panel-body mt--40">



        <div class="row search_table_hide search-area">



        <div class="col-sm-2">



                <div class="form-group">



                    <label class="control-label">Shop Name</label>



                    <select id='firm_id' class="form-control">



                        <option>Select</option>



                        <?php



                        if (isset($firm_list) && !empty($firm_list)) {



                            foreach ($firm_list as $key=> $val) {

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



            <div class="col-sm-2">



                <div class="form-group">



                    <label class="control-label">Category</label>



                    <select id='category' class="form-control">



                        <option>Select</option>



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



            <div class="col-sm-2">



                <div class="form-group">



                    <label class="control-label">Product</label>



                    <select id='product'  class="form-control multi_select" multiple="multiple">



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



            <div class="col-sm-2">



                <div class="form-group">



                    <label class="control-label">Brand</label>



                    <select id='brand'  class="form-control">



                        <option>Select</option>



                        <?php



                        if (isset($brand) && !empty($brand)) {



                            foreach ($brand as $val) {



                                ?>



                                <option value='<?= $val['id'] ?>'><?= $val['brands'] ?></option>



                                <?php



                            }



                        }



                        ?>



                    </select>



                </div>



            </div>







            <?php /*







              <div class="col-sm-2">



              <div class="form-group">



              <label class="control-label">From</label>



              <input type="text" name="from_date" id="from_date" class="datepicker form-control" placeholder="Select From Date">



              </div>



              </div>



              <div class="col-sm-2">



              <div class="form-group">



              <label class="control-label">To</label>



              <input type="text" name="to_date" id="to_date" class="datepicker form-control" placeholder="Select To Date">



              </div>



              </div>



             */



            ?>







            <div class="col-sm-2">



                <div class="form-group mcenter">



                    <label class="control-label col-md-12 mnone">&nbsp;</label>



                    <a id='search' class="btn btn-success  mtop4"><span class="glyphicon glyphicon-search"></span> Search</a>&nbsp;



                    <a class="btn btn-danger1 mtop4" id='clear'><span class="fa fa-close"></span> Clear</a>



                </div>



            </div>



        </div>



    </div>



    <div class="contentpanel">



        <div  class="panel-body mt-top5">



            <table id="myTable" class="display last-td-center dataTable table table-striped table-bordered responsive dataTable dtr-inline no-footer " cellspacing="0" width="100%" >



                <thead>



                    <tr style="text-align:center;">



                        <td class="action-btn-align">S.No</td>



                        <td>Category</td>



                        <td>Product</td>



                        <td>Brand</td>



                        <!-- <td>Model No</td> -->



                        



                        <td class="action-btn-align">Quantity</td>







                    </tr>



                </thead>



                <tfoot class="hide_class">



                    <tr>



                        <td ></td>



                        <td ></td>



                        <td ></td>



                        <td ></td>







                        <td class="hide_class total-bg action-btn-align"></td>







                    </tr>



                </tfoot>



                <tbody id='result_div'>



                    <?php



                    /* if (isset($stock) && !empty($stock)) {



                      $i = 1;



                      foreach ($stock as $val) {



                      ?>



                      <tr>



                      <td class='first_td action-btn-align'><?= $i ?></td>



                      <td><?= $val['categoryName'] ?></td>



                      <td><?= $val['brands'] ?></td>



                      <!--  <td><?= $val['model_no'] ?></td> -->



                      <td><?= $val['product_name'] ?></td>



                      <td class="action-btn-align"><?= $val['quantity'] ?></td>



                      </tr>







                      <?php



                      $i++;



                      }



                      } */



                    ?>



                </tbody>



            </table>







            <div class="action-btn-align">



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

            "url": '<?php echo base_url() . 'report/ajaxList'; ?>',

            "type": "POST",

            "data": function (data) {

                 data.brand =$('#brand').val();

                data.product =$('#product').val();

                data.category = $('#category').val();

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

              var cols = [4];

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



    new $.fn.dataTable.FixedHeader(table);



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



    $('#clear').on('click', function () {



        window.location.reload();



    });



    $('#search').on('click', function () {



        //alert(1);



        for_loading();



        $.ajax({



            url: BASE_URL + "report/stock_search_result",



            type: 'GET',



            data: {



                brand: $('#brand').val(),



                product: $('#product').val(),



                category: $('#category').val(),



                from_date: $('#from_date').val(),



                to_date: $('#to_date').val(),



                  firm_id: $('#firm_id').val(),



            },



            success: function (result) {



                for_response();



                var table = $('#myTable').DataTable();





                table.destroy();



                $('#result_div').html('');



                $('#result_div').html(result);



                datatable();











            }



        });



    });



</script>



<script type="text/javascript">



    $(document).ready(function () {



        $('.datepicker').datepicker({



            dateFormat: 'yy-mm-dd',



        });



        $('.multi_select').fSelect();







        $('#search_clear').click(function ()



        {



            $('#category').val('Select');



            $('#product').val('Select');



            $('.fs-label').text('Select some Options');



            $('#brand').val('Select');



            $('#from_date').val('');



            $('#to_date').val('');







        });



          $('.fs-label-wrap').find('.fs-label').text();

        $('.fs-label-wrap').find('.fs-label').text('Select Product');



    });



</script>







<script>



    $('#excel-prt').on('click', function ()



    {



        var arr = [];



        arr.push({'report': 1});



        arr.push({'category': $('#category').val()});



        arr.push({'product': $('#product').val()});



        arr.push({'brand': $('#brand').val()});



        arr.push({'from': $('#from_date').val()});



        arr.push({'to': $('#to_date').val()});



        var arrStr = JSON.stringify(arr);



        window.location.replace('<?php echo $this->config->item('base_url') . 'stock/excel_report?search=' ?>' + arrStr);



    });













    function datatable()



    {





        var table;



        //datatables



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



                var cols = [4];



                pageTotal='';



                for (x in cols) {



                    console.log(1);



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



                    if (x == 0) {

                        $(api.column(cols[x]).footer()).html(pageTotal);

                    } else {

                        $(api.column(cols[x]).footer()).html(numFormat(pageTotal));

                    }







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











