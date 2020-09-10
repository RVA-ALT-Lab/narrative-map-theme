<?php

require get_template_directory() . '/custom-functions/enqueue-scripts.php';
require get_template_directory() . '/custom-functions/custom-post-types.php';
require get_template_directory() . '/custom-functions/custom-menus.php';

require get_template_directory() . '/api/FeatureController.php';

$feature_controller = new FeatureController();
$feature_controller->init();