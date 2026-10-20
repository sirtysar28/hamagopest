<?php
/**
 * Form pencarian.
 *
 * @package hamagopest
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="hmg-search-field"><?php esc_html_e( 'Cari:', 'hamagopest' ); ?></label>
	<input type="search" id="hmg-search-field" class="search-field" placeholder="<?php esc_attr_e( 'Cari artikel…', 'hamagopest' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	<button type="submit" class="search-submit btn btn-gold"><?php esc_html_e( 'Cari', 'hamagopest' ); ?></button>
</form>
