<?php
/**
 * Penerapan template Elementor dari file JSON — generik, TANPA otomasi.
 *
 * Sejak v1.9.0 seluruh tombol/aksi otomatis dihapus (notice dashboard,
 * "Terapkan Desain Modern", tombol perbaiki widget, hint melayang,
 * auto-sync Saved Templates) karena bermasalah di hosting dengan upload
 * theme yang tidak lengkap.
 *
 * Penerapan desain modern sekarang cukup IMPORT MANUAL:
 * Elementor → Templates → Saved Templates → Import Templates → pilih file
 * JSON (folder hamago-elementor-templates-IMPORT/ di luar folder theme),
 * lalu sisipkan ke halaman via editor Elementor → tab My Templates.
 *
 * Fungsi di file ini dipertahankan karena masih dipakai sistem Beranda
 * (inc/admin-homepage.php).
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Terapkan file template Elementor (JSON export) ke sebuah halaman.
 *
 * @param int    $page_id ID halaman.
 * @param string $file    Path absolut file template JSON.
 * @return bool
 */
function hamagopest_apply_page_template_file( $page_id, $file ) {

	$page_id = absint( $page_id );

	if ( ! $page_id || ! is_readable( $file ) || ! hamagopest_elementor_active() ) {
		return false;
	}

	$raw    = file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	$parsed = $raw ? json_decode( $raw, true ) : null;

	if ( ! is_array( $parsed ) ) {
		return false;
	}

	/* File export Elementor modern menyimpan 'content' sebagai ARRAY;
	 * versi lama sebagai string JSON — tangani keduanya. */
	if ( isset( $parsed['content'] ) && is_string( $parsed['content'] ) ) {
		$elements = $parsed['content'];
	} elseif ( isset( $parsed['content'] ) && is_array( $parsed['content'] ) ) {
		$elements = wp_json_encode( $parsed['content'] );
	} else {
		$elements = wp_json_encode( $parsed );
	}

	json_decode( $elements );
	if ( json_last_error() !== JSON_ERROR_NONE ) {
		return false;
	}

	update_post_meta( $page_id, '_elementor_edit_mode', 'builder' );
	update_post_meta( $page_id, '_elementor_data', wp_slash( $elements ) );
	update_post_meta( $page_id, '_elementor_template_type', 'wp-page' );
	if ( defined( 'ELEMENTOR_VERSION' ) ) {
		update_post_meta( $page_id, '_elementor_version', ELEMENTOR_VERSION );
	}

	/* Hapus meta CSS lama agar Elementor me-regenerate stylesheet-nya. */
	delete_post_meta( $page_id, '_elementor_css' );

	return true;
}
