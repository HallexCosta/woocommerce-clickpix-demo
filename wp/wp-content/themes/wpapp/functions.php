<?php
flush_rewrite_rules();

// Version project
require_once get_template_directory() . '/includes/version.php';

// Force postname permalinks
require_once get_template_directory() . '/includes/force-structure-post-permalinks.php';

// Force installation plugins
require_once get_template_directory() . '/includes/force-installation-plugins.php';

// Utils
require_once get_template_directory() . '/includes/utils.php';

// Validations
require_once get_template_directory() . '/includes/validations.php'; 

// Allow API Cors
require_once get_template_directory() . '/includes/allow-host-cors.php'; 

// Theme Supports
require_once get_template_directory() . '/includes/theme-supports.php'; 

// Images Sizes
require_once get_template_directory() . '/includes/image-sizes.php'; 

//
// Services
require_once get_template_directory() . '/services/EmailService.php'; 

//
// Modules
require_once get_template_directory() . '/modules/FormNotification/init.php'; 
require_once get_template_directory() . '/modules/FormContact/init.php'; 
require_once get_template_directory() . '/modules/FormLead/init.php'; 

//
// Adaptsers
require_once get_template_directory() . '/adapters/RWMBMeta/init.php'; 