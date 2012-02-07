<?php
	global $wptouch_pro;
	$wptouch_pro->bnc_api->verify_site_license( 'wptouch-pro' );
	$settings = wptouch_get_settings();
?>

	
<?php if ( wptouch_has_proper_auth() && !$settings->admin_client_mode_hide_licenses ) { ?>
	<?php if ( wptouch_has_license() ) { ?>
	<p class="license-valid round-6"><span><?php _e( 'License accepted, thank you for supporting WPtouch Pro!', 'wptouch-pro' ); ?></span></p>	
	<?php } else { ?>
	<p class="license-partial round-6"><span><?php echo sprintf( __( 'Your BNCID and License Key have been accepted. <br />Next, %sconnect a site license%s to this domain to enable support and automatic upgrades.', 'wptouch-pro' ), '<a href="#pane-5" class="configure-licenses">', '</a>' ); ?></span></p>
	<?php } ?>
<?php } else { ?>
	<?php if ( wptouch_credentials_invalid() ) { ?>
	<p class="license-invalid bncid-failed round-6"><span><?php echo __( 'This BNCID/License Key combination you have entered was rejected by the BraveNewCode server. Please try again.' ); ?></span></p>	
	<?php } else { ?>
	<p class="license-invalid round-6"><span><?php echo sprintf( __( 'Please enter your BNCID and License Key to begin the license activation process, or %spurchase a license &raquo;%s', 'wptouch-pro' ), '<a href="http://www.bravenewcode.com/products/wptouch-pro/">', '</a>' ); ?></span></p>
	<?php } ?>
<?php } ?>