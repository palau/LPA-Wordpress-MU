<?php

$options = array (

	array(	"name" => __("Twitter", "standardtheme"),
			"desc" => __("Do you want to display the Twitter Button on your posts?", "standardtheme"),
			"id" => "tweetmeme_sharer",
			"type" => "select",
			"default_text" => __("No", "standardtheme"),
			"options" => array(
				__("Yes", "standardtheme") => "Yes",
			)
	),

	array(	"name" => __("Facebook", "standardtheme"),
			"desc" => __("Do you want to display the Facebook Share button on your posts?", "standardtheme"),
			"id" => "facebook_sharer",
			"type" => "select",
			"default_text" => __("No", "standardtheme"),
			"options" => array(
				__("Yes", "standardtheme") => "Yes"
			)
	),
	
	array(	"name" => __("AddThis", "standardtheme"),
			"desc" => __("Do you you want to display the AddThis Global Sharer button on your posts?", "standardtheme"),
			"id" => "addthis_sharer",
			"type" => "select",
			"default_text" => __("No", "standardtheme"),
			"options" => array(
				__("Yes", "standardtheme") => "Yes"
			)
	),
	
	array(	"name" => __("Twitter", "standardtheme"),
			"desc" => __("http://twitter.com/<strong>username</strong>", "standardtheme"),
			"id"=> "twitter",
			"type" => "text"
	),
	
	array(	"name" => __("Facebook", "standardtheme"),
			"desc" => __("http://facebook.com/<strong>username</strong>", "standardtheme"),
			"id"=> "facebook",
			"type" => "text"
	),
	
	array(	"name" => __("LinkedIn", "standardtheme"),
			"desc" => __("http://linkedin.com/in/<strong>username</strong>", "standardtheme"),
			"id"=> "linkedin",
			"type" => "text"
	),
	
	array(	"name" => __("Posterous", "standardtheme"),
			"desc" => __("The full URL (or custom URL) to your Posterous account.", "standardtheme"),
			"id"=> "posterous",
			"type" => "text"
	),
	
	array(	"name" => __("Vimeo", "standardtheme"),
			"desc" => __("http://vimeo.com/<strong>username</strong>", "standardtheme"),
			"id"=> "vimeo",
			"type" => "text"
	),
	
	array(	"name" => __("YouTube", "standardtheme"),
			"desc" => __("http://youtube.com/<strong>username</strong>", "standardtheme"),
			"id"=> "youtube",
			"type" => "text"
	),
	
	array(	"name" => __("Digg", "standardtheme"),
			"desc" => __("http://digg.com/users/<strong>username</strong>", "standardtheme"),
			"id"=> "digg",
			"type" => "text"
	),
	
	array(	"name" => __("Flickr", "standardtheme"),
			"desc" => __("http://flickr.com/photos/<strong>username</strong>", "standardtheme"),
			"id"=> "flickr",
			"type" => "text"
	),
	
	array(	"name" => __("FriendFeed", "standardtheme"),
			"desc" => __("http://friendfeed.com/<strong>username</strong>", "standardtheme"),
			"id"=> "friendfeed",
			"type" => "text"
	),
	
	array(	"name" => __("LastFM", "standardtheme"),
			"desc" => __("http://last.fm/user/<strong>username</strong>", "standardtheme"),
			"id"=> "lastfm",
			"type" => "text"
	),

	array(	"name" => __("MySpace", "standardtheme"),
			"desc" => __("http://myspace.com/<strong>username</strong>", "standardtheme"),
			"id"=> "myspace",
			"type" => "text"
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