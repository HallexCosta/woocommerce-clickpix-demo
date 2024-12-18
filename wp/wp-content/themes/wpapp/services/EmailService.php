<?php 

class EmailService {
  public static $model;

  public function __construct($args) {
    self::$model = $args['model'];
  }
  public function sendMail($subject, $data, $recipients) {
    $body = self::$model::templateEmail($subject, $data);
    $headers = ['Content-Type: text/html; charset=UTF-8'];
    
    $response = wp_mail(
      $recipients,
      $subject,
      $body,
      $headers
    );

    return $response;
  }
}