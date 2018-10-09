<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package rgblog
 */

get_header();
?>

	<div id="primary" class="content-area page-show-posts-grid mini-posts-container">
		<main id="main" class="site-main">

		<?php
		if ( !have_posts() ) :
			get_template_part( 'template-parts/content', 'page' );
		else :
			get_template_part( 'template-parts/content-page-posts-grid');
		endif;
		the_posts_navigation();
		?>
		

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
