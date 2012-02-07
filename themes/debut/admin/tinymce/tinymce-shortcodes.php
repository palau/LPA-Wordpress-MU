<?php
/*
 * These shortcodes are included but not promoted in the theme.
 * A styles drop down, quick tags, and a custom "Snipperts" button
 * have been provided to add the necessary div and classes. These 
 * are commonly used shortcodes and I had theme in the initial release.
 * I figure they better stay put and can come in useful if user
 * switches themes to Debut in which it used the same shortcodes.
 *
 * In addition, a editor stylesheet has been provided to help display
 * and style these types of items. Doing this lets the user know if
 * the content has been styled or not which is important because there
 * are now no shortcodes indicating such.
 */
 
/* 1/2 */
function ti_one_half( $atts, $content = null ) {
	return '<div class="one-half">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'one_half', 'ti_one_half' );

/* 1/2 Last */
function ti_one_half_last( $atts, $content = null ) {
	return '<div class="one-half last">' . do_shortcode( $content ) . '</div><div class="clearfix"></div>';
}
add_shortcode( 'one_half_last', 'ti_one_half_last' );

/* 1/3 */
function ti_one_third( $atts, $content = null ) {
	return '<div class="one-third">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'one_third', 'ti_one_third' );

/* 1/3 Last */
function ti_one_third_last( $atts, $content = null ) {
	return '<div class="one-third last">' . do_shortcode( $content ) . '</div><div class="clearfix"></div>';
}
add_shortcode( 'one_third_last', 'ti_one_third_last' );

/* 2/3 */
function ti_two_third( $atts, $content = null ) {
	return '<div class="two-third">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'two_third', 'ti_two_third' );

/* 2/3 Last */
function ti_two_third_last( $atts, $content = null ) {
	return '<div class="two-third last">' . do_shortcode( $content ) . '</div><div class="clearfix"></div>';
}
add_shortcode( 'two_third_last', 'ti_two_third_last' );

/* 1/4 */
function ti_one_fourth( $atts, $content = null ) {
	return '<div class="one-fourth">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'one_fourth', 'ti_one_fourth' );

/* 1/4 Last */
function ti_one_fourth_last( $atts, $content = null ) {
	return '<div class="one-fourth last">' . do_shortcode( $content ) . '</div><div class="clearfix"></div>';
}
add_shortcode( 'one_fourth_last', 'ti_one_fourth_last' );

/* 3/4 */
function ti_three_fourth( $atts, $content = null ) {
	return '<div class="three-fourth">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'three_fourth', 'ti_three_fourth' );

/* 3/4 Last */
function ti_three_fourth_last( $atts, $content = null ) {
	return '<div class="three-fourth last">' . do_shortcode( $content ) . '</div><div class="clearfix"></div>';
}
add_shortcode( 'three_fourth_last', 'ti_three_fourth_last' );

?>