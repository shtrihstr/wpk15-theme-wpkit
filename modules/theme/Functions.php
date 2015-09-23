<?php
namespace modules\theme;

use WPKit\Module\AbstractThemeFunctions;
use WPKit\Options\Option;

class Functions extends AbstractThemeFunctions
{

    public static function get_site_logo( $size )
    {
        return wp_get_attachment_image( Option::get( 'logo' ), $size );
    }

    public static function get_site_background_color()
    {
        $color = Option::get( 'background' );
        return empty( $color ) ? '#FFFFFF' : $color;
    }


    public static function print_tracking_code()
    {
        echo Option::get( 'analytics' );
    }

}
