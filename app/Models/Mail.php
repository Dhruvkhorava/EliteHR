<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'subject',
        'message',
        'is_read',
        'is_starred_sender',
        'is_starred_receiver',
        'is_draft',
        'is_trashed_sender',
        'is_trashed_receiver',
        'read_at',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function scopeInbox($query, $userId)
    {
        return $query->where('receiver_id', $userId)
            ->where('is_draft', false)
            ->where('is_trashed_receiver', false);
    }

    public function scopeSent($query, $userId)
    {
        return $query->where('sender_id', $userId)
            ->where('is_draft', false)
            ->where('is_trashed_sender', false);
    }

    public function scopeDrafts($query, $userId)
    {
        return $query->where('sender_id', $userId)
            ->where('is_draft', true)
            ->where('is_trashed_sender', false);
    }

    public function scopeTrash($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('sender_id', $userId)->where('is_trashed_sender', true);
        })->orWhere(function ($q) use ($userId) {
            $q->where('receiver_id', $userId)->where('is_trashed_receiver', true);
        });
    }
}
