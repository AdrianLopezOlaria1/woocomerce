<?php

require_once("./wp-load.php");

 ?>

<div class="product-list">
    <?php
    // Configuración de la consulta
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
    );

    // Consulta de productos
    $loop = new WP_Query($args);

    if ($loop->have_posts()) :
        while ($loop->have_posts()) : $loop->the_post();
            global $product;
            ?>
            <div class="product-item">
                <h2><?php the_title(); ?></h2>
                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                <span class="price"><?php echo $product->get_price_html(); ?></span>
            </div>
            <?php
        endwhile;
    else :
        echo __('No hay productos disponibles', 'textdomain');
    endif;

    wp_reset_postdata();
    ?>
</div>



