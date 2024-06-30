<style>
    .unidex-blog-loop-wrapper .swiper-wrapper {

        gap: 16px;
        width: 100%;
        display: grid;
        align-content: stretch;
        justify-content: start;
        align-items: stretch;
        justify-items: start;
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .unidex-blog-loop-wrapper .card-wrapper {
        display: flex;
        flex-direction: column;
        gap: 24px;
        border-radius: 17px;
        background-color: white;
        overflow: hidden;
        width: 100%;
        background-color: #EEEEEE;
        border-radius: 12px;
        overflow: hidden;
    }

    .unidex-blog-loop-wrapper .card-wrapper .image {
        width: 100%;
        min-height: 190px;
        height: 190px;
        background-color: white;
        overflow: hidden;
        border-radius: 12px;
    }

    .unidex-blog-loop-wrapper .card-wrapper .image img {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }

    .unidex-blog-loop-wrapper .card-wrapper .card-description {
        padding: 0px 24px 24px 24px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        height: 100%;
        justify-content: space-between;
    }

    .unidex-blog-loop-wrapper .card-wrapper .card-description .title{
        display: flex;
        flex-direction: column;
        gap: 16px;
        height: 100%;
    }

    .unidex-blog-loop-wrapper .card-wrapper .card-description .title span{
        font-family: Inter;
        font-size: 12px;
        font-weight: 400;
        line-height: 14.52px;
        text-align: left;
        color: #000000;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp:5;  /* Number of lines displayed before it truncate */
        overflow: hidden;
    }  

    .unidex-blog-loop-wrapper .card-wrapper .card-description .category-wrapper {
        display: flex;
        gap: 10px;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .unidex-blog-loop-wrapper .card-wrapper .card-description .category-wrapper .category-item {
        border-radius: 16px;
        padding: 8px 16px;
        font-family: capitana;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #19156D;
        color: white;
    }

    .unidex-blog-loop-wrapper .card-wrapper .card-description .category-wrapper .category-item a {
        color: white;
    }

    .unidex-blog-loop-wrapper .card-wrapper .card-description .title a{
        font-family: Inter;
        font-size: 24px;
        font-weight: 700;
        line-height: 29.05px;
        text-align: left;
        color: #000000;

    }

    .unidex-blog-loop-wrapper .card-wrapper .card-description .footer-card {
        display: flex;
        gap: 22px;
        font-family: capitana;
        align-items: center;
        font-size: 18px;
        line-height: 1.8;
        justify-content: space-between;
    }

    .unidex-blog-loop-wrapper .card-wrapper .card-description .footer-card a{
        color: white;
        background-color: #3B95FF;
        border-radius: 30px;
        padding: 10px;
        font-family: Inter;
        font-size: 12px;
        font-weight: 500;
        line-height: 14.52px;
        text-align: left;

    }

    .unidex-blog-loop-wrapper .card-wrapper .card-description .footer-card span{
        font-family: Inter;
        font-size: 12px;
        font-weight: 400;
        line-height: 14.52px;
        text-align: left;
        color: black;
    }

    .unidex-blog-loop-wrapper .swiper-button-next,
    .unidex-blog-loop-wrapper .swiper-button-prev {
        display: none;
    }

    .unidex-blog-loop-wrapper .swiper-pagination.custom-related-article {
        display: none;
    }

    @media only screen and (max-width: 768px) {

        .unidex-blog-loop-wrapper .card-wrapper .card-description .title {
            font-size: 18px;
        }
        .unidex-blog-loop-wrapper .card-wrapper .card-description {
            padding: 0px 24px 24px 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            height: 100%;
            justify-content: space-between;
        }

        .unidex-blog-loop-wrapper .card-wrapper {
            height: auto;
        }
    }
</style>

<div id="unidex-blog-loop-wrapper<?php echo $id ?>" class="unidex-blog-loop-wrapper">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php
            if (get_query_var('paged')) {
                $paged = get_query_var('paged');
            } elseif (get_query_var('page')) {
                $paged = get_query_var('page');
            } else {
                $paged = 1;
            }
            $post_id = [];
            // Define query parameters
            $args = array(
                'post_type'      => $post_type,          // Post type (e.g., 'post', 'page', 'custom_post_type')
                'posts_per_page' => $posts_per_page,              // Number of posts per page
                'orderby'        => $orderby,          // Field to order by (e.g., 'date', 'title', 'rand', etc.)
                'order'          => $orderby_option,          // Order direction (e.g., 'ASC', 'DESC')
                'paged'          => $paged,          // Current page number for pagination
                'cat' => $category,
                'ignore_sticky_posts' => 1,
                'post__not_in' => $post_id,
            );

            // Create a new WP_Query instance
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                // Loop through the posts
                while ($query->have_posts()) {
                    $query->the_post();
            ?>

                    <div class="card-wrapper swiper-slide">
                        <div class="image">
                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" alt="<?php the_title(); ?>">
                        </div>

                        <div class="card-description">
                            <div class="title">
                                <a href="<?php echo esc_url(get_permalink()) ?>"><?php echo __(get_the_title()) ?></a>
                                <span><?php echo __(get_the_excerpt()) ?></span>
                            </div>

                            <div class="footer-card">
                                <a href="<?php echo esc_url(get_permalink()) ?>"><?php echo __('Baca Selengkapnya', 'sabiluna') ?></a>
                                <span><?php echo getDifferentTime(get_the_date('Y-m-d H:i:s')) ?></span>
                            </div>
                        </div>
                    </div>

                <?php }
            }?>
        </div>
    </div>
    <!-- !swiper slides -->

    <!-- next / prev arrows -->
    <div class="swiper-button-next custom-next">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="7.4" viewBox="0 0 12 7.4">
            <path id="_Color" data-name=" ↳Color" d="M10.59,0,6,4.574,1.41,0,0,1.408,6,7.4l6-5.992Z" fill="#19156d" />
        </svg>
    </div>
    <div class="swiper-button-prev custom-prev">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="7.4" viewBox="0 0 12 7.4">
            <path id="_Color" data-name=" ↳Color" d="M10.59,0,6,4.574,1.41,0,0,1.408,6,7.4l6-5.992Z" fill="#19156d" />
        </svg>
    </div>
    <!-- !next / prev arrows -->

    <div class="swiper-pagination custom-related-article"></div>
</div>

<script>
    (function($) {
        'use strict';
        $(document).ready(function() {

            
        });
    })(jQuery);
</script>