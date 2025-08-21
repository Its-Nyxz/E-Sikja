<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryRequestLetter extends Model
{
    protected $fillable = [
        'request_letter_id',
        'status',
        'notes'
    ];

    /**
     * Get the request letter that owns the history.
     */
    public function requestLetter(): BelongsTo
    {
        return $this->belongsTo(RequestLetter::class);
    }
}
