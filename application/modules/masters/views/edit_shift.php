<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?><script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script><script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script><script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script><link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" /><link rel="stylesheet" href="<?= $theme_path ?>/css/jquery-ui-theme.css" type="text/css" /><link rel="stylesheet" href="<?= $theme_path ?>/css/jquery.ui.timepicker.css" type="text/css" /><script type="text/javascript" src="<?= $theme_path; ?>/js/department.js"></script><style>    .req { color:#FF0000; }</style><div class="contentinner">    <div class="media mt--20">        <h4 class="widgettitle">Shift Edit </h4>    </div>    <div class="widgetcontent">        <?php        $result = validation_errors();        if (trim($result) != ""):            ?>            <div class="alert alert-error">                <button data-dismiss="alert" class="close" type="button">&times;</button>                <?php echo implode("</p>", array_unique(explode("</p>", validation_errors()))); ?>            </div>        <?php endif; ?>        <?php        $attributes = array('class' => 'stdform editprofileform', 'method' => 'post');        echo form_open('', $attributes);        ?>        <p><?php echo form_label('Shift Name <span class="req">*</span>'); ?>            <span class="field">                <?php                $data = array(                    'name' => 'shift[name]',//                     'value' => isset($_POST['save']) ? $post['reason'] : $holiday[0]['reason'],                    'value' => isset($_POST['save']) ? set_value('shift[name]') : $shift[0]["name"],                    'class' => 'required alphabet',                );                echo form_input($data);                ?>            </span>        </p>        <div class="panel-body mt-top5">            <div class="scroll_bar">                <table class="table table-bordered shift_table">                    <thead>                        <tr>                            <th>S no</th>                            <?php                            //print_r($users);                            $head = array("Type", "From <span class='req'>*</span>", "To <span class='req'>*</span>");                            foreach ($head as $ele) {                                echo "<th  class='center'>" . $ele . "</th>";                            }                            ?>                            <th class="center"><a href="javascript:void(0);" class="btn btn-danger add_row">+</th>                        </tr>                    </thead>                    <tbody>                        <?php                        if (!isset($s_length)):                            $s_length = count($shift);                        endif;                        for ($len = 0; $len < $s_length; $len++) {                            $class = "";                            if ($len == 0) {                                $class = "to_clone";                            }                            ?>                            <tr class="<?= $class ?>">                                <td class="center sno"><?= $len + 1 ?></td>                                <td  class="center"><?php                                    $options = array(                                        '' => 'Select',                                        'forenoon' => 'Forenoon',                                        'break' => 'Break',                                        'lunch' => 'Lunch',                                        'afternoon' => 'Afternoon'                                    );                                    if ($len == 0) {//                                        $options["regular"] = "Regular";////                                        $prop = 'class="required select_shift_no_chng" ';//                                    } else {                                        $prop = 'class="required select_shift" ';                                    }                                    if (isset($_POST['save']))                                        $default = set_value('shift[type][]');                                    else                                        $default = $shift[$len]['type'];                                    echo form_dropdown('shift[type][]', $options, $default, $prop);                                    ?> </td>                                <td class="center">                                    <?php                                    $data = array(                                        'name' => 'shift[from_time][]',                                        'value' => isset($_POST['save']) ? set_value('shift[from_time][]') : $shift[$len]["from_time"],                                        'class' => 'required from_time',                                        'readonly' => 'readonly'                                    );                                    echo form_input($data);                                    ?>                                </td>                                <td class="center">                                    <?php                                    $data = array(                                        'name' => 'shift[to_time][]',                                        'value' => isset($_POST['save']) ? set_value('shift[to_time][]') : $shift[$len]["to_time"],                                        'class' => 'required to_time',                                        'readonly' => 'readonly'                                    );                                    echo form_input($data);                                    ?>                                </td>                                <?php                                if ($len == 0)                                    $style = "visibility:hidden;";                                else                                    $style = "visibility:visible;";                                ?>                                <td class="center"><a href="javascript:void(0);" class="btn btn-danger remove_row" style="<?php echo $style; ?>">-</td>                            </tr>                        <?php }                        ?>                    </tbody>                </table>            </div>            <div class="action-btn-align">                <?php                $data = array(                    'name' => 'save',                    'value' => 'Update',                    'class' => 'btn btn-info border4 submit',                    'title' => 'Update'                );                echo form_submit($data);                $url = $this->config->item('base_url') . "masters/biometric/shifts/";                if (isset($_GET["page"]))                    $url = $this->config->item('base_url') . "masters/biometric/view_shift/" . $shift[0]['id'];                ?>                <a href="<?= $this->config->item('base_url') . "masters/biometric/shifts/" ?>"  title="Cancel"><input type="button" class="btn btn-danger border4" value="Cancel" /></a>            </div>        </div>    </div></div><script type="text/javascript">    $(document).ready(function () {<?php if (isset($attendance) && !empty($attendance)) { ?>            alert("Current Month attendance already added for this User. Go to attendance edit for modify the attendance details")<?php } ?>    });</script><script type="text/javascript">    function removejscssfile(filename, filetype) {        var targetelement = (filetype == "js") ? "script" : (filetype == "css") ? "link" : "none" //determine element type to create nodelist from        var targetattr = (filetype == "js") ? "src" : (filetype == "css") ? "href" : "none" //determine corresponding attribute to test for        var allsuspects = document.getElementsByTagName(targetelement)        for (var i = allsuspects.length; i >= 0; i--) { //search backwards within nodelist for matching elements to remove            if (allsuspects[i] && allsuspects[i].getAttribute(targetattr) != null && allsuspects[i].getAttribute(targetattr).indexOf(filename) != -1)                allsuspects[i].parentNode.removeChild(allsuspects[i]) //remove element by calling parentNode.removeChild()        }    }    removejscssfile("<?= $theme_path; ?>/css/jquery-ui-timepicker-addon.min.css", "css")    removejscssfile("<?= $theme_path; ?>/js/jquery-ui-timepicker-addon.min.js", "js")    $(".remove_row").live('click', function () {        $(this).closest("tr").remove();        tr = $("tbody").children("tr");        $(tr).each(function (i) {            $(this).find("td.sno").text(i + 1);        });    });</script><script type="text/ecmascript" src="<?= $theme_path ?>/js/jquery.ui.timepicker.js"></script>