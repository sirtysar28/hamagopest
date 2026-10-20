<?php
/**
 * Integrasi Elementor — super aman (fail-safe) untuk semua versi Elementor
 * dan PHP 7.4 s/d 8.2+.
 *
 * Prinsip:
 * 1. Theme dimuat SETELAH plugin → hook 'elementor/loaded' sudah lewat,
 *    jadi integrasi dijalankan langsung via did_action().
 * 2. Semua dibungkus try/catch \Throwable — kegagalan apapun di integrasi
 *    tidak pernah menjatuhkan website (hanya tercatat di error log).
 * 3. Hanya memakai API Elementor yang stabil, tanpa filter eksperimental.
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Inisialisasi integrasi Elementor (dipanggil hanya bila Elementor aktif).
 */
function hamagopest_elementor_init() {

	if ( ! class_exists( '\Elementor\Plugin' ) ) {
		return;
	}

	require_once HAMAGOPEST_DIR . '/inc/elementor/icons.php';

	/* Base class WAJIB ada sebelum file widget (semua widget extends-nya).
	 * Bila file hilang/kosong (upload parsial), JANGAN require widget sama
	 * sekali — otherwise fatal "Class Hamagopest_Widget_Base not found"
	 * menghantam seluruh halaman. Self-heal di admin-pages.php yang menangani
	 * pemuatan begitu file tersedia. */
	if ( ! class_exists( 'Hamagopest_Widget_Base' ) ) {
		$base = HAMAGOPEST_DIR . '/inc/elementor/class-widget-base.php';
		if ( is_readable( $base ) && filesize( $base ) > 200 ) {
			require_once $base;
		}
	}
	if ( ! class_exists( 'Hamagopest_Widget_Base' ) ) {
		error_log( '[hamagopest] inc/elementor/class-widget-base.php tidak ada/tidak utuh — pemuatan widget theme dilewati agar tidak fatal.' );
		return;
	}

	$widgets = array(
		'class-hero-widget',
		'class-usp-widget',
		'class-about-widget',
		'class-services-widget',
		'class-process-widget',
		'class-video-cta-widget',
		'class-clients-widget',
		'class-testimonials-widget',
		'class-posts-widget',
		'class-booking-widget',
		'class-pagehero-widget',
		'class-aboutpage-widget',
		'class-servicespage-widget',
		'class-contact-widget',
	);

	foreach ( $widgets as $widget ) {
		$file = HAMAGOPEST_DIR . '/inc/elementor/widgets/' . $widget . '.php';
		if ( is_readable( $file ) && filesize( $file ) > 200 ) {
			require_once $file;
		}
	}

	/* Kategori "Hamago Elements" di panel widget Elementor. */
	if ( ! has_action( 'elementor/elements/categories_registered', 'hamagopest_register_elementor_category' ) ) {
		add_action( 'elementor/elements/categories_registered', 'hamagopest_register_elementor_category' );
	}

	/* Registrasi widget — dua hook agar kompatibel Elementor baru & lama. */
	if ( ! has_action( 'elementor/widgets/register', 'hamagopest_register_elementor_widgets' ) ) {
		add_action( 'elementor/widgets/register', 'hamagopest_register_elementor_widgets' );
		add_action( 'elementor/widgets/widgets_registered', 'hamagopest_register_elementor_widgets' );
	}

	/* Jaring pengaman untuk Elementor 4.x: jika kedua hook di atas SUDAH terlewat
	 * (kasus plugin/cache memaksa Elementor boot lebih awal), daftarkan widget
	 * langsung ke widgets_manager saat init. Registrasi ganda aman — id sama
	 * hanya menimpa dirinya sendiri. */
	add_action(
		'init',
		function () {
			hamagopest_register_widgets_safe();
		},
		20
	);

	/* Kesempatan kedua setelah SEMUA plugin & theme termuat — menutup kasus
	 * OPcache/opcache.validate_timestamps=0 di shared hosting yang menyajikan
	 * file PHP lama, atau plugin cache yang meng-boot Elementor sangat awal. */
	add_action(
		'wp_loaded',
		function () {
			hamagopest_register_widgets_safe();
		}
	);

	/* Theme Builder locations (Elementor Pro: header/footer/single/archive). */
	if ( ! has_action( 'elementor/theme/register_locations', 'hamagopest_register_elementor_locations' ) ) {
		add_action( 'elementor/theme/register_locations', 'hamagopest_register_elementor_locations' );
	}

	/* Style theme + font HANYA di iframe preview Elementor — bukan di halaman
	 * admin editor (menghindari bentrok class .wrap theme vs .wrap WP admin). */
	add_action( 'elementor/preview/enqueue_styles', 'hamagopest_elementor_enqueue_styles' );
	add_action( 'elementor/preview/enqueue_scripts', 'hamagopest_elementor_enqueue_scripts' );
	add_action( 'elementor/editor/before_enqueue_styles', 'hamagopest_elementor_enqueue_fonts' );

	/* Lebar default konten container Elementor mengikuti theme. */
	add_filter(
		'elementor/container/default_content_width',
		function () {
			return '1180';
		}
	);
}

/**
 * Kategori widget "Hamago Elements".
 */
function hamagopest_register_elementor_category( $elements_manager ) {
	try {
		$elements_manager->add_category(
			'hamago-elements',
			array(
				'title' => __( 'Hamago Elements', 'hamagopest' ),
				'icon'  => 'eicon-shield',
			)
		);
	} catch ( \Throwable $e ) {
		error_log( '[hamagopest] category: ' . $e->getMessage() );
	}
}

/**
 * Registrasi SELURUH widget — kompatibel Elementor 3.5+ dan versi lama.
 * Guard statis mencegah registrasi ganda bila dua hook terpicu bersamaan.
 */
function hamagopest_register_elementor_widgets( $widgets_manager ) {
	static $done = false;
	if ( $done ) {
		return;
	}
	$done = true;

	$classes = array(
		'Hamagopest_Hero_Widget',
		'Hamagopest_USP_Widget',
		'Hamagopest_About_Widget',
		'Hamagopest_Services_Widget',
		'Hamagopest_Process_Widget',
		'Hamagopest_Video_CTA_Widget',
		'Hamagopest_Clients_Widget',
		'Hamagopest_Testimonials_Widget',
		'Hamagopest_Posts_Widget',
		'Hamagopest_Booking_Widget',
		'Hamagopest_PageHero_Widget',
		'Hamagopest_AboutPage_Widget',
		'Hamagopest_ServicesPage_Widget',
		'Hamagopest_Contact_Widget',
	);

	foreach ( $classes as $class ) {
		try {
			if ( ! class_exists( $class ) ) {
				continue;
			}
			if ( is_callable( array( $widgets_manager, 'register' ) ) ) {
				$widgets_manager->register( new $class() ); // Elementor 3.5+.
			} elseif ( is_callable( array( $widgets_manager, 'register_widget_type' ) ) ) {
				$widgets_manager->register_widget_type( new $class() ); // Elementor < 3.5.
			}
		} catch ( \Throwable $e ) {
			error_log( '[hamagopest] widget ' . $class . ': ' . $e->getMessage() );
		}
	}
}

/**
 * Registrasi widget SELF-HEALING — dipanggil di 'init' & 'wp_loaded'.
 *
 * Mengapa per-widget: jika file theme ter-upload sebagian (mis. zip terputus
 * atau OPcache menyajikan file lama), widget baru tidak termuat. Elementor
 * lalu me-render widget tak dikenal sebagai KOSONG TANPA PERINGATAN — persis
 * kasus "halaman jadi kosong setelah Terapkan Desain Modern". Fungsi ini
 * memeriksa SATU-PER-SATU widget di widgets_manager dan mendaftarkan yang
 * hilang, sehingga recovery otomatis begitu file tersedia / cache bersih.
 */
function hamagopest_register_widgets_safe() {
	try {
		if ( ! did_action( 'elementor/loaded' ) || ! class_exists( '\Elementor\Plugin' ) ) {
			return;
		}
		$manager = \Elementor\Plugin::instance()->widgets_manager ?? null;
		if ( ! $manager || ! is_callable( array( $manager, 'get_widget_type' ) ) || ! is_callable( array( $manager, 'register' ) ) ) {
			return;
		}

		$map = array(
			'hamago_hero'          => 'Hamagopest_Hero_Widget',
			'hamago_usp'           => 'Hamagopest_USP_Widget',
			'hamago_about'         => 'Hamagopest_About_Widget',
			'hamago_services'      => 'Hamagopest_Services_Widget',
			'hamago_process'       => 'Hamagopest_Process_Widget',
			'hamago_video_cta'     => 'Hamagopest_Video_CTA_Widget',
			'hamago_clients'       => 'Hamagopest_Clients_Widget',
			'hamago_testimonials'  => 'Hamagopest_Testimonials_Widget',
			'hamago_posts'         => 'Hamagopest_Posts_Widget',
			'hamago_booking'       => 'Hamagopest_Booking_Widget',
			'hamago_pagehero'      => 'Hamagopest_PageHero_Widget',
			'hamago_about_page'    => 'Hamagopest_AboutPage_Widget',
			'hamago_services_page' => 'Hamagopest_ServicesPage_Widget',
			'hamago_contact'       => 'Hamagopest_Contact_Widget',
		);

		foreach ( $map as $widget_name => $class ) {
			if ( $manager->get_widget_type( $widget_name ) ) {
				continue; /* Sudah terdaftar. */
			}
			if ( ! class_exists( $class ) ) {
				continue; /* File belum termuat (partial upload / OPcache lama). */
			}
			$manager->register( new $class() );
		}
	} catch ( \Throwable $e ) {
		error_log( '[hamagopest] register_widgets_safe: ' . $e->getMessage() );
	}
}

/**
 * Registrasi lokasi Theme Builder (Elementor Pro).
 */
function hamagopest_register_elementor_locations( $location_manager ) {
	try {
		if ( is_callable( array( $location_manager, 'register_all_core_location' ) ) ) {
			$location_manager->register_all_core_location();
		}
	} catch ( \Throwable $e ) {
		error_log( '[hamagopest] locations: ' . $e->getMessage() );
	}
}

/**
 * Bootstrap — dipanggil langsung saat theme dimuat.
 *
 * WordPress memuat plugin lebih dulu, sehingga saat functions.php theme
 * berjalan hook 'elementor/loaded' SUDAH terpicu. Pola lama
 * add_action( 'elementor/loaded', ... ) di theme adalah dead code dan menjadi
 * penyebab integrasi Elementor tidak pernah berjalan.
 */
function hamagopest_elementor_bootstrap() {
	if ( ! did_action( 'elementor/loaded' ) && ! class_exists( '\Elementor\Plugin' ) ) {
		return;
	}

	try {
		hamagopest_elementor_init();
	} catch ( \Throwable $e ) {
		error_log( '[hamagopest] Elementor init gagal: ' . $e->getMessage() );
	}
}
hamagopest_elementor_bootstrap();

/**
 * Font Google untuk editor & preview Elementor.
 */
function hamagopest_elementor_enqueue_fonts() {
	wp_enqueue_style(
		'hamagopest-fonts',
		'https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap',
		array(),
		null
	);
}

/**
 * Style theme (CSS) untuk iframe preview Elementor.
 */
function hamagopest_elementor_enqueue_styles() {
	hamagopest_elementor_enqueue_fonts();
	wp_enqueue_style( 'hamagopest-main', HAMAGOPEST_URI . '/assets/css/main.css', array(), HAMAGOPEST_VERSION );
}

/**
 * Script theme (JS) untuk iframe preview Elementor.
 */
function hamagopest_elementor_enqueue_scripts() {
	wp_enqueue_script( 'hamagopest-main', HAMAGOPEST_URI . '/assets/js/main.js', array(), HAMAGOPEST_VERSION, true );
}

/**
 * Deteksi apakah halaman dirender oleh Elementor.
 *
 * Berbasis meta _elementor_edit_mode — sama seperti
 * Elementor\Document::is_built_with_elementor(), tanpa memanggil instance
 * (aman dari fatal "call to member function on bool").
 */
function hamagopest_is_elementor_page( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();

	if ( ! $post_id || ! class_exists( '\Elementor\Plugin' ) ) {
		return false;
	}

	return 'builder' === get_post_meta( $post_id, '_elementor_edit_mode', true );
}
