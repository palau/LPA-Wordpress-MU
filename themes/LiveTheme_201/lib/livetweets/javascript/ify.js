/**
 * The Twitalinkahashifyer!
 * http://www.dustindiaz.com/basement/ify.html
 * Eg:
 * ify.clean('your tweet text');
 *
 * username(tweet) added by Tom McFarlin 08/2010
 * for the Live Tweet plug-in
 */
		
var ify = {
  link: function(tweet) {
    return tweet.replace(/\b(((https*\:\/\/)|www\.).+?)(([!?,.\)]+)?(\s|$))/g, function(link, m1, m2, m3, m4) {
      var http = m2.match(/w/) ? 'http://' : '';
      return '<a class="live_tweets_hyperlink" target="_blank" href="' + http + m1 + '">' + ((m1.length > 25) ? m1.substr(0, 24) + '...' : m1) + '</a>' + m4;
    });
  },

 at: function(tweet) {
    return tweet.replace(/\B\@([a-zA-Z0-9_]{1,20})/g, function(m, username) {
      return '<a target="_blank" class="live_tweets_atreply" href="http://twitter.com/' + username + '">@' + username + '</a>';
    });
  },

  list: function(tweet) {
    return tweet.replace(/\B\@([a-zA-Z0-9_]{1,20}\/\w+)/g, function(m, userlist) {
      return '@<a target="_blank" class="live_tweets_atreply" href="http://twitter.com/' + userlist + '">' + userlist + '</a>';
    });
  },

  hash: function(tweet) {
    return tweet.replace(/\B\#(\w+)/gi, function(m, hash) {
      return '<a target="_blank" class="live_tweets_hashtag" href="http://twitter.com/search?q=%23' + hash + '">#' + hash + '</a>';
    });
  },

  clean: function(tweet) {
    return this.hash(this.at(this.list(this.link(tweet))));
  },
		
	/**
	 * Implemented to parse the Tweet's author and provide a link back to their original Tweet.
	 */
	username: function(tweet) {
    return tweet.replace(/(\S[a-zA-Z0-9_]{1,20})/g, function(m, username) {
      return '<a target="_blank" class="live_tweets_atreply" href="http://twitter.com/' + username + '">@' + username + '</a>';
    });
  },
		
};