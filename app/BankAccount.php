<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelScopes;

class BankAccount extends Model
{
    use ModelScopes;
    use SoftDeletes;

    /* Bank Accounts Type */
    const BANK_ACC_TY_ALL   = 1;
    const BANK_ACC_TY_SAL   = 2;
    const BANK_ACC_TY_MUT   = 3;

    /* Bank Accounts Status Daily Run */
    const BANK_ACC_ST_DAILY_ACTIVE      = 1;
    const BANK_ACC_ST_DAILY_INACTIVE    = 2;

    /* Bank Accounts Status */
    const BANK_ACC_ST_ACTIVE      = 1;
    const BANK_ACC_ST_INACTIVE    = 2;

    protected $fillable = [
        'number', 
        'name', 
        'type',
        'bank_user_id',
        'saldo',
        'delay_job_minutes',
        'daily_job_status',
        'telegram_id',
        'status',
    ];

    protected $appends = [
        'typeName', 'dailyStatus', 'statusName',
    ];

    public static function lists($attr='name') {
        $lists = BankAccount::where(['status' => 1])
                    ->orderBy($attr)
                    ->pluck( $attr, 'id' );

        return $lists;
    }

    public static function listType(){
        return [
            self::BANK_ACC_TY_ALL   => 'All',
            self::BANK_ACC_TY_SAL   => 'Cek Saldo',
            self::BANK_ACC_TY_MUT   => 'Ambil Mutasi Transaksi',
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

    public static function listDailyStatus(){
        return [
            self::BANK_ACC_ST_DAILY_INACTIVE    => 'Inactive',
            self::BANK_ACC_ST_DAILY_ACTIVE      => 'Active',
        ];
    }

    public function getDailyStatusAttribute(){
        $value = '';
        foreach (self::listDailyStatus() as $key => $type) {
            if($this->type == $key){
                return $type;
            }
        }
        return $value;
    }

    public static function listStatus(){
        return [
            self::BANK_ACC_ST_DAILY_INACTIVE    => 'Inactive',
            self::BANK_ACC_ST_DAILY_ACTIVE      => 'Active',
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

    public function bankUser(){
        return $this->belongsTo('App\BankUser');
    }

    public function bank(){
        return $this->hasOneThrough('App\Bank', 'App\BankUser', 'id', 'id', 'bank_user_id', 'bank_id');
    }
}
