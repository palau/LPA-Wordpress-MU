$(function() {

	$('.fade > img').hover(function() {
		$(this).fadeTo('fast', 0.5);
	}, function() {
		$(this).fadeTo('fast', 1);
	});
	
	if($('#liveTabs').children().size() === 0) { 
		$('#liveTabs').hide();
		$('#inside').hide();
	} else {
		if($('#liveTabs').children().size() === 1) {
			if($('#liveTabs').children(':first').attr('class') === 'twitter') {
				$('#tab-facebook').hide();
				$('#tab-twitter').addClass('active-social');
			} else {
				$('#tab-twitter').hide();
				$('#tab-facebook').addClass('active-social');
			}
		} else {
			$('#tab-facebook').hide();
			$('#social-tabs .social-tab').click(function() {
				if(!$(this).hasClass('active-social')) {
					$('.active-social').removeClass('active-social');
					$(this).addClass('active-social');
					$('#tab-facebook').toggle();
					$('#tab-twitter').toggle();
				}
			});
		}
	}
	
	$('#features-tabs li:first').addClass('active');
	if(hasActivePage($('#features-tabs .active'))) {
		$('#features').children(getActivePageId($('#features-tabs .active')))
									.addClass('active-page')
									.parent()
									.children()
									.not(getActivePageId($('#features-tabs .active')))
									.toggle();
	}
	
	$('#features-tabs a').click(function() {
		if(!$(this).parent().hasClass('active')) {
			$('.active').removeClass('active');
			$(this).parent()
						 .addClass('active');
			$('.active-page').toggle()
											.removeClass('active-page')
											.children(':first')
											.toggle();
			if(hasActivePage($(this).parent('.active'))) {
				$(getActivePageId($(this).parent('.active'))).toggle()
					.addClass('active-page')
					.children(':first')
					.show();
			}
		}
		return false;
	});
	
	if($('#flickr').length > 0 ) {
		$('.flickr_badge_image').each(function() {
			$(this).children(':first')
						 .attr('target', '_blank');
		});
	}
	
});

function getActivePageId(oElem) {
		return '#' + $(oElem).attr('class').split(' ')[1];
}

function hasActivePage(oElem) {
	return $(oElem).get(0) !== undefined;
}
