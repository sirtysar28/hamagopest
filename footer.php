<?php
/**
 * Footer theme + tombol WhatsApp melayang.
 *
 * @package hamagopest
 */
?>
</main><!-- #content -->

<?php
/* Jika Elementor Pro Theme Builder punya template footer, pakai itu. */
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) :
?>

<footer class="site-footer">
	<div class="wrap">
		<div class="footer-grid">
			<div class="footer-col footer-about">
				<?php hamagopest_site_logo( true ); ?>
				<p><?php echo esc_html( get_theme_mod( 'hamagopest_footer_about', __( 'Solusi profesional, efektif, dan aman untuk membasmi hama hingga ke sarangnya.', 'hamagopest' ) ) ); ?></p>
				<div class="social-row">
					<?php
					$socials = array(
						'facebook'  => array( get_theme_mod( 'hamagopest_social_facebook' ), 'Facebook', '<path d="M15 3h-2.5A3.5 3.5 0 009 6.5V9H6v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3V3z"/>' ),
						'instagram' => array( get_theme_mod( 'hamagopest_social_instagram' ), 'Instagram', '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><path d="M17.5 6.5h.01"/>' ),
						'tiktok'    => array( get_theme_mod( 'hamagopest_social_tiktok' ), 'TikTok', '<path d="M15 3c.5 3 2 4.5 5 5v3c-1.8 0-3.5-.6-5-1.6V15a6 6 0 11-6-6c.35 0 .7.03 1 .09V12a3 3 0 103 3V3z"/>' ),
						'youtube'   => array( get_theme_mod( 'hamagopest_social_youtube' ), 'YouTube', '<path d="M22 8.2s-.2-1.6-.8-2.3c-.8-.8-1.7-.8-2.1-.9C16.2 4.8 12 4.8 12 4.8h0s-4.2 0-7.1.2c-.4.05-1.3.05-2.1.9C2.2 6.6 2 8.2 2 8.2S1.8 10 1.8 11.9v1.7C1.8 15.4 2 17.2 2 17.2s.2 1.6.8 2.3c.8.8 1.8.8 2.3.9 1.7.2 6.9.2 6.9.2s4.2 0 7.1-.2c.4-.1 1.3-.1 2.1-.9.6-.7.8-2.3.8-2.3s.2-1.8.2-3.6v-1.7C22.2 10 22 8.2 22 8.2zM9.9 15.6V9.7l5.4 3L9.9 15.6z" fill="currentColor" stroke="none"/>' ),
						'x'         => array( get_theme_mod( 'hamagopest_social_x' ), 'X / Twitter', '<path d="M4 4l7.5 9.5L4.5 20h2.6l5.4-5 4 5H20l-7.8-9.9L19.4 4h-2.6l-4.8 4.5L8.4 4H4z" fill="currentColor" stroke="none"/>' ),
					);
					foreach ( $socials as $key => $data ) :
						list( $url, $label, $path ) = $data;
						if ( ! $url ) {
							continue;
						}
						?>
						<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $label ); ?>">
							<svg class="hmg-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><?php echo $path; // phpcs:ignore WordPress.Security.EscapeOutput ?></svg>
						</a>
						<?php
					endforeach;
					?>
				</div>
			</div>

			<div class="footer-col">
				<h4><?php esc_html_e( 'Menu', 'hamagopest' ); ?></h4>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => 'footer-menu',
						'fallback_cb'    => 'hamagopest_menu_fallback',
						'depth'          => 1,
					)
				);
				?>
			</div>

			<div class="footer-col">
				<h4><?php esc_html_e( 'Layanan', 'hamagopest' ); ?></h4>
				<ul class="footer-menu">
					<li><a href="<?php echo esc_url( home_url( '/#layanan' ) ); ?>"><?php esc_html_e( 'Rodent Control', 'hamagopest' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#layanan' ) ); ?>"><?php esc_html_e( 'Pest Control', 'hamagopest' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#layanan' ) ); ?>"><?php esc_html_e( 'Termite Control', 'hamagopest' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#layanan' ) ); ?>"><?php esc_html_e( 'Fumigasi', 'hamagopest' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#layanan' ) ); ?>"><?php esc_html_e( 'Disinfeksi & Sanitasi', 'hamagopest' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#layanan' ) ); ?>"><?php esc_html_e( 'Pengendalian Hewan Pengganggu', 'hamagopest' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#layanan' ) ); ?>"><?php esc_html_e( 'Pengharum Ruangan', 'hamagopest' ); ?></a></li>
				</ul>
			</div>

			<div class="footer-col footer-contact">
				<h4><?php esc_html_e( 'Kontak', 'hamagopest' ); ?></h4>
				<p><?php echo esc_html( hamagopest_get_address() ); ?></p>
				<p class="footer-phone"><a href="<?php echo esc_url( hamagopest_tel_link() ); ?>"><?php echo esc_html( hamagopest_get_phone() ); ?></a></p>
				<?php $email = get_theme_mod( 'hamagopest_email', 'info@hamagopest.co.id' ); ?>
				<?php if ( $email ) : ?>
					<p><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
				<?php endif; ?>
			</div>
		</div>

		<div class="foot-bottom">
			<span><?php echo esc_html( sprintf( get_theme_mod( 'hamagopest_copyright', __( '© %s Hamago Pest Solutions. Seluruh hak cipta dilindungi.', 'hamagopest' ) ), gmdate( 'Y' ) ) ); ?></span>
			<span><?php esc_html_e( 'Dikembangkan untuk hamagopest.co.id', 'hamagopest' ); ?></span>
		</div>
	</div>
</footer>

<?php endif; ?>

<?php if ( get_theme_mod( 'hamagopest_wa_float_show', true ) ) : ?>
<a class="wa-float" href="<?php echo esc_url( hamagopest_wa_link() ); ?>" target="_blank" rel="noopener nofollow" aria-label="<?php esc_attr_e( 'Chat WhatsApp', 'hamagopest' ); ?>">
	<span class="wa-ring" aria-hidden="true"></span>
	<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C6.5 2 2 6.5 2 12c0 1.8.5 3.5 1.3 5L2 22l5.2-1.4c1.4.8 3.1 1.2 4.8 1.2 5.5 0 10-4.5 10-10S17.5 2 12 2zm5.9 14.2c-.2.7-1.4 1.3-2 1.4-.5.1-1.1.2-3.6-.8-3-1.2-4.9-4.2-5.1-4.4-.1-.2-1.2-1.6-1.2-3 0-1.4.7-2.1 1-2.4.3-.3.6-.3.8-.3h.6c.2 0 .5 0 .7.6.3.7.9 2.2 1 2.4.1.2.1.4 0 .6-.1.2-.2.4-.4.6-.2.2-.4.5-.6.6-.2.2-.4.4-.2.8.2.4 1 1.6 2.1 2.6 1.4 1.3 2.6 1.7 3 1.9.4.2.6.1.9-.1.3-.3.9-1.1 1.2-1.5.3-.4.5-.3.9-.2.4.2 2.3 1.1 2.7 1.3.4.2.6.3.7.4.1.2.1.9-.1 1.5z"/></svg>
</a>
<?php endif; ?>

<button class="back-top" id="hmgBackTop" aria-label="<?php esc_attr_e( 'Kembali ke atas', 'hamagopest' ); ?>">
	<svg class="hmg-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
</button>

<?php wp_footer(); ?>
</body>
</html>
