<?php
/**
 * Archive (kategori, tag, tanggal, author).
 *
 * @package hamagopest
 */

get_header();

/* Jika Elementor Pro Theme Builder punya template archive, pakai itu. */
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) :
?>

<div class="hmg-page-wrap hmg-section">
	<div class="wrap">
		<header class="page-head">
			<h1 data-reveal="fade-up"><?php the_archive_title(); ?></h1>
			<?php the_archive_description( '<p class="archive-desc">', '</p>' ); ?>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="blog-grid cols-3">
				<?php
				$i = 0;
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'blog-card' ); ?> data-reveal="fade-up" data-delay="<?php echo esc_attr( ( $i % 3 ) * 100 ); ?>">
						<a class="blog-thumb-link" href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'hamagopest-card', array( 'class' => 'blog-thumb-img' ) ); ?>
							<?php else : ?>
								<div class="blog-thumb"></div>
							<?php endif; ?>
						</a>
						<div class="blog-body">
							<span class="blog-tag"><?php echo esc_html( hamagopest_first_category( get_the_ID() ) ); ?></span>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
						</div>
					</article>
				<?php
					$i++;
				endwhile;
				?>
			</div>
			<?php hamagopest_pagination(); ?>
		<?php else : ?>
			<p class="no-posts"><?php esc_html_e( 'Belum ada konten di arsip ini.', 'hamagopest' ); ?></p>
		<?php endif; ?>
	</div>
</div>

<?php endif; ?>

<?php get_footer(); ?>
