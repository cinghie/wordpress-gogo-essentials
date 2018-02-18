<?php

/**
 * Plugin Name: Gogodigital Essentials
 * Plugin URI: https://github.com/cinghie/wordpress-gogo-bootstrap
 * Description: Manage Essentials settings on your Wordpress site
 * Author: Gogodigital S.r.l.s.
 * Version: 2.0.0
 * Author URI: http://www.gogodigital.it
 **/

define( 'GOGO_ESSENTIALS_VERSION', '2.0.0' );
define( 'GOGO_ESSENTIALS_PATH', plugin_dir_path(__FILE__) );
define( 'GOGO_ESSENTIALS_URL', plugin_dir_url(__FILE__) );

if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

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
        add_options_page(
            'Essentials Settings Admin',
            'Essentials',
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
        $this->options = get_option( 'essentials_options' );
        ?>
        <div class="wrap">
            <div style="border-right: 1px solid #ddd; float: left; padding-right: 2%;  width: 50%">
                <h1><?php echo  __( 'Gogodigital Essentials Settings', 'gogodigital-essentials' ) ?></h1>
                <form method="post" action="options.php">
                    <?php
                    settings_fields( 'framework_group' );
                    do_settings_sections( 'template-settings' );
                    submit_button();
                    ?>
                </form>
            </div>
            <div style="float: left; margin-left: 2%; width: 40%">
	            <?php include_once( 'sidebar.php' ); ?>
                <h3 style="border-top: 1px solid #ddd; padding-top: 12px">Widget Settings</h3>
                <p>Remember to add manually the Widget Code on your Wordpress Theme</p>
                <p class="description" id="tagline-description" style="background-color: #fcf8e3; border-color: #faebcc; border-radius: 4px; color: #8a6d3b; padding: 10px">
                    if ( is_active_sidebar( 'footer-copyright' ) ) { dynamic_sidebar( 'footer-copyright' ); }
                </p>
                <p class="description" id="tagline-description" style="background-color: #fcf8e3; border-color: #faebcc; border-radius: 4px; color: #8a6d3b; padding: 10px">
                    <a href="https://github.com/cinghie/wordpress-gogo-essentials/blob/master/docs/footer_top_position.md" target="_blank">Copyright Top Example</a>
                </p>
                <p class="description" id="tagline-description" style="background-color: #fcf8e3; border-color: #faebcc; border-radius: 4px; color: #8a6d3b; padding: 10px">
                    if ( is_active_sidebar( 'social-icons' ) ) { dynamic_sidebar( 'social-icons' ); }
                </p>
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
            'template_settings_id', // ID
            'Framework Settings', // Title
            array( $this, 'print_framework_info' ), // Callback
            'template-settings' // Page
        );

        add_settings_field(
            'bootstrap',
            'Load Bootstrap',
            array( $this, 'bootstrap_callback' ),
            'template-settings',
            'template_settings_id'
        );

        add_settings_field(
            'fontawesome',
            'Load Fontawesome',
            array( $this, 'fontawesome_callback' ),
            'template-settings',
            'template_settings_id'
        );

        add_settings_field(
            'jqueryui',
            'Load jQuery UI',
            array( $this, 'jqueryui_callback' ),
            'template-settings',
            'template_settings_id'
        );

        add_settings_field(
            'jquerymobile',
            'Load jQuery Mobile',
            array( $this, 'jquerymobile_callback' ),
            'template-settings',
            'template_settings_id'
        );

        add_settings_field(
            'googlefonts',
            'Load Google Fonts',
            array( $this, 'googlefonts_callback' ),
            'template-settings',
            'template_settings_id'
        );

        add_settings_section(
            'widget_settings_id', // ID
            'Widget Settings', // Title
            array( $this, 'print_widget_info' ), // Callback
            'template-settings' // Page
        );

        add_settings_field(
            'widgetcopyright',
            'Copyright Widget Position',
            array( $this, 'widgetcopyright_callback' ),
            'template-settings',
            'widget_settings_id'
        );

        add_settings_field(
            'widgetcopyrighttop',
            'Copyright Top Widget Position',
            array( $this, 'widgetcopyrighttop_callback' ),
            'template-settings',
            'widget_settings_id'
        );

        add_settings_field(
            'widgetsocialicons',
            'Social Icons Widget Position',
            array( $this, 'widgetsocialicons_callback' ),
            'template-settings',
            'widget_settings_id'
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

        if( isset( $input['jqueryui'] ) )
            $new_input['jqueryui'] = sanitize_text_field( $input['jqueryui'] );

        if( isset( $input['jquerymobile'] ) )
            $new_input['jquerymobile'] = sanitize_text_field( $input['jquerymobile'] );

        if( isset( $input['googlefonts'] ) )
            $new_input['googlefonts'] = sanitize_text_field( $input['googlefonts'] );

        if( isset( $input['widgetcopyright'] ) )
            $new_input['widgetcopyright'] = sanitize_text_field( $input['widgetcopyright'] );

        if( isset( $input['widgetcopyrighttop'] ) )
            $new_input['widgetcopyrighttop'] = sanitize_text_field( $input['widgetcopyrighttop'] );

        if( isset( $input['widgetsocialicons'] ) )
            $new_input['widgetsocialicons'] = sanitize_text_field( $input['widgetsocialicons'] );

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_framework_info()
    {
        print 'Select which <strong>Framework</strong> do you wanna load on your Wordpress Theme';
    }

    /**
     * Print the Section text
     */
    public function print_widget_info()
    {
        print 'Select which <strong>Widget Position</strong> do you wanna register on your Wordpress Theme Widget';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function bootstrap_callback()
    {
        $select  = '<select id="bootstrap" name="essentials_options[bootstrap]">';

        if($this->options['bootstrap'] == "not-load") {
            $select .= '<option value="not-load" selected="selected">Not Load Bootstrap</option>';
        } else {
            $select .= '<option value="not-load">Not Load Bootstrap</option>';
        }

        if($this->options['bootstrap'] == "load-3.3.7") {
            $select .= '<option value="load-3.3.7" selected="selected">Load Bootstrap 3.3.7</option>';
        } else {
            $select .= '<option value="load-3.3.7">Load Bootstrap 3.3.7</option>';
        }

        if($this->options['bootstrap'] == "load-4.0.0") {
            $select .= '<option value="load-4.0.0" selected="selected">Load Bootstrap 4.0.0</option>';
        } else {
            $select .= '<option value="load-4.0.0">Load Bootstrap 4.0.0</option>';
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
        $select  = '<select id="fontawesome" name="essentials_options[fontawesome]">';

        if($this->options['fontawesome'] == "not-load") {
            $select .= '<option value="not-load" selected="selected">Not Load Fontawesome</option>';
        } else {
            $select .= '<option value="not-load">Not Load Fontawesome</option>';
        }

        if($this->options['fontawesome'] == "load-4.7.0") {
            $select .= '<option value="load-4.7.0"" selected="selected">Load Fontawesome 4.7.0</option>';
        } else {
            $select .= '<option value="load-4.7.0"">Load Fontawesome 4.7.0</option>';
        }

        if($this->options['fontawesome'] == "load-5.0.6") {
            $select .= '<option value="load-5.0.6" selected="selected">Load Fontawesome 5.0.6</option>';
        } else {
            $select .= '<option value="load-5.0.6">Load Bootstrap 5.0.6</option>';
        }

        $select .= '</select>';

        printf(
            $select,
            isset( $this->options['fontawesome'] ) ? esc_attr( $this->options['fontawesome']) : ''
        );
    }

	/**
	 * Get the settings option array and print one of its values
	 */
	public function jqueryui_callback()
	{
		$select  = '<select id="jqueryui" name="essentials_options[jqueryui]">';

		if($this->options['jqueryui'] == "not-load") {
			$select .= '<option value="not-load" selected="selected">Not Load jQuery UI</option>';
		} else {
			$select .= '<option value="not-load">Not Load jQuery UI</option>';
		}

		if($this->options['jqueryui'] == "load-1.12.1") {
			$select .= '<option value="load-1.12.1" selected="selected">Load jQuery UI 1.12.1</option>';
		} else {
			$select .= '<option value="load-1.12.1">Load jQuery UI 1.12.1</option>';
		}

		$select .= '</select>';

		printf(
			$select,
			isset( $this->options['jqueryui'] ) ? esc_attr( $this->options['jqueryui']) : ''
		);
	}

    /**
     * Get the settings option array and print one of its values
     */
    public function jquerymobile_callback()
    {
        $select  = '<select id="jquerymobile" name="essentials_options[jquerymobile]">';

        if($this->options['jquerymobile'] == "not-load") {
            $select .= '<option value="not-load" selected="selected">Not Load jQuery Mobile</option>';
        } else {
            $select .= '<option value="not-load">Not Load jQuery Mobile</option>';
        }

        if($this->options['jquerymobile'] == "load-1.4.5") {
            $select .= '<option value="load-1.4.5" selected="selected">Load jQuery Mobile 1.4.5</option>';
        } else {
            $select .= '<option value="load-1.4.5">Load jQuery Mobile 1.4.5</option>';
        }

        $select .= '</select>';

        printf(
            $select,
            isset( $this->options['jquerymobile'] ) ? esc_attr( $this->options['jquerymobile']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function googlefonts_callback()
    {
        printf(
            '<input type="text" class="widefat" id="googlefonts" name="essentials_options[googlefonts]" value="%s" />
             <p class="description" id="tagline-description">Comma separated Fonts like "Open Sans,Roboto"</p>',
            isset( $this->options['googlefonts'] ) ? esc_attr( $this->options['googlefonts']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function widgetcopyright_callback()
    {
        $select  = '<select id="widgetcopyright" name="essentials_options[widgetcopyright]" aria-describedby="widget-copyright">';

        if($this->options['widgetcopyright'] == "not-active") {
            $select .= '<option value="not-active" selected="selected">Not Active</option>';
        } else {
            $select .= '<option value="not-active">Not Active</option>';
        }

        if($this->options['widgetcopyright'] == "active") {
            $select .= '<option value="active" selected="selected">Active</option>';
        } else {
            $select .= '<option value="active">Active</option>';
        }

        $select .= '</select>';

        printf(
            $select,
            isset( $this->options['widgetcopyright'] ) ? esc_attr( $this->options['widgetcopyright']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function widgetcopyrighttop_callback()
    {
        $select  = '<select id="widgetcopyrighttop" name="essentials_options[widgetcopyrighttop]" aria-describedby="widget-copyright-top">';

        if($this->options['widgetcopyrighttop'] == "not-active") {
            $select .= '<option value="not-active" selected="selected">Not Active</option>';
        } else {
            $select .= '<option value="not-active">Not Active</option>';
        }

        if($this->options['widgetcopyrighttop'] == "active") {
            $select .= '<option value="active" selected="selected">Active</option>';
        } else {
            $select .= '<option value="active">Active</option>';
        }

        $select .= '</select>';

        printf(
            $select,
            isset( $this->options['widgetcopyrighttop'] ) ? esc_attr( $this->options['widgetcopyrighttop']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function widgetsocialicons_callback()
    {
        $select  = '<select id="widgetsocialicons" name="essentials_options[widgetsocialicons]" aria-describedby="widget-social-icons">';

        if($this->options['widgetsocialicons'] == "not-active") {
            $select .= '<option value="not-active" selected="selected">Not Active</option>';
        } else {
            $select .= '<option value="not-active">Not Active</option>';
        }

        if($this->options['widgetsocialicons'] == "active") {
            $select .= '<option value="active" selected="selected">Active</option>';
        } else {
            $select .= '<option value="active">Active</option>';
        }

        $select .= '</select>';

        printf(
            $select,
            isset( $this->options['widgetsocialicons'] ) ? esc_attr( $this->options['widgetsocialicons']) : ''
        );
    }
}

/*
 * Create WP Gogo Essentials Page
 */
if( is_admin() )  {
    $my_settings_page = new EssentialsSettingsPage();
}

/*
 * Implementing Params
 */

$essentials_options = get_option('essentials_options');

$googlefonts = str_replace(array(" ",","), array("+","|"), $essentials_options['googlefonts']);
$googlefonts = "https://fonts.googleapis.com/css?family=".$googlefonts;

// Load Bootstrap
if( isset( $essentials_options['bootstrap'] ) ) {
    if ($essentials_options["bootstrap"] === "load-3.3.7") {
        add_action('wp_enqueue_scripts', 'theme_add_bootstrap_337');
    } elseif($essentials_options["bootstrap"] === "load-4.0.0") {
        add_action('wp_enqueue_scripts', 'theme_add_bootstrap_400');
    }
}

// Load Fontawesome
if( isset( $essentials_options['fontawesome'] ) ) {
    if ($essentials_options["fontawesome"] === "load-4.7.0") {
        add_action('wp_enqueue_scripts', 'theme_add_fontawesome_470');
    } elseif($essentials_options["fontawesome"] === "load-5.0.6") {
        add_action('wp_enqueue_scripts', 'theme_add_fontawesome_506');
    }
}

// Load jQuery UI
if( isset( $essentials_options['jqueryui'] ) ) {
    if ($essentials_options["jqueryui"] === "load-1.12.1") {
        add_action('wp_enqueue_scripts', 'theme_add_jqueryui');
    }
}

// Load jQuery Mobile
if( isset( $essentials_options['jquerymobile'] ) ) {
    if ($essentials_options["jquerymobile"] === "load-1.4.5") {
        add_action('wp_enqueue_scripts', 'theme_add_jquerymobile');
    }
}

// Load Google Fonts
if( isset( $essentials_options['googlefonts'] ) ) {
    if ($essentials_options['googlefonts'] != "" ) {
        add_action('wp_enqueue_scripts', 'theme_add_googlefonts');
    }
}

// Load Copyright Widget Position
if( isset( $essentials_options['widgetcopyright'] ) ) {
    if ($essentials_options["widgetcopyright"] === "active") {
        add_action( 'widgets_init', 'footer_copyright_widgets_init' );
    }
}

// Load Copyright Top Widget Position
if( isset( $essentials_options['widgetcopyrighttop'] ) ) {
    if ($essentials_options["widgetcopyrighttop"] === "active") {
        add_action( 'widgets_init', 'footer_copyright_top1_widgets_init' );
        add_action( 'widgets_init', 'footer_copyright_top2_widgets_init' );
        add_action( 'widgets_init', 'footer_copyright_top3_widgets_init' );
        add_action( 'widgets_init', 'footer_copyright_top4_widgets_init' );
    }
}

// Load Social Icons Widget Position
if( isset( $essentials_options['widgetsocialicons'] ) ) {
    if ($essentials_options["widgetsocialicons"] === "active") {
        add_action( 'widgets_init', 'socialicons_widgets_init' );
    }
}

/**
 * Adding Bootstrap css and js
 */
function theme_add_bootstrap_337()
{
	wp_enqueue_style( 'bootstrap', gogodigital_essentials_get_plugin_url() . '/assets/bootstrap/3.3.7/bootstrap.min.css', array(), '3.3.7', 'all');
	wp_enqueue_script( 'bootstrap', gogodigital_essentials_get_plugin_url(). '/assets/bootstrap/3.3.7/bootstrap.min.js', array(), '3.3.7', true );
}

/**
 * Adding Bootstrap css and js from CDN
 */
function theme_add_bootstrap_400()
{
	wp_enqueue_style( 'bootstrap', gogodigital_essentials_get_plugin_url() . '/assets/bootstrap/4.0.0/bootstrap.min.css', array(), '4.0.0', 'all');
	wp_enqueue_script( 'bootstrap', gogodigital_essentials_get_plugin_url(). '/assets/bootstrap/4.0.0/bootstrap.min.js', array(), '4.0.0', true );
}

/**
 * Adding Fontawesome css and js
 */
function theme_add_fontawesome_470()
{
	wp_enqueue_style( 'fontawesome', gogodigital_essentials_get_plugin_url() . '/assets/fontawesome/4.7.0/font-awesome.min.css', array(), '4.7.0', 'all');
}

/**
 * Adding Fontawesome css and js from CDN
 */
function theme_add_fontawesome_506()
{
	wp_enqueue_style( 'fontawesome', gogodigital_essentials_get_plugin_url() . '/assets/fontawesome/5.0.6/fontawesome.min.css', array(), '5.0.6', 'all');
}

/**
 * Adding jQuery UI css and js
 */
function theme_add_jqueryui()
{
	wp_enqueue_style( 'jqueryui', gogodigital_essentials_get_plugin_url() . '/assets/jqueryui/jquery-ui.min.css', array(), '1.12.1', 'all');
	wp_enqueue_script( 'jqueryui', gogodigital_essentials_get_plugin_url(). '/assets/jqueryui/jquery-ui.min.js', array(), '1.12.1', true );
}

/**
 * Adding Bootstrap css and js
 */
function theme_add_jquerymobile()
{
    wp_enqueue_style( 'jquerymobile', gogodigital_essentials_get_plugin_url() . '/assets/jquerymobile/jquery.mobile-1.4.5.min.css', array(), '1.4.5', 'all');
    wp_enqueue_script( 'jquerymobile', gogodigital_essentials_get_plugin_url(). '/assets/jquerymobile/jquery.mobile-1.4.5.min.js', array(), '1.4.5', true );
}

/**
 * Adding Fontawesome css and js
 */
function theme_add_googlefonts()
{
    global $googlefonts;
    wp_enqueue_style( 'googlefonts', $googlefonts, false);
}

/*
 * Adding Copyright Widget Position
 */
function footer_copyright_widgets_init()
{
    register_sidebar( array(
        'name'          => 'Footer Copyright',
        'id'            => 'footer-copyright',
        'before_widget' => '<div class="widget-copyright">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ) );
}

/*
 * Adding Copyright Top1 Widget Position
 */
function footer_copyright_top1_widgets_init()
{
    register_sidebar( array(
        'name'          => 'Footer Copyright Top1',
        'id'            => 'footer-copyright-top1',
        'before_widget' => '<div class="widget-copyright-top1">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="rounded">',
        'after_title'   => '</h3>',
    ) );
}

/*
 * Adding Copyright Top2 Widget Position
 */
function footer_copyright_top2_widgets_init()
{
    register_sidebar( array(
        'name'          => 'Footer Copyright Top2',
        'id'            => 'footer-copyright-top2',
        'before_widget' => '<div class="widget-copyright-top2">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="rounded">',
        'after_title'   => '</h3>',
    ) );
}

/*
 * Adding Copyright Top3 Widget Position
 */
function footer_copyright_top3_widgets_init()
{
    register_sidebar( array(
        'name'          => 'Footer Copyright Top3',
        'id'            => 'footer-copyright-top3',
        'before_widget' => '<div class="widget-copyright-top3">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="rounded">',
        'after_title'   => '</h3>',
    ) );
}

/*
 * Adding Copyright Top4 Widget Position
 */
function footer_copyright_top4_widgets_init()
{
    register_sidebar( array(
        'name'          => 'Footer Copyright Top4',
        'id'            => 'footer-copyright-top4',
        'before_widget' => '<div class="widget-copyright-top4">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="rounded">',
        'after_title'   => '</h3>',
    ) );
}

/*
 * Adding Social Icons Widget Position
 */
function socialicons_widgets_init()
{
    register_sidebar( array(
        'name'          => 'Social Icons',
        'id'            => 'social-icons',
        'before_widget' => '<div class="widget-social-icons">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ) );
}

/**
 * Get Plugin URL
 * @return string
 */
function gogodigital_essentials_get_plugin_url()
{
    if ( !function_exists('plugins_url') )
        return get_option('siteurl') . '/wp-content/plugins/' . plugin_basename(dirname(__FILE__));
    return plugins_url(plugin_basename(dirname(__FILE__)));
}

/**
 * Settings Button on Plugins Panel
 */
function gogodigital_essentials_plugin_action_links($links, $file) {

	static $this_plugin;
	if ( ! $this_plugin ) $this_plugin = plugin_basename( __FILE__ );

	if ( $file == $this_plugin ){
		$settings_link = '<a href="options-general.php?page=essentials-settings">' . __( 'Settings', 'gogodigital-essentials' ) . '</a>';
		array_unshift( $links, $settings_link );
	}

	return $links;

}
add_filter( 'plugin_action_links', 'gogodigital_essentials_plugin_action_links', 10, 2 );