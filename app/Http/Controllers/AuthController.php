<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;
use Config;

class AuthController extends Controller
{
    public $base_url = "https://testing.sparkdlens.com";
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'password' => 'required',
        ]);
        
        $apiURL = $this->base_url.'/oauth/token';
        $postInput = [
            'grant_type' => 'password',
            'client_id' => '95d8400c-31a0-4e26-af94-cf0d144e3bb4',
            'client_secret' => 'UlZvl3ZPP78yj80KvvuP2GAuMmChAAdOYxAJV8ws',
            'username' => $request->user_id,
            'password' => $request->password
        ];
  
        $headers = [
            'Accept' => 'application/json'
        ];
  
        $response = Http::withHeaders($headers)->post($apiURL, $postInput);
        $response = json_decode($response);
        if(!isset($response->access_token) || !isset($response->refresh_token))
        {
            return redirect('login')->with(['error_message'=> $response->message]);
        }

        Session::put('access_token',$response->access_token);
        Session::put('refresh_token',$response->refresh_token);

        $user_details = $this->user_details();
        $user_details = json_decode($user_details)->data;
        Session::put('user_name',$user_details->name);
        
        return redirect('/');

    }

    public function logout()
    {
        Session::flush();
        return redirect('login');
    }

    public function user_details()
    {
        $apiURL = $this->base_url.'/api/user/me';
        return $response = Http::withToken(Session::get('access_token'))->get($apiURL);
    }
}
