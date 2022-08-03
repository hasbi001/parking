<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Parkir extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parkings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_tiket',255);
            $table->string('jenis_kendaraan',50);
            $table->string('plat_no',10);
            $table->timestamp('jam_masuk')->useCurrent();
            $table->timestamp('jam_keluar')->nullable();
            $table->integer('duration')->nullable();
            $table->string('tarif_parkir',150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parkings');
    }
}
