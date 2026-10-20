<?php
/**
 * Elementor Widget: Hamago Posts — artikel terbaru (blog).
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;

class Hamagopest_Posts_Widget extends Hamagopest_Widget_Base {

	public function get_name() {
		return 'hamago_posts';
	}

	public function get_title() {
		return __( 'Hamago — Artikel Terbaru', 'hamagopest' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_keywords() {
		return array( 'artikel', 'blog', 'posts', 'hamago' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_content', array( 'label' => __( 'Konten', 'hamagopest' ) ) );
		$this->add_heading_controls(
			array(
				'eyebrow' => __( 'Artikel', 'hamagopest' ),
				'heading' => __( 'Wawasan seputar hama dan pencegahannya', 'hamagopest' ),
				'sub'     => '',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section( 'section_query', array( 'label' => __( 'Query', 'hamagopest' ) ) );

		$this->add_control(
			'posts_per_page',
			array(
				'label'   => __( 'Jumlah artikel', 'hamagopest' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 9,
			)
		);

		$this->add_control(
			'columns',
			array(
				'label'   => __( 'Kolom (desktop)', 'hamagopest' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '3',
				'options' => array( '2' => '2', '3' => '3', '4' => '4' ),
			)
		);

		$this->add_control(
			'btn_text',
			array(
				'label'   => __( 'Teks tombol "Lihat Semua"', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Lihat Semua Artikel', 'hamagopest' ),
			)
		);
		$this->add_control(
			'btn_link',
			array(
				'label'   => __( 'Link tombol', 'hamagopest' ),
				'type'    => Controls_Manager::URL,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section( 'section_anim', array( 'label' => __( 'Animasi & Background', 'hamagopest' ) ) );
		$this->add_bg_controls( 'alt' );
		$this->add_parallax_toggle();
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();

		$q = new WP_Query(
			array(
				'post_type'           => 'post',
				'posts_per_page'      => ! empty( $s['posts_per_page'] ) ? intval( $s['posts_per_page'] ) : 3,
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			)
		);
		?>
		<div class="hmg-el hmg-el-posts">
			<section id="blog" class="blog-section <?php echo esc_attr( $this->bg_class( $s ) ); ?>">
				<div class="wrap">
					<?php $this->render_heading_block( $s ); ?>

					<?php if ( $q->have_posts() ) : ?>
					<div class="blog-grid cols-<?php echo esc_attr( $s['columns'] ?? '3' ); ?>">
						<?php
						$i = 0;
						while ( $q->have_posts() ) :
							$q->the_post();
							?>
							<article class="blog-card" data-reveal="fade-up" data-delay="<?php echo esc_attr( $i * 100 ); ?>">
								<a class="blog-thumb-link" href="<?php the_permalink(); ?>">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'hamagopest-card', array( 'class' => 'blog-thumb-img' ) ); ?>
									<?php else : ?>
										<div class="blog-thumb"></div>
									<?php endif; ?>
								</a>
								<div class="blog-body">
									<span class="blog-tag"><?php echo esc_html( hamagopest_first_category( get_the_ID() ) ); ?></span>
									<h3><a href="<?php the_permalink(); ?>"><?php echo esc_html( wp_trim_words( get_the_title(), 10 ) ); ?></a></h3>
									<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
								</div>
							</article>
						<?php
							$i++;
						endwhile;
						wp_reset_postdata();
						?>
					</div>

					<?php
					$btn_url = ! empty( $s['btn_link']['url'] ) ? $s['btn_link']['url'] : home_url( '/' );
					if ( ! empty( $s['btn_text'] ) ) :
						?>
						<div class="section-cta" data-reveal="fade-up" data-delay="200">
							<a href="<?php echo esc_url( $btn_url ); ?>" class="btn btn-outline dark"><?php echo esc_html( $s['btn_text'] ); ?></a>
						</div>
					<?php endif; ?>

					<?php else : ?>
						<p class="no-posts"><?php esc_html_e( 'Belum ada artikel. Tambahkan post pertama Anda di menu Posts.', 'hamagopest' ); ?></p>
					<?php endif; ?>
				</div>
			</section>
		</div>
		<?php
	}
}
