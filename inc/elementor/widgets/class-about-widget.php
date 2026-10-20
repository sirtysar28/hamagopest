<?php
/**
 * Elementor Widget: Hamago About — visual statistik + narasi.
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;

class Hamagopest_About_Widget extends Hamagopest_Widget_Base {

	public function get_name() {
		return 'hamago_about';
	}

	public function get_title() {
		return __( 'Hamago — Tentang Kami', 'hamagopest' );
	}

	public function get_icon() {
		return 'eicon-site-identity';
	}

	public function get_keywords() {
		return array( 'about', 'tentang', 'hamago' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_content', array( 'label' => __( 'Konten', 'hamagopest' ) ) );

		$this->add_control(
			'eyebrow',
			array(
				'label'   => __( 'Eyebrow', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Tentang Kami', 'hamagopest' ),
			)
		);
		$this->add_control(
			'heading',
			array(
				'label'   => __( 'Judul', 'hamagopest' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 2,
				'default' => __( 'Mitra pengendalian hama yang bekerja dengan data, bukan tebakan', 'hamagopest' ),
			)
		);
		$this->add_control(
			'body',
			array(
				'label'   => __( 'Paragraf', 'hamagopest' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 5,
				'default' => __( 'Hamago Pest Solutions memadukan teknisi bersertifikat dengan pendekatan yang terukur untuk menjaga hunian dan area komersial tetap bersih dan sehat. Setiap metode yang kami pakai diuji aman bagi keluarga dan lingkungan kerja Anda, mulai dari inspeksi awal hingga pemantauan pasca-treatment.', 'hamagopest' ),
			)
		);
		$this->add_control(
			'btn_text',
			array(
				'label'   => __( 'Teks Tombol', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Pelajari Layanan Kami', 'hamagopest' ),
			)
		);
		$this->add_control(
			'btn_link',
			array(
				'label'   => __( 'Link Tombol', 'hamagopest' ),
				'type'    => Controls_Manager::URL,
				'default' => array( 'url' => '#layanan' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section( 'section_cells', array( 'label' => __( 'Kotak Statistik', 'hamagopest' ) ) );

		$repeater = new Repeater();
		$repeater->add_control(
			'value',
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
				'default' => __( 'Tahun pengalaman lapangan', 'hamagopest' ),
			)
		);

		$this->add_control(
			'cells',
			array(
				'label'       => __( 'Kotak', 'hamagopest' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ value }}}',
				'default'     => array(
					array( 'value' => '10+', 'label' => __( 'Tahun pengalaman lapangan', 'hamagopest' ) ),
					array( 'value' => '50+', 'label' => __( 'Teknisi bersertifikat', 'hamagopest' ) ),
					array( 'value' => '15',  'label' => __( 'Kota jangkauan layanan', 'hamagopest' ) ),
					array( 'value' => '98%', 'label' => __( 'Klien merekomendasikan', 'hamagopest' ) ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section( 'section_anim', array( 'label' => __( 'Animasi & Background', 'hamagopest' ) ) );
		$this->add_bg_controls( 'default' );
		$this->add_parallax_toggle();
		$this->end_controls_section();
	}

	protected function render() {
		$s    = $this->get_settings_for_display();
		$url  = ! empty( $s['btn_link']['url'] ) ? $s['btn_link']['url'] : '#layanan';
		$attr = $this->parallax_attrs( $s, 0.1 );
		?>
		<div class="hmg-el hmg-el-about">
			<section id="tentang" class="about <?php echo esc_attr( $this->bg_class( $s ) ); ?>">
				<div class="wrap about-grid">
					<?php if ( ! empty( $s['cells'] ) ) : ?>
					<div class="about-visual"<?php echo $attr; // phpcs:ignore WordPress.Security.EscapeOutput ?> data-reveal="fade-right">
						<?php foreach ( $s['cells'] as $i => $cell ) : ?>
							<div class="cell" data-reveal="zoom" data-delay="<?php echo esc_attr( $i * 90 ); ?>">
								<b><?php echo esc_html( $cell['value'] ?? '' ); ?></b>
								<span><?php echo esc_html( $cell['label'] ?? '' ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>
					<div class="about-copy">
						<?php if ( $s['eyebrow'] ) : ?>
							<div class="eyebrow" data-reveal="fade-up"><?php echo esc_html( $s['eyebrow'] ); ?></div>
						<?php endif; ?>
						<h2 data-reveal="fade-up" data-delay="80"><?php echo hamagopest_kses_heading( $s['heading'] ?? '' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
						<p class="body" data-reveal="fade-up" data-delay="160"><?php echo esc_html( $s['body'] ?? '' ); ?></p>
						<?php if ( $s['btn_text'] ) : ?>
							<a href="<?php echo esc_url( $url ); ?>" class="btn btn-outline dark" data-reveal="fade-up" data-delay="240"><?php echo esc_html( $s['btn_text'] ?? '' ); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</section>
		</div>
		<?php
	}
}
