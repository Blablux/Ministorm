<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Ministorm
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function ministorm_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'main',
		'footer'         => 'primary',
	) );
	add_image_size( 'ministorm-site-logo', '300', '300' );
	add_theme_support( 'site-logo', array( 'size' => 'ministorm-site-logo' ) );
	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'ministorm_jetpack_setup' );
