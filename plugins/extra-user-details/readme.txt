=== Plugin Name ===
Contributors: Vadimk
Tags: plugin, admin, profile, links, social, meta, facebook, author, user, users, fields, details.
Requires at least: 2.0.2
Tested up to: 3.0.1
Stable tag: 0.2

Add extra fields to the user profile page, saved in WordPress' native way (in wp_usermeta).

== Description ==

Extra User Details is the simple plugin that allows you to add extra fields to the user profile page (e.g. Facebook, Twitter, LinkedIn links etc).

Extra fields can be easily accessed in your templates like a general wordpress author details:

`<?php get_user_meta( $userid, $metakey ); ?>`

Plugin saves fields data in wp_usermeta table. You can add and edit extra fields at plugin options section in backend.

== Installation ==

Install it like other plugins, no special actions required.

1. Upload `extra_user_details.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Ready to use. To configure - go to the Users - Extra User Details section

== Frequently Asked Questions ==

= I've found a bug! How do I report? =

Please contact me here http://vadimk.com/contact/.

== Changelog ==

= 0.2 =
* Added ability to change meta_key for any field.
* Now order of custom fields can be easily changed by drag and drop.
* Moved plugin options page to Users tab.
* Improved user interface.
* Fixed bug: extra fields disappeared after update.
* Removed default help text.

= 0.1.1 =
* Improved user interface.
* Fixed bug with extra user details retrieval.
* Fixed bug: extra fields values disappeared after update.

= 0.1 =
* Initial release.