var touchJS = jQuery.noConflict();
function doClassicReady() {
touchJS( function () {
var tabContainers = touchJS( '#menu-container > div' );
var loginTab = touchJS( '#menu-tab5' );
touchJS( '#tab-inner-wrap-left a' ).click( function () {
tabContainers.hide().filter( this.hash ).opacityToggle( 350 );
touchJS( '#tab-inner-wrap-left a' ).removeClass( 'selected' );
touchJS( this ).addClass( 'selected' );
if ( loginTab ) {
touchJS( 'input#log' ).focus();
} else {
touchJS( 'input#log' ).blur();	}
return false;
}).filter( ':first' ).click();
});
touchJS( 'a#header-menu-toggle' ).unbind( 'click' ).click( function() {
touchJS( '#main-menu' ).opacityToggle( 350 );
touchJS( this ).toggleClass( 'menu-toggle-open' );
return false;
});	touchJS( 'a#tab-search' ).unbind( 'click' ).click( function() {
touchJS( '#search-bar' ).toggleClass( 'show-search' );
touchJS( this ).toggleClass( 'search-toggle-open' );
if ( touchJS( '#search-bar' ).hasClass( 'show-search' ) ) {
touchJS( 'input#search-input' ).focus();
} else{
touchJS( 'input#search-input' ).blur();	}
return false;
});	touchJS( '#main-menu' ).find( 'li.has_children ul' ).hide();
touchJS( '#main-menu ul li.has_children > a' ).unbind( 'click' ).click( function() {
touchJS( this ).parent().children( 'ul' ).opacityToggle( 350 );
touchJS( this ).toggleClass( 'arrow-toggle' );
touchJS( this ).parent().toggleClass( 'open-tree' );
return false;
});
if ( touchJS( '#prowl-message' ).length ) {
setTimeout( function() { touchJS( '#prowl-message' ).fadeOut( 350 ); }, 2500 );
}
if ( touchJS( '.single' ).length ) {
touchJS( '.content img, .content .wp-caption' ).each( function() {
if ( touchJS( this ).width() <= 250 && touchJS( this ).width() >= 100 ) {
touchJS( this ).addClass( 'aligncenter' );
}
});
}
if ( touchJS( '.single .p3-img-protect' ).length ) {
touchJS( '.single .p3-img-protect' ).each( function() {
touchJS( '.p3-overlay' ).remove();
var insideContent = touchJS( this ).html();
touchJS( this ).replaceWith( insideContent );
});
}
touchJS( 'a#share-post' ).unbind( 'click' ).click( function() {
touchJS( '#inner-ajax #share-absolute' ).opacityToggle( 450 ).viewportCenter();
});	touchJS( 'a#share-close' ).unbind( 'click' ).click( function() {
touchJS( '#inner-ajax #share-absolute' ).opacityToggle( 450 );
return false;
});	touchJS('li#instapaper a').unbind( 'click' ).click( function() {
var userName = prompt( WPtouch.instapaper_username, '' );
if ( userName ) {
var somePassword = prompt( WPtouch.instapaper_password, '' );
if ( !somePassword ) {
somePassword = 'default';	}
var ajaxParams = {
url: document.location.href,
username: userName,
password: somePassword,
title: document.title
};
WPtouchAjax( 'instapaper', ajaxParams, function( result ) {
if ( result == '1' ) {
alert( WPtouch.instapaper_saved );
} else {
alert( WPtouch.instapaper_try_again );
}
});
}
return false;
});
var shareOverlay = touchJS( '#share-absolute' ).get(0);
if ( shareOverlay ) {
shareOverlay.addEventListener( 'touchmove', classicTouchMove, false );	touchJS( '#email a' ).click( function() {
touchJS( 'a#share-close' ).click();
return true;
});
}
if ( touchJS( '.commentlist' ).length ) {
touchJS( '.commentlist li :first' ).addClass( 'first' );
touchJS( '.commentlist img.avatar:first' ).addClass( 'first' );
}
if ( touchJS( window ).width() <= 320 ) {
touchJS( 'body' ).addClass( 'portrait' );
} else {
touchJS( 'body' ).addClass( 'landscape' );
}
window.onorientationchange = function() {
var orientation = window.orientation;
switch( orientation ) {
case 0:
touchJS( 'body' ).toggleClass( 'portrait' ).removeClass( 'landscape' );
break;
case 180:
touchJS( 'body' ).toggleClass( 'portrait' ).removeClass( 'landscape' );
break;
case 90:
touchJS( 'body' ).toggleClass( 'landscape' ).removeClass( 'portrait' );
break;
case -90:
touchJS( 'body' ).toggleClass( 'landscape' ).removeClass( 'portrait' );
break;
}
}
if ( touchJS( 'a.com-toggle').length ) {
touchJS( 'a.com-toggle' ).click( function() {
classic_showhide_response();
return false;
});
}
hideAddressBar();
webAppOnly();
hijackPostLinks();
loadMoreEntries();
loadMoreComments();
comReplyArrows();
classicExcerptToggle();
webAppOverlay();
var webApp = window.navigator.standalone;
if ( webApp ) {
touchJS( 'div.wptouch-shortcode-webapp-only' ).show();	} else {
touchJS( 'div.wptouch-shortcode-mobile-only' ).show();
touchJS( '#web-app-overlay a' ).unbind( 'click' ).click( function() {
dismissWebAppNotice();
touchJS( '#web-app-overlay' ).fadeOut();
});
}
}
function hideAddressBar() {
var webApp = window.navigator.standalone;
if ( !webApp ) {
if ( top.location!= self.location ) { top.location = self.location.href }
window.addEventListener( 'load', function() {
setTimeout( scrollTo, 0, 0, 1 );
}, false );
}
}
function classicTouchMove( event ) {
event.preventDefault();	}
touchJS.fn.opacityToggle = function( speed, easing, callback ) {
return this.animate( { opacity: 'toggle' }, speed, easing, callback );
}
touchJS.fn.viewportCenter = function() {
this.css( 'position','absolute');
this.css( 'top', ( touchJS( window ).height() - this.height() ) / 3 + touchJS( window ).scrollTop() + 'px' );
this.css( 'left', ( touchJS( window ).width() - this.width() ) / 2 + touchJS( window ).scrollLeft() + 'px' );
return this;
}
touchJS.fn.viewportBottom = function() {
this.css( 'position','absolute');
this.css( 'top', ( touchJS( window ).height() - this.height() ) / .68 + touchJS( window ).scrollTop() + 'px' );
this.css( 'left', ( touchJS( window ).width() - this.width() ) / 2 + touchJS( window ).scrollLeft() + 'px' );
return this;
}
function webAppOverlay() {
var webApp = window.navigator.standalone;
if ( !webApp ) {	var storage = window [ 'localStorage' ];
if ( !window [ 'localStorage' ] ) return;
if ( !localStorage.getItem( 'webapp' ) ) {
touchJS( '#web-app-overlay' ).viewportBottom();
} else {
touchJS( '#web-app-overlay' ).hide();
}
} else {
touchJS( '#web-app-overlay' ).hide();
}
}
function dismissWebAppNotice( type ) {
var storage = window [ 'localStorage' ];
if ( !window [ 'localStorage' ] ) return;
localStorage.setItem( 'webapp', 'true' );
}
function webAppOnly() {
var webApp = window.navigator.standalone;
if ( webApp ) {
touchJS( '#welcome-message' ).hide();
touchJS( '#switch' ).remove();
touchJS( 'a.comment-reply-link' ).remove();
touchJS( 'a.comment-edit-link' ).remove();
touchJS( 'body' ).addClass( 'web-app' );
if ( touchJS( 'body.black-translucent' ).length ) {
touchJS( 'body.black-translucent' ).css('margin-top', '20px');
}
}
}
function wptouchGetDocumentUrl() {
if ( window.navigator.standalone && wptouchAjaxUrl ) {
return wptouchAjaxUrl;	}
return document.location.href;	}
function wptouchGetDocumentTitle() {
if ( window.navigator.standalone ) {
return prompt( WPtouch.classic_post_desc, '' );
} else {
return document.title;
}
}
function hijackPostLinks() {
touchJS( '#main-menu ul li.has_children > a, a.load-more-link' ).addClass( 'no-ajax' );
touchJS( 'a.translate_translate' ).addClass( 'no-ajax' );
if ( window.navigator.standalone ) {
touchJS( 'li.force-external a' ).addClass( 'no-ajax' );
touchJS( '#main-menu ul li a img' ).click( function() {
touchJS( this ).parent().click();	return false;
});
}
var allExternalLinks = touchJS( 'a:not(.no-ajax)' );
if ( allExternalLinks.length ) {
allExternalLinks.unbind( 'click' ).click( function( e ) {
var url = e.target.href;
var isPhoneNumber = ( url.indexOf( 'tel:' ) >= 0 );
var isEmail = ( url.indexOf( 'mailto:' ) >= 0 );
var isUnsupportedFile = (
url.lastIndexOf( '.pdf' ) >= 0 || url.lastIndexOf( '.xls' ) >= 0 || url.lastIndexOf( '.numbers' ) >= 0 || url.lastIndexOf( '.pages' ) >= 0 ||
url.lastIndexOf( '.mp3' ) >= 0 || url.lastIndexOf( '.mp4' ) >= 0 || url.lastIndexOf( '.m4v' ) >= 0 || url.lastIndexOf( '.mov' ) >= 0
);
var localDomain = document.domain;
var webApp = window.navigator.standalone;
if ( isPhoneNumber || isEmail || isUnsupportedFile ) {
return true;	}
if ( webApp ) {
if ( touchJS( this ).hasClass( 'comment-reply-link' ) || touchJS( this ).hasClass( 'thdrpy' ) || touchJS( this ).hasClass( 'thdmang' ) ) {
return true;	}
var actualLink = touchJS( this ).attr( 'href' );
if ( actualLink[0] == '#' ) {
return true;
}	if ( url.match( localDomain ) && !touchJS( this ).parent().hasClass( 'email' ) ) {
if ( touchJS( '#main-menu' ).hasClass( 'show-menu' ) ) {
touchJS( 'a#header-menu-toggle' ).click();
}	loadPage( url );	return false;
} else {
if ( touchJS( this ).parent().hasClass( 'email' ) ) {
return true;	}
var answer = confirm( WPtouch.external_link_text + ' \n' + WPtouch.open_browser_text );
if ( answer ) {
return true;
} else {
return false;
}
}
} else {
if ( touchJS( this ).parent().hasClass( 'email' ) ) {
touchJS( '#main-menu' ).opacityToggle( 0 );
touchJS( 'a#header-menu-toggle' ).toggleClass( 'menu-toggle-open' );
}
}
});
}
}
function classicExcerptToggle() {
touchJS( 'a.excerpt-button' ).live( 'click', function() {
touchJS( this ).toggleClass( 'open' );
var postID = touchJS( this ).attr( "rel" );
var parentPost = touchJS( this ).parents( "div.post" );
if ( parentPost.length ) {
var firstParent = touchJS( parentPost.get(0) );
firstParent.find( 'div.content' ).opacityToggle( 350 );	}	return false;	});
}
function loadMoreEntries() {
var webApp = window.navigator.standalone;
var loadMoreLink = touchJS( 'a.load-more-link' );
if ( loadMoreLink.length ) {
loadMoreLink.live( 'click', function() {
touchJS( this ).addClass( 'ajax-spinner' ).fadeOut( 2200 );
var loadMoreURL = touchJS( this ).attr( 'rel' );
touchJS( '#content' ).append( "<div class='ajax-page-target'></div>" );
touchJS( 'div.ajax-page-target' ).hide().load( loadMoreURL + ' #content .post, #content .load-more-link', function() {
touchJS( 'div.ajax-page-target' ).replaceWith( touchJS( 'div.ajax-page-target' ).html() );	if ( webApp ) {	hijackPostLinks();	}
});
return false;
});	}	}
function loadMoreComments() {
var loadMoreLink = touchJS( 'ol.commentlist li.load-more-comments-link a' );
if ( loadMoreLink.length ) {
loadMoreLink.live( 'click', function() {
touchJS( this ).addClass( 'ajax-spinner' ).fadeOut( 2200 );
var loadMoreURL = touchJS( this ).attr( 'href' );
touchJS( 'ol.commentlist' ).append( "<div class='ajax-page-target'></div>" );
touchJS( 'div.ajax-page-target' ).hide().load( loadMoreURL + ' ol.commentlist > li', function() {
touchJS( 'div.ajax-page-target' ).replaceWith( touchJS( 'div.ajax-page-target' ).html() );	webAppOnly();
comReplyArrows();
});
return false;
});	}	}
function comReplyArrows() {
var comReply = touchJS( 'ol.commentlist li li .comment-top' );
touchJS.each( comReply, function() {
touchJS( comReply ).prepend( '<div class="com-down-arrow"></div>' );
});
}
function classic_showhide_response() {
touchJS( 'ol.commentlist' ).toggleClass( 'shown' );
touchJS( 'ol.commentlist' ).toggleClass( 'hidden' );
touchJS( 'img#com-arrow' ).toggleClass( 'com-arrow-down' );
}
function saveURL( type ) {
var storage = window [ type + 'Storage' ];
if ( !window [ type + 'Storage' ] ) return;
localStorage.setItem( 'savedUrl', wptouchAjaxUrl );
}
function goToPersistent() {
var webApp = window.navigator.standalone;
if ( webApp && touchJS( 'body.loadsaved' ).length ) {	var lastUrl = localStorage.getItem( 'savedUrl' );
var storage = window [ 'localStorage' ];
if ( !window [ 'localStorage' ] ) return;
if ( window.location != localStorage.getItem( 'savedUrl' ) ) {
loadSavedPage( lastUrl );
} else {
localStorage.setItem( 'savedUrl', window.location.href );
}
}
}
var wptouchAjaxUrl = '';
function loadPage( url ) {
touchJS( 'body' ).append( '<div id="progress"></div>' )
touchJS( '#progress' ).viewportCenter();
touchJS( '#outer-ajax' ).load( url + ' #inner-ajax', function( allDone ) {
wptouchAjaxUrl = url;
touchJS('#progress').remove();
saveURL( 'local' );
scrollTo( 0, 0 );
doClassicReady();
} );
}
var webApp = window.navigator.standalone;
if ( webApp ) {
var wptouchAjaxUrl = '';
function loadSavedPage( url ) {
touchJS( '#content' ).load( url + ' #content', function( allDone ) {
wptouchAjaxUrl = url;
doClassicReady();
});
}
}
touchJS( document ).ready( function() { goToPersistent(); doClassicReady(); } );