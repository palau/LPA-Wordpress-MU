<?php /* This is seotitles.php

The following are perfectly formatted title tags for flawless SEO performance.
In other words, you won't need any bloated or slow-loading plugin!

We have captured every single type of page that you may use for your blog:

  * Home Page | Blog Name | Blog Description
  * Search Results | Search Results for search terms | 11 Articles | Blog Name
  * 404 (Error) Page  | Blog Name | 404 Nothing Found
  * Author Archives | Blog Name | Author Archives
  * Single Post | Post Name | Category Name | Blog Name
  * Page | Page Name | Blog Name
  * Category Page | Category Name | Blog Name
  * Monthly Archive | Blog Name | Archive | Month, Year
  * Day Archive | Blog Name | Archive | Month Day, Year
  * Tag | Blog Name | Tag Archive | Tag

You can, of course, make modifications if you would like, but be careful!

*/ ?>

<title>
	<?php if (is_home()) { bloginfo('name'); ?> | <?php bloginfo('description'); } ?>
	<?php if (is_search()) { _e('Search Results for', 'standardtheme'); ?> <?php $allsearch = &new WP_Query("s=$s&showposts=-1"); $key = wp_specialchars($s, 1); $count = $allsearch->post_count; echo $key; echo ' &mdash; '; echo $count . ' '; _e('Articles', 'standardtheme'); wp_reset_query(); } ?>
	<?php if (is_404()) { bloginfo('name'); ?> | <?php _e('404 Nothing Found', 'standardtheme'); } ?>
	<?php if (is_author()) { bloginfo('name'); ?> | <?php _e('Author Archives', 'standardtheme'); } ?>
	<?php if (is_single()) { the_title(); ?> | <?php bloginfo('name'); } ?>
	<?php if (is_page()) { bloginfo('name'); ?> | <?php the_title(''); } ?>
	<?php if (is_category()) { single_cat_title(); ?> | <?php bloginfo('name'); } ?>
	<?php if (is_month()) { bloginfo('name'); ?> | <?php _e('Archive', 'standardtheme'); ?> | <?php the_time('F, Y'); } ?>
	<?php if (is_day()) { bloginfo('name'); ?> | <?php _e('Archive', 'standardtheme'); ?> | <?php the_time('F j, Y'); } ?>
	<?php if (function_exists('is_tag')) { if ( is_tag() ) { bloginfo('name'); ?> | <?php _e('Tag Archive', 'standardtheme'); ?> | <?php single_tag_title("", true); } } ?>
</title>
