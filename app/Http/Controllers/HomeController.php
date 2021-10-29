<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getCountries()
    {
            $url = "https://api.first.org/data/v1/countries?region=South America&pretty=true";

            $result = file_get_contents($url);

            $result = json_decode($result, true);
            
         return response()->json($result);
    }
}
