<?php
/*
Plugin Name: Live Countdown
Plugin URI: http://livetheme.com
Description: Displays a countdown in days, hours, minutes, and seconds based on the specified date.
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

class Live_Countdown_Widget extends WP_Widget {
	
	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/
	
	function Live_Countdown_Widget() {
		$widget_ops = array(
			'classname' => 'live_countdown',
			'description' => __('Displays a countdown in days, hours, minutes, and seconds based on the specified date.', 'livecountdown')
		);
		$this->WP_Widget('live_countdown', 'Live Countdown', $widget_ops);
		wp_enqueue_script("jquery");
		if(is_admin()):
			wp_enqueue_script('jquery.livecountdownadmin', get_template_directory_uri() . '/lib/live-countdown/javascript/livecountdown.admin.js');
		else:
			wp_enqueue_style('livecountdown',  get_template_directory_uri() . '/lib/live-countdown/css/livecountdown.css');
			wp_enqueue_script('jquery.livecountdown',  get_template_directory_uri() . '/lib/live-countdown/javascript/jquery.livecountdown.js');
		endif;
	} // end constructor
	
	/*--------------------------------------------------*/
	/* API Functions
	/*--------------------------------------------------*/
	
	function widget($args, $instance) {
		
		extract($args, EXTR_SKIP);
		
		echo $before_widget;

		$month = empty($instance['month']) ? '&nbsp;' : apply_filters('widget_month', $instance['month']);
		$day = empty($instance['day']) ? '&nbsp;' : apply_filters('widget_day', $instance['day']);
		$year = empty($instance['year']) ? '&nbsp;' : apply_filters('widget_year', $instance['year']);
		$hour = empty($instance['hour']) ? '&nbsp;' : apply_filters('widget_hour', $instance['hour']);
		$minute = empty($instance['minute']) ? '&nbsp;' : apply_filters('widget_minute', $instance['minute']);
		$ampm = empty($instance['ampm']) ? '&nbsp;' : apply_filters('widget_ampm', $instance['ampm']);
		$timezone = empty($instance['timezone']) ? '&nbsp;' : apply_filters('widget_timezone', $instance['timezone']);
		
		?>
		<div class="live_countdown_container">
			<span class="live_countdown_display">
				<span class="live_countdown_live">
					<?php _e('Live In', 'livetheme'); ?>
				</span>
				<span class="live_countdown_days_left lt_num"></span>
				<span class="live_countdown_days_label lt_label">
					<?php _e(" Days", "livetheme"); ?>
				</span>
				<span class="live_countdown_hours_left lt_num"></span>
				<span class="live_countdown_hours_label lt_label">
					<?php _e(" Hrs", "livetheme"); ?>
				</span>
				<span class="live_countdown_minutes_left lt_num"></span>
				<span class="live_countdown_minutes_label lt_label">
					<?php _e(" Min", "livetheme"); ?>
				</span>
				<span class="live_countdown_seconds_left lt_num"></span>
				<span class="live_countdown_seconds_label lt_label">
					<?php _e(" Sec", "livetheme"); ?>
				</span>
				<span style="display:block;clear:both;"></span>
			</span>
			<div class="live_countdown_control" style="display:none;">
				<span class="live_countdown_live">Live In</span>
				<span class="live_countdown_month"><?php echo $month; ?></span>
				<span class="live_countdown_day"><?php echo $day; ?></span>
				<span class="live_countdown_year"><?php echo $year; ?></span>
				<span class="live_countdown_hour"><?php echo $hour; ?></span>
				<span class="live_countdown_minute"><?php echo $minute; ?></span>
				<span class="live_countdown_ampm"><?php echo $ampm; ?></span>
				<span class="live_countdown_timezone"><?php echo $timezone; ?></span>
			</div>
		</div>
		<?php
		
		echo $after_widget;
		
	} // end widget
	
	function update($new_instance, $old_instance) {
	
		$instance = $old_instance;
		
		$instance['month'] = strip_tags(stripslashes($new_instance['month']));
		$instance['day'] = strip_tags(stripslashes($new_instance['day']));
		$instance['year'] = strip_tags(stripslashes($new_instance['year']));
		$instance['hour'] = strip_tags(stripslashes($new_instance['hour']));
		$instance['minute'] = strip_tags(stripslashes($new_instance['minute']));
		$instance['ampm'] = strip_tags(stripslashes($new_instance['ampm']));
		$instance['timezone'] = strip_tags(stripslashes($new_instance['timezone']));
		
		return $instance;
		
	} // end update
	
	function form($instance) {
		
		$instance = wp_parse_args(
			(array)$instance,
			array(
				'month' => '',
				'day' => '',
				'year' => '',
				'hour' => '',
				'minute' => '',
				'ampm' => '',
				'timezone' => ''
			)
		);
		
		$month = strip_tags(stripslashes($instance['month']));
		$day = strip_tags(stripslashes($instance['day']));
		$year = strip_tags(stripslashes($instance['year']));
		$hour = strip_tags(stripslashes($instance['hour']));
		$minute = strip_tags(stripslashes($instance['minute']));
		$ampm = strip_tags(stripslashes($instance['ampm']));
		$timezone = strip_tags(stripslashes($instance['timezone']));
		
	?>
		<p>
			<label for="date" style="display:block;">
				<?php _e("Date", "standardtheme"); ?>
			</label>
			<select id="<?php echo $this->get_field_id('month'); ?>" name="<?php echo $this->get_field_name('month'); ?>" class="live_countdown_month" onchange="_setup();">
				<?php for($i = 1; $i <= 12; $i++): ?>
						<option <?php if($i == $instance['month']): echo 'selected="selected"'; endif; ?> value="<?php echo $i; ?>">
							<?php echo $this->get_month($i); ?>
						</option>
				<?php endfor; ?>
			</select>
			<select id="<?php echo $this->get_field_id('day'); ?>" name="<?php echo $this->get_field_name('day'); ?>" class="live_countdown_day" onchange="_setup();">
				<?php for($i = 1; $i <= 31; $i++): ?>
					<option <?php if($i == $instance['day']): echo 'selected="selected"'; endif; ?> value="<?php echo $i; ?>">
						<?php echo $i; ?> 
					</option>
				<?php endfor; ?>
			</select>
			<select id="<?php echo $this->get_field_id('year'); ?>" name="<?php echo $this->get_field_name('year'); ?>" class="live_countdown_year" onchange="_setup();">
				<?php for($i = 2010; $i <= 2025; $i++): ?>
					<option <?php if($i == $instance['year']): echo 'selected="selected"'; endif; ?> value="<?php echo $i; ?>">
						<?php echo $i; ?>
					</option>
				<?php endfor; ?>
			</select>
		</p>
		<p>
			<label for="time" style="display:block;">
				<?php _e("Time", "standardtheme"); ?>
			</label>
			<select id="<?php echo $this->get_field_id('hour'); ?>" name="<?php echo $this->get_field_name('hour'); ?>">
				<?php for($i = 1; $i <= 12; $i++): ?>
						<option <?php if($i == $instance['hour']): echo 'selected="selected"'; endif; ?> value="<?php echo $i; ?>">
							<?php echo $i; ?>
						</option>
				<?php endfor; ?>
			</select>
			<select id="<?php echo $this->get_field_id('minute'); ?>" name="<?php echo $this->get_field_name('minute'); ?>">
				<?php for($i = 1; $i <= 60; $i++): ?>
						<option <?php if($i == $instance['minute']): echo 'selected="selected"'; endif; ?> value="<?php echo $i; ?>">
							<?php 
								if(($i - 1) < 10): 
									echo '0' . (string)($i - 1);
								else:
									echo $i - 1;
								endif;
						?>
						</option>
				<?php endfor; ?>
			</select>
			<select id="<?php echo $this->get_field_id('ampm'); ?>" name="<?php echo $this->get_field_name('ampm'); ?>">
				<option <?php if('AM' == $instance['ampm']): echo 'selected="selected"'; endif; ?> value="AM">
					<?php _e('AM', "standardtheme"); ?>
				</option>
				<option <?php if('PM' == $instance['ampm']): echo 'selected="selected"'; endif; ?> value="PM">
					<?php _e('PM', "standardtheme"); ?>
				</option>
			</select>
			<input type="hidden" id="<?php echo $this->get_field_id('timezone'); ?>" name="<?php echo $this->get_field_name('timezone'); ?>" value="<?php echo $instance['timezone']; ?>" class="live_countdown_timezone" />
			</span>
		</p>
		
	<?php
	} // end form
	
	/*--------------------------------------------------*/
	/* Helper Functions
	/*--------------------------------------------------*/
	
	function get_month($num_month) {
		$str_month = '';
		switch($num_month) {
			case 1:
				$str_month = 'January';
				break;
			case 2:
				$str_month = 'February';
				break;
			case 3:
				$str_month = 'March';
				break;
			case 4:
				$str_month = 'April';
				break;
			case 5:
				$str_month = 'May';
				break;
			case 6:
				$str_month = 'June';
				break;
			case 7:
				$str_month = 'July';
				break;
			case 8:
				$str_month = 'August';
				break;
			case 9:
				$str_month = 'September';
				break;
			case 10:
				$str_month = 'October';
				break;
			case 11:
				$str_month = 'November';
				break;
			case 12:
				$str_month = 'December';
				break;
			default:
				break;
		}
		return $str_month;
	} // end get_month
	
} // end class
add_action('widgets_init', create_function('', 'return register_widget("Live_Countdown_Widget");'));