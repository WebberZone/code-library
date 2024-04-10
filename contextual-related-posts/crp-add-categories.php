<?php
/**
 * Plugin Name: Contextual Related Posts - Add Categories
 * Plugin URI:  https://webberzone.com/plugins/contextual-related-posts/
 * Description: Adds the categories to the items in the related posts list.
 * Author: Ajay D'Souza
 * Author URI: https://webberzone.com
 * Version: 1.0
 *
 * @package Contextual_Related_Posts
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
function crp_list_cats( $output, $result, $args ) {
	$categories = get_the_category_list( ', ', '', $result->ID );

	$output .= ' ' . $categories;

	return $output;
}
add_filter( 'crp_after_list_item', 'crp_list_cats', 10, 3 );
