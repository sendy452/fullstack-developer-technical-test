<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_id')->constrained();
            $table->string('nama_karyawan');
            $table->string('nip')->unique();
            $table->string('departemen');
            $table->date('tgl_lahir');
            $table->string('thn_lahir');
            $table->string('alamat');
            $table->string('no_telp');
            $table->string('agama');
            $table->integer('status');
            $table->string('ktp');
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
        Schema::dropIfExists('employees');
    }
}
