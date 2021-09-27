<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $client = new Client;
        $response = $client->get('https://api.openbrewerydb.org/breweries');
        $data['breweries'] = json_decode($response->getBody()->getContents(), true);
        return view('admin.breweries')->with($data);
    }
}
