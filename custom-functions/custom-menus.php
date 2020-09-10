<?php

function add_import_json_menu(){
  add_menu_page(
    'Import GeoJSON',
    'Import GeoJSON',
    'manage_options',
    'import-geojson',
    'import_geojson',
    'dashicons-globe'
  );
}

add_action('admin_menu', 'add_import_json_menu');

function import_geojson() {
  require_once 'menu-template.php';
}
