
<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 5/1/2018
 * Time: 9:19 AM
 */
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Box Comment -->
                <div class="box box-widget">
                    <div class="box-header with-border text-center" style="background-color: #fff !important; color: #244b90;  border-radius: 6px;">
                        <h1 style="margin-bottom: 20px;">
                            <i class="fa fa-check-circle-o fa-lg" style="color: #00a65a;"></i> &nbsp; User Guide
                        </h1>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="video-player" style="text-align: center;">
                                    
                                    <video id="my-video" class="video-js" controls preload="auto" width="80%" height="auto" poster="<?php if (file_exists('uploads/user_manual/thumbnail/videoplaceholder.jpg')) {
                                                                                                                                            echo base_url() . 'uploads/user_manual/thumbnail/videoplaceholder.jpg';
                                                                                                                                        } else {
                                                                                                                                            echo base_url().'uploads/user_manual/thumbnail/videoplaceholder.png';
                                                                                                                                        } ?>" data-setup="{}">
                                        <source src="<?php echo base_url() . 'uploads/user_manual/video/Direct_route_temporary_user'; ?>.mp4" type='video/mp4'>
                                        <source src="<?php echo base_url() . 'uploads/user_manual/video/Direct_route_temporary_user'; ?>.webm" type='video/webm'>
                                        <p class="vjs-no-js">
                                            To view this video please enable JavaScript, and consider upgrading to a web browser that
                                            <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                                        </p>
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
