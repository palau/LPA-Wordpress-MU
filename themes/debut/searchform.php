<?php 
/**
 * The page template file.
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      1.0
 */

// Set search placeholder text
$search_placeholder = __( 'Search', 'theme-it' ); 

?>

<script type="text/javascript">
  function doSerachBlur(theValue) {
  	if (theValue.value == '') {
  		theValue.value = '<?php _e( $search_placeholder ); ?>';
  	}
  }
  function doSearchFocus(theValue) {
  	if (theValue.value == '<?php _e( $search_placeholder ); ?>') {
  		theValue.value = '';
  	}
  }
</script>

<div id="search" role="search">
	<form method="get" id="search-form" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  	<input type="text" id="s" name="s" value="<?php esc_attr_e( $search_placeholder ); ?>" onblur="doSerachBlur(this)" onfocus="doSearchFocus(this)" />
		<input type="submit" class="png_bg" id="search-submit" value="" />
	</form>
</div><!-- #search -->
