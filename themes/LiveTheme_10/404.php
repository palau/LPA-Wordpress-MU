<?php /* this is 404.php */ ?>
<?php get_header(); ?>
	<div id="content" class="col-full">
		<div id="main" class="col-full">
			<div class="post">
				<h2 class="title">
					<?php _e('Error 404 - Page Not Found!','livetheme'); ?>
				</h2>
				<p>
					<?php _e('Whoops! Something broke. Please try again!','livetheme'); ?>
				</p>
			</div>
		</div>
	<?php get_sidebar(); ?>
	</div>
<?php get_footer(); ?>