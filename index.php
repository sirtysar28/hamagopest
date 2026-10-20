<?php
/**
 * Fallback template utama (dipakai juga untuk listing Blog bila halaman
 * Blog di-set sebagai "Posts page" di Settings → Reading).
 *
 * @package hamagopest
 */

get_header();

/* Jika Elementor Pro Theme Builder punya template archive, pakai itu. */
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) :
?>

<div class="hmg-page-wrap">

	<?php if ( have_posts() ) : ?>

		<?php
		if ( is_home() && ! is_front_page() ) :
			$posts_page_id = (int) get_option( 'page_for_posts' );
			$blog_title    = $posts_page_id ? get_the_title( $posts_page_id ) : '';
			?>
			<section class="hmg-pagehero hmg-pagehero--blog">
				<span class="ph-blob ph-blob--1" aria-hidden="true"></span>
				<span class="ph-blob ph-blob--2" aria-hidden="true"></span>
				<span class="ph-grid" aria-hidden="true"></span>
				<span class="ph-ring" aria-hidden="true"></span>
				<div class="wrap ph-inner">
					<nav class="ph-crumb" data-reveal="fade-up" aria-label="<?php esc_attr_e( 'Navigasi breadcrumb', 'hamagopest' ); ?>">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Beranda', 'hamagopest' ); ?></a>
						<span class="ph-crumb-sep" aria-hidden="true">/</span>
						<span class="ph-crumb-cur"><?php echo esc_html( $blog_title ? $blog_title : __( 'Blog', 'hamagopest' ) ); ?></span>
					</nav>
					<h1 data-reveal="fade-up" data-delay="70"><?php echo esc_html( $blog_title ? $blog_title : __( 'Artikel &amp; Wawasan', 'hamagopest' ) ); ?></h1>
					<p class="ph-lead" data-reveal="fade-up" data-delay="140"><?php esc_html_e( 'Wawasan, tips, dan informasi terbaru seputar pengendalian hama untuk rumah dan bisnis Anda.', 'hamagopest' ); ?></p>
				</div>
			</section>
		<?php endif; ?>

		<div class="hmg-section hmg-blog-listing<?php echo ( is_home() && ! is_front_page() ) ? '' : ' hmg-page-wrap'; ?>">
			<div class="wrap">
				<div class="blog-grid cols-3">
					<?php
					$i = 0;
					while ( have_posts() ) :
						the_post();
						?>
						<article <?php post_class( 'blog-card' ); ?> data-reveal="fade-up" data-delay="<?php echo esc_attr( ( $i % 3 ) * 100 ); ?>">
							<a class="blog-thumb-link" href="<?php the_permalink(); ?>">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'hamagopest-card', array( 'class' => 'blog-thumb-img' ) ); ?>
								<?php else : ?>
									<div class="blog-thumb"></div>
								<?php endif; ?>
							</a>
							<div class="blog-body">
								<div class="blog-meta">
									<span class="blog-tag"><?php echo esc_html( hamagopest_first_category( get_the_ID() ) ); ?></span>
									<time class="blog-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
								</div>
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
								<a class="more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Baca selengkapnya', 'hamagopest' ); ?> <span aria-hidden="true">→</span></a>
							</div>
						</article>
					<?php
						$i++;
					endwhile;
					?>
				</div>

				<?php hamagopest_pagination(); ?>
			</div>
		</div>

	<?php else : ?>

		<div class="hmg-section">
			<div class="wrap">
				<div class="no-posts">
					<h1><?php esc_html_e( 'Tidak ditemukan', 'hamagopest' ); ?></h1>
					<p><?php esc_html_e( 'Maaf, tidak ada konten yang cocok. Coba cari dengan kata kunci lain.', 'hamagopest' ); ?></p>
					<?php get_search_form(); ?>
				</div>
			</div>
		</div>

	<?php endif; ?>

</div>

<?php endif; ?>

<?php get_footer();
