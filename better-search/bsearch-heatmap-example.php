<?php
/**
 * This is an example to display the Better Search Heatmap
 * by changing the default parameters.
 *
 * @package Better_Search
 */

if ( function_exists( 'get_bsearch_heatmap' ) ) {

	// All these parameters are optional. If you don't pass any of these, the plugin will default to the options set in the Better Search settings page.
	$args = array(
		'daily'         => false,
		'smallest'      => '10',     // Heatmap - Smallest Font Size.
		'largest'       => '20',      // Heatmap - Largest Font Size.
		'unit'          => 'pt',         // Heatmap - We'll use pt for font size.
		'cold'          => 'ccc',        // Heatmap - cold searches.
		'hot'           => '000',         // Heatmap - hot searches.
		'before'        => '',         // Heatmap - Display before each search term.
		'after'         => '&nbsp;',        // Heatmap - Display after each search term.
		'heatmap_limit' => '30',    // Heatmap - Maximum number of searches to display in heatmap.
		'daily_range'   => '7',       // Daily Popular will contain posts of how many days?
	);

	echo get_bsearch_heatmap( $args ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

