/*
 * jQuery Live Countdown
 * Copyright (c) 2010 - 2011 8BIT
 * Licensed under GPL2
 *
 * http://livetheme.tv
 */
 
jQuery(function($) {
  
  if(!($.browser.msie && parseInt($.browser.version) < 9)) {
    $('.live_countdown:not(:first)').remove();
  }
 
	jQuery.liveCountdown($);
});

(function($) {

	$.liveCountdown = function($) {
    
		$('.live_countdown_control').each(function() {
		 
    var iInterval = $.liveCountdown.getBumperDuration();
		var sDay = $(this).children('.live_countdown_day').text();
		var sMonth = $(this).children('.live_countdown_month').text() - 1; // we have to do off by one for proper server-side calculation
		var sYear = $(this).children('.live_countdown_year').text();
		var sHour = parseInt($(this).children('.live_countdown_hour').text());
		var sMinute = $(this).children('.live_countdown_minute').text();
		var sSeconds = $(this).children('.live_countdown_second').text();
		var sAmPm = $(this).children('.live_countdown_ampm').text();
		sHour = $.liveCountdown.normalizeHour(sAmPm, sHour);
		var sTimezone = $('.live_countdown_control').children('.live_countdown_timezone').text();
		var sUrl = $(this).children('.live_countdown_url').text();
		var oSlideshowInterval = null;
      
        var oTimeNow = new Date();
        var oTimeThen = new Date(sYear, sMonth, sDay, sHour, sMinute);
        if(oTimeNow < oTimeThen) {
          $('.live_countdown').fadeIn('fast');
          $('.live_countdown_container').countdown({
            until: oTimeThen,
            timezone: sTimezone,
            alwaysExpire: true,
            layout: '<span class="live_countdown_live">Live In</span> <span class="live_countdown_days_left lt_num">{dn}</span> <span class="live_countdown_days_label lt_label">Days</span> <span class="live_countdown_hours_left lt_num">{hn}</span><span class="live_countdown_hours_left lt_label">Hrs</span><span class="live_countdown_minutes_left lt_num">{mn}</span><span class="live_countdown_minutes_left lt_label">Min</span><span class="live_countdown_seconds_left lt_num">{sn}</span><span class="live_countdown_seconds lt_label">Sec</span>',
            onExpiry: function() {
              $.liveCountdown.stopCountdown(oSlideshowInterval);
              $.liveCountdown.showVideo($('.live_countdown_control'));
              $('.live_countdown').fadeOut('fast');
            } // end onExpiry
          });

			$('#livetheme-online-container').hide();
          if(!$('#livetheme-online-container').is(':visible')) {
            $.liveCountdown.initSlideshow();
            if($('#livetheme-offline-container').children().length > 1) {
              oSlideshowInterval = setInterval(function() {
                $.liveCountdown.runSlideshow();
              }, iInterval);
            } // end if
          } else {
            $('#livetheme-offline-container').hide();
            clearInterval(oSlideshowInterval);
          } // end if/else
        } // end if/else
		});

	} // end liveCountdown

	$.liveCountdown.runSlideshow = function(oInterval) {
	
		$.liveCountdown.initSlideshow();
		if($('.activeImg').next().get(0) !== undefined) {
			$('.activeImg').fadeOut('slow', function() {
				$(this).removeClass('activeImg').next().addClass('activeImg').fadeIn();
			});
		} else {
			$('.activeImg').fadeOut('slow', function() {
				$(this).removeClass('activeImg').siblings(':first').addClass('activeImg').fadeIn();
			});
		} // end if/else
	
	} // end runSlideshow
	
	$.liveCountdown.initSlideshow = function() {
	    
	    $('#livetheme-offline-container').children(':not(:first)').hide();
	    
	    if(!$('#livetheme-offline-container').is(':visible')) {
	    	
	    	$('#livetheme-offline-container').show()
	    		.children(':first')
	    		.fadeIn('slow', function() {
	    			$(this).addClass('activeImg');
	    		});

	    } // end if
	    
	} // end initSlideshow
	
	$.liveCountdown.serverTime = function(sDay, sMonth, sYear, sHour, sMinute, sSecond, sTimezone, sUrl) {
		
		var oTime = null;
		
		$.ajax({
			url: sUrl, 
			data: 'd=' + sDay + '&m=' + sMonth + '&y=' + sYear + '&h=' + sHour + '&min=' + sMinute,
			async: false, 
			dataType: 'text', 
			success: function(text) {
				oTime = new Date(sYear, sMonth, sDay, sHour, sMinute, 0, 0);
			}, error: function(http, message, exc) { 
				oTime = new Date(); 
			}
		});
		
		return oTime;
		
	} // end serverTime
	
	$.liveCountdown.stopCountdown = function(oSlideshowInterval) {
		
		if($('#livetheme-online-container').length > 0) {
			$('#livetheme-offline-container').hide()
				.remove();
			clearInterval(oSlideshowInterval);
		} // end if
		
	} // end stopCountdown
	
	$.liveCountdown.showVideo = function(oContainer) {
	
		$('#livetheme-online-container').fadeIn('slow');
		
		if($(oContainer).siblings(':first').is(':visible')) {
			$(oContainer).siblings(':first').fadeIn('slow');
		} else {
			$(oContainer).siblings(':first').show();
		}
		
		$('.live_countdown').fadeOut('fast');
		
	} // end showVideo
	
	$.liveCountdown.normalizeHour = function(sAmPm, sHour) {
	
		var sNormalizedHour = sHour;
	
		if(sAmPm === 'PM') {
			sNormalizedHour += 12;
		} else {
			if(sHour === 12) {
				sNormalizedHour = 0;
			}
		} // end if/else
		
		return sNormalizedHour;
		
	} // end normalizeHour
  
  $.liveCountdown.getBumperDuration = function() {
  
    var iDuration = -1;
    
    // read the query string
    var sBumperDuration = '';
    $('script').each(function() {
      if($(this).attr('src') !== undefined && $(this).attr('src').indexOf('bumper_duration') > -1) {
        sBumperDuration = $(this).attr('src').split('bumper_duration=')[1].split('&')[0];
      }
    });
    
    // parse out the duration, prepare for interval
    iDuration = parseInt(sBumperDuration) * 1000;
    
    return iDuration;
  
  } // end getBumperDuration
	
})(jQuery);