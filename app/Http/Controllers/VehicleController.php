<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response ;
use App\Models\Client;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function destroy($phoneNumber, $ruVehicleRegistration)
    {
        $clientId = Vehicle::getClientIdByRegistration($ruVehicleRegistration);
        Vehicle::deleteVehicleByRegistration($ruVehicleRegistration);
        
        if(Vehicle::getVehiclesByClientId($clientId)->count() == 0) {
            Client::deleteClientById($clientId);
        }
		
        return response()->noContent(204);
    }
}
