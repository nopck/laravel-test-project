<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    public static function getClients() {
        return DB::table('clients')->join('vehicles', 'clients.id', '=', 'vehicles.client_id')->select('phone_number', 'full_name', 'model', 'ru_vehicle_registration');
    }
    public static function getClientByPhoneNumber($phoneNumber) {
     return DB::table('clients')->select('id', 'full_name', 'phone_number', 'gender', 'address')->where('phone_number', '=', $phoneNumber)->take(1)->get()->first();
    }

    public static function getClientIdByPhoneNumber($phoneNumber) {
        return DB::table('clients')->select('id')->where('phone_number', '=', $phoneNumber)->take(1)->get()[0]->id;
    }

    public static function updateClientByPhoneNumber($phoneNumber, $fullName, $gender, $address) {
        DB::table('clients')->upsert([
            'full_name' => $fullName,
            'phone_number' => $phoneNumber,
            'gender' => $gender,
            'address' => $address,
        ], ['phone_number'], ['full_name', 'gender', 'address']);
    }

    public static function deleteClientById($clientId) {
        DB::table('clients')->where('id', '=', $clientId)->delete();
    }
}
