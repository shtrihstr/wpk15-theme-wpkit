<?php
namespace modules\theme;

use WPKit\AdminPage\OptionPage;
use WPKit\Module\AbstractThemeInitialization;
use WPKit\Options\OptionBox;
use WPKit\Options\Option;

class Initialization extends AbstractThemeInitialization
{

    public function register_nav_menus()
    {
        // TODO: Implement register_nav_menus() method.
    }

    public function register_dynamic_sidebars()
    {
        register_sidebar( [
            'id'    => 'before-post',
            'name'  => 'Before Posts Widget',
        ] );
    }

    public function register_image_sizes()
    {
        add_image_size( 'facebook', 600, 600, true );
    }

    public function register_stylesheets()
    {
        add_action( 'wp_enqueue_scripts', function() {
            wp_enqueue_style( 'theme-screen', $this->get_theme_assets_url() . '/stylesheets/screen.css', [], '1.0' );
            wp_enqueue_style( 'theme-print', $this->get_theme_assets_url() . '/stylesheets/print.css', [], '1.0', 'print' );
        });
    }

    public function register_javascript()
    {
        add_action( 'wp_enqueue_scripts', function() {
            wp_enqueue_script( 'theme-script', $this->get_theme_assets_url() . '/javascripts/script.js', ['jquery'], '1.0', $in_footer = true );
        });
    }

    public function register_noscript_message()
    {
        add_action( 'wp_footer', function() {
            echo "
            <noscript>
                <div style='position: absolute; bottom: 0; left: 0; right: 0; padding: 10px 20px; background-color: #FFF; text-align: center; color: #000; z-index: 999; border-top: 1px solid #000;'>
                    Javascript is disabled on your browser. Please enable JavaScript or upgrade to a Javascript-capable browser to use this site.
                </div>
            </noscript>
            <script>document.getElementsByTagName('html')[0].className = document.getElementsByTagName('html')[0].className.replace(/\b(no-js)\b/,'');</script>
            ";
        } );
    }

    public function register_meta_tags()
    {
        add_action( 'wp_head', function() {

            if( is_singular() && false == post_password_required() ) {
                if( '' == ( $description = get_the_excerpt() ) ) {
                    $description = wp_trim_words( esc_html( strip_shortcodes( get_the_content() ) ), 20, '...' );
                }
            }
            elseif( is_category() && '' != category_description() ) {
                $description = category_description();
            }
            elseif( is_tag() && '' != term_description() ) {
                $description = term_description();
            }
            else {
                $description = get_bloginfo('description');
            }

            $description = esc_attr( $description );

            echo "<meta name=\"description\" content=\"{$description}\" />\n";
            echo "<meta name=\"og:description\" content=\"{$description}\" />\n";

            if( is_singular() && false == post_password_required() && has_post_thumbnail() ) {
                list( $image, $width, $height ) = wp_get_attachment_image_src( get_post_thumbnail_id() , 'facebook' );
            }
            else {
                $image = apply_filters( '',  $this->get_theme_assets_url() . '/images/logo-fb.png' );
            }

            $image = esc_url( $image );

            echo "<meta name=\"og:image\" content=\"{$image}\" />\n";
            echo "<meta name=\"twitter:image\" content=\"{$image}\" />\n";

        });
    }


    public function admin_register_remove_menu_items()
    {
        add_action( 'admin_menu', function() {
            remove_menu_page( 'edit-comments.php' );
        });
    }

    public function register_login_page_stylesheet()
    {
        add_action( 'login_head', function() {
            echo '<link href="' . $this->get_theme_assets_url() . '/stylesheets/login.css' . '" rel="stylesheet" media="all" />';
        });
    }

    public function admin_register_editor_stylesheet()
    {
        add_editor_style( $this->get_theme_assets_url() . '/stylesheets/editor.css' );
    }

    public function admin_register_settings()
    {
        $option_box_design = new OptionBox( 'design', __( 'Design', 'wpk15' ) );
        $option_box_design->add_field( 'background', __( 'Background Color', 'wpk15' ), 'Color' );

        $option_box_social = new OptionBox( 'social', __( 'Social', 'wpk15' ) );
        $option_box_social->add_field( 'analytics', __( 'Google Analytics', 'wpk15' ), 'Textarea' );

        $page = new OptionPage( 'site-options', __( 'Site Options', 'wpk15' ), 'options-general.php' );
        $page->add_box( $option_box_design );
        $page->add_box( $option_box_social );
    }

}
