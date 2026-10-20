<?php
/**
 * Homepage default — SELURUH konten bisa diedit via
 * Appearance → Customize → "Hamago Pest — Pengaturan" (section Homepage — ...).
 *
 * - Hero: 0 gambar = radar icon berputar | 1 gambar = background statis |
 *   2+ gambar = slider otomatis (overlay bayangan gelap, default 30%).
 * - Setiap section punya tombol show/hide; item kosong otomatis disembunyikan.
 *
 * @package hamagopest
 */

/** Shortcut ambil setting homepage (theme mod + default bersama). */
if ( ! function_exists( 'hmg_home_mod' ) ) {
	function hmg_home_mod( $id, $default = '' ) {
		return hamagopest_home_mod( $id, $default );
	}
}

/* ================= DATA DARI CUSTOMIZER ================= */

/* Hero — gambar Customizer jadi BACKGROUND di belakang animasi radar.
 * Nilai bisa URL (Image_Control) ATAU attachment ID (data lama). */
$hero_images = array();
for ( $i = 1; $i <= 5; $i++ ) {
	$raw = trim( (string) hmg_home_mod( 'hero_image_' . $i, '' ) );
	$url = '';
	if ( '' !== $raw && ctype_digit( $raw ) ) {
		$url = wp_get_attachment_url( absint( $raw ) );
	} elseif ( '' !== $raw ) {
		$url = esc_url_raw( $raw );
	}
	if ( $url ) {
		$hero_images[] = $url;
	}
}
$hero_has_media = ! empty( $hero_images );
$hero_is_slider = count( $hero_images ) > 1;
$hero_overlay   = max( 0, min( 90, absint( hmg_home_mod( 'hero_overlay', 30 ) ) ) );
$hero_speed     = max( 2, absint( hmg_home_mod( 'hero_slide_speed', 5 ) ) );
$hero_btn1_url  = hmg_home_mod( 'hero_btn1_url', '' );
$hero_btn1_url  = $hero_btn1_url ? $hero_btn1_url : hamagopest_wa_link();
$hero_btn2_url  = hmg_home_mod( 'hero_btn2_url', '#layanan' );

/* USP */
$usps = array();
for ( $i = 1; $i <= 4; $i++ ) {
	$title = hmg_home_mod( 'usp' . $i . '_title', '' );
	if ( '' === $title ) {
		continue;
	}
	$usps[] = array(
		'icon'  => hmg_home_mod( 'usp' . $i . '_icon', 'shield' ),
		'title' => $title,
		'desc'  => hmg_home_mod( 'usp' . $i . '_desc', '' ),
	);
}

/* About cells */
$cells = array();
for ( $i = 1; $i <= 4; $i++ ) {
	$value = hmg_home_mod( 'about_cell' . $i . '_value', '' );
	if ( '' === $value ) {
		continue;
	}
	$cells[] = array(
		'value' => $value,
		'label' => hmg_home_mod( 'about_cell' . $i . '_label', '' ),
	);
}

/* Services — repeater tak terbatas: gambar + icon + judul + deskripsi + metode + link */
$services = function_exists( 'hamagopest_services_items' ) ? hamagopest_services_items() : array();

/* Process */
$steps = array();
for ( $i = 1; $i <= 4; $i++ ) {
	$title = hmg_home_mod( 'proc' . $i . '_title', '' );
	if ( '' === $title ) {
		continue;
	}
	$steps[] = array(
		'title' => $title,
		'desc'  => hmg_home_mod( 'proc' . $i . '_desc', '' ),
	);
}

/* Clients — repeater tak terbatas: nama + logo + url */
$clients      = function_exists( 'hamagopest_clients_items' ) ? hamagopest_clients_items() : array();
$has_logo     = false;
foreach ( $clients as $cl ) {
	if ( ! empty( $cl['logo'] ) ) {
		$has_logo = true;
		break;
	}
}

/* Testimonials — repeater tak terbatas: isi + nama + jabatan + foto */
$testi           = function_exists( 'hamagopest_testi_items' ) ? hamagopest_testi_items() : array();
$is_testi_slider = count( $testi ) > 3; /* Lebih dari 3 → mode slider. */

/* Video CTA */
$video_url = hmg_home_mod( 'video_url', '' );

/* Booking */
$booking_btn_url = hmg_home_mod( 'booking_btn_url', '' );
$booking_btn_url = $booking_btn_url ? $booking_btn_url : hamagopest_wa_link();

/* Video CTA — video dibuka sebagai POPUP (lightbox), bukan tab baru. */
$video_embed = $video_url ? hamagopest_video_embed_url( $video_url ) : '';

$video_play = $video_embed
	? '<a class="play-btn" href="' . esc_url( $video_url ) . '" data-hmg-video="' . esc_attr( $video_embed ) . '" aria-haspopup="dialog"><svg class="hmg-ico" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg></a>'
	: '<span class="play-btn" aria-hidden="true"><svg class="hmg-ico" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg></span>';
?>
<?php if ( hmg_home_mod( 'hero_show', true ) ) : ?>
<!-- ================= HERO ================= -->
<section class="hero hmg-hero<?php echo $hero_has_media ? ' hero--has-media' : ''; ?>"<?php echo $hero_has_media ? ' style="--hmg-hero-overlay:' . esc_attr( $hero_overlay / 100 ) . ';"' : ''; ?>>
	<?php if ( $hero_has_media ) : ?>
		<div class="hero-media hmg-slider<?php echo $hero_is_slider ? ' hmg-slider--multi' : ''; ?>"<?php echo $hero_is_slider ? ' data-autoplay="' . esc_attr( $hero_speed * 1000 ) . '"' : ''; ?> aria-roledescription="<?php echo $hero_is_slider ? 'carousel' : 'img'; ?>">
			<?php foreach ( $hero_images as $i => $url ) : ?>
				<div class="hero-slide<?php echo 0 === $i ? ' is-active' : ''; ?>" style="background-image:url('<?php echo esc_url( $url ); ?>');"<?php echo 0 === $i ? '' : ' aria-hidden="true"'; ?> role="group" aria-label="<?php echo esc_attr( ( $i + 1 ) . ' / ' . count( $hero_images ) ); ?>"></div>
			<?php endforeach; ?>
		</div>
		<div class="hero-overlay" aria-hidden="true"></div>

		<?php if ( $hero_is_slider ) : ?>
			<button type="button" class="hmg-slider-nav hmg-slider-nav--prev" aria-label="<?php esc_attr_e( 'Slide sebelumnya', 'hamagopest' ); ?>">
				<svg class="hmg-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
			</button>
			<button type="button" class="hmg-slider-nav hmg-slider-nav--next" aria-label="<?php esc_attr_e( 'Slide berikutnya', 'hamagopest' ); ?>">
				<svg class="hmg-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 6l6 6-6 6"/></svg>
			</button>
			<div class="hmg-slider-dots">
				<?php foreach ( $hero_images as $i => $url ) : ?>
					<button type="button" class="hmg-slider-dot<?php echo 0 === $i ? ' is-active' : ''; ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Ke slide %d', 'hamagopest' ), $i + 1 ) ); ?>"></button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<div class="hero-blob hero-blob--1" data-hmg-parallax="0.22" aria-hidden="true"></div>
	<div class="hero-blob hero-blob--2" data-hmg-parallax="-0.16" aria-hidden="true"></div>

	<div class="wrap hero-grid">
		<div class="hero-copy">
			<?php if ( hmg_home_mod( 'hero_eyebrow', '' ) ) : ?>
				<div class="eyebrow" data-reveal="fade-up"><?php echo esc_html( hmg_home_mod( 'hero_eyebrow', '' ) ); ?></div>
			<?php endif; ?>
			<h1 data-reveal="fade-up" data-delay="80"><?php echo hamagopest_sanitize_heading( hmg_home_mod( 'hero_title', '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h1>
			<p class="lead" data-reveal="fade-up" data-delay="160"><?php echo esc_html( hmg_home_mod( 'hero_lead', '' ) ); ?></p>
			<div class="cta-row" data-reveal="fade-up" data-delay="240">
				<a href="<?php echo esc_url( $hero_btn1_url ); ?>" <?php echo ( 0 === strpos( $hero_btn1_url, 'http' ) ) ? 'target="_blank" rel="noopener"' : ''; ?> class="btn btn-gold"><?php echo esc_html( hmg_home_mod( 'hero_btn1_text', '' ) ); ?></a>
				<a href="<?php echo esc_url( $hero_btn2_url ); ?>" class="btn btn-outline dark"><?php echo esc_html( hmg_home_mod( 'hero_btn2_text', '' ) ); ?></a>
			</div>
			<?php
			$hero_stats = array();
			for ( $i = 1; $i <= 3; $i++ ) {
				$num = hmg_home_mod( 'hero_stat' . $i . '_number', '' );
				if ( '' !== $num ) {
					$hero_stats[] = array( $num, hmg_home_mod( 'hero_stat' . $i . '_label', '' ) );
				}
			}
			if ( $hero_stats ) :
				?>
			<div class="stat-strip" data-reveal="fade-up" data-delay="320">
				<?php foreach ( $hero_stats as $stat ) : ?>
					<div><b><?php echo esc_html( $stat[0] ); ?></b><span><?php echo esc_html( $stat[1] ); ?></span></div>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>

		<?php /* Radar + orbit icon — selalu tampil, persis demo asli. */ ?>
		<div class="radar-wrap" data-hmg-parallax="0.08" data-reveal="zoom" data-delay="150">
				<div class="radar-ring r1"></div>
				<div class="radar-ring r2"></div>
				<div class="radar-ring r3"></div>
				<div class="radar-pulse" aria-hidden="true"></div>
				<div class="radar-pulse rp2" aria-hidden="true"></div>
				<div class="radar-sweep" aria-hidden="true"></div>
				<div class="radar-core"><?php hamagopest_icon( 'shield-check', 'radar-core-ico' ); ?></div>
				<div class="orbit orbit--outer">
					<div class="chip-place" style="--a:10deg; --chip-top:1.5%; --ci:0;"><div class="chip-box"><span class="pest-chip pest-chip--pine"><?php hamagopest_icon( 'bug' ); ?></span></div></div>
					<div class="chip-place" style="--a:80deg; --chip-top:1.5%; --ci:1;"><div class="chip-box"><span class="pest-chip pest-chip--gold"><?php hamagopest_icon( 'termite' ); ?></span></div></div>
					<div class="chip-place" style="--a:150deg; --chip-top:1.5%; --ci:2;"><div class="chip-box"><span class="pest-chip pest-chip--pine"><?php hamagopest_icon( 'mosquito' ); ?></span></div></div>
					<div class="chip-place" style="--a:215deg; --chip-top:1.5%; --ci:3;"><div class="chip-box"><span class="pest-chip pest-chip--gold"><?php hamagopest_icon( 'rat' ); ?></span></div></div>
					<div class="chip-place" style="--a:285deg; --chip-top:1.5%; --ci:4;"><div class="chip-box"><span class="pest-chip pest-chip--pine"><?php hamagopest_icon( 'cockroach' ); ?></span></div></div>
				</div>
				<div class="orbit orbit--inner">
					<div class="chip-place" style="--a:30deg; --chip-top:13%; --ci:5;"><div class="chip-box"><span class="pest-chip pest-chip--gold"><?php hamagopest_icon( 'ant' ); ?></span></div></div>
					<div class="chip-place" style="--a:120deg; --chip-top:13%; --ci:6;"><div class="chip-box"><span class="pest-chip pest-chip--pine"><?php hamagopest_icon( 'spider' ); ?></span></div></div>
					<div class="chip-place" style="--a:240deg; --chip-top:13%; --ci:7;"><div class="chip-box"><span class="pest-chip pest-chip--gold"><?php hamagopest_icon( 'droplet' ); ?></span></div></div>
				</div>
			</div>
	</div>
</section>
<?php endif; ?>

<?php if ( hmg_home_mod( 'usp_show', true ) && $usps ) : ?>
<!-- ================= USP ================= -->
<section class="usp-section hmg-section hmg-section--pine">
	<div class="wrap">
		<div class="section-head usp-head">
			<?php if ( hmg_home_mod( 'usp_eyebrow', '' ) ) : ?>
				<div class="eyebrow" data-reveal="fade-up"><?php echo esc_html( hmg_home_mod( 'usp_eyebrow', '' ) ); ?></div>
			<?php endif; ?>
			<h2 data-reveal="fade-up" data-delay="60"><?php echo hamagopest_sanitize_heading( hmg_home_mod( 'usp_heading', '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			<p data-reveal="fade-up" data-delay="120"><?php echo esc_html( hmg_home_mod( 'usp_sub', '' ) ); ?></p>
		</div>
		<div class="usp-grid">
			<?php foreach ( $usps as $i => $item ) : ?>
				<div class="usp-item" data-reveal="fade-up" data-delay="<?php echo esc_attr( $i * 100 ); ?>">
					<?php hamagopest_icon( $item['icon'] ); ?>
					<h4><?php echo esc_html( $item['title'] ); ?></h4>
					<p><?php echo esc_html( $item['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( hmg_home_mod( 'about_show', true ) && ( $cells || hmg_home_mod( 'about_heading', '' ) ) ) : ?>
<!-- ================= ABOUT ================= -->
<section id="tentang" class="about hmg-section">
	<div class="wrap about-grid">
		<?php if ( $cells ) : ?>
			<div class="about-visual" data-hmg-parallax="0.1" data-reveal="fade-right">
				<?php foreach ( $cells as $i => $cell ) : ?>
					<div class="cell" data-reveal="zoom" data-delay="<?php echo esc_attr( $i * 90 ); ?>"><b><?php echo esc_html( $cell['value'] ); ?></b><span><?php echo esc_html( $cell['label'] ); ?></span></div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<div class="about-copy">
			<?php if ( hmg_home_mod( 'about_eyebrow', '' ) ) : ?>
				<div class="eyebrow" data-reveal="fade-up"><?php echo esc_html( hmg_home_mod( 'about_eyebrow', '' ) ); ?></div>
			<?php endif; ?>
			<h2 data-reveal="fade-up" data-delay="80"><?php echo hamagopest_sanitize_heading( hmg_home_mod( 'about_heading', '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			<p class="body" data-reveal="fade-up" data-delay="160"><?php echo esc_html( hmg_home_mod( 'about_body', '' ) ); ?></p>
			<?php if ( hmg_home_mod( 'about_btn_text', '' ) ) : ?>
				<a href="<?php echo esc_url( hmg_home_mod( 'about_btn_url', '#layanan' ) ); ?>" class="btn btn-outline dark" data-reveal="fade-up" data-delay="240"><?php echo esc_html( hmg_home_mod( 'about_btn_text', '' ) ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( hmg_home_mod( 'svc_show', true ) && $services ) : ?>
<!-- ================= SERVICES ================= -->
<section id="layanan" class="services hmg-section hmg-section--alt">
	<div class="wrap">
		<div class="section-head usp-head">
			<?php if ( hmg_home_mod( 'svc_eyebrow', '' ) ) : ?>
				<div class="eyebrow" data-reveal="fade-up"><?php echo esc_html( hmg_home_mod( 'svc_eyebrow', '' ) ); ?></div>
			<?php endif; ?>
			<h2 data-reveal="fade-up" data-delay="60"><?php echo hamagopest_sanitize_heading( hmg_home_mod( 'svc_heading', '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
		</div>
		<div class="services-grid cols-4">
			<?php foreach ( $services as $i => $svc ) : ?>
				<div class="svc-card<?php echo ! empty( $svc['image'] ) ? ' has-thumb' : ''; ?>" data-reveal="fade-up" data-delay="<?php echo esc_attr( ( $i % 4 ) * 90 ); ?>">
					<?php if ( ! empty( $svc['image'] ) ) : ?>
						<div class="svc-thumb">
							<img src="<?php echo esc_url( $svc['image'] ); ?>" alt="<?php echo esc_attr( $svc['title'] ); ?>" loading="lazy" />
							<span class="svc-thumb-icon"><?php hamagopest_icon( $svc['icon'] ); ?></span>
						</div>
					<?php endif; ?>
					<div class="svc-icon"><?php hamagopest_icon( $svc['icon'] ); ?></div>
					<h3><?php echo esc_html( $svc['title'] ); ?></h3>
					<p><?php echo esc_html( $svc['desc'] ); ?></p>
					<?php
					$methods = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $svc['methods'] ) ) );
					if ( $methods ) :
						?>
						<ul class="svc-list">
							<?php foreach ( $methods as $method ) : ?>
								<li><?php echo esc_html( $method ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<?php if ( ! empty( $svc['link'] ) ) : ?>
						<a class="more" href="<?php echo esc_url( $svc['link'] ); ?>"><?php esc_html_e( 'Selengkapnya', 'hamagopest' ); ?> <span aria-hidden="true">→</span></a>
					<?php else : ?>
						<span class="more"><?php esc_html_e( 'Selengkapnya', 'hamagopest' ); ?> <span aria-hidden="true">→</span></span>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( hmg_home_mod( 'proc_show', true ) && $steps ) : ?>
<!-- ================= PROCESS ================= -->
<section id="proses" class="process hmg-section hmg-section--alt process--sep">
	<div class="wrap">
		<div class="section-head usp-head">
			<?php if ( hmg_home_mod( 'proc_eyebrow', '' ) ) : ?>
				<div class="eyebrow" data-reveal="fade-up"><?php echo esc_html( hmg_home_mod( 'proc_eyebrow', '' ) ); ?></div>
			<?php endif; ?>
			<h2 data-reveal="fade-up" data-delay="60"><?php echo hamagopest_sanitize_heading( hmg_home_mod( 'proc_heading', '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
		</div>
		<div class="process-grid">
			<?php foreach ( $steps as $i => $step ) : ?>
				<div class="proc-item" data-reveal="fade-up" data-delay="<?php echo esc_attr( $i * 110 ); ?>">
					<div class="proc-num"><?php echo esc_html( $i + 1 ); ?></div>
					<h4><?php echo esc_html( $step['title'] ); ?></h4>
					<p><?php echo esc_html( $step['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( hmg_home_mod( 'video_show', true ) ) : ?>
<!-- ================= VIDEO CTA ================= -->
<section class="hmg-section hmg-section--plain video-cta-section">
	<div class="wrap">
		<div class="video-cta" data-hmg-parallax="0.06" data-reveal="fade-up">
			<div class="video-cta-copy">
				<?php if ( hmg_home_mod( 'video_eyebrow', '' ) ) : ?>
					<div class="eyebrow eyebrow--gold" data-reveal="fade-up"><?php echo esc_html( hmg_home_mod( 'video_eyebrow', '' ) ); ?></div>
				<?php endif; ?>
				<h2 data-reveal="fade-up" data-delay="80"><?php echo hamagopest_sanitize_heading( hmg_home_mod( 'video_heading', '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
				<p data-reveal="fade-up" data-delay="160"><?php echo esc_html( hmg_home_mod( 'video_sub', '' ) ); ?></p>
			</div>
			<div class="video-cta-play">
				<?php echo $video_play; // phpcs:ignore WordPress.Security.EscapeOutput -- markup dibangun internal & di-escape. ?>
			</div>
		</div>
	</div>

	<?php if ( $video_embed ) : ?>
	<?php /* Modal popup video (lightbox) — iframe dibuat JS saat dibuka. */ ?>
	<div class="hmg-video-modal" id="hmgVideoModal" aria-hidden="true" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Video Hamago', 'hamagopest' ); ?>">
		<div class="hmg-video-backdrop" data-hmg-video-close></div>
		<div class="hmg-video-box">
			<button type="button" class="hmg-video-close" data-hmg-video-close aria-label="<?php esc_attr_e( 'Tutup video', 'hamagopest' ); ?>">&times;</button>
			<div class="hmg-video-frame" data-hmg-video-frame></div>
		</div>
	</div>
	<?php endif; ?>
</section>
<?php endif; ?>

<?php if ( hmg_home_mod( 'clients_show', true ) && $clients ) : ?>
<!-- ================= CLIENTS ================= -->
<section class="clients-section hmg-section clients--tight">
	<div class="wrap">
		<?php if ( hmg_home_mod( 'clients_eyebrow', '' ) ) : ?>
			<div class="eyebrow" data-reveal="fade-up"><?php echo esc_html( hmg_home_mod( 'clients_eyebrow', '' ) ); ?></div>
		<?php endif; ?>
		<h2 class="clients-title" data-reveal="fade-up" data-delay="80"><?php echo esc_html( hmg_home_mod( 'clients_heading', '' ) ); ?></h2>

		<?php if ( $has_logo ) : ?>
			<?php
			/* Slider logo berjalan otomatis & looping — track digandakan agar mulus. */
			$speed = max( 18, count( $clients ) * 4 );
			?>
			<div class="clients-marquee" data-reveal="fade-up" data-delay="140" style="--hmg-marquee-duration:<?php echo esc_attr( $speed ); ?>s;">
				<div class="clients-track">
					<?php for ( $copy = 0; $copy < 2; $copy++ ) : ?>
						<?php foreach ( $clients as $cl ) : ?>
							<?php
							$inner = ! empty( $cl['logo'] )
								? '<img src="' . esc_url( $cl['logo'] ) . '" alt="' . esc_attr( $cl['name'] ) . '" loading="lazy" />'
								: '<span class="client-pill">' . esc_html( $cl['name'] ) . '</span>';
							?>
							<?php if ( ! empty( $cl['url'] ) ) : ?>
								<a class="client-logo" href="<?php echo esc_url( $cl['url'] ); ?>" target="_blank" rel="noopener"><?php echo $inner; // phpcs:ignore ?></a>
							<?php else : ?>
								<span class="client-logo"><?php echo $inner; // phpcs:ignore ?></span>
							<?php endif; ?>
						<?php endforeach; ?>
				<?php endfor; ?>
				</div>
			</div>
		<?php else : ?>
			<div class="clients-strip" data-reveal="fade-up" data-delay="140">
				<?php foreach ( $clients as $cl ) : ?>
					<span class="client-pill"><?php echo esc_html( $cl['name'] ); ?></span>
					<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<?php if ( hmg_home_mod( 'testi_show', true ) && $testi ) : ?>
<!-- ================= TESTIMONIALS ================= -->
<section id="testimoni" class="testimonials hmg-section<?php echo $is_testi_slider ? ' testi-has-slider' : ''; ?>">
	<div class="wrap">
		<div class="section-head usp-head">
			<?php if ( hmg_home_mod( 'testi_eyebrow', '' ) ) : ?>
				<div class="eyebrow" data-reveal="fade-up"><?php echo esc_html( hmg_home_mod( 'testi_eyebrow', '' ) ); ?></div>
			<?php endif; ?>
			<h2 data-reveal="fade-up" data-delay="60"><?php echo hamagopest_sanitize_heading( hmg_home_mod( 'testi_heading', '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
		</div>
		<div class="testi-grid<?php echo $is_testi_slider ? ' is-slider' : ''; ?>"<?php echo $is_testi_slider ? ' data-testi-slider' : ''; ?>>
			<?php foreach ( $testi as $i => $t ) : ?>
				<div class="testi-card"<?php echo $is_testi_slider ? '' : ' data-reveal="fade-up" data-delay="' . esc_attr( $i * 100 ) . '"'; ?>>
					<div class="testi-stars" aria-label="5/5">
						<?php for ( $st = 0; $st < 5; $st++ ) : ?>
							<svg class="hmg-ico star" viewBox="0 0 24 24" fill="currentColor" stroke="none" aria-hidden="true"><path d="M12 3l2.7 5.6 6.1.8-4.5 4.3 1.1 6-5.4-3-5.4 3 1.1-6L3.2 9.4l6.1-.8L12 3z"/></svg>
						<?php endfor; ?>
					</div>
					<p class="testi-quote"><?php echo esc_html( $t['quote'] ); ?></p>
					<div class="testi-who">
						<?php if ( ! empty( $t['avatar'] ) ) : ?>
							<img class="avatar avatar-img" src="<?php echo esc_url( $t['avatar'] ); ?>" alt="<?php echo esc_attr( $t['name'] ); ?>" loading="lazy" />
						<?php else : ?>
							<div class="avatar"><?php echo esc_html( mb_substr( (string) $t['name'], 0, 1 ) ); ?></div>
						<?php endif; ?>
						<div><b><?php echo esc_html( $t['name'] ); ?></b><span><?php echo esc_html( $t['role'] ); ?></span></div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php if ( $is_testi_slider ) : ?>
			<div class="testi-nav" data-testi-nav>
				<button type="button" class="testi-nav-btn testi-nav-btn--prev" aria-label="<?php esc_attr_e( 'Testimoni sebelumnya', 'hamagopest' ); ?>"><svg class="hmg-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M12 19l-7-7 7-7"/></svg></button>
				<button type="button" class="testi-nav-btn testi-nav-btn--next" aria-label="<?php esc_attr_e( 'Testimoni berikutnya', 'hamagopest' ); ?>"><svg class="hmg-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16M13 5l7 7-7 7"/></svg></button>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<!-- ================= ARTIKEL TERBARU (otomatis dari posts) ================= -->
<section id="blog" class="blog-section hmg-section hmg-section--alt">
	<div class="wrap">
		<div class="section-head usp-head">
			<div class="eyebrow" data-reveal="fade-up"><?php esc_html_e( 'Artikel', 'hamagopest' ); ?></div>
			<h2 data-reveal="fade-up" data-delay="60"><?php esc_html_e( 'Wawasan seputar hama dan pencegahannya', 'hamagopest' ); ?></h2>
		</div>

		<?php
		$blog_q = new WP_Query(
			array(
				'post_type'           => 'post',
				'posts_per_page'      => 3,
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			)
		);
		?>
		<?php if ( $blog_q->have_posts() ) : ?>
		<div class="blog-grid cols-3">
			<?php
			$i = 0;
			while ( $blog_q->have_posts() ) :
				$blog_q->the_post();
				?>
				<article class="blog-card" data-reveal="fade-up" data-delay="<?php echo esc_attr( $i * 100 ); ?>">
					<a class="blog-thumb-link" href="<?php the_permalink(); ?>">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'hamagopest-card', array( 'class' => 'blog-thumb-img' ) ); ?>
						<?php else : ?>
							<div class="blog-thumb"></div>
						<?php endif; ?>
					</a>
					<div class="blog-body">
						<span class="blog-tag"><?php echo esc_html( hamagopest_first_category( get_the_ID() ) ); ?></span>
						<h3><a href="<?php the_permalink(); ?>"><?php echo esc_html( wp_trim_words( get_the_title(), 10 ) ); ?></a></h3>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
					</div>
				</article>
			<?php
				$i++;
			endwhile;
			wp_reset_postdata();
			?>
		</div>
		<div class="section-cta" data-reveal="fade-up" data-delay="200">
			<a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="btn btn-outline dark"><?php esc_html_e( 'Lihat Semua Artikel', 'hamagopest' ); ?></a>
		</div>
		<?php else : ?>
		<p class="no-posts"><?php esc_html_e( 'Belum ada artikel diterbitkan.', 'hamagopest' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php if ( hmg_home_mod( 'booking_show', true ) ) : ?>
<!-- ================= BOOKING ================= -->
<section id="kontak" class="booking hmg-section hmg-section--gold booking-tight">
	<div class="wrap booking-flex" data-hmg-parallax="0.05">
		<div class="booking-copy" data-reveal="fade-right">
			<h2><?php echo hamagopest_sanitize_heading( hmg_home_mod( 'booking_heading', '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
			<p><?php echo esc_html( hmg_home_mod( 'booking_sub', '' ) ); ?></p>
		</div>
		<a href="<?php echo esc_url( $booking_btn_url ); ?>" target="_blank" rel="noopener" class="btn btn-pine booking-btn" data-reveal="fade-left" data-delay="120">
			<svg class="hmg-ico" viewBox="0 0 24 24" fill="currentColor" stroke="none" aria-hidden="true"><path d="M12 2C6.5 2 2 6.5 2 12c0 1.8.5 3.5 1.3 5L2 22l5.2-1.4c1.4.8 3.1 1.2 4.8 1.2 5.5 0 10-4.5 10-10S17.5 2 12 2zm5.9 14.2c-.2.7-1.4 1.3-2 1.4-.5.1-1.1.2-3.6-.8-3-1.2-4.9-4.2-5.1-4.4-.1-.2-1.2-1.6-1.2-3 0-1.4.7-2.1 1-2.4.3-.3.6-.3.8-.3h.6c.2 0 .5 0 .7.6.3.7.9 2.2 1 2.4.1.2.1.4 0 .6-.1.2-.2.4-.4.6-.2.2-.4.5-.6.6-.2.2-.4.4-.2.8.2.4 1 1.6 2.1 2.6 1.4 1.3 2.6 1.7 3 1.9.4.2.6.1.9-.1.3-.3.9-1.1 1.2-1.5.3-.4.5-.3.9-.2.4.2 2.3 1.1 2.7 1.3.4.2.6.3.7.4.1.2.1.9-.1 1.5z"/></svg>
			<?php echo esc_html( hmg_home_mod( 'booking_btn_text', '' ) ); ?>
		</a>
	</div>
</section>
<?php endif; ?>
