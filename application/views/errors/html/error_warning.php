<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $pagetitle; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/bower_components/font-awesome/css/font-awesome.min.css'); ?>">
<style type="text/css">

::selection { background-color: #E13300; color: white; }
::-moz-selection { background-color: #E13300; color: white; }

body {
	background-color: #fff;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	box-shadow: 0 0 8px #D0D0D0;
}
section.content-header.breadcrumbs {
    min-height: 0 !important;
}

p {
	margin: 12px 15px 12px 15px;
}

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
                                    <i class="fa fa-exclamation-triangle fa-5x text-warning" aria-hidden="true"></i>
                                    <h2><?php echo $warningTitle; ?></h2>
                                    <div class="error-content" style="text-align: left;"><?php echo $warningContent; ?></div>
                                    <button class="btn btn-primary" onclick="history.go(-1)">Go Back</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
