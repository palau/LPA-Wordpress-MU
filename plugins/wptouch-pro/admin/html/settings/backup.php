<textarea rows="5" class="textarea" readonly>
<?php
	$settings = wptouch_get_settings();
	
	if ( function_exists( 'gzcompress' ) ) {
		echo base64_encode( gzcompress( serialize( $settings ), 9 ) );
	}
?>
</textarea>