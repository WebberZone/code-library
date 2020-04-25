<?php
/**
 * This is a simple example that modifies the to and from dates in the CRP query.
 *
 * @package Contextual_Related_Posts
 */

/**
 * Modify the from date of the CRP query.
 *
 * @param string $from_clause The Minimum date of the WHERE clause of the query.
 * @param int    $id    Post ID.
 *
 * @return string Updated minimum date.
 */
function crp_same_date_from( $from_clause, $id ) {
	global $wpdb, $post;

	$post_time = get_the_time( 'U', $post->ID );
	$from_date = $post_time;
	$from_date = gmdate( 'Y-m-d 0:0:0', $from_date );

	$from_clause = $wpdb->prepare( " AND $wpdb->posts.post_date >= %s ", $from_date );

	return $from_clause;
}
add_filter( 'crp_posts_from_date', 'crp_same_date_from', 10, 2 );


/**
 * Modify the to date of the CRP query.
 *
 * @param string $now_clause The Minimum date of the WHERE clause of the query.
 * @param int    $id    Post ID.
 *
 * @return string Updated max date.
 */
function crp_same_date_now( $now_clause, $id ) {
	global $wpdb, $post;

	$post_time = get_the_time( 'U', $post->ID );

	$to_date = $post_time + DAY_IN_SECONDS; // Within next day of the post.
	$to_date = gmdate( 'Y-m-d 0:0:0', $to_date );

	$now_clause = $wpdb->prepare( " AND $wpdb->posts.post_date < %s ", $to_date );

	return $now_clause;
}
add_filter( 'crp_posts_now_date', 'crp_same_date_now', 10, 2 );
