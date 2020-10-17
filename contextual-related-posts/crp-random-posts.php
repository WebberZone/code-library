<?php
/**
 * Random posts after manual posts are added.
 *
 * @package Contextual_Related_Posts
 */

/**
 * Randomly sort posts after manual posts are added.
 *
 * @param   object $results    Original object array with post results.
 * @return  object  Updated object array with post results
 */
function crp_truly_random( $results ) {
	$results_array = (array) $results;
	shuffle( $results_array );
	$results = (object) $results_array;

	return $results;
}
add_filter( 'get_crp_posts_id', 'crp_truly_random', 99 );
