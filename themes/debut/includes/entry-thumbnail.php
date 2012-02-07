<?php  
/**
 * This template file determines how to display the post thumbnail,
 * video, or gallery. Used across multiple files.
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      2.0
 */

// Used to detect page template type, in which place the $is_page var is set
global $is_page;

// Get theme options
$of_disable_post_attributes = ti_get_option( 'disable_post_attributes', 0 );

// Returns an array with a href and class. The link and class are generated
// depending upon if "Instant View" is enabled in theme options
$link = ti_get_instant_view_link();

// Set post thumbnail
$the_post_thumbnail = '';
if ( has_post_thumbnail() ) {
	if ( isset( $is_page ) && $is_page == 'home' || $is_page == 'template-post-gallery' )
	  $the_post_thumbnail = get_the_post_thumbnail( $post->ID, 'thumbnail-wide' );
	
	elseif ( isset( $is_page ) && $is_page == 'template-full' )
	  $the_post_thumbnail = get_the_post_thumbnail( $post->ID, 'full-image' );
	
	elseif( is_singular() )
		if ( ! ti_has_sidebar() )
	  	$the_post_thumbnail = get_the_post_thumbnail( $post->ID, 'full-image' );
	  else
	  	$the_post_thumbnail = get_the_post_thumbnail( $post->ID, 'singular-image' );
	else
	  $the_post_thumbnail = get_the_post_thumbnail( $post->ID, 'thumbnail-wide' ); 
}

?>

 
<?php 
/**
 * Media Embed Setup
 *
 * Check for media embed option. If the page is singular,
 * check to see that the media embed has not been disabled
 * via the Theme Options.
 *
 * If not singular, check to see if the post has a thumbnail.
 * If the post does in fact have a thumbnail, add a link to
 * the media embed. Depending upon the Theme Options, the media
 * embed may link to the post or display in a modal box. Those
 * options were determined above.
 */
if ( has_media_embed() ) : ?>
	
	<?php if ( is_singular() ) : ?>
	
		<?php if ( $of_disable_post_attributes['media_embed'] == 0 ) : ?>
		
			<figure class="entry-thumbnail">
			
				<?php
				/* Determine page type and set video size */
				if ( isset( $is_page ) && $is_page == 'template-full' ) :
				  $video_width = 840;
				  $video_height = 473;
				elseif ( isset( $is_page ) && $is_page == 'template-centered' ) :
				  $video_width = 530;
				  $video_height = 298;
				elseif ( is_page() && ! ti_has_sidebar() ) :
				  $video_width = 840;
				  $video_height = 473;
				elseif ( is_single() && ! ti_has_sidebar() ) :
				  $video_width = 840;
				  $video_height = 473;
				else :
				  $video_width = 530;
				  $video_height = 298;
				endif;
				?>
				
				<?php 
				// action, $post_id, $width, $height, $allow_autoplay = true, $echo =  true
				do_action( 'get_media', $post->ID, absint( $video_width ), absint( $video_height ) );	?>
			
			</figure><!-- .entry-thumbnail -->
			
		<?php endif; ?>
	
	<?php elseif ( $the_post_thumbnail ) : ?>
		
		<figure class="entry-thumbnail">
		
			<div class="entry-media">
			
				<a href="<?php echo esc_url( $link['href'] ) ?>" class="<?php echo esc_attr( $link['class'] ) ?>" title="<?php ti_the_title_attribute(); ?>"><!-- nothing to see here --></a>
			  
				<?php echo $the_post_thumbnail; ?>
			  
			</div><!-- .entry-media -->
		
		</figure><!-- .entry-thumbnail -->
	
	<?php endif; ?>

<?php 
/**
 * Post Thumbnail Setup
 * 
 * Check for featured post thumbnail. If the page is singular
 * check to see that the post thumbnail has not been disabled
 * via the Theme Options.
 *
 * If not singular, make the post thumbnail a link to the post.
 */
elseif ( $the_post_thumbnail ) : ?>
		
	<?php if ( is_singular() ) : ?>
	
		<?php if ( $of_disable_post_attributes['post_thumbnail'] == 0 ) : ?>
	
			<figure class="entry-thumbnail">
	  			
	  			<?php echo $the_post_thumbnail ?>
	  		
			</figure>
	  	
		<?php endif; ?>
	
	<?php else : ?>
	  
		<figure class="entry-thumbnail">
	  
			<a href="<?php echo esc_url( $link['href'] ) ?>" class="<?php echo esc_attr( $link['class'] ) ?> " title="<?php ti_the_title_attribute(); ?>">
	  	
				<?php echo $the_post_thumbnail ?>
	  	
			</a>
	  	
		</figure>
	
	<?php endif; ?>
		
<?php endif; ?>
