<?php
        if (isset($brand) && !empty($brand)) {
            foreach ($brand as $val) {
                ?>

                <div id="test1_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                    <div class="modal-dialog">
                        <div class="modal-content modalcontent-top">
                            <div class="modal-header modal-padding modalcolor"><a class="close modal-close closecolor" data-dismiss="modal">×</a>
                                <h3 id="myModalLabel" style="color:white;margin-top:10px">Update Model</h3>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <table class="table" width="60%">
                                        <tr>
                                            <td><input type="hidden" name="id" class="id form-control id_update" id="id" value="<?php echo $val["id"]; ?>" readonly="readonly" /></td>
                                        </tr>
                                        <tr>
                                            <td width="12%"><b>Shop</b></td>
                                            <td width="18%">
                                                <div class="">
                                                    <select name="firm_id"  class="form-control form-align required firm firm<?php echo $val['id']; ?>" id="firm" onchange="Firm(this.value)">
                                                        <option value="">Select Shop</option>
                                                        <?php
                                                        if (isset($firms) && !empty($firms)) {
                                                            foreach ($firms as $firm) {
                                                                $select = ($firm['firm_id'] == $val['firm_id']) ? 'selected' : '';
                                                                ?>
                                                                <option value="<?php echo $firm['firm_id']; ?>" <?php echo $select; ?>> <?php echo $firm['firm_name']; ?> </option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <span id="firmerr" class="val firmerr<?php echo $val['id']; ?>"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width="12%"><b>Category</b></td>
                                            <td width="18%">
                                                <div class="">
                                                    <select name="Category_Id"  class="form-control <?php echo $val['cat_id']; ?> form-align cat_id<?php echo $val['id']; ?>" id="cat_id" >
                                                        <option value="">Select Category</option>
                                                        <?php
                                                        if (isset($category) && !empty($category)) {
                                                            foreach ($category as $cat_data) {
                                                                if ($cat_data['cat_id'] == $val['cat_id']) {
                                                                    $select = "selected=selected";
                                                                } else {
                                                                    $select = '';
                                                                }
                                                                ?>
                                                                <option <?php echo $select; ?> value="<?php echo $cat_data['cat_id']; ?>" > <?php echo $cat_data['categoryName']; ?> </option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <span id="caterr" class="val caterr<?php echo $val['id']; ?>"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><strong>Model Name</strong></td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="brand form-control colornameup colornamecup brandnameup borderra0 form-align brandname<?php echo $val['id']; ?>" name="brands"
                                                           value="<?php echo $val["brands"]; ?>" id="colornameup" maxlength="40" /><input type="hidden" class="root1_h"  value="<?php echo $val["brand"]; ?>"  />
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-fa"></i>
                                                    </div>
                                                </div>
                                                <span id="cnameerrorup" class="cnameerrorup<?php echo $val['id']; ?>" style="color:#F00; font-style:italic;"></span>
                                                <span id="dupup" class="dupup dupup<?php echo $val['id']; ?>" style="color:#F00; font-style:italic;"></span>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                            <div class="modal-footer action-btn-align">
                                <button type="button" class="edit btn btn-info1"  onclick="edit_update(<?php echo $val['id']; ?>)" id="edit_brand">Update</button>
                                <button type="reset" class="btn btn-danger1 "  id="no" data-dismiss="modal"> Discard</button>
                            </div>
                        </div>
                    </div>
                </div>


                <script type="text/javascript">
                    $('.brandnamecup').on('change', function ()
                    {
                        var cname = $(this).parent().parent().find(".$brandnamecup").val();
                        //var sname=$('.style_nameup').val();
                        var m = $(this).offsetParent().find('.cnameerrorup');
                        if (cname == '' || cname == null || cname.trim().length == 0)
                        {
                            m.html("Required Field");
                        } else
                        {
                            m.html("");
                        }
                    });
                    $(document).ready(function ()
                    {
                        $('#no').on('click', function ()
                        {
                            var root_h = $(this).parent().parent().parent().find('.root1_h').val();
                            $(this).parent().parent().find('.brandnameup').val(root_h);
                            var m = $(this).offsetParent().find('.cnameerrorup');
                            var message = $(this).offsetParent().find('.dupup');
                            //var message=$(this).parent().parent().find('.dupup').html();
                            m.html("");
                            message.html("");
                        });
                    });
                </script>
                <script type="text/javascript">
                    $(".brandnameup").on('blur', function ()
                    {
                        //alert("hi");
                        var cname = $.trim($(this).parent().parent().find('.brandnameup').val());
                        var id = $(this).offsetParent().find('.id_update').val();
                        var message = $(this).offsetParent().find('.dupup');
                        $.ajax(
                                {
                                    url: BASE_URL + "masters/brands/update_duplicate_brandname",
                                    type: 'get',
                                    data: {value1: cname, value2: id},
                                    success: function (result)
                                    {
                                        message.html(result);
                                    }
                                });
                    });
                </script>
                <?php
            }
        }
        ?>

<script type="text/javascript">
    // $("#edit_brand").on("click", function ()
    function  edit_update(id)
    {

        var cname = $.trim($(this).parent().parent().find('.brandnameup').val());
        var cat_id = $.trim($(this).parent().parent().find('.cat_id').val());
        var ids = $(this).offsetParent().find('.id_update').val();
        var ids = id;
        var firm = $(this).parent().parent().find("firm").val();
        var message = $(this).offsetParent().find('.dupup');

        var cname = $('.brandname' + id).val();
        var cat_id = $('.cat_id' + id).val();
        var firm = $('.firm' + id).val();
        var message = $('.dupup' + id).val();

        $.ajax(
                {
                    url: BASE_URL + "masters/brands/update_duplicatebrandname",
                    type: 'get',
                    async: false,
                    data: {value1: cname, value2: ids, value3: cat_id, value4: firm},
                    success: function (result)
                    {

                        if (result != 0)
                            message.html(result);
                    }
                });
        var i = 0;

        if (firm == '') {
            $('.firmerr' + id).text('Required Field');
            i = 1;
        } else {
            $('.firmerr' + id).text(' ');
        }

        if (cat_id == '') {
            $('.caterr' + id).text('Required Field');
            i = 1;
        } else {
            $('.caterr' + id).text(' ');
        }

        var brand = cname;
        var m = $('.cnameerrorup' + id);
        if (brand == '' || brand == null || brand.trim().length == 0)
        {
            m.html("Required Field");
            i = 1;
        } else
        {
            m.html("");
        }


        //  var m = $(this).offsetParent().find('.cnameerrorup');

        //var message=$(this).offsetParent().find('.dupup');
        //  var message = $(this).parent().parent().find('.dupup').html();
        if ((message.trim()).length > 0)
        {
            i = 1;
        }

        if (i == 1)
        {
            return false;
        } else
        {
            $.ajax({
                url: BASE_URL + "masters/brands/update_brand",
                type: 'POST',
                data: {value1: id, value2: brand, firm: firm, cat_id: cat_id},
                success: function (result)
                {
                    window.location.reload(BASE_URL + "index/");
                }
            });
        }
        $('.modal').css("display", "none");
        $('.fade').css("display", "none");
    }
    //});
</script>