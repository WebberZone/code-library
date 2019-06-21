<?php
/**
 * Plugin Name: Top 10 - Add Categories
 * Plugin URI:  https://webberzone.com/plugins/top-10/
 * Description: Adds the categories to the items in the popular posts list.
 * Author: Ajay D'Souza
 * Author URI: https://webberzone.com
 * Version: 1.0
 *
 * @package Top_Ten
 * @license GPL-2.0+
 */

/**
 * Add categories to the list items.
 *
 * @param   string $output Formatted list item with link and and thumbnail.
 * @param   object $result Object of the current post result.
 * @param   array  $args   Array of arguments.
 *
 * @return  string  Output variable with categories added
 */
function tptn_list_cats( $output, $result, $args ) {
	$categories = get_the_category_list( ', ', '', $result->ID );

	$output .= ' ' . $categories;

	return $output;
}
add_filter( 'tptn_list', 'tptn_list_cats', 10, 3 );
