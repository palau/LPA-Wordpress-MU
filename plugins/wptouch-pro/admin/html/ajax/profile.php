<div id="wptouch-admin-profile">
	<h5><?php _e( "Active Site Licenses", "wptouch-pro" ); ?></h5>
	
	<?php if ( wptouch_has_site_licenses() ) { ?>
		<p><?php _e( "You have activated these sites for automatic upgrades & support:", "wptouch-pro" ); ?></p>
		<ol class="round-6">
			<?php while ( wptouch_has_site_licenses() ) { ?>
				<?php wptouch_the_site_license(); ?>
				<li <?php if ( wptouch_can_delete_site_license() ) { echo 'class="green-text"'; } ?>>
					<?php wptouch_the_site_license_name(); ?> <?php if ( wptouch_can_delete_site_license() ) { ?><a class="wptouch-remove-license" href="#" rel="<?php wptouch_the_site_license_name(); ?>" title="<?php _e( "Remove license?", "wptouch-pro" ); ?>">(x)</a><?php } ?></li>
					<?php $count++; ?>
			<?php } ?>
		</ol>
		<?php if ( wptouch_get_site_licenses_remaining() != BNC_WPTOUCH_UNLIMITED ) { ?>
			<?php echo sprintf( __( "%s%d%s licenses remaining.", "wptouch-pro" ), '<strong>', wptouch_get_site_licenses_remaining(), '</strong>' ); ?><br /><br />	
		<?php } ?>
		
		<?php if ( wptouch_get_site_licenses_remaining() ) { ?>
			<?php if ( !wptouch_is_licensed_site() ) { ?>
				<a class="wptouch-add-license ajax-button" href="#"><?php _e( "Connect a license for this site", "wptouch-pro" ); ?> &raquo;</a>		
			<?php } else { ?>
				
			<?php } ?>
		<?php } else { ?>
			 <a href="http://www.bravenewcode.com/store/upgrade/?utm_source=wptouch_pro&utm_medium=web&utm_campaign=admin-upgrades"><?php _e( "Upgrade WPtouch Pro to obtain more licenses.", "wptouch-pro" ); ?></a>
		<?php } ?>	
	<?php } else { ?>
		<p>
			<br />
			<?php if ( wptouch_get_site_licenses_remaining() ) { ?>
				<?php _e( "You have not activated a license for this website's domain.", "wptouch-pro" ); ?>
				<a class="wptouch-add-license round-24" id="partial-activation" href="#"><?php _e( "Activate This Domain &raquo;", "wptouch-pro" ); ?></a>
			<?php } else { ?>
				<?php _e( "You have no licenses left.", "wptouch-pro" ); ?>
			 <a href="http://www.bravenewcode.com/store/upgrade/?utm_source=wptouch_pro&utm_medium=web&utm_campaign=admin-upgrades"><?php _e( "Upgrade WPtouch Pro to obtain additional licenses.", "wptouch-pro" ); ?></a>
			<?php } ?>
		</p>	
	<?php } ?>
	<br class="clearer" />
</div>

<?php
global $wptouch_pro;
$wptouch_pro->bnc_api->verify_site_license( 'wptouch-pro' );
?>