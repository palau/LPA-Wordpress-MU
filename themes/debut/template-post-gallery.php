<?php
/**
 * Template Name: Custom Post Gallery
 *
 * This page template is used to show posts for any given page
 * in a gallery format. Options are set via a custom metabox
 * to determine which categories should be included.
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      2.6
 */
 
/**
 * Page Type
 *
 * Used in includes/entry-thumbnail.php and functions.php
 * ti_has_sidebar() check.
 */
$is_page = 'template-post-gallery';

get_header(); ?>

<?php 
/* Get custom post page metabox options (functions/theme-metabox.php) */
global $post_page_mb;
$post_page_mb->the_meta(); 
$enable_post_page_title   = $post_page_mb->get_the_value( 'enable_post_page_title' );
$enable_post_page_content = $post_page_mb->get_the_value( 'enable_post_page_content' );

/* Get page excerpt metabox options (functions/theme-metabox.php) */
$page_excerpt_mb->the_meta();
$page_excerpt = $page_excerpt_mb->get_the_value( 'page_excerpt' ); ?>

<section id="main">

	<section id="entry-container"> 
		
		<?php if ( $enable_post_page_title || $enable_post_page_content ) :  the_post(); ?>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry page-header' ) ?>>
				
				<?php 
				/**
				 * Entry Title & Excerpt
				 *
				 */
				if ( $enable_post_page_title ) : ?>
				
					<header class="entry-header">
				  	
						<h1 class="entry-title"><?php the_title(); ?></h1>
				  	
						<?php if( $page_excerpt ) : ?>
				  	
						  <mark class="entry-excerpt"><span><?php echo $page_excerpt; ?></span></mark>
				  	
						<?php endif; ?>
				  
					</header><!-- .entry-header -->
		  	
				<?php endif; ?>
		  	
		  	
				<?php 
				/**
				 * Entry Content
				 *
				 */
				if ( $enable_post_page_content ) : ?>
		  	  
					<div class="entry-content">
		  	  
						<?php the_content(); ?>  
		  	  
					</div><!-- entry-content -->
				
				<?php endif; ?>
			
			</article><!-- #post-## -->
		
		<?php endif; // end enable post title and content check ?>
		
	</section><!-- #entry-container -->
		
</section><!-- #main -->
		
<?php
/**
 * Entry Posts Setup
 *
 */
// Check for pages
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

if ( $paged > 1 )
  $args['paged'] = $paged;

$post_page_cats = $post_page_mb->get_the_value( 'post_page_cats' );

// Create query based on metabox options
$args = array( 
    'cat'            => ( $post_page_cats ) ? implode(",", $post_page_cats) : null,
    'posts_per_page' => $post_page_mb->get_the_value( 'post_page_number' ),
    'paged'          => $paged
);

query_posts( $args ); ?>

<?php
/**
 * The Loop
 *
 */
get_template_part( 'content', 'featured' ); ?>


<?php	wp_reset_query(); // reset the query for next use ?>
		

<?php get_footer(); ?>