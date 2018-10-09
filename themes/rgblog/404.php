<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package rgblog
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="title"><?php esc_html_e( 'Página no encontrada.', 'rgblog' ); ?></h1>
				</header><!-- .page-header -->

				<div class="content">
					<p><?php esc_html_e( 'Lo sentimos, la página que usted solicitó no fue encontrada.', 'rgblog' ); ?> <a href="<?php echo esc_url( home_url('/') ); ?>" class="btn">Ir a <span lang="en">home</span></a></p>

					<?php
					//get_search_form();
					//the_widget( 'WP_Widget_Recent_Posts' );
					?>
					<!--
					<div class="widget widget_categories">
						<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'rgblog' ); ?></h2>
						<ul>
							<?php
							wp_list_categories( array(
								'orderby'    => 'count',
								'order'      => 'DESC',
								'show_count' => 1,
								'title_li'   => '',
								'number'     => 10,
							) );
							?>
						</ul>
					</div><!-- .widget -->

					<?php
					/* translators: %1$s: smiley */
					//$rgblog_archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'rgblog' ), convert_smilies( ':)' ) ) . '</p>';
					//the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$rgblog_archive_content" );

					//the_widget( 'WP_Widget_Tag_Cloud' );
					?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
