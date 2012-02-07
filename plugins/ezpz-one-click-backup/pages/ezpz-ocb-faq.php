<?php
global $wpdb;
head_template("EZPZ OCB - Frequently Asked Questions", false, false);
?>
<style>
    #faq-body {
        font-family: Georgia, 'Times New Roman' , 'Bitstream Charter', Times,serif;
        text-shadow:rgba(255,255,255,1) 0 1px 0;
        color:#464646;
    }

    .faq-answer{
        margin: 2px 2px 2px 20px;
    }

    .hilite {
        background-color:#ffffe0;
        border-color:#e6db55;
        border-width:1px;
        border-style:solid;
        padding:.3em .6em;
        margin:5px 35px 2px 15px;
    }
</style>

<div id="faq-body">
    <h3><em>Q: How do I restore my site from a backup using EZPZ Easy Restore?</em></h3>
    <p><b>NOTE: EZPZ Easy Restore only works on backups made with version 5.0.x and above.</b><br/>
        Please make a new backup when installing a this version.</p>
    <div class="faq-answer"><p>A: It&apos;s actually pretty easy, only 2 steps are required.</p>
        <ol><li>Using FTP or Cpanel, upload the zip file you wish to restore from
                your computer to <b><?php echo get_bloginfo('name'); ?>&apos;s</b> root folder
                (<em><?php echo ABSPATH; ?></em>) then using Cpanel, unzip (unarchive)
                the zip file you uploaded into the same folder.
                <p class="hilite" >
				If you are unable to unarchive the zip file via Cpanel you&apos;ll need to unzip it
				on your computer then upload the entire <b>EZPZ_RESTORATION_FILES</b> folder
                    into <b><?php echo get_bloginfo('name'); ?>&apos;s</b> root folder.<br/>
                    <b>DO NOT</b> unarchive the tgz file contained within the restoration
                    folder, just unzip the folder.</p> </li>
            <li>In your browser go to <b><?php echo site_url(); ?>/EZPZ_RESTORATION_FILES/EZPZ_RESTORE.PHP
                </b> and watch the magic happen...<br/>
                <p class="hilite" >The above link is only active after the previous two steps are
				performed. It will give a <b>404 Page Not Found error</b> when an auto restoration
				isn&apos;t allowed or possible.</p></li>
        </ol>
        <p><b><?php echo get_bloginfo('name'); ?></b> will now be automatically
            restored to the date and time the backup you selected was made.</p>
        <p class="hilite" >If anything goes wrong there&apos;s no need to worry, all the old
            files have been saved and are available for manual restoration at
        <em><?php echo ABSPATH . "EZPZ_RESTORATION_FILES"; ?></em></p>
    </div></div> <!-- faq-body -->
<?php
foot_template();
if (get_option('ezpz_ocb_updated') != '') {
    $updated = str_replace('faq', '', get_option('ezpz_ocb_updated'));
    update_option('ezpz_ocb_updated', $updated);
}
?>