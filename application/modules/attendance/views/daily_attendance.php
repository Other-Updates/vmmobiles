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
    .req {
        color: #FF0000;
    }
</style>
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

            <table  id="basicTable_call_back" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">

                <thead>

                    <tr>

<!--                        <th class="action-btn-align">Department &nbsp; <?php
//                            $default = '';
//
//                            if (isset($filter["department"]) && !empty($filter["department"])) {
//
//                                $default = $filter["department"];
//                            }
//
//                            $options = array();
//
//                            if (isset($departments) && !empty($departments)) {
//
//                                foreach ($departments as $dept) {
//
//                                    $options[$dept["dept_id"]] = ucwords($dept["dept_name"]);
//                                }
//                            }
                        //   echo form_multiselect('department[]', $options, $default, 'class="multiselect" id="department_select"');
                        ?></th>-->

<!--                        <th class="action-btn-align" id ="designation">Designation &nbsp; <?php
//                        $default = '';
//
//                        if (isset($filter["designation"]) && !empty($filter["designation"])) {
//
//                            $default = $filter["designation"];
//                        }
//
//                        $options = array();
//
//                        if (isset($designations) && !empty($designations)) {
//
//                            foreach ($designations as $des) {
//
//                                $options[$des["id"]] = ucwords($des["name"]);
//                            }
//                        }
//
//                        echo form_multiselect('designation[]', $options, $default, 'class="multiselect" id="designation_select"');
                        ?></th>-->

                        <!--<th class="action-btn-align">Shift <span class="req">*</span>&nbsp;-->

                        <?php
//                            $default = '';
//
//                            if (isset($filter["shift"]) && !empty($filter["shift"])) {
//
//                                $default = $filter["shift"];
//                            }
//
//                            $options = array('' => 'Select Shift');
//
//                            if (isset($shifts) && !empty($shifts)) {
//
//                                foreach ($shifts as $shf) {
//
//                                    $options[$shf["id"]] = ucwords($shf["name"]);
//                                }
//                            }
//
//                            //echo form_multiselect('shift[]',$options,$default,'class="multiselect" id="shift" ');
//
//                            echo form_dropdown('shift[]', $options, $default, 'id="shift" class="uniformselect"');
                        ?>

                        <!--</th>-->

                        <!--<th class="action-btn-align">Salary Group &nbsp;-->

                        <?php
//                            $default = '';
//
//                            if (isset($filter["salary_group"]) && !empty($filter["salary_group"])) {
//
//                                $default = $filter["salary_group"];
//                            }
//
//                            $options = array();
//
//                            if (isset($salary_groups) && !empty($salary_groups)) {
//
//                                foreach ($salary_groups as $sg) {
//
//                                    $options[$sg["id"]] = ucwords($sg["name"]);
//                                }
//                            }
//
//                            echo form_multiselect('salary_group[]', $options, $default, 'class="multiselect" ');
                        ?>

                        <!--</th>-->

                        <th class="action-btn-align">Date <span class="req">*</span>&nbsp;

                            <?php
                            $default = '';

                            if (isset($filter["start_date"]) && $filter["start_date"] != "") {

                                $default = date("d-m-Y", strtotime($filter["start_date"]));
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

                            <a href="javascript:void(0)" style="float:right" title="Reset"><input type="button" class="btn btn-danger border4 reset" value="Reset"></a>

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

//                echo "Show " . form_dropdown('record_show', $options, $count, "id='count_change'") . " entries";
            }
            ?>

            <div class="scroll_bar">

                <?php
                $attributes = array('class' => 'attendance_data_form', 'method' => 'post');

                echo form_open('', $attributes);
                ?>

                <table  id="basicTable_call_back" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">

                    <thead>

                        <?php
//print_r($shifts);
//                        $head = array("S.No", "Employee Id", "Username", "Employee Name", "Department", "Designation", "Email");
//
//                        $db_name = array("id", "emp_id", "username", "first_name", "dept_name", "des_name", "email");
                        ?>

                        <tr>

                            <td class="action-btn-align">S.No</td>
                            <td class="action-btn-align">Employee Id</td>
                            <td class="action-btn-align">Username</td>
                            <td class="action-btn-align">Employee Name</td>
                            <td class="action-btn-align">Department</td>
                            <td class="action-btn-align">Designation</td>
                            <td class="action-btn-align">Email</td>

                            <?php
                            $i = 0;

                            $id_sort = 0;

                            //print_r($head);

                            $filter = array();

                            foreach ($head as $ele) {

                                $elem_class = $elem_id = "";

                                if (isset($filter["sort"])) {

                                    if ($db_name[$i] == $filter["sort"]) {

                                        $elem_class = "class='sort' ";

                                        $elem_id = "id='" . $filter["order"] . "' ";

                                        if ($filter["sort"] == "id" && $filter["order"] == "desc")
                                            $id_sort = 1;
                                    }
                                }

                                echo "<th " . $elem_class . $elem_id . " data='" . base64_encode($db_name[$i++]) . "'>" . $ele . "</th>";
                            }

                            if (isset($status)) {

                                echo "<th>Status</th>";
                            }

                            if ($id_sort == 1)
                                $s = count($no_of_users1) - $start;
                            else
                                $s = $start + 1;
                            ?>

                            <?php //if (in_array("attendance:add_attendance_for_day", $user_role) && isset($users) && !empty($users)) {                     ?>

                            <th class="hide_class action-btn-align">

                                <?php
                                echo "<span id='action'>Action</span>";

                                $data = array(
                                    "class" => "required group_check",
                                    "checked" => FALSE
                                );

                                echo form_checkbox($data);
                                ?>

                            </th>

                            <?php //}                     ?>

                        </tr>

                    </thead>



                    <tbody>

                        <?php
//                        echo '<pre>';
//                        print_r($no_of_users1);
//                        exit;
                        if (isset($no_of_users1)) {

                            if (isset($add_attendance_users) && !empty($add_attendance_users)) {

                                $exist = 0;

                                $enter_count = 0;

                                foreach ($add_attendance_users as $user) {

                                    $class = "";

                                    $this->load->model('masters/user_shift_model');

                                    $this->load->model('masters/user_salary_model');

                                    $current_shift = $this->user_shift_model->get_user_current_shift_by_user_id($user["id"], null);
//                                    print_r($current_shift);
//                                    exit;
                                    $salary_group = $this->user_salary_model->get_user_salary_by_user_id($user["id"]);

                                    if ($user["dept_name"] == "" || $user["des_name"] == "" || empty($current_shift) || empty($salary_group)) {

                                        $class = "in-complete";

                                        $exist = 1;
                                    }
                                    ?>

                                    <tr class="<?= $class ?>">

                                        <?php
                                        $attendance_data = array("user_id" => $user["id"], "username" => $user["username"]);
                                        ?>

                                        <td class="first_td action-btn-align"><?php echo $id_sort == 1 ? $s-- : $s++; ?></td>

                                        <td class="action-btn-align"><?= $user["employee_id"] ?></td>

                                        <td class="action-btn-align"><?= ucwords($user['username']) ?></td>

                                        <td class="action-btn-align"><?= ucwords($user['first_name']) . " " . ucwords($user['last_name']) ?></td>

                                        <td class="action-btn-align"><?= ucwords($user["department"]) ?></td>

                                        <td class="action-btn-align"><?= ucwords($user["designation"]) ?></td>

                                        <td class="action-btn-align"><?= $user['email'] ?></td>

                                        <?php
                                        //if (in_array("attendance:add_attendance_for_day", $user_role)) {
                                        ?>

                                        <td class="hide_class action-btn-align">

                                            <?php
                                            if (isset($user_attendance) && !empty($user_attendance)) {

                                                foreach ($user_attendance as $today_attendance) {

                                                    $user_id_list[] = $today_attendance["user_id"];
                                                }
                                            }


                                            if (isset($user_id_list) && !empty($user_id_list)) {

                                                if (!in_array($user["id"], $user_id_list)) {


                                                    $enter_count++;

                                                    $data = array(
                                                        "value" => $user["id"],
                                                        "class" => "required single_check",
                                                        "checked" => FALSE
                                                    );

                                                    echo form_checkbox($data);

                                                    echo "<input type='hidden' disabled='disabled'  class = 'attendance_data' name='attendance_data[" . $user["id"] . "]' value='" . json_encode($attendance_data) . "'>";
                                                    ?>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <!--<a title="Add" href="<?= $this->config->item('base_url') . "attendance/add_attendance_for_day/" . $user["id"] ?>" class="btn btn-danger btn-rounded">

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <i class="icon icon-plus"></i></a>-->

                                                    <?php
                                                } else {
                                                    ?>

                                                    <i class="icon-thumbs-up"  title="Processed"></i>

                                                    <?php
                                                }
                                            } else {

                                                $enter_count++;



                                                $data = array(
                                                    "value" => $user["id"],
                                                    "class" => "required single_check",
                                                    "checked" => FALSE
                                                );

                                                echo form_checkbox($data);

                                                echo "<input type='hidden' disabled='disabled'  class = 'attendance_data' name='attendance_data[" . $user["id"] . "]' value='" . json_encode($attendance_data) . "'>";
//                                                echo test;
//                                                exit;
                                                ?>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <!--<a title="Add" href="<?= $this->config->item('base_url') . "attendance/add_attendance_for_day/" . $user["id"] ?>" class="btn btn-danger btn-rounded">

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <i class="icon icon-plus"></i></a>-->

                                                <?php
//
                                            }
                                            ?>

                                        </td>

                                        <?php //}                          ?>

                                    </tr>

                                    <?php
                                }
                            } else {

//                                if (in_array("attendance:add_attendance_for_day", $user_role) && isset($users) && !empty($users)) {
//                                    echo "<tr><td colspan='8'>No Records Found</td></tr>";
//                                } else {

                                echo "<tr><td colspan='7'>No Records Found</td></tr>";
                            }
                            // }
                        } else {

                            $enter_count = 0;

                            echo "<tr><td colspan='8'>Please select date</td></tr>";
                        }
                        ?>



                    </tbody>

                </table>

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
            ?>







            <div class="button_right_align">

                <?php
                if (isset($links) && $links != NULL)
                    echo $links;
                ?><br />

                <a href="javascript:void(0);">

                    <input type="submit" class="btn btn-success btn-rounded"  onclick="daily_attend()" value="Add Attendance"  name ="add_attendance" style="display:none; float:right;" id="add_attendance"/>

                </a>

            </div>



        </div>



    </div>
</div>
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

            $.ajax({
                url: BASE_URL + "attendance/check_manual_attendance",
                type: "POST",
                success: function (res)
                {

                    if (res == 1)
                    {
                        $("#add_attendance").css("display", "block");
                    } else {
                        alert("Manual attenance entry not active");
                    }

                }

            });


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

//        var shift = $("#shift").val();
        var start_date = $("#start_date").val();

//        if (shift == '' || shift == 'Select Shift' && start_date == '')
//        {
//            alert("Please select Shift and Date");
//            return false;
//        }
//
//        if (shift == '' || shift == 'Select Shift')
//        {
//            alert("Please select Shift");
//            return false;
//        }

        if (start_date == '')
        {
            alert("Please select Date");
            return false;
        }

    });




</script>