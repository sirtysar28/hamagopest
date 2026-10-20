<?php
/**
 * Header theme: topbar + sticky header + mobile drawer.
 *
 * @package hamagopest
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Lompat ke konten', 'hamagopest' ); ?></a>

<?php
/* Jika Elementor Pro Theme Builder punya template header, pakai itu. */
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) :
?>

	<?php if ( get_theme_mod( 'hamagopest_topbar_show', true ) ) : ?>
	<div class="topbar">
		<div class="wrap topbar-flex">
			<div class="tb-left">
				<a href="<?php echo esc_url( hamagopest_tel_link() ); ?>">
					<svg class="hmg-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M22 16.9v3a2 2 0 01-2.2 2 19.8 19.8 0 01-8.6-3 19.5 19.5 0 01-6-6A19.8 19.8 0 012.1 4.2 2 2 0 014.1 2h3a2 2 0 012 1.7c.1.9.4 1.9.7 2.8a2 2 0 01-.5 2.1L8 9.9a16 16 0 006 6l1.3-1.3a2 2 0 012.1-.5c.9.3 1.9.6 2.8.7a2 2 0 011.8 2.1z"/></svg>
					<?php echo esc_html( hamagopest_get_phone() ); ?>
				</a>
				<span class="tb-address">
					<svg class="hmg-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0116 0z"/><circle cx="12" cy="10" r="3"/></svg>
					<?php echo esc_html( hamagopest_get_address() ); ?>
				</span>
			</div>
			<div class="tb-right">
				<a href="<?php echo esc_url( hamagopest_wa_link() ); ?>" target="_blank" rel="noopener"><?php echo esc_html( get_theme_mod( 'hamagopest_topbar_cta', __( 'Inspeksi Gratis Hari Ini', 'hamagopest' ) ) ); ?></a>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<header class="site-header" id="site-header">
		<div class="wrap header-flex">
			<div class="site-branding">
				<?php hamagopest_site_logo(); ?>
			</div>

			<nav class="main-nav" aria-label="<?php esc_attr_e( 'Menu utama', 'hamagopest' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'main-menu',
						'fallback_cb'    => 'hamagopest_menu_fallback',
						'depth'          => 2,
					)
				);
				?>
			</nav>

			<div class="header-cta">
				<a href="<?php echo esc_url( hamagopest_wa_link() ); ?>" target="_blank" rel="noopener" class="btn btn-gold"><?php esc_html_e( 'Booking Sekarang', 'hamagopest' ); ?></a>
			</div>

			<button class="burger" id="hmgBurger" aria-label="<?php esc_attr_e( 'Buka menu', 'hamagopest' ); ?>" aria-expanded="false" aria-controls="hmgMobileNav">
				<span></span><span></span><span></span>
			</button>
		</div>
	</header>

	<div class="overlay" id="hmgOverlay" hidden></div>

	<nav class="mobile-nav" id="hmgMobileNav" aria-label="<?php esc_attr_e( 'Menu mobile', 'hamagopest' ); ?>">
		<button class="close-btn" id="hmgCloseNav" aria-label="<?php esc_attr_e( 'Tutup menu', 'hamagopest' ); ?>">&times;</button>
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'mobile-menu',
				'fallback_cb'    => 'hamagopest_menu_fallback',
				'depth'          => 2,
			)
		);
		?>
		<a href="<?php echo esc_url( hamagopest_wa_link() ); ?>" target="_blank" rel="noopener" class="btn btn-gold mobile-cta"><?php esc_html_e( 'Booking Sekarang', 'hamagopest' ); ?></a>
	</nav>

<?php endif; ?>

<main id="content" class="site-main">
