<div id="page-nav">
    <div class="col-full">
		<?php
		if ( function_exists('has_nav_menu') && has_nav_menu('primary-menu') ) {
			wp_nav_menu( array( 'depth' => 6, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'nav', 'menu_class' => 'fl', 'theme_location' => 'primary-menu' ) );
		} else {
		?>
        <ul id="nav" class="fl">
        
            <li><a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/ico-home.png" class="ico-home" alt="<?php _e('Home', 'woothemes'); ?>" /></a></li>
			<?php 
        	if ( get_option('woo_custom_nav_menu') == 'true' && function_exists('woo_custom_navigation_output') ) {
			
			woo_custom_navigation_output('name=Woo Menu 1');
			
			} else { ?>
        
            <?php wp_list_pages('sort_column=menu_order&depth=4&title_li=&exclude='.get_option('woo_nav_exclude')); ?>
            
			<?php }	?>
            
            
        </ul><!-- /#nav1 -->
        <?php } ?>
        <ul class="rss fr">
            <?php if ( get_option('woo_feedburner_id') ) {?>
            <li class="last"><a href="<?php echo get_option('woo_feedburner_id'); ?>" target="_blank"><?php _e('Email', 'woothemes') ?></a></li>
            <?php } ?>
            <li><a href="<?php if ( get_option('woo_feedburner_url') <> "" ) { echo get_option('woo_feedburner_url'); } else { echo get_bloginfo_rss('rss2_url'); } ?>"><?php _e('Posts', 'woothemes') ?></a></li>
        </ul><!-- /.rss -->
    </div><!-- /.col-full -->
</div><!-- /#page-nav -->
