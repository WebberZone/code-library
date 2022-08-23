<?php
/**
 * This is a simple example that fetches the popular posts for the current post ID
 * and displays the output in a custom format restricted by the 'news' category
 *
 * @package Top_Ten
 */

if ( function_exists( 'get_tptn_pop_posts' ) ) {
	global $post;

	// You can customize these arguments. Refer to the WP_Query documentation for additional details.
	$args = array(
		'daily'               => true,
		'daily_range'         => 30,
		'limit'               => 7,
		'ignore_sticky_posts' => 1,
	);

	$my_query = new Top_Ten_Query( $args );

	if ( $my_query->have_posts() ) {
		echo '<ul class="category posts popular-posts">';

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

