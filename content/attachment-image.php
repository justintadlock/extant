<?php if ( is_attachment( get_the_ID() ) ) : // If viewing a single attachment. ?>

	<article <?php hybrid_attr( 'post' ); ?>>

		<header class="entry-header">
			<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php single_post_title(); ?></h1>
		</header><!-- .entry-header -->

		<?php if ( has_excerpt() ) : // If the image has an excerpt/caption. ?>

			<?php $src = wp_get_attachment_image_src( get_the_ID(), 'full' ); ?>

			<div class="featured-media">
				<?php echo img_caption_shortcode( array( 'align' => 'aligncenter', 'width' => esc_attr( $src[1] ), 'caption' => get_the_excerpt() ), wp_get_attachment_image( get_the_ID(), 'extant-large', false ) ); ?>
			</div><!-- .featured-media -->

		<?php else : // If the image doesn't have a caption. ?>

			<div class="featured-media">
				<?php echo wp_get_attachment_image( get_the_ID(), 'extant-large', false, array( 'class' => 'aligncenter' ) ); ?>
			</div><!-- .featured-media -->

		<?php endif; // End check for image caption. ?>

		<div <?php hybrid_attr( 'entry-content' ); ?>>
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div><!-- .entry-content -->

		<div class="attachment-meta">

			<div class="media-info">

				<h3 class="attachment-meta-title"><?php _e( 'Image Info', 'extant' ); ?></h3>

				<ul class="media-meta">
					<?php $pre = '<li><span class="prep">%s</span>'; ?>
					<?php hybrid_media_meta( 'dimensions',        array( 'before' => sprintf( $pre, esc_html__( 'Dimensions',    'extant' ) ), 'after' => '</li>' ) ); ?>
					<?php hybrid_media_meta( 'created_timestamp', array( 'before' => sprintf( $pre, esc_html__( 'Date',          'extant' ) ), 'after' => '</li>' ) ); ?>
					<?php hybrid_media_meta( 'camera',            array( 'before' => sprintf( $pre, esc_html__( 'Camera',        'extant' ) ), 'after' => '</li>' ) ); ?>
					<?php hybrid_media_meta( 'aperture',          array( 'before' => sprintf( $pre, esc_html__( 'Aperture',      'extant' ) ), 'after' => '</li>' ) ); ?>
					<?php hybrid_media_meta( 'focal_length',      array( 'before' => sprintf( $pre, esc_html__( 'Focal Length',  'extant' ) ), 'after' => '</li>', 'text' => esc_html__( '%s mm', 'extant' ) ) ); ?>
					<?php hybrid_media_meta( 'iso',               array( 'before' => sprintf( $pre, esc_html__( 'ISO',           'extant' ) ), 'after' => '</li>' ) ); ?>
					<?php hybrid_media_meta( 'shutter_speed',     array( 'before' => sprintf( $pre, esc_html__( 'Shutter Speed', 'extant' ) ), 'after' => '</li>', 'text' => esc_html__( '%s sec', 'extant' ) ) ); ?>
					<?php hybrid_media_meta( 'file_type',         array( 'before' => sprintf( $pre, esc_html__( 'Type',          'extant' ) ), 'after' => '</li>' ) ); ?>
					<?php hybrid_media_meta( 'file_name',         array( 'before' => sprintf( $pre, esc_html__( 'Name',          'extant' ) ), 'after' => '</li>' ) ); ?>
					<?php hybrid_media_meta( 'mime_type',         array( 'before' => sprintf( $pre, esc_html__( 'Mime Type',     'extant' ) ), 'after' => '</li>' ) ); ?>
				</ul>

			</div><!-- .media-info -->

			<?php $gallery = gallery_shortcode( array( 'columns' => 4, 'numberposts' => 8, 'orderby' => 'rand', 'id' => get_queried_object()->post_parent, 'exclude' => get_the_ID() ) ); ?>

			<?php if ( $gallery ) : // Check if the gallery is not empty. ?>

				<div class="image-gallery">
					<h3 class="attachment-meta-title"><?php _e( 'Gallery', 'extant' ); ?></h3>
					<?php echo $gallery; ?>
				</div>

			<?php endif; // End gallery check. ?>

		</div><!-- .attachment-meta -->

	</article><!-- .entry -->

<?php else : // If not viewing a single attachment. ?>

	<article <?php hybrid_attr( 'post' ); ?>>

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

	</article><!-- .entry -->

<?php endif; // End single attachment check. ?>
