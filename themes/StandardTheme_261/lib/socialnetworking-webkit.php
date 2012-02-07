<?php /* this is socialnetworking-webkit.php */ 
global $standard_options;
?>
<div id="socialnetworking">
	<ul class="social_icons">
		<li>
			<a href="<?php standard_feed_url() ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/rss_16.png" class="small" alt="RSS" />
				<img src="<?php bloginfo('template_directory'); ?>/images/rss_32.png" alt="RSS" />
			</a>
		</li>
	<?php if ($standard_options->feedburneremail): ?>
		<li>
			<a href="<?php echo $standard_options->feedburneremail; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/email_16.png" class="small" alt="Email" />
				<img src="<?php bloginfo('template_directory'); ?>/images/email_32.png" alt="Email" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->twitter): ?>
		<li>
			<a href="http://twitter.com/<?php $standard_options->twitter; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/twitter_16.png" class="small" alt="Twitter" />
				<img src="<?php bloginfo('template_directory'); ?>/images/twitter_32.png" alt="Twitter" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->facebook): ?>
		<li>
			<a href="http://facebook.com/<?php echo $standard_options->facebook; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/facebook_16.png" class="small" alt="Facebook" />
				<img src="<?php bloginfo('template_directory'); ?>/images/facebook_32.png" alt="Facebook" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->digg): ?>
		<li>
			<a href="http://digg.com/users/<?php echo $standard_options->digg; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/digg_16.png" class="small" alt="Digg" />
				<img src="<?php bloginfo('template_directory'); ?>/images/digg_32.png" alt="Digg" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->delicious): ?>
		<li>
			<a href="http://delicious.com/<?php echo $standard_options->delicious; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/delicious_16.png" class="small" alt="Delicious" />
				<img src="<?php bloginfo('template_directory'); ?>/images/delicious_32.png" alt="Delicious" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->flickr): ?>
		<li>
			<a class="fade" href="http://flickr.com/photos/<?php echo $standard_options->flickr; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/flickr_16.png" class="small" alt="flickr" />
				<img src="<?php bloginfo('template_directory'); ?>/images/flickr_32.png" alt="flickr" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->friendfeed): ?>
		<li>
			<a class="fade" href="http://friendfeed.com/<?php echo $standard_options->friendfeed; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/friendfeed_16.png" class="small" alt="FriendFeed" />
				<img src="<?php bloginfo('template_directory'); ?>/images/friendfeed_32.png" alt="FriendFeed" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->lastfm): ?>
		<li>
			<a class="fade" href="http://last.fm/user/<?php echo $standard_options->lastfm; ?>" target="_blank">
			<img src="<?php bloginfo('template_directory'); ?>/images/lastfm_16.png" class="small" alt="last.fm" />
			<img src="<?php bloginfo('template_directory'); ?>/images/lastfm_32.png" alt="last.fm" /></a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->linkedin): ?>
		<li>
			<a class="fade" href="http://linkedin.com/in/<?php echo $standard_options->linkedin; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/linkedin_16.png" class="small" alt="Linkedin" />
				<img src="<?php bloginfo('template_directory'); ?>/images/linkedin_32.png" alt="Linkedin" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->myspace): ?>
		<li>
			<a class="fade" href="http://myspace.com/<?php echo $standard_options->myspace; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/myspace_16.png" class="small" alt="MySpace" />
				<img src="<?php bloginfo('template_directory'); ?>/images/myspace_32.png" alt="MySpace" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->posterous): ?>
		<li>
			<a class="fade" href="<?php echo $standard_options->posterous; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/posterous_16.png" class="small" alt="Posterous" />
				<img src="<?php bloginfo('template_directory'); ?>/images/posterous_32.png" alt="Posterous" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->vimeo): ?>
		<li>
			<a class="fade" href="http://vimeo.com/<?php echo $standard_options->vimeo; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/vimeo_16.png" class="small" alt="Vimeo" />
				<img src="<?php bloginfo('template_directory'); ?>/images/vimeo_32.png" alt="Vimeo" />
			</a>
		</li>
	<?php endif; ?>
	<?php if ($standard_options->youtube): ?>
		<li>
			<a class="fade" href="http://youtube.com/user/<?php echo $standard_options->youtube; ?>" target="_blank">
				<img src="<?php bloginfo('template_directory'); ?>/images/youtube_16.png" class="small" alt="YouTube" />
				<img src="<?php bloginfo('template_directory'); ?>/images/youtube_32.png" alt="YouTube" />
			</a>
		</li>
	<?php endif; ?>
	</ul>
</div>