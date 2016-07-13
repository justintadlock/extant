<?php if ( get_theme_mod( 'enable_search_menu', true ) ) : ?>

	<li <?php hybrid_attr( 'menu', 'search' ); ?>>

		<h3 id="menu-search-title" class="menu-toggle-search">
			<button><span class="screen-reader-text"><?php esc_html_e( 'Search', 'extant' ); ?></span></button>
		</h3><!-- .menu-toggle-search -->

		<?php get_search_form(); ?>
	</li>

<?php endif; ?>
