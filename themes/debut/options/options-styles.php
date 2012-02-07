<?php

$options[] = array( 
  'name' => __( 'Styles', 'theme-it' ),
  'type' => 'heading'
);

$options[] = array( 
  'name' => __( 'Custom Theme Styles', 'theme-it' ),
  'desc' => __( 'Yes, enable custom theme styles. <strong>This option must be checked in order for the following options to take effect.</strong>', 'theme-it' ),
  'id'   => 'enable_styles',
  'std'  => 0,
  'class' => 'featured',
  'type' => 'checkbox'
);


/* Backgrounds
----------------------------------------------------------*/
$options[] = array( 
  'name'  => __( 'Background Styles', 'theme-it' ),
  'desc'  => __( 'Change background images and colors globally.', 'theme-it' ),
  'class' => 'featured toggle-section',
  'type'  => 'info'
);

$options[] = array(
  'name' => __( 'Body - Background', 'theme-it' ),
  'desc' => __( 'By default this is the dark grey texture. This can be something unique, like a large photo of your dog.', 'theme-it' ),
  'id'   => 'body_background',
  'std'  => array( 
  	'color' => '#333333', 
  	'image' => esc_url( $imagepath ) . 'background-dark.png', 
  	'repeat' => 'repeat', 
  	'position' => 'top left', 
  	'attachment'=>'scroll'
  ),
  'type' => 'background'
);

$options[] = array(
  'name' => __( 'Global 1 - Background (Lightest)', 'theme-it' ),
  'desc' => __( 'By default this is the lightest shade of gray. A few primary elements this effects: light callout, comments area, sidebar thumbnails, primary navigation sub level items, footer thumbnails.', 'theme-it' ),
  'id'   => 'global_background_1',
  'std'  => array( 
  	'color' => '#f5f5f5', 
  	'image' => esc_url( $imagepath ) . 'background-light.png', 
  	'repeat' => 'repeat', 
  	'position' => 'top left', 
  	'attachment'=>'scroll'
  ),
  'type' => 'background'
);
// medium callout, announcement, hero light background, entry thumbnails, primary navigation top level items, sidebar, footer
$options[] = array(
  'name' => __( 'Global 2 - Background (Medium)', 'theme-it' ),
  'desc' => __( 'By default this is the medium shade of gray. A few primary elements this effects: medium callout, announcement, entry-thumbnail backgrounds, sidebar, footbar.', 'theme-it' ),
  'id'   => 'global_background_2',
  'std'  => array( 
  	'color' => '#e3e3e3', 
  	'image' => esc_url( $imagepath ) . 'background-medium.png', 
  	'repeat' => 'repeat', 
  	'position' => 'top left', 
  	'attachment'=>'scroll'
  ),
  'type' => 'background'
);

$options[] = array(
  'name' => __( 'Global 3 - Background (Darkest)', 'theme-it' ),
  'desc' => __( 'By default this is the medium shade of gray. A few primary elements this effects: dark callout, announcement button, hero dark background.', 'theme-it' ),
  'id'   => 'global_background_3',
  'std'  => array( 
  	'color' => '#333333', 
  	'image' => esc_url( $imagepath ) . 'background-dark.png', 
  	'repeat' => 'repeat', 
  	'position' => 'top left', 
  	'attachment'=>'scroll'
  ),
  'type' => 'background'
);

$options[] = array(
  'name' => __( 'Global 4 - Background (Colored)', 'theme-it' ),
  'desc' => __( 'By default this is the light blue background color of the Action Navigation.', 'theme-it' ),
  'id'   => 'global_background_4',
  'std'  => array( 
  	'color' => '#7fccff', 
  	'image' => esc_url( $imagepath ) . 'background-color.png', 
  	'repeat' => 'repeat', 
  	'position' => 'top left', 
  	'attachment'=>'scroll'
  ),
  'type' => 'background'
);

$options[] = array(
  'name' => __( 'Global 5 - Background (Overlay)', 'theme-it' ),
  'desc' => __( 'By default this is the thick border around the site content. This also effects the Top Navigation background.', 'theme-it' ),
  'id'   => 'global_background_5',
  'std'  => array( 
  	'color' => '#2b2b2b', 
  	'image' => esc_url( $imagepath ) . 'background-overlay.png', 
  	'repeat' => 'repeat', 
  	'position' => 'top left', 
  	'attachment'=>'scroll'
  ),
  'type' => 'background'
);



/* Text Colors
----------------------------------------------------------*/
$options[] = array( 
  'name'  => __( 'Text Styles', 'theme-it' ),
  'desc'  => __( 'Change text and link colors globally.', 'theme-it' ),
  'class' => 'featured toggle-section',
  'type'  => 'info'
);

$options[] = array(
  'name' => __( 'Site Info - Text Color', 'theme-it' ),
  'desc' => __( 'This is the logo and tagline color.', 'theme-it' ),
  'id'   => 'text_logo_text_color',
  'std'  => '#f5f5f5',
  'type' => 'color'
);

$options[] = array(
  'name' => __( 'Main - Link Color', 'theme-it' ),
  'desc' => __( 'This applies to the link colors in the main content.', 'theme-it' ),
  'id'   => 'main_link_color',
  'std'  => '#7fccff',
  'type' => 'color'
);

$options[] = array(
  'name' => __( 'Body - Text Color', 'theme-it' ),
  'desc' => __( 'This applies to elements using the Body - Background (e.g. Footer Text)', 'theme-it' ),
  'id'   => 'body_text_color',
  'std'  => '#666666',
  'type' => 'color'
);

$options[] = array(
  'name' => __( 'Global 1 - Text Color', 'theme-it' ),
  'desc' => __( 'This applies to elements using the Global 1 - Background (e.g. Light Callout)', 'theme-it' ),
  'id'   => 'global_text_color_1',
  'std'  => '#333333',
  'type' => 'color'
);

$options[] = array(
  'name' => __( 'Global 2 - Text Color', 'theme-it' ),
  'desc' => __( 'This applies to elements using the Global 2 - Background (e.g. Medium Callout )', 'theme-it' ),
  'id'   => 'global_text_color_2',
  'std'  => '#333333',
  'type' => 'color'
);

$options[] = array(
  'name' => __( 'Global 3 - Text Color', 'theme-it' ),
  'desc' => __( 'This applies to elements using the Global 3 - Background (e.g. Dark Callout )', 'theme-it' ),
  'id'   => 'global_text_color_3',
  'std'  => '#ffffff',
  'type' => 'color'
);

$options[] = array(
  'name' => __( 'Global 4 - Text Color', 'theme-it' ),
  'desc' => __( 'This applies to elements using the Global 4 - Background (e.g. Action Navigation)', 'theme-it' ),
  'id'   => 'global_text_color_4',
  'std'  => ti_get_option( 'action_nav_text_color', '#333333' ),
  'type' => 'color'
);

$options[] = array(
  'name' => __( 'Global 5 - Text Color', 'theme-it' ),
  'desc' => __( 'This applies to elements using the Global 5 - Background (e.g. Top Navigation )', 'theme-it' ),
  'id'   => 'global_text_color_5',
  'std'  => '#ffffff',
  'type' => 'color'
);



