<?php
/**
 * Helper Homepage (Beranda) — memastikan homepage bisa diedit via Elementor.
 *
 * Fitur:
 * 1. Notice di WP Dashboard bila Elementor aktif tapi belum ada static front
 *    page → tombol "Siapkan Halaman Beranda" SEKALI KLIK:
 *    membuat halaman "Beranda", mengaktifkan static front page, lalu langsung
 *    membuka editor Elementor untuk halaman tersebut.
 * 2. Hint melayang (hanya untuk admin yang login) saat homepage masih mode
 *    demo — klik untuk setup, atau langsung "Edit dengan Elementor" bila
 *    halaman beranda sudah ada.
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Apakah plugin Elementor aktif?
 */
function hamagopest_elementor_active() {
	return did_action( 'elementor/loaded' ) || class_exists( '\Elementor\Plugin' );
}

/**
 * Izinkan upload file .json — dibutuhkan untuk import template Elementor
 * (mis. beranda-template.json). Banyak shared hosting / konfigurasi keamanan
 * memblokir json secara default sehingga import gagal dengan error
 * "Sorry, this file type is not permitted for security reasons".
 */
function hamagopest_allow_json_upload( $mimes ) {
	if ( ! isset( $mimes['json'] ) ) {
		$mimes['json'] = 'application/json';
	}
	return $mimes;
}
add_filter( 'upload_mimes', 'hamagopest_allow_json_upload' );

/**
 * Beberapa WP check real mime via finfo — pastikan json lolos verifikasi
 * wp_check_filetype_and_ext() (json kadang terdeteksi text/plain).
 */
function hamagopest_json_ext_check( $types, $file, $filename, $mimes ) {
	if ( empty( $types['ext'] ) && preg_match( '/\.json$/i', $filename ) ) {
		$types['ext']  = 'json';
		$types['type'] = 'application/json';
	}
	return $types;
}
add_filter( 'wp_check_filetype_and_ext', 'hamagopest_json_ext_check', 10, 4 );

/**
 * Apakah halaman punya konten Elementor yang sudah diisi (bukan cuma canvas kosong)?
 */
function hamagopest_elementor_has_content( $post_id ) {
	$data = get_post_meta( (int) $post_id, '_elementor_data', true );
	return $data && '' !== trim( $data ) && '[]' !== trim( $data );
}

/**
 * URL aksi setup beranda (dengan nonce).
 */
function hamagopest_setup_front_url() {
	return wp_nonce_url(
		admin_url( 'admin.php?action=hamagopest_setup_front_page' ),
		'hamagopest_setup_front'
	);
}

/**
 * Terapkan template "Beranda" (10 widget Hamago Elements — isi sama persis
 * dengan homepage demo) ke sebuah halaman, sehingga langsung penuh dan tinggal
 * diedit via Elementor tanpa membangun dari nol.
 *
 * Sumber template: inc/elementor/beranda-template.json (format export
 * Elementor standar — juga bisa diimport manual via Elementor).
 *
 * @param int $page_id ID halaman.
 * @return bool True bila template berhasil diterapkan.
 */
function hamagopest_apply_beranda_template( $page_id ) {
	return hamagopest_apply_page_template_file(
		$page_id,
		HAMAGOPEST_DIR . '/inc/elementor/beranda-template.json'
	);
}

/**
 * Daftarkan template "Beranda" ke library Elementor (Saved Templates)
 * secara OTOMATIS — tanpa perlu import JSON sama sekali.
 *
 * Sinkronisasi kini ditangani hamagopest_sync_library_templates()
 * (inc/admin-pages.php) yang mencakup Beranda + Tentang Kami +
 * Layanan + Kontak sekaligus. Fungsi ini tetap ada sebagai delegasi
 * agar kode pihak ketiga yang memanggilnya tetap berjalan.
 */
function hamagopest_sync_beranda_library_template() {
	if ( function_exists( 'hamagopest_sync_library_templates' ) ) {
		hamagopest_sync_library_templates();
	}
}

/**
 * Notice dashboard: ajak admin menyiapkan beranda Elementor.
 */
function hamagopest_front_page_admin_notice() {

	if ( ! current_user_can( 'manage_options' ) || ! hamagopest_elementor_active() ) {
		return;
	}

	/* Sudah ada static front page → tidak perlu notice. */
	if ( 'page' === get_option( 'show_on_front' ) && (int) get_option( 'page_on_front' ) > 0 ) {
		return;
	}

	/* Notice sudah disembunyikan user ini. */
	if ( get_user_meta( get_current_user_id(), 'hamagopest_hide_front_nag', true ) ) {
		return;
	}

	$dismiss_url = wp_nonce_url(
		admin_url( 'admin.php?action=hamagopest_dismiss_front_nag' ),
		'hamagopest_dismiss_front_nag'
	);
	?>
	<div class="notice notice-info">
		<p>
			<strong><?php esc_html_e( 'Hamago Theme:', 'hamagopest' ); ?></strong>
			<?php esc_html_e( 'homepage masih memakai tampilan demo theme. Klik tombol di bawah — halaman Beranda dibuat otomatis berisi konten lengkap (sama seperti demo) dan langsung bisa diedit dengan Elementor. Template juga tersedia otomatis di Saved Templates dengan nama "Beranda — Hamago (Theme)".', 'hamagopest' ); ?>
		</p>
		<p>
			<a href="<?php echo esc_url( hamagopest_setup_front_url() ); ?>" class="button button-primary">
				<?php esc_html_e( 'Siapkan Halaman Beranda (Elementor)', 'hamagopest' ); ?>
			</a>
			<a href="<?php echo esc_url( $dismiss_url ); ?>" class="button" style="margin-left:6px">
				<?php esc_html_e( 'Jangan tampilkan lagi', 'hamagopest' ); ?>
			</a>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'hamagopest_front_page_admin_notice' );

/**
 * Handler aksi admin: setup beranda & dismiss notice.
 */
function hamagopest_handle_front_page_actions() {

	if ( ! isset( $_GET['action'] ) ) {
		return;
	}

	$action = sanitize_key( wp_unslash( $_GET['action'] ) );

	/* ---- Setup beranda sekali klik ---- */
	if ( 'hamagopest_setup_front_page' === $action ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Anda tidak punya izin untuk aksi ini.', 'hamagopest' ) );
		}
		check_admin_referer( 'hamagopest_setup_front' );

		/* Pakai halaman "Beranda" yang sudah ada bila ada. */
		$page    = get_page_by_path( 'beranda' );
		$page_id = $page ? (int) $page->ID : 0;

		if ( ! $page_id ) {
			$page_id = (int) wp_insert_post(
				array(
					'post_title'   => __( 'Beranda', 'hamagopest' ),
					'post_name'    => 'beranda',
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_content' => '',
				)
			);
		}

		if ( ! $page_id || is_wp_error( $page_id ) ) {
			wp_die( esc_html__( 'Gagal membuat halaman Beranda. Coba buat manual via Pages → Add New.', 'hamagopest' ) );
		}

		/* Terapkan template Beranda (isi sama seperti homepage demo) bila halaman
		 * belum punya konten Elementor — jadi halaman langsung penuh & tinggal diedit. */
		if ( ! hamagopest_elementor_has_content( $page_id ) ) {
			hamagopest_apply_beranda_template( $page_id );
		}

		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $page_id );
		flush_rewrite_rules();

		/* Langsung buka editor Elementor untuk halaman beranda. */
		wp_safe_redirect( admin_url( 'post.php?post=' . $page_id . '&action=elementor' ) );
		exit;
	}

	/* ---- Sembunyikan notice ---- */
	if ( 'hamagopest_dismiss_front_nag' === $action ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		check_admin_referer( 'hamagopest_dismiss_front_nag' );

		update_user_meta( get_current_user_id(), 'hamagopest_hide_front_nag', 1 );
		wp_safe_redirect( remove_query_arg( array( 'action', '_wpnonce' ), wp_get_referer() ? wp_get_referer() : admin_url() ) );
		exit;
	}
}
add_action( 'admin_init', 'hamagopest_handle_front_page_actions' );

/**
 * Hint melayang di homepage — HANYA untuk admin yang login.
 * Hilang otomatis setelah beranda Elementor aktif.
 */
function hamagopest_front_edit_hint() {

	if ( ! is_user_logged_in() || ! current_user_can( 'manage_options' ) || ! is_front_page() ) {
		return;
	}
	if ( ! hamagopest_elementor_active() ) {
		return;
	}

	$front_id      = (int) get_option( 'page_on_front' );
	$is_static     = 'page' === get_option( 'show_on_front' ) && $front_id > 0;
	$has_elementor = $is_static && hamagopest_is_elementor_page( $front_id ) && hamagopest_elementor_has_content( $front_id );

	/* Beranda sudah Elementor → tidak perlu hint. */
	if ( $has_elementor ) {
		return;
	}

	if ( $is_static ) {
		$label = __( 'Edit Beranda dengan Elementor', 'hamagopest' );
		$url   = admin_url( 'post.php?post=' . $front_id . '&action=elementor' );
	} else {
		$label = __( 'Homepage masih demo — siapkan Beranda Elementor', 'hamagopest' );
		$url   = hamagopest_setup_front_url();
	}
	?>
	<div class="hmg-front-hint" id="hmgFrontHint">
		<span class="hmg-front-hint__dot" aria-hidden="true"></span>
		<a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a>
		<button type="button" class="hmg-front-hint__close" id="hmgFrontHintClose" aria-label="<?php esc_attr_e( 'Tutup', 'hamagopest' ); ?>">&times;</button>
	</div>
	<script>
	(function () {
		var box = document.getElementById('hmgFrontHint');
		var btn = document.getElementById('hmgFrontHintClose');
		if (!box || !btn) return;
		try { if (localStorage.getItem('hmgFrontHintOff') === '1') { box.remove(); return; } } catch (e) {}
		btn.addEventListener('click', function () {
			box.remove();
			try { localStorage.setItem('hmgFrontHintOff', '1'); } catch (e) {}
		});
	})();
	</script>
	<?php
}
add_action( 'wp_footer', 'hamagopest_front_edit_hint' );
