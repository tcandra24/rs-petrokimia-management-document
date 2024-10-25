<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Memo extends Model
{
    use HasFactory;

    protected $fillable = [
        'counter',
        'number_transaction',
        'from_user_id',
        'to_user_id',
        'regarding',
        'content',
        'file',
        'qr_code_file',
        'approve_datetime'
    ];

    public function dispositions(): HasOne
    {
        return $this->hasOne(Disposition::class);
    }

    public function from_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id', 'id');
    }

    public function to_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id', 'id');
    }
}
