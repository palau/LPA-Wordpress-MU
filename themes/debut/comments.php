<?php if ( comments_open() ) : ?>

	<div id="comments">
		
		<?php 
		/** 
		 * Post Password Required
		 *
		 */
		if ( post_password_required() ) : ?>
		
			<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'framework' ); ?></p>
	
		</div><!-- #comments-wrap -->
	
		<?php
		/** 
		 * Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return; ?>
	
	<?php endif; ?>
	
	
		<?php 
		/** 
		 * Comments
		 *
		 */
		if ( have_comments() ) : ?>
		
			<?php  
			/** 
			 * Comments Title
			 *
			 */
			?>
			
			<div class="comment-title-wrap clearfix">
				
				<h3 class="comment-title"><?php _e( 'Comments', 'framework' ); ?></h3>
				
				<div class="add-comment-link">
				  
				  <a class="scroll" href="#respond" title="<?php _e( 'Leave A Comment &rarr;', 'framework' ); ?>"><?php _e( 'Leave A Comment &rarr;', 'framework' ); ?></a>
				  
				</div><!-- .add-comment-link -->
			
			</div><!-- .comments-title-wrap -->
		
			<ol id="comments-list" class="commentlist">
			
				<?php
				/** 
				 * Comment List
				 *
				 * Using a custom callback function called ti_comment() found in functions.php
				 *
				 */
				wp_list_comments( array( 'callback' => 'ti_comment' ) ); ?>
			  
			</ol><!-- .commentlist -->
		
		<?php endif; // end have_comments() ?>
		
		
		<?php 
		/** 
		 * Comment Form
		 *
		 */
		
		$fields =  array(
			'author'  => '<p><input type="text" name="author" id="author" size="22" ><label for="author">Name <span class="required">*</span></label></p>',
			'email'   => '<p><input type="email" name="email" id="email" size="22" ><label for="email">Email <span class="required">*</span> (never published)</label></p>',
			'url'     => '<p><input type="url" name="url" id="url" size="22" ><label for="url">Website</label></p>',
		);
		
		$defaults = array(
			'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
			//'comment_field'        => '<p class="comment-form-comment">Comment Field</p>',
			//'must_log_in'          => '<p class="must-log-in">Must Be Logged In</p>',
			'logged_in_as'         => '',
			'comment_notes_before' => '<div class="respond-title-wrap clearfix"><h3 id="respond-title">' . __( 'Add Your Comment', 'framework' ) . '</h3> <span class="respond-caption">' . __( 'Your email will not be published.', 'framwork' ) . '</span></div>',
			'comment_notes_after'  => '',
			'id_form'              => 'commentform',
			'id_submit'            => 'submit',
			'title_reply'          => '',
			//'title_reply_to'       => __( 'Leave a Reply to %s', 'framework' ),
			'cancel_reply_link'    => '<div class="cancel-comment-reply">' . __( 'Click here to cancel reply.', 'framework' ) . '</div>',
			'label_submit'         => __( 'Post Comment &rarr;', 'framework' ),
		);
		
		comment_form( $defaults ); ?>
		
		<div class="clearfix"><!-- nothing to see here --></div>
	
	</div><!-- #comments -->
	
<?php endif ?>