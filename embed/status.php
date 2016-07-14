<div <?php post_class( 'wp-embed' ); ?>>

	<div class="wp-embed-content">
			<?php if ( get_option( 'show_avatars' ) ) : // If avatars are enabled. ?>
				<span class="avatar-wrap"><?php echo get_avatar( get_the_author_meta( 'email' ) ); ?></span>
			<?php endif; ?>

		<?php the_content(); ?>
	</div><!-- .wp-embed-content -->

	<?php do_action( 'embed_content' ); ?>

	<div class="wp-embed-footer">

		<?php the_embed_site_title() ?>

		<div class="wp-embed-meta">
			<?php extant_post_format_permalink(); ?>
			<?php do_action( 'embed_content_meta' ); ?>
		</div><!-- .wp-embed-meta -->

	</div><!-- .wp-embed-footer -->

</div><!-- .wp-embed -->