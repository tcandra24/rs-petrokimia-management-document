<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDivisionDisposition extends Model
{
    use HasFactory;
    public $table = 'sub_division_dispositions';

    protected $fillable = [
        'disposition_id',
        'sub_division_id'
    ];

}
