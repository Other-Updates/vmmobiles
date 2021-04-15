<style type="text/css">
    .error_msg, em{color: rgb(255, 0, 0); font-size: 12px;font-weight: normal;}
</style>

<div class="mainpanel">
    <div class="contentpanel mb-45">
        <div class="media">
            <h4>Daily Task Report &nbsp;</h4>
        </div>
        <form  method="post"  class="panel-body" id="quotation">
            <div class="row" >
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Task Name <span style="color:#F00; font-style:oblique;">*</span></label>
                        <div class="col-sm-8">
                            <input type="text"   name="task[task_name]" id="task_name" class='form-control form-align  required' />
                            <span class="error_msg"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Date<span style="color:#F00; font-style:oblique;">*</span></label>
                        <div class="col-sm-8">
                            <input type="text"   name="task[date]" id="date" class='form-control form-align  required' />
                            <span class="error_msg"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Status</label>
                        <div class="col-sm-8">
                            <input type="text"   name="task[status]" id="status" class='form-control form-align  required'/>
                            <span class="error_msg"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mscroll">
                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline text-center"id="task_table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th style="text-align: center;">Employee Name</th>
                            <th style="text-align: center;">Date</th>
                            <th style="text-align: center;">Task</th>
                            <th style="text-align: center;">Status</th>
                            <th style="width: 10%;"><a href="javascript:void(0);" class="btn btn-success form-control add_task"><span class="glyphicon glyphicon-plus"></span></a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="s_no">1</td>
                            <td><input type="text" name="name[]" class="form-control task"></td>
                            <td><input type="text" name="date[]" class="form-control task"></td>
                            <td><input type="text" name="task[]" class="form-control task"></td>
                            <td><input type="text" name="status[]" class="form-control task"></td>
                            <td class="center">
                                <a href="javascript:void(0);" class="btn btn-danger btn-xs delete_task"><span class="glyphicon glyphicon-trash"></span></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </form>
    </div>
</div>
<table class="task_clone_tab" style="display:none;">
    <tr class="task_clone_tr">
        <td class="s_no">1</td>
        <td><input type="text" name="name[]" class="form-control task"></td>
        <td><input type="text" name="date[]" class="form-control task"></td>
        <td><input type="text" name="task[]" class="form-control task"></td>
        <td><input type="text" name="status[]" class="form-control task"></td>
        <td class="center">
            <a href="javascript:void(0);" class="btn btn-danger btn-xs delete_task"><span class="glyphicon glyphicon-trash"></span></i></a>
        </td>
    </tr>
</table>
<script type="text/javascript">
    $(document).ready(function () {
        $('.add_task').click(function () {

            $('.task_clone_tab').show();
            clone_ele = '';
            clone_ele = $('.task_clone_tr').clone();
            $('.task_clone_tab').hide();
            clone_ele.removeClass('task_clone_tr');
            clone_ele.find('input.task').removeAttr('disabled');
            $('#task_table tbody').append(clone_ele);
            var v = 1;
            $('#task_table td.s_no').each(function () {
                $(this).html(v);
                v++;
            });
        });
        $(document).on('click', '.delete_task', function () {
            $(this).closest('tr').remove();
            var v = 1;
            $('#task_table td.s_no').each(function () {
                $(this).html(v);
                v++;
            });
        });
    });
</script>

