<?php
/**
 * Customizer — pengaturan kontak, sosial media, footer,
 * dan SELURUH konten homepage (teks + gambar) yang bisa diedit
 * dari Appearance → Customize → "Hamago Pest — Pengaturan".
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function hamagopest_customize_register( $wp_customize ) {

	/* ===================== PANEL HAMAGO ===================== */
	$wp_customize->add_panel(
		'hamagopest_panel',
		array(
			'title'    => __( 'Hamago Pest — Pengaturan', 'hamagopest' ),
			'priority' => 30,
		)
	);

	/* ---------- Section: Kontak & WhatsApp ---------- */
	$wp_customize->add_section(
		'hamagopest_contact',
		array(
			'title' => __( 'Kontak & WhatsApp', 'hamagopest' ),
			'panel' => 'hamagopest_panel',
		)
	);

	$fields = array(
		'hamagopest_phone'   => array(
			'label'   => __( 'Nomor Telepon', 'hamagopest' ),
			'default' => '+62 896-0140-4999',
			'type'    => 'text',
		),
		'hamagopest_wa'      => array(
			'label'       => __( 'Nomor WhatsApp', 'hamagopest' ),
			'description' => __( 'Contoh: +6289601404999', 'hamagopest' ),
			'default'     => '+62 896-0140-4999',
			'type'        => 'text',
		),
		'hamagopest_address' => array(
			'label'   => __( 'Alamat Kantor', 'hamagopest' ),
			'default' => __( 'Pembina Graha, Jl. DI. Panjaitan, Jatinegara, Jakarta Timur 13350', 'hamagopest' ),
			'type'    => 'textarea',
		),
		'hamagopest_email'   => array(
			'label'   => __( 'Email', 'hamagopest' ),
			'default' => 'info@hamagopest.co.id',
			'type'    => 'text',
		),
		'hamagopest_hours'   => array(
			'label'   => __( 'Jam Operasional', 'hamagopest' ),
			'default' => __( 'Senin – Sabtu: 08.00 – 17.00 WIB', 'hamagopest' ),
			'type'    => 'textarea',
		),
	);

	foreach ( $fields as $id => $args ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $args['default'],
				'sanitize_callback' => 'textarea' === $args['type'] ? 'sanitize_textarea_field' : 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'       => $args['label'],
				'description' => isset( $args['description'] ) ? $args['description'] : '',
				'section'     => 'hamagopest_contact',
				'type'        => $args['type'],
			)
		);
	}

/* URL embed Google Maps untuk halaman Kontak (widget "Hamago \u2014 Kontak & Maps").
 * Cara ambil: Google Maps \u2192 cari lokasi \u2192 Bagikan \u2192 Sematkan peta \u2192 salin
 * isi atribut src dari iframe. Kosong = peta otomatis dari alamat kantor. */
$wp_customize->add_setting(
	'hamagopest_map_embed',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	'hamagopest_map_embed',
	array(
		'label'       => __( 'URL Embed Google Maps', 'hamagopest' ),
		'description' => __( 'Tempel isi src iframe dari Google Maps (Bagikan \u2192 Sematkan peta). Kosongkan untuk peta otomatis berdasarkan alamat kantor.', 'hamagopest' ),
		'section'     => 'hamagopest_contact',
		'type'        => 'url',
	)
);

	/* ---------- Section: Top Bar ---------- */
	$wp_customize->add_section(
		'hamagopest_topbar',
		array(
			'title' => __( 'Top Bar (atas header)', 'hamagopest' ),
			'panel' => 'hamagopest_panel',
		)
	);

	$wp_customize->add_setting(
		'hamagopest_topbar_show',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);
	$wp_customize->add_control(
		'hamagopest_topbar_show',
		array(
			'label'   => __( 'Tampilkan top bar', 'hamagopest' ),
			'section' => 'hamagopest_topbar',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'hamagopest_topbar_cta',
		array(
			'default'           => __( 'Inspeksi Gratis Hari Ini', 'hamagopest' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'hamagopest_topbar_cta',
		array(
			'label'   => __( 'Teks CTA top bar', 'hamagopest' ),
			'section' => 'hamagopest_topbar',
			'type'    => 'text',
		)
	);

	/* ---------- Section: Sosial Media ---------- */
	$wp_customize->add_section(
		'hamagopest_social',
		array(
			'title' => __( 'Sosial Media', 'hamagopest' ),
			'panel' => 'hamagopest_panel',
		)
	);

	$socials = array(
		'hamagopest_social_facebook'  => __( 'URL Facebook', 'hamagopest' ),
		'hamagopest_social_instagram' => __( 'URL Instagram', 'hamagopest' ),
		'hamagopest_social_tiktok'    => __( 'URL TikTok', 'hamagopest' ),
		'hamagopest_social_youtube'   => __( 'URL YouTube', 'hamagopest' ),
		'hamagopest_social_x'         => __( 'URL X / Twitter', 'hamagopest' ),
	);

	foreach ( $socials as $id => $label ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $label,
				'section' => 'hamagopest_social',
				'type'    => 'url',
			)
		);
	}

	/* ---------- Section: Footer ---------- */
	$wp_customize->add_section(
		'hamagopest_footer',
		array(
			'title' => __( 'Footer', 'hamagopest' ),
			'panel' => 'hamagopest_panel',
		)
	);

	$wp_customize->add_setting(
		'hamagopest_footer_about',
		array(
			'default'           => __( 'Solusi profesional, efektif, dan aman untuk membasmi hama hingga ke sarangnya.', 'hamagopest' ),
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'hamagopest_footer_about',
		array(
			'label'   => __( 'Deskripsi singkat di footer', 'hamagopest' ),
			'section' => 'hamagopest_footer',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hamagopest_footer_logo',
		array(
			'default'           => '',
			'sanitize_callback' => 'hamagopest_sanitize_logo_value',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control( /* Media_Control deprecated & dihapus di WP modern */
			$wp_customize,
			'hamagopest_footer_logo',
			array(
				'label'     => __( 'Logo Footer (versi putih disarankan)', 'hamagopest' ),
				'section'   => 'hamagopest_footer',
			)
		)
	);

	$wp_customize->add_setting(
		'hamagopest_copyright',
		array(
			'default'           => __( '© %s Hamago Pest Solutions. Seluruh hak cipta dilindungi.', 'hamagopest' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'hamagopest_copyright',
		array(
			'label'   => __( 'Teks copyright (%s = tahun)', 'hamagopest' ),
			'section' => 'hamagopest_footer',
			'type'    => 'text',
		)
	);

	/* ---------- Section: Tombol WhatsApp Float ---------- */
	$wp_customize->add_section(
		'hamagopest_wa_float',
		array(
			'title' => __( 'Tombol WhatsApp Melayang', 'hamagopest' ),
			'panel' => 'hamagopest_panel',
		)
	);

	$wp_customize->add_setting(
		'hamagopest_wa_float_show',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);
	$wp_customize->add_control(
		'hamagopest_wa_float_show',
		array(
			'label'   => __( 'Tampilkan tombol WhatsApp melayang', 'hamagopest' ),
			'section' => 'hamagopest_wa_float',
			'type'    => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'hamagopest_customize_register' );

/**
 * Sanitize nilai logo: numerik (attachment ID lama) ATAU URL gambar.
 */
function hamagopest_sanitize_logo_value( $value ) {
	$value = trim( (string) $value );
	if ( '' === $value ) {
		return '';
	}
	if ( ctype_digit( $value ) ) {
		return (string) absint( $value );
	}
	return esc_url_raw( $value );
}

/* =========================================================================
 * HOMEPAGE — SEMUA konten section editable via Customizer.
 * Satu sumber default (hamagopest_home_defaults) dipakai bersama oleh
 * Customizer DAN template homepage sehingga isi awal = demo asli.
 * ====================================================================== */

/**
 * Default konten homepage (key TANPA prefix hamagopest_).
 */
function hamagopest_home_defaults() {
	return array(
		/* Hero */
		'hero_show'        => true,
		'hero_eyebrow'     => __( 'Pest Control Bersertifikat', 'hamagopest' ),
		'hero_title'       => __( 'Bebas hama, <span class="accent">bukan sekadar janji.</span>', 'hamagopest' ),
		'hero_lead'        => __( 'Hamago menangani rayap, serangga, dan tikus sampai ke sumber masalahnya — dengan metode terukur, tenaga ahli berpengalaman, dan garansi layanan untuk rumah maupun bisnis Anda.', 'hamagopest' ),
		'hero_btn1_text'   => __( 'Ajukan Inspeksi Gratis', 'hamagopest' ),
		'hero_btn1_url'    => '',
		'hero_btn2_text'   => __( 'Lihat Layanan', 'hamagopest' ),
		'hero_btn2_url'    => '#layanan',
		'hero_image_1'     => '',
		'hero_image_2'     => '',
		'hero_image_3'     => '',
		'hero_image_4'     => '',
		'hero_image_5'     => '',
		'hero_overlay'     => 30,
		'hero_slide_speed' => 5,
		'hero_stat1_number' => '10+',
		'hero_stat1_label'  => __( 'Tahun menangani hama', 'hamagopest' ),
		'hero_stat2_number' => '1.200+',
		'hero_stat2_label'  => __( 'Properti tertangani', 'hamagopest' ),
		'hero_stat3_number' => '4.9/5',
		'hero_stat3_label'  => __( 'Rating kepuasan klien', 'hamagopest' ),

		/* USP */
		'usp_show'    => true,
		'usp_eyebrow' => __( 'Kenapa Hamago', 'hamagopest' ),
		'usp_heading' => __( 'Empat alasan klien kami bertahan bertahun-tahun', 'hamagopest' ),
		'usp_sub'     => __( 'Bukan cuma menyemprot dan pergi — kami merancang solusi sesuai kondisi properti, lalu memastikan hasilnya bertahan.', 'hamagopest' ),
		'usp1_icon'   => 'search',
		'usp1_title'  => __( 'Inspeksi Gratis', 'hamagopest' ),
		'usp1_desc'   => __( 'Tim kami memetakan titik masuk dan sarang hama sebelum menentukan rencana penanganan — tanpa biaya.', 'hamagopest' ),
		'usp2_icon'   => 'target',
		'usp2_title'  => __( 'Solusi Kustom', 'hamagopest' ),
		'usp2_desc'   => __( 'Metode disesuaikan dengan jenis hama, tingkat infestasi, dan karakter bangunan Anda.', 'hamagopest' ),
		'usp3_icon'   => 'bundle',
		'usp3_title'  => __( 'Paket Bundling', 'hamagopest' ),
		'usp3_desc'   => __( 'Perawatan rutin tahunan dengan harga lebih hemat, dirancang untuk mencegah hama datang kembali.', 'hamagopest' ),
		'usp4_icon'   => 'price',
		'usp4_title'  => __( 'Harga Transparan', 'hamagopest' ),
		'usp4_desc'   => __( 'Penawaran jelas di awal, tanpa biaya tersembunyi, sepadan dengan kualitas layanan yang Anda terima.', 'hamagopest' ),

		/* About */
		'about_show'      => true,
		'about_eyebrow'   => __( 'Tentang Kami', 'hamagopest' ),
		'about_heading'   => __( 'Mitra pengendalian hama yang bekerja dengan data, bukan tebakan', 'hamagopest' ),
		'about_body'      => __( 'Hamago Pest Solutions memadukan teknisi bersertifikat dengan pendekatan yang terukur untuk menjaga hunian dan area komersial tetap bersih dan sehat. Setiap metode yang kami pakai diuji aman bagi keluarga dan lingkungan kerja Anda, mulai dari inspeksi awal hingga pemantauan pasca-treatment.', 'hamagopest' ),
		'about_btn_text'  => __( 'Pelajari Layanan Kami', 'hamagopest' ),
		'about_btn_url'   => '#layanan',
		'about_cell1_value' => '10+',
		'about_cell1_label' => __( 'Tahun pengalaman lapangan', 'hamagopest' ),
		'about_cell2_value' => '50+',
		'about_cell2_label' => __( 'Teknisi bersertifikat', 'hamagopest' ),
		'about_cell3_value' => '15',
		'about_cell3_label' => __( 'Kota jangkauan layanan', 'hamagopest' ),
		'about_cell4_value' => '98%',
		'about_cell4_label' => __( 'Klien merekomendasikan', 'hamagopest' ),

		/* Services */
		'svc_show'    => true,
		'svc_eyebrow' => __( 'Layanan Kami', 'hamagopest' ),
		'svc_heading' => __( 'Penanganan hama yang paling sering mengganggu properti Anda', 'hamagopest' ),
		'svc1_icon'   => 'rat',
		'svc1_title'  => __( 'Rodent Control', 'hamagopest' ),
		'svc1_desc'   => __( 'Pengendalian tikus dan hama pengerat secara menyeluruh: deteksi jalur masuk, pengumpanan aman, dan sanitasi area agar infestasi tidak kembali.', 'hamagopest' ),
		'svc1_methods' => '',
		'svc2_icon'   => 'bug',
		'svc2_title'  => __( 'Pest Control', 'hamagopest' ),
		'svc2_desc'   => __( 'Pengendalian hama umum — kecoa, semut, nyamuk, lalat, dan serangga lainnya — untuk rumah, kantor, hingga area komersial.', 'hamagopest' ),
		'svc2_methods' => '',
		'svc3_icon'   => 'termite',
		'svc3_title'  => __( 'Termite Control', 'hamagopest' ),
		'svc3_desc'   => __( 'Basmi rayap hingga ke koloninya dengan metode terpilih sesuai kondisi bangunan Anda.', 'hamagopest' ),
		'svc3_methods' => __( "Metode Pipanisasi\nMetode Baiting (Pengumpanan)\nMetode Injeksi — Penyuntikan Chemical Anti Rayap", 'hamagopest' ),
		'svc4_icon'   => 'fumigation',
		'svc4_title'  => __( 'Fumigasi', 'hamagopest' ),
		'svc4_desc'   => __( 'Pengasapan komoditas, gudang, dan kontainer memakai fumigan resmi, dikerjakan tenaga ahli bersertifikat.', 'hamagopest' ),
		'svc4_methods' => '',
		'svc5_icon'   => 'spray',
		'svc5_title'  => __( 'Disinfeksi & Sanitasi', 'hamagopest' ),
		'svc5_desc'   => __( 'Kebersihan permukaan saja tidak cukup — kami membasmi virus dan bakteri untuk lingkungan yang lebih higienis.', 'hamagopest' ),
		'svc5_methods' => '',
		'svc6_icon'   => 'snake',
		'svc6_title'  => __( 'Pengendalian Hewan Pengganggu', 'hamagopest' ),
		'svc6_desc'   => __( 'Ular, biawak, kucing liar, tawon, lebah, dan hewan pengganggu lainnya ditangani dengan aman oleh tim berpengalaman.', 'hamagopest' ),
		'svc6_methods' => '',
		'svc7_icon'   => 'scent',
		'svc7_title'  => __( 'Pengharum Ruangan', 'hamagopest' ),
		'svc7_desc'   => __( 'Layanan pengharum ruangan untuk kantor dan hotel — aroma segar, tahan lama, dan aman bagi penghuni.', 'hamagopest' ),
		'svc7_methods' => '',
		'svc8_icon'   => 'broom',
		'svc8_title'  => __( 'Cleaning Services', 'hamagopest' ),
		'svc8_desc'   => __( 'Layanan pembersihan profesional untuk rumah, kantor, dan area komersial — hasil bersih, rapi, dan higienis oleh tim terlatih.', 'hamagopest' ),
		'svc8_methods' => '',

		/* Process */
		'proc_show'    => true,
		'proc_eyebrow' => __( 'Cara Kerja', 'hamagopest' ),
		'proc_heading' => __( 'Empat langkah menuju properti yang bebas hama', 'hamagopest' ),
		'proc1_title'  => __( 'Konsultasi', 'hamagopest' ),
		'proc1_desc'   => __( 'Ceritakan keluhan hama Anda lewat telepon atau WhatsApp, kami jadwalkan kunjungan.', 'hamagopest' ),
		'proc2_title'  => __( 'Inspeksi Lapangan', 'hamagopest' ),
		'proc2_desc'   => __( 'Teknisi memetakan titik masuk dan tingkat infestasi secara langsung di lokasi.', 'hamagopest' ),
		'proc3_title'  => __( 'Treatment', 'hamagopest' ),
		'proc3_desc'   => __( 'Penanganan dilakukan sesuai rencana yang disepakati, dengan metode yang aman.', 'hamagopest' ),
		'proc4_title'  => __( 'Pemantauan', 'hamagopest' ),
		'proc4_desc'   => __( 'Kami pantau hasil dan berikan garansi agar hama tidak kembali.', 'hamagopest' ),

		/* Video CTA */
		'video_show'    => true,
		'video_eyebrow' => __( 'Kenali Hamago', 'hamagopest' ),
		'video_heading' => __( 'Lihat bagaimana tim kami menangani masalah hama dari awal sampai tuntas', 'hamagopest' ),
		'video_sub'     => __( 'Tonton cuplikan proses kerja lapangan tim teknisi Hamago di berbagai properti klien.', 'hamagopest' ),
		'video_url'     => '',

		/* Clients */
		'clients_show'    => true,
		'clients_eyebrow' => __( 'Dipercaya Oleh', 'hamagopest' ),
		'clients_heading' => __( 'Mitra dan klien Hamago', 'hamagopest' ),
		/* Clients — repeater JSON (nama + logo + url), tak terbatas. */
		'clients_items'  => wp_json_encode(
			array(
				array( 'name' => 'Anya Living', 'logo' => '', 'url' => '' ),
				array( 'name' => 'Streat Koppi', 'logo' => '', 'url' => '' ),
				array( 'name' => 'BRImedika', 'logo' => '', 'url' => '' ),
				array( 'name' => 'Casablanca Mansion', 'logo' => '', 'url' => '' ),
				array( 'name' => 'Oasis Residence', 'logo' => '', 'url' => '' ),
				array( 'name' => 'Syofia Islamic School', 'logo' => '', 'url' => '' ),
			)
		),

		/* Testimonials */
		'testi_show'    => true,
		'testi_eyebrow' => __( 'Testimoni', 'hamagopest' ),
		'testi_heading' => __( 'Apa kata klien tentang layanan kami', 'hamagopest' ),
		'testi1_quote'  => __( 'Tim Hamago datang tepat waktu dan menjelaskan setiap tahap penanganan dengan jelas. Masalah rayap di rumah kami akhirnya tuntas.', 'hamagopest' ),
		'testi1_name'   => 'Andi Prasetyo',
		'testi1_role'   => __( 'Pemilik Rumah, Jakarta Timur', 'hamagopest' ),
		'testi2_quote'  => __( 'Sebagai pengelola gedung, kami butuh mitra yang bisa diandalkan untuk perawatan rutin. Hamago konsisten dan rapi dalam laporan kerja.', 'hamagopest' ),
		'testi2_name'   => 'Mira Santoso',
		'testi2_role'   => 'Building Manager',
		'testi3_quote'  => __( 'Harga yang ditawarkan transparan sejak awal, tidak ada biaya tambahan mendadak. Hasilnya juga sesuai yang dijanjikan.', 'hamagopest' ),
		'testi3_name'   => 'Rian Kusuma',
		'testi3_role'   => __( 'Pemilik Restoran', 'hamagopest' ),

		/* Repeater JSON — layanan & testimoni tak terbatas (fallback field lama di atas tetap dipakai bila repeater belum pernah disimpan). */
		'services_items' => wp_json_encode(
			array(
				array( 'image' => '', 'icon' => 'rat', 'title' => 'Rodent Control', 'desc' => __( 'Pengendalian tikus dan hama pengerat secara menyeluruh: deteksi jalur masuk, pengumpanan aman, dan sanitasi area agar infestasi tidak kembali.', 'hamagopest' ), 'methods' => '', 'link' => '' ),
				array( 'image' => '', 'icon' => 'bug', 'title' => 'Pest Control', 'desc' => __( 'Pengendalian hama umum — kecoa, semut, nyamuk, lalat, dan serangga lainnya — untuk rumah, kantor, hingga area komersial.', 'hamagopest' ), 'methods' => '', 'link' => '' ),
				array( 'image' => '', 'icon' => 'termite', 'title' => 'Termite Control', 'desc' => __( 'Basmi rayap hingga ke koloninya dengan metode terpilih sesuai kondisi bangunan Anda.', 'hamagopest' ), 'methods' => __( "Metode Pipanisasi\nMetode Baiting (Pengumpanan)\nMetode Injeksi — Penyuntikan Chemical Anti Rayap", 'hamagopest' ), 'link' => '' ),
				array( 'image' => '', 'icon' => 'fumigation', 'title' => 'Fumigasi', 'desc' => __( 'Pengasapan komoditas, gudang, dan kontainer memakai fumigan resmi, dikerjakan tenaga ahli bersertifikat.', 'hamagopest' ), 'methods' => '', 'link' => '' ),
				array( 'image' => '', 'icon' => 'spray', 'title' => 'Disinfeksi & Sanitasi', 'desc' => __( 'Kebersihan permukaan saja tidak cukup — kami membasmi virus dan bakteri untuk lingkungan yang lebih higienis.', 'hamagopest' ), 'methods' => '', 'link' => '' ),
				array( 'image' => '', 'icon' => 'snake', 'title' => 'Pengendalian Hewan Pengganggu', 'desc' => __( 'Ular, biawak, kucing liar, tawon, lebah, dan hewan pengganggu lainnya ditangani dengan aman oleh tim berpengalaman.', 'hamagopest' ), 'methods' => '', 'link' => '' ),
				array( 'image' => '', 'icon' => 'scent', 'title' => 'Pengharum Ruangan', 'desc' => __( 'Layanan pengharum ruangan untuk kantor dan hotel — aroma segar, tahan lama, dan aman bagi penghuni.', 'hamagopest' ), 'methods' => '', 'link' => '' ),
				array( 'image' => '', 'icon' => 'broom', 'title' => 'Cleaning Services', 'desc' => __( 'Layanan pembersihan profesional untuk rumah, kantor, dan area komersial — hasil bersih, rapi, dan higienis oleh tim terlatih.', 'hamagopest' ), 'methods' => '', 'link' => '' ),
			)
		),
		'testi_items'    => wp_json_encode(
			array(
				array( 'quote' => __( 'Tim Hamago datang tepat waktu dan menjelaskan setiap tahap penanganan dengan jelas. Masalah rayap di rumah kami akhirnya tuntas.', 'hamagopest' ), 'name' => 'Andi Prasetyo', 'role' => __( 'Pemilik Rumah, Jakarta Timur', 'hamagopest' ), 'avatar' => '' ),
				array( 'quote' => __( 'Sebagai pengelola gedung, kami butuh mitra yang bisa diandalkan untuk perawatan rutin. Hamago konsisten dan rapi dalam laporan kerja.', 'hamagopest' ), 'name' => 'Mira Santoso', 'role' => 'Building Manager', 'avatar' => '' ),
				array( 'quote' => __( 'Harga yang ditawarkan transparan sejak awal, tidak ada biaya tambahan mendadak. Hasilnya juga sesuai yang dijanjikan.', 'hamagopest' ), 'name' => 'Rian Kusuma', 'role' => __( 'Pemilik Restoran', 'hamagopest' ), 'avatar' => '' ),
			)
		),

		/* Booking */
		'booking_show'     => true,
		'booking_heading'  => __( 'Siap bebas dari hama?', 'hamagopest' ),
		'booking_sub'      => __( 'Jadwalkan inspeksi gratis dan konsultasikan masalah hama Anda hari ini.', 'hamagopest' ),
		'booking_btn_text' => __( 'Hubungi via WhatsApp', 'hamagopest' ),
		'booking_btn_url'  => '',
	);
}

/**
 * Ambil setting homepage: theme mod bila ada, atau default bersama.
 */
function hamagopest_home_mod( $key, $fallback = '' ) {
	$defaults = hamagopest_home_defaults();
	$default  = array_key_exists( $key, $defaults ) ? $defaults[ $key ] : $fallback;
	return get_theme_mod( 'hamagopest_' . $key, $default );
}

/**
 * Sanitize judul — izinkan <span class="accent"> dsb.
 */
function hamagopest_sanitize_heading( $text ) {
	return wp_kses(
		(string) $text,
		array(
			'span'   => array( 'class' => array() ),
			'br'     => array(),
			'strong' => array(),
			'em'     => array(),
			'b'      => array(),
		)
	);
}

/**
 * Registrasi setting + control Customizer secara ringkas.
 */
function hamagopest_home_field( $wp_customize, $key, $args ) {

	$type    = isset( $args['type'] ) ? $args['type'] : 'text';
	$section = $args['section'];
	$label   = isset( $args['label'] ) ? $args['label'] : '';
	$id      = 'hamagopest_' . $key;

	/* Default selalu diambil dari sumber bersama. */
	$defaults = hamagopest_home_defaults();
	$default  = array_key_exists( $key, $defaults ) ? $defaults[ $key ] : '';

	$desc = isset( $args['description'] ) ? $args['description'] : '';

	switch ( $type ) {
		case 'url':
			$sanitize = 'esc_url_raw';
			break;
		case 'image':
			$sanitize = 'esc_url_raw'; /* WP_Customize_Image_Control menyimpan URL. */
			break;
		case 'textarea':
			$sanitize = 'sanitize_textarea_field';
			break;
		case 'heading':
			$sanitize = 'hamagopest_sanitize_heading';
			break;
		case 'checkbox':
			$sanitize = 'wp_validate_boolean';
			break;
		case 'range':
			$sanitize = 'absint';
			break;
		case 'icon':
			$sanitize = 'sanitize_key';
			break;
		default:
			$sanitize = 'sanitize_text_field';
	}

	$wp_customize->add_setting(
		$id,
		array(
			'default'           => $default,
			'sanitize_callback' => $sanitize,
		)
	);

	if ( 'image' === $type ) {
		if ( class_exists( 'WP_Customize_Image_Control' ) ) {
			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					$id,
					array(
						'label'       => $label,
						'description' => $desc,
						'section'     => $section,
					)
				)
			);
		} else {
			/* Fallback bila class image dihapus WP: input URL manual. */
			$wp_customize->add_control(
				$id,
				array(
					'label'       => $label,
					'description' => $desc . ' ' . __( '(tempel URL gambar)', 'hamagopest' ),
						'section'     => $section,
						'type'        => 'url',
					)
			);
		}
		return;
	}

	$wp_customize->add_control(
		$id,
		array(
			'label'       => $label,
			'description' => $desc,
			'section'     => $section,
			'type'        => ( 'heading' === $type ) ? 'textarea' : $type,
			'choices'     => isset( $args['choices'] ) ? $args['choices'] : array(),
			'input_attrs' => isset( $args['input_attrs'] ) ? $args['input_attrs'] : array(),
		)
	);
}

/**
 * Registrasi seluruh section homepage di Customizer.
 */
function hamagopest_home_customize_register( $wp_customize ) {

	$panel  = 'hamagopest_panel';
	$iconsl = hamagopest_icon_options();

	/* ================= HERO ================= */
	$wp_customize->add_section(
		'hamagopest_home_hero',
		array(
			'title'       => __( 'Homepage — Hero', 'hamagopest' ),
			'description' => __( 'Judul, teks, tombol, statistik, dan gambar BACKGROUND. Animasi radar selalu tampil; gambar jadi background di belakangnya (1 gambar = statis, 2 gambar atau lebih = slider otomatis).', 'hamagopest' ),
			'panel'       => $panel,
		)
	);

	hamagopest_home_field( $wp_customize, 'hero_show', array( 'type' => 'checkbox', 'label' => __( 'Tampilkan section Hero', 'hamagopest' ), 'section' => 'hamagopest_home_hero' ) );
	hamagopest_home_field( $wp_customize, 'hero_eyebrow', array( 'label' => __( 'Eyebrow (label kecil)', 'hamagopest' ), 'section' => 'hamagopest_home_hero' ) );
	hamagopest_home_field( $wp_customize, 'hero_title', array( 'type' => 'heading', 'label' => __( 'Judul Utama', 'hamagopest' ), 'description' => __( 'Bisa pakai <span class="accent">teks</span> untuk aksen emas.', 'hamagopest' ), 'section' => 'hamagopest_home_hero' ) );
	hamagopest_home_field( $wp_customize, 'hero_lead', array( 'type' => 'textarea', 'label' => __( 'Paragraf Pengantar', 'hamagopest' ), 'section' => 'hamagopest_home_hero' ) );
	hamagopest_home_field( $wp_customize, 'hero_btn1_text', array( 'label' => __( 'Tombol Utama — Teks', 'hamagopest' ), 'section' => 'hamagopest_home_hero' ) );
	hamagopest_home_field( $wp_customize, 'hero_btn1_url', array( 'type' => 'url', 'label' => __( 'Tombol Utama — Link', 'hamagopest' ), 'description' => __( 'Kosongkan untuk otomatis ke WhatsApp.', 'hamagopest' ), 'section' => 'hamagopest_home_hero' ) );
	hamagopest_home_field( $wp_customize, 'hero_btn2_text', array( 'label' => __( 'Tombol Kedua — Teks', 'hamagopest' ), 'section' => 'hamagopest_home_hero' ) );
	hamagopest_home_field( $wp_customize, 'hero_btn2_url', array( 'type' => 'url', 'label' => __( 'Tombol Kedua — Link', 'hamagopest' ), 'section' => 'hamagopest_home_hero' ) );

	for ( $i = 1; $i <= 5; $i++ ) {
		hamagopest_home_field( $wp_customize, 'hero_image_' . $i, array( 'type' => 'image', 'label' => sprintf( __( 'Gambar Hero %d', 'hamagopest' ), $i ), 'section' => 'hamagopest_home_hero' ) );
	}
	hamagopest_home_field( $wp_customize, 'hero_overlay', array( 'type' => 'range', 'label' => __( 'Bayangan Gelap / Overlay (%)', 'hamagopest' ), 'description' => __( 'Default 30% — kegelapan overlay di atas gambar agar teks terbaca.', 'hamagopest' ), 'input_attrs' => array( 'min' => 0, 'max' => 90, 'step' => 5 ), 'section' => 'hamagopest_home_hero' ) );
	hamagopest_home_field( $wp_customize, 'hero_slide_speed', array( 'type' => 'range', 'label' => __( 'Durasi Per Slide (detik)', 'hamagopest' ), 'input_attrs' => array( 'min' => 2, 'max' => 10, 'step' => 1 ), 'section' => 'hamagopest_home_hero' ) );

	for ( $i = 1; $i <= 3; $i++ ) {
		hamagopest_home_field( $wp_customize, 'hero_stat' . $i . '_number', array( 'label' => sprintf( __( 'Statistik %d — Angka', 'hamagopest' ), $i ), 'section' => 'hamagopest_home_hero' ) );
		hamagopest_home_field( $wp_customize, 'hero_stat' . $i . '_label', array( 'label' => sprintf( __( 'Statistik %d — Keterangan', 'hamagopest' ), $i ), 'section' => 'hamagopest_home_hero' ) );
	}

	/* ================= USP ================= */
	$wp_customize->add_section( 'hamagopest_home_usp', array( 'title' => __( 'Homepage — Keunggulan (USP)', 'hamagopest' ), 'panel' => $panel ) );
	hamagopest_home_field( $wp_customize, 'usp_show', array( 'type' => 'checkbox', 'label' => __( 'Tampilkan section', 'hamagopest' ), 'section' => 'hamagopest_home_usp' ) );
	hamagopest_home_field( $wp_customize, 'usp_eyebrow', array( 'label' => __( 'Eyebrow', 'hamagopest' ), 'section' => 'hamagopest_home_usp' ) );
	hamagopest_home_field( $wp_customize, 'usp_heading', array( 'type' => 'heading', 'label' => __( 'Judul', 'hamagopest' ), 'section' => 'hamagopest_home_usp' ) );
	hamagopest_home_field( $wp_customize, 'usp_sub', array( 'type' => 'textarea', 'label' => __( 'Deskripsi pendek', 'hamagopest' ), 'section' => 'hamagopest_home_usp' ) );

	for ( $i = 1; $i <= 4; $i++ ) {
		hamagopest_home_field( $wp_customize, 'usp' . $i . '_icon', array( 'type' => 'icon', 'label' => sprintf( __( 'Keunggulan %d — Icon', 'hamagopest' ), $i ), 'choices' => $iconsl, 'section' => 'hamagopest_home_usp' ) );
		hamagopest_home_field( $wp_customize, 'usp' . $i . '_title', array( 'label' => sprintf( __( 'Keunggulan %d — Judul', 'hamagopest' ), $i ), 'section' => 'hamagopest_home_usp' ) );
		hamagopest_home_field( $wp_customize, 'usp' . $i . '_desc', array( 'type' => 'textarea', 'label' => sprintf( __( 'Keunggulan %d — Deskripsi', 'hamagopest' ), $i ), 'section' => 'hamagopest_home_usp' ) );
	}

	/* ================= ABOUT ================= */
	$wp_customize->add_section( 'hamagopest_home_about', array( 'title' => __( 'Homepage — Tentang', 'hamagopest' ), 'panel' => $panel ) );
	hamagopest_home_field( $wp_customize, 'about_show', array( 'type' => 'checkbox', 'label' => __( 'Tampilkan section', 'hamagopest' ), 'section' => 'hamagopest_home_about' ) );
	hamagopest_home_field( $wp_customize, 'about_eyebrow', array( 'label' => __( 'Eyebrow', 'hamagopest' ), 'section' => 'hamagopest_home_about' ) );
	hamagopest_home_field( $wp_customize, 'about_heading', array( 'type' => 'heading', 'label' => __( 'Judul', 'hamagopest' ), 'section' => 'hamagopest_home_about' ) );
	hamagopest_home_field( $wp_customize, 'about_body', array( 'type' => 'textarea', 'label' => __( 'Paragraf', 'hamagopest' ), 'section' => 'hamagopest_home_about' ) );
	hamagopest_home_field( $wp_customize, 'about_btn_text', array( 'label' => __( 'Teks Tombol', 'hamagopest' ), 'section' => 'hamagopest_home_about' ) );
	hamagopest_home_field( $wp_customize, 'about_btn_url', array( 'type' => 'url', 'label' => __( 'Link Tombol', 'hamagopest' ), 'section' => 'hamagopest_home_about' ) );

	for ( $i = 1; $i <= 4; $i++ ) {
		hamagopest_home_field( $wp_customize, 'about_cell' . $i . '_value', array( 'label' => sprintf( __( 'Kotak %d — Angka', 'hamagopest' ), $i ), 'section' => 'hamagopest_home_about' ) );
		hamagopest_home_field( $wp_customize, 'about_cell' . $i . '_label', array( 'label' => sprintf( __( 'Kotak %d — Keterangan', 'hamagopest' ), $i ), 'section' => 'hamagopest_home_about' ) );
	}

	/* ================= SERVICES ================= */
	$wp_customize->add_section( 'hamagopest_home_services', array( 'title' => __( 'Homepage — Layanan', 'hamagopest' ), 'description' => __( 'Daftar layanan TAK TERBATAS — tambah kartu sebanyak apa pun. Upload gambar opsional per kartu: jika diisi gambar tampil di atas kartu, jika dikosongkan kartu memakai icon. Kosongkan judul untuk menyembunyikan kartu. Daftar metode ditulis satu per baris.', 'hamagopest' ), 'panel' => $panel ) );
	hamagopest_home_field( $wp_customize, 'svc_show', array( 'type' => 'checkbox', 'label' => __( 'Tampilkan section', 'hamagopest' ), 'section' => 'hamagopest_home_services' ) );
	hamagopest_home_field( $wp_customize, 'svc_eyebrow', array( 'label' => __( 'Eyebrow', 'hamagopest' ), 'section' => 'hamagopest_home_services' ) );
	hamagopest_home_field( $wp_customize, 'svc_heading', array( 'type' => 'heading', 'label' => __( 'Judul', 'hamagopest' ), 'section' => 'hamagopest_home_services' ) );

	$wp_customize->add_setting(
		'hamagopest_services_items',
		array(
			'default'           => hamagopest_home_defaults()['services_items'],
			'sanitize_callback' => 'hamagopest_sanitize_services_json',
		)
	);
	if ( class_exists( 'Hamagopest_Repeater_Control' ) ) {
		$wp_customize->add_control(
			new Hamagopest_Repeater_Control(
				$wp_customize,
				'hamagopest_services_items',
				array(
					'label'       => __( 'Daftar Layanan (tak terbatas)', 'hamagopest' ),
					'description' => __( 'Klik judul baris untuk membuka/tutup isian. Kartu tanpa judul otomatis disembunyikan.', 'hamagopest' ),
					'section'     => 'hamagopest_home_services',
					'add_label'   => __( '+ Tambah Layanan', 'hamagopest' ),
					'fields'      => array(
						'image'   => array( 'label' => __( 'Gambar Kartu (opsional)', 'hamagopest' ), 'type' => 'image' ),
						'icon'    => array( 'label' => __( 'Icon', 'hamagopest' ), 'type' => 'select', 'options' => $iconsl ),
						'title'   => array( 'label' => __( 'Judul Layanan', 'hamagopest' ), 'type' => 'text', 'placeholder' => __( 'Nama layanan', 'hamagopest' ) ),
						'desc'    => array( 'label' => __( 'Deskripsi', 'hamagopest' ), 'type' => 'textarea', 'placeholder' => __( 'Deskripsi singkat layanan', 'hamagopest' ) ),
						'methods' => array( 'label' => __( 'Daftar Metode — satu per baris (opsional)', 'hamagopest' ), 'type' => 'textarea' ),
						'link'    => array( 'label' => __( 'Link "Selengkapnya" (opsional)', 'hamagopest' ), 'type' => 'url', 'placeholder' => 'https://' ),
					),
				)
			)
		);
	} else {
		$wp_customize->add_control(
			'hamagopest_services_items',
			array(
				'label'   => __( 'Daftar Layanan (JSON)', 'hamagopest' ),
				'section' => 'hamagopest_home_services',
				'type'    => 'textarea',
			)
		);
	}

	/* ================= PROCESS ================= */
	$wp_customize->add_section( 'hamagopest_home_process', array( 'title' => __( 'Homepage — Cara Kerja', 'hamagopest' ), 'panel' => $panel ) );
	hamagopest_home_field( $wp_customize, 'proc_show', array( 'type' => 'checkbox', 'label' => __( 'Tampilkan section', 'hamagopest' ), 'section' => 'hamagopest_home_process' ) );
	hamagopest_home_field( $wp_customize, 'proc_eyebrow', array( 'label' => __( 'Eyebrow', 'hamagopest' ), 'section' => 'hamagopest_home_process' ) );
	hamagopest_home_field( $wp_customize, 'proc_heading', array( 'type' => 'heading', 'label' => __( 'Judul', 'hamagopest' ), 'section' => 'hamagopest_home_process' ) );

	for ( $i = 1; $i <= 4; $i++ ) {
		hamagopest_home_field( $wp_customize, 'proc' . $i . '_title', array( 'label' => sprintf( __( 'Langkah %d — Judul', 'hamagopest' ), $i ), 'section' => 'hamagopest_home_process' ) );
		hamagopest_home_field( $wp_customize, 'proc' . $i . '_desc', array( 'type' => 'textarea', 'label' => sprintf( __( 'Langkah %d — Deskripsi', 'hamagopest' ), $i ), 'section' => 'hamagopest_home_process' ) );
	}

	/* ================= VIDEO CTA ================= */
	$wp_customize->add_section( 'hamagopest_home_video', array( 'title' => __( 'Homepage — Video CTA', 'hamagopest' ), 'panel' => $panel ) );
	hamagopest_home_field( $wp_customize, 'video_show', array( 'type' => 'checkbox', 'label' => __( 'Tampilkan section', 'hamagopest' ), 'section' => 'hamagopest_home_video' ) );
	hamagopest_home_field( $wp_customize, 'video_eyebrow', array( 'label' => __( 'Eyebrow', 'hamagopest' ), 'section' => 'hamagopest_home_video' ) );
	hamagopest_home_field( $wp_customize, 'video_heading', array( 'type' => 'heading', 'label' => __( 'Judul', 'hamagopest' ), 'section' => 'hamagopest_home_video' ) );
	hamagopest_home_field( $wp_customize, 'video_sub', array( 'type' => 'textarea', 'label' => __( 'Deskripsi', 'hamagopest' ), 'section' => 'hamagopest_home_video' ) );
	hamagopest_home_field( $wp_customize, 'video_url', array( 'type' => 'url', 'label' => __( 'Link Video (YouTube/Vimeo)', 'hamagopest' ), 'description' => __( 'Kosongkan untuk menampilkan tombol play sebagai aksen.', 'hamagopest' ), 'section' => 'hamagopest_home_video' ) );

	/* ================= CLIENTS ================= */
	$wp_customize->add_section( 'hamagopest_home_clients', array( 'title' => __( 'Homepage — Klien', 'hamagopest' ), 'description' => __( 'Tambah klien seberapa pun — upload logo (dan link opsional). Ada logo → section jadi slider logo berjalan otomatis; tanpa logo → tampil sebagai pill teks.', 'hamagopest' ), 'panel' => $panel ) );
	hamagopest_home_field( $wp_customize, 'clients_show', array( 'type' => 'checkbox', 'label' => __( 'Tampilkan section', 'hamagopest' ), 'section' => 'hamagopest_home_clients' ) );
	hamagopest_home_field( $wp_customize, 'clients_eyebrow', array( 'label' => __( 'Eyebrow', 'hamagopest' ), 'section' => 'hamagopest_home_clients' ) );
	hamagopest_home_field( $wp_customize, 'clients_heading', array( 'label' => __( 'Judul', 'hamagopest' ), 'section' => 'hamagopest_home_clients' ) );

	$wp_customize->add_setting(
		'hamagopest_clients_items',
		array(
			'default'           => hamagopest_home_defaults()['clients_items'],
			'sanitize_callback' => 'hamagopest_sanitize_clients_json',
		)
	);
	if ( class_exists( 'Hamagopest_Clients_Control' ) ) {
		$wp_customize->add_control(
			new Hamagopest_Clients_Control(
				$wp_customize,
				'hamagopest_clients_items',
				array(
					'label'       => __( 'Daftar Klien', 'hamagopest' ),
					'description' => __( 'Item tanpa nama & logo otomatis disembunyikan.', 'hamagopest' ),
					'section'     => 'hamagopest_home_clients',
				)
			)
		);
	} else {
		$wp_customize->add_control(
			'hamagopest_clients_items',
			array(
				'label'   => __( 'Daftar Klien (JSON)', 'hamagopest' ),
				'section' => 'hamagopest_home_clients',
				'type'    => 'textarea',
			)
		);
	}

	/* ================= TESTIMONIALS ================= */
	$wp_customize->add_section( 'hamagopest_home_testi', array( 'title' => __( 'Homepage — Testimoni', 'hamagopest' ), 'description' => __( 'Daftar testimoni TAK TERBATAS. Sampai 3 item tampil sebagai grid; lebih dari 3 otomatis menjadi slider dengan tombol navigasi.', 'hamagopest' ), 'panel' => $panel ) );
	hamagopest_home_field( $wp_customize, 'testi_show', array( 'type' => 'checkbox', 'label' => __( 'Tampilkan section', 'hamagopest' ), 'section' => 'hamagopest_home_testi' ) );
	hamagopest_home_field( $wp_customize, 'testi_eyebrow', array( 'label' => __( 'Eyebrow', 'hamagopest' ), 'section' => 'hamagopest_home_testi' ) );
	hamagopest_home_field( $wp_customize, 'testi_heading', array( 'type' => 'heading', 'label' => __( 'Judul', 'hamagopest' ), 'section' => 'hamagopest_home_testi' ) );

	$wp_customize->add_setting(
		'hamagopest_testi_items',
		array(
			'default'           => hamagopest_home_defaults()['testi_items'],
			'sanitize_callback' => 'hamagopest_sanitize_testi_json',
		)
	);
	if ( class_exists( 'Hamagopest_Repeater_Control' ) ) {
		$wp_customize->add_control(
			new Hamagopest_Repeater_Control(
				$wp_customize,
				'hamagopest_testi_items',
				array(
					'label'       => __( 'Daftar Testimoni (tak terbatas)', 'hamagopest' ),
					'description' => __( 'Klik judul baris untuk membuka/tutup isian. Lebih dari 3 item otomatis tampil sebagai slider.', 'hamagopest' ),
					'section'     => 'hamagopest_home_testi',
					'add_label'   => __( '+ Tambah Testimoni', 'hamagopest' ),
					'fields'      => array(
						'quote'  => array( 'label' => __( 'Isi Testimoni', 'hamagopest' ), 'type' => 'textarea', 'placeholder' => __( 'Tulis isi testimoni di sini…', 'hamagopest' ) ),
						'name'   => array( 'label' => __( 'Nama Klien', 'hamagopest' ), 'type' => 'text', 'placeholder' => __( 'Nama klien', 'hamagopest' ) ),
						'role'   => array( 'label' => __( 'Jabatan / Keterangan', 'hamagopest' ), 'type' => 'text', 'placeholder' => __( 'mis. Pemilik Rumah, Jakarta Timur', 'hamagopest' ) ),
						'avatar' => array( 'label' => __( 'Foto (opsional — kosongkan untuk avatar inisial)', 'hamagopest' ), 'type' => 'image' ),
					),
				)
			)
		);
	} else {
		$wp_customize->add_control(
			'hamagopest_testi_items',
			array(
					'label'   => __( 'Daftar Testimoni (JSON)', 'hamagopest' ),
				'section' => 'hamagopest_home_testi',
				'type'    => 'textarea',
			)
		);
	}

	/* ================= BOOKING ================= */
	$wp_customize->add_section( 'hamagopest_home_booking', array( 'title' => __( 'Homepage — Booking CTA', 'hamagopest' ), 'panel' => $panel ) );
	hamagopest_home_field( $wp_customize, 'booking_show', array( 'type' => 'checkbox', 'label' => __( 'Tampilkan section', 'hamagopest' ), 'section' => 'hamagopest_home_booking' ) );
	hamagopest_home_field( $wp_customize, 'booking_heading', array( 'type' => 'heading', 'label' => __( 'Judul', 'hamagopest' ), 'section' => 'hamagopest_home_booking' ) );
	hamagopest_home_field( $wp_customize, 'booking_sub', array( 'type' => 'textarea', 'label' => __( 'Deskripsi', 'hamagopest' ), 'section' => 'hamagopest_home_booking' ) );
	hamagopest_home_field( $wp_customize, 'booking_btn_text', array( 'label' => __( 'Teks Tombol', 'hamagopest' ), 'section' => 'hamagopest_home_booking' ) );
	hamagopest_home_field( $wp_customize, 'booking_btn_url', array( 'type' => 'url', 'label' => __( 'Link Tombol', 'hamagopest' ), 'description' => __( 'Kosongkan untuk otomatis ke WhatsApp.', 'hamagopest' ), 'section' => 'hamagopest_home_booking' ) );
}
add_action( 'customize_register', 'hamagopest_home_customize_register', 20 );
