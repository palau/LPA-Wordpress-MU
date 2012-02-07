<?php /* This is the Loop template for aside post types - included in index.php, archive.php */ ?>
<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
	<?php edit_post_link('edit','<span class="the_edit_link">','</span>') ?>
	<div id="content-<?php the_ID(); ?>" class="entry">
		<span class="thumbnail">
			<a class="fade" href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
				<?php standard_post_thumbnails(is_page()); ?>
			</a>
		</span>
		<div class="content">
			<?php the_content(__('Continue Reading...','standardtheme')); ?>
		</div>
		<div class="clear"></div>
	</div>
	<p class="post-meta">
		<span class="the_post_permalink">
			<a class="fade" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>">
				<img src="<?php bloginfo('template_directory'); ?>/images/icn_permalink.png" alt="link" /></a>
		</span>
	</p>
</div>