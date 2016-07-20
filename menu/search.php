<?php if ( get_theme_mod( 'enable_search_menu', true ) ) : ?>

	<li <?php hybrid_attr( 'menu', 'search' ); ?>>

		<h3 id="menu-search-title" class="menu-toggle-search">
			<?php printf(
				'<button>%s<span class="screen-reader-text">%s</span></button>',
				extant_get_menu_search_i(),
				esc_html__( 'Search', 'extant' )
			); ?>
		</h3><!-- .menu-toggle-search -->

		<?php get_search_form(); ?>
	</li>

<?php endif; ?>
