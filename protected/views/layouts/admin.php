<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title># NEW ARRIVALS</title>
    <link rel="stylesheet" type="text/css" href="<?php echo ct::baseURL()?>/css/default.css">
	<link rel="stylesheet" type="text/css" href="<?php echo ct::baseURL()?>/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo ct::baseURL()?>/css/admin.css">
    <script type="text/javascript" src="<?php echo ct::baseURL()?>/js/jquery2.js"></script>
	<script type="text/javascript" src="<?php echo ct::baseURL()?>/js/responsive.js"></script>
	<script type="text/javascript" src="<?php echo ct::baseURL()?>/js/elements.js"></script>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>	
	<script type="text/javascript">
		$(document).ready(function(){
			mainLayoutControl();
			searchStyle();
			gridController();
		})
	</script>
</head>
<body class="clearfix">
	<div id="container" class="desktop-view">
		<!--START HEADER MENU-->	
		<div id="header-menu" class="clearfix">
			<div id="panel-setting">
				<div id="search-box">
					<img src="<?php echo ct::baseURL()?>/images/icons/searbt.png" style="float:left;padding-right: 10px;">
					<form id="search-form">
						<input tpye="text" name="search-input" id="search-input" placeholder="search...">
						<div id="search-border"></div>
					</form>
				</div>
				<div id="ajust-view-bt"style="float:right;">
					<img src="<?php echo ct::baseURL()?>/images/icons/close-bt.png">
				</div>
			</div>
			<div id="menu-wrapper">
				<div id="main-logo-wrapper">
					<a href="#" id="main-logo">И</a>
				</div>
				<blockquote>
					Fashion is all about showing<br /> WHO YOU ARE.
				</blockquote>
				<div id="main-menu">
                                    <?php 
                                        CT::widgets('MainMenu')->show('new arrivals');
                                    ?>
				</div>
			</div>
			<div id="socials">
				<a id="facebook-link" href="http://facebook.com">f</a>
				<span id="phone-number">+84 168 340 8828</span>
			</div>
		</div>
		<div id="content-container" class="clearfix">
                    <?php echo $content ?>
		</div>
	</div>	
</body>
</html>