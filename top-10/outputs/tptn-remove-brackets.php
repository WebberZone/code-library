<?php
/**
 * Plugin Name: Top 10 - Remove brackets
 * Plugin URI:  https://webberzone.com/plugins/top-10/
 * Description: Remove brackets from the list count in the list items.
 * Author: Ajay D'Souza
 * Author URI: https://webberzone.com
 * Version: 1.0
 *
 * @package Top_Ten
 * @license GPL-2.0+
 */

/**
 * Remove brackets from the count.
 *
 * @param   $string $tptn_list_count    Formatted list count.
 */
function tptn_remove_brackets( $tptn_list_count ) {

	$tptn_list_count = str_replace( ￼array( '(', ')' ), '', $tptn_list_count );

	return $tptn_list_count;
}
add_filter( 'tptn_list_count', 'tptn_remove_brackets' );

