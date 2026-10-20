<?php
/**
 * Elementor Widget: Hamago USP — 4 keunggulan (dark navy).
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;

class Hamagopest_USP_Widget extends Hamagopest_Widget_Base {

	public function get_name() {
		return 'hamago_usp';
	}

	public function get_title() {
		return __( 'Hamago — Keunggulan (USP)', 'hamagopest' );
	}

	public function get_icon() {
		return 'eicon-favorite';
	}

	public function get_keywords() {
		return array( 'usp', 'keunggulan', 'hamago' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_content', array( 'label' => __( 'Konten', 'hamagopest' ) ) );
		$this->add_heading_controls(
			array(
				'eyebrow' => __( 'Kenapa Hamago', 'hamagopest' ),
				'heading' => __( 'Empat alasan klien kami bertahan bertahun-tahun', 'hamagopest' ),
				'sub'     => __( 'Bukan cuma menyemprot dan pergi — kami merancang solusi sesuai kondisi properti, lalu memastikan hasilnya bertahan.', 'hamagopest' ),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section( 'section_items', array( 'label' => __( 'Daftar Keunggulan', 'hamagopest' ) ) );

		$repeater = new Repeater();
		$repeater->add_control(
			'icon',
			array(
				'label'   => __( 'Icon', 'hamagopest' ),
				'type'    => Controls_Manager::SELECT,
				'options' => hamagopest_icon_options(),
				'default' => 'search',
			)
		);
		$repeater->add_control(
			'title',
			array(
				'label'   => __( 'Judul', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Judul keunggulan', 'hamagopest' ),
			)
		);
		$repeater->add_control(
			'desc',
			array(
				'label'   => __( 'Deskripsi', 'hamagopest' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Deskripsi singkat keunggulan.', 'hamagopest' ),
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => __( 'Items', 'hamagopest' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => array(
					array(
						'icon'  => 'search',
						'title' => __( 'Inspeksi Gratis', 'hamagopest' ),
						'desc'  => __( 'Tim kami memetakan titik masuk dan sarang hama sebelum menentukan rencana penanganan — tanpa biaya.', 'hamagopest' ),
					),
					array(
						'icon'  => 'target',
						'title' => __( 'Solusi Kustom', 'hamagopest' ),
						'desc'  => __( 'Metode disesuaikan dengan jenis hama, tingkat infestasi, dan karakter bangunan Anda.', 'hamagopest' ),
					),
					array(
						'icon'  => 'bundle',
						'title' => __( 'Paket Bundling', 'hamagopest' ),
						'desc'  => __( 'Perawatan rutin tahunan dengan harga lebih hemat, dirancang untuk mencegah hama datang kembali.', 'hamagopest' ),
					),
					array(
						'icon'  => 'price',
						'title' => __( 'Harga Transparan', 'hamagopest' ),
						'desc'  => __( 'Penawaran jelas di awal, tanpa biaya tersembunyi, sepadan dengan kualitas layanan yang Anda terima.', 'hamagopest' ),
					),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section( 'section_anim', array( 'label' => __( 'Animasi', 'hamagopest' ) ) );
		$this->add_parallax_toggle();
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<div class="hmg-el hmg-el-usp">
			<section class="usp-section hmg-section hmg-section--pine">
				<div class="wrap">
					<?php $this->render_heading_block( $s ); ?>
					<?php if ( ! empty( $s['items'] ) ) : ?>
					<div class="usp-grid">
						<?php foreach ( $s['items'] as $i => $item ) : ?>
							<div class="usp-item" data-reveal="fade-up" data-delay="<?php echo esc_attr( $i * 100 ); ?>">
								<?php hamagopest_icon( $item['icon'] ?? 'shield' ); ?>
								<h4><?php echo esc_html( $item['title'] ?? '' ); ?></h4>
								<p><?php echo esc_html( $item['desc'] ?? '' ); ?></p>
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
