<?php

$options = array (

	array(	"name" => __("Breadcrumbs", "standardtheme"),
			"desc" => __("Do you want to display SEO-friendly breadcrumbs on each of your posts?", "standardtheme"),
			"id" => "breadcrumbs",
			"type" => "select",
			"default_text" => __("No", "standardtheme"),
			"options" => array(
				__("Yes", "standardtheme") => "Yes",
			)
	),
	
	array(	"name" => __("Use WordPress 3.0 Custom Menu?", "standardtheme"),
			"desc" => __("Use WordPress 3.0 menus rather than Standard Theme's menus?", "standardtheme"),
			"id" => "wp3menu",
			"type" => "select",
			"default_text" => __("No", "standardtheme"),
			"options" => array(
				__("Yes", "standardtheme") => "Yes",
			)
	),
	
	array(	"name" => __("Exclude Pages From The Navigation Menus", "standardtheme"),
			"desc" => __("Select the pages to exclude from your navigation menus. Excluding a top-level page excludes child pages.  <br><br><small>(Command/Control + Select to choose multiple)</small>", "standardtheme"),
			"id" => "page_exclude",
			"type" => "pages"
	),
	
	array(	"name" => __("Exclude Categories in Navigation Menus", "standardtheme"),
			"desc" => __("Select the categories to exclude from your navigation menus. Excluding a top-level page excludes child categories. <br><br><small>(Command/Control + Select to choose multiple)</small>", "standardtheme"),
			"id" => "category_exclude",
			"type" => "categories"
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