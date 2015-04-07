<html>
<head>

<title> <?php bloginfo ('name'); ?> - <?php bloginfo ('description'); ?>  </title>
<meta name="generator" content="WordPress <?php bloginfo ('version'); ?>" />
<meta http-equiv="content-type" content=" <?php bloginfo ('html_type'); ?>; <?php bloginfo ('charset'); ?>" />
<link rel="stylesheet" href="<?php bloginfo ('stylesheet_url'); ?>" media="all" type="text/css" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo ('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo ('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo ('atom_url'); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>favico.ico" type="image/x-icon"/>

<?php wp_head (); ?>
</head>

<body> 

<div class="header">
<div class = "letreiro"><a href="<?php echo get_option ('home'); ?>"></a>
<div class="logo"> <!- imagem da logo ->
                    <a href="<?php bloginfo('home'); ?>"><img src="<?php echo (get_option('logo_url')) ? get_option('logo_url') : get_bloginfo('template_url') . '/img/logo.png' ?>" alt="<?php bloginfo('name'); ?>"/></a>
                </div><!-end logo->
                </div></div>
<div class="menu-inicial">
	<div class="menu"> 
	<div class="centered_menu">
		
			 <?php wp_nav_menu( array( 
'theme_location' 	=> 'Navigation',
'menu' 				=> 'Home',
'container'			=> 'div',
'container_class'	=> 'main-navigation',
'menu_class'		=> 'navigation')); ?>
	</div>
	</div>


</div>


</html>
