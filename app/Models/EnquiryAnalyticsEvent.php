<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnquiryAnalyticsEvent extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_enquiry_id',
        'product_id',
        'event_type',
        'occurred_at',
    ];

    protected function casts(): array
    {
        return [
            'product_id' => 'integer',
            'occurred_at' => 'datetime',
        ];
    }

    public function productEnquiry(): BelongsTo
    {
        return $this->belongsTo(ProductEnquiry::class);
    }
}
