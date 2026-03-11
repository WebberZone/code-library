<?php
/**
 * This is a simple example that excludes certain posts from the related posts list on specific posts.
 *
 * @package Contextual_Related_Posts
 */

/**
 * Exclude specific posts from the related posts list when displayed on certain posts.
 *
 * The crp_query_posts_where filter changed to apply_filters_ref_array in CRP 3.3.0.
 * Use crp_exclude_post_ids instead, which is a simpler and more reliable approach.
 *
 * @since 1.0.0
 *
 * @param array   $exclude_post_ids Array of post IDs to exclude.
 * @param array   $args             CRP query arguments.
 * @param WP_Post $source_post      The source post object.
 *
 * @return array Updated array of post IDs to exclude.
 */
function crp_exclude_specific_post( $exclude_post_ids, $args, $source_post ) {

	$exclude_ids    = array( 568, 674 );     // Post IDs to exclude from related posts.
	$exclude_on_ids = array( 1016, 1011 );   // Post IDs on which the exclusion applies.

	if ( in_array( $source_post->ID, $exclude_on_ids, true ) ) {
		$exclude_post_ids = array_merge( $exclude_post_ids, $exclude_ids );
	}

	return $exclude_post_ids;
}
add_filter( 'crp_exclude_post_ids', 'crp_exclude_specific_post', 10, 3 );
