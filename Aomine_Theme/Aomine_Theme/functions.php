<?php 
// CPT

function register_portfolio_post_type(){
    $labels = array(
        'name' => 'Portfolio',
        'singular_name' => 'Portfolio',
        'add_new' => 'Add Portfolio',
        'add_new_item' => 'Add New Portfolio',
        'edit_item' => 'Edit Portfolio',
        'new_item' => 'New Portfolio',
        'view_item' => 'See Portfolio',
        'not_found' => 'Portfolio Not Found',
        'not_found_in_trash' => 'In trash Portfolio Not Found',
        'parent_item_colon' => '',
        'menu_name' => 'Portfolio',
      );
    
      $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title','editor','author','thumbnail','comments','excerpt'),
    );
      register_post_type('portfolio',$args);
    
    }
    
    add_action( 'init', 'create_portfolio_taxonomies', 0 );
    
    function create_portfolio_taxonomies(){
      $labels = array(
        'name' => _x( 'Category Portfolio', 'taxonomy general name' ),
        'singular_name' => _x( 'Category Portfolio', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Category Portfolio' ),
        'all_items' => __( 'All Category Portfolio' ),
        'parent_item' => __( 'Parent Category Portfolio' ),
        'parent_item_colon' => __( 'Parent Category Portfolio:' ),
        'edit_item' => __( 'Edit Category' ),
        'update_item' => __( 'Refresh Category' ),
        'add_new_item' => __( 'Add New Category' ),
        'new_item_name' => __( 'New Name Category' ),
        'menu_name' => __( 'Category Portfolio' ),
      );
    
      register_taxonomy('portfolio_category', array('portfolio'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'portfolio_category' ),
      ));
    }
    
    add_action('init', 'register_portfolio_post_type');

    
function register_service_post_type() {

	$labels = array(
		'name' => 'Services',
		'singular_name' => 'Service',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Service',
		'edit_item' => 'Edit Service',
		'new_item' => 'New Service',
		'view_item' => 'View Service',
		'search_items' => 'Search Services',
		'not_found' =>  'No services found',
		'not_found_in_trash' => 'No services found in Trash', 
		'parent_item_colon' => '',
		'menu_name' => 'Services'
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => array( 'slug' => 'services' ),
		'capability_type' => 'post',
		'has_archive' => false, 
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','author','thumbnail','excerpt','comments')
	); 

	register_post_type('service',$args);
}

add_action('init', 'register_service_post_type');
// Add thumbnail

if ( ! function_exists( 'main_setup' ) ) :
    function main_setup() {
      /**
       * Enable support for Post Thumbnails on posts and pages.
       * @link //developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
       */
      add_theme_support( 'post-thumbnails' );
    }
    endif;
    add_action( 'after_setup_theme', 'main_setup' );

    // Register Menus
    function register_my_menus() {
        register_nav_menus(
        array(
         'header-menu' => ( 'Header Menu' ),
         'footer-menu' => ( 'Footer Menu' ),
         )
         );
        }
        add_action( 'init', 'register_my_menus' );

        // Add Svg from library
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
  // Add localize function

add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
function my_scripts_method(){
  wp_enqueue_script('jquery');
}
 
add_action( 'wp_enqueue_scripts', 'true_include_myscript' );
function true_include_myscript() {
  wp_enqueue_script( 'slickslider', get_stylesheet_directory_uri() .'/assets/js/slick.min.js', array('jquery'), null, true );
  wp_enqueue_script( 'fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js', null, true );
  wp_enqueue_script( 'newscript', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), null, true );

  wp_localize_script('newscript' , 'homepage_js', [
    'homeurl' => get_bloginfo('url')
  ]);
}




  // action Portfolio
  function filter_category_portfolio() {
    $catSlug = $_POST['category'];
    header("Content-Type: text/html");
  
    if ($catSlug == 'all') {
      $ajaxposts = new WP_Query([
        'post_type' => 'portfolio',
        'posts_per_page' => -1,
      ]);
    } else {
      $ajaxposts = new WP_Query([
        'post_type' => 'portfolio',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'portfolio_category',
                'field' => 'slug',
                'terms' => $catSlug
            )
        )
      ]);
    }
    $response = '
    <h2 class="portfolio-page__title">'.$catSlug.'</h2>
    <div class="portfolio-page__grid">
    ';
  
    if($ajaxposts->have_posts()) {
      while($ajaxposts->have_posts()) : $ajaxposts->the_post();
        $response .= '<a href="'. get_the_post_thumbnail_url() .'" data-fancybox="'. $catSlug .'" data-caption="'. get_the_title() .'">
        <img src="'. get_the_post_thumbnail_url() .'" alt="'. get_the_title() .'"></a>';
      endwhile;
    } else {
      $response = '<span style="color: #fff;">Sorry, but we can"t find to portfolio</span>';
    }
    $response .= '</div>';
    echo $response;
    exit;
  }
  add_action('wp_ajax_filter_category_portfolio', 'filter_category_portfolio');
  add_action('wp_ajax_nopriv_filter_category_portfolio', 'filter_category_portfolio');

  /* Remove the <p> tag from images */
function img_unautop($pee) {
  $pee = preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<figure>$1</figure>', $pee);
  return $pee;
}
function filter_ptags_on_images($content){
  //функция preg replace, которая убивает тег p
      return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
  }
  add_filter('the_content', 'filter_ptags_on_images');

add_filter( 'the_content', 'img_unautop', 30 );

add_filter( 'image_send_to_editor', 'remove_figure_from_image', 10 ); 
function remove_figure_from_image( $html ) { 
$html = preg_replace('/<figure(.*?)>/i', '', $html); 
$html = preg_replace('/<\/figure>/i', '', $html); 
$html = preg_replace('/class=\"(.*?)\"/i', '', $html); 
return $html; 
}

?>

