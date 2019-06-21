<?php
/**
 * This is a simple example that fetches the related posts for the current post ID
 * and displays the output in a custom format restricted by the 'news' category
 *
 * @package Contextual_Related_Posts
 */

if ( function_exists( 'get_crp_posts_id' ) ) {
	global $post;
	$scores    = get_crp_posts_id(
		array(
			'postid' => $post->ID,
			'limit'  => 7,
		)
	);
	$crp_posts = wp_list_pluck( (array) $scores, 'ID' );

	// You can customize these arguments. Refer to the WP_Query article in the codex for additional details.
	$args = array(
		'post__in'            => $crp_posts,
		'posts_per_page'      => 7,
		'category_name'       => 'news',
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
