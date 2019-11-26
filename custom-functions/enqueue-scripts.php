<?php
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

  wp_register_script('leaflet_pattern_js', get_template_directory_uri() . '/js/leaflet-pattern.js', null, null, true);
  wp_enqueue_script('leaflet_pattern_js');

  wp_enqueue_script( 'narrative-map-theme-custom-js', get_template_directory_uri() . '/js/narrative-map-theme.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'narrative_map_theme_scripts' );