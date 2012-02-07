<?php

add_action( 'wptouch_theme_init', 'classic_init' );
add_action( 'wptouch_theme_language', 'classic_language' );
add_filter( 'wptouch_body_classes', 'classic_body_classes' );
add_action( 'wptouch_post_head', 'classic_custom_style' );
add_action( 'wptouch_post_head', 'classic_compat_css' );
add_action( 'wptouch_post_head', 'classic_iphone_meta' );
add_filter( 'pre_get_posts', 'classic_exclude_categories' );
add_filter( 'wptouch_has_post_thumbnail', 'classic_has_post_thumbnail' );
add_filter( 'wptouch_the_post_thumbnail', 'classic_the_post_thumbnail' );

//--Device Theme Functions for Classic --//

function classic_init() {
	$minfile = WPTOUCH_DIR . '/themes/classic/iphone/theme-min.js';
		if ( file_exists( $minfile ) ) {
			wp_enqueue_script( 'classic-js', wptouch_get_bloginfo('template_directory') . '/theme-min.js', array('jquery'), md5( WPTOUCH_VERSION ) );
		} else {
			wp_enqueue_script( 'classic-js', wptouch_get_bloginfo('template_directory') . '/theme.js', array('jquery'), md5( WPTOUCH_VERSION ) );
		}
}

function classic_compat_css() {
	$settings = wptouch_get_settings();
	$minfile = WPTOUCH_DIR . '/themes/classic/iphone/compat-min.css';
	if ( $settings->classic_use_compat_css ) {
		if ( file_exists( $minfile ) ) {
			echo "<link rel='stylesheet' type='text/css' href='" . wptouch_get_bloginfo('template_directory') . "/compat-min.css?ver=" . md5( WPTOUCH_VERSION ) . "' /> \n";
		} else {
			echo "<link rel='stylesheet' type='text/css' href='" . wptouch_get_bloginfo('template_directory') . "/compat.css?ver=" . md5( WPTOUCH_VERSION ) . "' /> \n";		
		}
	}
}

// New in 2.0.7, include the custom styles file
function classic_custom_style() {
	include('dynamic-style.php' );
}

function classic_language( $locale ) {
	// In a normal theme a language file would be loaded here for text translation
}

// This spits out all the meta tags for iPhone/iPod touch/iPad stuff 
// (web-app, startup img, device width, status bar style)
function classic_iphone_meta() {
	$settings = wptouch_get_settings();
	$status_type = $settings->classic_webapp_status_bar_color;
	echo "<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' /> \n";

	if ( $settings->classic_webapp_enabled ) {
		echo "<meta name='apple-mobile-web-app-status-bar-style' content='" . $status_type . "' /> \n";	
		echo "<meta name='apple-mobile-web-app-capable' content='yes' /> \n";
		
		if ( $settings->classic_webapp_use_loading_img && !$settings->classic_webapp_loading_img_location ) {
			echo "<link rel='apple-touch-startup-image' href='" . wptouch_get_bloginfo('template_directory') . "/images/startup.png' /> \n";
		} elseif ( $settings->classic_webapp_use_loading_img && $settings->classic_webapp_loading_img_location ) {
			echo "<link rel='apple-touch-startup-image' href='" . $settings->classic_webapp_loading_img_location . "' /> \n";
		} 			
	} 
}

// Add background image name and post icon type for styling diffs
function classic_body_classes( $body_classes ) {
	$settings = wptouch_get_settings();
	
	$is_idevice = strstr( $_SERVER['HTTP_USER_AGENT'],'iPad') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPod' );
	
	$body_classes[] = $settings->classic_header_color_style;

	$body_classes[] = $settings->classic_background_image;

	$body_classes[] = $settings->classic_icon_type;

	$body_classes[] = $settings->classic_calendar_icon_bg;

	$body_classes[] = $settings->classic_show_excerpts;
	
	$body_classes[] = $settings->classic_text_justification;
	
	if ( !$settings->enable_menu_icons ) {
		$body_classes[] = 'no-icons';
	}

	if ( $settings->make_menu_relative ) {
		$body_classes[] = 'relative-menu';
	}
	
	if ( $settings->classic_webapp_status_bar_color == 'black-translucent' ) {
		$body_classes[] = $settings->classic_webapp_status_bar_color;
	}

	if ( !$is_idevice ) {
		$body_classes[] = 'idevice';
	}	

	if ( $settings->classic_enable_persistent ) {
		$body_classes[] = 'loadsaved';
	}

	return $body_classes;
}

// Previous + Next Post Functions For Single Post Pages
function classic_get_previous_post_link() {
	$prev_post = get_previous_post(); 
	if ( $prev_post ) {
		$prev_post = get_previous_post( false ); 
		$prev_url = get_permalink( $prev_post->ID ); 
//		echo '<a href="#" rel="' . $prev_url . '" class="nav-back ajax-link">' . __( "Back", "wptouch-pro" ) . '</a>'; <- playing with ajax
		echo '<a href="' . $prev_url . '" class="nav-back ajax-link">' . __( "Back", "wptouch-pro" ) . '</a>';
	}
}

// New logo code
function classic_has_logo() {
	$settings = wptouch_get_settings();
		if ( $settings->classic_header_img_location || $settings->classic_retina_header_img_location ) {
			return true;
		} else {
			return false;
		}
}

function classic_logo_img() {
	$settings = wptouch_get_settings();
	if ( $settings->classic_retina_header_img_location ) {
		echo "<img id='retina-custom-logo' src='" . $settings->classic_retina_header_img_location . "' alt='retina-logo-image' /> \n";
	} else {
		echo "<img id='custom-logo' src='" . $settings->classic_header_img_location . "' alt='logo-image' /> \n";
	}
}

// 2.0.8
function classic_show_site_icon() {
	$settings = wptouch_get_settings();
		if ( $settings->classic_show_header_icon ) {
			return true;
		} else {
			return false;		
		}
}

// 2.0.7 - menu menu text vs. icon option
function classic_has_menu_icon() {
	$settings = wptouch_get_settings();
	
	if ( $settings->classic_use_menu_icon ) {
		return true;
	} else {
		return false;
	}
}

function classic_get_next_post_link() {
	$next_post = get_next_post(); 
	if ( $next_post ) {
		$next_post = get_next_post( false );
		$next_url = get_permalink( $next_post->ID ); 
//		echo '<a href="#" rel="' . $next_url . '" class="nav-fwd ajax-link">'. __( "Next", "wptouch-pro" ) . '</a>'; <- playing with ajax
		echo '<a href="' . $next_url . '" class="nav-fwd ajax-link">'. __( "Next", "wptouch-pro" ) . '</a>';
	}
}

// Dynamic archives heading text for archive result pages, and search
function classic_archive_text() {
	if ( !is_home() ) {
		echo '<div class="archive-text">';
	}
	if ( is_search() ) {
		echo sprintf( __( "Search results &rsaquo; %s", "wptouch-pro" ), get_search_query() );
	} if ( is_category() ) {
		echo sprintf( __( "Categories &rsaquo; %s", "wptouch-pro" ), single_cat_title( "", false ) );
	} elseif ( is_tag() ) {
		echo sprintf( __( "Tags &rsaquo; %s", "wptouch-pro" ), single_tag_title(" ", false ) );
	} elseif ( is_day() ) {
		echo sprintf( __( "Archives &rsaquo; %s", "wptouch-pro" ),  get_the_time( 'F jS, Y' ) );
	} elseif ( is_month() ) {
		echo sprintf( __( "Archives &rsaquo; %s", "wptouch-pro" ),  get_the_time( 'F, Y' ) );
	} elseif ( is_year() ) {
		echo sprintf( __( "Archives &rsaquo; %s", "wptouch-pro" ),  get_the_time( 'Y' ) );
	} elseif ( is_404() ) {
		echo( __( "404 Not Found", "wptouch-pro" ) );
	}
	if ( !is_home() ) {
		echo '</div>';
	}
}

// If Ajax load more is turned off, this shows
function classic_archive_navigation_back() {
	if ( is_search() ) {
		previous_posts_link( __( 'Back in Search', "wptouch-pro" ) );
	} elseif ( is_category() ) {
		previous_posts_link( __( 'Back in Category', "wptouch-pro" ) );
	} elseif ( is_tag() ) {
		previous_posts_link( __( 'Back in Tag', "wptouch-pro" ) );
	} elseif ( is_day() ) {
		previous_posts_link( __( 'Back One Day', "wptouch-pro" ) );
	} elseif ( is_month() ) {
		previous_posts_link( __( 'Back One Month', "wptouch-pro" ) );
	} elseif ( is_year() ) {
		previous_posts_link( __( 'Back One Year', "wptouch-pro" ) );
	}
}

// If Ajax load more is turned off, this shows
function classic_archive_navigation_next() {
	if ( is_search() ) {
		next_posts_link( __( 'Next in Search', "wptouch-pro" ) );
	} elseif ( is_category() ) {		  
		next_posts_link( __( 'Next in Category', "wptouch-pro" ) );
	} elseif ( is_tag() ) {
		next_posts_link( __( 'Next in Tag', "wptouch-pro" ) );
	} elseif ( is_day() ) {
		next_posts_link( __( 'Next One Day', "wptouch-pro" ) );
	} elseif ( is_month() ) {
		next_posts_link( __( 'Next One Month', "wptouch-pro" ) );
	} elseif ( is_year() ) {
		next_posts_link( __( 'Next One Year', "wptouch-pro" ) );
	}
}

function classic_wp_comments_nav_on() {
	if ( get_option( 'page_comments' ) ) {
		return true;
	} else {
		return false;
	}
}

function classic_show_comments_on_pages() {
	$settings = wptouch_get_settings();
	if ( comments_open() ) {
		return $settings->classic_show_comments_on_pages;
	} else {
		return false;
	}
}

// 2.0.8.2
function show_webapp_notice() {
	$settings = wptouch_get_settings();
	if ( $settings->classic_webapp_enabled && $settings->classic_show_webapp_notice ) {
		return true;
	} else {
		return false;
	}
}

function classic_is_ajax_enabled() {
	$settings = wptouch_get_settings();
	return $settings->classic_ajax_mode_enabled;
}

function classic_use_calendar_icons() {
	$settings = wptouch_get_settings();
	return $settings->classic_icon_type == 'calendar';
}

function classic_use_thumbnail_icons() {
	$settings = wptouch_get_settings();
	return ( $settings->classic_icon_type != 'calendar' && $settings->classic_icon_type != 'none' );
}

function classic_background() {
	$settings = wptouch_get_settings();
	return $settings->classic_background_image;
}

function classic_show_categories_tab() {
	$settings = wptouch_get_settings();
	return $settings->classic_show_categories;
}

function classic_show_tags_tab() {
	$settings = wptouch_get_settings();
	return $settings->classic_show_tags;
}

function classic_show_account_tab() {
	$settings = wptouch_get_settings();
	if ( get_option( 'comment_registration' ) || get_option( 'users_can_register' ) || $settings->classic_show_account ) {
		return true;
	} else {
		return false;
	}
}

function classic_show_admin_menu_link() {
	$settings = wptouch_get_settings();
	if ( classic_show_account_tab() ) {
		if ( $settings->classic_show_admin_menu_link ) {
			return true;
		} else {
			return false;
		}
	}
}

function classic_show_profile_menu_link() {
	$settings = wptouch_get_settings();
	if ( classic_show_account_tab() ) {
		if ( $settings->classic_show_profile_menu_link ) {
			return true;
		} else {
			return false;
		}
	}
}

function classic_show_search_button() {
	$settings = wptouch_get_settings();
	return $settings->classic_show_search;
}

function classic_show_author_in_posts() {
	$settings = wptouch_get_settings();
	return $settings->classic_show_post_author;
}

function classic_show_categories_in_posts() {
	$settings = wptouch_get_settings();
	return $settings->classic_show_post_categories;
}

function classic_show_tags_in_posts() {
	$settings = wptouch_get_settings();
	return $settings->classic_show_post_tags;
}

function classic_show_date_in_posts() {
	$settings = wptouch_get_settings();
	return $settings->classic_show_post_date;
}

function classic_first_full_post() {
	$settings = wptouch_get_settings();
	if ( $settings->classic_show_excerpts == 'first-full-hidden' || $settings->classic_show_excerpts == 'first-full-shown' ) {
		return true;
	} else {
		return false;
	}
}

function classic_show_all_full_post() {
	$settings = wptouch_get_settings();
	if ( $settings->classic_show_excerpts == 'full-hidden' || $settings->classic_show_excerpts == 'full-shown' ) {
		return true;
	} else {
		return false;
	}
}

function classic_excerpts_open() {
	$settings = wptouch_get_settings();
	if ( $settings->classic_show_excerpts == 'excerpts-shown' || $settings->classic_show_excerpts == 'first-full-shown' ) {
		return true;
	} else {
		return false;
	}
}

function classic_exclude_categories($query) {
	$settings = wptouch_get_settings();
	$cats = $settings->classic_excluded_categories;
	
	if ( $cats ) {
		$icats = explode( ",", $cats );
		$new_cats = array();
		
		foreach( $icats as $icat ) {
			$new_cats[] = "-" . $icat;
		}
	
		$cats = implode( ",",  $new_cats );
	
		if ( $query->is_home || $query->is_search || $query->is_archive ) {
			$query->set('cat', $cats);
		}
	}
	
	return $query;
}

// Check what order comments are displayed, governs whether 'load more comments' link uses previous_ or next_ function
function classic_comments_newer() {
	if ( get_option( 'default_comments_page' ) == 'newest' ) {
			return true;
		} else {
			return false;
		}
}

// Thumbnail stuff added in 2.0.4
function classic_has_post_thumbnail() {
	global $post;
	
	$settings = wptouch_get_settings();
	
	$has_post_thumbnail = false;
	
	switch( $settings->classic_icon_type ) {
		case 'thumbnails':
			$has_post_thumbnail = function_exists( 'has_post_thumbnail' ) && has_post_thumbnail();
			break;
		case 'simple_thumbs':
			$has_post_thumbnail = function_exists( 'p75GetThumbnail' ) && p75HasThumbnail( $post->ID );
			break;
		case 'custom_thumbs':
			$has_post_thumbnail = get_post_meta( $post->ID, $settings->classic_custom_field_thumbnail_name, true ) || get_post_meta( $post->ID, 'Thumbnail', true ) || get_post_meta( $post->ID, 'thumbnail', true );
			break;
	}

	return $has_post_thumbnail;
}

function classic_the_post_thumbnail( $thumbnail ) {
	global $post;
	
	$settings = wptouch_get_settings();	
	$custom_field_name = $settings->classic_custom_field_thumbnail_name;
	
	switch( $settings->classic_icon_type ) {
		case 'thumbnails':
			if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail() ) {
				return $thumbnail;	
			}
			break;
		case 'simple_thumbs':
			if ( function_exists( 'p75GetThumbnail' ) && p75HasThumbnail( $post->ID ) ) {
				return p75GetThumbnail( $post->ID );	
			}
			break;
		case 'custom_thumbs':
			if ( get_post_meta( $post->ID, $custom_field_name, true ) ) {
				return get_post_meta( $post->ID, $custom_field_name, true );
			} else if ( get_post_meta( $post->ID, 'Thumbnail', true ) ) {
				return get_post_meta( $post->ID, 'Thumbnail', true );
			} else if ( get_post_meta( $post->ID, 'thumbnail', true ) ) {
				return get_post_meta( $post->ID, 'thumbnail', true );
			}
			
			break;
	}		
	// return default if none of those exist
	return wptouch_get_bloginfo( 'template_directory' ) . '/images/retina/retina-default-thumbnail.png';
}

function classic_thumbs_on_single() {
	$settings = wptouch_get_settings();	
	if ( $settings->classic_thumbs_on_single ) {
		return true;
	} else {
		return false;
	}
}

function classic_thumbs_on_pages() {
	$settings = wptouch_get_settings();	
	if ( $settings->classic_thumbs_on_pages && classic_has_post_thumbnail() ) {
		return true;
	} else {
		return false;
	}
}

//Single Post Page
function classic_show_date_single() {
	$settings = wptouch_get_settings();
	return $settings->classic_show_post_date_single;
}

function classic_show_author_single() {
	$settings = wptouch_get_settings();
	return $settings->classic_show_post_author_single;
}

function classic_show_cats_single() {
	$settings = wptouch_get_settings();
	return $settings->classic_show_post_cats_single;
}

function classic_show_tags_single() {
	$settings = wptouch_get_settings();
	return $settings->classic_show_post_tags_single;
}

function classic_show_share_single() {
	$settings = wptouch_get_settings();
	return $settings->classic_show_share_save;
}

function classic_hide_responses() {
	$settings = wptouch_get_settings();
	return $settings->classic_hide_responses;
}

function classic_com_toggle() {
	$comment_string1 = __( 'No Responses', 'wptouch-pro' );
	$comment_string2 = __( '1 Response', 'wptouch-pro' );
	$comment_string3 = __( '% Responses', 'wptouch-pro' );
	if ( classic_show_share_single() ) {
		echo '<a id="comments-' . get_the_ID() . '" class="post no-ajax rounded-corners-8px com-toggle">';
	} else {
		echo '<a id="comments-' . get_the_ID() . '" class="post no-ajax rounded-corners-8px com-toggle comments-center">';	
	}
	if ( classic_hide_responses() ) {
		echo '<img id="com-arrow" class="com-arrow" src="' . wptouch_get_bloginfo('template_directory') . '/images/com_arrow.png" alt="arrow" />';
	} else {
		echo '<img id="com-arrow" class="com-arrow-down" src="' . wptouch_get_bloginfo('template_directory') . '/images/com_arrow.png" alt="arrow" />';	
	}
	comments_number( $comment_string1, $comment_string2, $comment_string3 );
	echo '</a>';
}

// Custom Comments
// Custom callback to list comments in the your-theme style
function classic_custom_comments( $comment, $args, $depth ) {
	$GLOBALS[ 'comment' ] = $comment;
	$GLOBALS[ 'comment_depth' ] = $depth;
  ?>
   <li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
    <div class="comment-top">
    	<?php classic_commenter_link() ?>
    	<div class="comment-meta">
	    	<?php printf( __( '%1$s - %2$s <span class="meta-sep"></span>'),
				get_comment_date(), 
				get_comment_time() ); 
			?>
	    	<div class="comment-buttons">
		    	<?php edit_comment_link( __( 'Edit', "wptouch-pro" ), ' <span class="edit-link">', '</span>' ); ?>
			<?php if ( !class_exists( 'wp_thread_comment' ) ) // echo the comment reply link
				if( $args[ 'type' ] == 'all' || get_comment_type() == 'comment' ) : comment_reply_link( 
					array_merge( 
						$args, array(
							'reply_text' => __( 'Reply',"wptouch-pro" ),
							'login_text' => __( 'Log in to reply.',"wptouch-pro" ),
							'depth' => $depth
						)
					) 
				);
				endif; ?>
			</div>
    	</div>
		<?php if ( $comment->comment_approved == '0' ) __( "<span class='unapproved'>Your comment is awaiting moderation.</span>", "wptouch-pro" ) ?>
	</div>

	<div class="comment-content">
		<?php comment_text() ?>
	</div>

<?php } // end custom_comments

// Produces an avatar image with the hCard-compliant photo class
function classic_commenter_link() {
	$commenter = get_comment_author_link();
	if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
		$commenter = ereg_replace( '(<a[^>]* class=[\'"]?)', '\\1url ' , $commenter );
	} else {
		$commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );
	}
	
	$avatar_email = get_comment_author_email();
	$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, 68 ) );
	echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
} // end commenter_link

?>