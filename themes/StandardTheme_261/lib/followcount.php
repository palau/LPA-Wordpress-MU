<?php
class Follower_Count_Widget extends WP_Widget {
	
	/*-------------------------------------------------------------*/
	/* API Functions
	/*-------------------------------------------------------------*/
	
	function Follower_Count_Widget() {
		$widget_ops = array(
			'classname' => 'follower_count',
			'description' => __('Displays the total number of Twitter and FeedBurner followers.', 'follower_count')
		);
		$this->WP_Widget('follower_count', 'Standard Theme - Follower Count', $widget_ops);
	} // end constructor
	
	function widget($args, $instance) {
		
		extract($args, EXTR_SKIP);
		
		echo $before_widget;
		
		$twitter_username = empty($instance['twitter_username']) ? '&nbsp;' : apply_filters('widget_twitter_username', $instance['twitter_username']);
		$feedburner_name = empty($instance['feedburner_name']) ? '&nbsp;' : apply_filters('widget_feedburner_name', $instance['feedburner_name']);
		$clear_cache = empty($instance['clear_cache']) ? '&nbsp;' : apply_filters('widget_clear_cache', $instance['clear_cache']);
		
		$sum = $this->twitter_count($twitter_username, $args['widget_id'], $clear_cache) + $this->feed_count($feedburner_name, $args['widget_id'], $clear_cache); 
		
		?>
		<span class="count_label">
			<?php _e("twitter + feedburner", "follower_count"); ?>
		</span>
		<span class="count">
		<?php
			if($sum < 0):
				echo $sum;
			else:
				echo number_format($sum, 0, '.', ', ');
			endif;
			?>
		</span>
		<?php
		
		echo $after_widget;
		
	} // end widget
	
	function update($new_instance, $old_instance) {
	
		$instance = $old_instance;
		
		$instance['twitter_username'] = strip_tags(stripslashes($new_instance['twitter_username']));
		$instance['feedburner_name'] = strip_tags(stripslashes($new_instance['feedburner_name']));
		$instance['clear_cache'] = strip_tags(stripslashes($new_instance['clear_cache']));
		
		return $instance;
		
	} // end update
	
	function form($instance) {
		
		$instance = wp_parse_args(
			(array)$instance,
			array(
				'twitter_username' => '',
				'feedburner_name' => '',
				'clear_cache' => ''
			)
		);
		
		$twitter_username = strip_tags(stripslashes($instance['twitter_username']));
		$feedburner_name = strip_tags(stripslashes($instance['feedburner_name']));
		$clear_cache = strip_tags(stripslashes($instance['clear_cache']));
		
	?>
		<style type="text/css">
		label { font-size: 1em; margin: 0 0 0.25em 0; width: 90%; }
		.container { padding: 1em; margin: 0em 0 0.5em 0; }
		.container input { padding: 0.25em; font-size: 1em; margin: 0.5em 0 0 0; }
		.container input:focus { background: #efefef; }
		</style>
		<div class="container">
			<label for="twitter_username">
				<?php _e("Twitter Username (without '@'):", "follower_count"); ?>
			</label>
			<input type="text" value="<?php echo attribute_escape($twitter_username); ?>" id="<?php echo $this->get_field_id('twitter_username'); ?>" name="<?php echo $this->get_field_name('twitter_username'); ?>" class="widefat" />
		</div>
		<div class="container">
			<label for="feedburner_name">
				<?php _e("FeedBurner Name:", "follower_count"); ?>
			</label>
			<input type="text" value="<?php echo attribute_escape($feedburner_name); ?>" id="<?php echo $this->get_field_id('feedburner_name'); ?>" name="<?php echo $this->get_field_name('feedburner_name'); ?>" class="widefat" />
		</div>
		<div class="container">
			<input type="checkbox" id="<?php echo $this->get_field_id('clear_cache'); ?>" name="<?php echo $this->get_field_name('clear_cache'); ?>" />
			<label for="clear_cache">
				<?php _e("Clear cache on save?", "follower_count"); ?>
			</label>
		</div>
	<?php
	} // end form
	
	/*-------------------------------------------------------------*/
	/* Plug-in Functions
	/*-------------------------------------------------------------*/

	/**
	 * Retrieves the number of followers subscribed to the specified Twitter account.
	 *
	 * @twitter_id 	The Twitter username from which to retrieve followers.
	 */
	function twitter_count($twitter_id, $widget_id, $clear_cache) {
		
		$twittercount = 0;

		if(get_option('twitter_count_' . $widget_id) == 0 || $clear_cache == 'on' || get_option('twitter_count_api_timer_' . $widget_id) < (time() - 1800)): 
			$followers = $this->curl("http://twitter.com/users/show.xml?screen_name=" . $twitter_id);
			try {
				if($followers):
					$xml = new SimpleXmlElement($followers, LIBXML_NOCDATA);
					if($xml):
						if((string)$xml->followers_count):
							$twittercount = (string)$xml->followers_count;
						endif;
						update_option('twitter_count_' . $widget_id, $twittercount);
					endif;
				endif;
			} catch(Exception $ex) {}
			update_option('twitter_count_api_timer_' . $widget_id, time());
		else:
			$twittercount = get_option('twitter_count_' . $widget_id);
		endif;
		
		return $twittercount;
		
	} // end twitter_count

	/**
	 * Retrieves the number of subscribers to this blog.
	 *
	 * @feedburner_id	The name of the feedburner feed.
	 */
	function feed_count($feedburner_id, $widget_id, $clear_cache) {
		
		$rsscount = 0;
		
		if(get_option('feed_count_' . $widget_id) == 0 || $clear_cache == 'on' || get_option('feed_count_api_timer_' . $widget_id) < (time() - 1800)):
			$subscribers = $this->curl("http://feedburner.google.com/api/awareness/1.0/GetFeedData?uri=" . $feedburner_id);
			if($subscribers):
				$xml = new SimpleXmlElement($subscribers, LIBXML_NOCDATA);
				if($xml):
					if((string)$xml->feed->entry['circulation']):
						$rsscount = (string)$xml->feed->entry['circulation'];
					endif;
					update_option('feed_count_' . $widget_id, $rsscount);
				endif;
			else:
				$rsscount = get_option('feed_count_' . $widget_id);
			endif;
			update_option('feed_count_api_timer_' . $widget_id, time());
		else:
			$rsscount = get_option('feed_count_' . $widget_id);
		endif;

		return $rsscount;
		
	} // end count_subscribers
	
	/**
	 * Returns data retrieved from the specified URL.
	 *
	 * @url	The URL to which we're making the request.
	 */
	function curl($url) {

		$ch = curl_init($url);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, '');
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		
		$data = curl_exec($ch);
		if(curl_errno($ch) !== 0 || curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200):
			$data === false;
		endif;
		curl_close($ch);
		
		return $data;
		
	} // end curl
	
} // end class
add_action('widgets_init', create_function('', 'return register_widget("Follower_Count_Widget");'));
?>