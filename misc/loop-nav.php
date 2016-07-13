<?php if ( hybrid_is_plural() ) : // If viewing the blog, an archive, or search results. ?>

	<?php the_posts_pagination(
		array(
			'type'      => 'list',
			'prev_text' => _x( 'Newer', 'posts navigation', 'extant' ),
			'next_text' => _x( 'Older', 'posts navigation', 'extant' )
		)
	); ?>

<?php endif; // End check for type of page being viewed. ?>
