<?php
/**
 * Plugin Name: Top 10 - Restyle count
 * Plugin URI:  https://webberzone.com/plugins/top-10/
 * Description: Reformats the Top 10 counter to show k, m, bn and tn instead.
 * Author: Ajay D'Souza
 * Author URI: https://webberzone.com
 * Version: 1.1
 *
 * @package Top_Ten
 * @license GPL-2.0+
 */

/**
 * Modify the display of the Top 10 counter to show k, m, bn and tn instead.
 *
 * @since 1.0
 *
 * @param int $input Raw post count.
 * @return string Formatted count string.
 */
function tptn_restyle_count( $input ) {

	$input = absint( $input );

	$thresholds = array(
		1000000000000 => 'tn',
		1000000000    => 'bn',
		1000000       => 'm',
		1000          => 'k',
	);

	foreach ( $thresholds as $value => $suffix ) {
		if ( $input >= $value ) {
			return round( $input / $value, 1 ) . $suffix;
		}
	}

	return (string) $input;
}
add_filter( 'tptn_post_count_only', 'tptn_restyle_count' );
