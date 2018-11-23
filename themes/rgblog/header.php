<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php bloginfo( 'description' ); ?>">

	<link rel="profile" href="https://gmpg.org/xfn/11">

	<link href="//www.google-analytics.com" rel="dns-prefetch">

	<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/icons/favicon.ico" rel="shortcut icon">
	<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/icons/touch.png" rel="apple-touch-icon">

	<?php wp_head(); ?>

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
</head>

<body <?php body_class(); ?>>
<div id="start-content" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Ir al contenido', 'rgblog' ); ?></a>

	<header id="site-header" class="header">
		<div class="header-content">

			<div class="logo">
			
				<?php if ( in_array( 'single-edlt', get_body_class() ) || in_array( 'post-type-archive-edlt', get_body_class() ) ) :?>
				<a href="<?php echo esc_url( home_url('/') ); ?>edlt">
					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/edlt-logo.png" alt="Logo" class="logo-img">
				</a>
				<?php else:?>
				<a href="<?php echo esc_url( home_url('/') ); ?>">
					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/logo.png" alt="Logo" class="logo-img">
				</a>
				<?php endif;?>
			</div>

		<div class="search-form">
			<?php get_search_form();?>
		</div>

			<nav class="nav" id="site-navigation">
				<!--<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'rgblog' ); ?></button> -->
				<?php /*
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				) );
				*/
				 ?>

				<?php
				$cats_terms = get_terms('category');
				$categories_count = array();
				$categories_info  = array();
				
				foreach( $cats_terms as $category ) {
					$categories_count[] = $category->count;
					$categories_info[] = array( $category->name , esc_url( get_category_link( $category->term_id ) ) );
				} 

				array_multisort(  $categories_count, SORT_DESC,
						            $categories_info
						         );
				?>

				
				<ul>
					<?php 

					$ctr = 0;
					$sub_menu_set = false;
					 
					foreach( $categories_count as $key => $category ) {
						$ctr++;

						if ($ctr > 3 and !$sub_menu_set) {
							echo '<li class="hs-menu-item has-submenu" role="menu">';
							echo '<span class="item-more">Otros Temas</span>';
							echo '<ul>';
							$sub_menu_set = true;
						}

						echo '<li><a href="' . $categories_info[$key][1] . '">' . $categories_info[$key][0] . '</a></li>';
					} 

					if ($ctr > 3 and $sub_menu_set) {
						echo '</ul>';
						echo '</li>';
					}

				?>
				</ul>

			</nav>
		</div>

	</header><!-- #masthead -->

	<div id="content" class="site-content">
