<?php
/**
 * Narrative Map Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Narrative_Map_Theme
 */

if ( ! function_exists( 'narrative_map_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function narrative_map_theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Narrative Map Theme, use a find and replace
		 * to change 'narrative-map-theme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'narrative-map-theme', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'narrative-map-theme' ),
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
		add_theme_support( 'custom-background', apply_filters( 'narrative_map_theme_custom_background_args', array(
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
add_action( 'after_setup_theme', 'narrative_map_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function narrative_map_theme_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'narrative_map_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'narrative_map_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function narrative_map_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'narrative-map-theme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'narrative-map-theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'narrative_map_theme_widgets_init' );


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
* Load all custom WP functions
*/

require get_template_directory() . '/custom-functions/init.php';


/**
 * TEMP HOUSING OF ACF FOR TESTING W/O IMPORT HASSLE
 */
//require get_template_directory() . '/inc/acf-functions.php';



if (function_exists('acf_add_options_page')) {
 function add_options_menu () {
    acf_add_options_page(
      array(
        'page_title' => 'Map Settings',
        'menu_title' => 'Map Settings',
        'menu_slug' => 'map-settings',
        'redirect' => true,
        'capability' => 'activate_plugins',
        'icon_url' => 'dashicons-admin-site'
      )
    );
  }

  add_action('admin_menu', 'add_options_menu');
}


//ACF DISPLAY
//Location

function acf_fetch_pastor(){
  global $post;
  $html = '';
  $pastor = get_field('pastor');
    if( $pastor) {
      $html = '<div class="pastor">' . $pastor . '</div>';
     return $html;
    }

}


function acf_fetch_clerk(){
  global $post;
  $html = '';
  $clerk = get_field('clerk');

    if( $clerk) {
      $html =  '<div class="clerk">' . $clerk . '</div>';
     return $html;
    }

}


function acf_fetch_city(){
  global $post;
  $html = '';
  $city = get_field('city');

    if( $city) {
      $html = $city;
     return $html;
    }
}


function acf_fetch_count(){
  global $post;
  $html = '';
  $count = get_field('count');

    if( $count) {
      $html = $count;
     return $html;
    }

}


function acf_fetch_state(){
  global $post;
  $html = '';
  $state = get_field('state');
    if( $state) {
      $html = $state;
     return $html;
    }
}

function acf_generic_field($field, $label){
	global $post;
  	$html = '';
  	$info = get_field($field);
  	 if( $info ) {
     return '<div class="generic-data">' . $label . ': ' . $info . '</div>';
    }
}

function acf_fetch_data_binding(){
  global $post;
  $json = get_field('data_binding');
  if( $json) {
    return json_encode($json);
  } else {
    return '';
  }
}

function acf_fetch_map_json(){
  global $post;
  $json = get_field('map_json');
  if( $json) {
    return $json;
  } else {
    return '{"step":"no json provided"}';
  }
}

function acf_fetch_map_focus_latitude(){
  global $post;
  $json = get_field('focus_latitude');
  if( $json) {
    return $json;
  } else {
    return '';
  }
}

function acf_fetch_map_focus_longitude(){
  global $post;
  $json = get_field('focus_longitude');
  if( $json) {
    return $json;
  } else {
    return '';
  }
}

function acf_fetch_map_focus_zoom(){
  global $post;
  $json = get_field('focus_zoom');
  if( $json) {
    return $json;
  } else {
    return '';
  }
}

function acf_fetch_map_focus_transition(){
  global $post;
  $json = get_field('focus_transition');
  if( $json) {
    return $json;
  } else {
    return '';
  }
}

function acf_fetch_map_title(){
  global $post;
  $json = get_field('map_title');
  if( $json) {
    return $json;
  } else {
    return '';
  }
}

function acf_fetch_map_legend(){
  global $post;
  $json = get_field('map_legend');
  if( $json) {
    return $json;
  } else {
    return '';
  }
}

function acf_fetch_map_points(){
  global $post;
  $rows = get_field('points');
  if ($rows) {
    $points = array();
    foreach($rows as $row) {
      $point = array(
        'latitude' => $row['point_latitude'],
        'longitude' => $row['point_longitude'],
        'title' => $row['point_title'],
        'content' => $row['point_content']
      );
      array_push($points, $point);
    }
    return json_encode($points);
  } else {
    return '';
  }
}

function acf_fetch_map_highlighted_counties(){
  global $post;
  $json = get_field('highlighted_counties');
  if( $json) {
    return $json;
  } else {
    return '';
  }
}














