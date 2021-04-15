<?php

namespace Utils;

use GuzzleHttp\Client;

// HTTP请求工具类
class Http
{

    public static function post($url, $data = [], $headers = [], $contentType = 'application/x-www-form-urlencoded')
    {
        $client = new Client([
            'verify' => false
        ]);
        $headers = array_merge($headers, ['Content-Type' => $contentType]);
        $response = $client->post($url, [
            'headers' => $headers,
            'form_params' => $data
        ]);
        return $response->getBody();
    }

    public static function get($url)
    {
        $client = new Client([
            'verify' => false
        ]);
        $response = $client->get($url);
        return $response->getBody();
    }

}
