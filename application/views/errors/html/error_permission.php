<?php
/**
 * Created by PhpStorm.
 * User: ba
 * Date: 7/24/18
 * Time: 10:48 AM
 */
?>
<style>
    .four-zero-three {
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 80vh;
    > .inner {
        padding: 20px;
    }
    }
</style>
    <section class="content-header">
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="four-zero-three">
                            <div class="inner">
                                <i class="fa fa-exclamation-triangle fa-5x text-danger" aria-hidden="true"></i>
                                <h1>403</h1>
                                <h1>Access Denied</h1>
                                <div class="lead mb-30">Sorry, but you don't have permission to access this page.<?php if($errorMessage){ echo '<br>'.$errorMessage; } ?></div>
                                <a class="btn btn-primary" href="<?php echo site_url('member_dashboard'); ?>">Back to home</a>
                                <button class="btn btn-primary" onclick="history.go(-1)">Go Back</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
