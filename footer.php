			</div><!-- #main -->

			<footer <?php hybrid_attr( 'footer' ); ?>>

				<div class="wrap">

					<p class="credit">
						<?php printf(
							// Translators: 1 is current year and 2 is site name/link,
							esc_html__( 'Copyright &#169; %1$s %2$s.', 'extant' ), date_i18n( 'Y' ), hybrid_get_site_link()
						); ?>
						<br />
						<?php printf(
							// Translators: 1 is WordPress name/link and 2 is theme name/link. */
							esc_html__( 'Powered by %1$s and %2$s.', 'extant' ), hybrid_get_wp_link(), hybrid_get_theme_link()
						); ?>
					</p><!-- .credit -->

				</div><!-- .wrap -->

			</footer><!-- #footer -->

		</div><!-- .below-site-header -->

	</div><!-- #container -->

	<?php wp_footer(); // WordPress hook for loading JavaScript, toolbar, and other things in the footer. ?>

</body>
</html>
