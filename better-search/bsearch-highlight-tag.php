<?php
/**
 * Plugin Name: Better Search - Custom Highlight Markup
 * Plugin URI:  https://webberzone.com/plugins/better-search/
 * Description: Replaces the default <mark> element and CSS class used to highlight search terms in results.
 * Author: Ajay D'Souza
 * Author URI: https://webberzone.com
 * Version: 1.0
 *
 * @package Better_Search
 * @license GPL-2.0+
 */

/**
 * Change the HTML element used to wrap highlighted search terms.
 *
 * Better Search wraps matched terms in <mark class="bsearch_highlight"> by default.
 * Use these two filters to swap in whatever element and class your theme expects.
 *
 * Common replacements:
 * - 'strong'  — bold with semantic weight
 * - 'em'      — italic with semantic emphasis
 * - 'span'    — no semantic meaning; rely entirely on the CSS class
 */

/**
 * Change the highlight HTML tag.
 *
 * @return string HTML tag name (without angle brackets).
 */
function bsearch_custom_highlight_tag() {
	return 'strong';
}
add_filter( 'bsearch_highlight_tag', 'bsearch_custom_highlight_tag' );

/**
 * Change the CSS class applied to the highlight element.
 *
 * @return string CSS class name.
 */
function bsearch_custom_highlight_class() {
	return 'search-highlight';
}
add_filter( 'bsearch_highlight_class', 'bsearch_custom_highlight_class' );
