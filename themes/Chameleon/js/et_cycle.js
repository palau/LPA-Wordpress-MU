(function(){
	$featured_content = jQuery('#featured #slides'),
	et_featured_slider_auto = jQuery("meta[name=et_featured_slider_auto]").attr('content'),
	et_featured_auto_speed = jQuery("meta[name=et_featured_auto_speed]").attr('content');
	
	if ($featured_content.length){
		var et_featured_options = {
			timeout: 0,
			speed: 500,
			cleartypeNoBg: true,
			prev:   '#featured a#left-arrow', 
			next:   '#featured a#right-arrow',
			pager:  '#controllers'
		}
		if ( et_featured_slider_auto == 1 ) et_featured_options.timeout = et_featured_auto_speed;
					
		$featured_content.cycle( et_featured_options );
	}
})();