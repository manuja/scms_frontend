
<!-- Content Wrapper. Contains page content -->
<style>
    .selectlistpanel {
        width: 100%;
    }

    .selectlistpanel .widget-content {
        padding: 5px;
        margin: 0px;
    }

    .selectlistpanel select[multiple] {
        height: 200px;
        width: 100%;
        border: 1px solid #EAEAEA;
    }

    .selectlistpanel .widget-content select[multiple] option {
        padding: 10px;
        margin-bottom: 3px;
    }

    .selectlistpanel .widget-content select[multiple] option:not ([disabled]) {
        box-shadow: 0px 0px 5px #CCC inset;
        -webkit-box-shadow: 0px 0px 5px #CCC inset;
    }

    .selectionbuttons {
        padding-top: 25px;
        padding-left: 5px;
    }

    .selectionbuttons .btn {
        margin-bottom: 5px;
        cursor: pointer;
    }


    .widget {
        border-width: 1px;
        border-style: solid;
        margin-bottom: 20px;
        background-color: #f9f9f9;
        border-color: #d3d3d3;
    }

    .widget.widget-table {
        overflow: hidden;
    }

    .widget.widget-hide-header {
        border: none;
        background: none;
    }

    .widget.widget-focus-enabled {
        z-index: 999;
        position: relative;
    }

    .widget .widget-header {
        padding: 0 10px;
        height: 35px;
        border-bottom-width: 1px;
        border-bottom-style: solid;
        border-bottom-color: #d3d3d3;
        background-color: #eee;
    }

    @media screen and (max-width: 480px) {
        .widget .widget-header {
            height: 100%;
        }
    }

    .widget .widget-header h3 {
        display: -moz-inline-stack;
        display: inline-block;
        vertical-align: middle;
        *vertical-align: auto;
        zoom: 1;
        *display: inline;
        font-family: "latobold";
        font-size: 1.1em;
        margin: 0;
        line-height: 35px;
        float: left;
    }

    @media screen and (max-width: 480px) {
        .widget .widget-header h3 {
            float: none;
        }
    }

    .widget .widget-header .fa {
        margin-right: 5px;
    }

    .widget .widget-header em {
        float: left;
        font-size: 0.9em;
        color: #a4a4a4;
        line-height: 35px;
        margin-left: 4px;
    }

    @media screen and (max-width: 1279px) {
        .widget .widget-header em {
            display: none;
        }
    }

    .widget .widget-header .btn-help {
        float: left;
        padding: 0;
        position: relative;
        top: 3px;
        left: 3px;
    }

    @media screen and (max-width: 1279px) {
        .widget .widget-header .btn-help {
            display: none;
        }
    }

    .widget .widget-header .btn-group>a {
        color: #555;
    }

    .widget .widget-header .widget-header-toolbar {
        float: right;
        width: auto;
        height: 35px;
        border-left: 1px solid #ddd;
        padding-left: 10px;
        margin-left: 10px;
    }

    @media screen and (max-width: 480px) {
        .widget .widget-header .widget-header-toolbar {
            display: block;
            float: none;
            border-left: none;
            margin-left: 0;
            padding-left: 0;
        }
    }

    .widget .widget-header .widget-header-toolbar>a {
        margin-left: 5px;
    }

    .widget .widget-header .widget-header-toolbar.btn-init-hide {
        display: none;
    }

    .widget .widget-header .widget-header-toolbar .control-title {
        font-size: 0.9em;
        color: #a4a4a4;
        position: relative;
        top: 1px;
    }

    .widget .widget-header .widget-header-toolbar .label {
        position: relative;
        top: 8px;
    }

    .widget .widget-header .widget-header-toolbar .toolbar-item-group {
        padding-top: 0.3em;
        height: 100%;
    }

    .widget .widget-header .widget-header-toolbar .toolbar-item-group .label {
        position: relative;
        top: 1px;
    }

    .widget .widget-header .widget-header-toolbar .toolbar-item-group .multiselect {
        margin-top: 0;
    }

    .widget .widget-header .widget-header-toolbar .btn,.widget .widget-header .widget-header-toolbar .btn-borderless {
        display: -moz-inline-stack;
        display: inline-block;
        vertical-align: middle;
        *vertical-align: auto;
        zoom: 1;
        *display: inline;
        height: 25px;
    }

    .widget .widget-header .widget-header-toolbar .btn-borderless {
        padding-top: 5px;
    }

    .widget .widget-header .widget-header-toolbar .btn-borderless .fa {
        margin-right: 5px;
        position: relative;
        top: 2px;
    }

    .widget .widget-header .widget-header-toolbar .btn {
        margin-top: 5px;
    }

    .widget .widget-header .widget-header-toolbar .btn.btn-sm {
        padding: 0 10px;
    }

    .widget .widget-header .widget-header-toolbar .btn.btn-sm .fa {
        width: 10px;
        height: 12px;
    }

    .widget .widget-header .widget-header-toolbar .progress {
        width: 150px;
        height: 15px;
        margin-bottom: 0;
        margin-top: 10px;
    }

    .widget .widget-header .widget-header-toolbar .progress .progress-bar {
        font-size: 10px;
        line-height: 1.5;
    }

    .widget .widget-content {
        padding: 20px 10px;
    }

    .widget .widget-footer {
        padding: 7px 10px;
        border-top-width: 1px;
        border-top-style: solid;
        border-top-color: #f0f0f0;
        background-color: #f7f7f7;
    }

    .swal2-popup {
        font-size: 1.6rem !important;
    }
</style>


<!-- Main content -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-users text-blue"></i>
            <h3 class="box-title">Add Members to Group</h3>
        </div>
        <div class="box-body">
            <form action="" id="create_membership_group_form">
                <!--<div class="row">-->
                <div class="form-group" id="select_membership_groups"> </div>
                <input type="hidden" id="hidden_group_id" value="<?php echo $group_id ?>"/>
                <div class="form-group">
                    <div class="row">
                        <div class="container">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Select Group</label>

                                    <?php
                                    echo form_dropdown('membership_groups" id="membership_groups" class="form-control text-left" required', $membership_groups, isset($group_id) ? $group_id : '');
                                    ?>
                                </div>

                                <div class="form-group">
                                    <label for="">Membership Category</label>
                                    <?php
                                    echo form_dropdown('class_of_membership" id="class_of_membership" class="form-control text-left" required', $class_of_membership, isset($selectadmin) ? $selectadmin : '');
                                    ?>
                                </div>

                            </div>
                            <div class="col-sm-8">
                                <div class="row">

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">Group Admin/s</th>
                                                <th style="text-align: center">Core engineering discipline</th>
                                                <th style="text-align: center">Sub engineering discipline</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><div text-align: center  id="admin_div">

                                                    </div></td>
                                                <td><div text-align: center  id="core_engi_div"></div></td>
                                                <td><div text-align: center  id="sub_eng_div"></div></td>
                                            </tr>

                                        </tbody>
                                    </table>




                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--</div>-->
                <div class="form-group">

                    <div class="row">

                        <div class="col-md-5" style="">
                            <div class="form-group">
                                <label for="">Search By Name / Membership Number <span></span></label>
                                <input type="text" name="search_by_name" id="search_by_name" value="" class="form-control search_by_name" required="">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="widget selectlistpanel">
                                <div class="widget-header">
                                    <h3>Member List</h3>
                                </div>
                                <div class="widget-content">
                                    <select multiple="" id="available_privilegs">

                                    </select>
                                </div>
                            </div> 
                        </div>

                        <div class="col-md-1" style="margin-top: 150px">
                            <div class="btn-group btn-group-vertical selectionbuttons" >
                                <button class="btn btn-lg btn-default" type="button" id="prv-add" title=""><i class="fa fa-angle-right"></i></button>
<!--                                <button class="btn btn-lg btn-default" type="button" id="prv-add-all" title=""><i class="fa fa-angle-double-right"></i></button>-->
                                <button class="btn btn-lg btn-default" type="button" id="prv-remove" title=""><i class="fa fa-angle-left"></i></button>
<!--                                <button class="btn btn-lg btn-default" type="button" id="prv-remove-all" title=""><i class="fa fa-angle-double-left"></i></button>-->
                            </div>
                        </div>

                        <div class="col-md-5" style="">
                            <div class="form-group">
                                <label for=""><span><label for="">Search By Name / Membership Number<span></span></label></span></label>
                                <input type="text" name="search_by_names_added_members" id="search_by_names_added_members" value="" class="form-control search_by_names_added_members" required="">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="widget selectlistpanel">
                                <div class="widget-header">
                                    <h3>Added Members</h3>
                                </div>
                                <div class="widget-content">
                                    <select multiple="" id="assigned_privileges">

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
                <!--                    <div class="form-group">
                                        <button type="button" id="abcd" class="btn btn-success">Save</button> &nbsp; 
                                        <button type="reset" class="btn btn-danger">Clear</button>
                                    </div>-->
            </form>


        </div>
    </div></section>
</div>

<!-- /.content -->

<!-- /.content-wrapper -->

