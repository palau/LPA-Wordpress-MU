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
			<?php standard_footer_menu(); ?>
			<div id="credit" class="col-right">
				<?php standard_credit(); ?>
			</div>
		</div>
	</div>
</div>
<?php wp_footer(); ?>
<?php standard_analytics(false); ?>
<div id="event-poll" class="polling"><?php echo standard_is_offline(); ?></div>
<div id="event-response" class="polling"></div>
</body>
</html>