<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class PreMemo extends Model
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
        'status',
        'note',
        'approve_by',
        'qr_code_file',
        'approve_datetime'
    ];

    public function memo(): HasOne
    {
        return $this->hasOne(Memo::class);
    }

    public function from_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id', 'id');
    }

    public function to_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id', 'id');
    }

    public function status(): Attribute
    {
        return Attribute::make(
            get: function(string $value){
                if($value === 'approve') {
                    return 'Disetujui';
                } elseif($value === 'reject') {
                    return 'Ditolak';
                } else {
                    return 'Dibuat';
                }
            },
        );
    }

    public function approveBy(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucwords($value),
            set: fn(string $value) => strtolower($value)
        );
    }
}
