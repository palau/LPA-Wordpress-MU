<?php

/*-----------------------------------------------------------------*
 * Live Theme 2.0
 * 8BIT
 *
 * 1. Framework Dependencies
 * 2. WordPress Functions
 * 3. Framework  
 * 4. Advertisements
 * 5. Custom Functions
 * 6. Helper Functions
 * 7. Standard Theme Core
 *-----------------------------------------------------------------*/

/*-----------------------------------------------------------------*
 * 1. Framework Dependencies
 *-----------------------------------------------------------------*/
 
 if(!in_array(WP_PLUGIN_URL . 'live-countdown/livecountdown.php', apply_filters('active_plugins', get_option( 'active_plugins')))):
	require_once('live-countdown/livecountdown.php');
 endif;
 
 if(!in_array(WP_PLUGIN_URL . '/livetweets/livetweets.php', apply_filters('active_plugins', get_option( 'active_plugins')))):
	require_once('livetweets/livetweets.php');
 endif;
 
 if(!in_array(WP_PLUGIN_URL . '/livefacebook/livefacebook.php', apply_filters('active_plugins', get_option( 'active_plugins')))):
	require_once('livefacebook/livefacebook.php');
 endif;
 
/*-----------------------------------------------------------------*
 * 2. WordPress Functions
 *-----------------------------------------------------------------*/
 
 /**
 * Initialize the Standard Theme widgets.
 */
function the_widgets_init() {
	
	if (!function_exists('register_sidebars')):
		return;
	endif;

	register_sidebar(
		array('name' => __('Countdown'),
				'id' => 'header-widget',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>'
			)
	); 
	
	register_sidebar(
		array('name' => __('Twitter Tab'),
				'id' => 'twitter-feed',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>'
			)
	); 
	
	register_sidebar(
		array('name' => __('Facebook Tab'),
				'id' => 'facebook-feed',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>'
			)
	);
  
  register_sidebar(
    array('name' => __('Custom Tab'),
      'id' => 'custom-tab',
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>'
    )
  );
	
	register_sidebar(
		array('name' => __('Sidebar Advertisement'),
				'id' => 'sidebar-ad',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>'
			)
	); 
	
	register_sidebar(
		array('name' => __('Footer Advertisement #1'),
				'id' => 'footer-ad1',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>'
			)
	); 
	
	register_sidebar(
		array('name' => __('Footer Advertisement #2'),
				'id' => 'footer-ad2',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>'
			)
	); 
	
	register_sidebar(
		array('name' => __('Footer Advertisement #3'),
				'id' => 'footer-ad3',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>'
			)
	); 
	
} // end the_widgets_init
add_action( 'init', 'the_widgets_init' );

/**
 * Initializes core theme functionality.
 */
function livetheme_init() {

  $term = 'Video Archives';
  $taxonomy = 'category';

  $opts = array(
    'cat_name' => __("Video Archives"),
    'cat_description' => __("A category used to drive the video archives page template."),
    'category_nicename' => __('video-archives')
  );
  
  if(!is_term($term, $taxonomy)) {
    wp_insert_term($term, $taxonomy, $opts);
  } // end if

} // end livetheme_init
add_action('init', 'livetheme_init');
 
/**
 * Defines the basis for the Standard Theme framework (version, styles, and general meta tags).
 */
function standard_version() {
	$standard_framework_version = "1.0";
	$theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
	$theme_version = $theme_data['Version'];
	echo '<meta name="generator" content="Live Theme' .' '. $theme_version .'" />' ."\n";
	echo '<meta name="generator" content="Standard Theme Framework Version '. $standard_framework_version .'" />' ."\n";
} // end standard_version
add_action('wp_head','standard_version');

/**
 * Register the WP3 menu system.
 */ 
function register_my_menus() {
	
  register_nav_menus(
		array(
      'page-tabs' => __('Live Theme Tabbed Navigation'),
			'footer-navigation' => __( 'Live Theme Footer Navigtion' )
		)
	);
  
} // end register_my_menus
add_action('init', 'register_my_menus');


/**
 * Register Post Thumbnails
 */ 
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 300, 170, true );

/*-----------------------------------------------------------------*
 * 3. Framework
/*-----------------------------------------------------------------*/

/**
 * Includes the version of jQuery hosted via Google.
 */
function standard_theme_libs() {

  global $standard_options;

	if(!is_admin()):
		
	    wp_deregister_script("jquery");
		wp_enqueue_script("jquery", "http://ajax.googleapis.com/ajax/libs/jquery/1.6.0/jquery.min.js");
	
		wp_deregister_script("prettyPhoto");
		wp_enqueue_script("prettyPhoto", get_bloginfo('template_directory') . "/js/jquery.prettyPhoto.js");
    
	    $stylesheet = $standard_options->livetheme_style == '' ? 'default' : $standard_options->livetheme_style;
	    wp_register_style('livetheme-option-style', get_bloginfo('template_directory') . '/styles/' . $stylesheet . '.css');
	    wp_enqueue_style('livetheme-option-style');
	    
	    wp_register_style('prettyPhoto-style', get_bloginfo('template_directory') . '/css/prettyPhoto.css');
	    wp_enqueue_style('prettyPhoto-style');
    
	endif;
  
} // end standard_theme_libs

/** 
 * Returns whether or not to render the header as text or as an image.
 */
function standard_use_text_header() {
	global $standard_options;
	return $standard_options->text_header || !$standard_options->logo;
} // end standard_use_text_header

/**
 * Displays the logo .
 */
function standard_display_logo() {
	global $standard_options; ?>
	<img class="title" src="<?php echo $standard_options->logo; ?>" alt="<?php bloginfo('name'); ?>" />
<?php } // end standard_display_logo

/**
 * Loads the favicon
 */
function standard_wp_head() {
	global $standard_options;
	echo '<link rel="shortcut icon" href="' . $standard_options->custom_favicon . '" type="image/vnd.microsoft.icon" />'."\n";
} // end standard_wp_head
add_action('wp_head', 'standard_wp_head');

/** 
 * Returns whether or not to force viewers to refresh their browser.
 */
function standard_is_offline() {
	global $standard_options;
	return $standard_options->is_offline;
} // end standard_is_offline

/**
 * Returns how long the site should wait before polling to see
 * if it should refresh.
 */
function standard_polling_duration() {
  global $standard_options;
  return $standard_options->polling_interval ? $standard_options->polling_interval : "off";
} // standard_polling_duration

/**
 * Register the WP3 background system.
 */
function standard_register_background() {
	add_custom_background();
} // end standard_register_background
add_action('init', 'standard_register_background');

/** 
 * Renders the custom menu for the footer.
 */
function standard_footer_menu() {
	
  wp_nav_menu(
    array(
      'theme_location' => 'footer-navigation',
      'menu_class' => 'nav fl clearfix',
      'fallback_cb' => ''
    )
  );

} // end standard_footer_menu

/**
 * Returns the text provided by the user for the title
 * of the third tab.
 */
function standard_custom_tab_text() {
  global $standard_options;
  return $standard_options->custom_tab_text;
} // end standard_custom_tab_text

/**
 * Returns the tabbed navigation for the pages on the home.
 */
function standard_get_page_tabs() {

  wp_nav_menu(
    array(
      'theme_location' => 'page-tabs',
      'menu_class' => 'clearfix',
      'fallback_cb' => ''
    )
  );
  
} // end standard_get_page_tabs

/**
 * Returns the content for each of the pages in the 
 * tabbed navigation.
 */
function standard_get_page_tab_content() {

	global $post;
  
	$menu_name = 'page-tabs';
	$locations = get_nav_menu_locations();
	$menu = wp_get_nav_menu_object($locations[$menu_name]);
	$menu_items = wp_get_nav_menu_items($menu->term_id); 
  
	$count = 0;
  if($menu_items != null && count($menu_items) > 0) {
  
    foreach($menu_items as $item => $value) {
      $post = get_post($value->object_id);
      ?>
      <div id="page-item-<?php echo $post->ID; ?>" class="clearfix tab-content <?php echo $post->post_title; echo $count == 0 ? ' active-page' : '' ?>">
        <div class="right <?php if(get_post_meta($post->ID, "image", $single = true) != "") { ?>double <?php } ?>">
          <?php
            if ( get_post_meta($post->ID, "excerpt", $single = true) <> "" ) {
              echo '<p>' . stripslashes( get_post_meta($post->ID, "excerpt", $single = true) ) . '</p>'; 
            } else {
              echo apply_filters('the_content', $post->post_content);
            } // end if/else 
            $count++;
          ?>
        </div>
      </div>
      <?php
    } // end foreach
    
  } // end if
  
} // end standard_get_page_tab_content

/**
 * Returns true if there is at least one social sharer.
 */
function standard_has_social_sharers() {
	global $standard_options;
	return
		$standard_options->social_url_1 ||
		$standard_options->social_url_2 ||
		$standard_options->social_url_3 ||
		$standard_options->social_url_4 ||
		$standard_options->social_url_5 ||
		$standard_options->social_url_6;
} // end standard_has_social_sharers

/** 
 * Creates the list of social sharing links based on the admin panel configuration.
 */
function standard_social_sharer() {
	global $standard_options;
	
	if($standard_options->social_url_1): ?>
		<li>
			<a href="<?php echo $standard_options->social_url_1; ?>" class="fade" target="_blank">
				<img src="<?php echo $standard_options->social_icon_1; ?>" alt="" />
			</a>
		</li>
	<?php endif;
	
	if($standard_options->social_url_2): ?>
		<li>
			<a href="<?php echo $standard_options->social_url_2; ?>" class="fade" target="_blank">
				<img src="<?php echo $standard_options->social_icon_2; ?>" alt="" />
			</a>
		</li>
	<?php endif;
	
	if($standard_options->social_url_3): ?>
		<li>
			<a href="<?php echo $standard_options->social_url_3; ?>" class="fade" target="_blank">
				<img src="<?php echo $standard_options->social_icon_3; ?>" alt="" />
			</a>
		</li>
	<?php endif;
	
	if($standard_options->social_url_4): ?>
		<li>
			<a href="<?php echo $standard_options->social_url_4; ?>" class="fade" target="_blank">
				<img src="<?php echo $standard_options->social_icon_4; ?>" alt="" />
			</a>
		</li>
	<?php endif;
	
	if($standard_options->social_url_5): ?>
		<li>
			<a href="<?php echo $standard_options->social_url_5; ?>" class="fade" target="_blank">
				<img src="<?php echo $standard_options->social_icon_5; ?>" alt="" />
			</a>
		</li>
	<?php endif;
	
	if($standard_options->social_url_6): ?>
		<li>
			<a href="<?php echo $standard_options->social_url_6; ?>" class="fade" target="_blank">
				<img src="<?php echo $standard_options->social_icon_6; ?>" alt="" />
			</a>
		</li>
	<?php endif;
	
} // end standard_social_sharer

/**
 * Returns whether or not to display the video bumpers regardless
 * of if the countdown is active.
 */
function standard_display_video_bumpers() {
	global $standard_options;
	return strtolower(trim($standard_options->display_video_bumpers)) != '';
} // end display_video_bumpers

/**
 * Returns whether or not to display the 'Tweet This!' button.
 */
function standard_display_tweet_this() {
	global $standard_options;
	return strlen(trim($standard_options->tweet_this_text)) != 0;
} // end standard_display_tweet_this

/**
 * Returns the value for the 'Tweet This!' text.
 */
function standard_tweet_this() {
	global $standard_options;		
	echo urlencode($standard_options->tweet_this_text);
} // end standard_tweet_this

/**
 * Returns whether or not to display the Standard sidebar advertisement.
 */
function standard_display_footer_ad() {
	global $standard_options;
	return strlen(trim($standard_options->footer_ad_url)) != 0;
} // end standard_display_footer_ad

/**
 * Renders the Standard Theme feed URL (either the user-specified feed or the native WordPress-based feed).
 */
function standard_feed_url() {	
	global $standard_options;
	echo $standard_options->feedburner_url ? $standard_options->feedburner_url : get_bloginfo_rss('rss2_url');
} // end get_feed_url

/**
 * Returns whether or not the user has an affiliate link.
 */
function standard_is_affiliate() {
	global $standard_options;
	return strlen($standard_options->aff_link) != 0;
} // end standard_is_affiliate

/**
 * Returns whether or not the user has an affiliate link.
 */
function standard_get_affiliate_url() {
	global $standard_options;
	return $standard_options->aff_link;
} // end standard_get_affiliate_url

/**
 * Renders the copyright and credit information in the footer.
 */
function standard_credit() {
	global $standard_options;
	
	echo '&copy;&nbsp;';
	echo date('Y'); 
	echo '&nbsp;';
	bloginfo(); 
	echo '&nbsp;';
	echo '&nbsp;|&nbsp;&nbsp;';
	
	_e("Powered by","livetheme"); ?>
	<?php if(standard_is_affiliate()): ?>
		<a href="<?php echo standard_get_affiliate_url(); ?>" target="_blank">
	<?php else: ?>
		<a href="http://livetheme.tv" target="_blank">
	<?php endif; ?>
		<?php _e("Live Theme", "livetheme"); ?>
	</a>
<?php } // end standard_footer

/**
 * Returns the embed code for the video feed.
 */
function standard_video_embed() {
	global $standard_options;
	echo $standard_options->video_embed_code;
} // end standard_video_embed

/**
 * Returns the embed code for the video feed.
 */
function standard_bumper_embed_code() {

	global $standard_options;
  
	if($standard_options->safe_mode) {
	  
	  preg_match_all("/<iframe (.*)? src=\'(.*)\' (.*)?><\/iframe>/", $standard_options->bumper_embed_code, $attrs);
	  foreach($attrs[0] as $attr) {
	    echo $attr;
	  } // end foreach
	    
	} else {
	  echo $standard_options->bumper_embed_code;
	} // end if/else
  
} // end standard_bumper_embed_code

/**
 * Used to display the slideshow of images while the event is offline.
 */
function standard_offline_display() {
	global $standard_options;
?>

  <?php if($standard_options->bumper_embed_code) {
    standard_bumper_embed_code();
  } else { ?>
    <?php if($standard_options->disable_bumper_1) { ?>
      <?php if($standard_options->video_bumper_1_url) { ?>
        <a href="<?php echo $standard_options->video_bumper_1_url ?>" target="_blank">
          <img src="<?php echo $standard_options->video_bumper_1; ?>" alt="" />
        </a>
      <?php } else { ?>
        <img src="<?php echo $standard_options->video_bumper_1; ?>" alt="" />
      <?php } // end if { ?>
    <?php } // end if ?>
    
    <?php if($standard_options->disable_bumper_2) { ?>
      <?php if($standard_options->video_bumper_2_url) { ?>
        <a href="<?php echo $standard_options->video_bumper_2_url ?>" target="_blank">
          <img src="<?php echo $standard_options->video_bumper_2; ?>" alt="" />
        </a>
      <?php } else { ?>
        <img src="<?php echo $standard_options->video_bumper_2; ?>" alt="" />
      <?php } // end if { ?>
    <?php } // end if ?>
    
    <?php if($standard_options->disable_bumper_3) { ?>
      <?php if($standard_options->video_bumper_3_url) { ?>
        <a href="<?php echo $standard_options->video_bumper_3_url ?>" target="_blank">
          <img src="<?php echo $standard_options->video_bumper_3; ?>" alt="" />
        </a>
      <?php } else { ?>
        <img src="<?php echo $standard_options->video_bumper_3; ?>" alt="" />
      <?php } // end if { ?>
    <?php } // end if ?>
    
    <?php if($standard_options->disable_bumper_4) { ?>
      <?php if($standard_options->video_bumper_4_url) { ?>
        <a href="<?php echo $standard_options->video_bumper_4_url ?>" target="_blank">
          <img src="<?php echo $standard_options->video_bumper_4; ?>" alt="" />
        </a>
      <?php } else { ?>
        <img src="<?php echo $standard_options->video_bumper_4; ?>" alt="" />
      <?php } // end if { ?>
    <?php } // end if ?>

     <?php if($standard_options->disable_bumper_5) { ?>
      <?php if($standard_options->video_bumper_5_url) { ?>
        <a href="<?php echo $standard_options->video_bumper_5_url ?>" target="_blank">
          <img src="<?php echo $standard_options->video_bumper_5; ?>" alt="" />
        </a>
      <?php } else { ?>
        <img src="<?php echo $standard_options->video_bumper_5; ?>" alt="" />
      <?php } // end if { ?>
    <?php } // end if ?>
    
    <?php if($standard_options->disable_bumper_6) { ?>
      <?php if($standard_options->video_bumper_6_url) { ?>
        <a href="<?php echo $standard_options->video_bumper_6_url ?>" target="_blank">
          <img src="<?php echo $standard_options->video_bumper_6; ?>" alt="" />
        </a>
      <?php } else { ?>
        <img src="<?php echo $standard_options->video_bumper_6; ?>" alt="" />
      <?php } // end if { ?>
    <?php } // end if ?>
    
    <?php if($standard_options->disable_bumper_7) { ?>
      <?php if($standard_options->video_bumper_7_url) { ?>
        <a href="<?php echo $standard_options->video_bumper_7_url ?>" target="_blank">
          <img src="<?php echo $standard_options->video_bumper_7; ?>" alt="" />
        </a>
      <?php } else { ?>
        <img src="<?php echo $standard_options->video_bumper_7; ?>" alt="" />
      <?php } // end if { ?>
    <?php } // end if ?>
    
    <?php if($standard_options->disable_bumper_8) { ?>
      <?php if($standard_options->video_bumper_8_url) { ?>
        <a href="<?php echo $standard_options->video_bumper_8_url ?>" target="_blank">
          <img src="<?php echo $standard_options->video_bumper_8; ?>" alt="" />
        </a>
      <?php } else { ?>
        <img src="<?php echo $standard_options->video_bumper_8; ?>" alt="" />
      <?php } // end if { ?>
    <?php } // end if ?>
    
    <?php if($standard_options->disable_bumper_9) { ?>
      <?php if($standard_options->video_bumper_9_url) { ?>
        <a href="<?php echo $standard_options->video_bumper_9_url ?>" target="_blank">
          <img src="<?php echo $standard_options->video_bumper_9; ?>" alt="" />
        </a>
      <?php } else { ?>
        <img src="<?php echo $standard_options->video_bumper_9; ?>" alt="" />
      <?php } // end if { ?>
    <?php } // end if ?>
    
    <?php if($standard_options->disable_bumper_10) { ?>
      <?php if($standard_options->video_bumper_10_url) { ?>
        <a href="<?php echo $standard_options->video_bumper_10_url ?>" target="_blank">
          <img src="<?php echo $standard_options->video_bumper_10; ?>" alt="" />
        </a>
      <?php } else { ?>
        <img src="<?php echo $standard_options->video_bumper_10; ?>" alt="" />
      <?php } // end if { ?>
    <?php } // end if ?>
    
    <?php if($standard_options->disable_bumper_11) { ?>
      <?php if($standard_options->video_bumper_11_url) { ?>
        <a href="<?php echo $standard_options->video_bumper_11_url ?>" target="_blank">
          <img src="<?php echo $standard_options->video_bumper_11; ?>" alt="" />
        </a>
      <?php } else { ?>
        <img src="<?php echo $standard_options->video_bumper_11; ?>" alt="" />
      <?php } // end if { ?>
    <?php } // end if ?>
    
    <?php if($standard_options->disable_bumper_12) { ?>
      <?php if($standard_options->video_bumper_12_url) { ?>
        <a href="<?php echo $standard_options->video_bumper_12_url ?>" target="_blank">
          <img src="<?php echo $standard_options->video_bumper_12; ?>" alt="" />
        </a>
      <?php } else { ?>
        <img src="<?php echo $standard_options->video_bumper_12; ?>" alt="" />
      <?php } // end if { ?>
    <?php } // end if ?>
  
  <?php } // end if/else ?>
  
<?php } // end standard_offline_display

/*-----------------------------------------------------------------*
 * 4. Advertisements
/*-----------------------------------------------------------------*/

/**
 * Display of the Sidebar Advertisement
 */
function standard_sidebar_advertisement() { 
	global $standard_options; ?>
	<div class="wrap widget">
		<?php if ($standard_options->sidebar_ad_adsense):
			echo stripslashes($standard_options->sidebar_ad_adsense); ?>
		<?php else: ?>
			<?php if($standard_options->sidebar_ad_url): ?>
				<a class="fade" href="<?php echo $standard_options->sidebar_ad_url; ?>" target="_blank">
					<img src="<?php echo $standard_options->sidebar_ad_image; ?>" alt="advert" />
				</a>
			<?php else: ?>
				<img src="<?php echo $standard_options->sidebar_ad_image; ?>" alt="advert" />
			<?php endif; ?>
		<?php endif; ?>
	</div>
<?php } // end sidebar_advertisement
register_sidebar_widget(__('Live Theme - Sidebar Ad'), 'standard_sidebar_advertisement');

/**
 * Initialize the first footer advertisement.
 */
function standard_footer_advertisement1() { 
	global $standard_options; ?>
	<div class="widget first">
		<?php if ($standard_options->footer_ad_adsense1): 
			echo stripslashes($standard_options->footer_ad_adsense1); ?>
	<?php else: ?>
		<?php if($standard_options->footer_ad_url1): ?>
			<a class="fade" href="<?php echo $standard_options->footer_ad_url1; ?>" target="_blank">
				<img src="<?php echo $standard_options->footer_ad1_image; ?>" alt="advert" />
			</a>
		<?php else: ?>
			<img src="<?php echo $standard_options->footer_ad1_image; ?>" alt="advert" />
		<?php endif; ?>
	<?php endif; ?>
	</div>
<?php } // end standard_footer_advertisement1
register_sidebar_widget(__('Live Theme - Footer Ad #1'), 'standard_footer_advertisement1');

/**
 * Initialize the second footer advertisement.
 */
function standard_footer_advertisement2() { 
	global $standard_options; ?>
	<div class="widget">
		<?php if ($standard_options->footer_ad_adsense2): 
			echo stripslashes($standard_options->footer_ad_adsense2); ?>
	<?php else: ?>
		<?php if($standard_options->footer_ad_url2): ?>
		<a class="fade" href="<?php echo $standard_options->footer_ad_url2; ?>" target="_blank">
			<img src="<?php echo $standard_options->footer_ad2_image; ?>" alt="advert" />
		</a>
		<?php else:  ?>
			<img src="<?php echo $standard_options->footer_ad2_image; ?>" alt="advert" />
		<?php endif; ?>
	<?php endif; ?>
	</div>
<?php } // end footer_advertisement2
register_sidebar_widget(__('Live Theme - Footer Ad #2'), 'standard_footer_advertisement2');

/**
 * Initialize the third footer advertisement.
 */
function standard_footer_advertisement3() { 
	global $standard_options; ?>
	<div class="widget last">
		<?php if ($standard_options->footer_ad_adsense3): 
			echo stripslashes($standard_options->footer_ad_adsense3); ?>
	<?php else: ?>
		<?php if($standard_options->footer_ad_url3): ?>
		<a class="fade" href="<?php echo $standard_options->footer_ad_url3; ?>" target="_blank">
			<img src="<?php echo $standard_options->footer_ad3_image; ?>" alt="advert" />
		</a>
		<?php else: ?>
			<img src="<?php echo $standard_options->footer_ad3_image; ?>" alt="advert" />
		<?php endif; ?>
	<?php endif; ?>
	</div>
<?php } // end footer_advertisement3
register_sidebar_widget(__('Live Theme - Footer Ad #3'), 'standard_footer_advertisement3');

/**
 * Returns whether or not to display the photo stream.
 */
function standard_display_photo_stream() {
	global $standard_options;
	return strlen($standard_options->flickr_username) > 0;
} // end standard_display_photo_feed

/**
 * Returns whether or not to use Flickr safe mode
 */
function standard_flickr_safe_mode() {
	global $standard_options;
	return strlen($standard_options->flickr_safe_mode) > 0;
} // end standard_display_photo_feed

/**
 * Returns the Flickr user ID based on the Flickr username.
 */
function standard_flickr_id() {
	
  global $standard_options;
  
  $user_id = $standard_options->flickr_username;
  if(!$standard_options->flickr_safe_mode) {
    $oXML = simplexml_load_string(curl('http://api.flickr.com/services/rest/?method=flickr.people.findByUsername&api_key=719608c6070fdf02c9845a366b401795&username=' . $standard_options->flickr_username));
    $user_id = $oXML->user['id'];
  } // end if/else
  
  return $user_id;
  
} // end standard_display_photo_stream

/*-----------------------------------------------------------------*
 * 6. Helper Functions
 *-----------------------------------------------------------------*/

/**
 * Returns data retrieved from the specified URL.
 *
 * @url	The URL to which we're making the request.
 */
function curl($url) {

	$ch = curl_init($url);
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_USERAGENT, '');
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	
	$data = curl_exec($ch);
	if(curl_errno($ch) !== 0 || curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200):
		$data === false;
	endif;
	curl_close($ch);
	
	return $data;
	
} // end curl

/*-----------------------------------------------------------------*
 * 7. Standard Theme Core
 *-----------------------------------------------------------------*/

/**
 * Generates the content container for each post (and page if enabled).
 *
 * @comment	The current comment being displayed.
 * @args	Array containing arguments for displaying the comment.
 * @depth	The depth of where this comment falls in the tree.
 */
function custom_comment($comment, $args, $depth) {
	global $standard_options;
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<a name="comment-<?php comment_ID() ?>"></a>
		<div class="comment-container">
			<div class="comment-head">
				<?php if (get_comment_type() == "comment"): ?>
					<div class="avatar">
						<?php 
						$default = null;
						if(get_comment_author_email() == get_the_author_meta('user_email', $user_ID)):
							$default = get_the_author_meta('user_email', $user_ID);
						else:
							$default = get_comment_author_email();
						endif;
						echo get_avatar($default, '36', $default = $standard_options->gravatar_image);
						?>
					</div>
					<?php endif; ?>
					<span class="name">
						<?php the_commenter_link() ?>
					</span>
					<?php if (get_comment_type() == "comment"): ?>
						<span class="date">
							<?php echo get_comment_date('F j, Y') ?> <?php _e('at','livetheme'); ?> <?php echo get_comment_time(); ?>
						</span>
						<span class="edit">
							<?php edit_comment_link(__('Edit','livetheme'), '', ''); ?>
						</span>
						<span class="perma">
							<a href="<?php echo get_comment_link(); ?>" title="Direct Link">
								#
							</a>
						</span>
						<?php endif; ?>
						<div class="fix"></div>
			</div>
			<div class="comment-entry"	id="comment-<?php comment_ID(); ?>">
				<?php comment_text() ?>
				<?php if ($comment->comment_approved == '0'): ?>
					<p class='unapproved'>
						<?php _e('Your comment is awaiting moderation','livetheme'); ?>
					</p>
					<?php endif; ?>
					<div class="reply">
						<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
					</div>
			</div>
		</div>
<?php } // end custom_comment

/**
 * Render the analytics either in the footer or the header depending on which part
 * of the page is calling this function.
 *
 * @bIsHeader	Whether or not the header is calling this function.
 */
function standard_analytics($bIsHeader) {
	global $standard_options;
	if($bIsHeader):
		if ($standard_options->google_asynchronous_analytics):
			echo stripslashes($standard_options->google_asynchronous_analytics);
		endif;
	else:
		if($standard_options->other_analytics):
			echo stripslashes($standard_options->other_analytics);
		endif;
	endif;
} // end standard_analytics

/**
 * Renders the archive header and formats it 	based on which type of page archive the user is viewing.
 *
 * @isDay		Whether or not the user is viewing a daily archive
 * @isMonth		Whether or not the user is viewing a monthly archive
 * @isYear		Whether or not the user is viewing a yearly archive
 * @isAuthor	Whether or not the user is viewing an author archive
 * @isTag		Whether or not the user is viewing a tag archive
 * @wp_query	The WordPress query object used to display the category RSS link.
 */
function standard_archive_header($isDay, $isMonth, $isYear, $isAuthor, $isTag, $wp_query) {
	if ($isDay):
		printf(__('Archive - %s','livetheme'), get_the_time('F j, Y'));
	elseif ($isMonth):
			printf(__('Archive - %s','livetheme'), get_the_time('F, Y'));
	elseif ($isYear):
			printf(__('Archive - %s','livetheme'), get_the_time('Y')); 
	elseif ($isAuthor):
			_e('Archive by Author','livetheme');
	elseif ($isTag):
		printf(__('Tag Archive - %s','livetheme'), single_tag_title('', true));
	endif;
} // end standard_archive_header

/**
 * Returns the title of the category archive.
 */
function standard_get_archive_title() {
	printf(__('Archive - %s','livetheme'), ''); single_cat_title();
} // end standard_get_archive_title

/**
 * Returns the RSS link for the given category.
 *
 * $cat_id	The ID of the category for which to return the feed link.
 */
function standard_get_archive_rss_container($wp_query) {
	
	$str_rss_link = '';
	
	$cat_obj = $wp_query->get_queried_object(); 
	$cat_id = $cat_obj->cat_ID; 
	
	$str_rss_link = '<a href="' . get_category_feed_link($cat_id, '') . '">';
		$str_rss_link .= __("RSS Feed", "livetheme");
	$str_rss_link .= '</a>';
	
	return $str_rss_link;
	
} // end standard_archive_rss_container

/**
 * Formats the commenter's link before writing it out to the page.
 */
function the_commenter_link() {
	$commenter = get_comment_author_link();
	if (ereg( ']* class=[^>]+>', $commenter )):
		$commenter = ereg_replace( '(]* class=[\'"]?)', '\\1url ' , $commenter );
	else: 
		$commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );
	endif;
	echo $commenter;
} // end the_commenter_link

/**
 * Remove the 'No Categories' tag from the specified str.
 *
 * @str	The string from which to remove 'No Categories'
 */
function hide_empty_category_notice($str) {
	if(!empty($str)):
		return str_ireplace('<li>' . __('No categories') . '</li>', '', $str);
	endif;
} // end hide_empty_category_notice

/**
 * Returns the navigation menu.
 *
 * @is_footer	Whether or not this function is being called for the footer.
 */
function standard_navigation_menu($is_footer) {
	
	global $standard_options;
	
	$page_ids = '';
	if($standard_options->page_exclude):
		foreach($standard_options->page_exclude as $pid):
			$page_ids .= $pid . ',';
		endforeach;
	endif;
	wp_list_pages('sort_column=menu_order&title_li=&depth=-1&exclude=' . $page_ids);
			
  if(!$standard_options->hide_footer_categories) {
    $cat_ids = '';
    if($standard_options->category_exclude):
      foreach($standard_options->category_exclude as $cid):
        $cat_ids .= $cid . ',';
      endforeach;
    endif;
    wp_list_categories('show_option_all=&hide_empty=1&style=list&title_li=&hierarchical=0&depth=-1&exclude=' . $cat_ids);
  } // end if/else
	
} // end standard_navigation_menu
add_filter('wp_list_categories', 'hide_empty_category_notice');

?>