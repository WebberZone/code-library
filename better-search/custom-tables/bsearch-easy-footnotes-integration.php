<?php
/**
 * Plugin Name: Better Search - Easy Footnotes Integration
 * Plugin URI:  https://webberzone.com/plugins/better-search/
 * Description: Makes footnote text added via the Easy Footnotes plugin searchable by Better Search Pro's Custom Tables (Enhanced Content Search Index).
 * Author: Ajay D'Souza
 * Author URI: https://webberzone.com
 * Version: 1.0
 *
 * @package Better_Search_Pro
 * @license GPL-2.0+
 */

/**
 * Easy Footnotes' [efn_note] / [note] shortcode replaces its own enclosed text with a
 * numbered marker and only re-appends the note text via a the_content filter, which
 * Better Search Pro's indexer doesn't run. This pulls the note text back out of the raw
 * shortcode content before it's discarded, using the bsearch_pre_index_content_parts
 * filter (and its Contextual Related Posts Pro equivalent, since the two plugins share
 * the same custom content table and only one of them syncs on save_post).
 *
 * After installing, run a reindex so already-published posts pick up their footnote
 * text: WP Admin > Better Search Pro > Tools, or `wp bsearch ecsi reindex --force`.
 */

if ( ! function_exists( 'bsearch_efn_integration_extract_notes' ) ) {
	/**
	 * Extract footnote text from Easy Footnotes shortcodes before it is discarded.
	 *
	 * @param string[] $extra_parts Extra text fragments already queued for the index.
	 * @param string   $content     Raw post content, before block/shortcode processing.
	 * @return string[] Extra text fragments, with recovered footnote text appended.
	 */
	function bsearch_efn_integration_extract_notes( array $extra_parts, string $content ): array {
		if ( ! class_exists( 'easyFootnotes' ) ) {
			return $extra_parts;
		}

		// Easy Footnotes registers both [note] and [efn_note] as aliases of the same shortcode.
		$pattern = get_shortcode_regex( array( 'note', 'efn_note' ) );

		if ( ! preg_match_all( '/' . $pattern . '/', $content, $matches, PREG_SET_ORDER ) ) {
			return $extra_parts;
		}

		foreach ( $matches as $match ) {
			// Skip escaped shortcodes, e.g. [[efn_note]]...[[/efn_note]].
			if ( '[' === $match[1] && ']' === $match[6] ) {
				continue;
			}

			$note = trim( $match[5] );

			if ( '' === $note ) {
				continue;
			}

			$extra_parts[] = wp_strip_all_tags( do_shortcode( $note ) );
		}

		return $extra_parts;
	}
}

if ( ! has_filter( 'bsearch_pre_index_content_parts', 'bsearch_efn_integration_extract_notes' ) ) {
	add_filter( 'bsearch_pre_index_content_parts', 'bsearch_efn_integration_extract_notes', 10, 2 );
}
if ( ! has_filter( 'crp_pre_index_content_parts', 'bsearch_efn_integration_extract_notes' ) ) {
	add_filter( 'crp_pre_index_content_parts', 'bsearch_efn_integration_extract_notes', 10, 2 );
}
