<?php
/**
 * Minnow functions and definitions
 *
 * @package Minnow
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 660; /* pixels */
}

if ( ! function_exists( 'minnow_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function minnow_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Minnow, use a find and replace
	 * to change 'minnow' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'minnow', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	add_editor_style( array( 'editor-style.css', minnow_fonts_url() ) );
	
	add_theme_support( 'title-tag' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'minnow' ),
		'social'  => __( 'Social Links', 'minnow' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'audio', 'gallery', 'status'
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'minnow_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // minnow_setup
add_action( 'after_setup_theme', 'minnow_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function minnow_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'minnow' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'minnow_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function minnow_scripts() {

	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.2' );

	wp_enqueue_style( 'minnow-style', get_stylesheet_uri() );

	wp_enqueue_script( 'minnow-script', get_template_directory_uri() . '/js/minnow.js', array( 'jquery' ), '20141015', true );

	wp_enqueue_script( 'minnow-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'minnow-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_style( 'minnow-opensans', minnow_fonts_url(), array(), null );

}
add_action( 'wp_enqueue_scripts', 'minnow_scripts' );

/**
 * Register Google Fonts
 */
function minnow_fonts_url() {
    $fonts_url = '';

    /* Translators: If there are characters in your language that are not
	 * supported by Open Sans, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$opensans = _x( 'on', 'Open Sans font: on or off', 'minnow' );

	/* Translators: If there are characters in your language that are not
	 * supported by Open Sans Condensed, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$opensanscond = _x( 'on', 'Open Sans Condensed font: on or off', 'minnow' );

	$font_families = array();

	if ( 'off' !== $opensans ) {

		$font_families[] = 'Open Sans:300,400,700,700italic,400italic,300italic';

	}

	if ( 'off' !== $opensanscond ) {

		$font_families[] = 'Open Sans Condensed:700,700italic';

	}

	if ( 'off' !== $opensanscond || 'off' !== $opensans ) {

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return $fonts_url;

}

/**
 * Enqueue Google Fonts for Editor Styles
 */
function minnow_editor_styles() {
    add_editor_style( array( 'editor-style.css', minnow_fonts_url() ) );
}
add_action( 'after_setup_theme', 'minnow_editor_styles' );

/**
 * Enqueue Google Fonts for custom headers
 */
function minnow_admin_scripts( $hook_suffix ) {

	wp_enqueue_style( 'minnow-opensans', minnow_fonts_url(), array(), null );

}
add_action( 'admin_print_styles-appearance_page_custom-header', 'minnow_admin_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
