=== Flexi Quote Rotator ===
Version 0.3.2
Contributors: acurran
Donate link: http://sww.co.nz/payments/
Tags: quotes, quotation, quote, quotations, testimony, testimonies, random quotes, random, rotating, quotation, plugin, shortcode, template, display
Requires at least: 2.1
Tested up to: 3.1
Stable tag: 0.3.2


A plugin for displaying quotes or testimonials or other rotating snippets of content.

== Description ==

Based on [Luke Howell's](http://www.lukehowell.com/wordpress/quote-rotator/) *quote rotator* plugin, the *flexi quote rotator* plugin allows you to add the quotations to your site using a shortcode or php snippet in template instead of only as a widget. Also adds a settings panel to the admin and provides additional flexibility with styling.

You can use this plugin to display quotes or testimonials or other rotating snippets of content on your web site. The quotes are entered in the admin area and can be displayed using a widget, a shortcode or php snippet. The quotes will rotate with a fade transition on each changeover. 

== Change Log ==

Version 0.3.2  (28 Mar 2011)
> Resolved issue with height jumping around in widget version of quote rotator

Version 0.3.1  (25 Mar 2011)
> Added back in the style sheets that were missing from previous version due to SVN glitch

Version 0.3  (24 Mar 2011)
> * Modified jQuery animation to fix issue with jagged text in IE. 
* Added new options Height Override and Width Override. 
* Added template tag quoteRotator(). 
* Added new widget options.

Version 0.2  (5 Apr 2010)
>  Changed script library used for fading effects from Scriptaculous to jQuery. This should resolve script library conflicts that some users have experienced. Added fix for saving options in WP 2.9 MU. Thanks to colin@brainbits.ca for supplying the code! Also added a new option for fade-out duration. This defaults to 0 so that it behaves like previous versions with no fade-out unless specified.

Version 0.1.3  (17 Mar 2009)
>  Minor update: replaced a PHP shorthand tag, which was causing problem for some users, with full PHP tag, updated readme

Version 0.1.2  (12 Jan 2009)
>  Minor update: updated instructions and screenshots for WordPress 2.7

Version 0.1.1  (4 Nov 2008)
>  Minor update: set default parameters for getQuoteCode() function

Version 0.1  (28 Oct 2008)
>  Initial beta release based on Version 3.5.4 of Quote Rotator by Luke Howell.

== Installation ==

1. Upload 'flexi-quote-rotator' folder to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress

= Updating Plugin =

* **If you had any custom stylesheet and related images, please make sure to save a copy of these before updating, you will need to replace these files.**
* You may have to enter the widget options after upgrading.

= Usage =

* To enter quotations, go to Tools > Quotes
* To display the quote rotator on a web page you have 3 options:

> 1. Use the widget created (Design > Widgets)
> 2. Add this shortcode to your page or post content:  
>    `[quoteRotator title="{optional title}" delay="{delay in seconds, optional}" fade="{fade-in duration in seconds, optional}" fadeout="{fade-out duration in seconds, optional}"]`  
> e.g.1: `[quoteRotator]`  
> e.g.2: `[quoteRotator title="Testimonials" delay="8" fade="4" fadeout="2"]`  
> 3. Insert a template tag in a template file:  
>    `quoteRotator({optional title}, {delay in seconds, optional}, {fade-in duration in seconds, optional}, {fade-out duration in seconds, optional});`  
> e.g.1: `<?php echo quoteRotator(); ?>`  
> e.g.2: `<?php echo quoteRotator("Testimonials", 8, 4, 2); ?>`

* The settings can be edited at Settings > Quote Rotator. Or, if you are using the widget they can be edited in the widget. Settings entered directly in shortcode or PHP override the settings saved in the administration settings.

Styling:

This plugin allows full styling flexibility using CSS to control how the quotes are displayed on your web site. A few example stylesheets are included in the styles folder (/wp-content/plugins/flexi-quote-rotator/styles/). One of these can be selected in the settings admin panel. You can copy and modify one of these stylesheets to achieve the desired look. Then you save it in the styles folder and it will become an available for selection in the settings admin panel. Photoshop source files are also provided if you want to modify the provided background images.

== Frequently Asked Questions ==
= Where do I add my quotes? =
Under the "Manage" tab of the admin page, there is a "Quotes" subpage.
= Can I have more than one quote areas on a page? =
No, this plugin is not designed to handle more than one quote areas on an individual page.
= There appears to be more than one way of controlling the settings such as fade, delay, etc. Which takes precedence? =
It depends on the method used to display the quotes - if the original widget method if display is used, then the widget settings are used. If
the shortcode or PHP methods of display are used, the settings saved in Settings > Quote Rotator are used but these can be overidden by the optional attributes passed to shortcode or PHP.
= Can I put HTML code in the quote? =
Yes, you can put HTML code into the quote and also into the quote author field (which is useful if you want to link to the quote author's web site)

== Screenshots ==
1. Example of how flexi quote rotator can be displayed on a web page
2. Settings panel in admin
3. Management panel in admin
