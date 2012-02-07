<?php 
// Get MediaAccess global variable
global $wpalchemy_media_access; 
?>

<div id="ti-hero" class="ti-metabox">

	<div class="metabox-tabs-div">
	  
	  <ul class="metabox-tabs" id="metabox-tabs">
	  	<li class="active tab1"><a class="active" href="javascript:void(null);"><?php echo __( 'Content Layout', 'theme-it' ); ?></a></li>
	  	<li class="tab2"><a href="javascript:void(null);"><?php echo __( 'Background Image', 'theme-it' ); ?></a></li>
	  	<li class="tab3"><a href="javascript:void(null);"><?php echo __( 'Help', 'theme-it' ); ?></a></li>
	  </ul>
	  
	  <div class="tab1">
	  	<h4 class="heading"><?php echo __( 'Content Layout', 'theme-it' ); ?></h4>
	  	<table class="form-table">
	  		<tr>
					<th scope="col"><?php echo __( 'Position', 'theme-it' ); ?></th>
					<th scope="col"><?php echo __( 'Visibility', 'theme-it' ); ?></th>
					<th scope="col"><?php echo __( 'Color ', 'theme-it' ) . '<span style="font-weight: normal">' . __( '(Text ', 'theme-it' ) . '<em>' . __( 'on ', 'theme-it' ) . '</em>' . __( 'Bg)', 'theme-it' ) . '</span>'; ?></th>
	  		</tr>
	  		<tr>
	  			<td>
	  	  		<?php $mb->the_field( 'position' ); ?>
	  	  	  <input type="radio" name="<?php $mb->the_name(); ?>" value="alignleft"<?php $mb->the_radio_state( 'alignleft' ); ?>/> <?php echo __( 'Content Left', 'theme-it' ); ?><br />
	  	  	  <input type="radio" name="<?php $mb->the_name(); ?>" value="alignright"<?php $mb->the_radio_state( 'alignright' ); ?>/> <?php echo __( 'Content Right', 'theme-it' ); ?><br />
	  	  	  <input type="radio" name="<?php $mb->the_name(); ?>" value="centercontent"<?php $mb->the_radio_state( 'centercontent' ); ?>/> <?php echo __( 'Content Center', 'theme-it' ); ?><br />
	  	  	  <input type="radio" name="<?php $mb->the_name(); ?>" value="centermedia"<?php $mb->the_radio_state( 'centermedia' ); ?>/> <?php echo __( 'Media Embed Center', 'theme-it' ); ?>
	  			</td>
	  			<td>
						<?php $mb->the_field( 'hero_title' ); ?>
						<label><input type="checkbox" name="<?php $mb->the_name(); ?>" value="1"<?php if ( $mb->get_the_value() ) echo ' checked="checked"'; ?>/> 
						<?php echo __( 'Hide Title', 'theme-it' ); ?></label><br />
						<?php $mb->the_field( 'hero_content' ); ?>
						<label><input type="checkbox" name="<?php $mb->the_name(); ?>" value="1"<?php if ( $mb->get_the_value() ) echo ' checked="checked"'; ?>/>
						<?php echo __( 'Hide Content', 'theme-it' ); ?></label><br />
						<?php $mb->the_field( 'hero_media' ); ?>
						<label><input type="checkbox" name="<?php $mb->the_name(); ?>" value="1"<?php if ( $mb->get_the_value() ) echo ' checked="checked"'; ?>/>
						<?php echo __( 'Hide Media Embed', 'theme-it' ); ?></label><br />						<?php $mb->the_field( 'hero_more_link' ); ?>
						<label><input type="checkbox" name="<?php $mb->the_name(); ?>" value="1"<?php if ( $mb->get_the_value() ) echo ' checked="checked"'; ?>/>
						<?php echo __( 'Hide More Link', 'theme-it' ); ?></label>
	  			</td>
	  			<td>
				  	<?php $mb->the_field( 'color' ); ?>
				  	<input type="radio" name="<?php $mb->the_name(); ?>" value="dark-on-light"<?php $mb->the_radio_state( 'dark-on-light' ); ?>/> 
				  	<?php echo __( 'Dark', 'theme-it' ) . ' <em>' . __( 'on', 'theme-it' ) . '</em>' . __( ' Light', 'theme-it' ); ?><br />
				  	<input type="radio" name="<?php $mb->the_name(); ?>" value="light-on-dark"<?php $mb->the_radio_state( 'light-on-dark' ); ?>/> 
				  	<?php echo __( 'Light', 'theme-it' ) . ' <em>' . __( 'on', 'theme-it' ) . '</em>' . __( ' Dark', 'theme-it' ); ?><br />
				  	<input type="radio" name="<?php $mb->the_name(); ?>" value="dark-on-none"<?php $mb->the_radio_state( 'dark-on-none' ); ?>/> 
				  	<?php echo __( 'Dark', 'theme-it' ) . ' <em>' . __( 'on', 'theme-it' ) . '</em>' . __( ' None', 'theme-it' ); ?><br />
				  	<input type="radio" name="<?php $mb->the_name(); ?>" value="light-on-none"<?php $mb->the_radio_state( 'light-on-none' ); ?>/> 
				  	<?php echo __( 'Light', 'theme-it' ) . ' <em>' . __( 'on', 'theme-it' ) . '</em>' . __( ' None', 'theme-it' ); ?><br />
	  			</td>
	  		</tr>
	  	</table>
	  </div><!-- .tabs1 -->
	 
	  <div class="tab2">
			<table class="form-table">
				<thead>
					<tr>
						<td scope="row" colspan="2">
							<p>
								<?php _e( 'By default, the featured thumbnail is used for the background image of the post in the Hero slider. The option to upload a custom background image for this post can be set. This will override the featured thumbnail if set. The recommended size of the Hero slider image is 940x350.', 'theme-it' ); ?>
							</p>
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="w66">
			  			<?php $mb->the_field( 'hero_background_image' ); ?>
			  			<?php $wpalchemy_media_access->setGroupName( 'n' . $mb->get_the_index() )->setInsertButtonLabel( 'Insert Background Image' ); ?>
			  			<?php echo $wpalchemy_media_access->getField( array( 'name' => $mb->get_the_name(), 'value' => $mb->get_the_value() ) ); ?>
						</td>
						<td class="w33">
							<div style="margin: 10px 0;">
								<?php echo $wpalchemy_media_access->getButton( array( 'label' => 'Add Background Image', 'class' => 'media-access-button' ) ); ?>
							</div>
						</td>
					</tr>
					<?php	if( $mb->get_the_value( 'hero_background_image' ) ) : ?>
						<tr>
							<td scope="row" colspan="2">
								<h4><?php echo __( 'Background Image Preview', 'theme-it' ); ?></h4>
								<p><?php echo '<a href="' . esc_url( $mb->get_the_value() ) . '" title="Link to Hero background preview image" target="_blank"><img src="' . esc_url( $mb->get_the_value() ) . '" alt="Hero background preview image" /></a>'; ?></p>
							</td>
						</tr>
			  	<?php endif; // end custom background image check ?>
				</tbody>
			</table>
	  </div><!-- .tab2 -->
	  
	  <div class="tab3">
	  	<h4 class="heading"><?php echo __( 'Help', 'theme-it' ); ?></h4>
	  	<table class="form-table">
	  		<thead>
	  			<tr>
	  				<td scope="row" colspan="2">
	  					<p><?php echo __( 'The "Hero" area of the theme is the large (940x350) image slider located on the home page. This area provides the option to uniquely display the posts information in the home pages "Hero" area. Various options are available to control this area which can be set here. Additionally, more General Options, such as setting a particular category, can be set in the Theme Options.', 'theme-it' ); ?></p>
						</td>
	  			</tr>
	  		</thead>
	  		<tbody>
	  			<tr>
	  				<th scope="row"><h4><?php echo __( 'Content Layout', 'theme-it' ); ?></h4></th>
	  				<td>
	  					<p><?php echo __( 'By default, the Hero area pulls in the posts Title, Excerpt, Featured Image (as background), and a More Link (linking to post). The ability to adjust how those elements are shown can be set by the option settings described below.', 'theme-it' ); ?></p>
	  					<p><?php echo '<strong>' . __( 'Position: ', 'theme-it' ) . '</strong>' . __( 'Decide to show the post content on the Left, Center, or Right side of the Hero area. If the center is a desired location, only the Content or the Media Embed (if set), can be centered. The options to do so are provided.', 'theme-it' ); ?></p>
	  					<p><?php echo '<strong>' . __( 'Visibility: ', 'theme-it' ) . '</strong>' . __( 'This area allows for different elements to be hidden. Simply check the box and the element is hidden.', 'theme-it' ); ?></p>
	  					<p><?php echo '<strong>' . __( 'Color: ', 'theme-it' ) . '</strong>' . __( 'The color option allows for a little bit of control to match the content background color to the featured image used. The option to not have a background color behind the content is provided as well.', 'theme-it' ); ?></p>
	  				</td>
	  			</tr>
	  			<tr>
	  				<th scope="row"><h4><?php echo __( 'Background Image', 'theme-it' ); ?></h4></th>
	  				<td>
	  					<p><?php echo __( 'By default, the featured thumbnail is used for the background image of the post in the Hero slider. The option to upload a custom background image for this post can be set. This will override the featured thumbnail if set. The recommended size of the Hero slider image is 940x350.', 'theme-it' ); ?></p>
	  					<p><?php echo __( 'Uploading an image is easy. By clicking on the "Upload Background Image" button, a familiar pop up box will appear. Follow the same steps you would use to upload an image. After the image is uploaded or selected from the media library, be sure to choose the correct size to insert, which in most cases will be the ', 'theme-it' ) . '<strong>' . __( '"Full Image" ', 'theme-it' ) . '</strong>' . __( 'size. Lastly, simple click the "Insert Background Image" button located next to the familiar "Use As Featured Image" link.', 'theme-it' ); ?></p>
	  					<p><?php echo __( 'In addition, to help get the images to fit this theme better, you can adjust the Full Image size options. To do this, go to ', 'theme-it' ) . '<strong>' . __( '"Settings -> Media" ', 'theme-it' ) . '</strong>' . __( 'and set the "Large size" options to 940 for both width and height. This is the max width of the Hero slider area.', 'theme-it' ); ?></p>
	  				</td>
	  			</tr>
	  		</tbody>
	  	</table>
	  </div><!-- .tab3 -->
	
	</div><!-- .metabox-tabs-div -->

</div> <!-- wpalchemy-metabox -->

<style type="text/css">
/* Group Styles */
#wpa_loop-links .wpa_group {
  cursor: move;
  overflow: hidden;
  border-bottom: 1px dotted #E3E3E3;
  background: url(<?php echo ti_ADMINURL; ?>/images/corner.png) no-repeat;
}
#wpa_loop-links .wpa_group:nth-child(odd) {
  background-color: #fff;
}
#wpa_loop-links .wpa_group:hover {
  background-color: #eaf2fb;
}
#wpa_loop-links .slide-highlight {
  height: 70px;
  border: 3px dashed #E3E3E3;
  background: #f5f5f5;
}
</style>

<script type="text/javascript">
//<![CDATA[
	
	jQuery(function($)
	{
		$("#wpa_loop-links").sortable({
			placeholder: 'slide-highlight',
			change: function() {
				$('.sort-warning').show();
			}
		});
	})
	
//]]>
</script>


