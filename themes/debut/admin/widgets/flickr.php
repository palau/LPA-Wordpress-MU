<?php
/*
Plugin Name: Custom Flickr Photostream
Plugin URI: http://www.celtic7.com
Description: A widget that displays your Flickr photos
Version: 1.1
Author: Luke McDonald
Author URI: http://www.lukemcdonald.com
*/

/*
 * Load our widget.
 */
add_action( 'widgets_init', 'ti_flickr_widgets' );

/*
 * Register widget.
 */
function ti_flickr_widgets() 
{
	register_widget( 'ti_flickr_widget' );
}

/*
 * Widget class.
 */
class ti_flickr_widget extends WP_Widget 
{
	function ti_flickr_widget() 
	{
		$widget_ops = array( 'classname' => 'ti-flickr-widget', 'description' => __( 'Show Flickr photos', 'theme-it' ) );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'ti_flickr_widget' );
		$this->WP_Widget( 'ti_flickr_widget', __( 'Custom Flickr Photos', 'theme-it' ), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) 
	{
		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );
		$flickrID = $instance['flickrID'];
		$postcount = $instance['postcount'];
		$type = $instance['type'];
		$display = $instance['display'];

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;

		 ?>
			
			<div class="clearfix flickr-badge-wrapper">
				<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo absint( $postcount ) ?>&amp;display=<?php echo urlencode( $display ) ?>&amp;size=s&amp;layout=x&amp;source=<?php echo urlencode( $type ) ?>&amp;<?php echo urlencode( $type ) ?>=<?php echo urlencode( $flickrID ) ?>"></script>
			</div>
		
		<?php

		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) 
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['flickrID'] = strip_tags( $new_instance['flickrID'] );
		$instance['postcount'] = absint( $new_instance['postcount'] );
		$instance['type'] =  strip_tags( $new_instance['type'] );
		$instance['display'] =  strip_tags( $new_instance['display'] );

		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) 
	{
		$defaults = array(
			'title' => __( 'My Photostream', 'theme-it' ),
			'flickrID' => '49559723@N04',
			'postcount' => absint( 8 ),
			'type' => 'user',
			'display' => 'random',
		);
		$instance = wp_parse_args( ( array ) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'theme-it') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<!-- Flickr ID: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'flickrID' ); ?>"><?php _e('Flickr ID:', 'theme-it') ?> (<a href="http://idgettr.com/" target="_blank"><?php _e( 'idGettr', 'theme-it' ); ?></a>)</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'flickrID' ); ?>" name="<?php echo $this->get_field_name( 'flickrID' ); ?>" value="<?php echo $instance['flickrID']; ?>" />
		</p>
		
		<!-- Postcount: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'postcount' ); ?>"><?php _e('Number of Photos:', 'theme-it') ?></label>
			<select id="<?php echo $this->get_field_id( 'postcount' ); ?>" name="<?php echo $this->get_field_name( 'postcount' ); ?>" class="widefat">
				<option <?php if ( '4' == $instance['postcount'] ) echo 'selected="selected"'; ?>>4</option>
				<option <?php if ( '8' == $instance['postcount'] ) echo 'selected="selected"'; ?>>8</option>
			</select>
		</p>
		
		<!-- Type: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e('Type (user or group):', 'theme-it') ?></label>
			<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat">
				<option <?php if ( 'user' == $instance['type'] ) echo 'selected="selected"'; ?>>user</option>
				<option <?php if ( 'group' == $instance['type'] ) echo 'selected="selected"'; ?>>group</option>
			</select>
		</p>
		
		<!-- Display: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e('Display (random or latest):', 'theme-it') ?></label>
			<select id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>" class="widefat">
				<option <?php if ( 'random' == $instance['display'] ) echo 'selected="selected"'; ?>>random</option>
				<option <?php if ( 'latest' == $instance['display'] ) echo 'selected="selected"'; ?>>latest</option>
			</select>
		</p>
		
	<?php
	}
}
?>