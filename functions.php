<?php

function theme_enqueue_styles() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/editor-style.css' );
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/rtl.css' );

}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function minnow_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	echo '<span class="posted-on">' . $posted_on . '</span>';

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'minnow' ), __( '1 Comment', 'minnow' ), __( '% Comments', 'minnow' ) );
		echo '</span>';
	}

	edit_post_link( __( 'Edit', 'minnow' ), '<span class="edit-link">', '</span>' );

}
