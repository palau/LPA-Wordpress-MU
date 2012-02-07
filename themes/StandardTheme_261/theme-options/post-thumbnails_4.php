<?php

$options = array (

	array(	"name" => __("Post Thumbnails on your Blog", "standardtheme"),
			"desc" => __("Do you want to display post thumbnails on your blog?", "standardtheme"),
			"id" => "post_thumb",
			"type" => "select",
			"default_text" => __("No","standardtheme"),
			"options" => array(
				__("Yes", "standardtheme") => "yes"
			)

	),
	
	array(	"name" => __("Post Thumbnails in Single View", "standardtheme"),
			"desc" => __("Do you want to display post thumbnails on single posts?", "standardtheme"),
			"id" => "post_thumb_single",
			"type" => "select",
			"default_text" => __("No","standardtheme"),
			"options" => array(
				__("Yes", "standardtheme") => "yes"
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