<?php

$options = array (

	array(	"name" => __("Enable WordPress 3.0 Custom Menus?", "livetheme"),
			"desc" => __("This will add the WordPress \"Menus\" link under the Appearance section in the navigation bar.<br /><br />Custom menu hierarchy / nesting is not supported. Only top-level menu items will be displayed.", "livetheme"),
			"id" => "wp3menu",
			"type" => "select",
			"default_text" => __("No", "livetheme"),
			"options" => array(
				__("Yes", "livetheme") => "Yes",
			)
	),
	
	array(	"name" => __("Exclude Pages From Navigation Menu", "livetheme"),
			"desc" => __("Select the pages to exclude from your navigation menu. Excluding a top-level page excludes child pages.<br /><br /><small>(Command/Control + Select to choose multiple)</small>", "livetheme"),
			"id" => "page_exclude",
			"type" => "pages"
	),
	
	array(	"name" => __("Exclude Categories From Navigation Menu", "livetheme"),
			"desc" => __("Select the categories to exclude from your navigation menu. Excluding a top-level page excludes child categories.<br><br><small>(Command/Control + Select to choose multiple)</small>", "livetheme"),
			"id" => "category_exclude",
			"type" => "categories"
	),
	
	array(	"name" => __("Display Footer Navigation", "livetheme"),
			"desc" => __("Show the navigation menu in the footer?", "livetheme"),
			"id" => "show_footer_navigation",
			"type" => "select",
			"default_text" => __("Yes", "livetheme"),
			"options" => array(
				__("No", "livetheme") => "No",
			)
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