<?php $theme_path = $this->config->item('theme_locations').$this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<style type="text/css">
.text_right
{
        text-align:right;
}
.box, .box-body, .content { padding:0; margin:0;border-radius: 0;}
#top_heading_fix h3 {top: -57px;left: 6px;}
#TB_overlay { z-index:20000 !important; }
#TB_window { z-index:25000 !important; }
.dialog_black{ z-index:30000 !important; }
#boxscroll22 {max-height: 291px;overflow: auto;cursor: inherit !important;} 
.auto-asset-search ul#country-list li:hover {
    background: #c3c3c3;
    cursor: pointer;
}
.auto-asset-search ul#product-list li:hover {
    background: #c3c3c3;
    cursor: pointer;
}
.auto-asset-search ul#country-list li {
    background: #dadada;
    margin: 0;
    padding: 5px;
    border-bottom: 1px solid #f3f3f3;
}
.auto-asset-search ul#product-list li {
    background: #dadada;
    margin: 0;
    padding: 5px;
    border-bottom: 1px solid #f3f3f3;
}
ul li {
    list-style-type: none;
}
.style{
    align-content: center;
    text-align: center;
}
 </style>
<div class="mainpanel mt-top40">
    <div class="col-md-12" style="align:center">
        <h4 class="style">Check Warranty Services</h4>
        <div class="style"> Reference Id :
                <select name='quotation[]' class="quotation style">
                            <option>Select</option>
                            <?php 
                                if(isset($job_id) && !empty($job_id))
                                {
                                    foreach($job_id as $val)
                                    {
                                        ?>
                                            <option value='<?php echo $val['id']?>' class="q_o" q_no="<?php echo $val['inv_id']?>"> <?php echo $val['inv_id']?></option>
                                        <?php
                                    }
                                }
                            ?>
                </select>
            </div>   
            <div id="service">

            </div>
    </div>
</div>
<script>  
   
    $(document).ready(function(){
       
        $('.quotation').live('change',function(){  
            
             $.ajaxPrefilter(function( options, original_Options, jqXHR ) {
                options.async = true;
            });
            if($(this).val()!='Select')	 
            {   
                var this_=$(this).closest('div').next('div');  
                var option = $('option:selected', this).attr('q_no');  
                 
                $.ajax({ 
                    url:BASE_URL+"service/get_invoice",
                    type:'GET', 
                    data:{
                            q_id:$(this).val(),
                            q_no:option
                      },
                    beforeSend: function() {
                        for_loading(' Warranty Services Loading...');
                    },

                    success:function(result){
                        for_response('Success...');                        
                        $('#service').html(result);  
                        
                    }    
                });                
            }
        });
       // xml.async = "false";
    });
           
</script>
