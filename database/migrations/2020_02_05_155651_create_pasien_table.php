<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasien', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 100);
            $table->string('no_rekam_medis', 100)->unique();
            $table->date('tanggal');
            $table->text('alergi_obat');
            $table->text('riwayat_penyakit');
            $table->text('alamat');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('pekerjaan', 200)->nullable();
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
        Schema::dropIfExists('pasien');
    }
}
