<?php
/**
 * Plugin Name: Contextual Related Posts - Co-Author Plus Glue
 * Plugin URI:  https://webberzone.com/plugins/contextual-related-posts/
 * Description: Displays all the authors set by Co-Author Plus.
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
 * @param   string  $crp_author Contextual Related Posts Author HTML.
 * @param   object  $author_info Object of the current post result.
 * @param   WP_Post $result Post object.
 *
 * @return  string  Updated HTML with the co-authors added
 */
function crp_coauthor( $crp_author, $author_info, $result ) {

	$coauthors = get_coauthors( $result->ID );
	$authors   = array();

	$crp_author = '<span class="crp_author"> ' . __( ' by ', 'contextual-related-posts' );

	foreach ( $coauthors as $author ) {
		$author_link = get_author_posts_url( $author->ID );
		$author_name = ucwords( trim( stripslashes( $author->display_name ) ) );

		$authors[] = '<a href="' . $author_link . '">' . $author_name . '</a>';
	}

	$crp_author .= implode( ', ', $authors );
	$crp_author .= '</span>';

	return $crp_author;

}
add_filter( 'crp_author', 'crp_coauthor', 10, 3 );
