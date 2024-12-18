<?php 

function allow_cors() {
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
  header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
  // $allowedOrigin = [
  //   'localhost:3001', 
  //   'localhost:12345', 
  //   'tokai.test',
  //   'tokaioptical.com.br', 
  //   'tokaioptical.com.br', 
  // ];
  // $origin = $_SERVER['HTTP_HOST'];
  // if (in_array($origin, $allowedOrigin)) {
  //   header("Access-Control-Allow-Origin: $origin");
  //   header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
  //   header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

  //   if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  //     http_response_code(204); 
  //     exit();
  //   }
  // } else {
  //   http_response_code(403);
  //   exit('Acesso negado para esta origem.');
  // }
}

add_action('init', 'allow_cors');