<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructionDisposition extends Model
{
    use HasFactory;
    public $table = 'instruction_dispositions';

    protected $fillable = [
        'disposition_id',
        'instruction_id'
    ];
}
