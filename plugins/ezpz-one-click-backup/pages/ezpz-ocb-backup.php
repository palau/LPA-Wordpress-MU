<?php

if (get_option('ezpz_ocb_log_errors') === 'yes') {
    $error_logging = true;
} else {
    $error_logging = false;
}
if ($error_logging) {
    if (!file_exists(WP_PLUGIN_DIR . "/" . ezpz_ocb_slug() . "/error.txt")) {
        file_put_contents(WP_PLUGIN_DIR . "/" . ezpz_ocb_slug() . "/error.txt", "");
    }
    set_error_handler('ezpz_ocb_error_handler');
} else {
    if (file_exists(WP_PLUGIN_DIR . "/" . ezpz_ocb_slug() . "/error.txt")) {
        $cmd = "rm -r " . WP_PLUGIN_DIR . "/" . ezpz_ocb_slug() . "/error.txt";
        exec($cmd);
    }
}

global $wpdb;
$rnd_dir = get_rnd_folder();

$timeZone = get_option('ezpz_ocb_save_tz');
if ($timeZone == "") {
    $timeZone = 'GMT';
}
$ds_format = get_option('ezpz_ocb_ds_format');
$dateSrc = date('Y-m-d H:i:s');
if ($timeZone == "GMT") {
    $dateTime = new DateTime($dateSrc, new DateTimeZone('GMT'));
    $dateTime->setTimeZone(new DateTimeZone('GMT'));
} else {
    $dateTime = new DateTime($dateSrc, new DateTimeZone('GMT'));
    $dateTime->setTimeZone(new DateTimeZone($timeZone));
}

$datestamp = $dateTime->format($ds_format);

set_new_date($datestamp);

head_template('EZPZ OCB - Backup', true);

$db_prefix = $wpdb->prefix;

$speed = get_option('ezpz_ocb_speed_factor');
$xcluded = get_option('ezpz_ocb_excluded_folders');
$prefix_only = get_option('ezpz_ocb_prefix_only');
$stylized = get_option('ezpz_ocb_stylized');

$blog_path = str_replace('/wp-content/plugins', '', WP_PLUGIN_DIR);
$wp_temp = explode('/', $blog_path);
$wp_dir = end($wp_temp);

$rnd_dir = get_rnd_folder();
$clean_name = clean_name();
$zip_name = $clean_name . get_zip_date() . '.zip';

usleep(250000);
update_option('ezpz_ocb_zip_name', $zip_name);
$tar_name = "EZPZ_$wp_dir.TGZ";
$archive_dir = $rnd_dir . "/" . clean_name() . get_zip_date();
$sql_file = $archive_dir . '/EZPZ_DB.SQL';


$save_path = $rnd_dir;
$save_wpcontent_path = $blog_path . '/wp-content/';
$ckmrk = '&nbsp;<span style="font-family: tahoma, sans-serif; color: green; font-weight: 900;"> &#10004;<small>OK</small></span>';
$failed = '&nbsp;<span style="font-family: tahoma, sans-serif; color: darkred; font-weight: 900;"> X<small> FAILED</small></span>';
$bullet = '&nbsp;&nbsp;&nbsp;&nbsp;<img src="' . site_url() . '/wp-content/plugins/' . ezpz_ocb_slug() . '/images/bullet.png" />&nbsp;&nbsp;';
if ($stylized != 'no') {
    $gold_span = "<span style='color: rgb(204,153,0);'>";
    $blue_span = "<span style='color: rgb(0,0,160); font-weight: bold;'>";
    $dkred_span = "<span style='color: darkred; font-size: 16px; font-family: MS Comic Sans, cursive, sans-serif; font-style: italic;'>";
} else {
    $gold_span = "<span>";
    $blue_span = "<span style='font-weight: bold;'>";
    $dkred_span = "<span>";
}

echo "<div id='generated' style='font-size: 1.5em; padding: 0 0 0 12px;'>";
if ($error_logging) {
    echo "<h4 style='color: darkred;'>Error logging is active...</h4>";
} else {
    echo "<p></p>\n";
}
echo "<ol style='margin: 0 0 0 16px;'><li><b>First we need to gather some information about " . $gold_span . "<em>" . stripslashes(get_bloginfo('name')) . "</em></span></b>\n";
usleep(1250000);
echo "<br/>" . $dkred_span . "Don't worry, sit back and I'll do all the work.</span></li>\n";
usleep(1250000);
echo "<li style='margin-top: 0px;'><b>Get the required database information.</b></li>\n";
usleep(125000 * $speed);
echo "<ul class=\"circle\"><li>DB Host: ";
usleep(125000 * $speed);
echo $blue_span . DB_HOST . "</span>" . $ckmrk . $bullet . "DB Name: \n";
usleep(125000 * $speed);
echo $blue_span . DB_NAME . "</span>" . $ckmrk . "</li><li>DB User: \n";
usleep(125000 * $speed);
echo $blue_span . DB_USER . "</span>" . $ckmrk . $bullet . "DB Password: \n";
usleep(125000 * $speed);
echo $blue_span . "[Hidden]</span>" . $ckmrk;
if ($prefix_only === "yes") {
    $db_txt = "Now let's get your$blue_span $db_prefix</span> database tables and create";
    echo $bullet . "DB Prefix: ";
    usleep(125000 * $speed);
    echo $blue_span . $db_prefix . "</span>" . $ckmrk;
} else {
    $db_txt = "Now let's get the database contents and create";
}
echo "</li><li>Website URL: \n";
usleep(125000 * $speed);
echo $blue_span . site_url() . "</span>" . $ckmrk . "</li><li>Get Full Wordpress Path: \n";
usleep(125000 * $speed);
echo $blue_span . $blog_path . "</span>" . $ckmrk . "</li></ul></li>\n";
usleep(125000 * $speed);
echo "<li><b>$db_txt the database backup file.</b>\n";
usleep(125000 * $speed);
echo "</li><ul class=\"circle\" style='margin-top: 0px;'><li>Archiving Your Database";
usleep(125000 * $speed);

remove_old_backup();
if (!file_exists($archive_dir)) {
    mkdir($archive_dir);
}

OCBmysql($sql_file);
if (file_exists($sql_file)) {
    $db_info = "and the database";
    echo $ckmrk . "</li></ul>";
} else {
    $db_info = "<span style='color: darkred;'><s>and the database</s></span>";
    echo $failed . "<div class='ezpz-ocb-warning'><b>EZPZ OCB</b> was unable to backup the database. This is usually
    due to <em>mysqldump</em> being disabled by your server. Please try the option <b>\"Use alternate database backup method\"</b>
    on <b>EZPZ OCB's</b> options page. The backup process will continue but it will not be possible
    to include a database file during this backup.</div>";
}
echo "<li><b>Finally we'll zip " . get_bloginfo('name') .", the restoration script $db_info into:<br/><em>$gold_span $zip_name</span></em></b>";
$folder_size = bytes_to_Xb(folder_size_in_bytes(ABSPATH));
echo "<br/>Please be patient, we&apos;re archiving $folder_size of files and it may take a while.";

usleep(250000 * $speed);
$excluded_folders = "";
if ($xcluded != "" && $xcluded != "none") {
    echo "<br/>Excluding $blue_span$xcluded</span> folders from $gold_span<em><b>$tar_name</b></em></span>";
    $xcluded = str_replace(",  ", ",", $xcluded);
    $xcluded = str_replace(", ", ",", $xcluded);
    $excluded = explode(",", $xcluded);

    foreach ($excluded as $item) {

        $excluded_folders = $excluded_folders . ' --exclude "' . $item . '*" --exclude "' . $item . '"';
    }
}

    $archive_this = "../../$wp_dir/";


$exclude_bu_dir = str_replace(WP_PLUGIN_DIR . "/" . ezpz_ocb_slug() . "/backups/", "", $rnd_dir);

$cmd = "tar czf $archive_dir/$tar_name --exclude \"$exclude_bu_dir/*\" $excluded_folders $archive_this";
exec($cmd);

sleep(2);

generate_restore();

//Open zip archive.
$zip = new ZipArchive;
$res = $zip->open("$rnd_dir/$zip_name", ZipArchive::CREATE);
if ($res === TRUE) {
    if (file_exists("$archive_dir/$tar_name")) {
        $zip->addFile("$archive_dir/$tar_name", "EZPZ_RESTORATION_FILES/$tar_name");
    }
    if (file_exists("$archive_dir/EZPZ_DB.SQL")) {
        $zip->addFile("$archive_dir/EZPZ_DB.SQL", "EZPZ_RESTORATION_FILES/EZPZ_DB.SQL");
    }
    if (file_exists("$archive_dir/EZPZ_RESTORE.PHP")) {
        $zip->addFile("$archive_dir/EZPZ_RESTORE.PHP", "EZPZ_RESTORATION_FILES/EZPZ_RESTORE.PHP");
    }
    $zip->close();

} else {
    echo "<p><b>FAILED! Could not create $zip_name.</b></p>";
}

empty_folder($archive_dir, true);

if (file_exists("$rnd_dir/$zip_name")) {
    echo "$ckmrk<br/></li></ul></ol><center><b><h5 style='font-size: 75%;'>Hopefully that was relatively quick
    and painless... because WE'RE DONE!</h5></b></center>\n";

    if (get_option('ezpz_ocb_hide_backup') != 'yes') {
        echo get_dl_box() . "\n</div>";
    } else {
        $short_path = str_replace(ABSPATH, "", $save_path . "/" . $tar_name);
        echo "<center><div class='ezpz-ocb-warning' style='font-size: 12px; text-align: center;'><b>You have chosen
    to hide the backups folder from web browsers.</b><br/>The FTP/Cpanel path needed to download your backup is:<br/>
    <div style='font-family: monospace courier;'>&lt;path_to_wordpress&gt;/$short_path</div></center>";
    }
} else {
    echo "$failed<br/></li></ul></ol>
    <div style=' margin-left: 26px;'><div class='ezpz-ocb-warning' style='font-size: 12px;'><b>EZPZ OCB</b>
    was unable to complete your backup. This is usually due to a server issue such as the process timing out
    or needed functions such as <em>exec</em>, <em>mkdir</em>, etc being disabled on your server. Please
    try decativating and reactivating <b>EZPZ OCB</b> then run the backup again. If the problem persists
    <b>EZPZ OCB</b> is probably incompatible with your server. Sorry...</div></div>";
}
if ($error_logging) {
    echo "<div style='font-size: 14px;'><a href='" . site_url() . '/wp-content/plugins/' . ezpz_ocb_slug() .
    '/error.txt' . "' >View error log</a></div>";
}
foot_template();

echo "<!-- END of Generated HTML ........................................ -->\n";

return false;
?>