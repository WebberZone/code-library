<?php
/**
 * Plugin Name: Contextual Related Posts - Custom Template: Card Grid
 * Plugin URI:  https://webberzone.com/plugins/contextual-related-posts/
 * Description: Displays related posts in a responsive card grid.
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

/** Enqueue the card-grid template styles. */
function ad_crp_custom_template_card_grid_enqueue_styles() {
	$css = <<<'CSS'
.ad-crp-template-grid {
	--ad-crp-grid-ink: #26343a;
	--ad-crp-grid-muted: #5c696e;
	--ad-crp-grid-paper: #fbf8f2;
	--ad-crp-grid-line: #ddd6ca;
	--ad-crp-grid-accent: #b94332;
	color: var(--ad-crp-grid-ink);
}

.ad-crp-template-grid > h2,
.ad-crp-template-grid > h3,
.ad-crp-template-grid > .crp_title {
	border-bottom: 2px solid var(--ad-crp-grid-accent);
	color: var(--ad-crp-grid-ink);
	font-family: Georgia, 'Times New Roman', serif;
	font-size: clamp(1.35rem, 2vw, 1.8rem);
	line-height: 1.2;
	margin: 0 0 1.1rem;
	padding-bottom: 0.7rem;
}

.ad-crp-template-grid__list {
	display: grid;
	gap: 1.25rem;
	grid-template-columns: repeat(auto-fit, minmax(min(100%, 17rem), 1fr));
	list-style: none;
	margin: 0;
	padding: 0;
}

.ad-crp-template-grid__item {
	margin: 0;
}

.ad-crp-template-grid__card {
	background: var(--ad-crp-grid-paper);
	border: 1px solid var(--ad-crp-grid-line);
	border-top: 4px solid var(--ad-crp-grid-accent);
	border-radius: 0.25rem;
	box-shadow: 0 2px 8px rgb(38 52 58 / 6%);
	color: var(--ad-crp-grid-ink);
	display: flex;
	flex-direction: column;
	height: 100%;
	overflow: hidden;
	transition: border-color 180ms ease, box-shadow 180ms ease, transform 180ms ease;
}

.ad-crp-template-grid__card:hover,
.ad-crp-template-grid__card:focus-within {
	border-color: var(--ad-crp-grid-accent);
	box-shadow: 0 8px 20px rgb(38 52 58 / 12%);
	transform: translateY(-2px);
}

.ad-crp-template-grid__image {
	aspect-ratio: 16 / 9;
	display: block;
	overflow: hidden;
	width: 100%;
}

.ad-crp-template-grid__image img {
	display: block;
	height: 100%;
	object-fit: cover;
	transition: transform 240ms ease;
	width: 100%;
}

.ad-crp-template-grid__card:hover .ad-crp-template-grid__image img,
.ad-crp-template-grid__card:focus-within .ad-crp-template-grid__image img {
	transform: scale(1.03);
}

.ad-crp-template-grid__content {
	display: flex;
	flex: 1;
	flex-direction: column;
	gap: 0.75rem;
	padding: 1.15rem;
}

.ad-crp-template-grid__content h3 {
	font-family: Georgia, 'Times New Roman', serif;
	font-size: 1.25rem;
	font-weight: 700;
	letter-spacing: -0.02em;
	line-height: 1.25;
	margin: 0;
}

.ad-crp-template-grid__content h3 a {
	color: inherit;
	text-decoration-color: transparent;
	text-underline-offset: 0.18em;
}

.ad-crp-template-grid__content h3 a:hover {
	text-decoration-color: var(--ad-crp-grid-accent);
}

.ad-crp-template-grid__content h3 a:focus-visible {
	border-radius: 0.1em;
	outline: 2px solid var(--ad-crp-grid-accent);
	outline-offset: 3px;
}

.ad-crp-template-grid__content p {
	color: var(--ad-crp-grid-muted);
	line-height: 1.55;
	margin: 0;
}

.ad-crp-template-grid__content time {
	border-top: 1px solid var(--ad-crp-grid-line);
	color: var(--ad-crp-grid-muted);
	font-size: 0.72rem;
	font-weight: 700;
	letter-spacing: 0.08em;
	line-height: 1.4;
	margin-top: auto;
	padding-top: 0.8rem;
	text-transform: uppercase;
}

@media (prefers-reduced-motion: reduce) {
	.ad-crp-template-grid__card,
	.ad-crp-template-grid__image img {
		transition: none;
	}

	.ad-crp-template-grid__card:hover,
	.ad-crp-template-grid__card:focus-within,
	.ad-crp-template-grid__card:hover .ad-crp-template-grid__image img,
	.ad-crp-template-grid__card:focus-within .ad-crp-template-grid__image img {
		transform: none;
	}
}
CSS;

	wp_register_style( 'ad-crp-custom-template-card-grid', false, array(), '1.0.0' );
	wp_enqueue_style( 'ad-crp-custom-template-card-grid' );
	wp_add_inline_style( 'ad-crp-custom-template-card-grid', $css );
}
add_action( 'wp_enqueue_scripts', 'ad_crp_custom_template_card_grid_enqueue_styles' );

/**
 * Replace the default output with a responsive card grid.
 *
 * @param string|null     $template Previous custom template.
 * @param WP_Post[]|int[] $results Related posts.
 * @param array           $args Parsed display arguments.
 * @return string|null Custom HTML or the existing template.
 */
function ad_crp_custom_template_card_grid( $template, $results, $args ) {
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
				'<a class="ad-crp-template-grid__image" href="%1$s" aria-hidden="true" tabindex="-1">%2$s</a>',
				esc_url( $permalink ),
				wp_kses_post( get_the_post_thumbnail( $related_post->ID, 'large' ) )
			);
		}

		$excerpt_source = $related_post->post_excerpt ? $related_post->post_excerpt : $related_post->post_content;
		$excerpt        = wp_trim_words( wp_strip_all_tags( strip_shortcodes( $excerpt_source ) ), 24, '…' );
		$excerpt_markup = '';
		if ( '' !== $excerpt ) {
			$excerpt_markup = '<p>' . esc_html( $excerpt ) . '</p>';
		}

		$items[] = sprintf(
			'<li class="ad-crp-template-grid__item"><article class="ad-crp-template-grid__card">%1$s<div class="ad-crp-template-grid__content"><h3><a href="%2$s">%3$s</a></h3>%4$s<time datetime="%5$s">%6$s</time></div></article></li>',
			$thumbnail,
			esc_url( $permalink ),
			esc_html( get_the_title( $related_post ) ),
			$excerpt_markup,
			esc_attr( get_the_date( DATE_W3C, $related_post ) ),
			esc_html( get_the_date( '', $related_post ) )
		);
	}

	if ( empty( $items ) ) {
		return $template;
	}

	$heading = '';
	if ( ! empty( $args['heading'] ) && empty( $args['is_widget'] ) ) {
		$heading = wp_kses_post( \WebberZone\Contextual_Related_Posts\Frontend\Display::heading_title( $args ) );
	}

	return '<div class="crp_related ad-crp-template-grid">' . $heading . '<ul class="ad-crp-template-grid__list">' . implode( '', $items ) . '</ul></div>';
}
add_filter( 'crp_custom_template', 'ad_crp_custom_template_card_grid', 10, 3 );
