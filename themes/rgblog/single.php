<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package rgblog
 */

get_header();

$social_links = array(
	'facebook' => 'https://www.facebook.com/sharer/sharer.php?u='.esc_url( get_the_permalink() ),
	'twitter' => 'https://twitter.com/intent/tweet?url='.esc_url( get_the_permalink() ).'&text=' . esc_html( get_the_title() ).'&via=MuniRioGrande',
	

	'email' => 'mailto:?subject='.esc_html( get_the_title() ).'&body='.esc_url( get_the_permalink() ),
	'whatsapp' => 'whatsapp://send?text=' . esc_html( get_the_title() ) . ' ' . esc_html( get_the_title() ),
	'linkedin' => 'https://www.linkedin.com/shareArticle?mini=true&url='.esc_url( get_the_permalink() ).'&title='.esc_html( get_the_title() ),
	'print' => 'javascript:if(window.print)window.print()',
	
	//'pdf' => 'https://www.facebook.com/sharer/sharer.php?u='.esc_url( get_the_permalink() ),
);

$social_sharing_list = '<ul class="social-links">';
foreach ($social_links as $key => $url) {
	$social_sharing_list .='<li><a href="'.$url.'"><span lang="en">'.ucfirst($key).'</span></a></li>';
}
$social_sharing_list .= '</ul>';

?>

<progress value="0" id="reading-progress"></progress>

	<div id="primary" class="content-area">
		<main id="main" class="site-main single-post">

			<section class="post-wrapper">

				<?php
				while ( have_posts() ) :
					the_post();

					$categories     = get_the_category();
					$category_ids   = array();
					$category_links = array();
					foreach($categories as $category) {
						$category_ids[] = $category->term_id;
						//$category_links[] = '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" rel="category tag">' . $category->name . '</a>';
						$category_links[] = '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . $category->name . '</a>';
					}

					//$categories_list = get_the_category_list( esc_html__( ', ', 'rgblog' ) );

					$post_thumbnail_url = get_the_post_thumbnail_url(get_the_ID(),'full');
					$post_classes = get_post_class(array("h-entry"));
					?>

					<article id="post-<?php the_ID(); ?>" class="<?php echo implode(' ', $post_classes);?>"  itemscope itemtype="http://schema.org/NewsArticle">

						<?php if ( $category_links ) : ?>
							<p class="category uppercase p-category tags" itemprop="articleSection">									
								<?php echo implode(" • ", $category_links);?>
							</p>
						<?php endif; ?>

						<h1 class="title p-name entry-title" itemprop="headline">
							<a href="<?php the_permalink(); ?>" class="u-url" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</h1>

						<?php rgblog_post_thumbnail("large"); ?>

						<div class="columns">
							<div class="social-bar">
								<?php echo $social_sharing_list; ?>
							</div>
							<div class="content-wrapper">
								<div class="content e-content entry-content" itemprop="articleBody">
									<?php the_content(); ?>
								</div>
								<meta itemprop="author" content="Municipio de Río Grande">
								<meta itemprop="publisher" content="Municipio de Río Grande">
								<meta itemprop="image" content="<?php echo $post_thumbnail_url;?>">

								<p class="date"><?php rgblog_updated_on();?></p>
								<?php 
								//$categories_list = get_the_category_list( esc_html__( ', ', 'rgblog' ) );
								if ( $category_links ) : ?>
									<p class="category">
										<span class="uppercase">Tags: </span>
										<span itemprop="articleSection"><?php echo implode(", ", $category_links);?></span>
									</p>
									<?php
								endif; ?>


							<div class="social-share">
								<p>Si te gustó este artículo puedes compartirlo</p>
								<?php echo $social_sharing_list; ?>
							</div>
						</div>



						<script type="application/ld+json">
						{
							"@context": "http://schema.org",
							"@type": "NewsArticle",
							"mainEntityOfPage": {
								"@type": "WebPage",
								"@id": "https://google.com/article"
							},
							"headline": "<?php echo get_the_title(); ?>",
							"image": [
								"<?php echo $post_thumbnail_url; ?>"
								],
							"datePublished": "<?php echo rgblog_get_post_date("created")["attr"];?>",
							"dateModified": "<?php echo rgblog_get_post_date("modified")["attr"];?>",
							"author": {
								"@type": "Person",
								"name": "Municipio Río Grande"
							},
							"publisher": {
								"@type": "Organization",
								"name": "Municipio Río Grande",
									"logo": {
										"@type": "ImageObject",
										"url": "https://info.riogrande.gob.ar/wp-content/themes/rgblog/img/logo.png"
									}
								},							
							"description": "<?php echo get_the_excerpt();?>"
						}
						</script>


					</article>


				<?php 
					$args_related = array(
					'category__in' => $category_ids,
					'post__not_in' => array(get_the_ID(),get_option( 'sticky_posts' )),
					'posts_per_page'=> 6, // Number of related posts that will be shown.
					'ignore_sticky_posts' => true,
					'post_type' => get_post_type( get_the_ID() ),
					);

				endwhile; // End of the loop. ?>


<aside class="related-posts mini-posts-container">
	<div class="orange-separator"></div>

	<?php $the_query = new WP_QUERY( $args_related ); ?>
	<?php if ( $the_query->have_posts() ): ?>
	<h2 class="title">Notas Relacionadas</h2>

	
	<div class="row">
		<?php
			$ctr = 0;
			$total = $the_query->post_count;
			
			while ( $the_query->have_posts() ): 
				$ctr++;
				$the_query->the_post();  
				echo '<div class="column">';
				get_template_part( 'template-parts/mini-article'); 
				echo '</div>';

				if ( $ctr == 3 ) {
					echo '</div>';
					echo '<div class="row">';
					$ctr = 0;
				}

				
			endwhile;
			?>
	</div> 
	<?php endif; // have_posts() ?>


</aside>



</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//get_sidebar();
get_footer();
