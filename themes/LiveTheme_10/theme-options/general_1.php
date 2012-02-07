<?php

$options = array (

	array(	"name" => __("Display blog title or custom logo?", "livetheme"),
            "desc" => __("Should the header show the configured title of your blog or the custom logo specified below?", "livetheme"),
            "id" => "text_header",
            "type" => "select",
            "default_text" => __("Logo", "livetheme"),
            "options" => array(
				__("Title", "livetheme") => "yes",
			)
	),
	
	array(	"name" => __("Custom Logo", "livetheme"),
            "desc" => __("Upload a logo for your event.", "livetheme"),
            "id" => "logo",
            "type" => "image",
            "value" => "Upload Custom Logo",
            "url" => get_bloginfo('stylesheet_directory')."/images/logo.png"
	),
    
	array(	"name" => __("Custom Favicon","livetheme"),
			"desc" => __("Upload a 16px x 16px PNG/JPG image.", "livetheme"),
			"id" => "custom_favicon",
			"type" => "image",
			"value" => "Upload Custom Favicon",
			"url" => get_bloginfo('stylesheet_directory')."/images/favicon.png"
	),
	
	array(	"name" => __("Tabbed Pages", "livetheme"),
			"desc" => __("Select the pages to include on the tabbed navigation of the homepage.<br><br><small>(Command/Control + Select to choose multiple)</small>", "livetheme"),
			"id" => "featured_tabs",
			"type" => "page_include",
			"type" => "pages"
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