<?php
/**
 * Plugin Name: Top 10 - Restyle count
 * Plugin URI:  https://webberzone.com/plugins/top-10/
 * Description: Reformats the Top 10 counter to show k, m, bn and tn instead.
 * Author: Ajay D'Souza
 * Author URI: https://webberzone.com
 * Version: 1.0
 *
 * @package Top_Ten
 * @license GPL-2.0+
 */

/**
 * Modify the display the Top 10 counter to show k, m, bn and tn instead.
 *
 * @since 1.0
 *
 * @param string $input  Formatted list count.
 */
function tptn_restyle_count( $input ) {

	$input = filter_var( $input, FILTER_SANITIZE_NUMBER_INT );
	$input = number_format( $input, 0, '.', ',' );

	$input_count = substr_count( $input, ',' );

	switch ( $input_count ) {
		case 1:
			$input = substr( $input, 0, -4 ) . 'k';
			break;
		case 2:
			$input = substr( $input, 0, -4 ) . 'm';
			break;
		case 3:
			$input = substr( $input, 0, -4 ) . 'bn';
			break;
		case 4:
			$input = substr( $input, 0, -4 ) . 'tn';
			break;
		default:
			$input = $input;
	}
	return $input;
}
add_filter( 'tptn_post_count_only', 'tptn_restyle_count' );
