<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisionDisposition extends Model
{
    use HasFactory;
    public $table = 'division_dispositions';

    protected $fillable = [
        'disposition_id',
        'division_id'
    ];
}
