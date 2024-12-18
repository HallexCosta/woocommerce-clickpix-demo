<?php
function getAppVersion() {
  $timestamp_deploy = isset($_ENV['APP_VERSION']) ? $_ENV['APP_VERSION'] : 0;
  $version = in_array($_ENV['APP_ENV'], ['production', 'staging']) ? $timestamp_deploy : date('Y-m-d_H-i-s');
  return $version;
}