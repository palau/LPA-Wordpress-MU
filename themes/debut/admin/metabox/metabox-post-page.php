<div id="ti-post-page" class="ti-metabox">
	
	<div class="section">
	
		<div class="header">
			<p><?php echo __( 'Choose to show this page\'s title and/or content.', 'theme-it' ); ?></p>
		</div>
		<!-- .header -->
		
		<div class="content">
			<div class="col w50">
			  <p>
			    <label class="txtnormal">
			      <?php $mb->the_field( 'enable_post_page_title' ); ?>
			      <input type="checkbox" name="<?php $mb->the_name(); ?>" value="1"<?php if ( $mb->get_the_value() ) echo ' checked="checked"'; ?>/> 
			      <?php echo __( 'Show Title', 'theme-it' ); ?>
			    </label>
			  </p>
			  <p>
			    <label class="txtnormal">
			      <?php $mb->the_field( 'enable_post_page_content' ); ?>
			      <input type="checkbox" name="<?php $mb->the_name(); ?>" value="1"<?php if ( $mb->get_the_value() ) echo ' checked="checked"'; ?>/> 
			      <?php echo __( 'Show Content', 'theme-it' ); ?>
			    </label>
			  </p>
			</div>
			<!-- .column -->
			<div class="col w50">
			  <p>
			    <label><?php echo __( 'Number of Posts:' , 'theme-it' ); ?></label>
			    	<?php $mb->the_field( 'post_page_number' ); ?>
			    	<input type="text" size="2" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
			  </p>
			</div>
			<!-- .column -->				
		</div>
		<!-- .content -->
	</div>
	<!-- .section -->
	
	<div class="section">
		
		<div class="header">
			<p><?php echo __( 'All categories are shown by default.', 'theme-it' ); ?></p>
		</div>
		<!-- .header -->
		
		<div id="ti-post-page-terms" class="content">
			<p>
			  <?php $terms = get_terms( 'category', 'hide_empty=0' ); ?>
			  
			  <?php while ( $mb->have_fields( 'post_page_cats', count( $terms ) ) ): ?>
			  
			  	<?php $term = $terms[ $mb->get_the_index() ]; ?>
			  	<input type="checkbox" name="<?php $mb->the_name(); ?>" value="<?php echo $term->term_id; ?>"<?php $mb->the_checkbox_state( $term->term_id ); ?>/> 
			  	<?php echo $term->name; ?><br/>
			  
			  <?php endwhile; ?>
			</p>		
		</div>
		<!-- .content -->
		
	</div>
	<!-- .section -->
	
</div>
<!-- #ti-post-page -->

<style type="text/css">

/* Tab Styles */
#ti-post-page #ti-post-page-terms {
	overflow: auto;
	max-height: 100px;
}
</style>

