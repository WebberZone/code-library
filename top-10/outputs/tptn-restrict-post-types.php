<?php
/**
 * Plugin Name: Top 10 - Restrict to Post Types
 * Plugin URI:  https://webberzone.com/plugins/top-10/
 * Description: Restricts the popular posts list to specific post types.
 * Author: Ajay D'Souza
 * Author URI: https://webberzone.com
 * Version: 1.0
 *
 * @package Top_Ten
 * @license GPL-2.0+
 */

/**
 * Restrict the popular posts query to specific post types.
 *
 * By default Top 10 queries all post types enabled in the plugin settings.
 * This snippet overrides that to show only the post types you specify —
 * useful for WooCommerce stores (show only popular products), magazine sites
 * (show only popular articles from a specific CPT), and so on.
 *
 * Adjust the $allowed_post_types array to match your needs.
 *
 * @param array $post_types Array of post type slugs to include in the query.
 * @param array $args       Top 10 query arguments.
 *
 * @return array Updated array of post type slugs.
 */
function tptn_restrict_to_post_types( $post_types, $args ) {
	$allowed_post_types = array( 'post', 'product' );
	return $allowed_post_types;
}
add_filter( 'top_ten_posts_post_types', 'tptn_restrict_to_post_types', 10, 2 );
