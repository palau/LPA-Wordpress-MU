<?php 
/*
Template Name: Landing Page, Enlace Stream 
*/ ?>
<?php get_header(); ?>
	<div id="content" class="col-full">
		<div id="main-mid" class="full-width borders shadow">
				<?php if (have_posts()) : $count = 0; ?>
					<?php while (have_posts()) : the_post(); $count++; ?>
						<div class="post" style="padding: 10px; width:640px; float:left;">
							<?php edit_post_link('edit','<span class="the_edit_link">','</span>') ?>
							<div class="entry borders shadow" style="background-color: #fff; margin: 0; padding: 20px">	
							<h2><?php the_title(); ?></h2>
								<?php the_content(); ?>
<?php 
/*							
<script type="text/javascript" src="http://www.unored.com/streams/flash/player5/swfobject.js"></script>
<div id="mediaspace">Señal En Vivo - Enlace </div>
	<script type="text/javascript">// <![CDATA[
		var so = new SWFObject('http://www.unored.com/streams/flash/player5/player.swf','mpl','600','469','9');
			so.addParam('allowfullscreen','true');
			so.addParam('allowscriptaccess','always');
			so.addParam('wmode','opaque');
			so.addVariable('rtmp.subscribe', 'true');
			so.addVariable('file','str.sdp');
			so.addVariable('skin','http://enlace.org/videos/wp-content/mediaplayer-viral/glow.zip');
			so.addVariable('streamer','rtmp://cdne.unored.com/enlace');
			so.addVariable('autostart','false');
			so.write('mediaspace');
	// ]]>
	</script>
*/
?>			
								
							</div>
						</div>
					<?php endwhile; 
				else: ?>
					<div class="post">
						<h2 class="title">
							<?php _e('Sorry!','livetheme'); ?>
						</h2>
						<p>
							<?php _e('Whoops! Something broke. Please try again!','livetheme'); ?>
						</p>
					</div>
				<?php endif; ?>	
				
							<!-- Right Side -->
			<div id="mid-right" class="col-right">

			<h2>live chat</h2>			
			<iframe width="300" height="400" src="http://cdn.livestream.com/embed/palau?layout=6&showTimestamp=true&height=400&width=300" style="border:0;outline:0;margin:5px 0 20px 0" frameborder="0" scrolling="no" bgcolor="#ccc"></iframe>

			<h2>connect</h2>			
			<!-- Social Tabs -->
			<div id="social-tabs" style="margin: 5px 0 40px 0; width="300px">			
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
				</ul>
				<div class="clear"></div>
				<div id="inside">
					<div id="tab-twitter" class="list" style="height: 325px; overflow:hidden;">
						<?php dynamic_sidebar('twitter-feed'); ?>                     
					</div>
					<div id="tab-facebook" class="list">
						<?php dynamic_sidebar('facebook-feed'); ?>                     
					</div>	
				</div><!-- /.inside -->
			</div> <!-- /Social Tabs -->


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

				<h2 style="font-size: 30px">make a difference</h2>			

				<div class="advert">
					<?php dynamic_sidebar('sidebar-ad'); ?>
				</div>
			</div><!-- /Right Side -->

				
				<div style="clear: both;"> </div>
		</div>
	</div>
<?php get_footer(); ?>