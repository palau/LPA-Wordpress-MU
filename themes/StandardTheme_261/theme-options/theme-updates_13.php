<?php

$options = array (

	array(	"name" => __("Update Your Theme", "standardtheme"),
			"desc" => __(get_theme_version_status(), "standardtheme"),
			"id" => "theme_version_status"
	)
	
);

/**
 * Determines if the current theme is out of date with our latest version
 * and echoes and update to the administration panel.
 */
function get_theme_version_status() {
	
	$tags = get_meta_tags('http://standardtheme.com/demo/');
	if($tags):
		$properties = explode(' ', $tags['generator']);
		echo create_message_container(STANDARD_THEME_VER, $properties[2]);	
	else:
		$container = '<kbd>';
			$container .= __('Your host doesn\'t support the ability to check theme version.  Please follow the <a href="http://8bit.io/blog/standard/">Standard Theme Blog</a> for updates.', "standardtheme");
		$container .= '</kbd>';
		echo $container;
	endif;
	
} // end standardtheme_add_updates

/**
 * Creates the localized message to display in the theme updates area of the administration
 * panel.
 */
function create_message_container($this_version, $live_version) {
	
	$msg = __("Your site is powered by Standard Theme <strong>", "standardtheme") . $this_version . __("</strong>. ", "standardtheme");

	if($this_version < $live_version):
		$msg .= __("The most recent version is <strong>", "standardtheme") 
			. 	$live_version . __("</strong>. ", "standardtheme")
			.	__('Grab your update <a href="http://standardtheme.com/forums">', 'standardtheme') 
			. 	__('in the forums!', 'standardtheme');
	else:
		$msg .= __("You're up to date!", "standardtheme");
	endif;
	
	$container = '<kbd>';
		$container .= $msg;
	$container .= '</kbd>';
	
	return $container;
	
} // end create_message_container

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