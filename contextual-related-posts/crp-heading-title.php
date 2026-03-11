<?php
/**
 * Plugin Name: Contextual Related Posts - Custom Heading Title
 * Plugin URI:  https://webberzone.com/plugins/contextual-related-posts/
 * Description: Changes the related posts heading based on the current post type.
 * Author: Ajay D'Souza
 * Author URI: https://webberzone.com
 * Version: 1.0
 *
 * @package Contextual_Related_Posts
 * @license GPL-2.0+
 */

/**
 * Customise the related posts section heading per post type.
 *
 * The $args array contains the full CRP display arguments, including 'postid'
 * which is the source post ID. Use this to tailor the heading for different
 * content types — e.g. "Related Products" for WooCommerce, "More in this series"
 * for a custom 'series' post type, and the default for standard blog posts.
 *
 * @param string $title The current heading text.
 * @param array  $args  CRP display arguments.
 *
 * @return string Updated heading text.
 */
function crp_custom_heading_title( $title, $args ) {
	$post_id   = ! empty( $args['postid'] ) ? (int) $args['postid'] : get_the_ID();
	$post_type = get_post_type( $post_id );

	$headings = array(
		'product' => __( 'Related Products', 'contextual-related-posts' ),
		'series'  => __( 'More in This Series', 'contextual-related-posts' ),
		'recipe'  => __( 'More Recipes You Might Like', 'contextual-related-posts' ),
	);

	return isset( $headings[ $post_type ] ) ? $headings[ $post_type ] : $title;
}
add_filter( 'crp_heading_title', 'crp_custom_heading_title', 10, 2 );
