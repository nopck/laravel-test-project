<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function destroy($phoneNumber, $ru_vehicle_registration)
    {
		$vehiclesTable = DB::table('vehicles');

        $client_id = $vehiclesTable->select('client_id')->where('ru_vehicle_registration', '=', $ru_vehicle_registration)->get()[0]->client_id;
        $vehiclesTable->where('ru_vehicle_registration', '=', $ru_vehicle_registration)->delete();
        if($vehiclesTable->where('client_id', '=', $client_id)->count() == 0) {
            DB::table('clients')->where('phone_number', '=', $phoneNumber)->delete();
        }
		
        return 204;
    }
}
