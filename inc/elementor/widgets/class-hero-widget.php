<?php
/**
 * Elementor Widget: Hamago Hero — headline + radar dengan icon berputar (orbit).
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;

class Hamagopest_Hero_Widget extends Hamagopest_Widget_Base {

	public function get_name() {
		return 'hamago_hero';
	}

	public function get_title() {
		return __( 'Hamago — Hero (Icon Berputar)', 'hamagopest' );
	}

	public function get_icon() {
		return 'eicon-banner';
	}

	public function get_keywords() {
		return array( 'hero', 'hamago', 'pest', 'radar', 'orbit', 'animasi' );
	}

	protected function register_controls() {

		/* ============ KONTEN UTAMA ============ */
		$this->start_controls_section(
			'section_content',
			array( 'label' => __( 'Konten Hero', 'hamagopest' ) )
		);

		$this->add_control(
			'eyebrow',
			array(
				'label'   => __( 'Eyebrow', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Pest Control Bersertifikat', 'hamagopest' ),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => __( 'Judul Utama', 'hamagopest' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'default'     => __( 'Bebas hama, <span class="accent">bukan sekadar janji.</span>', 'hamagopest' ),
				'description' => __( 'Gunakan <span class="accent">teks</span> untuk aksen emas.', 'hamagopest' ),
			)
		);

		$this->add_control(
			'lead',
			array(
				'label'   => __( 'Paragraf Pengantar', 'hamagopest' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 4,
				'default' => __( 'Hamago menangani rayap, serangga, dan tikus sampai ke sumber masalahnya — dengan metode terukur, tenaga ahli berpengalaman, dan garansi layanan untuk rumah maupun bisnis Anda.', 'hamagopest' ),
			)
		);

		$this->add_control(
			'btn_primary_text',
			array(
				'label'   => __( 'Tombol Utama — Teks', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Ajukan Inspeksi Gratis', 'hamagopest' ),
			)
		);

		$this->add_control(
			'btn_primary_link',
			array(
				'label'       => __( 'Tombol Utama — Link', 'hamagopest' ),
				'type'        => Controls_Manager::URL,
				'default'     => array( 'url' => '#kontak' ),
				'placeholder' => 'https://',
			)
		);

		$this->add_control(
			'btn_secondary_text',
			array(
				'label'   => __( 'Tombol Kedua — Teks', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Lihat Layanan', 'hamagopest' ),
			)
		);

		$this->add_control(
			'btn_secondary_link',
			array(
				'label'       => __( 'Tombol Kedua — Link', 'hamagopest' ),
				'type'        => Controls_Manager::URL,
				'default'     => array( 'url' => '#layanan' ),
				'placeholder' => 'https://',
			)
		);

		$this->end_controls_section();

		/* ============ GAMBAR HERO (BACKGROUND / SLIDER) ============ */
		$this->start_controls_section(
			'section_media',
			array( 'label' => __( 'Gambar Hero (Background / Slider)', 'hamagopest' ) )
		);

		$this->add_control(
			'hero_images',
			array(
				'label'       => __( 'Upload Gambar', 'hamagopest' ),
				'type'        => Controls_Manager::GALLERY,
				'description' => __( 'Kosong = hero radar default. 1 gambar = background statis. Upload lebih dari 1 gambar = otomatis menjadi SLIDER.', 'hamagopest' ),
			)
		);

		$this->add_control(
			'overlay_strength',
			array(
				'label'       => __( 'Bayangan Gelap (Overlay)', 'hamagopest' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( '%' ),
				'range'       => array( '%' => array( 'min' => 0, 'max' => 90, 'step' => 1 ) ),
				'default'     => array( 'size' => 30, 'unit' => '%' ),
				'description' => __( 'Kegelapan overlay di atas gambar agar teks tetap terbaca — default 30%.', 'hamagopest' ),
			)
		);

		$this->add_control(
			'keep_radar',
			array(
				'label'        => __( 'Tampilkan Radar di Samping Teks', 'hamagopest' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
				'description' => __( 'Jika nonaktif, teks hero ditampilkan di tengah di atas gambar/slider.', 'hamagopest' ),
			)
		);

		$this->add_control(
			'slider_autoplay',
			array(
				'label'        => __( 'Slider Auto-play', 'hamagopest' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'description' => __( 'Hanya berlaku bila gambar lebih dari 1.', 'hamagopest' ),
			)
		);

		$this->add_control(
			'slider_speed',
			array(
				'label'   => __( 'Durasi Per Slide (detik)', 'hamagopest' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => array( 's' => array( 'min' => 2, 'max' => 12, 'step' => 1 ) ),
				'default' => array( 'size' => 5, 'unit' => 's' ),
			)
		);

		$this->add_control(
			'slider_arrows',
			array(
				'label'        => __( 'Tombol Panah Kiri/Kanan', 'hamagopest' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'slider_dots',
			array(
				'label'        => __( 'Titik Navigasi (Dots)', 'hamagopest' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();

		/* ============ STATISTIK ============ */
		$this->start_controls_section(
			'section_stats',
			array( 'label' => __( 'Statistik', 'hamagopest' ) )
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'number',
			array(
				'label'   => __( 'Angka', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '10+',
			)
		);
		$repeater->add_control(
			'label',
			array(
				'label'   => __( 'Keterangan', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Tahun menangani hama', 'hamagopest' ),
			)
		);

		$this->add_control(
			'stats',
			array(
				'label'       => __( 'Daftar Statistik', 'hamagopest' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ number }}}',
				'default'     => array(
					array( 'number' => '10+',    'label' => __( 'Tahun menangani hama', 'hamagopest' ) ),
					array( 'number' => '1200+',  'label' => __( 'Properti tertangani', 'hamagopest' ) ),
					array( 'number' => '4.9/5',  'label' => __( 'Rating kepuasan klien', 'hamagopest' ) ),
				),
			)
		);

		$this->end_controls_section();

		/* ============ RADAR / ICON BERPUTAR ============ */
		$this->start_controls_section(
			'section_radar',
			array( 'label' => __( 'Radar — Icon Berputar', 'hamagopest' ) )
		);

		$this->add_control(
			'radar_core_icon',
			array(
				'label'   => __( 'Icon Tengah (Core)', 'hamagopest' ),
				'type'    => Controls_Manager::SELECT,
				'options' => hamagopest_icon_options(),
				'default' => 'shield-check',
			)
		);

		$chips = new Repeater();
		$chips->add_control(
			'icon',
			array(
				'label'   => __( 'Icon', 'hamagopest' ),
				'type'    => Controls_Manager::SELECT,
				'options' => hamagopest_icon_options(),
				'default' => 'bug',
			)
		);
		$chips->add_control(
			'orbit',
			array(
				'label'   => __( 'Orbit (cincin)', 'hamagopest' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'outer' => __( 'Luar (cepat)', 'hamagopest' ),
					'inner' => __( 'Dalam (lambat, berlawanan)', 'hamagopest' ),
				),
				'default' => 'outer',
			)
		);
		$chips->add_control(
			'color',
			array(
				'label'   => __( 'Warna Icon', 'hamagopest' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'pine' => __( 'Navy Gelap', 'hamagopest' ),
					'gold' => __( 'Emas (Gold)', 'hamagopest' ),
				),
				'default' => 'pine',
			)
		);
		$chips->add_control(
			'angle',
			array(
				'label'       => __( 'Posisi Awal (derajat)', 'hamagopest' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 0,
				'max'         => 360,
				'default'     => 0,
				'description' => __( 'Sebar posisi awal agar icon tidak menumpuk.', 'hamagopest' ),
			)
		);

		$this->add_control(
			'chips',
			array(
				'label'       => __( 'Icon Hama (Berputar Mengorbit)', 'hamagopest' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $chips->get_controls(),
				'title_field' => 'Icon',
				'default'     => array(
					array( 'icon' => 'bug',      'orbit' => 'outer', 'color' => 'pine', 'angle' => 10 ),
					array( 'icon' => 'termite',  'orbit' => 'outer', 'color' => 'gold', 'angle' => 80 ),
					array( 'icon' => 'mosquito', 'orbit' => 'outer', 'color' => 'pine', 'angle' => 150 ),
					array( 'icon' => 'rat',      'orbit' => 'outer', 'color' => 'gold', 'angle' => 215 ),
					array( 'icon' => 'cockroach','orbit' => 'outer', 'color' => 'pine', 'angle' => 285 ),
					array( 'icon' => 'ant',      'orbit' => 'inner', 'color' => 'gold', 'angle' => 30 ),
					array( 'icon' => 'spider',   'orbit' => 'inner', 'color' => 'pine', 'angle' => 120 ),
					array( 'icon' => 'droplet',  'orbit' => 'inner', 'color' => 'gold', 'angle' => 240 ),
				),
			)
		);

		$this->add_control(
			'orbit_speed',
			array(
				'label'     => __( 'Kecepatan Rotasi Luar (detik / putaran)', 'hamagopest' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array( 's' => array( 'min' => 8, 'max' => 80, 'step' => 1 ) ),
				'default'   => array( 'size' => 26, 'unit' => 's' ),
				'selectors' => array(
					'{{WRAPPER}} .radar-wrap' => '--orbit-dur: {{SIZE}}s;',
					'{{WRAPPER}} .orbit--outer' => 'animation-duration: {{SIZE}}s;',
					'{{WRAPPER}} .orbit--outer .pest-chip' => 'animation-duration: {{SIZE}}s;',
				),
			)
		);

		$this->add_control(
			'orbit_speed_inner',
			array(
				'label'     => __( 'Kecepatan Rotasi Dalam', 'hamagopest' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array( 's' => array( 'min' => 10, 'max' => 100, 'step' => 1 ) ),
				'default'   => array( 'size' => 40, 'unit' => 's' ),
				'selectors' => array(
					'{{WRAPPER}} .orbit--inner' => 'animation-duration: {{SIZE}}s;',
					'{{WRAPPER}} .orbit--inner .pest-chip' => 'animation-duration: {{SIZE}}s;',
				),
			)
		);

		$this->add_control(
			'show_sweep',
			array(
				'label'        => __( 'Radar Sweep (sapuan radar)', 'hamagopest' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_ripple',
			array(
				'label'        => __( 'Gelombang Ripple', 'hamagopest' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();

		/* ============ ANIMASI ============ */
		$this->start_controls_section(
			'section_anim',
			array( 'label' => __( 'Animasi & Parallax', 'hamagopest' ) )
		);

		$this->add_parallax_toggle();

		$this->add_control(
			'anim_note',
			array(
				'label'       => '',
				'type'        => Controls_Manager::RAW_HTML,
				'raw'         => '<p style="line-height:1.6">' . esc_html__( 'Icon hama otomatis berputar mengorbit core radar. Kecepatan bisa diatur di tab Radar. Semua animasi otomatis smooth & responsive.', 'hamagopest' ) . '</p>',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$attrs = $this->parallax_attrs( $s, 0.08 );

		$p_url  = ! empty( $s['btn_primary_link']['url'] ) ? $s['btn_primary_link']['url'] : '#kontak';
		$s_url  = ! empty( $s['btn_secondary_link']['url'] ) ? $s['btn_secondary_link']['url'] : '#layanan';

		/* Gambar hero: 0 = radar default, 1 = background statis, >1 = slider. */
		$images    = ( ! empty( $s['hero_images'] ) && is_array( $s['hero_images'] ) ) ? array_values( $s['hero_images'] ) : array();
		$has_media = ! empty( $images );

		/* Bayangan gelap overlay — default 30%. */
		$overlay_pct = isset( $s['overlay_strength']['size'] ) ? (float) $s['overlay_strength']['size'] : 30;
		$overlay_pct = max( 0, min( 90, $overlay_pct ) );

		$is_slider = count( $images ) > 1;
		$autoplay  = $is_slider && ( 'yes' === ( $s['slider_autoplay'] ?? 'yes' ) );
		$speed_s   = isset( $s['slider_speed']['size'] ) ? max( 2, (float) $s['slider_speed']['size'] ) : 5;
		$keep_radar = 'yes' === ( $s['keep_radar'] ?? '' );
		?>
		<div class="hmg-el hmg-el-hero">
			<section class="hero hmg-hero<?php echo $has_media ? ' hero--has-media' : ''; ?>"<?php if ( $has_media ) : ?> style="--hmg-hero-overlay:<?php echo esc_attr( $overlay_pct / 100 ); ?>;"<?php endif; ?>>
				<?php if ( $has_media ) : ?>
					<div class="hero-media hmg-slider<?php echo $is_slider ? ' hmg-slider--multi' : ''; ?>"<?php echo $autoplay ? ' data-autoplay="' . esc_attr( (int) ( $speed_s * 1000 ) ) . '"' : ''; ?> aria-roledescription="<?php echo $is_slider ? 'carousel' : 'img'; ?>">
						<?php foreach ( $images as $i => $img ) : ?>
							<div class="hero-slide<?php echo 0 === $i ? ' is-active' : ''; ?>" style="background-image:url('<?php echo esc_url( $img['url'] ); ?>');"<?php echo 0 === $i ? '' : ' aria-hidden="true"'; ?> role="group" aria-label="<?php echo esc_attr( ( $i + 1 ) . ' / ' . count( $images ) ); ?>"></div>
						<?php endforeach; ?>
					</div>
					<div class="hero-overlay" aria-hidden="true"></div>

					<?php if ( $is_slider && 'yes' === ( $s['slider_arrows'] ?? 'yes' ) ) : ?>
						<button type="button" class="hmg-slider-nav hmg-slider-nav--prev" aria-label="<?php esc_attr_e( 'Slide sebelumnya', 'hamagopest' ); ?>">
							<svg class="hmg-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
						</button>
						<button type="button" class="hmg-slider-nav hmg-slider-nav--next" aria-label="<?php esc_attr_e( 'Slide berikutnya', 'hamagopest' ); ?>">
							<svg class="hmg-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 6l6 6-6 6"/></svg>
						</button>
					<?php endif; ?>

					<?php if ( $is_slider && 'yes' === ( $s['slider_dots'] ?? 'yes' ) ) : ?>
						<div class="hmg-slider-dots">
							<?php foreach ( $images as $i => $img ) : ?>
								<button type="button" class="hmg-slider-dot<?php echo 0 === $i ? ' is-active' : ''; ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Ke slide %d', 'hamagopest' ), $i + 1 ) ); ?>"></button>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				<?php else : ?>
					<div class="hero-blob hero-blob--1" data-hmg-parallax="0.22" aria-hidden="true"></div>
					<div class="hero-blob hero-blob--2" data-hmg-parallax="-0.16" aria-hidden="true"></div>
				<?php endif; ?>
				<div class="wrap hero-grid<?php echo ( $has_media && ! $keep_radar ) ? ' hero-grid--center' : ''; ?>">
					<div class="hero-copy">
						<?php if ( $s['eyebrow'] ) : ?>
							<div class="eyebrow" data-reveal="fade-up"><?php echo esc_html( $s['eyebrow'] ); ?></div>
						<?php endif; ?>
						<h1 data-reveal="fade-up" data-delay="80"><?php echo hamagopest_kses_heading( $s['title'] ?? '' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h1>
						<p class="lead" data-reveal="fade-up" data-delay="160"><?php echo esc_html( $s['lead'] ?? '' ); ?></p>

						<div class="cta-row" data-reveal="fade-up" data-delay="240">
							<a href="<?php echo esc_url( $p_url ); ?>" class="btn btn-gold"><?php echo esc_html( $s['btn_primary_text'] ?? '' ); ?></a>
							<a href="<?php echo esc_url( $s_url ); ?>" class="btn btn-outline dark"><?php echo esc_html( $s['btn_secondary_text'] ?? '' ); ?></a>
						</div>

						<?php if ( ! empty( $s['stats'] ) ) : ?>
						<div class="stat-strip" data-reveal="fade-up" data-delay="320">
							<?php foreach ( $s['stats'] as $stat ) : ?>
								<div><b><?php echo esc_html( $stat['number'] ?? '' ); ?></b><span><?php echo esc_html( $stat['label'] ?? '' ); ?></span></div>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>
					</div>

					<?php if ( ! $has_media || $keep_radar ) : ?>
					<div class="radar-wrap"<?php echo $attrs; // phpcs:ignore WordPress.Security.EscapeOutput ?> data-reveal="zoom" data-delay="150">
						<div class="radar-ring r1"></div>
						<div class="radar-ring r2"></div>
						<div class="radar-ring r3"></div>

						<?php if ( 'yes' === ( $s['show_ripple'] ?? 'yes' ) ) : ?>
							<div class="radar-pulse" aria-hidden="true"></div>
							<div class="radar-pulse rp2" aria-hidden="true"></div>
						<?php endif; ?>

						<?php if ( 'yes' === ( $s['show_sweep'] ?? 'yes' ) ) : ?>
							<div class="radar-sweep" aria-hidden="true"></div>
						<?php endif; ?>

						<div class="radar-core">
							<?php hamagopest_icon( $s['radar_core_icon'] ?? 'shield-check', 'radar-core-ico' ); ?>
						</div>

						<?php
						$outer = array();
						$inner = array();
						if ( ! empty( $s['chips'] ) ) {
							foreach ( $s['chips'] as $chip ) {
								if ( ( $chip['orbit'] ?? 'outer' ) === 'inner' ) {
									$inner[] = $chip;
								} else {
									$outer[] = $chip;
								}
							}
						}

						foreach ( array( 'outer' => $outer, 'inner' => $inner ) as $orbit_key => $chips_list ) :
							if ( empty( $chips_list ) ) {
								continue;
							}
							?>
							<div class="orbit orbit--<?php echo esc_attr( $orbit_key ); ?>">
								<?php foreach ( $chips_list as $index => $chip ) : ?>
									<div class="chip-place" style="--a:<?php echo (float) ( $chip['angle'] ?? 0 ); ?>deg; --chip-top:<?php echo 'outer' === $orbit_key ? '1.5%' : '13%'; ?>; --ci:<?php echo (float) $index; ?>;">
										<div class="chip-box" style="animation-delay:<?php echo esc_attr( $index * 0.45 ); ?>s;">
											<span class="pest-chip pest-chip--<?php echo esc_attr( $chip['color'] ?? 'pine' ); ?>">
												<?php hamagopest_icon( $chip['icon'] ?? 'shield' ); ?>
											</span>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>
				</div>
			</section>
		</div>
		<?php
	}
}
