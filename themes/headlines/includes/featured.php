
<div id="loopedSlider" class="box">

    <?php if ( get_option('woo_featured_banner') == "true" ) { ?><div class="featured-banner"><?php _e('Current', 'woothemes'); ?></div><?php } ?>
    
    <?php
		$featposts = get_option('woo_featured_entries'); // Number of featured entries to be shown
		$GLOBALS[feat_tags_array] = explode(',',get_option('woo_featured_tags')); // Tags to be shown
        foreach ($GLOBALS[feat_tags_array] as $tags){ 
			$tag = get_term_by( 'name', trim($tags), 'post_tag', 'ARRAY_A' );
			if ( $tag['term_id'] > 0 )
				$tag_array[] = $tag['term_id'];
		}
    ?>
	<?php $saved = $wp_query; query_posts(array('tag__in' => $tag_array, 'showposts' => $featposts)); ?>
    <?php if (have_posts()) : $count = 0; ?>

	<div class="featured-nav">
        <ul class="pagination">
			<?php while (have_posts()) : the_post();  $GLOBALS['shownposts'][$count] = $post->ID; $count++; ?>
            <li>
            	<a href="#">
					<?php woo_get_image('image',48,48,'thumbnail',90,$post->ID,'img'); ?>                
                 <!--    <em class="cufon"></em> -->
	                 <h4 class="meta"><?php the_title(); ?></h4>
                    <span class="meta"><?php // echo woo_excerpt( get_the_excerpt(), '80'); ?><?php the_author(); ?></span>
                </a>
                <div style="clear:both"></div>
            </li>
          	<?php endwhile; ?>      
        </ul>      
    </div> 
        
	<?php endif; $wp_query = $saved; ?>      

	<?php $saved = $wp_query; query_posts(array('tag__in' => $tag_array, 'showposts' => $featposts)); ?>
	<?php if (have_posts()) : $count = 0; ?>

    <div class="container">
    
        <div class="slides">
        
            <?php while (have_posts()) : the_post(); $count++; ?>
            
            <div id="slide-<?php echo $count; ?>" class="slide">                

                <div class="post" style="margin:0; padding:0;">
                   	<div class="featuredPoster"><?php woo_get_image('img_poster','640', '360'); ?></div>
                </div><!-- /.post -->
                
                <div class="post-bottom">
                    <div class="fl"><span class="cat"><?php the_category(', ') ?></span></div>
                   <!--  <div class="fr"><?php the_tags('<span class="tags">', ', ', '</span>'); ?></div>  -->
                    <div class="fix"></div>                       
                </div>
        
            </div>
            
		<?php endwhile; ?> 

        </div><!-- /.slides -->        
    </div><!-- /.container -->
	<div class="fix"></div>
    
    <?php endif; $wp_query = $saved; ?> 
    <?php update_option("woo_exclude", $GLOBALS[shownposts]); ?>
        
</div><!-- /#loopedSlider -->
