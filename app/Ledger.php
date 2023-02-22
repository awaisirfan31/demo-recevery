<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    public static function invoice_id()
    {
        return 145236;
    }

    public static function sum_otc()
    {
        return Ledger::sum('otc');
    }
}
