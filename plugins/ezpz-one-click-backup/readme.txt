=== EZPZ One Click Backup ===
Contributors: EZPZSolutions, Joe "UncaJoe" Cook
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=JSQGRHN58DXPE
Tags: backup, plugins, wordpress, security, easy
Requires at least: 3.0
Tested up to: 3.1
Stable tag: 0.5.1.1

EZPZ One Click Backup(OCB) is a very easy way to do a complete backup of your entire WordPress site. EZPZ OCB is not compatible with Windows servers.

== Description ==

**EZPZ One Click Backup**, or **EZPZ OCB** as we call it, is a very easy way to do a complete backup of your entire Wordpress site. In fact it's so easy to use there are no required user settings, everything is automatic. Just one click and presto, you'll have a complete backup stored on your server. One more click and you can download the entire backup to your own computer.

If you prefer to download your backup via FTP the path you'll need is also included. **EZPZ OCB** also stores your last backup on the server in case you ever need to download it again.

With the new **EZPZ Easy Restore** restoring your site is a simple two step process.

Now just because no settings are required doesn't mean there are no options. There are several choices that can make your backup the way you want.

1. You can schedule backups ranging from 4 times a day to once per week.
1. The option to choose the timezone your backup's datestamp is based on.
1. Choose one of ten pre-defined datestamp formats for your backup or customize your own.
1. If you're using a shared database you can choose to backup only the tables needed for your WordPress installation.
1. You can choose to exclude selected folders you don't want to include in the backup.
1. Backup everything or just the most frequently modified files in the wp-content folder.
1. You can choose to completely deny web browser access to your backup.
1. You can adjust the speed of **EZPZ OCB** to best match your server's capabilities.
1. You can choose to remove the color and font styling from the backup progress page.
1. You can enable error logging to help track down compatibility issues.

Like most applications **EZPZ OCB** has certain limitations and requirements. First and foremost, **EZPZ OCB only works on Linux servers running PHP 5 and above** and only those servers which allow certain required php functions with exec and mysqldump seeming to be the most frequently unavailable ones.

Most WordPress users will have no problems but there are some servers with which **EZPZ OCB** is simply incompatible. Sorry...

On the drawing board...

* Internationalization.
* Amazon S3 (Simple Storage Service) integration.

== Installation ==

1. Upload 'ezpz-one-click-backup' to the '/wp-content/plugins/' directory
1. Activate **EZPZ One Click Backup** through the 'Plugins' menu in WordPress
1. When using Wordpress' auto upgrade it is necessary to deactivate **EZPZ One Click Backup** then reactivate.

== Frequently Asked Questions ==

= Is it really one click? =

Yes and no. The backup can be completed by a single click with absolutely no user settings required.

You will need to make a second click if you choose to download your backup but let's face it, what's the purpose of a backup if you're not keeping it somewhere other than your server.

= What if I get an error? =

Errors sometimes occur. Should this happen simply deactivate then reactivate **EZPZ One Click Backup**

== Screenshots ==

1. A Successful Backup, `/tags/0.5.1.1/images/screenshot-1.png`

2. Failed database backup warning, `/tags/0.5.1.1/images/screenshot-2.png`

3. Failed backup warning, `/tags/0.5.1.1/images/screenshot-3.png`

== Changelog ==

= 0.5.1.1 =
* Fixed folder size calculation bug
* Deactivated Faq and News auto updates until bug fix is found 

= 0.5.0 =
* Added EZPZ Easy Restore capability
* Added auto updated FAQ section
* Added auto updated News section
* Streamlined coding and corrected typos
* Improved error handling

= 0.4.6 =
* Added ability to customize datestamp format
* Added option to block browser downloads of backup files
* Added option to log php errors for troubleshooting purposes
* Removed troublesome asterisk in cron backups
* Added pre-installation compatibility checks for most troublesome issues

= 0.4.5 =
* Added ability to schedule backups using wp-cron
* Timezone bug RESOLVED
* Relocated sql file in backup file for easier locating
* Streamlined coding for smoother operation

= 0.4.2 =
* Added optional datestamp formats
* Added improved timezone support
* Added styling option
* Streamlined coding

= 0.4.0 =
* Added option to exclude folders
* Added option to adjust execution speed
* Added option to backup wp-content folder only
* Added option for more control over database backup

= 0.3.0.2 =
* mysqldump problem RESOLVED

= 0.3.0.1 =
* Storing excess backups bug RESOLVED

= 0.3.0 =
* Improved cross-browser performance
* Now BASH free, All scripting is in PHP/JAVASCRIPT
* Improved timer
* Streamlined code for faster operation
* Now using tgz archive format to improve performance

= 0.2.9 =
* Download saved file bug RESOLVED
* Individualized zip and sql files based on blog name
* Added support for shared databases
* Added elapsed time counter

= 0.2.8 =
* Now compatible with WordPress 2.6 +

= 0.2.5 =
* Public Release

= 0.2.2 =
* Beautified display
* Added visual confirmation of data collection and archive completion

= 0.2.0 =
* IE download bug RESOLVED

= 0.1.2 =
* Download saved backup bug RESOLVED

= 0.1.0 =
* Initial limited release for testing