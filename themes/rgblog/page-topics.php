<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package rgblog
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">


			<h2>Categorías</h2>
			<ul style="column-count:2;">
				<?php
					$categories = get_categories( array(
						'orderby' => 'name',
						'order'   => 'ASC'
					) );
				
				foreach( $categories as $category ) {
					$category_link = sprintf( 
						'<a href="%1$s" alt="%2$s">%3$s</a>',
						esc_url( get_category_link( $category->term_id ) ),
						esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ),
						esc_html( $category->name )
					);
					
					echo '<li>' . $category_link  . '</li> ';
				} 
				?>
			</ul>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
