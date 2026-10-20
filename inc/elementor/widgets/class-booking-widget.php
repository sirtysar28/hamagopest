<?php
/**
 * Elementor Widget: Hamago Booking — banner emas dengan tombol WhatsApp.
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;

class Hamagopest_Booking_Widget extends Hamagopest_Widget_Base {

	public function get_name() {
		return 'hamago_booking';
	}

	public function get_title() {
		return __( 'Hamago — Booking CTA (WhatsApp)', 'hamagopest' );
	}

	public function get_icon() {
		return 'eicon-whatsapp';
	}

	public function get_keywords() {
		return array( 'booking', 'whatsapp', 'cta', 'hamago' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_content', array( 'label' => __( 'Konten', 'hamagopest' ) ) );

		$this->add_control(
			'heading',
			array(
				'label'   => __( 'Judul', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Siap bebas dari hama?', 'hamagopest' ),
			)
		);
		$this->add_control(
			'sub',
			array(
				'label'   => __( 'Deskripsi', 'hamagopest' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 2,
				'default' => __( 'Jadwalkan inspeksi gratis dan konsultasikan masalah hama Anda hari ini.', 'hamagopest' ),
			)
		);
		$this->add_control(
			'btn_text',
			array(
				'label'   => __( 'Teks Tombol', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Hubungi via WhatsApp', 'hamagopest' ),
			)
		);
		$this->add_control(
			'btn_link',
			array(
				'label'       => __( 'Link Tombol', 'hamagopest' ),
				'type'        => Controls_Manager::URL,
				'description' => __( 'Kosongkan untuk otomatis pakai nomor WhatsApp dari Customizer.', 'hamagopest' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section( 'section_anim', array( 'label' => __( 'Animasi & Parallax', 'hamagopest' ) ) );
		$this->add_parallax_toggle();
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();

		$link = ! empty( $s['btn_link']['url'] ) ? $s['btn_link']['url'] : hamagopest_wa_link();
		$attr = $this->parallax_attrs( $s, 0.05 );
		?>
		<div class="hmg-el hmg-el-booking">
			<section id="kontak" class="booking hmg-section hmg-section--gold booking-tight">
				<div class="wrap booking-flex"<?php echo $attr; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
					<div class="booking-copy" data-reveal="fade-right">
						<h2><?php echo hamagopest_kses_heading( $s['heading'] ?? '' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
						<p><?php echo esc_html( $s['sub'] ?? '' ); ?></p>
					</div>
					<a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener nofollow" class="btn btn-pine booking-btn" data-reveal="fade-left" data-delay="120">
						<svg class="hmg-ico" viewBox="0 0 24 24" fill="currentColor" stroke="none" aria-hidden="true"><path d="M12 2C6.5 2 2 6.5 2 12c0 1.8.5 3.5 1.3 5L2 22l5.2-1.4c1.4.8 3.1 1.2 4.8 1.2 5.5 0 10-4.5 10-10S17.5 2 12 2zm5.9 14.2c-.2.7-1.4 1.3-2 1.4-.5.1-1.1.2-3.6-.8-3-1.2-4.9-4.2-5.1-4.4-.1-.2-1.2-1.6-1.2-3 0-1.4.7-2.1 1-2.4.3-.3.6-.3.8-.3h.6c.2 0 .5 0 .7.6.3.7.9 2.2 1 2.4.1.2.1.4 0 .6-.1.2-.2.4-.4.6-.2.2-.4.5-.6.6-.2.2-.4.4-.2.8.2.4 1 1.6 2.1 2.6 1.4 1.3 2.6 1.7 3 1.9.4.2.6.1.9-.1.3-.3.9-1.1 1.2-1.5.3-.4.5-.3.9-.2.4.2 2.3 1.1 2.7 1.3.4.2.6.3.7.4.1.2.1.9-.1 1.5z"/></svg>
						<?php echo esc_html( $s['btn_text'] ?? '' ); ?>
					</a>
				</div>
			</section>
		</div>
		<?php
	}
}
