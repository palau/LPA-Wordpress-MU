<td class="box-table-number" id="wptouch-licenses-remaining">
	<?php $remaining = wptouch_get_bloginfo( 'support_licenses_remaining' ); ?>
	<?php if ( $remaining == BNC_WPTOUCH_UNLIMITED ) { ?>
		&infin;
	<?php } else { ?>
		<?php echo $remaining; ?>
	<?php } ?>
</td>
<td class="box-table-text"><a href="#" rel="licenses" class="wptouch-admin-switch"><?php _e( "Licenses Remaining", "wptouch-pro" ); ?></a></td>