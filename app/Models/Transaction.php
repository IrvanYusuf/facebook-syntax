<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;


    protected $fillable = [
        'customer_id',
        'invoice_number',
        'status',
        'total',
        'transaction_date',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
            'transaction_date' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }
}
