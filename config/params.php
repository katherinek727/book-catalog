<?php

$params = [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
];

$localParams = __DIR__ . '/params-local.php';
if (is_file($localParams)) {
    $params = array_merge($params, require $localParams);
}

return $params;
