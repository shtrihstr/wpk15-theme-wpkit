<!DOCTYPE html>
<html <?php language_attributes() ?> class="no-js">
<head>

    <meta charset="<?php bloginfo( 'charset' ) ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no,minimal-ui" />

    <title><?php wp_title('|', true, 'right') ?><?php bloginfo('name') ?></title>

    <?php wp_head() ?>

</head>

<body <?php body_class() ?> style="background-color: <?= Theme::get_site_background_color() ?>">

<header>
    <div class="logo">
        <a href="<?= home_url() ?>"><?= Theme::get_site_logo( 'thumbnail' ) ?></a>
    </div>
</header>