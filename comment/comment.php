<li <?php hybrid_attr( 'comment' ); ?>>

	<article>
		<?php extant_comment_parent_link(
			array(
				'depth'  => 3,
				'text'   => __( 'In reply to %s', 'extant' ),
				'before' => '<div class="comment-parent">',
				'after'  => '</div>'
			)
		); ?>

		<?php echo get_avatar( $comment ); ?>

		<div class="wrap">

			<div <?php hybrid_attr( 'comment-content' ); ?>>
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<footer class="comment-meta">
				<a <?php hybrid_attr( 'comment-permalink' ); ?>><time <?php hybrid_attr( 'comment-published' ); ?>><?php printf( __( '%s ago', 'extant' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?></time></a>
				<?php edit_comment_link( null, '<span class="sep">' . _x( '&middot;', 'comment meta separator', 'extant' ) . '</span>' ); ?>
				<?php hybrid_comment_reply_link( array( 'before' => '<span class="sep">' . _x( '&middot;', 'comment meta separator', 'extant' ) . '</span>' ) ); ?>
			</footer>

		</div>
	</article>

<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>
