<?php

$options = array (

	array(	"name" => __("Video Embed Code", "livetheme"),
			"desc" => __("Enter the embed code for your video feed.<br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_embed_code",
			"type" => "textarea"
	),
	
	array(	"name" => __("Display Bumpers Or Video Stream?", "livetheme"),
			"desc" => __('When configured for "Video Stream," the bumpers will show until the Live Countdown widget expires and then the video stream will show.<br /><br />When configured for "Bumpers," the bumpers will be displayed unconditionally.', "livetheme"),
			"id" => "display_video_bumpers",
			"type" => "select",
			"default_text" => __("Video Stream", "livetheme"),
			"options" => array(
				__("Bumpers", "livetheme") => "Bumpers",
			)
	),

  array(	
    "name" => __("Video Bumper Embed Code", "livetheme"),
    "desc" => __("If you'd rather use a video as a bumper (instead of the image bumpers below), then place an embed code here.", "livetheme"),
    "id" => "bumper_embed_code",
    "type" => "textarea"
  ),

  /*
  array(
    "name" => __("Use Safe Mode?", "livetheme"),
    "desc" => __("Problems with either of your video embed code? Enable this option and we'll see what we can do to fix it.", "livetheme"),
    "id" => "safe_mode",
    "type" => "select",
    "default_text" => __("No", "livetheme"),
    "options" => array(
      __("Yes", "livetheme") => "Yes",
    )
  ),
  */
  
  array(	
    "name" => __("Bumper Duration", "livetheme"),
    "desc" => __("How long (in seconds) should each bumper display before moving to the next?", "livetheme"),
    "id" => "bumper_duration",
    "type" => "select",
    "default_text" => __("5", "livetheme"),
    "options" => get_bumper_durations()
  ),
  
	array(	"name" => __("Bumper #1 Image", "livetheme"),
			"desc" => __("Upload an image for this video bumper. <br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_bumper_1",
			"type" => "image",
			"value" => "Upload Video Bumper",
			"url" => get_bloginfo('template_directory')."/images/default_bumper1.jpg"
	),

	array(	"name" => __("Bumper #1 Destination", "livetheme"),
			"desc" => __("Specify the destination for this video bumper.<br /><br />The bumper will only show if there is a destination entered.", "livetheme"),
			"id" => "video_bumper_1_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
  
  array(
    "name" => __("Bumper #1 Disabled", "livetheme"),
    "desc" => __("If disabled, this bumper will not appear in rotation.", "livetheme"),
    "id" => "disable_bumper_1",
    "type" => "select",
    "default_text" => __("Yes", "livetheme"),
    "options" => array(
      __("No", "livetheme") => "no"
    )
  ),
	
	array(	"name" => __("Bumper #2 Image", "livetheme"),
			"desc" => __("Upload an image for this video bumper. <br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_bumper_2",
			"type" => "image",
			"value" => "Upload Video Bumper",
			"url" => get_bloginfo('template_directory')."/images/default_bumper2.jpg"
	),

	array(	"name" => __("Bumper #2 Destination", "livetheme"),
			"desc" => __("Specify the destination for this video bumper.<br /><br />The bumper will only show if there is a destination entered.", "livetheme"),
			"id" => "video_bumper_2_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
  
  array(
    "name" => __("Bumper #2 Disabled", "livetheme"),
    "desc" => __("If disabled, this bumper will not appear in rotation.", "livetheme"),
    "id" => "disable_bumper_2",
    "type" => "select",
    "default_text" => __("Yes", "livetheme"),
    "options" => array(
      __("No", "livetheme") => "no"
    )
  ),
	
  array(	"name" => __("Bumper #3 Image", "livetheme"),
			"desc" => __("Upload an image for this video bumper. <br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_bumper_3",
			"type" => "image",
			"value" => "Upload Video Bumper",
			"url" => get_bloginfo('template_directory')."/images/default_bumper3.jpg"
	),

	array(	"name" => __("Bumper #3 Destination", "livetheme"),
			"desc" => __("Specify the destination for this video bumper.<br /><br />The bumper will only show if there is a destination entered.", "livetheme"),
			"id" => "video_bumper_3_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
	
  array(
    "name" => __("Bumper #3 Disabled", "livetheme"),
    "desc" => __("If disabled, this bumper will not appear in rotation.", "livetheme"),
    "id" => "disable_bumper_3",
    "type" => "select",
    "default_text" => __("Yes", "livetheme"),
    "options" => array(
      __("No", "livetheme") => "no"
    )
  ),
  
		array(	"name" => __("Bumper #4 Image", "livetheme"),
			"desc" => __("Upload an image for this video bumper. <br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_bumper_4",
			"type" => "image",
			"value" => "Upload Video Bumper",
			"url" => get_bloginfo('template_directory')."/images/default_bumper4.jpg"
	),

	array(	"name" => __("Bumper #4 Destination", "livetheme"),
			"desc" => __("Specify the destination for this video bumper.<br /><br />The bumper will only show if there is a destination entered.", "livetheme"),
			"id" => "video_bumper_4_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
	
  array(
    "name" => __("Bumper #4 Disabled", "livetheme"),
    "desc" => __("If disabled, this bumper will not appear in rotation.", "livetheme"),
    "id" => "disable_bumper_4",
    "type" => "select",
    "default_text" => __("Yes", "livetheme"),
    "options" => array(
      __("No", "livetheme") => "no"
    )
  ),
  
		array(	"name" => __("Bumper #5 Image", "livetheme"),
			"desc" => __("Upload an image for this video bumper. <br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_bumper_5",
			"type" => "image",
			"value" => "Upload Video Bumper",
			"url" => get_bloginfo('template_directory')."/images/default_bumper1.jpg"
	),

	array(	"name" => __("Bumper #5 Destination", "livetheme"),
			"desc" => __("Specify the destination for this video bumper.<br /><br />The bumper will only show if there is a destination entered.", "livetheme"),
			"id" => "video_bumper_5_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
	
  array(
    "name" => __("Bumper #5 Disabled", "livetheme"),
    "desc" => __("If disabled, this bumper will not appear in rotation.", "livetheme"),
    "id" => "disable_bumper_5",
    "type" => "select",
    "default_text" => __("Yes", "livetheme"),
    "options" => array(
      __("No", "livetheme") => "no"
    )
  ),
  
  array(	"name" => __("Bumper #6 Image", "livetheme"),
			"desc" => __("Upload an image for this video bumper. <br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_bumper_6",
			"type" => "image",
			"value" => "Upload Video Bumper",
			"url" => get_bloginfo('template_directory')."/images/default_bumper2.jpg"
	),

	array(	"name" => __("Bumper #6 Destination", "livetheme"),
			"desc" => __("Specify the destination for this video bumper.<br /><br />The bumper will only show if there is a destination entered.", "livetheme"),
			"id" => "video_bumper_6_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
	
  array(
    "name" => __("Bumper #6 Disabled", "livetheme"),
    "desc" => __("If disabled, this bumper will not appear in rotation.", "livetheme"),
    "id" => "disable_bumper_6",
    "type" => "select",
    "default_text" => __("Yes", "livetheme"),
    "options" => array(
      __("No", "livetheme") => "no"
    )
  ),
	
	array(	"name" => __("Bumper #7 Image", "livetheme"),
			"desc" => __("Upload an image for this video bumper. <br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_bumper_7",
			"type" => "image",
			"value" => "Upload Video Bumper",
			"url" => get_bloginfo('template_directory')."/images/default_bumper3.jpg"
	),

	array(	"name" => __("Bumper #7 Destination", "livetheme"),
			"desc" => __("Specify the destination for this video bumper.<br /><br />The bumper will only show if there is a destination entered.", "livetheme"),
			"id" => "video_bumper_7_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
  
  array(
    "name" => __("Bumper #7 Disabled", "livetheme"),
    "desc" => __("If disabled, this bumper will not appear in rotation.", "livetheme"),
    "id" => "disable_bumper_7",
    "type" => "select",
    "default_text" => __("Yes", "livetheme"),
    "options" => array(
      __("No", "livetheme") => "no"
    )
  ),
	
	array(	"name" => __("Bumper #8 Image", "livetheme"),
			"desc" => __("Upload an image for this video bumper. <br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_bumper_8",
			"type" => "image",
			"value" => "Upload Video Bumper",
			"url" => get_bloginfo('template_directory')."/images/default_bumper4.jpg"
	),

	array(	"name" => __("Bumper #8 Destination", "livetheme"),
			"desc" => __("Specify the destination for this video bumper.<br /><br />The bumper will only show if there is a destination entered.", "livetheme"),
			"id" => "video_bumper_8_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
  
  array(
    "name" => __("Bumper #8 Disabled", "livetheme"),
    "desc" => __("If disabled, this bumper will not appear in rotation.", "livetheme"),
    "id" => "disable_bumper_8",
    "type" => "select",
    "default_text" => __("Yes", "livetheme"),
    "options" => array(
      __("No", "livetheme") => "no"
    )
  ),
	
  array(	"name" => __("Bumper #9 Image", "livetheme"),
			"desc" => __("Upload an image for this video bumper. <br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_bumper_3",
			"type" => "image",
			"value" => "Upload Video Bumper",
			"url" => get_bloginfo('template_directory')."/images/default_bumper1.jpg"
	),

	array(	"name" => __("Bumper #9 Destination", "livetheme"),
			"desc" => __("Specify the destination for this video bumper.<br /><br />The bumper will only show if there is a destination entered.", "livetheme"),
			"id" => "video_bumper_9_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
	
  array(
    "name" => __("Bumper #9 Disabled", "livetheme"),
    "desc" => __("If disabled, this bumper will not appear in rotation.", "livetheme"),
    "id" => "disable_bumper_9",
    "type" => "select",
    "default_text" => __("Yes", "livetheme"),
    "options" => array(
      __("No", "livetheme") => "no"
    )
  ),
  
		array(	"name" => __("Bumper #10 Image", "livetheme"),
			"desc" => __("Upload an image for this video bumper. <br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_bumper_10",
			"type" => "image",
			"value" => "Upload Video Bumper",
			"url" => get_bloginfo('template_directory')."/images/default_bumper2.jpg"
	),

	array(	"name" => __("Bumper #10 Destination", "livetheme"),
			"desc" => __("Specify the destination for this video bumper.<br /><br />The bumper will only show if there is a destination entered.", "livetheme"),
			"id" => "video_bumper_10_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
	
  array(
    "name" => __("Bumper #10 Disabled", "livetheme"),
    "desc" => __("If disabled, this bumper will not appear in rotation.", "livetheme"),
    "id" => "disable_bumper_10",
    "type" => "select",
    "default_text" => __("Yes", "livetheme"),
    "options" => array(
      __("No", "livetheme") => "no"
    )
  ),
  
		array(	"name" => __("Bumper #11 Image", "livetheme"),
			"desc" => __("Upload an image for this video bumper. <br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_bumper_11",
			"type" => "image",
			"value" => "Upload Video Bumper",
			"url" => get_bloginfo('template_directory')."/images/default_bumper3.jpg"
	),

	array(	"name" => __("Bumper #11 Destination", "livetheme"),
			"desc" => __("Specify the destination for this video bumper.<br /><br />The bumper will only show if there is a destination entered.", "livetheme"),
			"id" => "video_bumper_11_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
	
  array(
    "name" => __("Bumper #11 Disabled", "livetheme"),
    "desc" => __("If disabled, this bumper will not appear in rotation.", "livetheme"),
    "id" => "disable_bumper_11",
    "type" => "select",
    "default_text" => __("Yes", "livetheme"),
    "options" => array(
      __("No", "livetheme") => "no"
    )
  ),
  
  array(	"name" => __("Bumper #12 Image", "livetheme"),
			"desc" => __("Upload an image for this video bumper. <br /><br /><small>(640px x 360px)</small>", "livetheme"),
			"id" => "video_bumper_12",
			"type" => "image",
			"value" => "Upload Video Bumper",
			"url" => get_bloginfo('template_directory')."/images/default_bumper4.jpg"
	),

	array(	"name" => __("Bumper #12 Destination", "livetheme"),
			"desc" => __("Specify the destination for this video bumper.<br /><br />The bumper will only show if there is a destination entered.", "livetheme"),
			"id" => "video_bumper_12_url",
			"type" => "text",
			"std" => "http://livetheme.tv"
	),
	
  array(
    "name" => __("Bumper #12 Disabled", "livetheme"),
    "desc" => __("If disabled, this bumper will not appear in rotation.", "livetheme"),
    "id" => "disable_bumper_12",
    "type" => "select",
    "default_text" => __("Yes", "livetheme"),
    "options" => array(
      __("No", "livetheme") => "no"
    )
  ),
  
);

/* ------------ Do not edit below this line ----------- */

/**
 * Creates an array of seconds to be used to select how long each
 * bumper should display.
 */
function get_bumper_durations() {

  $durations = array();
  
  for($i = 10; $i <= 60; $i += 5) {
    $durations[$i] = $i;
  } // end for
  
  return $durations;

} // end get_bumper_durations

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