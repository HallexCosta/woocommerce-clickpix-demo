<?php 

class FormNotificationController extends WP_REST_Controller {
  public EmailService $emailService;
  public string $baseEndpoint;
  
  public function __construct($args) {
    $this->emailService = $args['emailService'];
    $this->baseEndpoint = FormNotificationModel::$postType;
  }

  public function registerRoutes() {
    register_rest_route($this->baseEndpoint, '/send', [
      'methods' => 'POST',
      'callback' => [$this, 'save'],
    ]); // http://localhost:3001/wp-json/form-notification/send
  }

  public function save() {
    $mailResponse = $this->emailService->sendMail(
      'Notificação - Independente',
      $_POST, 
      FormNotificationModel::$recipients
    );

    if (!$mailResponse) {
      return new WP_REST_Response([
        'mail_response' =>  $mailResponse,
        'recipients' => FormNotificationModel::$recipients
      ], 400);
    }

    return new WP_REST_Response([
      'mail_response' =>  $mailResponse,
      'recipients' => FormNotificationModel::$recipients
    ], 200);
  }
}