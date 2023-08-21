<!DOCTYPE html>
<html <?php language_attributes();?> class="no-js no-svg">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/assets/style/style.css">
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/assets/style/slick-theme.css">
    <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
/>
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
    <title><?= the_title() ?></title>
    <?php wp_head();?> 

</head>
<body>
    <header>
        <div class="container">
            <div class="header__container">
                <?= is_front_page() ? 
                '<img src="'. get_stylesheet_directory_uri(  ) .'/assets/images/logo.svg" alt="Header Logo" class="header__logo">' :
                 '<a href="'. get_home_url() .'"><img src="'. get_stylesheet_directory_uri(  ) .'/assets/images/logo.svg" alt="Header Logo" class="header__logo"></a>' ?>
                <nav class="header__nav">
                    <?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'container' => 'ul' , 'items_wrap' => '<ul id="%1$s" class="">%3$s</ul>', ) ); ?>
                </nav>
                <a href="/contacts/" class="header__btn btn">consultation</a>
                <div class="menu-btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
    
            <div class="menu">
                <nav>
                <?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'container' => 'ul' , 'items_wrap' => '<ul id="%1$s" class="">%3$s</ul>', ) ); ?>
                   <a href="/contacts/" class="btn">consultation</a>
                </nav>
            </div>
        </div>
    </header>