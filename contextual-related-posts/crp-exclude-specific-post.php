<?php
/**
 * This is a simple example that allows for certain posts to be excluded on a specific set of posts.
 *
 * @package Contextual_Related_Posts
 */

/**
 * Exclude a post from displaying in a specific post's related posts.
 *
 * @param string $where The WHERE clause of the query.
 * @param int    $id    Post ID.
 * @return string Updated WHERE clause.
 */
function crp_exclude_specific_post( $where, $id ) {
	global $wpdb, $crp_settings;

	$exclude_ids    = array( '568', '674' );   // Enter the array of post IDs to exclude.
	$exclude_on_ids = array( '1016', '1011' ); // Enter the array of post IDs on which these posts are excluded.

	if ( in_array( $id, $exclude_on_ids ) ) { // phpcs:ignore WordPress.PHP.StrictInArray.MissingTrueStrict
		// Convert it back to string.
		$exclude_post_ids = implode( ',', array_filter( $exclude_ids ) );

		$where .= " AND $wpdb->posts.ID NOT IN ({$exclude_post_ids}) ";
	}
	return $where;
}
add_filter( 'crp_posts_where', 'crp_exclude_specific_post', 10, 2 );
