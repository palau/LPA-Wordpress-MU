<?php
/**
 * This file includes or removes widgets.
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      1.0
 */


/**
 * Include Widgets
 *
 * @since     1.0
 */
function ti_register_widgets() {
	require_once ti_ADMINPATH . '/widgets/flickr.php';
	require_once ti_ADMINPATH . '/widgets/multi-ad-footer.php';
	require_once ti_ADMINPATH . '/widgets/multi-ad-sidebar.php';
	require_once ti_ADMINPATH . '/widgets/single-ad-footer.php';
	require_once ti_ADMINPATH . '/widgets/single-ad-sidebar.php';
	require_once ti_ADMINPATH . '/widgets/tabbed.php';
	require_once ti_ADMINPATH . '/widgets/tweets.php';
	require_once ti_ADMINPATH . '/widgets/video.php';
}
add_action( 'widgets_init', 'ti_register_widgets', 1 );

?>