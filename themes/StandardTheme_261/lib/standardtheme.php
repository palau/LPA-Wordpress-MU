<?php

/*-----------------------------------------------------------------*
 * Standard Theme 2.5.4
 * The 8BIT Network
 *
 * 1. Framework Dependencies
 * 2. WordPress Customization
 * 3. Framework  
 * 4. Widgets
 * 5. Custom Functions
 *-----------------------------------------------------------------*/

/*-----------------------------------------------------------------*
 * 1. Framework Dependencies
 *-----------------------------------------------------------------*/
 
require_once('standard_theme_nav_walker.php');
require_once('wp-pagenavi.php');
require_once('standard_yoast_breadcrumbs.php');
require_once('yoast_posts.php');
require_once('followcount.php');
 
/*-----------------------------------------------------------------*
 * 2. WordPress Customization
 *-----------------------------------------------------------------*/

/**
 * Inserts the post thumbnail into the content feed.
 *
 * @content	The post content.
 */
function insert_thumbnail($content) {
	global $post;
	if (has_post_thumbnail( $post->ID )):
		$content = '<p>' . get_the_post_thumbnail( $post->ID, 'thumbnail' ) . '</p>' . $content;
	endif;
	return $content;
} // end insert_thumbnail

/**
 * Adds Twitter and Facebook into the $contactmethods array.
 * 
 * @contactmethods	The array used to store ways to contact the author.
 */
function additional_contact_methods($contactmethods) {
	$contactmethods['twitter'] = 'Twitter';
	$contactmethods['facebook'] = 'Facebook';
	return $contactmethods;
} // end additional_contact_methods
add_filter('user_contactmethods','additional_contact_methods',10,1);

/**
 * Generates content for sending a post via email.
 * 
 * @text	Text used as the link title and content.
 */
function direct_email($text="Share By Email") {
	global $post;
	$title = htmlspecialchars($post->post_title);
	$subject = sprintf(__('Check this Post from %s - %s','standardtheme'), htmlspecialchars(get_bloginfo('name')), $title);
	$body = sprintf(__('I recommend this page : %s. You can read it on : %s','standardtheme'), $title, get_permalink($post->ID));
	$link = '<a rel="nofollow" href="mailto:?subject='.rawurlencode($subject).'&amp;body='.rawurlencode($body).'" title="'.$text.' : '.$title.'">'.$text.'</a>';
	return $link;
} // end direct_email


/**
 * Loads the custom stylesheet, favicon, optionally echos the Standard Theme option output.
 */
function stwpthemes_wp_head() {
	global $standard_options;
	if(!$standard_options->disable_css3_effects): 
		echo '<link href="' . get_bloginfo('template_directory') . '/css/css3.css" rel="stylesheet" type="text/css" />' . "\n";
	endif;
	echo '<link rel="shortcut icon" href="' . $standard_options->custom_favicon . '" type="image/vnd.microsoft.icon" />'."\n";
	echo '<link href="'. get_bloginfo('template_directory') .'/custom.css" rel="stylesheet" type="text/css" />'."\n";
	$decode = $_REQUEST['decode'];
	if ($decode == 'true'):
		stwp_option_output();
	endif;
} // end stwpthemes_wp_head

/**
 * Echoes the content generator meta tag for Standard.
 */
function stwp_option_output() {
	$data = get_option('stwp_settings_encode');
	echo '<meta name="generator" content="' . $data . '" />';
} // end stwp_option_output

/**
 * Defines the basis for the Standard Theme framework (version, styles, and general meta tags).
 */
function stwp_version() {
	$theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
	$theme_version = $theme_data['Version'];
	echo '<meta name="generator" content="Standard Theme ' . $theme_version .'" />' ."\n";
} // end stwp_version
remove_action('wp_head', 'wp_generator');
add_action('wp_head','stwp_version');

/**
 * Initializes the array of shortcodes used throughout the theme.
 *
 * @attr	The array used to store the shortcode attributes.
 */
function stwp_post_insert_shortcode($attr) {
	$output = apply_filters('insert', '', $attr);
	if ( $output != '' ):
		return $output;
	endif;
	extract(shortcode_atts(array(
		'name'		=> null,
		'id'		 => null,
		'before'	=> '',
		'after'		=> ''
		), $attr));
	$id = intval($id);
	global $wpdb;
	if ($name == ''):
		$query = "SELECT post_content FROM $wpdb->posts WHERE id = $id";
	else:
		$query = "SELECT post_content FROM $wpdb->posts WHERE post_name = '$name'";
	endif;
	$result = $wpdb->get_var($query);
	if (!empty($result)):
		$result = wpautop( $result, $br = 1 );
		return $before . $result . $after;
	else:
		return;
	endif;
} // end stwp_post_insert_shortcode
add_shortcode('insert', 'stwp_post_insert_shortcode');

/**
 * Defines the custom fields for the Standard Theme.
 */ 
function stwpthemes_metabox_create() {
	global $post;
	$stwp_metaboxes = get_option('stwp_custom_template');
	$output = '';
	$output .= '<table class="stwp_metaboxes_table">'."\n";
	foreach ($stwp_metaboxes as $stwp_id => $stwp_metabox) {
		if (
			$stwp_metabox['type'] == 'text'
			OR		$stwp_metabox['type'] == 'select'
			OR		$stwp_metabox['type'] == 'checkbox'
			OR		$stwp_metabox['type'] == 'textarea'
			OR		$stwp_metabox['type'] == 'radio'
			)
			$stwp_metaboxvalue = get_post_meta($post->ID,$stwp_metabox["name"],true);
		if ($stwp_metaboxvalue == "" || !isset($stwp_metaboxvalue)):
			$stwp_metaboxvalue = $stwp_metabox['std'];
		endif;
		if ($stwp_metabox['type'] == 'text'):
			$output .= "\t".'<tr>';
			$output .= "\t\t".'<th class="stwp_metabox_names"><label for="'.$stwp_id.'">'.$stwp_metabox['label'].'</label></th>'."\n";
			$output .= "\t\t".'<td><input class="stwp_input_text" type="'.$stwp_metabox['type'].'" value="'.$stwp_metaboxvalue.'" name="stwpthemes_'.$stwp_metabox["name"].'" id="'.$stwp_id.'"/>';
			$output .= '<span class="stwp_metabox_desc">'.$stwp_metabox['desc'].'</span></td>'."\n";
			$output .= "\t".'<td></td></tr>'."\n";
		elseif ($stwp_metabox['type'] == 'textarea'):
			$output .= "\t".'<tr>';
			$output .= "\t\t".'<th class="stwp_metabox_names"><label for="'.$stwp_metabox.'">'.$stwp_metabox['label'].'</label></th>'."\n";
			$output .= "\t\t".'<td><textarea class="stwp_input_textarea" name="stwpthemes_'.$stwp_metabox["name"].'" id="'.$stwp_id.'">' . $stwp_metaboxvalue . '</textarea>';
			$output .= '<span class="stwp_metabox_desc">'.$stwp_metabox['desc'].'</span></td>'."\n";
			$output .= "\t".'<td></td></tr>'."\n";
		elseif ($stwp_metabox['type'] == 'select'):
			$output .= "\t".'<tr>';
			$output .= "\t\t".'<th class="stwp_metabox_names"><label for="'.$stwp_id.'">'.$stwp_metabox['label'].'</label></th>'."\n";
			$output .= "\t\t".'<td><select class="stwp_input_select" id="'.$stwp_id.'" name="stwpthemes_'. $stwp_metabox["name"] .'">';
			$output .= '<option value="">'.__('Select to return to default').'</option>';
			$array = $stwp_metabox['options'];
			if ($array):
				foreach ( $array as $id => $option ) {
					$selected = '';

					if ($stwp_metabox['default'] == $option && empty($stwp_metaboxvalue)):
						$selected = 'selected="selected"';
					else:
						$selected = '';
					endif;
					if ($stwp_metaboxvalue == $option):
						$selected = 'selected="selected"'; 
					else: $selected = '';
					endif;

					$output .= '<option value="'. $option .'" '. $selected .'>' . $option .'</option>';
				}
			endif;
			$output .= '</select><span class="stwp_metabox_desc">'.$stwp_metabox['desc'].'</span></td></td><td></td>'."\n";
			$output .= "\t".'</tr>'."\n";
		elseif ($stwp_metabox['type'] == 'checkbox'):
			if ($stwp_metaboxvalue == 'true'):
				$checked = ' checked="checked"'; 
			else: 
				$checked='';
			endif;
			$output .= "\t".'<tr>';
			$output .= "\t\t".'<th class="stwp_metabox_names"><label for="'.$stwp_id.'">'.$stwp_metabox['label'].'</label></th>'."\n";
			$output .= "\t\t".'<td><input type="checkbox" '.$checked.' class="stwp_input_checkbox" value="true"	 id="'.$stwp_id.'" name="stwpthemes_'. $stwp_metabox["name"] .'" />';
			$output .= '<span class="stwp_metabox_desc" style="display:inline">'.$stwp_metabox['desc'].'</span></td></td><td></td>'."\n";
			$output .= "\t".'</tr>'."\n";
		elseif ($stwp_metabox['type'] == 'radio'):
			$array = $stwp_metabox['options'];
			if ($array):
				$output .= "\t".'<tr>';
				$output .= "\t\t".'<th class="stwp_metabox_names"><label for="'.$stwp_id.'">'.$stwp_metabox['label'].'</label></th>'."\n";
				$output .= "\t\t".'<td>';
				foreach ( $array as $id => $option ) {
					if ($stwp_metaboxvalue == $option) { $checked = ' checked';} else {$checked='';}
					$output .= '<input type="radio" '.$checked.' value="' . $id . '" class="stwp_input_radio"  id="'.$stwp_id.'" name="stwpthemes_'. $stwp_metabox["name"] .'" />';
					$output .= '<span class="stwp_input_radio_desc" style="display:inline">'. $option .'</span><div class="stwp_spacer"></div>';
				}
				$output .=	'</td></td><td></td>'."\n";
				$output .= "\t".'</tr>'."\n";
			endif;
		endif;
	}
	$output .= '</table>'."\n\n";
	echo $output;
} // end stwpthemes_metabox_create

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
		<?php get_the_author_meta('twitter', $twitter); ?>
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
							<?php echo get_comment_date('F j, Y') ?> <?php _e('at','standardtheme'); ?> <?php echo get_comment_time(); ?>
						</span>
						<span class="edit">
							<?php edit_comment_link(__('Edit','standardtheme'), '', ''); ?>
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
						<?php _e('Your comment is awaiting moderation','standardtheme'); ?>
					</p>
					<?php endif; ?>
					<div class="reply">
						<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => __('Reply', 'standardtheme')))) ?>
					</div>
			</div>
		</div>
<?php } // end custom_comment

/**
 * Generates the list of pings for the given post.
 *
 * @comment	The current ping being displayed.
 * @args	Array containing arguments for displaying the ping.
 * @depth	The depth of where this comment falls in the tree.
 */
function list_pings($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li id="comment-<?php comment_ID(); ?>">
		<span class="author">
			<?php comment_author_link(); ?>
		</span> -
		<span class="date">
			<?php echo get_comment_date('F j, Y') ?>
		</span>
		<span class="pingcontent">
			<?php comment_text() ?>
		</span>
<?php } // end list_pings
	
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
	echo $commenter ;
} // end the_commenter_link

/**
 * If the current user is not the administrator, write out the Standard Theme
 * JavaScript libraries.
 */
if (!is_admin()):
	add_action( 'wp_print_scripts', 'stwpthemes_add_javascript' );
endif;
function stwpthemes_add_javascript( ) {
	wp_enqueue_script( 'general', get_bloginfo('template_directory').'/js/general.js', array( 'jquery' ) );
} // end stwpthemes_add_javascript

/**
 * Includes the version of jQuery hosted via Google.
 */
function standard_theme_libs() {
	wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js');
  wp_enqueue_script( 'jquery' );
} // end standard_theme_libs

/**
 * Add post formats for >= WordPress 3.1
 */
if (version_compare(get_bloginfo('version'), '3.1', '>=')) {
	add_theme_support('post-formats', array('aside', 'video', 'image', 'link', 'quote'));
} // end if

/*-----------------------------------------------------------------*
 * 3. Framework
/*-----------------------------------------------------------------*/

/**
 * Renders the Standard Theme header and uses the appropriate header tags for SEO
 * based on whether the user is viewing a list of posts or a single post.
 *
 * @bSinglePage	Whether or not the current page is a single post or page.
 */
function standard_header($bSinglePage) { 

	global $standard_options;
	
	if(!$standard_options->adjusted_navigation):
		standard_navigation(is_page(), false);
	endif;
	?>
	
	<div id="header" class="col-full">
		<div id="logo" class="fl">	
				<?php
				if($standard_options->text_header || !$standard_options->logo): ?>
					<?php if($bSinglePage): ?>
						<h2 class="site-title">
							<a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description'); ?>">
								<?php bloginfo('name'); ?>
							</a>
						</h2>
					<?php else: ?>
						<h1 class="site-title">
							<a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description'); ?>">
								<?php bloginfo('name'); ?>
							</a>
						</h1>
					<?php endif; ?>
				<?php else: ?>
					<?php if($bSinglePage): ?>
						<h2 class="site-title">
							<a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description'); ?>">
								<img class="title" src="<?php echo $standard_options->logo; ?>" alt="<?php bloginfo('name'); ?>" />
							</a>
						</h2>
					<?php else: ?>
						<h1 class="site-title">
							<a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description'); ?>">
								<img class="title" src="<?php echo $standard_options->logo; ?>" alt="<?php bloginfo('name'); ?>" />
							</a>
						</h1>
					<?php endif; ?>
				<?php endif;  ?>
		</div>
		<div id="topad">
			<?php dynamic_sidebar(2); ?>
		</div>
	</div>
	
	<?php
	if($standard_options->adjusted_navigation):
		standard_navigation(is_page(), false);
	endif;
	?>
	
<?php } // end standard_header

/**
 * Register the WP3 menu system.
 */ 
add_action('init', 'register_my_menus');
function register_my_menus() {
	register_nav_menus(
		array(
			'menu-1' => __( 'Standard Theme Custom Menu 1' ),
			'menu-2' => __( 'Standard Theme Custom Menu 2' ),
			'menu-3' => __( 'Standard Theme Custom Menu 3' )
		)
	);
} // end register_my_menus


/**
 * Register the WP3 background system.
 */
add_action('init', 'register_my_background');
function register_my_background() {
	global $standard_options;
	if($standard_options->wp3backgrounds):
		add_custom_background();
	endif;
} // end register_my_background

/**
 * Render the navigation links, pages, and categories
 *
 * @bIsPage	Whether or not the current page is a post or a page.
 * @bIsFooter Whether or not the call to this function is coming from the footer.
 */
function standard_navigation($bIsPage, $bIsFooter) { 

	global $standard_options; 
	$nav_depth = $bIsFooter ? 1 : 3;
	?>

	<div id="<?php if($bIsFooter): echo "footer-navigation"; else: echo "header-navigation"; endif; ?>" class="navigation<?php if(!$bIsFooter): echo " top-nav"; endif; ?>">
		<div class="navigation-container <?php if(!$bIsFooter): echo "col-full"; endif; ?>">
	<?php 
		if(!$bIsFooter || $bIsFooter && !$standard_options->hide_footer_navigation):
			if($standard_options->wp3menu && function_exists('wp_nav_menu')):
				$standard_walker = new Standard_Theme_Nav_Walker();
				$menu_classes = 'nav_wp3menu nav';
				if($standard_options->large_social_icons && !$bIsFooter):
					$menu_classes .= ' large_nav';
				endif;
				wp_nav_menu(
					array(
						'sort_column' => 'menu-order',
						'menu_class' => $menu_classes,
						'show_home' => 0,
						'walker' => $standard_walker,
						'depth' => $nav_depth,
						'theme_location' => 'menu-1'
					)
				);
				wp_nav_menu(
					array(
						'sort_column' => 'menu-order',
						'menu_class' => $menu_classes,
						'show_home' => 0,
						'walker' => $standard_walker,
						'depth' => $nav_depth,
						'theme_location' => 'menu-2'
					)
				);
				wp_nav_menu(
					array(
						'sort_column' => 'menu-order',
						'menu_class' => $menu_classes,
						'show_home' => 0,
						'walker' => $standard_walker,
						'depth' => $nav_depth,
						'theme_location' => 'menu-3'
					)
				);
		else: ?>
			<ul class="nav <?php echo $standard_options->large_social_icons && !$bIsFooter ? 'large_nav' : ''; ?>">						
				<li class="b <?php $bIsPage ? "page_item" : "page_item current_page_item"; ?>">
					<a href="<?php bloginfo('url'); ?>">
						<?php _e("Home", "standardtheme"); ?>
					</a>
				</li>
				
				<?php
				
				$page_ids = '';
				if($standard_options->page_exclude):
					foreach($standard_options->page_exclude as $pid) {
						$page_ids .= $pid . ',';
					}
				endif;
				wp_list_pages('sort_column=menu_order&title_li=&depth=' . $nav_depth . '&exclude=' . $page_ids);
				
				$cat_ids = '';
				if($standard_options->category_exclude):
					foreach($standard_options->category_exclude as $cid) {
						$cat_ids .= $cid . ',';
					}
				endif;
				wp_list_categories('show_option_all=&hide_empty=1&style=list&title_li=&hierarchical=0&depth=' . $nav_depth . '&exclude=' . $cat_ids); ?>
			</ul>
		<?php endif; ?>
	<?php endif; ?>

	<div class="fr">
		<?php require_once('socialnetworking.php'); ?>
	</div>
	
		</div>
	</div>
<?php } // end standard_navigation
add_filter('wp_list_categories', 'hide_empty_category_notice');

/**
 * Remove the 'No Categories' tag from the specified str.
 *
 * @str	The string from which to remove 'No Categories'
 */
function hide_empty_category_notice($str) {
	if(!empty($str)):
		return str_replace('<li>' . __('No categories') . '</li>', '', $str);
	endif;
} // end hide_empty_category_notice

/**
 * Creates the main column for content.
 */
function main_content_orientation() { 
	global $standard_options;
	return $standard_options->adjusted_sidebar ? 'right' : 'left';
} // end main_content_orientation

/**
 * Creates the sidebar.
 */
function standard_sidebar() { 
	global $standard_options;
	$orientation = $standard_options->adjusted_sidebar ? 'left' : 'right';
	?>
	<div id="sidebar" class="col-<?php echo $orientation; ?>">
		<?php dynamic_sidebar(1); ?>
	</div>
<?php } // end standard_sidebar

/**
 * Renders the Standard Theme feed URL (either the user-specified feed or the native WordPress-based feed).
 */
function standard_feed_url() {	
	global $standard_options;
	echo $standard_options->feedburner_url ? $standard_options->feedburner_url : get_bloginfo_rss('rss2_url');
} // end get_feed_url

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
 * Renders the sharers based on the configuration in the admin panel.
 */
function standard_sharers() {

	global $standard_options; ?>
	
	<div class="sharepost<?php echo $standard_options->adjusted_sidebar ? '-right' : '';?>">
			<?php if ($standard_options->tweetmeme_sharer): ?>
				<div id="twitter-sharer" class="sharer">
					<?php $tweetmeme_source = $standard_options->twitter ? $standard_options->twitter : 'standardtheme'; ?>
					<a href="http://twitter.com/share" class="twitter-share-button" data-count="vertical" data-via="<?php echo $tweetmeme_source; ?>">Tweet</a>
					<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
				</div>
			<?php endif; ?>
			<?php if($standard_options->facebook_sharer): ?>
					<div id="facebook-sharer" class="sharer">
						<script type="text/javascript">
							var fbShare = { 
								url: '<?php the_permalink(); ?>'
							}
						</script>
						<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/fbshare.min.js"></script>
					</div>
			<?php endif; ?>
			<?php if($standard_options->addthis_sharer): ?>
					<div id="addthis-sharer" class="addthis_toolbox addthis_default_style sharer">
						<a href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4bae0317605366f7" class="addthis_button_compact">
							<img src="<?php bloginfo('template_directory'); ?>/images/addthis_50x50.png" alt="Share This!" />
						</a>
					</div>
					<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4bae0317605366f7"></script>
			<?php endif;  ?>
	</div>
<?php } // end standard_sharers 

/**
 * Render the SEO-friendly breadcrumbs using the Yoast Breadcrumb plug-in.
 * This will not print a breadcrumb if the page is showing an attachment.
 */
function standard_breadcrumbs() { 
	global $standard_options;
	if($standard_options->breadcrumbs && !is_attachment()):
		yoast_breadcrumb('<div id="breadcrumb"><ul>','</ul></div>');
	endif;
} // end standard_breadcrumbs

/**
 * Renders the post thumbnail on the page.
 * 
 * @bIsSinglePost	Whether or not the user is viewing a single post or a list.
 */
function standard_post_thumbnails($bIsSinglePost) {
	global $standard_options;
	if($standard_options->post_thumb && !$bIsSinglePost):
		the_post_thumbnail('thumbnail');
	elseif ($standard_options->post_thumb_single && $bIsSinglePost):
		the_post_thumbnail('thumbnail');
	endif;
} // end standard_post_thumbnail

/**
 * Renders the author box beneath the post content.
 */
function standard_author_box() {
	global $standard_options;
	if($standard_options->author_box): ?>
		<div class="author_info">
			<?php 
				echo get_avatar(get_the_author_meta('user_email', $user_ID), '80', $default = $standard_options->gravatar_image);
			?>
			<div class="post-author">
				<p>
					<strong>
						<?php _e('About','standardtheme'); ?> <?php the_author(); ?>:
					</strong> 
					<?php the_author_description(); ?>
				</p>
				<div class="author-details">
					<?php _e('All Posts by','standardtheme'); ?> <?php the_author_posts_link(); ?> 
					<?php if ($standard_options->author_box_website && get_the_author_meta('user_url') != ''): ?>
						&nbsp;|&nbsp;
						<a href="<?php the_author_meta('user_url'); ?>" target="_blank">
							<?php _e('Website','standardtheme'); ?>
						</a>
					<?php endif; ?>
					<?php if ($standard_options->author_box_twitter && get_the_author_meta('twitter') != ''): ?>
						&nbsp;|&nbsp;
						<a href="http://twitter.com/<?php the_author_meta('twitter'); ?>" target="_blank">
							<?php _e('Twitter','standardtheme'); ?>
						</a>
					<?php endif; ?>
					<?php if ($standard_options->author_box_facebook && get_the_author_meta('facebook') != ''): ?>
						&nbsp;|&nbsp;
						<a href="http://facebook.com/<?php the_author_meta('facebook'); ?>" target="_blank">
							<?php _e('Facebook','standardtheme'); ?>
						</a>
					<?php endif; ?>
					<?php if ($standard_options->author_box_email): ?>
						&nbsp;|&nbsp;
						<?php echo direct_email(); ?>
					<?php endif; ?>
				</div>
				<div class="fix"></div>
			</div>
		</div>
	<?php endif;
} // end standard_author_box

/**
 * Renders pagination links.
 */
function standard_pagination() { ?>
		<div class="more_entries">
	<?php
		if(!function_exists('wp_pagenavi')): 
			include('wp-pagenavi.php'); 
		endif;
		if (function_exists('wp_pagenavi')):
			wp_pagenavi();
		else:?>
			<div class="fl">
				<?php next_posts_link(__('&laquo; Older Entries','standardtheme')) ?>
			</div>
			<div class="fr">
				<?php previous_posts_link(__('Newer Entries &raquo;','standardtheme')) ?>
			</div>
			<div class="fix"></div>
		<?php endif; ?>
		</div>
<?php
} // end standard_pagination

/**
 * Renders the footer
 */
function standard_footer() {
	global $standard_options;
	
	echo '&copy;&nbsp;';
	echo date('Y'); 
	echo '&nbsp;';
	bloginfo();
	echo '&nbsp;&nbsp;|&nbsp;&nbsp;';
	
	_e("Powered by the","standardtheme");
	if($standard_options->aff_link): ?>
		<a href="<?php echo $standard_options->aff_link; ?>" target="_blank">
	<?php else: ?>
		<a href="http://standardtheme.com" target="_blank">
	<?php endif; ?>
			<?php _e("Standard Theme", "standardtheme"); ?>
	</a>
<?php } // end standard_footer

/**
 * Renders the archive header and formats it 	based on which type of page archive the user is viewing.
 *
 * @isCategory	Whether or not the user is viewing a category archive
 * @isDay		Whether or not the user is viewing a daily archive
 * @isMonth		Whether or not the user is viewing a monthly archive
 * @isYear		Whether or not the user is viewing a yearly archive
 * @isAuthor	Whether or not the user is viewing an author archive
 * @isTag		Whether or not the user is viewing a tag archive
 * @wp_query	The WordPress query object used to display the category RSS link.
 */
function standard_archive_header($isCategory, $isDay, $isMonth, $isYear, $isAuthor, $isTag, $wp_query) {
	if ($isCategory) { ?>
		<span class="archive_header">
			<span class="fl cat">
				<?php printf(__('Archive - %s','standardtheme'), ''); single_cat_title(); ?>
			</span> 
			<span class="fr catrss">
				<?php $cat_obj = $wp_query->get_queried_object(); $cat_id = $cat_obj->cat_ID; echo '<a href="' . get_category_feed_link($cat_id, 'rss2') . '">RSS Feed</a>'; ?>
			</span>
		</span>		   
	<?php } elseif ($isDay) { ?>
		<span class="archive_header">
			<?php printf(__('Archive - %s','standardtheme'), get_the_time('F j, Y')); ?>
		</span>
	<?php } elseif ($isMonth) { ?>
		<span class="archive_header">
			<?php printf(__('Archive - %s','standardtheme'), get_the_time('F, Y')); ?>
		</span>
	<?php } elseif ($isYear) { ?>
		<span class="archive_header">
			<?php printf(__('Archive - %s','standardtheme'), get_the_time('Y')); ?>
		</span>
	<?php } elseif ($isAuthor) { ?>
		<span class="archive_header">
			<?php _e('Archive by Author','standardtheme'); ?>
		</span>
	<?php } elseif ($isTag) { ?>
		<span class="archive_header">
			<?php printf(__('Tag Archive - %s','standardtheme'), single_tag_title('', false)); ?>
		</span>
	<?php } ?>
	<div class="fix"></div> <?
} // end standard_archive_header

/**
 * Outputs a meta description. If you're on the homepage,
 * it will output the blog's description; otherwise, it will
 * output content freom the post.
 */
function standard_meta_description() {

	$excerpt_length = strlen(trim(get_the_excerpt()));

	if(is_single() && $excerpt_length > 0):
		if($excerpt_length >= 150):
			echo trim(substr(strip_tags(get_the_excerpt()), 0, 150)) . '...';
		else:
			echo trim(strip_tags(get_the_excerpt()));
		endif;
	else:
		echo strip_tags(get_bloginfo('description'));
	endif;
} // end standard_description

/*-----------------------------------------------------------------*
 * 4. Widgets
/*-----------------------------------------------------------------*/

/**
 * Initialize the Standard Theme widgets.
 */
function the_widgets_init() {
	
	if (!function_exists('register_sidebars')):
		return;
	endif;

	register_sidebar(
		array(	'name' => __('Sidebar'),
				'id' => 'sidebar-1',
				'before_widget' => '<div id="%1$s" class="widget %2$s">','after_widget' => '</div>',
				'before_title' => '<h3>',
				'after_title' => '</h3>'
			)
	);
	
	register_sidebar(
		array(	'name' => __('Top Ad'),
				'id' => 'sidebar-2',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3>',
				'after_title' => '</h3>'
			)
	); 
	
} // end the_widgets_init
add_action( 'init', 'the_widgets_init' );

/**
 * Initialize the 300x250 advertisement #1
 */
function ad300Widget() { 
	global $standard_options; ?>
	<div class="wrap widget">
		<?php if ($standard_options->ad_300_adsense): 
			echo stripslashes($standard_options->ad_300_adsense); ?>
	<?php else: ?>
		<?php if($standard_options->ad_300_url): ?>
			<a class="fade" href="<?php echo $standard_options->ad_300_url; ?>" target="_blank">
		<?php endif; ?>
				<img src="<?php echo $standard_options->ad_300_image; ?>" alt="advert" />
		<?php if($standard_options->ad_300_url): ?>
			</a>
		<?php endif; ?>
	<?php endif; ?>
	</div>
<?php } // end ad300Widget
wp_register_sidebar_widget('standard_ad300_1', __('Standard Theme - Ad 300x250 #1'), 'ad300Widget', null);

/**
 * Initialize the 300x250 advertisement #2
 */
function ad300Widget2() { 
	global $standard_options; ?>
	<div class="wrap widget">
		<?php if ($standard_options->ad_300_adsense2): 
			echo stripslashes($standard_options->ad_300_adsense2); ?>
	<?php else: ?>
		<?php if($standard_options->ad_300_url2): ?>
			<a class="fade" href="<?php echo $standard_options->ad_300_url2; ?>" target="_blank">
		<?php endif; ?>
				<img src="<?php echo $standard_options->ad_300_image2; ?>" alt="advert" />
		<?php if($standard_options->ad_300_url2): ?>
			</a>
		<?php endif; ?>
	<?php endif; ?>
	</div>
<?php } // end ad300Widget2
wp_register_sidebar_widget('standard_ad300_2', __('Standard Theme - Ad 300x250 #2'), 'ad300Widget2', null);

/**
 * Initialize the 300x250 advertisement #3
 */
function ad300Widget3() { 
	global $standard_options; ?>
	<div class="wrap widget">
		<?php if ($standard_options->ad_300_adsense3): 
			echo stripslashes($standard_options->ad_300_adsense3); ?>
	<?php else: ?>
		<?php if($standard_options->ad_300_url3): ?>
			<a class="fade" href="<?php echo $standard_options->ad_300_url3; ?>" target="_blank">
		<?php endif; ?>
				<img src="<?php echo $standard_options->ad_300_image3; ?>" alt="advert" />
		<?php if($standard_options->ad_300_url3): ?>
			</a>
		<?php endif; ?>
	<?php endif; ?>
	</div>
<?php } // end ad300Widget3
wp_register_sidebar_widget('standard_ad300_3', __('Standard Theme - Ad 300x250 #3'), 'ad300Widget3', null);

/**
 * Initialize the Personal Image widget
 */
function personal_image_widget() { 
	global $standard_options; ?>
	<div class="personal-image widget">
		<?php if($standard_options->personal_image_url): ?>
			<a class="fade" href="<?php echo $standard_options->personal_image_url ?>">
		<?php endif; ?>
				<img src="<?php echo $standard_options->personal_image; ?>" alt="Personal Image" />
		<?php if($standard_options->personal_image_url): ?>
			</a>
		<?php endif; ?>
	</div>
<?php } // end personal_image_widget
wp_register_sidebar_widget('standard_personal_image', __('Standard Theme - Personal Image'), 'personal_image_widget', null);

/**
 * Initialize the 468x60 banner advertisement.
 */
function ad468Widget() { 
	global $standard_options;
	?>
	<div class="wrap widget">
	<?php if ($standard_options->ad_468_adsense):
		echo stripslashes($standard_options->ad_468_adsense);
	else: ?>
		<?php if($standard_options->ad_468_url): ?>
			<a class="fade" href="<?php echo $standard_options->ad_468_url; ?>" target="_blank">
		<?php endif; ?>
				<img src="<?php echo $standard_options->ad_468_image; ?>" alt="advert" />
		<?php if($standard_options->ad_468_url): ?>
			</a>
		<?php endif; ?>
	<?php endif; ?>
	</div>
<?php } // end ad468widget
wp_register_sidebar_widget('standard_ad468', __('Standard Theme - Ad 468x60'), 'ad468Widget', null);

/**
 * Setup all 10 of the 125x125 advertisement widgets.
 */
function adsWidget() {
	global $standard_options;
	$settings = get_option("widget_adswidget");
	$number = $settings['number'];
	if ($number == 0 || $number < 0): 
		$number = 1;
	elseif ($number > 10):
		$number = 10;
	endif;
	$numbers = range(1,$number);
	if ($standard_options->ads_rotate): 
		shuffle($numbers); 
	endif; ?>
	<div class="ads125 widget">
		<?php foreach ($numbers as $number) {
			$ad_image_url = 'ad_image_' . $number;
			$ad_url = 'ad_url_' . $number; 
			if($standard_options->$ad_url): ?>
			<a class="fade" href="<?php echo $standard_options->$ad_url; ?>" target="_blank">
			<?php endif; ?>
				<img src="<?php echo $standard_options->$ad_image_url; ?>" alt="Ad" />
			<?php if($standard_options->$ad_url): ?>
				</a>
			<?php endif; ?>
		<?php } ?>
		<div class="fix"></div>
	</div>
<?php } // end adsWidget
wp_register_sidebar_widget('standard_ad125', __('Standard Theme - Ads 125x125'), 'adsWidget', null);

/**
 * Setup the 125x125 advertisement administration widget.
 */
function adsWidgetAdmin() {
	$settings = get_option("widget_adswidget");
	if (isset($_POST['update_ads'])):
		$settings['number'] = strip_tags(stripslashes($_POST['ads_number']));
		update_option("widget_adswidget",$settings); 
	endif;
	echo '<p>
			<label for="ads_number">'.__('Number of ads (1-10)').':
				<input id="ads_number" name="ads_number" type="text" class="widefat" value="'.$settings['number'].'" />
			</label>
		</p>';
	echo '<input type="hidden" id="update_ads" name="update_ads" value="1" />'; 
} // end adsWidgetAdmin
wp_register_widget_control('standard_ad125', __('Standard Theme - Ads 125x125'), 'adsWidgetAdmin', null, null);

/**
 * Initialize the search widget.
 */
function searchWidget() { ?>
	<div id="search_main" class="widget">
		<h3><?php _e('Search', 'standardtheme'); ?></h3>
			<form method="get" id="searchform" action="<?php bloginfo('url'); ?>">
				<input type="text" class="field" name="s" id="s"  value="<?php _e('Type Here.', 'standardtheme'); ?>" onfocus="if (this.value == '<?php _e('Type Here.', 'standardtheme'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Type Here.', 'standardtheme'); ?>';}" />
				<input type="submit" class="submit" name="submit" value="<?php _e('Submit', 'standardtheme'); ?>" />
			</form>
	<div class="fix"></div>
	</div>
<?php } // end searchWidget
wp_register_sidebar_widget('standard_search', __('Standard Theme - Search'), 'SearchWidget', null);
add_action('wp_head', 'stwpthemes_wp_head');

?>