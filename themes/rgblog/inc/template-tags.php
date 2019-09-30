<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package rgblog
 */


function rgblog_get_post_date($option="created"){

	if ( $option == "created" ) {
		return array("attr" => get_the_date( DATE_W3C ), "human" => get_the_date() );
	}

	if ( $option == "modified" ) {
		return array("attr" => get_the_modified_date( DATE_W3C ), "human" => get_the_modified_date() );
	}

	return array("attr" => "", "human" => "" );
}


if ( ! function_exists( 'rgblog_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function rgblog_posted_on() {
		$time_string = '<time class="entry-date published updated dt-published" datetime="%1$s" itemprop="datePublished">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published dt-published" datetime="%1$s" itemprop="datePublished">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$tmp_c = rgblog_get_post_date("created");
		$tmp_m = rgblog_get_post_date("modified");

		$time_string = sprintf( $time_string,
			esc_attr( $tmp_c["attr"] ),
			esc_html( $tmp_c["human"] ),
			esc_attr( $tmp_m["attr"] ),
			esc_html( $tmp_m["human"] )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'rgblog' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'rgblog_updated_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function rgblog_updated_on() {
		$time_string = '<time class="entry-date published updated dt-updated" datetime="%1$s" itemprop="datePublished">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published dt-updated" datetime="%1$s" itemprop="datePublished">%2$s</time><time class="updated" datetime="%3$s" >%4$s</time>';
		}

		$tmp_c = rgblog_get_post_date("created");
		$tmp_m = rgblog_get_post_date("modified");

		$time_string = sprintf( $time_string,
			esc_attr( $tmp_c["attr"] ),
			esc_html( $tmp_c["human"] ),
			esc_attr( $tmp_m["attr"] ),
			esc_html( $tmp_m["human"] )
		);

		echo '<span class="posted-on">Última actualización: ' . $time_string . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'rgblog_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function rgblog_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'rgblog' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'rgblog_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function rgblog_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'rgblog' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'rgblog' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'rgblog' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'rgblog' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'rgblog' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'rgblog' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;



if ( ! function_exists( 'rgblog_post_thumbnail_single' ) ) :
	/**
	 * Displays an optional post thumbnail. Fixed srcset for single view
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function rgblog_post_thumbnail_single() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>
			<div class="post-thumbnail u-photo">

				<?php
				$attachment_id   = get_post_thumbnail_id(get_the_ID());
				$img_src_alttext = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );;
				$img_src_medium       = wp_get_attachment_image_url( $attachment_id, 'medium' );
				$img_src_medium_large = wp_get_attachment_image_url( $attachment_id, 'medium_large' );
				$img_src_large        = wp_get_attachment_image_url( $attachment_id, 'large' );
				?>
				<img src="<?php echo esc_url( $img_src_large ); ?>" class="attachment-full size-full wp-post-image" alt="<?php echo $img_src_alttext;?>"
				srcset="<?php echo $img_src_large; ?> 1024w, <?php echo $img_src_medium; ?> 400w, <?php echo $img_src_medium_large; ?> 600w"
				sizes="(max-width: 640px) 100vw, 640px" width="640" height="426">

			</div><!-- .post-thumbnail -->

		<?php
		endif; // End is_singular().
	}
endif;













if ( ! function_exists( 'rgblog_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function rgblog_post_thumbnail($size="") {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail u-photo">
				<?php the_post_thumbnail($size); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail u-photo" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1" >
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;

