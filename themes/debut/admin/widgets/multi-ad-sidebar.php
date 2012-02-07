<?php
/*
Plugin Name: Custom 220x125 Ad Unit
Plugin URI: http://www.celtic7.com
Description: A widget that allows the selection and configuration of 6 220x125 ad units
Version: 1.1
Author: Luke McDonald
Author URI: http://www.lukemcdonald.com
*/

/*
 * Load our widget.
 */
add_action( 'widgets_init', 'ti_ads_220x125_widgets' );

/*
 * Register widget.
 */
function ti_ads_220x125_widgets() {
	register_widget( 'ti_ads_220x125_widget' );
}

/*
 * Widget class.
 */
class ti_ads_220x125_widget extends WP_Widget {

	function ti_ads_220x125_widget() 
	{
		/* Widget settings */
		$widget_ops = array( 'classname' => 'ti-ad-widget', 'description' => __( 'Display up to six 220x125 ad blocks.', 'theme-it' ) );

		/* Widget control settings */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'ti_ads_220x125_widget' );

		/* Create the widget */
		$this->WP_Widget( 'ti_ads_220x125_widget', __( 'Multi Ads - Sidebar', 'theme-it' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) 
	{
		extract( $args );

		/* Our variables from the widget settings. */
		$title     = apply_filters( 'widget_title', $instance['title'] );
		$ad1       = $instance['ad1'];
		$ad2       = $instance['ad2'];
		$ad3       = $instance['ad3'];
		$ad4       = $instance['ad4'];
		$ad5       = $instance['ad5'];
		$ad6       = $instance['ad6'];
		$link1     = $instance['link1'];
		$link2     = $instance['link2'];
		$link3     = $instance['link3'];
		$link4     = $instance['link4'];
		$link5     = $instance['link5'];
		$link6     = $instance['link6'];
		$randomize = $instance['random'];

		/* Before widget ( defined by themes ). */
		echo $before_widget;

		/* Display the widget title if one was input ( before and after defined by themes ). */
		if ( $title )
			echo $before_title . esc_html( $title ) . $after_title;

		//Randomize ads order in a new array
		$ads = array();
		
		?>
			
		<div class="ads-220x125 clearfix">
			<ul class="clearfix">
				
				<?php
				/* Display Ad 1. */
				if ( $link1 )
					$ads[] = '<li><a href="' . esc_url( $link1 ) . '"><img src="' . esc_url( $ad1 ) . '" width="220" height="125" alt="" /></a></li>';
				elseif ( $ad1 )
				 	$ads[] = '<li><img src="' . esc_url( $ad1 ) . '" width="220" height="125" alt="" /></li>';
				
				/* Display Ad 2. */
				if ( $link2 )
					$ads[] = '<li><a href="' . esc_url( $link2 ) . '"><img src="' . esc_url( $ad2 ) . '" width="220" height="125" alt="" /></a></li>';
				elseif ( $ad2 )
				 	$ads[] = '<li><img src="' . esc_url( $ad2 ) . '" width="220" height="125" alt="" /></li>';
					
				/* Display Ad 3. */
				if ( $link3 )
					$ads[] = '<li><a href="' . esc_url( $link3 ) . '"><img src="' . esc_url( $ad3 ) . '" width="220" height="125" alt="" /></a></li>';
				elseif ( $ad3 )
				 	$ads[] = '<li><img src="' . esc_url( $ad3 ) . '" width="220" height="125" alt="" /></li>';
					
				/* Display Ad 4. */
				if ( $link4 )
					$ads[] = '<li><a href="' . esc_url( $link4 ) . '"><img src="' . esc_url( $ad4 ) . '" width="220" height="125" alt="" /></a></li>';
				elseif ( $ad4 )
				 	$ads[] = '<li><img src="' . esc_url( $ad4 ) . '" width="220" height="125" alt="" /></li>';
					
				/* Display Ad 5. */
				if ( $link5 )
					$ads[] = '<li><a href="' . esc_url( $link5 ) . '"><img src="' . esc_url( $ad5 ) . '" width="220" height="125" alt="" /></a></li>';
				elseif ( $ad5 )
				 	$ads[] = '<li><img src="' . esc_url( $ad5 ) . '" width="220" height="125" alt="" /></li>';
					
				/* Display Ad 6. */
				if ( $link6 )
					$ads[] = '<li><a href="' . esc_url( $link6 ) . '"><img src="' . esc_url( $ad6 ) . '" width="220" height="125" alt="" /></a></li>';
				elseif ( $ad6 )
				 	$ads[] = '<li><img src="' . esc_url( $ad6 ) . '" width="220" height="125" alt="" /></li>';
				
				//Randomize order if user want it
				if ( $randomize )
					shuffle( $ads );
				
				//Display ads
				foreach( $ads as $ad ) {
					echo $ad;
				}
				
				?>
			</ul>
		</div>
		
		<?php
		/* After widget ( defined by themes ). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags to remove HTML ( important for text inputs ). */
		$instance['title'] = strip_tags( $new_instance['title'] );

		/* No need to strip tags */
		$instance['ad1']    = esc_url_raw( strip_tags( $new_instance['ad1'] ) );
		$instance['ad2']    = esc_url_raw( strip_tags( $new_instance['ad2'] ) );
		$instance['ad3']    = esc_url_raw( strip_tags( $new_instance['ad3'] ) );
		$instance['ad4']    = esc_url_raw( strip_tags( $new_instance['ad4'] ) );
		$instance['ad5']    = esc_url_raw( strip_tags( $new_instance['ad5'] ) );
		$instance['ad6']    = esc_url_raw( strip_tags( $new_instance['ad6'] ) );
		$instance['link1' ] = esc_url_raw( strip_tags( $new_instance['link1'] ) );
		$instance['link2' ] = esc_url_raw( strip_tags( $new_instance['link2'] ) );
		$instance['link3' ] = esc_url_raw( strip_tags( $new_instance['link3'] ) );
		$instance['link4' ] = esc_url_raw( strip_tags( $new_instance['link4'] ) );
		$instance['link5' ] = esc_url_raw( strip_tags( $new_instance['link5'] ) );
		$instance['link6' ] = esc_url_raw( strip_tags( $new_instance['link6'] ) );
		$instance['random'] = $new_instance['random'];
		
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
			'title'  => 'Our Sponsors',
			'ad1'    => get_template_directory_uri() . "/images/banner-220x125.png",
			'link1'  => 'http://www.lukemcdonald.com',
			'ad2'    => get_template_directory_uri() . "/images/banner-220x125.png",
			'link2'  => 'http://www.lukemcdonald.com',
			'ad3'    => '',
			'link3'  => '',
			'ad4'    => '',
			'link4'  => '',
			'ad5'    => '',
			'link5'  => '',
			'ad6'    => '',
			'link6'  => '',
			'random' => false
		 );
		$instance = wp_parse_args( ( array ) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<!-- Ad 1 image url: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ad1' ); ?>"><?php _e( 'Ad 1 image url:', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'ad1' ); ?>" name="<?php echo $this->get_field_name( 'ad1' ); ?>" value="<?php echo $instance['ad1']; ?>" />
		</p>
		
		<!-- Ad 1 link url: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'link1' ); ?>"><?php _e( 'Ad 1 link url:', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link1' ); ?>" name="<?php echo $this->get_field_name( 'link1' ); ?>" value="<?php echo $instance['link1']; ?>" />
		</p>
		
		<!-- Ad 2 image url: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ad2' ); ?>"><?php _e( 'Ad 2 image url:', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'ad2' ); ?>" name="<?php echo $this->get_field_name( 'ad2' ); ?>" value="<?php echo $instance['ad2']; ?>" />
		</p>
		
		<!-- Ad 2 link url: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'link2' ); ?>"><?php _e( 'Ad 2 link url:', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link2' ); ?>" name="<?php echo $this->get_field_name( 'link2' ); ?>" value="<?php echo $instance['link2']; ?>" />
		</p>
		
		<!-- Ad 3 image url: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ad3' ); ?>"><?php _e( 'Ad 3 image url:', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'ad3' ); ?>" name="<?php echo $this->get_field_name( 'ad3' ); ?>" value="<?php echo $instance['ad3']; ?>" />
		</p>
		
		<!-- Ad 3 link url: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'link3' ); ?>"><?php _e( 'Ad 3 link url:', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link3' ); ?>" name="<?php echo $this->get_field_name( 'link3' ); ?>" value="<?php echo $instance['link3']; ?>" />
		</p>
		
		<!-- Ad 4 image url: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ad4' ); ?>"><?php _e( 'Ad 4 image url:', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'ad4' ); ?>" name="<?php echo $this->get_field_name( 'ad4' ); ?>" value="<?php echo $instance['ad4']; ?>" />
		</p>
		
		<!-- Ad 4 link url: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'link4' ); ?>"><?php _e( 'Ad 4 link url:', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link4' ); ?>" name="<?php echo $this->get_field_name( 'link4' ); ?>" value="<?php echo $instance['link4']; ?>" />
		</p>
		
		<!-- Ad 5 image url: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ad5' ); ?>"><?php _e( 'Ad 5 image url:', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'ad5' ); ?>" name="<?php echo $this->get_field_name( 'ad5' ); ?>" value="<?php echo $instance['ad5']; ?>" />
		</p>
		
		<!-- Ad 5 link url: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'link5' ); ?>"><?php _e( 'Ad 5 link url:', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link5' ); ?>" name="<?php echo $this->get_field_name( 'link5' ); ?>" value="<?php echo $instance['link5']; ?>" />
		</p>
		
		<!-- Ad 6 image url: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ad6' ); ?>"><?php _e( 'Ad 6 image url:', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'ad6' ); ?>" name="<?php echo $this->get_field_name( 'ad6' ); ?>" value="<?php echo $instance['ad6']; ?>" />
		</p>
		
		<!-- Ad 6 link url: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'link6' ); ?>"><?php _e( 'Ad 6 link url:', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link6' ); ?>" name="<?php echo $this->get_field_name( 'link6' ); ?>" value="<?php echo $instance['link6']; ?>" />
		</p>
		
		<!-- Randomize? -->
		<p>
			<label for="<?php echo $this->get_field_id( 'random' ); ?>"><?php _e( 'Randomize ads order?', 'theme-it' ) ?></label>
			<?php if ( $instance['random'] ){ ?>
				<input type="checkbox" id="<?php echo $this->get_field_id( 'random' ); ?>" name="<?php echo $this->get_field_name( 'random' ); ?>" checked="checked" />
			<?php } else { ?>
				<input type="checkbox" id="<?php echo $this->get_field_id( 'random' ); ?>" name="<?php echo $this->get_field_name( 'random' ); ?>"  />
			<?php } ?>
		</p>
	<?php
	}
}
?>