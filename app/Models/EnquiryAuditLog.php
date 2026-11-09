<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnquiryAuditLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_enquiry_id',
        'action',
        'context',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'context' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function productEnquiry(): BelongsTo
    {
        return $this->belongsTo(ProductEnquiry::class);
    }
}
