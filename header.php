<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package lsx
 */
global $lsx_options;

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php lsx_head_top(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<?php
if ( ! function_exists( '_wp_render_title_tag' ) ) { ?>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php } ?>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
<?php lsx_head_bottom(); ?>
</head>
<body <?php body_class( 'lsx' ); ?>>
<?php lsx_body_top(); ?>
<?php lsx_header_before(); ?>
 	<header class="banner navbar navbar-default navbar-static-top" role="banner">
  		<?php lsx_header_top(); ?>
	  	<div class="container">
	    	<div class="navbar-header">
	    		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		        	<span class="sr-only"><?php _e('Toggle navigation','lsx'); ?></span>
		        	<span class="icon-bar"></span>
		        	<span class="icon-bar"></span>
		        	<span class="icon-bar"></span>
	      		</button>

	      		<span class="mobile-menu-title">Menu</span>

				<?php lsx_site_identity(); ?>
		    </div>

			<?php lsx_nav_before(); ?>
			
			<?php lsx_nav_menu(); ?>
	  		
	  		<?php lsx_nav_after(); ?>
	  		
	  	<?php lsx_header_bottom(); ?>

	  	</div>
	</header>
		
<?php lsx_header_after(); ?>
    
    <div class="wrap container" role="document">
		<div class="content role row">