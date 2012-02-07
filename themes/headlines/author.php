<?php 
if(isset($_GET['author_name'])) :
  $curauth = get_user_by('slug', $author_name);
else :
    $curauth = get_userdata(intval($author));
endif;
?>
<?php get_header(); ?>
       
    <div id="content" class="col-full">
		<div id="main" class="col-left">
            
		<?php if (have_posts()) : $count = 0; ?>
        
            
            <div class="fix"></div>
            
            <!-- modded author list -->
        <div class="box">
			<div class="post">
			<div class="entry">
				<h2 class="title"><?php echo $curauth->display_name; ?></h2>
				<span class="author_photo" style="float:left; margin: 5px 20px 5px 0px;"><?php echo get_avatar( $curauth->ID, '150' ); ?></span>
				<p><?php echo $curauth->bio_long; // was ->description ?> <br style="clear:both;" /></p>
				<?php if ($curauth->twitter){ ?>
					<p><a href="<?php echo $curauth->twitter; ?>" title="Follow <?php echo $curauth->display_name; ?> on Twitter"><img style="border:none; padding:0; margin:0 10px 0 0;" src="http://blogs.palau.org/wp-content/plugins/social-media-widget/images/default/32/twitter.png" alt="twitter" />Follow <?php echo $curauth->display_name; ?> on Twitter</a></p>
					<?php }?>
				<?php if ($curauth->facebook){ ?>
					<p><a href="<?php echo $curauth->facebook; ?>" title="Follow <?php echo $curauth->display_name; ?> on Facebook"><img style="border:none; padding:0; margin:0 10px 0 0;" src="http://blogs.palau.org/wp-content/plugins/social-media-widget/images/default/32/facebook.png" alt="facebook" />Connect with <?php echo $curauth->display_name; ?> on Facebook</a></p>
					<?php }?>
			</div> <!-- /.entry -->
		</div><!-- /.post -->
		</div><!-- /.box -->
		<div class="post" style="border:none"><h2 class="title" style="margin:0; padding-top: 0; padding-bottom: 15px">Recent Posts by <?php echo $curauth->display_name; ?></h2>
</div>
        <?php while (have_posts()) : the_post(); $count++; ?>
                                                                    
            <div class="box">
                    <div class="post">
                        
						<?php woo_get_image('image',$GLOBALS['220'],$GLOBALS['220'],'thumbnail '.$GLOBALS['align']); 
						/*
						if (!woo_get_embed('embed','590','420')) 
							woo_get_image('image',$GLOBALS['thumb_width'],$GLOBALS['thumb_height'],'thumbnail '.$GLOBALS['align']); 
						else
							echo woo_get_embed('embed','590','420');
						*/
						?> 
                        <h3 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                        <p class="post-meta">
							<img src="<?php bloginfo('template_directory'); ?>/images/ico-time.png" alt="" /><?php the_time($GLOBALS['woodate']); ?>
                            <span class="comments"><img src="<?php bloginfo('template_directory'); ?>/images/ico-comment.png" alt="" /><?php comments_popup_link(__('0 Comments', 'woothemes'), __('1 Comment', 'woothemes'), __('% Comments', 'woothemes')); ?></span>
                        </p>
                        <div class="entry">
                            
                            <?php if ( get_option('woo_archive_content') == "true" ) { ?>
							<?php the_content(__('Read more...', 'woothemes')); ?>
                            <?php } else { ?>
							<?php the_excerpt(); ?><span class="read-more" style="display:inline"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="btn">
							<?php if (woo_get_embed())
								$readLabel = 'Watch video';
							else
								$readLabel='Read more...';
							 _e($readLabel, 'woothemes'); ?></a></span>
                            <?php } ?>
                            
                            
                            
                        </div>
                        <div class="fix"></div>
                    </div><!-- /.post -->
                                                        
                    <div class="post-bottom">
                        <div class="fl"><span class="cat"><?php the_category(', ') ?></span></div>
                        <div class="fr"><?php the_tags('<span class="tags">', ', ', '</span>'); ?></div> 
                        <div class="fix"></div>                       
                    </div>
            </div>        
                                                    
            <?php endwhile; else: ?>
            <div class="box">
                <div class="post">
                    <p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
                </div><!-- /.post -->
            </div>        
            <?php endif; ?>  

            <div class="more_entries">
                <?php if (function_exists('wp_pagenavi')) wp_pagenavi(); else { ?>
                <div class="fl"><?php previous_posts_link(__('Newer Entries', 'woothemes')) ?></div>
                <div class="fr"><?php next_posts_link(__('Older Entries', 'woothemes')) ?></div>
                <br class="fix" />
                <?php } ?> 
            </div>		
                
		</div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>