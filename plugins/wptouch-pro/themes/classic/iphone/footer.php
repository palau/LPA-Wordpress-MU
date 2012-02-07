					</div><!-- #content -->
						
					<?php do_action( 'wptouch_body_bottom' ); ?>
							
					<?php if ( wptouch_show_switch_link() ) { ?>
						<div id="switch">
							<?php _e( "Mobile Theme", "wptouch-pro" ); ?> | <a href="<?php wptouch_the_mobile_switch_link(); ?>"><?php _e( "Switch To Regular Theme", "wptouch-pro" ); ?></a>
						</div>
					<?php } ?>
							
					<div class="<?php wptouch_footer_classes(); ?>">
						<?php wptouch_footer(); ?>
					</div>
		
					<?php do_action( 'wptouch_advertising_bottom' ); ?>
				</div> <!-- #inner-ajax -->
			</div> <!-- #outer-ajax -->
<?php if ( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] == '' ) { ?>			
			<?php if ( show_webapp_notice() ) { ?>
				<div id="web-app-overlay">
					<a href="#" id="close-wa-overlay">X</a>
					<img src="<?php  echo wptouch_get_site_menu_icon( WPTOUCH_ICON_BOOKMARK ); ?>" alt="bookmark-icon" />
					<h2><?php wptouch_bloginfo( 'site_title' ); ?> <?php _e( "is now web-app enabled!", "wptouch-pro" ); ?></h2>
					<p><?php _e( "Save", "wptouch-pro" ); ?> <?php wptouch_bloginfo( 'site_title' ); ?> <?php _e( "as a web-app on your Home Screen.", "wptouch-pro" ); ?></p>
					<p><?php _e( "Tap + then Add to Home Screen.", "wptouch-pro" ); ?></p>
				</div>
			<?php } ?>
			<!-- <?php echo WPTOUCH_VERSION; ?> -->
		</body>
	</html>
<?php } ?>