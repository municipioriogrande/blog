<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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
			if ( is_front_page() ) :
				get_template_part( 'template-parts/content-page-posts-grid');
			endif; //front page
		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
