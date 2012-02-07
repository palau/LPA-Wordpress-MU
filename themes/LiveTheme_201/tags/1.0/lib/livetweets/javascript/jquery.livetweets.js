/*
 * jQuery Live Tweets 1.0
 * Copyright (c) 2010 The Standard Theme Team
 * Licensed under GPL2
 *
 * Also uses:
 * - Dustin Diaz's Twitalinkahashifyer!
 * - H() from Twitter's widget.js
 *
 * http://standardtheme.com
 */

jQuery(function() {
	
	var $livetweets = null;
	if(jQuery('.live_tweets').length === 0) {
		$livetweets = jQuery('.live_tweets_display').parents();
	} else {
		$livetweets = jQuery('.live_tweets');
	}
	
	jQuery($livetweets).each(function() {
		if(jQuery.browser.msie) {
			jQuery.liveTweets(
				this,
				jQuery(this).children('.live_tweets_hashtag').val(),
				jQuery(this).children('.live_tweets_username').val(),
				Math.ceil(parseInt(jQuery(this).children('.live_tweets_updaterate').val())),
				Math.ceil(parseInt(jQuery(this).children('.live_tweets_displaycount').val()))
			);
		} else {
			jQuery.liveTweets(
				this,
				jQuery(this).children('.live_tweets_hashtag').val().trim(),
				jQuery(this).children('.live_tweets_username').val().trim(),
				Math.ceil(parseInt(jQuery(this).children('.live_tweets_updaterate').val())),
				Math.ceil(parseInt(jQuery(this).children('.live_tweets_displaycount').val()))
			);
		}
	});
});

(function($) {

	$.liveTweets = function(oLiveTweets, sHashTag, sUsername, iUpdateRate) {
		
		var aThemePath = $('#live_tweets_source').val().split('/');
		var sThemeDirectory = aThemePath[aThemePath.length - 1];
		
		var iUpdateRate = iUpdateRate === 0 || isNaN(iUpdateRate) ? 2000 : iUpdateRate * 1000;
		var iDisplayCount = iDisplayCount === 0 || isNaN(iDisplayCount) ? 4 : iDisplayCount;
	
		var oTimer = $.liveTweets.start(oLiveTweets, sHashTag, sUsername, iUpdateRate, iDisplayCount, sThemeDirectory);
		$('.live_tweets_controls').children('.live_tweets_pause').click(function() {
			$(this).toggle();
			$('.live_tweets_controls .live_tweets_resume').toggle();
			clearInterval(oTimer);
			oTimer = null;
		});
		
		$('.live_tweets_controls').children('.live_tweets_resume').click(function() {
			$(this).toggle();
			$('.live_tweets_controls .live_tweets_pause').toggle();
			if(oTimer === null) {
				oTimer = $.liveTweets.start(oLiveTweets, sHashTag, sUsername, iUpdateRate, iDisplayCount, sThemeDirectory);
			}
		});
		
	}
	
	$.liveTweets.start = function(oLiveTweets, sHashTag, sUsername, iUpdateRate, iDisplayCount, sThemeDirectory) {

		$(oLiveTweets).children('.live_tweets_loading').fadeOut(1000, function() {
			$(this).remove();
			if(sHashTag === "" && sUsername === "") {
				$(oLiveTweets).children('.live_tweets_display').children('.live_tweets_error').fadeIn();
			} else { 
				$(oLiveTweets).children('.live_tweets_display').children('.live_tweets_error').remove();
				$(oLiveTweets).children('.live_tweets_controls').fadeIn();
			}
		});
		$.liveTweets.getNewTweets(oLiveTweets, sHashTag, sUsername, sThemeDirectory);
		
		return setInterval(function() {
			
			$(oLiveTweets).children('.live_tweets_display')
				.prepend(
					$(oLiveTweets).children('.live_tweets_container').children('li:first')
				);
			
			$(oLiveTweets).children('.live_tweets_display').children(':first').fadeIn();
			
			var iVisibleTweets = $(oLiveTweets).children('.live_tweets_display').children().length;
			if(iVisibleTweets > iDisplayCount) {
				$(oLiveTweets).children('.live_tweets_display').children('li:last').remove();
			} else if(iVisibleTweets === iDisplayCount) {
				$.liveTweets.getNewTweets(oLiveTweets, sHashTag, sUsername, sThemeDirectory);
			}
			
		}, iUpdateRate);
		
	} // end start
		
	/**
	 * Asynchronously pulls new Tweets for the specified hashtag and username.
	 *
	 * @hashtag	The hashtag for which to search.
	 * @username The username for which to search.
	 */
	$.liveTweets.getNewTweets = function(oLiveTweets, sHashTag, sUsername, sThemeDirectory) {
		
		var sParameters = sHashTag.length === 0 ? '' : 'hashtag=' + sHashTag;
		sParameters += sUsername.length === 0 ? '' : '&username=' + sUsername;
		
		var sUrl = './wp-content/themes/' + sThemeDirectory + '/lib/livetweets/php/livetweets.reader.php?' + sParameters;
		$.getJSON(sUrl, function(oTweets) {
			while(oTweets.results.length !== 0) {
				$(oLiveTweets).children('.live_tweets_container').append($.liveTweets.createTweetElement(oTweets.results.pop()));
			}
		});
	} // end getNewTweets
		
	/**
	 * Creates and returns a list item element containing a Twitter profile image, 
	 * message, and timestamp
	 *
	 * @oTweet	A single instance of a Tweet from which to create the element.
	 */
	$.liveTweets.createTweetElement = function(oTweet) {
	
		var liTweetContainer = document.createElement('li');
		$(liTweetContainer).hide()
				.attr('id', oTweet.id)
				.append($.liveTweets.tweetProfileImage(oTweet))
				.append($.liveTweets.tweetUsername(oTweet))
				.append($.liveTweets.tweetTimestamp(oTweet))
				.append($.liveTweets.tweetText(oTweet))
				
		return liTweetContainer;
			
	} // end createTweetElement
		
	/**
	 * Creates the Twitter profile image element from the specified Tweet.
	 *
	 * @oTweet	A single instance of a Tweet from which to create the profile image.
	 */
	$.liveTweets.tweetProfileImage = function(oTweet) {
		
		var divImgProfile = document.createElement('div');
		
		var imgProfile = document.createElement('img');
		$(imgProfile).attr('alt', oTweet.from_user)
					.attr('src', oTweet.profile_image_url)
					.attr('width', 35)
					.attr('height', 35)
					.attr('class', 'live_tweet_profile_image');
		
		return $(divImgProfile).addClass('live_tweet_avatar').append(imgProfile);
		
	} // end tweetProfileImage

	/**
	 * Returns a span element containing a formatted version of the user's name.
	 */
	$.liveTweets.tweetUsername = function(oTweet) {
		var spanTweetUsername = document.createElement('span');
		$(spanTweetUsername).addClass('live_tweets_tweet_title').append(ify.username(oTweet.from_user));
		return spanTweetUsername;
	} // end tweetUsername
	
	/**
	 * Creates the Twitter text element from the specified Tweet.
	 *
	 * @oTweet	A single instance of a Tweet from which to create the Twitter text.
	 */		
	$.liveTweets.tweetText = function(oTweet) {
		var pTweet = document.createElement('p');
		$(pTweet).attr('class', 'live_tweet_text')
						 .html(ify.clean(oTweet.text));
		return pTweet;
	} // end tweetText
		
	/**
	 * Uses John Resig's prettyDate() to create the Twitter timestamp and link it
	 * to the original Tweet.
	 *
	 * @oTweet	A single instance of a Tweet from which to create the timestamp.
	 */
	$.liveTweets.tweetTimestamp = function(oTweet) {
	
		var aTimestamp = document.createElement('a');
		$(aTimestamp).attr('href', 'http://twitter.com/' + oTweet.from_user + '/status/' + oTweet.id)
								 .attr('class', 'live_tweet_timestamp_link')
								 .attr('target', '_blank')
								 .append(H(oTweet.created_at));
								 
		var spanTimestamp = document.createElement('span');
		$(spanTimestamp).attr('class', 'live_tweet_timestamp')
										.append(aTimestamp);
		
		return spanTimestamp;
		
	} // end tweetTimestamp
	
})(jQuery);