<?php

$options = array (

	array(	"name" => __("Video Embed Code", "livetheme"),
			"desc" => __("Enter the embed code for your video feed.<br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_embed_code",
			"type" => "textarea"
	),
	
	array(	"name" => __("Display Video Bumpers Or Video Stream?", "livetheme"),
			"desc" => __('When configured for "Video Stream," the bumpers will show until the Live Countdown widget expires and then the video stream will show.<br /><br />When configured for "Video Bumpers," the bumpers will be displayed unconditionally.', "livetheme"),
			"id" => "display_video_bumpers",
			"type" => "select",
			"default_text" => __("Video Stream", "livetheme"),
			"options" => array(
				__("Video Bumpers", "livetheme") => "Yes",
			)
	),

	array(	"name" => __("Video Bumper #1 Image", "livetheme"),
			"desc" => __("Upload an image for this video bumper. <br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_bumper_1",
			"type" => "image",
			"value" => "Upload Video Bumper",
			"url" => get_bloginfo('stylesheet_directory')."/images/default_bumper1.jpg"
	),

	array(	"name" => __("Video Bumper #1 Destination", "livetheme"),
			"desc" => __("Specify the destination for this video bumper.<br /><br />The bumper will only show if there is a destination entered.", "livetheme"),
			"id" => "video_bumper_1_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
	
	array(	"name" => __("Video Bumper #2 Image", "livetheme"),
			"desc" => __("Upload an image for this video bumper. <br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_bumper_2",
			"type" => "image",
			"value" => "Upload Video Bumper",
			"url" => get_bloginfo('stylesheet_directory')."/images/default_bumper2.jpg"
	),

	array(	"name" => __("Video Bumper #2 Destination", "livetheme"),
			"desc" => __("Specify the destination for this video bumper.<br /><br />The bumper will only show if there is a destination entered.", "livetheme"),
			"id" => "video_bumper_2_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
	
		array(	"name" => __("Video Bumper #3 Image", "livetheme"),
			"desc" => __("Upload an image for this video bumper. <br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_bumper_3",
			"type" => "image",
			"value" => "Upload Video Bumper",
			"url" => get_bloginfo('stylesheet_directory')."/images/default_bumper3.jpg"
	),

	array(	"name" => __("Video Bumper #3 Destination", "livetheme"),
			"desc" => __("Specify the destination for this video bumper.<br /><br />The bumper will only show if there is a destination entered.", "livetheme"),
			"id" => "video_bumper_3_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
	
		array(	"name" => __("Video Bumper #4 Image", "livetheme"),
			"desc" => __("Upload an image for this video bumper. <br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_bumper_4",
			"type" => "image",
			"value" => "Upload Video Bumper",
			"url" => get_bloginfo('stylesheet_directory')."/images/default_bumper4.jpg"
	),

	array(	"name" => __("Video Bumper #4 Destination", "livetheme"),
			"desc" => __("Specify the destination for this video bumper.<br /><br />The bumper will only show if there is a destination entered.", "livetheme"),
			"id" => "video_bumper_4_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
	
		array(	"name" => __("Video Bumper #5 Image", "livetheme"),
			"desc" => __("Upload an image for this video bumper. <br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_bumper_5",
			"type" => "image",
			"value" => "Upload Video Bumper",
			"url" => get_bloginfo('stylesheet_directory')."/images/default_bumper1.jpg"
	),

	array(	"name" => __("Video Bumper #5 Destination", "livetheme"),
			"desc" => __("Specify the destination for this video bumper.<br /><br />The bumper will only show if there is a destination entered.", "livetheme"),
			"id" => "video_bumper_5_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
	
		array(	"name" => __("Video Bumper #6 Image", "livetheme"),
			"desc" => __("Upload an image for this video bumper. <br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_bumper_6",
			"type" => "image",
			"value" => "Upload Video Bumper",
			"url" => get_bloginfo('stylesheet_directory')."/images/default_bumper2.jpg"
	),

	array(	"name" => __("Video Bumper #6 Destination", "livetheme"),
			"desc" => __("Specify the destination for this video bumper.<br /><br />The bumper will only show if there is a destination entered.", "livetheme"),
			"id" => "video_bumper_6_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
	
		array(	"name" => __("Video Bumper #7 Image", "livetheme"),
			"desc" => __("Upload an image for this video bumper. <br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_bumper_7",
			"type" => "image",
			"value" => "Upload Video Bumper",
			"url" => get_bloginfo('stylesheet_directory')."/images/default_bumper3.jpg"
	),

	array(	"name" => __("Video Bumper #7 Destination", "livetheme"),
			"desc" => __("Specify the destination for this video bumper.<br /><br />The bumper will only show if there is a destination entered.", "livetheme"),
			"id" => "video_bumper_7_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
	
		array(	"name" => __("Video Bumper #8 Image", "livetheme"),
			"desc" => __("Upload an image for this video bumper. <br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_bumper_8",
			"type" => "image",
			"value" => "Upload Video Bumper",
			"url" => get_bloginfo('stylesheet_directory')."/images/default_bumper4.jpg"
	),

	array(	"name" => __("Video Bumper #8 Destination", "livetheme"),
			"desc" => __("Specify the destination for this video bumper.<br /><br />The bumper will only show if there is a destination entered.", "livetheme"),
			"id" => "video_bumper_8_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
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