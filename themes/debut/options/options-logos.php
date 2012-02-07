<?php

$options[] = array( 
  'name' => __( 'Logos', 'theme-it' ),
  'type' => 'heading'
);


/* Logos
----------------------------------------------------------*/
$options[] = array(
  'name'    => __( 'Miscellaneous Logo Options', 'theme-it' ),
  'desc'    => __( '', 'theme-it' ),
  'id'      => 'logo_options',
  'std'     => '',
  'type'    => 'multicheck',
  'options' => array( 
  	'logo_text'        => __( 'Use a text based logo.', 'theme-it' ), 
  	'site_description' => __( 'Show site description below logo', 'theme-it' )
  )
);

$options[] = array( 
  'name' => __( 'Image Logo', 'theme-it' ),
  'desc' => __( 'Upload an image based logo for the website.', 'theme-it' ),
  'id'   => 'logo_image',
  'std'  => '',
  'type' => 'upload'
);