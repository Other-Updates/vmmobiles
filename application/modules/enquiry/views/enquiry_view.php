<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>

<div class="mainpanel">
    <div class="media marbot">
        <h4 class="hide_class">View Enquiry</h4>
    </div>
    <!--<div class="pageheader">
        <div class="media">
            <div class="pageicon pull-left">
                <i class="fa fa-question iconen"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                    <li>Home</li>
                    <li>View</li>
                </ul>
                <h4>Enquiry</h4>
            </div>
        </div>
    </div>-->

    <div class="contentpanel enquiryview  ptpb-10">

        <div class="tab-content1 tabpad1 " style="width:98%;">
            <!--<h4 align="center" class="sup-align">View Enquiry</h4>-->
            <?php
            if (isset($all_enquiry) && !empty($all_enquiry)) {
                foreach ($all_enquiry as $val) {
                    ?>

           <!-- <h5 class="ml-230"><b> Enquiry Number :  </b> <?php echo $val['enquiry_no']; ?>  </h5>
            <h5 class="ml-230"><b>Customer Name : </b> <?php echo $val['customer_name']; ?>  </h5> 
            <h5 class="ml-230"><b>Customer Address : </b> <?php echo $val['customer_address']; ?>  </h5> -->
                    <table class="table table-striped table-bordered responsive no-footer dtr-inline twidth-65 ">
                        <tr>
                            <td><span  class="tdhead">TO,</span>
                                <div><?php echo $val['customer_address']; ?> </div>
                            </td>
                            <td>  </td>
                            <td class="action-btn-align"> <img src="<?= $theme_path; ?>/images/Logo1.png" alt="Chain Logo" style="width:125px;"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><span  class="tdhead">Enquiry Number:</span></td>
                            <td><?php echo $val['enquiry_no']; ?> </td>
                            <td><span  class="tdhead">Customer Name:</span> </td>
                            <td><?php echo $val['customer_name']; ?></td>
                        </tr>
                        <tr>
                            <td><span  class="tdhead">Enquiry_About:</span></td>
                            <td> <?php echo $val['enquiry_about']; ?> </td>
                            <td><span  class="tdhead">Customer Email:</span></td>
                            <td><?php echo $val['customer_email']; ?></td>
                        </tr>
                        <tr>
                            <td><span  class="tdhead">Contact Number:</span></td>
                            <td><?php echo $val['contact_number']; ?></td>
                            <td><span  class="tdhead">Remarks:</span> </td>
                            <td><?php echo $val['remarks']; ?></td>

                        </tr>
                    </table>


                <?php }
            }
            ?>
            <div class="action-btn-align mt10">
                <button class="btn btn-defaultprint6 print_btn "><span class="glyphicon glyphicon-print"></span> Print</button>
                <a href="<?php echo $this->config->item('base_url') . 'enquiry/enquiry_list/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
            </div>
        </div>

        <script>
            $('.print_btn').click(function () {
                window.print();
            });
        </script>
    </div><!-- contentpanel -->
</div><!-- mainpanel -->
