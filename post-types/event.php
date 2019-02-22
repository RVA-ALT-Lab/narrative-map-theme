<?php

/**
 * Registers the `event` post type.
 */
function event_init() {
	register_post_type( 'event', array(
		'labels'                => array(
			'name'                  => __( 'Events', 'narrative-map-theme' ),
			'singular_name'         => __( 'Event', 'narrative-map-theme' ),
			'all_items'             => __( 'All Events', 'narrative-map-theme' ),
			'archives'              => __( 'Event Archives', 'narrative-map-theme' ),
			'attributes'            => __( 'Event Attributes', 'narrative-map-theme' ),
			'insert_into_item'      => __( 'Insert into Event', 'narrative-map-theme' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Event', 'narrative-map-theme' ),
			'featured_image'        => _x( 'Featured Image', 'event', 'narrative-map-theme' ),
			'set_featured_image'    => _x( 'Set featured image', 'event', 'narrative-map-theme' ),
			'remove_featured_image' => _x( 'Remove featured image', 'event', 'narrative-map-theme' ),
			'use_featured_image'    => _x( 'Use as featured image', 'event', 'narrative-map-theme' ),
			'filter_items_list'     => __( 'Filter Events list', 'narrative-map-theme' ),
			'items_list_navigation' => __( 'Events list navigation', 'narrative-map-theme' ),
			'items_list'            => __( 'Events list', 'narrative-map-theme' ),
			'new_item'              => __( 'New Event', 'narrative-map-theme' ),
			'add_new'               => __( 'Add New', 'narrative-map-theme' ),
			'add_new_item'          => __( 'Add New Event', 'narrative-map-theme' ),
			'edit_item'             => __( 'Edit Event', 'narrative-map-theme' ),
			'view_item'             => __( 'View Event', 'narrative-map-theme' ),
			'view_items'            => __( 'View Events', 'narrative-map-theme' ),
			'search_items'          => __( 'Search Events', 'narrative-map-theme' ),
			'not_found'             => __( 'No Events found', 'narrative-map-theme' ),
			'not_found_in_trash'    => __( 'No Events found in trash', 'narrative-map-theme' ),
			'parent_item_colon'     => __( 'Parent Event:', 'narrative-map-theme' ),
			'menu_name'             => __( 'Events', 'narrative-map-theme' ),
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
		'menu_icon'             => 'dashicons-calendar-alt',
		'show_in_rest'          => true,
		'rest_base'             => 'event',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'event_init' );

/**
 * Sets the post updated messages for the `event` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `event` post type.
 */
function event_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['event'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Event updated. <a target="_blank" href="%s">View Event</a>', 'narrative-map-theme' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'narrative-map-theme' ),
		3  => __( 'Custom field deleted.', 'narrative-map-theme' ),
		4  => __( 'Event updated.', 'narrative-map-theme' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Event restored to revision from %s', 'narrative-map-theme' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Event published. <a href="%s">View Event</a>', 'narrative-map-theme' ), esc_url( $permalink ) ),
		7  => __( 'Event saved.', 'narrative-map-theme' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Event submitted. <a target="_blank" href="%s">Preview Event</a>', 'narrative-map-theme' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Event scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Event</a>', 'narrative-map-theme' ),
		date_i18n( __( 'M j, Y @ G:i', 'narrative-map-theme' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Event draft updated. <a target="_blank" href="%s">Preview Event</a>', 'narrative-map-theme' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'event_updated_messages' );
