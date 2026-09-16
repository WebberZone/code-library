<?php
/**
 * Plugin Name: Contextual Related Posts - Custom Template: Thumbnail List
 * Plugin URI:  https://webberzone.com/plugins/contextual-related-posts/
 * Description: Displays related posts as a thumbnail-and-excerpt list.
 * Version:     1.0.0
 * Requires at least: 6.6
 * Requires PHP: 7.4
 * Author:      WebberZone Code Library
 * Author URI:  https://webberzone.com/
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package Contextual_Related_Posts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Replace the default output with a thumbnail-and-excerpt list.
 *
 * @param string|null     $template Previous custom template.
 * @param WP_Post[]|int[] $results Related posts.
 * @param array           $args Parsed display arguments.
 * @return string|null Custom HTML or the existing template.
 */
function ad_crp_custom_template_thumbnail_list( $template, $results, $args ) {
	if ( ! empty( $template ) || empty( $results ) ) {
		return $template;
	}

	$items = array();

	foreach ( $results as $result ) {
		$related_post = get_post( $result );
		if ( ! $related_post instanceof \WP_Post ) {
			continue;
		}

		$permalink = get_permalink( $related_post );
		if ( ! $permalink ) {
			continue;
		}

		$thumbnail = '';
		if ( has_post_thumbnail( $related_post->ID ) ) {
			$thumbnail = sprintf(
				'<a class="ad-crp-template-list__image" href="%1$s" aria-hidden="true" tabindex="-1">%2$s</a>',
				esc_url( $permalink ),
				wp_kses_post( get_the_post_thumbnail( $related_post->ID, 'medium' ) )
			);
		}

		$excerpt_source = $related_post->post_excerpt ? $related_post->post_excerpt : $related_post->post_content;
		$excerpt        = wp_trim_words( wp_strip_all_tags( strip_shortcodes( $excerpt_source ) ), 22, '…' );
		$excerpt_markup = '';
		if ( '' !== $excerpt ) {
			$excerpt_markup = '<p class="ad-crp-template-list__excerpt">' . esc_html( $excerpt ) . '</p>';
		}

		$items[] = sprintf(
			'<li class="ad-crp-template-list__item"><article>%1$s<h3><a href="%2$s">%3$s</a></h3>%4$s</article></li>',
			$thumbnail,
			esc_url( $permalink ),
			esc_html( get_the_title( $related_post ) ),
			$excerpt_markup
		);
	}

	if ( empty( $items ) ) {
		return $template;
	}

	$heading = '';
	if ( ! empty( $args['heading'] ) && empty( $args['is_widget'] ) ) {
		$heading = wp_kses_post( \WebberZone\Contextual_Related_Posts\Frontend\Display::heading_title( $args ) );
	}

	return '<div class="crp_related ad-crp-template-list">' . $heading . '<ul class="ad-crp-template-list__list">' . implode( '', $items ) . '</ul></div>';
}
add_filter( 'crp_custom_template', 'ad_crp_custom_template_thumbnail_list', 10, 3 );
