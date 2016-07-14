<!DOCTYPE html>
<html <?php language_attributes( 'html' ); ?>>

<head <?php hybrid_attr( 'head' ); ?>>
<?php wp_head(); // Hook required for scripts, styles, and other <head> items. ?>
</head>

<body <?php hybrid_attr( 'body' ); ?>>

	<div id="container">

		<div class="skip-link">
			<a href="#content" class="screen-reader-text"><?php _e( 'Skip to content', 'extant' ); ?></a>
		</div><!-- .skip-link -->

		<header <?php hybrid_attr( 'header' ); ?>>

			<div id="branding" class="site-branding">
				<?php hybrid_site_title(); ?>
				<?php hybrid_site_description(); ?>
			</div><!-- #branding -->

			<?php hybrid_get_menu( 'super' ); // Loads the `menu/super.php` template. ?>

		</header><!-- #header -->

		<div class="below-site-header">

			<?php hybrid_get_menu( 'breadcrumbs' ); // Loads the menu/breadcrumbs.php template. ?>

			<div id="main" class="main">
