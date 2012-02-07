<?php
/*
 * Plugin Name: Custom Tabbed Widget
 * Plugin URI: http://www.celtic7.com
 * Description: A widget that display popular posts, recent posts, recent comments and tags
 * Version: 1.1
 * Author: Luke McDonald
 * Author URI: http://www.lukemcdonald.com
 */

/*
 * Load our widget.
 */
add_action( 'widgets_init', 'ti_tab_widgets' );

/*
 * Register widget.
 */
function ti_tab_widgets() {
	register_widget( 'ti_tab_widget' );
}

function ti_tabbed_widget_enqueue()
{
	if ( is_active_widget( false, false, 'ti_tab_widget' ) ){ 
		wp_enqueue_script( 'jquery-ui-core' );		
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_register_script( 'tabbed', get_template_directory_uri() . '/js/tabbed-widget.js', array( 'jquery-ui-tabs' ) );
		wp_enqueue_script( 'tabbed' );
	}
}
add_action( 'init', 'ti_tabbed_widget_enqueue' );

/*
 * Widget class.
 */
class ti_tab_widget extends WP_Widget {

	function ti_tab_widget() 
	{
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'ti-tab-widget', 'description' => __( 'A tabbed widget that display popular posts, recent posts, and comments.', 'theme-it' ) );
		
		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'ti_tab_widget' );
		
		/* Create the widget. */
		$this->WP_Widget( 'ti_tab_widget', __( 'Custom Tabbed Widget', 'theme-it' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) 
	{
		global $wpdb;
		
		extract( $args );

		/* Our variables from the widget settings. */
		$tab1 = $instance['tab1'];
		$tab2 = $instance['tab2'];
		$tab3 = $instance['tab3'];
	
		echo $before_widget;

		//Randomize tab order in a new array
		$tab = array(); ?>
			
		<div id="tabs">
		
			<ul id="tab-items">
				<li class="button-dark"><a href="#tabs-1"><span><?php esc_html_e( $tab1, 'theme-it' ) ?></span><span class="indicator"></span></a></li>
				<li class="button-dark"><a href="#tabs-2"><span><?php esc_html_e( $tab2, 'theme-it' ) ?></span><span class="indicator"></span></a></li>
				<li class="button-dark"><a href="#tabs-3"><span><?php esc_html_e( $tab3, 'theme-it' ) ?></span><span class="indicator"></span></a></li>
			</ul>
			
			<div class="tabs-inner">
				<div id="tabs-1" class="tab tab-recent">
					<ul>
						<?php
						/* Get array of post info. */
						$recent_posts_args = array(
							'posts_per_page' => '5'
						);
						
						$recent_posts_query = new WP_Query( $recent_posts_args );
						
						while ( $recent_posts_query->have_posts() ) : $recent_posts_query->the_post(); ?>
						
							<li class="clearfix">
								
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="entry-thumbnail">
										<a href="<?php the_permalink();?>" class="post-thumbnail" title="<?php printf( esc_attr__( 'Permalink to %s', 'theme-it' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_post_thumbnail( 'thumbnail-large' ); ?></a>
									</div><!-- .entry-thumbnail -->
								<?php endif; // end post thumbnail check ?>
								
								<h4 class="entry-title">
									<a class="title" href="<?php esc_url( the_permalink() ) ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'theme-it' ), the_title_attribute( 'echo=0' ) ); ?>">
										<?php if ( function_exists( 'the_short_title' ) ) {
											the_short_title( '', '&hellip;', true, 40 );
										} else {
											the_title();
										} ?>
									</a>
								</h4><!-- .entry-title -->
								
								<div class="entry-meta">
									<time class="entry-date published" datetime="<?php the_time( 'm-d-Y') ?>"><?php the_time( get_option( 'date_format' ) ) ?></time>
									<span class="comment-count"><?php comments_popup_link( __( 'No comments', 'theme-it' ), __( '1 Comment', 'theme-it' ), __( '% Comments', 'theme-it' ) ); ?></span>
								</div><!-- .entry-meta -->
							
							</li>
							
						<?php endwhile; wp_reset_query(); ?>
						
					</ul>
				</div><!-- #tabs-1 -->
			
				<div id="tabs-2" class="tab tab-popular">
					<ul>
						<?php
						/* Get array of post info. */
						$popular_posts_args = array(
						  'posts_per_page' => '5',
						  'orderby' => 'comment_count'
						);
						
						$popular_posts_args = new WP_Query( $popular_posts_args );
						
						while ( $popular_posts_args->have_posts() ) : $popular_posts_args->the_post(); ?>
							
							<li class="clearfix">
							
								<?php if ( has_post_thumbnail() ) : ?>
								  <div class="entry-thumbnail">
								  	<a href="<?php the_permalink();?>" class="post-thumbnail" title="<?php printf( esc_attr__( 'Permalink to %s', 'theme-it' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_post_thumbnail( 'thumbnail-large' ); ?></a>
								  </div><!-- .entry-thumbnail -->
								<?php endif; // end post thumbnail check ?>
								
								<h4 class="entry-title">
									<a class="title" href="<?php esc_url( the_permalink() ) ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'theme-it' ), the_title_attribute( 'echo=0' ) ); ?>">
										<?php if ( function_exists( 'the_short_title' ) ) {
											the_short_title( '', '&hellip;', true, 40 );
										} else {
											the_title();
										} ?>
									</a>
								</h4><!-- .entry-title -->
								
							<div class="entry-meta entry-header">
								<span class="published"><?php the_time( get_option( 'date_format' ) ); ?></span>
								<span class="comment-count"><?php comments_popup_link(__( 'No comments', 'theme-it' ), __( '1 Comment', 'theme-it' ), __( '% Comments', 'theme-it' ) ); ?></span>
							</div>
						</li>
							
						<?php endwhile; wp_reset_query(); ?>
					
					</ul>
				</div><!-- #tabs-2 -->

				<div id="tabs-3" class="tab tab-comments">
				
					<?php
					$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved, comment_type, comment_author_url, SUBSTRING(comment_content,1,70) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ( $wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT 5";
					$comments = $wpdb->get_results( $sql );
					?>
				
					<ul>
				
						<?php foreach ( $comments as $comment) { ?>
					
							<li class="clearfix">
							  
							  <div class="entry-thumbnail">
							  	<a href="<?php echo esc_url( get_permalink( $comment->ID ) ) ?>#comment-<?php echo absint( $comment->comment_ID ) ?>" title="<?php echo esc_attr__( $comment->comment_author . ' on ' . $comment->post_title, 'theme-it' ) ?>"><?php echo get_avatar( $comment, '55' ); ?></a>
							  </div>
							
							  <h4>
							  	<a href="<?php echo get_permalink( $comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php echo strip_tags( $comment->comment_author); ?> <?php _e( 'on ', 'theme-it' ); ?><?php echo $comment->post_title; ?>">
							  		<?php echo strip_tags( $comment->comment_author); ?>: <?php echo strip_tags( $comment->com_excerpt); ?>...
							  	</a>
							  </h4>
							
							</li>
						
						<?php }	// end foreach ?>		
							
					</ul>
			
				</div><!-- #tabs-3 -->

			</div><!-- .tabs-inner -->
	
		</div><!-- #tabs -->

  <?php /* After widget (defined by themes). */
  echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['tab1'] = $new_instance['tab1'];
		$instance['tab2'] = $new_instance['tab2'];
		$instance['tab3'] = $new_instance['tab3'];
		
		return $instance;
	}
	
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array(
			'tab1' => __( 'Recent', 'theme-it' ),
			'tab2' => __( 'Popular', 'theme-it' ),
			'tab3' => __( 'Comments', 'theme-it' )
		);
		$instance = wp_parse_args( ( array ) $instance, $defaults ); ?>

		<!-- tab 1 title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tab1' ); ?>"><?php _e( 'Tab 1 Title:', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tab1' ); ?>" name="<?php echo $this->get_field_name( 'tab1' ); ?>" value="<?php echo $instance['tab1']; ?>" />
		</p>
		
		<!-- tab 2 title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tab2' ); ?>"><?php _e( 'Tab 2 Title:', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tab2' ); ?>" name="<?php echo $this->get_field_name( 'tab2' ); ?>" value="<?php echo $instance['tab2']; ?>" />
		</p>
		
		<!-- tab 3 title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tab3' ); ?>"><?php _e( 'Tab 3 Title:', 'theme-it' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tab3' ); ?>" name="<?php echo $this->get_field_name( 'tab3' ); ?>" value="<?php echo $instance['tab3']; ?>" />
		</p>
	<?php
	}
}
?>