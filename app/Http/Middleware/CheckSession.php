<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // die();
        if ($request->session()->has('ses_email') && $request->session()->has('ses_name')) {
            return $next($request);
            // return redirect()->route('home');
        } else {
            // session()->set('redirect_url', $request->getRequestUri());
            if ($request->ajax()) {
                $response = [
                    'status' => false,
                    'code' => 401,
                    'message' => 'Session expired, please relogin',
                ];
                return response()->json($response, 200);
            } else {
                // $request->session()->put('redirect_url', $request->getRequestUri());
                return redirect()->route('login_page');
            }
            // return $next($request); //$next($request); //route('login');
        }
    }
}
