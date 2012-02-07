<?php

$options = array (
	
	array(	"name" => __("Enable CSS3 Effects?", "standardtheme"),
			"desc" => __("Enable CSS3-based visual effects on the default theme?", "standardtheme"),
			"id" => "disable_css3_effects",
			"type" => "select",
			"default_text" => __("Yes", "standardtheme"),
			"options" => array(
				__("No", "standardtheme") => "no",
			)
	),
	
	array(	"name" => __("Place Navigation Below The Header?", "standardtheme"),
			"desc" => __("Display the navigation bar between the header and the content?", "standardtheme"),
			"id" => "adjusted_navigation",
			"type" => "select",
			"default_text" => __("No", "standardtheme"),
			"options" => array(
				__("Yes", "standardtheme") => "yes",
			)
	),
	
	array(	"name" => __("Use Large Social Icons?", "standardtheme"),
			"desc" => __("Do you want to use larger images of social icons?", "standardtheme"),
			"id" => "large_social_icons",
			"type" => "select",
			"default_text" => __("No", "standardtheme"),
			"options" => array(
				__("Yes", "standardtheme") => "yes",
			)
	),
	
	array(	"name" => __("Place The Sidebar on the Left?", "standardtheme"),
			"desc" => __("Move the sidebar to the left of the content?", "standardtheme"),
			"id" => "adjusted_sidebar",
			"type" => "select",
			"default_text" => __("No", "standardtheme"),
			"options" => array(
				__("Yes", "standardtheme") => "yes",
			)
	),
	
	array(	"name" => __("Include WordPress 3.0 Background Support?", "standardtheme"),
	        "desc" => __("Would you like to enable WordPress 3.0 background color and image support?", "standardtheme"),
	        "id" => "wp3backgrounds",
	        "type" => "select",
	        "default_text" => __("No", "standardtheme"),
	        "options" => array(
				__("Yes", "standardtheme") => "yes",
			)
	),
	
	array(	"name" => __("Hide Navigatation Menu in the Footer?", "standardtheme"),
					"desc" => __("Would you like to hide the footer navigation menu?", "standardtheme"),
					"id" => "hide_footer_navigation",
	        "type" => "select",
	        "default_text" => __("No", "standardtheme"),
	        "options" => array(
				__("Yes", "standardtheme") => "yes",
			)
	)
	
);

/* ------------ Do not edit below this line ----------- */

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