<?php 
/* 
Template Name: Directory w. Links
*/
?>

<?php the_post(); ?>
<?php get_header(); ?>

<?php //include(TEMPLATEPATH . '/includes/breadcrumbs.php'); ?>
<?php include(TEMPLATEPATH . '/includes/top_info.php'); ?>

<div id="content" class="clearfix fullwidth">
	<div id="left-area">
		<div class="entry post clearfix">							
			<?php if (get_option('chameleon_page_thumbnails') == 'on') { ?>
				<?php 
					$thumb = '';
					$width = 186;
					$height = 186;
					$classtext = 'post-thumb';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Entry');
					$thumb = $thumbnail["thumb"];
				?>
				
				<?php if($thumb <> '') { ?>
					<div class="post-thumbnail">
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
						<span class="post-overlay"></span>
					</div> 	<!-- end .post-thumbnail -->
				<?php } ?>
			<?php } ?>
			
			<?php the_content(); ?>
			
			<?php
if (is_page('get-involved')) {
wp_list_bookmarks('show_description=1&between=<br />');
}
?>
			<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages','Chameleon').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php edit_post_link(__('Edit this page','Chameleon')); ?>			
		</div> <!-- end .entry -->
					
		<?php if (get_option('chameleon_show_pagescomments') == 'on') comments_template('', true); ?>
	</div> 	<!-- end #left-area -->
</div> <!-- end #content -->
		
<?php get_footer(); ?>

