<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Disposition extends Model
{
    use HasFactory;

    protected $fillable = [
        'counter',
        'memo_id',
        'number_transaction',
        'committee',
        'is_urgent',
        'note',
        'file',
        'status',
        'qr_code_file',
        'approve_datetime',
        'approve_by'
    ];

    public function memo(): BelongsTo
    {
        return $this->belongsTo(Memo::class);
    }

    public function sub_divisions(): BelongsToMany
    {
        return $this->belongsToMany(SubDivision::class, 'sub_division_dispositions');
    }

    public function instructions(): BelongsToMany
    {
        return $this->belongsToMany(Instruction::class, 'instruction_dispositions');
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

    public function committee(): Attribute
    {
        return Attribute::make(
            get: function(string $value){
                if($value === 'medic') {
                    return 'Medik';
                } elseif($value === 'nursing') {
                    return 'Keperawatan';
                } else {
                    return '';
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
