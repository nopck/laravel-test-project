<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
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
        $client = Client::getClientByPhoneNumber($phoneNumber);
        if($client == null) {
            abort(Response::HTTP_NOT_FOUND);
        }
        $vehicles = Vehicle::getVehiclesByClientId($client->id);
        $vehicles->push(new Vehicle);
        // TODO: Move to middleware
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
        return view('client', compact('client', 'vehicles'));      
    }

    public function store(ClientRequest $request)
    {
        $phoneNumber = str_replace('/', '', $request->input('phone_number'));
        Client::updateClientByPhoneNumber(
            $phoneNumber,
            $request->input('full_name'),
            $request->input('gender'),
            $request->input('address'),
        );
        $clientId = Client::getClientIdByPhoneNumber($phoneNumber);
        $vehicles = [];
        $vregs = [];
        foreach($request->ru_vehicle_registration as $index => $reg) {
            if($reg == null) {
                continue;
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
        
        if(count($vregs) == 0) {
            // Delete client without vehicles
            Client::deleteClientById($clientId);
        } else {
            Vehicle::updateVehiclesByRegistartionForClientId($vregs, $clientId, $vehicles);
        }

        return redirect()->route('clients-show', ['phone_number' => $phoneNumber]);
    }
}
