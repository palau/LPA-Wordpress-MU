<?php
global $wpdb;
$blog_tz = get_option('timezone_string');
if ($blog_tz == "" || $blog_tz == null) {
    $blog_tz = "UTC";
}
head_template('EZPZ OCB - About');
?>
<div id="about-page" style="text-align: justify;">
    <div id="nav-menu" style="text-align: center">
        <ul><li style="display: inline;"><a style="font-size: 14px; font-weight: bold;" href="<?php echo site_url(); ?>/wp-admin/admin.php?page=ezpz_ocb_backup" target="_self">
                    Backup Now</a>&nbsp;&nbsp;&nbsp;&nbsp;| </li>
            <li style="display: inline;"><a style="font-size: 14px; font-weight: bold;" href="<?php echo site_url(); ?>/wp-admin/admin.php?page=ezpz_ocb_options" target="_self">
                    Choose Options</a>&nbsp;&nbsp;&nbsp;&nbsp;| </li>
            <li style="display: inline;"><a style="font-size: 14px; font-weight: bold;" href="<?php echo site_url(); ?>/wp-admin/admin.php?page=ezpz_ocb_download" target="_self">
                    Download Backup</a>&nbsp;&nbsp;&nbsp;&nbsp;| </li>
            <li style="display: inline;"><a style="font-size: 12px; font-weight: bold;" href="<?php echo site_url(); ?>/wp-admin/admin.php?page=ezpz_ocb_faq" target="_self">
                    FAQs</a>&nbsp;&nbsp;&nbsp;&nbsp;| </li>
            <li style="display: inline;"><a style="font-size: 12px; font-weight: bold;" href="<?php echo site_url(); ?>/wp-admin/admin.php?page=ezpz_ocb_news" target="_self">
                    News</a></li></ul></div>
    <center><p style="
					 margin-top: 5px;
                     font-size: large;
                     font-family: Georgia, 'Times New Roman', 'Bitstream Charter', Times,serif;
                     color: darkred;">
                <b>Now with EZPZ Easy Restore!!!</b></p></center>
    <div style="text-align: center;
         font-weight: bold;
         line-height: 80%;
         border-color:#2a2a2a;
         border-width:2px;
         border-style:solid;
         padding:.3em .6em;
         margin:5px auto;
         -moz-border-radius:5px;
         -khtml-border-radius:5px;
         -webkit-border-radius:5px;
         border-radius:5px;">
        <ul><li><big>New in version <?php echo ezpz_ocb_version(); ?></big></li>
            <li>Restoring your site from a backup is now a simple two step process with EZPZ Easy Restore.</li>
            <!--<li>EZPZ OCB now has FAQ and News pages which are automatically updated as needed.</li>-->
        </ul>
    </div>

    <p>EZPZ One Click Backup, or EZPZ OCB as we call it, is a very easy way to do a complete backup of your entire Wordpress site.
        In fact it's so easy to use there are no required user settings, everything is automatic.
        Just one click and presto, you'll have a complete backup stored on your server.
        One more click and you can download the entire backup to your own computer.</p>
    <p>If you prefer to download your backup via FTP the path you'll need is also included.
        EZPZ OCB also stores your last backup on the server
        should you ever need to download it again.</p>
    <p>With the new <b>EZPZ Easy Restore</b> feature restoring your site is a simple two step process.
        <small>See <a href="<?php echo site_url(); ?>/wp-admin/admin.php?page=ezpz_ocb_faq" target="_self">
               FAQs</a> for instructions.</small></p>
    <p>Now just because no settings are required doesn't mean there are no
        <a href="<?php echo site_url(); ?>/wp-admin/admin.php?page=ezpz_ocb_options" target="_self">
            options</a>. There are several choices that can make your backup the way you want.
    <ol><li>You can schedule backups ranging from 4 times a day to once per week.</li>
        <li>The option to choose the timezone your backup's datestamp is based on.</li>
        <li>Choose one of eight datestamp formats for your backup.</li>
        <li>If you're using a shared database you can choose to backup only the tables needed for your WordPress installation.</li>
        <li>You can adjust the speed of EZPZ OCB to best match your server's capabilities.</li>
        <li>You can choose to exclude selected folders you don't want to include in the backup.</li>
        <li>You can choose to remove the color and font styling from the backup progress page.</li></ol>
    <p>Like most applications EZPZ OCB has certain limitations and requirements.
        First and foremost, EZPZ OCB <strong>only works on Linux servers running PHP 5 and above</strong>
        and only those servers which allow certain required php functions with <em>exec</em> and <em>mysqldump</em>
        seeming to be the most frequently unavailable ones. EZPZ OCB now has improved error messaging to help
        determine if it is compatible with your server.</p>
    <p>Most WordPress users will have no problems but there are some servers with which EZPZ OCB is simply incompatible. Sorry...</p>
    <p><span style="font-size: large;">On the drawing board...</span></p>
    <ul>
        <li>Internationalization.</li>
        <li>Amazon S3 (Simple Storage Service) integration.</li>
    </ul>
</div>
<?php foot_template(); ?>