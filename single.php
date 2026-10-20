<?php
/**
 * Single post.
 *
 * @package hamagopest
 */

get_header();

/* Jika Elementor Pro Theme Builder punya template single, pakai itu. */
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) :
?>

<?php
while ( have_posts() ) :
	the_post();
	?>
	<article <?php post_class( 'single-post-wrap' ); ?>>

		<header class="single-hero hmg-section hmg-section--alt">
			<div class="wrap">
				<span class="blog-tag"><?php echo esc_html( hamagopest_first_category( get_the_ID() ) ); ?></span>
				<h1 data-reveal="fade-up"><?php the_title(); ?></h1>
				<div class="single-meta" data-reveal="fade-up" data-delay="80">
					<span><?php echo esc_html( get_the_date() ); ?></span>
					<span aria-hidden="true">•</span>
					<span><?php echo esc_html( get_the_author() ); ?></span>
				</div>
			</div>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="wrap single-thumb" data-reveal="fade-up">
				<?php the_post_thumbnail( 'large' ); ?>
			</div>
		<?php endif; ?>

		<div class="hmg-section hmg-section--plain">
			<div class="wrap single-content">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div>
		</div>

		<?php
		$prev = get_previous_post();
		$next = get_next_post();
		if ( $prev || $next ) :
			?>
			<div class="hmg-section hmg-section--alt post-nav-section">
				<div class="wrap post-nav">
					<?php if ( $prev ) : ?>
						<a class="post-nav-link post-nav-prev" href="<?php echo esc_url( get_permalink( $prev ) ); ?>">
							<small>← <?php esc_html_e( 'Sebelumnya', 'hamagopest' ); ?></small>
							<b><?php echo esc_html( get_the_title( $prev ) ); ?></b>
						</a>
					<?php endif; ?>
					<?php if ( $next ) : ?>
						<a class="post-nav-link post-nav-next" href="<?php echo esc_url( get_permalink( $next ) ); ?>">
							<small><?php esc_html_e( 'Berikutnya', 'hamagopest' ); ?> →</small>
							<b><?php echo esc_html( get_the_title( $next ) ); ?></b>
						</a>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php
		if ( comments_open() || get_comments_number() ) {
			echo '<div class="hmg-section hmg-section--plain"><div class="wrap">';
			comments_template();
			echo '</div></div>';
		}
		?>
	</article>
	<?php
endwhile;
?>

<?php endif; ?>

<?php get_footer(); ?>
