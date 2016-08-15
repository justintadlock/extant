<li <?php hybrid_attr( 'comment' ); ?>>

	<div class="comment-meta">
		<cite <?php hybrid_attr( 'comment-author' ); ?>><?php comment_author_link(); ?></cite><br />
		<a <?php hybrid_attr( 'comment-permalink' ); ?>><time <?php hybrid_attr( 'comment-published' ); ?>><?php printf( __( '%s ago', 'extant' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?></time></a>
		<?php edit_comment_link( null, '<span class="sep">' . _x( '&middot;', 'comment meta separator', 'extant' ) . '</span>' ); ?>
	</div><!-- .comment-meta -->

<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>
