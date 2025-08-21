<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RequestLetter extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'request_type_id',
        'user_id',
        'code',
        'document_number',
        'data',
        'status'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    /**
     * Get the request type that owns the request letter.
     */
    public function requestType(): BelongsTo
    {
        return $this->belongsTo(RequestType::class);
    }

    /**
     * Get the user that owns the request letter.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the documents that belong to the request letter.
     */
    public function documentRequestLetters(): HasMany
    {
        return $this->hasMany(DocumentRequestLetter::class, 'request_letter_id', 'id');
    }

    
    /**
     * Get the histories that belong to the request letter.
     */
    public function historyRequestLetters(): HasMany
    {
        return $this->hasMany(HistoryRequestLetter::class, 'request_letter_id', 'id');
    }

}

