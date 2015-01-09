<?php

/**
 * Yoast Breadcrumbs on Twitter Bootstrap
 * 
 * @author Novrian <me@novrian.info>
 * @copyright (c) 2013. Novrian Y.F.
 * @license MIT License
 * @param string $sep Your custom separator
 */
function lsx_breadcrumbs() {
  if (!function_exists('yoast_breadcrumb')) {
    return null;
  }

  // Default Yoast Breadcrumbs Separator
  $old_sep = '\&raquo\;';

  // Get the crumbs
  $crumbs = yoast_breadcrumb(null, null, false);

  // Remove wrapper <span xmlns:v />
  $output = preg_replace("/^\<span xmlns\:v=\"http\:\/\/rdf\.data\-vocabulary\.org\/#\"\>/", "", $crumbs);
  $output = preg_replace("/\<\/span\><\/span\>$/", "", $output);

  $crumb = preg_split("/\40(" . $old_sep . ")\40/", $output);

  $crumb = array_map(
    create_function('$crumb', '
      if (preg_match(\'/\<span\40class=\"breadcrumb_last\"/\', $crumb)) {
        return \'<li class="active">\' . $crumb . \'</li>\';
      }
      return \'<li>\' . $crumb . \' </li>\';
      '),
    $crumb
    );

  // Output HTML
  //$output = '<div class="breadcrumbs-container" xmlns="http://rdf.data-vocabulary.org/#"> <ul class="breadcrumb">' . implode("", $crumb) . '</ul></div>';
  $output = '<div class="breadcrumbs-container"> <ul class="breadcrumb">' . implode("", $crumb) . '</ul></div>';

  // Print
  echo $output;
}

/**
 * Custom template tags for this theme.
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package lsx
 */
if ( ! function_exists( 'lsx_site_title' ) ) :
	/**
	 * Displays logo when applicable
	 *
	 * @return void
	*/
	function lsx_site_title() {
		?>
			<div class="site-branding">
				<h1 class="site-title"><a title="<?php bloginfo( 'name' ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<p class="site-description"><?php bloginfo( 'description' ); ?></p>
			</div>		
		<?php 
	}
endif;



/*-----------------------------------------------------------------------------------*/
/* Add customisable post meta */
/*-----------------------------------------------------------------------------------*/

/**
 * Add customisable post meta.
 *
 * Add customisable post meta, using shortcodes,
 * to be added/modified where necessary.
 */

if ( ! function_exists( 'lsx_post_meta' ) ) {
	function lsx_post_meta() {
		if ( is_page() && ! is_page_template( 'page-templates/template-blog.php' ) ) { return; } ?>
		
		<div class="post-meta">
			<div class="post-date">
				<span class="genericon genericon-month"></span>
				<?php
					$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
					
					$time_string = sprintf( $time_string,
						esc_attr( get_the_date( 'c' ) ),
						get_the_date(),
						esc_attr( get_the_modified_date( 'c' ) ),
						get_the_modified_date()
					);
					printf( '<a href="%2$s" rel="bookmark">%3$s</a>',
						_x( 'Posted on', 'Used before publish date.', 'lsx' ),
						esc_url( get_permalink() ),
						$time_string
					);
				?>
			</div>

			<div class="post-author">

				<span class="genericon genericon-user"></span>

				<?php printf( '<a class="url fn n" href="%2$s">%3$s</a>',
					_x( 'Author', 'Used before post author name.', 'lsx' ),
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					get_the_author()
				); ?>
			</div>


			<?php 
		    	$post_categories = wp_get_post_categories( get_the_ID() );
		    	$cats = array();
		    	foreach($post_categories as $c){
		    			$cat = get_category( $c );
		    			$cats[] = '<a href="' . get_category_link( $cat->term_id ) . '" title="' . sprintf( __( "View all posts in %s" , 'lsx' ), $cat->name ) . '" ' . '>' . $cat->name.'</a> ';
		    	}
		    	if(!empty($cats)){ ?>
					<div class="post-categories">
						<span class="genericon genericon-category"></span>		    	
						<?php echo implode(', ', $cats); ?>
					</div>					
			<?php } ?>


			<?php echo get_the_tag_list('<div class="post-tags"><span class="genericon genericon-tag"></span> ',', ','</div>'); ?>

			
			<br clear="both" />
		</div>

	<?php } // End lsx_post_meta() 
}

/**
 * Add customisable post format html.
 */

if ( ! function_exists( 'lsx_post_format' ) ) {
	function lsx_post_format() {
		global $post;
		
		$post_format = get_post_format($post);
		
		if('standard' != $post_format && '' != $post_format) {
			$format_link = get_post_format_link($post_format);
			?>
	    	<div class="post-format">
	    		<?php echo '<span class="genericon"></span><a href="' . $format_link . '" title="' . sprintf( __( "View all %s posts" , 'lsx' ), ucfirst($post_format) ) . '" ' . '>' . ucfirst($post_format) . '</a> '; ?>
	    	</div>			
			<?php 
		}
	} // End lsx_post_format()
}

/**
 * Add customisable post meta.
 *
 * Add customisable post meta, using shortcodes,
 * to be added/modified where necessary.
 */

if ( ! function_exists( 'lsx_portfolio_meta' ) ) {
	function lsx_portfolio_meta() {
		?>
		
		
		<div class="portfolio-meta">
		
			<?php 
				$portfolio_type = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '', ', ', '' );
				
				if($portfolio_type){
					?>
					<div class="portfolio-category">
						<span><span class="genericon genericon-category"></span>Category</span>
						<?php echo $portfolio_type; ?>
					</div>			
			<?php } ?>
		


			<div class="portfolio-client">
				<span><span class="genericon genericon-user"></span>Client</span>
				<span>Dolor Sit Amet</span>
			</div>

			<?php 
				$website = get_post_meta(get_the_ID(),'lsx-website',true);
				if(false != $website){ ?>
				<div class="portfolio-website">
					<span><span class="genericon genericon-link"></span>Website</span>
					<a href="<?php echo $website; ?>"><?php echo $website; ?></a>
				</div>				
			<?php }	?>

		</div>
		
		<div class="post-meta">
			<div class="post-date">
				<span class="genericon genericon-month"></span>
				<?php
					$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
					
					$time_string = sprintf( $time_string,
						esc_attr( get_the_date( 'c' ) ),
						get_the_date(),
						esc_attr( get_the_modified_date( 'c' ) ),
						get_the_modified_date()
					);
					printf( '<a href="%2$s" rel="bookmark">%3$s</a>',
						_x( 'Posted on', 'Used before publish date.', 'lsx' ),
						esc_url( get_permalink() ),
						$time_string
					);
				?>
			</div>

			<div class="post-author">

				<span class="genericon genericon-user"></span>

				<?php printf( '<a class="url fn n" href="%2$s">%3$s</a>',
					_x( 'Author', 'Used before post author name.', 'lsx' ),
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					get_the_author()
				); ?>
			</div>


			<?php 
		    	$post_categories = wp_get_post_categories( get_the_ID() );
		    	$cats = array();
		    	foreach($post_categories as $c){
		    			$cat = get_category( $c );
		    			$cats[] = '<a href="' . get_category_link( $cat->term_id ) . '" title="' . sprintf( __( "View all posts in %s" , 'lsx' ), $cat->name ) . '" ' . '>' . $cat->name.'</a> ';
		    	}
		    	if(!empty($cats)){ ?>
					<div class="post-categories">
						<span class="genericon genericon-category"></span>		    	
						<?php echo implode(', ', $cats); ?>
					</div>					
			<?php } ?>


			<?php echo get_the_tag_list('<div class="post-tags"><span class="genericon genericon-tag"></span> ',', ','</div>'); ?>

			
			<br clear="both" />
		</div>

	<?php } // End lsx_post_meta() 
}

if ( ! function_exists( 'lsx_paging_nav' ) ) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 * @return void
	 */
	function lsx_paging_nav() {
		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}
		
		
		if(true == get_option('infinite_scroll',1) && function_exists('the_neverending_home_page_init')){
			return true;
		}elseif(function_exists('wp_pagenavi')){
			wp_pagenavi();
		}else{
		
			?>
			<nav class="navigation paging-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'lsx' ); ?></h1>
				<div class="nav-links">
		
					<?php if ( get_next_posts_link() ) : ?>
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'lsx' ) ); ?></div>
					<?php endif; ?>
		
					<?php if ( get_previous_posts_link() ) : ?>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'lsx' ) ); ?></div>
					<?php endif; ?>
		
				</div><!-- .nav-links -->
			</nav><!-- .navigation -->
			<?php
		}
	}
endif;

if ( ! function_exists( 'lsx_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @return void
 */
function lsx_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<div class="nav-links pager row">

			<?php
				$previous_post = get_previous_post_link( '%link', _x( '<div class="previous"><span class="meta-nav">&larr;</span> %title</div>', 'Previous post link', 'lsx' ) );
				$previous_post = str_replace('<a','<a class="col-sm-6"',$previous_post);
				echo $previous_post;
			?>
			<?php
				$next_post = get_next_post_link(     '%link', _x( '<div class="next">%title <span class="meta-nav">&rarr;</span></div>', 'Next post link',     'lsx' ) );
				$next_post = str_replace('<a','<a class="col-sm-6"',$next_post);
				echo $next_post;
			?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'lsx_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function lsx_posted_on() {
	global $post;

	echo 'by '; 
	the_author_posts_link(); 
	echo ' on ' . get_the_date( 'D jS F Y ' ) . ' in ' . get_the_category_list( ', ', '', $post->ID );
}
endif;