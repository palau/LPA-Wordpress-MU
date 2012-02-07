<?php
global $wpdb;

$backup_folder_path = WP_PLUGIN_DIR . '/' . ezpz_ocb_slug() . '/backups';



// variables for the field and option names
$opt_name = array(
  'db_dump' => 'ezpz_ocb_db_dump',
  'set_cron' => 'ezpz_ocb_set_cron',
  'cron_time' => 'ezpz_ocb_cron_time',
  'cron_day' => 'ezpz_ocb_cron_day',
  'excluded_folders' => 'ezpz_ocb_excluded_folders',
  'prefix_only' => 'ezpz_ocb_prefix_only',
  'speed_factor' => 'ezpz_ocb_speed_factor',
  'stylized' => 'ezpz_ocb_stylized',
  'save_tz' => 'ezpz_ocb_save_tz',
  'hide_backup' => 'ezpz_ocb_hide_backup',
  'log_errors' => 'ezpz_ocb_log_errors',
  'ds_format' => 'ezpz_ocb_ds_format');

$hidden_field_name = 'ezpz_ocb_submit_hidden';

if (get_option('ezpz_ocb_db_dump') == 'alt') {
    $posted_prefix = "";
} else {
    $posted_prefix = $_POST[$opt_name['prefix_only']];
}

// Read in existing option value from database
$opt_val = array(
  'db_dump' => get_option($opt_name['db_dump']),
  'set_cron' => get_option($opt_name['set_cron']),
  'cron_day' => get_option($opt_name['cron_day']),
  'cron_time' => get_option($opt_name['cron_time']),
  'excluded_folders' => get_option($opt_name['excluded_folders']),
  'prefix_only' => $posted_prefix,
  'speed_factor' => get_option($opt_name['speed_factor']),
  'stylized' => get_option($opt_name['stylized']),
  'save_tz' => get_option($opt_name['save_tz']),
  'hide_backup' => get_option($opt_name['hide_backup']),
  'log_errors' => get_option($opt_name['log_errors']),
  'ds_format' => get_option($opt_name['ds_format']));

// See if the user has posted us some information
// If they did, this hidden field will be set to 'Y'
if (isset($_POST[$hidden_field_name]) && $_POST[$hidden_field_name] == 'Y') {
    // Read their posted value

    $opt_val = array(
      'db_dump' => $_POST[$opt_name['db_dump']],
      'set_cron' => $_POST[$opt_name['set_cron']],
      'cron_time' => $_POST[$opt_name['cron_time']],
      'cron_day' => $_POST[$opt_name['cron_day']],
      'excluded_folders' => $_POST[$opt_name['excluded_folders']],
      'prefix_only' => $_POST[$opt_name['prefix_only']],
      'speed_factor' => $_POST[$opt_name['speed_factor']],
      'stylized' => $_POST[$opt_name['stylized']],
      'save_tz' => $_POST[$opt_name['save_tz']],
      'hide_backup' => $_POST[$opt_name['hide_backup']],
      'ds_format' => $_POST[$opt_name['ds_format']],
      'log_errors' => $_POST[$opt_name['log_errors']],
      'tmp_ds_format' => $_POST['tmp_ds_format']);

    if ($opt_val['tmp_ds_format'] != get_option('ezpz_ocb_ds_format')) {
        $opt_val['tmp_ds_format'] = preg_replace("#[^0-9a-zA-Z\_\.\-\,\@\s]#", "", $opt_val['tmp_ds_format']);
        $opt_val['tmp_ds_format'] = str_replace(" ", "_", $opt_val['tmp_ds_format']);
        $opt_val['tmp_ds_format'] = str_replace("\\", "", $opt_val['tmp_ds_format']);
        $opt_val['ds_format'] = $opt_val['tmp_ds_format'];
    }



    if ($opt_val['set_cron'] != get_option('ezpz_ocb_set_cron') || $opt_val['cron_time'] != get_option('ezpz_ocb_cron_time')) {

        if (get_option('timezone_string') == '') {
            $default_tz = 'GMT';
            $blog_tz = "GMT";
            $gmt_offset = get_option('gmt_offset');
            if ($gmt_offset > 0) {
                $gmt_offset = "+" . $gmt_offset;
            }
            $gmt_offset = str_replace('.5', ':30', $gmt_offset);
            $gmt_offset = str_replace('.75', ':45', $gmt_offset);
            $blog_tz_adjusted = "<b>UTC$gmt_offset</b> so <b>GMT</b> will be used as default";
            $pseudo_tz = 'GMT';
        } else {

            $default_tz = get_option('timezone_string');
            $blog_tz = get_option('timezone_string');
            $blog_tz_adjusted = "<b>$blog_tz</b>";
            $pseudo_tz = '';
        }

        $ezpz_tz = get_option('ezpz_ocb_save_tz');

        if ($ezpz_tz != 'DISABLED' && $ezpz_tz != "") {
            $dateSrc = date('Y-m-d H:i:s');


            $ezpz_date = new DateTime($dateSrc, new DateTimeZone('GMT'));
            $ezpz_date->setTimeZone(new DateTimeZone($ezpz_tz));
        } else {
            $dateSrc = date('Y-m-d H:i:s');


            $ezpz_date = new DateTime($dateSrc, new DateTimeZone('GMT'));
            $ezpz_date->setTimeZone(new DateTimeZone('GMT'));
        }
        wp_clear_scheduled_hook('ezpz_ocb_cron');

        if ($opt_val['set_cron'] != 'off') {
            $hour = $opt_val['cron_time'];
            $month = $ezpz_date->format('n');
            $day = $ezpz_date->format('j');
            $year = $ezpz_date->format('Y');
            if (get_option('ezpz_ocb_set_cron') == 'weekly') {
                update_option('ezpz_ocb_cron_day', $ezpz_date->format('l'));
            }
            $cron_time = date('U', mktime($hour, 0, 0, $month, $day, $year));

            wp_schedule_event($cron_time, $opt_val['set_cron'], 'ezpz_ocb_cron');
        }
    }

    if ($opt_val['hide_backup'] != get_option('ezpz_ocb_hide_backup')) {
        $hide_bu = $backup_folder_path . "/.htaccess";
        $show_bu = $backup_folder_path . "/htaccess.txt";
        if ($opt_val['hide_backup'] != 'yes') { //
            if (file_exists($hide_bu)) { // show backup
                rename($hide_bu, $show_bu);
            }
        } elseif (file_exists($show_bu)) { // hide backup
            rename($show_bu, $hide_bu);
        }
    }

// Save the posted value in the database
    update_option($opt_name['db_dump'], $opt_val['db_dump']);
    update_option($opt_name['set_cron'], $opt_val['set_cron']);
    update_option($opt_name['cron_time'], $opt_val['cron_time']);
    update_option($opt_name['excluded_folders'], $opt_val['excluded_folders']);
    update_option($opt_name['prefix_only'], $opt_val['prefix_only']);
    update_option($opt_name['speed_factor'], $opt_val['speed_factor']);
    update_option($opt_name['stylized'], $opt_val['stylized']);
    update_option($opt_name['save_tz'], $opt_val['save_tz']);
    update_option($opt_name['hide_backup'], $opt_val['hide_backup']);
    update_option($opt_name['log_errors'], $opt_val['log_errors']);
    update_option($opt_name['ds_format'], $opt_val['ds_format']);


// Put an options updated message on the screen
    echo '<div style="background-color:#ffffe0;
             border-color:#e6db55;
             border-width:1px;
             border-style:solid;
             padding:0 .6em;
             margin:5px 15px 2px;
             -moz-border-radius:3px;
             -khtml-border-radius:3px;
             -webkit-border-radius:3px;
             border-radius:3px;" >
            <p><strong>Options saved.</strong></p></div>';
}


if (get_option('timezone_string') == '') {
    $default_tz = 'GMT';
    $blog_tz = "GMT";
    $gmt_offset = get_option('gmt_offset');
    if ($gmt_offset > 0) {
        $gmt_offset = "+" . $gmt_offset;
    }
    $gmt_offset = str_replace('.5', ':30', $gmt_offset);
    $gmt_offset = str_replace('.75', ':45', $gmt_offset);
    $blog_tz_adjusted = "<b>UTC$gmt_offset</b> so <b>GMT</b> will be used as default";
    $pseudo_tz = 'GMT';
} else {

    $default_tz = get_option('timezone_string');
    $blog_tz = get_option('timezone_string');
    $blog_tz_adjusted = "<b>$blog_tz</b>";
    $pseudo_tz = '';
}

$ezpz_tz = get_option('ezpz_ocb_save_tz');

if ($ezpz_tz != 'DISABLED' && $ezpz_tz != "") {
    $dateSrc = date('Y-m-d H:i:s');

    $wp_date = new DateTime($dateSrc, new DateTimeZone('GMT'));
    $wp_date->setTimeZone(new DateTimeZone($blog_tz));

    $ezpz_date = new DateTime($dateSrc, new DateTimeZone('GMT'));
    $ezpz_date->setTimeZone(new DateTimeZone($ezpz_tz));
} else {
    $dateSrc = date('Y-m-d H:i:s');

    $wp_date = new DateTime($dateSrc, new DateTimeZone('GMT'));
    $wp_date->setTimeZone(new DateTimeZone($blog_tz));

    $ezpz_date = new DateTime($dateSrc, new DateTimeZone('GMT'));
    $ezpz_date->setTimeZone(new DateTimeZone('GMT'));
}
head_template('EZPZ OCB - Options');
echo '<br/>';

if (get_option('ezpz_ocb_db_dump') == 'alt') {
    update_option('ezpz_ocb_prefix_only', '');
    $pf_disabled = 'disabled="disabled"';
    echo "<style type='text/css'>
    #pf-only {border: medium #adadad groove !important;
              background-color: #f7f7f7 !important;
              color: #adadad !important;
    }
    #pf-button {display: none;}
</style>";
} else {
    $pf_disabled = "";
}
?>

<style type="text/css">
    li.options {border: medium #dddddd groove; padding: 5px 8px; margin: 0 0 20px 12px;}

</style>
<form name="ezpz-one-click-backup" method="post" action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
    <ul >
        <li class="options">
            <p style="font-weight: bold; text-align: center; margin:0 0 4px 0;"><?php echo current_schedule(get_option('ezpz_ocb_cron_time'), get_option('ezpz_ocb_set_cron')); ?></p>
            <label>Schedule backups: <span style="float: right; margin-right: 10px;">Defaults: Off / 12 am</span></label>
            <select style="width: 180px;" name="<?php echo $opt_name['set_cron']; ?>">
                <option value="off" <?php echo ($opt_val['set_cron'] == "off") ? 'selected="selected"' : ''; ?> >Off - Do Not Schedule</option>
                <option value="10min" <?php echo ($opt_val['set_cron'] == "10min") ? 'selected="selected"' : ''; ?> >Test - 10 minutes</option>
                <option value="4daily" <?php echo ($opt_val['set_cron'] == "4daily") ? 'selected="selected"' : ''; ?> >Four times a day</option>
                <option value="twicedaily" <?php echo ($opt_val['set_cron'] == "twicedaily") ? 'selected="selected"' : ''; ?> >Two times a day</option>
                <option value="daily" <?php echo ($opt_val['set_cron'] == "daily") ? 'selected="selected"' : ''; ?> >One time a day</option>
                <option value="twodays" <?php echo ($opt_val['set_cron'] == "twodays") ? 'selected="selected"' : ''; ?> >Every other day</option>
                <option value="weekly" <?php echo ($opt_val['set_cron'] == "weekly") ? 'selected="selected"' : ''; ?> >Once a week</option>
            </select>
            <label> Time: </label>
            <select style="width: 78px; text-align: right;" name="<?php echo $opt_name['cron_time']; ?>">
                <?php
                $ii = "";
                for ($i = 0; $i <= 23; $i++) {
                    if ($i == 0) {
                        $ii = "12:00am";
                    } elseif ($i == 12) {
                        $ii = "12:00pm";
                    } elseif ($i >= 13) {
                        $ii = "$i" - 12;
                        $ii = "$ii:00pm";
                    } else {
                        $ii = "$i:00am";
                    }
                    echo "<option value='$i'";
                    echo ($opt_val['cron_time'] == $i) ? 'selected="selected"' : '';
                    echo ">$ii</option>";
                }
                ?>

            </select>
            <p>Every time someone visits a page on your site, WordPress checks to see if any of it's scheduled functions need to be executed.
                EZPZ OCB can take advantage of this feature to automate your backups. These backup schedules are a kind of pseudo-cron job.
                Basically, if no one visits your site the backup won't run as scheduled, it will however
                run as soon as anyone visits after the scheduled time. If you get even 10 visitors daily this type of scheduling should work fine.</p>
            <table>
                <tr><td colspan="2"><center><strong>All times are approximate due to the nature of wp-cron.</strong>
                    </center></td></tr>
                <tr>
                    <td width="65%">
                        <small>Four times a day backups will occur every 6 hours starting with X time.
                            <br/>Two times a day backups will occur every 12 hours (Xam and Xpm).
                            <br/>Daily backups will occur at the selected time every day.
                            <br/>Weekly and Every other day backups will occur starting on the day the option is activated
                            and continue until the schedule is changed.</small></td>
                    <td valign="bottom"><p style="text-align: right; margin: 0 0 0 0;"><input type="submit" name="Submit" value="Update Options" /></p>
                    </td>
                </tr>
            </table>
        </li>
        <li class="options">
            <label>Select a timezone for backup datestamp:
                <span style="float: right; margin-right: 10px;">Default: <?php echo $blog_tz; ?></span></label>
            <select style="width: 180px;" name="<?php echo $opt_name['save_tz']; ?>">
                <?php include('ezpz-ocb-timezone-array.php'); //get the timezone options array.    ?>
            </select>
            <p>Your WordPress timezone setting is <?php echo $blog_tz_adjusted ?>
                <br/>Your backup's timezone is <b><?php echo $ezpz_tz; ?></b>
            </p>
            <p>Changing this option will not effect your WordPress timezone choice, it only applies to EZPZ OCB Backups.</p>
            <?php
                if ($blog_tz == 'GMT') {
                    $zz = "GMT";
                } else {
                    $zz = "WordPress";
                }
            ?>
                <p><b><?php echo $zz; ?> Time is <?php echo $wp_date->format('F jS, Y g:ia'); ?>
                        <br/>Backup Time will be <?php echo $ezpz_date->format('F jS, Y g:ia'); ?></b></p>
                <p style="text-align: right; margin:-33px 0 0 0;"><input type="submit" name="Submit" value="Update Options" /></p>
            </li>
        <?php
                $dsf = array(// Datestamp format
                  1 => "y-m-d",
                  2 => "y-m-d_h.ia",
                  3 => "Y-m-d",
                  4 => "Y-m-d_h.ia",
                  5 => "d-m-Y",
                  6 => "d-m-Y_h.ia",
                  7 => "dMy",
                  8 => "dMy_Hi",
                  9 => "MjS-Y",
                  10 => "MjS-Y_h.ia");

                if (in_array(get_option('ezpz_ocb_ds_format'), $dsf)) {
                    $dspf = "";
                } else {
                    $dspf = "Custom: ";
                }
        ?>
                <li class="options">
                    <label>Select a pre-defined datestamp format:
                        <span style="float: right; margin-right: 10px;">Default: <?php echo $ezpz_date->format('Y-m-d'); ?></span></label>
                    <select style="width: 220px;" name="<?php echo $opt_name['ds_format']; ?>">
                        <option value="<?php echo get_option('ezpz_ocb_ds_format'); ?>" <?php echo ($opt_val['ds_format'] == get_option('ezpz_ocb_ds_format')) ? 'selected="selected"' : ''; ?> ><?php echo $dspf . $ezpz_date->format(get_option('ezpz_ocb_ds_format')); ?></option>
                        <option value="<?php echo $dsf[1] ?>" <?php echo ($opt_val['ds_format'] == $dsf[1]) ? 'selected="selected"' : ''; ?> ><?php echo $ezpz_date->format('y-m-d'); ?></option>
                        <option value="<?php echo $dsf[2] ?>" <?php echo ($opt_val['ds_format'] == $dsf[2]) ? 'selected="selected"' : ''; ?> ><?php echo $ezpz_date->format('y-m-d_h.ia'); ?></option>
                        <option value="<?php echo $dsf[3] ?>" <?php echo ($opt_val['ds_format'] == $dsf[3]) ? 'selected="selected"' : ''; ?> ><?php echo $ezpz_date->format('Y-m-d'); ?></option>
                        <option value="<?php echo $dsf[4] ?>" <?php echo ($opt_val['ds_format'] == $dsf[4]) ? 'selected="selected"' : ''; ?> ><?php echo $ezpz_date->format('Y-m-d_h.ia'); ?></option>
                        <option value="<?php echo $dsf[5] ?>" <?php echo ($opt_val['ds_format'] == $dsf[5]) ? 'selected="selected"' : ''; ?> ><?php echo $ezpz_date->format('d-m-Y'); ?></option>
                        <option value="<?php echo $dsf[6] ?>" <?php echo ($opt_val['ds_format'] == $dsf[6]) ? 'selected="selected"' : ''; ?> ><?php echo $ezpz_date->format('d-m-Y_h.ia'); ?></option>
                        <option value="<?php echo $dsf[7] ?>" <?php echo ($opt_val['ds_format'] == $dsf[7]) ? 'selected="selected"' : ''; ?> ><?php echo $ezpz_date->format('dMy'); ?></option>
                        <option value="<?php echo $dsf[8] ?>" <?php echo ($opt_val['ds_format'] == $dsf[8]) ? 'selected="selected"' : ''; ?> ><?php echo $ezpz_date->format('dMy_Hi'); ?></option>
                        <option value="<?php echo $dsf[9] ?>" <?php echo ($opt_val['ds_format'] == $dsf[9]) ? 'selected="selected"' : ''; ?> ><?php echo $ezpz_date->format('MjS-Y'); ?></option>
                        <option value="<?php echo $dsf[10] ?>" <?php echo ($opt_val['ds_format'] == $dsf[10]) ? 'selected="selected"' : ''; ?> ><?php echo $ezpz_date->format('MjS-Y_h.ia'); ?></option>
                    </select><br/>
                    <label>Or customize your own <a href="http://php.about.com/od/learnphp/ss/php_functions_3.htm" target="_blank"> valid PHP date format</a>:
                        <input type="text" name="tmp_ds_format" value="<?php echo $opt_val['ds_format']; ?>" size="26" />
                        <br/>Allowed separators are periods(.) hyphens(-) commas(,) at symbols(@) &amp; underscores(_).
                        <br/>All other characters will be removed.
                        <br/><small>NOTE: Spaces will be converted to underscores(_).</small></label>
                    <p>Currently your datestamp is <b><?php echo $ezpz_date->format(get_option('ezpz_ocb_ds_format')); ?></b>.</p>
                    <p style="text-align: right; margin:-20px 0 0 0;"><input type="submit" name="Submit" value="Update Options" /></p>
                </li>
                <li class="options" id="pf-only">
                    <input id="prefix_only" type="checkbox" value="yes" <?php echo $pf_disabled; ?> name="<?php echo $opt_name['prefix_only']; ?>" <?php echo (isset($opt_val['prefix_only']) && $opt_val['prefix_only'] == "yes") ? 'checked="true"' : ''; ?>  />
                    <label>Backup only the database tables with <em><?php echo $wpdb->prefix; ?></em> prefix.
                        <span style="float: right; margin-right: 10px;">Default: Unchecked</span></label>
                    <p>Useful only if you are using a shared database. This option will only backup database tables prefixed with <em><?php echo $wpdb->prefix; ?></em>.
                        If you are using a dedicated database this option is moot and should be unchecked for better performance.
                        <br/><small>NOTE: Some servers may not allow use of this option.</small>
                        <br/><small>NOTE: This option is not available with the alternative database backup method.</small></p>
                    <div id="pf-button"><p style="text-align: right; margin-bottom: 0;"><input type="submit" name="Submit" value="Update Options" /></p></div>
                </li>
                <li class="options">
                    <input id="db_dump" type="checkbox" value="alt" name="<?php echo $opt_name['db_dump']; ?>" <?php echo (isset($opt_val['db_dump']) && $opt_val['db_dump'] == "alt") ? 'checked="true"' : ''; ?>  />
                    <label>Use alternate database backup method.
                        <span style="float: right; margin-right: 10px;">Default: Unchecked</span></label>
                    <p>Select this option only if you are getting <em>mysqldump</em> database warnings. This alternative method is slower
                        but does not use <em>mysqldump</em> for backing up your database.
                        <br/><small>NOTE: Using this option disables the <em><?php echo $wpdb->prefix; ?></em> prefix only option.</small></p>
                    <p style="text-align: right; margin-bottom: 0;"><input type="submit" name="Submit" value="Update Options" /></p>
                </li>
                <li class="options">
                    <table>
                        <tr>
                            <td colspan="2"><label>Excluded Folders
                                    <span style="float: right; margin-right: 10px;">Default: none</span></label></td></tr>
                        <tr><td valign="top"><textarea style="border:thin black inset" cols="30" rows="5" name="<?php echo $opt_name['excluded_folders'] ?>" value="<?php echo $opt_val['excluded_folders']; ?>"><?php echo $opt_val['excluded_folders']; ?></textarea>
                            </td>
                            <td valign="top" style="padding: 0 10px 0 15px;"><p>Here you can list specific folders you wish to exclude from your backup. These folders as well as all their content will be excluded from backups.</p>
                                <p>Enter each folder which you wish to exclude separated by commas.</p>
                            </td>
                        </tr>
                        <tr><td colspan="2">
                                <p>Be as specific as possible with folder names to avoid unwanted exclusions.
                                    <br/>For example, if you enter "<em>tmp</em>" ALL folders named "<em>tmp</em>" (<em>thisFolder/tmp</em> AND <em>thatFolder/tmp</em>) would be excluded.
                                    &nbsp;If you enter <em>thisFolder/tmp</em>, <em>thatFolder/tmp</em> is backed up while <em>thisFolder/tmp</em> is not.
                                    <br/><small>Note: Wildcards(*) are <b>NOT</b> allowed. Folder names <b>MAY</b> contain leading and/or trailing slashes.</small></p>
                            </td></tr>
                    </table>
                    <p style="text-align: right; margin-bottom: 0;"><input type="submit" name="Submit" value="Update Options" /></p>
                </li>                
                <li class="options">
                    <input type="checkbox" value="yes" name="<?php echo $opt_name['hide_backup']; ?>" <?php echo (isset($opt_val['hide_backup']) && $opt_val['hide_backup'] == "yes") ? 'checked="checked"' : ''; ?>  />
                    <label>Hide backup from web access.
                        <span style="float: right; margin-right: 10px;">Default: Unchecked</span></label>
                    <p>Selecting this option will change the permissions on your backup folder and it will be totally
                        inaccessible by browsers. You will have to download your backup via FTP or your server's control panel.</p>
                    <p><small>NOTE: While it is slightly more secure it's not necessary to use this option.<br/>
                            NOTE: Some servers may not allow the use of this option.</small></p>
                    <p style="text-align: right; margin: -40px 0 0 0;"><input type="submit" name="Submit" value="Update Options" /></p>
                </li>
                <li class="options">
                    <label>Server speed adjustment:
                        <span style="float: right; margin-right: 10px;">Default: Normal</span></label>
                    <select style="width: 85px;" name="<?php echo $opt_name['speed_factor']; ?>">
                        <option value="12" <?php echo ($opt_val['speed_factor'] == "12") ? 'selected="selected"' : ''; ?> >Slow</option>
                        <option value="6" <?php echo ($opt_val['speed_factor'] == "6") ? 'selected="selected"' : ''; ?> >Normal</option>
                        <option value="3" <?php echo ($opt_val['speed_factor'] == "3") ? 'selected="selected"' : ''; ?> >Fast</option>
                        <option value="1" <?php echo ($opt_val['speed_factor'] == "1") ? 'selected="selected"' : ''; ?> >Turbo</option>
                    </select>
                    <p><b>EZPZ One Click Backup</b> uses built in delays to ensure all data is backed up properly.
                        <br/>You can choose to adjust the execution speed. If your server is high speed you can try Fast or Turbo.
                        <br/>If your server is slower you may want to choose Slow for the best possible backup.</p>
                    <p style="text-align: right; margin-bottom: 0;"><input type="submit" name="Submit" value="Update Options" /></p>
                </li>
                <li class="options">
                    <input type="checkbox" value="no" name="<?php echo $opt_name['stylized']; ?>" <?php echo (isset($opt_val['stylized']) && $opt_val['stylized'] == "no") ? 'checked="checked"' : ''; ?>  />
                    <label>Remove colorful stylization on backup status display.
                        <span style="float: right; margin-right: 10px;">Default: Unchecked</span></label>
                    <p>Choosing this option will remove the light hearted color and font styling from the backup status report. </p>
                    <p style="text-align: right; margin-bottom: 0;"><input type="submit" name="Submit" value="Update Options" /></p>
                </li>
                <li class="options">
                    <input type="checkbox" value="yes" name="<?php echo $opt_name['log_errors']; ?>" <?php echo (isset($opt_val['log_errors']) && $opt_val['log_errors'] == "yes") ? 'checked="checked"' : ''; ?>  />
                    <label>Enable error logging.
                        <span style="float: right; margin-right: 10px;">Default: Unchecked</span></label>
                    <p>This will enable error logging if you are experiencing problems. Error's will only be logged when enabled
                        and the log will be erased when logging is disabled.</p>
                    <p style="text-align: right; margin-bottom: 0;"><input type="submit" name="Submit" value="Update Options" /></p>
                </li>

            </ul></form>
<?php foot_template(); ?>