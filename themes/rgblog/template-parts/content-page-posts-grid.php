<?php 
$postsIDs = array(); //only IDs
// number of posts from Wordpress' config

while ( have_posts() ) : the_post();
	$postsIDs[] += get_the_ID();
endwhile;



function post_box($ID, $IDs){
	global $post;
	//global $postsIDs;  //FIX: doesn't work with global....

	if ( !isset($IDs[$ID]) ) {
		return false;
	}	
	
	$post = get_post($IDs[$ID]);
	setup_postdata( $post ); //Must use $post
	get_template_part ( 'template-parts/mini-article' );
	
}


if ( isset($postsIDs[0]) ): ?>

	<div class="row column-bigger">
		<div class="post bigger column">
			<?php $tmp = post_box ( 0 , $postsIDs ); ?>
		</div>
		<aside class="posts-lists smaller">

			<h4 class="title">Más populares</h4>

			<?php if ( function_exists( 'get_tptn_pop_posts' ) ) : 

				$settings = array(
					'daily' => FALSE,
					'limit' => 3,
					'strict_limit' => FALSE,
				);
				$topposts = get_tptn_pop_posts( $settings ); // Array of posts
				
				$topposts = wp_list_pluck( (array) $topposts, 'postnumber' );
				
				$args = array(
					'post__in' => $topposts,
					'orderby' => 'post__in',
					'posts_per_page' => 3,
					'ignore_sticky_posts' => 1 
				);
				
				$my_query = new WP_Query( $args );

				if ( $my_query->have_posts() ) : ?>
					<ul>
					<?php 
					while ( $my_query->have_posts() ) :
						$my_query->the_post();
						?>
						<li class="effect-enlarge-shadow">
							<a href="<?php echo get_permalink( get_the_ID() );?>">
								<?php the_title(); ?>
							</a>
						</li>
						<?php
						wp_reset_postdata();
					endwhile;
					?>
					</ul>
				<?php endif; // have post 

				wp_reset_query();

				endif; // get_tptn_pop_posts ?>

			<h4 class="title">Destacados</h4>
				<?php
				$args = array(
					'post__in'  => get_option( 'sticky_posts' ),
					'posts_per_page' => 3,
					'ignore_sticky_posts' => 1 
				);
				
				$my_query = new WP_Query( $args );

				if ( $my_query->have_posts() ) : ?>
					<ul>
					<?php 
					while ( $my_query->have_posts() ) :
						$my_query->the_post();
						?>
						<li class="effect-enlarge-shadow">
							<a href="<?php echo get_permalink( get_the_ID() );?>">
								<?php the_title(); ?>
								<?php 
								$categories = get_the_category();
								$tmp = array();
								foreach ($categories as $category) {
							  		  $tmp[] = $category->name ;   
								}
								;?>
								<span class="category uppercase"> <?php echo implode(" • ", $tmp); ?> </span>
							</a>
						</li>
						<?php
						wp_reset_postdata();
					endwhile;
					?>
					</ul>
				<?php endif; // have post 

				wp_reset_query();
				?>
		</aside>
	</div>
		
<?php endif; ?>

<div class="row"> 
	<div class="column"> <?php post_box ( 1 , $postsIDs ); ?> </div>
	<div class="column"> <?php post_box ( 2 , $postsIDs ); ?> </div>
	<div class="column"> <?php post_box ( 3 , $postsIDs ); ?> </div>
</div>


<?php if ( isset($postsIDs[4]) ): ?>
	<div class="row column-bigger">
		<!--
		<aside class="newsletter-holder smaller column">
			<?php get_template_part( 'template-parts/newsletter');?>
		</aside>
		-->
		<div class="column smaller">
			<?php post_box ( 4 , $postsIDs ); ?>
		</div>
		<div class="post bigger column">
			<?php post_box ( 5 , $postsIDs ); ?>
		</div>
	</div>
<?php endif; ?>


<div class="row column-bigger">
	<div class="post column bigger">
		<?php post_box ( 6 , $postsIDs ); ?>
	</div>
	<div class="column smaller">
		<?php post_box ( 7 , $postsIDs ); ?>
	</div>
</div>

<?php
echo paginate_links(array(
	//'prev_text'          => __('« Previous'),
	//'next_text'          => __('Next »'),
	'prev_text'          => '« Prev',
	'next_text'          => 'Sig »',
	'type'               => 'list',

));

?>