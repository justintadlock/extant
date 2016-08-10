<div <?php post_class( 'wp-embed' ); ?>>

	<div class="wp-embed-content">
		<?php the_content(); ?>
	</div><!-- .wp-embed-content -->

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
