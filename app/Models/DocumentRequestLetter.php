<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentRequestLetter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'request_letter_id',
        'name',
        'url',
        'type',
        'description',
    ];

    /**
     * Get the request letter that owns the document.
     */
    public function requestLetter(): BelongsTo
    {
        return $this->belongsTo(RequestLetter::class);
    }
}
