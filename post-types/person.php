<?php

/**
 * Registers the `person` post type.
 */
function person_init() {
	register_post_type( 'person', array(
		'labels'                => array(
			'name'                  => __( 'People', 'narrative-map-theme' ),
			'singular_name'         => __( 'Person', 'narrative-map-theme' ),
			'all_items'             => __( 'All People', 'narrative-map-theme' ),
			'archives'              => __( 'Person Archives', 'narrative-map-theme' ),
			'attributes'            => __( 'Person Attributes', 'narrative-map-theme' ),
			'insert_into_item'      => __( 'Insert into Person', 'narrative-map-theme' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Person', 'narrative-map-theme' ),
			'featured_image'        => _x( 'Featured Image', 'person', 'narrative-map-theme' ),
			'set_featured_image'    => _x( 'Set featured image', 'person', 'narrative-map-theme' ),
			'remove_featured_image' => _x( 'Remove featured image', 'person', 'narrative-map-theme' ),
			'use_featured_image'    => _x( 'Use as featured image', 'person', 'narrative-map-theme' ),
			'filter_items_list'     => __( 'Filter People list', 'narrative-map-theme' ),
			'items_list_navigation' => __( 'People list navigation', 'narrative-map-theme' ),
			'items_list'            => __( 'People list', 'narrative-map-theme' ),
			'new_item'              => __( 'New Person', 'narrative-map-theme' ),
			'add_new'               => __( 'Add New', 'narrative-map-theme' ),
			'add_new_item'          => __( 'Add New Person', 'narrative-map-theme' ),
			'edit_item'             => __( 'Edit Person', 'narrative-map-theme' ),
			'view_item'             => __( 'View Person', 'narrative-map-theme' ),
			'view_items'            => __( 'View People', 'narrative-map-theme' ),
			'search_items'          => __( 'Search People', 'narrative-map-theme' ),
			'not_found'             => __( 'No People found', 'narrative-map-theme' ),
			'not_found_in_trash'    => __( 'No People found in trash', 'narrative-map-theme' ),
			'parent_item_colon'     => __( 'Parent Person:', 'narrative-map-theme' ),
			'menu_name'             => __( 'People', 'narrative-map-theme' ),
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
		'menu_icon'             => 'dashicons-universal-access',
		'show_in_rest'          => true,
		'rest_base'             => 'person',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'person_init' );

/**
 * Sets the post updated messages for the `person` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `person` post type.
 */
function person_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['person'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Person updated. <a target="_blank" href="%s">View Person</a>', 'narrative-map-theme' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'narrative-map-theme' ),
		3  => __( 'Custom field deleted.', 'narrative-map-theme' ),
		4  => __( 'Person updated.', 'narrative-map-theme' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Person restored to revision from %s', 'narrative-map-theme' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Person published. <a href="%s">View Person</a>', 'narrative-map-theme' ), esc_url( $permalink ) ),
		7  => __( 'Person saved.', 'narrative-map-theme' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Person submitted. <a target="_blank" href="%s">Preview Person</a>', 'narrative-map-theme' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Person scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Person</a>', 'narrative-map-theme' ),
		date_i18n( __( 'M j, Y @ G:i', 'narrative-map-theme' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Person draft updated. <a target="_blank" href="%s">Preview Person</a>', 'narrative-map-theme' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'person_updated_messages' );
