<?php
/**
 * Created by PhpStorm.
 * User: JEFF
 * Date: 16. 4. 7.
 * Time: 오후 12:30
 */

defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title> TattooIs </title>
    
    <link rel="stylesheet" href="<?php echo base_url(ASSETS_CSS.'bootstrap.min.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url(ASSETS_CSS.'animate.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url(ASSETS_CSS.'font-awesome/css/font-awesome.min.css');?>">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,300italic,500,700,700italic,900' rel='stylesheet' type='text/css'>
    <!-- toastr popup -->
    <link rel="stylesheet" href="/assets/emJs/lib/toastr/toastr.css">
    
    <link rel="stylesheet" href="<?php echo base_url(ASSETS_CSS.'style.css');?>">
    <link rel="stylesheet" href="/assets/emJs/normalize.css">
	<link rel="stylesheet" href="/assets/emJs/colorbox.css">
    
    <!-- Controller에서 동적으로 추가되는 CSS -->
	<?php 
		if(!empty($css)){
			foreach($css as $a)
				echo "<link rel=\"stylesheet\" href=\"".$a."\" />\n";
		}
	?>
    
    <!--[if lt IE 9]>	
	    <script src="/tattoois/js/respond.js"></script>
	    <script src="/tattoois/js/html5shiv.js"></script>
	<![endif]-->
    
    <!-- jQuery -->
    <script type="text/javascript" src="<?php echo base_url(ASSETS_JS.'jquery/jquery.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url(ASSETS_JS.'jquery/jquery-ui.min.js');?>"></script>
    
	<script type="text/javascript" src="<?php echo base_url(ASSETS_JS.'modernizr.custom.js');?>"></script>
    <!-- toastr popup -->
	<script type="text/javascript" src="/assets/emJs/lib/toastr/toastr.min.js"></script>

</head>
<body>
	
<header class="page-header" role="banner">
	<div class="write_bt">
        <a href="/post/register">
            <i class="fa fa-plus fa-2x"></i>
        </a>
    </div>
    <div class="inner">
        <h1 class="site-logo"><a href="/">TATOOIS</a></h1>
    </div>
    

</header>
<div class="wrapper animated fadeIn">
	<div class="container">