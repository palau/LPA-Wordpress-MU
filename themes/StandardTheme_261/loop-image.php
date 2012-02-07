<?php /* This is the default image Loop - included in index.php, archive.php */ ?>
<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
	<?php edit_post_link('edit','<span class="the_edit_link">','</span>') ?>
	<div id="content-<?php the_ID(); ?>" class="entry">
		<div class="content">
			<span class="thumbnail">
				<a class="fade" href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
					<?php standard_post_thumbnails(is_page()); ?>
				</a>
			</span>
			<?php the_content(__('Continue Reading...','standardtheme')); ?>
		</div>
		<div class="clear"></div>
			<?php if(is_single() || is_page()) { ?>
				<h1 class="title">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
						<?php the_title(); ?>
					</a>
				</h1>
			<?php } else { ?>
				<h2 class="title">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
						<?php the_title(); ?>
					</a>
				</h2>
			<?php } // end if/else ?>
			<p class="post-meta">
				<span class="the_post_permalink">
					<a class="fade" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>">
						<img src="<?php bloginfo('template_directory'); ?>/images/icn_permalink.png" alt="link" /></a>
				</span>
				<span class="the_time">
					<?php the_time('F j, Y'); ?>
				</span> <?php _e('in','standardtheme'); ?> 
				<span class="the_category">
					<?php the_category(', '); ?>
				</span> <?php _e('with','standardtheme'); ?> 
				<span class="the_comment_link">
					<?php comments_popup_link(__('0 Comments','standardtheme'), __('1 Comment','standardtheme'), __('% Comments','standardtheme')); ?>
				</span>
			</p>
		<div class="clear"></div>
	</div>
</div>