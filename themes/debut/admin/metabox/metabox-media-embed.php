<div id="ti-media" class="ti-metabox">

	<div class="metabox-tabs-div">
		<p><?php echo __( 'It\'s super easy to embed videos, images, and other content into your WordPress site. Okay, so ', 'theme-it' ) . '<a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">' . __( 'what sites can you embed from?', 'theme-it' ) . '</a>'; ?></p>
			
		<ul class="metabox-tabs">
		  	<li class="active tab1"><a class="active" href="javascript:void(null);"><?php echo __( 'URL', 'theme-it' ); ?></a></li>
		  	<li class="tab2"><a href="javascript:void(null);"><?php echo __( 'Code', 'theme-it' ); ?></a></li>
		  	<li class="tab3"><a href="javascript:void(null);"><?php echo __( 'Help', 'theme-it' ); ?></a></li>
		</ul>
		  
		<div class="tab1">
		  	<h4 class="heading"><?php echo __( 'URL', 'theme-it' ); ?></h4>
		  	<table>
		  		<tr>
		  			<td scope="row" colspan="2">
		  				<label><strong><?php echo __( 'Media Source', 'theme-it' ); ?></strong></label>
		  				<?php $mb->the_field( 'media_source' ); ?>
		  				<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		  			</td>
		  		</tr>
		  	</table>
		</div><!-- .tab1 -->
		  
		<div class="tab2">
			<h4 class="heading"><?php echo __( 'Code', 'theme-it' ); ?></h4>
			<table>
			    <tr>
			    	<td>
			    		<?php $mb->the_field( 'media_embed_code' ); ?>
			    		<label><strong><?php echo __( 'Custom Embed Code', 'theme-it' ); ?></strong></label>
			    		<textarea name="<?php $mb->the_name(); ?>" rows="4"><?php $mb->the_value(); ?></textarea>
			    	</td>
			    </tr>
			</table>
		</div><!-- .tab2 -->
	  
		<div class="tab3">
		  	<h4 class="heading"><?php echo __( 'Help', 'theme-it' ); ?></h4>
		  	<table>
		  		<tr>
		  			<td>
		  				<strong><?php echo __( 'In General...', 'theme-it' ); ?></strong>
		  				<p><?php echo __( 'The Media Embed option (', 'theme-it' ) . '<a href="http://codex.wordpress.org/Embeds#oEmbed" target="_blank">' . __( 'oEmbed', 'theme-it' ) . '</a>' . __( ') allows you to embed media from various external sites easily. This theme uses the media embed in various ways, inserting it into the theme already sized for the best results.', 'theme-it' ); ?></p>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				<strong><?php echo __( 'URL Option', 'theme-it' ); ?></strong>
		  				<p><?php echo __( 'To use this option, simply copy and past the URL of media content from an ', 'theme-it' ) . '<a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">' . __( 'approved site', 'theme-it' ) . '</a>' . __( '(e.g. youtube.com). ', 'theme-it' ) ?></p>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				<strong><?php echo __( 'Code Option', 'theme-it' ); ?></strong>
		  				<p><?php echo __( 'Same as the URL option, only it takes embed code if provided. This option will override the URL Option.', 'theme-it' ); ?></p>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				<strong><?php echo __( 'Media Preview', 'theme-it' ); ?></strong>
		  				<p><?php echo __( 'If set, a preview of the media embed option that will show in the website will be shown below. This is done after the page has been Published or Updated', 'theme-it' ); ?></p>
		  			</td>
		  		</tr>
			</table>
		</div><!-- .tab3 -->
	  
	</div><!-- .metabox-tabs-div -->
	
	<?php if( $mb->get_the_value( 'media_source' ) || $mb->get_the_value( 'media_embed_code' ) ) : ?>
	  <div class="ti-embed-preview" style="padding-top: 8px">
	  		<?php do_action( 'get_media', get_the_ID(), 258, 145, false ); ?>
	  </div>
	<?php endif; ?>
	  
</div><!-- .ti-metabox -->

<style type="text/css">

#ti-embed-preview {
	display: block;
	border: 1px solid #DFDFDF;
	border-top: none;
}

</style>