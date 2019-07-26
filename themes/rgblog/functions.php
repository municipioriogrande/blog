<?php
/**
 * rgblog functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package rgblog
 */

if ( ! function_exists( 'rgblog_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function rgblog_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on rgblog, use a find and replace
		 * to change 'rgblog' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'rgblog', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'rgblog' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		/*
		add_theme_support( 'custom-background', apply_filters( 'rgblog_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
		*/

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'rgblog_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function rgblog_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'rgblog_content_width', 640 );
}
add_action( 'after_setup_theme', 'rgblog_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function rgblog_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'rgblog' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'rgblog' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'rgblog_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function rgblog_scripts() {
	wp_enqueue_style( 'rgblog-style', get_template_directory_uri() . "/style.min.css" );
	//wp_enqueue_style( 'rgblog-style', get_stylesheet_uri() );
	////wp_enqueue_style( 'blog-style', get_stylesheet_uri() . '/main.css' );

	wp_enqueue_script('jquery') ;
	wp_enqueue_script( 'rgblog-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'rgblog-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	wp_enqueue_script( 'rgblog-sitio', get_template_directory_uri() . '/js/sitio.js', array(), '20180810', true );

}
add_action( 'wp_enqueue_scripts', 'rgblog_scripts' );




add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );
function my_login_stylesheet() { 
   wp_enqueue_style( 'rgblog-login', get_template_directory_uri() . "/wp-login.min.css" );
}

function admin_css() {
    echo "
    <style type='text/css'>
    #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu {
		background: #ff6b00;
	}
		
	#adminmenu li a:focus div.wp-menu-image:before, #adminmenu li.opensub div.wp-menu-image:before, #adminmenu li:hover div.wp-menu-image:before
	{
			color: #ff6b00;
	}
    </style>
    ";
}
add_action( 'admin_head', 'admin_css' );







/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
//require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}



add_action( 'pre_get_posts', 'ignore_sticky_in_indexhome' );

function ignore_sticky_in_indexhome( $query ) {
   if ($query->is_main_query() && $query->is_home()) {
      $query->set( 'ignore_sticky_posts', 1 );
   }
}


// Remove comments
add_action( 'admin_menu', 'my_remove_admin_menus' );
function my_remove_admin_menus() {
    remove_menu_page( 'edit-comments.php' );
}

add_action('init', 'remove_comment_support', 100);
function remove_comment_support() {
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'page', 'comments' );
}

add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );
function mytheme_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}






// add tag and category support to pages
function tags_categories_support_all() {
  register_taxonomy_for_object_type('post_tag', 'page');
  register_taxonomy_for_object_type('category', 'page');  
}

// ensure all tags and categories are included in queries
function tags_categories_support_query($wp_query) {
  if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
  if ($wp_query->get('category_name')) $wp_query->set('post_type', 'any');
}

// tag and category hooks
add_action('init', 'tags_categories_support_all');
add_action('pre_get_posts', 'tags_categories_support_query');



/* ----------------------
// CTA Shortcode section
 ---------------------- */
function rgcta_shortcode( $atts ) {

	$atts = shortcode_atts(
		array(
			'texto' => '',
			'link_texto' => '',
			'link_url' => '',
			'imagen' => '',
		),
		$atts
	);

	$building = '<div class="tttt cta">';

	if ( !empty($atts['imagen']) ) {
		$building = str_replace("cta","cta cta-image", $building);
		$building .= '<div class="image" style="background-image:url(' . wp_get_attachment_image_src( $atts['imagen'] )[0]. ')"></div>';
	}

	$building .= '<div class="text">';
	$building .= '<p><span>' . wp_kses_post($atts['texto'])."</span>";
	if ( !empty($atts['link_url']) && !empty($atts['link_texto']) ) {
		$building .= '<a href="'.wp_kses_post($atts['link_url']).'" class="btn">' . wp_kses_post($atts['link_texto']) . '</a>';
	}
	$building .= '</p>';
	$building .= '</div>';
	$building .= '</div>'; //end block

	return $building;
}
add_shortcode( 'rgcta', 'rgcta_shortcode' );






add_action( 'init', 'shortcode_ui_detection' );
/**
 * If Shortcake isn't active, then add an administration notice.
 *
 * This check is optional. The addition of the shortcode UI is via an action hook that is only called in Shortcake.
 * So if Shortcake isn't active, you won't be presented with errors.
 *
 * Here, we choose to tell users that Shortcake isn't active, but equally you could let it be silent.
 *
 * Why not just self-deactivate this plugin? Because then the shortcodes would not be registered either.
 *
 * @since 1.0.0
 */
function shortcode_ui_detection() {
	if ( ! function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
		add_action( 'admin_notices', 'shortcode_ui_dev_example_notices' );
	}
}
/**
 * Display an administration notice if the user can activate plugins.
 *
 * If the user can't activate plugins, then it's poor UX to show a notice they can't do anything to fix.
 *
 * @since 1.0.0
 */
function shortcode_ui_dev_example_notices() {
	if ( current_user_can( 'activate_plugins' ) ) {
		?>
		<div class="error message">
			<p><?php esc_html_e( 'Shortcode UI plugin must be active for Shortcode UI Example plugin to function.', 'shortcode-ui-example', 'shortcode-ui' ); ?></p>
		</div>
		<?php
	}
}



add_action( 'register_shortcode_ui', 'shortcode_ui_dev_advanced_example' );
/**
 *
 * This example shortcode has many editable attributes, and more complex UI.
 *
 * @since 1.0.0
 */
function shortcode_ui_dev_advanced_example() {
	/*
	 * Define the UI for attributes of the shortcode. Optional.
	 *
	 * In this demo example, we register multiple fields related to showing a quotation
	 * - Attachment, Citation Source, Select Page, Background Color, Alignment and Year.
	 *
	 * If no UI is registered for an attribute, then the attribute will
	 * not be editable through Shortcake's UI. However, the value of any
	 * unregistered attributes will be preserved when editing.
	 *
	 * Each array must include 'attr', 'type', and 'label'.
	 * * 'attr' should be the name of the attribute.
	 * * 'type' options include: text, checkbox, textarea, radio, select, email,
	 *     url, number, and date, post_select, attachment, color.
	 * * 'label' is the label text associated with that input field.
	 *
	 * Use 'meta' to add arbitrary attributes to the HTML of the field.
	 *
	 * Use 'encode' to encode attribute data. Requires customization in shortcode callback to decode.
	 *
	 * Depending on 'type', additional arguments may be available.
	 */
	$fields = array(
		array(
			'label'  => 'Texto',
			'attr'   => 'texto',
			'type'   => 'text',
			'meta'   => array(
				'placeholder' => 'Ingresar texto', 
				'data-test'   => 1,
			),
		),
		array(
			'label'  => 'Link texto',
			'attr'   => 'link_texto',
			'type'   => 'text',
			'meta'   => array(
				'placeholder' => 'Ingresar texto', 
				'data-test'   => 1,
			),
		),
		array(
			'label'  => 'Link url',
			'attr'   => 'link_url',
			'type'   => 'url',
			'encode' => true,
			'meta'   => array(
				'placeholder' => 'Ingresar URL',
				'data-test'   => 1,
			),
		),
		array(
			'label'       => 'Imagen',
			'attr'        => 'imagen',
			'type'        => 'attachment',
			/*
			 * These arguments are passed to the instantiation of the media library:
			 * 'libraryType' - Type of media to make available.
			 * 'addButton'   - Text for the button to open media library.
			 * 'frameTitle'  - Title for the modal UI once the library is open.
			 */
			'libraryType' => array( 'image' ),
			'addButton'   => 'Seleccionar imagen',
			'frameTitle'  => 'Seleccionar imagen',
		),
	);
	/*
	 * Define the Shortcode UI arguments.
	 */
	$shortcode_ui_args = array(
		/*
		 * How the shortcode should be labeled in the UI. Required argument.
		 */
		'label' => 'Call to Action',
		/*
		 * Include an icon with your shortcode. Optional.
		 * Use a dashicon, or full HTML (e.g. <img src="/path/to/your/icon" />).
		 */
		'listItemImage' => 'dashicons-align-left',
		/*
		 * Limit this shortcode UI to specific posts. Optional.
		 */
		'post_type' => array( 'post', 'page' ),

		/*
		 * Define the UI for attributes of the shortcode. Optional.
		 *
		 * See above, to where the the assignment to the $fields variable was made.
		 */
		'attrs' => $fields,
	);
	shortcode_ui_register_for_shortcode( 'rgcta', $shortcode_ui_args );
}





// add font type & font size selection option in the WYSIWYG editor
if ( ! function_exists( 'wdm_add_mce_fontoptions' ) ) {
	function wdm_add_mce_fontoptions( $buttons ) {
			array_unshift( $buttons, 'fontselect' );
			array_unshift( $buttons, 'fontsizeselect' );
			return $buttons;
	}
}
add_filter( 'mce_buttons_2', 'wdm_add_mce_fontoptions' );




//Register support for Gutenberg wide images in your theme

add_action( 'after_setup_theme', function () {
	add_theme_support( 'align-wide' );
 } );






 add_filter( 'pre_get_posts', function ( $query ) {
	// exclude attachments from search
	if ( !is_admin() && $query->is_main_query() ) {
		if ( $query->is_search ){
			$query->set( 'post_type',array("post", "pages") );
			return $query;
		}
	}

} );
 