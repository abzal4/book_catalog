<?php 

function view_blocks_game_line ($attributes) {
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $attributes['count'],
        'orderby' => 'date',
        'order' => 'DESC'
    );

    $books_query = new WP_Query($args);

    ob_start();

    echo '<div ' . get_block_wrapper_attributes() . '>';

    if ($books_query->have_posts()) {
        echo '<div class="bookscatalog-line-container"><div class="swiper-wrapper">';
        while ($books_query->have_posts()) {
            $books_query->the_post();
            $product = wc_get_product(get_the_ID());
            echo '<div class="swiper-slide book-item">';
            echo '<a href="' . get_the_permalink() . '">';
            echo $product->get_image('full');
            echo '</a>';
            echo '</div>';
        }
        echo '</div></div>';
    }

    echo '</div>';

    wp_reset_postdata();

    return ob_get_clean();
}
