<?php

$options = array (

	array(	"name" => __("Display blog title in place of custom logo?", "standardtheme"),
            "desc" => __("Would you rather display the title of your blog instead of a custom logo?", "standardtheme"),
            "id" => "text_header",
            "type" => "select",
            "default_text" => __("No", "standardtheme"),
            "options" => array(
				__("Yes", "standardtheme") => "yes",
			)
	),
	
	array(	"name" => __("Custom Logo", "standardtheme"),
            "desc" => __("Upload a logo for your theme.", "standardtheme"),
            "id" => "logo",
            "type" => "image",
            "value" => "Upload Custom Logo",
            "url" => get_bloginfo('stylesheet_directory')."/images/logo.png"
	),
    
	array(	"name" => __("Custom Favicon","standardtheme"),
			"desc" => __("Upload a 16px x 16px PNG/JPG image.", "standardtheme"),
			"id" => "custom_favicon",
			"type" => "image",
			"value" => "Upload Custom Favicon",
			"url" => get_bloginfo('stylesheet_directory')."/images/standardicon.png"
	),
	
	array(	"name" => __("Personal Image","standardtheme"),
			"desc" => __("Upload a personal image (300px wide).", "standardtheme"),
			"id" => "personal_image",
			"type" => "image",
			"value" => "Upload Personal Image",
			"url" => get_bloginfo('stylesheet_directory')."/admin/images/personal_image.jpg",
	),
	
	array(	"name" => __("Personal Image Link","standardtheme"),
			"desc" => __("The URL to which your personal image links.", "standardtheme"),
			"id" => "personal_image_url",
			"type" => "text"
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