<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Product',
        ];

        return view('pages.product.index', $data);
    }

    public function save(Request $request)
    {
        $data_validator = [
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required',
            'id_product_category' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $data_validator);

        if ($validator->fails()) {
            $response = [
                'code' => 400,
                'message' => $validator->errors()->first(),
            ];
        } else {
            $url = env('API_URL') . 'product';
            $id = $request->input('id');
            $request['price'] = str_replace(',', '', $request->price);
            if (!empty($id)) {
                $url = env('API_URL') . 'product/' . $id;
                try {
                    $res = $this->_put($url, $request->all());
                    $body = $res->getBody();
                    $response = json_decode($body, true);
                } catch (\GuzzleHttp\Exception\RequestException $e) {
                    $response = [
                        'code' => 500,
                        'message' => $e->getMessage(),
                    ];
                }
            } else {
                try {
                    $res = $this->_post($url, $request->all());
                    $body = $res->getBody();
                    $response = json_decode($body, true);
                } catch (\GuzzleHttp\Exception\RequestException $e) {
                    $response = [
                        'code' => 500,
                        'message' => $e->getMessage(),
                    ];
                }
            }
        }
        return response()->json($response, 200);
    }

    public function save_photo(Request $request)
    {
        $data_validator = [
            'id' => 'required|numeric',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $validator = Validator::make($request->all(), $data_validator);

        if ($validator->fails()) {
            $response = [
                'code' => 400,
                'message' => $validator->errors()->first(),
            ];
        } else {
            $url = env('API_URL') . 'product/upload_photo/' . $request->input('id');
            $file = $request->file('photo');
            $data = [
                [
                    'name' => 'photo',
                    'contents' => fopen($file->getRealPath(), 'r+'),
                    'filename' => $file->getClientOriginalName()
                ]
            ];
            try {
                $res = $this->_post_multi_part($url, $data);
                $body = $res->getBody();
                $response = json_decode($body, true);
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                $response = [
                    'code' => 500,
                    'message' => $e->getMessage(),
                ];
            }
        }
        return response()->json($response, 200);
    }

    public function delete(Request $request)
    {
        $data_validator = [
            'id' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $data_validator);

        if ($validator->fails()) {
            $response = [
                'code' => 400,
                'message' => $validator->errors()->first(),
            ];
        } else {
            $url = env('API_URL') . 'product/' . $request->input('id');
            try {
                $res = $this->_delete($url);
                $body = $res->getBody();
                $response = json_decode($body, true);
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                $response = [
                    'code' => 500,
                    'message' => $e->getMessage(),
                ];
            }
        }

        return response()->json($response, 200);
    }

    public function data(Request $request)
    {
        $url = env('API_URL') . 'product';
        $data = array();
        try {
            $res = $this->_get($url);
            $body = $res->getBody();
            $response = json_decode($body, true);
            if ($response == NULL) {
                $final['code'] = 500;
            } else {
                $final['code'] = $response['code'];
                if ($response['code'] == 201) {
                    $data = $response['data'];
                }
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $final['code'] = $e->getCode();
        }
        $final['draw'] = 1;
        $final['recordsTotal'] = sizeof($data);
        $final['recordsFiltered'] = sizeof($data);
        $final['data'] = $data;
        return response()->json($final, 200);
    }
}
