<?php
require_once ABSPATH . "WPKit/init_autoloader.php";

$loader = new WPKit\Module\Loader();
$loader->load_modules( ['theme', 'catalog'] );
