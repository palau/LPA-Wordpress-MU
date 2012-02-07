=== Plugin Name ===
Requires at least: 2.8
Stable tag: 2.0.8.2
Beta tag: 2.0RC1

== Changelog ==

= Version 2.0.8.2 =

* Fixed: An issue where certain filetypes (.mp3, .xls, .pages, etc) would open blank in web-app mode
* Fixed: .aligncenter to images JS (now leaves images under 100px alone)
* Fixed: Typos in WPtouch admin panel
* FIxed: An issue with image files which may prevent copying when upgrading the plugin
* Fixed: An issue with sticky post icons when "none" is selected as the post icon type
* Fixed: An issue with custom field thumbnails on WP 2.8.x installations
* Fixed: An issue that caused Intense Debate and DISQUS comments issues

* Added: Support for new Vimeo HTML5 embeds
* Added: New Web-App notice overlay feature. Let visitors on iDevices know your site is web-app ready
* Added: New Developer options: Client Mode settings to remove license, theme browser and tools and debug settings
* Added: Warning for, and better compatibility with Hyper Cache plugin
* Added: JS to deal with protected images in posts (P3)

* Changed: PixelPress icon set was updated for Retina display (60x60 versions)
* Changed: more retina display tweaks and updates

= Version 2.0.8.1 =

* Fixed: An issue with the height of YouTube and HTML5 videos, new Vimeo embed code
* Fixed: An issue where thumbnails may not display properly with rounded corners
* Fixed: An issue involving SSL admin panels and the inability to license/upgrade

* Added: JS to add .aligncenter to images and captions in posts smaller than 250px in width

* Changed: No longer filtering Intense Debate comments
* Changed: Updated Norwegian, French and Dutch translations

= Version 2.0.8 =

* Added: New setting in General settings to edit regular theme switch link css
* Added: New high-resolution images for iPhone 4 in Classic theme
* Added: New header logo retina img option
* Added: Option in Classic theme to disable header Site Icon
* Added: Option in Classic theme to disable Search button
* Added: Option in Classic to show first image attachment in the post above/below content
* Added: Option in Classic theme to set a custom Calendar icon color
* Added: Option in Classic theme to set preferred WPtouch thumbnail size
* Added: Option in Classic web-app mode to disable persistence
* Added: Settings link on plugins.php page to WPtouch Pro admin
* Added: CSS in Classic theme for code examples in posts
* Added: CSS for Comment Reply Notification plugin
* Added: BlackBerry Torch user agent
* Added: Samsung S8000, Bada user agents
* Added: Swedish translation - Thanks Peter!
* Added: Compatibility option to disable conversion of Menu page URLs to local format

* Changed: Now filtering "Facebook Like" plugin
* Changed: Now filtering "Sharebar" plugin
* Changed: Now filtering "WP Greet Box" plugin
* Changed: Other improved plugin compatibility
* Changed: Increased license server cache time
* Changed: Updated Italian, Spanish, German, Portuguese and Japanese translations

* Fixed: Case where debugging information was reported wrong
* Fixed: "Mailto:" links in web-app mode (Classic and Skeleton)
* Fixed: Some filetypes blanking in web-app mode (Classic and Skeleton)
* Fixed: Floated content issues in Classic post content area
* Fixed: An issue with compat.css and custom CSS files not loading in some situations
* Fixed: An issue where selecting all pages/none checkboxes in admin would prompt for reset
* Fixed: An issue with ajax, admin loading
* Fixed: An issue with license keys in certain SSL-enabled admin panels
* Fixed: An issue with thumbnails on upgraded installations of WPtouch Pro

= Version 2.0.7.1 =

* Fixed: Bugs with ajax, blank 'here' page

= Version 2.0.7 =

* Added: Web-app mode now remembers and loads the last visited post or page visited (persistence)
* Added: Dynamic Contact Form plugin CSS
* Added: Support for WP Thread Comment plugin in Classic
* Added: Domain Path: /lang to plugin file header
* Added: Classic theme style color options
* Added: Classic theme font face and size options
* Added: Classic theme Menu color options
* Added: New admin display for Classic user agents and device classes
* Added: Setting for Classic to show/hide post date in post listings when thumbnails/none are shown
* Added: Ability to load/include functions.php from the active desktop theme
* Added: Ability to dismiss plugin compatibility warnings
* Added: Classic theme text-justification options, preliminary RTL support
* Added: Custom advertising option that allows for user-defined ads/images/code
* Added: Backup/Restore section

* Changed: Clearer text in admin licenses tab
* Changed: Improved speed of admin panel
* Changed: Re-optimized theme and admin images
* Changed: More theme and admin optimizations for speed / load time
* Changed: Using jQuery now with noConflict(), should help some compatibility scenarios in themes and admin
* Changed: Updated readme.txt with installation instructions, added GPL license txt

* Fixed: An issue that could cause the auto-upgrade license to be incorrectly shown
* Fixed: An issue where share/save would not be shown when comments are closed in Classic
* Fixed: Menu CSS issues when icons are not enabled in Classic
* Fixed: Issues with opening some urls, buttons that opened new blank windows
* Fixed: An issue where a PDF, DOC, XLS or a few other file types would open within the browser
* FIxed: An issue which made it difficult to press the menu button in the Classic header
* Fixed: Issue with custom language files in the wptouch-data/lang directory
* Fixed: Bug with new languages not taking affect immediately

= Version 2.0.6 =

* Changed: Style adjustments and fixes to Classic
* Changed: Share/Save to detect current viewport width/height/position accordingly in Classic
* Changed: Removed Search 'GO' button in Classic (causes width issues in some languages)
* Changed: New tab-bar icons, adjustments (larger and easier to select)
* Changed: Converted default comments in Classic to functions.php version under the hood
* Changed: Removed warning for wpSEO - an update to the latest version 2.7.7 fixes the issue
* Changed: Disabled IntenseDebate comments in WPtouch (defaults to regular comments), full support is coming in a future version
* Changed: Default startup.png loading image for Classic web-app mode, now more generic w/o WPtouch branding

* Added: Body classes for portrait, landscape, and web-app mode ('portrait', 'landscape', 'web-app')
* Added: New settings in Classic, toggle showing: single post page tags, cats, author, date, share/save, comments
* Added: Setting in Classic to use relative position for drop-down menu (fixes issue where videos may overlay menu)
* Added: New setting in general to define a path to a custom stylesheet that is loaded in themes
* Added: New setting in General to hide Switch link (will cause switch link NOT to show on mobile or desktop)
* Added: New setting in General to make all links clickable in post content, similar to P2 theme
* Added: New setting in General for a custom 404 message
* Added: Two new background tiles for Classic: 'Grainy' and 'Cog Canvas'
* Added: Warning for 'Featured Content Gallery' plugin
* Added: Warning for 'IntenseDebate' plugin
* Added: wptouch shortcode for targeting mobile/desktop. Usage is [wptouch target="mobile"]your content[/wptouch]. Target can be mobile, webapp, non-webapp, desktop
* Added: Compat.php to remove particularly troublesome plugins from interacting with WPtouch Pro
* Added: Gcons Pack (blue only) from greepit.com
* Added: Glossy eCommerce Icons Pack from starfishwebconsulting.co.uk
* Added: User agents for newer BlackBerry Storm touch devices (9550 and 9520)
* Added: User agent for Froyo (Android 2.2)

* Fixed: Language file warning
* Fixed: Cases where too many redirects issue may occur on some installations
* Fixed: Semi-colon in text areas in admin settings causes settings to become broken
* Fixed: Paginated Comments plugin from breaking WPtouch comments
* Fixed: Telephone numbers should not cause a blank external page in web-app mode
* Fixed: Skip to Comments link failing in Web-App mode
* Fixed: Web-app mode now always shows mobile view when "1st time visitors see desktop theme" is enabled
* Fixed: Issue where clicking on menu icons in web-app mode would force exit

= Version 2.0.5 =

* Fixed: Minor localization issues
* Fixed: White flash on Web-app mode loading
* Fixed: tab links for activation, licenses in admin
* Changed: Wording for Adsense ID area, added info
* Changed: Presentation of menu icons/pages in Classic drop-down
* Changed: Sticky post icon is now a star, not a pin in Classic
* Changed: get_bloginfo( 'siteurl' ) now returns redirect target when defined
* Added: Norwegian translation
* Added: Portuguese translation
* Added: Partial Dutch translation
* Added: Options in Classic to disable "Admin" and "Profile" account tab links
* Added: Options for Calendar icon appearance
* Added: Options to define custom field name for thumbnails
* Added: Option to define a custom header logo image in Classic
* Added: New option for advertising (which views they show on)
* Added: Ability to define a functions.php file in the wptouch-data directory
* Added: wptouch_admin_languages filter to modify the languages drop down in the admin
* Added: Ability to have a custom .mo file in the wptouch-data/lang directory
* Added: Warning if WPMinify plugin is installed and active

= Verison 2.0.4 =

* Fixed: Default theme name of Classic on fresh install
* Fixed: Removed whitespace from end of custom user agents in Skeleton and Classic
* Fixed: Missing spinner icon, broken template link in admin upload icon area
* Fixed: Tabbing input order in Classic, Skeleton themes
* Changed: wptouch_title() - now respects short title, better for bookmarking to home screen
* Changed: Warnings if found stand out more in the admin WPtouchboard
* Changed: Comment bubble placement in Classic, Skeleton themes
* Changed: Only active plugins are shown in the admin plugin compatibility section
* Changed: Order of settings blocks in admin 'Compatibility' area
* Changed: Spaces are converted into dashes for uploaded icons .pngs to ensure working web-app mode icons
* Changed: various styling refinements
* Added: New wptouch_setting_filter_ filters to pre-process all submitted settings
* Added: Options to change menu sort order from page order to alphabetical
* Added: Option to disable Web-App Mode
* Added: Options for custom field thumbnails, simple post thumbnails plugin to Classic

= Verison 2.0.3 =

* Fixed: Icon set link from WPtouchBoard
* FIxed: Removed extra spaces at the ends of a few files
* Fixed: Styling issues with Gravity Forms in Classic, Skeleton
* Fixed: Styling issues with 'show load times' option on in Classic, Skeleton
* Fixed: Styling for alignnone, aligncenter in Classic, Skeleton
* Fixed: Bug in Prowl direct message that stopped after the first API key
* Fixed: Cases where 'Load More Comments' links would not be shown
* Changed: Loading div appearance in Classic theme web-app mode
* Added: New Regionalization section to General settings
* Added: Ability to force a language from the admin panel
* Added: New setting that allows WordPress date format to be used in themes
* Added: Excluded categories setting for Classic theme
* Added: Added ability to enable developer mode for admins only
* Added: Ability to choose between same and Homepage for Switch Link destination
* Added: Palm Pre/Pixi user agent strings (webOS)
* Added: Auto-copy custom icons from WPtouch 1.9.x installs if found

= Version 2.0.2 =

* Fixed: Problem with textareas in admin panel when they contain HTML code
* Fixed: Character encoding problem in admin dashboard
* Fixed: Changed ID class of custom page items to have be of the form 'id-custom-{num}'
* Fixed: Issue where calendar icons were different widths, and did not reflections on iDevices (iPad, iPhone, iPod touch)
* Fixed: Launching email from share area now closes overlay.  Mobile Safari bug still prevents JS from working after that point.
* Fixed: Blank email page for non-web app mode email link in menu
* Changed: Menu icons for pages and links are now clickable, removed :hover state to fix some browser issues
* Changed: CSS related to search icon in tab-bar to fix some browser issues
* Changed: CSS for Disqus and Intense Debate to hide comment bubbles

= Version 2.0.1 =

* Fixed: Verbiage surrounding GPL licenses
* Fixed: Issue with WordPress installs that are not in the root
* Fixed: Google AJAX Translation plugin compatibility
* Fixed: Issue with logo link in Web-App mode
* Fixed: Bug in plugin compatibility section
* Fixed: Added CSS for Banner Cycler plugin compatibility
* Fixed: Whitescreen/error in WordPress 2.8.x
* Fixed: Author URL link for icon sets
* Fixed: Removed various PHP warnings from admin panel
* Fixed: Share on Twitter link in Classic web-app mode
* Fixed: Replaced deprecated link_pages function with wp_link_pages in themes
* Added: Warning for when directories cannot be created
* Changed: Footer 'Powered by' message to match admin setting
* Updated: Language files for Italian, German, Japanese, Spanish and French

= Version 2.0 =

* First release

== Additional Information ==

* Visit the official WPtouch Pro page at http://wptouch.com
