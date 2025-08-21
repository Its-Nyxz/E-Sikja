<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Notification extends Model
{
    protected $fillable = [
        'type',
        'title',
        'text',
        'link',
        'read',
        'user_id'
    ];

    protected $casts = [
        'read' => 'boolean',
    ];

    /**
     * Get the user that owns the notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark the notification as read.
     */
    public function markAsRead(): bool
    {
        return $this->update([
            'read' => true
        ]);
    }

    /**
     * Mark the notification as unread.
     */
    public function markAsUnread(): bool
    {
        return $this->update([
            'read' => false
        ]);
    }

    /**
     * Scope a query to only include unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }

    /**
     * Scope a query to only include read notifications.
     */
    public function scopeRead($query)
    {
        return $query->where('read', true);
    }

    /**
     * Scope a query to filter by notification type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', 'LIKE', '%' . $type . '%');
    }

    /**
     * Check if the notification is unread.
     */
    public function isUnread(): bool
    {
        return !$this->read;
    }

    /**
     * Check if the notification is read.
     */
    public function isRead(): bool
    {
        return $this->read;
    }

    /**
     * Get the time elapsed since the notification was created.
     */
    public function getTimeElapsedAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get the time when the notification was read.
     */
    public function getReadAtAttribute(): ?Carbon
    {
        return $this->read ? $this->updated_at : null;
    }
}
