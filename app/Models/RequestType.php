<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        // 'additional_fields',
        'required_documents',
        'status'
    ];

    protected $casts = [
        // 'additional_fields' => 'array',
        'status' => 'boolean'
    ];
}
