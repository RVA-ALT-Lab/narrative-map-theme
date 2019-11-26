<?php

/**
 * Registers the `feature_collection` taxonomy,
 * for use with 'feature'.
 */
function feature_collection_init() {
	register_taxonomy( 'feature-collection', array( 'feature' ), array(
		'hierarchical'      => false,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'show_admin_column' => false,
		'query_var'         => true,
		'rewrite'           => true,
		'capabilities'      => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts',
		),
		'labels'            => array(
			'name'                       => __( 'Feature Collections', 'narrative-map-theme' ),
			'singular_name'              => _x( 'Feature Collection', 'taxonomy general name', 'narrative-map-theme' ),
			'search_items'               => __( 'Search Feature Collections', 'narrative-map-theme' ),
			'popular_items'              => __( 'Popular Feature Collections', 'narrative-map-theme' ),
			'all_items'                  => __( 'All Feature Collections', 'narrative-map-theme' ),
			'parent_item'                => __( 'Parent Feature Collection', 'narrative-map-theme' ),
			'parent_item_colon'          => __( 'Parent Feature Collection:', 'narrative-map-theme' ),
			'edit_item'                  => __( 'Edit Feature Collection', 'narrative-map-theme' ),
			'update_item'                => __( 'Update Feature Collection', 'narrative-map-theme' ),
			'view_item'                  => __( 'View Feature Collection', 'narrative-map-theme' ),
			'add_new_item'               => __( 'Add New Feature Collection', 'narrative-map-theme' ),
			'new_item_name'              => __( 'New Feature Collection', 'narrative-map-theme' ),
			'separate_items_with_commas' => __( 'Separate Feature Collections with commas', 'narrative-map-theme' ),
			'add_or_remove_items'        => __( 'Add or remove Feature Collections', 'narrative-map-theme' ),
			'choose_from_most_used'      => __( 'Choose from the most used Feature Collections', 'narrative-map-theme' ),
			'not_found'                  => __( 'No Feature Collections found.', 'narrative-map-theme' ),
			'no_terms'                   => __( 'No Feature Collections', 'narrative-map-theme' ),
			'menu_name'                  => __( 'Feature Collections', 'narrative-map-theme' ),
			'items_list_navigation'      => __( 'Feature Collections list navigation', 'narrative-map-theme' ),
			'items_list'                 => __( 'Feature Collections list', 'narrative-map-theme' ),
			'most_used'                  => _x( 'Most Used', 'feature-collection', 'narrative-map-theme' ),
			'back_to_items'              => __( '&larr; Back to Feature Collections', 'narrative-map-theme' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'feature-collection',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'feature_collection_init' );

/**
 * Sets the post updated messages for the `feature_collection` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `feature_collection` taxonomy.
 */
function feature_collection_updated_messages( $messages ) {

	$messages['feature-collection'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Feature Collection added.', 'narrative-map-theme' ),
		2 => __( 'Feature Collection deleted.', 'narrative-map-theme' ),
		3 => __( 'Feature Collection updated.', 'narrative-map-theme' ),
		4 => __( 'Feature Collection not added.', 'narrative-map-theme' ),
		5 => __( 'Feature Collection not updated.', 'narrative-map-theme' ),
		6 => __( 'Feature Collections deleted.', 'narrative-map-theme' ),
	);

	return $messages;
}
add_filter( 'term_updated_messages', 'feature_collection_updated_messages' );
