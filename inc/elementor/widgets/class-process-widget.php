<?php
/**
 * Elementor Widget: Hamago Process — langkah kerja bernomor.
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;

class Hamagopest_Process_Widget extends Hamagopest_Widget_Base {

	public function get_name() {
		return 'hamago_process';
	}

	public function get_title() {
		return __( 'Hamago — Cara Kerja (Proses)', 'hamagopest' );
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_keywords() {
		return array( 'proses', 'step', 'cara kerja', 'hamago' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_content', array( 'label' => __( 'Konten', 'hamagopest' ) ) );
		$this->add_heading_controls(
			array(
				'eyebrow' => __( 'Cara Kerja', 'hamagopest' ),
				'heading' => __( 'Empat langkah menuju properti yang bebas hama', 'hamagopest' ),
				'sub'     => '',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section( 'section_steps', array( 'label' => __( 'Langkah', 'hamagopest' ) ) );

		$repeater = new Repeater();
		$repeater->add_control(
			'title',
			array(
				'label'   => __( 'Judul', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Langkah', 'hamagopest' ),
			)
		);
		$repeater->add_control(
			'desc',
			array(
				'label'   => __( 'Deskripsi', 'hamagopest' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Deskripsi langkah.', 'hamagopest' ),
			)
		);

		$this->add_control(
			'steps',
			array(
				'label'       => __( 'Daftar Langkah (nomor otomatis)', 'hamagopest' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => array(
					array(
						'title' => __( 'Konsultasi', 'hamagopest' ),
						'desc'  => __( 'Ceritakan keluhan hama Anda lewat telepon atau WhatsApp, kami jadwalkan kunjungan.', 'hamagopest' ),
					),
					array(
						'title' => __( 'Inspeksi Lapangan', 'hamagopest' ),
						'desc'  => __( 'Teknisi memetakan titik masuk dan tingkat infestasi secara langsung di lokasi.', 'hamagopest' ),
					),
					array(
						'title' => __( 'Treatment', 'hamagopest' ),
						'desc'  => __( 'Penanganan dilakukan sesuai rencana yang disepakati, dengan metode yang aman.', 'hamagopest' ),
					),
					array(
						'title' => __( 'Pemantauan', 'hamagopest' ),
						'desc'  => __( 'Kami pantau hasil dan berikan garansi agar hama tidak kembali.', 'hamagopest' ),
					),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section( 'section_anim', array( 'label' => __( 'Animasi & Background', 'hamagopest' ) ) );
		$this->add_bg_controls( 'alt' );
		$this->add_parallax_toggle();
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<div class="hmg-el hmg-el-process">
			<section id="proses" class="process <?php echo esc_attr( $this->bg_class( $s ) ); ?>">
				<div class="wrap">
					<?php $this->render_heading_block( $s ); ?>
					<?php if ( ! empty( $s['steps'] ) ) : ?>
					<div class="process-grid">
						<?php foreach ( $s['steps'] as $i => $step ) : ?>
							<div class="proc-item" data-reveal="fade-up" data-delay="<?php echo esc_attr( $i * 110 ); ?>">
								<div class="proc-num"><?php echo esc_html( $i + 1 ); ?></div>
								<h4><?php echo esc_html( $step['title'] ?? '' ); ?></h4>
								<p><?php echo esc_html( $step['desc'] ?? '' ); ?></p>
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
