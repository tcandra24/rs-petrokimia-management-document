<?php

namespace App\Traits\Disposition;

use Carbon\Carbon;
use Illuminate\Support\Str;

trait TransactionNumberTrait
{
    public function generateNumber($counter, $memo = null)
    {
        $now = Carbon::now();

        if(isset($memo)){
            $length = 5;
            $random = '';
            for ($i = 0; $i < $length; $i++) {
                $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
            }

            return $counter . '/TEMP/' . Str::upper($random) . '/' . str_pad($now->month, 2, '0', STR_PAD_LEFT) . '/' . $now->year;
        } else {
           return $counter . '/' . str_pad($now->month, 2, '0', STR_PAD_LEFT) . '/SEKRE/' . $now->year;
        }


    }
}
