<?php get_header() ?>

<?php the_post() ?>
<article class="post">
    <h2><?php the_title() ?></h2>
    <?php the_post_thumbnail() ?>
    <p><?php _e( 'Price', 'wpk15' ) ?>: <?= money_format( '%i', Catalog::get_product_price() ) ?></p>
    <?php the_content() ?>
    <h4><?php _e( 'Variations', 'wpk15' ) ?></h4>
    <dl>
        <?php foreach( Catalog::get_product_variations() as $variation ): ?>
            <dt style="color: <?= $variation['color'] ?>"><?= esc_html( $variation['title'] ) ?></dt>
            <dd><?= $variation['photo'] ?></dd>
        <?php endforeach ?>
    </dl>
</article>

<?php get_footer() ?>