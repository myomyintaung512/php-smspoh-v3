# PHP SMSPoH V3 Library

This is a PHP library to interact with the SMSPoH V3 API.

## Installation

Install using Composer:

```bash
composer require myomyintaung512/smspoh
```

## Usage

```php
require 'vendor/autoload.php';

use myomyintaung512\smspoh\SmsPohApi;

$apiKey = 'your_api_key';
$apiSecret = 'your_api_secret';

$api = new SmsPohApi($apiKey, $apiSecret);

// Send an SMS
$response = $api->sendSms('09xxxxxxxxx', 'Hello World', 'YourSenderID', [
    'clientReference' => 'abcde12345',
    'test' => true,
]);
print_r($response);

// Get balance
$response = $api->getBalance();
print_r($response);

// Get messages
$response = $api->getMessages(['limit' => 10]);
print_r($response);
```

## Testing

Run tests with PHPUnit:

```bash
vendor/bin/phpunit tests
```

## License

This library is licensed under the MIT License.
