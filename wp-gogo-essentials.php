<?php
/*
 * Plugin Name: WP Gogo Essentials
 * Plugin URI: https://github.com/cinghie/wordpress-gogo-bootstrap
 * Description: Manage Essentials settings on your Wordpress site
 * Author: Gogodigital S.r.l.s.
 * Version: 1.0.0
 * Author URI: http://www.gogodigital.it
 */

class EssentialsSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Essentials Settings Admin',
            'WP Essentials',
            'manage_options',
            'essentials-settings',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'essentials_options' );
        ?>
        <div class="wrap">
            <div style="border-right: 1px solid #ddd; float: left; padding-right: 2%;  width: 50%">
                <h1>WP Gogo Essentials Settings</h1>
                <form method="post" action="options.php">
                    <?php
                    settings_fields( 'framework_group' );
                    do_settings_sections( 'framework-settings' );
                    submit_button();
                    ?>
                </form>
            </div>
            <div style="float: left; margin-left: 2%; width: 40%">
                <h3 style="margin-top: 2em;">Donate $5, $10 or $20</h3>
                <p>If you like this plugin, consider supporting us donating the time to develop it.</p>
                <div>
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="TNGRD94CRZLVU">
                        <input type="image" src="https://www.paypalobjects.com/en_US/IT/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                        <img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
                    </form>
                </div>
                <p>Some other ways to support this plugin</p>
                <ul>
                    <li><a href="http://wordpress.org/support/view/plugin-reviews/wp-gogo-essentials?rate=5#postform" target="_blank">Leave a ????? review on WordPress.org</a></li>
                    <li><a href="https://twitter.com/intent/tweet/?text=I+am+using+Wordpress+%22WP+GoGo+Essentials%22+plugin+to+manage+essentials+setings+on+my+WordPress+site.&amp" target="_blank">Tweet about this plugin</a></li>
                    <li><a href="http://wordpress.org/plugins/wp-gogo-essentials/#compatibility" target="_blank">Vote "works" on the WordPress.org plugin page</a></li>
                </ul>
                <h3>Looking for support?</h3>
                <p>Please use the <a href="#">plugin support forums</a> on WordPress.org.</p>
                <h3>Who are Us?</h3>
                <p><a href="http://www.gogodigital.it" target="_blank" title="Gogodigital Srls">Gogodigital Srls</a> is a young and innovative Web Agency is a young and innovative web agency that deals with Professional Web Sites for Companies and Persons, Responsive Web Sites, CMS Sites and Ecommerce Portals, Applications for Apple devices like iPhone, iPad, iPod, Applications for all Android devices like Samsung Smartphone and Pads, SEO Optimization, Web Marketing, Email Marketing and Social Media Marketing.</p>
                <div style="clear: both"></div>
            </div>
            <div style="clear: both"></div>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'framework_group', // Option group
            'essentials_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'Framework settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'framework-settings' // Page
        );

        add_settings_field(
            'bootstrap',
            'Load Bootstrap',
            array( $this, 'bootstrap_callback' ),
            'framework-settings',
            'setting_section_id'
        );

        add_settings_field(
            'fontawesome',
            'Load Fontawesome',
            array( $this, 'fontawesome_callback' ),
            'framework-settings',
            'setting_section_id'
        );
    }

    /**
     * Sanitize each setting field as needed
     * @param array $input Contains all settings fields as array keys
     * @return array
     */
    public function sanitize( $input )
    {
        $new_input = array();

        if( isset( $input['bootstrap'] ) )
            $new_input['bootstrap'] = sanitize_text_field( $input['bootstrap'] );

        if( isset( $input['fontawesome'] ) )
            $new_input['fontawesome'] = sanitize_text_field( $input['fontawesome'] );

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        //print 'Enter your settings below:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function bootstrap_callback()
    {
        $select  = '<select id="bootstrap" name="essentials_options[bootstrap]" aria-describedby="timezone-description">';

        if($this->options['bootstrap'] == "not-load") {
            $select .= '<option value="not-load" selected="selected">Not Load</option>';
        } else {
            $select .= '<option value="not-load">Not Load</option>';
        }

        if($this->options['bootstrap'] == "load") {
            $select .= '<option value="load" selected="selected">Load</option>';
        } else {
            $select .= '<option value="load">Load</option>';
        }

        $select .= '</select>';

        printf(
            $select,
            isset( $this->options['bootstrap'] ) ? esc_attr( $this->options['bootstrap']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function fontawesome_callback()
    {
        $select  = '<select id="fontawesome" name="essentials_options[fontawesome]" aria-describedby="timezone-description">';

        if($this->options['fontawesome'] == "not-load") {
            $select .= '<option value="not-load" selected="selected">Not Load</option>';
        } else {
            $select .= '<option value="not-load">Not Load</option>';
        }

        if($this->options['fontawesome'] == "load") {
            $select .= '<option value="load" selected="selected">Load</option>';
        } else {
            $select .= '<option value="load">Load</option>';
        }

        $select .= '</select>';

        printf(
            $select,
            isset( $this->options['fontawesome'] ) ? esc_attr( $this->options['fontawesome']) : ''
        );
    }
}

if( is_admin() ) $my_settings_page = new EssentialsSettingsPage();

$essentials_options = get_option('essentials_options');

// Check Bootstrap
if ($essentials_options["bootstrap"] === "load") {
    add_action('wp_enqueue_scripts', 'theme_add_bootstrap');
}

// Check Fontawesome
if ($essentials_options["fontawesome"] === "load") {
    add_action('wp_enqueue_scripts', 'theme_add_fontawesome');
}

/**
 * Adding Bootstrap css and js
 */
function theme_add_fontawesome()
{
    wp_enqueue_style( 'fontawesome', wp_gogo_bootstrap_get_plugin_url() . '/css/font-awesome.min.css', array(), '4.7.0', 'all');
}

/**
 * Adding Bootstrap css and js
 */
function theme_add_bootstrap()
{
    wp_enqueue_style( 'bootstrap', wp_gogo_bootstrap_get_plugin_url() . '/css/bootstrap.min.css', array(), '3.3.7', 'all');
    wp_enqueue_script( 'bootstrap', wp_gogo_bootstrap_get_plugin_url(). '/js/bootstrap.min.js', array(), '3.3.7', true );
}

/**
 * Get Plugin URL
 * @return string
 */
function wp_gogo_bootstrap_get_plugin_url()
{
    if ( !function_exists('plugins_url') )
        return get_option('siteurl') . '/wp-content/plugins/' . plugin_basename(dirname(__FILE__));
    return plugins_url(plugin_basename(dirname(__FILE__)));
}
