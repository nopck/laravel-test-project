<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function destroy($phoneNumber, $ru_vehicle_registration)
    {
        $clientId = Vehicle::getClientIdByRegistration($ru_vehicle_registration);
        Vehicle::deleteVehicleByRegistration($ru_vehicle_registration);
        
        if(Vehicle::getVehiclesByClientId($clientId)->count() == 0) {
            Client::deleteClientById($clientId);
        }
		
        return 204;
    }
}
