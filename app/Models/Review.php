<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'product_id', 'reviewer_name', 'reviewer_org', 'reviewer_email',
        'rating', 'review_text', 'status', 'ip_address', 'reviewed_at',
    ];

    protected $casts = [
        'rating'      => 'integer',
        'reviewed_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopePending($q)   { return $q->where('status', 'pending'); }
    public function scopeApproved($q)  { return $q->where('status', 'approved'); }
    public function scopeRejected($q)  { return $q->where('status', 'rejected'); }

    public function approve(): bool
    {
        return $this->update(['status' => 'approved', 'reviewed_at' => now()]);
    }

    public function reject(): bool
    {
        return $this->update(['status' => 'rejected', 'reviewed_at' => now()]);
    }
}
