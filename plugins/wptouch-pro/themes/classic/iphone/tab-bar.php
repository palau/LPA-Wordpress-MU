	<!-- The tab Icon Bar -->
	<div id="tab-bar">
		<?php if ( classic_show_search_button() ) { ?>
			<div id="tab-inner-wrap-right">
				<a id="tab-search" class="no-ajax" href="#"><?php _e( 'Search', 'wptouch-pro' ); ?></a>
			</div>
		<?php } ?>
		<div id="tab-inner-wrap-left">
			<a href="#menu-tab1"  id="tab-pages" class="first-tab no-ajax"><?php _e( "Menu", "wptouch-pro" ); ?></a>
			<?php if ( classic_show_categories_tab() ) { ?>
				<a href="#menu-tab2" id="tab-categories" class="no-ajax"><?php _e( "Categories", "wptouch-pro" ); ?></a>
			<?php } ?>
			<?php if ( classic_show_tags_tab() ) { ?>
				<a href="#menu-tab3" id="tab-tags" class="no-ajax"><?php _e( "Tags", "wptouch-pro" ); ?></a>
			<?php } ?>
			<?php if ( wptouch_prowl_direct_message_enabled() ) { ?>
			<a href="#menu-tab4" id="tab-push" class="no-ajax"><?php _e( "Message", "wptouch-pro" ); ?></a>
			<?php } ?>
			<?php if ( classic_show_account_tab() ) { ?>
			<a href="#menu-tab5" id="tab-login" class="no-ajax <?php if ( is_user_logged_in() ) { echo 'logged-in'; } ?>"><?php if ( is_user_logged_in() ) {  _e( "Account", "wptouch-pro" ); } else { _e( "Login", "wptouch-pro" ); } ?></a>
			<?php } ?>
		</div>
	</div>
	
	<div id="menu-container">
		<div id="menu-tab1">
			<h2><?php _e( "Menu", "wptouch-pro" ); ?></h2>
			<!-- The WPtouch Page Menu -->		
			<?php wptouch_show_menu(); ?>
		</div>

		<?php if ( classic_show_categories_tab() ) { ?>
			<div id="menu-tab2">
				<h2><?php _e( "Categories", "wptouch-pro" ); ?></h2>
				<?php wptouch_ordered_cat_list(); ?>
			</div>
		<?php } ?>

		<?php if ( classic_show_tags_tab() ) { ?>
			<div id="menu-tab3">
				<h2><?php _e( "Tags", "wptouch-pro" ); ?></h2>
				<?php wp_tag_cloud( 'smallest=13&largest=13&unit=px&number=20&order=asc&format=list' ); ?>
			</div>
		<?php } ?>
		
		<?php if ( wptouch_prowl_direct_message_enabled() ) { ?>
		<div id="menu-tab4">
			 <h4><?php _e( "Send a Message", "wptouch-pro" ); ?></h4>
			 <p><?php _e( "This message will be pushed to the admin's iPhone instantly.", "wptouch-pro" ); ?></p>
			 
			 <form id="prowl-direct-message" method="post" action="">
			 	<p>
			 		<input name="prowl-msg-name" id="prowl-msg-name" type="text" tabindex="3" />
			 		<label for="prowl-msg-name"><?php _e( 'Name', 'wptouch-pro' ); ?></label>
			 	</p>
				<p>
					<input name="prowl-msg-email" id="prowl-msg-email" autocapitalize="off" type="text" tabindex="4" />
					<label for="prowl-msg-email"><?php _e( 'E-Mail', 'wptouch-pro' ); ?></label>
				</p>
				<textarea name="prowl-msg-message" tabindex="5"></textarea>
				<input type="submit" name="prowl-submit" value="<?php _e( 'Send Now', 'wptouch-pro' ); ?>" id="prowl-submit" tabindex="6" />
				<input type="hidden" name="wptouch-prowl-nonce" value="<?php echo wp_create_nonce( 'wptouch-prowl' ); ?>" />			
			 </form>
		</div>
		<?php } ?>
		
		<div id="menu-tab5">
			<?php if ( is_user_logged_in() ) { ?>
					<ul>
						<?php if ( current_user_can( 'edit_posts' && classic_show_admin_menu_link() ) ) { ?>
							<li><a href="<?php bloginfo('wpurl'); ?>/wp-admin/"><?php _e( "Admin", "wptouch-pro" ); ?></a></li>
						<?php } ?>
						<?php if ( classic_show_profile_menu_link() ) { ?>
							<li><a href="<?php bloginfo('wpurl'); ?>/wp-admin/profile.php"><?php _e( "Account Profile", "wptouch-pro" ); ?></a></li>
						<?php } ?>
						<li><a href="<?php echo wp_logout_url( wptouch_get_current_page_url() ); ?>"><?php _e( "Logout", "wptouch-pro" ); ?></a>
						</li>
					</ul>
				
			<?php } else { ?>

				<form name="loginform" id="loginform" action="<?php bloginfo('wpurl'); ?>/wp-login.php?redirect_to=<?php wptouch_the_current_page_url(); ?>" method="post" class="clearfix">
					<div>
						<label for="log" id="log-label"><?php _e( 'Username', 'wptouch-pro' ); ?></label>
						<input type="text" autocapitalize="off" name="log" id="log" value="" tabindex="7" />
					</div>
					<div>
						<label for="pwd" id="pwd-label"><?php _e( 'Password', 'wptouch-pro' ); ?></label>
						<input autocapitalize="off" type="password" name="pwd"  id="pwd" value="" tabindex="8" />
						<input type="hidden" name="submit" id="logsub" tabindex="9" value="<?php _e( 'Login', 'wptouch-pro' ); ?>" />
						<input type="hidden" name="rememberme" checked="yes" value="forever"/>
					</div>
				<?php if ( classic_show_account_tab() ) { ?>
					<p><?php echo sprintf( __( "Not registered yet?<br />You can %ssign-up here%s.", "wptouch-pro" ), '<a class="no-ajax" href="' . get_bloginfo( 'wpurl' ) . '/wp-register.php">','</a>' ); ?>
					</p>
					<p><?php echo sprintf(__( "Lost your password?<br />You can %sreset it here%s.", "wptouch-pro" ), '<a class="no-ajax" href="' . get_bloginfo( 'wpurl' ) . '/wp-login.php?action=lostpassword">','</a>' ); ?>
					</p>					
				<?php } ?>
			</form>
			<?php } ?>
		</div>
	</div><!-- #tab-bar -->