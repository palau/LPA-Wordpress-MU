<?php

$options = array (

	array(	"name" => __("RSS Feed", "standardtheme"),
			"desc" => __("Enter the address of your blog's RSS feed (such as FeedBurner).", "standardtheme"),
			"id" => "feedburner_url",
			"type" => "text"
	),
	
	array(	"name" => __("FeedBurner Email", "standardtheme"),
			"desc" => __("Enter the address of your FeedBurner email feed.", "standardtheme"),
			"id" => "feedburneremail",
			"type" => "text"
	),
	
	array(	"name" => __("Google Tracking Code", "standardtheme"),
			"desc" => __("Paste your Google Tracking code here. Note that, this will be added to the <em>header</em> of your blog.", "standardtheme"),
			"id" => "google_asynchronous_analytics",
			"type" => "textarea"
	),
	
	array(	"name" => __("Other Tracking Code", "standardtheme"),
			"desc" => __("Paste your other analytics tracking code here. Note that, this will be added to the <em>footer</em> of your blog.", "standardtheme"),
			"id" => "other_analytics",
			"type" => "textarea"
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