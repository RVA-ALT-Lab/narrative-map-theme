<?php
/**
 * Load custom post types.
 */
require get_template_directory() . '/post-types/narrative.php';
require get_template_directory() . '/post-types/event.php';
require get_template_directory() . '/post-types/person.php';
require get_template_directory() . '/post-types/location.php';
require get_template_directory() . '/post-types/feature.php';

/**
 * Load custom taxonomies
 */

require get_template_directory() . '/taxonomies/feature-collection.php';