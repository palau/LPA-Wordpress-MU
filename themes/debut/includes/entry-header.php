<?php  
/**
 * This template file determines how to display entries header tag,
 * link, and meta information. Used across multiple files.
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      2.0
 */
?>

<header class="entry-header">
  
	<?php 
	/**
	 * Entry Title
	 *
	 */
	if( is_singular() ) : // Show h1 heading tag without a link if singular page ?>
	
		<h1 class="entry-title"><?php the_title(); ?></h1>
	
	<?php else : // Show h2 tag with link ?>
	
		<h2 class="entry-title">
		  
			<a href="<?php the_permalink(); ?>" title="<?php ti_the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
		
		</h2><!-- .entry-title -->
	
	<?php endif; // end singular check ?> <!-- .entry-title -->
	
	
	<?php
	/**
	 * Entry Excerpt
	 *
	 */
	 
	global $page_excerpt_mb; // Get custom global metabox info
	
	if( $page_excerpt_mb->get_the_value( 'page_excerpt' ) ) : // Check if page excerpt exists in page excerpt metabox option  ?>
	
		<mark class="entry-excerpt">
			
			<span><?php esc_html_e( $page_excerpt_mb->the_value( 'page_excerpt' ), 'theme-it' ); ?></span>
		
		</mark><!-- .entry-excerpt -->
	
	<?php endif; // end page excerpt check ?>
	
	
	<?php
	/**
	 * Entry Meta
	 *
	 */
	$of_disable_post_attributes = ti_get_option( 'disable_post_attributes' );
	
	if( $of_disable_post_attributes['posted_on'] == 0 && ! is_page() && ! is_404() ) : // Show entry meta on pages that are not a Page or 404 ?>
	
		<div class="entry-meta">
		  
			<?php ti_posted_on(); // Get who and when posted (functions.php) ?>
		
		</div><!-- .entry-meta -->
	
	<?php endif; // end Page and 404 check	?>

</header><!-- .entry-header -->
