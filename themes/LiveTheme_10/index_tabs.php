<?php get_header(); ?>
	<div id="content" class="col-full">
		<div id="main-top" class="full-width borders shadow">
		
			<!-- Video Player -->
			<div id="main-video" class="col-left">
				<?php if(standard_display_video_bumpers()): ?>
					<div id="livetheme-offline-container">
						<?php standard_offline_display(); ?>
					</div>
				<?php else: ?>
					<div id="livetheme-online-container">
						<?php standard_video_embed(); ?>
					</div>
					<div id="livetheme-offline-container">
						<?php standard_offline_display(); ?>
					</div>
				<?php endif; ?>
			</div><!-- /Video Player -->
			
			<!-- Social Tabs -->
			<div id="social-tabs" class="col-right">			
				<ul id="liveTabs">
					<?php if(is_active_sidebar('twitter-feed')): ?>
						<li class="twitter">
							<a class="active-social social-tab" href="javascript:;">
								<img src="<?php bloginfo('template_directory'); ?>/images/icn-twitter-16.png" alt="logo"/>
								<?php _e('Twitter', 'livetheme'); ?>
							</a>
						</li>
					<?php endif; ?>
					<?php if(is_active_sidebar('facebook-feed')): ?>
						<li class="facebook">
							<a href="javascript:;" class="social-tab">
								<img src="<?php bloginfo('template_directory'); ?>/images/icn-facebook-16.png" alt="logo"/>
								<?php _e('Facebook', 'livetheme'); ?>
							</a>
						</li>
					<?php endif; ?>
<!-- 			Add a third tab - extended fn in lib/livetheme.php -->
					<?php if(is_active_sidebar('social-stream-feed')): ?> 
						<li class="social-stream"> 
							<a href="javascript:;" class="social-tab"> 
							<img src="<?php bloginfo('template_directory'); ?>/images/icn-facebook-16.png" alt="logo"/>
							<?php _e('Chat', 'livetheme'); ?> 
							</a> 
						</li> 
					<?php endif; ?>
					
				</ul>
				<div class="clear"></div>
				<div id="inside">
					<div id="tab-twitter" class="list" style="height: 325px; overflow:hidden;">
						<?php dynamic_sidebar('twitter-feed'); ?>                     
					</div>
					<div id="tab-facebook" class="list">
						<?php dynamic_sidebar('facebook-feed'); ?>                     
					</div>
				<!-- Add the tab -->
					<div id="tab-social-stream" class="list"> 
						<?php dynamic_sidebar('social-stream-feed'); ?> 
					</div>
				</div><!-- /.inside -->
			</div><!-- /Social Tabs -->
			<div class="clear"></div>
			<!-- Photo Stream -->
			<?php if(standard_display_photo_stream()): ?>
			<div id="flickr" class="full-col">
				<div class="pictures">
					<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=10&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo standard_flickr_id(); ?>"></script>
					<div class="clear"></div>
				</div>
			</div><!-- /flickr -->
			<?php endif; ?>
		</div><!-- /main-top -->
		
		<!-- main-mid -->
		<div id="main-mid" class="full-width borders shadow">
			<!-- page-tabs -->
				<?php include_once( TEMPLATEPATH . '/page_tabs.php' ); ?>
			<!-- /page-tabs -->
			
			<!-- Right Side -->
			<div id="mid-right" class="col-right">
				<div id="social">
					<?php if(standard_has_social_sharers()): ?>
						<ul class="social_icons">
							<?php standard_social_sharer(); ?>
						</ul>
					<?php endif; ?>
				</div>
				<?php if(standard_display_tweet_this()): ?>
				<div id="tweet-out">
					<a class="tweet-out-btn borders" href="<?php standard_tweet_this(); ?>" title="Tweet This" target="_blank">
						<?php _e('Tweet This Out!', 'livetheme'); ?>
					</a>
				</div>
				<?php endif; ?>
				<div class="advert">
					<?php dynamic_sidebar('sidebar-ad'); ?>
				</div>
			</div><!-- /Right Side -->
			<div class="clear"></div>
		</div><!-- /main-mid -->
	</div>
<?php get_footer(); ?>