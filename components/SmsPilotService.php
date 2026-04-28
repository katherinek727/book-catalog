<?php

namespace app\components;

use Yii;

class SmsPilotService
{
    private string $apiKey;
    private string $sender;
    private string $apiUrl = 'https://smspilot.ru/api.php';

    public function __construct(string $apiKey = 'DEMO', string $sender = 'SMSPILOT')
    {
        $this->apiKey = $apiKey;
        $this->sender = $sender;
    }

    /**
     * Send an SMS message to a phone number.
     *
     * @param string $phone  Recipient phone, e.g. +79001234567
     * @param string $message  Text to send
     * @return bool  True on success, false on failure
     */
    public function send(string $phone, string $message): bool
    {
        $params = http_build_query([
            'send'   => $message,
            'to'     => $phone,
            'apikey' => $this->apiKey,
            'from'   => $this->sender,
            'format' => 'json',
        ]);

        $url = $this->apiUrl . '?' . $params;

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $response = curl_exec($ch);
        $error    = curl_error($ch);
        curl_close($ch);

        if ($error) {
            Yii::error("SmsPilot cURL error: $error", __METHOD__);
            return false;
        }

        $data = json_decode($response, true);

        if (!empty($data['error'])) {
            Yii::error("SmsPilot API error: " . json_encode($data['error']), __METHOD__);
            return false;
        }

        Yii::info("SMS sent to $phone", __METHOD__);
        return true;
    }
}
