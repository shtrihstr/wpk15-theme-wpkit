<?php
namespace modules\catalog;

use WPKit\Module\AbstractModuleInitialization;
use WPKit\PostType\MetaBox;
use WPKit\PostType\MetaBoxRelatedPosts;
use WPKit\PostType\MetaBoxRepeatable;
use WPKit\PostType\PostType;
use WPKit\Table\Table;
use WPKit\Taxonomy\Taxonomy;
use WPKit\Fields\Number;
use WPKit\Fields\Radio;
use WPKit\AdminPage\TablePage;
use modules\catalog\Widgets\PriceListWidget;

class Initialization extends AbstractModuleInitialization
{
    /**
     * @var PostType
     */
    protected $_post_type_product = null;

    /**
     * @var Taxonomy
     */
    protected $_taxonomy_brand = null;

    public function register_post_type()
    {
        $this->_post_type_product = new PostType( 'product', __( 'Product', 'wpk15' ), [ 'menu_name' => __( 'Catalog', 'wpk15' ) ] );
        $this->_post_type_product->set_menu_icon( 'dashicons-products' );
        $this->_post_type_product->set_supports( ['title', 'editor', 'thumbnail'] );
        $this->_post_type_product->add_column_thumbnail();
    }

    public function admin_register_meta_box_attributes()
    {
        $meta_box = new MetaBox( 'attributes', __( 'Attributes', 'wpk15' ) );

        $meta_box->add_field( 'price', __( 'Price', 'wpk15' ), function() {
            $field = new Number();
            $field->set_min( 0.0 );
            return $field;
        } );

        $meta_box->add_field( 'in-stock', __( 'In Stock', 'wpk15' ), 'Checkbox' );

        $meta_box->add_post_type( $this->_post_type_product );
    }

    public function admin_register_meta_box_color_variations()
    {
        $meta_box = new MetaBoxRepeatable( 'color-variations', __( 'Color Variations', 'wpk15' ) );
        $meta_box->add_field( 'photo', __( 'Photo', 'wpk15' ), 'Image' );
        $meta_box->add_field( 'color', __( 'Color', 'wpk15' ), 'Color' );
        $meta_box->add_field( 'title', __( 'Title', 'wpk15' ) );
        $meta_box->add_post_type( $this->_post_type_product );
    }

    public function admin_register_meta_box_related_products()
    {
        $meta_box = new MetaBoxRelatedPosts( 'related', __( 'Related Products', 'wpk15' ) );
        $meta_box->set_related_post_types( [ 'product' ] );
        $meta_box->add_post_type( $this->_post_type_product );
    }

    public function register_taxonomy_brand()
    {
        $this->_taxonomy_brand = new Taxonomy( 'brand', __( 'Brand', 'wpk15' ) );
        $this->_taxonomy_brand->add_post_type( $this->_post_type_product );

        $this->_taxonomy_brand->add_custom_field( 'site', __( 'Web Site', 'wpk15' ), 'Url' );
        $this->_taxonomy_brand->add_custom_field( 'Country', __( 'Country', 'wpk15' ), function() {
            $field = new Radio();
            $field->set_options( [
                'Ukraine',
                'Norway',
                'Denmark'
            ] );
            return $field;
        } );
    }

    public function admin_register_clients_table()
    {
        $table = new Table( 'users', 'ID' );

        $table->setup_column( 'Avatar', __( 'Avatar', 'wpk15' ), function( $item, $key ) {
            return get_avatar( $item[ 'user_email' ] );
        } );
        $table->setup_general_column( 'display_name', __( 'Name', 'wpk15' ), null, $sortable = true, $searchable = true );
        $table->setup_column( 'user_email', __( 'Email', 'wpk15' ), null, $sortable = true, $searchable = true );
        $table->setup_column( 'user_registered', __( 'Registered', 'wpk15' ), null, $sortable = true );

        $table->add_action( 'View', function( $action, $item ) {
            wp_redirect( get_edit_user_link( $item ) );
            exit;
        } );

        $admin_page = new TablePage( 'clients', __( 'Clients', 'wpk15' ), 'edit.php?post_type=product' );
        $admin_page->set_table( $table );
    }

    public function register_widgets()
    {
        PriceListWidget::register();
    }

}