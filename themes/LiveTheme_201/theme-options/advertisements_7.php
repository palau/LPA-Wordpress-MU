<?php

$options = array (

	array(	"name" => __("Sidebar Advertisement Image", "livetheme"),
			"desc" => __("Upload the image for this advertisement. It is displayed to the right of the tabbed pages. <br /><br /><small>(300px x 250px)</small>", "livetheme"),
			"id" => "sidebar_ad_image",
			"type" => "image",
			"value" => "Upload Sidebar Advertisement",
			"url" => get_bloginfo('template_directory')."/images/ad-sidebar.jpg"
	),

	array(	"name" => __("Sidebar Advertisement Adsense Code", "livetheme"),
			"desc" => __("Enter the adsense code for this advertisement.", "livetheme"),
			"id" => "sidebar_ad_adsense",
			"type" => "textarea"
	),

	array(	"name" => __("Sidebar Advertisement Destination", "livetheme"),
			"desc" => __("Specify the destination URL for the sidebar advertisement.", "livetheme"),
			"id" => "sidebar_ad_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
	
	array(	"name" => __("Footer Advertisement #1 Image", "livetheme"),
			"desc" => __("Upload the image for this advertisement. It will be displayed below the content. <br /><br /><small>(300px x 150px)</small>", "livetheme"),
			"id" => "footer_ad1_image",
			"type" => "image",
			"value" => "Upload Footer Advertisement #1",
			"url" => get_bloginfo('template_directory')."/images/ad-footer-1.jpg"
	),

	array(	"name" => __("Footer Advertisement #1 Adsense Code", "livetheme"),
			"desc" => __("Enter the adsense code for this advertisement.", "livetheme"),
			"id" => "footer_ad_adsense1",
			"type" => "textarea"
	),

	array(	"name" => __("Footer Advertisement #1 Destination", "livetheme"),
			"desc" => __("Specify the destination URL for this advertisement.", "livetheme"),
			"id" => "footer_ad_url1",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
	
	array(	"name" => __("Footer Advertisement #2 Image", "livetheme"),
			"desc" => __("Upload the image for this advertisement. It will be displayed below the content. <br /><br /><small>(300px x 150px)</small>", "livetheme"),
			"id" => "footer_ad2_image",
			"type" => "image",
			"value" => "Upload Footer Advertisement #2",
			"url" => get_bloginfo('template_directory')."/images/ad-footer-2.jpg"
	),

	array(	"name" => __("Footer Advertisement #2 Adsense Code", "livetheme"),
			"desc" => __("Enter the adsense code for this advertisement.", "livetheme"),
			"id" => "footer_ad_adsense2",
			"type" => "textarea"
	),

	array(	"name" => __("Footer Advertisement #2 Destination", "livetheme"),
			"desc" => __("Specify the destination URL for this advertisement.", "livetheme"),
			"id" => "footer_ad_url2",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
	
	array(	"name" => __("Footer Advertisement #3 Image", "livetheme"),
			"desc" => __("Upload the image for this advertisement. It will be displayed below the content. <br /><br /><small>(300px x 150px)</small>", "livetheme"),
			"id" => "footer_ad3_image",
			"type" => "image",
			"value" => "Upload Footer Advertisement #3",
			"url" => get_bloginfo('template_directory')."/images/ad-footer-3.jpg"
	),

	array(	"name" => __("Footer Advertisement #3 Adsense Code", "livetheme"),
			"desc" => __("Enter the adsense code for this advertisement.", "livetheme"),
			"id" => "footer_ad_adsense3",
			"type" => "textarea"
	),

	array(	"name" => __("Footer Advertisement #3 Destination", "livetheme"),
			"desc" => __("Specify the destination URL for this advertisement.", "livetheme"),
			"id" => "footer_ad_url3",
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