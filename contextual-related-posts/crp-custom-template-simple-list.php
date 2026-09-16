<?php
/**
 * Plugin Name: Contextual Related Posts - Custom Template: Simple List
 * Plugin URI:  https://webberzone.com/plugins/contextual-related-posts/
 * Description: Replaces the default related posts HTML with a simple linked list.
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
 * Replace the default output with a simple related-post list.
 *
 * @param string|null     $template Previous custom template.
 * @param WP_Post[]|int[] $results Related posts.
 * @param array           $args Parsed display arguments.
 * @return string|null Custom HTML or the existing template.
 */
function ad_crp_custom_template_simple_list( $template, $results, $args ) {
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

		$items[] = sprintf(
			'<li class="ad-crp-custom-template__item"><a href="%1$s">%2$s</a></li>',
			esc_url( $permalink ),
			esc_html( get_the_title( $related_post ) )
		);
	}

	if ( empty( $items ) ) {
		return $template;
	}

	$heading = '';
	if ( ! empty( $args['heading'] ) && empty( $args['is_widget'] ) ) {
		$heading = wp_kses_post( \WebberZone\Contextual_Related_Posts\Frontend\Display::heading_title( $args ) );
	}

	return '<div class="crp_related ad-crp-custom-template ad-crp-custom-template--simple-list">' . $heading . '<ul class="ad-crp-custom-template__list">' . implode( '', $items ) . '</ul></div>';
}
add_filter( 'crp_custom_template', 'ad_crp_custom_template_simple_list', 10, 3 );
