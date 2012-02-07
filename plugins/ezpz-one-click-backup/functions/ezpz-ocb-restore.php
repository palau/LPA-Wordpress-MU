<?php

function generate_restore() {

    global $wpdb;
    $rnd_dir = get_rnd_folder();
    $zip_name = get_option('ezpz_ocb_zip_name');
    $timeZone = get_option('ezpz_ocb_save_tz');
    $ds_format = get_option('ezpz_ocb_ds_format');
    $dateSrc = date('Y-m-d H:i:s');
    if ($timeZone == "GMT") {
        $dateTime = new DateTime($dateSrc, new DateTimeZone('GMT'));
        $dateTime->setTimeZone(new DateTimeZone('GMT'));
    } else {
        $dateTime = new DateTime($dateSrc, new DateTimeZone('GMT'));
        $dateTime->setTimeZone(new DateTimeZone($timeZone));
    }

    $datestamp = $dateTime->format('l, F jS, Y \a\t g:ia');

    $blog_url = site_url();
    $blog_name = get_bloginfo('name');
    $plugin_home_url = site_url() . '/wp-admin/admin.php?page=ezpz_ocb';
    $wp_dir = str_replace('/wp-content/plugins', '', WP_PLUGIN_DIR);
    $wp_temp_dir = $wp_dir . "_EZPZ_TEMP";
    $wp_dir_name_tmp = explode('/', $wp_dir);
    $wp_dir_name = end($wp_dir_name_tmp);
    $wp_parent_dir = str_replace("/$wp_dir_name", "", $wp_dir);
    $wp_orig_dir = "$wp_parent_dir/$wp_dir_name" . "_EZPZ_COPY";
    $wp_orig_dir_name = "$wp_dir_name" . "_EZPZ_COPY";
    $tgz_file = "EZPZ_$wp_dir_name.TGZ";


    $db_user = DB_USER;
    $db_password = DB_PASSWORD;
    $db_host = DB_HOST;
    $db_name = DB_NAME;
    $sql_file = "$wp_parent_dir/EZPZ_RESTORATION_FILES/EZPZ_DB.SQL";
    $sql_dump_file = "$wp_orig_dir/EZPZ_DB_DUMP/EZPZ_DB.SQL";
    $sql_insert_cmd = "mysql --host=$db_host --user=$db_user --password=$db_password  $db_name < $sql_file";

    $ckmrk = "&nbsp;<span style='font-family: tahoma, sans-serif; color: green; font-weight: 900;'> &#10004;<small>OK</small></span>";
    $failed = "&nbsp;<span style='font-family: tahoma, sans-serif; color: darkred; font-weight: 900;'> X<small> FAILED</small></span>";

    $restore_script = <<<RESTORE_SCRIPT
<?php

echo "
<head><title>Restoring $blog_name</title></head>
<h2 style='text-align: center; font-family: Tahoma,Helvetica,Arial,sans-serif;'>
EZPZ One Click Backup Restoration</h2>
<p>This application will attempt to restore your <b>$blog_name</b>
WordPress installation to the way it was on $datestamp.</p>
<p>No files will be deleted during the restoration and a fresh database backup
will be performed before restoration begins.</p>
";
sleep(2);
echo "<li>Creating temporary folder and extracting the backup from $datestamp into it.";

mkdir('$wp_temp_dir', 0755);
mkdir('$wp_orig_dir', 0755);
exec("tar -C $wp_temp_dir -zxvf $tgz_file");
sleep(2);
if (file_exists('$wp_temp_dir')) {
    echo " $ckmrk</li><li>Copying <em>$wp_dir_name</em> into <em>$wp_orig_dir_name</em>";
}
exec('cp -r $wp_dir/* $wp_orig_dir');
sleep(2);

if (file_exists('$wp_orig_dir')) {
    echo " $ckmrk</li><li>Create backup of current database.";
}
if (file_exists('$wp_orig_dir')) {
    mkdir("$wp_orig_dir/EZPZ_DB_DUMP");
    db_dump2("$db_host", "$db_user", "$db_password", "$db_name", "$sql_dump_file");
    echo " $ckmrk</li><li>Reset database to the way it was on $datestamp.";
}
exec("$sql_insert_cmd");
sleep(2);
echo " $ckmrk</li><li>Final cleanup... Moving all temporary files, folders and
copies into $wp_dir/EZPZ_RESTORATION_FILES.";
exec("rm -r $wp_dir");
rename('$wp_temp_dir/$wp_dir_name', '$wp_dir');
rename('$wp_orig_dir/EZPZ_RESTORATION_FILES', '$wp_dir/EZPZ_RESTORATION_FILES');
if (file_exists('$wp_orig_dir/$zip_name')) {
    rename('$wp_orig_dir/$zip_name', '$wp_dir/EZPZ_RESTORATION_FILES/$zip_name');
}
rename('$wp_orig_dir', '$wp_dir/EZPZ_RESTORATION_FILES/$wp_orig_dir_name');
rmdir('$wp_temp_dir');

echo " $ckmrk</li><br/><iframe width='100%' height='400px' src ='$blog_url' ></iframe>";

echo "<center><h4>Restoration Complete!<br/>
<a href='$plugin_home_url' target='_self'>Go To EZPZ OCB on $blog_name</a>
</center></h4>";

function db_dump2(\$host, \$user, \$pass, \$name, \$backup_file) {

    \$link = mysql_connect(\$host, \$user, \$pass);
    \$return = '';
    mysql_select_db(\$name, \$link);

    //get all of the tables
    \$tables = array();
    \$result = mysql_query('SHOW TABLES');
    while (\$row = mysql_fetch_row(\$result)) {
        \$tables[] = \$row[0];
    }


    //cycle through
    foreach (\$tables as \$table) {

        \$result = mysql_query('SELECT * FROM ' . \$table);
        \$num_fields = mysql_num_fields(\$result);

        \$return.= 'DROP TABLE ' . \$table . ';';
        \$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE ' . \$table));
        \$return.= '\n\n' . \$row2[1] . ';\n\n';

        for (\$i = 0; \$i < \$num_fields; \$i++) {
            while (\$row = mysql_fetch_row(\$result)) {
                \$return.= 'INSERT INTO ' . \$table . ' VALUES(';
                for (\$j = 0; \$j < \$num_fields; \$j++) {
                    \$row[\$j] = addslashes(\$row[\$j]);
                    \$row[\$j] = preg_replace('/\n/', '/\\n/', \$row[\$j]);
                    if (isset(\$row[\$j])) {
                        \$return.= '"' . \$row[\$j] . '"';
                    } else {
                        \$return.= '""';
                    }
                    if (\$j < (\$num_fields - 1)) {
                        \$return.= ',';
                    }
                }
                \$return.= ');\n';
            }
        }
        \$return.='\n\n\n';
    }

    //save file
    \$handle = fopen(\$backup_file, 'w+');
    fwrite(\$handle, \$return);
    fclose(\$handle);
}
?>
RESTORE_SCRIPT;

    $restore_php = $rnd_dir . "/" . clean_name() . get_zip_date() . "/EZPZ_RESTORE.PHP";

    file_put_contents($restore_php, $restore_script);
}

?>