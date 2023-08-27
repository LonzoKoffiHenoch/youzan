<?php

namespace App\Models;

use App\Enums\TypeTransaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $casts = [
        "type" => TypeTransaction::class,
        "amount" => "decimal"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
