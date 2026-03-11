<?php
/**
 * Randomly sort the related posts results.
 *
 * @package Contextual_Related_Posts
 */

/**
 * Randomly sort related posts after the query runs.
 *
 * The get_crp_posts_id filter was removed in CRP 3.3.0.
 * Use crp_query_the_posts instead, which receives a plain array of WP_Post objects.
 *
 * @since 1.0.0
 *
 * @param WP_Post[] $posts      Array of related post objects.
 * @param array     $query_args CRP query arguments.
 * @param WP_Query  $query      The WP_Query instance.
 * @param object    $crp_query  The CRP_Core_Query instance.
 *
 * @return WP_Post[] Shuffled array of post objects.
 */
function crp_truly_random( $posts, $query_args, $query, $crp_query ) {
	shuffle( $posts );
	return $posts;
}
add_filter( 'crp_query_the_posts', 'crp_truly_random', 99, 4 );
