<?php 	/* This file generates CSS for Classic based on style options chosen in the settings */ ?>
<?php 
	$settings = wptouch_get_settings(); 
	$head_bg_shade = 				$settings->classic_header_shading_style;
	$head_font =						$settings->classic_header_font;
	$head_font_size = 				$settings->classic_header_title_font_size;
	$head_color = 						$settings->classic_header_color_style;

	$gen_font = 						$settings->classic_general_font;
	$gen_font_size = 					$settings->classic_general_font_size;
	$gen_font_color =				$settings->classic_general_font_color;

	$post_title_font = 				$settings->classic_post_title_font;
	$post_title_font_size = 		$settings->classic_post_title_font_size;
	$post_title_color = 				$settings->classic_post_title_font_color;

	$post_body_font = 				$settings->classic_post_body_font;
	$post_body_font_size = 		$settings->classic_post_body_font_size;

	$link_color =						$settings->classic_link_color;
	$context_headers_color = 	$settings->classic_context_headers_color;
	$footer_text_color = 			$settings->classic_footer_text_color;
	$custom_background =		$settings->classic_custom_background_image;
	$text_drop_shade =				$settings->classic_text_shade_color;
	$custom_cal_color =				$settings->classic_custom_cal_icon_color;
?>
<style type="text/css">

body { 
	font: <?php echo $gen_font_size ?> "<?php echo $gen_font ?>", Helvetica, Geneva, Arial, sans-serif;
	color: #<?php echo $gen_font_color ?>;
<?php if ( $settings->classic_custom_background_image ) { ?>
	background: url( <?php echo $settings->classic_custom_background_image; ?> ) repeat 0 0 !important; 
<?php } ?>
}

#header { 
<?php if ( $settings->classic_header_shading_style != 'none' ) { ?>
	background-image: url(<?php wptouch_bloginfo( 'template_directory' ); ?>/images/<?php echo $head_bg_shade ?>.png); 
<?php } ?>
	font: <?php echo $head_font_size ?> "<?php echo $head_font ?>", Helvetica, Geneva, Arial, sans-serif;
}

a { color: #<?php echo $link_color ?>; }

.post h2, .post h2 a { color: #<?php echo $post_title_color ?>; font: <?php echo $post_title_font_size ?> "<?php echo $post_title_font ?>", Helvetica, Geneva, Arial, sans-serif; }

#content .content, #content .page .content, #content .post.single { font: <?php echo $post_body_font_size ?> "<?php echo $post_body_font ?>", Helvetica, Geneva, Arial, sans-serif; }

#respond h3,
p.nocomments,
#respond p,
form#commentform p,
#loading p,
form#commentform label,
.archive-text,
.linkcat h2,
h2.wptouch-archives,
h2.iphone-list,
ul.iphone-list li span {
	color: #<?php echo $context_headers_color ?>;
<?php if ( $text_drop_shade = 'light' ) { ?>
	text-shadow: #fff 0 1px 0;
<?php } else { ?>
	text-shadow: #000 0 -1px 0;
<?php } ?>
}

#respond h3,
p.nocomments,
#respond p,
form#commentform p,
#loading p,
form#commentform label,
.archive-text,
.linkcat h2,
h2.wptouch-archives,
h2.iphone-list,
.load-more-link,
ul.iphone-list li span,
#switch, 
.footer {
<?php if ( $settings->classic_text_shade_color == 'light' ) { ?>
	text-shadow: #fff 0 1px 0;
<?php } else { ?>
	text-shadow: #000 0 -1px 1px;
<?php } ?>
}

.cal-custom .cal-month { background-color: #<?php echo $custom_cal_color ?>; }

#switch, .footer { color: #<?php echo $footer_text_color ?>; }

</style>