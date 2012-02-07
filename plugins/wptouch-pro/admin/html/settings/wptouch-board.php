<?php 
	global $wptouch_pro; 
	$settings = wptouch_get_settings();
?>

<div class='wptouch-setting' id='touchboard'>
	<div class="box-holder round-6" id="right-now-box">

		<h3><?php _e( "Right Now", "wptouch-pro" ); ?></h3>

		<p class="sub"><?php _e( "At a Glance", "wptouch-pro" ); ?></p>

		<table class="fonty">
		<tbody>
			<tr>
				<td class="box-table-number"><?php wptouch_bloginfo( 'theme_count' ); ?></td>
				<td class="box-table-text"><a href="#" rel="themes" class="wptouch-admin-switch"><?php _e( "Themes", "wptouch-pro" ); ?></a></td>
			</tr>
			<tr>
				<td class="box-table-number"><?php wptouch_bloginfo( 'icon_count' ); ?></td>
				<td class="box-table-text"><a href="#" rel="icons" class="wptouch-admin-switch"><?php _e( "Icons", "wptouch-pro" ); ?></a></td>
			</tr>
			<tr>
				<td class="box-table-number"><?php wptouch_bloginfo( 'icon_set_count' ); ?></td>
				<td class="box-table-text"><a href="#" rel="icon-sets" class="wptouch-admin-switch"><?php _e( "Icon Sets", "wptouch-pro" ); ?></a></td>
			</tr>
			<?php if ( wptouch_get_bloginfo( 'warnings' ) ) { ?>
			<tr id="board-warnings">
				<td class="box-table-number"><?php wptouch_bloginfo( 'warnings' ); ?></td>
				<td class="box-table-text"><a href="#" rel="plugin-conflicts" class="wptouch-admin-switch"><?php _e( "Warnings", "wptouch-pro" ); ?></a></td>
			</tr>
			<?php } ?>
			<?php if ( wptouch_has_license() && !$settings->admin_client_mode_hide_licenses	 ) { ?>
			<tr id="wptouch-licenses-remaining">
				<td class="box-table-number">&nbsp;</td>
				<td class="box-table-text">&nbsp;</td>
			</tr>
			<?php } ?>
		</tbody>
		</table>

		<div id="touchboard-ajax"></div>
		
	</div><!-- box-holder -->

	<div class="box-holder loading round-6" id="blog-news-box">
		<h3><?php _e( "WPtouch News", "wptouch-pro" ); ?></h3>

		<p class="sub"><?php _e( "From the BraveNewCode Blog", "wptouch-pro" ); ?></p>

		<div id="blog-news-box-ajax"></div>

	</div><!-- box-holder -->

	<?php if ( wptouch_has_proper_auth()  && !$settings->admin_client_mode_hide_licenses ) { ?>	
		<?php if ( wptouch_has_license() ) { ?>	
			<div class="box-holder loading round-6" id="support-threads-box">
				<h3><?php _e( "WPtouch Support Posts", "wptouch-pro" ); ?></h3>
		
				<p class="sub"><?php _e( "From the WPtouch Pro Forums", "wptouch-pro" ); ?></p>
				
				<div id="support-threads-box-ajax"></div>
		
			</div><!-- box-holder -->
			
			<div class="box-holder round-6" id="support-form-box">
				<h3><?php _e( "Support Topic QuickPress", "wptouch-pro" ); ?></h3>
				
				<div id="support-form-inside">	
					<p class="sub"><?php _e( "Add a New Topic to the Pro Forums", "wptouch-pro" ); ?></p>
			
					<input autocomplete="off" type="text" class="text" id="forum-post-title" name="forum-post-title" value="" />
					<label class="text" for="forum-post-title">
					<?php _e( "Topic Title", "wptouch-pro" ); ?>
					</label>			
					
					<input autocomplete="off" type="text" class="text" id="forum-post-tag" name="forum-post-tag" value="" />
					<label class="text" for="forum-post-tag">
					<?php _e( "Topic Tags", "wptouch-pro" ); ?> <a href="#" class="wptouch-tooltip-left" title="<?php _e( "Comma separated list", "wptouch-pro" ); ?>">?</a>
					</label>			
					
					<textarea rows="5" class="textarea"  id="forum-post-content" name="forum-post-content"></textarea>			
					<a href="#" class="button" id="support-form-submit"><?php _e( 'Publish', 'wptouch-pro' ); ?></a>
				</div>
		
			</div><!-- box-holder -->
		<?php } else { ?>
			<br class="clearer" />
			<div id="unlicensed-board" class="partial round-6">
				<strong><?php echo sprintf( __( "Your copy of WPtouch Pro %s is partially activated.", "wptouch-pro" ), wptouch_get_bloginfo( 'version' ) ); ?></strong>
				<a href="#pane-5" id="target-pane-5" class="partial"><?php _e( "Add a site license &raquo;", "wptouch-pro" ); ?></a>
			</div>		
		<?php } ?>
	<?php } elseif ( !$settings->admin_client_mode_hide_licenses ) { ?>	
	<br class="clearer" />
	<div id="unlicensed-board" class="round-6">
		<strong><?php echo sprintf( __( "This copy of WPtouch Pro %s is unlicensed.", "wptouch-pro" ), wptouch_get_bloginfo( 'version' ) ); ?></strong>
		<?php if ( !wptouch_is_multisite_enabled() || ( wptouch_is_multisite_enabled() && wptouch_is_multisite_primary() ) ) { ?>
			<a href="#pane-5" id="target-pane-5"><?php _e( "Get started with Activation &raquo;", "wptouch-pro" ); ?></a>
		<?php } ?>
	</div>
	<?php } ?>

</div><!-- wptouch-setting -->