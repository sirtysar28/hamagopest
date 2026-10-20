<?php
/**
 * Elementor Widget: Hamago Testimonials — kartu testimoni.
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;

class Hamagopest_Testimonials_Widget extends Hamagopest_Widget_Base {

	public function get_name() {
		return 'hamago_testimonials';
	}

	public function get_title() {
		return __( 'Hamago — Testimoni', 'hamagopest' );
	}

	public function get_icon() {
		return 'eicon-review';
	}

	public function get_keywords() {
		return array( 'testimoni', 'review', 'hamago' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_content', array( 'label' => __( 'Konten', 'hamagopest' ) ) );
		$this->add_heading_controls(
			array(
				'eyebrow' => __( 'Testimoni', 'hamagopest' ),
				'heading' => __( 'Apa kata klien tentang layanan kami', 'hamagopest' ),
				'sub'     => '',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section( 'section_items', array( 'label' => __( 'Daftar Testimoni', 'hamagopest' ) ) );

		$repeater = new Repeater();
		$repeater->add_control(
			'quote',
			array(
				'label'   => __( 'Isi Testimoni', 'hamagopest' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 4,
				'default' => __( 'Isi testimoni klien.', 'hamagopest' ),
			)
		);
		$repeater->add_control(
			'name',
			array(
				'label'   => __( 'Nama', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Nama Klien', 'hamagopest' ),
			)
		);
		$repeater->add_control(
			'role',
			array(
				'label'   => __( 'Jabatan / Keterangan', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Pemilik Rumah', 'hamagopest' ),
			)
		);
		$repeater->add_control(
			'avatar',
			array(
				'label'       => __( 'Foto (opsional)', 'hamagopest' ),
				'type'        => Controls_Manager::MEDIA,
				'description' => __( 'Kosongkan untuk avatar inisial.', 'hamagopest' ),
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => __( 'Items', 'hamagopest' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
				'default'     => array(
					array(
						'quote' => __( 'Tim Hamago datang tepat waktu dan menjelaskan setiap tahap penanganan dengan jelas. Masalah rayap di rumah kami akhirnya tuntas.', 'hamagopest' ),
						'name'  => 'Andi Prasetyo',
						'role'  => __( 'Pemilik Rumah, Jakarta Timur', 'hamagopest' ),
					),
					array(
						'quote' => __( 'Sebagai pengelola gedung, kami butuh mitra yang bisa diandalkan untuk perawatan rutin. Hamago konsisten dan rapi dalam laporan kerja.', 'hamagopest' ),
						'name'  => 'Mira Santoso',
						'role'  => 'Building Manager',
					),
					array(
						'quote' => __( 'Harga yang ditawarkan transparan sejak awal, tidak ada biaya tambahan mendadak. Hasilnya juga sesuai yang dijanjikan.', 'hamagopest' ),
						'name'  => 'Rian Kusuma',
						'role'  => __( 'Pemilik Restoran', 'hamagopest' ),
					),
				),
			)
		);

		$this->add_control(
			'show_stars',
			array(
				'label'        => __( 'Tampilkan bintang 5', 'hamagopest' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
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
		$s       = $this->get_settings_for_display();
		$items   = ! empty( $s['items'] ) ? $s['items'] : array();
		$is_slide = count( $items ) > 3; /* Lebih dari 3 → mode slider. */
		?>
		<div class="hmg-el hmg-el-testimonials">
			<section id="testimoni" class="testimonials <?php echo esc_attr( $this->bg_class( $s ) ); ?><?php echo $is_slide ? ' testi-has-slider' : ''; ?>">
				<div class="wrap">
					<?php $this->render_heading_block( $s ); ?>
					<?php if ( $items ) : ?>
					<div class="testi-grid<?php echo $is_slide ? ' is-slider' : ''; ?>"<?php echo $is_slide ? ' data-testi-slider' : ''; ?>>
						<?php foreach ( $s['items'] as $i => $item ) : ?>
							<div class="testi-card" data-reveal="fade-up" data-delay="<?php echo esc_attr( $i * 100 ); ?>">
								<?php if ( 'yes' === ( $s['show_stars'] ?? 'yes' ) ) : ?>
									<div class="testi-stars" aria-label="<?php esc_attr_e( '5 dari 5 bintang', 'hamagopest' ); ?>">
										<?php for ( $st = 0; $st < 5; $st++ ) : ?>
											<svg class="hmg-ico star" viewBox="0 0 24 24" fill="currentColor" stroke="none" aria-hidden="true"><path d="M12 3l2.7 5.6 6.1.8-4.5 4.3 1.1 6-5.4-3-5.4 3 1.1-6L3.2 9.4l6.1-.8L12 3z"/></svg>
										<?php endfor; ?>
									</div>
								<?php endif; ?>
								<p class="testi-quote"><?php echo esc_html( $item['quote'] ?? '' ); ?></p>
								<div class="testi-who">
									<?php if ( ! empty( $item['avatar']['url'] ) ) : ?>
										<img class="avatar avatar-img" src="<?php echo esc_url( $item['avatar']['url'] ); ?>" alt="<?php echo esc_attr( $item['name'] ); ?>" loading="lazy" />
									<?php else : ?>
										<div class="avatar"><?php echo esc_html( mb_substr( (string) ( $item['name'] ?? '' ), 0, 1 ) ); ?></div>
									<?php endif; ?>
									<div><b><?php echo esc_html( $item['name'] ?? '' ); ?></b><span><?php echo esc_html( $item['role'] ?? '' ); ?></span></div>
								</div>
							</div>
							<?php endforeach; ?>
					</div>
					<?php if ( $is_slide ) : ?>
						<div class="testi-nav" data-testi-nav>
							<button type="button" class="testi-nav-btn testi-nav-btn--prev" aria-label="<?php esc_attr_e( 'Testimoni sebelumnya', 'hamagopest' ); ?>"><svg class="hmg-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M12 19l-7-7 7-7"/></svg></button>
							<button type="button" class="testi-nav-btn testi-nav-btn--next" aria-label="<?php esc_attr_e( 'Testimoni berikutnya', 'hamagopest' ); ?>"><svg class="hmg-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16M13 5l7 7-7 7"/></svg></button>
						</div>
					<?php endif; ?>
					<?php endif; ?>
				</div>
			</section>
		</div>
		<?php
	}
}
