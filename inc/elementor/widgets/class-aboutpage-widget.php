<?php
/**
 * Elementor Widget: Hamago About Page — konten lengkap halaman Tentang Kami.
 *
 * Susunan section dalam satu widget:
 * 1. Intro — foto bertumpuk (2 foto + badge melayang) + narasi + checklist
 * 2. Statistik — band navy dengan angka COUNT-UP animasi saat terlihat
 * 3. Nilai & Keunggulan — kartu grid dengan hover effect
 * 4. Perjalanan — timeline zig-zag dengan garis gradasi
 * 5. Sertifikasi — pill badges
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;

class Hamagopest_AboutPage_Widget extends Hamagopest_Widget_Base {

	public function get_name() {
		return 'hamago_about_page';
	}

	public function get_title() {
		return __( 'Hamago — Tentang Kami (Halaman)', 'hamagopest' );
	}

	public function get_icon() {
		return 'eicon-site-identity';
	}

	public function get_keywords() {
		return array( 'tentang', 'about', 'perusahaan', 'hamago', 'halaman' );
	}

	protected function register_controls() {

		/* ============ INTRO ============ */
		$this->start_controls_section( 'sec_intro', array( 'label' => __( '1. Intro — Narasi & Foto', 'hamagopest' ) ) );

		$this->add_heading_controls(
			array(
				'eyebrow' => __( 'Tentang Kami', 'hamagopest' ),
				'heading' => __( 'Mitra pengendalian hama yang bekerja dengan <span class="accent">data, bukan tebakan</span>', 'hamagopest' ),
				'sub'     => '',
			)
		);

		$this->add_control(
			'intro_body',
			array(
				'label'   => __( 'Paragraf Narasi', 'hamagopest' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 6,
				'default' => __( 'Hamago Pest Solutions berdiri dengan satu misi: menghadirkan lingkungan hidup dan bebas hama yang aman bagi keluarga maupun bisnis. Kami memadukan teknisi bersertifikat, metode penanganan terukur, dan produk yang aman bagi manusia serta lingkungan.', 'hamagopest' ),
			)
		);

		$this->add_control(
			'intro_body2',
			array(
				'label'   => __( 'Paragraf Kedua (opsional)', 'hamagopest' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 5,
				'default' => __( 'Setiap penanganan dimulai dari inspeksi menyeluruh — memetakan titik masuk, tingkat infestasi, dan karakter bangunan — sehingga solusi yang diterapkan tepat sasaran dan hasilnya bertahan lama.', 'hamagopest' ),
			)
		);

		$check = new Repeater();
		$check->add_control(
			'text',
			array(
				'label'   => __( 'Poin', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Teknisi bersertifikat & terlatih', 'hamagopest' ),
			)
		);
		$this->add_control(
			'checklist',
			array(
				'label'       => __( 'Checklist Keunggulan', 'hamagopest' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $check->get_controls(),
				'title_field' => '{{{ text }}}',
				'default'     => array(
					array( 'text' => __( 'Teknisi bersertifikat & terlatih', 'hamagopest' ) ),
					array( 'text' => __( 'Produk aman bagi keluarga & lingkungan', 'hamagopest' ) ),
					array( 'text' => __( 'Garansi layanan & pemantauan pasca-treatment', 'hamagopest' ) ),
					array( 'text' => __( 'Laporan kerja transparan di setiap kunjungan', 'hamagopest' ) ),
				),
			)
		);

		$this->add_control(
			'intro_btn_text',
			array(
				'label'   => __( 'Tombol — Teks', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Konsultasi Gratis', 'hamagopest' ),
			)
		);
		$this->add_control(
			'intro_btn_link',
			array(
				'label'       => __( 'Tombol — Link', 'hamagopest' ),
				'type'        => Controls_Manager::URL,
				'description' => __( 'Kosongkan untuk otomatis ke WhatsApp.', 'hamagopest' ),
			)
		);

		$this->add_control(
			'photo_main',
			array(
				'label'       => __( 'Foto Utama', 'hamagopest' ),
				'type'        => Controls_Manager::MEDIA,
				'description' => __( 'Disarankan rasio 4:3 (mis. 800×600).', 'hamagopest' ),
			)
		);
		$this->add_control(
			'photo_sub',
			array(
				'label'   => __( 'Foto Kedua (tumpukan)', 'hamagopest' ),
				'type'    => Controls_Manager::MEDIA,
			)
		);
		$this->add_control(
			'badge_number',
			array(
				'label'   => __( 'Badge — Angka', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '10+',
			)
		);
		$this->add_control(
			'badge_label',
			array(
				'label'   => __( 'Badge — Keterangan', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Tahun pengalaman', 'hamagopest' ),
			)
		);
		$this->end_controls_section();

		/* ============ STATS ============ */
		$this->start_controls_section( 'sec_stats', array( 'label' => __( '2. Statistik (angka beranimasi)', 'hamagopest' ) ) );

		$stat = new Repeater();
		$stat->add_control(
			'number',
			array(
				'label'       => __( 'Angka', 'hamagopest' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '1.200+',
				'description' => __( 'Angka akan beranimasi (count-up) saat terlihat. Contoh: 10+, 98%, 4.9, 1.200+.', 'hamagopest' ),
			)
		);
		$stat->add_control(
			'label',
			array(
				'label'   => __( 'Keterangan', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Properti tertangani', 'hamagopest' ),
			)
		);
		$this->add_control(
			'stats',
			array(
				'label'       => __( 'Statistik', 'hamagopest' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $stat->get_controls(),
				'title_field' => '{{{ number }}} {{{ label }}}',
				'default'     => array(
					array( 'number' => '10+', 'label' => __( 'Tahun pengalaman lapangan', 'hamagopest' ) ),
					array( 'number' => '1.200+', 'label' => __( 'Properti tertangani', 'hamagopest' ) ),
					array( 'number' => '50+', 'label' => __( 'Teknisi bersertifikat', 'hamagopest' ) ),
					array( 'number' => '98%', 'label' => __( 'Klien merekomendasikan', 'hamagopest' ) ),
				),
			)
		);
		$this->end_controls_section();

		/* ============ VALUES ============ */
		$this->start_controls_section( 'sec_values', array( 'label' => __( '3. Nilai & Keunggulan', 'hamagopest' ) ) );

		$this->add_heading_controls(
			array(
				'eyebrow' => __( 'Nilai Kami', 'hamagopest' ),
				'heading' => __( 'Prinsip yang kami pegang di setiap penanganan', 'hamagopest' ),
				'sub'     => '',
			),
			'v_'
		);

		$val = new Repeater();
		$val->add_control(
			'icon',
			array(
				'label'   => __( 'Icon', 'hamagopest' ),
				'type'    => Controls_Manager::SELECT,
				'options' => hamagopest_icon_options(),
				'default' => 'shield-check',
			)
		);
		$val->add_control(
			'title',
			array(
				'label'   => __( 'Judul', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Aman & Bertanggung Jawab', 'hamagopest' ),
			)
		);
		$val->add_control(
			'desc',
			array(
				'label'   => __( 'Deskripsi', 'hamagopest' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Kami memilih produk dan metode yang aman bagi keluarga, hewan peliharaan, dan lingkungan.', 'hamagopest' ),
			)
		);
		$this->add_control(
			'values',
			array(
				'label'       => __( 'Kartu Nilai', 'hamagopest' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $val->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => array(
					array(
						'icon'  => 'shield-check',
						'title' => __( 'Aman & Bertanggung Jawab', 'hamagopest' ),
						'desc'  => __( 'Kami memilih produk dan metode yang aman bagi keluarga, hewan peliharaan, dan lingkungan.', 'hamagopest' ),
					),
					array(
						'icon'  => 'target',
						'title' => __( 'Tepat Sasaran', 'hamagopest' ),
						'desc'  => __( 'Inspeksi detail sebelum treatment — solusi disesuaikan jenis hama dan kondisi bangunan Anda.', 'hamagopest' ),
					),
					array(
						'icon'  => 'heart',
						'title' => __( 'Melayani dengan Sepenuh Hati', 'hamagopest' ),
						'desc'  => __( 'Teknisi ramah, tepat waktu, dan selalu menjelaskan setiap tahap pekerjaan kepada Anda.', 'hamagopest' ),
					),
					array(
						'icon'  => 'doc',
						'title' => __( 'Transparan & Terukur', 'hamagopest' ),
						'desc'  => __( 'Penawaran jelas di awal, laporan kerja rapi, dan garansi sesuai kesepakatan.', 'hamagopest' ),
					),
					array(
						'icon'  => 'clock',
						'title' => __( 'Respons Cepat', 'hamagopest' ),
						'desc'  => __( 'Jadwal fleksibel dan penanganan segera untuk infestasi yang butuh tindakan cepat.', 'hamagopest' ),
					),
					array(
						'icon'  => 'chart',
						'title' => __( 'Berbasis Data', 'hamagopest' ),
						'desc'  => __( 'Pemantauan berkala dan evaluasi hasil agar hama tidak kembali.', 'hamagopest' ),
					),
				),
			)
		);
		$this->end_controls_section();

		/* ============ TIMELINE ============ */
		$this->start_controls_section( 'sec_timeline', array( 'label' => __( '4. Perjalanan (Timeline)', 'hamagopest' ) ) );

		$this->add_heading_controls(
			array(
				'eyebrow' => __( 'Perjalanan Kami', 'hamagopest' ),
				'heading' => __( 'Tumbuh bersama kepercayaan klien', 'hamagopest' ),
				'sub'     => '',
			),
			't_'
		);

		$tl = new Repeater();
		$tl->add_control(
			'year',
			array(
				'label'   => __( 'Tahun / Label', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '2015',
			)
		);
		$tl->add_control(
			'title',
			array(
				'label'   => __( 'Judul', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Awal berdiri', 'hamagopest' ),
			)
		);
		$tl->add_control(
			'desc',
			array(
				'label'   => __( 'Deskripsi', 'hamagopest' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Dimulai dari tim kecil dengan fokus layanan anti rayap untuk rumah tinggal.', 'hamagopest' ),
			)
		);
		$this->add_control(
			'timeline',
			array(
				'label'       => __( 'Item Timeline', 'hamagopest' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $tl->get_controls(),
				'title_field' => '{{{ year }}} — {{{ title }}}',
				'default'     => array(
					array(
						'year'  => '2015',
						'title' => __( 'Awal Berdiri', 'hamagopest' ),
						'desc'  => __( 'Dimulai dari tim kecil dengan fokus layanan anti rayap untuk rumah tinggal di Jakarta.', 'hamagopest' ),
					),
					array(
						'year'  => '2018',
						'title' => __( 'Layanan Berkembang', 'hamagopest' ),
						'desc'  => __( 'Menambah layanan pengendalian serangga, tikus, fumigasi, hingga disinfeksi untuk klien komersial.', 'hamagopest' ),
					),
					array(
						'year'  => '2021',
						'title' => __( 'Dipercaya Institusi', 'hamagopest' ),
						'desc'  => __( 'Melayani rumah sakit, sekolah, pabrik, dan hotel dengan standar dokumentasi lengkap.', 'hamagopest' ),
					),
					array(
						'year'  => __( 'Hari Ini', 'hamagopest' ),
						'title' => __( '1.200+ Properti Terlindungi', 'hamagopest' ),
						'desc'  => __( 'Terus berinovasi dengan metode terbaru dan pemantauan berkala untuk klien rumah tangga maupun korporasi.', 'hamagopest' ),
					),
				),
			)
		);
		$this->end_controls_section();

		/* ============ CERTS ============ */
		$this->start_controls_section( 'sec_certs', array( 'label' => __( '5. Sertifikasi & Legalitas', 'hamagopest' ) ) );

		$cert = new Repeater();
		$cert->add_control(
			'icon',
			array(
				'label'   => __( 'Icon', 'hamagopest' ),
				'type'    => Controls_Manager::SELECT,
				'options' => hamagopest_icon_options(),
				'default' => 'shield-check',
			)
		);
		$cert->add_control(
			'text',
			array(
				'label'   => __( 'Nama Sertifikasi', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Teknisi Bersertifikat', 'hamagopest' ),
			)
		);
		$this->add_control(
			'certs',
			array(
				'label'       => __( 'Daftar Sertifikasi', 'hamagopest' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $cert->get_controls(),
				'title_field' => '{{{ text }}}',
				'default'     => array(
					array( 'icon' => 'shield-check', 'text' => __( 'Teknisi Bersertifikat', 'hamagopest' ) ),
					array( 'icon' => 'doc', 'text' => __( 'Perusahaan Resmi & Berbadan Hukum', 'hamagopest' ) ),
					array( 'icon' => 'droplet', 'text' => __( 'Produk Terdaftar & Aman', 'hamagopest' ) ),
					array( 'icon' => 'building', 'text' => __( 'Standar Higiene Industri (GMP/HACCP-ready)', 'hamagopest' ) ),
				),
			)
		);
		$this->end_controls_section();

		/* ============ BACKGROUND ============ */
		$this->start_controls_section( 'section_anim', array( 'label' => __( 'Animasi & Background', 'hamagopest' ) ) );
		$this->add_bg_controls( 'default' );
		$this->add_parallax_toggle();
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();

		$btn_url = ! empty( $s['intro_btn_link']['url'] ) ? hamagopest_maybe_home_url( $s['intro_btn_link']['url'] ) : hamagopest_wa_link();
		$img1    = ! empty( $s['photo_main']['url'] ) ? $s['photo_main']['url'] : '';
		$img2    = ! empty( $s['photo_sub']['url'] ) ? $s['photo_sub']['url'] : '';
		?>
		<div class="hmg-el hmg-el-about-page">
			<section id="tentang-halaman" class="about-page <?php echo esc_attr( $this->bg_class( $s ) ); ?>">
				<div class="wrap">

					<?php
					/* ---------- 1. INTRO ---------- */
					$checklist = ! empty( $s['checklist'] ) ? array_filter( wp_list_pluck( $s['checklist'], 'text' ) ) : array();
					?>
					<div class="ap-intro">
						<div class="ap-media" data-reveal="fade-right">
							<?php if ( $img1 ) : ?>
								<div class="ap-media__main">
									<img src="<?php echo esc_url( $img1 ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" loading="lazy" />
								</div>
							<?php else : ?>
								<div class="ap-media__main ap-media__main--ph">
									<span class="ap-media__ph-ico"><?php hamagopest_icon( 'users' ); ?></span>
									<p><?php esc_html_e( 'Upload foto tim / kantor Anda di panel kiri', 'hamagopest' ); ?></p>
								</div>
							<?php endif; ?>
							<?php if ( $img2 ) : ?>
								<div class="ap-media__sub">
									<img src="<?php echo esc_url( $img2 ); ?>" alt="" loading="lazy" />
								</div>
							<?php endif; ?>
							<?php if ( ! empty( $s['badge_number'] ) ) : ?>
								<div class="ap-media__badge">
									<b><?php echo esc_html( $s['badge_number'] ); ?></b>
									<span><?php echo esc_html( $s['badge_label'] ?? '' ); ?></span>
								</div>
							<?php endif; ?>
						</div>

						<div class="ap-copy" data-reveal="fade-left" data-delay="120">
							<?php $this->render_heading_block( $s ); ?>
							<?php if ( ! empty( $s['intro_body'] ) ) : ?>
								<p class="body"><?php echo esc_html( $s['intro_body'] ); ?></p>
							<?php endif; ?>
							<?php if ( ! empty( $s['intro_body2'] ) ) : ?>
								<p class="body"><?php echo esc_html( $s['intro_body2'] ); ?></p>
							<?php endif; ?>
							<?php if ( $checklist ) : ?>
								<ul class="ap-checklist">
									<?php foreach ( $checklist as $item ) : ?>
										<li><span class="ap-chk"><?php hamagopest_icon( 'check' ); ?></span><?php echo esc_html( $item ); ?></li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
							<?php if ( ! empty( $s['intro_btn_text'] ) ) : ?>
								<a class="btn btn-gold" href="<?php echo esc_url( $btn_url ); ?>"<?php echo empty( $s['intro_btn_link']['url'] ) ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( $s['intro_btn_text'] ); ?></a>
							<?php endif; ?>
						</div>
					</div>

					<?php
					/* ---------- 2. STATS ---------- */
					if ( ! empty( $s['stats'] ) ) :
						?>
						<div class="ap-stats" data-reveal="fade-up">
							<span class="ap-stats__blob" aria-hidden="true"></span>
							<?php foreach ( $s['stats'] as $stat ) : ?>
								<div class="ap-stat">
									<b data-count="<?php echo esc_attr( $stat['number'] ?? '' ); ?>"><?php echo esc_html( $stat['number'] ?? '' ); ?></b>
									<span><?php echo esc_html( $stat['label'] ?? '' ); ?></span>
								</div>
							<?php endforeach; ?>
						</div>
						<?php
					endif;

					/* ---------- 3. VALUES ---------- */
					if ( ! empty( $s['values'] ) ) :
						?>
						<div class="ap-values-wrap">
							<?php $this->render_heading_block( $s, 'v_' ); ?>
							<div class="ap-values">
								<?php foreach ( $s['values'] as $i => $val ) : ?>
									<div class="ap-value" data-reveal="fade-up" data-delay="<?php echo esc_attr( ( $i % 3 ) * 90 ); ?>">
										<span class="ap-value-ico"><?php hamagopest_icon( $val['icon'] ?? 'shield-check' ); ?></span>
										<h3><?php echo esc_html( $val['title'] ?? '' ); ?></h3>
										<p><?php echo esc_html( $val['desc'] ?? '' ); ?></p>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
						<?php
					endif;

					/* ---------- 4. TIMELINE ---------- */
					if ( ! empty( $s['timeline'] ) ) :
						?>
						<div class="ap-timeline-wrap">
							<?php $this->render_heading_block( $s, 't_' ); ?>
							<div class="ap-timeline">
								<?php foreach ( $s['timeline'] as $i => $tl ) : ?>
									<div class="ap-tl-item" data-reveal="fade-up" data-delay="<?php echo esc_attr( ( $i % 2 ) * 120 ); ?>">
										<div class="ap-tl-card">
											<span class="ap-tl-year"><?php echo esc_html( $tl['year'] ?? '' ); ?></span>
											<h4><?php echo esc_html( $tl['title'] ?? '' ); ?></h4>
											<p><?php echo esc_html( $tl['desc'] ?? '' ); ?></p>
										</div>
										<span class="ap-tl-dot" aria-hidden="true"></span>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
						<?php
					endif;

					/* ---------- 5. CERTS ---------- */
					if ( ! empty( $s['certs'] ) ) :
						?>
						<div class="ap-certs" data-reveal="zoom">
							<?php foreach ( $s['certs'] as $cert ) : ?>
								<span class="ap-cert">
									<?php hamagopest_icon( $cert['icon'] ?? 'shield-check' ); ?>
									<?php echo esc_html( $cert['text'] ?? '' ); ?>
								</span>
							<?php endforeach; ?>
						</div>
						<?php
					endif;
					?>
				</div>
			</section>
		</div>
		<?php
	}
}
