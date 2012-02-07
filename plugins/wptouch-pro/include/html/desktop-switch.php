<?php if ( wptouch_show_switch_link() ) { ?>
	<div id="wptouch-desktop-switch">	
		<?php _e( "Desktop Version", "wptouch-pro" ); ?> | <a href="<?php wptouch_the_desktop_switch_link(); ?>"><?php _e( "Switch To Mobile Version", "wptouch-pro" ); ?></a>
	</div>
<?php } ?>