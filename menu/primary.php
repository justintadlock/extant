<li <?php hybrid_attr( 'menu', 'primary' ); ?>>

	<h3 id="menu-primary-title" class="menu-toggle-primary">
		<?php printf(
			'<button>%s<span class="screen-reader-text">%s</span></button>',
			extant_get_menu_primary_i(),
			hybrid_get_menu_name( 'primary' )
		); ?>
	</h3><!-- .menu-primary-toggle -->

	<?php if ( has_nav_menu( 'primary' ) ) : ?>

		<?php wp_nav_menu(
			array(
				'theme_location'  => 'primary',
				'container'       => '',
				'menu_id'         => 'menu-primary-items',
				'menu_class'      => 'menu-items',
				'items_wrap'      => '<div class="wrap"><ul id="%s" class="%s">%s</ul></div>'
			)
		); ?>

	<?php else : ?>

		<?php wp_page_menu(
			array(
				'menu_class' => 'wrap',
				'before'     => '<ul id="menu-primary-items" class="menu-items">',
				'after'      => '</ul>'
			)
		); ?>

	<?php endif; ?>

</li><!-- #menu-primary -->
