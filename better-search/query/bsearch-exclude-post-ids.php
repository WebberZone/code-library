<?php
/**
 * This is a simple example that excludes the current post and a set of specific posts
 * from Better Search results — useful when displaying search results alongside a post.
 *
 * @package Better_Search
 */

/**
 * Exclude the current post and a set of specific posts from Better Search results.
 *
 * @param array $exclude_post_ids Array of post IDs to exclude.
 * @param array $args             Better Search query arguments.
 *
 * @return array Updated array of post IDs to exclude.
 */
function bsearch_exclude_current_and_specific_posts( $exclude_post_ids, $args ) {
	global $post;

	// Always exclude the currently displayed post (avoids self-referential results).
	if ( ! empty( $post->ID ) ) {
		$exclude_post_ids[] = $post->ID;
	}

	// Add any other post IDs you want to permanently exclude.
	$always_exclude = array( 42, 57 );

	return array_unique( array_merge( $exclude_post_ids, $always_exclude ) );
}
add_filter( 'bsearch_exclude_post_ids', 'bsearch_exclude_current_and_specific_posts', 10, 2 );
