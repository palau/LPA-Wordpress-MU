<?php

$options[] = array( 
  'name' => __( 'General', 'theme-it' ),
  'type' => 'heading'
);


/*
 * Misc.
 */
$options[] = array( 
  'name' => __( 'Miscellaneous', 'theme-it' ),
  'desc' => __( 'Below are a few miscellaneous features that can be enabled/disabled.', 'theme-it' ),
  'class' => 'featured toggle-section',
  'type' => 'info'
);

$options[] = array( 
  'name' => __( 'Top Menu Search Form', 'theme-it' ),
  'desc' => __( 'Display search form in Top Menu', 'theme-it' ),
  'id'   => 'top_search_form',
  'std'  => 0,
  'type' => 'checkbox'
);

$options[] = array(
  'name'    => __( 'Post Information', 'theme-it' ),
  'desc'    => __( 'The option to easily disable some default post information can be selected below.', 'theme-it' ),
  'id'      => 'disable_post_attributes',
  'std'     => '',
  'type'    => 'multicheck',
  'options' => array(
  	'posted_on' => 'Disable Post Meta. (e.g. Posted on April 25, 2011 by Luke McDonald)',
  	'posted_in' => 'Disable Post Utility. (e.g. This entry was posted in Video. Bookmark the permalink)', 
  	'comments' => 'Disable Comments. (Single posts and pages)', 
  	'post_thumbnail' => 'Disable Post Thumbnail (Single posts and pages)',
  	'media_embed' => 'Disable Media Embed. (Single posts and pages)'
  )
);

$options[] = array( 
  'name' => __( 'Excerpt Length', 'theme-it' ),
  'desc' => __( 'Provide a number (of words), for how long the excerpt length should be. This length controls the description length of the featured posts on home page, the gallery posts in the gallery post template, and the results in search pages.', 'theme-it' ),
  'id'   => 'excerpt_length',
  'std'  => '24',
  'class' => 'mini',
  'type' => 'text'
);


/*
 * Video.
 */
$options[] = array( 
  'name' => __( 'Video', 'theme-it' ),
  'desc' => __( 'Below are a few miscellaneous features that can be enabled/disabled.', 'theme-it' ),
  'class' => 'featured toggle-section',
  'type' => 'info'
);

$options[] = array( 
  'name' => __( 'Instant View', 'theme-it' ),
  'desc' => __( 'Yes, enable Instant View. By enabling instant view, any posts that have a media embed option set, will pop up in a modal window. NOTE: This may slow down your site if a bunch of videos are being loaded for instant view. e.g. the Featured Content area on home page.', 'theme-it' ),
  'id'   => 'instant_view',
  'std'  => 0,
  'type' => 'checkbox'
);

$options[] = array( 
  'name' => __( 'Instant View Video Size', 'theme-it' ),
  'desc' => __( 'Provide a width and height for your video dimensions in instant view (e.g. 640x360)', 'theme-it' ),
  'id'   => 'instant_size',
  'std'  => '640x360',
  'class' => 'mini',
  'type' => 'text'
);


/*
 * Footer
 */
$options[] = array( 
  'name' => __( 'Footer Text', 'theme-it' ),
  'desc' => __( 'The following options update the text in the footer at the bottom of each page.', 'theme-it' ),
  'class' => 'featured toggle-section',
  'type' => 'info'
);

$options[] = array( 
  'name' => __( 'Copyright Text', 'theme-it' ),
  'desc' => __( 'Enable "Copyright" text by entering your business name.', 'theme-it' ),
  'id'   => 'footer_copyright',
  'std'  => '',
  'type' => 'text'
);

$options[] = array(
  'name' => __( 'General Text', 'theme-it' ),
  'desc' => __( 'Additional text below the copyright', 'theme-it' ),
  'id'   => 'footer_text',
  'std'  => '',
  'type' => 'textarea'
);


if( function_exists( 'social_bartender' ) ) :
	$options[] = array( 
	  'name' => __( 'Social Media', 'theme-it' ),
	  'desc' => '<strong>' . __( 'The Social Bartender plugin is currently active.', '' ) . '</strong> ' . __( 'Deactivate the Social Bartender plugin to set the Social Media options here.', 'theme-it' ),
	  'class' => 'featured',
	  'type' => 'info'
	);
else :
	$options[] = array( 
	  'name' => __( 'Social Media', 'theme-it' ),
	  'desc' => __( 'The following options allow you to enter in your username for a few of the social media networks available. If set, a small icon will be displayed in the footer.', 'theme-it' ),
	  'class' => 'featured toggle-section',
	  'type' => 'info'
	);

	$options[] = array( 
	  'name' => __( 'RSS Icon', 'theme-it' ),
	  'desc' => __( 'Enable RSS Icon', 'theme-it' ),
	  'id'   => 'social_rss',
	  'std'  => 1,
	  'type' => 'checkbox'
	);
	
	$options[] = array( 
		'name' => __( 'FeedBurner', 'theme-it' ),
	  'desc' => __( 'Provide your <a href="http://feedburner.google.com" title="Go to FeedBurner" target="_blank">FeedBurner</a> feed name to enable this functionality. The RSS icon must be enabled above.', 'theme-it' ),
	  'id'   => 'feedburner_url',
	  'std'  => '',
	  'type' => 'text'
	);
	
	$options[] = array( 
	  'name' => __( 'Twitter', 'theme-it' ),
	  'desc' => __( '', 'theme-it' ),
	  'id'   => 'social_twitter',
	  'std'  => '',
	  'type' => 'text'
	);
	
	$options[] = array( 
	  'name' => __( 'Facebook', 'theme-it' ),
	  'desc' => __( '', 'theme-it' ),
	  'id'   => 'social_facebook',
	  'std'  => '',
	  'type' => 'text'
	);
	
	$options[] = array( 
	  'name' => __( 'Flickr', 'theme-it' ),
	  'desc' => __( '', 'theme-it' ),
	  'id'   => 'social_flickr',
	  'std'  => '',
	  'type' => 'text'
	);
	
	$options[] = array( 
	  'name' => __( 'Vimeo', 'theme-it' ),
	  'desc' => __( '', 'theme-it' ),
	  'id'   => 'social_vimeo',
	  'std'  => '',
	  'type' => 'text'
	);
	
	$options[] = array( 
	  'name' => __( 'YouTube', 'theme-it' ),
	  'desc' => __( '', 'theme-it' ),
	  'id'   => 'social_youtube',
	  'std'  => '',
	  'type' => 'text'
	);
	
	$options[] = array( 
	  'name' => __( 'Delicious', 'theme-it' ),
	  'desc' => __( '', 'theme-it' ),
	  'id'   => 'social_delicious',
	  'std'  => '',
	  'type' => 'text'
	);
	
	$options[] = array( 
	  'name' => __( 'Last.fm', 'theme-it' ),
	  'desc' => __( '', 'theme-it' ),
	  'id'   => 'social_lastfm',
	  'std'  => '',
	  'type' => 'text'
	);
endif; // end social bartendar plugin check
