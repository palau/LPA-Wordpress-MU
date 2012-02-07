/*
 * jQuery Live Countdown Administration Functionality
 * Copyright (c) 2010 - 2011 8BIT
 * Licensed under GPL2
 *
 * http://livetheme.tv
 */
 
jQuery(function($) {

	getValidMonths($);
	
	$('.live_countdown_year:last').change(function() {
		getValidMonths($, $(this).children(':selected').val());
	});

	var iMonth = -1;
	$('.live_countdown_month:last').change(function() {
	
		iMonth = $(this).children(':selected').val();
		iYear = $('.live_countdown_year:last').children(':selected').val();
		getValidDatesFor($, iMonth);
		
		if(parseInt(iMonth) === 2) {		
			getValidDatesForLeapYear($, iMonth, iYear);
		} // end if
		
	});
	

	var iYear = -1;
	$('.live_countdown_year:last').change(function() {
	
		iMonth = $('.live_countdown_month:last').children(':selected').val();
		iYear = $(this).children(':selected').val();
		getValidDatesFor($, iMonth);
		
		if(parseInt(iMonth) === 2) {		
			getValidDatesForLeapYear($, iMonth, iYear);
		} // end if
	});
	
	var sOffsetQualifier = new Date().toString().split('GMT')[1].charAt(0); // + or - for offset
	var sOffset = new Date().getTimezoneOffset().toString() / 60;
	if(sOffset.toString().charAt(0) === '-') {
		sOffset = sOffset.toString().substring(1, sOffset.length);
	} else { 
		sOffset = sOffset.toString().substring(1, sOffset.length - 1);
	} // end if/else
	$('.live_countdown_timezone:last').val(sOffsetQualifier + sOffset);
	
}); 

function getValidMonths($) {

	var oDate = new Date();
	
	// optional arguments for year. passed in when the year select changes
	var iYear = null;
	if(arguments[1] !== null) {
		iYear = arguments[1];
	} // end if
	
	var iThisMonth = oDate.getMonth() + 1;	// JavaScript returns 0 for January, 11 for December. 
	var iThisYear = oDate.getFullYear();
	
	var iSelectedMonth = parseInt($('.live_countdown_month:last').children(':selected').val());	
	if(iThisMonth > iSelectedMonth) {
		$('.live_countdown_month:last option[value="' + iThisMonth + '"]').attr('selected', 'selected');
	} // end if/else
	$('.live_countdown_month:last option:lt(' + (iThisMonth - 1) + ')').attr('disabled', 'disabled');

	if(iYear !== undefined && iThisYear < iYear) {
		$('.live_countdown_month:last').children().removeAttr('disabled');
	} // end if

} // end getValidMonths
 
function getValidDatesFor($, iMonth) {

	switch(parseInt(iMonth)) {
	
		case 4:
		case 6:
		case 9:
		case 11:
			jQuery('.live_countdown_day:last').children('option').each(function() {
				if(parseInt($(this).val()) > 30) {
					$(this).attr('disabled', 'disabled');
				} else {
					$(this).removeAttr('disabled');
				} // end if/else
			});
			break;
			
		case 2:
			$('.live_countdown_day:last').children('option').each(function() {
				if(parseInt($(this).val()) > 28) {
					$(this).attr('disabled', 'disabled');
				}
			});
			break;
			
		default:
			$('.live_countdown_day:last').children('option').each(function() {
				$(this).removeAttr('disabled')
			});
			break;
			
	} // end switch/case

} // end getValidDatesFor

function getValidDatesForLeapYear($, iMonth, iYear) {
	
	iMonth = parseInt(iMonth);
	iYear = parseInt(iYear);
	
	if(new Date(iYear,1,29).getDate() === 29 && iMonth === 2) {
		jQuery('.live_countdown_day:last').children('option').each(function() {
			var iCurrentDay = parseInt($(this).val());
			if(iCurrentDay > 29) {
				$(this).attr('disabled', 'disabled');
			} else if (iCurrentDay === 29) {
				$(this).removeAttr('disabled');
			} // end if/else
		});
	} else {
		$('.live_countdown_day:last').children('option').each(function() {
			if(parseInt($(this).val()) >= 29) {
				$(this).attr('disabled', 'disabled');
			} // end if
		});
	} // end if/else
	
} // _end getValidDatesForLeapYear
