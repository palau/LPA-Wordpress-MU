(function(){
	$featured_content = jQuery('#featured #slides'),
	et_featured_slider_auto = jQuery("meta[name=et_featured_slider_auto]").attr('content'),
	et_featured_auto_speed = jQuery("meta[name=et_featured_auto_speed]").attr('content');
	
	if ( $featured_content.length ){
		et_nivo_slider_options = {
			pauseTime: et_featured_auto_speed,
			pauseOnHover:true 
		}
		if ( et_featured_slider_auto != 1 ) et_nivo_slider_options.manualAdvance = false;
		
		$featured_content.nivoSlider(et_nivo_slider_options);
	}
})();