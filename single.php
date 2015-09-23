<?php get_header() ?>

<?php the_post() ?>
<article class="post">
    <h2><?php the_title() ?></h2>
    <?php the_content() ?>
</article>

<?php get_footer() ?>