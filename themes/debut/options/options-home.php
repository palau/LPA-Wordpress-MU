<?php

$options[] = array( 
  'name' => __( 'Home', 'theme-it' ),
  'type' => 'heading'
);


/**
 * Announcement
 *
 */
$options[] = array( 
  'name' => __( 'Announcement', 'theme-it' ),
  'desc' => __( 'Easily add an announcement to the homepage by setting the following options.', 'theme-it' ),
  'class' => 'featured toggle-section',
  'type' => 'info'
);

$options[] = array( 
  'name'  => __( 'Announcement Title', 'theme-it' ),
  'id'    => 'announcement_title',
  'std'   => '',
  'type'  => 'text'
); 

$options[] = array(
  'name'  => __( 'Announcement Message', 'theme-it' ),
  'id'    => 'announcement_message',
  'std'   => '',
  'type'  => 'textarea'
); 

$options[] = array( 
  'name'  => __( 'Announcement Button Title', 'theme-it' ),
  'id'    => 'announcement_button_title',
  'std'   => '',
  'type'  => 'text'
); 

$options[] = array( 
  'name'  => __( 'Announcement Button Link (URL)', 'theme-it' ),
  'id'    => 'announcement_button_link',
  'std'   => '',
  'type'  => 'text'
);


/**
 * Hero
 *
 */
$options[] = array( 
  'name' => __( 'Hero Slider', 'theme-it' ),
  'desc' => __( 'The following options control how the slider on the home page functions.', 'theme-it' ),
  'class' => 'featured toggle-section',
  'type' => 'info'
);

$options[] = array( 
  'name'  => __( 'Hero Slider Speed', 'theme-it' ),
  'desc'  => __( 'Speed (in seconds) at which the slides will animate between transitions.', 'theme-it' ),
  'id'    => 'hero_cycle_speed',
  'std'   => '2',
  'class' => 'mini',
  'type'  => 'text'
);

$options[] = array( 
  'name'  => __( 'Hero Slider Timeout', 'theme-it' ),
  'desc'  => __( 'Time (in seconds) before transitioning to the next slide. Leave empty to disable.', 'theme-it' ),
  'id'    => 'hero_cycle_timeout',
  'std'   => '6',
  'class' => 'mini',
  'type'  => 'text'
);

$options[] = array(
  'name'    => __( 'Hero Transition Style', 'theme-it' ),
  'desc'    => __( 'Select a style from the drop down to control how the slides transition from one to the next.', 'theme-it' ),
  'id'      => 'hero_cycle_fx',
  'std'     => 'scrollHorz',
  'type'    => 'select',
  'options' => array(
  	'none'        => __( 'None - No Effect', 'theme-it' ),
  	'fade'        => __( 'Fade', 'theme-it' ),
  	'scrollHorz'  => __( 'Scroll - Horizontal', 'theme-it' ),
  	'scrollVert'  => __( 'Scroll - Vertical', 'theme-it' ),
  	'blindX'      => __( 'Blinds - Horizontal', 'theme-it' ),
  	'blindY'      => __( 'Blinds - Vertical', 'theme-it' )
  )
);

$options[] = array(
  'name'    => __( 'Hero Category', 'theme-it' ),
  'desc'    => __( 'Select which category should be shown in the hero area.', 'theme-it' ),
  'id'      => 'hero_category',
  'std'     => 'Select a category:',
  'type'    => 'select',
  'options' => $options_categories
);

$options[] = array( 
  'name' => __( 'Hero Filter Posts by Featured Image', 'theme-it' ),
  'desc' => __( 'Only includes posts that have a featured image set.', 'theme-it' ),
  'id'   => 'hero_filter_thumbs',
  'std'  => 0,
  'type' => 'checkbox'
);

$options[] = array( 
  'name'  => __( 'Hero Number of Posts', 'theme-it' ),
  'desc'  => __( 'If you wish to only display a specific number of posts or all posts on the home page\'s hero, provide a number or enter -1 to show all posts.', 'theme-it' ),
  'id'    => 'hero_posts_per_page',
  'std'   => '',
  'class' => 'mini',
  'type'  => 'text'
);


/**
 * Featured
 *
 */
$options[] = array( 
  'name' => __( 'Featured Content', 'theme-it' ),
  'desc' => __( 'The following options are for the featured area below the slider on the home page.', 'theme-it' ),
  'class' => 'featured toggle-section',
  'type' => 'info'
);

$options[] = array( 
  'name' => __( 'Featured Section Title', 'theme-it' ),
  'desc' => __( 'Name of the featured section. Generally, the type of posts that will be shown. (e.g. Featured Images)', 'theme-it' ),
  'id'   => 'featured_section_title',
  'std'  => '',
  'type' => 'text'
);

$options[] = array(
  'name'    => __( 'Featured Category', 'theme-it' ),
  'desc'    => __( 'Select a specific category of posts to display.', 'theme-it' ),
  'id'      => 'featured_category',
  'std'     => __( 'Select a category:', 'theme-it' ),
  'type'    => 'select',
  'options' => $options_categories
);

$options[] = array( 
  'name'  => __( 'Featured Number of Posts', 'theme-it' ),
  'desc'  => __( 'Provide a number of featured posts to display. Enter -1 to show all posts. Leave blank to show your default number.', 'theme-it' ),
  'id'    => 'featured_posts_per_page',
  'std'   => '',
  'class' => 'mini',
  'type'  => 'text'
);

$options[] = array( 
  'name' => __( 'Featured Filter Posts by Featured Image', 'theme-it' ),
  'desc' => __( 'Only includes posts that have a featured image set.', 'theme-it' ),
  'id'   => 'featured_filter_thumbs',
  'std'  => 0,
  'type' => 'checkbox'
);

$options[] = array( 
  'name' => __( 'Featured Pagination', 'theme-it' ),
  'desc' => __( 'Show pagination for featured posts.', 'theme-it' ),
  'id'   => 'featured_enable_pagination',
  'std'  => 0,
  'type' => 'checkbox'
); 

$options[] = array(
  'name'    => __( 'Featured Layout Options', 'theme-it' ),
  'id'      => 'featured_hide',
  'std'     => '',
  'type'    => 'multicheck',
  'options' => array( 
  	'images'    => __( 'Hide Images', 'theme-it' ), 
  	'titles'    => __( 'Hide Titles', 'theme-it' ), 
  	'content'   => __( 'Hide Content', 'theme-it' ), 
  	'read_more' => __( 'Hide Read More', 'theme-it' ) 
  )
);

?>