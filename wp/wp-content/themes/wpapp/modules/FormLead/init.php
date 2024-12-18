<?php
require_once __DIR__ . '/model.php'; 
require_once __DIR__ . '/controller.php'; 
require_once __DIR__ . '/routes.php'; 

$formLeadModel = new FormLeadModel();
$formLeadModel->run();