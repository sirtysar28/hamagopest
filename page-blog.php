<?php
/**
 * Template halaman Blog (slug: blog) — daftar artikel modern.
 *
 * Kenapa template ini ada: halaman "Blog" yang berisi Query Loop block
 * (Gutenberg) bisa memunculkan artikel DOBEL bila block tersalin beberapa
 * kali. Template ini MENGABAIKAN isi editor halaman dan menampilkan
 * daftar artikel langsung dari theme:
 *   - Grid 3 kolom (2 kolom tablet, 1 kolom mobile)
 *   - 6 artikel per halaman
 *   - Pagination otomatis bila artikel lebih dari 6
 *
 * Bila halaman ini justru ingin dibangun bebas dengan Elementor, template
 * otomatis menyerah: selama halaman punya konten Elementor, konten itulah
 * yang dirender (bukan grid theme).
 *
 * @package hamagopest
 */

get_header();

$page_id   = get_queried_object_id();
$is_el     = $page_id && hamagopest_is_elementor_page( $page_id ) && hamagopest_elementor_has_content( $page_id );
$per_page  = (int) apply_filters( 'hamagopest_blog_posts_per_page', 6 );
$paged     = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? (int) get_query_var( 'page' ) : 1 );

if ( $is_el ) :

	/* ---- User membangun halaman ini sendiri via Elementor → hormati. ---- */
	while ( have_posts() ) :
		the_post();
		?>
		<div id="page-<?php the_ID(); ?>" <?php post_class( 'hmg-page-content' ); ?>>
			<div class="hmg-elementor-content">
				<?php
				the_content();
				wp_link_pages();
				?>
			</div>
		</div>
		<?php
	endwhile;

else :

	/* ---- Daftar artikel standar theme: grid 3 kolom + pagination. ---- */
	$q = new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'paged'               => $paged,
			'posts_per_page'      => $per_page,
			'ignore_sticky_posts' => true,
		)
	);

	$blog_title = $page_id ? get_the_title( $page_id ) : '';
	$blog_sub   = apply_filters(
		'hamagopest_blog_subtitle',
		__( 'Wawasan, tips, dan informasi terbaru seputar pengendalian hama untuk rumah dan bisnis Anda.', 'hamagopest' )
	);
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
			<p class="ph-lead" data-reveal="fade-up" data-delay="140"><?php echo esc_html( $blog_sub ); ?></p>
		</div>
	</section>

	<div class="hmg-section hmg-blog-listing">
		<div class="wrap">
			<?php if ( $q->have_posts() ) : ?>
				<div class="blog-grid cols-3">
					<?php
					$i = 0;
					while ( $q->have_posts() ) :
						$q->the_post();
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

				<?php
				if ( $q->max_num_pages > 1 ) :
					$big   = 999999999; /* placeholder unik untuk str_replace */
					$base  = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) );
					$links = paginate_links(
						array(
							'base'      => $base,
							'format'    => '?paged=%#%',
							'current'   => $paged,
							'total'     => (int) $q->max_num_pages,
							'mid_size'  => 2,
							'prev_text' => '&larr;',
							'next_text' => '&rarr;',
						)
					);
					if ( $links ) :
						?>
						<nav class="hmg-pagination navigation pagination" aria-label="<?php esc_attr_e( 'Navigasi artikel', 'hamagopest' ); ?>">
							<div class="nav-links"><?php echo wp_kses_post( $links ); ?></div>
						</nav>
						<?php
					endif;
				endif;
				?>
			<?php else : ?>
				<p class="no-posts"><?php esc_html_e( 'Belum ada artikel. Tambahkan post pertama Anda di menu Posts.', 'hamagopest' ); ?></p>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
	<?php
endif;

get_footer();
