<?php

// add_action('init', 'my_theme_setup');
// function my_theme_setup(){
// 	load_theme_textdomain('fav', get_template_directory() . '/languages');
// }

/*========== Create Tables for contact form and subscription ===========*/

function create_users_table() {
  global $wpdb;

  $sql_contact_form = "CREATE TABLE IF NOT EXISTS users_contact_form ( ";
  $sql_contact_form .= "`id` int(10) NOT NULL AUTO_INCREMENT,";
  $sql_contact_form .= "`name` varchar(100) NOT NULL,";
  $sql_contact_form .= "`email` varchar(100) NOT NULL,";
  $sql_contact_form .= "`message` varchar(255) NOT NULL,";
  $sql_contact_form .= "`date` varchar(100) NOT NULL,";
  $sql_contact_form .= "PRIMARY KEY(`id`)";
  $sql_contact_form .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8; ";

	$sql_subscribers_form = "CREATE TABLE IF NOT EXISTS users_subscribers ( ";
	$sql_subscribers_form .= "`id` int(10) NOT NULL AUTO_INCREMENT,";
	$sql_subscribers_form .= "`email` varchar(100) NOT NULL,";
	$sql_subscribers_form .= "`date` varchar(100) NOT NULL,";
	$sql_subscribers_form .= "PRIMARY KEY(`id`)";
  $sql_subscribers_form .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8; ";

  require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
  dbDelta($sql_contact_form);
	dbDelta($sql_subscribers_form);
}

add_action('init', 'create_users_table');

/*===== include wp-api to live search =====*/
function get_image_src( $object, $field_name, $request ) {
  $feat_img_array = wp_get_attachment_image_src(
    $object['featured_media'], // Image attachment ID
    'thumbnail',  // Size.  Ex. "thumbnail", "large", "full", etc..
    true // Whether the image should be treated as an icon.
  );
  return $feat_img_array[0];
}

wp_enqueue_script( 'wp-api' );
add_action( 'rest_api_init', 'add_thumbnail_to_JSON' );
function add_thumbnail_to_JSON() {
register_rest_field(
  array('post','casino','vegashero_games'), // Where to add the field (Here, blog posts. Could be an array)
  'featured_image_src', // Name of new field (You can call this anything)
  array(
      'get_callback'    => 'get_image_src',
      'update_callback' => null,
      'schema'          => null,
  )
);
}
/*===== Remove standart scripts =====*/

add_action('init', 'deregister_scripts');
function deregister_scripts() {
    if ( !is_admin() ) wp_deregister_script('jquery');
}

add_action( 'init', 'disable_emojis' );
function disable_emojis() {
  	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  	remove_action( 'wp_print_styles', 'print_emoji_styles' );
  	remove_action( 'admin_print_styles', 'print_emoji_styles' );
  	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}

/*========== Register all style on front end ==========*/

add_action('wp_enqueue_scripts', 'register_box_styles_theme_action', 99);

function register_box_styles_theme_action()
{
    global $fav_theme_uri;

    // Styles - register to be queued later
    wp_register_style('all-styles', $fav_theme_uri . '/assets/css/style.css', array());
    wp_register_style('single-casino', $fav_theme_uri . '/assets/css/single-casino.css', array());
    wp_register_style('single-game', $fav_theme_uri . '/assets/css/single-slot.css', array());
    wp_register_style('single-provider', $fav_theme_uri . '/assets/css/single-provider.css', array());
    wp_register_style('single-payment', $fav_theme_uri . '/assets/css/single-payment.css', array());
    wp_register_style('single-blog', $fav_theme_uri . '/assets/css/single-blog.css', array());
    wp_register_style('all-casino', $fav_theme_uri . '/assets/css/all-casino.css', array());
    wp_register_style('all-slots', $fav_theme_uri . '/assets/css/all-slots.css', array());
    wp_register_style('all-providers', $fav_theme_uri . '/assets/css/all-providers.css', array());
    wp_register_style('all-payments', $fav_theme_uri . '/assets/css/all-payments.css', array());


    wp_register_style('front-page-styles', $fav_theme_uri . '/assets/css/front-page.css.css', array());
    wp_register_style('fav-css-generate-shortcode', $fav_theme_uri . '/assets/css/generate-shortcode.css', array());  
    wp_register_style('simple-page', $fav_theme_uri . '/assets/css/simple-page.css', array());
    wp_register_style('error-page', $fav_theme_uri . '/assets/css/error.css', array());
    wp_register_style('contacts-page', $fav_theme_uri . '/assets/css/contacts.css', array());



    // Scripts - register to be queued later
    wp_register_script('all-js', $fav_theme_uri . '/assets/js/all.js', array(), '', true);
    wp_register_script('page-casino', $fav_theme_uri . '/assets/js/page-casino.js', array(), '', true);
    wp_register_script('page-slots', $fav_theme_uri . '/assets/js/page-slots.js', array(), '', true);
    wp_register_script('page-providers', $fav_theme_uri . '/assets/js/page-providers.js', array(), '', true);
    wp_register_script('page-payments', $fav_theme_uri . '/assets/js/page-payments.js', array(), '', true);
    wp_register_script('single-casino-js', $fav_theme_uri . '/assets/js/single-casino.js', array(), '', true);
    wp_register_script('contacts-page-js', $fav_theme_uri . '/assets/js/page-contacts.js', array(), '', true);


// localize script

wp_localize_script('home-page' , 'homepage_js', [
  'homeurl' => get_bloginfo('url')
]);

wp_localize_script('all-js' , 'homepage_js', [
  'homeurl' => get_bloginfo('url'),
  'admin_ajax' => get_bloginfo('url').'/wp-admin/admin-ajax.php'
]);
wp_localize_script('contacts' , 'homepage_js', [
  'homeurl' => get_bloginfo('url'),
  'admin_ajax' => get_bloginfo('url').'/wp-admin/admin-ajax.php'
]);



}

/*============== Include styles to wp-admin ================*/

function admin_style() {
		global $fav_theme_uri;

    wp_enqueue_style('fav-css-generate-shortcode', $fav_theme_uri . '/assets/css/generate-shortcode.css', array());
		wp_enqueue_style('fav-css-casino-loop', $fav_theme_uri . '/assets/css/casino-loop.css', array());
		wp_enqueue_script('fav-js-generate-shortcode', $fav_theme_uri . '/assets/js/generate-shortcode.js', array(), '', true);

		wp_localize_script('fav-js-generate-shortcode', 'fav_ajax', [
        'ajax_url' => site_url() . '/wp-admin/admin-ajax.php',
        'ajax_nonce' => wp_create_nonce('ajax_nonce'),
    ]);
}
add_action('admin_enqueue_scripts', 'admin_style');

/*=========== Check country code for user ip (US, UK etc.) ===========*/

function check_country() {
  $user_ip = '';
  if (getenv('HTTP_CLIENT_IP'))
      $user_ip = getenv('HTTP_CLIENT_IP');
  else if(getenv('HTTP_X_FORWARDED_FOR'))
      $user_ip = getenv('HTTP_X_FORWARDED_FOR');
  else if(getenv('HTTP_X_FORWARDED'))
      $user_ip = getenv('HTTP_X_FORWARDED');
  else if(getenv('HTTP_FORWARDED_FOR'))
      $user_ip = getenv('HTTP_FORWARDED_FOR');
  else if(getenv('HTTP_FORWARDED'))
      $user_ip = getenv('HTTP_FORWARDED');
  else if(getenv('REMOTE_ADDR'))
      $user_ip = getenv('REMOTE_ADDR');
  else
      $user_ip = 'UNKNOWN';
  if($_COOKIE['user_country'] == NULL || empty($_COOKIE['user_country']) || $_COOKIE['user_country'] == ''):
    $json = file_get_contents('http://ip-api.com/json/'.$user_ip.'?key=RzZOfj25suwQEpS&fields=countryCode');
    $data = json_decode($json);
    // setcookie("user_country", $data->countryCode);
  endif;

  return $data->countryCode;
}

/*======== Create global VAR for project ==========*/

function fav_global_variables() {
    global $fav_theme_uri, $fav_blog_url;
    $fav_theme_uri = get_stylesheet_directory_uri();
		$fav_blog_url = get_bloginfo('url');
}
add_action( 'after_setup_theme', 'fav_global_variables' );

/*========= TAXONOMY DATE CREATED AND UPDATED ============*/

add_action( "create_payments", 'payments_create_date', 10, 2 );
function payments_create_date( $term_id, $tt_id){
    update_option('payment_create_date_'.$term_id, time());
}

add_action ('edited_payments', 'update_payments_function');
function update_payments_function( $term_id )
{
    update_option('payment_update_date_'.$term_id, time());
}

add_action( "create_game_provider", 'providers_create_date', 10, 2 );
function providers_create_date( $term_id, $tt_id){
    update_option('provider_create_date_'.$term_id, time());
}
add_action ('edited_game_provider', 'update_providers_function');
function update_providers_function( $term_id )
{
    update_option('provider_update_date_'.$term_id, time());
}

/*========= END TAXONOMY DATE CREATED AND UPDATED ============*/

/*========= Header Functions ===============*/

// function add_rel_preload($html, $handle, $href, $media) {
//
// $html = <<<EOT
// <link rel='preload' as='style' onload="this.onload=null;this.rel='stylesheet'"
// id='$handle' href='$href' type='text/css' media='all' />
// EOT;
// 	return $html;
// }
//
// add_filter( 'style_loader_tag', 'add_rel_preload', 10, 4 );
//
// function remove_script_version( $src ){
//   $parts = explode( '?ver', $src );
//   return $parts[0];
// }
//
// add_filter( 'script_loader_src', 'remove_script_version', 15, 1 );
// add_filter( 'style_loader_src', 'remove_script_version', 15, 1 );
//
// add_filter( 'script_loader_src', 'slotys_src' );
// add_filter( 'style_loader_src', 'slotys_src' );
// function slotys_src( $url )
// {
//     if( is_admin() ) return $url;
//     return str_replace( site_url(), '', $url );
// }

function register_my_menus() {
    register_nav_menus(
    array(
     'nav-2' => ( 'Nav 2' ),
     'aside-menu' => ( ' Aside Menu ' ),
     'footer-menu1' => ( 'Footer Menu1' ),
     'footer-menu2' => ( 'Footer Menu2' ),
     'footer-menu3' => ( 'Footer Menu3' ),
     'footer-menu4' => ( 'Footer Menu4' )
     )
     );
    }
    add_action( 'init', 'register_my_menus' );

add_action( 'admin_menu', 'fav_forms_page' );
function fav_forms_page() {

  add_menu_page(
    'Emails from Forms', // page <title>Title</title>
    'Emails', // menu link text
    'manage_options', // capability to access the page
    'forms-emails', // page URL slug
    'emails_forms_function', // callback function /w content
    'dashicons-media-text', // menu icon
    90 // priority
  );

}

/*===== Add styles and template to generate shortcode page =====*/

function emails_forms_function() {

  get_template_part('template-parts/content', 'emails-forms');

}

$games_args = array(
  'post_type' => 'vegashero_games',
  'posts_per_page' => -1,
  'post_status' => 'publish'
);
$query_games = new WP_Query($games_args);
$image_count = 1;
while ($query_games->have_posts()) : $query_games->the_post();
  if(!has_post_thumbnail() && current_user_can('edit_dashboard')) {
    $slug = get_post_field( 'post_name', get_the_ID() );
    $post_id = get_the_ID();
    $img_url = 'http:' . get_post_field('game_img', $post_id);
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($img_url);
    $filename = $slug .'_image_'. basename($img_url);
    if(wp_mkdir_p($upload_dir['baseurl'] . '/games/'))
      $file = $upload_dir['baseurl'] . '/games/' . $filename;
    else
      $file = $upload_dir['basedir'] . '/games/' . $filename;
    file_put_contents($file, $image_data);

    $wp_filetype = wp_check_filetype($filename, null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
    $res2= set_post_thumbnail( $post_id, $attach_id );
  }
  $image_count++;
endwhile;


function setup_theme() {
  add_theme_support( 'title-tag' );
}

add_action( 'after_setup_theme', 'setup_theme' );
add_filter( 'document_title_parts', 'mytheme_remove_title' );
function mytheme_remove_title( $title ){
  if ( !is_home() ) {
    $title['site'] = '';
  }
  return $title;
}

// Add Texonomy on Edit page
// function add_taxonomy_boxes_side() {
//   add_meta_box('casino-type', 'Chose Casino Type Casino', 'post_categories_meta_box', 'casino', 'side', 'high', array( 'taxonomy' => 'casino-type' ));
// }
// add_action('admin_menu', 'add_taxonomy_boxes_side');
add_filter( 'upload_mimes', 'svg_upload_allow' );

# Добавляет SVG в список разрешенных для загрузки файлов.
function svg_upload_allow( $mimes ) {
	$mimes['svg']  = 'image/svg+xml';

	return $mimes;
}
add_filter( 'wp_check_filetype_and_ext', 'fix_svg_mime_type', 10, 5 );

# Исправление MIME типа для SVG файлов.
function fix_svg_mime_type( $data, $file, $filename, $mimes, $real_mime = '' ){

	// WP 5.1 +
	if( version_compare( $GLOBALS['wp_version'], '5.1.0', '>=' ) ){
		$dosvg = in_array( $real_mime, [ 'image/svg', 'image/svg+xml' ] );
	}
	else {
		$dosvg = ( '.svg' === strtolower( substr( $filename, -4 ) ) );
	}

	// mime тип был обнулен, поправим его
	// а также проверим право пользователя
	if( $dosvg ){

		// разрешим
		if( current_user_can('manage_options') ){

			$data['ext']  = 'svg';
			$data['type'] = 'image/svg+xml';
		}
		// запретим
		else {
			$data['ext']  = false;
			$data['type'] = false;
		}

	}

	return $data;
}
?>
