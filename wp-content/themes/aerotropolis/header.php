<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Header template.
 */


?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="page-top">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<?php flush(); ?>
<body <?php body_class(); ?>>

<!-- BEGIN: Main Navigation -->

<nav class="secondary-nav" role="navigation">
	<div class="content-wrapper align-right">

		<?php get_search_form(); ?>

		<?php
			wp_nav_menu( array(
				'theme_location'	=> 'secondary_menu',
				'menu_class'  		=> 'secondary_menu'
			) );
		?>
	</div>
</nav>

<nav class="main-nav" role="navigation">
	<div class="content-wrapper">
		<a class="aerotropolis-logo" href="/">
			<div class="buildings"></div>
			<div class="text"></div>
		</a>
		<div class="hamburger-menu">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
		</div>
		<?php
			wp_nav_menu( array(
				'theme_location'	=> 'main_menu',
				'menu_class'  		=> 'main_menu sf-menu'
			) );
		?>
	</div>
</nav>

<!-- END: Main Navigation -->