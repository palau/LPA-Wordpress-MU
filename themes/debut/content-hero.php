<?php
/**
 * The loop for displaying hero posts on home page.
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      2.0
 */

// Get custom global metabox info
global $hero_mb;

// Set query arguments
$hero_args = array(
	'cat'            => ti_get_option( 'hero_category', null ),
	'posts_per_page' => ti_get_option( 'hero_posts_per_page', null ),
	'meta_query'     => array ( 
		array (
			'key' => ( ti_get_option( 'hero_filter_thumbs', 0 ) == 1 ) ? '_thumbnail_id' : null
  	)
  )
);

$hero_query = new WP_Query( $hero_args ); // Create new query


/**
 * The Loop
 *
 */
if ( $hero_query->have_posts() ) : ?>

	<section id="hero" role="complementary">
	
		<div class="inner">
		
			<?php while ( $hero_query->have_posts() ) : $hero_query->the_post(); ?>
		  
				<?php
				// Get and set hero metabox options
				$hero_mb->the_meta();
				$hero = array(
					'position'  => $hero_mb->get_the_value( 'position' ),
					'color'     => $hero_mb->get_the_value( 'color' ),
					'title'     => $hero_mb->get_the_value( 'hero_title' ),
					'content'   => $hero_mb->get_the_value( 'hero_content' ),
					'more_link' => $hero_mb->get_the_value( 'hero_more_link' ),
					'media'     => $hero_mb->get_the_value( 'hero_media' ),
					'bg_image'  => $hero_mb->get_the_value( 'hero_background_image' )
				);
				
				$class_args = array(
					'entry',
					'slide-container',
					( $hero['position'] ) ? $hero['position'] : 'alignleft',
					( $hero['color'] ) ? $hero['color'] : 'dark-on-light'
				);
				
				$post_class = implode( ' ', $class_args );
				
				
				// Image: Set post style
				$post_style = '';
				if ( $hero['bg_image'] ) :
					$post_style = 'style="background-image: url(' . esc_url( $hero['bg_image'] ) . '); background-repeat: no-repeat;"';
				elseif ( has_post_thumbnail() ) :
					$attachment_image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'hero-image' ); // Get post thumbnail full image source
					$post_style = 'style="background-image: url(' . esc_url( $attachment_image_src[0] ) . '); background-repeat: no-repeat;"';
				endif;

				?>
			  
				<article <?php post_class( $post_class ) ?> <?php echo $post_style ?> >
			  
					<div class="slide">
						
						<?php
						/**
						 * Background image link
						 *
						 */
						if( 1 == $hero['title'] && 1 == $hero['content'] && 1 == $hero['media'] ) : ?>
							
							<?php 
							// returns an array with a href and class
							$link = ti_get_instant_view_link(); ?>
			  				
			  				<a href="<?php echo esc_url( $link['href'] ) ?>" class="bg-link <?php echo esc_attr( $link['class'] ) ?>"><!-- nothing to see here --></a>
			  			
			  			<?php endif; ?>
			  			
						<?php if ( 1 != $hero['title'] || 1 != $hero['content'] ) : // Check if here post title or post content are enabled ?>
			  		
							<div class="entry-content">
			  			
								<?php 
								/**
								 * Entry Header
								 *
								 */
								if ( 1 != $hero['title'] ) : // Show post title if not disabled ?>
			  				
									<header class="entry-header">
			  						
										<h2><a href="<?php the_permalink() ?>" title="<?php ti_the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			  					
									</header><!-- .entry-header -->
			  				
								<?php endif; // end entry title check ?>
			  				
			  				
								<?php
								/**
								 * Entry Summary
								 *
								 */
								if ( 1 != $hero['content'] ) : // Show post content if not disabled ?>
			  					
									<?php the_excerpt(); ?>
			  				
								<?php endif; // end hero content check ?>
			  				
			  				
								<footer class="entry-footer">
			  					
									<nav class="action">
			  						
										<ul>
			  						
											<?php 
											/**
											 * More Link
											 *
											 */
											if ( 1 != $hero['more_link'] ) : // Check if read more is enabled ?>
			  							
												<li>
			  									
													<a href="<?php the_permalink() ?>" title="<?php ti_the_title_attribute(); ?>"><?php _e( '&raquo; Read More', 'theme-it' ); ?></a> 
			  								
												</li>
			  							
											<?php endif; // end read more check ?>
			  							
										</ul>

									</nav><!-- .action -->
			  					
								</footer><!-- .entry-footer -->
			  				
							</div><!-- .entry-content -->
			  		
						<?php endif; // end post title and post content check ?>
			  		
			  		
						<?php
						/**
						 * Entry Media
						 *
						 */
						if ( has_media_embed() ) : // Check if media source is provided and if it is enabled ?>
						
							<?php if (  1 != $hero['media'] ) : ?>
			  		
								<div class="entry-media">
			  				  
									<?php 
									// action, id, width, height, allow_autoplay, echo 
									do_action( 'get_media', $post->ID, '400', '225', false ); ?>
			  				
								</div><!-- .entry-media -->
								
							<?php endif; // end $hero['media'] check (hero metabox options) ?>
			  		
						<?php endif; // end media source check ?>
			  	
					</div><!-- .slide -->
			  
				</article><!-- .slide-container -->
			    
			<?php endwhile; ?>
		
		</div><!-- .inner -->
		
		<a href="#" class="prev ir" title="Previous"><?php _e( 'Previous', 'theme-it' ); ?></a>
		<a href="#" class="next ir" title="Next"><?php _e( 'Next', 'theme-it' ); ?></a>
	
	</section><!-- #hero -->

<?php endif; // end loop ?>

<?php wp_reset_query(); // reset query ?>
