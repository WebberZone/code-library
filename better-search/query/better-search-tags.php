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
 * @param  string $where        WHERE clause.
 * @param  string $search_query Search query.
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

	// The OR branch below sits outside the query's own visibility filters, so it repeats them:
	// published posts of searchable public post types only.
	$post_types   = array_values( get_post_types( array( 'public' => true, 'exclude_from_search' => false ) ) );
	$placeholders = implode( ', ', array_fill( 0, count( $post_types ), '%s' ) );

	foreach ( $exploded as $tag ) {
		// The tag is user input: escape it.
		$sql .= $wpdb->prepare(
			" OR (
				{$wpdb->posts}.post_status = 'publish'
				AND {$wpdb->posts}.post_type IN ( {$placeholders} )
				AND EXISTS (
					SELECT 1 FROM {$wpdb->terms}
					INNER JOIN {$wpdb->term_taxonomy}
						ON {$wpdb->term_taxonomy}.term_id = {$wpdb->terms}.term_id
					INNER JOIN {$wpdb->term_relationships}
						ON {$wpdb->term_relationships}.term_taxonomy_id = {$wpdb->term_taxonomy}.term_taxonomy_id
					WHERE taxonomy = 'post_tag'
						AND object_id = {$wpdb->posts}.ID
						AND {$wpdb->terms}.name LIKE %s
				)
			)",
			array_merge( $post_types, array( '%' . $wpdb->esc_like( $tag ) . '%' ) )
		);
	}

	return $sql;
}
add_filter( 'bsearch_posts_where', 'bsearch_tag_search_where', 500, 2 );
