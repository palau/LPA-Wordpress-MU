<?php 
get_header(); ?>
       
    <div id="content" class="col-full">
		<div id="main" class="col-left">
	            
            <?php if (have_posts()) : $count = 0; ?>
            <?php while (have_posts()) : the_post(); $count++; ?>
                                                                        
                <div class="box">
                    <div class="post">
    
                        <h2>List of authors:</h2>
                       
                        <?php $authors = getUsersByRole('author'); ?>
                        <?php foreach($authors as $author): 
                            $user_info = get_userdata($author);
                        ?>
                          <h2><a href="/archives/author/<?=$user_info->user_nicename?>"><?=$user_info->display_name?></a></h2>
                          <?php echo wpautop($user_info->description, false)?>
                        <?php endforeach; ?>
                    </div><!-- /.post -->
                                        
                </div><!-- /.box -->
                
               
                                                    
			<?php endwhile; else: ?>
                <div class="box">
                    <div class="post">
                        <p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
                    </div><!-- /.post -->            
				</div>                     
            <?php endif; ?>  
        
		</div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>