/*
 * jQuery Live Countdown Administration Functionality
 * Copyright (c) 2010 The Standard Theme Team
 * Licensed under GPL2
 *
 * http://standardtheme.com
 */

jQuery(_setup);

function _setup() {
	
	var iSelectedMonth = parseInt(jQuery('.live_countdown_month :selected:last').val());
	_getValidDatesForSelectedMonth(iSelectedMonth);
	
	jQuery('.live_countdown_month').change(function() {
		iSelectedMonth = parseInt(jQuery(this).val())		
		_getValidDatesForSelectedMonth(iSelectedMonth);
	});
		
	jQuery('.live_countdown_year').change(function() {
		_getValidDatesForLeapYear(iSelectedMonth, jQuery(this).val());
	});
	
	jQuery('.live_countdown_timezone').val(new Date().getTimezoneOffset().toString() / 60);
	
} // end _setup

function _getValidDatesForSelectedMonth(iSelectedMonth) {
	iSelectedMonth = parseInt(iSelectedMonth);
	switch(iSelectedMonth) {
		case 4:
		case 6:
		case 9:
		case 11:
			jQuery('.live_countdown_day').children('option').each(function() {
				if(parseInt(jQuery(this).val()) > 30) {
					jQuery(this).hide();
				} else {
					jQuery(this).show();
				}
			});
			break;
		case 2:
			jQuery('.live_countdown_day').children('option').each(function() {
				if(parseInt(jQuery(this).val()) > 28) {
					jQuery(this).hide();
				}
			});
			break;
		default:
			jQuery('.live_countdown_day').children('option').each(function() {
				jQuery(this).show();
			});
			break;
	} // end switch/case
} // end _getValidDatesForSelectedMonth

function _getValidDatesForLeapYear(iSelectedMonth, iSelectedYear) {
	
	iSelectedMonth = parseInt(iSelectedMonth);
	iSelectedYear = parseInt(iSelectedYear);
	
	if(new Date(iSelectedYear,1,29).getDate() === 29 && iSelectedMonth === 2) {
		jQuery('.live_countdown_day').children('option').each(function() {
			var iCurrentDay = parseInt(jQuery(this).val());
			if(iCurrentDay > 29) {
				jQuery(this).hide();
			} else if (iCurrentDay === 29) {
				jQuery(this).show();
			}
		});
	} else {
		jQuery('.live_countdown_day').children('option').each(function() {
			if(parseInt(jQuery(this).val()) >= 29) {
				jQuery(this).hide();
			}
		});
	}
} // _end getValidDatesForLeapYear