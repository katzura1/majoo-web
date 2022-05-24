<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Login',
        ];

        return view('pages.auth.login', $data);
    }

    public function login(Request $request)
    {
        $data_validator = [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];

        $validator = Validator::make($request->all(), $data_validator);

        if ($validator->fails()) {
            $response = [
                'code' => 400,
                'message' => $validator->errors()->first(),
            ];
        } else {
            $url = env('API_URL') . 'login';

            try {
                $res = $this->_post($url, $request->all());
                $body = $res->getBody();
                $response = json_decode($body, true);
                if ($response['code'] == 200) {
                    // Set session
                    $request->session()->put('ses_email', $response['data']['email']);
                    $request->session()->put('ses_name', $response['data']['name']);
                }
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                $response = [
                    'code' => 500,
                    'message' => $e->getMessage(),
                ];
            }
        }
        return response()->json($response, 200);
    }

    public function logout()
    {
        // Remove session
        session()->forget('ses_email');
        session()->forget('ses_name');
        return redirect()->route('login');
    }
}
