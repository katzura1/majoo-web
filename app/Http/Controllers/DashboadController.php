<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboadController extends Controller
{
    public function index()
    {

        $url = env('API_URL') . 'product';
        try {
            $res = $this->_get($url);
            $body = $res->getBody();
            $response = json_decode($body, true);
            if ($response['code'] == 201) {
                $products = $response['data'];
            } else {
                $products = [];
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $products = [];
        }

        $data = [
            'title' => 'Dashboard',
            'products' => $products,
        ];

        return view('pages.dashboard.index', $data);
    }
}
