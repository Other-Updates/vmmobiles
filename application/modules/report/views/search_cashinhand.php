<table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
    <thead>
                    <tr>
                        <td class="action-btn-align">S.No</td>                           
                        <td colspan="2">Source</td>
                        <td colspan="2">Receiver</td>                      
                        <td>Date</td>
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
                                <td><?= $val['receiver_type'] ?></td><td><?=$val['receipt_id'] ?></td>
                                <td><?= $val['recevier'] ?> </td><td><?= $val['name'] ?></td>
                                <td><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td> 
                                <td><?= ucfirst($val['type']); ?></td>                                
                                <td  class="text_right"><?= number_format($val['bill_amount'], 2, '.', ',') ?></td>   
                            </tr>
                            
                        <?php
                        $i++;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                        <tr>
                          <?php  $user_info =$this->user_info=$this->session->userdata('user_info'); 
                             if($user_info[0]['role'] != 4) { ?>
                            <td class="text_right" colspan="7"><b>Cash in Hand/ Agent</b></td>
                            <td class="text_right total-bg"><?= number_format($company_amount, 2, '.', ',') ?></td>   
                             <?php }?>
                        </tr>
                    </tfoot>
    <?php
    } else {
        ?>
            <tr><td colspan="8">No data found...</td></tr>
            <?php
        }
    ?>


</table>
<div class="action-btn-align mt-top15">
    <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
    <button class="btn btn-success excel_btn"><span class="glyphicon glyphicon-print"></span> Excel</button>
</div>