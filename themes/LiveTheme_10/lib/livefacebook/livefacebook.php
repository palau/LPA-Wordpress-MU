<?php
/*
Plugin Name: Live Facebook
Plugin URI: http://livetheme.tv
Description: Makes it easy to embed a Facebook Live Stream into your site. Bring your own Application ID.
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

class Live_Facebook_Widget extends WP_Widget {
	
	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/
	
	function Live_Facebook_Widget() {
		$widget_ops = array(
			'classname' => 'live_facebook',
			'description' => __('Makes it easy to embed a Facebook Live Stream into your site. Bring your own Application ID.', 'live_facebook')
		);
		$this->WP_Widget('live_facebook', 'Live Facebook', $widget_ops);
		if(!is_admin()):
			wp_enqueue_script("jquery");
		endif;
	} // end constructor
	
	/*--------------------------------------------------*/
	/* API Functions
	/*--------------------------------------------------*/
	
	function widget($args, $instance) {
		
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$appid = empty($instance['appid']) ? '&nbsp;' : apply_filters('widget_appid', $instance['appid']);
		
		?>
		<iframe src="http://www.facebook.com/plugins/livefeed.php?app_id=<?php echo $appid; ?>&amp;width=300&amp;height=331" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:331px;margin-top:-0.4em;" allowTransparency="true"></iframe>
		<?php
		
		echo $after_widget;
		
	} // end widget
	
	function update($new_instance, $old_instance) {
	
		$instance = $old_instance;
		$instance['appid'] = strip_tags(stripslashes($new_instance['appid']));
		return $instance;
		
	} // end update
	
	function form($instance) {
		
		$instance = wp_parse_args(
			(array)$instance,
			array(
				'appid' => '',
			)
		);
		
		$appid = strip_tags(stripslashes($instance['appid']));
		
	?>
		<div>
			<label for="appid" style="display:block;">
				<?php _e("Facebook Application ID:", "live_facebook"); ?>
			</label>
			<input type="text" value="<?php echo attribute_escape($appid); ?>" id="<?php echo $this->get_field_id('appid'); ?>" name="<?php echo $this->get_field_name('appid'); ?>" class="widefat" />
		</div>
	<?php
	} // end form
	
} // end class
add_action('widgets_init', create_function('', 'return register_widget("Live_Facebook_Widget");'));