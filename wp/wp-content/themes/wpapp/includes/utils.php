<?php
function getAsset($file, $vers = '') {
  $base_url = home_url();
  $vers = ($vers != "") ? "?{$vers}" : "";
  return "{$base_url}/wp-content/themes/wpapp/assets/{$file}{$vers}";
}

function getTheme($file, $vers = '') {
  $base_url = home_url();
  $vers = ($vers != "") ? "?{$vers}" : "";
  return "{$base_url}/wp-content/themes/wpapp/{$file}{$vers}";
}

function getBaseUrl($slug = "") {
  $base_url = home_url();
  $a = $slug . (($slug !== '') ? '/' : '');
  return "{$base_url}/{$a}";
}

function formatDateTime($timestamp, $format) {
  $timezone = new DateTimeZone(-3);
  return (new DateTime($timestamp))->setTimezone($timezone)->format("{$format}");
}