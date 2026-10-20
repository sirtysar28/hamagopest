<?php
/**
 * Halaman statis (termasuk halaman yang dibangun dengan Elementor).
 *
 * @package hamagopest
 */

get_header();
?>

<?php
while ( have_posts() ) :
	the_post();
	?>
	<div id="page-<?php the_ID(); ?>" <?php post_class( 'hmg-page-content' ); ?>>
		<?php
		/*
		 * Halaman yang dibangun penuh dengan Elementor dirender TANPA wrapper
		 * .single-content (max-width 780px) & tanpa judul otomatis, agar layout
		 * full-width / boxed Elementor tampil sesuai desain.
		 */
		$is_elementor = hamagopest_is_elementor_page();
		?>

		<?php if ( $is_elementor ) : ?>

			<div class="hmg-elementor-content">
				<?php
				the_content();
				wp_link_pages();
				?>
			</div>

		<?php else : ?>

			<header class="page-header hmg-section hmg-section--alt">
				<div class="wrap">
					<h1 data-reveal="fade-up"><?php the_title(); ?></h1>
				</div>
			</header>

			<div class="hmg-section hmg-section--plain">
				<div class="wrap single-content">
					<?php
					the_content();
					wp_link_pages();
					?>
				</div>
			</div>

			<?php
			if ( comments_open() || get_comments_number() ) {
				echo '<div class="hmg-section hmg-section--plain"><div class="wrap">';
				comments_template();
				echo '</div></div>';
			}
			?>

		<?php endif; ?>
	</div>
	<?php
endwhile;
?>

<?php get_footer(); ?>
