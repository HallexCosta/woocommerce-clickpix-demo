<?php
// Init rest api with controller
add_action('rest_api_init', function() {
  $emailService = new EmailService([
    'model' => FormNotificationModel::class
  ]);
  
  $formNotificationController = new FormNotificationController([
    'emailService' => $emailService
  ]); 
  $formNotificationController->registerRoutes();
});