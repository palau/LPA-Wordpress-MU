<?php
$pop_posts = get_option('woo_tabs_popular');
if (empty($pop_posts) || $pop_posts < 1) $pop_posts = 5;
$popularposts = "SELECT ID,post_title FROM {$wpdb->prefix}posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY comment_count DESC LIMIT 0,".$pop_posts;
$posts = $wpdb->get_results($popularposts);
if($posts){
	foreach($posts as $post){
		$post_title = stripslashes($post->post_title);
		$guid = get_permalink($post->ID);
?>
		<li>
			<?php 
				woo_get_image('image',48,48,'thumbnail',90,$post->ID,'src',1,0,'','',true,false,false);
			?>                
            <a href="<?php echo $guid; ?>" title="<?php echo $post_title; ?>"><?php echo $post_title; ?></a>
            <span class="meta"><?php the_time($GLOBALS['woodate']); ?></span>
    		<div style="clear:both"></div>

        </li>
<?php 
	}
}
?>