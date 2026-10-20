<?php
/**
 * Elementor Widget: Hamago Clients — strip logo/nama klien.
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;

class Hamagopest_Clients_Widget extends Hamagopest_Widget_Base {

	public function get_name() {
		return 'hamago_clients';
	}

	public function get_title() {
		return __( 'Hamago — Klien & Mitra', 'hamagopest' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

	public function get_keywords() {
		return array( 'klien', 'clients', 'partner', 'hamago' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_content', array( 'label' => __( 'Konten', 'hamagopest' ) ) );

		$this->add_control(
			'eyebrow',
			array(
				'label'   => __( 'Eyebrow', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Dipercaya Oleh', 'hamagopest' ),
			)
		);
		$this->add_control(
			'heading',
			array(
				'label'   => __( 'Judul', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Mitra dan klien Hamago', 'hamagopest' ),
			)
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'name',
			array(
				'label'   => __( 'Nama Klien', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Nama Klien', 'hamagopest' ),
			)
		);
		$repeater->add_control(
			'image',
			array(
				'label'       => __( 'Logo (opsional)', 'hamagopest' ),
				'type'        => Controls_Manager::MEDIA,
				'description' => __( 'Jika diisi, logo menggantikan teks.', 'hamagopest' ),
			)
		);

		$this->add_control(
			'clients',
			array(
				'label'       => __( 'Daftar Klien', 'hamagopest' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
				'default'     => array(
					array( 'name' => 'Anya Living' ),
					array( 'name' => 'Streat Koppi' ),
					array( 'name' => 'BRImedika' ),
					array( 'name' => 'Casablanca Mansion' ),
					array( 'name' => 'Oasis Residence' ),
					array( 'name' => 'Syofia Islamic School' ),
				),
			)
		);

		$this->add_control(
			'marquee',
			array(
				'label'        => __( 'Animasi Marquee (berjalan)', 'hamagopest' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section( 'section_anim', array( 'label' => __( 'Animasi & Background', 'hamagopest' ) ) );
		$this->add_bg_controls( 'default' );
		$this->add_parallax_toggle();
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<div class="hmg-el hmg-el-clients">
			<section class="clients-section <?php echo esc_attr( $this->bg_class( $s ) ); ?>">
				<div class="wrap">
					<?php if ( $s['eyebrow'] ) : ?>
						<div class="eyebrow" data-reveal="fade-up"><?php echo esc_html( $s['eyebrow'] ); ?></div>
					<?php endif; ?>
					<?php if ( $s['heading'] ) : ?>
						<h2 class="clients-title" data-reveal="fade-up" data-delay="80"><?php echo hamagopest_kses_heading( $s['heading'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
					<?php endif; ?>

					<?php if ( ! empty( $s['clients'] ) ) : ?>
						<?php if ( 'yes' === $s['marquee'] ) : ?>
						<div class="clients-marquee" data-reveal="fade-up">
							<div class="clients-track">
								<?php foreach ( array_merge( $s['clients'], $s['clients'] ) as $client ) : ?>
									<span class="client-pill">
										<?php if ( ! empty( $client['image']['url'] ) ) : ?>
											<img src="<?php echo esc_url( $client['image']['url'] ); ?>" alt="<?php echo esc_attr( $client['name'] ?? '' ); ?>" loading="lazy" />
										<?php else : ?>
											<?php echo esc_html( $client['name'] ?? '' ); ?>
										<?php endif; ?>
									</span>
								<?php endforeach; ?>
							</div>
						</div>
						<?php else : ?>
						<div class="clients-strip" data-reveal="fade-up" data-delay="140">
							<?php foreach ( $s['clients'] as $client ) : ?>
								<span class="client-pill">
									<?php if ( ! empty( $client['image']['url'] ) ) : ?>
										<img src="<?php echo esc_url( $client['image']['url'] ); ?>" alt="<?php echo esc_attr( $client['name'] ?? '' ); ?>" loading="lazy" />
									<?php else : ?>
										<?php echo esc_html( $client['name'] ?? '' ); ?>
									<?php endif; ?>
								</span>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</section>
		</div>
		<?php
	}
}
