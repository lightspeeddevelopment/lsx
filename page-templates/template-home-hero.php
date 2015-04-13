<?php
/**
 * Template Name: Home Hero
 *
 * @package lsx
 */

get_header(); ?>

	<div id="primary" class="content-area col-sm-8">

		<?php lsx_content_before(); ?>

		<main id="main" class="site-main" role="main">

			<?php lsx_content_top(); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; // end of the loop. ?>
			
			<?php lsx_content_bottom(); ?>
			
			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
			?>

		</main><!-- #main -->

		<?php lsx_content_after(); ?>
		
	</div><!-- #primary -->

	<section id="home-widgets" class="lsx-full-width">
			
		<?php if ( ! dynamic_sidebar( 'sidebar-home' ) ) : ?>
		
		
		<?php endif; // end sidebar widget area ?>
		
	</section>

<?php get_footer(); ?>
