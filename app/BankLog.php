<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelScopes;

class BankLog extends Model
{
    use SoftDeletes;
    use ModelScopes;

    /* Bank Log Status */
    const BANK_LOG_ST_SUCCESS   = 1;
    const BANK_LOG_ST_FAILED    = 2;
    
    protected $fillable = [
        'bank_username',
        'bank_account_number',
        'event',
        'url',
        'http_code',
        'response_code',
        'description',
        'status'
    ];

    protected $appends = [
        'statusName'
    ];

    public static function listStatus(){
        return [
            self::BANK_LOG_ST_SUCCESS   => 'Success',
            self::BANK_LOG_ST_FAILED    => 'Failed',
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
}
