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


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'customer_id', 'amount', 'status', 'currency_id'];

    const TRANSFER_STATUS_SUCCEEDED = 'succeeded';

    const TRANSFER_TYPE_TRANSFER = 'transfer';
    const TRANSFER_TYPE_REVERSE = 'reverse';

    public static function convertSum($amount, $toDbValues = true)
    {
        return ($toDbValues) ? (int)((float)$amount * 100) : (int)$amount / 100;
    }
    
    public function getAmount()
    {
        return self::convertSum($this->amount, false);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id')->withTrashed();
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id')->withTrashed();
    }


}
