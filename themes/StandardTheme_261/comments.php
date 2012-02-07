<?php /* this is comments.php */ 
global $standard_options;
?>
<?php if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])):
	die ('Please do not load this page directly. Thanks!');
endif;
if (post_password_required()): ?>
	<p class="nocomments">
		<?php _e('This post is <strong>password protected</strong>. Enter the password above to view the comments.','standardtheme'); ?>
	</p>
<?php endif; ?>

<?php if (have_comments()) : ?>
	<?php if (!empty($comments_by_type['comment']) ) : ?>
		<div id="comments">
			<h3>
				<?php comments_number(__('No Responses','standardtheme'), __('One Response','standardtheme'), __('% Responses','standardtheme'));?> <?php _e('to','standardtheme'); ?> &#8220;<?php the_title(); ?>&#8221;
			</h3>
			<ol class="commentlist">
				<?php wp_list_comments('avatar_size=36&callback=custom_comment&type=comment'); ?>
			</ol>    
			<div class="comment-navigation">
				<div class="fl">
					<?php previous_comments_link() ?>
				</div>
				<div class="fr">
					<?php next_comments_link() ?>
				</div>
				<div class="fix"></div>
			</div>
		</div>
	<?php endif; ?>
	<?php if (!empty($comments_by_type['pings'])): ?>
		<div id="pings">
			<h3>
				<?php _e('Trackbacks/Pingbacks:','standardtheme'); ?>
			</h3>
		<ol class="pinglist">
			<?php wp_list_comments('type=pings&callback=list_pings'); ?>
		</ol>
	</div>
	<?php endif; ?>	
<?php else: ?>
	<?php if('open' == $post->comment_status): ?>
		<div id="no-comments">
			<h2 class="title">
				<?php _e('Wow. It\'s Quiet Here...','standardtheme'); ?>
			</h2>
			<p>
				<?php _e('Be the first to start the conversation!','standardtheme'); ?>
			</p>
			<div class="fix"></div>
		</div>
	<?php else: ?>
		<div id="no-comments">
			<h2 class="title">
				<?php _e('Sorry, Comments are Closed.','standardtheme'); ?>
			</h2>
			<p>
				<?php _e('You\'ll have to take it up with the author...','standardtheme'); ?>
			</p>
			<div class="fix"></div>
		</div>
	<?php endif; ?>
<?php endif; ?>
<?php if ('open' == $post->comment_status): ?>
	<div id="respond">
		<h3>
			<?php comment_form_title( __('Leave a Reply:','standardtheme'), __('Leave a Reply to %s','standardtheme') ); ?>
		</h3>
		<?php if ($user_ID != ''): ?>
			<div class="pre_comment_avatar">
				<?php 
					echo get_avatar(get_the_author_meta('user_email', $user_ID), '105', $default = $standard_options->gravatar_image);
					//echo get_avatar(null, '105', $default = $standard_options->gravatar_image); 
				?>
			</div>
		<?php else: ?>
			<div class="pre_comment_avatar">
				<img id="gravatar" alt="Gravatar Image" height="105px" width="105px" src="<?php echo $standard_options->gravatar_image; ?>" />
			</div>
		<?php endif; ?>
	<div class="cancel-comment-reply">
		<small>
			<?php cancel_comment_reply_link(); ?>
		</small>
	</div>
	<?php if ( get_option('comment_registration') && !$user_ID ): ?>
		<p>
			<?php printf(__('You must be <a href="%s/wp-login.php?redirect_to=%s">logged in</a> to post a comment.','standardtheme'), get_option('siteurl'), urlencode(get_permalink())); ?>
		</p>
	<?php else : //No registration required ?>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
			<?php if ( $user_ID ): ?>
			<p>
				<?php printf(__('Logged in as <a href="%s/wp-admin/profile.php">%s</a>. <a href="%s" title="Log out of this account">Logout &raquo;</a>','standardtheme'), get_option('siteurl'), $user_identity, wp_logout_url()); ?>
				</p>
			<?php else : //If user is not logged in ?>
				<p>
					<input type="text" name="author" class="txt" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" />
					<label for="author"><?php _e('Name','standardtheme'); ?>
						<?php if ($req) _e("(required)"); ?>
					</label>
				</p>
				<p>
					<input type="text" name="email" class="txt" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" />
					<label for="email"><?php _e('Email','standardtheme'); ?>
						<?php if ($req) _e("(required)"); ?>
					</label>
				</p>
				<p>
					<input type="text" name="url" class="txt" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
					<label for="url"><?php _e('URL','standardtheme'); ?></label>
				</p>
			<?php endif; // End if logged in ?>
			<?php if($standard_options->comment_shortcodes): ?>
				<p>
					<strong>
						<?php _e('XHTML','standardtheme'); ?>:
					</strong> 
					<?php echo allowed_tags(); ?>
				</p>
			<?php endif; ?>
			<p>
				<textarea name="comment" id="comment" rows="10" cols="50" tabindex="4"></textarea>
			</p>
			<input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment','standardtheme'); ?>" />
			<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
			<?php comment_id_fields(); ?>
			<?php do_action('comment_form', $post->ID); ?>
		</form>
	<?php endif; // If registration required ?>
	<div class="fix"></div>
</div>
<?php endif; ?>