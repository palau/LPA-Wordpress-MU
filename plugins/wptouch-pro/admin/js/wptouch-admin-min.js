var wptouchClip = 0;
function WPtouchProAdminReady() {	inputSetBorderColor();
inputSetBorderColorOnChange();
jQuery.ajaxSetup ({
cache: false
});
WPtouchCookieSetup();
WPtouchTooltipSetup();
jQuery( '#setting-installed-themes .wptouch-theme-box' ).equalHeights( 250 , 500 );
jQuery( '#touchboard .box-holder' ).equalHeights( 275 , 500 );
if ( jQuery('a#target-pane-5').length ) {
jQuery( 'a#target-pane-5' ).unbind( 'click' ).click( function() {
jQuery( 'a.pane-bncid-licenses' ).click();
return false;
});
jQuery( 'a#target-pane-5.partial' ).unbind( 'click' ).click( function() {
jQuery( 'a.pane-bncid-licenses' ).click();
jQuery( 'a.configure-licenses' ).click();
return false;
});
}
WPtouchSetupActivateThemes();
WPtouchSetupCopyThemes();
WPtouchSetupDeleteThemes();
WPtouchSetupThemeSettings();
jQuery( 'a#select-text-button' ).click( function() {
selectAllText( jQuery( '.type-backup textarea' ) )
return false;
});
jQuery( 'a#color-picker' ).click( function() {
NewWindow(this.href,'av','900','500','no','no');
return false;
});
var ajaxRequests = 0;
jQuery( 'div.admin-ajax' ).each( function() {
var divTitle = jQuery( this ).attr( "title" );
var divId = jQuery( this ).attr( "id" );
if ( ajaxRequests == 0 ) {
WPtouchAjaxOn();
}
ajaxRequests++;
WPtouchAdminAjax( divTitle, {}, function( data ) {
jQuery( '#' + divId ).html( data );
ajaxRequests--;
if ( ajaxRequests == 0 ) {
}	});
});
jQuery( '#bnc-submit' ).unbind( 'click' ).click( function() {
jQuery('#saving-ajax').fadeIn(250);
return true;
});
if ( jQuery( '#bnc-form .saved' ).length ) {
setTimeout( function() {
jQuery( '#bnc-form .saved' ).fadeOut(500);
}, 2500);
}
jQuery( '#bnc-submit-reset input' ).click( function() {
var answer = confirm( WPtouchCustom.reset_admin_settings );
if ( answer ) {
jQuery.cookie( 'wptouch-tab', '' );
jQuery.cookie( 'wptouch-list', '' );
} else {
return false;	}
});
if ( jQuery( '#bnc-form .reset' ).length ) {
setTimeout( function() {
jQuery( '#bnc-form .reset' ).fadeOut(500);
}, 2500);
}
jQuery( '#bnc-form' ).click( function() {	var totalItems = '';
var uncheckedMenuItems = jQuery( 'ul.icon-menu li input.checkbox:not(:checked)' );
jQuery.each( uncheckedMenuItems, function( i, e ) {
var menuItemTitle = jQuery( e ).attr( 'title' );
totalItems = totalItems + menuItemTitle + ",";
});
jQuery( 'input#hidden-menu-items' ).attr( "value", totalItems );
return true;
});
if ( jQuery( '#wptouch-tabbed-area.developer' ).length == 0 ) {
jQuery( '.section-clientmode' ).remove();
}
if ( jQuery( '#wptouch-icon-list' ).length ) {
WPtouchSetupIconDragDrag();
var wptouchMenuOpen = false;
jQuery( 'a.expand' ).click( function() {
var parentListItem = jQuery( this ).parent( 'li' );
if ( parentListItem.length ) {
if ( parentListItem.hasClass( 'open' ) ) {
if ( wptouchMenuOpen ) {
jQuery( 'li.open' ).removeClass( 'open' );
wptouchMenuOpen = false;
jQuery( "#wptouch-icon-menu ul ul" ).slideUp( 250 );
}
} else {
if ( wptouchMenuOpen ) {
jQuery( "#wptouch-icon-menu ul ul" ).slideUp( 250 );
jQuery( 'li.open' ).removeClass( 'open' );
}
var delay = 500;
if ( !wptouchMenuOpen ) {
delay = 0;
}
setTimeout( function() {
parentListItem.find( "ul" ).slideDown( 250 );
parentListItem.addClass( 'open' );
wptouchMenuOpen = true;
}, delay );
}
}
return false;
});
jQuery( '#active-icon-set' ).change( function() {
var selectItem = jQuery( this );
jQuery( '#wptouch-icon-list' ).animate( { opacity: 0.4 }, 250 );
var ajaxParams = {
set: selectItem.val()
};
WPtouchAdminAjax( 'update-icon-pack', ajaxParams, function( result ) {
setTimeout(
function() {
jQuery( '#wptouch-icon-list' ).html( result ).animate( { opacity: 1 }, 250 );
WPtouchSetupIconDragDrag();
}, 250 );	});	});
jQuery( '#active-icon-set' ).change();
jQuery( 'a#reset-menu-all' ).click( function() {
var answer = confirm( WPtouchCustom.reset_icon_menu_settings );
if ( answer ) {
WPtouchAdminAjax( 'reset-menu-icons', {}, function( result ) {
jQuery('#bnc-form').submit();
});
return false;
} else {
return false;	}
});
jQuery( 'a#pages-check-all' ).click( function() {
jQuery( 'ul.icon-menu input:checkbox:not(:checked)' ).attr( 'checked', true );
return false;
});
jQuery( 'a#pages-check-none' ).click( function() {
jQuery( 'ul.icon-menu input:checkbox' ).attr( 'checked', false );
return false;
});
jQuery( 'ul.icon-menu input.checkbox' ).change( function() {
if( jQuery(this).attr( "checked" ) ) {
jQuery(this).parent( "li" ).find( "input.checkbox" ).attr( "checked", true );
WPtouchDoTreeDisable();
} else {
jQuery(this).parent( "li" ).find( "input.checkbox" ).attr( "checked", false );
WPtouchDoTreeDisable();
}
});
WPtouchDoTreeDisable();
}
if ( jQuery('#manage-sets').length ) {
jQuery( '#manage-icon-set-area li a' ).unbind( 'click' ).click( function() {
var iconSetName = jQuery( this ).attr( "title" );
var clickedLink = jQuery( this );
jQuery( '#manage-icon-set-area li' ).removeClass( 'active ');
jQuery( this ).parent().addClass( 'active' );
jQuery( '#manage-icon-ajax' ).animate( { opacity: 0.4 }, 250 );
var ajaxParams = {
area: "manage",
set: iconSetName	};
WPtouchAdminAjax( 'update-icon-pack', ajaxParams, function( result ) {
setTimeout(
function() {
jQuery( '#manage-icon-ajax' ).html( result ).animate( { opacity: 1 }, 250 );
jQuery( 'a.delete-icon' ).unbind( 'click' ).click( function(e) {
var deleteLink = jQuery( this );
var linkOffset = jQuery( this ).offset();
jQuery('#bnc .poof').css({
left: linkOffset.left + 14 + 'px',
top: linkOffset.top + 10 + 'px'
}).show();
animatePoof();
var iconFile = jQuery( this ).parent().find( 'img' ).attr( 'src' );
var ajaxParams = {
area: "manage",
icon: iconFile
};
WPtouchAdminAjax( 'delete-icon', ajaxParams, function( result ) {
var currentIcons = jQuery( '#manage-icon-ajax li' );
if ( currentIcons.size() == 1 ) {
jQuery( '#manage-icon-set-area li:first a' ).click();
}
});	jQuery( this ).parent().fadeOut( 500 );	setTimeout( function() {
deleteLink.parent().remove();
}, 500
);
return false;
});
if ( clickedLink.parent().hasClass( 'dark' ) ) {
jQuery( '#pool-color-switch a.dark' ).click();
} else {
jQuery( '#pool-color-switch a.light' ).click();
}
jQuery( 'a.delete-set' ).unbind( 'click' ).click( function() {
var iconSetName = jQuery( this ).parent().parent().find( "em" ).html();
if ( confirm( WPtouchCustom.are_you_sure_set ) ) {
var ajaxParams = {
area: "manage",
set: iconSetName
};
WPtouchAdminAjax( 'delete-icon-pack', ajaxParams, function( result ) {	jQuery('#bnc-form').submit();	});
}
return false;
});
}, 250 );	});	return false;
});
jQuery( '#pool-color-switch a').unbind( 'click' ).click( function() {
jQuery( '#manage-icon-area' ).removeClass( 'light' ).removeClass( 'dark' );
jQuery( '#pool-color-switch a ').removeClass( 'active ');
if ( jQuery( this ).hasClass( 'light') ) {
jQuery( '#manage-icon-area' ).addClass( 'light' );	} else {
jQuery( '#manage-icon-area' ).addClass( 'dark' );
}
jQuery( this ).addClass( 'active' );
return false;
});
new AjaxUpload( 'manage-upload-button', {
action: ajaxurl,
data: {
action: "wptouch_ajax",
wptouch_action: "manage-upload",
wptouch_nonce: WPtouchCustom.admin_nonce
},
autoSubmit: true,
onSubmit: function( file, extension ) {
jQuery( '#manage-set-upload-name' ).html( file ).show();
WPtouchDoManageStatus( WPtouchCustom.upload_header, WPtouchCustom.upload_status, false, 'success' );
},
onComplete: function( file, response ) {
if ( response == 'invalid' ) {
WPtouchDoManageStatus( WPtouchCustom.upload_invalid_header, WPtouchCustom.upload_invalid_status, true, 'failure' );
} else if ( response == 'icon-done' ) {
setTimeout( function() {
WPtouchDoManageStatus( WPtouchCustom.upload_done_header, WPtouchCustom.upload_done_icon_status, true, 'success' );	setTimeout( function() { jQuery( '#manage-icon-set-area li a:first' ).click(); }, 250 ); }, 750
);	} else if ( response == 'zip' ) {	WPtouchDoManageStatus( WPtouchCustom.upload_unzip_header, WPtouchCustom.upload_unzip_status, false, 'success' );	WPtouchAdminAjax( 'manage-unzip-set', {}, function( result ) {
if ( result == 'done' ) {
setTimeout(
function() {	WPtouchDoManageStatus( WPtouchCustom.upload_done_header, WPtouchCustom.upload_done_set_status, true, 'success' );
setTimeout( function() { jQuery('#bnc-form').submit(); }, 250 ); }, 500
);	} else if ( result == 'create-readme' ) {
setTimeout(
function() {	WPtouchDoManageStatus( WPtouchCustom.upload_done_header, WPtouchCustom.upload_describe_set, true, 'success' );
setTimeout( function() { jQuery( '#wptouch-set-input-area' ).fadeIn(); }, 500 );
}, 500
);	} else {
alert( 'Unknown error' );	}
});
} else {
setTimeout( function() {
WPtouchDoManageStatus( WPtouchCustom.upload_processing_header, WPtouchCustom.upload_processing_status, false, 'success' );	setTimeout( function() {
WPtouchDoManageStatus( WPtouchCustom.upload_done_header, WPtouchCustom.upload_done_status, true, 'success' ); }, 750 );
}, 750
);
}
}
});
jQuery( '#manage-icon-set-area li:first a' ).click();
jQuery( '#pool-color-switch a:first').click();
}
var advertisingSelect = jQuery( 'select#advertising_type' );
if ( advertisingSelect.length ) {
advertisingSelect.change( function() {
var selectedValue = advertisingSelect.val();
if ( selectedValue == 'none' ) {
jQuery( '.section-custom-advertising' ).hide();
jQuery( '.section-google' ).hide();
jQuery( '.section-admob' ).hide();
} else if ( selectedValue == 'google' ) {
jQuery( '.section-google' ).fadeIn();
jQuery( '.section-admob' ).hide();
jQuery( '.section-custom-advertising' ).hide();
} else if ( selectedValue == 'admob' ) {
jQuery( '.section-google' ).hide();
jQuery( '.section-admob' ).fadeIn();
jQuery( '.section-custom-advertising' ).hide();
} else if ( selectedValue == 'custom' ) {
jQuery( '.section-google' ).hide();
jQuery( '.section-admob' ).hide();
jQuery( '.section-custom-advertising' ).fadeIn();
}
});
advertisingSelect.change();
}	var debugLogCheckbox = jQuery( 'input#debug_log' );
if ( debugLogCheckbox ) {
debugLogCheckbox.click( function() {
WPtouchChangeDebugLog();
});	WPtouchChangeDebugLog();
}
wptouchSetupTabSwitching();
var manageLicense = jQuery( '#wptouch-license-area' );
if ( manageLicense.length ) {
WPtouchAdminAjax( 'profile', {}, function( result ) {
jQuery( '#wptouch-license-area' ).html( result );
WPtouchSetupLicenseArea();
});
}
var wptouchboardNews = jQuery( '#blog-news-box-ajax' );
if ( wptouchboardNews.length ) {
WPtouchAdminAjax( 'wptouch-news', {}, function( result ) {
setTimeout( function() { jQuery( '#blog-news-box' ).removeClass( 'loading' );}, 750);
wptouchboardNews.html( result );
});	}
wptouchLoadSupportPosts();
var wptouchboardAjax = jQuery( '#touchboard-ajax' );
if ( wptouchboardAjax.length ) {
WPtouchAdminAjax( 'license-info', {}, function( result ) {
wptouchboardAjax.html( result );
statusActivateTabLink();
});	}
var licensesRemaining = jQuery( '#wptouch-licenses-remaining' );
if ( licensesRemaining.length ) {
WPtouchAdminAjax( 'licenses-left', {}, function( result ) {
licensesRemaining.hide();
licensesRemaining.html( result );
wptouchSetupTabSwitching();
licensesRemaining.fadeIn( 250 );
});	}
if ( jQuery( '#setting-bncid p.license-valid' ).length ) {
jQuery( '#setting-bncid input#bncid.text' ).addClass( 'valid' );
jQuery( '#setting-bncid input#wptouch_license_key.text' ).addClass( 'valid' );	}
if ( jQuery( '#setting-bncid p.license-partial' ).length ) {
jQuery( '#setting-bncid input#bncid.text' ).addClass( 'partial' );
jQuery( '#setting-bncid input#wptouch_license_key.text' ).addClass( 'partial' );	}
if ( jQuery( 'p.bncid-failed' ).length ) {
jQuery( 'p.bncid-failed' ).shake( 5, 3, 600 );
}
var wptouchPageRedirect = jQuery( '#enable_home_page_redirect' );
if ( wptouchPageRedirect.length ) {
wptouchCheckHomePageRedirect();
wptouchPageRedirect.change( function() {
wptouchCheckHomePageRedirect();
});	}
var wptouchSwitchDestination = jQuery( '#show_switch_link' );
if ( wptouchSwitchDestination.length ) {
wptouchCheckSwitchDestination();
wptouchSwitchDestination.change( function() {
wptouchCheckSwitchDestination();
});	}
var wptouchWebAppSettings = jQuery( 'input#classic_webapp_enabled' );
if ( wptouchWebAppSettings.length ) {
wptouchCheckWebAppEnabled();
wptouchWebAppSettings.change( function() {
wptouchCheckWebAppEnabled();
});	}
var wptouchPostIconType = jQuery( '#classic_icon_type' );
if ( wptouchPostIconType.length ) {
wptouchPostIconType.change( function() {
var selectedValue = wptouchPostIconType.val();	if ( selectedValue == 'none' || selectedValue == 'calendar' ) {
jQuery( '#setting_classic_thumbs_on_single' ).hide();
jQuery( '#setting_classic_thumbs_on_pages' ).hide();	} else {
jQuery( '#setting_classic_thumbs_on_single' ).fadeIn();
jQuery( '#setting_classic_thumbs_on_pages' ).fadeIn();
}
if ( selectedValue == 'thumbnails' ) {
jQuery( '#setting_post_thumbnails_new_image_size' ).fadeIn();
jQuery( '#setting_regenerate-copytext-info' ).fadeIn();
} else {
jQuery( '#setting_post_thumbnails_new_image_size' ).hide();	jQuery( '#setting_regenerate-copytext-info' ).hide();	}
});	}
var wptouchCalColor = jQuery( '#classic_icon_type' );
if ( wptouchCalColor.length ) {
wptouchCalColor.change( function() {
var selectedValue = wptouchCalColor.val();	if ( selectedValue == 'calendar' ) {
jQuery( '#setting_classic_calendar_icon_bg' ).fadeIn();
} else {
jQuery( '#setting_classic_calendar_icon_bg' ).hide();
}
});	}
var wptouchCalCustomColor = jQuery( '#classic_calendar_icon_bg' );
if ( wptouchCalCustomColor.length ) {
wptouchCalCustomColor.change( function() {
var selectedParent = jQuery( '#classic_icon_type' ).val();	var selectedValue = wptouchCalCustomColor.val();	if ( selectedValue == 'cal-custom' && selectedParent == 'calendar' ) {
jQuery( '#setting_classic_custom_cal_icon_color' ).fadeIn();
} else {
jQuery( '#setting_classic_custom_cal_icon_color' ).hide();
}
});	}
var newForumPostSubmit = jQuery( '#support-form-submit' );
if ( newForumPostSubmit.length ) {
newForumPostSubmit.click( function() {
var postTitle = jQuery( '#forum-post-title' ).val();
if ( postTitle ) {
var postTags = jQuery( '#forum-post-tag' ).val();
if ( postTags ) {
var postDesc = jQuery( '#forum-post-content' ).val();
if ( postDesc ) {
if ( postDesc ) {
jQuery( '#support-form-inside' ).animate( { opacity: 0.5 } );
var ajaxParams = {
title: postTitle,
tags: postTags,
desc: postDesc	};
WPtouchAdminAjax( 'support-posting', ajaxParams, function( result ) {	if ( result == "ok" ) {
alert( WPtouchCustom.forum_topic_success );
jQuery( '#forum-post-title' ).val( '' );
jQuery( '#forum-post-tag' ).val( '' );
jQuery( '#forum-post-content' ).val( '' );
wptouchLoadSupportPosts();
} else {
alert( WPtouchCustom.forum_topic_failed );	}
jQuery( '#support-form-inside' ).animate( { opacity: 1.0 } );
});
}
} else {
alert( WPtouchCustom.forum_topic_text );	}	} else {
alert( WPtouchCustom.forum_topic_tags );	}
} else {
alert( WPtouchCustom.forum_topic_title );	}
return false;
});	}
var classicIconType = jQuery( '#classic_icon_type' );
if ( classicIconType.length ) {	classicIconType.change( function() {
var selectItem = jQuery( this );
if ( selectItem.val() == 'custom_thumbs' ) {
jQuery( '#setting_classic_custom_field_thumbnail_name' ).fadeIn();	} else {
jQuery( '#setting_classic_custom_field_thumbnail_name' ).hide();
}	});	classicIconType.change();
}
var classicCalCustom = jQuery( '#classic_calendar_icon_bg' );
if ( classicCalCustom.length ) {	classicCalCustom.change( function() {
var selectItem = jQuery( this );
var selectedParent = jQuery( '#classic_icon_type' ).val();	if ( selectItem.val() == 'cal-custom' && selectedParent == 'calendar' ) {
jQuery( '#setting_classic_custom_cal_icon_color' ).fadeIn();	} else {
jQuery( '#setting_classic_custom_cal_icon_color' ).hide();
}	});	classicCalCustom.change();
}
WPtouchSetupLicenseArea();
WPtouchSetupPluginCompat();
WPtouchCheckApiServer();
WPtouchSetupPluginDismiss();
WPtouchHandleBackupRestore();
WPtouchShowWhenCheckboxEnabled( '#classic_show_attached_image', '#setting_classic_show_attached_image_location' );
}
function WPtouchHandleBackupRestore() {
var backupRestoreSelect = jQuery( 'select#backup_or_restore' );
if ( backupRestoreSelect.length ) {
if ( backupRestoreSelect.val() == 'backup' ) {
jQuery( '#setting_import' ).hide();
jQuery( '#setting_backup' ).show();	WPtouchHandleBackupClipboard();
} else if ( backupRestoreSelect.val() == 'restore' ) {
jQuery( '#setting_backup' ).hide();
jQuery( '#setting_import' ).show();	}	}	backupRestoreSelect.unbind( 'change' ).change( function() {
WPtouchHandleBackupRestore();
});
}
function WPtouchSetupPluginDismiss() {
var dismissButtons = jQuery( 'a.dismiss-button' );
if ( dismissButtons.length > 0 ) {
dismissButtons.unbind( 'click' ).click( function() {
var linkOffset = jQuery( this ).offset();
jQuery( '#bnc .poof' ).css({
left: linkOffset.left + 14 + 'px',
top: linkOffset.top - 5 + 'px'
}).show();
animatePoof();
jQuery( this ).parent().parent().fadeOut(250);
var ajaxParams = {
plugin: jQuery( this ).attr( 'id' )
};
WPtouchAdminAjax( 'dismiss-warning', ajaxParams, function( result ) {
if ( result == '0' ) {
jQuery( 'tr#board-warnings' ).remove();
} else {
jQuery( 'tr#board-warnings td.box-table-number' ).html( result );	}	jQuery( '#setting_warnings-and-conflicts' ).load(
WPtouchCustom.plugin_url + ' #setting_warnings-and-conflicts fieldset',
function() {	WPtouchSetupPluginDismiss();
}
);
});	return false;
});	}
}
function WPtouchReloadThemeArea() {
jQuery( '#bnc-form' ).load( WPtouchCustom.plugin_url + ' #bnc', function( d ) {
jQuery( "#setting-installed-themes" ).css( { display: 'block' });
WPtouchProAdminReady();
jQuery( '#pane-content-pane-2 .right-area' ).animate( { opacity: 1 } );
});	}
function WPtouchTooltipSetup() {
jQuery( 'a.wptouch-tooltip' ).tooltip( { effect: 'fade', position: 'top right', offset: [-12, -10], tip: '#wptouch-tooltip' });	jQuery( 'a.wptouch-tooltip-left' ).tooltip( { effect: 'fade', position: 'top left', offset: [-10, 7], tip: '#wptouch-tooltip-left' });
jQuery( 'a.wptouch-tooltip-center' ).tooltip( { effect: 'fade', position: 'top center', offset: [-15, 0], tip: '#wptouch-tooltip-center' });	}
function WPtouchCookieSetup() {
jQuery( '#wptouch-top-menu li a' ).unbind( 'click' ).click( function() {
var tabId = jQuery( this ).attr( "id" );
jQuery.cookie( 'wptouch-tab', tabId );
jQuery( '.pane-content' ).hide();
jQuery( '#pane-content-' + tabId ).show();
jQuery( '#pane-content-' + tabId + ' .left-area li a:first' ).click();
jQuery( '#wptouch-top-menu li a' ).removeClass( 'active' );
jQuery( '#wptouch-top-menu li a' ).removeClass( 'round-top-6' );
jQuery( this ).addClass( 'active' );
jQuery( this ).addClass( 'round-top-6' );
return false;
});
jQuery( '#wptouch-admin-form .left-area li a' ).unbind( 'click' ).click( function() {
var relAttr = jQuery( this ).attr( "rel" );
jQuery.cookie( 'wptouch-list', relAttr );
jQuery( ".setting-right-section" ).hide();
jQuery( "#setting-" + relAttr ).show();
jQuery( '#wptouch-admin-form .left-area li a' ).removeClass( 'active' );
jQuery( this ).addClass( 'active' );
if ( jQuery( this ).attr( 'id' ) == 'tab-section-backup-restore' ) {
WPtouchHandleBackupClipboard();	wptouchClip.show();
} else {
if ( wptouchClip ) {
wptouchClip.hide();
}
}
return false;
});
var tabCookie = jQuery.cookie( 'wptouch-tab' );
if ( tabCookie ) {
var tabLink = jQuery( "#wptouch-top-menu li a[id='" + tabCookie + "']" );
jQuery( '.pane-content' ).hide();
jQuery( '#pane-content-' + tabCookie ).show();	tabLink.addClass( 'active' );
tabLink.addClass( 'round-top-6' );
var listCookie = jQuery.cookie( 'wptouch-list' );
if ( listCookie ) {
var menuLink = jQuery( "#wptouch-admin-form .left-area li a[rel='" + listCookie + "']");
jQuery( ".setting-right-section" ).hide();
jQuery( "#setting-" + listCookie ).show();	jQuery( '#wptouch-admin-form .left-area li a' ).removeClass( 'active' );	menuLink.click();	} else {
jQuery( "#wptouch-admin-form .left-area li a:first" ).click();
}
} else {
jQuery( '#wptouch-top-menu li a:first' ).click();
}	}
function WPtouchSetupThemeSettings() {	jQuery( 'a.theme-settings' ).unbind( 'click' ).unbind( 'click' ).click( function() {
jQuery( 'a#pane-3' ).click();
return false;
});	}
function WPtouchSetupActivateThemes() {	jQuery( 'a.activate-theme' ).unbind( 'click' ).unbind( 'click ').click( function() {
jQuery( '#pane-content-pane-2 .right-area' ).animate( { opacity: 0.45 } );	jQuery( '#ajax-saving' ).fadeIn( 350 );
var themeLocation = jQuery( this ).parent().find( 'input.theme-location' ).attr( 'value' );
var themeName = jQuery( this ).parent().find( 'input.theme-name' ).attr( 'value' );
var ajaxParams = {
name: themeName,
location: themeLocation
};
WPtouchAdminAjax( 'activate-theme', ajaxParams, function( result ) {
setTimeout( function() {
jQuery( "#ajax-saving" ).hide();
jQuery( "#ajax-saved" ).show();
}, 3000);
setTimeout( function() {
jQuery( '#ajax-saved' ).fadeOut(350);
}, 4000);
WPtouchReloadThemeArea();
});
return false;
});	}
function WPtouchSetupCopyThemes() {
jQuery( 'a.copy-theme' ).unbind( 'click' ).unbind( 'click' ).click( function() {
jQuery( '#ajax-saving' ).fadeIn( 300 );	jQuery( '#pane-content-pane-2 .right-area' ).animate( { opacity: 0.5 } );
var themeLocation = jQuery( this ).parent().find( 'input.theme-location' ).attr( 'value' );
var themeName = jQuery( this ).parent().find( 'input.theme-name' ).attr( 'value' );
var ajaxParams = {
name: themeName,
location: themeLocation	};
setTimeout( function() {
jQuery( '#ajax-saving' ).hide();
jQuery( '#ajax-saved' ).show();
}, 2500);
setTimeout( function() {
jQuery( '#ajax-saved' ).fadeOut(500);
}, 3000);
WPtouchAdminAjax( 'copy-theme', ajaxParams, function( result ) {
WPtouchReloadThemeArea();
});
return false;
});	}
function WPtouchSetupDeleteThemes() {
jQuery( 'a.delete-theme' ).unbind( 'click' ).click( function(e) {
var answer = confirm( WPtouchCustom.are_you_sure_delete );
if ( answer ) {
var xOffset = 24;
var yOffset = 24;
jQuery(this).parent().parent().fadeOut( 500 );
jQuery('#bnc .poof').css({
left: e.pageX - xOffset + 'px',
top: e.pageY - yOffset + 'px'
}).show();
animatePoof();
jQuery( '#ajax-saving' ).fadeIn( 300 );
setTimeout( function() {
jQuery( '#ajax-saving' ).hide();
jQuery( '#ajax-saved' ).show().fadeOut(300);
}, 1000);
var themeLocation = jQuery( this ).parent().find( 'input.theme-location' ).attr( 'value' );
var themeName = jQuery( this ).parent().find( 'input.theme-name' ).attr( 'value' );
var ajaxParams = {
name: themeName,
location: themeLocation	};
WPtouchAdminAjax( 'delete-theme', ajaxParams, function( result ) {
WPtouchReloadThemeArea();
});	}
return false;
});	}
function WPtouchCheckApiServer() {
WPtouchAdminAjax( 'check-api-server', {}, function( result ) {
jQuery( '#wptouch-api-server-check' ).html( result );
});	}
function WPtouchSetupPluginCompat() {
jQuery( 'a.regenerate-plugin-list' ).unbind( 'click' ).click( function() {
jQuery( '.section-plugin-compatibility' ).animate( { opacity: 0.5 } );
WPtouchAdminAjax( 'regenerate-plugin-list', {}, function( result ) {
jQuery( '.section-plugin-compatibility' ).load( WPtouchCustom.plugin_url + " .section-plugin-compatibility fieldset", function( a ) {
jQuery( '.section-plugin-compatibility' ).animate( { opacity: 1.0 } );
WPtouchSetupPluginCompat();
});
});
return false;
});	}
function wptouchLoadSupportPosts() {	var wptouchboardSupport = jQuery( '#support-threads-box-ajax' );
if ( wptouchboardSupport.length ) {
WPtouchAdminAjax( 'support-posts', {}, function( result ) {
setTimeout( function() { jQuery( '#support-threads-box' ).removeClass( 'loading' );}, 750);
wptouchboardSupport.hide();
wptouchboardSupport.html( result );
wptouchboardSupport.fadeIn( 500 );
});	}	}
function wptouchCheckHomePageRedirect() {
if ( jQuery( '#enable_home_page_redirect' ).attr( 'checked' ) ) {
jQuery( '#home_page_redirect_target' ).parent().fadeIn();
} else {
jQuery( '#home_page_redirect_target' ).parent().fadeOut();	}	}
function wptouchCheckSwitchDestination() {
if ( jQuery( '#show_switch_link' ).attr( 'checked' ) ) {
jQuery( '#setting_home_page_redirect_address' ).fadeIn();
} else {
jQuery( '#setting_home_page_redirect_address' ).fadeOut();	}	}
function wptouchCheckWebAppEnabled() {
if ( jQuery( 'input#classic_webapp_enabled' ).attr( 'checked' ) ) {
jQuery( '#setting_classic_webapp_enabled' ).parent().children().show();
} else {
jQuery( '#setting_classic_webapp_enabled' ).parent().children().not( '#setting_classic_webapp_enabled' ).not( 'legend' ).hide();	}	}
function wptouchSetupTabSwitching() {
var adminTabSwitchLinks = jQuery( 'a.wptouch-admin-switch' );
if ( adminTabSwitchLinks.length ) {
adminTabSwitchLinks.unbind( 'click' ).click( function() {
var targetTabId = '';
var targetArea = jQuery( this ).attr( 'rel' );
if ( targetArea == 'themes' ) {
targetTabId = 'pane-theme-browser';
targetTabSection = 'tab-section-installed-themes';
} else if ( targetArea == 'icons' ) {
targetTabId = 'pane-menu-icons';
targetTabSection = 'tab-section-menu-and-icon-setup';
} else if ( targetArea == 'icon-sets' ) {
targetTabId = 'pane-menu-icons';
targetTabSection = 'tab-section-upload_icons_and_sets';	} else if ( targetArea == 'licenses' ) {
targetTabId = 'pane-bncid-licenses';
targetTabSection = 'tab-section-manage-licenses';	} else if ( targetArea == 'plugin-conflicts' ) {
targetTabId = 'pane-general';
targetTabSection = 'tab-section-compatibility';	}
jQuery( '#wptouch-tabbed-area' ).animate( { opacity: 0.5 }, 500 );
setTimeout( function() {	jQuery( 'a.' + targetTabId ).click();
jQuery( 'a#' + targetTabSection ).click();	jQuery( '#wptouch-tabbed-area' ).animate( { opacity: 1.0 }, 500 );
},
600 );
return false;
});	}	}
function WPtouchChangeDebugLog() {
var debugLogCheckbox = jQuery( 'input#debug_log' );
if ( debugLogCheckbox.attr( "checked" ) ) {
jQuery( '#setting_debug_log_level' ).fadeIn();
} else {
jQuery( '#setting_debug_log_level' ).hide();
}	}
function WPtouchDoManageStatus( header, status, all_done, class_to_add ) {
setTimeout(
function() {
jQuery( '#manage-status' ).removeClass().addClass( class_to_add );
if ( all_done ) {
jQuery( '#manage-status h6' ).removeClass().addClass( 'end' ).html( header );
} else {
jQuery( '#manage-status h6' ).removeClass().html( header );
}
jQuery( '#manage-status p.info' ).html( status );	if ( all_done ) {
jQuery( '#manage-spinner' ).hide();	jQuery( '#manage-set-upload-name' ).hide();	} else {
jQuery( '#manage-spinner' ).show();	}	},
250
);	}
function WPtouchDoTreeDisable() {
jQuery( 'ul.icon-menu input.checkbox' ).attr( "disabled", false );
var enabledCheckboxes = jQuery( 'ul.icon-menu input.checkbox:not(:checked)' );
enabledCheckboxes.each( function() {
var parentItems = jQuery(this).parents( "li" );
jQuery( parentItems.get(0) ).find( "ul input.checkbox" ).attr( "disabled", true );
});
}
function WPtouchSetupIconDragDrag() {
jQuery( '#wptouch-icon-list img' ).draggable( {
revert: true,
cursorAt: { top: 0 },
revertDuration: 150
} );	jQuery( '#wptouch-icon-menu div.icon-drop-target' ).droppable( {
drop: function( event, ui ) {
var droppedDiv = jQuery( this );
var sourceIcon = ui.draggable.attr( 'src' );
var menuId = jQuery( this ).attr( "title" );
var parentListItem = jQuery( this ).parent();
var imageHtml = '<img src="' + sourceIcon + '" />';
droppedDiv.html( imageHtml );	droppedDiv.addClass( 'noborder' );	if ( jQuery( '#wptouch-icon-list ul li:first' ).hasClass('dark' ) ) {
droppedDiv.addClass( 'dark' );
} else {
droppedDiv.removeClass( 'dark' );
}	var ajaxParams = {
title: droppedDiv.attr( "title" ),
icon: sourceIcon
};
WPtouchAdminAjax( 'set-menu-icon', ajaxParams, function( result ) {
if ( parentListItem.hasClass( 'default-prototype' ) ) {
jQuery( 'div.icon-drop-target.default' ).html( imageHtml );
if ( jQuery( '#wptouch-icon-list ul li:first' ).hasClass('dark' ) ) {
jQuery( 'div.icon-drop-target.default' ).addClass( 'dark' );
} else {
jQuery( 'div.icon-drop-target.default' ).removeClass( 'dark' );
}
}	droppedDiv.removeClass( 'default' );
});
WPtouchSetupIconDragDrag();
},
hoverClass: 'active-drop'
});	jQuery( '#wptouch-icon-menu div.icon-drop-target' ).draggable( {
revert: true,
cursorAt: { top: 0 },
revertDuration: 150,
scope: 'trash'
} );	jQuery( '#remove-icon-area' ).droppable( {
drop: function( event, ui ) {
var menuID = ui.draggable.attr( "title" );
var ajaxParams = {
title: menuID
};
WPtouchAdminAjax( 'remove-menu-icon', ajaxParams, function( result ) {
ui.draggable.html( '<img src="' + result + '" alt="" />' );
jQuery('#bnc .poof').css({
left: ui.offset.left + 'px',
top: ui.offset.top + 'px'
}).show();
animatePoof();
ui.draggable.addClass( 'default' );
var currentDefaultImage = jQuery( 'li.default-prototype div').html();
ui.draggable.html( currentDefaultImage );
});	},
scope: 'trash',
hoverClass: 'active-trash'
});
}
function WPtouchAdminAjax( actionName, actionParams, callback ) {	var ajaxData = {
action: "wptouch_ajax",
wptouch_action: actionName,
wptouch_nonce: WPtouchCustom.admin_nonce
};
for ( name in actionParams ) { ajaxData[name] = actionParams[name]; }
jQuery.post( ajaxurl, ajaxData, function( result ) {
callback( result );	});	}
function WPtouchSetupLicenseArea() {	jQuery( 'a.wptouch-remove-license' ).unbind('click').click( function() {
var siteToRemove = jQuery( this ).attr( "rel" );
jQuery( '#wptouch-license-area' ).animate( { opacity: 0.5 } ).append( '<div id="loading-big"></div>' );
var ajaxParams = {
site: siteToRemove	};
WPtouchAdminAjax( 'remove-license', ajaxParams, function(data) {
var reloadURL =  jQuery(location).attr('href');
window.location = ( reloadURL );
});
return false;
});
jQuery( 'a.wptouch-add-license' ).unbind('click').click( function() {
jQuery( 'a.wptouch-add-license' ).remove();
jQuery( '#wptouch-license-area' ).animate( { opacity: 0.5 } ).append( '<div id="loading-big"></div>' );
WPtouchAdminAjax( 'activate-license', {}, function(data) {
var reloadURL =  jQuery(location).attr('href');
window.location = ( reloadURL );
});
return false;
});	jQuery( 'a.configure-licenses' ).unbind( "click" ).click( function() {
jQuery( '#tab-section-manage-licenses' ).click();
return false;
});
}
function WPtouchAjaxOn() {
jQuery( '#ajax-loading' ).fadeIn(300);
}
function WPtouchAjaxOff() {
jQuery( '#ajax-loading' ).fadeOut(300);	}
function statusActivateTabLink() {
jQuery( 'a#status-target-pane-5' ).unbind( 'click' ).click( function() {
jQuery( 'a.pane-bncid-licenses' ).click();
jQuery( 'a.configure-licenses' ).click();
return false;
});
}
function animatePoof() {
var bgTop = 0;	var frames = 5;	var frameSize = 32;
var frameRate = 80;
for( i=1; i<frames; i++ ) {
jQuery('#bnc .poof').animate({
backgroundPosition: '0 ' + (bgTop - frameSize) + 'px'
}, frameRate);
bgTop -= frameSize;
}
setTimeout("jQuery('#bnc .poof').hide();", frames * frameRate);
}
function inputSetBorderColor() {
jQuery( '.section-body-style-settings input.text' ).each( function() {
var inputColor = '#' + jQuery( this ).val();
jQuery( this ).css( 'color', inputColor );
jQuery( this ).css( 'border-color', inputColor );
jQuery( this ).parent().find( 'label' ).css( 'color', inputColor );
});
}
function inputSetBorderColorOnChange() {
jQuery( '.section-body-style-settings input.text' ).change( function () {
var inputColor = '#' + jQuery( this ).val();
jQuery( this ).css( 'color', inputColor );
jQuery( this ).css( 'border-color', inputColor );
jQuery( this ).parent().find( 'label' ).css( 'color', inputColor );
});
}
function selectAllText(textbox) {
textbox.focus();
textbox.select();
}
function WPtouchShowWhenCheckboxEnabled( checkboxSelector, showHideSelector ) {
jQuery( checkboxSelector ).change( function() {
if ( jQuery( checkboxSelector ).attr( 'checked' ) ) {
jQuery( showHideSelector ).show();	} else {
jQuery( showHideSelector ).hide();
}
});	jQuery( checkboxSelector ).change();
}
function WPtouchHandleBackupClipboard() {	if ( wptouchClip == 0 && jQuery( '#copy-text-button' ).is(':visible') ) {
wptouchClip = new ZeroClipboard.Client();
wptouchClip.glue( 'copy-text-button' );
var textToCopy = jQuery( '.type-backup textarea' ).text();
wptouchClip.setText( textToCopy );
wptouchClip.addEventListener( 'complete', function( client, text ) {
alert( WPtouchCustom.copying_text );
});	}
}
var win=null;function NewWindow(mypage,myname,w,h,scroll){LeftPosition=(screen.width)?(screen.width-w)/2:0;TopPosition=(screen.height)?(screen.height-h)/2:0;settings='height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+','
win=window.open(mypage,myname,settings)}
jQuery( document ).ready( function() { WPtouchProAdminReady(); } );