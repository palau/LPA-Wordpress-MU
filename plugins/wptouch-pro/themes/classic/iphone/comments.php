<?php

// Do not delete these lines
	if ( !empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
		die ('Please do not load this page directly. Thanks!');
	}

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e( "This post is password protected. Enter the password to view comments", "wptouch-pro" ); ?>.</p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( classic_show_share_single() ) { ?>					
	<a id="share-post" href="#share-absolute-div" class="post no-ajax rounded-corners-8px<?php if ( !have_comments() ) echo ' share-center'; ?>"><?php _e( "Share or Save", "wptouch-pro" ); ?></a>
<?php } ?>

	<div id="share-absolute">
		<ul id="share-overlay">
			<li id="twitter">
				<a id="share-close" class="no-ajax" href="#share-overlay">&nbsp;</a>
				<a href="http://m.twitter.com/home/?status=<?php echo urlencode( html_entity_decode( wptouch_get_title() . ' -> ' . get_permalink() ) ); ?>" class="no-ajax"><?php _e( "Share on Twitter", "wptouch-pro" ); ?></a>
			</li>
			<li id="facebook"><a  target="_blank" class="no-ajax" href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&t=<?php the_title();?>"><?php _e( "Share on Facebook", "wptouch-pro" ); ?></a></li>
			<li id="email"><a class="no-ajax" href="mailto:?subject=<?php
			wptouch_get_bloginfo('site_title'); ?>%20-%20<?php the_title_attribute();?>&body=<?php _e( "Check out this post:", "wptouch" ); ?>%20<?php the_permalink(); ?>"><?php _e( "Share", "wptouch-pro" ); ?><br /><?php _e( "via E-Mail", "wptouch-pro" ); ?></a></li>
			<li id="delicious"><a class="no-ajax" target="_blank" href="http://del.icio.us/post?url=<?php the_permalink(); ?>&title=<?php the_title();?>"><?php _e( "Save to Del.icio.us", "wptouch-pro" ); ?></a></li>
			<li id="instapaper"><a class="no-ajax" href="#"><?php _e( "Save to Instapaper", "wptouch-pro" ); ?></a></li>
			<li id="rss"><a class="no-ajax" href="<?php echo wptouch_get_bloginfo('rss_url'); ?>"><?php _e( "RSS", "wptouch-pro" ); ?><br /><?php _e( "Feed", "wptouch-pro" ); ?></a></li>
		</ul>
	</div>

<?php if ( have_comments() ) : ?>
	
	<?php classic_com_toggle(); ?>

	<?php if ( classic_wp_comments_nav_on() && !classic_is_ajax_enabled() ) { ?>
		<div class="navigation">
			<div class="alignleft"><?php previous_comments_link() ?></div>
			<div class="alignright"><?php next_comments_link() ?></div>
		</div>
	<?php } ?>
	
	<ol class="commentlist rounded-corners-8px <?php if ( classic_hide_responses() ) echo 'hidden'; ?>">
		<?php wp_list_comments('type=comment&callback=classic_custom_comments'); ?>
		<?php if ( classic_is_ajax_enabled() ) { ?>
			<?php if ( classic_comments_newer() ) { ?>
				<li class="load-more-comments-link"><?php previous_comments_link(__( "Load More Comments&hellip;", "wptouch-pro" ) ); ?></li>
			<?php } else { ?>
				<li class="load-more-comments-link"><?php next_comments_link(__( "Load More Comments&hellip;", "wptouch-pro" ) ); ?></li>
			<?php } ?>
		<?php } ?>
	</ol>

	<?php if ( classic_wp_comments_nav_on() && !classic_is_ajax_enabled() ) { ?>
		<div class="navigation">
			<div class="alignleft"><?php previous_comments_link() ?></div>
			<div class="alignright"><?php next_comments_link() ?></div>
		</div>
	<?php } ?>
	
	
 
<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php _e( "Comments are closed", "wptouch-pro" ); ?>.</p>
	<?php endif; ?>
	
<?php endif; ?>

<?php if ( comments_open() ) : ?>

	<div id="respond">
	
	<h3><?php comment_form_title( __( 'Leave a Reply', 'wptouch-pro' ), __( 'Leave a Reply to %s', 'wptouch-pro' ) ); ?></h3>
	
	<div class="cancel-comment-reply">
		<small><?php cancel_comment_reply_link( __( 'Cancel', 'wptouch-pro' ) ); ?></small>
	</div>
	
	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
	<p><?php echo sprintf( __( "You must be %slogged in%s to post a comment.", "wptouch-pro" ), '<a href="' . wp_login_url( get_permalink() ) . '">', '</a>' ); ?></p>
	
	<?php else : ?>
	
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		<?php if ( is_user_logged_in() ) : ?>
		
		<p><?php _e( "Logged in as", "wptouch-pro" ); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e( "Log out of this account", "wptouch-pro" ); ?>"><?php _e( "Log out", "wptouch-pro" ); ?> &raquo;</a></p>
		
		<?php else : ?>
		
		<p><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" <?php if ( $req ) echo "aria-required='true'"; ?> tabindex="10" />
		<label for="author"><?php _e( "Name", "wptouch-pro" ); ?><?php if ( $req ) echo "*"; ?></label></p>
		
		<p><input type="email" autocapitalize="off" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" <?php if ( $req ) echo "aria-required='true'"; ?> tabindex="11" />
		<label for="email"><?php _e( "E-Mail", "wptouch-pro" ); ?><?php if ( $req ) echo "*"; ?></label></p>
		
		<p><input type="url" autocapitalize="off" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="12" />
		<label for="url"><?php _e( "Website", "wptouch-pro" ); ?></label></p>
				
		<?php endif; ?>
			
		<p><textarea name="comment" id="comment" cols="58" rows="10" tabindex="13"></textarea></p>
		
		<p><input name="submit" type="submit" id="submit" value="<?php _e( "Publish", "wptouch-pro" ); ?>" tabindex="14" /></p>
		
		<?php comment_id_fields(); ?>
		
		<?php do_action( 'comment_form', $post->ID ); ?>
	
	</form>
	
	<?php endif; // If registration required and not logged in ?>
	</div>

<?php endif; // if you delete this the sky will fall on your head ?>