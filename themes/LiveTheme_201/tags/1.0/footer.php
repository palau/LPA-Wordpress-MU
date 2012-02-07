<?php /* this is footer.php */ ?>
	<div id="footer" class="col-full">
		<div id="buckets">
			<?php 
				dynamic_sidebar('footer-ad1'); 
				dynamic_sidebar('footer-ad2'); 
				dynamic_sidebar('footer-ad3'); 
			?>
			<div class="clear"></div>
		</div>
		<div class="navigation-container col-full">
			<?php if(standard_show_footer_navigation()): ?>
				<?php if(standard_use_wp3_menus()):
					standard_wp3_navigation_menu(true);
				else: ?>
					<ul class="nav fl">						
						<li class="b <?php is_page() ? "page_item" : "page_item current_page_item"; ?>">
							<a href="<?php bloginfo('url'); ?>">
								<?php _e("Home", "livetheme"); ?>
							</a>
						</li>
						<?php standard_navigation_menu(true) ?>
					</ul>
				<?php endif; ?>
			<?php endif; ?>
			<div id="credit" class="col-right">
				<?php standard_credit(); ?>
			</div>
		</div>
	</div>
</div>
<?php wp_footer(); ?>
<?php standard_analytics(false); ?>
</body>
</html>