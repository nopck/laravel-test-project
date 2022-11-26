<?php

use App\Models\Client;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Client::class);
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->string('brand', 64);
            $table->string('model', 128);
            // Maybe RGB or HSV or enumuration?
            $table->string('color', 64);
            $table->string('ru_vehicle_registration', 8)->unique();
            $table->boolean('in_parking');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};
