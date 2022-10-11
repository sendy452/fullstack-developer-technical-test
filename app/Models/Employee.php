<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'position_id',
        'nama_karyawan',
        'nip',
        'departemen',
        'tgl_lahir',
        'thn_lahir',
        'alamat',
        'no_telp',
        'agama',
        'status',
        'ktp'
    ];
}
