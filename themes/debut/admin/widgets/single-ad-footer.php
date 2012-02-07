<?php
/*
Plugin Name: Custom 250x125 Ad Block
Plugin URI: http://www.celtic7.com
Description: Configure a single 250x125 advertisement area
Version: 1.1
Author: Luke McDonald
Author URI: http://www.lukemcdonald.com
*/

/*
 * Load our widget.
 */
add_action( 'widgets_init', 'ti_ad_250x125_widgets' );

/*
 * Register widget.
 */
function ti_ad_250x125_widgets() {
	register_widget( 'ti_ad_250x125_widget' );
}

/*
 * Widget class.
 */
class ti_ad_250x125_widget extends WP_Widget {

	function ti_ad_250x125_widget() 
	{
		/* Widget settings */
		$widget_ops = array( 'classname' => 'ti-ad-widget', 'description' => __( 'Display a single 250x125 ad block.', 'theme-it' ) );

		/* Widget control settings */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'ti_ad_250x125_widget' );

		/* Create the widget */
		$this->WP_Widget( 'ti_ad_250x125_widget', __( 'Single Ad - Footer', 'theme-it' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) 
	{
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters( 'widget_title', $instance['title'] );
		$ad    = $instance['ad'];
		$link  = $instance['link'];

		/* Before widget ( defined by themes ). */
		echo $before_widget;

		/* Display the widget title if one was input ( before and after defined by themes ). */
		if ( $title )
			echo $before_title . esc_html( $title ) . $after_title;
			
		/* Display a containing div */
		echo '<div class="ad-250x125">';

		/* Display Ad */
		if ( $link )
			echo '<a href="' . esc_url( $link ) . '"><img src="' . esc_url( $ad ) . '" width="250" height="125" alt="" /></a>';
			
		elseif ( $ad )
		 	echo '<img src="' . esc_url( $ad ) . '" width="250" height="125" alt="" />';
			
		echo '</div>';

		/* After widget ( defined by themes ). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['ad']    = esc_url_raw( strip_tags( $new_instance['ad'] ) );
		$instance['link']  = esc_url_raw( strip_tags( $new_instance['link'] ) );

		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array( 
		'title' => '',
		'ad'    => get_template_directory_uri() . "/images/banner-250x125.png",
		'link'  => 'http://www.lukemcdonald.com',
		 );
		$instance = wp_parse_args( ( array ) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<!-- Ad image url: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ad' ); ?>"><?php _e( 'Ad image url:', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'ad' ); ?>" name="<?php echo $this->get_field_name( 'ad' ); ?>" value="<?php echo $instance['ad']; ?>" />
		</p>
		
		<!-- Ad link url: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Ad link url:', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo $instance['link']; ?>" />
		</p>
		
	<?php
	}
}
?>