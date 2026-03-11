<?php
/**
 * Visitor-facing example that renders a styled "Trending Posts" block using Top Ten.
 *
 * @package Top_Ten
 */

if ( class_exists( 'Top_Ten_Query' ) ) {
	global $post;

	// You can customize these arguments. Refer to the WP_Query documentation for additional details.
	$args = array(
		'daily'               => true,
		'daily_range'         => 30,
		'limit'               => 6,
		'ignore_sticky_posts' => 1,
	);

	$my_query = new \Top_Ten_Query( $args );

	if ( $my_query->have_posts() ) {
		?>

		<section class="tptn-showcase" aria-labelledby="tptn-showcase-title">
		<?php tptn_render_showcase_styles(); ?>

			<header class="tptn-showcase__header">
				<div>
					<span class="tptn-showcase__eyebrow"><?php esc_html_e( 'Reader Favorites', 'top-10' ); ?></span>
					<h2 class="tptn-showcase__title" id="tptn-showcase-title"><?php esc_html_e( 'Trending This Month', 'top-10' ); ?></h2>
					<p class="tptn-showcase__intro">
		<?php esc_html_e( 'A curated list of the stories visitors keep coming back to, updated automatically from your Top Ten stats.', 'top-10' ); ?>
					</p>
				</div>
				<span class="tptn-showcase__badge"><?php esc_html_e( 'Updated from the last 30 days', 'top-10' ); ?></span>
			</header>

			<ul class="tptn-showcase__grid">
		<?php
		// Start looping over the query results.
		$rank = 1;
		while ( $my_query->have_posts() ) {
			$my_query->the_post();
			$post_id       = get_the_ID();
			$excerpt       = get_the_excerpt();
			$trimmed_text  = $excerpt ? wp_trim_words( $excerpt, 18, '...' ) : wp_trim_words( wp_strip_all_tags( get_the_content() ), 18, '...' );
			$category      = get_the_category();
			$category_name = ! empty( $category ) ? $category[0]->name : __( 'Popular Pick', 'top-10' );

			?>

				<li <?php post_class( 'tptn-showcase__card' ); ?>>
					<a class="tptn-showcase__media" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			if ( has_post_thumbnail() ) {
				echo get_the_post_thumbnail( $post_id, 'large', array( 'loading' => 'lazy' ) );
			} else {
				?>
							<span style="display:flex;height:100%;align-items:center;justify-content:center;padding:1.25rem;color:#7c2d12;font-size:1rem;font-weight:700;text-align:center;">
				<?php echo esc_html( mb_strimwidth( get_the_title(), 0, 52, '...' ) ); ?>
							</span>
					<?php
			}
			?>
					</a>

					<div class="tptn-showcase__content">
						<div class="tptn-showcase__meta">
							<span class="tptn-showcase__rank"><?php echo esc_html( '#' . $rank ); ?></span>
							<span><?php echo esc_html( $category_name ); ?></span>
						</div>

						<h3 class="tptn-showcase__card-title">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array( 'echo' => false ) ); ?>">
			<?php the_title(); ?>
							</a>
						</h3>

						<p class="tptn-showcase__excerpt"><?php echo esc_html( $trimmed_text ); ?></p>

						<div class="tptn-showcase__footer">
							<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							<a class="tptn-showcase__readmore" href="<?php the_permalink(); ?>">
			<?php esc_html_e( 'Read story', 'top-10' ); ?>
							</a>
						</div>
					</div>
				</li>

			<?php
			++$rank;

		}

		?>
			</ul>
		</section>
		<?php

	}

	// Restore original post data.
	wp_reset_postdata();
}

if ( ! function_exists( 'tptn_render_showcase_styles' ) ) {
	/**
	 * Outputs the CSS used by the Top Ten showcase example.
	 *
	 * @return void
	 */
	function tptn_render_showcase_styles() {
		?>
		<style>
			.tptn-showcase {
				--tptn-bg: linear-gradient(135deg, #0f172a 0%, #1e293b 48%, #334155 100%);
				--tptn-card: rgba(255, 255, 255, 0.92);
				--tptn-copy: #0f172a;
				--tptn-muted: #475569;
				--tptn-accent: #f97316;
				--tptn-border: rgba(255, 255, 255, 0.14);
				background: var(--tptn-bg);
				border-radius: 28px;
				color: #fff;
				margin: 2rem 0;
				overflow: hidden;
				padding: clamp(1.5rem, 4vw, 3rem);
				position: relative;
			}

			.tptn-showcase::before,
			.tptn-showcase::after {
				background: radial-gradient(circle, rgba(249, 115, 22, 0.22), transparent 65%);
				content: "";
				height: 18rem;
				position: absolute;
				width: 18rem;
			}

			.tptn-showcase::before {
				right: -4rem;
				top: -5rem;
			}

			.tptn-showcase::after {
				bottom: -6rem;
				left: -6rem;
			}

			.tptn-showcase__header,
			.tptn-showcase__grid {
				position: relative;
				z-index: 1;
			}

			.tptn-showcase__header {
				align-items: end;
				display: flex;
				flex-wrap: wrap;
				gap: 1rem;
				justify-content: space-between;
				margin-bottom: 1.75rem;
			}

			.tptn-showcase__eyebrow {
				color: #fdba74;
				display: block;
				font-size: 0.78rem;
				font-weight: 700;
				letter-spacing: 0.14em;
				margin-bottom: 0.5rem;
				text-transform: uppercase;
			}

			.tptn-showcase__title {
				font-size: clamp(1.75rem, 4vw, 3rem);
				font-weight: 700;
				letter-spacing: -0.04em;
				line-height: 1;
				margin: 0;
			}

			.tptn-showcase__intro {
				color: rgba(255, 255, 255, 0.78);
				font-size: 1rem;
				margin: 0.75rem 0 0;
				max-width: 42rem;
			}

			.tptn-showcase__badge {
				border: 1px solid var(--tptn-border);
				border-radius: 999px;
				color: #fff;
				font-size: 0.85rem;
				font-weight: 600;
				padding: 0.75rem 1rem;
				text-decoration: none;
				white-space: nowrap;
			}

			.tptn-showcase__grid {
				display: grid;
				gap: 1rem;
				grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
				list-style: none;
				margin: 0;
				padding: 0;
			}

			.tptn-showcase__card {
				background: var(--tptn-card);
				border: 1px solid rgba(255, 255, 255, 0.45);
				border-radius: 22px;
				box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
				color: var(--tptn-copy);
				display: flex;
				flex-direction: column;
				height: 100%;
				overflow: hidden;
			}

			.tptn-showcase__media {
				aspect-ratio: 16 / 10;
				background: linear-gradient(135deg, #fed7aa, #fb923c);
				display: block;
				overflow: hidden;
			}

			.tptn-showcase__media img {
				display: block;
				height: 100%;
				object-fit: cover;
				transition: transform 220ms ease;
				width: 100%;
			}

			.tptn-showcase__card:hover .tptn-showcase__media img,
			.tptn-showcase__card:focus-within .tptn-showcase__media img {
				transform: scale(1.04);
			}

			.tptn-showcase__content {
				display: flex;
				flex: 1;
				flex-direction: column;
				gap: 0.9rem;
				padding: 1.15rem;
			}

			.tptn-showcase__meta {
				align-items: center;
				color: var(--tptn-muted);
				display: flex;
				font-size: 0.82rem;
				font-weight: 600;
				gap: 0.65rem;
				text-transform: uppercase;
			}

			.tptn-showcase__rank {
				align-items: center;
				background: rgba(249, 115, 22, 0.14);
				border-radius: 999px;
				color: #c2410c;
				display: inline-flex;
				font-size: 0.78rem;
				height: 2rem;
				justify-content: center;
				min-width: 2rem;
				padding: 0 0.55rem;
			}

			.tptn-showcase__card-title {
				font-size: 1.15rem;
				line-height: 1.25;
				margin: 0;
			}

			.tptn-showcase__card-title a {
				color: inherit;
				text-decoration: none;
			}

			.tptn-showcase__card-title a:hover,
			.tptn-showcase__card-title a:focus {
				color: #c2410c;
			}

			.tptn-showcase__excerpt {
				color: var(--tptn-muted);
				flex: 1;
				font-size: 0.95rem;
				line-height: 1.6;
				margin: 0;
			}

			.tptn-showcase__footer {
				align-items: center;
				display: flex;
				justify-content: space-between;
				margin-top: auto;
			}

			.tptn-showcase__readmore {
				color: #c2410c;
				font-size: 0.9rem;
				font-weight: 700;
				text-decoration: none;
			}

			@media (max-width: 640px) {
				.tptn-showcase {
					border-radius: 20px;
				}

				.tptn-showcase__header {
					align-items: start;
					flex-direction: column;
				}

				.tptn-showcase__badge {
					white-space: normal;
				}
			}
		</style>
		<?php
	}
}
