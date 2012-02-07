<?php

$options = array (

	array(	"name" => __("Display Author Box", "standardtheme"),
			"desc" => __("Do you want to display an author biography box at the bottom of each post?", "standardtheme"),
			"id" => "author_box",
			"type" => "select",
			"default_text" => __("No", "standardtheme"),
			"options" => array(
				__("Yes", "standardtheme") => "yes"
			),
	),
	
	array(	"name" => __("Display Website Link?", "standardtheme"),
			"desc" => __("Do you want to provide a link to the author's website?", "standardtheme"),
			"id" => "author_box_website",
			"type" => "select",
			"default_text" => __("No", "standardtheme"),
			"options" => array(
				__("Yes", "standardtheme") => "yes"
			),
	),
	
	array(	"name" => __("Display Twitter Link?", "standardtheme"),
			"desc" => __("Do you want to provide a link to the author's Twitter account?", "standardtheme"),
			"id" => "author_box_twitter",
			"type" => "select",
			"default_text" => __("No", "standardtheme"),
			"options" => array(
				__("Yes", "standardtheme") => "yes"
			),
	),
	
	array(	"name" => __("Display Facebook Link?", "standardtheme"),
			"desc" => __("Do you want to provide a link to the author's Facebook page?", "standardtheme"),
			"id" => "author_box_facebook",
			"type" => "select",
			"default_text" => __("No", "standardtheme"),
			"options" => array(
				__("Yes", "standardtheme") => "yes"
			),
	),
	
	array(	"name" => __("Display Share By Link?", "standardtheme"),
			"desc" => __("Do you want to provide a link to share a post via email?", "standardtheme"),
			"id" => "author_box_email",
			"type" => "select",
			"default_text" => __("No", "standardtheme"),
			"options" => array(
				__("Yes", "standardtheme") => "yes"
			),
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