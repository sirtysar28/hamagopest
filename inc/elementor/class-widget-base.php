<?php
/**
 * Base class widget Elementor Hamago — controls & helpers bersama.
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;

abstract class Hamagopest_Widget_Base extends \Elementor\Widget_Base {

	/**
	 * Semua widget masuk kategori "Hamago Elements".
	 */
	public function get_categories() {
		return array( 'hamago-elements' );
	}

	/**
	 * CSS theme sudah dimuat global via functions.php + hook preview Elementor,
	 * jadi tidak perlu deklarasi dependency (aman dari notice handle tak terdaftar).
	 */
	public function get_style_depends() {
		return array();
	}

	/**
	 * Control umum: eyebrow, heading, sub-heading.
	 */
	protected function add_heading_controls( $defaults = array(), $prefix = '' ) {
		$d = wp_parse_args(
			$defaults,
			array(
				'eyebrow' => __( 'Kenapa Hamago', 'hamagopest' ),
				'heading' => __( 'Judul Section', 'hamagopest' ),
				'sub'     => '',
			)
		);

		$this->add_control(
			$prefix . 'eyebrow',
			array(
				'label'   => __( 'Eyebrow (label kecil)', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => $d['eyebrow'],
			)
		);

		$this->add_control(
			$prefix . 'heading',
			array(
				'label'       => __( 'Judul', 'hamagopest' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'default'     => $d['heading'],
				/* translators: %s = kelas HTML */
				'description' => __( 'Bisa pakai <span class="accent">kata</span> untuk warna emas.', 'hamagopest' ),
			)
		);

		$this->add_control(
			$prefix . 'sub',
			array(
				'label'   => __( 'Deskripsi pendek', 'hamagopest' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => $d['sub'],
			)
		);
	}

	/**
	 * Render heading block umum.
	 */
	protected function render_heading_block( $settings, $prefix = '', $class = 'section-head' ) {
		$eyebrow = isset( $settings[ $prefix . 'eyebrow' ] ) ? $settings[ $prefix . 'eyebrow' ] : '';
		$heading = isset( $settings[ $prefix . 'heading' ] ) ? $settings[ $prefix . 'heading' ] : '';
		$sub     = isset( $settings[ $prefix . 'sub' ] ) ? $settings[ $prefix . 'sub' ] : '';

		echo '<div class="' . esc_attr( $class ) . ' usp-head">';
		if ( $eyebrow ) {
			echo '<div class="eyebrow">' . esc_html( $eyebrow ) . '</div>';
		}
		if ( $heading ) {
			echo '<h2 data-reveal="fade-up" data-delay="0">' . hamagopest_kses_heading( $heading ) . '</h2>'; // phpcs:ignore WordPress.Security.EscapeOutput
		}
		if ( $sub ) {
			echo '<p data-reveal="fade-up" data-delay="80">' . esc_html( $sub ) . '</p>';
		}
		echo '</div>';
	}

	/**
	 * Control background section: default / alt / pine / custom.
	 */
	protected function add_bg_controls( $default = 'default' ) {
		$this->add_control(
			'section_bg',
			array(
				'label'   => __( 'Background Section', 'hamagopest' ),
				'type'    => Controls_Manager::SELECT,
				'default' => $default,
				'options' => array(
					'default' => __( 'Default (putih kebiruan)', 'hamagopest' ),
					'alt'     => __( 'Alt (biru muda)', 'hamagopest' ),
					'gold'    => __( 'Gold (emas)', 'hamagopest' ),
					'pine'    => __( 'Navy Gelap (dominan)', 'hamagopest' ),
					'none'    => __( 'Polos', 'hamagopest' ),
				),
			)
		);
	}

	/**
	 * Class background section.
	 */
	protected function bg_class( $settings ) {
		$map = array(
			'default' => 'hmg-section',
			'alt'     => 'hmg-section hmg-section--alt',
			'gold'    => 'hmg-section hmg-section--gold',
			'pine'    => 'hmg-section hmg-section--pine',
			'none'    => 'hmg-section hmg-section--plain',
		);
		$bg = isset( $settings['section_bg'] ) ? $settings['section_bg'] : 'default';
		return isset( $map[ $bg ] ) ? $map[ $bg ] : 'hmg-section';
	}

	/**
	 * Kontrol parallax section.
	 */
	protected function add_parallax_toggle() {
		$this->add_control(
			'enable_parallax',
			array(
				'label'        => __( 'Animasi Parallax saat Scroll', 'hamagopest' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'separator'    => 'before',
			)
		);
	}

	protected function parallax_attrs( $settings, $speed = 0.12 ) {
		$on = ( ! isset( $settings['enable_parallax'] ) || 'yes' === $settings['enable_parallax'] );
		return $on ? ' data-hmg-parallax="' . esc_attr( $speed ) . '"' : '';
	}
}
