<?php if ( has_nav_menu( 'secondary' ) ) : ?>

	<li <?php hybrid_attr( 'menu', 'secondary' ); ?>>

		<h3 id="menu-secondary-title" class="menu-toggle-secondary">
			<button><span class="screen-reader-text"><?php echo hybrid_get_menu_name( 'secondary' ); ?></span></button>
		</h3><!-- .menu-toggle -->

		<?php wp_nav_menu(
			array(
				'theme_location'  => 'secondary',
				'container'       => '',
				'menu_id'         => 'menu-secondary-items',
				'menu_class'      => 'menu-items',
				'items_wrap'      => '<div class="wrap"><ul id="%s" class="%s">%s</ul></div>'
			)
		); ?>
	</li>

<?php endif; ?>
