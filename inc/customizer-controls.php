<?php
/**
 * Customizer control: daftar klien TAK TERBATAS.
 * Setiap item: Nama + Logo (upload) + Link URL.
 * Disimpan sebagai JSON string, dirender jadi slider logo loop di homepage.
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return; /* WP tanpa Customizer — kontrol repeater tidak dibutuhkan. */
}

/**
 * Sanitize JSON daftar klien.
 */
function hamagopest_sanitize_clients_json( $json ) {
	$raw = json_decode( (string) $json, true );
	if ( ! is_array( $raw ) ) {
		return '';
	}
	$out = array();
	foreach ( $raw as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$name = isset( $item['name'] ) ? sanitize_text_field( (string) $item['name'] ) : '';
		$logo = isset( $item['logo'] ) ? esc_url_raw( (string) $item['logo'] ) : '';
		$url  = isset( $item['url'] ) ? esc_url_raw( (string) $item['url'] ) : '';
		if ( '' === $name && '' === $logo ) {
			continue; /* item kosong dibuang */
		}
		$out[] = array(
			'name' => $name,
			'logo' => $logo,
			'url'  => $url,
		);
	}
	return wp_json_encode( $out );
}

/**
 * Ambil daftar klien: repeater (baru) → fallback field lama → default demo.
 */
function hamagopest_clients_items() {
	$json = get_theme_mod( 'hamagopest_clients_items', '' );
	$items = json_decode( (string) $json, true );
	if ( is_array( $items ) ) {
		$clean = array();
		foreach ( $items as $item ) {
			$name = isset( $item['name'] ) ? (string) $item['name'] : '';
			$logo = isset( $item['logo'] ) ? (string) $item['logo'] : '';
			$url  = isset( $item['url'] ) ? (string) $item['url'] : '';
			if ( '' === $name && '' === $logo ) {
				continue;
			}
			$clean[] = array(
				'name' => $name,
				'logo' => $logo,
				'url'  => $url,
			);
		}
		return $clean;
	}

	/* Fallback field nama lama (client1_name dst) bila ada yang terisi. */
	$legacy = array();
	for ( $i = 1; $i <= 6; $i++ ) {
		$name = get_theme_mod( 'hamagopest_client' . $i . '_name', '' );
		if ( '' !== (string) $name ) {
			$legacy[] = array(
				'name' => (string) $name,
				'logo' => '',
				'url'  => '',
			);
		}
	}
	if ( $legacy ) {
		return $legacy;
	}

	/* Default demo. */
	$defaults = hamagopest_home_defaults();
	return json_decode( $defaults['clients_items'], true );
}

/**
 * Control repeater klien di Customizer.
 */
class Hamagopest_Clients_Control extends WP_Customize_Control {

	/**
	 * Control type.
	 *
	 * @var string
	 */
	public $type = 'hamagopest_clients';

	/**
	 * Script & style admin.
	 */
	public function enqueue() {
		wp_enqueue_media();
		wp_enqueue_script(
			'hamagopest-clients-repeater',
			get_template_directory_uri() . '/assets/js/customizer-clients.js',
			array( 'jquery', 'customize-base' ),
			HAMAGOPEST_VERSION,
			true
		);
		wp_enqueue_style(
			'hamagopest-clients-repeater',
			get_template_directory_uri() . '/assets/css/customizer-clients.css',
			array(),
			HAMAGOPEST_VERSION
		);
	}

	/**
	 * Render konten control.
	 */
	public function render_content() {
		$id    = 'hmg-clients-' . esc_attr( $this->id );
		$value = (string) $this->value();
		?>
		<label>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>
		</label>

		<div class="hmg-cr" id="<?php echo esc_attr( $id ); ?>">
			<input
				type="hidden"
				class="hmg-cr-value"
				data-customize-setting-link="<?php echo esc_attr( $this->id ); ?>"
				value="<?php echo esc_attr( $value ); ?>"
			/>
			<div class="hmg-cr-rows"></div>
			<button type="button" class="button button-secondary hmg-cr-add"><?php esc_html_e( '+ Tambah Klien', 'hamagopest' ); ?></button>
		</div>
		<?php
	}
}

/* =========================================================================
 * REPEATER GENERIK (Layanan & Testimoni) — tak terbatas.
 * Dipakai: Homepage — Layanan (gambar + icon + judul + deskripsi + metode +
 * link) dan Homepage — Testimoni (isi + nama + jabatan + foto).
 * Disimpan sebagai JSON string. Fallback: field lama (svc1_*, testi1_*).
 * ======================================================================= */

/**
 * Sanitize JSON daftar layanan.
 */
function hamagopest_sanitize_services_json( $json ) {
	$raw = json_decode( (string) $json, true );
	if ( ! is_array( $raw ) ) {
		return '';
	}
	$valid_icons = function_exists( 'hamagopest_icons' ) ? array_keys( hamagopest_icons() ) : array();
	$out         = array();
	foreach ( $raw as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$title = isset( $item['title'] ) ? sanitize_text_field( (string) $item['title'] ) : '';
		$icon  = isset( $item['icon'] ) && in_array( $item['icon'], $valid_icons, true ) ? $item['icon'] : 'shield';
		if ( '' === $title ) {
			continue; /* kartu tanpa judul disembunyikan */
		}
		$out[] = array(
			'image'   => isset( $item['image'] ) ? esc_url_raw( (string) $item['image'] ) : '',
			'icon'    => $icon,
			'title'   => $title,
			'desc'    => isset( $item['desc'] ) ? sanitize_textarea_field( (string) $item['desc'] ) : '',
			'methods' => isset( $item['methods'] ) ? sanitize_textarea_field( (string) $item['methods'] ) : '',
			'link'    => isset( $item['link'] ) ? esc_url_raw( (string) $item['link'] ) : '',
		);
	}
	return wp_json_encode( $out );
}

/**
 * Sanitize JSON daftar testimoni.
 */
function hamagopest_sanitize_testi_json( $json ) {
	$raw = json_decode( (string) $json, true );
	if ( ! is_array( $raw ) ) {
		return '';
	}
	$out = array();
	foreach ( $raw as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$quote = isset( $item['quote'] ) ? sanitize_textarea_field( (string) $item['quote'] ) : '';
		if ( '' === $quote ) {
			continue;
		}
		$out[] = array(
			'quote'  => $quote,
			'name'   => isset( $item['name'] ) ? sanitize_text_field( (string) $item['name'] ) : '',
			'role'   => isset( $item['role'] ) ? sanitize_text_field( (string) $item['role'] ) : '',
			'avatar' => isset( $item['avatar'] ) ? esc_url_raw( (string) $item['avatar'] ) : '',
		);
	}
	return wp_json_encode( $out );
}

/**
 * Ambil daftar layanan: repeater (baru) → field lama (svc1_*) → default demo.
 */
function hamagopest_services_items() {
	$json  = get_theme_mod( 'hamagopest_services_items', '' );
	$items = json_decode( (string) $json, true );
	if ( is_array( $items ) ) {
		$clean = array();
		foreach ( $items as $item ) {
			if ( empty( $item['title'] ) ) {
				continue;
			}
			$clean[] = array(
				'image'   => isset( $item['image'] ) ? (string) $item['image'] : '',
				'icon'    => isset( $item['icon'] ) ? (string) $item['icon'] : 'shield',
				'title'   => (string) $item['title'],
				'desc'    => isset( $item['desc'] ) ? (string) $item['desc'] : '',
				'methods' => isset( $item['methods'] ) ? (string) $item['methods'] : '',
				'link'    => isset( $item['link'] ) ? (string) $item['link'] : '',
			);
		}
		return $clean;
	}

	/* Fallback field lama — baca sampai 20 slot agar data manual ikut. */
	$legacy = array();
	for ( $i = 1; $i <= 20; $i++ ) {
		$title = get_theme_mod( 'hamagopest_svc' . $i . '_title', '' );
		if ( '' === (string) $title ) {
			continue;
		}
		$legacy[] = array(
			'image'   => '',
			'icon'    => (string) get_theme_mod( 'hamagopest_svc' . $i . '_icon', 'shield' ),
			'title'   => (string) $title,
			'desc'    => (string) get_theme_mod( 'hamagopest_svc' . $i . '_desc', '' ),
			'methods' => (string) get_theme_mod( 'hamagopest_svc' . $i . '_methods', '' ),
			'link'    => '',
		);
	}
	if ( $legacy ) {
		return $legacy;
	}

	/* Default demo. */
	$defaults = hamagopest_home_defaults();
	$decoded  = json_decode( $defaults['services_items'], true );
	return is_array( $decoded ) ? $decoded : array();
}

/**
 * Ambil daftar testimoni: repeater (baru) → field lama (testi1_*) → default demo.
 */
function hamagopest_testi_items() {
	$json  = get_theme_mod( 'hamagopest_testi_items', '' );
	$items = json_decode( (string) $json, true );
	if ( is_array( $items ) ) {
		$clean = array();
		foreach ( $items as $item ) {
			if ( empty( $item['quote'] ) ) {
				continue;
			}
			$clean[] = array(
				'quote'  => (string) $item['quote'],
				'name'   => isset( $item['name'] ) ? (string) $item['name'] : '',
				'role'   => isset( $item['role'] ) ? (string) $item['role'] : '',
				'avatar' => isset( $item['avatar'] ) ? (string) $item['avatar'] : '',
			);
		}
		return $clean;
	}

	/* Fallback field lama. */
	$legacy = array();
	for ( $i = 1; $i <= 20; $i++ ) {
		$quote = get_theme_mod( 'hamagopest_testi' . $i . '_quote', '' );
		if ( '' === (string) $quote ) {
			continue;
		}
		$legacy[] = array(
			'quote'  => (string) $quote,
			'name'   => (string) get_theme_mod( 'hamagopest_testi' . $i . '_name', '' ),
			'role'   => (string) get_theme_mod( 'hamagopest_testi' . $i . '_role', '' ),
			'avatar' => '',
		);
	}
	if ( $legacy ) {
		return $legacy;
	}

	/* Default demo. */
	$defaults = hamagopest_home_defaults();
	$decoded  = json_decode( $defaults['testi_items'], true );
	return is_array( $decoded ) ? $decoded : array();
}

/**
 * Control repeater generik di Customizer.
 * Konfigurasi field via properti $fields: key => array(label, type, placeholder, options).
 * Tipe yang didukung: text, textarea, url, select, image.
 */
class Hamagopest_Repeater_Control extends WP_Customize_Control {

	/**
	 * Control type.
	 *
	 * @var string
	 */
	public $type = 'hamagopest_repeater';

	/**
	 * Konfigurasi field per baris.
	 *
	 * @var array
	 */
	public $fields = array();

	/**
	 * Label tombol tambah.
	 *
	 * @var string
	 */
	public $add_label = '';

	/**
	 * Script & style admin.
	 */
	public function enqueue() {
		wp_enqueue_media();
		wp_enqueue_script(
			'hamagopest-repeater',
			get_template_directory_uri() . '/assets/js/customizer-repeater.js',
			array( 'jquery', 'customize-base' ),
			HAMAGOPEST_VERSION,
			true
		);
		wp_enqueue_style(
			'hamagopest-repeater',
			get_template_directory_uri() . '/assets/css/customizer-repeater.css',
			array(),
			HAMAGOPEST_VERSION
		);
	}

	/**
	 * Render konten control.
	 */
	public function render_content() {
		$id    = 'hmg-rp-' . esc_attr( $this->id );
		$value = (string) $this->value();
		?>
		<label>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>
		</label>

		<div class="hmg-rp" id="<?php echo esc_attr( $id ); ?>"
			data-fields="<?php echo esc_attr( wp_json_encode( array_values( $this->fields ) ) ); ?>"
			data-keys="<?php echo esc_attr( wp_json_encode( array_keys( $this->fields ) ) ); ?>"
			data-add-label="<?php echo esc_attr( $this->add_label ? $this->add_label : __( '+ Tambah Item', 'hamagopest' ) ); ?>">
			<input
				type="hidden"
				class="hmg-rp-value"
				data-customize-setting-link="<?php echo esc_attr( $this->id ); ?>"
				value="<?php echo esc_attr( $value ); ?>"
			/>
			<div class="hmg-rp-rows"></div>
			<button type="button" class="button button-secondary hmg-rp-add"><?php echo esc_html( $this->add_label ? $this->add_label : __( '+ Tambah Item', 'hamagopest' ) ); ?></button>
		</div>
		<?php
	}
}
