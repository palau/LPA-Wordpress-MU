<?php

/*
  Plugin Name: EZPZ One Click Backup
  Plugin URI: http://ezpzsolutions.net/ezpz-wordpress-plugins/ezpz-one-click-backup
  Description: EZPZ One Click Backup(OCB) is a very easy way to do a complete backup of your entire WordPress site. In fact it's so easy there are absolutely no required user settings, everything's automatic. <strong>When using WordPress' auto upgrade it is necessary to deactivate then reactivate EZPZ One Click Backup</strong>.
  Author: Joe 'UncaJoe' Cook
  Version: 0.5.1.1
  Author URI: http://ezpzsolutions.net
 */

function ezpz_ocb_version() {
    return "0.5.1.1";
}

/*  Copyright 2011

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

// Pre-2.6 compatibility

if (!defined('WP_CONTENT_URL'))
    define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content');

if (!defined('WP_CONTENT_DIR'))
    define('WP_CONTENT_DIR', ABSPATH . 'wp-content');

if (!defined('WP_PLUGIN_URL'))
    define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins');

if (!defined('WP_PLUGIN_DIR'))
    define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');

require_once('functions/ezpz-ocb-functions.php'); //get the functions page.

register_activation_hook(__FILE__, 'ezpz_ocb_installer');

register_deactivation_hook(__FILE__, 'ezpz_ocb_uninstall');

add_action('admin_menu', 'ezpz_ocb_plugin_menu');

add_action('ezpz_ocb_cron', 'ezpz_ocb_run_cron');

add_action('ezpz_ocb_updates', 'ezpz_ocb_updates');

add_action('admin_notices', 'ezpz_ocb_admin_notices');

add_filter('cron_schedules', 'custom_cron_schedules');

// ezpz_ocb_check_updates();

function ezpz_ocb_installer() {

    // Compatibility pre-checks

    $die_message = '';
    $server_os = php_uname('s');

    if (strtolower(substr($server_os, 0, 7)) == 'windows') {
        $windows_os = true;
        $die_message = $die_message . "<li>EZPZ One Click Backup is not compatible with your " . php_uname('s') . " server.</li>";
    }

    if (!function_exists(exec) && !$windows_os) {
        $die_message = $die_message . "<li>Your $server_os server has disabled the <em>exec</em> function.</li>";
    }

    if (!function_exists(mkdir) && !$windows_os) {
        $die_message = $die_message . "<li>Your $server_os server has disabled the <em>mkdir</em> function.</li>";
    }

    if ($die_message != '') {
        die($die_message);
    }

    global $wpdb;

    $plugin_bu_path = WP_PLUGIN_DIR . "/" . ezpz_ocb_slug() . "/backups";

    if (!file_exists($plugin_bu_path)) {
        $cmd = "mkdir $plugin_path";
        exec($cmd);
    }

    if (get_option('ezpz_ocb_hide_backup') != 'yes') {
        if (!file_exists($plugin_bu_path . '/htaccess.txt')) {
            file_put_contents($plugin_bu_path . '/htaccess.txt', "deny from all");
        }
    } else {
        if (!file_exists($plugin_bu_path . '/.htaccess')) {
            file_put_contents($plugin_bu_path . '/.htaccess', "deny from all");
        }
    }

    // Set random folder name and path
    $rnd_dir = WP_PLUGIN_DIR . '/' . ezpz_ocb_slug() . '/backups/' . rnd_alpha_numeric(rand(12, 18));

    $zip_date = "2011-01-01";

    $table_name = $wpdb->prefix . "ezpz_ocb_settings";

    $blog_path = str_replace('/wp-content/plugins', '', WP_PLUGIN_DIR);

    if (!get_option('ezpz_ocb_rnd_key')) {
        $cmd = "mkdir $rnd_dir";
        update_option('ezpz_ocb_rnd_key', $rnd_dir);
    } else {
        $cmd = "mkdir " . get_option('ezpz_ocb_rnd_key');
    }

    exec($cmd);

    set_new_date($zip_date);


    $blog_tz = get_option('timezone_string');
    if ($blog_tz == '') {
        $blog_tz = 'GMT';
    }

    if (!get_option('ezpz_ocb_zip_date')) {
        update_option('ezpz_ocb_zip_date', $zip_date);
    }

    if (!get_option('ezpz_ocb_set_cron')) {
        update_option('ezpz_ocb_set_cron', 'off');
    }

    if (!get_option('ezpz_ocb_cron_time')) {
        update_option('ezpz_ocb_cron_time', '0');
    }

    if (!get_option('ezpz_ocb_prefix_only')) {
        update_option('ezpz_ocb_prefix_only', 'no');
    }
    if (!get_option('ezpz_ocb_excluded_folders')) {
        update_option('ezpz_ocb_excluded_folders', 'none');
    }

    if (!get_option('ezpz_ocb_speed_factor')) {
        update_option('ezpz_ocb_speed_factor', '6');
    }

    if (!get_option('ezpz_ocb_stylized')) {
        update_option('ezpz_ocb_stylized', 'yes');
    }

    if (!get_option('ezpz_ocb_save_tz')) {
        update_option('ezpz_ocb_save_tz', $blog_tz);
    }

    if (!get_option('ezpz_ocb_ds_format')) {
        update_option('ezpz_ocb_ds_format', 'Y-m-d');
    }

    if (!get_option('ezpz_ocb_hide_backup')) {
        update_option('ezpz_ocb_hide_backup', 'no');
    }

    if (get_option('ezpz_ocb_backup_everything')) {
        delete_option('ezpz_ocb_backup_everything');
    }

    if (get_option('ezpz_ocb_set_cron') != 'off') {
        $tempTime = date('U', mktime(get_option('ezpz_ocb_cron_time'), 0, 0, date('n'), date('j'), date('Y')));
        wp_schedule_event($tempTime, get_option('ezpz_ocb_set_cron'), 'ezpz_ocb_cron');
    }

    $forbidden_html =
      "
    <!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
    <html>
        <head>
            <meta content='text/html; charset=ISO-8859-1'
                  http-equiv='content-type'>
            <title>Forbidden Area</title>
        </head>
        <body>
            <center>
            <img style='width: 380px; height: 380px;' alt='Forbidden Area'
            src='" . site_url() . "/wp-content/plugins/" . ezpz_ocb_slug() . "/images/forbidden.jpg'>
            </center>
        </body>
    </html>";

    $rnd_dir = get_option('ezpz_ocb_rnd_key');
    $ezpz_ocb_dir = WP_PLUGIN_DIR . '/' . ezpz_ocb_slug();
    $ezpz_ocb_bu_dir = "$ezpz_ocb_dir/backups";
    $ezpz_ocb_bu_rnd_dir = "$rnd_dir";
    $ezpz_ocb_functions_dir = "$ezpz_ocb_dir/functions";
    $ezpz_ocb_images_dir = "$ezpz_ocb_dir/images";
    $ezpz_ocb_pages_dir = "$ezpz_ocb_dir/pages";

    $dir_list = array($ezpz_ocb_dir,
      $ezpz_ocb_bu_dir,
      $ezpz_ocb_bu_rnd_dir,
      $ezpz_ocb_functions_dir,
      $ezpz_ocb_images_dir,
      $ezpz_ocb_pages_dir,);

    foreach ($dir_list as $item) {
        file_put_contents("$item/index.html", $forbidden_html);
    }

    // wp_schedule_event(time(), 'twodays', 'ezpz_ocb_updates');
}

function ezpz_ocb_uninstall() {

    global $wpdb;

    wp_clear_scheduled_hook('ezpz_ocb_cron');

    wp_clear_scheduled_hook('ezpz_ocb_updates');

    remove_action('admin_notices', 'ezpz_ocb_admin_notices');

    $table_name = $wpdb->prefix . "ezpz_ocb_settings";

    $backup_folder_path = WP_PLUGIN_DIR . '/' . ezpz_ocb_slug() . '/backups/';

//    empty_folder($backup_folder_path);

    if (file_exists(WP_PLUGIN_DIR . "/" . ezpz_ocb_slug() . "/error.txt")) {
        $cmd = "rm -r " . WP_PLUGIN_DIR . "/" . ezpz_ocb_slug() . "/error.txt";
        exec($cmd);
    }

    $sqldrop = "DROP TABLE IF EXISTS $table_name";

    $results = $wpdb->query($sqldrop);
}

function ezpz_ocb_plugin_menu() {

    add_menu_page('EZPZ One Click Backup', 'EZPZ OCB', activate_plugins, 'ezpz_ocb', ezpz_ocb_about);
    add_submenu_page('ezpz_ocb', 'EZPZ One Click Backup - Backup', 'Backup Now', activate_plugins, 'ezpz_ocb_backup', ezpz_ocb_backup);
    add_submenu_page('ezpz_ocb', 'EZPZ One Click Backup - Options', 'Choose Options', activate_plugins, 'ezpz_ocb_options', ezpz_ocb_get_options_page);
    add_submenu_page('ezpz_ocb', 'EZPZ One Click Backup - Download', 'Download Now', activate_plugins, 'ezpz_ocb_download', ezpz_ocb_dl_previous_backup);
    add_submenu_page('ezpz_ocb', 'EZPZ One Click Backup - FAQs', 'FAQs', activate_plugins, 'ezpz_ocb_faq', ezpz_ocb_faq);
    add_submenu_page('ezpz_ocb', 'EZPZ One Click Backup - News', 'News', activate_plugins, 'ezpz_ocb_news', ezpz_ocb_news);
}

function ezpz_ocb_about() {
    require_once('pages/ezpz-ocb-about.php'); //get the about page.
}

function ezpz_ocb_backup() {
    require_once('pages/ezpz-ocb-backup.php'); //get the backup page.
}

function ezpz_ocb_get_options_page() {
    require_once('pages/ezpz-ocb-options.php'); //get the options entry page.
}

function ezpz_ocb_run_cron() {
    require_once('pages/ezpz-ocb-cron.php'); //get the cron page.
}

function ezpz_ocb_faq() {
    require_once('pages/ezpz-ocb-faq.php'); //get the faq page.
}

function ezpz_ocb_news() {
    require_once('pages/ezpz-ocb-news.php'); //get the faq page.
}

?>