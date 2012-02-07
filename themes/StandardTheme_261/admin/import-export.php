<form method="post" action="#/import-export">
<?php //Security Nonce For Cross Site Hacking
$nonce= wp_create_nonce(md5('standard_framework'.date('D')));?>
<input type="hidden" name="_wpnonce" value="<?=$nonce?>" />


<?php
global $export_message;
echo $export_message;

//Create Export Code

$opts_to_export = get_option('standard_framework_'.STANDARD_FRAMEWORK_SHORT_NAME);
if(is_array($opts_to_export)):
    $encoded = 'standard_framework_'.STANDARD_FRAMEWORK_SHORT_NAME."~~";
    foreach($opts_to_export as $k => $v):
        if($v):
            $encoded .= $k.'|'.$v.'||';
        endif;
    endforeach;

    $encoded = base64_encode(substr($encoded, 0, -2));
    $encoded_check = true;
else:
    $encoded = "No theme options found. Please refresh the theme options to generate an export code.";
    $encoded_check = false;
endif;

//Create Export Options

$export = array (
    array(  "name" => STANDARD_FRAMEWORK_NAME." Export Code",
            "desc" => "Copy and paste this code to somewhere safe.",
            "id" => "standard_export",
            "type" => "textarea",
            "value" => $encoded,
            "attr" => array("rows" => "12", "class" => "click-copy")
    )
);
render_options($export);

//Create Download Link

if($encoded_check):
    $export = array (
        array(  "name" => "Download ".STANDARD_FRAMEWORK_NAME." Export Code",
                "desc" => "Download and save this file somewhere safe.",
                "id" => "export_file",
                "type" => "button",
                "value" => "Download File",
                "attr" => array("ONCLICK" => "window.location.href='".get_bloginfo('stylesheet_directory').'/admin/export-options.php?f=standardframework_'.STANDARD_FRAMEWORK_SHORT_NAME.'_'.date('mdy').'&e='.$encoded."'")            
        ) 
    );
    render_options($export);
endif;


//Create import options

$import = array (
    array(  "name" => "Import ".STANDARD_FRAMEWORK_NAME." Options",
            "desc" => "Paste your options code here.",
            "id" => "standard_import_code",
            "type" => "textarea",
            "value" => '',
            "attr" => array("rows" => "12", "class" => "standard_import_code")
            
    ),
        
    array(  "name" => "",
            "desc" => "Notice: This overwrites your current options.",
            "id" => "standard_import",
            "type" => "submit",
            "value" => 'Import Options Code'
    )
);
render_options($import);

//Create Restore Defaults Option
$import = array (
    array(  "name" => "Restore Theme Defaults",
            "desc" => "Refresh all options to original defaults.",
            "id" => "standard_defaults",
            "type" => "submit",
            "value" => 'Restore Defaults'
    ));
render_options($import);
?>

</form>