<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}


class FeatureController {
  public function __construct() {
    $this->namespace = '/narrative-map-theme/v1';
    $this->resource_endpoint = 'features';
  }

  public function init() {
    add_action('rest_api_init', array($this, 'register_routes'));
  }

  public function register_routes() {
    register_rest_route($this->namespace, '/' . $this->resource_endpoint, array(
      'methods' => 'GET',
      'callback' => array($this, 'get_items')
    ));

    register_rest_route($this->namespace, '/' . $this->resource_endpoint . '/(?P<id>[a-zA-Z0-9._-]+)', array(
      'methods' => 'GET',
      'callback' => array($this, 'get_item'),
      'args' => array(
        'id' => array(
          'required' => true
        )
      )
    ));
    register_rest_route($this->namespace, '/' . $this->resource_endpoint . '/(?P<id>[a-zA-Z0-9._-]+)/coordinates', array(
      'methods' => 'POST',
      'callback' => array($this, 'update_coordinates'),
      'args' => array(
        'id' => array(
          'required' => true
        )
      )
    ));

    register_rest_route($this->namespace, '/' . $this->resource_endpoint, array(
      'methods' => 'POST',
      'permission_callback' => array($this, 'check_can_post'),
      'callback' => array($this, 'create_item')
    ));
  }

  public function get_items (WP_REST_Request $request) {
    try{
      $query = new WP_Query([
        'post_type' => 'feature',
        'posts_per_page' => -1,
        'post_status' => 'publish'
      ]);

      if ($query->have_posts()) {
        $posts = $query->posts;

        return [
          'type' => 'FeatureCollection',
          'features' => FeatureController::assembleFeaturesFromPosts($posts)
        ];
      } else {
        return [];
      }
    } catch (Exception $exc) {
      return $exc;
    }
  }

  public function get_item (WP_REST_Request $request) {
    try{
      $query = new WP_Query([
        'p' => $request['id'],
        'post_type' => 'feature'
      ]);

      if ($query->have_posts()) {
        $posts = $query->posts;
        return FeatureController::assembleFeaturesFromPosts($posts);
      } else {
        return [];
      }
    } catch (Exception $exc) {
      return $exc;
    }
  }

  public function create_item (WP_REST_Request $request) {
    try {
      $post_body = json_decode($request->get_body(), TRUE);
      $post_id = wp_insert_post([
        'post_type' => 'feature',
        'post_title' => $post_body['properties']['Name'],
        'post_status' => 'publish'
      ]);
      $post_body['id'] = $post_id;
      $data = [];
      foreach($post_body['properties']['data'] as $key => $value) {
        $row = array(
          'key' => strval($key),
          'value' => strval($value)
        );
        if (strlen($row['key']) < 2) return;
        array_push($data, array(
          'key' => strval($key),
          'value' => strval($value)
        ));
      }
      update_field('properties', $data, $post_id);
      update_field('geometry_type', $post_body['geometry']['type'], $post_id);


      return $post_id;
    } catch (Exception $exc) {
      return $exc;
    }
  }

  public function update_coordinates (WP_REST_Request $request) {
    try {
      return $request['id'];
    } catch (Exception $exc) {
      return $exc;
    }
  }
  public static function formatProperties($props) {
    $properties = [];
    foreach($props as $prop){
      $properties[$prop['key']] = $prop['value'];
    }
    return $properties;
  }
  public static function assembleFeaturesFromPosts($posts) {
    $features = [];
        foreach($posts as $post ) {
          $feature = [
            'name' => $post->post_title,
            'type' => 'Feature',
            'geometry' => [
              'type' => get_field('geometry_type', $post->ID),
              'coordinates' => get_field('geometry_coordinates', $post->ID)
            ],
            'properties' => FeatureController::formatProperties( get_field('properties', $post->ID))
          ];
          array_push($features, $feature);
        }

   return $features;
  }

  public function check_can_post() {
    return true;
  }


}