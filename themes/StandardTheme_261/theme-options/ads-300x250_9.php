<?php

$options = array (

	array(	"name" => __("Advertisement Image #1", "standardtheme"),
			"desc" => __("Upload the image for this advertisement.", "standardtheme"),
			"id" => "ad_300_image",
			"type" => "image",
			"value" => "Upload 300x250px Advertisement #1",
			"url" => get_bloginfo('template_directory')."/admin/images/300-1.jpg"
	),

	array(	"name" => __("Adsense Code #1", "standardtheme"),
			"desc" => __("Enter the adsense code for this advertisement.", "standardtheme"),
			"id" => "ad_300_adsense",
			"type" => "textarea"
	),

	array(	"name" => __("Advertisement Destination #1", "standardtheme"),
			"desc" => __("Specify the destination URL for this advertisement.", "standardtheme"),
			"id" => "ad_300_url",
			"type" => "text",
			"std" => ""
	),
	
	array(	"name" => __("Advertisement Image #2", "standardtheme"),
			"desc" => __("Upload the image for this advertisement.", "standardtheme"),
			"id" => "ad_300_image2",
			"type" => "image",
			"value" => "Upload 300x250px Advertisement #2",
			"url" => get_bloginfo('template_directory')."/admin/images/300-2.jpg"
	),

	array(	"name" => __("Adsense Code #2", "standardtheme"),
			"desc" => __("Enter the adsense code for this advertisement.", "standardtheme"),
			"id" => "ad_300_adsense2",
			"type" => "textarea"
	),

	array(	"name" => __("Advertisement Destination #2", "standardtheme"),
			"desc" => __("Specify the destination URL for this advertisement.", "standardtheme"),
			"id" => "ad_300_url2",
			"type" => "text",
			"std" => ""
	),
	
	array(	"name" => __("Advertisement Image #3", "standardtheme"),
			"desc" => __("Upload the image for this advertisement.", "standardtheme"),
			"id" => "ad_300_image3",
			"type" => "image",
			"value" => "Upload 300x250px Advertisement #3",
			"url" => get_bloginfo('template_directory')."/admin/images/300-3.jpg"
	),

	array(	"name" => __("Adsense Code #3", "standardtheme"),
			"desc" => __("Enter the adsense code for this advertisement.", "standardtheme"),
			"id" => "ad_300_adsense3",
			"type" => "textarea"
	),

	array(	"name" => __("Advertisement Destination #3", "standardtheme"),
			"desc" => __("Specify the destination URL for this advertisement.", "standardtheme"),
			"id" => "ad_300_url3",
			"type" => "text",
			"std" => "http://standardtheme.com"
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