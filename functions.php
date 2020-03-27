<?php
/**
 * _ez functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _s
 */

if ( ! function_exists( '_ez_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function _ez_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on _s, use a find and replace
		 * to change '_ez' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( '_ez', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', '_ez' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( '_ez_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', '_ez_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _ez_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( '_ez_content_width', 640 );
}
add_action( 'after_setup_theme', '_ez_content_width', 0 );

/* 
   Debug preview with custom fields 
*/ 

add_filter('_wp_post_revision_fields', 'add_field_debug_preview');
function add_field_debug_preview($fields){
   $fields["debug_preview"] = "debug_preview";
   return $fields;
}

add_action( 'edit_form_after_title', 'add_input_debug_preview' );
function add_input_debug_preview() {
   echo '<input type="hidden" name="debug_preview" value="debug_preview">';
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function _ez_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', '_ez' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', '_ez' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', '_ez_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function _ez_scripts() {
	// wp_enqueue_style( '_s-style', get_stylesheet_uri() );

	// wp_enqueue_script( '_s-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	// wp_enqueue_script( '_s-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	// if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	// 	wp_enqueue_script( 'comment-reply' );
	// }
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/scripts.js', array(), null, true );

	wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery-2.2.4.min.js', array(), null, true);
}
add_action( 'wp_enqueue_scripts', '_ez_scripts' );

/**
 * Enqueue ajax correctly
 */
function add_ajax_script() {
    wp_localize_script( 'ajax-js', 'ajax_params', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'add_ajax_script' );

function mytheme_customize_register( $wp_customize ) {
    //All our sections, settings, and controls will be added here

    $wp_customize->add_section( 'my_site_logo' , array(
        'title'      => __( 'My Site Logo', 'mytheme' ),
        'priority'   => 30,
    ) );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'logo',
            array(
               'label'      => __( 'Upload a logo', 'theme_name' ),
               'section'    => 'my_site_logo',
               'settings'   => 'my_site_logo_id' 
            )
        )
    );

}
add_action( 'customize_register', 'mytheme_customize_register' );

//get_theme_mod( 'my_site_logo_id' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Remove all the BS trash
 */
remove_action('wp_head', 'rsd_link'); // remove really simple discovery link
remove_action('wp_head', 'wp_generator'); // remove wordpress version
remove_action('wp_head', 'feed_links', 2); // remove rss feed links (make sure you add them in yourself if youre using feedblitz or an rss service)
remove_action('wp_head', 'feed_links_extra', 3); // removes all extra rss feed links
remove_action('wp_head', 'index_rel_link'); // remove link to index page
remove_action('wp_head', 'wlwmanifest_link'); // remove wlwmanifest.xml (needed to support windows live writer)
remove_action('wp_head', 'start_post_rel_link', 10, 0); // remove random post link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // remove parent post link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // remove the next and previous post links
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
      
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
      
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0); // Remove shortlink
remove_action('welcome_panel', 'wp_welcome_panel'); // Remove welcome BS

add_filter('xmlrpc_enabled', '__return_false');

add_theme_support( 'title-tag' ); // Utilize Proper WordPress Titles

/**
 * Add ACF to backend
 */
// 1. customize ACF path
add_filter('acf/settings/path', 'my_acf_settings_path');
function my_acf_settings_path($path)
{

	// update path
	$path = get_stylesheet_directory() . '/acf/';

	// return
	return $path;
}
// 2. customize ACF dir
add_filter('acf/settings/dir', 'my_acf_settings_dir');
function my_acf_settings_dir($dir)
{

	// update path
	$dir = get_stylesheet_directory_uri() . '/acf/';

	// return
	return $dir;
}
// 3. Hide ACF field group menu item
add_filter('acf/settings/show_admin', '__return_true');
// 4. Include ACF
include_once(get_stylesheet_directory() . '/acf/acf.php');

/**
 * Changes reset password to more uniform text
 */
add_action( 'resetpass_form', 'resettext');
function resettext(){ ?>

<script type="text/javascript">
   jQuery( document ).ready(function() {                 
     jQuery('#resetpassform input#wp-submit').val("Set Password");
   });
</script>
<?php
}

/**
 * Hides shit from the default login on wp.login
 */
function my_login_page_remove_back_to_link() { ?>
    <style type="text/css">
        body.login div#login p#backtoblog,
        body.login div#login p#nav {
          display: none;
        }
    </style>
<?php }
//This loads the function above on the login page
add_action( 'login_enqueue_scripts', 'my_login_page_remove_back_to_link' );

/**
 * Redirects the user if not admin to a specific page
 */
function admin_login_redirect( $redirect_to, $request, $user ) {
	global $user;
	
	if( isset( $user->roles ) && is_array( $user->roles ) ) {
	   if( in_array( "administrator", $user->roles ) ) {
	   return $redirect_to;
	   } 
	   else {
		return home_url();
	   }
	}
	else {
	return $redirect_to;
	}
 }
add_filter("login_redirect", "admin_login_redirect", 10, 3);

/**
 * Custom pagination
 */
function pagination($pages = '', $range = 4)
{
    $showitems = ($range * 2)+1;
 
    global $paged;
    if(empty($paged)) $paged = 1;
 
    if($pages == '')
    {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if(!$pages)
        {
            $pages = 1;
        }
    }
 
    if(1 != $pages)
    {
        echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
        if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
        if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
 
        for ($i=1; $i <= $pages; $i++)
        {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
            {
                echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
            }
        }
 
        if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";
        if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
        echo "</div>\n";
    }
}

/**
 * Somehow fixes the buggy pagination
 */
function custom_posts_per_page( $query ) {
if ( $query->is_archive('project') ) 
	{
	set_query_var('posts_per_page', -1);
	}
}
add_action( 'pre_get_posts', 'custom_posts_per_page' );

/**
 * Hide the tags that are not needed in pagination
 */
function sanitize_pagination($content) {
	// Remove h2 tag
	$content = str_replace('role="navigation"', '', $content);
    $content = preg_replace('#<h2.*?>(.*?)<\/h2>#si', '', $content);
    return $content;
}
add_action('navigation_markup_template', 'sanitize_pagination');

/**
 *Remove access to normal users from wp admin backend
 */
function wpse23007_redirect(){
	if( is_admin() && !defined('DOING_AJAX') && ( current_user_can('subscriber') || current_user_can('contributor') ) ){
	  wp_redirect(home_url());
	  exit;
	}
}
add_action('init','wpse23007_redirect');

/**
 *Remove admin panel for frontend users
 */
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}
add_action('after_setup_theme', 'remove_admin_bar');

/**
 * Adds custom taxonomy custom post types
 */
function add_cats_to_page()
{
	// Add tag metabox to page
	register_taxonomy_for_object_type('post_tag', 'ADD_NEW_TAXONOMY');
	// Add category metabox to ADD_NEW_TAXONOMY
	register_taxonomy_for_object_type('category', 'ADD_NEW_TAXONOMY');
	register_taxonomy_for_object_type('category', 'page');  
}
add_action('init', 'add_cats_to_page');

/**
 * Remove the standard posts from admin 
 */
function remove_menu () 
{
   remove_menu_page('edit.php');
} 
add_action('admin_menu', 'remove_menu');

// /**
//  * Add subscribers to post authors
//  */
// add_filter( 'wp_dropdown_users_args', 'add_subscribers_to_dropdown', 10, 2 );
// function add_subscribers_to_dropdown( $query_args, $r ) {

//     $query_args['who'] = '';
//     return $query_args;

// }


/**
	 * Create A Simple Theme Options Panel
	 *
	 */
	
	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}
	
	// Start Class
	if ( ! class_exists( 'WPEX_Theme_Options' ) ) {
	
		class WPEX_Theme_Options {
	
			/**
			 * Start things up
			 *
			 * @since 1.0.0
			 */
			public function __construct() {
	
				// We only need to register the admin panel on the back-end
				if ( is_admin() ) {
					add_action( 'admin_menu', array( 'WPEX_Theme_Options', 'add_admin_menu' ) );
					add_action( 'admin_init', array( 'WPEX_Theme_Options', 'register_settings' ) );
				}
	
			}
	
			/**
			 * Returns all theme options
			 *
			 * @since 1.0.0
			 */
			public static function get_theme_options() {
				return get_option( 'theme_options' );
			}
	
			/**
			 * Returns single theme option
			 *
			 * @since 1.0.0
			 */
			public static function get_theme_option( $id ) {
				$options = self::get_theme_options();
				if ( isset( $options[$id] ) ) {
					return $options[$id];
				}
			}
	
			/**
			 * Add sub menu page
			 *
			 * @since 1.0.0
			 */
			public static function add_admin_menu() {
				add_menu_page(
					esc_html__( 'Theme Settings', 'ez' ),
					esc_html__( 'Theme Settings', 'ez' ),
					'manage_options',
					'theme-settings',
					array( 'WPEX_Theme_Options', 'create_admin_page' )
				);
			}
	
			/**
			 * Register a setting and its sanitization callback.
			 *
			 * We are only registering 1 setting so we can store all options in a single option as
			 * an array. You could, however, register a new setting for each option
			 *
			 * @since 1.0.0
			 */
			public static function register_settings() {
				register_setting( 'theme_options', 'theme_options', array( 'WPEX_Theme_Options', 'sanitize' ) );
			}
	
			/**
			 * Sanitization callback
			 *
			 * @since 1.0.0
			 */
			public static function sanitize( $options ) {
	
				// If we have options lets sanitize them
				if ( $options ) {
	
					// Checkbox
					// if ( ! empty( $options['checkbox_example'] ) ) {
					// 	$options['checkbox_example'] = 'on';
					// } else {
					// 	unset( $options['checkbox_example'] ); // Remove from options if not checked
					// }
	
					// // Input
					// if ( ! empty( $options['input_example'] ) ) {
					// 	$options['input_example'] = sanitize_text_field( $options['input_example'] );
					// } else {
					// 	unset( $options['input_example'] ); // Remove from options if empty
					// }

					// Input
					if ( ! empty( $options['place1'] ) ) {
						$options['place1'] = sanitize_text_field( $options['place1'] );
					} else {
						unset( $options['place1'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['place2'] ) ) {
						$options['place2'] = sanitize_text_field( $options['place2'] );
					} else {
						unset( $options['place2'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['place1_phone'] ) ) {
						$options['place1_phone'] = sanitize_text_field( $options['place1_phone'] );
					} else {
						unset( $options['place1_phone'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['place1_address'] ) ) {
						$options['place1_address'] = sanitize_text_field( $options['place1_address'] );
					} else {
						unset( $options['place1_address'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['place1_email'] ) ) {
						$options['place1_email'] = sanitize_text_field( $options['place1_email'] );
					} else {
						unset( $options['place1_email'] ); // Remove from options if empty
					}

					// Input
					if ( ! empty( $options['place2_phone'] ) ) {
						$options['place2_phone'] = sanitize_text_field( $options['place2_phone'] );
					} else {
						unset( $options['place2_phone'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['place2_address'] ) ) {
						$options['place2_address'] = sanitize_text_field( $options['place2_address'] );
					} else {
						unset( $options['place2_address'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['place2_email'] ) ) {
						$options['place2_email'] = sanitize_text_field( $options['place2_email'] );
					} else {
						unset( $options['place2_email'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['pagination'] ) ) {
						$options['pagination'] = sanitize_text_field( $options['pagination'] );
					} else {
						unset( $options['pagination'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['login_error'] ) ) {
						$options['login_error'] = sanitize_text_field( $options['login_error'] );
					} else {
						unset( $options['login_error'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['email_body'] ) ) {
						$options['email_header'] = sanitize_text_field( $options['email_header'] );
					} else {
						unset( $options['email_header'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['email_body'] ) ) {
						$options['email_body'] = sanitize_text_field( $options['email_body'] );
					} else {
						unset( $options['email_body'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['email_link'] ) ) {
						$options['email_link'] = sanitize_text_field( $options['email_link'] );
					} else {
						unset( $options['email_link'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['ga'] ) ) {
						$options['ga'] = sanitize_text_field( $options['ga'] );
					} else {
						unset( $options['ga'] ); // Remove from options if empty
					}
	
					// // Select
					// if ( ! empty( $options['select_example'] ) ) {
					// 	$options['select_example'] = sanitize_text_field( $options['select_example'] );
					// }
	
				}
	
				// Return sanitized options
				return $options;
	
			}
	
			/**
			 * Settings page output
			 *
			 * @since 1.0.0
			 */
			public static function create_admin_page() { ?>

<div class="wrap">

    <h1><?php esc_html_e( 'Theme settings', 'ez' ); ?></h1>

    <form method="post" action="options.php">

        <?php settings_fields( 'theme_options' ); ?>

        <table class="form-table wpex-custom-admin-login-table">

            <!-- <?php // Checkbox example ?>
							<tr valign="top">
								<th scope="row"><?php// esc_html_e( 'Checkbox Example', 'ez' ); ?></th>
								<td>
									<?php// $value = self::get_theme_option( 'checkbox_example' ); ?>
									<input type="checkbox" name="theme_options[checkbox_example]" <?php// checked( $value, 'on' ); ?>> <?php// esc_html_e( 'Checkbox example description.', 'ez' ); ?>
								</td>
							</tr>
	
							<?php// // Text input example ?>
							<tr valign="top">
								<th scope="row"><?php// esc_html_e( 'Input Example', 'ez' ); ?></th>
								<td>
									<?php// $value = self::get_theme_option( 'input_example' ); ?>
									<input type="text" name="theme_options[input_example]" value="<?php// echo esc_attr( $value ); ?>">
								</td>
							</tr> -->

            <?php // book online text ?>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Place of work', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'place1' ); ?>
                    <input type="text" name="theme_options[place1]" value="<?php echo esc_attr( $value ); ?>">
                </td>
            </tr>
            <?php // book online text ?>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Place of work Phone Number', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'place1_phone' ); ?>
                    <input type="text" name="theme_options[place1_phone]" value="<?php echo esc_attr( $value ); ?>">
                </td>
            </tr>

            <?php // book online link ?>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Place of work Address', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'place1_address' ); ?>
                    <textarea type="text" name="theme_options[place1_address]" cols="50"
                        rows="8" /><?php echo esc_attr( $value ); ?></textarea>
                </td>
            </tr>

            <?php // footer copyright ?>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Place of work Email ', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'place1_email' ); ?>
                    <input type="text" name="theme_options[place1_email]" value="<?php echo esc_attr( $value ); ?>">
                </td>
            </tr>

            <?php // telephone number ?>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Place of work', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'place2' ); ?>
                    <input type="text" name="theme_options[place2]" value="<?php echo esc_attr( $value ); ?>">
                </td>
            </tr>
            <?php // telephone number ?>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Place of work Phone Number', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'place2_phone' ); ?>
                    <input type="text" name="theme_options[place2_phone]" value="<?php echo esc_attr( $value ); ?>">
                </td>
            </tr>

            <?php // telephone number ?>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Place of work Address', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'place2_address' ); ?>
                    <textarea type="text" name="theme_options[place2_address]" cols="50"
                        rows="8" /><?php echo esc_attr( $value ); ?></textarea>

                </td>
            </tr>

            <?php // telephone number ?>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Place of work Email', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'place2_email' ); ?>
                    <input type="text" name="theme_options[place2_email]" value="<?php echo esc_attr( $value ); ?>">
                </td>
			</tr>

			<tr valign="top">
				<th scope="row"><h2><?php esc_html_e( 'Pagination settings', 'ez' ); ?></h2></th>
			</tr>
            <?php // telephone number ?>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'How many custom-post to be shown on one page', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'pagination' ); ?>
                    <input type="text" name="theme_options[pagination]" value="<?php echo esc_attr( $value ); ?>">
                </td>
            </tr>

			<tr valign="top">
				<th scope="row"><h2><?php esc_html_e( 'Login settings ', 'ez' ); ?></h2></th>
			</tr>
            <?php // telephone number ?>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'If user name or/and password doesnt match error header (If using custom login pages/forms)', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'login_error' ); ?>
                    <input type="text" name="theme_options[login_error]" value="<?php echo esc_attr( $value ); ?>">
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'If user name or/and password doesnt match error message (If using custom login pages/forms)', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'login_error_text' ); ?>
					<textarea type="text" name="theme_options[login_error_text]" cols="50"
                        rows="8" /><?php echo esc_attr( $value ); ?></textarea>
                </td>
			</tr>

			<tr valign="top">
				<th scope="row"><h2><?php esc_html_e( 'Google analytics', 'ez' ); ?></h2></th>
			</tr>
			<tr valign="top">
                <th scope="row"><?php esc_html_e( 'UA Number (If using analytics)', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'ga' ); ?>
					<input type="text" name="theme_options[ga]" value="<?php echo esc_attr( $value ); ?>">
                </td>
            </tr>

			<tr valign="top">
				<th scope="row"><h2><?php esc_html_e( 'User registration email settings', 'ez' ); ?></h2></th>
			</tr>
			<tr valign="top">
                <th scope="row"><?php esc_html_e( 'Email header (If using custom email plugin)', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'email_header' ); ?>
					<textarea type="text" name="theme_options[email_header]" cols="50"
                        rows="8" /><?php echo esc_attr( $value ); ?></textarea>
                </td>
            </tr>

			<tr valign="top">
                <th scope="row"><?php esc_html_e( 'Email message (If using custom email plugin)', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'email_body' ); ?>
					<textarea type="text" name="theme_options[email_body]" cols="50"
                        rows="8" /><?php echo esc_attr( $value ); ?></textarea>
                </td>
            </tr>

			<tr valign="top">
                <th scope="row"><?php esc_html_e( 'Email link message (If using custom email plugin)', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'email_link' ); ?>
					<input type="text" name="theme_options[email_link]" value="<?php echo esc_attr( $value ); ?>">
                </td>
            </tr>

            <!-- <?php// // Select example ?>
							<tr valign="top" class="wpex-custom-admin-screen-background-section">
								<th scope="row"><?php// esc_html_e( 'Select Example', 'ez' ); ?></th>
								<td>
									<?php// $value = self::get_theme_option( 'select_example' ); ?>
									<select name="theme_options[select_example]">
										<?php//
										//$options = array(
										//	'1' => esc_html__( 'Option 1', 'ez' ),
										//	'2' => esc_html__( 'Option 2', 'ez' ),
										//	'3' => esc_html__( 'Option 3', 'ez' ),
										//);
										//foreach ( $options as $id => $label ) { ?>
											<option value="<?php// echo esc_attr( $id ); ?>" <?php// selected( $value, $id, true ); ?>>
												<?php// echo strip_tags( $label ); ?>
											</option>
										<?php// } ?>
									</select>
								</td>
							</tr> -->

        </table>

        <?php submit_button(); ?>

    </form>

</div><!-- .wrap -->
<?php }
	
		}
	}
	new WPEX_Theme_Options();
	
	// Helper function to use in your theme to return a theme option value
	function myprefix_get_theme_option( $id = '' ) {
		return WPEX_Theme_Options::get_theme_option( $id );
	}

/**
 * Load custom post type 
 */
function custom_post()
{

	// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x('Bets', 'Post Type General Name', 'ez'),
		'singular_name'       => _x('Bets', 'Post Type Singular Name', 'ez'),
		'menu_name'           => __('Bets', 'ez'),
		'parent_item_colon'   => __('Parent Bets', 'ez'),
		'all_items'           => __('All Bets', 'ez'),
		'view_item'           => __('View Bets', 'ez'),
		'add_new_item'        => __('Add New Bets', 'ez'),
		'add_new'             => __('Add New Bets', 'ez'),
		'edit_item'           => __('Edit Bets', 'ez'),
		'update_item'         => __('Update Bets', 'ez'),
		'search_items'        => __('Search Bets', 'ez'),
		'not_found'           => __('Not Found', 'ez'),
		'not_found_in_trash'  => __('Not found in Trash', 'ez'),
	);

	// Set other options for Custom Post Type

	$args = array(
		'label'               => __('Bets', 'ez'),
		'description'         => __('Bets', 'ez'),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array('title', 'author'),
		// You can associate this CPT with a taxonomy or custom taxonomy.
		'taxonomies'          => array('Bets'),
		/* A hierarchical CPT is like Pages and can have
			* Parent and child items. A non-hierarchical CPT
			* is like Posts.
			*/
		'hierarchical'        => false,
		// 'taxonomies'            => array('category'),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 10,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => true, // Change if weird things atrt to happen
		'capability_type'     => 'page',
		'menu_icon'           => 'dashicons-awards',
		'publicly_queryable'  => false, // Set to false hides Single Pages
	);

	// Registering your Custom Post Type
	register_post_type('betting', $args); // change to match that of the real name 
}

/* Hook into the 'init' action so that the function
	* Containing our post type registration is not
	* unnecessarily executed.
	*/

add_action('init', 'custom_post', 0);

/**
 * Add custom taxonomy
 */
//hook into the init action and call create_book_taxonomies when it fires
add_action('init', 'custom_taxonomy', 0);
function custom_taxonomy()
{

	// Add new taxonomy, make it hierarchical like categories
	//first do the translations part for GUI

	$labels = array(
		'name' => _x('Betting categories', 'taxonomy general name'),
		'singular_name' => _x('Betting categories', 'taxonomy singular name'),
		'search_items' =>  __('Search Betting categories'),
		'all_items' => __('All Betting categories'),
		'parent_item' => __('Parent Betting categories'),
		'parent_item_colon' => __('Parent betting categories:'),
		'edit_item' => __('Edit Betting categories'),
		'update_item' => __('Update Betting categories'),
		'add_new_item' => __('Add New Betting categories'),
		'new_item_name' => __('New Betting categories Name'),
		'menu_name' => __(' Betting categories'),
	);

	// Now register the taxonomy

	register_taxonomy('custom-bets', array('betting'), array( // change to match that of the real name 
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'custom-bets'),
		'show_in_rest' => true
	));
}

/**
 * Remove search ability
 */
function fb_filter_query( $query, $error = true ) {
	if ( is_search() ) {
	$query->is_search = false;
	$query->query_vars[s] = false;
	$query->query[s] = false;

	// to error
	if ( $error == true )
	$query->is_404 = true;
	}
}
add_action( 'parse_query', 'fb_filter_query' );
add_filter( 'get_search_form', create_function( '$a', "return null;" ) );

/**
 * Remove Default Image Links in WordPress
 */
function wpb_imagelink_setup() {
    $image_set = get_option( 'image_default_link_type' );
     
    if ($image_set !== 'none') {
        update_option('image_default_link_type', 'none');
    }
}
add_action('admin_init', 'wpb_imagelink_setup', 10);

/**
 * Hide WordPress update nag to all but admins
 */
function hide_update_notice_to_all_but_admin() {
    if ( !current_user_can( 'update_core' ) ) {
        remove_action( 'admin_notices', 'update_nag', 3 );
    }
}
add_action( 'admin_head', 'hide_update_notice_to_all_but_admin', 1 );

/**
 * Modify admin footer text
 */
function modify_footer() {
    echo 'Created by <a href="mailto:info@ez.media">EZ MEDIA</a>.';
}
add_filter( 'admin_footer_text', 'modify_footer' );

/*****************************************************************************
What sport
*****************************************************************************/
function what_sport() { 
		
	//Euro competitions
	$sport = get_field('pick_your_sport');

	if ($sport == 'Football') { ?>
			<img src="<?php echo get_template_directory_uri(); ?>/competition/football.png" width="30px" height="auto" alt="">
        <?php
	} else if ($sport == 'Hockey') { ?>
			<img src="<?php echo get_template_directory_uri(); ?>/competition/hockey.png" width="30px" height="auto" alt="">
        <?php
	} else if ($sport == 'Basketball') { ?>
			<img src="<?php echo get_template_directory_uri(); ?>/competition/basketball.png" width="30px" height="auto" alt="">
        <?php
	} else if ($sport == 'American football') { ?>
			<img src="<?php echo get_template_directory_uri(); ?>/competition/nfl.png" width="30px" height="auto" alt="">
        <?php
	} else if ($sport == 'Baseball') { ?>
			<img src="<?php echo get_template_directory_uri(); ?>/competition/baseball.png" width="30px" height="auto" alt="">
        <?php
	} else if ($sport == 'Esports') { ?>
		<img src="<?php echo get_template_directory_uri(); ?>/competition/esports.png" width="30px" height="auto" alt="">
		<?php
	}
	
}
add_action( 'wpmu_before_content', 'what_sport' );

/*****************************************************************************
A full betslip
*****************************************************************************/
function complete_bet( $teams ) {

	// echo "<div class='level-left'>";
	
		// echo "<div class='level-item'>";
			
			// Loop through team(s) Logos
			if (count($teams) != 2) {
				
					foreach ($teams as $team) { ?>
						<div class="is-not-domestic">
							<img src="<?php echo get_template_directory_uri(); ?>/team-badge/<?php echo $team ?>.png" width="30px" height="auto" alt="">
						</div>
					<?php };
					
					//Loop through the team(s) names
					foreach ($teams as $team) {
						echo "<div class='is-not-domestic truncate'>";
						echo $team;
						echo "</div>";
					};
					// echo "<div>VS</div>";
			} else { ?>
				<div class="reorder has-text-right truncate">
				<?php echo $teams[0];?>
				</div>
				<div class="reorder">
				<img src="<?php echo get_template_directory_uri(); ?>/team-badge/<?php echo $teams[0]; ?>.png" width="30px" height="auto" alt="">
				</div>
				<!-- <div>VS</div> -->
				<div class="reorder">
				<img src="<?php echo get_template_directory_uri(); ?>/team-badge/<?php echo $teams[1]; ?>.png" width="30px" height="auto" alt="">
				</div>
				<div class="reorder has-text-left truncate">
				<?php echo $teams[1];?>
				</div>
				<?php
			};
			
		// echo "</div>";

	// echo "</div>";


	// print_r($team);
	
}
add_action( 'kingtips_content', 'complete_bet' );


/*----------------- start of esports ----------------------------------


/*****************************************************************************
Esports teams
*****************************************************************************/
function eteams() {
	$home = get_field('e_team_1');
	$away = get_field('e_team_2');
?>

	<div class="reorder has-text-right truncate">
	<?php echo $home;?>
	</div>
	<div class="reorder">
	<img src="<?php echo get_template_directory_uri(); ?>/team-badge/default.png" width="30px" height="auto" alt="">
	</div>
	<div class="reorder">
	<img src="<?php echo get_template_directory_uri(); ?>/team-badge/default.png" width="30px" height="auto" alt="">
	</div>
	<div class="reorder has-text-left truncate">
	<?php echo $away;?>
	</div>
	<?php

}
add_action( 'kingtips_content', 'eteams' );

/*****************************************************************************
Esports information
*****************************************************************************/
function esports_info() {

	//Euro competitions
    $game = get_field('esports');
	// $round = get_field('competition_round');
	$time = get_field('game_time'); ?>

	<div class="level-item">
		<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $game ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $game; ?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time; ?>
			</div>
		</div>
	</div><?php

}
add_action( 'kingtips_content', 'esports_info' );


/*----------------- start of football teams ----------------------------------


/*****************************************************************************
European information
*****************************************************************************/
function euro_info() { 
		
	//Euro competitions
    $europe = get_field('european');
	$round = get_field('competition_round');
	$time = get_field('game_time');

	if ($europe !== 'Not a European fixture') { ?>
	<div class="level-item">
		<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $europe ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $europe; ?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time; ?>
			</div>
		</div>
	</div><?php
	}

}
add_action( 'wpmu_before_content', 'euro_info' );

/*****************************************************************************
English League information
*****************************************************************************/
function eng_league_info() { 
		
	//competitions
	$eng_comps = get_field('eng_comp');
	$round = get_field('competition_round');
	$time = get_field('game_time');

	?>
	<div class="level-item">
		<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $eng_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $eng_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time; ?>
			</div>
		</div>
	</div><?php

}
add_action( 'wpmu_before_content', 'eng_league_info' );

/*****************************************************************************
Belguim League information
*****************************************************************************/
function bel_league_info() { 
		
	//competitions
	$bel_comps = get_field('bel_comp');
	$round = get_field('competition_round');
	$time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $bel_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $bel_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time; ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'bel_league_info' );

/*****************************************************************************
Turkish League information
*****************************************************************************/
function turk_league_info() { 
		
	//competitions
	$turk_comps = get_field('turk_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $turk_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $turk_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'turk_league_info' );

/*****************************************************************************
Russian League information
*****************************************************************************/
function rus_league_info() { 
		
	//competitions
	$rus_comps = get_field('rus_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $rus_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $rus_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'rus_league_info' );

/*****************************************************************************
Swiss League information
*****************************************************************************/
function swss_league_info() { 
		
	//competitions
	$swss_comps = get_field('swss_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $swss_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $swss_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'swss_league_info' );

/*****************************************************************************
Argentina League information
*****************************************************************************/
function arg_league_info() { 
		
	//competitions
	$arg_comps = get_field('arg_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $arg_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $arg_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'arg_league_info' );

/*****************************************************************************
Spain League information
*****************************************************************************/
function spa_league_info() { 
		
	//competitions
	$spa_comps = get_field('spa_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $spa_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $spa_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'spa_league_info' );

/*****************************************************************************
Canada League information
*****************************************************************************/
function can_league_info() { 
		
	//competitions
	$can_comps = get_field('can_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $can_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $can_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'can_league_info' );

/*****************************************************************************
Brazil League information
*****************************************************************************/
function bra_league_info() { 
		
	//competitions
	$bra_comps = get_field('bra_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $bra_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $bra_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'bra_league_info' );

/*****************************************************************************
Netherlands League information
*****************************************************************************/
function ned_league_info() { 
		
	//competitions
	$ned_comps = get_field('ned_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $ned_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $ned_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'ned_league_info' );

/*****************************************************************************
German League information
*****************************************************************************/
function ger_league_info() { 
		
	//competitions
	$ger_comps = get_field('ger_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $ger_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $ger_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'ger_league_info' );

/*****************************************************************************
Danish League information
*****************************************************************************/
function dan_league_info() { 
		
	//competitions
	$dan_comps = get_field('dan_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $dan_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $dan_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'dan_league_info' );

/*****************************************************************************
America League information
*****************************************************************************/
function amr_league_info() { 
		
	//competitions
	$amr_comps = get_field('amr_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $amr_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $amr_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'amr_league_info' );

/*****************************************************************************
Mexico League information
*****************************************************************************/
function mex_league_info() { 
		
	//competitions
	$mex_comps = get_field('mex_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $mex_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $mex_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'mex_league_info' );

/*****************************************************************************
Scottish League information
*****************************************************************************/
function scot_league_info() { 
		
	//competitions
	$scot_comps = get_field('scot_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $scot_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $scot_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'scot_league_info' );

/*****************************************************************************
Austrian League information
*****************************************************************************/
function aus_league_info() { 
		
	//competitions
	$aus_comps = get_field('aus_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $aus_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $aus_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'aus_league_info' );

/*****************************************************************************
China League information
*****************************************************************************/
function chi_league_info() { 
		
	//competitions
	$chi_comps = get_field('chi_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $chi_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $chi_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'chi_league_info' );

/*****************************************************************************
Japan League information
*****************************************************************************/
function jap_league_info() { 
		
	//competitions
	$jap_comps = get_field('jap_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $jap_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $jap_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'jap_league_info' );

/*****************************************************************************
Sweden League information
*****************************************************************************/
function swe_league_info() { 
		
	//competitions
	$swe_comps = get_field('swe_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $swe_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $swe_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'swe_league_info' );

/*****************************************************************************
Portugal League information
*****************************************************************************/
function port_league_info() { 
		
	//competitions
	$port_comps = get_field('port_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $port_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $port_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'port_league_info' );

/*****************************************************************************
Greece League information
*****************************************************************************/
function gre_league_info() { 
		
	//competitions
	$gre_comps = get_field('gre_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $gre_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $gre_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'gre_league_info' );

/*****************************************************************************
Italy League information
*****************************************************************************/
function ita_league_info() { 
		
	//competitions
	$ita_comps = get_field('ita_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $ita_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $ita_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'ita_league_info' );

/*****************************************************************************
France League information
*****************************************************************************/
function fra_league_info() { 
		
	//competitions
	$fra_comps = get_field('fra_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $fra_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $fra_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'fra_league_info' );


/*----------------- start of hockey teams ----------------------------------


/*****************************************************************************
NHL information
*****************************************************************************/
function nhl_league_info() { 
		
	//competitions
	$nhl_comps = get_field('nhl_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>

	<div class="level-item">
		<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $nhl_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $nhl_comps; ?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time; ?>
			</div>
		</div>
	</div><?php

}
add_action( 'wpmu_before_content', 'nhl_league_info' );

/*****************************************************************************
KHL information
*****************************************************************************/
function khl_league_info() { 
		
	//competitions
	$khl_comps = get_field('khl_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $khl_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $khl_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php
	
}
add_action( 'wpmu_before_content', 'khl_league_info' );

/*****************************************************************************
Eishockey information
*****************************************************************************/
function Eishockey_league_info() { 
		
	//competitions
	$Eishockey_comps = get_field('Eishockey_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $Eishockey_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $Eishockey_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php
	
}
add_action( 'wpmu_before_content', 'Eishockey_league_info' );

/*****************************************************************************
Eishockey 2 information
*****************************************************************************/
function Eishockey2_league_info() { 
		
	//competitions
	$Eishockey2_comps = get_field('Eishockey2_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $Eishockey2_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $Eishockey2_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php
	
}
add_action( 'wpmu_before_content', 'Eishockey2_league_info' );


/*----------------- start of basketabll teams ----------------------------------


/*****************************************************************************
NBA information
*****************************************************************************/
function nba_league_info() { 
		
	//competitions
	$nba_comps = get_field('nba_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $nba_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $nba_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'nba_league_info' );

/*****************************************************************************
World cup information
*****************************************************************************/
function basketball_wc_league_info() { 

	//competitions
	$basketball_wc_comps = get_field('basketball_wc_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $basketball_wc_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $basketball_wc_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'basketball_wc_league_info' );


/*----------------- start of nfl teams ----------------------------------


/*****************************************************************************
NFL information
*****************************************************************************/
function nfl_league_info() { 
		
	//competitions
	$nfl_comps = get_field('nfl_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $nfl_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $nfl_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'nfl_league_info' );


/*----------------- start of mlb teams ----------------------------------


/*****************************************************************************
MLB information
*****************************************************************************/
function mlb_league_info() { 
		
	//competitions
	$mlb_comps = get_field('mlb_comp');
	 $round = get_field('competition_round');
	 $time = get_field('game_time');

	?>
	
	<img class="spacer" src="<?php echo get_template_directory_uri(); ?>/competition/<?php echo $mlb_comps ?>.png" width="30px" height="auto" alt="">
		<div class="level-item is-block">
			<div class="is-block has-text-weight-bold">
				<?php echo $mlb_comps;?>
			</div>
			<div class="is-block has-text-grey">
				<?php echo $time ?>
			</div>
		</div>
	
	<?php

}
add_action( 'wpmu_before_content', 'mlb_league_info' );


/*----------------- start league information ----------------------------------


/*****************************************************************************
League information
*****************************************************************************/
function extra_league_info() { 

	//what sport
    $sport = get_field('pick_your_sport');

//Basketball comps
    $basketball_league = get_field('basketball');
    $nba = get_field('nba');
    $basketball_wc = get_field('basketball_wc');

//American football
    $nfl = get_field('nfl');

//Baseball
    $mlb = get_field('mlb');

//hockey comps
    $hockey_league = get_field('hockey');
    $nhl = get_field('nhl');
    $khl = get_field('khl');
    $Eishockey = get_field('Eishockey');
    $Eishockey2 = get_field('Eishockey2');

// Football teams
    $country = get_field('football');
    $eng = get_field('eng');
    $aus = get_field('aus');
    $bra = get_field('bra');
    $can = get_field('can');
    $bel = get_field('bel');
    $arg = get_field('arg');
    $chi = get_field('chi');
    $ger = get_field('ger');
    $ned = get_field('ned');
    $gre = get_field('gre');
    $jap = get_field('jap');
    $sco = get_field('scot');
    $rus = get_field('rus');
    $port = get_field('port');
    $swed = get_field('swed');
    $swss = get_field('swss');
    $ita = get_field('ita');
    $turk = get_field('turk');
    $amr = get_field('amr');
    $mex = get_field('mex');
    $dan = get_field('dan');
    $spa = get_field('spa');
	$fra = get_field('fra');
	
	$europe = get_field('european');
	
	echo "<div class='level-item'>";
	what_sport();
	//only load this if footballis selected
	if ($sport == 'Football') {
		//Is this a european match
		if ($europe !== 'Not a European fixture') { 
		// if (euro_info()) {
			euro_info();
		}  else {
			if ($country && in_array('England', $country)) {
				if (count($eng) === 2) {
					eng_league_info();
				};
			};
			if ($country && in_array('Austrian', $country)) {
				if (count($aus) === 2) {
					aus_league_info();
				};
			};
			if ($country && in_array('Brazil', $country)) {
				if (count($bra) === 2) {
					bra_league_info();
				};
			};
			if ($country && in_array('Canada', $country)) {
				if (count($can) === 2) {
					can_league_info();
				};
			};
			if ($country && in_array('Belgium', $country)) {
				if (count($bel) === 2) {
					bel_league_info();
				};
			};
			if ($country && in_array('Argentina', $country)) {
				if (count($arg) === 2) {
					arg_league_info();
				};
			};
			if ($country && in_array('China', $country)) {
				if (count($chi) === 2) {
					chi_league_info();
				};
			};
			if ($country && in_array('Germany', $country)) {
				if (count($ger) === 2) {
					ger_league_info();
				};
			};
			if ($country && in_array('Holland', $country)) {
				if (count($ned) === 2) {
					ned_league_info();
				};
			};
			if ($country && in_array('Greece', $country)) {
				if (count($gre) === 2) {
					gre_league_info();
				};
			};
			if ($country && in_array('Japan', $country)) {
				if (count($jap) === 2) {
					jap_league_info();
				};
			};
			if ($country && in_array('Scotland', $country)) {
				if (count($scot) === 2) {
					scot_league_info();
				};
			};
			if ($country && in_array('Russia', $country)) {
				if (count($rus) === 2) {
					rus_league_info();
				};
			};
			if ($country && in_array('Portugal', $country)) {
				if (count($port) === 2) {
					port_league_info();
				};
			};
			if ($country && in_array('Sweden', $country)) {
				if (count($swed) === 2) {
					swed_league_info();
				};
			};
			if ($country && in_array('Swiss', $country)) {
				if (count($swss) === 2) {
					swss_league_info();
				};
			};
			if ($country && in_array('Italy', $country)) {
				if (count($ita) === 2) {
					ita_league_info();
				};
			};
			if ($country && in_array('Turkish', $country)) {
				if (count($turk) === 2) {
					turk_league_info();
				};
			};
			if ($country && in_array('America', $country)) {
				if (count($amr) === 2) {
					amr_league_info();
				};
			};
			if ($country && in_array('Mexico', $country)) {
				if (count($mex) === 2) {
					mex_league_info();
				};
			};
			if ($country && in_array('Danish', $country)) {
				if (count($dan) === 2) {
					dan_league_info();
				};
			};
			if ($country && in_array('Spain', $country)) {
				if (count($spa) === 2) {
					spa_league_info();
				};
			};
			if ($country && in_array('France', $country)) {
				if (count($fra) === 2) {
					fra_league_info();
				};
			};
		}
	} else if ($sport == 'Hockey') { 
		if ($hockey_league && in_array('NHL', $hockey_league)) {
			if (count($nhl) === 2) {
				nhl_league_info();
			};
		};
		if ($hockey_league && in_array('KHL', $hockey_league)) {
			if (count($khl) === 2) {
				khl_league_info();
			};
		};
		if ($hockey_league && in_array('Deutsche Eishockey Liga', $hockey_league)) {
			if (count($Eishockey) === 2) {
				Eishockey_league_info();
			};
		};
		if ($hockey_league && in_array('Deutsche Eishockey Liga 2nd Division', $hockey_league)) {
			if (count($Eishockey2) === 2) {
				Eishockey2_league_info();
			};
		};
	} else if ($sport == 'Basketball') {
		if ($basketball_league && in_array('NBA', $basketball_league)) {
			if (count($nba) === 2) {
				nba_league_info();
			};
		};
		if ($basketball_league && in_array('World cup', $basketball_league)) {
			if (count($basketball_wc) === 2) {
				basketball_wc_league_info();
			};
		};
	} else if ($sport == 'American football') {
		if ($sport == 'American football') {
			if (count($nfl) === 2) {
				nfl_league_info();
			};
		};
	} else if ($sport == 'Baseball') {
		if ($sport == 'Baseball') {
			if (count($mlb) === 2) {
				mlb_league_info();
			}
		};
	} else if ($sport == 'Esports') {
		esports_info();
	}
	echo "</div>";

}
add_action( 'wpmu_before_content', 'extra_league_info' );

