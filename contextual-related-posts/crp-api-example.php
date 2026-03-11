<?php
/**
 * Visitor-facing example that renders a styled "Related Stories" block using CRP.
 *
 * @package Contextual_Related_Posts
 */

if ( class_exists( 'CRP_Query' ) ) {
	global $post;

	// You can customize these arguments. Refer to the WP_Query documentation for additional details.
	$args = array(
		'post'                => $post->ID,
		'limit'               => 6,
		'category_name'       => 'news',
		'ignore_sticky_posts' => 1,
	);

	$my_query = new \CRP_Query( $args );

	if ( $my_query->have_posts() ) {
		?>

		<section class="crp-showcase" aria-labelledby="crp-showcase-title">
		<?php crp_render_showcase_styles(); ?>

			<header class="crp-showcase__header">
				<div>
					<span class="crp-showcase__eyebrow"><?php esc_html_e( 'Keep Reading', 'contextual-related-posts' ); ?></span>
					<h2 class="crp-showcase__title" id="crp-showcase-title"><?php esc_html_e( 'Related Stories You Might Like', 'contextual-related-posts' ); ?></h2>
					<p class="crp-showcase__intro">
		<?php esc_html_e( 'These picks are selected automatically based on the current article so visitors can discover more relevant content.', 'contextual-related-posts' ); ?>
					</p>
				</div>
				<span class="crp-showcase__badge"><?php esc_html_e( 'Filtered to the news category', 'contextual-related-posts' ); ?></span>
			</header>

			<ul class="crp-showcase__grid">
		<?php
		// Start looping over the query results.
		while ( $my_query->have_posts() ) {
			$my_query->the_post();
			$post_id       = get_the_ID();
			$excerpt       = get_the_excerpt();
			$trimmed_text  = $excerpt ? wp_trim_words( $excerpt, 18, '...' ) : wp_trim_words( wp_strip_all_tags( get_the_content() ), 18, '...' );
			$category      = get_the_category();
			$category_name = ! empty( $category ) ? $category[0]->name : __( 'Related Post', 'contextual-related-posts' );
			?>

					<li <?php post_class( 'crp-showcase__card' ); ?>>
						<a class="crp-showcase__media" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			if ( has_post_thumbnail() ) {
					echo get_the_post_thumbnail( $post_id, 'large', array( 'loading' => 'lazy' ) );
			} else {
				?>
								<span style="display:flex;height:100%;align-items:center;justify-content:center;padding:1.25rem;color:#0f766e;font-size:1rem;font-weight:700;text-align:center;">
				<?php echo esc_html( mb_strimwidth( get_the_title(), 0, 52, '...' ) ); ?>
								</span>
					<?php
			}
			?>
						</a>

						<div class="crp-showcase__content">
							<div class="crp-showcase__meta">
								<span class="crp-showcase__pill"><?php esc_html_e( 'Related', 'contextual-related-posts' ); ?></span>
								<span><?php echo esc_html( $category_name ); ?></span>
							</div>

							<h3 class="crp-showcase__card-title">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array( 'echo' => false ) ); ?>">
			<?php the_title(); ?>
								</a>
							</h3>

							<p class="crp-showcase__excerpt"><?php echo esc_html( $trimmed_text ); ?></p>

							<div class="crp-showcase__footer">
								<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
								<a class="crp-showcase__readmore" href="<?php the_permalink(); ?>">
			<?php esc_html_e( 'Read next', 'contextual-related-posts' ); ?>
								</a>
							</div>
						</div>
					</li>

			<?php
		}
		?>
			</ul>
		</section>
		<?php
	}

	// Restore original post data.
	wp_reset_postdata();
}

if ( ! function_exists( 'crp_render_showcase_styles' ) ) {
	/**
	 * Outputs the CSS used by the CRP showcase example.
	 *
	 * @return void
	 */
	function crp_render_showcase_styles() {
		?>
		<style>
			.crp-showcase {
				--crp-bg: linear-gradient(145deg, #172554 0%, #1d4ed8 46%, #38bdf8 100%);
				--crp-card: rgba(255, 255, 255, 0.95);
				--crp-copy: #0f172a;
				--crp-muted: #475569;
				--crp-accent: #0f766e;
				--crp-border: rgba(255, 255, 255, 0.2);
				background: var(--crp-bg);
				border-radius: 28px;
				color: #fff;
				margin: 2rem 0;
				overflow: hidden;
				padding: clamp(1.5rem, 4vw, 3rem);
				position: relative;
			}

			.crp-showcase::before,
			.crp-showcase::after {
				background: radial-gradient(circle, rgba(255, 255, 255, 0.18), transparent 68%);
				content: "";
				height: 18rem;
				position: absolute;
				width: 18rem;
			}

			.crp-showcase::before {
				right: -4rem;
				top: -4rem;
			}

			.crp-showcase::after {
				bottom: -6rem;
				left: -5rem;
			}

			.crp-showcase__header,
			.crp-showcase__grid {
				position: relative;
				z-index: 1;
			}

			.crp-showcase__header {
				align-items: end;
				display: flex;
				flex-wrap: wrap;
				gap: 1rem;
				justify-content: space-between;
				margin-bottom: 1.75rem;
			}

			.crp-showcase__eyebrow {
				color: rgba(255, 255, 255, 0.72);
				display: block;
				font-size: 0.78rem;
				font-weight: 700;
				letter-spacing: 0.14em;
				margin-bottom: 0.5rem;
				text-transform: uppercase;
			}

			.crp-showcase__title {
				font-size: clamp(1.75rem, 4vw, 3rem);
				font-weight: 700;
				letter-spacing: -0.04em;
				line-height: 1;
				margin: 0;
			}

			.crp-showcase__intro {
				color: rgba(255, 255, 255, 0.86);
				font-size: 1rem;
				margin: 0.75rem 0 0;
				max-width: 42rem;
			}

			.crp-showcase__badge {
				border: 1px solid var(--crp-border);
				border-radius: 999px;
				color: #fff;
				font-size: 0.85rem;
				font-weight: 600;
				padding: 0.75rem 1rem;
				white-space: nowrap;
			}

			.crp-showcase__grid {
				display: grid;
				gap: 1rem;
				grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
				list-style: none;
				margin: 0;
				padding: 0;
			}

			.crp-showcase__card {
				background: var(--crp-card);
				border: 1px solid rgba(255, 255, 255, 0.45);
				border-radius: 22px;
				box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
				color: var(--crp-copy);
				display: flex;
				flex-direction: column;
				height: 100%;
				overflow: hidden;
			}

			.crp-showcase__media {
				aspect-ratio: 16 / 10;
				background: linear-gradient(135deg, #bfdbfe, #67e8f9);
				display: block;
				overflow: hidden;
			}

			.crp-showcase__media img {
				display: block;
				height: 100%;
				object-fit: cover;
				transition: transform 220ms ease;
				width: 100%;
			}

			.crp-showcase__card:hover .crp-showcase__media img,
			.crp-showcase__card:focus-within .crp-showcase__media img {
				transform: scale(1.04);
			}

			.crp-showcase__content {
				display: flex;
				flex: 1;
				flex-direction: column;
				gap: 0.9rem;
				padding: 1.15rem;
			}

			.crp-showcase__meta {
				align-items: center;
				color: var(--crp-muted);
				display: flex;
				font-size: 0.82rem;
				font-weight: 600;
				gap: 0.65rem;
				text-transform: uppercase;
			}

			.crp-showcase__pill {
				align-items: center;
				background: rgba(15, 118, 110, 0.12);
				border-radius: 999px;
				color: var(--crp-accent);
				display: inline-flex;
				font-size: 0.78rem;
				height: 2rem;
				justify-content: center;
				min-width: 2rem;
				padding: 0 0.7rem;
			}

			.crp-showcase__card-title {
				font-size: 1.15rem;
				line-height: 1.25;
				margin: 0;
			}

			.crp-showcase__card-title a {
				color: inherit;
				text-decoration: none;
			}

			.crp-showcase__card-title a:hover,
			.crp-showcase__card-title a:focus {
				color: var(--crp-accent);
			}

			.crp-showcase__excerpt {
				color: var(--crp-muted);
				flex: 1;
				font-size: 0.95rem;
				line-height: 1.6;
				margin: 0;
			}

			.crp-showcase__footer {
				align-items: center;
				display: flex;
				justify-content: space-between;
				margin-top: auto;
			}

			.crp-showcase__readmore {
				color: var(--crp-accent);
				font-size: 0.9rem;
				font-weight: 700;
				text-decoration: none;
			}

			@media (max-width: 640px) {
				.crp-showcase {
					border-radius: 20px;
				}

				.crp-showcase__header {
					align-items: start;
					flex-direction: column;
				}

				.crp-showcase__badge {
					white-space: normal;
				}
			}
		</style>
		<?php
	}
}

