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
 * Enqueue scripts and styles.
 */
function narrative_map_theme_scripts() {

  wp_register_style('leaflet_css', 'https://unpkg.com/leaflet@1.2.0/dist/leaflet.css');
  wp_enqueue_style('leaflet_css');

  wp_register_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css');
  wp_enqueue_style('bootstrap');

  wp_register_style('font_awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css');
  wp_enqueue_style('font_awesome');

  wp_enqueue_style( 'narrative-map-theme-style', get_stylesheet_uri() );

	wp_enqueue_script( 'narrative-map-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

  wp_enqueue_script( 'narrative-map-theme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

  wp_register_script('jQuery3','https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', null, null, true);
  wp_enqueue_script('jQuery3');

  wp_register_script('leaflet_js', 'https://unpkg.com/leaflet@1.2.0/dist/leaflet.js', null, null, true);
  wp_enqueue_script('leaflet_js');

  wp_enqueue_script( 'narrative-map-theme-custom-js', get_template_directory_uri() . '/js/narrative-map-theme.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'narrative_map_theme_scripts' );

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
 * Load custom post types.
 */
require get_template_directory() . '/post-types/narrative.php';
require get_template_directory() . '/post-types/event.php';
require get_template_directory() . '/post-types/person.php';
require get_template_directory() . '/post-types/location.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


/**
 * TEMP HOUSING OF ACF FOR TESTING W/O IMPORT HASSLE
 */
//require get_template_directory() . '/inc/acf-functions.php';




//IMPORT CSV STUFF 

function import_members_csv(){
         $file = plugin_dir_path(__FILE__) .'black_churches.csv';
			$arrResult  = array();
			$handle     = fopen($file, "r");
			if(empty($handle) === false) {
			    while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
			        $arrResult[] = $data;
			    }
			    fclose($handle);
			}
			make_member_csv($arrResult);
	}	

function make_member_csv($data){
			foreach ($data as $key => $church) {
				$new_church = array(
				  'post_title'    => $church[0],
				  'post_status'   => 'publish',
				  'post_type' => 'location',
				);
			 
			// Insert the post into the database
			$new_church = wp_insert_post( $new_church );
			var_dump($new_church);
			if ($new_church) {
			   // insert post meta
				$values = array( 
					'pastor' => $church[8],					
					'clerk' => $church[9],
					'year' => $church[7],
					'association' => $church[6],
					'city' => $church[1],
					'county' => $church[2],
					'state' => $church[3],
					'number_of_members' => $church[10],
					'post_office' => $church[11],
				);
			   foreach ($values as $key => $value) {
				   	update_post_meta( $new_church, $key, $value);
				   }
				}
			}
			
}

add_shortcode( 'get-churches', 'import_members_csv' );


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













