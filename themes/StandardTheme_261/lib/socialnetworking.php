<?php /* this is socialnetworking.php */ 
global $standard_options;
$icon_size = $standard_options->large_social_icons ? '32' : '16';
?>
<div id="socialnetworking">
	<ul class="social_icons <?php echo $standard_options->large_social_icons ? 'large_icons' : ''; ?>">
		<li>
	
			<a class="fade" href="<?php standard_feed_url(); ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/rss_<?php echo $icon_size; ?>.png" class="small" alt="RSS" width="<?php echo $icon_size; ?>" height="<?php echo $icon_size; ?>" />
			</a>
		</li>
	<?php if ($standard_options->feedburneremail): ?>
		<li>
			<a class="fade" href="<?php echo $standard_options->feedburneremail; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/email_<?php echo $icon_size; ?>.png" class="small" alt="Email" width="<?php echo $icon_size; ?>" height="<?php echo $icon_size; ?>" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->twitter): ?>
		<li>
			<a class="fade" href="http://twitter.com/<?php echo $standard_options->twitter; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/twitter_<?php echo $icon_size; ?>.png" class="small" alt="Twitter" width="<?php echo $icon_size; ?>" height="<?php echo $icon_size; ?>" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->facebook): ?>
		<li>
			<a class="fade" href="http://facebook.com/<?php echo $standard_options->facebook; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/facebook_<?php echo $icon_size; ?>.png" class="small" alt="Facebook" width="<?php echo $icon_size; ?>" height="<?php echo $icon_size; ?>" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->digg): ?>
		<li>
			<a class="fade" href="http://digg.com/users/<?php echo $standard_options->digg; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/digg_<?php echo $icon_size; ?>.png" class="small" alt="Digg" width="<?php echo $icon_size; ?>" height="<?php echo $icon_size; ?>" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->flickr): ?>
		<li>
			<a class="fade" href="http://flickr.com/photos/<?php echo $standard_options->flickr; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/flickr_<?php echo $icon_size; ?>.png" class="small" alt="flickr" width="<?php echo $icon_size; ?>" height="<?php echo $icon_size; ?>" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->friendfeed): ?>
		<li>
			<a class="fade" href="http://friendfeed.com/<?php echo $standard_options->friendfeed; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/friendfeed_<?php echo $icon_size; ?>.png" class="small" alt="FriendFeed" width="<?php echo $icon_size; ?>" height="<?php echo $icon_size; ?>" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->lastfm): ?>
		<li>
			<a class="fade" href="http://last.fm/user/<?php echo $standard_options->lastfm; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/lastfm_<?php echo $icon_size; ?>.png" class="small" alt="last.fm" width="<?php echo $icon_size; ?>" height="<?php echo $icon_size; ?>" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->linkedin): ?>
		<li>
			<a class="fade" href="http://linkedin.com/in/<?php echo $standard_options->linkedin; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/linkedin_<?php echo $icon_size; ?>.png" class="small" alt="LinkedIn" width="<?php echo $icon_size; ?>" height="<?php echo $icon_size; ?>" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->myspace): ?>
		<li>
			<a class="fade" href="http://myspace.com/<?php echo $standard_options->myspace; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/myspace_<?php echo $icon_size; ?>.png" class="small" alt="MySpace" width="<?php echo $icon_size; ?>" height="<?php echo $icon_size; ?>" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->posterous): ?>
		<li>
			<a class="fade" href="<?php echo $standard_options->posterous; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/posterous_<?php echo $icon_size; ?>.png" class="small" alt="Posterous" width="<?php echo $icon_size; ?>" height="<?php echo $icon_size; ?>" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->vimeo): ?>
		<li>
			<a class="fade" href="http://vimeo.com/<?php echo $standard_options->vimeo; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/vimeo_<?php echo $icon_size; ?>.png" class="small" alt="Vimeo" width="<?php echo $icon_size; ?>" height="<?php echo $icon_size; ?>" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->youtube): ?>
		<li>
			<a class="fade" href="http://youtube.com/user/<?php echo $standard_options->youtube; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/youtube_<?php echo $icon_size; ?>.png" class="small" alt="YouTube" width="<?php echo $icon_size; ?>" height="<?php echo $icon_size; ?>" />
			</a>
		</li>
	<?php endif; ?>
	</ul>
</div>