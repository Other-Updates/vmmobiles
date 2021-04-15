<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>



<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>



<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>



<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>



<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />



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

table tr td:nth-child(5) {
	text-align:center;
}
table tr td:nth-child(6) {
	text-align:right;
}
table tr td:nth-child(7) {
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



    <!--<div class="pageheader">



<div class="media">



<div class="pageicon pull-left">



    <i class="fa fa-quote-right pageheader_icon iconquo"></i>



</div>



<div class="media-body">



    <ul class="breadcrumb">



        <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>



        <li>Home</li>



    </ul>



    <h4>Quotation List</h4>



     <a href="<?php echo $this->config->item('base_url') . 'purchase_order/' ?>" class="btn btn-success right topgen adden"><span class="glyphicon glyphicon-plus"></span> Add Quotation</a>



</div>







</div>



</div>-->



    <div class="media mt--20">



        <h4>Inward List



            <a href="<?php if ($this->user_auth->is_action_allowed('purchase', 'purchase_order', 'add')): ?><?php echo $this->config->item('base_url') . 'purchase_order/' ?><?php endif ?>" class="btn btn-success right topgen <?php if (!$this->user_auth->is_action_allowed('purchase', 'purchase_order', 'add')): ?>alerts<?php endif ?>"><span class="glyphicon glyphicon-plus"></span> New Inward</a>



        </h4>



    </div>



    <div class="contentpanel">



        <div id='result_div' class="panel-body mt-top5 pb0">



            <div class="tabpad">



                <table id="basicTable_call_back" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">



                    <thead>



                        <tr>



                            <th class="action-btn-align">S.No</th>



                            <th class="action-btn-align">Shop</th>



                         <!--   <td class='action-btn-align'>PR No</td>-->



                            <th class='action-btn-align'>PO No</th>



                            <th class="action-btn-align">Supplier Name</th>



                            <th class="action-btn-align">Total Quantity</th>



                          <!--  <td class="action-btn-align">Delivery Quantity</td>-->



                            <th class="action-btn-align">Total Amount</th>



                            <th class='action-btn-align'>Created Date</th>



                           <!-- <td class='action-btn-align'>PR Status</td>



                            <td class='action-btn-align'>Delivery Status</td>-->



                            <th class="hide_class action-btn-align">Action</th>



                        </tr>



                    </thead>







                    <tbody>



               <!--      <?php



                        if (isset($po) && !empty($po)) {



                            $i = 1;



                            foreach ($po as $val) {



                                ?>



                                <tr>



                                    <td class='first_td action-btn-align'><?= $i ?></td>



                                    <td><?= $val['firm_name'] ?></td>



                                 <!--   <td class='action-btn-align'><?= $val['pr_no'] ?></td>







                                    <td class='action-btn-align'><?= ($val['pr_status'] == 'approved') ? $val['po_no'] : '-' ?></td>



                                    <td><?= $val['store_name'] ?></td>







                                    <td class="action-btn-align"><?= $val['total_qty'] ?></td>



                                   <!-- <td class="action-btn-align"><?= $val['delivery_qty'] ?></td>







                                    <td class="text_right"><?= number_format($val['net_total'], 2); ?></td>



                                    <td class='action-btn-align'><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '-'; ?></td>



                                    <?php



                                    $pr_status = $delivery_status = '';



                                    if ($val['pr_status'] == 'waiting') {



                                        $pr_status = '<span class=" badge  bg-red">Waiting</span>';



                                    } else if ($val['pr_status'] == 'approved') {



                                        $pr_status = '<span class=" badge bg-green">Approved</span>';



                                    }



                                    ?>



                                   <!-- <td class="action-btn-align"><?php echo $pr_status; ?></td>







                                    <?php



                                    if ($val['delivery_status'] == 'partially_delivered') {



                                        $delivery_status = '<span class="badge bg-red">Partially Delivered</span>';



                                    } else if ($val['delivery_status'] == 'pending') {



                                        $delivery_status = '<span class="badge bg-yellow">Pending</span>';



                                    } else if ($val['delivery_status'] == 'delivered') {



                                        $delivery_status = '<span class = "badge bg-green">Delivered</span>';



                                    }



                                    ?>







                                   <!-- <td class="action-btn-align"><?php echo $delivery_status; ?></td>







                                    <td class='hide_class  action-btn-align'>



                                        <?php



                                        if ($val['pr_status'] == 'waiting') {



                                            if ($this->user_auth->is_section_allowed('purchase', 'purchase_request')) {



                                                ?>



                                                <a href="<?php if ($this->user_auth->is_action_allowed('purchase', 'purchase_request', 'edit')): ?><?php echo $this->config->item('base_url') . 'purchase_order/po_edit/' . $val['id'] ?><?php endif ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('purchase', 'purchase_request', 'edit')): ?>alerts<?php endif ?>" title="" data-original-title="Edit" ><span class="fa fa-edit"></span></a>



                                            <?php }



                                            ?>



                                            <a href="<?php if ($this->user_auth->is_action_allowed('purchase', 'purchase_order', 'view')): ?><?php echo $this->config->item('base_url') . 'purchase_order/pr_view/' . $val['id'] ?><?php endif ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('purchase', 'purchase_order', 'view')): ?>alerts<?php endif ?>" title="" data-original-title="PR-View" ><span class="fa fa-eye"></span></a>







                                            <?php



                                        }







                                        if ($val['pr_status'] == 'approved') {



                                            ?>



                                            <a href="<?php if ($this->user_auth->is_action_allowed('purchase', 'purchase_order', 'view')): ?><?php echo $this->config->item('base_url') . 'purchase_order/po_view/' . $val['id'] ?><?php endif ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('purchase', 'purchase_order', 'view')): ?>alerts<?php endif ?>" title="" data-original-title="PO-View" ><span class="fa fa-eye"></span></a>  <?php } ?>



                                    </td>



                                </tr>



                                <?php



                                $i++;



                            }



                        }



                        ?>



<!--                             <tr><td colspan="10">No data found...</td></tr>-->







                    </tbody>



                    <tfoot>



                        <tr>



                            <td class="text_right"></td>



                           <!-- <td class="text_right"></td>-->



                            <td class="text_right"></td>



                            <td class="text_right"></td>



                            <td class="text_right"></td>



                            <td class="action-btn-align total-bg"></td>



                          <!--  <td class="action-btn-align total-bg"></td>-->



                            <td class="text_right total-bg"></td>



                            <td class="text_right"></td>



                          <!--  <td class="text_right"></td>



                            <td class="text_right"></td>-->



                            <td class="hide_class text_right"></td>



                        </tr>



                    </tfoot>



                </table>



            </div>



            <div class="action-btn-align mb-10">



                <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>



            </div>



        </div>



        <?php



        if (isset($po) && !empty($po)) {



            foreach ($po as $val) {



                ?>







                <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">



                    <div class="modal-dialog">



                        <div class="modal-content modalcontent-top">



                            <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>



                                <h3 id="myModalLabel" class="inactivepop">In-Active user</h3>



                            </div>



                            <div class="modal-body">



                                Do You Want In-Active This Purchase Order?<strong><?= $val['po_no']; ?></strong>



                                <input type="hidden" value="<?php echo $val['id']; ?>" class="id" />



                            </div>



                            <div class="modal-footer action-btn-align">



                                <button class="btn btn-primary delete_yes" id="yesin">Yes</button>



                                <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no">No</button>



                            </div>



                        </div>



                    </div>



                </div>



                <?php



            }



        }



        ?>



    </div>



</div>



<script>



    $('.print_btn').click(function () {



        window.print();



    });



</script>



</div><!-- contentpanel -->







</div><!-- mainpanel -->



<script type="text/javascript">



    $(document).on('click', '.alerts', function () {



        sweetAlert("Oops...", "This Access is blocked!", "error");



        return false;



    });



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



            url: BASE_URL + "po/search_result",



            type: 'GET',



            data: {



                po: $('#po_no').val(),



                style: $('#style').val(),



                supplier: $('#supplier').val(),



                supplier_name: $('#supplier').find('option:selected').text(),



                from_date: $('#from_date').val(),



                to_date: $('#to_date').val()



            },



            success: function (result) {



                for_response();



                $('#result_div').html(result);



            }



        });



    });



</script>



<script type="text/javascript">



    $(document).ready(function ()



    {



        var table =$('#basicTable_call_back').DataTable({



            "lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],



            "pageLength": 50,



            "processing": true, //Feature control the processing indicator.



            "serverSide": true, //Feature control DataTables' server-side processing mode.



            "order": [], //Initial no order.



            //dom: 'Bfrtip',



            // Load data for the table's content from an Ajax source



            "ajax": {



                "url": "<?php echo site_url('purchase_order/purchase_order_ajaxList/'); ?>",



                "type": "POST",



            },



            //Set column definition initialisation properties.



            "columnDefs": [



                {



                    "targets": [0, 6], //first column / numbering column



                    "orderable": false, //set not orderable



                },



                {



                    "class": "text_center", "targets": [0,1,2]



                },



                {



                    "class": "action-btn-align", "targets": [3,4,5]



                },



                {



                    "class": "hide_class", "targets": [6]



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



                var cols = [4, 5];

                 symbol = " ";



               var numFormat = $.fn.dataTable.render.number('\,', '.', 2, symbol).display;

                for (x in cols) {



                    total = api.column(cols[x]).data().reduce(function (a, b) {



                        return (intVal(a) + intVal(b)).toFixed(2);



                    }, 0);







                    // Total over this page



                    pageTotal = api.column(cols[x], {page: 'current'}).data().reduce(function (a, b) {



                        return intVal(a) + intVal(b);



                    }, 0);







                    // Update footer

                    $(api.column(cols[x]).footer()).html(numFormat(pageTotal.toFixed(2)));

                    //$(api.column(cols[x]).footer()).html(pageTotal.toFixed(2));



                }











            },



            responsive: true,



            columnDefs: [



                {responsivePriority: 1, targets: 0},



                {responsivePriority: 2, targets: -2}



            ]



        });

         //new $.fn.dataTable.FixedHeader(table);





          /* var table = $('#basicTable_call_back').DataTable({

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

                var cols = [4, 5];

               // var numFormat = $.fn.dataTable.render.number('\,', '.', 2, var).display;

                 // var numFormat=$.fn.dataTable.render.number( ',', '.', 2 );

                  symbol = " ";

                  

                 // var numFormat = $.fn.dataTable.render.number(',', '.', 2, symbol).display();

               var numFormat = $.fn.dataTable.render.number('\,', '.', 2, symbol).display;//

                for (x in cols) {

                    total = api.column(cols[x]).data().reduce(function (a, b) {

                        return (intVal(a) + intVal(b)).toFixed(2);

                    }, 0);



                    // Total over this page

                    pageTotal = api.column(cols[x], {page: 'current'}).data().reduce(function (a, b) {

                        return intVal(a) + intVal(b);

                    }, 0);



                    // Update footer



                    $(api.column(cols[x]).footer()).html(numFormat(pageTotal.toFixed(2)));

                }





            },

            responsive: true,

            columnDefs: [

                {responsivePriority: 1, targets: 0},

                {responsivePriority: 2, targets: -2}

            ]

        });

       // new $.fn.dataTable.FixedHeader(table);*/



        $("#yesin").live("click", function ()



        {







            var hidin = $(this).parent().parent().find('.id').val();



            // alert(hidin);



            $.ajax({



                url: BASE_URL + "purchase_order/po_delete",



                type: 'POST',



                data: {value1: hidin},



                success: function (result) {







                    window.location.reload(BASE_URL + "purchase_order/purchase_order_list");



                }



            });







        });







        $('.modal').css("display", "none");



        $('.fade').css("display", "none");







    });



</script>



<script src="<?= $theme_path; ?>/js/fixedheader/jquery.dataTables.min.js"></script>