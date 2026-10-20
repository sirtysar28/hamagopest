<?php
/**
 * Elementor Widget: Hamago Services — kartu layanan.
 *
 * @package hamagopest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;

class Hamagopest_Services_Widget extends Hamagopest_Widget_Base {

	public function get_name() {
		return 'hamago_services';
	}

	public function get_title() {
		return __( 'Hamago — Layanan', 'hamagopest' );
	}

	public function get_icon() {
		return 'eicon-archive';
	}

	public function get_keywords() {
		return array( 'layanan', 'services', 'hamago', 'kartu' );
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_content', array( 'label' => __( 'Konten', 'hamagopest' ) ) );
		$this->add_heading_controls(
			array(
				'eyebrow' => __( 'Layanan Kami', 'hamagopest' ),
				'heading' => __( 'Penanganan hama yang paling sering mengganggu properti Anda', 'hamagopest' ),
				'sub'     => '',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section( 'section_cards', array( 'label' => __( 'Kartu Layanan', 'hamagopest' ) ) );

		$repeater = new Repeater();
		$repeater->add_control(
			'image',
			array(
				'label'       => __( 'Gambar Kartu (opsional)', 'hamagopest' ),
				'type'        => Controls_Manager::MEDIA,
				'description' => __( 'Upload gambar layanan (disarankan rasio 4:3, mis. 640×480). Jika diisi, gambar tampil di atas kartu; jika dikosongkan kartu tetap memakai icon.', 'hamagopest' ),
			)
		);
		$repeater->add_control(
			'icon',
			array(
				'label'   => __( 'Icon', 'hamagopest' ),
				'type'    => Controls_Manager::SELECT,
				'options' => hamagopest_icon_options(),
				'default' => 'termite',
			)
		);
		$repeater->add_control(
			'title',
			array(
				'label'   => __( 'Judul Layanan', 'hamagopest' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Nama Layanan', 'hamagopest' ),
			)
		);
		$repeater->add_control(
			'desc',
			array(
				'label'   => __( 'Deskripsi', 'hamagopest' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Deskripsi layanan.', 'hamagopest' ),
			)
		);
		$repeater->add_control(
			'methods',
			array(
				'label'       => __( 'Daftar Metode / Poin', 'hamagopest' ),
				'description' => __( 'Opsional. Satu poin per baris — tampil sebagai bullet di kartu layanan.', 'hamagopest' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '',
			)
		);
		$repeater->add_control(
			'link',
			array(
				'label'   => __( 'Link "Selengkapnya"', 'hamagopest' ),
				'type'    => Controls_Manager::URL,
			)
		);

		$this->add_control(
			'cards',
			array(
				'label'       => __( 'Kartu', 'hamagopest' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => array(
					array(
						'icon'  => 'rat',
						'title' => __( 'Rodent Control', 'hamagopest' ),
						'desc'  => __( 'Pengendalian tikus dan hama pengerat secara menyeluruh: deteksi jalur masuk, pengumpanan aman, dan sanitasi area agar infestasi tidak kembali.', 'hamagopest' ),
					),
					array(
						'icon'  => 'bug',
						'title' => __( 'Pest Control', 'hamagopest' ),
						'desc'  => __( 'Pengendalian hama umum — kecoa, semut, nyamuk, lalat, dan serangga lainnya — untuk rumah, kantor, hingga area komersial.', 'hamagopest' ),
					),
					array(
						'icon'  => 'termite',
						'title' => __( 'Termite Control', 'hamagopest' ),
						'desc'  => __( 'Basmi rayap hingga ke koloninya dengan metode terpilih sesuai kondisi bangunan Anda.', 'hamagopest' ),
						'methods' => __( "Metode Pipanisasi\nMetode Baiting (Pengumpanan)\nMetode Injeksi — Penyuntikan Chemical Anti Rayap", 'hamagopest' ),
					),
					array(
						'icon'  => 'fumigation',
						'title' => __( 'Fumigasi', 'hamagopest' ),
						'desc'  => __( 'Pengasapan komoditas, gudang, dan kontainer memakai fumigan resmi, dikerjakan tenaga ahli bersertifikat.', 'hamagopest' ),
					),
					array(
						'icon'  => 'spray',
						'title' => __( 'Disinfeksi & Sanitasi', 'hamagopest' ),
						'desc'  => __( 'Kebersihan permukaan saja tidak cukup — kami membasmi virus dan bakteri untuk lingkungan yang lebih higienis.', 'hamagopest' ),
					),
					array(
						'icon'  => 'snake',
						'title' => __( 'Pengendalian Hewan Pengganggu', 'hamagopest' ),
						'desc'  => __( 'Ular, biawak, kucing liar, tawon, lebah, dan hewan pengganggu lainnya ditangani dengan aman oleh tim berpengalaman.', 'hamagopest' ),
					),
					array(
						'icon'  => 'scent',
						'title' => __( 'Pengharum Ruangan', 'hamagopest' ),
						'desc'  => __( 'Layanan pengharum ruangan untuk kantor dan hotel — aroma segar, tahan lama, dan aman bagi penghuni.', 'hamagopest' ),
					),
					array(
						'icon'  => 'broom',
						'title' => __( 'Cleaning Services', 'hamagopest' ),
						'desc'  => __( 'Layanan pembersihan profesional untuk rumah, kantor, dan area komersial — hasil bersih, rapi, dan higienis oleh tim terlatih.', 'hamagopest' ),
					),
				),
			)
		);

		$this->add_control(
			'columns',
			array(
				'label'   => __( 'Kolom (desktop)', 'hamagopest' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '4',
				'options' => array( '2' => '2', '3' => '3', '4' => '4' ),
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
		?>
		<div class="hmg-el hmg-el-services">
			<section id="layanan" class="services <?php echo esc_attr( $this->bg_class( $s ) ); ?>">
				<div class="wrap">
					<?php $this->render_heading_block( $s ); ?>
					<?php if ( ! empty( $s['cards'] ) ) : ?>
					<div class="services-grid cols-<?php echo esc_attr( $s['columns'] ?? '4' ); ?>">
						<?php foreach ( $s['cards'] as $i => $card ) :
							$link  = ! empty( $card['link']['url'] ) ? $card['link']['url'] : '';
							$img   = ! empty( $card['image']['url'] ) ? $card['image']['url'] : '';
							$thumb = $img ? ' has-thumb' : '';
							?>
							<div class="svc-card<?php echo esc_attr( $thumb ); ?>" data-reveal="fade-up" data-delay="<?php echo esc_attr( $i * 90 ); ?>">
								<?php if ( $img ) : ?>
									<div class="svc-thumb">
										<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $card['title'] ?? '' ); ?>" loading="lazy" />
										<span class="svc-thumb-icon"><?php hamagopest_icon( $card['icon'] ?? 'termite' ); ?></span>
									</div>
								<?php endif; ?>
								<div class="svc-icon"><?php hamagopest_icon( $card['icon'] ?? 'termite' ); ?></div>
								<h3><?php echo esc_html( $card['title'] ?? '' ); ?></h3>
								<p><?php echo esc_html( $card['desc'] ?? '' ); ?></p>
								<?php
								$methods = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) ( $card['methods'] ?? '' ) ) ) );
								if ( $methods ) :
									?>
									<ul class="svc-list">
										<?php foreach ( $methods as $method ) : ?>
											<li><?php echo esc_html( $method ); ?></li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
								<?php if ( $link ) : ?>
									<a class="more" href="<?php echo esc_url( $link ); ?>"><?php esc_html_e( 'Selengkapnya', 'hamagopest' ); ?> <span aria-hidden="true">→</span></a>
								<?php else : ?>
									<span class="more"><?php esc_html_e( 'Selengkapnya', 'hamagopest' ); ?> <span aria-hidden="true">→</span></span>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>
				</div>
			</section>
		</div>
		<?php
	}
}
