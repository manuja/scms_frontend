<!-- Main content -->
<style> 
    /* Timeline */
    .timeline,
    .timeline-horizontal {
        list-style: none;
        padding: 20px;
        position: relative;
    }
    .timeline:before {
        top: 40px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 3px;
        background-color: #eeeeee;
        left: 50%;
        margin-left: -1.5px;
    }
    .timeline .timeline-item {
        margin-bottom: 10px;
        position: relative;
    }
    .timeline .timeline-item:before,
    .timeline .timeline-item:after {
        content: "";
        display: table;
    }
    .timeline .timeline-item:after {
        clear: both;
    }
    .timeline .timeline-item .timeline-badge {
        color: #fff;
        width: 54px;
        height: 54px;
        line-height: 52px;
        font-size: 22px;
        text-align: center;
        position: absolute;
        top: 18px;
        left: 50%;
        margin-left: -25px;
        background-color: #7c7c7c;
        border: 3px solid #ffffff;
        z-index: 100;
        border-top-right-radius: 50%;
        border-top-left-radius: 50%;
        border-bottom-right-radius: 50%;
        border-bottom-left-radius: 50%;
    }
    .timeline .timeline-item .timeline-badge i,
    .timeline .timeline-item .timeline-badge .fa,
    .timeline .timeline-item .timeline-badge .glyphicon {
        top: 2px;
        left: 0px;
    }
    .timeline .timeline-item .timeline-badge.primary {
        background-color: #1f9eba;
    }
    .timeline .timeline-item .timeline-badge.info {
        background-color: #5bc0de;
    }
    .timeline .timeline-item .timeline-badge.success {
        background-color: #FF9327;
    }
    .timeline .timeline-item .timeline-badge.warning {
        background-color: #d1bd10;
    }
    .timeline .timeline-item .timeline-badge.danger {
        background-color: #ba1f1f;
    }
    .timeline .timeline-item:last-child:nth-child(even) {
        float: right;
    }
    .timeline-horizontal {
        list-style: none;
        position: relative;
        padding: 20px 0px 20px 0px;
        display: inline-block;
    }
    .timeline-horizontal:before {
        height: 3px;
        top: auto;
        bottom: 26px;
        left: 56px;
        right: 0;
        width: 100%;
        margin-bottom: 20px;
    }
    .timeline-horizontal .timeline-item {
        display: table-cell;
        height: 40px;
        width: 20%;
        min-width:  196px;
        float: none !important;
        padding-left: 0px;
        padding-right: 20px;
        margin: 0 auto;
        vertical-align: bottom;
    }

    .timeline-horizontal .timeline-item:before,
    .timeline-horizontal .timeline-item:after {
        display: none;
    }
    .timeline-horizontal .timeline-item .timeline-badge {
        top: auto;
        bottom: 0px;
        left: 43px;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div>
                    <ul class="timeline timeline-horizontal">
                        <li class="timeline-item">
                            <a href="<?php echo base_url('employee/employee-details/'.$profile_id) ?>" title="Employee Details">
                                <div class="timeline-badge <?php if ($select_page == 1) { ?> success <?php } ?>">
                                    <i class="">1</i>
                                </div>
                            </a>
                        </li>
                        <li class="timeline-item">
                            <a href="<?php if($profile_id){ echo base_url('employee/employment_details/'.$profile_id); }else{ echo base_url('employee/employee-details/'); } ?>" title="Employment Details">
                                <div class="timeline-badge <?php if ($select_page == 2) { ?> success <?php } ?>">
                                    <i class="">2</i>

                                </div>
                            </a>
                        </li>

                        <li class="timeline-item">
                            <a href="<?php if($profile_id){ echo base_url('employee/academic-details/'.$profile_id); }else{ echo base_url('employee/employee-details/'); } ?>" title="Academic Professional Qaulifications">
                                <div class="timeline-badge <?php if ($select_page == 3) { ?> success <?php } ?>">
                                    <i class="">3</i>
                                </div>
                            </a>
                        </li>
                        <li class="timeline-item">
                            <a href="<?php if($profile_id){ echo base_url('employee/former-employee-details/'.$profile_id); }else{ echo base_url('employee/employee-details/'); } ?>" title="Former Employemnt Details">
                                <div class="timeline-badge <?php if ($select_page == 4) { ?> success <?php } ?>">
                                    <i class="">4</i>
                                </div>
                            </a>
                        </li>

                        <li class="timeline-item">
                            <a href="<?php if($profile_id){ echo base_url('employee/other-documents/'.$profile_id); }else{ echo base_url('employee/employee-details/'); } ?>" title="Other Documents">
                                <div class="timeline-badge <?php if ($select_page == 5) { ?> success <?php } ?>">
                                    <i class="">5</i>
                                </div>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
