<?php
/**
 * Plugin Name: Contextual Related Posts - UTM Link Tracking
 * Plugin URI:  https://webberzone.com/plugins/contextual-related-posts/
 * Description: Appends UTM parameters to related post links for analytics tracking.
 * Author: Ajay D'Souza
 * Author URI: https://webberzone.com
 * Version: 1.0
 *
 * @package Contextual_Related_Posts
 * @license GPL-2.0+
 */

/**
 * Append UTM parameters to related post links.
 *
 * Useful when you want to distinguish traffic driven by the related posts widget
 * from other internal traffic in Google Analytics or similar tools.
 *
 * Adjust $utm_params to match your campaign naming convention.
 *
 * @param string  $link   The permalink for the related post.
 * @param WP_Post $result The related post object.
 * @param array   $args   CRP display arguments.
 *
 * @return string Permalink with UTM parameters appended.
 */
function crp_add_utm_params( $link, $result, $args ) {
	$utm_params = array(
		'utm_source'   => 'related-posts',
		'utm_medium'   => 'internal',
		'utm_campaign' => 'crp',
	);

	return add_query_arg( $utm_params, $link );
}
add_filter( 'crp_permalink', 'crp_add_utm_params', 10, 3 );
