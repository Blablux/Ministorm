<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Minnow
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function minnow_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'main',
		'footer'         => 'primary',
	) );

	add_image_size( 'minnow-site-logo', '300', '300' );

	add_theme_support( 'site-logo', array( 'size' => 'minnow-site-logo' ) );

	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'minnow_jetpack_setup' );
