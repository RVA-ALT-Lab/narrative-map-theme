<?php

/**
 * Registers the `narrative` post type.
 */
function narrative_init() {
	register_post_type( 'narrative', array(
		'labels'                => array(
			'name'                  => __( 'Narratives', 'narrative-map-theme' ),
			'singular_name'         => __( 'Narrative', 'narrative-map-theme' ),
			'all_items'             => __( 'All Narratives', 'narrative-map-theme' ),
			'archives'              => __( 'Narrative Archives', 'narrative-map-theme' ),
			'attributes'            => __( 'Narrative Attributes', 'narrative-map-theme' ),
			'insert_into_item'      => __( 'Insert into Narrative', 'narrative-map-theme' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Narrative', 'narrative-map-theme' ),
			'featured_image'        => _x( 'Featured Image', 'narrative', 'narrative-map-theme' ),
			'set_featured_image'    => _x( 'Set featured image', 'narrative', 'narrative-map-theme' ),
			'remove_featured_image' => _x( 'Remove featured image', 'narrative', 'narrative-map-theme' ),
			'use_featured_image'    => _x( 'Use as featured image', 'narrative', 'narrative-map-theme' ),
			'filter_items_list'     => __( 'Filter Narratives list', 'narrative-map-theme' ),
			'items_list_navigation' => __( 'Narratives list navigation', 'narrative-map-theme' ),
			'items_list'            => __( 'Narratives list', 'narrative-map-theme' ),
			'new_item'              => __( 'New Narrative', 'narrative-map-theme' ),
			'add_new'               => __( 'Add New', 'narrative-map-theme' ),
			'add_new_item'          => __( 'Add New Narrative', 'narrative-map-theme' ),
			'edit_item'             => __( 'Edit Narrative', 'narrative-map-theme' ),
			'view_item'             => __( 'View Narrative', 'narrative-map-theme' ),
			'view_items'            => __( 'View Narratives', 'narrative-map-theme' ),
			'search_items'          => __( 'Search Narratives', 'narrative-map-theme' ),
			'not_found'             => __( 'No Narratives found', 'narrative-map-theme' ),
			'not_found_in_trash'    => __( 'No Narratives found in trash', 'narrative-map-theme' ),
			'parent_item_colon'     => __( 'Parent Narrative:', 'narrative-map-theme' ),
			'menu_name'             => __( 'Narratives', 'narrative-map-theme' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title', 'editor', 'page-attributes' ),
		'has_archive'           => true,
		'rewrite'               => true,
		'query_var'             => true,
		'menu_position'         => null,
		'menu_icon'             => 'dashicons-schedule',
		'show_in_rest'          => true,
		'rest_base'             => 'narrative',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'narrative_init' );

/**
 * Sets the post updated messages for the `narrative` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `narrative` post type.
 */
function narrative_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['narrative'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Narrative updated. <a target="_blank" href="%s">View Narrative</a>', 'narrative-map-theme' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'narrative-map-theme' ),
		3  => __( 'Custom field deleted.', 'narrative-map-theme' ),
		4  => __( 'Narrative updated.', 'narrative-map-theme' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Narrative restored to revision from %s', 'narrative-map-theme' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Narrative published. <a href="%s">View Narrative</a>', 'narrative-map-theme' ), esc_url( $permalink ) ),
		7  => __( 'Narrative saved.', 'narrative-map-theme' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Narrative submitted. <a target="_blank" href="%s">Preview Narrative</a>', 'narrative-map-theme' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Narrative scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Narrative</a>', 'narrative-map-theme' ),
		date_i18n( __( 'M j, Y @ G:i', 'narrative-map-theme' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Narrative draft updated. <a target="_blank" href="%s">Preview Narrative</a>', 'narrative-map-theme' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'narrative_updated_messages' );
