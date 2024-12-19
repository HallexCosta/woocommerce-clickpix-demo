<?php
$messages = [
	'env_title' => 'O arquivo ".env" foi encontrado, mas está incompleto.',
	'env_description' => 'O arquivo ".env" foi encontrado, mas está incompleto.',
];

// Path to the .env file
$env_file_path = __DIR__ . '/.env';
var_dump($_ENV);exit;

// Check if the file exists
if (!file_exists($env_file_path)) {
	$messages['env_title'] = 'O arquivo ".env" não encontrado!';
	$messages['env_description'] = 'Por favor, crie um arquivo ".env" e adicione as variáveis de ambiente do banco de dados listadas abaixo para completar a configuração.';

	require_once ABSPATH . 'wp-required-env.php';
	exit;
}

/**#@+
 * Start Auto generator
 * Authentication unique keys and salts.
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 * @since 1.0.0
 */

// Load the content of the .env file
$env_content = file_get_contents($env_file_path);

// Check if the SALT keys are already present in the .env file
$salt_keys_needed = [
  'AUTH_KEY', 'SECURE_AUTH_KEY', 'LOGGED_IN_KEY', 'NONCE_KEY',
  'AUTH_SALT', 'SECURE_AUTH_SALT', 'LOGGED_IN_SALT', 'NONCE_SALT'
];

$missing_salt_keys = [];
foreach ($salt_keys_needed as $key) {
  if (strpos($env_content, $key) === false) {
    $missing_salt_keys[] = $key;
  }
}

// If some SALT keys are missing, generate new salts
if (!empty($missing_salt_keys)) {
  $new_salts = [];
  foreach ($missing_salt_keys as $key) {
    // Generate a random base64 salt of 64 bytes
    $salt = base64_encode(random_bytes(64));
    $salt = rtrim($salt, '='); // Remove padding '=' characters
    $new_salts[] = $key . '="' . $salt . '"'; // Ensure values are wrapped in quotes
  }

	// Add the new keys to the .env file
	if (!empty($new_salts)) {
		file_put_contents($env_file_path, "\n" . implode("\n", $new_salts), FILE_APPEND);
	}
}
// End auto salt generator

$messages['env_title'] = 'O arquivo ".env" foi encontrado, mas está incompleto!';
$messages['env_description'] = 'O arquivo ".env" foi localizado, mas ainda não contém todas as credenciais necessárias para a conexão com o banco de dados. Por favor, complete as informações ausentes para garantir o funcionamento correto.';

// Open and read the file line by line
$lines = file($env_file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Array to store environment variables
$env_vars = [];

// Read the .env file and populate the $env_vars array
foreach ($lines as $line) {
	// Ignore comments
	if (strpos(trim($line), '#') === 0) {
		continue;
	}

	// Split the line by the first occurrence of '='
	list($key, $value) = explode('=', $line, 2);

	// Remove whitespace around the key and value
	$key = trim($key);
	$value = trim($value);

	// Remove double or single quotes around the value, if present
	$value = trim($value, "\"'");

	// Store the key-value pair in the $env_vars array
	$env_vars[$key] = $value;

	// Set the environment variable in $_ENV and also with putenv()
	$_ENV[$key] = $value;
	putenv("$key=$value");
}

// Required database credentials
$required_envs = [
	'DB_HOST', 
	'DB_NAME', 
	'DB_USER', 
	'DB_PASSWORD',
	'DB_CHARSET',
	'APP_ENV',
	'BASE_URL',
	'WP_DEBUG',
	'WP_DEBUG_LOG',
	'FORCE_SSL',
	'CONCATENATE_SCRIPTS',
	'SCRIPT_DEBUG',
	'FS_METHOD',
];

// Check if all required credentials are set in the .env file
foreach ($required_envs as $required_env) {
	if (empty($env_vars[$required_env])) {
		// If any required credential is missing, require the wp-required-env.php file
		require_once ABSPATH . 'wp-required-env.php';
		exit;
	}
}

// The script will continue if all required credentials are found in the .env file