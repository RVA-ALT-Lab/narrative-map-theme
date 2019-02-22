<?php

/**
 * Registers the `location` post type.
 */
function location_init() {
	register_post_type( 'location', array(
		'labels'                => array(
			'name'                  => __( 'Locations', 'narrative-map-theme' ),
			'singular_name'         => __( 'Location', 'narrative-map-theme' ),
			'all_items'             => __( 'All Locations', 'narrative-map-theme' ),
			'archives'              => __( 'Location Archives', 'narrative-map-theme' ),
			'attributes'            => __( 'Location Attributes', 'narrative-map-theme' ),
			'insert_into_item'      => __( 'Insert into Location', 'narrative-map-theme' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Location', 'narrative-map-theme' ),
			'featured_image'        => _x( 'Featured Image', 'location', 'narrative-map-theme' ),
			'set_featured_image'    => _x( 'Set featured image', 'location', 'narrative-map-theme' ),
			'remove_featured_image' => _x( 'Remove featured image', 'location', 'narrative-map-theme' ),
			'use_featured_image'    => _x( 'Use as featured image', 'location', 'narrative-map-theme' ),
			'filter_items_list'     => __( 'Filter Locations list', 'narrative-map-theme' ),
			'items_list_navigation' => __( 'Locations list navigation', 'narrative-map-theme' ),
			'items_list'            => __( 'Locations list', 'narrative-map-theme' ),
			'new_item'              => __( 'New Location', 'narrative-map-theme' ),
			'add_new'               => __( 'Add New', 'narrative-map-theme' ),
			'add_new_item'          => __( 'Add New Location', 'narrative-map-theme' ),
			'edit_item'             => __( 'Edit Location', 'narrative-map-theme' ),
			'view_item'             => __( 'View Location', 'narrative-map-theme' ),
			'view_items'            => __( 'View Locations', 'narrative-map-theme' ),
			'search_items'          => __( 'Search Locations', 'narrative-map-theme' ),
			'not_found'             => __( 'No Locations found', 'narrative-map-theme' ),
			'not_found_in_trash'    => __( 'No Locations found in trash', 'narrative-map-theme' ),
			'parent_item_colon'     => __( 'Parent Location:', 'narrative-map-theme' ),
			'menu_name'             => __( 'Locations', 'narrative-map-theme' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title', 'editor' ),
		'has_archive'           => true,
		'rewrite'               => true,
		'query_var'             => true,
		'menu_position'         => null,
		'menu_icon'             => 'dashicons-location-alt',
		'show_in_rest'          => true,
		'rest_base'             => 'location',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'location_init' );

/**
 * Sets the post updated messages for the `location` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `location` post type.
 */
function location_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['location'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Location updated. <a target="_blank" href="%s">View Location</a>', 'narrative-map-theme' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'narrative-map-theme' ),
		3  => __( 'Custom field deleted.', 'narrative-map-theme' ),
		4  => __( 'Location updated.', 'narrative-map-theme' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Location restored to revision from %s', 'narrative-map-theme' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Location published. <a href="%s">View Location</a>', 'narrative-map-theme' ), esc_url( $permalink ) ),
		7  => __( 'Location saved.', 'narrative-map-theme' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Location submitted. <a target="_blank" href="%s">Preview Location</a>', 'narrative-map-theme' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Location scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Location</a>', 'narrative-map-theme' ),
		date_i18n( __( 'M j, Y @ G:i', 'narrative-map-theme' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Location draft updated. <a target="_blank" href="%s">Preview Location</a>', 'narrative-map-theme' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'location_updated_messages' );
