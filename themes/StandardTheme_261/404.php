<?php /* this is 404.php */ ?>
<?php get_header(); ?>
	<div id="content" class="col-full">
		<div id="main" class="col-<?php echo main_content_orientation(); ?>">
			<div class="post">
				<h2 class="title">
					<?php _e('Error 404 - Page Not Found','standardtheme'); ?>
				</h2>
				<p>
					<?php _e('Something broke - please try again!','standardtheme'); ?>
				</p>
			</div>
		</div>
	<?php get_sidebar(); ?>
	</div>
<?php get_footer(); ?>