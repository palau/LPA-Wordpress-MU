<?php 

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Misc
- WooTabs - Popular Posts
- WooTabs - Latest Posts
- WooTabs - Latest Comments
- WordPress 3.0 New Features Support

-----------------------------------------------------------------------------------*/



/*-----------------------------------------------------------------------------------*/
/* Misc */
/*-----------------------------------------------------------------------------------*/

// Show sidebar on left
function woo_sidebar_left() {
	if ( get_option('woo_left_sidebar') == "true" ) 
		echo '<style type="text/css">#main.col-left { float:right; } #main.col-right { float:left; }</style>' . "\n";
} 
add_action('wp_head','woo_sidebar_left');

// Use Cufon font replacement
function woo_cufon() {
	if ( get_option('woo_cufon') == "true" ) {
		echo '<script type="text/javascript">Cufon.replace("h2, h3, h4, h5, h6, .title, .cufon");</script>' . "\n";
		echo '<style type="text/css">.widget h3 { line-height:22px; }</style>' . "\n";
    }
} 
add_action('wp_head','woo_cufon');

// Show Category descriptions in menu
function woo_menu_description() {
	if ( get_option('woo_menu_desc') == "true" ) { 
		$GLOBALS[desc] = "true"; 
		echo '<style type="text/css">#secnav a { line-height:16px; padding:13px 15px; }</style>' . "\n";
	}
}
add_action('wp_head','woo_menu_description');


// SET GLOBAL WOO VARIABLES
function woo_globals() {
	
	// Featured dimensions
	$GLOBALS['align_feat'] = 'alignleft'; if (get_option('woo_align_feat')) $GLOBALS['align_feat'] = get_option('woo_align_feat'); 			
	$GLOBALS['thumb_width_feat'] = '200'; if (get_option('woo_thumb_width_feat')) $GLOBALS['thumb_width_feat'] = get_option('woo_thumb_width_feat'); 		
	$GLOBALS['thumb_height_feat'] = '200'; if (get_option('woo_thumb_height_feat')) $GLOBALS['thumb_height_feat'] = get_option('woo_thumb_height_feat'); 

	// Thumbnail dimensions
	$GLOBALS['align'] = 'alignleft'; if (get_option('woo_align')) $GLOBALS['align'] = get_option('woo_align'); 			
	$GLOBALS['thumb_width'] = '200'; if (get_option('woo_thumb_width')) $GLOBALS['thumb_width'] = get_option('woo_thumb_width'); 		
	$GLOBALS['thumb_height'] = '200'; if (get_option('woo_thumb_height')) $GLOBALS['thumb_height'] = get_option('woo_thumb_height'); 

	// Featured Tags
	$GLOBALS['feat_tags_array'] = array();

	// Duplicate posts 
	$GLOBALS['shownposts'] = array();

	// Video Category
	global $wpdb;
	$video_cat = get_option('woo_video_category'); 
	$GLOBALS[video_id] = $wpdb->get_var("SELECT term_id FROM $wpdb->terms WHERE name = '$video_cat'");
}

// Remove image dimentions from woo_get_image images
update_option('woo_force_all',false);
update_option('woo_force_single',false);


// SHOW SOCIAL BOOKMARKS
function woo_social() {
?>
<a href="http://twitter.com/home/?status=<?php the_title(); ?> : <?php echo get_tiny_url(get_permalink($post->ID)); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/ico-social-twitter.png" alt="Twitter" /></a>
<a href="http://digg.com/submit?phase=2&amp;url=<?php the_permalink() ?>"><img src="<?php bloginfo('template_directory'); ?>/images/ico-social-digg.png" alt="Digg" /></a>                            
<a href="http://del.icio.us/post?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/ico-social-delicious.png" alt="Delicious" /></a>                            
<a href="http://www.stumbleupon.com/submit?url=<?php the_permalink() ?>&amp;title=<?php echo urlencode(the_title('','', false)) ?>"><img src="<?php bloginfo('template_directory'); ?>/images/ico-social-stumbleupon.png" alt="Stumbleupon" /></a>                            
<a href="http://technorati.com/cosmos/search.html?url=<?php the_permalink() ?>"><img src="<?php bloginfo('template_directory'); ?>/images/ico-social-technorati.png" alt="Technorati" /></a>                            
<a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&amp;t=<?php the_title(); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/ico-social-facebook.png" alt="Facebook" /></a>
<a href="mailto:EMAIL ADDRESS?body=<?php the_permalink() ?>"><img src="<?php bloginfo('template_directory'); ?>/images/ico-social-mail.png" alt="Email" /></a>                           
<?php 
}

// Shorten URL for Twitter
function get_tiny_url($url) {
 
 if (function_exists('curl_init')) {
   $url = 'http://tinyurl.com/api-create.php?url=' . $url;
 
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_HEADER, 0);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_URL, $url);
   $tinyurl = curl_exec($ch);
   curl_close($ch);
 
   return $tinyurl;
 }
 
 else {
   # cURL disabled on server; Can't shorten URL
   # Return long URL instead.
   return $url;
 }
 
}

// Shorten Excerpt text for use in theme
function woo_excerpt($text, $chars = 120) {
	$text = $text." ";
	$text = substr($text,0,$chars);
	$text = substr($text,0,strrpos($text,' '));
	$text = $text."...";
	return $text;
}

// Add custom color		
function woo_custom_color() {
	$color = get_option('woo_custom_color');
	if ( $color ) {
		$path = get_bloginfo('template_directory');
		echo '<style type="text/css">#top {background:'.$color.' url('.$path.'/images/bg-gradient.png) no-repeat top center!important;}</style>' . "\n";
	}
	$link = get_option('woo_custom_link');
	if ( $link ) {
		$path = get_bloginfo('template_directory');
		echo '<style type="text/css">a:link, a:visited, #tabs ul.wooTabs li a.selected, #tabs ul.wooTabs li a:hover {color:'.$link.'} .entry a.btn, input.submit, #commentform #submit {background-color:'.$link.'; border-color:'.$link.';} </style>' . "\n";
	}
	
} 
add_action('woo_head','woo_custom_color');


/*-----------------------------------------------------------------------------------*/
/* WooTabs - Popular Posts */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('woo_tabs_popular')) {
	function woo_tabs_popular( $posts = 5, $size = 35 ) {
		$popular = new WP_Query('orderby=comment_count&posts_per_page='.$posts);
		while ($popular->have_posts()) : $popular->the_post();
	?>
	<li>
		<?php if ($size <> 0) woo_get_image('image',$size,$size,'thumbnail',90,null,'src',1,0,'','',true,false,false); ?>
		<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
		<span class="meta"><?php the_time($GLOBALS['woodate']); ?></span>
		<div class="fix"></div>
	</li>
	<?php endwhile; 
	}
}


/*-----------------------------------------------------------------------------------*/
/* WooTabs - Latest Posts */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('woo_tabs_latest')) {
	function woo_tabs_latest( $posts = 5, $size = 35 ) {
		$the_query = new WP_Query('showposts='. $posts .'&orderby=post_date&order=desc');	
		while ($the_query->have_posts()) : $the_query->the_post(); 
	?>
	<li>
		<?php if ($size <> 0) woo_get_image('image',$size,$size,'thumbnail',90,null,'src',1,0,'','',true,false,false); ?>
		<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
		<span class="meta"><?php the_time($GLOBALS['woodate']); ?></span>
		<div class="fix"></div>
	</li>
	<?php endwhile; 
	}
}



/*-----------------------------------------------------------------------------------*/
/* WooTabs - Latest Comments */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('woo_tabs_comments')) {
	function woo_tabs_comments( $posts = 5, $size = 35 ) {
		global $wpdb;
		$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID,
		comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved,
		comment_type,comment_author_url,
		SUBSTRING(comment_content,1,50) AS com_excerpt
		FROM $wpdb->comments
		LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID =
		$wpdb->posts.ID)
		WHERE comment_approved = '1' AND comment_type = '' AND
		post_password = ''
		ORDER BY comment_date_gmt DESC LIMIT ".$posts;
		
		$comments = $wpdb->get_results($sql);
		
		foreach ($comments as $comment) {
		?>
		<li>
			<?php echo get_avatar( $comment, $size ); ?>
		
			<a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php _e('on ', 'woothemes'); ?> <?php echo $comment->post_title; ?>">
				<?php echo strip_tags($comment->comment_author); ?>: <?php echo strip_tags($comment->com_excerpt); ?>...
			</a>
			<div class="fix"></div>
		</li>
		<?php 
		}
	}
}



/*-----------------------------------------------------------------------------------*/
/* WordPress 3.0 New Features Support */
/*-----------------------------------------------------------------------------------*/

if ( function_exists('wp_nav_menu') ) {
	add_theme_support( 'nav-menus' );
	register_nav_menus( array( 'primary-menu' => __( 'Primary Menu' ), 'secondary-menu' => __( 'Secondary Menu' ) ) );
}

?>