<?php
include('ezpz-ocb-restore.php');

// Backup the database
function OCBmysql($sql_file) {
    global $wpdb;

//    Set some variables name
    $db_prefix = $wpdb->prefix;
    $speed = get_option('ezpz_ocb_speed_factor');
    $prefix_only = get_option('ezpz_ocb_prefix_only');
    $tablelist = "";

    if (get_option('ezpz_ocb_db_dump') != "alt") { // Primary database backup method
//    Perform prefix only extraction if option is selected
        if ($prefix_only === "yes") {
            if (!mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)) {
                echo 'Could not connect to mysql';
                exit;
            }


            $sql_tables = "SHOW TABLES FROM " . DB_NAME;
            $result = mysql_query($sql_tables);

            if (!$result) {
                echo "DB Error, could not list tables\n";
                echo 'MySQL Error: ' . mysql_error();
                exit;
            }

            $prefix_len = strlen($db_prefix);
            while ($row = mysql_fetch_row($result)) {
                if (substr($row[0], 0, $prefix_len) == $db_prefix) {
                    $tablelist = $tablelist . $row[0] . ' ';
                }
            }


//        Prefix only database backup command
            $command = 'mysqldump -p --user=' . DB_USER . ' --password=' . DB_PASSWORD . ' --host=' . DB_HOST . ' --opt ' . DB_NAME . ' ' . $tablelist . ' > ' . $sql_file;
        } else {
//        Entire database backup command
            $command = 'mysqldump -p --user=' . DB_USER . ' --password=' . DB_PASSWORD . ' --host=' . DB_HOST . ' --add-drop-table ' . DB_NAME . ' > ' . $sql_file;
        }

        exec($command);
    } else { // Alternate database backup method
        update_option('ezpz_ocb_prefix_only', "nullified");
        db_dump(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, $sql_file);
    }
    usleep(250000 * $speed);
}

function ezpz_ocb_dl_previous_backup() {

    head_template('EZPZ OCB - Download');

//    Get the archive file name
    if ($handle = opendir(get_rnd_folder())) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && $file != "index.html") {
                $ezpz_archive = $file;
            }
        }
        closedir($handle);
    }

//    Setup some variables
    $clean_name = clean_name();
    $short_path = str_replace(ABSPATH, "", get_rnd_folder()) . '/' . $ezpz_archive;
    $zip_path = get_rnd_folder() . '/' . $ezpz_archive;
    $zipped = site_url() . "/" . $short_path;

//    Check if archive exists then add the html
    if (is_file($zip_path)) {
        if (get_option('ezpz_ocb_hide_backup') != 'yes') {
//            echo get_dl_box() . "\n</div>";
?>
            <table width="90%" style="margin: 25px auto;">

                <tr>

                    <td>
                        <center>
                            <div id="dlButton" style="display: block;">
                                <form method="link" action="<?php echo $zipped; ?>">

                                    <input type="submit" value=" Download <?php echo $ezpz_archive; ?> " >

                                </form>
                                <p style="font-size: 75%">If your backup is really big you may want to download it via ftp. The path you'll need is below.
                                    <br/><span style=" font-family: monospace;">Path to Wordpress<span style="color: green;">/<?php echo $short_path; ?></span></span></p>
                            </div>

                            <div id="complete" style="display: none;"><h3>Your backup is downloading, what are you hanging around for? GO AWAY! ;-)</h3></div>

                        </center>
                    </td>


                </tr>

            </table>
<?php
        } else {
            echo "<center><div class='ezpz-ocb-warning' style='font-size: 12px; text-align: center;'><b>You have chosen
    to hide the backups folder from web browsers.</b><br/>The FTP/Cpanel path needed to download your backup is:<br/>
    <div style='font-family: monospace courier;'>&lt;path_to_wordpress&gt;/$short_path</div></center>";
        }
    } else {
        echo "No previous backup found... Please make new backup.";
    }
    foot_template();
}

// Make a random alpha numeric string $num characters long
function rnd_alpha_numeric($num = 6) {

    for ($i = 0; $i < $num; $i++) {

        $seed = rand(1, 30) % 3;

        if ($seed == 0) {

//            A-Z
            $char = chr(rand(97, 122));
        } else if ($seed == 1) {

//            a-z
            $char = chr(rand(65, 90));
        } else {

//            0-9
            $char = chr(rand(48, 57));
        }

        $output = $output . $char;
    }

    return $output;
}

function get_rnd_folder() {
    return get_option('ezpz_ocb_rnd_key');
}

function get_zip_date() {
    return get_option('ezpz_ocb_zip_date');
}

function set_new_date($new_date) {
    return update_option('ezpz_ocb_zip_date', $new_date);
}

function empty_folder($folder_path, $del_dir = false) {

    if (file_exists($folder_path)) {
        $cmd = "rm -r $folder_path";
        exec($cmd);

        if ($del_dir === false) {
            $cmd = "mkdir $folder_path";
            exec($cmd);
        }
        if (file_exists($folder_path) && function_exists(forbidden)) {
            file_put_contents("$folder_path/index.html", forbidden());
        }
    }
}

function remove_old_backup() {

    $rnd_dir = get_rnd_folder();

    if (file_exists($rnd_dir)) {
        $cmd = "rm -r $rnd_dir";
        exec($cmd);

        $cmd = "mkdir $rnd_dir";
        exec($cmd);

        file_put_contents("$rnd_dir/index.html", forbidden());
    }
}

function get_dl_box() {

    if ($handle = opendir(get_rnd_folder())) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && $file != "index.html") {
                $ezpz_archive = $file;
            }
        }
        closedir($handle);
    }

    $clean_name = clean_name();
    $short_path = str_replace(ABSPATH, "", get_rnd_folder()) . '/' . $ezpz_archive;
    $zipped = site_url() . "/" . $short_path;

    $dl_box = <<<DOWNLOAD
            <script type="text/javascript"  language="javascript">

            function hide_me(div2hide) {


                document.getElementById(div2hide).style.display="none";

            }

            function show_me(div2hide) {

                document.getElementById(div2hide).style.display="block";

            }

            function no_border(ID) {


                document.getElementById(ID).style.border="none";

            }


          </script>
        <table id="DL-Table"style="margin: 0 auto; width: 90%; border: 1px black dotted;">

                <tr>

                    <td><p id="message" style="display: block; padding: 2px 10px 2px 10px; text-align: justify; font-size: 80%">If you were expecting a more complicated process,
                            I apologize... That's all there is to it. Just click the Download button and you'll have a complete copy of your website safely
                            tucked away on your computer. If you'd rather download it later, no worries, I'll keep it handy. Keep in mind that I only store the
                            latest backup on the server because they tend to pile up and can consume a lot of precious disc space.</p>

                    </td>

                </tr>

                <div><tr>

                        <td>
                            <center>
                                <div id="dlButton" style="display: block;">


                                    <form method="link" action="$zipped">

                                        <input type="submit" value="Download Your Backup" onclick="" onmouseup="hide_me('dlButton'); hide_me('message'); show_me('complete'); no_border('DL-Table'); download()">

                                    </form>
                                    <p style="font-size: 85%">If your backup is really big you may want to download it via ftp. The path you'll need is below.
                                        <br/>PathToWordpress<span style="font-size: 90%; font-family: Courier New, monospace; color: green;">/$short_path</span></p>
                                </div>

                                <div id="complete" style="display: none;"><center><h4>Your backup is downloading, what are you hanging around for? GO AWAY! ;-)</h4></center></div>

                            </center>
                        </td>


                    </tr></div>

            </table>
DOWNLOAD;

    return $dl_box;
}

function head_template($title, $timer=false, $show_mode=true) {
    $ocb_version = ezpz_ocb_version();
    $speed = get_option('ezpz_ocb_speed_factor');
    $speed_level[1] = "turbo";
    $speed_level[3] = "fast";
    $speed_level[6] = "normal";
    $speed_level[12] = "slow";

    $mode = $speed_level[$speed];

    if ($show_mode) {
        $bg_mode = "background:transparent url(" . site_url() . "/wp-content/plugins/" . ezpz_ocb_slug() . "/images/$mode.png)";
    } else {
        $bg_mode = "";
    }
    $sidebar = <<<SIDEBAR
<p style="text-align: center;"><strong>EZPZ One Click Backup</strong><br/> by <em>EZPZ Solutions</em></p>
    <p style="text-align: justify;">If you find this plugin useful please consider a donation to help <em>EZPZ Solutions</em>
 keep improving existing plugins and develop new, easy to use Wordpress plugins.</p>
   <center><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="JSQGRHN58DXPE">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form></center>
<p style="text-align: center;">
<a href="http://wordpress.org/extend/plugins/ezpz-one-click-backup/" target="_blank">
Rate this plugin at WordPress.org</a></p>
<p style="text-align: center;">Questions, Comments, Suggestions or Requests?</p>
<p style="text-align: center;">Contact us at <br/>EZPZSolutions@gmail.com</p>
<p style="text-align: center;"><a href="http://ezpzsolutions.net/ezpz-wordpress-plugins/ezpz-one-click-backup" target="_blank">Visit Plugin Site</a></p>
SIDEBAR;

    echo " <!-- START of Generated HTML ........................................ -->
    
    <style type=\"text/css\">
    li {margin-left: 10px;}
    ul.circle {
	list-style-type: circle;
	list-style-image: none;
	list-style-position: inside;
    }
    ul.circle ul {
        list-style-type: circle;
    }
    .ezpz-ocb-warning {
        border: 1px darkred solid;
        width: 450px;
        background: #FFCCCC;
        margin: 5px 5px 5px 12px;
        padding: 8px;
        text-align: justify;
         -moz-border-radius:6px;
         -khtml-border-radius:6px;
         -webkit-border-radius:6px;
         border-radius:6px;
        }

    .ezpz-title {
        font-size:1.5em;
        font-weight:bold;
        font:italic normal normal 24px/29px Georgia,\"Times New Roman\",\"Bitstream Charter\",Times,serif;
        margin:0;
        padding:14px 15px 3px 0;
        line-height:35px;
        text-shadow:rgba(255,255,255,1) 0 1px 0;
        color:#464646;
        }

    .ezpz-version {
        margin: -10px 0 0 84px;
        font-size: .85em;
        color:#464646;
        }
    </style>
        <div id=\"ezpz-ocb-wrapper\" style=\"min-width: 815px;\">
            <div id=\"pseudo-head\">";

    if ($timer) {
        echo "<script type=\"text/javascript\">
                    <!-- Begin
                    /* This script and many more are available free online at
        The JavaScript Source!! http://javascript.internet.com
        Created by: Abraham Joffe :: http://www.abrahamjoffe.com.au/ */

                    var startTime=new Date();

                    function currentTime(){
                        var a=Math.floor((new Date()-startTime)/100)/10;
                        if (a%1==0) a+=\".0\";
                        document.getElementById(\"endTime\").innerHTML=a;
                    }

                    window.onload=function(){
                        clearTimeout(loopTime);
                    }

                    // End -->
                </script>";
    }

    echo "<div class='wrap'><div style='background:transparent url(" . site_url() . "/wp-content/plugins/" . ezpz_ocb_slug() . "/images/gears2.gif) no-repeat; float: left; height: 23px; margin: 32px 6px 0 0; width: 46px;'><br></div>
                <h2><div style='height: 50px; $bg_mode no-repeat; background-position: 315px 17px;'><div class=\"ezpz-title\">$title</div></h2>";

    echo "</div>
            </div>
            <div id=\"pseudo-wrapper\" style=\"font-family: Tahoma, Geneva, sans-serif;\">
                <div id=\"sidebar\" style=\"margin: 0 10px; padding: 0 10px; float: right; max-width: 180px;\">$sidebar</div>
                <div class='ezpz-version'><b><em>Version $ocb_version</em></b>";

    if ($timer) {
        echo "<div id=\"clock\" >
                        <script type=\"text/javascript\">
                            <!-- Begin
                            document.write('<div style=\"float: right; width: 250px; font-size: 1.2em; font-weight: bold; text-align: center; background: none repeat scroll 0% 0% rgb(0, 0, 0); color: rgb(0, 255, 0);\">Elapsed Time -> <span id=\"endTime\">0.0</span> seconds</div>');
                            var loopTime=setInterval(\"currentTime()\",100);
                            // End -->
                        </script>
                    </div>";
    }
    echo "</div>
                <h2></h2>

                <div id='left-body' style='margin: 0 0 0 15px; width: 70%; max-width: 700px; float: left;'>";
}

function foot_template() {
    echo "            </div>
        </div>
    </div>
</div> <!-- pseudo-body -->";
}

function tab($num = 1) {
    $nn = 0;
    $output = "";
    while ($nn < $num) {
        $output = $output . "&nbsp;&nbsp;&nbsp;&nbsp;";
        $nn++;
    }
    return $output;
}

function clean_name() {
    $cn = substr(preg_replace("#[^0-9a-zA-Z_\s]#", "", str_replace(" ", "_", preg_replace("/&#?[a-z0-9]{2,8};/i", "", get_bloginfo('name')))), 0, 20) . "_";
    return str_replace('__', '_', $cn);
}

function ezpz_ocb_slug() {
    return "ezpz-one-click-backup";
}

function custom_cron_schedules($schedules) {

    $_min = 60;
    $_hr = 60 * $_min;
    $_day = 24 * $_hr;

    $schedules['twodays'] = array(
      'interval' => 2 * $_day,
      'display' => __('Every other day'),
    );

    $schedules['weekly'] = array(
      'interval' => 7 * $_day,
      'display' => __('Weekly'),
    );

    $schedules['4daily'] = array(
      'interval' => $_day / 4,
      'display' => __('Four times a day'),
    );

    $schedules['10min'] = array(
      'interval' => 10 * $_min,
      'display' => __('Every 10 minutes'),
    );

    return $schedules;
}

function ezpz_ocb_error_handler($code, $msg, $file, $line) {
    $logData = date("d-M-Y h:i:s", mktime()) . ", $code, $msg, $line, $file";
    if (strpos($logData, "is_a(): Deprecated. Please use the instanceof operator, 652,")) {
        $logData = "";
    } else {
        $logData = $logData . "\n\n";
    }
    file_put_contents(WP_PLUGIN_DIR . "/" . ezpz_ocb_slug() . "/error.txt", $logData, FILE_APPEND);
}

function db_dump($host, $user, $pass, $name, $backup_file) {

    $link = mysql_connect($host, $user, $pass);
    $return = "";
    mysql_select_db($name, $link);

//get all of the tables
    $tables = array();
    $result = mysql_query('SHOW TABLES');
    while ($row = mysql_fetch_row($result)) {
        $tables[] = $row[0];
    }


//cycle through
    foreach ($tables as $table) {

        $result = mysql_query('SELECT * FROM ' . $table);
        $num_fields = mysql_num_fields($result);

        $return.= 'DROP TABLE ' . $table . ';';
        $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE ' . $table));
        $return.= "\n\n" . $row2[1] . ";\n\n";

        for ($i = 0; $i < $num_fields; $i++) {
            while ($row = mysql_fetch_row($result)) {
                $return.= 'INSERT INTO ' . $table . ' VALUES(';
                for ($j = 0; $j < $num_fields; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = preg_replace("/\n/", "\\n", $row[$j]);
                    if (isset($row[$j])) {
                        $return.= '"' . $row[$j] . '"';
                    } else {
                        $return.= '""';
                    }
                    if ($j < ($num_fields - 1)) {
                        $return.= ',';
                    }
                }
                $return.= ");\n";
            }
        }
        $return.="\n\n\n";
    }

//save file
    file_put_contents($backup_file, $return);
}

function current_schedule($time, $schedule) {
    $prefix = "Your current schedule is ";

    if ($time > 12) {
        $adj_time = $time - 12;
        $adj_time = "$adj_time:00pm";
    } elseif ($time == 0) {
        $adj_time = "12:00am";
    } elseif ($time == 12) {
        $adj_time = "12:00pm";
    } else {
        $adj_time = "$time:00am";
    }


    switch ($schedule) {
        case 'off':
            $prefix = "Scheduling is turned off.";
            $output = "";
            break;
        case 'daily':
            $output = "one time a day at $adj_time";
            break;
        case 'twicedaily':
            $_2time = $time % 12;
            $output = "two times a day at $_2time:00, am and pm";
            $output = str_replace(' 0', ' 12', $output);
            break;
        case 'twodays':
            $output = "every other day at $adj_time";
            break;
        case 'weekly':
            $weekday = get_option('ezpz_ocb_cron_day');
            $output = "once a week on every $weekday at $adj_time";
            break;
        case '4daily':
            $_4time[1] = $time % 6;
            $_4time[2] = $_4time[1] + 6;
            $output = "four times a day at $_4time[1]:00 &amp; $_4time[2]:00, am and pm";
            $output = str_replace(' 0', ' 12', $output);
            break;
    }
    return $prefix . $output;
}

function folder_size_in_bytes($directory) {

    $size = 0;
    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){
        $size+=$file->getSize();
    }
    return $size;
}


function bytes_to_Xb($bytes) {
    $symbols = array('B', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb', 'Eb', 'Zb', 'Yb');
    $exp = floor(log($bytes) / log(1024));

    return sprintf("%.2f " . $symbols[$exp], ($bytes / pow(1024, floor($exp))));
}

function ezpz_ocb_admin_notices() {
    $wp_dir = str_replace('/wp-content/plugins', '', WP_PLUGIN_DIR);
    $wp_dir_name_tmp = explode('/', $wp_dir);
    $wp_dir_name = end($wp_dir_name_tmp);
    $wp_parent_dir = str_replace("/$wp_dir_name", "", $wp_dir);
    $ezpz_restore_dir = "$wp_dir/EZPZ_RESTORATION_FILES";


    if (file_exists("$ezpz_restore_dir/$wp_dir_name" . "_EZPZ_COPY")) {
        $folder_size = bytes_to_Xb(folder_size_in_bytes($ezpz_restore_dir));

        $blog_name = get_bloginfo('name');
        $url_slug = "?dir=$ezpz_restore_dir" . "&amp;site=" . site_url();
        $clear_files = site_url() . "/wp-content/plugins/" . ezpz_ocb_slug() .
          "/functions/ezpz-ocb-clear-files.php$url_slug";
        echo "<div id='notice' class='updated'><p><center><b>$blog_name</b> has been
        successfully restored by <b>EZPZ OCB Easy Restore</b>.<br/>If everything seems
        normal it's safe to remove the $folder_size of <em>EZPZ_RESTORATION_FILES</em>
        left after restoration by <a href='$clear_files'>Clicking_here</a>.</center></p></div>";
    }
}

function forbidden() {

    return "
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
}

function ezpz_ocb_updates() {

    global $wpdb;
    // $updated = get_option('ezpz_ocb_updated');

    // $update_slug = "http://ezpzsolutions.net/wp-content/uploads/plugins/ocb/" . ezpz_ocb_version();

    // if (file_get_contents("$update_slug/faq-update.ocb") !== false) {
        // $new_faq = file_get_contents("$update_slug/faq-update.ocb");
        // $faq_path = ABSPATH . "wp-content/plugins/" . ezpz_ocb_slug() . "/pages/ezpz-ocb-faq.php";
        // $old_faq = file_get_contents($faq_path);

        // if ($old_faq !== $new_faq && strlen($new_faq) > 5) {
            // file_put_contents($faq_path, $new_faq);
            // if (!strpos($updated, 'faq')) {
                // $updated = $updated . 'faq';
            // }
        // }
    // }

    // if (file_get_contents("$update_slug/faq-update.ocb") !== false) {
        // $new_news = file_get_contents("$update_slug/news-update.ocb");
        // $news_path = ABSPATH . "wp-content/plugins/" . ezpz_ocb_slug() . "/pages/ezpz-ocb-news.php";
        // $old_news = file_get_contents($news_path);

        // if ($old_news !== $new_news && strlen($new_news) > 5) {
            // file_put_contents($news_path, $new_news);
            // if (!strpos($updated, 'news')) {
                // $updated = $updated . 'news';
            // }
        // }
    // }
	$updated = "";
    update_option('ezpz_ocb_updated', $updated);
}

function ezpz_ocb_check_updates() {

    if (get_option('ezpz_ocb_updated') != '') {
        echo "<div id='notice' class='updated'><p>";

        if (strpos(get_option('ezpz_ocb_updated'), 'faq') > -1 && strpos(get_option('ezpz_ocb_updated'), 'news') > -1) {
            echo "<b>EZPZ OCB FAQ and News</b> have new updates.";
        } elseif (strpos(get_option('ezpz_ocb_updated'), 'faq') > -1) {
            echo "<b>EZPZ OCB FAQ</b> has new updates.";
        } elseif (strpos(get_option('ezpz_ocb_updated'), 'news') > -1) {
            echo "<p><b>EZPZ OCB News</b> has new updates.</p>";
        }
        echo "</p></div>";
    }
}

?>