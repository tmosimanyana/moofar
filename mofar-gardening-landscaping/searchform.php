<?php
/**
 * The template for displaying search forms in VW Gardening Landscaping
 *
 * @package VW Gardening Landscaping
 */
?>

<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_attr_x( 'Search for:', 'label', 'vw-gardening-landscaping' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr( get_theme_mod('vw_gardening_landscaping_search_placeholder', __('Search', 'vw-gardening-landscaping')) ); ?>" value="<?php echo esc_attr(get_search_query()) ?>" name="s">
	</label>
	<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button','vw-gardening-landscaping' ); ?>">
</form>