<?php
add_action('rest_api_init', function() {
  $emailService = new EmailService([
    'model' => FormContactModel::class
  ]);

  $formContactController = new FormContactController([
    'emailService' => $emailService
  ]); 
  $formContactController->registerRoutes();
});