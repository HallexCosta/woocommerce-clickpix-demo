<?php
add_action('rest_api_init', function() {
  $emailService = new EmailService([
    'model' => FormLeadModel::class
  ]);

  $formLeadController = new FormLeadController([
    'emailService' => $emailService
  ]); 
  $formLeadController->registerRoutes();
});