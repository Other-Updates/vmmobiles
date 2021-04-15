<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>

<!--<script type="text/javascript" src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js"></script> -->

<script type="text/javascript" src="<?php echo $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>

<style type="text/css">

    .td-pad { padding:6px; }

</style>

<div class="mainpanel">

    <div class="media"></div>

    <div class="contentpanel mb-50">

        <div class="media mt--2">

            <h4>User Role Permissions (<?php echo $user_role[0]['user_role']; ?>)</h4>

        </div>

        <div class="panel-body">

            <?php echo form_open_multipart('masters/user_roles/user_permissions/' . $user_role_id, 'name="user_permission" id="user_permission" class="form-horizontal"'); ?>

            <input type="hidden" name="user_role_id" id="user_role_id" value="<?php echo $user_role_id; ?>">

            <div class="row">

                <div class="form-group">

                    <div class="checkbox" style="float:right; margin-right: 15px;">

                        <label>

                            <input type="checkbox" name="grand_all" class="grand_all" value="1" <?php echo (isset($user_role[0]['grand_all']) && $user_role[0]['grand_all'] == 1) ? 'checked' : ''; ?>><span class="text-semibold">Grand All</span>

                        </label>

                    </div>

                </div>

            </div>

            <fieldset class="content-group">

                <div class="table-responsive">

                    <table class="table table-bordered table-striped table-hover">

                        <thead>

                            <tr>

                                <th>Module</th>

                                <th>Section</th>

                                <th>Enable Menu</th>

                                <th>View</th>

                                <th>Add</th>

                                <th>Edit</th>

                                <th>Delete</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            if (!empty($user_sections)) {


                                foreach ($user_sections as $key => $value) {

                                    if (!empty($value['sections'])) {

                                        $k = 1;

                                        foreach ($value['sections'] as $section) {

                                            if (($section['user_section_key'] == 'user_modules') || ($section['user_section_key'] == 'user_sections') || (!in_array($section['user_section_key'], array('user_modules', 'user_sections')))) {

                                                $checked_all = (isset($user_permissions[$key][$section['id']]['acc_all']) && $user_permissions[$key][$section['id']]['acc_all'] == 1) ? 'checked' : '';

                                                $checked_view = (isset($user_permissions[$key][$section['id']]['acc_view']) && $user_permissions[$key][$section['id']]['acc_view'] == 1) ? 'checked' : '';

                                                $checked_add = (isset($user_permissions[$key][$section['id']]['acc_add']) && $user_permissions[$key][$section['id']]['acc_add'] == 1) ? 'checked' : '';

                                                $checked_edit = (isset($user_permissions[$key][$section['id']]['acc_edit']) && $user_permissions[$key][$section['id']]['acc_edit'] == 1) ? 'checked' : '';

                                                $checked_delete = (isset($user_permissions[$key][$section['id']]['acc_delete']) && $user_permissions[$key][$section['id']]['acc_delete'] == 1) ? 'checked' : '';

                                                ?>

                                                <tr class="danger">

                                                    <td><strong><?php echo ($k == 1) ? ucfirst($value['user_module_name']) : ''; ?></strong></td>

                                                    <td><?php echo ucfirst($section['user_section_name']); ?></td>

                                                    <td><input type="checkbox" name="permissions[<?php echo $key; ?>][<?php echo $section['id']; ?>][acc_all]" class="menu_all" value="1" <?php echo $checked_all; ?> /></td>

                                                    <?php if ($section['acc_view'] == 1): ?>

                                                        <td><input type="checkbox" name="permissions[<?php echo $key; ?>][<?php echo $section['id']; ?>][acc_view]" class="allow_access" value="1" <?php echo $checked_view; ?> /></td>

                                                    <?php endif; ?>

                                                    <?php if ($section['acc_view'] == 0): ?>

                                                        <td>NA</td>

                                                    <?php endif; ?>

                                                    <?php if ($section['acc_add'] == 1): ?>

                                                        <td><input type="checkbox" name="permissions[<?php echo $key; ?>][<?php echo $section['id']; ?>][acc_add]" class="allow_access" value="1" <?php echo $checked_add; ?> /></td>

                                                    <?php endif; ?>

                                                    <?php if ($section['acc_add'] == 0): ?>

                                                        <td>NA</td>

                                                    <?php endif; ?>

                                                    <?php if ($section['acc_edit'] == 1): ?>

                                                        <td><input type="checkbox" name="permissions[<?php echo $key; ?>][<?php echo $section['id']; ?>][acc_edit]" class="allow_access" value="1" <?php echo $checked_edit; ?> /></td>

                                                    <?php endif; ?>

                                                    <?php if ($section['acc_edit'] == 0): ?>

                                                        <td>NA</td>

                                                    <?php endif; ?>

                                                    <?php if ($section['acc_delete'] == 1): ?>

                                                        <td><input type="checkbox" name="permissions[<?php echo $key; ?>][<?php echo $section['id']; ?>][acc_delete]" class="allow_access" value="1" <?php echo $checked_delete; ?> /></td>

                                                    <?php endif; ?>

                                                    <?php if ($section['acc_delete'] == 0): ?>

                                                        <td>NA</td>

                                                    <?php endif; ?>

                                                </tr>

                                                <?php

                                                $k++;

                                            }

                                        }

                                    }

                                }

                            }

                            ?>

                        </tbody>

                    </table>

                </div>

            </fieldset>

            <div class="row">

                <div class="col-md-12">

                    <button type="button" class="btn btn-defaultback" onclick="window.location = '<?php echo base_url('masters/user_roles'); ?>'" style="float:left;"><i class="icon-arrow-left13 position-left"></i> Cancel</button>

                    <button type="submit" class="btn btn-success submit" style="float:right;">Submit <i class="icon-arrow-right14 position-right"></i></button>

                </div>

            </div>

            <?php echo form_close(); ?>

        </div>

    </div>

</div>

<script type="text/javascript">

    $(document).ready(function () {

        $('.menu_all').click(function () {

            if ($(this).prop('checked') == true) {

                $(this).closest('tr').find('input.allow_access').prop('checked', true);

            } else {

                $(this).closest('tr').find('input.allow_access').removeAttr('checked');

            }



            total_checkbox = Number($('input[type=checkbox].allow_access,input[type=checkbox].menu_all').length);

            checked_checkbox = Number($('input[type=checkbox].allow_access:checked,input[type=checkbox].menu_all:checked').length);

            if (total_checkbox == checked_checkbox) {

                $('input.grand_all').prop('checked', true);

            } else {

                $('input.grand_all').removeAttr('checked');

            }





        });



        $('.grand_all').click(function () {

            if ($(this).prop('checked') == true) {

                $('input.allow_access,input.menu_all').prop('checked', true);

            } else {

                $('input.allow_access,input.menu_all').removeAttr('checked');

            }

        });



        $('.allow_access').click(function () {

            length = Number($(this).closest('tr').find('input.allow_access:checked').length);

            if (length == 4) {

                $(this).closest('tr').find('input.menu_all').prop('checked', true);

            } else {

                $(this).closest('tr').find('input.menu_all').removeAttr('checked');

            }

            total_checkbox = Number($('input[type=checkbox].allow_access,input[type=checkbox].menu_all').length);

            checked_checkbox = Number($('input[type=checkbox].allow_access:checked,input[type=checkbox].menu_all:checked').length);

            if (total_checkbox == checked_checkbox) {

                $('input.grand_all').prop('checked', true);

            } else {

                $('input.grand_all').removeAttr('checked');

            }

            if (length >= 1) {

                $(this).closest('tr').find('input.menu_all').prop('checked', true);

            } else {

                $(this).closest('tr').find('input.menu_all').removeAttr('checked');

            }

        });

    });

</script>