<?php
/**
 * Elementor Widget: Hamago Video CTA — banner navy dengan tombol play.
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;

class Hamagopest_Video_CTA_Widget extends Hamagopest_Widget_Base {

	public function get_name() {
		return 'hamago_video_cta';
	}

	public function get_title() {
		return __( 'Hamago — Video CTA', 'hamagopest' );
	}

	public function get_icon() {
		return 'eicon-video-playlist';
	}

	public function get_keywords() {
		return array( 'video', 'cta', 'hamago', 'banner' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_content', array( 'label' => __( 'Konten', 'hamagopest' ) ) );

		$this->add_control(
			'eyebrow',
			array(
				'label'   => __( 'Eyebrow', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Kenali Hamago', 'hamagopest' ),
			)
		);
		$this->add_control(
			'heading',
			array(
				'label'   => __( 'Judul', 'hamagopest' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 2,
				'default' => __( 'Lihat bagaimana tim kami menangani masalah hama dari awal sampai tuntas', 'hamagopest' ),
			)
		);
		$this->add_control(
			'sub',
			array(
				'label'   => __( 'Deskripsi', 'hamagopest' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => __( 'Tonton cuplikan proses kerja lapangan tim teknisi Hamago di berbagai properti klien.', 'hamagopest' ),
			)
		);
		$this->add_control(
			'video_link',
			array(
				'label'       => __( 'Link Video (YouTube/Vimeo)', 'hamagopest' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://youtube.com/watch?v=...',
				'description' => __( 'Kosongkan jika tidak ada video — tombol play tetap tampil sebagai aksen.', 'hamagopest' ),
			)
		);
		$this->add_control(
			'lightbox',
			array(
				'label'        => __( 'Buka video di Lightbox', 'hamagopest' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section( 'section_anim', array( 'label' => __( 'Animasi & Parallax', 'hamagopest' ) ) );
		$this->add_parallax_toggle();
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();

		$video = ! empty( $s['video_link']['url'] ) ? $s['video_link']['url'] : '';
		$attr  = $this->parallax_attrs( $s, 0.06 );
		?>
		<div class="hmg-el hmg-el-video-cta">
			<section class="hmg-section hmg-section--plain video-cta-section">
				<div class="wrap">
					<div class="video-cta"<?php echo $attr; // phpcs:ignore WordPress.Security.EscapeOutput ?> data-reveal="fade-up">
						<div class="video-cta-copy">
							<?php if ( $s['eyebrow'] ) : ?>
								<div class="eyebrow eyebrow--gold" data-reveal="fade-up"><?php echo esc_html( $s['eyebrow'] ); ?></div>
							<?php endif; ?>
							<h2 data-reveal="fade-up" data-delay="80"><?php echo hamagopest_kses_heading( $s['heading'] ?? '' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></h2>
							<p data-reveal="fade-up" data-delay="160"><?php echo esc_html( $s['sub'] ?? '' ); ?></p>
						</div>
						<div class="video-cta-play">
							<?php if ( $video ) : ?>
								<a class="play-btn" href="<?php echo esc_url( $video ); ?>" <?php echo 'yes' === ( $s['lightbox'] ?? 'yes' ) ? 'data-hmg-lightbox' : 'target="_blank" rel="noopener"'; ?> aria-label="<?php esc_attr_e( 'Putar video', 'hamagopest' ); ?>">
									<svg class="hmg-ico" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
								</a>
							<?php else : ?>
								<span class="play-btn" aria-hidden="true">
									<svg class="hmg-ico" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
								</span>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</section>
		</div>
		<?php
	}
}
