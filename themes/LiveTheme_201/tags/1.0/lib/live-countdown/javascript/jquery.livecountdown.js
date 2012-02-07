/*
 * jQuery Live Countdown
 * Copyright (c) 2010 The Standard Theme Team
 * Licensed under GPL2
 *
 * http://standardtheme.com
 */
 
jQuery(function() {
	jQuery.liveCountdown();
});

(function($) {

	$.liveCountdown = function() {
	
		var iOriginalOffset = $('.live_countdown_control').children('.live_countdown_timezone').text();
		var iCurrentOffset = new Date().getTimezoneOffset() / 60;
		
		var oInterval = setInterval(function() {
		
			$('.live_countdown_control').each(function() {
		
				var oTimeNow = new Date();
				var oTimeNowEpoch = oTimeNow.getTime();
		
				var sDay = $(this).children('.live_countdown_day').text();
				var sMonth = $.liveCountdown.getMonthName($(this).children('.live_countdown_month').text());
				var sYear = $(this).children('.live_countdown_year').text();
				var sHour = parseInt($(this).children('.live_countdown_hour').text()) + (iOriginalOffset - iCurrentOffset);
				if(sHour > 12) {
					sHour -= 12;
				}
				
				var sMinute = $(this).children('.live_countdown_minute').text();
				var sSeconds = $(this).children('.live_countdown_second').text();
				var sAmPm = $(this).children('.live_countdown_ampm').text();
				
				var oTargetTime = new Date(sDay + " " + sMonth + ", " + sYear + " " + sHour + ":" + sMinute + ":00 " + sAmPm);
				var oTargetTimeEpoch = oTargetTime.getTime();
				
				var iDaysLeft = Math.floor(((oTargetTimeEpoch - oTimeNowEpoch) / (60 * 60 * 24)) / 1000);
				iDaysLeft = iDaysLeft < 0 ? 0 : iDaysLeft;
				$(this).siblings('.live_countdown_display').children('.live_countdown_days_left').text(iDaysLeft);
				
				var iHoursLeft = Math.floor(((oTargetTimeEpoch - oTimeNowEpoch) / (60 * 60)) / 1000);
				iHoursLeft = iHoursLeft < 0 ? 0 : iHoursLeft;				
				$(this).siblings('.live_countdown_display').children('.live_countdown_hours_left').text(iHoursLeft - (iDaysLeft * 24));
				
				var iMinutesLeft = Math.floor(((oTargetTimeEpoch - oTimeNowEpoch) / (60)) / 1000);
				iMinutesLeft = iMinutesLeft < 0 ? 0 : iMinutesLeft;
				$(this).siblings('.live_countdown_display').children('.live_countdown_minutes_left').text(iMinutesLeft - (iHoursLeft * 60));
				
				var iSecondsLeft = Math.floor(((oTargetTimeEpoch - oTimeNowEpoch) / 1000));
				iSecondsLeft = iSecondsLeft < 0 ? 0 : iSecondsLeft;
				$(this).siblings('.live_countdown_display').children('.live_countdown_seconds_left').text(iSecondsLeft - (iMinutesLeft * 60));
				
				if($.liveCountdown.eventHasStarted(iDaysLeft, iHoursLeft, iMinutesLeft, iSecondsLeft)) {
					if($('#livetheme-online-container').length > 0) {
						$('#livetheme-offline-container').hide();
						clearInterval(oSlideshowInterval);
					}
					$('#livetheme-online-container').fadeIn('slow');
					if($(this).siblings(':first').is(':visible')) {
						$(this).siblings(':first').fadeIn('slow');
					} else {
						$(this).siblings(':first').show();
					}
					$('.live_countdown').fadeOut('slow');
				} else {
					$('.live_countdown').fadeIn('slow');
				}
				
			}); // end each
			
		}, 1000); // end setInterval	
		
		var oSlideshowInterval = null;
		if(!$('#livetheme-online-container').is(':visible')) {
			$.liveCountdown.initSlideshow();
			if($('#livetheme-offline-container').children().length > 1) {
				oSlideshowInterval = setInterval(function() {
					$.liveCountdown.runSlideshow();
				}, 5000);
			}
		} else {
			$('#livetheme-offline-container a').hide();
			clearInterval(oSlideshowInterval);
		}
		
	} // end liveCountdown
	
	$.liveCountdown.getMonthName = function(iId) {
		var sMonthName = null;
		switch(parseInt(iId)) {
				case 1:
					sMonthName = 'January';
					break;
				case 2:
					sMonthName = 'February';
					break;
				case 3:
					sMonthName = 'March';
					break;
				case 4:
					sMonthName = 'April';
					break;
				case 5:
					sMonthName = 'May';
					break;
				case 6:
					sMonthName = 'June';
					break;
				case 7:
					sMonthName = 'July';
					break;
				case 8:
					sMonthName = 'August';
					break;
				case 9:
					sMonthName = 'September';
					break;
				case 10:
					sMonthName = 'October';
					break;
				case 11:
					sMonthName = 'November';
					break;
				case 12:
					sMonthName = 'December';
					break;
				default:
					break;
			} // end switch/case
			return sMonthName;
	} // end getMonthName
	
	$.liveCountdown.eventHasStarted = function(iDay, iHour, iMinute, iSecond) {
		return iDay === 0 && iHour === 0 && iMinute === 0 && iSecond === 0;
	} // end hasInvalidDate
	
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
		}
	
	} // end runSlideshow
	
	$.liveCountdown.initSlideshow = function() {
		if(!$('#livetheme-offline-container').is(':visible')) {
			$('#livetheme-offline-container a').hide();
			$('#livetheme-offline-container').show().children('a:first').fadeIn('slow', function() {
				$(this).addClass('activeImg');
			});
		}
	} // end initSlideshow
	
})(jQuery);