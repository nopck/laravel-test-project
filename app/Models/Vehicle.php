<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    public static function getVehiclesByClientId($clientId) {
		return DB::table('vehicles')->select('brand', 'model', 'color', 'ru_vehicle_registration', 'in_parking')->where('client_id', '=', $clientId)->get();
    }
    
    public static function getClientIdByRegistration($ru_vehicle_registration) {
        return DB::table('vehicles')->select('client_id')->where('ru_vehicle_registration', '=', $ru_vehicle_registration)->get()[0]->client_id;
    }

	public static function updateVehiclesByRegistartionForClientId($ru_vehicle_registrations, $clientId, $vehicles) {
		DB::table('vehicles')->where('client_id', '=', $clientId)->whereNotIn('ru_vehicle_registration', $ru_vehicle_registrations)->delete();
        DB::table('vehicles')->upsert($vehicles, ['ru_vehicle_registration'], ['brand', 'model', 'color', 'in_parking']);
	}
    
    public static function deleteVehicleByRegistration($ru_vehicle_registration) {
        DB::table('vehicles')->where('ru_vehicle_registration', '=', $ru_vehicle_registration)->delete();
    }
}
