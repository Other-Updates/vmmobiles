<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<style>
.ui-datepicker td.ui-datepicker-today a {
     background:#999999;  
}
</style>
<div class="mainpanel">
    <div class="media mt--20">
        <h4 class="ml-25">Cash In Hand ( Company / Agent ) </h4>
    </div>
    <div class="contentpanel mb-50 mt--60">
         <?php  $user_info =$this->user_info=$this->session->userdata('user_info'); 
                             if($user_info[0]['role'] != 4) { ?>
        <table class="table table-striped table-bordered responsive no-footer dtr-inline search_table_hide">
            <tr>
                <td>
                    Cash In 
                    <select id='cah_option'  class="form-control" style="width: 170px;">
                        <option>Select</option>
                        <option value="company" selected>Company</option>
                        <option value="agent">Agent</option>
                    </select>
                </td>
                <td id='agent_td' style="display:none;">Agent
                    <input type="hidden" name="po_no" id="po_no" autocomplete="off" style="width:150px"/>
                    <select id='agent' style="width: 170px;" class="form-control">
                        <option>Select</option>
                        <?php
                        if (isset($all_agent) && !empty($all_agent)) {
                            foreach ($all_agent as $val) {
                                ?>
                                <option value='<?= $val['id'] ?>'><?= $val['name'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>                            
                <td>From Date</td>
                <td>
                    <div class="input-group" style="width:70%;">
                        <input type="text" id='from_date'  class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >

                    </div>
                </td>
                <td>To Date</td>
                <td>
                    <div class="input-group" style="width:70%;">
                        <input type="text"  id='to_date' class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >

                    </div>
                </td>
                <td align="center"><a  id='search' class="btn btn-success"><span class="glyphicon glyphicon-search "></span> Search</a></td>
            </tr>
        </table>
                             <?php }?>
        <div id='result_div'  class="panel-body">
        <div class="tabpad">
            <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                <thead>
                    <tr>
                        <td class="action-btn-align">S.No</td>                           
                        <td colspan="2">Source</td>
                        <td colspan="2">Receiver</td>                      
                        <td class="action-btn-align">Date</td>
                        <td>Type</td>
                        <td>Amount</td>
<!--                            <td>Cash in Hand Amount</td>-->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($amount) && !empty($amount)) {
                        $i = 1;
                        foreach ($amount as $val) {
                            ?>
                            <tr>
                                <td class='first_td action-btn-align'><?= $i ?></td>
                                <td><?= $val['receiver_type'] ?></td><td><?= $val['receipt_id'] ?></td>
                                <td><?= $val['recevier'] ?> </td><td><?= $val['name'] ?></td>
                                <td class="action-btn-align"><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td> 
                                <td><?= ucfirst($val['type']); ?></td>                                
                                <td  class="text_right total-bg"><?= number_format($val['bill_amount'], 2, '.', ',') ?></td>   
                            </tr>
                            
                        <?php
                        $i++;
                    }
                    }?>
                    
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text_right" colspan="7"><b>Cash in Hand/ Company</b></td>
                            <td class="text_right" ><?= number_format($company_amount, 2, '.', ',') ?></td>     
                        </tr>
                    </tfoot>
    <input type="hidden" value="<?php echo $this->session->userdata['user_info'][0]['id']; ?>" id="val" />
    <input type="hidden" value="<?php echo $this->session->userdata['user_info'][0]['role']; ?>" id="role" />
            </table>
            </div>
            <div class="action-btn-align mt-top15">
                <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                <button class="btn btn-success excel_btn"><span class="glyphicon glyphicon-print"></span> Excel</button>
            </div>
            
        </div>



        
    </div><!-- contentpanel -->

</div><!-- mainpanel -->


<script type="text/javascript">
    
    $(document).ready(function () {
        jQuery('.datepicker').datepicker();
        if($('#role').val() == 4 )
        {
        var val = $('#val').val();    
        jQuery('.datepicker').datepicker();
         $.ajax({
            url: BASE_URL + "report/search_cahsinhand",
            type: 'GET',
            data: {
                cah_option: $('#cah_option').val(),
                agent: val,
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val()
            },
            success: function (result) {
                for_response();
                $('#result_div').html(result);
            }
        });
         $('.print_btn').live('click', function () {             
            window.print();
        });
    }
    });
   
    $('#cah_option').change(function () {
        if ($(this).val() == 'agent')
        {
            $('#agent_td').css('display', 'block');
        } else
        {
            $('#agent_td').css('display', 'none');
        }
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
            url: BASE_URL + "report/search_cahsinhand",
            type: 'GET',
            data: {
                cah_option: $('#cah_option').val(),
                agent: $('#agent').val(),
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
<script>
    $('.print_btn').click(function () {
        window.print();
    });
</script>