<?php

$options = array (

	array(	"name" => __("Display Allowed Comments Markup?", "standardtheme"),
			"desc" => __("Do you want to display the allowed HTML tags for your comments?", "standardtheme"),
			"id" => "comment_shortcodes",
			"type" => "select",
			"default_text" => __("No", "standardtheme"),
			"options" => array(
				__("Yes", "standardtheme") => "yes",
			)
	),
	
	array(	"name" => __("Default Gravatar Image", "standardtheme"),
			"desc" => __("Upload an image that you wish to display as your default gravatar image. ", "standardtheme"),
			"id" => "gravatar_image",
			"type" => "image",
			"value" => "Upload Gravatar Image",
            "url" => get_bloginfo('stylesheet_directory')."/admin/images/blank-gravatar.jpg"
	),
	
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