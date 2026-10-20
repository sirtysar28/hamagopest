<?php
/**
 * Comments template.
 *
 * @package hamagopest
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
			$count = get_comments_number();
			/* translators: %s = jumlah komentar */
			printf( esc_html( _n( '%s Komentar', '%s Komentar', $count, 'hamagopest' ) ), esc_html( number_format_i18n( $count ) ) );
			?>
		</h3>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 44,
				)
			);
			?>
		</ol>

		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'title_reply'        => __( 'Tinggalkan Komentar', 'hamagopest' ),
			'label_submit'       => __( 'Kirim Komentar', 'hamagopest' ),
			'class_submit'       => 'btn btn-gold',
			'comment_notes_before' => '',
		)
	);
	?>
</div>
