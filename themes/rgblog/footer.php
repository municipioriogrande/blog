<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package rgblog
 */

?>

	</div><!-- #content -->

	<footer id="site-footer" class="footer">
		<div class="columns">
			<div class="logo">
				<?php if ( in_array( 'single-edlt', get_body_class() )  ||  in_array( 'post-type-archive-edlt', get_body_class() ) ) :?>
				<a href="//www.riogrande.gob.ar/"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/edlt-logo_footer.png" alt="Logo" class="logo-img"></a>
				<?php else:?>
				<a href="//www.riogrande.gob.ar/"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/logo_footer.png" alt="Logo" class="logo-img"></a>
				<?php endif;?>
			</div>
			<div>
				<p style="margin: 0;">Seguinos</p>
				<?php 
					$social_links = array(
						'facebook' => 'https://www.facebook.com/pages/Municipio+de+R%C3%ADo+Grande/362204533804292',
						'twitter' => 'https://twitter.com/MuniRioGrande',
						'instagram' => 'https://instagram.com/riograndeciudad',
						//'email' => 'mailto:?subject='.esc_html( get_the_title() ).'&body='.esc_url( get_the_permalink() ),
						'youtube' => 'https://www.youtube.com/user/MunicipioRioGrande/',
					);

					$social_sharing_list = '<ul class="social-links">';
					foreach ($social_links as $key => $url) {
						$social_sharing_list .='<li><a href="'.$url.'"><span lang="en">'.ucfirst($key).'</span></a></li>';
					}
					$social_sharing_list .= '</ul>';

					echo $social_sharing_list;
				?>
			</div>
			<div class="col-right">
				<!--<a href="#">Leer noticias mas viejas</a>-->
				<a href="#top" class="back-to-top"><span>Volver arriba</span></a>
			</div>
		</div>

	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>


<!-- analytics 
<script>
(function(f,i,r,e,s,h,l){i['GoogleAnalyticsObject']=s;f[s]=f[s]||function(){
(f[s].q=f[s].q||[]).push(arguments)},f[s].l=1*new Date();h=i.createElement(r),
l=i.getElementsByTagName(r)[0];h.async=1;h.src=e;l.parentNode.insertBefore(h,l)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-XXXXXXXX-XX', 'yourdomain.com');
ga('send', 'pageview');
</script>-->

	
</body>
</html>
