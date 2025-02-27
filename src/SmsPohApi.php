<?php

namespace myomyintaung512\smspoh;

class SmsPohApi
{
    private $apiUrl = 'https://v3.smspoh.com/api/rest';
    private $apiKey;
    private $apiSecret;

    public function __construct($apiKey, $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    private function getAuthToken()
    {
        $credentials = $this->apiKey . ':' . $this->apiSecret;
        return base64_encode($credentials);
    }

    private function makeRequest($endpoint, $data = [])
    {
        $url = $this->apiUrl . $endpoint;
        $headers = [
            "Authorization: Bearer " . $this->getAuthToken(),
            "Content-Type: application/json",
        ];
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => json_encode($data),
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 400) {
            throw new \Exception("HTTP Error: $httpCode. Response: $response");
        }

        return json_decode($response, true);
    }

    public function sendSms($to, $message, $from, $options = [])
    {
        $endpoint = '/send';
        // Convert + to %2B in phone numbers
        $to = str_replace('+', '%2B', $to);

        $data = array_merge([
            'to' => $to,
            'message' => $message,
            'from' => $from,
        ], $options);

        return $this->makeRequest($endpoint, $data);
    }

    public function getBalance()
    {
        $endpoint = '/balance';
        return $this->makeRequest($endpoint);
    }

    public function getMessages($params = [])
    {
        $endpoint = '/messages';
        return $this->makeRequest($endpoint, $params);
    }
}
