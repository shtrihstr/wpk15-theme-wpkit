<?php
namespace modules\catalog;

use WPKit\Module\AbstractFunctions;
use WPKit\PostType\MetaBox;
use WPKit\Taxonomy\TaxonomyField;

class Functions extends AbstractFunctions
{
    public static function get_product_price( $product_id = null )
    {
        if( null == $product_id ) {
            $product_id = get_the_ID();
        }

        return (float) MetaBox::get( $product_id, 'attributes', 'price' );
    }

    public static function get_product_variations( $product_id = null )
    {
        if( null == $product_id ) {
            $product_id = get_the_ID();
        }
        $variations_photo = MetaBox::get( $product_id, 'color-variations', 'photo' );
        $variations_color = MetaBox::get( $product_id, 'color-variations', 'color' );
        $variations_title = MetaBox::get( $product_id, 'color-variations', 'title' );

        $variations = [];
        foreach( $variations_photo as $key => $_ ) {
            $variations[] = [
                'photo' => wp_get_attachment_image( $variations_photo[ $key ] ),
                'color' => $variations_color[ $key ],
                'title' => $variations_title[ $key ],
            ];
        }
        return $variations;
    }

    public static function get_brand_site_url( $product_id )
    {
        return TaxonomyField::get( $product_id, 'site' );
    }
}
