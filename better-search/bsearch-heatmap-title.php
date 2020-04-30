<?php
/**
 * This is an example to replace the Better Search Heatmap title tag.
 *
 * @package Better_Search
 */

/**
 * Filter the value of the title tag of heatmap links.
 *
 * @param string $title     Value of the title tag of the link.
 * @param string $searchvar Search term.
 */
function override_bsearch_heatmap_title( $title, $searchvar ) {

	$title = sprintf(
		/* translators: 1: Search term, 2: Number of searches */
		__( 'Search for %1$s', 'better-search' ),
		$searchvar,
	);
	return $title;
}
add_filter( 'bsearch_heatmap_title', 'override_bsearch_heatmap_title', 10, 3 );
