<?php if ( is_attachment( get_the_ID() ) ) : // If viewing a single attachment. ?>

	<article <?php hybrid_attr( 'post' ); ?>>

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

	</article><!-- .entry -->

	<div class="attachment-meta">

		<div class="media-info">

			<h3><?php _e( 'Video Info', 'extant' ); ?></h3>

			<ul class="media-meta">
				<?php $pre = '<li><span class="prep">%s</span>'; ?>
				<?php hybrid_media_meta( 'length_formatted',  array( 'before' => sprintf( $pre, esc_html__( 'Run Time',      'extant' ) ), 'after' => '</li>' ) ); ?>
				<?php hybrid_media_meta( 'dimensions',        array( 'before' => sprintf( $pre, esc_html__( 'Dimensions',    'extant' ) ), 'after' => '</li>' ) ); ?>
				<?php hybrid_media_meta( 'file_type',         array( 'before' => sprintf( $pre, esc_html__( 'Type',          'extant' ) ), 'after' => '</li>' ) ); ?>
				<?php hybrid_media_meta( 'file_name',         array( 'before' => sprintf( $pre, esc_html__( 'Name',          'extant' ) ), 'after' => '</li>' ) ); ?>
				<?php hybrid_media_meta( 'mime_type',         array( 'before' => sprintf( $pre, esc_html__( 'Mime Type',     'extant' ) ), 'after' => '</li>' ) ); ?>
			</ul>

		</div><!-- .media-info -->

	</div><!-- .attachment-meta -->

<?php else : // If not viewing a single attachment. ?>

	<article <?php hybrid_attr( 'post' ); ?>>

		<?php $image = get_the_image(
			array(
				'size'         => 'extant-large',
				'srcset_sizes' => array( 'extant-large-2x' => '2x' ),
				'order'        => array( 'featured' ),
				'min_width'    => 750,
				'before'       => '<div class="featured-media">',
				'after'        => '</div>',
				'echo'         => false
			)
		); ?>

		<?php echo $image ? $image : extant_get_featured_fallback(); ?>

		<header class="entry-header">
			<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>
		</header><!-- .entry-header -->

	</article><!-- .entry -->

<?php endif; // End single attachment check. ?>