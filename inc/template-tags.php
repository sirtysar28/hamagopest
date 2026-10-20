<?php
/**
 * Template tags & helper functions.
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Nomor telepon (Customizer).
 */
function hamagopest_get_phone() {
	return get_theme_mod( 'hamagopest_phone', '+62 896-0140-4999' );
}

/**
 * Nomor WhatsApp tanpa simbol (untuk wa.me).
 */
function hamagopest_get_wa_number() {
	$raw = get_theme_mod( 'hamagopest_wa', '+62 896-0140-4999' );
	$dig = preg_replace( '/[^0-9]/', '', $raw );
	return $dig;
}

/**
 * Link WhatsApp dengan pesan default.
 */
function hamagopest_wa_link( $text = '' ) {
	$text = $text ? $text : __( 'Halo Hamago Pest Solutions, saya ingin konsultasi masalah hama.', 'hamagopest' );
	return 'https://wa.me/' . hamagopest_get_wa_number() . '?text=' . rawurlencode( $text );
}

/**
 * Alamat (Customizer).
 */
function hamagopest_get_address() {
	return get_theme_mod( 'hamagopest_address', __( 'Pembina Graha, Jl. DI. Panjaitan, Jatinegara, Jakarta Timur 13350', 'hamagopest' ) );
}

/**
 * Link tel: dari nomor telepon.
 */
function hamagopest_tel_link() {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', hamagopest_get_phone() );
}

/**
 * Logo situs header/footer — selalu membawa <a> sendiri.
 *
 * PENTING: dulu pemanggil (header.php/footer.php) membungkus output fungsi ini
 * dengan <a> lain, padahal the_custom_logo() sudah mengeluarkan <a> miliknya —
 * menghasilkan <a> bersarang (HTML invalid). Browser memecah DOM akibatnya dan
 * logo menjadi "turun ke bawah" / tidak sejajar dengan menu.
 */
function hamagopest_site_logo( $footer = false ) {

	/* Header + custom logo → pakai markup WP (sudah punya <a>-nya sendiri). */
	if ( ! $footer && has_custom_logo() ) {
		the_custom_logo();
		return;
	}

	/* Footer + logo footer dari Customizer → img dibungkus <a> sendiri. */
	if ( $footer && get_theme_mod( 'hamagopest_footer_logo' ) ) {
		$logo_val = (string) get_theme_mod( 'hamagopest_footer_logo' );
		$img      = '';
		if ( ctype_digit( $logo_val ) ) {
			/* Data lama (Media_Control) = attachment ID. */
			$img = wp_get_attachment_image(
				absint( $logo_val ),
				'medium',
				false,
				array(
					'class' => 'footer-logo-img',
					'alt'  => get_bloginfo( 'name' ),
				)
			);
		} elseif ( filter_var( $logo_val, FILTER_VALIDATE_URL ) ) {
			/* Data baru (Image_Control) = URL. */
			$img = sprintf(
				'<img src="%1$s" class="footer-logo-img" alt="%2$s" />',
				esc_url( $logo_val ),
				esc_attr( get_bloginfo( 'name' ) )
			);
		}
		if ( $img ) {
			printf(
				'<a href="%1$s" class="foot-logo" aria-label="%2$s">%3$s</a>',
				esc_url( home_url( '/' ) ),
				esc_attr( get_bloginfo( 'name' ) ),
				$img
			);
			return;
		}
	}

	/* Fallback teks brand — dibungkus <a> sendiri agar tidak bersarang. */
	printf(
		'<a href="%1$s" class="%2$s" rel="home" aria-label="%3$s"><span class="logo-text%4$s"><span class="dot"></span>%5$s<span class="logo-dot-accent">.</span></span></a>',
		esc_url( home_url( '/' ) ),
		$footer ? 'foot-logo' : 'logo',
		esc_attr( get_bloginfo( 'name' ) ),
		$footer ? ' footer-logo-text' : '',
		esc_html( get_bloginfo( 'name' ) )
	);
}

/**
 * Normalisasi URL untuk tombol/widget: link relatif ("/layanan/...")
 * otomatis dijadikan absolut — esc_url() menolak URL tanpa scheme sehingga
 * tanpa ini tombol "Selengkapnya" bisa hilang. Anchor (#) & URL absolut
 * dikembalikan apa adanya.
 */
function hamagopest_maybe_home_url( $url ) {
	$url = trim( (string) $url );
	if ( '' === $url || '#' === $url[0] || preg_match( '#^([a-z][a-z0-9+.-]*:|//)#i', $url ) ) {
		return $url;
	}
	return home_url( '/' . ltrim( $url, '/' ) );
}

/**
 * Kategori post pertama sebagai "tag" kartu blog.
 */
function hamagopest_first_category( $post_id = 0 ) {
	$cats = get_the_category( $post_id );
	return $cats ? $cats[0]->name : __( 'Artikel', 'hamagopest' );
}

/**
 * Escape heading yang mengizinkan <span class="accent"> dsb.
 */
function hamagopest_kses_heading( $text ) {
	$allowed = array(
		'span'   => array( 'class' => array() ),
		'br'     => array(),
		'em'     => array(),
		'strong' => array(),
		'b'      => array(),
		'i'      => array(),
	);
	return wp_kses( $text, $allowed );
}

/**
 * Pagination bergaya theme.
 */
function hamagopest_pagination() {
	the_posts_pagination(
		array(
			'mid_size'  => 2,
			'prev_text' => '&larr;',
			'next_text' => '&rarr;',
			'class'     => 'hmg-pagination',
		)
	);
}

/**
 * Fallback menu saat lokasi menu masih kosong.
 *
 * Prinsip: MENGHORMATI settingan user di Appearance → Menus.
 * - Tidak pernah mengubah nav_menu_locations secara diam-diam (dulu theme
 *   memaksa menempel menu pertama alfabetis — header jadi menampilkan
 *   menu yang salah / numpuk, tidak sesuai settingan user).
 * - Hanya menampilkan menu import demo bila slug-nya persis cocok dengan
 *   lokasi (menu-utama / menu-footer), sebatas render — tanpa side effect.
 */
function hamagopest_menu_fallback( $args = array() ) {

	$location = isset( $args['theme_location'] ) ? $args['theme_location'] : 'primary';

	/* Cari menu hasil import demo: primary → menu-utama, footer → menu-footer. */
	$slug = ( 'footer' === $location ) ? 'menu-footer' : 'menu-utama';
	$menu = wp_get_nav_menu_object( $slug );

	if ( $menu ) {
		wp_nav_menu(
			array(
				'menu'        => (int) $menu->term_id,
				'container'   => false,
				'menu_class'  => isset( $args['menu_class'] ) ? $args['menu_class'] : 'main-menu',
				'depth'       => isset( $args['depth'] ) ? $args['depth'] : 2,
				'fallback_cb' => false,
			)
		);
		return;
	}

	/* Belum ada menu sama sekali → daftar anchor homepage demo. */
	$items = array(
		'#tentang'   => __( 'Tentang', 'hamagopest' ),
		'#layanan'   => __( 'Layanan', 'hamagopest' ),
		'#proses'    => __( 'Cara Kerja', 'hamagopest' ),
		'#testimoni' => __( 'Testimoni', 'hamagopest' ),
		'#blog'      => __( 'Artikel', 'hamagopest' ),
		'#kontak'    => __( 'Kontak', 'hamagopest' ),
	);
	echo '<ul class="main-menu">';
	foreach ( $items as $href => $label ) {
		echo '<li><a href="' . esc_url( home_url( '/' . $href ) ) . '">' . esc_html( $label ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Konversi URL video (YouTube / Vimeo) ke format embed popup.
 * Mendukung: youtube.com/watch?v=, youtu.be/, /shorts/, /embed/,
 * vimeo.com/ID. URL lain dikembalikan apa adanya.
 *
 * @param string $url URL video dari Customizer.
 * @return string URL embed siap dipakai di iframe.
 */
function hamagopest_video_embed_url( $url ) {
	$url = trim( (string) $url );
	if ( '' === $url ) {
		return '';
	}

	$host = '';
	$path = '';
	$query = '';
	if ( preg_match( '#^https?://([^/]+)([^?]*)(?:\?(.*))?$#i', $url, $m ) ) {
		$host  = strtolower( $m[1] );
		$path  = $m[2];
		$query = isset( $m[3] ) ? $m[3] : '';
	}

	/* YouTube */
	if ( preg_match( '/(^|\.)(youtube\.com|youtube-nocookie\.com|youtu\.be)$/i', $host ) ) {
		$vid = '';
		if ( 'youtu.be' === $host ) {
			$vid = ltrim( $path, '/' );
		} elseif ( preg_match( '#/shorts/([A-Za-z0-9_-]{6,})#', $path, $mm ) ) {
			$vid = $mm[1];
		} elseif ( preg_match( '#/embed/([A-Za-z0-9_-]{6,})#', $path, $mm ) ) {
			$vid = $mm[1];
		} elseif ( preg_match( '/(?:^|&)v=([A-Za-z0-9_-]{6,})/', $query, $mm ) ) {
			$vid = $mm[1];
		}
		if ( $vid ) {
			return 'https://www.youtube-nocookie.com/embed/' . $vid . '?autoplay=1&rel=0';
		}
		return $url;
	}

	/* Vimeo */
	if ( preg_match( '/(^|\.)vimeo\.com$/i', $host ) && preg_match( '#/(\d+)#', $path, $mm ) ) {
		return 'https://player.vimeo.com/video/' . $mm[1] . '?autoplay=1';
	}

	return $url;
}
