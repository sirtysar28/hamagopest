<?php
/**
 * Elementor Widget: Hamago Services Page — daftar layanan untuk halaman Layanan.
 *
 * Kartu layanan modern: gambar/ilustrasi atas dengan overlay gradasi,
 * icon chip melayang, badge opsional ("Populer" dll), daftar metode
 * sebagai chips, tombol selengkapnya, hover lift + zoom gambar.
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;

class Hamagopest_ServicesPage_Widget extends Hamagopest_Widget_Base {

	public function get_name() {
		return 'hamago_services_page';
	}

	public function get_title() {
		return __( 'Hamago — Daftar Layanan (Halaman)', 'hamagopest' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_keywords() {
		return array( 'layanan', 'services', 'halaman', 'kartu', 'hamago' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_content', array( 'label' => __( 'Judul Section', 'hamagopest' ) ) );
		$this->add_heading_controls(
			array(
				'eyebrow' => __( 'Layanan Kami', 'hamagopest' ),
				'heading' => __( 'Solusi pengendalian hama <span class="accent">menyeluruh</span> untuk rumah & bisnis', 'hamagopest' ),
				'sub'     => __( 'Setiap layanan dimulai dari inspeksi gratis dan dikerjakan teknisi bersertifikat dengan garansi layanan.', 'hamagopest' ),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section( 'section_cards', array( 'label' => __( 'Kartu Layanan', 'hamagopest' ) ) );

		$rep = new Repeater();
		$rep->add_control(
			'image',
			array(
				'label'       => __( 'Gambar Kartu', 'hamagopest' ),
				'type'        => Controls_Manager::MEDIA,
				'description' => __( 'Disarankan rasio 16:10 (mis. 800×500). Tanpa gambar, kartu memakai gradasi + icon.', 'hamagopest' ),
			)
		);
		$rep->add_control(
			'icon',
			array(
				'label'   => __( 'Icon', 'hamagopest' ),
				'type'    => Controls_Manager::SELECT,
				'options' => hamagopest_icon_options(),
				'default' => 'termite',
			)
		);
		$rep->add_control(
			'title',
			array(
				'label'   => __( 'Judul Layanan', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Nama Layanan', 'hamagopest' ),
			)
		);
		$rep->add_control(
			'badge',
			array(
				'label'   => __( 'Badge (opsional)', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			)
		);
		$rep->add_control(
			'desc',
			array(
				'label'   => __( 'Deskripsi', 'hamagopest' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Deskripsi singkat layanan.', 'hamagopest' ),
			)
		);
		$rep->add_control(
			'methods',
			array(
				'label'       => __( 'Metode / Poin (satu per baris)', 'hamagopest' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => __( 'Tampil sebagai chips di kartu. Contoh: Metode Pipanisasi.', 'hamagopest' ),
			)
		);
		$rep->add_control(
			'link',
			array(
				'label'       => __( 'Link "Selengkapnya"', 'hamagopest' ),
				'type'        => Controls_Manager::URL,
				'description' => __( 'Arahkan ke halaman detail layanan bila ada.', 'hamagopest' ),
			)
		);

		$this->add_control(
			'cards',
			array(
				'label'       => __( 'Kartu', 'hamagopest' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $rep->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => array(
					array(
						'icon'    => 'termite',
						'title'   => __( 'Pengendalian Rayap', 'hamagopest' ),
						'badge'   => __( 'Terpopuler', 'hamagopest' ),
						'desc'    => __( 'Rayap adalah ancaman senyap bagi struktur bangunan. Kami membasminya hingga ke koloni dengan metode yang sesuai kondisi properti Anda.', 'hamagopest' ),
						'methods' => __( "Pipanisasi\nBaiting / Pengumpanan\nInjeksi Chemical Anti Rayap", 'hamagopest' ),
						'link'    => array( 'url' => '/layanan/pengendalian-rayap/', 'is_external' => '', 'nofollow' => '' ),
					),
					array(
						'icon'  => 'bug',
						'title' => __( 'Pengendalian Serangga', 'hamagopest' ),
						'desc'  => __( 'Kecoak, semut, nyamuk, lalat, dan serangga lainnya ditangani menyeluruh — dari penyemprotan hingga pengendalian di titik sumber perkembangbiakan.', 'hamagopest' ),
						'link'  => array( 'url' => '/layanan/pengendalian-serangga/', 'is_external' => '', 'nofollow' => '' ),
					),
					array(
						'icon'  => 'rat',
						'title' => __( 'Pengendalian Tikus', 'hamagopest' ),
						'desc'  => __( 'Pengendalian hama pengerat secara terpadu: deteksi jalur masuk, pengumpanan aman, dan sanitasi area agar tidak kembali.', 'hamagopest' ),
						'link'  => array( 'url' => '/layanan/pengendalian-tikus/', 'is_external' => '', 'nofollow' => '' ),
					),
					array(
						'icon'  => 'spray',
						'title' => __( 'Disinfektan', 'hamagopest' ),
						'desc'  => __( 'Pembasmian virus dan bakteri di permukaan untuk rumah, kantor, sekolah, dan fasilitas umum yang lebih higienis.', 'hamagopest' ),
						'link'  => array( 'url' => '/layanan/desinfektan/', 'is_external' => '', 'nofollow' => '' ),
					),
					array(
						'icon'  => 'fumigation',
						'title' => __( 'Fumigasi', 'hamagopest' ),
						'desc'  => __( 'Pengasapan komoditas, gudang, dan kontainer memakai fumigan resmi, dikerjakan tenaga ahli bersertifikat.', 'hamagopest' ),
					),
					array(
						'icon'  => 'snake',
						'title' => __( 'Pengendalian Hewan Pengganggu', 'hamagopest' ),
						'desc'  => __( 'Ular, biawak, kucing liar, tawon, dan lebah ditangani dengan aman oleh tim berpengalaman.', 'hamagopest' ),
					),
					array(
						'icon'  => 'scent',
						'title' => __( 'Pengharum Ruangan', 'hamagopest' ),
						'desc'  => __( 'Layanan pengharum ruangan untuk kantor dan hotel — aroma segar, tahan lama, dan aman bagi penghuni.', 'hamagopest' ),
					),
					array(
						'icon'  => 'broom',
						'title' => __( 'Cleaning Services', 'hamagopest' ),
						'desc'  => __( 'Pembersihan profesional untuk rumah, kantor, dan area komersial — bersih, rapi, dan higienis oleh tim terlatih.', 'hamagopest' ),
					),
				),
			)
		);

		$this->add_control(
			'columns',
			array(
				'label'   => __( 'Kolom (desktop)', 'hamagopest' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '3',
				'options' => array( '2' => '2', '3' => '3', '4' => '4' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section( 'section_cta', array( 'label' => __( 'CTA Bawah', 'hamagopest' ) ) );
		$this->add_control(
			'cta_text',
			array(
				'label'   => __( 'Teks CTA', 'hamagopest' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 2,
				'default' => __( 'Tidak yakin layanan mana yang tepat? Tim kami siap membantu memetakan masalah hama properti Anda — gratis.', 'hamagopest' ),
			)
		);
		$this->add_control(
			'cta_btn_text',
			array(
				'label'   => __( 'Teks Tombol', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Konsultasi via WhatsApp', 'hamagopest' ),
			)
		);
		$this->add_control(
			'cta_btn_link',
			array(
				'label'       => __( 'Link Tombol', 'hamagopest' ),
				'type'        => Controls_Manager::URL,
				'description' => __( 'Kosongkan untuk otomatis ke WhatsApp.', 'hamagopest' ),
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

		$cta_url = ! empty( $s['cta_btn_link']['url'] ) ? hamagopest_maybe_home_url( $s['cta_btn_link']['url'] ) : hamagopest_wa_link();
		$wa      = empty( $s['cta_btn_link']['url'] );
		?>
		<div class="hmg-el hmg-el-services-page">
			<section id="layanan-halaman" class="services-page <?php echo esc_attr( $this->bg_class( $s ) ); ?>">
				<div class="wrap">
					<?php $this->render_heading_block( $s ); ?>

					<?php if ( ! empty( $s['cards'] ) ) : ?>
						<div class="sp-grid cols-<?php echo esc_attr( $s['columns'] ?? '3' ); ?>">
							<?php foreach ( $s['cards'] as $i => $card ) :
								$link = ! empty( $card['link']['url'] ) ? hamagopest_maybe_home_url( $card['link']['url'] ) : '';
								$img  = ! empty( $card['image']['url'] ) ? $card['image']['url'] : '';
								$methods = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) ( $card['methods'] ?? '' ) ) ) );
								?>
								<article class="sp-card" data-reveal="fade-up" data-delay="<?php echo esc_attr( ( $i % 3 ) * 100 ); ?>">
									<div class="sp-media<?php echo $img ? '' : ' sp-media--ph'; ?>">
										<?php if ( $img ) : ?>
											<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $card['title'] ?? '' ); ?>" loading="lazy" />
										<?php endif; ?>
										<?php if ( ! empty( $card['badge'] ) ) : ?>
											<span class="sp-badge"><?php echo esc_html( $card['badge'] ); ?></span>
										<?php endif; ?>
									</div>
									<span class="sp-ico"><?php hamagopest_icon( $card['icon'] ?? 'termite' ); ?></span>
									<div class="sp-body">
										<h3><?php echo esc_html( $card['title'] ?? '' ); ?></h3>
										<p><?php echo esc_html( $card['desc'] ?? '' ); ?></p>
										<?php if ( $methods ) : ?>
											<div class="sp-list">
												<?php foreach ( $methods as $m ) : ?>
													<span class="sp-chip"><?php echo esc_html( $m ); ?></span>
												<?php endforeach; ?>
											</div>
										<?php endif; ?>
										<?php if ( $link ) : ?>
											<a class="more sp-more" href="<?php echo esc_url( $link ); ?>"><?php esc_html_e( 'Selengkapnya', 'hamagopest' ); ?> <span aria-hidden="true">→</span></a>
										<?php endif; ?>
									</div>
								</article>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $s['cta_text'] ) || ! empty( $s['cta_btn_text'] ) ) : ?>
						<div class="sp-cta" data-reveal="fade-up" data-delay="150">
							<?php if ( ! empty( $s['cta_text'] ) ) : ?>
								<p><?php echo esc_html( $s['cta_text'] ); ?></p>
							<?php endif; ?>
							<?php if ( ! empty( $s['cta_btn_text'] ) ) : ?>
								<a class="btn btn-pine" href="<?php echo esc_url( $cta_url ); ?>"<?php echo $wa ? ' target="_blank" rel="noopener"' : ''; ?>><?php hamagopest_icon( 'wa' ); ?> <?php echo esc_html( $s['cta_btn_text'] ); ?></a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</section>
		</div>
		<?php
	}
}
