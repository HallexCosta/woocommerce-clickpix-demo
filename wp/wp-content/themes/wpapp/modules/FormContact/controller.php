<?php 
class FormContactController extends WP_REST_Controller {
  public EmailService $emailService;
  public string $baseEndpoint;

  public function __construct($args) {
    $this->emailService = $args['emailService'];
    $this->baseEndpoint = FormContactModel::$postType;
  }

  public function registerRoutes() {
    register_rest_route($this->baseEndpoint, '/register', [
      'methods' => 'POST',
      'callback' => [$this, 'save'],
    ]); // http://localhost:3001/wp-json/form-contact/register
  }

  public function save() {
    $contactResponse = FormContactModel::save($_POST);

    if (!$contactResponse) {
      return new WP_REST_Response([
        'response' => FormContactModel::$out, 
        'mail_response' =>  false
      ], 400);
    } 

    $mailResponse = $this->emailService->sendMail(
      'Site WP APP - Contato',
      $_POST, 
      FormNotificationModel::$recipients
    );

    return new WP_REST_Response([
      'response' => $contactResponse, 
      'mail_response' =>  $mailResponse
    ], $contactResponse['status']);
  }
}