<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'message',
        'ip_address', 'user_agent', 'is_read', 'replied_at', 'reply_content',
    ];

    protected $casts = [
        'is_read'    => 'boolean',
        'replied_at' => 'datetime',
    ];

    public function scopeUnread($q)  { return $q->where('is_read', false); }
    public function scopeRead($q)    { return $q->where('is_read', true); }

    public function markAsRead(): bool
    {
        return $this->is_read ? true : $this->update(['is_read' => true]);
    }
}
