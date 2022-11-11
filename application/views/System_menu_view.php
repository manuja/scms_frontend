

    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <i class="fa fa-users text-blue"></i>

                <h3 class="box-title">System Menu</h3>

                <div id="messages_noti" style="margin-top: 20px;"></div>
            </div>
            <div class="box-body">
                <div id="project_create" >
                    <form name="menu_create_form" 
                          id="menu_create_form" 
                          class="form-horizontal menu_create_form" data-toggle="validator" role="form">

                        <div>
                            <!--($user['is_logged_in'] ? $user['first_name'] : 'Guest')-->
                            <input type="hidden" name="menu_id" id="menu_id"  class="menu_id" value="" >
                            <input type="hidden" name="menu_parent_hdn" id="menu_parent_hdn"  class="menu_parent_hdn" value="" >
                        </div>




                        <div class="division_project_information">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="page-header">
                                        <h4>System Menu</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">

                                        <label for="menu_title" 
                                               class="control-label col-lg-2">Menu Title<span> *</span></label>
                                        <div class="col-lg-10 validate-parent">
                                            <input type="text" 
                                                   name="menu_title" 
                                                   id="menu_title" 
                                                   class="form-control text-left menu_title" 
                                                   placeholder="Enter menu title" 
                                                   value="" 
                                                   required />
                                        </div>

                                    </div>
                                    <div class="form-group">

                                        <label for="menu_icon" 
                                               class="control-label col-lg-2">Menu icon<span> *</span></label>
                                        <!--<div class="col-lg-10 validate-parent">-->
                                        <!-- Button tag -->
                                        <!--<button class="btn btn-default" role="iconpicker"></button>-->
                                        <!-- Div tag -->
                                        <div role="iconpicker" name="menu_icon" id="menu_icon" data-iconset="fontawesome" class="col-lg-2 validate-parent"></div>
<!--                                            <input type="text" 
                                               name="menu_icon" 
                                               id="menu_icon" 
                                               class="form-control text-left menu_icon" 
                                               placeholder="Pick menu icon" 
                                               value="" 
                                               required />-->
                                        <!--</div>-->

                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" for="radios">Menu level</label>
                                        <div class="col-md-4" >
                                            <div id="menu_level1" class="radio">
                                                <label for="menu_level">
                                                    <input type="radio" name="menu_level" id="menu_level" value="1" checked="checked">
                                                    Level 1
                                                </label>
                                            </div>
                                            <div id="menu_level2" class="radio hidden">
                                                <label for="menu_level">
                                                    <input type="radio" name="menu_level" id="menu_level" value="2">
                                                    Level 2
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    <div class="form-group">
                                    
                                                                            <label for="menu_level" 
                                                                                   class="control-label col-lg-2">Level<span> *</span></label>
                                                                            <div class="col-lg-10 validate-parent">
                                                                                <select name="menu_level" id="menu_level" class="menu_level form-control text-left" >
                                                                                    <option value="1">Level 1</option>
                                                                                    <option value="2">Level 2</option>
                                    
                                                                                </select>
                                    
                                                                            </div>
                                    
                                                                        </div>-->
                                    <div class="form-group">

                                        <label for="menu_url" 
                                               class="control-label col-lg-2">Menu URL<span> *</span></label>
                                        <div class="col-lg-10 validate-parent">
                                            <input type="text" 
                                                   name="menu_url" 
                                                   id="menu_url" 
                                                   class="form-control text-left menu_icon" 
                                                   placeholder="Enter menu url" 
                                                   value="" 
                                                   required="" />
                                        </div>

                                    </div>
                                    <!--                                    <div class="form-group">
                                    
                                                                            <label for="parent_menu" 
                                                                                   class="control-label col-lg-2">Parent menu<span> *</span></label>
                                                                            <div class="col-lg-10 validate-parent">
                                                                                <input type="text" 
                                                                                       name="parent_menu" 
                                                                                       id="parent_menu" 
                                                                                       class="form-control text-left parent_menu" 
                                                                                       placeholder="Enter parent menu" 
                                                                                       value="" 
                                                                                       required />
                                                                            </div>
                                    
                                                                        </div>-->
                                    <div class="form-group">

                                        <label for="menu_order" 
                                               class="control-label col-lg-2">Menu Order<span> *</span></label>
                                        <div class="col-lg-10 validate-parent">
                                            <input type="number" 
                                                   name="menu_order" 
                                                   id="menu_order" 
                                                   class="form-control text-left menu_order" 
                                                   placeholder="Enter menu order" 
                                                   value="" 
                                                   required />
                                        </div>

                                    </div>
                                </div>
                            </div>



                            <div class="" id="main_process">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">

                                        <label for="division_project_fund_type" 
                                               class="control-label col-lg-2">Group<span> *</span></label>

                                        <div class="col-lg-10 validate-parent">
<!--                                            <select><option>Select Group</option></select>-->
                                            <?php
                                            echo form_dropdown('parent_menu" id="parent_menu" class="form-control text-left"', $parent_menu, isset($load_project->cl_client_type) ? $load_project->cl_client_type : '');
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <!--<input type="hidden" name="hidden_main_category" id="hidden_main_category" value="">-->
                                        <label for="child_menu" 
                                               class="control-label col-lg-2">Main Process<span>*</span></label>
                                        <div class="col-lg-10 validate-parent">
                                            <select name="child_menu" 
                                                    id="child_menu" 
                                                    class="form-control text-left child_menu">
                                                <!--<option> Select Child Menu </option>-->
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <!--                                                                        <div class="form-group">
                                                                                                                <input type="hidden" name="hidden_sub_category" id="hidden_sub_category" value="">
                                                                                                                <label for="grand_child" 
                                                                                                                       class="control-label col-lg-2">Sub Process<span>*</span></label>
                                                                                                                <div class="col-lg-10 validate-parent">
                                                                                                                    <select name="grand_child" 
                                                                                                                            id="grand_child" 
                                                                                                                            class="form-control text-left grand_child">
                                                                                                                        <option> Select Grand Child Menu </option>
                                                                                                                    </select>
                                                                                                                </div>
                                                                        
                                                                                                            </div>-->
                                    <div class="form-group">

                                        <button type="button" 
                                                name="cancel_button" 
                                                id="cancel_button" 
                                                class="btn btn-warning cancel_button pull-right" >Cancel</button>
                                        <button type="button" 
                                                name="update_button" 
                                                id="update_button" 
                                                class="btn btn-primary pull-right update_button hidden" >Update</button>

                                        <button type="button" 
                                                name="save_button" 
                                                id="save_button" 
                                                class="btn btn-primary pull-right save_button" >Save</button>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </form>

                </div>
            </div>
    </section>
    <div class="row">

        <div class="container">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Parent</th>
                    <th>Child</th>
                    <th>Grand child</th>
                    <th>Menu Icon</th>
                    <th>Menu Path</th>
                    <th>Row order</th>
                    <!--<th>4</th>-->
                </tr>

                <?php
                if ($grid_view) {
                    if (sizeof($grid_view) > 0) {
//                        echo '<pre>';
//                    print_r($grid_view);
//                    exit;
                        foreach ($grid_view as $res) {
                            ?>
                            <tr>

                                <td valign="top">
                                    <?php echo $res['menu_title']; ?>
                                    <a href="#" data-toggle="tooltip" title="Delete <?php echo $res['menu_title']; ?>?">
                                        <button id="title_delete" class="fa  fa-close" value="<?php echo $res['menu_id']; ?>" style="color:red"></button></a>
                                    <a href="#" data-toggle="tooltip" title="Edit <?php echo $res['menu_title']; ?>?">   <button id="title_edit" value="<?php echo $res['menu_id']; ?>" class="fa  fa-pencil-square-o" style="color:olivedrab"></button>
                                    </a>
                                    <a href="#" data-toggle="tooltip" title="Add sub menu">   <button id="add_sub_menu" value="<?php echo $res['menu_id']; ?>" class="fa fa-plus-circle" style="color:#808000"></button>
                                    </a>


                                </td>
                                <td colspan="2">
                                    <table width="100%">
                                        <?php
                                        $submenu = get_sub_menu_items($res['menu_id']);
                                        if (sizeof($submenu) > 0) {
                                            foreach ($submenu as $res_sub) {
                                                ?>
                                                <tr>
                                                    <td width="50%" valign="top">

                                                        <?php
                                                        echo $res_sub['menu_title'];
                                                        ?>

                                                        <a href="#" data-toggle="tooltip" title="Delete <?php echo $res_sub['menu_title']; ?>?">
                                                            <button id="child_delete"  class="fa  fa-close" value="<?php echo $res_sub['menu_id']; ?>" style="color:red"></button>
                                                        </a>
                                                        <a href="#" data-toggle="tooltip" title="Edit <?php echo $res_sub['menu_title']; ?>?">
                                                            <button id="child_edit" value="<?php echo $res_sub['menu_id']; ?>" class="fa  fa-pencil-square-o" style="color:olivedrab"></button>   
                                                        </a>


                                                    </td>

                                                    <td width="50%">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <?php
                                                            $get_grand_child_menu_items = get_grand_child_menu_items($res['permission_parent_id']);
                                                            if (sizeof($get_grand_child_menu_items) > 0) {
                                                                foreach ($get_grand_child_menu_items as $res_grand_sub) {
                                                                    ?>
                                                                    <tr>
                                                                        <td valign="top">
                                                                            <?php echo $res_grand_sub['menu_title']; ?>
                                                                            <a href="#" data-toggle="tooltip" title="Delete <?php echo $res_sub['menu_title']; ?>?">
                                                                                <button id="grand_child_delete" class="fa  fa-close" value="<?php echo $res_sub['menu_id']; ?>" style="color:red"></button></a>
                                                                            <a href="#" data-toggle="tooltip" title="Edit <?php echo $res_sub['menu_title']; ?>?">   <button id="grand_child_edit" value="<?php echo $res_sub['menu_id']; ?>" class="fa  fa-pencil-square-o" style="color:olivedrab"></button>
                                                                            </a>
                                                                        </td>
                                                                        <?php ?>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <tr>
                                                                    <td height="25" colspan="2">&nbsp;</td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>
                                                        </table>
                                                    </td>

                                                    <td width="27%" valign="top">
                                                </tr>

                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td width="27%">&nbsp;</td>
                                                <td width="73%">&nbsp;</td>
                                                <td width="73%">&nbsp;</td>
                                                <td width="73%">&nbsp;</td>
                                                <td width="73%">&nbsp;</td>
                                                <td width="73%">&nbsp;</td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </table>
                                </td>
                                <td>
                                    <?php echo $res['menu_icon']; ?>
                                </td>
                                <td>
                                    <?php echo $res['menu_path']; ?>
                                </td>
                                <td>
                                    <?php echo $res['row_order']; ?>
                                </td>

                            </tr>
                            <?php
                        }
                    } else {
                        echo 'No data found';
//                        exit;
                    }
                } else {
                    echo 'No data found';
//                    exit;
                }
                ?>
            </table>
        </div>
    </div>

</div>


</div>
</div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->