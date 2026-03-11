<?php
/**
 * This is a simple example that restricts CRP results to posts published on the same day as the current post.
 *
 * @package Contextual_Related_Posts
 */

/**
 * Restrict CRP related posts to those published on the same day as the current post.
 *
 * The crp_posts_from_date and crp_posts_now_date filters were removed in CRP 3.3.0.
 * Use crp_query_date_query instead, which accepts a standard WP_Query date_query array.
 *
 * @since 1.0.0
 *
 * @param array $date_query Date query array passed to WP_Query.
 *
 * @return array Updated date query.
 */
function crp_same_date_query( $date_query ) {
	global $post;

	$post_time = get_the_time( 'U', $post->ID );
	$from_date = gmdate( 'Y-m-d', $post_time );
	$to_date   = gmdate( 'Y-m-d', $post_time + DAY_IN_SECONDS );

	$date_query = array(
		array(
			'after'     => $from_date,
			'before'    => $to_date,
			'inclusive' => true,
		),
	);

	return $date_query;
}
add_filter( 'crp_query_date_query', 'crp_same_date_query', 10, 2 );
