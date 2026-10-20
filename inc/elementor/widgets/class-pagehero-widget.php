<?php
/**
 * Elementor Widget: Hamago Page Hero — banner halaman dalam (inner page).
 *
 * Banner navy modern untuk halaman Tentang Kami, Layanan, Kontak, FAQ, dll:
 * breadcrumb, judul besar, deskripsi, blob animasi, grid pattern, ring
 * berputar, dan sudut bawah membulat. Semua animasi menghormati
 * prefers-reduced-motion.
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;

class Hamagopest_PageHero_Widget extends Hamagopest_Widget_Base {

	public function get_name() {
		return 'hamago_pagehero';
	}

	public function get_title() {
		return __( 'Hamago — Hero Halaman (Banner)', 'hamagopest' );
	}

	public function get_icon() {
		return 'eicon-banner';
	}

	public function get_keywords() {
		return array( 'hero', 'banner', 'halaman', 'breadcrumb', 'hamago' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_content', array( 'label' => __( 'Konten Banner', 'hamagopest' ) ) );

		$this->add_control(
			'crumb_text',
			array(
				'label'   => __( 'Teks Breadcrumb (halaman ini)', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Tentang Kami', 'hamagopest' ),
			)
		);

		$this->add_control(
			'crumb_home',
			array(
				'label'   => __( 'Teks link Beranda', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Beranda', 'hamagopest' ),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => __( 'Judul Halaman', 'hamagopest' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'default'     => __( 'Tentang <span class="accent">Hamago</span>', 'hamagopest' ),
				'description' => __( 'Bisa pakai <span class="accent">kata</span> untuk warna emas.', 'hamagopest' ),
			)
		);

		$this->add_control(
			'desc',
			array(
				'label'   => __( 'Deskripsi singkat', 'hamagopest' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => __( 'Mitra pengendalian hama profesional yang bekerja dengan data, metode terukur, dan garansi layanan.', 'hamagopest' ),
			)
		);

		$this->add_control(
			'btn_text',
			array(
				'label'   => __( 'Tombol — Teks (opsional)', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$this->add_control(
			'btn_link',
			array(
				'label'   => __( 'Tombol — Link', 'hamagopest' ),
				'type'    => Controls_Manager::URL,
			)
		);

		$this->add_control(
			'height',
			array(
				'label'   => __( 'Tinggi Banner', 'hamagopest' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'md',
				'options' => array(
					'sm' => __( 'Ringkas', 'hamagopest' ),
					'md' => __( 'Standar', 'hamagopest' ),
					'lg' => __( 'Tinggi', 'hamagopest' ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section( 'section_anim', array( 'label' => __( 'Animasi & Dekorasi', 'hamagopest' ) ) );

		$this->add_control(
			'show_blobs',
			array(
				'label'        => __( 'Blob animasi bergerak', 'hamagopest' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_grid',
			array(
				'label'        => __( 'Pola grid halus', 'hamagopest' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_ring',
			array(
				'label'        => __( 'Ring dekoratif berputar', 'hamagopest' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_parallax_toggle();

		$this->end_controls_section();
	}

	protected function render() {
		$s       = $this->get_settings_for_display();
		$blobs   = ( 'yes' === ( $s['show_blobs'] ?? 'yes' ) );
		$grid    = ( 'yes' === ( $s['show_grid'] ?? 'yes' ) );
		$ring    = ( 'yes' === ( $s['show_ring'] ?? 'yes' ) );
		$crumb   = ! empty( $s['crumb_text'] ) ? $s['crumb_text'] : get_the_title();
		$btn_url = ! empty( $s['btn_link']['url'] ) ? hamagopest_maybe_home_url( $s['btn_link']['url'] ) : '';
		?>
		<div class="hmg-el hmg-el-pagehero">
			<section class="hmg-pagehero hmg-pagehero--<?php echo esc_attr( $s['height'] ?? 'md' ); ?>"<?php echo $this->parallax_attrs( $s, 0.08 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
				<?php if ( $blobs ) : ?>
					<span class="ph-blob ph-blob--1" aria-hidden="true"></span>
					<span class="ph-blob ph-blob--2" aria-hidden="true"></span>
				<?php endif; ?>
				<?php if ( $grid ) : ?>
					<span class="ph-grid" aria-hidden="true"></span>
				<?php endif; ?>
				<?php if ( $ring ) : ?>
					<span class="ph-ring" aria-hidden="true"></span>
				<?php endif; ?>
				<div class="wrap ph-inner">
					<nav class="ph-crumb" data-reveal="fade-up" aria-label="<?php esc_attr_e( 'Breadcrumb', 'hamagopest' ); ?>">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( ! empty( $s['crumb_home'] ) ? $s['crumb_home'] : __( 'Beranda', 'hamagopest' ) ); ?></a>
						<span class="ph-crumb-sep" aria-hidden="true">/</span>
						<span class="ph-crumb-cur"><?php echo esc_html( $crumb ); ?></span>
					</nav>
					<?php if ( ! empty( $s['title'] ) ) : ?>
						<h1 data-reveal="fade-up" data-delay="70"><?php echo hamagopest_kses_heading( $s['title'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h1>
					<?php endif; ?>
					<?php if ( ! empty( $s['desc'] ) ) : ?>
						<p class="ph-lead" data-reveal="fade-up" data-delay="140"><?php echo esc_html( $s['desc'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $s['btn_text'] ) && $btn_url ) : ?>
						<div class="ph-actions" data-reveal="fade-up" data-delay="210">
							<a class="btn btn-gold" href="<?php echo esc_url( $btn_url ); ?>"><?php echo esc_html( $s['btn_text'] ); ?></a>
						</div>
					<?php endif; ?>
				</div>
			</section>
		</div>
		<?php
	}
}
