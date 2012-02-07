<?php
/*
Plugin Name: Live Tweets
Plugin URI: http://livetheme.tv
Description: Displays what people are currently tweeting based on the specified hashtag and username.
Version: 1.0
Author: The Standard Theme Team
Author URI: http://standardtheme.com
License: GPL2
*/

/*  Copyright 2010  Standard Theme Team  (email : info@standardtheme.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Live_Tweets_Widget extends WP_Widget {
	
	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/
	
	function Live_Tweets_Widget() {
		$widget_ops = array(
			'classname' => 'live_tweets',
			'description' => __('Displays a feed of what people are saying based on the given hashtag.', 'live_tweets')
		);
		$this->WP_Widget('live_tweets', __('Live Tweets', 'live_tweets'), $widget_ops);
		load_plugin_textdomain('live_tweets', '/livetweets/lang/');
		if(!is_admin()):
			wp_enqueue_style('livetweets', get_template_directory_uri() . '/lib/livetweets/css/livetweets.css');
			wp_enqueue_script("jquery");
			wp_enqueue_script('formatDate', get_template_directory_uri() . '/lib/livetweets/javascript/formatDate.js');
			wp_enqueue_script('ify', get_template_directory_uri() . '/lib/livetweets/javascript/ify.js');
			wp_enqueue_script('jquery.livetweets', get_template_directory_uri() . '/lib/livetweets/javascript/jquery.livetweets.js');
		endif;
	} // end constructor
	
	/*--------------------------------------------------*/
	/* API Functions
	/*--------------------------------------------------*/
	
	function widget($args, $instance) {
		
		extract($args, EXTR_SKIP);
		
		echo $before_widget;
		
		$hashtag = empty($instance['hashtag']) ? '&nbsp;' : apply_filters('widget_hashtag', $instance['hashtag']);
		$username = empty($instance['username']) ? '&nbsp;' : apply_filters('widget_username', $instance['username']);
		$updaterate = empty($instance['updaterate']) ? '&nbsp;' : apply_filters('widget_updaterate', $instance['updaterate']);
		
		?>
		<img src="<?php echo get_template_directory_uri() . '/lib/livetweets/images/ajax-loader.gif' ?>" alt="<?php _e("Loading...", "live_tweets"); ?>" class="live_tweets_loading" />
		<ul class="live_tweets_display">
			<li>
				<span class="live_tweets_error">
					<?php _e("You entered an invalid hashtag and/or username.", "live_tweets"); ?>
				</span>
			</li>
		</ul>
		<div class="live_tweets_controls">
			<a href="javascript:void(0);" class="live_tweets_pause">
				<img src="<?php bloginfo('template_directory'); ?>/images/icn-pause-16.png" alt="pause"/>
				<?php _e('Pause', 'livetheme'); ?>
			</a>
			<a href="javascript:void(0);" class="live_tweets_resume">
				<img src="<?php bloginfo('template_directory'); ?>/images/icn-resume-16.png" alt="resume"/>
				<?php _e("Resume", "live_tweets"); ?>
			</a>
		</div>
		<div class="live_tweets_container" style="display:none;"></div>
		<input type="hidden" id="live_tweets_hashtag" class="live_tweets_hashtag" value="<?php echo trim($hashtag); ?>" />
		<input type="hidden" id="live_tweets_username" class="live_tweets_username" value="<?php echo trim($username); ?>" />
		<input type="hidden" id="live_tweets_updaterate" class="live_tweets_updaterate" value="<?php echo trim($updaterate); ?>" />
		<input type="hidden" id="live_tweets_source" class="live_tweets_source" value="<?php echo bloginfo('template_directory'); ?>" />
		<?php
		
		echo $after_widget;
		
	} // end widget
	
	function update($new_instance, $old_instance) {
	
		$instance = $old_instance;
		
		$instance['hashtag'] = strip_tags(stripslashes($new_instance['hashtag']));
		$instance['username'] = strip_tags(stripslashes($new_instance['username']));
		$instance['updaterate'] = strip_tags(stripslashes($new_instance['updaterate']));
		
		return $instance;
		
	} // end update
	
	function form($instance) {
		
		$instance = wp_parse_args(
			(array)$instance,
			array(
				'hashtag' => '',
				'username' => '',
				'updaterate' => '',
				'displaycount' => ''
			)
		);
		
		$hashtag = strip_tags(stripslashes($instance['hashtag']));
		$username = strip_tags(stripslashes($instance['username']));
		$updaterate = strip_tags(stripslashes($instance['updaterate']));
		
	?>
		<p class="description">
			<?php _e("Leave a field blank if you wish to exclude it from your feed."); ?>
		</p>
		<div>
			<label for="hashtag" style="display:block;">
				<?php _e("Twitter Hashtag (excluding '#'):", "live_tweets"); ?>
			</label>
			<input type="text" value="<?php echo attribute_escape($hashtag); ?>" id="<?php echo $this->get_field_id('hashtag'); ?>" name="<?php echo $this->get_field_name('hashtag'); ?>" class="widefat" />
			<label for="hashtag" style="display:block;">
				<?php _e("Twitter Username (excluding '@'):", "live_tweets"); ?>
			</label>
			<input type="text" value="<?php echo attribute_escape($username); ?>" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" class="widefat" />
			<label for="updaterate" style="display:block;">
				<?php _e("Update Rate (in seconds):", "live_tweets"); ?>
			</label>
			<input type="text" value="<?php echo attribute_escape($updaterate); ?>" id="<?php echo $this->get_field_id('updaterate'); ?>" name="<?php echo $this->get_field_name('updaterate'); ?>" class="widefat" />
		</div>
	<?php
	} // end form
	
} // end class
add_action('widgets_init', create_function('', 'return register_widget("Live_Tweets_Widget");'));