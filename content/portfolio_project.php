<article <?php hybrid_attr( 'post' ); ?>>

	<?php if ( is_single( get_the_ID() ) ) : // If viewing a single post. ?>

		<header class="entry-header">

			<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php single_post_title(); ?></h1>

			<div class="entry-byline">
				<?php hybrid_post_terms( array( 'taxonomy' => 'portfolio_category' ) ); ?>
				<?php hybrid_post_terms( array( 'taxonomy' => 'portfolio_tag', 'before' => sprintf( '<span class="sep">%s</span> ', _x( '&middot;', 'post meta separator', 'extant' ) ) ) ); ?>
			</div><!-- .entry-byline -->

		</header><!-- .entry-header -->

		<div <?php hybrid_attr( 'entry-content' ); ?>>
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php ccp_project_client(     array( 'wrap' => '<span %s><span class="project-key">' . __( 'Client',    'extant' ) . '</span> %s</span>' ) ); ?>
			<?php ccp_project_location(   array( 'wrap' => '<span %s><span class="project-key">' . __( 'Location',  'extant' ) . '</span> %s</span>' ) ); ?>
			<?php ccp_project_start_date( array( 'wrap' => '<span %s><span class="project-key">' . __( 'Started',   'extant' ) . '</span> %s</span>' ) ); ?>
			<?php ccp_project_end_date(   array( 'wrap' => '<span %s><span class="project-key">' . __( 'Completed', 'extant' ) . '</span> %s</span>' ) ); ?>
			<?php ccp_project_link(       array( 'text' => __( 'View Project Site', 'extant' ) ) ); ?>
		</footer><!-- .entry-footer -->

	<?php else : // If not viewing a single post. ?>

		<?php $image = get_the_image(
			array(
				'size'         => extant_get_featured_size(),
				'srcset_sizes' => array( extant_get_featured_size_2x() => '2x' ),
				'order'        => array( 'featured' ),
				'min_width'    => extant_get_featured_min_width(),
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
