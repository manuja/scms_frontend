

<!-- Main content -->
<section class="content">
    <div class="box box-primary">

        <div class="box-header">
            <i class="fa fa-users text-blue"></i>
            <h3 class="box-title">Create Membership Group</h3>
        </div>
        <?php
//            echo '<pre>';
//            print_r($memship_details);
//            exit;
        ?>
        <div class="box-body">
            <div id="create_mem_group"> </div>
            <div class="row">
                <form action="" id="create_membership_group_form">
                    <input id="hidden_group_id" type="hidden" name="hidden_group_id" value="<?php
                    if (isset($memship_details->mem_group_id)) {
                        echo $memship_details->mem_group_id;
                    }
                    ?>">

                    <?php
                    if (!empty($sub_eng_desc)) {
                        foreach ($sub_eng_desc as $row)
                        {
                            $subengarray = $row['sub_discipline_option_id'];
                            echo '<input id="hidden_sub_eng_id" name="hidden_sub_eng_id[]" type="hidden" class="hidden_sub_eng_id" name="hidden_sub_eng_id" value="' . $subengarray . '">';
                        }
                    }
                    ?>

                    <div class="col-sm-6">

                        <div class="form-group">
                            <label for="">Group Name<span>*</span></label>
                            <input type="text" name="group_name" id="group_name" value="<?php echo isset($memship_details->mem_goup_name) ? $memship_details->mem_goup_name : ''; ?>" class="form-control group_name" required>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea name="description" id="description" class="form-control description"><?php echo isset($memship_details->mem_group_description) ? $memship_details->mem_group_description : ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="">Group Admins<span>*</span></label>

                            <div class="input-group" style="margin-bottom: 10px;">
                                <input name="group_admin_search" id="group_admin_search" class="form-control" placeholder="" type="text">
                                <div class="input-group-btn">
                                    <span id="append_group_id" class="btn btn-primary disabled">Add Group Admin</span> 
                                </div>

                            </div>
                            <select name="group_admins[]" id="group_admins" class="form-control group_admins" multiple="" required>

                                <?php
                                               
                               
                                    if (!empty($group_admins)) {
                                        foreach ($group_admins as $row)
                                        {
                                            echo '<option value='.$row['mem_group_admin_id'].' selected>'.$row['user_name_w_initials'].'</option>';
                                        }
                                    }
                                
                                ?>  



                            </select>

<!--<input name="group_admin_ids[]" type="text" id="group_admin_ids" class="form-control group_admin_ids">-->
                            <!--<input name="group_admins"  class="form-control" id="group_admins">-->

                            <!--</select>-->


                            <?php
                            
//                            echo form_dropdown('group_admins[]" required id="group_admins" multiple class="form-control text-left" ', $mem_group, isset($selectadmin) ? $selectadmin : '');
////                            
//                            
                            ?>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Core Engineering Discipline<span></span></label>
                            <div class="checkbox">
                                <label for="checkboxes-0">
                                    <input type="checkbox" name="checkboxes" id="core_eng_select_all" value="1">
                                    Select All
                                </label>
                            </div>
                            <?php
                            if (!empty($core_eng_desc)) {
                                if ($core_eng_desc) {
                                    foreach ($core_eng_desc as $row)
                                    {
                                        $selectcoreeng[] = $row['eng_discipline_option_id'];
                                    }
                                }
                            }
                            ?>
                            <?php
//                                print_r($selectcoreeng);
                            echo form_dropdown('core_ing_disp[]" id = "core_ing_disp" multiple class = "form-control text-left"', $core_eng, isset($selectcoreeng) ? $selectcoreeng : '');
                            ?>
                        </div>

                        <div class="form-group">
                            <label for="">Sub Engineering Discipline<span></span></label> <br>
                            <label for="checkboxes-0">
                                <input type="checkbox" name="checkboxes" id="sub_eng_select_all" value="1">
                                Select All
                            </label>
                            <select name="sub_engineering_id[]" id="sub_engineering_id" multiple class="form-control text-left sub_engineering_id">
                            </select>

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="radios">Group Types<span>*</span></label>
                            <?php
                            $commitee = '';
                            $chapter = '';
                            if (!empty($memship_details)) {
                                $group_type = 0;

                                if ($memship_details->mem_group_category == 1 || $group_type == 1) {
                                    $group = 'checked';
                                } else if ($memship_details->mem_group_category == 2 || $group_type == 2) {
                                    $chapter = 'checked';
                                } else if ($memship_details->mem_group_category == 3 || $group_type == 3) {
                                    $commitee = 'checked';
                                }
                            }
                            if (!empty($group_type)) {
                                if ($group_type == 1) {
                                    $group = 'checked';
                                } else if ($group_type == 2) {
                                    $chapter = 'checked';
                                } else {
                                    $commitee = 'checked';
                                }
                            }
                            ?>
                            <div class=""> 
                                <label class="radio-inline" for="radios-0">
                                    <input type="radio" name="group_type" id="radios-0" value="1" checked="checked" >
                                    Group
                                </label> 

                                <label class="radio-inline" for="radios-1">
                                    <input type="radio" name="group_type" id="radios-1" <?php echo $chapter; ?> value="2">
                                    Chapter
                                </label> 
                                <label class="radio-inline" for="radios-2">
                                    <input type="radio" name="group_type" id="radios-2" <?php echo $commitee; ?> value="3">
                                    Committee
                                </label> 
                            </div>
                        </div>
                        <div class="form-group hidden" id="chapter_div">
                            <label for="">Chapter</label>
                            <?php
                            echo form_dropdown('chapter" id="chapter" class="form-control text-left" required', $chapters, isset($memship_details->mem_group_chapter) ? $memship_details->mem_group_chapter : '');
                            ?>
                        </div>
                        <div class="form-group hidden" id="commitee_div">
                            <label for="">Committee</label>
                            <?php
                            echo form_dropdown('committee" id = "committee" required class = "form-control text-left" required', $committee, isset($memship_details->mem_group_committee) ? $memship_details->mem_group_committee : '');
                            ?>
                        </div>
                        <?php
                        if (isset($memship_details->mem_group_category)) {
                            if ($memship_details->mem_group_category == 2) {
                                if ($memship_details->mem_group_chapter == '3' && $memship_details->asso_provincial_district > 0) {
                                    $checked_ass = 'checked';
                                } else {
                                    $checked_ass = '';
                                }
                            }
                        } else {
                            $checked_ass = '';
                        }
                        ?>
                        <div class="form-group hidden" id="provincial_chapter_div">

                            <div class="checkbox">
                                <label for="checkboxes-0">
                                    <input type="checkbox" name="assoc_prov_check" id="assoc_prov_check" value="1" <?php echo $checked_ass; ?>>
                                    Associate Provincial Chapter to District Chapter
                                </label>
                            </div>
                        </div>
                        <div class="form-group hidden" id="asc_provincial_chapter_div">

                            <?php
                            echo form_dropdown('asso_pro_chap" id="asso_pro_chap" class="form-control text-left"', $prov_chapters, isset($memship_details->asso_provincial_district) ? $memship_details->asso_provincial_district : '');
                            ?>

                        </div>



                        <div class="form-group">

                            <label for="">Group Image  &nbsp;<span title="Allowed file types - jpg|jpeg|png & Max file Size -2 MB">&#9432;</span></label><br />
                            <label class="btn btn-primary"> Browse... 
                                <input type="file" name="group_image" id="group_image" onchange="document.getElementById('group_image_info').innerHTML = this.files[0].name" hidden <?php if (empty($memship_details->mem_group_image_path)) { ?> required="" <?php } ?>>
                                <input name="update_url" type="hidden" value="<?php if (!empty($memship_details->mem_group_image_path)) { echo $memship_details->mem_group_image_path; }?>">
                            </label>
                            <span class="label label-info" id="group_image_info"></span>
                            <div class="help-block with-errors"></div>
                            <?php if (!empty($memship_details->mem_group_image_path)) { ?>
                                <img src="<?php echo site_url($memship_details->mem_group_image_path);
                                            ?>" alt="group Img" width="42" height="42">
                                        <?php } ?>
                                </div>
                                <div class="form-group">

                                    
                                    <label for="">Committee Image &nbsp; <span title="Allowed file types - jpg|jpeg|png & Max file Size -2 MB">&#9432;</span></label><br />
                                    <label class="btn btn-primary"> Browse... 
                                        <input type="file" name="commitee_image" id="commitee_image" onchange="document.getElementById('commitee_image_info').innerHTML = this.files[0].name" hidden>
                                        <input name="commitee_update_url" type="hidden" value="<?php if (!empty($memship_details->mem_commitee_img_path)) { echo $memship_details->mem_commitee_img_path; }?>">
                                    </label>
                                    <span class="label label-info" id="commitee_image_info"></span>
                                    <div class="help-block with-errors"></div>
                                     <?php if (!empty($memship_details->mem_commitee_img_path)) { ?>
                                <img src="<?php echo site_url($memship_details->mem_commitee_img_path);
                                            ?>" alt="Commitee Img" width="42" height="42">
                                 <?php } ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    if (empty($memship_details)) {
                                        ?>

                                        <button type="submit" id="mem_group_create" class="btn btn-success">Create</button>
                                        <?php
                                    } else {
                                        ?>
                                        <button type="submit" id="mem_group_update" class="btn btn-success">Update</button>
                                    <?php } ?>
                        </div>


                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

