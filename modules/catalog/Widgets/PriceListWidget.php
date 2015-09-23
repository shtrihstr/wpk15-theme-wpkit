<?php
namespace modules\catalog\Widgets;

use WPKit\Widgets\AbstractWidget;

class PriceListWidget extends AbstractWidget
{
    protected function _get_config()
    {
        return [
            'id' => 'price-list',
            'name' => __( 'Price List', 'wpk15' ),
        ];
    }

    protected function _build_fields()
    {
        $this->_add_field( 'file', __( 'CSV File', 'wpk15' ), 'File' );
    }

    protected function _render( $args, $data )
    {
        if( empty( $data['file'] ) ) {
            return;
        }
        echo __( 'Download:', 'wpk15' ) . wp_get_attachment_link( $data['file'] );
    }
}