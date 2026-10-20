<?php
/**
 * Library icon SVG inline — stroke currentColor, aman diwarnai via CSS.
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'hamagopest_icons' ) ) {
	/**
	 * Daftar icon: key => path SVG dalam viewBox 0 0 24 24.
	 */
	function hamagopest_icons() {
		return array(
			'shield-check' => '<path d="M12 2l8 4v6c0 5-3.4 8.4-8 10-4.6-1.6-8-5-8-10V6l8-4z"/><path d="M9 12l2 2 4-4"/>',
			'shield'       => '<path d="M12 2l8 4v6c0 5-3.4 8.4-8 10-4.6-1.6-8-5-8-10V6l8-4z"/>',
			'bug'          => '<circle cx="12" cy="9" r="3"/><path d="M12 12v8M8 15l-3-2M16 15l3-2M8 18l-3 2M16 18l3 2M9.5 6.5L8 4M14.5 6.5L16 4"/>',
			'termite'      => '<ellipse cx="12" cy="13" rx="4" ry="6"/><path d="M8 8l-3-3M16 8l3-3M8 18l-3 3M16 18l3 3"/>',
			'cockroach'    => '<ellipse cx="12" cy="13" rx="5" ry="6"/><path d="M7 10L4 8M17 10l3-2M7 16l-3 2M17 16l3 2M12 7V4"/>',
			'ant'          => '<circle cx="7" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="17" cy="12" r="2"/><path d="M17 12h4M7 12H3M12 12V6M9 6l3-3 3 3"/>',
			'mosquito'     => '<path d="M4 15c1-6 4-9 8-9s7 3 8 9"/><circle cx="18" cy="9" r="1.4"/><path d="M12 6V3"/>',
			'rat'          => '<path d="M5 12c0-3 3-6 7-6s7 3 7 6v3a3 3 0 01-3 3H8a3 3 0 01-3-3v-3z"/><path d="M19 13h2M9 18v2M15 18v2M9.5 11h.01M14.5 11h.01"/>',
			'fumigation'   => '<path d="M3 21h18"/><path d="M6 21l6-15 6 15"/><path d="M9.4 21l2.6-6.5 2.6 6.5"/><path d="M9 3.4c.9.7.9 1.5 0 2.2M12.5 3.4c.9.7.9 1.5 0 2.2M16 3.4c.9.7.9 1.5 0 2.2"/>',
			'snake'        => '<path d="M17 5h-6a3 3 0 100 6h2a4 4 0 010 8H7"/><path d="M17 5l2.4-1.4M17 5l2.4 1"/><path d="M16 6.5h.01"/>',
			'scent'        => '<circle cx="12" cy="12" r="1.7"/><path d="M12 10.3C10.4 8.7 10.4 6.4 12 4.8c1.6 1.6 1.6 3.9 0 5.5z"/><path d="M13.7 12c1.6-1.6 3.9-1.6 5.5 0-1.6 1.6-3.9 1.6-5.5 0z"/><path d="M12 13.7c1.6 1.6 1.6 3.9 0 5.5-1.6-1.6-1.6-3.9 0-5.5z"/><path d="M10.3 12c-1.6 1.6-3.9 1.6-5.5 0 1.6-1.6 3.9-1.6 5.5 0z"/>',
			'spider'       => '<circle cx="12" cy="12" r="4"/><path d="M8 9L4 6M16 9l4-3M8 15l-4 3M16 15l4 3M12 8V4M12 16v4"/>',
			'droplet'      => '<path d="M12 3s6 6.5 6 11a6 6 0 01-12 0c0-4.5 6-11 6-11z"/>',
			'spray'        => '<rect x="9" y="9" width="6" height="11" rx="1.5"/><path d="M12 9V6h5M15 3h4M19 6h2M19 9h2"/>',
			'broom'        => '<path d="M9 3l2.5 8.5"/><path d="M11.5 11.5L20 3"/><path d="M9.5 11l4 1.5"/><path d="M13 14c1.5 3.5-1 6-3.5 7C7 18.5 6 16 6.5 13.5L13 14z"/><path d="M6.5 13.5L4 12.5"/><path d="M7 16l-3 .5M8 18.5L6 21"/>',
			'search'       => '<circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/>',
			'target'       => '<circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="3.5"/>',
			'user'         => '<path d="M4 21v-6a4 4 0 014-4h8a4 4 0 014 4v6"/><circle cx="12" cy="7" r="4"/>',
			'users'        => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20v-4a4 4 0 014-4h5a4 4 0 014 4v4M16 4.5a3.5 3.5 0 010 7M18 20v-4a4 4 0 00-2.5-3.7"/>',
			'bundle'       => '<path d="M21 8l-9-5-9 5v8l9 5 9-5V8z"/><path d="M3 8l9 5 9-5M12 13v8"/>',
			'price'        => '<path d="M20.59 13.41L11 3.83A2 2 0 009.59 3.24H4a1 1 0 00-1 1v5.59a2 2 0 00.59 1.41l9.58 9.59a2 2 0 002.83 0l4.59-4.59a2 2 0 000-2.83z"/><path d="M7.5 7.5h.01"/>',
			'clock'        => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
			'star'         => '<path d="M12 3l2.7 5.6 6.1.8-4.5 4.3 1.1 6-5.4-3-5.4 3 1.1-6L3.2 9.4l6.1-.8L12 3z"/>',
			'check'        => '<path d="M5 13l4 4L19 7"/>',
			'phone'        => '<path d="M22 16.9v3a2 2 0 01-2.2 2 19.8 19.8 0 01-8.6-3 19.5 19.5 0 01-6-6A19.8 19.8 0 012.1 4.2 2 2 0 014.1 2h3a2 2 0 012 1.7c.1.9.4 1.9.7 2.8a2 2 0 01-.5 2.1L8 9.9a16 16 0 006 6l1.3-1.3a2 2 0 012.1-.5c.9.3 1.9.6 2.8.7a2 2 0 011.8 2.1z"/>',
			'mail'         => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 7 10-7"/>',
			'pin'          => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0116 0z"/><circle cx="12" cy="10" r="3"/>',
			'wa'           => '<path d="M12 2C6.5 2 2 6.5 2 12c0 1.8.5 3.5 1.3 5L2 22l5.2-1.4c1.4.8 3.1 1.2 4.8 1.2 5.5 0 10-4.5 10-10S17.5 2 12 2zm5.9 14.2c-.2.7-1.4 1.3-2 1.4-.5.1-1.1.2-3.6-.8-3-1.2-4.9-4.2-5.1-4.4-.1-.2-1.2-1.6-1.2-3 0-1.4.7-2.1 1-2.4.3-.3.6-.3.8-.3h.6c.2 0 .5 0 .7.6.3.7.9 2.2 1 2.4.1.2.1.4 0 .6-.1.2-.2.4-.4.6-.2.2-.4.5-.6.6-.2.2-.4.4-.2.8.2.4 1 1.6 2.1 2.6 1.4 1.3 2.6 1.7 3 1.9.4.2.6.1.9-.1.3-.3.9-1.1 1.2-1.5.3-.4.5-.3.9-.2.4.2 2.3 1.1 2.7 1.3.4.2.6.3.7.4.1.2.1.9-.1 1.5z" fill="currentColor" stroke="none"/>',
			'play'         => '<path d="M8 5v14l11-7z" fill="currentColor" stroke="none"/>',
			'arrow-right'  => '<path d="M4 12h16M13 5l7 7-7 7"/>',
			'leaf'         => '<path d="M20 4C10 4 4 10 4 20c10 0 16-6 16-16z"/><path d="M4 20C8 14 12 10 18 6"/>',
			'home'         => '<path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/>',
			'building'     => '<rect x="5" y="3" width="14" height="18" rx="1"/><path d="M9 7h2M13 7h2M9 11h2M13 11h2M9 15h2M13 15h2M10 21v-3h4v3"/>',
			'doc'          => '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/><path d="M14 2v6h6M9 13h6M9 17h6"/>',
			'chart'        => '<path d="M3 3v18h18"/><path d="M7 15v3M12 10v8M17 6v12"/>',
			'heart'        => '<path d="M20.8 4.6a5.5 5.5 0 00-7.8 0L12 5.6l-1-1a5.5 5.5 0 00-7.8 7.8l1 1L12 21.2l7.8-7.8 1-1a5.5 5.5 0 000-7.8z"/>',
		);
	}
}

if ( ! function_exists( 'hamagopest_icon_options' ) ) {
	/**
	 * Options untuk control select icon di widget Elementor.
	 */
	function hamagopest_icon_options() {
		$options = array( '' => '— Pilih Icon —' );
		foreach ( array_keys( hamagopest_icons() ) as $key ) {
			$options[ $key ] = ucfirst( str_replace( '-', ' ', $key ) );
		}
		return $options;
	}
}

if ( ! function_exists( 'hamagopest_icon' ) ) {
	/**
	 * Output icon SVG inline.
	 */
	function hamagopest_icon( $key, $class = '' ) {
		$icons = hamagopest_icons();
		if ( ! isset( $icons[ $key ] ) ) {
			$key = 'shield-check';
		}
		printf(
			'<svg class="hmg-ico %1$s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">%2$s</svg>',
			esc_attr( $class ),
			$icons[ $key ] // phpcs:ignore WordPress.Security.EscapeOutput -- statis & aman dari library internal.
		);
	}
}
