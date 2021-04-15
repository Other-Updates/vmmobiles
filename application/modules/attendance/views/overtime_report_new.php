<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>

<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>

<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>

<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />

<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>

<link rel="stylesheet" href="<?= $theme_path; ?>/css/bootstrap-multiselect.css" type="text/css"/>

<script type="text/javascript" src="<?= $theme_path; ?>/js/bootstrap-multiselect.js"></script>



<script type="text/javascript" src="<?= $theme_path; ?>/js/employee.js"></script>



<style type="text/css">
    .verticalTableHeader {text-align: center;transform: rotate(-90deg);/* position: absolute; *//* left: 78px; *//* height: 101px; *//* margin-bottom: 32px; *//* top: 105px; */width: 25px;/* white-space: nowrap; */}
    .verticalTableHeader1 {text-align: center;transform: rotate(-90deg);/* position: absolute; *//* left: 78px; *//* height: 101px; *//* margin-bottom: 32px; *//* top: 105px; */width: 25px;/* white-space: nowrap; */margin-bottom:6px;}


    @media print




    {

        @page{ size : letter landscape; max-width:100% !important;
               margin: 0;
               padding:0;
               margin: 1cm auto;}
        .print_table2 th, .print_table2 td { font-size:7px !important;}
    }



    .headerpanel



    {



        width:100%;



    }



    [class^="icon-"],[class*=" icon-"]{display:inline-block;width:12px;height:12px;}



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



    <?php
    $filter = array();

    $filter = $this->session_view->get_session(null, null);



    $attributes = array('class' => 'stdform editprofileform', 'method' => 'post');







    echo form_open('', $attributes);



    $s = $start_page + 1;
    ?>

    <div class="media mt--20">

        <h4>Overtime Reports</h4>

    </div>

</div>



<div class="contentpanel">

    <div class="panel-body mt-top5">

        <table class="table responsive_table table-bordered hide_class">



            <thead>



                <tr>





                    <th class="action-btn-align">Start Date <span class="req">*</span>&nbsp;



                        <?php
                        $default = '';



                        if (isset($start_date) && $start_date != "") {



                            $default = date("d-m-Y", strtotime($start_date));
                        }



                        $data = array(
                            'id' => 'start_date',
                            'name' => 'start_date',
                            'class' => 'input-small today-date',
                            'readonly' => 'readonly',
                            'value' => $default
                        );



                        echo form_input($data);
                        ?>



                    </th>



                    <th class="action-btn-align">To Date <span class="req">*</span>&nbsp;



                        <?php
                        $default = '';



                        if (isset($end_date) && $end_date != "") {



                            $default = date("d-m-Y", strtotime($end_date));
                        }



                        $data = array(
                            'id' => 'end_date',
                            'name' => 'end_date',
                            'class' => 'input-small today-date',
                            'readonly' => 'readonly',
                            'value' => $default
                        );



                        echo form_input($data);
                        ?>



                    </th>







                    <th>&nbsp;



                        <?php
                        $data = array(
                            'id' => 'overtime-search',
                            'name' => 'search',
                            'value' => 'Search',
                            'class' => 'btn btn-warning border4',
                            'title' => 'Search'
                        );







                        echo form_submit($data);
                        ?>



                    </th>



                    <th>



                        <a href="javascript:void(0)" style="float:right" title="Reset"><input type="button" class="btn btn-danger border4 reset" value="Reset"></a>



                    </th>



                </tr></thead>







        </table>





        <!--

        <?php
        $options = array();



        $this->load->model('options_model');



        $record = array(10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 120, 140, 160, 180, 200);



        $closest = $this->options_model->getClosest(count($no_of_users), $record);



//echo $closest;



        for ($k = 10; $k <= $closest;) {



            $options[$k] = $k;



            if ($k < 100)
                $k = $k + 10;
            else
                $k = $k + 20;
        }



        if (count($no_of_users) >= 1000) {



            $count_start = count($no_of_users) / 100;



            if ($count_start >= 10) {







                for ($c = 4; $c < $count_start;) {



                    $options[$c * 100] = $c * 100;



                    $c+=2;
                }
            }
        }



        if (!in_array($count, $options)) {



            $max = $this->options_model->getClosest($count, $options);



            if ($max < count($no_of_users))
                $count = "all";
            else
                $count = $max;
        }



        $options["all"] = "All";



        echo "<span class='hide_show'>Show " . form_dropdown('record_show', $options, $count, "id='count_change'") . " entries</span>";
        ?>



                <div class="button_right_align" style="float:right;">



                    NA - Not Applicable, &nbsp;I - Inactive Status



                </div>



                <table class="table table-bordered wage_res"  >







                    <tr>



                        <td>Name of the Company : <strong><?php if (isset($company_name) && $company_name != "") echo $company_name; ?></strong></td>



                        <td>Place : <strong><?php if (isset($place) && $place != "") echo $place; ?></strong></td>



                        <td>District : <strong><?php if (isset($district) && $district != "") echo $district; ?></strong></td>



                        <td>Holidays : <strong>Sunday</strong></td>



                        <td colspan="4">Month of <strong><?php
        $month_arr = array("Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec");







        echo $month_arr[$month - 1] . " " . $year;
        ?></strong></td>



                    </tr>



                </table>-->



        <br>



        <?php
        $s_date = date('d-m-Y', strtotime($start_date));



        $std_dt = $end_date . " 00:00:00";



        $exclude_date = new DateTime($std_dt . ' +1 day');



        $e_date = $exclude_date->format('d-m-Y');







        $start = new DateTime($s_date . ' 00:00:00');



//Create a DateTime representation of the last day of the current month based off of "now"



        $end = new DateTime($e_date . ' 00:00:00');



//Define our interval (1 Day)



        $interval = new DateInterval('P1D');



//Setup a DatePeriod instance to iterate between the start and end date by the interval



        $period = new DatePeriod($start, $interval, $end);







        foreach ($period as $date) {



            //Make sure the day displayed is ONLY sunday.



            $days_array[] = $date->format('d-m-Y');
        }
        ?>
        <div class="auto-scroll" id="remove_scroll_class">
            <table class="table table-bordered print_table2 print_border" style="font-size:10px;">
                <thead>
                    <tr>
                        <th rowspan="2"><div class="verticalTableHeader1">S.No&nbsp;</div></th>
                        <th rowspan="2"><div class="verticalTableHeader1">Employee&nbsp;ID&nbsp;</div></th>
                        <th rowspan="2"><div class="verticalTableHeader1">Name&nbsp;of&nbsp;the&nbsp;Worker&nbsp;</div></th>
                        <th rowspan="2"><div class="verticalTableHeader1">Department&nbsp;</div></th>
                        <th rowspan="2"><div class="verticalTableHeader1">Designation&nbsp;</div></th>
                        <th style="text-align: center;" colspan="<?= count($days_array) ?>">Wages Period / Hours of Over Time</th>
                        <th rowspan="2" style="height:120px;text-align: -webkit-center;"><div class="verticalTableHeader">Total&nbsp;Hour&nbsp;of&nbsp;overtime<br>work&nbsp;perfomed</div></th>
                        <th rowspan="2"><div class="verticalTableHeader1">&nbsp;Late&nbsp;MTD&nbsp;</div></th>
                        <th rowspan="2"><div class="verticalTableHeader1">&nbsp;EarlyGoing&nbsp;MTD&nbsp;</div></th>
 <!--  <th rowspan="2">Normal Rate/ Hour(Rs)</th>



                        <th rowspan="2">Wages for over time<br>work (Double)</th>



                        <?php if ($proceed == 0) { ?>



                                                            <th rowspan="2">Net Amount Paid</th>



                                                            <th rowspan="2">Signature of the employee</th>



                        <?php } ?>-->
                    </tr>
                    <tr>

                        <?php for ($d = 0; $d <= count($days_array) - 1; $d++) {
                            ?>



                            <th><?php
                                $current_day = explode("-", $days_array[$d]);



                                $jd = gregoriantojd($current_day[1], $current_day[0], $current_day[2]);

                                $m_name = jdmonthname($jd, 0);



                                echo $m_name . " " . $current_day[0];
                                ?></th>



                        <?php } ?>



                    </tr>



                </thead>



                <tbody>

                    <?php
                    if (!empty($over_reports)) {

                        foreach ($over_reports as $key => $report_data) {
                            ?>

                            <tr>

                                <td><?php echo $key + 1; ?></td>

                                <td><?php echo $report_data['employee_id']; ?></td>

                                <td><?php echo $report_data['username']; ?></td>

                                <td><?php echo $report_data['department']; ?></td>

                                <td><?php echo $report_data['designation']; ?></td>



                                <?php foreach ($report_data['over_time_works'] as $key1 => $over_data) { ?>

                                    <td><?php echo $over_data['over_time']; ?></td>

                                <?php } ?>

                                <td><?php echo $report_data['over_time_add']; ?></td>
                                <?php
                                if ($report_data['early_going'] == 0) {
                                    $report_data['early_going'] = '-';
                                } if ($report_data['late_by'] == 0) {
                                    $report_data['late_by'] = '-';
                                }
                                ?>
                                <td><?php echo $report_data['late_by']; ?></td>
                                <td><?php echo $report_data['early_going']; ?></td>

                            </tr>

                            <?php
                        }
                    } else {
                        ?>

                        <tr><td colspan="7">No Results Found</td></tr>

                    <?php } ?>

                </tbody>



            </table>



        </div>





        <div class="button_right_align">



            <div class="action-btn-align">



                <a href="#" id="print" class="btn btn-defaultprint6  print-align print_btn"><i class="glyphicon glyphicon-print"></i> Print</a>

            </div>



        </div>





        <?php
        if (isset($users) && !empty($users)) {







            $end = $start_page + count($users);







            $start_page = $start_page + 1;
            ?>



            <span class="no-display hide_class">Showing <?= $start_page ?> to <?= $end ?> of <?= count($no_of_users) ?> records </span>



        <?php } ?>



        <!-- <input type="hidden" id="week_starting_day" value="<?= $week_starting_day ?>"/>



        <input type="hidden" id="month_starting_date" value="<?= $month_starting_date ?>"/>



        <div class="button_right_align">



        <?php
        if (isset($links) && $links != NULL)
            echo $links;
        ?>



            <a href="#" id="print" class="btn btn-warning btn-rounded print-align" style="margin-left:50%;"><span class="glyphicon glyphicon-print"></span>Print</a>



        </div>-->







    </div>



</div><!--contentinner-->









<script type="text/javascript">



    $(document).ready(function () {



        user_val = "<?= $user_type ?>";



        if (user_val == 2)



        {



            $("#date_th").hide();



        }

        $(".reset").click(function () {



            $.ajax({
                url: BASE_URL + "api/reset_session/",
                type: "POST",
                data: {class: ct_class, method: ct_method},
                success: function (res)



                {



                    window.location = window.location.pathname;



                }



            });

        });

        $("#attendance-search").click(function () {



            var start_date = $("#start_date").val();

            var end_date = $("#end_date").val();



            if (start_date == '')

            {

                alert("Please select start date");

                return false;

            }







        });

    });
    window.onafterprint = afterPrint;
    function afterPrint()
    {
        $('#remove_scroll_class').addClass("auto-scroll");
    }

    $('.print_btn').click(function () {

        $('#remove_scroll_class').removeClass("auto-scroll");
        window.print();

    });


</script>