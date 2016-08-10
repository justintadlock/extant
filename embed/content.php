<div <?php post_class( 'wp-embed' ); ?>>

	<?php $image = get_the_image(
		array(
			'size'      => extant_get_featured_size(),
			'order'     => array( 'featured' ),
			'min_width' => extant_get_featured_min_width(),
			'echo'      => false
		)
	); ?>

	<?php echo $image ? $image : extant_get_featured_fallback(); ?>

	<p class="wp-embed-heading">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</p><!-- .wp-embed-heading -->

	<div class="wp-embed-excerpt">
		<?php the_excerpt_embed(); ?>
	</div><!-- .wp-embed-excerpt -->

	<?php do_action( 'embed_content' ); ?>

	<div class="wp-embed-footer">

		<?php the_embed_site_title() ?>

		<div class="wp-embed-meta">

			<a class="entry-permalink" href="<?php the_permalink(); ?>" rel="bookmark" itemprop="url"><time <?php hybrid_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time></a>
			<?php extant_comments_link( array( 'before' => sprintf( '<span class="sep">%s</span> ', _x( '&middot;', 'post meta separator', 'extant' ) ) ) ); ?>
			<span class="sep"><?php _ex( '&middot;', 'post meta separator', 'extant' ); ?></span>
			<button type="button" class="wp-embed-share-dialog-open" aria-label="<?php esc_attr_e( 'Open sharing dialog', 'extant' ); ?>"><?php _e( 'Share', 'extant' ); ?></button>

			<?php do_action( 'embed_content_meta' ); ?>
		</div><!-- .wp-embed-meta -->

	</div><!-- .wp-embed-footer -->

</div><!-- .wp-embed -->
