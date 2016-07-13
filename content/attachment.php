<article <?php hybrid_attr( 'post' ); ?>>

	<?php if ( is_attachment( get_the_ID() ) ) : // If viewing a single attachment. ?>

		<header class="entry-header">
			<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php single_post_title(); ?></h1>
		</header><!-- .entry-header -->

		<div class="featured-media">
			<?php hybrid_attachment(); // Function for handling non-image attachments. ?>
		</div><!-- .featured-media -->

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div><!-- .entry-content -->

	<?php else : // If not viewing a single attachment. ?>

		<?php $image = get_the_image(
			array(
				'size'         => 'extant-large',
				'srcset_sizes' => array( 'extant-large-2x' => '2x' ),
				'order'        => array( 'featured', 'default' ),
				'min_width'    => 750,
				'before'       => '<div class="featured-media">',
				'after'        => '</div>',
				'echo'         => false
			)
		); ?>

		<?php echo $image ? $image : extant_get_featured_fallback(); ?>

		<header class="entry-header">
			<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . get_permalink() . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>
		</header><!-- .entry-header -->

	<?php endif; // End single attachment check. ?>

</article><!-- .entry -->
