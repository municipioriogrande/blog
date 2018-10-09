<div class="mini-article effect-enlarge-shadow">
	<div>
		<div <?php if ( has_post_thumbnail() ) { echo 'style="background-image:url('.get_the_post_thumbnail_url( get_the_ID(), "large").')"'; } ?> class="image"></div>

		<h3 class="title"><a href="<?php echo esc_url( get_permalink() );?>"><?php echo get_the_title();?></a></h3>


	</div>

		<?php 
		$categories_list = get_the_category_list( esc_html__( ', ', 'rgblog' ) );
		if ( $categories_list ) : ?>
				<p class="category uppercase">
					<?php echo $categories_list;?>
				</p>
			<?php
		endif; 
		?>
</div>
