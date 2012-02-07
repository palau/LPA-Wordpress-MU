<?php 
	$settings = wptouch_get_settings();
?>
<ul>
	<li><?php _e( "Active Theme", "wptouch-pro" ); ?>: <span><?php wptouch_bloginfo( 'active_theme_friendly_name' ); ?></span></li>
	<li><?php _e( "WPtouch Version", "wptouch-pro" ); ?>: <span><?php wptouch_bloginfo( 'version' ); ?></span> 
	<?php if ( wptouch_is_upgrade_available() ) { ?>
	<a id="upgrade-link" href="<?php echo admin_url(); ?>plugins.php?plugin_status=upgrade" class="green-text"><?php echo '(' . __( "Upgrade Available", "wptouch-pro" ) . ')'; ?></a></li>
	<?php } else { ?>
	<span class="current grey-999-text"><?php echo '(' . __( "Up To Date", "wptouch-pro" ) . ')'; ?></span>
	<?php } ?>
	
	
	<li>
	<?php if ( wptouch_has_proper_auth() && !$settings->admin_client_mode_hide_licenses ) { ?>	
		<?php if ( wptouch_has_license() ) { ?>
			<?php _e( "Status", "wptouch-pro" ); ?>: <span class="green-text"><?php _e( 'LICENSED', 'wptouch-pro' ); ?></span> | <em><?php _e( "Thank you for supporting us!", "wptouch-pro" ); ?></em>
		<?php } else { ?>
			<?php _e( "Status", "wptouch-pro" ); ?>: <span class="status-unl"><?php _e( 'ACTIVATION REQUIRED', 'wptouch-pro' ); ?></span> | <a href="#pane-5" id="status-target-pane-5" class="blue-text"><?php _e( 'Activate a Site License', 'wptouch-pro' ); ?></a>
		<?php } ?>
	<?php } elseif ( !$settings->admin_client_mode_hide_licenses ) { ?>
			<?php _e( "Status", "wptouch-pro" ); ?>: <span class="status-unl"><?php _e( 'UNLICENSED', 'wptouch-pro' ); ?></span><?php if ( !wptouch_is_multisite_enabled() || ( wptouch_is_multisite_enabled() && wptouch_is_multisite_primary() ) ) { ?> | <a href="http://www.bravenewcode.com/store/?utm_source=wptouch_pro&utm_medium=web&utm_campaign=admin-purchase" class="green-text"><?php _e( 'Purchase a License', 'wptouch-pro' ); ?></a><?php } ?>
	<?php } ?>
	</li>
</ul>