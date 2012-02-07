<div id="sidebar" class="col-<?php if ( get_option('woo_left_sidebar') == "true" ) echo 'left'; else echo 'right'; ?>">

	<!-- Widgetized Sidebar -->	
	<?php dynamic_sidebar('sidebar'); ?>		
             
</div><!-- /#sidebar -->