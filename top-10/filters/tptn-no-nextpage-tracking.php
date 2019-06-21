<?php
/**
 * Plugin Name: Top 10 - Do not track nextpage
 * Plugin URI:  https://webberzone.com/plugins/top-10/
 * Description: Do not track any page views after nextpage code.
 * Author: Ajay D'Souza
 * Author URI: https://webberzone.com
 * Version: 1.0
 *
 * @package Top_Ten
 * @license GPL-2.0+
 */

/**
 * Do not track pages generated with the nextpage code in a post.
 *
 * @param   string $output Top 10 tracker script.
 * @return  string  Filtered tracker script.
 */
function filter_tptn_viewed_count( $output ) {
	global $wp_query;

	if ( $wp_query->query_vars['page'] > 1 ) {
		$output = '';
	}

	return $output;
}
add_filter( 'tptn_viewed_count', 'filter_tptn_viewed_count' );

