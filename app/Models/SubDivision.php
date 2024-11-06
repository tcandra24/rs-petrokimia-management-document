<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SubDivision extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'division_id',
        'is_active'
    ];

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function dispositions(): BelongsToMany
    {
        return $this->belongsToMany(Disposition::class, 'sub_division_dispositions');
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucwords($value),
            set: fn(string $value) => strtolower($value)
        );
    }
}
