<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductEnquiry extends Model
{
    protected $fillable = [
        'product_id',
        'reference',
        'name',
        'email',
        'phone',
        'message',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'product_id' => 'integer',
        ];
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(EnquiryAuditLog::class);
    }

    public function analyticsEvents(): HasMany
    {
        return $this->hasMany(EnquiryAnalyticsEvent::class);
    }
}
