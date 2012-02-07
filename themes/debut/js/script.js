(function($) {
	
	/**
	 * No Spam Email
	 */
	$('a.emailaddy').each(function(i) {
		var text = $(this).text();
		var address = text.replace(" at ", "@");
		$(this).attr('href', 'mailto:' + address);
		$(this).text(address);
	});
	
	
	/**
	 * Layout Styles
	 */
	// P Tags - remove empty one
	$("p:empty").remove();
	
	// Nav Styles
	$('#primary-nav li:last-child').css({
		borderRight: '0'
	});
	
	// Widget List Items
	$(".widget ul:last-child").css({
		marginBottom: '0'
	});
	$(".widget ul li:last-child").css({
		border: 'none',
		paddingBottom: '0',
		marginBottom: '0'
	});
	
	// Flickr images - add class
	$('.flickr_badge_image').addClass('entry-thumbnail');
	
	
})(window.jQuery);




jQuery(document).ready(function($) {
	
	/**
	 * Equal Hieght
	 */
	var equalHieghtItems = '#featured .entry';
	
	function sortNumber(a, b) {
		return a - b;
	}
	
	function maxHeight() {
		var heights = new Array();
		$(equalHieghtItems).each(function() {
			$(this).css('height', 'auto');
			heights.push($(this).height());
			heights = heights.sort(sortNumber).reverse();
			$(this).css('height', heights[0]);
		});
	}
	
	maxHeight();
	
	$(window).resize(maxHeight);
	
	
});
