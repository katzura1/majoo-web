<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function _get($url)
    {
        return $this->client->request('GET', $url);
    }

    public function _post($url, $data)
    {
        return $this->client->request('POST', $url, [
            'form_params' => $data,
        ]);
    }

    public function _post_multi_part($url, $data)
    {
        return $this->client->request('POST', $url, [
            'multipart' => $data,
        ]);
    }

    public function _put($url, $data)
    {
        return $this->client->request('PUT', $url, [
            'form_params' => $data,
        ]);
    }

    public function _delete($url)
    {
        return $this->client->request('DELETE', $url);
    }
}
