<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_transaction',
        'from_user_id',
        'to_user_id',
        'regarding',
        'content',
        'file'
    ];
}
