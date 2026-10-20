<?php
/**
 * Front page (homepage / beranda).
 *
 * Prioritas render:
 * 1. Halaman statis yang dibangun dengan Elementor → konten Elementor penuh
 *    (full-width, tanpa wrapper theme) sehingga homepage 100% bisa diedit
 *    via Elementor, termasuk widget "Hamago Elements".
 * 2. Halaman statis dengan konten biasa (Gutenberg/HTML).
 * 3. Belum ada halaman statis / konten masih kosong → homepage demo theme.
 *
 * Deteksi Elementor memakai meta _elementor_edit_mode (persis seperti
 * Elementor\Document::is_built_with_elementor()) DAN memastikan
 * _elementor_data tidak kosong — sehingga halaman yang baru "dibuka di
 * Elementor tapi belum diisi" tetap jatuh ke demo, bukan halaman blank.
 *
 * @package hamagopest
 */

get_header();

$front_id       = (int) get_option( 'page_on_front' );
$is_static_front = 'page' === get_option( 'show_on_front' )
	&& $front_id > 0
	&& ( get_queried_object() instanceof WP_Post );

$is_elementor_page = $is_static_front
	&& hamagopest_is_elementor_page( get_queried_object_id() )
	&& hamagopest_elementor_has_content( get_queried_object_id() );

if ( $is_elementor_page ) :
	?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<div id="hmg-front-content" class="hmg-page-content hmg-elementor-content">
			<?php the_content(); ?>
		</div>
	<?php endwhile; ?>

<?php elseif ( $is_static_front && trim( (string) get_queried_object()->post_content ) ) : ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<div id="hmg-front-content" class="hmg-page-content">
			<?php the_content(); ?>
		</div>
	<?php endwhile; ?>

<?php else : ?>

	<?php get_template_part( 'template-parts/home-demo' ); ?>

<?php endif; ?>

<?php get_footer(); ?>
