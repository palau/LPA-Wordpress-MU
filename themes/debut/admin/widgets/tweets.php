<?php
/*
Plugin Name: Custom Latest Tweets
Plugin URI: http://www.celtic7.com
Description: Display latest tweets
Version: 1.2
Author: Luke McDonald
Author URI: http://www.lukemcdonald.com
*/

/*
 * Load our widget.
 */
add_action( 'widgets_init', 'ti_twitters_widgets' );

/*
 * Register widget.
 */
function ti_twitters_widgets() {
	register_widget( 'ti_twitter_widget' );
}

/*
 * Widget class.
 */
class ti_twitter_widget extends WP_Widget {

	function ti_twitter_widget()	{
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'ti-twitter-widget', 'description' => __( 'Display latest tweets', 'theme-it' ) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'ti_twitter_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'ti_twitter_widget', __( 'Custom Latest Tweets', 'theme-it' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance )	{
		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );
		$twittername = $instance['twittername'];
		$tweetcount = $instance['tweetcount'];
		$tweettext = $instance['tweettext'];

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;

		 ?>
			
			<div id="twitter-div" class="clearfix">
				<ul id="twitter_update_list">
					<li>&nbsp;</li>
				</ul>
				<a href="http://twitter.com/<?php echo urlencode( $twittername ) ?>" class="twitter-link"><?php echo $tweettext ?></a>
			</div>
			<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
			<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo urlencode( $twittername ) ?>.json?callback=twitterCallback2&amp;count=<?php echo absint( $tweetcount ) ?>"></script>

		<?php 

		echo $after_widget;
	}


	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance )	{
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['twittername'] = strip_tags( $new_instance['twittername'] );
		$instance['tweetcount'] = absint( $new_instance['tweetcount'] );
		$instance['tweettext'] = strip_tags( $new_instance['tweettext'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
		$defaults = array(
			'title'       => __( 'Latest Tweets', 'theme-it' ),
			'twittername' => 'thelukemcdonald',
			'tweetcount'  => absint( 5 ),
			'tweettext'   => __( 'Follow on Twitter', 'theme-it' )
		);
		$instance = wp_parse_args( ( array ) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<!-- twittername: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'twittername' ); ?>"><?php _e( 'Twitter Username', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'twittername' ); ?>" name="<?php echo $this->get_field_name( 'twittername' ); ?>" value="<?php echo $instance['twittername']; ?>" />
		</p>
		
		<!-- tweetcount: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tweetcount' ); ?>"><?php _e( 'Number of tweets (max 20)', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tweetcount' ); ?>" name="<?php echo $this->get_field_name( 'tweetcount' ); ?>" value="<?php echo absint( $instance['tweetcount'] ) ?>" />
		</p>
		
		<!-- Tweettext: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tweettext' ); ?>"><?php _e( 'Follow Text e.g. Follow me on Twitter', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tweettext' ); ?>" name="<?php echo $this->get_field_name( 'tweettext' ); ?>" value="<?php echo $instance['tweettext']; ?>" />
		</p>
		
	<?php
	}
}
?>