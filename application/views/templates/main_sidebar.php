<?php
$CI = &get_instance();

$dash_url = '';

if ($CI->ion_auth->is_admin())
{
    $dash_url = site_url('/admin_dashboard');
}
else
{
    $page = $this->session->userdata('page');
    $dashboard_url = site_url('dashboard/' . $page);
    $dash_url = $dashboard_url;
}
$menu = $this->session->user_menu;

?>

<aside class="main-sidebar">
    <section class="sidebar">

        <ul class="sidebar-menu" data-widget="tree">

            <li class="">
                <a href="<?php echo $dash_url; ?>">
                    <i class="fa fa-tachometer"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                    </span>
                </a>

            </li>            


            <?php if ($CI->ion_auth->is_admin())
            {
                ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bars"></i>
                        <span>Orders</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left" onClick="($(this)[0].className == 'fa fa-angle-left') ? $(this)[0].className = 'fa fa-angle-down' : $(this)[0].className = 'fa fa-angle-left'" style="float: right !important;"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo site_url('orders'); ?>"><i class="fa fa-circle-o"></i>All Orders</a></li>
                       
                    </ul>
                </li>   


            </ul>
        <?php
        }
        else
        {
            ?>
            <li class="">
                <a href="<?php echo site_url('my-profile'); ?>">
                    <i class="fa fa-user"></i> <span>My Profile</span>
                    <span class="pull-right-container">
                    </span>
                </a>

            </li>
        
            <?php
            if (!empty($menu))
            {

                foreach ($menu as $main_item)
                {
                    // echo "----- ";
                    // print_r($main_item);
                    // print_r($this->session->user_id);

                    // echo " -----";

                    if (!empty($main_item['sub_items']))
                    {
                        /// has sub menus

                
            ?>


                        <li class="treeview">
                            <a href="#">
                                <i class="fa <?php echo $main_item['menu_icon'] ?> fa-lg"></i>
                                <span><?php echo $main_item['menu_title'] ?> <span class="label label-success" style=""></span></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left" onClick="($(this)[0].className == 'fa fa-angle-left') ? $(this)[0].className = 'fa fa-angle-down' : $(this)[0].className = 'fa fa-angle-left'" style="float: right !important;"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php
                                foreach ($main_item['sub_items'] as $sub_item)
                                {
                                    ?>
                                    <li><a href="<?php echo site_url($sub_item['menu_path']) ?>"><i class="fa fa-circle-o"></i> <?php echo $sub_item['menu_title'] ?></a></li>


                                    <?php
                                }
                                echo '</ul>';
                                echo '</li>';
                            }
                        }
                        echo '</ul>';
                    }
                }
                ?>

            </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header breadcrumbs" style="min-height: 50px;">
        <div class="breadcrumb-holder pull-right">
<?php echo $breadcrumbs; ?>
        </div>
    </section>

    <!--  System Messages - start  -->
    <section id="response-block">
<?php if ($this->session->flashdata('response_success'))
{
    ?>
            <div class="row row-success">
                <div class="col-md-12 row-wrapper">
                    <div class="row row-content alert fade in alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <?php echo $this->session->flashdata('response_success'); ?>
                    </div>
                </div>
            </div>
<?php } ?>
<?php if ($this->session->flashdata('response_warning'))
{
    ?>
            <div class="row row-warning">
                <div class="col-md-12 row-wrapper">
                    <div class="row row-content alert fade in alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <?php echo $this->session->flashdata('response_warning'); ?>
                    </div>
                </div>
            </div>
<?php } ?>
<?php if ($this->session->flashdata('response_error'))
{
    ?>
            <div class="row row-error">
                <div class="col-md-12 row-wrapper">
                    <div class="row row-content alert fade in alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    <?php echo $this->session->flashdata('response_error'); ?>
                    </div>
                </div>
            </div>
<?php } ?>
    </section>
    <!--  System Messages - end  -->