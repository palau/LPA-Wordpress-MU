<?php
// The main icon picker for the menu items
?>

<?php require_once( WPTOUCH_ADMIN_DIR . '/template-tags/icons.php' ); ?>

<div id="wptouch-icon-area">
	<div class="round-6" id="wptouch-icon-packs">
		<div id="icon-select">
			<label for="active-icon-set"><?php _e( "Active Icon Set: ", "wptouch-pro" ); ?></label>
			<select name="active-icon-set" id="active-icon-set">
			<?php while ( wptouch_have_icon_packs() ) { ?>
				<?php wptouch_the_icon_pack(); ?>
				<option value="<?php wptouch_the_icon_pack_name(); ?>"><?php wptouch_the_icon_pack_name(); ?></option>	
			<?php } ?>
			</select>
		</div>
		
		<div id="wptouch-icon-list"></div>		
	</div>
	
	<div class="round-6" id="wptouch-icon-menu">
		<h4><?php _e( 'Menu Pages &amp; Associated Icons', 'wptouch-pro' ); ?></h4>
	
		<div class="menu-meta">			
			<h6><?php _e( 'Site, Theme &amp; Bookmark Icons', 'wptouch-pro' ); ?></h6>
		
			<div class="menu-actions">
				<a id="reset-menu-all" href="/"><?php _e( 'Reset All Pages & Icons', 'wptouch-pro' ); ?></a>
			</div>			
			
			<div class="clearer"></div>
		</div>	
	
		<ul class="icon-menu">
			<?php while ( wptouch_has_site_icons() ) { ?>
				<?php wptouch_the_site_icon(); ?>
				
				<li class="<?php wptouch_the_site_icon_classes(); ?>">
					<div class="icon-drop-target<?php if ( wptouch_site_icon_has_dark_bg() ) echo ' dark'; ?>" title="<?php wptouch_the_site_icon_id(); ?>">
						<img src="<?php wptouch_the_site_icon_icon(); ?>" alt="" /> 
					</div>
					
					<span class="title"><?php wptouch_the_site_icon_name(); ?></span>
					
					<div class="clearer"></div>
				</li>
			<?php } ?>
		</ul>
		
		<div id="remove-icon-area">
			<?php _e( "Drag an icon here to remove it from the menu", "wptouch-pro" ); ?>
		</div>
		
		<div class="menu-meta">			
			<h6><?php _e( 'WordPress Pages', 'wptouch-pro' ); ?></h6>
			<div class="menu-actions">
				<?php _e( "Show / Hide", "wptouch-pro" ); ?>: <a href="#" id="pages-check-all"><?php _e( "Check All", "wptouch-pro" ); ?></a> | <a href="#" id="pages-check-none"><?php _e( "None", "wptouch-pro" ); ?></a>
			</div>		
			
			<div class="clearer"></div>
		</div>
		
		<?php wptouch_show_menu( WPTOUCH_ADMIN_DIR . '/html/icon-menu/main.php' ); ?>
		<input type="hidden" name="hidden-menu-items" id="hidden-menu-items" value="" />
	</div>
	
	<div class="clearer"></div>
</div>