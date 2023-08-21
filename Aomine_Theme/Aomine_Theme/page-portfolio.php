<?php get_header();
$homepageurl = get_stylesheet_directory_uri();?>
<main>
<?= the_content() ?>
<section class="portfolio-page">
            <div class="container">
                <?php 
                    $portfolio_tags = array(
                        'taxonomy' => 'portfolio_category',
                        'order' => 'DESC',
                        'hide_empty' => 0
                    );
                    $portfolio_tag_list = get_categories($portfolio_tags);
                ?>
                <div class="portfolio-page__tabs ">
                    <div class="portfolio-page__tab tab tab--active" data-slug="all">ALL</div>
                    <?php 
                    foreach($portfolio_tag_list as $tag) { ?>
                        <div class="portfolio-page__tab tab" data-name="<?= $tag -> name ?>" data-slug="<?= $tag -> slug ?>"><?= $tag->name ?></div>
                    <?php } ?>
                    <!-- <div class="portfolio-page__tab tab tab--active">bathhouse</div>
                    <div class="portfolio-page__tab tab">house painting</div>
                    <div class="portfolio-page__tab tab">bathroom</div>
                    <div class="portfolio-page__tab tab">Room</div>
                    <div class="portfolio-page__tab tab">Kitchen</div>
                    <div class="portfolio-page__tab tab">2021 year</div>
                    <div class="portfolio-page__tab tab">2022 year</div>
                    <div class="portfolio-page__tab tab">2023 year</div> -->
                </div>

                    <div class="portfolio-page__content">
                            <h2 class="portfolio-page__title">ALL</h2>
                            <div class="portfolio-page__grid">

                        <?php
                            $args = array(
                                'post_type' => 'portfolio',
                            );
                            $portfolio_query = new WP_Query( $args );
                            
                            if( $portfolio_query->have_posts() ) :
                                while( $portfolio_query->have_posts() ) :
                                    $portfolio_query->the_post();
                                            // $head_img_thumb = get_the_post_thumbnail_url( get_the_id(), 'full' );
                                    echo '<a href="'. get_the_post_thumbnail_url() .'" data-fancybox="ALL" data-caption="'. get_the_title() .'">
                                    <img src="'. get_the_post_thumbnail_url() .'" alt="'.get_the_title().'">
                                        </a>';
                                endwhile;
                            endif;
                            wp_reset_postdata();
                        ?>
                        </div>
                    </div>
                 
                </div>
        </section>
    </main>
</main>
<?php get_footer(); ?>




