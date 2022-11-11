<style>
    #loading_animation_div {
        /*    position: absolute;
            width: 80%;
            text-align: center;*/
        position: fixed;
        top: 50%;
        left: 50%;
        margin-top: -25px;
        margin-left: -25px;
        z-index: 9999;
    }
    .backDrop{
        background:rgba(255, 255, 255, 0.81);
        position:fixed;
        left:0;
        top:0;
        width:100 % ;
        height:100 % ;
        z - index:888;
    }
</style>
<!-- Content Header (Page header) -->
<?php
//echo '<pre>';
//print_r($system_groups);
//                                exit;
//foreach ($system_groups as $value)
//{
//    echo '<pre>';
//    print_r($value->gname) ;
//}
//exit;
?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Box Comment -->
            <div class="box box-widget">
                <div id="messages_noti"> </div>
                <!-- /.box-header -->
                <div class="box-body box-title" >


                    <form id="adjudcations_from" name="adjudcations_from" enctype="multipart/form-data" data-toggle="validator">


                        <div class="form-group col-md-6">
                            <label for="">User's Group</label>

                            <select id="group_id" class="form-control text-left" style="">
                                <option value = "">Select</option>
                                <?php
                                foreach ($system_groups as $group)
                                {
                                    ?>
                                    <optgroup label = "<?php echo $group->gname; ?>">

                                        <?php
                                        $parent_id = $group->group_id;
                                        $sub_items = sub_items($parent_id);

                                        foreach ($sub_items as $value)
                                        {
                                            ?>
                                            <option value = "<?php echo $value['group_id']; ?>"><?php echo $value['sname']; ?></option>
                                        <?php } ?>
                                    </optgroup>
                                <?php } ?>
                            </select>

                        </div>

                    </form>




                    <!--<button>demo button</button>-->

                    <div class="col-sm-12">
                        <div id="loading_animation_div" style="display: none;" class="loading_animation_content">
                            <img id="loading_animation_img" src="<?php echo base_url("assets/images/loading.gif"); ?>" style="max-height:50px;">
                        </div>
                        <div class="backDrop loading_animation_content" style="display: none;" ></div>
                        <div class="alert form-alertbox" role="alert" style="display: none;">

                        </div> 
                        <hr/>
                        <div id="jstree">

                        </div>
                    </div>
                    <br>
                    <div class="col-sm-12">
                        <br />
                        <!--<button class="btn btn-info"><i class="fa fa-floppy-o"></i> &nbsp; Save Draft</button> &nbsp;--> 
                        <button type="button" id="group_perm_save" class="btn btn-success"><i class="fa fa-paper-plane"></i> &nbsp; Submit</button> &nbsp; 
                        <button type="button" id="group_perm_clear" class="btn btn-danger"><i class="fa fa-minus-circle"></i> &nbsp; Clear</button>
                    </div>
                </div>
            </div>





        </div>
    </div>






</section>
</div>