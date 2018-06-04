<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    const TRANSFER_STATUS_SUCCEEDED = 'succeeded';

    const TRANSFER_TYPE_TRANSFER = 'transfer';
    const TRANSFER_TYPE_REVERSE = 'reverse';
    const TRANSFER_TYPE_MONEY_IN = 'money_in';
    const TRANSFER_TYPE_MONEY_OUT = 'money_out';


    public static function convertSum($amount, $toDbValues = true)
    {
        return ($toDbValues) ? (int)((float)$amount * 100) : (int)$amount / 100;
    }
    
    public function getAmount()
    {
        return self::convertSum($this->amount, false);
    }

}
