<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path ?>/js/attendance_reports.js"></script>

<link href="<?php echo $theme_path; ?>/css/print_page.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $theme_path ?>/css/bootstrap-multiselect.css" type="text/css"/>
<script type="text/javascript" src="<?php echo $theme_path ?>/js/jquery.MultiFile.js"></script>
<script type="text/javascript" src="<?php echo $theme_path ?>/js/bootstrap-multiselect.js"></script>
<style type="text/css">
@media print {
	.final_cl,.final_cl1{position: relative;left: 1px;line-height:10px;}
	 @page{ size :landscape;padding:0;margin: 0; margin: 1cm auto;}	 
}
.verticalTableHeader {text-align: center;transform: rotate(-90deg);/* position: absolute; *//* left: 78px; *//* height: 101px; *//* margin-bottom: 32px; *//* top: 105px; */width: 25px;/* white-space: nowrap; */}
.headerpanel{width:100%;}
.leftmenu{height:728px;}
.right-content{padding-left:220px;}
.mtop{margin-top:15px;}
</style>
<script>
    $(document).ready(function ()
    {
        $('#excel_report').on('click', function ()
        {
//            var arr = [];
//            arr.push({'department': $('#department_select')});
//            arr.push({'designation': $('#designation_select').val()});
//            arr.push({'user_type': $('#user_type').val()});
//            arr.push({'year': $('#year_select').val()});
//            arr.push({'month': $('#month_select').val()});
//            arr.push({'week': $('#date_select').val()});
//            var arrStr = JSON.stringify(arr);

            window.location.replace('<?php echo $this->config->item('base_url') . 'attendance/reports/excel_report' ?>');
            return false;
        });
    });
</script>
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
		
    $filter = $this->session_view->get_session(null, null);
//    $this->pre_print->view($filter);

    $attributes = array('class' => 'stdform editprofileform', 'method' => 'post');

    echo form_open('', $attributes);
    ?>
    <div class="mt--20" >
        <h4 class="widgettitle mtop">Attendance Reports</h4>
    </div>
    <!--<div class="well">-->
    <div class="panel-body mt-top5 hide_class">
        <table class="table responsive_table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="basicTable_call_back">

            <thead>

                <tr>

                    <th class="action-btn-align">Department &nbsp; <?php
                        $options = array();

                        $default = '';

                        if (isset($filter["department"]) && !empty($filter["department"])) {

                            $default = $filter["department"];
                        }

                        if (isset($departments) && !empty($departments)) {

                            foreach ($departments as $dept) {

                                $options[$dept["dept_id"]] = $dept["dept_name"];
                            }
                        }

                        echo form_multiselect('department[]', $options, $default, 'class="multiselect" id="department_select"');
                        ?></th>

                    <th class="action-btn-align">Designation &nbsp;<?php
                        $default = '';

                        if (isset($filter["designation"]) && !empty($filter["designation"])) {

                            $default = $filter["designation"];
                        }

                        $options = array();

                        if (isset($designations) && !empty($designations)) {

                            foreach ($designations as $des) {

                                $options[$des["id"]] = $des["name"];
                            }
                        }

                        echo form_multiselect('designation[]', $options, $default, 'class="multiselect" id="designation_select"');
                        ?></th>

                    <th class="action-btn-align">User Type&nbsp; <?php
                        $options = array('' => "Select", 1 => "Weekly", 2 => "Monthly");

                        $default = $user_type;

                        echo form_dropdown('user_type', $options, $default, 'id="user_type" class="uniformselect user_type"');
                        ?>

                    </th>

                    <th class="action-btn-align" >Year &nbsp;<?php
                        $options = array('' => 'Select Year');



                        for ($i = 2000; $i <= date('Y'); $i++) {

                            $options[$i] = $i;
                        }

                        echo form_dropdown('year', $options, $year, 'id="year_select" class="input-small"');
                        ?></th>

                    <th class="action-btn-align" >Month &nbsp;<?php
                        $options = array('' => 'Select Month');

                        $month_arr = array("Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec");

                        $default = $month;

                        //echo $default;

                        if ($year == date('Y')) {



                            for ($i = 0; $i < date('m'); $i++)
                                $options[$i + 1] = $month_arr[$i];
                        } else {

                            for ($i = 0; $i < 12; $i++) {

                                $options[$i + 1] = $month_arr[$i];
                            }
                        }

                        //$options[$default] = $month_arr[$default-1];

                        echo form_dropdown('month', $options, $default, 'id="month_select" class="input-small"');
                        ?></th>
                  <!--  <th>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">From Date</label>
                                <input type="text" id='from_date_atten'  class="form-control datepicker" name="from_date_picker" value="<?php echo(!empty($from_date_picker) ? date('d-m-Y', strtotime($from_date_picker)) : date('d-m-Y')); ?>" placeholder="dd-mm-yyyy" >
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">To Date</label>
                                <input type="text"  id='to_date_atten' class="form-control datepicker" name="to_date_picker" value="<?php echo(!empty($to_date_picker) ? date('d-m-Y', strtotime($to_date_picker)) : date('d-m-Y')); ?>"   placeholder="dd-mm-yyyy" >
                            </div>
                        </div>
                    </th>-->

            <input type="hidden" name="start_date" id="start_date" value="<?= $start_date ?>">

            <input type="hidden" name="end_date" id="end_date" value="<?= $end_date ?>">

            <th id="date_th">Week &nbsp;

                <?php
// echo $week_starting_day;

                $filter_start = $start_date;

                $filter_end = $end_date;

                $default = "";

                if (isset($filter['date']))
                    $default = $filter["date"];

//echo $default;

                $starting_day = array();
                $day = $month_starting_date;
                $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);

                $start_d = $year . "-" . $month . "-1";

                $end = ($year) . "-" . $month . "-" . ($days_in_month);

                $start_date = date('d-m-Y', strtotime($start_d));

                $end_date = date('d-m-Y', strtotime($end));

                $std_dt1 = $end_date . " 00:00:00";

                $exclude_date1 = new DateTime($std_dt1 . ' +1 day');

                $e_date1 = $exclude_date1->format('d-m-Y');

                $start = new DateTime($start_date . ' 00:00:00');
//Create a DateTime representation of the last day of the current month based off of "now"

                $end = new DateTime($e_date1 . ' 00:00:00');

//Define our interval (1 Day)

                $interval = new DateInterval('P1D');

//Setup a DatePeriod instance to iterate between the start and end date by the interval

                $period = new DatePeriod($start, $interval, $end);



//Iterate over the DatePeriod instance

                $sunday = array();

                foreach ($period as $date) {

                    //Make sure the day displayed is ONLY sunday.

                    if ($date->format('w') == $week_starting_day) {

                        $starting_day[] = $date->format('d-m-Y') . PHP_EOL;
                    }
                }

                $options = array();

                if (isset($starting_day) && !empty($starting_day)) {

                    if ($year == date('Y')) {

                        if ($month == date('m')) {

                            foreach ($starting_day as $st) {

                                $next_date1 = date("Y-m-d", strtotime($st)) . " 00:00:00";

                                $next_date2 = new DateTime($next_date1);

                                if ($next_date2->format('d') < date('d'))
                                    $options[ltrim(date('d', strtotime($st)), 0)] = date('d-M', strtotime($st));
                            }
                        }

                        else {



                            foreach ($starting_day as $st) {

                                if (strtotime($st) < strtotime(date("d-m-Y"))) {

                                    $options[ltrim(date('d', strtotime($st)), 0)] = date('d-M', strtotime($st));
                                }
                            }
                        }
                    } else {

                        foreach ($starting_day as $st) {

                            $options[ltrim(date('d', strtotime($st)), 0)] = date('d-M', strtotime($st));
                        }
                    }
                }





                echo form_multiselect('date[]', $options, $default, 'id="date_select" class="multiselect"');
                ?>



            <th class="res_div"><input type="submit" name="go" value="  Go  " id="go" class="btn btn-info border4"></th>

            <th>

                <a href="javascript:void(0)" style="float:right" title="Reset"><input type="button" class="btn btn-danger border4 reset" value="Reset" ></a>

            </th>

            </tr></thead>



        </table>

    </div>
    <div class="panel-body mt-top5  mt--20 mtop ">
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

        //echo $no_of_users1[0]['count'];

        echo "<span class='hide_show'>Show " . form_dropdown('record_show', $options, $count, "id='count_change'") . " entries</span>";
        ?>

        <div class="button_right_align  mt--20 mtop">

            <strong>NA</strong> - Not Applicable, &nbsp; <strong>P</strong> - Permission, &nbsp; <strong>SL</strong> - Sick Leave, &nbsp; <strong>CL</strong> - Casual Leave, &nbsp; <strong>EL</strong> - Earned Leave, &nbsp; <strong>LOP</strong> - Loss of Pay, &nbsp; <strong>OD</strong> - On-duty, &nbsp; <strong>C</strong> - Compoff, &nbsp; <strong>PH</strong> - Public Holiday, &nbsp; <strong>I</strong> - Inactive Status

        </div>


<br />
        <table class="tit-bg-gray table table-bordered text-center wage_res">

            <tr>

                <td>Name of the Company : <strong><?php if (isset($company_name) && $company_name != "") echo $company_name; ?></strong></td>

                <td>Place : <strong><?php if (isset($place) && $place != "") echo $place; ?></strong></td>

                <td>District : <strong><?php if (isset($district) && $district != "") echo $district; ?></strong></td>

                <td>Holidays : <strong>Sunday<?php
                        if (isset($saturday_holiday) && $saturday_holiday == 1)
                            echo " , Saturday";
                        echo ", PH-Public Holidays";
//                        echo $month_arr;
//                        exit;
                        ?></strong></td>

                <td colspan="4">Month of <strong><?php
                        $month_arr = array("Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec");

                        echo $month_arr[$month - 1] . " " . $year;
                        ?></strong></td>

            </tr>



        </table>

    

        <?php 
        $this->load->model('masters/shift_model');

        $this->load->model('masters/user_shift_model');

        $this->load->model('masters/salary_group_model');

        if (isset($saturday_holiday) && $saturday_holiday == 0)
            $week_days = 6;
        else
            $week_days = 5;

        $this->load->model("attendance_model");

        $month_start = new DateTime(date('d-m-Y', strtotime($filter_start)) . " 00:00:00");

        $month_end = new DateTime(date('d-m-Y', strtotime($filter_end)) . " 00:00:00");

        $s_date = date('d-m-Y', strtotime($filter_start));

        $std_dt = $filter_end . " 00:00:00";

        $exclude_date = new DateTime($std_dt . ' +1 day');

        $e_date = $exclude_date->format('d-m-Y');



        $start = new DateTime($s_date . ' 00:00:00');

//Create a DateTime representation of the last day of the current month based off of "now"

        $end = new DateTime($e_date . ' 00:00:00');



        $attd_end_date = $end->format('d-m-Y');

        $date = new DateTime(date('d-m-Y') . " 00:00:00" . ' +1 day');


        $cur_date = date('d-m-Y', (strtotime($date->format('d-m-Y'))));

        if (strtotime($cur_date) <= strtotime($attd_end_date)) {

            $end = new DateTime($cur_date . ' 00:00:00');
        }



//Define our interval (1 Day)

        $interval = new DateInterval('P1D');

//Setup a DatePeriod instance to iterate between the start and end date by the interval

        $period = new DatePeriod($start, $interval, $end);


//Iterate over the DatePeriod instance

        $sunday = array();

        foreach ($period as $date) {

            //Make sure the day displayed is ONLY sunday.

            $days_array[] = $date->format('d-m-Y');
        }

        $proceed = 0;

//Define our interval (1 Day)

        $interval = new DateInterval('P1D');



//Setup a DatePeriod instance to iterate between the start and end date by the interval

        $period = new DatePeriod($month_start, $interval, $month_end);

//Iterate over the DatePeriod instance

        $sunday = array();

        foreach ($period as $date) {

            //Make sure the day displayed is ONLY sunday.

            if ($date->format('w') == 0) {

                $sunday[] = $date->format('d-m-Y') . PHP_EOL;
            }

            //Checking saturday is a  Saturday holiday

            if (isset($saturday_holiday) && $saturday_holiday == 1) {

                if ($date->format('w') == 6) {

                    $sunday[] = $date->format('d-m-Y') . PHP_EOL;
                }
            }
        } 
        ?>

        <div class="">

            <table class="table table-bordered print_table print_border"  style="font-size:12px;">

                <thead>

                    <tr>

                        <th rowspan="3" style=""><div class="final_cl1"> &nbsp;S.No&nbsp;</div></th>

                        <th rowspan="3" class="text-center">Employee<br />ID</th>

                        <th rowspan="3">Employee<br />Name</th>

                        <th rowspan="3">Department</th>

                        <th rowspan="3">Designation</th>

                        <?php for ($d = 0; $d <= count($days_array) - 1; $d++) { ?>

                            <th rowspan="3" class="text-center"><?php
                                $current_day = explode("-", $days_array[$d]);

                                echo $current_day[0];
                                ?></th>

                        <?php } ?>

                        <th rowspan="3" style="height:120px;text-align: -webkit-center;"><div class="final_cl verticalTableHeader">No.of&nbsp;days&nbsp;worked during&nbsp;the&nbsp;<?php
                                if ($filter["user_type"] == 1)
                                    echo "week(s)";
                                else
                                    echo "month";
                                ?></div></th>

                        <th  rowspan="3" style="height:120px;text-align: -webkit-center;"><div class="verticalTableHeader">Compoff&nbsp;days worked</div></th>
                        <th  rowspan="3" class="hide_class" style="text-align:center;" ><div>Detailed<br />Report</div></th>
                    </tr>
                </thead>
                <tbody>

                    <?php 
                    //print_r($attendance);

                    $s = $start_page + 1;

                    if (isset($attendance) && !empty($attendance))
                        $result = array_filter($attendance);

                    //if(isset($result)&& !empty($result)){

                    if (isset($users) && !empty($users)):



                        for ($k = 0; $k < count($users); $k++) {

                            $no_of_ot_hours = 0;

                            $comp_off_ot_hours = 0;

                            $user_overtime = 0;

                            $att = array(0);

                            $da = 0;

                            $total_all = 0;

                            $total_dedu = 0;

                            $user_salary = array();



                            if (isset($attendance[$k]) && !empty($attendance[$k])) {

                                //$this->pre_print->view($attendance[$k]);

                                foreach ($attendance[$k] as $am) {

                                    if ($am["in"] != "00:00:00")
                                        $att[$am["attendance_date"]] = $am;
                                }
                            }

                          
				
                            $leave_arr = array();

                            if (isset($leave[$k]) && !empty($leave[$k])) {

							
                                foreach ($leave[$k] as $lval) {

                                    $current_shift_id = $this->user_shift_model->get_user_current_shift_by_user_id($users[$k]["id"], $lval["l_from"]);



                                    $current_shift = $this->shift_model->get_shift_regular_time_by_shift_id($current_shift_id[0]["shift_id"]);

                                    $start_hour = strtotime($current_shift[0]["from_time"]);

                                    $end_hour = strtotime($current_shift[0]["to_time"]);



                                    if ($lval["l_from"] == $lval["l_to"]) {

                                        if ($start_hour >= $end_hour) {



                                            $sdt = date("H:i", strtotime($lval["leave_from"]));

                                            $edt = date("H:i", strtotime($lval["leave_to"]));



                                            if (strtotime("00:00") < strtotime($sdt) && (strtotime($edt) < $end_hour)) {

                                                $previous = date('Y-m-d', strtotime($lval["l_from"] . ' -1 day'));

                                                $leave_arr[date('d-m-Y', strtotime($previous))] = $lval;
                                            } else
                                                $leave_arr[$lval["l_from"]] = $lval;
                                        } else
                                            $leave_arr[$lval["l_from"]] = $lval;
                                    }

                                    else if ($lval["type"] == "permission") {

                                        //$leave_arr[$lval["l_from"]] = $lval;

                                        if ($start_hour >= $end_hour) {



                                            $sdt = date("H:i", strtotime($lval["leave_from"]));

                                            $edt = date("H:i", strtotime($lval["leave_to"]));



                                            if (strtotime("00:00") < strtotime($sdt) && (strtotime($edt) < $end_hour)) {

                                                $previous = date('Y-m-d', strtotime($lval["l_from"] . ' -1 day'));



                                                $leave_arr[date('d-m-Y', strtotime($previous))] = $lval;
                                            } else
                                                $leave_arr[$lval["l_from"]] = $lval;
                                        } else
                                            $leave_arr[$lval["l_from"]] = $lval;
                                    }

                                    else {



                                        $start = $lval["l_from"];

                                        $std_dt = date('Y-m-d', strtotime($lval["l_to"]));

                                        $end_current = new DateTime($lval["l_to"] . ' 00:00:00');

                                        $exclude_date = new DateTime($std_dt . ' +1 day');

                                        $end = $exclude_date->format('d-m-Y');

                                        $start = new DateTime($start . ' 00:00:00');

                                        //Create a DateTime representation of the last day of the current month based off of "now"

                                        $end = new DateTime($end . ' 00:00:00');

                                        $interval_od = dateTimeDiff($start, $end_current);

                                        if ($lval["type"] == "on-duty") {



                                            if ($start_hour >= $end_hour) {

                                                //Define our interval (1 Day)



                                                $interval = new DateInterval('P1D');

                                                //Setup a DatePeriod instance to iterate between the start and end date by the interval

                                                $period = new DatePeriod($start, $interval, $end_current);



                                                //Iterate over the DatePeriod instance

                                                $lval["shift"] = "night";



                                                foreach ($period as $date) {

                                                    //Make sure the day displayed is ONLY sunday.



                                                    $leave_arr[$date->format('d-m-Y')] = $lval;
                                                }
                                            } else {



                                                $interval = new DateInterval('P1D');

                                                //Setup a DatePeriod instance to iterate between the start and end date by the interval

                                                $period = new DatePeriod($start, $interval, $end);

                                                $lval["shift"] = "day";

                                                //Iterate over the DatePeriod instance



                                                foreach ($period as $date) {

                                                    //Make sure the day displayed is ONLY sunday.



                                                    $leave_arr[$date->format('d-m-Y')] = $lval;
                                                }
                                            }
                                        } else {

                                            //Define our interval (1 Day)

                                            $interval = new DateInterval('P1D');

                                            //Setup a DatePeriod instance to iterate between the start and end date by the interval

                                            $period = new DatePeriod($start, $interval, $end);



                                            //Iterate over the DatePeriod instance



                                            foreach ($period as $date) {

                                                //Make sure the day displayed is ONLY sunday.



                                                $leave_arr[$date->format('d-m-Y')] = $lval;
                                            }
                                        }
                                    }
                                }
                            }



                            //$this->pre_print->view($leave_arr);

                            $holi_arr = array();

                            if (isset($holiday[$k]) && !empty($holiday[$k])) {

                                foreach ($holiday[$k] as $hval) {

                                    if ($hval["holiday_from"] == $hval["holiday_to"]) {

                                        //$holi_arr[$hval["h_from"]] = $hval;

                                        $hol_val = date('l', strtotime($hval["holiday_from"]));

                                        if ($hol_val == "Sunday" || $hol_val == "Saturday") {

                                            if (isset($saturday_holiday) && $saturday_holiday != 1)
                                                $holi_arr[$hval["h_from"]] = $hval;
                                        } else
                                            $holi_arr[$hval["h_from"]] = $hval;
                                    }

                                    else {

                                        $start = $hval["h_from"];

                                        $std_dt = date('Y-m-d', strtotime($hval["h_to"]));

                                        $exclude_date = new DateTime($std_dt . ' +1 day');

                                        $end = $exclude_date->format('d-m-Y');

                                        $start = new DateTime($std_dt . ' 00:00:00');

                                        //Create a DateTime representation of the last day of the current month based off of "now"

                                        $end = new DateTime($end . ' 00:00:00');

                                        //Define our interval (1 Day)

                                        $interval = new DateInterval('P1D');

                                        //Setup a DatePeriod instance to iterate between the start and end date by the interval

                                        $period = new DatePeriod($start, $interval, $end);



                                        //Iterate over the DatePeriod instance

                                        $sunday = array();

                                        foreach ($period as $date) {

                                            $hol_val = date('l', strtotime($date->format('d-m-Y')));

                                            if ($hol_val == "Sunday" || $hol_val == "Saturday") {

                                                if (isset($saturday_holiday) && $saturday_holiday != 1)
                                                    $holi_arr[$hval["h_from"]] = $hval;
                                            } else
                                                $holi_arr[$hval["h_from"]] = $hval;

                                            //Make sure the day displayed is ONLY sunday.

                                            $holi_arr[$date->format('d-m-Y')] = $hval;
                                        }
                                    }
                                }
                            }

                            //echo "<pre>";



                            $lop_days = 0;

                            $comp_off_days = 0;

                            $days_with_salary = 0;

                            $total_ot_earned = 0;

                            $total_compoff_ot_earned = 0;

                            $earned = 0;

                            $ot_all = 0;
                            


                            $key_id = array("EMP-1", "EMP-2", "EMP-3", "EMP-4","EMP-15");
if (!in_array($users[$k]['employee_id'], $key_id)) {  ?>
                            <tr>

                                <td class="text-center"><?= $s++ ?></td>

                                <td class="text-center"><?= $users[$k]['employee_id'] ?></td>

                                <td><?= $users[$k]['first_name'] ?></td>

                                <td><?= ucwords($users[$k]['dept_name']) ?></td>

                                <td><?= ucwords($users[$k]['des_name']) ?></td>

                                <?php
                                for ($n = 0; $n <= count($days_array) - 1; $n++) {



                                    $current_day = explode("-", $days_array[$n]);



                                    $working_days = count($days_array) - (count($sunday) + count($holi_arr));

                                    $day_value = $days_array[$n];

                                    $current = $current_day[0];

                                    //echo $day_value;

                                    if (isset($users[$k]["dol"]) && strtotime($day_value) > strtotime($users[$k]["dol"]))
                                        echo "<td  class='text-center'>I</td>";

                                    else {

                                        $start_time = 0;

                                        $regular_time = 0;

                                        $regular_time_val = 0;

                                        $breaktimediff = 0;

                                        $date_end = 0;

                                        $end_time = 0;

                                        $leave_taken = 0;

                                        $half_regular = 0;

                                        $full_day_od = 0;

                                        $duty_hours = 0;



                                        $on_duty = 0;

                                        $current_shift_id = $this->user_shift_model->get_user_current_shift_by_user_id($users[$k]["id"], $day_value);

                                        //echo "<pre>";
                                        //print_r($current_shift_id);
                                        //exit;
                                        //print_r($current_shift_id);

                                        $shift = $this->shift_model->get_shift_details_by_shift_id($current_shift_id[0]["shift_id"]);
                                      

                                        $salary = $this->user_salary_model->get_user_salary_by_user_id($users[$k]["id"], $day_value);


                                        if (isset($shift) && !empty($shift)) {

                                            foreach ($shift as $sh) {

                                                if ($sh["type"] == "overtimestart") {


                                                    $overtimestart = $sh["from_time"];

                                                    $overtimeend = $sh["to_time"];
                                                } else {

                                                    if ($sh["type"] == "regular") {

                                                        $reg_st = explode(':', $sh["from_time"]);

                                                        $reg_et = explode(':', $sh["to_time"]);

                                                        if ($reg_st[0] > $reg_et[0]) {

                                                            $next_day = new DateTime(date('d-m-Y H:i:s') . ' + 1 day');

                                                            $date_start = new DateTime(date('d-m-Y') . " " . $sh["from_time"]);

                                                            $date_end = new DateTime($next_day->format('d-m-Y') . " " . $sh["to_time"]);
                                                        } else {

                                                            $date_start = new DateTime(date('d-m-Y') . " " . $sh["from_time"]);

                                                            $date_end = new DateTime(date('d-m-Y') . " " . $sh["to_time"]);
                                                        }



                                                        $start_time = $sh["from_time"];

                                                        $end_time = $sh["to_time"];

                                                        //print_r($date8);

                                                        $regular_time = dateTimeDiff($date_start, $date_end);
                                                    } else {

                                                        $reg_st = explode(':', $sh["from_time"]);

                                                        $reg_et = explode(':', $sh["to_time"]);

                                                        if ($reg_st[0] > $reg_et[0]) {

                                                            $next_day = new DateTime(date('d-m-Y H:i:s') . ' + 1 day');

                                                            $break_st = new DateTime(date('d-m-Y') . " " . $sh["from_time"]);

                                                            $break_end = new DateTime($next_day->format('d-m-Y') . " " . $sh["to_time"]);
                                                        } else {

                                                            $break_st = new DateTime(date('d-m-Y') . " " . $sh["from_time"]);

                                                            $break_end = new DateTime(date('d-m-Y') . " " . $sh["to_time"]);
                                                        }


												
                                                        $inter = dateTimeDiff($break_st, $break_end);

                                                        if ($inter->h > 0) {

                                                            $breaktimediff = $breaktimediff + ($inter->h) * 60;
                                                        }

                                                        if ($inter->i > 0) {

                                                            $breaktimediff = $breaktimediff + ($inter->i);
                                                        }

                                                        if ($interval->s > 0) {

                                                            $breaktimediff = $breaktimediff + ($interval->s / 60);
                                                        }
                                                    }
                                                }
                                            }
										
											 if($breaktimediff==60)
											 {
												 $breaktimediff=120;
											 }
											// if($threshold[0]['value']==15)
											// {
												// $threshold[0]['value']=$threshold[0]['value'];
											// }
											// echo "<pre>";
										
											// print_r($regular_time->h);
											// echo "<br>";
											// print_r($regular_time->i);
												// echo "<br>";
											// print_r($breaktimediff);
											// echo "<br>";
											// print_r($threshold[0]['value']);
                                            $regular_time_val = $regular_time->h * 60 + $regular_time->i - $breaktimediff - $threshold[0]['value']-60;

                                            $half_regular = $regular_time_val / 2;
											//echo "<pre>";print_r($half_regular);
                                            $res = explode(':', $start_time);

                                            $shift_start_time = $res[0] * 60 + $res[1] + $threshold[0]['value'];

                                            if (isset($res[2]) && $res[2] > 0)
                                                $shift_start_time = $shift_start_time + ($res[2] / 60);



                                            $yes = 0;

                                            $total_break = 0;

                                            $time_taken = 0;

                                            $break = array();

                                            $difference = "";

                                            $permission_hrs = 0;

                                            $half_day = 0;





                                            $sun = date('l', strtotime($day_value));

                                            //echo $sun;

                                            if (isset($att[$current]) && !empty($att[$current])) {

                                                $user_in = explode(':', $att[$current]['in']); // user in time

                                                $shift_start = explode(':', $start_time); // shift start time

                                                $calc = explode(':', $att[$current]['out']); // user out time

                                                $end = explode(':', $end_time); // shift end time



                                                $start_shift = ( $shift_start[0] - 1) . ":" . $shift_start[1];

                                                $user_in_start = $user_in[0] . ":" . $user_in[1];

                                                $end_shift = ($end[0] + 1) . ":" . $end[1];

                                                $check1 = DateTime::createFromFormat('H:i', $user_in_start);

                                                $check2 = DateTime::createFromFormat('H:i', $start_shift);



                                                if ($shift_start[0] > $end[0]) {

                                                    $next_day = new DateTime(date('d-m-Y H:i:s') . ' + 1 day');

                                                    $check3 = new DateTime($next_day->format('d-m-Y') . " " . $end_shift);
                                                } else {

                                                    $check3 = DateTime::createFromFormat('H:i', $end_shift);
                                                }

                                                if (!($check1 > $check2 && $check1 < $check3)) {

                                                    unset($att[$current]);
                                                }
                                            }

                                            if (isset($att[$day_value]) && !empty($att[$day_value])) {





                                                $user_in = explode(':', $att[$day_value]['in']); // user in time

                                                $shift_start = explode(':', $start_time); // shift start time

                                                $calc = explode(':', $att[$day_value]['out']); // user out time

                                                $end = explode(':', $end_time); // shift end time
                                                //print_r($calc);
                                                //echo $att[$n]["in"]."shift time".$start_time." <br>";

                                                $in_start = new DateTime(date('Y-m-d') . $att[$day_value]['in']);



                                                if ($calc[0] < $end[0]) {

                                                    if ($user_in[0] > $calc[0]) {

                                                        $next_day = new DateTime(date('d-m-Y H:i:s') . ' + 1 day');

                                                        $in_end = new DateTime($next_day->format('d-m-Y') . " " . $att[$day_value]['out']);
                                                    } else {

                                                        $in_end = new DateTime(date('Y-m-d') . $att[$day_value]['out']);
                                                    }
                                                } elseif ($calc[0] > $end[0]) {

                                                    //echo $end_time;

                                                    if ($user_in[0] > $calc[0]) {

                                                        $next_day = new DateTime(date('d-m-Y H:i:s') . ' + 1 day');

                                                        $in_end = new DateTime($next_day->format('d-m-Y') . " " . $end_time);
                                                    } else {

                                                        $in_end = new DateTime(date('Y-m-d') . $end_time);
                                                    }
                                                } elseif ($calc[0] == $end[0] && $calc[1] > $end[1]) {

                                                    if ($user_in[0] > $calc[0]) {

                                                        $next_day = new DateTime(date('d-m-Y H:i:s') . ' + 1 day');

                                                        $in_end = new DateTime($next_day->format('d-m-Y') . " " . $end_time);
                                                    } else {

                                                        $in_end = new DateTime(date('Y-m-d') . $end_time);
                                                    }
                                                } else {

                                                    if ($user_in[0] > $calc[0]) {

                                                        $next_day = new DateTime(date('d-m-Y H:i:s') . ' + 1 day');

                                                        $in_end = new DateTime($next_day->format('d-m-Y') . " " . $end_time);
                                                    } else {

                                                        $in_end = new DateTime(date('Y-m-d') . $end_time);
                                                    }
                                                }



                                                $in_interval = dateTimeDiff($in_start, $in_end);

                                                $break = $this->attendance_model->get_break_details_by_attendance_id($att[$day_value]["id"]);

                                                if (isset($break) && !empty($break)) {

                                                    foreach ($break as $br) {



                                                        if ($br["in_time"] != "00:00:00") {

                                                            $reg_st = explode(':', $br["in_time"]);

                                                            $reg_et = explode(':', $br["out_time"]);

                                                            if ($reg_st[0] > $reg_et[0]) {

                                                                $next_day = new DateTime(date('d-m-Y H:i:s') . ' + 1 day');

                                                                $break1 = date('Y-m-d') . " " . $br["in_time"];

                                                                $break2 = $next_day->format('d-m-Y') . " " . $br["out_time"];
                                                            } else {

                                                                $break1 = date('Y-m-d') . " " . $br["in_time"];

                                                                $break2 = date('Y-m-d') . " " . $br["out_time"];
                                                            }



                                                            $break1_date = new DateTime($break1);

                                                            $break2_date = new DateTime($break2);

                                                            $break_interval = dateTimeDiff($break1_date, $break2_date);



                                                            $total_break = $total_break + $break_interval->i;

                                                            if ($break_interval->h > 0)
                                                                $total_break = $total_break + $break_interval->h * 60;

                                                            if ($break_interval->s > 0)
                                                                $total_break = $total_break + ($break_interval->s / 60);
                                                        }
                                                    }
                                                }

											
                                                $time_taken = $in_interval->h * 60 + $in_interval->i - $total_break;



                                                if ($in_interval->s > 0)
                                                    $time_taken = $time_taken + ($in_interval->s / 60);

                                                //print_r($salary[$k]);
                                            }

												
                                            //echo $current_compoff_ot_hrs;
                                            //echo $no_of_ot_hours;
                                            //echo "compoff".$comp_off_ot_hours;

                                            if ($sun == "Sunday") {

                                                //print_r( $att[$current]);

                                                $yes = 1;

                                                if (isset($att[$day_value]) && !empty($att[$day_value])) {

                                                    //print_r($att[$day_value]);

                                                    $half_salary = $regular_time_val / 2;



                                                    if ($regular_time_val <= $time_taken) {

                                                        $comp_off_days = $comp_off_days + 1;

                                                        echo '<td class="holiday_class text-center">C</td>';
                                                    } else if ($half_regular <= $time_taken) {

                                                        $comp_off_days = $comp_off_days + 0.5;

                                                        echo '<td class="holiday_class text-center">C 1/2</td>';
                                                    } elseif ($half_regular > $time_taken) {



                                                        echo '<td class="holiday_class text-center">-&nbsp;Sun&nbsp;-</td>';
                                                    }
                                                } else {

                                                    echo '<td class="holiday_class text-center">-&nbsp;Sun&nbsp;-</td>';
                                                }
                                            }

                                            if ($sun == "Saturday") {

                                                if (isset($saturday_holiday) && $saturday_holiday == 1) {

                                                    $yes = 1;

                                                    if (isset($att[$day_value]) && !empty($att[$day_value])) {



                                                        $half_salary = $regular_time_val / 2;

                                                        if ($regular_time_val <= $time_taken) {

                                                            $comp_off_days = $comp_off_days + 1;

                                                            echo '<td class="holiday_class text-center">C</td>';
                                                        } else if ($half_regular <= $time_taken) {

                                                            $comp_off_days = $comp_off_days + 0.5;

                                                            echo '<td  class="holiday_class text-center">C 1/2</td>';
                                                        } elseif ($half_regular > $time_taken) {



                                                            echo '<td  class="holiday_classtext-center">-&nbsp;Sat&nbsp;-</td>';
                                                        }
                                                    } else {

                                                        echo '<td  class="holiday_class text-center">-&nbsp;Sat&nbsp;-</td>';
                                                    }
                                                }
                                            }



                                            if ($yes == 0) {

                                                if (isset($holi_arr[$day_value]) && !empty($holi_arr[$day_value])) {

                                                    $yes = 1;

                                                    //echo $in_interval->h;

                                                    if (isset($att[$day_value]) && !empty($att[$day_value])) {

                                                        if ($regular_time_val <= $time_taken) {

                                                            $comp_off_days = $comp_off_days + 1;

                                                            echo '<td class="text-center">C</td>';
                                                        } else if ($half_regular <= $time_taken) {

                                                            $comp_off_days = $comp_off_days + 0.5;

                                                            echo '<td class="text-center">C 1/2</td>';
                                                        } elseif ($half_regular > $time_taken) {

                                                           // echo "testt";
                                                            //echo $half_regular; echo "test1";
                                                           // echo $time_taken;exit;
                                                            echo '<td class="text-center">PH</td>';
                                                           // echo '<td><img src="' . $theme_path . '/img/holiday_icon.png" width="20" height="20"></td>';
                                                        }
                                                    } else {

                                                        echo '<td class="text-center">PH</td>';
                                                    }
                                                }
                                            }

                                            if ($yes == 0) {

                                                if (isset($leave_arr[$day_value]) && !empty($leave_arr[$day_value])) {



                                                    $reason = '';

                                                    $yes = 1;



                                                    $leave_from = new DateTime(date('d-m-Y H:i:s', strtotime($leave_arr[$day_value]["leave_from"])));

                                                    $leave_to = new DateTime(date('d-m-Y H:i:s', strtotime($leave_arr[$day_value]["leave_to"])));

                                                    $leave_interval = dateTimeDiff($leave_from, $leave_to);

                                                    if ($leave_arr[$day_value]['type'] == 'casual leave' || $leave_arr[$day_value]['type'] == 'sick leave' || $leave_arr[$day_value]['type'] == 'earned leave') {

                                                        if ($leave_from == $leave_to) {

                                                            $reason = 2;
                                                        } else {



                                                            if ($leave_interval->d == 0) {

                                                                $reason = 1;

                                                                $half_day = ($leave_interval->h * 60) + $leave_interval->i;
                                                            } else {

                                                                $reason = 2;
                                                            }
                                                        }

                                                        if ($reason == 1) {

                                                            if ($leave_arr[$day_value]['type'] == 'casual leave')
                                                                $reason = "CL 1/2";
                                                            else
                                                                $reason = "SL 1/2";



                                                            if ($leave_arr[$day_value]['lop'] == 1) { //echo $reason;
                                                                if ($salary[0]["type"] != "daily") {

                                                                    $lop_days = $lop_days + 0.5;

                                                                    $reason = "LOP 1/2";
                                                                } else
                                                                    $reason = "1/2";
                                                            }

                                                            else {

                                                                if ($salary[0]["type"] != "daily") {

                                                                    $days_with_salary = $days_with_salary + 0.5;
                                                                }
                                                            }

                                                            if (isset($att[$day_value]) && !empty($att[$day_value])) {



                                                                $balance = $regular_time_val - ($leave_interval->h * 60) - $leave_interval->i;

                                                                if ($time_taken < $balance) {



                                                                    if ($salary[$k][0]["type"] != "daily") {

                                                                        $lop_days = $lop_days + 0.5;

                                                                        $reason = "LOP";
                                                                    } else
                                                                        $reason = "a";
                                                                }

                                                                else {

                                                                    $days_with_salary = $days_with_salary + 0.5;
                                                                }
                                                            } else {

                                                                if ($leave_arr[$day_value]['lop'] == 1) {

                                                                    if ($salary[0]["type"] != "daily") {

                                                                        $lop_days = $lop_days + 1;

                                                                        $reason = "LOP";
                                                                    } else
                                                                        $reason = "a";
                                                                }
                                                            }
                                                        }

                                                        else {

                                                            if ($leave_arr[$day_value]['type'] == 'earned leave')
                                                                $reason = "EL";

                                                            else if ($leave_arr[$day_value]['type'] == 'casual leave')
                                                                $reason = "CL";
                                                            else
                                                                $reason = "SL";

                                                            if ($leave_arr[$day_value]['lop'] == 1) {



                                                                if ($salary[0]["type"] != "daily") {

                                                                    $lop_days = $lop_days + 1;



                                                                    $reason = "LOP";
                                                                } else
                                                                    $reason = "a";
                                                            }

                                                            else {

                                                                $days_with_salary = $days_with_salary + 1;
                                                            }
                                                        }
                                                    } else if ($leave_arr[$day_value]['type'] == "permission") {

                                                        $reason = 'P';



                                                        $permission_hrs = ($interval->h * 60) + $interval->i;

                                                        if ($leave_arr[$day_value]['lop'] == 1) {

                                                            if ($salary[0]["type"] != "daily") {

                                                                $lop_days = $lop_days + 0.5;

                                                                $reason = "LOP 1/2";
                                                            } else
                                                                $reason = "1/2";
                                                        }

                                                        else {

                                                            $days_with_salary = $days_with_salary + 0.5;
                                                        }

                                                        if (isset($att[$day_value]) && !empty($att[$day_value])) {

                                                            $balance = $regular_time_val - $permission_hrs;



                                                            if ($time_taken < $balance && $leave_arr[$day_value]['lop'] == 1) {



                                                                $lop_days = $lop_days + 1;

                                                                if ($salary[0]["type"] != "daily") {

                                                                    $reason = "LOP";
                                                                } else {

                                                                    $reason = "a";
                                                                }
                                                            } else if ($time_taken < $balance && $leave_arr[$day_value]['lop'] == 0) {

                                                                $lop_days = $lop_days + 1;

                                                                if ($salary[0]["type"] != "daily") {

                                                                    $reason = "LOP 1/2";
                                                                } else {

                                                                    $reason = "1/2";
                                                                }
                                                            } else if ($time_taken >= $balance) {

                                                                $days_with_salary = $days_with_salary + 0.5;
                                                            }
                                                        } else {

                                                            if ($leave_arr[$day_value]['lop'] == 1) {

                                                                if ($salary[0]["type"] != "daily") {

                                                                    $lop_days = $lop_days + 1;

                                                                    $reason = "LOP";
                                                                } else
                                                                    $reason = "a";
                                                            }
                                                        }
                                                    }

                                                    else if ($leave_arr[$day_value]['type'] == "on-duty") {

                                                        $reason = 'OD';

                                                        //echo $users[$k]["id"];

                                                        $od_dt = $day_value . " 00:00:00";

                                                        $exclude_date = new DateTime($od_dt . ' +1 day');

                                                        $next_day = $exclude_date->format('d-m-Y');

                                                        if ($leave_arr[$day_value]["l_from"] == $day_value && $leave_arr[$day_value]["l_to"] == $day_value) {

                                                            $ds = explode(':', date('H:i:s', strtotime($leave_arr[$day_value]["leave_from"])));

                                                            $duty_start_time = $ds[0] * 60 + $ds[1];

                                                            if (isset($ds[2]) && $ds[2] > 0) {

                                                                $duty_start_time = $duty_start_time + ($ds[2] / 60);
                                                            }

                                                            $ds_to = explode(':', date('H:i:s', strtotime($leave_arr[$day_value]["leave_to"])));

                                                            $duty_end_time = $ds_to[0] * 60 + $ds_to[1];

                                                            if (isset($ds_to[2]) && $ds_to[2] > 0) {

                                                                $duty_end_time = $duty_end_time + ($ds_to[2] / 60);
                                                            }

                                                            $d_from = new DateTime($day_value . " " . date('H:i:s', strtotime($leave_arr[$day_value]["leave_from"])));

                                                            $d_to = new DateTime($day_value . " " . date('H:i:s', strtotime($leave_arr[$day_value]["leave_to"])));

                                                            $d_inter = dateTimeDiff($d_from, $d_to);

                                                            $duty_hours = $d_inter->h * 60 + $d_inter->i + $d_inter->i / 60;

                                                            //echo $duty_hours;

                                                            $duty_hours = $regular_time_val - $duty_hours;

                                                            if ($duty_hours >= $regular_time_val) {

                                                                $days_with_salary = $days_with_salary + 1;

                                                                $full_day_od = 1;
                                                            } else {

                                                                if ($shift_start_time > $duty_start_time)
                                                                    $on_duty = 1;
                                                            }
                                                        }

                                                        elseif ($leave_arr[$day_value]["l_from"] == $next_day && $leave_arr[$day_value]["l_to"] == $next_day) {

                                                            $ds = explode(':', date('H:i:s', strtotime($leave_arr[$day_value]["leave_from"])));

                                                            $duty_start_time = $ds[0] * 60 + $ds[1];

                                                            if (isset($ds[2]) && $ds[2] > 0) {

                                                                $duty_start_time = $duty_start_time + ($ds[2] / 60);
                                                            }

                                                            $ds_to = explode(':', date('H:i:s', strtotime($leave_arr[$day_value]["leave_to"])));

                                                            $duty_end_time = $ds_to[0] * 60 + $ds_to[1];

                                                            if (isset($ds_to[2]) && $ds_to[2] > 0) {

                                                                $duty_end_time = $duty_end_time + ($ds_to[2] / 60);
                                                            }

                                                            $d_from = new DateTime($day_value . " " . date('H:i:s', strtotime($leave_arr[$day_value]["leave_from"])));

                                                            $d_to = new DateTime($day_value . " " . date('H:i:s', strtotime($leave_arr[$day_value]["leave_to"])));

                                                            $d_inter = dateTimeDiff($d_from, $d_to);

                                                            $duty_hours = $d_inter->h * 60 + $d_inter->i + $d_inter->i / 60;

                                                            //echo $duty_hours;

                                                            $duty_hours = $regular_time_val - $duty_hours;

                                                            if ($duty_hours >= $regular_time_val) {

                                                                $days_with_salary = $days_with_salary + 1;

                                                                $full_day_od = 1;
                                                            } else {

                                                                if ($shift_start_time > $duty_start_time)
                                                                    $on_duty = 1;
                                                            }
                                                        }

                                                        elseif ($leave_arr[$day_value]["shift"] == "day") {

                                                            if ($leave_arr[$day_value]["l_from"] == $day_value && $leave_arr[$day_value]["l_to"] != $day_value) {

                                                                //echo "enter";

                                                                $ds = explode(':', date('H:i:s', strtotime($leave_arr[$day_value]["leave_from"])));

                                                                $duty_start_time = $ds[0] * 60 + $ds[1];

                                                                if (isset($ds[2]) && $ds[2] > 0) {

                                                                    $duty_start_time = $duty_start_time + ($ds[2] / 60);
                                                                }

                                                                if ($shift_start_time < $duty_start_time) {



                                                                    $d_from = new DateTime($day_value . " " . $start_time);

                                                                    $d_to = new DateTime($day_value . " " . date('H:i:s', strtotime($leave_arr[$day_value]["leave_from"])));

                                                                    $d_inter = dateTimeDiff($d_from, $d_to);

                                                                    $duty_hours = $d_inter->h * 60 + $d_inter->i + $d_inter->i / 60;
                                                                } else if ($shift_start_time >= $duty_start_time) {

                                                                    $days_with_salary = $days_with_salary + 1;

                                                                    $full_day_od = 1;
                                                                }
                                                            } else if ($leave_arr[$day_value]["l_from"] != $day_value && $leave_arr[$day_value]["l_to"] != $day_value) {

                                                                $days_with_salary = $days_with_salary + 1;

                                                                $full_day_od = 1;
                                                            } elseif ($leave_arr[$day_value]["l_from"] != $day_value && $leave_arr[$day_value]["l_to"] == $day_value) {

                                                                $ds = explode(':', date('H:i:s', strtotime($leave_arr[$day_value]["leave_to"])));

                                                                $duty_end_time = $ds[0] * 60 + $ds[1];

                                                                if (isset($ds[2]) && $ds[2] > 0) {

                                                                    $duty_end_time = $duty_end_time + ($ds[2] / 60);
                                                                }

                                                                if ($shift_start_time < $duty_end_time) {





                                                                    $d_from = new DateTime($day_value . " " . date('H:i:s', strtotime($leave_arr[$day_value]["leave_to"])));

                                                                    $d_to = new DateTime($day_value . " " . $end_time);

                                                                    $d_inter = dateTimeDiff($d_from, $d_to);

                                                                    $duty_hours = $d_inter->h * 60 + $d_inter->i + $d_inter->i / 60;

                                                                    $on_duty = 1;
                                                                } else if ($shift_start_time >= $duty_end_time) {

                                                                    $duty_hours = 0;
                                                                }
                                                            }
                                                        } elseif ($leave_arr[$day_value]["shift"] == "night") {



                                                            if ($leave_arr[$day_value]["l_from"] == $day_value && $leave_arr[$day_value]["l_to"] == $next_day) {

                                                                $ds = explode(':', date('H:i:s', strtotime($leave_arr[$day_value]["leave_from"])));

                                                                $duty_start_time = $ds[0] * 60 + $ds[1];

                                                                if (isset($ds[2]) && $ds[2] > 0) {

                                                                    $duty_start_time = $duty_start_time + ($ds[2] / 60);
                                                                }

                                                                $ds_to = explode(':', date('H:i:s', strtotime($leave_arr[$day_value]["leave_to"])));

                                                                $duty_end_time = $ds_to[0] * 60 + $ds_to[1];

                                                                if (isset($ds_to[2]) && $ds_to[2] > 0) {

                                                                    $duty_end_time = $duty_end_time + ($ds_to[2] / 60);
                                                                }

                                                                $d_from = new DateTime($day_value . " " . date('H:i:s', strtotime($leave_arr[$day_value]["leave_from"])));

                                                                $d_to = new DateTime($next_day . " " . date('H:i:s', strtotime($leave_arr[$day_value]["leave_to"])));

                                                                $d_inter = dateTimeDiff($d_from, $d_to);

                                                                $duty_hours = $d_inter->h * 60 + $d_inter->i + $d_inter->i / 60;

                                                                //echo $duty_hours;

                                                                $duty_hours = $regular_time_val - $duty_hours;

                                                                if ($duty_hours >= $regular_time_val) {

                                                                    $days_with_salary = $days_with_salary + 1;

                                                                    $full_day_od = 1;
                                                                } else {

                                                                    if ($shift_start_time > $duty_start_time)
                                                                        $on_duty = 1;
                                                                }
                                                            }

                                                            else if ($leave_arr[$day_value]["l_from"] == $day_value && $leave_arr[$day_value]["l_to"] != $day_value) {

                                                                $ds = explode(':', date('H:i:s', strtotime($leave_arr[$day_value]["leave_from"])));

                                                                $duty_start_time = $ds[0] * 60 + $ds[1];

                                                                if (isset($ds[2]) && $ds[2] > 0) {

                                                                    $duty_start_time = $duty_start_time + ($ds[2] / 60);
                                                                }

                                                                if ($shift_start_time < $duty_start_time) {



                                                                    $d_from = new DateTime($day_value . " " . $start_time);

                                                                    $d_end = date('H:i:s', strtotime($leave_arr[$day_value]["leave_from"]));

                                                                    if (strtotime($d_end) <= strtotime($start_time))
                                                                        $d_to = new DateTime($day_value . " " . $d_end);
                                                                    else
                                                                        $d_to = new DateTime($next_day . " " . $d_end);

                                                                    $d_inter = dateTimeDiff($d_from, $d_to);

                                                                    $duty_hours = $d_inter->h * 60 + $d_inter->i + $d_inter->i / 60;
                                                                }

                                                                else if ($shift_start_time >= $duty_start_time) {

                                                                    $days_with_salary = $days_with_salary + 1;

                                                                    $full_day_od = 1;
                                                                }
                                                            } else if ($leave_arr[$day_value]["l_from"] != $day_value && $leave_arr[$day_value]["l_to"] != $day_value) {

                                                                if ($next_day == $leave_arr[$day_value]["l_to"]) {



                                                                    $ds = explode(':', date('H:i:s', strtotime($leave_arr[$day_value]["leave_to"])));

                                                                    $duty_end_time = $ds[0] * 60 + $ds[1];

                                                                    if (isset($ds[2]) && $ds[2] > 0) {

                                                                        $duty_end_time = $duty_end_time + ($ds[2] / 60);
                                                                    }

                                                                    if ($shift_start_time >= $duty_end_time) {



                                                                        $d_st = date('H:i:s', strtotime($leave_arr[$day_value]["leave_to"]));

                                                                        $d_from = new DateTime($day_value . " " . $d_st);

                                                                        if (strtotime($d_st) >= strtotime($end_time))
                                                                            $d_to = new DateTime($next_day . " " . $end_time);
                                                                        else
                                                                            $d_to = new DateTime($day_value . " " . $end_time);

                                                                        $d_inter = dateTimeDiff($d_from, $d_to);

                                                                        $duty_hours = $d_inter->h * 60 + $d_inter->i + $d_inter->i / 60;

                                                                        $on_duty = 1;
                                                                    }

                                                                    else if ($shift_start_time < $duty_end_time) {

                                                                        $duty_hours = 0;
                                                                    }
                                                                } else {

                                                                    $days_with_salary = $days_with_salary + 1;

                                                                    $full_day_od = 1;
                                                                }
                                                            }
                                                        }

                                                        if (isset($att[$day_value]) && !empty($att[$day_value])) {

														

                                                            $att_time = explode(':', $att[$day_value]["in"]);

                                                            $att_calc = $att_time[0] * 60 + $att_time[1];

                                                            if (isset($att_time) && $att_time[2] > 0)
                                                                $att_calc = $att_calc + ($att_time[2] / 60);

                                                            $balance = $regular_time_val - $duty_hours;



                                                            if ($full_day_od == 0):



                                                                if ($time_taken < $duty_hours) {

                                                                    if ($time_taken >= $half_regular) {

                                                                        if ($att_calc > $shift_start_time && $on_duty != 1) {

                                                                            if ($salary[0]["type"] == "daily")
                                                                                $reason = 'a';
                                                                            else
                                                                                $reason = 'LOP';
                                                                        }

                                                                        else {

                                                                            $days_with_salary = $days_with_salary + 0.5;



                                                                            if ($salary[0]["type"] == "daily")
                                                                                $reason = '1/2';
                                                                            else
                                                                                $reason = 'LOP 1/2';
                                                                        }
                                                                    }

                                                                    else {

                                                                        if ($salary[0]["type"] == "daily")
                                                                            $reason = 'a';
                                                                        else
                                                                            $reason = 'LOP';
                                                                    }
                                                                }



                                                                else if ($time_taken >= $duty_hours) {

                                                                    if ($att_calc > $shift_start_time && $on_duty != 1) {

                                                                        if ($salary[0]["type"] == "daily")
                                                                            $reason = '1/2';
                                                                        else
                                                                            $reason = 'LOP 1/2';

                                                                        $days_with_salary = $days_with_salary + 0.5;
                                                                    }

                                                                    else {

                                                                        $days_with_salary = $days_with_salary + 1;

                                                                        $reason = '<span class="fa fa-check"></span>';
                                                                    }
                                                                }



                                                            endif;
                                                        } else {





                                                            if ($full_day_od == 0) {

                                                                if ($salary[0]["type"] == "daily")
                                                                    $reason = 'a';
                                                                else
                                                                    $reason = 'LOP';
                                                            }
                                                        }
                                                    }





                                                    else if ($leave_arr[$day_value]['type'] == "compoff") {

                                                        if ($leave_arr[$day_value]['approved'] == 1) {

                                                            $reason = 'compoff leave';

                                                            if ($leave_interval->h == 0) {

                                                                $days_with_salary = $days_with_salary + 1;
                                                            } else {

                                                                $days_with_salary = $days_with_salary + 0.5;
                                                            }
                                                        } else {

                                                            //$reason = 'a';

                                                            if ($leave_interval->h > 5) {

                                                                $lop_days = $lop_days + 1;

                                                                $reason = 'a';
                                                            } else {

                                                                $lop_days = $lop_days + 0.5;

                                                                $days_with_salary = $days_with_salary + 0.5;

                                                                $reason = 'a 1/2';
                                                            }
                                                        }
                                                    }





                                                    echo '<td>' . $reason . '</td>';

                                                    $yes = 1;
                                                }
                                            }

                                            if ($yes == 0) {

                                                if (isset($att[$day_value]) && !empty($att[$day_value])) {

                                                    if ($salary[0]["type"] == "daily") {

                                                        if ($att[$day_value]["in"] != "00:00:00" && $att[$day_value]["in"] != "NULL") {

                                                            $att_time = explode(':', $att[$day_value]["in"]);

                                                            $att_calc = $att_time[0] * 60 + $att_time[1];

                                                            if (isset($att_time) && $att_time[2] > 0)
                                                                $att_calc = $att_calc + ($att_time[2] / 60);

                                                            if ($att_calc > $shift_start_time && $regular_time_val > $time_taken) {

                                                                echo "<td>a</td>";

                                                                $lop_days = $lop_days + 1;
                                                            } else if ($att_calc > $shift_start_time) {

                                                                echo "<td>1/2</td>";

                                                                $lop_days = $lop_days + 0.5;

                                                                $days_with_salary = $days_with_salary + 0.5;
                                                            } else if ($regular_time_val > $time_taken) {



                                                                if ($time_taken >= $half_regular) {

                                                                    echo "<td>1/2</td>";

                                                                    $lop_days = $lop_days + 0.5;

                                                                    $days_with_salary = $days_with_salary + 0.5;
                                                                } else {

                                                                    echo "<td>a</td>";

                                                                    $lop_days = $lop_days + 1;
                                                                }
                                                            } else if ($regular_time_val <= $time_taken) {



                                                                $days_with_salary = $days_with_salary + 1;

                                                                echo '<td><span class="fa fa-check"></span></td>';
                                                            }

                                                            $yes = 1;
                                                        } else
                                                            echo '<td>a</td>';
                                                    }

                                                    else {

                                                        $att_time = explode(':', $att[$day_value]["in"]);
														

                                                        if ($att[$day_value]["in"] != "00:00:00" && $att[$day_value]["in"] != NULL):

                                                            $att_calc = $att_time[0] * 60 + $att_time[1];

                                                            if (isset($att_time[2]) && $att_time[2] > 0)
                                                                $att_calc = $att_calc + ($att_time[2] / 60);


// echo "<pre>";
												// print_r($att_calc);
												// echo "<br>";
												// print_r($shift_start_time);
												// echo "<br>";
												// print_r($regular_time_val);
												// echo "<br>";
												// print_r($time_taken);
                                                            if ($att_calc > $shift_start_time && $regular_time_val > $time_taken) {

                                                                echo "<td>LOP</td>";

                                                                $lop_days = $lop_days + 1;
                                                            } else if ($att_calc > $shift_start_time) {

                                                                echo "<td>LOP 1/2</td>";

                                                                $lop_days = $lop_days + 0.5;

                                                                $days_with_salary = $days_with_salary + 0.5;
                                                            } else if ($regular_time_val > $time_taken) {
								// echo "<pre>";
												// print_r($regular_time_val);
												// echo "<br>";
												// print_r($time_taken);
												// echo "<br>";
												// print_r($total_break);
												// echo "<br>";
												// print_r($half_regular);
                                                                if ($time_taken >= $half_regular) {
//test_data
                                                                    echo "<td>LOP 1/2</td>";

                                                                    $lop_days = $lop_days + 0.5;

                                                                    $days_with_salary = $days_with_salary + 0.5;
                                                                } else {

                                                                    echo "<td>LOP</td>";

                                                                    $lop_days = $lop_days + 1;
                                                                }
                                                            } else if ($regular_time_val <= $time_taken) {

                                                                $days_with_salary = $days_with_salary + 1;

                                                                echo '<td><span class="fa fa-check"></span></td>';
                                                            }

                                                            $yes = 1;

                                                        endif;
                                                    }
                                                }
                                            }

                                            if ($yes == 0) {

                                                echo "<td class='text-center'>a</td>";

                                                if ($salary[0]["type"] != "daily") {

                                                    $lop_days = $lop_days + 1;
                                                }
                                            }
                                            ?>

                                            <?php
                                        } else
                                            echo "<td class='text-center'>NA</td>";
                                    }
                                }
                                ?>



                                <td class="text-center"><?php
                                    echo $days_with_salary;

                                    $total_ot = 0;

                                    if ($no_of_ot_hours != 0)
                                        $total_ot += $no_of_ot_hours / (60 / $ot_division);

                                    if ($comp_off_ot_hours != 0)
                                        $total_ot += $comp_off_ot_hours / (60 / $ot_division);

                                    if ($total_ot != 0)
                                        echo "+" . $total_ot / 4;
                                    ?>

                                </td>

                                <td class="text-center">
                                    <?php
                                    if ($comp_off_days > 0)
                                        echo $comp_off_days;
                                    else
                                        echo "-";
                                    ?>
                                </td>
                                <td class="text-center hide_class">
                                    <?php
                                    $employee_id = $users[$k]['id'];
                                    $link = $this->config->item('base_url') . 'attendance/reports/monthly_attendance_view/' . $employee_id;
                                    echo "<span class='badge bg-green view_monthly_report' emp_id='$employee_id' style='cursor: pointer;'>View</span>";
                                    ?>
                                </td>
                            </tr>
                            <?php 
                        }
                            //exit;
                        }
                    endif;

                    if (empty($users)) {

                        if ($proceed == 0)
                            $colspan = 20 + count($days_array) + 1;
                        else
                            $colspan = 11 + count($days_array) + 1;

                        echo "<tr><td colspan=" . $colspan . ">No Results Found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
   
    <?php
    if (isset($users) && !empty($users)) {
        $end = $start_page + count($users);
        $start_page = $start_page + 1;
        ?>
        <span class="no-display">Showing <?= $start_page ?> to <?= $end ?> of <?= count($no_of_users) ?> records </span>

    <?php } ?>

    <div class="button_right_align">

        <?php
        if (isset($links) && $links != NULL)
            echo $links;
        ?>
        <div class="action-btn-align">
            <button class="btn btn-success excel" id="excel_report"><span class="glyphicon glyphicon-print"></span> Excel</button>
            <a href="#" id="print" class="btn btn-info  print-align"><i class="icon icon-print"></i> Print</a>
        </div>

    </div>

    <input type="hidden" id="week_starting_day" value="<?= $week_starting_day ?>"/>

    <input type="hidden" id="month_starting_date" value="<?= $month_starting_date ?>"/>

 </div>
</div><!--contentinner-->



<!-- <div class="button_right_align">



</div>-->

<?php

function dateTimeDiff($date1, $date2) {

    $alt_diff = new stdClass();

    $alt_diff->y = floor(abs($date1->format('U') - $date2->format('U')) / (60 * 60 * 24 * 365));

    $alt_diff->m = floor((floor(abs($date1->format('U') - $date2->format('U')) / (60 * 60 * 24)) - ($alt_diff->y * 365)) / 30);

    $alt_diff->d = floor(floor(abs($date1->format('U') - $date2->format('U')) / (60 * 60 * 24)) - ($alt_diff->y * 365) - ($alt_diff->m * 30));

    $alt_diff->h = floor(floor(abs($date1->format('U') - $date2->format('U')) / (60 * 60)) - ($alt_diff->y * 365 * 24) - ($alt_diff->m * 30 * 24 ) - ($alt_diff->d * 24));

    $alt_diff->i = floor(floor(abs($date1->format('U') - $date2->format('U')) / (60)) - ($alt_diff->y * 365 * 24 * 60) - ($alt_diff->m * 30 * 24 * 60) - ($alt_diff->d * 24 * 60) - ($alt_diff->h * 60));

    $alt_diff->s = floor(floor(abs($date1->format('U') - $date2->format('U'))) - ($alt_diff->y * 365 * 24 * 60 * 60) - ($alt_diff->m * 30 * 24 * 60 * 60) - ($alt_diff->d * 24 * 60 * 60) - ($alt_diff->h * 60 * 60) - ($alt_diff->i * 60));

    $alt_diff->invert = (($date1->format('U') - $date2->format('U')) > 0) ? 0 : 1;

    return $alt_diff;
}
?>

<script type="text/javascript">

    $("#from_date_atten").datepicker({
        dateFormat: 'dd-mm-yy',
    });
    $("#to_date_atten").datepicker({
        dateFormat: 'dd-mm-yy',
    });

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
    $(document).ready(function () {
        user_val = "<?= $user_type ?>";
        if (user_val == 2)

        {
            $("#date_th").hide();
        }

    });

    $(".showmenu").click(function () {

        $(this).attr("title", title);
        $('.headerpanel').css('width', '100%');
    }
    );

    $(document).on('click', '.view_monthly_report', function () {
        var emp_id = $(this).attr('emp_id');
        $.ajax({
            url: BASE_URL + "attendance/reports/monthly_attendance_sets/",
            type: "POST",
            data: {emp_id: emp_id, year: $('#year_select').val(), month: $('#month_select').val()},
            success: function (res)
            {
                window.location = '<?php echo $this->config->item('base_url') . 'attendance/reports/monthly_attendance_view/'; ?>';
            }
        });
    });
</script>
