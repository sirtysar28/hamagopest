<?php
/**
 * Hamago Pest Solutions — Theme functions & definitions.
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'HAMAGOPEST_VERSION', '1.9.0' );
define( 'HAMAGOPEST_DIR', get_template_directory() );
define( 'HAMAGOPEST_URI', get_template_directory_uri() );

/* -------------------------------------------------------------------------
 * Theme setup
 * ---------------------------------------------------------------------- */
function hamagopest_setup() {

	load_theme_textdomain( 'hamagopest', HAMAGOPEST_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'hamagopest-card', 640, 420, true ); // blog card thumbnail

	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);

	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );

	/* Logo bisa diganti via Customizer → Situs Identity → Logo */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Menu Utama (Header)', 'hamagopest' ),
			'footer'  => __( 'Menu Footer', 'hamagopest' ),
		)
	);
}
add_action( 'after_setup_theme', 'hamagopest_setup' );

function hamagopest_content_width() {
	$GLOBALS['content_width'] = 1180;
}
add_action( 'after_setup_theme', 'hamagopest_content_width', 0 );

/* -------------------------------------------------------------------------
 * Widget areas
 * ---------------------------------------------------------------------- */
function hamagopest_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar Blog', 'hamagopest' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Widget tambahan untuk halaman blog.', 'hamagopest' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'hamagopest_widgets_init' );

/* -------------------------------------------------------------------------
 * Scripts & styles — Sora (heading) + Inter (body)
 * ---------------------------------------------------------------------- */
function hamagopest_scripts() {

	wp_enqueue_style(
		'hamagopest-fonts',
		'https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'hamagopest-main', HAMAGOPEST_URI . '/assets/css/main.css', array(), HAMAGOPEST_VERSION );

	wp_enqueue_script( 'hamagopest-main', HAMAGOPEST_URI . '/assets/js/main.js', array(), HAMAGOPEST_VERSION, true );

	/* Kompatibilitas konten lebar (alignwide/alignfull) di halaman Elementor. */
	if ( function_exists( 'hamagopest_is_elementor_page' ) && hamagopest_is_elementor_page() ) {
		wp_enqueue_style( 'hamagopest-elementor', HAMAGOPEST_URI . '/assets/css/elementor.css', array( 'hamagopest-main' ), HAMAGOPEST_VERSION );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hamagopest_scripts' );

/**
 * Preconnect untuk Google Fonts.
 */
function hamagopest_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array( 'href' => 'https://fonts.googleapis.com' );
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'hamagopest_resource_hints', 10, 2 );

/* -------------------------------------------------------------------------
 * Body classes helper
 * ---------------------------------------------------------------------- */
function hamagopest_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hmg-not-singular';
	}
	return $classes;
}
add_filter( 'body_class', 'hamagopest_body_classes' );

/* -------------------------------------------------------------------------
 * Blog — 6 artikel per halaman (grid 3 kolom) + pagination otomatis.
 * Berlaku bila halaman Blog dijadikan "Posts page" (Settings → Reading).
 * Halaman dengan slug "blog" yang biasa memakai template page-blog.php
 * sudah membawa query sendiri (6 post + pagination).
 * ---------------------------------------------------------------------- */
function hamagopest_blog_posts_per_page( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_home() ) {
		$query->set( 'posts_per_page', (int) apply_filters( 'hamagopest_blog_posts_per_page', 6 ) );
	}
}
add_action( 'pre_get_posts', 'hamagopest_blog_posts_per_page' );

/* -------------------------------------------------------------------------
 * Includes
 * ---------------------------------------------------------------------- */
require HAMAGOPEST_DIR . '/inc/template-tags.php';
require HAMAGOPEST_DIR . '/inc/elementor/icons.php'; /* icon library — dipakai Customizer & homepage, tanpa perlu Elementor. */
require HAMAGOPEST_DIR . '/inc/customizer-controls.php'; /* control repeater klien (logo slider). */
require HAMAGOPEST_DIR . '/inc/customizer.php';
require HAMAGOPEST_DIR . '/inc/admin-homepage.php';
require HAMAGOPEST_DIR . '/inc/admin-pages.php';
require HAMAGOPEST_DIR . '/inc/elementor/elementor.php';
