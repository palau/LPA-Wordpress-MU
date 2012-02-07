<?php

// =============================== Author widget ======================================
function authorWidget()
{
	$settings = get_option("widget_authorwidget");
	$title = $settings['title'];
	if ($title == "") 
		$title = __('Author Info', 'woothemes');
	if ( is_single() ) :
		$authordata = $GLOBALS['saved_author']; // Grab saved author data
?>
<?php if ( $authordata->ID != 15) { //show the widget only if not by the Editor ?>
<div id="author" class="widget">
	<h3 class="widget_title">About <?php the_author_posts_link(); ?></h3>
	<div class="wrap">
		<div class="fl"><?php echo get_avatar( get_the_author_id(), '60' ); ?></div>
        		<!-- <br class="fix"></br> -->
		<p class="author-desc"><?php echo $authordata->bio_short; ?></p>
		<p class="author-desc"><a href="/archives/author/<?php echo $authordata->nickname; ?>">Full Profile.</a></p>
		
		<div class="socialmedia-buttons">
				<?php // show social media icons if present in user_meta
					$smIcon_path = 'http://blogs.palau.org/wp-content/plugins/social-media-widget/images/default/32/';
					// would love to do a for-each loop here, ideas?

				 if ($authordata->twitter){ $smNetwork = 'twitter';?>
					<a href="<?php echo $authordata->twitter; ?>" title="Follow <?php echo $authordata->display_name; ?> on Twitter" rel="nofollow" target="_blank"><img style="opacity: 0.7; -moz-opacity: 0.7; border:none; padding:0; margin:0 10px 0 0;" src="<?php echo $smIcon_path . $smNetwork ?>.png" alt="<?php $smNetwork ?>" class="fade" /></a>
					<?php }?>
				<?php if ($authordata->facebook){  $smNetwork = 'facebook';?>
					<a href="<?php echo $authordata->facebook; ?>" title="Follow <?php echo $authordata->display_name; ?> on Facebook" rel="nofollow" target="_blank"><img style="opacity: 0.7; -moz-opacity: 0.7; border:none; padding:0; margin:0 10px 0 0;" src="<?php echo $smIcon_path . $smNetwork ?>.png" alt="<?php $smNetwork ?>" class="fade" /></a>
					<?php }?>
		</div> <!-- /.socialmedia-buttons -->
	</div>
</div>
<?php } // end != editor if ?>

<?php
	endif;
}

function authorWidgetAdmin() {
	$settings = get_option("widget_authorwidget");

	// check if anything's been sent
	if (isset($_POST['update_author'])) {
		$settings['title'] = strip_tags(stripslashes($_POST['author_title']));

		update_option("widget_authorwidget",$settings);
	}

	echo '<p>
			<label for="author_title">Title:
			<input id="author_title" name="author_title" type="text" class="widefat" value="'.$settings['title'].'" /></label></p>';
	echo '<p>
			 <small>NOTE: This widget will only show on single post page.</small>
		  </p>';
	echo '<input type="hidden" id="update_author" name="update_author" value="1" />';

}

register_sidebar_widget('Woo - Author', 'authorWidget');
register_widget_control('Woo - Author', 'authorWidgetAdmin', 200, 200);


// =============================== Flickr widget ======================================
function flickrWidget()
{
	$settings = get_option("widget_flickrwidget");

	$id = $settings['id'];
	$number = $settings['number'];

?>

<div id="flickr" class="widget">
	<h3 class="widget_title"><?php _e('Photos on <span>Flick<span>r</span></span>', 'woothemes') ?></h3>
	<div class="wrap">
		<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $id; ?>"></script>        
		<div class="fix"></div>
	</div>
</div>

<?php
}

function flickrWidgetAdmin() {

	$settings = get_option("widget_flickrwidget");

	// check if anything's been sent
	if (isset($_POST['update_flickr'])) {
		$settings['id'] = strip_tags(stripslashes($_POST['flickr_id']));
		$settings['number'] = strip_tags(stripslashes($_POST['flickr_number']));

		update_option("widget_flickrwidget",$settings);
	}

	echo '<p>
			<label for="flickr_id">Flickr ID (<a href="http://www.idgettr.com">idGettr</a>):
			<input id="flickr_id" name="flickr_id" type="text" class="widefat" value="'.$settings['id'].'" /></label></p>';
	echo '<p>
			<label for="flickr_number">Number of photos:
			<input id="flickr_number" name="flickr_number" type="text" class="widefat" value="'.$settings['number'].'" /></label></p>';
	echo '<input type="hidden" id="update_flickr" name="update_flickr" value="1" />';

}

register_sidebar_widget('Woo - Flickr', 'flickrWidget');
register_widget_control('Woo - Flickr', 'flickrWidgetAdmin', 400, 200);


// =============================== Search widget ======================================
function searchWidget()
{
include(TEMPLATEPATH . '/search-form.php');
}
register_sidebar_widget('Woo - Search', 'SearchWidget');

// =============================== Video Player widget ======================================
function videoWidget()
{
	$number = 3;
	$title = "Latest Videos";
	$settings = get_option("widget_videowidget");
	if ($settings['number']) $number = $settings['number'];
	if ($settings['title']) $title = $settings['title'];
?>

<div id="video" class="widget">

    <h3><?php echo $title; ?></h3>
    
    <div class="inside">
		<?php query_posts('showposts='.$number.'&cat='.$GLOBALS[video_id]); ?>
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>	
        
            <div id="video-<?php the_ID(); ?>" class="latest">
                <?php echo woo_get_embed('embed','269','225'); ?> 
            </div>	
            
            <?php endwhile; ?>   
        <?php endif; ?>
	</div>
    
	<?php query_posts('showposts='.$number.'&cat='.$GLOBALS[video_id]); ?>   
    <?php if (have_posts()) : ?>
    
    <ul class="wooTabs">
    
    <?php while (have_posts()) : the_post(); $count++; ?>	        
        <li><a href="#video-<?php the_ID(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>            
    <?php endwhile; ?>
            
    </ul>

    <?php endif; ?>
	
</div>
<?php 
}
register_sidebar_widget('Woo - Video Player', 'videoWidget');

function videoWidgetAdmin() {

	$settings = get_option("widget_videowidget");

	// check if anything's been sent
	if (isset($_POST['update_video'])) {
		$settings['number'] = strip_tags(stripslashes($_POST['video_number']));
		$settings['title'] = strip_tags(stripslashes($_POST['video_title']));
		update_option("widget_videowidget",$settings);
	}

	echo '<p>
			<label for="video_number">Number of videos (default = 3):
			<input id="video_number" name="video_number" type="text" class="widefat" value="'.$settings['number'].'" /></label></p>';
	echo '<p>
			<label for="video_title">Title
			<input id="video_title" name="video_title" type="text" class="widefat" value="'.$settings['title'].'" /></label></p>';
	echo '<label>NOTE: Setup the video category in the theme Options Panel';
	echo '<input type="hidden" id="update_video" name="update_video" value="1" /></label>';


}
register_widget_control('Woo - Video Player', 'videoWidgetAdmin', 200, 200);

// =============================== Ad 125x125 widget ======================================
function adsWidget()
{
$settings = get_option("widget_adswidget");
$number = $settings['number'];
if ($number == 0) $number = 1;
$img_url = array();
$dest_url = array();

$numbers = range(1,$number); 
$counter = 0;

if (get_option('woo_ads_rotate') == "true") {
	shuffle($numbers);
}
?>
<div id="advert_125x125" class="widget">
<?php
	foreach ($numbers as $number) {	
		$counter++;
		$img_url[$counter] = get_option('woo_ad_image_'.$number);
		$dest_url[$counter] = get_option('woo_ad_url_'.$number);
	
?>
        <a href="<?php echo "$dest_url[$counter]"; ?>"><img src="<?php echo "$img_url[$counter]"; ?>" alt="Ad" /></a>
<?php } ?>
</div>
<!--/ads -->
<?php

}
register_sidebar_widget('Woo - Ads 125x125', 'adsWidget');

function adsWidgetAdmin() {

	$settings = get_option("widget_adswidget");

	// check if anything's been sent
	if (isset($_POST['update_ads'])) {
		$settings['number'] = strip_tags(stripslashes($_POST['ads_number']));

		update_option("widget_adswidget",$settings);
	}

	echo '<p>
			<label for="ads_number">Number of ads (1-6):
			<input id="ads_number" name="ads_number" type="text" class="widefat" value="'.$settings['number'].'" /></label></p>';
	echo '<input type="hidden" id="update_ads" name="update_ads" value="1" />';

}
register_widget_control('Woo - Ads 125x125', 'adsWidgetAdmin', 200, 200);


/*---------------------------------------------------------------------------------*/
/* Ad Widget */
/*---------------------------------------------------------------------------------*/
if (class_exists('WP_Widget')) {
	class Woo_AdWidget extends WP_Widget {
	
		function Woo_AdWidget() {
			$widget_ops = array('description' => 'Use this widget to add any type of Ad as a widget.' );
			parent::WP_Widget(false, __('Woo - Adspace Widget', 'woothemes'),$widget_ops);      
		}
	
		function widget($args, $instance) {  
			$title = $instance['title'];
			$adcode = $instance['adcode'];
			$image = $instance['image'];
			$href = $instance['href'];
			$alt = $instance['alt'];
	
			echo '<div class="adspace-widget widget">';
	
			if($title != '')
				echo '<h3>'.$title.'</h3>';
	
			if($adcode != ''){
			?>
			
			<?php echo $adcode; ?>
			
			<?php } else { ?>
			
				<a href="<?php echo $href; ?>"><img src="<?php echo $image; ?>" alt="<?php echo $alt; ?>" /></a>
		
			<?php
			}
			
			echo '</div>';
	
		}
	
		function update($new_instance, $old_instance) {                
			return $new_instance;
		}
	
		function form($instance) {        
			$title = esc_attr($instance['title']);
			$adcode = esc_attr($instance['adcode']);
			$image = esc_attr($instance['image']);
			$href = esc_attr($instance['href']);
			$alt = esc_attr($instance['alt']);
			?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):','woothemes'); ?></label>
				<input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('adcode'); ?>"><?php _e('Ad Code:','woothemes'); ?></label>
				<textarea name="<?php echo $this->get_field_name('adcode'); ?>" class="widefat" id="<?php echo $this->get_field_id('adcode'); ?>"><?php echo $adcode; ?></textarea>
			</p>
			<p><strong>or</strong></p>
			<p>
				<label for="<?php echo $this->get_field_id('image'); ?>"><?php _e('Image Url:','woothemes'); ?></label>
				<input type="text" name="<?php echo $this->get_field_name('image'); ?>" value="<?php echo $image; ?>" class="widefat" id="<?php echo $this->get_field_id('image'); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('href'); ?>"><?php _e('Link URL:','woothemes'); ?></label>
				<input type="text" name="<?php echo $this->get_field_name('href'); ?>" value="<?php echo $href; ?>" class="widefat" id="<?php echo $this->get_field_id('href'); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('alt'); ?>"><?php _e('Alt text:','woothemes'); ?></label>
				<input type="text" name="<?php echo $this->get_field_name('alt'); ?>" value="<?php echo $alt; ?>" class="widefat" id="<?php echo $this->get_field_id('alt'); ?>" />
			</p>
			<?php
		}
	} 
	
	register_widget('Woo_AdWidget');
}


/*---------------------------------------------------------------------------------*/
/* WooTabs widget */
/*---------------------------------------------------------------------------------*/

class Woo_Tabs extends WP_Widget {

   function Woo_Tabs() {
  	   $widget_ops = array('description' => 'This widget is the Tabs that classicaly goes into the sidebar. It contains the Popular posts, Latest Posts, Recent comments and a Tag cloud.' );
       parent::WP_Widget(false, $name = __('Woo - Tabs', 'woothemes'), $widget_ops);    
   }


   function widget($args, $instance) {        
       extract( $args );
       
       $number = $instance['number']; if ($number == '') $number = 5;
       $thumb_size = $instance['thumb_size']; if ($thumb_size == '') $thumb_size = 35;
       ?>  

 		<div id="tabs">
           
            <ul class="wooTabs">
                <li class="popular"><a href="#tab-pop"><?php _e('Popular', 'woothemes'); ?></a></li>
                <li class="latest"><a href="#tab-latest"><?php _e('Latest', 'woothemes'); ?></a></li>
                <li class="comments"><a href="#tab-comm"><?php _e('Comments', 'woothemes'); ?></a></li>
                <li class="tags"><a href="#tab-tags"><?php _e('Tags', 'woothemes'); ?></a></li>
            </ul>
            
            <div class="clear"></div>
            
            <div class="boxes box inside">
                        
                <ul id="tab-pop" class="list">            
                    <?php if ( function_exists('woo_tabs_popular') ) woo_tabs_popular($number, $thumb_size); ?>                    
                </ul>
            
                <ul id="tab-latest" class="list">
                    <?php if ( function_exists('woo_tabs_latest') ) woo_tabs_latest($number, $thumb_size); ?>                    
                </ul>	
            
                <ul id="tab-comm" class="list">
                    <?php if ( function_exists('woo_tabs_comments') ) woo_tabs_comments($number, $thumb_size); ?>                    
                </ul>	
                
                <div id="tab-tags" class="list">
                    <?php wp_tag_cloud('smallest=12&largest=20'); ?>
                </div>
                
            </div><!-- /.boxes -->
			
        </div><!-- /wooTabs -->
    
         <?php
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {                
       $number = esc_attr($instance['number']);
       $thumb_size = esc_attr($instance['thumb_size']);
	   
       ?>    
       <p>
       <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts:','woothemes'); ?>
       <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
       </label>
       </p>  
       <p>
       <label for="<?php echo $this->get_field_id('thumb_size'); ?>"><?php _e('Thumbnail Size (0=disable):','woothemes'); ?>
       <input class="widefat" id="<?php echo $this->get_field_id('thumb_size'); ?>" name="<?php echo $this->get_field_name('thumb_size'); ?>" type="text" value="<?php echo $thumb_size; ?>" />
       </label>
       </p>  
       <?php 
   }

} 
register_widget('Woo_Tabs');

/* Deregister Default Widgets */
function woo_deregister_widgets(){
    unregister_widget('WP_Widget_Search');         
}
add_action('widgets_init', 'woo_deregister_widgets');  


?>