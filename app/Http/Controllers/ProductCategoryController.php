<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Product Category',
        ];

        return view('pages.product_category.index', $data);
    }

    public function save(Request $request)
    {
        $data_validator = [
            'name' => 'required|max:255',
        ];

        $validator = Validator::make($request->all(), $data_validator);

        if ($validator->fails()) {
            $response = [
                'code' => 400,
                'message' => $validator->errors()->first(),
            ];
        } else {
            $url = env('API_URL') . 'product_category';
            $id = $request->input('id');
            if (!empty($id)) {
                $url = env('API_URL') . 'product_category/' . $id;
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
            $url = env('API_URL') . 'product_category/' . $request->input('id');
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
        $url = env('API_URL') . 'product_category';
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

    public function select2(Request $request)
    {
        $search = $request->input('searchTerm');
        $search = strtolower($search);

        $data = array();
        $url = env('API_URL') . 'product_category';
        try {
            $res = $this->_get($url);
            $body = $res->getBody();
            $response = json_decode($body, true);

            if ($response['code'] == 201) {
                $data = $response['data'];
            }
            $data = collect($data);
            if (!empty($search)) {
                //fillter by search request
                $filtered = $data->filter(function ($value, $key) use ($search) {
                    return strpos(strtolower($value['name']), $search) !== false;
                });
                //get fillter data
                $filtered = $filtered->all();
            } else {
                $filtered = $data;
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $data = array();
        }

        $dd = array();
        $i = 0;
        foreach ($filtered as $key => $value) {
            $dd[] = array(
                'text' => $value['name'],
                'id' => $value['id'],
            );
            $i++;
        }
        return response()->json($dd, 200);
    }
}
