<?php

$options = array (

	array(	"name" => __("Display blog title or custom logo?", "livetheme"),
            "desc" => __("Should the header show the configured title of your blog or the custom logo specified below?", "livetheme"),
            "id" => "text_header",
            "type" => "select",
            "default_text" => __("Logo", "livetheme"),
            "options" => array(
				__("Title", "livetheme") => "yes",
			)
	),
	
	array(	"name" => __("Custom Logo", "livetheme"),
            "desc" => __("Upload a logo for your event.", "livetheme"),
            "id" => "logo",
            "type" => "image",
            "value" => "Upload Custom Logo",
            "url" => get_bloginfo('template_directory')."/images/logo.png"
	),
    
	array(	"name" => __("Custom Favicon","livetheme"),
			"desc" => __("Upload a 16px x 16px PNG/JPG image.", "livetheme"),
			"id" => "custom_favicon",
			"type" => "image",
			"value" => "Upload Custom Favicon",
			"url" => get_bloginfo('template_directory')."/images/favicon.png"
	),
	
  array(	
    "name" => __("Custom Social Tab Title", "livetheme"),
    "desc" => __("The social tab area next to the video can contain a custom tab for a widget of your choosing. Dimensions: 276 x 306px.", "livetheme"),
		"id" => "custom_tab_text",
		"type" => "text",
		"std" => ""
	),
  
  array(	
    "name" => __("Take video offline?", "livetheme"),
		"desc" => __('If your video feed is complete, select "yes" and save. Viewers browsers will be forced to refresh based on the polling interval below, bringing your image bumpers or video archives back up. <br/><br/>You must also reconfigure the countdown widget.', "livetheme"),
		"id" => "is_offline",
		"type" => "select",
		"default_text" => __("No", "livetheme"),
		"options" => array(
			__("Yes", "livetheme") => "yes",
		)
	),
  
  array(	
    "name" => __("Specify the polling interval", "livetheme"),
    "desc" => __("How long (in minutes) should the site wait before checking to see if it should refresh?", "livetheme"),
    "id" => "polling_interval",
    "type" => "select",
    "default_text" => __("Off", "livetheme"),
    "options" => get_polling_duration()
  ),
  
  array(
		"name" => __("Color Scheme", "standardtheme"),
		"desc" => __("Pick a color scheme with which to style your blog.", "standardtheme"),
		"id" => "livetheme_style",
		"type" => "select",
		"default_text" => __("Default", "standardtheme"),
		"options" => load_styles_into_array()
	),
	
);

/* ------------ Do not edit below this line ----------- */

/**
 * Returns an array of all stylesheets located in ProPhoto's styles
 * directory.
 */
function load_styles_into_array() {

	$arr_styles = array();
	$handle = opendir(dirname(dirname(__FILE__)) . '/styles');
	while(false !== ($file = readdir($handle))) {
		if($file != '.' && $file != '..' && strpos($file, '.') && strtolower($file) !== 'default.css') {
			$filename = substr($file, 0, strpos($file, '.'));
			$arr_styles[ucfirst($filename)] = strtolower($filename);
		} // end if
	} // end while

	return $arr_styles;

} // end load_styles_into_array

/**
 * Creates an array of seconds to be used to select how long each
 * bumper should display.
 */
function get_polling_duration() {

  $durations = array();
  
  $durations[5] = 5;
  $durations[10] = 10;
  $durations[15] = 15;
  for($i = 60; $i <= 180; $i += 30) {
    $durations[$i] = $i;
  } // end for
  
  return $durations;

} // end get_bumper_durations

//Check if theme options set
global $default_check;
global $default_options;

if(!$default_check):
    foreach($options as $option):
        if($option['type'] != 'image'):
            $default_options[$option['id']] = $option['value'];
        else:
            $default_options[$option['id']] = $option['url'];
        endif;
    endforeach;
    $update_option = get_option('standard_framework_'.STANDARD_FRAMEWORK_SHORT_NAME);
    if(is_array($update_option)):
        $update_option = array_merge($update_option, $default_options);
        update_option('standard_framework_'.STANDARD_FRAMEWORK_SHORT_NAME, $update_option);
    else:
        update_option('standard_framework_'.STANDARD_FRAMEWORK_SHORT_NAME, $default_options);
    endif;
endif;

render_options($options);
?>