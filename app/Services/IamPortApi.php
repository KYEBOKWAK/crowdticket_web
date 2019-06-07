<?php
/**
 * Created by PhpStorm.
 * User: mhd
 * Date: 2016-05-15
 * Time: 오전 5:18
 */

namespace App\Services;


use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class IamPortApi
{
    const BASE_URL = "https://api.iamport.kr";
    const GET_TOKEN_URL = "/users/getToken";
    const API_KEY = "";
    const SECRET_KEY = "";

    private $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => self::BASE_URL]);
    }

    public function get($url)
    {
        $header = $this->getHttpHeader();
        $res = $this->client->get($url, [
            'headers' => $header
        ]);
        return $this->responseToObject($res);
    }

    public function post($url, array $args = [])
    {
        $header = $this->getHttpHeader();
        $res = $this->client->post($url, [
            'headers' => $header,
            'form_params' => $args
        ]);
        return $this->responseToObject($res);
    }

    public function delete($url, array $args = [])
    {
        $header = $this->getHttpHeader();
        $res = $this->client->delete($url, [
            'headers' => $header,
            'form_params' => $args
        ]);
        return $this->responseToObject($res);
    }

    private function getHttpHeader()
    {
        return [
            'X-ImpTokenHeader' => $this->getAccessToken()
        ];
    }

    private function getAccessToken()
    {
        $res = $this->client->post(self::GET_TOKEN_URL, [
            'form_params' => [
                'imp_key' => env('IAMPORT_API_KEY'),
                'imp_secret' => env('IAMPORT_SECRET_KEY')
            ]
        ]);
        $contents = $this->responseToObject($res);
        return $contents->response->access_token;
    }

    private function responseToObject(ResponseInterface $res)
    {
        return json_decode($res->getBody()->getContents());
    }
}