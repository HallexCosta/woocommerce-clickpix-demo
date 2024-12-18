<?php
$DB_HOST = !empty($_ENV['DB_HOST']) ? '*********' : '';
$DB_NAME = !empty($_ENV['DB_NAME']) ? '****' : '';
$DB_USER = !empty($_ENV['DB_USER']) ? '****' : '';
$DB_PASSWORD = !empty($_ENV['DB_PASSWORD']) ? '****************' : '';

$env_title = $messages['env_title'];
$env_description = $messages['env_description'];

echo <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Missing Environment</title>
    <style>
			body {
				font-family: Arial, sans-serif;
				text-align: center;
				padding: 50px;
				background-color: #f9f9f9;
				margin: 0;
			}
			.container {
				display: inline-block;
				border: 1px solid #dcdcdc;
				padding: 20px;
				background-color: #fff;
				box-shadow: 0 1px 2px rgba(0,0,0,0.1);
				max-width: 600px;
				margin: 0 auto;
				text-align: left;
		}
			h1 {
				font-size: 24px;
				color: #333;
				text-align: center;
				margin: 0;
			}
			h4 {
				font-size: 16px;
				color: #666;
				text-align: center;
				margin: 0;
				font-weight: 400;
			}
			p {
				font-size: 14px;
				color: #333;
				margin: 10px 0;
			}
			a {
				color: #0073aa;
				text-decoration: none;
			}
			a:hover {
				text-decoration: underline;
			}

			.card {
				padding: 10px 20px;
				border-radius: 20px;
				border: 1px solid black;
			}
	</style>
</head>
<body>
    <div class="container">
			<h1>$env_title</h1>
			<div style="padding: 10px;"></div>
			<h4>$env_description</h4>
			<div style="padding: 10px;"></div>

			<h3>.env - development</h3>
			<div class="card">
				<p>DB_HOST=$DB_HOST</p>
				<p>DB_NAME=$DB_NAME</p>
				<p>DB_USER=$DB_USER<p>
				<p>DB_PASSWORD=$DB_PASSWORD</p>
				<p>DB_CHARSET=utf8 #latin or ut8</p>
				<p>APP_ENV=development</p>
				<p>BASE_URL=http://localhost:3001</p>
				<p>WP_DEBUG=false</p>
				<p>WP_DEBUG_LOG=false</p>
				<p>FORCE_SSL=false</p>
				<p>CONCATENATE_SCRIPTS=false</p>
				<p>SCRIPT_DEBUG=true</p>
				<p>FS_METHOD=true</p>
			</div>

			<h3>.env - staging</h3>
			<div class="card">
				<p>DB_HOST=$DB_HOST</p>
				<p>DB_NAME=$DB_NAME</p>
				<p>DB_USER=$DB_USER<p>
				<p>DB_PASSWORD=$DB_PASSWORD</p>
				<p>DB_CHARSET=latin #latin or ut8</p>
				<p>APP_ENV=staging</p>
				<p>BASE_URL=https://staging.meudominio.com.br</p>
				<p>WP_DEBUG=false</p>
				<p>WP_DEBUG_LOG=false</p>
				<p>FORCE_SSL=true</p>
				<p>CONCATENATE_SCRIPTS=true</p>
				<p>SCRIPT_DEBUG=false</p>
				<p>FS_METHOD=true</p>
			</div>

			<h3>.env - production</h3>
			<div class="card">
				<p>DB_HOST=$DB_HOST</p>
				<p>DB_NAME=$DB_NAME</p>
				<p>DB_USER=$DB_USER<p>
				<p>DB_PASSWORD=$DB_PASSWORD</p>
				<p>DB_CHARSET=latin #latin or ut8</p>
				<p>APP_ENV=production</p>
				<p>BASE_URL=https://meudominio.com.br</p>
				<p>WP_DEBUG=false</p>
				<p>WP_DEBUG_LOG=false</p>
				<p>FORCE_SSL=true</p>
				<p>CONCATENATE_SCRIPTS=true</p>
				<p>SCRIPT_DEBUG=false</p>
				<p>FS_METHOD=true</p>
			</div>
    </div>
</body>
</html>
HTML;