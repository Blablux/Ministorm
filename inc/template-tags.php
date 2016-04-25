<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Ministorm
 */

if ( ! function_exists( 'ministorm_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function ministorm_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'ministorm' ); ?></h1>
		<div class="nav-links">
			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'ministorm' ) ); ?></div>
			<?php endif; ?>
			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'ministorm' ) ); ?></div>
			<?php endif; ?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'ministorm_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function ministorm_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'ministorm' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'ministorm' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link',     'ministorm' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'ministorm_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
 function ministorm_posted_on() {
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
 		comments_popup_link( __( 'Leave a comment', 'ministorm' ), __( '1 Comment', 'ministorm' ), __( '% Comments', 'ministorm' ) );
 		echo '</span>';
 	}
 	edit_post_link( __( 'Edit', 'ministorm' ), '<span class="edit-link">', '</span>' );
 }
endif;

if ( ! function_exists( 'ministorm_entry_format' ) ) :
/**
 * Prints HTML with meta information for the post format, if it exists.
 */
function ministorm_entry_format() {
	$format = get_post_format();
	$formats = get_theme_support( 'post-formats' );
	//If the post has no format, or if it's not a format supported by the theme, return
	if ( ! $format || ! has_post_format( $formats[0] ) ) :
		printf( '<a href="%1$s"><span class="screen-reader-text">%2$s</span></a>',
					esc_url( get_permalink() ),
					get_the_title()
				);
	else :
		printf( '<a href="%1$s" title="%2$s"><span class="screen-reader-text">%3$s</span></a>',
					esc_url( get_post_format_link( $format ) ),
					esc_attr( sprintf( __( 'All %s posts', 'ministorm' ), get_post_format_string( $format ) ) ),
					get_post_format_string( $format )
				);
	endif;
}
endif;
