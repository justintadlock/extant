<article <?php hybrid_attr( 'post' ); ?>>

	<div class="wrap">

		<?php if ( is_single( get_the_ID() ) ) : // If viewing a single post. ?>

			<header class="entry-header">
				<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php single_post_title(); ?></h1>
			</header><!-- .entry-header -->

	<?php get_the_image(
		array(
			'size'         => 'extant-large',
			'order'        => array( 'featured' ),
			'link_to_post' => is_singular() ? false : true,
			'before'       => '<div class="featured-media">',
			'after'        => '</div>'
		)
	); ?>


	<?php if ( ! get_post_meta( get_the_ID(), '_edd_hide_purchase_link', true ) ) {
		echo edd_get_purchase_link();
	} ?>

			<div <?php hybrid_attr( 'entry-content' ); ?>>
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div><!-- .entry-content -->

			<footer class="entry-footer">
				<?php hybrid_post_terms( array( 'taxonomy' => 'download_category' ) ); ?>
				<?php hybrid_post_terms( array( 'taxonomy' => 'download_tag', 'before' => sprintf( '<span class="sep">%s</span> ', _x( '&middot;', 'post meta separator', 'extant' ) ) ) ); ?>
			</footer><!-- .entry-footer -->

		<?php else : // If not viewing a single post. ?>

	<?php $image = get_the_image(
		array(
			'size'         => 'extant-large',
			'srcset_sizes' => array( 'extant-large-2x' => '2x' ),
			'order'        => array( 'featured', 'default' ),
			'before'       => '<div class="featured-media">',
			'after'        => '</div>',
				'echo'         => false
			)
		); ?>

		<?php echo $image ? $image : extant_get_featured_fallback(); ?>

			<header class="entry-header">
				<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . get_permalink() . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>
			</header><!-- .entry-header -->

		<?php if ( function_exists( 'edd_price' ) ) edd_price(); ?>

		<?php endif; // End single post check. ?>

	</div><!-- .wrap -->

</article><!-- .entry -->