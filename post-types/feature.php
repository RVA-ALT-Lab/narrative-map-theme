<?php

/**
 * Registers the `feature` post type.
 */
function feature_init() {
	register_post_type( 'feature', array(
		'labels'                => array(
			'name'                  => __( 'Features', 'narrative-map-theme' ),
			'singular_name'         => __( 'Feature', 'narrative-map-theme' ),
			'all_items'             => __( 'All Features', 'narrative-map-theme' ),
			'archives'              => __( 'Feature Archives', 'narrative-map-theme' ),
			'attributes'            => __( 'Feature Attributes', 'narrative-map-theme' ),
			'insert_into_item'      => __( 'Insert into Feature', 'narrative-map-theme' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Feature', 'narrative-map-theme' ),
			'featured_image'        => _x( 'Featured Image', 'feature', 'narrative-map-theme' ),
			'set_featured_image'    => _x( 'Set featured image', 'feature', 'narrative-map-theme' ),
			'remove_featured_image' => _x( 'Remove featured image', 'feature', 'narrative-map-theme' ),
			'use_featured_image'    => _x( 'Use as featured image', 'feature', 'narrative-map-theme' ),
			'filter_items_list'     => __( 'Filter Features list', 'narrative-map-theme' ),
			'items_list_navigation' => __( 'Features list navigation', 'narrative-map-theme' ),
			'items_list'            => __( 'Features list', 'narrative-map-theme' ),
			'new_item'              => __( 'New Feature', 'narrative-map-theme' ),
			'add_new'               => __( 'Add New', 'narrative-map-theme' ),
			'add_new_item'          => __( 'Add New Feature', 'narrative-map-theme' ),
			'edit_item'             => __( 'Edit Feature', 'narrative-map-theme' ),
			'view_item'             => __( 'View Feature', 'narrative-map-theme' ),
			'view_items'            => __( 'View Features', 'narrative-map-theme' ),
			'search_items'          => __( 'Search Features', 'narrative-map-theme' ),
			'not_found'             => __( 'No Features found', 'narrative-map-theme' ),
			'not_found_in_trash'    => __( 'No Features found in trash', 'narrative-map-theme' ),
			'parent_item_colon'     => __( 'Parent Feature:', 'narrative-map-theme' ),
			'menu_name'             => __( 'Features', 'narrative-map-theme' ),
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
		'menu_icon'             => 'dashicons-chart-line',
		'show_in_rest'          => true,
		'rest_base'             => 'feature',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'feature_init' );

/**
 * Sets the post updated messages for the `feature` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `feature` post type.
 */
function feature_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['feature'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Feature updated. <a target="_blank" href="%s">View Feature</a>', 'narrative-map-theme' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'narrative-map-theme' ),
		3  => __( 'Custom field deleted.', 'narrative-map-theme' ),
		4  => __( 'Feature updated.', 'narrative-map-theme' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Feature restored to revision from %s', 'narrative-map-theme' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Feature published. <a href="%s">View Feature</a>', 'narrative-map-theme' ), esc_url( $permalink ) ),
		7  => __( 'Feature saved.', 'narrative-map-theme' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Feature submitted. <a target="_blank" href="%s">Preview Feature</a>', 'narrative-map-theme' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Feature scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Feature</a>', 'narrative-map-theme' ),
		date_i18n( __( 'M j, Y @ G:i', 'narrative-map-theme' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Feature draft updated. <a target="_blank" href="%s">Preview Feature</a>', 'narrative-map-theme' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'feature_updated_messages' );
