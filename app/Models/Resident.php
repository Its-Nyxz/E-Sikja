<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resident extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kk',
        'nik',
        'name',
        'pob',
        'dob',
        'gender',
        'address',
        'rt',
        'rw',
        'sub_village',
        'village',
        'district',
        'religion',
        'marital_status',
        'occupation',
        'nationality',
        'education',
        'father_name',
        'mother_name'
    ];

    protected $casts = [
        'dob' => 'date',
    ];
}
