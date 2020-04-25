<?php
/**
 * Extend Better Search to search in tags.
 *
 * @package Better_Search
 *
 * @wordpress-plugin
 * Plugin Name: Better Search
 * Plugin URI:  https://webberzone.com/plugins/better-search/
 * Description: Extend Better Search to search in tags.
 * Version:     1.0.0
 * Author:      Ajay D'Souza
 * Author URI:  https://webberzone.com/
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

/**
 * Extend Better Search to search through tags.
 *
 * @since 1.0.0
 *
 * @param string $where WHERE clause.
 * @param string $search_query Search query.
 * @return string Updated WHERE clause
 */
function bsearch_tag_search_where( $where, $search_query ) {
	global $wpdb;

	if ( empty( $search_query ) ) {
		return $where;
	}

	$exploded = explode( ' ', $search_query );

	if ( false === $exploded || 0 === count( $exploded ) ) {
		$exploded = array( 0 => $search_query );
	}

	$sql = $where;

	foreach ( $exploded as $tag ) {
		$sql .= "
			OR EXISTS
			(
				SELECT * FROM {$wpdb->terms}
				INNER JOIN {$wpdb->term_taxonomy}
					ON {$wpdb->term_taxonomy}.term_id = {$wpdb->terms}.term_id
				INNER JOIN {$wpdb->term_relationships}
					ON {$wpdb->term_relationships}.term_taxonomy_id = {$wpdb->term_taxonomy}.term_taxonomy_id
				WHERE taxonomy = 'post_tag'
					AND object_id = {$wpdb->posts}.ID
					AND {$wpdb->terms}.name LIKE '%$tag%'

		)";
	}

	return $sql;
}
add_filter( 'bsearch_posts_where', 'bsearch_tag_search_where', 500, 2 );
