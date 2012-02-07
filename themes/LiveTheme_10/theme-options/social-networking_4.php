<?php

$options = array (
	
	array(	"name" => __("'Tweet This!' Text", "livetheme"),
			"desc" => __("This is the auto-fill text that will be entered when users click the \"Tweet This!\" button.", "livetheme"),
			"id" => "tweet_this_text",
			"type" => "textarea"
	),
	
	/*-*/
	
	array("name" => __("Social Network #1 Icon", "livetheme"),
		"desc" => __("Upload or select a social icon from the Live Theme gallery", "livetheme"),
		"id" => "social_icon_1",
		"type" => "image",
		"value" => "Upload Social Icon",
		"url" => get_bloginfo('stylesheet_directory')."/images/icn-facebook-32.png"
	),
	
	array(	"name" => __("Social Network #1 Destination", "livetheme"),
			"desc" => __("Enter the URL for this social icon.<br /><br />The social network icon will only show if there is a destination entered.", "livetheme"),
			"id"=> "social_url_1",
			"type" => "text",
			"value" => ""
	),
	
	/*-*/
	
	array("name" => __("Social Network #2 Icon", "livetheme"),
		"desc" => __("Upload or select a social icon from the Live Theme gallery", "livetheme"),
		"id" => "social_icon_2",
		"type" => "image",
		"value" => "Upload Social Icon",
		"url" => get_bloginfo('stylesheet_directory')."/images/icn-twitter-32.png"
	),
	
	array(	"name" => __("Social Network #2 Destination", "livetheme"),
			"desc" => __("Enter the URL for this social icon.<br /><br />The social network icon will only show if there is a destination entered.", "livetheme"),
			"id"=> "social_url_2",
			"type" => "text",
			"value" => ""
	),
	
	/*-*/
	
	array("name" => __("Social Network #3 Icon", "livetheme"),
		"desc" => __("Upload or select a social icon from the Live Theme gallery", "livetheme"),
		"id" => "social_icon_3",
		"type" => "image",
		"value" => "Upload Social Icon",
		"url" => get_bloginfo('stylesheet_directory')."/images/icn-flickr-32.png"
	),
	
	array(	"name" => __("Social Network #3 Destination", "livetheme"),
			"desc" => __("Enter the URL for this social icon.<br /><br />The social network icon will only show if there is a destination entered.", "livetheme"),
			"id"=> "social_url_3",
			"type" => "text",
			"value" => ""
	),
	
	/*-*/
	
	array("name" => __("Social Network #4 Icon", "livetheme"),
		"desc" => __("Upload or select a social icon from the Live Theme gallery", "livetheme"),
		"id" => "social_icon_4",
		"type" => "image",
		"value" => "Upload Social Icon",
		"url" => get_bloginfo('stylesheet_directory')."/images/icn-dig-32.png",
	),
	
	array(	"name" => __("Social Network #4 Destination", "livetheme"),
			"desc" => __("Enter the URL for this social icon.<br /><br />The social network icon will only show if there is a destination entered.", "livetheme"),
			"id"=> "social_url_4",
			"type" => "text",
			"value" => ""
	),
	
	/*-*/
	
	array("name" => __("Social Network #5 Icon", "livetheme"),
		"desc" => __("Upload or select a social icon from the Live Theme gallery", "livetheme"),
		"id" => "social_icon_5",
		"type" => "image",
		"value" => "Upload Social Icon",
		"url" => get_bloginfo('stylesheet_directory')."/images/icn-sharethis-32.png"
	),
	
	array(	"name" => __("Social Network #5 Destination", "livetheme"),
			"desc" => __("Enter the URL for this social icon.<br /><br />The social network icon will only show if there is a destination entered.", "livetheme"),
			"id"=> "social_url_5",
			"type" => "text",
			"value" => ""
	
	),
	
	/*-*/
	
	array("name" => __("Social Network #6 Icon", "livetheme"),
		"desc" => __("Upload or select a social icon from the Live Theme gallery", "livetheme"),
		"id" => "social_icon_6",
		"type" => "image",
		"value" => "Upload Social Icon",
		"url" => get_bloginfo('stylesheet_directory')."/images/icn-rss-32.png"
	),
	
	array(	"name" => __("Social Network #6 Destination", "livetheme"),
			"desc" => __("Enter the URL for this social icon.<br /><br />The social network icon will only show if there is a destination entered.", "livetheme"),
			"id"=> "social_url_6",
			"type" => "text",
			"value" => ""
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