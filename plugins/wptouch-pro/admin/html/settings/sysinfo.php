<div id="system-info">
	<table>
		<tr>
			<td class="desc"><?php _e( "WordPress Version", "wptouch-pro" ); ?></td>
			<td><?php echo sprintf( __( "%s", "wptouch-pro" ), get_bloginfo( 'version' ) ); ?></td>
		</tr>			
		<tr>
			<td class="desc"><?php _e( "Server Configuration", "wptouch-pro" ); ?></td>
			<td><?php echo $_SERVER['SERVER_SOFTWARE']; ?>, <?php echo $_SERVER['GATEWAY_INTERFACE']; ?>, PHP <?php echo phpversion(); ?></td>
		</tr>
		<tr>
			<td class="desc"><?php _e( "Browser User Agent", "wptouch-pro" ); ?></td>
			<td><?php echo $_SERVER['HTTP_USER_AGENT']; ?></td>
		<tr/>
<!-- 
		<tr>
			<td class="desc"><?php _e( "Active Plugins", "wptouch-pro" ); ?></td>
			<td>(not available)</td>
		<tr/>
 -->	
	</table>
</div>