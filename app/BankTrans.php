<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelScopes;

class BankTrans extends Model
{
    use ModelScopes;
    use SoftDeletes;

    /* Bank Trans Type */
    const BANK_TRANS_TY_DB   = 1;
    const BANK_TRANS_TY_CR   = 2;

    /* Bank Trans Status */
    const BANK_TRANS_ST_ACTIVE      = 1;
    const BANK_TRANS_ST_INACTIVE    = 2;

    // protected $table = 'bank_trans';
    
    protected $fillable = [
        'trans_id',
        'trans_time',
        'bank_account_id',
        'bank_trans_group_id',
        'refference',
        'description',
        'type',
        'amount',
        'status',
        'user_id'
    ];

    protected $appends = [
        'typeName', 'statusName', 'amountFormat'
    ];

    public static function listType(){
        return [
            self::BANK_TRANS_TY_DB   => 'Debit',
            self::BANK_TRANS_TY_CR   => 'Credit',
        ];
    }

    public function getTypeNameAttribute(){
        $value = '';
        foreach (self::listType() as $key => $type) {
            if($this->type == $key){
                return $type;
            }
        }
        return $value;
    }

    public static function listStatus(){
        return [
            self::BANK_TRANS_ST_INACTIVE    => 'Inactive',
            self::BANK_TRANS_ST_ACTIVE      => 'Active',
        ];
    }

    public function getStatusNameAttribute(){
        $value = '';
        foreach (self::listStatus() as $key => $type) {
            if($this->status == $key){
                return $type;
            }
        }
        return $value;
    }

    public function bankAccount(){
        return $this->belongsTo('App\BankAccount');
    }

    public function getAmountFormatAttribute(){
        return number_format($this->amount, 0);
    }
}
