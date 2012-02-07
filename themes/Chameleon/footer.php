		<div id="footer">
			<div id="footer-content" class="clearfix">
				<div id="footer-widgets" class="clearfix">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
					<?php endif; ?>
				</div> <!-- end #footer-widgets -->
				<p id="copyright"><?php _e('Designed by ','Chameleon'); ?> <a href="http://themecrunch.blogspot.com/2011/05/chameleon.html" title="Premium WordPress Themes">Elegant WordPress Themes</a> | <?php _e('Powered by ','Chameleon'); ?> WordPress</p>
			</div> <!-- end #footer-content -->
		</div> <!-- end #footer -->
	</div> <!-- end #container -->
	 <?php wp_footer(); ?>

	<?php include(TEMPLATEPATH . '/includes/scripts.php'); ?>
</body>
</html>