<?php /* This is the default link Loop - included in index.php, archive.php */ ?>

<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
	<?php edit_post_link('edit','<span class="the_edit_link">','</span>') ?>
	<?php if(is_single() || is_page()) { ?>
		<h1 class="title">
			<a href="<?php the_title(); ?>" rel="bookmark" title="<?php the_title(); ?>">
				<?php echo get_the_content(''); ?>
			</a>
		</h1>
	<?php } else { ?>
		<h2 class="title">
			<a href="<?php the_title(); ?>" rel="bookmark" title="<?php the_title(); ?>">
				<?php echo get_the_content(''); ?>
			</a>
		</h2>
	<?php } // end if/else ?>
	<p class="post-meta">
		<span class="the_post_permalink">
			<a class="fade" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>">
				<img src="<?php bloginfo('template_directory'); ?>/images/icn_permalink.png" alt="link" /></a>
		</span>
	</p>	
</div>