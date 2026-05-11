<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $fillable = [
        'user_id',
        'shop_name',
        'slug',
        'whatsapp_number',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paymentRecords(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PaymentRecord::class);
    }
}