<?php
/**
 * Ministorm functions and definitions
 *
 * @package Ministorm
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 660; /* pixels */
}
if ( ! function_exists( 'ministorm_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ministorm_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Ministorm, use a find and replace
	 * to change 'ministorm' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'ministorm', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	add_editor_style( array( 'editor-style.css', ministorm_fonts_url() ) );
	add_theme_support( 'title-tag' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'ministorm' ),
		'social'  => __( 'Social Links', 'ministorm' ),
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
	add_theme_support( 'custom-background', apply_filters( 'ministorm_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
	add_theme_support( 'custom-header', array(
		'default-image'          => get_template_directory_uri() . '/images/default-header.jpg',
		'height'                 => 300,
		'width'                  => 960,
		'max-width'              =>  2000,
		'flex-height'            => true,
		'flex-width'             => true,
		'uploads'                => true,
		'random-default'         => false,
		'header-text'            => true,
) );
}
endif; // ministorm_setup
add_action( 'after_setup_theme', 'ministorm_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function ministorm_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'ministorm' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'ministorm_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ministorm_scripts() {
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.2' );
	wp_enqueue_style( 'ministorm-style', get_stylesheet_uri() );
	wp_enqueue_script( 'ministorm-script', get_template_directory_uri() . '/js/ministorm.js', array( 'jquery' ), '20141015', true );
	wp_enqueue_script( 'ministorm-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'ministorm-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	wp_enqueue_style( 'ministorm-opensans', ministorm_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'ministorm_scripts' );

/**
 * Register Google Fonts
 */
function ministorm_fonts_url() {
    $fonts_url = '';
    /* Translators: If there are characters in your language that are not
	 * supported by Open Sans, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$opensans = _x( 'on', 'Open Sans font: on or off', 'ministorm' );
	/* Translators: If there are characters in your language that are not
	 * supported by Open Sans Condensed, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$opensanscond = _x( 'on', 'Open Sans Condensed font: on or off', 'ministorm' );
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
function ministorm_editor_styles() {
    add_editor_style( array( 'editor-style.css', ministorm_fonts_url() ) );
}
add_action( 'after_setup_theme', 'ministorm_editor_styles' );

/**
 * Enqueue Google Fonts for custom headers
 */
function ministorm_admin_scripts( $hook_suffix ) {
	wp_enqueue_style( 'ministorm-opensans', ministorm_fonts_url(), array(), null );
}
add_action( 'admin_print_styles-appearance_page_custom-header', 'ministorm_admin_scripts' );

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
