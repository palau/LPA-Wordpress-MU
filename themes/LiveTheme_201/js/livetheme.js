$(function() {

  /* --- Pretty Photo For Archives --- */

	$("a[rel^='prettyPhoto']").prettyPhoto({
		theme: 'dark_square',
		show_title: false,
		default_height: 450,
		horizontal_padding: 20,
		deeplinking: true,
		social_tools: false
	});
	
  /* --- /Pretty Photo For Archives --- */

  /* --- Image Fade --- */

	$('.fade > img').hover(function() {
		$(this).fadeTo('fast', 0.5);
	}, function() {
		$(this).fadeTo('fast', 1);
	});
	
		$('.video-fade > img').hover(function() {
		$(this).fadeTo('fast', 0.1);
	}, function() {
		$(this).fadeTo('fast', 1);
	});
  
  /* -- /Image Fade --- */
	
  /* --- Social Tabs --- */
  
  if($('#liveTabs').children().size() === 0) {
    $('#liveTabs').hide();
    $('#inside').hide();
  } else if($('#liveTabs').children().size() == 1) {
    
    var sTabType = $('#liveTabs').children('li').attr('class');
    sTabType = 'tab-' + sTabType;
    
    $('#liveTabs').children('li').addClass('active-tab');
    $('#inside').children().hide();
    $('#' + sTabType).addClass('active-tab').show();
    
  } else {
  
    $('#liveTabs').children('li').click(function() {
            
      // Update the active tab
      $('.active-social').removeClass('active-social');
      $(this).children(':first').addClass('active-social');
      $('#inside').children(':not(first)').hide();
      
      // Toggle the proper tab content
      var sTabType = $(this).attr('class');
      sTabType = 'tab-' + sTabType;
      $('.active-tab').removeClass('active-tab').hide();
      $('#' + sTabType).addClass('active-tab').show();
      
    });
    
    $('#inside').children(':first').addClass('active-tab');
  
  } // end if/else

  /* -- /Social Tabs --- */
  
  /* --- Page Tabs --- */
  
	$('#features-tabs li:first').addClass('active');
	if(hasActivePage($('#features-tabs .active'))) {
		$('#features').children(getActivePageId($('#features-tabs .active')))
									.addClass('active-page')
									.parent()
									.children()
									.not(getActivePageId($('#features-tabs .active')))
									.toggle();
	}
	
  $('.active-page').siblings().toggle();
	$('#features-tabs a').click(function(evt) {
    
    evt.preventDefault();
    if(!$(this).parent().hasClass('active')) {
      
      $('.active').removeClass('active');
      $(this).parent()
        .addClass('active');
      
      $('.active-page').toggle().removeClass('active-page');
      $('#features .' + $(this).text().split(' ')[0]).toggle().addClass('active-page');
      
    } // end if

	});
	
  /* -- /Page Tabs --- */
  
	if($('#flickr').length > 0 ) {
		$('.flickr_badge_image').each(function() {
			$(this).children(':first')
						 .attr('target', '_blank');
		});
	}
 
  if($('#poll-duration').attr('src').split('=')[1] !== 'off') {
	setInterval(function() {
		$('#event-response').load(window.location.href + ' #event-poll', function(data) {
		 	if($(this).children(':first').text() === 'yes' && $('.live_countdown').is(':not(:visible)')) {
		    	location.reload();
		  	} // end if/else
		});
	}, getPollingInterval());
  } // end if/else
	
});

function getActivePageId(oElem) {
  return '#page-item-' + $('.active').attr('class').split(' ')[3].split('-')[2];
}

function hasActivePage(oElem) {
	return $(oElem).get(0) !== undefined;
}

function getPollingInterval() {

  var iDuration = -1;
    
  // read the query string
  var sDuration = '';
  sDuration = $('#poll-duration').attr('src').split('=')[1];

  // parse out the duration, prepare for interval
  iDuration = parseInt(sDuration) * 60 * 1000;
  
  return iDuration;
    
} // end getPollingInterval
