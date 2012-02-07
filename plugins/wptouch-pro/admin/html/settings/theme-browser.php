<?php if ( wptouch_has_themes() ) { ?>
	<?php while ( wptouch_has_themes() ) { ?>
		<?php wptouch_the_theme(); ?>
		
		<div class="<?php wptouch_the_theme_classes( "wptouch-theme-box round-8" ); ?>">
			<div class="wptouch-right-align <?php if ( wptouch_is_theme_active() ) { echo 'active-theme'; } ?>">
				<?php if ( wptouch_is_theme_custom() ) { ?>
				<a href="#" class="wptouch-tooltip-center" title="<?php echo sprintf( __( 'Theme Location (relative to wp-content):<br />%s', 'wptouch-pro' ), wptouch_get_theme_location() ); ?>">?</a>
				<?php } ?>
				
				<input type="hidden" class="theme-location" name="theme-location-<?php echo md5( wptouch_get_theme_location() ); ?>" value="<?php wptouch_the_theme_location(); ?>" />
				<input type="hidden" class="theme-name" name="theme-name-<?php echo md5( wptouch_get_theme_location() ); ?>" value="<?php wptouch_the_theme_title(); ?>" />
				<?php if ( !wptouch_is_theme_active() ) { ?>
				
				<a href="#" class="ajax-button activate-theme"><?php _e( 'Activate', 'wptouch-pro' ); ?></a>
				
				<!-- <input type="submit" class="button activate" name="activate-theme-<?php echo md5( wptouch_get_theme_location() ); ?>" value="<?php _e( 'Activate', 'wptouch-pro' ); ?>" />  -->
				<!-- <p class="update-available">Update Available &raquo;</p> -->
				<?php } ?>
				<?php if ( !wptouch_is_theme_custom() ) { ?>
				<!-- <input type="submit" class="button copy" name="copy-theme-<?php echo md5( wptouch_get_theme_location() ); ?>" value="<?php _e( 'Copy', 'wptouch-pro' ); ?>" /> -->
				<a href="#" class="ajax-button copy-theme"><?php _e( 'Copy', 'wptouch-pro' ); ?></a>
				<?php } ?>
				<?php if ( wptouch_is_theme_custom() ) { ?>
				<!-- <input type="submit" class="button deleteme deletetheme" name="delete-theme-<?php echo md5( wptouch_get_theme_location() ); ?>" value="<?php _e( 'Delete', 'wptouch-pro' ); ?>" <?php if ( wptouch_is_theme_active() ) echo "disabled"; ?> title="<?php _e( "You cannot delete the active theme.", "wptouch-pro" ); ?>" /> -->
					<a href="#" class="ajax-button delete-theme"><?php _e( 'Delete', 'wptouch-pro' ); ?></a>
				<?php } ?>
				<?php if ( wptouch_is_theme_active() && wptouch_active_theme_has_settings() ) { ?>
					<!-- <input type="submit" id="settings-link" class="button settings-link" name="settings-link" value="<?php _e( 'Theme Settings', 'wptouch-pro' ); ?> &raquo;" />  -->
					<a href="#" class="ajax-button theme-settings"><?php _e( 'Theme Settings', 'wptouch-pro' ); ?></a>
				<?php } ?>
			</div>
					
			<div class="wptouch-theme-left-wrap round-6">
				<img src="<?php wptouch_the_theme_screenshot(); ?>" alt="<?php echo sprintf( __( '%s Theme Image', 'wptouch-pro' ), wptouch_get_theme_title() ); ?>" />
				<h6><?php echo sprintf( __( '%s', 'wptouch-pro' ), wptouch_get_theme_version() ); ?></h6>
			</div>
			<div class="wptouch-theme-right-wrap">
				<h4><?php wptouch_the_theme_title(); ?></h4>
				<p class="wptouch-theme-author green-text"><?php echo sprintf( __( 'By %s', 'wptouch-pro' ), wptouch_get_theme_author() ); ?></p>
				<p class="wptouch-theme-description"><?php wptouch_the_theme_description(); ?></p>

				<?php if ( wptouch_theme_has_features() ) { ?>
					<p class="wptouch-theme-features"><?php echo sprintf( __( 'Features: %s', 'wptouch-pro' ), implode( wptouch_get_theme_features(), ', ' ) ); ?></p>
				<?php } ?>		
				<br class="clearer" />	
			</div>
		</div>
	<?php } ?>
<?php } else { ?>
	<?php _e( "There are currently no themes installed.", "wptouch-pro" ); ?>
<?php } ?>