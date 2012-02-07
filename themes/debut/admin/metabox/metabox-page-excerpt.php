<div id="ti-page-excerpt" class="ti-metabox">
	
	<div class="content">
		
		<p>
		  <?php $mb->the_field( 'page_excerpt' ); ?>
		  <textarea name="<?php $mb->the_name(); ?>" ><?php $mb->the_value(); ?></textarea><br />
		  <span><?php echo __( 'Highlighted text shown after the page title. A little HTML is accepted.', 'theme-it' ); ?></span>
		</p>
	
	</div>
	<!-- .content -->
	
</div>
<!-- #ti-page-excerpt -->
