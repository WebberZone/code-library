<?php
/**
 * This is a simple example that fetches the popular posts for the current post ID
 * and displays the output in a custom format restricted by the 'news' category
 *
 * @package Top_Ten
 */

if ( function_exists( 'get_tptn_pop_posts' ) ) {
	global $post;

	$settings = array(
		'daily'        => true,
		'daily_range'  => 30,
		'limit'        => 20,
		'strict_limit' => false,
	);
	$topposts = get_tptn_pop_posts( $settings );

	$topposts = wp_list_pluck( (array) $topposts, 'postnumber' );

	// You can customize these arguments. Refer to the WP_Query article in the codex for additional details.
	$args = array(
		'post__in'            => $topposts,
		'orderby'             => 'post__in',
		'posts_per_page'      => 7,
		'ignore_sticky_posts' => 1,
	);

	$my_query = new WP_Query( $args );

	if ( $my_query->have_posts() ) {
		echo '<ul class="category posts crp_related">';

		// Start looping over the query results.
		while ( $query->have_posts() ) {

			$query->the_post();

			?>

			<li <?php post_class( 'left' ); ?>>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<?php the_title(); ?>
				</a>
			</li>

			<?php

		}

		echo '</ul>';

	}

	// Restore original post data.
	wp_reset_postdata();
}
