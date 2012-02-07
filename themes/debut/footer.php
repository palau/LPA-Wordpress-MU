<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main-container div and all content after
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      1.0
 */
?>

	<?php 
	/**
	 * Footbar
	 *
	 * Show footbar container if one of the footbar's has widgets
	 */
	if( is_active_sidebar( 'footbar-column-1' ) || is_active_sidebar( 'footbar-column-2' ) || is_active_sidebar( 'footbar-column-3' ) ) :	?>

		<section id="footbar-container" role="complementary">
		
			<?php get_sidebar( 'footer' ); // sidebar-footer.php ?>
		
		</section><!-- #footbar-container -->

	<?php	endif; // end sidebar check	?>
	
	<div class="clearfix"><!-- nothing to see here --></div>

</div><!-- #main-container -->


<div id="footer-container">
		
	<footer id="footer">
		<?php 
		/**
		 * Social Networking Icons
		 *
		 */
		
		// Social Bartender Plugin Support
		if( function_exists( 'social_bartender' ) ) : ?>
			
			<ul id="networking" class="social-bartender">
				<li class="text"><?php _e( 'Connect with us: ', 'theme-it' ); ?></li>
				<?php social_bartender( '<li>', '</li>' ); ?>
			</ul><!-- #networking.social-bartender -->
			
		<?php 
		// Use Theme Options Settings
		else : ?>
		
			<ul id="networking">
			
				<li class="text"><?php _e( 'Connect with us: ', 'theme-it' ); ?></li>
								
				<?php
				$sites = array(
					'twitter'   => array( 'label' => 'Twitter',   'host' => 'twitter.com' ),
					'facebook'  => array( 'label' => 'Facebook',  'host' => 'facebook.com' ),
					'flickr'    => array( 'label' => 'Flickr',    'host' => 'flickr.com' ),
					'vimeo'     => array( 'label' => 'Vimeo',     'host' => 'vimeo.com' ),
					'youtube'   => array( 'label' => 'YouTube',   'host' => 'youtube.com' ),
					'delicious' => array( 'label' => 'Delicious', 'host' => 'delicous.com' ),
					'lastfm'    => array( 'label' => 'Last.fm',   'host' => 'lastfm.com' ),
					'rss'       => array( 'label' => 'RSS',       'host' => 'feeds.feedburner.com' )
				);												 

				// Loop through $sites
				foreach( $sites as $social => $site ) { ?>
				
					<?php 
					// Get theme option, false if blank 
					$username = ti_get_option( 'social_' .  $social );
					
					// Continue if username theme option is provided
					if( ! $username ) 
						continue;
					
					// Check for RSS is up to bat in loop and set its value accordingly					
					if( 'rss' === $social ) {
						if( ti_get_option( 'feedburner_url' ) ) {
							$username = ti_get_option( 'feedburner_url' );
						} else {
							$rss2_url = get_bloginfo( 'rss2_url' );
						}
					}
					
					// Create some variables
					$class = $social;
					$url = ( isset( $rss2_url ) ) ? $rss2_url : 'http://' . $site['host'] . '/' . $username;
					$title = $site['label']
					?>
					
					<li class="<?php echo esc_attr( $class ) ?> ir">
					    
					    <a href="<?php echo esc_url( $url ) ?>" class="tooltip" title="<?php esc_attr_e( 'Link to ', 'theme-it' ) . esc_attr_e( $title, 'theme-it' ); ?>" target="_blank"><?php _e( $title, 'theme-it' ); ?></a>
					    
					</li>
								
				<?php } // End $sites foreach loop ?>
			
			</ul><!-- .social-networking -->
			
		<?php endif; // end social bartender plugin check ?>
		
		<ul id="role-credits" role="contentinfo">
			<?php
			/**
			 * Copyright
			 */
			$of_footer_copyright_default = 'Your Company Name - All Rights Reserved';
			$of_footer_copyright = stripslashes( ti_get_option( 'footer_copyright', $of_footer_copyright_default ) ); ?>
			
			<li class="copyright"><?php echo __( '&copy; ', 'theme-it' ) . '<time datetime="' . date( 'Y-m-d' ) . '">'  . date( 'Y ' ) . '</time>' . esc_html__( $of_footer_copyright, 'theme-it' ); ?></li>
		  
			<?php 
			/**
			 * Footer Text
			 */
			$of_footer_text_default = __( 'Powered by ', 'theme-it' ) . '<a href="http://www.wordpress.org" title="WordPress.org">' . __( 'WordPress', 'theme-it' ) . '</a>';
			$of_footer_text = stripslashes( ti_get_option( 'footer_text', $of_footer_text_default ) ); ?>
		  
			<li class="footer-text"><?php echo $of_footer_text ?></li>
		
		</ul><!-- #role-credits -->
		
	</footer><!-- #footer -->

</div><!-- #footer-container -->
	

<?php wp_footer(); ?>

</body>
</html>