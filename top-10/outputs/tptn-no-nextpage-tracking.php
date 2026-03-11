<?php
/**
 * Plugin Name: Top 10 - Do not track nextpage
 * Plugin URI:  https://webberzone.com/plugins/top-10/
 * Description: Do not track any page views after nextpage code.
 * Author: Ajay D'Souza
 * Author URI: https://webberzone.com
 * Version: 1.1
 *
 * @package Top_Ten
 * @license GPL-2.0+
 */

/**
 * Do not track pages generated with the nextpage code in a post.
 *
 * The tptn_viewed_count filter was removed in Top 10 3.3.0.
 * Use tptn_view_post_count instead, which filters the full counter output
 * (including the tracker script) returned by Counter::echo_post_count().
 *
 * @param  string $output Top 10 counter output (tracker script or static count HTML).
 * @return string  Filtered counter output.
 */
function filter_tptn_viewed_count( $output ) {
	global $wp_query;

	if ( isset( $wp_query->query_vars['page'] ) && $wp_query->query_vars['page'] > 1 ) {
		$output = '';
	}

	return $output;
}
add_filter( 'tptn_view_post_count', 'filter_tptn_viewed_count' );
