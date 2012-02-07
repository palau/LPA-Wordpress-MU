<?php

global $wpdb;
head_template("EZPZ OCB - Latest News", false, false);
?>
<style>
    #page-body {
        font-family: Georgia, 'Times New Roman' , 'Bitstream Charter', Times,serif;
        text-shadow:rgba(255,255,255,1) 0 1px 0;
        color:#464646;
    }

    .page-indent{
        margin: 2px 2px 2px 20px;
    }
</style>

<div id="page-body">
    <h3>Coming Soon</h3>
</div>
<?php

foot_template();
if (get_option('ezpz_ocb_updated') != '') {
    $updated = str_replace('news', '', get_option('ezpz_ocb_updated'));
    update_option('ezpz_ocb_updated', $updated);
}
?>
