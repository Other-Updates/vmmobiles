<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<link rel="stylesheet" href="<?= $theme_path; ?>/css/bootstrap-multiselect.css" type="text/css"/>
<script type="text/javascript" src="<?= $theme_path; ?>/js/bootstrap-multiselect.js"></script>

<script type="text/javascript" src="<?= $theme_path; ?>/js/employee.js"></script>
<style>
    <!--@media print

    {

        .contentinner

        {

            -webkit-print-color-adjust: exact;

        }

    }-->
    .req {
        color: #FF0000;
    }
    .box {color:black !important; background-color:white !important; }
    .red {
        color:#f50d0d;
    }
    .green {
        color:#008000;
    }
    .yellow {
        color: #e8da18;
    }
    table.dataTable thead > tr > th {
        padding-left: 0px !important;
        padding-right: 0px !important;
        text-align:center !important;
    }
</style>
<style type="text/css" media="print">
    @page
    {
        size:letter landscape; max-width:100% !important;
        margin: 0;
        padding:0;
        margin: 1cm auto;

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
        <h4>Daily Attendance </h4>
    </div>

    <div class="contentpanel">

        <div class="panel-body mt-top5">

            <?php
            //print_r($user_attendance);
            // $user_role = json_decode($roles[0]["roles"]);
            //print_r($roles);

            $filter = $this->session_view->get_session(null, null);

            $attributes = array('class' => 'stdform editprofileform', 'method' => 'post');

            echo form_open('', $attributes);
            ?>

            <table  id="basicTable_call_back" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline box hide_class " >

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

                        <th colspan="2" class="action-btn-align">Present <span class="req">*</span>&nbsp;

                            <?php
                            $present = false;
                            if ($attendance_status == "all" || $attendance_status == "1") {
                                $present = true;
                            }
                            if ($present == true) {
                                $data = array(
                                    'id' => 'atten_status',
                                    'type' => 'checkbox',
                                    'name' => 'atten_status_p',
                                    'class' => 'input-small atten_status',
                                    'value' => '1',
                                    'checked' => "checked"
                                );
                            } else {
                                $data = array(
                                    'id' => 'atten_status',
                                    'type' => 'checkbox',
                                    'name' => 'atten_status_p',
                                    'class' => 'input-small atten_status',
                                    'value' => '1'
                                );
                            }


                            echo form_input($data);
                            ?>



                        </th>

                        <th class="action-btn-align">Absent <span class="req">*</span>&nbsp;

                            <?php
                            $absent = false;
                            if ($attendance_status == "all" || $attendance_status == "0") {
                                $absent = true;
                            }
                            if ($absent == true) {
                                $data = array(
                                    'id' => 'atten_status',
                                    'type' => 'checkbox',
                                    'name' => 'atten_status_a',
                                    'class' => 'input-small atten_status',
                                    'value' => '0',
                                    'checked' => "checked"
                                );
                            } else {
                                $data = array(
                                    'id' => 'atten_status',
                                    'type' => 'checkbox',
                                    'name' => 'atten_status_a',
                                    'class' => 'input-small atten_status',
                                    'value' => '0'
                                );
                            }


                            echo form_input($data);
                            ?>



                        </th>


                        <th>&nbsp;

                            <?php
                            $data = array(
                                'id' => 'attendance-search',
                                'name' => 'search',
                                'value' => 'Search',
                                'class' => 'btn btn-warning border4',
                                'title' => 'Search'
                            );



                            echo form_submit($data);
                            ?>

                        </th>

                        <th>&nbsp;

                            <a href="javascript:void(0)" title="Reset"><input type="button" class="btn btn-danger border4 reset" value="Reset"></a>

                        </th>

                    </tr>

                </thead>

            </table>



            <?php
//            echo "<pre>";
//            print_r($no_of_users1);
//            exit;
            if (isset($no_of_users1)) {

                $options = array();

                $this->load->model('masters/options_model');

                $record = array(10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 120, 140, 160, 180, 200);

                $closest = $this->options_model->getClosest(count($no_of_users1), $record);

                //echo $closest;

                for ($k = 10; $k <= $closest;) {

                    $options[$k] = $k;

                    if ($k < 100)
                        $k = $k + 10;
                    else
                        $k = $k + 20;
                }

                if (count($no_of_users1) >= 1000) {

                    $count_start = count($no_of_users1) / 100;

                    if ($count_start >= 10) {



                        for ($c = 4; $c < $count_start;) {

                            $options[$c * 100] = $c * 100;

                            $c+=2;
                        }
                    }
                }

                if (!in_array($count, $options)) {

                    $max = $this->options_model->getClosest($count, $options);

                    if ($max < count($no_of_users1))
                        $count = "all";
                    else
                        $count = $max;
                }

                $options["all"] = "All";

                echo "Show " . form_dropdown('record_show', $options, $count, "id='count_change'") . " entries";
            }
            ?>

            <div class="button_right_align  mt--20 mtop"><br/>

                <strong>P</strong> - Present, &nbsp; &nbsp;<strong>A</strong> - Absent, &nbsp;&nbsp; <strong>PH</strong> - Public Holiday, &nbsp; &nbsp;<strong>H</strong> - Saturday, &nbsp; &nbsp;<strong>WO</strong> - Week Off, &nbsp; &nbsp;<strong>1/4 A</strong> - Quater day Absent, &nbsp; &nbsp;<strong>1/2 A</strong> - Half day Absent, &nbsp; &nbsp;<strong>3/4 A</strong> - Three Quaters day Absent

            </div>

            <div class="" style="">

                <?php
                $attributes = array('class' => 'attendance_data_form', 'method' => 'post');

                echo form_open('', $attributes);

                if ($attendance_status == "1")
                    $status = ["P"];
                else if ($attendance_status == "0")
                    $status = ["A", "1/2A", "1/4A", "3/4A"];
                if ($attendance_status == "all")
                    $status = ["P", "A", "H", "PH", "-", "1/2A", "WO", "1/4A", "3/4A", ""];

                if (isset($users_data)) {
                    foreach ($users_data as $dates => $users_list) {
                        $date_for_name = date('d-m-Y', strtotime($dates));
                        $nameOfDay = date('l', strtotime($date_for_name));

                        if (!empty($users_list['users'])) {
                            ?>
                            <div>

                                <?php
                                if ($attendance_status != "all") {
                                    if ($users_list['holidays'] != "") {
                                        $users_list['is_users'] = 0;
                                    }
                                }

                                if ($users_list['is_users'] == 1) {
                                    ?>
                                    <h5>Daily Attendance <?php echo date('d-m-Y', strtotime($dates)); ?> (<?php echo $nameOfDay; ?>)</h5>
                                    <table  id="basicTable_call_back" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">

                                        <thead>

                                            <?php
//print_r($shifts);
                                            $head = array("S.No", "Employee Id", "Username", "Employee Name", "Department", "Designation", "Email");

                                            $db_name = array("id", "emp_id", "username", "first_name", "dept_name", "des_name", "email");
                                            ?>

                                            <tr>
                                                <th rowspan="2"><div class="verticalTableHeader1">S.No&nbsp;</div></th>
                                                <th rowspan="2"><div class="verticalTableHeader1">Employee Code</div></th>
                                                <th rowspan="2"><div class="verticalTableHeader1">Employee Name</div></th>
                                                <th style="text-align: center;" colspan="8">ForeNoon</th>
                                                <th style="text-align: center;" colspan="8">AfterNoon</th>
                                                <th rowspan="2"><div class="verticalTableHeader1">Overall Work Duration</div></th>
                <!--                                                <th rowspan="2"><div class="verticalTableHeader1">OT</div></th>
                                                <th rowspan="2"><div class="verticalTableHeader1">Total Duration</div></th>-->
                                                <th rowspan="2"><div class="verticalTableHeader1">Attendance Status</div></th>
                                                <th rowspan="2"><div class="verticalTableHeader1">Punch Records</div></th>
                                            </tr>
                                            <tr>
                                                <th>S.InTime</th>
                                                <th>S.OutTime</th>
                                                <th>A.InTime</th>
                                                <th>A.OutTime</th>
                                                <th>LateBy</th>
                                                <th>EarlyGoing</th>
                                                <th>Work Duration</th>
                                                <th>Status</th>
                                                <th>S.InTime</th>
                                                <th>S.OutTime</th>
                                                <th>A.InTime</th>
                                                <th>A.OutTime</th>
                                                <th>LateBy</th>
                                                <th>EarlyGoing</th>
                                                <th>Work Duration</th>
                                                <th>Status</th>
                                            </tr>

                                            <?php
                                            if (isset($users_data[$dates]['holidays']) && !empty($users_data[$dates]['holidays'])) {
                                                ?>

                                                <tr><td colspan='22'><center><?php echo $users_data[$dates]['holidays'] ?></center></td></tr>



                                        <?php } else { ?>



                                            <?php
                                            if (isset($users_data[$dates]['users']) && !empty($users_data[$dates]['users'])) {

                                                foreach ($users_data[$dates]['users'] as $key => $list) {
                                                    if (in_array($list['status'], $status)) {
                                                        ?>
                                                        <tr>
                                                            <td class="action-btn-align"><?php echo $key + 1; ?></td>
                                                            <td class="action-btn-align"><?php echo $list['employee_id']; ?></td>
                                                            <td class="action-btn-align"><?php echo ucwords($list['username']); ?></td>
                                                           <!-- <td class="action-btn-align"><?php echo $list['shift_name']; ?></td>-->
                                                            <td class="action-btn-align"><?php echo $list['shift_fn_in']; ?></td>
                                                            <td class="action-btn-align"><?php echo $list['shift_fn_out']; ?></td>
                                                            <td class="action-btn-align time_calc_in_time">
                                                                <?php
                                                                if ($list['mor_in'] == ":") {
                                                                    echo "-";
                                                                } else {
                                                                    echo $list['mor_in'];
                                                                }
                                                                ?></td>
                                                            <td class="action-btn-align"><?php
                                                                if ($list['mor_out'] == ":") {
                                                                    echo "-";
                                                                } else {
                                                                    echo $list['mor_out'];
                                                                }
                                                                ?></td>
                                                            <td class="action-btn-align"><?php echo $list['mor_late_by']; ?></td>
                                                            <td class="action-btn-align"><?php echo $list['mor_early_going']; ?></td>
                                                            <td><?php echo $list['morning_work_duration']; ?></td>
                                                            <?php if ($list['morning_status'] == "P") {
                                                                ?>
                                                                <td class="action-btn-align green">P</td>
                                                            <?php } else if ($list['morning_status'] == "3/4A") { ?>
                                                                <td class="action-btn-align red">3/4A</td>
                                                            <?php } else if ($list['morning_status'] == "A") { ?>
                                                                <td class="action-btn-align red">A</td>
                                                            <?php } else if ($list['morning_status'] == "1/2A") { ?>
                                                                <td class="action-btn-align red">1/2A</td>
                                                            <?php } else if ($list['morning_status'] == "1/4A") { ?>
                                                                <td class="action-btn-align red">1/4A</td>
                                                            <?php } else if ($list['morning_status'] == "1/2P") { ?>
                                                                <td class="action-btn-align green">1/2P</td>
                                                            <?php } else { ?>
                                                                <td class="action-btn-align"><?php echo $list['morning_status']; ?></td>
                                                            <?php } ?>
                                                            <td class="action-btn-align"><?php echo $list['shift_an_in']; ?></td>
                                                            <td class="action-btn-align"><?php echo $list['shift_an_out']; ?></td>
                                                            <td class="action-btn-align">
                                                                <?php
                                                                if ($list['aftnun_in'] == ":") {
                                                                    echo "-";
                                                                } else {
                                                                    echo $list['aftnun_in'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="action-btn-align time_calc_out_time"><?php
                                                                if ($list['aftnun_out'] == ":") {
                                                                    echo "-";
                                                                } else {
                                                                    echo $list['aftnun_out'];
                                                                }
                                                                ?></td>
                                                            <td class="action-btn-align"><?php echo $list['aftnun_late_by']; ?></td>
                                                            <td class="action-btn-align"><?php echo $list['aftnun_early_going']; ?></td>
                                                            <td><?php echo $list['afternoon_work_duration']; ?></td>
                                                            <?php if ($list['evening_status'] == "P") {
                                                                ?>
                                                                <td class="action-btn-align green">P</td>
                                                            <?php } else if ($list['evening_status'] == "3/4A") { ?>
                                                                <td class="action-btn-align red">3/4A</td>
                                                            <?php } else if ($list['evening_status'] == "A") { ?>
                                                                <td class="action-btn-align red">A</td>
                                                            <?php } else if ($list['evening_status'] == "1/2A") { ?>
                                                                <td class="action-btn-align red">1/2A</td>
                                                            <?php } else if ($list['evening_status'] == "1/4A") { ?>
                                                                <td class="action-btn-align red">1/4A</td>
                                                            <?php } else if ($list['evening_status'] == "1/2P") { ?>
                                                                <td class="action-btn-align green">1/2P</td>
                                                            <?php } else { ?>
                                                                <td class="action-btn-align"><?php echo $list['morning_status']; ?></td>
                                                            <?php } ?>
                                                            <td class="action-btn-align time_calc_work_time"><?php echo $list['overall_work_duration']; ?></td>
                                <!--                                                            <td class="action-btn-align"><?php echo $list['ot']; ?></td>
                                                            <td class="action-btn-align"><?php echo $list['over_all_duration']; ?></td>-->

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <!--<td class="action-btn-align"><?php echo $list['status']; ?></td>-->
                                                            <?php if ($list['status'] == "PH") {
                                                                ?>
                                                                <td class="action-btn-align green">PH</td>
                                                            <?php } else if ($list['status'] == "H") {
                                                                ?>
                                                                <td class="action-btn-align yellow">H</td>
                                                            <?php } else if ($list['status'] == "3/4A") { ?>
                                                                <td class="action-btn-align red">3/4A</td>
                                                            <?php } else if ($list['status'] == "P") { ?>
                                                                <td class="action-btn-align green">P</td>
                                                            <?php } else if ($list['status'] == "A") { ?>
                                                                <td class="action-btn-align red">A</td>
                                                            <?php } else if ($list['status'] == "1/2A") { ?>
                                                                <td class="action-btn-align red">1/2A</td>
                                                            <?php } else if ($list['status'] == "1/4A") { ?>
                                                                <td class="action-btn-align red">1/4A</td>
                                                            <?php } else if ($list['status'] == "WO") { ?>
                                                                <td class="action-btn-align yellow">WO</td>
                                                            <?php } else { ?>
                                                                <td class="action-btn-align green"><?php echo $list['status']; ?></td>
                                                            <?php } ?>
                                                            <td class="logs"> <center><span class='badge bg-green view_day_log' date="<?php echo date('d-m-Y', strtotime($dates)); ?>" user_id="<?php echo $list['id']; ?>"  style="cursor: pointer;" title="log">log</span></center></td>
                                                        <td class="action-btn-align fulllogs deactive_class" style="text-align: justify;"><?php echo $list['full_logs']; ?></td>
                                                                                                <!-- <td class="action-btn-align">dsfsdfsssssssssssssssssssssssssssssssssssssssss</td>-->

                                                        </tr>


                                                        <?php
                                                    }
                                                }
                                            } else {
                                                ?>

                                                <tr><td colspan='7'>No Records Found</td></tr>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <!--</tr>-->

                                        </thead>



                                        <tbody>

                                        </tbody>

                                    </table></div><?php
                            }
                        }
                    }
                }
                ?>
            </div>

            <?php
            if (isset($no_of_users1)) {

                if (isset($users) && !empty($users)) {

                    $end = $start + count($users);

                    $start = $start + 1;
                    ?>

                    Showing <?= $start ?> to <?= $end ?> of <?= count($no_of_users1) ?> records

                    <?php
                }
            }
            $this->load->library('user_agent');
            if ($this->agent->is_referral()) {
                $refer = $this->agent->referrer();
            }
            ?>


            <div class="action-btn-align mb-10" style="margin-top:7px;">
                <input type="submit" name="update" value="save" class="btn btn-primary btn-rounded save" title="save" autocomplete="off" style="display: none;">

                <a href="<?php echo $refer; ?>" title="Back"><input type="button" class="btn btn-info btn-rounded" value="Back" id="back_btn" autocomplete="off" ></a>

                <a href="javascript:void(0)" id="print" title="Print"> <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button></i></a>
            </div>




            <div class="button_right_align">

                <?php
                if (isset($links) && $links != NULL)
                    echo $links;
                ?><br />

                <a href="javascript:void(0);">

                    <input type="submit" class="btn btn-success btn-rounded"  value="Add Attendance"  name ="add_attendance" style="display:none; float:right;" id="add_attendance"/>

                </a>

            </div>



        </div>



    </div>
</div>
<div id="day_log_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content"style="overflow-y:auto; height:600px;">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h6 class="modal-title">Daily Log History</h6>

            </div>

            <div class="modal-body">
                <div class="form-group">
                    <div class="col-lg-12">

                        <div> <div class="col-md-4"> <div style="">In Time : <span class="modal_in_time">00:00</span></div>  </div>
                            <div class="col-md-4"> <div style=""> Out Time :<span class="modal_out_time">00:00</span></div></div>
                            <div class="col-md-4"><div style="float:right;">Work duration: <span class="modal_over_work_time">00:00</span></div></div></div>
                        <table class="table table-bordered sortable table-striped table-bordered responsive  no-footer dtr-inline
                               tquantity-cntr tamount-right">

                            <thead>
                                <tr>
                                    <th>S.No</th><th>In Time</th><th>Out Time</th><th>Duration</th>
                                </tr>
                            </thead>
                            <tbody id="dynamic_logs_table">

                                <tr>
                                    <td class="center holiday_class" colspan="4">No logs found...!</td>

                                </tr>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<style>

    .deactive_class
    {
        display:none;
    }
</style>
<script type="text/javascript">



    $(document).ready(function () {
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
        //$('#department_select').select2();
        var enter_count = "<?= $enter_count ?>";

        //alert(enter_count);

        if (enter_count == 0)

        {

            $(".group_check").hide();

        } else

        {

            $("#action").hide();

        }


        $(document).on('click', '.view_day_log', function () {
            var modal_in_time = $(this).closest('tr').find('.time_calc_in_time').text();
            var modal_out_time = $(this).closest('tr').find('.time_calc_out_time').text();
            var modal_over_work_time = $(this).closest('tr').find('.time_calc_work_time').text();

            // if (modal_in_time == null || modal_in_time == '')
            //modal_in_time = '-';
            //if (modal_out_time == null || modal_out_time == '')
            // modal_out_time = '-';
            $('.modal_in_time').text('').text(modal_in_time);
            $('.modal_out_time').text('').text(modal_out_time);
            $('.modal_over_work_time').text('').text(modal_over_work_time);
            $('#day_log_modal').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#day_log_modal').modal('show');

            var user_id = $(this).attr('user_id');
            var date = $(this).attr('date');
            //alert(date);
            $.ajax({
                url: BASE_URL + "attendance/reports/get_emp_all_logs_by_day",
                type: "POST",
                data: {user_id: user_id, created_date: date, modal_in_time: modal_in_time, modal_out_time: modal_out_time},
                success: function (res)
                {
//                    alert(res);
                    $('#dynamic_logs_table').html('').html(res);
                }
            });

        });

        $(".group_check").click(function () {

            if ($(this).is(":checked"))

            {

                $(".single_check").attr("checked", "checked");

                $(".attendance_data").removeAttr("disabled");

            } else

            {

                $(".single_check").removeAttr("checked");

                $(".attendance_data").attr("disabled", "disabled");

            }



        });

        $('.print_btn').click(function () {
            $(".fulllogs").removeClass("deactive_class");
            $(".logs").addClass("deactive_class");
            window.print();
        });

    });

    $(".single_check").live('click', function () {

        if ($(this).is(":checked"))

        {

            $(this).next().removeAttr("disabled");

        } else

        {

            $(this).next().attr("disabled", "disabled");

        }

    });

    $(".group_check,.single_check").live('click', function () {

        var count = 0;

        var total = 0;

        $(".single_check:checked").each(function () {

            count++;

        });

        if (count >= 1)

        {

            $("#add_attendance").css("display", "block");

        } else

        {

            $("#add_attendance").css("display", "none");

        }



        $(".single_check").each(function () {

            total++;

        });

        if (count < total)

        {

            $(".group_check").removeAttr("checked");

        }

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

</script>
<script>
    function datatable() {
        var table;
        table = jQuery('#basicTable_call_back').DataTable({
        });
        new $.fn.dataTable.FixedHeader(table);

    }
</script>
<script src="<?= $theme_path; ?>/js/fixedheader/jquery.dataTables.min.js"></script>