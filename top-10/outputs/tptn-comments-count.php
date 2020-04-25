<?php
/**
 * Plugin Name: Top 10 - Add Comments Count
 * Plugin URI:  https://webberzone.com/plugins/top-10/
 * Description: Adds the number of comments to the items in the popular posts list.
 * Author: Ajay D'Souza
 * Author URI: https://webberzone.com
 * Version: 1.0
 *
 * @package Top_Ten
 * @license GPL-2.0+
 */

/**
 * Add comments count to the list items.
 *
 * @param string $output Formatted list item with link and and thumbnail.
 * @param object $result Object of the current post result.
 *
 * @return  string  Output variable with comments number added
 */
function tptn_comments_count( $output, $result ) {

	$output .= ' ' . $result->comment_count . __( ' comments', 'top-10' );

	return $output;
}
add_filter( 'tptn_list', 'tptn_comments_count', 10, 2 );

