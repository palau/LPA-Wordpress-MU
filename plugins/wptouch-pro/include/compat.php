<?php

// Force removal of Paginated Comments plugin
remove_action( 'init', 'Paginated_Comments_init' );
remove_action( 'admin_menu', 'Paginated_Comments_menu_add' );
remove_action( 'template_redirect', 'Paginated_Comments_alter_source', 15 );
remove_action( 'wp_head', 'Paginated_Comments_heads' );
remove_filter( 'comment_post_redirect', 'Paginated_Comments_redirect_location', 1, 2 );

//// Intense Debate
//remove_action( 'init', 'id_request_handler' );
//remove_action( 'admin_notices', 'id_admin_notices' );
//remove_action( 'admin_menu', 'id_menu_items' );
//remove_action( 'init', 'id_process_settings_page' );
//remove_action( "admin_head", 'id_settings_head' );
//remove_action( 'admin_print_footer_scripts', 'id_get_comment_footer_script', 21 );
//remove_action( 'admin_footer', 'id_get_comment_footer_script', 100 );
//remove_action( 'admin_print_footer_scripts', 'id_admin_footer', 21 );
//remove_action( 'admin_footer', 'id_admin_footer', 100 );
//remove_action( 'comment_post', 'id_save_comment' );
//remove_action( 'trackback_post', 'id_save_comment' );
//remove_action( 'pingback_post', 'id_save_comment' );
//remove_action( 'edit_comment', 'id_save_comment' );
//remove_action( 'save_post', 'id_save_post' );
//remove_action( 'delete_post', 'id_delete_post' );
//remove_action( 'wp_set_comment_status', 'id_comment_status', 10, 2 );
//remove_action( 'trashed_comment', 'id_comment_trashed', 10 );
//remove_action( 'untrashed_comment', 'id_comment_untrashed', 10 );
//remove_action( 'show_user_profile', 'id_show_user_profile' );
//remove_action( 'profile_update', 'id_profile_update' );
//remove_action( 'load-options.php', 'id_discussion_settings_page' );
//remove_action( 'wp_footer', 'id_get_comment_footer_script', 21 );
//remove_action( 'get_footer', 'id_get_comment_footer_script', 100 );
//remove_action( 'shutdown', 'id_ping_queue' );
//remove_action( 'edit_comment', 'id_save_comment' );
//remove_action( 'comment_post', 'id_save_comment' );
//remove_action( 'comment_post', 'id_save_comment' );
//remove_action( 'save_post', 'id_save_post' );
//remove_action( 'edit_post', 'tla_send_updated_post_alert' );
//remove_action( 'wp_set_comment_status', 'id_comment_status', 10, 2 );
//remove_action( 'plugins_loaded', 'id_blog_stats_init' );
//remove_action( 'plugins_loaded', 'id_recent_comments_init' );
//remove_action( 'plugins_loaded', 'id_top_commenters_init' );
//remove_action( 'plugins_loaded', 'id_most_commented_posts_init' );
//remove_filter( 'whitelist_options', 'id_whitelist_options' );
//remove_filter( 'comments_template', 'id_comments_template' );
//remove_filter( 'comments_number', 'id_get_comment_number' );

// qTranslate
if ( function_exists( 'qtrans_useCurrentLanguageIfNotFoundShowAvailable' ) ) {
	add_filter( 'wptouch_menu_item_title', 'qtrans_useCurrentLanguageIfNotFoundShowAvailable', 0 );	
}

// Facebook Like button
remove_filter('the_content', 'Add_Like_Button');

//Sharebar Plugin
remove_filter('the_content', 'sharebar_auto');
remove_action('wp_head', 'sharebar_header');

// Hyper Cache

if ( function_exists( 'hyper_activate' ) ) {
global $hyper_cache_stop;
}

?>