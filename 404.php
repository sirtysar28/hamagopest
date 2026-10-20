<?php
/**
 * 404.
 *
 * @package hamagopest
 */

get_header();
?>

<div class="hmg-section error-404-wrap">
	<div class="wrap error-404-inner">
		<div class="err-code" data-reveal="zoom">4<span class="accent">0</span>4</div>
		<h1 data-reveal="fade-up" data-delay="80"><?php esc_html_e( 'Halaman tidak ditemukan', 'hamagopest' ); ?></h1>
		<p data-reveal="fade-up" data-delay="160"><?php esc_html_e( 'Sepertinya hama sudah memindahkan halaman ini. Coba cari atau kembali ke beranda.', 'hamagopest' ); ?></p>
		<div class="cta-row cta-row--center" data-reveal="fade-up" data-delay="240">
			<?php get_search_form(); ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-outline dark"><?php esc_html_e( 'Kembali ke Beranda', 'hamagopest' ); ?></a>
		</div>
	</div>
</div>

<?php get_footer(); ?>
