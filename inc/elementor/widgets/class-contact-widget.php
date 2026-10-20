<?php
/**
 * Elementor Widget: Hamago Contact — halaman Kontak lengkap dengan Maps.
 *
 * - Kartu info kontak (telepon, WA, email, alamat, jam operasional) —
 *   nilainya otomatis diambil dari Customizer bila tidak diubah.
 * - Formulir: tempel shortcode plugin form (Contact Form 7 / WPForms /
 *   Fluent Forms) — tanpa shortcode tampil kartu WhatsApp besar.
 * - Peta Google Maps embed (iframe) — ambil dari control widget,
 *   Customizer (hamagopest_map_embed), atau fallback otomatis dari
 *   alamat kantor.
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;

class Hamagopest_Contact_Widget extends Hamagopest_Widget_Base {

	public function get_name() {
		return 'hamago_contact';
	}

	public function get_title() {
		return __( 'Hamago — Kontak & Maps', 'hamagopest' );
	}

	public function get_icon() {
		return 'eicon-google-maps';
	}

	public function get_keywords() {
		return array( 'kontak', 'contact', 'maps', 'peta', 'form', 'hamago' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_content', array( 'label' => __( 'Judul Section', 'hamagopest' ) ) );
		$this->add_heading_controls(
			array(
				'eyebrow' => __( 'Hubungi Kami', 'hamagopest' ),
				'heading' => __( 'Kami siap membantu <span class="accent">kapan pun</span> Anda butuh', 'hamagopest' ),
				'sub'     => __( 'Pilih cara paling nyaman untuk Anda — telepon, WhatsApp, email, atau datang langsung ke kantor kami.', 'hamagopest' ),
			)
		);
		$this->end_controls_section();

		/* ============ KARTU INFO ============ */
		$this->start_controls_section( 'sec_info', array( 'label' => __( 'Kartu Info Kontak', 'hamagopest' ) ) );

		$rep = new Repeater();
		$rep->add_control(
			'icon',
			array(
				'label'   => __( 'Icon', 'hamagopest' ),
				'type'    => Controls_Manager::SELECT,
				'options' => hamagopest_icon_options(),
				'default' => 'phone',
			)
		);
		$rep->add_control(
			'label',
			array(
				'label'   => __( 'Label', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Telepon', 'hamagopest' ),
			)
		);
		$rep->add_control(
			'value',
			array(
				'label'       => __( 'Isi / Nilai', 'hamagopest' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'default'     => hamagopest_get_phone(),
				'description' => __( 'Kosongkan untuk otomatis mengikuti Customizer.', 'hamagopest' ),
			)
		);
		$rep->add_control(
			'link',
			array(
				'label'       => __( 'Link (opsional)', 'hamagopest' ),
				'type'        => Controls_Manager::URL,
				'description' => __( 'Kosongkan = otomatis: telepon → tel:, WhatsApp → wa.me.', 'hamagopest' ),
			)
		);

		$this->add_control(
			'cards',
			array(
				'label'       => __( 'Kartu', 'hamagopest' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $rep->get_controls(),
				'title_field' => '{{{ label }}}',
				'default'     => array(
					array(
						'icon'  => 'phone',
						'label' => __( 'Telepon', 'hamagopest' ),
						'value' => hamagopest_get_phone(),
					),
					array(
						'icon'  => 'wa',
						'label' => __( 'WhatsApp', 'hamagopest' ),
						'value' => hamagopest_get_phone(),
					),
					array(
						'icon'  => 'mail',
						'label' => __( 'Email', 'hamagopest' ),
						'value' => get_theme_mod( 'hamagopest_email', 'info@hamagopest.co.id' ),
					),
					array(
						'icon'  => 'pin',
						'label' => __( 'Alamat Kantor', 'hamagopest' ),
						'value' => hamagopest_get_address(),
					),
					array(
						'icon'  => 'clock',
						'label' => __( 'Jam Operasional', 'hamagopest' ),
						'value' => get_theme_mod( 'hamagopest_hours', __( 'Senin – Sabtu: 08.00 – 17.00 WIB', 'hamagopest' ) ),
					),
				),
			)
		);
		$this->end_controls_section();

		/* ============ FORM ============ */
		$this->start_controls_section( 'sec_form', array( 'label' => __( 'Formulir', 'hamagopest' ) ) );

		$this->add_control(
			'form_title',
			array(
				'label'   => __( 'Judul Form', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Kirim Pesan', 'hamagopest' ),
			)
		);
		$this->add_control(
			'form_desc',
			array(
				'label'   => __( 'Deskripsi Form', 'hamagopest' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 2,
				'default' => __( 'Isi formulir di bawah dan tim kami akan menghubungi Anda maksimal 1×24 jam.', 'hamagopest' ),
			)
		);
		$this->add_control(
			'form_shortcode',
			array(
				'label'       => __( 'Shortcode Form (opsional)', 'hamagopest' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'description' => __( 'Tempel shortcode plugin form, mis. [contact-form-7 id="123"]. Tanpa shortcode, tampil kartu ajakan WhatsApp.', 'hamagopest' ),
				'label_block' => true,
			)
		);
		$this->end_controls_section();

		/* ============ MAPS ============ */
		$this->start_controls_section( 'sec_map', array( 'label' => __( 'Google Maps', 'hamagopest' ) ) );

		$this->add_control(
			'show_map',
			array(
				'label'        => __( 'Tampilkan Peta', 'hamagopest' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);
		$this->add_control(
			'map_url',
			array(
				'label'       => __( 'URL Embed Peta', 'hamagopest' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'description' => __( 'Cara ambil: Google Maps → cari alamat → Bagikan → Sematkan peta → salin isi src iframe. Kosongkan untuk otomatis dari Customizer / alamat kantor.', 'hamagopest' ),
				'label_block' => true,
			)
		);
		$this->add_control(
			'map_title',
			array(
				'label'   => __( 'Judul Peta', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Lokasi Kantor Kami', 'hamagopest' ),
			)
		);
		$this->add_control(
			'map_height',
			array(
				'label'      => __( 'Tinggi Peta (px)', 'hamagopest' ),
				'type'       => Controls_Manager::NUMBER,
				'default'    => 430,
				'min'        => 240,
				'max'        => 720,
			)
		);
		$this->end_controls_section();

		$this->start_controls_section( 'section_anim', array( 'label' => __( 'Animasi & Background', 'hamagopest' ) ) );
		$this->add_bg_controls( 'alt' );
		$this->add_parallax_toggle();
		$this->end_controls_section();
	}

	/**
	 * URL embed peta: widget → Customizer → fallback alamat.
	 */
	protected function map_src( $settings ) {
		if ( ! empty( $settings['map_url'] ) && is_string( $settings['map_url'] ) ) {
			$url = trim( $settings['map_url'] );
		} else {
			$url = trim( (string) get_theme_mod( 'hamagopest_map_embed', '' ) );
		}

		/* Terima src iframe utuh — ambil bagian src="..." saja. */
		if ( false !== stripos( $url, '<iframe' ) && preg_match( '/src=["\']([^"\']+)["\']/i', $url, $m ) ) {
			$url = $m[1];
		}

		if ( $url && preg_match( '#^https?://#i', $url ) ) {
			return $url;
		}

		/* Fallback: embed pencarian berdasarkan alamat kantor (tanpa API key). */
		return 'https://maps.google.com/maps?q=' . rawurlencode( hamagopest_get_address() ) . '&z=15&output=embed';
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<div class="hmg-el hmg-el-contact">
			<section id="kontak-halaman" class="contact-page <?php echo esc_attr( $this->bg_class( $s ) ); ?>">
				<div class="wrap">
					<?php $this->render_heading_block( $s ); ?>

					<div class="ct-grid">
						<?php
						/* ---------- Kartu info ---------- */
						if ( ! empty( $s['cards'] ) ) :
							?>
							<div class="ct-cards">
								<?php
								foreach ( $s['cards'] as $i => $card ) :
									$value = ! empty( $card['value'] ) ? $card['value'] : '';
									$icon  = $card['icon'] ?? 'phone';

									/* Link otomatis berdasarkan jenis kartu. */
									$link = ! empty( $card['link']['url'] ) ? hamagopest_maybe_home_url( $card['link']['url'] ) : '';
									if ( ! $link ) {
										if ( 'wa' === $icon ) {
											$link = hamagopest_wa_link();
										} elseif ( 'phone' === $icon ) {
											$link = hamagopest_tel_link();
										} elseif ( 'mail' === $icon ) {
											$link = 'mailto:' . antispambot( $value, false ); // phpcs:ignore
										}
									}

									$value_html = ( 'mail' === $icon ) ? esc_html( antispambot( $value ) ) : esc_html( $value );
									?>
									<div class="ct-card" data-reveal="fade-left" data-delay="<?php echo esc_attr( $i * 80 ); ?>">
										<span class="ct-ico"><?php hamagopest_icon( $icon ); ?></span>
										<div class="ct-card-body">
											<h4><?php echo esc_html( $card['label'] ?? '' ); ?></h4>
											<?php if ( $link ) : ?>
												<p><a href="<?php echo esc_url( $link ); ?>"<?php echo ( 'wa' === $icon && empty( $card['link']['url'] ) ) ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo $value_html; // phpcs:ignore WordPress.Security.EscapeOutput ?></a></p>
											<?php else : ?>
												<p><?php echo $value_html; // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
											<?php endif; ?>
										</div>
									</div>
									<?php
								endforeach;
								?>
							</div>
						<?php endif; ?>

						<?php
						/* ---------- Form / kartu WhatsApp ---------- */
						$shortcode = trim( (string) ( $s['form_shortcode'] ?? '' ) );
						?>
						<div class="ct-form" data-reveal="fade-right" data-delay="120">
							<?php if ( ! empty( $s['form_title'] ) ) : ?>
								<h3><?php echo esc_html( $s['form_title'] ); ?></h3>
							<?php endif; ?>
							<?php if ( ! empty( $s['form_desc'] ) ) : ?>
								<p class="ct-form-desc"><?php echo esc_html( $s['form_desc'] ); ?></p>
							<?php endif; ?>

							<?php if ( $shortcode ) : ?>
								<div class="ct-form-shortcode">
									<?php echo do_shortcode( shortcode_unautop( $shortcode ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
							<?php else : ?>
								<div class="ct-wa-fallback">
									<span class="ct-wa-ico"><?php hamagopest_icon( 'wa' ); ?></span>
									<h4><?php esc_html_e( 'Konsultasi Cepat via WhatsApp', 'hamagopest' ); ?></h4>
									<p><?php esc_html_e( 'Ceritakan masalah hama Anda — balasan cepat, gratis, tanpa komitmen.', 'hamagopest' ); ?></p>
									<a class="btn btn-gold" href="<?php echo esc_url( hamagopest_wa_link() ); ?>" target="_blank" rel="noopener"><?php hamagopest_icon( 'wa' ); ?> <?php esc_html_e( 'Chat Sekarang', 'hamagopest' ); ?></a>
								</div>
							<?php endif; ?>
						</div>
					</div>

					<?php
					/* ---------- Peta ---------- */
					if ( 'yes' === ( $s['show_map'] ?? 'yes' ) ) :
						$src     = $this->map_src( $s );
						$height  = max( 240, min( 720, (int) ( $s['map_height'] ?? 430 ) ) );
						?>
						<div class="ct-map" data-reveal="fade-up" data-delay="100">
							<div class="ct-map-head">
								<span class="ct-map-pin"><?php hamagopest_icon( 'pin' ); ?></span>
								<div>
									<h3><?php echo esc_html( $s['map_title'] ?? '' ); ?></h3>
									<p><?php echo esc_html( hamagopest_get_address() ); ?></p>
								</div>
								<a class="btn btn-outline dark ct-map-dir" href="https://maps.google.com/?q=<?php echo rawurlencode( hamagopest_get_address() ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Petunjuk Arah', 'hamagopest' ); ?></a>
							</div>
							<iframe
								src="<?php echo esc_url( $src ); ?>"
								title="<?php echo esc_attr( $s['map_title'] ?? __( 'Peta Lokasi', 'hamagopest' ) ); ?>"
								loading="lazy"
								referrerpolicy="no-referrer-when-downgrade"
								allowfullscreen
								style="height:<?php echo esc_attr( $height ); ?>px;"
							></iframe>
						</div>
					<?php endif; ?>
				</div>
			</section>
		</div>
		<?php
	}
}
