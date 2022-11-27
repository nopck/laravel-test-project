<?php

namespace App\Http\Controllers;
use DB;
use App\Http\Requests\ClientRequest;
use App\Models\Vehicle;
use App\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        $vehicles = [new Vehicle];
        return view('client', compact("vehicles"));
    }

    public function show($phoneNumber)
    {
        $client = DB::table('clients')->select('id', 'full_name', 'phone_number', 'gender', 'address')->where('phone_number', '=', $phoneNumber)->take(1)->get()[0];
        $vehicles = DB::table('vehicles')->select('brand', 'model', 'color', 'ru_vehicle_registration', 'in_parking')->where('client_id', '=', $client->id)->get();
        $vehicles->push(new Vehicle);
        // TODO: Move to middleware
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
        return view('client', compact('client', 'vehicles'));      
    }

    public function store(ClientRequest $request)
    {
        $phoneNumber = $request->input('phone_number');
        $clientsTable = DB::table('clients');
        $clientsTable->upsert([
            'full_name' => $request->input('full_name'),
            'phone_number' => $phoneNumber,
            'gender' => $request->input('gender'),
            'address' => $request->input('address'),
        ], ['phone_number'], ['full_name', 'gender', 'address']);
        $clientId = $clientsTable->select('id')->where('phone_number', '=', $phoneNumber)->take(1)->get()[0]->id;
        $vehicles = [];
        $vregs = [];
        foreach($request->ru_vehicle_registration as $index => $reg) {
            if($reg == null) {
                break;
            }
            $vregs[] = $reg;
            $vehicles[] = [
                'client_id' => $clientId,
                'brand' => $request->brand[$index],
                'model' => $request->model[$index],
                'color' => $request->color[$index],
                'ru_vehicle_registration' => $reg,
                'in_parking' => isset($request->in_parking) ? in_array($reg, $request->in_parking) : false
            ];
        }
        
        $vehiclesTable = DB::table('vehicles');
        if(count($vregs) == 0) {
            // Delete empty client
            $vehiclesTable->where('client_id', '=', $clientId)->delete();
            $clientsTable->where('id', '=', $clientId)->delete();
        } else {
            $vehiclesTable->where('client_id', '=', $clientId)->whereNotIn('ru_vehicle_registration', $vregs)->delete();
            $vehiclesTable->upsert($vehicles, ['ru_vehicle_registration'], ['brand', 'model', 'color', 'in_parking']);
        }
        return redirect()->route('clients-show', ['phone_number' => $phoneNumber]);
    }
}
