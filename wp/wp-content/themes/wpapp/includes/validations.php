<?php

function check_length($value = "", $min, $max) {
	$len = strlen($value);
	return $len >= $min && $len <= $max;
}

function check_email($v) {
	return preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $v);
}

function check_name($v, $min, $max) {
	return preg_match('/\S+(?:\s+\S+)+/', $v) && check_length($v, $min, $max);
}
