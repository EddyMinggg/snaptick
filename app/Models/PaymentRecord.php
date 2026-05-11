<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentRecord extends Model
{
    protected $fillable = [
        'merchant_id',
        'customer_identifier',
        'amount',
        'screenshot_path',
        'status',
    ];

    public function merchant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }
}