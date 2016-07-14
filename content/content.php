<article <?php hybrid_attr( 'post' ); ?>>

	<?php if ( is_single( get_the_ID() ) ) : // If viewing a single post. ?>

		<header class="entry-header">
			<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php single_post_title(); ?></h1>
		</header><!-- .entry-header -->

		<div <?php hybrid_attr( 'entry-content' ); ?>>
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div><!-- .entry-content -->

	<?php else : // If not viewing a single post. ?>

		<?php $image = get_the_image(
			array(
				'size'         => 'extant-large',
				'srcset_sizes' => array( 'extant-large-2x' => '2x' ),
				'order'        => array( 'featured' ),
				'min_width'    => is_home() && is_sticky() ? 950 : 750,
				'before'       => '<div class="featured-media">',
				'after'        => '</div>',
				'echo'         => false
			)
		); ?>

		<?php echo $image ? $image : extant_get_featured_fallback(); ?>

		<header class="entry-header">
			<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>
		</header><!-- .entry-header -->

	<?php endif; // End single post check. ?>

</article><!-- .entry -->
