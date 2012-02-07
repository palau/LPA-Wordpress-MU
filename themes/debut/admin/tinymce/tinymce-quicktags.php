<?php

/**
 * Quicktags
 */
function ti_add_simple_buttons() { 
	
	wp_print_scripts( 'quicktags' );
		
	$output = "<script type='text/javascript'>\n
	/* <![CDATA[ */ \n";
		
	$buttons = array();
	
	$buttons[] = array( 
	'name' 					=> 'email',
	'options' 			=> array(
		'display_name'	=> 'email',
		'open_tag' 			=> '<a class="jquery-email">' . __( 'NAME at DOMAIN', 'theme-it' ) . '</a>',
		'close_tag' 		=> '',
		'key' 					=> ''
	));
	
	$buttons[] = array( 
	'name' 					=> 'callout',
	'options' 			=> array(
		'display_name'	=> 'callout',
		'open_tag' 			=> '<div class="callout-light">',
		'close_tag' 		=> '</div>',
		'key' 					=> ''
	));
	
	$buttons[] = array( 
	'name' 					=> 'one_half',
	'options' 			=> array(
		'display_name'	=> 'column',
		'open_tag' 			=> '\n<div class="one-half">',
		'close_tag' 		=> '</div>\n',
		'key' 					=> ''
	));
	
	$buttons[] = array( 
	'name' 					=> 'one_half_last',
	'options' 			=> array(
		'display_name'	=> 'column last',
		'open_tag' 			=> '\n<div class="one-half last">',
		'close_tag' 		=> '</div>\n',
		'key' 					=> ''
	));

	$buttons[] = array( 
	'name' 					=> 'embed',
	'options' 			=> array(
		'display_name'	=> 'embed',
		'open_tag' 			=> '\n[embed]',
		'close_tag' 		=> '[/embed]\n',
		'key' 					=> ''
	));
				
							
	// Out put $buttons array of options
	for ( $i=0; $i <= ( count( $buttons ) - 1 ); $i++ ) {
	$output .= "edButtons[edButtons.length] = new edButton('ed_{$buttons[$i]['name']}'
		,'{$buttons[$i]['options']['display_name']}'
		,'{$buttons[$i]['options']['open_tag']}'
		,'{$buttons[$i]['options']['close_tag']}'
		,'{$buttons[$i]['options']['key']}'
	); \n";
	}
	
	$output .= "\n /* ]]> */ \n
	
	</script>";
	
	echo $output;

}

?>