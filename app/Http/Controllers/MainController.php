<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    const PAGE_SIZE = 5;

    public function index()
    {
        $clients = DB::table('clients')->join('vehicles', 'clients.id', '=', 'vehicles.client_id')->select('phone_number', 'full_name', 'model', 'ru_vehicle_registration')->paginate(self::PAGE_SIZE);
        // TODO: Move to middleware
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        return view('clients', compact('clients'));
    }
}
