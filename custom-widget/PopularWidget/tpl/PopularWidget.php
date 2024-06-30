<style>
    .PopularWidgetWrapper {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 32px;
    }

    .PopularWidgetWrapper .popular-item {
        display: flex;
        flex-direction: row;
        column-gap: 24px;
    }

    .PopularWidgetWrapper .popular-item .counter{
        background-color: #3B95FF;
        width: 60px;
        height: 60px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        color: #fff;
        font-family: Inter;
        font-size: 32px;
        font-weight: 700;
        line-height: 38.73px;
        text-align: left;
        aspect-ratio: 1/1;
    }

    .PopularWidgetWrapper .popular-item .popular-item-content {
        display: flex;
        flex-direction: column;
        gap: 16px;
        justify-content: center;
        flex: 1;
    }

    .PopularWidgetWrapper .popular-item .popular-item-content .title {
        color: #000;
        font-family: Inter;
        font-size: 24px;
        font-weight: 700;
        line-height: 29.05px;
        text-align: left;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp:2;  /* Number of lines displayed before it truncate */
        overflow: hidden;
    }

    .PopularWidgetWrapper .popular-item .popular-item-content .topic-wrapper {
        display: flex;
        flex-direction: row;
        gap: 16px;
    }

    .PopularWidgetWrapper .popular-item .popular-item-content .topic-wrapper .topic {
        background-color: #3B95FF;
        border-radius: 45px;
        padding: 10px 16px;
        color: #fff;
        font-family: Inter;
        font-size: 16px;
        font-weight: 400;
        line-height: 19.36px;
        text-align: left;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .PopularWidgetWrapper .popular-item .image img{
        width: 203px;
        border-radius: 12px;
        object-fit: cover;
        height: 114px;
        overflow-clip-margin: unset;
    }

    @media only screen and (max-width: 600px) {
        .PopularWidgetWrapper .popular-item {
            gap: 16px;
        }

        .PopularWidgetWrapper .popular-item .counter{
            font-size: 16px;
            height: 48px;
            width: auto;
        }

        .PopularWidgetWrapper .popular-item .popular-item-content .title{
            font-size: 16px;
        }

        .PopularWidgetWrapper .popular-item .popular-item-content .topic-wrapper .topic{
            font-size: 12px;
            padding: 4px 8px;
        }

        .PopularWidgetWrapper .popular-item .image img{
            width: 100px;
            aspect-ratio: 1/1;
            height: 100%;
        }
    }

</style>

<div id="PopularWidget-<?php echo $id ?>" class="PopularWidgetWrapper">
    <?php 
    
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $posts_per_page,
        'meta_key' => 'post_views_count',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
    );

    $popular_posts_query = new WP_Query($args);
    if ($popular_posts_query->have_posts()) :
        $no= 0;
        while ($popular_posts_query->have_posts()) : $popular_posts_query->the_post();
            $no++;
    ?>
    
        <div class="popular-item">
            <div class="counter">
                <span><?php echo $no ?></span>
            </div>

            <div class="popular-item-content">
                <a href="" class="title"><?php echo __(get_the_title()) ?></a>
                <div class="topic-wrapper">
                    <?php 
                    
                    $categories = get_the_category();
                    foreach ($categories as $category) {
                        ?>
                        <a href="<?php echo get_category_link($category->term_id) ?>" class="topic">
                            <span><?php echo $category->name ?></span>
                        </a>
                        <?php
                    }
                    
                    ?>
                </div>
            </div>

            <div class="image">
                <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full') ?>" alt="">
            </div>
        </div>
    <?php 
        endwhile;
    endif;
    wp_reset_postdata();
    ?>
</div>

<script>
    (function($) {
        'use strict';
        $(document).ready(function() {

            
        });
    })(jQuery);
</script>