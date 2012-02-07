<?php

$options = array (

	array(	"name" => __("Advertisement Image", "standardtheme"),
			"desc" => __("Upload the image for the 468x60 advertisement.", "standardtheme"),
			"id" => "ad_468_image",
			"type" => "image",
			"value" => "Upload 468x60 Advertisement",
			"url" => get_bloginfo('template_directory')."/admin/images/468-1.jpg"
	),

	array(	"name" => __("Adsense Code", "standardtheme"),
			"desc" => __("Enter the adsense code for your 468x60 advertisement.", "standardtheme"),
			"id" => "ad_468_adsense",
			"type" => "textarea"
	),

	array(	"name" => __("Advertisement Destination", "standardtheme"),
			"desc" => __("Specify the destination URL for your advertisement.", "standardtheme"),
			"id" => "ad_468_url",
			"type" => "text",
			"std" => ""
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